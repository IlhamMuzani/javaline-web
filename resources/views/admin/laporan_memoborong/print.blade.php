<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-10px">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Memo Borong</title>
    <style>
        html,
        body {
            font-family: Arial, sans-serif;
            color: black;
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
        <img src="{{ public_path('storage/uploads/user/logo.png') }}" alt="JAVA LINE LOGISTICS" width="150" height="50">
    </div>
    <div style="font-weight: bold; text-align: center">
        <span style="font-weight: bold; font-size: 22px;">LAPORAN MEMO BORONG - RANGKUMAN</span>
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
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 10px;">No</td>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 10px;">No. Memo
            </td>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 10px;width: 12%;">
                Tanggal
            </td>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 10px; width: 10%;">Sopir
            </td>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 10px;">No Kabin</td>
            {{-- <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 10px;">Type Memo</td> --}}
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 10px;">Rute</td>
            <td class="td" style="text-align: right; padding: 5px; font-weight:bold; font-size: 10px;">Harga
            </td>
            <td class="td" style="text-align: right; padding: 5px; font-weight:bold; font-size: 10px;">Qty
            </td>
            <td class="td" style="text-align: right; padding: 5px; font-weight:bold; font-size: 10px;">Total</td>
            <td class="td" style="text-align: right; padding: 5px; font-weight:bold; font-size: 10px;">PPH
            </td>
            <td class="td" style="text-align: right; padding: 5px; font-weight:bold; font-size: 10px;">Adm</td>
            <td class="td" style="text-align: right; padding: 5px; font-weight:bold; font-size: 10px;">Deposit Sopir
            </td>
            <td class="td" style="text-align: right; padding: 5px; font-weight:bold; font-size: 10px;">Grand Total</td>
        </tr>
        <!-- Separator row -->
        <tr style="border-bottom: 1px solid black;">
            <td colspan="5" style="padding: 0px;"></td>
        </tr>
        <!-- Data rows -->
        @foreach ($inquery as $memo)
            <tr>
                <td class="td" style="text-align: left; padding: 5px; font-size: 10px;">{{ $loop->iteration }}</td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 10px;">{{ $memo->kode_memo }}</td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 10px;">{{ $memo->tanggal_awal }}
                </td>
                <td class="td"
                    style="text-align: left; padding: 5px; font-size: 10px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    {{ substr($memo->nama_driver, 0, 5) . '...' }}
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 10px;">{{ $memo->no_kabin }}</td>
                {{-- <td class="td" style="text-align: left; padding: 5px; font-size: 10px;">{{ $memo->kategori }}</td> --}}
                <td class="td" style="text-align: left; padding: 5px; font-size: 10px;">
                    @if ($memo->kategori == 'Memo Tambahan')
                    @else
                        @if ($memo->nama_rute == null)
                            {{ $memo->detail_memo->first()->nama_rutes }}
                        @else
                            {{ $memo->nama_rute }}
                        @endif
                    @endif
                </td>
                <td class="td" style="text-align: right; padding: 5px; font-size: 10px;">
                    @if ($memo->harga_rute == null)
                        0
                    @else
                        {{ number_format($memo->harga_rute, 0, ',', '.') }}
                    @endif
                </td>
                <td class="td" style="text-align: right; padding: 5px; font-size: 10px;">
                    @if ($memo->jumlah == null)
                        0
                    @else
                        {{ number_format($memo->jumlah, 0, ',', '.') }}
                    @endif
                </td>
                <td class="td" style="text-align: right; padding: 5px; font-size: 10px;">
                    @if ($memo->totalrute == null)
                        0
                    @else
                        {{ number_format($memo->totalrute, 0, ',', '.') }}
                    @endif
                </td>
                <td class="td" style="text-align: right; padding: 5px; font-size: 10px;">
                    @if ($memo->pphs == null)
                        0
                    @else
                        {{ number_format($memo->pphs, 0, ',', '.') }}
                    @endif
                </td>
                <td class="td" style="text-align: right; padding: 5px; font-size: 10px;">
                    @if ($memo->uang_jaminans == null)
                        0
                    @else
                        {{ number_format($memo->uang_jaminans, 0, ',', '.') }}
                    @endif
                </td>
                <td class="td" style="text-align: right; padding: 5px; font-size: 10px;">
                    @if ($memo->deposit_drivers == null)
                        0
                    @else
                        {{ number_format($memo->deposit_drivers, 0, ',', '.') }}
                    @endif
                </td>
                <td class="td" style="text-align: right; padding: 5px; font-size: 10px;">
                    {{ number_format(($memo->sub_total) / 2, 0, ',', '.') }}
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
                $total += $item->total_borongs;
            @endphp
        @endforeach
        <tr>
            <td colspan="12" style="text-align: right; font-weight: bold; padding: 5px; font-size: 10px;">Sub Total
            </td>
            <td style="text-align: right; font-weight: bold; padding: 5px; font-size: 10px;">
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
