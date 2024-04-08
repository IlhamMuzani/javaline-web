<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Kendaraan;
use App\Models\Sparepart;
use Illuminate\Http\Request;
use App\Models\Pemasangan_part;
use App\Http\Controllers\Controller;
use App\Models\Detail_pemasanganpart;
use App\Models\Detail_penggantianoli;
use App\Models\Detail_penggantianpart;
use App\Models\Pembelian_ban;
use App\Models\Penggantian_oli;
use Illuminate\Support\Facades\Validator;

class InqueryPenggantianoliController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->check() && auth()->user()->menu['inquery penggantian oli']) {

            Penggantian_oli::where([
                ['status', 'posting']
            ])->update([
                'status_notif' => true
            ]);

            $status = $request->status;
            $tanggal_awal = $request->tanggal_awal;
            $tanggal_akhir = $request->tanggal_akhir;

            $inquery = Penggantian_oli::query();

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

            return view('admin.inquery_penggantianoli.index', compact('inquery'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }
    public function edit($id)
    {
        if (auth()->check() && auth()->user()->menu['inquery penggantian oli']) {

            $penggantianoli = Penggantian_oli::where('id', $id)->first();
            $spareparts = Sparepart::where('kategori', 'oli')->get();

            $details = Detail_penggantianoli::where('penggantian_oli_id', $id)->get();
            $detailparts = Detail_penggantianpart::where('penggantians_oli_id', $id)->get();

            return view('admin.inquery_penggantianoli.update', compact('penggantianoli', 'spareparts', 'details', 'detailparts'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function update(Request $request, $id)
    {
        $validasi_pelanggan = Validator::make($request->all(), [
            'kendaraan_id' => 'required',
        ], [
            'kendaraan_id.required' => 'Pilih no kabin!',
        ]);

        $error_pelanggans = array();
        $error_pesanans = array();
        $data_pembelians = collect();
        $data_pembelians2 = collect();


        if ($validasi_pelanggan->fails()) {
            array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
        }


        if ($request->has('kategori')) {
            for ($i = 0; $i < count($request->kategori); $i++) {
                $validasi_produk = Validator::make($request->all(), [
                    'kategori.' . $i => 'required',
                    'sparepart_id.' . $i => 'required',
                    'nama_barang.' . $i => 'required',
                    'jumlah.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Pergantian Oli nomor " . $i + 1 . " belum dilengkapi!");
                }


                $kategori = is_null($request->kategori[$i]) ? '' : $request->kategori[$i];
                $sparepart_id = is_null($request->sparepart_id[$i]) ? '' : $request->sparepart_id[$i];
                $nama_barang = is_null($request->nama_barang[$i]) ? '' : $request->nama_barang[$i];
                $jumlah = is_null($request->jumlah[$i]) ? '' : $request->jumlah[$i];

                $data_pembelians->push(['detail_id' => $request->detail_ids[$i] ?? null, 'kategori' => $kategori, 'sparepart_id' => $sparepart_id, 'nama_barang' => $nama_barang, 'jumlah' => $jumlah]);
            }

            $transaksi = Penggantian_oli::findOrFail($id);
            $transaksi_id = $transaksi->id;
            $detailIds = $request->input('detail_ids');

            foreach ($data_pembelians as $data_pesanan) {
                $sparepartId = $data_pesanan['sparepart_id'];

                $existingDetail = Detail_penggantianoli::where([
                    'penggantian_oli_id' => $transaksi_id,
                    'sparepart_id' => $sparepartId,
                ])->first();

                if (!$existingDetail) {
                    // Handle oil replacement checks only for new 'sparepart_id'
                    $kendaraan = Kendaraan::where('id', $transaksi->kendaraan_id)->first();

                    $kategori_to_km = [
                        'Oli Mesin' => $kendaraan->km_olimesin,
                        'Oli Gardan' => $kendaraan->km_oligardan,
                        'Oli Transmisi' => $kendaraan->km_olitransmisi,
                    ];

                    foreach ($kategori_to_km as $kategori => $km_threshold) {
                        if (in_array($kategori, $request->kategori) && $kendaraan->km < $km_threshold) {
                            array_push($error_pesanans, "Penambahan penggantian oli tidak dapat dilakukan, belum waktunya penggantian");
                            $performValidation = false; // Disable further validation
                            break; // Exit the inner loop
                        }
                    }
                }
            }
        } else {
        }

        if ($request->has('kategori2') || $request->has('spareparts_id') || $request->has('nama_barang2') || $request->has('jumlah2')) {
            for ($i = 0; $i < count($request->kategori2); $i++) {
                // Check if either 'keterangan_tambahan' or 'nominal_tambahan' has input
                if (empty($request->kategori2[$i]) && empty($request->spareparts_id[$i]) && empty($request->nama_barang2[$i]) && empty($request->jumlah2[$i])) {
                    continue; // Skip validation if both are empty
                }

                $validasi_produk = Validator::make($request->all(), [
                    'kategori2.' . $i => 'required',
                    'spareparts_id.' . $i => 'required',
                    'nama_barang2.' . $i => 'required',
                    'jumlah2.*' => 'required|numeric|min:1',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Pergantian filter nomor " . ($i + 1) . " belum dilengkapi!");
                }

                $kategori2 = $request->kategori2[$i] ?? '';
                $spareparts_id = $request->spareparts_id[$i] ?? '';
                $nama_barang2 = $request->nama_barang2[$i] ?? '';
                $jumlah2 = $request->jumlah2[$i] ?? '';

                $data_pembelians2->push(['details_id' => $request->details_ids[$i] ?? null, 'kategori2' => $kategori2, 'spareparts_id' => $spareparts_id, 'nama_barang2' => $nama_barang2, 'jumlah2' => $jumlah2]);
            }
        } else {
        }

        // if ($request->has('kategori2')) {
        //     for ($i = 0; $i < count($request->kategori2); $i++) {
        //         $validasi_produk = Validator::make($request->all(), [
        //             'kategori2.' . $i => 'required',
        //             'spareparts_id.' . $i => 'required',
        //             'nama_barang2.' . $i => 'required',
        //             'jumlah2.' . $i => 'required',
        //         ]);

        //         if ($validasi_produk->fails()) {
        //             array_push($error_pesanans, "Pergantian Filter nomor " . $i + 1 . " belum dilengkapi!");
        //         }


        //         $kategori2 = is_null($request->kategori2[$i]) ? '' : $request->kategori2[$i];
        //         $spareparts_id = is_null($request->spareparts_id[$i]) ? '' : $request->spareparts_id[$i];
        //         $nama_barang2 = is_null($request->nama_barang2[$i]) ? '' : $request->nama_barang2[$i];
        //         $jumlah2 = is_null($request->jumlah2[$i]) ? '' : $request->jumlah2[$i];

        //         $data_pembelians2->push(['details_id' => $request->details_ids[$i] ?? null, 'kategori2' => $kategori2, 'spareparts_id' => $spareparts_id, 'nama_barang2' => $nama_barang2, 'jumlah2' => $jumlah2]);
        //     }
        // } else {
        // }

        if ($error_pelanggans || $error_pesanans) {
            return back()
                ->withInput()
                ->with('error_pelanggans', $error_pelanggans)
                ->with('error_pesanans', $error_pesanans)
                ->with('data_pembelians', $data_pembelians)
                ->with('data_pembelians2', $data_pembelians2);
        }

        $transaksi = Penggantian_oli::findOrFail($id);

        $transaksi->update([
            'status' => 'posting',
        ]);

        $transaksi_id = $transaksi->id;

        $detailIds = $request->input('detail_ids');

        foreach ($data_pembelians as $data_pesanan) {
            $detailId = $data_pesanan['detail_id'];

            if ($detailId) {
                // Mendapatkan data Detail_pembelianpart yang akan diupdate
                $detailToUpdate = Detail_penggantianoli::find($detailId);

                if ($detailToUpdate) {
                    // Menghitung jumlah baru berdasarkan perubahan
                    $jumlahLamaDetail = $detailToUpdate->jumlah;
                    $jumlahBaruDetail = $data_pesanan['jumlah'];

                    // Menghitung selisih antara stok lama dan stok baru
                    $selisihStok = $jumlahBaruDetail - $jumlahLamaDetail;

                    // Mendapatkan data Sparepart
                    $sparepart = Sparepart::find($detailToUpdate->sparepart_id);

                    if ($sparepart) {
                        // Menghitung jumlah baru untuk Sparepart
                        $jumlahLamaSparepart = $sparepart->jumlah;
                        $jumlahBaruSparepart = $data_pesanan['jumlah'];
                        $jumlahTotalSparepart = $jumlahLamaSparepart - $selisihStok;

                        // Update Detail_pembelianpart
                        $detailToUpdate->update([
                            'penggantian_oli_id' => $transaksi->id,
                            'kategori' => $data_pesanan['kategori'],
                            'sparepart_id' => $data_pesanan['sparepart_id'],
                            'jumlah' => $data_pesanan['jumlah'],
                        ]);

                        // Temukan semua Detail_pembelianpart dengan sparepart_id yang sama
                        $sparepart->update([
                            'jumlah' => $jumlahTotalSparepart,
                        ]);
                    }
                }
            } else {
                $existingDetail = Detail_penggantianoli::where([
                    'penggantian_oli_id' => $transaksi->id,
                    'sparepart_id' => $data_pesanan['sparepart_id'],
                ])->first();

                if (!$existingDetail) {

                    $penggantianoli = Penggantian_oli::where('id', $id)->first();
                    $kendaraan = Kendaraan::where('id', $penggantianoli->kendaraan_id)->first();
                    $km_olimesin = $kendaraan->km_olimesin; // Ambil nilai km_olimesin
                    $km_oligardan = $kendaraan->km_oligardan; // Ambil nilai km gardan
                    $km_olitransmisi = $kendaraan->km_olitransmisi; // Ambil nilai km transmisi
                    $kategori_to_km = [
                        'Oli Mesin' => $km_olimesin,
                        'Oli Gardan' => $km_oligardan,
                        'Oli Transmisi' => $km_olitransmisi,
                    ];
                    foreach ($kategori_to_km as $kategori => $km_threshold) {
                        if (in_array($kategori, $request->kategori) && $kendaraan->km < $km_threshold) {
                            array_push($error_pesanans, "Pergantian $kategori tidak dapat dilakukan, belum saatnya penggantian");
                        }
                    }


                    $penggantianoli = Penggantian_oli::where('id', $id)->first();
                    $kendaraan = Kendaraan::where('id', $penggantianoli->kendaraan_id)->first();
                    $km_berikutnya = $kendaraan->km; // Nilai default

                    if ($data_pesanan['kategori'] == 'Oli Mesin') {
                        $km_berikutnya += 13000;
                    } elseif ($data_pesanan['kategori'] == 'Oli Gardan') {
                        $km_berikutnya += 50000;
                    } elseif ($data_pesanan['kategori'] == 'Oli Transmisi') {
                        $km_berikutnya += 50000;
                    }
                    // Membuat Detail_pemasanganpart baru
                    Detail_penggantianoli::create([
                        'penggantian_oli_id' => $transaksi->id,
                        'tanggal_awal' => Carbon::now('Asia/Jakarta'),
                        'sparepart_id' => $data_pesanan['sparepart_id'],
                        'kategori' => $data_pesanan['kategori'],
                        'jumlah' => $data_pesanan['jumlah'],
                        'km_penggantian' => $kendaraan->km,
                        'km_berikutnya' => $km_berikutnya, // Menggunakan nilai yang telah diubah
                    ]);

                    $dataToUpdate = [
                        'km' => $kendaraan->km,
                        'km_olimesin' => $kendaraan->km_olimesin, // Tambahkan ini
                        'km_oligardan' => $kendaraan->km_oligardan, // Tambahkan ini
                        'km_olitransmisi' => $kendaraan->km_olitransmisi, // Tambahkan ini
                        'status_olimesin' => null,
                        'status_oligardan' => null,
                        'status_olitransmisi' => null,
                    ];

                    if ($data_pesanan['kategori'] == 'Oli Mesin') {
                        $dataToUpdate['km_olimesin'] = $km_berikutnya; // Update km_olimesin
                    } elseif ($data_pesanan['kategori'] == 'Oli Gardan') {
                        $dataToUpdate['km_oligardan'] = $km_berikutnya; // Update km_oligardan
                    } elseif ($data_pesanan['kategori'] == 'Oli Transmisi') {
                        $dataToUpdate['km_olitransmisi'] = $km_berikutnya; // Update km_olitransmisi
                    }

                    $kendaraan->update($dataToUpdate);

                    $penggantianoli = Penggantian_oli::where('id', $id)->first();
                    Kendaraan::where('id', $penggantianoli->kendaraan_id)->update($dataToUpdate);


                    $sparepart = Sparepart::find($data_pesanan['sparepart_id']);

                    if ($sparepart) {
                        // Mengurangkan jumlah yang ada di tabel Sparepart dengan jumlah yang diminta dalam request
                        $newQuantity = $sparepart->jumlah - $data_pesanan['jumlah'];

                        // Pastikan jumlah tidak kurang dari nol
                        $newQuantity = max(0, $newQuantity);

                        // Memperbarui jumlah yang ada di tabel Sparepart
                        $sparepart->update(['jumlah' => $newQuantity]);
                    }
                }
            }
        }

        $detailIdss = $request->input('details_ids');

        foreach ($data_pembelians2 as $data_pesanan) {
            $detailId = $data_pesanan['details_id'];

            if ($detailId) {
                // Mendapatkan data Detail_pembelianpart yang akan diupdate
                $detailToUpdate = Detail_penggantianpart::find($detailId);

                if ($detailToUpdate) {
                    // Menghitung jumlah baru berdasarkan perubahan
                    $jumlahLamaDetail = $detailToUpdate->jumlah2;
                    $jumlahBaruDetail = $data_pesanan['jumlah2'];

                    // Menghitung selisih antara stok lama dan stok baru
                    $selisihStok = $jumlahBaruDetail - $jumlahLamaDetail;

                    // Mendapatkan data Sparepart
                    $sparepart = Sparepart::find($detailToUpdate->spareparts_id);

                    if ($sparepart) {
                        // Menghitung jumlah baru untuk Sparepart
                        $jumlahLamaSparepart = $sparepart->jumlah;
                        $jumlahBaruSparepart = $data_pesanan['jumlah2'];
                        $jumlahTotalSparepart = $jumlahLamaSparepart - $selisihStok;

                        // Mengecek apakah stok cukup
                        // Update Detail_pembelianpart
                        $detailToUpdate->update([
                            'penggantians_oli_id' => $transaksi->id,
                            'kategori2' => $data_pesanan['kategori2'],
                            'spareparts_id' => $data_pesanan['spareparts_id'],
                            'jumlah2' => $data_pesanan['jumlah2'],
                        ]);

                        // Temukan semua Detail_pembelianpart dengan sparepart_id yang sama
                        $sparepart->update([
                            'jumlah' => $jumlahTotalSparepart,
                        ]);
                    }
                }
            } else {
                $existingDetail = Detail_penggantianpart::where([
                    'penggantians_oli_id' => $transaksi->id,
                    'spareparts_id' => $data_pesanan['spareparts_id'],
                ])->first();

                if (!$existingDetail) {
                    // Membuat Detail_pemasanganpart baru
                    Detail_penggantianpart::create([
                        'penggantians_oli_id' => $transaksi->id,
                        'tanggal_awal' => Carbon::now('Asia/Jakarta'),
                        'spareparts_id' => $data_pesanan['spareparts_id'],
                        'kategori2' => $data_pesanan['kategori2'],
                        'jumlah2' => $data_pesanan['jumlah2'],
                    ]);

                    // Mengambil informasi jumlah yang ada di tabel Sparepart
                    $sparepart = Sparepart::find($data_pesanan['spareparts_id']);

                    if ($sparepart) {
                        // Mengurangkan jumlah yang ada di tabel Sparepart dengan jumlah yang diminta dalam request
                        $newQuantity = $sparepart->jumlah - $data_pesanan['jumlah2'];

                        // Pastikan jumlah tidak kurang dari nol
                        $newQuantity = max(0, $newQuantity);

                        // Memperbarui jumlah yang ada di tabel Sparepart
                        $sparepart->update(['jumlah' => $newQuantity]);
                    }
                }
            }
        }


        $pemasangan_part = Penggantian_oli::find($transaksi_id);

        $parts = Detail_penggantianoli::where('penggantian_oli_id', $pemasangan_part->id)->get();
        $parts2 = Detail_penggantianpart::where('penggantians_oli_id', $pemasangan_part->id)->get();

        return view('admin.inquery_penggantianoli.show', compact('parts', 'parts2', 'pemasangan_part'));
    }

    public function unpostpenggantianoli($id)
    {
        $part = Penggantian_oli::where('id', $id)->first(); {

            // $detailpenggantianoli = Detail_penggantianoli::where('penggantian_oli_id', $id)->get();
            // $detailpenggantianpart = Detail_penggantianpart::where('penggantians_oli_id', $id)->get();

            // $kendaraan = Kendaraan::find($part->kendaraan_id);

            // foreach ($detailpenggantianoli as $detail) {
            //     $sparepartId = $detail->sparepart_id;
            //     $sparepart = Sparepart::find($sparepartId);

            //     // Add the quantity back to the stock in the Sparepart record
            //     $newQuantity = $sparepart->jumlah + $detail->jumlah;
            //     $sparepart->update(['jumlah' => $newQuantity]);
            // }

            // foreach ($detailpenggantianpart as $detail) {
            //     $sparepartId = $detail->spareparts_id;
            //     $sparepart = Sparepart::find($sparepartId);

            //     // Add the quantity back to the stock in the Sparepart record
            //     $newQuantity = $sparepart->jumlah + $detail->jumlah2;
            //     $sparepart->update(['jumlah' => $newQuantity]);
            // }

            $part->update([
                'status' => 'unpost'
            ]);

            return back()->with('success', 'Berhasil');
        }
    }

    public function postingpenggantianoli($id)
    {
        $part = Penggantian_oli::where('id', $id)->first();

        $part->update([
            'status' => 'posting'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function lihat_penggantianoli($id)
    {
        if (auth()->check() && auth()->user()->menu['inquery penggantian oli']) {

            $pemasangan_part = Penggantian_oli::findOrFail($id);

            $parts = Detail_penggantianoli::where('penggantian_oli_id', $id)->with('sparepart')->get();
            $parts2 = Detail_penggantianpart::where('penggantians_oli_id', $id)->with('spareparts')->get();

            return view('admin.inquery_penggantianoli.show', compact('parts', 'parts2', 'pemasangan_part'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }


    public function delete($id)
    {
        $part = Penggantian_oli::find($id);
        $detailpenggantianoli = Detail_penggantianoli::where('penggantian_oli_id', $id)->get();
        $detailpenggantianpart = Detail_penggantianpart::where('penggantians_oli_id', $id)->get();

        $kendaraan = Kendaraan::find($part->kendaraan_id);


        foreach ($detailpenggantianoli as $detail) {
            $sparepartId = $detail->sparepart_id;
            $sparepart = Sparepart::find($sparepartId);

            // Add the quantity back to the stock in the Sparepart record
            $newQuantity = $sparepart->jumlah + $detail->jumlah;
            $sparepart->update(['jumlah' => $newQuantity]);

            // Check the category and update the Kendaraan status
            if ($detail->kategori == 'Oli Mesin') {
                $kendaraan->update(['km_olimesin' => 0]);
                $kendaraan->update(['status_olimesin' => 'belum penggantian']);
            } elseif ($detail->kategori == 'Oli Transmisi') {
                $kendaraan->update(['km_olitransmisi' => 0]);
                $kendaraan->update(['status_olitransmisi' => 'belum penggantian']);
            } elseif ($detail->kategori == 'Oli Gardan') {
                $kendaraan->update(['km_oligardan' => 0]);
                $kendaraan->update(['status_oligardan' => 'belum penggantian']);
            }
        }


        foreach ($detailpenggantianpart as $detail) {
            $sparepartId = $detail->spareparts_id;
            $sparepart = Sparepart::find($sparepartId);

            // Add the quantity back to the stock in the Sparepart record
            $newQuantity = $sparepart->jumlah + $detail->jumlah2;
            $sparepart->update(['jumlah' => $newQuantity]);
        }

        // Delete the related Detail_penggantianoli records
        $part->detail_oli()->delete();

        // Delete the Penggantian_oli record
        $part->delete();

        return redirect('admin/inquery_penggantianoli')->with('success', 'Berhasil menghapus Penggantian');
    }


    public function deleteoli($id)
    {
        $part = Detail_penggantianoli::find($id);
        $parts = Detail_penggantianoli::where('id', $id)->first();

        $penggantianoli = Penggantian_oli::where('id', $parts->penggantian_oli_id)->first();
        $kendaraan = Kendaraan::find($penggantianoli->kendaraan_id);

        // Check the category and update the Kendaraan status
        if ($parts->kategori == 'Oli Mesin') {
            $kendaraan->update(['km_olimesin' => 0]);
            $kendaraan->update(['status_olimesin' => 'belum penggantian']);
        } elseif ($parts->kategori == 'Oli Transmisi') {
            $kendaraan->update(['km_olitransmisi' => 0]);
            $kendaraan->update(['status_olitransmisi' => 'belum penggantian']);
        } elseif ($parts->kategori == 'Oli Gardan') {
            $kendaraan->update(['km_oligardan' => 0]);
            $kendaraan->update(['status_oligardan' => 'belum penggantian']);
        }

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

    public function hapuspenggantianoli($id)
    {
        $part = Penggantian_oli::find($id);
        $detailpenggantianoli = Detail_penggantianoli::where('penggantian_oli_id', $id)->get();
        $detailpenggantianpart = Detail_penggantianpart::where('penggantians_oli_id', $id)->get();

        $kendaraan = Kendaraan::find($part->kendaraan_id);


        foreach ($detailpenggantianoli as $detail) {
            $sparepartId = $detail->sparepart_id;
            $sparepart = Sparepart::find($sparepartId);

            // Add the quantity back to the stock in the Sparepart record
            $newQuantity = $sparepart->jumlah + $detail->jumlah;
            $sparepart->update(['jumlah' => $newQuantity]);

            // Check the category and update the Kendaraan status
            if ($detail->kategori == 'Oli Mesin') {
                $kendaraan->update(['km_olimesin' => 0]);
                $kendaraan->update(['status_olimesin' => 'belum penggantian']);
            } elseif ($detail->kategori == 'Oli Transmisi') {
                $kendaraan->update(['km_olitransmisi' => 0]);
                $kendaraan->update(['status_olitransmisi' => 'belum penggantian']);
            } elseif ($detail->kategori == 'Oli Gardan') {
                $kendaraan->update(['km_oligardan' => 0]);
                $kendaraan->update(['status_oligardan' => 'belum penggantian']);
            }
        }


        foreach ($detailpenggantianpart as $detail) {
            $sparepartId = $detail->spareparts_id;
            $sparepart = Sparepart::find($sparepartId);

            // Add the quantity back to the stock in the Sparepart record
            $newQuantity = $sparepart->jumlah + $detail->jumlah2;
            $sparepart->update(['jumlah' => $newQuantity]);
        }

        // Delete the related Detail_penggantianoli records
        $part->detail_oli()->delete();

        // Delete the Penggantian_oli record
        $part->delete();

        return redirect('admin/inquery_penggantianoli')->with('success', 'Berhasil menghapus Penggantian');
    }

    public function deletefilter($id)
    {
        $part = Detail_penggantianpart::find($id);

        if ($part) {
            $sparepart = Sparepart::find($part->spareparts_id);

            if ($sparepart) {
                $sparepart->update(['jumlah' => $sparepart->jumlah + $part->jumlah2]);

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