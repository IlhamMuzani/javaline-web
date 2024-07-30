<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Detail_pelunasanpart;
use App\Models\Faktur_pelunasanpart;
use App\Models\Pembelian_part;
use App\Models\Supplier;
use Illuminate\Support\Facades\Validator;

class FakturpelunasanpartController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();
        $fakturs = Pembelian_part::where(['status_pelunasan' => null, 'status' => 'posting'])->get();
        return view('admin.faktur_pelunasanpart.index', compact('suppliers', 'fakturs'));
    }

    public function store(Request $request)
    {
        $validasi_pelanggan = Validator::make(
            $request->all(),
            [
                'supplier_id' => 'required',
                'pembelian_part_id' => 'required',
            ],
            [
                'supplier_id.required' => 'Pilih Supplier',
                'pembelian_part_id.required' => 'Pilih Faktur Pembelian Part',
            ]
        );

        $error_pelanggans = array();

        if ($validasi_pelanggan->fails()) {
            array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
        }

        $error_pesanans = array();
        $data_pembelians = collect();

        if ($request->has('pembelian_part_id')) {
            for ($i = 0; $i < count($request->pembelian_part_id); $i++) {
                $validasi_produk = Validator::make($request->all(), [
                    'pembelian_part_id.' . $i => 'required',
                    'kode_pembelianpart.' . $i => 'required',
                    'tanggal_pembelian.' . $i => 'required',
                    'total.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Faktur nomor " . ($i + 1) . " belum dilengkapi!"); // Corrected the syntax for concatenation and indexing
                }
                $pembelian_part_id = is_null($request->pembelian_part_id[$i]) ? '' : $request->pembelian_part_id[$i];
                $kode_pembelianpart = is_null($request->kode_pembelianpart[$i]) ? '' : $request->kode_pembelianpart[$i];
                $tanggal_pembelian = is_null($request->tanggal_pembelian[$i]) ? '' : $request->tanggal_pembelian[$i];
                $total = is_null($request->total[$i]) ? '' : $request->total[$i];

                $data_pembelians->push([
                    'pembelian_part_id' => $pembelian_part_id,
                    'kode_pembelianpart' => $kode_pembelianpart,
                    'tanggal_pembelian' => $tanggal_pembelian,
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

        $selisih = (int)str_replace(['Rp', '.', ' '], '', $request->selisih);
        $totalpembayaran = (int)str_replace(['Rp', '.', ' '], '', $request->totalpembayaran);
        $tanggal = Carbon::now()->format('Y-m-d');
        $cetakpdf = Faktur_pelunasanpart::create([
            'user_id' => auth()->user()->id,
            'kode_pelunasanpart' => $this->kode(),
            'supplier_id' => $request->supplier_id,
            'kode_supplier' => $request->kode_supplier,
            'nama_supplier' => $request->nama_supplier,
            'alamat_supplier' => $request->alamat_supplier,
            'telp_supplier' => $request->telp_supplier,
            'keterangan' => $request->keterangan,
            'totalpenjualan' => str_replace(',', '.', str_replace('.', '', $request->totalpenjualan)),
            'dp' => str_replace(',', '.', str_replace('.', '', $request->dp)),
            'potonganselisih' => str_replace(',', '.', str_replace('.', '', $request->potonganselisih)),
            'totalpembayaran' => str_replace(',', '.', str_replace('.', '', $request->totalpembayaran)),
            'selisih' => str_replace(',', '.', str_replace('.', '', $request->selisih)),
            'potongan' => $request->potongan ? str_replace(',', '.', str_replace('.', '', $request->potongan)) : 0,
            'tambahan_pembayaran' => $request->tambahan_pembayaran ? str_replace(',', '.', str_replace('.', '', $request->tambahan_pembayaran)) : 0,
            'kategori' => $request->kategori,
            'nomor' => $request->nomor,
            'tanggal_transfer' => $request->tanggal_transfer,
            'nominal' =>  $request->nominal ? str_replace(',', '.', str_replace('.', '', $request->nominal)) : 0,
            'tanggal' => $format_tanggal,
            'tanggal_awal' => $tanggal,
            'qrcode_pelunasanpart' => 'https://javaline.id/faktur_pelunasanpart/' . $kode,
            'status' => 'posting',
            'status_notif' => false,
        ]);

        $transaksi_id = $cetakpdf->id;

        foreach ($data_pembelians as $data_pesanan) {
            $detailPelunasan = Detail_pelunasanpart::create([
                'faktur_pelunasanpart_id' => $cetakpdf->id,
                'status' => 'unpost',
                'pembelian_part_id' => $data_pesanan['pembelian_part_id'],
                'kode_pembelianpart' => $data_pesanan['kode_pembelianpart'],
                'tanggal_pembelian' => $data_pesanan['tanggal_pembelian'],
                'total' => str_replace(',', '.', str_replace('.', '', $data_pesanan['total'])),
            ]);
            Pembelian_part::where('id', $detailPelunasan->pembelian_part_id)->update(['status' => 'selesai', 'status_pelunasan' => 'aktif']);
        }


        $details = Detail_pelunasanpart::where('faktur_pelunasanpart_id', $cetakpdf->id)->get();

        return view('admin.faktur_pelunasanpart.show', compact('cetakpdf', 'details'));
    }

    public function kode()
    {
        $lastBarang = Faktur_pelunasanpart::latest()->first();
        if (!$lastBarang) {
            $num = 1;
        } else {
            $lastCode = $lastBarang->kode_pelunasanpart;
            $num = (int) substr($lastCode, strlen('LS')) + 1;
        }
        $formattedNum = sprintf("%06s", $num);
        $prefix = 'LS';
        $newCode = $prefix . $formattedNum;
        return $newCode;
    }

    public function show($id)
    {
        $cetakpdf = Faktur_pelunasanpart::where('id', $id)->first();
        return view('admin.faktur_pelunasanpart.show', compact('cetakpdf'));
    }

    public function cetakpdf($id)
    {
        $cetakpdf = Faktur_pelunasanpart::where('id', $id)->first();
        $details = Detail_pelunasanpart::where('faktur_pelunasanpart_id', $cetakpdf->id)->get();
        $pdf = PDF::loadView('admin.faktur_pelunasanpart.cetak_pdf', compact('cetakpdf', 'details'));
        $pdf->setPaper('letter', 'portrait');
        return $pdf->stream('Faktur_Pelunasan.pdf');
    }
}