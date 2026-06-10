<?php

namespace App\Livewire\Frontend\Pemesanan;

use Livewire\Component;
use App\Models\Pemesanan;
use Illuminate\Support\Facades\Auth; // Jika butuh ID pelanggan dari user login

class CreatePemesananModal extends Component
{
    public $isOpen = false;

    // Properti Form sesuai fillable model
    public $jenis_pemesanan = '';
    public $layanan_pemesanan = '';
    public $jumlah_brg;
    public $tanggal_pemesanan;

    // Variabel tab aktif (opsional jika ingin mempertahankan fitur tab)
    public $activeTab = 'website';

    protected $listeners = ['openOrderModal' => 'open'];

    public function open()
    {
        $this->resetValidation();
        $this->reset(['jenis_pemesanan', 'layanan_pemesanan', 'jumlah_brg', 'tanggal_pemesanan']);
        // Isi otomatis tanggal hari ini jika diinginkan
        $this->tanggal_pemesanan = date('Y-m-d'); 
        
        $this->isOpen = true;
    }

    public function close()
    {
        $this->isOpen = false;
    }

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function store()
    {
        $this->validate([
            'jenis_pemesanan' => 'required|in:Satuan,Kiloan',
            'layanan_pemesanan' => 'required|in:Cepat,Biasa',
            'jumlah_brg' => 'required|numeric|min:1',
            'tanggal_pemesanan' => 'required|date',
        ]);

        // 🔴 Perubahan di sini: Mengambil ID Pelanggan dari guard 'pelanggan' yang aktif
        $idPelanggan = auth()->guard('pelanggan')->id();

        // Proteksi: Jika belum login, jangan izinkan membuat pesanan
        if (!$idPelanggan) {
            $this->addError('jenis_pemesanan', 'Anda harus login terlebih dahulu.');
            return;
        }

        $pelanggan = \App\Models\Pelanggan::find($idPelanggan);
        $alamatUtama = $pelanggan?->alamat()->where('is_utama', true)->first()
            ?? $pelanggan?->alamat()->first();
        $idAlamat = $alamatUtama?->id_alamat;

        Pemesanan::create([
            'id_pelanggan'      => $idPelanggan, // Menggunakan ID asli hasil login
            'id_alamat'         => $idAlamat,
            'jenis_pemesanan'   => $this->jenis_pemesanan,
            'layanan_pemesanan' => $this->layanan_pemesanan,
            'jumlah_brg'        => $this->jumlah_brg,
            'tanggal_pemesanan' => $this->tanggal_pemesanan,
        ]);

        $this->dispatch('pemesananCreated', 'Pemesanan berhasil dikirim!');
        $this->close();
    }

    public function render()
    {
        return view('livewire.frontend.form.create-pemesanan-modal');
    }
}