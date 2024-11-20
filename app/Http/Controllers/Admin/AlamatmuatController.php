<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Alamat_muat;
use App\Models\Pelanggan;
use App\Models\Vendor;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client;

class AlamatmuatController extends Controller
{
    public function index()
    {
        $alamatmuats = Alamat_muat::all();
        return view('admin.alamat_muat.index', compact('alamatmuats'));
    }

    public function create()
    {
        $pelanggans = Pelanggan::get();
        $vendors = Vendor::get();

        return view('admin.alamat_muat.create', compact('pelanggans', 'vendors'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'alamat' => 'required',
                'latitude' => 'required',
            ],
            [
                'alamat.required' => 'Masukkan tujuan muat',
                'latitude.required' => 'Pilih titik tujuan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kode = $this->kode();

        Alamat_muat::create(array_merge(
            $request->all(),
            [
                'kode_alamat' => $this->kode(),
                'tanggal_awal' => Carbon::now('Asia/Jakarta'),
                'pelanggan_id' => $request->pelanggan_id,
                'telp' => $request->telp,
                'alamat' => $request->alamat,
                'nama_lokasi' => $request->nama_lokasi,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ],
        ));

        return redirect('admin/alamat_muat')->with('success', 'Berhasil menambahkan tujuan muat');
    }

    public function ambil_lokasi()
    {
        $client = new Client();

        try {
            // Gunakan URL API yang benar
            $response = $client->post('https://vtsapi.easygo-gps.co.id/api/geofence/masterdata', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Token' => 'B13E7A18C7FF4E80B9A252F54DB3D939',  // Ganti dengan token yang benar
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    "tipe" => null,
                    "code" => "",
                    "nama" => "",
                    "include_upline_downline" => 0
                ],
            ]);

            // Cek status kode HTTP
            if ($response->getStatusCode() === 200) {
                $data = json_decode($response->getBody()->getContents(), true);
                return response()->json($data);
            } else {
                return response()->json(['error' => 'Gagal mengambil data lokasi kendaraan.'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }


    public function ambil_lokasimulia()
    {
        // URL API yang benar
        $url = 'https://app1.muliatrack.com/wspubjavasnackfactory/service.asmx/GetJsonPositionPoi?sTokenKey=gps-J@va';

        // Inisialisasi client Guzzle untuk melakukan request
        $client = new Client();

        try {
            // Mengirim permintaan GET ke API
            $response = $client->get($url);

            // Cek status kode HTTP
            if ($response->getStatusCode() === 200) {
                // Mendapatkan isi body respons dan decode JSON
                $data = json_decode($response->getBody()->getContents(), true);

                // Mengekstrak PointName, Lon, dan Lat dari respons
                $lokasi = [];
                foreach ($data as $item) {
                    $lokasi[] = [
                        'PointName' => $item['PointName'],
                        'Lon' => $item['Lon'],
                        'Lat' => $item['Lat']
                    ];
                }

                // Mengembalikan data sebagai response JSON
                return response()->json($lokasi);
            } else {
                return response()->json(['error' => 'Gagal mengambil data lokasi kendaraan.'], 500);
            }
        } catch (\Exception $e) {
            // Menangani kesalahan jika ada exception
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }


    public function kode()
    {
        $lastBarang = Alamat_muat::latest()->first();
        if (!$lastBarang) {
            $num = 1;
        } else {
            $lastCode = $lastBarang->kode_alamat;
            $num = (int) substr($lastCode, strlen('AAM')) + 1;
        }
        $formattedNum = sprintf("%06s", $num);
        $prefix = 'AAM';
        $newCode = $prefix . $formattedNum;
        return $newCode;
    }

    public function edit($id)
    {
        $alamatmuats = Alamat_muat::where('id', $id)->first();
        $pelanggans = Pelanggan::get();
        $vendors = Vendor::get();
        return view('admin/alamat_muat.update', compact('alamatmuats', 'pelanggans', 'vendors'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'alamat' => 'required',
                'latitude' => 'required',
            ],
            [
                'alamat.required' => 'Masukkan tujuan muat',
                'latitude.required' => 'Pilih titik tujuan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $alamatmuats = Alamat_muat::findOrFail($id);

        $alamatmuats->pelanggan_id = $request->pelanggan_id;
        $alamatmuats->vendor_id = $request->vendor_id;
        $alamatmuats->alamat = $request->alamat;
        $alamatmuats->nama_lokasi = $request->nama_lokasi;
        $alamatmuats->telp = $request->telp;
        $alamatmuats->latitude = $request->latitude;
        $alamatmuats->longitude = $request->longitude;

        $alamatmuats->save();

        return redirect('admin/alamat_muat')->with('success', 'Berhasil memperbarui tujuan muat');
    }

    public function destroy($id)
    {
        $alamatmuats = Alamat_muat::find($id);
        $alamatmuats->delete();

        return redirect('admin/alamat_muat')->with('success', 'Berhasil menghapus tujuan muat');
    }
}
