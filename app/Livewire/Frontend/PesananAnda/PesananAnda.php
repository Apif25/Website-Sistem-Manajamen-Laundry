<?php

namespace App\Livewire\Frontend\PesananAnda;

use Livewire\Component;
use App\Models\Pemesanan;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('frontend.layouts.app')] // Sesuaikan dengan layout frontend Anda
#[Title('Pesanan Anda')]
class PesananAnda extends Component
{
    // Properti untuk menyimpan status tab yang aktif
    public $statusAktif = 'diproses';

    /**
     * Fungsi untuk mengubah status tab saat tombol diklik
     */
    public function switchTab($status)
    {
        // Validasi status untuk keamanan
        if (in_array($status, ['diproses', 'selesai', 'dibatalkan'])) {
            $this->statusAktif = $status;
        }
    }

    public function render()
    {
        // Mengambil data pemesanan sesuai pelanggan yang login dan status tab aktif
        $idPelanggan = Auth::guard('pelanggan')->id() ?? Auth::id();
        
        $pesanan = Pemesanan::where('id_pelanggan', $idPelanggan)
            ->where('status_pemesanan', $this->statusAktif) // Sesuaikan nama kolom status di DB Anda
            ->latest('tanggal_pemesanan')
            ->get();

        return view('livewire.frontend.pesanan-anda.pesanan-anda', [
            'pesanan' => $pesanan
        ]);
    }
}