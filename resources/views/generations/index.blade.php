@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-semibold">Generate HTML</h1>
        <p class="text-sm text-slate-400 mt-1">
            Poin kamu: <span class="text-primary font-medium">{{ auth()->user()->points }}</span>
        </p>
    </div>
    <a href="{{ route('generations.create') }}"
       class="px-4 py-2 rounded-md bg-primary hover:bg-primary-dark text-sm font-medium transition">
        Generate Baru
    </a>
</div>

@if ($generations->isEmpty())
    <div class="rounded-lg border border-dashed border-slate-700 bg-slate-900/60 p-6 text-center text-sm text-slate-400">
        Belum ada riwayat generate. Coba buat satu.
    </div>
@else
    <div class="overflow-hidden rounded-lg border border-slate-800 bg-slate-900/70">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-900/80 border-b border-slate-800">
                <tr>
                    <th class="px-4 py-2 text-left font-medium text-slate-400">Judul</th>
                    <th class="px-4 py-2 text-left font-medium text-slate-400">Library</th>
                    <th class="px-4 py-2 text-left font-medium text-slate-400">Status</th>
                    <th class="px-4 py-2 text-right font-medium text-slate-400">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($generations as $item)
                    <tr class="border-t border-slate-800/80 hover:bg-slate-800/40">
                        <td class="px-4 py-2">
                            <div class="font-medium text-slate-100">{{ $item->title }}</div>
                            <div class="text-xs text-slate-500">
                                {{ $item->created_at->format('d M Y H:i') }}
                            </div>
                        </td>
                        <td class="px-4 py-2">
                            <span class="inline-flex items-center rounded-full border border-slate-700 px-2 py-0.5 text-[11px] uppercase tracking-wide text-slate-300">
                                {{ $item->library }}
                            </span>
                        </td>
                        <td class="px-4 py-2">
                            @php
                                $badgeClass = match ($item->status) {
                                    'DONE' => 'bg-emerald-500/10 text-emerald-300 border-emerald-500/40',
                                    'FAILED' => 'bg-red-500/10 text-red-300 border-red-500/40',
                                    'GENERATING' => 'bg-blue-500/10 text-blue-300 border-blue-500/40',
                                    default => 'bg-slate-700/40 text-slate-200 border-slate-600/70',
                                };
                            @endphp
                            <span class="inline-flex items-center rounded-full border px-2 py-0.5 text-[11px] font-medium {{ $badgeClass }}">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td class="px-4 py-2 text-right">
                            <div class="inline-flex items-center gap-2">
                                @if ($item->status === 'DONE')
                                    <a href="{{ route('generations.edit', $item) }}"
                                       class="text-xs px-3 py-1.5 rounded-md border border-slate-700 hover:border-primary hover:text-primary transition">
                                        Edit
                                    </a>
                                    <a href="{{ route('generations.preview', $item) }}"
                                       target="_blank"
                                       class="text-xs px-3 py-1.5 rounded-md border border-slate-700 hover:border-primary hover:text-primary transition">
                                        Preview
                                    </a>
                                @endif
                                @if (in_array($item->status, ['WAITING','GENERATING']))
                                    <span class="text-xs text-slate-500">Sedang diproses...</span>
                                @endif
                                @if ($item->status === 'FAILED')
                                    <span class="text-xs text-red-400">Gagal generate</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="border-t border-slate-800 px-4 py-3">
            {{ $generations->links() }}
        </div>
    </div>
@endif
@endsection
