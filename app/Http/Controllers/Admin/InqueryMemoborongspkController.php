<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Biaya_tambahan;
use App\Models\Deposit_driver;
use App\Models\Detail_faktur;
use App\Models\Detail_notabon;
use App\Models\Detail_pengeluaran;
use App\Models\Detail_potongan;
use App\Models\Detail_tambahan;
use App\Models\Faktur_ekspedisi;
use App\Models\Jarak_km;
use App\Models\Kendaraan;
use App\Models\Memo_ekspedisi;
use App\Models\Memotambahan;
use App\Models\Notabon_ujs;
use App\Models\Pengambilan_do;
use App\Models\Pengeluaran_kaskecil;
use App\Models\Potongan_memo;
use App\Models\Rute_perjalanan;
use App\Models\Saldo;
use App\Models\Spk;
use App\Models\Total_ujs;
use App\Models\Uangjaminan;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class InqueryMemoborongspkController extends Controller
{
    public function index(Request $request)
    {
        Memo_ekspedisi::where('status', 'posting')->update(['status_notif' => true]);

        $kategori = $request->kategori;
        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        if ($kategori === 'Memo Tambahan') {
            $inquery = Memotambahan::query();
        } else {
            $inquery = Memo_ekspedisi::query();
        }

        if ($kategori) {
            $inquery->where('kategori', $kategori);
        }

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
            $inquery->whereDate('tanggal_awal', Carbon::today());
        }

        $inquery->orderBy('id', 'DESC');
        $inquery = $inquery->get();

        $saldoTerakhir = Saldo::latest()->first();

        if ($kategori === 'Memo Perjalanan') {
            $memoekspedisi = Memo_ekspedisi::get();
            $memoekspedisiJson = json_encode($memoekspedisi);
            return view('admin.inquery_memoekspedisi.index', compact('memoekspedisiJson', 'saldoTerakhir', 'inquery'));
        } elseif ($kategori === 'Memo Borong') {
            return view('admin.inquery_memoborong.index', compact('inquery', 'saldoTerakhir'));
        } elseif ($kategori === 'Memo Tambahan') {
            return view('admin.inquery_memotambahan.index', compact('inquery', 'saldoTerakhir'));
        } else {
            return view('admin.inquery_memoborong.index', compact('inquery', 'saldoTerakhir'));
        }
    }


    public function edit($id)
    {

        $inquery = Memo_ekspedisi::where('id', $id)->first();
        // $kendaraans = Kendaraan::all();

        $spks = Spk::where(
            'voucher',
            '<',
            2
        )
            ->where(function ($query) {
                $query->where('status_spk', '!=', 'faktur')
                    ->where('status_spk', '!=', 'invoice')
                    ->where('status_spk', '!=', 'pelunasan')
                    ->orWhereNull('status_spk');
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // $drivers = User::whereHas('karyawan', function ($query) {
        //     $query->where('departemen_id', '2');
        // })->get();
        $ruteperjalanans = Rute_perjalanan::all();
        $biayatambahan = Biaya_tambahan::all();
        $potonganmemos = Potongan_memo::all();
        $saldoTerakhir = Saldo::latest()->first();
        $detailstambahan = Detail_tambahan::where('memo_ekspedisi_id', $id)->get();
        $detailnotas = Detail_notabon::where('memo_ekspedisi_id', $id)->get();
        $details = Detail_potongan::where('memo_ekspedisi_id', $id)->get();
        $memos = Memo_ekspedisi::all();
        $notas = Notabon_ujs::where(['status' => 'posting'])->get();
        return view('admin.inquery_memoborongspk.update', compact(
            'inquery',
            'potonganmemos',
            'biayatambahan',
            'details',
            'ruteperjalanans',
            'memos',
            'detailstambahan',
            'spks',
            'detailnotas',
            'notas',
            'saldoTerakhir'
        ));
    }

    public function update(Request $request, $id)
    {
        // $jarak = Jarak_km::first(); // Mendapatkan jarak yang akan digunakan untuk validasi
        $validasi_pelanggan = Validator::make(
            $request->all(),
            [
                'spk_id' => 'required',
                'kategori' => 'required',
                'kendaraan_id' => 'required',
                'user_id' => 'required',
                'sub_total' => 'required',
                'jumlah' => 'required',
                'satuan' => 'required',
                'harga_rute' => ['nullable', function ($attribute, $value, $fail) {
                    $numericValue = preg_replace('/[^0-9]/', '', $value);
                    if (!is_numeric($numericValue)) {
                        $fail('Uang jalan harus berupa angka atau dalam format Rupiah yang valid.');
                    }
                }],
                // 'km_akhir' => [
                //     'required',
                //     'numeric',
                //     function ($attribute, $value, $fail) use ($request, $jarak) {
                //         $kendaraan = Kendaraan::find($request->kendaraan_id); // Mendapatkan kendaraan berdasarkan ID
                //         if ($kendaraan && $value < $kendaraan->km) { // Hanya jika km_akhir lebih kecil dari km kendaraan
                //             $fail('Nilai km akhir harus lebih tinggi dari km awal');
                //         } elseif ($kendaraan && $value - $kendaraan->km > $jarak->batas) {
                //             $fail('Nilai km tidak boleh lebih dari ' . $jarak->batas . ' km dari km awal.');
                //         }
                //     },
                // ],
            ],
            [
                'spk_id.required' => 'Pilih spk',
                'kategori.required' => 'Pilih kategori',
                'kendaraan_id.required' => 'Pilih no kabin',
                'user_id.required' => 'Pilih driver',
                'sub_total.required' => 'Masukkan total harga',
                'jumlah.required' => 'Masukkan quantity',
                'satuan.required' => 'Pilih satuan',
                'harga_rute.*' => 'Uang jalan harus berupa angka atau dalam format Rupiah yang valid',
                // 'km_akhir.required' => 'Masukkan km akhir',
                // 'km_akhir.numeric' => 'Nilai km harus berupa angka',
            ]
        );


        $error_pelanggans = array();

        if ($validasi_pelanggan->fails()) {
            array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
        }

        $error_pesanans = array();
        $data_pembelians = collect();
        $data_pembelians4 = collect();
        $data_pembeliansnota = collect();


        if ($request->has('biaya_tambahan_id') || $request->has('kode_biaya') || $request->has('nama_biaya') || $request->has('nominal')) {
            for ($i = 0; $i < count($request->biaya_tambahan_id); $i++) {
                if (empty($request->biaya_tambahan_id[$i]) && empty($request->kode_biaya[$i]) && empty($request->nama_biaya[$i]) && empty($request->nominal[$i])) {
                    continue;
                }

                $validasi_produk = Validator::make($request->all(), [
                    'biaya_tambahan_id.' . $i => 'required',
                    'kode_biaya.' . $i => 'required',
                    'nama_biaya.' . $i => 'required',
                    'nominal.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Biaya tambahan  nomor " . ($i + 1) . " belum dilengkapi!");
                }

                $biaya_tambahan_id = $request->biaya_tambahan_id[$i] ?? '';
                $kode_biaya = $request->kode_biaya[$i] ?? '';
                $nama_biaya = $request->nama_biaya[$i] ?? '';
                $nominal = $request->nominal[$i] ?? '';

                $data_pembelians->push([
                    'detail_idd' => $request->detail_idss[$i] ?? null,
                    'biaya_tambahan_id' => $biaya_tambahan_id,
                    'kode_biaya' => $kode_biaya,
                    'nama_biaya' => $nama_biaya,
                    'nominal' => $nominal,

                ]);
            }
        }

        if ($request->has('potongan_memo_id') || $request->has('kode_potongan') || $request->has('keterangan_potongan') || $request->has('nominal_potongan')) {
            for ($i = 0; $i < count($request->potongan_memo_id); $i++) {
                if (empty($request->potongan_memo_id[$i]) && empty($request->kode_potongan[$i]) && empty($request->keterangan_potongan[$i]) && empty($request->nominal_potongan[$i])) {
                    continue;
                }

                $validasi_produk = Validator::make($request->all(), [
                    'potongan_memo_id.' . $i => 'required',
                    'kode_potongan.' . $i => 'required',
                    'keterangan_potongan.' . $i => 'required',
                    'nominal_potongan.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Potongan nomor " . ($i + 1) . " belum dilengkapi!");
                }

                $potongan_memo_id = $request->potongan_memo_id[$i] ?? '';
                $kode_potongan = $request->kode_potongan[$i] ?? '';
                $keterangan_potongan = $request->keterangan_potongan[$i] ?? '';
                $nominal_potongan = $request->nominal_potongan[$i] ?? '';

                $data_pembelians4->push([
                    'detail_id' => $request->detail_ids[$i] ?? null,
                    'potongan_memo_id' => $potongan_memo_id,
                    'kode_potongan' => $kode_potongan,
                    'keterangan_potongan' => $keterangan_potongan,
                    'nominal_potongan' => $nominal_potongan,

                ]);
            }
        }

        if ($request->has('notabon_ujs_id') || $request->has('kode_nota') || $request->has('nama_drivernota') || $request->has('nominal_nota')) {
            for ($i = 0; $i < count($request->notabon_ujs_id); $i++) {
                if (empty($request->notabon_ujs_id[$i]) && empty($request->kode_nota[$i]) && empty($request->nama_drivernota[$i]) && empty($request->nominal_nota[$i])) {
                    continue;
                }

                $validasi_produk = Validator::make($request->all(), [
                    'notabon_ujs_id.' . $i => 'required',
                    'kode_nota.' . $i => 'required',
                    'nama_drivernota.' . $i => 'required',
                    'nominal_nota.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Biaya tambahan nomor " . ($i + 1) . " belum dilengkapi!");
                }

                $notabon_ujs_id = $request->notabon_ujs_id[$i] ?? '';
                $kode_nota = $request->kode_nota[$i] ?? '';
                $nama_drivernota = $request->nama_drivernota[$i] ?? '';
                $nominal_nota = $request->nominal_nota[$i] ?? '';

                $data_pembeliansnota->push([
                    'detail_iddd' => $request->detail_idnotas[$i] ?? null,
                    'notabon_ujs_id' => $notabon_ujs_id,
                    'kode_nota' => $kode_nota,
                    'nama_drivernota' => $nama_drivernota,
                    'nominal_nota' => $nominal_nota,

                ]);
            }
        }

        if ($error_pelanggans || $error_pesanans) {
            return back()
                ->withInput()
                ->with('error_pelanggans', $error_pelanggans)
                ->with('error_pesanans', $error_pesanans)
                ->with('data_pembelians', $data_pembelians)
                ->with('data_pembelians4', $data_pembelians4);
        }

        $deposit = $request->depositsopir;

        if (!is_numeric($deposit)) {
            return back()->with('erorrss', 'Deposit harus berupa angka');
        }

        if ($validasi_pelanggan->fails()) {
            $errors = $validasi_pelanggan->errors()->all();
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

        // tgl indo
        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');
        $cetakpdf = Memo_ekspedisi::findOrFail($id);

        $totalrute = str_replace('.', '', $request->totalrute);
        $totalrute = str_replace(',', '.', $totalrute);

        $pphs = str_replace(',', '.', str_replace('.', '', $request->pphs));
        $pphs =  round($pphs);
        $notabons = str_replace('.', '', $request->nota_bons);

        $biaya_tambahan = str_replace('.', '', $request->biaya_tambahan);
        $biaya_tambahan = str_replace(',', '.', $biaya_tambahan);

        $potongan_memos = $request->potongan_memoborong;
        // Jika nilai kosong, setel menjadi 0
        if (empty($potongan_memos)) {
            $potongan_memos = 0;
        } else {
            // Menghilangkan titik dan mengganti koma dengan titik pada angka
            $potongan_memos = str_replace(',', '.', str_replace('.', '', $potongan_memos));
            $potongan_memos = str_replace(',', '.', $potongan_memos); // Pastikan format angka yang benar
        }

        $hasil_jumlah = ($totalrute - $pphs) / 2 + $biaya_tambahan - $potongan_memos - $notabons;

        $tanggal = Carbon::now()->format('Y-m-d');

        $spk_id = $request->spk_id;
        $spk = Spk::where('id', $spk_id)->first();
        $pengambilan_do = Pengambilan_do::where('spk_id', $spk->id)->first(); // Mengambil satu pengambilan_do

        $status_memo = 'rilis';
        if (
            $pengambilan_do && in_array($pengambilan_do->status, ['unpost', 'posting'])
        ) {
            $status_memo = 'rilis';
        } else {
            $status_memo = 'unpost';
        }

        $cetakpdf->update(
            [
                'spk_id' => $request->spk_id,
                'kategori' => $request->kategori,
                'kendaraan_id' => $request->kendaraan_id,
                'no_kabin' => $request->no_kabin,
                'no_pol' => $request->no_pol,
                'golongan' => $request->golongan,
                'km_awal' => $request->km_awal,
                'km_akhir' => $request->km_akhir,
                'user_id' => $request->user_id,
                'kode_driver' => $request->kode_driver,
                'nama_driver' => $request->nama_driver,
                'telp' => $request->telp,
                'pelanggan_id' => $request->pelanggan_id,
                'kode_pelanggan' => $request->kode_pelanggan,
                'nama_pelanggan' => $request->nama_pelanggan,
                'alamat_pelanggan' => $request->alamat_pelanggan,
                'telp_pelanggan' => $request->telp_pelanggan,
                'saldo_deposit' => str_replace(',', '.', str_replace('.', '', $request->saldo_deposit)),
                'biaya_tambahan' => $biaya_tambahan = is_null($request->biaya_tambahan) ? 0 : str_replace('.', '', $request->biaya_tambahan),
                'total_borongs' => str_replace(',', '.', str_replace('.', '', $request->total_borongs)),
                'pphs' => str_replace(',', '.', str_replace('.', '', $request->pphs)),
                'deposit_driver' => $request->depositsopir ? str_replace('.', '', $request->depositsopir) : 0,
                'deposit_drivers' => $request->depositsopir ? str_replace('.', '', $request->depositsopir) : 0,
                'totals' => str_replace(',', '.', str_replace('.', '', $request->totals)),
                'uang_jaminans' => str_replace(',', '.', str_replace('.', '', $request->uang_jaminans)),
                // 'potongan_memo' => str_replace(',', '.', str_replace('.', '', $request->potongan_memoborong)),
                'potongan_memo' => $potongan_memos = is_null($request->potongan_memoborong) ? 0 : str_replace('.', '', $request->potongan_memoborong),
                'sub_total' => str_replace(',', '.', str_replace('.', '', $request->sub_total)),
                'hasil_jumlah' => $hasil_jumlah,
                'keterangan' => $request->keterangan,
                'rute_perjalanan_id' => $request->rute_id,
                'kode_rute' => $request->kode_rutes,
                'nama_rute' => $request->nama_rutes,
                'harga_rute' => str_replace(',', '.', str_replace('.', '', $request->harga_rute)),
                'jumlah' => $request->jumlah,
                'satuan' => $request->satuan,
                'totalrute' => str_replace(',', '.', str_replace('.', '', $request->totalrute)),
                'nota_bons' => str_replace(',', '.', str_replace('.', '', $request->nota_bons)),
                'status' => $status_memo,

            ]
        );


        $transaksi_id = $cetakpdf->id;
        $detailIds = $request->input('detail_idnotas');
        $detailIds = $request->input('detail_idss');
        $detailIds = $request->input('detail_ids');

        foreach ($data_pembelians as $data_pesanan) {
            $detailId = $data_pesanan['detail_idd'];

            if ($detailId) {
                Detail_tambahan::where('id', $detailId)->update([
                    'memo_ekspedisi_id' => $cetakpdf->id,
                    'biaya_tambahan_id' => $data_pesanan['biaya_tambahan_id'],
                    'kode_biaya' => $data_pesanan['kode_biaya'],
                    'nama_biaya' => $data_pesanan['nama_biaya'],
                    'nominal' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['nominal'])),

                ]);
            } else {
                $existingDetail = Detail_tambahan::where([
                    'memo_ekspedisi_id' => $cetakpdf->id,
                    'biaya_tambahan_id' => $data_pesanan['biaya_tambahan_id'],
                    'kode_biaya' => $data_pesanan['kode_biaya'],
                    'nama_biaya' => $data_pesanan['nama_biaya'],
                    'nominal' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['nominal'])),
                ])->first();


                if (!$existingDetail) {
                    Detail_tambahan::create([
                        'memo_ekspedisi_id' => $cetakpdf->id,
                        'biaya_tambahan_id' => $data_pesanan['biaya_tambahan_id'],
                        'kode_biaya' => $data_pesanan['kode_biaya'],
                        'nama_biaya' => $data_pesanan['nama_biaya'],
                        'nominal' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['nominal'])),
                    ]);
                }
            }
        }

        foreach ($data_pembelians4 as $data_pesanan) {
            $detailId = $data_pesanan['detail_id'];

            if ($detailId) {
                Detail_potongan::where('id', $detailId)->update([
                    'memo_ekspedisi_id' => $cetakpdf->id,
                    'potongan_memo_id' => $data_pesanan['potongan_memo_id'],
                    'kode_potongan' => $data_pesanan['kode_potongan'],
                    'keterangan_potongan' => $data_pesanan['keterangan_potongan'],
                    'nominal_potongan' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['nominal_potongan'])),
                ]);
            } else {
                $existingDetail = Detail_potongan::where([
                    'memo_ekspedisi_id' => $cetakpdf->id,
                    'potongan_memo_id' => $data_pesanan['potongan_memo_id'],
                    'kode_potongan' => $data_pesanan['kode_potongan'],
                    'keterangan_potongan' => $data_pesanan['keterangan_potongan'],
                    'nominal_potongan' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['nominal_potongan'])),
                ])->first();


                if (!$existingDetail) {
                    Detail_potongan::create([
                        'memo_ekspedisi_id' => $cetakpdf->id,
                        'potongan_memo_id' => $data_pesanan['potongan_memo_id'],
                        'kode_potongan' => $data_pesanan['kode_potongan'],
                        'keterangan_potongan' => $data_pesanan['keterangan_potongan'],
                        'nominal_potongan' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['nominal_potongan'])),
                    ]);
                }
            }
        }

        foreach ($data_pembeliansnota as $data_pesanan) {
            $detailId = $data_pesanan['detail_iddd'];

            if ($detailId) {
                $detail = Detail_notabon::where('id', $detailId)->update([
                    'memo_ekspedisi_id' => $cetakpdf->id,
                    'notabon_ujs_id' => $data_pesanan['notabon_ujs_id'],
                    'kode_nota' => $data_pesanan['kode_nota'],
                    'nama_drivernota' => $data_pesanan['nama_drivernota'],
                    'nominal_nota' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['nominal_nota'])),
                ]);
                // $nota = Notabon_ujs::find($detail->notabon_ujs_id);
                // if ($nota) {
                //     $nota->update(['status_memo' => 'aktif']);
                // }
            } else {
                $existingDetail = Detail_notabon::where([
                    'memo_ekspedisi_id' => $cetakpdf->id,
                    'notabon_ujs_id' => $data_pesanan['notabon_ujs_id'],
                    'kode_nota' => $data_pesanan['kode_nota'],
                    'nama_drivernota' => $data_pesanan['nama_drivernota'],
                    'nominal_nota' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['nominal_nota'])),
                ])->first();


                if (!$existingDetail) {
                    $detail =  Detail_notabon::create([
                        'memo_ekspedisi_id' => $cetakpdf->id,
                        'notabon_ujs_id' => $data_pesanan['notabon_ujs_id'],
                        'kode_nota' => $data_pesanan['kode_nota'],
                        'nama_drivernota' => $data_pesanan['nama_drivernota'],
                        'nominal_nota' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['nominal_nota'])),
                    ]);
                    // $nota = Notabon_ujs::find($detail->notabon_ujs_id);
                    // if ($nota) {
                    //     $nota->update(['status_memo' => 'aktif']);
                    // }
                }
            }
        }

        $pengeluaran = Pengeluaran_kaskecil::where('memo_ekspedisi_id', $id)->first();
        $pengeluaran->update(
            [
                'kendaraan_id' => $request->kendaraan_id,
                'keterangan' => $request->keterangan,
                'grand_total' => $hasil_jumlah,
            ]
        );

        $detailpengeluaran = Detail_pengeluaran::where('memo_ekspedisi_id', $id)->first();
        $detailpengeluaran->update(
            [
                'keterangan' => $request->keterangan,
                'nominal' => $hasil_jumlah,
            ]
        );

        $uangjaminan = Uangjaminan::where('memo_ekspedisi_id', $id)->first();
        $uangjaminan->update(
            [
                'memo_ekspedisi_id' => $cetakpdf->id,
                'nama_sopir' => $request->nama_driver,
                'keterangan' => $request->keterangan,
                'nominal' => str_replace(',', '.', str_replace('.', '', $request->uang_jaminans)),
            ]
        );
        $detail_nota = Detail_notabon::where('memo_ekspedisi_id', $cetakpdf->id)->get();

        return view('admin.inquery_memoborong.show', compact('cetakpdf', 'detail_nota'));
    }


    public function cetak_memoborongfilter(Request $request)
    {
        $selectedIds = explode(',', $request->input('ids'));
        $memos = Memo_ekspedisi::whereIn('id', $selectedIds)->orderBy('id', 'DESC')->get();

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('admin.inquery_memoborong.cetak_pdffilter', compact('memos'));
        $pdf->setPaper('landscape');

        return $pdf->stream('SelectedMemoBorong.pdf');
    }
    public function show($id)
    {
        $cetakpdf = Memo_ekspedisi::where('id', $id)->first();
        $detail_nota = Detail_notabon::where('memo_ekspedisi_id', $cetakpdf->id)->get();

        return view('admin.inquery_memoborong.show', compact('cetakpdf', 'detail_nota'));
    }

    public function postingmemoborong($id)
    {
        try {
            $item = Memo_ekspedisi::findOrFail($id);
            $user = $item->user;
            $postedCount = Memo_ekspedisi::where('nama_driver', $item->nama_driver)
                ->where('status', 'posting')
                ->count();
            if ($postedCount >= 3) {
                return response()->json(['error' => 'Memo Borong telah mencapai batas maksimal']);
            }
            $BiayaTambahan = $item->hasil_jumlah;
            $lastSaldo = Saldo::latest()->first();
            $lastUjs = Total_ujs::latest()->first();

            if (!$lastSaldo) {
                return back()->with('error', 'Saldo tidak ditemukan');
            }

            if ($lastSaldo->sisa_saldo < $BiayaTambahan) {
                return back()->with('error', 'Saldo tidak mencukupi');
            }

            if (!$lastUjs) {
                return back()->with('error', 'Ujs tidak ditemukan');
            }

            $sisaSaldo = $lastSaldo->sisa_saldo - $BiayaTambahan;
            Saldo::create([
                'sisa_saldo' => $sisaSaldo,
            ]);

            $uangUjs = $item->uang_jaminans;
            $uangUjs = round($uangUjs);

            $sisaUjs = $lastUjs->sisa_ujs + $uangUjs;
            Total_ujs::create([
                'sisa_ujs' => $sisaUjs,
            ]);

            $user = $item->user;

            if (!$user) {
                return back()->with('error', 'User tidak ditemukan');
            }

            $karyawan = $user->karyawan;

            if (!$karyawan) {
                return back()->with('error', 'Karyawan tidak ditemukan');
            }

            $tabungans = $karyawan->tabungan;
            $deposits = $karyawan->deposit;

            $karyawan->update([
                'tabungan' => $tabungans + $item->deposit_driver,
                'deposit' => $deposits + $item->deposit_driver,
            ]);

            $depositDriverRecord = Deposit_driver::where('memo_ekspedisi_id', $item->id)->first();

            if ($depositDriverRecord) {
                $depositDriverRecord->update([
                    'sub_total' => $tabungans + $item->deposit_driver,
                    'nominal' => $item->deposit_driver,
                    'sisa_saldo' => $tabungans + $item->deposit_driver,
                    'status' => 'posting memo',
                ]);
            } else {
                Deposit_driver::create([
                    'kode_deposit' => $this->kodedeposit(),
                    'kategori' => 'Pemasukan Deposit',
                    'memo_ekspedisi_id' => $item->id,
                    'nama_sopir' => $item->nama_driver,
                    'sub_total' => $tabungans + $item->deposit_driver,
                    'nominal' => $item->deposit_driver,
                    'saldo_masuk' => $item->deposit_driver,
                    'keterangan' => "Deposit Memo",
                    'sisa_saldo' => $tabungans + $item->deposit_driver,
                    'tanggal' => now()->format('d F Y'),
                    'tanggal_awal' => now()->format('Y-m-d'),
                    'status' => 'posting memo',
                ]);
            }

            Pengeluaran_kaskecil::where('memo_ekspedisi_id', $id)->update([
                'status' => 'posting'
            ]);

            Detail_pengeluaran::where('memo_ekspedisi_id', $id)->update([
                'status' => 'posting'
            ]);

            Spk::where('id', $item->spk_id)->update(['status_spk' => 'memo', 'status' => 'selesai']);

            $detailnotes = Detail_notabon::where('memo_ekspedisi_id', $item->id)->get();

            foreach ($detailnotes as $detail) {
                $nota_bon = Notabon_ujs::where('id', $detail->notabon_ujs_id)
                    ->where('status', 'posting')
                    ->first();

                if ($nota_bon) {
                    $nota_bon->update([
                        'status_memo' => 'aktif',
                        'status' => 'selesai'
                    ]);
                }
            }

            $item->update([
                'status' => 'posting'
            ]);

            Uangjaminan::where('memo_ekspedisi_id', $id)->update([
                'status' => 'posting'
            ]);

            return response()->json(['success' => 'Berhasil memposting memo']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Gagal memposting memo: Memo tidak ditemukan']);
        }
    }

    public function unpostmemoborong($id)
    {
        try {
            $item = Memo_ekspedisi::findOrFail($id);
            $BiayaTambahan = $item->hasil_jumlah;

            $lastSaldo = Saldo::latest()->first();
            if (!$lastSaldo) {
                return back()->with('error', 'Saldo tidak ditemukan');
            }
            $sisaSaldo = $lastSaldo->sisa_saldo + $BiayaTambahan;

            Saldo::create([
                'sisa_saldo' => $sisaSaldo,
            ]);

            $user = $item->user;
            $karyawan = $user->karyawan;

            $tabungans = $karyawan->tabungan;
            $deposits = $karyawan->deposit;
            $karyawan->update([
                'tabungan' => $tabungans - $item->deposit_driver,
                'deposit' => $deposits - $item->deposit_driver,
            ]);

            $lastUjs = Total_ujs::latest()->first();

            if (!$lastUjs) {
                return back()->with('error', 'Ujs tidak ditemukan');
            }

            $uangUjs = $item->uang_jaminans;
            $uangUjs = round($uangUjs);
            $sisaUjs = $lastUjs->sisa_ujs - $uangUjs;
            Total_ujs::create([
                'sisa_ujs' => $sisaUjs,
            ]);

            Pengeluaran_kaskecil::where('memo_ekspedisi_id', $id)->update([
                'status' => 'pending',
            ]);

            Detail_pengeluaran::where('memo_ekspedisi_id', $id)->update([
                'status' => 'pending'
            ]);

            Uangjaminan::where('memo_ekspedisi_id', $id)->update([
                'status' => 'pending'
            ]);

            $depositdriver = Deposit_driver::where('memo_ekspedisi_id', $id)->first();
            $depositdriver->update([
                'sub_total' => $tabungans - $item->deposit_driver,
                'nominal' => $item->deposit_driver,
                'sisa_saldo' => $tabungans - $item->deposit_driver,
                'status' => 'pending',
            ]);

            Spk::where('id', $item->spk_id)->update(['status_spk' => null, 'status' => 'posting']);

            $detailnotes = Detail_notabon::where('memo_ekspedisi_id', $item->id)->get();

            foreach ($detailnotes as $detail) {
                $nota_bon = Notabon_ujs::where('id', $detail->notabon_ujs_id)
                    ->where('status', 'selesai')
                    ->first();

                if ($nota_bon) {
                    $nota_bon->update([
                        'status_memo' => null,
                        'status' => 'posting',
                    ]);
                }
            }

            $item->update([
                'status' => 'unpost',
            ]);

            return back()->with('success', 'Berhasil');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        }
    }

    public function postingmemoborongfilter(Request $request)
    {
        $selectedIds = array_reverse(explode(',', $request->input('ids')));

        try {
            $totalDeduction = 0;
            $totalDeductionujs = 0;

            foreach ($selectedIds as $id) {
                $driverName = Memo_ekspedisi::findOrFail($id)->nama_driver;
                $postedCount = Memo_ekspedisi::where('nama_driver', $driverName)
                    ->where('status', 'posting')
                    ->count();
                if ($postedCount >= 3) {
                    continue;
                }

                $item = Memo_ekspedisi::findOrFail($id);

                if ($item->status === 'unpost' && $item->kategori === 'Memo Borong') {
                    $totalDeduction += $item->hasil_jumlah;

                    $uangUjs = $item->uang_jaminans;
                    $uangUjs = round($uangUjs);

                    $totalDeductionujs += $uangUjs;
                }
            }
            $lastSaldo = Saldo::latest()->first();
            $lastUjs = Total_ujs::latest()->first();

            if (!$lastSaldo) {
                return back()->with('error', 'Saldo tidak ditemukan');
            }
            if ($lastSaldo->sisa_saldo < $totalDeduction) {
                return back()->with('error', 'Saldo tidak mencukupi');
            }
            $totalUangJalanRequest = array_reduce($selectedIds, function ($carry, $id) {
                $item = Memo_ekspedisi::findOrFail($id);
                return $carry + $item->hasil_jumlah;
            }, 0);

            if ($lastSaldo->sisa_saldo < $totalUangJalanRequest) {
                return back()->with('error', 'Total request uang jalan melebihi saldo terakhir');
            }
            foreach ($selectedIds as $id) {
                $item = Memo_ekspedisi::findOrFail($id);
                $postedCount = Memo_ekspedisi::where('nama_driver', $item->nama_driver)
                    ->where('status', 'posting')
                    ->count();
                if ($postedCount >= 3 && $item->status !== 'posting') {
                    continue;
                }

                if ($item->status === 'unpost' && $item->kategori === 'Memo Borong') {
                    $user = $item->user;

                    $uangJalan = $item->uang_jalan;
                    $BiayaTambahan = $item->biaya_tambahan;
                    $PotonganMemo = $item->potongan_memo;

                    $karyawan = $user->karyawan;

                    $tabungans = $karyawan->tabungan;
                    $deposits = $karyawan->deposit;
                    $karyawan->update([
                        'deposit' => $deposits + $item->deposit_driver,
                        'tabungan' => $tabungans + $item->deposit_driver,
                    ]);

                    Pengeluaran_kaskecil::where('memo_ekspedisi_id', $id)->update([
                        'status' => 'posting'
                    ]);

                    Detail_pengeluaran::where('memo_ekspedisi_id', $id)->update([
                        'status' => 'posting'
                    ]);

                    Uangjaminan::where('memo_ekspedisi_id', $id)->update([
                        'status' => 'posting'
                    ]);

                    $tanggal1 = Carbon::now('Asia/Jakarta');
                    $format_tanggal = $tanggal1->format('d F Y');
                    $kodedeposit = $this->kodedeposit();
                    $tanggal = Carbon::now()->format('Y-m-d');
                    $depositDriverRecord = Deposit_driver::where('memo_ekspedisi_id', $item->id)->first();

                    if ($depositDriverRecord) {
                        $depositDriverRecord->update([
                            'sub_total' => $tabungans + $item->deposit_driver,
                            'nominal' => $item->deposit_driver,
                            'sisa_saldo' => $tabungans + $item->deposit_driver,
                            'status' => 'posting memo',
                        ]);
                    } else {
                        Deposit_driver::create([
                            'kode_deposit' => $this->kodedeposit(),
                            'kategori' => 'Pemasukan Deposit',
                            'memo_ekspedisi_id' => $item->id,
                            'nama_sopir' => $item->nama_driver,
                            'sub_total' => $tabungans + $item->deposit_driver,
                            'nominal' => $item->deposit_driver,
                            'saldo_masuk' => $item->deposit_driver,
                            'keterangan' => "Deposit Memo",
                            'sisa_saldo' => $tabungans + $item->deposit_driver,
                            'tanggal' => $format_tanggal,
                            'tanggal_awal' => $tanggal,
                            'status' => 'posting memo',
                        ]);
                    }

                    $spk = Spk::where('id', $item->spk_id)->first();
                    if ($spk) {
                        $spk->update(['status_spk' => 'memo', 'status' => 'selesai']);
                    }

                    $detailnotes = Detail_notabon::where('memo_ekspedisi_id', $item->id)->get();

                    foreach ($detailnotes as $detail) {
                        $nota_bon = Notabon_ujs::where('id', $detail->notabon_ujs_id)
                            ->where('status', 'posting')
                            ->first();

                        if ($nota_bon) {
                            $nota_bon->update([
                                'status_memo' => 'aktif',
                                'status' => 'selesai',
                            ]);
                        }
                    }

                    $item->update([
                        'status' => 'posting'
                    ]);
                    $lastSaldo->update([
                        'sisa_saldo' => $lastSaldo->sisa_saldo - ($item->hasil_jumlah)
                    ]);

                    $lastUjs->update([
                        $uangUjs = $item->uang_jaminans,
                        $uangUjs = round($uangUjs),
                        'sisa_ujs' => $lastUjs->sisa_ujs + ($uangUjs)
                    ]);
                }
            }

            return back()->with('success', 'Berhasil memposting memo yang dipilih');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return back()->with('error', 'Terdapat memo yang tidak ditemukan');
        }
    }

    public function unpostmemoborongfilter(Request $request)
    {
        $selectedIds = array_reverse(explode(',', $request->input('ids')));

        try {
            $totalDeduction = 0;
            $totalDeductionujs = 0;

            foreach ($selectedIds as $id) {
                $item = Memo_ekspedisi::findOrFail($id);
                if ($item->status === 'posting') {
                    $totalDeduction += $item->hasil_jumlah;
                    $uangUjs = $item->uang_jaminans;
                    $uangUjs = round($uangUjs);
                    $totalDeductionujs += $uangUjs;
                }
            }
            $lastSaldo = Saldo::latest()->first();
            $lastUjs = Total_ujs::latest()->first();

            if (!$lastSaldo) {
                return back()->with('error', 'Saldo tidak ditemukan');
            }
            $totalUangJalanRequest = array_reduce($selectedIds, function ($carry, $id) {
                $item = Memo_ekspedisi::findOrFail($id);
                return $carry + $item->hasil_jumlah;
            }, 0);

            foreach ($selectedIds as $id) {
                $item = Memo_ekspedisi::findOrFail($id);

                if ($item->status === 'posting') {
                    $user = $item->user;

                    $uangJalan = $item->uang_jalan;
                    $BiayaTambahan = $item->biaya_tambahan;
                    $PotonganMemo = $item->potongan_memo;

                    $karyawan = $user->karyawan;

                    $tabungans = $karyawan->tabungan;
                    $deposits = $karyawan->deposit;
                    $karyawan->update([
                        'deposit' => $deposits - $item->deposit_driver,
                        'tabungan' => $tabungans - $item->deposit_driver,
                    ]);

                    Pengeluaran_kaskecil::where('memo_ekspedisi_id', $id)->update([
                        'status' => 'pending'
                    ]);

                    Detail_pengeluaran::where('memo_ekspedisi_id', $id)->update([
                        'status' => 'pending'
                    ]);

                    Uangjaminan::where('memo_ekspedisi_id', $id)->update([
                        'status' => 'unpost'
                    ]);

                    $tanggal1 = Carbon::now('Asia/Jakarta');

                    $depositDriverRecord = Deposit_driver::where('memo_ekspedisi_id', $item->id)->first();

                    if ($depositDriverRecord) {
                        $depositDriverRecord->update([
                            'status' => 'pending',
                        ]);
                    }
                    $spk = Spk::where(
                        'id',
                        $item->spk_id
                    )->first();
                    if ($spk) {
                        $spk->update(['status_spk' => null, 'status' => 'posting']);
                    }

                    $detailnotes = Detail_notabon::where('memo_ekspedisi_id', $item->id)->get();

                    foreach ($detailnotes as $detail) {
                        $nota_bon = Notabon_ujs::where('id', $detail->notabon_ujs_id)
                            ->where('status', 'selesai')
                            ->first();

                        if ($nota_bon) {
                            $nota_bon->update([
                                'status_memo' => null,
                                'status' => 'posting',
                            ]);
                        }
                    }

                    $item->update([
                        'status' => 'unpost'
                    ]);

                    $lastSaldo->update([
                        'sisa_saldo' => $lastSaldo->sisa_saldo + ($item->hasil_jumlah)
                    ]);

                    $lastUjs->update([
                        $uangUjs = $item->uang_jaminans,
                        $uangUjs = round($uangUjs),
                        'sisa_ujs' => $lastUjs->sisa_ujs - ($uangUjs)
                    ]);
                }
            }

            return;

            return back()->with('success', 'Berhasil memposting memo yang dipilih');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return back()->with('error', 'Terdapat memo yang tidak ditemukan');
        }
    }

    public function unpostmemoborongselesai($id)
    {
        try {
            $item = Memo_ekspedisi::findOrFail($id);

            $uangJalan = $item->totalrute;
            $lastSaldo = Saldo::latest()->first();

            if (!$lastSaldo) {
                return back()->with('error', 'Saldo tidak ditemukan');
            }

            $sisaSaldo = $lastSaldo->sisa_saldo + $uangJalan;

            Saldo::create([
                'sisa_saldo' => $sisaSaldo,
            ]);

            $user = $item->user;

            if (!$user) {
                return back()->with('error', 'User tidak ditemukan');
            }

            $karyawan = $user->karyawan;

            if (!$karyawan) {
                return back()->with('error', 'Karyawan tidak ditemukan');
            }

            $tabungans = $karyawan->tabungan;
            $deposits = $karyawan->deposit;

            $karyawan->update([
                'tabungan' => $tabungans - $item->deposit_driver,
                'deposit' => $deposits - $item->deposit_driver,
            ]);

            Pengeluaran_kaskecil::where('memo_ekspedisi_id', $id)->update([
                'status' => 'pending',
            ]);

            Detail_pengeluaran::where('memo_ekspedisi_id', $id)->update([
                'status' => 'pending'
            ]);

            Uangjaminan::where('memo_ekspedisi_id', $id)->update([
                'status' => 'pending'
            ]);

            $depositdriver = Deposit_driver::where('memo_ekspedisi_id', $id)->first();
            $depositdriver->update([
                'sub_total' => $tabungans - $item->deposit_driver,
                'nominal' => $item->deposit_driver,
                'sisa_saldo' => $tabungans - $item->deposit_driver,
                'status' => 'pending',
            ]);

            $detail_faktur = Detail_faktur::where('memo_ekspedisi_id', $id)->first();

            if ($detail_faktur) {
                $faktur_id = $detail_faktur->faktur_ekspedisi_id;

                Faktur_ekspedisi::where('id', $faktur_id)->update([
                    'status' => 'unpost',
                ]);

                $item->update([
                    'status' => 'unpost',
                    'status_memo' => null,
                ]);

                return back()->with('success', 'Berhasil');
            } else {
                return back()->with('error', 'Detail Faktur not found for the given ID');
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        }
    }

    public function kodedeposit()
    {
        $penerimaan = Deposit_driver::all();
        if ($penerimaan->isEmpty()) {
            $num = "000001";
        } else {
            $id = Deposit_driver::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'FD';
        $kode_penerimaan = $data . $num;
        return $kode_penerimaan;
    }


    public function hapusmemoborong($id)
    {
        $memo = Memo_ekspedisi::where('id', $id)->first();
        $memo->deposit_driver()->delete();
        $memo->pengeluaran_kaskecil()->delete();
        $memo->detail_pengeluaran()->delete();
        $memo->uangjaminan()->delete();
        $memo->detail_tambahan()->delete();
        $memo->detail_potongan()->delete();
        $memo->delete();
        return back()->with('success', 'Berhasil');
    }

    public function destroy($id)
    {
        $ban = Memo_ekspedisi::find($id);
        $ban->delete();
        return redirect('admin/inquery_memoborong')->with('success', 'Berhasil memperbarui memo borong');
    }
}
