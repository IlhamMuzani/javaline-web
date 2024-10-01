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
                ->with('data_pembelians', $data_pembelians);
        }

        $transaksi = Penggantian_bearing::findOrFail($id);

        $transaksi->update([
            'status' => 'posting',
        ]);

        $transaksi_id = $transaksi->id;

        $detailIds = $request->input('detail_ids');

        foreach ($data_pembelians as $data_pesanan) {
            $detailId = $data_pesanan['detail_id'];

            if ($detailId) {
                $detailToUpdate = Detail_penggantianbearing::find($detailId);
                $sparepart = Sparepart::find($data_pesanan['sparepart_id']);
                $jumlah_sparepart = $sparepart->jumlah - $data_pesanan['jumlah'];
                $lama_bearing = Lama_bearing::first();

                $sparepart->update(['jumlah' => $jumlah_sparepart]);
                $detailToUpdate->update([
                    'kendaraan_id' => $request->kendaraan_id,
                    'penggantian_bearing_id' => $transaksi->id,
                    'sparepart_id' => $data_pesanan['sparepart_id'],
                    'kategori' => $data_pesanan['kategori'],
                    'kode_barang' => $data_pesanan['kode_barang'],
                    'nama_barang' => $data_pesanan['nama_barang'],
                    'jumlah' => $data_pesanan['jumlah'],
                    'km_penggantian' => $kendaraan->km,
                    'km_berikutnya' => $kendaraan->km + $lama_bearing->batas,
                    'tanggal_awal' => Carbon::now('Asia/Jakarta'),
                ]);

                $km_kendaraan = $request->km;
                $lama_bearing = Lama_bearing::first();
                $bearing = Bearing::where('kendaraan_id', $transaksi->kendaraan_id)->first();

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
                    'kategori' => $data_pesanan['kategori'],
                ])->first();

                $sparepart = Sparepart::find($data_pesanan['sparepart_id']);
                if (!$existingDetail) {
                    $lama_bearing = Lama_bearing::first();
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
                        'km_penggantian' => $kendaraan->km,
                        'km_berikutnya' => $kendaraan->km + $lama_bearing->batas,
                        'tanggal_awal' => Carbon::now('Asia/Jakarta'),
                    ]);

                    $km_kendaraan = $request->km;
                    $lama_bearing = Lama_bearing::first();
                    $bearing = Bearing::where('kendaraan_id', $transaksi->kendaraan_id)->first();

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

        $penggantian = Penggantian_bearing::find($transaksi_id);

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


        $details = Detail_penggantianbearing::where('penggantian_bearing_id', $penggantian->id)
            ->whereNotNull('kategori') // Memastikan kategori tidak null
            ->get();
        $detailgrease = Detail_penggantianbearing::where('penggantian_bearing_id', $penggantian->id)
            ->whereNull('kategori') // Mencari kategori yang null
            ->first();


        return view('admin.penggantian_bearing.show', compact('detailgrease', 'details', 'penggantian'));
    }

    public function show($id)
    {

        $penggantian = Penggantian_bearing::where('id', $id)->first();
        $pemakaian = Penggantian_bearing::find($id);

        $details = Detail_penggantianbearing::where('penggantian_bearing_id', $id)
            ->whereNotNull('kategori') // Memastikan kategori tidak null
            ->get();
        $detailgrease = Detail_penggantianbearing::where('penggantian_bearing_id', $id)
            ->whereNull('kategori') // Mencari kategori yang null
            ->first();

        return view('admin.inquery_penggantianbearing.show', compact('details', 'detailgrease', 'penggantian'));
    }

    public function unpostpenggantian($id)
    {
        // Ambil data penggantian bearing berdasarkan ID
        $part = Penggantian_bearing::where('id', $id)->first();

        // Jika data part tidak ditemukan, kembalikan pesan error
        if (!$part) {
            return back()->with('error', 'Data penggantian bearing tidak ditemukan');
        }

        // Ambil semua detail penggantian bearing berdasarkan penggantian_bearing_id
        $detailpenggantianoli = Detail_penggantianbearing::where('penggantian_bearing_id', $id)->get();

        // Cari data kendaraan dan bearing terkait
        $kendaraan = Kendaraan::find($part->kendaraan_id);
        $bearing = Bearing::where('kendaraan_id', $part->kendaraan_id)->first();

        // Jika kendaraan atau bearing tidak ditemukan, kembalikan pesan error
        if (!$kendaraan || !$bearing) {
            return back()->with('error', 'Data kendaraan atau bearing tidak ditemukan');
        }

        // Lakukan perulangan untuk setiap detail penggantian oli
        foreach ($detailpenggantianoli as $detail) {
            // Ambil sparepart terkait
            $sparepartId = $detail->sparepart_id;
            $sparepart = Sparepart::find($sparepartId);

            // Cek apakah sparepart ditemukan
            if ($sparepart) {
                // Tambahkan jumlah sparepart yang digunakan kembali ke stok
                $newQuantity = $sparepart->jumlah + $detail->jumlah;
                $sparepart->update(['jumlah' => $newQuantity]);
            } else {
                // Jika sparepart tidak ditemukan, lanjutkan ke item berikutnya
                continue;
            }

            // Inisialisasi array untuk menampung perubahan pada bearing
            $newBearingData = [];

            // Update status bearing berdasarkan kategori
            switch ($detail->kategori) {
                case 'Axle 1A':
                    $newBearingData['bearing1a'] = null;
                    $newBearingData['status_bearing1a'] = 'belum penggantian';
                    break;
                case 'Axle 1B':
                    $newBearingData['bearing1b'] = null;
                    $newBearingData['status_bearing1b'] = 'belum penggantian';
                    break;
                case 'Axle 2A':
                    $newBearingData['bearing2a'] = null;
                    $newBearingData['status_bearing2a'] = 'belum penggantian';
                    break;
                case 'Axle 2B':
                    $newBearingData['bearing2b'] = null;
                    $newBearingData['status_bearing2b'] = 'belum penggantian';
                    break;
                case 'Axle 3A':
                    $newBearingData['bearing3a'] = null;
                    $newBearingData['status_bearing3a'] = 'belum penggantian';
                    break;
                case 'Axle 3B':
                    $newBearingData['bearing3b'] = null;
                    $newBearingData['status_bearing3b'] = 'belum penggantian';
                    break;
                case 'Axle 4A':
                    $newBearingData['bearing4a'] = null;
                    $newBearingData['status_bearing4a'] = 'belum penggantian';
                    break;
                case 'Axle 4B':
                    $newBearingData['bearing4b'] = null;
                    $newBearingData['status_bearing4b'] = 'belum penggantian';
                    break;
                case 'Axle 5A':
                    $newBearingData['bearing5a'] = null;
                    $newBearingData['status_bearing5a'] = 'belum penggantian';
                    break;
                case 'Axle 5B':
                    $newBearingData['bearing5b'] = null;
                    $newBearingData['status_bearing5b'] = 'belum penggantian';
                    break;
                case 'Axle 6A':
                    $newBearingData['bearing6a'] = null;
                    $newBearingData['status_bearing6a'] = 'belum penggantian';
                    break;
                case 'Axle 6B':
                    $newBearingData['bearing6b'] = null;
                    $newBearingData['status_bearing6b'] = 'belum penggantian';
                    break;
                default:
            }

            // Update data bearing jika ada perubahan
            if (!empty($newBearingData)) {
                $bearing->update($newBearingData);
            }
        }

        // Update status penggantian bearing menjadi 'unpost'
        $part->update([
            'status' => 'unpost'
        ]);

        // Kembalikan pesan sukses
        return back()->with('success', 'Berhasil');
    }


    public function postingpenggantian($id)
    {
        $part = Penggantian_bearing::where('id', $id)->first(); {

            $detailpenggantianoli = Detail_penggantianbearing::where('penggantian_bearing_id', $id)->get();

            $kendaraan = Kendaraan::find($part->kendaraan_id);
            $bearing = Bearing::where('kendaraan_id', $part->kendaraan_id)->first();

            // Jika kendaraan atau bearing tidak ditemukan, kembalikan pesan error
            if (!$kendaraan || !$bearing) {
                return back()->with('error', 'Data kendaraan atau bearing tidak ditemukan');
            }
            foreach ($detailpenggantianoli as $detail) {
                $sparepartId = $detail->sparepart_id;
                $sparepart = Sparepart::find($sparepartId);

                // Add the quantity back to the stock in the Sparepart record
                $newQuantity = $sparepart->jumlah - $detail->jumlah;
                $sparepart->update(['jumlah' => $newQuantity]);
                // Inisialisasi array untuk menampung perubahan pada bearing
                $newBearingData = [];

                // Update status bearing berdasarkan kategori
                switch ($detail->kategori) {
                    case 'Axle 1A':
                        $newBearingData['bearing1a'] = $detail->km_berikutnya;
                        $newBearingData['status_bearing1a'] = 'sudah penggantian';
                        break;
                    case 'Axle 1B':
                        $newBearingData['bearing1b'] = $detail->km_berikutnya;
                        $newBearingData['status_bearing1b'] = 'sudah penggantian';
                        break;
                    case 'Axle 2A':
                        $newBearingData['bearing2a'] = $detail->km_berikutnya;
                        $newBearingData['status_bearing2a'] = 'sudah penggantian';
                        break;
                    case 'Axle 2B':
                        $newBearingData['bearing2b'] = $detail->km_berikutnya;
                        $newBearingData['status_bearing2b'] = 'sudah penggantian';
                        break;
                    case 'Axle 3A':
                        $newBearingData['bearing3a'] = $detail->km_berikutnya;
                        $newBearingData['status_bearing3a'] = 'sudah penggantian';
                        break;
                    case 'Axle 3B':
                        $newBearingData['bearing3b'] = $detail->km_berikutnya;
                        $newBearingData['status_bearing3b'] = 'sudah penggantian';
                        break;
                    case 'Axle 4A':
                        $newBearingData['bearing4a'] = $detail->km_berikutnya;
                        $newBearingData['status_bearing4a'] = 'sudah penggantian';
                        break;
                    case 'Axle 4B':
                        $newBearingData['bearing4b'] = $detail->km_berikutnya;
                        $newBearingData['status_bearing4b'] = 'sudah penggantian';
                        break;
                    case 'Axle 5A':
                        $newBearingData['bearing5a'] = $detail->km_berikutnya;
                        $newBearingData['status_bearing5a'] = 'sudah penggantian';
                        break;
                    case 'Axle 5B':
                        $newBearingData['bearing5b'] = $detail->km_berikutnya;
                        $newBearingData['status_bearing5b'] = 'sudah penggantian';
                        break;
                    case 'Axle 6A':
                        $newBearingData['bearing6a'] = $detail->km_berikutnya;
                        $newBearingData['status_bearing6a'] = 'sudah penggantian';
                        break;
                    case 'Axle 6B':
                        $newBearingData['bearing6b'] = $detail->km_berikutnya;
                        $newBearingData['status_bearing6b'] = 'sudah penggantian';
                        break;
                    default:
                }

                // Update data bearing jika ada perubahan
                if (!empty($newBearingData)) {
                    $bearing->update($newBearingData);
                }
            }
            $part->update([
                'status' => 'posting'
            ]);
            return back()->with('success', 'Berhasil');
        }
    }


    public function deletedetailpenggantian($id)
    {
        $part = Detail_penggantianbearing::find($id);
        $part->delete();
    }

    public function hapuspenggantianbearing($id)
    {
        $part = Penggantian_bearing::find($id);
        // Delete the related Detail_penggantianoli records
        $part->detail_penggantianbearing()->delete();

        // Delete the Penggantian_bearing record
        $part->delete();

        return redirect('admin/inquery_penggantianbearing')->with('success', 'Berhasil menghapus Penggantian');
    }

}