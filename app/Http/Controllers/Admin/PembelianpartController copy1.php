<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
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
                'nama_person' => 'required',
                'jabatan' => 'required',
                'fax' => 'required',
                'telp' => 'required',
                'hp' => 'required',
                'email' => 'required',
                'npwp' => 'required',
                'nama_bank' => 'required',
                'atas_nama' => 'required',
                'norek' => 'required',
            ],
            [
                'nama_supp.required' => 'Masukkan nama supplier',
                'alamat.required' => 'Masukkan Alamat',
                'nama_person.required' => 'Masukkan nama',
                'jabatan.required' => 'Masukkan jabatan',
                'telp.required' => 'Masukkan no telepon',
                'fax.required' => 'Masukkan no fax',
                'hp.required' => 'Masukkan no hp',
                'email.required' => 'Masukkan email',
                'npwp.required' => 'Masukkan no npwp',
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

        if (is_array($request->kategori)) {
            for ($i = 0; $i < count($request->kategori); $i++) {
                $validasi_produk = Validator::make($request->all(), [
                    'kategori.' . $i => 'required',
                    'kode_pembelianpart.' . $i => 'required',
                    'nama_barang.' . $i => 'required',
                    'satuan.' . $i => 'required',
                    'jumlah.' . $i => 'required',
                    'harga.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Pembelian part nomor " . $i + 1 . " belum dilengkapi!");
                }

                $kategori = is_null($request->kategori[$i]) ? '' : $request->kategori[$i];
                $kode_pembelianpart = is_null($request->kode_pembelianpart[$i]) ? '' : $request->kode_pembelianpart[$i];
                $nama_barang = is_null($request->nama_barang[$i]) ? '' : $request->nama_barang[$i];
                $satuan = is_null($request->satuan[$i]) ? '' : $request->satuan[$i];
                $jumlah = is_null($request->jumlah[$i]) ? '' : $request->jumlah[$i];
                $harga = is_null($request->harga[$i]) ? '' : $request->harga[$i];

                $data_pembelians->push(['kategori' => $kategori, 'nama_barang' => $nama_barang, 'kode_pembelianpart' => $kode_pembelianpart, 'jumlah' => $jumlah, 'harga' => $harga]);
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

        $tanggal = Carbon::now()->format('Y-m-d');
        $transaksi = Pembelian_part::create([
            'kode_barang' => $this->kode(),
            'supplier_id' => $request->supplier_id,
            'tanggal_awal' => $tanggal,
            'status' => 'posting',
            'status_notif' => false,

        ]);

        $transaksi_id = $transaksi->id;

        if ($transaksi) {
            foreach ($data_pembelians as $data_pesanan) {
                // Check if 'kode_pembelianpart' key exists in the array
                if (array_key_exists('kode_pembelianpart', $data_pesanan)) {
                    $kodePembelianPart = $data_pesanan['kode_pembelianpart'];

                    // Check if the record with the provided 'kode_pembelianpart' exists in the database
                    $sparepart = Sparepart::where('kode_partdetail', $kodePembelianPart)->first();

                    if ($sparepart) {
                        // Update the record
                        $sparepart->update([
                            'jumlah' => $data_pesanan['jumlah'],
                            'harga' => $data_pesanan['harga'],
                        ]);
                    }
                }
            }
        }

        $pembelians = Pembelian_part::find($transaksi_id);

        $parts = Sparepart::where('pembelian_part_id', $pembelians->id)->get();

        return view('admin.pembelian_part.show', compact('parts', 'pembelians'));
        // return redirect('admin/pembelian_ban/show')->with('success', 'Berhasil menambahkan Pembelian ban');
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

    public function kodepart()
    {
        $ban = Detail_pembelianpart::all();
        if ($ban->isEmpty()) {
            $num = "000001";
        } else {
            $id = Detail_pembelianpart::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'FSB';
        $kode_part = $data . $num;
        return $kode_part;
    }

    public function tambah_sparepart(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_barang' => 'required',
                'keterangan' => 'required',
                'harga_jual' => 'required',
                'tersedia' => 'required',
                // 'satuan' => 'required',
            ],
            [
                'nama_barang.required' => 'Masukkan nama barang',
                'keterangan.required' => 'Masukkan keterangan',
                'harga_jual.required' => 'Masukkan harga jual',
                'tersedia.required' => 'Masukkan tersedia',
                // 'satuan.required' => 'Masukkan satuan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }
        $kode = $this->kodesparepart();

        Sparepart::create(array_merge(
            $request->all(),
            [
                'kode_barang' => $kode,
                // 'qrcode_barang' => 'http://192.168.1.46/javaline/barang/' . $kode
                'qrcode_barang' => 'https:///javaline.id/barang/' . $kode,
                'tanggal_awal' => Carbon::now('Asia/Jakarta'),
            ],
        ));

        return Redirect::back()->with('success', 'Berhasil menambahkan part');

        // return redirect('admin/pembelian_part/create')->with('success', 'Berhasil menambahkan part');
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
        $pembelians = Pembelian_part::where('id', $id)->first();
        $pembelian_part = Pembelian_part::find($id);

        $parts = Sparepart::where('pembelian_part_id', $pembelian_part->id)->get();

        return view('admin.pembelian_part.show', compact('parts', 'pembelians'));
    }

    public function cetakpdf($id)
    {
        $pembelians = Pembelian_part::find($id);

        $parts = Detail_pembelianpart::where('pembelian_part_id', $pembelians->id)->get();
        $html = view('admin/pembelian_part.cetak_pdf', compact('parts', 'pembelians'));

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        // $dompdf->setPaper('A4', 'landscape');

        $dompdf->setPaper('A4', 'portrait');
        // $dompdf->setPaper('A4', 'landscape')->set_option('enable_php', true);
        $dompdf->render();

        $dompdf->stream();
    }
}