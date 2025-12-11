{{-- resources/views/layouts/guest.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC]">

        <div class="min-h-screen flex lg:grid lg:grid-cols-2">

            {{-- Left Side: Branding & Visual (Hidden on Mobile) --}}
            <div class="hidden lg:flex flex-col items-center justify-center relative border-r border-[#e3e3e0] dark:border-[#3E3E3A] bg-[#FDFDFC] dark:bg-[#0a0a0a] overflow-hidden">
                {{-- Decorative Pattern (Dots) --}}
                <div class="absolute inset-0 opacity-[0.03] dark:opacity-[0.05]"
                     style="background-image: radial-gradient(#1b1b18 1px, transparent 1px); background-size: 24px 24px;">
                </div>

                {{-- Centered Logo --}}
                <div class="relative z-10 flex flex-col items-center gap-6">
                    <a href="{{ url('/') }}" class="inline-flex flex-col items-center gap-4 group">
                        <span class="inline-flex h-20 w-20 rounded-2xl bg-[#fff2f2] dark:bg-[#1D0002] items-center justify-center ring-1 ring-[#e3e3e0] dark:ring-[#3E3E3A] shadow-sm group-hover:scale-105 transition-transform duration-300">
                            <span class="h-5 w-5 rounded-full bg-[#F53003] dark:bg-[#F61500]"></span>
                        </span>
                        <span class="text-3xl font-bold tracking-tight text-[#1b1b18] dark:text-[#EDEDEC]">
                            {{ config('app.name', 'Laravel') }}
                        </span>
                    </a>
                </div>
            </div>

            {{-- Right Side: Content & Form --}}
            <div class="w-full flex flex-col h-screen overflow-y-auto">
                {{-- Header / Navigation --}}
                <header class="w-full px-6 py-6 flex items-center justify-between lg:justify-end shrink-0">

                    {{-- Mobile Logo (Visible only on small screens) --}}
                    <div class="lg:hidden">
                        <a href="{{ url('/') }}" class="inline-flex items-center gap-2">
                            <span class="inline-flex h-9 w-9 rounded-lg bg-[#fff2f2] dark:bg-[#1D0002] items-center justify-center ring-1 ring-[#e3e3e0] dark:ring-[#3E3E3A]">
                                <span class="h-2.5 w-2.5 rounded-full bg-[#F53003] dark:bg-[#F61500]"></span>
                            </span>
                            <span class="text-base font-bold tracking-tight">
                                {{ config('app.name', 'Laravel') }}
                            </span>
                        </a>
                    </div>

                    {{-- Auth Links --}}
                    @if (Route::has('login'))
                        <nav class="flex items-center gap-3 text-xs font-medium">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="px-4 py-2 rounded-md hover:bg-[#e3e3e0] dark:hover:bg-[#3E3E3A] transition">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="px-4 py-2 rounded-md hover:bg-[#e3e3e0] dark:hover:bg-[#3E3E3A] transition text-[#1b1b18] dark:text-[#EDEDEC]">
                                    Log in
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="px-4 py-2 rounded-md border border-[#e3e3e0] dark:border-[#3E3E3A] hover:bg-[#fafafa] dark:hover:bg-[#161615] transition">
                                        Register
                                    </a>
                                @endif
                            @endauth
                        </nav>
                    @endif
                </header>

                {{-- Main Form Area --}}
                <main class="flex-1 flex items-center justify-center px-6 py-8">
                    <div class="w-full max-w-[420px]">

                        {{-- Welcome Text for Mobile --}}
                        <div class="lg:hidden mb-8 text-center">
                            <h2 class="text-2xl font-semibold mb-2 text-[#1b1b18] dark:text-[#EDEDEC]">Welcome back</h2>
                            <p class="text-[#706f6c] dark:text-[#A1A09A] text-sm">Please enter your details to sign in.</p>
                        </div>

                        {{-- Card Slot --}}
                        <div class="bg-white dark:bg-[#161615] rounded-2xl shadow-[0px_0px_1px_rgba(0,0,0,0.03),0px_10px_30px_rgba(0,0,0,0.08)] border border-[#e3e3e0] dark:border-[#3E3E3A] p-6 sm:p-8">
                            {{ $slot }}
                        </div>
                    </div>
                </main>

                {{-- Footer --}}
                <footer class="py-6 text-[11px] text-center text-[#706f6c] dark:text-[#A1A09A] shrink-0">
                    © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                </footer>
            </div>
        </div>
    </body>
</html>
