<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use App\Models\Merek;
use App\Models\Ukuran;
use App\Models\Supplier;
use App\Models\Sparepart;
use Illuminate\Http\Request;
use App\Models\Pembelian_ban;
use App\Models\Pembelian_part;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\Detail_pembelianpart;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class InqueryPembelianPartController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->check() && auth()->user()->menu['inquery pembelian part']) {

            Pembelian_part::where([
                ['status', 'posting']
            ])->update([
                'status_notif' => true
            ]);

            $status = $request->status;
            $tanggal_awal = $request->tanggal_awal;
            $tanggal_akhir = $request->tanggal_akhir;

            $inquery = Pembelian_part::query();

            if ($status) {
                $inquery->where('status', $status);
            }

            if ($tanggal_awal && $tanggal_akhir) {
                $inquery->whereBetween('tanggal_awal', [$tanggal_awal, $tanggal_akhir]);
            } elseif ($tanggal_awal) {
                $inquery->where('tanggal_awal', '>=', $tanggal_awal);
            } elseif ($tanggal_akhir) {
                $inquery->where('tanggal_awal', '<=', $tanggal_akhir);
            }

            $inquery->orWhereDate('tanggal_awal', Carbon::today());

            $inquery->orderBy('id', 'DESC');
            $inquery = $inquery->get();

            return view('admin.inquery_pembelianpart.index', compact('inquery'));
        } else {
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function edit($id)
    {
        if (auth()->check() && auth()->user()->menu['inquery pembelian part']) {

            $inquery = Pembelian_part::where('id', $id)->first();
            $suppliers = Supplier::all();
            $spareparts = Sparepart::all();
            $details = Detail_pembelianpart::where('pembelian_part_id', $id)->get();
            return view('admin.inquery_pembelianpart.update', compact('inquery', 'suppliers', 'spareparts', 'details'));
        } else {
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }
    public function update(Request $request, $id)
    {
        $validasi_pelanggan = Validator::make($request->all(), [
            'supplier_id' => 'required',
        ], [
            'supplier_id.required' => 'Pilih nama supplier!',
        ]);

        $error_pelanggans = array();
        $error_pesanans = array();
        $data_pembelians = collect();


        if ($validasi_pelanggan->fails()) {
            array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
        }


        if ($request->has('kategori')) {
            for ($i = 0; $i < count($request->kategori); $i++) {
                $validasi_produk = Validator::make($request->all(), [
                    'kategori.' . $i => 'required',
                    'sparepart_id.' . $i => 'required',
                    'kode_partdetail.' . $i => 'required',
                    'nama_barang.' . $i => 'required',
                    'satuan.' . $i => 'required',
                    'hargasatuan.' . $i => 'required',
                    'jumlah.' . $i => 'required',
                    'harga.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Pembelian ban nomor " . $i + 1 . " belum dilengkapi!");
                }


                $kategori = is_null($request->kategori[$i]) ? '' : $request->kategori[$i];
                $sparepart_id = is_null($request->sparepart_id[$i]) ? '' : $request->sparepart_id[$i];
                $kode_partdetail = is_null($request->kode_partdetail[$i]) ? '' : $request->kode_partdetail[$i];
                $nama_barang = is_null($request->nama_barang[$i]) ? '' : $request->nama_barang[$i];
                $satuan = is_null($request->satuan[$i]) ? '' : $request->satuan[$i];
                $hargasatuan = is_null($request->hargasatuan[$i]) ? '' : $request->hargasatuan[$i];
                $jumlah = is_null($request->kategori[$i]) ? '' : $request->jumlah[$i];
                $harga = is_null($request->harga[$i]) ? '' : $request->harga[$i];

                $data_pembelians->push([
                    'detail_id' => $request->detail_ids[$i] ?? null,
                    'sparepart_id' => $sparepart_id,
                    'kategori' => $kategori,
                    'kode_partdetail' => $kode_partdetail,
                    'nama_barang' => $nama_barang,
                    'satuan' => $satuan,
                    'hargasatuan' => $hargasatuan,
                    'jumlah' => $jumlah,
                    'harga' => $harga
                ]);
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

        $tanggal = Carbon::now()->format('Y-m-d');
        $transaksi = Pembelian_part::findOrFail($id);

        $grandTotal = 0;
        if ($request->has('harga')) {
            foreach ($request->harga as $harga) {
                $hargaNumeric = (float) str_replace('.', '', $harga);
                $grandTotal += $hargaNumeric;
            }
        }

        $transaksi->update([
            'supplier_id' => $request->supplier_id,
            'grand_total' => $grandTotal,
            'status' => 'posting',
        ]);

        $transaksi_id = $transaksi->id;


        $detailIds = $request->input('detail_ids');

        foreach ($data_pembelians as $data_pesanan) {
            $detailId = $data_pesanan['detail_id'];

            if ($detailId) {
                Detail_pembelianpart::where('id', $detailId)->update([
                    'pembelian_part_id' => $transaksi->id,
                    'sparepart_id' => $data_pesanan['sparepart_id'],
                    'tanggal_awal' => Carbon::now('Asia/Jakarta'),
                    'kategori' => $data_pesanan['kategori'],
                    'kode_partdetail' => $data_pesanan['kode_partdetail'],
                    'nama_barang' => $data_pesanan['nama_barang'],
                    'jumlah' => $data_pesanan['jumlah'],
                    'satuan' => $data_pesanan['satuan'],
                    'hargasatuan' => $data_pesanan['hargasatuan'],
                    'harga' => $data_pesanan['harga'],
                ]);
            } else {
                $existingDetail = Detail_pembelianpart::where([
                    'pembelian_part_id' => $transaksi->id,
                    'sparepart_id' => $data_pesanan['sparepart_id'],
                    'tanggal_awal' => Carbon::now('Asia/Jakarta'),
                    'kategori' => $data_pesanan['kategori'],
                    'kode_partdetail' => $data_pesanan['kode_partdetail'],
                    'nama_barang' => $data_pesanan['nama_barang'],
                    'jumlah' => $data_pesanan['jumlah'],
                    'satuan' => $data_pesanan['satuan'],
                    'hargasatuan' => $data_pesanan['hargasatuan'],
                    'harga' => $data_pesanan['harga'],
                ])->first();

                if (!$existingDetail) {
                    Detail_pembelianpart::create([
                        'pembelian_part_id' => $transaksi->id,
                        'sparepart_id' => $data_pesanan['sparepart_id'],
                        'tanggal_awal' => Carbon::now('Asia/Jakarta'),
                        'kategori' => $data_pesanan['kategori'],
                        'kode_partdetail' => $data_pesanan['kode_partdetail'],
                        'nama_barang' => $data_pesanan['nama_barang'],
                        'jumlah' => $data_pesanan['jumlah'],
                        'satuan' => $data_pesanan['satuan'],
                        'hargasatuan' => $data_pesanan['hargasatuan'],
                        'harga' => $data_pesanan['harga'],
                    ]);
                }
            }

            Sparepart::where('id', $data_pesanan['sparepart_id'])->increment('jumlah', $data_pesanan['jumlah']);
        }

        $pembelians = Pembelian_part::find($transaksi_id);

        $parts = Detail_pembelianpart::where('pembelian_part_id', $pembelians->id)->get();

        return view('admin.inquery_pembelianpart.show', compact('parts', 'pembelians'));
    }

    public function print(Request $request)
    {
        if (auth()->check() && auth()->user()->menu['inquery pembelian part']) {

            $status = $request->status;
            $tanggal_awal = $request->tanggal_awal;
            $tanggal_akhir = $request->tanggal_akhir;

            if ($status != "" && $tanggal_awal != "" && $tanggal_akhir != "") {
                $inquery = Pembelian_part::where('status', $status)
                    ->whereDate('tanggal_awal', '>=', $tanggal_awal)
                    ->whereDate('tanggal_awal', '<=', $tanggal_akhir)
                    ->orderBy('id', 'DESC')->get();
            } else if ($status != "" && $tanggal_awal == "" && $tanggal_akhir == "") {
                $inquery = Pembelian_part::where('status', $status)->orderBy('id', 'DESC')->get();
            } else if ($status == "" && $tanggal_awal != "" && $tanggal_akhir != "") {
                $inquery = Pembelian_part::whereDate('tanggal_awal', '>=', $tanggal_awal)
                    ->whereDate('tanggal_awal', '<=', $tanggal_akhir)
                    ->orderBy('id', 'DESC')->get();
            } else if ($status != "" && $tanggal_awal != "") {
                $inquery = Pembelian_part::where('status', $status)
                    ->whereDate('tanggal_awal', '>=', $tanggal_awal)
                    ->orderBy('id', 'DESC')->get();
            } else if ($status == "" && $tanggal_awal != "") {
                $inquery = Pembelian_part::whereDate('tanggal_awal', '>=', $tanggal_awal)
                    ->orderBy('id', 'DESC')->get();
            } else {
                $inquery = Pembelian_part::orderBy('id', 'DESC')->get();
            }

            $pdf = Pdf::loadview('admin.report.print', compact('inquery'));
            return $pdf->stream('Laporan Pengaduan');
        } else {
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }


    public function kode_supp()
    {
        $supplier = Supplier::all();
        if ($supplier->isEmpty()) {
            $num = "000001";
        } else {
            $id = Supplier::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'AC';
        $kode_supplier = $data . $num;
        return $kode_supplier;
    }

    public function unpostpart($id)
    {
        $pembelian = Pembelian_part::where('id', $id)->first();
        $detailpembelian = Detail_pembelianpart::where('pembelian_part_id', $id)->get();

        foreach ($detailpembelian as $detail) {
            $barangId = $detail->sparepart_id;
            $barang = Sparepart::find($barangId);

            if ($barang) {
                $newQuantity = $barang->jumlah - $detail->jumlah;
                $barang->update(['jumlah' => $newQuantity]);
            } else {
            }
        }

        $pembelian->update([
            'status' => 'unpost'
        ]);

        return back()->with('success', 'Berhasil');
    }


    public function postingpart($id)
    {
        $pembelian = Pembelian_part::where('id', $id)->first();
        $detailpembelian = Detail_pembelianpart::where('pembelian_part_id', $id)->get();

        foreach ($detailpembelian as $detail) {
            $barangId = $detail->sparepart_id;
            $barang = Sparepart::find($barangId);

            if ($barang) {
                $newQuantity = $barang->jumlah + $detail->jumlah;
                $barang->update(['jumlah' => $newQuantity]);
            } else {
            }
        }

        $pembelian->update([
            'status' => 'posting'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function tambah_sparepart(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'kategori' => 'required',
                'nama_barang' => 'required',
                'keterangan' => 'required',
                'harga' => 'required',
                'jumlah' => 'required',
                'satuan' => 'required',
            ],
            [
                'kategori.required' => 'Pilih kategori',
                'nama_barang.required' => 'Masukkan nama barang',
                'keterangan.required' => 'Masukkan keterangan',
                'harga_jual.required' => 'Masukkan harga jual',
                'jumlah.required' => 'Masukkan stok',
                'satuan.required' => 'Masukkan satuan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kode = '';
        if ($request->kategori === 'oli') {
            $kode = $this->kodeoli();
        } elseif ($request->kategori === 'mesin') {
            $kode = $this->kodemesin();
        } elseif ($request->kategori === 'body') {
            $kode = $this->kodebody();
        } elseif ($request->kategori === 'sasis') {
            $kode = $this->kodesasis();
        }
        Sparepart::create(array_merge(
            $request->all(),
            [
                'kode_partdetail' => $kode,
                'qrcode_barang' => 'https:///javaline.id/barang/' . $kode,
                'tanggal_awal' => Carbon::now('Asia/Jakarta'),

            ],
        ));

        return Redirect::back()->with('success', 'Berhasil menambahkan part');
    }

    public function kode()
    {
        $pembelian_part = Pembelian_part::all();
        if ($pembelian_part->isEmpty()) {
            $num = "000001";
        } else {
            $id = Pembelian_part::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'FS';
        $kode_pembelian_part = $data . $num;
        return $kode_pembelian_part;
    }

    public function kodeoli()
    {
        $part = Sparepart::all();
        if ($part->isEmpty()) {
            $num = "000001";
        } else {
            $id = Sparepart::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'SO';
        $kode_part = $data . $num;
        return $kode_part;
    }

    public function kodebody()
    {
        $part = Sparepart::all();
        if ($part->isEmpty()) {
            $num = "000001";
        } else {
            $id = Sparepart::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'SB';
        $kode_part = $data . $num;
        return $kode_part;
    }

    public function kodemesin()
    {
        $part = Sparepart::all();
        if ($part->isEmpty()) {
            $num = "000001";
        } else {
            $id = Sparepart::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'SM';
        $kode_part = $data . $num;
        return $kode_part;
    }

    public function kodesasis()
    {
        $part = Sparepart::all();
        if ($part->isEmpty()) {
            $num = "000001";
        } else {
            $id = Sparepart::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'SS';
        $kode_part = $data . $num;
        return $kode_part;
    }

    public function kodesparepart()
    {
        $part = Sparepart::all();
        if ($part->isEmpty()) {
            $num = "000001";
        } else {
            $id = Sparepart::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'A0';
        $kode_part = $data . $num;
        return $kode_part;
    }

    public function lihat_fakturpart($id)
    {
        if (auth()->check() && auth()->user()->menu['inquery pembelian part']) {

            $pembelians = Pembelian_part::where('id', $id)->first();
            $pembelian_part = Pembelian_part::find($id);

            $parts = Detail_pembelianpart::where('pembelian_part_id', $pembelian_part->id)->get();

            return view('admin.inquery_pembelianpart.show', compact('parts', 'pembelians'));
        } else {
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function edit_fakturpart($id)
    {
        if (auth()->check() && auth()->user()->menu['inquery pembelian part']) {

            $inquery = Pembelian_part::where('id', $id)->first();
            $suppliers = Supplier::all();
            $spareparts = Sparepart::all();
            $details = Detail_pembelianpart::where('pembelian_part_id', $id)->get();

            return view('admin.inquery_pembelianpart.update', compact('inquery', 'suppliers', 'spareparts', 'details'));
        } else {
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function destroy($id)
    {
        $ban = Pembelian_part::find($id);
        $ban->detail_part()->delete();
        $ban->delete();

        return redirect('admin/inquery_pembelianpart')->with('success', 'Berhasil menghapus Pembelian');
    }

    public function hapuspart($id)
    {
        $ban = Pembelian_part::where('id', $id)->first();

        $ban->detail_part()->delete();
        $ban->delete();
        return back()->with('success', 'Berhasil');
    }

    public function deletepart($id)
    {
        $part = Detail_pembelianpart::find($id);
        $part->delete();

        return redirect('admin/inquery_pembelianpart')->with('success', 'Berhasil menghapus Sparepart');
    }
}