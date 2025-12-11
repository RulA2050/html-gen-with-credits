{{-- resources/views/welcome.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC] min-h-screen flex flex-col relative selection:bg-[#F53003] selection:text-white">

        {{-- Background Pattern (Visual Texture) --}}
        <div class="fixed inset-0 -z-10 opacity-[0.03] dark:opacity-[0.05] pointer-events-none"
             style="background-image: radial-gradient(#1b1b18 1px, transparent 1px); background-size: 24px 24px;">
        </div>

        {{-- Navbar --}}
        <header class="w-full px-6 lg:px-8 py-5 border-b border-transparent">
            <div class="max-w-6xl mx-auto flex items-center justify-between">
                {{-- Brand --}}
                <div class="flex items-center gap-2.5">
                    <span class="inline-flex h-9 w-9 rounded-xl bg-[#fff2f2] dark:bg-[#1D0002] items-center justify-center border border-[#e3e3e0] dark:border-[#3E3E3A]">
                        <span class="h-2.5 w-2.5 rounded-full bg-[#F53003] dark:bg-[#F61500]"></span>
                    </span>
                    <span class="text-base font-bold tracking-tight">
                        {{ config('app.name', 'Laravel') }}
                    </span>
                </div>

                {{-- Auth Navigation --}}
                @if (Route::has('login'))
                    <nav class="flex items-center gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}"
                               class="text-sm font-medium hover:text-black dark:hover:text-white transition-colors">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                               class="text-sm font-medium hover:text-black dark:hover:text-white transition-colors">
                                Log in
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                   class="hidden sm:inline-flex items-center px-4 py-2 rounded-lg bg-[#1b1b18] dark:bg-[#EDEDEC] text-white dark:text-black text-xs font-semibold hover:opacity-90 transition shadow-sm">
                                    Register
                                </a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </div>
        </header>

        {{-- Main Content --}}
        <main class="flex-1 w-full max-w-6xl mx-auto px-6 lg:px-8 py-12 lg:py-20 flex flex-col gap-16 lg:gap-24">

            {{-- Hero Section --}}
            <div class="flex flex-col items-center text-center space-y-8 max-w-3xl mx-auto">
                {{-- Badge --}}
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full border border-[#e3e3e0] dark:border-[#3E3E3A] bg-white/50 dark:bg-[#161615]/50 backdrop-blur-sm">
                    <span class="relative flex h-2 w-2">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                    <span class="text-[11px] font-medium text-[#706f6c] dark:text-[#A1A09A]">
                        Ready to build v1.0
                    </span>
                </div>

                {{-- Headline --}}
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold tracking-tight leading-[1.1]">
                    Landing page rapi, <br />
                    <span class="text-[#706f6c] dark:text-[#A1A09A]">tanpa pusing koding.</span>
                </h1>

                {{-- Subheadline --}}
                <p class="text-lg text-[#706f6c] dark:text-[#A1A09A] leading-relaxed max-w-xl">
                    {{ config('app.name', 'Laravel') }} memberikan fondasi kokoh untuk proyekmu.
                    Desain modern, responsif, dan siap dikembangkan lebih jauh.
                </p>

                {{-- CTAs --}}
                <div class="flex flex-wrap items-center justify-center gap-3 w-full">
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-[#1b1b18] dark:bg-[#EDEDEC] text-white dark:text-black text-sm font-semibold hover:-translate-y-0.5 transition-transform shadow-md w-full sm:w-auto">
                            Mulai Sekarang
                        </a>
                    @endif
                    <a href="#features"
                       class="inline-flex items-center justify-center px-6 py-3 rounded-xl border border-[#e3e3e0] dark:border-[#3E3E3A] bg-white dark:bg-[#161615] text-sm font-medium hover:bg-[#fafafa] dark:hover:bg-[#1f1f1e] transition w-full sm:w-auto">
                        Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>

            {{-- Illustration Area --}}
            <div class="relative rounded-2xl border border-[#e3e3e0] dark:border-[#3E3E3A] bg-[#fff2f2] dark:bg-[#1D0002] p-2 shadow-sm">
                <div class="aspect-[16/9] sm:aspect-[21/9] w-full rounded-xl bg-gradient-to-tr from-white to-[#fffbfb] dark:from-[#161615] dark:to-[#0a0a0a] overflow-hidden flex items-center justify-center relative border border-[#e3e3e0]/50 dark:border-[#3E3E3A]/50">
                    <div class="absolute inset-0 opacity-[0.4]" style="background-image: linear-gradient(#e3e3e0 1px, transparent 1px), linear-gradient(90deg, #e3e3e0 1px, transparent 1px); background-size: 40px 40px;"></div>
                    <span class="relative z-10 text-sm font-medium text-[#706f6c] dark:text-[#A1A09A]">
                        (Preview Dashboard / UI App Kamu)
                    </span>
                </div>
            </div>

            {{-- Features Grid --}}
            <div id="features" class="grid sm:grid-cols-3 gap-6">
                {{-- Feature 1 --}}
                <div class="group p-6 rounded-2xl bg-white dark:bg-[#161615] border border-[#e3e3e0] dark:border-[#3E3E3A] hover:border-[#d4d4d0] dark:hover:border-[#52524e] transition-colors shadow-sm">
                    <div class="h-10 w-10 rounded-lg bg-[#fff2f2] dark:bg-[#1D0002] flex items-center justify-center mb-4 text-[#F53003] dark:text-[#F61500]">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    </div>
                    <h3 class="font-semibold text-base mb-2">Daftar Akun</h3>
                    <p class="text-sm text-[#706f6c] dark:text-[#A1A09A] leading-relaxed">
                        Proses pendaftaran cepat. Sekali klik langsung dapat akses penuh ke semua fitur.
                    </p>
                </div>

                {{-- Feature 2 --}}
                <div class="group p-6 rounded-2xl bg-white dark:bg-[#161615] border border-[#e3e3e0] dark:border-[#3E3E3A] hover:border-[#d4d4d0] dark:hover:border-[#52524e] transition-colors shadow-sm">
                    <div class="h-10 w-10 rounded-lg bg-[#fff2f2] dark:bg-[#1D0002] flex items-center justify-center mb-4 text-[#F53003] dark:text-[#F61500]">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" /></svg>
                    </div>
                    <h3 class="font-semibold text-base mb-2">Kelola Konten</h3>
                    <p class="text-sm text-[#706f6c] dark:text-[#A1A09A] leading-relaxed">
                        Dashboard intuitif untuk mengatur section, teks, dan struktur halaman dengan mudah.
                    </p>
                </div>

                {{-- Feature 3 --}}
                <div class="group p-6 rounded-2xl bg-white dark:bg-[#161615] border border-[#e3e3e0] dark:border-[#3E3E3A] hover:border-[#d4d4d0] dark:hover:border-[#52524e] transition-colors shadow-sm">
                    <div class="h-10 w-10 rounded-lg bg-[#fff2f2] dark:bg-[#1D0002] flex items-center justify-center mb-4 text-[#F53003] dark:text-[#F61500]">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                    </div>
                    <h3 class="font-semibold text-base mb-2">Siap Go-Live</h3>
                    <p class="text-sm text-[#706f6c] dark:text-[#A1A09A] leading-relaxed">
                        Optimasi performa tinggi. Deploy di VPS atau cloud hosting favoritmu tanpa kendala.
                    </p>
                </div>
            </div>

        </main>

        {{-- Footer --}}
        <footer class="w-full py-8 border-t border-[#e3e3e0] dark:border-[#3E3E3A] bg-white/50 dark:bg-[#0a0a0a]/50 backdrop-blur-sm">
            <div class="max-w-6xl mx-auto px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-[#706f6c] dark:text-[#A1A09A]">
                <p>&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.</p>
                <div class="flex items-center gap-4">
                    <a href="#" class="hover:text-black dark:hover:text-white transition-colors">Privacy</a>
                    <a href="#" class="hover:text-black dark:hover:text-white transition-colors">Terms</a>
                </div>
            </div>
        </footer>

    </body>
</html>
