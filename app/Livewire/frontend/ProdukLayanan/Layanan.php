<?php

namespace App\Livewire\Frontend\ProdukLayanan;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('frontend.layouts.app')]
#[Title('Layanan Kami')]
class Layanan extends Component
{
    public function render()
    {
        return view('frontend.produk-layanan.layanan');
    }
}
