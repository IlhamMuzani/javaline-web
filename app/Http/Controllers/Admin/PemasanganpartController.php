<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Supplier;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Kendaraan;
use App\Models\Sparepart;
use Illuminate\Http\Request;
use App\Models\Pembelian_ban;
use App\Models\Pemasangan_ban;
use App\Models\Pembelian_part;
use App\Models\Pemasangan_part;
use App\Http\Controllers\Controller;
use App\Models\Detail_pembelianpart;
use App\Models\Detail_pemasanganpart;
use App\Models\Detail_pemasanganpartdua;
use Illuminate\Support\Facades\Validator;

class PemasanganpartController extends Controller
{
    public function index()
    {
        if (auth()->check() && auth()->user()->menu['pemasangan part']) {

            $kendaraans = Kendaraan::all();
            $spareparts = Sparepart::where([
                ['kategori', '!=', 'oli']
            ])->get();

            return view('admin.pemasangan_part.index', compact('kendaraans', 'spareparts'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }


    public function store(Request $request)
    {
        $validasi_pelanggan = Validator::make($request->all(), [
            // 'kendaraan_id' => 'required',
        ], [
            // 'kendaraan_id.required' => 'Pilih no kabin!',
        ]);

        $error_pelanggans = array();

        if ($validasi_pelanggan->fails()) {
            array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
        }

        $error_pesanans = array();
        $data_pembelians = collect();

        if ($request->has('sparepart_id')) {
            for ($i = 0; $i < count($request->sparepart_id); $i++) {
                $validasi_produk = Validator::make($request->all(), [
                    'sparepart_id.' . $i => 'required',
                    'nama_barang.' . $i => 'required',
                    'keterangan.' . $i => 'required',
                    'jumlah.*' => 'required|numeric|min:1',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Pemasangan Part nomor " . $i + 1 . " belum dilengkapi!");
                }

                $sparepart_id = is_null($request->sparepart_id[$i]) ? '' : $request->sparepart_id[$i];
                $nama_barang = is_null($request->nama_barang[$i]) ? '' : $request->nama_barang[$i];
                $keterangan = is_null($request->keterangan[$i]) ? '' : $request->keterangan[$i];
                $jumlah = is_null($request->jumlah[$i]) ? '' : $request->jumlah[$i];

                $data_pembelians->push(['sparepart_id' => $sparepart_id, 'nama_barang' => $nama_barang, 'keterangan' => $keterangan, 'jumlah' => $jumlah]);
            }

            // if (!$error_pelanggans && !$error_pesanans) {
            //     foreach ($request->sparepart_id as $index => $sparepartId) {
            //         $jumlahDiminta = $request->jumlah[$index];
            //         $sparepart = Sparepart::find($sparepartId);

            //         if ($sparepart && $jumlahDiminta > $sparepart->jumlah) {
            //             array_push($error_pesanans, "Stok Sparepart nomor " . ($index + 1) . " tidak mencukupi!");
            //         }
            //     }
            // }
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

        $tanggal = Carbon::now()->format('Y-m-d');
        $transaksi = Pemasangan_part::create([
            'user_id' => auth()->user()->id,
            'kode_pemasanganpart' => $this->kode(),
            'kendaraan_id' => $request->kendaraan_id,
            'tanggal_pemasangan' => $format_tanggal,
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

                    // Pastikan jumlah sparepart tidak kurang dari nol
                    // $jumlah_sparepart = max(0, $jumlah_sparepart);

                    // Memperbarui jumlah sparepart
                    $sparepart->update(['jumlah' => $jumlah_sparepart]);

                    // Membuat Detail_pemasanganpart
                    Detail_pemasanganpart::create([
                        'pemasangan_part_id' => $transaksi->id,
                        'sparepart_id' => $data_pesanan['sparepart_id'],
                        'tanggal_awal' => Carbon::now('Asia/Jakarta'),
                        'keterangan' => $data_pesanan['keterangan'],
                        'jumlah' => $data_pesanan['jumlah'],
                    ]);
                }
            }
        }

        $pembelians = Pemasangan_part::find($transaksi_id);

        // $kendaraan = Kendaraan::where('id', $pembelians->id)->first();
        $parts = Detail_pemasanganpart::where('pemasangan_part_id', $pembelians->id)->get();

        return view('admin.pemasangan_part.show', compact('parts', 'pembelians'));
    }

    public function cetakpdf($id)
    {
        if (auth()->check() && auth()->user()->menu['pemasangan part']) {

            $pemasangans = Pemasangan_part::find($id);
            $parts = Detail_pemasanganpart::where('pemasangan_part_id', $id)->get();
            // Load the view and set the paper size to portrait letter
            $pdf = PDF::loadView('admin.pemasangan_part.cetak_pdf', compact('parts', 'pemasangans'));
            $pdf->setPaper('letter', 'portrait'); // Set the paper size to portrait letter

            return $pdf->stream('Surat_Pemasangan_Part.pdf');
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function kode()
    {
        // Ambil kode memo terakhir yang sesuai format 'OB%' dan kategori 'Memo Perjalanan'
        $lastBarang = Pemasangan_part::where('kode_pemasanganpart', 'like', 'OB%')
            ->orderBy('id', 'desc')
            ->first();

        // Inisialisasi nomor urut
        $num = 1;

        // Jika ada kode terakhir, proses untuk mendapatkan nomor urut
        if ($lastBarang) {
            $lastCode = $lastBarang->kode_pemasanganpart;

            // Pastikan kode terakhir sesuai dengan format OB[YYYYMMDD][NNNN]B
            if (preg_match('/^OB(\d{6})(\d{4})B$/', $lastCode, $matches)) {
                $lastDate = $matches[1]; // Bagian tanggal: ymd (contoh: 241125)
                $lastMonth = substr($lastDate, 2, 2); // Ambil bulan dari tanggal (contoh: 11)
                $currentMonth = date('m'); // Bulan saat ini

                if ($lastMonth === $currentMonth) {
                    // Jika bulan sama, tambahkan nomor urut
                    $lastNum = (int)$matches[2]; // Bagian nomor urut (contoh: 0001)
                    $num = $lastNum + 1;
                }
            }
        }

        // Formatkan nomor urut menjadi 4 digit
        $formattedNum = sprintf("%04s", $num);

        // Buat kode baru dengan tambahan huruf B di belakang
        $prefix = 'OB';
        $kodeMemo = $prefix . date('ymd') . $formattedNum . 'B'; // Format akhir kode memo

        return $kodeMemo;
    }

    public function destroy($id)
    {
        // Mencari data berdasarkan pemasangan_part_id

        $part = Pemasangan_part::find($id);
        $part = Detail_pembelianpart::find($id);
        $part->delete();
        return;
    }
}
