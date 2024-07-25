<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Klaim Peralatan</title>
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
            margin-top: 20px;
            font-size: 12px;
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
    </style>
</head>

<body>
    <div class="container">
        <h1>LAPORAN KLAIM BAN - RANGKUMAN</h1>
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
            <th>Kode Klaim</th>
            <th>Nama Driver</th>
            <th>Tanggal</th>
            <th>No Kabin</th>
            <th>No Pol</th>
            <th>Jenis Kendaraan</th>
            <th>Total Klaim</th>
        </tr>
        @php
            $total = 0;
        @endphp
        @foreach ($inquery as $klaim)
            <tr>
                <td>{{ $klaim->kode_klaimban }}</td>
                <td> {{ $klaim->karyawan->nama_lengkap }}</td>
                <td> {{ $klaim->tanggal_awal }}</td>
                <td> {{ $klaim->kendaraan->no_kabin }}</td>
                <td> {{ $klaim->kendaraan->no_pol }}</td>
                <td> {{ $klaim->kendaraan->jenis_kendaraan->nama_jenis_kendaraan }}</td>
                <td> {{ number_format($klaim->harga_klaim, 2, ',', '.') }}</td>
            </tr>
            @php
                $total += $klaim->harga_klaim;
            @endphp
        @endforeach
        <tr style="border-bottom: 1px solid black;">
            <td colspan="7" style="padding: 0px;"></td>
        </tr>
        <tr>
            <td colspan="6" style="text-align: right; font-weight: bold;">
            </td>
            <td style="text-align: right; font-weight: bold; background:rgb(190, 190, 190)">
                {{ number_format($total, 2) }}
            </td>
        </tr>
    </table>
</body>


</html>
