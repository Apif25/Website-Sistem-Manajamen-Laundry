<?php

namespace Database\Seeders;

use App\Models\Pekerja;
use Illuminate\Database\Seeder;

class PekerjaSeeder extends Seeder
{
    public function run(): void
    {
        // -------------------------------------------------------
        // ADMIN
        // -------------------------------------------------------
        $admin = Pekerja::create([
            'email'         => 'admin@laundry.com',
            'password'      => bcrypt('password'),
            'nama_pekerja'  => 'Denni',
            'no_telepon'    => '081234567890',
            'alamat'        => 'Jl. Merdeka No. 123',
            'jenis_kelamin' => 'Pria',
        ]);
        $admin->assignRole('admin');

        // -------------------------------------------------------
        // PETUGAS
        // -------------------------------------------------------
        $petugas = Pekerja::create([
            'email'         => 'petugas@laundry.com',
            'password'      => bcrypt('password'),
            'nama_pekerja'  => 'Goku',
            'no_telepon'    => '082234567890',
            'alamat'        => 'Jl. Kamekameha No. 1',
            'jenis_kelamin' => 'Pria',
        ]);
        $petugas->assignRole('petugas');

        // -------------------------------------------------------
        // MANAJER
        // -------------------------------------------------------
        $manajer = Pekerja::create([
            'email'         => 'manajer@laundry.com',
            'password'      => bcrypt('password'),
            'nama_pekerja'  => 'Budi',
            'no_telepon'    => '083234567890',
            'alamat'        => 'Jl. Sudirman No. 45',
            'jenis_kelamin' => 'Pria',
        ]);
        $manajer->assignRole('manajer');

        // -------------------------------------------------------
        // OWNER
        // -------------------------------------------------------
        $owner = Pekerja::create([
            'email'         => 'owner@laundry.com',
            'password'      => bcrypt('password'),
            'nama_pekerja'  => 'Siti',
            'no_telepon'    => '084234567890',
            'alamat'        => 'Jl. Diponegoro No. 7',
            'jenis_kelamin' => 'Wanita',
        ]);
        $owner->assignRole('owner');
    }
}
