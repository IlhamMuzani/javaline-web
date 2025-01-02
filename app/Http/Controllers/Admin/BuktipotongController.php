<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Bukti_potongpajak;
use App\Models\Detail_bukti;
use App\Models\Detail_tagihan;
use App\Models\Pelanggan;
use App\Models\Tagihan_ekspedisi;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class BuktipotongController extends Controller
{
    public function index(Request $request)
    {
        $pelanggans = Pelanggan::whereHas('tagihan_ekspedisi', function ($query) {
            $query->where('kategori', 'PPH');
        })->get();
        $pelanggan_id = $request->pelanggan_id;
        $inquery = Tagihan_ekspedisi::where(function ($query) {
            $query->where('status', 'posting')
                ->orWhere('status', 'selesai');
        })->where('kategori', 'PPH')
            ->where('status_terpakai', null)
            ->when($pelanggan_id, function ($query, $pelanggan_id) {
                return $query->where('pelanggan_id', $pelanggan_id);
            })
            ->get();
        return view('admin.bukti_potongpajak.index', compact('inquery', 'pelanggans'));
    }

    public function updatebuktitagihan(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'gambar_bukti' => 'nullable|mimes:pdf|max:2048',
            ],
            [
                'gambar_bukti.mimes' => 'Hanya file PDF yang diperbolehkan!',
                'gambar_bukti.max' => 'Ukuran file PDF maksimal 2MB!',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $tagihan_ekspedisi = Tagihan_ekspedisi::findOrFail($id);
        if ($request->gambar_bukti) {
            Storage::disk('local')->delete('public/uploads/' . $tagihan_ekspedisi->gambar_bukti);
            $pdf = str_replace(' ', '', $request->gambar_bukti->getClientOriginalName());
            $namaPdf = 'tagihan_ekspedisi/' . date('mYdHs') . rand(1, 10) . '_' . $pdf;
            $request->gambar_bukti->storeAs('public/uploads/', $namaPdf);
        } else {
            $namaPdf = $tagihan_ekspedisi->gambar_bukti;
        }
        $tagihan = Tagihan_ekspedisi::findOrFail($id);
        $tagihan->update([
            'gambar_bukti' => $namaPdf,
            'nomor_buktitagihan' => $request->nomor_buktitagihan,
            'tanggal_nomortagihan' => $request->tanggal_nomortagihan
        ]);
        foreach ($request->nomor_buktifaktur as $detailId => $nomorBuktiFaktur) {
            $detail = Detail_tagihan::findOrFail($detailId);

            if ($request->hasFile("gambar_buktifaktur.$detailId")) {
                Storage::disk('local')->delete('public/uploads/' . $detail->gambar_buktifaktur);
                $gambar2 = str_replace(' ', '', $request->file("gambar_buktifaktur.$detailId")->getClientOriginalName());
                $namaGambarfaktur = 'detail_tagihan/' . date('mYdHs') . rand(1, 10) . '_' . $gambar2;
                $request->file("gambar_buktifaktur.$detailId")->storeAs('public/uploads/', $namaGambarfaktur);
            } else {
                $namaGambarfaktur = $detail->gambar_buktifaktur;
            }

            $detail->update([
                'gambar_buktifaktur' => $namaGambarfaktur,
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

        if ($request->has('nomor_buktitagihan') && $request->has('tanggal_nomortagihan')) {
            if (!is_null($request->nomor_buktitagihan) && !is_null($request->tanggal_nomortagihan)) {
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
        $detailTagihanFilled = true;
        foreach ($request->nomor_buktifaktur as $detailId => $nomorBuktiFaktur) {
            if (is_null($nomorBuktiFaktur) || is_null($request->tanggal_nomorfaktur[$detailId])) {
                $detailTagihanFilled = false;
                break;
            }
        }
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
        $lastBarang = Bukti_potongpajak::where('kode_bukti', 'like', 'FR%')
            ->orderBy('id', 'desc')
            ->first();

        // Inisialisasi nomor urut
        $num = 1;

        // Jika ada kode terakhir, proses untuk mendapatkan nomor urut
        if ($lastBarang) {
            $lastCode = $lastBarang->kode_bukti;

            // Pastikan kode terakhir sesuai dengan format FR[YYYYMMDD][NNNN]
            if (preg_match('/^FR(\d{6})(\d{4})$/', $lastCode, $matches)) {
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

        // Buat kode baru tanpa huruf B di belakang
        $prefix = 'FR';
        $kodeMemo = $prefix . date('ymd') . $formattedNum; // Format akhir kode memo

        return $kodeMemo;
    }
}
