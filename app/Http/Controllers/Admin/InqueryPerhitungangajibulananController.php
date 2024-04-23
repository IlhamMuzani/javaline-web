<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use App\Models\Merek;
use App\Models\Ukuran;
use App\Models\Typeban;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\Perhitungan_gajikaryawan;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\Detail_cicilan;
use App\Models\Detail_gajikaryawan;
use App\Models\Detail_pelunasandeposit;
use App\Models\Detail_pengeluaran;
use App\Models\Karyawan;
use App\Models\Kasbon_karyawan;
use App\Models\Pelunasan_deposit;
use App\Models\Pengeluaran_kaskecil;
use App\Models\Saldo;
use App\Models\Total_kasbon;
use Illuminate\Support\Facades\Validator;
use Egulias\EmailValidator\Result\Reason\DetailedReason;

class InqueryPerhitungangajibulananController extends Controller
{
    public function index(Request $request)
    {
        // Memperbaharui status_notif untuk entri yang memenuhi kriteria
        Perhitungan_gajikaryawan::where('status', 'posting')
            ->update(['status_notif' => true]);

        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        // Membuat query awal dengan kategori 'Mingguan'
        $inquery = Perhitungan_gajikaryawan::where('kategori', 'Bulanan');

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
            // Jika tidak ada filter tanggal, hanya mengambil hari ini
            $inquery->whereDate('tanggal_awal', Carbon::today());
        }

        // Menyusun hasil query
        $inquery->orderBy('id', 'DESC');
        $inquery = $inquery->get();

