<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Validator;

class InqueryUpdateKMController extends Controller
{

    public function index(Request $request)
    {
        if (auth()->check() && auth()->user()->menu['inquery update km']) {

            LogAktivitas::where([
                ['status', 'posting']
            ])->update([
                'status_notif' => true
            ]);

            $status = $request->status;
            $created_at = $request->created_at;
            $tanggal_akhir = $request->tanggal_akhir;

            $inquery = LogAktivitas::query();

            if ($status) {
                $inquery->where('status', $status);
            }

            if ($created_at && $tanggal_akhir) {
                $inquery->whereBetween('created_at', [$created_at, $tanggal_akhir]);
            } elseif ($created_at) {
                $inquery->where('created_at', '>=', $created_at);
            } elseif ($tanggal_akhir) {
                $inquery->where('created_at', '<=', $tanggal_akhir);
            }

            $inquery->orWhereDate('created_at', Carbon::today());

            $inquery->orderBy('tanggal', 'DESC');
            $inquery = $inquery->get();

            return view('admin.inquery_updatekm.index', compact('inquery'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }
    // public function index(Request $request)
    // {
    //     if (auth()->check() && auth()->user()->menu['inquery update km']) {

    //         LogAktivitas::where([
    //             ['status', 'posting']
    //         ])->update([
    //             'status_notif' => true
    //         ]);

    //         // $status = $request->status;
    //         // $tanggal_awal = $request->tanggal_awal;
    //         // $tanggal_akhir = $request->tanggal_akhir;

    //         // $inquery = LogAktivitas::query();

    //         // if ($status) {
    //         //     $inquery->where('status', $status);
    //         // }

    //         // if ($tanggal_awal && $tanggal_akhir) {
    //         //     $inquery->whereBetween('tanggal_awal', [$tanggal_awal, $tanggal_akhir]);
    //         // } elseif ($tanggal_awal) {
    //         //     $inquery->where('tanggal_awal', '>=', $tanggal_awal);
    //         // } elseif ($tanggal_akhir) {
    //         //     $inquery->where('tanggal_awal', '<=', $tanggal_akhir);
    //         // }

    //         // $inquery->orWhereDate('tanggal_awal', Carbon::today());

    //         // $inquery->orderBy('tanggal', 'DESC');
    //         // $inquery = $inquery->get();
    //         $inquery = LogAktivitas::all();

    //         return view('admin.inquery_updatekm.index', compact('inquery'));
    //     } else {
    //         // tidak memiliki akses
    //         return back()->with('error', array('Anda tidak memiliki akses'));
    //     }
    // }
    public function unpostkm($id)
    {
        $ban = LogAktivitas::where('id', $id)->first();

        $ban->update([
            'status' => 'unpost'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function postingkm($id)
    {
        $ban = LogAktivitas::where('id', $id)->first();

        $ban->update([
            'status' => 'posting'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function lihat_kendaraan($id)
    {
        if (auth()->check() && auth()->user()->menu['inquery update km']) {
            $kendaraan = LogAktivitas::where('id', $id)->first();
            return view('admin/inquery_updatekm.show', compact('kendaraan'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }
    public function edit_kendaraan($id)
    {
        if (auth()->check() && auth()->user()->menu['inquery update km']) {

            $kendaraan = LogAktivitas::where('id', $id)->first();
            return view('admin/inquery_updatekm.update', compact('kendaraan'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }
    public function update(Request $request, $id)
    {
        $kendaraan = LogAktivitas::findOrFail($id);

        $validator = Validator::make(
            $request->all(),
            [
                'km' => 'required',
            ],
            [
                'km.required' => 'Masukkan nilai km',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $item = LogAktivitas::findOrFail($id);
        $tanggal_awal = Carbon::parse($item->tanggal_awal);

        $today = Carbon::now('Asia/Jakarta')->format('Y-m-d');
        $lastUpdatedDate = $tanggal_awal->format('Y-m-d');

        if ($lastUpdatedDate < $today) {
            return back()->with('errormax', 'Anda tidak dapat melakukan update setelah berganti hari.');
        }


        LogAktivitas::where('id', $kendaraan->id)->update(
            [
                'km_update' => $request->km,
                // 'tanggal' => Carbon::now('Asia/Jakarta'),
                'status' => 'posting',
            ]
        );

        Kendaraan::where('id', $kendaraan->kendaraan_id)->update(
            [
                'km' => $request->km,
            ]
        );
        return redirect('admin/inquery_updatekm')->with('success', 'Kilo meter berhasil terupdate');
    }

    public function hapuskm($id)
    {
        $ban = LogAktivitas::where('id', $id)->first();

        $ban->delete();
        return back()->with('success', 'Berhasil');
    }

    // public function deletekm($id)
    // {
    //     $kendaraan = Kendaraan::find($id);

    //     if (!$kendaraan) {
    //         return back()->with('error', 'Kendaraan tidak ditemukan');
    //     }

    //     // Temukan log aktivitas terbaru yang mengubah "km"
    //     $logAktivitasTerbaru = LogAktivitas::where('kendaraan_id', $id)
    //         ->orderBy('created_at', 'desc')
    //         ->first();

    //     if (!$logAktivitasTerbaru) {
    //         return back()->with('error', 'Log Aktivitas tidak ditemukan');
    //     }

    //     // Temukan log aktivitas sebelum "km" diperbarui
    //     $logAktivitasSebelumnya = LogAktivitas::where('kendaraan_id', $id)
    //         ->where('created_at', '<', $logAktivitasTerbaru->created_at)
    //         ->orderBy('created_at', 'desc')
    //         ->first();

    //     if (!$logAktivitasSebelumnya) {
    //         return back()->with('error', 'Log Aktivitas sebelumnya tidak ditemukan');
    //     }

    //     // Simpan nilai "km_update" sebelum "km" terakhir kali diperbarui
    //     $kmSebelumTerakhir = $logAktivitasSebelumnya->km_update;

    //     // Hapus kendaraan
    //     $kendaraan->update([
    //         'status_post' => 'posting',
    //         'km' => $kmSebelumTerakhir
    //     ]);

    //     return back()->with('success', 'Berhasil menghapus kendaraan. Nilai km terakhir sebelum terbaru: ' . $kmSebelumTerakhir);
    // }
}