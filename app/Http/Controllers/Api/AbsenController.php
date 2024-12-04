<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Absen;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;


class AbsenController extends Controller
{

    public function add_absen(Request $request)
    {

        if (!$request->hasFile('gambar') || !$request->file('gambar')->isValid()) {
            return response()->json([
                'status' => false,
                'msg' => 'Gambar tidak valid.',
            ], 200);
        }

        $gambar = str_replace(' ', '', $request->file('gambar')->getClientOriginalName());
        $namagambar = 'absen/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;

        $request->file('gambar')->storeAs('public/uploads/', $namagambar);

        $absen = Absen::create(array_merge(
            $request->all(),
            [
                'user_id' => $request->user_id,
                'waktu' => $request->waktu,
                'gambar' => $namagambar,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'tanggal_awal' => now()->format('Y-m-d H:i:s')
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

    public function response($status, $message, $data = null)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ]);
    }
}