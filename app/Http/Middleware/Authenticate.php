<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek apakah pelanggan BELUM login
        if (!Auth::guard('pelanggan')->check()) {

            // 2. Langsung lempar ke halaman login terpisah
            // Menggunakan route('login') memastikan Laravel mengingat halaman yang ingin dituju (intended)
            return redirect()->route('login'); 
        }

        return $next($request);
    }
}
