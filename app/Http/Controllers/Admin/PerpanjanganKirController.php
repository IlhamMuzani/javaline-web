<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Nokir;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use App\Models\Jenis_kendaraan;
use App\Models\LogPerpanjangankir;
use App\Http\Controllers\Controller;
use App\Models\Laporankir;
use Illuminate\Support\Facades\Validator;

class PerpanjanganKirController extends Controller
{
    public function index()
    {
        if (auth()->check() && auth()->user()->menu['perpanjangan kir']) {

            $currentDate = now();
            $twoWeeksLater  = $currentDate->copy()->addWeeks(2); // Menambahkan 1 bulan ke tanggal saat ini
            $oneMonthLater = $currentDate->copy()->addMonth();

            $nokirs = Nokir::where('status_kir', 'konfirmasi')
                ->orWhere('status_kir', 'belum perpanjang')
                ->orderByRaw("CASE WHEN status_kir = 'konfirmasi' THEN 1 ELSE 2 END, masa_berlaku ASC")
                ->get();

            foreach ($nokirs as $nokir) {
                $nokir->update([
                    'status_notif' => true,
                ]);
            }

            return view('admin.perpanjangan_kir.index', compact('nokirs'));
        } else {
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function kendaraan($id)
    {
        $nokir = Kendaraan::where('id', $id)->first();

        return json_decode($nokir);
    }

    public function edit($id)
    {
        if (auth()->check() && auth()->user()->menu['perpanjangan kir']) {

            $nokir = Nokir::where('id', $id)->first();
            $jenis_kendaraans = Jenis_kendaraan::all();
            $kendaraans = Kendaraan::all();
            return view('admin.perpanjangan_kir.update', compact('nokir', 'jenis_kendaraans', 'kendaraans'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'kategori' => 'required',
                'masa_berlaku' => 'required',
                'jumlah' => 'required'
            ],
            [
                'kategori' => 'pilih kategori perpanjangan',
                'masa_berlaku' => 'masukkan masa berlaku kir',
                'jumlah' => 'masukkan jumlah',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $nokir = Nokir::findOrFail($id);

        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');
        Nokir::where('id', $id)->update([
            'kategori' => $request->kategori,
            'masa_berlaku' => $request->masa_berlaku,
            'jumlah' => $request->jumlah,
            'tanggal' => $format_tanggal,
            'status_kir' => 'sudah perpanjang',
            'tanggal_awal' => Carbon::now('Asia/Jakarta'),
        ]);

        LogPerpanjangankir::create([
            'user_id' => auth()->user()->id,
            'nokir_id' => $nokir->id,
            'tanggal_perpanjang' => $request->masa_berlaku,
            'jumlah_pembayaran' => $request->jumlah,
            'nokir_id' => $id,
            'tanggal' => Carbon::now('Asia/Jakarta'), // Menggunakan zona waktu Asia/Jakarta (WIB)
        ]);


        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');

        $tanggal = Carbon::now()->format('Y-m-d');

        $masa_berlaku = $nokir->masa_berlaku; // Mengambil nilai 'expired_stnk' dari model 'Stnk'
        $jumlah = $nokir->jumlah; // Mengambil nilai 'jumlah' dari model 'Stnk'


        $kode = $this->kode();

        $laporan = Laporankir::create([
            'kode_perpanjangan' => $this->kode(),
            'nokir_id' => $nokir->id,
            'kategori' => $request->kategori,
            'masa_berlaku' => $request->masa_berlaku,
            'jumlah' => $request->jumlah,
            'tanggal' => $format_tanggal,
            'tanggal_awal' => $tanggal,
            'status' => 'posting',
            'status_notif' => false,
        ]);


        $cetakpdf = Nokir::where('id', $id)->first();
        $laporan = Laporankir::where('nokir_id', $id)->first();

        return view('admin.perpanjangan_kir.show', compact('cetakpdf','laporan'));
    }


    public function kode()
    {
        $perpanjangan = Laporankir::all();
        if ($perpanjangan->isEmpty()) {
            $num = "000001";
        } else {
            $id = Laporankir::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'AS';
        $kode_perpanjangan = $data . $num;
        return $kode_perpanjangan;
    }


    public function show($id)
    {
        if (auth()->check() && auth()->user()->menu['perpanjangan kir']) {

            $cetakpdf = Nokir::where('id', $id)->first();
            return view('admin.perpanjangan_kir.show', compact('cetakpdf'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function cetakpdf($id)
    {
        if (auth()->check() && auth()->user()->menu['perpanjangan kir']) {

            $cetakpdf = Nokir::where('id', $id)->first();
            $laporan = Laporankir::where('nokir_id', $id)->first();
            $pdf = PDF::loadView('admin/perpanjangan_kir.cetak_pdf', compact('cetakpdf', 'laporan'));
            $pdf->setPaper('letter', 'portrait');

            return $pdf->stream('Surat_Perpanjangan_Stnk.pdf');
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function checkpostkir($id)
    {
        $ban = Nokir::where('id', $id)->first();

        $ban->update([
            'status_kir' => 'sudah perpanjang'
        ]);

        return back()->with('success', 'Berhasil');
    }
}