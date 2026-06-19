<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')
            ->scopes([
                'openid',
                'profile',
                'email',
                'https://www.googleapis.com/auth/userinfo.profile',
            ])
            ->with(['access_type' => 'offline', 'prompt' => 'consent'])
            ->redirect();
    }

    public function callback()
    {
        try {

            $googleUser = Socialite::driver('google')->stateless()->user();

            $pelanggan = Pelanggan::where('email', $googleUser->getEmail())
                ->orWhere('google_id', $googleUser->getId())
                ->first();

            if (!$pelanggan) {

                $pelanggan = Pelanggan::create([
                    'google_id'        => $googleUser->getId(),
                    'nama_pelanggan'   => $googleUser->getName(),
                    'email'            => $googleUser->getEmail(),
                    'password'         => Str::random(32),
                    'foto_profil'      => $googleUser->getAvatar(),

                    // 🔥 PENTING UNTUK REVOKE
                    'google_token'     => $googleUser->token ?? null,
                    'google_refresh_token' => $googleUser->refreshToken ?? null,

                    'email_verified_at' => now(),
                ]);
            } else {

                $pelanggan->update([
                    'google_id'            => $googleUser->getId(),
                    'foto_profil'          => $googleUser->getAvatar(),

                    // update token setiap login
                    'google_token'         => $googleUser->token ?? null,
                    'google_refresh_token' => $googleUser->refreshToken ?? null,
                ]);
            }

            Auth::guard('pelanggan')->login($pelanggan, true);

            return redirect()->route('pelanggan.beranda')
                ->with('success', 'Login Google berhasil!');
        } catch (\Exception $e) {

            return redirect()->route('login')
                ->with('error', 'Login Google gagal: ' . $e->getMessage());
        }
    }
}
