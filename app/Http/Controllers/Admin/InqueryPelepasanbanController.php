<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use App\Models\Ban;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use App\Models\Pelepasan_ban;
use App\Http\Controllers\Controller;
use App\Models\Deposit_driver;
use App\Models\Detail_ban;
use App\Models\Karyawan;
use App\Models\Klaim_ban;
use App\Models\Penerimaan_kaskecil;
use App\Models\Saldo;
use App\Models\Km_ban;
use Illuminate\Support\Facades\Validator;

class InqueryPelepasanbanController extends Controller
{
    public function index(Request $request)
    {

        if (auth()->check() && auth()->user()->menu['inquery pelepasan ban']) {

            Pelepasan_ban::where([
                ['status', 'posting']
            ])->update([
                'status_notif' => true
            ]);

            $status = $request->status;
            $tanggal_awal = $request->tanggal_awal;
            $tanggal_akhir = $request->tanggal_akhir;

            $inquery = Pelepasan_ban::query();

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
                $inquery->orWhereDate('tanggal_awal', Carbon::today());
            }

            $inquery->orderBy('id', 'DESC');
            $inquery = $inquery->get();

            return view('admin.inquery_pelepasanban.index', compact('inquery'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function unpostpelepasan($id)
    {
        $ban = Pelepasan_ban::where('id', $id)->first();

        $ban->update([
            'status' => 'unpost'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function postingpelepasan($id)
    {
        $ban = Pelepasan_ban::where('id', $id)->first();

        $ban->update([
            'status' => 'posting'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function lihat_pelepasan($id)
    {
        if (auth()->check() && auth()->user()->menu['inquery pelepasan ban']) {

            $pelepasan_ban = Pelepasan_ban::findOrFail($id);

            $kendaraan_id = $pelepasan_ban->kendaraan_id;

            $kendaraan = Kendaraan::findOrFail($kendaraan_id);

            $bans = Detail_ban::where('pelepasan_ban_id', $id)->get();

            return view('admin.inquery_pelepasanban.show', compact('bans', 'kendaraan', 'pelepasan_ban'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function edit($id)
    {
        if (auth()->check() && auth()->user()->menu['inquery pelepasan ban']) {

            $inquerypelepasan = Pelepasan_ban::where('id', $id)->first();
            $inquery_pelepasanban = Pelepasan_ban::findOrFail($id);
            $kendaraan = Kendaraan::findOrFail($inquery_pelepasanban->kendaraan_id);

            $bans = Ban::where(['posisi_ban' => '1A', 'status' => 'aktif',  'kendaraan_id' => $kendaraan->id,])->first();
            $bansb = Ban::where(['posisi_ban' => '1B', 'status' => 'aktif',  'kendaraan_id' => $kendaraan->id,])->first();
            $bans2a = Ban::where(['posisi_ban' => '2A', 'status' => 'aktif',  'kendaraan_id' => $kendaraan->id,])->first();
            $bans2b = Ban::where(['posisi_ban' => '2B', 'status' => 'aktif',  'kendaraan_id' => $kendaraan->id,])->first();
            $bans2c = Ban::where(['posisi_ban' => '2C', 'status' => 'aktif',  'kendaraan_id' => $kendaraan->id,])->first();
            $bans2d = Ban::where(['posisi_ban' => '2D', 'status' => 'aktif',  'kendaraan_id' => $kendaraan->id,])->first();
            $bans3a = Ban::where(['posisi_ban' => '3A', 'status' => 'aktif',  'kendaraan_id' => $kendaraan->id,])->first();
            $bans3b = Ban::where(['posisi_ban' => '3B', 'status' => 'aktif',  'kendaraan_id' => $kendaraan->id,])->first();
            $bans3c = Ban::where(['posisi_ban' => '3C', 'status' => 'aktif',  'kendaraan_id' => $kendaraan->id,])->first();
            $bans3d = Ban::where(['posisi_ban' => '3D', 'status' => 'aktif',  'kendaraan_id' => $kendaraan->id,])->first();
            $bans4a = Ban::where(['posisi_ban' => '3A', 'status' => 'aktif',  'kendaraan_id' => $kendaraan->id,])->first();
            $bans4b = Ban::where(['posisi_ban' => '3B', 'status' => 'aktif',  'kendaraan_id' => $kendaraan->id,])->first();
            $bans4c = Ban::where(['posisi_ban' => '3C', 'status' => 'aktif',  'kendaraan_id' => $kendaraan->id,])->first();
            $bans4d = Ban::where(['posisi_ban' => '3D', 'status' => 'aktif',  'kendaraan_id' => $kendaraan->id,])->first();
            $bans4a = Ban::where(['posisi_ban' => '4A', 'status' => 'aktif',  'kendaraan_id' => $kendaraan->id,])->first();
            $bans4b = Ban::where(['posisi_ban' => '4B', 'status' => 'aktif',  'kendaraan_id' => $kendaraan->id,])->first();
            $bans4c = Ban::where(['posisi_ban' => '4C', 'status' => 'aktif',  'kendaraan_id' => $kendaraan->id,])->first();
            $bans4d = Ban::where(['posisi_ban' => '4D', 'status' => 'aktif',  'kendaraan_id' => $kendaraan->id,])->first();
            $bans5a = Ban::where(['posisi_ban' => '5A', 'status' => 'aktif',  'kendaraan_id' => $kendaraan->id,])->first();
            $bans5b = Ban::where(['posisi_ban' => '5B', 'status' => 'aktif',  'kendaraan_id' => $kendaraan->id,])->first();
            $bans5c = Ban::where(['posisi_ban' => '5C', 'status' => 'aktif',  'kendaraan_id' => $kendaraan->id,])->first();
            $bans5d = Ban::where(['posisi_ban' => '5D', 'status' => 'aktif',  'kendaraan_id' => $kendaraan->id,])->first();
            $bans6a = Ban::where(['posisi_ban' => '6A', 'status' => 'aktif',  'kendaraan_id' => $kendaraan->id,])->first();
            $bans6b = Ban::where(['posisi_ban' => '6B', 'status' => 'aktif',  'kendaraan_id' => $kendaraan->id,])->first();
            $bans6c = Ban::where(['posisi_ban' => '6C', 'status' => 'aktif',  'kendaraan_id' => $kendaraan->id,])->first();
            $bans6d = Ban::where(['posisi_ban' => '6D', 'status' => 'aktif',  'kendaraan_id' => $kendaraan->id,])->first();

            $banspas = Ban::where(['posisi_ban' => '1A', 'status' => 'non aktif', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id,])->first();
            $banspasb = Ban::where(['posisi_ban' => '1B', 'status' => 'non aktif', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id,])->first();
            $banspas2a = Ban::where(['posisi_ban' => '2A', 'status' => 'non aktif', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id,])->first();
            $banspas2b = Ban::where(['posisi_ban' => '2B', 'status' => 'non aktif', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id,])->first();
            $banspas2c = Ban::where(['posisi_ban' => '2C', 'status' => 'non aktif', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id,])->first();
            $banspas2d = Ban::where(['posisi_ban' => '2D', 'status' => 'non aktif', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id,])->first();
            $banspas3a = Ban::where(['posisi_ban' => '3A', 'status' => 'non aktif', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id,])->first();
            $banspas3b = Ban::where(['posisi_ban' => '3B', 'status' => 'non aktif', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id,])->first();
            $banspas3c = Ban::where(['posisi_ban' => '3C', 'status' => 'non aktif', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id,])->first();
            $banspas3d = Ban::where(['posisi_ban' => '3D', 'status' => 'non aktif', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id,])->first();
            $banspas4a = Ban::where(['posisi_ban' => '3A', 'status' => 'non aktif', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id,])->first();
            $banspas4b = Ban::where(['posisi_ban' => '3B', 'status' => 'non aktif', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id,])->first();
            $banspas4c = Ban::where(['posisi_ban' => '3C', 'status' => 'non aktif', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id,])->first();
            $banspas4d = Ban::where(['posisi_ban' => '3D', 'status' => 'non aktif', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id,])->first();
            $banspas4a = Ban::where(['posisi_ban' => '4A', 'status' => 'non aktif', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id,])->first();
            $banspas4b = Ban::where(['posisi_ban' => '4B', 'status' => 'non aktif', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id,])->first();
            $banspas4c = Ban::where(['posisi_ban' => '4C', 'status' => 'non aktif', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id,])->first();
            $banspas4d = Ban::where(['posisi_ban' => '4D', 'status' => 'non aktif', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id,])->first();
            $banspas5a = Ban::where(['posisi_ban' => '5A', 'status' => 'non aktif', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id,])->first();
            $banspas5b = Ban::where(['posisi_ban' => '5B', 'status' => 'non aktif', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id,])->first();
            $banspas5c = Ban::where(['posisi_ban' => '5C', 'status' => 'non aktif', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id,])->first();
            $banspas5d = Ban::where(['posisi_ban' => '5D', 'status' => 'non aktif', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id,])->first();
            $banspas6a = Ban::where(['posisi_ban' => '6A', 'status' => 'non aktif', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id,])->first();
            $banspas6b = Ban::where(['posisi_ban' => '6B', 'status' => 'non aktif', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id,])->first();
            $banspas6c = Ban::where(['posisi_ban' => '6C', 'status' => 'non aktif', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id,])->first();
            $banspas6d = Ban::where(['posisi_ban' => '6D', 'status' => 'non aktif', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id,])->first();
            $daftarbans = Ban::where(['status' => 'non aktif'])->get();

            $SopirAll = Karyawan::where('departemen_id', '2')->get();

            $tabelbans = Ban::where([
                ['kendaraan_id', $kendaraan->id],
                ['status_pelepasan', 'true'],
                ['pelepasan_ban_id', $id]
            ])->get();

            return view('admin/inquery_pelepasanban.update', compact('SopirAll', 'inquerypelepasan', 'daftarbans', 'kendaraan', 'tabelbans', 'bans', 'bansb', 'bans2a', 'bans2b', 'bans2c', 'bans2d', 'bans3a', 'bans3b', 'bans3c', 'bans3d', 'bans4a', 'bans4b', 'bans4c', 'bans4d', 'bans5a', 'bans5b', 'bans5c', 'bans5d', 'bans6a', 'bans6b', 'bans6c', 'bans6d', 'banspas', 'banspasb', 'banspas2a', 'banspas2b', 'banspas2c', 'banspas2d', 'banspas3a', 'banspas3b', 'banspas3c', 'banspas3d', 'banspas4a', 'banspas4b', 'banspas4c', 'banspas4d', 'banspas5a', 'banspas5b', 'banspas5c', 'banspas5d', 'banspas6a', 'banspas6b', 'banspas6c', 'banspas6d'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
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

        $umurbans = Km_ban::where(['ban_id' => $id])
            ->orderBy('created_at', 'desc')
            ->first();

        if ($umurbans) {
            // Hapus deposit_driver
            $umurbans->delete();
        }

        $detail_ban = Detail_ban::where('ban_id', $id)->first();
        if ($detail_ban) {
            // Hapus deposit_driver
            $detail_ban->delete();
        }

        // Setelah itu, update objek Ban
        $ban->update([
            // 'pelepasan_ban_id' => null,
            'jumlah_km' => null,
            'status' => 'aktif',
            'status_pelepasan' => null
        ]);

        return redirect()->back()->with('success', 'Berhasil menghapus pelepasan ban');
    }

    public function hapuspelepasan($id)
    {
        $ban = Ban::find($id);

        if ($ban) {
            $ban->update([
                'status' => 'aktif'
            ]);

            return redirect()->back()->with('success', 'Berhasil menghapus pelepasan ban');
        }
    }

    public function deletebans($id)
    {
        $item = Pelepasan_ban::find($id);
        $bans = Ban::where('pelepasan_ban_id', $id)->get();

        if ($bans->isNotEmpty()) {
            // Iterasi melalui setiap objek ban dan perbarui statusnya
            foreach ($bans as $ban) {
                $ban->update([
                    'status' => 'aktif'
                ]);
            }
        }

        // Hapus item Pelepasan_ban
        $item->delete();

        return redirect('admin/inquery_pelepasanban')->with('success', 'Berhasil menghapus Pelepasan');
    }

    public function update(Request $request, $id)
    {

        $pelepasan_ban = Pelepasan_ban::findOrFail($id);

        $tanggal_awal = Carbon::parse($pelepasan_ban->tanggal_awal);

        $today = Carbon::now('Asia/Jakarta')->format('Y-m-d');
        $lastUpdatedDate = $tanggal_awal->format('Y-m-d');

        // if ($lastUpdatedDate < $today) {
        //     return back()->with('errormax', 'Anda tidak dapat melakukan update setelah berganti hari.');
        // }

        $bans = Ban::where([
            ['pelepasan_ban_id', $id],
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

            // Update Ban dengan nilai jumlah_km
            $ban->update([
                'status' => 'stok',
                'status_pelepasan' => 'true',
                'pelepasan_ban_id' => $id,
                'jumlah_km' => $jumlahKm + ($ban->km_terpakai ?? 0)
            ]);

            $detail_ban = Detail_ban::where('ban_id', $ban->id)->update([
                'status' => 'stok',
                'status_pelepasan' => 'true',
                'pelepasan_ban_id' => $id,
                'jumlah_km' => $jumlahKm + ($ban->km_terpakai ?? 0)
            ]);
        }


        $bans = Ban::where([
            ['pelepasan_ban_id', $id],
            ['status', 'non aktif sementara']
        ])->get();

        // Loop melalui setiap Ban dan update dengan jumlah_km dari Km_ban
        foreach ($bans as $ban) {

            $ban->update([
                'status' => 'non aktif',
                'status_pelepasan' => 'true',
                'pelepasan_ban_id' => $id,
            ]);

            $detail_ban = Detail_ban::where('ban_id', $ban->id)->update([
                'status' => 'non aktif',
                'status_pelepasan' => 'true',
                'pelepasan_ban_id' => $id,
            ]);
        }

        // Ban::where([
        //     ['kendaraan_id', $id],
        //     ['status', 'non aktif sementara']
        // ])->update([
        //     'status' => 'non aktif',
        //     'status_pelepasan' => 'true',
        //     'pelepasan_ban_id' => $id,
        // ]);

        Km_ban::where([
            ['pelepasan_ban_id', $id],
            ['status', 'non aktif sementara']
        ])->update([
            'status' => 'digunakan',
            'pelepasan_ban_id' => $id,
        ]);

        $pelepasan_ban->update([
            'status' => 'posting',
        ]);

        $kendaraan_id = $pelepasan_ban->kendaraan_id;

        $kendaraan = Kendaraan::findOrFail($kendaraan_id);

        $bans = Detail_ban::where('pelepasan_ban_id', $id)->get();

        return view('admin.inquery_pelepasanban.show', compact('bans', 'kendaraan', 'pelepasan_ban'));
    }

    public function inquerypelepasan1(Request $request, $id)
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

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
        $kendaraan->update([
            'km' => $request->km_pelepasan
        ]);

        $keterangan = $request->keterangan;

        if ($keterangan == "Pecah Klaim") {

            $kendaraan = Kendaraan::findOrFail($id);
            $banId = $request->id_ban;
            $ban = Ban::find($banId);

            if (!$ban) {
                return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
            }

            $pelepasan = Pelepasan_ban::findOrFail($request->pelepasan_ban_id);
            $ban->update([
                'keterangan' => $request->keterangan,
                'km_pelepasan' => $request->km_pelepasan,
                'status' => 'non aktif sementara',
                'status_pelepasan' => 'true',
                'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'pelepasan_ban_id' => $request->pelepasan_ban_id,
            ]);

            $detailBanData = $ban->toArray();
            $detailBanData['ban_id'] = $ban->id;

            Detail_ban::create($detailBanData);

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
                'status_pelepasan' => 'true',
                // 'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'status' => 'non aktif sementara',
                'pelepasan_ban_id' => $request->pelepasan_ban_id,
            ]);

            $detailBanData = $ban->toArray();
            $detailBanData['ban_id'] = $ban->id;

            Detail_ban::create($detailBanData);

            Km_ban::create([
                'ban_id' => $banId,
                'kendaraan_id' => $request->kendaraan_id,
                'pemasangan_ban_id' => $ban->pemasangan_ban_id,
                'pelepasan_ban_id' => $request->pelepasan_ban_id,
                'status' => 'non aktif sementara',
                'umur_ban' => $request->km_terpakai + ($ban->jumlah_km ?? 0),
            ]);
        } else {
            $kendaraan = Kendaraan::findOrFail($id);
            $banId = $request->id_ban;
            $ban = Ban::find($banId);

            if (!$ban) {
                return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
            }

            $pelepasan = Pelepasan_ban::findOrFail($request->pelepasan_ban_id);
            $ban->update([
                'keterangan' => $request->keterangan,
                'km_pelepasan' => $request->km_pelepasan,
                'jumlah_km' => $request->km_pelepasan - $ban->km_pemasangan,
                'km_terpakai' => $request->km_terpakai,
                'pelepasan_ban_id' => $pelepasan->id,
                'status' => 'non aktif sementara',
                'status_pelepasan' => 'true',
                'pelepasan_ban_id' => $request->pelepasan_ban_id,
            ]);

            $detailBanData = $ban->toArray();
            $detailBanData['ban_id'] = $ban->id;

            Detail_ban::create($detailBanData);
        }

        return redirect()->back()->withInput()->with('success', 'Berhasil menambahkan Pelepasan');
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