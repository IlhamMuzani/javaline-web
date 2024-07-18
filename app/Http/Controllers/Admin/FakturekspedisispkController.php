<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\Merek;
use App\Models\Ukuran;
use App\Models\Supplier;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Pembelian_ban;
use App\Models\Detail_pembelianban;
use App\Http\Controllers\Controller;
use App\Models\Ban;
use App\Models\Biaya_tambahan;
use App\Models\Detail_faktur;
use App\Models\Detail_memo;
use App\Models\Detail_memotambahan;
use App\Models\Detail_tariftambahan;
use App\Models\Faktur_ekspedisi;
use App\Models\Kendaraan;
use App\Models\Memo_ekspedisi;
use App\Models\Memo_tambahan;
use App\Models\Memotambahan;
use App\Models\Pelanggan;
use App\Models\Penerimaan_kaskecil;
use App\Models\Potongan_memo;
use App\Models\nama_rute;
use App\Models\Pph;
use App\Models\Saldo;
use App\Models\Spk;
use App\Models\Tarif;
use App\Models\Typeban;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class FakturekspedisispkController extends Controller
{
    // public function index()
    // {
    //     $pelanggans = Pelanggan::all();
    //     $memoEkspedisi = Memo_ekspedisi::where(['status_memo' => null, 'status' => 'posting'])->get();
    //     $memoTambahan = Memotambahan::where(['status_memo' => null, 'status' => 'posting'])->get();
    //     $kendaraans = Kendaraan::get();

    //     // Gabungkan dua koleksi menjadi satu
    //     $memos = $memoEkspedisi->concat($memoTambahan);
    //     $tarifs = Tarif::all();

    //     return view('admin.faktur_ekspedisispk.index', compact('kendaraans', 'pelanggans', 'memos', 'tarifs', 'memoEkspedisi', 'memoTambahan'));
    // }

    public function index()
    {
        $pelanggans = Pelanggan::all();
        $spks = Spk::where('status_spk', 'sj')->get();
        $memoEkspedisi = Memo_ekspedisi::whereHas('spk', function ($query) {
            $query->where('status_spk', 'sj');
        })->where(['status_memo' => null, 'status' => 'posting'])->get();
        $memoTambahan = Memotambahan::where(['status_memo' => null, 'status' => 'posting'])->get();
        $kendaraans = Kendaraan::get();

        // Gabungkan dua koleksi menjadi satu
        $memos = $memoEkspedisi->concat($memoTambahan);
        $tarifs = Tarif::all();

        return view('admin.faktur_ekspedisispk.index', compact(
            'spks',
            'kendaraans',
            'pelanggans',
            'memos',
            'tarifs',
            'memoEkspedisi',
            'memoTambahan'
        ));
    }


    public function store(Request $request)
    {
        $validasi_pelanggan = Validator::make(
            $request->all(),
            [
                'kode_faktur' => 'unique:faktur_ekspedisis,kode_faktur',
                'kategori' => 'required',
                'pelanggan_id' => 'required',
                'tarif_id' => 'required',
                'jumlah' => 'required|numeric',
                'satuan' => 'required',
            ],
            [
                'kode_faktur.unique' => 'Kode Memo sudah ada, silakan coba lagi',
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

        if ($request->has('memo_ekspedisi_id') || $request->has('kode_memo') || $request->has('nama_driver') || $request->has('telp_driver') || $request->has('nama_rute') || $request->has('kendaraan_id') || $request->has('no_kabin') || $request->has('no_pol')) {
            for ($i = 0; $i < count($request->memo_ekspedisi_id); $i++) {
                // Check if either 'keterangan_tambahan' or 'nominal_tambahan' has input
                if (
                    empty($request->memo_ekspedisi_id[$i]) && empty($request->kode_memo[$i]) && empty($request->nama_driver[$i]) && empty($request->telp_driver[$i]) && empty($request->nama_rute[$i]) && empty($request->kendaraan_id[$i]) && empty($request->no_kabin[$i]) && empty($request->no_pol[$i])
                ) {
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
                // Check if either 'keterangan_tambahan' or 'nominal_tambahan' has input
                if (
                    empty($request->keterangan_tambahan[$i]) && empty($request->nominal_tambahan[$i]) && empty($request->qty_tambahan[$i]) && empty($request->satuan_tambahan[$i])
                ) {
                    continue; // Skip validation if both are empty
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
                $data_pembelians4->push(['keterangan_tambahan' => $keterangan_tambahan, 'nominal_tambahan' => $nominal_tambahan, 'qty_tambahan' => $qty_tambahan, 'satuan_tambahan' => $satuan_tambahan]);
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

        $kode = $this->kode();
        // format tanggal indo
        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');
        $tanggal = Carbon::now()->format('Y-m-d');
        $cetakpdf = Faktur_ekspedisi::create([
            'user_id' => auth()->user()->id,
            'spk_id' => $request->spk_id,
            'kode_spk' => $request->kode_spk,
            'kode_faktur' => $this->kode(),
            'kategori' => $request->kategori,
            'kategoris' => $request->kategoris,
            'kendaraan_id' => $request->kendaraan_id[0] ?? $request->kendaraan_ids,
            'nama_rute' => $request->nama_rute[0] ?? null,
            'kode_memo' => $request->kode_memo[0] ?? null,
            'no_kabin' => $request->no_kabin[0] ?? $request->no_kabins,
            'no_pol' => $request->no_pol[0] ?? $request->no_pols,
            'nama_sopir' => $request->nama_sopir,
            'tarif_id' => $request->tarif_id,
            'tanggal_memo' => $request->tanggal_memo[0] ?? null ? \Carbon\Carbon::parse($request->tanggal_memo[0])->format('d M Y') : null,
            // 'pph' => str_replace('.', '', $request->pph),
            'pph' => str_replace(',', '.', str_replace('.', '', $request->pph)),
            'pelanggan_id' => $request->pelanggan_id,
            'kode_pelanggan' => $request->kode_pelanggan,
            'nama_pelanggan' => $request->nama_pelanggan,
            'alamat_pelanggan' => $request->alamat_pelanggan,
            'telp_pelanggan' => $request->telp_pelanggan,
            'kode_tarif' => $request->kode_tarif,
            'nama_tarif' => $request->nama_tarif,
            'harga_tarif' => str_replace(',', '.', str_replace('.', '', $request->harga_tarif)),
            // 'harga_tarif' => str_replace('.', '', $request->harga_tarif),
            // 'jumlah' => str_replace('.', ',', $request->jumlah),
            'jumlah' => $request->jumlah,
            'satuan' => $request->satuan,
            'total_tarif' => str_replace(',', '.', str_replace('.', '', $request->total_tarif)),
            // 'total_tarif' => str_replace('.', '', $request->total_tarif),
            'grand_total' => str_replace(
                ',',
                '.',
                str_replace('.', '', $request->sub_total)
            ),
            // 'grand_total' => str_replace('.', '', $request->sub_total),
            'sisa' => str_replace(',', '.', str_replace('.', '', $request->sisa)),
            // 'sisa' => str_replace('.', '', $request->sisa),
            'biaya_tambahan' => str_replace(',', '.', str_replace('.', '', $request->biaya_tambahan)),
            // 'biaya_tambahan' => str_replace('.', '', $request->biaya_tambahan),
            'keterangan' => $request->keterangan,
            'tanggal' => $format_tanggal,
            'tanggal_awal' => $tanggal,
            'qrcode_faktur' => 'https://batlink.id/faktur_ekspedisispk/' . $kode,
            'status' => 'posting',
            'status_notif' => false,
        ]);

        if ($request->kategori == "PPH") {
            Pph::create([
                'faktur_ekspedisi_id' => $cetakpdf->id,
                'kode_faktur' => $cetakpdf->kode_faktur,
                'pelanggan_id' => $request->pelanggan_id,
                'kode_pelanggan' => $request->kode_pelanggan,
                'nama_pelanggan' => $request->nama_pelanggan,
                'pph' => str_replace(',', '.', str_replace('.', '', $request->pph)),
                'tanggal' => $format_tanggal,
                'status' => 'posting',
                'tanggal_awal' => $tanggal,
            ]);
        }


        $transaksi_id = $cetakpdf->id;

        if ($request->kategoris == "memo") {
            if ($cetakpdf) {
                foreach ($data_pembelians as $data_pesanan) {
                    // Simpan Detail_faktur baru
                    $detailfaktur = Detail_faktur::create([
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
                        'kode_memotambahan' => $data_pesanan['kode_memotambahan'] ? $data_pesanan['kode_memotambahan'] : null,
                        'tanggal_memotambahan' => $data_pesanan['tanggal_memotambahan'] ? $data_pesanan['tanggal_memotambahan'] : null,
                        'nama_drivertambahan' => $data_pesanan['nama_drivertambahan'] ? $data_pesanan['nama_drivertambahan'] : null,
                        'nama_rutetambahan' => $data_pesanan['nama_rutetambahan'] ? $data_pesanan['nama_rutetambahan'] : null,

                    ]);

                    // Update status memo ekspedisi
                    $memo = Memo_ekspedisi::find($data_pesanan['memo_ekspedisi_id']);
                    $memo->update(['status_memo' => 'aktif', 'status' => 'selesai', 'status_terpakai' => 'digunakan']);

                    // Update the related SPK status
                    if (
                        $memo && $memo->spk
                    ) {
                        $memo->spk->update(['status_spk' => 'faktur']);
                    }

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

        if ($cetakpdf) {

            foreach ($data_pembelians4 as $data_pesanan) {
                Detail_tariftambahan::create([
                    'faktur_ekspedisi_id' => $cetakpdf->id,
                    'keterangan_tambahan' => $data_pesanan['keterangan_tambahan'],
                    'nominal_tambahan' => str_replace('.', '', $data_pesanan['nominal_tambahan']),
                    'qty_tambahan' => $data_pesanan['qty_tambahan'],
                    'satuan_tambahan' => $data_pesanan['satuan_tambahan'],
                ]);
            }
        }

        $details = Detail_faktur::where('faktur_ekspedisi_id', $cetakpdf->id)->get();
        $detailtarifs = Detail_tariftambahan::where('faktur_ekspedisi_id', $cetakpdf->id)->get();

        return view('admin.faktur_ekspedisispk.show', compact('cetakpdf', 'details', 'detailtarifs'));
    }


    // public function kode()
    // {
    //     $item = Faktur_ekspedisi::all();
    //     if ($item->isEmpty()) {
    //         $num = "000001";
    //     } else {
    //         $id = Faktur_ekspedisi::getId();
    //         foreach ($id as $value);
    //         $idlm = $value->id;
    //         $idbr = $idlm + 1;
    //         $num = sprintf("%06s", $idbr);
    //     }

    //     $data = 'FE';
    //     $kode_item = $data . $num;
    //     return $kode_item;
    // }


    // public function kode()
    // {
    //     $lastBarang = Faktur_ekspedisi::latest()->first();
    //     if (!$lastBarang) {
    //         $num = 1;
    //     } else {
    //         $lastCode = $lastBarang->kode_faktur;
    //         $num = (int) substr($lastCode, strlen('FE')) + 1;
    //     }
    //     $formattedNum = sprintf("%06s", $num);
    //     $prefix = 'FE';
    //     $newCode = $prefix . $formattedNum;
    //     return $newCode;
    // }

    public function kode()
    {
        // Mengambil kode terbaru dari database dengan awalan 'MP'
        $lastBarang = Faktur_ekspedisi::where('kode_faktur', 'like', 'FE%')->latest()->first();

        // Mendapatkan hari dari tanggal kode terakhir
        $lastDay = $lastBarang ? date('d', strtotime($lastBarang->created_at)) : null;
        $currentDay = date('d');

        // Jika tidak ada kode sebelumnya atau hari ini berbeda dari hari kode terakhir
        if (!$lastBarang || $currentDay != $lastDay) {
            $num = 1; // Mulai dari 1 jika hari berbeda
        } else {
            // Jika ada kode sebelumnya, ambil nomor terakhir
            $lastCode = $lastBarang->kode_faktur;

            // Pisahkan kode menjadi bagian-bagian terpisah
            $parts = explode('/', $lastCode);
            $lastNum = end($parts); // Ambil bagian terakhir sebagai nomor terakhir
            $num = (int) $lastNum + 1; // Tambahkan 1 ke nomor terakhir
        }

        // Format nomor dengan leading zeros sebanyak 6 digit
        $formattedNum = sprintf("%03s", $num);

        // Awalan untuk kode baru
        $prefix = 'FE';
        $tahun = date('y');
        $tanggal = date('dm');

        // Buat kode baru dengan menggabungkan awalan, tanggal, tahun, dan nomor yang diformat
        $newCode = $prefix . "/" . $tanggal . $tahun . "/" . $formattedNum;

        // Kembalikan kode
        return $newCode;
    }


    public function show($id)
    {
        $cetakpdf = Faktur_ekspedisi::where('id', $id)->first();

        return view('admin.memo_ekspedisi.show', compact('cetakpdf'));
    }

    public function cetakpdf($id)
    {
        $cetakpdf = Faktur_ekspedisi::where('id', $id)->first();
        $details = Detail_faktur::where('faktur_ekspedisi_id', $cetakpdf->id)->get();
        $detailtarifs = Detail_tariftambahan::where('faktur_ekspedisi_id', $cetakpdf->id)->get();


        $pdf = PDF::loadView('admin.faktur_ekspedisispk.cetak_pdf', compact('cetakpdf', 'details', 'detailtarifs'));
        $pdf->setPaper('letter', 'portrait'); // Set the paper size to portrait letter

        return $pdf->stream('Faktur_ekspedisi.pdf');
    }
}