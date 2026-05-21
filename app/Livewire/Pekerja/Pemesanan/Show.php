<?php

namespace App\Livewire\Pekerja\Pemesanan;

use Livewire\Component;
use App\Models\Pemesanan;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('backend.layouts.app')]
#[Title('Detail Pemesanan')]
class Show extends Component
{
    public $pemesanan;

    public function mount($id)
    {
        $this->pemesanan = Pemesanan::findOrFail($id);
    }

    public function render()
    {
        return view('livewire.pekerja.pemesanan.show');
    }
}
