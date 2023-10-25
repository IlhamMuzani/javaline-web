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
use App\Models\Laporanstnk;
use App\Models\Stnk;
use Illuminate\Support\Facades\Validator;
use Egulias\EmailValidator\Result\Reason\DetailedReason;

class InqueryPerpanjanganstnkController extends Controller
{
    public function index(Request $request)
    {
        // if (auth()->check() && auth()->user()->menu['inquery perpanjangan stnk']) {

        Laporanstnk::where([
            ['status', 'posting']
        ])->update([
            'status_notif' => true
        ]);

        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $inquery = Laporanstnk::query();

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

        return view('admin.inquery_perpanjanganstnk.index', compact('inquery'));
        // } else {
        //     // tidak memiliki akses
        //     return back()->with('error', array('Anda tidak memiliki akses'));
        // }
    }

    public function edit($id)
    {
        // if (auth()->check() && auth()->user()->menu['inquery perpanjangan stnk']) {

        $inquery = Laporanstnk::where('id', $id)->first();

        return view('admin.inquery_perpanjanganstnk.update', compact('inquery'));
        // } else {
        //     // tidak memiliki akses
        //     return back()->with('error', array('Anda tidak memiliki akses'));
        // }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'expired_stnk' => 'required',
                'jumlah' => 'required'
            ],
            [
                'expired_stnk' => 'masukkan tanggal expired',
                'jumlah' => 'masukkan jumlah',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $stnk = Laporanstnk::findOrFail($id);

        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');
        Laporanstnk::where('id', $id)->update([
            'expired_stnk' => $request->expired_stnk,
            'jumlah' => $request->jumlah,
            'tanggal' => $format_tanggal,
            'status' => 'posting',
            'tanggal_awal' => $request->expired_stnk,
        ]);

        Stnk::where('id', $stnk->stnk_id)->update([
            'expired_stnk' => $request->expired_stnk,
            'jumlah' => $request->jumlah,
        ]);

        $cetakpdf = Laporanstnk::where('id', $id)->first();

        return view('admin.inquery_perpanjanganstnk.show', compact('cetakpdf'));
    }

    public function show($id)
    {
        // if (auth()->check() && auth()->user()->menu['perpanjangan stnk']) {

        $cetakpdf = Laporanstnk::where('id', $id)->first();
        return view('admin.inquery_perpanjanganstnk.show', compact('cetakpdf'));
        // } else {
        //     // tidak memiliki akses
        //     return back()->with('error', array('Anda tidak memiliki akses'));
        // }
    }

    public function cetakpdf($id)
    {
        $cetakpdf = Laporanstnk::where('id', $id)->first();

        $pdf = PDF::loadView('admin/inquery_perpanjanganstnk.cetak_pdf', compact('cetakpdf'));
        $pdf->setPaper('letter', 'portrait');

        return $pdf->stream('Surat_Perpanjangan_Stnk.pdf');
    }

    public function unpoststnk($id)
    {
        $ban = Laporanstnk::where('id', $id)->first();

        $ban->update([
            'status' => 'unpost'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function postingstnk($id)
    {
        $ban = Laporanstnk::where('id', $id)->first();

        $ban->update([
            'status' => 'posting'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function destroy($id)
    {
        $stnk = Laporanstnk::find($id);
        $stnk->delete();

        return redirect('admin/inquery_perpanjanganstnk')->with('success', 'Berhasil menghapus perpanjangan');
    }
}