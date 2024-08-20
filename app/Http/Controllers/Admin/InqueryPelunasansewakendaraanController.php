<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Detail_pelunasansewa;
use App\Models\Detail_pelunasanpotongan;
use App\Models\Detail_pelunasanreturn;
use App\Models\Sewa_kendaraan;
use App\Models\Pelunasan_sewakendaraan;
use App\Models\Faktur_penjualanreturn;
use App\Models\Potongan_penjualan;
use App\Models\Spk;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InqueryPelunasansewakendaraanController extends Controller
{

    public function index(Request $request)
    {
        Pelunasan_sewakendaraan::where([
            ['status', 'posting']
        ])->update([
            'status_notif' => true
        ]);

        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $inquery = Pelunasan_sewakendaraan::query();

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

        return view('admin.inquery_pelunasansewakendaraan.index', compact('inquery'));
    }

    public function edit($id)
    {
        $inquery = Pelunasan_sewakendaraan::where('id', $id)->first();
        $invoices = Sewa_kendaraan::whereDoesntHave('detail_invoice', function ($query) {
            $query->whereHas('sewa_kendaraan', function ($query) {
                $query->whereNotNull('status_pelunasan');
            });
        })->orWhereHas('detail_invoice', function ($query) {
            $query->whereHas('sewa_kendaraan', function ($query) {
                $query->whereNull('status_pelunasan');
            });
        })->get();
        $details  = Detail_pelunasansewa::where('pelunasan_sewakendaraan_id', $id)->get();
        // $detailsreturn  = Detail_pelunasanreturn::where('pelunasan_sewakendaraan_id', $id)->get();
        $detailspotongan  = Detail_pelunasanpotongan::where('pelunasan_sewakendaraan_id', $id)->get();

        $fakturs = Sewa_kendaraan::get();
        $returns = Faktur_penjualanreturn::where('status', 'posting')->get();
        $potonganlains = Potongan_penjualan::where('status', 'posting')->get();

        return view('admin.inquery_pelunasansewakendaraan.update', compact('fakturs', 'details', 'detailspotongan', 'inquery', 'returns', 'potonganlains', 'invoices'));
    }

    public function update(Request $request, $id)
    {
        $validasi_pelanggan = Validator::make(
            $request->all(),
            [
                'vendor_id' => 'required',
                'nominal' => 'required',
            ],
            [
                'vendor_id.required' => 'Pilih Rekanan',
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

        if ($request->has('sewa_kendaraan_id')) {
            for ($i = 0; $i < count($request->sewa_kendaraan_id); $i++) {
                $validasi_produk = Validator::make($request->all(), [
                    'sewa_kendaraan_id.' . $i => 'required',
                    'kode_faktur.' . $i => 'required',
                    'tanggal_faktur.' . $i => 'required',
                    'total.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Faktur nomor " . ($i + 1) . " belum dilengkapi!"); // Corrected the syntax for concatenation and indexing
                }
                $sewa_kendaraan_id = is_null($request->sewa_kendaraan_id[$i]) ? '' : $request->sewa_kendaraan_id[$i];
                $kode_faktur = is_null($request->kode_faktur[$i]) ? '' : $request->kode_faktur[$i];
                $tanggal_faktur = is_null($request->tanggal_faktur[$i]) ? '' : $request->tanggal_faktur[$i];
                $total = is_null($request->total[$i]) ? '' : $request->total[$i];

                $data_pembelians->push([
                    'sewa_kendaraan_id' => $sewa_kendaraan_id,
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
        $cetakpdf = Pelunasan_sewakendaraan::findOrFail($id);
        $selisih = (int)str_replace(['Rp', '.', ' '], '', $request->selisih);
        $totalpembayaran = (int)str_replace(['Rp', '.', ' '], '', $request->totalpembayaran);

        $cetakpdf->update([
            'invoice_sewakendaraan_id' => $request->invoice_sewakendaraan_id,
            'kode_tagihan' => $request->kode_tagihan,
            'vendor_id' => $request->vendor_id,
            'kode_vendor' => $request->kode_vendor,
            'nama_vendor' => $request->nama_vendor,
            'alamat_vendor' => $request->alamat_vendor,
            'telp_vendor' => $request->telp_vendor,
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

        Sewa_kendaraan::where('id', $request->invoice_sewakendaraan_id)->update([
            'status' => 'selesai',
        ]);

        $transaksi_id = $cetakpdf->id;
        $detailIds = $request->input('detail_idss');
        $detailIds = $request->input('detail_ids');

        $updatedFakturEkspedisiIds = [];
        $newFakturEkspedisiIds = [];

        foreach ($data_pembelians as $data_pesanan) {
            $detailPelunasan = Detail_pelunasansewa::updateOrCreate(
                ['sewa_kendaraan_id' => $data_pesanan['sewa_kendaraan_id']],
                [
                    'pelunasan_sewakendaraan_id' => $cetakpdf->id,
                    'kode_faktur' => $data_pesanan['kode_faktur'],
                    'tanggal_faktur' => $data_pesanan['tanggal_faktur'],
                    'total' => str_replace(',', '.', str_replace('.', '', $data_pesanan['total'])),
                    'status' => 'posting',
                ]
            );
            $updatedFakturEkspedisiIds[] = $detailPelunasan->sewa_kendaraan_id;
            $newFakturEkspedisiIds[] = $data_pesanan['sewa_kendaraan_id'];
        }

        Sewa_kendaraan::whereIn('id', $updatedFakturEkspedisiIds)->update(['status_pelunasan' => 'aktif']);
        foreach ($updatedFakturEkspedisiIds as $fakturId) {
            $faktur = Sewa_kendaraan::find($fakturId);
            if ($faktur) {
            }
        }

        // Delete Detail_tagihan records that are no longer relevant
        Detail_pelunasansewa::where('pelunasan_sewakendaraan_id', $cetakpdf->id)
            ->whereNotIn('sewa_kendaraan_id', $newFakturEkspedisiIds)
            ->delete();

        $deletedFakturEkspedisiIds = Sewa_kendaraan::whereNotIn('id', $updatedFakturEkspedisiIds)
            ->pluck('id');
        foreach ($deletedFakturEkspedisiIds as $fakturId) {
            $faktur = Sewa_kendaraan::find($fakturId);
            if ($faktur) {
            }
        }

        foreach ($data_pembelians2 as $data_pesanan) {
            $detailId = $data_pesanan['detail_id'];

            if ($detailId) {
                Detail_pelunasanreturn::where('id', $detailId)->update([
                    'pelunasan_sewakendaraan_id' => $cetakpdf->id,
                    'sewa_kendaraan_id' => $data_pesanan['faktur_id'],
                    'nota_return_id' => $data_pesanan['nota_return_id'],
                    'kode_potongan' => $data_pesanan['kode_potongan'],
                    'keterangan_potongan' => $data_pesanan['keterangan_potongan'],
                    'nominal_potongan' => str_replace(',', '.', str_replace('.', '', $data_pesanan['nominal_potongan'])),
                    'status' => 'posting',
                ]);
            } else {
                $existingDetail = Detail_pelunasanreturn::where([
                    'pelunasan_sewakendaraan_id' => $cetakpdf->id,
                    'sewa_kendaraan_id' => $data_pesanan['faktur_id'],
                    'nota_return_id' => $data_pesanan['nota_return_id'],
                    'kode_potongan' => $data_pesanan['kode_potongan'],
                    'keterangan_potongan' => $data_pesanan['keterangan_potongan'],
                    'nominal_potongan' => str_replace(',', '.', str_replace('.', '', $data_pesanan['nominal_potongan'])),
                    'status' => 'posting',
                ])->first();


                if (!$existingDetail) {
                    Detail_pelunasanreturn::create([
                        'pelunasan_sewakendaraan_id' => $cetakpdf->id,
                        'sewa_kendaraan_id' => $data_pesanan['faktur_id'],
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
                    'pelunasan_sewakendaraan_id' => $cetakpdf->id,
                    'potongan_penjualan_id' => $data_pesanan['potongan_penjualan_id'],
                    'kode_potonganlain' => $data_pesanan['kode_potonganlain'],
                    'keterangan_potonganlain' => $data_pesanan['keterangan_potonganlain'],
                    'nominallain' => str_replace(',', '.', str_replace('.', '', $data_pesanan['nominallain'])),
                    'status' => 'posting',
                ]);
                Potongan_penjualan::where('id', $data_pesanan['potongan_penjualan_id'])->update(['status' => 'selesai']);
            } else {
                $existingDetail = Detail_pelunasanpotongan::where([
                    'pelunasan_sewakendaraan_id' => $cetakpdf->id,
                    'potongan_penjualan_id' => $data_pesanan['potongan_penjualan_id'],
                    'kode_potonganlain' => $data_pesanan['kode_potonganlain'],
                    'keterangan_potonganlain' => $data_pesanan['keterangan_potonganlain'],
                    'nominallain' => str_replace(',', '.', str_replace('.', '', $data_pesanan['nominallain'])),
                    'status' => 'posting',
                ])->first();


                if (!$existingDetail) {
                    Detail_pelunasanpotongan::create([
                        'pelunasan_sewakendaraan_id' => $cetakpdf->id,
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
        $details = Detail_pelunasansewa::where('pelunasan_sewakendaraan_id', $cetakpdf->id)->get();

        return view('admin.inquery_pelunasansewakendaraan.show', compact('cetakpdf', 'details'));
    }
    public function show($id)
    {
        $cetakpdf = Pelunasan_sewakendaraan::where('id', $id)->first();
        $details = Detail_pelunasansewa::where('pelunasan_sewakendaraan_id', $id)->get();

        return view('admin.inquery_pelunasansewakendaraan.show', compact('cetakpdf', 'details'));
    }

    public function unpost($id)
    {
        $item = Pelunasan_sewakendaraan::find($id);
        if (!$item) {
            return back()->with('error', 'Faktur pelunasan tidak ditemukan');
        }
        $detailpelunasan = Detail_pelunasansewa::where('pelunasan_sewakendaraan_id', $id)->get();
        foreach ($detailpelunasan as $detail) {
            if ($detail->sewa_kendaraan_id) {
                $fakturEkspedisi = Sewa_kendaraan::find($detail->sewa_kendaraan_id);
                if ($fakturEkspedisi && $fakturEkspedisi->status_pelunasan == 'aktif') {
                    $fakturEkspedisi->update(['status_pelunasan' => null]);
                }
            }
        }

        foreach (Detail_pelunasanpotongan::where('pelunasan_sewakendaraan_id', $id)->get() as $detail) {
            $detail->update(['status' => 'unpost']);

            Potongan_penjualan::where(['id' => $detail->potongan_penjualan_id, 'status' => 'selesai'])->update(['status' => 'posting']);
        }

        Sewa_kendaraan::where('id', $item->invoice_sewakendaraan_id)->update([
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



    public function posting($id)
    {
        $item = Pelunasan_sewakendaraan::find($id);
        if (!$item) {
            return back()->with('error', 'Faktur pelunasan tidak ditemukan');
        }
        $detailpelunasan = Detail_pelunasansewa::where('pelunasan_sewakendaraan_id', $id)->get();
        foreach ($detailpelunasan as $detail) {
            if ($detail->sewa_kendaraan_id) {
                $fakturEkspedisi = Sewa_kendaraan::find($detail->sewa_kendaraan_id);
                if ($fakturEkspedisi && $fakturEkspedisi->status_pelunasan == null) {
                    $fakturEkspedisi->update(['status_pelunasan' => 'aktif']);
                }
            }
        }

        foreach (Detail_pelunasanpotongan::where('pelunasan_sewakendaraan_id', $id)->get() as $detail) {
            $detail->update(['status' => 'posting']);
            Potongan_penjualan::where(['id' => $detail->potongan_penjualan_id, 'status' => 'posting'])->update(['status' => 'selesai']);
        }
        Sewa_kendaraan::where('id', $item->invoice_sewakendaraan_id)->update([
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


    public function postingpelunasanfiltersewa(Request $request)
    {

        $selectedIds = array_reverse(explode(',', $request->input('ids')));
    }

    public function unpostpelunasanfiltersewa(Request $request)
    {
        $selectedIds = array_reverse(explode(',', $request->input('ids')));
    }


    public function hapuspelunasansewa($id)
    {
        $item = Pelunasan_sewakendaraan::where('id', $id)->first();

        if ($item) {
            $detailpelunasan = Detail_pelunasansewa::where('pelunasan_sewakendaraan_id', $id)->get();
            Detail_pelunasansewa::where('pelunasan_sewakendaraan_id', $id)->delete();
            Detail_pelunasanreturn::where('pelunasan_sewakendaraan_id', $id)->delete();
            Detail_pelunasanpotongan::where('pelunasan_sewakendaraan_id', $id)->delete();
            $item->delete();

            return back()->with('success', 'Berhasil menghapus Pelunasan Ekspedisi');
        } else {
            return back()->with('error', 'Pelunasan Ekspedisi tidak ditemukan');
        }
    }



    public function deleteRow(Request $request)
    {
        $rowId = $request->input('row_id');
        Detail_pelunasansewa::destroy($rowId);
        return response()->json(['success' => true]);
    }

    public function deletedetailpelunasansewa($id)
    {
        $item = Detail_pelunasansewa::find($id);

        if ($item) {
            $item->delete();
            return response()->json(['message' => 'Data deleted successfully']);
        } else {
            return response()->json(['message' => 'Detail Faktur not found'], 404);
        }
    }

    public function deletedetailpelunasanreturnsewa($id)
    {
        $item = Detail_pelunasanreturn::find($id);

        if ($item) {
            $item->delete();
            return response()->json(['message' => 'Data deleted successfully']);
        } else {
            return response()->json(['message' => 'Detail Faktur not found'], 404);
        }
    }

    public function deletedetailpelunasanpotongansewa($id)
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