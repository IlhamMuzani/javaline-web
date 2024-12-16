<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\Pengambilan_do;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanmonitoringsjController extends Controller

{

    public function index(Request $request)
    {
        $status = $request->status;
        $kategori = $request->kategori;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;
        $karyawan_id = $request->karyawan_id;

        if ($karyawan_id) {
            $karyawan = Karyawan::find($karyawan_id);
            $nama_lengkap = $karyawan ? $karyawan->nama_lengkap : null;
        } else {
            $nama_lengkap = null;
        }

        $pengurus = Karyawan::select('id', 'kode_karyawan', 'nama_lengkap')
            ->where('departemen_id', '5')
            ->orderBy('nama_lengkap')
            ->get();

        $inquery = Pengambilan_do::query();

        if ($status) {
            $inquery->where('status', $status);
        } else {
            $inquery->where('status', '!=', 'unpost');
        }

        if ($kategori) {
            if ($kategori === 'belum_selesai') {
                $inquery->whereNull('waktu_suratakhir'); // waktu_suratakhir null
            } elseif ($kategori === 'selesai') {
                $inquery->whereNotNull('waktu_suratakhir'); // waktu_suratakhir tidak null
            }
        }

        if ($tanggal_awal && $tanggal_akhir) {
            $inquery->whereDate('tanggal_awal', '>=', $tanggal_awal)
                ->whereDate('tanggal_awal', '<=', $tanggal_akhir);
        }

        $inquery->whereNotNull('penerima_sj');
        $inquery->where('status_penerimaansj', '!=', 'unpost');

        if ($karyawan_id) {
            $inquery->where('penerima_sj', $karyawan->nama_lengkap);
        }

        $inquery->orderBy('tanggal_awal', 'DESC');

        $hasSearch = $status || $nama_lengkap || ($tanggal_awal && $tanggal_akhir);
        $inquery = $hasSearch ? $inquery->get() : collect();

        return view('admin.laporan_monitoringsj.index', compact('inquery', 'pengurus'));
    }


    public function print_monitoringsj(Request $request)
    {
        $status = $request->status;
        $kategori = $request->kategori;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;
        $karyawan_id = $request->karyawan_id; // Ambil karyawan_id dari input

        $query = Pengambilan_do::query(); // Inisialisasi query

        // Data untuk dropdown pengurus
        $pengurus = Karyawan::select('id', 'kode_karyawan', 'nama_lengkap')
            ->where('departemen_id', '5')
            ->orderBy('nama_lengkap')
            ->get();

        // Filter status
        if ($status) {
            $query->where('status', $status);
        } else {
            $query->where('status', '!=', 'unpost'); // Mengambil data dengan status selain 'unpost'
        }

        if ($kategori) {
            if ($kategori === 'belum_selesai') {
                $query->whereNull('waktu_suratakhir'); // waktu_suratakhir null
            } elseif ($kategori === 'selesai') {
                $query->whereNotNull('waktu_suratakhir'); // waktu_suratakhir tidak null
            }
        }

        // Filter tanggal jika ada
        if ($tanggal_awal && $tanggal_akhir) {
            $query->whereDate('tanggal_awal', '>=', $tanggal_awal)
                ->whereDate('tanggal_awal', '<=', $tanggal_akhir);
        }

        // Filter kolom penerima_sj tidak null dan status_penerimaansj bukan 'unpost'
        $query->whereNotNull('penerima_sj');
        $query->where('status_penerimaansj', '!=', 'unpost');

        // Jika karyawan_id ada, filter berdasarkan nama lengkap penerima_sj
        if ($karyawan_id) {
            $karyawan = Karyawan::find($karyawan_id);
            $nama_lengkap = $karyawan ? $karyawan->nama_lengkap : null;
            if ($nama_lengkap) {
                $query->where('penerima_sj', $nama_lengkap);
            }
        }

        // Ambil data berdasarkan query yang sudah difilter
        $inquery = $query->orderBy('id', 'DESC')->get();

        // Membuat PDF dengan data yang sudah difilter
        $pdf = PDF::loadView('admin.laporan_monitoringsj.print', compact('inquery', 'pengurus'));

        // Tampilkan PDF
        return $pdf->stream('Laporan_Monitoring_SJ.pdf');
    }


    public function indexglobal(Request $request)
    {
        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;
        $karyawan_id = $request->karyawan_id;

        if ($karyawan_id) {
            $karyawan = Karyawan::find($karyawan_id);
            $nama_lengkap = $karyawan ? $karyawan->nama_lengkap : null;
        } else {
            $nama_lengkap = null;
        }

        $pengurus = Karyawan::select('id', 'kode_karyawan', 'nama_lengkap')
            ->where('departemen_id', '5')
            ->orderBy('nama_lengkap')
            ->get();

        // Pastikan filter tanggal tersedia
        $filterTanggal = $tanggal_awal && $tanggal_akhir;

        $inquery = Pengambilan_do::query();

        if ($status) {
            $inquery->where('status', $status);
        } else {
            $inquery->where('status', '!=', 'unpost');
        }

        if ($filterTanggal) {
            $inquery->whereDate('tanggal_awal', '>=', $tanggal_awal)
                ->whereDate('tanggal_awal', '<=', $tanggal_akhir);
        }

        $inquery->whereNotNull('penerima_sj');
        $inquery->where('status_penerimaansj', '!=', 'unpost');

        if ($karyawan_id) {
            $inquery->where('penerima_sj', $karyawan->nama_lengkap);
        }

        $inquery->orderBy('tanggal_awal', 'DESC');
        $hasSearch = $status || $nama_lengkap || $filterTanggal;
        $inquery = $hasSearch ? $inquery->get() : collect();

        // Hitung jumlah surat jalan diterima
        $pengurus = $pengurus->map(function ($pengurus) use ($filterTanggal, $tanggal_awal, $tanggal_akhir) {
            if ($filterTanggal) {
                // Hitung jumlah surat jalan diterima berdasarkan filter tanggal
                $pengurus->jumlah_surat_jalan_diterima = Pengambilan_do::where('penerima_sj', $pengurus->nama_lengkap)
                    ->whereDate('tanggal_awal', '>=', $tanggal_awal)
                    ->whereDate('tanggal_awal', '<=', $tanggal_akhir)
                    ->count();
            } else {
                // Default ke 0 jika tidak ada filter tanggal
                $pengurus->jumlah_surat_jalan_diterima = 0;
            }
            return $pengurus;
        });

        return view('admin.laporan_monitoringsjglobal.index', compact('inquery', 'pengurus'));
    }


    public function print_monitoringsjglobal(Request $request)
    {
        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;
        $karyawan_id = $request->karyawan_id; // Ambil karyawan_id dari input

        $query = Pengambilan_do::query(); // Inisialisasi query

        if ($karyawan_id) {
            $karyawan = Karyawan::find($karyawan_id);
            $nama_lengkap = $karyawan ? $karyawan->nama_lengkap : null;
        } else {
            $nama_lengkap = null;
        }

        // Data untuk dropdown pengurus
        $pengurus = Karyawan::select('id', 'kode_karyawan', 'nama_lengkap')
            ->where('departemen_id', '5')
            ->orderBy('nama_lengkap')
            ->get();

        $filterTanggal = $tanggal_awal && $tanggal_akhir;

        $inquery = Pengambilan_do::query();

        if ($status) {
            $inquery->where('status', $status);
        } else {
            $inquery->where('status', '!=', 'unpost');
        }

        if ($filterTanggal) {
            $inquery->whereDate('tanggal_awal', '>=', $tanggal_awal)
                ->whereDate('tanggal_awal', '<=', $tanggal_akhir);
        }

        $inquery->whereNotNull('penerima_sj');
        $inquery->where('status_penerimaansj', '!=', 'unpost');

        if ($karyawan_id) {
            $inquery->where('penerima_sj', $karyawan->nama_lengkap);
        }

        $inquery->orderBy('tanggal_awal', 'DESC');
        $hasSearch = $status || $nama_lengkap || $filterTanggal;
        $inquery = $hasSearch ? $inquery->get() : collect();

        // Hitung jumlah surat jalan diterima
        $pengurus = $pengurus->map(function ($pengurus) use ($filterTanggal, $tanggal_awal, $tanggal_akhir) {
            if ($filterTanggal) {
                // Hitung jumlah surat jalan diterima berdasarkan filter tanggal
                $pengurus->jumlah_surat_jalan_diterima = Pengambilan_do::where('penerima_sj', $pengurus->nama_lengkap)
                    ->whereDate('tanggal_awal', '>=', $tanggal_awal)
                    ->whereDate('tanggal_awal', '<=', $tanggal_akhir)
                    ->count();
            } else {
                // Default ke 0 jika tidak ada filter tanggal
                $pengurus->jumlah_surat_jalan_diterima = 0;
            }
            return $pengurus;
        });

        // Membuat PDF dengan data yang sudah difilter
        $pdf = PDF::loadView('admin.laporan_monitoringsjglobal.print', compact('inquery', 'pengurus'));

        // Tampilkan PDF
        return $pdf->stream('Laporan_Monitoring_SJ.pdf');
    }




    // public function index(Request $request)
    // {
    //     $status = $request->status;
    //     $tanggal_awal = $request->tanggal_awal;
    //     $tanggal_akhir = $request->tanggal_akhir;
    //     $karyawan_id = $request->karyawan_id; // Ambil karyawan_id dari input

    //     // Data untuk dropdown pengurus
    //     $pengurus = Karyawan::select('id', 'kode_karyawan', 'nama_lengkap')
    //         ->where('departemen_id', '5')
    //         ->orderBy('nama_lengkap')
    //         ->get();

    //     // Inisialisasi query
    //     $inquery = Pengambilan_do::orderBy('id', 'DESC');

    //     // Filter status
    //     if ($status) {
    //         $inquery->where('status', $status);
    //     } else {
    //         $inquery->where('status', '!=', 'unpost'); // Mengambil data dengan status selain 'unpost'
    //     }

    //     // Filter kolom penerima_sj tidak null
    //     $inquery->whereNotNull('penerima_sj');
    //     $inquery->where('status_penerimaansj', '!=', 'unpost');

    //     // Filter tanggal
    //     if ($tanggal_awal && $tanggal_akhir) {
    //         $inquery->whereDate('tanggal_awal', '>=', $tanggal_awal)
    //             ->whereDate('tanggal_awal', '<=', $tanggal_akhir);
    //     }

    //     // Filter berdasarkan karyawan_id
    //     if ($karyawan_id) {
    //         $inquery->whereHas('timer_suratjalan', function ($query) use ($karyawan_id) {
    //             $query->whereHas('user', function ($query) use ($karyawan_id) {
    //                 $query->where('karyawan_id', $karyawan_id);
    //             });
    //         });
    //     }

    //     // Periksa apakah pencarian dilakukan
    //     $hasSearch = $status || $karyawan_id || ($tanggal_awal && $tanggal_akhir);
    //     $inquery = $hasSearch ? $inquery->get() : collect();

    //     // Return ke view
    //     return view('admin.laporan_monitoringsj.index', compact('inquery', 'pengurus'));
    // }


}