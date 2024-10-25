<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use App\Models\Pengambilan_do;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Carbon\Carbon;

class MonitoringsuratjalanController extends Controller
{
    public function index(Request $request)
    {
        // Mendapatkan input dari select divisi
        $divisi = $request->input('divisi');

        // Query dasar untuk mendapatkan data dengan status_suratjalan 'belum pulang'
        $spks = Pengambilan_do::with('kendaraan')
            ->whereNotNull('spk_id')
            ->where('status_suratjalan', 'belum pulang')
            ->whereNull('waktu_suratakhir'); // Filter untuk waktu_suratakhir yang null

        // Filter berdasarkan nomor kabin kendaraan jika divisi dipilih
        if (!empty($divisi) && $divisi != 'All') {
            $spks->whereHas('kendaraan', function ($query) use ($divisi) {
                $query->where('no_kabin', 'LIKE', $divisi . '%');
            });
        }

        // Mengurutkan berdasarkan id secara descending
        $spks = $spks->orderBy('waktu_suratawal', 'ASC')->get();

        // Perulangan untuk menghitung durasi di controller
        foreach ($spks as $spk) {
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

        // Kirim data ke Blade
        return view('admin.monitoring_suratjalan.index', compact('spks'));
    }

    // public function show($id)
    // {
    //     $cetakpdf = Pengambilan_do::find($id);
    //     $kendaraan = Kendaraan::find($cetakpdf->kendaraan_id);
    //     $odometer = null; // Inisialisasi variabel $odometer

    //     if ($kendaraan) {
    //         $client = new Client();
    //         $response = $client->post('https://vtsapi.easygo-gps.co.id/api/Report/lastposition', [
    //             'headers' => [
    //                 'accept' => 'application/json',
    //                 'token' => 'B13E7A18C7FF4E80B9A252F54DB3D939',
    //                 'Content-Type' => 'application/json',
    //             ],
    //             'json' => [
    //                 'list_vehicle_id' => [$kendaraan->list_vehicle_id],
    //                 'list_nopol' => [],
    //                 'list_no_aset' => [],
    //                 'geo_code' => [],
    //                 'min_lastupdate_hour' => null,
    //                 'page' => 0,
    //                 'encrypted' => 0,
    //             ],
    //         ]);

    //         $data = json_decode($response->getBody()->getContents(), true);

    //         if (isset($data['Data'][0]['vehicle_id'])) {
    //             $vehicleId = $data['Data'][0]['vehicle_id'];

    //             // Periksa apakah vehicle_id sama dengan list_vehicle_id
    //             if ($vehicleId === $kendaraan->list_vehicle_id) {
    //                 // Ambil nilai 'odometer' dari data API dan hilangkan bagian desimalnya
    //                 $odometer = intval($data['Data'][0]['odometer'] ?? 0);

    //                 if ($odometer > 0) {
    //                     $kendaraan->km = $odometer;
    //                     $kendaraan->save();
    //                 }
    //             } else {
    //                 // Gunakan API lain jika vehicle_id tidak cocok
    //                 $response = Http::get('https://app1.muliatrack.com/wspubjavasnackfactory/service.asmx/GetJsonPosition?sTokenKey=gps-J@va');
    //                 if ($response->successful()) {
    //                     $vehicles = $response->json();
    //                     $matchedVehicle = collect($vehicles)->firstWhere('gpsid', $kendaraan->gpsid);

    //                     if ($matchedVehicle) {
    //                         $odometer = $matchedVehicle['odometer'] ?? $kendaraan->km;

    //                         if ($odometer > 0) {
    //                             $kendaraan->km = $odometer;
    //                             $kendaraan->save();
    //                         }

    //                     } else {
    //                         $odometer = $kendaraan->km;

    //                         if ($odometer > 0) {
    //                             $kendaraan->km = $odometer;
    //                             $kendaraan->save();
    //                         }
    //                     }
    //                 }
    //             }
    //         }
    //     }

    //     // Pastikan variabel $odometer dimasukkan dalam compact
    //     return view('admin.monitoring_suratjalan.show', compact('cetakpdf', 'odometer'));
    // }

    public function show($id)
    {
        $cetakpdf = Pengambilan_do::find($id);
        $kendaraan = Kendaraan::find($cetakpdf->kendaraan_id);
        $odometer = null; // Inisialisasi variabel $odometer

        if ($kendaraan) {
            try {
                // API pertama
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
                        // Jika vehicle_id tidak cocok, gunakan API kedua
                        $this->ambilDariApiKedua($kendaraan, $odometer);
                    }
                }
            } catch (\Exception $e) {
                // Tangkap error API pertama dan log jika diperlukan

                // Jika terjadi error pada API pertama, gunakan API kedua
                $this->ambilDariApiKedua($kendaraan, $odometer);
            }
        }

        // Pastikan variabel $odometer dimasukkan dalam compact
        return view('admin.monitoring_suratjalan.show', compact('cetakpdf', 'odometer'));
    }

    // Fungsi untuk menangani pemanggilan API kedua
    private function ambilDariApiKedua($kendaraan, &$odometer)
    {
        try {
            // Panggil API kedua
            $response = Http::get('https://app1.muliatrack.com/wspubjavasnackfactory/service.asmx/GetJsonPosition?sTokenKey=gps-J@va');
            if ($response->successful()) {
                $vehicles = $response->json();
                $matchedVehicle = collect($vehicles)->firstWhere('gpsid', $kendaraan->gpsid);

                if ($matchedVehicle) {
                    $odometer = $matchedVehicle['odometer'] ?? $kendaraan->km;

                    if ($odometer > 0) {
                        $kendaraan->km = $odometer;
                        $kendaraan->save();
                    }
                } else {
                    $odometer = $kendaraan->km;
                }
            } else {
                // Jika respons dari API kedua tidak sukses
                $odometer = $kendaraan->km;
            }
        } catch (\Exception $e) {
            // Tangkap error dari API kedua dan log jika diperlukan
            $odometer = $kendaraan->km;
        }
    }
}
