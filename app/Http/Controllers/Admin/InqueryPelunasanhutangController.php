<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Pembelian_ban;
use App\Http\Controllers\Controller;
use App\Models\Pelunasan_hutangkw;
use App\Models\Karyawan;
use App\Models\Saldo;
use Illuminate\Support\Facades\Validator;

class InqueryPelunasanhutangController extends Controller
{
    public function index(Request $request)
    {
        Pelunasan_hutangkw::where([
            ['status', 'posting']
        ])->update([
            'status_notif' => true
        ]);

        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;
        $inquery = Pelunasan_hutangkw::query();

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

        return view('admin.inquery_pelunasanhutangkw.index', compact('inquery'));
    }


    public function edit($id)
    {

        $inquery = Pelunasan_hutangkw::where('id', $id)->first();
        $SopirAll =
            Karyawan::whereIn('departemen_id', [1, 4, 5])->get();

        return view('admin.inquery_pelunasanhutangkw.update', compact('inquery', 'SopirAll'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'kategori' => 'required',
                'karyawan_id' => 'required',
            ],
            [
                'kategori.required' => 'Pilih kategori',
                'karyawan_id.required' => 'Pilih sopir',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }


        $penerimaan = Pelunasan_hutangkw::findOrFail($id);

        $tanggal_awal = Carbon::parse($penerimaan->tanggal_awal);

        $today = Carbon::now('Asia/Jakarta')->format('Y-m-d');
        $lastUpdatedDate = $tanggal_awal->format('Y-m-d');

        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');

        $subTotalInput = $request->input('sub_total');
        $cleanedSubTotal = (int) str_replace(['Rp', '.'], '', $subTotalInput);

        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');

        $tanggal = Carbon::now()->format('Y-m-d');
        $penerimaan->update([
            'nominal' => $request->nominal,
            'kode_karyawan' => $request->kode_karyawan,
            'nama_karyawan' => $request->nama_karyawan,
            'keterangan' => $request->keterangan,
            'saldo_masuk' => $request->saldo_masuk,
            'sisa_saldo' => $request->sisa_saldo,
            'sub_total' => $request->sub_total2,
            'status' => 'unpost',
        ]);

        $cetakpdf = Pelunasan_hutangkw::where('id', $id)->first();

        return view('admin.inquery_pelunasanhutangkw.show', compact('cetakpdf'));
    }

    public function show($id)
    {
        $cetakpdf = Pelunasan_hutangkw::where('id', $id)->first();

        return view('admin.inquery_pelunasanhutangkw.show', compact('cetakpdf'));
    }

    public function unpostdeposit($id)
    {
        $item = Pelunasan_hutangkw::find($id);
        if (!$item) {
            return back()->with('error', 'Deposit karyawan tidak ditemukan');
        }
        $sopir = Karyawan::find($item->karyawan_id);

        if (!$sopir) {
            return back()->with('error', 'Karyawan tidak ditemukan');
        }


        // Ambil saldo terakhir
        $lastSaldo = Saldo::latest()->first();

        // Periksa apakah saldo terakhir ditemukan
        if (!$lastSaldo) {
            return back()->with('error', 'Saldo tidak ditemukan');
        }

        $sisaSaldo = $lastSaldo->sisa_saldo - $item->nominal;
        Saldo::create([
            'sisa_saldo' => $sisaSaldo,
        ]);

        $tabungan = $sopir->tabungan;
        $total = $item->nominal;
        $sub_totals = $tabungan - $total;

        $kasbon = $sopir->kasbon;
        $total = $item->nominal;
        $kasbons = $kasbon + $total;
        $sopir->update([
            'kasbon' => $kasbons,
        ]);

        $item->update([
            'status' => 'unpost'
        ]);

        return back()->with('success', 'Berhasil. Tabungan karyawan sekarang: Rp ' . number_format($sub_totals, 0, ',', '.'));
    }

    public function postingdeposit($id)
    {
        $item = Pelunasan_hutangkw::find($id);
        if (!$item) {
            return back()->with('error', 'Deposit karyawan tidak ditemukan');
        }
        $sopir = Karyawan::find($item->karyawan_id);

        if (!$sopir) {
            return back()->with('error', 'Karyawan tidak ditemukan');
        }

        $lastSaldo = Saldo::latest()->first();

        // Periksa apakah saldo terakhir ditemukan
        if (!$lastSaldo) {
            return back()->with('error', 'Saldo tidak ditemukan');
        }

        $sisaSaldo = $lastSaldo->sisa_saldo + $item->nominal;
        Saldo::create([
            'sisa_saldo' => $sisaSaldo,
        ]);

        $kasbon = $sopir->kasbon;
        $totalKasbon = $item->nominal;
        $kasbons = $kasbon - $totalKasbon;
        $tabungan = $sopir->tabungan;
        $total = $item->nominal;
        $sub_totals = $tabungan + $total;

        $sopir->update([
            'kasbon' => $kasbons,
        ]);


        $item->update([
            'status' => 'posting'
        ]);
        return back()->with('success', 'Berhasil. Tabungan karyawan sekarang: Rp ' . number_format($sub_totals, 0, ',', '.'));
    }


    public function postingfilterpengambilandeposit(Request $request)
    {
        $selectedIds = array_reverse(explode(',', $request->input('ids')));

        try {
            // Update transactions and memo statuses
            foreach ($selectedIds as $id) {
                $item = Pelunasan_hutangkw::find($id);
                if (!$item) {
                    return back()->with('error', 'Deposit karyawan tidak ditemukan');
                }
                $sopir = Karyawan::find($item->karyawan_id);

                if (!$sopir) {
                    return back()->with('error', 'Karyawan tidak ditemukan');
                }

                $kasbon = $sopir->kasbon;
                $totalKasbon = $item->nominal;
                $kasbons = $kasbon + $totalKasbon;
                $tabungan = $sopir->tabungan;
                $total = $item->nominal;
                $sub_totals = $tabungan - $total;

                $sopir->update([
                    'kasbon' => $kasbons,
                    // 'deposit' => $deposits,
                    'tabungan' => $sub_totals
                ]);
                $item->update([
                    'status' => 'posting'
                ]);
            }

            return back()->with('success', 'Berhasil memposting');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return back()->with('error', 'Terdapat surat deposit yang tidak ditemukan');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat memposting deposit: ' . $e->getMessage());
        }
    }

    public function unpostfilterpengambilandeposit(Request $request)
    {
        $selectedIds = array_reverse(explode(',', $request->input('ids')));

        try {
            // Update transactions and memo statuses
            foreach ($selectedIds as $id) {
                $item = Pelunasan_hutangkw::find($id);
                if (!$item) {
                    return back()->with('error', 'Deposit karyawan tidak ditemukan');
                }
                $sopir = Karyawan::find($item->karyawan_id);

                if (!$sopir) {
                    return back()->with('error', 'Karyawan tidak ditemukan');
                }
                $tabungan = $sopir->tabungan;
                $total = $item->nominal;
                $sub_totals = $tabungan + $total;

                $kasbon = $sopir->kasbon;
                $total = $item->nominal;
                $kasbons = $kasbon - $total;
                $sopir->update([
                    'kasbon' => $kasbons,
                    // 'deposit' => $deposits,
                    'tabungan' => $sub_totals,
                ]);

                $item->update([
                    'status' => 'unpost'
                ]);
            }

            return back()->with('success', 'Berhasil mengunpost');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return back()->with('error', 'Terdapat deposit yang tidak ditemukan');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mengunpost deposit: ' . $e->getMessage());
        }
    }

    public function hapusdeposit($id)
    {
        $item = Pelunasan_hutangkw::where('id', $id)->first();
        $item->delete();
        return back()->with('success', 'Berhasil');
    }


    public function destroy($id)
    {
        $item = Pembelian_ban::find($id);
        $item->detail_ban()->delete();
        $item->delete();

        return redirect('admin/inquery_pelunasanhutangkw')->with('success', 'Berhasil deposit');
    }
}
