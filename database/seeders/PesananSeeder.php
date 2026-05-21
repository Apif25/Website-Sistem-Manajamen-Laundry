<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pesanan;

class PesananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pesanan::create([
            'id_pemesanan'    => 1,
            'id_pelanggan'    => 1,
            'jenis_pesanan'   => 'Satuan',
            'layanan_pesanan' => 'Biasa',
            'berat'           => 3,
            'harga'           => 15000.00,
            'tanggal_pesanan' => now(),
        ]);

        Pesanan::create([
            'id_pemesanan'    => 2,
            'id_pelanggan'    => 2,
            'jenis_pesanan'   => 'Kiloan',
            'layanan_pesanan' => 'Cepat',
            'berat'           => 5,
            'harga'           => 35000.00,
            'tanggal_pesanan' => now(),
        ]);

        Pesanan::create([
            'id_pemesanan'    => 3,
            'id_pelanggan'    => 3,
            'jenis_pesanan'   => 'Satuan',
            'layanan_pesanan' => 'Cepat',
            'berat'      => 7,
            'harga'           => 50000.00,
            'tanggal_pesanan' => now(),
        ]);
    }
}
