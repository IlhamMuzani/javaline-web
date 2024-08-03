<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pengambilan_do;
use App\Models\Spk;
use Illuminate\Support\Facades\Validator;

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
            [
                'spk_id' => 'required',
                'latitude' => 'required',
            ],
            [
                'spk_id.required' => 'Pilih spk',
                'latitude.required' => 'Pilih titik tujuan',
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }

        Pengambilan_do::findOrFail($id);

        Pengambilan_do::where('id', $id)->update([
            'spk_id' => $request->spk_id,
            'user_id' => $request->user_id,
            'kendaraan_id' => $request->kendaraan_id,
            'alamat_muat_id' => $request->alamat_muat_id,
            'alamat_bongkar_id' => $request->alamat_bongkar_id,
            'rute_perjalanan_id' => $request->rute_perjalanan_id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'status' => 'posting',
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