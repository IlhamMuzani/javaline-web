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
use Illuminate\Support\Facades\Validator;
use Egulias\EmailValidator\Result\Reason\DetailedReason;

class InqueryPembelianBanController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->check() && auth()->user()->menu['inquery pembelian ban']) {

            Pembelian_ban::where([
                ['status', 'posting']
            ])->update([
                'status_notif' => true
            ]);

            $status = $request->status;
            $tanggal_awal = $request->tanggal_awal;
            $tanggal_akhir = $request->tanggal_akhir;

            $inquery = Pembelian_ban::query();

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

            return view('admin.inquery_pembelianban.index', compact('inquery'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function edit($id)
    {
        if (auth()->check() && auth()->user()->menu['inquery pembelian ban']) {

            $inquery = Pembelian_ban::where('id', $id)->first();
            $suppliers = Supplier::all();
            $ukurans = Ukuran::all();
            $mereks = Merek::all();
            $typebans = Typeban::all();
            $details = Ban::where('pembelian_ban_id', $id)->get();

            return view('admin.inquery_pembelianban.update', compact('inquery', 'suppliers', 'typebans', 'ukurans', 'mereks', 'details'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function update(Request $request, $id)
    {
        $validasi_pelanggan = Validator::make($request->all(), [
            'supplier_id' => 'required',
        ], [
            'supplier_id.required' => 'Pilih nama supplier!',
        ]);

        $error_pelanggans = array();
        $error_pesanans = array();
        $data_pembelians = collect();


        if ($validasi_pelanggan->fails()) {
            array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
        }

        if ($request->has('no_seri')) {
            for ($i = 0; $i < count($request->no_seri); $i++) {
                $validasi_produk = Validator::make($request->all(), [
                    'no_seri.' . $i => 'required',
                    'ukuran_id.' . $i => 'required',
                    'kondisi_ban.' . $i => 'required',
                    'merek_id.' . $i => 'required',
                    'typeban_id.' . $i => 'required',
                    'harga.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Pembelian ban nomor " . ($i + 1) . " belum dilengkapi!");
                }


                $no_seri = is_null($request->no_seri[$i]) ? '' : $request->no_seri[$i];
                $ukuran_id = is_null($request->ukuran_id[$i]) ? '' : $request->ukuran_id[$i];
                $kondisi_ban = is_null($request->kondisi_ban[$i]) ? '' : $request->kondisi_ban[$i];
                $merek_id = is_null($request->merek_id[$i]) ? '' : $request->merek_id[$i];
                $typeban_id = is_null($request->typeban_id[$i]) ? '' : $request->typeban_id[$i];
                $harga = is_null($request->harga[$i]) ? '' : $request->harga[$i];

                $data_pembelians->push([
                    'detail_id' => $request->detail_ids[$i] ?? null,
                    'no_seri' => $no_seri,
                    'ukuran_id' => $ukuran_id,
                    'kondisi_ban' => $kondisi_ban,
                    'merek_id' => $merek_id,
                    'typeban_id' => $typeban_id,
                    'harga' => $harga,
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

        // format tanggal indo
        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');

        $tanggal = Carbon::now()->format('Y-m-d');
        $transaksi = Pembelian_ban::findOrFail($id);

        // Update the main transaction
        $transaksi->update([
            'supplier_id' => $request->supplier_id,
            'tanggal' => $format_tanggal,
            'tanggal_awal' => $tanggal,
            'status' => 'posting',
        ]);

        $transaksi_id = $transaksi->id;

        $detailIds = $request->input('detail_ids');

        foreach ($data_pembelians as $data_pesanan) {
            $detailId = $data_pesanan['detail_id'];

            if ($detailId) {
                Ban::where('id', $detailId)->update([
                    'pembelian_ban_id' => $transaksi->id,
                    'no_seri' => $data_pesanan['no_seri'],
                    'ukuran_id' => $data_pesanan['ukuran_id'],
                    'kondisi_ban' => $data_pesanan['kondisi_ban'],
                    'merek_id' => $data_pesanan['merek_id'],
                    'typeban_id' => $data_pesanan['typeban_id'],
                    'harga' => $data_pesanan['harga'],
                ]);
            } else {
                $existingDetail = Ban::where([
                    'pembelian_ban_id' => $transaksi->id,
                    'no_seri' => $data_pesanan['no_seri'],
                ])->first();


                $kodeban = $this->kodeban();
                if (!$existingDetail) {
                    Ban::create([
                        'kode_ban' => $this->kodeban(),
                        'pembelian_ban_id' => $transaksi->id,
                        'qrcode_ban' => 'https://javaline.id/ban/' . $this->kodeban(),
                        'status' => 'stok',
                        'tanggal_awal' => Carbon::now('Asia/Jakarta'),
                        'no_seri' => $data_pesanan['no_seri'],
                        'ukuran_id' => $data_pesanan['ukuran_id'],
                        'kondisi_ban' => $data_pesanan['kondisi_ban'],
                        'merek_id' => $data_pesanan['merek_id'],
                        'typeban_id' => $data_pesanan['typeban_id'],
                        'harga' => $data_pesanan['harga'],
                    ]);
                }
            }
        }

        $pembelians = Pembelian_ban::find($transaksi_id);
        $bans = Ban::where('pembelian_ban_id', $pembelians->id)->get();

        return view('admin.inquery_pembelianban.show', compact('bans', 'pembelians'));

        // $pembelians = Pembelian_ban::find($transaksi);


        // return redirect('admin/inquery_pembelianban')->with('success', 'Berhasil memperbarui Pembelian ban');
    }

    public function unpostban($id)
    {
        $ban = Pembelian_ban::where('id', $id)->first();

        $ban->update([
            'status' => 'unpost'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function kode_supp()
    {
        $supplier = Supplier::all();
        if ($supplier->isEmpty()) {
            $num = "000001";
        } else {
            $id = Supplier::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'AC';
        $kode_supplier = $data . $num;
        return $kode_supplier;
    }

    public function postingban($id)
    {
        $ban = Pembelian_ban::where('id', $id)->first();

        $ban->update([
            'status' => 'posting'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function kode()
    {
        $pembelian_ban = Pembelian_ban::all();
        if ($pembelian_ban->isEmpty()) {
            $num = "000001";
        } else {
            $id = Pembelian_ban::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'FB';
        $kode_pembelian_ban = $data . $num;
        return $kode_pembelian_ban;
    }

    public function kodeban()
    {
        $ban = Ban::all();
        if ($ban->isEmpty()) {
            $num = "000001";
        } else {
            $id = Ban::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'JL';
        $kode_ban = $data . $num;
        return $kode_ban;
    }

    public function lihat_faktur($id)
    {
        if (auth()->check() && auth()->user()->menu['inquery pembelian ban']) {

            $pembelians = Pembelian_ban::where('id', $id)->first();
            $pembelian_ban = Pembelian_ban::find($id);

            $bans = Ban::where('pembelian_ban_id', $pembelian_ban->id)->get();

            return view('admin.inquery_pembelianban.show', compact('bans', 'pembelians'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function edit_faktur($id)
    {
        if (auth()->check() && auth()->user()->menu['inquery pembelian ban']) {

            $inquery = Pembelian_ban::where('id', $id)->first();
            $suppliers = Supplier::all();
            $ukurans = Ukuran::all();
            $mereks = Merek::all();
            $details = Ban::where('pembelian_ban_id', $id)->get();

            return view('admin.inquery_pembelianban.update', compact('inquery', 'suppliers', 'ukurans', 'mereks', 'details'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function destroy($id)
    {
        $ban = Pembelian_ban::find($id);
        $ban->detail_ban()->delete();
        $ban->delete();

        return redirect('admin/inquery_pembelianban')->with('success', 'Berhasil menghapus Pembelian');
    }

    // public function removeBan($id)
    // {
    //     $detail = Ban::findOrFail($id);
    //     $detail->delete();

    //     return response()->json(['message' => 'Data deleted successfully']);
    // }
}
