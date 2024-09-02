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
use GuzzleHttp\Client;

class SpkController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $spks = Spk::whereDate('created_at', $today)
            ->orWhere(function ($query) use ($today) {
                $query->where('status', 'unpost')
                    ->whereDate('created_at', '<', $today);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.spk.index', compact('spks'));
    }


    public function create()
    {
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

        return view('admin.spk.create', compact('alamat_muats', 'alamat_bongkars', 'vendors', 'kendaraans', 'drivers', 'ruteperjalanans', 'pelanggans'));
    }


    public function store(Request $request)
    {
        $jarak = Jarak_km::first(); // Mendapatkan jarak yang akan digunakan untuk validasi
        $rules = [
            'kode_spk' => 'unique:spks,kode_spk',
        ];

        $messages = [
            'kode_spk.unique' => 'Kode spk sudah ada',
        ];

        // Tambahkan aturan tambahan jika kategori bukan 'non memo'
        if ($request->kategori !== 'non memo') {
            $rules['user_id'] = 'required';
            $rules['rute_perjalanan_id'] = 'required';
            $rules['kendaraan_id'] = 'required';
            $rules['uang_jalan'] = 'required';

            $messages['user_id.required'] = 'Pilih driver';
            $messages['rute_perjalanan_id.required'] = 'Pilih rute perjalanan';
            $messages['kendaraan_id.required'] = 'Pilih No Kabin';
            $messages['uang_jalan.required'] = 'Masukkan uang jalan';
        } else {
            $rules['vendor_id'] = 'required';
            $messages['vendor_id.required'] = 'Pilih Vendor';
        }

        // Validasi request
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }

        $kendaraan_id = $request->kendaraan_id;
        $kendaraan = Kendaraan::find($kendaraan_id);

        if ($kendaraan) {
            $client = new Client();
            $response = $client->post('https://vtsapi.easygo-gps.co.id/api/Report/lastposition', [
                'headers' => [
                    'accept' => 'application/json',
                    'token' => 'B13E7A18C7FF4E80B9A252F54DB3D939',
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'list_vehicle_id' => [$kendaraan->vehicle_id], // Sesuaikan dengan field yang tepat dari tabel Kendaraan
                    'list_nopol' => [],
                    'list_no_aset' => [],
                    'status_vehicle' => 0,
                    'geo_code' => [],
                    'min_lastupdate_hour' => null,
                    'page' => 0,
                    'encrypted' => 0,
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            // Ambil nilai 'odometer' dari data API dan hilangkan bagian desimalnya
            $odometer = intval($data['Data'][0]['odometer'] ?? 0);

            if ($odometer > 0) {
                // Update nilai km kendaraan jika odometer valid
                $kendaraan->km = $odometer;
                $kendaraan->save();
            }
        }

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
        // $kendaraan->update([
        //     'km' => $request->km_akhir
        // ]);

        // $kms = $request->km_akhir;

        // Periksa apakah selisih kurang dari 1000 atau lebih tinggi dari km_olimesin
        if (
            $kendaraan->km > $kendaraan->km_olimesin - 1000 || $kendaraan->km > $kendaraan->km_olimesin
        ) {
            $status_olimesins = "belum penggantian";
            $kendaraan->status_olimesin = $status_olimesins;
        }

        if (
            $kendaraan->km > $kendaraan->km_oligardan - 5000 || $kendaraan->km > $kendaraan->km_oligardan
        ) {
            $status_olimesins = "belum penggantian";
            $kendaraan->status_oligardan = $status_olimesins;
        }

        if (
            $kendaraan->km > $kendaraan->km_olitransmisi - 5000 || $kendaraan->km > $kendaraan->km_olitransmisi
        ) {
            $status_olimesins = "belum penggantian";
            $kendaraan->status_olitransmisi = $status_olimesins;
        }

        // Update umur_ban for related ban
        foreach ($kendaraan->ban as $ban) {
            $ban->update([
                'umur_ban' => ($kendaraan->km - $ban->km_pemasangan) + ($ban->jumlah_km ?? 0)
            ]);
        }

        // Jika kendaraan tidak ditemukan atau odometer tidak valid, lanjutkan dengan proses SPK
        $kode = $this->kode();
        $tanggal = Carbon::now()->format('Y-m-d');
        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');

        $status_spk = $request->kategori === 'non memo' ? 'non memo' : null;
        $saldo_deposit = $request->saldo_deposit ? str_replace(',', '.', str_replace('.', '', $request->saldo_deposit)) : '0';
        $uang_jalan = $request->uang_jalan ? str_replace(',', '.', str_replace('.', '', $request->uang_jalan)) : '0';

        $km_akhir = $kendaraan->km;
        $cetakpdf = Spk::create(array_merge(
            $request->all(),
            [
                'admin' => auth()->user()->karyawan->nama_lengkap,
                'kode_spk' => $kode,
                'voucher' => '0',
                'user_id' => $request->user_id,
                'pelanggan_id' => $request->pelanggan_id,
                'alamat_muat_id' => $request->alamat_muat_id,
                'alamat_bongkar_id' => $request->alamat_bongkar_id,
                'vendor_id' => $request->vendor_id,
                'kendaraan_id' => $request->kendaraan_id,
                'no_kabin' => $request->no_kabin,
                'no_pol' => $request->no_pol,
                'golongan' => $request->golongan,
                'km_awal' => $request->km_awal,
                'km_akhir' => $km_akhir,
                'kode_driver' => $request->kode_driver,
                'nama_driver' => $request->nama_driver,
                'telp' => $request->telp,
                'rute_perjalanan_id' => $request->rute_perjalanan_id,
                'kode_rute' => $request->kode_rute,
                'nama_rute' => $request->nama_rute,
                'saldo_deposit' => $saldo_deposit,
                'uang_jalan' => $uang_jalan,
                'qrcode_spk' => 'https://javaline.id/spk/' . $kode,
                'tanggal' => $format_tanggal,
                'tanggal_awal' => $tanggal,
                'status_spk' => $status_spk,
                'status' => 'posting',
            ]
        ));

        $projects = Pengambilan_do::create(array_merge(
            $request->all(),
            [
                'spk_id' => $cetakpdf->id,
                'kendaraan_id' => $request->kendaraan_id,
                'rute_perjalanan_id' => $request->rute_perjalanan_id,
                'user_id' => $request->user_id,
                'km_awal' => $request->km_awal,
                'tanggal_awal' => $tanggal,
                'tanggal' => $format_tanggal,
                'status' => 'posting',
            ]
        ));

        return redirect('admin/spk')->with('success', 'Berhasil menambahkan spk');
    }



    // public function store(Request $request)
    // {
    //     $kendaraan_id = $request->kendaraan_id;
    //     $kendaraan = Kendaraan::find($kendaraan_id);

    //     if (!$kendaraan) {
    //         return response()->json(['message' => 'Kendaraan tidak ditemukan'], 404);
    //     }

    //     $client = new Client();
    //     $response = $client->post('https://vtsapi.easygo-gps.co.id/api/Report/lastposition', [
    //         'headers' => [
    //             'accept' => 'application/json',
    //             'token' => 'B13E7A18C7FF4E80B9A252F54DB3D939',
    //             'Content-Type' => 'application/json',
    //         ],
    //         'json' => [
    //             'list_vehicle_id' => [$kendaraan->vehicle_id], // Sesuaikan dengan field yang tepat dari tabel Kendaraan
    //             'list_nopol' => [],
    //             'list_no_aset' => [],
    //             'status_vehicle' => 0,
    //             'geo_code' => [],
    //             'min_lastupdate_hour' => null,
    //             'page' => 0,
    //             'encrypted' => 0,
    //         ],
    //     ]);

    //     $data = json_decode($response->getBody()->getContents(), true);

    //     // Ambil nilai 'odometer' dari data API dan hilangkan bagian desimalnya
    //     $odometer = intval($data['Data'][0]['odometer'] ?? 0);

    //     if ($odometer > 0) {
    //         $kendaraan->km = $odometer;
    //         $kendaraan->save();
    //         return response()->json(['message' => 'Nilai km berhasil diperbarui']);
    //     } else {
    //         return response()->json(['message' => 'Nilai odometer tidak ditemukan atau tidak valid pada response API'], 400);
    //     }
    // }


    public function kode()
    {
        $lastBarang = Spk::where('kode_spk', 'like', 'SPK%')->latest()->first();
        $lastMonth = $lastBarang ? date('m', strtotime($lastBarang->created_at)) : null;
        $currentMonth = date('m');
        if (!$lastBarang || $currentMonth != $lastMonth) {
            $num = 1;
        } else {
            $lastCode = $lastBarang->kode_spk;
            $parts = explode('/', $lastCode);
            $lastNum = end($parts);
            $num = (int) $lastNum + 1;
        }
        $formattedNum = sprintf("%03s", $num);
        $prefix = 'SPK';
        $tahun = date('y');
        $tanggal = date('dm');
        $newCode = $prefix . "/" . $tanggal . $tahun . "/" . $formattedNum;
        return $newCode;
    }
}