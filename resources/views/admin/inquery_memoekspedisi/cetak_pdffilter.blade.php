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
            margin-left: 35px;
            margin-right: 80px;
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
            /* vertical-align: top; */
        }

        table {
            width: 100%;
            border-collapse: collapse;
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
    </style>
</head>
{{-- @foreach ($memos as $cetakpdf) --}}

<body style="margin: 0; padding: 0;">
    @for ($i = 0; $i < count($memos); $i += 2)
        @for ($j = $i; $j < $i + 2 && $j < count($memos); $j++)
            @php
                $cetakpdf = $memos[$j];
            @endphp
            <table width="100%">
                <tr>
                    <td style="width:0%;">
                    </td>
                    <td style="width: 70%; text-align: right;">
                    </td>
                </tr>
            </table>
            <div style="text-align: center;">
                <span style="font-weight: bold; font-size: 17px;">PT JAVA LINE LOGISTICS</span>
                <br>
                <span style=" font-size: 13px;">JL. HOS COKRO AMINOTO NO 5 SLAWI TEGAL
                </span>
                <br>
                <span style=" font-size: 13px;">Telp / Fax, 02836195328 02838195187</span>
            </div>
            <hr style="border: 0.5px solid;">


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
                                        <span class="info-item"
                                            style="font-size: 13px;">{{ $cetakpdf->kode_memo }}</span>
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
                                        <span class="info-item"
                                            style="font-size: 13px;">{{ $cetakpdf->no_kabin }}</span>
                                    </td>
                                </tr>
                            </table>
                        </td>

                        <td style="width: 50%; text-align: left;">
                            <table style="width: 100%; margin-top:4px">
                                <tr>
                                    <td style="width: 40%;">
                                        <span class="info-item"
                                            style="font-size: 13px; text-align: left; display: inline-block;">Nama
                                            bank</span>
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
                                            style="font-size: 13px; text-align: left; display: inline-block;">Atas
                                            Nama</span>
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
                                        <span class="info-item"
                                            style="font-size: 13px;">{{ $cetakpdf->kode_driver }}</span>
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
                                        <span class="info-item"
                                            style="font-size: 13px;">{{ $cetakpdf->nama_driver }}</span>
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
                                    <td class="info-column">
                                        <span class="info-item" style="font-size: 13px; color:white">.</span>
                                    </td>
                                    <td class="info-column">
                                        <span class="info-titik" style="font-size: 13px; color:white">.</span>
                                    </td>
                                    <td class="info-column">
                                        <span class="info-item" style="font-size: 13px; color:white">.</span>
                                    </td>
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
                                    <td class="td"
                                        style="text-align: right; padding-right: 11px;; font-size: 13px;">
                                        {{ number_format($cetakpdf->uang_jalan, 2, ',', '.') }}

                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" style="text-align: left; padding-left: 0px; font-size: 13px;">
                                        Biaya
                                        Tambahan
                                    </td>
                                    <td class="td"
                                        style="text-align: right; padding-right: 3px; font-size: 13px;">
                                        {{ number_format($cetakpdf->biaya_tambahan, 2, ',', '.') }} -</td>
                                </tr>
                                <tr>
                                    <td colspan="5" style="text-align: left; padding-left: 0px; font-size: 13px;">
                                        Potongan
                                        Memo
                                    </td>
                                    <td class="td"
                                        style="text-align: right; padding-right: 0px; font-size: 13px;">
                                        {{ number_format($cetakpdf->potongan_memo, 2, ',', '.') }} +</td>
                                </tr>
                                <tr>
                                    <td colspan="6" style="padding: 0px;">
                                        <hr style="border-top: 0.5px solid black; margin: 5px 0;">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" style="text-align: left; padding-left: 0px; font-size: 13px;">
                                        jumlah
                                    </td>
                                    <td class="td"
                                        style="text-align: right; padding-right: 11px; font-size: 13px;">
                                        {{ number_format($cetakpdf->uang_jalan + $cetakpdf->biaya_tambahan - $cetakpdf->potongan_memo, 2, ',', '.') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" style="text-align: left; padding-left: 0px; font-size: 13px;">
                                        Adm
                                    </td>
                                    <td class="td"
                                        style="text-align: right; padding-right: 11px; font-size: 13px;">
                                        {{ number_format($cetakpdf->uang_jaminan, 2, ',', '.') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" style="text-align: left; padding-left: 0px; font-size: 13px;">
                                        Deposit Sopir
                                    </td>
                                    <td class="td"
                                        style="text-align: right; padding-right: 3.5px; font-size: 13px;">
                                        {{ number_format($cetakpdf->deposit_driver, 2, ',', '.') }} -
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
                            style="text-align: left; padding: 0px; font-size: 13px; white-space: nowrap; width: 50%;">
                            Ket Memo
                        </td>
                        <td class="td"
                            style="text-align: center; padding-right: 10px; font-size: 13px; width: 25%;">
                            Grand Total
                        </td>
                        <td class="td"
                            style="text-align: right; padding-right: 13px; font-size: 13px; width: 20%; max-width: 100px; overflow: hidden; text-overflow: ellipsis;">
                            {{ number_format($cetakpdf->sub_total, 2, ',', '.') }}
                        </td>
                    </tr>
                </table>

                <div style="height: 48px; overflow: hidden;">
                    <table style="width: 100%;" cellpadding="2" cellspacing="0">
                        <tr>
                            <td class="td"
                                style="text-align: left; padding-right: 330px; font-size: 13px; white-space: normal;">
                                {{ $cetakpdf->keterangan }}
                            </td>
                        </tr>
                    </table>
                </div>
            @endif
            {{-- <br> --}}
            <div style=" margin-top:13px; margin-bottom:{{ $j % 2 != 0 && $j != 0 ? 150 : 12 }}px">
                <table class="tdd" cellpadding="10" cellspacing="0" style="margin: 0 auto;">
                    <tr>
                        <td style="text-align: center;">
                            <table style="margin: 0 auto;">
                                <tr style="text-align: center;">
                                    <td style="font-size: 13px;" class="label">
                                        {{ $cetakpdf->nama_driver }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="separator" colspan="2"><span></span></td>
                                </tr>
                                <tr style="text-align: center;">
                                    <td style="font-size: 13px;" class="label">Sopir</td>
                                </tr>
                            </table>
                        </td>
                        <td style="text-align: center;">
                            <table style="margin: 0 auto;">
                                <tr style="text-align: center;">
                                    <td style="font-size: 13px;" class="label">
                                        DJOHAN WAHYUDI
                                    </td>
                                </tr>
                                <tr>
                                    <td class="separator" colspan="2"><span></span></td>
                                </tr>
                                <tr style="text-align: center;">
                                    <td style="font-size: 13px;" class="label">Finance</td>
                                </tr>
                            </table>
                        </td>
                        <td style="text-align: center;">
                            <table style="margin: 0 auto;">
                                <tr style="text-align: center;">
                                    <td style="font-size: 13px;" class="label">
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
                                    <td style="font-size: 13px;" class="label">Admin</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <div style="text-align: right; font-size:12px; margin-top:0px">
                    <span style="font-style: italic;">Printed Date
                        {{ \Carbon\Carbon::now()->format('Y-m-d H:i:s') }}</span>
                </div>
            </div>
        @endfor
    @endfor
</body>
{{-- @endforeach --}}

</html>
