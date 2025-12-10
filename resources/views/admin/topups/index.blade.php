@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-semibold">Admin · Topup</h1>
    <form method="GET" class="text-xs flex items-center gap-2">
        <select name="status"
                class="rounded-md border border-slate-700 bg-slate-900 text-xs focus:border-primary focus:ring-primary"
                onchange="this.form.submit()">
            @foreach (['WAITING_PAYMENT','PENDING','PAID','CANCELLED'] as $s)
                <option value="{{ $s }}" @selected($status === $s)>{{ $s }}</option>
            @endforeach
        </select>
    </form>
</div>

@if ($topups->isEmpty())
    <div class="rounded-lg border border-dashed border-slate-700 bg-slate-900/60 p-6 text-center text-sm text-slate-400">
        Tidak ada data.
    </div>
@else
    <div class="overflow-hidden rounded-lg border border-slate-800 bg-slate-900/70">
        <table class="min-w-full text-xs">
            <thead class="bg-slate-900/80 border-b border-slate-800">
                <tr>
                    <th class="px-3 py-2 text-left text-slate-400">Tanggal</th>
                    <th class="px-3 py-2 text-left text-slate-400">User</th>
                    <th class="px-3 py-2 text-left text-slate-400">Nomor</th>
                    <th class="px-3 py-2 text-left text-slate-400">Poin</th>
                    <th class="px-3 py-2 text-left text-slate-400">Status</th>
                    <th class="px-3 py-2 text-right text-slate-400">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($topups as $t)
                    <tr class="border-t border-slate-800/80">
                        <td class="px-3 py-2">
                            {{ $t->created_at->format('d M Y H:i') }}
                        </td>
                        <td class="px-3 py-2">
                            {{ $t->user->name }}<br>
                            <span class="text-[10px] text-slate-500">{{ $t->user->email }}</span>
                        </td>
                        <td class="px-3 py-2">
                            {{ $t->phone_number }}
                        </td>
                        <td class="px-3 py-2">
                            {{ $t->amount_points }}
                        </td>
                        <td class="px-3 py-2">
                            {{ $t->status }}
                        </td>
                        <td class="px-3 py-2 text-right">
                            @if (in_array($t->status, ['PENDING','WAITING_PAYMENT']))
                                <form action="{{ route('admin.topups.markPaid', $t) }}" method="POST"
                                      onsubmit="return confirm('Tandai sebagai sudah dibayar?')">
                                    @csrf
                                    <button
                                        class="px-3 py-1.5 rounded-md bg-primary hover:bg-primary-dark text-[11px] font-medium">
                                        Mark PAID
                                    </button>
                                </form>
                            @else
                                <span class="text-[11px] text-slate-500">Tidak ada aksi</span>
                            @endif
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
