<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Faktur Ekspedisi</title>
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
            font-size: 8;
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
            padding-top: 8;
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
        <span style="font-weight: bold; font-size: 22px;">LAPORAN FAKTUR EKSPEDISI - RANGKUMAN</span>
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
        <!-- Header row -->
        <tr>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 8;">No</td>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 8;">No. Faktur
            </td>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 8;width: 12%;">
                Tanggal
            </td>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 8; width: 10%;">Sopir
            </td>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 8;">No Kabin</td>
            {{-- <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 8;">Type Memo</td> --}}
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 8;">Rute</td>
            <td class="td" style="text-align: right; padding: 5px; font-weight:bold; font-size: 8;">Uang Tambah
            </td>
            <td class="td" style="text-align: right; padding: 5px; font-weight:bold; font-size: 8;">Total</td>
        </tr>
        <!-- Separator row -->
        <tr style="border-bottom: 1px solid black;">
            <td colspan="5" style="padding: 0px;"></td>
        </tr>
        <!-- Data rows -->
        @foreach ($inquery as $faktur)
            <tr>
                <td class="td" style="text-align: left; padding: 5px; font-size: 8;">{{ $loop->iteration }}</td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 8;">{{ $faktur->kode_faktur }}</td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 8;">{{ $faktur->tanggal_awal }}
                </td>
                <td class="td"
                    style="text-align: left; padding: 5px; font-size: 8; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    {{ substr($faktur->detail_faktur->first()->nama_driver, 0, 5) . '...' }}
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 8;">
                    {{ $faktur->detail_faktur->first()->no_kabin }}</td>
                {{-- <td class="td" style="text-align: left; padding: 5px; font-size: 8;">{{ $faktur->kategori }}</td> --}}


                <td class="td" style="text-align: left; padding: 5px; font-size: 8;">
                    {{ $faktur->detail_faktur->first()->nama_rute }}
                </td>

                <td class="td" style="text-align: right; padding: 5px; font-size: 8;">
                    {{ $faktur->biaya_tambahan }}
                </td>

                <td class="td" style="text-align: right; padding: 5px; font-size: 8;">
                    {{ $faktur->grand_total }}
                </td>

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
                $total += $item->grand_total;
            @endphp
        @endforeach
        <tr>
            <td colspan="7" style="text-align: right; font-weight: bold; padding: 5px; font-size: 8;">Sub Total
            </td>
            <td style="text-align: right; font-weight: bold; padding: 5px; font-size: 8;">
                {{ number_format($total, 0, ',', '.') }}
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
