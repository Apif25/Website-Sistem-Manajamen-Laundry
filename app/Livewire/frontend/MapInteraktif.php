<?php

namespace App\Livewire\Frontend;

use Livewire\Component;

class MapInteraktif extends Component
{
    public $locations = [];

    public function mount()
    {
        $this->locations = [
            [
                'name' => 'Kelana Laundry - Pusat Bekasi',
                'lat' => -6.2383,
                'lng' => 106.9756
            ],
            [
                'name' => 'Kelana Laundry - Cabang Jakarta Timur',
                'lat' => -6.2250,
                'lng' => 106.9004
            ],
            [
                'name' => 'Kelana Laundry - Cabang Depok',
                'lat' => -6.4025,
                'lng' => 106.7942
            ]
        ];
    }

    public function render()
    {
        return view('livewire.frontend.map-interaktif');
    }
}
