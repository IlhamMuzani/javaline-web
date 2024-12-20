<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Aki;
use App\Models\Merek_aki;
use App\Models\Ukuran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use App\Models\Klaim_ban;
use App\Models\Typeban;
use Illuminate\Support\Facades\Validator;

class AkiController extends Controller
{
    public function index(Request $request)
    {

        if (auth()->check() && auth()->user()->menu['ban']) {
            $kendaraans = Kendaraan::all();

            $status = $request->status;
            $created_at = $request->created_at;
            $tanggal_akhir = $request->tanggal_akhir;

            $kendaraan = $request->kendaraan_id;
            $inquery = Aki::query();


            if ($kendaraan) {
                $inquery->where('kendaraan_id', $kendaraan);
            } else {
                if ($status) {
                    $inquery->where('status', $status);
                }
                if ($created_at && $tanggal_akhir) {
                    $inquery->whereBetween('created_at', [$created_at, $tanggal_akhir]);
                } elseif ($created_at) {
                    $inquery->where('created_at', '>=', $created_at);
                } elseif ($tanggal_akhir) {
                    $inquery->where('created_at', '<=', $tanggal_akhir);
                } else {
                    $inquery->whereDate('created_at', Carbon::today());
                }
            }

            $inquery->orderBy('id', 'DESC');
            $akis = $inquery->get();

            return view('admin.aki.index', compact('akis', 'kendaraans'));
        } else {
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function create()
    {
        if (auth()->check() && auth()->user()->menu['ban']) {

            $mereks = Merek_aki::all();
            return view('admin/aki.create', compact('mereks'));
        } else {
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function store(Request  $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'ukuran_id' => 'required',
                'kondisi_ban' => 'required',
                'merek_id' => 'required',
                'typeban_id' => 'required',
                'no_seri' => 'required',
                'harga' => 'required',
                'umur_ban' => 'required',
                'target_km_ban' => 'nullable',
            ],
            [
                'no_seri.required' => 'Masukan no seri ban',
                'merek_id.required' => 'Masukan merek ban',
                'typeban_id.required' => 'Masukkan Type ban',
                'ukuran_ban.required' => 'Ukuran ban',
                'kondisi_ban.required' => 'Pilih kondisi ban',
                'harga.required' => 'Masukan harga satuan ban',
                'umur_ban.required' => 'Masukan umur ban',
                // 'target_km_ban.required' => 'Masukan target km',
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }

        $kode = $this->kode();

        Aki::create(array_merge(
            $request->all(),
            [
                'kode_ban' => $this->kode(),
                'qrcode_ban' => 'https://javaline.id/ban/' . $kode,
                'status' => 'stok',
                'tanggal_awal' => Carbon::now('Asia/Jakarta'),

            ]
        ));
        return redirect('admin/ban')->with('success', 'Berhasil menambahkan ban');
    }

    public function cetakpdf($id)
    {
        $akis = Aki::find($id);
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('admin.ban.cetak_pdf', compact('akis'));
        $pdf->setPaper('letter', 'potrait');
        return $pdf->stream('QrCodeBan.pdf');
    }

    public function cetak_pdffilter(Request $request)
    {
        $selectedIds = explode(',', $request->input('ids'));

        // Now you can use $selectedIds to retrieve the selected IDs and generate the PDF as needed.

        $akis = Aki::whereIn('id', $selectedIds)->orderBy('id', 'DESC')->get();

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('admin.ban.cetak_pdffilter', compact('akis'));
        $pdf->setPaper([0, 0, 612, 48], 'portrait'); // 612x396 piksel setara dengan 8.5x5.5 inci

        return $pdf->stream('SelectedBans.pdf');
    }

    public function kode()
    {
        $ban = Aki::all();
        if ($ban->isEmpty()) {
            $num = "000001";
        } else {
            $id = Aki::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'JL';
        $kode_ban = $data . $num;
        return $kode_ban;
    }

    public function show($id)
    {
        if (auth()->check() && auth()->user()->menu['ban']) {

            $ban = Aki::where('id', $id)->first();
            return view('admin/ban.show', compact('ban'));
        } else {
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function lihat_klaim($id)
    {
        $ban = Aki::where('id', $id)->first();
        $cetakpdf = Klaim_ban::where('ban_id', $id)->first();

        $pdf = PDF::loadView('admin.klaim_ban.cetak_pdf', compact('cetakpdf'));
        $pdf->setPaper('letter', 'portrait'); // Set the paper size to portrait letter

        return $pdf->stream('Surat_klaim_ban_driver.pdf');
    }


    public function edit($id)
    {
        if (auth()->check() && auth()->user()->menu['ban']) {

            $ukurans = Ukuran::all();
            $mereks = Merek_aki::all();
            $typebans = Typeban::all();
            $ban = Aki::where('id', $id)->first();
            return view('admin/ban.update', compact('ukurans', 'mereks', 'ban', 'typebans'));
        } else {
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'no_seri' => 'required',
                'ukuran_id' => 'required',
                'merek_id' => 'required',
                'typeban_id' => 'required',
                'kondisi_ban' => 'required',
                'harga' => 'required',
                'umur_ban' => 'required',
                'target_km_ban' => 'nullable',
            ],
            [
                'no_seri.required' => 'Masukan no seri ban',
                'merek_id.required' => 'Masukan merek ban',
                'typeban_id.required' => 'Masukkan type ban',
                'ukuran_id.required' => 'Masukkan ukuran ban',
                'kondisi_ban.required' => 'Pilih kondisi ban',
                'harga.required' => 'Masukan harga satuan ban',
                'umur_ban.required' => 'Masukan umur ban',
                // 'target_km_ban.required' => 'Masukan target km',
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }

        $ban = Aki::findOrFail($id);

        $today = Carbon::now('Asia/Jakarta')->format('Y-m-d');
        $lastUpdatedDate = $ban->updated_at->format('Y-m-d');

        if ($lastUpdatedDate < $today) {
            return back()->with('errors', 'Anda tidak dapat melakukan update setelah berganti hari.');
        }

        $ban->no_seri = $request->no_seri;
        $ban->merek_id = $request->merek_id;
        $ban->typeban_id = $request->typeban_id;
        $ban->ukuran_id = $request->ukuran_id;
        $ban->kondisi_ban = $request->kondisi_ban;
        $ban->harga = $request->harga;
        $ban->umur_ban = $request->umur_ban;
        $ban->target_km_ban = $request->target_km_ban;
        $ban->tanggal_awal = Carbon::now('Asia/Jakarta');

        $ban->save();

        return redirect('admin/ban')->with('success', 'Berhasil memperbarui ban');
    }

    public function destroy($id)
    {
        $ban = Aki::find($id);
        $ban->delete();

        return redirect('admin/ban')->with('success', 'Berhasil menghapus Aki');
    }
}