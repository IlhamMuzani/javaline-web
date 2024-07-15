<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Pengambilan Kas Kecil</title>
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
        <span style="font-weight: bold; font-size: 22px;">LAPORAN PENGAMBILAN KAS KECIL</span>
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
    </div>

    @php
        $grandTotal = 0; // Initialize grandTotal
    @endphp

    @for ($date = $startDate; $date <= $endDate; $date = date('Y-m-d', strtotime($date . ' + 1 day')))
        @php
            $counter = 1; // Counter for each date
            $totalForDate = 0; // Variable to store total for each date
        @endphp
        <table style="width: 100%; border-top: 1px solid black;" cellspacing="0">
            <tr>
                <td colspan="1"
                    style="text-align: left; font-weight: bold; padding: 5px; font-size: 10px; background:rgb(190, 190, 190)">
                    Tanggal: {{ $date }}
                </td>
                <td colspan="2"
                    style="text-align: right; font-weight: bold; padding: 5px; font-size: 10px; background:rgb(190, 190, 190)">
                </td>
                <td colspan="3"
                    style="text-align: right; font-weight: bold; padding: 5px; font-size: 10px; background:rgb(190, 190, 190)">
                </td>
                <td colspan="4"
                    style="text-align: right; font-weight: bold; padding: 5px; font-size: 10px; background:rgb(190, 190, 190)">
                </td>
                <td colspan="5"
                    style="text-align: right; font-weight: bold; padding: 5px; font-size: 10px; background:rgb(190, 190, 190)">
                </td>
                <td
                    style="text-align: right; font-weight: bold; padding: 5px; font-size: 10px;background:rgb(190, 190, 190)">
                </td>
            </tr>
        </table>
        <table style="width: 100%; border-top: 1px solid black;" cellpadding="2" cellspacing="0">
            <tr>
                <td class="td"
                    style="text-align: left; padding: 5px; font-weight:bold; font-size: 10px; border-bottom: 1px solid black; width: 5%">
                    No</td>
                <td class="td"
                    style="text-align: left; padding: 5px; font-weight:bold; font-size: 10px; border-bottom: 1px solid black; width: 15%">
                    Kode Pengeluaran</td>
                <td class="td"
                    style="text-align: left; padding: 5px; font-weight:bold; font-size: 10px; border-bottom: 1px solid black; width: 60%">
                    Keterangan</td>
                <td class="td"
                    style="text-align: right; padding: 5px; font-weight:bold; font-size: 10px; border-bottom: 1px solid black; width: 20%">
                    Nominal</td>
            </tr>
            <tr style="border-bottom: 1px solid black;">
                <td colspan="4" style="padding: 0px;"></td>
            </tr>
            @foreach ($inquery as $item)
                @if ($item->tanggal_awal == $date)
                    <tr>
                        <td class="td" style="text-align: left; padding: 5px; font-size: 10px;">{{ $counter++ }}
                        </td>
                        <td class="td" style="text-align: left; padding: 5px; font-size: 10px;">
                            {{ $item->kode_pengeluaran }}</td>
                        <td class="td" style="text-align: left; padding: 5px; font-size: 10px;">
                            {{ $item->keterangan }}</td>
                        <td class="td" style="text-align: right; padding: 5px; font-size: 10px;">
                            {{ number_format($item->grand_total, 0, ',', '.') }}</td>
                        @php
                            $totalForDate += $item->grand_total; // Accumulate total for each date
                        @endphp
                    </tr>
                @endif
            @endforeach
            <tr style="border-bottom: 1px solid black;">
                <td colspan="4" style="padding: 0px;"></td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: right; font-weight: bold; padding: 5px; font-size: 10px;"></td>
                <td
                    style="text-align: right; font-weight: bold; padding: 5px; font-size: 10px;background:rgb(190, 190, 190)">
                    {{ number_format($totalForDate, 0, ',', '.') }}</td>
            </tr>
        </table>
        <br>
        @php
            $grandTotal += $totalForDate; // Accumulate the grand total
        @endphp
    @endfor
    <br>
    <div style="text-align: right;">
        <strong>Sub Total: Rp. {{ number_format($grandTotal, 0, ',', '.') }}</strong>
    </div>
    <br>
    <br>

    <footer style="position: fixed; bottom: 0; right: 20px; width: auto; text-align: end; font-size: 10px;">Page
    </footer>
</body>

</html>
