<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    public function index()
    {
        if (auth()->check() && auth()->user()->menu['supplier']) {

            $suppliers = Supplier::all();

            return view('admin/supplier.index', compact('suppliers'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function create()
    {
        if (auth()->check() && auth()->user()->menu['supplier']) {

            return view('admin/supplier.create');
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
                'nama_supp' => 'required',
                'alamat' => 'required',
                // 'nama_person' => 'required',
                // 'jabatan' => 'required',
                // 'fax' => 'required',
                'telp' => 'required',
                'hp' => 'required',
                // 'email' => 'required',
                // 'npwp' => 'required',
                'nama_bank' => 'required',
                'atas_nama' => 'required',
                'norek' => 'required',
            ],
            [
                'nama_supp.required' => 'Masukkan nama supplier',
                'alamat.required' => 'Masukkan Alamat',
                // 'nama_person.required' => 'Masukkan nama',
                // 'jabatan.required' => 'Masukkan jabatan',
                'telp.required' => 'Masukkan no telepon',
                // 'fax.required' => 'Masukkan no fax',
                'hp.required' => 'Masukkan no hp',
                // 'email.required' => 'Masukkan email',
                // 'npwp.required' => 'Masukkan no npwp',
                'nama_bank.required' => 'Masukkan nama bank',
                'atas_nama.required' => 'Masukkan atas nama',
                'norek.required' => 'Masukkan no rekening',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kode = $this->kode();

        Supplier::create(array_merge(
            $request->all(),
            [
                'kode_supplier' => $this->kode(),
                'qrcode_supplier' => 'https://javaline.id/supplier/' . $kode,
                // 'qrcode_supplier' => 'http://192.168.1.46/javaline/supplier/' . $kode
                'tanggal_awal' => Carbon::now('Asia/Jakarta'),
            ]
        ));

        return redirect('admin/supplier')->with('success', 'Berhasil menambahkan supplier');
    }

    public function cetakpdf($id)
    {
        $cetakpdf = Supplier::where('id', $id)->first();
        $html = view('admin/supplier.cetak_pdf', compact('cetakpdf'));

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');

        $dompdf->render();

        $dompdf->stream();
    }

    public function edit($id)
    {
        if (auth()->check() && auth()->user()->menu['supplier']) {

            $supplier = Supplier::where('id', $id)->first();
            return view('admin/supplier.update', compact('supplier'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function show($id)
    {
        if (auth()->check() && auth()->user()->menu['supplier']) {

            $supplier = Supplier::where('id', $id)->first();
            return view('admin/supplier.show', compact('supplier'));
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
                'nama_supp' => 'required',
                'alamat' => 'required',
                'nama_person' => 'required',
                // 'jabatan' => 'required',
                // 'fax' => 'required',
                'telp' => 'required',
                'hp' => 'required',
                // 'email' => 'required',
                // 'npwp' => 'required',
                'nama_bank' => 'required',
                'atas_nama' => 'required',
                'norek' => 'required',
            ],
            [
                'nama_supp.required' => 'Masukkan nama supplier',
                'alamat.required' => 'Masukkan Alamat',
                'nama_person.required' => 'Masukkan nama',
                // 'jabatan.required' => 'Masukkan jabatan',
                // 'telp.required' => 'Masukkan no telepon',
                'fax.required' => 'Masukkan no fax',
                'hp.required' => 'Masukkan no hp',
                // 'email.required' => 'Masukkan email',
                // 'npwp.required' => 'Pilih no npwp',
                'nama_bank.required' => 'Masukkan nama bank',
                'atas_nama.required' => 'Masukkan atas nama',
                'norek.required' => 'Masukkan no rekening',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $supplier = Supplier::findOrFail($id);

        Supplier::where('id', $supplier->id)
            ->update([
                'nama_supp' => $request->nama_supp,
                'alamat' => $request->alamat,
                'nama_person' => $request->nama_person,
                'jabatan' => $request->jabatan,
                'telp' => $request->telp,
                'fax' => $request->fax,
                'hp' => $request->hp,
                'email' => $request->email,
                'npwp' => $request->npwp,
                'nama_bank' => $request->nama_bank,
                'atas_nama' => $request->atas_nama,
                'norek' => $request->norek,
                'tanggal_awal' => Carbon::now('Asia/Jakarta'),
            ]);

        return redirect('admin/supplier')->with('success', 'Berhasil memperbarui supplier');
    }

    public function kode()
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

    public function destroy($id)
    {
        $supplier = Supplier::find($id);
        $supplier->delete();

        return redirect('admin/supplier')->with('success', 'Berhasil menghapus Supplier');
    }
}