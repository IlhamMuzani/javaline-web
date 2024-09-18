<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Piutang</title>
    <style>
        html,
        body {
            font-family: 'DOSVGA', Arial, Helvetica, sans-serif;
            color: black;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .td {
            text-align: center;
            padding: 5px;
            font-size: 10px;
        }

        .container {
            position: relative;
            margin-top: 7rem;
        }

        .info-container {
            display: flex;
            justify-content: space-between;
            font-size: 16px;
            margin: 5px 0;
        }

        .info-text {
            text-align: left;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .info-catatan2 {
            font-weight: bold;
            margin-right: 5px;
            min-width: 120px;
        }

        .alamat,
        .nama-pt {
            color: black;
        }

        .separator {
            padding-top: 10px;
            text-align: center;
        }

        .separator span {
            display: inline-block;
            border-top: 1px solid black;
            width: 100%;
            position: relative;
            top: -8px;
        }

        @page {
            margin: 1cm;
            counter-increment: page;
            counter-reset: page 1;
        }

        /* Define the footer with page number */
        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: start;
            font-size: 10px;
        }

        footer::after {
            content: counter(page);
        }
    </style>
</head>

<body style="margin: 0; padding: 0;">
    <div id="logo-container">
        <img src="{{ public_path('storage/uploads/user/logo.png') }}" alt="JAVA LINE LOGISTICS" width="150"
            height="50">
    </div>
    <div style="font-weight: bold; text-align: center">
        <span style="font-weight: bold; font-size: 22px;">LAPORAN PIUTANG</span>
        <div class="text">
        </div>
    </div>
    <br>
    <table style="width: 100%; border-top: 1px solid black;" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td"
                style="text-align: left; padding: 5px; font-weight:bold; font-size: 10px; border-bottom: 1px solid black; width: 5%; background:rgb(190, 190, 190)">
                No</td>
            <td class="td"
                style="text-align: left; padding: 5px; font-weight:bold; font-size: 10px; border-bottom: 1px solid black; width: 25%;  background:rgb(190, 190, 190)">
                Kode Invoice</td>
            <td class="td"
                style="text-align: left; padding: 5px; font-weight:bold; font-size: 10px; border-bottom: 1px solid black; width: 25%;  background:rgb(190, 190, 190)">
                Tanggal</td>
            <td class="td"
                style="text-align: left; padding: 5px; font-weight:bold; font-size: 10px; border-bottom: 1px solid black; width: 35%;  background:rgb(190, 190, 190)">
                Pelanggan</td>
            <td class="td"
                style="text-align: right; padding: 5px; font-weight:bold; font-size: 10px; border-bottom: 1px solid black; width: 15%;  background:rgb(190, 190, 190)">
                DPP</td>
            <td class="td"
                style="text-align: right; padding: 5px; font-weight:bold; font-size: 10px; border-bottom: 1px solid black; width: 15%;  background:rgb(190, 190, 190)">
                PPH</td>
            <td class="td"
                style="text-align: right; padding: 5px; font-weight:bold; font-size: 10px; border-bottom: 1px solid black; width: 20%;  background:rgb(190, 190, 190)">
                Sub Total</td>
        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td colspan="7" style="padding: 0px;"></td>
        </tr>

        @php
            $totalDPP = 0;
            $totalPPH = 0;
            $totalSUB = 0;
        @endphp
        @foreach ($inquery as $item)
            <tr>
                <td class="td" style="text-align: left; padding: 5px; font-size: 10px;">{{ $loop->iteration }}
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 10px;">
                    {{ $item->kode_tagihan }}</td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 10px;">
                    {{ $item->created_at }}</td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 10px;">
                    {{ $item->nama_pelanggan }}</td>
                <td class="td" style="text-align: right; padding: 5px; font-size: 10px;">
                    {{ number_format($item->sub_total, 0, ',', '.') }}
                </td>
                <td class="td" style="text-align: right; padding: 5px; font-size: 10px;">
                    @if ($item->kategori == 'PPH')
                        {{ number_format($item->pph, 0, ',', '.') }}
                    @else
                        0
                    @endif
                </td>
                <td class="td" style="text-align: right; padding: 5px; font-size: 10px;">
                    {{ number_format($item->grand_total, 0, ',', '.') }}</td>
                @php
                    $totalDPP += $item->sub_total;
                    $totalPPH += $item->pph;
                    $totalSUB += $item->grand_total;
                @endphp
            </tr>
        @endforeach
        <tr style="border-bottom: 1px solid black;">
            <td colspan="7" style="padding: 0px;"></td>
        </tr>
    </table>
    <br>
    <br>
    <div style="text-align: right;">
        <strong>Sub Total: Rp. {{ number_format($totalSUB, 0, ',', '.') }}</strong>
    </div>
    <br>
    <br>

    <footer style="position: fixed; bottom: 0; right: 20px; width: auto; text-align: end; font-size: 10px;">Page
    </footer>
</body>

</html>
