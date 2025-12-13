@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    {{-- Header --}}
    <div class="mb-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-white flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-r from-orange-500 to-pink-500 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    Riwayat Topup
                </h1>
                <p class="text-slate-400 text-sm mt-2">Kelola dan pantau semua transaksi topup Anda</p>
            </div>
            <a href="{{ route('topups.create') }}"
               class="flex items-center gap-2 px-4 py-2.5 rounded-xl bg-gradient-to-r from-orange-500 to-pink-500 hover:from-orange-600 hover:to-pink-600 text-white font-medium shadow-lg shadow-orange-500/25 transition-all duration-200 transform hover:scale-[1.02]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Topup Baru
            </a>
        </div>

        {{-- Points Card --}}
        <div class="inline-flex items-center gap-3 px-4 py-2 rounded-xl bg-gradient-to-r from-orange-500/10 to-pink-500/10 border border-orange-500/20 backdrop-blur-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
            </svg>
            <div>
                <p class="text-xs text-slate-400">Poin tersedia</p>
                <p class="text-lg font-bold text-white">{{ number_format(auth()->user()->points) }}</p>
            </div>
        </div>
    </div>

    @if ($topups->isEmpty())
        {{-- Empty State --}}
        <div class="bg-slate-800/50 backdrop-blur-sm rounded-2xl border border-slate-700/50 shadow-xl p-12 text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-gradient-to-r from-orange-500/20 to-pink-500/20 mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-white mb-2">Belum ada riwayat topup</h3>
            <p class="text-slate-400 mb-6 max-w-md mx-auto">Mulai lakukan topup pertama Anda untuk mendapatkan poin dan gunakan fitur generate HTML.</p>
            <a href="{{ route('topups.create') }}"
               class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-orange-500 to-pink-500 hover:from-orange-600 hover:to-pink-600 text-white font-medium shadow-lg shadow-orange-500/25 transition-all duration-200 transform hover:scale-[1.02]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Topup Sekarang
            </a>
        </div>
    @else
        {{-- Table Card --}}
        <div class="bg-slate-800/50 backdrop-blur-sm rounded-2xl border border-slate-700/50 shadow-xl overflow-hidden">
            <div class="p-6 border-b border-slate-700/50">
                <h2 class="text-lg font-semibold text-white flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Daftar Transaksi Topup
                </h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-900/50 border-b border-slate-700/50">
                        <tr>
                            <th class="px-6 py-4 text-left font-medium text-slate-300">Tanggal</th>
                            <th class="px-6 py-4 text-left font-medium text-slate-300">Nomor</th>
                            <th class="px-6 py-4 text-left font-medium text-slate-300">Poin</th>
                            <th class="px-6 py-4 text-left font-medium text-slate-300">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700/50">
                        @foreach ($topups as $t)
                            <tr class="hover:bg-slate-700/30 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span class="text-white">{{ $t->created_at->format('d M Y') }}</span>
                                        <span class="text-xs text-slate-500">{{ $t->created_at->format('H:i') }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        <span class="text-white">{{ $t->phone_number }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="text-white font-medium">{{ number_format($t->amount_points) }}</span>
                                        <span class="text-xs text-slate-500">PTS</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusConfig = [
                                            'PAID' => [
                                                'color' => 'bg-emerald-500/20 text-emerald-300 border-emerald-500/30',
                                                'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'
                                            ],
                                            'WAITING_PAYMENT' => [
                                                'color' => 'bg-yellow-500/20 text-yellow-300 border-yellow-500/30',
                                                'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'
                                            ],
                                            'PENDING' => [
                                                'color' => 'bg-red-500/20 text-red-300 border-red-500/30',
                                                'icon' => 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
                                            ],
                                        ];
                                        $statusData = $statusConfig[$t->status] ?? [
                                            'color' => 'bg-slate-500/20 text-slate-300 border-slate-500/30',
                                            'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'
                                        ];
                                    @endphp
                                    <div class="inline-flex items-center gap-2 rounded-full border px-3 py-1 text-xs font-medium {{ $statusData['color'] }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $statusData['icon'] }}" />
                                        </svg>
                                        <span>{{ $t->status }}</span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="px-6 py-4 border-t border-slate-700/50 bg-slate-900/30">
                {{ $topups->links() }}
            </div>
        </div>
    @endif
</div>
@endsection
