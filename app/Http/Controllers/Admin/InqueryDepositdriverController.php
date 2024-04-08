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
use App\Models\Deposit_driver;
use App\Models\Karyawan;
use App\Models\Penerimaan_kaskecil;
use App\Models\Saldo;
use Illuminate\Support\Facades\Validator;
use Egulias\EmailValidator\Result\Reason\DetailedReason;

class InqueryDepositdriverController extends Controller
{
    public function index(Request $request)
    {
        Deposit_driver::where([
            ['status', 'posting']
        ])->update([
            'status_notif' => true
        ]);

        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $inquery = Deposit_driver::query();

        // Add condition for category "Pengambilan Deposit"
        $inquery->where('kategori', 'Pengambilan Deposit');

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

        return view('admin.inquery_depositdriver.index', compact('inquery'));
    }


    public function edit($id)
    {
        // if (auth()->check() && auth()->user()->menu['inquery perpanjangan stnk']) {

        $inquery = Deposit_driver::where('id', $id)->first();
        $SopirAll = Karyawan::where('departemen_id', '2')->get();

        return view('admin.inquery_depositdriver.update', compact('inquery', 'SopirAll'));
        // } else {
        //     // tidak memiliki akses
        //     return back()->with('error', array('Anda tidak memiliki akses'));
        // }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'kategori' => 'required',
                'karyawan_id' => 'required',
                // 'keterangan' => 'required', // Menambahkan aturan unique
            ],
            [
                'kategori.required' => 'Pilih kategori',
                'karyawan_id.required' => 'Pilih sopir',
                // 'keterangan.required' => 'Masukkan keterangan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kategori = $request->kategori;
        if ($kategori == "Pemasukan Deposit") {

            $penerimaan = Deposit_driver::findOrFail($id);

            $tanggal_awal = Carbon::parse($penerimaan->tanggal_awal);

            $today = Carbon::now('Asia/Jakarta')->format('Y-m-d');
            $lastUpdatedDate = $tanggal_awal->format('Y-m-d');

            if ($lastUpdatedDate < $today) {
                return back()->with('errormax', 'Anda tidak dapat melakukan update setelah berganti hari.');
            }

            $tanggal1 = Carbon::now('Asia/Jakarta');
            $format_tanggal = $tanggal1->format('d F Y');

            $subTotalInput = $request->input('sub_total');
            $cleanedSubTotal = (int) str_replace(['Rp', '.'], '', $subTotalInput);

            $tanggal1 = Carbon::now('Asia/Jakarta');
            $format_tanggal = $tanggal1->format('d F Y');

            $tanggal = Carbon::now()->format('Y-m-d');
            $penerimaan->update([
                'nominal' => $request->nominal,
                'kode_sopir' => $request->kode_sopir,
                'nama_sopir' => $request->nama_sopir,
                'keterangan' => $request->keterangan,
                'saldo_masuk' => $request->saldo_masuk,
                'sisa_saldo' => $request->sisa_saldo,
                'sub_total' => $request->sub_total2,
                'status' => 'unpost',
            ]);

            // $karyawanId = $request->karyawan_id;
            // $karyawan = Karyawan::find($karyawanId);

            // if ($karyawan) {
            //     // Remove "Rp" and dots from the sub_total
            //     $subTotal = str_replace(['Rp', '.'], '', $request->sub_total);

            //     $karyawan->update([
            //         'tabungan' => $subTotal,
            //     ]);
            // } else {
            //     // Handle the case where the Karyawan with the given ID is not found
            // }



            $cetakpdf = Deposit_driver::where('id', $id)->first();

            return view('admin.inquery_depositdriver.show', compact('cetakpdf'));
        } else {

            $penerimaan = Deposit_driver::findOrFail($id);

            $tanggal_awal = Carbon::parse($penerimaan->tanggal_awal);

            $today = Carbon::now('Asia/Jakarta')->format('Y-m-d');
            $lastUpdatedDate = $tanggal_awal->format('Y-m-d');

            if ($lastUpdatedDate < $today) {
                return back()->with('errormax', 'Anda tidak dapat melakukan update setelah berganti hari.');
            }

            $tanggal1 = Carbon::now('Asia/Jakarta');
            $format_tanggal = $tanggal1->format('d F Y');

            $subTotalInput = $request->input('sub_totals');
            $cleanedSubTotal = (int) str_replace(['Rp', '.'], '', $subTotalInput);

            $tanggal1 = Carbon::now('Asia/Jakarta');
            $format_tanggal = $tanggal1->format('d F Y');

            $tanggal = Carbon::now()->format('Y-m-d');
            $penerimaan->update([
                'nominal' => $request->nominals,
                'keterangan' => $request->keterangans,
                'kode_sopir' => $request->kode_sopir,
                'nama_sopir' => $request->nama_sopir,
                'saldo_keluar' => $request->saldo_keluar,
                'sisa_saldo' => $request->sisa_saldos,
                'sub_total' => $request->sub_total2,
                'status' => 'unpost',
            ]);

            // $karyawanId = $request->karyawan_id;
            // $karyawan = Karyawan::find($karyawanId);

            // if ($karyawan) {
            //     // Remove "Rp" and dots from the sub_total
            //     $subTotal = str_replace(['Rp', '.'], '', $request->sub_totals);

            //     $karyawan->update([
            //         'tabungan' => $subTotal,
            //     ]);
            // } else {
            //     // Handle the case where the Karyawan with the given ID is not found
            // }



            $cetakpdf = Deposit_driver::where('id', $id)->first();

            return view('admin.inquery_depositdriver.show', compact('cetakpdf'));
        }
    }

