<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PublishHtml;
use App\Models\HtmlGeneration;
use App\Models\HtmlAsset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class PublishHtmlController extends Controller
{

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

    protected function authorizeView(HtmlGeneration $generation): void
    {
        if ($generation->user_id !== Auth::id()) {
            abort(403);
        }
    }
    public function export(Request $request, HtmlGeneration $htmlGeneration)
    {
        $this->authorizeView($htmlGeneration);

        // // Cek apakah sudah ada publish_html terkait
        // $publishHtml = PublishHtml::where('html_generation_id', $htmlGeneration->id)->first();
        // // Jika sudah ada cek kapan terakhir di edit / dibuat Rate Limit export (1x24 jam)
        // if ($publishHtml) {
        //     $lastUpdated = $publishHtml->updated_at ?? $publishHtml->created_at;
        //     $hoursSinceUpdate = now()->diffInHours($lastUpdated);
        //     if ($hoursSinceUpdate < 24) {
        //         return back()->with('error', 'Anda hanya dapat mengekspor HTML sekali dalam 24 jam. Silakan coba lagi nanti.');
        //     }
        // }

        $htmlContent = $htmlGeneration->html_full;
        $cssContent = $htmlGeneration->css_raw;
        $jsContent = $htmlGeneration->js_raw;
        // Assets
        $assetGroups = $this->resolveAssets($htmlGeneration);

        $html = "<!DOCTYPE html>
        <html lang=\"en\">
        <head>
            <meta charset=\"UTF-8\">
            <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
            <title>{$htmlGeneration->title}</title>";
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

        $fullContent = $html;
        PublishHtml::updateOrCreate(
            ['html_generation_id' => $htmlGeneration->id],
            [
                'title' => $htmlGeneration->title,
                'url' => '#',
                'status' => 'EXPORTED',
                'updated_at' => now(),
            ]
        );
        // Regex title jika adaspace pakai - atau _
        $title = preg_replace('/\s+/', '_', $htmlGeneration->title);
        return response($fullContent)
            ->header('Content-Type', 'text/html')
            ->header('Content-Disposition', "attachment; filename=\"$title.html\"");
    }


}
