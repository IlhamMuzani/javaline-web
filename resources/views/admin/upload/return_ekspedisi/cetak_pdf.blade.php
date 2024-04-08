<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Return Barang</title>
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
            font-family: 'DOSVGA', monospace;
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
            font-size: 13px;
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
            text-align: left;
            /* Teks menjadi berada di tengah */

        }

        .separator {
            padding-top: 13px;
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
        <span style="font-weight: bold; font-size: 23px;">SURAT PENERIMAAN RETURN BARANG EKSPEDISI</span>
        <br>
        <br>
    </div>
    <table cellpadding="2" cellspacing="0">
        <tr>
            <td class="text-align: left" style="font-size: 13px; display: block;">Nama Pelanggan</td>
            <td style="text-align: left; font-size: 13px;">
                <span class="content2">
                    :{{ $cetakpdf->nama_pelanggan }} </span>
                <br>
            </td>
            <td class="text-align: left" style="font-size: 13px; margin-left: 40px; display: block;">No Mobil</td>
            <td style="text-align: left; font-size: 13px;">
                <span class="content2">
                    :{{ $cetakpdf->no_pol }} </span>
                <br>
            </td>
        </tr>
        <tr>
            <td style="font-size: 13px; display: block;">Alamat</td>
            <td style="text-align: left; font-size: 13px; width: 35%;">
                <span class="content2">
                    :{{ $cetakpdf->alamat_pelanggan }}</span>
                <br>
            </td>
            
            </td>
            <td style="font-size: 13px; margin-left: 40px; display: block;">Kode Sopir</td>
            <td style="text-align: left; font-size: 13px;">
                    :{{ $cetakpdf->kode_driver }}
            </td>
        </tr>
        <tr>
            <td style="font-size: 13px; display: block;">Telp / Hp</td>
            <td style="text-align: left; font-size: 13px;">
                <span class="content2">
                    :{{ $cetakpdf->telp_pelanggan }}
                </span>
                <br>
            </td>
            <td style="font-size: 13px; margin-left: 40px; display: block;">Nama Sopir</td>
            <td style="text-align: left; font-size: 13px;">
                <span class="content2">
                    :{{ $cetakpdf->nama_driver }}</span>
                <br>
            </td>
        </tr>
        <tr>
            <td style="font-size: 13px; display: block;">ID Pelanggan</td>
            <td style="text-align: left; font-size: 13px;">
                <span class="content2">
                    :{{ $cetakpdf->kode_pelanggan }}
                </span>
                <br>
            </td>
            <td style="font-size: 13px; margin-left: 40px; display: block;">Telp / Hp</td>
            <td style="text-align: left; font-size: 13px;">
                <span class="content2">
                    :{{ $cetakpdf->telp }}</span>
                <br>
            </td>
        </tr>
    </table>

    {{-- <table class="tdd" cellpadding="10" cellspacing="0" style="margin: 0 auto;">
        <tr>
            <td style="text-align: left;">
                <table style="margin: 0 auto;">
                    <tr style="text-align: left;">
                        <td class="label">Alamat</td>
                        
                    </tr>
                    <tr style="text-align: left;">
                        <td class="label">Driver</td>
                    </tr>
                    <tr style="text-align: left;">
                        <td class="label">Driver</td>
                    </tr>
                </table>
            </td>
            <td style="text-align: left;">
                <table style="margin: 0 auto;">
                    <tr style="text-align: left;">
                        <td class="label">Gudang</td>
                        <td class="label">:</td>
                        <td class="label">jasfkhj jhasfjk jkhj asfjkhka sjhkjas fjhjkja sjk</td>
                    </tr>
                    <tr style="text-align: left;">
                        <td class="label">Gudang</td>
                    </tr>
                    <tr style="text-align: left;">
                        <td class="label">Gudang</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table> --}}
    <hr style="border-top: 0.1px solid black; margin: 3px 0;">
    <table style="width: 100%; margin-bottom:5px" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">No.
                Faktur:{{ $cetakpdf->kode_return }}</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">
                Tanggal:{{ $cetakpdf->tanggal }}</td>
        </tr>
    </table>
    {{-- <hr style="border-top: 0.5px solid black; margin: 3px 0;"> --}}
    <table style="width: 100%; border-top: 1px solid black;" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td" style="text-align: center; padding: 5px; font-size: 13px;">No.</td>
            <td class="td" style="text-align: center; padding: 5px; font-size: 13px;">Kode Barang</td>
            <td class="td" style="text-align: center; padding: 5px; font-size: 13px;">Nama Barang</td>
            <td class="td" style="text-align: center; padding: 5px; font-size: 13px;">Satuan</td>
            <td class="td" style="text-align: center; padding: 5px; font-size: 13px;">Qty</td>
        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td colspan="8" style="padding: 0px;"></td>
        </tr>

        @foreach ($details as $item)
            <tr>
                <td class="td" style="text-align: center;  font-size: 13px;">{{ $loop->iteration }}
                </td>
                <td class="td" style="text-align: center;  font-size: 13px;">{{ $item->kode_barang }}</td>
                <td class="info-text info-left" style="font-size: 13px; text-align: center;">
                    {{ $item->nama_barang }}
                </td>
                <td class="info-text info-left" style="font-size: 13px; text-align: center;">
                    {{ $item->satuan }}
                </td>
                <td class="td" style="text-align: center; font-size: 13px;">
                    {{ $item->jumlah }}
                </td>
                </td>
            </tr>
        @endforeach
        <tr style="border-bottom: 1px solid black;">
            <td colspan="8" style="padding: 0px;"></td>
        </tr>

    </table>
    <br><br><br>

    <table class="tdd" cellpadding="10" cellspacing="0" style="margin: 0 auto;">
        <tr>
            <td style="text-align: center;">
                <table style="margin: 0 auto;">
                    <tr style="text-align: center;">
                        <td class="label">
                            {{ $cetakpdf->nama_driver }}
                        </td>
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
                        <td class="label" style="min-height: 13px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="separator" colspan="2"><span></span></td>
                    </tr>
                    <tr style="text-align: center;">
                        <td class="label">Gudang</td>
                    </tr>
                </table>
            </td>
            <td style="text-align: center;">
                <table style="margin: 0 auto;">
                    <tr style="text-align: center;">
                        <td class="label">
                            {{ $cetakpdf->admin }}
                        </td>
                    </tr>
                    <tr>
                        <td class="separator" colspan="2"><span></span></td>
                    </tr>
                    <tr style="text-align: center;">
                        <td class="label">Accounting</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
