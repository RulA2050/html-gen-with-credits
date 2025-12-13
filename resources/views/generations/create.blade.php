@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">
    {{-- Header Section --}}
    <div class="mb-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-white flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center shadow-lg shadow-blue-500/25">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    Generate HTML Baru
                </h1>
                <p class="text-slate-400 text-sm mt-2">Buat halaman HTML yang menarik dengan AI</p>
            </div>
            <a href="{{ route('generations.index') }}" class="flex items-center gap-2 px-4 py-2 rounded-lg bg-slate-800/50 hover:bg-slate-700/50 border border-slate-700/50 text-sm text-slate-300 transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>

        {{-- Points Badge --}}
        <div class="inline-flex items-center gap-3 px-4 py-2 rounded-xl bg-gradient-to-r from-blue-500/10 to-purple-500/10 border border-blue-500/20 backdrop-blur-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
            </svg>
            <div>
                <p class="text-xs text-slate-400">Poin tersedia</p>
                <p class="text-lg font-bold text-white">{{ number_format(auth()->user()->points) }}</p>
            </div>
        </div>
    </div>

    <form action="{{ route('generations.store') }}" method="POST" class="space-y-6" x-data="htmlGenerator()">
        @csrf

        {{-- Basic Information Card --}}
        <div class="bg-slate-800/50 backdrop-blur-sm rounded-2xl border border-slate-700/50 shadow-xl p-6">
            <h2 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-blue-500/20 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                Informasi Dasar
            </h2>

            <div class="grid md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-slate-300" for="title">Judul Halaman</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <input
                            type="text"
                            id="title"
                            name="title"
                            value="{{ old('title') }}"
                            class="w-full pl-10 pr-3 py-3 bg-slate-900/50 border border-slate-600 rounded-xl text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all text-white placeholder-slate-500"
                            placeholder="Landing Page Produk X"
                            x-model="title">
                    </div>
                    @error('title')
                        <p class="text-xs text-red-400 flex items-center gap-1 mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-slate-300" for="library">Library</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                            </svg>
                        </div>
                        <select
                            id="library"
                            name="library"
                            class="w-full pl-10 pr-10 py-3 bg-slate-900/50 border border-slate-600 rounded-xl text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all appearance-none text-white"
                            x-model="library">
                            <option value="bootstrap" @selected(old('library') === 'bootstrap')>Bootstrap 5</option>
                            <option value="tailwind" @selected(old('library') === 'tailwind')>TailwindCSS</option>
                            <option value="pure" @selected(old('library') === 'pure')>Pure CSS</option>
                            <option value="custom" @selected(old('library') === 'custom')>Custom</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                    @error('library')
                        <p class="text-xs text-red-400 flex items-center gap-1 mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Target & Use Case Card --}}
        <div class="bg-slate-800/50 backdrop-blur-sm rounded-2xl border border-slate-700/50 shadow-xl p-6">
            <h2 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-purple-500/20 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                Target & Use Case
            </h2>

            <div class="grid md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-slate-300" for="use_case">Jenis / Use Case</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                        </div>
                        <input
                            type="text"
                            id="use_case"
                            name="use_case"
                            value="{{ old('use_case') }}"
                            class="w-full pl-10 pr-3 py-3 bg-slate-900/50 border border-slate-600 rounded-xl text-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition-all text-white placeholder-slate-500"
                            placeholder="Landing page SaaS, portfolio, profile bisnis, dsb"
                            x-model="useCase">
                    </div>
                    @error('use_case')
                        <p class="text-xs text-red-400 flex items-center gap-1 mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-slate-300" for="target_audience">Target Audience</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <input
                            type="text"
                            id="target_audience"
                            name="target_audience"
                            value="{{ old('target_audience') }}"
                            class="w-full pl-10 pr-3 py-3 bg-slate-900/50 border border-slate-600 rounded-xl text-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition-all text-white placeholder-slate-500"
                            placeholder="Anak muda, UMKM, corporate, dll"
                            x-model="targetAudience">
                    </div>
                    @error('target_audience')
                        <p class="text-xs text-red-400 flex items-center gap-1 mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Design Preferences Card --}}
        <div class="bg-slate-800/50 backdrop-blur-sm rounded-2xl border border-slate-700/50 shadow-xl p-6">
            <h2 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-green-500/20 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                    </svg>
                </div>
                Preferensi Desain
            </h2>

            <div class="grid md:grid-cols-3 gap-6">
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-slate-300" for="tone">Tone</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                            </svg>
                        </div>
                        <input
                            type="text"
                            id="tone"
                            name="tone"
                            value="{{ old('tone', 'casual, modern') }}"
                            class="w-full pl-10 pr-3 py-3 bg-slate-900/50 border border-slate-600 rounded-xl text-sm focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all text-white placeholder-slate-500"
                            x-model="tone">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-slate-300" for="layout">Preferensi Layout</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                            </svg>
                        </div>
                        <input
                            type="text"
                            id="layout"
                            name="layout"
                            value="{{ old('layout', 'hero + 3 section, CTA di atas, footer simpel') }}"
                            class="w-full pl-10 pr-3 py-3 bg-slate-900/50 border border-slate-600 rounded-xl text-sm focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all text-white placeholder-slate-500"
                            x-model="layout">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-slate-300">Warna</label>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs text-slate-400 mb-1" for="primary_color">Primary</label>
                            <div class="relative">
                                <input
                                    type="color"
                                    id="primary_color"
                                    name="primary_color"
                                    value="{{ old('primary_color', '#f97316') }}"
                                    class="h-10 w-full rounded-lg border border-slate-600 bg-slate-900/50 cursor-pointer"
                                    x-model="primaryColor">
                                <div class="absolute inset-y-0 right-0 pr-2 flex items-center pointer-events-none">
                                    <span class="text-xs text-slate-400 font-mono" x-text="primaryColor"></span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs text-slate-400 mb-1" for="secondary_color">Secondary</label>
                            <div class="relative">
                                <input
                                    type="color"
                                    id="secondary_color"
                                    name="secondary_color"
                                    value="{{ old('secondary_color', '#0f172a') }}"
                                    class="h-10 w-full rounded-lg border border-slate-600 bg-slate-900/50 cursor-pointer"
                                    x-model="secondaryColor">
                                <div class="absolute inset-y-0 right-0 pr-2 flex items-center pointer-events-none">
                                    <span class="text-xs text-slate-400 font-mono" x-text="secondaryColor"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Color Preview --}}
                    <div class="mt-3 p-3 rounded-lg bg-slate-900/50 border border-slate-700">
                        <p class="text-xs text-slate-400 mb-2">Preview</p>
                        <div class="flex gap-2 mb-2">
                            <div class="w-8 h-8 rounded-md shadow-sm" :style="`background-color: ${primaryColor}`"></div>
                            <div class="w-8 h-8 rounded-md shadow-sm" :style="`background-color: ${secondaryColor}`"></div>
                        </div>
                        <div class="h-6 rounded" :style="`background: linear-gradient(to right, ${primaryColor}, ${secondaryColor})`"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Brand Information Card --}}
        <div class="bg-slate-800/50 backdrop-blur-sm rounded-2xl border border-slate-700/50 shadow-xl p-6">
            <h2 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-yellow-500/20 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                Informasi Brand
            </h2>

            <div class="grid md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-slate-300" for="brand_name">Nama Brand</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                            </svg>
                        </div>
                        <input
                            type="text"
                            id="brand_name"
                            name="brand_name"
                            value="{{ old('brand_name') }}"
                            class="w-full pl-10 pr-3 py-3 bg-slate-900/50 border border-slate-600 rounded-xl text-sm focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500/20 transition-all text-white placeholder-slate-500"
                            placeholder="Nama brand Anda"
                            x-model="brandName">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-slate-300" for="brand_slogan">Tagline / Slogan</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 16h4m10 0h4" />
                            </svg>
                        </div>
                        <input
                            type="text"
                            id="brand_slogan"
                            name="brand_slogan"
                            value="{{ old('brand_slogan') }}"
                            class="w-full pl-10 pr-3 py-3 bg-slate-900/50 border border-slate-600 rounded-xl text-sm focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500/20 transition-all text-white placeholder-slate-500"
                            placeholder="Slogan brand Anda"
                            x-model="brandSlogan">
                    </div>
                </div>
            </div>
        </div>

        {{-- CTA Card --}}
        <div class="bg-slate-800/50 backdrop-blur-sm rounded-2xl border border-slate-700/50 shadow-xl p-6">
            <h2 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-red-500/20 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                    </svg>
                </div>
                Call to Action
            </h2>

            <div class="grid md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-slate-300" for="cta_text">CTA Text</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                        <input
                            type="text"
                            id="cta_text"
                            name="cta_text"
                            value="{{ old('cta_text', 'Mulai Sekarang') }}"
                            class="w-full pl-10 pr-3 py-3 bg-slate-900/50 border border-slate-600 rounded-xl text-sm focus:border-red-500 focus:ring-2 focus:ring-red-500/20 transition-all text-white placeholder-slate-500"
                            placeholder="Teks tombol CTA"
                            x-model="ctaText">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-slate-300" for="cta_url">CTA URL</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                            </svg>
                        </div>
                        <input
                            type="url"
                            id="cta_url"
                            name="cta_url"
                            value="{{ old('cta_url') }}"
                            class="w-full pl-10 pr-3 py-3 bg-slate-900/50 border border-slate-600 rounded-xl text-sm focus:border-red-500 focus:ring-2 focus:ring-red-500/20 transition-all text-white placeholder-slate-500"
                            placeholder="https://..."
                            x-model="ctaUrl">
                    </div>
                </div>
            </div>

            {{-- CTA Preview --}}
            <div class="mt-4 p-4 rounded-lg bg-slate-900/50 border border-slate-700">
                <p class="text-xs text-slate-400 mb-2">Preview</p>
                <button class="px-4 py-2 rounded-lg text-white font-medium text-sm transition-all" :style="`background-color: ${primaryColor}`" x-text="ctaText || 'Mulai Sekarang'"></button>
            </div>
        </div>

        {{-- Additional Prompt Card --}}
        <div class="bg-slate-800/50 backdrop-blur-sm rounded-2xl border border-slate-700/50 shadow-xl p-6">
            <h2 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-indigo-500/20 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                Prompt Tambahan (opsional)
            </h2>

            <div class="space-y-2">
                <textarea
                    id="extra_prompt"
                    name="extra_prompt"
                    rows="4"
                    class="w-full bg-slate-900/50 border border-slate-600 rounded-xl text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all p-3 text-white placeholder-slate-500"
                    placeholder="Instruksi detail tambahan, misal: fokus pada hero yang kuat, gunakan card layout untuk fitur, hindari tampilan generik, dll."
                    x-model="extraPrompt">{{ old('extra_prompt') }}</textarea>
                <p class="text-xs text-slate-500">Berikan instruksi spesifik untuk hasil yang lebih baik</p>
            </div>
        </div>

        {{-- Submit Section --}}
        <div class="flex items-center justify-between bg-slate-800/30 backdrop-blur-sm rounded-2xl border border-slate-700/30 p-6">
            <div class="text-sm text-slate-400">
                <p>Perkiraan poin yang akan digunakan: <span class="text-white font-medium">3 poin</span></p>
            </div>

            <button
                type="submit"
                class="px-6 py-3 rounded-xl bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-medium shadow-lg shadow-blue-500/25 transition-all duration-200 transform hover:scale-[1.02] flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                Kirim ke AI
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('htmlGenerator', () => ({
        title: '{{ old('title') }}',
        library: '{{ old('library', 'bootstrap') }}',
        useCase: '{{ old('use_case') }}',
        targetAudience: '{{ old('target_audience') }}',
        tone: '{{ old('tone', 'casual, modern') }}',
        layout: '{{ old('layout', 'hero + 3 section, CTA di atas, footer simpel') }}',
        primaryColor: '{{ old('primary_color', '#f97316') }}',
        secondaryColor: '{{ old('secondary_color', '#0f172a') }}',
        brandName: '{{ old('brand_name') }}',
        brandSlogan: '{{ old('brand_slogan') }}',
        ctaText: '{{ old('cta_text', 'Mulai Sekarang') }}',
        ctaUrl: '{{ old('cta_url') }}',
        extraPrompt: '{{ old('extra_prompt') }}'
    }));
});
</script>
@endsection
