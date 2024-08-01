<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pengambilan_do;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PengambilandoController extends Controller
{

    public function list($id)
    {
        // Assuming you have a 'user_id' column in the Pengambilan_do table
        $pengambilando = Pengambilan_do::where('user_id', $id)->with('kendaraan', 'rute_perjalanan', 'alamat_muat', 'alamat_bongkar')->get();

        if (count($pengambilando) > 0) {
            return $this->response(TRUE, array('Berhasil menampilkan data'), $pengambilando);
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
        $kendaraan = Pengambilan_do::where([
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
        $kendaraans = Pengambilan_do::find($id);

        if ($kendaraans) {
            return $this->response(TRUE, array('Berhasil menampilkan data'), array($kendaraans));
        } else {
            return $this->response(FALSE, array('Gagal menampilkan data!'));
        }
    }

    public function update(Request $request, $id)
    {
        $km = Pengambilan_do::findOrFail($id);

        $validator = Validator::make(
            $request->all(),
            [
                'km' => 'required',
                'km' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($km) {
                        if ($value <= $km->km) {
                            $fail('Nilai Km harus lebih tinggi dari Km awal');
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
            return $this->response(FALSE, $error);
        }

        $data = Pengambilan_do::where('id', $id)->first();

        $reports = Pengambilan_do::where('id', $id)->update([
            'km' => $request->km,
        ]);

        if ($reports) {
            return $this->response(TRUE, array('Berhasil memperbarui data'));
        } else {
            return $this->response(FALSE, array('Gagal memperbarui data!'));
        }
    }

}