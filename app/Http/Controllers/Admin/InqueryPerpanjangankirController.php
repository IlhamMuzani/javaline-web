<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\Detail_pengeluaran;
use App\Models\Laporankir;
use App\Models\Nokir;
use App\Models\Pengeluaran_kaskecil;
use App\Models\Saldo;
use Illuminate\Support\Facades\Validator;
use Egulias\EmailValidator\Result\Reason\DetailedReason;

class InqueryPerpanjangankirController extends Controller
{
    public function index(Request $request)
    {
        // if (auth()->check() && auth()->user()->menu['inquery perpanjangan nokir']) {

        Laporankir::where([
            ['status', 'posting']
        ])->update([
            'status_notif' => true
        ]);

        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $inquery = Laporankir::query();

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

        return view('admin.inquery_perpanjangankir.index', compact('inquery'));
        // } else {
        //     // tidak memiliki akses
        //     return back()->with('error', array('Anda tidak memiliki akses'));
        // }
    }

    public function edit($id)
    {
        // if (auth()->check() && auth()->user()->menu['inquery perpanjangan nokir']) {

        $inquery = Laporankir::where('id', $id)->first();

        return view('admin.inquery_perpanjangankir.update', compact('inquery'));
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
                'kategori' => 'required',
                'masa_berlaku' => 'required',
                'jumlah' => 'required'
            ],
            [
                'kategori' => 'pilih kategori',
                'masa_berlaku' => 'masukkan tanggal expired',
                'jumlah' => 'masukkan jumlah',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $nokir = Laporankir::findOrFail($id);

        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');

        $kategori = $request->kategori;

        if ($kategori == 'Perpanjangan JAVA LINE LOGISTICS') {
            $status = 'posting';
        } else {
            $status = 'unpost';
        }
        $laporan = Laporankir::where('id', $id)->update([
            'kategori' => $request->kategori,
            'masa_berlaku' => $request->masa_berlaku,
            'jumlah' => $request->jumlah,
            'status' => $status,
        ]);

        Nokir::where('id', $nokir->nokir_id)->update([
            'kategori' => $request->kategori,
            'masa_berlaku' => $request->masa_berlaku,
            'jumlah' => $request->jumlah,
        ]);

        if ($kategori == 'Perpanjangan DISHUB') {

            $pengeluaran = Pengeluaran_kaskecil::where('laporankir_id', $id)->first();
            $pengeluaran->update(
                [
                    'laporankir_id' => $id,
                    'kendaraan_id' => $nokir->kendaraan_id,
                    'grand_total' => str_replace('.', '', $request->jumlah),
                    'status' => 'unpost',
                ]
            );

            $detailpengeluaran = Detail_pengeluaran::where('laporankir_id', $id)->first();
            $detailpengeluaran->update(
                [
                    'laporankir_id' => $id,
                    'nominal' => str_replace('.', '', $request->jumlah),
                    'status' => 'unpost',
                ]
            );
        }

        $cetakpdf = Laporankir::where('id', $id)->first();

        return view('admin.inquery_perpanjangankir.show', compact('cetakpdf'));
    }

    public function show($id)
    {
        // if (auth()->check() && auth()->user()->menu['perpanjangan nokir']) {

        $cetakpdf = Laporankir::where('id', $id)->first();
        return view('admin.inquery_perpanjangankir.show', compact('cetakpdf'));
        // } else {
        //     // tidak memiliki akses
        //     return back()->with('error', array('Anda tidak memiliki akses'));
        // }
    }

    public function cetakpdf($id)
    {
        $cetakpdf = Laporankir::where('id', $id)->first();

        $pdf = PDF::loadView('admin/inquery_perpanjangankir.cetak_pdf', compact('cetakpdf'));
        $pdf->setPaper('letter', 'portrait');

        return $pdf->stream('Surat_Perpanjangan_Nokir.pdf');
    }

    public function unpostkir($id)
    {
        $item = Laporankir::where('id', $id)->first();


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
        Pengeluaran_kaskecil::where('laporankir_id', $id)->update([
            'status' => 'unpost'
        ]);
        Detail_pengeluaran::where('laporankir_id', $id)->update([
            'status' => 'unpost'
        ]);


        $item->update([
            'status' => 'unpost'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function postingkir($id)
    {
        $item = Laporankir::where('id', $id)->first();

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
        Pengeluaran_kaskecil::where('laporankir_id', $id)->update([
            'status' => 'posting'
        ]);
        Detail_pengeluaran::where('laporankir_id', $id)->update([
            'status' => 'posting'
        ]);

        // Update status laporankir
        $item->update([
            'status' => 'posting'
        ]);

        return back()->with('success', 'Berhasil');
    }


    public function hapuskir($id)
    {
        $item = Laporankir::where('id', $id)->first();

        $item->delete();
        return back()->with('success', 'Berhasil');
    }

    public function destroy($id)
    {
        $nokir = Laporankir::find($id);
        $nokir->delete();

        return redirect('admin/inquery_perpanjangankir')->with('success', 'Berhasil menghapus perpanjangan');
    }
}