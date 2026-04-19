<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TwoFAMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return $next($request);
        }

        $user = auth()->user();

        // Kalau belum aktifkan 2FA → paksa setup
        if (!$user->google2fa_enabled && !$request->is('2fa/*')) {
            return redirect(route('2fa.setup'));
        }
        
        return $next($request);
    }
}
