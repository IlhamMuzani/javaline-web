<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use App\Models\Aki;
use App\Models\Merek;
use App\Models\Ukuran;
use App\Models\Typeban;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\Pembelian_aki;
use App\Http\Controllers\Controller;
use App\Models\Merek_aki;
use Illuminate\Support\Facades\Validator;

class InqueryPembelianAkiController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->check() && auth()->user()->menu['inquery pembelian part']) {

            Pembelian_aki::where([
                ['status', 'posting']
            ])->update([
                'status_notif' => true
            ]);

            $status = $request->status;
            $tanggal_awal = $request->tanggal_awal;
            $tanggal_akhir = $request->tanggal_akhir;

            $inquery = Pembelian_aki::query();

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

            return view('admin.inquery_pembelianaki.index', compact('inquery'));
        } else {
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function edit($id)
    {
        if (auth()->check() && auth()->user()->menu['inquery pembelian part']) {

            $inquery = Pembelian_aki::where('id', $id)->first();
            $suppliers = Supplier::all();
            $mereks = Merek_aki::all();
            $details = Aki::where('pembelian_aki_id', $id)->get();

            return view('admin.inquery_pembelianaki.update', compact('inquery', 'suppliers', 'mereks', 'details'));
        } else {
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
                    'kondisi_aki.' . $i => 'required',
                    'merek_aki_id.' . $i => 'required',
                    'harga.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Pembelian item nomor " . ($i + 1) . " belum dilengkapi!");
                }


                $no_seri = is_null($request->no_seri[$i]) ? '' : $request->no_seri[$i];
                $kondisi_aki = is_null($request->kondisi_aki[$i]) ? '' : $request->kondisi_aki[$i];
                $merek_aki_id = is_null($request->merek_aki_id[$i]) ? '' : $request->merek_aki_id[$i];
                $harga = is_null($request->harga[$i]) ? '' : $request->harga[$i];

                $data_pembelians->push([
                    'detail_id' => $request->detail_ids[$i] ?? null,
                    'no_seri' => $no_seri,
                    'kondisi_aki' => $kondisi_aki,
                    'merek_aki_id' => $merek_aki_id,
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
        $transaksi = Pembelian_aki::findOrFail($id);

        $transaksi->update([
            'supplier_id' => $request->supplier_id,
            'grand_total' => str_replace(',', '.', str_replace('.', '', $request->grand_total)),
            'status' => 'posting',
        ]);

        $transaksi_id = $transaksi->id;

        $detailIds = $request->input('detail_ids');

        foreach ($data_pembelians as $data_pesanan) {
            $detailId = $data_pesanan['detail_id'];

            if ($detailId) {
                Aki::where('id', $detailId)->update([
                    'pembelian_aki_id' => $transaksi->id,
                    'no_seri' => $data_pesanan['no_seri'],
                    'kondisi_aki' => $data_pesanan['kondisi_aki'],
                    'merek_aki_id' => $data_pesanan['merek_aki_id'],
                    'status' => 'posting',
                    'status_aki' => 'stok',
                    'harga' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['harga'])),
                ]);
            } else {
                $existingDetail = Aki::where([
                    'pembelian_aki_id' => $transaksi->id,
                    'no_seri' => $data_pesanan['no_seri'],
                ])->first();


                $kodeaki = $this->kodeaki();
                if (!$existingDetail) {
                    Aki::create([
                        'kode_aki' => $this->kodeaki(),
                        'pembelian_aki_id' => $transaksi->id,
                        'qrcode_aki' => 'https://javaline.id/aki/' . $this->kodeaki(),
                        'tanggal_awal' => Carbon::now()->format('Y-m-d'),
                        'no_seri' => $data_pesanan['no_seri'],
                        'kondisi_aki' => $data_pesanan['kondisi_aki'],
                        'merek_aki_id' => $data_pesanan['merek_aki_id'],
                        'status' => 'posting',
                        'status_aki' => 'stok',
                        'harga' =>  str_replace(',', '.', str_replace('.', '', $data_pesanan['harga'])),
                    ]);
                }
            }
        }

        $cetakpdf = Pembelian_aki::find($transaksi_id);
        $akis = Aki::where('pembelian_aki_id', $cetakpdf->id)->get();

        return view('admin.inquery_pembelianaki.show', compact('akis', 'cetakpdf'));
    }

    public function unpostpembelianaki($id)
    {
        $item = Pembelian_aki::where('id', $id)->first();

        $details = Aki::where('pembelian_aki_id', $id)->get();

        foreach ($details as $detail) {
            $detail->update([
                'status' => 'unpost',
            ]);
        }

        $item->update([
            'status' => 'unpost'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function postingpembelianaki($id)
    {
        $item = Pembelian_aki::where('id', $id)->first();

        $details = Aki::where('pembelian_aki_id', $id)->get();

        foreach ($details as $detail) {
            $detail->update(['status' => 'posting']);
        }

        $item->update([
            'status' => 'posting'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function kodeaki()
    {
        $item = Aki::all();
        if ($item->isEmpty()) {
            $num = "000001";
        } else {
            $id = Aki::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'SA';
        $kode_ban = $data . $num;
        return $kode_ban;
    }

    public function show($id)
    {
        if (auth()->check() && auth()->user()->menu['inquery pembelian part']) {

            $pembelian_aki = Pembelian_aki::find($id);
            $akis = Aki::where('pembelian_aki_id', $pembelian_aki->id)->get();


            $cetakpdf = Pembelian_aki::where('id', $id)->first();

            return view('admin.inquery_pembelianaki.show', compact('akis', 'cetakpdf'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function hapuspembelianaki($id)
    {
        $item = Pembelian_aki::where('id', $id)->first();

        $item->aki()->delete();
        $item->delete();
        return back()->with('success', 'Berhasil');
    }

    public function deletedetailaki($id)
    {
        $item = Aki::find($id);

        if ($item) {
            $item->delete();
            return response()->json(['message' => 'Data deleted successfully']);
        } else {
            return response()->json(['message' => 'Detail Faktur not found'], 404);
        }
    }
}