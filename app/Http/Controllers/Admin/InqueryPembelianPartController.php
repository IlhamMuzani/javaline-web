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
            // tidak memiliki akses
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
            // tidak memiliki akses
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
                    'kode_partdetail.' . $i => 'required',
                    'nama_barang.' . $i => 'required',
                    'satuan.' . $i => 'required',
                    'jumlah.' . $i => 'required',
                    'harga.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Pembelian ban nomor " . $i + 1 . " belum dilengkapi!");
                }


                $kategori = is_null($request->kategori[$i]) ? '' : $request->kategori[$i];
                $kode_partdetail = is_null($request->kode_partdetail[$i]) ? '' : $request->kode_partdetail[$i];
                $nama_barang = is_null($request->nama_barang[$i]) ? '' : $request->nama_barang[$i];
                $satuan = is_null($request->satuan[$i]) ? '' : $request->satuan[$i];
                $jumlah = is_null($request->kategori[$i]) ? '' : $request->jumlah[$i];
                $harga = is_null($request->harga[$i]) ? '' : $request->harga[$i];

                $data_pembelians->push([
                    'detail_id' => $request->detail_ids[$i] ?? null,
                    'kategori' => $kategori,
                    'kode_partdetail' => $kode_partdetail,
                    'nama_barang' => $nama_barang,
                    'satuan' => $satuan,
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
        $transaksi = Pembelian_part::findOrFail($id);

        $transaksi->update([
            'supplier_id' => $request->supplier_id,
            'tanggal' => $format_tanggal,
            'tanggal_awal' => $tanggal1,
            'status' => 'posting',
        ]);

        $transaksi_id = $transaksi->id;


        $detailIds = $request->input('detail_ids');

        foreach ($data_pembelians as $data_pesanan) {
            $detailId = $data_pesanan['detail_id'];

            if ($detailId) {
                // Mendapatkan data Detail_pembelianpart yang akan diupdate
                $detailToUpdate = Detail_pembelianpart::find($detailId);

                if ($detailToUpdate) {
                    // Menghitung jumlah baru berdasarkan perubahan
                    $jumlahLamaDetail = $detailToUpdate->jumlah;
                    $jumlahBaruDetail = $data_pesanan['jumlah'];
                    $jumlahSparepart = $jumlahLamaDetail - $jumlahBaruDetail + $jumlahBaruDetail;

                    // Update Detail_pembelianpart
                    $detailToUpdate->update([
                        'pembelian_part_id' => $transaksi->id,
                        'tanggal_awal' => Carbon::now('Asia/Jakarta'),
                        'kategori' => $data_pesanan['kategori'],
                        'kode_partdetail' => $data_pesanan['kode_partdetail'],
                        'nama_barang' => $data_pesanan['nama_barang'],
                        'jumlah' => $jumlahBaruDetail,
                        'satuan' => $data_pesanan['satuan'],
                        'harga' => $data_pesanan['harga'],
                    ]);

                    // Temukan semua Detail_pembelianpart dengan sparepart_id yang sama
                    $detailParts = Detail_pembelianpart::where('sparepart_id', $detailToUpdate->sparepart_id)->get();

                    // Update jumlah dan harga di Sparepart untuk semua Detail_pembelianpart yang sesuai
                    foreach ($detailParts as $detail) {
                        $sparepart = Sparepart::find($detail->sparepart_id);

                        if ($sparepart) {
                            // Menghitung jumlah baru untuk Sparepart
                            $jumlahLamaSparepart = $sparepart->jumlah;
                            $jumlahBaruSparepart = $data_pesanan['jumlah'];
                            $jumlahTotalSparepart = $jumlahLamaSparepart - $jumlahLamaDetail + $jumlahBaruSparepart;

                            // Update jumlah dan harga di Sparepart
                            $sparepart->update([
                                'jumlah' => $jumlahTotalSparepart,
                                'harga' => $data_pesanan['harga'],
                            ]);
                        }
                    }
                }
            } else {
                Detail_pembelianpart::create([
                    'pembelian_part_id' => $transaksi->id,
                    'tanggal_awal' => Carbon::now('Asia/Jakarta'),
                    'kategori' => $data_pesanan['kategori'],
                    'kode_partdetail' => $data_pesanan['kode_partdetail'],
                    'nama_barang' => $data_pesanan['nama_barang'],
                    'jumlah' => $data_pesanan['jumlah'],
                    'satuan' => $data_pesanan['satuan'],
                    'harga' => $data_pesanan['harga'],
                ]);
            }
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
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function unpostpart($id)
    {
        $ban = Pembelian_part::where('id', $id)->first();

        $ban->update([
            'status' => 'unpost'
        ]);

        return back()->with('success', 'Berhasil');
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

    public function postingpart($id)
    {
        $ban = Pembelian_part::where('id', $id)->first();

        $ban->update([
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
                // 'qrcode_barang' => 'http://192.168.1.46/javaline/barang/' . $kode
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
            // tidak memiliki akses
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
            // tidak memiliki akses
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


    public function deletepart($id)
    {
        $part = Detail_pembelianpart::find($id);
        $part->delete();

        return redirect('admin/inquery_pembelianpart')->with('success', 'Berhasil menghapus Sparepart');
    }
}
