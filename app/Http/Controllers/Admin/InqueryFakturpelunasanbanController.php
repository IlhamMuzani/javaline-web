<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Detail_pelunasanban;
use App\Models\Pembelian_ban;
use App\Models\Supplier;
use App\Models\Faktur_pelunasanban;
use App\Models\Nota_return;
use App\Models\Return_ekspedisi;
use App\Models\Satuan;
use Illuminate\Support\Facades\Validator;

class InqueryFakturpelunasanbanController extends Controller
{
    public function index(Request $request)
    {
        Faktur_pelunasanban::where([
            ['status', 'posting']
        ])->update([
            'status_notif' => true
        ]);

        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $inquery = Faktur_pelunasanban::query();

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

        return view('admin.inquery_fakturpelunasanban.index', compact('inquery'));
    }



    public function edit($id)
    {
        $inquery = Faktur_pelunasanban::where('id', $id)->first();
        $details  = Detail_pelunasanban::where('faktur_pelunasanban_id', $id)->get();
        $suppliers = Supplier::all();
        $fakturs = Pembelian_ban::where(['status_pelunasan' => null, 'status' => 'posting'])->get();
        return view('admin.inquery_fakturpelunasanban.update', compact('details', 'inquery', 'suppliers', 'fakturs'));
    }

