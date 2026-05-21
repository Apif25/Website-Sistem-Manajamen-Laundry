<?php

namespace App\Livewire\Pekerja;

use App\Services\PekerjaAuthService;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('backend.layouts.app')]
#[Title('Tambah Pekerja')]
class Create extends Component
{
    use WithFileUploads;

    public string $nama_pekerja  = '';
    public string $email         = '';
    public string $password      = '';
    public string $no_telepon    = '';
    public string $alamat        = '';
    public string $jenis_kelamin = '';
    public $foto = null;

    protected PekerjaAuthService $pekerjaService;

    public function boot(PekerjaAuthService $pekerjaService): void
    {
        $this->pekerjaService = $pekerjaService;
    }

    protected function rules(): array
    {
        return [
            'nama_pekerja'  => 'required|string|max:50',
            'email'         => 'required|email|unique:pekerja,email',
            'password'      => 'required|string|min:8',
            'no_telepon'    => 'required|string|max:20',
            'alamat'        => 'required|string',
            'jenis_kelamin' => 'required|in:Pria,Wanita',
            'foto'          => 'nullable|image|max:2048',
        ];
    }

    protected $messages = [
        'nama_pekerja.required'  => 'Nama pekerja wajib diisi.',
        'email.required'         => 'Email wajib diisi.',
        'email.unique'           => 'Email sudah digunakan.',
        'password.required'      => 'Password wajib diisi.',
        'password.min'           => 'Password minimal 8 karakter.',
        'no_telepon.required'    => 'Nomor telepon wajib diisi.',
        'alamat.required'        => 'Alamat wajib diisi.',
        'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
        'foto.image'             => 'File harus berupa gambar.',
        'foto.max'               => 'Ukuran foto maksimal 2MB.',
    ];

    public function simpan(): void
    {
        $validated = $this->validate();

        $validated['password'] = bcrypt($validated['password']);

        $this->pekerjaService->create($validated, $this->foto);

        session()->flash('success', 'Pekerja berhasil ditambahkan.');

        $this->redirect(route('pekerja.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.pekerja.create');
    }
}
