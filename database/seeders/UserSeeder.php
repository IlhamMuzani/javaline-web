<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
                $karyawans = [
            [
                'karyawan_id' => '1',
                'kode_user' => 'AB000001',
                'qrcode_user' => '6714059572',
                'menu' => json_encode([
                    'akses' => true,
                    'karyawan' => true,
                    'user' => true,
                    'departemen' => true,
                    'supplier' => true,
                    'pelanggan' => true,
                    'kendaraan' => true,
                    'ban' => true,
                    'golongan' => true,
                    'divisi mobil' => true,
                    'jenis kendaraan' => true,
                    'ukuran ban' => true,
                    'merek ban' => true,
                    'nokir' => true,
                    'stnk' => true,
                    'update km' => true,
                    'perpanjangan stnk' => true,
                    'pemasangan ban' => true,
                    'pelepasan ban' => true,
                ]),
                'password' => bcrypt('admin'),
                'cek_hapus' => 'tidak',
                'level' => 'admin',
            ],
        ];
        User::insert($karyawans);
    }
}