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
    // Properti untuk kontrol halaman/step
    public $currentStep = 1;

    // Properti Langkah 1 (Sesuai dengan wire:model di Blade Anda)
    public $username; 
    public $email;
    public $password;
    public $password_confirmation;
    public $otp;
    public $terms = false;

    // Properti Langkah 2 (Sesuai dengan wire:model di Blade Anda)
    public $no_telp;
    public $jenis_kelamin;
    public $alamat;

    // Aturan dasar untuk real-time validation (hanya untuk Step 1)
    public function rules()
    {
        return [
            // Validasi unik diarahkan ke kolom 'nama_pelanggan' di database
            'username' => 'required|min:3|unique:' . Pelanggan::class . ',nama_pelanggan',
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
            logger($e->getMessage()); 
            session()->flash('error', 'Gagal mengirim email. Silakan cek konfigurasi mail server Anda.');
        }
    }

    public function register()
    {
        // ================= JIKA USER BERADA DI STEP 1 =================
        if ($this->currentStep == 1) {
            $this->validate();

            // Validasi Kode OTP yang dimasukkan user
            $otpCheck = DB::table('otps')
                ->where('email', $this->email)
                ->where('otp_code', $this->otp)
                ->where('expires_at', '>', Carbon::now())
                ->first();

            if (!$otpCheck) {
                $this->addError('otp', 'Kode OTP salah atau sudah kedaluwarsa!');
                return;
            }

            // Lanjut ke step 2
            $this->currentStep = 2;
            return;
        }

        // ================= JIKA USER BERADA DI STEP 2 =================
        if ($this->currentStep == 2) {
            // Validasi inputan step 2 (menggunakan nama properti Livewire)
            $this->validate([
                'no_telp'       => 'required|numeric|digits_between:10,14',
                'jenis_kelamin' => 'required|in:Pria,Wanita',
                'alamat'        => 'required|min:10',
            ], [
                'no_telp.required'       => 'Nomor telepon wajib diisi.',
                'no_telp.numeric'        => 'Nomor telepon harus berupa angka.',
                'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
                'jenis_kelamin.in'       => 'Pilihan jenis kelamin tidak valid.',
                'alamat.required'        => 'Alamat wajib diisi.',
                'alamat.min'             => 'Alamat minimal harus terdiri dari 10 karakter.',
            ]);

            // Logika simpan dengan pemetaan ke kolom asli database (Model Pelanggan)
            Pelanggan::create([
                'nama_pelanggan' => $this->username, // Memetakan $username ke kolom nama_pelanggan
                'email'          => $this->email,
                'password'       => Hash::make($this->password), 
                'no_telepon'     => $this->no_telp,  // Memetakan $no_telp ke kolom no_telepon
                'jenis_kelamin'  => $this->jenis_kelamin,
                'alamat'         => $this->alamat,
            ]);

            // Hapus OTP setelah sukses
            DB::table('otps')->where('email', $this->email)->delete();

            return redirect()->route('login')->with('success', 'Pendaftaran berhasil!');
        }
    }

    public function backToStepOne()
    {
        $this->currentStep = 1;
    }

    public function render()
    {
        return view('livewire.frontend.form.register');
    }
}