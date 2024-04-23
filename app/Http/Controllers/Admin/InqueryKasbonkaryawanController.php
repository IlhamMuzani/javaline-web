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
use App\Models\Detail_cicilan;
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
        $saldoTerakhir = Saldo::latest()->first();

        return view('admin.inquery_kasbonkaryawan.index', compact('inquery', 'saldoTerakhir'));
    }


    public function edit($id)
    {

        $inquery = Kasbon_karyawan::where('id', $id)->first();
        $details  = Detail_cicilan::where('kasbon_karyawan_id', $id)->get();
        $KaryawanAll = Karyawan::whereIn('departemen_id', [1, 3])->get();

        return view('admin.inquery_kasbonkaryawan.update', compact('inquery', 'KaryawanAll', 'details'));
    }

    public function update(Request $request, $id)
    {
        $validasi_pelanggan = Validator::make(
            $request->all(),
            [
                'karyawan_id' => 'required',
            ],
            [
                'karyawan_id.required' => 'Pilih sopir',
            ]
        );

        $error_pelanggans = array();

        if ($validasi_pelanggan->fails()) {
            array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
        }

        $error_pesanans = array();
        $data_pembelians = collect();

        if ($validasi_pelanggan->fails()) {
            array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
        }

        if ($request->has('nominal_cicilan')) {
            for ($i = 0; $i < count($request->nominal_cicilan); $i++) {
                $validasi_produk = Validator::make($request->all(), [
                    'nominal_cicilan.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Cicilan nomor " . ($i + 1) . " belum dilengkapi!");
                }

                $nominal_cicilan = is_null($request->nominal_cicilan[$i]) ? '' : $request->nominal_cicilan[$i];

                $data_pembelians->push([
                    'detail_id' => $request->detail_ids[$i] ?? null,
                    'nominal_cicilan' => $nominal_cicilan,
                ]);
            }
        } else {
        }
        if ($validasi_pelanggan->fails() || $error_pesanans) {
            return back()
                ->withInput()
                ->with('error_pelanggans', $error_pelanggans)
                ->with('error_pesanans', $error_pesanans)
                ->with('data_pembelians', $data_pembelians);
        }

        $penerimaan = Kasbon_karyawan::findOrFail($id);
        $penerimaan->update([
            'nominal' => $request->nominal,
            'keterangan' => $request->keterangan,
            'saldo_masuk' => $request->saldo_masuk,
            'sisa_saldo' => $request->sisa_saldo,
            'sub_total' => $request->sub_total2,
            'status' => 'unpost',
        ]);


        foreach ($data_pembelians as $data_pesanan) {
            $detailId = $data_pesanan['detail_id'];

            if ($detailId) {
                Detail_cicilan::where('id', $detailId)->update([
                    'kasbon_karyawan_id' => $penerimaan->id,
                    'kasbon_karyawan_id' =>  $penerimaan->id,
                    'nominal_cicilan' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['nominal_cicilan'])),
                    'status' =>  'unpost',
                    'status_cicilan' =>  'belum lunas',
                    'karyawan_id' =>  $request->karyawan_id,
                ]);
            } else {
                $existingDetail = Detail_cicilan::where([
                    'kasbon_karyawan_id' => $penerimaan->id,
                    'nominal_cicilan' => $data_pesanan['nominal_cicilan'],
                ])->first();

                if (!$existingDetail) {
                    Detail_cicilan::create([
                        'kasbon_karyawan_id' =>  $penerimaan->id,
                        'nominal_cicilan' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['nominal_cicilan'])),
                        'status' =>  'unpost',
                        'status_cicilan' =>  'belum lunas',
                        'karyawan_id' =>  $request->karyawan_id,
                    ]);
                }
            }
        }

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

        $detail_cicilan = Detail_cicilan::where('kasbon_karyawan_id', $item->id)->get();

        foreach ($detail_cicilan as $detail) {
            $detail->update([
                'status' => 'unpost'
            ]);
        }

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

        $detail_cicilan = Detail_cicilan::where('kasbon_karyawan_id', $item->id)->get();

        foreach ($detail_cicilan as $detail) {
            $detail->update([
                'status' => 'posting'
            ]);
        }

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

    public function deletedetailcicilan($id)
    {
        $item = Detail_cicilan::find($id);

        if ($item) {
            $item->delete();
            return response()->json(['message' => 'Data deleted successfully']);
        } else {
            return response()->json(['message' => 'Detail Faktur not found'], 404);
        }
    }
}