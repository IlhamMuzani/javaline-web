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
use App\Models\Bearing;
use App\Models\Detail_penggantianbearing;
use App\Models\Detail_penggantianoli;
use App\Models\Detail_penggantianpart;
use App\Models\Lama_bearing;
use App\Models\Lama_penggantianoli;
use App\Models\Penggantian_bearing;
use Illuminate\Support\Facades\Validator;

class PenggantianBearingController extends Controller
{
    public function index()
    {
        $kendaraans = Kendaraan::all();


        foreach ($kendaraans as $kendaraan) {
            $updates = [];

            // Cek apakah bearing ditemukan untuk kendaraan
            $bearing = Bearing::where('kendaraan_id', $kendaraan->id)->first();

            // Jika bearing tidak ditemukan, skip ke kendaraan berikutnya
            if (!$bearing) {
                continue;
            }

            // Melakukan pengecekan dan pembaruan berdasarkan kondisi km
            if ($kendaraan->km >= $bearing->bearing1a) {
                $updates['status_bearing1a'] = 'belum penggantian';
            } else {
                $updates['status_bearing1a'] = 'sudah penggantian';
            }

            if ($kendaraan->km >= $bearing->bearing1b) {
                $updates['status_bearing1b'] = 'belum penggantian';
            } else {
                $updates['status_bearing1b'] = 'sudah penggantian';
            }

            if ($kendaraan->km >= $bearing->bearing2a) {
                $updates['status_bearing2a'] = 'belum penggantian';
            } else {
                $updates['status_bearing2a'] = 'sudah penggantian';
            }

            if ($kendaraan->km >= $bearing->bearing2b) {
                $updates['status_bearing2b'] = 'belum penggantian';
            } else {
                $updates['status_bearing2b'] = 'sudah penggantian';
            }

            if ($kendaraan->km >= $bearing->bearing3a) {
                $updates['status_bearing3a'] = 'belum penggantian';
            } else {
                $updates['status_bearing3a'] = 'sudah penggantian';
            }

            if ($kendaraan->km >= $bearing->bearing3b) {
                $updates['status_bearing3b'] = 'belum penggantian';
            } else {
                $updates['status_bearing3b'] = 'sudah penggantian';
            }

            if ($kendaraan->km >= $bearing->bearing4a) {
                $updates['status_bearing4a'] = 'belum penggantian';
            } else {
                $updates['status_bearing4a'] = 'sudah penggantian';
            }

            if ($kendaraan->km >= $bearing->bearing4b) {
                $updates['status_bearing4b'] = 'belum penggantian';
            } else {
                $updates['status_bearing4b'] = 'sudah penggantian';
            }

            if ($kendaraan->km >= $bearing->bearing5a) {
                $updates['status_bearing5a'] = 'belum penggantian';
            } else {
                $updates['status_bearing5a'] = 'sudah penggantian';
            }

            if ($kendaraan->km >= $bearing->bearing5b) {
                $updates['status_bearing5b'] = 'belum penggantian';
            } else {
                $updates['status_bearing5b'] = 'sudah penggantian';
            }

            if ($kendaraan->km >= $bearing->bearing6a) {
                $updates['status_bearing6a'] = 'belum penggantian';
            } else {
                $updates['status_bearing6a'] = 'sudah penggantian';
            }

            if ($kendaraan->km >= $bearing->bearing6b) {
                $updates['status_bearing6b'] = 'belum penggantian';
            } else {
                $updates['status_bearing6b'] = 'sudah penggantian';
            }

            // Melakukan pembaruan pada bearing jika ada perubahan
            $bearing->update($updates);
        }

        return view('admin.penggantian_bearing.index', compact('kendaraans'));
    }

    public function edit($id)
    {
        $kendaraan = Kendaraan::find($id);
        $updates = [];
        $bearing = Bearing::where('kendaraan_id', $kendaraan->id)->first();
        if ($kendaraan->km >= $bearing->bearing1a) {
            $updates['status_bearing1a'] = 'belum penggantian';
        } else {
            $updates['status_bearing1a'] = 'sudah penggantian';
        }

        if ($kendaraan->km >= $bearing->bearing1b) {
            $updates['status_bearing1b'] = 'belum penggantian';
        } else {
            $updates['status_bearing1b'] = 'sudah penggantian';
        }

        if ($kendaraan->km >= $bearing->bearing2a) {
            $updates['status_bearing2a'] = 'belum penggantian';
        } else {
            $updates['status_bearing2a'] = 'sudah penggantian';
        }

        if ($kendaraan->km >= $bearing->bearing2b) {
            $updates['status_bearing2b'] = 'belum penggantian';
        } else {
            $updates['status_bearing2b'] = 'sudah penggantian';
        }

        if ($kendaraan->km >= $bearing->bearing3a) {
            $updates['status_bearing3a'] = 'belum penggantian';
        } else {
            $updates['status_bearing3a'] = 'sudah penggantian';
        }

        if ($kendaraan->km >= $bearing->bearing3b) {
            $updates['status_bearing3b'] = 'belum penggantian';
        } else {
            $updates['status_bearing3b'] = 'sudah penggantian';
        }

        if ($kendaraan->km >= $bearing->bearing4a) {
            $updates['status_bearing4a'] = 'belum penggantian';
        } else {
            $updates['status_bearing4a'] = 'sudah penggantian';
        }

        if ($kendaraan->km >= $bearing->bearing4b) {
            $updates['status_bearing4b'] = 'belum penggantian';
        } else {
            $updates['status_bearing4b'] = 'sudah penggantian';
        }

        if ($kendaraan->km >= $bearing->bearing5a) {
            $updates['status_bearing5a'] = 'belum penggantian';
        } else {
            $updates['status_bearing5a'] = 'sudah penggantian';
        }

        if ($kendaraan->km >= $bearing->bearing5b) {
            $updates['status_bearing5b'] = 'belum penggantian';
        } else {
            $updates['status_bearing5b'] = 'sudah penggantian';
        }

        if ($kendaraan->km >= $bearing->bearing6a) {
            $updates['status_bearing6a'] = 'belum penggantian';
        } else {
            $updates['status_bearing6a'] = 'sudah penggantian';
        }

        if ($kendaraan->km >= $bearing->bearing6b) {
            $updates['status_bearing6b'] = 'belum penggantian';
        } else {
            $updates['status_bearing6b'] = 'sudah penggantian';
        }

        $bearing->update($updates);
        $spareparts = Sparepart::where('kategori', 'sasis')->get();

        return view('admin.penggantian_bearing.update', compact('kendaraan', 'spareparts'));
    }

