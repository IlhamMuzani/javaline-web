<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use App\Models\Nokir;
use App\Models\Stnk;

class DashboardController extends Controller
{
    public function index()
    {
        $currentDate = now(); // Menggunakan Carbon untuk mendapatkan tanggal saat ini
        $oneMonthLater = $currentDate->copy()->addMonth(); // Menambahkan 1 bulan ke tanggal saat ini

        $nokirs1 = Nokir::where('status_kir', 'sudah perpanjang')
            ->whereDate('masa_berlaku', '<', $oneMonthLater)
            ->get();

        foreach ($nokirs1 as $nokir) {
            $nokir->update([
                'status_kir' => 'belum perpanjang',
                'status_notif' => false,
            ]);
        }

        $stnks1 = Stnk::where('status_stnk', 'sudah perpanjang')
            ->whereDate('expired_stnk', '<', $oneMonthLater)
            ->get();

        foreach ($stnks1 as $stnk) {
            $stnk->update([
                'status_stnk' => 'belum perpanjang',
                'status_notif' => false,
            ]);
        }


        $km_olis = Kendaraan::where(
            [
                'status' => 'sudah penggantian',
                'status_oligardan' => 'sudah penggantian',
                'status_olitransmisi' => 'sudah penggantian',
            ]
        )->get();

        foreach ($km_olis as $km_oli) {
            $perbedaan_km_oli_mesin = abs($km_oli->km - $km_oli->km_olimesin);
            $perbedaan_km_oli_gardan = abs($km_oli->km - $km_oli->km_oligardan);
            $perbedaan_km_oli_transmisi = abs($km_oli->km - $km_oli->km_olitransmisi);

            if ($perbedaan_km_oli_mesin <= 1000) {
                $km_oli->update([
                    'status_olimesin' => 'belum penggantian',
                    'status_notifkm' => false,
                ]);
            }

            if ($perbedaan_km_oli_gardan <= 10000) {
                // Ubah status sesuai dengan kebutuhan Anda
                $km_oli->update([
                    'status_oligardan' => 'belum penggantian', // Ganti dengan status yang sesuai
                    'status_notifkm' => false, // Ganti dengan status notifikasi yang sesuai
                ]);
            }

            if ($perbedaan_km_oli_transmisi <= 10000) {
                // Ubah status sesuai dengan kebutuhan Anda
                $km_oli->update([
                    'status_olitransmisi' => 'belum penggantian', // Ganti dengan status yang sesuai
                    'status_notifkm' => false, // Ganti dengan status notifikasi yang sesuai
                ]);
            }
        }


        return view('admin.index');
    }
}