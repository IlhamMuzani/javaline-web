<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use App\Models\Ban;
use App\Models\Merek;
use App\Models\Ukuran;
use App\Models\Typeban;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\Pembelian_ban;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\Biaya_tambahan;
use App\Models\Detail_memo;
use App\Models\Detail_memotambahan;
use App\Models\Detail_tagihan;
use App\Models\Faktur_ekspedisi;
use App\Models\Kendaraan;
use App\Models\Memo_ekspedisi;
use App\Models\Memotambahan;
use App\Models\Pelanggan;
use App\Models\Penerimaan_kaskecil;
use App\Models\Potongan_memo;
use App\Models\Rute_perjalanan;
use App\Models\Saldo;
use App\Models\Tagihan_ekspedisi;
use App\Models\Tarif;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Egulias\EmailValidator\Result\Reason\DetailedReason;

class InqueryTagihanekspedisiController extends Controller
{
    public function index(Request $request)
    {
        Tagihan_ekspedisi::where([
            ['status', 'posting']
        ])->update([
            'status_notif' => true
        ]);

        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $inquery = Tagihan_ekspedisi::query();

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

        return view('admin.inquery_tagihanekspedisi.index', compact('inquery'));
    }



    public function edit($id)
    {
        $inquery = Tagihan_ekspedisi::where('id', $id)->first();
        $details  = Detail_tagihan::where('tagihan_ekspedisi_id', $id)->get();
        // $pelanggans = Pelanggan::all();
        $fakturs = Faktur_ekspedisi::where(['status_tagihan' => null, 'status' => 'posting'])->get();
        $tarifs = Tarif::all();
        return view('admin.inquery_tagihanekspedisi.update', compact('details', 'tarifs', 'fakturs', 'inquery'));
    }

