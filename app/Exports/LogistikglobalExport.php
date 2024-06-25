<?php

namespace App\Exports;

use App\Models\Kendaraan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LogistikglobalExport implements FromView
{
    protected $created_at;
    protected $tanggal_akhir;
    protected $kategoris;

    public function __construct($created_at, $tanggal_akhir, $kategoris)
    {
        $this->created_at = $created_at;
        $this->tanggal_akhir = $tanggal_akhir;
        $this->kategoris = $kategoris;
    }

    public function view(): View
    {
        $kendaraans = Kendaraan::with(['user', 'memo_ekspedisi', 'faktur_ekspedisi', 'detail_pengeluaran'])
            ->get();

        return view('admin.laporan_mobillogistikglobal.logistik_global', [
            'kendaraans' => $kendaraans,
            'created_at' => $this->created_at,
            'tanggal_akhir' => $this->tanggal_akhir,
            'kategoris' => $this->kategoris,
        ]);
    }
}