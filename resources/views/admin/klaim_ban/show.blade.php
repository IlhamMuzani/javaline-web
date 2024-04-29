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
    <hr style="border-top: 0.1px solid black; margin: 5px 0;">
    <table style="width: 100%;" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">Kode Ban</td>
            <td class="td" style="text-align: center; font-size: 12px;">No Seri</td>
            <td class="td" style="text-align: right; font-size: 12px;">Km Pemasangan</td>
            <td class="td" style="text-align: right; padding: 0px; font-size: 12px;">Km Target</td>
            <td class="td" style="text-align: right; padding: 0px; font-size: 12px;">Km Pelepasan</td>
            <td class="td" style="text-align: right; padding: 0px; font-size: 12px;">Km Tercapai</td>
            <td class="td" style="text-align: right; padding-right: 23px; font-size: 12px;">Harga Klaim</td>
        </tr>
        <!-- Add horizontal line below this row -->
        <tr>
            <td colspan="7" style="padding: 0px;">
                <hr style="border-top: 0.1px solid black; margin: 5px 0;">
            </td>
        </tr>
        <tr>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">
                {{ $cetakpdf->ban->kode_ban }}
            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">
                {{ $cetakpdf->ban->no_seri }}
            </td>
            <td class="td" style="text-align: right; font-size: 12px;">
                {{ number_format($cetakpdf->ban->km_pemasangan, 0, ',', '.') }}
            </td>
            <td class="td" style="text-align: right; font-size: 12px;">
                {{ number_format($cetakpdf->ban->target_km_ban, 0, ',', '.') }}
            </td>
            <td class="td" style="text-align: right; font-size: 12px;">
                {{ number_format($cetakpdf->ban->km_pelepasan, 0, ',', '.') }}
            </td>
            <td class="td" style="text-align: right; font-size: 12px;">
                {{ number_format($cetakpdf->ban->km_terpakai, 0, ',', '.') }}
            </td>
            <td class="td" style="text-align: right; padding-right: 23px; font-size: 12px;">
                {{ number_format($cetakpdf->harga_klaim, 0, ',', '.') }}
            </td>
        </tr>

        <tr style="border-bottom: 1px solid black;">
            <td colspan="7"></td>
        </tr>
        <tr>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">
            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">
            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">
            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">
            </td>
            <td class="td" style="text-align: center; padding: 2px; font-size: 12px;">
            </td>
            <td class="td" style="text-align: center; padding: 2px; font-size: 12px;">
            </td>
            <td class="td" style="text-align: right; padding-right: 23px; font-size: 12px;">
                {{ number_format($cetakpdf->harga_klaim, 0, ',', '.') }}
            </td>
        </tr>
        
        <tr>
        </tr>
    </table>


    {{-- <hr style="border-top: 0.5px solid black; margin: 3px 0;"> --}}
    {{-- <table style="width: 100%;" cellpadding="2" cellspacing="0">
        <tr style="color: white">
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">No.</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">Nama Tarif</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">Harga</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">Qty</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">Satuan</td>
            <td class="td" style="text-align: right; padding-right: 23px; font-size: 12px;">Total</td>
        </tr>

        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td colspan="8"></td>
        </tr>
        <tr>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">
            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">
            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">
            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">
            </td>
            <td class="td" style="text-align: right; padding: 2px; font-size: 12px;">
                Grand Total :
            </td>
            <td class="td" style="text-align: right; padding-right: 23px; font-size: 12px;">
                0 </td>
        </tr>

        <tr>
        </tr>
    </table> --}}
    <div style="font-size: 12px; margin-right:300px">Keterangan : {{ $cetakpdf->keterangan }}</div>
    <div style=" margin-top:13px; margin-bottom:27px">
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
    </div>

    <div class="container">
        <a href="{{ url('admin/klaim_ban') }}" class="blue-button">Kembali</a>
        <a href="{{ url('admin/klaim_ban/cetak-pdf/' . $cetakpdf->id) }}" class="blue-button">Cetak</a>
    </div>
</body>

</html>
