<?php

namespace Database\Seeders;

use App\Models\Departemen;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartemenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departemen = [
            [
                'nama' => 'Staff Karyawan',
                'qrcode_departemen' => '6630196356'
            ]];
        Departemen::insert($departemen);
    }
}