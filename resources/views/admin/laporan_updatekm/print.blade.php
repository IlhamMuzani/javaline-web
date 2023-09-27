<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Update KM</title>
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
    </style>
</head>

<body>
    <div class="container">
        <h1>LAPORAN UPDATE KM - RANGKUMAN</h1>
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
            <th>No</th>
            <th>Tanggal</th>
            <th>Nama User</th>
            <th>No Kabin</th>
            <th>Km Update</th>
        </tr>
        @foreach ($inquery as $updatekm)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $updatekm->tanggal }}</td>
                <td>
                    @if ($updatekm->user)
                        {{ $updatekm->user->karyawan->nama_lengkap }}
                    @else
                        User tidak ada
                    @endif
                </td>
                <td>{{ $updatekm->no_kabin }}</td>
                <td>{{ $updatekm->km }}</td>
            </tr>
        @endforeach
    </table>
    {{-- <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br> <br> --}}

</body>

</html>
