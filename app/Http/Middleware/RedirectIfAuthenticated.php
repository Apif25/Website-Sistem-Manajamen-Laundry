<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Redirect ke dashboard yang sesuai jika user sudah login.
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        foreach ($guards as $guard) {
            if ($guard && Auth::guard($guard)->check()) {
                return match ($guard) {
                    'pelanggan' => redirect()->route('pelanggan.dashboard'),
                    'pekerja'   => redirect()->route('pekerja.dashboard'),
                    default     => redirect('/'),
                };
            }
        }

        return $next($request);
    }
}
