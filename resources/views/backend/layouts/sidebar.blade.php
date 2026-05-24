<div class="sidebar-wrapper active">
    <div class="sidebar-header position-relative">
        <div class="d-flex justify-content-between align-items-center">
            <div class="logo">
                <a href="{{ route('pekerja.dashboard') }}"><img src="{{ asset('templates/backend/assets/compiled/svg/logo.svg') }}" alt="Logo" srcset=""></a>
            </div>
            <div
                x-data="themeHandler()"
                x-init="init()"
                class="theme-toggle d-flex gap-2 align-items-center mt-2">

                <!-- Sun -->
                <svg xmlns="http://www.w3.org/2000/svg"
                    aria-hidden="true"
                    role="img"
                    class="iconify iconify--system-uicons"
                    width="20"
                    height="20"
                    preserveAspectRatio="xMidYMid meet"
                    viewBox="0 0 21 21">

                    <g fill="none"
                        fill-rule="evenodd"
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round">

                        <path
                            d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2"
                            opacity=".3">
                        </path>

                        <g transform="translate(-210 -1)">
                            <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                            <circle cx="220.5" cy="11.5" r="4"></circle>
                            <path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2"></path>
                        </g>
                    </g>
                </svg>

                <!-- Toggle -->
                <div class="form-check form-switch fs-6 mb-0">
                    <input
                        class="form-check-input me-0"
                        type="checkbox"
                        id="toggle-dark"
                        style="cursor: pointer"
                        x-model="darkMode"
                        @change="toggleTheme()">
                </div>

                <!-- Moon -->
                <svg xmlns="http://www.w3.org/2000/svg"
                    aria-hidden="true"
                    role="img"
                    class="iconify iconify--mdi"
                    width="20"
                    height="20"
                    preserveAspectRatio="xMidYMid meet"
                    viewBox="0 0 24 24">

                    <path fill="currentColor"
                        d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89">
                    </path>
                </svg>
            </div>
            <div class="sidebar-toggler  x">
                <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
            </div>
        </div>
    </div>
    <div class="sidebar-menu">
        <ul class="menu">
            <li class="sidebar-title">Menu</li>

            {{-- Dashboard — semua role --}}
            <li class="sidebar-item {{ request()->routeIs('pekerja.dashboard') ? 'active' : '' }}">
                <a href="{{ route('pekerja.dashboard') }}" wire:navigate class="sidebar-link">
                    <i class="bi bi-grid-fill"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            {{-- =============================================
                SUPER ADMIN: Manajemen Akun + Audit Log
            ============================================== --}}
            @role('super admin')
            <li class="sidebar-title">Manajemen Akun</li>

            <li class="sidebar-item {{ request()->routeIs('pekerja.index') ? 'active' : '' }}">
                <a href="{{ route('pekerja.index') }}" wire:navigate class="sidebar-link">
                    <i class="bi bi-person-circle"></i>
                    <span>Pekerja</span>
                </a>
            </li>

            <li class="sidebar-item {{ request()->routeIs('pekerja.pelanggan.index') ? 'active' : '' }}">
                <a href="{{ route('pekerja.pelanggan.index') }}" wire:navigate class="sidebar-link">
                    <i class="bi bi-person-circle"></i>
                    <span>Pelanggan</span>
                </a>
            </li>

            {{-- ── Keamanan & Audit ── --}}
            <li class="sidebar-title">Keamanan</li>

            <li class="sidebar-item {{ request()->routeIs('pekerja.audit-log') ? 'active' : '' }}">
                <a href="{{ route('pekerja.audit-log') }}" wire:navigate class="sidebar-link">
                    <i class="bi bi-shield-lock-fill"></i>
                    <span>Audit Log</span>

                    {{-- Badge: jumlah event gagal/warning hari ini --}}
                    @php
                    $alertCount = \App\Models\AuditLog::whereDate('created_at', today())
                    ->whereIn('status', ['failed', 'warning'])
                    ->count();
                    @endphp
                    @if ($alertCount > 0)
                    <span
                        class="badge bg-danger rounded-pill ms-auto"
                        style="font-size:.65rem; min-width:20px"
                        title="{{ $alertCount }} aktivitas mencurigakan hari ini">
                        {{ $alertCount > 99 ? '99+' : $alertCount }}
                    </span>
                    @endif
                </a>
            </li>
            @endrole

            {{-- =============================================
                PETUGAS: Pemesanan, Transaksi, Stok
            ============================================== --}}
            @hasanyrole('petugas|owner')
            <li class="sidebar-title">Manajemen Pemesanan</li>

            <li class="sidebar-item {{ request()->routeIs('pekerja.pemesanan.index') ? 'active' : '' }}">
                <a href="{{ route('pekerja.pemesanan.index') }}" wire:navigate class="sidebar-link">
                    <i class="bi-cart"></i>
                    <span>Pemesanan</span>
                </a>
            </li>

            <li class="sidebar-item {{ request()->routeIs('pekerja.pesanan.index') ? 'active' : '' }}">
                <a href="{{ route('pekerja.pesanan.index') }}" wire:navigate class="sidebar-link">
                    <i class="bi-bag"></i>
                    <span>Pesanan</span>
                </a>
            </li>

            <li class="sidebar-item {{ request()->routeIs('pekerja.proses.index') ? 'active' : '' }}">
                <a href="{{ route('pekerja.proses.index') }}" wire:navigate class="sidebar-link">
                    <i class="bi-hourglass-split"></i>
                    <span>Proses</span>
                </a>
            </li>

            <li class="sidebar-title">Manajemen Transaksi</li>

            <li class="sidebar-item {{ request()->routeIs('pekerja.pembayaran.index') ? 'active' : '' }}">
                <a href="{{ route('pekerja.pembayaran.index') }}" wire:navigate class="sidebar-link">
                    <i class="bi-receipt"></i>
                    <span>Pembayaran</span>
                </a>
            </li>

            <li class="sidebar-title">Manajemen Stok</li>

            <li class="sidebar-item {{ request()->routeIs('pekerja.stockbarang.index') ? 'active' : '' }}">
                <a href="{{ route('pekerja.stockbarang.index') }}" wire:navigate class="sidebar-link">
                    <i class="bi-box"></i>
                    <span>Stock Barang</span>
                </a>
            </li>

            <li class="sidebar-item {{ request()->routeIs('pekerja.inventaris.index') ? 'active' : '' }}">
                <a href="{{ route('pekerja.inventaris.index') }}" wire:navigate class="sidebar-link">
                    <i class="bi-collection"></i>
                    <span>Inventaris</span>
                </a>
            </li>
            @endhasanyrole

            {{-- =============================================
                OWNER: Keuangan
            ============================================== --}}
            @hasanyrole('owner')
            <li class="sidebar-title">Manajemen Transaksi</li>

            <li class="sidebar-item {{ request()->routeIs('pekerja.keuangan.index') ? 'active' : '' }}">
                <a href="{{ route('pekerja.keuangan.index') }}" wire:navigate class="sidebar-link">
                    <i class="bi-wallet"></i>
                    <span>Keuangan</span>
                </a>
            </li>
            @endhasanyrole

            {{-- =============================================
                SEMUA ROLE: Akun Saya
            ============================================== --}}
            <li class="sidebar-title">Akun Saya</li>

            <li class="sidebar-item {{ request()->routeIs('pekerja.profile.*') ? 'active' : '' }}">
                <a href="{{ route('pekerja.profile.index') }}" wire:navigate class="sidebar-link">
                    <i class="bi bi-person-badge"></i>
                    <span>Profil Saya</span>
                </a>
            </li>

            {{-- Logout --}}
            <li class="sidebar-item mt-4">
                <form
                    id="logout-form"
                    method="POST"
                    action="{{ route('pekerja.logout') }}">
                    @csrf
                    <button
                        type="button"
                        onclick="confirmLogout()"
                        class="sidebar-link border-0 bg-transparent w-100 text-start">
                        <i class="bi-door-open text-danger"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </li>

        </ul>
    </div>
</div>