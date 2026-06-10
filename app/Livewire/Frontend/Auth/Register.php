<?php

namespace App\Livewire\Frontend\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithFileUploads;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOtpMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\RateLimiter;

#[Layout('frontend.layouts.auth')]
#[Title('Halaman Pendaftaran Pelanggan')]
class Register extends Component
{
    use WithFileUploads;

    // Properti untuk kontrol halaman/step
    public $currentStep = 1;

    // Properti Langkah 1
    public $username;
    public $email;
    public $password;
    public $password_confirmation;
    public $otp;
    public $terms = false;

    // Properti Langkah 2
    public $no_telp;
    public $jenis_kelamin;
    public $alamat;
    public $foto_profil;
    public function rules()
    {
        return [
            'username' => 'required|min:3|unique:' . Pelanggan::class . ',nama_pelanggan',
            'email' => 'required|email|unique:' . Pelanggan::class . ',email',
            'password' => 'required|min:8|confirmed',
            'otp' => 'required|digits:6',
            'terms' => 'accepted',
        ];
    }

    public function sendOtp()
    {
        // Rate Limit: maksimal 3 kali dalam 5 menit per email
        $key = 'send-otp:' . $this->email;

        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);

            session()->flash(
                'error',
                'Terlalu banyak permintaan OTP. Silakan coba lagi dalam ' . ceil($seconds / 60) . ' menit.'
            );

            return;
        }

        RateLimiter::hit($key, 300); // 300 detik = 5 menit

        $this->validate([
            'email' => 'required|email|unique:' . Pelanggan::class . ',email',
        ]);

        $generatedOtp = rand(100000, 999999);

        DB::table('otps')->where('email', $this->email)->delete();

        DB::table('otps')->insert([
            'email' => $this->email,
            'otp_code' => $generatedOtp,
            'expires_at' => Carbon::now()->addMinutes(5),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        try {
            Mail::to($this->email)->send(new SendOtpMail($generatedOtp));

            session()->flash(
                'message',
                'Kode OTP telah dikirim ke email ' . $this->email
            );
        } catch (\Exception $e) {
            logger($e->getMessage());

            session()->flash(
                'error',
                'Gagal mengirim email. Silakan cek konfigurasi mail server Anda.'
            );
        }
    }

    public function register()
    {
        // ================= JIKA USER BERADA DI STEP 1 =================
        if ($this->currentStep == 1) {
            $this->validate();

            $otpCheck = DB::table('otps')
                ->where('email', $this->email)
                ->where('otp_code', $this->otp)
                ->where('expires_at', '>', Carbon::now())
                ->first();

            if (!$otpCheck) {
                $this->addError('otp', 'Kode OTP salah atau sudah kedaluwarsa!');
                return;
            }

            $this->currentStep = 2;
            return;
        }

        // ================= JIKA USER BERADA DI STEP 2 =================
        if ($this->currentStep == 2) {
            // 4. Tambahkan validasi untuk foto_profil di Step 2
            $this->validate([
                'no_telp'       => 'required|numeric|digits_between:10,14',
                'jenis_kelamin' => 'required|in:Pria,Wanita',
                'alamat'        => 'required|min:10',
                'foto_profil'   => 'nullable|image|max:2048', // Opsional, harus gambar, maks 2MB
            ], [
                'no_telp.required'       => 'Nomor telepon wajib diisi.',
                'no_telp.numeric'        => 'Nomor telepon harus berupa angka.',
                'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
                'jenis_kelamin.in'       => 'Pilihan jenis kelamin tidak valid.',
                'alamat.required'        => 'Alamat wajib diisi.',
                'alamat.min'             => 'Alamat minimal harus terdiri dari 10 karakter.',
                'foto_profil.image'      => 'File harus berupa gambar (jpg, jpeg, png).',
                'foto_profil.max'        => 'Ukuran foto maksimal adalah 2MB.',
            ]);

            // 5. Logika penyimpanan file foto jika diunggah
            $namaFoto = null;
            if ($this->foto_profil) {
                // Menyimpan file ke folder 'storage/app/public/foto-pelanggan'
                // hashName() digunakan agar nama file unik secara otomatis
                $namaFoto = $this->foto_profil->hashName();
                $this->foto_profil->storeAs('foto-pelanggan', $namaFoto, 'public');
            }

            // Logika simpan ke database
            Pelanggan::create([
                'nama_pelanggan' => $this->username,
                'email'          => $this->email,
                'password'       => Hash::make($this->password),
                'no_telepon'     => $this->no_telp,
                'jenis_kelamin'  => $this->jenis_kelamin,
                'alamat'         => $this->alamat,
                'foto_profil'    => $namaFoto, // 6. Simpan nama file ke kolom foto_profil
            ]);

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