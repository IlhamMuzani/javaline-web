<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-10px">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Pemasukan UJS</title>
    <style>
        html,
        body {
            font-family: 'DOSVGA', Arial, Helvetica, sans-serif;
            color: black;
            font-weight: bold
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .td {
            text-align: center;
            padding: 5px;
            font-size: 10px;
            /* border: 1px solid black; */
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
            /* Menetapkan lebar minimum untuk kolom pertama */
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
            /* size: A4; */
            margin: 1cm;
        }
    </style>
</head>

<body style="margin: 0; padding: 0;">
    <div id="logo-container">
        <img src="{{ public_path('storage/uploads/user/logo.png') }}" alt="JAVA LINE LOGISTICS" width="150"
            height="50">
    </div>
    <div style="font-weight: bold; text-align: center">
        <span style="font-weight: bold; font-size: 22px;">LAPORAN PEMASUKAN UJS</span>
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
    {{-- <hr style="border-top: 0.1px solid black; margin: 1px 0;"> --}}
    </div>
    @for ($date = $startDate; $date <= $endDate; $date = date('Y-m-d', strtotime($date . ' + 1 day')))
        @php
            $counter = 1; // Counter for each date
            $totalForDate = 0; // Variable to store total for each date
        @endphp
        <table style="width: 100%; border-top: 1px solid black;" cellspacing="0">
            <!-- Header row -->
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
            <!-- Header row -->
            <tr>
                <td class="td"
                    style="text-align: left; padding: 5px; font-weight:bold; font-size: 10px; border-bottom: 1px solid black;  width: 5%">
                    No</td>
                <td class="td"
                    style="text-align: left; padding: 5px; font-weight:bold; font-size: 10px; border-bottom: 1px solid black;  width: 15%">
                    Kode Pemasukan</td>
                <td class="td"
                    style="text-align: left; padding: 5px; font-weight:bold; font-size: 10px; border-bottom: 1px solid black;  width: 60%">
                    Jam</td>
                <td class="td"
                    style="text-align: right; padding: 5px; font-weight:bold; font-size: 10px; border-bottom: 1px solid black;  width: 20%">
                    Nominal</td>
            </tr>
            <tr style="border-bottom: 1px solid black;">
                <td colspan="4" style="padding: 0px;"></td>
            </tr>
            <!-- Data rows -->
            @foreach ($inquery as $item)
                @if ($item->tanggal_awal == $date)
                    <tr>
                        <td class="td" style="text-align: left; padding: 5px; font-size: 10px;">
                            {{ $counter++ }}</td>
                        <td class="td" style="text-align: left; padding: 5px; font-size: 10px;">
                            {{ $item->kode_jaminan }}
                        </td>
                        <td class="td" style="text-align: left; padding: 5px; font-size: 10px;">
                            {{ $item->jam }}
                        </td>
                        <td class="td" style="text-align: right; padding: 5px; font-size: 10px; ">
                            {{ number_format($item->nominal, 0, ',', '.') }}
                            @php
                                $totalForDate += $item->nominal; // Accumulate total for each date
                            @endphp
                        </td>
                    </tr>
                @endif
            @endforeach
            <!-- Separator row -->
            <tr style="border-bottom: 1px solid black;">
                <td colspan="4" style="padding: 0px;"></td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: right; font-weight: bold; padding: 5px; font-size: 10px; ">
                </td>
                <td
                    style="text-align: right; font-weight: bold; padding: 5px; font-size: 10px;background:rgb(190, 190, 190)">
                    {{ number_format($totalForDate, 0, ',', '.') }}
                </td>
            </tr>
        </table>
        <br>
    @endfor
    <br>

    <!-- Tampilkan sub-total di bawah tabel -->
    {{-- <div style="text-align: right;">
        <strong>Sub Total: Rp. {{ number_format($total, 0, ',', '.') }}</strong>
    </div> --}}


    {{-- <br> --}}

    <br>
    <br>

</body>

</html>
