<?php

namespace App\Livewire\Pekerja;

use App\Models\Pekerja;
use App\Services\PekerjaAuthService;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('backend.layouts.app')]
#[Title('Data Pekerja')]
class Index extends Component
{
    public string $search = '';

    public function delete($id)
    {
        Pekerja::findOrFail($id)->delete();
        session()->flash('success', 'Data pekerja berhasil dihapus.');
    }


    public function render(PekerjaAuthService $pekerjaService)
    {
        $pekerjaDaftar = $pekerjaService->getAll()->filter(function ($p) {
            return str_contains(strtolower($p->nama_pekerja), strtolower($this->search))
                || str_contains(strtolower($p->email), strtolower($this->search));
        })->values();

        return view('livewire.pekerja.index', [
            'pekerjaDaftar' => $pekerjaDaftar,
        ]);
    }
}
