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

            margin-top: 0px;
            margin-right: 10px;
            margin-left: 10px;
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
            padding-top: 10px;
            text-align: center;
        }

        .separator span {
            display: inline-block;
            border-top: 1px solid black;
            width: 100%;
            position: relative;
            top: -10px;
        }
    </style>
</head>


<body style="margin-top: 90; padding: 0;">
    <div class="welcome-text">
        <div class="header">
            <table width="100%">
                <tr>
                    <td style="width:20%;">
                        <div style="text-align: left;">
                            <img src="{{ asset('storage/uploads/user/logo.png') }}" alt="JAVA LINE LOGISTICS"
                                width="150" height="50">
                        </div>
                    </td>
                    <td style="width: 95%; text-align: left;">
                        <div style="text-align: center; margin-top:20px">
                            <span style="font-weight: bold; font-size: 15px;">REKAP GAJI KARYAWAN JAVA LINE LOGISTICS (
                                {{ \Carbon\Carbon::parse($cetakpdf->tanggal_awal)->locale('id')->isoFormat('D MMMM YYYY') }})</span>
                            <div class="text">
                                <p style="font-size: 13px">Periode:{{ $cetakpdf->periode_awal }}s/d
                                    {{ $cetakpdf->periode_akhir }}</p>
                            </div>
                        </div>
                    </td>
                    <td style="width: 10%; text-align: left; color:white">
                        <div style="text-align: center;">
                            <span style="font-weight: bold; font-size: 16px;">.</span>
                            <br>
                            <span style=" font-size: 15px;">..................................
                                {{-- <br>Tegal 52411 --}}
                            </span>
                            <br>
                            <span style=" font-size: 15px;">.</span>
                            <br>
                            <span style=" font-size: 15px;">.</span>
                        </div>
                    </td>
                </tr>
            </table>
            {{-- <hr style="border: 0.5px solid; margin-top:3px; margin-bottom: 1px; padding: 0;"> --}}
        </div>
    </div>
    <div style="text-align: left; margin-top:1px">

        <table style="width: 100%; border-top: 1px solid #000;" cellpadding="2" cellspacing="0">
            <tr>
                <td class="td" style="text-align: left; padding: 2px; font-size: 10px;  font-weight:bold; ">
                    NO.</td>
                <td class="td" style="text-align: left; padding: 2px; font-size: 10px;  font-weight:bold; ">
                    ID KARYAWAN</td>
                <td class="td" style="text-align: left; padding: 2px; font-size: 10px;  font-weight:bold; ">
                    NAMA LENGKAP</td>
                <td class="td" style="text-align: right; padding: 2px; font-size: 10px;  font-weight:bold;  ">
                    GAPOK</td>
                <td class="td" style="text-align: right; padding: 2px; font-size: 10px;  font-weight:bold;">
                    TDK MASUK</td>
                <td class="td" style="text-align: center; padding: 2px; font-size: 10px; font-weight:bold;">
                    LEMBUR <span> <br>(TGL MERAH)</span></td>
                <td class="td" style="text-align: right; padding: 2px; font-size: 10px;  font-weight:bold;">
                    LEMBUR</td>
                {{-- <td class="td" style="text-align: right; padding: 2px; font-size: 10px;  font-weight:bold;">
                    STORING</td>
                </td> --}}
                <td class="td" style="text-align: right; padding: 2px; font-size: 10px;  font-weight:bold;">
                    GAJI KOTOR</td>
                </td>
                <td class="td" style="text-align: center; padding: 2px; font-size: 10px; font-weight:bold; ">
                    KETERLAMBATAN <span> <br>(&lt; 30 MNT) (> 30 MNT)</span></td>
                {{-- <td class="td" style="text-align: center; padding: 2px; font-size: 10px;  font-weight:bold;width:8%">
                TIDAK ABSEN</td> --}}
                <td class="td" style="text-align: center; padding-left: 2px; font-size: 10px;  font-weight:bold;">
                    TIDAK ABSEN <span> <br>ISTRAHAT</span></td>
                </td>
                <td class="td" style="text-align: right; padding: 2px; font-size: 10px;  font-weight:bold;">
                    POTONGAN LAINYA</td>
                <td class="td" style="text-align: right; padding: 2px; font-size: 10px;  font-weight:bold;">
                    BPJS</td>
                <td class="td"
                    style="text-align: center; padding-left: 1px; font-size: 10px;  font-weight:bold;width:15%">
                    PELUNASAN <span> <br>KASBON</span></td>
                </td>
                <td class="td" style="text-align: right; font-size: 10px;  font-weight:bold; ">GAJI BERSIH
                </td>
            </tr>
            <!-- Add horizontal line below this row -->
            <tr>
                <td colspan="14" style="padding: 0px;">
                    <hr style="border: 0.5px solid; margin-top:0px; margin-bottom: 1px; padding: 0;">
                    <hr style="border: 0.5px solid; margin-top:1px; margin-bottom: 1px; padding: 0;">
                </td>
            </tr>
            @php
                $Grandtotal = 0;
            @endphp
            @foreach ($details as $item)
                <tr>
                    <td class="td"
                        style="text-align: center; padding: 2px; font-size: 10px; border-bottom: 1px solid black;">
                        {{ $loop->iteration }}
                    </td>
                    <td class="td"
                        style="text-align: left; padding: 2px; font-size: 10px; border-bottom: 1px solid black;">
                        @if ($item->karyawan)
                            {{ $item->karyawan->kode_karyawan }}
                        @endif
                    </td>
                    <td class="td"
                        style="text-align: left; padding: 2px; font-size: 10px; border-bottom: 1px solid black;">
                        {{ substr($item->nama_lengkap, 0, 12) }}
                    </td>
                    {{-- <td class="td"
                    style="text-align: right; padding: 2px; font-size: 10px; border-bottom: 1px solid black;">
                    Rp. {{ number_format($item->gaji, 0, ',', '.') }}
                </td> --}}
                    <td class="td"
                        style="text-align: center; padding: 1px; font-size: 10px; border-bottom: 1px solid black;">
                        <table style="width: 100%; text-align: right;">
                            <tr>
                                <td style="width: 50%;">
                                    Rp.
                                </td>
                                <td style="width: 50%;">
                                    {{ number_format($item->gaji, 0, ',', '.') }}
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td class="td"
                        style="text-align: right; padding: 2px; font-size: 10px;  border-bottom: 1px solid black;">
                        Rp. {{ number_format($item->hasiltdk_berangkat, 0, ',', '.') }}
                    </td>
                    <td class="td"
                        style="text-align: right; padding: 2px; font-size: 10px; border-bottom: 1px solid black;">
                        Rp. {{ number_format($item->hasiltgl_merah, 0, ',', '.') }}
                    </td>
                    <td class="td"
                        style="text-align: center; padding: 1px; font-size: 10px; border-bottom: 1px solid black;">
                        <table style="width: 100%; text-align: right;">
                            <tr>
                                <td style="width: 50%;">
                                    Rp.
                                </td>
                                <td style="width: 50%;">
                                    {{ number_format($item->hasil_lembur, 0, ',', '.') }}
                                </td>
                            </tr>
                        </table>
                    </td>
                    {{-- <td class="td"
                        style="text-align: center; padding: 1px; font-size: 10px; border-bottom: 1px solid black;">
                        <table style="width: 100%; text-align: right; padding-left:10px">
                            <tr>
                                <td style="width: 20%;">
                                    Rp.
                                </td>
                                <td style="width: 70%;">
                                    {{ number_format($item->hasil_storing, 2, ',', '.') }}
                                </td>
                            </tr>
                        </table>
                    </td> --}}
                    <td class="td"
                        style="text-align: right; padding-right: 7px; font-size: 10px; border-bottom: 1px solid black;">
                        Rp. {{ number_format($item->gaji_kotor, 0, ',', '.') }}
                    </td>
                    <td class="td"
                        style="text-align: center; padding: 1px; font-size: 10px; border-bottom: 1px solid black;">
                        <table style="width: 100%; text-align: right; padding-right:10px">
                            <tr>
                                <td style="width: 50%;">
                                    <table style="width: 100%; text-align: right;">
                                        <tr>
                                            <td style="width: 20%;">
                                                Rp.
                                            </td>
                                            <td style="width: 80%;">
                                                {{ number_format($item->hasilkurang, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td style="width: 50%;">
                                    <table style="width: 100%; text-align: right;">
                                        <tr>
                                            <td style="width: 20%;">
                                                Rp.
                                            </td>
                                            <td style="width: 80%;">
                                                {{ number_format($item->hasillebih, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td class="td"
                        style="text-align: right; padding-right: 15px; font-size: 10px; border-bottom: 1px solid black;">
                        Rp. {{ number_format($item->hasil_absen, 0, ',', '.') }}
                    </td>
                    <td class="td"
                        style="text-align: right; padding-right: 15px; font-size: 10px; border-bottom: 1px solid black;">
                        Rp. {{ number_format($item->lainya, 0, ',', '.') }}
                    </td>
                    <td class="td"
                        style="text-align: right; padding-right: 7px; font-size: 10px; border-bottom: 1px solid black;">
                        Rp. {{ number_format($item->potongan_bpjs, 0, ',', '.') }}
                    <td class="td"
                        style="text-align: center; padding: 1px; font-size: 10px; border-bottom: 1px solid black;">
                        <table style="width: 100%; text-align: right; padding-right: 24px; ">
                            <tr>
                                <td style="width: 50%;">
                                    Rp.
                                </td>
                                <td style="width: 50%;">
                                    {{ number_format($item->pelunasan_kasbon, 0, ',', '.') }}
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td class="td" style="text-align: right; font-size: 10px; border-bottom: 1px solid black;">
                        Rp. {{ number_format($item->gaji_bersih, 0, ',', '.') }}
                    </td>
                </tr>
                @php
                    $Grandtotal += $item->gaji_bersih;
                @endphp
            @endforeach
            <tr style="border-bottom: 1px solid black;">
                <td colspan="14" style="padding: 2px;"></td>
            </tr>
            <tr>
                <td colspan="13"
                    style="text-align: right; font-weight: bold; margin-top:5px; margin-bottom:5px; font-size: 10px;">
                    {{-- GRAND
                TOTAL --}}
                </td>
                <td class="td" style="text-align: right; font-weight: bold; font-size: 10px;">
                    Rp. {{ number_format($Grandtotal, 0, ',', '.') }}
                </td>
            </tr>
        </table>
    </div>

    <table style="width: 50%; border-top: 1px solid #000;" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td" style="text-align: left; padding: 2px; font-size: 10px;  font-weight:bold;">
                NO.</td>
            <td class="td" style="text-align: left; padding: 2px; font-size: 10px;  font-weight:bold;">
                ID KARYAWAN</td>
            <td class="td" style="text-align: left; padding: 2px; font-size: 10px;  font-weight:bold;">
                NAMA LENGKAP</td>
            <td class="td" style="text-align: right; padding: 2px; font-size: 10px;  font-weight:bold;">
                DEPOSIT AWAL</td>
            <td class="td" style="text-align: right; padding: 2px; font-size: 10px;  font-weight:bold;">
                PELUNASAN DEPOSIT</td>
            <td class="td" style="text-align: right; font-size: 10px;  font-weight:bold;">SISA DEPOSIT
            </td>
        </tr>
        <!-- Add horizontal line below this row -->
        <tr>
            <td colspan="6" style="padding: 0px;">
                <hr style="border: 0.5px solid; margin-top:0px; margin-bottom: 1px; padding: 0;">
                <hr style="border: 0.5px solid; margin-top:1px; margin-bottom: 1px; padding: 0;">
            </td>
        </tr>
        @php
            $nomor_urut = 1;
            $GrandtotalsaldoAwal = 0;
            $GrandtotalsisaDeposit = 0;
            $Grandtotal = 0;
        @endphp
        @foreach ($details as $item)
            @if ($item->pelunasan_kasbon !== null && $item->pelunasan_kasbon != 0)
                <tr>
                    <td class="td"
                        style="text-align: center; padding: 2px; font-size: 10px; border-bottom: 1px solid black;">
                        {{ $loop->iteration }}
                    </td>
                    <td class="td"
                        style="text-align: left; padding: 2px; font-size: 10px; border-bottom: 1px solid black;">
                        @if ($item->karyawan)
                            {{ $item->karyawan->kode_karyawan }}
                        @endif
                    </td>
                    <td class="td"
                        style="text-align: left; padding: 2px; font-size: 10px; border-bottom: 1px solid black;">
                        {{ $item->nama_lengkap }}
                    </td>
                    <td class="td"
                        style="text-align: center; padding: 1px; font-size: 10px; border-bottom: 1px solid black;">
                        <table style="width: 100%; text-align: right; ">
                            <tr>
                                <td style="width: 30%;">
                                    Rp.
                                </td>
                                <td style="width: 70%;">
                                    - {{ number_format($item->kasbon_awal, 2, ',', '.') }}
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td class="td"
                        style="text-align: center; padding: 1px; font-size: 10px; border-bottom: 1px solid black;">
                        <table style="width: 100%; text-align: right; padding-right:1px">
                            <tr>
                                <td style="width: 30%;">
                                    Rp.
                                </td>
                                <td style="width: 70%;">
                                    {{ number_format($item->pelunasan_kasbon, 2, ',', '.') }}
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td class="td"
                        style="text-align: center; padding: 1px; font-size: 10px; border-bottom: 1px solid black;">
                        <table style="width: 100%; text-align: right;">
                            <tr>
                                <td style="width: 30%;">
                                    Rp.
                                </td>
                                <td style="width: 70%;">
                                    {{ number_format($item->sisa_kasbon - $item->pelunasan_kasbon, 2, ',', '.') }}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                @php
                    $GrandtotalsaldoAwal += $item->kasbon_awal;
                    $GrandtotalsisaDeposit += $item->sisa_kasbon;
                    $Grandtotal += $item->pelunasan_kasbon;
                    $nomor_urut++;
                @endphp
            @endif
        @endforeach
        <tr style="border-bottom: 1px solid black;">
            <td colspan="6" style="padding: 2px;"></td>
        </tr>
        <tr>
            <td colspan="3"
                style="text-align: right; font-weight: bold; margin-top:5px; margin-bottom:5px; font-size: 10px;">
            </td>
            <td class="td" style="text-align: right; font-weight: bold; font-size: 10px;">
                <table style="width: 100%; text-align: right;">
                    <tr>
                        <td style="width: 30%;">
                            Rp.
                        </td>
                        <td style="width: 70%;">
                            - {{ number_format($GrandtotalsaldoAwal, 2, ',', '.') }}
                        </td>
                    </tr>
                </table>
            </td>
            <td class="td" style="text-align: right; font-weight: bold; font-size: 10px;">
                <table style="width: 100%; text-align: right;">
                    <tr>
                        <td style="width: 30%;">
                            Rp.
                        </td>
                        <td style="width: 70%;">
                            {{ number_format($Grandtotal, 2, ',', '.') }}
                        </td>
                    </tr>
                </table>
            </td>
            <td class="td" style="text-align: right; font-weight: bold; font-size: 10px;">
                <table style="width: 100%; text-align: right;">
                    <tr>
                        <td style="width: 30%;">
                            Rp.
                        </td>
                        <td style="width: 70%;">
                            - {{ number_format($GrandtotalsisaDeposit - $Grandtotal, 2, ',', '.') }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <br>
    <br>

    <br>
    <br>



    <div class="container">
        <a href="{{ url('admin/perhitungan_gajibulanan') }}" class="blue-button">Kembali</a>
        <a href="{{ url('admin/perhitungan_gajibulanan/cetak-pdf/' . $cetakpdf->id) }}" class="blue-button">Cetak</a>
    </div>

</body>

</html>
