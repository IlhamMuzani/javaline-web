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
        font-family: 'DOSVGA', Arial, Helvetica, sans-serif;
        /* font-family: 'DOSVGA', monospace; */
        color: black;

        margin-top: 5px;
        margin-right: 20px;
        margin-left: 20px;
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
        padding: 12px 20px;
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
        padding-top: 12px;
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


<body style="margin-top: 10; padding: 0;">
    <div id="logo-container">
        <img src="{{ asset('storage/uploads/user/logo.png') }}" alt="JAVA LINE" width="70" height="35">
    </div>
    <div style="text-align: center;">
        <span style="font-weight: bold; font-size: 16px;">SLIP GAJI</span>
    </div>

    <br>
    {{-- <span style="font-weight:bold; font-size:13px">
        Penerimaan
    </span> --}}

    <table style="width: 100%" cellpadding="2" cellspacing="0">
        @php
        $totalRuteSum = 0;
        @endphp
        <tr>
            <td class="td"
                style="text-align: left; font-weight:bold; padding: 0px; font-size: 12px; border-bottom: 1px solid black;">
                PENERIMA
            </td>
            <td class="td" style="text-align: left; padding: 2px; font-size: 12px; border-bottom: 1px solid black;">

            </td>
            <td class="td"
                style="text-align: left; font-weight:bold; padding: 1px; font-size: 12px; border-bottom: 1px solid black;">
                GAPOK
            </td>
            <td class="td"
                style="text-align: left; font-weight:bold; padding-right: 7px; font-size: 12px; border-bottom: 1px solid black;">
                EF
            </td>
            <td class="td"
                style="text-align: right; font-weight:bold; font-size: 12px; border-bottom: 1px solid black;">
                HK </td>
            <td class="td" style="text-align: right; font-size: 12px; border-bottom: 1px solid black;">
            </td>
            </td>
            <td class="td" style="text-align: left; font-size: 12px; border-bottom: 1px solid black;">
            </td>
            <td class="td" style="text-align: left; font-size: 12px; border-bottom: 1px solid black;">
            </td>
            <td class="td" style="text-align: left; font-weight:bold; font-size: 12px; border-bottom: 1px solid black;">
                TOTAL
            </td>
            <td class="td"
                style="text-align: right; font-weight:bold; font-size: 12px; border-bottom: 1px solid black;">
            </td>
            </td>
        </tr>
        <tr>
            <td class="td" style="text-align: left; padding: 0px; font-size: 12px;">
                Gaji
            </td>
            <td class="td" style="text-align: left; padding: 2px; font-size: 12px;">
                :
            </td>
            <td class="td" style="text-align: left; padding: 1px; font-size: 12px;">
                {{ number_format($cetakpdf->gaji, 0, ',', '.') }} </td>
            </td>
            <td class="td" style="text-align: left; padding-right: 7px; font-size: 12px;">
                {{ $cetakpdf->hari_efektif }}
            </td>
            <td class="td" style="text-align: right; font-size: 12px;">
                {{ $cetakpdf->hari_kerja }}
            </td>
            <td class="td" style="text-align: right; font-size: 12px;">
            </td>
            <td class="td" style="text-align: left; font-size: 12px;">
            </td>
            <td class="td" style="text-align: left; font-size: 12px;">
                = </td>
            <td class="td" style="text-align: left; font-size: 12px;">
                Rp </td>
            <td class="td" style="text-align: right; font-size: 12px;">
                {{ number_format($cetakpdf->gaji * $cetakpdf->hari_kerja, 0, ',', '.') }} </td>
        </tr>
        <tr>
            <td class="td" style="text-align: left; padding: 0px; font-size: 12px;">
                Lembur
            </td>
            <td class="td" style="text-align: left; padding: 2px; font-size: 12px;">
                :
            </td>
            <td class="td" style="text-align: left; padding: 1px; font-size: 12px;">
            </td>
            <td class="td" style="text-align: left; padding-right: 7px; font-size: 12px;">

            </td>
            <td class="td" style="text-align: right; font-size: 12px;">
            </td>
            <td class="td" style="text-align: right; font-size: 12px;">
            </td>
            <td class="td" style="text-align: left; font-size: 12px;">
            </td>
            <td class="td" style="text-align: left; font-size: 12px;">
                = </td>
            <td class="td" style="text-align: left; font-size: 12px;">
                Rp </td>
            <td class="td" style="text-align: right; font-size: 12px;">
                {{ number_format($cetakpdf->hasil_lembur, 0, ',', '.') }} </td>
        </tr>
        <tr>
            <td class="td" style="text-align: left; padding: 0px; font-size: 12px;">
                Lembur Storing
            </td>
            <td class="td" style="text-align: left; padding: 2px; font-size: 12px;">
                :
            </td>
            <td class="td" style="text-align: left; padding: 1px; font-size: 12px;">
            </td>
            <td class="td" style="text-align: left; padding-right: 7px; font-size: 12px;">

            </td>
            <td class="td" style="text-align: right; font-size: 12px;">
            </td>
            <td class="td" style="text-align: right; font-size: 12px;">
            </td>
            </td>
            <td class="td" style="text-align: left; font-size: 12px;">
            </td>
            <td class="td" style="text-align: left; font-size: 12px;">
                = </td>
            <td class="td" style="text-align: left; font-size: 12px; border-bottom: 1px solid black;">
                Rp </td>
            <td class="td" style="text-align: right; font-size: 12px; border-bottom: 1px solid black;">
                {{ number_format($cetakpdf->hasil_storing, 0, ',', '.') }} </td>
            </td>
        </tr>

        <tr>
            <td class="td" style="text-align: left; padding: 0px; font-size: 12px;">
            </td>
            <td class="td" style="text-align: left; padding: 2px; font-size: 12px;">
            </td>
            <td class="td" style="text-align: left; padding: 1px; font-size: 12px;">
            </td>
            <td class="td" style="text-align: left; padding-right: 7px; font-size: 12px;">
            </td>
            <td class="td" style="text-align: left; font-size: 12px;">
            </td>
            <td class="td" style="text-align: left; font-size: 12px;">
            </td>
            <td class="td" style="text-align: left; font-size: 12px;">
            </td>
            <td class="td" style="text-align: left; font-size: 12px;">
            </td>
            <td class="td" style="text-align: left; font-size: 12px;">Rp
            </td>
            <td class="td" style="text-align: right; font-size: 12px; font-weight:bold">
                {{ number_format($cetakpdf->gaji_kotor, 0, ',', '.') }} </td>
        </tr>

        <tr><br></tr>

        <tr>
            <td class="td" style="text-align: left; padding: 0px; font-size: 13px; font-weight:bold">
                Potongan
            </td>
            <td class="td" style="text-align: left; padding: 2px; font-size: 12px;">

            </td>
            <td class="td" style="text-align: left; padding: 1px; font-size: 12px;">

            </td>
            <td class="td" style="text-align: left; padding-right: 7px; font-size: 12px;">

            </td>
            <td class="td" style="text-align: left; font-size: 12px;">
            </td>
            <td class="td" style="text-align: left; font-size: 12px;">
            </td>
            <td class="td" style="text-align: left; font-size: 12px;">
            </td>
            <td class="td" style="text-align: left; font-size: 12px;">
            </td>
            <td class="td" style="text-align: left; font-size: 12px;">
            </td>
        </tr>
        <tr>
            <td class="td" style="text-align: left; padding: 0px; font-size: 12px;">
                Alpa
            </td>
            <td class="td" style="text-align: left; padding: 2px; font-size: 12px;">
                :
            </td>
            <td class="td" style="text-align: left; padding: 1px; font-size: 12px;">

            </td>
            <td class="td" style="text-align: left; padding-right: 7px; font-size: 12px;">

            </td>
            <td class="td" style="text-align: right; font-size: 12px;">
            </td>
            <td class="td" style="text-align: right; font-size: 12px;">
            </td>
            </td>
            <td class="td" style="text-align: left; font-size: 12px;">
            </td>
            <td class="td" style="text-align: left; font-size: 12px;">
                = </td>
            <td class="td" style="text-align: left; font-size: 12px;">
                Rp </td>
            <td class="td" style="text-align: right; font-size: 12px;">
                - </td>
        </tr>
        <tr>
            <td class="td" style="text-align: left; padding: 0px; font-size: 12px;">
                BPJS
            </td>
            <td class="td" style="text-align: left; padding: 2px; font-size: 12px;">
                :
            </td>
            <td class="td" style="text-align: left; padding: 1px; font-size: 12px;">

            </td>
            <td class="td" style="text-align: left; padding-right: 7px; font-size: 12px;">

            </td>
            <td class="td" style="text-align: right; font-size: 12px;">
            </td>
            <td class="td" style="text-align: right; font-size: 12px;">
            </td>
            </td>
            <td class="td" style="text-align: left; font-size: 12px;">
            </td>
            <td class="td" style="text-align: left; font-size: 12px;">
                = </td>
            <td class="td" style="text-align: left; font-size: 12px;">
                Rp </td>
            <td class="td" style="text-align: right; font-size: 12px;">
                {{ number_format($cetakpdf->potongan_bpjs, 0, ',', '.') }} </td>
        </tr>
        <tr>
            <td class="td" style="text-align: left; padding: 0px; font-size: 12px;">
                Pelunasan
            </td>
            <td class="td" style="text-align: left; padding: 2px; font-size: 12px;">
                :
            </td>
            <td class="td" style="text-align: left; padding: 1px; font-size: 12px;">
                {{ number_format($cetakpdf->pelunasan_kasbon, 0, ',', '.') }}
            </td>
            <td class="td" style="text-align: left; padding-right: 7px; font-size: 12px;">

            </td>
            <td class="td" style="text-align: right; font-size: 12px;">
            </td>
            <td class="td" style="text-align: right; font-size: 12px;">
            </td>
            </td>
            <td class="td" style="text-align: left; font-size: 12px;">
            </td>
            <td class="td" style="text-align: left; font-size: 12px;">
                = </td>
            <td class="td" style="text-align: left; font-size: 12px;">
                Rp </td>
            <td class="td" style="text-align: right; font-size: 12px;">
                {{ number_format($cetakpdf->pelunasan_kasbon, 0, ',', '.') }} </td>
        </tr>
        <tr>
            <td class="td" style="text-align: left; padding: 0px; font-size: 12px;">
                Terlambat < 30 m </td>
            <td class="td" style="text-align: left; padding: 2px; font-size: 12px;">
                :
            </td>
            <td class="td" style="text-align: left; padding: 1px; font-size: 12px;">
                {{ $cetakpdf->kurangtigapuluh }}
            </td>
            <td class="td" style="text-align: left; padding-right: 7px; font-size: 12px;">
                x
            </td>
            <td class="td" style="text-align: right; font-size: 12px;">
                Rp </td>
            <td class="td" style="text-align: right; font-size: 12px;">
                {{ number_format($cetakpdf->hasil_kurang, 0, ',', '.') }} </td>
            <td class="td" style="text-align: left; font-size: 12px;">
            </td>
            <td class="td" style="text-align: left; font-size: 12px;">
                = </td>
            <td class="td" style="text-align: left; font-size: 12px;">
                Rp </td>
            <td class="td" style="text-align: right; font-size: 12px;">
                {{ number_format($cetakpdf->hasil_kurang, 0, ',', '.') }} </td>
        </tr>
        <tr>
            <td class="td" style="text-align: left; padding: 0px; font-size: 12px;">
                Terlambat > 30 m
            </td>
            <td class="td" style="text-align: left; padding: 2px; font-size: 12px;">
                :
            </td>
            <td class="td" style="text-align: left; padding: 1px; font-size: 12px;">
                {{ $cetakpdf->lebihtigapuluh }}
            </td>
            <td class="td" style="text-align: left; padding-right: 7px; font-size: 12px;">
                x
            </td>
            <td class="td" style="text-align: right; font-size: 12px;">
                Rp </td>
            <td class="td" style="text-align: right; font-size: 12px;">
                {{ number_format($cetakpdf->hasil_lebih, 0, ',', '.') }} </td>
            <td class="td" style="text-align: left; font-size: 12px;">
            </td>
            <td class="td" style="text-align: left; font-size: 12px;">
                = </td>
            <td class="td" style="text-align: left; font-size: 12px;">
                Rp </td>
            <td class="td" style="text-align: right; font-size: 12px;">
                {{ number_format($cetakpdf->hasil_lebih, 0, ',', '.') }} </td>
        </tr>

        <tr>
            <td class="td" style="text-align: left; padding: 0px; font-size: 12px;">
                Potongan Absen
            </td>
            <td class="td" style="text-align: left; padding: 2px; font-size: 12px;">
                :
            </td>
            <td class="td" style="text-align: left; padding: 1px; font-size: 12px;">
                {{ $cetakpdf->absen }}
            </td>
            <td class="td" style="text-align: left; padding-right: 7px; font-size: 12px;">
                x
            </td>
            <td class="td" style="text-align: right; font-size: 12px;">
                Rp </td>
            <td class="td" style="text-align: right; font-size: 12px;">
                {{ $cetakpdf->hasil_absen }} </td>
            <td class="td" style="text-align: left; font-size: 12px;">
            </td>
            <td class="td" style="text-align: left; font-size: 12px;">
                = </td>
            <td class="td" style="text-align: left; font-size: 12px; border-bottom: 1px solid black;">
                Rp </td>
            <td class="td" style="text-align: right; font-size: 12px; border-bottom: 1px solid black;">
                {{ number_format($cetakpdf->hasil_absen, 0, ',', '.') }} </td>
            </td>
        </tr>

        <tr>
            <td class="td" style="text-align: left; padding: 0px; font-size: 12px; font-weight:bold">
                Total
            </td>
            <td class="td" style="text-align: left; padding: 2px; font-size: 12px;">
            </td>
            <td class="td" style="text-align: left; padding: 1px; font-size: 12px;">
            </td>
            <td class="td" style="text-align: left; padding-right: 7px; font-size: 12px;">
            </td>
            <td class="td" style="text-align: left; font-size: 12px;">
            </td>
            <td class="td" style="text-align: left; font-size: 12px;">
            </td>
            <td class="td" style="text-align: left; font-size: 12px;">
            </td>
            <td class="td" style="text-align: left; font-size: 12px;">
            </td>
            <td class="td" style="text-align: left; font-size: 12px; font-weight:bold">
                Rp
            </td>
            <td class="td" style="text-align: right; font-size: 12px; font-weight:bold">
                {{ number_format($cetakpdf->gaji_bersih, 0, ',', '.') }} </td>
            </td>
        </tr>
    </table>
    <table style="width: 100%; border-top: 1px solid #000;">
        <tr>
            <td>
            </td>
            <td style="text-align: right;font-size: 12px;  font-weight:bold">
            </td>
        </tr>
    </table>
    </table>
    <br>
    <div style="font-size: 13px">Ket</div>
    <table style="width: 100%;" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td"
                style="text-align: left; padding-right: 330px; color:red; font-size: 13px; white-space: normal; width: 60%;">
                {{ $cetakpdf->perhitungan_gajikaryawan->keterangan }}
            </td>
        </tr>
    </table>
    <br>
    <table width="100%">
        <tr style="font-size: 12px">
            <td style="width:60%;">
                <div>

                    <br>
                    <span style="color: white">.
                    </span>
                    <br>
                    <span style="color: white">.
                    </span>
                    <br>
                    <span style="color: white">.
                    </span>
                    <br>
                    <span style="color: white">.
                    </span>
                    <br>
                    <span style="color: white">.
                    </span>
                    <span style="color: white">.
                    </span>
                    <br>
                </div>
            </td>
            <td style="width: 30%; text-align: left;">
                <table class="tdd" cellpadding="10" cellspacing="0" style="margin: 0 auto;">
                    <tr>
                        <td style="text-align: center;">
                            <table style="margin: 0 auto;">
                                <tr style="text-align: center;">
                                    <td class="label">
                                        <span class="info-item" style="font-size: 12px; padding-right:0px">
                                            Slawi,
                                            {{ \Carbon\Carbon::parse($cetakpdf->tanggal)->locale('id')->isoFormat('D MMMM YYYY') }}
                                        </span>
                                        <br>
                                        {{-- <span class="info-item"
                                            style="font-size: 12px; padding-right:0px; margin-top:5px">
                                            Mengetahui,
                                        </span> --}}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <div style=" margin-top:13px; margin-bottom:27px">
        <table class="tdd" cellpadding="10" cellspacing="0" style="margin: 0 auto;">
            <tr>
                <td style="text-align: center;">
                    <table style="margin: 0 auto;">
                        <tr style="text-align: center; font-size:12px">
                            <td class="label">{{ $cetakpdf->karyawan->nama_lengkap }}</td>
                        </tr>
                        <tr>
                            <td class="separator" colspan="2"><span></span></td>
                        </tr>
                        <tr style="text-align: center; font-size:12px">
                            <td class="label">Penerima</td>
                        </tr>
                    </table>
                </td>
                <td style="text-align: center;">
                    <table style="margin: 0 auto;">
                        <tr style="text-align: center; font-size:12px">
                            <td class="label">{{ auth()->user()->karyawan->nama_lengkap }}</td>
                        </tr>
                        <tr>
                            <td class="separator" colspan="2"><span></span></td>
                        </tr>
                        <tr style="text-align: center; font-size:12px">
                            <td class="label">Finance</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <div style="text-align: right; font-size:12px">
            <span style="font-style: italic;">Printed Date
                {{ \Carbon\Carbon::now()->format('Y-m-d H:i:s') }}</span>
        </div>
    </div>
</body>

</html>