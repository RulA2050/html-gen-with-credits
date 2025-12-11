<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\WhatsappService;
use Illuminate\Http\Request;

class PhoneVerificationController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();

        if ($user->phone_verified_at) {
            return redirect()->route('dashboard');
        }

        return view('auth.verify-phone', [
            'phone_number' => $user->phone_number,
        ]);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'code' => ['required', 'digits:6'],
        ]);

        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        if ($user->phone_verified_at) {
            return redirect()->route('dashboard');
        }

        if (
            $user->phone_verification_code !== $request->code ||
            ! $user->phone_verification_expires_at ||
            now()->greaterThan($user->phone_verification_expires_at)
        ) {
            return back()->withErrors([
                'code' => 'Kode salah atau sudah kadaluarsa.',
            ]);
        }

        $user->update([
            'phone_verified_at'             => now(),
            'phone_verification_code'       => null,
            'phone_verification_expires_at' => null,
        ]);

        return redirect()->route('dashboard')
            ->with('status', 'Nomor HP berhasil diverifikasi.');
    }

    public function resend(Request $request)
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        if ($user->phone_verified_at) {
            return redirect()->route('dashboard');
        }

        $code = (string) random_int(100000, 999999);

        $user->update([
            'phone_verification_code'        => $code,
            'phone_verification_expires_at'  => now()->addMinutes(10),
        ]);

        WhatsappService::sendVerificationCode($user->phone_number, $code);

        return back()->with('status', 'Kode baru sudah dikirim ke WhatsApp kamu.');
    }
}
