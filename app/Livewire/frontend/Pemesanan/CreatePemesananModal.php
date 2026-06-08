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
        // Validasi input
        $this->validate([
            'jenis_pemesanan' => 'required|in:Satuan,Kiloan',
            'layanan_pemesanan' => 'required|in:Cepat,Biasa',
            'jumlah_brg' => 'required|numeric|min:1',
            'tanggal_pemesanan' => 'required|date',
        ]);

        // Simpan ke database
        Pemesanan::create([
            // Contoh mengambil id_pelanggan dari user yang login (sesuaikan dengan sistem Anda)
            'id_pelanggan' => Auth::id() ?? 1, 
            'jenis_pemesanan' => $this->jenis_pemesanan,
            'layanan_pemesanan' => $this->layanan_pemesanan,
            'jumlah_brg' => $this->jumlah_brg,
            'tanggal_pemesanan' => $this->tanggal_pemesanan,
        ]);

        // Event opsional untuk refresh tabel di komponen lain atau memicu alert sukses
        $this->dispatch('pemesananCreated', 'Pemesanan berhasil dikirim!');

        // Tutup modal
        $this->close();
    }

    public function render()
    {
        return view('livewire.frontend.form.create-pemesanan-modal');
    }
}