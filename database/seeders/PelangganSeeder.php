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
        $andi = Pelanggan::create([
            'email' => 'andi@gmail.com',
            'password' => Hash::make('password123'),
            'nama_pelanggan' => 'Andi Saputra',
            'no_telepon' => '081234567890',
            'jenis_kelamin' => 'Pria',
            'email_verified_at' => now(),
        ]);
        $andi->alamat()->create([
            'label_alamat' => 'Rumah',
            'province_id' => 12,
            'regency_id' => 181,
            'district_id' => 2563,
            'alamat_lengkap' => 'Jl. Merdeka No. 10',
            'is_utama' => true,
        ]);

        $siti = Pelanggan::create([
            'email' => 'siti@gmail.com',
            'password' => Hash::make('password123'),
            'nama_pelanggan' => 'Siti Aisyah',
            'no_telepon' => '081298765432',
            'jenis_kelamin' => 'Wanita',
            'email_verified_at' => now(),
        ]);
        $siti->alamat()->create([
            'label_alamat' => 'Kantor',
            'province_id' => 11,
            'regency_id' => 159,
            'district_id' => 1991,
            'alamat_lengkap' => 'Jl. Mawar No. 5',
            'is_utama' => true,
        ]);

        $budi = Pelanggan::create([
            'email' => 'budi@gmail.com',
            'password' => Hash::make('password123'),
            'nama_pelanggan' => 'Budi Santoso',
            'no_telepon' => '082112223333',
            'jenis_kelamin' => 'Pria',
            'email_verified_at' => now(),
        ]);
        $budi->alamat()->create([
            'label_alamat' => 'Rumah',
            'province_id' => 15,
            'regency_id' => 264,
            'district_id' => 3924,
            'alamat_lengkap' => 'Jl. Melati No. 7',
            'is_utama' => true,
        ]);

        $rina = Pelanggan::create([
            'email' => 'rina@gmail.com',
            'password' => Hash::make('password123'),
            'nama_pelanggan' => 'Rina Oktavia',
            'no_telepon' => '083344556677',
            'jenis_kelamin' => 'Wanita',
            'email_verified_at' => now(),
        ]);
        $rina->alamat()->create([
            'label_alamat' => 'Kos',
            'province_id' => 14,
            'regency_id' => 227,
            'district_id' => 3278,
            'alamat_lengkap' => 'Jl. Kenanga No. 2',
            'is_utama' => true,
        ]);

        $dedi = Pelanggan::create([
            'email' => 'dedi@gmail.com',
            'password' => Hash::make('password123'),
            'nama_pelanggan' => 'Dedi Kurniawan',
            'no_telepon' => '085566778899',
            'jenis_kelamin' => 'Pria',
            'email_verified_at' => now(),
        ]);
        $dedi->alamat()->create([
            'label_alamat' => 'Rumah',
            'province_id' => 12,
            'regency_id' => 183,
            'district_id' => 2598,
            'alamat_lengkap' => 'Jl. Anggrek No. 9',
            'is_utama' => true,
        ]);
    }
}
