<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-11px">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Faktur Ekspedisi</title>
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
        <span style="font-weight: bold; font-size: 22px;">FAKTUR EKSPEDISI - RANGKUMAN</span>
        <br>
        <div class="text">
            @php
                $startDate = request()->query('tanggal_awal');
                $endDate = request()->query('tanggal_akhir');
                $kendaraan = request()->query('kendaraan_id');
            @endphp
            @if ($startDate && $endDate)
                <p>Periode:{{ $startDate }} s/d {{ $endDate }}
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
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 11px; width:27%">
                Faktur
                Ekspedisi</td>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 11px; width:18%">
                Tanggal
            </td>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 11px; width:40%">
                Pelanggan</td>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 11px; width:40%">No
                Polisi
            </td>
            <td class="td" style="text-align: right; padding: 5px; font-weight:bold; font-size: 11px; width:25%">
                Total
            </td>
            <td class="td" style="text-align: right; padding: 5px; font-weight:bold; font-size: 11px; width:25%">
                Pph
            </td>
            <td class="td" style="text-align: right; padding: 5px; font-weight:bold; font-size: 11px; width:15% ">
                Sub Total
            </td>

        </tr>
        <!-- Separator row -->
        <tr style="border-bottom: 1px solid black;">
            <td colspan="5" style="padding: 0px;"></td>
        </tr>
        <!-- Data rows -->
        @foreach ($inquery as $faktur)
            <tr style="background:rgb(181, 181, 181)">
                <td class="td" style="text-align: left; padding: 5px; font-size: 11px;">{{ $faktur->kode_faktur }}
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 11px;">{{ $faktur->tanggal_awal }}
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 11px;">
                    {{ $faktur->nama_pelanggan }}
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 11px;">
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
                    {{ number_format($faktur->total_tarif, 2, ',', '.') }}
                </td>
                <td class="td" style="text-align: right; padding: 5px; font-size: 11px;">
                    {{ number_format($faktur->pph, 2, ',', '.') }}
                </td>
                <td class="td" style="text-align: right; padding: 5px; font-size: 11px;">
                    {{ number_format($faktur->grand_total, 2, ',', '.') }}
                </td>
            </tr>
            @foreach ($faktur->detail_faktur as $memo)
                <tr>
                    <td class="td" style="text-align: left; padding: 5px; font-size: 11px;">

                    </td>
                    <td class="td" style="text-align: left; padding: 5px; font-size: 11px;">
                        {{ $memo->kode_memo }}
                    </td>
                    <td class="td" style="text-align: left; padding: 5px; font-size: 11px;">
                        {{ $memo->created_at }}
                    </td>
                    <td class="td" style="text-align: left; padding: 5px; font-size: 11px;">


                    </td>
                    <td class="td" style="text-align: right; padding: 5px; font-size: 11px;">
                    </td>
                </tr>
                </tr>
            @endforeach
        @endforeach
        <!-- Separator row -->
        <tr style="border-bottom: 1px solid black;">
            <td colspan="" style="padding: 0px;"></td>
        </tr>
        <!-- Subtotal row -->
        @php
            $totaltarif = 0;
            $total = 0;
            $totalpph = 0;
        @endphp
        @foreach ($inquery as $item)
            @php
                $totaltarif += $item->total_tarif;
                $total += $item->grand_total;
                $totalpph += $item->pph;
            @endphp
        @endforeach
        <tr>
            <td colspan="6" style="text-align: right; font-weight: bold; padding: 5px; font-size: 11px;">
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
                            Total</td>
                        <td class="td" style="text-align: right; font-size: 11px;">
                            {{ number_format($totaltarif, 2, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" style="text-align: left; padding-left: 0px; font-size: 11px;">Pph
                        </td>
                        <td class="td" style="text-align: right; font-size: 11px;">
                            {{ number_format($totalpph, 2, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td colspan="6" style="padding: 0px;">
                            <hr style="border-top: 0.1px solid black; margin: 5px 0;">
                            {{-- <span
                                    style="position: absolute; top: 50%; transform: translateY(-50%); background-color: white; padding: 0 5px; font-size: 12px;">+</span> --}}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" style="text-align: left; padding-left: 0px; font-size: 11px;">Sub Total
                        </td>
                        <td class="td" style="text-align: right; padding-right: 6px; font-size: 11px;">
                            {{ number_format($totaltarif - $totalpph, 2, ',', '.') }}</td>
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
