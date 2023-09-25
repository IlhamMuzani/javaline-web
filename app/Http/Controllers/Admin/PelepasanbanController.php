<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Ban;
use App\Models\Kendaraan;
use App\Models\Service_ban;
use App\Models\Pelepasan_ban;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\ServerBag;

class PelepasanbanController extends Controller
{
    public function index()
    {
        if (auth()->check() && auth()->user()->menu['pelepasan ban']) {
            $pelepasan_bans = Pelepasan_ban::all();

            $kendaraans = Kendaraan::where(['status_pemasangan' => 'pemasangan'])->get();
            return view('admin.pelepasan_ban.index', compact('pelepasan_bans', 'kendaraans'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function create()
    {
        if (auth()->check() && auth()->user()->menu['pelepasan ban']) {
            $kendaraans = Kendaraan::all();
            $bans = Ban::all();
            return view('admin/pelepasan_ban.create', compact('kendaraans', 'bans'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function edit($id)
    {
        $kendaraan = Kendaraan::where('id', $id)->first();

        $bans = Ban::where(['posisi_ban' => '1A', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id])->first();
        $bansb = Ban::where(['posisi_ban' => '1B', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id])->first();
        $bans2a = Ban::where(['posisi_ban' => '2A', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id])->first();
        $bans2b = Ban::where(['posisi_ban' => '2B', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id])->first();
        $bans2c = Ban::where(['posisi_ban' => '2C', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id])->first();
        $bans2d = Ban::where(['posisi_ban' => '2D', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id])->first();
        $bans3a = Ban::where(['posisi_ban' => '3A', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id])->first();
        $bans3b = Ban::where(['posisi_ban' => '3B', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id])->first();
        $bans3c = Ban::where(['posisi_ban' => '3C', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id])->first();
        $bans3d = Ban::where(['posisi_ban' => '3D', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id])->first();
        $bans4a = Ban::where(['posisi_ban' => '3A', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id])->first();
        $bans4b = Ban::where(['posisi_ban' => '3B', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id])->first();
        $bans4c = Ban::where(['posisi_ban' => '3C', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id])->first();
        $bans4d = Ban::where(['posisi_ban' => '3D', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id])->first();
        $bans4a = Ban::where(['posisi_ban' => '4A', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id])->first();
        $bans4b = Ban::where(['posisi_ban' => '4B', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id])->first();
        $bans4c = Ban::where(['posisi_ban' => '4C', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id])->first();
        $bans4d = Ban::where(['posisi_ban' => '4D', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id])->first();
        $bans5a = Ban::where(['posisi_ban' => '5A', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id])->first();
        $bans5b = Ban::where(['posisi_ban' => '5B', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id])->first();
        $bans5c = Ban::where(['posisi_ban' => '5C', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id])->first();
        $bans5d = Ban::where(['posisi_ban' => '5D', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id])->first();
        $bans6a = Ban::where(['posisi_ban' => '6A', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id])->first();
        $bans6b = Ban::where(['posisi_ban' => '6B', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id])->first();
        $bans6c = Ban::where(['posisi_ban' => '6C', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id])->first();
        $bans6d = Ban::where(['posisi_ban' => '6D', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id])->first();

        $tabelbans = Ban::where(['kendaraan_id' => $kendaraan->id, 'status' => 'non aktif sementara'])->get();

        return view('admin/pelepasan_ban.create', compact('kendaraan', 'tabelbans', 'bans', 'bansb', 'bans2a', 'bans2b', 'bans2c', 'bans2d', 'bans3a', 'bans3b', 'bans3c', 'bans3d', 'bans4a', 'bans4b', 'bans4c', 'bans4d', 'bans5a', 'bans5b', 'bans5c', 'bans5d', 'bans6a', 'bans6b', 'bans6c', 'bans6d'));
    }


    public function store(Request $request)
    {
        $kendaraan_id = $request->kendaraan_id;

        Ban::where(['kendaraan_id' => $kendaraan_id, 'status' => 'non aktif sementara'])->update([
            'status' => 'aktif',
        ]);


        return redirect('admin/pelepasan_ban/' . $kendaraan_id . '/edit');
    }

    public function kode()
    {
        $pelepasan_ban = Pelepasan_ban::all();
        if ($pelepasan_ban->isEmpty()) {
            $num = "000001";
        } else {
            $id = Pelepasan_ban::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'AN';
        $kode_pelepasan_ban = $data . $num;
        return $kode_pelepasan_ban;
    }

    public function kendaraan($id)
    {
        $jenis_kendaraan = Kendaraan::where('id', $id)->with('jenis_kendaraan')->first();

        return json_decode($jenis_kendaraan);
    }

    public function show($id)
    {
        $pemasangan_ban = Pelepasan_ban::findOrFail($id);

        $kendaraan_id = $pemasangan_ban->kendaraan_id;

        $kendaraan = Kendaraan::findOrFail($kendaraan_id);

        $bans = Ban::where('kendaraan_id', $kendaraan_id)->get();

        return view('admin.pelepasan_ban.show', compact('bans', 'kendaraan'));
    }

    public function cetakpdf($id)
    { {
            $pelepasan_ban = Pelepasan_ban::where('id', $id)->first();
            $pemasangan_ban = Pelepasan_ban::findOrFail($id);
            $kendaraan_id = $pemasangan_ban->kendaraan_id;
            $kendaraan = Kendaraan::findOrFail($kendaraan_id);
            $bans = Ban::where('pelepasan_ban_id', $id)->get();

            $pdf = PDF::loadView('admin/pelepasan_ban.cetak_pdf', compact('bans', 'kendaraan', 'pelepasan_ban'));
            $pdf->setPaper('letter', 'portrait');

            return $pdf->stream('Laporan_Pelepasan_Ban.pdf');
        }
    }

    public function destroy($id)
    {
        $ban = Ban::find($id);

        if ($ban) {
            $ban->update([
                'pelepasan_ban_id' => null,
                'kendaraan_id' => null,
                'status' => 'aktif'
            ]);

            return redirect()->back()->with('success', 'Berhasil menghapus pelepasan ban');
        }

        return redirect()->back()->with('error', 'Data ban tidak ditemukan');
    }

    public function update(Request $request, $id)
    {

        $kendaraans = Kendaraan::findOrFail($id);

        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');

        // tgl filter
        $tanggal = Carbon::now()->format('Y-m-d');

        $pelepasan = Pelepasan_ban::create([
            'kode_pelepasan' => $this->kode(),
            'kendaraan_id' => $kendaraans->id,
            'tanggal' => $format_tanggal,
            'tanggal_awal' => $tanggal,
            'status' => 'posting',
            'status_notif' => false,

        ]);
        $pelepasanId = $pelepasan->id;

        Ban::where([
            ['kendaraan_id', $id],
            ['status', 'non aktif sementara']
        ])->update([
            'status' => 'non aktif',
            'pelepasan_ban_id' => $pelepasanId,
            'kendaraan_id' => null,
        ]);

        return redirect('admin/pelepasan_ban')->with('success', 'Berhasil melakukan pelepasan');
    }

    public function updatepelepasan_1a(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'keterangan' => 'required',
                'km_pelepasan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pelepasan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'keterangan.required' => 'Pilih Keterangan',
                'km_pelepasan.required' => 'Masukkan km pelepasan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
        $kendaraan->update([
            'km' => $request->km_pelepasan,
        ]);

        $kendaraan = Kendaraan::findOrFail($id);
        $banId = $request->id_ban;
        $ban = Ban::find($banId);

        if (!$ban) {
            return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
        }

        $ban->update([
            'keterangan' => $request->keterangan,
            'km_pelepasan' => $request->km_pelepasan,
            'status' => 'non aktif sementara',

        ]);

        return redirect()->back()->withInput()->with('success', 'Berhasil menambahkan Pelepasan ban pada posisi Axle 1A');

        // return Redirect::back()->with('success', 'Berhasil menambahkan Pelepasan ban pada posisi Axle 1A');
    }

    public function updatepelepasan_1b(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'keterangan' => 'required',
                'km_pelepasan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pelepasan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'keterangan.required' => 'Pilih Keterangan',
                'km_pelepasan.required' => 'Masukkan km pelepasan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
        $kendaraan->update([
            'km' => $request->km_pelepasan
        ]);

        $kendaraan = Kendaraan::findOrFail($id);
        $banId = $request->id_ban;
        $ban = Ban::find($banId);

        if (!$ban) {
            return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
        }

        $ban->update([
            'keterangan' => $request->keterangan,
            'km_pelepasan' => $request->km_pelepasan,
            'status' => 'non aktif sementara',
        ]);

        return redirect()->back()->withInput()->with('success', 'Berhasil menambahkan Pelepasan ban pada posisi Axle 1B');
    }

    public function updatepelepasan_2a(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'keterangan' => 'required',
                'km_pelepasan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pelepasan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'keterangan.required' => 'Pilih Keterangan',
                'km_pelepasan.required' => 'Masukkan km pelepasan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
        $kendaraan->update([
            'km' => $request->km_pelepasan
        ]);

        $kendaraan = Kendaraan::findOrFail($id);
        $banId = $request->id_ban;
        $ban = Ban::find($banId);

        if (!$ban) {
            return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
        }

        $ban->update([
            'keterangan' => $request->keterangan,
            'km_pelepasan' => $request->km_pelepasan,
            'status' => 'non aktif sementara',
        ]);

        return redirect()->back()->withInput()->with('success', 'Berhasil menambahkan Pelepasan ban pada posisi Axle 2A');
    }

    public function updatepelepasan_2b(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'keterangan' => 'required',
                'km_pelepasan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pelepasan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'keterangan.required' => 'Pilih Keterangan',
                'km_pelepasan.required' => 'Masukkan km pelepasan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
        $kendaraan->update([
            'km' => $request->km_pelepasan
        ]);

        $kendaraan = Kendaraan::findOrFail($id);
        $banId = $request->id_ban;
        $ban = Ban::find($banId);

        if (!$ban) {
            return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
        }

        $ban->update([
            'keterangan' => $request->keterangan,
            'km_pelepasan' => $request->km_pelepasan,
            'status' => 'non aktif sementara',
        ]);

        return redirect()->back()->withInput()->with('success', 'Berhasil menambahkan Pelepasan ban pada posisi Axle 2B');
    }

    public function updatepelepasan_2c(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'keterangan' => 'required',
                'km_pelepasan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pelepasan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'keterangan.required' => 'Pilih Keterangan',
                'km_pelepasan.required' => 'Masukkan km pelepasan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
        $kendaraan->update([
            'km' => $request->km_pelepasan
        ]);

        $kendaraan = Kendaraan::findOrFail($id);
        $banId = $request->id_ban;
        $ban = Ban::find($banId);

        if (!$ban) {
            return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
        }

        $ban->update([
            'keterangan' => $request->keterangan,
            'km_pelepasan' => $request->km_pelepasan,
            'status' => 'non aktif sementara',
        ]);

        return redirect()->back()->withInput()->with('success', 'Berhasil menambahkan Pelepasan ban pada posisi Axle 2C');
    }

    public function updatepelepasan_2d(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'keterangan' => 'required',
                'km_pelepasan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pelepasan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'keterangan.required' => 'Pilih Keterangan',
                'km_pelepasan.required' => 'Masukkan km pelepasan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
        $kendaraan->update([
            'km' => $request->km_pelepasan
        ]);

        $kendaraan = Kendaraan::findOrFail($id);
        $banId = $request->id_ban;
        $ban = Ban::find($banId);

        if (!$ban) {
            return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
        }

        $ban->update([
            'keterangan' => $request->keterangan,
            'km_pelepasan' => $request->km_pelepasan,
            'status' => 'non aktif sementara',
        ]);

        return redirect()->back()->withInput()->with('success', 'Berhasil menambahkan Pelepasan ban pada posisi Axle 2D');
    }

    public function updatepelepasan_3a(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'keterangan' => 'required',
                'km_pelepasan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pelepasan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'keterangan.required' => 'Pilih Keterangan',
                'km_pelepasan.required' => 'Masukkan km pelepasan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
        $kendaraan->update([
            'km' => $request->km_pelepasan
        ]);

        $kendaraan = Kendaraan::findOrFail($id);
        $banId = $request->id_ban;
        $ban = Ban::find($banId);

        if (!$ban) {
            return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
        }

        $ban->update([
            'keterangan' => $request->keterangan,
            'km_pelepasan' => $request->km_pelepasan,
            'status' => 'non aktif sementara',
        ]);

        return redirect()->back()->withInput()->with('success', 'Berhasil menambahkan Pelepasan ban pada posisi Axle 3A');
    }

    public function updatepelepasan_3b(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'keterangan' => 'required',
                'km_pelepasan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pelepasan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'keterangan.required' => 'Pilih Keterangan',
                'km_pelepasan.required' => 'Masukkan km pelepasan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
        $kendaraan->update([
            'km' => $request->km_pelepasan
        ]);

        $kendaraan = Kendaraan::findOrFail($id);
        $banId = $request->id_ban;
        $ban = Ban::find($banId);

        if (!$ban) {
            return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
        }

        $ban->update([
            'keterangan' => $request->keterangan,
            'km_pelepasan' => $request->km_pelepasan,
            'status' => 'non aktif sementara',
        ]);

        return redirect()->back()->withInput()->with('success', 'Berhasil menambahkan Pelepasan ban pada posisi Axle 3B');
    }

    public function updatepelepasan_3c(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'keterangan' => 'required',
                'km_pelepasan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pelepasan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'keterangan.required' => 'Pilih Keterangan',
                'km_pelepasan.required' => 'Masukkan km pelepasan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
        $kendaraan->update([
            'km' => $request->km_pelepasan
        ]);

        $kendaraan = Kendaraan::findOrFail($id);
        $banId = $request->id_ban;
        $ban = Ban::find($banId);

        if (!$ban) {
            return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
        }

        $ban->update([
            'keterangan' => $request->keterangan,
            'km_pelepasan' => $request->km_pelepasan,
            'status' => 'non aktif sementara',
        ]);

        return redirect()->back()->withInput()->with('success', 'Berhasil menambahkan Pelepasan ban pada posisi Axle 3C');
    }

    public function updatepelepasan_3d(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'keterangan' => 'required',
                'km_pelepasan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pelepasan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'keterangan.required' => 'Pilih Keterangan',
                'km_pelepasan.required' => 'Masukkan km pelepasan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
        $kendaraan->update([
            'km' => $request->km_pelepasan
        ]);

        $kendaraan = Kendaraan::findOrFail($id);
        $banId = $request->id_ban;
        $ban = Ban::find($banId);

        if (!$ban) {
            return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
        }

        $ban->update([
            'keterangan' => $request->keterangan,
            'km_pelepasan' => $request->km_pelepasan,
            'status' => 'non aktif sementara',
        ]);

        return redirect()->back()->withInput()->with('success', 'Berhasil menambahkan Pelepasan ban pada posisi Axle 3D');
    }

    public function updatepelepasan_4a(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'keterangan' => 'required',
                'km_pelepasan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pelepasan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'keterangan.required' => 'Pilih Keterangan',
                'km_pelepasan.required' => 'Masukkan km pelepasan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
        $kendaraan->update([
            'km' => $request->km_pelepasan
        ]);

        $kendaraan = Kendaraan::findOrFail($id);
        $banId = $request->id_ban;
        $ban = Ban::find($banId);

        if (!$ban) {
            return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
        }

        $ban->update([
            'keterangan' => $request->keterangan,
            'km_pelepasan' => $request->km_pelepasan,
            'status' => 'non aktif sementara',
        ]);

        return redirect()->back()->withInput()->with('success', 'Berhasil menambahkan Pelepasan ban pada posisi Axle 4A');
    }

    public function updatepelepasan_4b(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'keterangan' => 'required',
                'km_pelepasan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pelepasan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'keterangan.required' => 'Pilih Keterangan',
                'km_pelepasan.required' => 'Masukkan km pelepasan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
        $kendaraan->update([
            'km' => $request->km_pelepasan
        ]);

        $kendaraan = Kendaraan::findOrFail($id);
        $banId = $request->id_ban;
        $ban = Ban::find($banId);

        if (!$ban) {
            return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
        }

        $ban->update([
            'keterangan' => $request->keterangan,
            'km_pelepasan' => $request->km_pelepasan,
            'status' => 'non aktif sementara',
        ]);

        return redirect()->back()->withInput()->with('success', 'Berhasil menambahkan Pelepasan ban pada posisi Axle 4B');
    }

    public function updatepelepasan_4c(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'keterangan' => 'required',
                'km_pelepasan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pelepasan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'keterangan.required' => 'Pilih Keterangan',
                'km_pelepasan.required' => 'Masukkan km pelepasan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
        $kendaraan->update([
            'km' => $request->km_pelepasan
        ]);

        $kendaraan = Kendaraan::findOrFail($id);
        $banId = $request->id_ban;
        $ban = Ban::find($banId);

        if (!$ban) {
            return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
        }

        $ban->update([
            'keterangan' => $request->keterangan,
            'km_pelepasan' => $request->km_pelepasan,
            'status' => 'non aktif sementara',
        ]);

        return redirect()->back()->withInput()->with('success', 'Berhasil menambahkan Pelepasan ban pada posisi Axle 4C');
    }

    public function updatepelepasan_4d(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'keterangan' => 'required',
                'km_pelepasan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pelepasan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'keterangan.required' => 'Pilih Keterangan',
                'km_pelepasan.required' => 'Masukkan km pelepasan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
        $kendaraan->update([
            'km' => $request->km_pelepasan
        ]);

        $kendaraan = Kendaraan::findOrFail($id);
        $banId = $request->id_ban;
        $ban = Ban::find($banId);

        if (!$ban) {
            return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
        }

        $ban->update([
            'keterangan' => $request->keterangan,
            'km_pelepasan' => $request->km_pelepasan,
            'status' => 'non aktif sementara',
        ]);

        return redirect()->back()->withInput()->with('success', 'Berhasil menambahkan Pelepasan ban pada posisi Axle 4D');
    }

    public function updatepelepasan_5a(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'keterangan' => 'required',
                'km_pelepasan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pelepasan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'keterangan.required' => 'Pilih Keterangan',
                'km_pelepasan.required' => 'Masukkan km pelepasan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
        $kendaraan->update([
            'km' => $request->km_pelepasan
        ]);

        $kendaraan = Kendaraan::findOrFail($id);
        $banId = $request->id_ban;
        $ban = Ban::find($banId);

        if (!$ban) {
            return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
        }

        $ban->update([
            'keterangan' => $request->keterangan,
            'km_pelepasan' => $request->km_pelepasan,
            'status' => 'non aktif sementara',
        ]);

        return redirect()->back()->withInput()->with('success', 'Berhasil menambahkan Pelepasan ban pada posisi Axle 5A');
    }

    public function updatepelepasan_5b(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'keterangan' => 'required',
                'km_pelepasan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pelepasan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'keterangan.required' => 'Pilih Keterangan',
                'km_pelepasan.required' => 'Masukkan km pelepasan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
        $kendaraan->update([
            'km' => $request->km_pelepasan
        ]);

        $kendaraan = Kendaraan::findOrFail($id);
        $banId = $request->id_ban;
        $ban = Ban::find($banId);

        if (!$ban) {
            return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
        }

        $ban->update([
            'keterangan' => $request->keterangan,
            'km_pelepasan' => $request->km_pelepasan,
            'status' => 'non aktif sementara',
        ]);

        return redirect()->back()->withInput()->with('success', 'Berhasil menambahkan Pelepasan ban pada posisi Axle 5B');
    }

    public function updatepelepasan_5c(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'keterangan' => 'required',
                'km_pelepasan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pelepasan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'keterangan.required' => 'Pilih Keterangan',
                'km_pelepasan.required' => 'Masukkan km pelepasan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
        $kendaraan->update([
            'km' => $request->km_pelepasan
        ]);

        $kendaraan = Kendaraan::findOrFail($id);
        $banId = $request->id_ban;
        $ban = Ban::find($banId);

        if (!$ban) {
            return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
        }

        $ban->update([
            'keterangan' => $request->keterangan,
            'km_pelepasan' => $request->km_pelepasan,
            'status' => 'non aktif sementara',
        ]);

        return redirect()->back()->withInput()->with('success', 'Berhasil menambahkan Pelepasan ban pada posisi Axle 5C');
    }

    public function updatepelepasan_5d(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'keterangan' => 'required',
                'km_pelepasan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pelepasan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'keterangan.required' => 'Pilih Keterangan',
                'km_pelepasan.required' => 'Masukkan km pelepasan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
        $kendaraan->update([
            'km' => $request->km_pelepasan
        ]);

        $kendaraan = Kendaraan::findOrFail($id);
        $banId = $request->id_ban;
        $ban = Ban::find($banId);

        if (!$ban) {
            return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
        }

        $ban->update([
            'keterangan' => $request->keterangan,
            'km_pelepasan' => $request->km_pelepasan,
            'status' => 'non aktif sementara',
        ]);

        return redirect()->back()->withInput()->with('success', 'Berhasil menambahkan Pelepasan ban pada posisi Axle 5D');
    }

    public function updatepelepasan_6a(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'keterangan' => 'required',
                'km_pelepasan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pelepasan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'keterangan.required' => 'Pilih Keterangan',
                'km_pelepasan.required' => 'Masukkan km pelepasan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
        $kendaraan->update([
            'km' => $request->km_pelepasan
        ]);

        $kendaraan = Kendaraan::findOrFail($id);
        $banId = $request->id_ban;
        $ban = Ban::find($banId);

        if (!$ban) {
            return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
        }

        $ban->update([
            'keterangan' => $request->keterangan,
            'km_pelepasan' => $request->km_pelepasan,
            'status' => 'non aktif sementara',
        ]);

        return redirect()->back()->withInput()->with('success', 'Berhasil menambahkan Pelepasan ban pada posisi Axle 6A');
    }

    public function updatepelepasan_6B(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'keterangan' => 'required',
                'km_pelepasan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pelepasan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'keterangan.required' => 'Pilih Keterangan',
                'km_pelepasan.required' => 'Masukkan km pelepasan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
        $kendaraan->update([
            'km' => $request->km_pelepasan
        ]);

        $kendaraan = Kendaraan::findOrFail($id);
        $banId = $request->id_ban;
        $ban = Ban::find($banId);

        if (!$ban) {
            return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
        }

        $ban->update([
            'keterangan' => $request->keterangan,
            'km_pelepasan' => $request->km_pelepasan,
            'status' => 'non aktif sementara',
        ]);

        return redirect()->back()->withInput()->with('success', 'Berhasil menambahkan Pelepasan ban pada posisi Axle 6B');
    }

    public function updatepelepasan_6c(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'keterangan' => 'required',
                'km_pelepasan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pelepasan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'keterangan.required' => 'Pilih Keterangan',
                'km_pelepasan.required' => 'Masukkan km pelepasan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
        $kendaraan->update([
            'km' => $request->km_pelepasan
        ]);

        $kendaraan = Kendaraan::findOrFail($id);
        $banId = $request->id_ban;
        $ban = Ban::find($banId);

        if (!$ban) {
            return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
        }

        $ban->update([
            'keterangan' => $request->keterangan,
            'km_pelepasan' => $request->km_pelepasan,
            'status' => 'non aktif sementara',
        ]);

        return redirect()->back()->withInput()->with('success', 'Berhasil menambahkan Pelepasan ban pada posisi Axle 6C');
    }

    public function updatepelepasan_6d(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'keterangan' => 'required',
                'km_pelepasan' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        $kendaraan = Kendaraan::find($request->kendaraan_id);

                        if (!$kendaraan) {
                            return $fail('Kendaraan tidak ditemukan.');
                        }

                        if ($value < $kendaraan->km) {
                            $fail('Nilai km pelepasan tidak boleh lebih rendah dari km kendaraan.');
                        }
                    },
                ],
            ],
            [
                'keterangan.required' => 'Pilih Keterangan',
                'km_pelepasan.required' => 'Masukkan km pelepasan',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
        $kendaraan->update([
            'km' => $request->km_pelepasan
        ]);

        $kendaraan = Kendaraan::findOrFail($id);
        $banId = $request->id_ban;
        $ban = Ban::find($banId);

        if (!$ban) {
            return redirect()->back()->with('error', 'Ban dengan ID ' . $banId . ' tidak ditemukan.');
        }

        $ban->update([
            'keterangan' => $request->keterangan,
            'km_pelepasan' => $request->km_pelepasan,
            'status' => 'non aktif sementara',
        ]);

        return redirect()->back()->withInput()->with('success', 'Berhasil menambahkan Pelepasan ban pada posisi Axle 6D');
    }
}