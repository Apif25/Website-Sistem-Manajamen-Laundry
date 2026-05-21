<?php

namespace App\Livewire\Pekerja\Proses;

use App\Models\Pesanan;
use App\Models\Proses as ProsesModel;
use App\Services\ProsesService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\View\View;

#[Layout('backend.layouts.app')]
#[Title('Manajemen Proses')]
class Index extends Component
{
    use WithPagination;

    public bool $showCreateModal = false;
    public int|string $selectedPesananId = '';

    public bool $showEditModal = false;
    public $editProsesId = null; // tanpa type hint
    public string $editStep = '';

    public bool $showDeleteModal = false;
    public $deleteProsesId = null; // tanpa type hint

    #[Url]
    public string $search = '';

    #[Url]
    public string $filterStep = '';

    // ────────────────────────────────────────────────────────
    private function service(): ProsesService
    {
        return app(ProsesService::class);
    }

    protected function flash(string $message, string $type = 'success'): void
    {
        session()->flash($type, $message);
    }

    // ────────────────────────────────────────────────────────
    public function updatingSearch(): void
    {
        $this->resetPage();
    }
    public function updatingFilterStep(): void
    {
        $this->resetPage();
    }

    // ── CREATE ───────────────────────────────────────────────
    public function openCreateModal(): void
    {
        $this->reset('selectedPesananId');
        $this->resetValidation();
        $this->showCreateModal = true;
    }

    public function store(): void
    {
        $this->validate([
            'selectedPesananId' => 'required|integer|exists:pesanan,id_pesanan',
        ]);

        try {
            $this->service()->createProses((int) $this->selectedPesananId);
            $this->showCreateModal = false;
            $this->reset('selectedPesananId');
            $this->flash('Proses berhasil dibuat.');
        } catch (\InvalidArgumentException $e) {
            $this->addError('selectedPesananId', $e->getMessage());
        }
    }

    // ── ADVANCE ──────────────────────────────────────────────
    public function advance($id): void // tanpa type hint int
    {
        try {
            $this->service()->advanceProses((int) $id);
            $this->flash('Berhasil dilanjutkan ke tahap berikutnya.');
        } catch (\LogicException $e) {
            $this->flash($e->getMessage(), 'error');
        }
    }

    // ── EDIT ─────────────────────────────────────────────────
    public function openEditModal($id): void // tanpa type hint int
    {
        $proses = ProsesModel::findOrFail($id);
        $this->editProsesId = $id;
        $this->editStep     = $proses->proses;
        $this->resetValidation();
        $this->showEditModal = true;
    }

    public function update(): void
    {
        $this->validate([
            'editStep' => 'required|in:' . implode(',', ProsesModel::STEPS),
        ]);

        $this->service()->updateProses($this->editProsesId, $this->editStep);
        $this->showEditModal = false;
        $this->reset('editProsesId', 'editStep');
        $this->flash('Proses berhasil diperbarui.');
    }

    // ── DELETE ───────────────────────────────────────────────
    public function confirmDelete($id): void // tanpa type hint int
    {
        $this->deleteProsesId = $id;
        $this->showDeleteModal = true;
    }

    public function destroy(): void
    {
        if ($this->deleteProsesId) {
            $this->service()->deleteProses($this->deleteProsesId);
        }

        $this->showDeleteModal = false;
        $this->reset('deleteProsesId');
        $this->flash('Proses berhasil dihapus.');
    }

    // ── RENDER ───────────────────────────────────────────────
    public function render(): view
    {
        $search = $this->search;
        $filterStep = $this->filterStep;

        $prosesList = ProsesModel::query()
            ->with(['pesanan'])
            ->when($search, function ($query) use ($search) {
                $query->whereHas('pesanan', function ($q) use ($search) {
                    $q->where('id_pesanan', 'like', "%{$search}%");
                });
            })
            ->when($filterStep, function ($query) use ($filterStep) {
                $query->where('proses', $filterStep);
            })
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        $pesananList = Pesanan::query()
            ->orderByDesc('id_pesanan')
            ->get();

        $steps = ProsesModel::STEPS;

        return view('livewire.pekerja.proses.index', [
            'prosesList'  => $prosesList,
            'pesananList' => $pesananList,
            'steps'       => $steps,
        ]);
    }
}
