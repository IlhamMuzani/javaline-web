<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Kendaraan;
use App\Models\Sparepart;
use Illuminate\Http\Request;
use App\Models\Pemasangan_part;
use App\Http\Controllers\Controller;
use App\Models\Bearing;
use App\Models\Detail_pemasanganpart;
use App\Models\Detail_penggantianbearing;
use App\Models\Detail_penggantianoli;
use App\Models\Detail_penggantianpart;
use App\Models\Lama_bearing;
use App\Models\Lama_penggantianoli;
use App\Models\Pembelian_ban;
use App\Models\Penggantian_bearing;
use Illuminate\Support\Facades\Validator;

class InqueryPenggantianbearingController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->check() && auth()->user()->menu['inquery penggantian oli']) {

            Penggantian_bearing::where([
                ['status', 'posting']
            ])->update([
                'status_notif' => true
            ]);

            $status = $request->status;
            $tanggal_awal = $request->tanggal_awal;
            $tanggal_akhir = $request->tanggal_akhir;

            $inquery = Penggantian_bearing::query();

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

            return view('admin.inquery_penggantianbearing.index', compact('inquery'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }
    public function edit($id)
    {
        if (auth()->check() && auth()->user()->menu['inquery penggantian oli']) {

            $inquery = Penggantian_bearing::where('id', $id)->first();
            $spareparts = Sparepart::get();

            $details = Detail_penggantianbearing::where('penggantian_bearing_id', $id)
                ->whereNotNull('kategori') // Memastikan kategori tidak null
                ->get();
            $detailgrease = Detail_penggantianbearing::where('penggantian_bearing_id', $id)
                ->whereNull('kategori') // Mencari kategori yang null
                ->first();

            return view('admin.inquery_penggantianbearing.update', compact('detailgrease', 'inquery', 'spareparts', 'details'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function update(Request $request, $id)
    {
        $kendaraan_id = $request->kendaraan_id;
        $kendaraan = Kendaraan::where('id', $kendaraan_id)->first();
        $validasi_pelanggan = Validator::make($request->all(), [
            'kendaraan_id' => 'required',
            'km' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) use ($kendaraan) {
                    if ($value < $kendaraan->km) { // Memastikan km tidak lebih rendah
                        $fail('Nilai km akhir harus sama atau lebih tinggi dari km awal');
                    }
                },
            ],
        ], [
            'kendaraan_id.required' => 'Pilih no kabin',
            'km.required' => 'Masukkan nilai km',
        ]);

        $error_pelanggans = array();
        $error_pesanans = array();
        $data_pembelians = collect();
        $data_pembelians2 = collect();


        if ($validasi_pelanggan->fails()) {
            array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
        }


        if ($request->has('sparepart_id')) {
            for ($i = 0; $i < count($request->sparepart_id); $i++) {
                $validasi_produk = Validator::make($request->all(), [
                    'sparepart_id.' . $i => 'required',
                    'kategori.' . $i => 'required',
                    'kode_barang.' . $i => 'required',
                    'nama_barang.' . $i => 'required',
                    'jumlah.*' => 'required|numeric|min:1',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Pergantian Bearing nomor " . $i + 1 . " belum dilengkapi!");
                }


                $sparepart_id = is_null($request->sparepart_id[$i]) ? '' : $request->sparepart_id[$i];
                $kategori = is_null($request->kategori[$i]) ? '' : $request->kategori[$i];
                $nama_barang = is_null($request->nama_barang[$i]) ? '' : $request->nama_barang[$i];
                $kode_barang = is_null($request->kode_barang[$i]) ? '' : $request->kode_barang[$i];
                $jumlah = is_null($request->jumlah[$i]) ? '' : $request->jumlah[$i];

                $data_pembelians->push(['detail_id' => $request->detail_ids[$i] ?? null, 'sparepart_id' => $sparepart_id, 'kategori' => $kategori, 'kode_barang' => $kode_barang, 'nama_barang' => $nama_barang, 'jumlah' => $jumlah]);
            }
        } else {
        }

        if ($error_pelanggans || $error_pesanans) {
            return back()
                ->withInput()
                ->with('error_pelanggans', $error_pelanggans)
                ->with('error_pesanans', $error_pesanans)
                ->with('data_pembelians', $data_pembelians)
                ->with('data_pembelians2', $data_pembelians2);
        }

        $transaksi = Penggantian_bearing::findOrFail($id);

        $transaksi->update([
            'status' => 'posting',
        ]);

        $kendaraan = Kendaraan::where('id', $transaksi->kendaraan_id)->first();

        $transaksi_id = $transaksi->id;

        $detailIds = $request->input('detail_ids');

        foreach ($data_pembelians as $data_pesanan) {
            $detailId = $data_pesanan['detail_id'];

            if ($detailId) {
                $detailToUpdate = Detail_penggantianbearing::find($detailId);
                $sparepart = Sparepart::find($data_pesanan['sparepart_id']);
                if ($sparepart) {
                    $jumlah_sparepart = $sparepart->jumlah - $data_pesanan['jumlah'];

                    $sparepart->update(['jumlah' => $jumlah_sparepart]);
                    $detailToUpdate->update([
                        'penggantian_bearing_id' => $transaksi->id,
                        'sparepart_id' => $data_pesanan['sparepart_id'],
                        'kategori' => $data_pesanan['kategori'],
                        'kode_barang' => $data_pesanan['kode_barang'],
                        'nama_barang' => $data_pesanan['nama_barang'],
                        'jumlah' => $data_pesanan['jumlah'],
                    ]);
                }
                // Mengambil km kendaraan dan lama_bearing
                $km_kendaraan = $request->km;
                $lama_bearing = Lama_bearing::first();
                $bearing = Bearing::where('kendaraan_id', $transaksi->id)->first();

                // Memeriksa kategori dan memperbarui bearing yang sesuai
                switch ($data_pesanan['kategori']) {
                    case 'Axle 1A':
                        $bearing->update([
                            'bearing1a' => $km_kendaraan + $lama_bearing->batas,
                            'status_bearing1a' => 'sudah penggantian',
                        ]);
                        break;

                    case 'Axle 1B':
                        $bearing->update([
                            'bearing1b' => $km_kendaraan + $lama_bearing->batas,
                            'status_bearing1b' => 'sudah penggantian',
                        ]);
                        break;

                    case 'Axle 2A':
                        $bearing->update([
                            'bearing2a' => $km_kendaraan + $lama_bearing->batas,
                            'status_bearing2a' => 'sudah penggantian',
                        ]);
                        break;

                    case 'Axle 2B':
                        $bearing->update([
                            'bearing2b' => $km_kendaraan + $lama_bearing->batas,
                            'status_bearing2b' => 'sudah penggantian',
                        ]);
                        break;

                    case 'Axle 3A':
                        $bearing->update([
                            'bearing3a' => $km_kendaraan + $lama_bearing->batas,
                            'status_bearing3a' => 'sudah penggantian',
                        ]);
                        break;

                    case 'Axle 3B':
                        $bearing->update([
                            'bearing3b' => $km_kendaraan + $lama_bearing->batas,
                            'status_bearing3b' => 'sudah penggantian',
                        ]);
                        break;

                    case 'Axle 4A':
                        $bearing->update([
                            'bearing4a' => $km_kendaraan + $lama_bearing->batas,
                            'status_bearing4a' => 'sudah penggantian',
                        ]);
                        break;

                    case 'Axle 4B':
                        $bearing->update([
                            'bearing4b' => $km_kendaraan + $lama_bearing->batas,
                            'status_bearing4b' => 'sudah penggantian',
                        ]);
                        break;

                    case 'Axle 5A':
                        $bearing->update([
                            'bearing5a' => $km_kendaraan + $lama_bearing->batas,
                            'status_bearing5a' => 'sudah penggantian',
                        ]);
                        break;

                    case 'Axle 5B':
                        $bearing->update([
                            'bearing5b' => $km_kendaraan + $lama_bearing->batas,
                            'status_bearing5b' => 'sudah penggantian',
                        ]);
                        break;

                    case 'Axle 6A':
                        $bearing->update([
                            'bearing6a' => $km_kendaraan + $lama_bearing->batas,
                            'status_bearing6a' => 'sudah penggantian',
                        ]);
                        break;

                    case 'Axle 6B':
                        $bearing->update([
                            'bearing6b' => $km_kendaraan + $lama_bearing->batas,
                            'status_bearing6b' => 'sudah penggantian',
                        ]);
                        break;

                    default:
                        // Jika kategori tidak dikenal
                        break;
                }
            } else {
                $existingDetail = Detail_penggantianbearing::where([
                    'penggantian_bearing_id' => $transaksi->id,
                    'sparepart_id' => $data_pesanan['sparepart_id'],
                ])->first();

                $sparepart = Sparepart::find($data_pesanan['sparepart_id']);
                if (!$existingDetail) {
                    // Mengurangkan jumlah sparepart
                    $jumlah_sparepart = $sparepart->jumlah - $data_pesanan['jumlah'];
                    $sparepart->update(['jumlah' => $jumlah_sparepart]);

                    Detail_penggantianbearing::create([
                        'kendaraan_id' => $request->kendaraan_id,
                        'penggantian_bearing_id' => $transaksi->id,
                        'sparepart_id' => $data_pesanan['sparepart_id'],
                        'kategori' => $data_pesanan['kategori'],
                        'kode_barang' => $data_pesanan['kode_barang'],
                        'nama_barang' => $data_pesanan['nama_barang'],
                        'jumlah' => $data_pesanan['jumlah'],
                        'tanggal_awal' => Carbon::now('Asia/Jakarta'),
                    ]);

                    return;
                    // Mengambil km kendaraan dan lama_bearing
                    $km_kendaraan = $request->km;
                    $lama_bearing = Lama_bearing::first();
                    $bearing = Bearing::where('kendaraan_id', $transaksi->id)->first();

                    // Memeriksa kategori dan memperbarui bearing yang sesuai
                    switch ($data_pesanan['kategori']) {
                        case 'Axle 1A':
                            $bearing->update([
                                'bearing1a' => $km_kendaraan + $lama_bearing->batas,
                                'status_bearing1a' => 'sudah penggantian',
                            ]);
                            break;

                        case 'Axle 1B':
                            $bearing->update([
                                'bearing1b' => $km_kendaraan + $lama_bearing->batas,
                                'status_bearing1b' => 'sudah penggantian',
                            ]);
                            break;

                        case 'Axle 2A':
                            $bearing->update([
                                'bearing2a' => $km_kendaraan + $lama_bearing->batas,
                                'status_bearing2a' => 'sudah penggantian',
                            ]);
                            break;

                        case 'Axle 2B':
                            $bearing->update([
                                'bearing2b' => $km_kendaraan + $lama_bearing->batas,
                                'status_bearing2b' => 'sudah penggantian',
                            ]);
                            break;

                        case 'Axle 3A':
                            $bearing->update([
                                'bearing3a' => $km_kendaraan + $lama_bearing->batas,
                                'status_bearing3a' => 'sudah penggantian',
                            ]);
                            break;

                        case 'Axle 3B':
                            $bearing->update([
                                'bearing3b' => $km_kendaraan + $lama_bearing->batas,
                                'status_bearing3b' => 'sudah penggantian',
                            ]);
                            break;

                        case 'Axle 4A':
                            $bearing->update([
                                'bearing4a' => $km_kendaraan + $lama_bearing->batas,
                                'status_bearing4a' => 'sudah penggantian',
                            ]);
                            break;

                        case 'Axle 4B':
                            $bearing->update([
                                'bearing4b' => $km_kendaraan + $lama_bearing->batas,
                                'status_bearing4b' => 'sudah penggantian',
                            ]);
                            break;

                        case 'Axle 5A':
                            $bearing->update([
                                'bearing5a' => $km_kendaraan + $lama_bearing->batas,
                                'status_bearing5a' => 'sudah penggantian',
                            ]);
                            break;

                        case 'Axle 5B':
                            $bearing->update([
                                'bearing5b' => $km_kendaraan + $lama_bearing->batas,
                                'status_bearing5b' => 'sudah penggantian',
                            ]);
                            break;

                        case 'Axle 6A':
                            $bearing->update([
                                'bearing6a' => $km_kendaraan + $lama_bearing->batas,
                                'status_bearing6a' => 'sudah penggantian',
                            ]);
                            break;

                        case 'Axle 6B':
                            $bearing->update([
                                'bearing6b' => $km_kendaraan + $lama_bearing->batas,
                                'status_bearing6b' => 'sudah penggantian',
                            ]);
                            break;

                        default:
                            // Jika kategori tidak dikenal
                            break;
                    }
                }
            }
        }





        $pemakaians = Penggantian_bearing::find($transaksi_id);

        $detailgrease = Detail_penggantianbearing::where('penggantian_bearing_id', $id)
            ->whereNull('kategori') // Mencari kategori yang null
            ->first();
        $detailgrease->update([
            'sparepart_id' => $request->sparepart_ids,
            'penggantian_bearing_id' => $transaksi->id,
            'kode_barang' => $request->kode_gris,
            'nama_barang' => $request->nama_gris,
            'jumlah' => $request->jumlah_gris,
            'kendaraan_id' => $request->kendaraan_id,
        ]);

        $sparepart = Sparepart::find($request->sparepart_ids);
        if ($sparepart) {
            $jumlah_sparepart = $sparepart->jumlah - $request->jumlah_gris;
            $sparepart->update(['jumlah' => $jumlah_sparepart]);
        }

        $parts = Detail_penggantianbearing::where('penggantian_bearing_id', $pemakaians->id)->get();

        return view('admin.inquery_penggantianbearing.show', compact('parts', 'pemakaians'));
    }

    public function unpostpenggantian($id)
    {
        $part = Penggantian_bearing::where('id', $id)->first(); {

            $detailpenggantianoli = Detail_penggantianbearing::where('penggantian_bearing_id', $id)->get();

            $kendaraan = Kendaraan::find($part->kendaraan_id);

            foreach ($detailpenggantianoli as $detail) {
                $sparepartId = $detail->sparepart_id;
                $sparepart = Sparepart::find($sparepartId);

                // Add the quantity back to the stock in the Sparepart record
                $newQuantity = $sparepart->jumlah + $detail->jumlah;
                $sparepart->update(['jumlah' => $newQuantity]);
            }

            $part->update([
                'status' => 'unpost'
            ]);

            return back()->with('success', 'Berhasil');
        }
    }

    public function postingpenggantian($id)
    {
        $part = Penggantian_bearing::where('id', $id)->first(); {

            $detailpenggantianoli = Detail_penggantianbearing::where('penggantian_bearing_id', $id)->get();

            $kendaraan = Kendaraan::find($part->kendaraan_id);

            foreach ($detailpenggantianoli as $detail) {
                $sparepartId = $detail->sparepart_id;
                $sparepart = Sparepart::find($sparepartId);

                // Add the quantity back to the stock in the Sparepart record
                $newQuantity = $sparepart->jumlah - $detail->jumlah;
                $sparepart->update(['jumlah' => $newQuantity]);
            }

            $part->update([
                'status' => 'posting'
            ]);
            return back()->with('success', 'Berhasil');
        }
    }

    public function delete($id)
    {
        $part = Penggantian_bearing::find($id);
        $detailpenggantianoli = Detail_penggantianoli::where('penggantian_bearing_id', $id)->get();
        $detailpenggantianpart = Detail_penggantianpart::where('penggantians_oli_id', $id)->get();

        $kendaraan = Kendaraan::find($part->kendaraan_id);


        // foreach ($detailpenggantianoli as $detail) {
        //     $sparepartId = $detail->sparepart_id;
        //     $sparepart = Sparepart::find($sparepartId);

        //     // Add the quantity back to the stock in the Sparepart record
        //     $newQuantity = $sparepart->jumlah + $detail->jumlah;
        //     $sparepart->update(['jumlah' => $newQuantity]);

        //     // Check the category and update the Kendaraan status
        //     if ($detail->kategori == 'Oli Mesin') {
        //         $kendaraan->update(['km_olimesin' => 0]);
        //         $kendaraan->update(['status_olimesin' => 'belum penggantian']);
        //     } elseif ($detail->kategori == 'Oli Transmisi') {
        //         $kendaraan->update(['km_olitransmisi' => 0]);
        //         $kendaraan->update(['status_olitransmisi' => 'belum penggantian']);
        //     } elseif ($detail->kategori == 'Oli Gardan') {
        //         $kendaraan->update(['km_oligardan' => 0]);
        //         $kendaraan->update(['status_oligardan' => 'belum penggantian']);
        //     }
        // }


        // foreach ($detailpenggantianpart as $detail) {
        //     $sparepartId = $detail->spareparts_id;
        //     $sparepart = Sparepart::find($sparepartId);

        //     // Add the quantity back to the stock in the Sparepart record
        //     $newQuantity = $sparepart->jumlah + $detail->jumlah2;
        //     $sparepart->update(['jumlah' => $newQuantity]);
        // }

        // Delete the related Detail_penggantianoli records
        $part->detail_oli()->delete();

        // Delete the Penggantian_bearing record
        $part->delete();

        return redirect('admin/inquery_penggantianbearing')->with('success', 'Berhasil menghapus Penggantian');
    }


    public function deleteoli($id)
    {
        $part = Detail_penggantianoli::find($id);
        $parts = Detail_penggantianoli::where('id', $id)->first();

        $penggantianbearing = Penggantian_bearing::where('id', $parts->penggantian_bearing_id)->first();
        $kendaraan = Kendaraan::find($penggantianbearing->kendaraan_id);
        if ($part) {
            $sparepart = Sparepart::find($part->sparepart_id);
            $part->delete();
        } else {
            return response()->json(['message' => 'Detail_pemasanganpart not found'], 404);
        }
    }

    public function hapuspenggantianoli($id)
    {
        $part = Penggantian_bearing::find($id);
        $detailpenggantianoli = Detail_penggantianoli::where('penggantian_bearing_id', $id)->get();
        $detailpenggantianpart = Detail_penggantianpart::where('penggantians_oli_id', $id)->get();

        $kendaraan = Kendaraan::find($part->kendaraan_id);


        // foreach ($detailpenggantianoli as $detail) {
        //     $sparepartId = $detail->sparepart_id;
        //     $sparepart = Sparepart::find($sparepartId);

        //     // Add the quantity back to the stock in the Sparepart record
        //     $newQuantity = $sparepart->jumlah + $detail->jumlah;
        //     $sparepart->update(['jumlah' => $newQuantity]);

        //     // Check the category and update the Kendaraan status
        //     if ($detail->kategori == 'Oli Mesin') {
        //         $kendaraan->update(['km_olimesin' => 0]);
        //         $kendaraan->update(['status_olimesin' => 'belum penggantian']);
        //     } elseif ($detail->kategori == 'Oli Transmisi') {
        //         $kendaraan->update(['km_olitransmisi' => 0]);
        //         $kendaraan->update(['status_olitransmisi' => 'belum penggantian']);
        //     } elseif ($detail->kategori == 'Oli Gardan') {
        //         $kendaraan->update(['km_oligardan' => 0]);
        //         $kendaraan->update(['status_oligardan' => 'belum penggantian']);
        //     }
        // }


        // foreach ($detailpenggantianpart as $detail) {
        //     $sparepartId = $detail->spareparts_id;
        //     $sparepart = Sparepart::find($sparepartId);

        //     // Add the quantity back to the stock in the Sparepart record
        //     $newQuantity = $sparepart->jumlah + $detail->jumlah2;
        //     $sparepart->update(['jumlah' => $newQuantity]);
        // }

        // Delete the related Detail_penggantianoli records
        $part->detail_oli()->delete();

        // Delete the Penggantian_bearing record
        $part->delete();

        return redirect('admin/inquery_penggantianbearing')->with('success', 'Berhasil menghapus Penggantian');
    }

    public function deletefilter($id)
    {
        $part = Detail_penggantianpart::find($id);

        if ($part) {
            $sparepart = Sparepart::find($part->spareparts_id);

            if ($sparepart) {
                // $sparepart->update(['jumlah' => $sparepart->jumlah + $part->jumlah2]);

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