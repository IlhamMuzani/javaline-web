<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>faktur Pembelian Part</title>
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
        font-family: Arial, Helvetica, sans-serif;
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
        font-family: Arial, sans-serif;
        /* Contoh penggunaan jenis font Times New Roman */

        /* Menetapkan lebar minimum untuk kolom pertama */
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
    <div style="font-weight: bold; text-align: center">
        <span style="font-weight: bold; font-size: 17px;">FAKTUR PEMBELIAN PART</span>
        <br>
    </div>
    <table width="100%">
        <tr>
            <td>
                <div class="info-catatan" style="max-width: 230px;">
                    <table>
                        <tr>
                            <td class="info-catatan2" style="font-size: 13px;">Nama Supplier</td>
                            <td class="info-item" style="font-size: 13px;">:</td>
                            <td class="info-text info-left" style="font-size: 13px;">
                                {{ $pembelians->supplier->nama_supp }}
                            </td>
                        </tr>
                        <tr>
                            <td class="info-catatan2" style="font-size: 13px;">Alamat</td>
                            <td class="info-item" style="font-size: 13px;">:</td>
                            <td class="info-text info-left" style="font-size: 13px;">
                                {{ $pembelians->supplier->alamat }}
                            </td>
                        </tr>
                        <tr>
                            <td class="info-catatan2" style="font-size: 13px;">Telp / HP</td>
                            <td class="info-item" style="font-size: 13px;">:</td>
                            <td class="info-text info-left" style="font-size: 13px;">{{ $pembelians->supplier->telp }} /
                                {{ $pembelians->supplier->hp }}
                            </td>
                        </tr>
                        <tr>
                            <td class="info-catatan2" style="font-size: 13px;">ID Supplier</td>
                            <td class="info-item" style="font-size: 13px;">:</td>
                            <td class="info-text info-left" style="font-size: 13px;">
                                {{ $pembelians->supplier->kode_supplier }}
                            </td>
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
                <span class="info-item" style="font-size: 13px; padding-left: 5px;">No. Faktur:
                    {{ $pembelians->kode_pembelianpart }}</span>
                <br>
            </td>
            <td style="text-align: right; padding-right: 45px;">
                <span class="info-item" style="font-size: 13px;">Tanggal:{{ $pembelians->tanggal }}</span>
                <br>
            </td>
        </tr>
    </table>
    <hr style="border-top: 0.5px solid black; margin: 3px 0;">
    <table style="width: 100%;" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">No.</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">Kode Barang</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">Nama Barang</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">Jumlah</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">Satuan</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">Harga</td>
        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td colspan="6" style="padding: 0px;"></td>
        </tr>
        @php
        $totalQuantity = 0;
        $totalHarga = 0;
        @endphp
        @foreach ($parts as $item)
        <tr>
            <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">{{ $loop->iteration }}
            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">
                {{ $item->kode_partdetail }}</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">{{ $item->nama_barang }}
            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">
                {{ $item->jumlah }}
            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">
                {{ $item->satuan }}
            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">Rp.
                {{ number_format($item->harga, 0, ',', '.') }}
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
            <td colspan="5" style="text-align: right; font-weight: bold; padding: px; font-size: 12px;">Sub Total
            </td>
            <td class="td" style="text-align: center; font-weight: bold; padding: 5px; font-size: 12px;">Rp.
                {{ number_format($totalHarga, 0, ',', '.') }}
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
                                {{ $pembelians->supplier->nama_bank }}
                            </td>
                        </tr>
                        <tr>
                            <td class="info-catatan2" style="font-size: 13px;">No. Rekening</td>
                            <td class="info-item" style="font-size: 13px;">:</td>
                            <td class="info-text info-left" style="font-size: 13px;">
                                {{ $pembelians->supplier->norek }}
                            </td>
                        </tr>
                        <tr>
                            <td class="info-catatan2" style="font-size: 13px;">Atas Nama</td>
                            <td class="info-item" style="font-size: 13px;">:</td>
                            <td class="info-text info-left" style="font-size: 13px;">
                                {{ $pembelians->supplier->atas_nama }}
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>
    <br>
    <table class="tdd" cellpadding="10" cellspacing="0">
        <tr>
            <td>
                <table>
                    <tr>
                        <td class="label">.</td>
                    </tr>
                    <tr>
                        <td class="separator" colspan="2"><span></span></td>
                    </tr>
                    <tr>
                        <td class="label">Gudang</td>
                    </tr>
                </table>
            </td>
            <td>
                <table>
                    <tr>
                        <td class="label">{{ auth()->user()->karyawan->nama_lengkap }}</td>
                    </tr>
                    <tr>
                        <td class="separator" colspan="2"><span></span></td>
                    </tr>
                    <tr>
                        <td class="label">Pembelian</td>
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

</html>