<?php

namespace Database\Seeders;

use App\Models\Golongan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GolonganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $golongans = [
            [
                'kode_golongan' => 'AE000001',
                'nama_golongan' => 'GOLONGAN 1',
                'qrcode_golongan' => '7957801707',
            ]];
        Golongan::insert($golongans);
    }
}