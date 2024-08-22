<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Detail_invoice;
use App\Models\Sewa_kendaraan;
use App\Models\Invoice_sewakendaraan;
use App\Models\Tarif;
use Illuminate\Support\Facades\Validator;

class InqueryInvoicesewakendaraanController extends Controller
{
    public function index(Request $request)
    {
        Invoice_sewakendaraan::where([
            ['status', 'posting']
        ])->update([
            'status_notif' => true
        ]);

        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $inquery = Invoice_sewakendaraan::query();

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

        return view('admin.inquery_invoicesewakendaraan.index', compact('inquery'));
    }


    public function edit($id)
    {
        $inquery = Invoice_sewakendaraan::where('id', $id)->first();
        $details  = Detail_invoice::where('invoice_sewakendaraan_id', $id)->get();
        // $pelanggans = Pelanggan::all();
        $fakturs = Sewa_kendaraan::where(['status_tagihan' => null,'kategori' => 'PPH', 'status' => 'posting'])->get();
        $tarifs = Tarif::all();
        return view('admin.inquery_invoicesewakendaraan.update', compact('details', 'tarifs', 'fakturs', 'inquery'));
    }

    public function editnonpph($id)
    {
        $inquery = Invoice_sewakendaraan::where('id', $id)->first();
        $details  = Detail_invoice::where('invoice_sewakendaraan_id', $id)->get();
        // $pelanggans = Pelanggan::all();
        $fakturs = Sewa_kendaraan::where(['status_tagihan' => null,'kategori' => 'NON PPH', 'status' => 'posting'])->get();
        $tarifs = Tarif::all();
        return view('admin.inquery_invoicesewakendaraan.updatenon', compact('details', 'tarifs', 'fakturs', 'inquery'));
    }


    public function get_faktursewa($vendor_id)
    {
        $fakturs = Sewa_kendaraan::where(['status_tagihan' => null,'status' => 'posting', 'kategori' => 'PPH', 'vendor_id' => $vendor_id])
            ->with('vendor')
            ->get();
        return response()->json($fakturs);
    }

    public function get_faktursewanonpph($vendor_id)
    {
        $fakturs = Sewa_kendaraan::where(['status_tagihan' => null,'status' => 'posting', 'kategori' => 'NON PPH', 'vendor_id' => $vendor_id])
            ->with('vendor')
            ->get();
        return response()->json($fakturs);
    }


    public function update(Request $request, $id)
    {
        // Validasi data vendor
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

        // Jika validasi vendor gagal, tambahkan pesan error ke array
        if ($validasi_pelanggan->fails()) {
            array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
        }

        $error_pesanans = array();
        $data_pembelians = collect();

        // Jika ada sewa_kendaraan_id dalam permintaan
        if ($request->has('sewa_kendaraan_id')) {
            for ($i = 0; $i < count($request->sewa_kendaraan_id); $i++) {
                // Validasi data faktur
                $validasi_produk = Validator::make($request->all(), [
                    'sewa_kendaraan_id.' . $i => 'required',
                    'kode_faktur.' . $i => 'required',
                    'nama_rute.' . $i => 'required',
                    'no_do.' . $i => 'required',
                    'tanggal_memo.' . $i => 'required',
                    'no_pol.' . $i => 'required',
                    'jumlah.' . $i => 'required',
                    'satuan.' . $i => 'required',
                    'harga.' . $i => 'required',
                    'total.' . $i => 'required',
                ]);

                // Jika validasi produk gagal, tambahkan pesan error ke array
                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Faktur nomor " . ($i + 1) . " belum dilengkapi!");
                }

                // Kumpulkan data pembelian yang valid
                $data_pembelians->push([
                    'detail_id' => $request->detail_ids[$i] ?? null,
                    'sewa_kendaraan_id' => $request->sewa_kendaraan_id[$i] ?? '',
                    'kode_faktur' => $request->kode_faktur[$i] ?? '',
                    'nama_rute' => $request->nama_rute[$i] ?? '',
                    'no_memo' => $request->no_memo[$i] ?? '',
                    'no_do' => $request->no_do[$i] ?? '',
                    'tanggal_memo' => $request->tanggal_memo[$i] ?? '',
                    'no_kabin' => $request->no_kabin[$i] ?? '',
                    'no_pol' => $request->no_pol[$i] ?? '',
                    'jumlah' => $request->jumlah[$i] ?? '',
                    'satuan' => $request->satuan[$i] ?? '',
                    'harga' => $request->harga[$i] ?? '',
                    'nominal_potongan' => $request->nominal_potongan[$i] ?? '',
                    'total' => $request->total[$i] ?? ''
                ]);
            }
        }

        // Jika ada error validasi vendor atau faktur, kembalikan ke halaman sebelumnya
        if ($error_pelanggans || $error_pesanans) {
            return back()
                ->withInput()
                ->with('error_pelanggans', $error_pelanggans)
                ->with('error_pesanans', $error_pesanans)
                ->with('data_pembelians', $data_pembelians);
        }

        // Cari dan perbarui tagihan ekspedisi
        $cetakpdf = Invoice_sewakendaraan::findOrFail($id);
        $cetakpdf->update([
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
            'status' => 'posting',
        ]);

        $updatedFakturEkspedisiIds = [];
        $newFakturEkspedisiIds = [];

