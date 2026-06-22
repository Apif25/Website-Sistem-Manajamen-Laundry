<?php

namespace App\Livewire\Frontend\Pemesanan;

use Livewire\Component;
use App\Models\Pemesanan;
use Illuminate\Support\Facades\Auth;

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

    // Variabel tab aktif
    public $activeTab = 'website';

    protected $listeners = ['openOrderModal' => 'open'];

    /**
     * Hook yang otomatis berjalan setiap kali $jenis_pemesanan berubah di frontend
     */
    public function updatedJenisPemesanan($value)
    {
        if ($value !== 'Satuan') {
            $this->jumlah_brg = null; 
            $this->resetErrorBag('jumlah_brg'); 
        }
    }

    public function open()
    {
        $this->resetValidation();
        $this->reset(['jenis_pemesanan', 'layanan_pemesanan', 'jumlah_brg', 'tanggal_pemesanan', 'selectedAlamatId']);
        
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
        // Membuat aturan validasi dinamis berdasarkan JENIS PEMESANAN
        $rules = [
            'jenis_pemesanan'   => 'required|in:Satuan,Kiloan',
            'layanan_pemesanan' => 'required|in:Kilat,Biasa',
            'jumlah_brg'        => $this->jenis_pemesanan === 'Satuan' ? 'required|numeric|min:1' : 'nullable|numeric',
            'tanggal_pemesanan' => 'required|date|after_or_equal:today', // Validasi agar tidak boleh backdate/lewat hari
            'selectedAlamatId'  => 'required|exists:AlamatPelanggan,id_alamat',
        ];

        $this->validate($rules, [
            'selectedAlamatId.required'  => 'Alamat penjemputan / pengiriman wajib dipilih.',
            'selectedAlamatId.exists'    => 'Alamat yang dipilih tidak valid.',
            'jumlah_brg.required'        => 'Jumlah barang wajib diisi jika memesan layanan Satuan.',
            'tanggal_pemesanan.after_or_equal' => 'Tanggal pemesanan tidak boleh hari yang sudah lewat.',
        ]);

        $idPelanggan = auth()->guard('pelanggan')->id();

        if (!$idPelanggan) {
            $this->addError('jenis_pemesanan', 'Anda harus login terlebih dahulu.');
            return;
        }

        Pemesanan::create([
            'id_pelanggan'      => $idPelanggan,
            'id_alamat'         => $this->selectedAlamatId,
            'jenis_pemesanan'   => $this->jenis_pemesanan,
            'layanan_pemesanan' => $this->layanan_pemesanan,
            'jumlah_brg'        => $this->jenis_pemesanan === 'Satuan' ? $this->jumlah_brg : null,
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