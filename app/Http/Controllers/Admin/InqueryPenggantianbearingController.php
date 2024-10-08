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
            $spareparts = Sparepart::where('kategori', 'sasis')->get();

            $details = Detail_penggantianbearing::where('penggantian_bearing_id', $id)
                ->whereNotNull('kategori') // Memastikan kategori tidak null
                ->get();

            return view('admin.inquery_penggantianbearing.update', compact('inquery', 'spareparts', 'details'));
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
            'tromol1' => 'accepted',
            'tromol2' => 'accepted',
            'tromol3' => 'accepted',
            'tromol4' => 'accepted',
        ], [
            'kendaraan_id.required' => 'Pilih no kabin',
            'km.required' => 'Masukkan nilai km',
            'tromol1.accepted' => 'Centang tromol 1',
            'tromol2.accepted' => 'Centang tromol 2',
            'tromol3.accepted' => 'Centang tromol 3',
            'tromol4.accepted' => 'Centang tromol 4',
        ]);

        // Logika kondisional berdasarkan nilai request jumlah_ban
        if ($request->jumlah_ban == 6) {
            // Validasi untuk tromol 1-4 jika jumlah_ban adalah 6
            $validasi_pelanggan->after(function ($validator) {
                $validator->setCustomMessages([
                    'tromol1.accepted' => 'Centang tromol 1',
                    'tromol2.accepted' => 'Centang tromol 2',
                    'tromol3.accepted' => 'Centang tromol 3',
                    'tromol4.accepted' => 'Centang tromol 4',
                ]);
            });
        } elseif ($request->jumlah_ban == 10) {
            // Validasi untuk tromol 1-6 jika jumlah_ban adalah 10
            $validasi_pelanggan->after(function ($validator) {
                $validator->addRules([
                    'tromol5' => 'accepted',
                    'tromol6' => 'accepted',
                ]);

                $validator->setCustomMessages([
                    'tromol5.accepted' => 'Centang tromol 5',
                    'tromol6.accepted' => 'Centang tromol 6',
                ]);
            });
        } elseif ($request->jumlah_ban == 18) {
            // Validasi untuk tromol 1-10 jika jumlah_ban adalah 18
            $validasi_pelanggan->after(function ($validator) {
                $validator->addRules([
                    'tromol5' => 'accepted',
                    'tromol6' => 'accepted',
                    'tromol7' => 'accepted',
                    'tromol8' => 'accepted',
                    'tromol9' => 'accepted',
                    'tromol10' => 'accepted',
                ]);

                $validator->setCustomMessages([
                    'tromol5.accepted' => 'Centang tromol 5',
                    'tromol6.accepted' => 'Centang tromol 6',
                    'tromol7.accepted' => 'Centang tromol 7',
                    'tromol8.accepted' => 'Centang tromol 8',
                    'tromol9.accepted' => 'Centang tromol 9',
                    'tromol10.accepted' => 'Centang tromol 10',
                ]);
            });
        } elseif ($request->jumlah_ban == 22) {
            // Validasi untuk tromol 1-12 jika jumlah_ban adalah 22
            $validasi_pelanggan->after(function ($validator) {
                $validator->addRules([
                    'tromol5' => 'accepted',
                    'tromol6' => 'accepted',
                    'tromol7' => 'accepted',
                    'tromol8' => 'accepted',
                    'tromol9' => 'accepted',
                    'tromol10' => 'accepted',
                    'tromol11' => 'accepted',
                    'tromol12' => 'accepted',
                ]);

                $validator->setCustomMessages([
                    'tromol5.accepted' => 'Centang tromol 5',
                    'tromol6.accepted' => 'Centang tromol 6',
                    'tromol7.accepted' => 'Centang tromol 7',
                    'tromol8.accepted' => 'Centang tromol 8',
                    'tromol9.accepted' => 'Centang tromol 9',
                    'tromol10.accepted' => 'Centang tromol 10',
                    'tromol11.accepted' => 'Centang tromol 11',
                    'tromol12.accepted' => 'Centang tromol 12',
                ]);
            });
        }

        $error_pelanggans = array();
        $error_pesanans = array();
        $data_pembelians = collect();
        $data_pembelians2 = collect();


        if ($validasi_pelanggan->fails()) {
            array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
        }

        if ($request->has('sparepart_id') || $request->has('kategori') || $request->has('kode_barang') || $request->has('nama_barang') || $request->has('jumlah')) {
            for ($i = 0; $i < count($request->sparepart_id); $i++) {
                if (
                    empty($request->sparepart_id[$i]) && empty($request->kategori[$i]) && empty($request->kode_barang[$i]) && empty($request->nama_barang[$i]) && empty($request->jumlah[$i])
                ) {
                    continue;
                }

                $validasi_produk = Validator::make($request->all(), [
                    'sparepart_id.' . $i => 'required',
                    'kategori.' . $i => 'required',
                    'kode_barang.' . $i => 'required',
                    'nama_barang.' . $i => 'required',
                    'jumlah.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Penggantian Part Tromol Nomor " . ($i + 1) . " belum dilengkapi!");
                }

                $sparepart_id = $request->sparepart_id[$i] ?? '';
                $kategori = $request->kategori[$i] ?? '';
                $kode_barang = $request->kode_barang[$i] ?? '';
                $nama_barang = $request->nama_barang[$i] ?? '';
                $jumlah = $request->jumlah[$i] ?? '';

                $data_pembelians->push([
                    'detail_id' => $request->detail_ids[$i] ?? null,
                    'sparepart_id' => $sparepart_id,
                    'kategori' => $kategori,
                    'kode_barang' => $kode_barang,
                    'nama_barang' => $nama_barang,
                    'jumlah' => $jumlah,
                ]);
            }
            // return $data_pembelians;
        }

        if ($error_pelanggans || $error_pesanans) {
            return back()
                ->withInput()
                ->with('error_pelanggans', $error_pelanggans)
                ->with('error_pesanans', $error_pesanans)
                ->with('data_pembelians', $data_pembelians);
        }

        $transaksi = Penggantian_bearing::findOrFail($id);
        $km_kendaraan = $request->km;
        $lama_bearing = Lama_bearing::first();
        $transaksi->update([
            'status' => 'posting',
            'km_penggantian' => $km_kendaraan,
            'km_berikutnya' => $km_kendaraan + $lama_bearing->batas,
        ]);

        // Mengambil km kendaraan dan lama_bearing

        $bearing = Bearing::where('kendaraan_id', $transaksi->kendaraan_id)->first();
        if ($request->jumlah_ban == 6) {
            $bearing->update([
                'bearing1a' => $km_kendaraan + $lama_bearing->batas,
                'status_bearing1a' => 'sudah penggantian',

                'bearing1b' => $km_kendaraan + $lama_bearing->batas,
                'status_bearing1b' => 'sudah penggantian',

                'bearing2a' => $km_kendaraan + $lama_bearing->batas,
                'status_bearing2a' => 'sudah penggantian',

                'bearing2b' => $km_kendaraan + $lama_bearing->batas,
                'status_bearing2b' => 'sudah penggantian',
            ]);
        }
        if ($request->jumlah_ban == 10) {
            $bearing->update([
                'bearing1a' => $km_kendaraan + $lama_bearing->batas,
                'status_bearing1a' => 'sudah penggantian',

                'bearing1b' => $km_kendaraan + $lama_bearing->batas,
                'status_bearing1b' => 'sudah penggantian',

                'bearing2a' => $km_kendaraan + $lama_bearing->batas,
                'status_bearing2a' => 'sudah penggantian',

                'bearing2b' => $km_kendaraan + $lama_bearing->batas,
                'status_bearing2b' => 'sudah penggantian',

                'bearing3a' => $km_kendaraan + $lama_bearing->batas,
                'status_bearing3a' => 'sudah penggantian',

                'bearing3b' => $km_kendaraan + $lama_bearing->batas,
                'status_bearing3b' => 'sudah penggantian',
            ]);
        }
        if ($request->jumlah_ban == 18) {
            $bearing->update([
                'bearing1a' => $km_kendaraan + $lama_bearing->batas,
                'status_bearing1a' => 'sudah penggantian',

                'bearing1b' => $km_kendaraan + $lama_bearing->batas,
                'status_bearing1b' => 'sudah penggantian',

                'bearing2a' => $km_kendaraan + $lama_bearing->batas,
                'status_bearing2a' => 'sudah penggantian',

                'bearing2b' => $km_kendaraan + $lama_bearing->batas,
                'status_bearing2b' => 'sudah penggantian',

                'bearing3a' => $km_kendaraan + $lama_bearing->batas,
                'status_bearing3a' => 'sudah penggantian',

                'bearing3b' => $km_kendaraan + $lama_bearing->batas,
                'status_bearing3b' => 'sudah penggantian',

                'bearing4a' => $km_kendaraan + $lama_bearing->batas,
                'status_bearing4a' => 'sudah penggantian',

                'bearing4b' => $km_kendaraan + $lama_bearing->batas,
                'status_bearing4b' => 'sudah penggantian',

                'bearing5a' => $km_kendaraan + $lama_bearing->batas,
                'status_bearing5a' => 'sudah penggantian',

                'bearing5b' => $km_kendaraan + $lama_bearing->batas,
                'status_bearing5b' => 'sudah penggantian',
            ]);
        }
        if ($request->jumlah_ban == 22) {
            $bearing->update([
                'bearing1a' => $km_kendaraan + $lama_bearing->batas,
                'status_bearing1a' => 'sudah penggantian',

                'bearing1b' => $km_kendaraan + $lama_bearing->batas,
                'status_bearing1b' => 'sudah penggantian',

                'bearing2a' => $km_kendaraan + $lama_bearing->batas,
                'status_bearing2a' => 'sudah penggantian',

                'bearing2b' => $km_kendaraan + $lama_bearing->batas,
                'status_bearing2b' => 'sudah penggantian',

                'bearing3a' => $km_kendaraan + $lama_bearing->batas,
                'status_bearing3a' => 'sudah penggantian',

                'bearing3b' => $km_kendaraan + $lama_bearing->batas,
                'status_bearing3b' => 'sudah penggantian',

                'bearing4a' => $km_kendaraan + $lama_bearing->batas,
                'status_bearing4a' => 'sudah penggantian',

                'bearing4b' => $km_kendaraan + $lama_bearing->batas,
                'status_bearing4b' => 'sudah penggantian',

                'bearing5a' => $km_kendaraan + $lama_bearing->batas,
                'status_bearing5a' => 'sudah penggantian',

                'bearing5b' => $km_kendaraan + $lama_bearing->batas,
                'status_bearing5b' => 'sudah penggantian',

                'bearing6a' => $km_kendaraan + $lama_bearing->batas,
                'status_bearing6a' => 'sudah penggantian',

                'bearing6b' => $km_kendaraan + $lama_bearing->batas,
                'status_bearing6b' => 'sudah penggantian',

            ]);
        }


        $transaksi_id = $transaksi->id;

        $detailIds = $request->input('detail_ids');

        foreach ($data_pembelians as $data_pesanan) {
            $detailId = $data_pesanan['detail_id'];

            if ($detailId) {
                $detailToUpdate = Detail_penggantianbearing::find($detailId);
                $sparepart = Sparepart::find($data_pesanan['sparepart_id']);
                $lama_bearing = Lama_bearing::first();

                if ($sparepart) {
                    $jumlah_sparepart = $sparepart->jumlah - $data_pesanan['jumlah'];
                    $sparepart->update(['jumlah' => $jumlah_sparepart]);
                }

                $detail_pemakaians_data = [
                    'kendaraan_id' => $request->kendaraan_id,
                    'penggantian_bearing_id' => $transaksi->id,
                    'km_penggantian' => $kendaraan->km,
                    'km_berikutnya' => $kendaraan->km + $lama_bearing->batas,
                    'sparepart_id' => $data_pesanan['sparepart_id'],
                    'kategori' => $data_pesanan['kategori'],
                    'kode_barang' => $data_pesanan['kode_barang'],
                    'nama_barang' => $data_pesanan['nama_barang'],
                    'jumlah' => $data_pesanan['jumlah'],
                ];
                // Update detail_pemakaians
                $detailToUpdate->update($detail_pemakaians_data);
            } else {
                $existingDetail = Detail_penggantianbearing::where([
                    'penggantian_bearing_id' => $transaksi->id,
                    'kategori' => $data_pesanan['kategori'],
                    'sparepart_id' => $data_pesanan['sparepart_id'],
                ])->first();

                $sparepart = Sparepart::find($data_pesanan['sparepart_id']);
                if (!$existingDetail) {
                    if ($sparepart) {
                        $jumlah_sparepart = $sparepart->jumlah - $data_pesanan['jumlah'];
                        $sparepart->update(['jumlah' => $jumlah_sparepart]);
                    }
                    $lama_bearing = Lama_bearing::first();
                    $detail_pemakaians_data = [
                        'kendaraan_id' => $request->kendaraan_id,
                        'penggantian_bearing_id' => $transaksi->id,
                        'km_penggantian' => $kendaraan->km,
                        'km_berikutnya' => $kendaraan->km + $lama_bearing->batas,
                        'sparepart_id' => $data_pesanan['sparepart_id'],
                        'kategori' => $data_pesanan['kategori'],
                        'kode_barang' => $data_pesanan['kode_barang'],
                        'nama_barang' => $data_pesanan['nama_barang'],
                        'jumlah' => $data_pesanan['jumlah'],
                        'tanggal_awal' => Carbon::now('Asia/Jakarta'),
                    ];
                    // Membuat detail_pemakaians
                    $detail_pemakaians = Detail_penggantianbearing::create($detail_pemakaians_data);
                }
            }
        }

        $penggantian = Penggantian_bearing::find($transaksi_id);

        $details = Detail_penggantianbearing::where('penggantian_bearing_id', $penggantian->id)
            ->whereNotNull('kategori') // Memastikan kategori tidak null
            ->get();

        return view('admin.inquery_penggantianbearing.show', compact('details', 'penggantian'));
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

            // Cek apakah sparepart ditemukan dan kurangi jumlah stok
            if ($sparepart) {
                // Kurangi stok sparepart berdasarkan jumlah
                $newQuantity = $sparepart->jumlah + $detail->jumlah;
                $sparepart->update(['jumlah' => $newQuantity]);
            }

            if ($kendaraan->jenis_kendaraan->total_ban == 6) {
                $bearing->update([
                    'bearing1a' => null,
                    'status_bearing1a' => 'belum penggantian',

                    'bearing1b' => null,
                    'status_bearing1b' => 'belum penggantian',

                    'bearing2a' => null,
                    'status_bearing2a' => 'belum penggantian',

                    'bearing2b' => null,
                    'status_bearing2b' => 'belum penggantian',
                ]);
            }

            if ($kendaraan->jenis_kendaraan->total_ban == 10) {
                $bearing->update([
                    'bearing1a' => null,
                    'status_bearing1a' => 'belum penggantian',

                    'bearing1b' => null,
                    'status_bearing1b' => 'belum penggantian',

                    'bearing2a' => null,
                    'status_bearing2a' => 'belum penggantian',

                    'bearing2b' => null,
                    'status_bearing2b' => 'belum penggantian',

                    'bearing3a' => null,
                    'status_bearing3a' => 'belum penggantian',

                    'bearing3b' => null,
                    'status_bearing3b' => 'belum penggantian',
                ]);
            }
            if ($kendaraan->jenis_kendaraan->total_ban == 18) {
                $bearing->update([
                    'bearing1a' => null,
                    'status_bearing1a' => 'belum penggantian',

                    'bearing1b' => null,
                    'status_bearing1b' => 'belum penggantian',

                    'bearing2a' => null,
                    'status_bearing2a' => 'belum penggantian',

                    'bearing2b' => null,
                    'status_bearing2b' => 'belum penggantian',

                    'bearing3a' => null,
                    'status_bearing3a' => 'belum penggantian',

                    'bearing3b' => null,
                    'status_bearing3b' => 'belum penggantian',

                    'bearing4a' => null,
                    'status_bearing4a' => 'belum penggantian',

                    'bearing4b' => null,
                    'status_bearing4b' => 'belum penggantian',

                    'bearing5a' => null,
                    'status_bearing5a' => 'belum penggantian',

                    'bearing5b' => null,
                    'status_bearing5b' => 'belum penggantian',
                ]);
            }

            if ($kendaraan->jenis_kendaraan->total_ban == 22) {
                $bearing->update([
                    'bearing1a' => null,
                    'status_bearing1a' => 'belum penggantian',

                    'bearing1b' => null,
                    'status_bearing1b' => 'belum penggantian',

                    'bearing2a' => null,
                    'status_bearing2a' => 'belum penggantian',

                    'bearing2b' => null,
                    'status_bearing2b' => 'belum penggantian',

                    'bearing3a' => null,
                    'status_bearing3a' => 'belum penggantian',

                    'bearing3b' => null,
                    'status_bearing3b' => 'belum penggantian',

                    'bearing4a' => null,
                    'status_bearing4a' => 'belum penggantian',

                    'bearing4b' => null,
                    'status_bearing4b' => 'belum penggantian',

                    'bearing5a' => null,
                    'status_bearing5a' => 'belum penggantian',

                    'bearing5b' => null,
                    'status_bearing5b' => 'belum penggantian',

                    'bearing6a' => null,
                    'status_bearing6a' => 'belum penggantian',

                    'bearing6b' => null,
                    'status_bearing6b' => 'belum penggantian',

                ]);
            }
        }

        $part->update([
            'status' => 'unpost'
        ]);

        // Kembalikan pesan sukses
        return back()->with('success', 'Berhasil');
    }


    public function postingpenggantian($id)
    {
        $part = Penggantian_bearing::where('id', $id)->first();

        $detailpenggantianoli = Detail_penggantianbearing::where('penggantian_bearing_id', $id)->get();

        $kendaraan = Kendaraan::find($part->kendaraan_id);
        $bearing = Bearing::where('kendaraan_id', $part->kendaraan_id)->first();

        // Jika kendaraan atau bearing tidak ditemukan, kembalikan pesan error
        if (!$kendaraan || !$bearing) {
            return back()->with('error', 'Data kendaraan atau bearing tidak ditemukan');
        }

        foreach ($detailpenggantianoli as $detail) {
            // Lewati jika sparepart_id kosong
            $sparepartId = $detail->sparepart_id;
            $sparepart = Sparepart::find($sparepartId);

            // Cek apakah sparepart ditemukan dan kurangi jumlah stok
            if ($sparepart) {
                // Kurangi stok sparepart berdasarkan jumlah
                $newQuantity = $sparepart->jumlah - $detail->jumlah;
                $sparepart->update(['jumlah' => $newQuantity]);
            }

            if (
                $kendaraan->jenis_kendaraan->total_ban == 6
            ) {
                $bearing->update([
                    'bearing1a' => $detail->km_berikutnya,
                    'status_bearing1a' => 'sudah penggantian',

                    'bearing1b' => $detail->km_berikutnya,
                    'status_bearing1b' => 'sudah penggantian',

                    'bearing2a' => $detail->km_berikutnya,
                    'status_bearing2a' => 'sudah penggantian',

                    'bearing2b' => $detail->km_berikutnya,
                    'status_bearing2b' => 'sudah penggantian',
                ]);
            }

            if ($kendaraan->jenis_kendaraan->total_ban == 10) {
                $bearing->update([
                    'bearing1a' => $detail->km_berikutnya,
                    'status_bearing1a' => 'sudah penggantian',

                    'bearing1b' => $detail->km_berikutnya,
                    'status_bearing1b' => 'sudah penggantian',

                    'bearing2a' => $detail->km_berikutnya,
                    'status_bearing2a' => 'sudah penggantian',

                    'bearing2b' => $detail->km_berikutnya,
                    'status_bearing2b' => 'sudah penggantian',

                    'bearing3a' => $detail->km_berikutnya,
                    'status_bearing3a' => 'sudah penggantian',

                    'bearing3b' => $detail->km_berikutnya,
                    'status_bearing3b' => 'sudah penggantian',
                ]);
            }
            if (
                $kendaraan->jenis_kendaraan->total_ban == 18
            ) {
                $bearing->update([
                    'bearing1a' => $detail->km_berikutnya,
                    'status_bearing1a' => 'sudah penggantian',

                    'bearing1b' => $detail->km_berikutnya,
                    'status_bearing1b' => 'sudah penggantian',

                    'bearing2a' => $detail->km_berikutnya,
                    'status_bearing2a' => 'sudah penggantian',

                    'bearing2b' => $detail->km_berikutnya,
                    'status_bearing2b' => 'sudah penggantian',

                    'bearing3a' => $detail->km_berikutnya,
                    'status_bearing3a' => 'sudah penggantian',

                    'bearing3b' => $detail->km_berikutnya,
                    'status_bearing3b' => 'sudah penggantian',

                    'bearing4a' => $detail->km_berikutnya,
                    'status_bearing4a' => 'sudah penggantian',

                    'bearing4b' => $detail->km_berikutnya,
                    'status_bearing4b' => 'sudah penggantian',

                    'bearing5a' => $detail->km_berikutnya,
                    'status_bearing5a' => 'sudah penggantian',

                    'bearing5b' => $detail->km_berikutnya,
                    'status_bearing5b' => 'sudah penggantian',
                ]);
            }

            if (
                $kendaraan->jenis_kendaraan->total_ban == 22
            ) {
                $bearing->update([
                    'bearing1a' => $detail->km_berikutnya,
                    'status_bearing1a' => 'sudah penggantian',

                    'bearing1b' => $detail->km_berikutnya,
                    'status_bearing1b' => 'sudah penggantian',

                    'bearing2a' => $detail->km_berikutnya,
                    'status_bearing2a' => 'sudah penggantian',

                    'bearing2b' => $detail->km_berikutnya,
                    'status_bearing2b' => 'sudah penggantian',

                    'bearing3a' => $detail->km_berikutnya,
                    'status_bearing3a' => 'sudah penggantian',

                    'bearing3b' => $detail->km_berikutnya,
                    'status_bearing3b' => 'sudah penggantian',

                    'bearing4a' => $detail->km_berikutnya,
                    'status_bearing4a' => 'sudah penggantian',

                    'bearing4b' => $detail->km_berikutnya,
                    'status_bearing4b' => 'sudah penggantian',

                    'bearing5a' => $detail->km_berikutnya,
                    'status_bearing5a' => 'sudah penggantian',

                    'bearing5b' => $detail->km_berikutnya,
                    'status_bearing5b' => 'sudah penggantian',

                    'bearing6a' => $detail->km_berikutnya,
                    'status_bearing6a' => 'sudah penggantian',

                    'bearing6b' => $detail->km_berikutnya,
                    'status_bearing6b' => 'sudah penggantian',

                ]);
            }
        }

        // Update status penggantian bearing
        $part->update(['status' => 'posting']);

        return back()->with('success', 'Berhasil');
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