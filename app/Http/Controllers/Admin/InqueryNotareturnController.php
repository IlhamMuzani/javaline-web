<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Detail_nota;
use App\Models\Pelanggan;
use App\Models\Nota_return;
use App\Models\Return_ekspedisi;
use App\Models\Satuan;
use Illuminate\Support\Facades\Validator;

class InqueryNotareturnController extends Controller
{
    public function index(Request $request)
    {
        Nota_return::where([
            ['status', 'posting']
        ])->update([
            'status_notif' => true
        ]);

        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $inquery = Nota_return::query();

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

        return view('admin.inquery_notareturn.index', compact('inquery'));
    }



    public function edit($id)
    {
        $inquery = Nota_return::where('id', $id)->first();
        $details  = Detail_nota::where('nota_return_id', $id)->get();
        $returnbarangs = Return_ekspedisi::all();
        return view('admin.inquery_notareturn.update', compact('returnbarangs', 'details', 'inquery'));
    }

    public function update(Request $request, $id)
    {
        $validasi_pelanggan = Validator::make(
            $request->all(),
            [
                'return_ekspedisi_id' => 'required',
            ],
            [
                'return_ekspedisi_id.required' => 'Pilih Surat Penerimaan',
            ]
        );

        $error_pelanggans = array();

        if ($validasi_pelanggan->fails()) {
            array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
        }

        $error_pesanans = array();
        $data_pembelians = collect();

        if ($request->has('barang_id')) {
            for ($i = 0; $i < count($request->barang_id); $i++) {
                $validasi_produk = Validator::make($request->all(), [
                    'barang_id.' . $i => 'required',
                    'kode_barang.' . $i => 'required',
                    'nama_barang.' . $i => 'required',
                    'jumlah.' . $i => 'required',
                    'satuan.' . $i => 'required',
                    'harga.' . $i => 'required',
                    'total.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Barang nomor " . ($i + 1) . " belum dilengkapi!");
                }

                $barang_id = is_null($request->barang_id[$i]) ? '' : $request->barang_id[$i];
                $kode_barang = is_null($request->kode_barang[$i]) ? '' : $request->kode_barang[$i];
                $nama_barang = is_null($request->nama_barang[$i]) ? '' : $request->nama_barang[$i];
                $jumlah = is_null($request->jumlah[$i]) ? '' : $request->jumlah[$i];
                $satuan = is_null($request->satuan[$i]) ? '' : $request->satuan[$i];
                $harga = is_null($request->harga[$i]) ? '' : $request->harga[$i];
                $total = is_null($request->total[$i]) ? '' : $request->total[$i];

                $data_pembelians->push([
                    'detail_id' => $request->detail_ids[$i] ?? null,
                    'barang_id' => $barang_id,
                    'kode_barang' => $kode_barang,
                    'nama_barang' => $nama_barang,
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
        $cetakpdf = Nota_return::findOrFail($id);

        // Update the main transaction
        $cetakpdf->update([
            'return_ekspedisi_id' => $request->return_ekspedisi_id,
            'kode_return' => $request->kode_return,
            'nomor_suratjalan' => $request->nomor_suratjalan,
            'pelanggan_id' => $request->pelanggan_id,
            'kode_pelanggan' => $request->kode_pelanggan,
            'nama_pelanggan' => $request->nama_pelanggan,
            'alamat_pelanggan' => $request->alamat_pelanggan,
            'telp_pelanggan' => $request->telp_pelanggan,
            'kendaraan_id' => $request->kendaraan_id,
            'no_kabin' => $request->no_kabin,
            'no_pol' => $request->no_pol,
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'user_id' => $request->user_id,
            'kode_driver' => $request->kode_driver,
            'nama_driver' => $request->nama_driver,
            'telp' => $request->telp,
            'grand_total' => str_replace(',', '.', str_replace('.', '', $request->grand_total)),
            'status' => 'posting',
        ]);

        $transaksi_id = $cetakpdf->id;
        $detailIds = $request->input('detail_ids', []);

        // Hapus detail nota yang tidak ada di array detailIds
        Detail_nota::where('nota_return_id', $cetakpdf->id)
            ->whereNotIn('id', $detailIds)
            ->delete();

        foreach ($data_pembelians as $data_pesanan) {
            $detailId = $data_pesanan['detail_id'];

            if ($detailId) {
                Detail_nota::where('id', $detailId)->update([
                    'nota_return_id' => $cetakpdf->id,
                    'barang_id' => $data_pesanan['barang_id'],
                    'kode_barang' => $data_pesanan['kode_barang'],
                    'nama_barang' => $data_pesanan['nama_barang'],
                    'jumlah' => $data_pesanan['jumlah'],
                    'satuan' => $data_pesanan['satuan'],
                    'harga' => str_replace(',', '.', str_replace('.', '', $data_pesanan['harga'])),
                    'total' => str_replace(',', '.', str_replace('.', '', $data_pesanan['total'])),
                ]);
            } else {
                $existingDetail = Detail_nota::where([
                    'nota_return_id' => $cetakpdf->id,
                    'barang_id' => $data_pesanan['barang_id'],
                    'kode_barang' => $data_pesanan['kode_barang'],
                    'nama_barang' => $data_pesanan['nama_barang'],
                    'jumlah' => $data_pesanan['jumlah'],
                    'satuan' => $data_pesanan['satuan'],
                    'harga' => str_replace(',', '.', str_replace('.', '', $data_pesanan['harga'])),
                    'total' => str_replace(',', '.', str_replace('.', '', $data_pesanan['total'])),
                ])->first();

                if (!$existingDetail) {
                    Detail_nota::create([
                        'nota_return_id' => $cetakpdf->id,
                        'barang_id' => $data_pesanan['barang_id'],
                        'kode_barang' => $data_pesanan['kode_barang'],
                        'nama_barang' => $data_pesanan['nama_barang'],
                        'jumlah' => $data_pesanan['jumlah'],
                        'satuan' => $data_pesanan['satuan'],
                        'harga' => str_replace(',', '.', str_replace('.', '', $data_pesanan['harga'])),
                        'total' => str_replace(',', '.', str_replace('.', '', $data_pesanan['total'])),
                    ]);
                }
            }

            // Increment the stock after ensuring the record is either updated or created
            Barang::where('id', $data_pesanan['barang_id'])->increment('jumlah', $data_pesanan['jumlah']);
        }

        $details = Detail_nota::where('nota_return_id', $cetakpdf->id)->get();

        return view('admin.inquery_notareturn.show', compact('cetakpdf', 'details'));
    }

    
    public function show($id)
    {
        $cetakpdf = Nota_return::where('id', $id)->first();
        $details = Detail_nota::where('nota_return_id', $id)->get();

        return view('admin.inquery_notareturn.show', compact('cetakpdf', 'details'));
    }

    public function unpostnota($id)
    {
        $item = Nota_return::where('id', $id)->first();
        $detailpembelian = Detail_nota::where('nota_return_id', $id)->get();

        foreach ($detailpembelian as $detail) {
            $barangId = $detail->barang_id;
            $barang = Barang::find($barangId);

            // Add the quantity back to the stock in the Sparepart record
            $newQuantity = $barang->jumlah - $detail->jumlah;
            $barang->update(['jumlah' => $newQuantity]);
        }
        $item->update([
            'status' => 'unpost'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function postingnota($id)
    {
        $item = Nota_return::where('id', $id)->first();
        $detailpembelian = Detail_nota::where('nota_return_id', $id)->get();

        foreach ($detailpembelian as $detail) {
            $barangId = $detail->barang_id;
            $barang = Barang::find($barangId);

            // Add the quantity back to the stock in the Sparepart record
            $newQuantity = $barang->jumlah + $detail->jumlah;
            $barang->update(['jumlah' => $newQuantity]);
        }
        $item->update([
            'status' => 'posting'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function hapusnota($id)
    {
        $item = Nota_return::where('id', $id)->first();

        $item->delete();

        return back()->with('success', 'Berhasil');
    }
}