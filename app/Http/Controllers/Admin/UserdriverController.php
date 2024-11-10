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

class UserdriverController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->check() && auth()->user()->menu['user']) {
            $query = User::where(['cek_hapus' => 'tidak'])
                ->with('karyawan')
                ->whereHas('karyawan', function ($query) {
                    $query->where('departemen_id', 2); // Menambahkan kondisi departemen_id 2
                });

            if ($request->has('keyword')) {
                $keyword = $request->keyword;
                $query->where(function ($query) use ($keyword) {
                    $query->whereHas('karyawan', function ($query) use ($keyword) {
                        $query->where('nama_lengkap', 'like', "%$keyword%");
                    })
                        ->orWhere('kode_user', 'like', "%$keyword%");
                });
            }

            $users = $query->paginate(10);

            return view('admin.userdriver.index', compact('users'));
        } else {
            return back()->with('error', 'Anda tidak memiliki akses');
        }
    }

    public function create()
    {
        if (auth()->check() && auth()->user()->menu['user']) {

            $karyawans = Karyawan::with('departemen')
                ->select('id', 'kode_karyawan')->where(['status' => 'null'])->get();
            return view('admin/userdriver.create', compact('karyawans'));
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
            return view('admin/userdriver.update', compact('user'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function access($id)
    {
        if (auth()->check() && auth()->user()->menu['user']) {

            $user = User::where('id', $id)->first();
            return view('admin/userdriver.access', compact('user'));
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

        User::create(array_merge(
            $request->all(),
            [
                'cek_hapus' => 'tidak',
                'kode_user' => $this->kode(),
                'qrcode_user' => "-",
                'password' => bcrypt('123456'),
                // 'level' => 'admin',
                'tanggal_awal' => Carbon::now('Asia/Jakarta'),
            ]
        ));

        $karyawan = Karyawan::findOrFail($request->karyawan_id);
        $karyawan->status = 'user';
        $karyawan->save();

        return redirect('admin/userdriver')->with('success', 'Berhasil mengubah User');
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
        // Cari karyawan terakhir dengan kode_karyawan yang diawali dengan 'AA'
        $lastBarang = User::where('kode_user', 'like', 'AB%')->latest()->first();
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
            'menu' => [
                'kendaraan' => $kendaraan,
                'pelanggan' => $pelanggan
            ]
        ]);

        return redirect('admin/userdriver')->with('success', 'Berhasil menambah Akses');
    }

    public function destroy($id)
    {

        $user = User::find($id);
        Karyawan::where('id', $user->karyawan_id)->update([
            'status' => 'null',
        ]);
        $user->delete();

        LogAktivitas::where('user_id', $id)->update(['user_id' => null]);


        return redirect('admin/userdriver')->with('success', 'Berhasil menghapus user');
    }
}