<?php

namespace Database\Seeders;

use App\Http\Controllers\Admin\Jenis_kendaraanController;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            KotaSeeder::class,
            // DepartemenSeeder::class,
            // KaryawanSeeder::class,
            // UserSeeder::class,
            // GolonganSeeder::class,
            // DivisiSeeder::class,
            // Jenis_kendaraanSeeder::class,
            // Ukuran_banSeeder::class,
            // Merek_banSeeder::class,
        ]);
    }
}