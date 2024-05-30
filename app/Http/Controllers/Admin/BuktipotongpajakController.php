<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Bukti_potongpajak;
use App\Models\Detail_bukti;
use App\Models\Tagihan_ekspedisi;
use Illuminate\Support\Facades\Validator;

class BuktipotongpajakController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $buktipotongpajaks = Bukti_potongpajak::whereDate('created_at', $today)
            ->orWhere(function ($query) use ($today) {
                $query->where('status', 'unpost')
                    ->whereDate('created_at', '<', $today);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.bukti_potongpajak.index', compact('buktipotongpajaks'));
    }

    public function create()
    {
        $tagihanEkspedisis = Tagihan_ekspedisi::where(function ($query) {
            $query->where('status', 'posting')
                ->orWhere('status', 'selesai');
        })->where(['kategori' => 'PPH', 'status_terpakai' => null])->get();

        return view('admin.bukti_potongpajak.create', compact('tagihanEkspedisis'));
    }

    public function store(Request $request)
    {
        $validasi_barang = Validator::make($request->all(), [
            'kategori' => 'required',
            'kategoris' => 'required',
            'nomor_faktur' => 'required',
            'tanggal' => 'required',
            'grand_total' => 'required',
        ], [
            'kategori.required' => 'Pilih Status',
            'kategoris.required' => 'Pilih Kategori',
            'nomor_faktur.required' => 'Masukkan nomor faktur',
            'tanggal.required' => 'Pilih Tanggal',
            'grand_total.required' => 'Grand total kosong',
        ]);

        $error_barangs = array();

        if ($validasi_barang->fails()) {
            array_push($error_barangs, $validasi_barang->errors()->all()[0]);
        }

        $error_pesanans = array();
        $data_pembelians = collect();

        if ($request->has('id')) {
            foreach ($request->id as $key => $id) {
                $validator_produk = Validator::make($request->all(), []);

                if ($validator_produk->fails()) {
                    $error_pesanans[] = "Invoice nomor " . ($key + 1) . " belum dilengkapi!";
                }

                $barang = Tagihan_ekspedisi::where('id', $id)->first();

                $data_pembelians->push([
                    'id' => $id,
                    'kode_tagihan' => $barang->kode_tagihan,
                    'tanggal' => $barang->tanggal,
                    'nama_pelanggan' => $barang->nama_pelanggan,
                    'pph' => $barang->pph,
                    'total' => $barang->sub_total,
                ]);
            }
        }

        if ($error_barangs || $error_pesanans) {
            return back()
                ->withInput()
                ->with('error_barangs', $error_barangs)
                ->with('error_pesanans', $error_pesanans)
                ->with('data_pembelians', $data_pembelians);
        }

        $kode = $this->kode();

        // tgl indo
        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');
        $tanggal = Carbon::now()->format('Y-m-d');

        $cetakpdf = Bukti_potongpajak::create([
            'user_id' => auth()->user()->id,
            'kategori' => $request->kategori,
            'kategoris' => $request->kategoris,
            'nomor_faktur' => $request->nomor_faktur,
            'periode_awal' => $request->periode_awal,
            'grand_total' => str_replace(',', '.', str_replace('.', '', $request->grand_total)),
            'kode_bukti' => $kode,
            'tanggal' => $format_tanggal,
            'tanggal_awal' => $tanggal,
            'status' => 'posting',
        ]);

        if ($cetakpdf) {
            foreach ($data_pembelians as $data_pesanan) {
                $barang = Tagihan_ekspedisi::where('id', $data_pesanan['id'])->first();
                $detailBukti = Detail_bukti::create([
                    'bukti_potongpajak_id' => $cetakpdf->id,
                    'tagihan_ekspedisi_id' => $barang->id,
                    'kode_tagihan' => $barang->kode_tagihan,
                    'tanggal' => $barang->tanggal,
                    'nama_pelanggan' => $barang->nama_pelanggan,
                    'pph' => $barang->pph,
                    'total' => $barang->sub_total,
                ]);
                Tagihan_ekspedisi::where('id', $detailBukti->tagihan_ekspedisi_id)->update(['status_terpakai' => 'digunakan']);
            }
        }

        $details = Detail_bukti::where('bukti_potongpajak_id', $cetakpdf->id)->get();

        return view('admin.bukti_potongpajak.show', compact('cetakpdf', 'details'));
    }

    // public function kode()
    // {
    //     $item = Bukti_potongpajak::all();
    //     if ($item->isEmpty()) {
    //         $num = "000001";
    //     } else {
    //         $id = Bukti_potongpajak::getId();
    //         foreach ($id as $value);
    //         $idlm = $value->id;
    //         $idbr = $idlm + 1;
    //         $num = sprintf("%06s", $idbr);
    //     }
    //     $tahun = date('y');
    //     $data = 'BPP';
    //     $tanggal = date('dm');
    //     $kode_item = $data . "/" . $tanggal . $tahun . "/" . $num;

    //     return $kode_item;
    // }

    public function kode()
    {
        $lastBarang = Bukti_potongpajak::where('kode_bukti', 'like', 'BPP%')->latest()->first();
        $lastMonth = $lastBarang ? date('m', strtotime($lastBarang->created_at)) : null;
        $currentMonth = date('m');
        if (!$lastBarang || $currentMonth != $lastMonth) {
            $num = 1;
        } else {
            $lastCode = $lastBarang->kode_bukti;
            $parts = explode('/', $lastCode);
            $lastNum = end($parts);
            $num = (int) $lastNum + 1;
        }
        $formattedNum = sprintf("%03s", $num);
        $prefix = 'BPP';
        $tahun = date('y');
        $tanggal = date('dm');
        $newCode = $prefix . "/" . $tanggal . $tahun . "/" . $formattedNum;
        return $newCode;
    }

    public function destroy($id)
    {
        $pemasukan = Bukti_potongpajak::find($id);
        $pemasukan->detail_pemasukan()->delete();
        $pemasukan->delete();

        return redirect('admin/pemasukan')->with('success', 'Berhasil menghapus pemasukan');
    }

    public function show($id)
    {
        $cetakpdf = Bukti_potongpajak::where('id', $id)->first();
        $details = Detail_bukti::where('bukti_potongpajak_id', $id)->get();

        return view('admin.bukti_potongpajak.show', compact('cetakpdf', 'details'));
    }

    public function cetakpdf($id)
    {
        $cetakpdf = Bukti_potongpajak::find($id);
        $details = Detail_bukti::where('bukti_potongpajak_id', $cetakpdf->id)->get();

        $pdf = PDF::loadView('admin.bukti_potongpajak.cetak_pdf', compact('details', 'cetakpdf'));
        $pdf->setPaper('letter', 'portrait');

        return $pdf->stream('Bukti_Potong_pajak.pdf');
    }

    public function get_item($id)
    {
        $barang = Tagihan_ekspedisi::where('id', $id)->first();
        return $barang;
    }
}