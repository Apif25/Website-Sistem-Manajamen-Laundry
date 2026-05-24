<div>
    {{-- Page Title --}}
    <div class="page-title mb-4">
        <div class="row align-items-center">

            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3 class="mb-1">Manajemen Keuangan</h3>
                <p class="text-subtitle text-muted mb-0">
                    Kelola data seluruh keuangan laundry
                </p>
            </div>

            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('pekerja.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Keuangan
                        </li>
                    </ol>
                </nav>
            </div>

        </div>
    </div>

    {{-- Flash Message --}}
    @if (session()->has('success'))
    <div wire:key="success-alert"
        class="alert alert-success alert-dismissible fade show mb-3"
        role="alert">
        <i class="bi bi-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- Card --}}
    <div class="card">

        {{-- Card Header --}}
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h4 class="card-title mb-0">Data Keuangan</h4>
                <small class="text-muted">Daftar seluruh data keuangan</small>
            </div>
            @if ($canManage)
            <button wire:click="openCreate" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg me-1"></i> Tambah Keuangan
            </button>
            @else
            <span class="badge bg-light text-dark border px-3 py-2">
                <i class="bi bi-shield-lock me-1"></i>
                Akses Terbatas
            </span>
            @endif
        </div>

        {{-- Card Body --}}
        <div class="card-body">

            {{-- Filter & Action --}}
            <div class="row mb-3 align-items-end">

                {{-- Search --}}
                <div class="col-12 col-md-4 mb-2">
                    <label class="form-label fw-semibold">Cari Data</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-search"></i>
                        </span>
                        <input
                            type="text"
                            wire:model.live.debounce.400ms="search"
                            class="form-control"
                            placeholder="Cari keuangan...">
                    </div>
                </div>

                {{-- Bulan --}}
                <div class="col-6 col-md-2 mb-2">
                    <label class="form-label fw-semibold">Bulan</label>
                    <select wire:model.live="bulan" class="form-select">
                        @foreach ([
                        1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
                        4 => 'April', 5 => 'Mei', 6 => 'Juni',
                        7 => 'Juli', 8 => 'Agustus', 9 => 'September',
                        10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                        ] as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Tahun --}}
                <div class="col-6 col-md-2 mb-2">
                    <label class="form-label fw-semibold">Tahun</label>
                    <select wire:model.live="tahun" class="form-select">
                        @for ($i = now()->year; $i >= 2020; $i--)
                        <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>

                {{-- Tombol PDF --}}
                <div class="col-12 col-md-4 mb-2">
                    <a href="{{ route('pekerja.keuangan.pdf', ['bulan' => $bulan, 'tahun' => $tahun]) }}"
                        target="_blank"
                        class="btn btn-danger w-100">
                        <i class="bi bi-file-earmark-pdf me-1"></i>
                        Cetak Laporan PDF
                    </a>
                </div>

            </div>

            {{-- Ringkasan Keuangan --}}
            <div class="row g-3 mb-4">

                @php
                $totalPemasukan = $keuangans->where('jenis', 'Pemasukan')->sum('jumlah');
                $totalPengeluaran = $keuangans->where('jenis', 'Pengeluaran')->sum('jumlah');
                $saldo = $totalPemasukan - $totalPengeluaran;
                @endphp

                <div class="col-md-4">
                    <div class="card border shadow-sm h-100">
                        <div class="card-body">
                            <small class="text-muted">Total Pemasukan</small>
                            <h4 class="text-success mb-0">
                                Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
                            </h4>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border shadow-sm h-100">
                        <div class="card-body">
                            <small class="text-muted">Total Pengeluaran</small>
                            <h4 class="text-danger mb-0">
                                Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
                            </h4>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border shadow-sm h-100">
                        <div class="card-body">
                            <small class="text-muted">Saldo Bersih</small>
                            <h4 class="{{ $saldo >= 0 ? 'text-primary' : 'text-danger' }} mb-0">
                                Rp {{ number_format($saldo, 0, ',', '.') }}
                            </h4>
                        </div>
                    </div>
                </div>

            </div>


            {{-- Table --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle text-nowrap mb-0">
                    <thead class="table-light text-center align-middle">
                        <tr>
                            <th width="5%">ID</th>
                            <th>ID Pembayaran</th>
                            <th>Tanggal</th>
                            <th>Jenis</th>
                            <th>Kategori</th>
                            <th>Jumlah</th>
                            <th>Keterangan</th>
                            <th>Pekerja</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($keuangans as $keuangan)
                        <tr>
                            <td class="text-center fw-semibold">
                                {{ $loop->iteration }}
                            </td>

                            <td class="text-center">
                                <span class="badge bg-secondary px-3 py-2">
                                    {{ $keuangan->pembayaran?->id_pembayaran ? '#' . $keuangan->pembayaran->id_pembayaran : '-' }}
                                </span>
                            </td>

                            <td class="text-center">
                                {{ \Carbon\Carbon::parse($keuangan->tanggal)->format('d M Y, H:i') }}
                            </td>

                            <td class="text-center">
                                @if ($keuangan->jenis === 'Pemasukan')
                                <span class="badge bg-success px-3 py-2">
                                    <i class="bi bi-arrow-up-circle me-1"></i>Pemasukan
                                </span>
                                @else
                                <span class="badge bg-danger px-3 py-2">
                                    <i class="bi bi-arrow-down-circle me-1"></i>Pengeluaran
                                </span>
                                @endif
                            </td>

                            <td class="text-center">
                                <span class="badge bg-info text-dark px-3 py-2">
                                    {{ $keuangan->kategori }}
                                </span>
                            </td>

                            <td class="fw-semibold text-end">
                                Rp {{ number_format($keuangan->jumlah, 0, ',', '.') }}
                            </td>

                            <td style="max-width: 220px;">
                                <div
                                    class="text-truncate text-muted"
                                    style="max-width: 220px;"
                                    title="{{ $keuangan->keterangan }}">
                                    {{ $keuangan->keterangan ?? '-' }}
                                </div>
                            </td>

                            <td class="text-center">
                                {{ $keuangan->pekerja?->nama_pekerja ?? '-' }}
                            </td>

                            <td class="text-center">
                                @if ($canManage)
                                <div class="d-flex justify-content-center gap-1">
                                    <button
                                        wire:click="openShow({{ $keuangan->id_keuangan }})"
                                        class="btn btn-sm btn-info text-white">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button
                                        wire:click="openEdit({{ $keuangan->id_keuangan }})"
                                        class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button
                                        wire:click="delete({{ $keuangan->id_keuangan }})"
                                        wire:confirm="Yakin ingin menghapus data keuangan ini?"
                                        class="btn btn-sm btn-danger"
                                        title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                                @else
                                {{-- Owner: hanya bisa lihat detail --}}
                                <button
                                    wire:click="openShow({{ $keuangan->id_keuangan }})"
                                    class="btn btn-sm btn-info text-white">
                                    <i class="bi bi-eye me-1"></i>Lihat
                                </button>
                                @endif
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-5">
                                <i class="bi bi-database-x fs-4 d-block mb-2"></i>
                                Data keuangan tidak ditemukan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    {{-- Modal Form — hanya owner --}}
    @if ($canManage)
    @livewire('pekerja.keuangan.form')
    @endif

    {{-- Modal Show — semua role (owner) --}}
    @if ($detail)
    <div class="modal fade show d-block"
        tabindex="-1"
        style="background-color: rgba(0,0,0,0.5)">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">

                {{-- Header --}}
                <div class="modal-header">
                    <h5 class="modal-title fw-semibold">
                        <i class="bi bi-wallet2 me-2"></i>Detail Keuangan
                    </h5>
                    <button class="btn-close" wire:click="closeShow"></button>
                </div>

                {{-- Body --}}
                <div class="modal-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <th width="35%">ID Pembayaran</th>
                            <td>
                                {{ $detail->pembayaran?->id_pembayaran ? '#' . $detail->pembayaran->id_pembayaran : '-' }}
                            </td>
                        </tr>
                        <tr>
                            <th>Tanggal</th>
                            <td>{{ \Carbon\Carbon::parse($detail->tanggal)->format('d M Y, H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Jenis</th>
                            <td>
                                @if ($detail->jenis === 'Pemasukan')
                                <span class="badge bg-success">Pemasukan</span>
                                @else
                                <span class="badge bg-danger">Pengeluaran</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Kategori</th>
                            <td>
                                <span class="badge bg-info text-dark">{{ $detail->kategori }}</span>
                            </td>
                        </tr>
                        <tr>
                            <th>Jumlah</th>
                            <td class="fw-semibold">
                                Rp {{ number_format($detail->jumlah, 0, ',', '.') }}
                            </td>
                        </tr>
                        <tr>
                            <th>Keterangan</th>
                            <td>{{ $detail->keterangan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Pekerja</th>
                            <td>{{ $detail->pekerja?->nama_pekerja ?? '-' }}</td>
                        </tr>
                    </table>
                </div>

                {{-- Footer --}}
                <div class="modal-footer">
                    <button class="btn btn-secondary" wire:click="closeShow">
                        Tutup
                    </button>
                </div>

            </div>
        </div>
    </div>
    @endif

</div>