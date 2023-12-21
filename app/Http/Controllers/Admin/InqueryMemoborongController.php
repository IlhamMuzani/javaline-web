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
use App\Models\Karyawan;
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

class InqueryMemoborongController extends Controller
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

        $inquery->where('kategori', 'Memo Borong');
        $inquery->orderBy('id', 'DESC');
        $inquery = $inquery->get();

        // Collect the ids of Memo_ekspedisi
        $memoIds = $inquery->pluck('id');

        // Query the associated Detail_memo using the collected ids
        $details = Detail_memo::whereIn('memo_ekspedisi_id', $memoIds)->first();

        return view('admin.inquery_memoborong.index', compact('inquery', 'details'));
    }



    public function edit($id)
    {
        // if (auth()->check() && auth()->user()->menu['inquery perpanjangan stnk']) {

        $inquery = Memo_ekspedisi::where('id', $id)->first();
        $details = Detail_memo::where('memo_ekspedisi_id', $id)->get();
        $kendaraans = Kendaraan::all();
        $drivers = User::whereHas('karyawan', function ($query) {
            $query->where('departemen_id', '2');
        })->get();
        $ruteperjalanans = Rute_perjalanan::all();
        $saldoTerakhir = Saldo::latest()->first();
        $memos = Memo_ekspedisi::all();
        return view('admin.inquery_memoborong.update', compact(
            'details',
            'inquery',
            'kendaraans',
            'drivers',
            'ruteperjalanans',
            'memos',
            'saldoTerakhir'
        ));

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
                'kendaraan_id' => 'required',
                'user_id' => 'required',
                'sub_total' => 'required',
                'jumlah' => 'required',
                'satuan' => 'required',
            ],
            [
                'kategori.required' => 'Pilih kategori',
                'kendaraan_id.required' => 'Pilih no kabin',
                'user_id.required' => 'Pilih driver',
                'sub_total.required' => 'Masukkan total harga',
                'jumlah.required' => 'Masukkan quantity',
                'satuan.required' => 'Pilih satuan',
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }

        // tgl indo
        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');
        $cetakpdf = Memo_ekspedisi::findOrFail($id);

        $tanggal = Carbon::now()->format('Y-m-d');
        $cetakpdf->update(
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
                'pelanggan_id' => $request->pelanggan_id,
                'kode_pelanggan' => $request->kode_pelanggan,
                'nama_pelanggan' => $request->nama_pelanggan,
                'alamat_pelanggan' => $request->alamat_pelanggan,
                'telp_pelanggan' => $request->telp_pelanggan,
                'saldo_deposit' => str_replace('.', '', $request->saldo_deposit),
                'biaya_tambahan' => str_replace('.', '', $request->biaya_tambahan),
                'deposit_driver' => str_replace('.', '', $request->depositsopir),
                'total_borongs' => str_replace('.', '', $request->total_borongs),
                'pphs' => str_replace('.', '', $request->pphs),
                'uang_jaminans' => str_replace('.', '', $request->uang_jaminans),
                'uang_jaminan' => str_replace('.', '', $request->uang_jaminans),
                'deposit_drivers' => str_replace('.', '', $request->depositsopir),
                'totals' => str_replace('.', '', $request->totals),
                'sub_total' => str_replace('.', '', $request->sub_total),
                'keterangan' => $request->keterangan,
                // 'sisa_saldo' => $request->sisa_saldo,
                'rute_perjalanan_id' => $request->rute_id,
                'kode_rute' => $request->kode_rutes,
                'nama_rute' => $request->nama_rutes,
                'harga_rute' => str_replace('.', ' ', $request->harga_rute),
                'jumlah' => $request->jumlah,
                'satuan' => $request->satuan,
                'totalrute' => str_replace('.', ' ', $request->totalrute),
            ]
        );

        return view('admin.inquery_memoborong.show', compact('cetakpdf'));
    }

    public function show($id)
    {
        $cetakpdf = Memo_ekspedisi::where('id', $id)->first();

        return view('admin.inquery_memoborong.show', compact('cetakpdf'));
    }

    public function unpostmemoborong($id)
    {
        $item = Memo_ekspedisi::where('id', $id)->first();
        if (!$item) {
            return back()->with('error', 'Memo tidak ditemukan');
        }
        $uangJalan = $item->totalrute;
        $lastSaldo = Saldo::latest()->first();
        if (!$lastSaldo) {
            return back()->with('error', 'Saldo tidak ditemukan');
        }
        $sisaSaldo = $lastSaldo->sisa_saldo + $uangJalan;
        Saldo::create([
            'sisa_saldo' => $sisaSaldo,
        ]);
        $item = Memo_ekspedisi::where('id', $id)->first();
        if (!$item) {
            return back()->with('error', 'Memo tidak ditemukan');
        }
        $user = User::where('id', $item->user_id)->first();
        if (!$user) {
            return back()->with('error', 'User tidak ditemukan');
        }
        $karyawan = Karyawan::where('id', $user->id)->first();
        if (!$karyawan) {
            return back()->with('error', 'Karyawan tidak ditemukan');
        }
        $tabungans = $karyawan->tabungan;
        $karyawan->update([
            'tabungan' => $tabungans - $item->deposit_driver
        ]);
        $item->update([
            'status' => 'unpost'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function postingmemoborong($id)
    {
        $item = Memo_ekspedisi::where('id', $id)->first();
        if (!$item) {
            return back()->with('error', 'Memo tidak ditemukan');
        }
        $uangJalan = $item->totalrute;
        $lastSaldo = Saldo::latest()->first();
        if (!$lastSaldo) {
            return back()->with('error', 'Saldo tidak ditemukan');
        }
        $sisaSaldo = $lastSaldo->sisa_saldo - $uangJalan;
        Saldo::create([
            'sisa_saldo' => $sisaSaldo,
        ]);
        if (!$item) {
            return back()->with('error', 'Memo tidak ditemukan');
        }
        $user = User::where('id', $item->user_id)->first();
        if (!$user) {
            return back()->with('error', 'User tidak ditemukan');
        }
        $karyawan = Karyawan::where('id', $user->id)->first();
        if (!$karyawan) {
            return back()->with('error', 'Karyawan tidak ditemukan');
        }
        $tabungans = $karyawan->tabungan;
        $karyawan->update([
            'tabungan' => $tabungans + $item->deposit_driver
        ]);
        // Update the Memo_ekspedisi status
        $item->update([
            'status' => 'posting'
        ]);
        return back()->with('success', 'Berhasil');
    }

    public function hapusmemoborong($id)
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
        return redirect('admin/inquery_memoborong')->with('success', 'Berhasil memperbarui memo borong');
    }
}