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
use Illuminate\Support\Facades\Http;
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

    public function ambil_km($id)
    {
        $kendaraan = Kendaraan::find($id);

        if ($kendaraan) {
            $client = new Client();
            $response = $client->post('https://vtsapi.easygo-gps.co.id/api/Report/lastposition', [
                'headers' => [
                    'accept' => 'application/json',
                    'token' => 'B13E7A18C7FF4E80B9A252F54DB3D939',
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'list_vehicle_id' => [$kendaraan->list_vehicle_id], // Sesuaikan dengan field yang tepat dari tabel Kendaraan
                    'list_nopol' => [],
                    'list_no_aset' => [],
                    'geo_code' => [],
                    'min_lastupdate_hour' => null,
                    'page' => 0,
                    'encrypted' => 0,
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            if (isset($data['Data'][0]['vehicle_id'])) {
                $vehicleId = $data['Data'][0]['vehicle_id'];

                // Periksa apakah vehicle_id sama dengan list_vehicle_id
                if ($vehicleId === $kendaraan->list_vehicle_id) {
                    // Ambil nilai 'odometer' dari data API dan hilangkan bagian desimalnya
                    $odometer = intval($data['Data'][0]['odometer'] ?? 0);

                    // if ($odometer > 0) {
                    //     $kendaraan->km = $odometer;
                    //     $kendaraan->save();
                    // }

                    return response()->json(['km' => $odometer]);
                } else {
                    $response = Http::get('https://app1.muliatrack.com/wspubjavasnackfactory/service.asmx/GetJsonPosition?sTokenKey=gps-J@va');
                    if ($response->successful()) {
                        $vehicles = $response->json();
                        $matchedVehicle = collect($vehicles)->firstWhere('gpsid', $kendaraan->gpsid);

                        if ($matchedVehicle) {
                            return response()->json(['km' => $matchedVehicle['odometer']]);
                        } else {
                            return response()->json(['km' => $kendaraan->km]);
                        }
                    }

                    // return response()->json(['km' => $kendaraan->km]);
                }
            }
        }

        // Jika kendaraan tidak ditemukan, kembalikan response error
        return response()->json(['error' => 'Kendaraan tidak ditemukan'], 404);
    }

    public function store(Request $request)
    {
        $jarak = Jarak_km::first(); // Mendapatkan jarak yang akan digunakan untuk validasi
        $rules = [
            'kode_spk' => 'unique:spks,kode_spk',
            'km_awal' => 'required',
            // 'alamat_muat_id' => 'required',
            // 'alamat_bongkar_id' => 'required',
        ];

        $messages = [
            'kode_spk.unique' => 'Kode spk sudah ada',
            'km_awal.required' => 'Km awal kendaraan tidak boleh kosong',
            // 'alamat_muat_id.required' => 'Pilih alamat muat',
            // 'alamat_bongkar_id.required' => 'Pilih alamat bongkar',
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

        // Validate the request
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }

        $kendaraan_id = $request->kendaraan_id;
        $kendaraan = Kendaraan::find($kendaraan_id);

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

        $kode = $this->kode();
        // tgl indo
        $tanggal = Carbon::now()->format('Y-m-d');
        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');

        $status_spk = $request->kategori === 'non memo' ? 'non memo' : null;
        $saldo_deposit = $request->saldo_deposit ? str_replace(',', '.', str_replace('.', '', $request->saldo_deposit)) : '0';
        $uang_jalan = $request->uang_jalan ? str_replace(',', '.', str_replace('.', '', $request->uang_jalan)) : '0';

        $cetakpdf = Spk::create(array_merge(
            $request->all(),
            [
                'admin' => auth()->user()->karyawan->nama_lengkap,
                'kode_spk' => $this->kode(),
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
                'user_id' => $request->user_id,
                'kode_driver' => $request->kode_driver,
                'nama_driver' => $request->nama_driver,
                'telp' => $request->telp,
                'rute_perjalanan_id' => $request->rute_perjalanan_id,
                'kode_rute' => $request->kode_rute,
                'nama_rute' => $request->nama_rute,
                'saldo_deposit' => $saldo_deposit,
                'uang_jalan' => $uang_jalan,
                'kode_spk' => $this->kode(),
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