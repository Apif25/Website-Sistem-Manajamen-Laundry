<?php

namespace App\Livewire\Pekerja\Inventaris;

use App\Services\InventarisService;
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
        $this->dispatch('open-form-inventaris', mode: 'create', id: null);
    }

    public function openEdit(int $id): void
    {
        $this->dispatch('open-form-inventaris', mode: 'edit', id: $id);
    }

    public function openShow(int $id, InventarisService $service): void
    {
        $this->detail = $service->findById($id);
    }

    public function closeShow(): void
    {
        $this->detail = null;
    }

    public function delete(int $id, InventarisService $service): void
    {
        $service->destroy($id);
        session()->flash('success', 'Data inventaris berhasil dihapus.');
    }

    #[On('inventaris-saved')]
    public function handleSaved(): void
    {
        // tabel otomatis re-render
    }

    public function render(InventarisService $service)
    {
        return view('livewire.pekerja.inventaris.index', [
            'inventaris' => $service->getAll($this->search),
        ]);
    }
}