    public function update(Request $request, $id)
    {
        $validasi_pelanggan = Validator::make(
            $request->all(),
            [
                'supplier_id' => 'required',
                'pembelian_ban_id' => 'required',
            ],
            [
                'supplier_id.required' => 'Pilih Supplier',
                'pembelian_ban_id.required' => 'Pilih Faktur Pembelian Ban',
            ]
        );

        $error_pelanggans = array();

        if ($validasi_pelanggan->fails()) {
            array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
        }

        $error_pesanans = array();
        $data_pembelians = collect();

        if ($request->has('pembelian_ban_id')) {
            for ($i = 0; $i < count($request->pembelian_ban_id); $i++) {
                $validasi_produk = Validator::make($request->all(), [
                    'pembelian_ban_id.' . $i => 'required',
                    'kode_pembelian_ban.' . $i => 'required',
                    'tanggal_pembelian.' . $i => 'required',
                    'total.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Faktur nomor " . ($i + 1) . " belum dilengkapi!"); // Corrected the syntax for concatenation and indexing
                }

                $pembelian_ban_id = is_null($request->pembelian_ban_id[$i]) ? '' : $request->pembelian_ban_id[$i];
                $kode_pembelian_ban = is_null($request->kode_pembelian_ban[$i]) ? '' : $request->kode_pembelian_ban[$i];
                $tanggal_pembelian = is_null($request->tanggal_pembelian[$i]) ? '' : $request->tanggal_pembelian[$i];
                $total = is_null($request->total[$i]) ? '' : $request->total[$i];

                $data_pembelians->push([
                    'detail_id' => $request->detail_ids[$i] ?? null,
                    'pembelian_ban_id' => $pembelian_ban_id,
                    'kode_pembelian_ban' => $kode_pembelian_ban,
                    'tanggal_pembelian' => $tanggal_pembelian,
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
        $cetakpdf = Faktur_pelunasanban::findOrFail($id);

        // Update the main transaction
        $cetakpdf->update([
            'supplier_id' => $request->supplier_id,
            'kode_supplier' => $request->kode_supplier,
            'nama_supplier' => $request->nama_supplier,
            'alamat_supplier' => $request->alamat_supplier,
            'telp_supplier' => $request->telp_supplier,
            'keterangan' => $request->keterangan,
            'totalpenjualan' => str_replace(',', '.', str_replace('.', '', $request->totalpenjualan)),
            'dp' => str_replace(',', '.', str_replace('.', '', $request->dp)),
            'potonganselisih' => str_replace(',', '.', str_replace('.', '', $request->potonganselisih)),
            'totalpembayaran' => str_replace(',', '.', str_replace('.', '', $request->totalpembayaran)),
            'selisih' => str_replace(',', '.', str_replace('.', '', $request->selisih)),
            'potongan' => $request->potongan ? str_replace(',', '.', str_replace('.', '', $request->potongan)) : 0,
            'tambahan_pembayaran' => $request->tambahan_pembayaran ? str_replace(',', '.', str_replace('.', '', $request->tambahan_pembayaran)) : 0,
            'kategori' => $request->kategori,
            'nomor' => $request->nomor,
            'status' => 'posting',
            'tanggal_transfer' => $request->tanggal_transfer,
            // 'nominal' => str_replace('.', '', $request->nominal),
            'nominal' =>  $request->nominal ? str_replace(',', '.', str_replace('.', '', $request->nominal)) : 0,

        ]);

        $transaksi_id = $cetakpdf->id;
        $detailIds = $request->input('detail_ids');

        foreach ($data_pembelians as $data_pesanan) {
            $detailId = $data_pesanan['detail_id'];

            if ($detailId) {
                $detailPelunasan = Detail_pelunasanban::where('id', $detailId)->update([
                    'faktur_pelunasanban_id' => $cetakpdf->id,
                    'pembelian_ban_id' => $data_pesanan['pembelian_ban_id'],
                    'kode_pembelian_ban' => $data_pesanan['kode_pembelian_ban'],
                    'tanggal_pembelian' => $data_pesanan['tanggal_pembelian'],
                    'status' => 'posting',
                    'total' => str_replace(',', '.', str_replace('.', '', $data_pesanan['total'])),
                ]);

                // Update Pembelian_ban
                Pembelian_ban::where('id', $data_pesanan['pembelian_ban_id'])->update(['status' => 'selesai', 'status_pelunasan' => 'aktif']);
            } else {
                $existingDetail = Detail_pelunasanban::where([
                    'faktur_pelunasanban_id' => $cetakpdf->id,
                    'pembelian_ban_id' => $data_pesanan['pembelian_ban_id'],
                    'kode_pembelian_ban' => $data_pesanan['kode_pembelian_ban'],
                    'tanggal_pembelian' => $data_pesanan['tanggal_pembelian'],
                    'total' => str_replace(',', '.', str_replace('.', '', $data_pesanan['total'])),
                ])->first();

                if (!$existingDetail) {
                    $detailPelunasan = Detail_pelunasanban::create([
                        'faktur_pelunasanban_id' => $cetakpdf->id,
                        'status' => 'posting',
                        'pembelian_ban_id' => $data_pesanan['pembelian_ban_id'],
                        'kode_pembelian_ban' => $data_pesanan['kode_pembelian_ban'],
                        'tanggal_pembelian' => $data_pesanan['tanggal_pembelian'],
                        'total' => str_replace(',', '.', str_replace('.', '', $data_pesanan['total'])),
                    ]);

                    // Update Pembelian_ban
                    Pembelian_ban::where('id', $detailPelunasan->pembelian_ban_id)->update(['status' => 'selesai', 'status_pelunasan' => 'aktif']);
                }
            }
        }

        $details = Detail_pelunasanban::where('faktur_pelunasanban_id', $cetakpdf->id)->get();

        return view('admin.inquery_fakturpelunasanban.show', compact('cetakpdf', 'details'));
    }

    public function show($id)
    {
        $cetakpdf = Faktur_pelunasanban::where('id', $id)->first();
        $details = Detail_pelunasanban::where('faktur_pelunasanban_id', $id)->get();

        return view('admin.inquery_fakturpelunasanban.show', compact('cetakpdf', 'details'));
    }

    public function unpostpelunasanban($id)
    {
        // Menggunakan find untuk mendapatkan Faktur_pelunasanban berdasarkan ID
        $item = Faktur_pelunasanban::find($id);

        // Memeriksa apakah Faktur_pelunasanban ditemukan
        if (!$item) {
            return back()->with('error', 'Faktur pembelian ban tidak ditemukan');
        }

        // Mendapatkan detail pelunasan terkait
        $detailpelunasan = Detail_pelunasanban::where('faktur_pelunasanban_id', $id)->get();

        // Melakukan loop pada setiap Detail_pelunasanban dan memperbarui rekaman Pembelian_ban terkait
        foreach ($detailpelunasan as $detail) {
            if ($detail->pembelian_ban_id) {
                // Menggunakan find untuk mendapatkan Pembelian_ban berdasarkan ID
                $fakturEkspedisi = Pembelian_ban::find($detail->pembelian_ban_id);

                // Memeriksa apakah Pembelian_ban ditemukan
                if ($fakturEkspedisi) {
                    // Memperbarui status_pelunasan pada Pembelian_ban menjadi 'aktif'
                    $fakturEkspedisi->update(['status' => 'posting', 'status_pelunasan' => null]);
                }
            }
        }

        try {
            // Memperbarui status pada Faktur_pelunasanban menjadi 'unpost'
            $item->update(['status' => 'unpost']);

            // Melakukan loop pada setiap Detail_pelunasanban dan memperbarui status menjadi 'unpost'
            foreach ($detailpelunasan as $detail) {
                $detail->update(['status' => 'unpost']);
            }

            return back()->with('success', 'Berhasil unposting faktur pembelian ban');
        } catch (\Exception $e) {
            // Menangani kesalahan pembaruan basis data
            return back()->with('error', 'Gagal unposting faktur pembelian ban: ' . $e->getMessage());
        }
    }


    public function postingpelunasanban($id)
    {
        // Menggunakan find untuk mendapatkan Faktur_pelunasanban berdasarkan ID
        $item = Faktur_pelunasanban::find($id);

        // Memeriksa apakah Faktur_pelunasanban ditemukan
        if (!$item) {
            return back()->with('error', 'Faktur pembelian ban tidak ditemukan');
        }

        // Mendapatkan detail pelunasan terkait
        $detailpelunasan = Detail_pelunasanban::where('faktur_pelunasanban_id', $id)->get();

        try {
            // Melakukan loop pada setiap Detail_pelunasanban dan memperbarui status menjadi 'posting'
            foreach ($detailpelunasan as $detail) {
                $detail->update(['status' => 'posting']);
            }

            // Memperbarui status pada Faktur_pelunasanban menjadi 'posting'
            $item->update(['status' => 'posting']);

            return back()->with('success', 'Berhasil posting pembelian ban');
        } catch (\Exception $e) {
            // Menangani kesalahan pembaruan basis data
            return back()->with('error', 'Gagal posting pembelian ban: ' . $e->getMessage());
        }
    }


    public function hapuspelunasanban($id)
    {
        $item = Faktur_pelunasanban::where('id', $id)->first();

        if ($item) {
            $detailpelunasan = Detail_pelunasanban::where('faktur_pelunasanban_id', $id)->get();

            // Loop through each Detail_pelunasanban and update associated Pembelian_ban records
            // foreach ($detailpelunasan as $detail) {
            //     if ($detail->pembelian_ban_id) {
            //         Pembelian_ban::where('id', $detail->pembelian_ban_id)->update(['status_pelunasan' => null, 'status' => 'posting']);
            //     }
            // }
            // Delete related Detail_pelunasanban instances
            Detail_pelunasanban::where('faktur_pelunasanban_id', $id)->delete();

            // Delete the main Faktur_pelunasanban instance
            $item->delete();

            return back()->with('success', 'Berhasil menghapus pembelian ban');
        } else {
            // Handle the case where the Faktur_pelunasanban with the given ID is not found
            return back()->with('error', 'pembelian ban tidak ditemukan');
        }
    }
}