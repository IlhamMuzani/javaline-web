<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pengambilan_do;
use App\Models\Spk;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class InqueryPengambilandoController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $inquery = Pengambilan_do::query();

        if ($status) {
            $inquery->where('status', $status);
        }

        if ($tanggal_awal && $tanggal_akhir) {
            $inquery->whereBetween('tanggal_awal', [$tanggal_awal, $tanggal_akhir]);
        } elseif ($tanggal_awal) {
            $inquery->where('tanggal_awal', '>=', $tanggal_awal);
        } elseif ($tanggal_akhir) {
            $inquery->where('tanggal_awal', '<=', $tanggal_akhir);
        } else {
            // Jika tidak ada filter tanggal hari ini
            $inquery->whereDate('tanggal_awal', Carbon::today());
        }

        $inquery->orderBy('id', 'DESC');
        $inquery = $inquery->get();

        return view('admin/inquery_pengambilando.index', compact('inquery'));
    }


    public function show($id)
    {
        $cetakpdf = Pengambilan_do::where('id', $id)->first();

        return view('admin.inquery_pengambilando.show', compact('cetakpdf'));
    }


    public function edit($id)
    {
        $inquery = Pengambilan_do::where('id', $id)->first();
        $spks = Spk::orderBy('created_at', 'desc')
            ->get();

        return view('admin.inquery_pengambilando.update', compact('inquery', 'spks'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [],
            []
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }


        $pengambilan_do = Pengambilan_do::findOrFail($id);

        if ($request->gambar) {
            Storage::disk('local')->delete('public/uploads/' . $pengambilan_do->gambar);
            $gambar = str_replace(' ', '', $request->gambar->getClientOriginalName());
            $namaGambar = 'pengambilan_do/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar->storeAs('public/uploads/', $namaGambar);
        } else {
            $namaGambar1 = $pengambilan_do->gambar;
        }

        if ($request->gambar2) {
            Storage::disk('local')->delete('public/uploads/' . $pengambilan_do->gambar2);
            $gambar2 = str_replace(' ', '', $request->gambar2->getClientOriginalName());
            $namaGambar = 'pengambilan_do/' . date('mYdHs') . rand(1, 10) . '_' . $gambar2;
            $request->gambar2->storeAs('public/uploads/', $namaGambar);
        } else {
            $namaGambar2 = $pengambilan_do->gambar2;
        }

        if ($request->gambar3) {
            Storage::disk('local')->delete('public/uploads/' . $pengambilan_do->gambar3);
            $gambar3 = str_replace(' ', '', $request->gambar3->getClientOriginalName());
            $namaGambar = 'pengambilan_do/' . date('mYdHs') . rand(1, 10) . '_' . $gambar3;
            $request->gambar3->storeAs('public/uploads/', $namaGambar);
        } else {
            $namaGambar3 = $pengambilan_do->gambar3;
        }

        if ($request->bukti) {
            Storage::disk('local')->delete('public/uploads/' . $pengambilan_do->bukti);
            $bukti = str_replace(' ', '', $request->bukti->getClientOriginalName());
            $namaGambar = 'bukti/' . date('mYdHs') . rand(1, 10) . '_' . $bukti;
            $request->bukti->storeAs('public/uploads/', $namaGambar);
        } else {
            $namaBukti1 = $pengambilan_do->bukti;
        }

        if ($request->bukti2) {
            Storage::disk('local')->delete('public/uploads/' . $pengambilan_do->bukti2);
            $bukti2 = str_replace(' ', '', $request->bukti2->getClientOriginalName());
            $namaGambar = 'bukti/' . date('mYdHs') . rand(1, 10) . '_' . $bukti2;
            $request->bukti2->storeAs('public/uploads/', $namaGambar);
        } else {
            $namaBukti2 = $pengambilan_do->bukti2;
        }

        if ($request->bukti3) {
            Storage::disk('local')->delete('public/uploads/' . $pengambilan_do->bukti3);
            $bukti3 = str_replace(' ', '', $request->bukti3->getClientOriginalName());
            $namaGambar = 'bukti/' . date('mYdHs') . rand(1, 10) . '_' . $bukti3;
            $request->bukti3->storeAs('public/uploads/', $namaGambar);
        } else {
            $namaBukti3 = $pengambilan_do->bukti3;
        }

        Pengambilan_do::where('id', $id)->update([
            'km_awal' => $request->km_awal,
            'km_akhir' => $request->km_akhir,
            'waktu_awal' => $request->waktu_awal,
            'waktu_akhir' => $request->waktu_akhir,
            'kendaraan_id' => $request->kendaraan_id,
            'rute_perjalanan_id' => $request->rute_perjalanan_id,
            'alamat_muat_id' => $request->alamat_muat_id,
            'alamat_bongkar_id' => $request->alamat_bongkar_id,
            'kode_pengambilan' => $request->kode_pengambilan,
            'tanggal' => $request->tanggal,
            'gambar' => $namaGambar1,
            'gambar2' => $namaGambar2,
            'gambar3' => $namaGambar3,
            'bukti' => $namaBukti1,
            'bukti2' => $namaBukti2,
            'bukti3' => $namaBukti3,
            'tanggal_awal' => $request->tanggal_awal,
            'tanggal_akhir' => $request->tanggal_akhir,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'waktu_suratawal' => $request->waktu_suratawal,
            'waktu_suratakhir' => $request->waktu_suratakhir,
            'status_suratjalan' => $request->status_suratjalan,
            'status' => $request->status,
        ]);

        Pengambilan_do::where('id', $id)->first();
        return redirect('admin/inquery_pengambilando')->with('success', 'Berhasil menyimpan');
    }


    public function unpostpengambilando($id)
    {
        $items = Pengambilan_do::where('id', $id)->first();
        $items->update([
            'status' => 'unpost'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function postingpengambilando($id)
    {
        $items = Pengambilan_do::where('id', $id)->first();
        $items->update([
            'status' => 'posting'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function hapuspengambilando($id)
    {
        $items = Pengambilan_do::where('id', $id)->first();
        $items->delete();
        return back()->with('success', 'Berhasil menghapus Surat penawaran');
    }
}