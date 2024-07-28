<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Detail_inventory;
use App\Models\Detail_pemakaian;
use App\Models\Kendaraan;
use App\Models\Pemakaian_peralatan;
use App\Models\Sparepart;
use App\Models\Supplier;
use Illuminate\Support\Facades\Validator;

class InqueryPemakaianperalatanController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $inquery = Pemakaian_peralatan::query();

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

        return view('admin/inquery_pemakaianperalatan.index', compact('inquery'));
    }


    public function show($id)
    {

        $pemakaians = Pemakaian_peralatan::where('id', $id)->first();
        $pemakaian = Pemakaian_peralatan::find($id);

        $parts = Detail_pemakaian::where('pemakaian_peralatan_id', $pemakaian->id)->get();

        return view('admin.inquery_pemakaianperalatan.show', compact('parts', 'pemakaians'));
    }


    public function edit($id)
    {
        $inquery = Pemakaian_peralatan::where('id', $id)->first();
        $kendaraans = Kendaraan::all();
        $spareparts = Sparepart::where([
            'kategori' => 'peralatan'
        ])->get();
        $details = Detail_pemakaian::where('pemakaian_peralatan_id', $id)->get();

        return view('admin.inquery_pemakaianperalatan.update', compact('inquery', 'kendaraans', 'spareparts', 'details'));
    }

    public function update(Request $request, $id)
    {
        $validasi_pelanggan = Validator::make(
            $request->all(),
            [
                'kendaraan_id' => 'required',
            ],
            [
                'kendaraan_id.required' => 'Pilih nama supplier!',
            ]
        );

        $error_pelanggans = array();

        if ($validasi_pelanggan->fails()) {
            array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
        }

        $error_pesanans = array();
        $data_pembelians = collect();

        if ($request->has('sparepart_id')) {
            for ($i = 0; $i < count($request->sparepart_id); $i++) {
                $validasi_produk = Validator::make($request->all(), [
                    'sparepart_id.' . $i => 'required',
                    'nama_barang.' . $i => 'required',
                    'keterangan.' . $i => 'required',
                    'jumlah.*' => 'required|numeric|min:1',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Pemakain Alat nomor " . $i + 1 . " belum dilengkapi!");
                }

                $sparepart_id = is_null($request->sparepart_id[$i]) ? '' : $request->sparepart_id[$i];
                $nama_barang = is_null($request->nama_barang[$i]) ? '' : $request->nama_barang[$i];
                $keterangan = is_null($request->keterangan[$i]) ? '' : $request->keterangan[$i];
                $jumlah = is_null($request->jumlah[$i]) ? '' : $request->jumlah[$i];

                $data_pembelians->push(['detail_id' => $request->detail_ids[$i] ?? null, 'sparepart_id' => $sparepart_id, 'nama_barang' => $nama_barang, 'keterangan' => $keterangan, 'jumlah' => $jumlah]);
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
        $transaksi = Pemakaian_peralatan::findOrFail($id);

        // Update the main transaction
        $transaksi->update([
            'kendaraan_id' => $request->kendaraan_id,
            'tanggal_pemakaian' => $format_tanggal,
            'status' => 'posting',
        ]);

        $transaksi_id = $transaksi->id;

        $detailIds = $request->input('detail_ids');

        foreach ($data_pembelians as $data_pesanan) {
            $detailId = $data_pesanan['detail_id'];

            if ($detailId) {
                // Update Detail_pemakaian
                Detail_pemakaian::where('id', $detailId)->update([
                    'kendaraan_id' => $request->kendaraan_id,
                    'pemakaian_peralatan_id' => $transaksi->id,
                    'sparepart_id' => $data_pesanan['sparepart_id'],
                    'tanggal_awal' => Carbon::now('Asia/Jakarta'),
                    'keterangan' => $data_pesanan['keterangan'],
                    'jumlah' => $data_pesanan['jumlah'],
                ]);

                // Check if the Detail_inventory already exists with the updated values
                $existingDetailBarang = Detail_inventory::where('kendaraan_id', $request->kendaraan_id)
                    ->where('sparepart_id', $data_pesanan['sparepart_id'])
                    ->first();

                if ($existingDetailBarang) {
                    // Update the jumlah
                    $existingDetailBarang->jumlah += $data_pesanan['jumlah'];
                    $existingDetailBarang->save();

                    // Update status menjadi 'posting'
                    $existingDetailBarang->update(['status' => 'posting']);
                } else {
                    Detail_inventory::create([
                        'pemakaian_peralatan_id' => $transaksi->id,
                        'detail_pemakaian_id' => $detailId->id,
                        'kendaraan_id' => $request->kendaraan_id,
                        'sparepart_id' => $data_pesanan['sparepart_id'],
                        'jumlah' => $data_pesanan['jumlah'],
                        'tanggal_awal' => $tanggal,
                        'status' => 'posting',
                    ]);
                }
            } else {
                // Check if the detail already exists
                $existingDetail = Detail_pemakaian::where([
                    'kendaraan_id' => $request->kendaraan_id,
                    'pemakaian_peralatan_id' => $transaksi->id,
                    'sparepart_id' => $data_pesanan['sparepart_id'],
                    'tanggal_awal' => Carbon::now('Asia/Jakarta'),
                    'keterangan' => $data_pesanan['keterangan'],
                    'jumlah' => $data_pesanan['jumlah'],
                ])->first();

                // If the detail does not exist, create a new one
                if (!$existingDetail) {
                    $detail_pemakaians = Detail_pemakaian::create([
                        'kendaraan_id' => $request->kendaraan_id,
                        'pemakaian_peralatan_id' => $transaksi->id,
                        'sparepart_id' => $data_pesanan['sparepart_id'],
                        'tanggal_awal' => Carbon::now('Asia/Jakarta'),
                        'keterangan' => $data_pesanan['keterangan'],
                        'jumlah' => $data_pesanan['jumlah'],
                    ]);
                }

                // Check if the Detail_inventory already exists
                $existingDetailBarang = Detail_inventory::where('kendaraan_id', $request->kendaraan_id)
                    ->where('sparepart_id', $data_pesanan['sparepart_id'])
                    ->first();

                if ($existingDetailBarang) {
                    // If exists, update the jumlah
                    $existingDetailBarang->jumlah += $data_pesanan['jumlah'];
                    $existingDetailBarang->save();
                } else {
                    // If not exists, create a new Detail_inventory
                    Detail_inventory::create([
                        'pemakaian_peralatan_id' => $transaksi->id,
                        'detail_pemakaian_id' => $detail_pemakaians->id,
                        'kendaraan_id' => $request->kendaraan_id,
                        'sparepart_id' => $data_pesanan['sparepart_id'],
                        'jumlah' => $data_pesanan['jumlah'],
                        'tanggal_awal' => $tanggal,
                        'status' => 'posting',
                    ]);
                }
            }
        }

        $pemakaians = Pemakaian_peralatan::find($transaksi_id);

        $parts = Detail_pemakaian::where('pemakaian_peralatan_id', $pemakaians->id)->get();
        Detail_inventory::where('pemakaian_peralatan_id', $pemakaians->id)
            ->where('status', 'unpost')
            ->delete();

        return view('admin.inquery_pemakaianperalatan.show', compact('parts', 'pemakaians'));
    }


    public function unpostpemakaian($id)
    {
        $pembelian = Pemakaian_peralatan::findOrFail($id);
        $detailpembelian = Detail_pemakaian::where('pemakaian_peralatan_id', $id)->get();

        foreach ($detailpembelian as $detail) {
            // Cari Detail_inventory yang sesuai
            $existingDetailBarang = Detail_inventory::where('kendaraan_id', $pembelian->kendaraan_id)
                ->where('sparepart_id', $detail->sparepart_id)
                ->first();

            if ($existingDetailBarang) {
                // Kurangi jumlahnya
                $existingDetailBarang->jumlah -= $detail->jumlah;

                // Simpan perubahan
                $existingDetailBarang->save();
            }
        }

        foreach ($detailpembelian as $detail) {
            // Cari Detail_inventory yang sesuai
            $existingDetailBarang = Detail_inventory::where('kendaraan_id', $pembelian->kendaraan_id)
                ->where('sparepart_id', $detail->sparepart_id)
                ->where('detail_pemakaian_id', $detail->id)
                ->first();

            if ($existingDetailBarang) {
                $existingDetailBarang->update(['status' => 'unpost']);
            }
        }

        // Update status pembelian menjadi 'unpost'
        $pembelian->update(['status' => 'unpost']);

        return back()->with('success', 'Pemakaian_peralatan berhasil di-unpost.');
    }


    public function postingpemakaian($id)
    {
        $pembelian = Pemakaian_peralatan::findOrFail($id);
        $detailpembelian = Detail_pemakaian::where('pemakaian_peralatan_id', $id)->get();

        foreach ($detailpembelian as $detail) {
            // Cari Detail_inventory yang sesuai
            $existingDetailBarang = Detail_inventory::where('kendaraan_id', $pembelian->kendaraan_id)
                ->where('sparepart_id', $detail->sparepart_id)
                ->first();
            if ($existingDetailBarang) {
                // Tambahkan jumlahnya
                $existingDetailBarang->jumlah += $detail->jumlah;
                // Simpan perubahan
                $existingDetailBarang->save();
            }
        }

        foreach ($detailpembelian as $detail) {
            // Cari Detail_inventory yang sesuai
            $existingDetailBarang = Detail_inventory::where('kendaraan_id', $pembelian->kendaraan_id)
                ->where('sparepart_id', $detail->sparepart_id)
                ->where('detail_pemakaian_id', $detail->id)
                ->first();

            if ($existingDetailBarang) {
                $existingDetailBarang->update(['status' => 'posting']);
            }
        }

        // Update status pembelian menjadi 'posting'
        $pembelian->update(['status' => 'posting']);

        return back()->with('success', 'Pemakaian_peralatan berhasil di-posting kembali.');
    }

    public function hapuspemakaian($id)
    {
        $tagihan = Pemakaian_peralatan::where('id', $id)->first();

        if ($tagihan) {
            $detailtagihan = Detail_pemakaian::where('pemakaian_peralatan_id', $id)->get();

            // Loop through each Detail_pemakaian and update associated Faktur_ekspedisi records
            // foreach ($detailtagihan as $detail) {
            //     if ($detail->faktur_ekspedisi_id) {
            //         Faktur_ekspedisi::where('id', $detail->faktur_ekspedisi_id)->update(['status_faktur' => null]);
            //     }
            // }

            // Delete related Detail_tagihan instances
            Detail_pemakaian::where('pemakaian_peralatan_id', $id)->delete();

            // Delete the main Pemakaian_peralatan instance
            $tagihan->delete();

            return back()->with('success', 'Berhasil menghapus Pemakaian_peralatan');
        } else {
            // Handle the case where the Pemakaian_peralatan with the given ID is not found
            return back()->with('error', 'Pemakaian peralatan tidak ditemukan');
        }
    }

    public function deletedetailpemakaians($id)
    {
        $item = Detail_pemakaian::find($id);

        if ($item) {
            $item->delete();
            return response()->json(['message' => 'Data deleted successfully']);
        } else {
            return response()->json(['message' => 'Detail Faktur not found'], 404);
        }
    }
}