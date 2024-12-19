<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Deposit_driver;
use App\Models\Detail_pengeluaran;
use App\Models\Karyawan;
use App\Models\Notabon_ujs;
use App\Models\Pengeluaran_kaskecil;
use App\Models\Saldo;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class NotabonController extends Controller
{

    public function index()
    {
        $today = Carbon::today();

        $inquery = Notabon_ujs::whereDate('created_at', $today)
            ->orWhere(function ($query) use ($today) {
                $query->where('status', 'unpost')
                    ->whereDate('created_at', '<', $today);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $saldoTerakhir = Saldo::latest()->first();

        return view('admin.nota_bon.index', compact('inquery', 'saldoTerakhir'));
    }


    public function create()
    {
        $SopirAll = Karyawan::where('departemen_id', '2')->get();
        return view('admin.nota_bon.create', compact('SopirAll'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'karyawan_id' => 'required',
                'nominal' => 'required',
            ],
            [
                'karyawan_id.required' => 'Pilih sopir',
                'nominal.required' => 'Masukkan nominal',
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }

        $nominal_nota = str_replace(',', '.', str_replace('.', '', $request->nominal));
        if ($nominal_nota > 3000000) {
            return back()
                ->withInput()
                ->with('error', 'Nominal nota tidak boleh lebih dari 3 juta');
        }

        $nama_driver = $request->input('nama_driver');
        $postedCount = Notabon_ujs::where('nama_driver', $nama_driver)
            ->where('status', 'posting')
            ->count();

        // Jika jumlahnya sudah mencapai atau melebihi 3, lewati memo ekspedisi ini
        if (
            $postedCount >= 4
        ) {
            return back()
                ->withInput()
                ->with('error', 'Nota telah mencapai batas maksimal untuk driver: ' . $nama_driver . ' ' . 'sudah ada 2 nota bon ' . $nama_driver . ' yang belum di tarik memo');
        }

        $kode = $this->kode();

        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');

        $tanggal = Carbon::now()->format('Y-m-d');
        $cetakpdf = Notabon_ujs::create(array_merge(
            $request->all(),
            [
                'kode_nota' => $this->kode(),
                'karyawan_id' => $request->karyawan_id,
                'user_id' => $request->user_id,
                'kode_driver' => $request->kode_driver,
                'nama_driver' => $request->nama_driver,
                'admin' => auth()->user()->karyawan->nama_lengkap,
                'nominal' => str_replace(',', '.', str_replace('.', '', $request->nominal)),
                'keterangan' => $request->keterangan,
                'tanggal' =>  $format_tanggal,
                'tanggal_awal' =>  $tanggal,
                'qrcode_nota' => 'https://javaline.id/nota-bon/' . $kode,
                'status' => 'unpost',
            ]
        ));

        $kodepengeluaran = $this->kodepengeluaran();
        Pengeluaran_kaskecil::create([
            'notabon_ujs_id' => $cetakpdf->id,
            'user_id' => auth()->user()->id,
            'kode_pengeluaran' => $this->kodepengeluaran(),
            'kendaraan_id' => $request->kendaraan_id,
            'keterangan' => $request->keterangan,
            // 'grand_total' => str_replace('.', '', $request->uang_jalan),
            'grand_total' => str_replace(',', '.', str_replace('.', '', $request->nominal)),
            'jam' => $tanggal1->format('H:i:s'),
            'tanggal' => $format_tanggal,
            'tanggal_awal' => $tanggal,
            'qrcode_return' => 'https://batlink.id/pengeluaran_kaskecil/' . $kodepengeluaran,
            'status' => 'pending',
        ]);

        Detail_pengeluaran::create([
            'notabon_ujs_id' => $cetakpdf->id,
            'barangakun_id' => 4,
            'kode_detailakun' => $this->kodeakuns(),
            'kode_akun' => 'KA000004',
            'nama_akun' => 'PERJALANAN',
            'keterangan' => $request->keterangan,
            // 'nominal' => str_replace('.', '', $request->uang_jalan),
            'nominal' => str_replace(',', '.', str_replace('.', '', $request->nominal)),
            'status' => 'pending',
        ]);

        return redirect('admin/nota-bon')->with('success', 'Berhasil menambahkan nota bon uang jalan');
    }

    public function kode()
    {
        // Mengambil kode terbaru dari database dengan awalan 'MP'
        $lastBarang = Notabon_ujs::where('kode_nota', 'like', 'KN%')->latest()->first();

        // Mendapatkan bulan dari tanggal kode terakhir
        $lastMonth = $lastBarang ? date('m', strtotime($lastBarang->created_at)) : null;
        $currentMonth = date('m');

        // Jika tidak ada kode sebelumnya atau bulan saat ini berbeda dari bulan kode terakhir
        if (!$lastBarang || $currentMonth != $lastMonth) {
            $num = 1; // Mulai dari 1 jika bulan berbeda
        } else {
            // Jika ada kode sebelumnya, ambil nomor terakhir
            $lastCode = $lastBarang->kode_nota;

            // Pisahkan kode menjadi bagian-bagian terpisah
            $parts = explode('/', $lastCode);
            $lastNum = end($parts); // Ambil bagian terakhir sebagai nomor terakhir
            $num = (int) $lastNum + 1; // Tambahkan 1 ke nomor terakhir
        }

        // Format nomor dengan leading zeros sebanyak 6 digit
        $formattedNum = sprintf("%06s", $num);

        // Awalan untuk kode baru
        $prefix = 'KN';
        $tahun = date('y');
        $tanggal = date('dm');

        // Buat kode baru dengan menggabungkan awalan, tanggal, tahun, dan nomor yang diformat
        $newCode = $prefix . "/" . $tanggal . $tahun . "/" . $formattedNum;

        // Kembalikan kode
        return $newCode;
    }

    public function kodeakuns()
    {
        try {
            return DB::transaction(function () {
                // Mengambil kode terbaru dari database dengan awalan 'KKA'
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
            });
        } catch (\Throwable $e) {
            // Jika terjadi kesalahan, melanjutkan dengan kode berikutnya
            $lastCode = Detail_pengeluaran::where('kode_detailakun', 'like', 'KKA%')->latest()->value('kode_detailakun');
            if (!$lastCode) {
                $lastNum = 0;
            } else {
                $parts = explode('/', $lastCode);
                $lastNum = end($parts);
            }
            $nextNum = (int) $lastNum + 1;
            $formattedNextNum = sprintf("%06s", $nextNum);
            $tahun = date('y');
            $tanggal = date('dm');
            return 'KKA/' . $tanggal . $tahun . "/" . $formattedNextNum;
        }
    }


    public function kodepengeluaran()
    {
        try {
            return DB::transaction(function () {
                // Mengambil kode terbaru dari database dengan awalan 'KK'
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
            });
        } catch (\Throwable $e) {
            // Jika terjadi kesalahan, melanjutkan dengan kode berikutnya
            $lastCode = Pengeluaran_kaskecil::where('kode_pengeluaran', 'like', 'KK%')->latest()->value('kode_pengeluaran');
            if (!$lastCode) {
                $lastNum = 0;
            } else {
                $parts = explode('/', $lastCode);
                $lastNum = end($parts);
            }
            $nextNum = (int) $lastNum + 1;
            $formattedNextNum = sprintf("%06s", $nextNum);
            $tahun = date('y');
            $tanggal = date('dm');
            return 'KK/' . $tanggal . $tahun . "/" . $formattedNextNum;
        }
    }

    public function show($id)
    {
        $cetakpdf = Notabon_ujs::where('id', $id)->first();
        return view('admin.nota_bon.show', compact('cetakpdf'));
    }

    public function cetakpdf($id)
    {
        $cetakpdf = Notabon_ujs::where('id', $id)->first();
        $pdf = PDF::loadView('admin.nota_bon.cetak_pdf', compact('cetakpdf'));
        $pdf->setPaper('letter', 'portrait');
        return $pdf->stream('Nota_bon.pdf');
    }
}