<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Surat Pemasangan Ban</title>
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
    </style>
</head>

<body>
    <table width="100%">
        <tr>
            <td style="letter-spacing: 1px">
                <span style="font-weight: bold; font-size: 20px;">Surat Pemasangan Ban</span>
                <br>
                <span>Tanggal: {{ now()->format('d-m-Y') }}</span>
                <br>
            </td>
        </tr>
    </table>
    <hr>
    <br>
    {{-- <p style="font-weight: bold; text-align: center">DATA BAN</p> --}}
    <br>
    <table style="width: 100%;" cellpadding="10" cellspacing="0">
        <tr>
            <td class="td" style="text-align: center">No.</td>
            <td class="td" style="text-align: center">Posisi Ban</td>
            <td class="td" style="text-align: center">Kode Ban</td>
            <td class="td" style="text-align: center">No. Seri</td>
            <td class="td" style="text-align: center">Ukuran</td>
            <td class="td" style="text-align: center">Merek</td>
            <td class="td" style="text-align: center">Kondisi</td>
        </tr>
        @foreach ($bans as $item)
            <tr>
                <td class="td" style="text-align: center">{{ $loop->iteration }}</td>
                <td class="td" style="text-align: center">{{ $item->posisi_ban }}</td>
                <td class="td" style="text-align: center">{{ $item->kode_ban }}</td>
                <td class="td" style="text-align: center">{{ $item->no_seri }}</td>
                <td class="td" style="text-align: center">{{ $item->ukuran->ukuran }}</td>
                <td class="td" style="text-align: center">{{ $item->merek->nama_merek }}</td>
                <td class="td" style="text-align: center">{{ $item->kondisi_ban }}</td>
            </tr>
        @endforeach
    </table>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <table class="tdd" style="width: 100%;" cellpadding="10" cellspacing="0">
        <tr>
            <td style="text-align: center">Operasional</td>
            <td style="text-align: center">Pembelian</td>
            <td style="text-align: center">Accounting</td>
        </tr>
    </table>
</body>

</html>
