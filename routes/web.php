<?php

use App\Http\Controllers\PemesananController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Pekerja\Pelanggan\Index;
use App\Livewire\Pekerja\Pelanggan\Edit;
use App\Livewire\Pekerja\Pelanggan\Show;
use App\Livewire\Pekerja\Pemesanan\Create as PemesananCreate;
use App\Livewire\Pekerja\Pemesanan\Edit as PemesananEdit;
use App\Livewire\Pekerja\Pemesanan\Show as PemesananShow;
use App\Livewire\Pekerja\Pesanan\Create as PesananCreate;
use App\Livewire\Pekerja\Pesanan\Edit as PesananEdit;
use App\Livewire\Pekerja\Auth\Setup2FA;
use App\Livewire\Pekerja\Auth\Verify2FA;
use App\Livewire\Pekerja\Auth\FirstPassword;

use App\Livewire\Frontend\Beranda;
use App\Livewire\Frontend\Auth\Login;
use App\Livewire\Frontend\Auth\Register;
use App\Livewire\Frontend\ProdukLayanan\Index as ProdukLayananIndex;
use App\Livewire\Frontend\ProdukLayanan\Produk;
use App\Livewire\Frontend\ProdukLayanan\Layanan;
use App\Livewire\Frontend\PesananAnda\PesananAnda;

// ============================================================================
// WELCOME
// ============================================================================

Route::get('/', function () {
    return redirect('/pelanggan');
}); 

Route::prefix('pelanggan')->name('pelanggan.')->group(function () {

    Route::get('/', Beranda::class)
        ->name('beranda');

    Route::get('/produk-layanan', ProdukLayananIndex::class)
        ->name('produk_layanan');

    Route::get('/produk', Produk::class)
        ->name('produk');

    Route::get('/layanan', Layanan::class)
        ->name('layanan');

    Route::middleware('auth.pelanggan')->group(function () {

        Route::get('/pesanan-anda', PesananAnda::class)
            ->name('pesanan_anda');

    });

});

Route::get('/login', Login::class)
    ->middleware('guest:pelanggan')
    ->name('login');

Route::get('/register', Register::class)
    ->middleware('guest:pelanggan')
    ->name('register');

// ============================================================================
// PEKERJA ROUTES
// ============================================================================

