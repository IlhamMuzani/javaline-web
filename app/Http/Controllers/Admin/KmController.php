<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Divisi;
use App\Models\Golongan;
use App\Models\Jenis_kendaraan;
use App\Models\Kendaraan;
use App\Models\LogAktivitas;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class KmController extends Controller
{
    public function index()
    {
        if (auth()->check() && auth()->user()->menu['update km']) {
            $kms = Kendaraan::all();
            $km = null; // Set $km to the first vehicle, you can adjust this as needed
            return view('admin/update_km.index', compact('kms', 'km'));
        } else {
            // tidak memiliki akses
            return back()->with('error', 'Anda tidak memiliki akses');
        }
    }

    public function create()
    {

        if (auth()->check() && auth()->user()->menu['update km']) {

            $kms = Kendaraan::all();
            return view('admin/update_km.create', compact('kms'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function edit($id)
    {
        if (auth()->check() && auth()->user()->menu['update km']) {

            $km = Kendaraan::where('id', $id)->first();
            return view('admin/update_km.update', compact('km'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function store(Request $request)
    {
        $kendaraan = $request->kendaraan_id;
        $km = $request->km;

        session(['kendaraan' => $kendaraan, 'km' => $km]);

        return redirect()->route('admin/km/' . $kendaraan);
    }

    public function update(Request $request, $id)
    {
        $km = Kendaraan::findOrFail($id);

        $validator = Validator::make(
            $request->all(),
            [
                // 'km' => 'required|numeric|min:' . ($km->km + 1), cara kedua
                'km' => 'required',
                'km' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($km) {
                        if ($value <= $km->km) {
                            $fail('Nilai km akhir harus lebih tinggi dari km awal');
                        }
                    },
                ],
            ],
            [
                'km.required' => 'Masukkan nilai km',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        LogAktivitas::create([
            'user_id' => auth()->user()->id,
            'kendaraan_id' => $km->id,
            'km_update' => $request->km,
            'tanggal' => Carbon::now('Asia/Jakarta'), // Menggunakan zona waktu Asia/Jakarta (WIB)
            'action' => 'update_km',
        ]);

        $tanggal = Carbon::now()->format('Y-m-d');
        Kendaraan::where('id', $km->id)->update(
            [
                'km' => $request->km,
                'tanggal' => Carbon::now('Asia/Jakarta'),
                'tanggal_awal' => $tanggal
            ]
        );
        return redirect('admin/km')->with('success', 'Kilo meter berhasil terupdate');
    }

    public function updateKM(Request $request, $id)
    {
        $km = Kendaraan::findOrFail($id);

        $validator = Validator::make(
            $request->all(),
            [
                'km' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($km) {
                        if ($value <= $km->km) {
                            $fail('Nilai km akhir harus lebih tinggi dari km awal');
                        }
                    },
                ],
            ],
            [
                'km.required' => 'Masukkan nilai km',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        LogAktivitas::create([
            'user_id' => auth()->user()->id,
            'kendaraan_id' => $km->id,
            'km_update' => $request->km,
            'tanggal' => Carbon::now('Asia/Jakarta'),
            'action' => 'update_km',
        ]);

        $tanggal = Carbon::now()->format('Y-m-d');
        Kendaraan::where('id', $km->id)->update([
            'km' => $request->km,
            'tanggal' => Carbon::now('Asia/Jakarta'),
            'tanggal_awal' => $tanggal
        ]);

        return redirect('admin/km')->with('success', 'Kilo meter berhasil terupdate');
    }

    public function kendaraan($id)
    {
        $kendaraan = Kendaraan::where('id', $id)->with('jenis_kendaraan')->first();

        return json_decode($kendaraan);
    }
}