<?php

namespace App\Livewire\Pekerja;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\Pekerja;
use App\Models\Pelanggan;
use App\Models\Pemesanan;
use App\Models\Proses;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('backend.layouts.app')]
#[Title('Dashboard')]
class Dashboard extends Component
{
    public $user;
    public $totalPekerja;
    public $totalPelanggan;
    public $role;

    public $chartLabels = [];
    public $chartData = [];

    public $statusLabels = [];
    public $statusData = [];
    public $statusColors = [];

    public function mount()
    {
        $this->user = Auth::guard('pekerja')->user();

        $this->totalPekerja = Pekerja::count();
        $this->totalPelanggan = Pelanggan::count();

        $this->role = $this->user->getRoleNames()->first();

        $this->loadChartData();
        $this->loadStatusData();
    }

    protected function loadChartData()
    {
        // Ambil jumlah pemesanan untuk 6 bulan terakhir (termasuk bulan ini)
        $months = collect(range(5, 0))->map(function ($i) {
            return Carbon::now()->subMonths($i);
        });

        $counts = Pemesanan::select(
            DB::raw("DATE_FORMAT(tanggal_pemesanan, '%Y-%m') as ym"),
            DB::raw('COUNT(*) as total')
        )
            ->where('tanggal_pemesanan', '>=', Carbon::now()->subMonths(5)->startOfMonth())
            ->groupBy('ym')
            ->pluck('total', 'ym');

        $this->chartLabels = $months->map(fn($m) => $m->translatedFormat('M Y'))->values()->toArray();

        $this->chartData = $months->map(function ($m) use ($counts) {
            return (int) ($counts[$m->format('Y-m')] ?? 0);
        })->values()->toArray();
    }

    protected function loadStatusData()
    {
        // Urutan & warna tetap untuk setiap status proses
        $statusMap = [
            'Menunggu'     => '#adb5bd',
            'Penjemputan'  => '#4361ee',
            'Pencucian'    => '#0dcaf0',
            'Penyetrikaan' => '#ffc107',
            'Pengantaran'  => '#fd7e14',
            'Selesai'      => '#198754',
        ];

        $counts = Proses::select('proses', DB::raw('COUNT(*) as total'))
            ->groupBy('proses')
            ->pluck('total', 'proses');

        $this->statusLabels = array_keys($statusMap);
        $this->statusColors = array_values($statusMap);
        $this->statusData = collect($this->statusLabels)
            ->map(fn($status) => (int) ($counts[$status] ?? 0))
            ->toArray();
    }

    public function render()
    {
        return view('livewire.pekerja.dashboard');
    }
}
