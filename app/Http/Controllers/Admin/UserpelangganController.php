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
use Illuminate\Support\Facades\Validator;

class UserpelangganController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->check() && auth()->user()->menu['user']) {

            // $this->storeAllPelanggan();

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

            return view('admin.userpelanggan.index', compact('pelanggans'));
        } else {
            return back()->with('error', 'Anda tidak memiliki akses');
        }
    }


    public function create()
    {
        if (auth()->check() && auth()->user()->menu['user']) {
            // Menampilkan hanya pelanggan yang belum memiliki relasi dengan user
            $karyawans = Pelanggan::select('id', 'kode_pelanggan', 'nama_pell', 'telp', 'alamat')
                ->whereNotIn('id', User::whereNotNull('pelanggan_id')->pluck('pelanggan_id'))
                ->get();

            return view('admin/userpelanggan.create', compact('karyawans'));
        } else {
            // tidak memiliki akses
            return back()->with('error', 'Anda tidak memiliki akses');
        }
    }


    public function pelanggan($id)
    {
        $user = Pelanggan::where('id', $id)->first();

        return json_decode($user);
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
    //     $pelanggan = Pelanggan::where('id', $pelanggan_id)->first();

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

    //     return redirect('admin/userpelanggan')->with('success', 'Berhasil menambah User');
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
    //     $pelanggan = Pelanggan::where('id', $pelanggan_id)->first();

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

    //     return redirect('admin/userpelanggan')->with('success', 'Berhasil menambah User');
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
    //     $pelanggan = Pelanggan::where('id', $pelanggan_id)->first();

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

    //     return redirect('admin/userpelanggan')->with('success', 'Berhasil menambah User');
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
        $pelanggan = Pelanggan::where('id', $pelanggan_id)->first();

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
                    'level' => 'pelanggan',
                    'password' => bcrypt('123456'),
                    'tanggal_awal' => Carbon::now('Asia/Jakarta'),
                    'detail_pelanggan_id' => $detailPelanggan->id, // Menambahkan detail_pelanggan_id ke user
                ]
            ));
        }

        return redirect('admin/userpelanggan')->with('success', 'Berhasil menambah User');
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

    public function storeAllPelanggan()
    {
        // Ambil semua pelanggan
        $allPelanggan = Pelanggan::all();

        // Loop melalui setiap pelanggan untuk membuat User yang terkait
        foreach ($allPelanggan as $pelanggan) {
            // Mengambil daftar detail pelanggan yang terkait dengan pelanggan_id
            $detailPelangganList = Detail_pelanggan::where('pelanggan_id', $pelanggan->id)->get();

            // Tentukan nomor dasar (angka) untuk kode user berdasarkan data terakhir
            $baseCodeNumber = $this->generateBaseCodeNumber();

            // Loop untuk membuat user berdasarkan jumlah detail pelanggan
            foreach ($detailPelangganList as $index => $detailPelanggan) {
                // Generate kode user untuk setiap iterasi
                $kode_user = $this->kode($baseCodeNumber, $index);

                // Membuat User baru untuk setiap kode yang dihasilkan
                User::create([
                    'pelanggan_id' => $pelanggan->id,
                    'cek_hapus' => 'tidak',
                    'kode_user' => $kode_user,
                    'qrcode_user' => "-",
                    'level' => 'pelanggan',
                    'password' => bcrypt('123456'),
                    'tanggal_awal' => Carbon::now('Asia/Jakarta'),
                    'detail_pelanggan_id' => $detailPelanggan->id, // Menambahkan detail_pelanggan_id ke user
                ]);
            }
        }

        return redirect('admin/userpelanggan')->with('success', 'Berhasil menambah User untuk semua pelanggan');
    }

    public function edit($id)
    {
        if (auth()->check() && auth()->user()->menu['user']) {

            $user = Pelanggan::where('id', $id)->first();
            $karyawans = Pelanggan::select('id', 'kode_pelanggan', 'nama_pell', 'telp', 'alamat')
                ->whereNotIn('id', User::whereNotNull('pelanggan_id')->pluck('pelanggan_id'))
                ->get();

            // Contoh memanggil ID pelanggan di sini
            $pelanggan_id = $user->id; // ID pelanggan yang dipanggil

            return view('admin/userpelanggan.update', compact('user', 'karyawans', 'pelanggan_id'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }


    public function update(Request $request, $id)
    {
        // Ambil data Pelanggan berdasarkan id pelanggan yang diberikan
        $pelanggan = Pelanggan::findOrFail($id);

        // Ambil daftar User yang sudah ada berdasarkan id pelanggan
        $existingUsers = User::where('pelanggan_id', $id)->get();

        // Mengambil daftar detail pelanggan yang belum memiliki User terkait
        $detailPelangganList = Detail_pelanggan::where('pelanggan_id', $id)
            ->whereNotIn('id', $existingUsers->pluck('detail_pelanggan_id'))
            ->get();

        // Mendapatkan angka dasar kode user dari user terakhir yang sudah ada
        $lastUser = $existingUsers->sortByDesc('kode_user')->first();
        $baseCodeNumber = $this->getBaseCodeNumberFromLastUser($lastUser);

        // Tentukan indeks huruf terakhir yang digunakan jika ada
        if ($lastUser) {
            $lastSuffix = substr($lastUser->kode_user, -1);
            $detailIndex = ord($lastSuffix) - 65 + 1; // Mengonversi huruf ke indeks numerik (A=0, B=1, dst.)
        } else {
            $detailIndex = 0; // Mulai dari indeks awal jika tidak ada user
        }

        // Loop untuk setiap detail pelanggan baru
        foreach ($detailPelangganList as $index => $detailPelanggan) {
            // Buat kode user baru dengan huruf akhiran berdasarkan indeks
            $kode_user = $this->kode($baseCodeNumber, $detailIndex);

            // Membuat User baru untuk setiap detail pelanggan baru
            User::create([
                'pelanggan_id' => $id,
                'cek_hapus' => 'tidak',
                'kode_user' => $kode_user,
                'level' => 'pelanggan',
                'qrcode_user' => "-",
                'password' => bcrypt('123456'),
                'tanggal_awal' => Carbon::now('Asia/Jakarta'),
                'detail_pelanggan_id' => $detailPelanggan->id,
            ]);

            $detailIndex++; // Tingkatkan indeks untuk huruf akhiran berikutnya
        }

        return redirect('admin/userpelanggan')->with('success', 'Data user berhasil diperbarui.');
    }

    // Fungsi untuk mendapatkan angka dasar dari kode terakhir yang ada
    public function getBaseCodeNumberFromLastUser($lastUser)
    {
        if ($lastUser) {
            // Ambil angka dasar dari kode terakhir yang ada
            $lastCode = substr($lastUser->kode_user, 2, 5); // Ambil angka 5 digit setelah 'BD'
        } else {
            // Jika tidak ada user sebelumnya, mulai dari 1
            $lastCode = "00001";
        }

        return $lastCode;
    }

    public function destroy($id)
    {
        // Temukan pelanggan berdasarkan ID
        $pelanggan = Pelanggan::find($id);

        // Hapus semua User yang terkait dengan pelanggan ini
        User::where('pelanggan_id', $pelanggan->id)->delete();

        // Kembali ke halaman dengan pesan sukses tanpa menghapus pelanggan
        return redirect('admin/userpelanggan')->with('success', 'Berhasil menghapus semua user yang terkait dengan pelanggan.');
    }
}