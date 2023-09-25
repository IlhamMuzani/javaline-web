<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\Departemen;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class DepartemenController extends Controller
{
    public function index()
    {
        if (auth()->check() && auth()->user()->menu['departemen']) {

            $departemens = Departemen::all();
            return view('admin/departemen.index', compact('departemens'));
            
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function create()
    {
        if (auth()->check() && auth()->user()->menu['departemen']) {

            return view('admin/departemen.create');
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama' => 'required',
            ],
            [
                'nama.required' => 'Masukkan nama',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $number = mt_rand(1000000000, 9999999999);
        if ($this->qrcodeDepartemenExists($number)) {
            $number = mt_rand(1000000000, 9999999999);
        }

        Departemen::create(array_merge(
            $request->all(),
            [
                'qrcode_departemen' => $number,
                'tanggal_awal' => Carbon::now('Asia/Jakarta'), 
            ]
        ));

        return redirect('admin/departemen')->with('success', 'Berhasil menambahkan departemen');
    }

    public function qrcodeDepartemenExists($number)
    {
        return Departemen::whereQrcodeDepartemen($number)->exists();
    }

    public function cetakpdf($id)
    {
        $cetakpdf = Departemen::where('id', $id)->first();
        $html = view('admin/departemen.cetak_pdf', compact('cetakpdf'));

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');

        $dompdf->render();

        $dompdf->stream();
    }

    public function edit($id)
    {
        if (auth()->check() && auth()->user()->menu['departemen']) {

            $departemen = Departemen::where('id', $id)->first();
            return view('admin/departemen.update', compact('departemen'));
            
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
        ], [
            'nama.required' => 'Nama tidak boleh Kosong',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        Departemen::where('id', $id)->update([
            'nama' => $request->nama,
            'tanggal_awal' => Carbon::now('Asia/Jakarta'), 
        ]);

        return redirect('admin/departemen')->with('success', 'Berhasil memperbarui Departemen');
    }

    public function destroy($id)
    {
        $departemen = Departemen::find($id);
        $departemen->delete();

        return redirect('admin/departemen')->with('success', 'Berhasil menghapus Departemen');
    }
}