Route::prefix('pekerja')->name('pekerja.')->group(function () {

    // ------------------------------------------------------------------
    // Guest: belum login
    // ------------------------------------------------------------------
    Route::middleware('guest:pekerja')->group(function () {
        Route::get('/auth/login', \App\Livewire\Pekerja\Auth\Login::class)
            ->name('login');
    });

    // ------------------------------------------------------------------
    // Auth: sudah login
    // ------------------------------------------------------------------
    Route::middleware('auth:pekerja')->group(function () {

        // Logout
        Route::post('/logout', function () {
            Auth::guard('pekerja')->logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
            return redirect()->route('pekerja.login');
        })->name('logout');

        // Password pertama kali
        Route::get('/auth/first-password', FirstPassword::class)
            ->name('password.first');

        // 2FA ROUTES — hanya untuk yang sudah login tapi belum verified 2FA
        Route::middleware(['auth:pekerja'])->group(function () {

            Route::get('/auth/Setup2FA', Setup2FA::class)
                ->name('pekerja.Setup2FA');

            Route::get('/auth/Verify2FA', Verify2FA::class)
                ->name('pekerja.Verify2FA');
        });

        // Setup Access Code
        Route::get(
            '/security/access-code',
            \App\Livewire\Pekerja\Security\AccessCode::class
        )->name('access-code.create');
        Route::get(
            '/security/verify-access-code',
            \App\Livewire\Pekerja\Security\VerifyAccessCode::class
        )->name('access-code.verify');

        // Dashboard — semua role
        Route::get('/dashboard', \App\Livewire\Pekerja\Dashboard::class)->name('dashboard');

        // Profile — semua role
        Route::get('/profile/index', \App\Livewire\Pekerja\Profile\Index::class)->name('profile.index');

        // --------------------------------------------------------------
        // ADMIN — Manajemen Pekerja & Pelanggan
        // --------------------------------------------------------------
        Route::middleware('role:super admin', 'access.code.exists')->group(function () {

            // Audit Log
            Route::get('/audit-log', \App\Livewire\Pekerja\AuditLog::class)
                ->name('audit-log');

            // Backup Database — ikut group yang sama
            Route::get('/backup', \App\Livewire\Pekerja\BackupDatabase::class)->name('backup.index');


            // Pekerja
            Route::get('/index', \App\Livewire\Pekerja\Index::class)->name('index');
            Route::get('/create', \App\Livewire\Pekerja\Create::class)->name('create');
            Route::get('/{id}/edit', \App\Livewire\Pekerja\Edit::class)->name('edit');
            Route::get('/{id}', \App\Livewire\Pekerja\Show::class)->name('show');

            // Pelanggan
            Route::prefix('pelanggan')->name('pelanggan.')->group(function () {
                Route::get('/index', Index::class)->name('index');
                Route::get('/{id}/edit', Edit::class)->name('edit');
                Route::get('/{id}', Show::class)->name('show');
            });
        });

        // --------------------------------------------------------------
        // PETUGAS — Pemesanan, Pesanan, Proses, Pembayaran, Stok, Inventaris
        // --------------------------------------------------------------
        Route::middleware('role:petugas|owner')->group(function () {

            // Pemesanan
            Route::prefix('pemesanan')->name('pemesanan.')->group(function () {
                Route::get('/index', \App\Livewire\Pekerja\Pemesanan\Index::class)->name('index');
                Route::get('/create', PemesananCreate::class)->name('create');
                Route::get('/{id}/edit', PemesananEdit::class)->name('edit');
                Route::get('/{id}', PemesananShow::class)->name('show');
                Route::delete('/{id}', [PemesananController::class, 'destroy'])->name('destroy');
            });

            // Pesanan
            Route::prefix('pesanan')->name('pesanan.')->group(function () {
                Route::get('/index', \App\Livewire\Pekerja\Pesanan\Index::class)->name('index');
                Route::get('/create', PesananCreate::class)->name('create');
                Route::get('/{id}', \App\Livewire\Pekerja\Pesanan\Show::class)->name('show');
                Route::get('/{id}/edit', PesananEdit::class)->name('edit');
            });

            // Proses
            Route::prefix('proses')->name('proses.')->group(function () {
                Route::get('/index', \App\Livewire\Pekerja\Proses\Index::class)->name('index');
            });

            // Pembayaran
            Route::prefix('pembayaran')->name('pembayaran.')->group(function () {
                Route::get('/index', \App\Livewire\Pekerja\Pembayaran\Index::class)->name('index');
                Route::get('/proses/{idPesanan}', \App\Livewire\Pekerja\Pembayaran\PembayaranProcess::class)->name('proses');
                Route::get('/finish', \App\Livewire\Pekerja\Pembayaran\PembayaranProcess::class)->name('finish');
            });

            // Stock Barang
            Route::prefix('stockbarang')->name('stockbarang.')->group(function () {
                Route::get('/index', \App\Livewire\Pekerja\StockBarang\Index::class)->name('index');
            });

            // Inventaris
            Route::prefix('inventaris')->name('inventaris.')->group(function () {
                Route::get('/index', \App\Livewire\Pekerja\Inventaris\Index::class)->name('index');
            });
        });

        // --------------------------------------------------------------
        // MANAJER — full CRUD keuangan
        // OWNER   — read only keuangan (hanya index & pdf)
        // --------------------------------------------------------------
        Route::middleware('role:owner')->group(function () {

            Route::prefix('keuangan')->name('keuangan.')->group(function () {
                Route::get('/index', \App\Livewire\Pekerja\Keuangan\Index::class)->name('index');
                Route::get('/pdf', [\App\Http\Controllers\KeuanganPdfController::class, 'generate'])->name('pdf');
            });
        });
    });
});
