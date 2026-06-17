<?php

namespace App\Livewire\Frontend\Auth;

use App\Mail\ResetPasswordOtpMail;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;

#[Layout('frontend.layouts.auth')]
#[Title('Halaman Lupa Password')]
class ForgotPassword extends Component
{
    public $email = '';
    public $otp = '';
    public $password = '';
    public $password_confirmation = '';

    public $step = 1;

    public function sendOtp()
    {
        $this->validate([
            'email' => 'required|email'
        ]);

        $pelanggan = Pelanggan::where('email', $this->email)->first();

        if (!$pelanggan) {
            $this->addError('email', 'Email tidak ditemukan.');
            return;
        }

        $otp = rand(100000, 999999);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $this->email],
            [
                'token' => $otp,
                'expires_at' => now()->addMinutes(10),
                'created_at' => now(),
            ]
        );

        Mail::to($this->email)
            ->send(new ResetPasswordOtpMail($otp));

        $this->step = 2;

        session()->flash(
            'success',
            'Kode OTP berhasil dikirim.'
        );
    }

    public function verifyOtp()
    {
        $token = DB::table('password_reset_tokens')
            ->where('email', $this->email)
            ->where('token', $this->otp)
            ->first();

        if (!$token) {
            $this->addError('otp', 'OTP tidak valid.');
            return;
        }

        if (now()->gt($token->expires_at)) {
            $this->addError('otp', 'OTP sudah kadaluarsa.');
            return;
        }

        $this->step = 3;
    }

    public function resetPassword()
    {
        $this->validate([
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase()   // huruf besar & kecil
                    ->numbers()     // angka
                    ->symbols(),    // simbol
            ],
        ]);

        Pelanggan::where('email', $this->email)
            ->update([
                'password' => Hash::make($this->password)
            ]);

        DB::table('password_reset_tokens')
            ->where('email', $this->email)
            ->delete();

        session()->flash(
            'success',
            'Password berhasil diubah.'
        );

        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.frontend.auth.forgot-password');
    }
}
