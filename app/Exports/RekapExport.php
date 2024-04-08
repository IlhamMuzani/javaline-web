<?php

namespace App\Exports;

use App\Models\Karyawan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RekapExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{

    private $grandTotal;

    public function collection()
    {
        $karyawanCollection = Karyawan::where('departemen_id', '2')
            ->get(['id', 'nama_lengkap', 'deposit', 'kasbon', 'bayar_kasbon', 'tabungan']);

        // Calculate grand total
        $this->grandTotal = $karyawanCollection->sum('tabungan');

        // Format 'tabungan' as currency (rupiah)
        $karyawanCollection = $karyawanCollection->map(function ($karyawan) {
            $karyawan['tabungan'] = 'Rp ' . number_format($karyawan['tabungan'], 0, ',', '.');
            $karyawan['kasbon'] = 'Rp ' . number_format($karyawan['kasbon'], 0, ',', '.');
            $karyawan['bayar_kasbon'] = 'Rp ' . number_format($karyawan['bayar_kasbon'], 0, ',', '.');
            $karyawan['deposit'] = 'Rp ' . number_format($karyawan['deposit'], 0, ',', '.');
            return $karyawan;
        });

        // Append a new row for grand total
        $grandTotalRow = [
            'No' => '',
            'Nama Sopir' => '',
            'Deposit Sopir' => '',
            'Kasbon' => '',
            'Bayar Kasbon' => 'GRAND TOTAL',
            'Total Deposit' => 'Rp ' . number_format($this->grandTotal, 0, ',', '.'),
        ];

        $karyawanCollection->push($grandTotalRow);

        // Manually set sequential numbers starting from 1
        return $karyawanCollection;
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Sopir',
            'Deposit Sopir',
            'Kasbon',
            'Bayar Kasbon',
            'Total Deposit',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT], // Align text to the left for other columns
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ],
            'C' => [ // 'C' corresponds to the 'tabungan' column
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT], // Align text to the right
            ],
            'D' => [ // 'D' corresponds to the 'kasbon' column
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT], // Align text to the right
            ],
            'E' => [ // 'E' corresponds to the 'deposit' column
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT], // Align text to the right
            ],
            'F' => [ // 'E' corresponds to the 'deposit' column
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT], // Align text to the right
            ],
        ];
    }
}