<?php

namespace App\Livewire\Pekerja;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Pekerja;
use App\Models\Pelanggan;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('backend.layouts.app')]
#[Title('Dashboard')]
class Dashboard extends Component
{
    public $user;
    public $totalPekerja;
    public $totalPelanggan;
    public $role;

    public function mount()
    {
        $this->user = Auth::guard('pekerja')->user();

        $this->totalPekerja = Pekerja::count();
        $this->totalPelanggan = Pelanggan::count();

        $this->role = $this->user->getRoleNames()->first();
    }

    public function render()
    {
        return view('livewire.pekerja.dashboard');
    }
}
