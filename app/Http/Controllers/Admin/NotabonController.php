<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Deposit_driver;
use App\Models\Karyawan;
use App\Models\Notabon_ujs;
use App\Models\Saldo;
use Illuminate\Support\Facades\Validator;

class NotabonController extends Controller
{

    public function index()
    {
        $today = Carbon::today();

        $inquery = Notabon_ujs::whereDate('created_at', $today)
            ->orWhere(function ($query) use ($today) {
                $query->where('status', 'unpost')
                    ->whereDate('created_at', '<', $today);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $saldoTerakhir = Saldo::latest()->first();

        return view('admin.nota_bon.index', compact('inquery', 'saldoTerakhir'));
    }


    public function create()
    {
        $SopirAll = Karyawan::where('departemen_id', '2')->get();
        return view('admin.nota_bon.create', compact('SopirAll'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'karyawan_id' => 'required',
                'nominal' => 'required',
            ],
            [
                'karyawan_id.required' => 'Pilih sopir',
                'nominal.required' => 'Masukkan nominal',
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }

        $kode = $this->kode();

        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');

        $tanggal = Carbon::now()->format('Y-m-d');
        $penerimaan = Notabon_ujs::create(array_merge(
            $request->all(),
            [
                'kode_nota' => $this->kode(),
                'karyawan_id' => $request->karyawan_id,
                'user_id' => $request->user_id,
                'kode_driver' => $request->kode_driver,
                'nama_driver' => $request->nama_driver,
                'admin' => auth()->user()->karyawan->nama_lengkap,
                'nominal' => str_replace(',', '.', str_replace('.', '', $request->nominal)),
                'keterangan' => $request->keterangan,
                'tanggal' =>  $format_tanggal,
                'tanggal_awal' =>  $tanggal,
                'qrcode_nota' => 'https://javaline.id/nota-bon/' . $kode,
                'status' => 'unpost',
            ]
        ));
        return redirect('admin/nota-bon')->with('success', 'Berhasil menambahkan nota bon uang jalan');
    }

    public function kode()
    {
        // Mengambil kode terbaru dari database dengan awalan 'MP'
        $lastBarang = Notabon_ujs::where('kode_nota', 'like', 'KN%')->latest()->first();

        // Mendapatkan bulan dari tanggal kode terakhir
        $lastMonth = $lastBarang ? date('m', strtotime($lastBarang->created_at)) : null;
        $currentMonth = date('m');

        // Jika tidak ada kode sebelumnya atau bulan saat ini berbeda dari bulan kode terakhir
        if (!$lastBarang || $currentMonth != $lastMonth) {
            $num = 1; // Mulai dari 1 jika bulan berbeda
        } else {
            // Jika ada kode sebelumnya, ambil nomor terakhir
            $lastCode = $lastBarang->kode_nota;

            // Pisahkan kode menjadi bagian-bagian terpisah
            $parts = explode('/', $lastCode);
            $lastNum = end($parts); // Ambil bagian terakhir sebagai nomor terakhir
            $num = (int) $lastNum + 1; // Tambahkan 1 ke nomor terakhir
        }

        // Format nomor dengan leading zeros sebanyak 6 digit
        $formattedNum = sprintf("%06s", $num);

        // Awalan untuk kode baru
        $prefix = 'KN';
        $tahun = date('y');
        $tanggal = date('dm');

        // Buat kode baru dengan menggabungkan awalan, tanggal, tahun, dan nomor yang diformat
        $newCode = $prefix . "/" . $tanggal . $tahun . "/" . $formattedNum;

        // Kembalikan kode
        return $newCode;
    }
    public function show($id)
    {
        $cetakpdf = Notabon_ujs::where('id', $id)->first();
        return view('admin.nota_bon.show', compact('cetakpdf'));
    }

    public function cetakpdf($id)
    {
        $cetakpdf = Notabon_ujs::where('id', $id)->first();
        $pdf = PDF::loadView('admin.nota_bon.cetak_pdf', compact('cetakpdf'));
        $pdf->setPaper('letter', 'portrait');
        return $pdf->stream('Faktur_Deposit_Driver.pdf');
    }
}
