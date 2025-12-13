<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>{{ $title ?? 'HTML Generator' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Custom animations and styles */
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .slide-down {
            animation: slideDown 0.3s ease-out;
        }

        .glass-effect {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(148, 163, 184, 0.1);
        }

        .gradient-border {
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            padding: 1px;
        }

        .nav-link {
            position: relative;
            transition: all 0.3s ease;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6);
            transition: width 0.3s ease;
        }

        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
        }

        .points-badge {
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }

        .logout-btn {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .logout-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(239, 68, 68, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .logout-btn:hover::before {
            left: 100%;
        }

        .message-animation {
            animation: slideDown 0.5s ease-out;
        }

        .bg-pattern {
            background-image:
                radial-gradient(circle at 20% 30%, rgba(59, 130, 246, 0.1) 0%, transparent 25%),
                radial-gradient(circle at 80% 70%, rgba(139, 92, 246, 0.1) 0%, transparent 20%);
        }
    </style>
</head>
<body class="bg-slate-950 text-slate-100 antialiased min-h-screen bg-pattern">
    <div class="min-h-screen flex flex-col">
        <!-- Enhanced Header -->
        <header class="glass-effect border-b border-slate-800/50 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <!-- Logo/Brand -->
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                        <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-sm font-bold shadow-lg shadow-blue-500/25 group-hover:scale-105 transition-transform">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                            </svg>
                        </div>
                        <div>
                            <span class="font-bold text-lg tracking-tight bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent">HTML Generator</span>
                            <p class="text-xs text-slate-500">Create Amazing Content</p>
                        </div>
                    </a>

                    @auth
                        <!-- Navigation -->
                        <nav class="hidden md:flex items-center gap-6">
                            <a href="{{ route('generations.index') }}" class="nav-link text-sm font-medium text-slate-300 hover:text-white transition-colors flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                Generate
                            </a>
                            <a href="{{ route('topups.index') }}" class="nav-link text-sm font-medium text-slate-300 hover:text-white transition-colors flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Topup
                            </a>

                            @if (auth()->user()->isAdmin())
                                <a href="{{ route('admin.topups.index') }}" class="nav-link text-sm font-medium text-slate-300 hover:text-white transition-colors flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Admin
                                </a>
                            @endif
                        </nav>

                        <!-- User Section -->
                        <div class="flex items-center gap-4">
                            <!-- Points Badge -->
                            <div class="points-badge px-3 py-1.5 rounded-full flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                                </svg>
                                <span class="text-sm font-bold text-white">{{ number_format(auth()->user()->points) }}</span>
                                <span class="text-xs text-white/80">PTS</span>
                            </div>

                            <!-- User Avatar (Optional) -->
                            <div class="hidden sm:block">
                                <div class="h-8 w-8 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-xs font-bold text-white">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            </div>

                            <!-- Logout Button -->
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button
                                    type="submit"
                                    class="logout-btn px-4 py-2 rounded-lg border border-red-500/30 text-sm font-medium text-red-400 hover:border-red-500 hover:text-red-300 hover:bg-red-500/10 transition-all flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    @endauth
                </div>
            </div>

            <!-- Mobile Navigation -->
            @auth
                <div class="md:hidden border-t border-slate-800/50">
                    <nav class="flex justify-around py-2">
                        <a href="{{ route('generations.index') }}" class="flex flex-col items-center gap-1 py-2 px-3 text-xs text-slate-400 hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            Generate
                        </a>
                        <a href="{{ route('topups.index') }}" class="flex flex-col items-center gap-1 py-2 px-3 text-xs text-slate-400 hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Topup
                        </a>
                        @if (auth()->user()->isAdmin())
                            <a href="{{ route('admin.topups.index') }}" class="flex flex-col items-center gap-1 py-2 px-3 text-xs text-slate-400 hover:text-white transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Admin
                            </a>
                        @endif
                    </nav>
                </div>
            @endauth
        </header>

        <!-- Main Content -->
        <main class="flex-1">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <!-- Session Messages -->
                @if (session('status'))
                    <div class="message-animation mb-6 rounded-xl border border-emerald-500/40 bg-emerald-500/10 backdrop-blur-sm px-6 py-4 flex items-center gap-3">
                        <div class="flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-emerald-300">{{ session('status') }}</p>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="message-animation mb-6 rounded-xl border border-red-500/40 bg-red-500/10 backdrop-blur-sm px-6 py-4 flex items-center gap-3">
                        <div class="flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-red-300">{{ session('error') }}</p>
                        </div>
                    </div>
                @endif

                <!-- Content Slot -->
                <div class="slide-down px-3">
                    {{ $slot ?? '' }}
                    @yield('content')
                </div>
            </div>
        </main>

        <!-- Footer (Optional) -->
        <footer class="border-t border-slate-800/50 glass-effect">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                    <p class="text-xs text-slate-500">© {{ date('Y') }} HTML Generator. All rights reserved.</p>
                    <div class="flex items-center gap-4">
                        <a href="#" class="text-xs text-slate-500 hover:text-slate-400 transition-colors">Help</a>
                        <a href="#" class="text-xs text-slate-500 hover:text-slate-400 transition-colors">Privacy</a>
                        <a href="#" class="text-xs text-slate-500 hover:text-slate-400 transition-colors">Terms</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    @stack('scripts')
</body>
</html>
