<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\User;
use App\Models\Karyawan;
use App\Models\Departemen;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        if (auth()->check() && auth()->user()->menu['user']) {

            $users = User::where(['cek_hapus' => 'tidak'])->get();
            return view('admin/user.index', compact('users'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function create()
    {
        if (auth()->check() && auth()->user()->menu['user']) {

            $departemens = Departemen::all();
            $karyawans = Karyawan::where(['status' => 'null'])->get();
            return view('admin/user.create', compact('departemens', 'karyawans'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function karyawan($id)
    {
        $user = Karyawan::where('id', $id)->first();

        return json_decode($user);
    }

    public function edit($id)
    {
        if (auth()->check() && auth()->user()->menu['user']) {

            $user = User::where('id', $id)->first();
            return view('admin/user.update', compact('user'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function access($id)
    {
        if (auth()->check() && auth()->user()->menu['user']) {

            $user = User::where('id', $id)->first();
            return view('admin/user.access', compact('user'));
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
                'karyawan_id' => 'required',
            ],
            [
                'karyawan_id.required' => 'Pilih kode karyawan',
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }

        $number = mt_rand(1000000000, 9999999999);
        if ($this->qrcodeUserExists($number)) {
            $number = mt_rand(1000000000, 9999999999);
        }

        User::create(array_merge(
            $request->all(),
            [
                // 'menu' => '-',
                // 'password' => '-',
                'cek_hapus' => 'tidak',
                'kode_user' => $this->kode(),
                'qrcode_user' => $number,
                'tanggal_awal' => Carbon::now('Asia/Jakarta'),
                'menu' => [
                    'akses' => false,
                    'karyawan' => false,
                    'user' => false,
                    'departemen' => false,
                    'supplier' => false,
                    'pelanggan' => false,
                    'kendaraan' => false,
                    'ban' => false,
                    'golongan' => false,
                    'divisi mobil' => false,
                    'jenis kendaraan' => false,
                    'ukuran ban' => false,
                    'merek ban' => false,
                    'type ban' => false,
                    'nokir' => false,
                    'stnk' => false,
                    'part' => false,
                    //opersional //
                    'update km' => false,
                    'perpanjangan stnk' => false,
                    'perpanjangan kir' => false,
                    'pemasangan ban' => false,
                    'pelepasan ban' => false,
                    'pemasangan part' => false,
                    'penggantian oli' => false,
                    'status perjalanan kendaraan' => false,
                    //transaksi//
                    'pembelian ban' => false,
                    'pembelian part' => false,
                    'inquery pembelian ban' => false,
                    'inquery pembelian part' => false,
                    'inquery pemasangan ban' => false,
                    'inquery pelepasan ban' => false,
                    'inquery pemasangan part' => false,
                    'inquery penggantian oli' => false,
                    'inquery update km' => false,
                    //laporan//
                    'laporan pembelian ban' => false,
                    'laporan pembelian part' => false,
                    'laporan pemasangan ban' => false,
                    'laporan pelepasan ban' => false,
                    'laporan pemasangan part' => false,
                    'laporan penggantian oli' => false,
                    'laporan update km' => false,
                    'laporan status perjalanan kendaraaan' => false,
                ]
            ]
        ));

        Karyawan::where('id', $request->karyawan_id)->update([
            'status' => 'user',
        ]);

        return redirect('admin/user')->with('success', 'Berhasil mengubah User');
    }

    public function qrcodeUserExists($number)
    {
        return User::whereQrcodeUser($number)->exists();
    }

    public function cetakpdf($id)
    {
        $cetakpdf = User::where('id', $id)->first();
        $html = view('admin/user.cetak_pdf', compact('cetakpdf'));

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');

        $dompdf->render();

        $dompdf->stream();
    }

    public function kode()
    {
        $id = User::getId();
        foreach ($id as $value);
        $idlm = $value->id;
        $idbr = $idlm + 1;
        $num = sprintf("%06s", $idbr);
        $data = 'AB';
        $kode_user = $data . $num;

        return $kode_user;
    }

    public function access_user(Request $request)
    {

        $pelanggan = $request->pelanggan;

        if ($request->kendaraan) {
            $kendaraan = $request->kendaraan;
        } else {
            $kendaraan = 0;
        }

        if ($request->pelanggan) {
            $pelanggan = $request->pelanggan;
        } else {
            $pelanggan = 0;
        }

        User::where('id', $request->id)->update([
            // 'menu' => $menu,
            'menu' => [
                'kendaraan' => $kendaraan,
                'pelanggan' => $pelanggan
            ]
        ]);

        return redirect('admin/user')->with('success', 'Berhasil menambah Akses');
    }

    public function destroy($id)
    {

        $user = User::find($id);
        Karyawan::where('id', $user->karyawan_id)->update([
            'status' => 'null',
        ]);
        $user->delete();

        LogAktivitas::where('user_id', $id)->update(['user_id' => null]);


        return redirect('admin/user')->with('success', 'Berhasil menghapus user');
    }
}