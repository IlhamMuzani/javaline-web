<?php

namespace App\Exports;

use App\Models\Memo_ekspedisi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class MemoperjalananExport implements FromView
{
    protected $tanggal_awal;
    protected $tanggal_akhir;
    protected $status;
    protected $kategori;

    public function __construct($tanggal_awal, $tanggal_akhir, $status, $kategori)
    {
        $this->tanggal_awal = $tanggal_awal;
        $this->tanggal_akhir = $tanggal_akhir;
        $this->status = $status;
        $this->kategori = $kategori;
    }

    public function view(): View
    {
        // Fetch memos with the specified date range
        $query = Memo_ekspedisi::whereBetween('tanggal_awal', [$this->tanggal_awal, $this->tanggal_akhir]);

        // Apply status filter only if status is 'posting' or 'unpost'
        if (in_array($this->status, ['posting', 'unpost'])) {
            $query->where('status', $this->status);
        }

        // Apply category filter if it is specified
        if (in_array($this->kategori, ['Memo Perjalanan', 'Memo Borong'])) {
            $query->where('kategori', $this->kategori);
        }

        // Get the filtered memos
        $memos = $query->get();

        return view('admin.inquery_memoekspedisi.memo_eksport', [
            'inquery' => $memos,
            'tanggal_awal' => $this->tanggal_awal,
            'tanggal_akhir' => $this->tanggal_akhir,
            'status' => $this->status,
            'kategori' => $this->kategori,
        ]);
    }
}