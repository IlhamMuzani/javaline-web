<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Detail_pelunasan;
use App\Models\Detail_pelunasanpotongan;
use App\Models\Detail_pelunasanreturn;
use App\Models\Faktur_ekspedisi;
use App\Models\Faktur_pelunasan;
use App\Models\Nota_return;
use App\Models\Potongan_penjualan;
use App\Models\Spk;
use App\Models\Tagihan_ekspedisi;
use Illuminate\Support\Facades\Validator;

class FakturpelunasanController extends Controller
{
    public function index()
    {

        $fakturs = Faktur_ekspedisi::get();
        $invoices = Tagihan_ekspedisi::whereDoesntHave('detail_tagihan', function ($query) {
            $query->whereHas('faktur_ekspedisi', function ($query) {
                $query->whereNotNull('status_pelunasan');
            });
        })->orWhereHas('detail_tagihan', function ($query) {
            $query->whereHas('faktur_ekspedisi', function ($query) {
                $query->whereNull('status_pelunasan');
            });
        })->get();
        $returns = Nota_return::where('status', 'posting')->get();
        $potonganlains = Potongan_penjualan::where('status', 'posting')->get();

        return view('admin.faktur_pelunasan.index', compact('fakturs', 'invoices', 'returns', 'potonganlains'));
    }

