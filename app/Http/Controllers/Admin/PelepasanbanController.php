<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Ban;
use App\Models\Kendaraan;
use App\Models\Service_ban;
use App\Models\Pelepasan_ban;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Deposit_driver;
use App\Models\Karyawan;
use App\Models\Penerimaan_kaskecil;
use App\Models\Saldo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\ServerBag;

class PelepasanbanController extends Controller
{
    public function index()
    {
        if (auth()->check() && auth()->user()->menu['pelepasan ban']) {
            $pelepasan_bans = Pelepasan_ban::all();

            $kendaraans = Kendaraan::where(['status_pemasangan' => 'pemasangan'])->get();
            return view('admin.pelepasan_ban.index', compact('pelepasan_bans', 'kendaraans'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function create()
    {
        if (auth()->check() && auth()->user()->menu['pelepasan ban']) {
            $kendaraans = Kendaraan::all();
            $bans = Ban::all();
            return view('admin/pelepasan_ban.create', compact('kendaraans', 'bans'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function edit($id)
    {
        $kendaraan = Kendaraan::where('id', $id)->first();

        $bans = Ban::where(['posisi_ban' => '1A', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id])->first();
        $bansb = Ban::where(['posisi_ban' => '1B', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id])->first();
        $bans2a = Ban::where(['posisi_ban' => '2A', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id])->first();
        $bans2b = Ban::where(['posisi_ban' => '2B', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id])->first();
        $bans2c = Ban::where(['posisi_ban' => '2C', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id])->first();
        $bans2d = Ban::where(['posisi_ban' => '2D', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id])->first();
        $bans3a = Ban::where(['posisi_ban' => '3A', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id])->first();
        $bans3b = Ban::where(['posisi_ban' => '3B', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id])->first();
        $bans3c = Ban::where(['posisi_ban' => '3C', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id])->first();
        $bans3d = Ban::where(['posisi_ban' => '3D', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id])->first();
        $bans4a = Ban::where(['posisi_ban' => '3A', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id])->first();
        $bans4b = Ban::where(['posisi_ban' => '3B', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id])->first();
        $bans4c = Ban::where(['posisi_ban' => '3C', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id])->first();
        $bans4d = Ban::where(['posisi_ban' => '3D', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id])->first();
        $bans4a = Ban::where(['posisi_ban' => '4A', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id])->first();
        $bans4b = Ban::where(['posisi_ban' => '4B', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id])->first();
        $bans4c = Ban::where(['posisi_ban' => '4C', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id])->first();
        $bans4d = Ban::where(['posisi_ban' => '4D', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id])->first();
        $bans5a = Ban::where(['posisi_ban' => '5A', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id])->first();
        $bans5b = Ban::where(['posisi_ban' => '5B', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id])->first();
        $bans5c = Ban::where(['posisi_ban' => '5C', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id])->first();
        $bans5d = Ban::where(['posisi_ban' => '5D', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id])->first();
        $bans6a = Ban::where(['posisi_ban' => '6A', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id])->first();
        $bans6b = Ban::where(['posisi_ban' => '6B', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id])->first();
        $bans6c = Ban::where(['posisi_ban' => '6C', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id])->first();
        $bans6d = Ban::where(['posisi_ban' => '6D', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id])->first();

        $SopirAll = Karyawan::where('departemen_id', '2')->get();

        $tabelbans = Ban::where(['kendaraan_id' => $kendaraan->id, 'status' => 'non aktif sementara'])->get();

        return view('admin/pelepasan_ban.create', compact('SopirAll', 'kendaraan', 'tabelbans', 'bans', 'bansb', 'bans2a', 'bans2b', 'bans2c', 'bans2d', 'bans3a', 'bans3b', 'bans3c', 'bans3d', 'bans4a', 'bans4b', 'bans4c', 'bans4d', 'bans5a', 'bans5b', 'bans5c', 'bans5d', 'bans6a', 'bans6b', 'bans6c', 'bans6d'));
    }


    public function store(Request $request)
    {
        $kendaraan_id = $request->kendaraan_id;

        Ban::where(['kendaraan_id' => $kendaraan_id, 'status' => 'non aktif sementara'])->update([
            'status' => 'aktif',
        ]);


        return redirect('admin/pelepasan_ban/' . $kendaraan_id . '/edit');
    }

    public function kode()
    {
        $lastBarang = Pelepasan_ban::latest()->first();
        if (!$lastBarang) {
            $num = 1;
        } else {
            $lastCode = $lastBarang->kode_pelepasan;
            $num = (int) substr($lastCode, strlen('AW')) + 1;
        }
        $formattedNum = sprintf("%06s", $num);
        $prefix = 'AW';
        $newCode = $prefix . $formattedNum;
        return $newCode;
    }


    public function kendaraan($id)
    {
        $jenis_kendaraan = Kendaraan::where('id', $id)->with('jenis_kendaraan')->first();

        return json_decode($jenis_kendaraan);
    }

    public function show($id)
    {
        $pemasangan_ban = Pelepasan_ban::findOrFail($id);

        $kendaraan_id = $pemasangan_ban->kendaraan_id;

        $kendaraan = Kendaraan::findOrFail($kendaraan_id);

        $bans = Ban::where('kendaraan_id', $kendaraan_id)->get();

        return view('admin.pelepasan_ban.show', compact('bans', 'kendaraan'));
    }

    public function cetakpdf($id)
    { {
            $pelepasan_ban = Pelepasan_ban::where('id', $id)->first();
            $pemasangan_ban = Pelepasan_ban::findOrFail($id);
            $kendaraan_id = $pemasangan_ban->kendaraan_id;
            $kendaraan = Kendaraan::findOrFail($kendaraan_id);
            $bans = Ban::where('pelepasan_ban_id', $id)->get();

            $pdf = PDF::loadView('admin/pelepasan_ban.cetak_pdf', compact('bans', 'kendaraan', 'pelepasan_ban'));
            $pdf->setPaper('letter', 'portrait');

            return $pdf->stream('Laporan_Pelepasan_Ban.pdf');
        }
    }

    public function destroy($id)
    {
        $ban = Ban::find($id);

        if (!$ban) {
            return redirect()->back()->with('error', 'Data ban tidak ditemukan');
        }

        $depositdriver = Deposit_driver::where('ban_id', $id)->first();
        if ($depositdriver) {
            // Hapus penerimaan_kaskecil yang terkait
            $penerimaanKasKecil = $depositdriver->penerimaan_kaskecil();
            if ($penerimaanKasKecil) {
                $penerimaanKasKecil->delete();
            }

            // Hapus deposit_driver
            $depositdriver->delete();
        }

        // Setelah itu, update objek Ban
        $ban->update([
            'pelepasan_ban_id' => null,
            'jumlah_km' => null,
            'status' => 'aktif'
        ]);

        return redirect()->back()->with('success', 'Berhasil menghapus pelepasan ban');
    }

    public function update(Request $request, $id)
    {

        $kendaraans = Kendaraan::findOrFail($id);

        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');

        // tgl filter
        $tanggal = Carbon::now()->format('Y-m-d');

        $pelepasan = Pelepasan_ban::create([
            'user_id' => auth()->user()->id,
            'kode_pelepasan' => $this->kode(),
            'kendaraan_id' => $kendaraans->id,
            'tanggal' => $format_tanggal,
            'tanggal_awal' => $tanggal,
            'status' => 'posting',
            'status_notif' => false,

        ]);
        $pelepasanId = $pelepasan->id;

        Ban::where([
            ['kendaraan_id', $id],
            ['keterangan', 'Stok'],
            ['status', 'non aktif sementara']
        ])->update([
            'status' => 'stok',
            'pelepasan_ban_id' => $pelepasanId,
            // 'kendaraan_id' => null,
        ]);

        Ban::where([
            ['kendaraan_id', $id],
            ['status', 'non aktif sementara']
        ])->update([
            'status' => 'non aktif',
            'pelepasan_ban_id' => $pelepasanId,
            // 'kendaraan_id' => null,
        ]);

        return redirect('admin/pelepasan_ban')->with('success', 'Berhasil melakukan pelepasan');
    }

    public function updatepelepasan_1a(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'keterangan' => 'required',
                'km_pelepasan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pelepasan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'keterangan.required' => 'Pilih Keterangan',
                'km_pelepasan.required' => 'Masukkan km pelepasan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $keterangan = $request->keterangan;
        if ($keterangan == "Pecah Klaim") {
            $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
            $kendaraan->update([
                'km' => $request->km_pelepasan,
            ]);

            $kendaraan = Kendaraan::findOrFail($id);
            $banId = $request->id_ban;
            $ban = Ban::find($banId);

            if (!$ban) {
                return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
            }

            $ban->update([
                'keterangan' => $request->keterangan,
                'km_pelepasan' => $request->km_pelepasan,
                'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',

            ]);

            $kodedepositdriver = $this->kodedepositdriver();

            $tanggal1 = Carbon::now('Asia/Jakarta');
            $format_tanggal = $tanggal1->format('d F Y');

            $tanggal = Carbon::now()->format('Y-m-d');
            $depositdriver = Deposit_driver::create(array_merge(
                $request->all(),
                [
                    'kode_deposit' => $this->kodedepositdriver(),
                    'ban_id' => $banId,
                    'karyawan_id' => $request->karyawan_id,
                    'kode_sopir' => $request->kode_karyawan,
                    'nama_sopir' => $request->nama_lengkap,
                    'kategori' => 'Pengambilan Deposit',
                    'sub_total' => str_replace('.', '', $request->sub_totals),
                    'nominal' => str_replace('.', '', $request->saldo_keluar),
                    'saldo_keluar' => $request->saldo_keluar,
                    'keterangan' => $request->keterangans,
                    'sisa_saldo' => str_replace('.', '', $request->sisa_saldo),
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));

            $saldoTerakhir = Saldo::latest()->first();
            $saldo = $saldoTerakhir->id;
            // Menghapus tanda titik dari nilai saldo_keluar dan mengonversi ke tipe numerik
            $saldo_keluar_numeric = (float) str_replace('.', '', $request->saldo_keluar);
            $subtotals =  $saldoTerakhir->sisa_saldo + $saldo_keluar_numeric;
            $kodepenerimaan = $this->kodepenerimaan();
            $penerimaan = Penerimaan_kaskecil::create(array_merge(
                $request->all(),
                [
                    'kode_penerimaan' => $this->kodepenerimaan(),
                    'deposit_driver_id' => $depositdriver->id,
                    'nominal' => str_replace('.', '', $request->saldo_keluar),
                    'saldo_masuk' => $request->saldo_keluar,
                    'keterangan' => $request->keterangans,
                    'sisa_saldo' => $saldoTerakhir->sisa_saldo,
                    'saldo_id' => $saldo,
                    'sub_total' => $subtotals,
                    'qr_code_penerimaan' => 'https:///javaline.id/penerimaan_kaskecil/' . $kodepenerimaan,
                    'tanggaljam' => Carbon::now('Asia/Jakarta'),
                    'jam' => $tanggal1->format('H:i:s'),
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));
        } else {
            $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
            $kendaraan->update([
                'km' => $request->km_pelepasan,
            ]);

            $kendaraan = Kendaraan::findOrFail($id);
            $banId = $request->id_ban;
            $ban = Ban::find($banId);

            if (!$ban) {
                return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
            }

            $ban->update([
                'keterangan' => $request->keterangan,
                'km_pelepasan' => $request->km_pelepasan,
                'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',
            ]);
        }

        return redirect()->back()->withInput()->with('success', 'Berhasil menambahkan Pelepasan ban pada posisi Axle 1A');

        // return Redirect::back()->with('success', 'Berhasil menambahkan Pelepasan ban pada posisi Axle 1A');
    }

    public function updatepelepasan_1b(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'keterangan' => 'required',
                'km_pelepasan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pelepasan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'keterangan.required' => 'Pilih Keterangan',
                'km_pelepasan.required' => 'Masukkan km pelepasan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $keterangan = $request->keterangan;
        if ($keterangan == "Pecah Klaim") {
            $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
            $kendaraan->update([
                'km' => $request->km_pelepasan,
            ]);

            $kendaraan = Kendaraan::findOrFail($id);
            $banId = $request->id_ban;
            $ban = Ban::find($banId);

            if (!$ban) {
                return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
            }

            $ban->update([
                'keterangan' => $request->keterangan,
                'km_pelepasan' => $request->km_pelepasan,
                'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',

            ]);

            $kodedepositdriver = $this->kodedepositdriver();

            $tanggal1 = Carbon::now('Asia/Jakarta');
            $format_tanggal = $tanggal1->format('d F Y');

            $tanggal = Carbon::now()->format('Y-m-d');
            $depositdriver = Deposit_driver::create(array_merge(
                $request->all(),
                [
                    'kode_deposit' => $this->kodedepositdriver(),
                    'ban_id' => $banId,
                    'karyawan_id' => $request->karyawan_id,
                    'kode_sopir' => $request->kode_karyawan,
                    'nama_sopir' => $request->nama_lengkap,
                    'kategori' => 'Pengambilan Deposit',
                    'sub_total' => str_replace('.', '', $request->sub_totals),
                    'nominal' => str_replace('.', '', $request->saldo_keluar),
                    'saldo_keluar' => $request->saldo_keluar,
                    'keterangan' => $request->keterangans,
                    'sisa_saldo' => str_replace('.', '', $request->sisa_saldo),
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));

            $saldoTerakhir = Saldo::latest()->first();
            $saldo = $saldoTerakhir->id;
            // Menghapus tanda titik dari nilai saldo_keluar dan mengonversi ke tipe numerik
            $saldo_keluar_numeric = (float) str_replace('.', '', $request->saldo_keluar);
            $subtotals =  $saldoTerakhir->sisa_saldo + $saldo_keluar_numeric;
            $kodepenerimaan = $this->kodepenerimaan();
            $penerimaan = Penerimaan_kaskecil::create(array_merge(
                $request->all(),
                [
                    'kode_penerimaan' => $this->kodepenerimaan(),
                    'deposit_driver_id' => $depositdriver->id,
                    'nominal' => str_replace('.', '', $request->saldo_keluar),
                    'saldo_masuk' => $request->saldo_keluar,
                    'keterangan' => $request->keterangans,
                    'sisa_saldo' => $saldoTerakhir->sisa_saldo,
                    'saldo_id' => $saldo,
                    'sub_total' => $subtotals,
                    'qr_code_penerimaan' => 'https:///javaline.id/penerimaan_kaskecil/' . $kodepenerimaan,
                    'tanggaljam' => Carbon::now('Asia/Jakarta'),
                    'jam' => $tanggal1->format('H:i:s'),
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));
        } else {
            $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
            $kendaraan->update([
                'km' => $request->km_pelepasan,
            ]);

            $kendaraan = Kendaraan::findOrFail($id);
            $banId = $request->id_ban;
            $ban = Ban::find($banId);

            if (!$ban) {
                return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
            }

            $ban->update([
                'keterangan' => $request->keterangan,
                'km_pelepasan' => $request->km_pelepasan,
                'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',
            ]);
        }
        return redirect()->back()->withInput()->with('success', 'Berhasil menambahkan Pelepasan ban pada posisi Axle 1B');
    }

    public function updatepelepasan_2a(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'keterangan' => 'required',
                'km_pelepasan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pelepasan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'keterangan.required' => 'Pilih Keterangan',
                'km_pelepasan.required' => 'Masukkan km pelepasan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }
        $keterangan = $request->keterangan;
        if ($keterangan == "Pecah Klaim") {
            $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
            $kendaraan->update([
                'km' => $request->km_pelepasan,
            ]);

            $kendaraan = Kendaraan::findOrFail($id);
            $banId = $request->id_ban;
            $ban = Ban::find($banId);

            if (!$ban) {
                return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
            }

            $ban->update([
                'keterangan' => $request->keterangan,
                'km_pelepasan' => $request->km_pelepasan,
                'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',

            ]);

            $kodedepositdriver = $this->kodedepositdriver();

            $tanggal1 = Carbon::now('Asia/Jakarta');
            $format_tanggal = $tanggal1->format('d F Y');

            $tanggal = Carbon::now()->format('Y-m-d');
            $depositdriver = Deposit_driver::create(array_merge(
                $request->all(),
                [
                    'kode_deposit' => $this->kodedepositdriver(),
                    'ban_id' => $banId,
                    'karyawan_id' => $request->karyawan_id,
                    'kode_sopir' => $request->kode_karyawan,
                    'nama_sopir' => $request->nama_lengkap,
                    'kategori' => 'Pengambilan Deposit',
                    'sub_total' => str_replace('.', '', $request->sub_totals),
                    'nominal' => str_replace('.', '', $request->saldo_keluar),
                    'saldo_keluar' => $request->saldo_keluar,
                    'keterangan' => $request->keterangans,
                    'sisa_saldo' => str_replace('.', '', $request->sisa_saldo),
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));

            $saldoTerakhir = Saldo::latest()->first();
            $saldo = $saldoTerakhir->id;
            // Menghapus tanda titik dari nilai saldo_keluar dan mengonversi ke tipe numerik
            $saldo_keluar_numeric = (float) str_replace('.', '', $request->saldo_keluar);
            $subtotals =  $saldoTerakhir->sisa_saldo + $saldo_keluar_numeric;
            $kodepenerimaan = $this->kodepenerimaan();
            $penerimaan = Penerimaan_kaskecil::create(array_merge(
                $request->all(),
                [
                    'kode_penerimaan' => $this->kodepenerimaan(),
                    'deposit_driver_id' => $depositdriver->id,
                    'nominal' => str_replace('.', '', $request->saldo_keluar),
                    'saldo_masuk' => $request->saldo_keluar,
                    'keterangan' => $request->keterangans,
                    'sisa_saldo' => $saldoTerakhir->sisa_saldo,
                    'saldo_id' => $saldo,
                    'sub_total' => $subtotals,
                    'qr_code_penerimaan' => 'https:///javaline.id/penerimaan_kaskecil/' . $kodepenerimaan,
                    'tanggaljam' => Carbon::now('Asia/Jakarta'),
                    'jam' => $tanggal1->format('H:i:s'),
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));
        } else {
            $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
            $kendaraan->update([
                'km' => $request->km_pelepasan
            ]);

            $kendaraan = Kendaraan::findOrFail($id);
            $banId = $request->id_ban;
            $ban = Ban::find($banId);

            if (!$ban) {
                return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
            }

            $ban->update([
                'keterangan' => $request->keterangan,
                'km_pelepasan' => $request->km_pelepasan,
                'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',
            ]);
        }

        return redirect()->back()->withInput()->with('success', 'Berhasil menambahkan Pelepasan ban pada posisi Axle 2A');
    }

    public function updatepelepasan_2b(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'keterangan' => 'required',
                'km_pelepasan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pelepasan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'keterangan.required' => 'Pilih Keterangan',
                'km_pelepasan.required' => 'Masukkan km pelepasan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $keterangan = $request->keterangan;
        if ($keterangan == "Pecah Klaim") {
            $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
            $kendaraan->update([
                'km' => $request->km_pelepasan,
            ]);

            $kendaraan = Kendaraan::findOrFail($id);
            $banId = $request->id_ban;
            $ban = Ban::find($banId);

            if (!$ban) {
                return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
            }

            $ban->update([
                'keterangan' => $request->keterangan,
                'km_pelepasan' => $request->km_pelepasan,
                'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',

            ]);

            $kodedepositdriver = $this->kodedepositdriver();

            $tanggal1 = Carbon::now('Asia/Jakarta');
            $format_tanggal = $tanggal1->format('d F Y');

            $tanggal = Carbon::now()->format('Y-m-d');
            $depositdriver = Deposit_driver::create(array_merge(
                $request->all(),
                [
                    'kode_deposit' => $this->kodedepositdriver(),
                    'ban_id' => $banId,
                    'karyawan_id' => $request->karyawan_id,
                    'kode_sopir' => $request->kode_karyawan,
                    'nama_sopir' => $request->nama_lengkap,
                    'kategori' => 'Pengambilan Deposit',
                    'sub_total' => str_replace('.', '', $request->sub_totals),
                    'nominal' => str_replace('.', '', $request->saldo_keluar),
                    'saldo_keluar' => $request->saldo_keluar,
                    'keterangan' => $request->keterangans,
                    'sisa_saldo' => str_replace('.', '', $request->sisa_saldo),
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));

            $saldoTerakhir = Saldo::latest()->first();
            $saldo = $saldoTerakhir->id;
            // Menghapus tanda titik dari nilai saldo_keluar dan mengonversi ke tipe numerik
            $saldo_keluar_numeric = (float) str_replace('.', '', $request->saldo_keluar);
            $subtotals =  $saldoTerakhir->sisa_saldo + $saldo_keluar_numeric;
            $kodepenerimaan = $this->kodepenerimaan();
            $penerimaan = Penerimaan_kaskecil::create(array_merge(
                $request->all(),
                [
                    'kode_penerimaan' => $this->kodepenerimaan(),
                    'deposit_driver_id' => $depositdriver->id,
                    'nominal' => str_replace('.', '', $request->saldo_keluar),
                    'saldo_masuk' => $request->saldo_keluar,
                    'keterangan' => $request->keterangans,
                    'sisa_saldo' => $saldoTerakhir->sisa_saldo,
                    'saldo_id' => $saldo,
                    'sub_total' => $subtotals,
                    'qr_code_penerimaan' => 'https:///javaline.id/penerimaan_kaskecil/' . $kodepenerimaan,
                    'tanggaljam' => Carbon::now('Asia/Jakarta'),
                    'jam' => $tanggal1->format('H:i:s'),
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));
        } else {
            $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
            $kendaraan->update([
                'km' => $request->km_pelepasan
            ]);

            $kendaraan = Kendaraan::findOrFail($id);
            $banId = $request->id_ban;
            $ban = Ban::find($banId);

            if (!$ban) {
                return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
            }

            $ban->update([
                'keterangan' => $request->keterangan,
                'km_pelepasan' => $request->km_pelepasan,
                'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',
            ]);
        }

        return redirect()->back()->withInput()->with('success', 'Berhasil menambahkan Pelepasan ban pada posisi Axle 2B');
    }

    public function updatepelepasan_2c(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'keterangan' => 'required',
                'km_pelepasan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pelepasan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'keterangan.required' => 'Pilih Keterangan',
                'km_pelepasan.required' => 'Masukkan km pelepasan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $keterangan = $request->keterangan;
        if ($keterangan == "Pecah Klaim") {
            $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
            $kendaraan->update([
                'km' => $request->km_pelepasan,
            ]);

            $kendaraan = Kendaraan::findOrFail($id);
            $banId = $request->id_ban;
            $ban = Ban::find($banId);

            if (!$ban) {
                return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
            }

            $ban->update([
                'keterangan' => $request->keterangan,
                'km_pelepasan' => $request->km_pelepasan,
                'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',

            ]);

            $kodedepositdriver = $this->kodedepositdriver();

            $tanggal1 = Carbon::now('Asia/Jakarta');
            $format_tanggal = $tanggal1->format('d F Y');

            $tanggal = Carbon::now()->format('Y-m-d');
            $depositdriver = Deposit_driver::create(array_merge(
                $request->all(),
                [
                    'kode_deposit' => $this->kodedepositdriver(),
                    'ban_id' => $banId,
                    'karyawan_id' => $request->karyawan_id,
                    'kode_sopir' => $request->kode_karyawan,
                    'nama_sopir' => $request->nama_lengkap,
                    'kategori' => 'Pengambilan Deposit',
                    'sub_total' => str_replace('.', '', $request->sub_totals),
                    'nominal' => str_replace('.', '', $request->saldo_keluar),
                    'saldo_keluar' => $request->saldo_keluar,
                    'keterangan' => $request->keterangans,
                    'sisa_saldo' => str_replace('.', '', $request->sisa_saldo),
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));

            $saldoTerakhir = Saldo::latest()->first();
            $saldo = $saldoTerakhir->id;
            // Menghapus tanda titik dari nilai saldo_keluar dan mengonversi ke tipe numerik
            $saldo_keluar_numeric = (float) str_replace('.', '', $request->saldo_keluar);
            $subtotals =  $saldoTerakhir->sisa_saldo + $saldo_keluar_numeric;
            $kodepenerimaan = $this->kodepenerimaan();
            $penerimaan = Penerimaan_kaskecil::create(array_merge(
                $request->all(),
                [
                    'kode_penerimaan' => $this->kodepenerimaan(),
                    'deposit_driver_id' => $depositdriver->id,
                    'nominal' => str_replace('.', '', $request->saldo_keluar),
                    'saldo_masuk' => $request->saldo_keluar,
                    'keterangan' => $request->keterangans,
                    'sisa_saldo' => $saldoTerakhir->sisa_saldo,
                    'saldo_id' => $saldo,
                    'sub_total' => $subtotals,
                    'qr_code_penerimaan' => 'https:///javaline.id/penerimaan_kaskecil/' . $kodepenerimaan,
                    'tanggaljam' => Carbon::now('Asia/Jakarta'),
                    'jam' => $tanggal1->format('H:i:s'),
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));
        } else {
            $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
            $kendaraan->update([
                'km' => $request->km_pelepasan
            ]);

            $kendaraan = Kendaraan::findOrFail($id);
            $banId = $request->id_ban;
            $ban = Ban::find($banId);

            if (!$ban) {
                return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
            }

            $ban->update([
                'keterangan' => $request->keterangan,
                'km_pelepasan' => $request->km_pelepasan,
                'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',
            ]);
        }
        return redirect()->back()->withInput()->with('success', 'Berhasil menambahkan Pelepasan ban pada posisi Axle 2C');
    }

    public function updatepelepasan_2d(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'keterangan' => 'required',
                'km_pelepasan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pelepasan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'keterangan.required' => 'Pilih Keterangan',
                'km_pelepasan.required' => 'Masukkan km pelepasan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $keterangan = $request->keterangan;
        if ($keterangan == "Pecah Klaim") {
            $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
            $kendaraan->update([
                'km' => $request->km_pelepasan,
            ]);

            $kendaraan = Kendaraan::findOrFail($id);
            $banId = $request->id_ban;
            $ban = Ban::find($banId);

            if (!$ban) {
                return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
            }

            $ban->update([
                'keterangan' => $request->keterangan,
                'km_pelepasan' => $request->km_pelepasan,
                'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',

            ]);

            $kodedepositdriver = $this->kodedepositdriver();

            $tanggal1 = Carbon::now('Asia/Jakarta');
            $format_tanggal = $tanggal1->format('d F Y');

            $tanggal = Carbon::now()->format('Y-m-d');
            $depositdriver = Deposit_driver::create(array_merge(
                $request->all(),
                [
                    'kode_deposit' => $this->kodedepositdriver(),
                    'ban_id' => $banId,
                    'karyawan_id' => $request->karyawan_id,
                    'kode_sopir' => $request->kode_karyawan,
                    'nama_sopir' => $request->nama_lengkap,
                    'kategori' => 'Pengambilan Deposit',
                    'sub_total' => str_replace('.', '', $request->sub_totals),
                    'nominal' => str_replace('.', '', $request->saldo_keluar),
                    'saldo_keluar' => $request->saldo_keluar,
                    'keterangan' => $request->keterangans,
                    'sisa_saldo' => str_replace('.', '', $request->sisa_saldo),
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));

            $saldoTerakhir = Saldo::latest()->first();
            $saldo = $saldoTerakhir->id;
            // Menghapus tanda titik dari nilai saldo_keluar dan mengonversi ke tipe numerik
            $saldo_keluar_numeric = (float) str_replace('.', '', $request->saldo_keluar);
            $subtotals =  $saldoTerakhir->sisa_saldo + $saldo_keluar_numeric;
            $kodepenerimaan = $this->kodepenerimaan();
            $penerimaan = Penerimaan_kaskecil::create(array_merge(
                $request->all(),
                [
                    'kode_penerimaan' => $this->kodepenerimaan(),
                    'deposit_driver_id' => $depositdriver->id,
                    'nominal' => str_replace('.', '', $request->saldo_keluar),
                    'saldo_masuk' => $request->saldo_keluar,
                    'keterangan' => $request->keterangans,
                    'sisa_saldo' => $saldoTerakhir->sisa_saldo,
                    'saldo_id' => $saldo,
                    'sub_total' => $subtotals,
                    'qr_code_penerimaan' => 'https:///javaline.id/penerimaan_kaskecil/' . $kodepenerimaan,
                    'tanggaljam' => Carbon::now('Asia/Jakarta'),
                    'jam' => $tanggal1->format('H:i:s'),
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));
        } else {
            $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
            $kendaraan->update([
                'km' => $request->km_pelepasan
            ]);

            $kendaraan = Kendaraan::findOrFail($id);
            $banId = $request->id_ban;
            $ban = Ban::find($banId);

            if (!$ban) {
                return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
            }

            $ban->update([
                'keterangan' => $request->keterangan,
                'km_pelepasan' => $request->km_pelepasan,
                'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',
            ]);
        }
        return redirect()->back()->withInput()->with('success', 'Berhasil menambahkan Pelepasan ban pada posisi Axle 2D');
    }

    public function updatepelepasan_3a(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'keterangan' => 'required',
                'km_pelepasan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pelepasan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'keterangan.required' => 'Pilih Keterangan',
                'km_pelepasan.required' => 'Masukkan km pelepasan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $keterangan = $request->keterangan;
        if ($keterangan == "Pecah Klaim") {
            $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
            $kendaraan->update([
                'km' => $request->km_pelepasan,
            ]);

            $kendaraan = Kendaraan::findOrFail($id);
            $banId = $request->id_ban;
            $ban = Ban::find($banId);

            if (!$ban) {
                return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
            }

            $ban->update([
                'keterangan' => $request->keterangan,
                'km_pelepasan' => $request->km_pelepasan,
                'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',

            ]);

            $kodedepositdriver = $this->kodedepositdriver();

            $tanggal1 = Carbon::now('Asia/Jakarta');
            $format_tanggal = $tanggal1->format('d F Y');

            $tanggal = Carbon::now()->format('Y-m-d');
            $depositdriver = Deposit_driver::create(array_merge(
                $request->all(),
                [
                    'kode_deposit' => $this->kodedepositdriver(),
                    'ban_id' => $banId,
                    'karyawan_id' => $request->karyawan_id,
                    'kode_sopir' => $request->kode_karyawan,
                    'nama_sopir' => $request->nama_lengkap,
                    'kategori' => 'Pengambilan Deposit',
                    'sub_total' => str_replace('.', '', $request->sub_totals),
                    'nominal' => str_replace('.', '', $request->saldo_keluar),
                    'saldo_keluar' => $request->saldo_keluar,
                    'keterangan' => $request->keterangans,
                    'sisa_saldo' => str_replace('.', '', $request->sisa_saldo),
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));

            $saldoTerakhir = Saldo::latest()->first();
            $saldo = $saldoTerakhir->id;
            // Menghapus tanda titik dari nilai saldo_keluar dan mengonversi ke tipe numerik
            $saldo_keluar_numeric = (float) str_replace('.', '', $request->saldo_keluar);
            $subtotals =  $saldoTerakhir->sisa_saldo + $saldo_keluar_numeric;
            $kodepenerimaan = $this->kodepenerimaan();
            $penerimaan = Penerimaan_kaskecil::create(array_merge(
                $request->all(),
                [
                    'kode_penerimaan' => $this->kodepenerimaan(),
                    'deposit_driver_id' => $depositdriver->id,
                    'nominal' => str_replace('.', '', $request->saldo_keluar),
                    'saldo_masuk' => $request->saldo_keluar,
                    'keterangan' => $request->keterangans,
                    'sisa_saldo' => $saldoTerakhir->sisa_saldo,
                    'saldo_id' => $saldo,
                    'sub_total' => $subtotals,
                    'qr_code_penerimaan' => 'https:///javaline.id/penerimaan_kaskecil/' . $kodepenerimaan,
                    'tanggaljam' => Carbon::now('Asia/Jakarta'),
                    'jam' => $tanggal1->format('H:i:s'),
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));
        } else {

            $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
            $kendaraan->update([
                'km' => $request->km_pelepasan
            ]);

            $kendaraan = Kendaraan::findOrFail($id);
            $banId = $request->id_ban;
            $ban = Ban::find($banId);

            if (!$ban) {
                return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
            }

            $ban->update([
                'keterangan' => $request->keterangan,
                'km_pelepasan' => $request->km_pelepasan,
                'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',
            ]);
        }
        return redirect()->back()->withInput()->with('success', 'Berhasil menambahkan Pelepasan ban pada posisi Axle 3A');
    }

    public function updatepelepasan_3b(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'keterangan' => 'required',
                'km_pelepasan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pelepasan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'keterangan.required' => 'Pilih Keterangan',
                'km_pelepasan.required' => 'Masukkan km pelepasan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $keterangan = $request->keterangan;
        if ($keterangan == "Pecah Klaim") {
            $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
            $kendaraan->update([
                'km' => $request->km_pelepasan,
            ]);

            $kendaraan = Kendaraan::findOrFail($id);
            $banId = $request->id_ban;
            $ban = Ban::find($banId);

            if (!$ban) {
                return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
            }

            $ban->update([
                'keterangan' => $request->keterangan,
                'km_pelepasan' => $request->km_pelepasan,
                'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',

            ]);

            $kodedepositdriver = $this->kodedepositdriver();

            $tanggal1 = Carbon::now('Asia/Jakarta');
            $format_tanggal = $tanggal1->format('d F Y');

            $tanggal = Carbon::now()->format('Y-m-d');
            $depositdriver = Deposit_driver::create(array_merge(
                $request->all(),
                [
                    'kode_deposit' => $this->kodedepositdriver(),
                    'ban_id' => $banId,
                    'karyawan_id' => $request->karyawan_id,
                    'kode_sopir' => $request->kode_karyawan,
                    'nama_sopir' => $request->nama_lengkap,
                    'kategori' => 'Pengambilan Deposit',
                    'sub_total' => str_replace('.', '', $request->sub_totals),
                    'nominal' => str_replace('.', '', $request->saldo_keluar),
                    'saldo_keluar' => $request->saldo_keluar,
                    'keterangan' => $request->keterangans,
                    'sisa_saldo' => str_replace('.', '', $request->sisa_saldo),
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));

            $saldoTerakhir = Saldo::latest()->first();
            $saldo = $saldoTerakhir->id;
            // Menghapus tanda titik dari nilai saldo_keluar dan mengonversi ke tipe numerik
            $saldo_keluar_numeric = (float) str_replace('.', '', $request->saldo_keluar);
            $subtotals =  $saldoTerakhir->sisa_saldo + $saldo_keluar_numeric;
            $kodepenerimaan = $this->kodepenerimaan();
            $penerimaan = Penerimaan_kaskecil::create(array_merge(
                $request->all(),
                [
                    'kode_penerimaan' => $this->kodepenerimaan(),
                    'deposit_driver_id' => $depositdriver->id,
                    'nominal' => str_replace('.', '', $request->saldo_keluar),
                    'saldo_masuk' => $request->saldo_keluar,
                    'keterangan' => $request->keterangans,
                    'sisa_saldo' => $saldoTerakhir->sisa_saldo,
                    'saldo_id' => $saldo,
                    'sub_total' => $subtotals,
                    'qr_code_penerimaan' => 'https:///javaline.id/penerimaan_kaskecil/' . $kodepenerimaan,
                    'tanggaljam' => Carbon::now('Asia/Jakarta'),
                    'jam' => $tanggal1->format('H:i:s'),
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));
        } else {
            $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
            $kendaraan->update([
                'km' => $request->km_pelepasan
            ]);

            $kendaraan = Kendaraan::findOrFail($id);
            $banId = $request->id_ban;
            $ban = Ban::find($banId);

            if (!$ban) {
                return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
            }

            $ban->update([
                'keterangan' => $request->keterangan,
                'km_pelepasan' => $request->km_pelepasan,
                'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',
            ]);
        }
        return redirect()->back()->withInput()->with('success', 'Berhasil menambahkan Pelepasan ban pada posisi Axle 3B');
    }

    public function updatepelepasan_3c(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'keterangan' => 'required',
                'km_pelepasan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pelepasan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'keterangan.required' => 'Pilih Keterangan',
                'km_pelepasan.required' => 'Masukkan km pelepasan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $keterangan = $request->keterangan;
        if ($keterangan == "Pecah Klaim") {
            $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
            $kendaraan->update([
                'km' => $request->km_pelepasan,
            ]);

            $kendaraan = Kendaraan::findOrFail($id);
            $banId = $request->id_ban;
            $ban = Ban::find($banId);

            if (!$ban) {
                return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
            }

            $ban->update([
                'keterangan' => $request->keterangan,
                'km_pelepasan' => $request->km_pelepasan,
                'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',

            ]);

            $kodedepositdriver = $this->kodedepositdriver();

            $tanggal1 = Carbon::now('Asia/Jakarta');
            $format_tanggal = $tanggal1->format('d F Y');

            $tanggal = Carbon::now()->format('Y-m-d');
            $depositdriver = Deposit_driver::create(array_merge(
                $request->all(),
                [
                    'kode_deposit' => $this->kodedepositdriver(),
                    'ban_id' => $banId,
                    'karyawan_id' => $request->karyawan_id,
                    'kode_sopir' => $request->kode_karyawan,
                    'nama_sopir' => $request->nama_lengkap,
                    'kategori' => 'Pengambilan Deposit',
                    'sub_total' => str_replace('.', '', $request->sub_totals),
                    'nominal' => str_replace('.', '', $request->saldo_keluar),
                    'saldo_keluar' => $request->saldo_keluar,
                    'keterangan' => $request->keterangans,
                    'sisa_saldo' => str_replace('.', '', $request->sisa_saldo),
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));

            $saldoTerakhir = Saldo::latest()->first();
            $saldo = $saldoTerakhir->id;
            // Menghapus tanda titik dari nilai saldo_keluar dan mengonversi ke tipe numerik
            $saldo_keluar_numeric = (float) str_replace('.', '', $request->saldo_keluar);
            $subtotals =  $saldoTerakhir->sisa_saldo + $saldo_keluar_numeric;
            $kodepenerimaan = $this->kodepenerimaan();
            $penerimaan = Penerimaan_kaskecil::create(array_merge(
                $request->all(),
                [
                    'kode_penerimaan' => $this->kodepenerimaan(),
                    'deposit_driver_id' => $depositdriver->id,
                    'nominal' => str_replace('.', '', $request->saldo_keluar),
                    'saldo_masuk' => $request->saldo_keluar,
                    'keterangan' => $request->keterangans,
                    'sisa_saldo' => $saldoTerakhir->sisa_saldo,
                    'saldo_id' => $saldo,
                    'sub_total' => $subtotals,
                    'qr_code_penerimaan' => 'https:///javaline.id/penerimaan_kaskecil/' . $kodepenerimaan,
                    'tanggaljam' => Carbon::now('Asia/Jakarta'),
                    'jam' => $tanggal1->format('H:i:s'),
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));
        } else {
            $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
            $kendaraan->update([
                'km' => $request->km_pelepasan
            ]);

            $kendaraan = Kendaraan::findOrFail($id);
            $banId = $request->id_ban;
            $ban = Ban::find($banId);

            if (!$ban) {
                return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
            }

            $ban->update([
                'keterangan' => $request->keterangan,
                'km_pelepasan' => $request->km_pelepasan,
                'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',
            ]);
        }
        return redirect()->back()->withInput()->with('success', 'Berhasil menambahkan Pelepasan ban pada posisi Axle 3C');
    }

    public function updatepelepasan_3d(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'keterangan' => 'required',
                'km_pelepasan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pelepasan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'keterangan.required' => 'Pilih Keterangan',
                'km_pelepasan.required' => 'Masukkan km pelepasan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $keterangan = $request->keterangan;
        if ($keterangan == "Pecah Klaim") {
            $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
            $kendaraan->update([
                'km' => $request->km_pelepasan,
            ]);

            $kendaraan = Kendaraan::findOrFail($id);
            $banId = $request->id_ban;
            $ban = Ban::find($banId);

            if (!$ban) {
                return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
            }

            $ban->update([
                'keterangan' => $request->keterangan,
                'km_pelepasan' => $request->km_pelepasan,
                'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',

            ]);

            $kodedepositdriver = $this->kodedepositdriver();

            $tanggal1 = Carbon::now('Asia/Jakarta');
            $format_tanggal = $tanggal1->format('d F Y');

            $tanggal = Carbon::now()->format('Y-m-d');
            $depositdriver = Deposit_driver::create(array_merge(
                $request->all(),
                [
                    'kode_deposit' => $this->kodedepositdriver(),
                    'ban_id' => $banId,
                    'karyawan_id' => $request->karyawan_id,
                    'kode_sopir' => $request->kode_karyawan,
                    'nama_sopir' => $request->nama_lengkap,
                    'kategori' => 'Pengambilan Deposit',
                    'sub_total' => str_replace('.', '', $request->sub_totals),
                    'nominal' => str_replace('.', '', $request->saldo_keluar),
                    'saldo_keluar' => $request->saldo_keluar,
                    'keterangan' => $request->keterangans,
                    'sisa_saldo' => str_replace('.', '', $request->sisa_saldo),
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));

            $saldoTerakhir = Saldo::latest()->first();
            $saldo = $saldoTerakhir->id;
            // Menghapus tanda titik dari nilai saldo_keluar dan mengonversi ke tipe numerik
            $saldo_keluar_numeric = (float) str_replace('.', '', $request->saldo_keluar);
            $subtotals =  $saldoTerakhir->sisa_saldo + $saldo_keluar_numeric;
            $kodepenerimaan = $this->kodepenerimaan();
            $penerimaan = Penerimaan_kaskecil::create(array_merge(
                $request->all(),
                [
                    'kode_penerimaan' => $this->kodepenerimaan(),
                    'deposit_driver_id' => $depositdriver->id,
                    'nominal' => str_replace('.', '', $request->saldo_keluar),
                    'saldo_masuk' => $request->saldo_keluar,
                    'keterangan' => $request->keterangans,
                    'sisa_saldo' => $saldoTerakhir->sisa_saldo,
                    'saldo_id' => $saldo,
                    'sub_total' => $subtotals,
                    'qr_code_penerimaan' => 'https:///javaline.id/penerimaan_kaskecil/' . $kodepenerimaan,
                    'tanggaljam' => Carbon::now('Asia/Jakarta'),
                    'jam' => $tanggal1->format('H:i:s'),
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));
        } else {
            $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
            $kendaraan->update([
                'km' => $request->km_pelepasan
            ]);

            $kendaraan = Kendaraan::findOrFail($id);
            $banId = $request->id_ban;
            $ban = Ban::find($banId);

            if (!$ban) {
                return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
            }

            $ban->update([
                'keterangan' => $request->keterangan,
                'km_pelepasan' => $request->km_pelepasan,
                'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',
            ]);
        }
        return redirect()->back()->withInput()->with('success', 'Berhasil menambahkan Pelepasan ban pada posisi Axle 3D');
    }

    public function updatepelepasan_4a(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'keterangan' => 'required',
                'km_pelepasan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pelepasan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'keterangan.required' => 'Pilih Keterangan',
                'km_pelepasan.required' => 'Masukkan km pelepasan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }
        $keterangan = $request->keterangan;
        if ($keterangan == "Pecah Klaim") {
            $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
            $kendaraan->update([
                'km' => $request->km_pelepasan,
            ]);

            $kendaraan = Kendaraan::findOrFail($id);
            $banId = $request->id_ban;
            $ban = Ban::find($banId);

            if (!$ban) {
                return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
            }

            $ban->update([
                'keterangan' => $request->keterangan,
                'km_pelepasan' => $request->km_pelepasan,
                'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',

            ]);

            $kodedepositdriver = $this->kodedepositdriver();

            $tanggal1 = Carbon::now('Asia/Jakarta');
            $format_tanggal = $tanggal1->format('d F Y');

            $tanggal = Carbon::now()->format('Y-m-d');
            $depositdriver = Deposit_driver::create(array_merge(
                $request->all(),
                [
                    'kode_deposit' => $this->kodedepositdriver(),
                    'ban_id' => $banId,
                    'karyawan_id' => $request->karyawan_id,
                    'kode_sopir' => $request->kode_karyawan,
                    'nama_sopir' => $request->nama_lengkap,
                    'kategori' => 'Pengambilan Deposit',
                    'sub_total' => str_replace('.', '', $request->sub_totals),
                    'nominal' => str_replace('.', '', $request->saldo_keluar),
                    'saldo_keluar' => $request->saldo_keluar,
                    'keterangan' => $request->keterangans,
                    'sisa_saldo' => str_replace('.', '', $request->sisa_saldo),
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));

            $saldoTerakhir = Saldo::latest()->first();
            $saldo = $saldoTerakhir->id;
            // Menghapus tanda titik dari nilai saldo_keluar dan mengonversi ke tipe numerik
            $saldo_keluar_numeric = (float) str_replace('.', '', $request->saldo_keluar);
            $subtotals =  $saldoTerakhir->sisa_saldo + $saldo_keluar_numeric;
            $kodepenerimaan = $this->kodepenerimaan();
            $penerimaan = Penerimaan_kaskecil::create(array_merge(
                $request->all(),
                [
                    'kode_penerimaan' => $this->kodepenerimaan(),
                    'deposit_driver_id' => $depositdriver->id,
                    'nominal' => str_replace('.', '', $request->saldo_keluar),
                    'saldo_masuk' => $request->saldo_keluar,
                    'keterangan' => $request->keterangans,
                    'sisa_saldo' => $saldoTerakhir->sisa_saldo,
                    'saldo_id' => $saldo,
                    'sub_total' => $subtotals,
                    'qr_code_penerimaan' => 'https:///javaline.id/penerimaan_kaskecil/' . $kodepenerimaan,
                    'tanggaljam' => Carbon::now('Asia/Jakarta'),
                    'jam' => $tanggal1->format('H:i:s'),
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));
        } else {
            $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
            $kendaraan->update([
                'km' => $request->km_pelepasan
            ]);

            $kendaraan = Kendaraan::findOrFail($id);
            $banId = $request->id_ban;
            $ban = Ban::find($banId);

            if (!$ban) {
                return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
            }

            $ban->update([
                'keterangan' => $request->keterangan,
                'km_pelepasan' => $request->km_pelepasan,
                'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',
            ]);
        }
        return redirect()->back()->withInput()->with('success', 'Berhasil menambahkan Pelepasan ban pada posisi Axle 4A');
    }

    public function updatepelepasan_4b(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'keterangan' => 'required',
                'km_pelepasan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pelepasan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'keterangan.required' => 'Pilih Keterangan',
                'km_pelepasan.required' => 'Masukkan km pelepasan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $keterangan = $request->keterangan;
        if ($keterangan == "Pecah Klaim") {
            $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
            $kendaraan->update([
                'km' => $request->km_pelepasan,
            ]);

            $kendaraan = Kendaraan::findOrFail($id);
            $banId = $request->id_ban;
            $ban = Ban::find($banId);

            if (!$ban) {
                return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
            }

            $ban->update([
                'keterangan' => $request->keterangan,
                'km_pelepasan' => $request->km_pelepasan,
                'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',

            ]);

            $kodedepositdriver = $this->kodedepositdriver();

            $tanggal1 = Carbon::now('Asia/Jakarta');
            $format_tanggal = $tanggal1->format('d F Y');

            $tanggal = Carbon::now()->format('Y-m-d');
            $depositdriver = Deposit_driver::create(array_merge(
                $request->all(),
                [
                    'kode_deposit' => $this->kodedepositdriver(),
                    'ban_id' => $banId,
                    'karyawan_id' => $request->karyawan_id,
                    'kode_sopir' => $request->kode_karyawan,
                    'nama_sopir' => $request->nama_lengkap,
                    'kategori' => 'Pengambilan Deposit',
                    'sub_total' => str_replace('.', '', $request->sub_totals),
                    'nominal' => str_replace('.', '', $request->saldo_keluar),
                    'saldo_keluar' => $request->saldo_keluar,
                    'keterangan' => $request->keterangans,
                    'sisa_saldo' => str_replace('.', '', $request->sisa_saldo),
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));

            $saldoTerakhir = Saldo::latest()->first();
            $saldo = $saldoTerakhir->id;
            // Menghapus tanda titik dari nilai saldo_keluar dan mengonversi ke tipe numerik
            $saldo_keluar_numeric = (float) str_replace('.', '', $request->saldo_keluar);
            $subtotals =  $saldoTerakhir->sisa_saldo + $saldo_keluar_numeric;
            $kodepenerimaan = $this->kodepenerimaan();
            $penerimaan = Penerimaan_kaskecil::create(array_merge(
                $request->all(),
                [
                    'kode_penerimaan' => $this->kodepenerimaan(),
                    'deposit_driver_id' => $depositdriver->id,
                    'nominal' => str_replace('.', '', $request->saldo_keluar),
                    'saldo_masuk' => $request->saldo_keluar,
                    'keterangan' => $request->keterangans,
                    'sisa_saldo' => $saldoTerakhir->sisa_saldo,
                    'saldo_id' => $saldo,
                    'sub_total' => $subtotals,
                    'qr_code_penerimaan' => 'https:///javaline.id/penerimaan_kaskecil/' . $kodepenerimaan,
                    'tanggaljam' => Carbon::now('Asia/Jakarta'),
                    'jam' => $tanggal1->format('H:i:s'),
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));
        } else {
            $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
            $kendaraan->update([
                'km' => $request->km_pelepasan
            ]);

            $kendaraan = Kendaraan::findOrFail($id);
            $banId = $request->id_ban;
            $ban = Ban::find($banId);

            if (!$ban) {
                return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
            }

            $ban->update([
                'keterangan' => $request->keterangan,
                'km_pelepasan' => $request->km_pelepasan,
                'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',
            ]);
        }
        return redirect()->back()->withInput()->with('success', 'Berhasil menambahkan Pelepasan ban pada posisi Axle 4B');
    }

    public function updatepelepasan_4c(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'keterangan' => 'required',
                'km_pelepasan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pelepasan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'keterangan.required' => 'Pilih Keterangan',
                'km_pelepasan.required' => 'Masukkan km pelepasan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $keterangan = $request->keterangan;
        if ($keterangan == "Pecah Klaim") {
            $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
            $kendaraan->update([
                'km' => $request->km_pelepasan,
            ]);

            $kendaraan = Kendaraan::findOrFail($id);
            $banId = $request->id_ban;
            $ban = Ban::find($banId);

            if (!$ban) {
                return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
            }

            $ban->update([
                'keterangan' => $request->keterangan,
                'km_pelepasan' => $request->km_pelepasan,
                'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',

            ]);

            $kodedepositdriver = $this->kodedepositdriver();

            $tanggal1 = Carbon::now('Asia/Jakarta');
            $format_tanggal = $tanggal1->format('d F Y');

            $tanggal = Carbon::now()->format('Y-m-d');
            $depositdriver = Deposit_driver::create(array_merge(
                $request->all(),
                [
                    'kode_deposit' => $this->kodedepositdriver(),
                    'ban_id' => $banId,
                    'karyawan_id' => $request->karyawan_id,
                    'kode_sopir' => $request->kode_karyawan,
                    'nama_sopir' => $request->nama_lengkap,
                    'kategori' => 'Pengambilan Deposit',
                    'sub_total' => str_replace('.', '', $request->sub_totals),
                    'nominal' => str_replace('.', '', $request->saldo_keluar),
                    'saldo_keluar' => $request->saldo_keluar,
                    'keterangan' => $request->keterangans,
                    'sisa_saldo' => str_replace('.', '', $request->sisa_saldo),
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));

            $saldoTerakhir = Saldo::latest()->first();
            $saldo = $saldoTerakhir->id;
            // Menghapus tanda titik dari nilai saldo_keluar dan mengonversi ke tipe numerik
            $saldo_keluar_numeric = (float) str_replace('.', '', $request->saldo_keluar);
            $subtotals =  $saldoTerakhir->sisa_saldo + $saldo_keluar_numeric;
            $kodepenerimaan = $this->kodepenerimaan();
            $penerimaan = Penerimaan_kaskecil::create(array_merge(
                $request->all(),
                [
                    'kode_penerimaan' => $this->kodepenerimaan(),
                    'deposit_driver_id' => $depositdriver->id,
                    'nominal' => str_replace('.', '', $request->saldo_keluar),
                    'saldo_masuk' => $request->saldo_keluar,
                    'keterangan' => $request->keterangans,
                    'sisa_saldo' => $saldoTerakhir->sisa_saldo,
                    'saldo_id' => $saldo,
                    'sub_total' => $subtotals,
                    'qr_code_penerimaan' => 'https:///javaline.id/penerimaan_kaskecil/' . $kodepenerimaan,
                    'tanggaljam' => Carbon::now('Asia/Jakarta'),
                    'jam' => $tanggal1->format('H:i:s'),
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));
        } else {
            $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
            $kendaraan->update([
                'km' => $request->km_pelepasan
            ]);

            $kendaraan = Kendaraan::findOrFail($id);
            $banId = $request->id_ban;
            $ban = Ban::find($banId);

            if (!$ban) {
                return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
            }

            $ban->update([
                'keterangan' => $request->keterangan,
                'km_pelepasan' => $request->km_pelepasan,
                'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',
            ]);
        }
        return redirect()->back()->withInput()->with('success', 'Berhasil menambahkan Pelepasan ban pada posisi Axle 4C');
    }

    public function updatepelepasan_4d(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'keterangan' => 'required',
                'km_pelepasan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pelepasan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'keterangan.required' => 'Pilih Keterangan',
                'km_pelepasan.required' => 'Masukkan km pelepasan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $keterangan = $request->keterangan;
        if ($keterangan == "Pecah Klaim") {
            $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
            $kendaraan->update([
                'km' => $request->km_pelepasan,
            ]);

            $kendaraan = Kendaraan::findOrFail($id);
            $banId = $request->id_ban;
            $ban = Ban::find($banId);

            if (!$ban) {
                return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
            }

            $ban->update([
                'keterangan' => $request->keterangan,
                'km_pelepasan' => $request->km_pelepasan,
                'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',

            ]);

            $kodedepositdriver = $this->kodedepositdriver();

            $tanggal1 = Carbon::now('Asia/Jakarta');
            $format_tanggal = $tanggal1->format('d F Y');

            $tanggal = Carbon::now()->format('Y-m-d');
            $depositdriver = Deposit_driver::create(array_merge(
                $request->all(),
                [
                    'kode_deposit' => $this->kodedepositdriver(),
                    'ban_id' => $banId,
                    'karyawan_id' => $request->karyawan_id,
                    'kode_sopir' => $request->kode_karyawan,
                    'nama_sopir' => $request->nama_lengkap,
                    'kategori' => 'Pengambilan Deposit',
                    'sub_total' => str_replace('.', '', $request->sub_totals),
                    'nominal' => str_replace('.', '', $request->saldo_keluar),
                    'saldo_keluar' => $request->saldo_keluar,
                    'keterangan' => $request->keterangans,
                    'sisa_saldo' => str_replace('.', '', $request->sisa_saldo),
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));

            $saldoTerakhir = Saldo::latest()->first();
            $saldo = $saldoTerakhir->id;
            // Menghapus tanda titik dari nilai saldo_keluar dan mengonversi ke tipe numerik
            $saldo_keluar_numeric = (float) str_replace('.', '', $request->saldo_keluar);
            $subtotals =  $saldoTerakhir->sisa_saldo + $saldo_keluar_numeric;
            $kodepenerimaan = $this->kodepenerimaan();
            $penerimaan = Penerimaan_kaskecil::create(array_merge(
                $request->all(),
                [
                    'kode_penerimaan' => $this->kodepenerimaan(),
                    'deposit_driver_id' => $depositdriver->id,
                    'nominal' => str_replace('.', '', $request->saldo_keluar),
                    'saldo_masuk' => $request->saldo_keluar,
                    'keterangan' => $request->keterangans,
                    'sisa_saldo' => $saldoTerakhir->sisa_saldo,
                    'saldo_id' => $saldo,
                    'sub_total' => $subtotals,
                    'qr_code_penerimaan' => 'https:///javaline.id/penerimaan_kaskecil/' . $kodepenerimaan,
                    'tanggaljam' => Carbon::now('Asia/Jakarta'),
                    'jam' => $tanggal1->format('H:i:s'),
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));
        } else {
            $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
            $kendaraan->update([
                'km' => $request->km_pelepasan
            ]);

            $kendaraan = Kendaraan::findOrFail($id);
            $banId = $request->id_ban;
            $ban = Ban::find($banId);

            if (!$ban) {
                return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
            }

            $ban->update([
                'keterangan' => $request->keterangan,
                'km_pelepasan' => $request->km_pelepasan,
                'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',
            ]);
        }
        return redirect()->back()->withInput()->with('success', 'Berhasil menambahkan Pelepasan ban pada posisi Axle 4D');
    }

    public function updatepelepasan_5a(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'keterangan' => 'required',
                'km_pelepasan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pelepasan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'keterangan.required' => 'Pilih Keterangan',
                'km_pelepasan.required' => 'Masukkan km pelepasan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }
        $keterangan = $request->keterangan;
        if ($keterangan == "Pecah Klaim") {
            $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
            $kendaraan->update([
                'km' => $request->km_pelepasan,
            ]);

            $kendaraan = Kendaraan::findOrFail($id);
            $banId = $request->id_ban;
            $ban = Ban::find($banId);

            if (!$ban) {
                return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
            }

            $ban->update([
                'keterangan' => $request->keterangan,
                'km_pelepasan' => $request->km_pelepasan,
                'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',

            ]);

            $kodedepositdriver = $this->kodedepositdriver();

            $tanggal1 = Carbon::now('Asia/Jakarta');
            $format_tanggal = $tanggal1->format('d F Y');

            $tanggal = Carbon::now()->format('Y-m-d');
            $depositdriver = Deposit_driver::create(array_merge(
                $request->all(),
                [
                    'kode_deposit' => $this->kodedepositdriver(),
                    'ban_id' => $banId,
                    'karyawan_id' => $request->karyawan_id,
                    'kode_sopir' => $request->kode_karyawan,
                    'nama_sopir' => $request->nama_lengkap,
                    'kategori' => 'Pengambilan Deposit',
                    'sub_total' => str_replace('.', '', $request->sub_totals),
                    'nominal' => str_replace('.', '', $request->saldo_keluar),
                    'saldo_keluar' => $request->saldo_keluar,
                    'keterangan' => $request->keterangans,
                    'sisa_saldo' => str_replace('.', '', $request->sisa_saldo),
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));

            $saldoTerakhir = Saldo::latest()->first();
            $saldo = $saldoTerakhir->id;
            // Menghapus tanda titik dari nilai saldo_keluar dan mengonversi ke tipe numerik
            $saldo_keluar_numeric = (float) str_replace('.', '', $request->saldo_keluar);
            $subtotals =  $saldoTerakhir->sisa_saldo + $saldo_keluar_numeric;
            $kodepenerimaan = $this->kodepenerimaan();
            $penerimaan = Penerimaan_kaskecil::create(array_merge(
                $request->all(),
                [
                    'kode_penerimaan' => $this->kodepenerimaan(),
                    'deposit_driver_id' => $depositdriver->id,
                    'nominal' => str_replace('.', '', $request->saldo_keluar),
                    'saldo_masuk' => $request->saldo_keluar,
                    'keterangan' => $request->keterangans,
                    'sisa_saldo' => $saldoTerakhir->sisa_saldo,
                    'saldo_id' => $saldo,
                    'sub_total' => $subtotals,
                    'qr_code_penerimaan' => 'https:///javaline.id/penerimaan_kaskecil/' . $kodepenerimaan,
                    'tanggaljam' => Carbon::now('Asia/Jakarta'),
                    'jam' => $tanggal1->format('H:i:s'),
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));
        } else {
            $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
            $kendaraan->update([
                'km' => $request->km_pelepasan
            ]);

            $kendaraan = Kendaraan::findOrFail($id);
            $banId = $request->id_ban;
            $ban = Ban::find($banId);

            if (!$ban) {
                return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
            }

            $ban->update([
                'keterangan' => $request->keterangan,
                'km_pelepasan' => $request->km_pelepasan,
                'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',
            ]);
        }
        return redirect()->back()->withInput()->with('success', 'Berhasil menambahkan Pelepasan ban pada posisi Axle 5A');
    }

    public function updatepelepasan_5b(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'keterangan' => 'required',
                'km_pelepasan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pelepasan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'keterangan.required' => 'Pilih Keterangan',
                'km_pelepasan.required' => 'Masukkan km pelepasan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }
        $keterangan = $request->keterangan;
        if ($keterangan == "Pecah Klaim") {
            $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
            $kendaraan->update([
                'km' => $request->km_pelepasan,
            ]);

            $kendaraan = Kendaraan::findOrFail($id);
            $banId = $request->id_ban;
            $ban = Ban::find($banId);

            if (!$ban) {
                return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
            }

            $ban->update([
                'keterangan' => $request->keterangan,
                'km_pelepasan' => $request->km_pelepasan,
                'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',

            ]);

            $kodedepositdriver = $this->kodedepositdriver();

            $tanggal1 = Carbon::now('Asia/Jakarta');
            $format_tanggal = $tanggal1->format('d F Y');

            $tanggal = Carbon::now()->format('Y-m-d');
            $depositdriver = Deposit_driver::create(array_merge(
                $request->all(),
                [
                    'kode_deposit' => $this->kodedepositdriver(),
                    'ban_id' => $banId,
                    'karyawan_id' => $request->karyawan_id,
                    'kode_sopir' => $request->kode_karyawan,
                    'nama_sopir' => $request->nama_lengkap,
                    'kategori' => 'Pengambilan Deposit',
                    'sub_total' => str_replace('.', '', $request->sub_totals),
                    'nominal' => str_replace('.', '', $request->saldo_keluar),
                    'saldo_keluar' => $request->saldo_keluar,
                    'keterangan' => $request->keterangans,
                    'sisa_saldo' => str_replace('.', '', $request->sisa_saldo),
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));

            $saldoTerakhir = Saldo::latest()->first();
            $saldo = $saldoTerakhir->id;
            // Menghapus tanda titik dari nilai saldo_keluar dan mengonversi ke tipe numerik
            $saldo_keluar_numeric = (float) str_replace('.', '', $request->saldo_keluar);
            $subtotals =  $saldoTerakhir->sisa_saldo + $saldo_keluar_numeric;
            $kodepenerimaan = $this->kodepenerimaan();
            $penerimaan = Penerimaan_kaskecil::create(array_merge(
                $request->all(),
                [
                    'kode_penerimaan' => $this->kodepenerimaan(),
                    'deposit_driver_id' => $depositdriver->id,
                    'nominal' => str_replace('.', '', $request->saldo_keluar),
                    'saldo_masuk' => $request->saldo_keluar,
                    'keterangan' => $request->keterangans,
                    'sisa_saldo' => $saldoTerakhir->sisa_saldo,
                    'saldo_id' => $saldo,
                    'sub_total' => $subtotals,
                    'qr_code_penerimaan' => 'https:///javaline.id/penerimaan_kaskecil/' . $kodepenerimaan,
                    'tanggaljam' => Carbon::now('Asia/Jakarta'),
                    'jam' => $tanggal1->format('H:i:s'),
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));
        } else {
            $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
            $kendaraan->update([
                'km' => $request->km_pelepasan
            ]);

            $kendaraan = Kendaraan::findOrFail($id);
            $banId = $request->id_ban;
            $ban = Ban::find($banId);

            if (!$ban) {
                return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
            }

            $ban->update([
                'keterangan' => $request->keterangan,
                'km_pelepasan' => $request->km_pelepasan,
                'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',
            ]);
        }
        return redirect()->back()->withInput()->with('success', 'Berhasil menambahkan Pelepasan ban pada posisi Axle 5B');
    }

    public function updatepelepasan_5c(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'keterangan' => 'required',
                'km_pelepasan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pelepasan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'keterangan.required' => 'Pilih Keterangan',
                'km_pelepasan.required' => 'Masukkan km pelepasan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }
        $keterangan = $request->keterangan;
        if ($keterangan == "Pecah Klaim") {
            $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
            $kendaraan->update([
                'km' => $request->km_pelepasan,
            ]);

            $kendaraan = Kendaraan::findOrFail($id);
            $banId = $request->id_ban;
            $ban = Ban::find($banId);

            if (!$ban) {
                return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
            }

            $ban->update([
                'keterangan' => $request->keterangan,
                'km_pelepasan' => $request->km_pelepasan,
                'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',

            ]);

            $kodedepositdriver = $this->kodedepositdriver();

            $tanggal1 = Carbon::now('Asia/Jakarta');
            $format_tanggal = $tanggal1->format('d F Y');

            $tanggal = Carbon::now()->format('Y-m-d');
            $depositdriver = Deposit_driver::create(array_merge(
                $request->all(),
                [
                    'kode_deposit' => $this->kodedepositdriver(),
                    'ban_id' => $banId,
                    'karyawan_id' => $request->karyawan_id,
                    'kode_sopir' => $request->kode_karyawan,
                    'nama_sopir' => $request->nama_lengkap,
                    'kategori' => 'Pengambilan Deposit',
                    'sub_total' => str_replace('.', '', $request->sub_totals),
                    'nominal' => str_replace('.', '', $request->saldo_keluar),
                    'saldo_keluar' => $request->saldo_keluar,
                    'keterangan' => $request->keterangans,
                    'sisa_saldo' => str_replace('.', '', $request->sisa_saldo),
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));

            $saldoTerakhir = Saldo::latest()->first();
            $saldo = $saldoTerakhir->id;
            // Menghapus tanda titik dari nilai saldo_keluar dan mengonversi ke tipe numerik
            $saldo_keluar_numeric = (float) str_replace('.', '', $request->saldo_keluar);
            $subtotals =  $saldoTerakhir->sisa_saldo + $saldo_keluar_numeric;
            $kodepenerimaan = $this->kodepenerimaan();
            $penerimaan = Penerimaan_kaskecil::create(array_merge(
                $request->all(),
                [
                    'kode_penerimaan' => $this->kodepenerimaan(),
                    'deposit_driver_id' => $depositdriver->id,
                    'nominal' => str_replace('.', '', $request->saldo_keluar),
                    'saldo_masuk' => $request->saldo_keluar,
                    'keterangan' => $request->keterangans,
                    'sisa_saldo' => $saldoTerakhir->sisa_saldo,
                    'saldo_id' => $saldo,
                    'sub_total' => $subtotals,
                    'qr_code_penerimaan' => 'https:///javaline.id/penerimaan_kaskecil/' . $kodepenerimaan,
                    'tanggaljam' => Carbon::now('Asia/Jakarta'),
                    'jam' => $tanggal1->format('H:i:s'),
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));
        } else {
            $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
            $kendaraan->update([
                'km' => $request->km_pelepasan
            ]);

            $kendaraan = Kendaraan::findOrFail($id);
            $banId = $request->id_ban;
            $ban = Ban::find($banId);

            if (!$ban) {
                return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
            }

            $ban->update([
                'keterangan' => $request->keterangan,
                'km_pelepasan' => $request->km_pelepasan,
                'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',
            ]);
        }
        return redirect()->back()->withInput()->with('success', 'Berhasil menambahkan Pelepasan ban pada posisi Axle 5C');
    }

    public function updatepelepasan_5d(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'keterangan' => 'required',
                'km_pelepasan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pelepasan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'keterangan.required' => 'Pilih Keterangan',
                'km_pelepasan.required' => 'Masukkan km pelepasan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }
        $keterangan = $request->keterangan;
        if ($keterangan == "Pecah Klaim") {
            $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
            $kendaraan->update([
                'km' => $request->km_pelepasan,
            ]);

            $kendaraan = Kendaraan::findOrFail($id);
            $banId = $request->id_ban;
            $ban = Ban::find($banId);

            if (!$ban) {
                return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
            }

            $ban->update([
                'keterangan' => $request->keterangan,
                'km_pelepasan' => $request->km_pelepasan,
                'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',

            ]);

            $kodedepositdriver = $this->kodedepositdriver();

            $tanggal1 = Carbon::now('Asia/Jakarta');
            $format_tanggal = $tanggal1->format('d F Y');

            $tanggal = Carbon::now()->format('Y-m-d');
            $depositdriver = Deposit_driver::create(array_merge(
                $request->all(),
                [
                    'kode_deposit' => $this->kodedepositdriver(),
                    'ban_id' => $banId,
                    'karyawan_id' => $request->karyawan_id,
                    'kode_sopir' => $request->kode_karyawan,
                    'nama_sopir' => $request->nama_lengkap,
                    'kategori' => 'Pengambilan Deposit',
                    'sub_total' => str_replace('.', '', $request->sub_totals),
                    'nominal' => str_replace('.', '', $request->saldo_keluar),
                    'saldo_keluar' => $request->saldo_keluar,
                    'keterangan' => $request->keterangans,
                    'sisa_saldo' => str_replace('.', '', $request->sisa_saldo),
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));

            $saldoTerakhir = Saldo::latest()->first();
            $saldo = $saldoTerakhir->id;
            // Menghapus tanda titik dari nilai saldo_keluar dan mengonversi ke tipe numerik
            $saldo_keluar_numeric = (float) str_replace('.', '', $request->saldo_keluar);
            $subtotals =  $saldoTerakhir->sisa_saldo + $saldo_keluar_numeric;
            $kodepenerimaan = $this->kodepenerimaan();
            $penerimaan = Penerimaan_kaskecil::create(array_merge(
                $request->all(),
                [
                    'kode_penerimaan' => $this->kodepenerimaan(),
                    'deposit_driver_id' => $depositdriver->id,
                    'nominal' => str_replace('.', '', $request->saldo_keluar),
                    'saldo_masuk' => $request->saldo_keluar,
                    'keterangan' => $request->keterangans,
                    'sisa_saldo' => $saldoTerakhir->sisa_saldo,
                    'saldo_id' => $saldo,
                    'sub_total' => $subtotals,
                    'qr_code_penerimaan' => 'https:///javaline.id/penerimaan_kaskecil/' . $kodepenerimaan,
                    'tanggaljam' => Carbon::now('Asia/Jakarta'),
                    'jam' => $tanggal1->format('H:i:s'),
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));
        } else {
            $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
            $kendaraan->update([
                'km' => $request->km_pelepasan
            ]);

            $kendaraan = Kendaraan::findOrFail($id);
            $banId = $request->id_ban;
            $ban = Ban::find($banId);

            if (!$ban) {
                return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
            }

            $ban->update([
                'keterangan' => $request->keterangan,
                'km_pelepasan' => $request->km_pelepasan,
                'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',
            ]);
        }
        return redirect()->back()->withInput()->with('success', 'Berhasil menambahkan Pelepasan ban pada posisi Axle 5D');
    }

    public function updatepelepasan_6a(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'keterangan' => 'required',
                'km_pelepasan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pelepasan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'keterangan.required' => 'Pilih Keterangan',
                'km_pelepasan.required' => 'Masukkan km pelepasan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }
        $keterangan = $request->keterangan;
        if ($keterangan == "Pecah Klaim") {
            $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
            $kendaraan->update([
                'km' => $request->km_pelepasan,
            ]);

            $kendaraan = Kendaraan::findOrFail($id);
            $banId = $request->id_ban;
            $ban = Ban::find($banId);

            if (!$ban) {
                return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
            }

            $ban->update([
                'keterangan' => $request->keterangan,
                'km_pelepasan' => $request->km_pelepasan,
                'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',

            ]);

            $kodedepositdriver = $this->kodedepositdriver();

            $tanggal1 = Carbon::now('Asia/Jakarta');
            $format_tanggal = $tanggal1->format('d F Y');

            $tanggal = Carbon::now()->format('Y-m-d');
            $depositdriver = Deposit_driver::create(array_merge(
                $request->all(),
                [
                    'kode_deposit' => $this->kodedepositdriver(),
                    'ban_id' => $banId,
                    'karyawan_id' => $request->karyawan_id,
                    'kode_sopir' => $request->kode_karyawan,
                    'nama_sopir' => $request->nama_lengkap,
                    'kategori' => 'Pengambilan Deposit',
                    'sub_total' => str_replace('.', '', $request->sub_totals),
                    'nominal' => str_replace('.', '', $request->saldo_keluar),
                    'saldo_keluar' => $request->saldo_keluar,
                    'keterangan' => $request->keterangans,
                    'sisa_saldo' => str_replace('.', '', $request->sisa_saldo),
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));

            $saldoTerakhir = Saldo::latest()->first();
            $saldo = $saldoTerakhir->id;
            // Menghapus tanda titik dari nilai saldo_keluar dan mengonversi ke tipe numerik
            $saldo_keluar_numeric = (float) str_replace('.', '', $request->saldo_keluar);
            $subtotals =  $saldoTerakhir->sisa_saldo + $saldo_keluar_numeric;
            $kodepenerimaan = $this->kodepenerimaan();
            $penerimaan = Penerimaan_kaskecil::create(array_merge(
                $request->all(),
                [
                    'kode_penerimaan' => $this->kodepenerimaan(),
                    'deposit_driver_id' => $depositdriver->id,
                    'nominal' => str_replace('.', '', $request->saldo_keluar),
                    'saldo_masuk' => $request->saldo_keluar,
                    'keterangan' => $request->keterangans,
                    'sisa_saldo' => $saldoTerakhir->sisa_saldo,
                    'saldo_id' => $saldo,
                    'sub_total' => $subtotals,
                    'qr_code_penerimaan' => 'https:///javaline.id/penerimaan_kaskecil/' . $kodepenerimaan,
                    'tanggaljam' => Carbon::now('Asia/Jakarta'),
                    'jam' => $tanggal1->format('H:i:s'),
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));
        } else {
            $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
            $kendaraan->update([
                'km' => $request->km_pelepasan
            ]);

            $kendaraan = Kendaraan::findOrFail($id);
            $banId = $request->id_ban;
            $ban = Ban::find($banId);

            if (!$ban) {
                return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
            }

            $ban->update([
                'keterangan' => $request->keterangan,
                'km_pelepasan' => $request->km_pelepasan,
                'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',
            ]);
        }
        return redirect()->back()->withInput()->with('success', 'Berhasil menambahkan Pelepasan ban pada posisi Axle 6A');
    }

    public function updatepelepasan_6b(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'keterangan' => 'required',
                'km_pelepasan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pelepasan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'keterangan.required' => 'Pilih Keterangan',
                'km_pelepasan.required' => 'Masukkan km pelepasan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }
        $keterangan = $request->keterangan;
        if ($keterangan == "Pecah Klaim") {
            $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
            $kendaraan->update([
                'km' => $request->km_pelepasan,
            ]);

            $kendaraan = Kendaraan::findOrFail($id);
            $banId = $request->id_ban;
            $ban = Ban::find($banId);

            if (!$ban) {
                return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
            }

            $ban->update([
                'keterangan' => $request->keterangan,
                'km_pelepasan' => $request->km_pelepasan,
                'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',

            ]);

            $kodedepositdriver = $this->kodedepositdriver();

            $tanggal1 = Carbon::now('Asia/Jakarta');
            $format_tanggal = $tanggal1->format('d F Y');

            $tanggal = Carbon::now()->format('Y-m-d');
            $depositdriver = Deposit_driver::create(array_merge(
                $request->all(),
                [
                    'kode_deposit' => $this->kodedepositdriver(),
                    'ban_id' => $banId,
                    'karyawan_id' => $request->karyawan_id,
                    'kode_sopir' => $request->kode_karyawan,
                    'nama_sopir' => $request->nama_lengkap,
                    'kategori' => 'Pengambilan Deposit',
                    'sub_total' => str_replace('.', '', $request->sub_totals),
                    'nominal' => str_replace('.', '', $request->saldo_keluar),
                    'saldo_keluar' => $request->saldo_keluar,
                    'keterangan' => $request->keterangans,
                    'sisa_saldo' => str_replace('.', '', $request->sisa_saldo),
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));

            $saldoTerakhir = Saldo::latest()->first();
            $saldo = $saldoTerakhir->id;
            // Menghapus tanda titik dari nilai saldo_keluar dan mengonversi ke tipe numerik
            $saldo_keluar_numeric = (float) str_replace('.', '', $request->saldo_keluar);
            $subtotals =  $saldoTerakhir->sisa_saldo + $saldo_keluar_numeric;
            $kodepenerimaan = $this->kodepenerimaan();
            $penerimaan = Penerimaan_kaskecil::create(array_merge(
                $request->all(),
                [
                    'kode_penerimaan' => $this->kodepenerimaan(),
                    'deposit_driver_id' => $depositdriver->id,
                    'nominal' => str_replace('.', '', $request->saldo_keluar),
                    'saldo_masuk' => $request->saldo_keluar,
                    'keterangan' => $request->keterangans,
                    'sisa_saldo' => $saldoTerakhir->sisa_saldo,
                    'saldo_id' => $saldo,
                    'sub_total' => $subtotals,
                    'qr_code_penerimaan' => 'https:///javaline.id/penerimaan_kaskecil/' . $kodepenerimaan,
                    'tanggaljam' => Carbon::now('Asia/Jakarta'),
                    'jam' => $tanggal1->format('H:i:s'),
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));
        } else {
            $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
            $kendaraan->update([
                'km' => $request->km_pelepasan
            ]);

            $kendaraan = Kendaraan::findOrFail($id);
            $banId = $request->id_ban;
            $ban = Ban::find($banId);

            if (!$ban) {
                return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
            }

            $ban->update([
                'keterangan' => $request->keterangan,
                'km_pelepasan' => $request->km_pelepasan,
                'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',
            ]);
        }
        return redirect()->back()->withInput()->with('success', 'Berhasil menambahkan Pelepasan ban pada posisi Axle 6B');
    }

    public function updatepelepasan_6c(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'keterangan' => 'required',
                'km_pelepasan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pelepasan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'keterangan.required' => 'Pilih Keterangan',
                'km_pelepasan.required' => 'Masukkan km pelepasan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }
        $keterangan = $request->keterangan;
        if ($keterangan == "Pecah Klaim") {
            $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
            $kendaraan->update([
                'km' => $request->km_pelepasan,
            ]);

            $kendaraan = Kendaraan::findOrFail($id);
            $banId = $request->id_ban;
            $ban = Ban::find($banId);

            if (!$ban) {
                return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
            }

            $ban->update([
                'keterangan' => $request->keterangan,
                'km_pelepasan' => $request->km_pelepasan,
                'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',

            ]);

            $kodedepositdriver = $this->kodedepositdriver();

            $tanggal1 = Carbon::now('Asia/Jakarta');
            $format_tanggal = $tanggal1->format('d F Y');

            $tanggal = Carbon::now()->format('Y-m-d');
            $depositdriver = Deposit_driver::create(array_merge(
                $request->all(),
                [
                    'kode_deposit' => $this->kodedepositdriver(),
                    'ban_id' => $banId,
                    'karyawan_id' => $request->karyawan_id,
                    'kode_sopir' => $request->kode_karyawan,
                    'nama_sopir' => $request->nama_lengkap,
                    'kategori' => 'Pengambilan Deposit',
                    'sub_total' => str_replace('.', '', $request->sub_totals),
                    'nominal' => str_replace('.', '', $request->saldo_keluar),
                    'saldo_keluar' => $request->saldo_keluar,
                    'keterangan' => $request->keterangans,
                    'sisa_saldo' => str_replace('.', '', $request->sisa_saldo),
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));

            $saldoTerakhir = Saldo::latest()->first();
            $saldo = $saldoTerakhir->id;
            // Menghapus tanda titik dari nilai saldo_keluar dan mengonversi ke tipe numerik
            $saldo_keluar_numeric = (float) str_replace('.', '', $request->saldo_keluar);
            $subtotals =  $saldoTerakhir->sisa_saldo + $saldo_keluar_numeric;
            $kodepenerimaan = $this->kodepenerimaan();
            $penerimaan = Penerimaan_kaskecil::create(array_merge(
                $request->all(),
                [
                    'kode_penerimaan' => $this->kodepenerimaan(),
                    'deposit_driver_id' => $depositdriver->id,
                    'nominal' => str_replace('.', '', $request->saldo_keluar),
                    'saldo_masuk' => $request->saldo_keluar,
                    'keterangan' => $request->keterangans,
                    'sisa_saldo' => $saldoTerakhir->sisa_saldo,
                    'saldo_id' => $saldo,
                    'sub_total' => $subtotals,
                    'qr_code_penerimaan' => 'https:///javaline.id/penerimaan_kaskecil/' . $kodepenerimaan,
                    'tanggaljam' => Carbon::now('Asia/Jakarta'),
                    'jam' => $tanggal1->format('H:i:s'),
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));
        } else {
            $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
            $kendaraan->update([
                'km' => $request->km_pelepasan
            ]);

            $kendaraan = Kendaraan::findOrFail($id);
            $banId = $request->id_ban;
            $ban = Ban::find($banId);

            if (!$ban) {
                return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
            }

            $ban->update([
                'keterangan' => $request->keterangan,
                'km_pelepasan' => $request->km_pelepasan,
                'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',
            ]);
        }
        return redirect()->back()->withInput()->with('success', 'Berhasil menambahkan Pelepasan ban pada posisi Axle 6C');
    }

    public function updatepelepasan_6d(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'keterangan' => 'required',
                'km_pelepasan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pelepasan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'keterangan.required' => 'Pilih Keterangan',
                'km_pelepasan.required' => 'Masukkan km pelepasan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }
        $keterangan = $request->keterangan;
        if ($keterangan == "Pecah Klaim") {
            $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
            $kendaraan->update([
                'km' => $request->km_pelepasan,
            ]);

            $kendaraan = Kendaraan::findOrFail($id);
            $banId = $request->id_ban;
            $ban = Ban::find($banId);

            if (!$ban) {
                return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
            }

            $ban->update([
                'keterangan' => $request->keterangan,
                'km_pelepasan' => $request->km_pelepasan,
                'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',

            ]);

            $kodedepositdriver = $this->kodedepositdriver();

            $tanggal1 = Carbon::now('Asia/Jakarta');
            $format_tanggal = $tanggal1->format('d F Y');

            $tanggal = Carbon::now()->format('Y-m-d');
            $depositdriver = Deposit_driver::create(array_merge(
                $request->all(),
                [
                    'kode_deposit' => $this->kodedepositdriver(),
                    'ban_id' => $banId,
                    'karyawan_id' => $request->karyawan_id,
                    'kode_sopir' => $request->kode_karyawan,
                    'nama_sopir' => $request->nama_lengkap,
                    'kategori' => 'Pengambilan Deposit',
                    'sub_total' => str_replace('.', '', $request->sub_totals),
                    'nominal' => str_replace('.', '', $request->saldo_keluar),
                    'saldo_keluar' => $request->saldo_keluar,
                    'keterangan' => $request->keterangans,
                    'sisa_saldo' => str_replace('.', '', $request->sisa_saldo),
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));

            $saldoTerakhir = Saldo::latest()->first();
            $saldo = $saldoTerakhir->id;
            // Menghapus tanda titik dari nilai saldo_keluar dan mengonversi ke tipe numerik
            $saldo_keluar_numeric = (float) str_replace('.', '', $request->saldo_keluar);
            $subtotals =  $saldoTerakhir->sisa_saldo + $saldo_keluar_numeric;
            $kodepenerimaan = $this->kodepenerimaan();
            $penerimaan = Penerimaan_kaskecil::create(array_merge(
                $request->all(),
                [
                    'kode_penerimaan' => $this->kodepenerimaan(),
                    'deposit_driver_id' => $depositdriver->id,
                    'nominal' => str_replace('.', '', $request->saldo_keluar),
                    'saldo_masuk' => $request->saldo_keluar,
                    'keterangan' => $request->keterangans,
                    'sisa_saldo' => $saldoTerakhir->sisa_saldo,
                    'saldo_id' => $saldo,
                    'sub_total' => $subtotals,
                    'qr_code_penerimaan' => 'https:///javaline.id/penerimaan_kaskecil/' . $kodepenerimaan,
                    'tanggaljam' => Carbon::now('Asia/Jakarta'),
                    'jam' => $tanggal1->format('H:i:s'),
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));
        } else {
            $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
            $kendaraan->update([
                'km' => $request->km_pelepasan
            ]);

            $kendaraan = Kendaraan::findOrFail($id);
            $banId = $request->id_ban;
            $ban = Ban::find($banId);

            if (!$ban) {
                return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
            }

            $ban->update([
                'keterangan' => $request->keterangan,
                'km_pelepasan' => $request->km_pelepasan,
                'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',
            ]);
        }
        return redirect()->back()->withInput()->with('success', 'Berhasil menambahkan Pelepasan ban pada posisi Axle 6D');
    }

    public function kodedepositdriver()
    {
        $lastBarang = Deposit_driver::latest()->first();
        if (!$lastBarang) {
            $num = 1;
        } else {
            $lastCode = $lastBarang->kode_deposit;
            $num = (int) substr($lastCode, strlen('FD')) + 1;
        }
        $formattedNum = sprintf("%06s", $num);
        $prefix = 'FD';
        $newCode = $prefix . $formattedNum;
        return $newCode;
    }

    public function kodepenerimaan()
    {
        $lastBarang = Penerimaan_kaskecil::latest()->first();
        if (!$lastBarang) {
            $num = 1;
        } else {
            $lastCode = $lastBarang->kode_penerimaan;
            $num = (int) substr($lastCode, strlen('FK')) + 1;
        }
        $formattedNum = sprintf("%06s", $num);
        $prefix = 'FK';
        $newCode = $prefix . $formattedNum;
        return $newCode;
    }
}