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
use App\Models\Detail_pengeluaran;
use App\Models\Laporanstnk;
use App\Models\Pengeluaran_kaskecil;
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
            'user_id' => auth()->user()->id,
            'kode_perpanjangan' => $this->kode(),
            'stnk_id' => $stnk->id,
            'kendaraan_id' => $stnk->kendaraan_id,
            'expired_stnk' => $request->expired_stnk,
            'jumlah' => $request->jumlah,
            'tanggal' => $format_tanggal,
            'tanggal_awal' => $tanggal,
            'status_notif' => false,
            'status' => 'unpost',

        ]);

        $kodepengeluaran = $this->kodepengeluaran();


        $pengeluaran_kaskecil = Pengeluaran_kaskecil::create([
            'laporanstnk_id' => $laporan->id,
            'user_id' => auth()->user()->id,
            'kode_pengeluaran' => $this->kodepengeluaran(),
            'kendaraan_id' => $stnk->kendaraan_id,
            'keterangan' => 'PERPANJANGAN STNK',
            'grand_total' => str_replace('.', '', $request->jumlah),
            'jam' => $tanggal1->format('H:i:s'),
            'tanggal' => $format_tanggal,
            'tanggal_awal' => $tanggal,
            'qrcode_return' => 'https://javaline.id/pengeluaran_kaskecil/' . $kodepengeluaran,
            'status' => 'unpost',
        ]);

        Detail_pengeluaran::create([
            'laporanstnk_id' => $laporan->id,
            'barangakun_id' => 14,
            'pengeluaran_kaskecil_id' => $pengeluaran_kaskecil->id,
            'kode_detailakun' => $this->kodeakuns(),
            'kode_akun' => 'KA000014',
            'nama_akun' => 'PAJAK KENDARAAN',
            'keterangan' => 'PERPANJANGAN STNK',
            'nominal' => str_replace('.', '', $request->jumlah),
            'status' => 'unpost',
        ]);

        $cetakpdf = Stnk::where('id', $id)->first();
        $laporan = Laporanstnk::where('stnk_id', $id)->first();

        return view('admin.perpanjangan_stnk.show', compact('cetakpdf', 'laporan'));

        // return back()->with('success', 'Berhasil memperpanjang No. Stnk');
    }


    public function kodeakuns()
    {
        // Mengambil kode terbaru dari database dengan awalan 'MP'
        $lastBarang = Detail_pengeluaran::where('kode_detailakun', 'like', 'KKA%')->latest()->first();

        // Mendapatkan bulan dari tanggal kode terakhir
        $lastMonth = $lastBarang ? date('m', strtotime($lastBarang->created_at)) : null;
        $currentMonth = date('m');

        // Jika tidak ada kode sebelumnya atau bulan saat ini berbeda dari bulan kode terakhir
        if (!$lastBarang || $currentMonth != $lastMonth) {
            $num = 1; // Mulai dari 1 jika bulan berbeda
        } else {
            // Jika ada kode sebelumnya, ambil nomor terakhir
            $lastCode = $lastBarang->kode_detailakun;

            // Pisahkan kode menjadi bagian-bagian terpisah
            $parts = explode('/', $lastCode);
            $lastNum = end($parts); // Ambil bagian terakhir sebagai nomor terakhir
            $num = (int) $lastNum + 1; // Tambahkan 1 ke nomor terakhir
        }

        // Format nomor dengan leading zeros sebanyak 6 digit
        $formattedNum = sprintf("%06s", $num);

        // Awalan untuk kode baru
        $prefix = 'KKA';
        $tahun = date('y');
        $tanggal = date('dm');

        // Buat kode baru dengan menggabungkan awalan, tanggal, tahun, dan nomor yang diformat
        $newCode = $prefix . "/" . $tanggal . $tahun . "/" . $formattedNum;

        // Kembalikan kode
        return $newCode;
    }
    public function kodepengeluaran()
    {
        // Mengambil kode terbaru dari database dengan awalan 'MP'
        $lastBarang = Pengeluaran_kaskecil::where('kode_pengeluaran', 'like', 'KK%')->latest()->first();

        // Mendapatkan bulan dari tanggal kode terakhir
        $lastMonth = $lastBarang ? date('m', strtotime($lastBarang->created_at)) : null;
        $currentMonth = date('m');

        // Jika tidak ada kode sebelumnya atau bulan saat ini berbeda dari bulan kode terakhir
        if (!$lastBarang || $currentMonth != $lastMonth) {
            $num = 1; // Mulai dari 1 jika bulan berbeda
        } else {
            // Jika ada kode sebelumnya, ambil nomor terakhir
            $lastCode = $lastBarang->kode_pengeluaran;

            // Pisahkan kode menjadi bagian-bagian terpisah
            $parts = explode('/', $lastCode);
            $lastNum = end($parts); // Ambil bagian terakhir sebagai nomor terakhir
            $num = (int) $lastNum + 1; // Tambahkan 1 ke nomor terakhir
        }

        // Format nomor dengan leading zeros sebanyak 6 digit
        $formattedNum = sprintf("%06s", $num);

        // Awalan untuk kode baru
        $prefix = 'KK';
        $tahun = date('y');
        $tanggal = date('dm');

        // Buat kode baru dengan menggabungkan awalan, tanggal, tahun, dan nomor yang diformat
        $newCode = $prefix . "/" . $tanggal . $tahun . "/" . $formattedNum;

        // Kembalikan kode
        return $newCode;
    }

    public function kode()
    {
        $lastBarang = Laporanstnk::latest()->first();
        if (!$lastBarang) {
            $num = 1;
        } else {
            $lastCode = $lastBarang->kode_perpanjangan;
            $num = (int) substr($lastCode, strlen('AR')) + 1;
        }
        $formattedNum = sprintf("%06s", $num);
        $prefix = 'AR';
        $newCode = $prefix . $formattedNum;
        return $newCode;
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
