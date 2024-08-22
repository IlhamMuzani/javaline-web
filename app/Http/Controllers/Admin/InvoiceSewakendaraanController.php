<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Detail_invoice;
use App\Models\Sewa_kendaraan;
use App\Models\Invoice_sewakendaraan;
use App\Models\Pelanggan;
use App\Models\Spk;
use App\Models\Tarif;
use Illuminate\Support\Facades\Validator;

class InvoiceSewakendaraanController extends Controller
{
    public function index()
    {

        $today = Carbon::today();

        $inquery = Invoice_sewakendaraan::whereDate('created_at', $today)
            ->orWhere(function ($query) use ($today) {
                $query->where('status', 'unpost')
                    ->whereDate('created_at', '<', $today);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.invoice_sewakendaraan.index', compact('inquery'));
    }

    public function create()
    {
        // $pelanggans = Pelanggan::all();
        $fakturs = Sewa_kendaraan::where(['status_tagihan' => null, 'status' => 'posting', 'kategori' => 'PPH'])->get();

        return view('admin.invoice_sewakendaraan.create', compact('fakturs'));
    }

    public function indexinvoice_nonpph()
    {
        // $pelanggans = Pelanggan::all();
        $fakturs = Sewa_kendaraan::where(['status_tagihan' => null, 'status' => 'posting', 'kategori' => 'NON PPH'])->get();
        $tarifs = Tarif::all();

        return view('admin.invoice_sewakendaraan.createnonpph', compact('fakturs', 'tarifs'));
    }

    public function get_faktursewa($vendor_id)
    {
        $fakturs = Sewa_kendaraan::where(['status_tagihan' => null, 'status' => 'posting', 'kategori' => 'PPH', 'vendor_id' => $vendor_id])
            ->with('vendor')
            ->get();
        return response()->json($fakturs);
    }

    public function get_faktursewanonpph($vendor_id)
    {
        $fakturs = Sewa_kendaraan::where(['status_tagihan' => null, 'status' => 'posting', 'kategori' => 'NON PPH', 'vendor_id' => $vendor_id])
            ->with('vendor')
            ->get();
        return response()->json($fakturs);
    }


    public function store(Request $request)
    {
        $validasi_pelanggan = Validator::make(
            $request->all(),
            [
                'kategori' => 'required',
                'vendor_id' => 'required',
                'grand_total' => 'required',
            ],
            [
                'kategori.required' => 'Pilih kategori',
                'vendor_id.required' => 'Pilih Pelanggan',
                'grand_total.required' => 'Masukkan grand total',
            ]
        );

        $error_pelanggans = array();

        if ($validasi_pelanggan->fails()) {
            array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
        }

        $error_pesanans = array();
        $data_pembelians = collect();

        if ($request->has('sewa_kendaraan_id')) {
            for ($i = 0; $i < count($request->sewa_kendaraan_id); $i++) {
                $validasi_produk = Validator::make($request->all(), [
                    'sewa_kendaraan_id.' . $i => 'required',
                    'kode_faktur.' . $i => 'required',
                    'nama_rute.' . $i => 'required',
                    // 'no_memo.' . $i => 'required',
                    'no_do.' . $i => 'required',
                    // 'no_po.' . $i => 'required',
                    'tanggal_memo.' . $i => 'required',
                    // 'no_kabin.' . $i => 'required',
                    'no_pol.' . $i => 'required',
                    'jumlah.' . $i => 'required',
                    'satuan.' . $i => 'required',
                    'harga.' . $i => 'required',
                    'total.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Faktur nomor " . ($i + 1) . " belum dilengkapi!"); // Corrected the syntax for concatenation and indexing
                }

                $sewa_kendaraan_id = is_null($request->sewa_kendaraan_id[$i]) ? '' : $request->sewa_kendaraan_id[$i];
                $kode_faktur = is_null($request->kode_faktur[$i]) ? '' : $request->kode_faktur[$i];
                $nama_rute = is_null($request->nama_rute[$i]) ? '' : $request->nama_rute[$i];
                $no_memo = is_null($request->no_memo[$i]) ? '' : $request->no_memo[$i];
                $no_do = is_null($request->no_do[$i]) ? '' : $request->no_do[$i];
                // $no_po = is_null($request->no_po[$i]) ? '' : $request->no_po[$i];
                $tanggal_memo = is_null($request->tanggal_memo[$i]) ? '' : $request->tanggal_memo[$i];
                $no_kabin = is_null($request->no_kabin[$i]) ? '' : $request->no_kabin[$i];
                $no_pol = is_null($request->no_pol[$i]) ? '' : $request->no_pol[$i];
                $jumlah = is_null($request->jumlah[$i]) ? '' : $request->jumlah[$i];
                $satuan = is_null($request->satuan[$i]) ? '' : $request->satuan[$i];
                $harga = is_null($request->harga[$i]) ? '' : $request->harga[$i];
                $nominal_potongan = is_null($request->nominal_potongan[$i]) ? '' : $request->nominal_potongan[$i];
                $total = is_null($request->total[$i]) ? '' : $request->total[$i];

                $data_pembelians->push([
                    'sewa_kendaraan_id' => $sewa_kendaraan_id,
                    'kode_faktur' => $kode_faktur,
                    'nama_rute' => $nama_rute,
                    'no_memo' => $no_memo,
                    'no_do' => $no_do,
                    // 'no_po' => $no_po,
                    'tanggal_memo' => $tanggal_memo,
                    'no_kabin' => $no_kabin,
                    'no_pol' => $no_pol,
                    'jumlah' => $jumlah,
                    'satuan' => $satuan,
                    'harga' => $harga,
                    'nominal_potongan' => $nominal_potongan,
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

        $kodePelanggan = $request->kode_vendor; // Mendapatkan kode pelanggan dari request
        $kode = $this->kode($kodePelanggan); // Memanggil fungsi kode() dengan melewatkan kode pelanggan

        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');

        $tanggal = Carbon::now()->format('Y-m-d');
        $cetakpdf = Invoice_sewakendaraan::create([
            'user_id' => auth()->user()->id,
            'kode_tagihan' => $kode,
            'kategori' => $request->kategori,
            'vendor_id' => $request->vendor_id,
            'kode_vendor' => $request->kode_vendor,
            'nama_vendor' => $request->nama_vendor,
            'alamat_vendor' => $request->alamat_vendor,
            'telp_vendor' => $request->telp_vendor,
            'periode_awal' => $request->periode_awal,
            'periode_akhir' => $request->periode_akhir,
            'pph' => str_replace(',', '.', str_replace('.', '', $request->pph)),
            'sub_total' => str_replace(',', '.', str_replace('.', '', $request->sub_total)),
            'grand_total' => str_replace(',', '.', str_replace('.', '', $request->grand_total)),
            'keterangan' => $request->keterangan,
            'tanggal' => $format_tanggal,
            'tanggal_awal' => $tanggal,
            'qrcode_tagihan' => 'https://javaline.id/invoice_sewakendaraan/' . $kode,
            'status' => 'posting',
            'status_notif' => false,
        ]);

        $transaksi_id = $cetakpdf->id;

        if ($cetakpdf) {
            foreach ($data_pembelians as $data_pesanan) {
                $detailTagihan = Detail_invoice::create([
                    'invoice_sewakendaraan_id' => $cetakpdf->id,
                    'sewa_kendaraan_id' => $data_pesanan['sewa_kendaraan_id'],
                    'kode_faktur' => $data_pesanan['kode_faktur'],
                    'nama_rute' => $data_pesanan['nama_rute'],
                    'no_memo' => $data_pesanan['no_memo'],
                    'no_do' => $data_pesanan['no_do'],
                    'tanggal_memo' => $data_pesanan['tanggal_memo'],
                    'no_kabin' => $data_pesanan['no_kabin'],
                    'no_pol' => $data_pesanan['no_pol'],
                    'jumlah' => $data_pesanan['jumlah'],
                    'satuan' => $data_pesanan['satuan'],
                    'harga' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['harga'])),
                    'nominal_potongan' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['nominal_potongan'])),
                    'total' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['total'])),

                ]);

                $faktur = Sewa_kendaraan::find($detailTagihan->sewa_kendaraan_id);
                if ($faktur) {
                    $faktur->update(['status_tagihan' => 'aktif', 'status' => 'selesai']);
                }
            }
        }

        $details = Detail_invoice::where('invoice_sewakendaraan_id', $cetakpdf->id)->get();

        return view('admin.invoice_sewakendaraan.show', compact('cetakpdf', 'details'));
    }


    public function kode($kodePelanggan)
    {
        // Mengambil 3 angka terakhir dari kode pelanggan
        $lastThreeDigits = substr($kodePelanggan, -3);

        // Mendapatkan tagihan terbaru dengan kode pelanggan yang sama
        $lastBarang = Invoice_sewakendaraan::where('kode_tagihan', 'like', 'IS%')
            ->where('kode_vendor', $kodePelanggan)
            ->latest()
            ->first();

        // Mendapatkan bulan dari tanggal pembuatan terakhir
        $lastMonth = $lastBarang ? date('m', strtotime($lastBarang->created_at)) : null;

        // Mendapatkan bulan saat ini
        $currentMonth = date('m');

        // Mendapatkan tahun saat ini
        $currentYear = date('y');

        // Menghitung nomor urut baru
        if (!$lastBarang || $lastMonth != $currentMonth || $currentYear != substr($lastBarang->created_at, 2, 2)) {
            // Jika tidak ada tagihan dengan kode pelanggan yang sama, atau bulan pembuatan terakhir berbeda dengan bulan saat ini, atau tahun pembuatan terakhir berbeda dengan tahun saat ini, mulai dari nomor 1
            $num = 1;
        } else {
            // Jika ada tagihan dengan kode pelanggan yang sama dan bulan pembuatan terakhir sama dengan bulan saat ini, dan tahun pembuatan terakhir sama dengan tahun saat ini, lanjutkan nomor urut
            $lastCode = $lastBarang->kode_tagihan;
            $parts = explode('/', $lastCode);
            $lastNum = end($parts);
            $num = (int) $lastNum + 1;
        }

        // Format nomor urut menjadi tiga digit
        $formattedNum = sprintf("%03s", $num);

        // Prefix untuk kode tagihan
        $prefix = 'ISAV';

        // Tanggal
        $tanggal = date('dm');

        // Kode tagihan baru
        $newCode = $prefix . $lastThreeDigits .  "/" . $tanggal . $currentYear . "/" . $formattedNum;

        // Kembalikan kode
        return $newCode;
    }


    public function show($id)
    {
        $cetakpdf = Sewa_kendaraan::where('id', $id)->first();

        return view('admin.invoice_sewakendaraan.show', compact('cetakpdf'));
    }

    public function cetakpdf($id)
    {
        $cetakpdf = Invoice_sewakendaraan::where('id', $id)->first();
        $details = Detail_invoice::where('invoice_sewakendaraan_id', $cetakpdf->id)->get();

        $pdf = PDF::loadView('admin.invoice_sewakendaraan.cetak_pdf', compact('cetakpdf', 'details'));
        $pdf->setPaper('letter', 'portrait'); // Set the paper size to portrait letter

        return $pdf->stream('Invoice_ekspedisi.pdf');
    }
}