<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Surat Klaim Ban Driver</title>
    <style>
        /* * {
            border: 1px solid black;
        } */
        .b {
            border: 1px solid black;
        }

        .table,
        .td {
            /* border: 1px solid black; */
        }

        .table,
        .tdd {
            border: 1px solid white;
        }

        html,
        body {
            margin-top: 10px;
            margin-right: 20px;
            margin-left: 20px;
            font-family: Arial, sans-serif;
            color: black;
        }

        span.h2 {
            font-size: 24px;
            font-weight: 500;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
        }

        .tdd td {
            border: none;
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

        .faktur {
            text-align: center
        }

        /* .blue-button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            right: 0;
        } */

        .info-container {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
            font-size: 16px;
            margin: 5px 0;
        }

        .right-col {
            text-align: right;
        }

        .info-text {
            text-align: left;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .info-left {
            text-align: left;
            /* Apply left-align specifically for the info-text class */
        }

        .info-item {
            flex: 1;
        }

        .alamat {
            color: black;
            font-weight: bold;
        }

        .blue-button:hover {
            background-color: #0056b3;
        }

        .nama-pt {
            color: black;
            font-weight: bold;
        }

        .alamat {
            color: black;
            font-weight: bold;
        }

        .info-catatan {
            display: flex;
            flex-direction: row;
            /* Mengatur arah menjadi baris */
            align-items: center;
            /* Posisi elemen secara vertikal di tengah */
            margin-bottom: 2px;
            /* Menambah jarak antara setiap baris */
        }

        .info-catatan2 {
            font-weight: bold;
            margin-right: 5px;
            min-width: 120px;
            /* Menetapkan lebar minimum untuk kolom pertama */
        }

        .tdd1 td {
            text-align: center;
            font-size: 12px;
            position: relative;
            padding-top: 10px;
            /* Sesuaikan dengan kebutuhan Anda */
        }

        .tdd1 td::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            border-top: 1px solid black;
        }

        .info-1 {}

        .label {
            font-size: 12px;
            text-align: center;
            /* Teks menjadi berada di tengah */

        }

        .label2 {
            font-size: 12px;
            text-align: left;
            /* Teks menjadi berada di tengah */

        }

        .separator {
            padding-top: 12px;
            /* Atur sesuai kebutuhan Anda */
            text-align: center;
            /* Teks menjadi berada di tengah */

        }

        .separator span {
            display: inline-block;
            border-top: 1px solid black;
            width: 100%;
            position: relative;
            top: -8px;
            /* Sesuaikan posisi vertikal garis tengah */
        }
    </style>
</head>

<body style="margin: 0; padding: 0;">

    <br>
    <div style="font-weight: bold; text-align: center">
        <span style="font-weight: bold; font-size: 19px;">SURAT KLAIM BAN DRIVER</span>
    </div>
    <table style=" margin: 5px 0;" cellpadding="2" cellspacing="0">
        <tr>
            <td class="text-align: left" style="font-size: 12px; display: block;">Kode Klaim</td>
            <td style="text-align: left; font-size: 12px;">
                <span class="content2">
                    : <span>{{ $cetakpdf->kode_klaimban }}</span></span>
                <br>
            </td>
            <td class="text-align: left" style="font-size: 12px; margin-left: 5px; display: block;">No. Kabin
            </td>
            <td style="text-align: left; font-size: 12px;">
                <span class="content2">
                    : @if ($cetakpdf->kendaraan)
                        {{ $cetakpdf->kendaraan->no_kabin }}
                    @else
                        tidak ada
                    @endif </span>
                <br>
            </td>
        </tr>
        <tr>
            <td class="text-align: left" style="font-size: 12px; display: block;">Kode Driver</td>
            <td style="text-align: left; font-size: 12px;">
                <span class="content2">
                    : @if ($cetakpdf->karyawan)
                        {{ $cetakpdf->karyawan->kode_karyawan }}
                    @else
                        tidak ada
                    @endif </span>
                </span>
                <br>
            </td>
            <td class="info-text-align: left" style="font-size: 12px; margin-left: 5px; display: block;">No.
                Mobil
            </td>
            <td style="text-align: left; font-size: 12px;">
                <span class="content2">
                    : @if ($cetakpdf->kendaraan)
                        {{ $cetakpdf->kendaraan->no_pol }}
                    @else
                        tidak ada
                    @endif </span>
                <br>
            </td>
        </tr>
        <tr>
            <td class="text-align: left" style="font-size: 12px; display: block;">Nama Driver</td>
            <td style="text-align: left; font-size: 12px;">
                <span class="content2">
                    : {{ $cetakpdf->karyawan->nama_lengkap }}
                </span>
                <br>
            </td>
            <td class="text-align: left" style="font-size: 12px; margin-left: 5px; display: block;">Jenis
                Kendaraan
            </td>
            <td style="text-align: left; font-size: 12px;">
                <span class="content2">
                    : {{ $cetakpdf->kendaraan->jenis_kendaraan->nama_jenis_kendaraan }}</span>
                </span>
                <br>
            </td>
        </tr>
    </table>
    <hr style="border: 0.5px solid;">
    <table width="100%" style="border-collapse: collapse;">
        <tr>
            <td style="width:100%;">
                <table>
                    <tr>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 12px;">Kode Ban</span>
                        </td>
                        <td class="info-column">
                            <span class="info-titik" style="font-size: 12px;">:</span>
                        </td>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 12px;">{{ $cetakpdf->ban->kode_ban }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 12px;">No Seri</span>
                        </td>
                        <td class="info-column">
                            <span class="info-titik" style="font-size: 12px;">:</span>
                        </td>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 12px;">{{ $cetakpdf->ban->no_seri }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 12px;">Merek Ban</span>
                        </td>
                        <td class="info-column">
                            <span class="info-titik" style="font-size: 12px;">:</span>
                        </td>
                        <td class="info-column">
                            <span class="info-item"
                                style="font-size: 12px;">{{ $cetakpdf->ban->merek->nama_merek }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 12px;">Type Ban</span>
                        </td>
                        <td class="info-column">
                            <span class="info-titik" style="font-size: 12px;">:</span>
                        </td>
                        <td class="info-column">
                            <span class="info-item"
                                style="font-size: 12px;">{{ $cetakpdf->ban->typeban->nama_type }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 12px;">Harga Ban</span>
                        </td>
                        <td class="info-column">
                            <span class="info-titik" style="font-size: 12px;">:</span>
                        </td>
                        <td class="info-column">
                            <span class="info-item"
                                style="font-size: 12px;">{{ number_format($cetakpdf->ban->harga, 0, ',', '.') }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 12px;">Posisi Ban</span>
                        </td>
                        <td class="info-column">
                            <span class="info-titik" style="font-size: 12px;">:</span>
                        </td>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 12px;">{{ $cetakpdf->ban->posisi_ban }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 12px;">Km Pemasangan</span>
                        </td>
                        <td class="info-column">
                            <span class="info-titik" style="font-size: 12px;">:</span>
                        </td>
                        <td class="info-column">
                            <span class="info-item"
                                style="font-size: 12px;">{{ number_format($cetakpdf->ban->km_pemasangan, 0, ',', '.') }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 12px;">Km Target</span>
                        </td>
                        <td class="info-column">
                            <span class="info-titik" style="font-size: 12px;">:</span>
                        </td>
                        <td class="info-column">
                            <span class="info-item"
                                style="font-size: 12px;">{{ number_format($cetakpdf->ban->target_km_ban, 0, ',', '.') }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 12px;">Km Pelepasan</span>
                        </td>
                        <td class="info-column">
                            <span class="info-titik" style="font-size: 12px;">:</span>
                        </td>
                        <td class="info-column">
                            <span class="info-item"
                                style="font-size: 12px;">{{ number_format($cetakpdf->ban->km_pelepasan, 0, ',', '.') }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 12px;">Km Tercapai</span>
                        </td>
                        <td class="info-column">
                            <span class="info-titik" style="font-size: 12px;">:</span>
                        </td>
                        <td class="info-column">
                            <span class="info-item"
                                style="font-size: 12px;">{{ number_format($cetakpdf->ban->km_terpakai, 0, ',', '.') }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 12px; color:white">.</span>
                        </td>
                        <td class="info-column">
                            <span class="info-titik" style="font-size: 12px; color:white">.</span>
                        </td>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 12px; color:white">.</span>
                        </td>
                    </tr>
                </table>
            </td>
            <td style="width: 70%;">
                <table style="width: 100%;" cellpadding="2" cellspacing="0">
                    <tr>
                        <td colspan="5" style="text-align: left; padding-left: 0px; font-size: 12px;width: 25%;">
                            Harga Ban</td>
                        <td class="td" style="text-align: right; padding-right: 11px;; font-size: 12px;">
                            @if ($cetakpdf->ban)
                                {{ number_format($cetakpdf->ban->harga, 0, ',', '.') }}
                            @else
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" style="text-align: left; padding-left: 0px; font-size: 12px;">
                            Km Target
                        </td>
                        <td class="td" style="text-align: right; padding-right: 3px; font-size: 12px;">
                            {{ number_format($cetakpdf->ban->target_km_ban - $cetakpdf->ban->km_pemasangan, 0, ',', '.') }}
                            /
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6" style="padding: 0px;">
                        <hr style="border-top: 0.1px solid black; margin: 5px 0;">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" style="text-align: left; padding-left: 0px; font-size: 12px;">

                        </td>
                        <td class="td" style="text-align: right; padding-right: 11px; font-size: 12px;">
                            {{ $cetakpdf->ban->harga / ($cetakpdf->ban->target_km_ban - $cetakpdf->ban->km_pemasangan) }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" style="text-align: left; padding-left: 0px; font-size: 12px;">
                            Km Belum Tercapai
                        </td>
                        <td class="td" style="text-align: right; padding-right: 0px; font-size: 12px;">
                            {{ number_format($cetakpdf->ban->target_km_ban - $cetakpdf->ban->km_pelepasan, 0, ',', '.') }}
                            x
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6" style="padding: 0px;">
                            <hr style="border-top: 0.1px solid black; margin: 5px 0;">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" style="text-align: left; padding-left: 0px; font-size: 12px;">
                        </td>
                        <td class="td" style="text-align: right; padding-right: 10px; font-size: 12px;">
                            {{ number_format(($cetakpdf->ban->target_km_ban - $cetakpdf->ban->km_pelepasan) * ($cetakpdf->ban->harga / ($cetakpdf->ban->target_km_ban - $cetakpdf->ban->km_pemasangan)), 0, ',', '.') }}
                        </td>
                    </tr>
                </table>
            </td>

        </tr>
    </table>
    <hr style="border: 0.5px solid;">
    <table style="width: 100%;" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td"
                style="text-align: left; padding: 0px; font-size: 12px; white-space: nowrap; width: 50%;">
                Ket Memo
            </td>
            <td class="td" style="text-align: center; padding-right: 10px; font-size: 12px; width: 25%;">
                Grand Total
            </td>
            <td class="td"
                style="text-align: right; padding-right: 12px; font-size: 12px; width: 20%; max-width: 100px; overflow: hidden; text-overflow: ellipsis;">
                {{ number_format(($cetakpdf->ban->target_km_ban - $cetakpdf->ban->km_pelepasan) * ($cetakpdf->ban->harga / ($cetakpdf->ban->target_km_ban - $cetakpdf->ban->km_pemasangan)), 0, ',', '.') }}
            </td>
        </tr>
    </table>

    <table style="width: 100%;" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td"
                style="text-align: left; padding-right: 330px; font-size: 12px; white-space: normal; width: 60%;">
                {{ $cetakpdf->keterangan }}
            </td>
        </tr>
    </table>

    <div style=" margin-top:12px; margin-bottom:27px">
        <table class="tdd" cellpadding="10" cellspacing="0" style="margin: 0 auto;">
            <tr>
                <td style="text-align: center;">
                    <table style="margin: 0 auto;">
                        <tr style="text-align: center;">
                            <td class="label">{{ $cetakpdf->karyawan->nama_lengkap }}</td>
                        </tr>
                        <tr>
                            <td class="separator" colspan="2"><span></span></td>
                        </tr>
                        <tr style="text-align: center;">
                            <td class="label">Driver</td>
                        </tr>
                    </table>
                </td>
                <td style="text-align: center;">
                    <table style="margin: 0 auto;">
                        <tr style="text-align: center;">
                            <td class="label" style="min-height: 16px;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="separator" colspan="2"><span></span></td>
                        </tr>
                        <tr style="text-align: center;">
                            <td class="label">Finance</td>
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
                            <td class="label">Admin</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <div style="text-align: right; font-size:11px">
            <span style="font-style: italic;">Printed Date
                {{ \Carbon\Carbon::now()->format('Y-m-d H:i:s') }}</span>
        </div>
    </div>
</body>

</html>
