<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Kendaraan;
use App\Models\Sparepart;
use Illuminate\Http\Request;
use App\Models\Pemakaian_peralatan;
use App\Http\Controllers\Controller;
use App\Models\Detail_inventory;
use App\Models\Detail_pembelianpart;
use App\Models\Detail_pemakaian;
use Illuminate\Support\Facades\Validator;

class PemakainperalatanController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $inquery = Pemakaian_peralatan::whereDate('created_at', $today)
            ->orWhere(function ($query) use ($today) {
                $query->where('status', 'unpost')
                    ->whereDate('created_at', '<', $today);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.pemakaian_peralatan.index', compact('inquery'));
    }
    public function create()
    {
        $kendaraans = Kendaraan::all();
        $spareparts = Sparepart::where([
            'kategori' => 'peralatan'
        ])->get();
        return view('admin.pemakaian_peralatan.create', compact('kendaraans', 'spareparts'));
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
                    'nama_barang.' . $i => 'required',
                    'keterangan.' . $i => 'required',
                    'jumlah.*' => 'required|numeric|min:1',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Pemakain Alat nomor " . $i + 1 . " belum dilengkapi!");
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
        $transaksi = Pemakaian_peralatan::create([
            'user_id' => auth()->user()->id,
            'kode_pemakaian' => $this->kode(),
            'kendaraan_id' => $request->kendaraan_id,
            'tanggal_pemakaian' => $format_tanggal,
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

                    // Membuat Detail_pemakaian
                    $detail_pemakaians = Detail_pemakaian::create([
                        'kendaraan_id' => $request->kendaraan_id,
                        'pemakaian_peralatan_id' => $transaksi->id,
                        'sparepart_id' => $data_pesanan['sparepart_id'],
                        'tanggal_awal' => Carbon::now('Asia/Jakarta'),
                        'keterangan' => $data_pesanan['keterangan'],
                        'jumlah' => $data_pesanan['jumlah'],
                    ]);
                }


                // Check if the Detail_inventory already exists
                $existingDetailBarang = Detail_inventory::where('kendaraan_id', $request->kendaraan_id)
                    ->where('sparepart_id', $data_pesanan['sparepart_id'])
                    ->first();

                if ($existingDetailBarang) {
                    // If exists, update the jumlah
                    $existingDetailBarang->jumlah += $data_pesanan['jumlah'];
                    $existingDetailBarang->save();
                } else {
                    // If not exists, create a new Detail_inventory
                    Detail_inventory::create([
                        'pemakaian_peralatan_id' => $transaksi->id,
                        'detail_pemakaian_id' => $detail_pemakaians->id,
                        'kendaraan_id' => $request->kendaraan_id,
                        'sparepart_id' => $data_pesanan['sparepart_id'],
                        'jumlah' => $data_pesanan['jumlah'],
                        // 'harga' => $data_pesanan['harga'],
                        'tanggal_awal' => $tanggal,
                        'status' => 'posting',
                    ]);
                }
            }
        }

        $pemakaians = Pemakaian_peralatan::find($transaksi_id);

        // $kendaraan = Kendaraan::where('id', $pemakaians->id)->first();
        $parts = Detail_pemakaian::where('pemakaian_peralatan_id', $pemakaians->id)->get();

        return view('admin.pemakaian_peralatan.show', compact('parts', 'pemakaians'));
    }

    public function show($id)
    {

        $pemakaians = Pemakaian_peralatan::where('id', $id)->first();
        $pemakaian = Pemakaian_peralatan::find($id);

        $parts = Detail_pemakaian::where('pemakaian_peralatan_id', $pemakaian->id)->get();

        return view('admin.pemakaian_peralatan.show', compact('parts', 'pemakaians'));
    }

    public function cetakpdf($id)
    {
        $pemakaians = Pemakaian_peralatan::find($id);
        $parts = Detail_pemakaian::where('pemakaian_peralatan_id', $id)->get();
        // Load the view and set the paper size to portrait letter
        $pdf = PDF::loadView('admin.pemakaian_peralatan.cetak_pdf', compact('parts', 'pemakaians'));
        $pdf->setPaper('letter', 'portrait'); // Set the paper size to portrait letter

        return $pdf->stream('Surat_Pemasangan_Part.pdf');
    }

    public function kode()
    {
        $pemasangan = Pemakaian_peralatan::all();
        if ($pemasangan->isEmpty()) {
            $num = "000001";
        } else {
            $id = Pemakaian_peralatan::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'APR';
        $kode_pemasangan = $data . $num;
        return $kode_pemasangan;
    }

    public function destroy($id)
    {
        // Mencari data berdasarkan pemakaian_peralatan_id

        $part = Pemakaian_peralatan::find($id);
        $part = Detail_pembelianpart::find($id);
        $part->delete();
        return;
    }
}