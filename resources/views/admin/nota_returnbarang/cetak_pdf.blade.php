<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nota Return Barang</title>
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
            margin-top: 30px;
            margin-right: 50px;
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
    <div style="font-weight: bold; text-align: center">
        <span style="font-weight: bold; font-size: 23px;">NOTA RETURN BARANG EKSPEDISI</span>
        <br>
        <br>
    </div>
    <table cellpadding="2" cellspacing="0">
        <tr>
            <td style="font-size: 13px; display: block; text-align: left;">Nama Pelanggan</td>
            <td style="text-align: left; font-size: 13px;">
                <span class="content2">: {{ $cetakpdf->nama_pelanggan }}</span>
                <br>
            </td>
            <td style="font-size: 13px; display: block; margin-left: 10px; text-align: left;">No Mobil</td>
            <td style="text-align: left; font-size: 13px;">
                <span class="content2">: {{ $cetakpdf->no_pol }}</span>
                <br>
            </td>
        </tr>
        <tr>
            <td style="font-size: 13px; display: block; text-align: left;">Alamat</td>
            <td style="text-align: left; font-size: 13px; width: 35%;">
                <span class="content2">: {{ $cetakpdf->alamat_pelanggan }}</span>
                <br>
            </td>
            <td style="font-size: 13px; display: block; margin-left: 10px; text-align: left;">Kode Sopir</td>
            <td style="text-align: left; font-size: 13px;">
                <span class="content2">: {{ $cetakpdf->kode_driver }}</span>
            </td>
        </tr>
        <tr>
            <td style="font-size: 13px; display: block; text-align: left;">Telp / Hp</td>
            <td style="text-align: left; font-size: 13px;">
                <span class="content2">: {{ $cetakpdf->telp_pelanggan }}</span>
                <br>
            </td>
            <td style="font-size: 13px; display: block; margin-left: 10px; text-align: left;">Nama Sopir</td>
            <td style="text-align: left; font-size: 13px;">
                <span class="content2">: {{ $cetakpdf->nama_driver }}</span>
                <br>
            </td>
        </tr>
        <tr>
            <td style="font-size: 13px; display: block; text-align: left;">ID Pelanggan</td>
            <td style="text-align: left; font-size: 13px;">
                <span class="content2">: {{ $cetakpdf->kode_pelanggan }}</span>
                <br>
            </td>
            <td style="font-size: 13px; display: block; margin-left: 10px; text-align: left;">Telp / Hp</td>
            <td style="text-align: left; font-size: 13px;">
                <span class="content2">: {{ $cetakpdf->telp }}</span>
                <br>
            </td>
        </tr>
    </table>
    <hr style="border-top: 0.1px solid black; margin: 3px 0;">

    <table style="width: 100%; margin-bottom: 5px" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">No.
                Faktur:{{ $cetakpdf->kode_nota }}</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">
                Tanggal:{{ $cetakpdf->tanggal }}</td>
        </tr>
    </table>
    {{-- <hr style="border-top: 0.5px solid black; margin: 3px 0;"> --}}
    <table style="width: 100%; border-top: 1px solid black;" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td" style="text-align: center; padding: 5px; font-size: 13px;">No.</td>
            <td class="td" style="text-align: left;  font-size: 13px;">Kode Barang</td>
            <td class="td" style="text-align: left;  font-size: 13px;">Nama Barang</td>
            <td class="td" style="text-align: right; font-size: 13px;">Qty</td>
            <td class="td" style="text-align: right; font-size: 13px;">Harga</td>
            <td class="td" style="text-align: right; font-size: 13px;">Total</td>
        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td colspan="5" style="padding: 0px;"></td>
        </tr>
        @php
            $totalQuantity = 0;
            $totalHarga = 0;

            $diskonquantity = 0;
            $totalDiskon = 0;
        @endphp
        @foreach ($details as $item)
            <tr>
                <td class="td" style="text-align: center;  font-size: 13px;">{{ $loop->iteration }}
                </td>
                <td class="td" style="text-align: left;  font-size: 13px;">{{ $item->kode_barang }}</td>
                <td class="info-text info-left" style="font-size: 13px; text-align: left;">
                    {{ $item->nama_barang }}
                </td>
                <td class="td" style="text-align: right; font-size: 13px;">
                    {{ $item->jumlah }}
                </td>
                <td class="td" style="text-align: right;  font-size: 13px;">
                    {{ number_format($item->harga, 2, ',', '.') }}
                </td>
                <td class="td" style="text-align: right;  font-size: 13px;">
                    {{ number_format($item->total, 2, ',', '.') }}
                </td>
            </tr>
            @php
                $totalQuantity += 1;
                $totalHarga += $item->total;

                $diskonquantity = 1;
                $totalDiskon += $item->diskon;
            @endphp
        @endforeach
        <tr style="border-bottom: 1px solid black;">
            <td colspan="6" style="padding: 0px;"></td>
        </tr>
        <tr>
            <td colspan="4"
                style="text-align: right; font-weight: bold; margin-top:5px; margin-bottom:5px; font-size: 13px;">
            </td>
            <td class="td" style="text-align: right; font-weight: bold; font-size: 13px;">
                Sub Total
            </td>
            <td class="td" style="text-align: right; font-weight: bold; font-size: 13px;">
                {{ number_format($totalHarga, 2, ',', '.') }}
            </td>
        </tr>
    </table>

    {{-- <table style="width: 100%;" cellpadding="2" cellspacing="0">
        <tr>
            <td colspan="4" style="text-align: right; padding-left: 78px; font-size: 13px;">Potongan
            </td>
            <td class="td" style="text-align: right; font-size: 13px;">
                0
            </td>
        </tr>
        <tr>
            <td colspan="4" style="text-align: right; padding: 0px; font-size: 13px;">Grand Total</td>
            <td class="td" style="text-align: right;  font-size: 13px;">
                {{ number_format($totalHarga, 0, ',', '.') }}
            </td>
        </tr>
    </table> --}}


    <br><br><br>

    <table class="tdd" cellpadding="10" cellspacing="0" style="margin: 0 auto;">
        <tr>
            <td style="text-align: center;">
                <table style="margin: 0 auto;">
                    <tr style="text-align: center;">
                        <td class="label">Mengetahui</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
                <table style="margin: 0 auto;">
                    <tr style="text-align: center;">
                        <td class="label">DJOHAN WAHYUDI</td>
                    </tr>
                    <tr>
                        <td class="separator" colspan="2"><span></span></td>
                    </tr>
                    <tr style="text-align: center;">
                        <td class="label">DIREKTUR</td>
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
                        <td class="label">ADMIN JAVA LINE</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <div style="text-align: right; font-size:12px; margin-top:25px">
        <span style="font-style: italic;">Printed Date {{ \Carbon\Carbon::now()->format('Y-m-d H:i:s') }}</span>
    </div>
</body>

</html>
