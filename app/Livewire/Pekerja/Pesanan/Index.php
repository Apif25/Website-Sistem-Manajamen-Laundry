<?php

namespace App\Livewire\Pekerja\Pesanan;

use App\Models\Pesanan;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('backend.layouts.app')]
class Index extends Component
{
    public string $search = '';

    public function delete(int $id): void
    {
        Pesanan::findOrFail($id)->delete();
        session()->flash('success', 'Data pesanan berhasil dihapus.');
    }

    public function render()
    {
        $pesanans = Pesanan::with(['pemesanan', 'pelanggan'])
            ->oldest()
            ->when($this->search, function ($query) {
                $query->whereHas('pelanggan', function ($q) {
                    $q->where('nama_pelanggan', 'like', '%' . $this->search . '%');
                })
                    ->orWhere('Jenis_Pesanan', 'like', '%' . $this->search . '%')
                    ->orWhere('Layanan_Pesanan', 'like', '%' . $this->search . '%');
            })
            ->get();

        return view('livewire.pekerja.pesanan.index', compact('pesanans'));
    }
}
