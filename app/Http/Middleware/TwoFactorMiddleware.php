<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TwoFactorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $pekerja = Auth::guard('pekerja')->user();

        if (!$pekerja) {
            return redirect()->route('pekerja.login');
        }

        // Jika 2FA aktif tapi belum diverifikasi di session ini
        if ($pekerja->google2fa_enabled && !session('2fa_verified')) {
            return redirect()->route('pekerja.2fa.verify');
        }

        // Jika 2FA belum di-setup sama sekali
        if (!$pekerja->google2fa_enabled) {
            return redirect()->route('pekerja.2fa.setup');
        }

        return $next($request);
    }
}
