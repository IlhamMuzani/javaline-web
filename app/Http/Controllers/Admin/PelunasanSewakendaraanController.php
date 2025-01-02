<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Detail_pelunasansewa;
use App\Models\Detail_pelunasanpotongan;
use App\Models\Detail_pelunasanreturn;
use App\Models\Sewa_kendaraan;
use App\Models\Pelunasan_sewakendaraan;
use App\Models\Nota_return;
use App\Models\Potongan_penjualan;
use App\Models\Spk;
use App\Models\Invoice_sewakendaraan;
use Illuminate\Support\Facades\Validator;

class PelunasanSewakendaraanController extends Controller
{

    public function index(Request $request)
    {
        $inquery = Pelunasan_sewakendaraan::query();

        $inquery->whereDate('tanggal_awal', Carbon::today());
        $inquery->orderBy('id', 'DESC');
        $inquery = $inquery->get();

        return view('admin.pelunasan_sewakendaraan.index', compact('inquery'));
    }

    public function create()
    {
        $fakturs = Sewa_kendaraan::get();
        $invoices = Invoice_sewakendaraan::whereDoesntHave('detail_invoice', function ($query) {
            $query->whereHas('sewa_kendaraan', function ($query) {
                $query->whereNotNull('status_pelunasan');
            });
        })->orWhereHas('detail_invoice', function ($query) {
            $query->whereHas('sewa_kendaraan', function ($query) {
                $query->whereNull('status_pelunasan');
            });
        })->get();
        $returns = Nota_return::where('status', 'posting')->get();
        $potonganlains = Potongan_penjualan::where('status', 'posting')->get();

        return view('admin.pelunasan_sewakendaraan.create', compact('fakturs', 'invoices', 'returns', 'potonganlains'));
    }

