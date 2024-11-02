<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Alamat_bongkar;
use App\Models\Alamat_muat;
use App\Models\Jarak_titik;
use App\Models\Karyawan;
use App\Models\Kendaraan;
use App\Models\Memo_ekspedisi;
use App\Models\Pelanggan;
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

class MonitoringsuratjalanController extends Controller
{

    public function list_dopelanggan($id)
    {
        $user = User::where('id', $id)->first();
        $pelanggan = Pelanggan::where('id', $user->pelanggan_id)->first();

        if (!$pelanggan) {
            return $this->response(
                FALSE,
                ['Pelanggan tidak ditemukan!']
            );
        }

        // Query untuk mendapatkan data Pengambilan_do yang berelasi dengan spk milik pelanggan yang sedang login
        $pengambilando = Pengambilan_do::with('user.karyawan', 'kendaraan', 'spk', 'rute_perjalanan') // Pastikan untuk memuat relasi spk juga
            ->whereHas('spk', function ($query) use ($pelanggan) {
                $query->where('pelanggan_id', $pelanggan->id); // Filter spk berdasarkan pelanggan yang login
            })
            ->whereNotNull('spk_id')
            ->where('status_suratjalan', 'belum pulang')
            ->whereNull('waktu_suratakhir') // Filter untuk waktu_suratakhir yang null
            ->orderBy('waktu_suratawal', 'ASC') // Urutkan berdasarkan waktu_suratawal secara ascending
            ->get();

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

        // Cek apakah ada data yang ditemukan
        if ($pengambilando->isNotEmpty()) {
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

    public function response($status, $message, $data = null)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ]);
    }

}