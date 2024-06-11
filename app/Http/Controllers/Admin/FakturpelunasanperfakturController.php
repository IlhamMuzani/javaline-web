<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Detail_pelunasan;
use App\Models\Detail_pelunasanpotongan;
use App\Models\Detail_pelunasanreturn;
use App\Models\Detail_return;
use App\Models\Faktur_ekspedisi;
use App\Models\Faktur_pelunasan;
use App\Models\Faktur_penjualanreturn;
use App\Models\Nota_return;
use App\Models\Pelanggan;
use App\Models\Potongan_penjualan;
use App\Models\Return_ekspedisi;
use App\Models\Tagihan_ekspedisi;
use App\Models\Tarif;
use Illuminate\Support\Facades\Validator;

class FakturpelunasanperfakturController extends Controller
{
    public function index()
    {
        $pelanggans = Pelanggan::all();
        $fakturs = Faktur_ekspedisi::where(['status_pelunasan' => null, 'status' => 'posting'])->get();
        $returns = Nota_return::all();

        return view('admin.faktur_pelunasanperfaktur.index', compact('pelanggans', 'fakturs', 'returns'));
    }


    public function store(Request $request)
    {
        $validasi_pelanggan = Validator::make(
            $request->all(),
            [
                'pelanggan_id' => 'required',
                'faktur_ekspedisi_id' => 'required',
            ],
            [
                'pelanggan_id.required' => 'Pilih Pelanggan',
                'faktur_ekspedisi_id.required' => 'Pilih Faktur',
            ]
        );

        $error_pelanggans = array();

        if ($validasi_pelanggan->fails()) {
            array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
        }

        $error_pesanans = array();
        $data_pembelians = collect();

        if ($request->has('faktur_ekspedisi_id')) {
            for ($i = 0; $i < count($request->faktur_ekspedisi_id); $i++) {
                $validasi_produk = Validator::make($request->all(), [
                    'faktur_ekspedisi_id.' . $i => 'required',
                    'kode_faktur.' . $i => 'required',
                    'tanggal_faktur.' . $i => 'required',
                    'total_faktur.' . $i => 'required',
                    // 'nota_return_id.' . $i => 'required',
                    // 'kode_return.' . $i => 'required',
                    // 'tanggal_return.' . $i => 'required',
                    // 'total_return.' . $i => 'required',
                    'total.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Faktur nomor " . ($i + 1) . " belum dilengkapi!"); // Corrected the syntax for concatenation and indexing
                }
                $faktur_ekspedisi_id = is_null($request->faktur_ekspedisi_id[$i]) ? '' : $request->faktur_ekspedisi_id[$i];
                $kode_faktur = is_null($request->kode_faktur[$i]) ? '' : $request->kode_faktur[$i];
                $tanggal_faktur = is_null($request->tanggal_faktur[$i]) ? '' : $request->tanggal_faktur[$i];
                $total_faktur = is_null($request->total_faktur[$i]) ? '' : $request->total_faktur[$i];

                $nota_return_id = empty($request->nota_return_id[$i]) ? null : $request->nota_return_id[$i];
                $kode_return = empty($request->kode_return[$i]) ? null : $request->kode_return[$i];
                $tanggal_return = empty($request->tanggal_return[$i]) ? null : $request->tanggal_return[$i];
                $total_return = empty($request->total_return[$i]) ? null : $request->total_return[$i];
                $total = is_null($request->total[$i]) ? '' : $request->total[$i];

                $data_pembelians->push([
                    'faktur_ekspedisi_id' => $faktur_ekspedisi_id,
                    'kode_faktur' => $kode_faktur,
                    'tanggal_faktur' => $tanggal_faktur,
                    'total_faktur' => $total_faktur,
                    'nota_return_id' => $nota_return_id,
                    'kode_return' => $kode_return,
                    'tanggal_return' => $tanggal_return,
                    'total_return' => $total_return,
                    'total' => $total
                ]);
            }
        }

        if ($error_pelanggans || $error_pesanans) {
            return back()
                ->withInput()
                ->with('error_pelanggans', $error_pelanggans)
                ->with('error_pesanans', $error_pesanans)
                ->with('data_pembelians', $data_pembelians);
        }



        $kode = $this->kode();
        // format tanggal indo
        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');

        $selisih = (int)str_replace(['Rp', '.', ' '], '', $request->selisih);
        $totalpembayaran = (int)str_replace(['Rp', '.', ' '], '', $request->totalpembayaran);
        $tanggal = Carbon::now()->format('Y-m-d');
        $cetakpdf = Faktur_pelunasan::create([
            'user_id' => auth()->user()->id,
            'kode_pelunasan' => $this->kode(),
            'pelanggan_id' => $request->pelanggan_id,
            'kode_pelanggan' => $request->kode_pelanggan,
            'nama_pelanggan' => $request->nama_pelanggan,
            'alamat_pelanggan' => $request->alamat_pelanggan,
            'telp_pelanggan' => $request->telp_pelanggan,
            'keterangan' => $request->keterangan,
            // 'totalpenjualan' => str_replace('.', '', $request->totalpenjualan),
            'totalpenjualan' => str_replace(',', '.', str_replace('.', '', $request->totalpenjualan)),
            // 'dp' => str_replace('.', '', $request->dp),
            'dp' => str_replace(',', '.', str_replace('.', '', $request->dp)),
            // 'potonganselisih' => str_replace('.', '', $request->potonganselisih),
            'potonganselisih' => str_replace(',', '.', str_replace('.', '', $request->potonganselisih)),
            // 'totalpembayaran' => (int)str_replace(['Rp', '.', ' '], '', $request->totalpembayaran),
            'totalpembayaran' => str_replace(',', '.', str_replace('.', '', $request->totalpembayaran)),
            // 'selisih' => (int)str_replace(['Rp', '.', ' '], '', $request->selisih),
            'selisih' => str_replace(',', '.', str_replace('.', '', $request->selisih)),
            // 'potongan' => $request->potongan ? str_replace('.', '', $request->potongan) : 0,
            'potongan' => $request->potongan ? str_replace(',', '.', str_replace('.', '', $request->potongan)) : 0,
            // 'ongkos_bongkar' => $request->ongkos_bongkar ? str_replace('.', '', $request->ongkos_bongkar) : 0,
            'ongkos_bongkar' => $request->ongkos_bongkar ? str_replace(',', '.', str_replace('.', '', $request->ongkos_bongkar)) : 0,

            'kategori' => $request->kategori,
            'nomor' => $request->nomor,
            'tanggal_transfer' => $request->tanggal_transfer,
            // 'nominal' => str_replace('.', '', $request->nominal),
            'nominal' => str_replace(',', '.', str_replace('.', '', $request->nominal)),
            'tanggal' => $format_tanggal,
            'tanggal_awal' => $tanggal,
            'qrcode_pelunasan' => 'https://javaline.id/faktur_pelunasan/' . $kode,
            'status' => 'posting',
            'status_notif' => false,
        ]);

        $transaksi_id = $cetakpdf->id;

        // if ($cetakpdf) {
        //     foreach ($data_pembelians as $data_pesanan) {
        //         $detailPelunasan = Detail_pelunasan::create([
        //             'pelunasan_id' => $cetakpdf->id,
        //             'faktur_ekspedisi_id' => $data_pesanan['faktur_ekspedisi_id'],
        //             'kode_faktur' => $data_pesanan['kode_faktur'],
        //             'tanggal_faktur' => $data_pesanan['tanggal_faktur'],
        //             'total_faktur' => str_replace('.', '', $data_pesanan['total_faktur']),
        //             'nota_return_id' => $data_pesanan['nota_return_id'],
        //             'kode_return' => $data_pesanan['kode_return'],
        //             'tanggal_return' => $data_pesanan['tanggal_return'],
        //             'total_return' => str_replace('.', '', $data_pesanan['total_return']),
        //             'nota_return_id' => $data_pesanan['nota_return_id'] ?? null,
        //             'kode_return' => $data_pesanan['kode_return'] ?? null,
        //             'tanggal_return' => $data_pesanan['tanggal_return'] ?? null,
        //             'total_return' => isset($data_pesanan['total_return']) && $data_pesanan['total_return'] !== ''
        //             ? str_replace('.', '', $data_pesanan['total_return'])
        //             : null,

        //             'total' => str_replace('.', '', $data_pesanan['total']),
        //         ]);
        //         Faktur_ekspedisi::where('id', $detailPelunasan->faktur_ekspedisi_id)->update(['status_pelunasan' => 'aktif']);
        //     }
        // }

        foreach ($data_pembelians as $data_pesanan) {
            $detailPelunasan = Detail_pelunasan::create([
                'pelunasan_id' => $cetakpdf->id,
                'faktur_ekspedisi_id' => $data_pesanan['faktur_ekspedisi_id'],
                'kode_faktur' => $data_pesanan['kode_faktur'],
                'tanggal_faktur' => $data_pesanan['tanggal_faktur'],
                // 'total_faktur' => str_replace('.', '', $data_pesanan['total_faktur']),
                'total_faktur' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['total_faktur'])),
                'nota_return_id' => empty($data_pesanan['nota_return_id']) ? null : $data_pesanan['nota_return_id'],
                'kode_return' => empty($data_pesanan['kode_return']) ? null : $data_pesanan['kode_return'],
                'tanggal_return' => empty($data_pesanan['tanggal_return']) ? null : $data_pesanan['tanggal_return'],
                'total_return' => empty($data_pesanan['total_return'])
                    ? null
                    : str_replace(',', '.', str_replace('.', '', $data_pesanan['total_return'])),
                'total' => str_replace(',', '.', str_replace('.', '', $data_pesanan['total'])),
            ]);

            // Assuming the status_pelunasan update is correct
            Faktur_ekspedisi::where('id', $detailPelunasan->faktur_ekspedisi_id)->update(['status_pelunasan' => 'aktif']);
        }


        $details = Detail_pelunasan::where('pelunasan_id', $cetakpdf->id)->get();

        return view('admin.faktur_pelunasan.show', compact('cetakpdf', 'details'));
    }

    public function kode()
    {
        $lastBarang = Faktur_pelunasan::latest()->first();
        if (!$lastBarang) {
            $num = 1;
        } else {
            $lastCode = $lastBarang->kode_pelunasan;
            $num = (int) substr($lastCode, strlen('LP')) + 1;
        }
        $formattedNum = sprintf("%06s", $num);
        $prefix = 'LP';
        $newCode = $prefix . $formattedNum;
        return $newCode;
    }

}