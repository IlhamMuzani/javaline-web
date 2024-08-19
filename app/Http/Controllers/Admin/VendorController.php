<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\Supplier;
use App\Models\Vendor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class VendorController extends Controller
{
    public function index(Request $request)
    {
        $query = Vendor::select('id', 'kode_vendor', 'nama_vendor', 'nama_person', 'telp', 'qrcode_vendor');

        if ($request->has('keyword')) {
            $keyword = $request->input('keyword');
            $query->where(function ($q) use ($keyword) {
                $q->where('kode_vendor', 'like', "%$keyword%")
                    ->orWhere('nama_vendor', 'like', "%$keyword%")
                    ->orWhere('nama_person', 'like', "%$keyword%")
                    ->orWhere('telp', 'like', "%$keyword%");
            });
        }

        $vendors = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.vendor.index', compact('vendors'));
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        // Ensure the query is properly formed
        $karyawans = Vendor::where('nama_vendor', 'like', "%$keyword%")
            ->orWhere('kode_vendor', 'like', "%$keyword%")
            ->paginate(10);

        return response()->json($karyawans);
    }


    public function create()
    {

        return view('admin/vendor.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_vendor' => 'required',
                // 'nama_alias' => 'required',
                'alamat' => 'required',
                // 'npwp' => 'required',
                // 'nama_person' => 'required',
                // 'jabatan' => 'required',
                // 'fax' => 'required',
                // 'telp' => 'required',
                // 'hp' => 'required',
                // 'email' => 'required',
            ],
            [
                'nama_vendor.required' => 'Masukkan nama vendor',
                // 'nama_alias.required' => 'Masukkan nama alias',
                'alamat.required' => 'Masukkan alamat',
                // 'npwp.required' => 'Masukkan no npwp',
                // 'nama_person.required' => 'Masukkan nama',
                // 'jabatan.required' => 'Masukkan jabatan',
                // 'telp.required' => 'Masukkan no telepon',
                // 'fax.required' => 'Masukkan no fax',
                // 'hp.required' => 'Masukkan no hp',
                // 'email.required' => 'Masukkan email',
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }

        $kode = $this->kode();

        Vendor::create(array_merge(
            $request->all(),
            [
                'kode_vendor' => $this->kode(),
                'qrcode_vendor' => 'https://javaline.id/vendor/' . $kode,
                'tanggal_awal' => Carbon::now('Asia/Jakarta'),
                // 'qrcode_vendor' => 'http://192.168.1.46/javaline/vendor/' . $kode
            ]
        ));

        return redirect('admin/vendor')->with('success', 'Berhasil menambahkan Rekanan');
    }

    public function cetakpdf($id)
    {
        $cetakpdf = Vendor::where('id', $id)->first();
        $html = view('admin/vendor.cetak_pdf', compact('cetakpdf'));

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');

        $dompdf->render();

        $dompdf->stream();
    }

    public function kode()
    {
        $lastBarang = Vendor::latest()->first();
        if (!$lastBarang) {
            $num = 1;
        } else {
            $lastCode = $lastBarang->kode_vendor;
            $num = (int) substr($lastCode, strlen('AV')) + 1;
        }
        $formattedNum = sprintf("%06s", $num);
        $prefix = 'AV';
        $newCode = $prefix . $formattedNum;
        return $newCode;
    }


    public function show($id)
    {

        $vendor = Vendor::where('id', $id)->first();
        return view('admin/vendor.show', compact('vendor'));
    }

    public function edit($id)
    {

        $vendor = Vendor::where('id', $id)->first();
        return view('admin/vendor.update', compact('vendor'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_vendor' => 'required',
                // 'nama_alias' => 'required',
                'alamat' => 'required',
                // 'npwp' => 'required',
                // 'nama_person' => 'required',
                // 'jabatan' => 'required',
                // 'fax' => 'required',
                // 'telp' => 'required',
                // 'hp' => 'required',
                // 'email' => 'required',
                // 'gambar' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            ],
            [
                'nama_vendor.required' => 'Masukkan nama vendor',
                // 'nama_alias.required' => 'Masukkan nama alias',
                'alamat.required' => 'Masukkan alamat',
                // 'npwp.required' => 'Masukkan no npwp',
                // 'nama_person.required' => 'Masukkan nama',
                // 'jabatan.required' => 'Masukkan jabatan',
                // 'telp.required' => 'Masukkan no telepon',
                // 'fax.required' => 'Masukkan no fax',
                // 'hp.required' => 'Masukkan no hp',
                // 'email.required' => 'Masukkan email',
                // 'gambar.image' => 'Gambar yang dimasukan salah!',
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }

        $vendor = Vendor::findOrfail($id);

        $vendor->nama_vendor = $request->nama_vendor;
        $vendor->nama_alias = $request->nama_alias;
        $vendor->npwp = $request->npwp;
        $vendor->alamat = $request->alamat;
        $vendor->nama_person = $request->nama_person;
        $vendor->jabatan = $request->jabatan;
        $vendor->telp = $request->telp;
        $vendor->fax = $request->fax;
        $vendor->hp = $request->hp;
        $vendor->email = $request->email;
        $vendor->tanggal_awal = Carbon::now('Asia/Jakarta');

        $vendor->save();

        return redirect('admin/vendor')->with('success', 'Berhasil memperbarui Rekanan');
    }

    public function destroy($id)
    {
        $vendor = Vendor::find($id);
        $vendor->delete();

        return redirect('admin/vendor')->with('success', 'Berhasil menghapus Rekanan');
    }
}