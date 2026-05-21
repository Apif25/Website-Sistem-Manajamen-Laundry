<?php

namespace App\Livewire\Pekerja\Pelanggan;

use Livewire\Component;
use App\Models\Pelanggan;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('backend.layouts.app')]
#[Title('Edit Data Pelanggan')]
class Edit extends Component
{
    public $pelangganId;
    public $nama;
    public $no_telepon;
    public $alamat;
    public $jenis_kelamin;

    public function mount($id)
    {
        $pelanggan = Pelanggan::where('id_pelanggan', $id)->firstOrFail();

        $this->pelangganId    = $pelanggan->id_pelanggan;
        $this->nama           = $pelanggan->nama_pelanggan;
        $this->no_telepon     = $pelanggan->no_telepon;
        $this->alamat         = $pelanggan->alamat;
        $this->jenis_kelamin  = $pelanggan->jenis_kelamin;
    }

    public function update()
    {
        $this->validate([
            'nama'          => 'required|string|max:255',
            'no_telepon'    => 'nullable|string|max:20',
            'alamat'        => 'required|string',
            'jenis_kelamin' => 'required|in:Pria,Wanita',
        ]);

        $pelanggan = Pelanggan::where('id_pelanggan', $this->pelangganId)->firstOrFail();
        $pelanggan->nama_pelanggan  = $this->nama;
        $pelanggan->no_telepon    = $this->no_telepon;
        $pelanggan->alamat        = $this->alamat;
        $pelanggan->jenis_kelamin = $this->jenis_kelamin;
        $pelanggan->save();

        session()->flash('success', 'Data berhasil diupdate');
        return redirect()->route('pekerja.pelanggan.index');
    }

    public function render()
    {
        return view('livewire.pekerja.pelanggan.edit');
    }
}
