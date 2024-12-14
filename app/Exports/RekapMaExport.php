<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class RekapMaExport implements FromView
{
    protected $memo_asuransi;

    public function __construct($memo_asuransi)
    {
        $this->memo_asuransi = $memo_asuransi;
    }

    public function view(): View
    {
        return view('admin.inquery_memoasuransi.export_rekap', [
            'memo_asuransi' => $this->memo_asuransi,
        ]);
    }
}