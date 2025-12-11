<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-widest">
                    Dashboard
                </p>
                <h2 class="mt-1 font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
                    Ringkasan Sistem & Aktivitas
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Data di bawah ini langsung keambil dari User, Topup, HTML Generation, dan Assets.
                </p>
            </div>

            <div class="flex items-center gap-3">
                <span class="hidden sm:inline-flex items-center text-xs px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300 border border-emerald-100 dark:border-emerald-800">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 mr-2 animate-pulse"></span>
                    Sistem aktif
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- TOP CARDS --}}
            <section>
                <div class="grid gap-4 sm:gap-6 md:grid-cols-2 xl:grid-cols-4">
                    {{-- Total User --}}
                    <div class="bg-white dark:bg-gray-900/60 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm p-5 flex flex-col justify-between">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                                    Total Pengguna
                                </p>
                                <p class="mt-2 text-2xl font-semibold text-gray-900 dark:text-gray-50">
                                    {{ number_format($totalUsers) }}
                                </p>
                            </div>
                            <span class="inline-flex items-center text-xs px-2.5 py-1 rounded-full bg-indigo-50 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-200">
                                {{ $usersGrowthText }}
                            </span>
                        </div>
                        <p class="mt-3 text-xs text-gray-500 dark:text-gray-400">
                            {{ number_format($verifiedUsers) }} user sudah verifikasi ({{ $conversionRate }}).
                        </p>
                    </div>

                    {{-- Points System --}}
                    <div class="bg-white dark:bg-gray-900/60 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm p-5 flex flex-col justify-between">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                                    Points System
                                </p>
                                <p class="mt-2 text-2xl font-semibold text-gray-900 dark:text-gray-50">
                                    {{ number_format($totalPoints) }} pts
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-[11px] text-gray-400 dark:text-gray-500">
                                    User aktif points:
                                </p>
                                <p class="text-sm font-semibold text-gray-800 dark:text-gray-100">
                                    {{ number_format($activePointsUsers) }} user
                                </p>
                            </div>
                        </div>
                        <p class="mt-3 text-xs text-gray-500 dark:text-gray-400">
                            Akumulasi total <span class="font-semibold">points</span> milik semua user.
                        </p>
                    </div>

                    {{-- Topup --}}
                    <div class="bg-white dark:bg-gray-900/60 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm p-5 flex flex-col justify-between">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                                    Topup Points
                                </p>
                                <p class="mt-2 text-2xl font-semibold text-gray-900 dark:text-gray-50">
                                    {{ number_format($topupPointsTotal) }} pts
                                </p>
                            </div>
                            <span class="inline-flex items-center text-xs px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-200">
                                Success {{ $topupSuccessRate }}
                            </span>
                        </div>
                        <p class="mt-3 text-xs text-gray-500 dark:text-gray-400">
                            {{ number_format($topupSuccess) }} success • {{ number_format($topupPending) }} pending • {{ number_format($topupFailed) }} failed
                        </p>
                    </div>

                    {{-- HTML Generation --}}
                    <div class="bg-white dark:bg-gray-900/60 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm p-5 flex flex-col justify-between">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                                    HTML Generated
                                </p>
                                <p class="mt-2 text-2xl font-semibold text-gray-900 dark:text-gray-50">
                                    {{ number_format($totalGenerations) }}
                                </p>
                            </div>
                            <span class="inline-flex items-center text-xs px-2.5 py-1 rounded-full bg-amber-50 text-amber-700 dark:bg-amber-900/40 dark:text-amber-200">
                                Done {{ $generationSuccessRate }}
                            </span>
                        </div>
                        <p class="mt-3 text-xs text-gray-500 dark:text-gray-400">
                            {{ number_format($completedGenerations) }} punya HTML lengkap.
                        </p>
                    </div>
                </div>
            </section>

            {{-- RINGKASAN DATA (TABLE GENERIC) --}}
            <section>
                <div class="bg-white dark:bg-gray-900/60 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm">
                    <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-50">
                                Ringkasan Data Sistem
                            </h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                Dibangun dari model: User, TopupTransaction, HtmlGeneration, HtmlAsset.
                            </p>
                        </div>
                    </div>

                    <div class="px-5 py-4 overflow-x-auto">
                        <table class="min-w-full text-xs">
                            <thead>
                                <tr class="text-left text-gray-400 dark:text-gray-500 border-b border-gray-100 dark:border-gray-800">
                                    <th class="py-2 pr-4">Resource</th>
                                    <th class="py-2 px-4">Total</th>
                                    <th class="py-2 px-4">Hari Ini</th>
                                    <th class="py-2 px-4">7 Hari Terakhir</th>
                                    <th class="py-2 px-4">Rate</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                @foreach($resources as $resource)
                                    <tr>
                                        <td class="py-2 pr-4 text-gray-800 dark:text-gray-100 font-medium">
                                            {{ $resource['label'] }}
                                        </td>
                                        <td class="py-2 px-4 text-gray-700 dark:text-gray-200">
                                            {{ number_format($resource['total']) }}
                                        </td>
                                        <td class="py-2 px-4 text-gray-700 dark:text-gray-200">
                                            {{ number_format($resource['today']) }}
                                        </td>
                                        <td class="py-2 px-4 text-gray-700 dark:text-gray-200">
                                            {{ number_format($resource['last7days']) }}
                                        </td>
                                        <td class="py-2 px-4 text-gray-700 dark:text-gray-200">
                                            {{ $resource['conversion'] ?? '—' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            {{-- ASSET BY LIBRARY + FAILED JOBS --}}
            <section class="grid gap-6 lg:grid-cols-3">
                {{-- Assets --}}
                <div class="lg:col-span-2 bg-white dark:bg-gray-900/60 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm">
                    <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-50">
                                Assets per Library
                            </h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                Total asset: {{ number_format($totalAssets) }} • Aktif: {{ number_format($activeAssets) }} ({{ $assetActiveRate }}).
                            </p>
                        </div>
                    </div>

                    <div class="px-5 py-4">
                        @if($assetsByLibrary->count())
                            <ul class="space-y-2 text-xs">
                                @foreach($assetsByLibrary as $row)
                                    <li class="flex items-center justify-between">
                                        <span class="text-gray-700 dark:text-gray-200">
                                            {{ $row->library ?? 'unknown' }}
                                        </span>
                                        <span class="text-gray-900 dark:text-gray-50 font-semibold">
                                            {{ $row->total }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                Belum ada asset tersimpan.
                            </p>
                        @endif
                    </div>
                </div>

                {{-- Error & Alert --}}
                <div class="bg-white dark:bg-gray-900/60 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm p-5">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-50 mb-2">
                        Error & Alert
                    </h3>
                    <p class="text-3xl font-semibold text-gray-900 dark:text-gray-50">
                        {{ $errorCount }}
                    </p>
                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                        Diambil dari tabel <code>failed_jobs</code>.
                    </p>
                    <p class="mt-4 text-xs text-gray-500 dark:text-gray-400">
                        @if($errorCount > 0)
                            Ada job yang gagal. Cek dan beresin queue / service.
                        @else
                            Tidak ada job gagal terdeteksi.
                        @endif
                    </p>
                </div>
            </section>

            {{-- AKTIVITAS TERBARU --}}
            <section class="grid gap-6 lg:grid-cols-3">
                {{-- User Terbaru --}}
                <div class="bg-white dark:bg-gray-900/60 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm lg:col-span-1">
                    <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-800">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-50">
                            User Terbaru
                        </h3>
                    </div>
                    <div class="px-5 py-4">
                        <ul class="space-y-3">
                            @forelse($recentUsers as $user)
                                <li class="flex items-start gap-3">
                                    <div class="mt-1 w-8 h-8 rounded-full bg-indigo-50 dark:bg-indigo-900/40 flex items-center justify-center">
                                        <span class="text-xs font-semibold text-indigo-700 dark:text-indigo-200">
                                            {{ strtoupper(mb_substr($user->name ?? 'U', 0, 1)) }}
                                        </span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {{ $user->name ?? 'User Tanpa Nama' }}
                                        </p>
                                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                            {{ $user->email }} • {{ optional($user->created_at)->diffForHumans() }}
                                        </p>
                                    </div>
                                </li>
                            @empty
                                <li class="text-xs text-gray-500 dark:text-gray-400">
                                    Belum ada user yang terdaftar.
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                {{-- Topup Terbaru --}}
                <div class="bg-white dark:bg-gray-900/60 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm lg:col-span-1">
                    <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-800">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-50">
                            Topup Terbaru
                        </h3>
                    </div>
                    <div class="px-5 py-4">
                        <ul class="space-y-3">
                            @forelse($recentTopups as $topup)
                                <li class="flex flex-col text-xs">
                                    <div class="flex items-center justify-between">
                                        <p class="font-medium text-gray-900 dark:text-gray-100">
                                            {{ optional($topup->user)->name ?? 'User #'.$topup->user_id }}
                                        </p>
                                        <span class="px-2 py-0.5 rounded-full text-[10px]
                                            @class([
                                                'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-200' => $topup->status === 'SUCCESS',
                                                'bg-amber-50 text-amber-700 dark:bg-amber-900/40 dark:text-amber-200' => $topup->status === 'PENDING',
                                                'bg-red-50 text-red-700 dark:bg-red-900/40 dark:text-red-200' => $topup->status === 'FAILED',
                                            ])
                                        ">
                                            {{ $topup->status ?? '-' }}
                                        </span>
                                    </div>
                                    <p class="mt-1 text-gray-600 dark:text-gray-300">
                                        {{ $topup->phone_number }} • {{ number_format($topup->amount_points) }} pts
                                    </p>
                                    <p class="mt-1 text-gray-400 dark:text-gray-500">
                                        {{ optional($topup->created_at)->diffForHumans() }}
                                    </p>
                                </li>
                            @empty
                                <li class="text-xs text-gray-500 dark:text-gray-400">
                                    Belum ada transaksi topup.
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                {{-- HTML Generation Terbaru --}}
                <div class="bg-white dark:bg-gray-900/60 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm lg:col-span-1">
                    <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-800">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-50">
                            HTML Generation Terbaru
                        </h3>
                    </div>
                    <div class="px-5 py-4">
                        <ul class="space-y-3 text-xs">
                            @forelse($recentGenerations as $gen)
                                <li class="flex flex-col">
                                    <div class="flex items-center justify-between">
                                        <p class="font-medium text-gray-900 dark:text-gray-100 truncate max-w-[160px]">
                                            {{ $gen->title ?? 'Tanpa Judul' }}
                                        </p>
                                        <span class="px-2 py-0.5 rounded-full text-[10px] bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                                            {{ $gen->library ?? 'unknown' }}
                                        </span>
                                    </div>
                                    <p class="mt-1 text-gray-600 dark:text-gray-300">
                                        {{ optional($gen->user)->name ?? 'User #'.$gen->user_id }}
                                    </p>
                                    <p class="mt-1 text-gray-400 dark:text-gray-500">
                                        Status: {{ $gen->status ?? '-' }} • {{ optional($gen->created_at)->diffForHumans() }}
                                    </p>
                                </li>
                            @empty
                                <li class="text-xs text-gray-500 dark:text-gray-400">
                                    Belum ada data HTML generation.
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </section>

            {{-- PANEL INFO AKUN (KANAN BAWAH / AKHIR) --}}
            <section>
                <div class="bg-white dark:bg-gray-900/60 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-50 mb-1">
                            Info Akun Kamu
                        </h3>
                        <p class="text-sm text-gray-700 dark:text-gray-200">
                            {{ auth()->user()->name }}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            {{ auth()->user()->email }} • Role: {{ auth()->user()->role ?? '-' }}
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        @if(Route::has('profile.edit'))
                            <a href="{{ route('profile.edit') }}"
                               class="inline-flex items-center px-3 py-1.5 text-xs rounded-lg border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                                Edit Profil
                            </a>
                        @endif

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button
                                type="submit"
                                class="inline-flex items-center px-3 py-1.5 text-xs rounded-lg border border-red-200 text-red-700 hover:bg-red-50 dark:border-red-800 dark:text-red-300 dark:hover:bg-red-900/30 transition"
                            >
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </section>

        </div>
    </div>
</x-app-layout>
