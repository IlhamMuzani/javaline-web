<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Kendaraan;
use App\Models\aki;
use Illuminate\Http\Request;
use App\Models\Pemasangan_aki;
use App\Http\Controllers\Controller;
use App\Models\Detail_pemasanganaki;
use Illuminate\Support\Facades\Validator;

class InqueryPemasanganakiController extends Controller
{
    public function index(Request $request)
    {


        Pemasangan_aki::where([
            ['status', 'posting']
        ])->update([
            'status_notif' => true
        ]);

        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $inquery = Pemasangan_aki::query();

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
            $inquery->orWhereDate('tanggal_awal', Carbon::today());
        }


        $inquery->orderBy('id', 'DESC');
        $inquery = $inquery->get();

        return view('admin.inquery_pemasanganaki.index', compact('inquery'));
    }

    public function edit($id)
    {

        $inquery = Pemasangan_aki::where('id', $id)->first();
        $kendaraans = Kendaraan::all();
        $spareparts = Aki::where('status_aki', 'stok')->get();

        $details = Detail_pemasanganaki::where('pemasangan_aki_id', $id)->get();

        return view('admin.inquery_pemasanganaki.update', compact('inquery', 'kendaraans', 'spareparts', 'details'));
    }


    public function update(Request $request, $id)
    {
        $validasi_pelanggan = Validator::make($request->all(), [
            // 'kendaraan_id' => 'required',
        ], [
            // 'kendaraan_id.required' => 'Pilih no kabin!',
        ]);

        $error_pelanggans = array();
        $error_pesanans = array();
        $data_pembelians = collect();

        $item = Pemasangan_aki::findOrFail($id);
        $tanggal_awal = Carbon::parse($item->tanggal_awal);

        $today = Carbon::now('Asia/Jakarta')->format('Y-m-d');
        $lastUpdatedDate = $tanggal_awal->format('Y-m-d');

        // if ($lastUpdatedDate < $today) {
        //     return back()->with('errormax', 'Anda tidak dapat melakukan update setelah berganti hari.');
        // }

        if ($validasi_pelanggan->fails()) {
            array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
        }


        if ($request->has('aki_id')) {
            for ($i = 0; $i < count($request->aki_id); $i++) {
                $validasi_produk = Validator::make($request->all(), [
                    'aki_id.' . $i => 'required',
                    'kode_aki.' . $i => 'required',
                    'merek.' . $i => 'required',
                    'keterangan.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Pemasangan Aki nomor " . $i + 1 . " belum dilengkapi!");
                }

                $aki_id = is_null($request->aki_id[$i]) ? '' : $request->aki_id[$i];
                $kode_aki = is_null($request->kode_aki[$i]) ? '' : $request->kode_aki[$i];
                $merek = is_null($request->merek[$i]) ? '' : $request->merek[$i];
                $keterangan = is_null($request->keterangan[$i]) ? '' : $request->keterangan[$i];

                $data_pembelians->push([
                    'detail_id' => $request->detail_ids[$i] ?? null,
                    'aki_id' => $aki_id,
                    'kode_aki' => $kode_aki,
                    'merek' => $merek,
                    'keterangan' => $keterangan,
                ]);
            }
        } else {
        }

        if ($error_pelanggans || $error_pesanans) {
            return back()
                ->withInput()
                ->with('error_pelanggans', $error_pelanggans)
                ->with('error_pesanans', $error_pesanans)
                ->with('data_pembelians', $data_pembelians);
        }

        $transaksi = Pemasangan_aki::findOrFail($id);

        $transaksi->update([
            'kendaraan_id' => $request->kendaraan_id,
            'status' => 'posting',
        ]);

        $transaksi_id = $transaksi->id;


        $detailIds = $request->input('detail_ids');

        $detailIds = $request->input('detail_ids');

        foreach ($data_pembelians as $data_pesanan) {
            $detailId = $data_pesanan['detail_id'];

            if ($detailId) {
                Detail_pemasanganaki::where('id', $detailId)->update([
                    'pemasangan_aki_id' => $transaksi->id,
                    'aki_id' => $data_pesanan['aki_id'],
                    'kode_aki' => $data_pesanan['kode_aki'],
                    'merek' => $data_pesanan['merek'],
                    'keterangan' => $data_pesanan['keterangan'],
                ]);
                $akis = Detail_pemasanganaki::find($data_pesanan['aki_id']);
                $akis->update(['status_aki' => 'aktif']);
            } else {
                $existingDetail = Detail_pemasanganaki::where([
                    'pemasangan_aki_id' => $transaksi->id,
                    'aki_id' => $data_pesanan['aki_id'],
                ])->first();


                $kodeaki = $this->kodeaki();
                if (!$existingDetail) {
                    Detail_pemasanganaki::create([
                        'pemasangan_aki_id' => $transaksi->id,
                        'aki_id' => $data_pesanan['aki_id'],
                        'kode_aki' => $data_pesanan['kode_aki'],
                        'merek' => $data_pesanan['merek'],
                        'tanggal_awal' => Carbon::now('Asia/Jakarta'),
                        'keterangan' => $data_pesanan['keterangan'],
                    ]);
                    $akis = Detail_pemasanganaki::find($data_pesanan['aki_id']);
                    $akis->update(['status_aki' => 'aktif']);
                }
            }
        }


        $cetakpdf = Pemasangan_aki::find($transaksi_id);

        $details = Detail_pemasanganaki::where('pemasangan_aki_id', $cetakpdf->id)->get();

        return view('admin.inquery_pemasanganaki.show', compact('details', 'cetakpdf'));
    }

    public function unpostpemasangan_aki($id)
    {
        $item = Pemasangan_aki::where('id', $id)->first();
        $details = Detail_pemasanganaki::where('pemasangan_aki_id', $id)->get();
        foreach ($details as $detail) {
            $aki = Aki::where('id', $detail->aki_id)->first();
            $aki->update([
                'status_aki' => 'stok',
            ]);
        }

        $item->update([
            'status' => 'unpost'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function postingpemasangan_aki($id)
    {
        $item = Pemasangan_aki::where('id', $id)->first();
        $details = Detail_pemasanganaki::where('pemasangan_aki_id', $id)->get();
        foreach ($details as $detail) {
            $aki = Aki::where('id', $detail->aki_id)->first();
            $aki->update([
                'status_aki' => 'aktif',
            ]);
        }

        $item->update([
            'status' => 'posting'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function show($id)
    {

        $pemasangan_aki = Pemasangan_aki::find($id);
        $details = Detail_pemasanganaki::where('pemasangan_aki_id', $pemasangan_aki->id)->get();


        $cetakpdf = Pemasangan_aki::where('id', $id)->first();

        return view('admin.inquery_pemasanganaki.show', compact('details', 'cetakpdf'));
    }


    public function hapuspemasangan_aki($id)
    {
        $item = Pemasangan_aki::find($id);
        $item->detail_pemasanganaki()->delete();
        $item->delete();
    }
}