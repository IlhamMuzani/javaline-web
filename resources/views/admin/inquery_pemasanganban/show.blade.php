<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Surat Pemasangan Ban</title>
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

        .faktur {
            text-align: center
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
        <img src="{{ asset('storage/uploads/user/logo1.png') }}" alt="Java Line" width="150" height="60">
    </div>
    <br>
    <div style="font-weight: bold; text-align: center">
        <span style="font-weight: bold; font-size: 20px;">SURAT PEMASANGAN BAN</span>
        <br>
        <br>
    </div>
    <hr style="border-top: 0.5px solid black; margin: 3px 0;">

    <table style="width: 100%;" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td" style="text-align: center; padding: 0px; font-size: 14px;">No.
                Kabin:{{ $kendaraan->no_kabin }}</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 14px;">Jenis
                Kendaraan:{{ $kendaraan->jenis_kendaraan->nama_jenis_kendaraan }}</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 14px;">Total
                Ban:{{ $kendaraan->jenis_kendaraan->total_ban }}</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 14px;">
                Tanggal:{{ $pemasangan_ban->tanggal }}</td>
        </tr>
    </table>
    </div>
    <hr style="border-top: 0.5px solid black; margin: 3px 0;">
    <table style="width: 100%;" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">No.</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">Posisi Ban</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">Kode Ban</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">No. Seri</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">Ukuran</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">Merek</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">Kondisi</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">Km Pemasangan</td>
        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td colspan="7" style="padding: 0px;">
            </td>
        </tr>
        @foreach ($bans as $item)
            <tr>
                <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">{{ $loop->iteration }}
                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">
                    {{ $item->posisi_ban }}
                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">{{ $item->kode_ban }}
                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">{{ $item->no_seri }}
                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">
                    {{ $item->ukuran->ukuran }}</td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">
                    {{ $item->merek->nama_merek }}</td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">
                    {{ number_format($item->jumlah_km, 0, ',', '.') }} km
                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">
                    {{ number_format($item->km_pemasangan, 0, ',', '.') }} km
                </td>
            </tr>
        @endforeach
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
                        <td class="label">
                            @if ($pemasangan_ban->user)
                                {{ $pemasangan_ban->user->karyawan->nama_lengkap }}
                            @else
                                user tidak ada
                            @endif
                        </td>
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
                        <td class="label">SPV Ban</td>
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
    {{-- <a href="{{ url('admin/inquery_pemasanganban') }}" class="blue-button">Kembali</a> --}}
    <a href="{{ url('admin/inquery_pemasanganban') . '?status=&tanggal_awal=' . $pemasangan_ban->tanggal_awal . '&tanggal_akhir=' . $pemasangan_ban->tanggal_awal . '&ids=' }}"
        class="blue-button">
        Kembali
    </a>
    <a href="{{ url('admin/pemasangan_ban/cetak-pdf/' . $pemasangan_ban->id) }}" class="blue-button">Cetak</a>
</div>

</html>
