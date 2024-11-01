<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Detail_cicilan;
use App\Models\Detail_gajikaryawan;
use App\Models\Detail_pelunasandeposit;
use App\Models\Detail_pengeluaran;
use App\Models\Detail_tariftambahan;
use App\Models\Karyawan;
use App\Models\Kasbon_karyawan;
use App\Models\Pelunasan_deposit;
use App\Models\Pengeluaran_kaskecil;
use App\Models\Perhitungan_gajikaryawan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PerhitungangajibulananController extends Controller
{
    public function index()
    {
        $karyawans = Karyawan::whereIn('departemen_id', [1, 4, 5])
            ->orderBy('nama_lengkap')
            ->get();
        return view('admin.perhitungan_gajibulanan.index', compact('karyawans'));
    }

    public function store(Request $request)
    {
        $validasi_pelanggan = Validator::make(
            $request->all(),
            [
                'periode_awal' => 'required',
                'periode_akhir' => 'required',
            ],
            [
                'periode_awal.required' => 'Masukkan periode awal',
                'periode_akhir.required' => 'Masukkan periode akhir',
            ]
        );

        $error_pelanggans = array();

        if ($validasi_pelanggan->fails()) {
            array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
        }

        $error_pesanans = array();
        $data_pembelians = collect();

        if ($request->has('karyawan_id')) {
            for ($i = 0; $i < count($request->karyawan_id); $i++) {
                $validasi_produk = Validator::make($request->all(), [
                    'karyawan_id.' . $i => 'required',
                    'kode_karyawan.' . $i => 'required',
                    'nama_lengkap.' . $i => 'required',
                    'gaji.' . $i => 'required',
                    'gaji_perhari.' . $i => 'required',
                    'hari_efektif.' . $i => 'required',
                    'hari_kerja.' . $i => 'required',
                    // 'lembur.' . $i => 'required',
                    // 'hasil_lembur.' . $i => 'required',
                    // 'storing.' . $i => 'required',
                    // 'hasil_storing.' . $i => 'required',
                    'gaji_kotor.' . $i => 'required',
                    // 'kurangtigapuluh.' . $i => 'required',
                    // 'lebihtigapuluh.' . $i => 'required',
                    // 'hasilkurang.' . $i => 'required',
                    // 'hasillebih.' . $i => 'required',
                    // 'pelunasan_kasbon.' . $i => 'required',
                    // 'potongan_bpjs.' . $i => 'required',
                    // 'absen.' . $i => 'required',
                    // 'hasil_absen.' . $i => 'required',
                    'gajinol_pelunasan.' . $i => 'required',
                    'gaji_bersih.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Perhitungan " . $i + 1 . " belum dilengkapi!");
                }

                $karyawan_id = $request->karyawan_id[$i] ?? '';
                $kode_karyawan = $request->kode_karyawan[$i] ?? '';
                $nama_lengkap = $request->nama_lengkap[$i] ?? '';
                $gaji = $request->gaji[$i] ?? '';
                $gaji_perhari = $request->gaji_perhari[$i] ?? '';
                $tdk_berangkat = $request->tdk_berangkat[$i] ?? 0;
                $hasiltdk_berangkat = $request->hasiltdk_berangkat[$i] ?? 0;
                $tgl_merah = $request->tgl_merah[$i] ?? 0;
                $hasiltgl_merah = $request->hasiltgl_merah[$i] ?? 0;
                $hari_efektif = $request->hari_efektif[$i] ?? '';
                $hari_kerja = $request->hari_kerja[$i] ?? '';
                $hasil_hk = $request->hasil_hk[$i] ?? '';
                $lembur = $request->lembur[$i] ?? 0;
                $hasil_lembur = $request->hasil_lembur[$i] ?? 0;
                $storing = $request->storing[$i] ?? 0;
                $hasil_storing = $request->hasil_storing[$i] ?? 0;
                $gaji_kotor = $request->gaji_kotor[$i] ?? 0;
                $kurangtigapuluh = $request->kurangtigapuluh[$i] ?? 0;
                $lebihtigapuluh = $request->lebihtigapuluh[$i] ?? 0;
                $hasilkurang = $request->hasilkurang[$i] ?? 0;
                $hasillebih = $request->hasillebih[$i] ?? 0;
                $pelunasan_kasbon = $request->pelunasan_kasbon[$i] ?? 0;
                $potongan_bpjs = $request->potongan_bpjs[$i] ?? '';
                $lainya = $request->lainya[$i] ?? 0;
                $absen = $request->absen[$i] ?? 0;
                $hasil_absen = $request->hasil_absen[$i] ?? 0;
                $gajinol_pelunasan = $request->gajinol_pelunasan[$i] ?? 0;
                $gaji_bersih = $request->gaji_bersih[$i] ?? 0;

                $data_pembelians->push([
                    'karyawan_id' => $karyawan_id,
                    'kode_karyawan' => $kode_karyawan,
                    'nama_lengkap' => $nama_lengkap,
                    'gaji' => $gaji,
                    'gaji_perhari' => $gaji_perhari,
                    'tdk_berangkat' => $tdk_berangkat,
                    'hasiltdk_berangkat' => $hasiltdk_berangkat,
                    'tgl_merah' => $tgl_merah,
                    'hasiltgl_merah' => $hasiltgl_merah,
                    'hari_efektif' => $hari_efektif,
                    'hari_kerja' => $hari_kerja,
                    'hasil_hk' => $hasil_hk,
                    'lembur' => $lembur,
                    'hasil_lembur' => $hasil_lembur,
                    'storing' => $storing,
                    'hasil_storing' => $hasil_storing,
                    'gaji_kotor' => $gaji_kotor,
                    'kurangtigapuluh' => $kurangtigapuluh,
                    'lebihtigapuluh' => $lebihtigapuluh,
                    'hasilkurang' => $hasilkurang,
                    'hasillebih' => $hasillebih,
                    'pelunasan_kasbon' => $pelunasan_kasbon,
                    'potongan_bpjs' => $potongan_bpjs,
                    'lainya' => $lainya,
                    'absen' => $absen,
                    'hasil_absen' => $hasil_absen,
                    'gajinol_pelunasan' => $gajinol_pelunasan,
                    'gaji_bersih' => $gaji_bersih,
                ]);
            }
        } else {
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
        $tanggal = Carbon::now()->format('Y-m-d');
        $cetakpdf = Perhitungan_gajikaryawan::create([
            'user_id' => auth()->user()->id,
            'kategori' => 'Bulanan',
            'kode_gaji' => $this->kode(),
            'periode_awal' => $request->periode_awal,
            'periode_akhir' => $request->periode_akhir,
            'keterangan' => $request->keterangan,
            'total_gaji' => str_replace(',', '.', str_replace('.', '', $request->total_gaji)),
            'total_pelunasan' => str_replace(',', '.', str_replace('.', '', $request->total_pelunasan)),
            'grand_total' => str_replace(',', '.', str_replace('.', '', $request->grand_total)),
            'tanggal' => $format_tanggal,
            'tanggal_awal' => $tanggal,
            'qr_code_perhitungan' => 'https://javaline.id/perhitungan_gajibulanan/' . $kode,
            'status' => 'unpost',
            'status_notif' => false,
        ]);

        $transaksi_id = $cetakpdf->id;
        $kodeban = $this->kodegaji();
        if ($cetakpdf) {
            foreach ($data_pembelians as $data_pesanan) {
                // Mendapatkan nilai potongan dari model Karyawan
                $karyawan = Karyawan::find($data_pesanan['karyawan_id']);
                // Simpan Detail_gajikaryawan baru
                $detailfaktur = Detail_gajikaryawan::create([
                    'kode_gajikaryawan' => $this->kodegaji(),
                    'kategori' => 'Bulanan',
                    'perhitungan_gajikaryawan_id' => $cetakpdf->id,
                    'karyawan_id' => $data_pesanan['karyawan_id'],
                    'kode_karyawan' => $data_pesanan['kode_karyawan'],
                    'nama_lengkap' => $data_pesanan['nama_lengkap'],
                    'gaji' => str_replace(',', '.', str_replace('.', '', $data_pesanan['gaji'])),
                    'gaji_perhari' => str_replace(',', '.', str_replace('.', '', $data_pesanan['gaji_perhari'])),
                    'tdk_berangkat' => $data_pesanan['tdk_berangkat'],
                    'hasiltdk_berangkat' => str_replace(',', '.', str_replace('.', '', $data_pesanan['hasiltdk_berangkat'])),
                    'tgl_merah' => $data_pesanan['tgl_merah'],
                    'hasiltgl_merah' => str_replace(',', '.', str_replace('.', '', $data_pesanan['hasiltgl_merah'])),
                    'hari_efektif' => $data_pesanan['hari_efektif'],
                    // 'hari_kerja' => $data_pesanan['hari_kerja'],
                    'hari_kerja' => str_replace(',', '.', str_replace('.', '', $data_pesanan['hari_kerja'])),
                    'hasil_hk' => str_replace(',', '.', str_replace('.', '', $data_pesanan['hasil_hk'])),
                    'lembur' => $data_pesanan['lembur'],
                    'hasil_lembur' => str_replace(',', '.', str_replace('.', '', $data_pesanan['hasil_lembur'])),
                    'storing' => $data_pesanan['storing'],
                    // 'hasil_storing' => str_replace('.', '', $data_pesanan['hasil_storing']),
                    'hasil_storing' => str_replace(',', '.', str_replace('.', '', $data_pesanan['hasil_storing'])),
                    'gaji_kotor' => str_replace(',', '.', str_replace('.', '', $data_pesanan['gaji_kotor'])),
                    'kurangtigapuluh' => $data_pesanan['kurangtigapuluh'],
                    'lebihtigapuluh' => $data_pesanan['lebihtigapuluh'],
                    'hasilkurang' => str_replace(',', '.', str_replace('.', '', $data_pesanan['hasilkurang'])),
                    'hasillebih' => str_replace(',', '.', str_replace('.', '', $data_pesanan['hasillebih'])),
                    'pelunasan_kasbon' => str_replace(',', '.', str_replace('.', '', $data_pesanan['pelunasan_kasbon'])),
                    'potongan_bpjs' => !empty($data_pesanan['potongan_bpjs']) ? str_replace('.', '', $data_pesanan['potongan_bpjs']) : null,
                    'lainya' => str_replace('.', '', $data_pesanan['lainya']),
                    'absen' => $data_pesanan['absen'],
                    'hasil_absen' => str_replace(',', '.', str_replace('.', '', $data_pesanan['hasil_absen'])),
                    'gajinol_pelunasan' => str_replace(',', '.', str_replace('.', '', $data_pesanan['gajinol_pelunasan'])),
                    'gaji_bersih' => str_replace(',', '.', str_replace('.', '', $data_pesanan['gaji_bersih'])),
                    'kasbon_awal' => $karyawan ? $karyawan->kasbon : 0,
                    'sisa_kasbon' => $karyawan->kasbon,
                    'status' => 'unpost',
                    'tanggal' => $format_tanggal,
                    'tanggal_awal' => $tanggal,
                ]);
                $detail_cicilan = Detail_cicilan::where('karyawan_id', $data_pesanan['karyawan_id'])
                    ->where('status', 'posting')
                    ->where('status_cicilan', 'belum lunas')
                    ->whereNull('detail_gajikaryawan_id')
                    ->first();

                if ($detail_cicilan) {
                    $detail_cicilan->update([
                        // 'status_cicilan' => 'belum lunas',
                        'detail_gajikaryawan_id' =>  $detailfaktur->id,
                    ]);
                }
            }
        }

        $kodepengeluaran = $this->kodepengeluaran();

        $pengeluarans =  Pengeluaran_kaskecil::create([
            'perhitungan_gajikaryawan_id' => $cetakpdf->id,
            'user_id' => auth()->user()->id,
            'kode_pengeluaran' => $this->kodepengeluaran(),
            // 'kendaraan_id' => $request->kendaraan_id,
            'keterangan' => $request->keterangan,
            'grand_total' => str_replace(',', '.', str_replace('.', '', $request->grand_total)),
            'jam' => $tanggal1->format('H:i:s'),
            'tanggal' => $format_tanggal,
            'tanggal_awal' => $tanggal,
            'qrcode_return' => 'https://javaline.id/pengeluaran_kaskecil/' . $kodepengeluaran,
            'status' => 'unpost',
        ]);

        Detail_pengeluaran::create([
            'pengeluaran_kaskecil_id' => $pengeluarans->id,
            'perhitungan_gajikaryawan_id' => $cetakpdf->id,
            'barangakun_id' => 1,
            'kode_detailakun' => $this->kodeakuns(),
            'kode_akun' => 'KA000001',
            'nama_akun' => 'GAJI & TUNJANGAN',
            'keterangan' => $request->keterangan,
            'nominal' => str_replace(',', '.', str_replace('.', '', $request->grand_total)),
            'status' => 'unpost',
        ]);

        $details = Detail_gajikaryawan::where('perhitungan_gajikaryawan_id', $cetakpdf->id)->get();

        return view('admin.perhitungan_gajibulanan.show', compact('details', 'cetakpdf'));
    }


    public function kodepelunasan()
    {
        // Mengambil kode terbaru dari database dengan awalan 'MP'
        $lastBarang = Pelunasan_deposit::where('kode_pelunasan', 'like', 'DK%')->latest()->first();

        // Jika tidak ada kode sebelumnya, mulai dengan 1
        if (!$lastBarang) {
            $num = 1;
        } else {
            // Jika ada kode sebelumnya, ambil nomor terakhir
            $lastCode = $lastBarang->kode_pelunasan;

            // Ambil nomor dari kode terakhir, tanpa awalan 'MP', lalu tambahkan 1
            $num = (int) substr($lastCode, strlen('DK')) + 1;
        }

        // Format nomor dengan leading zeros sebanyak 6 digit
        $formattedNum = sprintf("%06s", $num);

        // Awalan untuk kode baru
        $prefix = 'DK';

        // Buat kode baru dengan menggabungkan awalan dan nomor yang diformat
        $newCode = $prefix . $formattedNum;

        // Kembalikan kode
        return $newCode;
    }

    public function kodeakuns()
    {
        try {
            return DB::transaction(function () {
                // Mengambil kode terbaru dari database dengan awalan 'KKA'
                $lastBarang = Detail_pengeluaran::where('kode_detailakun', 'like', 'KKA%')->latest()->first();

                // Mendapatkan bulan dari tanggal kode terakhir
                $lastMonth = $lastBarang ? date('m', strtotime($lastBarang->created_at)) : null;
                $currentMonth = date('m');

                // Jika tidak ada kode sebelumnya atau bulan saat ini berbeda dari bulan kode terakhir
                if (!$lastBarang || $currentMonth != $lastMonth) {
                    $num = 1; // Mulai dari 1 jika bulan berbeda
                } else {
                    // Jika ada kode sebelumnya, ambil nomor terakhir
                    $lastCode = $lastBarang->kode_detailakun;

                    // Pisahkan kode menjadi bagian-bagian terpisah
                    $parts = explode('/', $lastCode);
                    $lastNum = end($parts); // Ambil bagian terakhir sebagai nomor terakhir
                    $num = (int) $lastNum + 1; // Tambahkan 1 ke nomor terakhir
                }

                // Format nomor dengan leading zeros sebanyak 6 digit
                $formattedNum = sprintf("%06s", $num);

                // Awalan untuk kode baru
                $prefix = 'KKA';
                $tahun = date('y');
                $tanggal = date('dm');

                // Buat kode baru dengan menggabungkan awalan, tanggal, tahun, dan nomor yang diformat
                $newCode = $prefix . "/" . $tanggal . $tahun . "/" . $formattedNum;

                // Kembalikan kode
                return $newCode;
            });
        } catch (\Throwable $e) {
            // Jika terjadi kesalahan, melanjutkan dengan kode berikutnya
            $lastCode = Detail_pengeluaran::where('kode_detailakun', 'like', 'KKA%')->latest()->value('kode_detailakun');
            if (!$lastCode) {
                $lastNum = 0;
            } else {
                $parts = explode('/', $lastCode);
                $lastNum = end($parts);
            }
            $nextNum = (int) $lastNum + 1;
            $formattedNextNum = sprintf("%06s", $nextNum);
            $tahun = date('y');
            $tanggal = date('dm');
            return 'KKA/' . $tanggal . $tahun . "/" . $formattedNextNum;
        }
    }

    public function kodepengeluaran()
    {
        try {
            return DB::transaction(function () {
                // Mengambil kode terbaru dari database dengan awalan 'KK'
                $lastBarang = Pengeluaran_kaskecil::where('kode_pengeluaran', 'like', 'KK%')->latest()->first();

                // Mendapatkan bulan dari tanggal kode terakhir
                $lastMonth = $lastBarang ? date('m', strtotime($lastBarang->created_at)) : null;
                $currentMonth = date('m');

                // Jika tidak ada kode sebelumnya atau bulan saat ini berbeda dari bulan kode terakhir
                if (!$lastBarang || $currentMonth != $lastMonth) {
                    $num = 1; // Mulai dari 1 jika bulan berbeda
                } else {
                    // Jika ada kode sebelumnya, ambil nomor terakhir
                    $lastCode = $lastBarang->kode_pengeluaran;

                    // Pisahkan kode menjadi bagian-bagian terpisah
                    $parts = explode('/', $lastCode);
                    $lastNum = end($parts); // Ambil bagian terakhir sebagai nomor terakhir
                    $num = (int) $lastNum + 1; // Tambahkan 1 ke nomor terakhir
                }

                // Format nomor dengan leading zeros sebanyak 6 digit
                $formattedNum = sprintf("%06s", $num);

                // Awalan untuk kode baru
                $prefix = 'KK';
                $tahun = date('y');
                $tanggal = date('dm');

                // Buat kode baru dengan menggabungkan awalan, tanggal, tahun, dan nomor yang diformat
                $newCode = $prefix . "/" . $tanggal . $tahun . "/" . $formattedNum;

                // Kembalikan kode
                return $newCode;
            });
        } catch (\Throwable $e) {
            // Jika terjadi kesalahan, melanjutkan dengan kode berikutnya
            $lastCode = Pengeluaran_kaskecil::where('kode_pengeluaran', 'like', 'KK%')->latest()->value('kode_pengeluaran');
            if (!$lastCode) {
                $lastNum = 0;
            } else {
                $parts = explode('/', $lastCode);
                $lastNum = end($parts);
            }
            $nextNum = (int) $lastNum + 1;
            $formattedNextNum = sprintf("%06s", $nextNum);
            $tahun = date('y');
            $tanggal = date('dm');
            return 'KK/' . $tanggal . $tahun . "/" . $formattedNextNum;
        }
    }

    public function kode()
    {
        // Mengambil kode terbaru dari database dengan awalan 'MP'
        $lastBarang = Perhitungan_gajikaryawan::where('kode_gaji', 'like', 'GJB%')->latest()->first();

        // Jika tidak ada kode sebelumnya, mulai dengan 1
        if (!$lastBarang) {
            $num = 1;
        } else {
            // Jika ada kode sebelumnya, ambil nomor terakhir
            $lastCode = $lastBarang->kode_gaji;

            // Ambil nomor dari kode terakhir, tanpa awalan 'MP', lalu tambahkan 1
            $num = (int) substr($lastCode, strlen('GJB')) + 1;
        }

        // Format nomor dengan leading zeros sebanyak 6 digit
        $formattedNum = sprintf("%06s", $num);

        // Awalan untuk kode baru
        $prefix = 'GJB';

        // Buat kode baru dengan menggabungkan awalan dan nomor yang diformat
        $newCode = $prefix . $formattedNum;

        // Kembalikan kode
        return $newCode;
    }

    // public function kodegaji()
    // {
    //     $lastBarang = Detail_gajikaryawan::latest()->first();
    //     if (!$lastBarang) {
    //         $num = 1;
    //     } else {
    //         $lastCode = $lastBarang->kode_gajikaryawan;
    //         $num = (int) substr($lastCode, strlen('GK')) + 1;
    //     }
    //     $formattedNum = sprintf("%06s", $num);
    //     $prefix = 'GK';
    //     $newCode = $prefix . $formattedNum;
    //     return $newCode;
    // }

    public function kodegaji()
    {
        $gaji = Detail_gajikaryawan::all();
        if ($gaji->isEmpty()) {
            $num = "000001";
        } else {
            $id = Detail_gajikaryawan::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'GK';
        $kodeGaji = $data . $num;
        return $kodeGaji;
    }


    public function cetakpdf($id)
    {
        $cetakpdf = Perhitungan_gajikaryawan::where('id', $id)->first();
        $details = Detail_gajikaryawan::where('perhitungan_gajikaryawan_id', $cetakpdf->id)->get();

        $pdf = PDF::loadView('admin.perhitungan_gajibulanan.cetak_pdf', compact('cetakpdf', 'details'))->setPaper('a4', 'landscape');

        return $pdf->stream('Gaji_karyawan.pdf');
    }

    // public function get_item($id)
    // {
    //     $barang = Karyawan::where('id', $id)->first();
    //     return $barang;
    // }
}