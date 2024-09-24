<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\Divisi;
use App\Models\Golongan;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use App\Models\Jenis_kendaraan;
use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\Kota;
use App\Models\Laporanperjalanan;
use App\Models\Pelanggan;
use App\Models\Timer;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class StatusPerjalananController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->check() && auth()->user()->menu['status perjalanan kendaraan']) {

            $status = $request->status_perjalanan;
            $kendaraanId = $request->kendaraan_id;
            $pelangganId = $request->pelanggan_id;
            $divisi = $request->divisi; // Ambil nilai divisi dari request

            // Inisialisasi query builder
            $inquery = Kendaraan::with(['latestpengambilan_do.spk.pelanggan']); // Include relasi pelanggan

            $hasSearch = $status || $kendaraanId || $pelangganId || $divisi;
            $odometer = null;

            if ($hasSearch) {
                if ($status) {
                    $inquery->where('status_perjalanan', $status);
                }

                if ($kendaraanId) {
                    $inquery->where('id', $kendaraanId);
                }

                // Filter berdasarkan pelanggan_id jika diberikan
                if ($pelangganId) {
                    $inquery->whereHas('latestpengambilan_do.spk.pelanggan', function ($query) use ($pelangganId) {
                        $query->where('id', $pelangganId);
                    });
                }

                // Tambahkan filter berdasarkan divisi (awalan nokabin)
                if ($divisi) {
                    $inquery->where('no_kabin', 'like', "$divisi%");
                }

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
            $pelanggans = Pelanggan::get();

            return view('admin/status_perjalanan.index', compact('kendaraans', 'pelanggans', 'odometer'));
        } else {
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
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


    // // sudah benar mengambil latlong mulyatrek
    // public function update_latlong($id)
    // {
    //     $kendaraan = Kendaraan::find($id);
    //     if ($kendaraan) {
    //         try {
    //             // Panggil API kedua
    //             $response = Http::get('https://app1.muliatrack.com/wspubjavasnackfactory/service.asmx/GetJsonPosition?sTokenKey=gps-J@va');
    //             if ($response->successful()) {
    //                 $vehicles = $response->json();
    //                 $matchedVehicle = collect($vehicles)->firstWhere('gpsid', $kendaraan->gpsid);

    //                 if ($matchedVehicle) {
    //                     $odometer = $matchedVehicle['odometer'] ?? $kendaraan->km;
    //                     $latitude = $matchedVehicle['lat'] ?? null; // Ambil latitude
    //                     $longitude = $matchedVehicle['long'] ?? null; // Ambil longitude

    //                     if ($odometer > 0) {
    //                         $kendaraan->km = $odometer;
    //                     }
    //                     if ($latitude !== null && $longitude !== null) {
    //                         $kendaraan->latitude = $latitude;
    //                         $kendaraan->longitude = $longitude;
    //                     }

    //                     // Simpan perubahan ke database
    //                     $kendaraan->save();

    //                     return response()->json([
    //                         'success' => true,
    //                         'latitude' => $latitude,
    //                         'longitude' => $longitude,
    //                     ]);
    //                 } else {
    //                     // Jika tidak ditemukan, tetap kembalikan odometer sebelumnya
    //                     $odometer = $kendaraan->km;
    //                 }
    //             } else {
    //                 // Jika respons dari API kedua tidak sukses
    //                 $odometer = $kendaraan->km;
    //             }
    //         } catch (\Exception $e) {
    //             // Tangkap error dari API kedua dan log jika diperlukan
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Tidak terhubung ke API.',
    //             ]);
    //         }
    //     }

    //     return response()->json([
    //         'success' => false,
    //         'message' => 'Kendaraan tidak ditemukan.',
    //     ]);
    // }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'status_perjalanan' => 'required',
                'kota_id' => 'required',
            ],
            [
                'status_perjalanan.required' => 'Pilih Status',
                'kota_id.required' => 'Pilih tujuan',
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }

        $kendaraan = Kendaraan::findOrFail($id);
        $currentStatusPerjalanan = $kendaraan->status_perjalanan;
        $currentTimer = $kendaraan->waktu;

        $kendaraan->update([
            'kota_id' => $request->kota_id,
            'status_perjalanan' => $request->status_perjalanan,
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

        return redirect('admin/status_perjalanan')->with('success', 'Berhasil merubah');
    }

    public function konfirmasiselesai($id)
    {
        $kendaraan = Kendaraan::where('id', $id)->first();

        if ($kendaraan) {
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
                'timer' => $kendaraan->timer,
                'kota_id' => $kendaraan->kota_id,
                // Anda dapat menambahkan kolom-kolom lain yang perlu diisi sesuai dengan tabel Laporanperjalanan
            ]);

            $kendaraan->update([
                'status_perjalanan' => null,
                'kota_id' => null,
                'user_id' => null,
            ]);

            return back()->with('success', 'Berhasil');
        } else {
            return back()->with('error', 'Kendaraan tidak ditemukan');
        }
    }

    public function driver($id)
    {
        $user = User::where('id', $id)->with('karyawan')->first();

        return json_decode($user);
    }
}
