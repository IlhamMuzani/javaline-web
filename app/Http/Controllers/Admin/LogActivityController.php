<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class LogActivityController extends Controller
{
    public function index()
    {
        if (auth()->check() && auth()->user()->menu['laporan update km']) {

            $log_updatekm = LogAktivitas::orderByDesc('tanggal')->get();
            return view('admin/log_updatekm.index', compact('log_updatekm'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }


    public function destroy($id)
    {
        $ban = LogAktivitas::find($id);
        $ban->delete();

        return redirect('admin/log_updatekm')->with('success', 'Berhasil menghapus Log Activity Update KM');
    }
}