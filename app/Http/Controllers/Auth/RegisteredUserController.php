<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\WhatsappService; // service WA yang udah kita pakai sebelumnya
use Illuminate\View\View;




class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */


    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'min:10', 'max:20', 'unique:users,phone_number'],
            'password' => ['required', 'confirmed', 'min:8'],
            // 'email'     => ['nullable', 'email', 'max:255', 'unique:users,email'], // opsional aja
        ]);

        $user = User::create([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'email' => $request->email ?? null,
            'password' => Hash::make($request->password),
            'role' => 'USER',
            'points' => 0,
        ]);

        // generate OTP 6 digit
        $code = (string) random_int(100000, 999999);

        $user->update([
            'phone_verification_code' => $code,
            'phone_verification_expires_at' => now()->addMinutes(10),
        ]);

        // kirim OTP ke WA (pakai service WA kamu)
        WhatsappService::sendVerificationCode($user->phone_number, $code);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('phone.verify.notice');
    }
}
