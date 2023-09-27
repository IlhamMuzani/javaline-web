<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\Merek;
use App\Models\Ukuran;
use App\Models\Supplier;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Pembelian_ban;
use App\Models\Detail_pembelianban;
use App\Http\Controllers\Controller;
use App\Models\Ban;
use App\Models\Typeban;
use Illuminate\Support\Facades\Validator;

class PembelianBanController extends Controller
{
    public function index()
    {
        if (auth()->check() && auth()->user()->menu['pembelian ban']) {

            $pembelian_bans = Pembelian_ban::all();
            $ukurans = Ukuran::all();
            $mereks = Merek::all();
            $typebans = Typeban::all();
            $suppliers = Supplier::all();
            return view('admin.pembelian_ban.index', compact('pembelian_bans', 'ukurans', 'mereks', 'typebans', 'suppliers'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function create()
    {
        if (auth()->check() && auth()->user()->menu['pembelian ban']) {
            $ukurans = Ukuran::all();
            $mereks = Merek::all();
            $suppliers = Supplier::all();
            return view('admin.pembelian_ban.create', compact('ukurans', 'mereks', 'suppliers'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function supplier($id)
    {
        $supplier = Supplier::where('id', $id)->first();

        return json_decode($supplier);
    }

    public function tambah_supplier(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_supp' => 'required',
                'alamat' => 'required',
                // 'nama_person' => 'required',
                // 'jabatan' => 'required',
                // 'fax' => 'required',
                'telp' => 'required',
                'hp' => 'required',
                // 'email' => 'required',
                // 'npwp' => 'required',
                'nama_bank' => 'required',
                'atas_nama' => 'required',
                'norek' => 'required',
            ],
            [
                'nama_supp.required' => 'Masukkan nama supplier',
                'alamat.required' => 'Masukkan Alamat',
                // 'nama_person.required' => 'Masukkan nama',
                // 'jabatan.required' => 'Masukkan jabatan',
                'telp.required' => 'Masukkan no telepon',
                // 'fax.required' => 'Masukkan no fax',
                'hp.required' => 'Masukkan no hp',
                // 'email.required' => 'Masukkan email',
                // 'npwp.required' => 'Masukkan no npwp',
                'nama_bank.required' => 'Masukkan nama bank',
                'atas_nama.required' => 'Masukkan atas nama',
                'norek.required' => 'Masukkan no rekening',
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error_pelanggans', $errors);
        }


        $kode_supp = $this->kode_supp();

        Supplier::create(array_merge(
            $request->all(),
            [
                'kode_supplier' => $this->kode_supp(),
                'qrcode_supplier' => 'https://javaline.id/supplier/' . $kode_supp,
                'tanggal_awal' => Carbon::now('Asia/Jakarta'),
                // 'qrcode_supplier' => 'http://192.168.1.46/javaline/supplier/' . $kode
            ]
        ));

        return redirect('admin/pembelian_ban/create')->with('success', 'Berhasil menambahkan supplier');
    }

    public function kode_supp()
    {
        $supplier = Supplier::all();
        if ($supplier->isEmpty()) {
            $num = "000001";
        } else {
            $id = Supplier::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'AC';
        $kode_supplier = $data . $num;
        return $kode_supplier;
    }

    public function store(Request $request)
    {
        $validasi_pelanggan = Validator::make($request->all(), [
            'supplier_id' => 'required',
        ], [
            'supplier_id.required' => 'Pilih nama supplier!',
        ]);

        $error_pelanggans = array();

        if ($validasi_pelanggan->fails()) {
            array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
        }

        $error_pesanans = array();
        $data_pembelians = collect();

        if ($request->has('no_seri')) {
            for ($i = 0; $i < count($request->no_seri); $i++) {
                $validasi_produk = Validator::make($request->all(), [
                    'no_seri.' . $i => 'required',
                    'ukuran_id.' . $i => 'required',
                    'kondisi_ban.' . $i => 'required',
                    'merek_id.' . $i => 'required',
                    'typeban_id.' . $i => 'required',
                    'harga.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Pembelian ban nomor " . $i + 1 . " belum dilengkapi!");
                }


                $no_seri = is_null($request->no_seri[$i]) ? '' : $request->no_seri[$i];
                $ukuran_id = is_null($request->ukuran_id[$i]) ? '' : $request->ukuran_id[$i];
                $kondisi_ban = is_null($request->kondisi_ban[$i]) ? '' : $request->kondisi_ban[$i];
                $merek_id = is_null($request->merek_id[$i]) ? '' : $request->merek_id[$i];
                $typeban_id = is_null($request->typeban_id[$i]) ? '' : $request->typeban_id[$i];
                $harga = is_null($request->harga[$i]) ? '' : $request->harga[$i];

                $data_pembelians->push(['no_seri' => $no_seri, 'ukuran_id' => $ukuran_id, 'kondisi_ban' => $kondisi_ban, 'merek_id' => $merek_id, 'typeban_id' => $typeban_id, 'harga' => $harga]);
            }
        } else {
        }

        if ($error_pelanggans || $error_pesanans) {
            return back()
                ->withInput()
                ->with('error_pelanggans', $error_pelanggans)
                ->with('error_pesanans', $error_pesanans)
                ->with('data_pembelians', $data_pembelians);
        }

        // format tanggal indo
        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');

        $tanggal = Carbon::now()->format('Y-m-d');
        $transaksi = Pembelian_ban::create([
            'kode_pembelian_ban' => $this->kode(),
            'supplier_id' => $request->supplier_id,
            'tanggal' => $format_tanggal,
            'tanggal_awal' => $tanggal,
            'status' => 'posting',
            'status_notif' => false,
        ]);

        $transaksi_id = $transaksi->id;

        $kodeban = $this->kodeban();

        if ($transaksi) {

            foreach ($data_pembelians as $data_pesanan) {
                Ban::create([
                    'kode_ban' => $this->kodeban(),
                    'pembelian_ban_id' => $transaksi->id,
                    'qrcode_ban' => 'https://javaline.id/ban/' . $this->kodeban(),
                    'status' => 'stok',
                    'tanggal_awal' => Carbon::now('Asia/Jakarta'),
                    'no_seri' => $data_pesanan['no_seri'],
                    'ukuran_id' => $data_pesanan['ukuran_id'],
                    'kondisi_ban' => $data_pesanan['kondisi_ban'],
                    'merek_id' => $data_pesanan['merek_id'],
                    'typeban_id' => $data_pesanan['typeban_id'],
                    'harga' => $data_pesanan['harga'],
                ]);
            }
        }

        $pembelians = Pembelian_ban::find($transaksi_id);

        $bans = Ban::where('pembelian_ban_id', $pembelians->id)->get();

        return view('admin.pembelian_ban.show', compact('bans', 'pembelians'));
        // return redirect('admin/pembelian_ban/show')->with('success', 'Berhasil menambahkan Pembelian ban');
    }

    public function kode()
    {
        $pembelian_ban = Pembelian_ban::all();
        if ($pembelian_ban->isEmpty()) {
            $num = "000001";
        } else {
            $id = Pembelian_ban::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'FB';
        $kode_pembelian_ban = $data . $num;
        return $kode_pembelian_ban;
    }

    public function kodeban()
    {
        $ban = Ban::all();
        if ($ban->isEmpty()) {
            $num = "000001";
        } else {
            $id = Ban::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'JL';
        $kode_ban = $data . $num;
        return $kode_ban;
    }

    public function show($id)
    {
        $pembelians = Pembelian_ban::where('id', $id)->first();
        $pembelian_ban = Pembelian_ban::find($id);

        $bans = Ban::where('pembelian_ban_id', $pembelian_ban->id)->get();

        return view('admin.pembelian_ban.show', compact('bans', 'pembelians'));
    }

    public function cetakpdf($id)
    {
        $pembelians = Pembelian_ban::find($id);
        $bans = Ban::where('pembelian_ban_id', $pembelians->id)->get();

        // Load the view and set the paper size to portrait letter
        $pembelianbans = Pembelian_ban::where('id', $id)->first();
        $pdf = PDF::loadView('admin.pembelian_ban.cetak_pdf', compact('bans', 'pembelians', 'pembelianbans'));
        $pdf->setPaper('letter', 'portrait'); // Set the paper size to portrait letter

        return $pdf->stream('Faktur_Pembelian_Ban.pdf');
    }
}