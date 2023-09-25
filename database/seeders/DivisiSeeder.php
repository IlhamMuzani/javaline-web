<?php

namespace Database\Seeders;

use App\Models\Divisi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DivisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $divisis = [
            [
                'kode_divisi' => 'AF000001',
                'nama_divisi' => 'JAVALINE',
            ]];
        Divisi::insert($divisis);
    }
}