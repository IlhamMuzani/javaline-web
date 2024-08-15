<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Detail_faktur;
use App\Models\Detail_tariftambahan;
use App\Models\Faktur_ekspedisi;
use App\Models\Karyawan;
use App\Models\Kendaraan;
use App\Models\Memo_ekspedisi;
use App\Models\Memotambahan;
use App\Models\Pelanggan;
use App\Models\Pph;
use App\Models\Spk;
use App\Models\Tarif;
use Illuminate\Support\Facades\Validator;

class InqueryFakturekspedisispkController extends Controller
{
    public function index(Request $request)
    {
        Faktur_ekspedisi::where([
            ['status', 'posting']
        ])->update([
            'status_notif' => true
        ]);

        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $inquery = Faktur_ekspedisi::query();

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
        return view('admin.inquery_fakturekspedisispk.index', compact('inquery'));
    }

    public function edit($id)
    {
        $pelanggans = Pelanggan::all();
        $memoEkspedisi = Memo_ekspedisi::whereHas('spk', function ($query) {
            $query->where('status_spk', 'sj');
        })->where(['status_memo' => null, 'status' => 'posting'])->get();
        $memoTambahan = Memotambahan::where(['status_memo' => null, 'status' => 'posting'])->get();
        $memos = $memoEkspedisi->concat($memoTambahan);
        $tarifs = Tarif::all();
        $inquery = Faktur_ekspedisi::where('id', $id)->first();
        $details = Detail_faktur::where('faktur_ekspedisi_id', $id)->get();
        $detailtarifs = Detail_tariftambahan::where('faktur_ekspedisi_id', $id)->get();
        $kendaraans = Kendaraan::get();
        $karyawans = Karyawan::select('id', 'kode_karyawan', 'nama_lengkap', 'alamat', 'telp')
        ->where('departemen_id', '4')
        ->orderBy('nama_lengkap')
        ->get();
        
        $spks = Spk::where('status_spk', 'sj')->get();
        return view('admin.inquery_fakturekspedisispk.update', compact('karyawans', 'spks', 'kendaraans', 'memoEkspedisi', 'memoTambahan', 'detailtarifs', 'details', 'inquery', 'pelanggans', 'memos', 'tarifs'));
    }

