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
use App\Models\Lama_penggantianoli;
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
            $lamapenggantians = Lama_penggantianoli::get();
            return view('admin.penggantian_oli.update', compact('lamapenggantians', 'jenis_kendaraans', 'kendaraans', 'spareparts'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

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

        if ($request->has('lama_penggantianoli_id')) {
            for ($i = 0; $i < count($request->lama_penggantianoli_id); $i++) {
                $validasi_produk = Validator::make($request->all(), [
                    'lama_penggantianoli_id.' . $i => 'required',
                    'sparepart_id.' . $i => 'required',
                    'nama_barang.' . $i => 'required',
                    'jumlah.' . $i => 'required|numeric|min:1', // 'jumlah.*' should be 'jumlah.' . $i
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Pergantian Oli nomor " . ($i + 1) . " belum dilengkapi!"); // Corrected the syntax for concatenation and indexing
                }

                $lama_penggantianoli_id = is_null($request->lama_penggantianoli_id[$i]) ? '' : $request->lama_penggantianoli_id[$i];
                $sparepart_id = is_null($request->sparepart_id[$i]) ? '' : $request->sparepart_id[$i];
                $nama_barang = is_null($request->nama_barang[$i]) ? '' : $request->nama_barang[$i];
                $jumlah = is_null($request->jumlah[$i]) ? '' : $request->jumlah[$i];

                $data_pembelians->push(['lama_penggantianoli_id' => $lama_penggantianoli_id, 'sparepart_id' => $sparepart_id, 'nama_barang' => $nama_barang, 'jumlah' => $jumlah]);
            }
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

                    // Mengambil data lama_penggantianoli berdasarkan ID
                    $lamapenggantian = Lama_penggantianoli::where('id', $data_pesanan['lama_penggantianoli_id'])->first();

                    // Menghitung nilai km_berikutnya
                    $km_berikutnya = $request->km + ($lamapenggantian ? $lamapenggantian->km_oli : 0);

                    Detail_penggantianoli::create([
                        'penggantian_oli_id' => $transaksi->id,
                        'lama_penggantianoli_id' => $data_pesanan['lama_penggantianoli_id'],
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

        if ($request->has('lama_penggantianoli_id')) {
            foreach ($request->lama_penggantianoli_id as $id) {
                $lama_penggantianoli = Lama_penggantianoli::find($id);

                if ($lama_penggantianoli) {
                    // Update the corresponding km and status fields based on the lama_penggantianoli_id
                    if ($id == 1) { // Assuming 1 represents 'Oli Mesin'
                        $dataToUpdate['km_olimesin'] = $request->km + $lama_penggantianoli->km_oli;
                        $dataToUpdate['status_olimesin'] = 'sudah penggantian';
                    } elseif ($id == 2) { // Assuming 2 represents 'Oli Gardan'
                        $dataToUpdate['km_oligardan'] = $request->km + $lama_penggantianoli->km_oli;
                        $dataToUpdate['status_oligardan'] = 'sudah penggantian';
                    } elseif ($id == 3) { // Assuming 3 represents 'Oli Transmisi'
                        $dataToUpdate['km_olitransmisi'] = $request->km + $lama_penggantianoli->km_oli;
                        $dataToUpdate['status_olitransmisi'] = 'sudah penggantian';
                    }
                }
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