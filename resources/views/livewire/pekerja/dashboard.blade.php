<div class="container-fluid">

    {{-- Welcome Banner --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm overflow-hidden"
                style="background: linear-gradient(135deg, #6f42c1, #4361ee); border-radius: 18px;">
                <div class="card-body p-4 p-lg-5">

                    <div class="row align-items-center">

                        {{-- Info User --}}
                        <div class="col-lg-8">
                            <div class="d-flex align-items-center">

                                <div class="bg-white bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center me-3"
                                    style="width:70px;height:70px;">
                                    <i class="ri-user-3-line fs-2 text-white"></i>
                                </div>

                                <div>
                                    <h3 class="fw-bold text-white mb-1">
                                        Selamat Datang, {{ $user->nama_pekerja }}
                                    </h3>

                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <span class="badge bg-light text-dark px-3 py-2">
                                            {{ ucfirst($role) }}
                                        </span>
                                    </div>

                                    <p class="mb-0 text-white-50">
                                        Berikut ringkasan aktivitas dan statistik sistem laundry hari ini.
                                    </p>
                                </div>

                            </div>
                        </div>

                        {{-- Tanggal --}}
                        <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                            <div class="bg-white bg-opacity-10 rounded-3 p-3 d-inline-block">
                                <div class="d-flex align-items-center gap-2 text-white">
                                    <i class="ri-calendar-2-line fs-4"></i>
                                    <div class="text-start">
                                        <small class="d-block text-white-50">
                                            Tanggal Hari Ini
                                        </small>
                                        <strong>
                                            {{ now()->translatedFormat('d F Y') }}
                                        </strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="row g-3 mb-3">

        {{-- Total Pekerja --}}
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100 dashboard-stat-card">
                <div class="card-body d-flex align-items-center justify-content-between">

                    <div>
                        <h6 class="text-muted mb-2">
                            Total Pekerja
                        </h6>

                        <h3 class="fw-bold mb-0">
                            {{ $totalPekerja }}
                        </h3>
                    </div>

                    <div class="bg-primary bg-opacity-10 p-3 rounded-3">
                        <i class="bi bi-people-fill text-primary fs-3"></i>
                    </div>

                </div>
            </div>
        </div>

        {{-- Total Pelanggan --}}
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100 dashboard-stat-card">
                <div class="card-body d-flex align-items-center justify-content-between">

                    <div>
                        <h6 class="text-muted mb-2">
                            Total Pelanggan
                        </h6>

                        <h3 class="fw-bold mb-0">
                            {{ $totalPelanggan }}
                        </h3>
                    </div>

                    <div class="bg-success bg-opacity-10 p-3 rounded-3">
                        <i class="bi bi-person-badge-fill text-success fs-3"></i>
                    </div>

                </div>
            </div>
        </div>

        {{-- Status --}}
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100 dashboard-stat-card">
                <div class="card-body d-flex align-items-center justify-content-between">

                    <div>
                        <h6 class="text-muted mb-2">
                            Status Sistem
                        </h6>

                        <h5 class="fw-bold text-success mb-0">
                            Aktif
                        </h5>
                    </div>

                    <div class="bg-warning bg-opacity-10 p-3 rounded-3">
                        <i class="bi bi-shield-check text-warning fs-3"></i>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Charts --}}
    <div class="row g-3 mb-3 align-items-stretch">

        {{-- Pertumbuhan Pemesanan --}}
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <div class="bg-primary bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center"
                                style="width:38px;height:38px;">
                                <i class="bi bi-graph-up-arrow text-primary"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0">Pertumbuhan Pemesanan</h6>
                                <small class="text-muted">6 bulan terakhir</small>
                            </div>
                        </div>
                    </div>

                    <div wire:ignore>
                        <canvas id="pemesananChart" height="120"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Distribusi Status Proses --}}
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body p-4 d-flex flex-column">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <div class="bg-info bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center"
                                style="width:38px;height:38px;">
                                <i class="bi bi-bar-chart-line-fill text-info"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0">Status Proses</h6>
                                <small class="text-muted">{{ array_sum($statusData ?? []) }} total pesanan</small>
                            </div>
                        </div>
                    </div>

                    <div wire:ignore class="flex-grow-1 d-flex align-items-center">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<style>
    .dashboard-stat-card {
        border-radius: 14px;
        transition: transform .15s ease, box-shadow .15s ease;
    }

    .dashboard-stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 .5rem 1.5rem rgba(0, 0, 0, .08) !important;
    }
</style>

<script>
    (function() {
        const labels = @json($chartLabels ?? []);
        const data = @json($chartData ?? []);

        const statusLabels = @json($statusLabels ?? []);
        const statusData = @json($statusData ?? []);
        const statusColors = @json($statusColors ?? []);

        function renderChart() {
            const ctx = document.getElementById('pemesananChart');
            if (!ctx) return;

            if (ctx._chartInstance) {
                ctx._chartInstance.destroy();
            }

            ctx._chartInstance = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Pemesanan',
                        data: data,
                        borderColor: '#4361ee',
                        backgroundColor: 'rgba(67, 97, 238, 0.15)',
                        tension: 0.35,
                        fill: true,
                        pointRadius: 4,
                        pointBackgroundColor: '#4361ee',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        datalabels: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }

        function renderStatusChart() {
            const ctx = document.getElementById('statusChart');
            if (!ctx) return;

            if (ctx._chartInstance) {
                ctx._chartInstance.destroy();
            }

            ctx._chartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: statusLabels,
                    datasets: [{
                        label: 'Jumlah',
                        data: statusData,
                        backgroundColor: statusColors,
                        borderRadius: 6,
                        barThickness: 16,
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: true,
                    layout: {
                        padding: {
                            right: 24
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        datalabels: {
                            anchor: 'end',
                            align: 'end',
                            color: '#495057',
                            font: {
                                weight: 'bold',
                                size: 11
                            }
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            ticks: {
                                display: false
                            },
                            grid: {
                                display: false
                            },
                            border: {
                                display: false
                            }
                        },
                        y: {
                            grid: {
                                display: false
                            }
                        }
                    }
                },
                plugins: [ChartDataLabels]
            });
        }

        function renderAllCharts() {
            renderChart();
            renderStatusChart();
        }

        function loadScript(src) {
            return new Promise((resolve) => {
                const s = document.createElement('script');
                s.src = src;
                s.onload = resolve;
                document.head.appendChild(s);
            });
        }

        async function init() {
            if (typeof Chart === 'undefined') {
                await loadScript('https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js');
            }
            if (typeof ChartDataLabels === 'undefined') {
                await loadScript('https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js');
            }
            renderAllCharts();
        }

        init();

        document.addEventListener('livewire:navigated', renderAllCharts);
        Livewire.hook('morph.updated', () => {
            renderAllCharts();
        });
    })();
</script>