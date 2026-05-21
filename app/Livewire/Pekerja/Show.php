<?php

namespace App\Livewire\Pekerja;

use Livewire\Component;
use App\Models\Pekerja;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('backend.layouts.app')]
#[Title('Detail Pekerja')]
class Show extends Component
{
    public $pekerja;

    public function mount($id)
    {
        $this->pekerja = Pekerja::findOrFail($id);
    }

    public function render()
    {
        return view('livewire.pekerja.show');
    }
}
