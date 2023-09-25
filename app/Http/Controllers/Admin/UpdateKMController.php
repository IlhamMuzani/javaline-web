<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Kendaraan;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UpdateKMController extends Controller
{
    public function index()
    {
        if (auth()->check() && auth()->user()->menu['update km']) {
            $kms = Kendaraan::all();
            return view('admin/update_km.index', compact('kms'));
        } else {
            // tidak memiliki akses
            return back()->with('error', 'Anda tidak memiliki akses');
        }
    }

    public function store(Request $request)
    {

        $nomorKabin = $request->input('kendaraan_id');
        
        $kendaraan = Kendaraan::where('id', $nomorKabin)->first();

        // if (!$kendaraan) {
        //     return response()->json(['Pesan' => 'Pilih no kabin'], 404);
        // }

        $validator = Validator::make(
            $request->all(),
            [
                'kendaraan_id' => 'required',
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
                'kendaraan_id.required' => 'Pilih no kabin !',
                'km.required' => 'Masukkan nilai km',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        LogAktivitas::create([
            'user_id' => auth()->user()->id,
            'kendaraan_id' => $kendaraan->id,
            'km_update' => $request->km,
            'tanggal' => Carbon::now('Asia/Jakarta'), // Menggunakan zona waktu Asia/Jakarta (WIB)
            'action' => 'update_km',
        ]);

        $tanggal = Carbon::now()->format('Y-m-d');
        Kendaraan::where('id', $kendaraan->id)->update(
            [
                'nama_security' => auth()->user()->karyawan->nama_lengkap,
                'km' => $request->km,
                'tanggal' => Carbon::now('Asia/Jakarta'),
                'tanggal_awal' => $tanggal,
                'status_post' => 'posting',
                'status_notif' => false
            ]
        );
        return back()->with('success', 'Kilo meter berhasil terupdate');
    }
}