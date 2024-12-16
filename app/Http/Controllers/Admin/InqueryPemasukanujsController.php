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
use App\Models\Uangjaminan;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class InqueryPemasukanujsController extends Controller
{
    public function index(Request $request)
    {
        Uangjaminan::where([
            ['status', 'posting']
        ])->update([
            'status_notif' => true
        ]);

        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $inquery = Uangjaminan::query();

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

        return view('admin.listadministrasi.index', compact('inquery'));
    }


    public function show($id)
    {
        $cetakpdf = Uangjaminan::where('id', $id)->first();

        return view('admin.listadministrasi.show', compact('cetakpdf'));
    }

    public function cetakpdf($id)
    {
        $cetakpdf = Uangjaminan::where('id', $id)->first();

        $pdf = PDF::loadView('admin.listadministrasi.cetak_pdf', compact('cetakpdf'));
        $pdf->setPaper('letter', 'portrait'); // Set the paper size to portrait letter

        return $pdf->stream('Administrasi_UJS.pdf');
    }
}