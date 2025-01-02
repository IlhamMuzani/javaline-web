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
use App\Models\Detail_pengeluaran;
use App\Models\Laporankir;
use App\Models\Pengeluaran_kaskecil;
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

        $kategori = $request->kategori;

        if ($kategori == 'Perpanjangan JAVA LINE LOGISTICS') {
            $status = 'posting';
        } else {
            $status = 'unpost';
        }
        $laporan = Laporankir::create([
            'user_id' => auth()->user()->id,
            'kode_perpanjangan' => $this->kode(),
            'nokir_id' => $nokir->id,
            'kategori' => $request->kategori,
            'masa_berlaku' => $request->masa_berlaku,
            'jumlah' => $request->jumlah,
            'tanggal' => $format_tanggal,
            'tanggal_awal' => $tanggal,
            'status' => $status,
            'status_notif' => false,
        ]);

        $kodepengeluaran = $this->kodepengeluaran();

        if ($kategori == 'Perpanjangan DISHUB') {
            $pengeluaran_kaskecil = Pengeluaran_kaskecil::create([
                'laporankir_id' => $laporan->id,
                'user_id' => auth()->user()->id,
                'kode_pengeluaran' => $this->kodepengeluaran(),
                'kendaraan_id' => $nokir->kendaraan_id,
                'keterangan' => 'PERPANJANGAN KIR',
                'grand_total' => str_replace('.', '', $request->jumlah),
                'jam' => $tanggal1->format('H:i:s'),
                'tanggal' => $format_tanggal,
                'tanggal_awal' => $tanggal,
                'qrcode_return' => 'https://javaline.id/pengeluaran_kaskecil/' . $kodepengeluaran,
                'status' => 'unpost',
            ]);

            Detail_pengeluaran::create([
                'laporankir_id' => $laporan->id,
                'barangakun_id' => 14,
                'pengeluaran_kaskecil_id' => $pengeluaran_kaskecil->id,
                'kode_detailakun' => $this->kodeakuns(),
                'kode_akun' => 'KA000014',
                'nama_akun' => 'PAJAK KENDARAAN',
                'keterangan' => 'PERPANJANGAN KIR',
                'nominal' => str_replace('.', '', $request->jumlah),
                'status' => 'unpost',
            ]);
        }

        $cetakpdf = Laporankir::where('id', $laporan->id)->first();

        return view('admin.perpanjangan_kir.show', compact('cetakpdf'));
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
        // Ambil kode memo terakhir yang sesuai format 'FQ%' dan kategori 'Memo Perjalanan'
        $lastBarang = Laporankir::where('kode_perpanjangan', 'like', 'FQ%')
            ->orderBy('id', 'desc')
            ->first();

        // Inisialisasi nomor urut
        $num = 1;

        // Jika ada kode terakhir, proses untuk mendapatkan nomor urut
        if ($lastBarang) {
            $lastCode = $lastBarang->kode_perpanjangan;

            // Pastikan kode terakhir sesuai dengan format FQ[YYYYMMDD][NNNN]B
            if (preg_match('/^FQ(\d{6})(\d{4})B$/', $lastCode, $matches)) {
                $lastDate = $matches[1]; // Bagian tanggal: ymd (contoh: 241125)
                $lastMonth = substr($lastDate, 2, 2); // Ambil bulan dari tanggal (contoh: 11)
                $currentMonth = date('m'); // Bulan saat ini

                if ($lastMonth === $currentMonth) {
                    // Jika bulan sama, tambahkan nomor urut
                    $lastNum = (int)$matches[2]; // Bagian nomor urut (contoh: 0001)
                    $num = $lastNum + 1;
                }
            }
        }

        // Formatkan nomor urut menjadi 4 digit
        $formattedNum = sprintf("%04s", $num);

        // Buat kode baru dengan tambahan huruf B di belakang
        $prefix = 'FQ';
        $kodeMemo = $prefix . date('ymd') . $formattedNum . 'B'; // Format akhir kode memo

        return $kodeMemo;
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

            $cetakpdf = Laporankir::where('id', $id)->first();
            $pdf = PDF::loadView('admin/perpanjangan_kir.cetak_pdf', compact('cetakpdf'));
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