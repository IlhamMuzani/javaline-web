<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Harga_sewa;
use App\Models\Pelanggan;
use App\Models\Rute_perjalanan;
use App\Models\Sewa_kendaraan;
use App\Models\Vendor;
use Illuminate\Support\Facades\Validator;


class InquerySewakendaraanController extends Controller
{
    public function index(Request $request)
    {
        // Memperbaharui status_notif untuk entri yang memenuhi kriteria
        Sewa_kendaraan::where('status', 'posting')
        ->update(['status_notif' => true]);

        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        // Membuat query awal dengan kategori 'Mingguan'
        $inquery = Sewa_kendaraan::where('kategori', 'Mingguan');

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
            // Jika tidak ada filter tanggal, hanya mengambil hari ini
            $inquery->whereDate('tanggal_awal', Carbon::today());
        }

        // Menyusun hasil query
        $inquery->orderBy('id', 'DESC');
        $inquery = $inquery->get();

        return view('admin.inquery_sewakendaraan.index', compact('inquery'));
    }


    public function edit($id)
    {
        $inquery = Sewa_kendaraan::where('id', $id)->first();
        $ruteperjalanans = Rute_perjalanan::all();
        $pelanggans = Pelanggan::all();
        $vendors = Vendor::all();
        $harga_sewas = Harga_sewa::all();

        return view('admin.inquery_sewakendaraan.edit', compact('harga_sewas', 'inquery', 'vendors', 'ruteperjalanans', 'pelanggans'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'vendor_id' => 'required',
                // 'rute_perjalanan_id' => 'required',
                'pelanggan_id' => 'required',
                'nama_driver' => 'required',
                'no_pol' => 'required',
            ],
            [
                'vendor_id' => 'pilih rekan',
                // 'rute_perjalanan_id' => 'pilih rute perjalanan',
                'pelanggan_id' => 'pilih pelanggan',
                'nama_driver' => 'masukkan nama sopir',
                'no_pol' => 'masukkan no pol',
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }

        $sewa_kendaraan = Sewa_kendaraan::findOrFail($id);

        $sewa_kendaraan->vendor_id = $request->vendor_id;
        $sewa_kendaraan->kategori = $request->kategori;
        // $sewa_kendaraan->rute_perjalanan_id = $request->rute_perjalanan_id;
        $sewa_kendaraan->harga_sewa_id = $request->harga_sewa_id;
        $sewa_kendaraan->pelanggan_id = $request->pelanggan_id;
        $sewa_kendaraan->jumlah = $request->jumlah;
        $sewa_kendaraan->satuan = $request->satuan;
        $sewa_kendaraan->nama_driver = $request->nama_driver;
        $sewa_kendaraan->telp_driver = $request->telp_driver;
        $sewa_kendaraan->no_pol = $request->no_pol;
        $sewa_kendaraan->nama_pelanggan = $request->nama_pelanggan;
        $sewa_kendaraan->nama_rute = $request->nama_tarif;
        // $sewa_kendaraan->nominal = str_replace(',', '.', str_replace('.', '', $request->harga_sewa));
        $sewa_kendaraan->pph = str_replace(',', '.', str_replace('.', '', $request->pph));
        $sewa_kendaraan->harga_tarif = str_replace(',', '.', str_replace('.', '', $request->harga_tarif));
        $sewa_kendaraan->total_tarif = str_replace(',', '.', str_replace('.', '', $request->total_tarif));
        $sewa_kendaraan->grand_total = str_replace(',', '.', str_replace('.', '', $request->sub_total));
        $sewa_kendaraan->sisa = str_replace(',', '.', str_replace('.', '', $request->sisa));
        $sewa_kendaraan->biaya_tambahan =  str_replace(',', '.', str_replace('.', '', $request->biaya_tambahan));
        $sewa_kendaraan->nominal_potongan = str_replace(',', '.', str_replace('.', '', $request->nominal_potongan));
        $sewa_kendaraan->hasil_potongan =  str_replace(',', '.', str_replace('.', '', $request->hasil_potongan));
        $sewa_kendaraan->keterangan = $request->keterangan;

        $sewa_kendaraan->status = 'posting';

        $sewa_kendaraan->save();

        $cetakpdf = Sewa_kendaraan::where('id', $sewa_kendaraan->id)->first();

        return view('admin.inquery_sewakendaraan.show', compact('cetakpdf'));
    }

    public function show($id)
    {
        $cetakpdf = Sewa_kendaraan::where('id', $id)->first();

        return view('admin.inquery_sewakendaraan.show', compact('cetakpdf'));
    }

    public function kode()
    {
        $lastBarang = Sewa_kendaraan::where('kode_sewa', 'like', 'RK%')->latest()->first();
        $lastMonth = $lastBarang ? date('m', strtotime($lastBarang->created_at)) : null;
        $currentMonth = date('m');
        if (!$lastBarang || $currentMonth != $lastMonth) {
            $num = 1;
        } else {
            $lastCode = $lastBarang->kode_sewa;
            $parts = explode('/', $lastCode);
            $lastNum = end($parts);
            $num = (int) $lastNum + 1;
        }
        $formattedNum = sprintf("%03s", $num);
        $prefix = 'RK';
        $tahun = date('y');
        $tanggal = date('dm');
        $newCode = $prefix . "/" . $tanggal . $tahun . "/" . $formattedNum;
        return $newCode;
    }

    public function postingsewakendaraan($id)
    {
        $item = Sewa_kendaraan::where('id', $id)->first();

        $item->update([
            'status' => 'posting'
        ]);

        return response()->json(['success' => 'Berhasil memposting sewa kendaraan']);
    }

    public function unpostsewakendaraan($id)
    {
        $item = Sewa_kendaraan::where('id', $id)->first();

        $item->update([
            'status' => 'unpost'
        ]);

        return response()->json(['success' => 'Berhasil unpost sewa kendaraan']);
    }
}