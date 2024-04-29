<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Deposit_driver;
use App\Models\Detail_faktur;
use App\Models\Detail_tariftambahan;
use App\Models\Karyawan;
use App\Models\Klaim_ban;
use App\Models\Kendaraan;
use App\Models\Memo_ekspedisi;
use App\Models\Memotambahan;
use App\Models\Pelanggan;
use App\Models\Penerimaan_kaskecil;
use App\Models\Pph;
use App\Models\Saldo;
use App\Models\Tarif;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Validator;

class KlaimbanController extends Controller
{
    public function index(Request $request)
    {
        Klaim_ban::where([
            ['status', 'posting']
        ])->update([
            'status_notif' => true
        ]);

        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $inquery = Klaim_ban::query();

        if ($status) {
            $inquery->where('status', $status);
        }

        if ($tanggal_awal && $tanggal_akhir) {
            $inquery->whereBetween('tanggal_awal', [$tanggal_awal, $tanggal_akhir]);
        } elseif ($tanggal_awal) {
            $inquery->where('tanggal_awal', '>=', $tanggal_awal);
        } elseif ($tanggal_akhir) {
            $inquery->where('tanggal_awal', '<=', $tanggal_akhir);
        } else {
            // Jika tidak ada filter tanggal hari ini
            $inquery->whereDate('tanggal_awal', Carbon::today());
        }

        $inquery->orderBy('id', 'DESC');
        $inquery = $inquery->get();

        return view('admin.klaim_ban.index', compact('inquery'));
    }

    public function show($id)
    {
        $cetakpdf = Klaim_ban::where('id', $id)->first();

        return view('admin.klaim_ban.show', compact('cetakpdf'));
    }

    public function hapusfaktur($id)
    {
        $faktur = Klaim_ban::find($id);

        if ($faktur) {
            // Check if the category is 'PPH' before attempting to delete Pph
            if ($faktur->kategori === 'PPH') {
                $pph = Pph::where('faktur_ekspedisi_id', $id)->first();

                // Check if the PPH record exists before deleting
                if ($pph) {
                    $pph->delete();
                }
            }
            // Retrieve related Detail_faktur instances
            $detailfaktur = Detail_faktur::where('faktur_ekspedisi_id', $id)->get();

            // Delete related Detail_faktur instances
            $faktur->detail_faktur->each(function ($detail) {
                $detail->delete();
            });
            // Delete the main Klaim_ban instance
            $faktur->delete();

            return back()->with('success', 'Berhasil menghapus Faktur Ekspedisi');
        } else {
            // Handle the case where the Klaim_ban with the given ID is not found
            return back()->with('error', 'Faktur Ekspedisi tidak ditemukan');
        }
    }

    public function unpost_klaimban($id)
    {
        $item = Klaim_ban::where('id', $id)->first();

        $depositdrivers = $item->deposit_driver_id;
        $depositdriver = Deposit_driver::where('id', $depositdrivers)->first();
        if ($depositdriver) {
            $sopir = Karyawan::find($depositdriver->karyawan_id);

            // Pastikan karyawan ditemukan
            if (!$sopir) {
                return back()->with('error', 'Karyawan tidak ditemukan');
            }

            $kasbon = $sopir->kasbon;
            $totalKasbon = $depositdriver->nominal;
            $kasbons = $kasbon - $totalKasbon;

            $tabungan = $sopir->tabungan;
            $total = $depositdriver->nominal;
            $sub_totals = $tabungan + $total;

            // Update tabungan karyawan
            $sopir->update([
                'kasbon' => $kasbons,
                // 'deposit' => $deposits,
                'tabungan' => $sub_totals
            ]);
            // Update status deposit_driver menjadi 'posting'
            $depositdriver->update([
                'status' => 'unpost'
            ]);
        }

        $penerimaans = $item->penerimaan_kaskecil_id;
        $penerimaan = Penerimaan_kaskecil::where('id', $penerimaans)->first();
        if ($penerimaan) {
            $lastSaldo = Saldo::latest()->first();

            // Periksa apakah saldo terakhir ditemukan
            if (!$lastSaldo) {
                return back()->with('error', 'Saldo tidak ditemukan');
            }

            $sisaSaldo = $lastSaldo->sisa_saldo - $penerimaan->nominal;
            Saldo::create([
                'sisa_saldo' => $sisaSaldo,
            ]);

            // Perbarui status penerimaan menjadi "unpost"
            $penerimaan->update([
                'status' => 'unpost'
            ]);
        }

        // Update the main record
        $item->update([
            'status' => 'unpost'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function posting_klaimban($id)
    {
        $item = Klaim_ban::where('id', $id)->first();

        $depositdrivers = $item->deposit_driver_id;
        $depositdriver = Deposit_driver::where('id', $depositdrivers)->first();
        if ($depositdriver) {                
            $sopir = Karyawan::find($depositdriver->karyawan_id);

            // Pastikan karyawan ditemukan
            if (!$sopir) {
                return back()->with('error', 'Karyawan tidak ditemukan');
            }

            $kasbon = $sopir->kasbon;
            $totalKasbon = $depositdriver->nominal;
            $kasbons = $kasbon + $totalKasbon;

            $tabungan = $sopir->tabungan;
            $total = $depositdriver->nominal;
            $sub_totals = $tabungan - $total;

            // Update tabungan karyawan
            $sopir->update([
                'kasbon' => $kasbons,
                // 'deposit' => $deposits,
                'tabungan' => $sub_totals
            ]);
            // Update status deposit_driver menjadi 'posting'
            $depositdriver->update([
                'status' => 'posting'
            ]);
        }

        $penerimaans = $item->penerimaan_kaskecil_id;
        $penerimaan = Penerimaan_kaskecil::where('id', $penerimaans)->first();
        if ($penerimaan) {
            $lastSaldo = Saldo::latest()->first();

            // Periksa apakah saldo terakhir ditemukan
            if (!$lastSaldo) {
                return back()->with('error', 'Saldo tidak ditemukan');
            }

            $sisaSaldo = $lastSaldo->sisa_saldo + $penerimaan->nominal;
            Saldo::create([
                'sisa_saldo' => $sisaSaldo,
            ]);

            $penerimaan->update([
                'status' => 'posting'
            ]);
        }
            
        // Update the main record
        $item->update([
            'status' => 'posting'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function cetakpdf($id)
    {
        $cetakpdf = Klaim_ban::where('id', $id)->first();

        $pdf = PDF::loadView('admin.klaim_ban.cetak_pdf', compact('cetakpdf'));
        $pdf->setPaper('letter', 'portrait'); // Set the paper size to portrait letter

        return $pdf->stream('Surat_klaim_ban_driver.pdf');
    }

}