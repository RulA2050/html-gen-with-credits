<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BindSessionToClient
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $session = $request->session();

            $uaHash = hash('sha256', $request->userAgent() ?? '');
            $ip = $request->ip();
            $ipSubnet = implode('.', array_slice(explode('.', $ip), 0, 3));

            if (! $session->has('client_ua')) {
                $session->put('client_ua', $uaHash);
                $session->put('client_ip_subnet', $ipSubnet);
            } else {
                if ($session->get('client_ua') !== $uaHash) {
                    auth()->guard()->logout();
                    $session->invalidate();
                    $session->regenerateToken();
                    abort(401, 'Session invalid.');
                }

                if ($session->get('client_ip_subnet') !== $ipSubnet) {
                    auth()->guard()->logout();
                    $session->invalidate();
                    $session->regenerateToken();
                    abort(401, 'Session invalid.');
                }
            }
        }

        return $next($request);
    }
}
