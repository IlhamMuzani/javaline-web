<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_user' => 'required',
            'password' => 'required',
        ], [
            'kode_user.required' => 'Kode tidak boleh kosong!',
            'password.required' => 'Password tidak boleh kosong!',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return $this->response(FALSE, $error);
        }

        $kode_user = $request->kode_user;
        $password = $request->password;

        $user = User::where('kode_user', $kode_user)
            ->whereHas('karyawan', function ($query) {
                $query->whereIn('departemen_id', [2, 5]); // Mengizinkan departemen 2 dan 5
            })
            ->first();
        if ($user) {
            if (password_verify($password, $user->password)) {
                return $this->response(TRUE, array('Berhasil login, Selamat Datang ' . $user->name), array($user));
            } else {
                return $this->response(FALSE, array('Kode atau password tidak sesuai!'));
            }
        } else {
            return $this->response(FALSE, array('Pengguna tidak ditemukan!'));
        }
    }

    // public function detail($id)
    // {
    //     $user = User::where('id', $id)
    //         ->with(['karyawan', 'kendaraan', 'pengambilan_do', 'latestpengambilan_do' => function ($query) {
    //             $query->with('kendaraan');
    //         }])
    //         ->first();

    //     if ($user) {
    //         return $this->response(TRUE, ['Berhasil menampilkan data'], [$user]);
    //     } else {
    //         return $this->response(FALSE, ['Gagal menampilkan detail!']);
    //     }
    // }

    public function detail($id)
    {
        // Ambil data user beserta relasi yang dibutuhkan
        $user = User::where('id', $id)
            ->with(['karyawan', 'kendaraan', 'pengambilan_do', 'latestpengambilan_do.kendaraan'])
            ->first();

        // Pastikan user dan latestpengambilan_do ada
        if ($user && $user->latestpengambilan_do && $user->latestpengambilan_do->kendaraan) {
            $kendaraan = $user->latestpengambilan_do->kendaraan;

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

        // Return response ke frontend
        if ($user) {
            return $this->response(TRUE, ['Berhasil menampilkan data'], [$user]);
        } else {
            return $this->response(FALSE, ['Gagal menampilkan detail!']);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'kode_user' => 'required',
                'password' => 'required|min:6|confirmed',
            ],
            [
                'kode_user.required' => 'kode tidak boleh kosong',
                'password.required' => 'Password tidak boleh kosong',
                'password.min' => 'Password minimum 6 karakter',
                'password.confirmed' => 'Konfirmasi password tidak sesuai!',
            ]
        );

        // if (is_null($user)) {
        //     return $this->response(FALSE, 'Pendaftaran gagal, kode tidak ditemukan');
        // }
        $user = User::where('kode_user', $request->kode_user)->first();

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }


        User::where('kode_user', $request->kode_user)->update([
            'password' => bcrypt($request->password),
            'level' => 'admin',
        ]);

        if ($user) {
            return $this->response(TRUE, array('Berhasil melakukan pendaftaran'), array($user));
        } else {
            return $this->response(FALSE, 'Pendaftaran gagal, ' + $validator->errors()->all()[0]);
        }
    }



    // public function register(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'kode_user' => 'required|exists:users,kode_user',
    //         'password' => 'required|min:6|confirmed',
    //     ], [
    //         'kode_user.required' => 'Kode user harus diisi!',
    //         'kode_user.exists' => 'Kode user tidak ditemukan!',
    //         'password.required' => 'Password tidak boleh kosong!',
    //         'password.min' => 'Password minimal 6 karakter!',
    //         'password.confirmed' => 'Konfirmasi password tidak sesuai!',
    //     ]);

    //     if ($validator->fails()) {
    //         $errors = $validator->errors()->all();
    //         return $this->response(FALSE, $errors);
    //     }


    //     $user = User::where('kode_user', $request->kode_user)->update([
    //         'kode_user' => $request->kode_user,
    //         'password' => bcrypt($request->password),
    //         'level' => 'admin'
    //     ]);

    //     // ini sudah benar tpi tidak menggunakan update kode user
    //     // $user = User::where('kode_user', $request->kode_user)->update([
    //     //     'password' => bcrypt($request->password),
    //     //     'level' => 'admin'
    //     // ]);


    //     if ($user) {
    //         return $this->response(TRUE, array('Berhasil melakukan pendaftaran'), array($user));
    //     } else {
    //         return $this->response(FALSE, 'Pendaftaran gagal');
    //     }
    // }


    public function login_pelanggan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_user' => 'required',
            'password' => 'required',
        ], [
            'kode_user.required' => 'Kode tidak boleh kosong!',
            'password.required' => 'Password tidak boleh kosong!',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return $this->response(FALSE, $error);
        }

        $kode_user = $request->kode_user;
        $password = $request->password;

        $user = User::where('kode_user', $kode_user)
            ->first();
        if ($user) {
            if (password_verify($password, $user->password)) {
                return $this->response(TRUE, array('Berhasil login, Selamat Datang ' . $user->name), array($user));
            } else {
                return $this->response(FALSE, array('Kode atau password tidak sesuai!'));
            }
        } else {
            return $this->response(FALSE, array('Pengguna tidak ditemukan!'));
        }
    }


    public function detail_pelanggan($id)
    {
        $user = User::where('id', $id)
            ->with(['pelanggan'])
            ->first();

        if ($user) {
            return $this->response(TRUE, ['Berhasil menampilkan data'], [$user]);
        } else {
            return $this->response(FALSE, ['Gagal menampilkan detail!']);
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
}