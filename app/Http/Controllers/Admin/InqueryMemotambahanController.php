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
use App\Models\Biaya_tambahan;
use App\Models\Detail_memo;
use App\Models\Detail_memotambahan;
use App\Models\Kendaraan;
use App\Models\Memo_ekspedisi;
use App\Models\Memotambahan;
use App\Models\Pelanggan;
use App\Models\Penerimaan_kaskecil;
use App\Models\Potongan_memo;
use App\Models\Rute_perjalanan;
use App\Models\Saldo;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Egulias\EmailValidator\Result\Reason\DetailedReason;

class InqueryMemotambahanController extends Controller
{
    public function index(Request $request)
    {
        Memo_ekspedisi::where([
            ['status', 'posting']
        ])->update([
            'status_notif' => true
        ]);

        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $inquery = Memo_ekspedisi::query();

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

        $inquery->where('kategori', 'Memo Tambahan');
        $inquery->orderBy('id', 'DESC');
        $inquery = $inquery->get();

        // Collect the ids of Memo_ekspedisi
        $memoIds = $inquery->pluck('id');

        // Query the associated Detail_memo using the collected ids
        $details = Detail_memo::whereIn('memo_ekspedisi_id', $memoIds)->first();

        return view('admin.inquery_memotambahan.index', compact('inquery', 'details'));
    }



    public function edit($id)
    {
        // if (auth()->check() && auth()->user()->menu['inquery perpanjangan stnk']) {

        $inquery = Memo_ekspedisi::where('id', $id)->first();
        if ($inquery->kategori == "Memo Tambahan") {
            $details = Detail_memo::where('memo_ekspedisi_id', $id)->get();
            $kendaraans = Kendaraan::all();
            $drivers = User::whereHas('karyawan', function ($query) {
                $query->where('departemen_id', '2');
            })->get();
            $ruteperjalanans = Rute_perjalanan::all();
            $biayatambahan = Biaya_tambahan::all();
            $pelanggans = Pelanggan::all();
            $saldoTerakhir = Saldo::latest()->first();
            $potonganmemos = Potongan_memo::all();
            $memos = Memo_ekspedisi::where('kategori', 'Memo Perjalanan')->get();
            $memotambahans = Memotambahan::where('id', $inquery->memotambahan_id)->first();
            $detailstambahan = Detail_memotambahan::where('memotambahan_id', $memotambahans->id)->get();

            return view('admin.inquery_memotambahan.update', compact(
                'details',
                'detailstambahan',
                'inquery',
                'pelanggans',
                'kendaraans',
                'drivers',
                'ruteperjalanans',
                'biayatambahan',
                'potonganmemos',
                'memos',
                'saldoTerakhir'
            ));
        } else {
            $details = Detail_memo::where('memo_ekspedisi_id', $id)->get();
            $kendaraans = Kendaraan::all();
            $drivers = User::whereHas('karyawan', function ($query) {
                $query->where('departemen_id', '2');
            })->get();
            $ruteperjalanans = Rute_perjalanan::all();
            $biayatambahan = Biaya_tambahan::all();
            $pelanggans = Pelanggan::all();
            $saldoTerakhir = Saldo::latest()->first();
            $potonganmemos = Potongan_memo::all();
            $memos = Memo_ekspedisi::all();
            return view('admin.inquery_memotambahan.update', compact(
                'details',
                'inquery',
                'pelanggans',
                'kendaraans',
                'drivers',
                'ruteperjalanans',
                'biayatambahan',
                'potonganmemos',
                'memos',
                'saldoTerakhir'
            ));
        }




        // } else {
        //     // tidak memiliki akses
        //     return back()->with('error', array('Anda tidak memiliki akses'));
        // }
    }

