<?php

namespace App\Livewire\Frontend;

use App\Services\PelangganAuthService;
use Livewire\Component;

class Navbar extends Component
{
    /**
     * Fungsi untuk menangani logout tanpa reload halaman penuh
     */
    public function logout(PelangganAuthService $authService)
    {
        // Panggil service logout pelanggan Anda
        $authService->logout();

        // Redirect instan menggunakan fitur navigasi Livewire (SPA feel)
        return $this->redirect(route('pelanggan.beranda'), navigate: true);
    }

    public function render()
    {
        return view('livewire.frontend.navbar');
    }
}