<?php

namespace App\Livewire\Pekerja\StockBarang;

use App\Services\StockBarangService;
use Livewire\Attributes\On;
use Livewire\Component;

class Form extends Component
{
    public bool $showModal = false;
    public string $mode = 'create';
    public ?int $editId = null;

    // Form fields
    public string $nama_produk = '';
    public string $stock_produk = '';

    protected function rules(): array
    {
        return [
            'nama_produk'  => 'required|string|max:255',
            'stock_produk' => 'required|integer|min:0',
        ];
    }

    protected function messages(): array
    {
        return [
            'nama_produk.required'  => 'Nama produk wajib diisi.',
            'nama_produk.max'       => 'Nama produk maksimal 255 karakter.',
            'stock_produk.required' => 'Stock wajib diisi.',
            'stock_produk.integer'  => 'Stock harus berupa angka bulat.',
            'stock_produk.min'      => 'Stock tidak boleh negatif.',
        ];
    }

    #[On('open-form-stock')]
    public function openModal(string $mode, ?int $id, StockBarangService $service): void
    {
        $this->resetForm();
        $this->mode   = $mode;
        $this->editId = $id;

        if ($mode === 'edit' && $id) {
            $data = $service->findById($id);
            $this->nama_produk  = $data->nama_produk;
            $this->stock_produk = $data->stock_produk;
        }

        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function save(StockBarangService $service): void
    {
        $this->validate();

        $data = [
            'nama_produk'  => $this->nama_produk,
            'stock_produk' => $this->stock_produk,
        ];

        if ($this->mode === 'edit' && $this->editId) {
            $service->update($this->editId, $data);
            session()->flash('success', 'Data stock barang berhasil diperbarui.');
        } else {
            $service->store($data);
            session()->flash('success', 'Data stock barang berhasil ditambahkan.');
        }

        $this->closeModal();
        $this->dispatch('stock-saved');
    }

    private function resetForm(): void
    {
        $this->reset(['nama_produk', 'stock_produk', 'editId']);
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.pekerja.stock-barang.form');
    }
}
