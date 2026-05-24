<?php

namespace App\Livewire\Pekerja;

use App\Models\AuditLog as AuditLogModel;
use Illuminate\Support\Facades\Response;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('backend.layouts.app')]
class AuditLog extends Component
{
    use WithPagination;

    public string $search = '';
    public string $event = '';
    public string $status = '';
    public string $dateFrom = '';
    public string $dateTo = '';
    public int $perPage = 15;
    public bool $showDetail = false;
    public ?int $detailId = null;

    protected $queryString = [
        'search'   => ['except' => ''],
        'event'    => ['except' => ''],
        'status'   => ['except' => ''],
        'dateFrom' => ['except' => ''],
        'dateTo'   => ['except' => ''],
    ];

    public function mount(): void
    {
        abort_unless(
            auth()->check() && auth()->user()->hasRole('super admin'),
            403
        );
    }

    public function boot(): void
    {
        abort_unless(
            auth()->check() && auth()->user()->hasRole('super admin'),
            403
        );
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingEvent(): void
    {
        $this->resetPage();
    }

    public function updatingStatus(): void
    {
        $this->resetPage();
    }

    public function updatingDateFrom(): void
    {
        $this->resetPage();
    }

    public function updatingDateTo(): void
    {
        $this->resetPage();
    }

    private function baseQuery()
    {
        return AuditLogModel::with('pekerja')
            ->when($this->search, fn($q) => $q->search($this->search))
            ->when($this->event, fn($q) => $q->byEvent($this->event))
            ->when($this->status, fn($q) => $q->byStatus($this->status))
            ->inDateRange(
                $this->dateFrom ?: null,
                $this->dateTo ?: null
            );
    }

    public function getLogs()
    {
        return $this->baseQuery()
            ->orderByDesc('created_at')
            ->paginate($this->perPage);
    }

    public function getStats(): array
    {
        $today = AuditLogModel::whereDate('created_at', today());

        return [
            'total_today'   => (clone $today)->count(),
            'failed_today'  => (clone $today)->byStatus('failed')->count(),
            'warning_today' => (clone $today)->byStatus('warning')->count(),
            'login_today'   => (clone $today)->byEvent('login')->count(),
        ];
    }

    public function showDetail(int $id): void
    {
        $this->detailId = $id;
        $this->showDetail = true;
    }

    public function closeDetail(): void
    {
        $this->showDetail = false;
        $this->detailId = null;
    }

    public function getDetailLog(): ?AuditLogModel
    {
        return $this->detailId
            ? AuditLogModel::find($this->detailId)
            : null;
    }

    public function resetFilters(): void
    {
        $this->reset([
            'search',
            'event',
            'status',
            'dateFrom',
            'dateTo'
        ]);

        $this->resetPage();
    }

    public function exportCsv()
    {
        abort_unless(
            auth()->user()->hasRole('super admin'),
            403
        );

        $logs = $this->baseQuery()
            ->orderByDesc('created_at')
            ->get([
                'created_at',
                'nama_pekerja',
                'email',
                'event_label',
                'auditable_label',
                'ip_address',
                'status',
                'description',
            ]);

        $filename = 'audit_log_' . now()->format('Ymd_His') . '.csv';

        $callback = function () use ($logs) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'Waktu',
                'nama_pekerja',
                'Email',
                'Event',
                'Objek',
                'IP',
                'Status',
                'Keterangan',
            ]);

            foreach ($logs as $log) {
                fputcsv($handle, [
                    $log->created_at?->format('d/m/Y H:i:s'),
                    $log->nama_pekerja ?? '-',
                    $log->email ?? '-',
                    $log->event_label,
                    $log->auditable_label ?? '-',
                    $log->ip_address ?? '-',
                    $log->status,
                    $log->description ?? '-',
                ]);
            }

            fclose($handle);
        };

        return Response::stream($callback, 200, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ]);
    }

    public function render()
    {
        return view('livewire.pekerja.audit-log', [
            'logs'   => $this->getLogs(),
            'stats'  => $this->getStats(),
            'detail' => $this->getDetailLog(),
        ]);
    }
}
