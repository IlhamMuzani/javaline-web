<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Barang_akun;
use App\Models\Detail_pengeluaran;
use App\Models\Kendaraan;
use App\Models\Pelanggan;
use App\Models\Pengeluaran_asuransi;
use App\Models\Satuan;
use App\Models\Total_asuransi;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class InqueryPengeluaranasuransiController extends Controller
{
    public function index(Request $request)
    {
        Pengeluaran_asuransi::where([
            ['status', 'posting']
        ])->update([
            'status_notif' => true
        ]);

        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $inquery = Pengeluaran_asuransi::query();

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
        $saldoTerakhir = Total_asuransi::latest()->first();
        return view('admin.inquery_pengeluaranasuransi.index', compact('inquery', 'saldoTerakhir'));
    }

    public function edit($id)
    {
        $inquery = Pengeluaran_asuransi::where('id', $id)->first();

        return view('admin.inquery_pengeluaranasuransi.update', compact('inquery'));
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nominal' => 'required',
                // 'keterangan' => 'required', // Menambahkan aturan unique
            ],
            [
                'nominal.required' => 'Masukkan nominal',
                // 'nominal.numeric' => 'Nominal harus berupa angka',
                // 'keterangan.required' => 'Masukkan keterangan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $penerimaan = Pengeluaran_asuransi::findOrFail($id);

        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');

        $saldo = Total_asuransi::latest()->first();
        $sisaSaldo = $saldo->sisa_asuransi;

        $nominallama = $penerimaan->nominal;

        $nominalbaru = str_replace('.', '', $request->nominal);
        $hasil = $sisaSaldo - $nominalbaru;

        // return $hasil;

        $subTotalInput = $request->input('grand_total');

        // Hilangkan 'Rp' dan titik
        $cleanedSubTotal = str_replace(['Rp', '.'], '', $subTotalInput);
        // Ubah koma menjadi titik
        $cleanedSubTotal = str_replace(',', '.', $cleanedSubTotal);

        $saldoTerakhir = Total_asuransi::latest()->first();
        $saldo = $saldoTerakhir->id;

        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');

        $tanggal = Carbon::now()->format('Y-m-d');
        $penerimaan->update([
            'nominal' => $request->nominal ? str_replace('.', '', $request->nominal) : null,
            'total_asuransi_id' => $saldo,
            'keterangan' => $request->keterangan,
            'saldo_masuk' => $request->saldo_masuk,
            'grand_total' => $cleanedSubTotal,
            'status' => 'unpost',
        ]);

        Total_asuransi::create([
            'tanggal' => Carbon::now('Asia/Jakarta'),
            'sisa_asuransi' => $hasil,
            'status' => 'inquery',
        ]);

        $cetakpdf = Pengeluaran_asuransi::where('id', $id)->first();

        return view('admin.inquery_pengeluaranasuransi.show', compact('cetakpdf'));
    }


    public function show($id)
    {
        $cetakpdf = Pengeluaran_asuransi::where('id', $id)->first();
        $details = Detail_pengeluaran::where('pengeluaran_kaskecil_id', $id)->get();

        return view('admin.inquery_pengeluaranasuransi.show', compact('cetakpdf', 'details'));
    }

    public function unpostpengeluaranasuransi($id)
    {
        $item = Pengeluaran_asuransi::where('id', $id)->first();
        $lastSaldo = Total_asuransi::latest()->first();

        if (!$lastSaldo) {
            return back()->with('error', 'Uang Asuransi tidak ditemukan');
        }
        $sisaSaldo = $lastSaldo->sisa_asuransi + $item->nominal;
        Total_asuransi::create([
            'sisa_asuransi' => $sisaSaldo,
        ]);

        $item->update([
            'status' => 'unpost'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function postingpengeluaranasuransi($id)
    {
        $item = Pengeluaran_asuransi::where('id', $id)->first();
        $lastSaldo = Total_asuransi::latest()->first();

        if (!$lastSaldo) {
            return back()->with('error', 'Uang asuransi tidak ditemukan');
        }

        $uangjalan = $item->nominal;
        if ($lastSaldo->sisa_asuransi < $uangjalan) {
            return back()->with('error', 'Uang asuransi tidak mencukupi');
        }
        $sisaSaldo = $lastSaldo->sisa_asuransi - $item->nominal;
        Total_asuransi::create([
            'sisa_asuransi' => $sisaSaldo,
        ]);

        // Update the main record
        $item->update([
            'status' => 'posting'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function hapuspengeluaranasuransi($id)
    {
        $item = Pengeluaran_asuransi::where('id', $id)->first();

        // $item->detail_tagihan()->delete();
        $item->delete();

        return back()->with('success', 'Berhasil');
    }
}