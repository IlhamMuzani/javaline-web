<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use App\Models\Pelanggan;
use App\Models\Kota;
use Illuminate\Http\Request;
use App\Models\Laporanperjalanan;
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

    public function pelangganlist()
    {

        $pelanggan = Pelanggan::get();


        if (count($pelanggan) > 0) {
            return $this->response(TRUE, array('Berhasil menampilkan data'), $pelanggan);
        } else {
            return $this->response(FALSE, array('Gagal menampilkan data!'));
        }
    }

    public function kotalist()
    {

        $kota = Kota::get();


        if (count($kota) > 0) {
            return $this->response(TRUE, array('Berhasil menampilkan data'), $kota);
        } else {
            return $this->response(FALSE, array('Gagal menampilkan data!'));
        }
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

        $kendaraan = Kendaraan::where('id', $id);
        $proses = $kendaraan->update([
            'user_id' => $request->user_id,
            'status_perjalanan' => 'Tunggu Muat',
            'km' => $request->km,
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
        $tanggal = Carbon::now()->format('Y-m-d');
        $proses = $kendaraan->update([
            'user_id' => $request->user_id,
            'km' => $request->km,
            'status_perjalanan' => 'Perjalanan Isi',
            'timer' => $jarakWaktu,
            'tujuan' => $request->tujuan,
            'tanggal_awalperjalanan' => $tanggal,
            'tanggal_awalwaktuperjalanan' => Carbon::now('Asia/Jakarta'), // Menggunakan zona waktu Asia/Jakarta (WIB)

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

        if ($kendaraan) {
            $tanggal = Carbon::now()->format('Y-m-d');
            Laporanperjalanan::create([
                'kode_kendaraan' => $kendaraan->kode_kendaraan,
                'kendaraan_id' => $kendaraan->id,
                'user_id' => $kendaraan->user_id,
                'no_kabin' => $kendaraan->no_kabin,
                'no_pol' => $kendaraan->no_pol,
                'no_rangka' => $kendaraan->no_rangka,
                'no_mesin' => $kendaraan->no_mesin,
                'warna' => $kendaraan->warna,
                'km' => $kendaraan->km,
                'km_olimesin' => $kendaraan->km_olimesin,
                'km_oligardan' => $kendaraan->km_oligardan,
                'km_olitransmisi' => $kendaraan->km_olitransmisi,
                'expired_kir' => $kendaraan->expired_kir,
                'expired_stnk' => $kendaraan->expired_stnk,
                'jenis_kendaraan_id' => $kendaraan->jenis_kendaraan_id,
                'golongan_id' => $kendaraan->golongan_id,
                'divisi_id' => $kendaraan->divisi_id,
                'status' => $kendaraan->status,
                'qrcode_kendaraan' => $kendaraan->qrcode_kendaraan,
                'status_pemasangan' => $kendaraan->status_pemasangan,
                'kode_pemasangan' => $kendaraan->kode_pemasangan,
                'kode_pelepasan' => $kendaraan->kode_pelepasan,
                'tanggal' => $kendaraan->tanggal,
                'tanggal_awal' => $kendaraan->tanggal_awal,
                'tanggal_akhir' => $kendaraan->tanggal_akhir,
                'status_post' => $kendaraan->status_post,
                'status_notif' => $kendaraan->status_notif,
                'status_olimesin' => $kendaraan->status_olimesin,
                'status_oligardan' => $kendaraan->status_oligardan,
                'status_olitransmisi' => $kendaraan->status_olitransmisi,
                'status_notifkm' => $kendaraan->status_notifkm,
                'status_perjalanan' => $kendaraan->status_perjalanan,
                'tanggal_awalperjalanan' => $kendaraan->tanggal_awalperjalanan,
                'tanggal_akhirperjalanan' => $tanggal,
                'tanggal_awalwaktuperjalanan' => $kendaraan->tanggal_awalwaktuperjalanan,
                'tanggal_akhirwaktuperjalanan' => Carbon::now('Asia/Jakarta'), // Menggunakan zona waktu Asia/Jakarta (WIB)
                'timer' => $kendaraan->timer,
                'tujuan' => $kendaraan->tujuan,
                'pelanggan_id' => $kendaraan->pelanggan_id,
            ]);
        }

        // Format "hari jam:menit:detik"
        $jarakWaktu = $waktuTungguMuat->diff($waktuPerjalananIsi)->format('%d %H:%I');

        $kendaraan = Kendaraan::where('id', $id);
        $proses = $kendaraan->update([
            'user_id' => $request->user_id,
            'pelanggan_id' => null,
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