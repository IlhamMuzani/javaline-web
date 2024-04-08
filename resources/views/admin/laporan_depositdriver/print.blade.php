<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Deposit Sopir</title>
    <style>
        html,
        body {
            font-family: 'DOSVGA', monospace;
            color: black;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .td {
            text-align: center;
            padding: 5px;
            font-size: 15px;
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
            padding-top: 15px;
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
        <img src="{{ public_path('storage/uploads/user/logo.png') }}" alt="JAVA LINE LOGISTICS" width="150" height="50">
    </div>
    <div style="font-weight: bold; text-align: center">
        @php
            $startDate = request()->query('tanggal_awal');
            $endDate = request()->query('tanggal_akhir');
            $kategori = request()->query('kategori');
        @endphp
        @if ($kategori == 'Pemasukan Deposit')
            <span style="font-weight: bold; font-size: 22px;">LAPORAN PEMASUKAN DEPOSIT SOPIR - RANGKUMAN</span>
        @else
            <span style="font-weight: bold; font-size: 22px;">LAPORAN PENGAMBILAN DEPOSIT SOPIR - RANGKUMAN</span>
        @endif
        <br>
        <div class="text">

            @if ($startDate && $endDate)
                <p>Periode:{{ $startDate }} s/d {{ $endDate }}</p>
            @else
                <p>Periode: Tidak ada tanggal awal dan akhir yang diteruskan.</p>
            @endif
        </div>
    </div>
    {{-- <hr style="border-top: 0.1px solid black; margin: 1px 0;"> --}}

    </div>
    {{-- <hr style="border-top: 0.1px solid black; margin: 1px 0;"> --}}
    <table style="width: 100%; border-top: 1px solid black;" cellpadding="2" cellspacing="0">
        <!-- Header row -->
        <tr>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 15px;">Tanggal</td>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 15px;">No. Faktur
            </td>
            <td class="td" style="text-align: right; padding: 5px; font-weight:bold; font-size: 15px;">Kas Masuk
            </td>
            <td class="td" style="text-align: right; padding: 5px; font-weight:bold; font-size: 15px; color:white">a
            </td>
            <td class="td" style="text-align: right; padding: 5px; font-weight:bold; font-size: 15px;">Saldo</td>
        </tr>
        <!-- Separator row -->
        <tr style="border-bottom: 1px solid black;">
            <td colspan="5" style="padding: 0px;"></td>
        </tr>
        <!-- Data rows -->
        @foreach ($inquery as $item)
            <tr>
                <td class="td" style="text-align: left; padding: 5px; font-size: 15px;">{{ $item->tanggal }}</td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 15px;">{{ $item->kode_deposit }}
                </td>
                <td class="td" style="text-align: right; padding: 5px; font-size: 15px;">
                    {{ number_format($item->nominal, 0, ',', '.') }}</td>
                <td class="td" style="text-align: right; padding: 5px; font-size: 15px; color:white">
                    a</td>
                <td class="td" style="text-align: right; padding: 5px; font-size: 15px;">
                    {{ number_format($item->sub_total, 0, ',', '.') }}</td>
            </tr>
        @endforeach
        <!-- Separator row -->
        <tr style="border-bottom: 1px solid black;">
            <td colspan="" style="padding: 0px;"></td>
        </tr>
        <!-- Subtotal row -->
        @php
            $total = 0;
        @endphp
        @foreach ($inquery as $item)
            @php
                $total += $item->nominal;
            @endphp
        @endforeach
        {{-- <tr style="color: white">
            <td colspan="2" style="text-align: right; font-weight: bold; padding: 5px; font-size: 15px;">a
            </td>
            <td style="text-align: right; font-weight: bold; padding: 5px; font-size: 15px;">a
            </td>
            <td style="text-align: right; font-weight: bold; padding: 5px; color:white; font-size: 15px;">a
            </td>
        </tr> --}}
        <tr>
            <td colspan="2" style="text-align: right; font-weight: bold; padding: 5px; font-size: 15px;">Sub Total
            </td>
            <td style="text-align: right; font-weight: bold; padding: 5px; font-size: 15px;">Rp.
                {{ number_format($total, 0, ',', '.') }}
            </td>
            <td style="text-align: right; font-weight: bold; padding: 5px; color:white; font-size: 15px;">a
            </td>
            <td style="text-align: right; font-weight: bold; padding: 5px; color:white; font-size: 15px;">a
            </td>
        </tr>
    </table>




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
