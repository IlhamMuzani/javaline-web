<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class RekapujExport implements FromView
{
    protected $memo_ekspedisi;

    public function __construct($memo_ekspedisi)
    {
        $this->memo_ekspedisi = $memo_ekspedisi;
    }

    public function view(): View
    {
        return view('admin.inquery_memoekspedisi.export_rekap', [
            'memo_ekspedisi' => $this->memo_ekspedisi,
        ]);
    }
}