    public function update(Request $request, $id)
    {
        $validasi_pelanggan = Validator::make(
            $request->all(),
            [
                'kategori' => 'required',
                'pelanggan_id' => 'required',
                'grand_total' => 'required',
            ],
            [
                'kategori.required' => 'Pilih kategori',
                'pelanggan_id.required' => 'Pilih Pelanggan',
                'grand_total.required' => 'Masukkan grand total',
            ]
        );

        $error_pelanggans = array();

        if ($validasi_pelanggan->fails()) {
            array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
        }

        $error_pesanans = array();
        $data_pembelians = collect();

        if ($request->has('faktur_ekspedisi_id')) {
            for ($i = 0; $i < count($request->faktur_ekspedisi_id); $i++) {
                $validasi_produk = Validator::make($request->all(), [
                    'faktur_ekspedisi_id.' . $i => 'required',
                    'kode_faktur.' . $i => 'required',
                    'nama_rute.' . $i => 'required',
                    // 'no_memo.' . $i => 'required',
                    'no_do.' . $i => 'required',
                    // 'no_po.' . $i => 'required',
                    'tanggal_memo.' . $i => 'required',
                    'no_kabin.' . $i => 'required',
                    'no_pol.' . $i => 'required',
                    'jumlah.' . $i => 'required',
                    'satuan.' . $i => 'required',
                    'harga.' . $i => 'required',
                    'total.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Faktur nomor " . ($i + 1) . " belum dilengkapi!"); // Corrected the syntax for concatenation and indexing
                }

                $faktur_ekspedisi_id = is_null($request->faktur_ekspedisi_id[$i]) ? '' : $request->faktur_ekspedisi_id[$i];
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
                $total = is_null($request->total[$i]) ? '' : $request->total[$i];

                $data_pembelians->push([
                    'detail_id' => $request->detail_ids[$i] ?? null,
                    'faktur_ekspedisi_id' => $faktur_ekspedisi_id,
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

        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');

        $tanggal = Carbon::now()->format('Y-m-d');
        $cetakpdf = Tagihan_ekspedisi::findOrFail($id);

        // Update the main transaction
        $cetakpdf->update([
            'kategori' => $request->kategori,
            'pelanggan_id' => $request->pelanggan_id,
            'kode_pelanggan' => $request->kode_pelanggan,
            'nama_pelanggan' => $request->nama_pelanggan,
            'alamat_pelanggan' => $request->alamat_pelanggan,
            'telp_pelanggan' => $request->telp_pelanggan,
            'periode_awal' => $request->periode_awal,
            'periode_akhir' => $request->periode_akhir,
            'pph' => str_replace(',', '.', str_replace('.', '', $request->pph)),
            'sub_total' => str_replace(',', '.', str_replace('.', '', $request->sub_total)),
            'grand_total' => str_replace(',', '.', str_replace('.', '', $request->grand_total)),
            'keterangan' => $request->keterangan,
            'status' => 'posting',
        ]);

        $transaksi_id = $cetakpdf->id;
        $detailIds = $request->input('detail_ids');

        foreach ($data_pembelians as $data_pesanan) {
            $detailId = $data_pesanan['detail_id'];

            if ($detailId) {
                $existingDetail = Detail_tagihan::findOrFail($detailId);
                $existingDetail->update([
                    'tagihan_ekspedisi_id' => $cetakpdf->id,
                    'faktur_ekspedisi_id' => $data_pesanan['faktur_ekspedisi_id'],
                    'kode_faktur' => $data_pesanan['kode_faktur'],
                    'nama_rute' => $data_pesanan['nama_rute'],
                    'no_memo' => $data_pesanan['no_memo'],
                    'no_do' => $data_pesanan['no_do'],
                    // 'no_po' => $data_pesanan['no_po'],
                    'tanggal_memo' => $data_pesanan['tanggal_memo'],
                    'no_kabin' => $data_pesanan['no_kabin'],
                    'no_pol' => $data_pesanan['no_pol'],
                    'satuan' => $data_pesanan['satuan'],
                    'jumlah' =>  $data_pesanan['jumlah'],
                    'harga' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['harga'])),
                    'total' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['total'])),
                ]);
                Faktur_ekspedisi::where('id', $existingDetail->faktur_ekspedisi_id)->update(['status_tagihan' => 'aktif', 'status' => 'selesai']);
            } else {
                $existingDetail = Detail_tagihan::where([
                    'tagihan_ekspedisi_id' => $cetakpdf->id,
                    'faktur_ekspedisi_id' => $data_pesanan['faktur_ekspedisi_id'],
                    'kode_faktur' => $data_pesanan['kode_faktur'],
                    'nama_rute' => $data_pesanan['nama_rute'],
                    'no_memo' => $data_pesanan['no_memo'],
                    'no_do' => $data_pesanan['no_do'],
                    // 'no_po' => $data_pesanan['no_po'],
                    'tanggal_memo' => $data_pesanan['tanggal_memo'],
                    'no_kabin' => $data_pesanan['no_kabin'],
                    'no_pol' => $data_pesanan['no_pol'],
                    'jumlah' => $data_pesanan['jumlah'],
                    'satuan' => $data_pesanan['satuan'],
                    // 'jumlah' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['jumlah'])),
                    'harga' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['harga'])),
                    'total' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['total'])),
                ])->first();

