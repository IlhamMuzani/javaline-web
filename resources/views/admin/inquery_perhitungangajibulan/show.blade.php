<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GAJI KARYAWAN</title>
    <style>
        html,
        body {
            font-family: 'DOSVGA', Arial, Helvetica, sans-serif;
            /* font-family: 'DOSVGA', monospace; */
            color: black;

            margin-top: 5px;
            margin-right: 11px;
            margin-left: 11px;
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
            padding: 11px 20px;
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
            padding-top: 11px;
            text-align: center;
        }

        .separator span {
            display: inline-block;
            border-top: 1px solid black;
            width: 100%;
            position: relative;
            top: -11px;
        }
    </style>
</head>


<body style="margin-top: 0; padding: 0;">

    <div style="text-align: center; margin-top:11px">
        <span style="font-weight: bold; font-size: 16px;">REKAP GAJI TEKNISI JAVA LINE LOGISTICS(
            {{ \Carbon\Carbon::parse($cetakpdf->tanggal_awal)->locale('id')->isoFormat('D MMMM YYYY') }})</span>
        <div class="text">
            <p style="font-size: 14px">Periode:{{ $cetakpdf->periode_awal }}s/d {{ $cetakpdf->periode_akhir }}</p>
        </div>
    </div>

    <br>
    <table style="width: 100%; border-top: 1px solid #000;" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td" style="text-align: left; padding: 0px; font-size: 11px;  font-weight:bold; width:3%">
                NO.</td>
            <td class="td" style="text-align: left; padding: 0px; font-size: 11px;  font-weight:bold; width:11%">
                NAMA LENGKAP</td>
            <td class="td" style="text-align: right; padding: 0px; font-size: 11px;  font-weight:bold; ">
                GAPOK</td>
            <td class="td" style="text-align: right; padding: 0px; font-size: 11px;  font-weight:bold; ">
                UM</td>
            <td class="td" style="text-align: right; padding: 0px; font-size: 11px;  font-weight:bold; ">
                UH</td>
            <td class="td" style="text-align: right; padding: 0px; font-size: 11px;  font-weight:bold; ">
                HK</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 11px;  font-weight:bold;">
                LEMBUR <span> <br>(JAM)</span></td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 11px;  font-weight:bold;">
                STORING <span> <br>(JAM)</span></td>
            </td>
            <td class="td" style="text-align: right; font-size: 11px;  font-weight:bold;">GAJI KOTOR</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 11px; font-weight:bold; width:12%">
                KETERLAMBATAN <span> <br>(< 30 MNT) (> 30 MNT)</span></td>
            <td class="td" style="text-align: right; padding: 0px; font-size: 11px;  font-weight:bold; ">
                BPJS</td>
            <td class="td" style="text-align: right; padding: 0px; font-size: 11px;  font-weight:bold; ">
                ABSEN</td>
            <td class="td" style="text-align: right; padding: 0px; font-size: 11px;  font-weight:bold; ">
                PELUNASAN</td>
            <td class="td" style="text-align: right; font-size: 11px;  font-weight:bold; width:10%">GAJI BERSIH
            </td>
        </tr>
        <!-- Add horizontal line below this row -->
        <tr>
            <td colspan="14" style="padding: 0px;">
                <hr style="border: 0.5px solid; margin-top:3px; margin-bottom: 1px; padding: 0;">
                <hr style="border: 0.5px solid; margin-top:1px; margin-bottom: 1px; padding: 0;">
            </td>
        </tr>
        @php
            $Grandtotal = 0;
        @endphp
        @foreach ($details as $item)
            <tr>
                <td class="td" style="text-align: center; padding: 0px; font-size: 11px;">
                    {{ $loop->iteration }}
                </td>
                <td class="td" style="text-align: left; padding: 2px; font-size: 11px;">
                    {{ $item->nama_lengkap }}
                </td>
                <td class="td" style="text-align: right; padding: 0px; font-size: 11px;">
                    {{ number_format($item->gaji, 0, ',', '.') }}
                </td>
                <td class="td" style="text-align: right; padding: 0px; font-size: 11px;">
                    {{ number_format($item->uang_makan, 0, ',', '.') }}

                </td>
                <td class="td" style="text-align: right; padding: 0px; font-size: 11px;">
                    {{ number_format($item->uang_hadir, 0, ',', '.') }}

                </td>
                <td class="td" style="text-align: right; padding: 0px; font-size: 11px;">
                    {{ $item->hari_kerja }}
                </td>
                <td class="td" style="text-align: center; padding: 1px; font-size: 11px;">
                    {{ $item->lembur }} jam
                </td>
                <td class="td" style="text-align: center; padding: 1px; font-size: 11px;">
                    {{ $item->storing }} jam
                </td>
                <td class="td" style="text-align: right; padding-right: 7px; font-size: 11px;">
                    {{ number_format($item->gaji_kotor, 0, ',', '.') }}
                </td>
                <td class="td" style="text-align: center; padding: 1px; font-size: 11px;">
                    <span style="display: block; margin: 0 auto;">
                        {{ $item->kurangtigapuluh }} <span style="color: white">padding</span>
                        {{ $item->lebihtigapuluh }}
                    </span>
                </td>
                <td class="td" style="text-align: right; padding-right: 7px; font-size: 11px;">
                    {{ number_format($item->potongan_bpjs, 0, ',', '.') }}
                <td class="td" style="text-align: right; padding-right: 7px; font-size: 11px;">
                    {{ number_format($item->absen, 0, ',', '.') }}
                </td>
                <td class="td" style="text-align: right; padding-right: 7px; font-size: 11px;">
                    {{ number_format($item->pelunasan_kasbon, 0, ',', '.') }}
                </td>
                <td class="td" style="text-align: right; font-size: 11px;">
                    {{ number_format($item->gaji_bersih, 0, ',', '.') }}
                </td>
            </tr>
            @php
                $Grandtotal += $item->gaji_bersih;
            @endphp
        @endforeach
        <tr style="border-bottom: 1px solid black;">
            <td colspan="8" style="padding: 0px;"></td>
        </tr>
        <tr>
            <td colspan="13"
                style="text-align: right; font-weight: bold; margin-top:5px; margin-bottom:5px; font-size: 11px;">
                {{-- GRAND
                TOTAL --}}
            </td>
            <td class="td" style="text-align: right; font-weight: bold; font-size: 11px;">
                {{-- Rp. {{ number_format($Grandtotal, 0, ',', '.') }} --}}
            </td>
        </tr>
    </table>
    <br>
    <table width="100%">
        <tr>
            <td style="width:60%;">
                <table>
                    <tr>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 11px;">Uang Makan 1x</span>
                        </td>
                        <td class="info-column">
                            <span class="info-titik" style="font-size: 11px;"></span>
                        </td>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 11px;">10.000</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 11px;">Uang Hadir 1x</span>
                        </td>
                        <td class="info-column">
                            <span class="info-titik" style="font-size: 11px;"></span>
                        </td>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 11px;">5.000,00</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 11px;">Absen 1x</span>
                        </td>
                        <td class="info-column">
                            <span class="info-titik" style="font-size: 11px;"></span>
                        </td>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 11px;">5.000,00</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 11px;">Keterlambatan 1x</span>
                        </td>
                        <td class="info-column">
                            <span class="info-titik" style="font-size: 11px;"></span>
                        </td>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 11px;">(< 30 Menit=5.000,00) (> 30 Menit =
                                    15.000,00)</span>
                        </td>
                    </tr>
                </table>
            </td>
            <td style="width: 70%;">
                <table style="width: 100%;" cellpadding="2" cellspacing="0">
                    <tr>
                        <td colspan="5" style="text-align: left; padding: 0px; font-size: 11px;width: 30%;">
                            Total Gaji</td>
                        <td class="td" style="text-align: right; font-size: 11px;">
                            {{ number_format($cetakpdf->total_gaji, 2, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" style="text-align: left; padding: 0px; font-size: 11px;">Total Pelunasan
                        </td>
                        <td class="td" style="text-align: right; font-size: 11px;">
                            {{ number_format($cetakpdf->total_pelunasan, 2, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6" style="padding: 0px; position: relative;">
                            <hr style="border-top: 0.1px solid black; ">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" style="text-align: left; padding: 0px; font-size: 11px;width: 30%;">
                            Grand Total</td>
                        <td class="td" style="text-align: right; font-size: 11px; font-weight:bold">
                            Rp. {{ number_format($cetakpdf->grand_total, 2, ',', '.') }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <br>
</body>

<div class="container">
    <a href="{{ url('admin/inquery_perhitungangajibulanan') }}" class="blue-button">Kembali</a>
    <a href="{{ url('admin/perhitungan_gajibulanan/cetak-pdf/' . $cetakpdf->id) }}" class="blue-button">Cetak</a>
</div>

</html>