    public function update(Request $request, $id)
    {
        $validasi_pelanggan = Validator::make(
            $request->all(),
            [
                'kategori' => 'required',
                'pelanggan_id' => [
                    'required_without:vendor_id',
                    'nullable',
                ],
                'vendor_id' => [
                    'required_without:pelanggan_id',
                    'nullable',
                ],
                'tarif_id' => 'required',
                'jumlah' => 'required|numeric',
                'satuan' => 'required',
                // 'karyawan_id' => 'required',
            ],
            [
                'kategori.required' => 'Pilih kategori',
                // 'karyawan_id.required' => 'Pilih karyawan',
                'pelanggan_id.required_without' => 'Pilih Pelanggan atau Vendor, tetapi tidak keduanya',
                'vendor_id.required_without' => 'Pilih Pelanggan atau Vendor, tetapi tidak keduanya',
                'tarif_id.required' => 'Pilih Tarif',
                'jumlah.required' => 'Masukkan Qty',
                'jumlah.numeric' => 'Qty harus berupa angka',
                'satuan.required' => 'Pilih satuan',
            ]
        );


        $error_pelanggans = array();

        if ($validasi_pelanggan->fails()) {
            array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
        }

        $error_pesanans = array();
        $data_pembelians = collect();
        $data_pembelians4 = collect();

        if ($request->has('memo_ekspedisi_id') || $request->has('kode_memo') || $request->has('nama_driver') || $request->has('telp_driver') || $request->has('nama_rute') || $request->has('kendaraan_id') || $request->has('no_kabin') || $request->has('no_pol')) {
            for ($i = 0; $i < count($request->memo_ekspedisi_id); $i++) {
                if (empty($request->memo_ekspedisi_id[$i]) && empty($request->kode_memo[$i]) && empty($request->nama_driver[$i]) && empty($request->telp_driver[$i]) && empty($request->nama_rute[$i]) && empty($request->kendaraan_id[$i]) && empty($request->no_kabin[$i]) && empty($request->no_pol[$i])) {
                    continue;
                }

                $validasi_produk = Validator::make($request->all(), [
                    'memo_ekspedisi_id.' . $i => 'required',
                    'kode_memo.' . $i => 'required',
                    'nama_driver.' . $i => 'required',
                    'nama_rute.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Memo nomor " . ($i + 1) . " belum dilengkapi!");
                }

                $memo_ekspedisi_id = $request->memo_ekspedisi_id[$i] ?? '';
                $kode_memo = $request->kode_memo[$i] ?? '';
                $tanggal_memo = $request->tanggal_memo[$i] ?? '';
                $nama_driver = $request->nama_driver[$i] ?? '';
                $telp_driver = $request->telp_driver[$i] ?? '';
                $nama_rute = $request->nama_rute[$i] ?? '';
                $kendaraan_id = $request->kendaraan_id[$i] ?? '';
                $no_kabin = $request->no_kabin[$i] ?? '';
                $no_pol = $request->no_pol[$i] ?? '';
                $memotambahan_id = $request->memotambahan_id[$i] ?? '';
                $kode_memotambahan = $request->kode_memotambahan[$i] ?? '';
                $tanggal_memotambahan = $request->tanggal_memotambahan[$i] ?? '';
                $nama_drivertambahan = $request->nama_drivertambahan[$i] ?? '';
                $nama_rutetambahan = $request->nama_rutetambahan[$i] ?? '';
                $kode_memotambahans = $request->kode_memotambahans[$i] ?? '';
                $tanggal_memotambahans = $request->tanggal_memotambahans[$i] ?? '';
                $nama_drivertambahans = $request->nama_drivertambahans[$i] ?? '';
                $nama_rutetambahans = $request->nama_rutetambahans[$i] ?? '';

                $data_pembelians->push([
                    'detail_id' => $request->detail_ids[$i] ?? null,
                    'memo_ekspedisi_id' => $memo_ekspedisi_id,
                    'kode_memo' => $kode_memo,
                    'tanggal_memo' => $tanggal_memo,
                    'nama_driver' => $nama_driver,
                    'telp_driver' => $telp_driver,
                    'nama_rute' => $nama_rute,
                    'kendaraan_id' => $kendaraan_id,
                    'no_kabin' => $no_kabin,
                    'no_pol' => $no_pol,
                    'memotambahan_id' => $memotambahan_id,
                    'kode_memotambahan' => $kode_memotambahan,
                    'tanggal_memotambahan' => $tanggal_memotambahan,
                    'nama_drivertambahan' => $nama_drivertambahan,
                    'nama_rutetambahan' => $nama_rutetambahan,
                    'kode_memotambahans' => $kode_memotambahans,
                    'tanggal_memotambahans' => $tanggal_memotambahans,
                    'nama_drivertambahans' => $nama_drivertambahans,
                    'nama_rutetambahans' => $nama_rutetambahans
                ]);
            }
        }

        if ($request->has('keterangan_tambahan') || $request->has('nominal_tambahan') || $request->has('qty_tambahan') || $request->has('satuan_tambahan')) {
            for ($i = 0; $i < count($request->keterangan_tambahan); $i++) {
                if (empty($request->keterangan_tambahan[$i]) && empty($request->nominal_tambahan[$i]) && empty($request->qty_tambahan[$i]) && empty($request->satuan_tambahan[$i])) {
                    continue;
                }

                $validasi_produk = Validator::make($request->all(), [
                    'keterangan_tambahan.' . $i => 'required',
                    'nominal_tambahan.' . $i => 'required',
                    'qty_tambahan.' . $i => 'required',
                    'satuan_tambahan.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Biaya tambahan nomor " . ($i + 1) . " belum dilengkapi!");
                }

                $keterangan_tambahan = $request->keterangan_tambahan[$i] ?? '';
                $nominal_tambahan = $request->nominal_tambahan[$i] ?? '';
                $qty_tambahan = $request->qty_tambahan[$i] ?? '';
                $satuan_tambahan = $request->satuan_tambahan[$i] ?? '';
                $data_pembelians4->push([
                    'detail_idd' => $request->detail_idss[$i] ?? null,
                    'keterangan_tambahan' => $keterangan_tambahan,
                    'nominal_tambahan' => $nominal_tambahan,
                    'qty_tambahan' => $qty_tambahan,
                    'satuan_tambahan' => $satuan_tambahan
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

        // format tanggal indo
        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');
        $tanggal = Carbon::now()->format('Y-m-d');
        $cetakpdf = Faktur_ekspedisi::findOrFail($id);
        $cetakpdf->update([
            'kategori' => $request->kategori,
            'kategoris' => $request->kategoris,
            'karyawan_id' => $request->karyawan_id,
            'tarif_id' => $request->tarif_id,
            'spk_id' => $request->spk_id,
            'kode_spk' => $request->kode_spk,
            'pph' => str_replace(',', '.', str_replace('.', '', $request->pph)),
            'kendaraan_id' => $request->kendaraan_id[0] ?? $request->kendaraan_ids,
            'nama_rute' => $request->nama_rute[0] ?? null,
            'kode_memo' => $request->kode_memo[0] ?? null,
            'no_kabin' => $request->no_kabin[0] ?? $request->no_kabins,
            'no_pol' => $request->no_pol[0] ?? $request->no_pols,
            'nama_sopir' => $request->nama_sopir,
            'tanggal_memo' => $request->tanggal_memo[0] ?? null ? \Carbon\Carbon::parse($request->tanggal_memo[0])->format('d M Y') : null,
            'pelanggan_id' => $request->pelanggan_id,
            'kode_pelanggan' => $request->kode_pelanggan,
            'nama_pelanggan' => $request->nama_pelanggan,
            'alamat_pelanggan' => $request->alamat_pelanggan,
            'telp_pelanggan' => $request->telp_pelanggan,
            'kode_tarif' => $request->kode_tarif,
            'nama_tarif' => $request->nama_tarif,
            'harga_tarif' => str_replace(',', '.', str_replace('.', '', $request->harga_tarif)),
            'jumlah' => $request->jumlah,
            'satuan' => $request->satuan,
            'total_tarif' => str_replace(',', '.', str_replace('.', '', $request->total_tarif)),
            'grand_total' => str_replace(',', '.', str_replace('.', '', $request->sub_total)),
            'sisa' => str_replace(',', '.', str_replace('.', '', $request->sisa)),
            'biaya_tambahan' => str_replace(',', '.', str_replace('.', '', $request->biaya_tambahan)),
            'keterangan' => $request->keterangan,
            'status' => 'posting',
        ]);

        $Pph = Pph::where('faktur_ekspedisi_id', $id)->first();

        if ($request->kategori == "PPH") {
            $attributes = [
                'kode_faktur' => $cetakpdf->kode_faktur,
                'pelanggan_id' => $request->pelanggan_id,
                'kode_pelanggan' => $request->kode_pelanggan,
                'nama_pelanggan' => $request->nama_pelanggan,
                'pph' => str_replace(',', '.', str_replace('.', '', $request->pph)),
            ];
            if (!$Pph) {
                $attributes += [
                    'tanggal' => $format_tanggal,
                    'status' => 'posting',
                    'tanggal_awal' => $tanggal,
                ];
            }
            $Pph = Pph::updateOrInsert(
                ['faktur_ekspedisi_id' => $id],
                $attributes
            );
        }

        $transaksi_id = $cetakpdf->id;
        $detailIds = $request->input('detail_ids');
        $detailIdss = $request->input('detail_idss');


        if ($request->kategoris == "memo") {
            $updatedDetailIds = [];
            $detailIds = $request->detail_ids ?? [];
            $existingDetailIds = Detail_faktur::where('faktur_ekspedisi_id', $cetakpdf->id)->pluck('id')->toArray();
            if (is_array($detailIds) && count($detailIds) > 0) {
                foreach ($detailIds as $i => $detailId) {
                    $detailFaktur = Detail_faktur::find($detailId);

                    if ($detailFaktur) {
                        $detailFaktur->update([
                            'memo_ekspedisi_id' => $request->memo_ekspedisi_id[$i] ?? '',
                            'kode_memo' => $request->kode_memo[$i] ?? null,
                            'tanggal_memo' => $request->tanggal_memo[$i] ?? null,
                            'nama_driver' => $request->nama_driver[$i] ?? null,
                            'telp_driver' => $request->telp_driver[$i] ?? null,
                            'nama_rute' => $request->nama_rute[$i] ?? null,
                            'kendaraan_id' => $request->kendaraan_id[$i] ?? null,
                            'no_kabin' => $request->no_kabin[$i] ?? null,
                            'no_pol' => $request->no_pol[$i] ?? null,
                            'memotambahan_id' => $request->memotambahan_id[$i] ?? null,
                            'kode_memotambahan' => $request->kode_memotambahan[$i] ?? null,
                            'tanggal_memotambahan' => $request->tanggal_memotambahan[$i] ?? null,
                            'nama_drivertambahan' => $request->nama_drivertambahan[$i] ?? null,
                            'nama_rutetambahan' => $request->nama_rutetambahan[$i] ?? null
                        ]);
                        $updatedDetailIds[] = $detailId;
                        $memo = Memo_ekspedisi::find($request->memo_ekspedisi_id[$i]);
                        if ($memo) {
                            $memo->update(['status_memo' => 'aktif', 'status' => 'selesai', 'status_terpakai' => 'digunakan', 'status_spk' => 'selesai']);
                            if ($memo->spk) {
                                $memo->spk->update(['status_spk' => 'faktur']);
                            }
                        }

                        if ($request->memo_ekspedisi_id[$i]) {
                            $memoTambahan = Memotambahan::where('memo_ekspedisi_id', $request->memo_ekspedisi_id[$i])->get();
                            foreach ($memoTambahan as $memo) {
                                if ($memo->status == 'posting') {
                                    $memo->update(['status_memo' => 'aktif', 'status' => 'selesai']);
                                }
                            }
                        }
                    }
                }

                $detailsToDelete = array_diff($existingDetailIds, $updatedDetailIds);
                Detail_faktur::whereIn('id', $detailsToDelete)->delete();
            }
            foreach ($data_pembelians as $data_pembelian) {
                if (!isset($data_pembelian['detail_id'])) {
                    Detail_faktur::create([
                        'faktur_ekspedisi_id' => $cetakpdf->id,
                        'memo_ekspedisi_id' => $data_pembelian['memo_ekspedisi_id'],
                        'kode_memo' => $data_pembelian['kode_memo'],
                        'tanggal_memo' => $data_pembelian['tanggal_memo'],
                        'nama_driver' => $data_pembelian['nama_driver'],
                        'telp_driver' => $data_pembelian['telp_driver'],
                        'nama_rute' => $data_pembelian['nama_rute'],
                        'kendaraan_id' => $data_pembelian['kendaraan_id'],
                        'no_kabin' => $data_pembelian['no_kabin'],
                        'no_pol' => $data_pembelian['no_pol'],
                        'memotambahan_id' => $data_pembelian['memotambahan_id'] ? $data_pembelian['memotambahan_id'] : null,
                        'kode_memotambahan' => $data_pembelian['kode_memotambahan'] ? $data_pembelian['kode_memotambahan'] : null,
                        'tanggal_memotambahan' => $data_pembelian['tanggal_memotambahan'] ? $data_pembelian['tanggal_memotambahan'] : null,
                        'nama_drivertambahan' => $data_pembelian['nama_drivertambahan'] ? $data_pembelian['nama_drivertambahan'] : null,
                        'nama_rutetambahan' => $data_pembelian['nama_rutetambahan'] ? $data_pembelian['nama_rutetambahan'] : null,
                    ]);

                    $memo = Memo_ekspedisi::find($data_pembelian['memo_ekspedisi_id']);
                    $memo->update(['status_memo' => 'aktif', 'status' => 'selesai', 'status_terpakai' => 'digunakan', 'status_spk' => 'selesai']);
                    if ($memo && $memo->spk) {
                        $memo->spk->update(['status_spk' => 'faktur']);
                    }

                    if ($data_pembelian['memo_ekspedisi_id']) {
                        $memoTambahan = Memotambahan::where('memo_ekspedisi_id', $data_pembelian['memo_ekspedisi_id'])->get();
                        foreach ($memoTambahan as $memo) {
                            if ($memo->status == 'posting') {
                                $memo->update(['status_memo' => 'aktif', 'status' => 'selesai']);
                            }
                        }
                    }
                }
            }
        }

        foreach ($data_pembelians4 as $data_pesanan) {
            $detailId = $data_pesanan['detail_idd'];

            if ($detailId) {
                Detail_tariftambahan::where('id', $detailId)->update([
                    'faktur_ekspedisi_id' => $cetakpdf->id,
                    'keterangan_tambahan' => $data_pesanan['keterangan_tambahan'],
                    'nominal_tambahan' => str_replace('.', '', $data_pesanan['nominal_tambahan']),
                    'qty_tambahan' => str_replace('.', '', $data_pesanan['qty_tambahan']),
                    'satuan_tambahan' => $data_pesanan['satuan_tambahan'],
                ]);
            } else {
                $existingDetail = Detail_tariftambahan::where([
                    'faktur_ekspedisi_id' => $cetakpdf->id,
                    'keterangan_tambahan' => $data_pesanan['keterangan_tambahan'],
                    'nominal_tambahan' => str_replace('.', '', $data_pesanan['nominal_tambahan']),
                    'qty_tambahan' => str_replace('.', '', $data_pesanan['qty_tambahan']),
                    'satuan_tambahan' => $data_pesanan['satuan_tambahan'],
                ])->first();


                if (!$existingDetail) {
                    Detail_tariftambahan::create([
                        'faktur_ekspedisi_id' => $cetakpdf->id,
                        'keterangan_tambahan' => $data_pesanan['keterangan_tambahan'],
                        'nominal_tambahan' => str_replace('.', '', $data_pesanan['nominal_tambahan']),
                        'qty_tambahan' => str_replace('.', '', $data_pesanan['qty_tambahan']),
                        'satuan_tambahan' => $data_pesanan['satuan_tambahan'],
                    ]);
                }
            }
        }



        $details = Detail_faktur::where('faktur_ekspedisi_id', $cetakpdf->id)->get();
        $detailtarifs = Detail_tariftambahan::where('faktur_ekspedisi_id', $cetakpdf->id)->get();

        return view('admin.inquery_fakturekspedisispk.show', compact('cetakpdf', 'details', 'detailtarifs'));
    }

    public function show($id)
    {
        $cetakpdf = Faktur_ekspedisi::where('id', $id)->first();
        $details = Detail_faktur::where('faktur_ekspedisi_id', $id)->get();
        $detailtarifs = Detail_tariftambahan::where('faktur_ekspedisi_id', $id)->get();

        return view('admin.inquery_fakturekspedisispk.show', compact('cetakpdf', 'details', 'detailtarifs'));
    }

    public function cetak_fakturekspedisifilter(Request $request)
    {
        $selectedIds = explode(',', $request->input('ids'));
        $fakturs = Faktur_ekspedisi::whereIn('id', $selectedIds)->orderBy('id', 'DESC')->get();
        $pdf = app('dompdf.wrapper');
        $pdf->setPaper('a5', 'landscape');
        $pdf->loadView('admin.inquery_fakturekspedisispk.cetak_pdffilter', compact('fakturs'));
        return $pdf->stream('SelectedFaktur.pdf');
    }



    public function unpostfaktur($id)
    {
        $faktur = Faktur_ekspedisi::find($id);
        if (!$faktur) {
            return back()->with('error', 'Faktur tidak ditemukan');
        }
        $detail_faktur = Detail_faktur::where('faktur_ekspedisi_id', $id)->first();

        if ($detail_faktur) {
            $detailfakturs = Detail_faktur::where('faktur_ekspedisi_id', $id)->get();
            foreach ($detailfakturs as $detail) {
                if ($detail->memo_ekspedisi_id) {
                    $memo = Memo_ekspedisi::where(['id' => $detail->memo_ekspedisi_id, 'status' => 'selesai'])->first();

                    if ($memo) {
                        $memo->update(['status_memo' => null, 'status' => 'posting', 'status_spk' => 'sj']);
                        Spk::where('id', $memo->spk_id)->update(['status_spk' => 'sj']);
                        $memotambahans = Memotambahan::where(['memo_ekspedisi_id' => $detail->memo_ekspedisi_id, 'status' => 'selesai'])->get();
                        foreach ($memotambahans as $memotambahan) {
                            $memotambahan->update(['status_memo' => null, 'status' => 'posting']);
                        }
                    }
                }
            }
        }

        $pph = Pph::where('faktur_ekspedisi_id', $id)->first();

        if ($pph) {
            $pph->update([
                'status' => 'unpost'
            ]);
        }
        $faktur->update([
            'status' => 'unpost'
        ]);

        return back()->with('success', 'Berhasil');
    }


    public function postingfaktur($id)
    {
        $faktur = Faktur_ekspedisi::where('id', $id)->first();

        if (!$faktur) {
            return back()->with('error', 'Faktur tidak ditemukan');
        }

        $detail_faktur = Detail_faktur::where('faktur_ekspedisi_id', $id)->first();

        if ($detail_faktur) {
            $detailfakturs = Detail_faktur::where('faktur_ekspedisi_id', $id)->get();
            foreach ($detailfakturs as $detail) {
                if ($detail->memo_ekspedisi_id) {
                    $memo = Memo_ekspedisi::where(['id' => $detail->memo_ekspedisi_id, 'status' => 'posting'])->first();

                    if ($memo) {
                        $memo->update(['status_memo' => 'aktif', 'status' => 'selesai', 'status_spk' => 'selesai']);
                        Spk::where('id', $memo->spk_id)->update(['status_spk' => 'faktur']);
                        $memotambahans = Memotambahan::where(['memo_ekspedisi_id' => $detail->memo_ekspedisi_id, 'status' => 'selesai'])->get();
                        foreach ($memotambahans as $memotambahan) {
                            $memotambahan->update(['status_memo' => 'aktif', 'status' => 'selesai']);
                        }
                    }
                }
            }
        }

        $pph = Pph::where('faktur_ekspedisi_id', $id)->first();

        if ($pph) {
            $pph->update([
                'status' => 'posting'
            ]);
        }
        $faktur->update([
            'status' => 'posting'
        ]);
        return back()->with('success', 'Berhasil');
    }



    public function hapusfaktur($id)
    {
        $faktur = Faktur_ekspedisi::find($id);

        if ($faktur) {
            if ($faktur->kategori === 'PPH') {
                $pph = Pph::where('faktur_ekspedisi_id', $id)->first();
                if ($pph) {
                    $pph->delete();
                }
            }
            $detailfaktur = Detail_faktur::where('faktur_ekspedisi_id', $id)->get();

            foreach ($detailfaktur as $detail) {
                if ($detail->memo_ekspedisi_id) {
                    Memo_ekspedisi::where('id', $detail->memo_ekspedisi_id)->update(['status_terpakai' => null]);
                }
            }
            $faktur->detail_faktur->each(function ($detail) {
                $detail->delete();
            });
            $faktur->delete();

            return back()->with('success', 'Berhasil menghapus Faktur Ekspedisi');
        } else {
            return back()->with('error', 'Faktur Ekspedisi tidak ditemukan');
        }
    }
    public function deletedetailfaktur($id)
    {
        $item = Detail_faktur::find($id);

        if ($item) {
            $memo = Memo_ekspedisi::where('id', $item->memo_ekspedisi_id);
            $memo->update([
                'status_terpakai' => null
            ]);
            $item->delete();
        } else {
            return response()->json(['message' => 'Detail Faktur not found'], 404);
        }
    }

    public function delettariftambahan($id)
    {
        $item = Detail_tariftambahan::find($id);

        if ($item) {
            $item->delete();
            return response()->json(['message' => 'Data deleted successfully']);
        } else {
            return response()->json(['message' => 'Detail Faktur not found'], 404);
        }
    }
}