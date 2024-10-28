<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Alamat_bongkar;
use App\Models\Alamat_muat;
use App\Models\Jarak_km;
use App\Models\Jarak_titik;
use App\Models\Karyawan;
use App\Models\Kendaraan;
use App\Models\Pelanggan;
use App\Models\Kota;
use App\Models\Pengambilan_do;
use Illuminate\Http\Request;
use App\Models\Timer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

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
        // Temukan pengguna berdasarkan ID
        // $user = User::find($id);

        // Validasi input dari request
        $validator = Validator::make(
            $request->all(),
            [
                'nama_kecil' => 'required',
                'telp' => 'required',
                'gambar' => 'nullable|image|max:2048', // Validasi gambar, opsional
            ],
            [
                'nama_kecil.required' => 'Masukkan nama lengkap',
                'telp.required' => 'Masukkan telp',
                'gambar.image' => 'File yang diunggah harus berupa gambar.',
                'gambar.max' => 'Ukuran gambar tidak boleh lebih dari 2 MB.',
            ]
        );

        // Jika validasi gagal, kirimkan pesan error
        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return $this->error($error);
        }

        // Temukan karyawan berdasarkan karyawan_id dari pengguna
        $karyawan = Karyawan::where('id', $id)->first();

        // Jika karyawan tidak ditemukan
        if (!$karyawan) {
            return $this->error('Karyawan tidak ditemukan.');
        }

        // Variabel untuk nama gambar
        $namaGambar = $karyawan->gambar; // Default ke gambar lama

        // Jika ada gambar baru, proses pengunggahan
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama dari penyimpanan
            if ($karyawan->gambar) {
                Storage::disk('local')->delete('public/uploads/' . $karyawan->gambar);
            }

            // Simpan gambar baru
            $gambar = str_replace(' ', '', $request->gambar->getClientOriginalName());
            $namaGambar = 'karyawan/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar->storeAs('public/uploads/', $namaGambar);
        }

        // Update data karyawan
        $karyawan->update([
            'nama_kecil' => $request->nama_kecil,
            'telp' => $request->telp,
            'gambar' => $namaGambar // Menggunakan nama gambar yang baru atau yang lama
        ]);

        // Mengembalikan respon jika berhasil
        return response()->json([
            'status' => true,
            'msg' => 'Profil berhasil diperbarui',
        ]);
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
        $kendaraan = Kendaraan::find($id);
        $pengambilan_do = $kendaraan->latestpengambilan_do;
        $alamat_muat = Alamat_muat::where('id', $pengambilan_do->alamat_muat_id)->first();

        $alamat_muat2 = null;
        $alamat_muat3 = null;

        if ($pengambilan_do->alamat_muat2_id != null) {
            $alamat_muat2 = Alamat_muat::where('id', $pengambilan_do->alamat_muat2_id)->first();
        }
        if ($pengambilan_do->alamat_muat3_id != null) {
            $alamat_muat3 = Alamat_muat::where('id', $pengambilan_do->alamat_muat3_id)->first();
        }

        if ($kendaraan->akses_lokasi == 1) {
            if ($pengambilan_do->akses_spk == 1) {

                if ($kendaraan->gpsid != null) {
                    if ($kendaraan) {
                        try {
                            // Panggil API dengan mencocokkan sVid kendaraan
                            $response = Http::get('https://app1.muliatrack.com/wspubjavasnackfactory/service.asmx/GetJsonPositionLocation', [
                                'sTokenKey' => 'gps-J@va',
                                'sVid' => $kendaraan->gpsid // Menggunakan gpsid dari tabel kendaraan sebagai sVid
                            ]);

                            if ($response->successful()) {
                                // Mendapatkan response dalam format JSON
                                $vehicles = $response->json();

                                // Mencari kendaraan berdasarkan gpsid
                                $matchedVehicle = collect($vehicles)->firstWhere('gpsid', $kendaraan->gpsid);

                                if ($matchedVehicle) {
                                    // Mengambil data odometer, latitude, longitude, dan status perjalanan
                                    $odometer = $matchedVehicle['odometer'] ?? $kendaraan->km;
                                    $latitude = $matchedVehicle['lat'] ?? null;
                                    $longitude = $matchedVehicle['long'] ?? null;
                                    $status_perjalanan = $matchedVehicle['status'] ?? null;
                                    $lokasi = $matchedVehicle['location'] ?? null;

                                    // Update odometer jika lebih besar dari 0
                                    if ($odometer > 0) {
                                        $kendaraan->km = $odometer;
                                    }

                                    // Update koordinat latitude dan longitude
                                    if ($latitude !== null && $longitude !== null) {
                                        $kendaraan->latitude = $latitude;
                                        $kendaraan->longitude = $longitude;
                                    }

                                    // Update status kendaraan jika ada
                                    if ($status_perjalanan !== null) {
                                        if ($status_perjalanan == "Acc On") {
                                            $kendaraan->status_kendaraan = 2;
                                        } else {
                                            $kendaraan->status_kendaraan = 0;
                                        }
                                    }

                                    if ($lokasi !== null) {
                                        $kendaraan->lokasi = $lokasi;
                                    }

                                    // Simpan perubahan ke database
                                    $kendaraan->save();
                                }
                            }
                        } catch (\Exception $e) {
                            // Tangani error jika terjadi masalah dengan API
                        }
                    }
                } else {
                    if ($kendaraan) {
                        try {
                            $client = new Client();
                            $response = $client->post('https://vtsapi.easygo-gps.co.id/api/Report/lastposition', [
                                'headers' => [
                                    'accept' => 'application/json',
                                    'token' => 'B13E7A18C7FF4E80B9A252F54DB3D939',
                                    'Content-Type' => 'application/json',
                                ],
                                'json' => [
                                    'list_vehicle_id' => [$kendaraan->list_vehicle_id],
                                    'list_nopol' => [],
                                    'list_no_aset' => [],
                                    'geo_code' => [],
                                    'min_lastupdate_hour' => null,
                                    'page' => 0,
                                    'encrypted' => 0,
                                ],
                            ]);

                            $data = json_decode($response->getBody()->getContents(), true);

                            if (isset($data['Data'][0]['vehicle_id'])) {
                                $vehicleId = $data['Data'][0]['vehicle_id'];

                                if ($vehicleId === $kendaraan->list_vehicle_id) {
                                    // Ambil odometer
                                    $odometer = intval($data['Data'][0]['odometer'] ?? 0);

                                    // Ambil latitude dan longitude
                                    $latitude = $data['Data'][0]['lat'] ?? null;
                                    $longitude = $data['Data'][0]['lon'] ?? null;
                                    $lokasi = $data['Data'][0]['addr'] ?? null;
                                    $status_kendaraan = $data['Data'][0]['currentStatusVehicle']['status'] ?? null;

                                    // Update data kendaraan dengan odometer, latitude, dan longitude
                                    if ($odometer > 0) {
                                        $kendaraan->km = $odometer;
                                    }
                                    if ($latitude !== null && $longitude !== null) {
                                        $kendaraan->latitude = $latitude;
                                        $kendaraan->longitude = $longitude;
                                    }

                                    if (
                                        $lokasi !== null
                                    ) {
                                        $kendaraan->lokasi = $lokasi;
                                    }

                                    if (
                                        $status_kendaraan !== null
                                    ) {
                                        $kendaraan->status_kendaraan = $status_kendaraan;
                                    }

                                    // Simpan perubahan ke database
                                    $kendaraan->save();
                                }
                            }
                        } catch (\Exception $e) {
                            // Tangani error jika diperlukan
                        }
                    }
                }

                $latitude_kendaraan = $kendaraan->latitude;
                $longitude_kendaraan = $kendaraan->longitude;

                // Cek jarak dari alamat pertama
                $distance = $this->calculateDistance($alamat_muat->latitude, $alamat_muat->longitude, $latitude_kendaraan, $longitude_kendaraan);

                // Ambil radius yang diperbolehkan dari kolom 'jarak'
                $jarak_titik = Jarak_titik::first();
                if (!$jarak_titik || $jarak_titik->jarak <= 0) {
                    return response()->json([
                        'status' => false,
                        'msg' => 'Nilai jarak tidak valid.',
                    ], 200);
                }

                $allowedRadius = $jarak_titik->jarak;

                // Jika jarak dari alamat pertama terlalu jauh, cek alamat kedua (jika ada)
                if ($distance > $allowedRadius && $alamat_muat2 != null) {
                    $distance = $this->calculateDistance($alamat_muat2->latitude, $alamat_muat2->longitude, $latitude_kendaraan, $longitude_kendaraan);
                }

                // Jika jarak dari alamat kedua terlalu jauh, cek alamat ketiga (jika ada)
                if ($distance > $allowedRadius && $alamat_muat3 != null) {
                    $distance = $this->calculateDistance($alamat_muat3->latitude, $alamat_muat3->longitude, $latitude_kendaraan, $longitude_kendaraan);
                }

                // Jika jarak masih lebih dari allowedRadius setelah cek ketiga lokasi, kembalikan respon
                if ($distance > $allowedRadius) {
                    return response()->json([
                        'status' => false,
                        'msg' => 'Tidak dapat melakukan update karena masih jauh dari tujuan, jarak anda dari tujuan sekitar ' . round($distance, 2) . ' km.',
                    ], 200);
                }
            }
        }


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
        $pengambilan_do_id = $pengambilan_do ? $pengambilan_do->id : null;

        // Retrieve the updated status_perjalanan for status_akhir
        $updatedStatusPerjalanan = $kendaraan->fresh()->status_perjalanan;
        $currentTimestamp = now()->format('Y-m-d H:i:s');

        // Create Timer record with the old and new status, and the old timer
        Timer::create(array_merge(
            $request->all(),
            [
                'kendaraan_id' => $id,
                'pengambilan_do_id' => $pengambilan_do_id,
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
        $pengambilan_do = $kendaraan->latestpengambilan_do;
        $alamat_muat = Alamat_muat::where('id', $pengambilan_do->alamat_muat_id)->first();

        if ($kendaraan->akses_lokasi == 1) {
            if ($pengambilan_do->akses_spk == 1) {
                if ($kendaraan->gpsid != null) {
                    if ($kendaraan) {
                        try {
                            // Panggil API dengan mencocokkan sVid kendaraan
                            $response = Http::get('https://app1.muliatrack.com/wspubjavasnackfactory/service.asmx/GetJsonPositionLocation', [
                                'sTokenKey' => 'gps-J@va',
                                'sVid' => $kendaraan->gpsid // Menggunakan gpsid dari tabel kendaraan sebagai sVid
                            ]);

                            if ($response->successful()) {
                                // Mendapatkan response dalam format JSON
                                $vehicles = $response->json();

                                // Mencari kendaraan berdasarkan gpsid
                                $matchedVehicle = collect($vehicles)->firstWhere('gpsid', $kendaraan->gpsid);

                                if ($matchedVehicle) {
                                    // Mengambil data odometer, latitude, longitude, dan status perjalanan
                                    $odometer = $matchedVehicle['odometer'] ?? $kendaraan->km;
                                    $latitude = $matchedVehicle['lat'] ?? null;
                                    $longitude = $matchedVehicle['long'] ?? null;
                                    $status_perjalanan = $matchedVehicle['status'] ?? null;
                                    $lokasi = $matchedVehicle['location'] ?? null;

                                    // Update odometer jika lebih besar dari 0
                                    if ($odometer > 0) {
                                        $kendaraan->km = $odometer;
                                    }

                                    // Update koordinat latitude dan longitude
                                    if ($latitude !== null && $longitude !== null) {
                                        $kendaraan->latitude = $latitude;
                                        $kendaraan->longitude = $longitude;
                                    }

                                    // Update status kendaraan jika ada
                                    if ($status_perjalanan !== null) {
                                        if ($status_perjalanan == "Acc On") {
                                            $kendaraan->status_kendaraan = 2;
                                        } else {
                                            $kendaraan->status_kendaraan = 0;
                                        }
                                    }

                                    if ($lokasi !== null) {
                                        $kendaraan->lokasi = $lokasi;
                                    }

                                    // Simpan perubahan ke database
                                    $kendaraan->save();
                                }
                            }
                        } catch (\Exception $e) {
                            // Tangani error jika terjadi masalah dengan API
                        }
                    }
                } else {
                    if ($kendaraan) {
                        try {
                            $client = new Client();
                            $response = $client->post('https://vtsapi.easygo-gps.co.id/api/Report/lastposition', [
                                'headers' => [
                                    'accept' => 'application/json',
                                    'token' => 'B13E7A18C7FF4E80B9A252F54DB3D939',
                                    'Content-Type' => 'application/json',
                                ],
                                'json' => [
                                    'list_vehicle_id' => [$kendaraan->list_vehicle_id],
                                    'list_nopol' => [],
                                    'list_no_aset' => [],
                                    'geo_code' => [],
                                    'min_lastupdate_hour' => null,
                                    'page' => 0,
                                    'encrypted' => 0,
                                ],
                            ]);

                            $data = json_decode($response->getBody()->getContents(), true);

                            if (isset($data['Data'][0]['vehicle_id'])) {
                                $vehicleId = $data['Data'][0]['vehicle_id'];

                                if ($vehicleId === $kendaraan->list_vehicle_id) {
                                    // Ambil odometer
                                    $odometer = intval($data['Data'][0]['odometer'] ?? 0);

                                    // Ambil latitude dan longitude
                                    $latitude = $data['Data'][0]['lat'] ?? null;
                                    $longitude = $data['Data'][0]['lon'] ?? null;
                                    $lokasi = $data['Data'][0]['addr'] ?? null;
                                    $status_kendaraan = $data['Data'][0]['currentStatusVehicle']['status'] ?? null;

                                    // Update data kendaraan dengan odometer, latitude, dan longitude
                                    if ($odometer > 0) {
                                        $kendaraan->km = $odometer;
                                    }
                                    if ($latitude !== null && $longitude !== null) {
                                        $kendaraan->latitude = $latitude;
                                        $kendaraan->longitude = $longitude;
                                    }

                                    if (
                                        $lokasi !== null
                                    ) {
                                        $kendaraan->lokasi = $lokasi;
                                    }

                                    if (
                                        $status_kendaraan !== null
                                    ) {
                                        $kendaraan->status_kendaraan = $status_kendaraan;
                                    }

                                    // Simpan perubahan ke database
                                    $kendaraan->save();
                                }
                            }
                        } catch (\Exception $e) {
                            // Tangani error jika diperlukan
                        }
                    }
                }

                $latitude_do = $alamat_muat->latitude;
                $longitude_do = $alamat_muat->longitude;

                $latitude_kendaraan = $kendaraan->latitude;
                $longitude_kendaraan = $kendaraan->longitude;

                $distance = $this->calculateDistance($latitude_do, $longitude_do, $latitude_kendaraan, $longitude_kendaraan);

                // Ambil radius yang diperbolehkan dari kolom 'jarak'
                $jarak_titik = Jarak_titik::first();
                if (!$jarak_titik || $jarak_titik->jarak <= 0) {
                    return response()->json([
                        'status' => false,
                        'msg' => 'Nilai jarak tidak valid.',
                    ], 200); // Jika tidak ada nilai jarak yang valid, kembalikan error
                }

                $allowedRadius = $jarak_titik->jarak;

                // Jika jarak lebih dari allowedRadius, kembalikan respon bahwa kendaraan masih jauh
                if ($distance > $allowedRadius) {
                    return response()->json([
                        'status' => false,
                        'msg' => 'Tidak dapat melakukan update karena masih jauh dari tujuan, jarak anda dari tujuan sekitar ' . round($distance, 2) . ' km.',
                    ], 200);
                }
            }
        }
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

        // $pengambilan_do = Pengambilan_do::where('kendaraan_id', $kendaraan->id)
        //     ->first();
        $pengambilan_do_id = $pengambilan_do ? $pengambilan_do->id : null;
        // Create Timer record with the old and new status, and the old timer
        Timer::create(array_merge(
            $request->all(),
            [
                'kendaraan_id' => $id,
                'pengambilan_do_id' => $pengambilan_do_id,
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

        $kendaraan = Kendaraan::find($id);
        $pengambilan_do = $kendaraan->latestpengambilan_do;

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

        // $pengambilan_do = Pengambilan_do::where('kendaraan_id', $kendaraan->id)
        //     ->first();
        $pengambilan_do_id = $pengambilan_do ? $pengambilan_do->id : null;
        // Create Timer record with the old and new status, and the old timer
        Timer::create(array_merge(
            $request->all(),
            [
                'kendaraan_id' => $id,
                'pengambilan_do_id' => $pengambilan_do_id,
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
        $kendaraan = Kendaraan::find($id);
        $pengambilan_do = $kendaraan->latestpengambilan_do;
        $alamat_muat = Alamat_bongkar::where('id', $pengambilan_do->alamat_bongkar_id)->first();

        $alamat_muat2 = null;
        $alamat_muat3 = null;

        if ($pengambilan_do->alamat_bongkar2_id != null) {
            $alamat_muat2 = Alamat_bongkar::where('id', $pengambilan_do->alamat_bongkar2_id)->first();
        }
        if ($pengambilan_do->alamat_bongkar3_id != null) {
            $alamat_muat3 = Alamat_bongkar::where('id', $pengambilan_do->alamat_bongkar3_id)->first();
        }

        if ($kendaraan->akses_lokasi == 1) {
            if ($pengambilan_do->akses_spk == 1) {

                if ($kendaraan->gpsid != null) {
                    if ($kendaraan) {
                        try {
                            // Panggil API dengan mencocokkan sVid kendaraan
                            $response = Http::get('https://app1.muliatrack.com/wspubjavasnackfactory/service.asmx/GetJsonPositionLocation', [
                                'sTokenKey' => 'gps-J@va',
                                'sVid' => $kendaraan->gpsid // Menggunakan gpsid dari tabel kendaraan sebagai sVid
                            ]);

                            if ($response->successful()) {
                                // Mendapatkan response dalam format JSON
                                $vehicles = $response->json();

                                // Mencari kendaraan berdasarkan gpsid
                                $matchedVehicle = collect($vehicles)->firstWhere('gpsid', $kendaraan->gpsid);

                                if ($matchedVehicle) {
                                    // Mengambil data odometer, latitude, longitude, dan status perjalanan
                                    $odometer = $matchedVehicle['odometer'] ?? $kendaraan->km;
                                    $latitude = $matchedVehicle['lat'] ?? null;
                                    $longitude = $matchedVehicle['long'] ?? null;
                                    $status_perjalanan = $matchedVehicle['status'] ?? null;
                                    $lokasi = $matchedVehicle['location'] ?? null;

                                    // Update odometer jika lebih besar dari 0
                                    if ($odometer > 0) {
                                        $kendaraan->km = $odometer;
                                    }

                                    // Update koordinat latitude dan longitude
                                    if ($latitude !== null && $longitude !== null) {
                                        $kendaraan->latitude = $latitude;
                                        $kendaraan->longitude = $longitude;
                                    }

                                    // Update status kendaraan jika ada
                                    if ($status_perjalanan !== null) {
                                        if ($status_perjalanan == "Acc On") {
                                            $kendaraan->status_kendaraan = 2;
                                        } else {
                                            $kendaraan->status_kendaraan = 0;
                                        }
                                    }

                                    if ($lokasi !== null) {
                                        $kendaraan->lokasi = $lokasi;
                                    }

                                    // Simpan perubahan ke database
                                    $kendaraan->save();
                                }
                            }
                        } catch (\Exception $e) {
                            // Tangani error jika terjadi masalah dengan API
                        }
                    }
                } else {
                    if ($kendaraan) {
                        try {
                            $client = new Client();
                            $response = $client->post('https://vtsapi.easygo-gps.co.id/api/Report/lastposition', [
                                'headers' => [
                                    'accept' => 'application/json',
                                    'token' => 'B13E7A18C7FF4E80B9A252F54DB3D939',
                                    'Content-Type' => 'application/json',
                                ],
                                'json' => [
                                    'list_vehicle_id' => [$kendaraan->list_vehicle_id],
                                    'list_nopol' => [],
                                    'list_no_aset' => [],
                                    'geo_code' => [],
                                    'min_lastupdate_hour' => null,
                                    'page' => 0,
                                    'encrypted' => 0,
                                ],
                            ]);

                            $data = json_decode($response->getBody()->getContents(), true);

                            if (isset($data['Data'][0]['vehicle_id'])) {
                                $vehicleId = $data['Data'][0]['vehicle_id'];

                                if ($vehicleId === $kendaraan->list_vehicle_id) {
                                    // Ambil odometer
                                    $odometer = intval($data['Data'][0]['odometer'] ?? 0);

                                    // Ambil latitude dan longitude
                                    $latitude = $data['Data'][0]['lat'] ?? null;
                                    $longitude = $data['Data'][0]['lon'] ?? null;
                                    $lokasi = $data['Data'][0]['addr'] ?? null;
                                    $status_kendaraan = $data['Data'][0]['currentStatusVehicle']['status'] ?? null;

                                    // Update data kendaraan dengan odometer, latitude, dan longitude
                                    if ($odometer > 0) {
                                        $kendaraan->km = $odometer;
                                    }
                                    if ($latitude !== null && $longitude !== null) {
                                        $kendaraan->latitude = $latitude;
                                        $kendaraan->longitude = $longitude;
                                    }

                                    if (
                                        $lokasi !== null
                                    ) {
                                        $kendaraan->lokasi = $lokasi;
                                    }

                                    if (
                                        $status_kendaraan !== null
                                    ) {
                                        $kendaraan->status_kendaraan = $status_kendaraan;
                                    }

                                    // Simpan perubahan ke database
                                    $kendaraan->save();
                                }
                            }
                        } catch (\Exception $e) {
                            // Tangani error jika diperlukan
                        }
                    }
                }

                $latitude_do = $alamat_muat->latitude;
                $longitude_do = $alamat_muat->longitude;

                $latitude_kendaraan = $kendaraan->latitude;
                $longitude_kendaraan = $kendaraan->longitude;

                $distance = $this->calculateDistance($latitude_do, $longitude_do, $latitude_kendaraan, $longitude_kendaraan);

                // Ambil radius yang diperbolehkan dari kolom 'jarak'
                $jarak_titik = Jarak_titik::first();
                if (!$jarak_titik || $jarak_titik->jarak <= 0) {
                    return response()->json([
                        'status' => false,
                        'msg' => 'Nilai jarak tidak valid.',
                    ], 200); // Jika tidak ada nilai jarak yang valid, kembalikan error
                }


                $allowedRadius = $jarak_titik->jarak;

                // Jika jarak dari alamat pertama terlalu jauh, cek alamat kedua (jika ada)
                if ($distance > $allowedRadius && $alamat_muat2 != null) {
                    $distance = $this->calculateDistance($alamat_muat2->latitude, $alamat_muat2->longitude, $latitude_kendaraan, $longitude_kendaraan);
                }

                // Jika jarak dari alamat kedua terlalu jauh, cek alamat ketiga (jika ada)
                if ($distance > $allowedRadius && $alamat_muat3 != null) {
                    $distance = $this->calculateDistance($alamat_muat3->latitude, $alamat_muat3->longitude, $latitude_kendaraan, $longitude_kendaraan);
                }

                // Jika jarak masih lebih dari allowedRadius setelah cek ketiga lokasi, kembalikan respon
                if ($distance > $allowedRadius) {
                    return response()->json([
                        'status' => false,
                        'msg' => 'Tidak dapat melakukan update karena masih jauh dari tujuan, jarak anda dari tujuan sekitar ' . round($distance, 2) . ' km.',
                    ], 200);
                }
            }
        }

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

        // $pengambilan_do = Pengambilan_do::where('kendaraan_id', $kendaraan->id)
        //     ->first();
        $pengambilan_do_id = $pengambilan_do ? $pengambilan_do->id : null;
        // Create Timer record with the old and new status, and the old timer
        Timer::create(array_merge(
            $request->all(),
            [
                'kendaraan_id' => $id,
                'pengambilan_do_id' => $pengambilan_do_id,
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
        $kendaraan = Kendaraan::find($id);

        $pengambilan_do = $kendaraan->latestpengambilan_do;
        $alamat_muat = Alamat_bongkar::where('id', $pengambilan_do->alamat_bongkar_id)->first();

        if ($kendaraan->akses_lokasi == 1) {

            if ($pengambilan_do->akses_spk == 1) {

                if ($kendaraan->gpsid != null) {
                    if ($kendaraan) {
                        try {
                            // Panggil API dengan mencocokkan sVid kendaraan
                            $response = Http::get('https://app1.muliatrack.com/wspubjavasnackfactory/service.asmx/GetJsonPositionLocation', [
                                'sTokenKey' => 'gps-J@va',
                                'sVid' => $kendaraan->gpsid // Menggunakan gpsid dari tabel kendaraan sebagai sVid
                            ]);

                            if ($response->successful()) {
                                // Mendapatkan response dalam format JSON
                                $vehicles = $response->json();

                                // Mencari kendaraan berdasarkan gpsid
                                $matchedVehicle = collect($vehicles)->firstWhere('gpsid', $kendaraan->gpsid);

                                if ($matchedVehicle) {
                                    // Mengambil data odometer, latitude, longitude, dan status perjalanan
                                    $odometer = $matchedVehicle['odometer'] ?? $kendaraan->km;
                                    $latitude = $matchedVehicle['lat'] ?? null;
                                    $longitude = $matchedVehicle['long'] ?? null;
                                    $status_perjalanan = $matchedVehicle['status'] ?? null;
                                    $lokasi = $matchedVehicle['location'] ?? null;

                                    // Update odometer jika lebih besar dari 0
                                    if ($odometer > 0) {
                                        $kendaraan->km = $odometer;
                                    }

                                    // Update koordinat latitude dan longitude
                                    if ($latitude !== null && $longitude !== null) {
                                        $kendaraan->latitude = $latitude;
                                        $kendaraan->longitude = $longitude;
                                    }

                                    // Update status kendaraan jika ada
                                    if ($status_perjalanan !== null) {
                                        if ($status_perjalanan == "Acc On") {
                                            $kendaraan->status_kendaraan = 2;
                                        } else {
                                            $kendaraan->status_kendaraan = 0;
                                        }
                                    }

                                    if ($lokasi !== null) {
                                        $kendaraan->lokasi = $lokasi;
                                    }

                                    // Simpan perubahan ke database
                                    $kendaraan->save();
                                }
                            }
                        } catch (\Exception $e) {
                            // Tangani error jika terjadi masalah dengan API
                        }
                    }
                } else {
                    if ($kendaraan) {
                        try {
                            $client = new Client();
                            $response = $client->post('https://vtsapi.easygo-gps.co.id/api/Report/lastposition', [
                                'headers' => [
                                    'accept' => 'application/json',
                                    'token' => 'B13E7A18C7FF4E80B9A252F54DB3D939',
                                    'Content-Type' => 'application/json',
                                ],
                                'json' => [
                                    'list_vehicle_id' => [$kendaraan->list_vehicle_id],
                                    'list_nopol' => [],
                                    'list_no_aset' => [],
                                    'geo_code' => [],
                                    'min_lastupdate_hour' => null,
                                    'page' => 0,
                                    'encrypted' => 0,
                                ],
                            ]);

                            $data = json_decode($response->getBody()->getContents(), true);

                            if (isset($data['Data'][0]['vehicle_id'])) {
                                $vehicleId = $data['Data'][0]['vehicle_id'];

                                if ($vehicleId === $kendaraan->list_vehicle_id) {
                                    // Ambil odometer
                                    $odometer = intval($data['Data'][0]['odometer'] ?? 0);

                                    // Ambil latitude dan longitude
                                    $latitude = $data['Data'][0]['lat'] ?? null;
                                    $longitude = $data['Data'][0]['lon'] ?? null;
                                    $lokasi = $data['Data'][0]['addr'] ?? null;
                                    $status_kendaraan = $data['Data'][0]['currentStatusVehicle']['status'] ?? null;

                                    // Update data kendaraan dengan odometer, latitude, dan longitude
                                    if ($odometer > 0) {
                                        $kendaraan->km = $odometer;
                                    }
                                    if ($latitude !== null && $longitude !== null) {
                                        $kendaraan->latitude = $latitude;
                                        $kendaraan->longitude = $longitude;
                                    }

                                    if (
                                        $lokasi !== null
                                    ) {
                                        $kendaraan->lokasi = $lokasi;
                                    }

                                    if (
                                        $status_kendaraan !== null
                                    ) {
                                        $kendaraan->status_kendaraan = $status_kendaraan;
                                    }

                                    // Simpan perubahan ke database
                                    $kendaraan->save();
                                }
                            }
                        } catch (\Exception $e) {
                            // Tangani error jika diperlukan
                        }
                    }
                }

                $latitude_do = $alamat_muat->latitude;
                $longitude_do = $alamat_muat->longitude;

                $latitude_kendaraan = $kendaraan->latitude;
                $longitude_kendaraan = $kendaraan->longitude;

                $distance = $this->calculateDistance($latitude_do, $longitude_do, $latitude_kendaraan, $longitude_kendaraan);

                // Ambil radius yang diperbolehkan dari kolom 'jarak'
                $jarak_titik = Jarak_titik::first();
                if (!$jarak_titik || $jarak_titik->jarak <= 0) {
                    return response()->json([
                        'status' => false,
                        'msg' => 'Nilai jarak tidak valid.',
                    ], 200); // Jika tidak ada nilai jarak yang valid, kembalikan error
                }

                $allowedRadius = $jarak_titik->jarak;

                // Jika jarak lebih dari allowedRadius, kembalikan respon bahwa kendaraan masih jauh
                if ($distance > $allowedRadius) {
                    return response()->json([
                        'status' => false,
                        'msg' => 'Tidak dapat melakukan update karena masih jauh dari tujuan, jarak anda dari tujuan sekitar ' . round($distance, 2) . ' km.',
                    ], 200);
                }
            }
        }
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

        // $pengambilan_do = Pengambilan_do::where('kendaraan_id', $kendaraan->id)
        //     ->first();
        $pengambilan_do_id = $pengambilan_do ? $pengambilan_do->id : null;
        // Create Timer record with the old and new status, and the old timer
        Timer::create(array_merge(
            $request->all(),
            [
                'kendaraan_id' => $id,
                'pengambilan_do_id' => $pengambilan_do_id,
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
        $pengambilan_do = $kendaraan->latestpengambilan_do;

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

        // $pengambilan_do = Pengambilan_do::where('kendaraan_id', $kendaraan->id)
        //     ->first();
        $pengambilan_do_id = $pengambilan_do ? $pengambilan_do->id : null;
        // Create Timer record with the old and new status, and the old timer
        Timer::create(array_merge(
            $request->all(),
            [
                'kendaraan_id' => $id,
                'pengambilan_do_id' => $pengambilan_do_id,
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

        $kendaraan = Kendaraan::find($id);

        $pengambilan_do = $kendaraan->latestpengambilan_do;

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

        // $pengambilan_do = Pengambilan_do::where('kendaraan_id', $kendaraan->id)
        //     ->first();
        $pengambilan_do_id = $pengambilan_do ? $pengambilan_do->id : null;
        // Create Timer record with the old and new status, and the old timer
        Timer::create(array_merge(
            $request->all(),
            [
                'kendaraan_id' => $id,
                'pengambilan_do_id' => $pengambilan_do_id,
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
        $kendaraan = Kendaraan::find($id);
        $pengambilan_do = $kendaraan->latestpengambilan_do;

        if (!$kendaraan) {
            return response()->json([
                'status' => false,
                'msg' => 'Kendaraan tidak ditemukan!',
            ], 404);
        }

        $currentStatusPerjalanan = $kendaraan->status_perjalanan;
        $currentTimer = $kendaraan->waktu;

        $waktuTungguMuat = $kendaraan->updated_at;
        $waktuPerjalananIsi = now();

        // Format "hari jam:menit:detik"
        $jarakWaktu = $waktuTungguMuat->diff($waktuPerjalananIsi)->format('%d %H:%I');

        // Update kendaraan tanpa mengganti $kendaraan menjadi boolean
        $kendaraan->update([
            'user_id' => $request->user_id,
            // 'km' => $request->km,
            'status_perjalanan' => 'Perbaikan di garasi',
            'timer' => $jarakWaktu,
            'waktu' => now()->format('Y-m-d H:i:s'),
        ]);

        // Retrieve the updated status_perjalanan for status_akhir
        $updatedStatusPerjalanan = $kendaraan->fresh()->status_perjalanan;
        $currentTimestamp = now()->format('Y-m-d H:i:s');

        // $pengambilan_do = Pengambilan_do::where('kendaraan_id', $kendaraan->id)->first();
        $pengambilan_do_id = $pengambilan_do ? $pengambilan_do->id : null;

        // Create Timer record with the old and new status, and the old timer
        Timer::create(array_merge(
            $request->all(),
            [
                'kendaraan_id' => $id,
                'pengambilan_do_id' => $pengambilan_do_id,
                'status_awal' => $currentStatusPerjalanan,
                'status_akhir' => $updatedStatusPerjalanan,
                'timer_awal' => $currentTimer,
                'timer_akhir' => $currentTimestamp,
            ]
        ));

        return response()->json([
            'status' => true,
            'msg' => 'Perbaikan di garasi',
        ]);
    }


    public function perbaikan_dijalan(Request $request, $id)
    {
        $kendaraan = Kendaraan::find($id);
        $pengambilan_do = $kendaraan->latestpengambilan_do;

        if (!$kendaraan) {
            return response()->json([
                'status' => false,
                'msg' => 'Kendaraan tidak ditemukan!',
            ], 404);
        }

        $currentStatusPerjalanan = $kendaraan->status_perjalanan;
        $currentTimer = $kendaraan->waktu;

        $waktuTungguMuat = $kendaraan->updated_at;
        $waktuPerjalananIsi = now();

        // Format "hari jam:menit:detik"
        $jarakWaktu = $waktuTungguMuat->diff($waktuPerjalananIsi)->format('%d %H:%I');

        // Update kendaraan tanpa mengganti $kendaraan menjadi boolean
        $kendaraan->update([
            'user_id' => $request->user_id,
            // 'km' => $request->km,
            'status_perjalanan' => 'Perbaikan di jalan',
            'timer' => $jarakWaktu,
            'waktu' => now()->format('Y-m-d H:i:s'),
        ]);

        // Retrieve the updated status_perjalanan for status_akhir
        $updatedStatusPerjalanan = $kendaraan->fresh()->status_perjalanan;
        $currentTimestamp = now()->format('Y-m-d H:i:s');

        // $pengambilan_do = Pengambilan_do::where('kendaraan_id', $kendaraan->id)->first();
        $pengambilan_do_id = $pengambilan_do ? $pengambilan_do->id : null;

        // Create Timer record with the old and new status, and the old timer
        Timer::create(array_merge(
            $request->all(),
            [
                'kendaraan_id' => $id,
                'pengambilan_do_id' => $pengambilan_do_id,
                'status_awal' => $currentStatusPerjalanan,
                'status_akhir' => $updatedStatusPerjalanan,
                'timer_awal' => $currentTimer,
                'timer_akhir' => $currentTimestamp,
            ]
        ));

        return response()->json([
            'status' => true,
            'msg' => 'Perbaikan di jalan',
        ]);
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

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {

        $earthRadius = 6371; // Radius bumi dalam kilometer

        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);

        // Haversine formula
        $dlat = $lat2 - $lat1;
        $dlon = $lon2 - $lon1;

        $a = sin($dlat / 2) * sin($dlat / 2) +
            cos($lat1) * cos($lat2) *
            sin($dlon / 2) * sin($dlon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        // Hitung jarak
        $distance = $earthRadius * $c;

        return $distance; // Jarak dalam kilometer
    }

    // private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    // {
    //     $earthRadius = 6371; // Radius bumi dalam kilometer

    //     // Konversi derajat ke radian
    //     $lat1 = deg2rad($lat1);
    //     $lon1 = deg2rad($lon1);
    //     $lat2 = deg2rad($lat2);
    //     $lon2 = deg2rad($lon2);

    //     // Haversine formula
    //     $dlat = $lat2 - $lat1;
    //     $dlon = $lon2 - $lon1;

    //     $a = sin($dlat / 2) * sin($dlat / 2) +
    //         cos($lat1) * cos($lat2) *
    //         sin($dlon / 2) * sin($dlon / 2);

    //     $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

    //     // Hitung jarak
    //     $distance = $earthRadius * $c;

    //     return $distance; // Jarak dalam kilometer
    // }
}