<?php

namespace App\Livewire\Pekerja\Keuangan;

use App\Services\KeuanganService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('backend.layouts.app')]
class Index extends Component
{
    public string $search = '';
    public $detail = null;
    public $bulan;
    public $tahun;

    public function mount(): void
    {
        $this->bulan = now()->month;
        $this->tahun = now()->year;
    }

    /**
     * Hanya manajer yang bisa create/edit/delete.
     * Owner hanya bisa read (index).
     */
    public function canManage(): bool
    {
        return Auth::guard('pekerja')->user()->hasRole('manajer');
    }

    public function openCreate(): void
    {
        abort_unless($this->canManage(), 403);
        $this->dispatch('open-form-keuangan', mode: 'create', id: null);
    }

    public function openEdit(int $id): void
    {
        abort_unless($this->canManage(), 403);
        $this->dispatch('open-form-keuangan', mode: 'edit', id: $id);
    }

    public function openShow(int $id, KeuanganService $service): void
    {
        $this->detail = $service->findById($id);
    }

    public function closeShow(): void
    {
        $this->detail = null;
    }

    public function delete(int $id, KeuanganService $service): void
    {
        abort_unless($this->canManage(), 403);
        $service->destroy($id);
        session()->flash('success', 'Data keuangan berhasil dihapus.');
    }

    #[On('keuangan-saved')]
    public function handleSaved(): void
    {
        // otomatis refresh
    }

    public function render(KeuanganService $service)
    {
        $keuangans = $service->query()
            ->whereMonth('tanggal', $this->bulan)
            ->whereYear('tanggal', $this->tahun)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('keterangan', 'like', '%' . $this->search . '%')
                        ->orWhere('kategori', 'like', '%' . $this->search . '%')
                        ->orWhere('jenis', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('tanggal', 'asc')
            ->get();

        return view('livewire.pekerja.keuangan.index', [
            'keuangans'  => $keuangans,
            'canManage'  => $this->canManage(),
        ]);
    }
}
