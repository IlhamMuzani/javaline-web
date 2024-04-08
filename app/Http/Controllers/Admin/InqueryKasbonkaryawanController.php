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
use App\Models\Detail_pengeluaran;
use App\Models\Kasbon_karyawan;
use App\Models\Karyawan;
use App\Models\Penerimaan_kaskecil;
use App\Models\Pengeluaran_kaskecil;
use App\Models\Saldo;
use Illuminate\Support\Facades\Validator;
use Egulias\EmailValidator\Result\Reason\DetailedReason;

class InqueryKasbonkaryawanController extends Controller
{
    public function index(Request $request)
    {
        Kasbon_karyawan::where([
            ['status', 'posting']
        ])->update([
            'status_notif' => true
        ]);

        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $inquery = Kasbon_karyawan::query();

        // Add condition for category "Pengambilan Deposit"
        $inquery->where('kategori', 'Pengambilan Kasbon');

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

        return view('admin.inquery_kasbonkaryawan.index', compact('inquery'));
    }


    public function edit($id)
    {
        // if (auth()->check() && auth()->user()->menu['inquery perpanjangan stnk']) {

        $inquery = Kasbon_karyawan::where('id', $id)->first();
        $KaryawanAll = Karyawan::where('departemen_id', '2')->get();

        return view('admin.inquery_kasbonkaryawan.update', compact('inquery', 'KaryawanAll'));
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
        if ($kategori == "Pengambilan Kasbon") {

            $penerimaan = Kasbon_karyawan::findOrFail($id);

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
                'keterangan' => $request->keterangan,
                'saldo_masuk' => $request->saldo_masuk,
                'sisa_saldo' => $request->sisa_saldo,
                'sub_total' => $request->sub_total2,
                'status' => 'unpost',
            ]);

            $pengeluaran = Pengeluaran_kaskecil::where('kasbon_karyawan_id', $id)->first();
            $pengeluaran->update(
                [
                    'kasbon_karyawan_id' => $penerimaan->id,
                    'keterangan' => $request->keterangan,
                    'grand_total' => str_replace(',', '.', str_replace('.', '', $request->nominal)),
                    'status' => 'unpost',
                ]
            );

            $detailpengeluaran = Detail_pengeluaran::where('kasbon_karyawan_id', $id)->first();
            $detailpengeluaran->update(
                [
                    'kasbon_karyawan_id' => $penerimaan->id,
                    'pengeluaran_kaskecil_id' => $pengeluaran->id,
                    'keterangan' => $request->keterangan,
                    'nominal' => str_replace(',', '.', str_replace('.', '', $request->nominal)),
                    'status' => 'unpost',
                ]
            );

            $cetakpdf = Kasbon_karyawan::where('id', $id)->first();

