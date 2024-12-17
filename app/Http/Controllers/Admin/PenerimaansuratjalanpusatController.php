<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\admin\RuteperjalananController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use App\Models\Memo_ekspedisi;
use App\Models\Spk;
use App\Models\Pelanggan;
use App\Models\Pengambilan_do;
use App\Models\Rute_perjalanan;
use App\Models\Timer_suratjalan;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class PenerimaansuratjalanpusatController extends Controller
{

    // public function index(Request $request)
    // {
    //     // Mendapatkan input dari select divisi
    //     $divisi = $request->input('divisi');

    //     // Query dasar untuk mendapatkan data dengan status_suratjalan 'belum pulang' dan waktu_suratakhir null
    //     $spks = Pengambilan_do::with('kendaraan')
    //         ->whereNotNull('spk_id')
    //         ->where('status_suratjalan', 'belum pulang')
    //         ->whereNull('waktu_suratakhir'); // Filter untuk waktu_suratakhir yang null

    //     // Filter berdasarkan nomor kabin kendaraan jika divisi dipilih
    //     if (!empty($divisi) && $divisi != 'All') {
    //         $spks->whereHas('kendaraan', function ($query) use ($divisi) {
    //             $query->where('no_kabin', 'LIKE', $divisi . '%');
    //         });
    //     }

    //     // Mengurutkan berdasarkan id secara ascending
    //     $spks = $spks->orderBy('waktu_suratawal', 'ASC')->get();

    //     // Perulangan untuk menghitung durasi di controller
    //     foreach ($spks as $spk) {
    //         if ($spk->waktu_suratawal) {
    //             $waktu_awal = Carbon::parse($spk->waktu_suratawal);
    //             $waktu_akhir = $spk->waktu_suratakhir ? Carbon::parse($spk->waktu_suratakhir) : Carbon::now();
    //             $durasi = $waktu_awal->diff($waktu_akhir);
    //             $spk->durasi_hari = $durasi->days;
    //             $spk->durasi_jam = $durasi->h;
    //             $spk->durasi_menit = $durasi->i;
    //             $spk->durasi_detik = $durasi->s;
    //         } else {
    //             $spk->durasi_hari = '-';
    //             $spk->durasi_jam = '-';
    //             $spk->durasi_menit = '-';
    //             $spk->durasi_detik = '-';
    //         }
    //     }

    //     // Kirim data ke Blade
    //     return view('admin.penerimaan_suratjalanpusat.index', compact('spks'));
    // }

    public function index(Request $request)
    {


        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $spks = Pengambilan_do::query();


        if ($status) {
            $spks->where('status', $status);
        }

        if ($tanggal_awal && $tanggal_akhir) {
            $spks->whereBetween('tanggal_awal', [$tanggal_awal, $tanggal_akhir]);
        } elseif ($tanggal_awal) {
            $spks->where('tanggal_awal', '>=', $tanggal_awal);
        } elseif ($tanggal_akhir) {
            $spks->where('tanggal_awal', '<=', $tanggal_akhir);
        } else {
            $spks->whereDate('tanggal_awal', Carbon::today());
        }

        $spks->orderBy('id', 'DESC');
        $spks = $spks->get();


        return view('admin.penerimaan_suratjalanpusat.index', compact('spks'));
    }


    public function postingpenerimaansuratpusat($id)
    {
        $pengambilan_do = Pengambilan_do::findOrFail($id);
        $timer = Timer_suratjalan::where('pengambilan_do_id', $id)->latest()->first();
        $spk = Spk::where('id', $pengambilan_do->spk_id)->first();

        // Memperbarui timer terakhir jika ada
        if ($timer) {
            $timer->update([
                'timer_akhir' => now()->format('Y-m-d H:i:s'),
            ]);
        }

        Timer_suratjalan::create([
            'pengambilan_do_id' => $id,
            'user_id' => auth()->user()->id,
            'kategori' => 'posting',
            'timer_awal' => now()->format('Y-m-d H:i:s'),
        ]);

        // $spk->update([
        //     'status_spk' => 'sj'
        // ]);

        // // Mengupdate semua memo yang berelasi dengan spk
        // $memos = Memo_ekspedisi::where('spk_id', $spk->id)->get();
        // foreach ($memos as $memo) {
        //     $memo->update([
        //         'status_spk' => 'sj'
        //     ]);
        // }

        $pengambilan_do->update([
            'status_penerimaansj' => 'posting',
            'userpenerima_id' => auth()->user()->id,
            'penerima_sj' => auth()->user()->karyawan->nama_lengkap,
        ]);

        return response()->json(['success' => 'Berhasil memposting penerimaan']);
    }


    public function unpostpenerimaansuratpusat($id)
    {
        $pengambilan_do = Pengambilan_do::findOrFail($id);
        $timer = Timer_suratjalan::where('pengambilan_do_id', $id)->latest()->first();
        $spk = Spk::where('id', $pengambilan_do->spk_id)->first();

        // Memperbarui timer terakhir jika ada
        if ($timer) {
            $timer->update([
                'timer_akhir' => now()->format('Y-m-d H:i:s'),
            ]);
        }

        Timer_suratjalan::create([
            'pengambilan_do_id' => $id,
            'user_id' => auth()->user()->id,
            'kategori' => 'unpost',
            'timer_awal' => now()->format('Y-m-d H:i:s'),
        ]);

        // $spk->update([
        //     'status_spk' => 'memo'
        // ]);

        // // Mengupdate semua memo yang berelasi dengan spk
        // $memos = Memo_ekspedisi::where('spk_id', $spk->id)->get();
        // foreach ($memos as $memo) {
        //     $memo->update([
        //         'status_spk' => null
        //     ]);
        // }

        $pengambilan_do->update([
            'status_penerimaansj' => 'unpost',
            'userpenerima_id' => null,
            'penerima_sj' => auth()->user()->karyawan->nama_lengkap,
        ]);

        return response()->json(['success' => 'Berhasil memposting penerimaan']);
    }


    public function postingfilterpenerimaanpusat(Request $request)
    {
        $selectedIds = array_reverse(explode(',', $request->input('ids')));
        $fakturs = Pengambilan_do::whereIn('id', $selectedIds)->orderBy('id', 'DESC')->get();

        foreach ($fakturs as $faktur) {
            $timer = Timer_suratjalan::where('pengambilan_do_id', $faktur->id)->latest()->first();
            $spk = Spk::where('id', $faktur->spk_id)->first();

            // Memperbarui timer terakhir jika ada
            if ($timer) {
                $timer->update([
                    'timer_akhir' => now()->format('Y-m-d H:i:s'),
                ]);
            }

            Timer_suratjalan::create([
                'pengambilan_do_id' => $faktur->id,
                'user_id' => auth()->user()->id,
                'kategori' => 'posting',
                'timer_awal' => now()->format('Y-m-d H:i:s'),
            ]);

            $faktur->update([
                'status_penerimaansj' => 'posting',
                'userpenerima_id' => auth()->user()->id,
                'penerima_sj' => auth()->user()->karyawan->nama_lengkap,
            ]);
        }
    }

    public function unpostfilterpenerimaanpusat(Request $request)
    {
        $selectedIds = array_reverse(explode(',', $request->input('ids')));
        $fakturs = Pengambilan_do::whereIn('id', $selectedIds)->orderBy('id', 'DESC')->get();

        foreach ($fakturs as $faktur) {
            $timer = Timer_suratjalan::where('pengambilan_do_id', $faktur->id)->latest()->first();
            $spk = Spk::where('id', $faktur->spk_id)->first();

            // Memperbarui timer terakhir jika ada
            if ($timer) {
                $timer->update([
                    'timer_akhir' => now()->format('Y-m-d H:i:s'),
                ]);
            }

            Timer_suratjalan::create([
                'pengambilan_do_id' => $faktur->id,
                'user_id' => auth()->user()->id,
                'kategori' => 'unpost',
                'timer_awal' => now()->format('Y-m-d H:i:s'),
            ]);

            // $spk->update([
            //     'status_spk' => 'memo'
            // ]);

            // // Mengupdate semua memo yang berelasi dengan spk
            // $memos = Memo_ekspedisi::where('spk_id', $spk->id)->get();
            // foreach ($memos as $memo) {
            //     $memo->update([
            //         'status_spk' => null
            //     ]);
            // }

            $faktur->update([
                'status_penerimaansj' => 'unpost',
                'userpenerima_id' => null,
                'penerima_sj' => auth()->user()->karyawan->nama_lengkap,
            ]);
        }
    }
}