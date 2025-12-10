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

        if ($user->points <= 0) {
            return back()->with('error', 'Poin kamu habis, silakan topup dulu.');
        }

        return DB::transaction(function () use ($user, $data) {
            $user->decrement('points');

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

    public function edit(HtmlGeneration $generation)
    {
        $this->authorizeView($generation);

        $assets = HtmlAsset::forLibrary($generation->library)->get();

        $headCss = $assets->where('type', 'css')->where('position', 'head')->values();
        $headJs = $assets->where('type', 'js')->where('position', 'head')->values();
        $bodyJs = $assets->where('type', 'js')->where('position', 'body_end')->values();

        return view('generations.edit', [
            'generation' => $generation,
            'headCss' => $headCss,
            'headJs' => $headJs,
            'bodyJs' => $bodyJs,
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

        return back()->with('status', 'Perubahan tersimpan.');
    }

    public function preview(HtmlGeneration $generation)
    {
        $this->authorizeView($generation);

        $library = $generation->library;

        $assets = HtmlAsset::forLibrary($library)->get();

        $headCss = $assets->where('type', 'css')->where('position', 'head');
        $headJs = $assets->where('type', 'js')->where('position', 'head');
        $bodyJs = $assets->where('type', 'js')->where('position', 'body_end');

        return response()->view('generations.preview', [
            'title' => $generation->title,
            'html' => $generation->html_full ?? '',
            'css' => $generation->css_raw ?? '',
            'js' => $generation->js_raw ?? '',
            'library' => $library,
            'headCss' => $headCss,
            'headJs' => $headJs,
            'bodyJs' => $bodyJs,
        ]);
    }

    protected function authorizeView(HtmlGeneration $generation): void
    {
        if ($generation->user_id !== Auth::id()) {
            abort(403);
        }
    }
}