        return view('admin.inquery_perhitungangajibulan.index', compact('inquery'));
    }

    public function edit($id)
    {
        // if (auth()->check() && auth()->user()->menu['inquery pembelian ban']) {

        $inquery = Perhitungan_gajikaryawan::where('id', $id)->first();
        $karyawans = Karyawan::where('departemen_id', 1)
            ->orderBy('nama_lengkap')
            ->get();
        $details = Detail_gajikaryawan::where('perhitungan_gajikaryawan_id', $id)->get();

        return view('admin.inquery_perhitungangajibulan.update', compact('inquery', 'karyawans', 'details'));
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
                    // 'keterlambatan.' . $i => 'required',
                    // 'pelunasan_kasbon.' . $i => 'required',
                    // 'absen.' . $i => 'required',
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
                    'detail_id' => $request->detail_ids[$i] ?? null,
                    'karyawan_id' => $karyawan_id,
                    'kode_karyawan' => $kode_karyawan,
                    'nama_lengkap' => $nama_lengkap,
                    'gaji' => $gaji,
                    'gaji_perhari' => $gaji_perhari,
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

        // format tanggal indo
        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');

        $tanggal = Carbon::now()->format('Y-m-d');
        $transaksi = Perhitungan_gajikaryawan::findOrFail($id);

        // Update the main transaction
        $transaksi->update([
            'periode_awal' => $request->periode_awal,
            'periode_akhir' => $request->periode_akhir,
            'keterangan' => $request->keterangan,
            'total_gaji' => str_replace(',', '.', str_replace('.', '', $request->total_gaji)),
            'total_pelunasan' => str_replace(',', '.', str_replace('.', '', $request->total_pelunasan)),
            'grand_total' => str_replace(',', '.', str_replace('.', '', $request->grand_total)),
        ]);

        $transaksi_id = $transaksi->id;

        $detailIds = $request->input('detail_ids');

        foreach ($data_pembelians as $data_pesanan) {
            $detailId = $data_pesanan['detail_id'];

            if ($detailId) {
                // Mendapatkan nilai potongan dari model Karyawan
                $karyawan = Karyawan::find($data_pesanan['karyawan_id']);

                $detailfakturs = Detail_gajikaryawan::where('id', $detailId)->update([
                    'perhitungan_gajikaryawan_id' => $transaksi->id,
                    'karyawan_id' => $data_pesanan['karyawan_id'],
                    'kode_karyawan' => $data_pesanan['kode_karyawan'],
                    'nama_lengkap' => $data_pesanan['nama_lengkap'],
                    'gaji' => str_replace(',', '.', str_replace('.', '', $data_pesanan['gaji'])),
                    'gaji_perhari' => str_replace(',', '.', str_replace('.', '', $data_pesanan['gaji_perhari'])),
                    'hari_efektif' => $data_pesanan['hari_efektif'],
                    'hari_kerja' => $data_pesanan['hari_kerja'],
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
                $detail_gajikaryawan = Detail_gajikaryawan::find($detailId);
                $detail_cicilan = Detail_cicilan::where('karyawan_id', $data_pesanan['karyawan_id'])
                    ->where('status', 'posting')
                    ->where('status_cicilan', 'belum lunas')
                    ->first();
                if ($detail_cicilan) {
                    $detail_cicilan->update([
                        'detail_gajikaryawan_id' =>  $detail_gajikaryawan->id,
                    ]);
                }
            } else {
                $existingDetail = Detail_gajikaryawan::where([
                    'perhitungan_gajikaryawan_id' => $transaksi->id,
                    'karyawan_id' => $data_pesanan['karyawan_id'],
                ])->first();


                $kodeban = $this->kodegaji();

                // Mendapatkan nilai potongan dari model Karyawan
                $karyawan = Karyawan::find($data_pesanan['karyawan_id']);
                if (!$existingDetail) {
                    $detailfaktur = Detail_gajikaryawan::create([
                        'kode_gajikaryawan' => $this->kodegaji(),
                        'kategori' => 'Bulanan',
                        'perhitungan_gajikaryawan_id' => $transaksi->id,
                        'karyawan_id' => $data_pesanan['karyawan_id'],
                        'kode_karyawan' => $data_pesanan['kode_karyawan'],
                        'nama_lengkap' => $data_pesanan['nama_lengkap'],
                        'gaji' => str_replace(',', '.', str_replace('.', '', $data_pesanan['gaji'])),
                        'gaji_perhari' => str_replace(',', '.', str_replace('.', '', $data_pesanan['gaji_perhari'])),
                        'hari_efektif' => $data_pesanan['hari_efektif'],
                        'hari_kerja' => $data_pesanan['hari_kerja'],
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
                        ->first();
                    if ($detail_cicilan) {
                        $detail_cicilan->update([
                            'detail_gajikaryawan_id' =>  $detailfaktur->id,
                        ]);
                    }
                }
            }
        }
        $cetakpdf = Perhitungan_gajikaryawan::find($transaksi_id);
        $details = Detail_gajikaryawan::where('perhitungan_gajikaryawan_id', $cetakpdf->id)->get();

        return view('admin.inquery_perhitungangajibulan.show', compact('details', 'cetakpdf'));
    }

    public function show($id)
    {
        $cetakpdf = Perhitungan_gajikaryawan::where('id', $id)->first();
        $details = Detail_gajikaryawan::where('perhitungan_gajikaryawan_id', $cetakpdf->id)->get();

        return view('admin.inquery_perhitungangajibulan.show', compact('details', 'cetakpdf'));
    }

    public function unpostperhitunganbulanan($id)
    {
        try {
            $item = Perhitungan_gajikaryawan::findOrFail($id);

            $detailGaji = Detail_gajikaryawan::where('perhitungan_gajikaryawan_id', $id)->get();

            foreach ($detailGaji as $detail) {
                // Ubah status detail gaji menjadi 'unpost'
                $detail->update([
                    'status' => 'unpost'
                ]);

                // Perbarui kembali kasbon dan bayar_kasbon
                $karyawan = Karyawan::find($detail->karyawan_id);
                if ($karyawan) {
                    $kasbon = $karyawan->kasbon_backup;
                    $bayar_kasbon = $karyawan->bayar_kasbon_backup;

                    $karyawan->update([
                        'kasbon' => $kasbon,
                        'bayar_kasbon' => $bayar_kasbon,
                    ]);
                }

                // Perbarui detail cicilan untuk setiap karyawan yang terlibat
                $detail_cicilan = Detail_cicilan::where('detail_gajikaryawan_id', $detail->id)
                    ->where('status', 'posting')
                    ->where('status_cicilan', 'lunas')
                    ->latest() // Mengambil data terbaru berdasarkan waktu pembuatan
                    ->first();

                if ($detail_cicilan) {
                    $detail_cicilan->update([
                        'status_cicilan' => 'belum lunas', // Kembalikan status cicilan menjadi 'belum lunas'
                    ]);
                }
            }

            // Ubah status perhitungan gaji menjadi 'unpost'
            $item->update([
                'status' => 'unpost'
            ]);

            return back()->with('success', 'Berhasil');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // return back()->with('error', 'Memo tidak ditemukan');
        }
    }


    public function postingperhitunganbulanan($id)
    {
        try {
            $item = Perhitungan_gajikaryawan::findOrFail($id);

            $detailGaji = Detail_gajikaryawan::where('perhitungan_gajikaryawan_id', $id)->get();

            foreach ($detailGaji as $detail) {
                $detail->update([
                    'status' => 'posting'
                ]);

                // Perbarui detail cicilan untuk setiap karyawan yang terlibat
                $detail_cicilan = Detail_cicilan::where('detail_gajikaryawan_id', $detail->id)
                    ->where('status', 'posting')
                    ->where('status_cicilan', 'belum lunas')
                    ->first();

                if ($detail_cicilan) {
                    $detail_cicilan->update([
                        'status_cicilan' => 'lunas',
                    ]);
                }

                // Perbarui kasbon dan bayar_kasbon
                $karyawan = Karyawan::find($detail->karyawan_id);
                if ($karyawan) {
                    $kasbon = $karyawan->kasbon;
                    $bayar_kasbon = $karyawan->bayar_kasbon;
                    $karyawan->update([
                        'kasbon' => $kasbon - $detail->pelunasan_kasbon,
                        'bayar_kasbon' => $bayar_kasbon + $detail->pelunasan_kasbon,
                    ]);
                }
            }

            $item->update([
                'status' => 'posting'
            ]);

            return back()->with('success', 'Berhasil');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // return back()->with('error', 'Memo tidak ditemukan');
        }
    }


    public function kodegaji()
    {
        $lastBarang = Detail_gajikaryawan::latest()->first();
        if (!$lastBarang) {
            $num = 1;
        } else {
            $lastCode = $lastBarang->kode_gajikaryawan;
            $num = (int) substr($lastCode, strlen('GK')) + 1;
        }
        $formattedNum = sprintf("%06s", $num);
        $prefix = 'GK';
        $newCode = $prefix . $formattedNum;
        return $newCode;
    }


    public function kodeakuns()
    {
        $lastBarang = Detail_pengeluaran::latest()->first();
        if (!$lastBarang) {
            $num = 1;
        } else {
            $lastCode = $lastBarang->kode_detailakun;
            $num = (int) substr($lastCode, strlen('KKA')) + 1;
        }
        $formattedNum = sprintf("%06s", $num);
        $prefix = 'KKA';
        $newCode = $prefix . $formattedNum;
        return $newCode;
    }

    public function kodepengeluaran()
    {
        $lastBarang = Pengeluaran_kaskecil::latest()->first();
        if (!$lastBarang) {
            $num = 1;
        } else {
            $lastCode = $lastBarang->kode_pengeluaran;
            $num = (int) substr($lastCode, strlen('KK')) + 1;
        }
        $formattedNum = sprintf("%06s", $num);
        $prefix = 'KK';
        $newCode = $prefix . $formattedNum;
        return $newCode;
    }

    public function hapusperhitunganbulanan($id)
    {
        $item = Perhitungan_gajikaryawan::findOrFail($id);
        // Perbarui detail cicilan yang terkait
        $detail_gajikaryawan = Detail_gajikaryawan::where('perhitungan_gajikaryawan_id', $id)->get();
        foreach ($detail_gajikaryawan as $detail) {
            Detail_cicilan::where('detail_gajikaryawan_id', $detail->id)
                ->update(['detail_gajikaryawan_id' => null]);
        }

        // Hapus semua detail gaji karyawan yang terkait
        $item->detail_gajikaryawan()->delete();
        $item->delete();

        return back()->with('success', 'Berhasil');
    }

    public function deletedetailperhitungan($id)
    {
        $item = Detail_gajikaryawan::find($id);
        Detail_cicilan::where('detail_gajikaryawan_id', $id)
            ->update(['detail_gajikaryawan_id' => null]);

        $item->delete();

        return response()->json(['message' => 'Data deleted successfully']);
    }
}