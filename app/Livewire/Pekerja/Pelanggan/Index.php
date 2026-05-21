<?php

namespace App\Livewire\Pekerja\Pelanggan;

use App\Models\Pelanggan;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('backend.layouts.app')]
class Index extends Component
{
    public string $search = '';

    public function delete($id)
    {
        try {

            Pelanggan::findOrFail($id)->delete();

            session()->flash(
                'success',
                'Data pelanggan berhasil dihapus.'
            );
        } catch (\Illuminate\Database\QueryException $e) {

            session()->flash(
                'error',
                'Data pelanggan tidak bisa dihapus karena masih memiliki pemesanan.'
            );
        }
    }
    public function render()
    {
        $pelanggans = Pelanggan::latest()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nama_pelanggan', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('no_telepon', 'like', '%' . $this->search . '%');
                });
            })
            ->get();

        return view('livewire.pekerja.pelanggan.index', compact('pelanggans'));
    }
}
