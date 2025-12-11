@extends('layouts.app')

@section('content')
{{--
    Pastikan x-data ada di container utama.
    Kita passing data dari Controller Laravel ke Alpine JS di sini.
--}}
<div
    class="max-w-md mx-auto"
    x-data="topupForm({
        phoneNumber: '{{ $phoneNumber }}',
        basePrice: {{ $pricePoints }},
        basePoints: {{ $usingPoints }},
        oldPoints: {{ old('amount_points', 10) }}
    })"
>
    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-xl font-bold text-white flex items-center gap-2">
            Topup Poin Generate
        </h1>
        <p class="text-slate-400 text-xs mt-1">Isi ulang saldo poin Anda dengan mudah.</p>
    </div>

    <form action="{{ route('topups.store') }}" method="POST" class="space-y-6">
        @csrf

        {{-- Nomor WhatsApp (Read Only) --}}
        <div class="space-y-2">
            <label class="block text-xs font-medium text-slate-400 uppercase tracking-wider">
                Nomor WhatsApp
            </label>
            <div class="relative">
                <input
                    type="text"
                    name="phone_number"
                    disabled
                    x-model="phoneNumber"
                    class="w-full pl-4 pr-4 py-3 bg-slate-900 border border-slate-700 rounded-xl text-slate-300 text-sm focus:outline-none cursor-not-allowed font-mono"
                >
                {{-- Verified Icon (Optional) --}}
                <div class="absolute right-3 top-3 text-emerald-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
            @error('phone_number')
                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Input Jumlah Poin --}}
        <div class="space-y-3">
            <div class="flex justify-between items-center">
                <label class="block text-xs font-medium text-slate-400 uppercase tracking-wider" for="amount_points">
                    Jumlah Poin
                </label>
                {{-- Badge Rate --}}
                <span class="text-[10px] px-2 py-0.5 rounded-full bg-indigo-500/10 text-indigo-400 border border-indigo-500/20">
                    Rate: <span x-text="basePoints"></span> Poin = <span x-text="formatRupiah(basePrice)"></span>
                </span>
            </div>

            <div class="relative group">
                <input
                    type="number"
                    id="amount_points"
                    name="amount_points"
                    x-model.number="points"
                    min="5"
                    step="1"
                    class="w-full px-4 py-4 bg-slate-800 border border-slate-700 rounded-xl text-white text-xl font-bold focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all placeholder-slate-600 text-center"
                >
                <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
                    <span class="text-slate-500 text-sm font-medium">PTS</span>
                </div>
                {{-- Tombol Plus Minus --}}
                <div class="absolute inset-y-0 left-4 flex items-center">
                    <button type="button" @click="points > 5 ? points-- : null" class="p-1 hover:text-white text-slate-500 transition"> - </button>
                </div>
                <div class="absolute inset-y-0 right-12 flex items-center">
                    <button type="button" @click="points++" class="p-1 hover:text-white text-slate-500 transition"> + </button>
                </div>
            </div>

            @error('amount_points')
                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
            @enderror

            {{-- Tombol Cepat (Quick Select) --}}
            <div class="grid grid-cols-4 gap-2">
                <template x-for="amt in [10, 25, 50, 100]">
                    <button
                        type="button"
                        @click="points = amt"
                        class="py-2 text-xs font-medium rounded-lg border transition-all duration-200"
                        :class="points === amt
                            ? 'bg-indigo-600 border-indigo-500 text-white shadow-lg'
                            : 'bg-slate-800 border-slate-700 text-slate-400 hover:bg-slate-700 hover:text-slate-200'"
                    >
                        <span x-text="amt"></span>
                    </button>
                </template>
            </div>

            {{-- Error visual jika poin < 5 --}}
            <div x-show="points < 5" x-transition class="text-xs text-red-400 flex items-center gap-1 mt-1">
                Minimal topup adalah 5 poin
            </div>
        </div>

        {{-- Kartu Kalkulasi Harga --}}
        <div class="bg-slate-900/50 border border-dashed border-slate-800 rounded-xl p-4 space-y-3">
            <div class="flex justify-between text-xs text-slate-400">
                <span>Harga Satuan</span>
                <span x-text="formatRupiah(basePrice / basePoints) + ' / poin'"></span>
            </div>
            <div class="w-full h-px bg-slate-800"></div>
            <div class="flex justify-between items-end">
                <span class="text-sm font-medium text-slate-300 mb-1">Total Tagihan</span>
                <span
                    class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-cyan-400"
                    x-text="formatRupiah(calculateTotal())"
                ></span>
            </div>
        </div>

        {{-- Submit Button --}}
        <button
            type="submit"
            :disabled="points < 5"
            class="w-full py-3 rounded-xl bg-indigo-600 hover:bg-indigo-500 disabled:bg-slate-800 disabled:text-slate-600 disabled:cursor-not-allowed text-white font-semibold text-sm transition-all"
        >
            Ajukan Topup
        </button>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('topupForm', (config) => ({
            // State
            phoneNumber: config.phoneNumber,
            points: config.oldPoints, // Ambil dari old() atau default
            basePrice: config.basePrice,
            basePoints: config.basePoints,

            // Logic Hitung
            calculateTotal() {
                let p = parseInt(this.points);
                if (!p || p < 0) p = 0;

                // Rumus: (Input / Poin Dasar) * Harga Dasar
                return (p / this.basePoints) * this.basePrice;
            },

            // Format Rupiah
            formatRupiah(angka) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }).format(angka);
            }
        }));
    });
</script>
@endpush
