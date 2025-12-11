<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsurePhoneIsVerified
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        if (is_null($user->phone_verified_at)) {
            return redirect()->route('phone.verify.notice')
                ->with('status', 'Silakan verifikasi nomor HP kamu dulu.');
        }

        return $next($request);
    }
}
