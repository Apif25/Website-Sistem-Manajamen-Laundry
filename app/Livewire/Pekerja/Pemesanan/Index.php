<?php

namespace App\Livewire\Pekerja\Pemesanan;

use App\Models\Pemesanan;
use App\Services\PemesananService;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('backend.layouts.app')]
class Index extends Component
{
    public string $search = '';

    public function delete(int $id): void
    {
        Pemesanan::findOrFail($id)->delete();
        session()->flash('success', 'Data pemesanan berhasil dihapus.');
    }

    public function render()
    {
        $pemesanans = Pemesanan::with('pelanggan')
            ->orderBy('id_pemesanan', 'asc')
            ->when($this->search, function ($query) {
                $query->whereHas('pelanggan', function ($q) {
                    $q->where('nama_pelanggan', 'like', '%' . $this->search . '%');
                })
                    ->orWhere('jenis_pemesanan', 'like', '%' . $this->search . '%')
                    ->orWhere('layanan_pemesanan', 'like', '%' . $this->search . '%');
            })
            ->get();

        return view('livewire.pekerja.pemesanan.index', compact('pemesanans'));
    }
}
