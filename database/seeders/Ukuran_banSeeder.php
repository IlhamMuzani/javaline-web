<?php

namespace Database\Seeders;

use App\Models\Ukuran_ban;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Ukuran_banSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ukuran_ban = [
            [
                'kode_ukuran_ban' => 'AI000001',
                'ukuran' => '10.00-20, 11.00-20, 12.00-20',
            ]];
        Ukuran_ban::insert($ukuran_ban);
    }
}