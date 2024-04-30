<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\Merek;
use App\Models\Ukuran;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ban;
use App\Models\Karyawan;
use App\Models\Klaim_ban;
use Illuminate\Support\Facades\Validator;

class KlaimbanController extends Controller
{
    public function index()
    {
        if (auth()->check() && auth()->user()->menu['merek ban']) {

            $today = Carbon::today();
            $inquery = Klaim_ban::whereDate('created_at', $today)
                ->orWhere(function ($query) use ($today) {
                    $query->where('status', 'unpost')
                        ->whereDate('created_at', '<', $today);
                })
                ->orderBy('created_at', 'desc')
                ->get();

            return view('admin.klaim_ban.index', compact('inquery'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function create()
    {
        $bans = Ban::get();
        $SopirAll = Karyawan::where('departemen_id', '2')->get();

        return view('admin.klaim_ban.create', compact('bans', 'SopirAll'));
    }
    // public function destroy($id)
    // {
    //     $klaim_ban = Merek::find($id);
    //     $klaim_ban->delete();

    //     return redirect('admin/klaim_ban')->with('success', 'Berhasil menghapus Merek ban');
    // }
}