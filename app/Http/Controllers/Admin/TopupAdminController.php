<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TopupTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TopupAdminController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'WAITING_PAYMENT');

        $topups = TopupTransaction::with('user')
            ->when($status, fn ($q) => $q->where('status', $status))
            ->latest()
            ->paginate(20);

        return view('admin.topups.index', compact('topups', 'status'));
    }

    public function markPaid(TopupTransaction $topup)
    {
        if (! in_array($topup->status, ['PENDING', 'WAITING_PAYMENT'])) {
            return back()->with('error', 'Transaksi sudah tidak bisa diubah.');
        }

        DB::transaction(function () use ($topup) {
            $user = $topup->user;

            $user->increment('points', $topup->amount_points);

            $topup->update([
                'status' => 'PAID',
                'admin_id' => auth()->id(),
            ]);
        });

        return back()->with('status', 'Topup ditandai lunas. Poin user sudah ditambahkan.');
    }
}
