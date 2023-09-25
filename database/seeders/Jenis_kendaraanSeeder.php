<?php

namespace Database\Seeders;

use App\Models\Divisi;
use App\Models\Jenis_kendaraan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Jenis_kendaraanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jenis_kendaraan = [
            [
                'kode_jenis_kendaraan' => 'AG000001',
                'nama_jenis_kendaraan' => 'ENGKEL',
                'panjang' => '310 cm',
                'lebar' => '170 cm',
                'tinggi' => '170 cm',
                'total_ban' => '8',
                'qrcode_jenis' => '-',
            ],
            [
                'kode_jenis_kendaraan' => 'AG000002',
                'nama_jenis_kendaraan' => 'TRONTON',
                'panjang' => '1190 cm',
                'lebar' => '250 cm',
                'tinggi' => '290 cm',
                'total_ban' => '10',
                'qrcode_jenis' => '-',
            ],
            [
                'kode_jenis_kendaraan' => 'AG000003',
                'nama_jenis_kendaraan' => 'TRAILER ENGKEL',
                'panjang' => '310 cm',
                'lebar' => '170 cm',
                'tinggi' => '170 cm',
                'total_ban' => '18',
                'qrcode_jenis' => '-',
            ],
            [
                'kode_jenis_kendaraan' => 'AG000004',
                'nama_jenis_kendaraan' => 'TRAILER TRONTON',
                'panjang' => '1190 cm',
                'lebar' => '250 cm',
                'tinggi' => '290 cm',
                'total_ban' => '22',
                'qrcode_jenis' => '-',
            ],
        ];
        Jenis_kendaraan::insert($jenis_kendaraan);
    }
}