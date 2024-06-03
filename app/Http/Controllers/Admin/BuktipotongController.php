<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Bukti_potongpajak;
use App\Models\Detail_bukti;
use App\Models\Detail_tagihan;
use App\Models\Tagihan_ekspedisi;
use Illuminate\Support\Facades\Validator;

class BuktipotongController extends Controller
{
    public function index()
    {
        $inquery = Tagihan_ekspedisi::where(function ($query) {
            $query->where('status', 'posting')
                ->orWhere('status', 'selesai');
        })->where(['kategori' => 'PPH', 'status_terpakai' => null])->get();

        return view('admin.bukti_potongpajak.index', compact('inquery'));
    }

    // public function updatebuktitagihan(Request $request, $id)
    // {
    //     // Memperbarui nomor bukti tagihan utama
    //     $tagihan = Tagihan_ekspedisi::findOrFail($id);
    //     $tagihan->update([
    //         'nomor_buktitagihan' => $request->nomor_buktitagihan,
    //         'tanggal_nomortagihan' => $request->tanggal_nomortagihan
    //     ]);

    //     // Memperbarui detail tagihan
    //     foreach ($request->nomor_buktifaktur as $detailId => $nomorBuktiFaktur) {
    //         $detail = Detail_tagihan::findOrFail($detailId);
    //         $detail->update([
    //             'nomor_buktifaktur' => $nomorBuktiFaktur,
    //             'tanggal_nomorfaktur' => $request->tanggal_nomorfaktur[$detailId] // Adding the update for tanggal_buktifaktur
    //         ]);
    //     }

    //     return redirect()->back()->with('success', 'Data berhasil diperbarui');
    // }

    public function updatebuktitagihan(Request $request, $id)
    {
        // Memperbarui nomor bukti tagihan utama
        $tagihan = Tagihan_ekspedisi::findOrFail($id);
        $tagihan->update([
            'nomor_buktitagihan' => $request->nomor_buktitagihan,
            'tanggal_nomortagihan' => $request->tanggal_nomortagihan
        ]);

        // Memperbarui detail tagihan
        foreach ($request->nomor_buktifaktur as $detailId => $nomorBuktiFaktur) {
            $detail = Detail_tagihan::findOrFail($detailId);
            $detail->update([
                'nomor_buktifaktur' => $nomorBuktiFaktur,
                'tanggal_nomorfaktur' => $request->tanggal_nomorfaktur[$detailId] // Adding the update for tanggal_buktifaktur
            ]);
        }

        $kode = $this->kode();
        // tgl indo
        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');
        $tanggal = Carbon::now()->format('Y-m-d');
        $grand_total = Detail_tagihan::where('tagihan_ekspedisi_id', $id)->sum('total');

        // Jika nomor_buktitagihan dan tanggal_nomortagihan ada dalam request
        if ($request->has('nomor_buktitagihan') && $request->has('tanggal_nomortagihan')) {
            // Jika request nomor_buktitagihan dan tanggal_nomortagihan tidak null
            if (!is_null($request->nomor_buktitagihan) && !is_null($request->tanggal_nomortagihan)) {
                // Buat Bukti_potongpajak
                $cetakpdf = Bukti_potongpajak::create([
                    'user_id' => auth()->user()->id,
                    'kategori' => 'PEMASUKAN',
                    'kategoris' => 'PPH23',
                    'nomor_faktur' => $request->nomor_buktitagihan,
                    'periode_awal' => $request->tanggal_nomortagihan,
                    'kode_bukti' => $kode,
                    'grand_total' => $grand_total,
                    'tanggal' => $format_tanggal,
                    'tanggal_awal' => $tanggal,
                    'status' => 'posting',
                ]);

                // Buat entri Detail_bukti untuk setiap detail tagihan
                Detail_bukti::create([
                    'bukti_potongpajak_id' => $cetakpdf->id,
                    'tagihan_ekspedisi_id' => $id,
                    'kode_tagihan' => $detail->tagihan_ekspedisi->kode_tagihan,
                    'tanggal' => $detail->tagihan_ekspedisi->tanggal,
                    'nama_pelanggan' => $detail->tagihan_ekspedisi->nama_pelanggan,
                    'pph' => $detail->tagihan_ekspedisi->pph,
                    'total' => $detail->tagihan_ekspedisi->sub_total,
                ]);

                Tagihan_ekspedisi::where('id', $id)->update(['status_terpakai' => 'digunakan']);
            }
        }

        // Jika detail tagihan semua terisi
        $detailTagihanFilled = true;
        foreach ($request->nomor_buktifaktur as $detailId => $nomorBuktiFaktur) {
            if (is_null($nomorBuktiFaktur) || is_null($request->tanggal_nomorfaktur[$detailId])) {
                $detailTagihanFilled = false;
                break;
            }
        }

        // Jika detail tagihan semua terisi, buat Bukti_potongpajak
        if ($detailTagihanFilled) {
            if (is_null($request->nomor_buktitagihan) && is_null($request->tanggal_nomortagihan)) {
                $nomorBuktiFakturPertama = $request->nomor_buktifaktur[array_key_first($request->nomor_buktifaktur)];
                $tanggalNomorFakturPertama = $request->tanggal_nomorfaktur[array_key_first($request->tanggal_nomorfaktur)];

                $cetakpdf = Bukti_potongpajak::create([
                    'user_id' => auth()->user()->id,
                    'kategori' => 'PEMASUKAN',
                    'kategoris' => 'PPH23',
                    'kode_bukti' => $kode,
                    'nomor_faktur' => $nomorBuktiFakturPertama,
                    'periode_awal' => $tanggalNomorFakturPertama,
                    'grand_total' => $grand_total,
                    'tanggal' => $format_tanggal,
                    'tanggal_awal' => $tanggal,
                    'status' => 'posting',
                ]);

                // Buat entri Detail_bukti untuk setiap detail tagihan
                Detail_bukti::create([
                    'bukti_potongpajak_id' => $cetakpdf->id,
                    'tagihan_ekspedisi_id' => $id,
                    'kode_tagihan' => $detail->tagihan_ekspedisi->kode_tagihan,
                    'tanggal' => $detail->tagihan_ekspedisi->tanggal,
                    'nama_pelanggan' => $detail->tagihan_ekspedisi->nama_pelanggan,
                    'pph' => $detail->tagihan_ekspedisi->pph,
                    'total' => $detail->tagihan_ekspedisi->sub_total,
                ]);

                Tagihan_ekspedisi::where('id', $id)->update(['status_terpakai' => 'digunakan']);
            }
        }


        return redirect()->back()->with('success', 'Data berhasil diperbarui');
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
}
