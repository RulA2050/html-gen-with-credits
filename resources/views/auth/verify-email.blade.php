<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-slate-950 px-4">
        <div class="w-full max-w-md bg-slate-900 border border-slate-800 rounded-2xl shadow-xl px-6 py-8">
            <div class="flex flex-col items-center gap-2 mb-6">
                <div class="h-10 w-10 rounded-xl bg-orange-500/10 border border-orange-500/40 flex items-center justify-center">
                    <span class="h-2 w-2 rounded-full bg-orange-400"></span>
                </div>
                <h1 class="text-lg font-semibold text-slate-50">
                    Verifikasi Email Kamu
                </h1>
                <p class="text-xs text-slate-400 text-center max-w-sm">
                    Kami sudah kirim link verifikasi ke email yang kamu pakai saat daftar.
                    Klik link tersebut dulu sebelum lanjut.
                </p>
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-5 rounded-lg border border-emerald-500/40 bg-emerald-500/10 px-3 py-2 text-xs text-emerald-300">
                    Link verifikasi baru sudah dikirim ulang ke email kamu.
                </div>
            @endif

            <div class="flex items-center justify-between gap-3 mt-2">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-lg bg-orange-500 hover:bg-orange-600 text-xs font-semibold text-white px-4 py-2.5 shadow-sm transition"
                    >
                        Kirim Ulang Email Verifikasi
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        type="submit"
                        class="text-[11px] text-slate-400 hover:text-slate-200 underline-offset-2 hover:underline rounded-md focus:outline-none focus:ring-1 focus:ring-orange-500 focus:ring-offset-0"
                    >
                        Keluar
                    </button>
                </form>
            </div>

            <p class="mt-6 text-[11px] text-slate-500 text-center leading-relaxed">
                Belum lihat email masuk? Cek folder spam / promosi.
                Kalau masih nggak ada, klik tombol kirim ulang di atas.
            </p>
        </div>
    </div>
</x-guest-layout>
