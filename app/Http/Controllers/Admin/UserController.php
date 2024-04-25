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
    public function index(Request $request)
    {
        if (auth()->check() && auth()->user()->menu['user']) {
            if ($request->has('keyword')) {
                $keyword = $request->keyword;
                $users = User::where(['cek_hapus' => 'tidak'])
                    ->with('karyawan')
                    ->where(function ($query) use ($keyword) {
                        $query->whereHas('karyawan', function ($query) use ($keyword) {
                            $query->where('nama_lengkap', 'like', "%$keyword%");
                        })
                            ->orWhere('kode_user', 'like', "%$keyword%");
                    })
                    ->paginate(10);
            } else {
                $users = User::where(['cek_hapus' => 'tidak'])
                    ->with('karyawan')
                    ->paginate(10);
            }
            return view('admin.user.index', compact('users'));
        } else {
            return back()->with('error', 'Anda tidak memiliki akses');
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
                    'sopir' => false,
                    'rute perjalanan' => false,
                    'biaya tambahan' => false,
                    'potongan memo' => false,
                    'tarif' => false,
                    'satuan barang' => false,
                    'barang return' => false,
                    'akun' => false,
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
                    'memo ekspedisi' => false,
                    'faktur ekspedisi' => false,
                    'invoice faktur ekspedisi' => false,
                    'return barang ekspedisi' => false,
                    'faktur pelunasan ekspedisi' => false,
                    'pelunasan faktur pembelian ban' => false,
                    'pelunasan faktur pembelian part' => false,
                    'penerimaan kas kecil' => false,
                    'pengambilan kas kecil' => false,
                    'deposit sopir' => false,
                    'list administrasi' => false,
                    'inquery penerimaan kas kecil' => false,
                    'inquery pengambilan kas kecil' => false,
                    'inquery deposit sopir' => false,
                    'inquery update km' => false,
                    'inquery pembelian ban' => false,
                    'inquery pembelian part' => false,
                    'inquery pemasangan ban' => false,
                    'inquery pelepasan ban' => false,
                    'inquery pemasangan part' => false,
                    'inquery penggantian oli' => false,
                    'inquery perpanjangan stnk' => false,
                    'inquery perpanjangan kir' => false,
                    'inquery memo ekspedisi' => false,
                    'inquery faktur ekspedisi' => false,
                    'inquery invoice faktur ekspedisi' => false,
                    'inquery return ekspedisi' => false,
                    'inquery pelunasan ekspedisi' => false,
                    'inquery pelunasan faktur pembelian ban' => false,
                    'inquery pelunasan faktur pembelian part' => false,
                    'laporan pembelian ban' => false,
                    'laporan pembelian part' => false,
                    'laporan pemasangan ban' => false,
                    'laporan pelepasan ban' => false,
                    'laporan pemasangan part' => false,
                    'laporan penggantian oli' => false,
                    'laporan update km' => false,
                    'laporan kas kecil' => false,
                    'laporan mobil logistik' => false,
                    'laporan status perjalanan kendaraan' => false,
                    'laporan penerimaan kas kecil' => false,
                    'laporan pengambilan kas kecil' => false,
                    'laporan mobil logistik' => false,
                    'laporan deposit sopir' => false,
                    'laporan memo ekspedisi' => false,
                    'laporan faktur ekspedisi' => false,
                    'laporan pph' => false,
                    'laporan invoice ekspedisi' => false,
                    'laporan return barang ekspedisi' => false,
                    'laporan pelunasan ekspedisi' => false,
                    'laporan pelunasan pembelian ban' => false,
                    'laporan pelunasan pembelian part' => false,
                    'gaji karyawan' => false,
                    'perhitungan gaji' => false,
                    'inquery perhitungan gaji' => false,
                    'laporan perhitungan gaji' => false,
                    'kasbon karyawan' => false,
                    'inquery kasbon karyawan' => false,
                    'laporan kasbon karyawan' => false
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

                    // stnk
                    'stnk create' => false,
                    'stnk update' => false,
                    'stnk delete' => false,
                    'stnk show' => false,

                    // part
                    'part create' => false,
                    'part update' => false,
                    'part delete' => false,
                    'part show' => false,

                    // sopir
                    // 'sopir create',
                    'sopir update' => false,
                    // 'sopir delete',
                    // 'sopir show',

                    // merek   
                    'rute create' => false,
                    'rute update' => false,
                    'rute delete' => false,

                    // biaya tambahan   
                    'biaya tambahan create' => false,
                    'biaya tambahan update' => false,
                    'biaya tambahan delete' => false,

                    // potongan memo   
                    'potongan memo create' => false,
                    'potongan memo update' => false,
                    'potongan memo delete' => false,

                    // tarif   
                    'tarif create' => false,
                    'tarif update' => false,
                    'tarif delete' => false,

                    // satuan barang   
                    'satuan barang create' => false,
                    'satuan barang update' => false,
                    'satuan barang delete' => false,

                    // barang return   
                    'barang return create' => false,
                    'barang return update' => false,
                    'barang return delete' => false,

                    // perpanjangan stnk   
                    'perpanjangan stnk show' => false,
                    'perpanjangan stnk create' => false,

                    // perpanjangan kir   
                    'perpanjangan kir show' => false,
                    'perpanjangan kir create' => false,

                    // penggantian oli 
                    'penggantian oli create' => false,

                    // inquery penerimaan kas kecil   
                    'inquery penerimaan kas kecil posting' => false,
                    'inquery penerimaan kas kecil unpost' => false,
                    'inquery penerimaan kas kecil update' => false,
                    'inquery penerimaan kas kecil delete' => false,
                    'inquery penerimaan kas kecil show' => false,

                    'inquery pengambilan kas kecil posting' => false,
                    'inquery pengambilan kas kecil unpost' => false,
                    'inquery pengambilan kas kecil update' => false,
                    'inquery pengambilan kas kecil delete' => false,
                    'inquery pengambilan kas kecil show' => false,

                    // inquery deposit sopir   
                    'inquery deposit sopir posting' => false,
                    'inquery deposit sopir unpost' => false,
                    'inquery deposit sopir update' => false,
                    'inquery deposit sopir delete' => false,
                    'inquery deposit sopir show' => false,

                    // inquery update km   
                    'inquery update km posting' => false,
                    'inquery update km unpost' => false,
                    'inquery update km update' => false,
                    'inquery update km delete' => false,
                    'inquery update km show' => false,

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

                    // inquery memo perjalanan   
                    'inquery memo perjalanan posting' => false,
                    'inquery memo perjalanan unpost' => false,
                    'inquery memo perjalanan update' => false,
                    'inquery memo perjalanan delete' => false,
                    'inquery memo perjalanan show' => false,

                    // inquery memo borong   
                    'inquery memo borong posting' => false,
                    'inquery memo borong unpost' => false,
                    'inquery memo borong update' => false,
                    'inquery memo borong delete' => false,
                    'inquery memo borong show' => false,

                    // inquery memo tambahan   
                    'inquery memo tambahan posting' => false,
                    'inquery memo tambahan unpost' => false,
                    'inquery memo tambahan update' => false,
                    'inquery memo tambahan delete' => false,
                    'inquery memo tambahan show' => false,

                    // inquery faktur ekspedisi   
                    'inquery faktur ekspedisi posting' => false,
                    'inquery faktur ekspedisi unpost' => false,
                    'inquery faktur ekspedisi update' => false,
                    'inquery faktur ekspedisi delete' => false,
                    'inquery faktur ekspedisi show' => false,

                    // inquery invoice ekspedisi   
                    'inquery invoice ekspedisi posting' => false,
                    'inquery invoice ekspedisi unpost' => false,
                    'inquery invoice ekspedisi update' => false,
                    'inquery invoice ekspedisi delete' => false,
                    'inquery invoice ekspedisi show' => false,

                    // inquery return penerimaan barang    
                    'inquery return penerimaan barang posting' => false,
                    'inquery return penerimaan barang unpost' => false,
                    'inquery return penerimaan barang update' => false,
                    'inquery return penerimaan barang delete' => false,
                    'inquery return penerimaan barang show' => false,

                    // inquery return nota barang    
                    'inquery return nota barang posting' => false,
                    'inquery return nota barang unpost' => false,
                    'inquery return nota barang update' => false,
                    'inquery return nota barang delete' => false,
                    'inquery return nota barang show' => false,

                    // inquery return penjualan barang    
                    'inquery return penjualan barang posting' => false,
                    'inquery return penjualan barang unpost' => false,
                    'inquery return penjualan barang update' => false,
                    'inquery return penjualan barang delete' => false,
                    'inquery return penjualan barang show' => false,

                    // inquery pelunasan ekspedisi    
                    'inquery pelunasan ekspedisi posting' => false,
                    'inquery pelunasan ekspedisi unpost' => false,
                    'inquery pelunasan ekspedisi update' => false,
                    'inquery pelunasan ekspedisi delete' => false,
                    'inquery pelunasan ekspedisi show' => false,

                    // inquery pelunasan faktur pembelian ban    
                    'inquery pelunasan faktur pembelian ban posting' => false,
                    'inquery pelunasan faktur pembelian ban unpost' => false,
                    'inquery pelunasan faktur pembelian ban update' => false,
                    'inquery pelunasan faktur pembelian ban delete' => false,
                    'inquery pelunasan faktur pembelian ban show' => false,

                    // inquery pelunasan faktur pembelian part    
                    'inquery pelunasan faktur pembelian part posting' => false,
                    'inquery pelunasan faktur pembelian part unpost' => false,
                    'inquery pelunasan faktur pembelian part update' => false,
                    'inquery pelunasan faktur pembelian part delete' => false,
                    'inquery pelunasan faktur pembelian part show' => false,

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

                    // laporan pengambilan kas kecil 
                    'laporan pengambilan kas kecil cari' => false,
                    'laporan pengambilan kas kecil cetak' => false,

                    // laporan deposit sopir 
                    'laporan deposit sopir cari' => false,
                    'laporan deposit sopir cetak' => false,

                    // laporan memo perjalanan 
                    'laporan memo perjalanan cari' => false,
                    'laporan memo perjalanan cetak' => false,

                    // laporan memo borong 
                    'laporan memo borong cari' => false,
                    'laporan memo borong cetak' => false,

                    // laporan memo tambahan 
                    'laporan memo tambahan cari' => false,
                    'laporan memo tambahan cetak' => false,

                    // laporan faktur ekspedisi 
                    'laporan faktur ekspedisi cari' => false,
                    'laporan faktur ekspedisi cetak' => false,

                    // laporan pph 
                    'laporan pph cari' => false,
                    'laporan pph cetak' => false,

                    // laporan invoice ekspedisi 
                    'laporan invoice ekspedisi cari' => false,
                    'laporan invoice ekspedisi cetak' => false,

                    // laporan penerimaan return  ekspedisi 
                    'laporan penerimaan return cari' => false,
                    'laporan penerimaan return cetak' => false,

                    // laporan nota return 
                    'laporan nota return cari' => false,
                    'laporan nota return cetak' => false,

                    // laporan penjualan 
                    'laporan penjualan return cari' => false,
                    'laporan penjualan return cetak' => false,

                    // laporan pelunasan ekspedisi 
                    'laporan pelunasan ekspedisi cari' => false,
                    'laporan pelunasan ekspedisi cetak' => false,

                    // laporan pelunasan faktur pembelian ban 
                    'laporan pelunasan faktur pembelian ban cari' => false,
                    'laporan pelunasan faktur pembelian ban cetak' => false,

                    // laporan pelunasan faktur pembelian part 
                    'laporan pelunasan faktur pembelian part cari' => false,
                    'laporan pelunasan faktur pembelian part cetak' => false,

                    // gaji karyawan
                    'gaji karyawan update' => false,

                    // akun 
                    'create akun' => false,
                    'update akun' => false,
                    'delete akun' => false,

                    // memo ekspedisi 
                    'create memo ekspedisi' => false,
                    'update memo ekspedisi' => false,
                    'show memo ekspedisi' => false,
                    'delete memo ekspedisi' => false,
                    'posting memo ekspedisi' => false,
                    'unpost memo ekspedisi' => false,
                    'posting memo perjalanan continue' => false,
                    'posting memo borong continue' => false,
                    'posting memo tambahan continue' => false,

                    // faktur ekspedisi 
                    'creates faktur ekspedisi' => false,
                    'updates faktur ekspedisi' => false,
                    'shows faktur ekspedisi' => false,
                    'postings faktur ekspedisi' => false,
                    'unposts faktur ekspedisi' => false,
                    'deletes faktur ekspedisi' => false,

                    // invoice
                    "create invoice ekspedisi" => false,
                    "update invoice ekspedisi" => false,
                    "show invoice ekspedisi" => false,
                    "posting invoice ekspedisi" => false,
                    "unpost invoice ekspedisi" => false,
                    'delete invoice ekspedisi' => false,

                    // pelunasan ekspedisi
                    "create pelunasan faktur ekspedisi" => false,
                    "update pelunasan faktur ekspedisi" => false,
                    "show pelunasan faktur ekspedisi" => false,
                    "posting pelunasan faktur ekspedisi" => false,
                    "unpost pelunasan faktur ekspedisi" => false,
                    'delete pelunasan faktur ekspedisi' => false,

                    // pelunasan pembelian ban
                    "create pelunasan faktur pembelian ban" => false,
                    "update pelunasan faktur pembelian ban" => false,
                    "show pelunasan faktur pembelian ban" => false,
                    "posting pelunasan faktur pembelian ban" => false,
                    "unpost pelunasan faktur pembelian ban" => false,
                    'delete pelunasan faktur pembelian ban' => false,

                    // pelunasan pembelian part
                    "create pelunasan faktur pembelian part" => false,
                    "update pelunasan faktur pembelian part" => false,
                    "show pelunasan faktur pembelian part" => false,
                    "posting pelunasan faktur pembelian part" => false,
                    "unpost pelunasan faktur pembelian part" => false,
                    'delete pelunasan faktur pembelian part' => false,

                    // pelunasan pembelian part
                    "create pengambilan kas kecil" => false,
                    "update pengambilan kas kecil" => false,
                    "show pengambilan kas kecil" => false,
                    "posting pengambilan kas kecil" => false,
                    "unpost pengambilan kas kecil" => false,
                    'delete pengambilan kas kecil' => false,

                    // inquery perhitungan gaji mingguan    
                    'inquery perhitungan gaji mingguan posting' => false,
                    'inquery perhitungan gaji mingguan unpost' => false,
                    'inquery perhitungan gaji mingguan update' => false,
                    'inquery perhitungan gaji mingguan delete' => false,
                    'inquery perhitungan gaji mingguan show' => false,

                    // inquery perhitungan gaji bulanan    
                    'inquery perhitungan gaji bulanan posting' => false,
                    'inquery perhitungan gaji bulanan unpost' => false,
                    'inquery perhitungan gaji bulanan update' => false,
                    'inquery perhitungan gaji bulanan delete' => false,
                    'inquery perhitungan gaji bulanan show' => false,

                    // inquery kasbon karyawan    
                    'inquery kasbon karyawan posting' => false,
                    'inquery kasbon karyawan unpost' => false,
                    'inquery kasbon karyawan update' => false,
                    'inquery kasbon karyawan delete' => false,
                    'inquery kasbon karyawan show' => false,

                    // laporan perhitungan gaji 
                    'laporan perhitungan gaji cari' => false,
                    'laporan perhitungan gaji cetak' => false,

                    // laporan kasbon karyawan 
                    'laporan kasbon karyawan cari' => false,
                    'laporan kasbon karyawan cetak' => false,
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
        $lastBarang = User::latest()->first();
        if (!$lastBarang) {
            $num = 1;
        } else {
            $lastCode = $lastBarang->kode_user;
            $num = (int) substr($lastCode, strlen('AB')) + 1;
        }
        $formattedNum = sprintf("%06s", $num);
        $prefix = 'AB';
        $newCode = $prefix . $formattedNum;
        return $newCode;
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