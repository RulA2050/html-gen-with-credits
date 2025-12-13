@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900">
    <div class="container mx-auto px-4 py-8">
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
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-r from-indigo-500 to-purple-600 mb-4 shadow-lg shadow-indigo-500/25">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-white mb-2">Topup Poin Generate</h1>
                <p class="text-slate-400 text-sm">Isi ulang saldo poin Anda dengan mudah dan cepat</p>
            </div>

            <form action="{{ route('topups.store') }}" method="POST" class="space-y-6">
                @csrf

                {{-- Nomor WhatsApp Card --}}
                <div class="bg-slate-800/50 backdrop-blur-sm rounded-2xl p-5 border border-slate-700/50 shadow-xl">
                    <div class="flex items-center justify-between mb-3">
                        <label class="text-xs font-semibold text-slate-400 uppercase tracking-wider">
                            Nomor WhatsApp
                        </label>
                        <div class="flex items-center gap-1 text-emerald-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-xs">Terverifikasi</span>
                        </div>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <input
                            type="text"
                            name="phone_number"
                            disabled
                            x-model="phoneNumber"
                            class="w-full pl-12 pr-4 py-3 bg-slate-900/50 border border-slate-700 rounded-xl text-slate-300 text-sm focus:outline-none cursor-not-allowed font-mono"
                        >
                    </div>
                    @error('phone_number')
                        <p class="text-xs text-red-400 mt-2 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Input Jumlah Poin --}}
                <div class="bg-slate-800/50 backdrop-blur-sm rounded-2xl p-5 border border-slate-700/50 shadow-xl">
                    <div class="flex justify-between items-center mb-4">
                        <label class="text-xs font-semibold text-slate-400 uppercase tracking-wider" for="amount_points">
                            Jumlah Poin
                        </label>
                        <div class="px-3 py-1 rounded-full bg-gradient-to-r from-indigo-500/20 to-purple-500/20 border border-indigo-500/30">
                            <span class="text-xs text-indigo-300 font-medium">
                                Rate: <span x-text="basePoints"></span> Poin = <span x-text="formatRupiah(basePrice)"></span>
                            </span>
                        </div>
                    </div>

                    <div class="relative mb-4">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4">
                            <button type="button" @click="points > 5 ? points-- : null" class="w-8 h-8 rounded-lg bg-slate-700/50 flex items-center justify-center hover:bg-slate-600 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                </svg>
                            </button>
                        </div>
                        <input
                            type="number"
                            id="amount_points"
                            name="amount_points"
                            x-model.number="points"
                            min="5"
                            step="1"
                            class="w-full px-16 py-4 bg-slate-900/50 border-2 border-slate-700 rounded-xl text-white text-2xl font-bold focus:border-indigo-500 focus:outline-none transition-all text-center"
                        >
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4">
                            <button type="button" @click="points++" class="w-8 h-8 rounded-lg bg-slate-700/50 flex items-center justify-center hover:bg-slate-600 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                            </button>
                        </div>
                        <div class="absolute inset-y-0 right-16 flex items-center pointer-events-none">
                            <span class="text-slate-500 text-sm font-medium">PTS</span>
                        </div>
                    </div>

                    @error('amount_points')
                        <p class="text-xs text-red-400 mb-3 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror

                    {{-- Tombol Cepat (Quick Select) --}}
                    <div class="grid grid-cols-4 gap-2">
                        <template x-for="amt in [10, 25, 50, 100]">
                            <button
                                type="button"
                                @click="points = amt"
                                class="py-2.5 rounded-lg border transition-all duration-200 font-medium text-sm"
                                :class="points === amt
                                    ? 'bg-gradient-to-r from-indigo-500 to-purple-600 border-transparent text-white shadow-lg shadow-indigo-500/25'
                                    : 'bg-slate-700/30 border-slate-600/50 text-slate-400 hover:bg-slate-700/50 hover:text-slate-200'"
                            >
                                <span x-text="amt"></span>
                            </button>
                        </template>
                    </div>

                    {{-- Error visual jika poin < 5 --}}
                    <div x-show="points < 5" x-transition class="mt-3 p-2 bg-red-500/10 border border-red-500/20 rounded-lg">
                        <p class="text-xs text-red-400 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            Minimal topup adalah 5 poin
                        </p>
                    </div>
                </div>

                {{-- Kartu Kalkulasi Harga --}}
                <div class="bg-gradient-to-r from-indigo-600/20 to-purple-600/20 backdrop-blur-sm rounded-2xl p-5 border border-indigo-500/30 shadow-xl">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold text-slate-300">Detail Pembayaran</h3>
                        <div class="w-10 h-10 rounded-full bg-gradient-to-r from-indigo-500 to-purple-600 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="flex justify-between text-xs text-slate-400">
                            <span>Harga Satuan</span>
                            <span x-text="formatRupiah(basePrice / basePoints) + ' / poin'"></span>
                        </div>
                        <div class="flex justify-between text-xs text-slate-400">
                            <span>Jumlah Poin</span>
                            <span x-text="points + ' PTS'"></span>
                        </div>
                        <div class="w-full h-px bg-slate-700"></div>
                        <div class="flex justify-between items-end">
                            <span class="text-sm font-medium text-slate-300">Total Tagihan</span>
                            <div class="text-right">
                                <span
                                    class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-cyan-400"
                                    x-text="formatRupiah(calculateTotal())"
                                ></span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Submit Button --}}
                <button
                    type="submit"
                    :disabled="points < 5"
                    class="w-full py-4 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 disabled:from-slate-700 disabled:to-slate-700 disabled:text-slate-500 disabled:cursor-not-allowed text-white font-semibold text-sm transition-all duration-200 shadow-lg shadow-indigo-500/25 flex items-center justify-center gap-2"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Ajukan Topup
                </button>
            </form>
        </div>
    </div>
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
