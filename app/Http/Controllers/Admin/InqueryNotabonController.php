<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Detail_cicilan;
use App\Models\Detail_pengeluaran;
use App\Models\Notabon_ujs;
use App\Models\Karyawan;
use App\Models\Pengeluaran_kaskecil;
use App\Models\Saldo;
use Illuminate\Support\Facades\Validator;
use App\Exports\RekapNotabonExport;
use Maatwebsite\Excel\Facades\Excel;

class InqueryNotabonController extends Controller
{
    public function index(Request $request)
    {
        Notabon_ujs::where([
            ['status', 'posting']
        ])->update([
            'status_notif' => true
        ]);

        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $inquery = Notabon_ujs::query();


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

        return view('admin.inquery_notabon.index', compact('inquery', 'saldoTerakhir'));
    }


    public function edit($id)
    {

        $inquery = Notabon_ujs::where('id', $id)->first();
        $SopirAll = Karyawan::where('departemen_id', '2')->get();

        return view('admin.inquery_notabon.update', compact('inquery', 'SopirAll'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'karyawan_id' => 'required',
                'nominal' => 'required',
            ],
            [
                'karyawan_id.required' => 'Pilih Driver',
                'nominal.required' => 'Masukkan nominal',
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }

        $penerimaan = Notabon_ujs::findOrFail($id);
        $penerimaan->update([
            'karyawan_id' => $request->karyawan_id,
            'user_id' => $request->user_id,
            'kode_driver' => $request->kode_driver,
            'nama_driver' => $request->nama_driver,
            'admin' => auth()->user()->karyawan->nama_lengkap,
            'nominal' => str_replace(',', '.', str_replace('.', '', $request->nominal)),
            'keterangan' => $request->keterangan,
            'status' => 'unpost',
        ]);


        $pengeluaran = Pengeluaran_kaskecil::where('notabon_ujs_id', $id)->first();
        $pengeluaran->update(
            [
                'kendaraan_id' => $request->kendaraan_id,
                'keterangan' => $request->keterangan,
                'grand_total' => str_replace(',', '.', str_replace('.', '', $request->nominal)),
            ]
        );

        $detailpengeluaran = Detail_pengeluaran::where('notabon_ujs_id', $id)->first();
        $detailpengeluaran->update(
            [
                'keterangan' => $request->keterangan,
                'nominal' => str_replace(',', '.', str_replace('.', '', $request->nominal)),
            ]
        );


        return redirect('admin/inquery-notabon')->with('success', 'Berhasil memperbarui nota bon uang jalan');
    }

    public function show($id)
    {
        $cetakpdf = Notabon_ujs::where('id', $id)->first();
        return view('admin.inquery_notabon.show', compact('cetakpdf'));
    }


    public function unpostnotabon($id)
    {
        $item = Notabon_ujs::find($id);
        if (!$item) {
            return back()->with('error', 'Nota bon driver tidak ditemukan');
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

        Pengeluaran_kaskecil::where('notabon_ujs_id', $id)->update([
            'status' => 'pending'
        ]);

        Detail_pengeluaran::where('notabon_ujs_id', $id)->update([
            'status' => 'pending'
        ]);

        $item->update([
            'status' => 'unpost'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function postingnotabon($id)
    {
        try {
            $item = Notabon_ujs::find($id);
            if (!$item) {
                return response()->json(['error' => 'Nota bon driver tidak ditemukan']);
            }
            $sopir = Karyawan::find($item->karyawan_id);

            if (!$sopir) {
                return response()->json(['error' => 'Driver tidak ditemukan']);
            }

            $postedCount = Notabon_ujs::where('nama_driver', $item->nama_driver)
                ->where('status', 'posting')
                ->count();
            if ($postedCount >= 2) {
                return response()->json(['error' => 'Nota Bon telah mencapai batas maksimal']);
            }

            $lastSaldo = Saldo::latest()->first();
            if (!$lastSaldo) {
                return response()->json(['error' => 'Saldo tidak ditemukan']);
            }

            $uangjalan = $item->nominal;

            if ($lastSaldo->sisa_saldo < $uangjalan) {
                return response()->json(['error' => 'Saldo tidak mencukupi']);
            }

            $sisaSaldo = $item->nominal;
            $lastSaldo->update([
                'sisa_saldo' => $lastSaldo->sisa_saldo - $sisaSaldo,
            ]);

            Pengeluaran_kaskecil::where('notabon_ujs_id', $id)->update([
                'status' => 'posting'
            ]);

            Detail_pengeluaran::where('notabon_ujs_id', $id)->update([
                'status' => 'posting'
            ]);

            $item->update([
                'status' => 'posting'
            ]);

            return response()->json(['success' => 'Berhasil memposting memo']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Gagal memposting memo: Memo tidak ditemukan']);
        }
    }


    // public function postingfilternota(Request $request)
    // {
    //     $selectedIds = array_reverse(explode(',', $request->input('ids')));

    //     try {
    //         // Initialize total deduction amount
    //         $totalDeduction = 0;

    //         foreach ($selectedIds as $id) {

    //             $driverName = Notabon_ujs::findOrFail($id)->nama_driver;
    //             $postedCount = Notabon_ujs::where('nama_driver', $driverName)
    //                 ->where('status', 'posting')
    //                 ->count();

    //             if ($postedCount >= 2) {
    //                 continue;
    //             }


    //             $item = Notabon_ujs::findOrFail($id);

    //             // Pastikan hanya memproses pengeluaran dengan status 'unpost'
    //             if ($item->status === 'unpost') {
    //                 // Accumulate total deduction amount
    //                 $totalDeduction += $item->nominal;
    //             }
    //         }

    //         // Get the last saldo
    //         $lastSaldo = Saldo::latest()->first();

    //         if (!$lastSaldo) {
    //             return back()->with('error', 'Saldo tidak ditemukan');
    //         }

    //         // Check if saldo is sufficient
    //         if ($lastSaldo->sisa_saldo < $totalDeduction) {
    //             return back()->with('error', 'Saldo tidak mencukupi');
    //         }

    //         // Deduct the total amount from saldo
    //         $sisaSaldo = $lastSaldo->sisa_saldo - $totalDeduction;

    //         // Update saldo
    //         Saldo::create([
    //             'sisa_saldo' => $sisaSaldo,
    //         ]);

    //         foreach ($selectedIds as $id) {
    //             $item = Notabon_ujs::findOrFail($id);

    //             $postedCount = Notabon_ujs::where('nama_driver', $item->nama_driver)
    //                 ->where('status', 'posting')
    //                 ->count();
    //             if ($postedCount >= 2 && $item->status !== 'posting') {
    //                 continue;
    //             }

    //             if ($item->status === 'unpost') {

    //                 Pengeluaran_kaskecil::where('notabon_ujs_id', $id)->update([
    //                     'status' => 'posting'
    //                 ]);

    //                 Detail_pengeluaran::where('notabon_ujs_id', $id)->update([
    //                     'status' => 'posting'
    //                 ]);

    //                 // Update the main record
    //                 $item->update([
    //                     'status' => 'posting'
    //                 ]);
    //             }
    //         }

    //         return back()->with('success', 'Berhasil memposting pengeluaran yang dipilih');
    //     } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
    //         return back()->with('error', 'Terdapat pengeluaran yang tidak ditemukan');
    //     }
    // }

    public function postingfilternota(Request $request)
    {
        $selectedIds = array_reverse(explode(',', $request->input('ids')));

        try {
            // Initialize total deduction amount
            $totalDeduction = 0;

            foreach ($selectedIds as $id) {
                // Check if the driver has already three or more posted memos
                $driverName = Notabon_ujs::findOrFail($id)->nama_driver;
                $postedCount = Notabon_ujs::where('nama_driver', $driverName)
                    ->where('status', 'posting')
                    ->count();

                // If the driver has three or more posted memos, skip this memo
                if ($postedCount >= 2) {
                    continue;
                }

                $item = Notabon_ujs::findOrFail($id);

                // Pastikan hanya memproses memo ekspedisi dengan status 'unpost'
                if ($item->status === 'unpost') {
                    // Accumulate total deduction amount
                    $totalDeduction += $item->nominal;
                }
            }

            // Get the last saldo
            $lastSaldo = Saldo::latest()->first();

            if (!$lastSaldo) {
                return back()->with('error', 'Saldo tidak ditemukan');
            }

            // Check if saldo is sufficient
            if ($lastSaldo->sisa_saldo < $totalDeduction) {
                return back()->with('error', 'Saldo tidak mencukupi');
            }

            // Check if total uang jalan request is greater than saldo
            $totalUangJalanRequest = array_reduce($selectedIds, function ($carry, $id) {
                $item = Notabon_ujs::findOrFail($id);
                return $carry + $item->nominal;
            }, 0);

            if ($lastSaldo->sisa_saldo < $totalUangJalanRequest) {
                return back()->with('error', 'Total request uang melebihi saldo terakhir');
            }

            // Update transactions and memo statuses
            foreach ($selectedIds as $id) {
                $item = Notabon_ujs::findOrFail($id);

                // Hitung jumlah memo ekspedisi yang telah diposting dengan nama driver yang sama
                $postedCount = Notabon_ujs::where('nama_driver', $item->nama_driver)
                    ->where('status', 'posting')
                    ->count();

                // Jika jumlahnya sudah mencapai atau melebihi 3 dan memo ekspedisi ini belum diposting, lewati memo ekspedisi ini
                if ($postedCount >= 2 && $item->status !== 'posting') {
                    continue;
                }

                if ($item->status === 'unpost') {

                    Pengeluaran_kaskecil::where('notabon_ujs_id', $id)->update([
                        'status' => 'posting'
                    ]);

                    Detail_pengeluaran::where('notabon_ujs_id', $id)->update([
                        'status' => 'posting'
                    ]);


                    $tanggal1 = Carbon::now('Asia/Jakarta');

                    // Update the Memo_ekspedisi status
                    $item->update([
                        'status' => 'posting'
                    ]);

                    // Update saldo deduction based on successfully posted memo
                    $lastSaldo->update([
                        'sisa_saldo' => $lastSaldo->sisa_saldo - ($item->nominal)
                    ]);
                }
            }

            return back()->with('success', 'Berhasil memposting nota yang dipilih');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return back()->with('error', 'Terdapat nota yang tidak ditemukan');
        }
    }


    public function unpostfilternota(Request $request)
    {
        $selectedIds = array_reverse(explode(',', $request->input('ids')));

        try {
            // Initialize total deduction amount
            $totalDeduction = 0;
            $totalDeductionujs = 0;

            foreach ($selectedIds as $id) {
                // Check if the driver has already three or more posted memos

                $item = Notabon_ujs::findOrFail($id);

                // Pastikan hanya memproses memo ekspedisi dengan status 'unpost'
                if ($item->status === 'posting') {
                    // Accumulate total deduction amount
                    $totalDeduction += $item->nominal;
                }
            }

            // Get the last saldo
            $lastSaldo = Saldo::latest()->first();

            if (!$lastSaldo) {
                return back()->with('error', 'Saldo tidak ditemukan');
            }

            // Check if total uang jalan request is greater than saldo
            $totalUangJalanRequest = array_reduce($selectedIds, function ($carry, $id) {
                $item = Notabon_ujs::findOrFail($id);
                return $carry + $item->nominal;
            }, 0);


            // Update transactions and memo statuses
            foreach ($selectedIds as $id) {
                $item = Notabon_ujs::findOrFail($id);

                if ($item->status === 'posting') {
                    $user = $item->user;

                    Pengeluaran_kaskecil::where('notabon_ujs_id', $id)->update([
                        'status' => 'pending'
                    ]);

                    Detail_pengeluaran::where('notabon_ujs_id', $id)->update([
                        'status' => 'pending'
                    ]);

                    // Update the Memo_ekspedisi status
                    $item->update([
                        'status' => 'unpost'
                    ]);

                    // Update saldo deduction based on successfully posted memo
                    $lastSaldo->update([
                        'sisa_saldo' => $lastSaldo->sisa_saldo + ($item->nominal)
                    ]);
                }
            }

            return;

            return back()->with('success', 'Berhasil memposting memo yang dipilih');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return back()->with('error', 'Terdapat memo yang tidak ditemukan');
        }
    }

    public function cetak_notafilter(Request $request)
    {
        $selectedIds = explode(',', $request->input('ids'));
        $notas = Notabon_ujs::whereIn('id', $selectedIds)->orderBy('id', 'DESC')->get();

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('admin.inquery_notabon.cetak_pdffilter', compact('notas'));
        $pdf->setPaper('folio');

        return $pdf->stream('SelectedNota.pdf');
    }

    public function cetak_nota3filter(Request $request)
    {
        $selectedIds = explode(',', $request->input('ids'));
        $notas = Notabon_ujs::whereIn('id', $selectedIds)->orderBy('id', 'DESC')->get();

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('admin.inquery_notabon.cetak3_pdffilter', compact('notas'));
        $pdf->setPaper('letter', 'portrait'); // Set the paper size to portrait letter
        return $pdf->stream('SelectedNota.pdf');
    }

    public function hapusnotabon($id)
    {
        $item = Notabon_ujs::where('id', $id)->first();
        $item->delete();
        return back()->with('success', 'Berhasil');
    }

    public function excel_notabonfilter(Request $request)
    {
        $selectedIds = explode(',', $request->input('ids'));

        $nota_bon = Notabon_ujs::whereIn('id', $selectedIds)->orderBy('id', 'DESC')->get();

        if (!$nota_bon) {
            return redirect()->back()->withErrors(['error' => 'Data Memo tidak ditemukan']);
        }

        // Ekspor sebagai CSV
        return Excel::download(new RekapNotabonExport($nota_bon), 'rekap_nota_bon.csv', \Maatwebsite\Excel\Excel::CSV);
    }
}