    public function update(Request $request, $id)
    {

        $validasi_pelanggan = Validator::make(
            $request->all(),
            [
                'memo_id' => 'required',
            ],
            [
                'memo_id.required' => 'Pilih memo',
            ]
        );

        $error_pelanggans = array();

        if ($validasi_pelanggan->fails()) {
            array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
        }

        $error_pesanans = array();
        $data_pembelians4 = collect();

        if ($request->has('keterangan_tambahan')) {
            for ($i = 0; $i < count($request->keterangan_tambahan); $i++) {
                $validasi_produk = Validator::make($request->all(), [
                    'keterangan_tambahan.' . $i => 'required',
                    'nominal_tambahan.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Memo tambahan nomor " . $i + 1 . " belum dilengkapi!");
                }

                $keterangan_tambahan = is_null($request->keterangan_tambahan[$i]) ? '' : $request->keterangan_tambahan[$i];
                $nominal_tambahan = is_null($request->nominal_tambahan[$i]) ? '' : $request->nominal_tambahan[$i];

                $data_pembelians4->push([
                    'detail_id' => $request->detail_idstambahan[$i] ?? null,
                    'keterangan_tambahan' => $keterangan_tambahan,
                    'nominal_tambahan' => $nominal_tambahan
                ]);
            }
        } else {
        }


        if ($error_pelanggans || $error_pesanans) {
            return back()
                ->withInput()
                ->with('error_pelanggans', $error_pelanggans)
                ->with('error_pesanans', $error_pesanans)
                ->with('data_pembelians4', $data_pembelians4);
        }

        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');
        $cetakpdf = Memo_ekspedisi::findOrFail($id);
        $memotambahan = Memotambahan::findOrFail($cetakpdf->memotambahan_id);

        $tanggal = Carbon::now()->format('Y-m-d');
        $memotambahan->update([
            'grand_total' => str_replace('.', '', $request->grand_total),
        ]);

        $transaksi_id = $memotambahan->id;
        $detailIds = $request->input('detail_idstambahan');

        foreach ($data_pembelians4 as $data_pesanan) {
            $detailId = $data_pesanan['detail_id'];

            if ($detailId) {
                Detail_memotambahan::where('id', $detailId)->update([
                    'memotambahan_id' => $memotambahan->id,
                    'keterangan_tambahan' => $data_pesanan['keterangan_tambahan'],
                    'nominal_tambahan' => $data_pesanan['nominal_tambahan'],
                ]);
            } else {
                $existingDetail = Detail_memotambahan::where([
                    'memotambahan_id' => $memotambahan->id,
                    'keterangan_tambahan' => $data_pesanan['keterangan_tambahan'],
                ])->first();

                if (!$existingDetail) {
                    Detail_memotambahan::create([
                        'memotambahan_id' => $memotambahan->id,
                        'keterangan_tambahan' => $data_pesanan['keterangan_tambahan'],
                        'nominal_tambahan' => $data_pesanan['nominal_tambahan'],
                    ]);
                }
            }
        }
        // Fetch Memo_ekspedisi and its details after the updates
        $cetakpdf = Memo_ekspedisi::find($id);
        $memotambahan = Memotambahan::where('id', $cetakpdf->memotambahan_id)->first();
        $detail_memo = Detail_memotambahan::where('memotambahan_id', $memotambahan->id)->get();

        return view('admin.inquery_memotambahan.show', compact('cetakpdf', 'detail_memo', 'memotambahan'));
    }

    public function show($id)
    {
        $inquery = Memo_ekspedisi::where('id', $id)->first();
        if ($inquery->kategori == "Memo Tambahan") {
            $cetakpdf = Memo_ekspedisi::where('id', $id)->first();
            $memotambahans = Memotambahan::where('id', $cetakpdf->memotambahan_id)->first();
            $detail_memo = Detail_memotambahan::where('memotambahan_id', $memotambahans->id)->get();
            return view('admin.inquery_memotambahan.show', compact('cetakpdf', 'detail_memo'));
        } else {
            $cetakpdf = Memo_ekspedisi::where('id', $id)->first();
            // $memotambahans = Memotambahan::where('memo_id', $id)->first();
            $detail_memo = Detail_memo::where('memo_ekspedisi_id', $cetakpdf->id)->get();
            return view('admin.inquery_memotambahan.show', compact('cetakpdf', 'detail_memo'));
        }
    }

    public function unpostmemotambahan($id)
    {
        $ban = Memo_ekspedisi::where('id', $id)->first();

        $ban->update([
            'status' => 'unpost'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function postingmemotambahan($id)
    {
        $ban = Memo_ekspedisi::where('id', $id)->first();

        $ban->update([
            'status' => 'posting'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function hapusmemotambahan($id)
    {
        $ban = Memo_ekspedisi::where('id', $id)->first();

        $ban->delete();
        return back()->with('success', 'Berhasil');
    }

    public function destroy($id)
    {
        $ban = Memo_ekspedisi::find($id);
        // $ban->detail_memo()->delete();
        $ban->delete();
        return redirect('admin/inquery_memotambahan')->with('success', 'Berhasil memperbarui memo tambahan');
    }
}