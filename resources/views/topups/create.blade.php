@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto">
    <h1 class="text-xl font-semibold mb-4">Topup Poin Generate</h1>

    <form action="{{ route('topups.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm mb-1" for="phone_number">Nomor WhatsApp</label>
            <input
                type="text"
                id="phone_number"
                name="phone_number"
                value="{{ old('phone_number', auth()->user()->phone_number) }}"
                class="w-full rounded-md border border-slate-700 bg-slate-900 text-sm focus:border-primary focus:ring-primary"
                placeholder="08xxxxxxxxxx">
            @error('phone_number')
                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm mb-1" for="amount_points">Jumlah Poin</label>
            <input
                type="number"
                id="amount_points"
                name="amount_points"
                value="{{ old('amount_points', 10) }}"
                class="w-full rounded-md border border-slate-700 bg-slate-900 text-sm focus:border-primary focus:ring-primary"
                min="1">
            @error('amount_points')
                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button
            type="submit"
            class="w-full py-2.5 rounded-md bg-primary hover:bg-primary-dark font-medium text-sm transition">
            Ajukan Topup
        </button>
    </form>
</div>
@endsection
