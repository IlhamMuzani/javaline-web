<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Detail_cicilan;
use App\Models\Detail_pengeluaran;
use App\Models\Kasbon_karyawan;
use App\Models\Karyawan;
use App\Models\Pengeluaran_kaskecil;
use App\Models\Saldo;
use Illuminate\Support\Facades\Validator;

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
        $karyawanAll = Karyawan::whereIn('departemen_id', [1, 3, 4, 5])->get();

        return view('admin.inquery_kasbonkaryawan.update', compact('inquery', 'karyawanAll', 'details'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'karyawan_id' => 'required',
                'nominal_cicilan' => 'required',
                'jumlah_cicilan' => 'required',
            ],
            [
                'karyawan_id.required' => 'Pilih Karyawan',
                'nominal_cicilan.required' => 'Masukkan nominal cicilan',
                'jumlah_cicilan.required' => 'Masukkan jumlah cicilan',
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }

        $penerimaan = Kasbon_karyawan::findOrFail($id);
        $penerimaan->update([
            'nominal' => $request->nominal,
            'saldo_masuk' => $request->saldo_masuk,
            'sisa_saldo' => $request->sisa_saldo,
            'saldo_keluar' => $request->saldo_keluar,
            'sub_total' => str_replace(',', '.', str_replace('.', '', $request->sub_total2)),
            'nominal_cicilan' => str_replace(',', '.', str_replace('.', '', $request->nominal_cicilan)),
            'nominal_lebih' => !empty($request->nominal_lebih) ? str_replace(',', '.', str_replace('.', '', $request->nominal_lebih)) : 0,
            'jumlah_cicilan' => str_replace(',', '.', str_replace('.', '', $request->jumlah_cicilan)),
            'grand_total' => str_replace(',', '.', str_replace('.', '', $request->grand_total)),
            'keterangan' => $request->keterangan,
            'status' => 'unpost',
        ]);

        $kasbon_id = $id;
        $jumlah_cicilan = $request->jumlah_cicilan;

        if ($jumlah_cicilan) {
            $existing_vouchers = Detail_cicilan::where(['kasbon_karyawan_id' => $kasbon_id, 'status_pemisah' => 'cicilan perkalian'])->get();
            $existing_voucher_count = $existing_vouchers->count();

            if ($jumlah_cicilan > $existing_voucher_count) {
                $vouchers_to_create = $jumlah_cicilan - $existing_voucher_count;

                for ($i = 1; $i <= $vouchers_to_create; $i++) {
                    Detail_cicilan::create([
                        'kasbon_karyawan_id' =>  $kasbon_id,
                        'karyawan_id' =>  $request->karyawan_id,
                        'nominal_cicilan' => str_replace(',', '.', str_replace('.', '', $request->nominal_cicilan)),
                        'status_cicilan' =>  'belum lunas',
                        'status_pemisah' =>  'cicilan perkalian',
                        'status' =>  'unpost',
                    ]);
                }
            } elseif ($jumlah_cicilan < $existing_voucher_count) {
                $vouchers_to_delete = $existing_vouchers
                    ->where('status_pemisah', 'cicilan perkalian')
                    ->sortByDesc('id')
                    ->take($existing_voucher_count - $jumlah_cicilan);

                foreach ($vouchers_to_delete as $voucher) {
                    $voucher->delete();
                }
            }

            foreach ($existing_vouchers as $voucher) {
                $voucher->update([
                    'nominal_cicilan' => str_replace(',', '.', str_replace('.', '', $request->nominal_cicilan)),
                ]);
            }
        }

        $nominal_lebih = $request->nominal_lebih;
        $detail_cicilan = Detail_cicilan::where('kasbon_karyawan_id', $kasbon_id)
            ->where('karyawan_id', $request->karyawan_id)
            ->where('status_pemisah', 'nominal lebih')
            ->first();

        if ($nominal_lebih !== null && $nominal_lebih != 0) {
            if ($detail_cicilan) {
                $detail_cicilan->update([
                    'nominal_cicilan' => str_replace(',', '.', str_replace('.', '', $request->nominal_lebih)),
                    'status_cicilan' => 'belum lunas',
                    'status' => 'unpost',
                ]);
            } else {
                Detail_cicilan::create([
                    'kasbon_karyawan_id' => $kasbon_id,
                    'karyawan_id' => $request->karyawan_id,
                    'nominal_cicilan' => str_replace(',', '.', str_replace('.', '', $request->nominal_lebih)),
                    'status_cicilan' => 'belum lunas',
                    'status_pemisah' => 'nominal lebih',
                    'status' => 'unpost',
                ]);
            }
        } elseif ($detail_cicilan) {
            $detail_cicilan->delete();
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
        $lastSaldo->update([
            'sisa_saldo' => $lastSaldo->sisa_saldo + $sisaSaldo,
        ]);
        Pengeluaran_kaskecil::where('kasbon_karyawan_id', $id)->update([
            'status' => 'unpost'
        ]);
        Detail_pengeluaran::where('kasbon_karyawan_id', $id)->update([
            'status' => 'unpost'
        ]);

        $kasbon = $sopir->kasbon;
        $total = $item->nominal;
        $kasbons = $kasbon - $total;

        $sopir->update([
            'kasbon' => $kasbons,
        ]);

        $detail_cicilan = Detail_cicilan::where('kasbon_karyawan_id', $item->id)->get();

        foreach ($detail_cicilan as $detail) {
            $detail->update([
                'status' => 'unpost'
            ]);
        }

        $item->update([
            'status' => 'unpost'
        ]);

        return back()->with('success', 'Berhasil. Tabungan karyawan sekarang: Rp ' . number_format($kasbons, 0, ',', '.'));
    }

    public function postingkasbon($id)
    {
        $item = Kasbon_karyawan::find($id);
        if (!$item) {
            return back()->with('error', 'Deposit driver tidak ditemukan');
        }
        $sopir = Karyawan::find($item->karyawan_id);

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
        $lastSaldo->update([
            'sisa_saldo' => $lastSaldo->sisa_saldo - $sisaSaldo,
        ]);
        Pengeluaran_kaskecil::where('kasbon_karyawan_id', $id)->update([
            'status' => 'posting'
        ]);
        Detail_pengeluaran::where('kasbon_karyawan_id', $id)->update([
            'status' => 'posting'
        ]);

        $kasbon = $sopir->kasbon;
        $totalKasbon = $item->nominal;
        $kasbons = $kasbon + $totalKasbon;

        $sopir->update([
            'kasbon' => $kasbons,
        ]);

        $detail_cicilan = Detail_cicilan::where('kasbon_karyawan_id', $item->id)->get();

        foreach ($detail_cicilan as $detail) {
            $detail->update([
                'status' => 'posting'
            ]);
        }

        $item->update([
            'status' => 'posting'
        ]);

        return back()->with('success', 'Berhasil. Tabungan karyawan sekarang: Rp ' . number_format($kasbons, 0, ',', '.'));
    }


    public function hapuskasbon($id)
    {
        $item = Kasbon_karyawan::where('id', $id)->first();
        $item->pengeluaran_kaskecil()->delete();
        $item->detail_pengeluaran()->delete();
        $item->detail_cicilan()->delete();
        $item->delete();
        return back()->with('success', 'Berhasil');
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
