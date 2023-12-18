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
use App\Models\Biaya_tambahan;
use App\Models\Detail_faktur;
use App\Models\Detail_memo;
use App\Models\Detail_memotambahan;
use App\Models\Detail_tariftambahan;
use App\Models\Faktur_ekspedisi;
use App\Models\Kendaraan;
use App\Models\Memo_ekspedisi;
use App\Models\Memo_tambahan;
use App\Models\Memotambahan;
use App\Models\Pelanggan;
use App\Models\Penerimaan_kaskecil;
use App\Models\Potongan_memo;
use App\Models\nama_rute;
use App\Models\Saldo;
use App\Models\Tarif;
use App\Models\Typeban;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class FakturekspedisiController extends Controller
{
    public function index()
    {
        $pelanggans = Pelanggan::all();
        $memos = Memo_ekspedisi::all();
        $tarifs = Tarif::all();

        return view('admin.faktur_ekspedisi.index', compact('pelanggans', 'memos', 'tarifs'));
    }

    public function store(Request $request)
    {
        $validasi_pelanggan = Validator::make(
            $request->all(),
            [
                'kategori' => 'required',
                'pelanggan_id' => 'required',
                'tarif_id' => 'required',
                'jumlah' => 'required',
                'satuan' => 'required',
            ],
            [
                'kategori.required' => 'Pilih kategori',
                'pelanggan_id.required' => 'Pilih Pelanggan',
                'tarif_id.required' => 'Pilih Tarif',
                'jumlah.required' => 'Masukkan jumlah',
                'satuan.required' => 'Pilih satuan',
            ]
        );

        $error_pelanggans = array();

        if ($validasi_pelanggan->fails()) {
            array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
        }

        $error_pesanans = array();
        $data_pembelians = collect();
        $data_pembelians4 = collect();

        if ($request->has('memo_ekspedisi_id')) {
            for ($i = 0; $i < count($request->memo_ekspedisi_id); $i++) {
                $validasi_produk = Validator::make($request->all(), [
                    'memo_ekspedisi_id.' . $i => 'required',
                    'kode_memo.' . $i => 'required',
                    'nama_driver.' . $i => 'required',
                    'nama_rute.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Memo nomor " . ($i + 1) . " belum dilengkapi!"); // Corrected the syntax for concatenation and indexing
                }

                $memo_ekspedisi_id = is_null($request->memo_ekspedisi_id[$i]) ? '' : $request->memo_ekspedisi_id[$i];
                $kode_memo = is_null($request->kode_memo[$i]) ? '' : $request->kode_memo[$i];
                $nama_driver = is_null($request->nama_driver[$i]) ? '' : $request->nama_driver[$i];
                $telp_driver = is_null($request->telp_driver[$i]) ? '' : $request->telp_driver[$i];
                $nama_rute = is_null($request->nama_rute[$i]) ? '' : $request->nama_rute[$i];
                $kendaraan_id = is_null($request->kendaraan_id[$i]) ? '' : $request->kendaraan_id[$i];
                $no_kabin = is_null($request->no_kabin[$i]) ? '' : $request->no_kabin[$i];

                $data_pembelians->push([
                    'memo_ekspedisi_id' => $memo_ekspedisi_id,
                    'kode_memo' => $kode_memo,
                    'nama_driver' => $nama_driver,
                    'telp_driver' => $telp_driver,
                    'nama_rute' => $nama_rute,
                    'kendaraan_id' => $kendaraan_id,
                    'no_kabin' => $no_kabin
                ]);
            }
        }

        if ($request->has('keterangan_tambahan') || $request->has('nominal_tambahan')) {
            for ($i = 0; $i < count($request->keterangan_tambahan); $i++) {
                // Check if either 'keterangan_tambahan' or 'nominal_tambahan' has input
                if (empty($request->keterangan_tambahan[$i]) && empty($request->nominal_tambahan[$i])) {
                    continue; // Skip validation if both are empty
                }

                $validasi_produk = Validator::make($request->all(), [
                    'keterangan_tambahan.' . $i => 'required',
                    'nominal_tambahan.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Biaya tambahan nomor " . ($i + 1) . " belum dilengkapi!");
                }

                $keterangan_tambahan = $request->keterangan_tambahan[$i] ?? '';
                $nominal_tambahan = $request->nominal_tambahan[$i] ?? '';

                $data_pembelians4->push(['keterangan_tambahan' => $keterangan_tambahan, 'nominal_tambahan' => $nominal_tambahan]);
            }
        }

        if ($error_pelanggans || $error_pesanans) {
            return back()
                ->withInput()
                ->with('error_pelanggans', $error_pelanggans)
                ->with('error_pesanans', $error_pesanans)
                ->with('data_pembelians', $data_pembelians)
                ->with('data_pembelians4', $data_pembelians4);
        }

        $kode = $this->kode();
        // format tanggal indo
        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');

        $tanggal = Carbon::now()->format('Y-m-d');
        $cetakpdf = Faktur_ekspedisi::create([
            'user_id' => auth()->user()->id,
            'kode_faktur' => $this->kode(),
            'kategori' => $request->kategori,
            'tarif_id' => $request->tarif_id,
            'pph' => $request->pph,
            'pelanggan_id' => $request->pelanggan_id,
            'kode_pelanggan' => $request->kode_pelanggan,
            'nama_pelanggan' => $request->nama_pelanggan,
            'alamat_pelanggan' => $request->alamat_pelanggan,
            'telp_pelanggan' => $request->telp_pelanggan,
            'kode_tarif' => $request->kode_tarif,
            'nama_tarif' => $request->nama_tarif,
            'harga_tarif' => $request->harga_tarif,
            'jumlah' => $request->jumlah,
            'satuan' => $request->satuan,
            'total_tarif' => $request->total_tarif,
            'grand_total' => $request->sub_total,
            'sisa' => $request->sisa,
            'biaya_tambahan' => $request->biaya_tambahan,
            'keterangan' => $request->keterangan,
            'tanggal' => $format_tanggal,
            'tanggal_awal' => $tanggal,
            'qrcode_faktur' => 'https://javaline.id/faktur_ekspedisi/' . $kode,
            'status' => 'posting',
            'status_notif' => false,
        ]);

        $transaksi_id = $cetakpdf->id;

        if ($cetakpdf) {

            foreach ($data_pembelians as $data_pesanan) {
                Detail_faktur::create([
                    'faktur_ekspedisi_id' => $cetakpdf->id,
                    'memo_ekspedisi_id' => $data_pesanan['memo_ekspedisi_id'],
                    'kode_memo' => $data_pesanan['kode_memo'],
                    'nama_driver' => $data_pesanan['nama_driver'],
                    'nama_rute' => $data_pesanan['nama_rute'],
                    'telp_driver' => $data_pesanan['telp_driver'],
                    'kendaraan_id' => $data_pesanan['kendaraan_id'],
                    'no_kabin' => $data_pesanan['no_kabin'],
                ]);
            }
        }

        if ($cetakpdf) {

            foreach ($data_pembelians4 as $data_pesanan) {
                Detail_tariftambahan::create([
                    'faktur_ekspedisi_id' => $cetakpdf->id,
                    'keterangan_tambahan' => $data_pesanan['keterangan_tambahan'],
                    'nominal_tambahan' => $data_pesanan['nominal_tambahan'],
                ]);
            }
        }

        $details = Detail_faktur::where('faktur_ekspedisi_id', $cetakpdf->id)->get();
        $detailtarifs = Detail_tariftambahan::where('faktur_ekspedisi_id', $cetakpdf->id)->get();

        return view('admin.faktur_ekspedisi.show', compact('cetakpdf', 'details', 'detailtarifs'));
    }


    public function kode()
    {
        $item = Faktur_ekspedisi::all();
        if ($item->isEmpty()) {
            $num = "000001";
        } else {
            $id = Faktur_ekspedisi::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'FE';
        $kode_item = $data . $num;
        return $kode_item;
    }


    public function show($id)
    {
        $cetakpdf = Faktur_ekspedisi::where('id', $id)->first();

        return view('admin.memo_ekspedisi.show', compact('cetakpdf'));
    }

    public function cetakpdf($id)
    {
        $cetakpdf = Faktur_ekspedisi::where('id', $id)->first();
        $details = Detail_faktur::where('faktur_ekspedisi_id', $cetakpdf->id)->get();
        $detailtarifs = Detail_tariftambahan::where('faktur_ekspedisi_id', $cetakpdf->id)->get();


        $pdf = PDF::loadView('admin.faktur_ekspedisi.cetak_pdf', compact('cetakpdf', 'details', 'detailtarifs'));
        $pdf->setPaper('letter', 'portrait'); // Set the paper size to portrait letter

        return $pdf->stream('Faktur_ekspedisi.pdf');
    }
}