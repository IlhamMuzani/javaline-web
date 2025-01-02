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
use App\Models\Pelanggan;
use App\Models\Tarif;
use Illuminate\Support\Facades\Validator;

class KontrakruteController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $kontrak_rutes = Kontrak_rute::whereDate('created_at', $today)
            ->orWhere(function ($query) use ($today) {
                $query->where('status', 'unpost')
                    ->whereDate('created_at', '<', $today);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.kontrak_rute.index', compact('kontrak_rutes'));
    }

    public function create()
    {

        $pelanggans = Pelanggan::get();
        return view('admin.kontrak_rute.create', compact('pelanggans'));
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
            'keterangan' => $request->keterangan,
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
                $details = Detail_kontrak::create([
                    'kontrak_rute_id' => $cetakpdfs->id,
                    'nama_tarif' => $data_pesanan['nama_tarif'],
                    'nominal' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['nominal'])),
                ]);

                Tarif::create([
                    'kode_tarif' => $this->kode_tarif(),
                    'pelanggan_id' => $cetakpdfs->pelanggan_id,
                    'kontrak_rute_id' => $cetakpdfs->id,
                    'detail_kontrak_id' => $details->id,
                    'nama_tarif' => $data_pesanan['nama_tarif'],
                    'nominal' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['nominal'])),
                    'status' =>  'unpost',
                ]);
            }
        }

        $cetakpdf = Kontrak_rute::where('id', $cetakpdfs->id)->first();
        $details = Detail_kontrak::where('kontrak_rute_id', $cetakpdfs->id)->get();

        return view('admin.kontrak_rute.show', compact('cetakpdf', 'details'));
    }

    public function kode()
    {
        $lastBarang = Kontrak_rute::latest()->first();
        if (!$lastBarang) {
            $num = 1;
        } else {
            $lastCode = $lastBarang->kode_kontrak;
            $num = (int) substr($lastCode, strlen('OG')) + 1;
        }
        $formattedNum = sprintf("%06s", $num);
        $prefix = 'OG';
        $newCode = $prefix . $formattedNum;
        return $newCode;
    }


    public function kode_tarif()
    {
        // Ambil tarif terakhir yang kodenya dimulai dengan 'HS'
        $lastBarang = Tarif::where('kode_tarif', 'LIKE', 'TF%')->latest('id')->first();

        // Jika tidak ada tarif dalam database dengan awalan 'HS'
        if (!$lastBarang) {
            $num = 1;
        } else {
            // Ambil kode tarif terakhir
            $lastCode = $lastBarang->kode_tarif;

            // Ambil angka setelah awalan 'TF'
            $num = (int) substr($lastCode, 2) + 1;
        }

        // Format nomor dengan panjang 6 digit (misalnya, 000001)
        $formattedNum = sprintf("%06s", $num);

        // Tentukan awalan kode
        $prefix = 'TF';

        // Gabungkan awalan dengan nomor yang diformat untuk mendapatkan kode baru
        $newCode = $prefix . $formattedNum;

        return $newCode;
    }



    public function show($id)
    {
        $cetakpdf = Kontrak_rute::where('id', $id)->first();
        $details = Detail_kontrak::where('kontrak_rute_id', $cetakpdf->id)->get();

        return view('admin.kontrak_rute.show', compact('cetakpdf', 'details'));
    }

    public function cetakpdf($id)
    {
        $cetakpdf = Kontrak_rute::where('id', $id)->first();
        $details = Detail_kontrak::where('kontrak_rute_id', $cetakpdf->id)->get();

        $pdf = PDF::loadView('admin.kontrak_rute.cetak_pdf', compact('cetakpdf', 'details'));
        $pdf->setPaper('letter', 'portrait'); // Set the paper size to portrait letter

        return $pdf->stream('Kontrak_rute.pdf');
    }
}