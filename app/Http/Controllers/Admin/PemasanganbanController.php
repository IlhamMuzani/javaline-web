<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;
use App\Models\Ban;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use App\Models\Pemasangan_ban;
use App\Http\Controllers\Controller;
use App\Models\Detail_ban;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PemasanganbanController extends Controller
{
    public function index()
    {
        if (auth()->check() && auth()->user()->menu['pemasangan ban']) {
            $pemasangan_bans = Pemasangan_ban::all();

            $kendaraans = Kendaraan::get();
            return view('admin.pemasangan_ban.index', compact('pemasangan_bans', 'kendaraans'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function edit($id)
    {
        // $kendaraan = Kendaraan::find($id);
        $kendaraan = Kendaraan::where('id', $id)->first();
        $bans = Ban::where(['status' => 'stok'])->get();

        $tabelbans = Ban::where(['kendaraan_id' => $kendaraan->id, 'status' => 'aktif sementara'])->get();

        return view('admin/pemasangan_ban.create', compact('bans', 'kendaraan', 'tabelbans'));
    }

    public function store(Request $request)
    {
        $kendaraan_id = $request->kendaraan_id;

        Ban::where(['kendaraan_id' => $kendaraan_id, 'status' => 'aktif sementara'])->update([
            'status' => 'stok',
        ]);

        return redirect('admin/pemasangan_ban/' . $kendaraan_id . '/edit');
    }

    public function kode()
    {
        // Ambil kode memo terakhir yang sesuai format 'OB%' dan kategori 'Memo Perjalanan'
        $lastBarang = Pemasangan_ban::where('kode_pemasangan', 'like', 'OB%')
            ->orderBy('id', 'desc')
            ->first();

        // Inisialisasi nomor urut
        $num = 1;

        // Jika ada kode terakhir, proses untuk mendapatkan nomor urut
        if ($lastBarang) {
            $lastCode = $lastBarang->kode_pemasangan;

            // Pastikan kode terakhir sesuai dengan format OB[YYYYMMDD][NNNN]A
            if (preg_match('/^OB(\d{6})(\d{4})A$/', $lastCode, $matches)) {
                $lastDate = $matches[1]; // Bagian tanggal: ymd (contoh: 241125)
                $lastMonth = substr($lastDate, 2, 2); // Ambil bulan dari tanggal (contoh: 11)
                $currentMonth = date('m'); // Bulan saat ini

                if ($lastMonth === $currentMonth) {
                    // Jika bulan sama, tambahkan nomor urut
                    $lastNum = (int)$matches[2]; // Bagian nomor urut (contoh: 0001)
                    $num = $lastNum + 1;
                }
            }
        }

        // Formatkan nomor urut menjadi 4 digit
        $formattedNum = sprintf("%04s", $num);

        // Buat kode baru dengan tambahan huruf A di belakang
        $prefix = 'OB';
        $kodeMemo = $prefix . date('ymd') . $formattedNum . 'A'; // Format akhir kode memo

        return $kodeMemo;
    }

    public function kendaraan($id)
    {
        $jenis_kendaraan = Kendaraan::where('id', $id)->with('jenis_kendaraan')->first();

        return json_decode($jenis_kendaraan);
    }

    public function show($id)
    {
        $pemasangan_ban = Pemasangan_ban::findOrFail($id);

        $kendaraan_id = $pemasangan_ban->kendaraan_id;

        $kendaraan = Kendaraan::findOrFail($kendaraan_id);

        $bans = Detail_ban::where('kendaraan_id', $kendaraan_id)->get();

        return view('admin.pemasangan_ban.show', compact('bans', 'kendaraan'));
    }

    public function cetakpdf($id)
    {
        $pasang_ban = Pemasangan_ban::where('id', $id)->first();
        $pemasangan_ban = Pemasangan_ban::findOrFail($id);
        $kendaraan_id = $pemasangan_ban->kendaraan_id;
        $kendaraan = Kendaraan::findOrFail($kendaraan_id);
        $bans = Detail_ban::where('pemasangan_ban_id', $id)->get();

        $pdf = PDF::loadView('admin/pemasangan_ban.cetak_pdf', compact('bans', 'kendaraan', 'pasang_ban'));
        $pdf->setPaper('letter', 'portrait');

        return $pdf->stream('Laporan_Pemasangan_Ban.pdf');
    }

    public function destroy($id)
    {
        $ban = Ban::find($id);

        if (!$ban) {
            return redirect()->back()->with('error', 'Data ban tidak ditemukan');
        }

        // $detail_ban = Detail_ban::where('ban_id', $id)->first();
        // if ($detail_ban) {
        //     // Hapus deposit_driver
        //     $detail_ban->delete();
        // }

        if ($ban) {
            $ban->update([
                'kendaraan_id' => null,
                'status' => 'stok'
            ]);

            return redirect()->back()->with('success', 'Berhasil menghapus pemasangan ban');
        }

        return redirect()->back()->with('error', 'Data ban tidak ditemukan');
    }

    public function update(Request $request, $id)
    {
        $kendaraans = Kendaraan::findOrFail($id);
        Kendaraan::where('id', $id)->update([
            'status_pemasangan' => 'pemasangan',
        ]);

        // tgl indo
        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');

        // tgl filter
        $tanggal = Carbon::now()->format('Y-m-d');
        $pemasangan_ban = Pemasangan_ban::create([
            'user_id' => auth()->user()->id,
            'kode_pemasangan' => $this->kode(),
            'kendaraan_id' => $kendaraans->id,
            'tanggal' => $format_tanggal,
            'tanggal_awal' => $tanggal,
            'status' => 'posting',
            'status_notif' => false,
        ]);
        $pemasanganId = $pemasangan_ban->id;

        // Update status ban dan pemasangan_ban_id
        $bans = Ban::where([
            ['kendaraan_id', $id],
            ['status', 'aktif sementara']
        ])->get();

        foreach ($bans as $ban) {
            $ban->update([
                'status' => 'aktif',
                'umur_ban' => null,
                'pemasangan_ban_id' => $pemasanganId
            ]);

            // Duplicate ban to Detail_ban
            $detailBanData = $ban->toArray();
            $detailBanData['ban_id'] = $ban->id;
            $detailBanData['pelepasan_ban_id'] = null; // Set pelepasan_ban to null

            Detail_ban::create($detailBanData);
        }

        $kendaraan = Kendaraan::findOrFail($id);
        $bans = Detail_ban::where('pemasangan_ban_id', $pemasanganId)->get();

        return view('admin.pemasangan_ban.show', compact('bans', 'kendaraan', 'pemasangan_ban'));
    }



    public function update_1a(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'exel_1a' => 'required',
                'km_pemasangan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pemasangan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'exel_1a.required' => 'Pilih Ban',
                'km_pemasangan.required' => 'Masukkan km pemasangan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
        $kendaraan->update([
            'km' => $request->km_pemasangan
        ]);

        $kendaraan = Kendaraan::findOrFail($id);
        $ban = Ban::findOrFail($request->exel_1a);
        // $jumlahkmpemasangan = $request->km_pemasangan - $ban->km_pemasangan;
        $ban->update([
            // 'jumlah_km' => $jumlahkmpemasangan,
            'km_pemasangan' => $request->km_pemasangan,
            'posisi_ban' => $request->posisi_1a,
            'status' => 'aktif sementara',
            'kendaraan_id' => $kendaraan->id,
        ]);

        // $detailBanData = $ban->toArray();
        // $detailBanData['ban_id'] = $ban->id;

        // Detail_ban::create($detailBanData);

        return redirect()->back()->with('success', 'Berhasil menambahkan Pemasangan ban pada posisi Axle 1A');
    }

    public function update_1b(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'exel_1b' => 'required',
                'km_pemasangan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pemasangan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'exel_1b.required' => 'Pilih Ban',
                'km_pemasangan.required' => 'Masukkan km pemasangan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
        $kendaraan->update([
            'km' => $request->km_pemasangan
        ]);

        $kendaraan = Kendaraan::findOrFail($id);
        $ban = Ban::findOrFail($request->exel_1b);
        // $jumlahkmpemasangan = $request->km_pemasangan - $ban->km_pemasangan;
        $ban->update([
            // 'jumlah_km' => $jumlahkmpemasangan,
            'km_pemasangan' => $request->km_pemasangan,
            'posisi_ban' => $request->posisi_1b,
            'status' => 'aktif sementara',
            'kendaraan_id' => $kendaraan->id,
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan Pemasangan ban pada posisi Axle 1B');
    }

    public function update_2a(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'exel_2a' => 'required',
                'km_pemasangan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pemasangan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'exel_2a.required' => 'Pilih Ban',
                'km_pemasangan.required' => 'Masukkan km pemasangan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
        $kendaraan->update([
            'km' => $request->km_pemasangan
        ]);

        $kendaraan = Kendaraan::findOrFail($id);
        $ban = Ban::findOrFail($request->exel_2a);
        // $jumlahkmpemasangan = $request->km_pemasangan - $ban->km_pemasangan;
        $ban->update([
            // 'jumlah_km' => $jumlahkmpemasangan,
            'km_pemasangan' => $request->km_pemasangan,
            'posisi_ban' => $request->posisi_2a,
            'status' => 'aktif sementara',
            'kendaraan_id' => $kendaraan->id,
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan Pemasangan ban pada posisi Axle 2A');
    }

    public function update_2b(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'exel_2b' => 'required',
                'km_pemasangan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pemasangan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'exel_2b.required' => 'Pilih Ban',
                'km_pemasangan.required' => 'Masukkan km pemasangan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
        $kendaraan->update([
            'km' => $request->km_pemasangan
        ]);

        $kendaraan = Kendaraan::findOrFail($id);
        $ban = Ban::findOrFail($request->exel_2b);
        // $jumlahkmpemasangan = $request->km_pemasangan - $ban->km_pemasangan;
        $ban->update([
            // 'jumlah_km' => $jumlahkmpemasangan,
            'km_pemasangan' => $request->km_pemasangan,
            'posisi_ban' => $request->posisi_2b,
            'status' => 'aktif sementara',
            'kendaraan_id' => $kendaraan->id,
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan Pemasangan ban pada posisi Axle 2B');
    }

    public function update_2c(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'exel_2c' => 'required',
                'km_pemasangan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pemasangan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'exel_2c.required' => 'Pilih Ban',
                'km_pemasangan.required' => 'Masukkan km pemasangan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
        $kendaraan->update([
            'km' => $request->km_pemasangan
        ]);

        $kendaraan = Kendaraan::findOrFail($id);
        $ban = Ban::findOrFail($request->exel_2c);
        // $jumlahkmpemasangan = $request->km_pemasangan - $ban->km_pemasangan;
        $ban->update([
            // 'jumlah_km' => $jumlahkmpemasangan,
            'km_pemasangan' => $request->km_pemasangan,
            'posisi_ban' => $request->posisi_2c,
            'status' => 'aktif sementara',
            'kendaraan_id' => $kendaraan->id,
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan Pemasangan ban pada posisi Axle 2C');
    }

    public function update_2d(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'exel_2d' => 'required',
                'km_pemasangan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pemasangan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'exel_2d.required' => 'Pilih Ban',
                'km_pemasangan.required' => 'Masukkan km pemasangan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
        $kendaraan->update([
            'km' => $request->km_pemasangan
        ]);

        $kendaraan = Kendaraan::findOrFail($id);
        $ban = Ban::findOrFail($request->exel_2d);
        // $jumlahkmpemasangan = $request->km_pemasangan - $ban->km_pemasangan;
        $ban->update([
            // 'jumlah_km' => $jumlahkmpemasangan,
            'km_pemasangan' => $request->km_pemasangan,
            'posisi_ban' => $request->posisi_2d,
            'status' => 'aktif sementara',
            'kendaraan_id' => $kendaraan->id,
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan Pemasangan ban pada posisi Axle 2D');
    }

    public function update_3a(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'exel_3a' => 'required',
                'km_pemasangan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pemasangan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'exel_3a.required' => 'Pilih Ban',
                'km_pemasangan.required' => 'Masukkan km pemasangan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
        $kendaraan->update([
            'km' => $request->km_pemasangan
        ]);

        $kendaraan = Kendaraan::findOrFail($id);
        $ban = Ban::findOrFail($request->exel_3a);
        // $jumlahkmpemasangan = $request->km_pemasangan - $ban->km_pemasangan;
        $ban->update([
            // 'jumlah_km' => $jumlahkmpemasangan,
            'km_pemasangan' => $request->km_pemasangan,
            'posisi_ban' => $request->posisi_3a,
            'status' => 'aktif sementara',
            'kendaraan_id' => $kendaraan->id,
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan Pemasangan ban pada posisi Axle 3A');
    }

    public function update_3b(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'exel_3b' => 'required',
                'km_pemasangan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pemasangan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'exel_3b.required' => 'Pilih Ban',
                'km_pemasangan.required' => 'Masukkan km pemasangan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
        $kendaraan->update([
            'km' => $request->km_pemasangan
        ]);

        $kendaraan = Kendaraan::findOrFail($id);
        $ban = Ban::findOrFail($request->exel_3b);
        // $jumlahkmpemasangan = $request->km_pemasangan - $ban->km_pemasangan;
        $ban->update([
            // 'jumlah_km' => $jumlahkmpemasangan,
            'km_pemasangan' => $request->km_pemasangan,
            'posisi_ban' => $request->posisi_3b,
            'status' => 'aktif sementara',
            'kendaraan_id' => $kendaraan->id,
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan Pemasangan ban pada posisi Axle 3B');
    }

    public function update_3c(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'exel_3c' => 'required',
                'km_pemasangan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pemasangan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'exel_3c.required' => 'Pilih Ban',
                'km_pemasangan.required' => 'Masukkan km pemasangan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
        $kendaraan->update([
            'km' => $request->km_pemasangan
        ]);

        $kendaraan = Kendaraan::findOrFail($id);
        $ban = Ban::findOrFail($request->exel_3c);
        // $jumlahkmpemasangan = $request->km_pemasangan - $ban->km_pemasangan;
        $ban->update([
            // 'jumlah_km' => $jumlahkmpemasangan,
            'km_pemasangan' => $request->km_pemasangan,
            'posisi_ban' => $request->posisi_3c,
            'status' => 'aktif sementara',
            'kendaraan_id' => $kendaraan->id,
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan Pemasangan ban pada posisi Axle 3C');
    }

    public function update_3d(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'exel_3d' => 'required',
                'km_pemasangan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pemasangan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'exel_3d.required' => 'Pilih Ban',
                'km_pemasangan.required' => 'Masukkan km pemasangan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
        $kendaraan->update([
            'km' => $request->km_pemasangan
        ]);

        $kendaraan = Kendaraan::findOrFail($id);
        $ban = Ban::findOrFail($request->exel_3d);
        // $jumlahkmpemasangan = $request->km_pemasangan - $ban->km_pemasangan;
        $ban->update([
            // 'jumlah_km' => $jumlahkmpemasangan,
            'km_pemasangan' => $request->km_pemasangan,
            'posisi_ban' => $request->posisi_3d,
            'status' => 'aktif sementara',
            'kendaraan_id' => $kendaraan->id,
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan Pemasangan ban pada posisi Axle 3D');
    }

    public function update_4a(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'exel_4a' => 'required',
                'km_pemasangan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pemasangan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'exel_4a.required' => 'Pilih Ban',
                'km_pemasangan.required' => 'Masukkan km pemasangan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
        $kendaraan->update([
            'km' => $request->km_pemasangan
        ]);

        $kendaraan = Kendaraan::findOrFail($id);
        $ban = Ban::findOrFail($request->exel_4a);
        // $jumlahkmpemasangan = $request->km_pemasangan - $ban->km_pemasangan;
        $ban->update([
            // 'jumlah_km' => $jumlahkmpemasangan,
            'km_pemasangan' => $request->km_pemasangan,
            'posisi_ban' => $request->posisi_4a,
            'status' => 'aktif sementara',
            'kendaraan_id' => $kendaraan->id,
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan Pemasangan ban pada posisi Axle 4A');
    }

    public function update_4b(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'exel_4b' => 'required',
                'km_pemasangan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pemasangan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'exel_4b.required' => 'Pilih Ban',
                'km_pemasangan.required' => 'Masukkan km pemasangan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
        $kendaraan->update([
            'km' => $request->km_pemasangan
        ]);

        $kendaraan = Kendaraan::findOrFail($id);
        $ban = Ban::findOrFail($request->exel_4b);
        // $jumlahkmpemasangan = $request->km_pemasangan - $ban->km_pemasangan;
        $ban->update([
            // 'jumlah_km' => $jumlahkmpemasangan,
            'km_pemasangan' => $request->km_pemasangan,
            'posisi_ban' => $request->posisi_4b,
            'status' => 'aktif sementara',
            'kendaraan_id' => $kendaraan->id,
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan Pemasangan ban pada posisi Axle 4B');
    }

    public function update_4c(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'exel_4c' => 'required',
                'km_pemasangan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pemasangan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'exel_4c.required' => 'Pilih Ban',
                'km_pemasangan.required' => 'Masukkan km pemasangan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
        $kendaraan->update([
            'km' => $request->km_pemasangan
        ]);

        $kendaraan = Kendaraan::findOrFail($id);
        $ban = Ban::findOrFail($request->exel_4c);
        // $jumlahkmpemasangan = $request->km_pemasangan - $ban->km_pemasangan;
        $ban->update([
            // 'jumlah_km' => $jumlahkmpemasangan,
            'km_pemasangan' => $request->km_pemasangan,
            'posisi_ban' => $request->posisi_4c,
            'status' => 'aktif sementara',
            'kendaraan_id' => $kendaraan->id,
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan Pemasangan ban pada posisi Axle 4C');
    }

    public function update_4d(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'exel_4d' => 'required',
                'km_pemasangan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pemasangan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'exel_4d.required' => 'Pilih Ban',
                'km_pemasangan.required' => 'Masukkan km pemasangan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
        $kendaraan->update([
            'km' => $request->km_pemasangan
        ]);

        $kendaraan = Kendaraan::findOrFail($id);
        $ban = Ban::findOrFail($request->exel_4d);
        // $jumlahkmpemasangan = $request->km_pemasangan - $ban->km_pemasangan;
        $ban->update([
            // 'jumlah_km' => $jumlahkmpemasangan,
            'km_pemasangan' => $request->km_pemasangan,
            'posisi_ban' => $request->posisi_4d,
            'status' => 'aktif sementara',
            'kendaraan_id' => $kendaraan->id,
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan Pemasangan ban pada posisi Axle 4D');
    }

    public function update_5a(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'exel_5a' => 'required',
                'km_pemasangan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pemasangan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'exel_5a.required' => 'Pilih Ban',
                'km_pemasangan.required' => 'Masukkan km pemasangan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
        $kendaraan->update([
            'km' => $request->km_pemasangan
        ]);

        $kendaraan = Kendaraan::findOrFail($id);
        $ban = Ban::findOrFail($request->exel_5a);
        // $jumlahkmpemasangan = $request->km_pemasangan - $ban->km_pemasangan;
        $ban->update([
            // 'jumlah_km' => $jumlahkmpemasangan,
            'km_pemasangan' => $request->km_pemasangan,
            'posisi_ban' => $request->posisi_5a,
            'status' => 'aktif sementara',
            'kendaraan_id' => $kendaraan->id,
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan Pemasangan ban pada posisi Axle 5A');
    }

    public function update_5b(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'exel_5b' => 'required',
                'km_pemasangan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pemasangan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'exel_5b.required' => 'Pilih Ban',
                'km_pemasangan.required' => 'Masukkan km pemasangan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
        $kendaraan->update([
            'km' => $request->km_pemasangan
        ]);

        $kendaraan = Kendaraan::findOrFail($id);
        $ban = Ban::findOrFail($request->exel_5b);
        // $jumlahkmpemasangan = $request->km_pemasangan - $ban->km_pemasangan;
        $ban->update([
            // 'jumlah_km' => $jumlahkmpemasangan,
            'km_pemasangan' => $request->km_pemasangan,
            'posisi_ban' => $request->posisi_5b,
            'status' => 'aktif sementara',
            'kendaraan_id' => $kendaraan->id,
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan Pemasangan ban pada posisi Axle 5B');
    }

    public function update_5c(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'exel_5c' => 'required',
                'km_pemasangan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pemasangan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'exel_5c.required' => 'Pilih Ban',
                'km_pemasangan.required' => 'Masukkan km pemasangan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
        $kendaraan->update([
            'km' => $request->km_pemasangan
        ]);

        $kendaraan = Kendaraan::findOrFail($id);
        $ban = Ban::findOrFail($request->exel_5c);
        // $jumlahkmpemasangan = $request->km_pemasangan - $ban->km_pemasangan;
        $ban->update([
            // 'jumlah_km' => $jumlahkmpemasangan,
            'km_pemasangan' => $request->km_pemasangan,
            'posisi_ban' => $request->posisi_5c,
            'status' => 'aktif sementara',
            'kendaraan_id' => $kendaraan->id,
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan Pemasangan ban pada posisi Axle 5C');
    }

    public function update_5d(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'exel_5d' => 'required',
                'km_pemasangan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pemasangan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'exel_5d.required' => 'Pilih Ban',
                'km_pemasangan.required' => 'Masukkan km pemasangan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
        $kendaraan->update([
            'km' => $request->km_pemasangan
        ]);

        $kendaraan = Kendaraan::findOrFail($id);
        $ban = Ban::findOrFail($request->exel_5d);
        // $jumlahkmpemasangan = $request->km_pemasangan - $ban->km_pemasangan;
        $ban->update([
            // 'jumlah_km' => $jumlahkmpemasangan,
            'km_pemasangan' => $request->km_pemasangan,
            'posisi_ban' => $request->posisi_5d,
            'status' => 'aktif sementara',
            'kendaraan_id' => $kendaraan->id,
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan Pemasangan ban pada posisi Axle 5D');
    }

    public function update_6a(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'exel_6a' => 'required',
                'km_pemasangan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pemasangan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'exel_6a.required' => 'Pilih Ban',
                'km_pemasangan.required' => 'Masukkan km pemasangan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
        $kendaraan->update([
            'km' => $request->km_pemasangan
        ]);

        $kendaraan = Kendaraan::findOrFail($id);
        $ban = Ban::findOrFail($request->exel_6a);
        // $jumlahkmpemasangan = $request->km_pemasangan - $ban->km_pemasangan;
        $ban->update([
            // 'jumlah_km' => $jumlahkmpemasangan,
            'km_pemasangan' => $request->km_pemasangan,
            'posisi_ban' => $request->posisi_6a,
            'status' => 'aktif sementara',
            'kendaraan_id' => $kendaraan->id,
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan Pemasangan ban pada posisi Axle 6A');
    }

    public function update_6b(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'exel_6b' => 'required',
                'km_pemasangan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pemasangan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'exel_6b.required' => 'Pilih Ban',
                'km_pemasangan.required' => 'Masukkan km pemasangan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
        $kendaraan->update([
            'km' => $request->km_pemasangan
        ]);

        $kendaraan = Kendaraan::findOrFail($id);
        $ban = Ban::findOrFail($request->exel_6b);
        // $jumlahkmpemasangan = $request->km_pemasangan - $ban->km_pemasangan;
        $ban->update([
            // 'jumlah_km' => $jumlahkmpemasangan,
            'km_pemasangan' => $request->km_pemasangan,
            'posisi_ban' => $request->posisi_6b,
            'status' => 'aktif sementara',
            'kendaraan_id' => $kendaraan->id,
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan Pemasangan ban pada posisi Axle 6B');
    }

    public function update_6c(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'exel_6c' => 'required',
                'km_pemasangan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pemasangan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'exel_6c.required' => 'Pilih Ban',
                'km_pemasangan.required' => 'Masukkan km pemasangan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
        $kendaraan->update([
            'km' => $request->km_pemasangan
        ]);

        $kendaraan = Kendaraan::findOrFail($id);
        $ban = Ban::findOrFail($request->exel_6c);
        // $jumlahkmpemasangan = $request->km_pemasangan - $ban->km_pemasangan;
        $ban->update([
            // 'jumlah_km' => $jumlahkmpemasangan,
            'km_pemasangan' => $request->km_pemasangan,
            'posisi_ban' => $request->posisi_6c,
            'status' => 'aktif sementara',
            'kendaraan_id' => $kendaraan->id,
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan Pemasangan ban pada posisi Axle 6c');
    }

    public function update_6d(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'exel_6d' => 'required',
                'km_pemasangan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pemasangan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'exel_6d.required' => 'Pilih Ban',
                'km_pemasangan.required' => 'Masukkan km pemasangan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
        $kendaraan->update([
            'km' => $request->km_pemasangan
        ]);

        $kendaraan = Kendaraan::findOrFail($id);
        $ban = Ban::findOrFail($request->exel_6d);
        // $jumlahkmpemasangan = $request->km_pemasangan - $ban->km_pemasangan;
        $ban->update([
            // 'jumlah_km' => $jumlahkmpemasangan,
            'km_pemasangan' => $request->km_pemasangan,
            'posisi_ban' => $request->posisi_6d,
            'status' => 'aktif sementara',
            'kendaraan_id' => $kendaraan->id,
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan Pemasangan ban pada posisi Axle 6d');
    }
}
