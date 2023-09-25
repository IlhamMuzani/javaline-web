<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Ban;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use App\Models\Pemasangan_ban;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class InqueryPemasanganbanController extends Controller
{
    public function index(Request $request)
    {

        if (auth()->check() && auth()->user()->menu['inquery pemasangan ban']) {

            Pemasangan_ban::where([
                ['status', 'posting']
            ])->update([
                'status_notif' => true
            ]);

            $status = $request->status;
            $tanggal_awal = $request->tanggal_awal;
            $tanggal_akhir = $request->tanggal_akhir;

            $inquery = Pemasangan_ban::query();

            if ($status) {
                $inquery->where('status', $status);
            }

            if ($tanggal_awal && $tanggal_akhir) {
                $inquery->whereBetween('tanggal_awal', [$tanggal_awal, $tanggal_akhir]);
            } elseif ($tanggal_awal) {
                $inquery->where('tanggal_awal', '>=', $tanggal_awal);
            } elseif ($tanggal_akhir) {
                $inquery->where('tanggal_awal', '<=', $tanggal_akhir);
            } else {
                $inquery->orWhereDate('tanggal_awal', Carbon::today());
            }


            $inquery->orderBy('id', 'DESC');
            $inquery = $inquery->get();

            return view('admin.inquery_pemasanganban.index', compact('inquery'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function unpostpemasangan($id)
    {
        $ban = Pemasangan_ban::where('id', $id)->first();

        $ban->update([
            'status' => 'unpost'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function postingpemasangan($id)
    {
        $ban = Pemasangan_ban::where('id', $id)->first();

        $ban->update([
            'status' => 'posting'
        ]);

        return back()->with('success', 'Berhasil');
    }

    public function lihat_pemasangan($id)
    {
        if (auth()->check() && auth()->user()->menu['inquery pemasangan ban']) {

            $pemasangan_ban = Pemasangan_ban::findOrFail($id);

            $kendaraan_id = $pemasangan_ban->kendaraan_id;

            $kendaraan = Kendaraan::findOrFail($kendaraan_id);

            $bans = Ban::where('pemasangan_ban_id', $id)->get();

            return view('admin.inquery_pemasanganban.show', compact('bans', 'kendaraan', 'pemasangan_ban'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function edit($id)
    {
        if (auth()->check() && auth()->user()->menu['inquery pemasangan ban']) {

            $inquerypemasangan = Pemasangan_ban::where('id', $id)->first();
            $inquery_pemasanganban = Pemasangan_ban::findOrFail($id);
            $kendaraan = Kendaraan::findOrFail($inquery_pemasanganban->kendaraan_id);

            $bans = Ban::where(['posisi_ban' => '1A', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id, 'pemasangan_ban_id' => $id])->first();
            $bansb = Ban::where(['posisi_ban' => '1B', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id, 'pemasangan_ban_id' => $id])->first();
            $bans2a = Ban::where(['posisi_ban' => '2A', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id, 'pemasangan_ban_id' => $id])->first();
            $bans2b = Ban::where(['posisi_ban' => '2B', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id, 'pemasangan_ban_id' => $id])->first();
            $bans2c = Ban::where(['posisi_ban' => '2C', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id, 'pemasangan_ban_id' => $id])->first();
            $bans2d = Ban::where(['posisi_ban' => '2D', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id, 'pemasangan_ban_id' => $id])->first();
            $bans3a = Ban::where(['posisi_ban' => '3A', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id, 'pemasangan_ban_id' => $id])->first();
            $bans3b = Ban::where(['posisi_ban' => '3B', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id, 'pemasangan_ban_id' => $id])->first();
            $bans3c = Ban::where(['posisi_ban' => '3C', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id, 'pemasangan_ban_id' => $id])->first();
            $bans3d = Ban::where(['posisi_ban' => '3D', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id, 'pemasangan_ban_id' => $id])->first();
            $bans4a = Ban::where(['posisi_ban' => '3A', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id, 'pemasangan_ban_id' => $id])->first();
            $bans4b = Ban::where(['posisi_ban' => '3B', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id, 'pemasangan_ban_id' => $id])->first();
            $bans4c = Ban::where(['posisi_ban' => '3C', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id, 'pemasangan_ban_id' => $id])->first();
            $bans4d = Ban::where(['posisi_ban' => '3D', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id, 'pemasangan_ban_id' => $id])->first();
            $bans4a = Ban::where(['posisi_ban' => '4A', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id, 'pemasangan_ban_id' => $id])->first();
            $bans4b = Ban::where(['posisi_ban' => '4B', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id, 'pemasangan_ban_id' => $id])->first();
            $bans4c = Ban::where(['posisi_ban' => '4C', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id, 'pemasangan_ban_id' => $id])->first();
            $bans4d = Ban::where(['posisi_ban' => '4D', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id, 'pemasangan_ban_id' => $id])->first();
            $bans5a = Ban::where(['posisi_ban' => '5A', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id, 'pemasangan_ban_id' => $id])->first();
            $bans5b = Ban::where(['posisi_ban' => '5B', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id, 'pemasangan_ban_id' => $id])->first();
            $bans5c = Ban::where(['posisi_ban' => '5C', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id, 'pemasangan_ban_id' => $id])->first();
            $bans5d = Ban::where(['posisi_ban' => '5D', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id, 'pemasangan_ban_id' => $id])->first();
            $bans6a = Ban::where(['posisi_ban' => '6A', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id, 'pemasangan_ban_id' => $id])->first();
            $bans6b = Ban::where(['posisi_ban' => '6B', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id, 'pemasangan_ban_id' => $id])->first();
            $bans6c = Ban::where(['posisi_ban' => '6C', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id, 'pemasangan_ban_id' => $id])->first();
            $bans6d = Ban::where(['posisi_ban' => '6D', 'status' => 'aktif', 'kendaraan_id' => $kendaraan->id, 'pemasangan_ban_id' => $id])->first();

            $daftarbans = Ban::where(['status' => 'stok'])->get();

            $tabelbans = Ban::where([
                ['kendaraan_id', $kendaraan->id],
                ['status', 'aktif'],
                ['pemasangan_ban_id', $id]
            ])->get();

            return view('admin/inquery_pemasanganban.update', compact('inquerypemasangan', 'daftarbans', 'kendaraan', 'tabelbans', 'bans', 'bansb', 'bans2a', 'bans2b', 'bans2c', 'bans2d', 'bans3a', 'bans3b', 'bans3c', 'bans3d', 'bans4a', 'bans4b', 'bans4c', 'bans4d', 'bans5a', 'bans5b', 'bans5c', 'bans5d', 'bans6a', 'bans6b', 'bans6c', 'bans6d'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function destroy($id)
    {
        $ban = Ban::find($id);

        if ($ban) {
            $ban->update([
                'pelepasan_ban_id' => null,
                'kendaraan_id' => null,
                'pemasangan_ban_id' => null,
                'status' => 'stok'
            ]);

            return redirect()->back()->with('success', 'Berhasil menghapus pemasangan ban');
        }

        return redirect()->back()->with('error', 'Data ban tidak ditemukan');
    }

    public function delete($id)
    {
        $ban = Pemasangan_ban::find($id);
        $ban->delete();

        return redirect('admin/inquery_pemasanganban')->with('success', 'Berhasil menghapus Pemasangan');
    }

    public function update(Request $request, $id)
    {

        $inquerypemasanganban = Pemasangan_ban::findOrFail($id);
        $inquerypemasanganban->update([
            'status' => 'posting',
        ]);
        return redirect('admin/inquery_pemasanganban')->with('success', 'Berhasil memperbarui');
    }

    public function inquerypemasangan1(Request $request, $id)
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
        $pemasangan = Pemasangan_ban::findOrFail($request->pemasangan_ban_id);

        $ban = Ban::findOrFail($request->exel_1a);
        $ban->update([
            'km_pemasangan' => $request->km_pemasangan,
            'posisi_ban' => $request->posisi_1a,
            'status' => 'aktif',
            'kendaraan_id' => $kendaraan->id,
            'pemasangan_ban_id' => $pemasangan->id,
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan Pemasangan ban pada posisi Axle 1A');
    }

    public function inquerypemasangan1b(Request $request, $id)
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

        $pemasangan = Pemasangan_ban::findOrFail($request->pemasangan_ban_id);
        $kendaraan = Kendaraan::findOrFail($id);
        $ban = Ban::findOrFail($request->exel_1b);
        $ban->update([
            'km_pemasangan' => $request->km_pemasangan,
            'posisi_ban' => $request->posisi_1b,
            'status' => 'aktif',
            'kendaraan_id' => $kendaraan->id,
            'pemasangan_ban_id' => $pemasangan->id
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan Pemasangan ban pada posisi Axle 1B');
    }

    public function inquerypemasangan2a(Request $request, $id)
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

        $pemasangan = Pemasangan_ban::findOrFail($request->pemasangan_ban_id);
        $kendaraan = Kendaraan::findOrFail($id);
        $ban = Ban::findOrFail($request->exel_2a);
        $ban->update([
            'km_pemasangan' => $request->km_pemasangan,
            'posisi_ban' => $request->posisi_2a,
            'status' => 'aktif',
            'kendaraan_id' => $kendaraan->id,
            'pemasangan_ban_id' => $pemasangan->id
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan Pemasangan ban pada posisi Axle 2A');
    }

    public function inquerypemasangan2b(Request $request, $id)
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


        $pemasangan = Pemasangan_ban::findOrFail($request->pemasangan_ban_id);
        $kendaraan = Kendaraan::findOrFail($id);
        $ban = Ban::findOrFail($request->exel_2b);
        $ban->update([
            'km_pemasangan' => $request->km_pemasangan,
            'posisi_ban' => $request->posisi_2b,
            'status' => 'aktif',
            'kendaraan_id' => $kendaraan->id,
            'pemasangan_ban_id' => $pemasangan->id
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan Pemasangan ban pada posisi Axle 2B');
    }

    public function inquerypemasangan2c(Request $request, $id)
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

        $pemasangan = Pemasangan_ban::findOrFail($request->pemasangan_ban_id);
        $kendaraan = Kendaraan::findOrFail($id);
        $ban = Ban::findOrFail($request->exel_2c);
        $ban->update([
            'km_pemasangan' => $request->km_pemasangan,
            'posisi_ban' => $request->posisi_2c,
            'status' => 'aktif',
            'kendaraan_id' => $kendaraan->id,
            'pemasangan_ban_id' => $pemasangan->id
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan Pemasangan ban pada posisi Axle 2C');
    }

    public function inquerypemasangan2d(Request $request, $id)
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

        $pemasangan = Pemasangan_ban::findOrFail($request->pemasangan_ban_id);
        $kendaraan = Kendaraan::findOrFail($id);
        $ban = Ban::findOrFail($request->exel_2d);
        $ban->update([
            'km_pemasangan' => $request->km_pemasangan,
            'posisi_ban' => $request->posisi_2d,
            'status' => 'aktif',
            'kendaraan_id' => $kendaraan->id,
            'pemasangan_ban_id' => $pemasangan->id
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan Pemasangan ban pada posisi Axle 2D');
    }

    public function inquerypemasangan3a(Request $request, $id)
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

        $pemasangan = Pemasangan_ban::findOrFail($request->pemasangan_ban_id);
        $kendaraan = Kendaraan::findOrFail($id);
        $ban = Ban::findOrFail($request->exel_3a);
        $ban->update([
            'km_pemasangan' => $request->km_pemasangan,
            'posisi_ban' => $request->posisi_3a,
            'status' => 'aktif',
            'kendaraan_id' => $kendaraan->id,
            'pemasangan_ban_id' => $pemasangan->id
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan Pemasangan ban pada posisi Axle 3A');
    }

    public function inquerypemasangan3b(Request $request, $id)
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

        $pemasangan = Pemasangan_ban::findOrFail($request->pemasangan_ban_id);
        $kendaraan = Kendaraan::findOrFail($id);
        $ban = Ban::findOrFail($request->exel_3b);
        $ban->update([
            'km_pemasangan' => $request->km_pemasangan,
            'posisi_ban' => $request->posisi_3b,
            'status' => 'aktif',
            'kendaraan_id' => $kendaraan->id,
            'pemasangan_ban_id' => $pemasangan->id
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan Pemasangan ban pada posisi Axle 3B');
    }

    public function inquerypemasangan3c(Request $request, $id)
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

        $pemasangan = Pemasangan_ban::findOrFail($request->pemasangan_ban_id);
        $kendaraan = Kendaraan::findOrFail($id);
        $ban = Ban::findOrFail($request->exel_3c);
        $ban->update([
            'km_pemasangan' => $request->km_pemasangan,
            'posisi_ban' => $request->posisi_3c,
            'status' => 'aktif',
            'kendaraan_id' => $kendaraan->id,
            'pemasangan_ban_id' => $pemasangan->id
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan Pemasangan ban pada posisi Axle 3C');
    }

    public function inquerypemasangan3d(Request $request, $id)
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

        $pemasangan = Pemasangan_ban::findOrFail($request->pemasangan_ban_id);
        $kendaraan = Kendaraan::findOrFail($id);
        $ban = Ban::findOrFail($request->exel_3d);
        $ban->update([
            'km_pemasangan' => $request->km_pemasangan,
            'posisi_ban' => $request->posisi_3d,
            'status' => 'aktif',
            'kendaraan_id' => $kendaraan->id,
            'pemasangan_ban_id' => $pemasangan->id

        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan Pemasangan ban pada posisi Axle 3D');
    }

    public function inquerypemasangan4a(Request $request, $id)
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

        $pemasangan = Pemasangan_ban::findOrFail($request->pemasangan_ban_id);
        $kendaraan = Kendaraan::findOrFail($id);
        $ban = Ban::findOrFail($request->exel_4a);
        $ban->update([
            'km_pemasangan' => $request->km_pemasangan,
            'posisi_ban' => $request->posisi_4a,
            'status' => 'aktif',
            'kendaraan_id' => $kendaraan->id,
            'pemasangan_ban_id' => $pemasangan->id
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan Pemasangan ban pada posisi Axle 4A');
    }

    public function inquerypemasangan4b(Request $request, $id)
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

        $pemasangan = Pemasangan_ban::findOrFail($request->pemasangan_ban_id);
        $kendaraan = Kendaraan::findOrFail($id);
        $ban = Ban::findOrFail($request->exel_4b);
        $ban->update([
            'km_pemasangan' => $request->km_pemasangan,
            'posisi_ban' => $request->posisi_4b,
            'status' => 'aktif',
            'kendaraan_id' => $kendaraan->id,
            'pemasangan_ban_id' => $pemasangan->id
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan Pemasangan ban pada posisi Axle 4B');
    }

    public function inquerypemasangan4c(Request $request, $id)
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

        $pemasangan = Pemasangan_ban::findOrFail($request->pemasangan_ban_id);
        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
        $kendaraan->update([
            'km' => $request->km_pemasangan
        ]);

        $kendaraan = Kendaraan::findOrFail($id);
        $ban = Ban::findOrFail($request->exel_4c);
        $ban->update([
            'km_pemasangan' => $request->km_pemasangan,
            'posisi_ban' => $request->posisi_4c,
            'status' => 'aktif',
            'kendaraan_id' => $kendaraan->id,
            'pemasangan_ban_id' => $pemasangan->id
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan Pemasangan ban pada posisi Axle 4C');
    }

    public function inquerypemasangan4d(Request $request, $id)
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

        $pemasangan = Pemasangan_ban::findOrFail($request->pemasangan_ban_id);
        $kendaraan = Kendaraan::findOrFail($id);
        $ban = Ban::findOrFail($request->exel_4d);
        $ban->update([
            'km_pemasangan' => $request->km_pemasangan,
            'posisi_ban' => $request->posisi_4d,
            'status' => 'aktif',
            'kendaraan_id' => $kendaraan->id,
            'pemasangan_ban_id' => $pemasangan->id
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan Pemasangan ban pada posisi Axle 4D');
    }

    public function inquerypemasangan5a(Request $request, $id)
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

        $pemasangan = Pemasangan_ban::findOrFail($request->pemasangan_ban_id);
        $kendaraan = Kendaraan::findOrFail($id);
        $ban = Ban::findOrFail($request->exel_5a);
        $ban->update([
            'km_pemasangan' => $request->km_pemasangan,
            'posisi_ban' => $request->posisi_5a,
            'status' => 'aktif',
            'kendaraan_id' => $kendaraan->id,
            'pemasangan_ban_id' => $pemasangan->id
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan Pemasangan ban pada posisi Axle 5A');
    }

    public function inquerypemasangan5b(Request $request, $id)
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

        $pemasangan = Pemasangan_ban::findOrFail($request->pemasangan_ban_id);
        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
        $kendaraan->update([
            'km' => $request->km_pemasangan
        ]);

        $kendaraan = Kendaraan::findOrFail($id);
        $ban = Ban::findOrFail($request->exel_5b);
        $ban->update([
            'km_pemasangan' => $request->km_pemasangan,
            'posisi_ban' => $request->posisi_5b,
            'status' => 'aktif',
            'kendaraan_id' => $kendaraan->id,
            'pemasangan_ban_id' => $pemasangan->id
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan Pemasangan ban pada posisi Axle 5B');
    }

    public function inquerypemasangan5c(Request $request, $id)
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

        $pemasangan = Pemasangan_ban::findOrFail($request->pemasangan_ban_id);
        $kendaraan = Kendaraan::findOrFail($id);
        $ban = Ban::findOrFail($request->exel_5c);
        $ban->update([
            'km_pemasangan' => $request->km_pemasangan,
            'posisi_ban' => $request->posisi_5c,
            'status' => 'aktif',
            'kendaraan_id' => $kendaraan->id,
            'pemasangan_ban_id' => $pemasangan->id
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan Pemasangan ban pada posisi Axle 5C');
    }

    public function inquerypemasangan5d(Request $request, $id)
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

        $pemasangan = Pemasangan_ban::findOrFail($request->pemasangan_ban_id);
        $kendaraan = Kendaraan::findOrFail($id);
        $ban = Ban::findOrFail($request->exel_5d);
        $ban->update([
            'km_pemasangan' => $request->km_pemasangan,
            'posisi_ban' => $request->posisi_5d,
            'status' => 'aktif',
            'kendaraan_id' => $kendaraan->id,
            'pemasangan_ban_id' => $pemasangan->id
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan Pemasangan ban pada posisi Axle 5D');
    }

    public function inquerypemasangan6a(Request $request, $id)
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

        $pemasangan = Pemasangan_ban::findOrFail($request->pemasangan_ban_id);
        $kendaraan = Kendaraan::findOrFail($id);
        $ban = Ban::findOrFail($request->exel_6a);
        $ban->update([
            'km_pemasangan' => $request->km_pemasangan,
            'posisi_ban' => $request->posisi_6a,
            'status' => 'aktif',
            'kendaraan_id' => $kendaraan->id,
            'pemasangan_ban_id' => $pemasangan->id
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan Pemasangan ban pada posisi Axle 6A');
    }

    public function inquerypemasangan6b(Request $request, $id)
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


        $pemasangan = Pemasangan_ban::findOrFail($request->pemasangan_ban_id);
        $kendaraan = Kendaraan::findOrFail($id);
        $ban = Ban::findOrFail($request->exel_6b);
        $ban->update([
            'km_pemasangan' => $request->km_pemasangan,
            'posisi_ban' => $request->posisi_6b,
            'status' => 'aktif',
            'kendaraan_id' => $kendaraan->id,
            'pemasangan_ban_id' => $pemasangan->id
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan Pemasangan ban pada posisi Axle 6B');
    }

    public function inquerypemasangan6c(Request $request, $id)
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

        $pemasangan = Pemasangan_ban::findOrFail($request->pemasangan_ban_id);
        $kendaraan = Kendaraan::findOrFail($id);
        $ban = Ban::findOrFail($request->exel_6c);
        $ban->update([
            'km_pemasangan' => $request->km_pemasangan,
            'posisi_ban' => $request->posisi_6c,
            'status' => 'aktif',
            'kendaraan_id' => $kendaraan->id,
            'pemasangan_ban_id' => $pemasangan->id
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan Pemasangan ban pada posisi Axle 6C');
    }

    public function inquerypemasangan6d(Request $request, $id)
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

        $pemasangan = Pemasangan_ban::findOrFail($request->pemasangan_ban_id);
        $kendaraan = Kendaraan::findOrFail($id);
        $ban = Ban::findOrFail($request->exel_6d);
        $ban->update([
            'km_pemasangan' => $request->km_pemasangan,
            'posisi_ban' => $request->posisi_6d,
            'status' => 'aktif',
            'kendaraan_id' => $kendaraan->id,
            'pemasangan_ban_id' => $pemasangan->id
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan Pemasangan ban pada posisi Axle 6D');
    }
}
