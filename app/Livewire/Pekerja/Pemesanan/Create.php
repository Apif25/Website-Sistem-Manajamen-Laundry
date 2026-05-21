<?php

namespace App\Livewire\Pekerja\Pemesanan;

use App\Models\Pelanggan;
use App\Services\PemesananService;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;

#[Layout('backend.layouts.app')]
#[Title('Tambah Pemesanan')]
class Create extends Component
{
    #[Rule('required|exists:pelanggan,id_pelanggan')]
    public ?int $id_pelanggan = null;

    #[Rule('required|in:Kiloan,Satuan')]
    public string $jenis_pemesanan = '';

    #[Rule('required|in:Cepat,Biasa')]
    public string $layanan_pemesanan = '';

    #[Rule('required|integer|min:1')]
    public string $jumlah_brg = '';

    #[Rule('required|date')]
    public string $tanggal_pemesanan = '';

    public function mount(): void
    {
        $this->tanggal_pemesanan = now()->format('Y-m-d');
    }

    protected array $messages = [
        'id_pelanggan.required'      => 'Pelanggan wajib dipilih.',
        'id_pelanggan.exists'        => 'Pelanggan tidak valid.',

        'jenis_pemesanan.required'   => 'Jenis pemesanan wajib dipilih.',
        'jenis_pemesanan.in'         => 'Jenis pemesanan tidak valid.',

        'layanan_pemesanan.required' => 'Layanan pemesanan wajib dipilih.',
        'layanan_pemesanan.in'       => 'Layanan pemesanan tidak valid.',

        'jumlah_brg.required'        => 'Jumlah barang wajib diisi.',
        'jumlah_brg.integer'         => 'Jumlah barang harus berupa angka.',
        'jumlah_brg.min'             => 'Jumlah barang minimal 1.',

        'tanggal_pemesanan.required' => 'Tanggal pemesanan wajib diisi.',
        'tanggal_pemesanan.date'     => 'Format tanggal tidak valid.',
    ];

    public function save(PemesananService $pemesananService): void
    {
        $validated = $this->validate();

        $pemesananService->create($validated);

        session()->flash('success', 'Pemesanan berhasil ditambahkan.');

        $this->redirectRoute('pekerja.pemesanan.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.pekerja.pemesanan.create', [
            'pelanggans' => Pelanggan::orderBy('nama_pelanggan')->get(),
        ]);
    }
}
