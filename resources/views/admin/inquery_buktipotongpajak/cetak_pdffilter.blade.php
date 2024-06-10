<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bukti Potong Pajak</title>
    <style>
        html,
        body {
            font-family: 'DOSVGA', Arial, Helvetica, sans-serif;
            /* font-family: 'DOSVGA', monospace; */
            color: black;

            margin-top: 5px;
            margin-right: 13px;
            margin-left: 13px;
            /* Margin kiri sebesar 20 piksel */

            /* font-weight: bold; */
            /* Atur ketebalan huruf menjadi bold */
        }

        .container {
            display: flex;
            justify-content: space-between;
            margin-top: 7rem;
        }

        .blue-button {
            padding: 13px 20px;
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
            padding-top: 13px;
            text-align: center;
        }

        .separator span {
            display: inline-block;
            border-top: 1px solid black;
            width: 100%;
            position: relative;
            top: -8px;
        }

        @media print {
            .header {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                z-index: 1000;
                /* Pastikan z-index lebih tinggi dari elemen lain yang mungkin ada */
            }

            /* Atur properti CSS untuk elemen header di sini */
            /* Misalnya, properti seperti ukuran font, warna teks, latar belakang, dll. */
        }

        .welcome-text {
            position: fixed;
            top: 2px;
            /* Atur jarak dari atas halaman */
            left: 9;
            /* Letakkan teks di kiri halaman */
            right: 9;
            /* Letakkan teks di kanan halaman */
            text-align: center;
            /* Pusatkan teks horizontal */
            font-size: 18px;
            font-weight: 700;
            /* Ganti dengan nilai yang lebih tinggi untuk bold */
            color: #000;
            /* Ganti dengan nilai hex yang lebih gelap */
            /* Warna teks */
            z-index: 999;
            /* Pastikan z-index lebih tinggi dari elemen lain */
        }
    </style>
</head>

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

