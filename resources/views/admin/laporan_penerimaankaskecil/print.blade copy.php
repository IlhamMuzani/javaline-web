<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Penerimaan Kas Kecil</title>
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
        <img src="{{ asset('storage/uploads/user/logo.png') }}" alt="Java Line" width="150" height="50">
    </div>
    <div style="font-weight: bold; text-align: center">
        <span style="font-weight: bold; font-size: 22px;">LAPORAN PENERIMAAN KAS KECIL - RANGKUMAN</span>
        <br>
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
    {{-- <hr style="border-top: 0.1px solid black; margin: 1px 0;"> --}}
    <table style="width: 100%; border-top: 1px solid black;" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 15px;">Faktur
                Penerimaan Kas Kecil</td>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 15px;">Waktu</td>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 15px;">Keterangan
            </td>
            <td class="td" style="text-align: right; padding: 5px; font-weight:bold; font-size: 15px;">Nominal</td>
        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td colspan="7" style="padding: 0px;">
            </td>
        </tr>
        @foreach ($inquery as $item)
        <tr>
            <td class="td"
                style="text-align: left; padding: 5px; font-size: 15px; background-color: rgb(191, 191, 191); color: black;">
                Tanggal: {{ $item->tanggal }}</td>
            <td class="td"
                style="text-align: left; padding: 5px; font-size: 15px; background-color: rgb(191, 191, 191); color: black;">
            </td>
            <td class="td"
                style="text-align: left; padding: 5px; font-size: 15px; background-color: rgb(191, 191, 191); color: black;">
            </td>
            <td class="td"
                style="text-align: left; padding: 5px; font-size: 15px; background-color: rgb(191, 191, 191); color: black;">
            </td>
        </tr>
        <tr>
            <td class="td" style="text-align: left; padding: 5px; font-size: 15px;">{{ $item->kode_penerimaan }}
            </td>
            <td class="td" style="text-align: left; padding: 5px; font-size: 15px;">
                {{ $item->jam }}
            </td>
            <td class="td" style="text-align: left; padding: 5px; font-size: 15px;">{{ $item->keterangan }}
            </td>
            <td class="td" style="text-align: right; padding: 5px; font-size: 15px;">
                {{ number_format($item->nominal, 0, ',', '.') }}
            </td>
        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td colspan="7" style="padding: 0px;">
            </td>
        </tr>
        <tr>
            <td class="td" style="text-align: left; padding: 5px; font-size: 15px;">
            </td>
            <td class="td" style="text-align: left; padding: 5px; font-size: 15px;">

            </td>
            <td class="td"
                style="text-align: right; padding: 5px; font-size: 15px; background-color: rgb(191, 191, 191); color: black;">
                Total :
            </td>
            <td class="td"
                style="text-align: right; padding: 5px; background-color: rgb(191, 191, 191); color: black; font-size: 15px;">
                {{ number_format($item->nominal, 0, ',', '.') }}
            </td>
        </tr>
        <div style="color: white">a</div>
        @endforeach
        <tr style="border-bottom: 1px solid black;">
            <td colspan="8" style="padding: 0px;">
            </td>
        </tr>
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
        <strong>Sub Total: Rp. {{ number_format($total, 0, ',', '.') }}</strong>
    </div>


    {{-- <br> --}}

    <br>
    <br>

</body>

</html>