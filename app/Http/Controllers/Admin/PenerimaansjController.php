<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\admin\RuteperjalananController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use App\Models\Pelanggan;
use App\Models\Rute_perjalanan;
use App\Models\Spk;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class PenerimaansjController extends Controller
{
    public function index(Request $request)
    {
        $status_spk = $request->status_spk;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $spks = Spk::query();

        if ($status_spk) {
            $spks->where('status_spk', $status_spk);
        }

        if ($tanggal_awal && $tanggal_akhir) {
            $spks->whereBetween('tanggal_awal', [$tanggal_awal, $tanggal_akhir]);
        } elseif ($tanggal_awal) {
            $spks->where('tanggal_awal', '>=', $tanggal_awal);
        } elseif ($tanggal_akhir) {
            $spks->where('tanggal_awal', '<=', $tanggal_akhir);
        } else {
            // Jika tidak ada filter tanggal hari ini
            $spks->whereDate('tanggal_awal', Carbon::today());
        }

        $spks->orderBy('id', 'DESC');
        $spks = $spks->get();

        return view('admin.penerimaan_sj.index', compact('spks'));
    }

    public function postingspkpenerimaan($id)
    {
        $ban = Spk::where('id', $id)->first();

        $ban->update([
            'status_spk' => 'sj'
        ]);

        return response()->json(['success' => 'Berhasil memposting penerimaan']);
    }

    public function unpostspkpenerimaan($id)
    {
        $spk = Spk::where('id', $id)->first();

        if (!$spk) {
            return response()->json(['error' => 'SPK not found'], 404);
        }

        if ($spk->kategori === 'non memo') {
            $status_spk = 'non memo';
        } elseif ($spk->kategori === 'memo') {
            $status_spk = 'memo';
        } else {
            return response()->json(['error' => 'Invalid kategori value'], 400);
        }

        $spk->update([
            'status_spk' => $status_spk
        ]);

        return response()->json(['success' => 'Berhasil unpost penerimaan']);
    }


    public function postingfilterpenerimaansj(Request $request)
    {
        $selectedIds = array_reverse(explode(',', $request->input('ids')));

        try {
            // Update transactions and memo statuses
            foreach ($selectedIds as $id) {
                $item = Spk::findOrFail($id);

                if ($item->status_spk === 'memo') {
                    $item->update([
                        'status_spk' => 'sj'
                    ]);
                }
            }

            return back()->with('success', 'Berhasil memposting surat penerimaan sj yang dipilih');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return back()->with('error', 'Terdapat surat penerimaan sj yang tidak ditemukan');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat memposting surat penerimaan sj: ' . $e->getMessage());
        }
    }

    public function unpostfilterpenerimaansj(Request $request)
    {
        $selectedIds = array_reverse(explode(',', $request->input('ids')));

        try {
            // Update transactions and memo statuses
            foreach ($selectedIds as $id) {
                $item = Spk::findOrFail($id);

                if ($item->status_spk === 'sj') {
                    $item->update([
                        'status_spk' => 'memo'
                    ]);
                }
            }

            return back()->with('success', 'Berhasil mengunpost surat penerimaan sj yang dipilih');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return back()->with('error', 'Terdapat surat penerimaan sj yang tidak ditemukan');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mengunpost surat penerimaan sj: ' . $e->getMessage());
        }
    }
}