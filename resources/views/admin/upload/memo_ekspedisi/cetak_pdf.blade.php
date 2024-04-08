<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Memo Ekspedisi</title>
    <style>
        html,
        body {
            font-family: 'DOSVGA', monospace;
            color: black;
            /* Gunakan Arial atau font sans-serif lainnya yang mudah dibaca */
            margin: 40px;
        }

        .container {
            display: flex;
            justify-content: space-between;
            margin-top: 7rem;
        }

        .blue-button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            text-decoration: none;
            top: 50%;
            border-radius: 5px;
            transform: translateY(-50%);
        }

        .info-column {
            padding-left: 5px;
        }

        .info-titik {
            vertical-align: top;
        }

        /* tanda tangan  */

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .separator {
            padding-top: 14px;
            text-align: center;
        }

        .separator span {
            display: inline-block;
            border-top: 1px solid black;
            width: 100%;
            position: relative;
            top: -8px;
        }
    </style>
</head>

<body style="margin: 0; padding: 0;">
    <table width="100%">

        <tr>
            <!-- First column (Nama PT) -->
            <td style="width:0%;">
            </td>
            <td style="width: 70%; text-align: right;">
            </td>
        </tr>
    </table>
    <div style="text-align: center;">
        <span style="font-weight: bold; font-size: 25px;">PT BINA ANUGERAH TRANSINDO</span>
        <br>
        <span style=" font-size: 14px;">JL. HOS COKRO AMINOTO NO 5 SLAWI TEGAL
            {{-- <br>Tegal 52411 --}}
        </span>
        <br>
        <span style=" font-size: 14px;">Telp / Fax, 02836195328 02838195187</span>
    </div>
    <hr style="border: 1px solid;">
    @if ($cetakpdf->kategori == 'Memo Perjalanan')
        <div style="text-align: center;">
            <span style="font-weight: bold; font-size: 20px;">MEMO PERJALANAN</span>
        </div>
        <table width="100%">
            <tr>
                <td style="width:60%;">
                    <table>
                        <tr>
                            <td class="info-column">
                                <span class="info-item" style="font-size: 14px;">Tanggal</span>
                            </td>
                            <td class="info-column">
                                <span class="info-titik" style="font-size: 14px;">:</span>
                            </td>
                            <td class="info-column">
                                <span class="info-item" style="font-size: 14px;">{{ $cetakpdf->tanggal }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="info-column">
                                <span class="info-item" style="font-size: 14px;">No. Memo</span>
                            </td>
                            <td class="info-column">
                                <span class="info-titik" style="font-size: 14px;">:</span>
                            </td>
                            <td class="info-column">
                                <span class="info-item" style="font-size: 14px;">{{ $cetakpdf->kode_memo }}</span>
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="width: 70%; text-align: left;">
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 40%;">
                                <span class="info-item"
                                    style="font-size: 14px; text-align: left; display: inline-block;">No. Kabin</span>
                            </td>
                            <td style="width: 60%;">
                                <span class="info-item"
                                    style="font-size: 14px; text-align: left; display: inline-block;">:
                                    {{ $cetakpdf->no_kabin }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 40%;">
                                <span class="info-item"
                                    style="font-size: 14px; text-align: left; display: inline-block;">Km Awal</span>
                            </td>
                            <td style="width: 60%;">
                                <span class="info-item"
                                    style="font-size: 14px; text-align: left; display: inline-block;">:
                                    {{ $cetakpdf->km_awal }}</span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <hr style="border: 1px solid;">

        <table width="100%" style="border-collapse: collapse;">
            <tr>
                <td style="width:100%;">
                    <table>
                        <tr>
                            <td class="info-column">
                                <span class="info-item" style="font-size: 14px;">Kode Sopir</span>
                            </td>
                            <td class="info-column">
                                <span class="info-titik" style="font-size: 14px;">:</span>
                            </td>
                            <td class="info-column">
                                <span class="info-item" style="font-size: 14px;">{{ $cetakpdf->kode_driver }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="info-column">
                                <span class="info-item" style="font-size: 14px;">Nama Sopir</span>
                            </td>
                            <td class="info-column">
                                <span class="info-titik" style="font-size: 14px;">:</span>
                            </td>
                            <td class="info-column">
                                <span class="info-item" style="font-size: 14px;">{{ $cetakpdf->nama_driver }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="info-column">
                                <span class="info-item" style="font-size: 14px;">Rute Perjalanan</span>
                            </td>
                            <td class="info-column">
                                <span class="info-titik" style="font-size: 14px;">:</span>
                            </td>
                            <td class="info-column">
                                <span class="info-item" style="font-size: 14px;">
                                    {{ $cetakpdf->nama_rute }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="info-column">
                                <span class="info-item" style="font-size: 14px;">Saldo Deposit</span>
                            </td>
                            <td class="info-column">
                                <span class="info-titik" style="font-size: 14px;">:</span>
                            </td>
                            <td class="info-column">
                                <span class="info-item" style="font-size: 14px;">
                                    {{ number_format($cetakpdf->saldo_deposit, 0, ',', '.') }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="info-column">
                                <span class="info-item" style="font-size: 14px; color:white">.</span>
                            </td>
                            <td class="info-column">
                                <span class="info-titik" style="font-size: 14px; color:white">.</span>
                            </td>
                            <td class="info-column">
                                <span class="info-item" style="font-size: 14px; color:white">.</span>
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="width: 70%;">
                    <table style="width: 100%;" cellpadding="2" cellspacing="0">
                        <tr>
                            <td colspan="5"
                                style="text-align: left; padding-left: 0px; font-size: 14px;width: 25%;">
                                Uang
                                Jalan</td>
                            <td class="td" style="text-align: right; padding-right: 17px;; font-size: 14px;">
                                {{ number_format($cetakpdf->uang_jalan, 0, ',', '.') }}

                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" style="text-align: left; padding-left: 0px; font-size: 14px;">Biaya
                                Tambahan
                            </td>
                            <td class="td" style="text-align: right; padding: 2px; font-size: 14px;">
                                {{ number_format($cetakpdf->biaya_tambahan, 0, ',', '.') }} -</td>
                        </tr>
                        <tr>
                            <td colspan="5" style="text-align: left; padding-left: 0px; font-size: 14px;">Potongan
                                Memo
                            </td>
                            <td class="td" style="text-align: right; padding: 2px; font-size: 14px;">
                                {{ number_format($cetakpdf->potongan_memo, 0, ',', '.') }} +</td>
                        </tr>
                        <tr>
                            <td colspan="6" style="padding: 0px;">
                                <hr style="border-top: 0.1px solid black; margin: 5px 0;">
                                {{-- <span
                                    style="position: absolute; top: 50%; transform: translateY(-50%); background-color: white; padding: 0 5px; font-size: 12px;">+</span> --}}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" style="text-align: left; padding-left: 0px; font-size: 14px;">
                                jumlah
                            </td>
                            <td class="td" style="text-align: right; padding-right: 17px; font-size: 14px;">
                                {{ number_format($cetakpdf->uang_jalan + $cetakpdf->biaya_tambahan - $cetakpdf->potongan_memo, 0, ',', '.') }}
                            </td>
                        </tr>
                        {{-- <tr>
                            <td colspan="5" style="text-align: left; padding-left: 0px; font-size: 14px;">
                                Adm
                            </td>
                            <td class="td" style="text-align: right; padding-right: 17px; font-size: 14px;">
                                {{ number_format($cetakpdf->uang_jaminan, 0, ',', '.') }}
                            </td>
                        </tr> --}}
                        <tr>
                            <td colspan="5" style="text-align: left; padding-left: 0px; font-size: 14px;">
                                Deposit Sopir
                            </td>
                            <td class="td" style="text-align: right; padding: 0px; font-size: 14px;">
                                {{ number_format($cetakpdf->deposit_driver, 0, ',', '.') }} -
                            </td>
                        </tr>
                    </table>
                </td>

            </tr>
        </table>
        <hr style="border: 0.5px solid;">
        <table style="width: 100%;" cellpadding="2" cellspacing="0">
            <tr>
                <td class="td"
                    style="text-align: left; padding: 0px; font-size: 14px; white-space: nowrap; width: 50%;">
                    Ket Memo
                </td>
                <td class="td" style="text-align: center; padding-right: 10px; font-size: 14px; width: 25%;">
                    Grand Total
                </td>
                <td class="td"
                    style="text-align: right; padding-right: 17px; font-size: 14px; width: 20%; max-width: 100px; overflow: hidden; text-overflow: ellipsis;">
                    {{ number_format($cetakpdf->sub_total, 0, ',', '.') }}
                </td>
            </tr>
        </table>

        <table style="width: 100%;" cellpadding="2" cellspacing="0">
            <tr>
                <td class="td"
                    style="text-align: left; padding-right: 300px; font-size: 14px; white-space: normal; width: 60%;">
                    {{ $cetakpdf->keterangan }}
                </td>
            </tr>
        </table>
    @endif
    @if ($cetakpdf->kategori == 'Memo Borong')
        <div style="text-align: center;">
            <span style="font-weight: bold; font-size: 20px;">MEMO BORONG</span>
        </div>
        <table width="100%">
            <tr>
                <td style="width:60%;">
                    <table>
                        <tr>
                            <td class="info-column">
                                <span class="info-item" style="font-size: 14px;">No Kabin</span>
                            </td>
                            <td class="info-column">
                                <span class="info-titik" style="font-size: 14px;">:</span>
                            </td>
                            <td class="info-column">
                                <span class="info-item" style="font-size: 14px;">{{ $cetakpdf->no_kabin }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="info-column">
                                <span class="info-item" style="font-size: 14px;">Tanggal</span>
                            </td>
                            <td class="info-column">
                                <span class="info-titik" style="font-size: 14px;">:</span>
                            </td>
                            <td class="info-column">
                                <span class="info-item" style="font-size: 14px;">{{ $cetakpdf->tanggal }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="info-column">
                                <span class="info-item" style="font-size: 14px;">No. Memo</span>
                            </td>
                            <td class="info-column">
                                <span class="info-titik" style="font-size: 14px;">:</span>
                            </td>
                            <td class="info-column">
                                <span class="info-item" style="font-size: 14px;">{{ $cetakpdf->kode_memo }}</span>
                            </td>
                        </tr>
                        {{-- <tr style="color: white">
                            <td class="info-column">
                                <span class="info-item" style="font-size: 14px;">Nama Pelanggan</span>
                            </td>
                            <td class="info-column">
                                <span class="info-titik" style="font-size: 14px;">:</span>
                            </td>
                            <td class="info-column">
                                <span class="info-item"
                                    style="font-size: 14px;">{{ $cetakpdf->nama_pelanggan }}</span>
                            </td>
                        </tr> --}}
                    </table>
                </td>
                <td style="width: 70%; text-align: left;">
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 40%;">
                                <span class="info-item"
                                    style="font-size: 14px; text-align: left; display: inline-block;">Kode Sopir</span>
                            </td>
                            <td style="width: 60%;">
                                <span class="info-item"
                                    style="font-size: 14px; text-align: left; display: inline-block;">:
                                    {{ $cetakpdf->kode_driver }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 40%;">
                                <span class="info-item"
                                    style="font-size: 14px; text-align: left; display: inline-block;">Nama
                                    Sopir</span>
                            </td>
                            <td style="width: 60%;">
                                <span class="info-item"
                                    style="font-size: 14px; text-align: left; display: inline-block;">:
                                    {{ $cetakpdf->nama_driver }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 40%;">
                                <span class="info-item"
                                    style="font-size: 14px; text-align: left; display: inline-block;">No. Telp</span>
                            </td>
                            <td style="width: 60%;">
                                <span class="info-item"
                                    style="font-size: 14px; text-align: left; display: inline-block;">:
                                    {{ $cetakpdf->telp }}</span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <hr style="border: 0.5px solid;">

        <table style="width: 100%;" cellpadding="2" cellspacing="0">
            <tr>
                <td class="td" style="text-align: center; padding: 0px; font-size: 14px;">No.</td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 14px;">Nama Rute</td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 14px;">harga</td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 14px;">Qty</td>
                <td class="td" style="text-align: right; padding-right: 17px; font-size: 14px;">Total</td>
            </tr>
            <!-- Add horizontal line below this row -->
            <tr>
                <td colspan="5" style="padding: 0px;">
                    <hr style="border-top: 0.1px solid black; margin: 5px 0;">
                </td>
            </tr>
            {{-- @php
                $totalRuteSum = 0;
            @endphp --}}
            {{-- @foreach ($detail_memo as $item) --}}
            <tr>
                <td class="td" style="text-align: center; padding: 0px; font-size: 14px;">
                    1
                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 14px;">
                    {{ $cetakpdf->nama_rute }}
                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 14px;">
                    {{ number_format($cetakpdf->harga_rute, 0, ',', '.') }}
                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 14px;">
                    {{ $cetakpdf->jumlah }}
                </td>
                <td class="td" style="text-align: right; padding-right: 17px; font-size: 14px;">
                    {{ number_format($cetakpdf->totalrute, 0, ',', '.') }}
                </td>
            </tr>
            {{-- @php
                    $totalRuteSum += $item->totalrute;
                @endphp --}}
            {{-- @endforeach --}}
            <tr>
                <td colspan="5" style="padding: 0px;">
                    {{-- <hr style="border-top: 1px solid black; margin: 5px 0;"> --}}
                </td>
            </tr>
        </table>
        <table style="width: 100%; border-top: 1px solid black; margin-bottom:5px;">
            <tr>
                <td style="width: 63%; text-align: left; padding-right: 20px;">
                    <span class="info-item" style="font-size: 14px; display: block; word-wrap: break-word;">
                        {{ $cetakpdf->keterangan }}
                    </span>
                </td>

                <td style="text-align: right; padding-right: 17px;font-size: 14px;">
                    {{ number_format($cetakpdf->totalrute, 0, ',', '.') }}
                </td>
            </tr>
        </table>

        <table style="width: 100%;" cellpadding="2" cellspacing="0">
            <tr>
                <td colspan="4" style="text-align: right; padding: 0px; font-size: 14px;">PPH 2 %</td>
                <td class="td" style="text-align: right; padding: 2px; font-size: 14px;">
                    {{ number_format($cetakpdf->pphs, 0, ',', '.') }} -
                </td>
            </tr>
            <tr>
                <td colspan="4" style="padding: 0px;"></td>
                <td style="padding: 0px;">
                    <hr style="border-top: 0.1px solid black; margin: 5px 0;">
                </td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: right; padding: 0px; font-size: 14px;"></td>
                <td class="td" style="text-align: right; padding-right: 17px; font-size: 14px;">
                    {{ number_format($cetakpdf->totalrute - $cetakpdf->pphs, 0, ',', '.') }}

                </td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: right; padding: 0px; font-size: 14px;">Borong 50 %</td>
                <td class="td" style="text-align: right; padding: 0px; font-size: 14px;">
                    {{ number_format(($cetakpdf->totalrute - $cetakpdf->pphs) / 2, 0, ',', '.') }} -

                </td>
            </tr>
            <tr>
                <td colspan="4" style="padding: 0px;"></td>
                <td style="padding: 0px;">
                    <hr style="border-top: 0.1px solid black; margin: 5px 0;">
                </td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: right; padding: 0px; font-size: 14px;"></td>
                <td class="td" style="text-align: right; padding-right: 17px; font-size: 14px;">
                    {{ number_format(($cetakpdf->totalrute - $cetakpdf->pphs) / 2, 0, ',', '.') }}

                </td>
            </tr>
            {{-- <tr>
                <td colspan="4" style="text-align: right; padding: 0px; font-size: 14px;">Administrasi (1%)</td>
                <td class="td" style="text-align: right; padding-right: 17px; font-size: 14px;">
                    {{ number_format($cetakpdf->uang_jaminan, 0, ',', '.') }}

                </td>
            </tr> --}}
            <tr>
                <td colspan="4" style="text-align: right; padding-left: 115px; font-size: 14px;">Deposit Supir</td>
                <td class="td" style="text-align: right; padding: 0px; font-size: 14px;">
                    {{ number_format($cetakpdf->deposit_driver, 0, ',', '.') }} -

                </td>
            </tr>
            <!-- Add horizontal line below the subtotal row -->
        </table>
                    <hr style="border-top: 0.1px solid black; margin: 5px 0;">
        <table style="width: 100%;" cellpadding="2" cellspacing="0">
            <tr>
                <td class="td"
                    style="text-align: left; padding: 0px; font-size: 14px; white-space: nowrap; width: 60%;">
                    Saldo Deposit Sopir :
                    {{ number_format($cetakpdf->saldo_deposit, 0, ',', '.') }}
                </td>
                <td class="td" style="text-align: left; padding-right: 0px; font-size: 14px; width: 0%;">
                    Grand Total
                </td>
                <td class="td" style="text-align: right; padding-right: 17px; font-size: 14px;">
                    {{ number_format(($cetakpdf->totalrute - $cetakpdf->pphs) / 2 - $cetakpdf->uang_jaminan - $cetakpdf->deposit_driver, 0, ',', '.') }}
                </td>
            </tr>
        </table>
    @endif
    @if (!($cetakpdf->kategori == 'Memo Perjalanan' || $cetakpdf->kategori == 'Memo Borong'))
        <div style="text-align: center;">
            <span style="font-weight: bold; font-size: 20px;">MEMO TAMBAHAN</span>
        </div>
        <table width="100%">
            <tr>
                <td style="width:60%;">
                    <table>
                        <tr>
                            <td class="info-column">
                                <span class="info-item" style="font-size: 14px;">Tanggal</span>
                            </td>
                            <td class="info-column">
                                <span class="info-titik" style="font-size: 14px;">:</span>
                            </td>
                            <td class="info-column">
                                <span class="info-item" style="font-size: 14px;">{{ $cetakpdf->tanggal_awal }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="info-column">
                                <span class="info-item" style="font-size: 14px;">No. Memo</span>
                            </td>
                            <td class="info-column">
                                <span class="info-titik" style="font-size: 14px;">:</span>
                            </td>
                            <td class="info-column">
                                <span class="info-item"
                                    style="font-size: 14px;">{{ $cetakpdf->kode_tambahan }}</span>
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="width: 70%; text-align: left;">
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 40%;">
                                <span class="info-item"
                                    style="font-size: 14px; text-align: left; display: inline-block;">No. Kabin</span>
                            </td>
                            <td style="width: 60%;">
                                <span class="info-item"
                                    style="font-size: 14px; text-align: left; display: inline-block;">:
                                    {{ $cetakpdf->no_kabin }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 40%;">
                                <span class="info-item"
                                    style="font-size: 14px; text-align: left; display: inline-block;">Nama Sopir</span>
                            </td>
                            <td style="width: 60%;">
                                <span class="info-item"
                                    style="font-size: 14px; text-align: left; display: inline-block;">:
                                    {{ $cetakpdf->nama_driver }}</span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <hr style="border: 1px solid;">

        <table style="width: 100%;" cellpadding="2" cellspacing="0">
            <tr>
                <td class="td" style="text-align: center; padding: 0px; font-size: 14px;">No.</td>
                <td class="td" style="text-align: left; padding: 0px; font-size: 14px;">Keterangan</td>
                <td class="td" style="text-align: right; padding-right: 17px; font-size: 14px;">Total</td>
            </tr>
            <!-- Add horizontal line below this row -->
            <tr>
                <td colspan="5" style="padding: 0px;">
                    <hr style="border-top: 1px solid black; margin: 5px 0;">
                </td>
            </tr>
            @php
                $totalRuteSum = 0;
            @endphp
            @foreach ($detail_memo as $item)
                <tr>
                    <td class="td" style="text-align: center; padding: 0px; font-size: 14px;">
                        {{ $loop->iteration }}
                    </td>
                    <td class="td" style="text-align: left; padding: 0px; font-size: 14px;">
                        {{ $item->keterangan_tambahan }}
                    </td>
                    <td class="td" style="text-align: right; padding-right: 17px; font-size: 14px;">
                        {{ number_format($item->nominal_tambahan, 0, ',', '.') }}
                    </td>
                </tr>
                @php
                    $totalRuteSum += $item->nominal_tambahan;
                @endphp
            @endforeach
            <tr>
                <td colspan="5" style="padding: 0px;">
                </td>
            </tr>
        </table>
        <table style="width: 100%; border-top: 1px solid black; margin-bottom:5px;">
            <tr>
                <td style="text-align: right; padding-right: 17px;font-size: 14px;">
                    {{ number_format($totalRuteSum, 0, ',', '.') }}
                </td>
            </tr>
        </table>

    @endif
    <br>
    <br>
    <br>

    <table class="tdd" cellpadding="10" cellspacing="0" style="margin: 0 auto;">
        <tr>
            <td style="text-align: center;">
                <table style="margin: 0 auto;">
                    <tr style="text-align: center;">
                        <td class="label">
                            {{ $cetakpdf->nama_driver }}
                        </td>
                    </tr>
                    <tr>
                        <td class="separator" colspan="2"><span></span></td>
                    </tr>
                    <tr style="text-align: center;">
                        <td class="label">Sopir</td>
                    </tr>
                </table>
            </td>
            <td style="text-align: center;">
                <table style="margin: 0 auto;">
                    <tr style="text-align: center;">
                        <td class="label">
                            DJOHAN WAHYUDI
                        </td>
                    </tr>
                    <tr>
                        <td class="separator" colspan="2"><span></span></td>
                    </tr>
                    <tr style="text-align: center;">
                        <td class="label">Finance</td>
                    </tr>
                </table>
            </td>
            <td style="text-align: center;">
                <table style="margin: 0 auto;">
                    <tr style="text-align: center;">
                        <td class="label">
                            {{-- @if ($cetakpdf->user)
                                {{ $cetakpdf->user->karyawan->nama_lengkap }}
                            @else
                                user tidak ada
                            @endif --}}
                            {{ auth()->user()->karyawan->nama_lengkap }}
                        </td>
                    </tr>
                    <tr>
                        <td class="separator" colspan="2"><span></span></td>
                    </tr>
                    <tr style="text-align: center;">
                        <td class="label">Admin</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <br>
</body>

</html>
