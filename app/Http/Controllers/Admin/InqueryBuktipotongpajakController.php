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
        $details = Detail_bukti::where('bukti_potongpajak_id', $id)
            ->select(
                'id as detail_id',
                'tagihan_ekspedisi_id as id',
                'kode_tagihan',
                'tanggal',
                'nama_pelanggan',
                'pph',
                'total',
            )
            ->get();
        $detail_id_data = Detail_bukti::where('bukti_potongpajak_id', $id)->pluck('id', 'tagihan_ekspedisi_id')->toArray();
        $tagihan_ekspedisis = Tagihan_ekspedisi::where(['kategori' => 'PPH', 'status' => 'posting', 'status_terpakai' => null])->get();

        return view('admin.inquery_buktipotongpajak.update', compact('details', 'detail_id_data', 'buktipotongpajak', 'tagihan_ekspedisis'));
    }

    public function update(Request $request, $id)
    {
        $validasi_pelanggan = Validator::make($request->all(), [
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


        $error_pelanggans = array();
        $error_pesanans = array();
        $data_pembelians = collect();

        if ($validasi_pelanggan->fails()) {
            array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
        }

        if ($request->has('id')) {
            foreach ($request->id as $key => $tagihan_ekspedisi_id) {
                $validator_produk = Validator::make($request->all(), []);

                if ($validator_produk->fails()) {
                    $error_pesanans[] = "Invoce nomor " . ($key + 1) . " belum dilengkapi!";
                }

                // $harga = $request->harga[$tagihan_ekspedisi_id] ?? '';
                // $satuan = $request->satuan[$tagihan_ekspedisi_id] ?? '';
                // $jumlah = $request->jumlah[$tagihan_ekspedisi_id] ?? '';
                // $total = $request->total[$tagihan_ekspedisi_id] ?? '';

                $tagihan = Tagihan_ekspedisi::where('id', $tagihan_ekspedisi_id)->first();

                $data_pembelians->push([
                    'id' => $tagihan_ekspedisi_id,
                    'kode_tagihan' => $tagihan->kode_tagihan,
                    'tanggal' => $tagihan->tanggal,
                    'nama_pelanggan' => $tagihan->nama_pelanggan,
                    'pph' => $tagihan->pph,
                    'total' => $tagihan->grand_total,
                ]);
            }
        }

        if ($validasi_pelanggan->fails() || $error_pesanans) {
            return back()
                ->withInput()
                ->with('error_pelanggans', $error_pelanggans)
                ->with('error_pesanans', $error_pesanans)
                ->with('data_pembelians', $data_pembelians);
        }

        Bukti_potongpajak::where('id', $id)->update([
            'kategori' => $request->kategori,
            'kategoris' => $request->kategoris,
            'nomor_faktur' => $request->nomor_faktur,
            'periode_awal' => $request->periode_awal,
            'grand_total' => str_replace(',', '.', str_replace('.', '', $request->grand_total)),
            'status' => 'posting',
        ]);

        // Update or create Detail_bukti records and update Tagihan_ekspedisi status
        foreach ($request->id as $tagihan_ekspedisi_id) {
            $detail = Detail_bukti::where([
                ['bukti_potongpajak_id', $id],
                ['tagihan_ekspedisi_id', $tagihan_ekspedisi_id]
            ])->first();

            if ($detail) {
                $detail->update([
                    'kode_tagihan' => $request->kode_tagihan[$tagihan_ekspedisi_id],
                    'tanggal' => $request->tanggal[$tagihan_ekspedisi_id],
                    'nama_pelanggan' => $request->nama_pelanggan[$tagihan_ekspedisi_id],
                    'pph' => $request->pph[$tagihan_ekspedisi_id],
                    'total' => $request->total[$tagihan_ekspedisi_id]
                ]);
            } else {
                $tagihan = Tagihan_ekspedisi::find($tagihan_ekspedisi_id);
                Detail_bukti::create([
                    'bukti_potongpajak_id' => $id,
                    'tagihan_ekspedisi_id' => $tagihan->id,
                    'kode_tagihan' => $tagihan->kode_tagihan,
                    'tanggal' => $tagihan->tanggal,
                    'nama_pelanggan' => $tagihan->nama_pelanggan,
                    'pph' => $tagihan->pph,
                    'total' => $tagihan->grand_total,
                ]);
            }

            Tagihan_ekspedisi::where('id', $tagihan_ekspedisi_id)->update(['status_terpakai' => 'digunakan']);
        }

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
}