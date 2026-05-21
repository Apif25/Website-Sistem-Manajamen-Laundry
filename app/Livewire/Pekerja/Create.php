<?php

namespace App\Livewire\Pekerja;

use App\Services\PekerjaAuthService;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Spatie\Permission\Models\Role;

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
    public string $role          = '';

    public array $roles = [];

    public $foto = null;

    protected PekerjaAuthService $pekerjaService;

    public function boot(PekerjaAuthService $pekerjaService): void
    {
        $this->pekerjaService = $pekerjaService;
    }

    public function mount(): void
    {
        $this->roles = Role::where('guard_name', 'pekerja')
            ->pluck('name')
            ->toArray();
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
            'role'          => 'required|exists:roles,name',
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
        'role.required'          => 'Role wajib dipilih.',
        'foto.image'             => 'File harus berupa gambar.',
        'foto.max'               => 'Ukuran foto maksimal 2MB.',
    ];

    public function simpan(): void
    {
        $validated = $this->validate();

        $this->pekerjaService->create(
            $validated,
            $this->foto,
            $this->role
        );

        session()->flash('success', 'Pekerja berhasil ditambahkan.');

        $this->redirect(route('pekerja.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.pekerja.create');
    }
}
