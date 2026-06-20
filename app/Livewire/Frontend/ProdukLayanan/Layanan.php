<?php

namespace App\Livewire\Frontend\ProdukLayanan;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('frontend.layouts.app')]
#[Title('Layanan Kami')]
class Layanan extends Component
{
    public $activeTab = 'kiloan'; // Default tab yang terbuka

    public function setTab($tabName)
    {
        $this->activeTab = $tabName;
    }

    public function render()
    {
        return view('frontend.produk-layanan.layanan');
    }
}
