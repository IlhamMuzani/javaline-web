<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>faktur Penerimaan Kas Kecil</title>
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
        <h1>FAKTUR PENERIMAAN KAS KECIL - RANGKUMAN</h1>
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
    <table style="width: 100%;" cellpadding="10" cellspacing="0">
        <tr>
            <td class="td" style="text-align: left">Faktur Penerimaan Kas Kecil</td>
            <td class="td" style="text-align: left">Waktu</td>
            <td class="td" style="text-align: left">Keterangan</td>
            <td class="td" style="text-align: right">Nominal</td>
        </tr>
        @foreach ($inquery as $item)
            <tr>
                <td class="td" style="text-align: left">{{ $item->kode_penerimaan }}</td>
                <td class="td" style="text-align: left">{{ $item->jam }}</td>
                <td class="td" style="text-align: left">{{ $item->keterangan }}</td>
                <td class="td" style="text-align: right">{{ $item->nominal }}</td>
            </tr>
        @endforeach
    </table>

    @php
        $total = 0;
    @endphp

    @foreach ($inquery as $item)
        @php
            $total += $item->nominal;
        @endphp
    @endforeach

    <br>
    <!-- Tampilkan sub-total di bawah tabel -->
    <div style="text-align: right;">
        <strong>Total: Rp. {{ number_format($total, 0, ',', '.') }}</strong>
    </div>


</body>


</html>
