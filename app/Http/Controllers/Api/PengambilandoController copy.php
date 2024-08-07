<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use App\Models\Pengambilan_do;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PengambilandoController extends Controller
{

    public function list($id)
    {
        // Assuming you have a 'user_id' column in the Pengambilan_do table
        $pengambilando = Pengambilan_do::where([
            ['user_id', $id],
            ['status', '<>', 'unpost'] // Filter out entries where status is 'unpost'
        ])
            ->with(['kendaraan', 'rute_perjalanan', 'alamat_muat', 'alamat_bongkar'])
            ->get();

        if ($pengambilando->isNotEmpty()) { // Check if there are any records
            return $this->response(TRUE, ['Berhasil menampilkan data'], $pengambilando);
        } else {
            return $this->response(FALSE, ['Gagal menampilkan data!']);
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

    public function pengambilando_detail($id)
    {
        $pengambilan_do = Pengambilan_do::where('id', $id)
            ->with([
                'spk.pelanggan', // Include pelanggan through spk
                'user',
                'rute_perjalanan',
                'alamat_muat',
                'alamat_bongkar',
                'kendaraan'
            ])
            ->first();
        if ($pengambilan_do) {
            return response()->json([
                'status' => TRUE,
                'msg' => 'Berhasil',
                'pengambilan_do' => $pengambilan_do
            ]);
        } else {
            return response()->json([
                'status' => FALSE,
                'msg' => 'Error',
            ]);
        }
    }


    public function konfirmasi(Request $request, $id)
    {

        $pengambilan_do = Pengambilan_do::find($id);
        $proses = $pengambilan_do->update([
            'user_id' => $request->user_id,
            'status' => 'loading muat',
        ]);


        $waktuTungguMuat = $pengambilan_do->updated_at;
        $waktuPerjalananIsi = now();

        // Format "hari jam:menit:detik"
        $jarakWaktu = $waktuTungguMuat->diff($waktuPerjalananIsi)->format('%d %H:%I');

        $kendaraan = Kendaraan::where('id', $pengambilan_do->kendaraan_id);
        $proses = $kendaraan->update([
            'user_id' => $request->user_id,
            'status_perjalanan' => 'Perjalanan Kosong',
            'timer' => $jarakWaktu
        ]);


        if ($proses) {
            return response()->json([
                'status' => true,
                'msg' => 'Status Selesai',
            ]);
        } else {
            $this->error('Gagal !');
        }
    }

    public function batal_pengambilan(Request $request, $id)
    {
        $pengambilan_do = Pengambilan_do::find($id);

        $pengambilan_do = Pengambilan_do::where('id', $id);
        $proses = $pengambilan_do->update([
            'user_id' => $request->user_id,
            'status' => 'Posting',
        ]);

        if ($proses) {
            return response()->json([
                'status' => true,
                'msg' => 'Status Berhasil',
            ]);
        } else {
            $this->error('Gagal !');
        }
    }

    public function bukti_foto(Request $request, $id)
    {
        $pengambilan_do = Pengambilan_do::find($id);

        $bukti = str_replace(' ', '', $request->gambar->getClientOriginalName());
        $namabukti = 'pengambilan_do/' . date('mYdHs') . rand(1, 10) . '_' . $bukti;
        $request->gambar->storeAs('public/uploads/', $namabukti);

        $pengambilan_do = Pengambilan_do::where('id', $id);
        $proses = $pengambilan_do->update([
            'gambar' => $namabukti,
            'status' => 'tunggu bongkar',
        ]);

        $waktuTungguMuat = $pengambilan_do->updated_at;
        $waktuPerjalananIsi = now();

        // Format "hari jam:menit:detik"
        $jarakWaktu = $waktuTungguMuat->diff($waktuPerjalananIsi)->format('%d %H:%I');

        $kendaraan = Kendaraan::where('id', $pengambilan_do->kendaraan_id);
        $proses = $kendaraan->update([
            'status_perjalanan' => 'Tunggu Bongkar',
            'timer' => $jarakWaktu
        ]);

        if ($proses) {
            return response()->json([
                'status' => true,
                'msg' => 'Status Berhasil',
            ]);
        } else {
            $this->error('Gagal !');
        }
    }

    public function bukti_fotoselesai(Request $request, $id)
    {
        $pengambilan_do = Pengambilan_do::find($id);

        $bukti = str_replace(' ', '', $request->bukti->getClientOriginalName());
        $namabukti = 'bukti/' . date('mYdHs') . rand(1, 10) . '_' . $bukti;
        $request->bukti->storeAs('public/uploads/', $namabukti);

        $pengambilan_do = Pengambilan_do::where('id', $id);
        $proses = $pengambilan_do->update([
            'bukti' => $namabukti,
            'status' => 'loading bongkar',
        ]);

        $waktuTungguMuat = $pengambilan_do->updated_at;
        $waktuPerjalananIsi = now();
        // Format "hari jam:menit:detik"
        $jarakWaktu = $waktuTungguMuat->diff($waktuPerjalananIsi)->format('%d %H:%I');

        $kendaraan = Kendaraan::where('id', $pengambilan_do->kendaraan_id);
        $proses = $kendaraan->update([
            'status_perjalanan' => 'Loading Bongkar',
            'timer' => $jarakWaktu
        ]);


        if ($proses) {
            return response()->json([
                'status' => true,
                'msg' => 'Status Berhasil',
            ]);
        } else {
            $this->error('Gagal !');
        }
    }

    public function konfirmasi_selesai(Request $request, $id)
    {
        $pengambilan_do = Pengambilan_do::find($id);

        $pengambilan_do = Pengambilan_do::where('id', $id);
        $proses = $pengambilan_do->update([
            'user_id' => $request->user_id,
            'status' => 'selesai',
        ]);

        if ($proses) {
            return response()->json([
                'status' => true,
                'msg' => 'Status Berhasil',
            ]);
        } else {
            $this->error('Gagal !');
        }
    }

    // public function bukti_foto(Request $request, $id)
    // {
    //     $pengambilan_do = Pengambilan_do::find($id);

    //     if ($request->file('gambar')->isValid()) {
    //         $gambar = $request->file('gambar');
    //         $extention = $gambar->getClientOriginalExtension();
    //         $namaFoto = "pengambilan_do/" . date('ymdHis') . "." . $extention;
    //         $upload_path = 'public/storage/uploads/pengambilan_do';
    //         $request->file('gambar')->move($upload_path, $namaFoto);
    //     }

    //     $pengambilan_do = Pengambilan_do::where('id', $id);
    //     $proses = $pengambilan_do->update([
    //         'gambar' => $namaFoto,
    //         'status' => 'loading bongkar',
    //     ]);

    //     if ($proses) {
    //         return response()->json([
    //             'status' => true,
    //             'msg' => 'Status Berhasil',
    //         ]);
    //     } else {
    //         $this->error('Gagal !');
    //     }
    // }

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