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
        ], [
            'kendaraan_id.required' => 'Pilih no kabin',
            'km.required' => 'Masukkan nilai km',
        ]);

        $error_pelanggans = array();

        if ($validasi_pelanggan->fails()) {
            array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
        }

        $error_pesanans = array();
        $data_pembelians = collect();

        if ($request->has('sparepart_id') || $request->has('kategori') || $request->has('kode_barang') || $request->has('nama_barang') || $request->has('jumlah') || $request->has('spareparts_id') || $request->has('kode_grease') || $request->has('nama_grease') || $request->has('jumlah_grease')) {
            for ($i = 0; $i < count($request->spareparts_id); $i++) {
                if (
                    empty($request->spareparts_id[$i]) && empty($request->kategori[$i]) && empty($request->kode_barang[$i]) && empty($request->nama_barang[$i]) && empty($request->jumlah[$i]) && empty($request->sparepart_id[$i]) && empty($request->kode_grease[$i]) && empty($request->nama_grease[$i]) && empty($request->jumlah_grease[$i])
                ) {
                    continue;
                }

                $validasi_produk = Validator::make($request->all(), [
                    // 'spareparts_id.' . $i => 'required',
                    // 'kode_grease.' . $i => 'required',
                    // 'nama_grease.' . $i => 'required',
                    // 'jumlah_grease.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Bearing nomor " . ($i + 1) . " belum dilengkapi!");
                }

                $sparepart_id = $request->sparepart_id[$i] ?? '';
                $kategori = $request->kategori[$i] ?? '';
                $kode_barang = $request->kode_barang[$i] ?? '';
                $nama_barang = $request->nama_barang[$i] ?? '';
                $jumlah = $request->jumlah[$i] ?? '';
                $spareparts_id = $request->spareparts_id[$i] ?? '';
                $kode_grease = $request->kode_grease[$i] ?? '';
                $nama_grease = $request->nama_grease[$i] ?? '';
                $jumlah_grease = $request->jumlah_grease[$i] ?? '';

                $data_pembelians->push([
                    'sparepart_id' => $sparepart_id,
                    'kategori' => $kategori,
                    'kode_barang' => $kode_barang,
                    'nama_barang' => $nama_barang,
                    'jumlah' => $jumlah,
                    'spareparts_id' => $spareparts_id,
                    'kode_grease' => $kode_grease,
                    'nama_grease' => $nama_grease,
                    'jumlah_grease' => $jumlah_grease
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

        $tanggal = Carbon::now()->format('Y-m-d');
        $transaksi = Penggantian_bearing::create([
            'user_id' => auth()->user()->id,
            'kode_penggantian' => $this->kode(),
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
                $spareparts = Sparepart::find($data_pesanan['spareparts_id']);
                if ($spareparts) {
                    // Mengurangkan jumlah sparepart
                    if ($sparepart) {
                        $jumlah_sparepart = $sparepart->jumlah - $data_pesanan['jumlah'];
                        $sparepart->update(['jumlah' => $jumlah_sparepart]);
                    }

                    if ($spareparts) {
                        $jumlah_spareparts = $spareparts->jumlah - $data_pesanan['jumlah_grease'];
                        $spareparts->update(['jumlah' => $jumlah_spareparts]);
                    }

                    $lama_bearing = Lama_bearing::first();
                    $detail_pemakaians_data = [
                        'kendaraan_id' => $request->kendaraan_id,
                        'penggantian_bearing_id' => $transaksi->id,
                        'km_penggantian' => $kendaraan->km,
                        'km_berikutnya' => $kendaraan->km + $lama_bearing->batas,
                        'spareparts_id' => $data_pesanan['spareparts_id'],
                        'kode_grease' => $data_pesanan['kode_grease'],
                        'nama_grease' => $data_pesanan['nama_grease'],
                        'jumlah_grease' => $data_pesanan['jumlah_grease'],
                        'tanggal_awal' => Carbon::now('Asia/Jakarta'),
                    ];

                    // Hanya tambahkan jika tidak null atau kosong
                    if (!empty($data_pesanan['sparepart_id'])) {
                        $detail_pemakaians_data['sparepart_id'] = $data_pesanan['sparepart_id'];
                    }

                    if (!empty($data_pesanan['kategori'])) {
                        $detail_pemakaians_data['kategori'] = $data_pesanan['kategori'];
                    }

                    if (!empty($data_pesanan['kode_barang'])) {
                        $detail_pemakaians_data['kode_barang'] = $data_pesanan['kode_barang'];
                    }

                    if (!empty($data_pesanan['nama_barang'])) {
                        $detail_pemakaians_data['nama_barang'] = $data_pesanan['nama_barang'];
                    }

                    if (!empty($data_pesanan['jumlah'])) {
                        $detail_pemakaians_data['jumlah'] = $data_pesanan['jumlah'];
                    }

                    // Membuat detail_pemakaians
                    $detail_pemakaians = Detail_penggantianbearing::create($detail_pemakaians_data);
                }

                // Mengambil km kendaraan dan lama_bearing
                $km_kendaraan = $request->km;
                $lama_bearing = Lama_bearing::first();
                $bearing = Bearing::where('kendaraan_id', $transaksi->kendaraan_id)->first();

                // Memeriksa kategori dan memperbarui bearing yang sesuai
                switch ($data_pesanan['kategori']) {
                    case 'Axle 1A':
                        if (!empty($data_pesanan['spareparts_id'])) {
                            $bearing->update([
                                'bearing1a' => $km_kendaraan + $lama_bearing->batas,
                                'status_bearing1a' => 'sudah penggantian',
                            ]);
                        }
                        break;
                    case 'Axle 1B':
                        if (!empty($data_pesanan['spareparts_id'])) {
                            $bearing->update([
                                'bearing1b' => $km_kendaraan + $lama_bearing->batas,
                                'status_bearing1b' => 'sudah penggantian',
                            ]);
                        }
                        break;

                    case 'Axle 2A':
                        if (!empty($data_pesanan['spareparts_id'])) {
                            $bearing->update([
                                'bearing2a' => $km_kendaraan + $lama_bearing->batas,
                                'status_bearing2a' => 'sudah penggantian',
                            ]);
                        }
                        break;

                    case 'Axle 2B':
                        if (!empty($data_pesanan['spareparts_id'])) {
                            $bearing->update([
                                'bearing2b' => $km_kendaraan + $lama_bearing->batas,
                                'status_bearing2b' => 'sudah penggantian',
                            ]);
                        }
                        break;

                    case 'Axle 3A':
                        if (!empty($data_pesanan['spareparts_id'])) {
                            $bearing->update([
                                'bearing3a' => $km_kendaraan + $lama_bearing->batas,
                                'status_bearing3a' => 'sudah penggantian',
                            ]);
                        }
                        break;

                    case 'Axle 3B':
                        if (!empty($data_pesanan['spareparts_id'])) {
                            $bearing->update([
                                'bearing3b' => $km_kendaraan + $lama_bearing->batas,
                                'status_bearing3b' => 'sudah penggantian',
                            ]);
                        }
                        break;

                    case 'Axle 4A':
                        if (!empty($data_pesanan['spareparts_id'])) {
                            $bearing->update([
                                'bearing4a' => $km_kendaraan + $lama_bearing->batas,
                                'status_bearing4a' => 'sudah penggantian',
                            ]);
                        }
                        break;

                    case 'Axle 4B':
                        if (!empty($data_pesanan['spareparts_id'])) {
                            $bearing->update([
                                'bearing4b' => $km_kendaraan + $lama_bearing->batas,
                                'status_bearing4b' => 'sudah penggantian',
                            ]);
                        }
                        break;

                    case 'Axle 5A':
                        if (!empty($data_pesanan['spareparts_id'])) {
                            $bearing->update([
                                'bearing5a' => $km_kendaraan + $lama_bearing->batas,
                                'status_bearing5a' => 'sudah penggantian',
                            ]);
                        }
                        break;

                    case 'Axle 5B':
                        if (!empty($data_pesanan['spareparts_id'])) {
                            $bearing->update([
                                'bearing5b' => $km_kendaraan + $lama_bearing->batas,
                                'status_bearing5b' => 'sudah penggantian',
                            ]);
                        }
                        break;

                    case 'Axle 6A':
                        if (!empty($data_pesanan['spareparts_id'])) {
                            $bearing->update([
                                'bearing6a' => $km_kendaraan + $lama_bearing->batas,
                                'status_bearing6a' => 'sudah penggantian',
                            ]);
                        }
                        break;

                    case 'Axle 6B':
                        if (!empty($data_pesanan['spareparts_id'])) {
                            $bearing->update([
                                'bearing6b' => $km_kendaraan + $lama_bearing->batas,
                                'status_bearing6b' => 'sudah penggantian',
                            ]);
                        }
                        break;

                    default:
                        // Jika kategori tidak dikenal
                        break;
                }
            }
        }

        $penggantian = Penggantian_bearing::find($transaksi_id);


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

        $data = 'PBB';
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