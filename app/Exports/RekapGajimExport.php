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
            '',
            '',
            '',
            '',
            '',
            'P',
            'yyyyMMdd',
            'Debit Account No.',
            'Total Records',
            'Total Amount',
            '',
            '',
            'To Acc No.',
            'To Acc Name',
            'To Acc Address 1',
            'To Acc Address 2',
            'To Acc Address 3',
            'Transfer Currency',
            'Transfer Amount',
            'Transaction Remark',
            'Customer Ref No.',
            'FT Service',
            'To Acc Bank Code',
            'To Acc Bank Name',
            'To Acc Bank Address 1',
            'To Acc Bank Address 2',
            'To Acc Bank Address 3',
            'Bank City Name / Country Name',
            'Beneficiary Notification Flag',
            'Benef Notification E-mail',
            'Organization Directory Name',
            'Identical Status',
            'Beneficiary Status',
            'Beneficiary Citizenship',
            'Purpose of Transaction',
            'Remittance Code 1',
            'Remittance Information 1',
            'Remittance Code 2',
            'Remittance Information 2',
            'Remittance Code 3',
            'Remittance Information 3',
            'Remittance Code 4',
            'Remittance Information 4',
            'Instruction Code 1',
            'Instruction Remark 1',
            'Instruction Code 2',
            'Instruction Remark 2',
            'Instruction Code 3',
            'Instruction Remark 3',
            'Charge Instruction',
            'SWIFT Method / Beneficiary Type',
            'Extended Payment Detail',
            'Special Rate Ref No',
            'Underlying Document Code',
            'Sender to Receiver Information Code 2',
            'Sender to Receiver Information Line 2',
            'Sender to Receiver Information Code 3',
            'Sender to Receiver Information Line 3',
            'Sender to Receiver Information Code 4',
            'Sender to Receiver Information Code 5',
            'Sender to Receiver Information Line 5',
            'Sender to Receiver Information Code 6',
            'Sender to Receiver Information Line 6'
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
