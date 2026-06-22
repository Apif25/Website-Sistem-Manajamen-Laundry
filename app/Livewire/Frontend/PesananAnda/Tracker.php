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

    public function mount(Pemesanan $pemesanan)
    {
        $idPelanggan = Auth::guard('pelanggan')->id() ?? Auth::id();

        // Ensure it belongs to the logged-in customer
        if ($pemesanan->id_pelanggan !== $idPelanggan) {
            abort(404);
        }

        $this->pemesanan = $pemesanan->load(['alamat', 'pesanan.proses', 'pesanan.pembayaran']);

        $this->pemesananId = $pemesanan->id_pemesanan;
    }

    public function render()
    {
        return view('frontend.pesanan-anda.tracker');
    }
}
