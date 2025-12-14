@extends('layouts.app')

@push('styles')
    {{-- Auto-refresh meta tag for loading states --}}
    @if(in_array($publishHtml->status, ['PENDING', 'PREPARING_PUBLISH']))
        <meta http-equiv="refresh" content="10">
    @endif
@endpush

@section('content')
<div class="max-w-4xl mx-auto">
    {{-- Header --}}
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-green-500/20 to-emerald-600/20 mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m9.032 4.026a9.001 9.001 0 01-7.432 0m9.032-4.026A9.001 9.001 0 0112 3c-4.474 0-8.268 2.943-9.543 7a9.97 9.97 0 011.827 3.342M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </div>
        <h1 class="text-3xl font-bold text-white mb-2">Status Publish</h1>
        <p class="text-slate-400">Pantau proses penerbitan halaman web Anda</p>
    </div>

    {{-- Status Card --}}
    <div class="bg-slate-800/50 backdrop-blur-sm rounded-2xl border border-slate-700/50 shadow-xl overflow-hidden">
        <div class="p-8">
            <div class="text-center">
                <h2 class="text-2xl font-semibold text-white mb-6">{{ $publishHtml->title }}</h2>

                {{-- Success State --}}
                @if ($publishHtml->status === 'PUBLISHED')
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-emerald-500/20 mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-emerald-400 text-lg font-medium mb-2">Berhasil Dipublish!</p>
                    <p class="text-slate-400 mb-8">Halaman Anda sudah online dan dapat diakses publik.</p>
                    <a href="https://web.ruxla.id/{{ \Str::afterLast($publishHtml->url, '/') }}" target="_blank"
                       class="inline-flex items-center gap-2 px-8 py-3 rounded-xl bg-gradient-to-br from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-medium shadow-lg shadow-green-500/25 transition-all duration-200 transform hover:scale-[1.02]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        Go to URL
                    </a>

                {{-- Pending / Preparing State --}}
                @elseif (in_array($publishHtml->status, ['PENDING', 'PREPARING_PUBLISH']))
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-blue-500/20 mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-blue-400 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </div>
                    <p class="text-blue-400 text-lg font-medium mb-2">Sedang Diproses</p>
                    <p class="text-slate-400 mb-2">Halaman Anda sedang disiapkan untuk diterbitkan.</p>
                    <p class="text-slate-500 text-sm mb-8">Halaman ini akan diperbarui secara otomatis. Silakan tunggu sebentar...</p>
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-slate-700/50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-slate-400 text-sm">Status saat ini: <span class="text-blue-400 font-medium">{{ $publishHtml->status }}</span></span>
                    </div>

                {{-- Other States (e.g., DRAFT, FAILED) --}}
                @else
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-slate-500/20 mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-slate-300 text-lg font-medium mb-2">Status: {{ $publishHtml->status }}</p>
                    <p class="text-slate-400 mb-8">Halaman sedang dalam status ini. Silakan periksa kembali nanti.</p>
                @endif
            </div>
        </div>

        <div class="px-8 py-4 border-t border-slate-700/50 bg-slate-900/30">
            <div class="flex items-center justify-between">
                <div class="text-sm text-slate-500">
                    ID Publish: #{{ $publishHtml->id }}
                </div>
                <a href="{{ route('generations.index') }}" class="text-sm text-blue-400 hover:text-blue-300 transition-colors">
                    ← Kembali ke Daftar Generate
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
