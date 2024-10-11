<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\admin\RuteperjalananController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Alamat_bongkar;
use App\Models\Alamat_muat;
use App\Models\Jarak_km;
use App\Models\Kendaraan;
use App\Models\Memo_ekspedisi;
use App\Models\Pelanggan;
use App\Models\Pengambilan_do;
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
            // Jika status yang dipilih adalah 'posting', tampilkan data dengan status 'posting' dan 'selesai'
            if ($status == 'posting') {
                $spks->whereIn('status', ['posting', 'selesai']);
            } else {
                $spks->where('status', $status);
            }
        }

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
        // $jarak = Jarak_km::first(); // Mendapatkan jarak yang akan digunakan untuk validasi

        $rules = [
            'kode_spk' => 'unique:spks,kode_spk',
            'km_awal' => 'required',
        ];

        $messages = [
            'kode_spk.unique' => 'Kode spk sudah ada',
            'km_awal.required' => 'Km awal kendaraan tidak boleh kosong',
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
        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
        $kendaraan->update([
            'km' => $request->km_awal
        ]);

        $kms = $request->km_awal;

        // Periksa apakah selisih kurang dari 1000 atau lebih tinggi dari km_olimesin
        if (
            $kms > $kendaraan->km_olimesin - 1000 || $kms > $kendaraan->km_olimesin
        ) {
            $status_olimesins = "belum penggantian";
            $kendaraan->status_olimesin = $status_olimesins;
        }

        if (
            $kms > $kendaraan->km_oligardan - 5000 || $kms > $kendaraan->km_oligardan
        ) {
            $status_olimesins = "belum penggantian";
            $kendaraan->status_oligardan = $status_olimesins;
        }

        if (
            $kms > $kendaraan->km_olitransmisi - 5000 || $kms > $kendaraan->km_olitransmisi
        ) {
            $status_olimesins = "belum penggantian";
            $kendaraan->status_olitransmisi = $status_olimesins;
        }

        // Update umur_ban for related ban
        foreach ($kendaraan->ban as $ban) {
            $ban->update([
                'umur_ban' => ($kms - $ban->km_pemasangan) + ($ban->jumlah_km ?? 0)
            ]);
        }


        // $status_spk = $request->kategori === 'non memo' ? 'non memo' : null;
        $saldo_deposit = $request->saldo_deposit ? str_replace(',', '.', str_replace('.', '', $request->saldo_deposit)) : '0';
        $uang_jalan = $request->uang_jalan ? str_replace(',', '.', str_replace('.', '', $request->uang_jalan)) : '0';


        $status_pengambilan_do = 'unpost';

        // Cek apakah semua field tidak null
        if (
            !is_null($request->pelanggan_id) &&
            !is_null($request->kendaraan_id) &&
            !is_null($request->rute_perjalanan_id) &&
            !is_null($request->user_id) &&
            !is_null($request->alamat_muat_id) &&
            !is_null($request->alamat_bongkar_id)
        ) {
            $status_pengambilan_do = 'posting';
        }

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
        $spk->status = $status_pengambilan_do;
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


        // Create or update Pengambilan_do
        $pengambilan_do = Pengambilan_do::where('spk_id', $id)->first();
        if ($pengambilan_do) {
            if ($pengambilan_do->status == 'unpost' || $pengambilan_do->status == 'posting') {
                $pengambilan_do->update([
                    'spk_id' => $id,
                    'kendaraan_id' => $request->kendaraan_id,
                    'rute_perjalanan_id' => $request->rute_perjalanan_id,
                    'user_id' => $request->user_id,
                    'alamat_muat_id' => $request->alamat_muat_id,
                    'alamat_bongkar_id' => $request->alamat_bongkar_id,
                    'status' => $status_pengambilan_do,
                ]);
            } else {
                $pengambilan_do->update([
                    'spk_id' => $id,
                    'kendaraan_id' => $request->kendaraan_id,
                    'rute_perjalanan_id' => $request->rute_perjalanan_id,
                    'user_id' => $request->user_id,
                    'alamat_muat_id' => $request->alamat_muat_id,
                    'alamat_bongkar_id' => $request->alamat_bongkar_id,
                ]);
            }
        } else {
            // Create Pengambilan_do if it does not exist
            $tanggal = Carbon::now()->format('Y-m-d');
            $tanggal1 = Carbon::now('Asia/Jakarta');
            $format_tanggal = $tanggal1->format('d F Y');

            Pengambilan_do::create(array_merge(
                $request->all(),
                [
                    'spk_id' => $id,
                    'kendaraan_id' => $request->kendaraan_id,
                    'rute_perjalanan_id' => $request->rute_perjalanan_id,
                    'user_id' => $request->user_id,
                    'km_awal' => $request->km_awal,
                    'tanggal_awal' => $tanggal,
                    'tanggal' => $format_tanggal,
                    'status' => $status_pengambilan_do,
                ]
            ));
        }

        return redirect('admin/inquery_spk')->with('success', 'Berhasil memperbarui spk');
    }

    public function postingspk($id)
    {
        // Mencari SPK berdasarkan id
        $item = Spk::find($id);

        if (!$item) {
            return response()->json(['error' => 'SPK tidak ditemukan'], 404);
        }

        if (
            is_null($item->kendaraan_id) ||
            is_null($item->pelanggan_id) ||
            is_null($item->rute_perjalanan_id) ||
            is_null($item->alamat_muat_id) ||
            is_null($item->alamat_bongkar_id) ||
            is_null($item->user_id)
        ) {
            return response()->json(['error' => 'Lengkapi spk'], 400);
        }

        // Mencari Pengambilan_do berdasarkan spk_id
        $pengambilando = Pengambilan_do::where('spk_id', $id)->first();

        if ($pengambilando) {
            // Jika status bukan 'selesai', update status menjadi 'posting'
            if ($pengambilando->status === 'unpost') {
                $pengambilando->update([
                    'status' => 'posting'
                ]);
            }
        }

        // Update status SPK menjadi 'posting'
        $item->update([
            'status' => 'posting'
        ]);

        return response()->json(['success' => 'Berhasil memposting SPK']);
    }

    public function unpostspk($id)
    {
        // Mencari SPK berdasarkan ID
        $item = Spk::find($id);

        if (!$item) {
            return response()->json(['error' => 'SPK tidak ditemukan'], 404);
        }

        // Mencari Pengambilan_do berdasarkan spk_id
        $pengambilando = Pengambilan_do::where('spk_id', $id)->first();

        // Jika Pengambilan_do ditemukan, update status
        if ($pengambilando) {
            // Jika status bukan 'selesai', update status menjadi 'posting'
            if ($pengambilando->status === 'posting') {
                $pengambilando->update([
                    'status' => 'unpost'
                ]);
            }
        }

        // Update status SPK menjadi 'unpost'
        $item->update([
            'status' => 'unpost'
        ]);

        return response()->json(['success' => 'Berhasil unpost spk']);
    }


    public function postingfilterspk(Request $request)
    {
        $selectedIds = array_reverse(explode(',', $request->input('ids')));

        try {
            foreach ($selectedIds as $id) {
                $item = Spk::findOrFail($id);

                // Periksa apakah semua field wajib sudah terisi
                if (
                    is_null($item->kendaraan_id) ||
                    is_null($item->pelanggan_id) ||
                    is_null($item->rute_perjalanan_id) ||
                    is_null($item->alamat_muat_id) ||
                    is_null($item->alamat_bongkar_id) ||
                    is_null($item->user_id)
                ) {
                    // Jika ada field yang null, lewati data ini
                    continue;
                }

                // Periksa status apakah masih 'unpost'
                if ($item->status === 'unpost') {
                    // Mencari Pengambilan_do berdasarkan spk_id
                    $pengambilando = Pengambilan_do::where('spk_id', $item->id)->first();

                    if ($pengambilando->status === 'unpost') {
                        if ($pengambilando) {
                            $pengambilando->update([
                                'status' => 'posting'
                            ]);
                        }
                    }

                    $item->update([
                        'status' => 'posting'
                    ]);
                }
            }

            return back()->with('success', 'Berhasil memposting SPK yang valid');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return back()->with('error', 'Terdapat SPK yang tidak ditemukan');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat memposting SPK: ' . $e->getMessage());
        }
    }

    public function unpostfilterspk(Request $request)
    {
        $selectedIds = array_reverse(explode(',', $request->input('ids')));
        try {
            // Update transactions and memo statuses
            foreach ($selectedIds as $id) {
                $item = Spk::findOrFail($id);

                // if ($item->status === 'posting') {
                if (in_array($item->status, ['posting', 'selesai'])) {

                    $pengambilando = Pengambilan_do::where('spk_id', $item->id)->first();

                    if ($pengambilando->status === 'posting') {
                        if ($pengambilando) {
                            $pengambilando->update([
                                'status' => 'unpost'
                            ]);
                        }
                    }
                    $item->update([
                        'status' => 'unpost'
                    ]);
                }
            }

            return back()->with('success', 'Berhasil mengunpost spk');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return back()->with('error', 'Terdapat surat spk yang tidak ditemukan');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mengunpost spk: ' . $e->getMessage());
        }
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
            $spk->pengambilan_do()->delete();
            $spk->delete();
            return back()->with('success', 'Berhasil');
        }

        // If SPK not found, return back with an error message
        return back()->withErrors(['error' => 'SPK tidak ditemukan.']);
    }
}