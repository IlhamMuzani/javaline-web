<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Kendaraan;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Sparepart;
use Illuminate\Http\Request;
use App\Models\Jenis_kendaraan;
use App\Models\Penggantian_oli;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Detail_penggantianoli;
use App\Models\Detail_penggantianpart;
use Illuminate\Support\Facades\Validator;

class PenggantianOliController extends Controller
{
    public function index()
    {
        if (auth()->check() && auth()->user()->menu['penggantian oli']) {

            Kendaraan::where([
                ['status_olimesin', 'belum penggantian'],
                ['status_oligardan', 'belum penggantian'],
                ['status_olitransmisi', 'belum penggantian'],
            ])->update([
                'status_notifkm' => true
            ]);

            $kendaraans = Kendaraan::where(function ($query) {
                $query->where('status_olimesin', 'konfirmasi')
                    ->orWhere('status_oligardan', 'konfirmasi')
                    ->orWhere('status_olitransmisi', 'konfirmasi')
                    ->orWhere('status_olimesin', 'belum penggantian')
                    ->orWhere('status_oligardan', 'belum penggantian')
                    ->orWhere('status_olitransmisi', 'belum penggantian');
            })->orderByRaw("CASE
    WHEN status_olimesin = 'konfirmasi' THEN 1
    WHEN status_oligardan = 'konfirmasi' THEN 1
    WHEN status_olitransmisi = 'konfirmasi' THEN 1
    ELSE 2
END")->get();


            return view('admin.penggantian_oli.index', compact('kendaraans'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function kendaraan($id)
    {
        $stnk = Kendaraan::where('id', $id)->first();

        return json_decode($stnk);
    }

    public function edit($id)
    {
        if (auth()->check() && auth()->user()->menu['penggantian oli']) {

            $kendaraans = Kendaraan::where('id', $id)->first();
            $jenis_kendaraans = Jenis_kendaraan::all();
            $spareparts = Sparepart::where('kategori', 'oli')->get();
            return view('admin.penggantian_oli.update', compact('jenis_kendaraans', 'kendaraans', 'spareparts'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    // public function update(Request $request, $id)
    // {
    //     $kendaraan = Kendaraan::where('id', $id)->first();
    //     $validasi_pelanggan = Validator::make(
    //         $request->all(),
    //         [
    //             'km' => [
    //                 'required',
    //                 'numeric',
    //                 function ($attribute, $value, $fail) use ($kendaraan) {
    //                     if ($value <= $kendaraan->km) {
    //                         $fail('Nilai km akhir harus lebih tinggi dari km awal');
    //                     }
    //                 },
    //             ],
    //         ],
    //         [
    //             'km.required' => 'Masukkan nilai km',
    //         ]
    //     );

    //     $error_pelanggans = array();

    //     if ($validasi_pelanggan->fails()) {
    //         array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
    //     }

    //     $error_pesanans = array();
    //     $data_pembelians = collect();
    //     $data_pembelians2 = collect();

    //     if ($request->has('kategori')) {
    //         for ($i = 0; $i < count($request->kategori); $i++) {
    //             $validasi_produk = Validator::make($request->all(), [
    //                 'kategori.' . $i => 'required',
    //                 'sparepart_id.' . $i => 'required',
    //                 'nama_barang.' . $i => 'required',
    //                 'jumlah.*' => 'required|numeric|min:1',
    //             ]);

    //             if ($validasi_produk->fails()) {
    //                 array_push($error_pesanans, "Pergantian Oli nomor " . $i + 1 . " belum dilengkapi!");
    //             }


    //             $kategori = is_null($request->kategori[$i]) ? '' : $request->kategori[$i];
    //             $sparepart_id = is_null($request->sparepart_id[$i]) ? '' : $request->sparepart_id[$i];
    //             $nama_barang = is_null($request->nama_barang[$i]) ? '' : $request->nama_barang[$i];
    //             $jumlah = is_null($request->jumlah[$i]) ? '' : $request->jumlah[$i];

    //             $data_pembelians->push(['kategori' => $kategori, 'sparepart_id' => $sparepart_id, 'nama_barang' => $nama_barang, 'jumlah' => $jumlah]);
    //         }

    //         if (!$error_pelanggans && !$error_pesanans) {
    //             foreach ($request->sparepart_id as $index => $sparepartId) {
    //                 $jumlahDiminta = $request->jumlah[$index];
    //                 $sparepart = Sparepart::find($sparepartId);

    //                 if ($sparepart && $jumlahDiminta > $sparepart->jumlah) {
    //                     array_push($error_pesanans, "Stok Oli nomor " . ($index + 1) . " tidak mencukupi!");
    //                 }
    //             }
    //         }
    //     } else {
    //     }

    //     if ($request->has('kategori2')) {
    //         for ($i = 0; $i < count($request->kategori2); $i++) {
    //             $validasi_produk = Validator::make($request->all(), [
    //                 'kategori2.' . $i => 'required',
    //                 'spareparts_id.' . $i => 'required',
    //                 'nama_barang2.' . $i => 'required',
    //                 'jumlah2.*' => 'required|numeric|min:1',
    //             ]);

    //             if ($validasi_produk->fails()) {
    //                 array_push($error_pesanans, "Pergantian Filter Nomor " . $i + 1 . " belum dilengkapi!");
    //             }

    //             $kategori2 = is_null($request->kategori2[$i]) ? '' : $request->kategori2[$i];
    //             $spareparts_id = is_null($request->spareparts_id[$i]) ? '' : $request->spareparts_id[$i];
    //             $nama_barang2 = is_null($request->nama_barang2[$i]) ? '' : $request->nama_barang2[$i];
    //             $jumlah2 = is_null($request->jumlah2[$i]) ? '' : $request->jumlah2[$i];

    //             $data_pembelians2->push(['kategori2' => $kategori2, 'spareparts_id' => $spareparts_id, 'nama_barang2' => $nama_barang2, 'jumlah2' => $jumlah2]);
    //         }

    //         if (!$error_pelanggans && !$error_pesanans) {
    //             foreach ($request->spareparts_id as $index => $sparepartId) {
    //                 $jumlahDiminta = $request->jumlah2[$index];
    //                 $sparepart = Sparepart::find($sparepartId);

    //                 if ($sparepart && $jumlahDiminta > $sparepart->jumlah) {
    //                     array_push($error_pesanans, "Stok Filter nomor " . ($index + 1) . " tidak mencukupi!");
    //                 }
    //             }
    //         }
    //     } else {
    //     }

    //     if ($error_pelanggans || $error_pesanans) {
    //         return back()
    //             ->withInput()
    //             ->with('error_pelanggans', $error_pelanggans)
    //             ->with('error_pesanans', $error_pesanans)
    //             ->with('data_pembelians', $data_pembelians)
    //             ->with('data_pembelians2', $data_pembelians2);
    //     }

    //     // format tanggal indo
    //     $tanggal1 = Carbon::now('Asia/Jakarta');
    //     $format_tanggal = $tanggal1->format('d F Y');

    //     $tanggal = Carbon::now()->format('Y-m-d');
    //     $transaksi = Penggantian_oli::create([
    //         'kode_penggantianoli' => $this->kode(),
    //         'kendaraan_id' => $request->kendaraan_id,
    //         'tanggal_penggantian' => $format_tanggal,
    //         'tanggal_awal' => $tanggal,
    //         'status' => 'posting',
    //         'status_notif' => false,
    //     ]);

    //     $transaksi_id = $transaksi->id;

    //     if ($transaksi) {
    //         foreach ($data_pembelians as $data_pesanan) {
    //             $sparepart = Sparepart::find($data_pesanan['sparepart_id']);
    //             if ($sparepart) {
    //                 // Mengurangkan jumlah sparepart yang dipilih dengan jumlah yang dikirim dalam request
    //                 $jumlah_sparepart = $sparepart->jumlah - $data_pesanan['jumlah'];

    //                 // Pastikan jumlah sparepart tidak kurang dari nol
    //                 $jumlah_sparepart = max(0, $jumlah_sparepart);

    //                 // Memperbarui jumlah sparepart
    //                 $sparepart->update(['jumlah' => $jumlah_sparepart]);

    //                 // Membuat Detail_pemasanganpart
    //                 $km_berikutnya = $request->km; // Nilai default

    //                 if ($data_pesanan['kategori'] == 'Oli Mesin') {
    //                     $km_berikutnya += 10000;
    //                 } elseif ($data_pesanan['kategori'] == 'Oli Gardan') {
    //                     $km_berikutnya += 50000;
    //                 } elseif ($data_pesanan['kategori'] == 'Oli Transmisi') {
    //                     $km_berikutnya += 50000;
    //                 }

    //                 Detail_penggantianoli::create([
    //                     'penggantian_oli_id' => $transaksi->id,
    //                     'kategori' => $data_pesanan['kategori'],
    //                     'sparepart_id' => $data_pesanan['sparepart_id'],
    //                     'tanggal_awal' => Carbon::now('Asia/Jakarta'),
    //                     'jumlah' => $data_pesanan['jumlah'],
    //                     'km_penggantian' => $request->km,
    //                     'km_berikutnya' => $km_berikutnya, // Menggunakan nilai yang telah diubah
    //                 ]);
    //             }
    //         }
    //     }

    //     if ($transaksi) {
    //         foreach ($data_pembelians2 as $data_pesanan) {
    //             $sparepart = Sparepart::find($data_pesanan['spareparts_id']);
    //             if ($sparepart) {
    //                 // Mengurangkan jumlah sparepart yang dipilih dengan jumlah yang dikirim dalam request
    //                 $jumlah_sparepart = $sparepart->jumlah - $data_pesanan['jumlah2'];

    //                 // Pastikan jumlah sparepart tidak kurang dari nol
    //                 $jumlah_sparepart = max(0, $jumlah_sparepart);

    //                 // Memperbarui jumlah sparepart
    //                 $sparepart->update(['jumlah' => $jumlah_sparepart]);

    //                 Detail_penggantianpart::create([
    //                     'penggantians_oli_id' => $transaksi->id,
    //                     'kategori2' => $data_pesanan['kategori2'],
    //                     'spareparts_id' => $data_pesanan['spareparts_id'],
    //                     'tanggal_awal' => Carbon::now('Asia/Jakarta'),
    //                     'jumlah2' => $data_pesanan['jumlah2'],
    //                     'km_penggantian' => $request->km,
    //                 ]);
    //             }
    //         }
    //     }

    //     $dataToUpdate = [
    //         'km' => $request->km,
    //         'km_olimesin' => null,
    //         'km_oligardan' => null,
    //         'km_olitransmisi' => null,
    //         'status_olimesin' => null,
    //         'status_oligardan' => null,
    //         'status_olitransmisi' => null,
    //     ];

    //     if ($request->has('kategori')) {
    //         if (in_array('Oli Mesin', $request->kategori)) {
    //             $dataToUpdate['km_olimesin'] = $request->km + 10000;
    //             $dataToUpdate['status_olimesin'] = 'konfirmasi';
    //         }

    //         if (in_array('Oli Gardan', $request->kategori)) {
    //             $dataToUpdate['km_oligardan'] = $request->km + 50000;
    //             $dataToUpdate['status_oligardan'] = 'konfirmasi';
    //         }

    //         if (in_array('Oli Transmisi', $request->kategori)) {
    //             $dataToUpdate['km_olitransmisi'] = $request->km + 50000;
    //             $dataToUpdate['status_olitransmisi'] = 'konfirmasi';
    //         }
    //     }

    //     // Periksa dan biarkan nilai-nilai yang tidak ada dalam request tetap sama seperti sebelumnya
    //     $dataToUpdate['km_olimesin'] = $dataToUpdate['km_olimesin'] ?? $kendaraan->km_olimesin;
    //     $dataToUpdate['km_oligardan'] = $dataToUpdate['km_oligardan'] ?? $kendaraan->km_oligardan;
    //     $dataToUpdate['km_olitransmisi'] = $dataToUpdate['km_olitransmisi'] ?? $kendaraan->km_olitransmisi;
    //     $dataToUpdate['status_olimesin'] = $dataToUpdate['status_olimesin'] ?? $kendaraan->status_olimesin;
    //     $dataToUpdate['status_oligardan'] = $dataToUpdate['status_oligardan'] ?? $kendaraan->status_oligardan;
    //     $dataToUpdate['status_olitransmisi'] = $dataToUpdate['status_olitransmisi'] ?? $kendaraan->status_olitransmisi;

    //     // Update data kendaraan
    //     $kendaraan->update($dataToUpdate);

    //     Kendaraan::where('id', $id)->update($dataToUpdate);

    //     $pembelians = Penggantian_oli::find($transaksi_id);

    //     // $kendaraan = Kendaraan::where('id', $pembelians->id)->first();
    //     $parts = Detail_penggantianoli::where('penggantian_oli_id', $pembelians->id)->get();
    //     $parts2 = Detail_penggantianpart::where('penggantians_oli_id', $pembelians->id)->get();

    //     return view('admin.penggantian_oli.show', compact('parts', 'parts2', 'pembelians'));
    // }

    public function update(Request $request, $id)
    {
        $kendaraan = Kendaraan::where('id', $id)->first();

        $validasi_pelanggan = Validator::make(
            $request->all(),
            [
                'km' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($kendaraan) {
                        if ($value <= $kendaraan->km) {
                            $fail('Nilai km akhir harus lebih tinggi dari km awal');
                        }
                    },
                ],
            ],
            [
                'km.required' => 'Masukkan nilai km',
            ]
        );

        $error_pelanggans = array();

        if ($validasi_pelanggan->fails()) {
            array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
        }

        $error_pesanans = array();
        $data_pembelians = collect();
        $data_pembelians2 = collect();

        if ($request->has('kategori')) {
            for ($i = 0; $i < count($request->kategori); $i++) {
                $validasi_produk = Validator::make($request->all(), [
                    'kategori.' . $i => 'required',
                    'sparepart_id.' . $i => 'required',
                    'nama_barang.' . $i => 'required',
                    'jumlah.' . $i => 'required|numeric|min:1', // 'jumlah.*' should be 'jumlah.' . $i
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Pergantian Oli nomor " . ($i + 1) . " belum dilengkapi!"); // Corrected the syntax for concatenation and indexing
                }

                $kategori = is_null($request->kategori[$i]) ? '' : $request->kategori[$i];
                $sparepart_id = is_null($request->sparepart_id[$i]) ? '' : $request->sparepart_id[$i];
                $nama_barang = is_null($request->nama_barang[$i]) ? '' : $request->nama_barang[$i];
                $jumlah = is_null($request->jumlah[$i]) ? '' : $request->jumlah[$i];

                $data_pembelians->push(['kategori' => $kategori, 'sparepart_id' => $sparepart_id, 'nama_barang' => $nama_barang, 'jumlah' => $jumlah]);
            }

            // Check for specific conditions based on category
            // $kategori_to_km = [
            //     'Oli Mesin' => $kendaraan->km_olimesin,
            //     'Oli Gardan' => $kendaraan->km_oligardan,
            //     'Oli Transmisi' => $kendaraan->km_olitransmisi,
            // ];

            // foreach ($kategori_to_km as $kategori => $km_threshold) {
            //     if (in_array($kategori, $request->kategori) && $request->km < $km_threshold) {
            //         array_push($error_pesanans, "Pergantian $kategori tidak dapat dilakukan, belum saatnya penggantian");
            //     }
            // }
        }

        // if ($request->has('kategori2')) {
        //     for ($i = 0; $i < count($request->kategori2); $i++) {
        //         $validasi_produk = Validator::make($request->all(), [
        //             'kategori2.' . $i => 'required',
        //             'spareparts_id.' . $i => 'required',
        //             'nama_barang2.' . $i => 'required',
        //             'jumlah2.*' => 'required|numeric|min:1',
        //         ]);

        //         if ($validasi_produk->fails()) {
        //             array_push($error_pesanans, "Pergantian Filter Nomor " . $i + 1 . " belum dilengkapi!");
        //         }

        //         $kategori2 = is_null($request->kategori2[$i]) ? '' : $request->kategori2[$i];
        //         $spareparts_id = is_null($request->spareparts_id[$i]) ? '' : $request->spareparts_id[$i];
        //         $nama_barang2 = is_null($request->nama_barang2[$i]) ? '' : $request->nama_barang2[$i];
        //         $jumlah2 = is_null($request->jumlah2[$i]) ? '' : $request->jumlah2[$i];

        //         $data_pembelians2->push(['kategori2' => $kategori2, 'spareparts_id' => $spareparts_id, 'nama_barang2' => $nama_barang2, 'jumlah2' => $jumlah2]);
        //     }
        // }

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

                $data_pembelians2->push(['kategori2' => $kategori2, 'spareparts_id' => $spareparts_id, 'nama_barang2' => $nama_barang2, 'jumlah2' => $jumlah2]);
            }
        }

        if ($error_pelanggans || $error_pesanans) {
            return back()
                ->withInput()
                ->with('error_pelanggans', $error_pelanggans)
                ->with('error_pesanans', $error_pesanans)
                ->with('data_pembelians', $data_pembelians)
                ->with('data_pembelians2', $data_pembelians2);
        }

        // format tanggal indo
        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');

        $tanggal = Carbon::now()->format('Y-m-d');
        $transaksi = Penggantian_oli::create([
            'user_id' => auth()->user()->id,
            'kode_penggantianoli' => $this->kode(),
            'kendaraan_id' => $request->kendaraan_id,
            'tanggal_penggantian' => $format_tanggal,
            'tanggal_awal' => $tanggal,
            'status' => 'posting',
            'status_notif' => false,
        ]);

        $transaksi_id = $transaksi->id;

        if ($transaksi) {
            foreach ($data_pembelians as $data_pesanan) {
                $sparepart = Sparepart::find($data_pesanan['sparepart_id']);
                if ($sparepart) {
                    // Mengurangkan jumlah sparepart yang dipilih dengan jumlah yang dikirim dalam request
                    $jumlah_sparepart = $sparepart->jumlah - $data_pesanan['jumlah'];

                    // Memperbarui jumlah sparepart langsung, tanpa membatasi menjadi minimum 0
                    $sparepart->update(['jumlah' => $jumlah_sparepart]);

                    // Membuat Detail_penggantianoli
                    $km_berikutnya = $request->km; // Nilai default

                    if ($data_pesanan['kategori'] == 'Oli Mesin') {
                        $km_berikutnya += 13000;
                    } elseif ($data_pesanan['kategori'] == 'Oli Gardan') {
                        $km_berikutnya += 50000;
                    } elseif ($data_pesanan['kategori'] == 'Oli Transmisi') {
                        $km_berikutnya += 50000;
                    }

                    Detail_penggantianoli::create([
                        'penggantian_oli_id' => $transaksi->id,
                        'kategori' => $data_pesanan['kategori'],
                        'sparepart_id' => $data_pesanan['sparepart_id'],
                        'tanggal_awal' => Carbon::now('Asia/Jakarta'),
                        'jumlah' => $data_pesanan['jumlah'],
                        'km_penggantian' => $request->km,
                        'km_berikutnya' => $km_berikutnya, // Menggunakan nilai yang telah diubah
                    ]);
                }
            }
        }


        if ($transaksi) {
            foreach ($data_pembelians2 as $data_pesanan) {
                $sparepart = Sparepart::find($data_pesanan['spareparts_id']);
                if ($sparepart) {
                    // Mengurangkan jumlah sparepart yang dipilih dengan jumlah yang dikirim dalam request
                    $jumlah_sparepart = $sparepart->jumlah - $data_pesanan['jumlah2'];

                    // Memperbarui jumlah sparepart
                    $sparepart->update(['jumlah' => $jumlah_sparepart]);

                    Detail_penggantianpart::create([
                        'penggantians_oli_id' => $transaksi->id,
                        'kategori2' => $data_pesanan['kategori2'],
                        'spareparts_id' => $data_pesanan['spareparts_id'],
                        'tanggal_awal' => Carbon::now('Asia/Jakarta'),
                        'jumlah2' => $data_pesanan['jumlah2'],
                        'km_penggantian' => $request->km,
                    ]);
                }
            }
        }

        $dataToUpdate = [
            'km' => $request->km,
            'km_olimesin' => null,
            'km_oligardan' => null,
            'km_olitransmisi' => null,
            'status_olimesin' => null,
            'status_oligardan' => null,
            'status_olitransmisi' => null,
        ];

        if ($request->has('kategori')) {
            if (in_array('Oli Mesin', $request->kategori)) {
                $dataToUpdate['km_olimesin'] = $request->km + 13000;
                $dataToUpdate['status_olimesin'] = 'sudah penggantian';
            }

            if (in_array('Oli Gardan', $request->kategori)) {
                $dataToUpdate['km_oligardan'] = $request->km + 50000;
                $dataToUpdate['status_oligardan'] = 'sudah penggantian';
            }

            if (in_array('Oli Transmisi', $request->kategori)) {
                $dataToUpdate['km_olitransmisi'] = $request->km + 50000;
                $dataToUpdate['status_olitransmisi'] = 'sudah penggantian';
            }
        }

        // Periksa dan biarkan nilai-nilai yang tidak ada dalam request tetap sama seperti sebelumnya
        $dataToUpdate['km_olimesin'] = $dataToUpdate['km_olimesin'] ?? $kendaraan->km_olimesin;
        $dataToUpdate['km_oligardan'] = $dataToUpdate['km_oligardan'] ?? $kendaraan->km_oligardan;
        $dataToUpdate['km_olitransmisi'] = $dataToUpdate['km_olitransmisi'] ?? $kendaraan->km_olitransmisi;
        $dataToUpdate['status_olimesin'] = $dataToUpdate['status_olimesin'] ?? $kendaraan->status_olimesin;
        $dataToUpdate['status_oligardan'] = $dataToUpdate['status_oligardan'] ?? $kendaraan->status_oligardan;
        $dataToUpdate['status_olitransmisi'] = $dataToUpdate['status_olitransmisi'] ?? $kendaraan->status_olitransmisi;

        $kendaraan->update($dataToUpdate);

        Kendaraan::where('id', $id)->update($dataToUpdate);

        $pembelians = Penggantian_oli::find($transaksi_id);

        // $kendaraan = Kendaraan::where('id', $pembelians->id)->first();
        $parts = Detail_penggantianoli::where('penggantian_oli_id', $pembelians->id)->get();
        $parts2 = Detail_penggantianpart::where('penggantians_oli_id', $pembelians->id)->get();

        return view('admin.penggantian_oli.show', compact('parts', 'parts2', 'pembelians'));
    }


    public function show($id)
    {
        if (auth()->check() && auth()->user()->menu['penggantian oli']) {

            $cetakpdf = Penggantian_oli::where('id', $id)->first();
            return view('admin.penggantian_oli.show', compact('cetakpdf'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function cetakpdf($id)
    {
        if (auth()->check() && auth()->user()->menu['penggantian oli']) {

            $pemasangans = Penggantian_oli::find($id);
            $parts = Detail_penggantianoli::where('penggantian_oli_id', $id)->get();
            $parts2 = Detail_penggantianpart::where('penggantians_oli_id', $id)->get();


            $pdf = PDF::loadView('admin/penggantian_oli.cetak_pdf', compact('parts', 'pemasangans', 'parts2'));
            $pdf->setPaper('letter', 'portrait');

            return $pdf->stream('Surat_Penggantian_Oli.pdf');
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }



    public function kode()
    {
        $penggantian = Penggantian_oli::all();
        if ($penggantian->isEmpty()) {
            $num = "000001";
        } else {
            $id = Penggantian_oli::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'AQ';
        $kode_penggantian = $data . $num;
        return $kode_penggantian;
    }

    public function checkpostoli($id)
    {
        $kendaraan = Kendaraan::find($id);

        // Memeriksa status dan mengupdate jika status adalah 'konfirmasi'
        if ($kendaraan->status_olimesin == 'konfirmasi') {
            $kendaraan->update(['status_olimesin' => 'sudah penggantian']);
        }

        if ($kendaraan->status_oligardan == 'konfirmasi') {
            $kendaraan->update(['status_oligardan' => 'sudah penggantian']);
        }

        if ($kendaraan->status_olitransmisi == 'konfirmasi') {
            $kendaraan->update(['status_olitransmisi' => 'sudah penggantian']);
        }

        return back()->with('success', 'Berhasil');
    }
}