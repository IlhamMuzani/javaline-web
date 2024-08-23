<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Admin\GajikaryawanController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Detail_kontrak;
use App\Models\Kontrak_rute;
use App\Models\Pelanggan;
use App\Models\Satuan;
use App\Models\Tarif;
use App\Models\Total_kasbon;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class InqueryKontrakruteController extends Controller
{
    public function index(Request $request)
    {
        Kontrak_rute::where([
            ['status', 'posting']
        ])->update([
            'status_notif' => true
        ]);

        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $inquery = Kontrak_rute::query();

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
        return view('admin.inquery_kontrakrute.index', compact('inquery'));
    }

    public function edit($id)
    {
        $inquery = Kontrak_rute::where('id', $id)->first();
        $details  = Detail_kontrak::where('kontrak_rute_id', $id)->get();
        $pelanggans = Pelanggan::all();
        return view('admin.inquery_kontrakrute.update', compact('details', 'inquery', 'pelanggans'));
    }

    public function update(Request $request, $id)
    {

        $validasi_pelanggan = Validator::make(
            $request->all(),
            [
                'pelanggan_id' => 'required',
            ],
            [
                'pelanggan_id.required' => 'Pilih Pelanggan',
            ]
        );

        $error_pelanggans = array();

        if ($validasi_pelanggan->fails()) {
            array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
        }

        $error_pesanans = array();
        $data_pembelians = collect();

        if ($request->has('nama_tarif')) {
            for ($i = 0; $i < count($request->nama_tarif); $i++) {
                $validasi_produk = Validator::make($request->all(), [
                    'nama_tarif.' . $i => 'required',
                    'nominal.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Akun nomor " . ($i + 1) . " belum dilengkapi!"); // Corrected the syntax for concatenation and indexing
                }

                $nama_tarif = is_null($request->nama_tarif[$i]) ? '' : $request->nama_tarif[$i];
                $nominal = is_null($request->nominal[$i]) ? '' : $request->nominal[$i];


                $data_pembelians->push([
                    'detail_id' => $request->detail_ids[$i] ?? null,
                    'nama_tarif' => $nama_tarif,
                    'nominal' => $nominal,

                ]);
            }
        }

        if ($error_pesanans) {
            return back()
                ->withInput()
                ->with('error_pesanans', $error_pesanans)
                ->with('data_pembelians', $data_pembelians);
        }

        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');

        $tanggal = Carbon::now()->format('Y-m-d');
        $cetakpdfs = Kontrak_rute::findOrFail($id);

        // Update the main transaction
        $cetakpdfs->update([
            'pelanggan_id' => $request->pelanggan_id,
            'keterangan' => $request->keterangan,
            'status' => 'unpost'
        ]);


        $transaksi_id = $cetakpdfs->id;

        $detailIds = $request->input('detail_ids');

        foreach ($data_pembelians as $data_pesanan) {
            $detailId = $data_pesanan['detail_id'];

            if ($detailId) {

                $existingDetail = Detail_kontrak::find($detailId);
                if ($existingDetail) {
                    $existingDetail->update([
                        'kontrak_rute_id' => $cetakpdfs->id,
                        'nama_tarif' => $data_pesanan['nama_tarif'],
                        'nominal' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['nominal'])),
                    ]);
                    $existingPengeluaran = Tarif::where('detail_kontrak_id', $existingDetail)->first();

                    if ($existingPengeluaran) {
                        $existingPengeluaran->update([
                            'pelanggan_id' => $cetakpdfs->pelanggan_id,
                            'kontrak_rute_id' => $cetakpdfs->id,
                            'detail_kontrak_id' => $detailId->id,
                            'nama_tarif' => $data_pesanan['nama_tarif'],
                            'nominal' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['nominal'])),
                            'status' =>  'unpost',
                        ]);
                    }
                }
            } else {
                $existingDetail = Detail_kontrak::where([
                    'kontrak_rute_id' => $cetakpdfs->id,
                    'nama_tarif' => $data_pesanan['nama_tarif'],
                    'nominal' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['nominal'])),
                ])->first();

                // $kodeban = $this->kodegaji();

                // Mendapatkan nilai potongan dari model Karyawan
                if (!$existingDetail) {
                    $detailfaktur = Detail_kontrak::create([
                        'kontrak_rute_id' => $cetakpdfs->id,
                        'nama_tarif' => $data_pesanan['nama_tarif'],
                        'nominal' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['nominal'])),
                    ]);

                    Tarif::create([
                        'kode_tarif' => $this->kode_tarif(),
                        'pelanggan_id' => $cetakpdfs->pelanggan_id,
                        'kontrak_rute_id' => $cetakpdfs->id,
                        'detail_kontrak_id' => $detailfaktur->id,
                        'nama_tarif' => $data_pesanan['nama_tarif'],
                        'nominal' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['nominal'])),
                        'status' =>  'unpost',
                    ]);
                }
            }
        }

        $cetakpdf = Kontrak_rute::where('id', $cetakpdfs->id)->first();
        $details = Detail_kontrak::where('kontrak_rute_id', $cetakpdfs->id)->get();

        return view('admin.inquery_kontrakrute.show', compact('cetakpdf', 'details'));
    }

    public function kode_tarif()
    {
        // Ambil tarif terakhir yang kodenya dimulai dengan 'HS'
        $lastBarang = Tarif::where('kode_tarif', 'LIKE', 'TF%')->latest('id')->first();

        // Jika tidak ada tarif dalam database dengan awalan 'HS'
        if (!$lastBarang) {
            $num = 1;
        } else {
            // Ambil kode tarif terakhir
            $lastCode = $lastBarang->kode_tarif;

            // Ambil angka setelah awalan 'TF'
            $num = (int) substr($lastCode, 2) + 1;
        }

        // Format nomor dengan panjang 6 digit (misalnya, 000001)
        $formattedNum = sprintf("%06s", $num);

        // Tentukan awalan kode
        $prefix = 'TF';

        // Gabungkan awalan dengan nomor yang diformat untuk mendapatkan kode baru
        $newCode = $prefix . $formattedNum;

        return $newCode;
    }

    public function show($id)
    {
        $cetakpdf = Kontrak_rute::where('id', $id)->first();
        $details = Detail_kontrak::where('kontrak_rute_id', $id)->get();

        return view('admin.inquery_kontrakrute.show', compact('cetakpdf', 'details'));
    }

    public function unpostpkontrak($id) {}

    public function postingpkontrak($id) {}



    public function hapuskontrak($id)
    {
        $item = Kontrak_rute::where('id', $id)->first();

        $item->detail_kontrak()->delete();
        $item->delete();

        return back()->with('success', 'Berhasil');
    }

    public function deletedetailkontrak($id)
    {
        $item = Detail_kontrak::find($id);

        if ($item) {
            $item->delete();
            return response()->json(['message' => 'Data deleted successfully']);
        } else {
            return response()->json(['message' => 'Detail Faktur not found'], 404);
        }
    }
}