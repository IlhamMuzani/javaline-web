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
                    'karyawan' => false,
                    'user' => false,
                    'akses' => false,
                    'departemen' => false,
                    'supplier' => false,
                    'pelanggan' => false,
                    'divisi mobil' => false,
                    'jenis kendaraan' => false,
                    'golongan' => false,
                    'kendaraan' => false,
                    'ukuran ban' => false,
                    'merek ban' => false,
                    'type ban' => false,
                    'ban' => false,
                    'nokir' => false,
                    'stnk' => false,
                    'part' => false,
                    'rute perjalanan' => false,
                    'update km' => false,
                    'perpanjangan stnk' => false,
                    'perpanjangan kir' => false,
                    'pemasangan ban' => false,
                    'pelepasan ban' => false,
                    'pemasangan part' => false,
                    'penggantian oli' => false,
                    'status perjalanan kendaraan' => false,
                    'pembelian ban' => false,
                    'pembelian part' => false,
                    'inquery pembelian ban' => false,
                    'inquery pembelian part' => false,
                    'inquery pemasangan ban' => false,
                    'inquery pelepasan ban' => false,
                    'inquery pemasangan part' => false,
                    'inquery penggantian oli' => false,
                    'inquery update km' => false,
                    'inquery perpanjangan stnk' => false,
                    'inquery perpanjangan kir' => false,
                    'penerimaan kas kecil' => false,
                    'inquery penerimaan kas kecil' => false,
                    'laporan pembelian ban' => false,
                    'laporan pembelian part' => false,
                    'laporan pemasangan ban' => false,
                    'laporan pelepasan ban' => false,
                    'laporan pemasangan part' => false,
                    'laporan penggantian oli' => false,
                    'laporan update km' => false,
                    'laporan status perjalanan kendaraan' => false,
                    'laporan penerimaan kas kecil' => false,
                ],
                'fitur' => [
                    // karyawan
                    'karyawan create' => false,
                    'karyawan update' => false,
                    'karyawan delete' => false,
                    'karyawan show' => false,

                    // user
                    'user create' => false,
                    'user delete' => false,

                    // hak akses
                    'hak akses create' => false,

                    // departemen
                    'departemen create' => false,
                    'departemen update' => false,

                    // supplier
                    'supplier create' => false,
                    'supplier update' => false,
                    'supplier delete' => false,
                    'supplier show' => false,

                    // pelanggan
                    'pelanggan create' => false,
                    'pelanggan update' => false,
                    'pelanggan delete' => false,
                    'pelanggan show' => false,

                    // divisi
                    'divisi create' => false,
                    'divisi update' => false,
                    'divisi delete' => false,

                    // jenis kendaraan   
                    'jenis kendaraan create' => false,
                    'jenis kendaraan update' => false,
                    'jenis kendaraan delete' => false,

                    // golongan   
                    'golongan create' => false,
                    'golongan update' => false,
                    'golongan delete' => false,

                    // kendaraan
                    'kendaraan create' => false,
                    'kendaraan update' => false,
                    'kendaraan delete' => false,
                    'kendaraan show' => false,

                    // ukuran ban   
                    'ukuran ban create' => false,
                    'ukuran ban update' => false,
                    'ukuran ban delete' => false,

                    // merek   
                    'merek create' => false,
                    'merek update' => false,
                    'merek delete' => false,

                    // type   
                    'type create' => false,
                    'type update' => false,
                    'type delete' => false,

                    // ban
                    'ban create' => false,
                    'ban update' => false,
                    'ban delete' => false,
                    'ban show' => false,

                    // nokir
                    'nokir print' => false,
                    'nokir create' => false,
                    'nokir update' => false,
                    'nokir delete' => false,
                    'nokir show' => false,

                    // nokir
                    'stnk create' => false,
                    'stnk update' => false,
                    'stnk delete' => false,
                    'stnk show' => false,

                    // part
                    'part create' => false,
                    'part update' => false,
                    'part delete' => false,
                    'part show' => false,

                    // merek   
                    'rute create' => false,
                    'rute update' => false,
                    'rute delete' => false,

                    // perpanjangan stnk   
                    'perpanjangan stnk show' => false,
                    'perpanjangan stnk create' => false,

                    // perpanjangan kir   
                    'perpanjangan kir show' => false,
                    'perpanjangan kir create' => false,

                    // penggantian oli 
                    'penggantian oli create' => false,

                    // inquery pembelian ban   
                    'inquery pembelian ban posting' => false,
                    'inquery pembelian ban unpost' => false,
                    'inquery pembelian ban update' => false,
                    'inquery pembelian ban delete' => false,
                    'inquery pembelian ban show' => false,

                    // inquery pembelian part   
                    'inquery pembelian part posting' => false,
                    'inquery pembelian part unpost' => false,
                    'inquery pembelian part update' => false,
                    'inquery pembelian part delete' => false,
                    'inquery pembelian part show' => false,

                    // inquery pemasangan ban   
                    'inquery pemasangan ban posting' => false,
                    'inquery pemasangan ban unpost' => false,
                    'inquery pemasangan ban update' => false,
                    'inquery pemasangan ban delete' => false,
                    'inquery pemasangan ban show' => false,

                    // inquery pelepasan ban   
                    'inquery pelepasan ban posting' => false,
                    'inquery pelepasan ban unpost' => false,
                    'inquery pelepasan ban update' => false,
                    'inquery pelepasan ban delete' => false,
                    'inquery pelepasan ban show' => false,

                    // inquery pemasangan part   
                    'inquery pemasangan part posting' => false,
                    'inquery pemasangan part unpost' => false,
                    'inquery pemasangan part update' => false,
                    'inquery pemasangan part delete' => false,
                    'inquery pemasangan part show' => false,

                    // inquery penggantian oli   
                    'inquery penggantian oli posting' => false,
                    'inquery penggantian oli unpost' => false,
                    'inquery penggantian oli update' => false,
                    'inquery penggantian oli delete' => false,
                    'inquery penggantian oli show' => false,

                    // inquery update km   
                    'inquery update km posting' => false,
                    'inquery update km unpost' => false,
                    'inquery update km update' => false,
                    'inquery update km delete' => false,
                    'inquery update km show' => false,

                    // inquery perpanjangan stnk   
                    'inquery perpanjangan stnk posting' => false,
                    'inquery perpanjangan stnk unpost' => false,
                    'inquery perpanjangan stnk update' => false,
                    'inquery perpanjangan stnk delete' => false,
                    'inquery perpanjangan stnk show' => false,

                    // inquery perpanjangan kir   
                    'inquery perpanjangan kir posting' => false,
                    'inquery perpanjangan kir unpost' => false,
                    'inquery perpanjangan kir update' => false,
                    'inquery perpanjangan kir delete' => false,
                    'inquery perpanjangan kir show' => false,

                    // penerimaan kas kecil
                    // 'penerimaan kas kecil create' => false,
                    // 'penerimaan kas kecil update' => false,
                    // 'penerimaan kas kecil delete' => false,
                    // 'penerimaan kas kecil show' => false,

                    // inquery penerimaan kas kecil   
                    'inquery penerimaan kas kecil posting' => false,
                    'inquery penerimaan kas kecil unpost' => false,
                    'inquery penerimaan kas kecil update' => false,
                    'inquery penerimaan kas kecil delete' => false,
                    'inquery penerimaan kas kecil show' => false,

                    // laporan pembelian ban
                    'laporan pembelian ban cari' => false,
                    'laporan pembelian ban cetak' => false,

                    // laporan pembelian part
                    'laporan pembelian part cari' => false,
                    'laporan pembelian part cetak' => false,

                    // laporan pemasangan ban
                    'laporan pemasangan ban cari' => false,
                    'laporan pemasangan ban cetak' => false,

                    // laporan pelepasan ban
                    'laporan pelepasan ban cari' => false,
                    'laporan pelepasan ban cetak' => false,

                    // laporan pemasangan part
                    'laporan pemasangan part cari' => false,
                    'laporan pemasangan part cetak' => false,

                    // laporan penggantian oli
                    'laporan penggantian oli cari' => false,
                    'laporan penggantian oli cetak' => false,

                    // laporan update km
                    'laporan update km cari' => false,
                    'laporan update km cetak' => false,

                    // laporan status perjalanan
                    'laporan status perjalanan cari' => false,
                    'laporan status perjalanan cetak' => false,

                    // laporan penerimaan kas kecil 
                    'laporan penerimaan kas kecil cari' => false,
                    'laporan penerimaan kas kecil cetak' => false,
                ]
            ]
        ));

        $karyawan = Karyawan::findOrFail($request->karyawan_id);
        $karyawan->status = 'user';
        $karyawan->save();

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