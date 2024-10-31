<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Alamat_bongkar;
use App\Models\Alamat_muat;
use App\Models\Jarak_titik;
use App\Models\Karyawan;
use App\Models\Kendaraan;
use App\Models\Memo_ekspedisi;
use App\Models\Pengambilan_do;
use App\Models\Spk;
use App\Models\Timer;
use App\Models\Timer_suratjalan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class PengambilandoController extends Controller
{

    public function listAll()
    {

        $pengambilando = Pengambilan_do::with(['user.karyawan', 'kendaraan', 'rute_perjalanan', 'alamat_muat', 'alamat_bongkar', 'spk.pelanggan'])
            ->whereNotNull('spk_id')
            ->where('status_suratjalan', 'belum pulang')
            ->whereNull('waktu_suratakhir'); // Filter untuk waktu_suratakhir yang null

        // Filter berdasarkan nomor kabin kendaraan jika divisi dipilih
        if (!empty($divisi) && $divisi != 'All') {
            $pengambilando->whereHas('kendaraan', function ($query) use ($divisi) {
                $query->where('no_kabin', 'LIKE', $divisi . '%');
            });
        }

        // Mengurutkan berdasarkan id secara ascending
        $pengambilando = $pengambilando->orderBy('waktu_suratawal', 'ASC')->get();

        // Perulangan untuk menghitung durasi di controller
        foreach ($pengambilando as $spk) {
            if ($spk->waktu_suratawal) {
                $waktu_awal = Carbon::parse($spk->waktu_suratawal);
                $waktu_akhir = $spk->waktu_suratakhir ? Carbon::parse($spk->waktu_suratakhir) : Carbon::now();
                $durasi = $waktu_awal->diff($waktu_akhir);
                $spk->durasi_hari = $durasi->days;
                $spk->durasi_jam = $durasi->h;
                $spk->durasi_menit = $durasi->i;
                $spk->durasi_detik = $durasi->s;
            } else {
                $spk->durasi_hari = '-';
                $spk->durasi_jam = '-';
                $spk->durasi_menit = '-';
                $spk->durasi_detik = '-';
            }
        }

        if ($pengambilando->isNotEmpty()) { // Check if there are any records
            return $this->response(TRUE, ['Berhasil menampilkan data'], $pengambilando);
        } else {
            return $this->response(
                FALSE,
                ['Gagal menampilkan data!']
            );
        }
    }

    public function list($id)
    {
        // Mengambil data Pengambilan_do berdasarkan user_id dan status
        $pengambilando = Pengambilan_do::where([
            ['user_id', $id],
            ['status', '<>', 'unpost'] // Filter out entries where status is 'unpost'
        ])
            ->with(['kendaraan', 'rute_perjalanan', 'alamat_muat', 'alamat_muat2', 'alamat_muat3', 'alamat_bongkar', 'alamat_bongkar2', 'alamat_bongkar3', 'spk.pelanggan'])
            ->orderByRaw("
        CASE 
            WHEN status = 'posting' THEN 1
            WHEN status <> 'selesai' THEN 2
            WHEN status = 'selesai' THEN 3
            ELSE 4
        END
    ") // Urutkan berdasarkan status
            ->orderByRaw("CASE WHEN status = 'posting' THEN created_at END DESC") // Urutkan berdasarkan created_at untuk status 'posting' (terbaru dulu)
            ->orderByRaw("CASE WHEN status = 'selesai' THEN created_at END DESC") // Urutkan berdasarkan created_at untuk status 'selesai' (terlama ke terbaru)
            ->orderBy('id', 'asc') // Order by ID to ensure consistent ordering
            ->get();

        if ($pengambilando->isNotEmpty()) { // Check if there are any records
            return $this->response(TRUE, ['Berhasil menampilkan data'], $pengambilando);
        } else {
            return $this->response(
                FALSE,
                ['Gagal menampilkan data!']
            );
        }
    }

    public function search(Request $request)
    {
        $keyword = $request->keyword;

        // Pencarian data pengambilan_do berdasarkan relasi dengan tabel spk, kendaraan, pelanggan, dan rute_perjalanan
        $pengambilan_do = Pengambilan_do::with(['user.karyawan', 'kendaraan', 'rute_perjalanan', 'alamat_muat', 'alamat_bongkar', 'spk.pelanggan'])
            ->whereNotNull('spk_id')
            ->where('status_suratjalan', 'belum pulang')
            ->whereNull('waktu_suratakhir')
            ->where(function ($query) use ($keyword) {
                $query->whereHas('spk', function ($spkQuery) use ($keyword) {
                    $spkQuery->where('kode_spk', 'like', '%' . $keyword . '%')
                        ->orWhere('nama_driver', 'like', '%' . $keyword . '%')
                        ->orWhereHas('pelanggan', function ($pelangganQuery) use ($keyword) {
                            $pelangganQuery->where('nama_pell', 'like', '%' . $keyword . '%');
                        });
                })
                    ->orWhereHas('kendaraan', function ($kendaraanQuery) use ($keyword) {
                        $kendaraanQuery->where('no_kabin', 'like', '%' . $keyword . '%')
                            ->orWhere('no_pol', 'like', '%' . $keyword . '%'); // Menambahkan pencarian no_pol
                    })
                    ->orWhereHas('rute_perjalanan', function ($ruteQuery) use ($keyword) {
                        $ruteQuery->where('nama_rute', 'like', '%' . $keyword . '%');
                    });
            })
            ->get();

        // Cek apakah data ditemukan
        if ($pengambilan_do->isNotEmpty()) {
            return $this->response(TRUE, ['Berhasil menampilkan data'], $pengambilan_do);
        } else {
            return $this->response(FALSE, ['Gagal menampilkan data!']);
        }
    }


    public function terima(Request $request, $id)
    {
        $pengambilan = Pengambilan_do::findOrFail($id);
        $spk = Spk::where('id', $pengambilan->spk_id)->first();
        $penerimasj = $request->penerima_sj;
        $user = User::where('id', $penerimasj)->first();
        $karyawan = Karyawan::where('id', $user->karyawan_id)->first();
        $timer = Timer_suratjalan::where('pengambilan_do_id', $id)->latest()->first();

        // Memperbarui timer terakhir jika ada
        if ($timer) {
            $timer->update([
                'timer_akhir' => now()->format('Y-m-d H:i:s'),
            ]);
        }

        Timer_suratjalan::create([
            'pengambilan_do_id' => $id,
            'user_id' => $user->id,
            'kategori' => 'posting',
            'timer_awal' => now()->format('Y-m-d H:i:s'),
        ]);

        $spk->update([
            'status_spk' => 'sj'
        ]);

        // Mengupdate semua memo yang berelasi dengan spk
        $memos = Memo_ekspedisi::where('spk_id', $spk->id)->get();
        foreach ($memos as $memo) {
            $memo->update([
                'status_spk' => 'sj'
            ]);
        }

        $pengambilan->update([
            'status_penerimaansj' => 'posting',
            'penerima_sj' => $karyawan->nama_lengkap,
            // 'start_waktuditerima' => now()->format('Y-m-d H:i:s')
        ]);

        if ($pengambilan) {
            return response()->json([
                'status' => true,
                'msg' => 'Status Berhasil',
            ]);
        } else {
            // Lakukan penanganan error yang sesuai jika update gagal
            return response()->json([
                'status' => false,
                'msg' => 'Gagal memperbarui status',
            ], 500);
        }
    }

    public function batal_terima(Request $request, $id)
    {
        $pengambilan = Pengambilan_do::findOrFail($id);
        $spk = Spk::where('id', $pengambilan->spk_id)->first();
        $penerimasj = $request->penerima_sj;
        $user = User::where('id', $penerimasj)->first();
        $karyawan = Karyawan::where('id', $user->karyawan_id)->first();

        $timer = Timer_suratjalan::where('pengambilan_do_id', $id)->latest()->first();

        // Memperbarui timer terakhir jika ada
        if ($timer) {
            $timer->update([
                'timer_akhir' => now()->format('Y-m-d H:i:s'),
            ]);
        }

        Timer_suratjalan::create([
            'pengambilan_do_id' => $id,
            'user_id' => $user->id,
            'kategori' => 'unpost',
            'timer_awal' => now()->format('Y-m-d H:i:s'),
        ]);

        $spk->update([
            'status_spk' => 'memo'
        ]);

        // Mengupdate semua memo yang berelasi dengan spk
        $memos = Memo_ekspedisi::where('spk_id', $spk->id)->get();
        foreach ($memos as $memo) {
            $memo->update([
                'status_spk' => null
            ]);
        }

        $pengambilan->update([
            'status_penerimaansj' => 'unpost',
            'penerima_sj' => $karyawan->nama_lengkap,
        ]);

        if ($pengambilan) {
            return response()->json([
                'status' => true,
                'msg' => 'Status Berhasil',
            ]);
        } else {
            // Lakukan penanganan error yang sesuai jika update gagal
            return response()->json([
                'status' => false,
                'msg' => 'Gagal memperbarui status',
            ], 500);
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
        // Temukan objek Pengambilan_do berdasarkan id
        $pengambilan_do = Pengambilan_do::find($id);

        // Temukan objek Kendaraan berdasarkan kendaraan_id dari pengambilan_do
        $kendaraan = Kendaraan::find($pengambilan_do->kendaraan_id);

        $lastPengambilan = Pengambilan_do::where(
            'user_id',
            $pengambilan_do->user_id
        )
            ->where('id', '<', $id)
            ->where('status', '!=', 'unpost')
            ->orderBy(
                'created_at',
                'desc'
            )
            ->take(3)
            ->get();

        // Cek apakah ada pengambilan DO yang statusnya belum selesai
        foreach ($lastPengambilan as $pengambilan) {
            if ($pengambilan->status !== 'selesai') {
                // Jika ditemukan pengambilan DO yang belum selesai
                return response()->json([
                    'status' => false,
                    'msg' => 'Mohon selesaikan pengambilan DO sebelumnya terlebih dahulu.',
                ], 200);
            }
        }

        $odometer = null; // Inisialisasi variabel odometer
        if ($kendaraan) {
            try {
                // Panggilan ke API pertama
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

                    // Periksa apakah vehicle_id sama dengan list_vehicle_id
                    if ($vehicleId === $kendaraan->list_vehicle_id) {
                        // Ambil nilai 'odometer' dari data API pertama
                        $odometer = intval($data['Data'][0]['odometer'] ?? 0);

                        if ($odometer > 0) {
                            $kendaraan->km = $odometer;
                            $kendaraan->save();
                        }
                    } else {
                        // Gunakan API kedua jika vehicle_id tidak cocok
                        $this->fetchFromSecondAPI($kendaraan);
                    }
                } else {
                    // Jika vehicle_id tidak ditemukan di API pertama, gunakan API kedua
                    $this->fetchFromSecondAPI($kendaraan);
                }
            } catch (\Exception $e) {
                // Log error jika terjadi kegagalan pada API pertama
                // Lanjutkan ke API kedua jika terjadi error
                $this->fetchFromSecondAPI($kendaraan);
            }
        }

        // Perbarui pengambilan_do dengan km_awal dari kendaraan
        $proses = $pengambilan_do->update([
            // 'user_id' => $request->user_id,
            'status' => 'loading muat',
            'km_awal' => $kendaraan ? $kendaraan->km : null,
            'waktu_awal' => now()->format('Y-m-d H:i:s')
        ]);

        $spk = Spk::where('id', $pengambilan_do->spk_id)->first();
        $memos = Memo_ekspedisi::where('spk_id', $spk->id)
            ->where('status', 'rilis') // Ambil hanya memo yang statusnya 'rilis'
            ->get();

        // Cek apakah ada memo yang perlu diupdate
        if ($memos->isNotEmpty()) {
            foreach ($memos as $memo) {
                // Update status memo menjadi 'unpost'
                $memo->update([
                    'status' => 'unpost',
                ]);
            }
        } else {
            // Jika tidak ada memo yang statusnya 'rilis', tidak ada update yang dilakukan
            // Kamu bisa menambahkan log atau pesan lain di sini jika diperlukan
        }

        // Hitung jarak waktu antara waktu tunggu muat dan waktu perjalanan isi
        $waktuTungguMuat = $pengambilan_do->updated_at;
        $waktuPerjalananIsi = now();
        $jarakWaktu = $waktuTungguMuat->diff($waktuPerjalananIsi)->format('%d %H:%I');

        // Ambil status perjalanan dan timer saat ini dari kendaraan
        $currentStatusPerjalanan = $kendaraan ? $kendaraan->status_perjalanan : null;
        $currentTimer = $kendaraan ? $kendaraan->waktu : null;

        // Perbarui kendaraan dengan data baru
        $proses = $kendaraan->update([
            // 'user_id' => $request->user_id,
            'status_perjalanan' => 'Perjalanan Kosong',
            'timer' => $jarakWaktu,
            'waktu' => now()->format('Y-m-d H:i:s')
        ]);

        // Retrieve the updated status_perjalanan for status_akhir
        $updatedStatusPerjalanan = $kendaraan ? $kendaraan->fresh()->status_perjalanan : null;
        $currentTimestamp = now()->format('Y-m-d H:i:s');

        // Buat record Timer dengan status awal dan akhir, serta timer awal dan akhir
        Timer::create([
            'kendaraan_id' => $kendaraan->id,
            'pengambilan_do_id' => $id,
            'status_awal' => $currentStatusPerjalanan,
            'status_akhir' => $updatedStatusPerjalanan,
            'timer_awal' => $currentTimer,
            'timer_akhir' => $currentTimestamp,
        ]);

        if ($proses) {
            return response()->json([
                'status' => true,
                'msg' => 'Status Perjalanan Kosong',
            ]);
        } else {
            // Lakukan penanganan error yang sesuai jika update gagal
            return response()->json([
                'status' => false,
                'msg' => 'Gagal memperbarui status',
            ], 500);
        }
    }


    public function fetchFromSecondAPI($kendaraan)
    {
        try {
            // Panggilan ke API kedua
            $response = Http::get('https://app1.muliatrack.com/wspubjavasnackfactory/service.asmx/GetJsonPosition?sTokenKey=gps-J@va');

            if ($response->successful()) {
                $vehicles = $response->json();
                $matchedVehicle = collect($vehicles)->firstWhere('gpsid', $kendaraan->gpsid);

                if ($matchedVehicle) {
                    $odometer = intval($matchedVehicle['odometer'] ?? $kendaraan->km);

                    if ($odometer > 0) {
                        $kendaraan->km = $odometer;
                        $kendaraan->save();
                    }
                } else {
                    // Jika tidak ada kendaraan yang cocok, tetap perbarui km ke nilai km yang ada
                    $kendaraan->km = $kendaraan->km;
                    $kendaraan->save();
                }
            }
        } catch (\Exception $e) {
            // Log error jika API kedua gagal
        }
    }

    public function batal_pengambilan(Request $request, $id)
    {
        $pengambilan_do = Pengambilan_do::find($id);

        $pengambilan_do = Pengambilan_do::where('id', $id);
        $proses = $pengambilan_do->update([
            'user_id' => $request->user_id,
            'status' => 'posting',
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
        // Temukan model berdasarkan ID
        $pengambilan_do = Pengambilan_do::find($id);
        $spk = Spk::where('id', $pengambilan_do->spk_id)->first();
        if (!$pengambilan_do) {
            return response()->json([
                'status' => false,
                'msg' => 'Data tidak ditemukan.',
            ], 404);
        }

        $kendaraan = Kendaraan::find($pengambilan_do->kendaraan_id);

        if (
            $kendaraan->akses_lokasi == 1
        ) {
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

                $alamat_muat = Alamat_muat::where(
                    'id',
                    $pengambilan_do->alamat_muat_id
                )->first();
                // Temukan objek Kendaraan berdasarkan kendaraan_id dari pengambilan_do

                $alamat_muat2 = null;
                $alamat_muat3 = null;

                if ($pengambilan_do->alamat_muat2_id != null) {
                    $alamat_muat2 = Alamat_muat::where('id', $pengambilan_do->alamat_muat2_id)->first();
                }
                if ($pengambilan_do->alamat_muat3_id != null) {
                    $alamat_muat3 = Alamat_muat::where('id', $pengambilan_do->alamat_muat3_id)->first();
                }

                $latitude_do = $alamat_muat->latitude;
                $longitude_do = $alamat_muat->longitude;

                $latitude_kendaraan = $kendaraan->latitude;
                $longitude_kendaraan = $kendaraan->longitude;

                // Hitung jarak menggunakan Haversine Formula
                $distance = $this->calculateDistance($latitude_do, $longitude_do, $latitude_kendaraan, $longitude_kendaraan);

                // Ambil radius yang diperbolehkan dari kolom 'jarak'
                $jarak_titik = Jarak_titik::first();
                if (
                    !$jarak_titik || $jarak_titik->jarak <= 0
                ) {
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

                // Jika jarak lebih dari allowedRadius, kembalikan respon bahwa kendaraan masih jauh
                if ($distance > $allowedRadius) {
                    return response()->json([
                        'status' => false,
                        'msg' => 'Tidak dapat melakukan update karena masih jauh dari tujuan, jarak anda dari tujuan sekitar ' . round($distance, 2) . ' km.',
                    ], 200);
                }
            }
        }

        // Validasi bahwa file diupload
        if (!$request->hasFile('gambar') || !$request->file('gambar')->isValid()) {
            return response()->json([
                'status' => false,
                'msg' => 'Gambar tidak valid.',
            ], 200);
        }

        $gambar1 = str_replace(' ', '', $request->file('gambar')->getClientOriginalName());
        $namagambar1 = 'pengambilan_do/' . date('mYdHs') . rand(1, 10) . '_' . $gambar1;

        $request->file('gambar')->storeAs('public/uploads/', $namagambar1);

        // Menyiapkan file 'gambar2' jika ada
        $namagambar2 = null;
        if ($request->hasFile('gambar2') && $request->file('gambar2')->isValid()) {
            $gambar2 = str_replace(' ', '', $request->file('gambar2')->getClientOriginalName());
            $namagambar2 = 'pengambilan_do/' . date('mYdHs') . rand(1, 10) . '_' . $gambar2;
            $request->file('gambar2')->storeAs('public/uploads/', $namagambar2);
        }

        // Menyiapkan file 'gambar3' jika ada
        $namagambar3 = null;
        if ($request->hasFile('gambar3') && $request->file('gambar3')->isValid()) {
            $gambar3 = str_replace(' ', '', $request->file('gambar3')->getClientOriginalName());
            $namagambar3 = 'pengambilan_do/' . date('mYdHs') . rand(1, 10) . '_' . $gambar3;
            $request->file('gambar3')->storeAs('public/uploads/', $namagambar3);
        }

        // Memperbarui entri di database
        $pengambilan_do->update([
            'gambar' => $namagambar1,
            'gambar2' => $namagambar2,
            'gambar3' => $namagambar3,
            'status' => 'tunggu bongkar',
            'waktu_suratawal' => now()->format('Y-m-d H:i:s'),
            'status_suratjalan' => 'belum pulang'
        ]);

        // Menghitung jarak waktu
        $waktuTungguMuat = $pengambilan_do->updated_at;
        $waktuPerjalananIsi = now();
        $jarakWaktu = $waktuTungguMuat->diff($waktuPerjalananIsi)->format('%d %H:%I');

        // Memperbarui kendaraan terkait
        $kendaraan = Kendaraan::find($pengambilan_do->kendaraan_id);

        $currentStatusPerjalanan = $kendaraan->status_perjalanan;
        $currentTimer = $kendaraan->waktu;

        if ($kendaraan) {
            $kendaraan->update([
                'status_perjalanan' => 'Perjalanan Isi',
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
                    'kendaraan_id' => $kendaraan->id,
                    'pengambilan_do_id' => $id,
                    'status_awal' => $currentStatusPerjalanan,
                    'status_akhir' => $updatedStatusPerjalanan,
                    'timer_awal' => $currentTimer,
                    'timer_akhir' => $currentTimestamp,
                ]
            ));

            Timer_suratjalan::create(array_merge(
                $request->all(),
                [
                    'pengambilan_do_id' => $id,
                    'user_id' => $spk->user_id,
                    'timer_awal' => now()->format('Y-m-d H:i:s'),
                    'kategori' => 'posting',
                ]
            ));
        }

        return response()->json([
            'status' => true,
            'msg' => 'Status Perjalanan Isi',
        ]);
    }

    public function bukti_fotoperbarui(Request $request, $id)
    {
        // Temukan model berdasarkan ID
        $pengambilan_do = Pengambilan_do::find($id);

        if (!$pengambilan_do) {
            return response()->json([
                'status' => false,
                'msg' => 'Data tidak ditemukan.',
            ], 404);
        }


        // Menyiapkan file 'gambar1' jika ada
        $namagambar1 = null;
        if ($request->hasFile('gambar') && $request->file('gambar')->isValid()) {
            $gambar1 = str_replace(' ', '', $request->file('gambar')->getClientOriginalName());
            $namagambar1 = 'pengambilan_do/' . date('mYdHs') . rand(1, 10) . '_' . $gambar1;
            $request->file('gambar')->storeAs('public/uploads/', $namagambar1);
        }

        // Menyiapkan file 'gambar2' jika ada
        $namagambar2 = null;
        if ($request->hasFile('gambar2') && $request->file('gambar2')->isValid()) {
            $gambar2 = str_replace(' ', '', $request->file('gambar2')->getClientOriginalName());
            $namagambar2 = 'pengambilan_do/' . date('mYdHs') . rand(1, 10) . '_' . $gambar2;
            $request->file('gambar2')->storeAs('public/uploads/', $namagambar2);
        }

        // Menyiapkan file 'gambar3' jika ada
        $namagambar3 = null;
        if ($request->hasFile('gambar3') && $request->file('gambar3')->isValid()) {
            $gambar3 = str_replace(' ', '', $request->file('gambar3')->getClientOriginalName());
            $namagambar3 = 'pengambilan_do/' . date('mYdHs') . rand(1, 10) . '_' . $gambar3;
            $request->file('gambar3')->storeAs('public/uploads/', $namagambar3);
        }

        // Memperbarui entri di database
        $pengambilan_do->update([
            'gambar' => $namagambar1,
            'gambar2' => $namagambar2,
            'gambar3' => $namagambar3,
        ]);

        return response()->json([
            'status' => true,
            'msg' => 'Berhasil Memperbarui Foto Muat',
        ]);
    }

    public function bukti_fotoselesai(Request $request, $id)
    {
        // Temukan model berdasarkan ID
        $pengambilan_do = Pengambilan_do::find($id);

        if (!$pengambilan_do) {
            return response()->json([
                'status' => false,
                'msg' => 'Data tidak ditemukan.',
            ], 404);
        }

        $kendaraan = Kendaraan::find($pengambilan_do->kendaraan_id);

        if (
            $kendaraan->akses_lokasi == 1
        ) {

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

                $alamat_muat = Alamat_bongkar::where(
                    'id',
                    $pengambilan_do->alamat_bongkar_id
                )->first();
                // Temukan objek Kendaraan berdasarkan kendaraan_id dari pengambilan_do

                $alamat_muat2 = null;
                $alamat_muat3 = null;

                if ($pengambilan_do->alamat_bongkar2_id != null) {
                    $alamat_muat2 = Alamat_bongkar::where('id', $pengambilan_do->alamat_bongkar2_id)->first();
                }
                if ($pengambilan_do->alamat_bongkar3_id != null) {
                    $alamat_muat3 = Alamat_bongkar::where('id', $pengambilan_do->alamat_bongkar3_id)->first();
                }

                $latitude_do = $alamat_muat->latitude;
                $longitude_do = $alamat_muat->longitude;

                $latitude_kendaraan = $kendaraan->latitude;
                $longitude_kendaraan = $kendaraan->longitude;

                // Hitung jarak menggunakan Haversine Formula
                $distance = $this->calculateDistance($latitude_do, $longitude_do, $latitude_kendaraan, $longitude_kendaraan);

                // Ambil radius yang diperbolehkan dari kolom 'jarak'
                $jarak_titik = Jarak_titik::first();
                if (
                    !$jarak_titik || $jarak_titik->jarak <= 0
                ) {
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

                // Jika jarak lebih dari allowedRadius, kembalikan respon bahwa kendaraan masih jauh
                if ($distance > $allowedRadius) {
                    return response()->json([
                        'status' => false,
                        'msg' => 'Tidak dapat melakukan update karena masih jauh dari tujuan, jarak anda dari tujuan sekitar ' . round($distance, 2) . ' km.',
                    ], 200);
                }
            }
        }
        // Validasi bahwa file diupload
        if (!$request->hasFile('bukti') || !$request->file('bukti')->isValid()) {
            return response()->json([
                'status' => false,
                'msg' => 'File bukti tidak valid.',
            ], 200);
        }

        // Menyiapkan nama file untuk penyimpanan
        $bukti = str_replace(' ', '', $request->file('bukti')->getClientOriginalName());
        $namabukti = 'bukti/' . date('mYdHs') . rand(1, 10) . '_' . $bukti;
        // Menyimpan file ke storage
        $request->file('bukti')->storeAs('public/uploads/', $namabukti);


        // Menyiapkan file 'bukti2' jika ada
        $namabukti2 = null;
        if ($request->hasFile('bukti2') && $request->file('bukti2')->isValid()) {
            $bukti2 = str_replace(' ', '', $request->file('bukti2')->getClientOriginalName());
            $namabukti2 = 'bukti/' . date('mYdHs') . rand(1, 10) . '_' . $bukti2;
            $request->file('bukti2')->storeAs('public/uploads/', $namabukti2);
        }

        // Menyiapkan file 'gambar3' jika ada
        $namabukti3 = null;
        if ($request->hasFile('bukti3') && $request->file('bukti3')->isValid()) {
            $bukti3 = str_replace(' ', '', $request->file('bukti3')->getClientOriginalName());
            $namabukti3 = 'bukti/' . date('mYdHs') . rand(1, 10) . '_' . $bukti3;
            $request->file('bukti3')->storeAs('public/uploads/', $namabukti3);
        }


        $kendaraan = Kendaraan::find($pengambilan_do->kendaraan_id);

        $odometer = null; // Inisialisasi variabel odometer

        if ($kendaraan) {
            try {
                // Panggilan ke API pertama
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

                    // Periksa apakah vehicle_id sama dengan list_vehicle_id
                    if ($vehicleId === $kendaraan->list_vehicle_id) {
                        // Ambil nilai 'odometer' dari data API dan hilangkan bagian desimalnya
                        $odometer = intval($data['Data'][0]['odometer'] ?? 0);

                        if ($odometer > 0) {
                            $kendaraan->km = $odometer;
                            $kendaraan->save();
                        }
                    } else {
                        // Gunakan API kedua jika vehicle_id tidak cocok
                        $this->fetchFromSecondAPIs($kendaraan);
                    }
                } else {
                    // Jika vehicle_id tidak ditemukan, langsung gunakan API kedua
                    $this->fetchFromSecondAPIs($kendaraan);
                }
            } catch (\Exception $e) {
                // Tangkap error dari API pertama dan log error tersebut
                // Lanjutkan ke API kedua jika API pertama gagal
                $this->fetchFromSecondAPIs($kendaraan);
            }
        }

        /**
         * Fungsi untuk mengambil data dari API kedua
         */

        // Memperbarui entri di database
        $pengambilan_do->update([
            'bukti' => $namabukti,
            'bukti2' => $namabukti2,
            'bukti3' => $namabukti3,
            'status' => 'selesai',
            'km_akhir' => $kendaraan ? $kendaraan->km : null,
            'waktu_akhir' => now()->format('Y-m-d H:i:s')
        ]);

        // Menghitung jarak waktu
        $waktuTungguMuat = $pengambilan_do->updated_at;
        $waktuPerjalananIsi = now();
        $jarakWaktu = $waktuTungguMuat->diff($waktuPerjalananIsi)->format('%d %H:%I');

        // Memperbarui kendaraan terkait
        if ($kendaraan) {
            $currentStatusPerjalanan = $kendaraan->status_perjalanan;
            $currentTimer = $kendaraan->waktu;

            $kendaraan->update([
                'status_perjalanan' => 'Kosong',
                'timer' => $jarakWaktu,
                'km_akhir' => $kendaraan->km,
                'waktu' => now()->format('Y-m-d H:i:s')
            ]);

            // Retrieve the updated status_perjalanan for status_akhir
            $updatedStatusPerjalanan = $kendaraan->fresh()->status_perjalanan;
            $currentTimestamp = now()->format('Y-m-d H:i:s');

            // Create Timer record with the old and new status, and the old timer
            Timer::create(array_merge(
                $request->all(),
                [
                    'kendaraan_id' => $kendaraan->id,
                    'pengambilan_do_id' => $id,
                    'status_awal' => $currentStatusPerjalanan,
                    'status_akhir' => $updatedStatusPerjalanan,
                    'timer_awal' => $currentTimer,
                    'timer_akhir' => $currentTimestamp,
                ]
            ));
        }

        // Jika proses berhasil, kembalikan respons sukses
        return response()->json([
            'status' => true,
            'msg' => 'Pengambilan Do Selesai',
        ]);
    }

    public function fetchFromSecondAPIs($kendaraan)
    {
        try {
            // Panggilan ke API kedua
            $response = Http::get('https://app1.muliatrack.com/wspubjavasnackfactory/service.asmx/GetJsonPosition?sTokenKey=gps-J@va');

            if ($response->successful()) {
                $vehicles = $response->json();
                $matchedVehicle = collect($vehicles)->firstWhere('gpsid', $kendaraan->gpsid);

                if ($matchedVehicle) {
                    $odometer = intval($matchedVehicle['odometer'] ?? $kendaraan->km);

                    if ($odometer > 0) {
                        $kendaraan->km = $odometer;
                        $kendaraan->save();
                    }
                } else {
                    // Jika tidak ada kendaraan yang cocok, gunakan nilai km yang ada
                    $kendaraan->km = $kendaraan->km;
                    $kendaraan->save();
                }
            }
        } catch (\Exception $e) {
            // Tangkap error dari API kedua dan log error tersebut
        }
    }

    public function bukti_fotoselesaiperbarui(Request $request, $id)
    {
        // Temukan model berdasarkan ID
        $pengambilan_do = Pengambilan_do::find($id);

        if (!$pengambilan_do) {
            return response()->json([
                'status' => false,
                'msg' => 'Data tidak ditemukan.',
            ], 404);
        }

        // Validasi bahwa file diupload
        if (!$request->hasFile('bukti') || !$request->file('bukti')->isValid()) {
            return response()->json([
                'status' => false,
                'msg' => 'File bukti tidak valid.',
            ], 200);
        }

        // Menyiapkan file 'bukti1' jika ada
        $namabukti1 = null;
        if ($request->hasFile('bukti') && $request->file('bukti')->isValid()) {
            $bukti1 = str_replace(' ', '', $request->file('bukti')->getClientOriginalName());
            $namabukti1 = 'bukti/' . date('mYdHs') . rand(1, 10) . '_' . $bukti1;
            $request->file('bukti')->storeAs('public/uploads/', $namabukti1);
        }

        // Menyiapkan file 'bukti2' jika ada
        $namabukti2 = null;
        if ($request->hasFile('bukti2') && $request->file('bukti2')->isValid()) {
            $bukti2 = str_replace(' ', '', $request->file('bukti2')->getClientOriginalName());
            $namabukti2 = 'bukti/' . date('mYdHs') . rand(1, 10) . '_' . $bukti2;
            $request->file('bukti2')->storeAs('public/uploads/', $namabukti2);
        }

        // Menyiapkan file 'gambar3' jika ada
        $namabukti3 = null;
        if ($request->hasFile('bukti3') && $request->file('bukti3')->isValid()) {
            $bukti3 = str_replace(' ', '', $request->file('bukti3')->getClientOriginalName());
            $namabukti3 = 'bukti/' . date('mYdHs') . rand(1, 10) . '_' . $bukti3;
            $request->file('bukti3')->storeAs('public/uploads/', $namabukti3);
        }

        // Memperbarui entri di database
        $pengambilan_do->update([
            'bukti' => $namabukti1,
            'bukti2' => $namabukti2,
            'bukti3' => $namabukti3,
        ]);

        return response()->json([
            'status' => true,
            'msg' => 'Status Berhasil Memperbarui Foto',
        ]);
    }

    public function konfirmasi_selesai(Request $request, $id)
    {
        // Temukan model berdasarkan ID
        $pengambilan_do = Pengambilan_do::find($id);

        if (!$pengambilan_do) {
            return response()->json([
                'status' => false,
                'msg' => 'Data tidak ditemukan.',
            ], 404);
        }

        // Validasi data request
        $request->validate([
            'user_id' => 'required|integer|exists:users,id', // Pastikan user_id valid
        ]);

        // Memperbarui entri di database
        $pengambilan_do->user_id = $request->user_id;
        $pengambilan_do->status = 'selesai';
        $proses = $pengambilan_do->save();

        if (!$proses) {
            return response()->json([
                'status' => false,
                'msg' => 'Gagal memperbarui data.',
            ], 500);
        }

        // Menghitung jarak waktu
        $waktuTungguMuat = $pengambilan_do->updated_at;
        $waktuPerjalananIsi = now();
        $jarakWaktu = $waktuTungguMuat->diff($waktuPerjalananIsi)->format('%d %H:%I');

        // Memperbarui kendaraan terkait
        $kendaraan = Kendaraan::find($pengambilan_do->kendaraan_id);

        $currentStatusPerjalanan = $kendaraan->status_perjalanan;
        $currentTimer = $kendaraan->waktu;

        if ($kendaraan) {
            $kendaraan->update([
                'status_perjalanan' => null,
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
                    'kendaraan_id' => $kendaraan->id,
                    'pengambilan_do_id' => $id,
                    'status_awal' => $currentStatusPerjalanan,
                    'status_akhir' => $updatedStatusPerjalanan,
                    'timer_awal' => $currentTimer,
                    'timer_akhir' => $currentTimestamp,
                ]
            ));
        }

        return response()->json([
            'status' => true,
            'msg' => 'Status Berhasil',
        ]);
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
}
