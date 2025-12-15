<?php

namespace App\Http\Controllers;

use App\Jobs\GenerateHtmlJob;
use App\Models\HtmlGeneration;
use App\Models\HtmlAsset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HtmlGenerationController extends Controller
{
    public function index()
    {
        $generations = Auth::user()
            ->generations()
            ->with('publishHtml')
            ->latest()
            ->paginate(10);

        return view('generations.index', compact('generations'));
    }

    public function create()
    {
        return view('generations.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:150',
            'library' => 'required|in:bootstrap,tailwind,pure,custom',
            'use_case' => 'required|string',
            'target_audience' => 'nullable|string',
            'tone' => 'nullable|string',
            'layout' => 'nullable|string',
            'primary_color' => 'nullable|string',
            'secondary_color' => 'nullable|string',
            'brand_name' => 'nullable|string',
            'brand_slogan' => 'nullable|string',
            'cta_text' => 'nullable|string',
            'cta_url' => 'nullable|url',
            'extra_prompt' => 'nullable|string',
        ]);

        $user = Auth::user();

        if ($user->points <= 0 || ($user->points - 3) < 0 ) {
            return back()->with('error', 'Poin kamu habis, silakan topup dulu.');
        }
        

        return DB::transaction(function () use ($user, $data) {
            $user->decrement('points', 3);

            $formPayload = [
                'use_case' => $data['use_case'],
                'target_audience' => $data['target_audience'] ?? null,
                'tone' => $data['tone'] ?? null,
                'layout' => $data['layout'] ?? null,
                'primary_color' => $data['primary_color'] ?? '#f97316', // orange default
                'secondary_color' => $data['secondary_color'] ?? '#0f172a',
                'brand_name' => $data['brand_name'] ?? null,
                'brand_slogan' => $data['brand_slogan'] ?? null,
                'cta_text' => $data['cta_text'] ?? null,
                'cta_url' => $data['cta_url'] ?? null,
            ];

            $generation = HtmlGeneration::create([
                'user_id' => $user->id,
                'title' => $data['title'],
                'library' => $data['library'],
                'status' => 'WAITING',
                'form_payload' => $formPayload,
                'extra_prompt' => $data['extra_prompt'] ?? null,
            ]);

            GenerateHtmlJob::dispatch($generation->id);

            return redirect()
                ->route('generations.index')
                ->with('status', 'Permintaan generate dikirim ke AI. Tunggu sebentar lalu refresh.');
        });
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
    public function preview(HtmlGeneration $generation)
    {
        $this->authorizeView($generation);

        $assetGroups = $this->resolveAssets($generation);

        return response()->view('generations.preview', [
            'title' => $generation->title,
            'html' => $generation->html_full ?? '',
            'css' => $generation->css_raw ?? '',
            'js' => $generation->js_raw ?? '',
            'headCss' => $assetGroups['headCss'],
            'headJs' => $assetGroups['headJs'],
            'bodyJs' => $assetGroups['bodyJs'],
        ]);
    }

    public function edit(HtmlGeneration $generation)
    {
        $this->authorizeView($generation);

        $assetGroups = $this->resolveAssets($generation);

        $headCss = $assetGroups['headCss'];
        $headJs = $assetGroups['headJs'];
        $bodyJs = $assetGroups['bodyJs'];

        return view('generations.edit', [
            'generation' => $generation,
            'schema' => $generation->editor_schema['editableFields'] ?? [],
            'headCssUrls' => $headCss->pluck('url')->values()->all(),
            'headJsUrls' => $headJs->pluck('url')->values()->all(),
            'bodyJsUrls' => $bodyJs->pluck('url')->values()->all(),
            'activeAssetNames' => $headCss->pluck('name')
                ->merge($headJs->pluck('name'))
                ->merge($bodyJs->pluck('name'))
                ->unique()
                ->values()
                ->all(),
        ]);
    }



    public function update(Request $request, HtmlGeneration $generation)
    {
        $this->authorizeView($generation);

        $data = $request->validate([
            'html_full' => 'required|string',
            'css_raw' => 'nullable|string',
            'js_raw' => 'nullable|string',
        ]);

        $generation->update($data);

        return redirect()
            ->route('generations.edit', $generation)
            ->with('status', 'Halaman berhasil diperbarui.');
    }
    protected function authorizeView(HtmlGeneration $generation): void
    {
        if ($generation->user_id !== Auth::id()) {
            abort(403);
        }
    }
}

