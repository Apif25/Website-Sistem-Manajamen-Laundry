<?php

namespace App\Livewire\Pekerja;

use Livewire\Component;
use App\Models\Pekerja;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('backend.layouts.app')]
#[Title('Edit Pekerja')]
class Edit extends Component
{
    public $pekerjaId;
    public $nama;
    public $email;
    public $no_telepon;
    public $alamat;
    public $jenis_kelamin;

    public function mount($id)
    {
        $pekerja = Pekerja::where('id_pekerja', $id)->firstOrFail();

        $this->pekerjaId      = $pekerja->id_pekerja;
        $this->nama           = $pekerja->nama_pekerja;
        $this->email          = $pekerja->email;
        $this->no_telepon     = $pekerja->no_telepon;
        $this->alamat         = $pekerja->alamat;
        $this->jenis_kelamin  = $pekerja->jenis_kelamin;
    }

    public function update()
    {
        $this->validate([
            'nama'          => 'required|string|max:255',
            'email'         => 'required|email|unique:pekerja,email,' . $this->pekerjaId . ',id_pekerja',
            'no_telepon'    => 'nullable|string|max:20',
            'alamat'        => 'required|string',
            'jenis_kelamin' => 'required|in:Pria,Wanita',
        ]);

        $pekerja = Pekerja::where('id_pekerja', $this->pekerjaId)->firstOrFail();
        $pekerja->nama_pekerja  = $this->nama;
        $pekerja->email         = $this->email;
        $pekerja->no_telepon    = $this->no_telepon;
        $pekerja->alamat        = $this->alamat;
        $pekerja->jenis_kelamin = $this->jenis_kelamin;
        $pekerja->save();

        session()->flash('success', 'Data berhasil diupdate');
        return redirect()->route('pekerja.index');
    }

    public function render()
    {
        return view('livewire.pekerja.edit');
    }
}
