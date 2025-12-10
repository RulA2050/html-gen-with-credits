@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-semibold">Riwayat Topup</h1>
    <a href="{{ route('topups.create') }}"
       class="px-4 py-2 rounded-md bg-primary hover:bg-primary-dark text-sm font-medium transition">
        Topup Baru
    </a>
</div>

@if ($topups->isEmpty())
    <div class="rounded-lg border border-dashed border-slate-700 bg-slate-900/60 p-6 text-center text-sm text-slate-400">
        Belum ada riwayat topup.
    </div>
@else
    <div class="overflow-hidden rounded-lg border border-slate-800 bg-slate-900/70">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-900/80 border-b border-slate-800">
                <tr>
                    <th class="px-4 py-2 text-left font-medium text-slate-400">Tanggal</th>
                    <th class="px-4 py-2 text-left font-medium text-slate-400">Nomor</th>
                    <th class="px-4 py-2 text-left font-medium text-slate-400">Poin</th>
                    <th class="px-4 py-2 text-left font-medium text-slate-400">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($topups as $t)
                    <tr class="border-t border-slate-800/80">
                        <td class="px-4 py-2">
                            {{ $t->created_at->format('d M Y H:i') }}
                        </td>
                        <td class="px-4 py-2">
                            {{ $t->phone_number }}
                        </td>
                        <td class="px-4 py-2">
                            {{ $t->amount_points }}
                        </td>
                        <td class="px-4 py-2">
                            {{ $t->status }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="border-t border-slate-800 px-4 py-3">
            {{ $topups->links() }}
        </div>
    </div>
@endif
@endsection
