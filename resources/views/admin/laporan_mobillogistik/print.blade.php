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
            margin: 20px;
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
        <span style="font-weight: bold; font-size: 20px;">FAKTUR EKSPEDISI MOBIL LOGISTIK - RANGKUMAN</span>
        <br>
        <div class="text">
            @php
                $startDate = request()->query('created_at');
                $endDate = request()->query('tanggal_akhir');
                $kendaraan = request()->query('kendaraan_id');

            @endphp
            @if ($startDate && $endDate)
                <p>Periode:{{ $startDate }} s/d {{ $endDate }} {{ $inquery->first()->kendaraan->no_pol }}
                    ({{ $inquery->first()->kendaraan->no_kabin }})
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
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 11px; width:40%">
                Nama Driver
            </td>
            <td class="td" style="text-align: right; padding: 5px; font-weight:bold; font-size: 11px; width:25%">
                No. Polisi
            </td>
            <td class="td" style="text-align: right; padding: 5px; font-weight:bold; font-size: 11px; width:25%">

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
        @php
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
                        {{ $faktur->created_at->format('Y-m-d') }}
                    </td>
                    <td class="td" style="text-align: left; padding: 5px; font-size: 11px;">
                        {{ $faktur->nama_pelanggan }}
                    </td>
                    <td class="td" style="text-align: left; padding: 5px; font-size: 11px;">
                        @if ($faktur->detail_faktur->first())
                            {{ $faktur->detail_faktur->first()->nama_driver }}
                        @else
                        @endif
                    </td>
                    <td class="td" style="text-align: right; padding: 5px; font-size: 11px;">
                        @if ($faktur->kendaraan)
                            ({{ $faktur->kendaraan->no_pol }})
                        @else
                        @endif
                    </td>
                    <td class="td" style="text-align: right; padding: 5px; font-size: 11px;">
                    </td>
                    <td class="td" style="text-align: right; padding: 5px; font-size: 11px;">
                        {{ number_format($faktur->grand_total, 2, ',', '.') }}
                    </td>
                </tr>
                @foreach ($faktur->detail_faktur as $memo)
                    <tr>
                        <td class="td" style="text-align: left; padding: 5px; font-size: 11px;">
                            {{ $memo->kode_memo }}

                        </td>
                        <td class="td" style="text-align: left; padding: 5px; font-size: 11px;">
                            {{ $memo->memo_ekspedisi->tanggal_awal }}
                        </td>
                        <td class="td" style="text-align: left; padding: 5px; font-size: 11px;">
                            {{ $memo->nama_rute }}
                        </td>
                        <td class="td" style="text-align: right; padding: 5px; font-size: 11px;">
                            @if ($memo->memo_ekspedisi->kategori == 'Memo Perjalanan')
                                @if ($memo->memo_ekspedisi)
                                    {{ number_format($memo->memo_ekspedisi->uang_jalan, 2, ',', '.') }}
                                @else
                                    tidak ada
                                @endif
                            @else
                                @if ($memo->memo_ekspedisi)
                                    {{ number_format($memo->memo_ekspedisi->totalrute, 2, ',', '.') }}
                                @else
                                    tidak ada
                                @endif
                            @endif
                        </td>
                        <td class="td" style="text-align: right; padding: 5px; font-size: 11px;">
                            @if ($memo->memo_ekspedisi)
                                {{ number_format($memo->memo_ekspedisi->biaya_tambahan, 2, ',', '.') }}
                            @else
                                tidak ada
                            @endif
                        </td>
                        <td class="td" style="text-align: right; padding: 5px; font-size: 11px;">
                            @if ($memo->memo_ekspedisi)
                                {{ number_format($memo->memo_ekspedisi->deposit_driver, 2, ',', '.') }}
                            @else
                                tidak ada
                            @endif
                        </td>
                        <td class="td" style="text-align: right; padding: 5px; font-size: 11px;">
                            @if ($memo->memo_ekspedisi)
                                {{ number_format($memo->memo_ekspedisi->hasil_jumlah, 2, ',', '.') }}
                            @else
                                tidak ada
                            @endif
                        </td>
                    </tr>
                    @foreach ($faktur->detail_faktur as $item)
                    @endforeach
                    @if ($memo->memo_ekspedisi && $memo->memo_ekspedisi->memotambahan->isNotEmpty())
                        @foreach ($memo->memo_ekspedisi->memotambahan as $memoTambahan)
                            <tr>
                                <td class="td" style="text-align: left; padding: 5px; font-size: 11px;">
                                    {{ $memoTambahan->kode_tambahan }}
                                </td>
                                <td class="td" style="text-align: left; padding: 5px; font-size: 11px;">
                                    {{ $memoTambahan->tanggal_awal }} </td>
                                <td class="td" style="text-align: left; padding: 5px; font-size: 11px;">
                                    {{ $memoTambahan->memo_ekspedisi->nama_rute }} </td>
                                <td class="td" style="text-align: right; padding: 5px; font-size: 11px;">
                                    {{ number_format($memoTambahan->grand_total, 2, ',', '.') }}
                                </td>
                                <td class="td" style="text-align: right; padding: 5px; font-size: 11px;">
                                    0,00
                                </td>
                                <td class="td" style="text-align: right; padding: 5px; font-size: 11px;">
                                    0,00
                                </td>
                                <td class="td" style="text-align: right; padding: 5px; font-size: 11px;">
                                    {{ number_format($memoTambahan->grand_total, 2, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    @endif
                @endforeach
            @endif
        @endforeach
        <!-- Separator row -->
        <tr style="border-bottom: 1px solid black;">
            <td colspan="" style="padding: 0px;"></td>
        </tr>
        <!-- Subtotal row -->
        <tr>
            <td colspan="6" style="text-align: right; font-weight: bold; padding: 5px; font-size: 11px;">
                {{-- Sub Total --}}
            </td>
            <td style="text-align: right; font-weight: bold; padding: 5px; font-size: 11px;">
                {{-- {{ number_format($total, 0, ',', '.') }} --}}
            </td>
        </tr>
    </table>

    @php
        $totalGrandTotal = 0;
        $totalMemo = 0;
        $totalMemoTambahan = 0;
        $totalMemoasuransi = 0;

        foreach ($inquery as $faktur) {
            $totalGrandTotal += $faktur->grand_total; // Total Faktur

            foreach ($faktur->detail_faktur as $memo) {
                $totalMemo += $memo->memo_ekspedisi->hasil_jumlah ?? 0; // Total Memo Ekspedisi

                if ($memo->memo_ekspedisi && $memo->memo_ekspedisi->memotambahan) {
                    foreach ($memo->memo_ekspedisi->memotambahan as $memoTambahan) {
                        $totalMemoTambahan += $memoTambahan->grand_total ?? 0; // Total Memo Tambahan
                    }
                }
            }

            if ($faktur->spk && isset($faktur->spk->id)) {
                // echo 'ID SPK: ' . $faktur->spk->id . '<br>';

                // Ambil memo_asuransi yang berelasi
                $memoAsuransiList = $faktur->spk->memo_asuransi;

                // Inisialisasi variabel totalMemoasuransi
                $totalMemoasuransi = 0;

                if ($memoAsuransiList->isNotEmpty()) {
                    foreach ($memoAsuransiList as $memo) {
                        // echo 'Memo Asuransi ID: ' . $memo->id . ', Nominal: ' . $memo->hasil_tarif . '<br>';
                        // Tambahkan nilai hasil_tarif ke totalMemoasuransi
                        $totalMemoasuransi += $memo->hasil_tarif ?? 0;
                    }

                    // echo 'Total Memo Asuransi: ' . $totalMemoasuransi . '<br>';
                } else {
                    // echo 'Tidak ada memo asuransi terkait.<br>';
                }
            }
        }

        // Hitung selisih antara total faktur dengan total memo + memo tambahan
        $selisih = $totalGrandTotal - ($totalMemo + $totalMemoTambahan) - $totalMemoasuransi;
    @endphp

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
                            {{ number_format($totalGrandTotal, 2, ',', '.') }} </td>
                    </tr>
                    <tr>
                        <td colspan="5" style="text-align: left; padding-left: 0px; font-size: 11px;">Total Memo
                        </td>
                        <td class="td" style="text-align: right; font-size: 11px;">
                            {{ number_format($totalMemo + $totalMemoTambahan, 2, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td colspan="5" style="text-align: left; padding-left: 0px; font-size: 11px;">Total Memo
                            Asuransi
                        </td>
                        <td class="td" style="text-align: right; font-size: 11px;">
                            {{ number_format($totalMemoasuransi, 2, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td colspan="6" style="padding: 0px;">
                            <hr style="border-top: 0.1px solid black; margin: 5px 0;">

                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" style="text-align: left; padding-left: 0px; font-size: 11px;">Selisih
                        </td>
                        <td class="td" style="text-align: right; padding-right: 5px; font-size: 11px;">
                            {{ number_format($selisih, 2, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <br>
                    </tr>
                    <tr>
                        <td colspan="5" style="text-align: left; padding-left: 0px; font-size: 11px;">
                            Biaya Operasional
                        </td>
                        <td class="td" style="text-align: right; font-size: 11px;">
                            {{ number_format($totalNominalPerbaikan, 2, ',', '.') }}
                        </td>
                    </tr>

                    <tr>
                        <td colspan="5" style="text-align: left; padding-left: 0px; font-size: 11px;">Biaya
                            Perbaikan
                        </td>
                        <td class="td" style="text-align: right; font-size: 11px;">
                            {{ number_format($totalNominalOperasional, 2, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6" style="padding: 0px;">
                            <hr style="border-top: 0.1px solid black; margin: 5px 0;">

                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" style="text-align: left; padding-left: 0px; font-size: 11px;">
                            Sub Total
                        </td>
                        <td class="td" style="text-align: right; font-size: 11px;">
                            {{ number_format($selisih - $totalNominalPerbaikan - $totalNominalOperasional, 2, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <br>
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


    <br>
    <br>

    <footer style="position: fixed; bottom: 0; right: 20px; width: auto; text-align: end; font-size: 10px;">Page
    </footer>

</body>

</html>
