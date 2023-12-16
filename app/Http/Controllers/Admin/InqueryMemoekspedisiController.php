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

class InqueryMemoekspedisiController extends Controller
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

        $inquery->where('kategori', 'Memo Perjalanan');
        $inquery->orderBy('id', 'DESC');
        $inquery = $inquery->get();

        // Collect the ids of Memo_ekspedisi
        $memoIds = $inquery->pluck('id');

        // Query the associated Detail_memo using the collected ids
        $details = Detail_memo::whereIn('memo_ekspedisi_id', $memoIds)->first();

        return view('admin.inquery_memoekspedisi.index', compact('inquery', 'details'));
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
            $memos = Memo_ekspedisi::all();
            $memotambahans = Memotambahan::where('id', $inquery->memotambahan_id)->first();
            $detailstambahan = Detail_memotambahan::where('memotambahan_id', $memotambahans->id)->get();

            return view('admin.inquery_memoekspedisi.update', compact(
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
            return view('admin.inquery_memoekspedisi.update', compact(
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

        $kategori = $request->kategori;

        $commonData = [
            'kategori' => $kategori,
            // Add other common data fields here
        ];

        // Common validation logic
        $validasi_pelanggan = Validator::make(
            $request->all(),
            [
                'kategori' => 'required',
                'kendaraan_id' => 'required',
                'user_id' => 'required',
                'rute_perjalanan_id' => 'required',
                'sub_total' => 'required'
            ],
            [
                'kategori.required' => 'Pilih kategori',
                'kendaraan_id.required' => 'Pilih no kabin',
                'user_id.required' => 'Pilih driver',
                'rute_perjalanan_id.required' => 'Pilih rute perjalanan',
                'sub_total.required' => 'Masukkan total harga',

            ]
        );

        $error_pelanggans = array();

        if ($validasi_pelanggan->fails()) {
            array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
        }

        $error_pesanans = array();
        $data_pembelians = collect();
        $data_pembelians3 = collect();

        if ($request->has('biaya_id') || $request->has('kode_biaya') || $request->has('nama_biaya') || $request->has('nominal')) {
            for ($i = 0; $i < count($request->biaya_id); $i++) {
                // Check if either 'keterangan_tambahan' or 'nominal_tambahan' has input
                if (empty($request->biaya_id[$i]) && empty($request->kode_biaya[$i]) && empty($request->nama_biaya[$i]) && empty($request->nominal[$i])) {
                    continue; // Skip validation if both are empty
                }

                $validasi_produk = Validator::make($request->all(), [
                    'biaya_id.' . $i => 'required',
                    'kode_biaya.' . $i => 'required',
                    'nama_biaya.' . $i => 'required',
                    'nominal.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Biaya tambahan nomor " . ($i + 1) . " belum dilengkapi!");
                }

                $biaya_id = $request->biaya_id[$i] ?? '';
                $kode_biaya = $request->kode_biaya[$i] ?? '';
                $nama_biaya = $request->nama_biaya[$i] ?? '';
                $nominal = $request->nominal[$i] ?? '';

                $data_pembelians->push([
                    'biaya_id' => $biaya_id,
                    'kode_biaya' => $kode_biaya,
                    'nama_biaya' => $nama_biaya,
                    'nominal' => $nominal,
                ]);
            }
        }

        if ($request->has('potongan_id') || $request->has('kode_potongan') || $request->has('keterangan_potongan') || $request->has('nominal_potongan')) {
            for ($i = 0; $i < count($request->potongan_id); $i++) {
                // Check if either 'keterangan_tambahan' or 'nominal_tambahan' has input
                if (empty($request->potongan_id[$i]) && empty($request->kode_potongan[$i]) && empty($request->keterangan_potongan[$i]) && empty($request->nominal_potongan[$i])) {
                    continue; // Skip validation if both are empty
                }

                $validasi_produk = Validator::make($request->all(), [
                    'potongan_id.' . $i => 'required',
                    'kode_potongan.' . $i => 'required',
                    'keterangan_potongan.' . $i => 'required',
                    'nominal_potongan.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Potongan memo nomor " . ($i + 1) . " belum dilengkapi!");
                }

                $potongan_id = $request->potongan_id[$i] ?? '';
                $kode_potongan = $request->kode_potongan[$i] ?? '';
                $keterangan_potongan = $request->keterangan_potongan[$i] ?? '';
                $nominal_potongan = $request->nominal_potongan[$i] ?? '';

                $data_pembelians3->push([
                    'potongan_id' => $potongan_id,
                    'kode_potongan' => $kode_potongan,
                    'keterangan_potongan' => $keterangan_potongan,
                    'nominal_potongan' => $nominal_potongan,
                ]);
            }
        }

        if ($error_pelanggans || $error_pesanans) {
            return back()
                ->withInput()
                ->with('error_pelanggans', $error_pelanggans)
                ->with('error_pesanans', $error_pesanans)
                ->with('data_pembelians', $data_pembelians)
                ->with('data_pembelians3', $data_pembelians3);
        }

        $kode = $this->kode();
        // tgl indo
        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');

        $tanggal = Carbon::now()->format('Y-m-d');
        $cetakpdf = Memo_ekspedisi::create(array_merge(
            $request->all(),
            [
                'kategori' => $request->kategori,
                'kendaraan_id' => $request->kendaraan_id,
                'no_kabin' => $request->no_kabin,
                'golongan' => $request->golongan,
                'km_awal' => $request->km_awal,
                'user_id' => $request->user_id,
                'kode_driver' => $request->kode_driver,
                'nam_driver' => $request->nama_driver,
                'telp' => $request->telp,
                'saldo_deposit' => $request->saldo_deposit,
                'rute_perjalanan_id' => $request->rute_perjalanan_id,
                'kode_rute' => $request->kode_rute,
                'nama_rute' => $request->nama_rute,
                'uang_jalan' => $request->uang_jalan,
                'uang_jaminan' => $request->uang_jaminan,
                'biaya_tambahan' => $request->biaya_tambahan,
                'deposit_driver' => $request->deposit_driver,
                'keterangan' => $request->keterangan,
                'sisa_saldo' => $request->sisa_saldo,
                'sub_total' => $request->sub_total,
                // 'harga' => $request->harga,
                'kode_memo' => $this->kode(),
                'qrcode_memo' => 'https:///tigerload.id/memo_ekspedisi/' . $kode,
                'tanggal' => $format_tanggal,
                'tanggal_awal' => $tanggal,
                // 'status' => 'posting',
            ]
        ));

        $transaksi_id = $cetakpdf->id;

        if ($cetakpdf) {

            foreach ($data_pembelians as $data_pesanan) {
                Detail_memo::create([
                    'memo_ekspedisi_id' => $cetakpdf->id,
                    'biaya_id' => $data_pesanan['biaya_id'],
                    'kode_biaya' => $data_pesanan['kode_biaya'],
                    'nama_biaya' => $data_pesanan['nama_biaya'],
                    'nominal' => $data_pesanan['nominal'],
                ]);
            }
        }

        $detail_memo = Detail_memo::where('memo_ekspedisi_id', $cetakpdf->id)->get();

        return view('admin.memo_ekspedisi.show', compact('cetakpdf', 'detail_memo'));
    }

    public function show($id)
    {
        $inquery = Memo_ekspedisi::where('id', $id)->first();
        if ($inquery->kategori == "Memo Tambahan") {
            $cetakpdf = Memo_ekspedisi::where('id', $id)->first();
            $memotambahans = Memotambahan::where('id', $cetakpdf->memotambahan_id)->first();
            $detail_memo = Detail_memotambahan::where('memotambahan_id', $memotambahans->id)->get();
            return view('admin.inquery_memoekspedisi.show', compact('cetakpdf', 'detail_memo'));
        } else {
            $cetakpdf = Memo_ekspedisi::where('id', $id)->first();
            // $memotambahans = Memotambahan::where('memo_id', $id)->first();
            $detail_memo = Detail_memo::where('memo_ekspedisi_id', $cetakpdf->id)->get();
            return view('admin.inquery_memoekspedisi.show', compact('cetakpdf', 'detail_memo'));
        }
    }

    public function unpostmemo($id)
    {
        $ban = Memo_ekspedisi::where('id', $id)->first();

        $ban->update([
            'status' => 'unpost'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function postingmemo($id)
    {
        $ban = Memo_ekspedisi::where('id', $id)->first();

        $ban->update([
            'status' => 'posting'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function hapusmemo($id)
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
        return redirect('admin/inquery_memoekspedisi')->with('success', 'Berhasil memperbarui memo ekspedisi');
    }
}