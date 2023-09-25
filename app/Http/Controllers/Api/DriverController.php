<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class DriverController extends Controller
{

    public function response($status, $message, $data = null)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ]);
    }

    public function tunggu_muat(Request $request, $id)
    {
        $km = Kendaraan::findOrFail($id);

        $validator = Validator::make(
            $request->all(),
            [
                'km' => 'required|numeric|min:' . ($km->km + 1),
            ],
            [
                'km.required' => 'Masukkan nilai km',
                'km.numeric' => 'Nilai Km harus berupa angka',
                'km.min' => 'Nilai Km harus lebih tinggi dari Km awal',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return $this->error($error);
        }

        $kendaraan = Kendaraan::find($id);

        $waktuTungguMuat = $kendaraan->updated_at;
        $waktuPerjalananIsi = now();

        // Format "hari jam:menit:detik"
        $jarakWaktu = $waktuTungguMuat->diff($waktuPerjalananIsi)->format('%d %H:%I');

        $tanggal = Carbon::now()->format('Y-m-d');
        $kendaraan = Kendaraan::where('id', $id);
        $proses = $kendaraan->update([
            'user_id' => $request->user_id,
            'status_perjalanan' => 'Tunggu Muat',
            'km' => $request->km,
            'tanggal_awalperjalanan' => $tanggal,
            'timer' => $jarakWaktu,
        ]);

        if ($proses) {
            return response()->json([
                'status' => true,
                'msg' => 'Status Tunggu Muat',
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'msg' => 'Gagal',
            ], 200);
        }
    }

    public function loading_muat(Request $request, $id)
    {
        $kendaraan = Kendaraan::find($id);

        $waktuTungguMuat = $kendaraan->updated_at;
        $waktuPerjalananIsi = now();

        // Format "hari jam:menit:detik"
        $jarakWaktu = $waktuTungguMuat->diff($waktuPerjalananIsi)->format('%d %H:%I');

        $kendaraan = Kendaraan::where('id', $id);
        $proses = $kendaraan->update([
            'user_id' => $request->user_id,
            'status_perjalanan' => 'Loading Muat',
            'timer' => $jarakWaktu,
            'pelanggan_id' => $request->pelanggan_id,
        ]);

        if ($proses) {
            return response()->json([
                'status' => true,
                'msg' => 'Status Loading Muat',
            ]);
        } else {
            $this->error('Gagal !');
        }
    }

    public function perjalanan_isi(Request $request, $id)
    {

        $km = Kendaraan::findOrFail($id);

        $validator = Validator::make(
            $request->all(),
            [
                'km' => 'required|numeric|min:' . ($km->km + 1),
                'tujuan' => 'required',
            ],
            [
                'km.required' => 'Masukkan nilai km',
                'km.numeric' => 'Nilai Km harus berupa angka',
                'km.min' => 'Nilai Km harus lebih tinggi dari Km awal',
                'tujuan.required' => 'Pilih tujuan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return $this->error($error);
        }

        $kendaraan = Kendaraan::find($id);

        $waktuTungguMuat = $kendaraan->updated_at;
        $waktuPerjalananIsi = now();

        // Format "hari jam:menit:detik"
        $jarakWaktu = $waktuTungguMuat->diff($waktuPerjalananIsi)->format('%d %H:%I');

        $kendaraan = Kendaraan::where('id', $id);
        $proses = $kendaraan->update([
            'user_id' => $request->user_id,
            'km' => $request->km,
            'status_perjalanan' => 'Perjalanan Isi',
            'timer' => $jarakWaktu,
            'tujuan' => $request->tujuan
        ]);

        if ($proses) {
            return response()->json([
                'status' => true,
                'msg' => 'Status Perjalanan Isi',
            ]);
        } else {
            $this->error('Gagal !');
        }
    }

    public function tunggu_bongkar(Request $request, $id)
    {
        $km = Kendaraan::findOrFail($id);

        $validator = Validator::make(
            $request->all(),
            [
                'km' => 'required|numeric|min:' . ($km->km + 1),
            ],
            [
                'km.required' => 'Masukkan nilai km',
                'km.numeric' => 'Nilai Km harus berupa angka',
                'km.min' => 'Nilai Km harus lebih tinggi dari Km awal',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return $this->error($error);
        }

        $kendaraan = Kendaraan::find($id);

        $waktuTungguMuat = $kendaraan->updated_at;
        $waktuPerjalananIsi = now();

        // Format "hari jam:menit:detik"
        $jarakWaktu = $waktuTungguMuat->diff($waktuPerjalananIsi)->format('%d %H:%I');

        $kendaraan = Kendaraan::where('id', $id);
        $proses = $kendaraan->update([
            'user_id' => $request->user_id,
            'km' => $request->km,
            'status_perjalanan' => 'Tunggu Bongkar',
            'timer' => $jarakWaktu
        ]);

        if ($proses) {
            return response()->json([
                'status' => true,
                'msg' => 'Status Tunggu Bongkar',
            ]);
        } else {
            $this->error('Gagal !');
        }
    }

    public function loading_bongkar(Request $request, $id)
    {

        $kendaraan = Kendaraan::find($id);

        $waktuTungguMuat = $kendaraan->updated_at;
        $waktuPerjalananIsi = now();

        // Format "hari jam:menit:detik"
        $jarakWaktu = $waktuTungguMuat->diff($waktuPerjalananIsi)->format('%d %H:%I');

        $kendaraan = Kendaraan::where('id', $id);
        $proses = $kendaraan->update([
            'user_id' => $request->user_id,
            'status_perjalanan' => 'Loading Bongkar',
            'timer' => $jarakWaktu
        ]);

        if ($proses) {
            return response()->json([
                'status' => true,
                'msg' => 'Status Loading Bongkar',
            ]);
        } else {
            $this->error('Gagal !');
        }
    }

    public function perjalanan_kosong(Request $request, $id)
    {
        $km = Kendaraan::findOrFail($id);

        $validator = Validator::make(
            $request->all(),
            [
                'km' => 'required|numeric|min:' . ($km->km + 1),
                'tujuan' => 'required',
            ],
            [
                'km.required' => 'Masukkan nilai km',
                'km.numeric' => 'Nilai Km harus berupa angka',
                'km.min' => 'Nilai Km harus lebih tinggi dari Km awal',
                'tujuan.required' => 'Pilih tujuan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return $this->error($error);
        }

        $kendaraan = Kendaraan::find($id);

        $waktuTungguMuat = $kendaraan->updated_at;
        $waktuPerjalananIsi = now();

        // Format "hari jam:menit:detik"
        $jarakWaktu = $waktuTungguMuat->diff($waktuPerjalananIsi)->format('%d %H:%I');

        $kendaraan = Kendaraan::where('id', $id);
        $proses = $kendaraan->update([
            'user_id' => $request->user_id,
            'km' => $request->km,
            'status_perjalanan' => 'Perjalanan Kosong',
            'timer' => $jarakWaktu,
            'tujuan' => $request->tujuan
        ]);

        if ($proses) {
            return response()->json([
                'status' => true,
                'msg' => 'Status Perjalanan Kosong',
            ]);
        } else {
            $this->error('Gagal !');
        }
    }

    public function perbaikan_digarasi(Request $request, $id)
    {
        $km = Kendaraan::findOrFail($id);

        $validator = Validator::make(
            $request->all(),
            [
                'km' => 'required|numeric|min:' . ($km->km + 1),
            ],
            [
                'km.required' => 'Masukkan nilai km',
                'km.numeric' => 'Nilai Km harus berupa angka',
                'km.min' => 'Nilai Km harus lebih tinggi dari Km awal',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return $this->error($error);
        }

        $kendaraan = Kendaraan::find($id);

        $waktuTungguMuat = $kendaraan->updated_at;
        $waktuPerjalananIsi = now();

        // Format "hari jam:menit:detik"
        $jarakWaktu = $waktuTungguMuat->diff($waktuPerjalananIsi)->format('%d %H:%I');

        $kendaraan = Kendaraan::where('id', $id);
        $proses = $kendaraan->update([
            'user_id' => $request->user_id,
            'km' => $request->km,
            'status_perjalanan' => 'Perbaikan di garasi',
            'timer' => $jarakWaktu
        ]);

        if ($proses) {
            return response()->json([
                'status' => true,
                'msg' => 'Perbaikan di garasi',
            ]);
        } else {
            $this->error('Gagal !');
        }
    }

    public function perbaikan_dijalan(Request $request, $id)
    {
        $km = Kendaraan::findOrFail($id);

        $validator = Validator::make(
            $request->all(),
            [
                'km' => 'required|numeric|min:' . ($km->km + 1),
            ],
            [
                'km.required' => 'Masukkan nilai km',
                'km.numeric' => 'Nilai Km harus berupa angka',
                'km.min' => 'Nilai Km harus lebih tinggi dari Km awal',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return $this->error($error);
        }

        $kendaraan = Kendaraan::find($id);

        $waktuTungguMuat = $kendaraan->updated_at;
        $waktuPerjalananIsi = now();

        // Format "hari jam:menit:detik"
        $jarakWaktu = $waktuTungguMuat->diff($waktuPerjalananIsi)->format('%d %H:%I');

        $kendaraan = Kendaraan::where('id', $id);
        $proses = $kendaraan->update([
            'user_id' => $request->user_id,
            'km' => $request->km,
            'status_perjalanan' => 'Perbaikan di jalan',
            'timer' => $jarakWaktu
        ]);

        if ($proses) {
            return response()->json([
                'status' => true,
                'msg' => 'Perbaikan di jalan',
            ]);
        } else {
            $this->error('Gagal !');
        }
    }

    public function kendaraan_detail($id)
    {
        $kendaraan = Kendaraan::where('id', $id)->with('user')->first();
        if ($kendaraan) {
            return response()->json([
                'status' => TRUE,
                'msg' => 'Berhasil',
                'kendaraan' => $kendaraan
            ]);
        } else {
            return response()->json([
                'status' => FALSE,
                'msg' => 'Error',
            ]);
        }
    }

    public function error($message)
    {
        return response()->json([
            'status' => FALSE,
            'msg' => $message,
        ]);
    }
}