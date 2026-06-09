<?php

namespace App\Livewire\Frontend\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOtpMail;
use Carbon\Carbon;

#[Layout('frontend.layouts.auth')] 
#[Title('Halaman Pendaftaran Pelanggan')]
class Register extends Component
{
    public $username;
    public $email;
    public $password;
    public $password_confirmation;
    public $otp;
    public $terms = false;

    // Aturan dasar yang digunakan untuk real-time validation (jika ada)
    public function rules()
    {
        return [
            'username' => 'required|min:3|unique:' . Pelanggan::class . ',username',
            'email' => 'required|email|unique:' . Pelanggan::class . ',email',
            'password' => 'required|min:8|confirmed',
            'otp' => 'required|digits:6',
            'terms' => 'accepted',
        ];
    }

    public function sendOtp()
    {
        // 1. Validasi khusus email Saja secara ketat sebelum kirim OTP
        $this->validate([
            'email' => 'required|email|unique:' . Pelanggan::class . ',email',
        ]);

        // 2. Generate 6 digit angka random
        $generatedOtp = rand(100000, 999999);

        // 3. Simpan ke database 'otps'
        DB::table('otps')->where('email', $this->email)->delete();
        
        DB::table('otps')->insert([
            'email' => $this->email,
            'otp_code' => $generatedOtp,
            'expires_at' => Carbon::now()->addMinutes(5),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // 4. Kirim Email dengan try-catch yang lebih aman
        try {
            Mail::to($this->email)->send(new SendOtpMail($generatedOtp));
            session()->flash('message', 'Kode OTP telah dikirim ke email ' . $this->email);
        } catch (\Exception $e) {
            // Log error asli agar Anda bisa cek via `storage/logs/laravel.log` jika gagal
            logger($e->getMessage()); 
            session()->flash('error', 'Gagal mengirim email. Silakan cek konfigurasi mail server Anda.');
        }
    }

    public function register()
    {
        // 5. Validasi menyeluruh saat tombol Register ditekan
        $this->validate();

        // 6. Validasi Kode OTP yang dimasukkan user
        $otpCheck = DB::table('otps')
            ->where('email', $this->email)
            ->where('otp_code', $this->otp)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (!$otpCheck) {
            $this->addError('otp', 'Kode OTP salah atau sudah kedaluwarsa!');
            return;
        }

        // 7. Logika simpan user ke tabel pelanggan
        Pelanggan::create([
            'username' => $this->username,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        // Hapus OTP setelah sukses
        DB::table('otps')->where('email', $this->email)->delete();

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil!');
    }

    public function render()
    {
        return view('livewire.frontend.form.register');
    }
}