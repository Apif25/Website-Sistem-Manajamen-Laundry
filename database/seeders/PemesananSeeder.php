<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pemesanan;

class PemesananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pemesanan::create([
            'id_pelanggan'       => 1,
            'jenis_pemesanan'    => 'Satuan',
            'layanan_pemesanan'  => 'Biasa',
            'Jumlah_brg'      => 5,
            'tanggal_pemesanan'  => now(),
        ]);

        Pemesanan::create([
            'id_pelanggan'       => 2,
            'jenis_pemesanan'    => 'Kiloan',
            'layanan_pemesanan'  => 'Cepat',
            'Jumlah_brg'      => 8,
            'tanggal_pemesanan'  => now(),
        ]);

        Pemesanan::create([
            'id_pelanggan'       => 3,
            'jenis_pemesanan'    => 'Kiloan',
            'layanan_pemesanan'  => 'Cepat',
            'Jumlah_brg'      => 3,
            'tanggal_pemesanan'  => now(),
        ]);

        Pemesanan::create([
            'id_pelanggan'       => 1,
            'jenis_pemesanan'    => 'Satuan',
            'layanan_pemesanan'  => 'Biasa',
            'Jumlah_brg'      => 2,
            'tanggal_pemesanan'  => now(),
        ]);

        Pemesanan::create([
            'id_pelanggan'       => 2,
            'jenis_pemesanan'    => 'Kiloan',
            'layanan_pemesanan'  => 'Cepat',
            'Jumlah_brg'      => 4,
            'tanggal_pemesanan'  => now(),
        ]);
    }
}
