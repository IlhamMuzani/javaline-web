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
use App\Models\Detail_tariftambahan;
use App\Models\Faktur_ekspedisi;
use App\Models\Memo_ekspedisi;
use App\Models\Pelanggan;
use App\Models\Saldo;
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
        $memos = Memo_ekspedisi::all();
        $tarifs = Tarif::all();
        $inquery = Faktur_ekspedisi::where('id', $id)->first();
        $details = Detail_faktur::where('faktur_ekspedisi_id', $id)->get();
        $detailtarifs = Detail_tariftambahan::where('faktur_ekspedisi_id', $id)->get();

        return view('admin.inquery_fakturekspedisi.update', compact('detailtarifs', 'details', 'inquery', 'pelanggans', 'memos', 'tarifs'));
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
                'jumlah' => 'required',
                'satuan' => 'required',
            ],
            [
                'kategori.required' => 'Pilih kategori',
                'pelanggan_id.required' => 'Pilih Pelanggan',
                'tarif_id.required' => 'Pilih Tarif',
                'jumlah.required' => 'Masukkan jumlah',
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

        if ($request->has('memo_ekspedisi_id')) {
            for ($i = 0; $i < count($request->memo_ekspedisi_id); $i++) {
                $validasi_produk = Validator::make($request->all(), [
                    'memo_ekspedisi_id.' . $i => 'required',
                    'kode_memo.' . $i => 'required',
                    'nama_driver.' . $i => 'required',
                    'nama_rute.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Memo nomor " . ($i + 1) . " belum dilengkapi!"); // Corrected the syntax for concatenation and indexing
                }

                $memo_ekspedisi_id = is_null($request->memo_ekspedisi_id[$i]) ? '' : $request->memo_ekspedisi_id[$i];
                $kode_memo = is_null($request->kode_memo[$i]) ? '' : $request->kode_memo[$i];
                $nama_driver = is_null($request->nama_driver[$i]) ? '' : $request->nama_driver[$i];
                $nama_rute = is_null($request->nama_rute[$i]) ? '' : $request->nama_rute[$i];
                $kendaraan_id = is_null($request->kendaraan_id[$i]) ? '' : $request->kendaraan_id[$i];
                $no_kabin = is_null($request->no_kabin[$i]) ? '' : $request->no_kabin[$i];
                $telp_driver = is_null($request->telp_driver[$i]) ? '' : $request->telp_driver[$i];

                $data_pembelians->push([
                    'detail_id' => $request->detail_ids[$i] ?? null,
                    'memo_ekspedisi_id' => $memo_ekspedisi_id,
                    'kode_memo' => $kode_memo,
                    'nama_driver' => $nama_driver,
                    'telp_driver' => $telp_driver,
                    'nama_rute' => $nama_rute,
                    'kendaraan_id' => $kendaraan_id,
                    'no_kabin' => $no_kabin
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
            'tarif_id' => $request->tarif_id,
            'pph' => $request->pph,
            'pelanggan_id' => $request->pelanggan_id,
            'kode_pelanggan' => $request->kode_pelanggan,
            'nama_pelanggan' => $request->nama_pelanggan,
            'alamat_pelanggan' => $request->alamat_pelanggan,
            'telp_pelanggan' => $request->telp_pelanggan,
            'kode_tarif' => $request->kode_tarif,
            'nama_tarif' => $request->nama_tarif,
            'harga_tarif' => $request->harga_tarif,
            'jumlah' => $request->jumlah,
            'satuan' => $request->satuan,
            'total_tarif' => $request->total_tarif,
            'grand_total' => $request->sub_total,
            'keterangan' => $request->keterangan,
            'sisa' => $request->sisa,
            'biaya_tambahan' => $request->biaya_tambahan,
            'status' => 'posting',
        ]);

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
                    'nama_driver' => $data_pesanan['nama_driver'],
                    'nama_rute' => $data_pesanan['nama_rute'],
                    'kendaraan_id' => $data_pesanan['kendaraan_id'],
                    'no_kabin' => $data_pesanan['no_kabin'],
                    'telp_driver' => $data_pesanan['telp_driver'],
                ]);
            } else {
                $existingDetail = Detail_faktur::where([
                    'faktur_ekspedisi_id' => $cetakpdf->id,
                    'kode_memo' => $data_pesanan['kode_memo'],
                ])->first();


                if (!$existingDetail) {
                    Detail_faktur::create([
                        'faktur_ekspedisi_id' => $cetakpdf->id,
                        'memo_ekspedisi_id' => $data_pesanan['memo_ekspedisi_id'],
                        'kode_memo' => $data_pesanan['kode_memo'],
                        'nama_driver' => $data_pesanan['nama_driver'],
                        'nama_rute' => $data_pesanan['nama_rute'],
                        'kendaraan_id' => $data_pesanan['kendaraan_id'],
                        'no_kabin' => $data_pesanan['no_kabin'],
                        'telp_driver' => $data_pesanan['telp_driver'],

                    ]);
                }
            }
        }

        foreach ($data_pembelians4 as $data_pesanan) {
            $detailId = $data_pesanan['detail_idd'];

            if ($detailId) {
                Detail_tariftambahan::where('id', $detailId)->update([
                    'faktur_ekspedisi_id' => $cetakpdf->id,
                    'keterangan_tambahan' => $data_pesanan['keterangan_tambahan'],
                    'nominal_tambahan' => $data_pesanan['nominal_tambahan'],
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
                        'nominal_tambahan' => $data_pesanan['nominal_tambahan'],
                    ]);
                }
            }
        }



        $detail_faktur = Detail_faktur::where('faktur_ekspedisi_id', $cetakpdf->id)->get();
        $detail_tarif = Detail_tariftambahan::where('faktur_ekspedisi_id', $cetakpdf->id)->get();

        return view('admin.inquery_fakturekspedisi.show', compact('cetakpdf', 'detail_faktur', 'detail_tarif'));
    }

    public function show($id)
    {
        $cetakpdf = Faktur_ekspedisi::where('id', $id)->first();
        $details = Detail_faktur::where('faktur_ekspedisi_id', $id)->get();
        $detailtarifs = Detail_tariftambahan::where('faktur_ekspedisi_id', $id)->get();

        return view('admin.inquery_fakturekspedisi.show', compact('cetakpdf', 'details', 'detailtarifs'));
    }

    public function unpostfaktur($id)
    {
        $faktur = Faktur_ekspedisi::where('id', $id)->first();

        $faktur->update([
            'status' => 'unpost'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function postingfaktur($id)
    {
        $faktur = Faktur_ekspedisi::where('id', $id)->first();

        $faktur->update([
            'status' => 'posting'
        ]);

        return back()->with('success', 'Berhasil');
    }


    public function destroy($id)
    {
        $faktur = Faktur_ekspedisi::find($id);
        $faktur->delete();

        return redirect('admin/inquery_fakturekspedisi')->with('success', 'Berhasil menghapus Faktur Ekspedisi');
    }
}