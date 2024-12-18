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
            font-family: Arial, sans-serif;
            color: black;
            margin-top: 20px;
            margin-left: 20px;
            margin-right: 80px;
        }

        .container {
            display: flex;
            justify-content: space-between;
            margin-top: 7rem;
        }

        .info-column {
            padding-left: 5px;
        }

        .info-titik {
            /* vertical-align: top; */
        }

        /* tanda tangan  */

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .separator {
            padding-top: 7px;
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
        <span style="font-weight: bold; font-size: 17px;">PT JAVA LINE LOGISTICS</span>
        <br>
        <span style=" font-size: 11px;">JL. HOS COKRO AMINOTO NO 5 SLAWI TEGAL
            {{-- <br>Tegal 52411 --}}
        </span>
        <br>
        <span style=" font-size: 11px;">Telp / Fax, 02836195328 02838195187</span>
    </div>
    <hr style="border: 0.1px solid;">
    @if ($cetakpdf->kategori == 'Memo Perjalanan')
        <div style="text-align: center;">
            <span style="font-weight: bold; font-size: 16px;">MEMO PERJALANAN</span>
        </div>
        <table width="100%">
            <tr>
                <td style="width:70%;">
                    <table>
                        <tr>
                            <td class="info-column">
                                <span class="info-item" style="font-size: 13px;">Tanggal</span>
                            </td>
                            <td class="info-column">
                                <span class="info-titik" style="font-size: 13px;">:</span>
                            </td>
                            <td class="info-column">
                                <span class="info-item"
                                    style="font-size: 13px;">{{ \Carbon\Carbon::parse($cetakpdf->tanggal)->locale('id')->isoFormat('D MMMM YYYY') }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="info-column">
                                <span class="info-item" style="font-size: 13px;">No. Memo</span>
                            </td>
                            <td class="info-column">
                                <span class="info-titik" style="font-size: 13px;">:</span>
                            </td>
                            <td class="info-column">
                                <span class="info-item" style="font-size: 13px;">{{ $cetakpdf->kode_memo }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="info-column">
                                <span class="info-item" style="font-size: 13px;">No. Kabin</span>
                            </td>
                            <td class="info-column">
                                <span class="info-titik" style="font-size: 13px;">:</span>
                            </td>
                            <td class="info-column">
                                <span class="info-item" style="font-size: 13px;">{{ $cetakpdf->no_kabin }}</span>
                            </td>
                        </tr>
                    </table>
                </td>

                <td style="width: 50%; text-align: left;">
                    <table style="width: 100%; margin-top:4px">
                        <tr>
                            <td style="width: 40%;">
                                <span class="info-item"
                                    style="font-size: 13px; text-align: left; display: inline-block;">Nama bank</span>
                            </td>
                            <td style="width: 60%;">
                                <span class="info-item"
                                    style="font-size: 13px; text-align: left; display: inline-block;">:
                                    @if ($cetakpdf->user->karyawan->nama_bank != null)
                                        {{ $cetakpdf->user->karyawan->nama_bank }}
                                    @else
                                    @endif
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 40%;">
                                <span class="info-item"
                                    style="font-size: 13px; text-align: left; display: inline-block;">No Rekening</span>
                            </td>
                            <td style="width: 60%;">
                                <span class="info-item"
                                    style="font-size: 13px; text-align: left; display: inline-block;">:
                                    @if ($cetakpdf->user->karyawan->norek != null)
                                        {{ $cetakpdf->user->karyawan->norek }}
                                    @else
                                    @endif
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 40%;">
                                <span class="info-item"
                                    style="font-size: 13px; text-align: left; display: inline-block;">Atas Nama</span>
                            </td>
                            <td style="width: 60%;">
                                <span class="info-item"
                                    style="font-size: 13px; text-align: left; display: inline-block;">:
                                    @if ($cetakpdf->user->karyawan->atas_nama != null)
                                        {{ $cetakpdf->user->karyawan->atas_nama }}
                                    @else
                                    @endif
                                </span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <hr style="border: 0.5px solid;">

        <table width="100%" style="border-collapse: collapse;">
            <tr>
                <td style="width:100%;">
                    <table>
                        <tr>
                            <td class="info-column">
                                <span class="info-item" style="font-size: 13px;">Kode Sopir</span>
                            </td>
                            <td class="info-column">
                                <span class="info-titik" style="font-size: 13px;">:</span>
                            </td>
                            <td class="info-column">
                                <span class="info-item" style="font-size: 13px;">{{ $cetakpdf->kode_driver }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="info-column">
                                <span class="info-item" style="font-size: 13px;">Nama Sopir</span>
                            </td>
                            <td class="info-column">
                                <span class="info-titik" style="font-size: 13px;">:</span>
                            </td>
                            <td class="info-column">
                                <span class="info-item" style="font-size: 13px;">{{ $cetakpdf->nama_driver }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="info-column">
                                <span class="info-item" style="font-size: 13px;">Rute Perjalanan</span>
                            </td>
                            <td class="info-column">
                                <span class="info-titik" style="font-size: 13px;">:</span>
                            </td>
                            <td class="info-column">
                                <span class="info-item" style="font-size: 13px;">
                                    {{ $cetakpdf->nama_rute }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="info-column">
                                <span class="info-item" style="font-size: 13px;">Saldo Deposit</span>
                            </td>
                            <td class="info-column">
                                <span class="info-titik" style="font-size: 13px;">:</span>
                            </td>
                            <td class="info-column">
                                <span class="info-item" style="font-size: 13px;">
                                    {{ number_format($cetakpdf->saldo_deposit, 2, ',', '.') }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <table style="margin-top: 15px">
                                <tr>
                                    <td style="text-align: left;font-size: 13px;">No
                                    </td>
                                    <td style="text-align: left;font-size: 13px;">Kode Nota Bon
                                    </td>
                                    <td style="text-align:
                                right;font-size: 13px;">
                                        Nominal</td>
                                </tr>
                                <tbody>
                                    @foreach ($detail_nota as $item)
                                        <td style="text-align: left;font-size: 13px;">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td style="text-align: left;font-size: 13px;">
                                            {{ $item->kode_nota }}</td>
                                        <td style="text-align:
                                right;font-size: 13px;">
                                            {{ number_format($item->nominal_nota, 2, ',', '.') }}
                                        </td>
                                    @endforeach
                                </tbody>
                            </table>
                        </tr>
                    </table>
                </td>
                <td style="width: 70%;">
                    <table style="width: 100%;" cellpadding="2" cellspacing="0">
                        <tr>
                            <td colspan="5"
                                style="text-align: left; padding-left: 0px; font-size: 13px;width: 25%;">
                                Uang
                                Jalan</td>
                            <td class="td" style="text-align: right; padding-right: 11px;; font-size: 13px;">
                                {{ number_format($cetakpdf->uang_jalan, 2, ',', '.') }}

                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" style="text-align: left; padding-left: 0px; font-size: 13px;">
                                Biaya
                                Tambahan
                            </td>
                            <td class="td" style="text-align: right; padding-right: 3px; font-size: 13px;">
                                {{ number_format($cetakpdf->biaya_tambahan, 2, ',', '.') }} -</td>
                        </tr>
                        <tr>
                            <td colspan="5" style="text-align: left; padding-left: 0px; font-size: 13px;">
                                Potongan
                                Memo
                            </td>
                            <td class="td" style="text-align: right; padding-right: 0px; font-size: 13px;">
                                {{ number_format($cetakpdf->potongan_memo, 2, ',', '.') }} +</td>
                        </tr>
                        <tr>
                            <td colspan="6" style="padding: 0px;">
                                <hr style="border-top: 0.1px solid black; margin: 5px 0;">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" style="text-align: left; padding-left: 0px; font-size: 13px;">
                                jumlah
                            </td>
                            <td class="td" style="text-align: right; padding-right: 11px; font-size: 13px;">
                                {{ number_format($cetakpdf->uang_jalan + $cetakpdf->biaya_tambahan - $cetakpdf->potongan_memo, 2, ',', '.') }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" style="text-align: left; padding-left: 0px; font-size: 13px;">
                                Adm
                            </td>
                            <td class="td" style="text-align: right; padding-right: 11px; font-size: 13px;">
                                {{ number_format($cetakpdf->uang_jaminan, 2, ',', '.') }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" style="text-align: left; padding-left: 0px; font-size: 13px;">
                                Deposit Sopir
                            </td>
                            <td class="td" style="text-align: right; padding-right: 3.5px; font-size: 13px;">
                                {{ number_format($cetakpdf->deposit_driver, 2, ',', '.') }} -
                            </td>
                        </tr>
                        @if ($cetakpdf->nota_bon == 0)
                        @else
                            <tr>
                                <td colspan="5" style="text-align: left; padding-left: 0px; font-size: 13px;">
                                    Nota Bon Sopir
                                </td>
                                <td class="td" style="text-align: right; padding-right: 3.5px; font-size: 13px;">
                                    {{ number_format($cetakpdf->nota_bon, 2, ',', '.') }} -
                                </td>
                            </tr>
                        @endif

                    </table>
                </td>

            </tr>
        </table>
        <hr style="border: 0.5px solid;">
        <table style="width: 100%;" cellpadding="2" cellspacing="0">
            <tr>
                <td class="td"
                    style="text-align: left; padding: 0px; font-size: 13px; white-space: nowrap; width: 50%;">
                    Ket Memo
                </td>
                <td class="td" style="text-align: center; padding-right: 10px; font-size: 13px; width: 25%;">
                    Sisa Transfer
                </td>
                <td class="td"
                    style="text-align: right; padding-right: 13px; font-size: 13px; width: 20%; max-width: 100px; overflow: hidden; text-overflow: ellipsis;">
                    {{ number_format($cetakpdf->sub_total, 2, ',', '.') }}
                </td>
            </tr>
        </table>

        <table style="width: 100%;" cellpadding="2" cellspacing="0">
            <tr>
                <td class="td"
                    style="text-align: left; padding-right: 330px; font-size: 13px; white-space: normal; width: 60%;">
                    {{ $cetakpdf->keterangan }}
                </td>
            </tr>
        </table>
        <table class="tdd" cellpadding="10" cellspacing="0" style="margin: 0 auto;">
            <tr>
                <td style="text-align: center;">
                    <table style="margin: 0 auto;">
                        <tr style="text-align: center;">
                            <td style="font-size: 12px;" class="label">
                                {{ $cetakpdf->nama_driver }}
                            </td>
                        </tr>
                        <tr>
                            <td class="separator" colspan="2"><span></span></td>
                        </tr>
                        <tr style="text-align: center;">
                            <td style="font-size: 12px;" class="label">Sopir</td>
                        </tr>
                    </table>
                </td>
                <td style="text-align: center;">
                    <table style="margin: 0 auto;">
                        <tr style="text-align: center;">
                            <td style="font-size: 12px;" class="label">
                                DJOHAN WAHYUDI
                            </td>
                        </tr>
                        <tr>
                            <td class="separator" colspan="2"><span></span></td>
                        </tr>
                        <tr style="text-align: center;">
                            <td style="font-size: 12px;" class="label">Finance</td>
                        </tr>
                    </table>
                </td>
                <td style="text-align: center;">
                    <table style="margin: 0 auto;">
                        <tr style="text-align: center;">
                            <td style="font-size: 12px;" class="label">
                                {{-- @if ($cetakpdf->user)
                                {{ $cetakpdf->user->karyawan->nama_lengkap }}
                            @else
                                user tidak ada
                            @endif --}}
                                {{ $cetakpdf->admin }}
                            </td>
                        </tr>
                        <tr>
                            <td class="separator" colspan="2"><span></span></td>
                        </tr>
                        <tr style="text-align: center;">
                            <td style="font-size: 12px;" class="label">Admin</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    @endif
    @if ($cetakpdf->kategori == 'Memo Borong')
        <div style="text-align: center;">
            <span style="font-weight: bold; font-size: 15px;">MEMO BORONG</span>
        </div>
        <table width="100%">
            <tr>
                <td style="width: 60%; text-align: left;">
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 40%;">
                                <span class="info-item"
                                    style="font-size: 13px; text-align: left; display: inline-block;">No Kabin</span>
                            </td>
                            <td style="width: 60%;">
                                <span class="info-item"
                                    style="font-size: 13px; text-align: left; display: inline-block;">:
                                    {{ $cetakpdf->no_kabin }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 40%;">
                                <span class="info-item"
                                    style="font-size: 13px; text-align: left; display: inline-block;">Tanggal</span>
                            </td>
                            <td style="width: 60%;">
                                <span class="info-item"
                                    style="font-size: 13px; text-align: left; display: inline-block;">:
                                    {{ \Carbon\Carbon::parse($cetakpdf->tanggal)->locale('id')->isoFormat('D MMMM YYYY') }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 40%;">
                                <span class="info-item"
                                    style="font-size: 13px; text-align: left; display: inline-block;">No. Memo</span>
                            </td>
                            <td style="width: 60%;">
                                <span class="info-item"
                                    style="font-size: 13px; text-align: left; display: inline-block;">:
                                    {{ $cetakpdf->kode_memo }}</span>
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="width: 70%; text-align: left;">
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 40%;">
                                <span class="info-item"
                                    style="font-size: 13px; text-align: left; display: inline-block;">Kode Sopir</span>
                            </td>
                            <td style="width: 60%;">
                                <span class="info-item"
                                    style="font-size: 13px; text-align: left; display: inline-block;">:
                                    {{ $cetakpdf->kode_driver }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 40%;">
                                <span class="info-item"
                                    style="font-size: 13px; text-align: left; display: inline-block;">Nama
                                    Sopir</span>
                            </td>
                            <td style="width: 60%;">
                                <span class="info-item"
                                    style="font-size: 13px; text-align: left; display: inline-block;">:
                                    {{ substr($cetakpdf->nama_driver, 0, 14) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 40%;">
                                <span class="info-item"
                                    style="font-size: 13px; text-align: left; display: inline-block;">No. Telp</span>
                            </td>
                            <td style="width: 60%;">
                                <span class="info-item"
                                    style="font-size: 13px; text-align: left; display: inline-block;">:
                                    {{ $cetakpdf->telp }}</span>
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="width: 70%; text-align: left;">
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 40%;">
                                <span class="info-item"
                                    style="font-size: 13px; text-align: left; display: inline-block;">Nama Bank</span>
                            </td>
                            <td style="width: 60%;">
                                <span class="info-item"
                                    style="font-size: 13px; text-align: left; display: inline-block;">:
                                    @if ($cetakpdf->user->karyawan->nama_bank != null)
                                        {{ $cetakpdf->user->karyawan->nama_bank }}
                                    @else
                                    @endif
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 40%;">
                                <span class="info-item"
                                    style="font-size: 13px; text-align: left; display: inline-block;">No
                                    Rekening</span>
                            </td>
                            <td style="width: 60%;">
                                <span class="info-item"
                                    style="font-size: 13px; text-align: left; display: inline-block;">:
                                    @if ($cetakpdf->user->karyawan->norek != null)
                                        {{ $cetakpdf->user->karyawan->norek }}
                                    @else
                                    @endif
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 40%;">
                                <span class="info-item"
                                    style="font-size: 13px; text-align: left; display: inline-block;">Atas Nama</span>
                            </td>
                            <td style="width: 60%;">
                                <span class="info-item"
                                    style="font-size: 13px; text-align: left; display: inline-block;">:
                                    @if ($cetakpdf->user->karyawan->atas_nama != null)
                                        {{ substr($cetakpdf->user->karyawan->atas_nama, 0, 14) }}
                                    @else
                                    @endif
                                </span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <hr style="border: 0.1px solid;">

        <table style="width: 100%;" cellpadding="0" cellspacing="0">
            <tr>
                <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">No.</td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">Nama Rute</td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">harga</td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">Qty</td>
                <td class="td" style="text-align: right; padding-right: 17px; font-size: 13px;">Total</td>
            </tr>
            <tr>
                <td colspan="5" style="padding: 0px;">
                    <hr style="border-top: 0.1px solid black; margin: 0.5px 0;">
                </td>
            </tr>
            {{-- @php
                $totalRuteSum = 0;
            @endphp --}}
            {{-- @foreach ($detail_memo as $item) --}}
            <tr>
                <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">
                    1
                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">
                    {{ $cetakpdf->nama_rute }}
                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">
                    {{ number_format($cetakpdf->harga_rute, 2, ',', '.') }}
                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">
                    {{ $cetakpdf->jumlah }}
                </td>
                <td class="td" style="text-align: right; padding-right: 17px; font-size: 13px;">
                    {{ number_format($cetakpdf->totalrute, 2, ',', '.') }}
                </td>
            </tr>
        </table>
        <table style="width: 100%; border-top: 1px solid black; margin-bottom:0.1px;">
            <tr>
                <td style="width: 63%; text-align: left; padding-right: 20px;">
                    <span class="info-item" style="font-size: 13px; display: block; word-wrap: break-word;">
                        {{ $cetakpdf->keterangan }}
                    </span>
                </td>

                <td style="text-align: right; padding-right: 17px;font-size: 13px;">
                    {{ number_format($cetakpdf->totalrute, 2, ',', '.') }}
                </td>
            </tr>
        </table>

        <table style="width: 100%; padding-top:0px" cellpadding="1" cellspacing="0">
            <tr>
                <td>
                    <table>
                        <tr>
                            <td style="text-align: left; padding-left: 17px;font-size: 13px;">No
                            </td>
                            <td style="text-align: left; padding-left: 17px;font-size: 13px;">Kode Nota Bon</td>
                            <td
                                style="text-align:
                                right; padding-right: 17px;font-size: 13px;">
                                Nominal</td>
                        </tr>
                        <tbody>
                            @foreach ($detail_nota as $item)
                                <td style="text-align: left; padding-left: 17px;font-size: 13px;">
                                    {{ $loop->iteration }}
                                </td>
                                <td style="text-align: left; padding-left: 17px;font-size: 13px;">
                                    {{ $item->kode_nota }}</td>
                                <td
                                    style="text-align:
                                right; padding-right: 17px;font-size: 13px;">
                                    {{ number_format($item->nominal_nota, 2, ',', '.') }}
                                </td>
                            @endforeach
                        </tbody>
                    </table>
                </td>
                <td>
                    <table>
                        <tr>
                            <td colspan="4" style="text-align: right; padding: 0px; font-size: 13px;">PPH 2 %</td>
                            <td class="td" style="text-align: right; padding-right: 9px; font-size: 13px;">
                                {{ number_format($cetakpdf->pphs, 2, ',', '.') }} -
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" style="padding: 0px;"></td>
                            <td style="padding: 0px;">
                                <hr style="border-top: 0.1px solid black; margin: 1px 0;">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" style="text-align: right; padding: 0px; font-size: 13px;"></td>
                            <td class="td" style="text-align: right; padding-right: 17px; font-size: 13px;">
                                {{ number_format($cetakpdf->totalrute - $cetakpdf->pphs, 2, ',', '.') }}

                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" style="text-align: right; padding: 0px; font-size: 13px;">Borong 50 %
                            </td>
                            <td class="td" style="text-align: right; padding-right: 9px; font-size: 13px;">
                                {{ number_format(($cetakpdf->totalrute - $cetakpdf->pphs) / 2, 2, ',', '.') }} -
                            </td>
                        </tr>
                        @if ($cetakpdf->potongan_memo == 0)
                            <tr>
                                <td colspan="4" style="text-align: right; padding: 0px; font-size: 13px;">Biaya
                                    Tambahan
                                </td>
                                <td class="td" style="text-align: right; padding-right: 6px; font-size: 13px;">
                                    {{ number_format($cetakpdf->biaya_tambahan, 2, ',', '.') }} +
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td colspan="4" style="text-align: right; padding: 0px; font-size: 13px;">Potongan
                                    Memo
                                </td>
                                <td class="td" style="text-align: right; padding-right: 6px; font-size: 13px;">
                                    {{ number_format($cetakpdf->potongan_memo, 2, ',', '.') }} +
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <td colspan="4" style="padding: 0px;"></td>
                            <td style="padding: 0px;">
                                <hr style="border-top: 0.1px solid black; margin: 1px 0;">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" style="text-align: right; padding: 0px; font-size: 13px;">Total Borong
                            </td>
                            <td class="td" style="text-align: right; padding-right: 17px; font-size: 13px;">
                                {{ number_format(($cetakpdf->totalrute - $cetakpdf->pphs) / 2 + $cetakpdf->biaya_tambahan, 2, ',', '.') }}

                            </td>
                        </tr>
                        @if ($cetakpdf->nota_bons == 0)
                            <tr>
                                <td colspan="4" style="text-align: right; padding-left: 115px; font-size: 13px;">
                                    Nota
                                    Bon
                                    Supir
                                </td>
                                <td class="td" style="text-align: right; padding-right: 9px; font-size: 13px;">
                                    0.00 -

                                </td>
                            </tr>
                        @else
                            <tr>
                                <td colspan="4" style="text-align: right; padding-left: 115px; font-size: 13px;">
                                    Nota
                                    Bon
                                    Supir
                                </td>
                                <td class="td" style="text-align: right; padding-right: 9px; font-size: 13px;">
                                    {{ number_format($cetakpdf->nota_bons, 2, ',', '.') }} -

                                </td>
                            </tr>
                        @endif
                        <tr>
                            <td colspan="4" style="padding: 0px;"></td>
                            <td style="padding: 0px;">
                                <hr style="border-top: 0.1px solid black; margin: 1px 0;">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" style="text-align: right; padding: 0px; font-size: 13px;">Grand Total
                            </td>
                            <td class="td" style="text-align: right; padding-right: 17px; font-size: 13px;">
                                {{ number_format($cetakpdf->hasil_jumlah, 2, ',', '.') }}

                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" style="text-align: right; padding: 0px; font-size: 13px;">Administrasi
                                (1%)
                            </td>
                            <td class="td" style="text-align: right; padding-right: 17px; font-size: 13px;">
                                {{ number_format($cetakpdf->uang_jaminans, 2, ',', '.') }}

                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" style="text-align: right; padding-left: 115px; font-size: 13px;">
                                Deposit
                                Supir
                            </td>
                            <td class="td" style="text-align: right; padding-right: 9px; font-size: 13px;">
                                {{ number_format($cetakpdf->deposit_driver, 2, ',', '.') }} -

                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <hr style="border-top: 0.1px solid black; margin: 0.1px 0;">
        <table style="width: 100%;" cellpadding="2" cellspacing="0">
            <tr>
                <td class="td"
                    style="text-align: left; padding: 0px; font-size: 13px; white-space: nowrap; width: 60%;">
                    Saldo Deposit Sopir :
                    {{ number_format($cetakpdf->saldo_deposit, 2, ',', '.') }}
                </td>
                <td class="td" style="text-align: left; padding-right: 0px; font-size: 13px; width: 0%;">
                    Sisa Transfer
                </td>
                <td class="td" style="text-align: right; padding-right: 17px; font-size: 13px;">
                    {{ number_format($cetakpdf->sub_total, 2, ',', '.') }}
                </td>
            </tr>
        </table>
        {{-- <br> --}}
        <table class="tdd" cellpadding="10" cellspacing="0" style="margin: 0 auto; margin-top:5px">
            <tr>
                <td style="text-align: center;">
                    <table style="margin: 0 auto;">
                        <tr style="text-align: center;">
                            <td style="font-size: 12px;" class="label">
                                {{ $cetakpdf->nama_driver }}
                            </td>
                        </tr>
                        <tr>
                            <td class="separator" colspan="2"><span></span></td>
                        </tr>
                        <tr style="text-align: center;">
                            <td style="font-size: 12px;" class="label">Sopir</td>
                        </tr>
                    </table>
                </td>
                <td style="text-align: center;">
                    <table style="margin: 0 auto;">
                        <tr style="text-align: center;">
                            <td style="font-size: 12px;" class="label">
                                DJOHAN WAHYUDI
                            </td>
                        </tr>
                        <tr>
                            <td class="separator" colspan="2"><span></span></td>
                        </tr>
                        <tr style="text-align: center;">
                            <td style="font-size: 12px;" class="label">Finance</td>
                        </tr>
                    </table>
                </td>
                <td style="text-align: center;">
                    <table style="margin: 0 auto;">
                        <tr style="text-align: center;">
                            <td style="font-size: 12px;" class="label">
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
                            <td style="font-size: 12px;" class="label">Admin</td>
                        </tr>
                    </table>
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
                                <span class="info-item" style="font-size: 13px;">Tanggal</span>
                            </td>
                            <td class="info-column">
                                <span class="info-titik" style="font-size: 13px;">:</span>
                            </td>
                            <td class="info-column">
                                <span class="info-item" style="font-size: 13px;">{{ $cetakpdf->tanggal_awal }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="info-column">
                                <span class="info-item" style="font-size: 13px;">No. Memo</span>
                            </td>
                            <td class="info-column">
                                <span class="info-titik" style="font-size: 13px;">:</span>
                            </td>
                            <td class="info-column">
                                <span class="info-item"
                                    style="font-size: 13px;">{{ $cetakpdf->kode_tambahan }}</span>
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="width: 70%; text-align: left;">
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 40%;">
                                <span class="info-item"
                                    style="font-size: 13px; text-align: left; display: inline-block;">No. Kabin</span>
                            </td>
                            <td style="width: 60%;">
                                <span class="info-item"
                                    style="font-size: 13px; text-align: left; display: inline-block;">:
                                    {{ $cetakpdf->no_kabin }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 40%;">
                                <span class="info-item"
                                    style="font-size: 13px; text-align: left; display: inline-block;">Nama Sopir</span>
                            </td>
                            <td style="width: 60%;">
                                <span class="info-item"
                                    style="font-size: 13px; text-align: left; display: inline-block;">:
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
                <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">No.</td>
                <td class="td" style="text-align: left; padding: 0px; font-size: 13px;">Keterangan</td>
                <td class="td" style="text-align: left; padding: 0px; font-size: 13px;">Qty</td>
                <td class="td" style="text-align: left; padding: 0px; font-size: 13px;">Satuan</td>
                <td class="td" style="text-align: right; padding: 0px; font-size: 13px;">Harga</td>
                <td class="td" style="text-align: right; padding-right: 17px; font-size: 13px;">Total</td>
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
                    <td class="td" style="text-align: center; padding: 0px; font-size: 13px;">
                        {{ $loop->iteration }}
                    </td>
                    <td class="td" style="text-align: left; padding: 0px; font-size: 13px;">
                        {{ $item->keterangan_tambahan }}
                    </td>
                    <td class="td" style="text-align: left; padding: 0px; font-size: 13px;">
                        {{ $item->qty }}
                    </td>
                    <td class="td" style="text-align: left; padding: 0px; font-size: 13px;">
                        {{ $item->satuans }}
                    </td>
                    <td class="td" style="text-align: left; padding: 0px; font-size: 13px;">
                        {{ number_format($item->hargasatuan, 2, ',', '.') }}
                    </td>
                    <td class="td" style="text-align: right; padding-right: 17px; font-size: 13px;">
                        {{ number_format($item->nominal_tambahan, 2, ',', '.') }}
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
                <td style="text-align: right; padding-right: 17px;font-size: 13px;">
                    {{ number_format($totalRuteSum, 2, ',', '.') }}
                </td>
            </tr>
        </table>
    @endif

    <div style="text-align: right; font-size:11px; margin-top:0px">
        <span style="font-style: italic;">Printed Date {{ \Carbon\Carbon::now()->format('Y-m-d H:i:s') }}</span>
    </div>

</body>

</html>
