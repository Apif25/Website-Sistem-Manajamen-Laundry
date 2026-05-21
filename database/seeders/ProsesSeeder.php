<?php

namespace Database\Seeders;

use App\Models\Proses;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProsesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Proses::create([
            'id_pesanan' => 1,
            'proses' => 'Menunggu',
        ]);

        Proses::create([
            'id_pesanan' => 2,
            'proses' => 'Pencucian',
        ]);

        Proses::create([
            'id_pesanan' => 3,
            'proses' => 'Penyetrikaan',
        ]);
    }
}
