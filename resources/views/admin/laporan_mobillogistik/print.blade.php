<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-11px">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Faktur Ekspedisi Mobil Logistik</title>
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
            font-size: 11px;
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
            padding-top: 11px;
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
        <span style="font-weight: bold; font-size: 22px;">FAKTUR EKSPEDISI MOBIL LOGISTIK - RANGKUMAN</span>
        <br>
        <div class="text">
            @php
                $startDate = request()->query('created_at');
                $endDate = request()->query('tanggal_akhir');
                $kendaraan = request()->query('kendaraan_id');

            @endphp
            @if ($startDate && $endDate)
                <p>Periode:{{ $startDate }} s/d {{ $endDate }} {{ $inquery->first()->kendaraan->no_pol }}
                </p>
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
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 11px; width:20%">
                Faktur
                Ekspedisi</td>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 11px; width:15%">
                Tanggal
            </td>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 11px; width:30%">
                Pelanggan</td>
            <td class="td" style="text-align: center; padding: 5px; font-weight:bold; font-size: 11px; width:35%">No
                Polisi
            </td>
            <td class="td" style="text-align: right; padding: 5px; font-weight:bold; font-size: 11px; width:15% ">
                Sub Total
            </td>

        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td colspan="5" style="padding: 0px;"></td>
        </tr>
        @php
            $totalGrandTotal = 0;
            $totalGrandTotalMemo = 0;
            $totalTambahan = 0;

            $created_at = isset($created_at) ? $created_at : null;
            $tanggal_akhir = isset($tanggal_akhir) ? $tanggal_akhir : null;
        @endphp
        @foreach ($inquery as $faktur)
            @if ($faktur->kendaraan_id == $kendaraan)
                <tr style="background:rgb(181, 181, 181)">
                    <td class="td" style="text-align: left; padding: 5px; font-size: 11px;">
                        {{ $faktur->kode_faktur }}
                    </td>
                    <td class="td" style="text-align: left; padding: 5px; font-size: 11px;">
                        {{ $faktur->created_at }}
                    </td>
                    <td class="td" style="text-align: left; padding: 5px; font-size: 11px;">
                        {{ $faktur->nama_pelanggan }}
                    </td>
                    <td class="td" style="text-align: right; padding: 5px; font-size: 11px;">
                        @if ($faktur->detail_faktur->first())
                            {{ $faktur->detail_faktur->first()->nama_driver }}
                        @else
                        @endif
                        @if ($faktur->kendaraan)
                            ({{ $faktur->kendaraan->no_pol }})
                        @else
                        @endif
                    </td>
                    <td class="td" style="text-align: right; padding: 5px; font-size: 11px;">
                        {{ number_format($faktur->grand_total, 0, ',', '.') }}
                    </td>
                </tr>
                @foreach ($faktur->detail_faktur as $memo)
                    <tr>
                        <td class="td" style="text-align: left; padding: 5px; font-size: 11px;">
                            {{ $memo->kode_memo }}
                        </td>
                        <td class="td" style="text-align: left; padding: 5px; font-size: 11px;">
                            {{ $memo->created_at }}
                        </td>
                        <td class="td" style="text-align: left; padding: 5px; font-size: 11px;">
                            {{ $memo->nama_rute }}
                        </td>
                        <td class="td" style="text-align: right; padding: 5px; font-size: 11px;">
                            <span style="margin-right:30px">
                                @if ($memo->memo_ekspedisi)
                                    {{ number_format($memo->memo_ekspedisi->uang_jalan, 0, ',', '.') }}
                                @else
                                    tidak ada
                                @endif
                            </span>
                            <span style="margin-right:30px">
                                @if ($memo->memo_ekspedisi)
                                    {{ number_format($memo->memo_ekspedisi->biaya_tambahan, 0, ',', '.') }}
                                @else
                                    tidak ada
                                @endif
                            </span>
                            <span>
                                @if ($memo->memo_ekspedisi)
                                    {{ number_format($memo->memo_ekspedisi->deposit_driver, 0, ',', '.') }}
                                @else
                                    tidak ada
                                @endif
                            </span>
                        </td>
                        <td class="td" style="text-align: right; padding: 5px; font-size: 11px;">
                            @if ($memo->memo_ekspedisi)
                                {{ number_format($memo->memo_ekspedisi->hasil_jumlah, 0, ',', '.') }}
                            @elseif($memo->memo_ekspedisi && $memo->memotambahan)
                                {{ number_format($memo->memotambahan->grand_total, 0, ',', '.') }}
                            @else
                                <!-- Handle kondisi ketika tidak memenuhi kedua kondisi di atas -->
                            @endif

                        </td>
                    </tr>
                    @php
                        $totalmemo = 0;
                    @endphp
                    @foreach ($faktur->detail_faktur as $item)
                        @php
                            $totalmemo += $item->memo_ekspedisi->hasil_jumlah ?? 0;
                        @endphp
                    @endforeach

                    @if ($memo->memo_ekspedisi && $memo->memo_ekspedisi->memotambahan->isNotEmpty())
                        @foreach ($memo->memo_ekspedisi->memotambahan as $memoTambahan)
                            <tr>
                                <td class="td" style="text-align: left; padding: 5px; font-size: 11px;">
                                    {{ $memoTambahan->kode_tambahan }} </td>
                                <td class="td" style="text-align: left; padding: 5px; font-size: 11px;">
                                    {{ $memoTambahan->created_at }} </td>
                                <td class="td" style="text-align: left; padding: 5px; font-size: 11px;">
                                    {{ $memoTambahan->memo_ekspedisi->nama_rute }} </td>
                                <td class="td" style="text-align: right; padding: 5px; font-size: 11px;">
                                    <span style="margin-right:34px">
                                        {{ number_format($memoTambahan->grand_total, 0, ',', '.') }}
                                    </span>
                                    <span style="margin-right:62px">0</span>
                                    <span style="margin-right:5px">0</span>
                                </td>
                                <td class="td" style="text-align: right; padding: 5px; font-size: 11px;">
                                    {{ number_format($memoTambahan->grand_total, 0, ',', '.') }}
                                </td>
                            </tr>

                            @php
                                $totalTambahan += $memoTambahan->grand_total;

                            @endphp
                        @endforeach
                    @endif
                @endforeach
            @endif
            @php
                $totalGrandTotal += $faktur->grand_total;
                $totalGrandTotalMemo += $memo->memo_ekspedisi->hasil_jumlah ?? 0;
                // $Selisih = $totalGrandTotal - $totalGrandTotalMemo;
                // $Totals = $totalGrandTotal - $totalGrandTotalMemo;
            @endphp
        @endforeach
        @php
            $Selisih = $totalGrandTotal - $totalGrandTotalMemo - $totalTambahan;
            $Totals = $totalGrandTotal - $totalGrandTotalMemo - $totalTambahan;
        @endphp
        <tr style="border-bottom: 1px solid black;">
            <td colspan="" style="padding: 0px;"></td>
        </tr>
        {{-- @php
            $total = 0;
        @endphp
        @foreach ($inquery as $item)
            @php
                $total += $item->grand_total;
            @endphp
        @endforeach --}}
        <tr>
            <td colspan="4" style="text-align: right; font-weight: bold; padding: 5px; font-size: 11px;">
                {{-- Sub Total --}}
            </td>
            <td style="text-align: right; font-weight: bold; padding: 5px; font-size: 11px;">
                {{-- {{ number_format($total, 0, ',', '.') }} --}}
            </td>
        </tr>
    </table>


    <table width="100%" style="border-collapse: collapse;">
        <tr>
            <td style="width:100%;">

            </td>
            <td style="width: 70%;">
                <table style="width: 100%;" cellpadding="2" cellspacing="0">
                    <tr>
                        <td colspan="5" style="text-align: left; padding-left: 0px; font-size: 11px;">
                            Total Faktur</td>
                        <td class="td" style="text-align: right; font-size: 11px;">
                            {{ number_format($totalGrandTotal, 0, ',', '.') }} </td>
                    </tr>
                    <tr>
                        <td colspan="5" style="text-align: left; padding-left: 0px; font-size: 11px;">Total Memo
                        </td>
                        <td class="td" style="text-align: right; font-size: 11px;">
                            {{ number_format($totalGrandTotalMemo + $totalTambahan, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td colspan="6" style="padding: 0px;">
                            <hr style="border-top: 0.1px solid black; margin: 5px 0;">
                            {{-- <span
                                    style="position: absolute; top: 50%; transform: translateY(-50%); background-color: white; padding: 0 5px; font-size: 12px;">+</span> --}}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" style="text-align: left; padding-left: 0px; font-size: 11px;">Selisih
                        </td>
                        <td class="td" style="text-align: right; padding-right: 5px; font-size: 11px;">
                            {{ number_format($Selisih, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <br>
                    </tr>
                    <tr>
                        <td colspan="5" style="text-align: left; padding-left: 0px; font-size: 11px;">
                            Biaya Operasional
                        </td>
                        <td class="td" style="text-align: right; font-size: 11px;">
                            0
                        </td>
                    </tr>
                    {{-- <tr>
                            <td colspan="5" style="text-align: left; padding-left: 0px; font-size: 11px;">
                                Adm
                            </td>
                            <td class="td" style="text-align: right; padding-right: 17px; font-size: 11px;">
                                {{ number_format($cetakpdf->uang_jaminan, 0, ',', '.') }}
                            </td>
                        </tr> --}}
                    <tr>
                        <td colspan="5" style="text-align: left; padding-left: 0px; font-size: 11px;">Biaya
                            Perbaikan
                        </td>
                        <td class="td" style="text-align: right; font-size: 11px;">
                            0</td>
                    </tr>
                    <tr>
                        <td colspan="6" style="padding: 0px;">
                            <hr style="border-top: 0.1px solid black; margin: 5px 0;">
                            {{-- <span
                                    style="position: absolute; top: 50%; transform: translateY(-50%); background-color: white; padding: 0 5px; font-size: 12px;">+</span> --}}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" style="text-align: left; padding-left: 0px; font-size: 11px;">
                            Sub Total
                        </td>
                        <td class="td" style="text-align: right; font-size: 11px;">
                            {{ number_format($Totals, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <br><br><br>
                    </tr>
                    <tr>
                        <td colspan="5" style="text-align: left; padding-left: 120px; font-size: 11px;">
                            Admin
                        </td>
                    </tr>
                </table>
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