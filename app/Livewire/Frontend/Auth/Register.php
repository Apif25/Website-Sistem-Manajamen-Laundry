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
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;

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
    public $foto_profil;

    // Properti Alamat Utama
    public $label_alamat = 'Rumah';
    public $province_id = '';
    public $regency_id = '';
    public $district_id = '';
    public $alamat_lengkap = '';

    // Dropdown Options
    public $provinces = [];
    public $regencies = [];
    public $districts = [];

    public function mount()
    {
        $this->provinces = \Laravolt\Indonesia\Models\Province::orderBy('name')->get();
    }

    public function updatedProvinceId($value): void
    {
        $this->regency_id = '';
        $this->district_id = '';
        $this->regencies = [];
        $this->districts = [];

        if (!empty($value)) {
            $province = \Laravolt\Indonesia\Models\Province::find($value);
            if ($province) {
                $this->regencies = \Laravolt\Indonesia\Models\City::where('province_code', $province->code)->orderBy('name')->get();
            }
        }
    }

    public function updatedRegencyId($value): void
    {
        $this->district_id = '';
        $this->districts = [];

        if (!empty($value)) {
            $city = \Laravolt\Indonesia\Models\City::find($value);
            if ($city) {
                $this->districts = \Laravolt\Indonesia\Models\District::where('city_code', $city->code)->orderBy('name')->get();
            }
        }
    }
    public function rules()
    {
        return [
            'username' => 'required|min:3|unique:' . Pelanggan::class . ',nama_pelanggan',
            'email' => 'required|email|unique:' . Pelanggan::class . ',email',
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase() // huruf besar & kecil
                    ->numbers()   // angka
                    ->symbols(),  // karakter khusus
            ],
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
            // 4. Tambahkan validasi untuk foto_profil & Alamat Utama di Step 2
            $this->validate([
                'no_telp'        => 'required|numeric|digits_between:10,14',
                'jenis_kelamin'  => 'required|in:Pria,Wanita',
                'foto_profil'    => 'nullable|image|max:2048', // Opsional, harus gambar, maks 2MB
                'label_alamat'   => 'required|string|max:50',
                'province_id'    => 'required|integer',
                'regency_id'     => 'required|integer',
                'district_id'    => 'required|integer',
                'alamat_lengkap' => 'required|string|min:5',
            ], [
                'no_telp.required'        => 'Nomor telepon wajib diisi.',
                'no_telp.numeric'         => 'Nomor telepon harus berupa angka.',
                'jenis_kelamin.required'  => 'Jenis kelamin wajib dipilih.',
                'jenis_kelamin.in'        => 'Pilihan jenis kelamin tidak valid.',
                'foto_profil.image'       => 'File harus berupa gambar (jpg, jpeg, png).',
                'foto_profil.max'         => 'Ukuran foto maksimal adalah 2MB.',
                'label_alamat.required'   => 'Label alamat wajib diisi.',
                'province_id.required'    => 'Provinsi wajib dipilih.',
                'regency_id.required'     => 'Kota/Kabupaten wajib dipilih.',
                'district_id.required'    => 'Kecamatan wajib dipilih.',
                'alamat_lengkap.required' => 'Alamat lengkap wajib diisi.',
                'alamat_lengkap.min'      => 'Alamat lengkap minimal 5 karakter.',
            ]);

            // 5. Logika penyimpanan file foto jika diunggah
            $namaFoto = null;
            if ($this->foto_profil) {
                // Menyimpan file ke folder 'storage/app/public/foto-pelanggan'
                // hashName() digunakan agar nama file unik secara otomatis
                $namaFoto = $this->foto_profil->hashName();
                $this->foto_profil->storeAs(
                    'pelanggan/foto-pelanggan',
                    $namaFoto,
                    'public'
                );
            }

            // Logika simpan ke database
            $pelanggan = Pelanggan::create([
                'nama_pelanggan' => $this->username,
                'email'          => $this->email,
                'password'       => Hash::make($this->password),
                'no_telepon'     => $this->no_telp,
                'jenis_kelamin'  => $this->jenis_kelamin,
                'foto_profil'    => $namaFoto, // 6. Simpan nama file ke kolom foto_profil
            ]);

            // Simpan alamat utama pelanggan
            $pelanggan->alamat()->create([
                'label_alamat'   => $this->label_alamat,
                'province_id'    => $this->province_id,
                'regency_id'     => $this->regency_id,
                'district_id'    => $this->district_id,
                'alamat_lengkap' => $this->alamat_lengkap,
                'is_utama'       => true,
            ]);

            DB::table('otps')->where('email', $this->email)->delete();

            // Login otomatis setelah register
            Auth::guard('pelanggan')->login($pelanggan);

            // Set session verifikasi 2FA kosong
            session()->forget('pelanggan_2fa_verified');

            session()->flash(
                'success',
                'Pendaftaran berhasil. Silakan aktifkan Google Authenticator.'
            );

            return redirect()->route('pelanggan.setup-2fa');
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
