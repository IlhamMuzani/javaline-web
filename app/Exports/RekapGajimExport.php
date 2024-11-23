<?php

namespace App\Exports;

use App\Models\Detail_gajikaryawan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class RekapGajimExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    protected $perhitungan_gaji;
    protected $detail_gaji;

    public function __construct($perhitungan_gaji, $detail_gaji)
    {
        $this->perhitungan_gaji = $perhitungan_gaji;
        $this->detail_gaji = $detail_gaji;
    }

    public function collection()
    {
        return $this->detail_gaji;
    }

    public function headings(): array
    {
        return [
            "",
            "",
            "",
            "",
            "",
            "P",
            "yyyyMMdd"
        ];
    }

    public function map($detail): array
    {
        return [];
    }

    public function title(): string
    {
        return 'Rekap Gaji'; // Nama sheet
    }
}