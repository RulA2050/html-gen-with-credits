@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-semibold">Generate HTML Baru</h1>
            <p class="text-sm text-slate-400 mt-1">
                Poin tersedia:
                <span class="text-primary font-medium">{{ auth()->user()->points }}</span>
            </p>
        </div>
        <a href="{{ route('generations.index') }}" class="text-xs text-slate-400 hover:text-primary">
            Kembali
        </a>
    </div>

    <form action="{{ route('generations.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm mb-1" for="title">Judul Halaman</label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    value="{{ old('title') }}"
                    class="w-full rounded-md border border-slate-700 bg-slate-900 text-sm focus:border-primary focus:ring-primary"
                    placeholder="Landing Page Produk X">
                @error('title')
                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm mb-1" for="library">Library</label>
                <select
                    id="library"
                    name="library"
                    class="w-full rounded-md border border-slate-700 bg-slate-900 text-sm focus:border-primary focus:ring-primary">
                    <option value="bootstrap" @selected(old('library') === 'bootstrap')>Bootstrap 5</option>
                    <option value="tailwind" @selected(old('library') === 'tailwind')>TailwindCSS</option>
                    <option value="pure" @selected(old('library') === 'pure')>Pure CSS</option>
                    <option value="custom" @selected(old('library') === 'custom')>Custom</option>
                </select>
                @error('library')
                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm mb-1" for="use_case">Jenis / Use Case</label>
                <input
                    type="text"
                    id="use_case"
                    name="use_case"
                    value="{{ old('use_case') }}"
                    class="w-full rounded-md border border-slate-700 bg-slate-900 text-sm focus:border-primary focus:ring-primary"
                    placeholder="Landing page SaaS, portfolio, profile bisnis, dsb">
                @error('use_case')
                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm mb-1" for="target_audience">Target Audience</label>
                <input
                    type="text"
                    id="target_audience"
                    name="target_audience"
                    value="{{ old('target_audience') }}"
                    class="w-full rounded-md border border-slate-700 bg-slate-900 text-sm focus:border-primary focus:ring-primary"
                    placeholder="Anak muda, UMKM, corporate, dll">
            </div>
        </div>

        <div class="grid md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm mb-1" for="tone">Tone</label>
                <input
                    type="text"
                    id="tone"
                    name="tone"
                    value="{{ old('tone', 'casual, modern') }}"
                    class="w-full rounded-md border border-slate-700 bg-slate-900 text-sm focus:border-primary focus:ring-primary">
            </div>
            <div>
                <label class="block text-sm mb-1" for="layout">Preferensi Layout</label>
                <input
                    type="text"
                    id="layout"
                    name="layout"
                    value="{{ old('layout', 'hero + 3 section, CTA di atas, footer simpel') }}"
                    class="w-full rounded-md border border-slate-700 bg-slate-900 text-sm focus:border-primary focus:ring-primary">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs mb-1" for="primary_color">Primary</label>
                    <input
                        type="color"
                        id="primary_color"
                        name="primary_color"
                        value="{{ old('primary_color', '#f97316') }}"
                        class="h-9 w-full rounded-md border border-slate-700 bg-slate-900">
                </div>
                <div>
                    <label class="block text-xs mb-1" for="secondary_color">Secondary</label>
                    <input
                        type="color"
                        id="secondary_color"
                        name="secondary_color"
                        value="{{ old('secondary_color', '#0f172a') }}"
                        class="h-9 w-full rounded-md border border-slate-700 bg-slate-900">
                </div>
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm mb-1" for="brand_name">Nama Brand</label>
                <input
                    type="text"
                    id="brand_name"
                    name="brand_name"
                    value="{{ old('brand_name') }}"
                    class="w-full rounded-md border border-slate-700 bg-slate-900 text-sm focus:border-primary focus:ring-primary">
            </div>
            <div>
                <label class="block text-sm mb-1" for="brand_slogan">Tagline / Slogan</label>
                <input
                    type="text"
                    id="brand_slogan"
                    name="brand_slogan"
                    value="{{ old('brand_slogan') }}"
                    class="w-full rounded-md border border-slate-700 bg-slate-900 text-sm focus:border-primary focus:ring-primary">
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm mb-1" for="cta_text">CTA Text</label>
                <input
                    type="text"
                    id="cta_text"
                    name="cta_text"
                    value="{{ old('cta_text', 'Mulai Sekarang') }}"
                    class="w-full rounded-md border border-slate-700 bg-slate-900 text-sm focus:border-primary focus:ring-primary">
            </div>
            <div>
                <label class="block text-sm mb-1" for="cta_url">CTA URL</label>
                <input
                    type="url"
                    id="cta_url"
                    name="cta_url"
                    value="{{ old('cta_url') }}"
                    class="w-full rounded-md border border-slate-700 bg-slate-900 text-sm focus:border-primary focus:ring-primary"
                    placeholder="https://...">
            </div>
        </div>

        <div>
            <label class="block text-sm mb-1" for="extra_prompt">Prompt Tambahan (opsional)</label>
            <textarea
                id="extra_prompt"
                name="extra_prompt"
                rows="4"
                class="w-full rounded-md border border-slate-700 bg-slate-900 text-sm focus:border-primary focus:ring-primary"
                placeholder="Instruksi detail tambahan, misal: fokus pada hero yang kuat, gunakan card layout untuk fitur, hindari tampilan generik, dll.">{{ old('extra_prompt') }}</textarea>
        </div>

        <div class="flex justify-end">
            <button
                type="submit"
                class="px-5 py-2.5 rounded-md bg-primary hover:bg-primary-dark text-sm font-medium transition">
                Kirim ke AI
            </button>
        </div>
    </form>
</div>
@endsection
