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
use App\Models\Detail_pengeluaran;
use App\Models\Laporanstnk;
use App\Models\Pengeluaran_kaskecil;
use App\Models\Saldo;
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
            // 'tanggal' => $format_tanggal,
            'status' => 'unpost',
        ]);

        $pengeluaran = Pengeluaran_kaskecil::where('laporanstnk_id', $id)->first();
        $pengeluaran->update(
            [
                'laporanstnk_id' => $id,
                'kendaraan_id' => $stnk->kendaraan_id,
                'grand_total' => str_replace('.', '', $request->jumlah),
                'status' => 'unpost',
            ]
        );

        $detailpengeluaran = Detail_pengeluaran::where('laporanstnk_id', $id)->first();
        $detailpengeluaran->update(
            [
                'laporanstnk_id' => $id,
                'nominal' => str_replace('.', '', $request->jumlah),
                'status' => 'unpost',
            ]
        );

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
        $item = Laporanstnk::where('id', $id)->first();

        $lastSaldo = Saldo::latest()->first();
        if (!$lastSaldo) {
            return back()->with('error', 'Saldo tidak ditemukan');
        }

        $sisaSaldo = $item->jumlah;

        if ($lastSaldo->sisa_saldo < $sisaSaldo) {
            return back()->with('error', 'Saldo tidak mencukupi');
        }

        // Update saldo terakhir
        $lastSaldo->update([
            'sisa_saldo' => $lastSaldo->sisa_saldo + $sisaSaldo,
        ]);

        // Update status pengeluaran
        Pengeluaran_kaskecil::where('laporanstnk_id', $id)->update([
            'status' => 'unpost'
        ]);
        Detail_pengeluaran::where('laporanstnk_id', $id)->update([
            'status' => 'unpost'
        ]);

        $item->update([
            'status' => 'unpost'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function postingstnk($id)
    {
        $item = Laporanstnk::where('id', $id)->first();

        $lastSaldo = Saldo::latest()->first();
        if (!$lastSaldo) {
            return back()->with('error', 'Saldo tidak ditemukan');
        }

        $uangjalan = $item->jumlah;

        if ($lastSaldo->sisa_saldo < $uangjalan) {
            return back()->with('error', 'Saldo tidak mencukupi');
        }

        $sisaSaldo = $item->jumlah;
        // Update saldo terakhir
        $lastSaldo->update([
            'sisa_saldo' => $lastSaldo->sisa_saldo - $sisaSaldo,
        ]);

        // Update status pengeluaran
        Pengeluaran_kaskecil::where('laporanstnk_id', $id)->update([
            'status' => 'posting'
        ]);
        Detail_pengeluaran::where('laporanstnk_id', $id)->update([
            'status' => 'posting'
        ]);

        $item->update([
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