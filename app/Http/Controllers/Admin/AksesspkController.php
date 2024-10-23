<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use App\Models\Pengambilan_do;
use Illuminate\Support\Facades\Validator;

class AksesspkController extends Controller
{

    public function index(Request $request)
    {
        $akses_spk = $request->akses_spk;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        // Inisialisasi query untuk Pengambilan_do
        $spks = Pengambilan_do::query();

        // Filter akses_spk jika ada request
        if (isset($akses_spk)) {
            if ($akses_spk == '1') {
                // Tampilkan hanya yang memiliki akses_spk = 1
                $spks->where('akses_spk', 1);
            } elseif ($akses_spk == '0') {
                // Tampilkan hanya yang memiliki akses_spk = 0
                $spks->where('akses_spk', 0);
            }
        }

        // Filter berdasarkan tanggal_awal dan tanggal_akhir
        if ($tanggal_awal && $tanggal_akhir) {
            $spks->whereBetween('tanggal_awal', [$tanggal_awal, $tanggal_akhir]);
        } elseif ($tanggal_awal) {
            $spks->where('tanggal_awal', '>=', $tanggal_awal);
        } elseif ($tanggal_akhir) {
            $spks->where('tanggal_awal', '<=', $tanggal_akhir);
        } else {
            // Jika tidak ada filter tanggal, tampilkan data untuk hari ini
            $spks->whereDate('tanggal_awal', Carbon::today());
        }

        // Urutkan data berdasarkan id secara descending
        $spks->orderBy('id', 'DESC');

        // Dapatkan hasil query
        $spks = $spks->get();

        // Return view dengan data yang difilter
        return view('admin.akses_spk.index', compact('spks'));
    }


    public function edit($id)
    {
        $akses_lokasi = Kendaraan::where('id', $id)->first();
        return view('admin/akses_lokasi.update', compact('akses_lokasi'));
    }

    public function update(Request $request, $id)
    {

        $akses_lokasi = Kendaraan::find($id);
        $akses_lokasi->akses_lokasi = $request->akses_lokasi;
        $akses_lokasi->save();
        return redirect('admin/akses_lokasi')->with('success', 'Berhasil memperbarui akses lokasi');
    }

    public function postingaksesspk($id)
    {
        // Mencari SPK berdasarkan id
        $item = Pengambilan_do::find($id);

        // Jika SPK tidak ditemukan, kembalikan error
        if (!$item) {
            return response()->json(['error' => 'SPK tidak ditemukan'], 404);
        }

        $item->update([
            'akses_spk' => 1
        ]);

        // Jika akses_spk sudah 0, kembalikan pesan
        return response()->json(['info' => 'SPK sudah dalam kondisi unpost'], 200);
    }


    public function unpostaksesspk($id)
    {
        // Mencari SPK berdasarkan id
        $item = Pengambilan_do::find($id);

        // Jika SPK tidak ditemukan, kembalikan error
        if (!$item) {
            return response()->json(['error' => 'SPK tidak ditemukan'], 404);
        }

        $item->update([
            'akses_spk' => 0
        ]);

        // Jika akses_spk sudah 0, kembalikan pesan
        return response()->json(['info' => 'SPK sudah dalam kondisi unpost'], 200);
    }


    public function postingfilterspkakses(Request $request)
    {
        $selectedIds = array_reverse(explode(',', $request->input('ids')));
        $spks = Pengambilan_do::whereIn('id', $selectedIds)->orderBy('id', 'DESC')->get();

        foreach ($spks as $spk) {
            if ($spk && $spk->akses_spk == 0) {
                $spk->update(['akses_spk' => 1]);
            }
        }
    }

    public function unpostfilterspkakses(Request $request)
    {
        $selectedIds = array_reverse(explode(',', $request->input('ids')));
        $spks = Pengambilan_do::whereIn('id', $selectedIds)->orderBy('id', 'DESC')->get();

        foreach ($spks as $spk) {
            if ($spk && $spk->akses_spk == 1) {
                $spk->update(['akses_spk' => 0]);
            }
        }
    }
}
