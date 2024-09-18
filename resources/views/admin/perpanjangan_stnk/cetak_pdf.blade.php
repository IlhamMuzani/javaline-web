<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Surat Perpanjangan Stnk</title>
    <style>
        html,
        body {
            font-family: Arial, sans-serif;
            color: black;
            margin-top: 10px;
            margin-left: 10px;
            margin-right: 10px;
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
            /* size: A4; */
            margin: 1cm;
        }
    </style>
</head>

<body style="margin: 0; padding: 0;">
    <div id="logo-container">
        <img src="{{ public_path('storage/uploads/user/logo.png') }}" alt="JAVA LINE LOGISTICS" width="150"
            height="50">
    </div>
    <br>
    <div style="font-weight: bold; text-align: center">
        <span style="font-weight: bold; font-size: 19px;">SURAT PERPANJANGAN STNK</span>
        <br>
        <br>
    </div>
    {{-- <hr style="border-top: 0.1px solid black; margin: 1px 0;"> --}}

    <table style="width: 100%; border-top: 1px solid black;" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td" style="text-align: center; padding: 3px; font-size: 13px;">
                Kode Perpanjangan:{{ $laporan->kode_perpanjangan }}</td>
            <td class="td" style="text-align: center; padding: 3px; font-size: 13px;">
                Tanggal:{{ $cetakpdf->tanggal }}</td>
        </tr>
    </table>
    </div>
    {{-- <hr style="border-top: 0.1px solid black; margin: 1px 0;"> --}}
    <table style="width: 100%; border-top: 1px solid black;" cellpadding="2" cellspacing="0">
        <tr>
            {{-- <td class="td" style="text-align: center; padding: 5px; font-size: 13px;">No.</td> --}}
            <td class="td" style="text-align: center; padding: 5px; font-size: 13px;">No. Kabin</td>
            <td class="td" style="text-align: center; padding: 5px; font-size: 13px;">No. Registrasi</td>
            <td class="td" style="text-align: center; padding: 5px; font-size: 13px;">Berlaku Sampai</td>
            <td class="td" style="text-align: center; padding: 5px; font-size: 13px;">Jumlah</td>
        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td colspan="7" style="padding: 0px;">
            </td>
        </tr>
        {{-- @foreach ($bans as $item) --}}
        <tr>
            {{-- <td class="td" style="text-align: center; padding: 5px; font-size: 13px;">{{ $loop->iteration }}
                </td> --}}
            <td class="td" style="text-align: center; padding: 5px; font-size: 13px;">
                {{ $cetakpdf->kendaraan->no_kabin }}
            </td>
            <td class="td" style="text-align: center; padding: 5px; font-size: 13px;">
                {{ $cetakpdf->kendaraan->no_pol }}
            </td>
            <td class="td" style="text-align: center; padding: 5px; font-size: 13px;">{{ $cetakpdf->expired_stnk }}
            </td>
            <td class="td" style="text-align: center; padding: 5px; font-size: 13px;">
                Rp.{{ number_format($cetakpdf->jumlah, 0, ',', '.') }}
                {{-- <td class="td" style="text-align: center; padding: 5px; font-size: 13px;">
                    {{ $item->merek->nama_merek }}</td>
                <td class="td" style="text-align: center; padding: 5px; font-size: 13px;">
                    {{ $item->kondisi_ban }}
                </td>
                <td class="td" style="text-align: center; padding: 5px; font-size: 13px;">
                    {{ number_format($item->km_pemasangan, 0, ',', '.') }}
                </td> --}}
        </tr>
        {{-- @endforeach --}}
        <tr style="border-bottom: 1px solid black;">
            <td colspan="8" style="padding: 0px;">
            </td>
        </tr>
    </table>

    {{-- <br> --}}

    {{-- <table width="100%">
        <tr>
            <td>
                <div class="info-catatan" style="max-width: 230px;">
                    <table>
                        <tr>
                            <td class="info-catatan2" style="font-size: 13px;">Nama Supplier</td>
                            <td class="info-item" style="font-size: 13px;">:</td>
                            <td class="info-text info-left" style="font-size: 13px;">
                                {{ $pasang_ban->supplier->nama_bank }}
                            </td>
                        </tr>
                        <tr>
                            <td class="info-catatan2" style="font-size: 13px;">No. Rekening</td>
                            <td class="info-item" style="font-size: 13px;">:</td>
                            <td class="info-text info-left" style="font-size: 13px;">
                                {{ $pasang_ban->supplier->norek }}
                            </td>
                        </tr>
                        <tr>
                            <td class="info-catatan2" style="font-size: 13px;">Atas Nama</td>
                            <td class="info-item" style="font-size: 13px;">:</td>
                            <td class="info-text info-left" style="font-size: 13px;">
                                {{ $pasang_ban->supplier->atas_nama }}
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table> --}}

    <br>
    <br>

    <table class="tdd" cellpadding="10" cellspacing="0" style="margin: 0 auto;">
        <tr>
            <td style="text-align: center;">
                <table style="margin: 0 auto;">
                    <tr style="text-align: center;">
                        <td style="font-size: 13px" class="label">
                            @if ($laporan->user)
                                {{ $laporan->user->karyawan->nama_lengkap }}
                            @else
                                user tidak ada
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <td style="font-size: 13px" class="separator" colspan="2"><span></span></td>
                    </tr>
                    <tr style="text-align: center;">
                        <td style="font-size: 13px" class="label">Operasional</td>
                    </tr>
                </table>
            </td>
            <td style="text-align: center;">
                <table style="margin: 0 auto;">
                    <tr style="text-align: center;">
                        <td style="font-size: 13px" class="label" style="min-height: 16px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="font-size: 13px" class="separator" colspan="2"><span></span></td>
                    </tr>
                    <tr style="text-align: center;">
                        <td style="font-size: 13px" class="label">Financial</td>
                    </tr>
                </table>
            </td>
            <td style="text-align: center;">
                <table style="margin: 0 auto;">
                    <tr style="text-align: center;">
                        <td style="font-size: 13px" class="label" style="min-height: 16px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="font-size: 13px" class="separator" colspan="2"><span></span></td>
                    </tr>
                    <tr style="text-align: center;">
                        <td style="font-size: 13px" class="label">Accounting</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <div style="text-align: right; font-size:12px; margin-top:25px">
        <span style="font-style: italic;">Printed Date {{ \Carbon\Carbon::now()->format('Y-m-d H:i:s') }}</span>
    </div>
</body>

</html>
