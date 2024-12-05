<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Absen;
use App\Models\Karyawan;
use App\Models\Lokasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;


class AbsenController extends Controller
{

    public function add_absen(Request $request)
    {

        $lokasi = Lokasi::first();
        if (!$lokasi) {
            return response()->json([
                'status' => false,
                'msg' => 'Data lokasi tidak ditemukan.'
            ], 400);
        }

        // Ambil latitude dan longitude dari request dan database
        $requestLatitude = $request->latitude;
        $requestLongitude = $request->longitude;
        $radius = $lokasi->radius; // Ambil radius (jarak) dari tabel lokasi

        $lokasiLatitude = $lokasi->latitude;
        $lokasiLongitude = $lokasi->longitude;

        // Hitung jarak antara dua koordinat
        $distance = round($this->calculateDistance($requestLatitude, $requestLongitude, $lokasiLatitude, $lokasiLongitude), 2);

        // Periksa apakah jarak lebih dari 5 meter
        if ($distance > $radius) {
            return response()->json([
                'status' => false,
                'msg' => 'Gagal. Jarak Anda adalah ' . $distance . ' meter (radius: ' . $radius . ' meter).'

                // 'msg' => 'Anda terlalu jauh dari lokasi yang ditentukan. Jarak Anda adalah ' . $distance . ' meter (radius: ' . $radius . ' meter).'
            ], 200);
        }

        if (!$request->hasFile('gambar') || !$request->file('gambar')->isValid()) {
            return response()->json([
                'status' => false,
                'msg' => 'Gambar tidak valid.',
            ], 200);
        }

        $gambar = str_replace(' ', '', $request->file('gambar')->getClientOriginalName());
        $namagambar = 'absen/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;

        $request->file('gambar')->storeAs('public/uploads/', $namagambar);
        $waktuSekarang = Carbon::now()->format('H:i:s'); // Mengambil jam saat ini dalam format Jam:Menit:Detik

        $userId = $request->user_id;
        $user = User::where('id', $userId)->first();
        $karyawan = Karyawan::where('id', $user->karyawan_id)->first();
        
        $absen = Absen::create(array_merge(
            $request->all(),
            [
                'user_id' => $request->user_id,
                'karyawan_id' => $karyawan->id,
                'waktu' => $waktuSekarang,
                'gambar' => $namagambar,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'jarak_absen' => $distance,
                'tanggal_awal' => Carbon::now()->format('Y-m-d')
            ]
        ));

        if ($absen) {
            return response()->json([
                'status' => true,
                'msg' => 'Absen Berhasil',
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'msg' => 'Gagal',
            ], 200);
        }
    }


    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // Radius bumi dalam meter

        $lat1Rad = deg2rad($lat1);
        $lat2Rad = deg2rad($lat2);
        $deltaLat = deg2rad($lat2 - $lat1);
        $deltaLon = deg2rad($lon2 - $lon1);

        $a = sin($deltaLat / 2) * sin($deltaLat / 2) +
            cos($lat1Rad) * cos($lat2Rad) *
            sin($deltaLon / 2) * sin($deltaLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c; // Jarak dalam meter
    }


    public function response($status, $message, $data = null)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ]);
    }
}