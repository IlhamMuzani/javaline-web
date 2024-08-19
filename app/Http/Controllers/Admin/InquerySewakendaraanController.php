<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Models\Rute_perjalanan;
use App\Models\Sewa_kendaraan;
use App\Models\Vendor;
use Illuminate\Support\Facades\Validator;


class InquerySewakendaraanController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $sewa_kendaraans = Sewa_kendaraan::whereDate('created_at', $today)
            ->orWhere(function ($query) use ($today) {
                $query->where('status', 'unpost')
                    ->whereDate('created_at', '<', $today);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.inquery_sewakendaraan.index', compact('sewa_kendaraans'));
    }


    public function edit($id)
    {
        $inquery = Sewa_kendaraan::where('id', $id)->first();
        $ruteperjalanans = Rute_perjalanan::all();
        $pelanggans = Pelanggan::all();
        $vendors = Vendor::all();

        return view('admin.inquery_sewakendaraan.edit', compact('inquery', 'vendors', 'ruteperjalanans', 'pelanggans'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'vendor_id' => 'required',
                'rute_perjalanan_id' => 'required',
                'pelanggan_id' => 'required',
                'nama_driver' => 'required',
                'no_pol' => 'required',
            ],
            [
                'vendor_id' => 'pilih rekan',
                'rute_perjalanan_id' => 'pilih rute perjalanan',
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
        $sewa_kendaraan->rute_perjalanan_id = $request->rute_perjalanan_id;
        $sewa_kendaraan->pelanggan_id = $request->pelanggan_id;
        $sewa_kendaraan->nama_driver = $request->nama_driver;
        $sewa_kendaraan->telp_driver = $request->telp_driver;
        $sewa_kendaraan->no_pol = $request->no_pol;
        $sewa_kendaraan->nama_pelanggan = $request->nama_pelanggan;
        $sewa_kendaraan->nama_rute = $request->nama_rute;
        $sewa_kendaraan->nama_driver = $request->nama_driver;
        $sewa_kendaraan->status = 'posting';

        $sewa_kendaraan->save();

        return redirect('admin/inquery_sewakendaraan')->with('success', 'Berhasil memperbarui');
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