<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>{{ $title ?? 'HTML Generator' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-950 text-slate-100 antialiased">
    <div class="min-h-screen flex flex-col">
        <header class="border-b border-slate-800 bg-slate-900/90 backdrop-blur">
            <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                    <div class="h-8 w-8 rounded-lg bg-gradient-to-br from-primary to-primary-dark flex items-center justify-center text-xs font-bold">
                        HG
                    </div>
                    <span class="font-semibold tracking-tight text-sm">HTML Generator</span>
                </a>
                @auth
                    <nav class="flex items-center gap-4 text-xs">
                        <a href="{{ route('generations.index') }}" class="hover:text-primary">
                            Generate
                        </a>
                        <a href="{{ route('topups.index') }}" class="hover:text-primary">
                            Topup
                        </a>

                        @if (auth()->user()->isAdmin())
                            <a href="{{ route('admin.topups.index') }}" class="hover:text-primary">
                                Admin
                            </a>
                        @endif

                        <span class="text-slate-500">
                            Poin:
                            <span class="text-primary font-medium">
                                {{ auth()->user()->points }}
                            </span>
                        </span>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button
                                class="px-3 py-1.5 rounded-md border border-slate-700 text-[11px] font-medium hover:border-primary hover:text-primary transition">
                                Logout
                            </button>
                        </form>
                    </nav>
                @endauth
            </div>
        </header>

        <main class="flex-1">
            <div class="max-w-6xl mx-auto px-4 py-8">
                @if (session('status'))
                    <div class="mb-4 rounded-md border border-emerald-500/40 bg-emerald-500/10 px-4 py-2 text-sm">
                        {{ session('status') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="mb-4 rounded-md border border-red-500/40 bg-red-500/10 px-4 py-2 text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                {{ $slot ?? '' }}
                @yield('content')
            </div>
        </main>
    </div>

    @stack('scripts')
</body>
</html>