        foreach ($data_pembelians as $data_pesanan) {
            $detailPelunasan = Detail_invoice::updateOrCreate(
                ['sewa_kendaraan_id' => $data_pesanan['sewa_kendaraan_id']],
                [
                    'invoice_sewakendaraan_id' => $cetakpdf->id,
                    'kode_faktur' => $data_pesanan['kode_faktur'],
                    'nama_rute' => $data_pesanan['nama_rute'],
                    'no_memo' => $data_pesanan['no_memo'],
                    'no_do' => $data_pesanan['no_do'],
                    'tanggal_memo' => $data_pesanan['tanggal_memo'],
                    'no_kabin' => $data_pesanan['no_kabin'],
                    'no_pol' => $data_pesanan['no_pol'],
                    'jumlah' => $data_pesanan['jumlah'],
                    'satuan' => $data_pesanan['satuan'],
                    'harga' => str_replace(',', '.', str_replace('.', '', $data_pesanan['harga'])),
                    'nominal_potongan' => str_replace(',', '.', str_replace('.', '', $data_pesanan['nominal_potongan'])),
                    'total' => str_replace(',', '.', str_replace('.', '', $data_pesanan['total'])),
                ]
            );
            $updatedFakturEkspedisiIds[] = $detailPelunasan->sewa_kendaraan_id;
            $newFakturEkspedisiIds[] = $data_pesanan['sewa_kendaraan_id'];
        }

        // Update Faktur Ekspedisi statuses
        Sewa_kendaraan::whereIn('id', $updatedFakturEkspedisiIds)->update(['status_tagihan' => 'aktif', 'status' => 'selesai']);

        // Update SPK statuses based on Faktur Ekspedisi IDs
        foreach ($updatedFakturEkspedisiIds as $fakturId) {
            $faktur = Sewa_kendaraan::find($fakturId);
        }

        // Delete Detail_invoice records that are no longer relevant
        Detail_invoice::where('invoice_sewakendaraan_id', $cetakpdf->id)
            ->whereNotIn('sewa_kendaraan_id', $newFakturEkspedisiIds)
            ->delete();

        // Handle Faktur Ekspedisi not updated
        $deletedFakturEkspedisiIds = Sewa_kendaraan::whereNotIn('id', $updatedFakturEkspedisiIds)
            ->pluck('id');
        foreach ($deletedFakturEkspedisiIds as $fakturId) {
            $faktur = Sewa_kendaraan::find($fakturId);
        }

        // Dapatkan detail tagihan yang diperbarui
        $details = Detail_invoice::where('invoice_sewakendaraan_id', $cetakpdf->id)->get();
        return view('admin.inquery_invoicesewakendaraan.show', compact('cetakpdf', 'details'));
    }


    public function show($id)
    {
        $cetakpdf = Invoice_sewakendaraan::where('id', $id)->first();
        $details = Detail_invoice::where('invoice_sewakendaraan_id', $id)->get();

        return view('admin.inquery_invoicesewakendaraan.show', compact('cetakpdf', 'details'));
    }

    public function unpostsewa($id)
    {
        $item = Invoice_sewakendaraan::findOrFail($id);
        $details = Detail_invoice::where('invoice_sewakendaraan_id', $id)->get();

        // Memperbarui status faktur ekspedisi untuk setiap detail yang sesuai
        foreach ($details as $detail) {
            $faktur = Sewa_kendaraan::where(['id' => $detail->sewa_kendaraan_id, 'status' => 'selesai'])->first();
            if ($faktur) {
                $faktur->update(['status_tagihan' => null, 'status' => 'posting']);
            }
        }
        // Memperbarui status tagihan ekspedisi menjadi 'posting'
        $item->update([
            'status' => 'unpost'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function postingsewa($id)
    {
        $item = Invoice_sewakendaraan::findOrFail($id);
        $details = Detail_invoice::where('invoice_sewakendaraan_id', $id)->get();

        // Memperbarui status faktur ekspedisi untuk setiap detail yang sesuai
        foreach ($details as $detail) {
            $faktur = Sewa_kendaraan::where(['id' => $detail->sewa_kendaraan_id, 'status' => 'posting'])->first();
            if ($faktur) {
                $faktur->update(['status_tagihan' => 'aktif', 'status' => 'selesai']);
            }
        }

        // Memperbarui status tagihan ekspedisi menjadi 'posting'
        $item->update([
            'status' => 'posting'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function hapusinvoice($id)
    {
        $tagihan = Invoice_sewakendaraan::where('id', $id)->first();

        if ($tagihan) {
            $detailtagihan = Detail_invoice::where('invoice_sewakendaraan_id', $id)->get();

            Detail_invoice::where('invoice_sewakendaraan_id', $id)->delete();

            // Delete the main Invoice_sewakendaraan instance
            $tagihan->delete();

            return back()->with('success', 'Berhasil menghapus Faktur Ekspedisi');
        } else {
            // Handle the case where the Invoice_sewakendaraan with the given ID is not found
            return back()->with('error', 'Faktur Ekspedisi tidak ditemukan');
        }
    }

    public function deletedetailsewa($id)
    {
        $item = Detail_invoice::find($id);

        if ($item) {
            $item->delete();
            return response()->json(['message' => 'Data deleted successfully']);
        } else {
            return response()->json(['message' => 'Detail Faktur not found'], 404);
        }
    }
}