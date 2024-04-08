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
        border: 1px solid black;
    }

    .table,
    .tdd {
        border: 1px solid white;
    }

    body {
        margin: 0;
        padding: 20px;
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

    .blue-button {
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
        flex: 1;
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
        margin-bottom: 5px;
        /* Menambah jarak antara setiap baris */
    }

    .info-catatan2 {
        font-weight: bold;
        margin-right: 5px;
        min-width: 120px;
        /* Menetapkan lebar minimum untuk kolom pertama */
    }

    .info-1 {
        /* Tidak perlu margin pada info-1 karena jarak diatur melalui margin-right pada .info-catatan2 */
    }
    </style>
</head>

<body>
    <table width="100%">
        <tr>
            <td>
                <span class="nama-pt">PT. JAVALINE LOGISTICS</span>
                <br>
                <span class="alamat">
                    JL. HOS COKRO AMINOTO NO.6
                </span>
                <br>
                <span class="alamat">
                    SLAWI TEGAL
                </span>
                <br>
                <span class="alamat">
                    Telp / Fax. 02836195326 02836195187
                </span>
                <br>
            </td>
            <td>
                <div class="info-catatan" style="max-width: 500px;">
                    <!-- Ganti 400px dengan lebar yang Anda inginkan -->
                    <table>
                        <tr>
                            <td class="info-catatan2">Nama Supplier</td>
                            <td class="info-item">: {{ $pembelians->supplier->nama_supp }}</td>
                        </tr>
                        <tr>
                            <td class="info-catatan2">Alamat</td>
                            <td class="info-item">: {{ $pembelians->supplier->alamat }}</td>
                        </tr>
                        <tr>
                            <td class="info-catatan2">Telp / HP</td>
                            <td class="info-item">: {{ $pembelians->supplier->telp }} /
                                {{ $pembelians->supplier->hp }}
                            </td>
                        </tr>
                        <tr>
                            <td class="info-catatan2">ID Supplier</td>
                            <td class="info-item">: {{ $pembelians->supplier->kode_supplier }}</td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>
    <br>
    <div style="font-weight: bold; text-align: center">
        <span style="font-weight: bold; font-size: 20px;">FAKTUR PEMBELIAN PART</span>
        <br>
    </div>
    <hr>
    <table width="100%">
        <tr>
            <td>
                <span class="info-item">No. Faktur: {{ $pembelians->kode_pembelianpart }}</span>
                <br>
            </td>
            <td style="text-align: right;">
                {{-- <span class="info-item">Tanggal:{{ now()->format('d-m-Y') }}</span> --}}
                <span class="info-item">Tanggal:{{ Carbon\Carbon::now()->translatedFormat('d M Y') }}</span>
                <br>
            </td>
        </tr>
    </table>
    <hr>
    <br>
    {{-- <div style="font-weight: bold; text-align: center">
        <span style="font-weight: bold; font-size: 20px;">Faktur Pembelian Ban</span>
        <br>
        <br>
    </div>
    <br> --}}
    <table style="width: 100%;" cellpadding="10" cellspacing="0">
        <tr>
            <td class="td" style="text-align: center">No.</td>
            <td class="td" style="text-align: center">Kode Barang</td>
            <td class="td" style="text-align: center">Nama Barang</td>
            <td class="td" style="text-align: center">Jumlah</td>
            <td class="td" style="text-align: center">Satuan</td>
            <td class="td" style="text-align: center">Harga Total</td>
        </tr>
        @php
        $totalQuantity = 0;
        $totalHarga = 0;
        @endphp
        @foreach ($parts as $item)
        <tr>
            <td class="td" style="text-align: center">{{ $loop->iteration }}</td>
            <td class="td" style="text-align: center">{{ $item->kode_partdetail }}</td>
            <td class="td" style="text-align: center">{{ $item->nama_barang }}</td>
            <td class="td" style="text-align: center">{{ $item->jumlah }}</td>
            <td class="td" style="text-align: center">{{ $item->satuan }}</td>
            <td class="td" style="text-align: center">Rp. {{ $item->harga }}</td>
        </tr>
        @php
        $totalQuantity += 1;
        $totalHarga += $item->harga * $item->jumlah;
        @endphp
        @endforeach
        <tr>
            <td class="td" colspan="5" style="text-align: right; font-weight: bold;">Total</td>
            {{-- <td class="td" style="text-align: center; font-weight: bold;">{{ $totalQuantity }}</td> --}}
            {{-- <td class="td" style="text-align: center; font-weight: bold;">Rp. {{ $totalHarga }}</td> --}}
        </tr>
    </table>
    <br>
    <br>
    <br>
    <br>

    <table width="100%">
        <tr>
            <td>
                <div class="info-catatan" style="max-width: 230px;">
                    <!-- Ganti 400px dengan lebar yang Anda inginkan -->
                    <table>
                        <tr>
                            <td class="info-catatan2">Nama Supplier</td>
                            <td class="info-item">: {{ $pembelians->supplier->nama_bank }}</td>
                        </tr>
                        <tr>
                            <td class="info-catatan2">No. Rekening</td>
                            <td class="info-item">: {{ $pembelians->supplier->norek }}</td>
                        </tr>
                        <tr>
                            <td class="info-catatan2">Atas Nama</td>
                            <td class="info-item">: {{ $pembelians->supplier->atas_nama }}</td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>
    <br>
    <br>
    <table class="tdd" style="width: 100%;" cellpadding="10" cellspacing="0">
        <tr>
            <td style="text-align: center">Gudang</td>
            <td style="text-align: center">Pembelian</td>
            <td style="text-align: center">Accounting</td>
        </tr>
    </table>
    <br> <br>

</body>

<div class="container">
    <a href="{{ url('admin/pembelian_part/cetak-pdf/' . $pembelians->id) }}" class="blue-button"
        style="text-decoration: none;">Cetak</a>
</div>


</html>