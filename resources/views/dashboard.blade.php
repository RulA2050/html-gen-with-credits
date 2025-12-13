@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    {{-- Header --}}
    <div class="mb-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-white flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-r from-orange-500 to-pink-600 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                    </div>
                    Dashboard
                </h1>
                <p class="text-slate-400 text-sm mt-2">Ringkasan Sistem & Aktivitas</p>
            </div>

            <div class="flex items-center gap-3">
                <div class="hidden sm:flex items-center gap-2 px-3 py-2 rounded-xl bg-emerald-500/10 border border-emerald-500/20 backdrop-blur-sm">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span class="text-sm text-emerald-300">Sistem Aktif</span>
                </div>

                {{-- Points Badge --}}
                <div class="flex items-center gap-2 px-3 py-2 rounded-xl bg-gradient-to-r from-orange-500/10 to-pink-500/10 border border-orange-500/20 backdrop-blur-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                    </svg>
                    <div>
                        <p class="text-xs text-slate-400">Poin tersedia</p>
                        <p class="text-sm font-bold text-white">{{ number_format(auth()->user()->points) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- TOP CARDS --}}
    <section class="mb-8">
        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
            {{-- Total User --}}
            <div class="bg-slate-800/50 backdrop-blur-sm rounded-2xl border border-slate-700/50 shadow-xl p-6">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Total Pengguna</p>
                        <p class="mt-2 text-2xl font-bold text-white">{{ number_format($totalUsers) }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-indigo-500/20 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <p class="text-xs text-slate-400">{{ number_format($verifiedUsers) }} user sudah verifikasi ({{ $conversionRate }})</p>
                    <span class="inline-flex items-center text-xs px-2 py-1 rounded-full bg-indigo-500/20 text-indigo-300 border border-indigo-500/30">
                        {{ $usersGrowthText }}
                    </span>
                </div>
            </div>

            {{-- Points System --}}
            <div class="bg-slate-800/50 backdrop-blur-sm rounded-2xl border border-slate-700/50 shadow-xl p-6">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Points System</p>
                        <p class="mt-2 text-2xl font-bold text-white">{{ number_format($totalPoints) }} pts</p>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-orange-500/20 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                        </svg>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <p class="text-xs text-slate-400">Akumulasi total points semua user</p>
                    <div class="text-right">
                        <p class="text-[11px] text-slate-500">User aktif points:</p>
                        <p class="text-sm font-semibold text-white">{{ number_format($activePointsUsers) }} user</p>
                    </div>
                </div>
            </div>

            {{-- Topup --}}
            <div class="bg-slate-800/50 backdrop-blur-sm rounded-2xl border border-slate-700/50 shadow-xl p-6">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Topup Points</p>
                        <p class="mt-2 text-2xl font-bold text-white">{{ number_format($topupPointsTotal) }} pts</p>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-emerald-500/20 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <p class="text-xs text-slate-400">{{ number_format($topupSuccess) }} success • {{ number_format($topupPending) }} pending • {{ number_format($topupFailed) }} failed</p>
                    <span class="inline-flex items-center text-xs px-2 py-1 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                        Success {{ $topupSuccessRate }}
                    </span>
                </div>
            </div>

            {{-- HTML Generation --}}
            <div class="bg-slate-800/50 backdrop-blur-sm rounded-2xl border border-slate-700/50 shadow-xl p-6">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">HTML Generated</p>
                        <p class="mt-2 text-2xl font-bold text-white">{{ number_format($totalGenerations) }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-amber-500/20 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                        </svg>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <p class="text-xs text-slate-400">{{ number_format($completedGenerations) }} punya HTML lengkap</p>
                    <span class="inline-flex items-center text-xs px-2 py-1 rounded-full bg-amber-500/20 text-amber-300 border border-amber-500/30">
                        Done {{ $generationSuccessRate }}
                    </span>
                </div>
            </div>
        </div>
    </section>

    {{-- RINGKASAN DATA (TABLE) --}}
    <section class="mb-8">
        <div class="bg-slate-800/50 backdrop-blur-sm rounded-2xl border border-slate-700/50 shadow-xl overflow-hidden">
            <div class="p-6 border-b border-slate-700/50">
                <h2 class="text-lg font-semibold text-white flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-pink-500/20 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-pink-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    Ringkasan Data Sistem
                </h2>
                <p class="text-xs text-slate-400 mt-1">Data dari model: User, TopupTransaction, HtmlGeneration, HtmlAsset</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-900/50 border-b border-slate-700/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">Resource</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">Hari Ini</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">7 Hari Terakhir</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">Rate</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700/50">
                        @foreach($resources as $resource)
                            <tr class="hover:bg-slate-700/30 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">
                                    {{ $resource['label'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-300">
                                    {{ number_format($resource['total']) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-300">
                                    {{ number_format($resource['today']) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-300">
                                    {{ number_format($resource['last7days']) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-300">
                                    {{ $resource['conversion'] ?? '—' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    {{-- ASSET BY LIBRARY + FAILED JOBS --}}
    <section class="mb-8">
        <div class="grid gap-6 lg:grid-cols-3">
            {{-- Assets --}}
            <div class="lg:col-span-2 bg-slate-800/50 backdrop-blur-sm rounded-2xl border border-slate-700/50 shadow-xl">
                <div class="p-6 border-b border-slate-700/50">
                    <h2 class="text-lg font-semibold text-white flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-cyan-500/20 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                        Assets per Library
                    </h2>
                    <p class="text-xs text-slate-400 mt-1">Total asset: {{ number_format($totalAssets) }} • Aktif: {{ number_format($activeAssets) }} ({{ $assetActiveRate }})</p>
                </div>

                <div class="p-6">
                    @if($assetsByLibrary->count())
                        <ul class="space-y-3">
                            @foreach($assetsByLibrary as $row)
                                <li class="flex items-center justify-between p-3 rounded-lg bg-slate-900/50 border border-slate-700/50">
                                    <span class="text-sm text-slate-300">{{ $row->library ?? 'unknown' }}</span>
                                    <span class="text-sm font-semibold text-white">{{ $row->total }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-sm text-slate-400">Belum ada asset tersimpan</p>
                    @endif
                </div>
            </div>

            {{-- Error & Alert --}}
            <div class="bg-slate-800/50 backdrop-blur-sm rounded-2xl border border-slate-700/50 shadow-xl p-6">
                <h2 class="text-lg font-semibold text-white flex items-center gap-2 mb-4">
                    <div class="w-8 h-8 rounded-lg bg-red-500/20 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    Error & Alert
                </h2>
                <p class="text-3xl font-bold text-white mb-2">{{ $errorCount }}</p>
                <p class="text-xs text-slate-400 mb-4">Dari tabel <code class="px-1 py-0.5 rounded bg-slate-700 text-slate-300">failed_jobs</code> dan <code class="px-1 py-0.5 rounded bg-slate-700 text-slate-300">html_generation</code></p>
                <div class="p-3 rounded-lg @if($errorCount > 0) bg-red-500/10 border border-red-500/20 @else bg-emerald-500/10 border border-emerald-500/20 @endif">
                    @if($errorCount > 0)
                        <p class="text-xs text-red-300">Ada job yang gagal. Cek dan beresin queue/service</p>
                    @else
                        <p class="text-xs text-emerald-300">Tidak ada job gagal terdeteksi</p>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- AKTIVITAS TERBARU --}}
    <section class="mb-8">
        <div class="grid gap-6 lg:grid-cols-3">
            {{-- User Terbaru --}}
            <div class="bg-slate-800/50 backdrop-blur-sm rounded-2xl border border-slate-700/50 shadow-xl">
                <div class="p-6 border-b border-slate-700/50">
                    <h2 class="text-lg font-semibold text-white flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-indigo-500/20 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                        </div>
                        User Terbaru
                    </h2>
                </div>
                <div class="p-6">
                    <ul class="space-y-4">
                        @forelse($recentUsers as $user)
                            <li class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-indigo-500 to-pink-600 flex items-center justify-center">
                                    <span class="text-sm font-bold text-white">
                                        {{ strtoupper(mb_substr($user->name ?? 'U', 0, 1)) }}
                                    </span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-white truncate">{{ $user->name ?? 'User Tanpa Nama' }}</p>
                                    <p class="text-xs text-slate-400 mt-1">{{ $user->email }} • {{ optional($user->created_at)->diffForHumans() }}</p>
                                </div>
                            </li>
                        @empty
                            <li class="text-sm text-slate-400">Belum ada user yang terdaftar</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            {{-- Topup Terbaru --}}
            <div class="bg-slate-800/50 backdrop-blur-sm rounded-2xl border border-slate-700/50 shadow-xl">
                <div class="p-6 border-b border-slate-700/50">
                    <h2 class="text-lg font-semibold text-white flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-emerald-500/20 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        Topup Terbaru
                    </h2>
                </div>
                <div class="p-6">
                    <ul class="space-y-4">
                        @forelse($recentTopups as $topup)
                            <li class="p-3 rounded-lg bg-slate-900/50 border border-slate-700/50">
                                <div class="flex items-center justify-between mb-2">
                                    <p class="text-sm font-medium text-white truncate">{{ optional($topup->user)->name ?? 'User #'.$topup->user_id }}</p>
                                    <span class="inline-flex items-center text-xs px-2 py-1 rounded-full
                                        @if($topup->status === 'PAID') bg-emerald-500/20 text-emerald-300 border border-emerald-500/30
                                        @elseif($topup->status === 'WAITING_PAYMENT') bg-amber-500/20 text-amber-300 border border-amber-500/30
                                        @else bg-red-500/20 text-red-300 border border-red-500/30 @endif">
                                        {{ $topup->status ?? '-' }}
                                    </span>
                                </div>
                                <p class="text-xs text-slate-400">{{ $topup->phone_number }} • {{ number_format($topup->amount_points) }} pts</p>
                                <p class="text-xs text-slate-500 mt-1">{{ optional($topup->created_at)->diffForHumans() }}</p>
                            </li>
                        @empty
                            <li class="text-sm text-slate-400">Belum ada transaksi topup</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            {{-- HTML Generation Terbaru --}}
            <div class="bg-slate-800/50 backdrop-blur-sm rounded-2xl border border-slate-700/50 shadow-xl">
                <div class="p-6 border-b border-slate-700/50">
                    <h2 class="text-lg font-semibold text-white flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-amber-500/20 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                            </svg>
                        </div>
                        HTML Generation Terbaru
                    </h2>
                </div>
                <div class="p-6">
                    <ul class="space-y-4">
                        @forelse($recentGenerations as $gen)
                            <li class="p-3 rounded-lg bg-slate-900/50 border border-slate-700/50">
                                <div class="flex items-center justify-between mb-2">
                                    <p class="text-sm font-medium text-white truncate max-w-[160px]">{{ $gen->title ?? 'Tanpa Judul' }}</p>
                                    <span class="inline-flex items-center text-xs px-2 py-1 rounded-full
                                    @if($gen->library === 'tailwind') bg-orange-500/20 text-orange-300 border border-blue-500/30
                                    @elseif($gen->library === 'bootstrap') bg-purple-500/20 text-purple-300 border border-purple-500/30
                                    @else bg-gray-500/20 text-gray-300
                                    @endif ">
                                        {{ $gen->library ?? 'unknown' }}
                                    </span>
                                </div>
                                <p class="text-xs text-slate-400">{{ optional($gen->user)->name ?? 'User #'.$gen->user_id }}</p>
                                <p class="text-xs text-slate-500 mt-1">Status: {{ $gen->status ?? '-' }} • {{ optional($gen->created_at)->diffForHumans() }}</p>
                            </li>
                        @empty
                            <li class="text-sm text-slate-400">Belum ada data HTML generation</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- PANEL INFO AKUN --}}
    <section>
        <div class="bg-slate-800/50 backdrop-blur-sm rounded-2xl border border-slate-700/50 shadow-xl p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h3 class="text-lg font-semibold text-white mb-2">Info Akun Kamu</h3>
                    <p class="text-sm text-slate-300">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-slate-400">{{ auth()->user()->email }} • Role: {{ auth()->user()->role ?? '-' }}</p>
                </div>

                <div class="flex flex-wrap gap-3">
                    @if(Route::has('profile.edit'))
                        <a href="{{ route('profile.edit') }}"
                           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-slate-700/50 hover:bg-slate-700 border border-slate-600/50 text-sm text-slate-300 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Edit Profil
                        </a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-red-500/10 hover:bg-red-500/20 border border-red-500/30 text-sm text-red-300 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
