<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Detail_penjualan;
use App\Models\Nota_return;
use App\Models\Faktur_penjualanreturn;
use Illuminate\Support\Facades\Validator;

class FakturpenjualanreturnController extends Controller
{
    public function index()
    {
        $barangs = Barang::all();
        $notas = Nota_return::all();

        return view('admin.faktur_penjualanreturn.index', compact('barangs', 'notas'));
    }

    public function store(Request $request)
    {
        $validasi_pelanggan = Validator::make(
            $request->all(),
            [
                'nota_return_id' => 'required',
            ],
            [
                'nota_return_id.required' => 'Pilih Nota',
            ]
        );

        $error_pelanggans = array();
        if ($validasi_pelanggan->fails()) {
            array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
        }

        $error_pesanans = array();
        $data_pembelians = collect();


        if ($request->has('barang_id')) {
            for ($i = 0; $i < count($request->barang_id); $i++) {
                $validasi_produk = Validator::make($request->all(), [
                    'barang_id.' . $i => 'required',
                    'kode_barang.' . $i => 'required',
                    'nama_barang.' . $i => 'required',
                    'satuan.' . $i => 'required',
                    'harga_beli.' . $i => 'required',
                    'harga_jual.' . $i => 'required',
                    'jumlah.' . $i => 'required',
                    'diskon.' . $i => 'required',
                    'total.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Barang nomor " . ($i + 1) . " belum dilengkapi!"); // Corrected the syntax for concatenation and indexing
                }

                $barang_id = is_null($request->barang_id[$i]) ? '' : $request->barang_id[$i];
                $kode_barang = is_null($request->kode_barang[$i]) ? '' : $request->kode_barang[$i];
                $nama_barang = is_null($request->nama_barang[$i]) ? '' : $request->nama_barang[$i];
                $satuan = is_null($request->satuan[$i]) ? '' : $request->satuan[$i];
                $harga_beli = is_null($request->harga_beli[$i]) ? '' : $request->harga_beli[$i];
                $harga_jual = is_null($request->harga_jual[$i]) ? '' : $request->harga_jual[$i];
                $jumlah = is_null($request->jumlah[$i]) ? '' : $request->jumlah[$i];
                $diskon = is_null($request->diskon[$i]) ? '' : $request->diskon[$i];
                $total = is_null($request->total[$i]) ? '' : $request->total[$i];

                $data_pembelians->push([
                    'barang_id' => $barang_id,
                    'kode_barang' => $kode_barang,
                    'nama_barang' => $nama_barang,
                    'satuan' => $satuan,
                    'harga_beli' => $harga_beli,
                    'harga_jual' => $harga_jual,
                    'jumlah' => $jumlah,
                    'diskon' => $diskon,
                    'total' => $total
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

        $kode = $this->kode();
        // format tanggal indo
        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');

        $tanggal = Carbon::now()->format('Y-m-d');
        $cetakpdf = Faktur_penjualanreturn::create([
            'admin' => auth()->user()->karyawan->nama_lengkap,
            'kode_penjualan' => $this->kode(),
            'nota_return_id' => $request->nota_return_id,
            'kode_nota' => $request->kode_nota,
            'pelanggan_id' => $request->pelanggan_id,
            'kode_pelanggan' => $request->kode_pelanggan,
            'nama_pelanggan' => $request->nama_pelanggan,
            'alamat_pelanggan' => $request->alamat_pelanggan,
            'telp_pelanggan' => $request->telp_pelanggan,
            'keterangan' => $request->keterangan,
            'grand_total' => str_replace(',', '.', str_replace('.', '', $request->grand_total)),
            'tanggal' => $format_tanggal,
            'tanggal_awal' => $tanggal,
            'qrcode_penjualan' => 'https://javaline.id/faktur_penjualanreturn/' . $kode,
            'status' => 'posting',
            'status_notif' => false,
        ]);

        $transaksi_id = $cetakpdf->id;

        if ($cetakpdf) {
            foreach ($data_pembelians as $data_pesanan) {
                $sparepart = Barang::find($data_pesanan['barang_id']);
                if ($sparepart) {
                    $jumlah_sparepart = $sparepart->jumlah - $data_pesanan['jumlah'];
                    $sparepart->update(['jumlah' => $jumlah_sparepart]);
                    Detail_penjualan::create([
                        'faktur_penjualanreturn_id' => $cetakpdf->id,
                        'barang_id' => $data_pesanan['barang_id'],
                        'kode_barang' => $data_pesanan['kode_barang'],
                        'nama_barang' => $data_pesanan['nama_barang'],
                        'jumlah' => $data_pesanan['jumlah'],
                        'satuan' => $data_pesanan['satuan'],
                        'harga_beli' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['harga_beli'])),
                        'harga_jual' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['harga_jual'])),
                        'diskon' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['diskon'])),
                        'total' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['total'])),
                    ]);
                }
            }
        }

        $details = Detail_penjualan::where('faktur_penjualanreturn_id', $cetakpdf->id)->get();

        return view('admin.faktur_penjualanreturn.show', compact('cetakpdf', 'details'));
    }

    public function kode()
    {
        $lastBarang = Faktur_penjualanreturn::latest()->first();
        if (!$lastBarang) {
            $num = 1;
        } else {
            $lastCode = $lastBarang->kode_penjualan;
            $num = (int) substr($lastCode, strlen('PR')) + 1;
        }
        $formattedNum = sprintf("%06s", $num);
        $prefix = 'PR';
        $newCode = $prefix . $formattedNum;
        return $newCode;
    }

    public function show($id)
    {
        $cetakpdf = Faktur_penjualanreturn::where('id', $id)->first();
        return view('admin.faktur_penjualanreturn.show', compact('cetakpdf'));
    }

    public function cetakpdf($id)
    {
        $cetakpdf = Faktur_penjualanreturn::where('id', $id)->first();
        $details = Detail_penjualan::where('faktur_penjualanreturn_id', $cetakpdf->id)->get();
        $pdf = PDF::loadView('admin.faktur_penjualanreturn.cetak_pdf', compact('cetakpdf', 'details'));
        $pdf->setPaper('letter', 'portrait');
        return $pdf->stream('Faktur_penjualan_return.pdf');
    }
}