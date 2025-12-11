<?php

namespace App\Http\Controllers;

use App\Models\TopupTransaction;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TopupController extends Controller
{
    protected $pricePoints ;
    protected $usingPoints ;

    public function __construct()
    {
        $this->pricePoints = config('app.price_points', 50000);
        $this->usingPoints = config('app.using_points', 5);
    }

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
        $pricePoints = $this->pricePoints;
        $usingPoints = $this->usingPoints;
        $phoneNumber = Auth::user()->phone_number;
        return view('topups.create', compact('pricePoints', 'usingPoints', 'phoneNumber'));
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
            'amount_points' => 'required|integer|min:3',
        ]);
        $usingPoints = $this->usingPoints;
        // Cek Amout poin harus kelipatan 3
        if ($data['amount_points'] % $usingPoints !== 0) {
            return back()->withErrors(['amount_points' => 'Jumlah poin harus kelipatan 3.'])->withInput();
        }


        $user = Auth::user();

        $topup = TopupTransaction::create([
            'user_id' => $user->id,
            'phone_number' => $user->phone_number,
            'amount_points' => $data['amount_points'],
            'status' => 'PENDING',
        ]);

        $message = "Topup Poin Generate HTML\n"
            . "User ID: {$user->id}\n"
            . "Nama: {$user->name}\n"
            . "Email: {$user->email}\n"
            . "Nomor HP: {$user->phone_number}\n"
            . "Paket: {$data['amount_points']} poin\n"
            . "Kode Transaksi: RXGT#TU#{$topup->id}\n\n"
            . 'Silakan lakukan pembayaran sebesar Rp ' . number_format($data['amount_points'] * $this->pricePoints / $this->usingPoints, 0, ',', '.') . "\n"
            . "Nomor Admin: {$adminPhoneNumber}\n"
            . "Silakan forward pesan ini ke Admin untuk instruksi pembayaran.\n\n"
            ;

        $clientId = config('services.wacserv.client_id');

        try {
            if ($clientId) {
                $wa->sendMessage($user->id, $user->phone_number, $message, $clientId);

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
