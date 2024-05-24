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
use App\Models\Detail_ban;
use App\Models\Karyawan;
use App\Models\Klaim_ban;
use App\Models\Penerimaan_kaskecil;
use App\Models\Saldo;
use App\Models\Km_ban;
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

        $bans = Ban::where('kendaraan_id', $id)
            ->where('status', 'aktif')
            ->whereNull('target_km_ban')
            ->get();

        foreach ($bans as $ban) {
            $posisi_ban = $ban->posisi_ban;
            $km_pemasangan = $ban->km_pemasangan;

            // Tetapkan nilai target_km berdasarkan posisi_ban
            if ($posisi_ban == '1A' || $posisi_ban == '1B') {
                $target_km = ($km_pemasangan !== null) ? $km_pemasangan + 100000 : null;
            } else {
                $target_km = ($km_pemasangan !== null) ? $km_pemasangan + 80000 : null;
            }

            // Update baris Ban dengan nilai target_km_ban yang baru
            $ban->update([
                'target_km_ban' => $target_km,
            ]);
        }

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
            $bans = Detail_ban::where('pelepasan_ban_id', $id)->get();

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

        $klaim_ban = Klaim_ban::where('ban_id', $id)->first();
        if ($klaim_ban) {
            // Hapus deposit_driver
            $klaim_ban->delete();
        }

        $umurbans = Km_ban::where(['ban_id' => $id, 'status' => 'non aktif sementara'])
            ->orderBy('created_at', 'desc')
            ->first();

        if ($umurbans) {
            // Hapus deposit_driver
            $umurbans->delete();
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

        $pelepasan_ban = Pelepasan_ban::create([
            'user_id' => auth()->user()->id,
            'kode_pelepasan' => $this->kode(),
            'kendaraan_id' => $kendaraans->id,
            'tanggal' => $format_tanggal,
            'tanggal_awal' => $tanggal,
            'status' => 'posting',
            'status_notif' => false,

        ]);
        $pelepasanId = $pelepasan_ban->id;


        // Ambil semua Ban yang memenuhi kriteria
        $bans = Ban::where([
            ['kendaraan_id', $id],
            ['keterangan', 'Stok'],
            ['status', 'non aktif sementara']
        ])->get();

        // Loop melalui setiap Ban dan update dengan jumlah_km dari Km_ban
        foreach ($bans as $ban) {
            // Ambil nilai jumlah_km terbaru dari Km_ban berdasarkan ban_id
            $jumlahKm = Km_ban::where('ban_id', $ban->id)
                ->where('status', 'digunakan')
                ->latest()
                ->value('umur_ban') ?? 0;

            // Ambil semua data km_ban yang diurutkan berdasarkan waktu atau ID
            $kmBanRecords = Km_ban::where('ban_id', $ban->id)
            ->orderBy('created_at', 'desc')
            ->get();

            // Ambil umur_ban terakhir kedua
            $umurBanTerakhirKedua = $kmBanRecords->skip(1)->first();
            $kmUmr = $umurBanTerakhirKedua ? $umurBanTerakhirKedua->umur_ban : 0;

            // Update Ban dengan nilai jumlah_km
            $ban->update([
                'status' => 'stok',
                'status_pelepasan' => 'true',
                'km_umur' => $kmUmr,
                'pelepasan_ban_id' => $pelepasanId,
                'jumlah_km' => $jumlahKm + ($ban->km_terpakai ?? 0)
            ]);

            // Duplicate ban to Detail_ban
            $detailBanData = $ban->toArray();
            $detailBanData['ban_id'] = $ban->id;

            Detail_ban::create($detailBanData);
        }

        $banss = Ban::where([
            ['kendaraan_id', $id],
            ['status', 'non aktif sementara']
        ])->get();

        foreach ($banss as $ban) {

            $umurBanTerakhir = Km_ban::where('ban_id', $ban->id)
                ->orderBy('created_at', 'desc')
                ->first();

            $kmUmr2 = $umurBanTerakhir ? $umurBanTerakhir->umur_ban : 0;

            $ban->update([
                'status' => 'non aktif',
                'status_pelepasan' => 'true',
                'km_umur' => $kmUmr2,
                'pelepasan_ban_id' => $pelepasanId,
            ]);
            // Duplicate ban to Detail_ban
            $detailBanData = $ban->toArray();
            $detailBanData['ban_id'] = $ban->id;

            Detail_ban::create($detailBanData);
        }

        Km_ban::where([
            ['kendaraan_id', $id],
            ['status', 'non aktif sementara']
        ])->update([
            'status' => 'digunakan',
            'pelepasan_ban_id' => $pelepasanId,
        ]);

        $kendaraan = Kendaraan::findOrFail($id);

        $bans = Detail_ban::where('pelepasan_ban_id', $pelepasanId)->get();

        return view('admin.pelepasan_ban.show', compact('bans', 'kendaraan', 'pelepasan_ban'));
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

            $kodeklaimban = $this->kodeklaimban();

            $tanggal1 = Carbon::now('Asia/Jakarta');
            $format_tanggal = $tanggal1->format('d F Y');

            $tanggal = Carbon::now()->format('Y-m-d');
            $depositdriver = Klaim_ban::create(array_merge(
                $request->all(),
                [
                    'kode_klaimban' => $this->kodeklaimban(),
                    'ban_id' => $banId,
                    'karyawan_id' => $request->karyawan_id,
                    'deposit_driver_id' => $depositdriver->id,
                    'penerimaan_kaskecil_id' => $penerimaan->id,
                    'keterangan' => $request->keterangan,
                    'harga_ban' => $ban->harga,
                    'harga_klaim' => str_replace('.', '', $request->sisa_harga),
                    'km_terpakai' => $request->km_terpakai,
                    'target_km' => $request->target_km,
                    'km_pemasangan' => $request->km_pemasangan,
                    'km_pelepasan' => $request->km_pelepasan,
                    'grand_total' => $request->grand_total,
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));
        } else if ($keterangan == "Stok") {
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
                // 'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',
            ]);

            Km_ban::create([
                'ban_id' => $banId,
                'kendaraan_id' => $request->kendaraan_id,
                'pemasangan_ban_id' => $ban->pemasangan_ban_id,
                'status' => 'non aktif sementara',
                'umur_ban' => $request->km_terpakai + ($ban->jumlah_km ?? 0),
                'pelepasan_ban_id' => null
            ]);
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

            $kodeklaimban = $this->kodeklaimban();

            $tanggal1 = Carbon::now('Asia/Jakarta');
            $format_tanggal = $tanggal1->format('d F Y');

            $tanggal = Carbon::now()->format('Y-m-d');
            $depositdriver = Klaim_ban::create(array_merge(
                $request->all(),
                [
                    'kode_klaimban' => $this->kodeklaimban(),
                    'ban_id' => $banId,
                    'karyawan_id' => $request->karyawan_id,
                    'deposit_driver_id' => $depositdriver->id,
                    'penerimaan_kaskecil_id' => $penerimaan->id,
                    'keterangan' => $request->keterangan,
                    'harga_ban' => $ban->harga,
                    'harga_klaim' => $request->sisa_harga,
                    'km_terpakai' => $request->km_terpakai,
                    'target_km' => $request->target_km,
                    'km_pemasangan' => $request->km_pemasangan,
                    'km_pelepasan' => $request->km_pelepasan,
                    'grand_total' => $request->grand_total,
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));
        } else if ($keterangan == "Stok") {
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
                // 'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',
            ]);

            Km_ban::create([
                'ban_id' => $banId,
                'kendaraan_id' => $request->kendaraan_id,
                'pemasangan_ban_id' => $ban->pemasangan_ban_id,
                'status' => 'non aktif sementara',
                'umur_ban' => $request->km_terpakai + ($ban->jumlah_km ?? 0),
                'pelepasan_ban_id' => null
            ]);
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

            $kodeklaimban = $this->kodeklaimban();

            $tanggal1 = Carbon::now('Asia/Jakarta');
            $format_tanggal = $tanggal1->format('d F Y');

            $tanggal = Carbon::now()->format('Y-m-d');
            $depositdriver = Klaim_ban::create(array_merge(
                $request->all(),
                [
                    'kode_klaimban' => $this->kodeklaimban(),
                    'ban_id' => $banId,
                    'karyawan_id' => $request->karyawan_id,
                    'deposit_driver_id' => $depositdriver->id,
                    'penerimaan_kaskecil_id' => $penerimaan->id,
                    'keterangan' => $request->keterangan,
                    'harga_ban' => $ban->harga,
                    'harga_klaim' => str_replace('.', '', $request->sisa_harga),
                    'km_terpakai' => $request->km_terpakai,
                    'target_km' => $request->target_km,
                    'km_pemasangan' => $request->km_pemasangan,
                    'km_pelepasan' => $request->km_pelepasan,
                    'grand_total' => $request->grand_total,
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));
        } else if ($keterangan == "Stok") {
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
                // 'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',
            ]);

            Km_ban::create([
                'ban_id' => $banId,
                'kendaraan_id' => $request->kendaraan_id,
                'pemasangan_ban_id' => $ban->pemasangan_ban_id,
                'status' => 'non aktif sementara',
                'umur_ban' => $request->km_terpakai + ($ban->jumlah_km ?? 0),
                'pelepasan_ban_id' => null
            ]);
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

            $kodeklaimban = $this->kodeklaimban();

            $tanggal1 = Carbon::now('Asia/Jakarta');
            $format_tanggal = $tanggal1->format('d F Y');

            $tanggal = Carbon::now()->format('Y-m-d');
            $depositdriver = Klaim_ban::create(array_merge(
                $request->all(),
                [
                    'kode_klaimban' => $this->kodeklaimban(),
                    'ban_id' => $banId,
                    'karyawan_id' => $request->karyawan_id,
                    'deposit_driver_id' => $depositdriver->id,
                    'penerimaan_kaskecil_id' => $penerimaan->id,
                    'keterangan' => $request->keterangan,
                    'harga_ban' => $ban->harga,
                    'harga_klaim' => str_replace('.', '', $request->sisa_harga),
                    'km_terpakai' => $request->km_terpakai,
                    'target_km' => $request->target_km,
                    'km_pemasangan' => $request->km_pemasangan,
                    'km_pelepasan' => $request->km_pelepasan,
                    'grand_total' => $request->grand_total,
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));
        } else if ($keterangan == "Stok") {
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
                // 'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',
            ]);

            Km_ban::create([
                'ban_id' => $banId,
                'kendaraan_id' => $request->kendaraan_id,
                'pemasangan_ban_id' => $ban->pemasangan_ban_id,
                'status' => 'non aktif sementara',
                'umur_ban' => $request->km_terpakai + ($ban->jumlah_km ?? 0),
                'pelepasan_ban_id' => null
            ]);
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

            $kodeklaimban = $this->kodeklaimban();

            $tanggal1 = Carbon::now('Asia/Jakarta');
            $format_tanggal = $tanggal1->format('d F Y');

            $tanggal = Carbon::now()->format('Y-m-d');
            $depositdriver = Klaim_ban::create(array_merge(
                $request->all(),
                [
                    'kode_klaimban' => $this->kodeklaimban(),
                    'ban_id' => $banId,
                    'karyawan_id' => $request->karyawan_id,
                    'deposit_driver_id' => $depositdriver->id,
                    'penerimaan_kaskecil_id' => $penerimaan->id,
                    'keterangan' => $request->keterangan,
                    'harga_ban' => $ban->harga,
                    'harga_klaim' => str_replace('.', '', $request->sisa_harga),
                    'km_terpakai' => $request->km_terpakai,
                    'target_km' => $request->target_km,
                    'km_pemasangan' => $request->km_pemasangan,
                    'km_pelepasan' => $request->km_pelepasan,
                    'grand_total' => $request->grand_total,
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));
        } else if ($keterangan == "Stok") {
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
                // 'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',
            ]);

            Km_ban::create([
                'ban_id' => $banId,
                'kendaraan_id' => $request->kendaraan_id,
                'pemasangan_ban_id' => $ban->pemasangan_ban_id,
                'status' => 'non aktif sementara',
                'umur_ban' => $request->km_terpakai + ($ban->jumlah_km ?? 0),
                'pelepasan_ban_id' => null
            ]);
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

            $kodeklaimban = $this->kodeklaimban();

            $tanggal1 = Carbon::now('Asia/Jakarta');
            $format_tanggal = $tanggal1->format('d F Y');

            $tanggal = Carbon::now()->format('Y-m-d');
            $depositdriver = Klaim_ban::create(array_merge(
                $request->all(),
                [
                    'kode_klaimban' => $this->kodeklaimban(),
                    'ban_id' => $banId,
                    'karyawan_id' => $request->karyawan_id,
                    'deposit_driver_id' => $depositdriver->id,
                    'penerimaan_kaskecil_id' => $penerimaan->id,
                    'keterangan' => $request->keterangan,
                    'harga_ban' => $ban->harga,
                    'harga_klaim' => str_replace('.', '', $request->sisa_harga),
                    'km_terpakai' => $request->km_terpakai,
                    'target_km' => $request->target_km,
                    'km_pemasangan' => $request->km_pemasangan,
                    'km_pelepasan' => $request->km_pelepasan,
                    'grand_total' => $request->grand_total,
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));
        } else if ($keterangan == "Stok") {
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
                // 'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',
            ]);

            Km_ban::create([
                'ban_id' => $banId,
                'kendaraan_id' => $request->kendaraan_id,
                'pemasangan_ban_id' => $ban->pemasangan_ban_id,
                'status' => 'non aktif sementara',
                'umur_ban' => $request->km_terpakai + ($ban->jumlah_km ?? 0),
                'pelepasan_ban_id' => null
            ]);
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

            $kodeklaimban = $this->kodeklaimban();

            $tanggal1 = Carbon::now('Asia/Jakarta');
            $format_tanggal = $tanggal1->format('d F Y');

            $tanggal = Carbon::now()->format('Y-m-d');
            $depositdriver = Klaim_ban::create(array_merge(
                $request->all(),
                [
                    'kode_klaimban' => $this->kodeklaimban(),
                    'ban_id' => $banId,
                    'karyawan_id' => $request->karyawan_id,
                    'deposit_driver_id' => $depositdriver->id,
                    'penerimaan_kaskecil_id' => $penerimaan->id,
                    'keterangan' => $request->keterangan,
                    'harga_ban' => $ban->harga,
                    'harga_klaim' => str_replace('.', '', $request->sisa_harga),
                    'km_terpakai' => $request->km_terpakai,
                    'target_km' => $request->target_km,
                    'km_pemasangan' => $request->km_pemasangan,
                    'km_pelepasan' => $request->km_pelepasan,
                    'grand_total' => $request->grand_total,
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));
        } else if ($keterangan == "Stok") {
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
                // 'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',
            ]);

            Km_ban::create([
                'ban_id' => $banId,
                'kendaraan_id' => $request->kendaraan_id,
                'pemasangan_ban_id' => $ban->pemasangan_ban_id,
                'status' => 'non aktif sementara',
                'umur_ban' => $request->km_terpakai + ($ban->jumlah_km ?? 0),
                'pelepasan_ban_id' => null
            ]);
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

            $kodeklaimban = $this->kodeklaimban();

            $tanggal1 = Carbon::now('Asia/Jakarta');
            $format_tanggal = $tanggal1->format('d F Y');

            $tanggal = Carbon::now()->format('Y-m-d');
            $depositdriver = Klaim_ban::create(array_merge(
                $request->all(),
                [
                    'kode_klaimban' => $this->kodeklaimban(),
                    'ban_id' => $banId,
                    'karyawan_id' => $request->karyawan_id,
                    'deposit_driver_id' => $depositdriver->id,
                    'penerimaan_kaskecil_id' => $penerimaan->id,
                    'keterangan' => $request->keterangan,
                    'harga_ban' => $ban->harga,
                    'harga_klaim' => str_replace('.', '', $request->sisa_harga),
                    'km_terpakai' => $request->km_terpakai,
                    'target_km' => $request->target_km,
                    'km_pemasangan' => $request->km_pemasangan,
                    'km_pelepasan' => $request->km_pelepasan,
                    'grand_total' => $request->grand_total,
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));
        } else if ($keterangan == "Stok") {
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
                // 'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',
            ]);

            Km_ban::create([
                'ban_id' => $banId,
                'kendaraan_id' => $request->kendaraan_id,
                'pemasangan_ban_id' => $ban->pemasangan_ban_id,
                'status' => 'non aktif sementara',
                'umur_ban' => $request->km_terpakai + ($ban->jumlah_km ?? 0),
                'pelepasan_ban_id' => null
            ]);
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

            $kodeklaimban = $this->kodeklaimban();

            $tanggal1 = Carbon::now('Asia/Jakarta');
            $format_tanggal = $tanggal1->format('d F Y');

            $tanggal = Carbon::now()->format('Y-m-d');
            $depositdriver = Klaim_ban::create(array_merge(
                $request->all(),
                [
                    'kode_klaimban' => $this->kodeklaimban(),
                    'ban_id' => $banId,
                    'karyawan_id' => $request->karyawan_id,
                    'deposit_driver_id' => $depositdriver->id,
                    'penerimaan_kaskecil_id' => $penerimaan->id,
                    'keterangan' => $request->keterangan,
                    'harga_ban' => $ban->harga,
                    'harga_klaim' => str_replace('.', '', $request->sisa_harga),
                    'km_terpakai' => $request->km_terpakai,
                    'target_km' => $request->target_km,
                    'km_pemasangan' => $request->km_pemasangan,
                    'km_pelepasan' => $request->km_pelepasan,
                    'grand_total' => $request->grand_total,
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));
        } else if ($keterangan == "Stok") {
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
                // 'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',
            ]);

            Km_ban::create([
                'ban_id' => $banId,
                'kendaraan_id' => $request->kendaraan_id,
                'pemasangan_ban_id' => $ban->pemasangan_ban_id,
                'status' => 'non aktif sementara',
                'umur_ban' => $request->km_terpakai + ($ban->jumlah_km ?? 0),
                'pelepasan_ban_id' => null
            ]);
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

            $kodeklaimban = $this->kodeklaimban();

            $tanggal1 = Carbon::now('Asia/Jakarta');
            $format_tanggal = $tanggal1->format('d F Y');

            $tanggal = Carbon::now()->format('Y-m-d');
            $depositdriver = Klaim_ban::create(array_merge(
                $request->all(),
                [
                    'kode_klaimban' => $this->kodeklaimban(),
                    'ban_id' => $banId,
                    'karyawan_id' => $request->karyawan_id,
                    'deposit_driver_id' => $depositdriver->id,
                    'penerimaan_kaskecil_id' => $penerimaan->id,
                    'keterangan' => $request->keterangan,
                    'harga_ban' => $ban->harga,
                    'harga_klaim' => str_replace('.', '', $request->sisa_harga),
                    'km_terpakai' => $request->km_terpakai,
                    'target_km' => $request->target_km,
                    'km_pemasangan' => $request->km_pemasangan,
                    'km_pelepasan' => $request->km_pelepasan,
                    'grand_total' => $request->grand_total,
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));
        } else if ($keterangan == "Stok") {
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
                // 'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',
            ]);

            Km_ban::create([
                'ban_id' => $banId,
                'kendaraan_id' => $request->kendaraan_id,
                'pemasangan_ban_id' => $ban->pemasangan_ban_id,
                'status' => 'non aktif sementara',
                'umur_ban' => $request->km_terpakai + ($ban->jumlah_km ?? 0),
                'pelepasan_ban_id' => null
            ]);
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

            $kodeklaimban = $this->kodeklaimban();

            $tanggal1 = Carbon::now('Asia/Jakarta');
            $format_tanggal = $tanggal1->format('d F Y');

            $tanggal = Carbon::now()->format('Y-m-d');
            $depositdriver = Klaim_ban::create(array_merge(
                $request->all(),
                [
                    'kode_klaimban' => $this->kodeklaimban(),
                    'ban_id' => $banId,
                    'karyawan_id' => $request->karyawan_id,
                    'deposit_driver_id' => $depositdriver->id,
                    'penerimaan_kaskecil_id' => $penerimaan->id,
                    'keterangan' => $request->keterangan,
                    'harga_ban' => $ban->harga,
                    'harga_klaim' => str_replace('.', '', $request->sisa_harga),
                    'km_terpakai' => $request->km_terpakai,
                    'target_km' => $request->target_km,
                    'km_pemasangan' => $request->km_pemasangan,
                    'km_pelepasan' => $request->km_pelepasan,
                    'grand_total' => $request->grand_total,
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));
        } else if ($keterangan == "Stok") {
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
                // 'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',
            ]);

            Km_ban::create([
                'ban_id' => $banId,
                'kendaraan_id' => $request->kendaraan_id,
                'pemasangan_ban_id' => $ban->pemasangan_ban_id,
                'status' => 'non aktif sementara',
                'umur_ban' => $request->km_terpakai + ($ban->jumlah_km ?? 0),
                'pelepasan_ban_id' => null
            ]);
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

            $kodeklaimban = $this->kodeklaimban();

            $tanggal1 = Carbon::now('Asia/Jakarta');
            $format_tanggal = $tanggal1->format('d F Y');

            $tanggal = Carbon::now()->format('Y-m-d');
            $depositdriver = Klaim_ban::create(array_merge(
                $request->all(),
                [
                    'kode_klaimban' => $this->kodeklaimban(),
                    'ban_id' => $banId,
                    'karyawan_id' => $request->karyawan_id,
                    'deposit_driver_id' => $depositdriver->id,
                    'penerimaan_kaskecil_id' => $penerimaan->id,
                    'keterangan' => $request->keterangan,
                    'harga_ban' => $ban->harga,
                    'harga_klaim' => str_replace('.', '', $request->sisa_harga),
                    'km_terpakai' => $request->km_terpakai,
                    'target_km' => $request->target_km,
                    'km_pemasangan' => $request->km_pemasangan,
                    'km_pelepasan' => $request->km_pelepasan,
                    'grand_total' => $request->grand_total,
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));
        } else if ($keterangan == "Stok") {
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
                // 'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',
            ]);

            Km_ban::create([
                'ban_id' => $banId,
                'kendaraan_id' => $request->kendaraan_id,
                'pemasangan_ban_id' => $ban->pemasangan_ban_id,
                'status' => 'non aktif sementara',
                'umur_ban' => $request->km_terpakai + ($ban->jumlah_km ?? 0),
                'pelepasan_ban_id' => null
            ]);
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

            $kodeklaimban = $this->kodeklaimban();

            $tanggal1 = Carbon::now('Asia/Jakarta');
            $format_tanggal = $tanggal1->format('d F Y');

            $tanggal = Carbon::now()->format('Y-m-d');
            $depositdriver = Klaim_ban::create(array_merge(
                $request->all(),
                [
                    'kode_klaimban' => $this->kodeklaimban(),
                    'ban_id' => $banId,
                    'karyawan_id' => $request->karyawan_id,
                    'deposit_driver_id' => $depositdriver->id,
                    'penerimaan_kaskecil_id' => $penerimaan->id,
                    'keterangan' => $request->keterangan,
                    'harga_ban' => $ban->harga,
                    'harga_klaim' => str_replace('.', '', $request->sisa_harga),
                    'km_terpakai' => $request->km_terpakai,
                    'target_km' => $request->target_km,
                    'km_pemasangan' => $request->km_pemasangan,
                    'km_pelepasan' => $request->km_pelepasan,
                    'grand_total' => $request->grand_total,
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));
        } else if ($keterangan == "Stok") {
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
                // 'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',
            ]);

            Km_ban::create([
                'ban_id' => $banId,
                'kendaraan_id' => $request->kendaraan_id,
                'pemasangan_ban_id' => $ban->pemasangan_ban_id,
                'status' => 'non aktif sementara',
                'umur_ban' => $request->km_terpakai + ($ban->jumlah_km ?? 0),
                'pelepasan_ban_id' => null
            ]);
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

            $kodeklaimban = $this->kodeklaimban();

            $tanggal1 = Carbon::now('Asia/Jakarta');
            $format_tanggal = $tanggal1->format('d F Y');

            $tanggal = Carbon::now()->format('Y-m-d');
            $depositdriver = Klaim_ban::create(array_merge(
                $request->all(),
                [
                    'kode_klaimban' => $this->kodeklaimban(),
                    'ban_id' => $banId,
                    'karyawan_id' => $request->karyawan_id,
                    'deposit_driver_id' => $depositdriver->id,
                    'penerimaan_kaskecil_id' => $penerimaan->id,
                    'keterangan' => $request->keterangan,
                    'harga_ban' => $ban->harga,
                    'harga_klaim' => str_replace('.', '', $request->sisa_harga),
                    'km_terpakai' => $request->km_terpakai,
                    'target_km' => $request->target_km,
                    'km_pemasangan' => $request->km_pemasangan,
                    'km_pelepasan' => $request->km_pelepasan,
                    'grand_total' => $request->grand_total,
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));
        } else if ($keterangan == "Stok") {
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
                // 'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',
            ]);

            Km_ban::create([
                'ban_id' => $banId,
                'kendaraan_id' => $request->kendaraan_id,
                'pemasangan_ban_id' => $ban->pemasangan_ban_id,
                'status' => 'non aktif sementara',
                'umur_ban' => $request->km_terpakai + ($ban->jumlah_km ?? 0),
                'pelepasan_ban_id' => null
            ]);
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

            $kodeklaimban = $this->kodeklaimban();

            $tanggal1 = Carbon::now('Asia/Jakarta');
            $format_tanggal = $tanggal1->format('d F Y');

            $tanggal = Carbon::now()->format('Y-m-d');
            $depositdriver = Klaim_ban::create(array_merge(
                $request->all(),
                [
                    'kode_klaimban' => $this->kodeklaimban(),
                    'ban_id' => $banId,
                    'karyawan_id' => $request->karyawan_id,
                    'deposit_driver_id' => $depositdriver->id,
                    'penerimaan_kaskecil_id' => $penerimaan->id,
                    'keterangan' => $request->keterangan,
                    'harga_ban' => $ban->harga,
                    'harga_klaim' => str_replace('.', '', $request->sisa_harga),
                    'km_terpakai' => $request->km_terpakai,
                    'target_km' => $request->target_km,
                    'km_pemasangan' => $request->km_pemasangan,
                    'km_pelepasan' => $request->km_pelepasan,
                    'grand_total' => $request->grand_total,
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));
        } else if ($keterangan == "Stok") {
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
                // 'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',
            ]);

            Km_ban::create([
                'ban_id' => $banId,
                'kendaraan_id' => $request->kendaraan_id,
                'pemasangan_ban_id' => $ban->pemasangan_ban_id,
                'status' => 'non aktif sementara',
                'umur_ban' => $request->km_terpakai + ($ban->jumlah_km ?? 0),
                'pelepasan_ban_id' => null
            ]);
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

            $kodeklaimban = $this->kodeklaimban();

            $tanggal1 = Carbon::now('Asia/Jakarta');
            $format_tanggal = $tanggal1->format('d F Y');

            $tanggal = Carbon::now()->format('Y-m-d');
            $depositdriver = Klaim_ban::create(array_merge(
                $request->all(),
                [
                    'kode_klaimban' => $this->kodeklaimban(),
                    'ban_id' => $banId,
                    'karyawan_id' => $request->karyawan_id,
                    'deposit_driver_id' => $depositdriver->id,
                    'penerimaan_kaskecil_id' => $penerimaan->id,
                    'keterangan' => $request->keterangan,
                    'harga_ban' => $ban->harga,
                    'harga_klaim' => str_replace('.', '', $request->sisa_harga),
                    'km_terpakai' => $request->km_terpakai,
                    'target_km' => $request->target_km,
                    'km_pemasangan' => $request->km_pemasangan,
                    'km_pelepasan' => $request->km_pelepasan,
                    'grand_total' => $request->grand_total,
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));
        } else if ($keterangan == "Stok") {
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
                // 'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',
            ]);

            Km_ban::create([
                'ban_id' => $banId,
                'kendaraan_id' => $request->kendaraan_id,
                'pemasangan_ban_id' => $ban->pemasangan_ban_id,
                'status' => 'non aktif sementara',
                'umur_ban' => $request->km_terpakai + ($ban->jumlah_km ?? 0),
                'pelepasan_ban_id' => null
            ]);
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

            $kodeklaimban = $this->kodeklaimban();

            $tanggal1 = Carbon::now('Asia/Jakarta');
            $format_tanggal = $tanggal1->format('d F Y');

            $tanggal = Carbon::now()->format('Y-m-d');
            $depositdriver = Klaim_ban::create(array_merge(
                $request->all(),
                [
                    'kode_klaimban' => $this->kodeklaimban(),
                    'ban_id' => $banId,
                    'karyawan_id' => $request->karyawan_id,
                    'deposit_driver_id' => $depositdriver->id,
                    'penerimaan_kaskecil_id' => $penerimaan->id,
                    'keterangan' => $request->keterangan,
                    'harga_ban' => $ban->harga,
                    'harga_klaim' => str_replace('.', '', $request->sisa_harga),
                    'km_terpakai' => $request->km_terpakai,
                    'target_km' => $request->target_km,
                    'km_pemasangan' => $request->km_pemasangan,
                    'km_pelepasan' => $request->km_pelepasan,
                    'grand_total' => $request->grand_total,
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));
        } else if ($keterangan == "Stok") {
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
                // 'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',
            ]);

            Km_ban::create([
                'ban_id' => $banId,
                'kendaraan_id' => $request->kendaraan_id,
                'pemasangan_ban_id' => $ban->pemasangan_ban_id,
                'status' => 'non aktif sementara',
                'umur_ban' => $request->km_terpakai + ($ban->jumlah_km ?? 0),
                'pelepasan_ban_id' => null
            ]);
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

            $kodeklaimban = $this->kodeklaimban();

            $tanggal1 = Carbon::now('Asia/Jakarta');
            $format_tanggal = $tanggal1->format('d F Y');

            $tanggal = Carbon::now()->format('Y-m-d');
            $depositdriver = Klaim_ban::create(array_merge(
                $request->all(),
                [
                    'kode_klaimban' => $this->kodeklaimban(),
                    'ban_id' => $banId,
                    'karyawan_id' => $request->karyawan_id,
                    'deposit_driver_id' => $depositdriver->id,
                    'penerimaan_kaskecil_id' => $penerimaan->id,
                    'keterangan' => $request->keterangan,
                    'harga_ban' => $ban->harga,
                    'harga_klaim' => str_replace('.', '', $request->sisa_harga),
                    'km_terpakai' => $request->km_terpakai,
                    'target_km' => $request->target_km,
                    'km_pemasangan' => $request->km_pemasangan,
                    'km_pelepasan' => $request->km_pelepasan,
                    'grand_total' => $request->grand_total,
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));
        } else if ($keterangan == "Stok") {
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
                // 'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',
            ]);

            Km_ban::create([
                'ban_id' => $banId,
                'kendaraan_id' => $request->kendaraan_id,
                'pemasangan_ban_id' => $ban->pemasangan_ban_id,
                'status' => 'non aktif sementara',
                'umur_ban' => $request->km_terpakai + ($ban->jumlah_km ?? 0),
                'pelepasan_ban_id' => null
            ]);
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

            $kodeklaimban = $this->kodeklaimban();

            $tanggal1 = Carbon::now('Asia/Jakarta');
            $format_tanggal = $tanggal1->format('d F Y');

            $tanggal = Carbon::now()->format('Y-m-d');
            $depositdriver = Klaim_ban::create(array_merge(
                $request->all(),
                [
                    'kode_klaimban' => $this->kodeklaimban(),
                    'ban_id' => $banId,
                    'karyawan_id' => $request->karyawan_id,
                    'deposit_driver_id' => $depositdriver->id,
                    'penerimaan_kaskecil_id' => $penerimaan->id,
                    'keterangan' => $request->keterangan,
                    'harga_ban' => $ban->harga,
                    'harga_klaim' => str_replace('.', '', $request->sisa_harga),
                    'km_terpakai' => $request->km_terpakai,
                    'target_km' => $request->target_km,
                    'km_pemasangan' => $request->km_pemasangan,
                    'km_pelepasan' => $request->km_pelepasan,
                    'grand_total' => $request->grand_total,
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));
        } else if ($keterangan == "Stok") {
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
                // 'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',
            ]);

            Km_ban::create([
                'ban_id' => $banId,
                'kendaraan_id' => $request->kendaraan_id,
                'pemasangan_ban_id' => $ban->pemasangan_ban_id,
                'status' => 'non aktif sementara',
                'umur_ban' => $request->km_terpakai + ($ban->jumlah_km ?? 0),
                'pelepasan_ban_id' => null
            ]);
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

            $kodeklaimban = $this->kodeklaimban();

            $tanggal1 = Carbon::now('Asia/Jakarta');
            $format_tanggal = $tanggal1->format('d F Y');

            $tanggal = Carbon::now()->format('Y-m-d');
            $depositdriver = Klaim_ban::create(array_merge(
                $request->all(),
                [
                    'kode_klaimban' => $this->kodeklaimban(),
                    'ban_id' => $banId,
                    'karyawan_id' => $request->karyawan_id,
                    'deposit_driver_id' => $depositdriver->id,
                    'penerimaan_kaskecil_id' => $penerimaan->id,
                    'keterangan' => $request->keterangan,
                    'harga_ban' => $ban->harga,
                    'harga_klaim' => str_replace('.', '', $request->sisa_harga),
                    'km_terpakai' => $request->km_terpakai,
                    'target_km' => $request->target_km,
                    'km_pemasangan' => $request->km_pemasangan,
                    'km_pelepasan' => $request->km_pelepasan,
                    'grand_total' => $request->grand_total,
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));
        } else if ($keterangan == "Stok") {
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
                // 'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',
            ]);

            Km_ban::create([
                'ban_id' => $banId,
                'kendaraan_id' => $request->kendaraan_id,
                'pemasangan_ban_id' => $ban->pemasangan_ban_id,
                'status' => 'non aktif sementara',
                'umur_ban' => $request->km_terpakai + ($ban->jumlah_km ?? 0),
                'pelepasan_ban_id' => null
            ]);
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

            $kodeklaimban = $this->kodeklaimban();

            $tanggal1 = Carbon::now('Asia/Jakarta');
            $format_tanggal = $tanggal1->format('d F Y');

            $tanggal = Carbon::now()->format('Y-m-d');
            $depositdriver = Klaim_ban::create(array_merge(
                $request->all(),
                [
                    'kode_klaimban' => $this->kodeklaimban(),
                    'ban_id' => $banId,
                    'karyawan_id' => $request->karyawan_id,
                    'deposit_driver_id' => $depositdriver->id,
                    'penerimaan_kaskecil_id' => $penerimaan->id,
                    'keterangan' => $request->keterangan,
                    'harga_ban' => $ban->harga,
                    'harga_klaim' => str_replace('.', '', $request->sisa_harga),
                    'km_terpakai' => $request->km_terpakai,
                    'target_km' => $request->target_km,
                    'km_pemasangan' => $request->km_pemasangan,
                    'km_pelepasan' => $request->km_pelepasan,
                    'grand_total' => $request->grand_total,
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));
        } else if ($keterangan == "Stok") {
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
                // 'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',
            ]);

            Km_ban::create([
                'ban_id' => $banId,
                'kendaraan_id' => $request->kendaraan_id,
                'pemasangan_ban_id' => $ban->pemasangan_ban_id,
                'status' => 'non aktif sementara',
                'umur_ban' => $request->km_terpakai + ($ban->jumlah_km ?? 0),
                'pelepasan_ban_id' => null
            ]);
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

            $kodeklaimban = $this->kodeklaimban();

            $tanggal1 = Carbon::now('Asia/Jakarta');
            $format_tanggal = $tanggal1->format('d F Y');

            $tanggal = Carbon::now()->format('Y-m-d');
            $depositdriver = Klaim_ban::create(array_merge(
                $request->all(),
                [
                    'kode_klaimban' => $this->kodeklaimban(),
                    'ban_id' => $banId,
                    'karyawan_id' => $request->karyawan_id,
                    'deposit_driver_id' => $depositdriver->id,
                    'penerimaan_kaskecil_id' => $penerimaan->id,
                    'keterangan' => $request->keterangan,
                    'harga_ban' => $ban->harga,
                    'harga_klaim' => str_replace('.', '', $request->sisa_harga),
                    'km_terpakai' => $request->km_terpakai,
                    'target_km' => $request->target_km,
                    'km_pemasangan' => $request->km_pemasangan,
                    'km_pelepasan' => $request->km_pelepasan,
                    'grand_total' => $request->grand_total,
                    'tanggal' =>  $format_tanggal,
                    'tanggal_awal' =>  $tanggal,
                    'status' => 'unpost',
                ]
            ));
        } else if ($keterangan == "Stok") {
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
                // 'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',
            ]);

            Km_ban::create([
                'ban_id' => $banId,
                'kendaraan_id' => $request->kendaraan_id,
                'pemasangan_ban_id' => $ban->pemasangan_ban_id,
                'status' => 'non aktif sementara',
                'umur_ban' => $request->km_terpakai + ($ban->jumlah_km ?? 0),
                'pelepasan_ban_id' => null
            ]);
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

    public function kodeklaimban()
    {
        $lastBarang = Klaim_ban::latest()->first();
        if (!$lastBarang) {
            $num = 1;
        } else {
            $lastCode = $lastBarang->kode_klaimban;
            $num = (int) substr($lastCode, strlen('KB')) + 1;
        }
        $formattedNum = sprintf("%06s", $num);
        $prefix = 'KB';
        $newCode = $prefix . $formattedNum;
        return $newCode;
    }
}