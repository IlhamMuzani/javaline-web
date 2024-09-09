<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Jarak_km;
use App\Models\Karyawan;
use App\Models\Kendaraan;
use App\Models\Pelanggan;
use App\Models\Kota;
use App\Models\Pengambilan_do;
use Illuminate\Http\Request;
use App\Models\Timer;
use App\Models\User;
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

    public function update_profile(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'nama_kecil' => 'required',
                'telp' => 'required',
            ],
            [
                'nama_kecil.required' => 'Masukkan nama lengkap',
                'telp.required' => 'Masukkan telp',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return $this->error($error);
        }

        $karyawan = Karyawan::find($id);
        $karyawan = Karyawan::where('id', $id);
        $kendaraan = $karyawan->update([
            'nama_kecil' => $request->nama_lengkap,
            'telp' => $request->telp,
        ]);

        if ($kendaraan) {
            return response()->json([
                'status' => true,
                'msg' => 'Profil berhasil di perbarui',
            ]);
        } else {
            $this->error('Gagal !');
        }
    }

    public function update_password(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6|confirmed'
        ], [
            'password.required' => 'Password tidak boleh kosong!',
            'password.min' => 'Password minimal 6 karakter!',
            'password.confirmed' => 'Konfirmasi password tidak sesuai!',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return $this->error($error);
        }

        $user = User::where('id', $id)
            ->update([
                'password' => bcrypt($request->password)
            ]);

        if ($user) {
            return response()->json([
                'status' => true,
                'msg' => 'Berhasil di perbarui',
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'msg' => 'Gagal',
            ], 200);
        }
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
        // $jarak = Jarak_km::first();

        // $validator = Validator::make(
        //     $request->all(),
        //     [
        //         'km' => [
        //             'required',
        //             'numeric',
        //             'min:' . ($km->km + 1),
        //             function ($attribute, $value, $fail) use ($km, $jarak) {
        //                 if ($value - $km->km > $jarak->batas) {
        //                     $fail('Nilai km baru tidak boleh lebih dari ' . $jarak->batas . ' km dari km awal.');
        //                 }
        //             },
        //         ],
        //     ],
        //     [
        //         'km.required' => 'Masukkan nilai km',
        //         'km.numeric' => 'Nilai Km harus berupa angka',
        //         'km.min' => 'Nilai Km harus lebih tinggi dari Km awal',
        //     ]
        // );


        // if ($validator->fails()) {
        //     $error = $validator->errors()->first();
        //     return $this->error($error);
        // }

        $kendaraan = Kendaraan::find($id);
        $currentStatusPerjalanan = $kendaraan->status_perjalanan;
        $currentTimer = $kendaraan->waktu;

        $waktuTungguMuat = $kendaraan->updated_at;
        $waktuPerjalananIsi = now();

        // Format "hari jam:menit:detik"
        $jarakWaktu = $waktuTungguMuat->diff($waktuPerjalananIsi)->format('%d %H:%I');

        // Update Kendaraan status and timer
        $kendaraan->update([
            'user_id' => $request->user_id,
            'status_perjalanan' => 'Tunggu Muat',
            // 'km' => $request->km,
            'timer' => $jarakWaktu,
            'waktu' => now()->format('Y-m-d H:i:s')
        ]);

        // $pengambilan_do = Pengambilan_do::where('kendaraan_id', $kendaraan->id)
        //     ->first();

        // if ($pengambilan_do) {
        //     $pengambilan_do->update([
        //         'km_awal' => $request->km,
        //     ]);
        // }

        // Retrieve the updated status_perjalanan for status_akhir
        $updatedStatusPerjalanan = $kendaraan->fresh()->status_perjalanan;
        $currentTimestamp = now()->format('Y-m-d H:i:s');

        // Create Timer record with the old and new status, and the old timer
        Timer::create(array_merge(
            $request->all(),
            [
                'kendaraan_id' => $id,
                'status_awal' => $currentStatusPerjalanan,
                'status_akhir' => $updatedStatusPerjalanan,
                'timer_awal' => $currentTimer,
                'timer_akhir' => $currentTimestamp,
            ]
        ));

        if ($kendaraan) {
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

        $currentStatusPerjalanan = $kendaraan->status_perjalanan;
        $currentTimer = $kendaraan->waktu;

        $waktuTungguMuat = $kendaraan->updated_at;
        $waktuPerjalananIsi = now();

        // Format "hari jam:menit:detik"
        $jarakWaktu = $waktuTungguMuat->diff($waktuPerjalananIsi)->format('%d %H:%I');

        $kendaraan->update([
            'user_id' => $request->user_id,
            'status_perjalanan' => 'Loading Muat',
            'timer' => $jarakWaktu,
            'waktu' => now()->format('Y-m-d H:i:s')
            // 'pelanggan_id' => $request->pelanggan_id,
        ]);

        // Retrieve the updated status_perjalanan for status_akhir
        $updatedStatusPerjalanan = $kendaraan->fresh()->status_perjalanan;
        $currentTimestamp = now()->format('Y-m-d H:i:s');

        // Create Timer record with the old and new status, and the old timer
        Timer::create(array_merge(
            $request->all(),
            [
                'kendaraan_id' => $id,
                'status_awal' => $currentStatusPerjalanan,
                'status_akhir' => $updatedStatusPerjalanan,
                'timer_awal' => $currentTimer,
                'timer_akhir' => $currentTimestamp,
            ]
        ));

        if ($kendaraan) {
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

        // $km = Kendaraan::findOrFail($id);

        // $validator = Validator::make(
        //     $request->all(),
        //     [
        //         'km' => 'required|numeric|min:' . ($km->km + 1),
        //         'kota_id' => 'required',
        //     ],
        //     [
        //         'km.required' => 'Masukkan nilai km',
        //         'km.numeric' => 'Nilai Km harus berupa angka',
        //         'km.min' => 'Nilai Km harus lebih tinggi dari Km awal',
        //         'kota_id.required' => 'Pilih tujuan',
        //     ]
        // );

        // if ($validator->fails()) {
        //     $error = $validator->errors()->first();
        //     return $this->error($error);
        // }

        $kendaraan = Kendaraan::find($id);
        $currentStatusPerjalanan = $kendaraan->status_perjalanan;
        $currentTimer = $kendaraan->waktu;

        $waktuTungguMuat = $kendaraan->updated_at;
        $waktuPerjalananIsi = now();

        // Format "hari jam:menit:detik"
        $jarakWaktu = $waktuTungguMuat->diff($waktuPerjalananIsi)->format('%d %H:%I');

        $tanggal = Carbon::now()->format('Y-m-d');
        $kendaraan->update([
            'user_id' => $request->user_id,
            // 'km' => $request->km,
            'status_perjalanan' => 'Perjalanan Isi',
            'timer' => $jarakWaktu,
            // 'kota_id' => $request->kota_id,
            'tanggal_awalperjalanan' => $tanggal,
            'tanggal_awalwaktuperjalanan' => Carbon::now('Asia/Jakarta'), // Menggunakan zona waktu Asia/Jakarta (WIB)
            'waktu' => now()->format('Y-m-d H:i:s')

        ]);

        // Retrieve the updated status_perjalanan for status_akhir
        $updatedStatusPerjalanan = $kendaraan->fresh()->status_perjalanan;
        $currentTimestamp = now()->format('Y-m-d H:i:s');

        // Create Timer record with the old and new status, and the old timer
        Timer::create(array_merge(
            $request->all(),
            [
                'kendaraan_id' => $id,
                'status_awal' => $currentStatusPerjalanan,
                'status_akhir' => $updatedStatusPerjalanan,
                'timer_awal' => $currentTimer,
                'timer_akhir' => $currentTimestamp,
            ]
        ));

        if ($kendaraan) {
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

        // $validator = Validator::make(
        //     $request->all(),
        //     [
        //         'km' => 'required|numeric|min:' . ($km->km + 1),
        //     ],
        //     [
        //         'km.required' => 'Masukkan nilai km',
        //         'km.numeric' => 'Nilai Km harus berupa angka',
        //         'km.min' => 'Nilai Km harus lebih tinggi dari Km awal',
        //     ]
        // );

        // if ($validator->fails()) {
        //     $error = $validator->errors()->first();
        //     return $this->error($error);
        // }

        $kendaraan = Kendaraan::find($id);
        $currentStatusPerjalanan = $kendaraan->status_perjalanan;
        $currentTimer = $kendaraan->waktu;

        $waktuTungguMuat = $kendaraan->updated_at;
        $waktuPerjalananIsi = now();

        // Format "hari jam:menit:detik"
        $jarakWaktu = $waktuTungguMuat->diff($waktuPerjalananIsi)->format('%d %H:%I');

        $kendaraan->update([
            'user_id' => $request->user_id,
            'status_perjalanan' => 'Tunggu Bongkar',
            'timer' => $jarakWaktu,
            'waktu' => now()->format('Y-m-d H:i:s')
        ]);

        // Retrieve the updated status_perjalanan for status_akhir
        $updatedStatusPerjalanan = $kendaraan->fresh()->status_perjalanan;
        $currentTimestamp = now()->format('Y-m-d H:i:s');

        // Create Timer record with the old and new status, and the old timer
        Timer::create(array_merge(
            $request->all(),
            [
                'kendaraan_id' => $id,
                'status_awal' => $currentStatusPerjalanan,
                'status_akhir' => $updatedStatusPerjalanan,
                'timer_awal' => $currentTimer,
                'timer_akhir' => $currentTimestamp,
            ]
        ));

        if ($kendaraan) {
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

        $km = Kendaraan::findOrFail($id);
        $jarak = Jarak_km::first();

        // $validator = Validator::make(
        //     $request->all(),
        //     [
        //         'km' => [
        //             'required',
        //             'numeric',
        //             'min:' . ($km->km + 1),
        //             function ($attribute, $value, $fail) use ($km, $jarak) {
        //                 if ($value - $km->km > $jarak->batas) {
        //                     $fail('Nilai km baru tidak boleh lebih dari ' . $jarak->batas . ' km dari km awal.');
        //                 }
        //             },
        //         ],
        //     ],
        //     [
        //         'km.required' => 'Masukkan nilai km',
        //         'km.numeric' => 'Nilai Km harus berupa angka',
        //         'km.min' => 'Nilai Km harus lebih tinggi dari Km awal',
        //     ]
        // );


        // if ($validator->fails()) {
        //     $error = $validator->errors()->first();
        //     return $this->error($error);
        // }

        $kendaraan = Kendaraan::find($id);
        $currentStatusPerjalanan = $kendaraan->status_perjalanan;
        $currentTimer = $kendaraan->waktu;

        $waktuTungguMuat = $kendaraan->updated_at;
        $waktuPerjalananIsi = now();

        if ($kendaraan) {
            $tanggal = Carbon::now()->format('Y-m-d');
            // Laporanperjalanan::create([
            //     'kode_kendaraan' => $kendaraan->kode_kendaraan,
            //     'kendaraan_id' => $kendaraan->id,
            //     'user_id' => $kendaraan->user_id,
            //     'no_kabin' => $kendaraan->no_kabin,
            //     'no_pol' => $kendaraan->no_pol,
            //     'no_rangka' => $kendaraan->no_rangka,
            //     'no_mesin' => $kendaraan->no_mesin,
            //     'warna' => $kendaraan->warna,
            //     'km' => $kendaraan->km,
            //     'km_olimesin' => $kendaraan->km_olimesin,
            //     'km_oligardan' => $kendaraan->km_oligardan,
            //     'km_olitransmisi' => $kendaraan->km_olitransmisi,
            //     'expired_kir' => $kendaraan->expired_kir,
            //     'expired_stnk' => $kendaraan->expired_stnk,
            //     'jenis_kendaraan_id' => $kendaraan->jenis_kendaraan_id,
            //     'golongan_id' => $kendaraan->golongan_id,
            //     'divisi_id' => $kendaraan->divisi_id,
            //     'status' => $kendaraan->status,
            //     'qrcode_kendaraan' => $kendaraan->qrcode_kendaraan,
            //     'status_pemasangan' => $kendaraan->status_pemasangan,
            //     'kode_pemasangan' => $kendaraan->kode_pemasangan,
            //     'kode_pelepasan' => $kendaraan->kode_pelepasan,
            //     'tanggal' => $kendaraan->tanggal,
            //     'tanggal_awal' => $kendaraan->tanggal_awal,
            //     'tanggal_akhir' => $kendaraan->tanggal_akhir,
            //     'status_post' => $kendaraan->status_post,
            //     'status_notif' => $kendaraan->status_notif,
            //     'status_olimesin' => $kendaraan->status_olimesin,
            //     'status_oligardan' => $kendaraan->status_oligardan,
            //     'status_olitransmisi' => $kendaraan->status_olitransmisi,
            //     'status_notifkm' => $kendaraan->status_notifkm,
            //     'status_perjalanan' => $kendaraan->status_perjalanan,
            //     'tanggal_awalperjalanan' => $kendaraan->tanggal_awalperjalanan,
            //     'tanggal_akhirperjalanan' => $tanggal,
            //     'tanggal_awalwaktuperjalanan' => $kendaraan->tanggal_awalwaktuperjalanan,
            //     'tanggal_akhirwaktuperjalanan' => Carbon::now('Asia/Jakarta'), // Menggunakan zona waktu Asia/Jakarta (WIB)
            //     'timer' => $kendaraan->timer,
            //     'kota_id' => $kendaraan->kota_id,
            //     'pelanggan_id' => $kendaraan->pelanggan_id,
            // ]);
        }

        // Format "hari jam:menit:detik"
        $jarakWaktu = $waktuTungguMuat->diff($waktuPerjalananIsi)->format('%d %H:%I');

        $kendaraan->update([
            'user_id' => $request->user_id,
            'pelanggan_id' => null,
            // 'km' => $request->km,
            'status_perjalanan' => 'Loading Bongkar',
            'timer' => $jarakWaktu,
            'waktu' => now()->format('Y-m-d H:i:s')
        ]);

        // Retrieve the updated status_perjalanan for status_akhir
        $updatedStatusPerjalanan = $kendaraan->fresh()->status_perjalanan;
        $currentTimestamp = now()->format('Y-m-d H:i:s');

        // Create Timer record with the old and new status, and the old timer
        Timer::create(array_merge(
            $request->all(),
            [
                'kendaraan_id' => $id,
                'status_awal' => $currentStatusPerjalanan,
                'status_akhir' => $updatedStatusPerjalanan,
                'timer_awal' => $currentTimer,
                'timer_akhir' => $currentTimestamp,
            ]
        ));

        // $pengambilan_do = Pengambilan_do::where('kendaraan_id', $kendaraan->id)->first();
        // $pengambilan_do->update([
        //     'km_akhir' => $kendaraan->km,
        // ]);

        if ($kendaraan) {
            return response()->json([
                'status' => true,
                'msg' => 'Status Loading Bongkar',
            ]);
        } else {
            $this->error('Gagal !');
        }
    }

    public function kosong(Request $request, $id)
    {
        $kendaraan = Kendaraan::find($id);
        $currentStatusPerjalanan = $kendaraan->status_perjalanan;
        $currentTimer = $kendaraan->waktu;

        $waktuTungguMuat = $kendaraan->updated_at;
        $waktuPerjalananIsi = now();

        // Format "hari jam:menit:detik"
        $jarakWaktu = $waktuTungguMuat->diff($waktuPerjalananIsi)->format('%d %H:%I');

        $kendaraan->update([
            'user_id' => $request->user_id,
            'status_perjalanan' => 'Kosong',
            'timer' => $jarakWaktu,
            'waktu' => now()->format('Y-m-d H:i:s')
        ]);

        // Retrieve the updated status_perjalanan for status_akhir
        $updatedStatusPerjalanan = $kendaraan->fresh()->status_perjalanan;
        $currentTimestamp = now()->format('Y-m-d H:i:s');

        // Create Timer record with the old and new status, and the old timer
        Timer::create(array_merge(
            $request->all(),
            [
                'kendaraan_id' => $id,
                'status_awal' => $currentStatusPerjalanan,
                'status_akhir' => $updatedStatusPerjalanan,
                'timer_awal' => $currentTimer,
                'timer_akhir' => $currentTimestamp,
            ]
        ));

        if ($kendaraan) {
            return response()->json([
                'status' => true,
                'msg' => 'Status Kosong',
            ]);
        } else {
            $this->error('Gagal !');
        }
    }

    public function perjalanan_kosong(Request $request, $id)
    {
        $km = Kendaraan::findOrFail($id);
        $jarak = Jarak_km::first();

        // $validator = Validator::make(
        //     $request->all(),
        //     [
        //         'km' => [
        //             'required',
        //             'numeric',
        //             'min:' . ($km->km + 1),
        //             function ($attribute, $value, $fail) use ($km, $jarak) {
        //                 if ($value - $km->km > $jarak->batas) {
        //                     $fail('Nilai km baru tidak boleh lebih dari ' . $jarak->batas . ' km dari km awal.');
        //                 }
        //             },
        //         ],
        //         'kota_id' => 'required',
        //     ],
        //     [
        //         'km.required' => 'Masukkan nilai km',
        //         'km.numeric' => 'Nilai Km harus berupa angka',
        //         'km.min' => 'Nilai Km harus lebih tinggi dari Km awal',
        //         'kota_id.required' => 'Pilih tujuan',

        //     ]
        // );

        // if ($validator->fails()) {
        //     $error = $validator->errors()->first();
        //     return $this->error($error);
        // }

        $kendaraan = Kendaraan::find($id);
        $currentStatusPerjalanan = $kendaraan->status_perjalanan;
        $currentTimer = $kendaraan->waktu;

        $waktuTungguMuat = $kendaraan->updated_at;
        $waktuPerjalananIsi = now();

        // Format "hari jam:menit:detik"
        $jarakWaktu = $waktuTungguMuat->diff($waktuPerjalananIsi)->format('%d %H:%I');

        $kendaraan->update([
            'user_id' => $request->user_id,
            // 'km' => $request->km,
            'status_perjalanan' => 'Perjalanan Kosong',
            'timer' => $jarakWaktu,
            // 'kota_id' => $request->kota_id,
            'waktu' => now()->format('Y-m-d H:i:s')
        ]);

        // Retrieve the updated status_perjalanan for status_akhir
        $updatedStatusPerjalanan = $kendaraan->fresh()->status_perjalanan;
        $currentTimestamp = now()->format('Y-m-d H:i:s');

        // Create Timer record with the old and new status, and the old timer
        Timer::create(array_merge(
            $request->all(),
            [
                'kendaraan_id' => $id,
                'status_awal' => $currentStatusPerjalanan,
                'status_akhir' => $updatedStatusPerjalanan,
                'timer_awal' => $currentTimer,
                'timer_akhir' => $currentTimestamp,
            ]
        ));

        if ($kendaraan) {
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

        $jarak = Jarak_km::first();

        // $validator = Validator::make(
        //     $request->all(),
        //     [
        //         'km' => [
        //             'required',
        //             'numeric',
        //             'min:' . ($km->km + 1),
        //             function ($attribute, $value, $fail) use ($km, $jarak) {
        //                 if ($value - $km->km > $jarak->batas) {
        //                     $fail('Nilai km baru tidak boleh lebih dari ' . $jarak->batas . ' km dari km awal.');
        //                 }
        //             },
        //         ],
        //     ],
        //     [
        //         'km.required' => 'Masukkan nilai km',
        //         'km.numeric' => 'Nilai Km harus berupa angka',
        //         'km.min' => 'Nilai Km harus lebih tinggi dari Km awal',
        //     ]
        // );
        // if ($validator->fails()) {
        //     $error = $validator->errors()->first();
        //     return $this->error($error);
        // }

        $kendaraan = Kendaraan::find($id);
        $currentStatusPerjalanan = $kendaraan->status_perjalanan;
        $currentTimer = $kendaraan->waktu;

        $waktuTungguMuat = $kendaraan->updated_at;
        $waktuPerjalananIsi = now();

        // Format "hari jam:menit:detik"
        $jarakWaktu = $waktuTungguMuat->diff($waktuPerjalananIsi)->format('%d %H:%I');

        $kendaraan = $kendaraan->update([
            'user_id' => $request->user_id,
            // 'km' => $request->km,
            'status_perjalanan' => 'Perbaikan di garasi',
            'timer' => $jarakWaktu,
            'waktu' => now()->format('Y-m-d H:i:s')
        ]);

        // Retrieve the updated status_perjalanan for status_akhir
        $updatedStatusPerjalanan = $kendaraan->fresh()->status_perjalanan;
        $currentTimestamp = now()->format('Y-m-d H:i:s');

        // Create Timer record with the old and new status, and the old timer
        Timer::create(array_merge(
            $request->all(),
            [
                'kendaraan_id' => $id,
                'status_awal' => $currentStatusPerjalanan,
                'status_akhir' => $updatedStatusPerjalanan,
                'timer_awal' => $currentTimer,
                'timer_akhir' => $currentTimestamp,
            ]
        ));

        if ($kendaraan) {
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

        // $jarak = Jarak_km::first();

        // $validator = Validator::make(
        //     $request->all(),
        //     [
        //         'km' => [
        //             'required',
        //             'numeric',
        //             'min:' . ($km->km + 1),
        //             function ($attribute, $value, $fail) use ($km, $jarak) {
        //                 if ($value - $km->km > $jarak->batas) {
        //                     $fail('Nilai km baru tidak boleh lebih dari ' . $jarak->batas . ' km dari km awal.');
        //                 }
        //             },
        //         ],
        //     ],
        //     [
        //         'km.required' => 'Masukkan nilai km',
        //         'km.numeric' => 'Nilai Km harus berupa angka',
        //         'km.min' => 'Nilai Km harus lebih tinggi dari Km awal',
        //     ]
        // );
        // if ($validator->fails()) {
        //     $error = $validator->errors()->first();
        //     return $this->error($error);
        // }

        $kendaraan = Kendaraan::find($id);
        $currentStatusPerjalanan = $kendaraan->status_perjalanan;
        $currentTimer = $kendaraan->waktu;

        $waktuTungguMuat = $kendaraan->updated_at;
        $waktuPerjalananIsi = now();

        // Format "hari jam:menit:detik"
        $jarakWaktu = $waktuTungguMuat->diff($waktuPerjalananIsi)->format('%d %H:%I');

        $kendaraan = $kendaraan->update([
            'user_id' => $request->user_id,
            // 'km' => $request->km,
            'status_perjalanan' => 'Perbaikan di jalan',
            'timer' => $jarakWaktu,
            'waktu' => now()->format('Y-m-d H:i:s')
        ]);

        // Retrieve the updated status_perjalanan for status_akhir
        $updatedStatusPerjalanan = $kendaraan->fresh()->status_perjalanan;
        $currentTimestamp = now()->format('Y-m-d H:i:s');

        // Create Timer record with the old and new status, and the old timer
        Timer::create(array_merge(
            $request->all(),
            [
                'kendaraan_id' => $id,
                'status_awal' => $currentStatusPerjalanan,
                'status_akhir' => $updatedStatusPerjalanan,
                'timer_awal' => $currentTimer,
                'timer_akhir' => $currentTimestamp,
            ]
        ));

        if ($kendaraan) {
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

    public function karyawan_detail($id)
    {
        $karyawan = Karyawan::where('id', $id)->with('user')->first();
        if ($karyawan) {
            return response()->json([
                'status' => TRUE,
                'msg' => 'Berhasil',
                'karyawan' => $karyawan
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