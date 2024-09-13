<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use App\Models\Pengambilan_do;
use App\Models\Timer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class PengambilandoController extends Controller
{

    // public function list($id)
    // {
    //     // Mengambil data Pengambilan_do berdasarkan user_id dan status
    //     $pengambilando = Pengambilan_do::where([
    //         ['user_id', $id],
    //         ['status', '<>', 'unpost'] // Filter out entries where status is 'unpost'
    //     ])
    //         ->with(['kendaraan', 'rute_perjalanan', 'alamat_muat', 'alamat_bongkar', 'spk.pelanggan'])
    //         ->orderByRaw("
    //     CASE 
    //         WHEN status = 'posting' THEN 1
    //         WHEN status <> 'selesai' THEN 2
    //         WHEN status = 'selesai' THEN 3
    //         ELSE 4
    //     END
    // ") // Urutkan berdasarkan status
    //         ->orderByRaw("CASE WHEN status = 'posting' THEN created_at END DESC") // Urutkan berdasarkan created_at untuk status 'posting' (terbaru dulu)
    //         ->orderBy('id', 'asc') // Order by ID to ensure consistent ordering
    //         ->get();

    //     if ($pengambilando->isNotEmpty()) { // Check if there are any records
    //         return $this->response(TRUE, ['Berhasil menampilkan data'], $pengambilando);
    //     } else {
    //         return $this->response(
    //             FALSE,
    //             ['Gagal menampilkan data!']
    //         );
    //     }
    // }

    public function list($id)
    {
        // Mengambil data Pengambilan_do berdasarkan user_id dan status
        $pengambilando = Pengambilan_do::where([
            ['user_id', $id],
            ['status', '<>', 'unpost'] // Filter out entries where status is 'unpost'
        ])
            ->with(['kendaraan', 'rute_perjalanan', 'alamat_muat', 'alamat_bongkar', 'spk.pelanggan'])
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
                ], 400);
            }
        }

        $odometer = null; // Inisialisasi variabel odometer

        if ($kendaraan) {
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
                    // Gunakan API lain jika vehicle_id tidak cocok
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

                            if ($odometer > 0) {
                                $kendaraan->km = $odometer;
                                $kendaraan->save();
                            }
                        }
                    }
                }
            }
        }

        // Perbarui pengambilan_do dengan km_awal dari kendaraan
        $proses = $pengambilan_do->update([
            // 'user_id' => $request->user_id,
            'status' => 'loading muat',
            'km_awal' => $odometer,
            'waktu_awal' => now()->format('Y-m-d H:i:s')
        ]);

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
            'kendaraan_id' => $id,
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

        if (!$pengambilan_do) {
            return response()->json([
                'status' => false,
                'msg' => 'Data tidak ditemukan.',
            ], 404);
        }

        // Validasi bahwa file diupload
        if (!$request->hasFile('gambar') || !$request->file('gambar')->isValid()) {
            return response()->json([
                'status' => false,
                'msg' => 'Gambar tidak valid.',
            ], 400);
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
                    'kendaraan_id' => $id,
                    'status_awal' => $currentStatusPerjalanan,
                    'status_akhir' => $updatedStatusPerjalanan,
                    'timer_awal' => $currentTimer,
                    'timer_akhir' => $currentTimestamp,
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

        // Validasi bahwa file diupload
        if (!$request->hasFile('bukti') || !$request->file('bukti')->isValid()) {
            return response()->json([
                'status' => false,
                'msg' => 'File bukti tidak valid.',
            ], 400);
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
                    // Ambil nilai 'odometer' dari data API dan hilangkan bagian desimalnya
                    $odometer = intval($data['Data'][0]['odometer'] ?? 0);

                    if ($odometer > 0) {
                        $kendaraan->km = $odometer;
                        $kendaraan->save();
                    }
                } else {
                    // Gunakan API lain jika vehicle_id tidak cocok
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

                            if ($odometer > 0) {
                                $kendaraan->km = $odometer;
                                $kendaraan->save();
                            }
                        }
                    }
                }
            }
        }

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
                    'kendaraan_id' => $id,
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
            ], 400);
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
                    'kendaraan_id' => $id,
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
}
