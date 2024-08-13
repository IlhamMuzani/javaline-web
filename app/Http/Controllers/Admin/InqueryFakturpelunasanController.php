<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Detail_pelunasan;
use App\Models\Detail_pelunasanpotongan;
use App\Models\Detail_pelunasanreturn;
use App\Models\Faktur_ekspedisi;
use App\Models\Faktur_pelunasan;
use App\Models\Faktur_penjualanreturn;
use App\Models\Potongan_penjualan;
use App\Models\Spk;
use App\Models\Tagihan_ekspedisi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InqueryFakturpelunasanController extends Controller
{

    public function updateDeletedAtpelunasan()
    {
        DB::table('detail_pelunasans')
            ->where('deleted_at', '2024-07-25 14:56:08')
            ->update(['deleted_at' => null]);
        return response()->json(['message' => 'Kolom deleted_at telah diubah menjadi null'], 200);
    }


    public function index(Request $request)
    {
        Faktur_pelunasan::where([
            ['status', 'posting']
        ])->update([
            'status_notif' => true
        ]);

        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $inquery = Faktur_pelunasan::query();

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
            $inquery->whereDate('tanggal_awal', Carbon::today());
        }

        $inquery->orderBy('id', 'DESC');
        $inquery = $inquery->get();

        return view('admin.inquery_fakturpelunasan.index', compact('inquery'));
    }

    public function edit($id)
    {
        $inquery = Faktur_pelunasan::where('id', $id)->first();
        $invoices = Tagihan_ekspedisi::whereDoesntHave('detail_tagihan', function ($query) {
            $query->whereHas('faktur_ekspedisi', function ($query) {
                $query->whereNotNull('status_pelunasan');
            });
        })->orWhereHas('detail_tagihan', function ($query) {
            $query->whereHas('faktur_ekspedisi', function ($query) {
                $query->whereNull('status_pelunasan');
            });
        })->get();
        $details  = Detail_pelunasan::where('faktur_pelunasan_id', $id)->get();
        $detailsreturn  = Detail_pelunasanreturn::where('faktur_pelunasan_id', $id)->get();
        $detailspotongan  = Detail_pelunasanpotongan::where('faktur_pelunasan_id', $id)->get();

        $fakturs = Faktur_ekspedisi::get();
        $returns = Faktur_penjualanreturn::where('status', 'posting')->get();
        $potonganlains = Potongan_penjualan::where('status', 'posting')->get();

        return view('admin.inquery_fakturpelunasan.update', compact('fakturs', 'details', 'detailsreturn', 'detailspotongan', 'inquery', 'returns', 'potonganlains', 'invoices'));
    }

    public function update(Request $request, $id)
    {
        $validasi_pelanggan = Validator::make(
            $request->all(),
            [
                'pelanggan_id' => 'required',
                'nominal' => 'required',
            ],
            [
                'pelanggan_id.required' => 'Pilih Pelanggan',
                'nominal.required' => 'Masukkan nominal',
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

        if ($request->has('faktur_ekspedisi_id')) {
            for ($i = 0; $i < count($request->faktur_ekspedisi_id); $i++) {
                $validasi_produk = Validator::make($request->all(), [
                    'faktur_ekspedisi_id.' . $i => 'required',
                    'kode_faktur.' . $i => 'required',
                    'tanggal_faktur.' . $i => 'required',
                    'total.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Faktur nomor " . ($i + 1) . " belum dilengkapi!"); // Corrected the syntax for concatenation and indexing
                }
                $faktur_ekspedisi_id = is_null($request->faktur_ekspedisi_id[$i]) ? '' : $request->faktur_ekspedisi_id[$i];
                $kode_faktur = is_null($request->kode_faktur[$i]) ? '' : $request->kode_faktur[$i];
                $tanggal_faktur = is_null($request->tanggal_faktur[$i]) ? '' : $request->tanggal_faktur[$i];
                $total = is_null($request->total[$i]) ? '' : $request->total[$i];

                $data_pembelians->push([
                    'faktur_ekspedisi_id' => $faktur_ekspedisi_id,
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
                    'detail_id' => $request->detail_ids[$i] ?? null,
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
                    'detail_idd' => $request->detail_idss[$i] ?? null,
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

        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');
        $tanggal = Carbon::now()->format('Y-m-d');
        $cetakpdf = Faktur_pelunasan::findOrFail($id);
        $selisih = (int)str_replace(['Rp', '.', ' '], '', $request->selisih);
        $totalpembayaran = (int)str_replace(['Rp', '.', ' '], '', $request->totalpembayaran);

        $cetakpdf->update([
            'tagihan_ekspedisi_id' => $request->tagihan_ekspedisi_id,
            'kode_tagihan' => $request->kode_tagihan,
            'pelanggan_id' => $request->pelanggan_id,
            'kode_pelanggan' => $request->kode_pelanggan,
            'nama_pelanggan' => $request->nama_pelanggan,
            'alamat_pelanggan' => $request->alamat_pelanggan,
            'telp_pelanggan' => $request->telp_pelanggan,
            'keterangan' => $request->keterangan,
            'saldo_masuk' => str_replace(',', '.', str_replace('.', '', $request->saldo_masuk  ?? '0')),
            'totalpenjualan' => str_replace(
                ',',
                '.',
                str_replace('.', '', $request->totalpenjualan  ?? '0')
            ),
            'dp' => str_replace(',', '.', str_replace('.', '', $request->dp  ?? '0')),
            'potonganselisih' => str_replace(',', '.', str_replace('.', '', $request->potonganselisih  ?? '0')),
            'totalpembayaran' => str_replace(',', '.', str_replace('.', '', $request->totalpembayaran  ?? '0')),
            'selisih' =>  $selisih,
            'potongan' => $request->potongan ? str_replace(',', '.', str_replace('.', '', $request->potongan)) : 0,
            'ongkos_bongkar' => $request->ongkos_bongkar ? str_replace(',', '.', str_replace('.', '', $request->ongkos_bongkar)) : 0,
            'kategori' => $request->kategori,
            'nomor' => $request->nomor,
            'tanggal_transfer' => $request->tanggal_transfer,
            'nominal' =>  $request->nominal ? str_replace(',', '.', str_replace('.', '', $request->nominal)) : 0,
            'status' => 'posting',
        ]);

        Tagihan_ekspedisi::where('id', $request->tagihan_ekspedisi_id)->update([
            'status' => 'selesai',
        ]);

        $transaksi_id = $cetakpdf->id;
        $detailIds = $request->input('detail_idss');
        $detailIds = $request->input('detail_ids');

        $updatedFakturEkspedisiIds = [];
        $newFakturEkspedisiIds = [];

        foreach ($data_pembelians as $data_pesanan) {
            $detailPelunasan = Detail_pelunasan::updateOrCreate(
                ['faktur_ekspedisi_id' => $data_pesanan['faktur_ekspedisi_id']],
                [
                    'faktur_pelunasan_id' => $cetakpdf->id,
                    'kode_faktur' => $data_pesanan['kode_faktur'],
                    'tanggal_faktur' => $data_pesanan['tanggal_faktur'],
                    'total' => str_replace(',', '.', str_replace('.', '', $data_pesanan['total'])),
                    'status' => 'posting',
                ]
            );
            $updatedFakturEkspedisiIds[] = $detailPelunasan->faktur_ekspedisi_id;
            $newFakturEkspedisiIds[] = $data_pesanan['faktur_ekspedisi_id'];
        }

        Faktur_ekspedisi::whereIn('id', $updatedFakturEkspedisiIds)->update(['status_pelunasan' => 'aktif']);
        foreach ($updatedFakturEkspedisiIds as $fakturId) {
            $faktur = Faktur_ekspedisi::find($fakturId);
            if ($faktur) {
                $spk = Spk::find($faktur->spk_id);
                if ($spk) {
                    $spk->update(['status_spk' => 'pelunasan']);
                }
            }
        }

        // Delete Detail_tagihan records that are no longer relevant
        Detail_pelunasan::where('faktur_pelunasan_id', $cetakpdf->id)
            ->whereNotIn('faktur_ekspedisi_id', $newFakturEkspedisiIds)
            ->delete();

        $deletedFakturEkspedisiIds = Faktur_ekspedisi::whereNotIn('id', $updatedFakturEkspedisiIds)
            ->pluck('id');
        foreach ($deletedFakturEkspedisiIds as $fakturId) {
            $faktur = Faktur_ekspedisi::find($fakturId);
            if ($faktur) {
                $spk = Spk::find($faktur->spk_id);
                if ($spk) {
                    $spk->update(['status_spk' => 'invoice']);
                }
            }
        }

        foreach ($data_pembelians2 as $data_pesanan) {
            $detailId = $data_pesanan['detail_id'];

            if ($detailId) {
                Detail_pelunasanreturn::where('id', $detailId)->update([
                    'faktur_pelunasan_id' => $cetakpdf->id,
                    'faktur_ekspedisi_id' => $data_pesanan['faktur_id'],
                    'nota_return_id' => $data_pesanan['nota_return_id'],
                    'kode_potongan' => $data_pesanan['kode_potongan'],
                    'keterangan_potongan' => $data_pesanan['keterangan_potongan'],
                    'nominal_potongan' => str_replace(',', '.', str_replace('.', '', $data_pesanan['nominal_potongan'])),
                    'status' => 'posting',
                ]);
            } else {
                $existingDetail = Detail_pelunasanreturn::where([
                    'faktur_pelunasan_id' => $cetakpdf->id,
                    'faktur_ekspedisi_id' => $data_pesanan['faktur_id'],
                    'nota_return_id' => $data_pesanan['nota_return_id'],
                    'kode_potongan' => $data_pesanan['kode_potongan'],
                    'keterangan_potongan' => $data_pesanan['keterangan_potongan'],
                    'nominal_potongan' => str_replace(',', '.', str_replace('.', '', $data_pesanan['nominal_potongan'])),
                    'status' => 'posting',
                ])->first();


                if (!$existingDetail) {
                    Detail_pelunasanreturn::create([
                        'faktur_pelunasan_id' => $cetakpdf->id,
                        'faktur_ekspedisi_id' => $data_pesanan['faktur_id'],
                        'nota_return_id' => $data_pesanan['nota_return_id'],
                        'kode_potongan' => $data_pesanan['kode_potongan'],
                        'keterangan_potongan' => $data_pesanan['keterangan_potongan'],
                        'nominal_potongan' => str_replace(',', '.', str_replace('.', '', $data_pesanan['nominal_potongan'])),
                        'status' => 'posting',
                    ]);
                }
            }
        }

        foreach ($data_pembelians3 as $data_pesanan) {
            $detailId = $data_pesanan['detail_idd'];

            if ($detailId) {
                Detail_pelunasanpotongan::where('id', $detailId)->update([
                    'faktur_pelunasan_id' => $cetakpdf->id,
                    'potongan_penjualan_id' => $data_pesanan['potongan_penjualan_id'],
                    'kode_potonganlain' => $data_pesanan['kode_potonganlain'],
                    'keterangan_potonganlain' => $data_pesanan['keterangan_potonganlain'],
                    'nominallain' => str_replace(',', '.', str_replace('.', '', $data_pesanan['nominallain'])),
                    'status' => 'posting',
                ]);
                Potongan_penjualan::where('id', $data_pesanan['potongan_penjualan_id'])->update(['status' => 'selesai']);
            } else {
                $existingDetail = Detail_pelunasanpotongan::where([
                    'faktur_pelunasan_id' => $cetakpdf->id,
                    'potongan_penjualan_id' => $data_pesanan['potongan_penjualan_id'],
                    'kode_potonganlain' => $data_pesanan['kode_potonganlain'],
                    'keterangan_potonganlain' => $data_pesanan['keterangan_potonganlain'],
                    'nominallain' => str_replace(',', '.', str_replace('.', '', $data_pesanan['nominallain'])),
                    'status' => 'posting',
                ])->first();


                if (!$existingDetail) {
                    Detail_pelunasanpotongan::create([
                        'faktur_pelunasan_id' => $cetakpdf->id,
                        'potongan_penjualan_id' => $data_pesanan['potongan_penjualan_id'],
                        'kode_potonganlain' => $data_pesanan['kode_potonganlain'],
                        'keterangan_potonganlain' => $data_pesanan['keterangan_potonganlain'],
                        'nominallain' => str_replace(',', '.', str_replace('.', '', $data_pesanan['nominallain'])),
                        'status' => 'posting',
                    ]);
                    Potongan_penjualan::where('id', $data_pesanan['potongan_penjualan_id'])->update(['status' => 'selesai']);
                }
            }
        }
        $details = Detail_pelunasan::where('faktur_pelunasan_id', $cetakpdf->id)->get();

        return view('admin.inquery_fakturpelunasan.show', compact('cetakpdf', 'details'));
    }
    public function show($id)
    {
        $cetakpdf = Faktur_pelunasan::where('id', $id)->first();
        $details = Detail_pelunasan::where('faktur_pelunasan_id', $id)->get();

        return view('admin.inquery_fakturpelunasan.show', compact('cetakpdf', 'details'));
    }

    public function unpostpelunasan($id)
    {
        $item = Faktur_pelunasan::find($id);
        if (!$item) {
            return back()->with('error', 'Faktur pelunasan tidak ditemukan');
        }
        $detailpelunasan = Detail_pelunasan::where('faktur_pelunasan_id', $id)->get();
        foreach ($detailpelunasan as $detail) {
            if ($detail->faktur_ekspedisi_id) {
                $fakturEkspedisi = Faktur_ekspedisi::find($detail->faktur_ekspedisi_id);
                if ($fakturEkspedisi && $fakturEkspedisi->status_pelunasan == 'aktif') {
                    $fakturEkspedisi->update(['status_pelunasan' => null]);
                    $spk = Spk::find($fakturEkspedisi->spk_id);
                    if ($spk) {
                        $spk->update(['status_spk' => 'invoice']);
                    }
                }
            }
        }
        foreach (Detail_pelunasanreturn::where('faktur_pelunasan_id', $id)->get() as $detail) {
            $detail->update(['status' => 'unpost']);
        }
        foreach (Detail_pelunasanpotongan::where('faktur_pelunasan_id', $id)->get() as $detail) {
            $detail->update(['status' => 'unpost']);

            Potongan_penjualan::where(['id' => $detail->potongan_penjualan_id, 'status' => 'selesai'])->update(['status' => 'posting']);
        }

        Tagihan_ekspedisi::where('id', $item->tagihan_ekspedisi_id)->update([
            'status' => 'posting',
        ]);

        try {
            $item->update(['status' => 'unpost']);
            foreach ($detailpelunasan as $detail) {
                $detail->update(['status' => 'unpost']);
            }
            return back()->with('success', 'Berhasil unposting pelunasan');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal unposting pelunasan: ' . $e->getMessage());
        }
    }



    public function postingpelunasan($id)
    {
        $item = Faktur_pelunasan::find($id);
        if (!$item) {
            return back()->with('error', 'Faktur pelunasan tidak ditemukan');
        }
        $detailpelunasan = Detail_pelunasan::where('faktur_pelunasan_id', $id)->get();
        foreach ($detailpelunasan as $detail) {
            if ($detail->faktur_ekspedisi_id) {
                $fakturEkspedisi = Faktur_ekspedisi::find($detail->faktur_ekspedisi_id);
                if ($fakturEkspedisi && $fakturEkspedisi->status_pelunasan == null) {
                    $fakturEkspedisi->update(['status_pelunasan' => 'aktif']);
                    $spk = Spk::find($fakturEkspedisi->spk_id);
                    if ($spk) {
                        $spk->update(['status_spk' => 'pelunasan']);
                    }
                }
            }
        }
        foreach (Detail_pelunasanreturn::where('faktur_pelunasan_id', $id)->get() as $detail) {
            $detail->update(['status' => 'posting']);
        }
        foreach (Detail_pelunasanpotongan::where('faktur_pelunasan_id', $id)->get() as $detail) {
            $detail->update(['status' => 'posting']);
            Potongan_penjualan::where(['id' => $detail->potongan_penjualan_id, 'status' => 'posting'])->update(['status' => 'selesai']);
        }
        Tagihan_ekspedisi::where('id', $item->tagihan_ekspedisi_id)->update([
            'status' => 'selesai',
        ]);
        try {
            $item->update(['status' => 'posting']);
            foreach ($detailpelunasan as $detail) {
                $detail->update(['status' => 'posting']);
            }
            return back()->with('success', 'Berhasil posting pelunasan');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal posting pelunasan: ' . $e->getMessage());
        }
    }



    public function hapuspelunasan($id)
    {
        $item = Faktur_pelunasan::where('id', $id)->first();

        if ($item) {
            $detailpelunasan = Detail_pelunasan::where('faktur_pelunasan_id', $id)->get();
            Detail_pelunasan::where('faktur_pelunasan_id', $id)->delete();
            Detail_pelunasanreturn::where('faktur_pelunasan_id', $id)->delete();
            Detail_pelunasanpotongan::where('faktur_pelunasan_id', $id)->delete();
            $item->delete();

            return back()->with('success', 'Berhasil menghapus Pelunasan Ekspedisi');
        } else {
            return back()->with('error', 'Pelunasan Ekspedisi tidak ditemukan');
        }
    }

    public function deleteRow(Request $request)
    {
        $rowId = $request->input('row_id');
        Detail_pelunasan::destroy($rowId);
        return response()->json(['success' => true]);
    }

    public function deletedetailpelunasan($id)
    {
        $item = Detail_pelunasan::find($id);

        if ($item) {
            $item->delete();
            return response()->json(['message' => 'Data deleted successfully']);
        } else {
            return response()->json(['message' => 'Detail Faktur not found'], 404);
        }
    }

    public function deletedetailpelunasanreturn($id)
    {
        $item = Detail_pelunasanreturn::find($id);

        if ($item) {
            $item->delete();
            return response()->json(['message' => 'Data deleted successfully']);
        } else {
            return response()->json(['message' => 'Detail Faktur not found'], 404);
        }
    }

    public function deletedetailpelunasanpotongan($id)
    {
        $item = Detail_pelunasanpotongan::find($id);

        if ($item) {
            $item->delete();
            return response()->json(['message' => 'Data deleted successfully']);
        } else {
            return response()->json(['message' => 'Detail Faktur not found'], 404);
        }
    }
}