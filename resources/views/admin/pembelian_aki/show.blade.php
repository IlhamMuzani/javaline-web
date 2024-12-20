<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>faktur Pembelian Aki</title>
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
            margin: 10px;
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

        .info-1 {}
    </style>
</head>

<body style="margin: 0; padding: 0;">
    <br>
    <div style="font-weight: bold; text-align: center">
        <span style="font-weight: bold; font-size: 22px;">FAKTUR PEMBELIAN AKI</span>
        <br>
        <br>
    </div>
    <table width="100%">
        <tr>
            <td>
                <div class="info-catatan" style="max-width: 230px;">
                    <table>
                        <tr>
                            <td class="info-catatan2">Nama Supplier</td>
                            <td class="info-item">:</td>
                            <td class="info-text info-left">{{ $cetakpdf->supplier->nama_supp ?? null }}</td>
                        </tr>
                        <tr>
                            <td class="info-catatan2">Alamat</td>
                            <td class="info-item">:</td>
                            <td class="info-text info-left">{{ $cetakpdf->supplier->alamat ?? null }}</td>
                        </tr>
                        <tr>
                            <td class="info-catatan2">Telp / HP</td>
                            <td class="info-item">:</td>
                            <td class="info-text info-left">{{ $cetakpdf->supplier->telp ?? null }} /
                                {{ $cetakpdf->supplier->hp ?? null }}</td>
                        </tr>
                        <tr>
                            <td class="info-catatan2">ID Supplier</td>
                            <td class="info-item">:</td>
                            <td class="info-text info-left">{{ $cetakpdf->supplier->kode_supplier ?? null }}</td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>
    <hr style="border-top: 0.5px solid black; margin: 3px 0;">
    <table width="100%">
        <tr>
            <td>
                <span class="info-item">No. Faktur: {{ $cetakpdf->kode_pembelianaki }}</span>
                <br>
            </td>
            <td style="text-align: right;">
                {{-- <span class="info-item">Tanggal:{{ now()->format('d-m-Y') }}</span> --}}
                <span class="info-item">Tanggal:{{ $cetakpdf->tanggal }}</span>
                <br>
            </td>
        </tr>
    </table>
    <hr style="border-top: 0.5px solid black; margin: 3px 0;">
    <table style="width: 100%;" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td" style="text-align: center; padding: 0px;">No.</td>
            <td class="td" style="text-align: center; padding: 2px;">Kode Aki</td>
            <td class="td" style="text-align: center; padding: 2px;">No. Seri</td>
            <td class="td" style="text-align: center; padding: 2px;">Merek</td>
            <td class="td" style="text-align: center; padding: 2px;">Kondisi</td>
            <td class="td" style="text-align: center; padding: 2px;">Harga</td>
        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td colspan="7" style="padding: 0px;">
            </td>
        </tr>
        @php
            $totalQuantity = 0;
            $totalHarga = 0;
        @endphp
        @foreach ($akis as $item)
            <tr>
                <td class="td" style="text-align: center; padding: 0px;">{{ $loop->iteration }}</td>
                <td class="td" style="text-align: center; padding: 2px;">{{ $item->kode_aki }}</td>
                <td class="td" style="text-align: center; padding: 2px;">{{ $item->no_seri }}</td>
                <td class="td" style="text-align: center; padding: 2px;">{{ $item->merek_aki->nama_merek ?? null }}
                </td>
                <td class="td" style="text-align: center; padding: 2px;">{{ $item->kondisi_aki }}</td>
                <td class="td" style="text-align: center; padding: 2px;">Rp.
                    {{ number_format($item->harga, 0, ',', '.') }}</td>
            </tr>
            @php
                $totalQuantity += 1; // Increment by 1 for each item (you can use your actual quantity field here)
                $totalHarga += $item->harga; // Add the item's harga to the total harga
            @endphp
        @endforeach
        <tr style="border-bottom: 1px solid black;">
            <td colspan="5" style="padding: 0px;">
            </td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: right; font-weight: bold; padding: px;">Sub Total</td>
            <td class="td" style="text-align: center; font-weight: bold; padding: 5px;">Rp.
                {{ number_format($totalHarga, 0, ',', '.') }}</td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td>
                <div class="info-catatan" style="max-width: 230px;">
                    <table>
                        <tr>
                            <td class="info-catatan2">Nama Supplier</td>
                            <td class="info-item">:</td>
                            <td class="info-text info-left">{{ $cetakpdf->supplier->nama_bank ?? null }}</td>
                        </tr>
                        <tr>
                            <td class="info-catatan2">No. Rekening</td>
                            <td class="info-item">:</td>
                            <td class="info-text info-left">{{ $cetakpdf->supplier->norek ?? null }}</td>
                        </tr>
                        <tr>
                            <td class="info-catatan2">Atas Nama</td>
                            <td class="info-item">:</td>
                            <td class="info-text info-left">{{ $cetakpdf->supplier->atas_nama ?? null }}</td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>

    <br><br><br>

    <table class="tdd" style="width: 100%;" cellpadding="10" cellspacing="0">
        <tr>
            <td style="text-align: center">Gudang</td>
            <td style="text-align: center">Pembelian</td>
            <td style="text-align: center">Accounting</td>
        </tr>
    </table>
</body>

<div class="container">
    <a href="{{ url('admin/pembelian-aki') }}" class="blue-button">Kembali</a>
    <a href="{{ url('admin/pembelian-aki/cetak-pdf/' . $cetakpdf->id) }}" class="blue-button">Cetak</a>
</div>

</html>
