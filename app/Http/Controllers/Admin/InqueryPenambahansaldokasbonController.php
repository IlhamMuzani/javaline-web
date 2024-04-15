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
use App\Models\Penambahan_saldokasbon;
use App\Models\Total_kasbon;
use Illuminate\Support\Facades\Validator;
use Egulias\EmailValidator\Result\Reason\DetailedReason;
use SebastianBergmann\CodeCoverage\Report\Xml\Totals;

class InqueryPenambahansaldokasbonController extends Controller
{
    public function index(Request $request)
    {
        Penambahan_saldokasbon::where([
            ['status', 'posting']
        ])->update([
            'status_notif' => true
        ]);

        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $inquery = Penambahan_saldokasbon::query();

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

        return view('admin.inquery_penambahansaldokasbon.index', compact('inquery'));
    }

    public function edit($id)
    {
        // if (auth()->check() && auth()->user()->menu['inquery perpanjangan stnk']) {

        $inquery = Penambahan_saldokasbon::where('id', $id)->first();

        return view('admin.inquery_penambahansaldokasbon.update', compact('inquery'));
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

        $penerimaan = Penambahan_saldokasbon::findOrFail($id);

        $subTotalInput = $request->input('sub_total');

        // Hilangkan 'Rp' dan titik
        $cleanedSubTotal = str_replace(['Rp', '.'], '', $subTotalInput);

        // Ubah koma menjadi titik
        $cleanedSubTotal = str_replace(',', '.', $cleanedSubTotal);

        $saldoTerakhir = Total_kasbon::latest()->first();
        $saldo = $saldoTerakhir->id;
        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');

        $tanggal = Carbon::now()->format('Y-m-d');

        $saldoTerakhir = Total_kasbon::latest()->first();
        $saldo = $saldoTerakhir->id;

        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');

        $tanggal = Carbon::now()->format('Y-m-d');
        $penerimaan->update([
                'nominal' => $request->nominal ? str_replace('.', '', $request->nominal) : null,
                'total_kasbon_id' => $saldo,
                'sub_total' => $cleanedSubTotal,
                'status' => 'posting',
        ]);

        $cetakpdf = Penambahan_saldokasbon::where('id', $id)->first();

        return view('admin.inquery_penambahansaldokasbon.show', compact('cetakpdf'));
    }

    public function show($id)
    {
        $cetakpdf = Penambahan_saldokasbon::where('id', $id)->first();

        return view('admin.inquery_penambahansaldokasbon.show', compact('cetakpdf'));
    }

    public function unpostpenambahansaldokasbon($id)
    {
        // Cari penerimaan kas kecil berdasarkan ID
        $item = Penambahan_saldokasbon::findOrFail($id);

        // Ambil nominal dari penerimaan
        $nominal = $item->nominal;

        // Ambil saldo terakhir
        $lastSaldo = Total_kasbon::latest()->first();

        // Periksa apakah saldo terakhir ditemukan
        if (!$lastSaldo) {
            return back()->with('error', 'Saldo tidak ditemukan');
        }
        
        $sisaSaldo = $lastSaldo->sisa_kasbon - $item->nominal;
        Total_kasbon::create([
            'sisa_kasbon' => $sisaSaldo,
        ]);
        
        // Perbarui status penerimaan menjadi "unpost"
        $item->update(['status' => 'unpost']);

        // Redirect kembali dengan pesan sukses
        return back()->with('success', 'Penerimaan berhasil di-"unpost"');
    }

    public function postingpenambahansaldokasbon($id)
    {
        // Cari penerimaan kas kecil berdasarkan ID
        $item = Penambahan_saldokasbon::findOrFail($id);
        // Ambil saldo terakhir
        $lastSaldo = Total_kasbon::latest()->first();

        // Periksa apakah saldo terakhir ditemukan
        if (!$lastSaldo) {
            return back()->with('error', 'Saldo tidak ditemukan');
        }

        $sisaSaldo = $lastSaldo->sisa_kasbon + $item->nominal;
        Total_kasbon::create([
            'sisa_kasbon' => $sisaSaldo,
        ]);
        
        // Perbarui status penerimaan menjadi "unpost"
        $item->update(['status' => 'posting']);

        // Redirect kembali dengan pesan sukses
        return back()->with('success', 'Penerimaan berhasil di-"Posting"');
    }

    public function hapuspenambahansaldokasbon($id)
    {
        $item = Penambahan_saldokasbon::where('id', $id)->first();

        $item->delete();
        return back()->with('success', 'Berhasil');
    }
}