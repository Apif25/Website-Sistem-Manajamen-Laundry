<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('frontend.layouts.app')]
#[Title('Beranda')]
class Beranda extends Component
{
    
    public function render()
    {
        return view('frontend.beranda.index');
    }
}
