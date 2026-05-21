<?php

namespace App\Livewire\Pekerja\Pesanan;

use App\Models\Pesanan;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('backend.layouts.app')]
class Show extends Component
{
    public Pesanan $pesanan;

    public function mount(int $id): void
    {
        $this->pesanan = Pesanan::with(['pemesanan', 'pelanggan'])
            ->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.pekerja.pesanan.show');
    }
}
