<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Memo Asuransi Barang</title>
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
            font-size: 13px;
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
            padding-top: 13px;
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
            font-size: 10px;
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
        <span style="font-weight: bold; font-size: 18px;">MEMO ASURANSI BARANG</span>
        <br>
        <br>
        <div class="text">
            {{-- <p>Periode:{{ $notas->first()->tanggal_awal }} s/d {{ $notas->first()->id }}</p>
            <p>Periode: Tidak ada tanggal awal dan akhir yang diteruskan.</p> --}}
        </div>
    </div>

    </div>
    <table style="width: 100%; border-top: 1px solid black;" cellpadding="2" cellspacing="0">
        <!-- Header row -->
        <tr>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 13px;">Kode Memo
            </td>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 13px;">Kode SPK
            </td>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 13px;">Tanggal</td>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 13px;">Nama Tarif
            </td>
            <td class="td" style="text-align: right; padding: 5px; font-weight:bold; font-size: 13px;">Nominal
            </td>
            <td class="td" style="text-align: right; padding: 5px; font-weight:bold; font-size: 13px;">%
            </td>
            <td class="td" style="text-align: right; padding: 5px; font-weight:bold; font-size: 13px;">Total</td>
        </tr>
        <!-- Separator row -->
        <tr style="border-bottom: 1px solid black;">
            <td colspan="5" style="padding: 0px;"></td>
        </tr>
        <!-- Data rows -->
        @php
            $total = 0;
        @endphp
        @foreach ($memos as $item)
            <tr>
                <td class="td" style="text-align: left; padding: 5px; font-size: 13px;">{{ $item->kode_memo }}
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 13px;">
                    {{ $item->spk->kode_spk ?? null }}
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 13px;">{{ $item->tanggal_awal }}
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 13px;">
                    {{ $item->nama_tarif }}</td>
                <td class="td" style="text-align: right; padding: 5px; font-size: 13px;">
                    {{ number_format($item->nominal_tarif ?? 0, 2, ',', '.') }}
                </td>
                <td class="td" style="text-align: right; padding: 5px; font-size: 13px;">
                    {{ $item->persen }}
                </td>
                <td class="td" style="text-align: right; padding: 5px; font-size: 13px;">
                    {{ number_format($item->hasil_tarif, 2, ',', '.') }}
                </td>
            </tr>
            @php
                $total += $item->hasil_tarif;
            @endphp
        @endforeach
        <!-- Separator row -->
        <tr style="border-bottom: 1px solid black;">
            <td colspan="" style="padding: 0px;"></td>
        </tr>

        <tr>
            <td colspan="6" style="text-align: right; font-weight: bold; padding: 5px; font-size: 13px;">Sub Total
            </td>
            <td style="text-align: right; font-weight: bold; padding: 5px; font-size: 13px;">Rp.
                {{ number_format($total, 2, ',', '.') }}
            </td>

        </tr>
    </table>

    <br>

    <br>
    <br>

    <footer style="position: fixed; bottom: 0; right: 20px; width: auto; text-align: end; font-size: 10px;">Page
    </footer>
</body>

</html>
