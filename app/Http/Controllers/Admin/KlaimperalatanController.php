<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Kendaraan;
use App\Models\Sparepart;
use Illuminate\Http\Request;
use App\Models\Klaim_peralatan;
use App\Http\Controllers\Controller;
use App\Models\Deposit_driver;
use App\Models\Detail_inventory;
use App\Models\Detail_pembelianpart;
use App\Models\Detail_klaimperalatan;
use App\Models\Karyawan;
use App\Models\Penerimaan_kaskecil;
use App\Models\Saldo;
use Illuminate\Support\Facades\Validator;

class KlaimperalatanController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $inquery = Klaim_peralatan::whereDate('created_at', $today)
            ->orWhere(function ($query) use ($today) {
                $query->where('status', 'unpost')
                    ->whereDate('created_at', '<', $today);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.klaim_peralatan.index', compact('inquery'));
    }

    public function create()
    {
        $kendaraans = Kendaraan::all();
        $spareparts = Sparepart::where([
            'kategori' => 'peralatan'
        ])->get();
        $SopirAll = Karyawan::where('departemen_id', '2')->get();

        return view('admin.klaim_peralatan.create', compact('SopirAll', 'kendaraans', 'spareparts'));
    }

    public function store(Request $request)
    {
        $validasi_pelanggan = Validator::make($request->all(), [
            'kendaraan_id' => 'required',
        ], [
            'kendaraan_id.required' => 'Pilih no kabin!',
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
                    'kode_partdetail.' . $i => 'required',
                    'nama_barang.' . $i => 'required',
                    'keterangan.' . $i => 'required',
                    'harga.' . $i => 'required',
                    'jumlah.*' => 'required|numeric|min:1',
                    'total.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Pemasangan Part nomor " . $i + 1 . " belum dilengkapi!");
                }

                $sparepart_id = is_null($request->sparepart_id[$i]) ? '' : $request->sparepart_id[$i];
                $kode_partdetail = is_null($request->kode_partdetail[$i]) ? '' : $request->kode_partdetail[$i];
                $nama_barang = is_null($request->nama_barang[$i]) ? '' : $request->nama_barang[$i];
                $keterangan = is_null($request->keterangan[$i]) ? '' : $request->keterangan[$i];
                $harga = is_null($request->harga[$i]) ? '' : $request->harga[$i];
                $jumlah = is_null($request->jumlah[$i]) ? '' : $request->jumlah[$i];
                $total = is_null($request->total[$i]) ? '' : $request->total[$i];

                $data_pembelians->push(['sparepart_id' => $sparepart_id, 'kode_partdetail' => $kode_partdetail, 'nama_barang' => $nama_barang, 'keterangan' => $keterangan, 'harga' => $harga, 'jumlah' => $jumlah, 'total' => $total]);
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
        $kodedepositdriver = $this->kodedepositdriver();
        $depositdriver = Deposit_driver::create(array_merge(
            $request->all(),
            [
                'kode_deposit' => $kodedepositdriver,
                'karyawan_id' => $request->karyawan_id,
                'kode_sopir' => $request->kode_karyawan,
                'nama_sopir' => $request->nama_lengkap,
                'kategori' => 'Pengambilan Deposit',
                'sub_total' => str_replace('.', '', $request->sub_totals),
                'nominal' => str_replace('.', '', $request->saldo_keluar),
                'saldo_keluar' => $request->saldo_keluar,
                'keterangan' => $request->keterangans,
                'sisa_saldo' => str_replace('.', '', $request->sisa_saldo),
                'tanggal' =>  $format_tanggal,
                'tanggal_awal' =>  $tanggal,
                'status' => 'unpost',
            ]
        ));

        $saldoTerakhir = Saldo::latest()->first();
        $saldo = $saldoTerakhir->id;
        // Menghapus tanda titik dari nilai saldo_keluar dan mengonversi ke tipe numerik
        $saldo_keluar_numeric = (float) str_replace('.', '', $request->saldo_keluar);
        $subtotals =  $saldoTerakhir->sisa_saldo + $saldo_keluar_numeric;
        $kodepenerimaan = $this->kodepenerimaan();
        $penerimaan = Penerimaan_kaskecil::create(array_merge(
            $request->all(),
            [
                'kode_penerimaan' => $this->kodepenerimaan(),
                'deposit_driver_id' => $depositdriver->id,
                'nominal' => str_replace('.', '', $request->saldo_keluar),
                'saldo_masuk' => $request->saldo_keluar,
                'keterangan' => $request->keterangans,
                'sisa_saldo' => $saldoTerakhir->sisa_saldo,
                'saldo_id' => $saldo,
                'sub_total' => $subtotals,
                'qr_code_penerimaan' => 'https:///javaline.id/penerimaan_kaskecil/' . $kodepenerimaan,
                'tanggaljam' => Carbon::now('Asia/Jakarta'),
                'jam' => $tanggal1->format('H:i:s'),
                'tanggal' =>  $format_tanggal,
                'tanggal_awal' =>  $tanggal,
                'status' => 'unpost',
            ]
        ));

        $transaksi = Klaim_peralatan::create([
            'user_id' => auth()->user()->id,
            'kode_klaim' => $this->kode(),
            'kendaraan_id' => $request->kendaraan_id,
            'penerimaan_kaskecil_id' => $penerimaan->id,
            'karyawan_id' => $request->karyawan_id,
            'deposit_driver_id' => $depositdriver->id,
            'penerimaan_kaskecil_id' => $penerimaan->id,
            'keterangan' => $request->keterangans,
            'sisa_saldo' => str_replace('.', '', $request->sisa_saldo),
            'harga_klaim' => str_replace('.', '', $request->saldo_keluar),
            'grand_total' => str_replace('.', '', $request->sub_totals),

            'tanggal_klaim' => $format_tanggal,
            'tanggal_awal' => $tanggal,
            'status' => 'unpost',
            'status_notif' => false,
        ]);

        $transaksi_id = $transaksi->id;

        if ($transaksi) {
            foreach ($data_pembelians as $data_pesanan) {
                // Find the corresponding Detail_inventory record based on sparepart_id
                // $detail_inventory = Detail_inventory::where('sparepart_id', $data_pesanan['sparepart_id'])
                //     ->where('kendaraan_id', $request->kendaraan_id)
                //     ->first();

                // if ($detail_inventory) {
                //     $jumlah_sparepart = $detail_inventory->jumlah - $data_pesanan['jumlah'];

                //     // Ensure jumlah sparepart does not go below zero
                //     $jumlah_sparepart = max(0, $jumlah_sparepart);

                //     // Update the jumlah in Detail_inventory
                //     $detail_inventory->update(['jumlah' => $jumlah_sparepart]);

                // Create Detail_klaimperalatan
                Detail_klaimperalatan::create([
                    'klaim_peralatan_id' => $transaksi->id,
                    'sparepart_id' => $data_pesanan['sparepart_id'],
                    'kode_partdetail' => $data_pesanan['kode_partdetail'],
                    'nama_barang' => $data_pesanan['nama_barang'],
                    'tanggal_awal' => Carbon::now('Asia/Jakarta'),
                    'keterangan' => $data_pesanan['keterangan'],
                    'jumlah' => $data_pesanan['jumlah'],
                    'harga' => $data_pesanan['harga'],
                    'total' => $data_pesanan['total'],
                ]);
                // }
            }
        }

        $klaim_peralatan = Klaim_peralatan::find($transaksi_id);

        // $kendaraan = Kendaraan::where('id', $klaim_peralatan->id)->first();
        $details = Detail_klaimperalatan::where('klaim_peralatan_id', $klaim_peralatan->id)->get();

        return view('admin.klaim_peralatan.show', compact('details', 'klaim_peralatan'));
    }

    public function cetakpdf($id)
    {
        if (auth()->check() && auth()->user()->menu['pemasangan part']) {

            $klaim_peralatan = Klaim_peralatan::find($id);
            $details = Detail_klaimperalatan::where('klaim_peralatan_id', $id)->get();
            // Load the view and set the paper size to portrait letter
            $pdf = PDF::loadView('admin.klaim_peralatan.cetak_pdf', compact('details', 'klaim_peralatan'));
            $pdf->setPaper('letter', 'portrait'); // Set the paper size to portrait letter

            return $pdf->stream('Surat_Pemasangan_Klaim_Peralatan.pdf');
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function show($id)
    {
        $klaim_peralatan = Klaim_peralatan::find($id);
        $details = Detail_klaimperalatan::where('klaim_peralatan_id', $klaim_peralatan->id)->get();

        return view('admin.klaim_peralatan.show', compact('details', 'klaim_peralatan'));
    }

    public function kode()
    {
        // Ambil kode memo terakhir yang sesuai format 'FP%' dan kategori 'Memo Perjalanan'
        $lastBarang = Klaim_peralatan::where('kode_klaim', 'like', 'FP%')
            ->orderBy('id', 'desc')
            ->first();

        // Inisialisasi nomor urut
        $num = 1;

        // Jika ada kode terakhir, proses untuk mendapatkan nomor urut
        if ($lastBarang) {
            $lastCode = $lastBarang->kode_klaim;

            // Pastikan kode terakhir sesuai dengan format FP[YYYYMMDD][NNNN]A
            if (preg_match('/^FP(\d{6})(\d{4})A$/', $lastCode, $matches)) {
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

        // Buat kode baru dengan tambahan huruf A di belakang
        $prefix = 'FP';
        $kodeMemo = $prefix . date('ymd') . $formattedNum . 'A'; // Format akhir kode memo

        return $kodeMemo;
    }
    
    public function destroy($id)
    {
        // Mencari data berdasarkan klaim_peralatan_id

        $part = Klaim_peralatan::find($id);
        $part = Detail_pembelianpart::find($id);
        $part->delete();
        return;
    }

    public function kodedepositdriver()
    {
        $lastBarang = Deposit_driver::latest()->first();
        if (!$lastBarang) {
            $num = 1;
        } else {
            $lastCode = $lastBarang->kode_deposit;
            $num = (int) substr($lastCode, strlen('FD')) + 1;
        }
        $formattedNum = sprintf("%06s", $num);
        $prefix = 'FD';
        $newCode = $prefix . $formattedNum;
        return $newCode;
    }

    public function kodepenerimaan()
    {
        $lastBarang = Penerimaan_kaskecil::latest()->first();
        if (!$lastBarang) {
            $num = 1;
        } else {
            $lastCode = $lastBarang->kode_penerimaan;
            $num = (int) substr($lastCode, strlen('FK')) + 1;
        }
        $formattedNum = sprintf("%06s", $num);
        $prefix = 'FK';
        $newCode = $prefix . $formattedNum;
        return $newCode;
    }

    public function get_detailinventory($kendaraan_id)
    {
        $fakturs = Detail_inventory::where(['kendaraan_id' => $kendaraan_id])
            ->with('kendaraan')
            ->with('sparepart')
            ->get();
        return response()->json($fakturs);
    }
}