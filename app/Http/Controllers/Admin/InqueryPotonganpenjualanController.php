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
use App\Models\Potongan_penjualan;
use App\Models\Saldo;
use Illuminate\Support\Facades\Validator;
use Egulias\EmailValidator\Result\Reason\DetailedReason;

class InqueryPotonganpenjualanController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $inquery = Potongan_penjualan::query();

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

        return view('admin.inquery_potonganpenjualan.index', compact('inquery'));
    }

    public function edit($id)
    {
        // if (auth()->check() && auth()->user()->menu['inquery perpanjangan stnk']) {

        $inquery = Potongan_penjualan::where('id', $id)->first();

        return view('admin.inquery_potonganpenjualan.update', compact('inquery'));
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
                'grand_total' => 'required',
                // 'keterangan' => 'required', // Menambahkan aturan unique
            ],
            [
                'grand_total.required' => 'Masukkan nominal',
                // 'nominal.numeric' => 'Nominal harus berupa angka',
                // 'keterangan.required' => 'Masukkan keterangan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $penerimaan = Potongan_penjualan::findOrFail($id);
        $penerimaan->update([
            'grand_total' => $request->grand_total ? str_replace('.', '', $request->grand_total) : null,
            'keterangan' => $request->keterangan,
        ]);

        $cetakpdf = Potongan_penjualan::where('id', $id)->first();

        return view('admin.inquery_potonganpenjualan.show', compact('cetakpdf'));
    }

    public function show($id)
    {
        $cetakpdf = Potongan_penjualan::where('id', $id)->first();

        return view('admin.inquery_potonganpenjualan.show', compact('cetakpdf'));
    }

    public function unpostpotongan($id)
    {
        $item = Potongan_penjualan::findOrFail($id);
        $item->update(['status' => 'unpost']);

        // Redirect kembali dengan pesan sukses
        return back()->with('success', 'Potongan Penjualan berhasil di-"unpost"');
    }

    public function postingpotongan($id)
    {
        $item = Potongan_penjualan::findOrFail($id);
        $item->update(['status' => 'posting']);

        // Redirect kembali dengan pesan sukses
        return back()->with('success', 'Penerimaan berhasil di-"Posting"');
    }

    public function hapuspotongan($id)
    {
        $item = Potongan_penjualan::where('id', $id)->first();

        $item->delete();
        return back()->with('success', 'Berhasil');
    }
}