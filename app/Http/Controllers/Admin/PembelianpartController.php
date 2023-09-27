<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Supplier;
use App\Models\Sparepart;
use Illuminate\Http\Request;
use App\Models\Pembelian_ban;
use App\Models\Pembelian_part;
use App\Http\Controllers\Controller;
use App\Models\Detail_pembelianpart;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PembelianpartController extends Controller
{
    public function index()
    {
        if (auth()->check() && auth()->user()->menu['pembelian part']) {

            $pembelian_parts = Pembelian_part::all();
            $suppliers = Supplier::all();
            $spareparts = Sparepart::all();

            return view('admin.pembelian_part.index', compact('pembelian_parts', 'suppliers', 'spareparts'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function tabelpart()
    {
        $spareparts = Sparepart::all();
        return response()->json($spareparts);
    }

    // public function tabelpartmesin()
    // {
    //     $spareparts = Sparepart::where('kategori', 'mesin')->get();
    //     return response()->json($spareparts);
    // }


    public function create()
    {
        if (auth()->check() && auth()->user()->menu['pembelian part']) {

            $suppliers = Supplier::all();
            $spareparts = Sparepart::all();
            return view('admin/pembelian_part/create', compact('suppliers', 'spareparts'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
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
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
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

        return Redirect::back()->with('success', 'Berhasil menambahkan supplier');

        // return redirect('admin/pembelian_part/create')->with('success', 'Berhasil menambahkan supplier');
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

        if ($request->has('kategori')) {
            for ($i = 0; $i < count($request->kategori); $i++) {
                $validasi_produk = Validator::make($request->all(), [
                    'kategori.' . $i => 'required',
                    'kode_partdetail.' . $i => 'required',
                    'nama_barang.' . $i => 'required',
                    'satuan.' . $i => 'required',
                    'jumlah.' . $i => 'required',
                    'harga.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Pembelian ban nomor " . $i + 1 . " belum dilengkapi!");
                }


                $kategori = is_null($request->kategori[$i]) ? '' : $request->kategori[$i];
                $kode_partdetail = is_null($request->kode_partdetail[$i]) ? '' : $request->kode_partdetail[$i];
                $nama_barang = is_null($request->nama_barang[$i]) ? '' : $request->nama_barang[$i];
                $satuan = is_null($request->satuan[$i]) ? '' : $request->satuan[$i];
                $jumlah = is_null($request->kategori[$i]) ? '' : $request->jumlah[$i];
                $harga = is_null($request->harga[$i]) ? '' : $request->harga[$i];

                $data_pembelians->push(['kategori' => $kategori, 'kode_partdetail' => $kode_partdetail, 'nama_barang' => $nama_barang, 'satuan' => $satuan, 'jumlah' => $jumlah, 'harga' => $harga]);
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
        $transaksi = Pembelian_part::create([
            'kode_pembelianpart' => $this->kode(),
            'supplier_id' => $request->supplier_id,
            'tanggal' => $format_tanggal,
            'tanggal_awal' => $tanggal,
            'status' => 'posting',
            'status_notif' => false,
        ]);

        $transaksi_id = $transaksi->id;

        if ($transaksi) {
            foreach ($data_pembelians as $data_pesanan) {
                if (array_key_exists('kode_partdetail', $data_pesanan)) {
                    $kodePembelianPart = $data_pesanan['kode_partdetail'];

                    $spareparts = Sparepart::where('kode_partdetail', $kodePembelianPart)->get();

                    if ($spareparts->count() > 0) {
                        foreach ($spareparts as $sparepart) {
                            $jumlahLama = $sparepart->jumlah;

                            $jumlahBaru = $data_pesanan['jumlah'];

                            $jumlahTotal = $jumlahLama + $jumlahBaru;

                            $sparepart->update([
                                'pembelian_part_id' => $transaksi->id,
                                'jumlah' => $jumlahTotal,
                                'harga' => $data_pesanan['harga'],
                            ]);
                        }
                    }
                }
            }
        }


        if ($transaksi) {
            foreach ($data_pembelians as $data_pesanan) {
                if (array_key_exists('kode_partdetail', $data_pesanan)) {
                    $kodePembelianPart = $data_pesanan['kode_partdetail'];

                    // Cari Sparepart yang memiliki kode_partdetail yang sesuai
                    $sparepart = Sparepart::where('kode_partdetail', $kodePembelianPart)->first();

                    if ($sparepart) {
                        // Buat Detail_pembelianpart dan hubungkan dengan Sparepart yang sesuai
                        Detail_pembelianpart::create([
                            'pembelian_part_id' => $transaksi->id,
                            'sparepart_id' => $sparepart->id, // Mengambil sparepart_id dari hasil pencarian di atas
                            'tanggal_awal' => Carbon::now('Asia/Jakarta'),
                            'kategori' => $data_pesanan['kategori'],
                            'kode_partdetail' => $data_pesanan['kode_partdetail'],
                            'nama_barang' => $data_pesanan['nama_barang'],
                            'jumlah' => $data_pesanan['jumlah'],
                            'satuan' => $data_pesanan['satuan'],
                            'harga' => $data_pesanan['harga'],
                        ]);
                    }
                }
            }
        }

        $pembelians = Pembelian_part::find($transaksi_id);

        $parts = Detail_pembelianpart::where('pembelian_part_id', $pembelians->id)->get();

        return view('admin.pembelian_part.show', compact('parts', 'pembelians'));
    }

    public function kode()
    {
        $pembelian_part = Pembelian_part::all();
        if ($pembelian_part->isEmpty()) {
            $num = "000001";
        } else {
            $id = Pembelian_part::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'FS';
        $kode_pembelian_part = $data . $num;
        return $kode_pembelian_part;
    }

    public function tambah_sparepart(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'kategori' => 'required',
                'nama_barang' => 'required',
                'keterangan' => 'required',
                'harga' => 'required',
                'jumlah' => 'required',
                'satuan' => 'required',
            ],
            [
                'kategori.required' => 'Pilih kategori',
                'nama_barang.required' => 'Masukkan nama barang',
                'keterangan.required' => 'Masukkan keterangan',
                'harga.required' => 'Masukkan harga',
                'jumlah.required' => 'Masukkan stok',
                'satuan.required' => 'Masukkan satuan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return response()->json(['success' => false, 'message' => $error]);
        }

        $kode = '';
        if ($request->kategori === 'oli') {
            $kode = $this->kodeoli();
        } elseif ($request->kategori === 'mesin') {
            $kode = $this->kodemesin();
        } elseif ($request->kategori === 'body') {
            $kode = $this->kodebody();
        } elseif ($request->kategori === 'sasis') {
            $kode = $this->kodesasis();
        }

        Sparepart::create(array_merge(
            $request->all(),
            [
                'kode_partdetail' => $kode,
                'qrcode_barang' => 'https:///javaline.id/barang/' . $kode,
                'tanggal_awal' => Carbon::now('Asia/Jakarta'),
            ]
        ));

        return response()->json(['success' => true, 'message' => 'Sparepart berhasil ditambahkan']);
    }

    public function kodeoli()
    {
        $part = Sparepart::all();
        if ($part->isEmpty()) {
            $num = "000001";
        } else {
            $id = Sparepart::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'SO';
        $kode_part = $data . $num;
        return $kode_part;
    }

    public function kodebody()
    {
        $part = Sparepart::all();
        if ($part->isEmpty()) {
            $num = "000001";
        } else {
            $id = Sparepart::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'SB';
        $kode_part = $data . $num;
        return $kode_part;
    }

    public function kodemesin()
    {
        $part = Sparepart::all();
        if ($part->isEmpty()) {
            $num = "000001";
        } else {
            $id = Sparepart::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'SM';
        $kode_part = $data . $num;
        return $kode_part;
    }

    public function kodesasis()
    {
        $part = Sparepart::all();
        if ($part->isEmpty()) {
            $num = "000001";
        } else {
            $id = Sparepart::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'SS';
        $kode_part = $data . $num;
        return $kode_part;
    }

    public function kodesparepart()
    {
        $part = Sparepart::all();
        if ($part->isEmpty()) {
            $num = "000001";
        } else {
            $id = Sparepart::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'A0';
        $kode_part = $data . $num;
        return $kode_part;
    }

    public function sparepart($id)
    {
        $sparepart = Sparepart::where('id', $id)->first();

        return json_decode($sparepart);
    }

    public function show($id)
    {
        if (auth()->check() && auth()->user()->menu['pembelian part']) {

            $pembelian_part = Pembelian_part::find($id);
            $parts = Detail_pembelianpart::where('pembelian_part_id', $pembelian_part->id)->get();


            $pembelians = Pembelian_part::where('id', $id)->first();

            return view('admin.pembelian_part.show', compact('parts', 'pembelians'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function cetakpdf($id)
    {
        if (auth()->check() && auth()->user()->menu['pembelian part']) {

            $pembelians = Pembelian_part::find($id);
            $parts = Detail_pembelianpart::where('pembelian_part_id', $pembelians->id)->get();

            // Load the view and set the paper size to portrait letter
            $pembelianbans = Pembelian_part::where('id', $id)->first();
            $pdf = PDF::loadView('admin.pembelian_part.cetak_pdf', compact('parts', 'pembelians', 'pembelianbans'));
            $pdf->setPaper('letter', 'portrait'); // Set the paper size to portrait letter

            return $pdf->stream('Faktur_Pembelian_Ban.pdf');
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }
}