<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Detail_pengeluaran;
use App\Models\Memo_asuransi;
use App\Models\Pengeluaran_kaskecil;
use App\Models\Saldo;
use App\Models\Spk;
use App\Models\Tarif_asuransi;
use App\Models\Total_asuransi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InquerymemoasuransiController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $inquery = Memo_asuransi::query();

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

        return view('admin.inquery_memoasuransi.index', compact('inquery', 'saldoTerakhir'));
    }

    public function edit($id)
    {
        $inquery = Memo_asuransi::where('id', $id)->first();
        $spks = Spk::where('voucher', '<', 2)
            ->where(function ($query) {
                $query->where('status_spk', '!=', 'faktur')
                    ->where('status_spk', '!=', 'invoice')
                    ->where('status_spk', '!=', 'pelunasan')
                    ->orWhereNull('status_spk');
            })
            ->orderBy('created_at', 'desc') // Change 'created_at' to the appropriate timestamp column
            ->get();
        $tarifs = Tarif_asuransi::all();

        return view('admin.inquery_memoasuransi.update', compact('spks', 'tarifs', 'inquery'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'spk_id' => 'required',
                'tarif_asuransi_id' => 'required',
                'nominal_tarif' => 'required'
            ],
            [
                'spk_id.required' => 'Pilih SPK',
                'tarif_asuransi_id.required' => 'Pilih Tarif Asuransi',
                'nominal_tarif.required' => 'Masukkan nominal tarif',
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }

        // tgl indo
        $tanggal = Carbon::now()->format('Y-m-d');
        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');

        $cetakpdf = Memo_asuransi::findOrFail($id);
        $cetakpdf->update(
            [
                'admin' => auth()->user()->karyawan->nama_lengkap,
                'spk_id' =>  $request->spk_id,
                'user_id' => $request->user_id,
                'kendaraan_id' => $request->kendaraan_id,
                'rute_perjalanan_id' => $request->rute_perjalanan_id,
                'tarif_asuransi_id' => $request->tarif_asuransi_id,
                'nominal_tarif' => str_replace(',', '.', str_replace('.', '', $request->nominal_tarif)),
                'persen' => $request->persen,
                'hasil_tarif' => str_replace(',', '.', str_replace('.', '', $request->hasil_tarif)),
                'keterangan' => $request->keterangan,
                'status' => 'unpost',
            ]
        );

        $pengeluaran = Pengeluaran_kaskecil::where('memo_asuransi_id', $id)->first();
        $pengeluaran->update(
            [
                'kendaraan_id' => $request->kendaraan_id,
                'keterangan' => $request->keterangan,
                'grand_total' => str_replace(',', '.', str_replace('.', '', $request->hasil_tarif)),
            ]
        );

        $detailpengeluaran = Detail_pengeluaran::where('memo_asuransi_id', $id)->first();
        $detailpengeluaran->update(
            [
                'keterangan' => $request->keterangan,
                'nominal' => str_replace(',', '.', str_replace('.', '', $request->hasil_tarif)),
            ]
        );

        return redirect('admin/inquery_memoasuransi')->with('success', 'Berhasil memperbarui memo asuransi');
    }

    public function unpostmemoasuransi($id)
    {
        try {
            $item = Memo_asuransi::findOrFail($id);

            $hasil_sub = $item->hasil_tarif;

            $lastSaldo = Saldo::latest()->first();
            if (!$lastSaldo) {
                return back()->with('error', 'Saldo tidak ditemukan');
            }

            $sisaSaldo = $lastSaldo->sisa_saldo + $hasil_sub;
            Saldo::create([
                'sisa_saldo' => $sisaSaldo,
            ]);

            $UangAsuransi = $item->hasil_tarif;
            $UangAsuransi = round($UangAsuransi);

            $lastAsuransi = Total_asuransi::latest()->first();
            if (!$lastAsuransi) {
                return response()->json(['error' => 'Asuransi tidak ditemukan']);
            }

            $sisaAsuransi = $lastAsuransi->sisa_asuransi - $UangAsuransi;
            Total_asuransi::create([
                'sisa_asuransi' => $sisaAsuransi,
            ]);

            Pengeluaran_kaskecil::where('memo_asuransi_id', $id)->update([
                'status' => 'pending'
            ]);

            Detail_pengeluaran::where('memo_asuransi_id', $id)->update([
                'status' => 'pending'
            ]);

            $item->update([
                'status' => 'unpost'
            ]);

            return back()->with('success', 'Berhasil');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        }
    }

    public function postingmemoasuransi($id)
    {
        try {
            $item = Memo_asuransi::findOrFail($id);

            $hasil_sub = $item->hasil_tarif;

            $lastSaldo = Saldo::latest()->first();
            if (!$lastSaldo) {
                return back()->with('error', 'Saldo tidak ditemukan');
            }

            // Check if saldo is sufficient
            if ($lastSaldo->sisa_saldo < $hasil_sub) {
                return back()->with('error', 'Saldo tidak mencukupi');
            }

            $sisaSaldo = $lastSaldo->sisa_saldo - $hasil_sub;
            Saldo::create([
                'sisa_saldo' => $sisaSaldo,
            ]);

            $UangAsuransi = $item->hasil_tarif;
            $UangAsuransi = round($UangAsuransi);

            $lastAsuransi = Total_asuransi::latest()->first();
            if (!$lastAsuransi) {
                return response()->json(['error' => 'Asuransi tidak ditemukan']);
            }

            $sisaAsuransi = $lastAsuransi->sisa_asuransi + $UangAsuransi;
            Total_asuransi::create([
                'sisa_asuransi' => $sisaAsuransi,
            ]);

            Pengeluaran_kaskecil::where('memo_asuransi_id', $id)->update([
                'status' => 'posting'
            ]);

            Detail_pengeluaran::where('memo_asuransi_id', $id)->update([
                'status' => 'posting'
            ]);

            $item->update([
                'status' => 'posting'
            ]);

            return back()->with('success', 'Berhasil');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        }
    }

    public function postingasuransifilter(Request $request)
    {
        $selectedIds = array_reverse(explode(',', $request->input('ids')));

        try {
            $totalDeduction = 0;

            foreach ($selectedIds as $id) {
                $item = Memo_asuransi::findOrFail($id);

                if ($item->status === 'unpost') {
                    $totalDeduction += $item->hasil_tarif;
                }
            }

            $lastSaldo = Saldo::latest()->first();
            $lastAsuransi = Total_asuransi::latest()->first();

            if (!$lastSaldo) {
                return back()->with('error', 'Saldo tidak ditemukan');
            }

            if ($lastSaldo->sisa_saldo < $totalDeduction) {
                return back()->with('error', 'Saldo tidak mencukupi');
            }

            $totalUangJalanRequest = array_reduce($selectedIds, function ($carry, $id) {
                $item = Memo_asuransi::findOrFail($id);
                return $carry + $item->hasil_tarif;
            }, 0);

            if ($lastSaldo->sisa_saldo < $totalUangJalanRequest) {
                return back()->with('error', 'Total request uang asuransi melebihi saldo terakhir');
            }

            foreach ($selectedIds as $id) {
                $item = Memo_asuransi::findOrFail($id);

                if ($item->status === 'unpost') {

                    Pengeluaran_kaskecil::where('memo_asuransi_id', $id)->update([
                        'status' => 'posting'
                    ]);

                    Detail_pengeluaran::where('memo_asuransi_id', $id)->update([
                        'status' => 'posting'
                    ]);

                    $item->update([
                        'status' => 'posting'
                    ]);

                    $lastSaldo->update([
                        'sisa_saldo' => $lastSaldo->sisa_saldo - ($item->hasil_tarif)
                    ]);

                    $lastAsuransi->update([
                        $UangASURANSI = $item->hasil_tarif,
                        $UangASURANSI = round($UangASURANSI),
                        'sisa_asuransi' => $lastAsuransi->sisa_asuransi + ($UangASURANSI)
                    ]);
                }
            }

            return back()->with('success', 'Berhasil memposting memo asuransi yang dipilih');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return back()->with('error', 'Terdapat memo asuransi yang tidak ditemukan');
        }
    }


    public function unpostasuransifilter(Request $request)
    {
        $selectedIds = array_reverse(explode(',', $request->input('ids')));

        try {
            $totalRestoration = 0;

            foreach ($selectedIds as $id) {
                $item = Memo_asuransi::findOrFail($id);
                if ($item->status === 'posting') {
                    $totalRestoration += $item->hasil_tarif;
                }
            }

            $lastSaldo = Saldo::latest()->first();
            $lastASURANSI = Total_asuransi::latest()->first();

            if (!$lastSaldo) {
                return back()->with('error', 'Saldo tidak ditemukan');
            }
            $sisaSaldo = $lastSaldo->sisa_saldo + $totalRestoration;
            $sisaASURANSI = $lastASURANSI->sisa_asuransi - $totalRestoration;

            Saldo::create([
                'sisa_saldo' => $sisaSaldo,
            ]);

            Total_asuransi::create([
                'sisa_asuransi' => $sisaASURANSI,
            ]);

            foreach ($selectedIds as $id) {
                $item = Memo_asuransi::findOrFail($id);

                if ($item->status === 'posting') {

                    Pengeluaran_kaskecil::where('memo_asuransi_id', $id)->update([
                        'status' => 'pending'
                    ]);

                    Detail_pengeluaran::where('memo_asuransi_id', $id)->update([
                        'status' => 'pending'
                    ]);

                    $item->update([
                        'status' => 'unpost'
                    ]);
                }
            }

            return back()->with('success', 'Berhasil membatalkan posting memo asuransi yang dipilih');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return back()->with('error', 'Terdapat memo asuransi yang tidak ditemukan');
        }
    }

    public function cetak_asuransifilter(Request $request)
    {
        $selectedIds = explode(',', $request->input('ids'));
        $memos = Memo_asuransi::whereIn('id', $selectedIds)->orderBy('id', 'DESC')->get();

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('admin.inquery_memoasuransi.cetak_pdffilter', compact('memos'));
        $pdf->setPaper('folio');

        return $pdf->stream('SelectedMemo.pdf');
    }

    public function hapusmemoasuransi($id)
    {
        $memo = Memo_asuransi::where('id', $id)->first();
        $memo->pengeluaran_kaskecil()->delete();
        $memo->detail_pengeluaran()->delete();
        $memo->delete();
        return back()->with('success', 'Berhasil');
    }
}
