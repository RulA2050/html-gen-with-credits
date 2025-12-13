{{-- resources/views/auth/login.blade.php --}}
<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900">
        <div class="w-full max-w-md px-10 py-8">
            <!-- Logo/Brand Section -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-gradient-to-r from-orange-500 to-pink-500 mb-4 shadow-2xl shadow-orange-500/25">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-white mb-2">Selamat Datang Kembali</h1>
                <p class="text-slate-400 text-sm">Masuk ke akun Anda untuk melanjutkan</p>
            </div>

            <!-- Login Card -->
            <div class="bg-slate-800/50 backdrop-blur-xl rounded-2xl border border-slate-700/50 shadow-2xl p-8">
                <!-- Header -->
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-white mb-2">
                        Masuk ke akun kamu
                    </h2>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Lanjutkan aktivitas yang sempat terpause. Belum punya akun?
                        <a href="{{ route('register') }}" class="text-orange-400 hover:text-orange-300 font-medium transition-colors">
                            Daftar di sini
                        </a>
                    </p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <!-- Validation Errors -->
                <x-input-error :messages="$errors->all()" class="mb-4 p-3 bg-red-500/10 border border-red-500/20 rounded-lg text-xs" />

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <!-- Email Address -->
                    <div class="space-y-2">
                        <x-input-label for="phone_number" :value="__('Nomor Handphone')" class="text-xs font-medium text-slate-300" />
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <x-text-input
                                id="phone_number"
                                class="block w-full pl-10 pr-3 py-3 text-sm bg-slate-900/50 border-slate-600 rounded-xl focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all"
                                type="tel"
                                name="phone_number"
                                :value="old('phone_number')"
                                required
                                autofocus
                                autocomplete="phone_number"
                                placeholder="081xxxxxxxxx"
                            />
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <x-input-label for="password" :value="__('Password')" class="text-xs font-medium text-slate-300" />

                            @if (Route::has('password.request'))
                                <a
                                    class="text-xs text-orange-400 hover:text-orange-300 font-medium transition-colors"
                                    href="{{ route('password.request') }}"
                                >
                                    Lupa password?
                                </a>
                            @endif
                        </div>

                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <x-text-input
                                id="password"
                                class="block w-full pl-10 pr-10 py-3 text-sm bg-slate-900/50 border-slate-600 rounded-xl focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all"
                                type="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                placeholder="••••••••"
                            />
                            <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center" onclick="togglePassword('password')">
                                <svg id="password-toggle" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-500 hover:text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <label class="inline-flex items-center cursor-pointer">
                            <input
                                id="remember_me"
                                type="checkbox"
                                class="sr-only peer"
                                name="remember"
                            >
                            <div class="relative w-11 h-6 bg-slate-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-500"></div>
                            <span class="ml-3 text-xs text-slate-400">Ingat saya di device ini</span>
                        </label>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full py-3 px-4 bg-gradient-to-r from-orange-500 to-pink-500 hover:from-orange-600 hover:to-pink-600 text-white font-semibold rounded-xl shadow-lg shadow-orange-500/25 transition-all duration-200 transform hover:scale-[1.02] flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            Masuk ke Akun
                        </button>
                    </div>
                </form>
            </div>

            <!-- Footer -->
            <div class="text-center mt-6">
                <p class="text-xs text-slate-500">
                    Dengan masuk, Anda menyetujui
                    <a href="#" class="text-orange-400 hover:text-orange-300">Syarat & Ketentuan</a>
                    dan
                    <a href="#" class="text-orange-400 hover:text-orange-300">Kebijakan Privasi</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const toggle = document.getElementById('password-toggle');

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
    </script>
</x-guest-layout>
