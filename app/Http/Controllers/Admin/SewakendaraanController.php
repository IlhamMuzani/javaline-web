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


class SewakendaraanController extends Controller
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

        return view('admin.sewa_kendaraan.index', compact('sewa_kendaraans'));
    }


    public function create()
    {
        $today = Carbon::today();

        $ruteperjalanans = Rute_perjalanan::all();
        $pelanggans = Pelanggan::all();
        $vendors = Vendor::all();

        return view('admin.sewa_kendaraan.create', compact('vendors', 'ruteperjalanans', 'pelanggans'));
    }

    public function store(Request $request)
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

        $kode = $this->kode();

        Sewa_kendaraan::create(array_merge(
            $request->all(),
            [
                'kode_sewa' => $this->kode(),
                'admin' => auth()->user()->karyawan->nama_lengkap,
                'nama_pelanggan' => $request->nama_pelanggan,
                'nama_rute' => $request->nama_rute,
                'nama_driver' =>$request->nama_driver,
                'qrcode_sewa' => 'https://javaline.id/sewa_kendaraan/' . $kode,
                'tanggal_awal' => Carbon::now('Asia/Jakarta'),
                'status' => 'posting',
            ],
        ));
        return redirect('admin/sewa_kendaraan')->with('success', 'Berhasil menambahkan');
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
}