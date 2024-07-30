<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Detail_pelunasanpart;
use App\Models\Pembelian_part;
use App\Models\Supplier;
use App\Models\Faktur_pelunasanpart;
use Illuminate\Support\Facades\Validator;

class InqueryFakturpelunasanpartController extends Controller
{
    public function index(Request $request)
    {
        Faktur_pelunasanpart::where([
            ['status', 'posting']
        ])->update([
            'status_notif' => true
        ]);

        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $inquery = Faktur_pelunasanpart::query();

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

        return view('admin.inquery_fakturpelunasanpart.index', compact('inquery'));
    }



    public function edit($id)
    {
        $inquery = Faktur_pelunasanpart::where('id', $id)->first();
        $details  = Detail_pelunasanpart::where('faktur_pelunasanpart_id', $id)->get();
        $suppliers = Supplier::all();
        $fakturs = Pembelian_part::where(['status_pelunasan' => null, 'status' => 'posting'])->get();
        return view('admin.inquery_fakturpelunasanpart.update', compact('details', 'inquery', 'suppliers', 'fakturs'));
    }

    public function update(Request $request, $id)
    {
        $validasi_pelanggan = Validator::make(
            $request->all(),
            [
                'supplier_id' => 'required',
                'pembelian_part_id' => 'required',
            ],
            [
                'supplier_id.required' => 'Pilih Supplier',
                'pembelian_part_id.required' => 'Pilih Faktur Pembelian Part',
            ]
        );

        $error_pelanggans = array();

        if ($validasi_pelanggan->fails()) {
            array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
        }

        $error_pesanans = array();
        $data_pembelians = collect();

        if ($request->has('pembelian_part_id')) {
            for ($i = 0; $i < count($request->pembelian_part_id); $i++) {
                $validasi_produk = Validator::make($request->all(), [
                    'pembelian_part_id.' . $i => 'required',
                    'kode_pembelianpart.' . $i => 'required',
                    'tanggal_pembelian.' . $i => 'required',
                    'total.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Faktur nomor " . ($i + 1) . " belum dilengkapi!"); // Corrected the syntax for concatenation and indexing
                }

                $pembelian_part_id = is_null($request->pembelian_part_id[$i]) ? '' : $request->pembelian_part_id[$i];
                $kode_pembelianpart = is_null($request->kode_pembelianpart[$i]) ? '' : $request->kode_pembelianpart[$i];
                $tanggal_pembelian = is_null($request->tanggal_pembelian[$i]) ? '' : $request->tanggal_pembelian[$i];
                $total = is_null($request->total[$i]) ? '' : $request->total[$i];

                $data_pembelians->push([
                    'detail_id' => $request->detail_ids[$i] ?? null,
                    'pembelian_part_id' => $pembelian_part_id,
                    'kode_pembelianpart' => $kode_pembelianpart,
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
        $cetakpdf = Faktur_pelunasanpart::findOrFail($id);

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
            'tanggal_transfer' => $request->tanggal_transfer,
            'status' => 'posting',
            'nominal' =>  $request->nominal ? str_replace(',', '.', str_replace('.', '', $request->nominal)) : 0,
        ]);

        $transaksi_id = $cetakpdf->id;
        $detailIds = $request->input('detail_ids');

        foreach ($data_pembelians as $data_pesanan) {
            $detailId = $data_pesanan['detail_id'];

            if ($detailId) {
                $detailPelunasan = Detail_pelunasanpart::where('id', $detailId)->update([
                    'faktur_pelunasanpart_id' => $cetakpdf->id,
                    'pembelian_part_id' => $data_pesanan['pembelian_part_id'],
                    'kode_pembelianpart' => $data_pesanan['kode_pembelianpart'],
                    'tanggal_pembelian' => $data_pesanan['tanggal_pembelian'],
                    'status' => 'posting',
                    'total' => str_replace(',', '.', str_replace('.', '', $data_pesanan['total'])),
                ]);

                Pembelian_part::where('id', $data_pesanan['pembelian_part_id'])->update(['status' => 'selesai', 'status_pelunasan' => 'aktif']);
            } else {
                $existingDetail = Detail_pelunasanpart::where([
                    'faktur_pelunasanpart_id' => $cetakpdf->id,
                    'pembelian_part_id' => $data_pesanan['pembelian_part_id'],
                    'kode_pembelianpart' => $data_pesanan['kode_pembelianpart'],
                    'tanggal_pembelian' => $data_pesanan['tanggal_pembelian'],
                    'total' => str_replace(',', '.', str_replace('.', '', $data_pesanan['total'])),
                ])->first();

                if (!$existingDetail) {
                    $detailPelunasan = Detail_pelunasanpart::create([
                        'faktur_pelunasanpart_id' => $cetakpdf->id,
                        'status' => 'posting',
                        'pembelian_part_id' => $data_pesanan['pembelian_part_id'],
                        'kode_pembelianpart' => $data_pesanan['kode_pembelianpart'],
                        'tanggal_pembelian' => $data_pesanan['tanggal_pembelian'],
                        'total' => str_replace(',', '.', str_replace('.', '', $data_pesanan['total'])),
                    ]);
                    Pembelian_part::where('id', $detailPelunasan->pembelian_part_id)->update(['status' => 'selesai', 'status_pelunasan' => 'aktif']);
                }
            }
        }

        $details = Detail_pelunasanpart::where('faktur_pelunasanpart_id', $cetakpdf->id)->get();

        return view('admin.inquery_fakturpelunasanpart.show', compact('cetakpdf', 'details'));
    }

    public function show($id)
    {
        $cetakpdf = Faktur_pelunasanpart::where('id', $id)->first();
        $details = Detail_pelunasanpart::where('faktur_pelunasanpart_id', $id)->get();

        return view('admin.inquery_fakturpelunasanpart.show', compact('cetakpdf', 'details'));
    }

    public function unpostpelunasanpart($id)
    {
        $item = Faktur_pelunasanpart::find($id);
        if (!$item) {
            return back()->with('error', 'Faktur pembelian part tidak ditemukan');
        }
        $detailpelunasan = Detail_pelunasanpart::where('faktur_pelunasanpart_id', $id)->get();
        foreach ($detailpelunasan as $detail) {
            if ($detail->pembelian_part_id) {
                $fakturEkspedisi = Pembelian_part::find($detail->pembelian_part_id);
                if ($fakturEkspedisi) {
                    $fakturEkspedisi->update(['status' => 'posting', 'status_pelunasan' => null]);
                }
            }
        }

        try {
            $item->update(['status' => 'unpost']);
            foreach ($detailpelunasan as $detail) {
                $detail->update(['status' => 'unpost']);
            }
            return back()->with('success', 'Berhasil unposting faktur pembelian part');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal unposting faktur pembelian part: ' . $e->getMessage());
        }
    }


    public function postingpelunasanpart($id)
    {
        $item = Faktur_pelunasanpart::find($id);
        if (!$item) {
            return back()->with('error', 'Faktur pembelian part tidak ditemukan');
        }
        $detailpelunasan = Detail_pelunasanpart::where('faktur_pelunasanpart_id', $id)->get();
        foreach ($detailpelunasan as $detail) {
            if ($detail->pembelian_part_id) {
                $fakturEkspedisi = Pembelian_part::find($detail->pembelian_part_id);
                if ($fakturEkspedisi) {
                    $fakturEkspedisi->update(['status' => 'selesai', 'status_pelunasan' => 'aktif']);
                }
            }
        }

        try {
            $item->update(['status' => 'posting']);
            foreach ($detailpelunasan as $detail) {
                $detail->update(['status' => 'posting']);
            }
            return back()->with('success', 'Berhasil unposting faktur pembelian part');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal unposting faktur pembelian part: ' . $e->getMessage());
        }
    }


    public function hapuspelunasanpart($id)
    {
        $item = Faktur_pelunasanpart::where('id', $id)->first();

        if ($item) {
            $detailpelunasan = Detail_pelunasanpart::where('faktur_pelunasanpart_id', $id)->get();

            // Loop through each Detail_pelunasanpart and update associated Pembelian_part records
            // foreach ($detailpelunasan as $detail) {
            //     if ($detail->pembelian_part_id) {
            //         Pembelian_part::where('id', $detail->pembelian_part_id)->update(['status_pelunasan' => null]);
            //     }
            // }
            // Delete related Detail_pelunasanpart instances
            Detail_pelunasanpart::where('faktur_pelunasanpart_id', $id)->delete();

            // Delete the main Faktur_pelunasanpart instance
            $item->delete();

            return back()->with('success', 'Berhasil menghapus pembelian part');
        } else {
            // Handle the case where the Faktur_pelunasanpart with the given ID is not found
            return back()->with('error', 'pembelian part tidak ditemukan');
        }
    }
}