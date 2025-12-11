{{-- resources/views/auth/login.blade.php --}}
<x-guest-layout>
    <div class="space-y-6">
        {{-- Header --}}
        <div class="space-y-1">
            <h2 class="text-lg font-semibold text-slate-50">
                Masuk ke akun kamu
            </h2>
            <p class="text-[12px] text-slate-400 leading-relaxed">
                Lanjutkan aktivitas yang sempat ke-pause. Kalau belum punya akun,
                <a href="{{ route('register') }}" class="text-orange-400 hover:text-orange-300 underline underline-offset-4">
                    daftar dulu di sini
                </a>.
            </p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-3" :status="session('status')" />

        <!-- Validation Errors -->
        <x-input-error :messages="$errors->all()" class="mb-3 text-[11px]" />

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <!-- Email Address -->
            <div class="space-y-1.5">
                <x-input-label for="phone_number" :value="__('Nomor Handphone')" class="text-[12px] text-slate-200" />
                <x-text-input
                    id="phone_number"
                    class="block w-full text-sm bg-slate-900/60 border-slate-700 focus:border-orange-500 focus:ring-orange-500"
                    type="phone_number"
                    name="phone_number"
                    :value="old('phone_number')"
                    required
                    autofocus
                    autocomplete="phone_number"
                    placeholder="081xxxxxxxxx"
                />
            </div>

            <!-- Password -->
            <div class="space-y-1.5">
                <div class="flex items-center justify-between">
                    <x-input-label for="password" :value="__('Password')" class="text-[12px] text-slate-200" />

                    @if (Route::has('password.request'))
                        <a
                            class="text-[11px] text-slate-400 hover:text-slate-200 underline underline-offset-4"
                            href="{{ route('password.request') }}"
                        >
                            Lupa password?
                        </a>
                    @endif
                </div>

                <x-text-input
                    id="password"
                    class="block w-full text-sm bg-slate-900/60 border-slate-700 focus:border-orange-500 focus:ring-orange-500"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="••••••••"
                />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between mt-1">
                <label class="inline-flex items-center gap-2 text-[11px] text-slate-400">
                    <input
                        id="remember_me"
                        type="checkbox"
                        class="rounded border-slate-600 bg-slate-900 text-orange-500 focus:ring-orange-500/70 focus:ring-offset-0"
                        name="remember"
                    >
                    <span>Ingat saya di device ini</span>
                </label>
            </div>

            <div class="pt-2">
                <x-primary-button class="w-full justify-center gap-2 bg-orange-500 hover:bg-orange-600 text-xs py-2.5">
                    Masuk
                    <span class="text-[10px] opacity-80">→</span>
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
