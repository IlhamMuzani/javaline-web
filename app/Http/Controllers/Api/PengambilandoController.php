<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use App\Models\Pengambilan_do;
use App\Models\Timer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PengambilandoController extends Controller
{

    // public function list($id)
    // {
    //     // Assuming you have a 'user_id' column in the Pengambilan_do table
    //     $pengambilando = Pengambilan_do::where([
    //         ['user_id', $id],
    //         ['status', '<>', 'unpost'] // Filter out entries where status is 'unpost'
    //     ])
    //         ->with(['kendaraan', 'rute_perjalanan', 'alamat_muat', 'alamat_bongkar', 'spk.pelanggan',])
    //         ->get();

    //     if ($pengambilando->isNotEmpty()) { // Check if there are any records
    //         return $this->response(TRUE, ['Berhasil menampilkan data'], $pengambilando);
    //     } else {
    //         return $this->response(FALSE, ['Gagal menampilkan data!']);
    //     }
    // }


    public function list($id)
    {
        // Assuming you have a 'user_id' column in the Pengambilan_do table
        $pengambilando = Pengambilan_do::where([
            ['user_id', $id],
            ['status', '<>', 'unpost'] // Filter out entries where status is 'unpost'
        ])
            ->with(['kendaraan', 'rute_perjalanan', 'alamat_muat', 'alamat_bongkar', 'spk.pelanggan'])
            ->orderByRaw("CASE WHEN status = 'selesai' THEN 1 ELSE 0 END") // Place 'selesai' status items at the bottom
            ->orderBy('id', 'asc') // Order by ID or another column to ensure consistent ordering
            ->get();

        if ($pengambilando->isNotEmpty()) { // Check if there are any records
            return $this->response(TRUE, ['Berhasil menampilkan data'], $pengambilando);
        } else {
            return $this->response(FALSE, ['Gagal menampilkan data!']);
        }
    }


    public function response($status, $message, $data = null)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ]);
    }

    public function kendaraan_search(Request $request)
    {
        $filterKeyword = $request->get('keyword');
        $kendaraan = Pengambilan_do::where([
            ['status', '!=', 'mobil'],
            ['no_kabin', 'LIKE', "%$filterKeyword%"],

        ])->get();

        if (count($kendaraan) > 0) {
            return $this->response(TRUE, array('Berhasil menampilkan data'), $kendaraan);
        } else {
            return $this->response(FALSE, array('Gagal menampilkan data!'));
        }
    }

    public function pengambilando_detail($id)
    {
        $pengambilan_do = Pengambilan_do::where('id', $id)
            ->with([
                'spk.pelanggan', // Include pelanggan through spk
                'user',
                'rute_perjalanan',
                'alamat_muat',
                'alamat_bongkar',
                'kendaraan'
            ])
            ->first();
        if ($pengambilan_do) {
            return response()->json([
                'status' => TRUE,
                'msg' => 'Berhasil',
                'pengambilan_do' => $pengambilan_do
            ]);
        } else {
            return response()->json([
                'status' => FALSE,
                'msg' => 'Error',
            ]);
        }
    }


    // public function konfirmasi(Request $request, $id)
    // {

    //     $pengambilan_do = Pengambilan_do::find($id);
    //     $proses = $pengambilan_do->update([
    //         'user_id' => $request->user_id,
    //         'status' => 'loading muat',
    //         'waktu_awal' => now()->format('Y-m-d H:i:s')
    //     ]);

    //     $waktuTungguMuat = $pengambilan_do->updated_at;
    //     $waktuPerjalananIsi = now();

    //     // Format "hari jam:menit:detik"
    //     $jarakWaktu = $waktuTungguMuat->diff($waktuPerjalananIsi)->format('%d %H:%I');

    //     $kendaraan = Kendaraan::find($pengambilan_do->kendaraan_id);

    //     $currentStatusPerjalanan = $kendaraan->status_perjalanan;
    //     $currentTimer = $kendaraan->waktu;


    //     $waktuTungguMuat = $pengambilan_do->updated_at;
    //     $waktuPerjalananIsi = now();

    //     // Format "hari jam:menit:detik"
    //     $jarakWaktu = $waktuTungguMuat->diff($waktuPerjalananIsi)->format('%d %H:%I');

    //     $kendaraan = Kendaraan::where('id', $pengambilan_do->kendaraan_id);
    //     $proses = $kendaraan->update([
    //         'user_id' => $request->user_id,
    //         'status_perjalanan' => 'Perjalanan Kosong',
    //         'timer' => $jarakWaktu
    //     ]);


    //     if ($proses) {
    //         return response()->json([
    //             'status' => true,
    //             'msg' => 'Status Selesai',
    //         ]);
    //     } else {
    //         $this->error('Gagal !');
    //     }
    // }


    public function konfirmasi(Request $request, $id)
    {

        $pengambilan_do = Pengambilan_do::find($id);
        $proses = $pengambilan_do->update([
            'user_id' => $request->user_id,
            'status' => 'loading muat',
            'waktu_awal' => now()->format('Y-m-d H:i:s')
        ]);


        $waktuTungguMuat = $pengambilan_do->updated_at;
        $waktuPerjalananIsi = now();

        // Format "hari jam:menit:detik"
        $jarakWaktu = $waktuTungguMuat->diff($waktuPerjalananIsi)->format('%d %H:%I');

        $kendaraan = Kendaraan::find($pengambilan_do->kendaraan_id);

        $currentStatusPerjalanan = $kendaraan->status_perjalanan;
        $currentTimer = $kendaraan->waktu;

        $proses = $kendaraan->update([
            'user_id' => $request->user_id,
            'km' => $request->km,
            'status_perjalanan' => 'Perjalanan Kosong',
            'timer' => $jarakWaktu,
            'waktu' => now()->format('Y-m-d H:i:s')
        ]);

        // Retrieve the updated status_perjalanan for status_akhir
        $updatedStatusPerjalanan = $kendaraan->fresh()->status_perjalanan;
        $currentTimestamp = now()->format('Y-m-d H:i:s');

        // Create Timer record with the old and new status, and the old timer
        Timer::create(array_merge(
            $request->all(),
            [
                'kendaraan_id' => $id,
                'status_awal' => $currentStatusPerjalanan,
                'status_akhir' => $updatedStatusPerjalanan,
                'timer_awal' => $currentTimer,
                'timer_akhir' => $currentTimestamp,
            ]
        ));


        if ($proses) {
            return response()->json([
                'status' => true,
                'msg' => 'Status loading muat',
            ]);
        } else {
            $this->error('Gagal !');
        }
    }

    public function batal_pengambilan(Request $request, $id)
    {
        $pengambilan_do = Pengambilan_do::find($id);

        $pengambilan_do = Pengambilan_do::where('id', $id);
        $proses = $pengambilan_do->update([
            'user_id' => $request->user_id,
            'status' => 'posting',
        ]);

        if ($proses) {
            return response()->json([
                'status' => true,
                'msg' => 'Status Berhasil',
            ]);
        } else {
            $this->error('Gagal !');
        }
    }

    public function bukti_foto(Request $request, $id)
    {
        // Temukan model berdasarkan ID
        $pengambilan_do = Pengambilan_do::find($id);

        if (!$pengambilan_do) {
            return response()->json([
                'status' => false,
                'msg' => 'Data tidak ditemukan.',
            ], 404);
        }

        // Validasi bahwa file diupload
        if (!$request->hasFile('gambar') || !$request->file('gambar')->isValid()) {
            return response()->json([
                'status' => false,
                'msg' => 'Gambar tidak valid.',
            ], 400);
        }

        // Menyiapkan nama file untuk penyimpanan
        $bukti = str_replace(' ', '', $request->file('gambar')->getClientOriginalName());
        $namabukti = 'pengambilan_do/' . date('mYdHs') . rand(1, 10) . '_' . $bukti;

        // Menyimpan file ke storage
        $request->file('gambar')->storeAs('public/uploads/', $namabukti);

        // Memperbarui entri di database
        $pengambilan_do->update([
            'gambar' => $namabukti,
            'status' => 'tunggu bongkar',
        ]);

        // Menghitung jarak waktu
        $waktuTungguMuat = $pengambilan_do->updated_at;
        $waktuPerjalananIsi = now();
        $jarakWaktu = $waktuTungguMuat->diff($waktuPerjalananIsi)->format('%d %H:%I');

        // Memperbarui kendaraan terkait
        $kendaraan = Kendaraan::find($pengambilan_do->kendaraan_id);

        $currentStatusPerjalanan = $kendaraan->status_perjalanan;
        $currentTimer = $kendaraan->waktu;

        if ($kendaraan) {
            $kendaraan->update([
                'status_perjalanan' => 'Perjalanan Isi',
                'timer' => $jarakWaktu,
                'waktu' => now()->format('Y-m-d H:i:s')
            ]);

            // Retrieve the updated status_perjalanan for status_akhir
            $updatedStatusPerjalanan = $kendaraan->fresh()->status_perjalanan;
            $currentTimestamp = now()->format('Y-m-d H:i:s');

            // Create Timer record with the old and new status, and the old timer
            Timer::create(array_merge(
                $request->all(),
                [
                    'kendaraan_id' => $id,
                    'status_awal' => $currentStatusPerjalanan,
                    'status_akhir' => $updatedStatusPerjalanan,
                    'timer_awal' => $currentTimer,
                    'timer_akhir' => $currentTimestamp,
                ]
            ));
        }

        return response()->json([
            'status' => true,
            'msg' => 'Status Tunggu Bongkar',
        ]);
    }

    public function bukti_fotoperbarui(Request $request, $id)
    {
        // Temukan model berdasarkan ID
        $pengambilan_do = Pengambilan_do::find($id);

        if (!$pengambilan_do) {
            return response()->json([
                'status' => false,
                'msg' => 'Data tidak ditemukan.',
            ], 404);
        }

        // Validasi bahwa file diupload
        if (!$request->hasFile('gambar') || !$request->file('gambar')->isValid()) {
            return response()->json([
                'status' => false,
                'msg' => 'Gambar tidak valid.',
            ], 400);
        }

        // Menyiapkan nama file untuk penyimpanan
        $bukti = str_replace(' ', '', $request->file('gambar')->getClientOriginalName());
        $namabukti = 'pengambilan_do/' . date('mYdHs') . rand(1, 10) . '_' . $bukti;

        // Menyimpan file ke storage
        $request->file('gambar')->storeAs('public/uploads/', $namabukti);

        // Memperbarui entri di database
        $pengambilan_do->update([
            'gambar' => $namabukti,
        ]);

        return response()->json([
            'status' => true,
            'msg' => 'Berhasil Memperbarui Foto Muat',
        ]);
    }


    public function bukti_fotoselesai(Request $request, $id)
    {
        // Temukan model berdasarkan ID
        $pengambilan_do = Pengambilan_do::find($id);

        if (!$pengambilan_do) {
            return response()->json([
                'status' => false,
                'msg' => 'Data tidak ditemukan.',
            ], 404);
        }

        // Validasi bahwa file diupload
        if (!$request->hasFile('bukti') || !$request->file('bukti')->isValid()) {
            return response()->json([
                'status' => false,
                'msg' => 'File bukti tidak valid.',
            ], 400);
        }

        // Menyiapkan nama file untuk penyimpanan
        $bukti = str_replace(' ', '', $request->file('bukti')->getClientOriginalName());
        $namabukti = 'bukti/' . date('mYdHs') . rand(1, 10) . '_' . $bukti;

        // Menyimpan file ke storage
        $request->file('bukti')->storeAs('public/uploads/', $namabukti);

        // Memperbarui entri di database
        $pengambilan_do->update([
            'bukti' => $namabukti,
            'status' => 'selesai',
            'waktu_akhir' => now()->format('Y-m-d H:i:s')

        ]);

        // Menghitung jarak waktu
        $waktuTungguMuat = $pengambilan_do->updated_at;
        $waktuPerjalananIsi = now();
        $jarakWaktu = $waktuTungguMuat->diff($waktuPerjalananIsi)->format('%d %H:%I');

        // Memperbarui kendaraan terkait
        $kendaraan = Kendaraan::find($pengambilan_do->kendaraan_id);
        $currentStatusPerjalanan = $kendaraan->status_perjalanan;
        $currentTimer = $kendaraan->waktu;

        if ($kendaraan) {
            $kendaraan->update([
                'status_perjalanan' => 'Kosong',
                'timer' => $jarakWaktu,
                'waktu' => now()->format('Y-m-d H:i:s')
            ]);

            // Retrieve the updated status_perjalanan for status_akhir
            $updatedStatusPerjalanan = $kendaraan->fresh()->status_perjalanan;
            $currentTimestamp = now()->format('Y-m-d H:i:s');

            // Create Timer record with the old and new status, and the old timer
            Timer::create(array_merge(
                $request->all(),
                [
                    'kendaraan_id' => $id,
                    'status_awal' => $currentStatusPerjalanan,
                    'status_akhir' => $updatedStatusPerjalanan,
                    'timer_awal' => $currentTimer,
                    'timer_akhir' => $currentTimestamp,
                ]
            ));
        }

        return response()->json([
            'status' => true,
            'msg' => 'Status Berhasil',
        ]);
    }

    public function bukti_fotoselesaiperbarui(Request $request, $id)
    {
        // Temukan model berdasarkan ID
        $pengambilan_do = Pengambilan_do::find($id);

        if (!$pengambilan_do) {
            return response()->json([
                'status' => false,
                'msg' => 'Data tidak ditemukan.',
            ], 404);
        }

        // Validasi bahwa file diupload
        if (!$request->hasFile('bukti') || !$request->file('bukti')->isValid()) {
            return response()->json([
                'status' => false,
                'msg' => 'File bukti tidak valid.',
            ], 400);
        }

        // Menyiapkan nama file untuk penyimpanan
        $bukti = str_replace(' ', '', $request->file('bukti')->getClientOriginalName());
        $namabukti = 'bukti/' . date('mYdHs') . rand(1, 10) . '_' . $bukti;

        // Menyimpan file ke storage
        $request->file('bukti')->storeAs('public/uploads/', $namabukti);

        // Memperbarui entri di database
        $pengambilan_do->update([
            'bukti' => $namabukti,
        ]);

        return response()->json([
            'status' => true,
            'msg' => 'Status Berhasil',
        ]);
    }

    public function konfirmasi_selesai(Request $request, $id)
    {
        // Temukan model berdasarkan ID
        $pengambilan_do = Pengambilan_do::find($id);

        if (!$pengambilan_do) {
            return response()->json([
                'status' => false,
                'msg' => 'Data tidak ditemukan.',
            ], 404);
        }

        // Validasi data request
        $request->validate([
            'user_id' => 'required|integer|exists:users,id', // Pastikan user_id valid
        ]);

        // Memperbarui entri di database
        $pengambilan_do->user_id = $request->user_id;
        $pengambilan_do->status = 'selesai';
        $proses = $pengambilan_do->save();

        if (!$proses) {
            return response()->json([
                'status' => false,
                'msg' => 'Gagal memperbarui data.',
            ], 500);
        }

        // Menghitung jarak waktu
        $waktuTungguMuat = $pengambilan_do->updated_at;
        $waktuPerjalananIsi = now();
        $jarakWaktu = $waktuTungguMuat->diff($waktuPerjalananIsi)->format('%d %H:%I');

        // Memperbarui kendaraan terkait
        $kendaraan = Kendaraan::find($pengambilan_do->kendaraan_id);

        $currentStatusPerjalanan = $kendaraan->status_perjalanan;
        $currentTimer = $kendaraan->waktu;

        if ($kendaraan) {
            $kendaraan->update([
                'status_perjalanan' => null,
                'timer' => $jarakWaktu,
                'waktu' => now()->format('Y-m-d H:i:s')
            ]);

            // Retrieve the updated status_perjalanan for status_akhir
            $updatedStatusPerjalanan = $kendaraan->fresh()->status_perjalanan;
            $currentTimestamp = now()->format('Y-m-d H:i:s');

            // Create Timer record with the old and new status, and the old timer
            Timer::create(array_merge(
                $request->all(),
                [
                    'kendaraan_id' => $id,
                    'status_awal' => $currentStatusPerjalanan,
                    'status_akhir' => $updatedStatusPerjalanan,
                    'timer_awal' => $currentTimer,
                    'timer_akhir' => $currentTimestamp,
                ]
            ));
        }

        return response()->json([
            'status' => true,
            'msg' => 'Status Berhasil',
        ]);
    }


    public function detail($id)
    {
        $kendaraans = Pengambilan_do::find($id);

        if ($kendaraans) {
            return $this->response(TRUE, array('Berhasil menampilkan data'), array($kendaraans));
        } else {
            return $this->response(FALSE, array('Gagal menampilkan data!'));
        }
    }

    public function update(Request $request, $id)
    {
        $km = Pengambilan_do::findOrFail($id);

        $validator = Validator::make(
            $request->all(),
            [
                'km' => 'required',
                'km' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($km) {
                        if ($value <= $km->km) {
                            $fail('Nilai Km harus lebih tinggi dari Km awal');
                        }
                    },
                ],
            ],
            [
                'km.required' => 'Masukkan nilai km',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return $this->response(FALSE, $error);
        }

        $data = Pengambilan_do::where('id', $id)->first();

        $reports = Pengambilan_do::where('id', $id)->update([
            'km' => $request->km,
        ]);

        if ($reports) {
            return $this->response(TRUE, array('Berhasil memperbarui data'));
        } else {
            return $this->response(FALSE, array('Gagal memperbarui data!'));
        }
    }
}