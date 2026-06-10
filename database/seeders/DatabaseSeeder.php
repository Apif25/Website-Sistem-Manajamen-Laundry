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
        // Automatically seed Laravolt Indonesia tables if they are empty
        if (\Illuminate\Support\Facades\DB::table('indonesia_provinces')->count() === 0) {
            $this->command->info('Seeding Laravolt Indonesia...');
            \Illuminate\Support\Facades\Artisan::call('laravolt:indonesia:seed');
        }

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
