{{-- resources/views/auth/register.blade.php --}}
<x-guest-layout>
    <div
        class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900">
        <div class="w-full max-w-md px-10 py-8">
            <!-- Logo/Brand Section -->
            <div class="text-center mb-8">
                <div
                    class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-gradient-to-r from-orange-500 to-pink-500 mb-4 shadow-2xl shadow-orange-500/25">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-white mb-2">Buat Akun Baru</h1>
                <p class="text-slate-400 text-sm">Bergabunglah dengan kami hari ini</p>
            </div>

            <!-- Register Card -->
            <div class="bg-slate-800/50 backdrop-blur-xl rounded-2xl border border-slate-700/50 shadow-2xl p-8">
                <!-- Header -->
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-white mb-2">
                        Daftar Sekarang
                    </h2>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Daftar sekali, akses semua fitur di {{ config('app.name') }}.
                        Sudah punya akun?
                        <a href="{{ route('login') }}"
                            class="text-orange-400 hover:text-orange-300 font-medium transition-colors">
                            Login di sini
                        </a>
                    </p>
                </div>

                <!-- Validation Errors -->
                <x-input-error :messages="$errors->all()"
                    class="mb-4 p-3 bg-red-500/10 border border-red-500/20 rounded-lg text-xs" />

                <form method="POST" action="{{ route('register') }}" class="space-y-4" x-data="registerForm()">
                    @csrf

                    <!-- Name -->
                    <div class="space-y-2">
                        <x-input-label for="name" :value="__('Nama Lengkap')" class="text-xs font-medium text-slate-300" />
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <x-text-input id="name"
                                class="block w-full pl-10 pr-3 py-3 text-sm bg-slate-900/50 border-slate-600 rounded-xl focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all"
                                type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                                placeholder="Masukkan nama lengkap" />
                        </div>
                    </div>

                    <!-- Email Address -->
                    <div class="space-y-2">
                        <x-input-label for="email" :value="__('Email Address')" class="text-xs font-medium text-slate-300" />
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <x-text-input id="email"
                                class="block w-full pl-10 pr-3 py-3 text-sm bg-slate-900/50 border-slate-600 rounded-xl focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all"
                                type="email" name="email" :value="old('email')" required autocomplete="username"
                                placeholder="you@example.com" />
                        </div>
                    </div>

                    <!-- Phone Number -->
                    <div class="space-y-2">
                        <x-input-label for="phone_number" :value="__('Nomor WhatsApp')"
                            class="text-xs font-medium text-slate-300" />
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <x-text-input id="phone_number"
                                class="block w-full pl-10 pr-3 py-3 text-sm bg-slate-900/50 border-slate-600 rounded-xl focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all"
                                type="tel" name="phone_number" :value="old('phone_number')" required autocomplete="tel"
                                placeholder="081xxxxxxxxx" />
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="space-y-2">
                        <x-input-label for="password" :value="__('Password')" class="text-xs font-medium text-slate-300" />
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <x-text-input id="password"
                                class="block w-full pl-10 pr-10 py-3 text-sm bg-slate-900/50 border-slate-600 rounded-xl focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all"
                                type="password" name="password" required autocomplete="new-password"
                                placeholder="Minimal 8 karakter" x-model="password" @input="checkPasswordStrength" />
                            <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                onclick="togglePassword('password')">
                                <svg id="password-toggle" xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 text-slate-500 hover:text-slate-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>

                        <!-- Password Strength Indicator -->
                        <div x-show="password" class="mt-2">
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-xs text-slate-500">Kekuatan Password</span>
                                <span class="text-xs" :class="passwordStrengthColor"
                                    x-text="passwordStrengthText"></span>
                            </div>
                            <div class="w-full bg-slate-700 rounded-full h-1.5">
                                <div class="h-1.5 rounded-full transition-all duration-300"
                                    :class="passwordStrengthColor" :style="`width: ${passwordStrength}%`"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div class="space-y-2">
                        <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')"
                            class="text-xs font-medium text-slate-300" />
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <x-text-input id="password_confirmation"
                                class="block w-full pl-10 pr-10 py-3 text-sm bg-slate-900/50 border-slate-600 rounded-xl focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all"
                                type="password" name="password_confirmation" required autocomplete="new-password"
                                placeholder="Ulangi password" />
                            <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                onclick="togglePassword('password_confirmation')">
                                <svg id="password-confirm-toggle" xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 text-slate-500 hover:text-slate-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Terms & Conditions -->
                    <div class="flex items-start gap-3 pt-2">
                        <input type="checkbox" id="terms"
                            class="mt-1 w-4 h-4 text-orange-500 bg-slate-700 border-slate-600 rounded focus:ring-orange-500/20 focus:ring-2"
                            required>
                        <label for="terms" class="text-xs text-slate-400">
                            Saya menyetujui <a href="#" class="text-orange-400 hover:text-orange-300">Syarat &
                                Ketentuan</a>
                            dan <a href="#" class="text-orange-400 hover:text-orange-300">Kebijakan Privasi</a>
                        </label>
                    </div>

                    <div class="pt-4">
                        <button type="submit"
                            class="w-full py-3 px-4 bg-gradient-to-r from-orange-500 to-pink-500 hover:from-orange-600 hover:to-pink-600 text-white font-semibold rounded-xl shadow-lg shadow-orange-500/25 transition-all duration-200 transform hover:scale-[1.02] flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            Daftar Sekarang
                        </button>
                    </div>
                </form>


            </div>

            <!-- Help Section -->
            <div class="text-center mt-6">
                <p class="text-xs text-slate-500">
                    Butuh bantuan?
                    <a href="#" class="text-orange-400 hover:text-orange-300">Hubungi Support</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const toggle = document.getElementById(inputId + '-toggle');

            if (input.type === 'password') {
                input.type = 'text';
                toggle.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                `;
            } else {
                input.type = 'password';
                toggle.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                `;
            }
        }

        document.addEventListener('alpine:init', () => {
            Alpine.data('registerForm', () => ({
                password: '',
                passwordStrength: 0,
                passwordStrengthText: '',
                passwordStrengthColor: '',

                checkPasswordStrength() {
                    const password = this.password;
                    let strength = 0;

                    if (password.length >= 8) strength += 25;
                    if (password.length >= 12) strength += 25;
                    if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength += 25;
                    if (/[0-9]/.test(password)) strength += 12.5;
                    if (/[^a-zA-Z0-9]/.test(password)) strength += 12.5;

                    this.passwordStrength = strength;

                    if (strength <= 25) {
                        this.passwordStrengthText = 'Lemah';
                        this.passwordStrengthColor = 'bg-red-500 text-red-400';
                    } else if (strength <= 50) {
                        this.passwordStrengthText = 'Sedang';
                        this.passwordStrengthColor = 'bg-yellow-500 text-yellow-400';
                    } else if (strength <= 75) {
                        this.passwordStrengthText = 'Kuat';
                        this.passwordStrengthColor = 'bg-blue-500 text-blue-400';
                    } else {
                        this.passwordStrengthText = 'Sangat Kuat';
                        this.passwordStrengthColor = 'bg-green-500 text-green-400';
                    }
                }
            }));
        });
    </script>
</x-guest-layout>
