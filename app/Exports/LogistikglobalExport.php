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
        // Fetch vehicles with their related data
        $kendaraans = Kendaraan::with(['user', 'memo_ekspedisi', 'faktur_ekspedisi', 'detail_pengeluaran'])
            ->get();

        // Filter and sort vehicles based on the numeric value in their 'no_kabin' attribute
        $kendaraans = $kendaraans->filter(function ($kendaraan) {
            // Add your additional filter conditions here if needed
            return true; // This is just a placeholder, apply actual filtering logic
        })->sort(function ($a, $b) {
            $numberA = (int) filter_var($a->no_kabin, FILTER_SANITIZE_NUMBER_INT);
            $numberB = (int) filter_var($b->no_kabin, FILTER_SANITIZE_NUMBER_INT);
            return $numberA <=> $numberB;
        });

        // Apply additional filters based on kategoris
        if ($this->kategoris) {
            $kendaraans = $kendaraans->filter(function ($kendaraan) {
                if ($this->kategoris == 'memo') {
                    return $kendaraan->memo_ekspedisi->isNotEmpty();
                } elseif ($this->kategoris == 'non memo') {
                    return $kendaraan->memo_ekspedisi->isEmpty();
                }
                return true;
            });
        }

        return view('admin.laporan_mobillogistikglobal.logistik_global', [
            'kendaraans' => $kendaraans,
            'created_at' => $this->created_at,
            'tanggal_akhir' => $this->tanggal_akhir,
            'kategoris' => $this->kategoris,
        ]);
    }
}