    public function store(Request $request)
    {
        $kendaraan_id = $request->kendaraan_id;
        $kendaraan = Kendaraan::where('id', $kendaraan_id)->first();
        $validasi_pelanggan = Validator::make($request->all(), [
            'kendaraan_id' => 'required',
            'km' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) use ($kendaraan) {
                    if ($value <= $kendaraan->km) {
                        $fail('Nilai km akhir harus lebih tinggi dari km awal');
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

        if ($validasi_pelanggan->fails()) {
            array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
        }

        $error_pesanans = array();
        $data_pembelians = collect();

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

        // format tanggal indo
        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');
        $km_kendaraan = $request->km;
        $lama_bearing = Lama_bearing::first();
        $tanggal = Carbon::now()->format('Y-m-d');
        $transaksi = Penggantian_bearing::create([
            'user_id' => auth()->user()->id,
            'kode_penggantian' => $this->kode(),
            'kendaraan_id' => $request->kendaraan_id,
            'km_penggantian' => $km_kendaraan,
            'km_berikutnya' => $km_kendaraan + $lama_bearing->batas,
            'tanggal_penggantian' => $format_tanggal,
            'tanggal_awal' => $tanggal,
            'tromol1' => $request->tromol1,
            'tromol2' => $request->tromol2,
            'tromol3' => $request->tromol3,
            'tromol4' => $request->tromol4,
            'tromol5' => $request->tromol5,
            'tromol6' => $request->tromol6,
            'tromol7' => $request->tromol7,
            'tromol8' => $request->tromol8,
            'tromol9' => $request->tromol9,
            'tromol10' => $request->tromol10,
            'tromol11' => $request->tromol11,
            'tromol12' => $request->tromol12,
            'status' => 'posting',
            'status_notif' => false,
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

        if ($transaksi) {
            foreach ($data_pembelians as $data_pesanan) {
                // Cari sparepart berdasarkan sparepart_id
                $sparepart = Sparepart::find($data_pesanan['sparepart_id']);

                if ($sparepart) {
                    $jumlah_sparepart = $sparepart->jumlah - $data_pesanan['jumlah'];
                    $sparepart->update(['jumlah' => $jumlah_sparepart]);
                    // Ambil data lama_bearing pertama
                    $lama_bearing = Lama_bearing::first();

                    // Siapkan data detail pemakaian
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

                    // Membuat record detail penggantian bearing
                    $detail_pemakaians = Detail_penggantianbearing::create($detail_pemakaians_data);
                }
            }
        }


        $penggantian = Penggantian_bearing::find($transaksi_id);

        $details = Detail_penggantianbearing::where('penggantian_bearing_id', $penggantian->id)
            ->whereNotNull('kategori') // Memastikan kategori tidak null
            ->get();

        return view('admin.penggantian_bearing.show', compact('details', 'penggantian'));
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

        return view('admin.penggantian_bearing.show', compact('details', 'detailgrease', 'penggantian'));
    }

    public function kode()
    {
        $pemasangan = Penggantian_bearing::all();
        if ($pemasangan->isEmpty()) {
            $num = "000001";
        } else {
            $id = Penggantian_bearing::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'PT';
        $kode_pemasangan = $data . $num;
        return $kode_pemasangan;
    }

    public function cetakpdf($id)
    {
        $penggantian = Penggantian_bearing::where('id', $id)->first();
        $pemakaian = Penggantian_bearing::find($id);

        $details = Detail_penggantianbearing::where('penggantian_bearing_id', $id)
            ->whereNotNull('kategori') // Memastikan kategori tidak null
            ->get();
        $detailgrease = Detail_penggantianbearing::where('penggantian_bearing_id', $id)
            ->whereNull('kategori') // Mencari kategori yang null
            ->first();

        $pdf = PDF::loadView('admin.penggantian_bearing.cetak_pdf', compact('penggantian', 'details', 'detailgrease'));
        $pdf->setPaper('letter', 'portrait'); // Set the paper size to portrait letter

        return $pdf->stream('Penggantian_Bearing.pdf');
    }
}