<?php

namespace App\Http\Controllers\Pelanggan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Models\Kendaraan;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class MonitoringkendaraanController extends Controller
{

    public function index(Request $request)
    {
        $user = auth()->user(); // Pastikan untuk mendapatkan pengguna yang sedang login
        $pelanggan = Pelanggan::where('id', $user->pelanggan_id)->first();

        // Ambil semua kendaraan yang terkait dengan pelanggan yang login
        $kendaraanall = Kendaraan::with(['latestpengambilan_do.spk.pelanggan'])
            ->whereHas('latestpengambilan_do.spk.pelanggan', function ($query) use ($user) {
                $query->where('id', $user->pelanggan_id); // Hanya ambil kendaraan berdasarkan pelanggan yang login
            })
            ->whereHas('latestpengambilan_do', function ($query) {
                $query->where('status_perjalanan', '!=', 'Kosong'); // Pastikan status perjalanan tidak kosong
            })
            ->get();

        $status = $request->status_perjalanan;
        $kendaraanId = $request->kendaraan_id; // ID kendaraan yang dipilih
        $pelangganId = $request->pelanggan_id;
        $divisi = $request->divisi; // Ambil nilai divisi dari request

        // Inisialisasi query builder
        $inquery = Kendaraan::with(['latestpengambilan_do.spk.pelanggan']); // Include relasi pelanggan

        $hasSearch = $status || $kendaraanId || $pelangganId || $divisi;
        $odometer = null;

        if ($hasSearch) {
            // Jika "All Kendaraan" dipilih, tidak perlu filter lebih lanjut
            if ($kendaraanId && $kendaraanId !== 'all') {
                $inquery->where('id', $kendaraanId);
            } else {
                // Jika 'all' dipilih, ambil semua kendaraan berdasarkan pelanggan yang login
                $inquery->whereHas('latestpengambilan_do.spk.pelanggan', function ($query) use ($user) {
                    $query->where('id', $user->pelanggan_id);
                })
                    ->whereHas('latestpengambilan_do', function ($query) {
                        $query->where('status_perjalanan', '!=', 'Kosong'); // Pastikan status perjalanan tidak kosong
                    });
            }

            // Lakukan pencarian berdasarkan status dan divisi jika ada
            if ($status) {
                $inquery->where('status_perjalanan', $status);
            }

            // Filter berdasarkan pelanggan_id jika diberikan
            if ($pelangganId) {
                $inquery->whereHas('latestpengambilan_do.spk.pelanggan', function ($query) use ($pelangganId) {
                    $query->where('id', $pelangganId);
                });
            }

            // Ambil kendaraan yang sesuai dengan kriteria pencarian
            $kendaraans = $inquery->orderBy('user_id', 'desc')
                ->orderBy('updated_at', 'desc')
                ->get()
                ->sort(function ($a, $b) {
                    $numberA = (int) filter_var($a->no_kabin, FILTER_SANITIZE_NUMBER_INT);
                    $numberB = (int) filter_var($b->no_kabin, FILTER_SANITIZE_NUMBER_INT);
                    return $numberA - $numberB;
                });

            $waktuPerjalananIsi = now();

            foreach ($kendaraans as $kendaraan) {
                $waktuTungguMuat = $kendaraan->updated_at;
                $jarakWaktu = $waktuTungguMuat->diffInSeconds($waktuPerjalananIsi);

                // Timer calculation
                $timerParts = explode(' ', $kendaraan->timer);
                $hari = (int)$timerParts[0];
                $jamMenit = explode(':', $timerParts[1]);
                $jam = (int)$jamMenit[0];
                $menit = (int)$jamMenit[1];

                $totalDetik = ($hari * 24 * 60 * 60) + ($jam * 60 * 60) + ($menit * 60);
                $totalDetik += $jarakWaktu;

                $hariBaru = floor($totalDetik / (24 * 60 * 60));
                $totalDetik %= (24 * 60 * 60);
                $jamBaru = floor($totalDetik / (60 * 60));
                $totalDetik %= (60 * 60);
                $menitBaru = floor($totalDetik / 60);

                $formattedTimer = sprintf('%d %02d:%02d', $hariBaru, $jamBaru, $menitBaru);
                $kendaraan->update([
                    'timer' => $formattedTimer
                ]);

                $odometer = null; // Inisialisasi variabel $odometer
                $latitude = null; // Inisialisasi variabel $latitude
                $longitude = null; // Inisialisasi variabel $longitude
                $lokasi = null; // Inisialisasi variabel $longitude
                $status_kendaraan = null; // Inisialisasi variabel $longitude

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
            }
        } else {
            $kendaraans = collect(); // Kosongkan data kendaraan jika tidak ada pencarian
        }


        // Menghitung timer dan melakukan update
        // (Kode penghitungan timer tetap sama)

        return view('pelanggan.monitoring_kendaraan.index', compact('kendaraans', 'kendaraanall'));
    }

    public function update_latlong($id)
    {
        $kendaraan = Kendaraan::find($id);

        if ($kendaraan->gpsid != null) {
            if ($kendaraan) {
                try {
                    // Panggil API kedua
                    $response = Http::get('https://app1.muliatrack.com/wspubjavasnackfactory/service.asmx/GetJsonPosition?sTokenKey=gps-J@va');
                    if ($response->successful()) {
                        $vehicles = $response->json();
                        $matchedVehicle = collect($vehicles)->firstWhere('gpsid', $kendaraan->gpsid);

                        if ($matchedVehicle) {
                            $odometer = $matchedVehicle['odometer'] ?? $kendaraan->km;
                            $latitude = $matchedVehicle['lat'] ?? null; // Ambil latitude
                            $longitude = $matchedVehicle['long'] ?? null; // Ambil longitude

                            if ($odometer > 0) {
                                $kendaraan->km = $odometer;
                            }
                            if ($latitude !== null && $longitude !== null) {
                                $kendaraan->latitude = $latitude;
                                $kendaraan->longitude = $longitude;
                            }

                            // Simpan perubahan ke database
                            $kendaraan->save();

                            return response()->json([
                                'success' => true,
                                'latitude' => $latitude,
                                'longitude' => $longitude,
                            ]);
                        } else {
                            // Jika tidak ditemukan, tetap kembalikan odometer sebelumnya
                            $odometer = $kendaraan->km;
                        }
                    } else {
                        // Jika respons dari API kedua tidak sukses
                        $odometer = $kendaraan->km;
                    }
                } catch (\Exception $e) {
                    // Tangkap error dari API kedua dan log jika diperlukan
                    return response()->json([
                        'success' => false,
                        'message' => 'Tidak terhubung ke API.',
                    ]);
                }
            }
        } else {
            if ($kendaraan) {
                try {
                    $client = new \GuzzleHttp\Client();
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
                            $odometer = intval($data['Data'][0]['odometer'] ?? 0);
                            $latitude = $data['Data'][0]['lat'] ?? null;
                            $longitude = $data['Data'][0]['lon'] ?? null;

                            if ($odometer > 0) {
                                $kendaraan->km = $odometer;
                            }
                            if ($latitude !== null && $longitude !== null) {
                                $kendaraan->latitude = $latitude;
                                $kendaraan->longitude = $longitude;
                            }

                            // Simpan perubahan ke database
                            $kendaraan->save();

                            return response()->json([
                                'success' => true,
                                'latitude' => $latitude,
                                'longitude' => $longitude,
                            ]);
                        }
                    }
                } catch (\Exception $e) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Tidak terhubung ke GPS.'
                    ]);
                }
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Kendaraan tidak ditemukan.',
        ]);
    }
}