<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Detail_penjualan;
use App\Models\Faktur_penjualanreturn;
use App\Models\Nota_return;
use Illuminate\Support\Facades\Validator;

class InqueryFakturpenjualanreturnController extends Controller
{
    public function index(Request $request)
    {
        Faktur_penjualanreturn::where([
            ['status', 'posting']
        ])->update([
            'status_notif' => true
        ]);

        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $inquery = Faktur_penjualanreturn::query();

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

        return view('admin.inquery_fakturpenjualanreturn.index', compact('inquery'));
    }

    public function edit($id)
    {
        $inquery = Faktur_penjualanreturn::where('id', $id)->first();
        $details  = Detail_penjualan::where('faktur_penjualanreturn_id', $id)->get();
        $barangs = Barang::all();
        $notas = Nota_return::all();
        return view('admin.inquery_fakturpenjualanreturn.update', compact('barangs', 'notas', 'details', 'inquery'));
    }

    public function update(Request $request, $id)
    {
        $validasi_pelanggan = Validator::make(
            $request->all(),
            [
                'nota_return_id' => 'required',
            ],
            [
                'nota_return_id.required' => 'Pilih Surat Penerimaan',
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
                    'satuan.' . $i => 'required',
                    'harga_beli.' . $i => 'required',
                    'harga_jual.' . $i => 'required',
                    'diskon.' . $i => 'required',
                    'jumlah.' . $i => 'required',
                    'total.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Barang nomor " . ($i + 1) . " belum dilengkapi!"); // Corrected the syntax for concatenation and indexing
                }

                $barang_id = is_null($request->barang_id[$i]) ? '' : $request->barang_id[$i];
                $kode_barang = is_null($request->kode_barang[$i]) ? '' : $request->kode_barang[$i];
                $nama_barang = is_null($request->nama_barang[$i]) ? '' : $request->nama_barang[$i];
                $satuan = is_null($request->satuan[$i]) ? '' : $request->satuan[$i];
                $harga_beli = is_null($request->harga_beli[$i]) ? '' : $request->harga_beli[$i];
                $harga_jual = is_null($request->harga_jual[$i]) ? '' : $request->harga_jual[$i];
                $diskon = is_null($request->diskon[$i]) ? '' : $request->diskon[$i];
                $jumlah = is_null($request->jumlah[$i]) ? '' : $request->jumlah[$i];
                $total = is_null($request->total[$i]) ? '' : $request->total[$i];

                $data_pembelians->push([
                    'detail_id' => $request->detail_ids[$i] ?? null,
                    'barang_id' => $barang_id,
                    'kode_barang' => $kode_barang,
                    'nama_barang' => $nama_barang,
                    'satuan' => $satuan,
                    'harga_beli' => $harga_beli,
                    'harga_jual' => $harga_jual,
                    'diskon' => $diskon,
                    'jumlah' => $jumlah,
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
        $cetakpdf = Faktur_penjualanreturn::findOrFail($id);

        // Update the main transaction
        $cetakpdf->update([
            'nota_return_id' => $request->nota_return_id,
            'kode_nota' => $request->kode_nota,
            'pelanggan_id' => $request->pelanggan_id,
            'pelanggan_id' => $request->pelanggan_id,
            'kode_pelanggan' => $request->kode_pelanggan,
            'nama_pelanggan' => $request->nama_pelanggan,
            'alamat_pelanggan' => $request->alamat_pelanggan,
            'telp_pelanggan' => $request->telp_pelanggan,
            'keterangan' => $request->keterangan,
            'grand_total' => str_replace(',', '.', str_replace('.', '', $request->grand_total)),
            'status' => 'posting',
        ]);

        $transaksi_id = $cetakpdf->id;
        $detailIds = $request->input('detail_ids');

        foreach ($data_pembelians as $data_pesanan) {
            $detailId = $data_pesanan['detail_id'];

            if ($detailId) {
                $detailToUpdate = Detail_penjualan::find($detailId);

                if ($detailToUpdate) {
                    $jumlahLamaDetail = $detailToUpdate->jumlah;
                    $jumlahBaruDetail = $data_pesanan['jumlah'];
                    $selisihStok = $jumlahBaruDetail - $jumlahLamaDetail;
                    $sparepart = Barang::find($detailToUpdate->barang_id);

                    if ($sparepart) {
                        $jumlahLamaSparepart = $sparepart->jumlah;
                        $jumlahBaruSparepart = $data_pesanan['jumlah'];
                        $jumlahTotalSparepart = $jumlahLamaSparepart - $selisihStok;

                        $detailToUpdate->update([
                            'faktur_penjualanreturn_id' => $cetakpdf->id,
                            'barang_id' => $data_pesanan['barang_id'],
                            'kode_barang' => $data_pesanan['kode_barang'],
                            'nama_barang' => $data_pesanan['nama_barang'],
                            'satuan' => $data_pesanan['satuan'],
                            'jumlah' => $data_pesanan['jumlah'],
                            'harga_beli' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['harga_beli'])),
                            'harga_jual' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['harga_jual'])),
                            'diskon' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['diskon'])),
                            'total' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['total'])),
                        ]);
                        $sparepart->update([
                            'jumlah' => $jumlahTotalSparepart,
                        ]);
                    }
                }
            } else {
                $existingDetail = Detail_penjualan::where([
                    'faktur_penjualanreturn_id' => $cetakpdf->id,
                    'barang_id' => $data_pesanan['barang_id'],
                    'kode_barang' => $data_pesanan['kode_barang'],
                    'nama_barang' => $data_pesanan['nama_barang'],
                    'satuan' => $data_pesanan['satuan'],
                    'jumlah' => $data_pesanan['jumlah'],
                    'harga_beli' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['harga_beli'])),
                    'harga_jual' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['harga_jual'])),
                    'diskon' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['diskon'])),
                    'total' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['total'])),
                ])->first();

                if (!$existingDetail) {
                    Detail_penjualan::create([
                        'faktur_penjualanreturn_id' => $cetakpdf->id,
                        'barang_id' => $data_pesanan['barang_id'],
                        'kode_barang' => $data_pesanan['kode_barang'],
                        'nama_barang' => $data_pesanan['nama_barang'],
                        'satuan' => $data_pesanan['satuan'],
                        'jumlah' => $data_pesanan['jumlah'],
                        'harga_beli' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['harga_beli'])),
                        'harga_jual' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['harga_jual'])),
                        'diskon' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['diskon'])),
                        'total' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['total'])),
                    ]);

                    $sparepart = Barang::find($data_pesanan['barang_id']);

                    if ($sparepart) {
                        $newQuantity = $sparepart->jumlah - $data_pesanan['jumlah'];
                        $newQuantity = max(0, $newQuantity);
                        $sparepart->update(['jumlah' => $newQuantity]);
                    }
                }
            }
        }

        $details = Detail_penjualan::where('faktur_penjualanreturn_id', $cetakpdf->id)->get();

        return view('admin.inquery_fakturpenjualanreturn.show', compact('cetakpdf', 'details'));
    }

    public function show($id)
    {
        $cetakpdf = Faktur_penjualanreturn::where('id', $id)->first();
        $details = Detail_penjualan::where('faktur_penjualanreturn_id', $id)->get();

        return view('admin.inquery_fakturpenjualanreturn.show', compact('cetakpdf', 'details'));
    }

    public function unpostpenjualan($id)
    {
        $item = Faktur_penjualanreturn::where('id', $id)->first();

        $item->update([
            'status' => 'unpost'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function postingpenjualan($id)
    {
        $item = Faktur_penjualanreturn::where('id', $id)->first();

        $item->update([
            'status' => 'posting'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function hapuspenjualan($id)
    {
        $item = Faktur_penjualanreturn::where('id', $id)->first();

        $item->delete();

        return back()->with('success', 'Berhasil');
    }


    public function dell($id)
    {
        $item = Detail_penjualan::find($id);

        if ($item) {
            $penjualan = Faktur_penjualanreturn::find($item->faktur_penjualanreturn_id);

            if ($penjualan) {
                $grand = $penjualan->grand_total;
                $nominal = $item->total;
                $total = $grand - $nominal;
                $penjualan->update(['grand_total' => $total]);
            } else {
                return response()->json(['message' => 'Memo not found'], 404);
            }
            $item->delete();
            return response()->json(['message' => 'Data deleted successfully']);
        } else {
            return response()->json(['message' => 'Detail penjualan not found'], 404);
        }
    }
}
