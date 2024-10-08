<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Memo PERJALANAN</title>
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
        <img src="{{ public_path('storage/uploads/user/logo.png') }}" alt="JAVA LINE LOGISTICS" width="150" height="50">
    </div>
    <div style="font-weight: bold; text-align: center">
        <span style="font-weight: bold; font-size: 22px;">LAPORAN MEMO PERJALANAN - RANGKUMAN</span>
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
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 8;">No. Memo
            </td>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 8;width: 12%;">
                Tanggal
            </td>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 8; width: 10%;">Sopir
            </td>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 8;">Kabin</td>
            {{-- <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 8;">Type Memo</td> --}}
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 8;">Rute</td>
            <td class="td" style="text-align: right; padding: 5px; font-weight:bold; font-size: 8;">UJ
            </td>
            <td class="td" style="text-align: right; padding: 5px; font-weight:bold; font-size: 8;">UT
            </td>
            <td class="td" style="text-align: right; padding: 5px; font-weight:bold; font-size: 8;">PM
            </td>
            <td class="td" style="text-align: right; padding: 5px; font-weight:bold; font-size: 8;">Deposit</td>
            <td class="td" style="text-align: right; padding: 5px; font-weight:bold; font-size: 8;">Adm
            </td>
            <td class="td" style="text-align: right; padding: 5px; font-weight:bold; font-size: 8;">Total</td>
        </tr>
        <!-- Separator row -->
        <tr style="border-bottom: 1px solid black;">
            <td colspan="5" style="padding: 0px;"></td>
        </tr>
        <!-- Data rows -->
        @foreach ($inquery as $memo)
            <tr>
                <td class="td" style="text-align: left; padding: 5px; font-size: 8;">{{ $loop->iteration }}</td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 8;">{{ $memo->kode_memo }}</td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 8;">{{ $memo->tanggal_awal }}
                </td>
                <td class="td"
                    style="text-align: left; padding: 5px; font-size: 8; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    {{ substr($memo->nama_driver, 0, 5) . '...' }}
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 8;">{{ $memo->no_kabin }}</td>
                {{-- <td class="td" style="text-align: left; padding: 5px; font-size: 8;">{{ $memo->kategori }}</td> --}}
                <td class="td" style="text-align: left; padding: 5px; font-size: 8;">
                    @if ($memo->nama_rute == null)
                        {{ $memo->detail_memo->first()->nama_rutes }}
                    @else
                        {{ $memo->nama_rute }}
                    @endif
                </td>
                <td class="td" style="text-align: right; padding: 5px; font-size: 8;">
                    @if ($memo->uang_jalan == null)
                        0
                    @else
                        {{ number_format($memo->uang_jalan, 0, ',', '.') }}
                    @endif
                </td>
                <td class="td" style="text-align: right; padding: 5px; font-size: 8;">
                    @if ($memo->biaya_tambahan == null)
                        0
                    @else
                        {{ number_format($memo->biaya_tambahan, 0, ',', '.') }}
                    @endif
                </td>
                <td class="td" style="text-align: right; padding: 5px; font-size: 8;">
                    @if ($memo->potongan_memo == null)
                        0
                    @else
                        {{ number_format($memo->potongan_memo, 0, ',', '.') }}
                    @endif
                </td>
                <td class="td" style="text-align: right; padding: 5px; font-size: 8;">
                    @if ($memo->deposit_driver == null)
                        0
                    @else
                        {{ number_format($memo->deposit_driver, 0, ',', '.') }}
                    @endif
                </td>
                <td class="td" style="text-align: right; padding: 5px; font-size: 8;">
                    @if ($memo->uang_jaminan == null)
                        0
                    @else
                        {{ number_format($memo->uang_jaminan, 0, ',', '.') }}
                    @endif
                </td>
                <td class="td" style="text-align: right; padding: 5px; font-size: 8;">
                    @if ($memo->sub_total == null)
                        0
                    @else
                        {{ number_format($memo->sub_total, 0, ',', '.') }}
                    @endif
                </td>
            </tr>
        @endforeach
        <!-- Separator row -->
        <tr style="border-bottom: 1px solid black;">
            <td colspan="" style="padding: 0px;"></td>
        </tr>
        <!-- Subtotal row -->
        @php
            $totalUJ = 0;
            $totaltambahan = 0;
            $totalpotongan = 0;
            $deposit = 0;
            $total = 0;
        @endphp
        @foreach ($inquery as $item)
            @php
                $totalUJ += $item->uang_jalan;
                $totaltambahan += $item->biaya_tambahan;
                $totalpotongan += $item->potongan_memo;
                $deposit += $item->deposit_driver;
                $total += $item->sub_total;

            @endphp
        @endforeach
        <tr>
            <td colspan="11" style="text-align: right; font-weight: bold; padding: 5px; font-size: 8;">Sub Total
            </td>
            {{-- <td style="text-align: right; font-weight: bold; padding: 5px; font-size: 7;">
                {{ number_format($totalUJ + $totaltambahan - $totalpotongan, 0, ',', '.') }}
            </td> --}}
            <td style="text-align: right; font-weight: bold; padding: 5px; font-size: 9;">
                {{-- {{ number_format($totalUJ + $totaltambahan - $totalpotongan, 2, ',', '.') }} --}}
            </td>
        </tr>
    </table>




    <br>

    <!-- Tampilkan sub-total di bawah tabel -->
    {{-- <div style="text-align: right;">
        <strong>Sub Total: Rp. {{ number_format($total, 0, ',', '.') }}</strong>
    </div> --}}


    {{-- <br> --}}

    <table width="100%" style="border-collapse: collapse;">
        <tr>
            <td style="width:100%;">

            </td>
            <td style="width: 70%;">
                <table style="width: 100%;" cellpadding="2" cellspacing="0">
                    <tr>
                        <td colspan="5"
                            style="text-align: left; font-weight: bold; padding-left: 0px; font-size: 11px;">
                            Uang Jalan</td>
                        <td class="td" style="text-align: right; font-weight: bold; font-size: 11px;">
                            {{ number_format($totalUJ, 2, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5"
                            style="text-align: left; font-weight: bold; padding-left: 0px; font-size: 11px;">Uang
                            Tambahan
                        </td>
                        <td class="td" style="text-align: right; font-weight: bold; font-size: 11px;">
                            {{ number_format($totaltambahan - $totalpotongan, 2, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td colspan="6" style="padding: 0px;">
                            <hr style="border-top: 0.1px solid black; margin: 5px 0;">
                            {{-- <span
                                    style="position: absolute; top: 50%; transform: translateY(-50%); background-color: white; padding: 0 5px; font-size: 12px;">+</span> --}}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5"
                            style="text-align: left; font-weight: bold; padding-left: 0px; font-size: 11px;">
                        </td>
                        <td class="td" style="text-align: right; font-weight: bold; padding: 2px; font-size: 11px;">
                            {{ number_format($totalUJ + $totaltambahan - $totalpotongan, 2, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <br>
                    </tr>
                    <tr>
                        <td colspan="5"
                            style="text-align: left; font-weight: bold; padding-left: 0px; font-size: 11px;">
                            Deposit
                        </td>
                        <td class="td" style="text-align: right; font-weight: bold; font-size: 11px;">
                            {{ number_format($deposit, 2, ',', '.') }}

                        </td>
                    </tr>

                    {{-- <tr>
                        <td colspan="5" style="text-align: left; padding-left: 0px; font-size: 11px;">
                            Sub Total
                        </td>
                        <td class="td" style="text-align: right; font-size: 11px;">
                            {{ number_format($totalUJ + $totaltambahan - $deposit, 0, ',', '.') }}
                        </td>
                    </tr> --}}
                    <tr>
                        <td colspan="6" style="padding: 0px;">
                            <hr style="border-top: 0.1px solid black; font-weight: bold; margin: 5px 0;">
                            {{-- <span
                                    style="position: absolute; top: 50%; transform: translateY(-50%); background-color: white; padding: 0 5px; font-size: 12px;">+</span> --}}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5"
                            style="text-align: left; font-weight: bold; padding-left: 0px; font-size: 11px;">
                            Sub Total
                        </td>
                        <td class="td" style="text-align: right; font-weight: bold; font-size: 11px;">
                            {{ number_format($totalUJ + $totaltambahan - $totalpotongan - $deposit, 2, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <br><br><br>
                    </tr>
                    <tr>
                        <td colspan="5"
                            style="text-align: left; font-weight: bold; padding-left: 120px; font-size: 11px;">
                            Admin
                        </td>
                    </tr>
                </table>
            </td>

        </tr>
    </table>



    <br>
    <br>

</body>

</html>
