<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Jarak_km;
use App\Models\Kendaraan;
use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KendaraanpelangganController extends Controller
{
    public function list_kendaraanid($id)
    {
        // Ambil user berdasarkan ID
        $user = User::find($id);

        // Pastikan user ditemukan
        if (!$user) {
            return $this->response(FALSE, ['User tidak ditemukan!']);
        }

        // Pastikan pelanggan terkait user ditemukan
        $pelanggan = Pelanggan::find($user->pelanggan_id);
        if (!$pelanggan) {
            return $this->response(FALSE, ['Pelanggan tidak ditemukan!']);
        }

        // Ambil kendaraan terkait pelanggan yang login dengan status perjalanan tidak kosong
        $kendaraans = Kendaraan::with([
            'latestpengambilan_do.spk.user.karyawan',
            'latestpengambilan_do.spk.pelanggan',
            'latestpengambilan_do.rute_perjalanan'
        ])
            ->whereHas('latestpengambilan_do.spk.pelanggan', function ($query) use ($user) {
                $query->where('id', $user->pelanggan_id);
            })
            ->whereHas('latestpengambilan_do', function ($query) {
                $query->where('status_perjalanan', '!=', 'Kosong');
            })
            ->get();

        $waktuPerjalananIsi = now();

        foreach ($kendaraans as $kendaraan) {
            $waktuTungguMuat = $kendaraan->updated_at;
            $jarakWaktu = $waktuTungguMuat->diffInSeconds($waktuPerjalananIsi);

            // Validasi timer format dan hitung ulang jika format benar
            if (isset($kendaraan->timer) && strpos($kendaraan->timer, ' ') !== false) {
                $timerParts = explode(' ', $kendaraan->timer);
                $hari = (int)$timerParts[0];
                $jamMenit = explode(':', $timerParts[1]);
                $jam = (int)$jamMenit[0];
                $menit = (int)$jamMenit[1];

                // Konversi total detik
                $totalDetik = ($hari * 24 * 60 * 60) + ($jam * 60 * 60) + ($menit * 60);
                $totalDetik += $jarakWaktu;

                // Hitung hari, jam, menit baru
                $hariBaru = floor($totalDetik / (24 * 60 * 60));
                $totalDetik %= (24 * 60 * 60);
                $jamBaru = floor($totalDetik / (60 * 60));
                $totalDetik %= (60 * 60);
                $menitBaru = floor($totalDetik / 60);

                $formattedTimer = sprintf('%d %02d:%02d', $hariBaru, $jamBaru, $menitBaru);
                $kendaraan->update([
                    'timer' => $formattedTimer
                ]);
            }
        }

        // Cek apakah ada kendaraan
        if ($kendaraans->isNotEmpty()) {
            return $this->response(TRUE, ['Berhasil menampilkan data'], $kendaraans);
        } else {
            return $this->response(FALSE, ['Tidak ada kendaraan yang sesuai!']);
        }
    }


    // public function kendaraan_search(Request $request, $id)
    // {
    //     // Ambil user berdasarkan ID
    //     $user = User::find($id);

    //     // Pastikan user ditemukan
    //     if (!$user) {
    //         return $this->response(FALSE, ['User tidak ditemukan!']);
    //     }

    //     // Pastikan pelanggan terkait user ditemukan
    //     $pelanggan = Pelanggan::find($user->pelanggan_id);
    //     if (!$pelanggan) {
    //         return $this->response(FALSE, ['Pelanggan tidak ditemukan!']);
    //     }

    //     $keyword = $request->keyword;

    //     // Pencarian data kendaraan berdasarkan relasi yang disebutkan
    //     $kendaraans = Kendaraan::with([
    //         'latestpengambilan_do.spk.user.karyawan',
    //         'latestpengambilan_do.spk.pelanggan',
    //         'latestpengambilan_do.rute_perjalanan'
    //     ])
    //         ->whereHas('latestpengambilan_do.spk.pelanggan', function ($query) use ($user) {
    //             // Filter kendaraan yang hanya berelasi dengan pelanggan user
    //             $query->where('id', $user->pelanggan_id);
    //         })
    //         ->where(function ($query) use ($keyword) {
    //             if ($keyword) {
    //                 // Filter berdasarkan no_pol
    //                 $query->where('no_pol', 'like', '%' . $keyword . '%')
    //                     // Filter berdasarkan status_perjalanan
    //                     ->orWhereHas('latestpengambilan_do', function ($query) use ($keyword) {
    //                         $query->where('status_perjalanan', 'like', '%' . $keyword . '%');
    //                     })
    //                     // Filter berdasarkan nama_lengkap dari relasi karyawan
    //                     ->orWhereHas('latestpengambilan_do.spk.user.karyawan', function ($query) use ($keyword) {
    //                         $query->where('nama_lengkap', 'like', '%' . $keyword . '%');
    //                     })
    //                     // Filter berdasarkan rute perjalanan
    //                     ->orWhereHas('latestpengambilan_do.rute_perjalanan', function ($query) use ($keyword) {
    //                         $query->where('nama_rute', 'like', '%' . $keyword . '%');
    //                     });
    //             }
    //         })
    //         ->get();

    //     // Cek apakah data ditemukan
    //     if ($kendaraans->isNotEmpty()) {
    //         return $this->response(TRUE, ['Berhasil menampilkan data'], $kendaraans);
    //     } else {
    //         return $this->response(FALSE, ['Gagal menampilkan data!']);
    //     }
    // }


    public function kendaraan_search(Request $request, $id)
    {
        // Ambil user berdasarkan ID
        $user = User::find($id);

        // Pastikan user ditemukan
        if (!$user) {
            return $this->response(FALSE, ['User tidak ditemukan!']);
        }

        // Pastikan pelanggan terkait user ditemukan
        $pelanggan = Pelanggan::find($user->pelanggan_id);
        if (!$pelanggan) {
            return $this->response(FALSE, ['Pelanggan tidak ditemukan!']);
        }

        $keyword = $request->keyword;

        // Pencarian data kendaraan berdasarkan relasi yang disebutkan
        $kendaraans = Kendaraan::with([
            'latestpengambilan_do.spk.user.karyawan',
            'latestpengambilan_do.spk.pelanggan',
            'latestpengambilan_do.rute_perjalanan'
        ])
            ->whereHas('latestpengambilan_do.spk.pelanggan', function ($query) use ($user) {
                // Filter kendaraan yang hanya berelasi dengan pelanggan user
                $query->where('id', $user->pelanggan_id);
            })
            ->whereHas('latestpengambilan_do', function ($query) {
                // Hanya ambil kendaraan yang status_perjalanan bukan "Kosong"
                $query->where('status_perjalanan', '!=', 'Kosong');
            })
            ->where(function ($query) use ($keyword) {
                if ($keyword) {
                    // Filter berdasarkan no_pol
                    $query->where('no_pol', 'like', '%' . $keyword . '%')
                        // Filter berdasarkan status_perjalanan
                        ->orWhereHas('latestpengambilan_do', function ($query) use ($keyword) {
                            $query->where('status_perjalanan', 'like', '%' . $keyword . '%');
                        })
                        // Filter berdasarkan nama_lengkap dari relasi karyawan
                        ->orWhereHas('latestpengambilan_do.spk.user.karyawan', function ($query) use ($keyword) {
                            $query->where('nama_lengkap', 'like', '%' . $keyword . '%');
                        })
                        // Filter berdasarkan rute perjalanan
                        ->orWhereHas('latestpengambilan_do.rute_perjalanan', function ($query) use ($keyword) {
                            $query->where('nama_rute', 'like', '%' . $keyword . '%');
                        });
                }
            })
            ->get();

        // Cek apakah data ditemukan
        if ($kendaraans->isNotEmpty()) {
            return $this->response(TRUE, ['Berhasil menampilkan data'], $kendaraans);
        } else {
            return $this->response(FALSE, ['Gagal menampilkan data!']);
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
