<?php

namespace App\Livewire\Pekerja\Profile;

use App\Services\PekerjaAuthService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('backend.layouts.app')]
class Index extends Component
{
    use WithFileUploads;

    public string $nama_pekerja = '';
    public string $email = '';
    public string $no_telepon = '';
    public string $alamat = '';
    public string $jenis_kelamin = '';
    public string $password = '';
    public string $password_confirmation = '';

    public $foto = null;

    public ?string $foto_existing = null;

    public function mount(): void
    {
        $pekerja = Auth::guard('pekerja')->user();

        $this->nama_pekerja  = $pekerja?->nama_pekerja ?? '';
        $this->email         = $pekerja?->email ?? '';
        $this->no_telepon    = $pekerja?->no_telepon ?? '';
        $this->alamat        = $pekerja?->alamat ?? '';
        $this->jenis_kelamin = $pekerja?->jenis_kelamin ?? '';
        $this->foto_existing = $pekerja?->foto;
    }

    protected function rules(): array
    {
        $id = Auth::guard('pekerja')->id();

        return [
            'nama_pekerja'  => 'required|string|max:255',

            'email' => 'required|email|max:255|unique:pekerja,email,' . $id . ',id_pekerja',

            'no_telepon'    => 'nullable|string|max:20',
            'alamat'        => 'nullable|string|max:500',

            'jenis_kelamin' => 'required|in:Pria,Wanita',

            'password'      => 'nullable|min:8|confirmed',

            'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    protected function messages(): array
    {
        return [
            'nama_pekerja.required'  => 'Nama wajib diisi.',

            'email.required'         => 'Email wajib diisi.',
            'email.email'            => 'Format email tidak valid.',
            'email.unique'           => 'Email sudah digunakan.',

            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in'       => 'Jenis kelamin tidak valid.',

            'password.min'           => 'Password minimal 8 karakter.',
            'password.confirmed'     => 'Konfirmasi password tidak cocok.',

            'foto.image'             => 'File harus berupa gambar.',
            'foto.mimes'             => 'Format foto harus jpg, jpeg, atau png.',
            'foto.max'               => 'Ukuran foto maksimal 2MB.',
        ];
    }

    public function save(PekerjaAuthService $service): void
    {
        $this->validate();

        $id = Auth::guard('pekerja')->id();

        $data = [
            'nama_pekerja'  => $this->nama_pekerja,
            'email'         => $this->email,
            'no_telepon'    => $this->no_telepon,
            'alamat'        => $this->alamat,
            'jenis_kelamin' => $this->jenis_kelamin,
        ];

        // Update password hanya jika diisi
        if (!empty($this->password)) {
            $data['password'] = $this->password;
        }

        // Update profile
        $service->update($id, $data, $this->foto);

        // Ambil ulang data terbaru
        $pekerja = \App\Models\Pekerja::find($id);

        $this->foto_existing = $pekerja?->foto;

        // Reset field sensitif
        $this->reset([
            'foto',
            'password',
            'password_confirmation',
        ]);

        session()->flash('success', 'Profil berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.pekerja.profile.index');
    }
}
