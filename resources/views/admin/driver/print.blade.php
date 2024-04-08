<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-10px">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Deposit</title>
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
        <img src="{{ asset('storage/uploads/user/logo.png') }}" alt="JAVALINE" width="150" height="55">
    </div>
    <div style="font-weight: bold; text-align: center">
        <span style="font-weight: bold; font-size: 22px;">SALDO DEPOSIT KARYAWAN</span>
        <div class="text">
            {{-- @php
                $startDate = request()->query('tanggal_awal');
                $endDate = request()->query('tanggal_akhir');
            @endphp
            @if ($startDate && $endDate) --}}
            <p style="font-size:14px">Periode: 01 Jan 2024 s/d {{ \Carbon\Carbon::now()->format('d M Y') }}</p>
            {{-- @else
                <p>Periode: Tidak ada tanggal awal dan akhir yang diteruskan.</p>
            @endif --}}
        </div>
    </div>
    {{-- <hr style="border-top: 0.1px solid black; margin: 1px 0;"> --}}

    </div>
    <table style="width: 100%; border-top: 1px solid black;" cellpadding="2" cellspacing="0">
        <!-- Header row -->
        <tr>
            <td class="td"
                style="text-align: left; padding: 5px; font-weight:bold; font-size: 10px; border-bottom: 1px solid black;">
                No</td>
            <td class="td"
                style="text-align: left; padding: 5px; font-weight:bold; font-size: 10px; border-bottom: 1px solid black;">
                Nama Sopir</td>
            <td class="td"
                style="text-align: right; padding: 5px; font-weight:bold; font-size: 10px; border-bottom: 1px solid black;">
                Deposit</td>
            <td class="td"
                style="text-align: right; padding: 5px; font-weight:bold; font-size: 10px; border-bottom: 1px solid black;">
                Kasbon</td>
            <td class="td"
                style="text-align: right; padding: 5px; font-weight:bold; font-size: 10px; border-bottom: 1px solid black;">
                Bayar Kasbon</td>
            <td class="td"
                style="text-align: right; padding: 5px; font-weight:bold; font-size: 10px; border-bottom: 1px solid black;">
                Saldo Deposit</td>
        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td colspan="6" style="padding: 0px;"></td>
        </tr>
        <!-- Data rows -->
        @foreach ($inquery as $driver)
            <tr>
                <td class="td"
                    style="text-align: left; padding: 5px; font-size: 10px; border-bottom: 1px solid black;">
                    {{ $loop->iteration }}</td>
                <td class="td"
                    style="text-align: left; padding: 5px; font-size: 10px; border-bottom: 1px solid black;">
                    {{ $driver->nama_lengkap }}</td>
                <td class="td"
                    style="text-align: right; padding: 5px; font-size: 10px; border-bottom: 1px solid black;">
                    {{ number_format($driver->deposit, 0, ',', '.') }}
                </td>
                <td class="td"
                    style="text-align: right; padding: 5px; font-size: 10px; border-bottom: 1px solid black;">
                    {{ number_format($driver->kasbon, 0, ',', '.') }}
                <td class="td"
                    style="text-align: right; padding: 5px; font-size: 10px; border-bottom: 1px solid black;">
                    {{ number_format($driver->bayar_kasbon, 0, ',', '.') }}
                <td class="td"
                    style="text-align: right; padding: 5px; font-size: 10px; border-bottom: 1px solid black; background:rgb(206, 206, 206)">
                    {{ number_format($driver->tabungan, 0, ',', '.') }}</td>
            </tr>
        @endforeach
        <!-- Separator row -->
        <tr style="border-bottom: 1px solid black;">
            <td colspan="6" style="padding: 0px;"></td>
        </tr>
        <!-- Subtotal row -->
        @php
            $total = 0;
        @endphp
        @foreach ($inquery as $item)
            @php
                $total += $item->tabungan;
            @endphp
        @endforeach
        <tr>
            <td colspan="5"
                style="text-align: right; font-weight: bold; padding: 5px; font-size: 10px; background:rgb(190, 190, 190)">
                Sub Total
            </td>
            <td
                style="text-align: right; font-weight: bold; padding: 5px; font-size: 10px;background:rgb(190, 190, 190)">
                {{ number_format($total, 0, ',', '.') }}</td>
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
