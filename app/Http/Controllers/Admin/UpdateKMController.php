<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Kendaraan;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ban;
use App\Models\Jarak_km;
use Illuminate\Support\Facades\DB;
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
        $jarak = Jarak_km::first();

        $validator = Validator::make(
            $request->all(),
            [
                'kendaraan_id' => 'required',
                'km' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($kendaraan, $jarak) {
                        if ($value <= $kendaraan->km) {
                            $fail('Nilai km akhir harus lebih tinggi dari km awal');
                        } elseif ($value - $kendaraan->km > $jarak->batas) {
                            $fail('Nilai km tidak boleh lebih dari ' . $jarak->batas . ' km dari km awal.');
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

        $tanggal = Carbon::now()->format('Y-m-d');
        $kendaraan = Kendaraan::findOrFail($kendaraan->id);

        LogAktivitas::create([
            'user_id' => auth()->user()->id,
            'kendaraan_id' => $kendaraan->id,
            'km_update' => $request->km,
            'tanggal' => Carbon::now('Asia/Jakarta'), // Menggunakan zona waktu Asia/Jakarta (WIB)
            'action' => 'update_km',
            'tanggal_awal' => $tanggal,
            'status_notif' => false,
            'status' => 'posting'
        ]);

        $kendaraan->nama_security = auth()->user()->karyawan->nama_lengkap;
        $kendaraan->km = $request->km;
        $kendaraan->tanggal = Carbon::now('Asia/Jakarta');
        $kendaraan->tanggal_awal = $tanggal;
        $kendaraan->status_post = 'posting';
        $kendaraan->status_notif = false;

        $kms = $request->km;

        // Periksa apakah selisih kurang dari 1000 atau lebih tinggi dari km_olimesin
        if ($kms > $kendaraan->km_olimesin - 1000 || $kms > $kendaraan->km_olimesin) {
            $status_olimesins = "belum penggantian";
            $kendaraan->status_olimesin = $status_olimesins;
        }

        if ($kms > $kendaraan->km_oligardan - 5000 || $kms > $kendaraan->km_oligardan) {
            $status_olimesins = "belum penggantian";
            $kendaraan->status_oligardan = $status_olimesins;
        }

        if ($kms > $kendaraan->km_olitransmisi - 5000 || $kms > $kendaraan->km_olitransmisi) {
            $status_olimesins = "belum penggantian";
            $kendaraan->status_olitransmisi = $status_olimesins;
        }

        // Update umur_ban for related ban
        foreach ($kendaraan->ban as $ban) {
            $ban->update([
                'umur_ban' => ($kms - $ban->km_pemasangan) + ($ban->jumlah_km ?? 0)
            ]);
        }

        // Simpan perubahan
        $kendaraan->save();

        return back()->with('success', 'Kilo meter berhasil terupdate');
    }
}