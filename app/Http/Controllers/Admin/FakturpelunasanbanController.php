<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Detail_pelunasanban;
use App\Models\Detail_return;
use App\Models\Faktur_pelunasanban;
use App\Models\Nota_return;
use App\Models\Pelanggan;
use App\Models\Pembelian_ban;
use App\Models\Return_ekspedisi;
use App\Models\Supplier;
use App\Models\Tarif;
use Illuminate\Support\Facades\Validator;

class FakturpelunasanbanController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();
        $fakturs = Pembelian_ban::where(['status_pelunasan' => null, 'status' => 'posting'])->get();

        return view('admin.faktur_pelunasanban.index', compact('suppliers', 'fakturs'));
    }

    public function store(Request $request)
    {
        $validasi_pelanggan = Validator::make(
            $request->all(),
            [
                'supplier_id' => 'required',
                'pembelian_ban_id' => 'required',
            ],
            [
                'supplier_id.required' => 'Pilih Supplier',
                'pembelian_ban_id.required' => 'Pilih Faktur Pembelian Ban',
            ]
        );

        $error_pelanggans = array();

        if ($validasi_pelanggan->fails()) {
            array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
        }

        $error_pesanans = array();
        $data_pembelians = collect();

        if ($request->has('pembelian_ban_id')) {
            for ($i = 0; $i < count($request->pembelian_ban_id); $i++) {
                $validasi_produk = Validator::make($request->all(), [
                    'pembelian_ban_id.' . $i => 'required',
                    'kode_pembelian_ban.' . $i => 'required',
                    'tanggal_pembelian.' . $i => 'required',
                    'total.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Faktur nomor " . ($i + 1) . " belum dilengkapi!"); // Corrected the syntax for concatenation and indexing
                }
                $pembelian_ban_id = is_null($request->pembelian_ban_id[$i]) ? '' : $request->pembelian_ban_id[$i];
                $kode_pembelian_ban = is_null($request->kode_pembelian_ban[$i]) ? '' : $request->kode_pembelian_ban[$i];
                $tanggal_pembelian = is_null($request->tanggal_pembelian[$i]) ? '' : $request->tanggal_pembelian[$i];
                $total = is_null($request->total[$i]) ? '' : $request->total[$i];

                $data_pembelians->push([
                    'pembelian_ban_id' => $pembelian_ban_id,
                    'kode_pembelian_ban' => $kode_pembelian_ban,
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
        $cetakpdf = Faktur_pelunasanban::create([
            'user_id' => auth()->user()->id,
            'kode_pelunasanban' => $this->kode(),
            'supplier_id' => $request->supplier_id,
            'kode_supplier' => $request->kode_supplier,
            'nama_supplier' => $request->nama_supplier,
            'alamat_supplier' => $request->alamat_supplier,
            'telp_supplier' => $request->telp_supplier,
            'keterangan' => $request->keterangan,
            // 'totalpenjualan' => str_replace('.', '', $request->totalpenjualan),
            'totalpenjualan' => str_replace(',', '.', str_replace('.', '', $request->totalpenjualan)),
            // 'dp' => str_replace('.', '', $request->dp),
            'dp' => str_replace(',', '.', str_replace('.', '', $request->dp)),
            // 'potonganselisih' => str_replace('.', '', $request->potonganselisih),
            'potonganselisih' => str_replace(',', '.', str_replace('.', '', $request->potonganselisih)),
            // 'totalpembayaran' => (int)str_replace(['Rp', '.', ' '], '', $request->totalpembayaran),
            'totalpembayaran' => str_replace(',', '.', str_replace('.', '', $request->totalpembayaran)),
            // 'selisih' => (int)str_replace(['Rp', '.', ' '], '', $request->selisih),
            'selisih' => str_replace(',', '.', str_replace('.', '', $request->selisih)),
            // 'potongan' => $request->potongan ? str_replace('.', '', $request->potongan) : 0,
            'potongan' => $request->potongan ? str_replace(',', '.', str_replace('.', '', $request->potongan)) : 0,
            // 'tambahan_pembayaran' => $request->tambahan_pembayaran ? str_replace('.', '', $request->tambahan_pembayaran) : 0,
            'tambahan_pembayaran' => $request->tambahan_pembayaran ? str_replace(',', '.', str_replace('.', '', $request->tambahan_pembayaran)) : 0,

            'kategori' => $request->kategori,
            'nomor' => $request->nomor,
            'tanggal_transfer' => $request->tanggal_transfer,
            // 'nominal' => str_replace('.', '', $request->nominal),
            'nominal' =>  $request->nominal ? str_replace(',', '.', str_replace('.', '', $request->nominal)) : 0,
            'tanggal' => $format_tanggal,
            'tanggal_awal' => $tanggal,
            'qrcode_pelunasanban' => 'https://javaline.id/faktur_pelunasanban/' . $kode,
            'status' => 'posting',
            'status_notif' => false,
        ]);

        $transaksi_id = $cetakpdf->id;

        foreach ($data_pembelians as $data_pesanan) {
            $detailPelunasan = Detail_pelunasanban::create([
                'faktur_pelunasanban_id' => $cetakpdf->id,
                'status' => 'posting',
                'pembelian_ban_id' => $data_pesanan['pembelian_ban_id'],
                'kode_pembelian_ban' => $data_pesanan['kode_pembelian_ban'],
                'tanggal_pembelian' => $data_pesanan['tanggal_pembelian'],
                'total' => str_replace(',', '.', str_replace('.', '', $data_pesanan['total'])),
            ]);

            // Assuming the status_pelunasan update is correct
            Pembelian_ban::where('id', $detailPelunasan->pembelian_ban_id)->update(['status' => 'selesai', 'status_pelunasan' => 'aktif']);
        }


        $details = Detail_pelunasanban::where('faktur_pelunasanban_id', $cetakpdf->id)->get();

        return view('admin.faktur_pelunasanban.show', compact('cetakpdf', 'details'));
    }


    // public function kode()
    // {
    //     $item = Faktur_pelunasanban::all();
    //     if ($item->isEmpty()) {
    //         $num = "000001";
    //     } else {
    //         $id = Faktur_pelunasanban::getId();
    //         foreach ($id as $value);
    //         $idlm = $value->id;
    //         $idbr = $idlm + 1;
    //         $num = sprintf("%06s", $idbr);
    //     }

    //     $data = 'LB';
    //     $kode_item = $data . $num;
    //     return $kode_item;
    // }

    public function kode()
    {
        $lastBarang = Faktur_pelunasanban::latest()->first();
        if (!$lastBarang) {
            $num = 1;
        } else {
            $lastCode = $lastBarang->kode_pelunasanban;
            $num = (int) substr($lastCode, strlen('LB')) + 1;
        }
        $formattedNum = sprintf("%06s", $num);
        $prefix = 'LB';
        $newCode = $prefix . $formattedNum;
        return $newCode;
    }

    public function show($id)
    {
        $cetakpdf = Faktur_pelunasanban::where('id', $id)->first();

        return view('admin.faktur_pelunasanban.show', compact('cetakpdf'));
    }

    public function cetakpdf($id)
    {
        $cetakpdf = Faktur_pelunasanban::where('id', $id)->first();
        $details = Detail_pelunasanban::where('faktur_pelunasanban_id', $cetakpdf->id)->get();

        $pdf = PDF::loadView('admin.faktur_pelunasanban.cetak_pdf', compact('cetakpdf', 'details'));
        $pdf->setPaper('letter', 'portrait'); // Set the paper size to portrait letter

        return $pdf->stream('Faktur_Pelunasan.pdf');
    }
}