<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\Stnk;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use App\Models\Jenis_kendaraan;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\LogPerpanjanganstnk;
use App\Http\Controllers\Controller;
use App\Models\Laporanstnk;
use Illuminate\Support\Facades\Validator;

class PerpanjanganstnkController extends Controller
{
    public function index()
    {
        if (auth()->check() && auth()->user()->menu['perpanjangan stnk']) {


            $currentDate = now();
            $twoWeeksLater  = $currentDate->copy()->addWeeks(2); // Menambahkan 1 bulan ke tanggal saat ini
            $oneMonthLater = $currentDate->copy()->addMonth();

            $stnks = Stnk::where('status_stnk', 'konfirmasi')
                ->orWhere('status_stnk', 'belum perpanjang')
                ->orderByRaw("CASE WHEN status_stnk = 'konfirmasi' THEN 1 ELSE 2 END, expired_stnk ASC")
                ->get();

            foreach ($stnks as $stnk) {
                $stnk->update([
                    'status_notif' => true,
                ]);
            }

            // 'status_stnk' => 'belum perpanjang',
            return view('admin.perpanjangan_stnk.index', compact('stnks'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function kendaraan($id)
    {
        $stnk = Kendaraan::where('id', $id)->first();

        return json_decode($stnk);
    }

    public function edit($id)
    {
        if (auth()->check() && auth()->user()->menu['perpanjangan stnk']) {

            $stnk = Stnk::where('id', $id)->first();
            $jenis_kendaraans = Jenis_kendaraan::all();
            $kendaraans = Kendaraan::all();
            return view('admin.perpanjangan_stnk.update', compact('stnk', 'jenis_kendaraans', 'kendaraans'));
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
                'expired_stnk' => 'required',
                'jumlah' => 'required'
            ],
            [
                'expired_stnk' => 'masukkan tanggal expired',
                'jumlah' => 'masukkan jumlah',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $stnk = Stnk::findOrFail($id);

        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');
        Stnk::where('id', $id)->update([
            'expired_stnk' => $request->expired_stnk,
            'jumlah' => $request->jumlah,
            'tanggal' => $format_tanggal,
            'status_stnk' => 'sudah perpanjang',
            'tanggal_awal' => Carbon::now('Asia/Jakarta'),
        ]);

        LogPerpanjanganstnk::create([
            'user_id' => auth()->user()->id,
            'stnk_id' => $stnk->id,
            'tanggal_perpanjang' => $request->expired_stnk,
            'jumlah_pembayaran' => $request->jumlah,
            'stnk_id' => $id,
            'tanggal' => Carbon::now('Asia/Jakarta'), // Menggunakan zona waktu Asia/Jakarta (WIB)
        ]);

        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');

        $tanggal = Carbon::now()->format('Y-m-d');

        $expired_stnk = $stnk->expired_stnk; // Mengambil nilai 'expired_stnk' dari model 'Stnk'
        $jumlah = $stnk->jumlah; // Mengambil nilai 'jumlah' dari model 'Stnk'


        $kode = $this->kode();

        $laporan = Laporanstnk::create([
            'kode_perpanjangan' => $this->kode(),
            'stnk_id' => $stnk->id,
            'expired_stnk' => $request->expired_stnk,
            'jumlah' => $request->jumlah,
            'tanggal' => $format_tanggal,
            'tanggal_awal' => $tanggal,
            'status' => 'posting',
            'status_notif' => false,
        ]);

        $cetakpdf = Stnk::where('id', $id)->first();
        $laporan = Laporanstnk::where('stnk_id', $id)->first();

        return view('admin.perpanjangan_stnk.show', compact('cetakpdf', 'laporan'));

        // return back()->with('success', 'Berhasil memperpanjang No. Stnk');
    }


    public function kode()
    {
        $perpanjangan = Laporanstnk::all();
        if ($perpanjangan->isEmpty()) {
            $num = "000001";
        } else {
            $id = Laporanstnk::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'AR';
        $kode_perpanjangan = $data . $num;
        return $kode_perpanjangan;
    }

    public function show($id)
    {
        if (auth()->check() && auth()->user()->menu['perpanjangan stnk']) {

            $cetakpdf = Stnk::where('id', $id)->first();
            return view('admin.perpanjangan_stnk.show', compact('cetakpdf'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function cetakpdf($id)
    {
        $cetakpdf = Stnk::where('id', $id)->first();
        $laporan = Laporanstnk::where('stnk_id', $id)->first();
        $pdf = PDF::loadView('admin/perpanjangan_stnk.cetak_pdf', compact('cetakpdf', 'laporan'));
        $pdf->setPaper('letter', 'portrait');

        return $pdf->stream('Surat_Perpanjangan_Stnk.pdf');
    }

    public function checkpost($id)
    {
        $ban = Stnk::where('id', $id)->first();

        $ban->update([
            'status_stnk' => 'sudah perpanjang'
        ]);

        return back()->with('success', 'Berhasil');
    }
}