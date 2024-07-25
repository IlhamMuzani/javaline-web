<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Deposit_driver;
use App\Models\Detail_inventory;
use App\Models\Detail_klaimperalatan;
use App\Models\Karyawan;
use App\Models\Kendaraan;
use App\Models\Klaim_peralatan;
use App\Models\Penerimaan_kaskecil;
use App\Models\Saldo;
use App\Models\Sparepart;
use Illuminate\Support\Facades\Validator;

class InqueryKlaimperalatanController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $inquery = Klaim_peralatan::query();

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

        return view('admin.inquery_klaimperalatan.index', compact('inquery'));
    }

    public function edit($id)
    {
        $inquery = Klaim_peralatan::where('id', $id)->first();

        $kendaraans = Kendaraan::all();
        $spareparts = Sparepart::where([
            'kategori' => 'peralatan'
        ])->get();
        $SopirAll = Karyawan::where('departemen_id', '2')->get();
        $details = Detail_klaimperalatan::where('klaim_peralatan_id', $id)->get();

        return view('admin.inquery_klaimperalatan.update', compact('details', 'inquery', 'SopirAll', 'kendaraans', 'spareparts'));
    }

    public function update(Request $request, $id)
    {
    }

    public function unpostklaimperalatan($id)
    {
        $pembelian = Klaim_peralatan::findOrFail($id);
        $detailpembelian = Detail_klaimperalatan::where('klaim_peralatan_id', $id)->get();

        foreach ($detailpembelian as $detail) {
            // Cari Detail_inventory yang sesuai
            $existingDetailBarang = Detail_inventory::where('kendaraan_id', $pembelian->kendaraan_id)
                ->where('sparepart_id', $detail->sparepart_id)
                ->first();

            if ($existingDetailBarang) {
                // Kurangi jumlahnya
                $existingDetailBarang->jumlah += $detail->jumlah;

                // Simpan perubahan
                $existingDetailBarang->save();
            }
        }


        $depositdrivers = $pembelian->deposit_driver_id;
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

        $penerimaans = $pembelian->penerimaan_kaskecil_id;
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

        // Update status pembelian menjadi 'unpost'
        $pembelian->update(['status' => 'unpost']);

        return back()->with('success', 'Klaim_peralatan berhasil di-unpost.');
    }


    public function postingklaimperalatan($id)
    {
        $pembelian = Klaim_peralatan::findOrFail($id);
        $detailpembelian = Detail_klaimperalatan::where('klaim_peralatan_id', $id)->get();

        foreach ($detailpembelian as $detail) {
            // Cari Detail_inventory yang sesuai
            $existingDetailBarang = Detail_inventory::where('kendaraan_id', $pembelian->kendaraan_id)
                ->where('sparepart_id', $detail->sparepart_id)
                ->first();
            if ($existingDetailBarang) {
                // Tambahkan jumlahnya
                $existingDetailBarang->jumlah -= $detail->jumlah;
                // Simpan perubahan
                $existingDetailBarang->save();
            }
        }


        $depositdrivers = $pembelian->deposit_driver_id;
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

        $penerimaans = $pembelian->penerimaan_kaskecil_id;
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

        // Update status pembelian menjadi 'posting'
        $pembelian->update(['status' => 'posting']);

        return back()->with('success', 'Klaim_peralatan berhasil di-posting kembali.');
    }


    public function show($id)
    {
        $klaim_peralatan = Klaim_peralatan::find($id);
        $details = Detail_klaimperalatan::where('klaim_peralatan_id', $klaim_peralatan->id)->get();

        return view('admin.inquery_klaimperalatan.show', compact('details', 'klaim_peralatan'));
    }

    public function hapusperalatan($id)
    {
        $klaim_peralatan = Klaim_peralatan::where('id', $id)->first();

        if ($klaim_peralatan) {
            $detail_klaim = Detail_klaimperalatan::where('klaim_peralatan_id', $id)->get();
            // Delete related Detail_tagihan instances
            Detail_klaimperalatan::where('klaim_peralatan_id', $id)->delete();
            $klaim_peralatan->delete();

            return back()->with('success', 'Berhasil menghapus Klaim_peralatan');
        } else {
            // Handle the case where the Klaim_peralatan with the given ID is not found
            return back()->with('error', 'Klaim_peralatan tidak ditemukan');
        }
    }
}