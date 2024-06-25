<?php

namespace App\Exports;

use App\Models\Karyawan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Faktur_ekspedisi;
use Maatwebsite\Excel\Concerns\WithMapping;

class LaporanLogistikExport implements FromCollection, WithHeadings, WithMapping
{
    protected $fakturEkspedisis;

    public function __construct($fakturEkspedisis)
    {
        $this->fakturEkspedisis = $fakturEkspedisis;
    }

    public function collection()
    {
        return $this->fakturEkspedisis;
    }

    public function headings(): array
    {
        return [
            'No',
            'No Kabin',
            'Sopir',
            'Ritase',
            'Total Faktur',
            'Total Memo',
            'Total Operasional',
            'Total Perbaikan',
            'Sub Total',
        ];
    }

    public function map($fakturEkspedisi): array
    {
        return [
            $fakturEkspedisi->id,
            $fakturEkspedisi->kendaraan ? $fakturEkspedisi->kendaraan->no_kabin : 'tidak ada',
            $fakturEkspedisi->kategoris == 'non memo' ? $fakturEkspedisi->id : 'tidak ada',
            // $fakturEkspedisi->user ? $fakturEkspedisi->user->karyawan->nama_lengkap : 'tidak ada',
            $fakturEkspedisi->ritase,
            $fakturEkspedisi->total_faktur,
            $fakturEkspedisi->memo_ekspedisi ? $fakturEkspedisi->memo_ekspedisi->count() : 0,
            $fakturEkspedisi->total_operasional,
            $fakturEkspedisi->total_perbaikan,
            $fakturEkspedisi->sub_total,
        ];
    }
}