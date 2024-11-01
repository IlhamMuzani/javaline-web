<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Models\Pengambilan_do;
use App\Models\User;
use Illuminate\Http\Request;

class HistorysuratjalanController extends Controller
{

    public function list_historydo(Request $request, $id)
    {
        $user = User::where('id', $id)->first();
        $pelanggan = Pelanggan::where('id', $user->pelanggan_id)->first();

        if (!$pelanggan) {
            return $this->response(
                FALSE,
                ['Pelanggan tidak ditemukan!']
            );
        }

        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        // Jika tidak ada filter tanggal, kembalikan data kosong
        if (!$tanggal_awal && !$tanggal_akhir) {
            $pengambilando = collect(); // Data kosong
        } else {
            $pengambilando = Pengambilan_do::with('kendaraan', 'spk')
            ->whereHas('spk', function ($query) use ($pelanggan) {
                $query->where('pelanggan_id', $pelanggan->id);
            })
                ->where('status', 'selesai'); // Hanya tampilkan yang berstatus selesai

            if ($tanggal_awal && $tanggal_akhir) {
                $pengambilando->whereBetween('tanggal_awal', [$tanggal_awal, $tanggal_akhir]);
            } elseif ($tanggal_awal) {
                $pengambilando->where('tanggal_awal', '>=', $tanggal_awal);
            } elseif ($tanggal_akhir) {
                $pengambilando->where('tanggal_awal', '<=', $tanggal_akhir);
            }

            $pengambilando->orderBy('id', 'DESC');
            $pengambilando = $pengambilando->get();
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