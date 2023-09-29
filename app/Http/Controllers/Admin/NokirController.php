<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Dompdf\Dompdf;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Nokir;
use App\Models\Ukuran;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use App\Models\Jenis_kendaraan;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class NokirController extends Controller
{
    public function index()
    {
        if (auth()->check() && auth()->user()->menu['nokir']) {
            
            $currentDate = now(); // Menggunakan Carbon untuk mendapatkan tanggal saat ini
            $oneMonthLater = $currentDate->copy()->addMonth(); // Menambahkan 1 bulan ke tanggal saat ini

            $nokirs1 = Nokir::where('status_kir', 'sudah perpanjang')
                ->whereDate('masa_berlaku', '<', $oneMonthLater)
                ->get();

            foreach ($nokirs1 as $nokir) {
                $nokir->update([
                    'status_kir' => 'belum perpanjang',
                    'status_notif' => false,
                ]);
            }

            $nokirs = Nokir::where(['status_kir' => 'sudah perpanjang'])->get();
            
            return view('admin/nokir.index', compact('nokirs'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function create()
    {
        if (auth()->check() && auth()->user()->menu['nokir']) {

            $jenis_kendaraans = Jenis_kendaraan::all();
            $kendaraans = Kendaraan::all();
            $ukurans = Ukuran::all();
            return view('admin/nokir.create', compact('kendaraans', 'jenis_kendaraans', 'ukurans'));
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
                'kendaraan_id' => 'required',
                'jenis_kendaraan' => 'required',
                'ukuran_ban' => 'required',
                'nama_pemilik' => 'required',
                'alamat' => 'required',
                'nomor_uji_kendaraan' => 'required',
                'nomor_sertifikat_kendaraan' => 'required',
                'tanggal_sertifikat' => 'required',
                // 'nopol' => 'required',
                // 'no_rangka' => 'required',
                // 'no_mesin' => 'required',
                'gambar_depan' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
                'gambar_belakang' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
                'gambar_kanan' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
                'gambar_kiri' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
                'merek_kendaraan' => 'required',
                'tahun_kendaraan' => 'required',
                'bahan_bakar' => 'required',
                'isi_silinder' => 'required',
                'daya_motor' => 'required',
                'konfigurasi_sumbu' => 'required',
                'berat_kosongkendaraan' => 'required',
                'lebar' => 'required',
                'tinggi' => 'required',
                'julur_depan' => 'required',
                'julur_belakang' => 'required',
                // 'sumbu_1_2' => 'required',
                // 'sumbu_2_3' => 'required',
                // 'sumbu_3_4' => 'required',
                'dimensi_bakmuatan' => 'required',
                'jbb' => 'required',
                'jbi' => 'required',
                'daya_angkutorang' => 'required',
                'kelas_jalan' => 'required',
                // 'rem_utama' => 'required',
                // 'emisi' => 'required',
                'keterangan' => 'required',
                'masa_berlaku' => 'required',
                'nama_petugas_penguji' => 'required',
                'nrp_petugas_penguji' => 'required',
                'nama_kepala_dinas' => 'required',
                'pangkat_kepala_dinas' => 'required',
                'nip_kepala_dinas' => 'required',
                'unit_pelaksanaan_teknis' => 'required',
                'nama_direktur' => 'required',
                'pangkat_direktur' => 'required',
                'nip_direktur' => 'required',
            ],
            [
                'nama_pemilik.required' => 'Masukkan nama pemilik',
                'alamat.required' => 'Masukkan alamat',
                'nomor_uji_kendaraan.required' => 'Masukkan no uji',
                'kendaraan_id.required' => 'Pilih no kabin',
                'tanggal_sertifikat.required' => 'Masukkan tanggal sertifikat registrasi',
                'nomor_sertifikat_kendaraan.required' => 'Masukkan no sertifikat kendaraan',
                // 'nopol.required' => 'Masukkan no registrasi kendaraan',
                // 'no_rangka.required' => 'Masukkan no rangka kendaraan',
                // 'no_mesin.required' => 'Masukkan no motor penggerak',
                'gambar_depan.image' => 'Gambar yang dimasukan salah!',
                'gambar_belakang.image' => 'Gambar yang dimasukan salah!',
                'gambar_kanan.image' => 'Gambar yang dimasukan salah!',
                'gambar_kiri.image' => 'Gambar yang dimasukan salah!',
                'jenis_kendaraan.required' => 'Masukkan jenis kendaraan',
                'merek_kendaraan.required' => 'Masukkan merek kendaraan',
                'tahun_kendaraan.required' => 'Pilih tahun kendaraan',
                'bahan_bakar.required' => 'Pilih bahan bakar',
                'isi_silinder.required' => 'Masukkan isi silinder',
                'daya_motor.required' => 'Masukkan daya motor',
                'ukuran_ban.required' => 'Masukkan ukuran ban',
                'konfigurasi_sumbu.required' => 'Masukkan konfigurasi sumbu',
                'berat_kosongkendaraan.required' => 'Masukkan berat kosong kendaraan',
                'panjang.required' => 'Masukkan panjang',
                'lebar.required' => 'Masukkan lebar',
                'tinggi.required' => 'Masukkan tinggi',
                'julur_depan.required' => 'Masukkan julur depan',
                'julur_belakang.required' => 'Masukkan julur belakang',
                // 'sumbu_1_2.required' => 'Masukkan sumbu I -> II',
                // 'sumbu_2_3.required' => 'Masukkan sumbu II -> III',
                // 'sumbu_3_4.required' => 'Masukkan sumbu III -> IV',
                'dimensi_bakmuatan.required' => 'Masukkan dimensi bak muatan',
                'jbb.required' => 'Masukkan jbb',
                'jbi.required' => 'Masukkan jbi',
                'daya_angkutorang.required' => 'Masukkan daya angkut orang',
                'kelas_jalan.required' => 'Masukkan kelas jalan',
                'keterangan.required' => 'Masukkan keterangan',
                'masa_berlaku.required' => 'Masukkan masa berlaku',
                'nama_petugas_penguji.required' => 'Masukkan nama petugas penguji',
                'nrp_petugas_penguji.required' => 'Masukkan nrp petugas penguji',
                'nama_kepala_dinas.required' => 'Masukkan nama kepala dinas',
                'pangkat_kepala_dinas.required' => 'Masukkan pangkat kepala dinas',
                'nip_kepala_dinas.required' => 'Masukkan nip kepala dinas',
                'unit_pelaksanaan_teknis.required' => 'Masukkan unit pelaksanaan',
                'nama_direktur.required' => 'Masukkan nama direktur',
                'pangkat_direktur.required' => 'Masukkan pangkat direktur',
                'nip_direktur.required' => 'Masukkan nip direktur',
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }

        if ($request->gambar_depan) {
            $gambar = str_replace(' ', '', $request->gambar_depan->getClientOriginalName());
            $namaGambar = 'gambar_depan/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar_depan->storeAs('public/uploads/', $namaGambar);
        } else {
            $namaGambar = 'null';
        }

        if ($request->gambar_belakang) {
            $gambar = str_replace(' ', '', $request->gambar_belakang->getClientOriginalName());
            $namaGambar2 = 'gambar_belakang/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar_belakang->storeAs('public/uploads/', $namaGambar2);
        } else {
            $namaGambar2 = 'null';
        }

        if ($request->gambar_kanan) {
            $gambar = str_replace(' ', '', $request->gambar_kanan->getClientOriginalName());
            $namaGambar3 = 'gambar_kanan/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar_kanan->storeAs('public/uploads/', $namaGambar3);
        } else {
            $namaGambar3 = 'null';
        }

        if ($request->gambar_kiri) {
            $gambar = str_replace(' ', '', $request->gambar_kiri->getClientOriginalName());
            $namaGambar4 = 'gambar_depan/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar_kiri->storeAs('public/uploads/', $namaGambar4);
        } else {
            $namaGambar4 = 'null';
        }

        $kode = $this->kode();

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        Nokir::create(array_merge(
            $request->all(),
            [
                'gambar_depan' => $namaGambar,
                'gambar_belakang' => $namaGambar2,
                'gambar_kanan' => $namaGambar3,
                'gambar_kiri' => $namaGambar4,
                // 'gambar_logo' => 'gambar_logo/dinas_perhubungan.png',
                'kode_kir' => $this->kode(),
                'qrcode_kir' => 'https://javaline.id/nokir/' . $kode,
                'tanggal_awal' => Carbon::now('Asia/Jakarta'),
                'status_kir' => 'sudah perpanjang',
                // 'qrcode_kir' => 'http://192.168.1.46/javaline/nokir/' . $kode
            ],
        ));

        return redirect('admin/nokir')->with('success', 'Berhasil menambahkan no. kir');
    }

    public function kode()
    {

        $nokir = Nokir::all();
        if ($nokir->isEmpty()) {
            $num = "000001";
        } else {
            $id = Nokir::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }

        $data = 'AK';
        $kode_nokir = $data . $num;
        return $kode_nokir;
    }

    public function kendaraan($id)
    {
        $nokir = Kendaraan::where('id', $id)->first();

        return json_decode($nokir);
    }

    public function edit($id)
    {
        if (auth()->check() && auth()->user()->menu['nokir']) {

            $nokir = Nokir::where('id', $id)->first();
            $jenis_kendaraans = Jenis_kendaraan::all();
            $kendaraans = Kendaraan::all();
            $ukurans = Ukuran::all();
            return view('admin/nokir.update', compact('nokir', 'jenis_kendaraans', 'kendaraans', 'ukurans'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'kendaraan_id' => 'required',
                'jenis_kendaraan' => 'required',
                'ukuran_ban' => 'required',
                'nama_pemilik' => 'required',
                'alamat' => 'required',
                'nomor_uji_kendaraan' => 'required',
                'nomor_sertifikat_kendaraan' => 'required',
                'tanggal_sertifikat' => 'required',
                // 'nopol' => 'required',
                // 'no_rangka' => 'required',
                // 'no_mesin' => 'required',
                'gambar_depan' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
                'gambar_belakang' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
                'gambar_kanan' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
                'gambar_kiri' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
                'merek_kendaraan' => 'required',
                'tahun_kendaraan' => 'required',
                'bahan_bakar' => 'required',
                'isi_silinder' => 'required',
                'daya_motor' => 'required',
                'konfigurasi_sumbu' => 'required',
                'berat_kosongkendaraan' => 'required',
                'lebar' => 'required',
                'tinggi' => 'required',
                'julur_depan' => 'required',
                'julur_belakang' => 'required',
                // 'sumbu_1_2' => 'required',
                // 'sumbu_2_3' => 'required',
                // 'sumbu_3_4' => 'required',
                'dimensi_bakmuatan' => 'required',
                'jbb' => 'required',
                'jbi' => 'required',
                'daya_angkutorang' => 'required',
                'kelas_jalan' => 'required',
                // 'rem_utama' => 'required',
                // 'emisi' => 'required',
                'keterangan' => 'required',
                'masa_berlaku' => 'required',
                'nama_petugas_penguji' => 'required',
                'nrp_petugas_penguji' => 'required',
                'nama_kepala_dinas' => 'required',
                'pangkat_kepala_dinas' => 'required',
                'nip_kepala_dinas' => 'required',
                'unit_pelaksanaan_teknis' => 'required',
                'nama_direktur' => 'required',
                'pangkat_direktur' => 'required',
                'nip_direktur' => 'required',
            ],
            [
                'nama_pemilik.required' => 'Masukkan nama pemilik',
                'alamat.required' => 'Masukkan alamat',
                'nomor_uji_kendaraan.required' => 'Masukkan no uji',
                'nomor_sertifikat_kendaraan.required' => 'Masukkan no sertifikat kendaraan',
                'kendaraan_id.required' => 'Pilih no kabin',
                'tanggal_sertifikat.required' => 'Masukkan tanggal sertifikat registrasi',
                // 'nopol.required' => 'Masukkan no registrasi kendaraan',
                // 'no_rangka.required' => 'Masukkan no rangka kendaraan',
                // 'no_mesin.required' => 'Masukkan no motor penggerak',
                'gambar_depan.image' => 'Gambar yang dimasukan salah!',
                'gambar_belakang.image' => 'Gambar yang dimasukan salah!',
                'gambar_kanan.image' => 'Gambar yang dimasukan salah!',
                'gambar_kiri.image' => 'Gambar yang dimasukan salah!',
                'jenis_kendaraan.required' => 'Masukkan jenis kendaraan',
                'merek_kendaraan.required' => 'Masukkan merek kendaraan',
                'tahun_kendaraan.required' => 'Pilih tahun kendaraan',
                'bahan_bakar.required' => 'Pilih bahan bakar',
                'isi_silinder.required' => 'Masukkan isi silinder',
                'daya_motor.required' => 'Masukkan daya motor',
                'ukuran_ban.required' => 'Masukkan ukuran ban',
                'konfigurasi_sumbu.required' => 'Masukkan konfigurasi sumbu',
                'berat_kosongkendaraan.required' => 'Masukkan berat kosong kendaraan',
                'panjang.required' => 'Masukkan panjang',
                'lebar.required' => 'Masukkan lebar',
                'tinggi.required' => 'Masukkan tinggi',
                'julur_depan.required' => 'Masukkan julur depan',
                'julur_belakang.required' => 'Masukkan julur belakang',
                // 'sumbu_1_2.required' => 'Masukkan sumbu I -> II',
                // 'sumbu_2_3.required' => 'Masukkan sumbu II -> III',
                // 'sumbu_3_4.required' => 'Masukkan sumbu III -> IV',
                'dimensi_bakmuatan.required' => 'Masukkan dimensi bak muatan',
                'jbb.required' => 'Masukkan jbb',
                'jbi.required' => 'Masukkan jbi',
                'daya_angkutorang.required' => 'Masukkan daya angkut orang',
                'kelas_jalan.required' => 'Masukkan kelas jalan',
                'keterangan.required' => 'Masukkan keterangan',
                'masa_berlaku.required' => 'Masukkan masa berlaku',
                'nama_petugas_penguji.required' => 'Masukkan nama petugas penguji',
                'nrp_petugas_penguji.required' => 'Masukkan nrp petugas penguji',
                'nama_kepala_dinas.required' => 'Masukkan nama kepala dinas',
                'pangkat_kepala_dinas.required' => 'Masukkan pangkat kepala dinas',
                'nip_kepala_dinas.required' => 'Masukkan nip kepala dinas',
                'unit_pelaksanaan_teknis.required' => 'Masukkan unit pelaksanaan',
                'nama_direktur.required' => 'Masukkan nama direktur',
                'pangkat_direktur.required' => 'Masukkan pangkat direktur',
                'nip_direktur.required' => 'Masukkan nip direktur',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $nokir = Nokir::findOrFail($id);

        if ($request->gambar_depan) {
            Storage::disk('local')->delete('public/uploads/' . $nokir->gambar_depan);
            $gambar = str_replace(' ', '', $request->gambar_depan->getClientOriginalName());
            $namaGambar = 'gambar_depan/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar_depan->storeAs('public/uploads/', $namaGambar);
        } else {
            $namaGambar = $nokir->gambar_depan;
        }

        if ($request->gambar_belakang) {
            Storage::disk('local')->delete('public/uploads/' . $nokir->gambar_belakang);
            $gambar = str_replace(' ', '', $request->gambar_belakang->getClientOriginalName());
            $namaGambar2 = 'gambar_belakang/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar_belakang->storeAs('public/uploads/', $namaGambar2);
        } else {
            $namaGambar2 = $nokir->gambar_belakang;
        }

        if ($request->gambar_kanan) {
            Storage::disk('local')->delete('public/uploads/' . $nokir->gambar_kanan);
            $gambar = str_replace(' ', '', $request->gambar_kanan->getClientOriginalName());
            $namaGambar3 = 'gambar_kanan/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar_kanan->storeAs('public/uploads/', $namaGambar3);
        } else {
            $namaGambar3 = $nokir->gambar_kanan;
        }

        if ($request->gambar_kiri) {
            Storage::disk('local')->delete('public/uploads/' . $nokir->gambar_kiri);
            $gambar = str_replace(' ', '', $request->gambar_kiri->getClientOriginalName());
            $namaGambar4 = 'gambar_kiri/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar_kiri->storeAs('public/uploads/', $namaGambar4);
        } else {
            $namaGambar4 = $nokir->gambar_kiri;
        }

        Nokir::where('id', $id)->update([
            'gambar_depan' => $namaGambar,
            'gambar_belakang' => $namaGambar2,
            'gambar_kanan' => $namaGambar3,
            'gambar_kiri' => $namaGambar4,
            'kendaraan_id' => $request->kendaraan_id,
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'ukuran_ban' => $request->ukuran_ban,
            'nama_pemilik' => $request->nama_pemilik,
            'alamat' => $request->alamat,
            'nomor_uji_kendaraan' => $request->nomor_uji_kendaraan,
            'nomor_sertifikat_kendaraan' => $request->nomor_sertifikat_kendaraan,
            'tanggal_sertifikat' => $request->tanggal_sertifikat,
            'merek_kendaraan' => $request->merek_kendaraan,
            'tahun_kendaraan' => $request->tahun_kendaraan,
            'bahan_bakar' => $request->bahan_bakar,
            'isi_silinder' => $request->isi_silinder,
            'daya_motor' => $request->daya_motor,
            'konfigurasi_sumbu' => $request->konfigurasi_sumbu,
            'berat_kosongkendaraan' => $request->berat_kosongkendaraan,
            'lebar' => $request->lebar,
            'tinggi' => $request->tinggi,
            'panjang' => $request->panjang,
            'julur_depan' => $request->julur_depan,
            'julur_belakang' => $request->julur_belakang,
            'dimensi_bakmuatan' => $request->dimensi_bakmuatan,
            'jbb' => $request->jbb,
            'jbi' => $request->jbi,
            'sumbu_1_2' => $request->sumbu_1_2,
            'sumbu_2_3' => $request->sumbu_2_3,
            'sumbu_3_4' => $request->sumbu_3_4,
            'daya_angkutorang' => $request->daya_angkutorang,
            'kelas_jalan' => $request->kelas_jalan,
            'keterangan' => $request->keterangan,
            'masa_berlaku' => $request->masa_berlaku,
            'nama_petugas_penguji' => $request->nama_petugas_penguji,
            'nrp_petugas_penguji' => $request->nrp_petugas_penguji,
            'nama_kepala_dinas' => $request->nama_kepala_dinas,
            'pangkat_kepala_dinas' => $request->pangkat_kepala_dinas,
            'nip_kepala_dinas' => $request->nip_kepala_dinas,
            'unit_pelaksanaan_teknis' => $request->unit_pelaksanaan_teknis,
            'nama_direktur' => $request->nama_direktur,
            'pangkat_direktur' => $request->pangkat_direktur,
            'nip_direktur' => $request->nip_direktur,
            'tanggal_awal' => Carbon::now('Asia/Jakarta'),
        ]);

        return redirect('admin/nokir')->with('success', 'Berhasil memperbarui No. Kir');
    }

    // public function cetakpdf($id)
    // {
    //     $cetakpdf = Nokir::where('id', $id)->first();
    //     $html = view('admin/nokir.cetak_pdf', compact('cetakpdf'));

    //     $dompdf = new Dompdf();
    //     $dompdf->loadHtml($html);
    //     $dompdf->setPaper('A4', 'landscape');

    //     $dompdf->render();

    //     $dompdf->stream();
    // }

    public function cetakpdfnokir($id)
    {

        $nokir = Nokir::where('id', $id)->first();

        $pdf = PDF::loadView('admin/nokir.cetak_pdfnokir', compact('nokir'));
        $pdf->setPaper('letter', 'portrait');

        return $pdf->stream();
    }


    public function destroy($id)
    {
        $nokir = Nokir::find($id);
        $nokir->kendaraan()->delete();
        $nokir->delete();

        return redirect('admin/nokir')->with('success', 'Berhasil menghapus No. Kir');
    }

    public function show($id)
    {
        if (auth()->check() && auth()->user()->menu['nokir']) {

            $nokir = Nokir::where('id', $id)->first();
            return view('admin/nokir.show', compact('nokir'));
        } else {
            // tidak memiliki akses
            return back()->with('error', array('Anda tidak memiliki akses'));
        }
    }
}