            return view('admin.inquery_kasbonkaryawan.show', compact('cetakpdf'));
        } else {

            $penerimaan = Kasbon_karyawan::findOrFail($id);

            $tanggal_awal = Carbon::parse($penerimaan->tanggal_awal);

            $today = Carbon::now('Asia/Jakarta')->format('Y-m-d');
            $lastUpdatedDate = $tanggal_awal->format('Y-m-d');

            if ($lastUpdatedDate < $today) {
                return back()->with('errormax', 'Anda tidak dapat melakukan update setelah berganti hari.');
            }

            $tanggal = Carbon::now()->format('Y-m-d');
            $penerimaan->update([
                'sub_total' => $request->sub_total2,
                'nominal' => str_replace('.', '', $request->nominals),
                'keterangan' => $request->keterangans,
                'sisa_saldo' => $request->sisa_saldos,
                'status' => 'unpost',
            ]);

            $cetakpdf = Kasbon_karyawan::where('id', $id)->first();

            return view('admin.inquery_kasbonkaryawan.show', compact('cetakpdf'));
        }
    }

    public function show($id)
    {
        $cetakpdf = Kasbon_karyawan::where('id', $id)->first();

        return view('admin.inquery_kasbonkaryawan.show', compact('cetakpdf'));
    }

    public function unpostkasbon($id)
    {
        $item = Kasbon_karyawan::find($id);
        if (!$item) {
            return back()->with('error', 'Deposit driver tidak ditemukan');
        }
        $sopir = Karyawan::find($item->karyawan_id);

        // Pastikan karyawan ditemukan
        if (!$sopir) {
            return back()->with('error', 'Karyawan tidak ditemukan');
        }

        $lastSaldo = Saldo::latest()->first();
        if (!$lastSaldo) {
            return back()->with('error', 'Saldo tidak ditemukan');
        }

        $uangjalan = $item->nominal;

        if ($lastSaldo->sisa_saldo < $uangjalan) {
            return back()->with('error', 'Saldo tidak mencukupi');
        }

        $sisaSaldo = $item->nominal;
        // Update saldo terakhir
        $lastSaldo->update([
            'sisa_saldo' => $lastSaldo->sisa_saldo + $sisaSaldo,
        ]);

        // Update status pengeluaran
        Pengeluaran_kaskecil::where('kasbon_karyawan_id', $id)->update([
            'status' => 'unpost'
        ]);
        Detail_pengeluaran::where('kasbon_karyawan_id', $id)->update([
            'status' => 'unpost'
        ]);


        $kasbon = $sopir->kasbon;
        $total = $item->nominal;
        $kasbons = $kasbon - $total;

        // $deposit = $sopir->deposit;
        // $totaldeposit = $item->nominal;
        // $deposits = $deposit + $totaldeposit;


        // Update tabungan karyawan
        $sopir->update([
            'kasbon' => $kasbons,
        ]);

        // Update status deposit_driver menjadi 'unpost'
        $item->update([
            'status' => 'unpost'
        ]);

        // Tampilkan pesan sesuai hasil penambahan
        return back()->with('success', 'Berhasil. Tabungan karyawan sekarang: Rp ' . number_format($kasbons, 0, ',', '.'));
    }

    public function postingkasbon($id)
    {
        $item = Kasbon_karyawan::find($id);
        if (!$item) {
            return back()->with('error', 'Deposit driver tidak ditemukan');
        }
        $sopir = Karyawan::find($item->karyawan_id);

        // Pastikan karyawan ditemukan
        if (!$sopir) {
            return back()->with('error', 'Karyawan tidak ditemukan');
        }

        $lastSaldo = Saldo::latest()->first();
        if (!$lastSaldo) {
            return back()->with('error', 'Saldo tidak ditemukan');
        }

        $uangjalan = $item->nominal;

        if ($lastSaldo->sisa_saldo < $uangjalan) {
            return back()->with('error', 'Saldo tidak mencukupi');
        }

        $sisaSaldo = $item->nominal;
        // Update saldo terakhir
        $lastSaldo->update([
            'sisa_saldo' => $lastSaldo->sisa_saldo - $sisaSaldo,
        ]);

        // Update status pengeluaran
        Pengeluaran_kaskecil::where('kasbon_karyawan_id', $id)->update([
            'status' => 'posting'
        ]);
        Detail_pengeluaran::where('kasbon_karyawan_id', $id)->update([
            'status' => 'posting'
        ]);


        $kasbon = $sopir->kasbon;
        $totalKasbon = $item->nominal;
        $kasbons = $kasbon + $totalKasbon;

        // Update tabungan karyawan
        $sopir->update([
            'kasbon' => $kasbons,
        ]);

        // Update status deposit_driver menjadi 'posting'
        $item->update([
            'status' => 'posting'
        ]);

        // Tampilkan pesan sesuai hasil pengurangan
        return back()->with('success', 'Berhasil. Tabungan karyawan sekarang: Rp ' . number_format($kasbons, 0, ',', '.'));
    }


    public function hapuskasbon($id)
    {
        $item = Kasbon_karyawan::where('id', $id)->first();

        $item->delete();
        return back()->with('success', 'Berhasil');
    }


    public function destroy($id)
    {
        $item = Pembelian_ban::find($id);
        $item->detail_ban()->delete();
        $item->delete();

        return redirect('admin/inquery_kasbonkaryawan')->with('success', 'Berhasil deposit');
    }
}