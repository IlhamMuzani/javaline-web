<?php

namespace Database\Seeders;

use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KaryawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'kode_karyawan' => 'AA000001',
                'departemen_id' => '1',
                'no_ktp' => '0869787567764',
                'no_sim' => '7437488743889',
                'qrcode_karyawan' => 'https://javaline.id/karyawan/AA000001',
                // 'qrcode_karyawan' => 'http://192.168.1.46/javaline/karyawan/AA000001',
                'departemen_id' => '1',
                'departemen_id' => '1',
                'departemen_id' => '1',
                'nama_lengkap' => 'admin',
                'nama_kecil' => 'admin',
                'gender' => 'L',
                'tanggal_lahir' => '12-121998',
                'tanggal_gabung' => '12-06-2023',
                'tanggal_keluar' => '-',
                'telp' => '08976688777',
                'alamat' => 'Tegal',
                'jabatan' => 'STAFF',
                'gaji' => '-',
                'pembayaran' => '-',
                'gambar' => 'user/user.png',
                'status' => 'user'
            ]];
        Karyawan::insert($users);
    }
}