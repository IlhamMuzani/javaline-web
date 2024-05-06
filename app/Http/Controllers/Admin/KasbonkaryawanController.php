<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Detail_cicilan;
use App\Models\Detail_pengeluaran;
use App\Models\Karyawan;
use App\Models\Kasbon_karyawan;
use App\Models\Pengeluaran_kaskecil;
use Illuminate\Support\Facades\Validator;

class KasbonkaryawanController extends Controller
{
    public function index()
    {
        $karyawanAll = Karyawan::whereIn('departemen_id', [1, 3])->get();
        return view('admin.kasbon_karyawan.index', compact('karyawanAll'));
    }


    public function store(Request $request)
    {
        $validasi_pelanggan = Validator::make(
            $request->all(),
            [
                'karyawan_id' => 'required',
            ],
            [
                'karyawan_id.required' => 'Pilih sopir',
            ]
        );

        $error_pelanggans = array();

        if ($validasi_pelanggan->fails()) {
            array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
        }

        $error_pesanans = array();
        $data_pembelians = collect();

        if ($request->has('nominal_cicilan')) {
            $totalNominalCicilan = 0;

            for ($i = 0; $i < count($request->nominal_cicilan); $i++) {
                $validasi_produk = Validator::make($request->all(), [
                    'nominal_cicilan.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Nominal cicilan nomor " . ($i + 1) . " belum dilengkapi!");
                }

                $nominal_cicilan = $request->nominal_cicilan[$i] ?? '';
                $totalNominalCicilan += $nominal_cicilan;
            }

            // $saldo_keluar = $request->saldo_keluar;

            // if ($totalNominalCicilan > $saldo_keluar) {
            //     array_push($error_pesanans, "Jumlah nominal cicilan melebihi nominal potongan !");
            // }

            // Jika tidak ada kesalahan, tambahkan data pembelian
            if (empty($error_pesanans)) {
                for ($i = 0; $i < count($request->nominal_cicilan); $i++) {
                    $nominal_cicilan = $request->nominal_cicilan[$i] ?? '';

                    $data_pembelians->push([
                        'nominal_cicilan' => $nominal_cicilan
                    ]);
                }
            }
        }

        if ($error_pelanggans || $error_pesanans) {
            return back()
                ->withInput()
                ->with('error_pelanggans', $error_pelanggans)
                ->with('error_pesanans', $error_pesanans)
                ->with('data_pembelians', $data_pembelians);
        }

        if ($validasi_pelanggan->fails()) {
            $errors = $validasi_pelanggan->errors()->all();
            return back()->withInput()->with('error', $errors);
        }

        $kode = $this->kode();
        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');

        $tanggal = Carbon::now()->format('Y-m-d');
        $penerimaan = Kasbon_karyawan::create(array_merge(
            $request->all(),
            [
                'kode_kasbon' => $this->kode(),
                'kategori' => 'Pengambilan Kasbon',
                'sub_total' => $request->sub_total2,
                'tanggal' =>  $format_tanggal,
                'tanggal_awal' =>  $tanggal,
                'keterangan' => $request->keterangan,
                'status' => 'unpost',
            ]
        ));

        $transaksi_id = $penerimaan->id;

        if ($penerimaan) {

            foreach ($data_pembelians as $data_pesanan) {
                Detail_cicilan::create([
                    'kasbon_karyawan_id' =>  $penerimaan->id,
                    'nominal_cicilan' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['nominal_cicilan'])),
                    'status' =>  'unpost',
                    'status_cicilan' =>  'belum lunas',
                    'karyawan_id' =>  $request->karyawan_id,
                ]);
            }
        }

        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');
        $tanggal = Carbon::now()->format('Y-m-d');
        $kodepengeluaran = $this->kodepengeluaran();
        $pengeluarankaskecil = Pengeluaran_kaskecil::create([
            'kasbon_karyawan_id' => $penerimaan->id,
            'user_id' => auth()->user()->id,
            'kode_pengeluaran' => $this->kodepengeluaran(),
            // 'kendaraan_id' => $request->kendaraan_id,
            'keterangan' => $request->keterangan,
            'grand_total' => str_replace(',', '.', str_replace('.', '', $request->nominal)),
            'jam' => $tanggal1->format('H:i:s'),
            'tanggal' => $format_tanggal,
            'tanggal_awal' => $tanggal,
            'qrcode_return' => 'https://javaline.id/kasbon_karyawan/' . $kodepengeluaran,
            'status' => 'unpost',
        ]);

        Detail_pengeluaran::create([
            'kasbon_karyawan_id' => $penerimaan->id,
            'pengeluaran_kaskecil_id' => $pengeluarankaskecil->id,
            'barangakun_id' => 1,
            'kode_detailakun' => $this->kodeakuns(),
            'kode_akun' => 'KA000004',
            'nama_akun' => 'GAJI & TUNJANGAN',
            'keterangan' => $request->keterangan,
            'nominal' => str_replace(',', '.', str_replace('.', '', $request->nominal)),
            'status' => 'unpost',
        ]);

        $cetakpdf = Kasbon_karyawan::find($penerimaan->id);
        return view('admin.kasbon_karyawan.show', compact('cetakpdf'));
    }

    public function kode()
    {
        $lastBarang = Kasbon_karyawan::latest()->first();
        if (!$lastBarang) {
            $num = 1;
        } else {
            $lastCode = $lastBarang->kode_kasbon;
            $num = (int) substr($lastCode, strlen('KS')) + 1;
        }
        $formattedNum = sprintf("%06s", $num);
        $prefix = 'KS';
        $newCode = $prefix . $formattedNum;
        return $newCode;
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
    public function show($id)
    {
        $cetakpdf = Kasbon_karyawan::where('id', $id)->first();

        return view('admin.kasbon_karyawan.show', compact('cetakpdf'));
    }

    public function cetakpdf($id)
    {
        $cetakpdf = Kasbon_karyawan::where('id', $id)->first();

        $pdf = PDF::loadView('admin.kasbon_karyawan.cetak_pdf', compact('cetakpdf'));
        $pdf->setPaper('letter', 'portrait'); // Set the paper size to portrait letter

        return $pdf->stream('Faktur_Kasbon_Karyawan.pdf');
    }
}