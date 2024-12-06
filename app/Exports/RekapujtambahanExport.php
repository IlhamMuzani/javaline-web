<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class RekapujtambahanExport implements FromView
{
    protected $memotambahan;

    public function __construct($memotambahan)
    {
        $this->memotambahan = $memotambahan;
    }

    public function view(): View
    {
        return view('admin.inquery_memotambahan.export_rekap', [
            'memotambahan' => $this->memotambahan,
        ]);
    }
}