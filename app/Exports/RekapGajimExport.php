<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class RekapGajimExport implements FromView
{
    protected $perhitungan_gaji;
    protected $detail_gaji;

    public function __construct($perhitungan_gaji, $detail_gaji)
    {
        $this->perhitungan_gaji = $perhitungan_gaji;
        $this->detail_gaji = $detail_gaji;
    }

    public function view(): View
    {
        return view('admin.inquery_perhitungangaji.export_rekap', [
            'perhitungan_gaji' => $this->perhitungan_gaji,
            'detail_gaji' => $this->detail_gaji,
        ]);
    }
}