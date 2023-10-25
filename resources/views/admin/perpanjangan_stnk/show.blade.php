<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Surat Perpanjangan Stnk</title>
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
            margin: 40px;
            padding: 10px;
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
            font-size: 13px;
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
            font-size: 13px;
            text-align: center;
            /* Teks menjadi berada di tengah */

        }

        .separator {
            padding-top: 15px;
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
    <div id="logo-container">
        <img src="{{ asset('storage/uploads/user/logo.png') }}" alt="Java Line" width="100" height="50">
    </div>
    <br>
    <div style="font-weight: bold; text-align: center">
        <span style="font-weight: bold; font-size: 20px;">SURAT PERPANJANGAN STNK</span>
        <br>
        <br>
    </div>
    <hr style="border-top: 0.5px solid black; margin: 3px 0;">
    <table style="width: 100%;" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td" style="text-align: center; padding: 0px; font-size: 14px;">
                Kode Perpanjangan:{{ $laporan->kode_perpanjangan }}</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 14px;">
                Tanggal:{{ $cetakpdf->tanggal }}</td>
        </tr>
    </table>
    </div>
    <hr style="border-top: 0.5px solid black; margin: 3px 0;">
    <table style="width: 100%;" cellpadding="2" cellspacing="0">
        <tr>
            {{-- <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">No.</td> --}}
            <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">No. Kabin</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">No. Registrasi</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">Berlaku Sampai</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">Jumlah</td>
        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td colspan="7" style="padding: 0px;">
            </td>
        </tr>
        {{-- @foreach ($bans as $item) --}}
        <tr>
            {{-- <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">{{ $loop->iteration }}
                </td> --}}
            <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">
                {{ $cetakpdf->kendaraan->no_kabin }}
            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">
                {{ $cetakpdf->kendaraan->no_pol }}
            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">{{ $cetakpdf->expired_stnk }}
            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">
                Rp.{{ number_format($cetakpdf->jumlah, 0, ',', '.') }}
            </td>
        </tr>
        {{-- @endforeach --}}
        <tr style="border-bottom: 1px solid black;">
            <td colspan="7" style="padding: 0px;">
            </td>
        </tr>
    </table>

    <br><br><br>

    <table class="tdd" cellpadding="10" cellspacing="0">
        <tr>
            <td>
                <table>
                    <tr>
                        <td class="label">{{ auth()->user()->karyawan->nama_lengkap }}</td>
                    </tr>

                    <tr>
                        <td class="separator" colspan="2"><span></span></td>
                    </tr>
                    <tr>
                        <td class="label">Operasional</td>
                    </tr>
                </table>
            </td>
            <td>
                <table>
                    <tr>
                        <td class="label">.</td>
                    </tr>
                    <tr>
                        <td class="separator" colspan="2"><span></span></td>
                    </tr>
                    <tr>
                        <td class="label">Financial</td>
                    </tr>
                </table>
            </td>
            <td>
                <table>
                    <tr>
                        <td class="label">.</td>
                    </tr>
                    <tr>
                        <td class="separator" colspan="2"><span></span></td>
                    </tr>
                    <tr>
                        <td class="label">Accounting</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>


<div class="container">
    <a href="{{ url('admin/perpanjangan_stnk') }}" class="blue-button">Kembali</a>
    <a href="{{ url('admin/perpanjangan_stnk/cetak-pdf/' . $cetakpdf->id) }}" class="blue-button">Cetak</a>
</div>

</html>
