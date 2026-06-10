<?php

namespace App\Livewire\Frontend\Profile;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Pelanggan;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('frontend.layouts.app')]
#[Title('Profil Anda')]
class Index extends Component
{
    use WithFileUploads;

    public string $nama_pelanggan = '';
    public string $email = '';
    public string $no_telepon = '';
    public string $jenis_kelamin = '';
    public string $password = '';
    public string $password_confirmation = '';

    public $foto_profil = null;
    public ?string $foto_profil_existing = null;

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

    public function mount(): void
    {
        $pelanggan = Auth::guard('pelanggan')->user();

        if (!$pelanggan) {
            abort(403, 'Akses tidak sah.');
        }

        $this->nama_pelanggan  = $pelanggan->nama_pelanggan;
        $this->email           = $pelanggan->email;
        $this->no_telepon      = $pelanggan->no_telepon;
        $this->jenis_kelamin   = $pelanggan->jenis_kelamin;
        $this->foto_profil_existing = $pelanggan->foto_profil;

        // Ambil alamat utama/pertama
        $alamat = $pelanggan->alamat()->first();
        if ($alamat) {
            $this->label_alamat   = $alamat->label_alamat;
            $this->province_id    = $alamat->province_id;
            $this->regency_id     = $alamat->regency_id;
            $this->district_id    = $alamat->district_id;
            $this->alamat_lengkap = $alamat->alamat_lengkap;
        }

        $this->provinces = \Laravolt\Indonesia\Models\Province::orderBy('name')->get();

        if ($this->province_id) {
            $province = \Laravolt\Indonesia\Models\Province::find($this->province_id);
            if ($province) {
                $this->regencies = \Laravolt\Indonesia\Models\City::where('province_code', $province->code)->orderBy('name')->get();
            }
        }

        if ($this->regency_id) {
            $city = \Laravolt\Indonesia\Models\City::find($this->regency_id);
            if ($city) {
                $this->districts = \Laravolt\Indonesia\Models\District::where('city_code', $city->code)->orderBy('name')->get();
            }
        }
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

    public function save(): void
    {
        $id = Auth::guard('pelanggan')->id();

        $this->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'email'          => 'required|email|max:255|unique:Pelanggan,email,' . $id . ',id_pelanggan',
            'no_telepon'     => 'required|numeric|digits_between:10,14',
            'jenis_kelamin'  => 'required|in:Pria,Wanita',
            'foto_profil'    => 'nullable|image|max:2048',
            'label_alamat'   => 'required|string|max:50',
            'province_id'    => 'required|integer',
            'regency_id'     => 'required|integer',
            'district_id'    => 'required|integer',
            'alamat_lengkap' => 'required|string|min:5',
            'password'       => 'nullable|min:8|confirmed',
        ], [
            'nama_pelanggan.required' => 'Nama wajib diisi.',
            'email.required'          => 'Email wajib diisi.',
            'email.email'             => 'Format email tidak valid.',
            'email.unique'            => 'Email sudah digunakan.',
            'no_telepon.required'     => 'Nomor telepon wajib diisi.',
            'no_telepon.numeric'      => 'Nomor telepon harus berupa angka.',
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
            'password.min'            => 'Password minimal 8 karakter.',
            'password.confirmed'      => 'Konfirmasi password tidak cocok.',
        ]);

        $pelanggan = Pelanggan::findOrFail($id);

        $namaFoto = $pelanggan->foto_profil;
        if ($this->foto_profil) {

            // Hapus foto lama jika ada
            if ($pelanggan->foto_profil && Storage::disk('public')->exists('foto-pelanggan/' . $pelanggan->foto_profil)) {
                Storage::disk('public')->delete('foto-pelanggan/' . $pelanggan->foto_profil);
            }

            $namaFoto = $this->foto_profil->hashName();

            $this->foto_profil->storeAs(
                'pelanggan/foto-pelanggan',
                $namaFoto,
                'public'
            );
        }

        $pelanggan->nama_pelanggan = $this->nama_pelanggan;
        $pelanggan->email          = $this->email;
        $pelanggan->no_telepon     = $this->no_telepon;
        $pelanggan->jenis_kelamin  = $this->jenis_kelamin;
        $pelanggan->foto_profil    = $namaFoto;

        if (!empty($this->password)) {
            $pelanggan->password = Hash::make($this->password);
        }

        $pelanggan->save();

        // Simpan / update data alamat
        $pelanggan->alamat()->updateOrCreate(
            ['id_pelanggan' => $pelanggan->id_pelanggan],
            [
                'label_alamat'   => $this->label_alamat,
                'province_id'    => $this->province_id,
                'regency_id'     => $this->regency_id,
                'district_id'    => $this->district_id,
                'alamat_lengkap' => $this->alamat_lengkap,
                'is_utama'       => true,
            ]
        );

        $this->foto_profil_existing = $pelanggan->foto_profil;

        // Reset fields
        $this->reset(['foto_profil', 'password', 'password_confirmation']);

        session()->flash('success', 'Profil Anda berhasil diperbarui!');
    }

    public function render()
    {
        return view('livewire.frontend.profile.index');
    }
}
