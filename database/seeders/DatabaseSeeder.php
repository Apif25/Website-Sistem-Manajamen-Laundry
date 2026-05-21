<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(RolePermissionSeeder::class);
        $this->call(PekerjaSeeder::class);
        $this->call(PelangganSeeder::class);
        $this->call(PemesananSeeder::class);
        $this->call(PesananSeeder::class);
        $this->call(ProsesSeeder::class);
    }
}
