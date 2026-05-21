<?php

namespace App\Livewire\Pekerja\Pembayaran;

use App\Services\PembayaranService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('backend.layouts.app')]
class Index extends Component
{
    public string $search = '';
    public $detail = null;

    protected PembayaranService $service;

    public function boot(PembayaranService $service): void
    {
        $this->service = $service;
    }

    public function openCreate(): void
    {
        $this->dispatch(
            'open-form',
            mode: 'create',
            id: null
        );
    }

    public function openEdit(int $id): void
    {
        $this->dispatch(
            'open-form',
            mode: 'edit',
            id: $id
        );
    }
    public function openShow(int $id): void
    {
        $this->detail = $this->service->findById($id);
    }
    public function closeShow(): void
    {
        $this->detail = null;
    }

    public function delete(int $id): void
    {
        $this->service->destroy($id);

        session()->flash(
            'success',
            'Data pembayaran berhasil dihapus.'
        );
    }

    #[On('pembayaran-saved')]
    public function handleSaved(): void
    {
        //
    }

    public function render()
    {
        return view('livewire.pekerja.pembayaran.index', [
            'pembayarans' => $this->service->getAll($this->search),
        ]);
    }
}