    public function store(Request $request)
    {
        $validasi_pelanggan = Validator::make(
            $request->all(),
            [
                'pelanggan_id' => 'required',
                'nominal' => 'required',
            ],
            [
                'pelanggan_id.required' => 'Pilih Pelanggan',
                'nominal.required' => 'Masukkan nominal pelunasan',
            ]
        );

        $error_pelanggans = array();

        if ($validasi_pelanggan->fails()) {
            array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
        }

        $error_pesanans = array();
        $data_pembelians = collect();
        $data_pembelians2 = collect();
        $data_pembelians3 = collect();

        if ($request->has('faktur_ekspedisi_id')) {
            for ($i = 0; $i < count($request->faktur_ekspedisi_id); $i++) {

                $validasi_produk = Validator::make($request->all(), [
                    'faktur_ekspedisi_id.' . $i => 'required',
                    'kode_faktur.' . $i => 'required',
                    'tanggal_faktur.' . $i => 'required',
                    'total.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Faktur nomor " . ($i + 1) . " belum dilengkapi!"); // Corrected the syntax for concatenation and indexing
                }
                $faktur_ekspedisi_id = is_null($request->faktur_ekspedisi_id[$i]) ? '' : $request->faktur_ekspedisi_id[$i];
                $kode_faktur = is_null($request->kode_faktur[$i]) ? '' : $request->kode_faktur[$i];
                $tanggal_faktur = is_null($request->tanggal_faktur[$i]) ? '' : $request->tanggal_faktur[$i];
                $total = is_null($request->total[$i]) ? '' : $request->total[$i];

                $data_pembelians->push([
                    'faktur_ekspedisi_id' => $faktur_ekspedisi_id,
                    'kode_faktur' => $kode_faktur,
                    'tanggal_faktur' => $tanggal_faktur,
                    'total' => $total
                ]);
            }
        }

        if ($request->has('nota_return_id') || $request->has('faktur_id') ||$request->has('kode_fakturekspedisi') || $request->has('kode_potongan') || $request->has('keterangan_potongan') || $request->has('nominal_potongan')) {
            for ($i = 0; $i < count($request->nota_return_id); $i++) {
                if (empty($request->nota_return_id[$i])  && empty($request->faktur_id[$i]) && empty($request->kode_fakturekspedisi[$i]) && empty($request->potongan_memo_id[$i]) && empty($request->kode_potongan[$i]) && empty($request->keterangan_potongan[$i]) && empty($request->nominal_potongan[$i])) {
                    continue;
                }
                $validasi_produk = Validator::make($request->all(), [
                    'nota_return_id.' . $i => 'required',
                    'faktur_id.' . $i => 'required',
                    'kode_fakturekspedisi.' . $i => 'required',
                    'kode_potongan.' . $i => 'required',
                    'keterangan_potongan.' . $i => 'required',
                    'nominal_potongan.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Return nomor " . ($i + 1) . " belum dilengkapi!");
                }
                $nota_return_id = $request->nota_return_id[$i] ?? '';
                $faktur_id = $request->faktur_id[$i] ?? '';
                $kode_fakturekspedisi = $request->kode_fakturekspedisi[$i] ?? '';
                $kode_potongan = $request->kode_potongan[$i] ?? '';
                $keterangan_potongan = $request->keterangan_potongan[$i] ?? '';
                $nominal_potongan = $request->nominal_potongan[$i] ?? '';
                $data_pembelians2->push([
                    'nota_return_id' => $nota_return_id,
                    'faktur_id' => $faktur_id,
                    'kode_fakturekspedisi' => $kode_fakturekspedisi,
                    'kode_potongan' => $kode_potongan,
                    'keterangan_potongan' => $keterangan_potongan,
                    'nominal_potongan' => $nominal_potongan,

                ]);
            }
        }

        if ($request->has('potongan_penjualan_id') || $request->has('kode_potonganlain') || $request->has('keterangan_potonganlain') || $request->has('nominallain')) {
            for ($i = 0; $i < count($request->potongan_penjualan_id); $i++) {
                if (empty($request->potongan_penjualan_id[$i]) && empty($request->kode_potonganlain[$i]) && empty($request->keterangan_potonganlain[$i]) && empty($request->nominallain[$i])) {
                    continue;
                }

                $validasi_produk = Validator::make($request->all(), [
                    'potongan_penjualan_id.' . $i => 'required',
                    'kode_potonganlain.' . $i => 'required',
                    'keterangan_potonganlain.' . $i => 'required',
                    'nominallain.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Potongan Penjualan Nomor " . ($i + 1) . " belum dilengkapi!");
                }

                $potongan_penjualan_id = $request->potongan_penjualan_id[$i] ?? '';
                $kode_potonganlain = $request->kode_potonganlain[$i] ?? '';
                $keterangan_potonganlain = $request->keterangan_potonganlain[$i] ?? '';
                $nominallain = $request->nominallain[$i] ?? '';

                $data_pembelians3->push([
                    'potongan_penjualan_id' => $potongan_penjualan_id,
                    'kode_potonganlain' => $kode_potonganlain,
                    'keterangan_potonganlain' => $keterangan_potonganlain,
                    'nominallain' => $nominallain,

                ]);
            }
        }

        if ($error_pelanggans || $error_pesanans) {
            return back()
                ->withInput()
                ->with('error_pelanggans', $error_pelanggans)
                ->with('error_pesanans', $error_pesanans)
                ->with('data_pembelians', $data_pembelians)
                ->with('data_pembelians2', $data_pembelians2)
                ->with('data_pembelians3', $data_pembelians3);
        }

        $kode = $this->kode();
        // format tanggal indo
        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');

        $selisih = (int)str_replace(['Rp', '.', ' '], '', $request->selisih);
        $totalpembayaran = (int)str_replace(['Rp', '.', ' '], '', $request->totalpembayaran);
        $tanggal = Carbon::now()->format('Y-m-d');
        $cetakpdf = Faktur_pelunasan::create([
            'user_id' => auth()->user()->id,
            'kode_pelunasan' => $this->kode(),
            'tagihan_ekspedisi_id' => $request->tagihan_ekspedisi_id,
            'kode_tagihan' => $request->kode_tagihan,
            'pelanggan_id' => $request->pelanggan_id,
            'kode_pelanggan' => $request->kode_pelanggan,
            'nama_pelanggan' => $request->nama_pelanggan,
            'alamat_pelanggan' => $request->alamat_pelanggan,
            'telp_pelanggan' => $request->telp_pelanggan,
            'keterangan' => $request->keterangan,
            'saldo_masuk' => str_replace(',', '.', str_replace('.', '', $request->saldo_masuk ?? '0')),
            'totalpenjualan' => str_replace(',', '.', str_replace('.', '', $request->totalpenjualan ?? '0')),
            'dp' => str_replace(',', '.', str_replace('.', '', $request->dp)),
            'potonganselisih' => str_replace(',', '.', str_replace('.', '', $request->potonganselisih ?? '0')),
            'totalpembayaran' => str_replace(',', '.', str_replace('.', '', $request->totalpembayaran ?? '0')),
            'selisih' =>  $selisih,
            'potongan' => $request->potongan ? str_replace(',', '.', str_replace('.', '', $request->potongan)) : 0,
            'ongkos_bongkar' => $request->ongkos_bongkar ? str_replace(',', '.', str_replace('.', '', $request->ongkos_bongkar)) : 0,
            'kategori' => $request->kategori,
            'nomor' => $request->nomor,
            'tanggal_transfer' => $request->tanggal_transfer,
            'nominal' =>  $request->nominal ? str_replace(',', '.', str_replace('.', '', $request->nominal)) : 0,
            'tanggal' => $format_tanggal,
            'tanggal_awal' => $tanggal,
            'qrcode_pelunasan' => 'https://javaline.id/faktur_pelunasan/' . $kode,
            'status' => 'posting',
            'status_notif' => false,
        ]);

        Tagihan_ekspedisi::where('id', $request->tagihan_ekspedisi_id)->update([
            'status' => 'selesai',
        ]);
        $transaksi_id = $cetakpdf->id;
        foreach ($data_pembelians as $data_pesanan) {
            $detailPelunasan = Detail_pelunasan::create([
                'faktur_pelunasan_id' => $cetakpdf->id,
                'faktur_ekspedisi_id' => $data_pesanan['faktur_ekspedisi_id'],
                'kode_faktur' => $data_pesanan['kode_faktur'],
                'tanggal_faktur' => $data_pesanan['tanggal_faktur'],
                'total' => str_replace(',', '.', str_replace('.', '', $data_pesanan['total'])),
                'status' => 'posting',
            ]);
            $faktur = Faktur_ekspedisi::find($detailPelunasan->faktur_ekspedisi_id);

            if ($faktur) {
                $faktur->update(['status_pelunasan' =>'aktif', 'status' => 'selesai']);
                $spk = Spk::find($faktur->spk_id);
                if ($spk) {
                    $spk->update(['status_spk' => 'pelunasan']);
                }
            }
        }

        foreach ($data_pembelians2 as $data_pesanan) {
            $detailPelunasan = Detail_pelunasanreturn::create([
                'faktur_pelunasan_id' => $cetakpdf->id,
                'faktur_ekspedisi_id' => $data_pesanan['faktur_id'],
                'kode_fakturekspedisi' => $data_pesanan['kode_fakturekspedisi'],
                'nota_return_id' => $data_pesanan['nota_return_id'],
                'kode_potongan' => $data_pesanan['kode_potongan'],
                'keterangan_potongan' => $data_pesanan['keterangan_potongan'],
                'nominal_potongan' => str_replace(',', '.', str_replace('.', '', $data_pesanan['nominal_potongan'])),
                'status' => 'posting',
            ]);
        }

        foreach ($data_pembelians3 as $data_pesanan) {
            $detailPelunasan = Detail_pelunasanpotongan::create([
                'faktur_pelunasan_id' => $cetakpdf->id,
                'potongan_penjualan_id' => $data_pesanan['potongan_penjualan_id'],
                'kode_potonganlain' => $data_pesanan['kode_potonganlain'],
                'keterangan_potonganlain' => $data_pesanan['keterangan_potonganlain'],
                'nominallain' => str_replace(',', '.', str_replace('.', '', $data_pesanan['nominallain'])),
                'status' => 'posting',
            ]);

            Potongan_penjualan::where('id', $data_pesanan['potongan_penjualan_id'])->update(['status' => 'selesai']);
        }

        $details = Detail_pelunasan::where('faktur_pelunasan_id', $cetakpdf->id)->get();
        $detailreturns = Detail_pelunasanreturn::where('faktur_pelunasan_id', $cetakpdf->id)->get();

        return view('admin.faktur_pelunasan.show', compact('cetakpdf', 'details', 'detailreturns'));
    }


    public function get_fakturpelunasan($pelanggan_id)
    {
        $fakturs = Faktur_ekspedisi::where('status_pelunasan', null)
            ->whereIn('status', ['posting', 'selesai'])
            ->where('pelanggan_id', $pelanggan_id)
            ->with('pelanggan')
            ->with('detail_faktur')
            ->get();

        return response()->json($fakturs);
    }

    public function kode()
    {
        $lastBarang = Faktur_pelunasan::latest()->first();
        if (!$lastBarang) {
            $num = 1;
        } else {
            $lastCode = $lastBarang->kode_pelunasan;
            $num = (int) substr($lastCode, strlen('LP')) + 1;
        }
        $formattedNum = sprintf("%06s", $num);
        $prefix = 'LP';
        $newCode = $prefix . $formattedNum;
        return $newCode;
    }


    public function show($id)
    {
        $cetakpdf = Faktur_pelunasan::where('id', $id)->first();
        $details = Detail_pelunasan::where('faktur_pelunasan_id', $cetakpdf->id)->get();
        $detailreturns = Detail_pelunasanreturn::where('faktur_pelunasan_id', $cetakpdf->id)->get();
        
        return view('admin.faktur_pelunasan.show', compact('cetakpdf', 'details', 'detailreturns'));
    }

    public function cetakpdf($id)
    {
        $cetakpdf = Faktur_pelunasan::where('id', $id)->first();
        $details = Detail_pelunasan::where('faktur_pelunasan_id', $cetakpdf->id)->get();
        $detailreturns = Detail_pelunasanreturn::where('faktur_pelunasan_id', $cetakpdf->id)->get();

        $pdf = PDF::loadView('admin.faktur_pelunasan.cetak_pdf', compact('detailreturns','cetakpdf', 'details'));
        $pdf->setPaper('letter', 'portrait');
        return $pdf->stream('Faktur_Pelunasan.pdf');
    }
}