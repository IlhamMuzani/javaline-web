<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Pembelian_ban;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\Detail_gajikaryawan;
use App\Models\Detail_pembelianban;
use App\Models\Perhot;
use App\Models\Perhitungan_gajikaryawan;
use Twilio\Rest\Client;

class InqueryslipgajibulananController extends Controller
{
    public function index(Request $request)
    {
        $gajis = Perhitungan_gajikaryawan::where(['kategori' => 'Bulanan', 'status' => 'posting'])
            ->orderBy('id', 'DESC')
            ->get();

        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;
        $gaji = $request->perhitungan_gajikaryawan_id;
        $inquery = Detail_gajikaryawan::query(); // Inisialisasi query tanpa kondisi

        if ($gaji) {
            // Apply perhitungan_gajikaryawan_id filter if it's provided
            $inquery->where('perhitungan_gajikaryawan_id', $gaji);
        } else {
            // Jika tidak ada filter gaji yang diberikan, kosongkan hasilnya
            $inquery->where('perhitungan_gajikaryawan_id', ''); // Jika nilai kosong, tidak akan cocok dengan baris mana pun
        }

        // Filter status hanya jika ada filter status yang diberikan
        if ($status) {
            $inquery->where('status', $status);
        }

        $inquery->orderBy('id', 'DESC');
        $inquery = $inquery->get(); // Eksekusi query

        return view('admin.inquery_slipgajibulanan.index', compact('inquery', 'gajis'));
    }


    public function inquery_printslipgaji(Request $request)
    {
        // if (auth()->check() && auth()->user()->menu['laporan penerimaan kas kecil']) {

        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $query = Detail_gajikaryawan::where('kategori', 'Bulanan');

        if ($status == "posting") {
            $query->where('status', $status);
        } else {
            $query->where('status', 'posting');
        }

        if ($tanggal_awal && $tanggal_akhir) {
            $query->whereDate('tanggal_awal', '>=', $tanggal_awal)
                ->whereDate('tanggal_awal', '<=', $tanggal_akhir);
        }

        $inquery = $query->orderBy('id', 'DESC')->get();

        $pdf = PDF::loadView('admin.inquery_slipgajibulanan.print', compact('inquery'));
        return $pdf->stream('Laporan_Gaji_Karyawan.pdf');
        // } else {
        //     // tidak memiliki akses
        //     return back()->with('error', array('Anda tidak memiliki akses'));
        // }
    }

    public function cetak_gajibulananfilter(Request $request)
    {
        $selectedIds = explode(',', $request->input('ids'));

        // Mengambil faktur berdasarkan id yang dipilih
        $cetakpdfs = Detail_gajikaryawan::whereIn('id', $selectedIds)->orderBy('id', 'DESC')->get();

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('admin.inquery_slipgajibulanan.cetak_pdffilter', compact('cetakpdfs'));
        $pdf->setPaper('landscape');

        return $pdf->stream('SelectedGaji.pdf');
    }


public function downloadMultiplePDFs(Request $request)
{
    
}


    // public function whatsapp(Request $request)
    // {
    //     // Ambil ID yang dipilih dari permintaan
    //     $selectedIds = explode(',', $request->input('ids'));

    //     // Mengambil data berdasarkan ID yang dipilih
    //     $cetakpdfs = Detail_gajikaryawan::whereIn('id', $selectedIds)->orderBy('id', 'DESC')->get();

    //     // Membuat PDF
    //     $id = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.inquery_slipgajibulanan.cetak_pdffilter', compact('cetakpdfs'))->output();

    //     // Kirim PDF melalui WhatsApp
    //     $this->sendPDFWhatsApp($id);
    // }

    // protected function sendPDFWhatsApp($id)
    // {
    //     $sid = 'YourTwilioSID';
    //     $token = 'YourTwilioToken';
    //     $twilioNumber = 'YourTwilioNumber';
    //     $recipientNumber = 'RecipientPhoneNumber'; // Nomor WhatsApp penerima

    //     $client = new Client($sid, $token);

    //     $client->messages->create(
    //         "whatsapp:$recipientNumber",
    //         [
    //             'from' => "whatsapp:$twilioNumber",
    //             'body' => 'Ini adalah PDF yang Anda minta.',
    //             'MediaUrl' => 'data:application/pdf;base64,' . base64_encode($id),
    //         ]
    //     );
    // }
}