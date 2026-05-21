<?php

namespace Database\Seeders;

use App\Models\Pelanggan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class PelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pelanggan::create([
            'email' => 'andi@gmail.com',
            'password' => Hash::make('password123'),
            'nama_pelanggan' => 'Andi Saputra',
            'no_telepon' => '081234567890',
            'alamat' => 'Jl. Merdeka No. 10, Bandung',
            'jenis_kelamin' => 'Pria',
            'email_verified_at' => now(),
        ]);

        Pelanggan::create([
            'email' => 'siti@gmail.com',
            'password' => Hash::make('password123'),
            'nama_pelanggan' => 'Siti Aisyah',
            'no_telepon' => '081298765432',
            'alamat' => 'Jl. Mawar No. 5, Jakarta',
            'jenis_kelamin' => 'Wanita',
            'email_verified_at' => now(),
        ]);

        Pelanggan::create([
            'email' => 'budi@gmail.com',
            'password' => Hash::make('password123'),
            'nama_pelanggan' => 'Budi Santoso',
            'no_telepon' => '082112223333',
            'alamat' => 'Jl. Melati No. 7, Surabaya',
            'jenis_kelamin' => 'Pria',
            'email_verified_at' => now(),
        ]);

        Pelanggan::create([
            'email' => 'rina@gmail.com',
            'password' => Hash::make('password123'),
            'nama_pelanggan' => 'Rina Oktavia',
            'no_telepon' => '083344556677',
            'alamat' => 'Jl. Kenanga No. 2, Yogyakarta',
            'jenis_kelamin' => 'Wanita',
            'email_verified_at' => now(),
        ]);

        Pelanggan::create([
            'email' => 'dedi@gmail.com',
            'password' => Hash::make('password123'),
            'nama_pelanggan' => 'Dedi Kurniawan',
            'no_telepon' => '085566778899',
            'alamat' => 'Jl. Anggrek No. 9, Bekasi',
            'jenis_kelamin' => 'Pria',
            'email_verified_at' => now(),
        ]);
    }
}
