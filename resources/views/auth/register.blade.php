{{-- resources/views/auth/register.blade.php --}}
<x-guest-layout>
    <div class="space-y-6">
        {{-- Header --}}
        <div class="space-y-1">
            <h2 class="text-lg font-semibold text-slate-50">
                Buat akun baru
            </h2>
            <p class="text-[12px] text-slate-400 leading-relaxed">
                Daftar sekali, habis itu kamu bisa akses semua fitur di
                {{ config('app.name') }}. Udah punya akun?
                <a href="{{ route('login') }}" class="text-orange-400 hover:text-orange-300 underline underline-offset-4">
                    langsung login
                </a>.
            </p>
        </div>

        <!-- Validation Errors -->
        <x-input-error :messages="$errors->all()" class="mb-3 text-[11px]" />

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <!-- Name -->
            <div class="space-y-1.5">
                <x-input-label for="name" :value="__('Name')" class="text-[12px] text-slate-200" />
                <x-text-input
                    id="name"
                    class="block w-full text-sm bg-slate-900/60 border-slate-700 focus:border-orange-500 focus:ring-orange-500"
                    type="text"
                    name="name"
                    :value="old('name')"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="Nama lengkap"
                />
            </div>

            <!-- Email Address -->
            <div class="space-y-1.5">
                <x-input-label for="email" :value="__('Email')" class="text-[12px] text-slate-200" />
                <x-text-input
                    id="email"
                    class="block w-full text-sm bg-slate-900/60 border-slate-700 focus:border-orange-500 focus:ring-orange-500"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required
                    autocomplete="username"
                    placeholder="you@example.com"
                />
            </div>
            {{-- Phone Number --}}
            <div class="space-y-1.5">
                <x-input-label for="phone_number" :value="__('Nomor WhatsApp')" class="text-[12px] text-slate-200" />
                <x-text-input
                    id="phone_number"
                    class="block w-full text-sm bg-slate-900/60 border-slate-700 focus:border-orange-500 focus:ring-orange-500"
                    type="text"
                    name="phone_number"
                    :value="old('phone_number')"
                    required
                    autocomplete="tel"
                    placeholder="08xxxxxxxxxx"
                />
            </div>

            <!-- Password -->
            <div class="space-y-1.5">
                <x-input-label for="password" :value="__('Password')" class="text-[12px] text-slate-200" />
                <x-text-input
                    id="password"
                    class="block w-full text-sm bg-slate-900/60 border-slate-700 focus:border-orange-500 focus:ring-orange-500"
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password"
                    placeholder="Minimal 8 karakter"
                />
            </div>

            <!-- Confirm Password -->
            <div class="space-y-1.5">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-[12px] text-slate-200" />
                <x-text-input
                    id="password_confirmation"
                    class="block w-full text-sm bg-slate-900/60 border-slate-700 focus:border-orange-500 focus:ring-orange-500"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="Ulangi password"
                />
            </div>

            <div class="pt-2 space-y-3">
                <x-primary-button class="w-full justify-center gap-2 bg-orange-500 hover:bg-orange-600 text-xs py-2.5">
                    Daftar sekarang
                    <span class="text-[10px] opacity-80">→</span>
                </x-primary-button>

                <p class="text-[11px] text-slate-400 text-center">
                    Dengan mendaftar, kamu menyetujui ketentuan & kebijakan yang berlaku.
                </p>
            </div>
        </form>
    </div>
</x-guest-layout>
