<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureAccessCodeExists
{
    public function handle(Request $request, Closure $next)
    {
        $pekerja = auth('pekerja')->user();

        // 1. BELUM PERNAH BUAT KODE
        if (!$pekerja->access_code) {
            return redirect()->route('pekerja.access-code.create', [
                'redirect' => $request->fullUrl()
            ]);
        }

        // 2. SUDAH PUNYA KODE TAPI BELUM VERIFIKASI SESSION
        if (!session('access_code_verified')) {
            return redirect()->route('pekerja.access-code.verify', [
                'redirect' => $request->fullUrl()
            ]);
        }

        return $next($request);
    }
}
