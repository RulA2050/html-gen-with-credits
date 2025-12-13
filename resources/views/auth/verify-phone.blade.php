<x-guest-layout>
    {{-- Verification Alert --}}
    <div class="mb-6 p-4 bg-gradient-to-r from-blue-500/10 to-purple-500/10 border border-blue-500/20 rounded-xl backdrop-blur-sm">
        <div class="flex items-start gap-3">
            <div class="flex-shrink-0 mt-0.5">
                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76" />
                    </svg>
                </div>
            </div>
            <div class="flex-1">
                <h3 class="text-sm font-semibold text-white mb-1">Verifikasi Diperlukan</h3>
                <p class="text-xs text-slate-300 leading-relaxed">
                    Kami telah mengirim kode verifikasi 6 digit ke nomor WhatsApp Anda:
                    <span class="font-bold text-white">{{ $phone_number }}</span>
                </p>
            </div>
        </div>
    </div>

    @if (session('status'))
        <div class="mb-6 p-4 bg-gradient-to-r from-emerald-500/10 to-green-500/10 border border-emerald-500/20 rounded-xl backdrop-blur-sm slide-down">
            <div class="flex items-center gap-3">
                <div class="flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="text-sm font-medium text-emerald-300">{{ session('status') }}</p>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('phone.verify.submit') }}" class="space-y-6" x-data="verificationForm()">
        @csrf

        {{-- Verification Code Input --}}
        <div class="space-y-3">
            <x-input-label for="code" :value="__('Kode Verifikasi')" class="text-sm font-medium text-slate-300" />

            {{-- 6 Digit Code Inputs --}}
            <div class="flex gap-2 justify-center" x-ref="codeContainer">
                <template x-for="(digit, index) in digits" :key="index">
                    <input
                        type="text"
                        maxlength="1"
                        class="w-12 h-14 text-center text-xl font-bold bg-slate-900/50 border-2 border-slate-600 rounded-xl focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all text-white"
                        :value="digit"
                        @input="handleInput($event, index)"
                        @keydown.backspace="handleBackspace($event, index)"
                        @paste="handlePaste($event)"
                        x-ref="inputs"
                        :name="index === 0 ? 'code' : ''"
                    >
                </template>
            </div>

            {{-- Hidden Input for Form Submission --}}
            <input type="hidden" name="code" :value="digits.join('')" x-model="fullCode">

            <x-input-error :messages="$errors->get('code')" class="mt-2" />

            {{-- Timer --}}
            <div x-show="timeLeft > 0" class="text-center">
                <p class="text-xs text-slate-400">
                    Kirim ulang kode dalam
                    <span class="font-mono font-bold text-orange-400" x-text="formatTime(timeLeft)"></span>
                </p>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex flex-col gap-3">
            <button
                type="submit"
                :disabled="digits.join('').length !== 6"
                class="w-full py-3 px-4 bg-gradient-to-r from-orange-500 to-pink-500 hover:from-orange-600 hover:to-pink-600 disabled:from-slate-700 disabled:to-slate-700 disabled:text-slate-500 text-white font-semibold rounded-xl shadow-lg shadow-orange-500/25 transition-all duration-200 transform hover:scale-[1.02] disabled:scale-100 disabled:cursor-not-allowed flex items-center justify-center gap-2"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                Verifikasi Sekarang
            </button>

            <form method="POST" action="{{ route('phone.verify.resend') }}" class="w-full">
                @csrf
                <button
                    type="submit"
                    :disabled="timeLeft > 0"
                    class="w-full py-2.5 px-4 bg-slate-800/50 hover:bg-slate-700/50 disabled:bg-slate-900/30 disabled:text-slate-600 disabled:cursor-not-allowed border border-slate-600/50 disabled:border-slate-700/50 text-slate-300 disabled:text-slate-600 text-sm font-medium rounded-xl transition-all duration-200 flex items-center justify-center gap-2"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    <span x-show="timeLeft > 0">Tunggu <span x-text="Math.ceil(timeLeft / 60)"></span> menit</span>
                    <span x-show="timeLeft <= 0">Kirim Ulang Kode</span>
                </button>
            </form>
        </div>
    </form>

    {{-- Help Section --}}
    <div class="mt-8 text-center">
        <p class="text-xs text-slate-500 mb-2">Tidak menerima kode?</p>
        <div class="flex items-center justify-center gap-4">
            <a href="#" class="text-xs text-orange-400 hover:text-orange-300 transition-colors flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Bantuan
            </a>
            <span class="text-slate-700">•</span>
            <a href="#" class="text-xs text-orange-400 hover:text-orange-300 transition-colors flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
                Hubungi Support
            </a>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('verificationForm', () => ({
                digits: ['', '', '', '', '', ''],
                timeLeft: 180, // 3 minutes in seconds

                init() {
                    // Start countdown timer
                    this.startTimer();

                    // Focus first input
                    this.$nextTick(() => {
                        this.$refs.inputs[0].focus();
                    });
                },

                get fullCode() {
                    return this.digits.join('');
                },

                handleInput(event, index) {
                    const value = event.target.value;

                    // Only allow numbers
                    if (!/^\d*$/.test(value)) {
                        event.target.value = '';
                        return;
                    }

                    this.digits[index] = value;

                    // Move to next input
                    if (value && index < 5) {
                        this.$refs.inputs[index + 1].focus();
                    }
                },

                handleBackspace(event, index) {
                    if (event.target.value === '' && index > 0) {
                        this.$refs.inputs[index - 1].focus();
                    }
                },

                handlePaste(event) {
                    event.preventDefault();
                    const pastedData = (event.clipboardData || window.clipboardData).getData('text');
                    const numbers = pastedData.replace(/\D/g, '').slice(0, 6);

                    for (let i = 0; i < numbers.length; i++) {
                        if (i < 6) {
                            this.digits[i] = numbers[i];
                        }
                    }

                    // Focus on the next empty input or the last one
                    const nextEmpty = this.digits.findIndex(d => d === '');
                    const focusIndex = nextEmpty === -1 ? 5 : nextEmpty;
                    this.$nextTick(() => {
                        this.$refs.inputs[focusIndex].focus();
                    });
                },

                startTimer() {
                    const timer = setInterval(() => {
                        this.timeLeft--;
                        if (this.timeLeft <= 0) {
                            clearInterval(timer);
                        }
                    }, 1000);
                },

                formatTime(seconds) {
                    const minutes = Math.floor(seconds / 60);
                    const secs = seconds % 60;
                    return `${minutes}:${secs.toString().padStart(2, '0')}`;
                }
            }));
        });
    </script>
</x-guest-layout>
