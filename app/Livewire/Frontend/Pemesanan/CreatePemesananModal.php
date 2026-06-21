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

    // Properti Alamat
    public $alamatList = [];
    public $selectedAlamatId = '';

    // Variabel tab aktif (opsional jika ingin mempertahankan fitur tab)
    public $activeTab = 'website';

    protected $listeners = ['openOrderModal' => 'open'];

    public function open()
    {
        $this->resetValidation();
        $this->reset(['jenis_pemesanan', 'layanan_pemesanan', 'jumlah_brg', 'tanggal_pemesanan', 'selectedAlamatId']);
        // Isi otomatis tanggal hari ini jika diinginkan
        $this->tanggal_pemesanan = date('Y-m-d'); 
        
        $idPelanggan = auth()->guard('pelanggan')->id();
        if ($idPelanggan) {
            $pelanggan = \App\Models\Pelanggan::find($idPelanggan);
            if ($pelanggan) {
                $this->alamatList = $pelanggan->alamat()->get();
                $alamatUtama = $pelanggan->alamat()->where('is_utama', true)->first()
                    ?? $pelanggan->alamat()->first();
                $this->selectedAlamatId = $alamatUtama?->id_alamat ?? '';
            }
        } else {
            $this->alamatList = [];
        }
        
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
            'layanan_pemesanan' => 'required|in:Kilat,Biasa',
            'jumlah_brg' => 'required|numeric|min:1',
            'tanggal_pemesanan' => 'required|date',
            'selectedAlamatId' => 'required|exists:AlamatPelanggan,id_alamat',
        ], [
            'selectedAlamatId.required' => 'Alamat penjemputan / pengiriman wajib dipilih.',
            'selectedAlamatId.exists' => 'Alamat yang dipilih tidak valid.',
        ]);

        // Perubahan di sini: Mengambil ID Pelanggan dari guard 'pelanggan' yang aktif
        $idPelanggan = auth()->guard('pelanggan')->id();

        // Proteksi: Jika belum login, jangan izinkan membuat pesanan
        if (!$idPelanggan) {
            $this->addError('jenis_pemesanan', 'Anda harus login terlebih dahulu.');
            return;
        }

        Pemesanan::create([
            'id_pelanggan'      => $idPelanggan, // Menggunakan ID asli hasil login
            'id_alamat'         => $this->selectedAlamatId,
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