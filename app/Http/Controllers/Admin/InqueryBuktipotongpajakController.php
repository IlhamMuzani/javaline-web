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

class InqueryBuktipotongpajakController extends Controller
{
    public function index(Request $request)
    {
        Bukti_potongpajak::where([
            ['status', 'posting']
        ])->update([
            'status_notif' => true
        ]);

        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $inquery = Bukti_potongpajak::query();

        if ($status) {
            $inquery->where('status', $status);
        }

        if ($tanggal_awal && $tanggal_akhir) {
            $inquery->whereBetween('tanggal_awal', [$tanggal_awal, $tanggal_akhir]);
        } elseif ($tanggal_awal) {
            $inquery->where('tanggal_awal', '>=', $tanggal_awal);
        } elseif ($tanggal_akhir) {
            $inquery->where('tanggal_awal', '<=', $tanggal_akhir);
        } else {
            // Jika tidak ada filter tanggal hari ini
            $inquery->whereDate('tanggal_awal', Carbon::today());
        }

        $inquery->orderBy('id', 'DESC');
        $inquery = $inquery->get();

        return view('admin.inquery_buktipotongpajak.index', compact('inquery'));
    }


    public function edit($id)
    {
        $buktipotongpajak = Bukti_potongpajak::where('id', $id)->first();

        return view('admin.inquery_buktipotongpajak.update', compact('buktipotongpajak'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nomor_faktur' => 'required',
            ],
            [
                'nomor_faktur.required' => 'Masukkan nomor faktur',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        Bukti_potongpajak::where('id', $id)->update([
            'nomor_faktur' => $request->nomor_faktur,
            'periode_awal' => $request->periode_awal,
            'status' => 'posting',
        ]);

        $cetakpdf = Bukti_potongpajak::where('id', $id)->first();
        $details = Detail_bukti::where('bukti_potongpajak_id', $id)->get();

        return view('admin.inquery_buktipotongpajak.show', compact('cetakpdf', 'details'));
    }

    public function show($id)
    {
        $cetakpdf = Bukti_potongpajak::where('id', $id)->first();
        $details = Detail_bukti::where('bukti_potongpajak_id', $id)->get();

        return view('admin.inquery_buktipotongpajak.show', compact('cetakpdf', 'details'));
    }


    public function unpostbukti($id)
    {
        $faktur = Bukti_potongpajak::find($id);

        if (!$faktur) {
            return back()->with('error', 'Bukti tidak ditemukan');
        }

        $detail_faktur = Detail_bukti::where('bukti_potongpajak_id', $id)->first();

        if ($detail_faktur) {
            $detailfakturs = Detail_bukti::where('bukti_potongpajak_id', $id)->get();
            foreach ($detailfakturs as $detail) {
                if ($detail->tagihan_ekspedisi_id) {
                    // Update status memo ekspedisi
                    Tagihan_ekspedisi::where(['id' => $detail->tagihan_ekspedisi_id])->update(['status_terpakai' => null]);
                    // Update status memotambahan
                }
            }
        }

        // Update the status of the faktur to 'unpost'
        $faktur->update([
            'status' => 'unpost'
        ]);

        // Return back with a success message
        return back()->with('success', 'Berhasil');
    }

    public function postingbukti($id)
    {
        $faktur = Bukti_potongpajak::where('id', $id)->first();

        if (!$faktur) {
            return back()->with('error', 'Bukti tidak ditemukan');
        }

        $detail_faktur = Detail_bukti::where('bukti_potongpajak_id', $id)->first();

        if ($detail_faktur) {
            $detailfakturs = Detail_bukti::where('bukti_potongpajak_id', $id)->get();
            foreach ($detailfakturs as $detail) {
                if ($detail->tagihan_ekspedisi_id) {
                    // Update status memo ekspedisi
                    Tagihan_ekspedisi::where(['id' => $detail->tagihan_ekspedisi_id])->update(['status_terpakai' => 'digunakan']);
                }
            }
        }

        $faktur->update([
            'status' => 'posting'
        ]);
        return back()->with('success', 'Berhasil');
    }

    public function hapusbukti($id)
    {
        $bukti = Bukti_potongpajak::where('id', $id)->first();

        if ($bukti) {
            $detailtagihan = Detail_bukti::where('bukti_potongpajak_id', $id)->get();
            // Delete related Detail_tagihan instances
            Detail_bukti::where('bukti_potongpajak_id', $id)->delete();

            // Delete the main bukti_potongpajak_id instance
            $bukti->delete();

            return back()->with('success', 'Berhasil menghapus Faktur Ekspedisi');
        } else {
            // Handle the case where the bukti_potongpajak_id with the given ID is not found
            return back()->with('error', 'Bukti tidak ditemukan');
        }
    }

    public function delete_item($id)
    {
        $detail = Detail_bukti::where('id', $id);
        if ($detail->exists()) {
            $detail->delete();
        }

        return true;
    }


    public function cetak_buktifilter(Request $request)
    {
        $selectedIds = explode(',', $request->input('ids'));

        // Mengambil faktur berdasarkan id yang dipilih
        $buktis = Bukti_potongpajak::whereIn('id', $selectedIds)->orderBy('id', 'DESC')->get();

        $pdf = PDF::loadView('admin.inquery_buktipotongpajak.cetak_pdffilter', compact('buktis'));
        $pdf->setPaper('a4');

        return $pdf->stream('Bukti_Potong_pajak.pdf');
    }

    public function cetak_buktifilterfoto(Request $request)
    {
        $selectedIds = explode(',', $request->input('ids'));

        // Mengambil faktur berdasarkan id yang dipilih
        $buktis = Bukti_potongpajak::whereIn('id', $selectedIds)->orderBy('id', 'DESC')->get();

        $detail_buktis = Detail_bukti::whereIn('bukti_potongpajak_id', $buktis->pluck('id'))->get();

        // Mengambil semua ID tagihan_ekspedisi yang terkait dengan detail_bukti yang dipilih
        $tagihanEkspedisiIds = $detail_buktis->pluck('tagihan_ekspedisi_id')->unique();

        // Mengambil semua tagihan ekspedisi yang terkait
        $tagihan_ekspedisis = Tagihan_ekspedisi::whereIn('id', $tagihanEkspedisiIds)->get();

        // Mengambil semua detail tagihan yang terkait
        $detail_tagihans = Detail_tagihan::whereIn('tagihan_ekspedisi_id', $tagihanEkspedisiIds)->get();

        // Load the view and pass the data
        $pdf = PDF::loadView('admin.inquery_buktipotongpajak.cetak_pdffilterfoto', compact('buktis', 'detail_buktis', 'tagihan_ekspedisis', 'detail_tagihans'));
        $pdf->setPaper('a4');

        return $pdf->stream('Bukti_Potong_pajak.pdf');
    }

}