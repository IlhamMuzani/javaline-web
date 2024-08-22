<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Harga_sewa;
use App\Models\Pelanggan;
use App\Models\Rute_perjalanan;
use App\Models\Sewa_kendaraan;
use App\Models\Tarif;
use App\Models\Vendor;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Validator;


class SewakendaraanController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $sewa_kendaraans = Sewa_kendaraan::whereDate('created_at', $today)
            ->orWhere(function ($query) use ($today) {
                $query->where('status', 'unpost')
                    ->whereDate('created_at', '<', $today);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.sewa_kendaraan.index', compact('sewa_kendaraans'));
    }


    public function create()
    {
        $today = Carbon::today();

        $ruteperjalanans = Rute_perjalanan::all();
        $pelanggans = Pelanggan::all();
        $vendors = Vendor::all();
        $harga_sewas = Harga_sewa::all();

        return view('admin.sewa_kendaraan.create', compact('harga_sewas', 'vendors', 'ruteperjalanans', 'pelanggans'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'vendor_id' => 'required',
                // 'rute_perjalanan_id' => 'required',
                'pelanggan_id' => 'required',
                'nama_driver' => 'required',
                'no_pol' => 'required',
            ],
            [
                'vendor_id' => 'pilih rekan',
                // 'rute_perjalanan_id' => 'pilih rute perjalanan',
                'pelanggan_id' => 'pilih pelanggan',
                'nama_driver' => 'masukkan nama sopir',
                'no_pol' => 'masukkan no pol',
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }

        $kode = $this->kode();
        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');
        $tanggal = Carbon::now()->format('Y-m-d');
        $sewa_kendaraan = Sewa_kendaraan::create(array_merge(
            $request->all(),
            [
                'kode_sewa' => $this->kode(),
                'admin' => auth()->user()->karyawan->nama_lengkap,
                'kategori' => $request->kategori,
                'jumlah' => $request->jumlah,
                'satuan' => $request->satuan,
                'harga_sewa_id' => $request->harga_sewa_id,
                'nama_pelanggan' => $request->nama_pelanggan,
                'nama_rute' => $request->nama_tarif,
                'nama_driver' => $request->nama_driver,
                // 'nominal' => str_replace(',', '.', str_replace('.', '', $request->harga_sewa)),

                'pph' => str_replace(',', '.', str_replace('.', '', $request->pph)),
                'harga_tarif' => str_replace(',', '.', str_replace('.', '', $request->harga_tarif)),
                'total_tarif' => str_replace(',', '.', str_replace('.', '', $request->total_tarif)),
                'grand_total' => str_replace(',', '.', str_replace('.', '', $request->sub_total)),
                'sisa' => str_replace(',', '.', str_replace('.', '', $request->sisa)),
                'biaya_tambahan' => str_replace(',', '.', str_replace('.', '', $request->biaya_tambahan)),
                'nominal_potongan' => str_replace(',', '.', str_replace('.', '', $request->nominal_potongan)),
                'hasil_potongan' => str_replace(',', '.', str_replace('.', '', $request->hasil_potongan)),
                'keterangan' => $request->keterangan,

                'qrcode_sewa' => 'https://javaline.id/sewa_kendaraan/' . $kode,
                'tanggal' => $format_tanggal,
                'tanggal_awal' => $tanggal,
                'status' => 'posting',
            ],
        ));
        $cetakpdf = Sewa_kendaraan::where('id', $sewa_kendaraan->id)->first();

        return view('admin.sewa_kendaraan.show', compact('cetakpdf'));
    }

    public function show($id)
    {
        $cetakpdf = Sewa_kendaraan::where('id', $id)->first();

        return view('admin.sewa_kendaraan.show', compact('cetakpdf'));
    }

    public function cetakpdf($id)
    {
        $cetakpdf = Sewa_kendaraan::where('id', $id)->first();
        $pdf = PDF::loadView('admin.sewa_kendaraan.cetak_pdf', compact('cetakpdf'));
        $pdf->setPaper('letter', 'portrait');
        return $pdf->stream('Faktur_sewa_kendaraan.pdf');
    }

    public function kode()
    {
        $lastBarang = Sewa_kendaraan::where('kode_sewa', 'like', 'RK%')->latest()->first();
        $lastMonth = $lastBarang ? date('m', strtotime($lastBarang->created_at)) : null;
        $currentMonth = date('m');
        if (!$lastBarang || $currentMonth != $lastMonth) {
            $num = 1;
        } else {
            $lastCode = $lastBarang->kode_sewa;
            $parts = explode('/', $lastCode);
            $lastNum = end($parts);
            $num = (int) $lastNum + 1;
        }
        $formattedNum = sprintf("%03s", $num);
        $prefix = 'RK';
        $tahun = date('y');
        $tanggal = date('dm');
        $newCode = $prefix . "/" . $tanggal . $tahun . "/" . $formattedNum;
        return $newCode;
    }

    public function hapussewa($id)
    {
        $faktur = Sewa_kendaraan::find($id);
        $faktur->delete();
        return back()->with('success', 'Berhasil menghapus Faktur Sewa');
    }
}