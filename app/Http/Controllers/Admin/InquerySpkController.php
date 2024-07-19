<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\admin\RuteperjalananController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use App\Models\Pelanggan;
use App\Models\Rute_perjalanan;
use App\Models\Spk;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class InquerySpkController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $spks = Spk::query();

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
            // Jika tidak ada filter tanggal hari ini
            $spks->whereDate('tanggal_awal', Carbon::today());
        }

        $spks->orderBy('id', 'DESC');
        $spks = $spks->get();

        return view('admin.inqueryspk.index', compact('spks'));
    }

    public function edit($id)
    {
        $inquery = Spk::where('id', $id)->first();
        $today = Carbon::today();

        $kendaraans = Kendaraan::all();
        $drivers = User::whereHas('karyawan', function ($query) {
            $query->where('departemen_id', '2');
        })->get();
        $ruteperjalanans = Rute_perjalanan::all();
        $pelanggans = Pelanggan::all();


        $spks = Spk::whereDate('created_at', $today)
            ->orWhere(function ($query) use ($today) {
                $query->where('status', 'unpost')
                    ->whereDate('created_at', '<', $today);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.inqueryspk.update', compact('inquery', 'kendaraans', 'drivers', 'ruteperjalanans', 'pelanggans'));
    }


    public function update(Request $request, $id)
    {
        $rules = [
            'kode_spk' => 'unique:spks,kode_spk',
        ];

        // Define base validation messages
        $messages = [
            'kode_spk.unique' => 'Kode spk sudah ada',
        ];

        // Add additional rules if kategori is not 'non memo'
        if ($request->kategori !== 'non memo') {
            $rules['user_id'] = 'required';
            // $rules['rute_perjalanan_id'] = 'required';
            $rules['kendaraan_id'] = 'required';
            // $rules['uang_jalan'] = 'required';

            $messages['user_id.required'] = 'Pilih driver';
            $messages['rute_perjalanan_id.required'] = 'Pilih rute perjalanan';
            $messages['kendaraan_id.required'] = 'Pilih No Kabin';
            $messages['uang_jalan.*'] = 'Uang jalan harus berupa angka atau dalam format Rupiah yang valid';
        }

        // Validate the request
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }

        $status_spk = $request->kategori === 'non memo' ? 'non memo' : null;
        $saldo_deposit = $request->saldo_deposit ? str_replace(',', '.', str_replace('.', '', $request->saldo_deposit)) : '0';
        $uang_jalan = $request->uang_jalan ? str_replace(',', '.', str_replace('.', '', $request->uang_jalan)) : '0';

        $spk = Spk::findOrFail($id);

        $spk->kategori = $request->kategori;
        $spk->pelanggan_id = $request->pelanggan_id;
        $spk->kendaraan_id = $request->kendaraan_id;
        $spk->no_kabin = $request->no_kabin;
        $spk->golongan = $request->golongan;
        $spk->km_awal = $request->km_awal;
        $spk->user_id = $request->user_id;
        $spk->kode_driver = $request->kode_driver;
        $spk->nama_driver = $request->nama_driver;
        $spk->telp = $request->telp;
        $spk->rute_perjalanan_id = $request->rute_perjalanan_id;
        $spk->kode_rute = $request->kode_rute;
        $spk->nama_rute = $request->nama_rute;
        $spk->status = 'posting';
        $spk->saldo_deposit = $saldo_deposit;
        $spk->uang_jalan = $uang_jalan;
        $spk->status_spk = $status_spk;

        $spk->save();

        return redirect('admin/inquery_spk')->with('success', 'Berhasil memperbarui spk');
    }



    public function postingspk($id)
    {
        $ban = Spk::where('id', $id)->first();

        $ban->update([
            'status' => 'posting'
        ]);

        return response()->json(['success' => 'Berhasil memposting spk']);
    }

    public function unpostspk($id)
    {
        $ban = Spk::where('id', $id)->first();

        $ban->update([
            'status' => 'unpost'
        ]);

        return response()->json(['success' => 'Berhasil unpost spk']);
    }

    public function hapusspk($id)
    {
        $memo = Spk::where('id', $id)->first();
        $memo->delete();
        return back()->with('success', 'Berhasil');
    }
}