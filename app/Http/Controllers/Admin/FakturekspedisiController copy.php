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
use App\Models\Rute_perjalanan;
use App\Models\Saldo;
use App\Models\Typeban;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class FakturekspedisiController extends Controller
{
    public function index()
    {
        $pelanggans = Pelanggan::all();

        return view('admin.faktur_ekspedisi.index', compact('pelanggans'));
    }

    public function store(Request $request)
    {
        $validasi_pelanggan = Validator::make(
            $request->all(),
            [
                'kategori' => 'required',
                'pelanggan_id' => 'required',
                // 'tarif_id' => 'required',
            ],
            [
                'kategori.required' => 'Pilih kategori',
                'pelanggan_id.required' => 'Pilih Pelanggan',
                // 'tarif_id.required' => 'Pilih Tarif',
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
                    'rute_perjalanan.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Memo nomor " . ($i + 1) . " belum dilengkapi!"); // Corrected the syntax for concatenation and indexing
                }

                $memo_ekspedisi_id = is_null($request->memo_ekspedisi_id[$i]) ? '' : $request->memo_ekspedisi_id[$i];
                $kode_memo = is_null($request->kode_memo[$i]) ? '' : $request->kode_memo[$i];
                $nama_driver = is_null($request->nama_driver[$i]) ? '' : $request->nama_driver[$i];
                $rute_perjalanan = is_null($request->rute_perjalanan[$i]) ? '' : $request->rute_perjalanan[$i];

                $data_pembelians->push(['memo_ekspedisi_id' => $memo_ekspedisi_id, 'kode_memo' => $kode_memo, 'nama_driver' => $nama_driver, 'rute_perjalanan' => $rute_perjalanan]);
            }
        }

        if ($request->has('keterangan_tambahan')) {
            for ($i = 0; $i < count($request->keterangan_tambahan); $i++) {
                $keterangan_tambahan = $request->input('keterangan_tambahan.' . $i, null);
                $nominal_tambahan = $request->input('nominal_tambahan.' . $i, null);

                // If 'biaya_id' is not null, validate and process the data
                if (!is_null($keterangan_tambahan)) {
                    $validasi_produk = Validator::make([
                        'keterangan_tambahan' => $keterangan_tambahan,
                        'nominal_tambahan' => $nominal_tambahan,
                    ], [
                        'keterangan_tambahan' => 'required',
                        'nominal_tambahan' => 'required',
                    ]);

                    if ($validasi_produk->fails()) {
                        array_push($error_pesanans, "Tambahan biaya nomor " . ($i + 1) . " tidak valid!");
                    } else {
                        $data_pembelians4->push([
                            'keterangan_tambahan' => $keterangan_tambahan,
                            'nominal_tambahan' => $nominal_tambahan,
                        ]);
                    }
                } else {

                    if ($error_pelanggans || $error_pesanans) {
                        return back()
                            ->withInput()
                            ->with('error_pelanggans', $error_pelanggans)
                            ->with('error_pesanans', $error_pesanans)
                            ->with('data_pembelians', $data_pembelians)
                            ->with('data_pembelians4', $data_pembelians4);
                    }

                    // 'biaya_id' is null, you can skip it

                    // format tanggal indo
                    $tanggal1 = Carbon::now('Asia/Jakarta');
                    $format_tanggal = $tanggal1->format('d F Y');

                    $tanggal = Carbon::now()->format('Y-m-d');
                    $cetakpdf = Faktur_ekspedisi::create([
                        'user_id' => auth()->user()->id,
                        'kode_faktur' => $this->kode(),
                        'tanggal' => $format_tanggal,
                        'tanggal_awal' => $tanggal,
                        'status' => 'posting',
                        'status_notif' => false,
                    ]);

                    $transaksi_id = $cetakpdf->id;

                    if ($cetakpdf) {

                        foreach ($data_pembelians as $data_pesanan) {
                            Detail_faktur::create([
                                'faktur_ekspedisi_id' => $cetakpdf->id,
                                'kode_memo' => $data_pesanan['kode_memo'],
                                'nama_driver' => $data_pesanan['nama_driver'],
                                'rute_perjalanan' => $data_pesanan['rute_perjalanan'],
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

                    return;

                    $detail_memo = Detail_memo::where('memo_ekspedisi_id', $cetakpdf->id)->get();

                    return view('admin.memo_ekspedisi.show', compact('cetakpdf', 'detail_memo'));
                }
            }
        } else {
        }

        if ($error_pelanggans || $error_pesanans) {
            return back()
                ->withInput()
                ->with('error_pelanggans', $error_pelanggans)
                ->with('error_pesanans', $error_pesanans)
                ->with('data_pembelians', $data_pembelians)
                ->with('data_pembelians4', $data_pembelians4);
        }

        return;
        $kode = $this->kode();
        // format tanggal indo
        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');

        $tanggal = Carbon::now()->format('Y-m-d');
        $cetakpdf = Faktur_ekspedisi::create([
            'user_id' => auth()->user()->id,
            'kode_faktur' => $this->kode(),
            'tanggal' => $format_tanggal,
            'tanggal_awal' => $tanggal,
            'status' => 'posting',
            'status_notif' => false,
        ]);

        $transaksi_id = $cetakpdf->id;

        if ($cetakpdf) {

            foreach ($data_pembelians as $data_pesanan) {
                Detail_faktur::create([
                    'faktur_ekspedisi_id' => $cetakpdf->id,
                    'kode_memo' => $data_pesanan['kode_memo'],
                    'nama_driver' => $data_pesanan['nama_driver'],
                    'rute_perjalanan' => $data_pesanan['rute_perjalanan'],
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

        $detail_memo = Detail_memo::where('memo_ekspedisi_id', $cetakpdf->id)->get();

        return view('admin.memo_ekspedisi.show', compact('cetakpdf', 'detail_memo'));
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
        $detail_faktur = Detail_faktur::where('faktur_ekspedisi_id', $cetakpdf->id)->get();
        $detail_tarif = Detail_tariftambahan::where('faktur_ekspedisi_id', $cetakpdf->id)->get();


        $pdf = PDF::loadView('admin.memo_ekspedisi.cetak_pdf', compact('cetakpdf', 'detail_memo'));
        $pdf->setPaper('letter', 'portrait'); // Set the paper size to portrait letter

        return $pdf->stream('Faktur_ekspedisi.pdf');
    }
}