<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\User;
use App\Models\Karyawan;
use App\Models\Departemen;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Detail_pelanggan;
use App\Models\LogAktivitas;
use App\Models\Pelanggan;
use App\Models\Supplier;
use Illuminate\Support\Facades\Validator;

class UsersupplierController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->check() && auth()->user()->menu['user']) {
            if ($request->has('keyword')) {
                $keyword = $request->keyword;

                // Mengambil data pelanggan yang memiliki relasi dengan user dan nama_pell yang sesuai dengan keyword
                $pelanggans = Pelanggan::where('nama_pell', 'like', "%$keyword%")
                ->whereHas('user') // Pastikan relasi dengan user ada
                    ->paginate(10);
            } else {
                // Mengambil semua pelanggan yang memiliki relasi dengan user jika tidak ada keyword
                $pelanggans = Pelanggan::whereHas('user')->paginate(10);
            }

            return view('admin.usersupplier.index', compact('pelanggans'));
        } else {
            return back()->with('error', 'Anda tidak memiliki akses');
        }
    }


    public function create()
    {
        if (auth()->check() && auth()->user()->menu['user']) {
            // Menampilkan hanya pelanggan yang belum memiliki relasi dengan user
            $karyawans = Supplier::select('id', 'kode_pelanggan', 'nama_pell', 'telp', 'alamat')
                ->whereNotIn('id', User::whereNotNull('pelanggan_id')->pluck('pelanggan_id'))
                ->get();

            return view('admin/usersupplier.create', compact('karyawans'));
        } else {
            // tidak memiliki akses
            return back()->with('error', 'Anda tidak memiliki akses');
        }
    }


    public function pelanggan($id)
    {
        $user = Supplier::where('id', $id)->first();

        return json_decode($user);
    }

    public function edit($id)
    {
        if (auth()->check() && auth()->user()->menu['user']) {

            $user = User::where('id', $id)->first();
            return view('admin/usersupplier.update', compact('user'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function access($id)
    {
        if (auth()->check() && auth()->user()->menu['user']) {

            $user = User::where('id', $id)->first();
            return view('admin/usersupplier.access', compact('user'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    // create user sudah benar namun tanpa relasi ke detail 
    // public function store(Request $request)
    // {
    //     $validator = Validator::make(
    //         $request->all(),
    //         [
    //             'pelanggan_id' => 'required',
    //         ],
    //         [
    //             'pelanggan_id.required' => 'Pilih kode pelanggan',
    //         ]
    //     );

    //     if ($validator->fails()) {
    //         $errors = $validator->errors()->all();
    //         return back()->withInput()->with('error', $errors);
    //     }

    //     $pelanggan_id = $request->pelanggan_id;
    //     $pelanggan = Supplier::where('id', $pelanggan_id)->first();

    //     // Menghitung jumlah detail pelanggan yang ada
    //     $detailCount = Detail_pelanggan::where('pelanggan_id', $pelanggan_id)->count();

    //     // Tentukan nomor dasar (angka) untuk kode user berdasarkan data terakhir
    //     $baseCodeNumber = $this->generateBaseCodeNumber();

    //     // Loop untuk membuat user berdasarkan jumlah detail + 1
    //     for ($i = 0; $i <= $detailCount; $i++) {
    //         // Generate kode user untuk setiap iterasi
    //         $kode_user = $this->kode($baseCodeNumber, $i);

    //         // Membuat User baru untuk setiap kode yang dihasilkan
    //         User::create(array_merge(
    //             $request->all(),
    //             [
    //                 'cek_hapus' => 'tidak',
    //                 'kode_user' => $kode_user,
    //                 'qrcode_user' => "-",
    //                 'password' => bcrypt('123456'),
    //                 'tanggal_awal' => Carbon::now('Asia/Jakarta'),
    //             ]
    //         ));
    //     }

    //     return redirect('admin/usersupplier')->with('success', 'Berhasil menambah User');
    // }

    // // Fungsi untuk menentukan nomor dasar kode user
    // public function generateBaseCodeNumber()
    // {
    //     // Mencari kode terakhir yang diawali dengan 'BD'
    //     $lastUser = User::where('kode_user', 'like', 'BD%')->orderBy('kode_user', 'desc')->first();

    //     if ($lastUser) {
    //         $lastCode = substr($lastUser->kode_user, 2, 5); // Ambil angka 5 digit setelah 'BD'
    //         $num = (int)$lastCode + 1;
    //     } else {
    //         $num = 1;
    //     }

    //     return sprintf("%05d", $num); // Format nomor menjadi 5 digit
    // }

    // public function kode($baseCodeNumber, $detailIndex)
    // {
    //     // Menentukan akhiran huruf berdasarkan indeks detail pelanggan
    //     $suffix = chr(65 + $detailIndex); // 65 adalah kode ASCII untuk 'A'

    //     // Membentuk kode baru dengan nomor dasar yang tetap dan huruf akhiran
    //     $prefix = 'BD';
    //     $newCode = $prefix . $baseCodeNumber . $suffix;

    //     return $newCode;
    // }



    // jika ada relasi ke detail  
    // public function store(Request $request)
    // {
    //     $validator = Validator::make(
    //         $request->all(),
    //         [
    //             'pelanggan_id' => 'required',
    //         ],
    //         [
    //             'pelanggan_id.required' => 'Pilih kode pelanggan',
    //         ]
    //     );

    //     if ($validator->fails()) {
    //         $errors = $validator->errors()->all();
    //         return back()->withInput()->with('error', $errors);
    //     }

    //     $pelanggan_id = $request->pelanggan_id;
    //     $pelanggan = Supplier::where('id', $pelanggan_id)->first();

    //     // Mengambil semua detail pelanggan yang terkait
    //     $detailPelangganList = Detail_pelanggan::where('pelanggan_id', $pelanggan_id)->get();

    //     // Tentukan nomor dasar (angka) untuk kode user berdasarkan data terakhir
    //     $baseCodeNumber = $this->generateBaseCodeNumber();

    //     // Loop untuk membuat user berdasarkan jumlah detail + 1
    //     for ($i = 0; $i <= $detailPelangganList->count(); $i++) {
    //         // Generate kode user untuk setiap iterasi
    //         $kode_user = $this->kode($baseCodeNumber, $i);

    //         // Dapatkan detail_pelanggan_id jika ada di dalam list
    //         $detail_pelanggan_id = $detailPelangganList[$i]->id ?? null;

    //         // Membuat User baru untuk setiap kode yang dihasilkan
    //         User::create(array_merge(
    //             $request->all(),
    //             [
    //                 'cek_hapus' => 'tidak',
    //                 'kode_user' => $kode_user,
    //                 'qrcode_user' => "-",
    //                 'password' => bcrypt('123456'),
    //                 'tanggal_awal' => Carbon::now('Asia/Jakarta'),
    //                 'detail_pelanggan_id' => $detail_pelanggan_id, // Set detail_pelanggan_id
    //             ]
    //         ));
    //     }

    //     return redirect('admin/usersupplier')->with('success', 'Berhasil menambah User');
    // }

    // // Fungsi untuk menentukan nomor dasar kode user
    // public function generateBaseCodeNumber()
    // {
    //     // Mencari kode terakhir yang diawali dengan 'BD'
    //     $lastUser = User::where('kode_user', 'like', 'BD%')->orderBy('kode_user', 'desc')->first();

    //     if ($lastUser) {
    //         $lastCode = substr($lastUser->kode_user, 2, 5); // Ambil angka 5 digit setelah 'BD'
    //         $num = (int)$lastCode + 1;
    //     } else {
    //         $num = 1;
    //     }

    //     return sprintf("%05d", $num); // Format nomor menjadi 5 digit
    // }

    // public function kode($baseCodeNumber, $detailIndex)
    // {
    //     // Menentukan akhiran huruf berdasarkan indeks detail pelanggan
    //     $suffix = chr(65 + $detailIndex); // 65 adalah kode ASCII untuk 'A'

    //     // Membentuk kode baru dengan nomor dasar yang tetap dan huruf akhiran
    //     $prefix = 'BD';
    //     $newCode = $prefix . $baseCodeNumber . $suffix;

    //     return $newCode;
    // }



    // public function store(Request $request)
    // {
    //     $validator = Validator::make(
    //         $request->all(),
    //         [
    //             'pelanggan_id' => 'required',
    //         ],
    //         [
    //             'pelanggan_id.required' => 'Pilih kode pelanggan',
    //         ]
    //     );

    //     if ($validator->fails()) {
    //         $errors = $validator->errors()->all();
    //         return back()->withInput()->with('error', $errors);
    //     }

    //     $pelanggan_id = $request->pelanggan_id;
    //     $pelanggan = Supplier::where('id', $pelanggan_id)->first();

    //     // Menghitung jumlah detail pelanggan yang ada
    //     $detailCount = Detail_pelanggan::where('pelanggan_id', $pelanggan_id)->count();

    //     // Tentukan nomor dasar (angka) untuk kode user berdasarkan data terakhir
    //     $baseCodeNumber = $this->generateBaseCodeNumber();

    //     // Loop untuk membuat user berdasarkan jumlah detail pelanggan
    //     for ($i = 0; $i < $detailCount; $i++) {  // Ganti <= dengan < agar hanya sebanyak detailCount
    //         // Generate kode user untuk setiap iterasi
    //         $kode_user = $this->kode($baseCodeNumber, $i);

    //         // Membuat User baru untuk setiap kode yang dihasilkan
    //         User::create(array_merge(
    //             $request->all(),
    //             [
    //                 'cek_hapus' => 'tidak',
    //                 'kode_user' => $kode_user,
    //                 'qrcode_user' => "-",
    //                 'password' => bcrypt('123456'),
    //                 'tanggal_awal' => Carbon::now('Asia/Jakarta'),
    //             ]
    //         ));
    //     }

    //     return redirect('admin/usersupplier')->with('success', 'Berhasil menambah User');
    // }

    // // Fungsi untuk menentukan nomor dasar kode user
    // public function generateBaseCodeNumber()
    // {
    //     // Mencari kode terakhir yang diawali dengan 'BD'
    //     $lastUser = User::where('kode_user', 'like', 'BD%')->orderBy('kode_user', 'desc')->first();

    //     if ($lastUser) {
    //         $lastCode = substr($lastUser->kode_user, 2, 5); // Ambil angka 5 digit setelah 'BD'
    //         $num = (int)$lastCode + 1;
    //     } else {
    //         $num = 1;
    //     }

    //     return sprintf("%05d", $num); // Format nomor menjadi 5 digit
    // }

    // public function kode($baseCodeNumber, $detailIndex)
    // {
    //     // Menentukan akhiran huruf berdasarkan indeks detail pelanggan
    //     $suffix = chr(65 + $detailIndex); // 65 adalah kode ASCII untuk 'A'

    //     // Membentuk kode baru dengan nomor dasar yang tetap dan huruf akhiran
    //     $prefix = 'BD';
    //     $newCode = $prefix . $baseCodeNumber . $suffix;

    //     return $newCode;
    // }



    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'pelanggan_id' => 'required',
            ],
            [
                'pelanggan_id.required' => 'Pilih kode pelanggan',
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }

        $pelanggan_id = $request->pelanggan_id;
        $pelanggan = Supplier::where('id', $pelanggan_id)->first();

        // Mengambil daftar detail pelanggan yang terkait dengan pelanggan_id
        $detailPelangganList = Detail_pelanggan::where('pelanggan_id', $pelanggan_id)->get();

        // Tentukan nomor dasar (angka) untuk kode user berdasarkan data terakhir
        $baseCodeNumber = $this->generateBaseCodeNumber();

        // Loop untuk membuat user berdasarkan jumlah detail pelanggan
        foreach ($detailPelangganList as $index => $detailPelanggan) {
            // Generate kode user untuk setiap iterasi
            $kode_user = $this->kode($baseCodeNumber, $index);

            // Membuat User baru untuk setiap kode yang dihasilkan
            User::create(array_merge(
                $request->all(),
                [
                    'cek_hapus' => 'tidak',
                    'kode_user' => $kode_user,
                    'qrcode_user' => "-",
                    'password' => bcrypt('123456'),
                    'tanggal_awal' => Carbon::now('Asia/Jakarta'),
                    'detail_pelanggan_id' => $detailPelanggan->id, // Menambahkan detail_pelanggan_id ke user
                ]
            ));
        }

        return redirect('admin/usersupplier')->with('success', 'Berhasil menambah User');
    }

    // Fungsi untuk menentukan nomor dasar kode user
    public function generateBaseCodeNumber()
    {
        // Mencari kode terakhir yang diawali dengan 'BD'
        $lastUser = User::where('kode_user', 'like', 'BD%')->orderBy('kode_user', 'desc')->first();

        if ($lastUser) {
            $lastCode = substr($lastUser->kode_user, 2, 5); // Ambil angka 5 digit setelah 'BD'
            $num = (int)$lastCode + 1;
        } else {
            $num = 1;
        }

        return sprintf("%05d", $num); // Format nomor menjadi 5 digit
    }

    public function kode($baseCodeNumber, $detailIndex)
    {
        // Menentukan akhiran huruf berdasarkan indeks detail pelanggan
        $suffix = chr(65 + $detailIndex); // 65 adalah kode ASCII untuk 'A'

        // Membentuk kode baru dengan nomor dasar yang tetap dan huruf akhiran
        $prefix = 'BD';
        $newCode = $prefix . $baseCodeNumber . $suffix;

        return $newCode;
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


    public function destroy($id)
    {
        // Temukan pelanggan berdasarkan ID
        $pelanggan = Supplier::find($id);

        // Hapus semua User yang terkait dengan pelanggan ini
        User::where('pelanggan_id', $pelanggan->id)->delete();

        // Kembali ke halaman dengan pesan sukses tanpa menghapus pelanggan
        return redirect('admin/usersupplier')->with('success', 'Berhasil menghapus semua user yang terkait dengan pelanggan.');
    }
}