@foreach ($buktis as $cetakpdf)

    <body style="margin-top: 20px; padding: 0;">
        <div id="logo-container">
            <img src="{{ public_path('storage/uploads/user/logo.png') }}" alt="JAVA LINE LOGISTICS" width="150"
                height="50">
        </div>
        <div style="font-weight: bold; text-align: center">
            <span style="font-weight: bold; font-size: 17px;">BUKTI POTONG PAJAK</span>
            <br>
            <br>
        </div>
        <table cellpadding="2" cellspacing="0">
            <tr>
                <td class="text-align: left" style="font-size: 13px; display: block;">Kode Bukti</td>
                <td style="text-align: left; font-size: 13px;">
                    <span class="content2">
                        : <span>{{ $cetakpdf->kode_bukti }}</span></span>
                    <br>
                </td>
                <td class="text-align: left" style="font-size: 13px; margin-left: 5px; display: block;">Kategori
                </td>
                <td style="text-align: left; font-size: 13px;">
                    <span class="content2">
                        <span>:{{ $cetakpdf->kategoris }}</span></span>
                    <br>
                </td>
            </tr>
            <tr>
                <td class="text-align: left" style="font-size: 13px; display: block;">Tanggal</td>
                <td style="text-align: left; font-size: 13px;">
                    <span class="content2">
                        :
                        <span>{{ \Carbon\Carbon::parse($cetakpdf->tanggal)->locale('id')->isoFormat('D MMMM YYYY') }}</span></span>
                    <br>
                </td>
                <td class="info-text-align: left" style="font-size: 13px; margin-left: 5px; display: block;">Nomor Bukti
                </td>
                <td style="text-align: left; font-size: 13px;">
                    <span class="content2">
                        <span>:{{ $cetakpdf->nomor_faktur }}</span></span>
                </td>
            </tr>
        </table>
        <br>
        <table style="width: 100%; border-top: 1px solid #000;" cellpadding="2" cellspacing="0">
            <tr>
                <td class="td" style="text-align: left; padding: 0px; font-size: 13px;  font-weight:bold;">
                    No.</td>
                <td class="td" style="text-align: left; padding: 0px; font-size: 13px;  font-weight:bold; ">
                    Kode Invoice</td>
                <td class="td" style="text-align: left; padding: 0px; font-size: 13px;  font-weight:bold; ">
                    Tanggal</td>
                <td class="td" style="text-align: left; padding: 0px; font-size: 13px;  font-weight:bold; ">
                    Nama Pelanggan</td>
                {{-- <td class="td" style="text-align: right; font-size: 13px;  font-weight:bold;">Pph</td> --}}
                <td class="td" style="text-align: right; font-size: 13px;  font-weight:bold;">Total</td>
            </tr>
            <!-- Add horizontal line below this row -->
            <tr>
                <td colspan="5" style="padding: 0px;">
                    <hr style="border: 0.5px solid; margin-top:3px; margin-bottom: 1px; padding: 0;">
                    <hr style="border: 0.5px solid; margin-top:1px; margin-bottom: 1px; padding: 0;">
                </td>
            </tr>
            @php
                $totalRuteSum = 0;
            @endphp
            @foreach ($cetakpdf->detail_bukti as $item)
                <tr>
                    <td class="td" style="text-align: left; padding: 0px; font-size: 13px;">
                        {{ $loop->iteration }}
                    </td>
                    <td class="td" style="text-align: left; padding: 0px; font-size: 13px;">
                        {{ $item->kode_tagihan }}
                    </td>
                    <td class="td" style="text-align: left; padding: 0px; font-size: 13px;">
                        {{ $item->tanggal }}
                    </td>
                    <td class="td" style="text-align: left; padding: 0px; font-size: 13px;">
                        {{ $item->nama_pelanggan }}
                    </td>
                    {{-- <td class="td" style="text-align: right; font-size: 13px;">
                    {{ number_format($item->pph, 2, ',', '.') }}
                </td> --}}
                    <td class="td" style="text-align: right; font-size: 13px;">
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
        <table style="width: 100%; border-top: 1px solid #000;">
            <tr>
                <td>

                </td>
                <td style="text-align: right;font-size: 13px;  font-weight:bold">
                    {{ number_format($totalRuteSum, 2, ',', '.') }}
                </td>
            </tr>
        </table>

        <table style="width: 100%;" cellpadding="2" cellspacing="0">
            <tr style="color: white">
                <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">No.</td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">Nama Tarif</td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">Harga</td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">Qty</td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">Satuan</td>
                <td class="td" style="text-align: right; padding-right: 23px; font-size: 13px;">Total</td>
            </tr>
            <!-- Add horizontal line below this row -->

            <tr style="color: white">
                <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">
                    .
                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">
                    .
                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">
                    .
                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">
                    .
                </td>
                <td class="td" style="text-align: right; padding: 2px; font-size: 13px;">
                    .
                </td>
                <td class="td" style="text-align: right; padding-right: 23px; font-size: 13px;">
                    .
                </td>
            </tr>

            <tr>
                <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">

                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">

                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">

                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">

                </td>
                <td class="td" style="text-align: right; padding: 2px; font-size: 13px;">
                    Dasar Pengenaan Pajak (DPP) :
                </td>
                <td class="td" style="text-align: right; font-size: 13px;  font-weight:bold">
                    {{ number_format($totalRuteSum, 2, ',', '.') }}
                </td>
            </tr>

            <tr>
                <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">

                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">

                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">

                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">

                </td>
                <td class="td" style="text-align: right; padding: 2px; font-size: 13px;">
                    PPH23 = 2% * Dasar Pengenaan Pajak :
                </td>
                <td class="td" style="text-align: right; font-size: 13px;  font-weight:bold">
                    {{ number_format($totalRuteSum * 0.02, 2, ',', '.') }}
                </td>
            </tr>

            <br>

            </tr>
            <tr style="border-bottom: 1px solid black;">
                <td colspan="4"></td>
            </tr>
            <tr>
                <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">

                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">

                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">

                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">

                </td>
                <td class="td" style="text-align: right; padding: 2px; font-size: 13px;">
                    Grand Total :
                </td>
                <td class="td" style="text-align: right; font-size: 13px; font-weight:bold">
                    {{ number_format($totalRuteSum - $totalRuteSum * 0.02, 2, ',', '.') }}

                </td>
            </tr>

            <tr>
            </tr>
        </table>


        <div style="font-size: 13px">
            Terbilang : <span style="font-weight: bold; font-style: italic; margin-right:250px ">
                ({{ terbilang($totalRuteSum) }}
                Rupiah)
            </span>
        </div>

        <br>
        <br>

        <div style=" margin-top:13px; margin-bottom:27px; font-size:13px">
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
                                <td class="label">{{ $cetakpdf->user->karyawan->nama_lengkap }}</td>
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
            <div style="text-align: right; font-size:13px">
                <span style="font-style: italic;">Printed Date
                    {{ \Carbon\Carbon::now()->format('Y-m-d H:i:s') }}</span>
            </div>
        </div>
        <br>
    </body>

</html>
@endforeach
