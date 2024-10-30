<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Alamat_bongkar;
use App\Models\Pelanggan;
use App\Models\Vendor;
use Illuminate\Support\Facades\Validator;

class AlamatbongkarController extends Controller
{
    public function index()
    {
        $alamatbongkars = Alamat_bongkar::all();
        return view('admin.alamat_bongkar.index', compact('alamatbongkars'));
    }

    public function create()
    {
        $pelanggans = Pelanggan::get();
        $vendors = Vendor::get();
        return view('admin.alamat_bongkar.create', compact('pelanggans', 'vendors'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'alamat' => 'required',
                'latitude' => 'required',
            ],
            [
                'alamat.required' => 'Masukkan tujuan bongkar',
                'latitude.required' => 'Pilih titik tujuan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kode = $this->kode();

        Alamat_bongkar::create(array_merge(
            $request->all(),
            [
                'kode_alamat' => $this->kode(),
                'tanggal_awal' => Carbon::now('Asia/Jakarta'),
                'alamat' => $request->alamat,
                'nama_lokasi' => $request->nama_lokasi,
                'telp' => $request->telp,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ],
        ));

        return redirect('admin/alamat_bongkar')->with('success', 'Berhasil menambahkan tujuan bongkar');
    }

    public function kode()
    {
        $lastBarang = Alamat_bongkar::latest()->first();
        if (!$lastBarang) {
            $num = 1;
        } else {
            $lastCode = $lastBarang->kode_alamat;
            $num = (int) substr($lastCode, strlen('AAB')) + 1;
        }
        $formattedNum = sprintf("%06s", $num);
        $prefix = 'AAB';
        $newCode = $prefix . $formattedNum;
        return $newCode;
    }

    public function edit($id)
    {
        $alamatbongkars = Alamat_bongkar::where('id', $id)->first();
        $pelanggans = Pelanggan::get();
        $vendors = Vendor::get();
        return view('admin/alamat_bongkar.update', compact('alamatbongkars', 'pelanggans', 'vendors'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'alamat' => 'required',
                'latitude' => 'required',
            ],
            [
                'alamat.required' => 'Masukkan tujuan bongkar',
                'latitude.required' => 'Pilih titik tujuan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $alamatbongkars = Alamat_bongkar::findOrFail($id);

        $alamatbongkars->pelanggan_id = $request->pelanggan_id;
        $alamatbongkars->alamat = $request->alamat;
        $alamatbongkars->nama_lokasi = $request->nama_lokasi;
        $alamatbongkars->telp = $request->telp;
        $alamatbongkars->latitude = $request->latitude;
        $alamatbongkars->longitude = $request->longitude;

        $alamatbongkars->save();

        return redirect('admin/alamat_bongkar')->with('success', 'Berhasil memperbarui tujuan bongkar');
    }

    public function destroy($id)
    {
        $alamatbongkars = Alamat_bongkar::find($id);
        $alamatbongkars->delete();

        return redirect('admin/alamat_bongkar')->with('success', 'Berhasil menghapus tujuan bongkar');
    }
}