<?php

namespace App\Livewire\Pekerja\Pesanan;

use App\Models\Pemesanan;
use App\Models\Pelanggan;
use App\Services\PesananService;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;

#[Layout('backend.layouts.app')]
class Create extends Component
{
    #[Rule('required|exists:Pemesanan,id_pemesanan')]
    public string $id_pemesanan = '';

    #[Rule('required|exists:Pelanggan,id_pelanggan')]
    public string $id_pelanggan = '';

    #[Rule('required|in:Kiloan,Satuan')]
    public string $jenis_pesanan = '';

    #[Rule('required|in:Cepat,Biasa')]
    public string $layanan_pesanan = '';

    #[Rule('required|numeric|min:0.1')]
    public string $berat = '';

    #[Rule('required|numeric|min:0')]
    public string $harga = '';

    #[Rule('required|date')]
    public string $tanggal_pesanan = '';

    // Auto-fill id_pelanggan saat pemesanan dipilih
    public function updatedIdPemesanan($value): void
    {
        $pemesanan = Pemesanan::with('pelanggan')->find($value);

        if ($pemesanan) {
            $this->id_pelanggan = $pemesanan->id_pelanggan;
        } else {
            $this->id_pelanggan = '';
        }
    }

    public function save(PesananService $pesananService): void
    {
        $this->validate();

        $pesananService->create([
            'id_pemesanan'    => $this->id_pemesanan,
            'id_pelanggan'    => $this->id_pelanggan,
            'jenis_pesanan'   => $this->jenis_pesanan,
            'layanan_pesanan' => $this->layanan_pesanan,
            'berat'           => $this->berat,
            'harga'           => $this->harga,
            'tanggal_pesanan' => $this->tanggal_pesanan,
        ]);

        session()->flash('success', 'Pesanan berhasil ditambahkan.');

        $this->redirectRoute('pekerja.pesanan.index', navigate: true);
    }

    public function render()
    {
        $pemesanans = Pemesanan::with('pelanggan')->latest()->get();
        $pelanggans = Pelanggan::orderBy('nama_pelanggan')->get();

        return view('livewire.pekerja.pesanan.create', compact('pemesanans', 'pelanggans'));
    }
}
