<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Pembelian_ban;
use App\Http\Controllers\Controller;
use App\Models\Deposit_driver;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Validator;

class InqueryDepositdriverController extends Controller
{
    public function index(Request $request)
    {
        Deposit_driver::where([
            ['status', 'posting']
        ])->update([
            'status_notif' => true
        ]);

        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;
        $inquery = Deposit_driver::query();
        $inquery->where('kategori', 'Pengambilan Deposit');

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

        return view('admin.inquery_depositdriver.index', compact('inquery'));
    }


    public function edit($id)
    {

        $inquery = Deposit_driver::where('id', $id)->first();
        $SopirAll = Karyawan::where('departemen_id', '2')->get();

        return view('admin.inquery_depositdriver.update', compact('inquery', 'SopirAll'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'kategori' => 'required',
                'karyawan_id' => 'required',
            ],
            [
                'kategori.required' => 'Pilih kategori',
                'karyawan_id.required' => 'Pilih sopir',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kategori = $request->kategori;
        if ($kategori == "Pemasukan Deposit") {

            $penerimaan = Deposit_driver::findOrFail($id);

            $tanggal_awal = Carbon::parse($penerimaan->tanggal_awal);

            $today = Carbon::now('Asia/Jakarta')->format('Y-m-d');
            $lastUpdatedDate = $tanggal_awal->format('Y-m-d');

            // if ($lastUpdatedDate < $today) {
            //     return back()->with('errormax', 'Anda tidak dapat melakukan update setelah berganti hari.');
            // }

            $tanggal1 = Carbon::now('Asia/Jakarta');
            $format_tanggal = $tanggal1->format('d F Y');

            $subTotalInput = $request->input('sub_total');
            $cleanedSubTotal = (int) str_replace(['Rp', '.'], '', $subTotalInput);

            $tanggal1 = Carbon::now('Asia/Jakarta');
            $format_tanggal = $tanggal1->format('d F Y');

            $tanggal = Carbon::now()->format('Y-m-d');
            $penerimaan->update([
                'nominal' => $request->nominal,
                'kode_sopir' => $request->kode_sopir,
                'nama_sopir' => $request->nama_sopir,
                'keterangan' => $request->keterangan,
                'saldo_masuk' => $request->saldo_masuk,
                'sisa_saldo' => $request->sisa_saldo,
                'sub_total' => $request->sub_total2,
                'status' => 'unpost',
            ]);


            $cetakpdf = Deposit_driver::where('id', $id)->first();

            return view('admin.inquery_depositdriver.show', compact('cetakpdf'));
        } else {

            $penerimaan = Deposit_driver::findOrFail($id);

            $tanggal_awal = Carbon::parse($penerimaan->tanggal_awal);

            $today = Carbon::now('Asia/Jakarta')->format('Y-m-d');
            $lastUpdatedDate = $tanggal_awal->format('Y-m-d');

            // if ($lastUpdatedDate < $today) {
            //     return back()->with('errormax', 'Anda tidak dapat melakukan update setelah berganti hari.');
            // }

            $tanggal1 = Carbon::now('Asia/Jakarta');
            $format_tanggal = $tanggal1->format('d F Y');

            $subTotalInput = $request->input('sub_totals');
            $cleanedSubTotal = (int) str_replace(['Rp', '.'], '', $subTotalInput);

            $tanggal1 = Carbon::now('Asia/Jakarta');
            $format_tanggal = $tanggal1->format('d F Y');

            $tanggal = Carbon::now()->format('Y-m-d');
            $penerimaan->update([
                'nominal' => $request->nominals,
                'keterangan' => $request->keterangans,
                'kode_sopir' => $request->kode_sopir,
                'nama_sopir' => $request->nama_sopir,
                'saldo_keluar' => $request->saldo_keluar,
                'sisa_saldo' => str_replace('.', '', $request->sisa_saldos), // Menghapus titik dari nilai sisa_saldo
                'sub_total' => $request->sub_total2,
                'status' => 'unpost',
            ]);

            $cetakpdf = Deposit_driver::where('id', $id)->first();

            return view('admin.inquery_depositdriver.show', compact('cetakpdf'));
        }
    }

    public function show($id)
    {
        $cetakpdf = Deposit_driver::where('id', $id)->first();

        return view('admin.inquery_depositdriver.show', compact('cetakpdf'));
    }

    public function unpostdeposit($id)
    {
        $item = Deposit_driver::find($id);
        if (!$item) {
            return back()->with('error', 'Deposit driver tidak ditemukan');
        }
        $sopir = Karyawan::find($item->karyawan_id);

        if (!$sopir) {
            return back()->with('error', 'Karyawan tidak ditemukan');
        }
        $tabungan = $sopir->tabungan;
        $total = $item->nominal;
        $sub_totals = $tabungan + $total;

        $kasbon = $sopir->kasbon;
        $total = $item->nominal;
        $kasbons = $kasbon - $total;
        $sopir->update([
            'kasbon' => $kasbons,
            // 'deposit' => $deposits,
            'tabungan' => $sub_totals,
        ]);

        $item->update([
            'status' => 'unpost'
        ]);

        return back()->with('success', 'Berhasil. Tabungan karyawan sekarang: Rp ' . number_format($sub_totals, 0, ',', '.'));
    }

    public function postingdeposit($id)
    {
        $item = Deposit_driver::find($id);
        if (!$item) {
            return back()->with('error', 'Deposit driver tidak ditemukan');
        }
        $sopir = Karyawan::find($item->karyawan_id);

        if (!$sopir) {
            return back()->with('error', 'Karyawan tidak ditemukan');
        }

        $kasbon = $sopir->kasbon;
        $totalKasbon = $item->nominal;
        $kasbons = $kasbon + $totalKasbon;
        $tabungan = $sopir->tabungan;
        $total = $item->nominal;
        $sub_totals = $tabungan - $total;

        $sopir->update([
            'kasbon' => $kasbons,
            // 'deposit' => $deposits,
            'tabungan' => $sub_totals
        ]);
        $item->update([
            'status' => 'posting'
        ]);
        return back()->with('success', 'Berhasil. Tabungan karyawan sekarang: Rp ' . number_format($sub_totals, 0, ',', '.'));
    }


    public function hapusdeposit($id)
    {
        $item = Deposit_driver::where('id', $id)->first();
        $item->delete();
        return back()->with('success', 'Berhasil');
    }


    public function destroy($id)
    {
        $item = Pembelian_ban::find($id);
        $item->detail_ban()->delete();
        $item->delete();

        return redirect('admin/inquery_depositdriver')->with('success', 'Berhasil deposit');
    }
}