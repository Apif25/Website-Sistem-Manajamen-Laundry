<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('frontend.layouts.app')]
#[Title('Beranda')]
class TentangKami extends Component
{
    public function render()
    {
        return view('livewire.frontend.tentang-kami.tentang-kami');
    }
}
