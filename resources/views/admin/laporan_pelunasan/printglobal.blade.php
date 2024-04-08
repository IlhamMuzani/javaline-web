<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-10px">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Pelunasan Ekspedisi</title>
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
        <img src="{{ asset('storage/uploads/user/logo.png') }}" alt="JAVA LINE" width="70" height="35">
    </div>
    <div style="font-weight: bold; text-align: center">
        <span style="font-weight: bold; font-size: 22px;">PELUNASAN EKSPEDISI - RANGKUMAN</span>
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
    @foreach ($inquery as $faktur)
        @php
            $counter = 1; // Counter for each date
            $totalForFaktur = 0; // Variable to store total for each barangakun
        @endphp
        {{-- <table style="width: 100%; border-top: 1px solid black;" cellspacing="0">
            <!-- Header row -->
            <tr>
                <td colspan="1"
                    style="text-align: left; font-weight: bold; padding: 5px; font-size: 10px; background:rgb(190, 190, 190);">
                    Kode Akun: {{ $faktur->kode_pelunasan }} <span style="margin-left: 20px">Nama Akun:
                        {{ $faktur->kode_pelunasan }}</span>
                </td>
                <td colspan="2"
                    style="text-align: left; font-weight: bold; padding: 5px; font-size: 10px; background:rgb(190, 190, 190)">


                </td>
                <td colspan="3"
                    style="text-align: right; font-weight: bold; padding: 5px; font-size: 10px; background:rgb(190, 190, 190)">

                </td>
                <td colspan="4"
                    style="text-align: right; font-weight: bold; padding: 5px; font-size: 10px; background:rgb(190, 190, 190)">

                </td>
                <td colspan="5"
                    style="text-align: right; font-weight: bold; padding: 5px; font-size: 10px; background:rgb(190, 190, 190)">

                </td>
                <td
                    style="text-align: right; font-weight: bold; padding: 5px; font-size: 10px;background:rgb(190, 190, 190)">
                </td>
            </tr>
        </table> --}}
        <table style="width: 100%; border-top: 1px solid black;" cellpadding="2" cellspacing="0">
            <!-- Header row -->
            <tr>
                <td class="td"
                    style="text-align: left; padding: 5px; font-weight:bold; font-size: 10px; border-bottom: 1px solid black;  width: 15%">
                    No. Faktur</td>
                <td class="td"
                    style="text-align: left; padding: 5px; font-weight:bold; font-size: 10px; border-bottom: 1px solid black;  width: 40%">
                    Nama Customer</td>
                <td class="td"
                    style="text-align: left; padding: 5px; font-weight:bold; font-size: 10px; border-bottom: 1px solid black;  width: 15%">
                    Tgl Fak. Exp</td>
                <td class="td"
                    style="text-align: left; padding: 5px; font-weight:bold; font-size: 10px; border-bottom: 1px solid black;  width: 12%">
                    Tgl Bayar</td>
                <td class="td"
                    style="text-align: right; padding: 5px; font-weight:bold; font-size: 10px; border-bottom: 1px solid black;  width: 15%">
                    Ekspedisi</td>
                <td class="td"
                    style="text-align: right; padding: 5px; font-weight:bold; font-size: 10px; border-bottom: 1px solid black;  width: 25%">
                    Return Ekspedisi</td>
                <td class="td"
                    style="text-align: right; padding: 5px; font-weight:bold; font-size: 10px; border-bottom: 1px solid black;  width: 15%">
                    Potongan</td>
                <td class="td"
                    style="text-align: right; padding: 5px; font-weight:bold; font-size: 10px; border-bottom: 1px solid black;  width: 25%">
                    Ongkos Bongkar</td>
                <td class="td"
                    style="text-align: right; padding: 5px; font-weight:bold; font-size: 10px; border-bottom: 1px solid black;  width: 15%">
                    Jumlah Bayar</td>
                <td class="td"
                    style="text-align: right; padding: 5px; font-weight:bold; font-size: 10px; border-bottom: 1px solid black;  width: 20%">
                    Nominal</td>
            </tr>
            <tr style="border-bottom: 1px solid black;">
                <td colspan="10" style="padding: 0px;"></td>
            </tr>
            <!-- Data rows -->
            @foreach ($faktur->detail_pelunasan as $item)
                {{-- @if ($item->tanggal_awal == $date) --}}
                <tr>
                    <td class="td" style="text-align: left; padding: 5px; font-size: 10px;">
                        {{ $item->faktur_ekspedisi->kode_faktur }}
                    </td>
                    <td class="td" style="text-align: left; padding: 5px; font-size: 10px;">
                        {{ $item->faktur_pelunasan->nama_pelanggan }}
                    </td>
                    <td class="td" style="text-align: left; padding: 5px; font-size: 10px;">
                        {{ $item->faktur_ekspedisi->tanggal_awal }}
                    </td>
                    <td class="td" style="text-align: left; padding: 5px; font-size: 10px;">
                        {{ $item->faktur_pelunasan->tanggal_awal }}
                    </td>
                    <td class="td" style="text-align: right; padding: 5px; font-size: 10px;">
                        {{ number_format($item->faktur_ekspedisi->grand_total, 2, ',', '.') }}
                    </td>
                    <td class="td" style="text-align: right; padding: 5px; font-size: 10px;">
                        @php
                            // Mendapatkan nilai nominal_potongan
                            $detail_pelunasan_return = $item->faktur_pelunasan->detail_pelunasanreturn
                                ->where('faktur_ekspedisi_id', $item->faktur_ekspedisi_id)
                                ->first();
                            $nominal_potongan = $detail_pelunasan_return
                                ? $detail_pelunasan_return->nominal_potongan
                                : 0;

                        @endphp
                        {{ number_format($nominal_potongan, 2, ',', '.') }}
                    </td>
                    <td class="td" style="text-align: right; padding: 5px; font-size: 10px;">

                    </td>
                    <td class="td" style="text-align: right; padding: 5px; font-size: 10px;">

                    </td>
                    <td class="td" style="text-align: right; padding: 5px; font-size: 10px;">

                    </td>
                    <td class="td" style="text-align: right; padding: 5px; font-size: 10px; ">
                    </td>
                </tr>
                {{-- @endif --}}
            @endforeach
            <!-- Separator row -->
            <tr style="border-bottom: 1px solid black;">
                <td colspan="5" style="padding: 0px;"></td>
            </tr>
            <tr>
                <td
                    style="text-align: right; font-weight: bold; padding: 5px; font-size: 10px;background:rgb(190, 190, 190)">
                    {{ $faktur->kode_pelunasan }}
                </td>
                <td
                    style="text-align: right; font-weight: bold; padding: 5px; font-size: 10px;background:rgb(190, 190, 190)">

                </td>
                <td
                    style="text-align: right; font-weight: bold; padding: 5px; font-size: 10px;background:rgb(190, 190, 190)">

                </td>
                <td
                    style="text-align: right; font-weight: bold; padding: 5px; font-size: 10px;background:rgb(190, 190, 190)">

                </td>
                <td
                    style="text-align: right; font-weight: bold; padding: 5px; font-size: 10px;background:rgb(190, 190, 190)">
                    {{ number_format($faktur->detail_pelunasan->sum('total'), 2, ',', '.') }}
                </td>
                <td
                    style="text-align: right; font-weight: bold; padding: 5px; font-size: 10px;background:rgb(190, 190, 190)">
                    {{ number_format($faktur->detail_pelunasanreturn->sum('nominal_potongan'), 2, ',', '.') }}
                </td>
                <td
                    style="text-align: right; font-weight: bold; padding: 5px; font-size: 10px;background:rgb(190, 190, 190)">
                    {{ number_format($faktur->potonganselisih, 2, ',', '.') }}
                </td>
                <td
                    style="text-align: right; font-weight: bold; padding: 5px; font-size: 10px;background:rgb(190, 190, 190)">
                    0,00
                </td>
                <td
                    style="text-align: right; font-weight: bold; padding: 5px; font-size: 10px;background:rgb(190, 190, 190)">
                    {{ number_format($faktur->saldo_masuk, 2, ',', '.') }}
                </td>
                <td
                    style="text-align: right; font-weight: bold; padding: 5px; font-size: 10px;background:rgb(190, 190, 190)">
                    0,00
                </td>
            </tr>
        </table>
        <br>
    @endforeach
    <br>

    <br>
    <br>

</body>

</html>
