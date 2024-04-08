<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Barang_akun;
use App\Models\Detail_memotambahan;
use App\Models\Kendaraan;
use App\Models\Detail_pengeluaran;
use App\Models\Pengeluaran_kaskecil;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PengeluarankaskecilController extends Controller
{
    public function index()
    {
        $kendaraans = Kendaraan::all();
        $barangakuns = Barang_akun::all();
        return view('admin.pengeluaran_kaskecil.index', compact('kendaraans', 'barangakuns'));
    }

    // public function store(Request $request)
    // {
    //     $error_pesanans = array();
    //     $data_pembelians = collect();

    //     if ($request->has('barangakun_id')) {
    //         for ($i = 0; $i < count($request->barangakun_id); $i++) {
    //             $validasi_produk = Validator::make($request->all(), [
    //                 'barangakun_id.' . $i => 'required',
    //                 'kode_akun.' . $i => 'required',
    //                 'nama_akun.' . $i => 'required',
    //                 'nominal.' . $i => 'required',
    //                 'keterangan.' . $i => 'required',
    //             ]);

    //             if ($validasi_produk->fails()) {
    //                 array_push($error_pesanans, "Akun nomor " . ($i + 1) . " belum dilengkapi!"); // Corrected the syntax for concatenation and indexing
    //             }

    //             $barangakun_id = is_null($request->barangakun_id[$i]) ? '' : $request->barangakun_id[$i];
    //             $kode_akun = is_null($request->kode_akun[$i]) ? '' : $request->kode_akun[$i];
    //             $nama_akun = is_null($request->nama_akun[$i]) ? '' : $request->nama_akun[$i];
    //             $nominal = is_null($request->nominal[$i]) ? '' : $request->nominal[$i];
    //             $keterangan = is_null($request->keterangan[$i]) ? '' : $request->keterangan[$i];

    //             $data_pembelians->push([
    //                 'barangakun_id' => $barangakun_id,
    //                 'kode_akun' => $kode_akun,
    //                 'nama_akun' => $nama_akun,
    //                 'nominal' => $nominal,
    //                 'keterangan' => $keterangan,
    //             ]);
    //         }
    //     }


    //     if ($error_pesanans) {
    //         return back()
    //             ->withInput()
    //             ->with('error_pesanans', $error_pesanans)
    //             ->with('data_pembelians', $data_pembelians);
    //     }

    //     $kode = $this->kode();
    //     // format tanggal indo
    //     $tanggal1 = Carbon::now('Asia/Jakarta');
    //     $format_tanggal = $tanggal1->format('d F Y');

    //     $tanggal = Carbon::now()->format('Y-m-d');
    //     $cetakpdf = Pengeluaran_kaskecil::create([
    //         'user_id' => auth()->user()->id,
    //         'kode_pengeluaran' => $this->kode(),
    //         'kendaraan_id' => $request->kendaraan_id,
    //         // 'keterangan' => $request->keterangan,
    //         'grand_total' => str_replace('.', '', $request->grand_total),
    //         'jam' => $tanggal1->format('H:i:s'),
    //         'tanggal' => $format_tanggal,
    //         'tanggal_awal' => $tanggal,
    //         'qrcode_return' => 'https://javaline.id/pengeluaran_kaskecil/' . $kode,
    //         'status' => 'unpost',
    //         'status_notif' => false,
    //     ]);

    //     $transaksi_id = $cetakpdf->id;

    //     if ($cetakpdf) {
    //         foreach ($data_pembelians as $data_pesanan) {
    //             Detail_pengeluaran::create([
    //                 'pengeluaran_kaskecil_id' => $cetakpdf->id,
    //                 'status' => 'unpost',
    //                 'kode_detailakun' => $this->kodeakuns(),
    //                 'barangakun_id' => $data_pesanan['barangakun_id'],
    //                 'kode_akun' => $data_pesanan['kode_akun'],
    //                 'nama_akun' => $data_pesanan['nama_akun'],
    //                 'nominal' => str_replace('.', '', $data_pesanan['nominal']),
    //                 'keterangan' => $data_pesanan['keterangan'],
    //             ]);
    //         }
    //     }

    //     $details = Detail_pengeluaran::where('pengeluaran_kaskecil_id', $cetakpdf->id)->get();

    //     return view('admin.pengeluaran_kaskecil.show', compact('cetakpdf', 'details'));
    // }


    public function store(Request $request)
    {
        $error_pesanans = array();
        $data_pembelians = collect();

        if ($request->has('barangakun_id')) {
            for ($i = 0; $i < count($request->barangakun_id); $i++) {
                $validasi_produk = Validator::make($request->all(), [
                    'barangakun_id.' . $i => 'required',
                    'kode_akun.' . $i => 'required',
                    'nama_akun.' . $i => 'required',
                    'nominal.' . $i => 'required',
                    'keterangan.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Akun nomor " . ($i + 1) . " belum dilengkapi!");
                }

                $barangakun_id = is_null($request->barangakun_id[$i]) ? '' : $request->barangakun_id[$i];
                $kode_akun = is_null($request->kode_akun[$i]) ? '' : $request->kode_akun[$i];
                $nama_akun = is_null($request->nama_akun[$i]) ? '' : $request->nama_akun[$i];
                $nominal = is_null($request->nominal[$i]) ? '' : $request->nominal[$i];
                $keterangan = is_null($request->keterangan[$i]) ? '' : $request->keterangan[$i];

                $data_pembelians->push([
                    'barangakun_id' => $barangakun_id,
                    'kode_akun' => $kode_akun,
                    'nama_akun' => $nama_akun,
                    'nominal' => $nominal,
                    'keterangan' => $keterangan,
                ]);
            }
        }

        if ($error_pesanans) {
            return back()
                ->withInput()
                ->with('error_pesanans', $error_pesanans)
                ->with('data_pembelians', $data_pembelians);
        }

        // Move this block above the point where $cetakpdf is used
        $kode = $this->kode();
        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');
        $tanggal = Carbon::now()->format('Y-m-d');

        $cetakpdf = Pengeluaran_kaskecil::create([
            'user_id' => auth()->user()->id,
            'kode_pengeluaran' => $this->kode(),
            'kendaraan_id' => $request->kendaraan_id,
            'grand_total' => str_replace('.', '', $request->grand_total),
            'jam' => $tanggal1->format('H:i:s'),
            'tanggal' => $format_tanggal,
            'tanggal_awal' => $tanggal,
            'qrcode_return' => 'https://javaline.id/pengeluaran_kaskecil/' . $kode,
            'status' => 'unpost',
            'status_notif' => false,
        ]);

        $allKeterangan = ''; // Initialize an empty string to accumulate keterangan values
        foreach ($data_pembelians as $data_pesanan) {
            Detail_pengeluaran::create([
                'pengeluaran_kaskecil_id' => $cetakpdf->id,
                'status' => 'unpost',
                'kendaraan_id' => $request->kendaraan_id,
                'kode_detailakun' => $this->kodeakuns(),
                'barangakun_id' => $data_pesanan['barangakun_id'],
                'kode_akun' => $data_pesanan['kode_akun'],
                'nama_akun' => $data_pesanan['nama_akun'],
                'nominal' => str_replace('.', '', $data_pesanan['nominal']),
                'keterangan' => $data_pesanan['keterangan'],
            ]);

            $allKeterangan .= $data_pesanan['keterangan'] . ', ';
        }

        // Remove the trailing comma and space from the accumulated keterangan
        $allKeterangan = rtrim($allKeterangan, ', ');

        // Update $allKeterangan in $cetakpdf after creating Detail_pengeluaran
        $cetakpdf->update([
            'keterangan' => $allKeterangan,
        ]);

        $details = Detail_pengeluaran::where('pengeluaran_kaskecil_id', $cetakpdf->id)->get();

        return view('admin.pengeluaran_kaskecil.show', compact('cetakpdf', 'details'));
    }

    // public function kodeakuns()
    // {
    //     $ban = Detail_pengeluaran::all();
    //     if ($ban->isEmpty()) {
    //         $num = "000001";
    //     } else {
    //         $id = Detail_pengeluaran::getId();
    //         foreach ($id as $value);
    //         $idlm = $value->id;
    //         $idbr = $idlm + 1;
    //         $num = sprintf("%06s", $idbr);
    //     }

    //     $data = 'KKA';
    //     $kode_ban = $data . $num;
    //     return $kode_ban;
    // }

    // public function kode()
    // {
    //     $item = Pengeluaran_kaskecil::all();
    //     if ($item->isEmpty()) {
    //         $num = "000001";
    //     } else {
    //         $id = Pengeluaran_kaskecil::getId();
    //         foreach ($id as $value);
    //         $idlm = $value->id;
    //         $idbr = $idlm + 1;
    //         $num = sprintf("%06s", $idbr);
    //     }

    //     $data = 'KK';
    //     $kode_item = $data . $num;
    //     return $kode_item;
    // }

    // public function kode()
    // {
    //     $lastBarang = Pengeluaran_kaskecil::latest()->first();
    //     if (!$lastBarang) {
    //         $num = 1;
    //     } else {
    //         $lastCode = $lastBarang->kode_pengeluaran;
    //         $num = (int) substr($lastCode, strlen('KK')) + 1;
    //     }
    //     $formattedNum = sprintf("%06s", $num);
    //     $prefix = 'KK';
    //     $newCode = $prefix . $formattedNum;
    //     return $newCode;
    // }

    public function kode()
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


    public function tambah_akun(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_barangakun' => 'required',
            ],
            [
                'nama_barangakun.required' => 'Masukkan nama akun',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kodebarang = $this->kodebarang();

        Barang_akun::create(array_merge(
            $request->all(),
            [
                'kode_barangakun' => $this->kodebarang(),
                'qrcode_barangakun' => 'https://batlink.id/barang_akun/' . $kodebarang,
                'tanggal_awal' => Carbon::now('Asia/Jakarta'),

            ]
        ));

        return back()->with('success', 'Berhasil menambahkan barang');
    }


    public function kodebarang()
    {
        $type = Barang_akun::all();
        if ($type->isEmpty()) {
            $num = "000001";
        } else {
            $id = Barang_akun::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'KA';
        $kode_type = $data . $num;
        return $kode_type;
    }

    public function show($id)
    {
        $cetakpdf = Pengeluaran_kaskecil::where('id', $id)->first();

        return view('admin.pengeluaran_kaskecil.show', compact('cetakpdf'));
    }

    public function cetakpdf($id)
    {
        $cetakpdf = Pengeluaran_kaskecil::where('id', $id)->first();
        $details = Detail_pengeluaran::where('pengeluaran_kaskecil_id', $cetakpdf->id)->get();

        $pdf = PDF::loadView('admin.pengeluaran_kaskecil.cetak_pdf', compact('cetakpdf', 'details'));
        $pdf->setPaper('letter', 'portrait'); // Set the paper size to portrait letter

        return $pdf->stream('Pengeluaran_Kaskecil.pdf');
    }
}