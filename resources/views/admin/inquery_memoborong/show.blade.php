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
        <span style="font-weight: bold; font-size: 25px;">PT JAVA LINE LOGISTICS</span>
        <br>
        <span style=" font-size: 15px;">JL. HOS COKRO AMINOTO NO 5 SLAWI TEGAL
            {{-- <br>Tegal 52411 --}}
        </span>
        <br>
        <span style=" font-size: 15px;">Telp / Fax, 02836195328 02838195187</span>
    </div>
    <hr style="border: 1px solid;">
    @if ($cetakpdf->kategori == 'Memo Borong')
        <div style="text-align: center;">
            <span style="font-weight: bold; font-size: 20px;">MEMO BORONG</span>
        </div>
        <table width="100%">
            <tr>

                <td style="width: 40%; text-align: left;">
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 40%;">
                                <span class="info-item"
                                    style="font-size: 15px; text-align: left; display: inline-block;">No Kabin</span>
                            </td>
                            <td style="width: 60%;">
                                <span class="info-item"
                                    style="font-size: 15px; text-align: left; display: inline-block;">:
                                    {{ $cetakpdf->no_kabin }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 40%;">
                                <span class="info-item"
                                    style="font-size: 15px; text-align: left; display: inline-block;">Tanggal</span>
                            </td>
                            <td style="width: 60%;">
                                <span class="info-item"
                                    style="font-size: 15px; text-align: left; display: inline-block;">:
                                    {{ \Carbon\Carbon::parse($cetakpdf->tanggal)->locale('id')->isoFormat('D MMMM YYYY') }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 40%;">
                                <span class="info-item"
                                    style="font-size: 15px; text-align: left; display: inline-block;">No. Memo</span>
                            </td>
                            <td style="width: 60%;">
                                <span class="info-item"
                                    style="font-size: 15px; text-align: left; display: inline-block;">:
                                    {{ $cetakpdf->kode_memo }}</span>
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="width: 40%; text-align: left;">
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 40%;">
                                <span class="info-item"
                                    style="font-size: 15px; text-align: left; display: inline-block;">Kode Sopir</span>
                            </td>
                            <td style="width: 60%;">
                                <span class="info-item"
                                    style="font-size: 15px; text-align: left; display: inline-block;">:
                                    {{ $cetakpdf->kode_driver }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 40%;">
                                <span class="info-item"
                                    style="font-size: 15px; text-align: left; display: inline-block;">Nama
                                    Sopir</span>
                            </td>
                            <td style="width: 60%;">
                                <span class="info-item"
                                    style="font-size: 15px; text-align: left; display: inline-block;">:
                                    {{ $cetakpdf->nama_driver }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 40%;">
                                <span class="info-item"
                                    style="font-size: 15px; text-align: left; display: inline-block;">No. Telp</span>
                            </td>
                            <td style="width: 60%;">
                                <span class="info-item"
                                    style="font-size: 15px; text-align: left; display: inline-block;">:
                                    {{ $cetakpdf->telp }}</span>
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="width: 40%; text-align: left;">
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 40%;">
                                <span class="info-item"
                                    style="font-size: 15px; text-align: left; display: inline-block;">Nama Bank</span>
                            </td>
                            <td style="width: 60%;">
                                <span class="info-item"
                                    style="font-size: 15px; text-align: left; display: inline-block;">:
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
                                    style="font-size: 15px; text-align: left; display: inline-block;">No
                                    Rekening</span>
                            </td>
                            <td style="width: 60%;">
                                <span class="info-item"
                                    style="font-size: 15px; text-align: left; display: inline-block;">:
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
                                    style="font-size: 15px; text-align: left; display: inline-block;">Atas Nama</span>
                            </td>
                            <td style="width: 60%;">
                                <span class="info-item"
                                    style="font-size: 15px; text-align: left; display: inline-block;">:
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
        <hr style="border: 1px solid;">

        <table style="width: 100%;" cellpadding="2" cellspacing="0">
            <tr>
                <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">No.</td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">Kode Rute</td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">Nama Rute</td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">harga</td>
                <td class="td" style="text-align: right; padding: 0px; font-size: 15px;">Qty</td>
                <td class="td" style="text-align: right; padding-right: 23px; font-size: 15px;">Total</td>
            </tr>
            <!-- Add horizontal line below this row -->
            <tr>
                <td colspan="6" style="padding: 0px;">
                    <hr style="border-top: 1px solid black; margin: 5px 0;">
                </td>
            </tr>
            @php
                $totalRuteSum = 0;
            @endphp
            {{-- @foreach ($detail_memo as $item) --}}
            <tr>
                <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">
                    1
                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">
                    {{ $cetakpdf->kode_rute }}
                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">
                    {{ $cetakpdf->nama_rute }}</td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">
                    {{ number_format($cetakpdf->harga_rute, 2, ',', '.') }}
                </td>
                <td class="td" style="text-align: right; padding: 2px; font-size: 15px;">
                    {{ $cetakpdf->jumlah }}
                </td>
                <td class="td" style="text-align: right; padding-right: 23px; font-size: 15px;">
                    {{ number_format($cetakpdf->totalrute, 2, ',', '.') }}
                </td>
            </tr>
            {{-- @php
                    $totalRuteSum += $item->totalrute;
                @endphp --}}
            {{-- @endforeach --}}
            <tr>
            </tr>
        </table>
        <td colspan="6" style="padding: 0px; position: relative;">
            <hr
                style="border-top: 1px solid black; margin: 3px 0; display: inline-block; width: calc(100% - 25px); vertical-align: middle;">
            <span>
                +
            </span>
        </td>
        <table style="width: 100%; margin-bottom:0px;">
            <tr>
                <td style="width: 40%; text-align: left; padding-right: 20px;">
                    <span class="info-item" style="font-size: 15px; display: block; word-wrap: break-word;">
                        {{ $cetakpdf->keterangan }}
                    </span>
                </td>
                <td style="text-align: right; padding: 0px;">
                    <span class="info-item" style="font-size: 15px; padding-right:20px">
                        {{ number_format($cetakpdf->totalrute, 2, ',', '.') }}
                    </span>
                </td>
            </tr>
        </table>


        <table>
            <tr>
                <td>
                    <table>
                        <tr>
                            <td style="text-align: left; padding-left: 17px;font-size: 15px;">No
                            </td>
                            <td style="text-align: left; padding-left: 17px;font-size: 15px;">Kode Nota Bon</td>
                            <td
                                style="text-align:
                                right; padding-right: 17px;font-size: 15px;">
                                Nominal</td>
                        </tr>
                        <tbody>
                            @foreach ($detail_nota as $item)
                                <td style="text-align: left; padding-left: 17px;font-size: 15px;">
                                    {{ $loop->iteration }}
                                </td>
                                <td style="text-align: left; padding-left: 17px;font-size: 15px;">
                                    {{ $item->kode_nota }}</td>
                                <td
                                    style="text-align:
                                right; padding-right: 17px;font-size: 15px;">
                                    {{ number_format($item->nominal_nota, 2, ',', '.') }}
                                </td>
                            @endforeach
                        </tbody>
                    </table>
                </td>
                <td>
                    <table style="width: 100%;" cellpadding="2" cellspacing="0">
                        <tr>
                            <td colspan="5" style="text-align: right; padding: 0px; font-size: 15px;">PPH 2 %</td>
                            <td class="td" style="text-align: right; padding-right: 20px; font-size: 15px;">
                                {{ number_format($cetakpdf->pphs, 2, ',', '.') }}

                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" style="padding: 0px;"></td>
                            <td style="padding: 0px;">
                                <hr
                                    style="border-top: 1px solid black; margin: 3px 0; display: inline-block; width: calc(100% - 25px); vertical-align: middle;">
                                <span>
                                    -
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" style="text-align: right; padding: 0px; font-size: 15px;"></td>
                            <td class="td" style="text-align: right; padding-right: 20px; font-size: 15px;">
                                {{ number_format($cetakpdf->totalrute - $cetakpdf->pphs, 2, ',', '.') }}

                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" style="text-align: right; padding: 0px; font-size: 15px;">Borong 50 %
                            </td>
                            <td class="td" style="text-align: right; padding-right: 20px; font-size: 15px;">
                                {{ number_format(($cetakpdf->totalrute - $cetakpdf->pphs) / 2, 2, ',', '.') }}

                            </td>
                        </tr>
                        @if ($cetakpdf->potongan_memo == 0)
                            <tr>
                                <td colspan="5" style="text-align: right; padding: 0px; font-size: 15px;">Biaya
                                    Tambahan</td>
                                <td class="td" style="text-align: right; padding-right: 20px; font-size: 15px;">
                                    {{ number_format($cetakpdf->biaya_tambahan, 2, ',', '.') }}
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td colspan="5" style="text-align: right; padding: 0px; font-size: 15px;">Potongan
                                    Memo</td>
                                <td class="td" style="text-align: right; padding-right: 20px; font-size: 15px;">
                                    {{ number_format($cetakpdf->potongan_memo, 2, ',', '.') }}
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <td colspan="5" style="padding: 0px;"></td>
                            <td style="padding: 0px;">
                                <hr
                                    style="border-top: 1px solid black; margin: 3px 0; display: inline-block; width: calc(100% - 25px); vertical-align: middle;">
                                <span>
                                    +
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" style="text-align: right; padding: 0px; font-size: 15px; color:white">
                                Sub Total
                            </td>
                            <td class="td" style="text-align: right; padding-right: 20px; font-size: 15px;">
                                {{ number_format(($cetakpdf->totalrute - $cetakpdf->pphs) / 2 + $cetakpdf->biaya_tambahan, 2, ',', '.') }}

                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" style="text-align: right; padding-left: 78px; font-size: 15px;">
                                Administrasi (1%)
                            </td>
                            <td class="td" style="text-align: right; padding-right: 20px; font-size: 15px;">
                                {{ number_format($cetakpdf->uang_jaminans, 2, ',', '.') }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" style="text-align: right; padding: 0px; font-size: 15px;">Deposit Supir
                            </td>
                            <td class="td" style="text-align: right; padding-right: 20px; font-size: 15px;">
                                {{ number_format($cetakpdf->deposit_driver, 2, ',', '.') }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" style="text-align: right; padding: 0px; font-size: 15px;">Nota Bon
                                Supir</td>
                            <td class="td" style="text-align: right; padding-right: 20px; font-size: 15px;">
                                {{ number_format($cetakpdf->nota_bons, 2, ',', '.') }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

        </table>

        <td colspan="5" style="padding: 0px;"></td>
        <td style="padding: 0px;">
            <hr
                style="border-top: 1px solid black; margin: 3px 0; display: inline-block; width: calc(100% - 25px); vertical-align: middle;">
            <span>
                -
            </span>
        </td>
        <table style="width: 100%;" cellpadding="2" cellspacing="0">
            <tr>
                <td class="td"
                    style="text-align: left; padding: 0px; font-size: 15px; white-space: nowrap; width: 60%;">
                    Saldo Deposit Sopir :
                    {{ number_format($cetakpdf->saldo_deposit, 2, ',', '.') }}
                </td>
                <td class="td" style="text-align: center; padding-right: 250px; font-size: 15px; width: 35%;">
                    Grand Total
                </td>
                <td class="td" style="text-align: right; padding-right: 20px; font-size: 15px;">
                    {{ number_format($cetakpdf->sub_total, 2, ',', '.') }}
                </td>
            </tr>
        </table>
    @endif
    <br>
    <br>
    <br>
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
                            {{ $cetakpdf->admin }}
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

<div class="container">
    <a href="{{ url('admin/inquery_memoborong') . '?status=&tanggal_awal=' . $cetakpdf->tanggal_awal . '&tanggal_akhir=' . $cetakpdf->tanggal_awal . '&kategori=' . $cetakpdf->kategori . '&ids=' }}"
        class="blue-button">
        Kembali
    </a>
    <a href="{{ url('admin/memo_ekspedisi/cetak-pdf/' . $cetakpdf->id) }}" class="blue-button">Cetak</a>
</div>


</html>
