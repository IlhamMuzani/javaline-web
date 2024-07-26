<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice Ekspedisi</title>
    <style>
        html,
        body {
            font-family: 'DOSVGA', monospace;
            color: black;
            /* Gunakan Arial atau font sans-serif lainnya yang mudah dibaca */
            margin: 40px;
        }

        .container {
            display: flex;
            justify-content: space-between;
            margin-top: 7rem;
        }

        .blue-button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            text-decoration: none;
            top: 50%;
            border-radius: 5px;
            transform: translateY(-50%);
        }

        .info-column {
            /* padding-left: 5px; */
        }

        .info-titik {
            vertical-align: top;
        }

        /* tanda tangan  */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        .separator {
            padding-top: 14px;
            text-align: center;
        }

        .separator span {
            display: inline-block;
            border-top: 1px solid black;
            width: 100%;
            position: relative;
            top: -8px;
        }
    </style>
</head>

<body style="margin: 0; padding: 0;">
    <table width="100%">

        <tr>
            <!-- First column (Nama PT) -->
            <td style="width:0%;">
            </td>
            <td style="width: 70%; text-align: right;">
            </td>
        </tr>
    </table>

    <div id="logo-container">
        <img src="{{ asset('storage/uploads/user/logo.png') }}" alt="JAVA LINE LOGISTICS" width="150" height="50">
    </div>
    <div style="font-weight: bold; text-align: center">
        <span style="font-weight: bold; font-size: 21px;">BUKTI POTONG PAJAK</span>
        <br>
        <br>
    </div>
    <table cellpadding="2" cellspacing="0">
        <tr>
            <td class="text-align: left" style="font-size: 15px; display: block;">Kode Bukti</td>
            <td style="text-align: left; font-size: 15px;">
                <span class="content2">
                    : <span>{{ $cetakpdf->kode_bukti }}</span></span>
                <br>
            </td>
            <td class="text-align: left" style="font-size: 15px; margin-left: 5px; display: block;">Kategori
            </td>
            <td style="text-align: left; font-size: 15px;">
                <span class="content2">
                    <span>:{{ $cetakpdf->kategoris }}</span></span>
                <br>
            </td>
        </tr>
        <tr>
            <td class="text-align: left" style="font-size: 15px; display: block;">Tanggal</td>
            <td style="text-align: left; font-size: 15px;">
                <span class="content2">
                    :
                    <span>{{ \Carbon\Carbon::parse($cetakpdf->periode_awal)->locale('id')->isoFormat('D MMMM YYYY') }}</span></span>
                <br>
            </td>
            <td class="info-text-align: left" style="font-size: 15px; margin-left: 5px; display: block;">Nomor Bukti
            </td>
            <td style="text-align: left; font-size: 15px;">
                <span class="content2">
                    <span>:{{ $cetakpdf->nomor_faktur }}</span></span>
            </td>
        </tr>
    </table>
    <br>

    <hr style="border: 1px solid;">
    <table style="width: 100%;" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">No.</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">Kode Invoice</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">Tanggal</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">Nama Pelanggan</td>
            {{-- <td class="td" style="text-align: right; padding-right: 23px; font-size: 15px;">Pph</td> --}}
            <td class="td" style="text-align: right; padding-right: 23px; font-size: 15px;">Total</td>
        </tr>
        <!-- Add horizontal line below this row -->
        <tr>
            <td colspan="9" style="padding: 0px;">
                <hr style="border-top: 1px solid black; margin: 5px 0;">
            </td>
        </tr>
        @php
            $totalRuteSum = 0;
        @endphp
        @foreach ($details as $item)
            <tr>
                <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">
                    {{ $loop->iteration }} </td>
                <td class="td" style="text-align: center; padding: 2px; font-size: 15px;">
                    {{ $item->kode_tagihan }}
                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">
                    {{ $item->tanggal }}</td>
                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">
                    {{ $item->nama_pelanggan }}
                </td>
                {{-- <td class="td" style="text-align: right; padding-right: 23px; font-size: 15px;">
                    {{ number_format($item->pph, 2, ',', '.') }}
                </td> --}}
                <td class="td" style="text-align: right; padding-right: 23px; font-size: 15px;">
                    {{ number_format($item->total, 2, ',', '.') }}
                </td>
            </tr>
            @php
                $totalRuteSum += $item->total;
            @endphp
        @endforeach

        <tr>
        </tr>
    </table>
    <td colspan="5" style="padding: 0px; position: relative;">
        <hr
            style="border-top: 1px solid black; margin: 3px 0; display: inline-block; width: calc(100% - 25px); vertical-align: middle;">
        <span>
            +
        </span>
    </td>
    <table style="width: 100%; margin-bottom:0px;">
        <tr>
            <td>
            </td>
            <td style="text-align: right; padding: 0px;">
                <span class="info-item" style="font-size: 15px; padding-right:24px">
                    {{ number_format($totalRuteSum, 2, ',', '.') }}
                </span>
            </td>
        </tr>
    </table>
    <br>

    <table style="width: 100%;" cellpadding="2" cellspacing="0">
        <tr style="color: white">
            <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">No.</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">Nama Tarif</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">Harga</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">Qty</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">Satuan</td>
            <td class="td" style="text-align: right; padding-right: 23px; font-size: 15px;">Total</td>
        </tr>
        <!-- Add horizontal line below this row -->

        <tr>
            <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">

            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">

            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">

            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">

            </td>
            <td class="td" style="text-align: right; padding: 2px; font-size: 15px;">
                Dasar Pengenaan Pajak (DPP) :
            </td>
            <td class="td" style="text-align: right; padding-right: 23px; font-size: 15px;">
                {{ number_format($totalRuteSum, 2, ',', '.') }}
            </td>
        </tr>

        <tr>
            <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">

            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">

            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">

            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">

            </td>
            <td class="td" style="text-align: right; padding: 2px; font-size: 15px;">
                PPH23 = 2% * Dasar Pengenaan Pajak :
            </td>
            <td class="td" style="text-align: right; padding-right: 23px; font-size: 15px;">
                {{ number_format($totalRuteSum * 0.02, 2, ',', '.') }}
            </td>
        </tr>
        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td colspan="6"></td>
        </tr>
        <tr>
            <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">

            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">

            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">

            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">

            </td>
            <td class="td" style="text-align: right; padding: 2px; font-size: 15px;">
                Grand Total :
            </td>
            <td class="td" style="text-align: right; padding-right: 23px; font-size: 15px;">
                {{ number_format($totalRuteSum - $totalRuteSum * 0.02, 2, ',', '.') }}

            </td>
        </tr>

        <tr>
        </tr>
    </table>

    <?php
    function terbilang($angka)
    {
        $angka = abs($angka); // Pastikan angka selalu positif
        $bilangan = ['', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas'];
        $hasil = '';
        if ($angka < 12) {
            $hasil = $bilangan[$angka];
        } elseif ($angka < 20) {
            $hasil = terbilang($angka - 10) . ' Belas';
        } elseif ($angka < 100) {
            $hasil = terbilang($angka / 10) . ' Puluh ' . terbilang($angka % 10);
        } elseif ($angka < 200) {
            $hasil = 'Seratus ' . terbilang($angka - 100);
        } elseif ($angka < 1000) {
            $hasil = terbilang($angka / 100) . ' Ratus ' . terbilang($angka % 100);
        } elseif ($angka < 2000) {
            $hasil = 'Seribu ' . terbilang($angka - 1000);
        } elseif ($angka < 1000000) {
            $hasil = terbilang($angka / 1000) . ' Ribu ' . terbilang($angka % 1000);
        } elseif ($angka < 1000000000) {
            $hasil = terbilang($angka / 1000000) . ' Juta ' . terbilang($angka % 1000000);
        } elseif ($angka < 1000000000000) {
            $hasil = terbilang($angka / 1000000000) . ' Miliar ' . terbilang($angka % 1000000000);
        } elseif ($angka < 1000000000000000) {
            $hasil = terbilang($angka / 1000000000000) . ' Triliun ' . terbilang($angka % 1000000000000);
        }
        return $hasil;
    }
    ?>
    <div>
        Terbilang : <span style="font-weight: bold; font-style: italic;">
            ({{ terbilang($totalRuteSum) }}
            Rupiah)
        </span>
    </div>
    <br>
    <br>
    <br>
    <br>


    <table class="tdd" cellpadding="10" cellspacing="0" style="margin: 0 auto;">
        <tr>
            <td style="text-align: center;">
                <table style="margin: 0 auto;">
                    <tr style="text-align: center;">
                        <td class="label" style="min-height: 16px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="separator" colspan="2"><span></span></td>
                    </tr>
                    <tr style="text-align: center;">
                        <td class="label">Direksi</td>
                    </tr>
                </table>
            </td>
            <td style="text-align: center;">
                <table style="margin: 0 auto;">
                    <tr style="text-align: center;">
                        <td class="label">{{ auth()->user()->karyawan->nama_lengkap }}</td>
                    </tr>
                    <tr>
                        <td class="separator" colspan="2"><span></span></td>
                    </tr>
                    <tr style="text-align: center;">
                        <td class="label">Finance</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <br>
    {{-- <div class="form-group mb-3">
        @if ($tagihan_ekspedisi->gambar_bukti == null)
            <p class="mt-3">Tidak ada PDF yang diunggah.</p>
        @else
            <p class="mt-3">
                <a href="{{ asset('storage/uploads/' . $tagihan_ekspedisi->gambar_bukti) }}" target="_blank" style="font-weight:bold">Lihat
                    Bukti Potong Pajak</a>
            </p>
        @endif
    </div> --}}
</body>

<div class="container">
    <a href="{{ url('admin/inquery_buktipotongpajak') }}" class="blue-button">Kembali</a>
    <a href="{{ url('admin/bukti_potongpajak/cetak-pdf/' . $cetakpdf->id) }}" class="blue-button">Cetak</a>
</div>


</html>
