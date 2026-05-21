<?php

namespace App\Livewire\Pekerja\Inventaris;

use App\Services\InventarisService;
use Livewire\Attributes\On;
use Livewire\Component;

class Form extends Component
{
    public bool $showModal = false;
    public string $mode = 'create';
    public ?int $editId = null;

    // Form fields
    public string $nama_barang = '';
    public string $jumlah_barang = '';
    public string $status = '';
    public string $keterangan = '';
    public string $tanggal = '';

    // Dropdown
    public array $statusList = [];

    protected function rules(): array
    {
        return [
            'nama_barang'   => 'required|string|max:50',
            'jumlah_barang' => 'required|integer|min:0',
            'status'        => 'required|in:Aktif,Tidak Aktif',
            'keterangan'    => 'required|string',
            'tanggal'       => 'required|date',
        ];
    }

    protected function messages(): array
    {
        return [
            'nama_barang.required'   => 'Nama barang wajib diisi.',
            'nama_barang.max'        => 'Nama barang maksimal 50 karakter.',
            'jumlah_barang.required' => 'Jumlah barang wajib diisi.',
            'jumlah_barang.integer'  => 'Jumlah barang harus berupa angka bulat.',
            'jumlah_barang.min'      => 'Jumlah barang tidak boleh negatif.',
            'status.required'        => 'Status wajib dipilih.',
            'status.in'              => 'Status tidak valid.',
            'keterangan.required'    => 'Keterangan wajib diisi.',
            'tanggal.required'       => 'Tanggal wajib diisi.',
            'tanggal.date'           => 'Format tanggal tidak valid.',
        ];
    }

    #[On('open-form-inventaris')]
    public function openModal(string $mode, ?int $id, InventarisService $service): void
    {
        $this->resetForm();
        $this->mode       = $mode;
        $this->editId     = $id;
        $this->statusList = $service->getStatusOptions();

        if ($mode === 'edit' && $id) {
            $data = $service->findById($id);
            $this->nama_barang   = $data->nama_barang;
            $this->jumlah_barang = $data->jumlah_barang;
            $this->status        = $data->status;
            $this->keterangan    = $data->keterangan;
            $this->tanggal       = \Carbon\Carbon::parse($data->tanggal)->format('Y-m-d\TH:i');
        }

        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function save(InventarisService $service): void
    {
        $this->validate();

        $data = [
            'nama_barang'   => $this->nama_barang,
            'jumlah_barang' => $this->jumlah_barang,
            'status'        => $this->status,
            'keterangan'    => $this->keterangan,
            'tanggal'       => $this->tanggal,
        ];

        if ($this->mode === 'edit' && $this->editId) {
            $service->update($this->editId, $data);
            session()->flash('success', 'Data inventaris berhasil diperbarui.');
        } else {
            $service->store($data);
            session()->flash('success', 'Data inventaris berhasil ditambahkan.');
        }

        $this->closeModal();
        $this->dispatch('inventaris-saved');
    }

    private function resetForm(): void
    {
        $this->reset(['nama_barang', 'jumlah_barang', 'status', 'keterangan', 'tanggal', 'editId', 'statusList']);
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.pekerja.inventaris.form');
    }
}
