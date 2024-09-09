<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Jarak_km;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KendaraanController extends Controller
{
    public function listAll()
    {
        $kendaraan = Kendaraan::get();

        if (count($kendaraan) > 0) {
            return $this->response(TRUE, array('Berhasil menampilkan data'), $kendaraan);
        } else {
            return $this->response(FALSE, array('Gagal menampilkan data!'));
        }
    }

    public function list($id)
    {
        // Assuming you have a 'user_id' column in the Kendaraan table
        $kendaraan = Kendaraan::where('user_id', $id)->get();

        if (count($kendaraan) > 0) {
            return $this->response(TRUE, array('Berhasil menampilkan data'), $kendaraan);
        } else {
            return $this->response(FALSE, array('Gagal menampilkan data!'));
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

    public function kendaraan_search(Request $request)
    {
        $filterKeyword = $request->get('keyword');
        $kendaraan = Kendaraan::where([
            ['status', '!=', 'mobil'],
            ['no_kabin', 'LIKE', "%$filterKeyword%"],

        ])->get();

        if (count($kendaraan) > 0) {
            return $this->response(TRUE, array('Berhasil menampilkan data'), $kendaraan);
        } else {
            return $this->response(FALSE, array('Gagal menampilkan data!'));
        }
    }

    public function detail($id)
    {
        $kendaraans = Kendaraan::find($id);

        if ($kendaraans) {
            return $this->response(TRUE, array('Berhasil menampilkan data'), array($kendaraans));
        } else {
            return $this->response(FALSE, array('Gagal menampilkan data!'));
        }
    }

    public function update(Request $request, $id)
    {
        $km = Kendaraan::findOrFail($id);

        $jarak = Jarak_km::first();

        $validator = Validator::make(
            $request->all(),
            [
                'km' => [
                    'required',
                    'numeric',
                    'min:' . ($km->km + 1),
                    function ($attribute, $value, $fail) use ($km, $jarak) {
                        if ($value - $km->km > $jarak->batas) {
                            $fail('Nilai km baru tidak boleh lebih dari ' . $jarak->batas . ' km dari km awal.');
                        }
                    },
                ],
            ],
            [
                'km.required' => 'Masukkan nilai km',
                'km.numeric' => 'Nilai Km harus berupa angka',
                'km.min' => 'Nilai Km harus lebih tinggi dari Km awal',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return $this->response(FALSE, $error);
        }

        $data = Kendaraan::where('id', $id)->first();

        $reports = Kendaraan::where('id', $id)->update([
            'km' => $request->km,
        ]);

        if ($reports) {
            return $this->response(TRUE, array('Berhasil memperbarui data'));
        } else {
            return $this->response(FALSE, array('Gagal memperbarui data!'));
        }
    }
}