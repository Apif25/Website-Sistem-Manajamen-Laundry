<?php

namespace App\Livewire\Frontend\PesananAnda;

use Livewire\Component;
use App\Models\Pemesanan;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('frontend.layouts.app')]
#[Title('Detail Pesanan')]
class Tracker extends Component
{
    public $pemesananId;
    public $pemesanan;

    public function mount($id)
    {
        $idPelanggan = Auth::guard('pelanggan')->id() ?? Auth::id();

        // Fetch booking record and ensure it belongs to the logged-in customer
        $this->pemesanan = Pemesanan::with(['alamat', 'pesanan.proses', 'pesanan.pembayaran'])
            ->where('id_pemesanan', $id)
            ->where('id_pelanggan', $idPelanggan)
            ->firstOrFail();

        $this->pemesananId = $id;
    }

    public function render()
    {
        return view('frontend.pesanan-anda.tracker');
    }
}
