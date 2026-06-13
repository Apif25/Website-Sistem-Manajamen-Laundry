<?php

namespace App\Livewire\Pekerja\Pesanan;

use App\Models\Pemesanan;
use App\Models\Pelanggan;
use App\Models\Pesanan;
use App\Services\PesananService;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('backend.layouts.app')]
class Create extends Component
{
    public string $id_pemesanan = '';

    public string $id_pelanggan = '';

    public string $jenis_pesanan = '';

    public string $layanan_pesanan = '';

    public string $berat = '';

    public string $harga = '';

    public string $tanggal_pesanan = '';

    public function rules(): array
    {
        return [
            'id_pemesanan' => [
                'required',
                'exists:Pemesanan,id_pemesanan',
                'unique:Pesanan,id_pemesanan',
            ],

            'id_pelanggan' => [
                'required',
                'exists:Pelanggan,id_pelanggan',
            ],

            'jenis_pesanan' => [
                'required',
                'in:Kiloan,Satuan',
            ],

            'layanan_pesanan' => [
                'required',
                'in:Cepat,Biasa',
            ],

            'berat' => [
                'required',
                'numeric',
                'min:0.1',
            ],

            'harga' => [
                'required',
                'numeric',
                'min:0',
            ],

            'tanggal_pesanan' => [
                'required',
                'date',
            ],
        ];
    }

    // Auto-fill data saat pemesanan dipilih
    public function updatedIdPemesanan($value): void
    {
        $pemesanan = Pemesanan::with('pelanggan')->find($value);

        if ($pemesanan) {
            $this->id_pelanggan = $pemesanan->id_pelanggan;
            $this->jenis_pesanan = $pemesanan->jenis_pemesanan;
            $this->layanan_pesanan = $pemesanan->layanan_pemesanan;
        } else {
            $this->id_pelanggan = '';
            $this->jenis_pesanan = '';
            $this->layanan_pesanan = '';
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
        $pemesanans = Pemesanan::with('pelanggan')
            ->whereNotIn('id_pemesanan', function ($query) {
                $query->select('id_pemesanan')
                    ->from('Pesanan');
            })
            ->latest()
            ->get();

        $pelanggans = Pelanggan::orderBy('nama_pelanggan')->get();

        return view(
            'livewire.pekerja.pesanan.create',
            compact('pemesanans', 'pelanggans')
        );
    }
}
