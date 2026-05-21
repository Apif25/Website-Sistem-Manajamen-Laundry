<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // Pekerja
            'pekerja.index',
            'pekerja.create',
            'pekerja.edit',
            'pekerja.delete',

            // Pelanggan
            'pelanggan.index',
            'pelanggan.create',
            'pelanggan.edit',
            'pelanggan.delete',

            // Pembayaran
            'pembayaran.index',
            'pembayaran.create',
            'pembayaran.edit',
            'pembayaran.delete',

            // Keuangan
            'keuangan.index',
            'keuangan.create',
            'keuangan.edit',
            'keuangan.delete',

            // Stock Barang
            'stockbarang.index',
            'stockbarang.create',
            'stockbarang.edit',
            'stockbarang.delete',

            // Inventaris
            'inventaris.index',
            'inventaris.create',
            'inventaris.edit',
            'inventaris.delete',

            // Pemesanan
            'pemesanan.index',
            'pemesanan.create',
            'pemesanan.edit',
            'pemesanan.delete',

            // Pesanan
            'pesanan.index',
            'pesanan.create',
            'pesanan.edit',
            'pesanan.delete',

            // Proses
            'proses.index',
            'proses.create',
            'proses.edit',
            'proses.delete',

            // Profile (semua bisa akses profil sendiri)
            'profile.index',
            'profile.edit',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name'       => $permission,
                'guard_name' => 'pekerja',
            ]);
        }
    }
}
