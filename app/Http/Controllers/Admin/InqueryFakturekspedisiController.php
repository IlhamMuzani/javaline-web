<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use App\Models\Ban;
use App\Models\Merek;
use App\Models\Ukuran;
use App\Models\Typeban;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\Pembelian_ban;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\Detail_faktur;
use App\Models\Detail_tagihan;
use App\Models\Detail_tariftambahan;
use App\Models\Faktur_ekspedisi;
use App\Models\Kendaraan;
use App\Models\Memo_ekspedisi;
use App\Models\Memotambahan;
use App\Models\Pelanggan;
use App\Models\Pph;
use App\Models\Saldo;
use App\Models\Tagihan_ekspedisi;
use App\Models\Tarif;
use Illuminate\Support\Facades\Validator;
use Egulias\EmailValidator\Result\Reason\DetailedReason;

class InqueryFakturekspedisiController extends Controller
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
            // Jika tidak ada filter tanggal hari ini
            $inquery->whereDate('tanggal_awal', Carbon::today());
        }

        $inquery->orderBy('id', 'DESC');
        $inquery = $inquery->get();

        return view('admin.inquery_fakturekspedisi.index', compact('inquery'));
    }

    public function edit($id)
    {
        // if (auth()->check() && auth()->user()->menu['inquery perpanjangan stnk']) {
        $pelanggans = Pelanggan::all();
        $memoEkspedisi = Memo_ekspedisi::where(['status_memo' => null, 'status' => 'posting'])->get();
        $memoTambahan = Memotambahan::where(['status_memo' => null, 'status' => 'posting'])->get();

        // Gabungkan dua koleksi menjadi satu
        $memos = $memoEkspedisi->concat($memoTambahan);
        $tarifs = Tarif::all();
        $inquery = Faktur_ekspedisi::where('id', $id)->first();
        $details = Detail_faktur::where('faktur_ekspedisi_id', $id)->get();
        $detailtarifs = Detail_tariftambahan::where('faktur_ekspedisi_id', $id)->get();
        $kendaraans = Kendaraan::get();

        return view('admin.inquery_fakturekspedisi.update', compact('kendaraans', 'memoEkspedisi', 'memoTambahan', 'detailtarifs', 'details', 'inquery', 'pelanggans', 'memos', 'tarifs'));
        // } else {
        //     // tidak memiliki akses
        //     return back()->with('error', array('Anda tidak memiliki akses'));
        // }
    }

    public function update(Request $request, $id)
    {
        $validasi_pelanggan = Validator::make(
            $request->all(),
            [
                'kategori' => 'required',
                'pelanggan_id' => 'required',
                'tarif_id' => 'required',
                'jumlah' => 'required|numeric',
                'satuan' => 'required',
            ],
            [
                'kategori.required' => 'Pilih kategori',
                'pelanggan_id.required' => 'Pilih Pelanggan',
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

        // if ($request->has('memo_ekspedisi_id')) {
        //     for ($i = 0; $i < count($request->memo_ekspedisi_id); $i++) {
        //         $validasi_produk = Validator::make($request->all(), [
        //             'memo_ekspedisi_id.' . $i => 'required',
        //             'kode_memo.' . $i => 'required',
        //             'nama_driver.' . $i => 'required',
        //             'nama_rute.' . $i => 'required',
        //         ]);

        //         if ($validasi_produk->fails()) {
        //             array_push($error_pesanans, "Memo nomor " . ($i + 1) . " belum dilengkapi!"); // Corrected the syntax for concatenation and indexing
        //         }

        //         $memo_ekspedisi_id = is_null($request->memo_ekspedisi_id[$i]) ? '' : $request->memo_ekspedisi_id[$i];
        //         $kode_memo = is_null($request->kode_memo[$i]) ? '' : $request->kode_memo[$i];
        //         $nama_driver = is_null($request->nama_driver[$i]) ? '' : $request->nama_driver[$i];
        //         $nama_rute = is_null($request->nama_rute[$i]) ? '' : $request->nama_rute[$i];
        //         $telp_driver = is_null($request->telp_driver[$i]) ? '' : $request->telp_driver[$i];
        //         $kendaraan_id = is_null($request->kendaraan_id[$i]) ? '' : $request->kendaraan_id[$i];
        //         $no_kabin = is_null($request->no_kabin[$i]) ? '' : $request->no_kabin[$i];
        //         $no_pol = is_null($request->no_pol[$i]) ? '' : $request->no_pol[$i];

        //         $data_pembelians->push([
        //             'detail_id' => $request->detail_ids[$i] ?? null,
        //             'memo_ekspedisi_id' => $memo_ekspedisi_id,
        //             'kode_memo' => $kode_memo,
        //             'nama_driver' => $nama_driver,
        //             'telp_driver' => $telp_driver,
        //             'nama_rute' => $nama_rute,
        //             'kendaraan_id' => $kendaraan_id,
        //             'no_kabin' => $no_kabin,
        //             'no_pol' => $no_pol
        //         ]);
        //     }
        // }

        if ($request->has('memo_ekspedisi_id') || $request->has('kode_memo') || $request->has('nama_driver') || $request->has('telp_driver') || $request->has('nama_rute') || $request->has('kendaraan_id') || $request->has('no_kabin') || $request->has('no_pol')) {
            for ($i = 0; $i < count($request->memo_ekspedisi_id); $i++) {
                // Check if either 'keterangan_tambahan' or 'nominal_tambahan' has input
                if (empty($request->memo_ekspedisi_id[$i]) && empty($request->kode_memo[$i]) && empty($request->nama_driver[$i]) && empty($request->telp_driver[$i]) && empty($request->nama_rute[$i]) && empty($request->kendaraan_id[$i]) && empty($request->no_kabin[$i]) && empty($request->no_pol[$i])) {
                    continue; // Skip validation if both are empty
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

        if ($request->has('keterangan_tambahan') || $request->has('nominal_tambahan')) {
            for ($i = 0; $i < count($request->keterangan_tambahan); $i++) {
                // Check if either 'keterangan_tambahan' or 'nominal_tambahan' has input
                if (empty($request->keterangan_tambahan[$i]) && empty($request->nominal_tambahan[$i])) {
                    continue; // Skip validation if both are empty
                }

                $validasi_produk = Validator::make($request->all(), [
                    'keterangan_tambahan.' . $i => 'required',
                    'nominal_tambahan.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Biaya tambahan nomor " . ($i + 1) . " belum dilengkapi!");
                }

                $keterangan_tambahan = $request->keterangan_tambahan[$i] ?? '';
                $nominal_tambahan = $request->nominal_tambahan[$i] ?? '';

                $data_pembelians4->push([
                    'detail_idd' => $request->detail_idss[$i] ?? null,
                    'keterangan_tambahan' => $keterangan_tambahan,
                    'nominal_tambahan' => $nominal_tambahan
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
            'tarif_id' => $request->tarif_id,
            // 'pph' => str_replace('.', '', $request->pph),
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
            // 'harga_tarif' => str_replace('.', '', $request->harga_tarif),
            // 'jumlah' => $request->jumlah,
            'harga_tarif' => str_replace(',', '.', str_replace('.', '', $request->harga_tarif)),
            // 'harga_tarif' => str_replace('.', '', $request->harga_tarif),
            // 'jumlah' => str_replace('.', ',', $request->jumlah),
            'jumlah' => $request->jumlah,
            'satuan' => $request->satuan,
            // 'total_tarif' => str_replace('.', '', $request->total_tarif),
            // 'grand_total' => str_replace('.', '', $request->sub_total),
            // 'sisa' => str_replace('.', '', $request->sisa),
            // 'biaya_tambahan' => str_replace('.', '', $request->biaya_tambahan),
            'total_tarif' => str_replace(',', '.', str_replace('.', '', $request->total_tarif)),
            // 'total_tarif' => str_replace('.', '', $request->total_tarif),
            'grand_total' => str_replace(',', '.', str_replace('.', '', $request->sub_total)),
            // 'grand_total' => str_replace('.', '', $request->sub_total),
            'sisa' => str_replace(',', '.', str_replace('.', '', $request->sisa)),
            // 'sisa' => str_replace('.', '', $request->sisa),
            'biaya_tambahan' => str_replace(',', '.', str_replace('.', '', $request->biaya_tambahan)),
            // 'biaya_tambahan' => str_replace('.', '', $request->biaya_tambahan),
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
                // Jika ini adalah pembuatan baru, tambahkan atribut-atribut tambahan
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

        foreach ($data_pembelians as $data_pesanan) {
            $detailId = $data_pesanan['detail_id'];

            if ($detailId) {
                Detail_faktur::where('id', $detailId)->update([
                    'faktur_ekspedisi_id' => $cetakpdf->id,
                    'memo_ekspedisi_id' => $data_pesanan['memo_ekspedisi_id'],
                    'kode_memo' => $data_pesanan['kode_memo'],
                    'tanggal_memo' => $data_pesanan['tanggal_memo'],
                    'nama_driver' => $data_pesanan['nama_driver'],
                    'nama_rute' => $data_pesanan['nama_rute'],
                    'telp_driver' => $data_pesanan['telp_driver'],
                    'kendaraan_id' => $data_pesanan['kendaraan_id'],
                    'no_kabin' => $data_pesanan['no_kabin'],
                    'no_pol' => $data_pesanan['no_pol'],
                    'memotambahan_id' => $data_pesanan['memotambahan_id'] ? $data_pesanan['memotambahan_id'] : null,
                    'kode_memotambahan' => $data_pesanan['kode_memotambahan'],
                    'tanggal_memotambahan' => $data_pesanan['tanggal_memotambahan'],
                    'nama_drivertambahan' => $data_pesanan['nama_drivertambahan'],
                    'nama_rutetambahan' => $data_pesanan['nama_rutetambahan'],

                    'kode_memotambahans' => $data_pesanan['kode_memotambahans'],
                    'tanggal_memotambahans' => $data_pesanan['tanggal_memotambahans'],
                    'nama_drivertambahans' => $data_pesanan['nama_drivertambahans'],
                    'nama_rutetambahans' => $data_pesanan['nama_rutetambahans'],
                ]);
                // Update status memo ekspedisi
                Memo_ekspedisi::where('id', $data_pesanan['memo_ekspedisi_id'])->update(['status_memo' => 'aktif', 'status' => 'selesai']);

                if ($data_pesanan['memo_ekspedisi_id']) {
                    // Ambil semua memo tambahan yang terkait dengan memo ekspedisi tertentu
                    $memoTambahan = Memotambahan::where('memo_ekspedisi_id', $data_pesanan['memo_ekspedisi_id'])->get();

                    // Loop dan perbarui status semua memo tambahan
                    foreach ($memoTambahan as $memo) {
                        // Periksa apakah status memo tambahan adalah 'posting'
                        if ($memo->status == 'posting') {
                            // Jika statusnya 'posting', lakukan pembaruan
                            $memo->update(['status_memo' => 'aktif', 'status' => 'selesai']);
                        }
                    }
                }
            } else {
                $existingDetail = Detail_faktur::where([
                    'faktur_ekspedisi_id' => $cetakpdf->id,
                    'memo_ekspedisi_id' => $data_pesanan['memo_ekspedisi_id'],
                    'kode_memo' => $data_pesanan['kode_memo'],
                    'tanggal_memo' => $data_pesanan['tanggal_memo'],
                    'nama_driver' => $data_pesanan['nama_driver'],
                    'nama_rute' => $data_pesanan['nama_rute'],
                    'telp_driver' => $data_pesanan['telp_driver'],
                    'kendaraan_id' => $data_pesanan['kendaraan_id'],
                    'no_kabin' => $data_pesanan['no_kabin'],
                    'no_pol' => $data_pesanan['no_pol'],
                    'memotambahan_id' => $data_pesanan['memotambahan_id'],
                    'kode_memotambahan' => $data_pesanan['kode_memotambahan'],
                    'tanggal_memotambahan' => $data_pesanan['tanggal_memotambahan'],
                    'nama_drivertambahan' => $data_pesanan['nama_drivertambahan'],
                    'nama_rutetambahan' => $data_pesanan['nama_rutetambahan'],
                    'kode_memotambahans' => $data_pesanan['kode_memotambahans'],
                    'tanggal_memotambahans' => $data_pesanan['tanggal_memotambahans'],
                    'nama_drivertambahans' => $data_pesanan['nama_drivertambahans'],
                    'nama_rutetambahans' => $data_pesanan['nama_rutetambahans'],
                ])->first();

                if (!$existingDetail) {
                    $detailTagihan = Detail_faktur::create([
                        'faktur_ekspedisi_id' => $cetakpdf->id,
                        'memo_ekspedisi_id' => $data_pesanan['memo_ekspedisi_id'],
                        'kode_memo' => $data_pesanan['kode_memo'],
                        'tanggal_memo' => $data_pesanan['tanggal_memo'],
                        'nama_driver' => $data_pesanan['nama_driver'],
                        'nama_rute' => $data_pesanan['nama_rute'],
                        'telp_driver' => $data_pesanan['telp_driver'],
                        'kendaraan_id' => $data_pesanan['kendaraan_id'],
                        'no_kabin' => $data_pesanan['no_kabin'],
                        'no_pol' => $data_pesanan['no_pol'],
                        'memotambahan_id' => $data_pesanan['memotambahan_id'] ? $data_pesanan['memotambahan_id'] : null,
                        'kode_memotambahan' => $data_pesanan['kode_memotambahan'],
                        'tanggal_memotambahan' => $data_pesanan['tanggal_memotambahan'],
                        'nama_drivertambahan' => $data_pesanan['nama_drivertambahan'],
                        'nama_rutetambahan' => $data_pesanan['nama_rutetambahan'],

                        'kode_memotambahans' => $data_pesanan['kode_memotambahans'],
                        'tanggal_memotambahans' => $data_pesanan['tanggal_memotambahans'],
                        'nama_drivertambahans' => $data_pesanan['nama_drivertambahans'],
                        'nama_rutetambahans' => $data_pesanan['nama_rutetambahans'],
                    ]);
                    // Update status memo ekspedisi
                    // Update status memo ekspedisi
                    Memo_ekspedisi::where('id', $data_pesanan['memo_ekspedisi_id'])->update(['status_memo' => 'aktif', 'status' => 'selesai']);

                    if ($data_pesanan['memo_ekspedisi_id']) {
                        // Ambil semua memo tambahan yang terkait dengan memo ekspedisi tertentu
                        $memoTambahan = Memotambahan::where('memo_ekspedisi_id', $data_pesanan['memo_ekspedisi_id'])->get();

                        // Loop dan perbarui status semua memo tambahan
                        foreach ($memoTambahan as $memo) {
                            // Periksa apakah status memo tambahan adalah 'posting'
                            if ($memo->status == 'posting') {
                                // Jika statusnya 'posting', lakukan pembaruan
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
                ]);
            } else {
                $existingDetail = Detail_tariftambahan::where([
                    'faktur_ekspedisi_id' => $cetakpdf->id,
                    'keterangan_tambahan' => $data_pesanan['keterangan_tambahan'],
                ])->first();


                if (!$existingDetail) {
                    Detail_tariftambahan::create([
                        'faktur_ekspedisi_id' => $cetakpdf->id,
                        'keterangan_tambahan' => $data_pesanan['keterangan_tambahan'],
                        'nominal_tambahan' => str_replace('.', '', $data_pesanan['nominal_tambahan']),
                    ]);
                }
            }
        }



        $details = Detail_faktur::where('faktur_ekspedisi_id', $cetakpdf->id)->get();
        $detailtarifs = Detail_tariftambahan::where('faktur_ekspedisi_id', $cetakpdf->id)->get();

        return view('admin.inquery_fakturekspedisi.show', compact('cetakpdf', 'details', 'detailtarifs'));
    }

    public function show($id)
    {
        $cetakpdf = Faktur_ekspedisi::where('id', $id)->first();
        $details = Detail_faktur::where('faktur_ekspedisi_id', $id)->get();
        $detailtarifs = Detail_tariftambahan::where('faktur_ekspedisi_id', $id)->get();

        return view('admin.inquery_fakturekspedisi.show', compact('cetakpdf', 'details', 'detailtarifs'));
    }

    public function cetak_fakturekspedisifilter(Request $request)
    {
        $selectedIds = explode(',', $request->input('ids'));

        // Mengambil faktur berdasarkan id yang dipilih
        $fakturs = Faktur_ekspedisi::whereIn('id', $selectedIds)->orderBy('id', 'DESC')->get();

        $pdf = app('dompdf.wrapper');

        // Set orientasi PDF menjadi landscape dan ukuran kertas faktur dot matrix setengah dari A4
        $pdf->setPaper('a5', 'landscape'); // Ukuran kertas setengah dari A4 dengan orientasi landscape

        $pdf->loadView('admin.inquery_fakturekspedisi.cetak_pdffilter', compact('fakturs'));

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
                    // Update status memo ekspedisi
                    Memo_ekspedisi::where(['id' => $detail->memo_ekspedisi_id, 'status' => 'selesai'])->update(['status_memo' => null, 'status' => 'posting']);
                    // Update status memotambahan
                    $memotambahans = Memotambahan::where(['memo_ekspedisi_id' => $detail->memo_ekspedisi_id, 'status' => 'selesai'])->get();
                    foreach ($memotambahans as $memotambahan) {
                        $memotambahan->update(['status_memo' => null, 'status' => 'posting']);
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
        // }

        // Update the status of the faktur to 'unpost'
        $faktur->update([
            'status' => 'unpost'
        ]);

        // Return back with a success message
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
                    // Update status memo ekspedisi
                    Memo_ekspedisi::where(['id' => $detail->memo_ekspedisi_id, 'status' => 'posting'])->update(['status_memo' => 'aktif', 'status' => 'selesai']);
                    // Update status memotambahan
                    $memotambahans = Memotambahan::where(['memo_ekspedisi_id' => $detail->memo_ekspedisi_id, 'status' => 'posting'])->get();
                    foreach ($memotambahans as $memotambahan) {
                        $memotambahan->update(['status_memo' => 'aktif', 'status' => 'selesai']);
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
            // Check if the category is 'PPH' before attempting to delete Pph
            if ($faktur->kategori === 'PPH') {
                $pph = Pph::where('faktur_ekspedisi_id', $id)->first();

                // Check if the PPH record exists before deleting
                if ($pph) {
                    $pph->delete();
                }
            }
            // Retrieve related Detail_faktur instances
            $detailfaktur = Detail_faktur::where('faktur_ekspedisi_id', $id)->get();

            // // Loop through each Detail_faktur and update associated Memo_ekspedisi and Memotambahan records
            // foreach ($detailfaktur as $detail) {
            //     if ($detail->memotambahan_id) {
            //         Memotambahan::where('id', $detail->memotambahan_id)->update(['status_memo' => null, 'status' => 'posting']);
            //     }

            //     if ($detail->memo_ekspedisi_id) {
            //         Memo_ekspedisi::where('id', $detail->memo_ekspedisi_id)->update(['status_memo' => null, 'status' => 'posting']);
            //     }
            // }

            // Delete related Detail_faktur instances
            $faktur->detail_faktur->each(function ($detail) {
                $detail->delete();
            });

            // Delete the main Faktur_ekspedisi instance
            $faktur->delete();

            return back()->with('success', 'Berhasil menghapus Faktur Ekspedisi');
        } else {
            // Handle the case where the Faktur_ekspedisi with the given ID is not found
            return back()->with('error', 'Faktur Ekspedisi tidak ditemukan');
        }
    }

    public function deletedetailfaktur($id)
    {
        $item = Detail_faktur::find($id);

        if ($item) {
            $faktur = Faktur_ekspedisi::find($item->faktur_ekspedisi_id);

            if ($faktur) {
                $memo = Memo_ekspedisi::find($item->memo_ekspedisi_id);
                // Hapus Detail_faktur
                $item->delete();

                return response()->json(['message' => 'Data deleted successfully']);
            } else {
                return response()->json(['message' => 'Faktur not found'], 404);
            }
        } else {
            return response()->json(['message' => 'Detail Faktur not found'], 404);
        }
    }
}