    public function show($id)
    {
        $cetakpdf = Deposit_driver::where('id', $id)->first();

        return view('admin.inquery_depositdriver.show', compact('cetakpdf'));
    }

    public function unpostdeposit($id)
    {
        $ban = Deposit_driver::find($id);
        if (!$ban) {
            return back()->with('error', 'Deposit driver tidak ditemukan');
        }
        $sopir = Karyawan::find($ban->karyawan_id);

        // Pastikan karyawan ditemukan
        if (!$sopir) {
            return back()->with('error', 'Karyawan tidak ditemukan');
        }

        // Ambil nilai tabungan dan total dari deposit_driver
        $tabungan = $sopir->tabungan;
        $total = $ban->nominal;
        $sub_totals = $tabungan + $total;

        $kasbon = $sopir->kasbon;
        $total = $ban->nominal;
        $kasbons = $kasbon - $total;

        // $deposit = $sopir->deposit;
        // $totaldeposit = $ban->nominal;
        // $deposits = $deposit + $totaldeposit;


        // Update tabungan karyawan
        $sopir->update([
            'kasbon' => $kasbons,
            // 'deposit' => $deposits,
            'tabungan' => $sub_totals,
        ]);

        // Update status deposit_driver menjadi 'unpost'
        $ban->update([
            'status' => 'unpost'
        ]);

        // Tampilkan pesan sesuai hasil penambahan
        return back()->with('success', 'Berhasil. Tabungan karyawan sekarang: Rp ' . number_format($sub_totals, 0, ',', '.'));
    }

    public function postingdeposit($id)
    {
        $ban = Deposit_driver::find($id);
        if (!$ban) {
            return back()->with('error', 'Deposit driver tidak ditemukan');
        }
        $sopir = Karyawan::find($ban->karyawan_id);

        // Pastikan karyawan ditemukan
        if (!$sopir) {
            return back()->with('error', 'Karyawan tidak ditemukan');
        }

        $kasbon = $sopir->kasbon;
        $totalKasbon = $ban->nominal;
        $kasbons = $kasbon + $totalKasbon;

        // $deposit = $sopir->deposit;
        // $totaldeposit = $ban->nominal;
        // $deposits = $deposit - $totaldeposit;

        $tabungan = $sopir->tabungan;
        $total = $ban->nominal;
        $sub_totals = $tabungan - $total;

        // Update tabungan karyawan
        $sopir->update([
            'kasbon' => $kasbons,
            // 'deposit' => $deposits,
            'tabungan' => $sub_totals
        ]);

        // Update status deposit_driver menjadi 'posting'
        $ban->update([
            'status' => 'posting'
        ]);

        // Tampilkan pesan sesuai hasil pengurangan
        return back()->with('success', 'Berhasil. Tabungan karyawan sekarang: Rp ' . number_format($sub_totals, 0, ',', '.'));
    }


    public function hapusdeposit($id)
    {
        $ban = Deposit_driver::where('id', $id)->first();

        $ban->delete();
        return back()->with('success', 'Berhasil');
    }


    public function destroy($id)
    {
        $ban = Pembelian_ban::find($id);
        $ban->detail_ban()->delete();
        $ban->delete();

        return redirect('admin/inquery_depositdriver')->with('success', 'Berhasil deposit');
    }
}