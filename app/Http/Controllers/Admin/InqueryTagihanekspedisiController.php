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
use App\Models\Spk;
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
        $fakturs = Faktur_ekspedisi::where(['kategori' => 'PPH', 'status_tagihan' => null, 'status' => 'posting'])->get();
        $tarifs = Tarif::all();
        return view('admin.inquery_tagihanekspedisi.update', compact('details', 'tarifs', 'fakturs', 'inquery'));
    }

    public function editnonpph($id)
    {
        $inquery = Tagihan_ekspedisi::where('id', $id)->first();
        $details  = Detail_tagihan::where('tagihan_ekspedisi_id', $id)->get();
        // $pelanggans = Pelanggan::all();
        $fakturs = Faktur_ekspedisi::where(['kategori' => 'NON PPH', 'status_tagihan' => null, 'status' => 'posting'])->get();
        $tarifs = Tarif::all();
        return view('admin.inquery_tagihanekspedisi.updatenon', compact('details', 'tarifs', 'fakturs', 'inquery'));
    }


    public function get_fakturtagihan($pelanggan_id)
    {
        $fakturs = Faktur_ekspedisi::where(['status_tagihan' => null, 'status' => 'posting', 'kategori' => 'PPH', 'pelanggan_id' => $pelanggan_id])
            ->with('pelanggan')
            ->with('detail_faktur')
            ->get();
        return response()->json($fakturs);
    }

    public function get_fakturtagihannonpph($pelanggan_id)
    {
        $fakturs = Faktur_ekspedisi::where(['status_tagihan' => null, 'status' => 'posting', 'kategori' => 'NON PPH', 'pelanggan_id' => $pelanggan_id])
            ->with('pelanggan')
            ->with('detail_faktur')
            ->get();
        return response()->json($fakturs);
    }


    public function update(Request $request, $id)
    {
        // Validasi data pelanggan
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

        // Jika validasi pelanggan gagal, tambahkan pesan error ke array
        if ($validasi_pelanggan->fails()) {
            array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
        }

        $error_pesanans = array();
        $data_pembelians = collect();

        // Jika ada faktur_ekspedisi_id dalam permintaan
        if ($request->has('faktur_ekspedisi_id')) {
            for ($i = 0; $i < count($request->faktur_ekspedisi_id); $i++) {
                // Validasi data faktur
                $validasi_produk = Validator::make($request->all(), [
                    'faktur_ekspedisi_id.' . $i => 'required',
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
                    'faktur_ekspedisi_id' => $request->faktur_ekspedisi_id[$i] ?? '',
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
                    'fee' => $request->fee[$i] ?? '',
                    'total' => $request->total[$i] ?? ''
                ]);
            }
        }

        // Jika ada error validasi pelanggan atau faktur, kembalikan ke halaman sebelumnya
        if ($error_pelanggans || $error_pesanans) {
            return back()
                ->withInput()
                ->with('error_pelanggans', $error_pelanggans)
                ->with('error_pesanans', $error_pesanans)
                ->with('data_pembelians', $data_pembelians);
        }

        // Cari dan perbarui tagihan ekspedisi
        $cetakpdf = Tagihan_ekspedisi::findOrFail($id);
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
            'hasil_feeall' => str_replace(',', '.', str_replace('.', '', $request->hasil_feeall)),
            'hasil_potonganfee' => str_replace(',', '.', str_replace('.', '', $request->hasil_potonganfee)),
            'grand_total' => str_replace(',', '.', str_replace('.', '', $request->grand_total)),
            'keterangan' => $request->keterangan,
            'status' => 'posting',
        ]);

        $updatedFakturEkspedisiIds = [];
        $newFakturEkspedisiIds = [];

        foreach ($data_pembelians as $data_pesanan) {
            $detailPelunasan = Detail_tagihan::updateOrCreate(
                ['faktur_ekspedisi_id' => $data_pesanan['faktur_ekspedisi_id']],
                [
                    'tagihan_ekspedisi_id' => $cetakpdf->id,
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
                    'fee' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['fee'])),
                    'total' => str_replace(',', '.', str_replace('.', '', $data_pesanan['total'])),
                ]
            );
            $updatedFakturEkspedisiIds[] = $detailPelunasan->faktur_ekspedisi_id;
            $newFakturEkspedisiIds[] = $data_pesanan['faktur_ekspedisi_id'];
        }

        // Update Faktur Ekspedisi statuses
        Faktur_ekspedisi::whereIn('id', $updatedFakturEkspedisiIds)->update(['status_tagihan' => 'aktif', 'status' => 'selesai']);

        // Update SPK statuses based on Faktur Ekspedisi IDs
        foreach ($updatedFakturEkspedisiIds as $fakturId) {
            $faktur = Faktur_ekspedisi::find($fakturId);
            if ($faktur) {
                $spk = Spk::find($faktur->spk_id);
                if ($spk) {
                    $spk->update(['status_spk' => 'invoice']);
                }
            }
        }

        // Delete Detail_tagihan records that are no longer relevant
        Detail_tagihan::where('tagihan_ekspedisi_id', $cetakpdf->id)
            ->whereNotIn('faktur_ekspedisi_id', $newFakturEkspedisiIds)
            ->delete();

        // Dapatkan detail tagihan yang diperbarui
        $details = Detail_tagihan::where('tagihan_ekspedisi_id', $cetakpdf->id)->get();
        return view('admin.tagihan_ekspedisi.show', compact('cetakpdf', 'details'));
    }


    public function show($id)
    {
        $cetakpdf = Tagihan_ekspedisi::where('id', $id)->first();
        $details = Detail_tagihan::where('tagihan_ekspedisi_id', $id)->get();

        return view('admin.inquery_tagihanekspedisi.show', compact('cetakpdf', 'details'));
    }


    public function no_resi(Request $request, $id)
    {
        // Ambil semua detail invoice yang berkaitan dengan tagihan ekspedisi
        $detail_invoice = Detail_tagihan::where('tagihan_ekspedisi_id', $id)->get();

        // Validasi input
        $validator = Validator::make(
            $request->all(),
            [
                'no_resi' => 'required',
            ],
            [
                'no_resi.required' => 'Masukkan nomor resi.',
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', implode(', ', $errors));
        }

        // Update kolom no_resi di setiap pengambilan_do yang terkait
        foreach ($detail_invoice as $detail) {
            if ($detail->faktur_ekspedisi && $detail->faktur_ekspedisi->spk) {
                $spk = $detail->faktur_ekspedisi->spk;

                // Pastikan `pengambilan_do` adalah koleksi dari relasi yang benar, lalu iterasi dan update
                foreach ($spk->pengambilan_do as $pengambilan_do) {
                    $pengambilan_do->no_resi = $request->no_resi;
                    $pengambilan_do->save();
                }
            }
        }

        // Update no_resi di tabel tagihan_ekspedisi
        $item = Tagihan_ekspedisi::findOrFail($id);
        $item->no_resi = $request->no_resi;
        $item->save();

        return response()->json(['success' => true, 'message' => 'Nomor resi berhasil disimpan.']);
    }

    public function unposttagihan($id)
    {
        $item = Tagihan_ekspedisi::findOrFail($id);
        $details = Detail_tagihan::where('tagihan_ekspedisi_id', $id)->get();

        // Memperbarui status faktur ekspedisi untuk setiap detail yang sesuai
        foreach ($details as $detail) {
            $faktur = Faktur_ekspedisi::where(['id' => $detail->faktur_ekspedisi_id, 'status' => 'selesai'])->first();
            if ($faktur) {
                $faktur->update(['status_tagihan' => null, 'status' => 'posting']);

                // Update status spk
                $spk = Spk::find($faktur->spk_id);
                if ($spk) {
                    $spk->update(['status_spk' => 'faktur']);
                }
            }
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
            $faktur = Faktur_ekspedisi::where(['id' => $detail->faktur_ekspedisi_id, 'status' => 'posting'])->first();
            if ($faktur) {
                $faktur->update(['status_tagihan' => 'aktif', 'status' => 'selesai']);

                // Update status spk
                $spk = Spk::find($faktur->spk_id);
                if ($spk) {
                    $spk->update(['status_spk' => 'invoice']);
                }
            }
        }

        // Memperbarui status tagihan ekspedisi menjadi 'posting'
        $item->update([
            'status' => 'posting'
        ]);

        return back()->with('success', 'Berhasil');
    }


    public function postingfiltertagihan(Request $request)
    {
        $selectedIds = array_reverse(explode(',', $request->input('ids')));
        $tagihans = Tagihan_ekspedisi::whereIn('id', $selectedIds)->orderBy('id', 'DESC')->get();

        foreach ($tagihans as $tagihan) {
            if ($tagihan && $tagihan->status == 'unpost') {
                $detailpelunasan = Detail_tagihan::where('tagihan_ekspedisi_id', $tagihan->id)->get();
                foreach ($detailpelunasan as $detail) {
                    $faktur = Faktur_ekspedisi::where(['id' => $detail->faktur_ekspedisi_id, 'status' => 'posting'])->first();
                    if ($faktur) {
                        $faktur->update(['status_tagihan' => 'aktif', 'status' => 'selesai']);

                        // Update status spk
                        $spk = Spk::find($faktur->spk_id);
                        if ($spk) {
                            $spk->update(['status_spk' => 'invoice']);
                        }
                    }
                }
                $tagihan->update([
                    'status' => 'posting'
                ]);
            }
        }
    }

    public function unpostfiltertagihan(Request $request)
    {
        // Ambil ID yang dipilih, urutkan dari yang terakhir
        $selectedIds = array_reverse(explode(',', $request->input('ids')));
        // Ambil data tagihan yang sesuai dengan ID yang dipilih, diurutkan berdasarkan ID dari terbesar
        $tagihans = Tagihan_ekspedisi::whereIn('id', $selectedIds)->orderBy('id', 'DESC')->get();

        // Loop melalui setiap tagihan yang diambil
        foreach ($tagihans as $tagihan) {
            // Cek apakah tagihan ada dan statusnya 'posting'
            if ($tagihan && $tagihan->status == 'posting') {
                // Ambil detail tagihan yang terkait dengan tagihan saat ini
                $detailtagihan = Detail_tagihan::where('tagihan_ekspedisi_id', $tagihan->id)->get();
                foreach ($detailtagihan as $detail) {
                    // Cek apakah faktur dengan status 'selesai' ada
                    $faktur = Faktur_ekspedisi::where(['id' => $detail->faktur_ekspedisi_id, 'status' => 'selesai'])->first();
                    if ($faktur) {
                        // Update status faktur
                        $faktur->update(['status_tagihan' => null, 'status' => 'posting']);

                        // Update status spk jika spk ditemukan
                        $spk = Spk::find($faktur->spk_id);
                        if ($spk) {
                            $spk->update(['status_spk' => 'faktur']);
                        }
                    }
                }
                // Update status tagihan menjadi 'unpost'
                $tagihan->update([
                    'status' => 'unpost'
                ]);
            }
        }
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