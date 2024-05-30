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
use App\Models\Pengeluaran_ujs;
use App\Models\Satuan;
use App\Models\Total_ujs;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class InqueryPengeluaranujsController extends Controller
{
    public function index(Request $request)
    {
        Pengeluaran_ujs::where([
            ['status', 'posting']
        ])->update([
            'status_notif' => true
        ]);

        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $inquery = Pengeluaran_ujs::query();

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
        $saldoTerakhir = Total_ujs::latest()->first();
        return view('admin.inquery_pengeluaranujs.index', compact('inquery', 'saldoTerakhir'));
    }

    public function edit($id)
    {
        $inquery = Pengeluaran_ujs::where('id', $id)->first();

        return view('admin.inquery_pengeluaranujs.update', compact('inquery'));
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

        $penerimaan = Pengeluaran_ujs::findOrFail($id);

        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');

        $saldo = Total_ujs::latest()->first();
        $sisaSaldo = $saldo->sisa_ujs;

        $nominallama = $penerimaan->nominal;

        $nominalbaru = str_replace('.', '', $request->nominal);
        $hasil = $sisaSaldo - $nominalbaru;

        // return $hasil;

        $subTotalInput = $request->input('grand_total');

        // Hilangkan 'Rp' dan titik
        $cleanedSubTotal = str_replace(['Rp', '.'], '', $subTotalInput);
        // Ubah koma menjadi titik
        $cleanedSubTotal = str_replace(',', '.', $cleanedSubTotal);

        $saldoTerakhir = Total_ujs::latest()->first();
        $saldo = $saldoTerakhir->id;

        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');

        $tanggal = Carbon::now()->format('Y-m-d');
        $penerimaan->update([
            'nominal' => $request->nominal ? str_replace('.', '', $request->nominal) : null,
            'total_ujs_id' => $saldo,
            'keterangan' => $request->keterangan,
            'saldo_masuk' => $request->saldo_masuk,
            'grand_total' => $cleanedSubTotal,
            'status' => 'unpost',
        ]);

        Total_ujs::create([
            'tanggal' => Carbon::now('Asia/Jakarta'),
            'sisa_ujs' => $hasil,
            'status' => 'inquery',
        ]);

        $cetakpdf = Pengeluaran_ujs::where('id', $id)->first();

        return view('admin.inquery_pengeluaranujs.show', compact('cetakpdf'));
    }


    public function show($id)
    {
        $cetakpdf = Pengeluaran_ujs::where('id', $id)->first();
        $details = Detail_pengeluaran::where('pengeluaran_kaskecil_id', $id)->get();

        return view('admin.inquery_pengeluaranujs.show', compact('cetakpdf', 'details'));
    }

    public function unpostpengeluaranujs($id)
    {
        $item = Pengeluaran_ujs::where('id', $id)->first();
        $lastSaldo = Total_ujs::latest()->first();

        if (!$lastSaldo) {
            return back()->with('error', 'Ujs tidak ditemukan');
        }
        $sisaSaldo = $lastSaldo->sisa_ujs + $item->nominal;
        Total_ujs::create([
            'sisa_ujs' => $sisaSaldo,
        ]);

        $item->update([
            'status' => 'unpost'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function postingpengeluaranujs($id)
    {
        $item = Pengeluaran_ujs::where('id', $id)->first();
        $lastSaldo = Total_ujs::latest()->first();

        if (!$lastSaldo) {
            return back()->with('error', 'UJS tidak ditemukan');
        }

        $uangjalan = $item->nominal;
        if ($lastSaldo->sisa_ujs < $uangjalan) {
            return back()->with('error', 'UJS tidak mencukupi');
        }
        $sisaSaldo = $lastSaldo->sisa_ujs - $item->nominal;
        Total_ujs::create([
            'sisa_ujs' => $sisaSaldo,
        ]);

        // Update the main record
        $item->update([
            'status' => 'posting'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function hapuspengeluaranujs($id)
    {
        $item = Pengeluaran_ujs::where('id', $id)->first();

        // $item->detail_tagihan()->delete();
        $item->delete();

        return back()->with('success', 'Berhasil');
    }
}