<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PublishHtml;
use App\Models\HtmlGeneration;
use App\Models\HtmlAsset;
use Illuminate\Support\Facades\Auth;

use App\Jobs\PublishWebJob;
class PublishHtmlController extends Controller
{

    protected function limitDays(HtmlGeneration $htmlGeneration){
        $this->authorizeView($htmlGeneration);

        // Cek apakah sudah ada publish_html terkait
        $publishHtml = PublishHtml::where('html_generation_id', $htmlGeneration->id)->first();
        // Jika sudah ada cek kapan terakhir di edit / dibuat Rate Limit export (1x24 jam)
        if ($publishHtml) {
            $lastUpdated = $publishHtml->updated_at ?? $publishHtml->created_at;
            $hoursSinceUpdate = now()->diffInHours($lastUpdated);
            if ($hoursSinceUpdate < 24) {
                return false;
            }
        }
        return true;
    }

    protected function resolveAssets(HtmlGeneration $generation): array
    {
        $library = $generation->library ?? 'tailwind';
        $logicKeys = $generation->assets ?? [];

        // Default asset berdasarkan library (tailwind/bootstrap + global)
        $libraryAssets = HtmlAsset::forLibrary($library)->get();

        // Asset tambahan berdasarkan logical_key dari AI (fontawesome, swiper, dll)
        $logicalAssets = !empty($logicKeys)
            ? HtmlAsset::forLogicalKeys($logicKeys)->get()
            : collect();

        // Gabung, unique, sort sesuai sort_order
        $assets = $libraryAssets
            ->merge($logicalAssets)
            ->unique('id')
            ->sortBy('sort_order')
            ->values();

        return [
            'headCss' => $assets->where('type', 'css')->where('position', 'head')->values(),
            'headJs' => $assets->where('type', 'js')->where('position', 'head')->values(),
            'bodyJs' => $assets->where('type', 'js')->where('position', 'body_end')->values(),
        ];
    }


    protected function buildHTML(HtmlGeneration $generation){
        $htmlContent = $generation->html_full;
        $cssContent = $generation->css_raw;
        $jsContent = $generation->js_raw;
        // Assets
        $assetGroups = $this->resolveAssets($generation);

        $html = "<!DOCTYPE html>
        <html lang=\"en\">
        <head>
            <meta charset=\"UTF-8\">
            <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
            <title>{$generation->title}</title>";
        // Include Head CSS Assets
        foreach ($assetGroups['headCss'] as $cssAsset) {
            $html .= "<link rel=\"stylesheet\" href=\"{$cssAsset->url}\">";
        }
        // Include Head JS Assets
        foreach ($assetGroups['headJs'] as $jsAsset) {
            $html .= "<script src=\"{$jsAsset->url}\"></script>";
        }
        // Inline CSS
        if (!empty($cssContent)) {
            $html .= "<style>{$cssContent}</style>";
        }
        $html .= "</head>
        <body>
            {$htmlContent}";
        // Include Body JS Assets
        foreach ($assetGroups['bodyJs'] as $jsAsset) {
            $html .= "<script src=\"{$jsAsset->url}\"></script>";
        }
        // Inline JS
        if (!empty($jsContent)) {
            $html .= "<script>{$jsContent}</script>";
        }
        $html .= "
        </body>
        </html>";
        return $html;
    }

    protected function authorizeView(HtmlGeneration $generation): void
    {
        if ($generation->user_id !== Auth::id()) {
            abort(403);
        }
    }
    public function export(Request $request, HtmlGeneration $htmlGeneration)
    {

        $this->authorizeView($htmlGeneration);

        $limitDays = $this->limitDays($htmlGeneration);

        if (!$limitDays) {
            return back()->with('error', 'Anda hanya dapat mengekspor halaman ini sekali dalam 24 jam. Silakan coba lagi nanti.');
        }

        $fullContent = $this->buildHTML($htmlGeneration);
        PublishHtml::updateOrCreate(
            ['html_generation_id' => $htmlGeneration->id],
            [
                'title' => $htmlGeneration->title,
                'updated_at' => now(),
            ]
        );
        // Regex title jika adaspace pakai - atau _
        $title = preg_replace('/\s+/', '_', $htmlGeneration->title);
        return response($fullContent)
            ->header('Content-Type', 'text/html')
            ->header('Content-Disposition', "attachment; filename=\"$title.html\"");
    }



    public function publish(Request $request, HtmlGeneration $htmlGeneration)
    {
        $this->authorizeView($htmlGeneration);

        $limitDays = $this->limitDays($htmlGeneration);
        if (!$limitDays) {
            return back()->with('error', 'Anda hanya dapat mempublikasikan halaman ini sekali dalam 24 jam. Silakan coba lagi nanti.');
        }

        $slug = $request->input('slug');
        if($slug) {
            // Validasi slug: hanya huruf, angka, strip, dan underscore
            if (!preg_match('/^[a-zA-Z0-9_-]+$/', $slug)) {
                return back()->with('error', 'Slug hanya boleh mengandung huruf, angka, strip (-), dan underscore (_).');
            }
        }

        $fullUrl = "https://web.rula.id/{$slug}";
        $fullHtml = $this->buildHTML($htmlGeneration);
        PublishHtml::updateOrCreate(
            ['html_generation_id' => $htmlGeneration->id],
            [
                'title' => $htmlGeneration->title,
                'url' => $fullUrl,
                'status' => 'PENDING',
                'updated_at' => now(),
            ]
        );

        // Dispatch PublishWebJob
        PublishWebJob::dispatch($htmlGeneration->id, $fullUrl, $fullHtml);

        return back()->with('success', 'Proses publikasi telah dimulai. Silakan periksa status di halaman generasi Anda.');
    }

    public function viewPublishStatus(Request $request, HtmlGeneration $htmlGeneration)
    {
        $this->authorizeView($htmlGeneration);

        $publishHtml = PublishHtml::where('html_generation_id', $htmlGeneration->id)->first();
        if(!$publishHtml) {
            return back()->with('error', 'Tidak ada informasi publikasi untuk halaman ini.');
        }

        return view('generations.publish_status', [
            'publishHtml' => $publishHtml,
        ]);


    }

}
