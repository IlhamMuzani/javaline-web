<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\admin\RuteperjalananController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Alamat_bongkar;
use App\Models\Alamat_muat;
use App\Models\Kendaraan;
use App\Models\Memo_ekspedisi;
use App\Models\Pelanggan;
use App\Models\Rute_perjalanan;
use App\Models\Spk;
use App\Models\User;
use App\Models\Vendor;
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
        $vendors = Vendor::all();
        $alamat_muats = Alamat_muat::all();
        $alamat_bongkars = Alamat_bongkar::all();


        $spks = Spk::whereDate('created_at', $today)
            ->orWhere(function ($query) use ($today) {
                $query->where('status', 'unpost')
                    ->whereDate('created_at', '<', $today);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.inqueryspk.update', compact('alamat_muats', 'alamat_bongkars', 'vendors', 'inquery', 'kendaraans', 'drivers', 'ruteperjalanans', 'pelanggans'));
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
            $rules['rute_perjalanan_id'] = 'required';
            $rules['kendaraan_id'] = 'required';
            $rules['uang_jalan'] = 'required';

            $messages['user_id.required'] = 'Pilih driver';
            $messages['rute_perjalanan_id.required'] = 'Pilih rute perjalanan';
            $messages['kendaraan_id.required'] = 'Pilih No Kabin';
            $messages['uang_jalan.*'] = 'Uang jalan harus berupa angka atau dalam format Rupiah yang valid';
        } else {
            $rules['vendor_id'] = 'required';
            $messages['vendor_id.required'] = 'Pilih Vendor';
        }

        // Validate the request
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }

        // $status_spk = $request->kategori === 'non memo' ? 'non memo' : null;
        $saldo_deposit = $request->saldo_deposit ? str_replace(',', '.', str_replace('.', '', $request->saldo_deposit)) : '0';
        $uang_jalan = $request->uang_jalan ? str_replace(',', '.', str_replace('.', '', $request->uang_jalan)) : '0';

        $spk = Spk::findOrFail($id);

        $spk->kategori = $request->kategori;
        $spk->pelanggan_id = $request->pelanggan_id;
        $spk->kode_pelanggan = $request->kode_pelanggan;
        $spk->nama_pelanggan = $request->nama_pelanggan;
        $spk->alamat_pelanggan = $request->alamat_pelanggan;
        $spk->alamat_muat_id = $request->alamat_muat_id;
        $spk->alamat_bongkar_id = $request->alamat_bongkar_id;
        $spk->kode_pelanggan = $request->kode_pelanggan;
        $spk->nama_pelanggan = $request->nama_pelanggan;
        $spk->telp_pelanggan = $request->telp_pelanggan;
        $spk->alamat_pelanggan = $request->alamat_pelanggan;
        $spk->vendor_id = $request->vendor_id;
        $spk->kode_vendor = $request->kode_vendor;
        $spk->nama_vendor = $request->nama_vendor;
        $spk->telp_vendor = $request->telp_vendor;
        $spk->alamat_vendor = $request->alamat_vendor;
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
        // $spk->status_spk = $status_spk;

        if ($request->kategori === 'non memo') {
            $spk->status_spk = 'non memo';
        } else {
            // Jika kategori bukan 'non memo', jangan ubah status_spk
            // Pastikan status_spk tetap tidak berubah jika tidak diperlukan
        }

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
        $spk = Spk::find($id);

        // Check if the SPK is used in memo_ekspedisi and get the first related memo
        $memoEkspedisi = Memo_ekspedisi::where('spk_id', $id)->first();

        if ($memoEkspedisi) {
            // Return back with an error message if used in memo_ekspedisi
            return back()->withErrors(['error' => 'SPK tidak dapat dihapus karena digunakan di Memo Ekspedisi dengan kode memo: ' . $memoEkspedisi->kode_memo]);
        }

        // If not used, delete the SPK
        if ($spk) {
            $spk->delete();
            return back()->with('success', 'Berhasil');
        }

        // If SPK not found, return back with an error message
        return back()->withErrors(['error' => 'SPK tidak ditemukan.']);
    }
}