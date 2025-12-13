<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TopupTransaction;
use App\Models\HtmlGeneration;
use App\Models\HtmlAsset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $today   = now()->toDateString();
        $weekAgo = now()->subDays(7);

        /**
         * ========================
         * USER & POINTS METRICS
         * ========================
         */
        $totalUsers        = User::count();
        $verifiedUsers     = User::whereNotNull('email_verified_at')->count();
        $todayNewUsers     = User::whereDate('created_at', $today)->count();
        $last7DaysUsers    = User::whereBetween('created_at', [$weekAgo, now()])->count();
        $totalPoints       = User::sum('points');
        $activePointsUsers = User::where('points', '>', 0)->count();

        if ($last7DaysUsers > 0) {
            $prevPeriod = max($totalUsers - $last7DaysUsers, 1);
            $usersGrowthText = sprintf('+%.1f%% vs periode sebelumnya', ($last7DaysUsers / $prevPeriod) * 100);
        } else {
            $usersGrowthText = 'Belum ada growth yang signifikan';
        }

        $conversionRate = $totalUsers > 0
            ? round(($verifiedUsers / $totalUsers) * 100, 1) . '%'
            : '0%';

        /**
         * ========================
         * TOPUP METRICS
         * ========================
         */
        $totalTopup     = TopupTransaction::count();
        $topupToday     = TopupTransaction::whereDate('created_at', $today)->count();
        $topupLast7     = TopupTransaction::whereBetween('created_at', [$weekAgo, now()])->count();

        $topupSuccess   = TopupTransaction::where('status', 'PAID')->count();
        $topupPending   = TopupTransaction::where('status', 'PENDING')->count();
        $topupFailed    = TopupTransaction::where('status', 'CANCELLED')->count();

        $topupSuccessRate = $totalTopup > 0
            ? round(($topupSuccess / $totalTopup) * 100, 1) . '%'
            : '0%';

        $topupPointsTotal = TopupTransaction::where('status', 'PAID')->sum('amount_points');

        /**
         * ========================
         * HTML GENERATION METRICS
         * ========================
         */
        $totalGenerations   = HtmlGeneration::count();
        $generationToday    = HtmlGeneration::whereDate('created_at', $today)->count();
        $generationLast7    = HtmlGeneration::whereBetween('created_at', [$weekAgo, now()])->count();

        // anggap "berhasil" kalau sudah punya html_full
        $completedGenerations = HtmlGeneration::whereNotNull('html_full')->count();

        $generationSuccessRate = $totalGenerations > 0
            ? round(($completedGenerations / $totalGenerations) * 100, 1) . '%'
            : '0%';

        // breakdown status, kalau mau dipakai di view
        $generationStatusBreakdown = HtmlGeneration::select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->get();

        /**
         * ========================
         * ASSET METRICS
         * ========================
         */
        $totalAssets   = HtmlAsset::count();
        $activeAssets  = HtmlAsset::where('is_active', true)->count();

        $assetActiveRate = $totalAssets > 0
            ? round(($activeAssets / $totalAssets) * 100, 1) . '%'
            : '0%';

        $assetsByLibrary = HtmlAsset::select('library', DB::raw('COUNT(*) as total'))
            ->groupBy('library')
            ->orderBy('library')
            ->get();

        /**
         * ========================
         * FAILED JOBS (kalau ada)
         * ========================
         */
        if (Schema::hasTable('failed_jobs')) {
            $errorCount = DB::table('failed_jobs')->count();
        } else {
            $errorCount = 0;
        }
        $errorCount += HtmlGeneration::where('status', 'FAILED')->count();

        /**
         * ========================
         * RECENT ACTIVITY
         * ========================
         */
        $recentUsers = User::latest()->take(5)->get();
        // Samarkan email dan nomor hp(Jika ada)
        for($i = 0; $i < count($recentUsers); $i++) {
            $email = $recentUsers[$i]->email;
            $atPos = strpos($email, '@');
            if ($atPos !== false) {
                $recentUsers[$i]->email = substr($email, 0, 2) . str_repeat('*', $atPos - 2) . substr($email, $atPos);
            }
            $num = $recentUsers[$i]->phone_number;
            if (strlen($num) >= 7) {
                $recentUsers[$i]->phone_number = substr($num, 0, 3) . str_repeat('*', strlen($num) - 6) . substr($num, -3);
            }
        }

        $recentTopups = TopupTransaction::with(['user', 'admin'])
            ->latest()
            ->take(5)
            ->get();
        // Nomor Hp disamarkan
        for($i = 0; $i < count($recentTopups); $i++) {
            $num = $recentTopups[$i]->phone_number;
            if (strlen($num) >= 7) {
                $recentTopups[$i]->phone_number = substr($num, 0, 3) . str_repeat('*', strlen($num) - 6) . substr($num, -3);
            }
        }



        $recentGenerations = HtmlGeneration::with('user')
            ->latest()
            ->take(5)
            ->get();

        /**
         * ========================
         * GENERIC RESOURCES TABLE
         * ========================
         */
        $resources = [
            [
                'key'        => 'users',
                'label'      => 'Pengguna',
                'total'      => $totalUsers,
                'today'      => $todayNewUsers,
                'last7days'  => $last7DaysUsers,
                'conversion' => $conversionRate,
            ],
            [
                'key'        => 'topups',
                'label'      => 'Topup Points',
                'total'      => $totalTopup,
                'today'      => $topupToday,
                'last7days'  => $topupLast7,
                'conversion' => $topupSuccessRate,
            ],
            [
                'key'        => 'generations',
                'label'      => 'HTML Generated',
                'total'      => $totalGenerations,
                'today'      => $generationToday,
                'last7days'  => $generationLast7,
                'conversion' => $generationSuccessRate,
            ],
            [
                'key'        => 'assets',
                'label'      => 'HTML Assets',
                'total'      => $totalAssets,
                'today'      => 0,
                'last7days'  => 0,
                'conversion' => $assetActiveRate,
            ],
        ];

        return view('dashboard', [
            // user
            'totalUsers'        => $totalUsers,
            'verifiedUsers'     => $verifiedUsers,
            'todayNewUsers'     => $todayNewUsers,
            'last7DaysUsers'    => $last7DaysUsers,
            'usersGrowthText'   => $usersGrowthText,
            'conversionRate'    => $conversionRate,
            'totalPoints'       => $totalPoints,
            'activePointsUsers' => $activePointsUsers,

            // topup
            'totalTopup'        => $totalTopup,
            'topupToday'        => $topupToday,
            'topupLast7'        => $topupLast7,
            'topupSuccess'      => $topupSuccess,
            'topupPending'      => $topupPending,
            'topupFailed'       => $topupFailed,
            'topupSuccessRate'  => $topupSuccessRate,
            'topupPointsTotal'  => $topupPointsTotal,

            // generation
            'totalGenerations'        => $totalGenerations,
            'generationToday'         => $generationToday,
            'generationLast7'         => $generationLast7,
            'completedGenerations'    => $completedGenerations,
            'generationSuccessRate'   => $generationSuccessRate,
            'generationStatusBreakdown' => $generationStatusBreakdown,

            // assets
            'totalAssets'      => $totalAssets,
            'activeAssets'     => $activeAssets,
            'assetActiveRate'  => $assetActiveRate,
            'assetsByLibrary'  => $assetsByLibrary,

            // error & activity
            'errorCount'       => $errorCount,
            'recentUsers'      => $recentUsers,
            'recentTopups'     => $recentTopups,
            'recentGenerations'=> $recentGenerations,

            // generic table
            'resources'        => $resources,
        ]);
    }
}
