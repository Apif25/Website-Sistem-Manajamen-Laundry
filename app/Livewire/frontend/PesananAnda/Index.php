<?php

namespace App\Livewire\Frontend\PesananAnda;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('frontend.layouts.app')]
#[Title('Pesanan Anda')]
class Index extends Component
{
    public function render()
    {
        return view('frontend.pesanan-anda.index');
    }
}
