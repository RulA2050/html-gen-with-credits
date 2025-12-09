<?php

namespace App\Http\Controllers;

use App\Models\TopupTransaction;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TopupController extends Controller
{
    public function index()
    {
        $topups = Auth::user()
            ->topups()
            ->latest()
            ->paginate(10);

        return view('topups.index', compact('topups'));
    }

    public function create()
    {
        return view('topups.create');
    }

    public function store(Request $request, WhatsAppService $wa)
    {
        $adminPhoneNumber = config('services.wacserv.admin_phone_number');
        $adminPhoneNumber = preg_replace('/\D/', '', $adminPhoneNumber);
        // Admin phone number must be set 6281234567890 format
        $adminPhoneNumber = ltrim($adminPhoneNumber, '0');
        if (str_starts_with($adminPhoneNumber, '8')) {
            $adminPhoneNumber = '62' . $adminPhoneNumber;
        }
        $data = $request->validate([
            'phone_number' => 'required|string|max:20',
            'amount_points' => 'required|integer|min:1',
        ]);

        $user = Auth::user();

        $topup = TopupTransaction::create([
            'user_id' => $user->id,
            'phone_number' => $data['phone_number'],
            'amount_points' => $data['amount_points'],
            'status' => 'PENDING',
        ]);

        $message = "Topup Poin Generate HTML\n"
            . "User ID: {$user->id}\n"
            . "Nama: {$user->name}\n"
            . "Email: {$user->email}\n"
            . "Nomor HP: {$data['phone_number']}\n"
            . "Paket: {$data['amount_points']} poin\n"
            . "Kode Transaksi: T{$topup->id}\n\n"
            . "Nomor Admin: {$adminPhoneNumber}\n"
            . "Silakan forward pesan ini ke Admin untuk instruksi pembayaran.\n\n"
            ;

        $clientId = config('services.wacserv.client_ids')[0] ?? null;

        try {
            if ($clientId) {
                $wa->sendMessage($user->id, $data['phone_number'], $message, $clientId);

                $topup->update([
                    'status' => 'WAITING_PAYMENT',
                    'wa_sent_at' => now(),
                    'wa_payload' => ['client_id' => $clientId],
                ]);
            }
        } catch (\Throwable $e) {
            // Log the error but don't block the user
            \Log::error('Failed to send WA message for topup: ' . $e->getMessage());
        }

        return redirect()
            ->route('topups.index')
            ->with('status', 'Permintaan topup dibuat. Cek WhatsApp dan teruskan pesan ke admin.');
    }
}
