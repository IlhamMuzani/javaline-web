<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Faktur Penjualan Return Barang Ekspedisi</title>
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
    <table class="tdd" cellpadding="10" cellspacing="0" style="margin: 0 auto;">
        <tr>
            {{-- pemilik pt  --}}
            <td style="text-align: left; width: 30%;">
                <table style="margin: 0 auto;">
                    <tr style="text-align: left;">
                        <td style="font-size: 12px; font-weight:bold" class="label2">PT. JAVA LINE LOGISTICS
                        </td>
                    </tr>
                    <tr>
                        <td class="label2">JL. HOS COKRO AMINOTO NO. 5</td>
                    </tr>
                    <tr style="text-align: left;">
                        <td class="label2">SLAWI TEGAL</td>
                    </tr>
                    <tr style="text-align: left;">
                        <td class="label2">Telp/ Fax 02836195326 02836195187</td>
                    </tr>
                    <tr style="text-align: left; background:whi">
                        <td class="label2">.</td>
                    </tr>
                </table>
            </td>
            {{-- pelanggan --}}
            <td style="text-align: left; width: 50%;">
                <table style="margin: 0 auto;">
                    <tr style="text-align: left;">
                        <td class="label2" style="width: 23%; font-weight:bold">Nama Pelanggan</td>
                        <td class="label2" style="width: 5%;">:</td>
                        <td class="label2" style="width: 67%;">{{ $cetakpdf->nama_pelanggan }}</td>
                    </tr>
                    <tr>
                        <td class="label2" style="font-weight:bold">Alamat</td>
                        <td class="label2">:</td>
                        <td class="label2"> {{ $cetakpdf->alamat_pelanggan }}</td>
                    </tr>
                    <tr style="text-align: left;">
                        <td class="label2" style="font-weight:bold">Telp</td>
                        <td class="label2">:</td>
                        <td class="label2">{{ $cetakpdf->telp }}</td>
                    </tr>
                    <tr style="text-align: left;">
                        <td class="label2" style="font-weight:bold">Id Pelanggan</td>
                        <td class="label2">:</td>
                        <td class="label2"> {{ $cetakpdf->kode_pelanggan }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <div style="font-weight: bold; text-align: center">
        <span style="font-weight: bold; font-size: 17px;">FAKTUR PENJUALAN RETURN EKSPEDISI</span>
        <br>
    </div>
    <hr style="border-top: 0.1px solid black; margin: 3px 0;">
    <table style="width: 100%;" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">No.
                Faktur:{{ $cetakpdf->kode_penjualan }}</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">
                Tanggal:{{ $cetakpdf->tanggal }}</td>
        </tr>
    </table>
    {{-- <hr style="border-top: 0.5px solid black; margin: 3px 0;"> --}}
    <table style="width: 100%; border-top: 1px solid black; margin-top:7px" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td" style="text-align: center; padding: 5px; font-size: 12px;">No.</td>
            <td class="td" style="text-align: center; padding: 5px; font-size: 12px;">Kode Barang</td>
            <td class="td" style="text-align: left; padding: 5px; font-size: 12px;">Nama Barang</td>
            <td class="td" style="text-align: right; padding: 5px; font-size: 12px;">Qty</td>
            <td class="td" style="text-align: left; padding: 5px; font-size: 12px;">Satuan</td>
            <td class="td" style="text-align: right; padding: 5px; font-size: 12px;">Harga</td>
            <td class="td" style="text-align: right; padding: 5px; font-size: 12px;">Diskon</td>
            <td class="td" style="text-align: right; padding: 5px; font-size: 12px;">Total</td>
        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td colspan="8" style="padding: 0px;"></td>
        </tr>
        @php
            $totalQuantity = 0;
            $totalHarga = 0;

            $diskonquantity = 0;
            $totalDiskon = 0;
        @endphp
        @foreach ($details as $item)
            <tr>
                <td class="td" style="text-align: center;  font-size: 12px;">{{ $loop->iteration }}
                </td>
                <td class="td" style="text-align: center;  font-size: 12px;">{{ $item->kode_barang }}</td>
                <td class="info-text info-left" style="font-size: 12px; text-align: left;">
                    {{ $item->nama_barang }}
                </td>
                <td class="td" style="text-align: right; font-size: 12px;">
                    {{ $item->jumlah }}
                </td>
                <td class="td" style="text-align: left;  font-size: 12px;">
                    {{ $item->satuan }}
                    {{-- {{ number_format($item->harga_beli, 0, ',', '.') }} --}}
                </td>
                <td class="td" style="text-align: right;  font-size: 12px;">
                    {{ number_format($item->harga_jual, 0, ',', '.') }}
                </td>
                <td class="td" style="text-align: right; font-size: 12px;">
                    {{ number_format($item->diskon, 0, ',', '.') }}
                </td>
                <td class="td" style="text-align: right;  font-size: 12px;">
                    {{ number_format($item->total, 0, ',', '.') }}
                </td>
            </tr>
            @php
                $totalQuantity += 1;
                $totalHarga += $item->total;

                $diskonquantity = 1;
                $totalDiskon += $item->diskon;

                $hasilpotongan = $totalHarga - $totalDiskon;
            @endphp
        @endforeach
        <tr style="border-bottom: 1px solid black;">
            <td colspan="9" style="padding: 0px;"></td>
        </tr>
        <tr>
            <td colspan="6"
                style="text-align: right; font-weight: bold; margin-top:5px; margin-bottom:5px; font-size: 12px;">
            </td>
            <td class="td" style="text-align: right; font-weight: bold; font-size: 12px;">
                {{ number_format($totalDiskon, 0, ',', '.') }}
            </td>
            <td class="td" style="text-align: right; font-weight: bold; font-size: 12px;">
                {{ number_format($totalHarga, 0, ',', '.') }}
            </td>
        </tr>
    </table>

    <table style="width: 100%;" cellpadding="2" cellspacing="0">
        <tr>
            <td colspan="6" style="text-align: right; padding-left: 325px; font-size: 12px;">Potongan
            </td>
            <td class="td" style="text-align: right; font-size: 12px;">
                {{ number_format($totalDiskon, 0, ',', '.') }}
            </td>
        </tr>
        <tr>
            <td colspan="6" style="text-align: right; padding: 0px; font-size: 12px;">Grand Total</td>
            <td class="td" style="text-align: right; font-weight: bold; font-size: 12px;">
                Rp. {{ number_format($hasilpotongan, 0, ',', '.') }}
            </td>
        </tr>
    </table>


    <br><br>

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
                        <td class="label">Pelanggan</td>
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


    <div style="text-align: right; font-size:12px; margin-top:25px">
        <span style="font-style: italic;">Printed Date {{ \Carbon\Carbon::now()->format('Y-m-d H:i:s') }}</span>
    </div>
</body>

</html>