                if (!$existingDetail) {
                    $detailTagihan = Detail_tagihan::create([
                        'tagihan_ekspedisi_id' => $cetakpdf->id,
                        'faktur_ekspedisi_id' => $data_pesanan['faktur_ekspedisi_id'],
                        'kode_faktur' => $data_pesanan['kode_faktur'],
                        'nama_rute' => $data_pesanan['nama_rute'],
                        'no_memo' => $data_pesanan['no_memo'],
                        'no_do' => $data_pesanan['no_do'],
                        // 'no_po' => $data_pesanan['no_po'],
                        'tanggal_memo' => $data_pesanan['tanggal_memo'],
                        'no_kabin' => $data_pesanan['no_kabin'],
                        'no_pol' => $data_pesanan['no_pol'],
                        'jumlah' => $data_pesanan['jumlah'],
                        'satuan' => $data_pesanan['satuan'],
                        // 'jumlah' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['jumlah'])),
                        'harga' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['harga'])),
                        'total' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['total'])),
                    ]);

                    Faktur_ekspedisi::where('id', $detailTagihan->faktur_ekspedisi_id)->update(['status_tagihan' => 'aktif', 'status' => 'selesai']);
                }
            }
        }
        $details = Detail_tagihan::where('tagihan_ekspedisi_id', $cetakpdf->id)->get();

        return view('admin.tagihan_ekspedisi.show', compact('cetakpdf', 'details'));
    }

    public function show($id)
    {
        $cetakpdf = Tagihan_ekspedisi::where('id', $id)->first();
        $details = Detail_tagihan::where('tagihan_ekspedisi_id', $id)->get();

        return view('admin.inquery_tagihanekspedisi.show', compact('cetakpdf', 'details'));
    }

    public function unposttagihan($id)
    {
        $item = Tagihan_ekspedisi::findOrFail($id);
        $details = Detail_tagihan::where('tagihan_ekspedisi_id', $id)->get();

        // Memperbarui status faktur ekspedisi untuk setiap detail yang sesuai
        foreach ($details as $detail) {
            Faktur_ekspedisi::where(['id' => $detail->faktur_ekspedisi_id, 'status' => 'selesai'])->update(['status_tagihan' => null, 'status' => 'posting']);
        }

        // Memperbarui status tagihan ekspedisi menjadi 'posting'
        $item->update([
            'status' => 'unpost'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function postingtagihan($id)
    {
        $item = Tagihan_ekspedisi::findOrFail($id);
        $details = Detail_tagihan::where('tagihan_ekspedisi_id', $id)->get();

        // Memperbarui status faktur ekspedisi untuk setiap detail yang sesuai
        foreach ($details as $detail) {
            Faktur_ekspedisi::where(['id' => $detail->faktur_ekspedisi_id, 'status' => 'posting'])->update(['status_tagihan' => 'aktif', 'status' => 'selesai']);
        }

        // Memperbarui status tagihan ekspedisi menjadi 'posting'
        $item->update([
            'status' => 'posting'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function hapustagihan($id)
    {
        $tagihan = Tagihan_ekspedisi::where('id', $id)->first();

        if ($tagihan) {
            $detailtagihan = Detail_tagihan::where('tagihan_ekspedisi_id', $id)->get();

            // Loop through each Detail_tagihan and update associated Faktur_ekspedisi records
            // foreach ($detailtagihan as $detail) {
            //     if ($detail->faktur_ekspedisi_id) {
            //         Faktur_ekspedisi::where('id', $detail->faktur_ekspedisi_id)->update(['status_faktur' => null]);
            //     }
            // }

            // Delete related Detail_tagihan instances
            Detail_tagihan::where('tagihan_ekspedisi_id', $id)->delete();

            // Delete the main Tagihan_ekspedisi instance
            $tagihan->delete();

            return back()->with('success', 'Berhasil menghapus Faktur Ekspedisi');
        } else {
            // Handle the case where the Tagihan_ekspedisi with the given ID is not found
            return back()->with('error', 'Faktur Ekspedisi tidak ditemukan');
        }
    }

    public function deletedetailtagihan($id)
    {
        $item = Detail_tagihan::find($id);

        if ($item) {
            $item->delete();
            return response()->json(['message' => 'Data deleted successfully']);
        } else {
            return response()->json(['message' => 'Detail Faktur not found'], 404);
        }
    }



    // public function hapustagihan($id)
    // {
    //     $item = Tagihan_ekspedisi::where('id', $id)->first();

    //     // $item->detail_tagihan()->delete();
    //     // $item->delete();

    //     // return back()->with('success', 'Berhasil');
    // }
}