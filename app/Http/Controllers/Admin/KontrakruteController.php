<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Barang_akun;
use App\Models\Kendaraan;
use App\Models\Detail_kontrak;
use App\Models\Kontrak_rute;
use App\Models\Tarif;
use Illuminate\Support\Facades\Validator;

class KontrakruteController extends Controller
{
    public function index()
    {
        return view('admin.kontrak_rute.index', compact('kendaraans', 'barangakuns'));
    }


    public function store(Request $request)
    {

        $validasi_pelanggan = Validator::make(
            $request->all(),
            [
                'pelanggan_id' => 'required',
            ],
            [
                'pelanggan_id.required' => 'Pilih Pelanggan',
            ]
        );

        $error_pelanggans = array();

        if ($validasi_pelanggan->fails()) {
            array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
        }

        $error_pesanans = array();
        $data_pembelians = collect();

        if ($request->has('nama_tarif')) {
            for ($i = 0; $i < count($request->nama_tarif); $i++) {
                $validasi_produk = Validator::make($request->all(), [
                    'nama_tarif.' . $i => 'required',
                    'nominal.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Rute nomor " . ($i + 1) . " belum dilengkapi!");
                }

                $nama_tarif = is_null($request->nama_tarif[$i]) ? '' : $request->nama_tarif[$i];
                $nominal = is_null($request->nominal[$i]) ? '' : $request->nominal[$i];

                $data_pembelians->push([
                    'nama_tarif' => $nama_tarif,
                    'nominal' => $nominal,
                ]);
            }
        }

        if ($error_pelanggans || $error_pesanans) {
            return back()
                ->withInput()
                ->with('error_pelanggans', $error_pelanggans)
                ->with('error_pesanans', $error_pesanans)
                ->with('data_pembelians', $data_pembelians);
        }


        // Move this block above the point where $cetakpdf is used
        $kode = $this->kode();
        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');
        $tanggal = Carbon::now()->format('Y-m-d');

        $cetakpdfs = Kontrak_rute::create([
            'user_id' => auth()->user()->id,
            'kode_kontrak' => $this->kode(),
            'pelanggan_id' => $request->pelanggan_id,
            'tanggal' => $format_tanggal,
            'tanggal_awal' => $tanggal,
            'qrcode_kontrak_rute' => 'https://javaline.id/kontrak_rute/' . $kode,
            'status' => 'unpost',
            'status_notif' => false,
        ]);

        $cetakpdf = $cetakpdfs->id;

        $kode_tarif = $this->kode_tarif();

        if ($cetakpdfs) {
            foreach ($data_pembelians as $data_pesanan) {
                Detail_kontrak::create([
                    'kode_tarif' => $this->kode_tarif(),
                    'kontrak_rute_id' => $cetakpdfs->id,
                    'nama_tarif' => $data_pesanan['nama_tarif'],
                    'nominal' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['nominal'])),
                ]);
            }
        }

        $pembelians = Kontrak_rute::find($cetakpdf);
        $details = Detail_kontrak::where('kontrak_rute_id', $cetakpdf->id)->get();

        return view('admin.kontrak_rute.show', compact('cetakpdf', 'details'));
    }

    public function kode()
    {
        $lastBarang = Kontrak_rute::latest()->first();
        if (!$lastBarang) {
            $num = 1;
        } else {
            $lastCode = $lastBarang->kode_pembelian_ban;
            $num = (int) substr($lastCode, strlen('FB')) + 1;
        }
        $formattedNum = sprintf("%06s", $num);
        $prefix = 'FB';
        $newCode = $prefix . $formattedNum;
        return $newCode;
    }


    public function kode_tarif()
    {
        $ban = Tarif::all();
        if ($ban->isEmpty()) {
            $num = "000001";
        } else {
            $id = Tarif::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'JL';
        $kode_ban = $data . $num;
        return $kode_ban;
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
        $cetakpdf = Kontrak_rute::where('id', $id)->first();

        return view('admin.kontrak_rute.show', compact('cetakpdf'));
    }

    public function cetakpdf($id)
    {
        $cetakpdf = Kontrak_rute::where('id', $id)->first();
        $details = Detail_kontrak::where('pengeluaran_kaskecil_id', $cetakpdf->id)->get();

        $pdf = PDF::loadView('admin.kontrak_rute.cetak_pdf', compact('cetakpdf', 'details'));
        $pdf->setPaper('letter', 'portrait'); // Set the paper size to portrait letter

        return $pdf->stream('Pengeluaran_Kaskecil.pdf');
    }
}