<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class RekapNotabonExport implements FromView
{
    protected $nota_bon;

    public function __construct($nota_bon)
    {
        $this->nota_bon = $nota_bon;
    }

    public function view(): View
    {
        return view('admin.inquery_notabon.export_rekap', [
            'nota_bon' => $this->nota_bon,
        ]);
    }
}