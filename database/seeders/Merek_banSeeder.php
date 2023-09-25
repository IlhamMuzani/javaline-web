<?php

namespace Database\Seeders;

use App\Models\Merek_ban;
use App\Models\Ukuran_ban;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Merek_banSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $merek_ban = [
            [
                'kode_merek' => 'AJ000001',
                'nama_merek' => 'Michelin',
                'kendaraan_id' => null
            ]];
        Merek_ban::insert($merek_ban);
    }
}