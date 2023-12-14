<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use App\Models\Ban;
use App\Models\Merek;
use App\Models\Ukuran;
use App\Models\Typeban;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\Pembelian_ban;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\Faktur_ekspedisi;
use App\Models\Memo_ekspedisi;
use App\Models\Pelanggan;
use App\Models\Saldo;
use App\Models\Tarif;
use Illuminate\Support\Facades\Validator;
use Egulias\EmailValidator\Result\Reason\DetailedReason;

class InqueryFakturekspedisiController extends Controller
{
    public function index(Request $request)
    {
        Faktur_ekspedisi::where([
            ['status', 'posting']
        ])->update([
            'status_notif' => true
        ]);

        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $inquery = Faktur_ekspedisi::query();

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

        return view('admin.inquery_fakturekspedisi.index', compact('inquery'));
    }

    public function edit($id)
    {
        // if (auth()->check() && auth()->user()->menu['inquery perpanjangan stnk']) {
        $pelanggans = Pelanggan::all();
        $memos = Memo_ekspedisi::all();
        $tarifs = Tarif::all();
        $inquery = Faktur_ekspedisi::where('id', $id)->first();

        return view('admin.inquery_fakturekspedisi.update', compact('inquery', 'pelanggans', 'memos', 'tarifs'));
        // } else {
        //     // tidak memiliki akses
        //     return back()->with('error', array('Anda tidak memiliki akses'));
        // }
    }



    public function show($id)
    {
        $cetakpdf = Faktur_ekspedisi::where('id', $id)->first();

        return view('admin.inquery_fakturekspedisi.show', compact('cetakpdf'));
    }

    public function unpostfaktur($id)
    {
        $faktur = Faktur_ekspedisi::where('id', $id)->first();

        $faktur->update([
            'status' => 'unpost'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function postingfaktur($id)
    {
        $faktur = Faktur_ekspedisi::where('id', $id)->first();

        $faktur->update([
            'status' => 'posting'
        ]);

        return back()->with('success', 'Berhasil');
    }


    public function destroy($id)
    {
        $faktur = Faktur_ekspedisi::find($id);
        $faktur->delete();

        return redirect('admin/inquery_fakturekspedisi')->with('success', 'Berhasil menghapus Faktur Ekspedisi');
    }
}