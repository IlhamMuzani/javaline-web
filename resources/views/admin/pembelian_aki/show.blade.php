<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Faktur Pembelian Aki</title>
    <style>
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
            font-family: Arial, sans-serif;
            /*font-family: 'DOSVGA', Arial, Helvetica, sans-serif;*/
            /*font-weight: bold;*/
            color: black;
            margin-top: 10px;
            margin-left: 20px;
            margin-right: 20px;
        }

        span.h2 {
            font-size: 24px;
            /* font-weight: 500; */
        }

        .label {
            font-size: 16px;
            /* Sesuaikan ukuran label sesuai preferensi Anda */
            text-align: center;
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
            position: relative;
            margin-top: 7rem;
        }

        .faktur {
            text-align: center
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

        /* .nama-pt {
            color: black;
            font-weight: bold;
        }

        .alamat {
            color: black;
            font-weight: bold;
        } */

        .alamat,
        .nama-pt {
            color: black;
            font-weight: bold;
        }

        .label {
            color: black;
            /* Atur warna sesuai kebutuhan Anda */
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

        .flex-container {
            display: flex;
            justify-content: space-between;
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

        @page {
            /* size: A4; */
            margin: 1cm;
        }
    </style>
</head>

<body style="margin: 0; padding: 0;">
    {{-- <div id="logo-container">
        <img src="{{ asset('storage/uploads/user/logo.png') }}" alt="Java Line" width="100" height="50">
    </div> --}}
    <br>
    <table cellpadding="2" cellspacing="0">
        <tr>
            <td class="info-catatan2" style="font-size: 13px;">PT. JAVA LINE LOGISTICS</td>
            <td class="info-catatan2" style="font-size: 13px; margin-left: 40px; display: block;">Nama Supplier</td>
            <td style="text-align: left; font-size: 13px;">
                <span class="content2">
                    {{ $cetakpdf->supplier->nama_supp }}
                </span>
                <br>
            </td>
        </tr>
        <tr>
            <td class="info-text info-left" style="font-size: 13px;">JL. HOS COKRO AMINOTO NO. 5
                {{-- <br>
                SLAWI TEGAL <br>
                Telp/ Fax 02836195326 02836195187 --}}
            </td>
            </td>
            <td class="info-catatan2" style="font-size: 13px; margin-left: 40px; display: block;">Alamat</td>
            <td style="text-align: left; font-size: 13px;">
                <span class="content2">
                    {{ $cetakpdf->supplier->alamat }}
                </span>
                <br>
            </td>
        </tr>
        <tr>
            <td class="info-text info-left" style="font-size: 13px;">SLAWI TEGAL
            </td>
            <td class="info-catatan2" style="font-size: 13px; margin-left: 40px; display: block;">Telp / Hp</td>
            <td style="text-align: left; font-size: 13px;">
                <span class="content2">
                    {{ $cetakpdf->supplier->telp }} /
                    {{ $cetakpdf->supplier->hp }}
                </span>
                <br>
            </td>
        </tr>
        <tr>
            <td class="info-text info-left" style="font-size: 13px;">Telp/ Fax 02836195326 02836195187
            </td>
            <td class="info-catatan2" style="font-size: 13px; margin-left: 40px; display: block;">ID Supplier</td>

            <td style="text-align: left; font-size: 13px;">
                <span class="content2">
                    {{ $cetakpdf->supplier->kode_supplier }}
                </span>
                <br>
            </td>
        </tr>
    </table>

    <div style="font-weight: bold; text-align: center;">
        <span style="font-weight: bold; font-size: 19px;">FAKTUR PEMBELIAN AKI</span>
        <br>
    </div>
    <table style="width: 100%;
                    border-top: 1px solid black; margin-bottom:5px">
        <tr>
            <td>
                <span class="info-item" style="font-size: 13px; padding-left: 5px;">No. Faktur:
                    {{ $cetakpdf->kode_pembelianaki }}</span>
                <br>
            </td>
            <td style="text-align: right; padding-right: 45px;">
                <span class="info-item" style="font-size: 13px;">Tanggal:{{ $cetakpdf->tanggal }}</span>
                <br>
            </td>
        </tr>
    </table>
    {{-- <hr style="border-top: 0.5px solid black; margin: 3px 0;"> --}}
    <table style="width: 100%; border-top: 1px solid black;" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td" style="text-align: center; padding: 5px; font-size: 13px;">No.</td>
            <td class="td" style="text-align: center; padding: 5px; font-size: 13px;">Kode Aki</td>
            <td class="td" style="text-align: left; padding: 5px; font-size: 13px;">No. Seri</td>
            <td class="td" style="text-align: left; padding: 5px; font-size: 13px;">Merek</td>
            <td class="td" style="text-align: center; padding: 5px; font-size: 13px;">Kondisi</td>
            <td class="td" style=" padding: 5px; font-size: 13px; color:white">Rp</td>
            <td class="td" style="text-align: right; padding: 5px; font-size: 13px;">Harga</td>
        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td colspan="8" style="padding: 0px;"></td>
        </tr>
        @php
            $totalQuantity = 0;
            $totalHarga = 0;
        @endphp
        @foreach ($akis as $item)
            <tr>
                <td class="td" style="text-align: center;  font-size: 13px;">{{ $loop->iteration }}
                </td>
                <td class="td" style="text-align: center;  font-size: 13px;">{{ $item->kode_aki }}</td>
                <td class="info-text info-left" style="font-size: 13px; text-align: left;">
                    {{ $item->no_seri }}
                </td>
                <td class="td" style="text-align: left;  font-size: 13px;">
                    {{ $item->merek_aki->nama_merek ?? null }}
                </td>
                <td class="td" style="text-align: center;  font-size: 13px;">{{ $item->kondisi_aki }}
                </td>
                <td class="td" style="text-align: right; font-size: 13px;">
                    Rp.
                </td>
                <td class="td" style="text-align: right;  font-size: 13px;">
                    {{ number_format($item->harga, 2, ',', '.') }}
                </td>
            </tr>
            @php
                $totalQuantity += 1; // Increment by 1 for each item (you can use your actual quantity field here)
                $totalHarga += $item->harga; // Add the item's harga to the total harga
            @endphp
        @endforeach
        <tr style="border-bottom: 1px solid black;">
            <td colspan="6" style="padding: 0px;"></td>
        </tr>
        <tr>
            <td colspan="4"
                style="text-align: right; font-weight: bold; margin-top:5px; margin-bottom:5px; font-size: 13px;">
                Total
                Rp.
            </td>
            <td class="td" style="text-align: right; font-weight: bold; font-size: 13px;">
            </td>
            <td class="td" style="text-align: right; font-weight: bold; font-size: 13px;">
            </td>
            <td class="td" style="text-align: right; font-weight: bold; font-size: 13px;">
                {{ number_format($totalHarga, 2, ',', '.') }}
            </td>
        </tr>
        <tr>
            <td colspan="4"
                style="text-align: right; font-weight: bold; margin-top:5px; margin-bottom:5px; font-size: 13px;">
                Aki Bekas
                Rp.
            </td>
            <td class="td" style="text-align: right; font-weight: bold; font-size: 13px;">
                {{ $cetakpdf->qty_akibekas }} x
            </td>
            <td class="td" style="text-align: right; font-weight: bold; font-size: 13px;">
                {{ number_format($cetakpdf->harga_akibekas, 0, ',', '.') }}
            </td>
            <td class="td" style="text-align: right; font-weight: bold; font-size: 13px;">
                {{ number_format($cetakpdf->total_akibekas, 2, ',', '.') }}
            </td>
        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td colspan="7" style="padding: 0px;"></td>
        </tr>
        <tr>
            <td colspan="4"
                style="text-align: right; font-weight: bold; margin-top:5px; margin-bottom:5px; font-size: 13px;">
                Grand Total
                Rp.
            </td>
            <td class="td" style="text-align: right; font-weight: bold; font-size: 13px;">
            </td>
            <td class="td" style="text-align: right; font-weight: bold; font-size: 13px;">
            </td>
            <td class="td" style="text-align: right; font-weight: bold; font-size: 13px;">
                {{ number_format($cetakpdf->total_harga, 2, ',', '.') }}
            </td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td>
                <div class="info-catatan" style="max-width: 230px;">
                    <table>
                        <tr>
                            <td class="info-catatan2" style="font-size: 13px;">Nama Supplier</td>
                            <td class="info-item" style="font-size: 13px;">:</td>
                            <td class="info-text info-left" style="font-size: 13px;">
                                {{ $cetakpdf->supplier->nama_bank }}
                            </td>
                        </tr>
                        <tr>
                            <td class="info-catatan2" style="font-size: 13px;">No. Rekening</td>
                            <td class="info-item" style="font-size: 13px;">:</td>
                            <td class="info-text info-left" style="font-size: 13px;">
                                {{ $cetakpdf->supplier->norek }}
                            </td>
                        </tr>
                        <tr>
                            <td class="info-catatan2" style="font-size: 13px;">Atas Nama</td>
                            <td class="info-item" style="font-size: 13px;">:</td>
                            <td class="info-text info-left" style="font-size: 13px;">
                                {{ $cetakpdf->supplier->atas_nama }}
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>
    <br>
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
                        <td class="label">Gudang</td>
                    </tr>
                </table>
            </td>
            <td style="text-align: center;">
                <table style="margin: 0 auto;">
                    <tr style="text-align: center;">
                        <td class="label">
                            @if ($cetakpdf->user)
                                {{ $cetakpdf->user->karyawan->nama_lengkap }}
                            @else
                                user tidak ada
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="separator" colspan="2"><span></span></td>
                    </tr>
                    <tr style="text-align: center;">
                        <td class="label">Pembelian</td>
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
                        <td class="label">Accounting</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <div style="text-align: right; font-size:12px; margin-top:25px">
        <span style="font-style: italic;">Printed Date {{ \Carbon\Carbon::now()->format('Y-m-d H:i:s') }}</span>
    </div>
</body>
<div class="container">
    <a href="{{ url('admin/pembelian-aki') }}" class="blue-button">Kembali</a>
    <a href="{{ url('admin/pembelian-aki/cetak-pdf/' . $cetakpdf->id) }}" class="blue-button">Cetak</a>
</div>

</html>
