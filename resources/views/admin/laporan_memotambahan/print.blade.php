<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-9">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Memo Tambahan</title>
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
            font-size: 9;
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
            padding-top: 9;
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
        <span style="font-weight: bold; font-size: 22px;">LAPORAN MEMO TAMBAHAN - RANGKUMAN</span>
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
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 9;">No</td>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 9;">No. Memo
            </td>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 9;">No. Memo Tambahan
            </td>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 9;width: 12%;">
                Tanggal
            </td>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 9; width: 10%;">Sopir
            </td>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 9;">No Kabin</td>
            {{-- <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 9;">Type Memo</td> --}}
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 9;">Rute</td>
            <td class="td" style="text-align: right; padding: 5px; font-weight:bold; font-size: 9;">U. Tambah
            </td>
        </tr>
        <!-- Separator row -->
        <tr style="border-bottom: 1px solid black;">
            <td colspan="5" style="padding: 0px;"></td>
        </tr>
        <!-- Data rows -->
        @foreach ($inquery as $memo)
            <tr>
                <td class="td" style="text-align: left; padding: 5px; font-size: 9;">{{ $loop->iteration }}</td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 9;">
                    {{ $memo->memotambahan->memo->kode_memo }}</td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 9;">{{ $memo->kode_memo }}</td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 9;">{{ $memo->tanggal_awal }}</td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 9;">
                    {{ $memo->memotambahan->memo->no_kabin }}</td>
                <td class="td"
                    style="text-align: left; padding: 5px; font-size: 8; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    {{ substr($memo->memotambahan->memo->nama_driver, 0, 5) . '...' }}
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 9;">
                    {{ $memo->memotambahan->memo->nama_rute }}</td>
                <td class="td" style="text-align: right; padding: 5px; font-size: 9;">
                    {{ number_format($memo->memotambahan->grand_total, 0, ',', '.') }}</td>



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
                $total += $item->total_borongs;
            @endphp
        @endforeach
        <tr>
            <td colspan="7" style="text-align: right; font-weight: bold; padding: 5px; font-size: 9;">Sub Total
            </td>
            <td style="text-align: right; font-weight: bold; padding: 5px; font-size: 9;">
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
