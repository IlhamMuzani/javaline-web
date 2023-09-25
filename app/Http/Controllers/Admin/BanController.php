<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\Ban;
use App\Models\Merek;
use App\Models\Ukuran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Typeban;
use Illuminate\Support\Facades\Validator;

class BanController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->check() && auth()->user()->menu['ban']) {


            $status = $request->status;

            $inquery = Ban::query();

            if ($status) {
                $inquery->where('status', $status);
            }

            $inquery->orderBy('id', 'DESC');
            $bans = $inquery->get();
            
            return view('admin/ban.index', compact('bans'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function create()
    {
        if (auth()->check() && auth()->user()->menu['ban']) {

            $ukurans = Ukuran::all();
            $mereks = Merek::all();
            $typebans = Typeban::all();
            return view('admin/ban.create', compact('ukurans', 'mereks', 'typebans'));
        } else {
            // tidak memiliki akses
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

        Ban::create(array_merge(
            $request->all(),
            [
                'kode_ban' => $this->kode(),
                'qrcode_ban' => 'https://javaline.id/ban/' . $kode,
                // 'qrcode_ban' => 'http://192.168.1.46/javaline/ban/' . $kode
                'status' => 'stok',
                'tanggal_awal' => Carbon::now('Asia/Jakarta'), 

            ]
        ));
        return redirect('admin/ban')->with('success', 'Berhasil menambahkan ban');
    }

    public function cetakpdf($id)
    {
        $cetakpdf = Ban::where('id', $id)->first();
        $html = view('admin/ban.cetak_pdf', compact('cetakpdf'));

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');

        $dompdf->render();

        $dompdf->stream();
    }


    public function kode()
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

    public function show($id)
    {
        if (auth()->check() && auth()->user()->menu['ban']) {

            $ban = Ban::where('id', $id)->first();
            return view('admin/ban.show', compact('ban'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function edit($id)
    {
        if (auth()->check() && auth()->user()->menu['ban']) {

            $ukurans = Ukuran::all();
            $mereks = Merek::all();
            $typebans = Typeban::all();
            $ban = Ban::where('id', $id)->first();
            return view('admin/ban.update', compact('ukurans', 'mereks', 'ban', 'typebans'));
        } else {
            // tidak memiliki akses
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

        $ban = Ban::findOrFail($id);

        Ban::where('id', $ban->id)->update(
            [
                'no_seri' => $request->no_seri,
                'merek_id' => $request->merek_id,
                'typeban_id' => $request->typeban_id,
                'ukuran_id' => $request->ukuran_id,
                'kondisi_ban' => $request->kondisi_ban,
                'harga' => $request->harga,
                'umur_ban' => $request->umur_ban,
                'target_km_ban' => $request->target_km_ban,
                'tanggal_awal' => Carbon::now('Asia/Jakarta'), 
            ]
        );
        return redirect('admin/ban')->with('success', 'Berhasil memperbarui ban');
    }

    public function destroy($id)
    {
        $ban = Ban::find($id);
        $ban->delete();

        return redirect('admin/ban')->with('success', 'Berhasil menghapus Ban');
    }
}