<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Deposit_driver;
use App\Models\Detail_inventory;
use App\Models\Detail_klaimperalatan;
use App\Models\Karyawan;
use App\Models\Kendaraan;
use App\Models\Klaim_peralatan;
use App\Models\Penerimaan_kaskecil;
use App\Models\Saldo;
use App\Models\Sparepart;
use Illuminate\Support\Facades\Validator;

class InqueryKlaimperalatanController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $inquery = Klaim_peralatan::query();

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

        return view('admin.inquery_klaimperalatan.index', compact('inquery'));
    }

    public function edit($id)
    {
        $inquery = Klaim_peralatan::where('id', $id)->first();

        $kendaraans = Kendaraan::all();
        $spareparts = Sparepart::where([
            'kategori' => 'peralatan'
        ])->get();
        $SopirAll = Karyawan::where('departemen_id', '2')->get();
        $details = Detail_klaimperalatan::where('klaim_peralatan_id', $id)->get();

        return view('admin.inquery_klaimperalatan.update', compact('details', 'inquery', 'SopirAll', 'kendaraans', 'spareparts'));
    }

    public function update(Request $request, $id)
    {
        $validasi_pelanggan = Validator::make($request->all(), [
            'kendaraan_id' => 'required',
        ], [
            'kendaraan_id.required' => 'Pilih no kabin!',
        ]);

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
                    'kode_partdetail.' . $i => 'required',
                    'nama_barang.' . $i => 'required',
                    'keterangan.' . $i => 'required',
                    'harga.' . $i => 'required',
                    'jumlah.*' => 'required|numeric|min:1',
                    'total.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Pemasangan Part nomor " . $i + 1 . " belum dilengkapi!");
                }

                $sparepart_id = is_null($request->sparepart_id[$i]) ? '' : $request->sparepart_id[$i];
                $kode_partdetail = is_null($request->kode_partdetail[$i]) ? '' : $request->kode_partdetail[$i];
                $nama_barang = is_null($request->nama_barang[$i]) ? '' : $request->nama_barang[$i];
                $keterangan = is_null($request->keterangan[$i]) ? '' : $request->keterangan[$i];
                $harga = is_null($request->harga[$i]) ? '' : $request->harga[$i];
                $jumlah = is_null($request->jumlah[$i]) ? '' : $request->jumlah[$i];
                $total = is_null($request->total[$i]) ? '' : $request->total[$i];

                $data_pembelians->push(['detail_id' => $request->detail_ids[$i] ?? null, 'sparepart_id' => $sparepart_id, 'kode_partdetail' => $kode_partdetail, 'nama_barang' => $nama_barang, 'keterangan' => $keterangan, 'harga' => $harga, 'jumlah' => $jumlah, 'total' => $total]);
            }
        } else {
        }

        if ($error_pelanggans || $error_pesanans) {
            return back()
                ->withInput()
                ->with('error_pelanggans', $error_pelanggans)
                ->with('error_pesanans', $error_pesanans)
                ->with('data_pembelians', $data_pembelians);
        }

        // format tanggal indo
        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');

        $transaksi = Klaim_peralatan::findOrFail($id);
        $depositdriver = Deposit_driver::where('id', $transaksi->deposit_driver_id)->first();

        if ($depositdriver) {
            $depositdriver->update([
                'karyawan_id' => $request->karyawan_id,
                'kode_sopir' => $request->kode_karyawan,
                'nama_sopir' => $request->nama_lengkap,
                'kategori' => 'Pengambilan Deposit',
                'sub_total' => str_replace('.', '', $request->sub_totals),
                'nominal' => str_replace('.', '', $request->saldo_keluar),
                'saldo_keluar' => str_replace('.', '', $request->saldo_keluar), // Assuming saldo_keluar should have periods removed
                'keterangan' => $request->keterangans, // Verify if 'keterangans' is correct
                'sisa_saldo' => str_replace('.', '', $request->sisa_saldo),
                'status' => 'unpost',
            ]);
        }

        $saldoTerakhir = Saldo::latest()->first();
        $saldo = $saldoTerakhir->id;
        // Menghapus tanda titik dari nilai saldo_keluar dan mengonversi ke tipe numerik
        $saldo_keluar_numeric = (float) str_replace('.', '', $request->saldo_keluar);
        $subtotals =  $saldoTerakhir->sisa_saldo + $saldo_keluar_numeric;

        $penerimaan = Penerimaan_kaskecil::where('id', $transaksi->penerimaan_kaskecil_id)->first();
        if ($penerimaan) {
            $penerimaan->update([
                'deposit_driver_id' => $depositdriver->id,
                'nominal' => str_replace('.', '', $request->saldo_keluar),
                'saldo_masuk' => $request->saldo_keluar,
                'keterangan' => $request->keterangans,
                'sisa_saldo' => $saldoTerakhir->sisa_saldo,
                'saldo_id' => $saldo,
                'sub_total' => $subtotals,
                'status' => 'unpost',
            ]);
        }

        $transaksi->update([
            'kendaraan_id' => $request->kendaraan_id,
            'penerimaan_kaskecil_id' => $penerimaan->id,
            'karyawan_id' => $request->karyawan_id,
            'deposit_driver_id' => $depositdriver->id,
            'penerimaan_kaskecil_id' => $penerimaan->id,
            'keterangan' => $request->keterangans,
            'sisa_saldo' => str_replace('.', '', $request->sisa_saldo),
            'harga_klaim' => str_replace('.', '', $request->saldo_keluar),
            'grand_total' => str_replace('.', '', $request->sub_totals),
            'status' => 'unpost',
            'status_notif' => false,
        ]);

        $transaksi_id = $transaksi->id;
        $detailIds = $request->input('detail_ids');

        foreach ($data_pembelians as $data_pesanan) {
            $detailId = $data_pesanan['detail_id'];

            if ($detailId) {
                $existingDetail = Detail_klaimperalatan::findOrFail($detailId);
                $existingDetail->update([
                    'klaim_peralatan_id' => $transaksi->id,
                    'sparepart_id' => $data_pesanan['sparepart_id'],
                    'kode_partdetail' => $data_pesanan['kode_partdetail'],
                    'nama_barang' => $data_pesanan['nama_barang'],
                    'keterangan' => $data_pesanan['keterangan'],
                    'jumlah' => $data_pesanan['jumlah'],
                    'harga' => $data_pesanan['harga'],
                    'total' => $data_pesanan['total'],
                ]);
            } else {
                $existingDetail = Detail_klaimperalatan::where([
                    'klaim_peralatan_id' => $transaksi->id,
                    'sparepart_id' => $data_pesanan['sparepart_id'],
                    'kode_partdetail' => $data_pesanan['kode_partdetail'],
                ])->first();

                if (!$existingDetail) {
                    $detailTagihan = Detail_klaimperalatan::create([
                        'klaim_peralatan_id' => $transaksi->id,
                        'sparepart_id' => $data_pesanan['sparepart_id'],
                        'kode_partdetail' => $data_pesanan['kode_partdetail'],
                        'nama_barang' => $data_pesanan['nama_barang'],
                        'tanggal_awal' => Carbon::now('Asia/Jakarta'),
                        'keterangan' => $data_pesanan['keterangan'],
                        'jumlah' => $data_pesanan['jumlah'],
                        'harga' => $data_pesanan['harga'],
                        'total' => $data_pesanan['total'],
                    ]);
                }
            }
        }
        $klaim_peralatan = Klaim_peralatan::find($transaksi_id);
        $details = Detail_klaimperalatan::where('klaim_peralatan_id', $klaim_peralatan->id)->get();

        return view('admin.inquery_klaimperalatan.show', compact('details', 'klaim_peralatan'));
    }

    public function unpostklaimperalatan($id)
    {
        $pembelian = Klaim_peralatan::findOrFail($id);
        $detailpembelian = Detail_klaimperalatan::where('klaim_peralatan_id', $id)->get();

        foreach ($detailpembelian as $detail) {
            // Cari Detail_inventory yang sesuai
            $existingDetailBarang = Detail_inventory::where('kendaraan_id', $pembelian->kendaraan_id)
                ->where('sparepart_id', $detail->sparepart_id)
                ->first();

            if ($existingDetailBarang) {
                // Kurangi jumlahnya
                $existingDetailBarang->jumlah += $detail->jumlah;

                // Simpan perubahan
                $existingDetailBarang->save();
            }
        }


        $depositdrivers = $pembelian->deposit_driver_id;
        $depositdriver = Deposit_driver::where('id', $depositdrivers)->first();
        if ($depositdriver) {
            $sopir = Karyawan::find($depositdriver->karyawan_id);

            // Pastikan karyawan ditemukan
            if (!$sopir) {
                return back()->with('error', 'Karyawan tidak ditemukan');
            }

            $kasbon = $sopir->kasbon;
            $totalKasbon = $depositdriver->nominal;
            $kasbons = $kasbon - $totalKasbon;

            $tabungan = $sopir->tabungan;
            $total = $depositdriver->nominal;
            $sub_totals = $tabungan + $total;

            // Update tabungan karyawan
            $sopir->update([
                'kasbon' => $kasbons,
                // 'deposit' => $deposits,
                'tabungan' => $sub_totals
            ]);
            // Update status deposit_driver menjadi 'posting'
            $depositdriver->update([
                'status' => 'unpost'
            ]);
        }

        $penerimaans = $pembelian->penerimaan_kaskecil_id;
        $penerimaan = Penerimaan_kaskecil::where('id', $penerimaans)->first();
        if ($penerimaan) {
            $lastSaldo = Saldo::latest()->first();

            // Periksa apakah saldo terakhir ditemukan
            if (!$lastSaldo) {
                return back()->with('error', 'Saldo tidak ditemukan');
            }

            $sisaSaldo = $lastSaldo->sisa_saldo - $penerimaan->nominal;
            Saldo::create([
                'sisa_saldo' => $sisaSaldo,
            ]);

            // Perbarui status penerimaan menjadi "unpost"
            $penerimaan->update([
                'status' => 'unpost'
            ]);
        }

        // Update status pembelian menjadi 'unpost'
        $pembelian->update(['status' => 'unpost']);

        return back()->with('success', 'Klaim_peralatan berhasil di-unpost.');
    }


    public function postingklaimperalatan($id)
    {
        $pembelian = Klaim_peralatan::findOrFail($id);
        $detailpembelian = Detail_klaimperalatan::where('klaim_peralatan_id', $id)->get();

        foreach ($detailpembelian as $detail) {
            // Cari Detail_inventory yang sesuai
            $existingDetailBarang = Detail_inventory::where('kendaraan_id', $pembelian->kendaraan_id)
                ->where('sparepart_id', $detail->sparepart_id)
                ->first();
            if ($existingDetailBarang) {
                // Tambahkan jumlahnya
                $existingDetailBarang->jumlah -= $detail->jumlah;
                // Simpan perubahan
                $existingDetailBarang->save();
            }
        }


        $depositdrivers = $pembelian->deposit_driver_id;
        $depositdriver = Deposit_driver::where('id', $depositdrivers)->first();
        if ($depositdriver) {
            $sopir = Karyawan::find($depositdriver->karyawan_id);

            // Pastikan karyawan ditemukan
            if (!$sopir) {
                return back()->with('error', 'Karyawan tidak ditemukan');
            }

            $kasbon = $sopir->kasbon;
            $totalKasbon = $depositdriver->nominal;
            $kasbons = $kasbon + $totalKasbon;

            $tabungan = $sopir->tabungan;
            $total = $depositdriver->nominal;
            $sub_totals = $tabungan - $total;

            // Update tabungan karyawan
            $sopir->update([
                'kasbon' => $kasbons,
                // 'deposit' => $deposits,
                'tabungan' => $sub_totals
            ]);
            // Update status deposit_driver menjadi 'posting'
            $depositdriver->update([
                'status' => 'posting'
            ]);
        }

        $penerimaans = $pembelian->penerimaan_kaskecil_id;
        $penerimaan = Penerimaan_kaskecil::where('id', $penerimaans)->first();
        if ($penerimaan) {
            $lastSaldo = Saldo::latest()->first();

            // Periksa apakah saldo terakhir ditemukan
            if (!$lastSaldo) {
                return back()->with('error', 'Saldo tidak ditemukan');
            }

            $sisaSaldo = $lastSaldo->sisa_saldo + $penerimaan->nominal;
            Saldo::create([
                'sisa_saldo' => $sisaSaldo,
            ]);

            $penerimaan->update([
                'status' => 'posting'
            ]);
        }

        // Update status pembelian menjadi 'posting'
        $pembelian->update(['status' => 'posting']);

        return back()->with('success', 'Klaim_peralatan berhasil di-posting kembali.');
    }


    public function show($id)
    {
        $klaim_peralatan = Klaim_peralatan::find($id);
        $details = Detail_klaimperalatan::where('klaim_peralatan_id', $klaim_peralatan->id)->get();

        return view('admin.inquery_klaimperalatan.show', compact('details', 'klaim_peralatan'));
    }

    public function hapusperalatan($id)
    {
        $klaim_peralatan = Klaim_peralatan::find($id);

        if (!$klaim_peralatan) {
            return redirect()->back()->with('error', 'Data ban tidak ditemukan');
        }

        $depositdriver = Deposit_driver::where('id', $klaim_peralatan->deposit_driver_id)->first();
        if ($depositdriver) {
            // Hapus penerimaan_kaskecil yang terkait
            $penerimaanKasKecil = $depositdriver->penerimaan_kaskecil();
            if ($penerimaanKasKecil) {
                $penerimaanKasKecil->delete();
            }

            // Hapus deposit_driver
            $depositdriver->delete();
        }

        if ($klaim_peralatan) {
            $detail_klaim = Detail_klaimperalatan::where('klaim_peralatan_id', $id)->get();
            // Delete related Detail_tagihan instances
            Detail_klaimperalatan::where('klaim_peralatan_id', $id)->delete();
            $klaim_peralatan->delete();

            return back()->with('success', 'Berhasil menghapus Klaim_peralatan');
        } else {
            // Handle the case where the Klaim_peralatan with the given ID is not found
            return back()->with('error', 'Klaim_peralatan tidak ditemukan');
        }
    }

    public function deletedetailklaim($id)
    {
        $item = Detail_klaimperalatan::find($id);

        if ($item) {
            $item->delete();
            return response()->json(['message' => 'Data deleted successfully']);
        } else {
            return response()->json(['message' => 'Detail Faktur not found'], 404);
        }
    }
}