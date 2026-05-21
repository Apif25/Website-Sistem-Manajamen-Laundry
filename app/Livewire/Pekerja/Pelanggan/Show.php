<?php

namespace App\Livewire\Pekerja\Pelanggan;

use Livewire\Component;
use App\Models\Pelanggan;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('backend.layouts.app')]
#[Title('Detail Pelanggan')]
class Show extends Component
{
    public $pelanggan;

    public function mount($id)
    {
        $this->pelanggan = Pelanggan::findOrFail($id);
    }

    public function render()
    {
        return view('livewire.pekerja.pelanggan.show');
    }
}
