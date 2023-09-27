<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Penggantian Oli</title>
    <style>
        body {
            margin: 0;
            padding: 20px;
            font-family: 'DOSVGA', monospace;
            color: black;
        }

        .container {
            text-align: center;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 24px;
            font-weight: bold;
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 2px;
            font-size: 10px;
            /* Atur ukuran font tabel sesuai kebutuhan */
        }

        th,
        td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .total {
            font-weight: bold;
        }

        .signature {
            position: absolute;
            bottom: 20px;
            right: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;

            /* Menghilangkan garis tepi tabel */
        }

        td {
            padding: 5px 10px;

            /* Menghilangkan garis tepi sel */

        }

        .kepala {
            background-color: #cfcfcf;
        }

        .detail {
            background-color: #ffffff;
        }

        .thdetail {
            background-color: #ffffff;
        }

        .label {
            text-align: left;
            width: 50%;
            border: none;
            /* Mengatur lebar kolom teks */
        }

        .value {
            text-align: right;
            width: 50%;
            border: none;
            /* Mengatur lebar kolom hasil */
        }

        .separator {
            text-align: center;
            font-weight: bold;
            border: none;
        }

        table tr:nth-child(odd) {
            background-color: #f2f2f2;
        }

        /* Ganti warna latar belakang setiap baris kode part */
        table tr:nth-child(even) {
            background-color: #ffffff;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>LAPORAN PENGGANTIAN OLI - RANGKUMAN</h1>
    </div>
    <div class="text">
        @php
            $startDate = request()->query('tanggal_awal');
            $endDate = request()->query('tanggal_akhir');
        @endphp
        @if ($startDate && $endDate)
            <p>Periode:{{ $startDate }} s/d {{ $endDate }}</p>
        @else
            <p>Periode: Tidak ada tanggal awal dan akhir yang diteruskan.</p>
        @endif
    </div>
    <table>
        <tr>
            <th>Kode Penggantian</th>
            <th>Tanggal</th>
            <th>No Kabin</th>
            <th>No Registrasi</th>
            <th>Jenis Kendaraan</th>
        </tr>
        @foreach ($inquery as $penggantianoli)
            <tr>
                <td class="kepala">{{ $penggantianoli->kode_penggantianoli }}</td>
                <td class="kepala"> {{ $penggantianoli->tanggal_awal }}</td>
                <td class="kepala"> {{ $penggantianoli->kendaraan->no_kabin }}</td>
                <td class="kepala"> {{ $penggantianoli->kendaraan->no_pol }}</td>
                <td class="kepala"> {{ $penggantianoli->kendaraan->jenis_kendaraan->nama_jenis_kendaraan }}</td>
            </tr>
            <tr>
                <td colspan="5">
                    <table>
                        <tr>
                            <th class="thdetail">Kode Oli</th>
                            <th class="thdetail">Nama Oli</th>
                            <th class="thdetail">Jumlah Liter</th>
                            <th class="thdetail">Km Penggantian</th>
                            <th class="thdetail">Km Berikutnya</th>
                        </tr>
                        @foreach ($penggantianoli->detail_oli as $detail_oli)
                            <tr>
                                <td class="detail">{{ $detail_oli->sparepart->kode_partdetail }}</td>
                                <td class="detail">{{ $detail_oli->sparepart->nama_barang }}</td>
                                <td class="detail">{{ $detail_oli->jumlah }}</td>
                                <td class="detail">{{ $detail_oli->km_penggantian }}</td>
                                <td class="detail">{{ $detail_oli->km_berikutnya }}</td>
                            </tr>
                        @endforeach
                    </table>
                </td>
            </tr>
        @endforeach
    </table>
</body>

</html>


</html>
