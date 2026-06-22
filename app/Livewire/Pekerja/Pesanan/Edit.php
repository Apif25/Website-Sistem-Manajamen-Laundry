<?php

namespace App\Livewire\Pekerja\Pesanan;

use App\Models\Pemesanan;
use App\Models\Pelanggan;
use App\Models\Pesanan;
use App\Services\PesananService;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;

#[Layout('backend.layouts.app')]
class Edit extends Component
{
    public Pesanan $pesanan;

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

    public function mount(Pesanan $pesanan): void
    {
        $this->pesanan = $pesanan->load(['pemesanan', 'pelanggan']);

        // Isi form dengan data existing
        $this->id_pemesanan    = (string) $this->pesanan->id_pemesanan;
        $this->id_pelanggan    = (string) $this->pesanan->id_pelanggan;
        $this->jenis_pesanan   = $this->pesanan->jenis_pesanan;
        $this->layanan_pesanan = $this->pesanan->layanan_pesanan;
        $this->berat           = (string) $this->pesanan->berat;
        $this->harga           = (string) $this->pesanan->harga;
        $this->tanggal_pesanan = \Carbon\Carbon::parse($this->pesanan->tanggal_pesanan)
            ->format('Y-m-d\TH:i');
    }

    // Auto-fill id_pelanggan saat pemesanan diganti
    public function updatedIdPemesanan($value): void
    {
        $pemesanan = Pemesanan::with('pelanggan')->find($value);

        if ($pemesanan) {
            $this->id_pelanggan = (string) $pemesanan->id_pelanggan;
        } else {
            $this->id_pelanggan = '';
        }
    }

    public function update(PesananService $pesananService): void
    {
        $this->validate();

        $pesananService->update($this->pesanan->id_pesanan, [
            'id_pemesanan'    => $this->id_pemesanan,
            'id_pelanggan'    => $this->id_pelanggan,
            'jenis_pesanan'   => $this->jenis_pesanan,
            'layanan_pesanan' => $this->layanan_pesanan,
            'berat'           => $this->berat,
            'harga'           => $this->harga,
            'tanggal_pesanan' => $this->tanggal_pesanan,
        ]);

        session()->flash('success', 'Data pesanan berhasil diperbarui.');

        $this->redirectRoute('pekerja.pesanan.index', navigate: true);
    }

    public function render()
    {
        $pemesanans = Pemesanan::with('pelanggan')->latest()->get();
        $pelanggans = Pelanggan::orderBy('nama_pelanggan')->get();

        return view('livewire.pekerja.pesanan.edit', compact('pemesanans', 'pelanggans'));
    }
}