    public function store(Request $request)
    {
        $validasi_pelanggan = Validator::make(
            $request->all(),
            [
                'vendor_id' => 'required',
                'nominal' => 'required',
            ],
            [
                'vendor_id.required' => 'Pilih Pelanggan',
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

        if ($request->has('sewa_kendaraan_id')) {
            for ($i = 0; $i < count($request->sewa_kendaraan_id); $i++) {

                $validasi_produk = Validator::make($request->all(), [
                    'sewa_kendaraan_id.' . $i => 'required',
                    'kode_faktur.' . $i => 'required',
                    'tanggal_faktur.' . $i => 'required',
                    'total.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Faktur nomor " . ($i + 1) . " belum dilengkapi!"); // Corrected the syntax for concatenation and indexing
                }
                $sewa_kendaraan_id = is_null($request->sewa_kendaraan_id[$i]) ? '' : $request->sewa_kendaraan_id[$i];
                $kode_faktur = is_null($request->kode_faktur[$i]) ? '' : $request->kode_faktur[$i];
                $tanggal_faktur = is_null($request->tanggal_faktur[$i]) ? '' : $request->tanggal_faktur[$i];
                $total = is_null($request->total[$i]) ? '' : $request->total[$i];

                $data_pembelians->push([
                    'sewa_kendaraan_id' => $sewa_kendaraan_id,
                    'kode_faktur' => $kode_faktur,
                    'tanggal_faktur' => $tanggal_faktur,
                    'total' => $total
                ]);
            }
        }

        if ($request->has('nota_return_id') || $request->has('faktur_id') || $request->has('kode_potongan') || $request->has('keterangan_potongan') || $request->has('nominal_potongan')) {
            for ($i = 0; $i < count($request->nota_return_id); $i++) {
                if (empty($request->nota_return_id[$i])  && empty($request->faktur_id[$i]) && empty($request->potongan_memo_id[$i]) && empty($request->kode_potongan[$i]) && empty($request->keterangan_potongan[$i]) && empty($request->nominal_potongan[$i])) {
                    continue;
                }
                $validasi_produk = Validator::make($request->all(), [
                    'nota_return_id.' . $i => 'required',
                    'faktur_id.' . $i => 'required',
                    'kode_potongan.' . $i => 'required',
                    'keterangan_potongan.' . $i => 'required',
                    'nominal_potongan.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Return nomor " . ($i + 1) . " belum dilengkapi!");
                }
                $nota_return_id = $request->nota_return_id[$i] ?? '';
                $faktur_id = $request->faktur_id[$i] ?? '';
                $kode_potongan = $request->kode_potongan[$i] ?? '';
                $keterangan_potongan = $request->keterangan_potongan[$i] ?? '';
                $nominal_potongan = $request->nominal_potongan[$i] ?? '';
                $data_pembelians2->push([
                    'nota_return_id' => $nota_return_id,
                    'faktur_id' => $faktur_id,
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
        $cetakpdf = Pelunasan_sewakendaraan::create([
            'user_id' => auth()->user()->id,
            'kode_pelunasan' => $this->kode(),
            'invoice_sewakendaraan_id' => $request->invoice_sewakendaraan_id,
            'kode_tagihan' => $request->kode_tagihan,
            'vendor_id' => $request->vendor_id,
            'kode_vendor' => $request->kode_vendor,
            'nama_vendor' => $request->nama_vendor,
            'alamat_vendor' => $request->alamat_vendor,
            'telp_vendor' => $request->telp_vendor,
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
            'qrcode_pelunasan' => 'https://javaline.id/pelunasan_sewakendaraan/' . $kode,
            'status' => 'posting',
            'status_notif' => false,
        ]);

        Invoice_sewakendaraan::where('id', $request->invoice_sewakendaraan_id)->update([
            'status' => 'selesai',
        ]);
        $transaksi_id = $cetakpdf->id;
        foreach ($data_pembelians as $data_pesanan) {
            $detailPelunasan = Detail_pelunasansewa::create([
                'pelunasan_sewakendaraan_id' => $cetakpdf->id,
                'sewa_kendaraan_id' => $data_pesanan['sewa_kendaraan_id'],
                'kode_faktur' => $data_pesanan['kode_faktur'],
                'tanggal_faktur' => $data_pesanan['tanggal_faktur'],
                'total' => str_replace(',', '.', str_replace('.', '', $data_pesanan['total'])),
                'status' => 'posting',
            ]);
            $faktur = Sewa_kendaraan::find($detailPelunasan->sewa_kendaraan_id);

            if ($faktur) {
                $faktur->update(['status_pelunasan' => 'aktif']);
            }
        }

        foreach ($data_pembelians2 as $data_pesanan) {
            $detailPelunasan = Detail_pelunasanreturn::create([
                'pelunasan_sewakendaraan_id' => $cetakpdf->id,
                'sewa_kendaraan_id' => $data_pesanan['faktur_id'],
                'nota_return_id' => $data_pesanan['nota_return_id'],
                'kode_potongan' => $data_pesanan['kode_potongan'],
                'keterangan_potongan' => $data_pesanan['keterangan_potongan'],
                'nominal_potongan' => str_replace(',', '.', str_replace('.', '', $data_pesanan['nominal_potongan'])),
                'status' => 'posting',
            ]);
        }

        foreach ($data_pembelians3 as $data_pesanan) {
            $detailPelunasan = Detail_pelunasanpotongan::create([
                'pelunasan_sewakendaraan_id' => $cetakpdf->id,
                'potongan_penjualan_id' => $data_pesanan['potongan_penjualan_id'],
                'kode_potonganlain' => $data_pesanan['kode_potonganlain'],
                'keterangan_potonganlain' => $data_pesanan['keterangan_potonganlain'],
                'nominallain' => str_replace(',', '.', str_replace('.', '', $data_pesanan['nominallain'])),
                'status' => 'posting',
            ]);

            Potongan_penjualan::where('id', $data_pesanan['potongan_penjualan_id'])->update(['status' => 'selesai']);
        }

        $details = Detail_pelunasansewa::where('pelunasan_sewakendaraan_id', $cetakpdf->id)->get();

        return view('admin.pelunasan_sewakendaraan.show', compact('cetakpdf', 'details'));
    }


    public function get_fakturpelunasansewa($vendor_id)
    {
        $fakturs = Sewa_kendaraan::where('status_pelunasan', null)
            ->whereIn('status', ['posting', 'selesai'])
            ->where('vendor_id', $vendor_id)
            ->with('vendor')
            ->get();

        return response()->json($fakturs);
    }

    public function kode()
    {
        // Ambil kode memo terakhir yang sesuai format 'FJ%' dan kategori 'Memo Perjalanan'
        $lastBarang = Pelunasan_sewakendaraan::where('kode_pelunasan', 'like', 'FJ%')
            ->orderBy('id', 'desc')
            ->first();

        // Inisialisasi nomor urut
        $num = 1;

        // Jika ada kode terakhir, proses untuk mendapatkan nomor urut
        if ($lastBarang) {
            $lastCode = $lastBarang->kode_pelunasan;

            // Pastikan kode terakhir sesuai dengan format FJ[YYYYMMDD][NNNN]D
            if (preg_match('/^FJ(\d{6})(\d{4})D$/', $lastCode, $matches)) {
                $lastDate = $matches[1]; // Bagian tanggal: ymd (contoh: 241125)
                $lastMonth = substr($lastDate, 2, 2); // Ambil bulan dari tanggal (contoh: 11)
                $currentMonth = date('m'); // Bulan saat ini

                if ($lastMonth === $currentMonth) {
                    // Jika bulan sama, tambahkan nomor urut
                    $lastNum = (int)$matches[2]; // Bagian nomor urut (contoh: 0001)
                    $num = $lastNum + 1;
                }
            }
        }

        // Formatkan nomor urut menjadi 4 digit
        $formattedNum = sprintf("%04s", $num);

        // Buat kode baru dengan tambahan huruf D di belakang
        $prefix = 'FJ';
        $kodeMemo = $prefix . date('ymd') . $formattedNum . 'D'; // Format akhir kode memo

        return $kodeMemo;
    }


    public function show($id)
    {
        $cetakpdf = Pelunasan_sewakendaraan::where('id', $id)->first();

        return view('admin.pelunasan_sewakendaraan.show', compact('cetakpdf'));
    }

    public function cetakpdf($id)
    {
        $cetakpdf = Pelunasan_sewakendaraan::where('id', $id)->first();
        $details = Detail_pelunasansewa::where('pelunasan_sewakendaraan_id', $cetakpdf->id)->get();

        $pdf = PDF::loadView('admin.pelunasan_sewakendaraan.cetak_pdf', compact('cetakpdf', 'details'));
        $pdf->setPaper('letter', 'portrait');
        return $pdf->stream('Faktur_Pelunasan_sewa.pdf');
    }
}
