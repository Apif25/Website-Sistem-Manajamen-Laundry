<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // -------------------------------------------------------
        // ADMIN — full akses ke pekerja & pelanggan + profile
        // -------------------------------------------------------
        $admin = Role::findByName('admin', 'pekerja');
        $admin->syncPermissions([
            'pekerja.index',
            'pekerja.create',
            'pekerja.edit',
            'pekerja.delete',
            'pelanggan.index',
            'pelanggan.create',
            'pelanggan.edit',
            'pelanggan.delete',
            'profile.index',
            'profile.edit',
        ]);

        // -------------------------------------------------------
        // PETUGAS — operasional harian + profile
        // -------------------------------------------------------
        $petugas = Role::findByName('petugas', 'pekerja');
        $petugas->syncPermissions([
            'pembayaran.index',
            'pembayaran.create',
            'pembayaran.edit',
            'pembayaran.delete',
            'stockbarang.index',
            'stockbarang.create',
            'stockbarang.edit',
            'stockbarang.delete',
            'inventaris.index',
            'inventaris.create',
            'inventaris.edit',
            'inventaris.delete',
            'pemesanan.index',
            'pemesanan.create',
            'pemesanan.edit',
            'pemesanan.delete',
            'pesanan.index',
            'pesanan.create',
            'pesanan.edit',
            'pesanan.delete',
            'proses.index',
            'proses.create',
            'proses.edit',
            'proses.delete',
            'profile.index',
            'profile.edit',
        ]);

        // -------------------------------------------------------
        // MANAJER — full akses keuangan + profile
        // -------------------------------------------------------
        $manajer = Role::findByName('manajer', 'pekerja');
        $manajer->syncPermissions([
            'pembayaran.index',
            'stockbarang.index',
            'inventaris.index',
            'pemesanan.index',
            'pesanan.index',
            'proses.index',
            'keuangan.index',
            'keuangan.create',
            'keuangan.edit',
            'keuangan.delete',
            'profile.index',
            'profile.edit',
        ]);

        // -------------------------------------------------------
        // OWNER — read only keuangan + profile
        // -------------------------------------------------------
        $owner = Role::findByName('owner', 'pekerja');
        $owner->syncPermissions([
            'keuangan.index',
            'profile.index',
            'profile.edit',
        ]);
    }
}
