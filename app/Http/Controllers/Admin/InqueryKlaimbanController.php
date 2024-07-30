<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ban;
use App\Models\Deposit_driver;
use App\Models\Karyawan;
use App\Models\Klaim_ban;
use App\Models\Penerimaan_kaskecil;
use App\Models\Saldo;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Validator;

class InqueryKlaimbanController extends Controller
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
            $inquery->whereDate('tanggal_awal', Carbon::today());
        }

        $inquery->orderBy('id', 'DESC');
        $inquery = $inquery->get();

        return view('admin.inqueryklaim_ban.index', compact('inquery'));
    }

    public function edit($id)
    {
        $inquery = Klaim_ban::where('id', $id)->first();
        $SopirAll = Karyawan::where('departemen_id', '2')->get();

        return view('admin.inqueryklaim_ban.update', compact('inquery', 'SopirAll'));
    }


    public function show($id)
    {
        $cetakpdf = Klaim_ban::where('id', $id)->first();

        return view('admin.inqueryklaim_ban.show', compact('cetakpdf'));
    }

    public function update(Request $request, $id)
    {
        $cetakpdf = Klaim_ban::where('id', $id)->first();
        $validator = Validator::make(
            $request->all(),
            [
                'karyawan_id' => 'required',
            ],
            [
                'karyawan_id.required' => 'Masukkan nama golongan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $banId = $request->id_ban;
        $ban = Ban::find($banId);

        if (!$ban) {
            return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
        }

        $ban->update([
            'keterangan' => $request->keterangan,
            'km_pelepasan' => $request->km_pelepasan,
            'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
            'km_terpakai' => $request->km_terpakai,

        ]);
        $depositdriver = Deposit_driver::where('id', $cetakpdf->deposit_driver_id)->first();
        $depositdriver->update(
            [
                'ban_id' => $banId,
                'karyawan_id' => $request->karyawan_id,
                'kode_sopir' => $request->kode_karyawan,
                'nama_sopir' => $request->nama_lengkap,
                'kategori' => 'Pengambilan Deposit',
                'sub_total' => str_replace('.', '', $request->sub_totals),
                'nominal' => str_replace('.', '', $request->saldo_keluar),
                'saldo_keluar' => $request->saldo_keluar,
                'keterangan' => $request->keterangans,
                'sisa_saldo' => str_replace('.', '', $request->sisa_saldo),
                'status' => 'unpost',
            ]
        );
        $saldoTerakhir = Saldo::latest()->first();
        $saldo = $saldoTerakhir->id;
        $saldo_keluar_numeric = (float) str_replace('.', '', $request->saldo_keluar);
        $subtotals =  $saldoTerakhir->sisa_saldo + $saldo_keluar_numeric;

        $penerimaan = Penerimaan_kaskecil::where('id', $cetakpdf->penerimaan_kaskecil_id)->first();
        $penerimaan->update(
            [
                'deposit_driver_id' => $depositdriver->id,
                'nominal' => str_replace('.', '', $request->saldo_keluar),
                'saldo_masuk' => $request->saldo_keluar,
                'keterangan' => $request->keterangans,
                'sisa_saldo' => $saldoTerakhir->sisa_saldo,
                'saldo_id' => $saldo,
                'sub_total' => $subtotals,
                'status' => 'unpost',
            ]
        );

        $cetakpdf->update(
            [
                'ban_id' => $banId,
                'karyawan_id' => $request->karyawan_id,
                'deposit_driver_id' => $depositdriver->id,
                'penerimaan_kaskecil_id' => $penerimaan->id,
                'keterangan' => $request->keterangan,
                'harga_ban' => $ban->harga,
                'harga_klaim' => str_replace('.', '', $request->sisa_harga),
                'km_terpakai' => $request->km_terpakai,
                'target_km' => $request->target_km,
                'km_pemasangan' => $request->km_pemasangan,
                'km_pelepasan' => $request->km_pelepasan,
                'grand_total' => $request->grand_total,
                'status' => 'unpost',
            ]
        );
        return view('admin.inqueryklaim_ban.show', compact('cetakpdf'));
    }

    public function unpost_klaimban($id)
    {
        $item = Klaim_ban::where('id', $id)->first();

        $depositdrivers = $item->deposit_driver_id;
        $depositdriver = Deposit_driver::where('id', $depositdrivers)->first();
        if ($depositdriver) {
            $sopir = Karyawan::find($depositdriver->karyawan_id);

            if (!$sopir) {
                return back()->with('error', 'Karyawan tidak ditemukan');
            }

            $kasbon = $sopir->kasbon;
            $totalKasbon = $depositdriver->nominal;
            $kasbons = $kasbon - $totalKasbon;

            $tabungan = $sopir->tabungan;
            $total = $depositdriver->nominal;
            $sub_totals = $tabungan + $total;

            $sopir->update([
                'kasbon' => $kasbons,
                // 'deposit' => $deposits,
                'tabungan' => $sub_totals
            ]);
            $depositdriver->update([
                'status' => 'unpost'
            ]);
        }

        $penerimaans = $item->penerimaan_kaskecil_id;
        $penerimaan = Penerimaan_kaskecil::where('id', $penerimaans)->first();
        if ($penerimaan) {
            $lastSaldo = Saldo::latest()->first();

            if (!$lastSaldo) {
                return back()->with('error', 'Saldo tidak ditemukan');
            }

            $sisaSaldo = $lastSaldo->sisa_saldo - $penerimaan->nominal;
            Saldo::create([
                'sisa_saldo' => $sisaSaldo,
            ]);

            $penerimaan->update([
                'status' => 'unpost'
            ]);
        }
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

            if (!$sopir) {
                return back()->with('error', 'Karyawan tidak ditemukan');
            }

            $kasbon = $sopir->kasbon;
            $totalKasbon = $depositdriver->nominal;
            $kasbons = $kasbon + $totalKasbon;

            $tabungan = $sopir->tabungan;
            $total = $depositdriver->nominal;
            $sub_totals = $tabungan - $total;

            $sopir->update([
                'kasbon' => $kasbons,
                // 'deposit' => $deposits,
                'tabungan' => $sub_totals
            ]);
            $depositdriver->update([
                'status' => 'posting'
            ]);
        }

        $penerimaans = $item->penerimaan_kaskecil_id;
        $penerimaan = Penerimaan_kaskecil::where('id', $penerimaans)->first();
        if ($penerimaan) {
            $lastSaldo = Saldo::latest()->first();
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
        $item->update([
            'status' => 'posting'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function cetakpdf($id)
    {
        $cetakpdf = Klaim_ban::where('id', $id)->first();

        $pdf = PDF::loadView('admin.inqueryklaim_ban.cetak_pdf', compact('cetakpdf'));
        $pdf->setPaper('letter', 'portrait'); // Set the paper size to portrait letter

        return $pdf->stream('Surat_klaim_ban_driver.pdf');
    }
}