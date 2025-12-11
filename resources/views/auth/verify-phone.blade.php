<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-300">
        Akun kamu belum diverifikasi.
        Kami sudah kirim kode ke WhatsApp:
        <span class="font-semibold">{{ $phone_number }}</span>
    </div>

    @if (session('status'))
        <div class="mb-4 text-sm font-medium text-emerald-600 dark:text-emerald-400">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('phone.verify.submit') }}">
        @csrf

        <div>
            <x-input-label for="code" :value="__('Kode Verifikasi (6 digit)')" />
            <x-text-input id="code" class="block mt-1 w-full" type="text" name="code"
                          :value="old('code')" required autofocus maxlength="6" />
            <x-input-error :messages="$errors->get('code')" class="mt-2" />
        </div>

        <div class="mt-4 flex items-center justify-between">
            <x-primary-button>
                Verifikasi
            </x-primary-button>

            <form method="POST" action="{{ route('phone.verify.resend') }}">
                @csrf
                <button type="submit"
                        class="text-xs text-gray-500 hover:text-gray-800 dark:text-gray-200 underline">
                    Kirim ulang kode
                </button>
            </form>
        </div>
    </form>
</x-guest-layout>
