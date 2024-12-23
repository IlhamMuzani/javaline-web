<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Memo Borong</title>
    <style>
        html,
        body {
            font-family: 'DOSVGA', Arial, Helvetica, sans-serif;
            color: black;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .td {
            text-align: center;
            padding: 5px;
            font-size: 9px;
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
            padding-top: 9px;
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
            font-size: 9px;
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
        <span style="font-weight: bold; font-size: 18px;">MEMO BORONG</span>
        <br>
        <br>
        <div class="text">
            {{-- <p>Periode:{{ $memos->first()->tanggal_awal }} s/d {{ $memos->first()->id }}</p>
            <p>Periode: Tidak ada tanggal awal dan akhir yang diteruskan.</p> --}}
        </div>
    </div>

    </div>
    <table style="width: 100%; border-top: 1px solid black;" cellpadding="2" cellspacing="0">
        <!-- Header row -->
        <tr>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 9px;">Kode Memo
            </td>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 9px;">Tanggal</td>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 9px;">Nama Driver
            </td>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 9px;">No Kabin
            </td>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 9px;">Rute
            </td>
            <td class="td" style="text-align: right; padding: 5px; font-weight:bold; font-size: 9px;">Harga
            </td>
            <td class="td" style="text-align: right; padding: 5px; font-weight:bold; font-size: 9px;">Qty
            </td>
            <td class="td" style="text-align: right; padding: 5px; font-weight:bold; font-size: 9px;">Total
            </td>
            <td class="td" style="text-align: right; padding: 5px; font-weight:bold; font-size: 9px;">Total Borong
            </td>
            <td class="td" style="text-align: right; padding: 5px; font-weight:bold; font-size: 9px;">G. Total
            </td>
            <td class="td" style="text-align: right; padding: 5px; font-weight:bold; font-size: 9px;">S. Trasnfer
            </td>
        </tr>
        <!-- Separator row -->
        <tr style="border-bottom: 1px solid black;">
            <td colspan="5" style="padding: 0px;"></td>
        </tr>
        <!-- Data rows -->
        @php
            $Harga = 0;
            $Qty = 0;
            $Total = 0;
            $TotalBorong = 0;
            $Grandtotal = 0;
            $SisaTransfer = 0;
        @endphp
        @foreach ($memos as $item)
            <tr>
                <td class="td" style="text-align: left; padding: 5px; font-size: 9px;">{{ $item->kode_memo }}
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 9px;">{{ $item->tanggal_awal }}
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 9px;">
                    {{ substr($item->nama_driver, 0, 10) }} ..</td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 9px;">
                    {{ $item->no_kabin }}</td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 9px;">
                    @if ($item->nama_rute == null)
                        rute tidak ada
                    @else
                        {{ $item->nama_rute }}
                    @endif
                </td>
                <td class="td" style="text-align: right; padding: 5px; font-size: 9px;">
                    {{ number_format($item->harga_rute, 0, ',', '.') }}
                </td>
                <td class="td" style="text-align: right; padding: 5px; font-size: 9px;">
                    {{ number_format($item->jumlah, 0, ',', '.') }}
                </td>
                <td class="td" style="text-align: right; padding: 5px; font-size: 9px;">
                    {{ number_format($item->totalrute, 0, ',', '.') }}
                </td>
                <td class="td" style="text-align: right; padding: 5px; font-size: 9px;">
                    {{ number_format(($item->totalrute - $item->pphs) / 2 + $item->biaya_tambahan, 0, ',', '.') }}
                </td>
                <td class="td" style="text-align: right; padding: 5px; font-size: 9px;">
                    {{ number_format($item->hasil_jumlah, 0, ',', '.') }}</td>
                <td class="td" style="text-align: right; padding: 5px; font-size: 9px;">
                    {{ number_format($item->sub_total, 0, ',', '.') }}
                </td>
            </tr>
            @php
                $Harga += $item->harga_rute;
                $Qty += $item->jumlah;
                $Total += $item->totalrute;
                $TotalBorong += ($item->totalrute - $item->pphs) / 2 + $item->biaya_tambahan;
                $Grandtotal += $item->hasil_jumlah;
                $SisaTransfer += $item->sub_total;
            @endphp
        @endforeach
        <!-- Separator row -->
        <tr style="border-bottom: 1px solid black;">
            <td colspan="" style="padding: 0px;"></td>
        </tr>

        <tr>
            <td colspan="5" style="text-align: right; font-weight: bold; padding: 5px; font-size: 9px;">Sub Total
            </td>
            <td style="text-align: right; font-weight: bold; padding: 5px; font-size: 9px;">
                {{ number_format($Harga, 0, ',', '.') }}
            </td>
            <td style="text-align: right; font-weight: bold; padding: 5px; font-size: 9px;">
                {{ number_format($Qty, 0, ',', '.') }}
            </td>
            <td style="text-align: right; font-weight: bold; padding: 5px; font-size: 9px;">
                {{ number_format($Total, 0, ',', '.') }}
            </td>
            <td style="text-align: right; font-weight: bold; padding: 5px; font-size: 9px;">
                {{ number_format($TotalBorong, 0, ',', '.') }}
            </td>
            <td style="text-align: right; font-weight: bold; padding: 5px; font-size: 9px;">
                {{ number_format($Grandtotal, 0, ',', '.') }}
            </td>
            <td style="text-align: right; font-weight: bold; padding: 5px; font-size: 9px;">
                {{ number_format($SisaTransfer, 0, ',', '.') }}
            </td>
        </tr>
    </table>

    <br>

    <br>
    <br>

    <footer style="position: fixed; bottom: 0; right: 20px; width: auto; text-align: end; font-size: 9px;">Page
    </footer>
</body>

</html>
