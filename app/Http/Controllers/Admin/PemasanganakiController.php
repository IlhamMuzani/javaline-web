<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Kendaraan;
use App\Models\Aki;
use Illuminate\Http\Request;
use App\Models\Pemasangan_aki;
use App\Http\Controllers\Controller;
use App\Models\Detail_pemasanganaki;
use Illuminate\Support\Facades\Validator;

class PemasanganakiController extends Controller
{

    public function index()
    {
        $today = Carbon::today();

        $inquery = Pemasangan_aki::whereDate('created_at', $today)
            ->orWhere(function ($query) use ($today) {
                $query->where('status', 'unpost')
                    ->whereDate('created_at', '<', $today);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.pemasangan_aki.index', compact('inquery'));
    }

    public function create()
    {
        if (auth()->check() && auth()->user()->menu['pemasangan part']) {

            $kendaraans = Kendaraan::all();
            $spareparts = Aki::where('status_aki', 'stok')->get();

            return view('admin.pemasangan_aki.create', compact('kendaraans', 'spareparts'));
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

        if ($request->has('aki_id')) {
            for ($i = 0; $i < count($request->aki_id); $i++) {
                $validasi_produk = Validator::make($request->all(), [
                    'aki_id.' . $i => 'required',
                    'kode_aki.' . $i => 'required',
                    'merek.' . $i => 'required',
                    'keterangan.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Pemasangan Aki nomor " . $i + 1 . " belum dilengkapi!");
                }

                $aki_id = is_null($request->aki_id[$i]) ? '' : $request->aki_id[$i];
                $kode_aki = is_null($request->kode_aki[$i]) ? '' : $request->kode_aki[$i];
                $merek = is_null($request->merek[$i]) ? '' : $request->merek[$i];
                $keterangan = is_null($request->keterangan[$i]) ? '' : $request->keterangan[$i];

                $data_pembelians->push(['aki_id' => $aki_id, 'kode_aki' => $kode_aki, 'merek' => $merek, 'keterangan' => $keterangan]);
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

        // format tanggal indo
        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');

        $tanggal = Carbon::now()->format('Y-m-d');
        $transaksi = Pemasangan_aki::create([
            'user_id' => auth()->user()->id,
            'kode_pemasanganaki' => $this->kode(),
            'kendaraan_id' => $request->kendaraan_id,
            'tanggal_pemasangan' => $format_tanggal,
            'tanggal_awal' => $tanggal,
            'status' => 'posting',
            'status_notif' => false,
        ]);

        $transaksi_id = $transaksi->id;

        if ($transaksi) {
            foreach ($data_pembelians as $data_pesanan) {
                $sparepart = Aki::find($data_pesanan['aki_id']);
                if ($sparepart) {
                    // Membuat Detail_pemasanganaki
                    Detail_pemasanganaki::create([
                        'pemasangan_aki_id' => $transaksi->id,
                        'aki_id' => $data_pesanan['aki_id'],
                        'kode_aki' => $data_pesanan['kode_aki'],
                        'merek' => $data_pesanan['merek'],
                        'tanggal_awal' => Carbon::now('Asia/Jakarta'),
                        'keterangan' => $data_pesanan['keterangan'],
                    ]);
                    $akis = Aki::find($data_pesanan['aki_id']);
                    $akis->update(['status_aki' => 'aktif']);
                }
            }
        }

        $cetakpdf = Pemasangan_aki::find($transaksi_id);
        $details = Detail_pemasanganaki::where('pemasangan_aki_id', $cetakpdf->id)->get();

        return view('admin.pemasangan_aki.show', compact('details', 'cetakpdf'));
    }

    public function show($id)
    {

        $pemasangan_aki = Pemasangan_aki::find($id);
        $details = Detail_pemasanganaki::where('pemasangan_aki_id', $pemasangan_aki->id)->get();


        $cetakpdf = Pemasangan_aki::where('id', $id)->first();

        return view('admin.pemasangan_aki.show', compact('details', 'cetakpdf'));
    }

    public function cetakpdf($id)
    {
        if (auth()->check() && auth()->user()->menu['pemasangan part']) {

            $cetakpdf = Pemasangan_aki::find($id);
            $details = Detail_pemasanganaki::where('pemasangan_aki_id', $id)->get();
            // Load the view and set the paper size to portrait letter
            $pdf = PDF::loadView('admin.pemasangan_aki.cetak_pdf', compact('details', 'cetakpdf'));
            $pdf->setPaper('letter', 'portrait'); // Set the paper size to portrait letter

            return $pdf->stream('Surat_Pemasangan_Aki.pdf');
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function kode()
    {
        $pemasangan = Pemasangan_aki::all();
        if ($pemasangan->isEmpty()) {
            $num = "000001";
        } else {
            $id = Pemasangan_aki::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'PS';
        $kode_pemasangan = $data . $num;
        return $kode_pemasangan;
    }

    public function destroy($id)
    {
        // Mencari data berdasarkan pemasangan_aki_id

        $part = Pemasangan_aki::find($id);
        $part = Detail_pemasanganaki::find($id);
        $part->delete();
        return;
    }
}