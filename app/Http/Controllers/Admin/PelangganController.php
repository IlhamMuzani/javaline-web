<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\Supplier;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Detail_pelanggan;
use App\Models\Karyawan;
use App\Models\Kelompok_pelanggan;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PelangganController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->check() && auth()->user()->menu['pelanggan']) {
            $query = Pelanggan::select('id', 'kode_pelanggan', 'nama_pell', 'nama_person', 'telp', 'qrcode_pelanggan');

            if ($request->has('keyword')) {
                $keyword = $request->input('keyword');
                $query->where(function ($q) use ($keyword) {
                    $q->where('kode_pelanggan', 'like', "%$keyword%")
                        ->orWhere('nama_pell', 'like', "%$keyword%")
                        ->orWhere('nama_person', 'like', "%$keyword%")
                        ->orWhere('telp', 'like', "%$keyword%");
                });
            }

            $pelanggans = $query->orderBy('created_at', 'desc')->paginate(10);

            return view('admin.pelanggan.index', compact('pelanggans'));
        } else {
            return back()->with('error', 'Anda tidak memiliki akses');
        }
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        // Ensure the query is properly formed
        $karyawans = Pelanggan::where('nama_pell', 'like', "%$keyword%")
            ->orWhere('kode_pelanggan', 'like', "%$keyword%")
            ->paginate(10);

        return response()->json($karyawans);
    }


    public function create()
    {
        if (auth()->check() && auth()->user()->menu['pelanggan']) {
            $kelompok_pelanggans = Kelompok_pelanggan::get();
            $karyawans = Karyawan::select('id', 'kode_karyawan', 'nama_lengkap', 'alamat', 'telp')
                ->where('departemen_id', '4')
                ->orderBy('nama_lengkap')
                ->get();

            return view('admin/pelanggan.create', compact('karyawans', 'kelompok_pelanggans'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function store(Request $request)
    {
        $validasi_pelanggan = Validator::make(
            $request->all(),
            [
                'nama_pell' => 'required',
                'alamat' => 'required',
                'karyawan_id' => 'required',
            ],
            [
                'nama_pell.required' => 'Masukkan nama pelanggan',
                'alamat.required' => 'Masukkan alamat',
                'karyawan_id.required' => 'Pilih Marketing',
            ]
        );

        $error_pelanggans = array();

        if ($validasi_pelanggan->fails()) {
            array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
        }

        $error_pesanans = array();
        $data_pembelians = collect();

        if ($request->has('nama_divisi')) {
            for ($i = 0; $i < count($request->nama_divisi); $i++) {
                $validasi_produk = Validator::make($request->all(), [
                    'nama_divisi.' . $i => 'required',
                    // 'jabatan_divisi.' . $i => 'required',
                    // 'telp_divisi.' . $i => 'required',
                    // 'fax_divisi.' . $i => 'required',
                    // 'hp_divisi.' . $i => 'required',
                    'alamat_divisi.' . $i => 'required',

                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Barang nomor " . $i + 1 . " belum dilengkapi!");
                }


                $nama_divisi = is_null($request->nama_divisi[$i]) ? '' : $request->nama_divisi[$i];
                $jabatan_divisi = is_null($request->jabatan_divisi[$i]) ? '' : $request->jabatan_divisi[$i];
                $telp_divisi = is_null($request->telp_divisi[$i]) ? '' : $request->telp_divisi[$i];
                $fax_divisi = is_null($request->fax_divisi[$i]) ? '' : $request->fax_divisi[$i];
                $hp_divisi = is_null($request->hp_divisi[$i]) ? '' : $request->hp_divisi[$i];
                $alamat_divisi = is_null($request->alamat_divisi[$i]) ? '' : $request->alamat_divisi[$i];

                $data_pembelians->push([
                    'nama_divisi' => $nama_divisi,
                    'jabatan_divisi' => $jabatan_divisi,
                    'telp_divisi' => $telp_divisi,
                    'fax_divisi' => $fax_divisi,
                    'hp_divisi' => $hp_divisi,
                    'alamat_divisi' => $alamat_divisi,
                ]);
            }
        } else {
        }

        if ($error_pelanggans || $error_pesanans) {
            return back()
                ->withInput()
                ->with('error_pelanggans', $error_pelanggans)
                ->with('error_pesanans', $error_pesanans)
                ->with('data_pembelians', $data_pembelians);
        }

        $kode = $this->kode();
        $pelanggan = Pelanggan::create(array_merge(
            $request->all(),
            [
                'kode_pelanggan' => $this->kode(),
                'kelompok_pelanggan_id' => $request->kelompok_pelanggan_id,
                'qrcode_pelanggan' => 'https://javaline.id/pelanggan/' . $kode,
                'tanggal_awal' => Carbon::now('Asia/Jakarta'),
            ]
        ));

        $transaksi_id = $pelanggan->id;

        if ($pelanggan) {
            foreach ($data_pembelians as $data_pesanan) {
                // Create a new Detailpembelianreturn
                Detail_pelanggan::create([
                    'pelanggan_id' => $pelanggan->id,
                    'nama_divisi' => $data_pesanan['nama_divisi'],
                    'jabatan_divisi' => $data_pesanan['jabatan_divisi'],
                    'telp_divisi' => $data_pesanan['telp_divisi'],
                    'fax_divisi' => $data_pesanan['fax_divisi'],
                    'hp_divisi' => $data_pesanan['hp_divisi'],
                    'alamat_divisi' => $data_pesanan['alamat_divisi'],
                ]);
            }
        }
        return redirect('admin/pelanggan')->with('success', 'Berhasil menambahkan Pelanggan');
    }

    public function cetakpdf($id)
    {
        $cetakpdf = Pelanggan::where('id', $id)->first();
        $html = view('admin/pelanggan.cetak_pdf', compact('cetakpdf'));

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');

        $dompdf->render();

        $dompdf->stream();
    }

    public function kode()
    {
        $lastBarang = Pelanggan::latest()->first();
        if (!$lastBarang) {
            $num = 1;
        } else {
            $lastCode = $lastBarang->kode_pelanggan;
            $num = (int) substr($lastCode, strlen('AP')) + 1;
        }
        $formattedNum = sprintf("%06s", $num);
        $prefix = 'AD';
        $newCode = $prefix . $formattedNum;
        return $newCode;
    }


    public function show($id)
    {
        if (auth()->check() && auth()->user()->menu['pelanggan']) {

            $pelanggan = Pelanggan::where('id', $id)->first();
            return view('admin/pelanggan.show', compact('pelanggan'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function edit($id)
    {
        if (auth()->check() && auth()->user()->menu['pelanggan']) {

            $pelanggan = Pelanggan::where('id', $id)->first();
            $karyawans = Karyawan::select('id', 'kode_karyawan', 'nama_lengkap', 'alamat', 'telp')
                ->where('departemen_id', '4')
                ->orderBy('nama_lengkap')
                ->get();
            $kelompok_pelanggans = Kelompok_pelanggan::get();
            $details  = Detail_pelanggan::where('pelanggan_id', $id)->get();
            return view('admin/pelanggan.update', compact('pelanggan', 'karyawans', 'kelompok_pelanggans', 'details'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function update(Request $request, $id)
    {
        $validasi_pelanggan = Validator::make(
            $request->all(),
            [
                'nama_pell' => 'required',
                'alamat' => 'required',
                'karyawan_id' => 'required',
            ],
            [
                'nama_pell.required' => 'Masukkan nama pelanggan',
                'alamat.required' => 'Masukkan alamat',
                'karyawan_id.required' => 'Pilih marketing',
            ]
        );

        $error_pelanggans = array();

        if ($validasi_pelanggan->fails()) {
            array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
        }


        $error_pesanans = array();
        $data_pembelians = collect();


        if ($request->has('nama_divisi')) {
            for ($i = 0; $i < count($request->nama_divisi); $i++) {
                $validasi_produk = Validator::make($request->all(), [
                    'nama_divisi.' . $i => 'required',
                    // 'jabatan_divisi.' . $i => 'required',
                    // 'telp_divisi.' . $i => 'required',
                    // 'fax_divisi.' . $i => 'required',
                    // 'hp_divisi.' . $i => 'required',
                    'alamat_divisi.' . $i => 'required',
                ]);

                if ($validasi_produk->fails()) {
                    array_push($error_pesanans, "Divisi nomor " . ($i + 1) . " belum dilengkapi!"); // Corrected the syntax for concatenation and indexing
                }

                $nama_divisi = is_null($request->nama_divisi[$i]) ? '' : $request->nama_divisi[$i];
                $detail_ids = is_null($request->detail_ids[$i]) ? '' : $request->detail_ids[$i];
                $jabatan_divisi = is_null($request->jabatan_divisi[$i]) ? '' : $request->jabatan_divisi[$i];
                $telp_divisi = is_null($request->telp_divisi[$i]) ? '' : $request->telp_divisi[$i];
                $fax_divisi = is_null($request->fax_divisi[$i]) ? '' : $request->fax_divisi[$i];
                $hp_divisi = is_null($request->hp_divisi[$i]) ? '' : $request->hp_divisi[$i];
                $alamat_divisi = is_null($request->alamat_divisi[$i]) ? '' : $request->alamat_divisi[$i];

                $data_pembelians->push([
                    'detail_id' => $request->detail_ids[$i] ?? null,
                    'nama_divisi' => $nama_divisi,
                    'detail_ids' => $detail_ids,
                    'jabatan_divisi' => $jabatan_divisi,
                    'telp_divisi' => $telp_divisi,
                    'fax_divisi' => $fax_divisi,
                    'hp_divisi' => $hp_divisi,
                    'alamat_divisi' => $alamat_divisi,
                ]);
            }
        }


        if ($error_pelanggans || $error_pesanans) {
            return back()
                ->withInput()
                ->with('error_pelanggans', $error_pelanggans)
                ->with('error_pesanans', $error_pesanans)
                ->with('data_pembelians', $data_pembelians);
        }


        $pelanggan = Pelanggan::findOrfail($id);


        $pelanggan->update([
            'nama_pell' => $request->nama_pell,
            'nama_alias' => $request->nama_alias,
            'karyawan_id' => $request->karyawan_id,
            'kelompok_pelanggan_id' => $request->kelompok_pelanggan_id,
            'npwp' => $request->npwp,
            'alamat' => $request->alamat,
            'nama_person' => $request->nama_person,
            'jabatan' => $request->jabatan,
            'telp' => $request->telp,
            'fax' => $request->fax,
            'hp' => $request->hp,
            'email' => $request->email,
        ]);

        $transaksi_id = $pelanggan->id;

        $detailIds = $request->input('detail_ids');

        foreach ($data_pembelians as $data_pesanan) {
            $detailId = $data_pesanan['detail_id'];

            if ($detailId) {
                // Update Detailpembelianreturn
                Detail_pelanggan::where('id', $detailId)->update([
                    'pelanggan_id' => $pelanggan->id,
                    'nama_divisi' =>  $data_pesanan['nama_divisi'],
                    'jabatan_divisi' => $data_pesanan['jabatan_divisi'],
                    'telp_divisi' => $data_pesanan['telp_divisi'],
                    'fax_divisi' => $data_pesanan['fax_divisi'],
                    'hp_divisi' => $data_pesanan['hp_divisi'],
                    'alamat_divisi' => $data_pesanan['alamat_divisi'],
                ]);
            } else {
                // Check if the detail already exists
                $existingDetail = Detail_pelanggan::where([
                    'pelanggan_id' => $pelanggan->id,
                    'nama_divisi' =>  $data_pesanan['nama_divisi'],
                    'alamat_divisi' => $data_pesanan['alamat_divisi'],
                ])->first();

                // If the detail does not exist, create a new one
                if (!$existingDetail) {
                    Detail_pelanggan::create([
                        'pelanggan_id' => $pelanggan->id,
                        'nama_divisi' =>  $data_pesanan['nama_divisi'],
                        'jabatan_divisi' => $data_pesanan['jabatan_divisi'],
                        'telp_divisi' => $data_pesanan['telp_divisi'],
                        'fax_divisi' => $data_pesanan['fax_divisi'],
                        'hp_divisi' => $data_pesanan['hp_divisi'],
                        'alamat_divisi' => $data_pesanan['alamat_divisi'],

                    ]);
                }
            }
        }

        return redirect('admin/pelanggan')->with('success', 'Berhasil memperbarui pelanggan');
    }

    public function destroy($id)
    {
        $pelanggan = Pelanggan::find($id);

        // Loop untuk menghapus setiap User terkait melalui Detail_pelanggan
        foreach ($pelanggan->detail_pelanggan as $detail) {
            $detail->user()->delete(); // Menghapus User terkait dengan setiap Detail_pelanggan
        }

        // Hapus semua Detail_pelanggan terkait
        $pelanggan->detail_pelanggan()->delete();

        // Hapus Pelanggan
        $pelanggan->delete();

        return redirect('admin/pelanggan')->with('success', 'Berhasil menghapus Pelanggan beserta data terkait');
    }

    public function delete_detailpelanggan($id)
    {
        $item = Detail_pelanggan::find($id);

        if ($item) {
            $item->delete();
            return response()->json(['message' => 'Data deleted successfully']);
        } else {
            return response()->json(['message' => 'Detail not found'], 404);
        }
    }
}