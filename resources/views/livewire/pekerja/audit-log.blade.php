<div wire:poll.60s>

    {{-- ══════════════════════════════════════════
         PAGE HEADER
    ══════════════════════════════════════════ --}}
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Audit Log</h3>
                    <p class="text-subtitle text-muted">
                        Riwayat seluruh aktivitas sistem — hanya dapat diakses oleh Super Admin.
                    </p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('pekerja.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Audit Log</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        {{-- ── Stat Cards ── --}}
        <section class="row mb-3">
            <div class="col-6 col-lg-3">
                <div class="card">
                    <div class="card-body px-3 py-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-md bg-light-secondary me-3">
                                <i class="bi bi-activity fs-4 text-secondary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-muted" style="font-size:.75rem">Total Hari Ini</h6>
                                <h4 class="mb-0 fw-bold">{{ $stats['total_today'] }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card">
                    <div class="card-body px-3 py-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-md bg-light-success me-3">
                                <i class="bi bi-box-arrow-in-right fs-4 text-success"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-muted" style="font-size:.75rem">Login Berhasil</h6>
                                <h4 class="mb-0 fw-bold text-success">{{ $stats['login_today'] }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card">
                    <div class="card-body px-3 py-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-md bg-light-danger me-3">
                                <i class="bi bi-x-octagon-fill fs-4 text-danger"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-muted" style="font-size:.75rem">Aktivitas Gagal</h6>
                                <h4 class="mb-0 fw-bold text-danger">{{ $stats['failed_today'] }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card">
                    <div class="card-body px-3 py-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-md bg-light-warning me-3">
                                <i class="bi bi-exclamation-triangle-fill fs-4 text-warning"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-muted" style="font-size:.75rem">Peringatan</h6>
                                <h4 class="mb-0 fw-bold text-warning">{{ $stats['warning_today'] }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ══════════════════════════════════════════
             FILTER + TABLE CARD
        ══════════════════════════════════════════ --}}
        <section class="section">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-shield-lock-fill text-primary me-2"></i>
                        Riwayat Aktivitas
                    </h5>
                    <div class="d-flex gap-2 flex-wrap">
                        <button wire:click="resetFilters" class="btn btn-sm btn-light-secondary">
                            <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                        </button>
                        <button wire:click="exportCsv" class="btn btn-sm btn-light-primary">
                            <i class="bi bi-download me-1"></i> Export CSV
                            <span wire:loading wire:target="exportCsv" class="spinner-border spinner-border-sm ms-1"></span>
                        </button>
                    </div>
                </div>

                {{-- ── Filter Bar ── --}}
                <div class="card-body border-bottom pb-3">
                    <div class="row g-2">
                        <div class="col-12 col-md-4">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                <input
                                    type="search"
                                    class="form-control"
                                    placeholder="Cari nama, email, IP, event..."
                                    wire:model.live.debounce.400ms="search">
                            </div>
                        </div>
                        <div class="col-6 col-md-2">
                            <select class="form-select form-select-sm" wire:model.live="event">
                                <option value="">Semua Event</option>
                                <optgroup label="Autentikasi">
                                    <option value="login">Login</option>
                                    <option value="logout">Logout</option>
                                    <option value="login_failed">Gagal Login</option>
                                    <option value="rate_limited">Rate Limited</option>
                                    <option value="access_code">Kode Akses</option>
                                    <option value="2fa">2FA</option>
                                </optgroup>
                                <optgroup label="Data">
                                    <option value="view">Lihat Data</option>
                                    <option value="create">Tambah Data</option>
                                    <option value="update">Update Data</option>
                                    <option value="delete">Hapus Data</option>
                                </optgroup>
                            </select>
                        </div>
                        <div class="col-6 col-md-2">
                            <select class="form-select form-select-sm" wire:model.live="status">
                                <option value="">Semua Status</option>
                                <option value="success">Berhasil</option>
                                <option value="failed">Gagal</option>
                                <option value="warning">Peringatan</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-2">
                            <input
                                type="date"
                                class="form-control form-control-sm"
                                wire:model.live="dateFrom"
                                title="Dari tanggal">
                        </div>
                        <div class="col-6 col-md-2">
                            <input
                                type="date"
                                class="form-control form-control-sm"
                                wire:model.live="dateTo"
                                title="Sampai tanggal">
                        </div>
                    </div>
                </div>

                {{-- ── Table ── --}}
                <div class="card-body p-0">
                    <div class="table-responsive" wire:loading.class="opacity-50">
                        <table class="table table-hover table-sm mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">Waktu</th>
                                    <th>Pengguna</th>
                                    <th>Event</th>
                                    <th>Objek</th>
                                    <th>IP Address</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($logs as $log)
                                <tr class="{{ $log->status === 'failed' ? 'table-danger bg-opacity-25' : ($log->status === 'warning' ? 'table-warning bg-opacity-25' : '') }}">

                                    {{-- Waktu --}}
                                    <td class="ps-3" style="white-space:nowrap">
                                        <span class="fw-semibold" style="font-size:.8rem">
                                            {{ $log->created_at->format('d/m/Y') }}
                                        </span><br>
                                        <small class="text-muted">{{ $log->created_at->format('H:i:s') }}</small>
                                    </td>

                                    {{-- Pengguna --}}
                                    <td>
                                        <span class="fw-semibold d-block" style="font-size:.85rem">
                                            {{ $log->nama_pekerja ?? '—' }}
                                        </span>
                                        <small class="text-muted">{{ $log->email ?? '' }}</small>
                                    </td>

                                    {{-- Event --}}
                                    <td style="white-space:nowrap; font-size:.85rem">
                                        {{ $log->event_icon }} {{ $log->event_label }}
                                    </td>

                                    {{-- Objek --}}
                                    <td class="text-muted" style="font-size:.8rem">
                                        {{ $log->auditable_label ?? '—' }}
                                    </td>

                                    {{-- IP --}}
                                    <td>
                                        <code style="font-size:.75rem; color:inherit">
                                            {{ $log->ip_address ?? '—' }}
                                        </code>
                                    </td>

                                    {{-- Status Badge --}}
                                    <td>
                                        @if ($log->status === 'success')
                                        <span class="badge bg-light-success text-success">Berhasil</span>
                                        @elseif ($log->status === 'failed')
                                        <span class="badge bg-light-danger text-danger">Gagal</span>
                                        @else
                                        <span class="badge bg-light-warning text-warning">Peringatan</span>
                                        @endif
                                    </td>

                                    {{-- Detail --}}
                                    <td class="text-center">
                                        <button
                                            wire:click="showDetail({{ $log->id }})"
                                            class="btn btn-sm btn-light-primary px-2 py-1"
                                            title="Lihat detail">
                                            <i class="bi bi-eye-fill"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-5">
                                        <i class="bi bi-inbox fs-3 d-block mb-2 opacity-50"></i>
                                        Tidak ada aktivitas yang ditemukan.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- ── Pagination ── --}}
                @if ($logs->hasPages())
                <div class="card-footer d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <small class="text-muted">
                        Menampilkan {{ $logs->firstItem() }}–{{ $logs->lastItem() }}
                        dari {{ $logs->total() }} entri
                    </small>
                    {{ $logs->links() }}
                </div>
                @endif
            </div>
        </section>
    </div>

    {{-- ══════════════════════════════════════════
         DETAIL MODAL
    ══════════════════════════════════════════ --}}
    @if ($showDetail && $detail)
    <div
        class="modal fade show d-block"
        tabindex="-1"
        role="dialog"
        aria-modal="true"
        aria-labelledby="auditDetailTitle"
        style="background:rgba(0,0,0,.45)">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="auditDetailTitle">
                        {{ $detail->event_icon }} {{ $detail->event_label }}
                    </h5>
                    <button
                        type="button"
                        wire:click="closeDetail"
                        class="btn-close"
                        aria-label="Tutup"></button>
                </div>

                <div class="modal-body">
                    <table class="table table-sm table-borderless mb-0" style="font-size:.875rem">
                        <tbody>
                            <tr>
                                <td class="text-muted fw-semibold" width="38%">Waktu</td>
                                <td>{{ $detail->created_at->format('d/m/Y H:i:s') }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted fw-semibold">Pengguna</td>
                                <td>
                                    {{ $detail->user_name ?? '—' }}
                                    @if($detail->user_email)
                                    <br><small class="text-muted">{{ $detail->user_email }}</small>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted fw-semibold">Event</td>
                                <td><code>{{ $detail->event }}</code></td>
                            </tr>
                            <tr>
                                <td class="text-muted fw-semibold">Status</td>
                                <td>
                                    @if ($detail->status === 'success')
                                    <span class="badge bg-light-success text-success">Berhasil</span>
                                    @elseif ($detail->status === 'failed')
                                    <span class="badge bg-light-danger text-danger">Gagal</span>
                                    @else
                                    <span class="badge bg-light-warning text-warning">Peringatan</span>
                                    @endif
                                </td>
                            </tr>
                            @if ($detail->auditable_label)
                            <tr>
                                <td class="text-muted fw-semibold">Objek</td>
                                <td>
                                    {{ $detail->auditable_label }}
                                    <br>
                                    <small class="text-muted">
                                        {{ class_basename($detail->auditable_type) }}
                                        #{{ $detail->auditable_id }}
                                    </small>
                                </td>
                            </tr>
                            @endif
                            <tr>
                                <td class="text-muted fw-semibold">IP Address</td>
                                <td><code>{{ $detail->ip_address ?? '—' }}</code></td>
                            </tr>
                            <tr>
                                <td class="text-muted fw-semibold">URL</td>
                                <td style="word-break:break-all">
                                    <small><code>{{ $detail->url ?? '—' }}</code></small>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted fw-semibold">Method</td>
                                <td>
                                    <span class="badge bg-light-secondary text-secondary">
                                        {{ $detail->method ?? '—' }}
                                    </span>
                                </td>
                            </tr>
                            @if ($detail->description)
                            <tr>
                                <td class="text-muted fw-semibold">Keterangan</td>
                                <td>{{ $detail->description }}</td>
                            </tr>
                            @endif
                            @if ($detail->user_agent)
                            <tr>
                                <td class="text-muted fw-semibold">User Agent</td>
                                <td>
                                    <small class="text-muted" style="word-break:break-all">
                                        {{ $detail->user_agent }}
                                    </small>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>

                    {{-- Nilai Sebelumnya --}}
                    @if ($detail->old_values)
                    <hr>
                    <p class="text-muted fw-semibold mb-1" style="font-size:.8rem">
                        <i class="bi bi-arrow-left-circle me-1 text-danger"></i>
                        Nilai Sebelumnya
                    </p>
                    <pre class="bg-light rounded p-2 mb-0" style="font-size:.75rem; max-height:180px; overflow-y:auto">{{ json_encode($detail->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                    @endif

                    {{-- Nilai Sesudahnya --}}
                    @if ($detail->new_values)
                    <hr>
                    <p class="text-muted fw-semibold mb-1" style="font-size:.8rem">
                        <i class="bi bi-arrow-right-circle me-1 text-success"></i>
                        Nilai Sesudahnya
                    </p>
                    <pre class="bg-light rounded p-2 mb-0" style="font-size:.75rem; max-height:180px; overflow-y:auto">{{ json_encode($detail->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                    @endif
                </div>

                <div class="modal-footer">
                    <button
                        type="button"
                        wire:click="closeDetail"
                        class="btn btn-light-secondary">
                        Tutup
                    </button>
                </div>

            </div>
        </div>
    </div>
    @endif
</div>