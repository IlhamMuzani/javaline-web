<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Kendaraan;
use App\Models\Sparepart;
use Illuminate\Http\Request;
use App\Models\Pemasangan_part;
use App\Http\Controllers\Controller;
use App\Models\Detail_pemasanganpart;
use Illuminate\Support\Facades\Validator;

class InqueryPemasanganpartController extends Controller
{
    public function index(Request $request)
    {

        if (auth()->check() && auth()->user()->menu['inquery pemasangan part']) {

            Pemasangan_part::where([
                ['status', 'posting']
            ])->update([
                'status_notif' => true
            ]);

            $status = $request->status;
            $tanggal_awal = $request->tanggal_awal;
            $tanggal_akhir = $request->tanggal_akhir;

            $inquery = Pemasangan_part::query();

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
                $inquery->orWhereDate('tanggal_awal', Carbon::today());
            }


            $inquery->orderBy('id', 'DESC');
            $inquery = $inquery->get();

            return view('admin.inquery_pemasanganpart.index', compact('inquery'));
        } else {
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function edit($id)
    {
        if (auth()->check() && auth()->user()->menu['inquery pemasangan part']) {

            $inquery = Pemasangan_part::where('id', $id)->first();
            $kendaraans = Kendaraan::all();
            $spareparts = Sparepart::where([
                ['kategori', '!=', 'oli']
            ])->get();
            $details = Detail_pemasanganpart::where('pemasangan_part_id', $id)->get();

            return view('admin.inquery_pemasanganpart.update', compact('inquery', 'kendaraans', 'spareparts', 'details'));
        } else {
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }


    public function update(Request $request, $id)
    {
        $validasi_pelanggan = Validator::make($request->all(), [
            // 'kendaraan_id' => 'required',
        ], [
            // 'kendaraan_id.required' => 'Pilih no kabin!',
        ]);

        $error_pelanggans = array();
        $error_pesanans = array();
        $data_pembelians = collect();

        $item = Pemasangan_part::findOrFail($id);
        $tanggal_awal = Carbon::parse($item->tanggal_awal);

        $today = Carbon::now('Asia/Jakarta')->format('Y-m-d');
        $lastUpdatedDate = $tanggal_awal->format('Y-m-d');

        if ($lastUpdatedDate < $today) {
            return back()->with('errormax', 'Anda tidak dapat melakukan update setelah berganti hari.');
        }

        if ($validasi_pelanggan->fails()) {
            array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
        }


        if ($request->has('sparepart_id')) {
            for ($i = 0; $i < count($request->sparepart_id); $i++) {
                $validasi_produk = Validator::make($request->all(), [
                    'sparepart_id.' . $i => 'required',
                    'nama_barang.' . $i => 'required',
                    'keterangan.' . $i => 'required',
                    'jumlah.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Pemasangan Part nomor " . $i + 1 . " belum dilengkapi!");
                }

                $sparepart_id = is_null($request->sparepart_id[$i]) ? '' : $request->sparepart_id[$i];
                $nama_barang = is_null($request->nama_barang[$i]) ? '' : $request->nama_barang[$i];
                $keterangan = is_null($request->keterangan[$i]) ? '' : $request->keterangan[$i];
                $jumlah = is_null($request->jumlah[$i]) ? '' : $request->jumlah[$i];

                $data_pembelians->push([
                    'detail_id' => $request->detail_ids[$i] ?? null,
                    'sparepart_id' => $sparepart_id,
                    'nama_barang' => $nama_barang,
                    'keterangan' => $keterangan,
                    'jumlah' => $jumlah
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

        $transaksi = Pemasangan_part::findOrFail($id);

        $transaksi->update([
            'kendaraan_id' => $request->kendaraan_id,
            'status' => 'posting',
        ]);

        $transaksi_id = $transaksi->id;


        $detailIds = $request->input('detail_ids');

        foreach ($data_pembelians as $data_pesanan) {
            $detailId = $data_pesanan['detail_id'];

            if ($detailId) {
                $detailToUpdate = Detail_pemasanganpart::find($detailId);

                if ($detailToUpdate) {
                    $jumlahLamaDetail = $detailToUpdate->jumlah;
                    $jumlahBaruDetail = $data_pesanan['jumlah'];
                    $selisihStok = $jumlahBaruDetail - $jumlahLamaDetail;
                    $sparepart = Sparepart::find($detailToUpdate->sparepart_id);

                    if ($sparepart) {
                        $jumlahLamaSparepart = $sparepart->jumlah;
                        $jumlahBaruSparepart = $data_pesanan['jumlah'];
                        $jumlahTotalSparepart = $jumlahLamaSparepart - $selisihStok;
                        $detailToUpdate->update([
                            'pemasangan_part_id' => $transaksi->id,
                            'sparepart_id' => $data_pesanan['sparepart_id'],
                            'keterangan' => $data_pesanan['keterangan'],
                            'jumlah' => $data_pesanan['jumlah'],
                        ]);
                        $sparepart->update([
                            'jumlah' => $jumlahTotalSparepart,
                        ]);
                    }
                }
            } else {
                $existingDetail = Detail_pemasanganpart::where([
                    'pemasangan_part_id' => $transaksi->id,
                    'sparepart_id' => $data_pesanan['sparepart_id'],
                ])->first();

                if (!$existingDetail) {
                    Detail_pemasanganpart::create([
                        'pemasangan_part_id' => $transaksi->id,
                        'tanggal_awal' => Carbon::now('Asia/Jakarta'),
                        'sparepart_id' => $data_pesanan['sparepart_id'],
                        'keterangan' => $data_pesanan['keterangan'],
                        'jumlah' => $data_pesanan['jumlah'],
                    ]);
                    $sparepart = Sparepart::find($data_pesanan['sparepart_id']);

                    if ($sparepart) {
                        $newQuantity = $sparepart->jumlah - $data_pesanan['jumlah'];
                        $sparepart->update(['jumlah' => $newQuantity]);
                    }
                }
            }
        }


        $pemasangan_part = Pemasangan_part::find($transaksi_id);

        $parts = Detail_pemasanganpart::where('pemasangan_part_id', $pemasangan_part->id)->get();

        return view('admin.inquery_pemasanganpart.show', compact('parts', 'pemasangan_part'));
    }

    public function unpostpemasanganpart($id)
    {
        $part = Pemasangan_part::where('id', $id)->first();

        $detailpemasangan = Detail_pemasanganpart::where('pemasangan_part_id', $id)->get();

        foreach ($detailpemasangan as $detail) {
            $sparepart = Sparepart::find($detail['sparepart_id']);

            if ($sparepart) {
                $sparepart->jumlah += $detail->jumlah;
                $sparepart->save();
            }
        }

        $part->update([
            'status' => 'unpost'
        ]);



        return back()->with('success', 'Berhasil');
    }

    public function postingpemasanganpart($id)
    {
        $part = Pemasangan_part::where('id', $id)->first();
        $detailpemasangan = Detail_pemasanganpart::where('pemasangan_part_id', $id)->get();

        foreach ($detailpemasangan as $detail) {
            $sparepart = Sparepart::find($detail['sparepart_id']);

            if ($sparepart) {
                $sparepart->jumlah -= $detail->jumlah;
                $sparepart->save();
            }
        }

        $part->update([
            'status' => 'posting'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function lihat_pemasanganpart($id)
    {
        if (auth()->check() && auth()->user()->menu['inquery pemasangan part']) {

            $pemasangan_part = Pemasangan_part::findOrFail($id);

            $parts = Detail_pemasanganpart::where('pemasangan_part_id', $id)->get();

            return view('admin.inquery_pemasanganpart.show', compact('parts', 'pemasangan_part'));
        } else {
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function delete($id)
    {
        $part = Pemasangan_part::find($id);
        $detailpenggantianpart = Detail_pemasanganpart::where('pemasangan_part_id', $id)->get();

        foreach ($detailpenggantianpart as $detail) {
            $sparepartId = $detail->sparepart_id;
            $sparepart = Sparepart::find($sparepartId);
            $newQuantity = $sparepart->jumlah + $detail->jumlah;
            $sparepart->update(['jumlah' => $newQuantity]);
        }
        $part->detail_part()->delete();
        $part->delete();

        return redirect('admin/inquery_pemasanganpart')->with('success', 'Berhasil menghapus Pemasangan');
    }

    public function deletepart($id)
    {
        $part = Detail_pemasanganpart::find($id);

        if ($part) {
            $sparepart = Sparepart::find($part->sparepart_id);

            if ($sparepart) {
                $sparepart->update(['jumlah' => $sparepart->jumlah + $part->jumlah]);

                $part->delete();

                return response()->json(['message' => 'Data deleted successfully']);
            } else {
                return response()->json(['message' => 'Sparepart not found'], 404);
            }
        } else {
            return response()->json(['message' => 'Detail_pemasanganpart not found'], 404);
        }
    }

    public function hapuspemasanganpart($id)
    {
        $part = Detail_pemasanganpart::find($id);

        if ($part) {
            $sparepart = Sparepart::find($part->sparepart_id);

            if ($sparepart) {
                $sparepart->update(['jumlah' => $sparepart->jumlah + $part->jumlah]);

                $part->delete();

                return response()->json(['message' => 'Data deleted successfully']);
            } else {
                return response()->json(['message' => 'Sparepart not found'], 404);
            }
        } else {
            return response()->json(['message' => 'Detail_pemasanganpart not found'], 404);
        }
    }
}