@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    {{-- Header --}}
    <div class="mb-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-white flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-orange-500 to-pink-500 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    Riwayat Generate
                </h1>
                <p class="text-slate-400 text-sm mt-2">Kelola dan pantau semua halaman HTML yang telah Anda buat</p>
            </div>
            <a href="{{ route('generations.create') }}"
               class="flex items-center gap-2 px-4 py-2.5 rounded-xl bg-gradient-to-br from-orange-500 to-pink-500 hover:from-blue-600 hover:to-purple-700 text-white font-medium shadow-lg shadow-blue-500/25 transition-all duration-200 transform hover:scale-[1.02]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Generate Baru
            </a>
        </div>

    </div>

    @if ($generations->isEmpty())
        {{-- Empty State --}}
        <div class="bg-slate-800/50 backdrop-blur-sm rounded-2xl border border-slate-700/50 shadow-xl p-12 text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-gradient-to-r from-orange-500/20 to-pink-500/20 mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-white mb-2">Belum ada riwayat generate</h3>
            <p class="text-slate-400 mb-6 max-w-md mx-auto">Mulai buat halaman HTML pertama Anda dengan AI. Cukup berikan instruksi dan biarkan AI melakukan sisanya.</p>
            <a href="{{ route('generations.create') }}"
               class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-br from-orange-500 to-pink-500 hover:from-blue-600 hover:to-purple-700 text-white font-medium shadow-lg shadow-blue-500/25 transition-all duration-200 transform hover:scale-[1.02]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Buat Generate Pertama
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
                    Daftar Generate
                </h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-900/50 border-b border-slate-700/50">
                        <tr>
                            <th class="px-6 py-4 text-left font-medium text-slate-300">Judul</th>
                            <th class="px-6 py-4 text-left font-medium text-slate-300">Library</th>
                            <th class="px-6 py-4 text-left font-medium text-slate-300">Status</th>
                            <th class="px-6 py-4 text-right font-medium text-slate-300">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700/50">
                        @foreach ($generations as $item)
                            <tr class="hover:bg-slate-700/30 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="font-medium text-white">{{ $item->title }}</span>
                                        <div class="flex items-center gap-2 mt-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span class="text-xs text-slate-500">{{ $item->created_at->format('d M Y H:i') }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $libraryColors = [
                                            'bootstrap' => 'bg-purple-500/20 text-purple-300 border-purple-500/30',
                                            'tailwind' => 'bg-cyan-500/20 text-cyan-300 border-cyan-500/30',
                                            'pure' => 'bg-emerald-500/20 text-emerald-300 border-emerald-500/30',
                                            'custom' => 'bg-orange-500/20 text-orange-300 border-orange-500/30',
                                        ];
                                        $libraryColor = $libraryColors[$item->library] ?? 'bg-slate-500/20 text-slate-300 border-slate-500/30';
                                    @endphp
                                    <span class="inline-flex items-center rounded-full border px-3 py-1 text-xs font-medium {{ $libraryColor }}">
                                        {{ $item->library }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusConfig = [
                                            'DONE' => [
                                                'color' => 'bg-emerald-500/20 text-emerald-300 border-emerald-500/30',
                                                'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'
                                            ],
                                            'FAILED' => [
                                                'color' => 'bg-red-500/20 text-red-300 border-red-500/30',
                                                'icon' => 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
                                            ],
                                            'GENERATING' => [
                                                'color' => 'bg-blue-500/20 text-blue-300 border-blue-500/30',
                                                'icon' => 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15'
                                            ],
                                            'WAITING' => [
                                                'color' => 'bg-yellow-500/20 text-yellow-300 border-yellow-500/30',
                                                'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'
                                            ],
                                        ];
                                        $statusData = $statusConfig[$item->status] ?? [
                                            'color' => 'bg-slate-500/20 text-slate-300 border-slate-500/30',
                                            'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'
                                        ];
                                    @endphp
                                    <div class="inline-flex items-center gap-2 rounded-full border px-3 py-1 text-xs font-medium {{ $statusData['color'] }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $statusData['icon'] }}" />
                                        </svg>
                                        <span>{{ $item->status }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="inline-flex items-center gap-2">
                                        @if ($item->status === 'DONE')
                                            <a href="{{ route('generations.edit', $item) }}"
                                               class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg border border-slate-600 hover:border-blue-500 hover:text-blue-400 text-xs font-medium transition-all">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                                Edit
                                            </a>
                                            <a href="{{ route('generations.preview', $item) }}"
                                               target="_blank"
                                               class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg border border-slate-600 hover:border-purple-500 hover:text-purple-400 text-xs font-medium transition-all">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                Preview
                                            </a>
                                            <form action="{{ route('generations.export', $item) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit"
                                                        class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg border border-slate-600 hover:border-emerald-500 hover:text-emerald-400 text-xs font-medium transition-all">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                    </svg>
                                                    Export HTML
                                                </button>
                                            </form>
                                        @endif
                                        @if (in_array($item->status, ['WAITING','GENERATING']))
                                            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-slate-700/50 text-xs text-slate-400">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                </svg>
                                                <span>Sedang diproses...</span>
                                            </div>
                                        @endif
                                        @if ($item->status === 'FAILED')
                                            <div class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-red-500/10 border border-red-500/20 text-xs text-red-400">
                                                {{-- SVG Unduh --}}
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span>Gagal generate</span>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="px-6 py-4 border-t border-slate-700/50 bg-slate-900/30">
                {{ $generations->links() }}
            </div>
        </div>
    @endif
</div>
@endsection
