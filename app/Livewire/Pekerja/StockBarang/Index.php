<?php

namespace App\Livewire\Pekerja\StockBarang;

use App\Services\StockBarangService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('backend.layouts.app')]
class Index extends Component
{
    public string $search = '';
    public $detail = null;

    public function openCreate(): void
    {
        $this->dispatch('open-form-stock', mode: 'create', id: null);
    }

    public function openEdit(int $id): void
    {
        $this->dispatch('open-form-stock', mode: 'edit', id: $id);
    }

    public function openShow(int $id, StockBarangService $service): void
    {
        $this->detail = $service->findById($id);
    }

    public function closeShow(): void
    {
        $this->detail = null;
    }

    public function delete(int $id, StockBarangService $service): void
    {
        $service->destroy($id);
        session()->flash('success', 'Data stock barang berhasil dihapus.');
    }

    #[On('stock-saved')]
    public function handleSaved(): void
    {
        // tabel otomatis re-render
    }

    public function render(StockBarangService $service)
    {
        return view('livewire.pekerja.stock-barang.index', [
            'stocks' => $service->getAll($this->search),
        ]);
    }
}
