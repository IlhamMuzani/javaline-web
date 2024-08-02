<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pengambilan DO</title>
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
    <div style="text-align: center;">
        <span style="font-weight: bold; font-size: 16px;">PENGAMBILAN DO</span>
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
                            <span class="info-item" style="font-size: 13px;">No. Pengambilan</span>
                        </td>
                        <td class="info-column">
                            <span class="info-titik" style="font-size: 13px;">:</span>
                        </td>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 13px;">{{ $cetakpdf->kode_pengambilan }}</span>
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
                            <span class="info-item" style="font-size: 13px;">{{ $cetakpdf->kendaraan->no_kabin }}</span>
                        </td>
                    </tr>
                </table>
            </td>

            <td style="width: 50%; text-align: left;">
                <table style="width: 100%; margin-top:4px">
                    <tr>
                        <td style="width: 40%;">
                            <span class="info-item"
                                style="font-size: 13px; text-align: left; display: inline-block; color:white">Nama
                                bank</span>
                        </td>
                        <td style="width: 60%;">
                            <span class="info-item"
                                style="font-size: 13px; text-align: left; display: inline-block; color:white">:
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
                                style="font-size: 13px; text-align: left; display: inline-block; color:white">No
                                Rekening</span>
                        </td>
                        <td style="width: 60%;">
                            <span class="info-item"
                                style="font-size: 13px; text-align: left; display: inline-block; color:white">:
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
                                style="font-size: 13px; text-align: left; display: inline-block; color:white">Atas
                                Nama</span>
                        </td>
                        <td style="width: 60%;">
                            <span class="info-item"
                                style="font-size: 13px; text-align: left; display: inline-block; color:white">:
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
                                style="font-size: 13px;">{{ $cetakpdf->user->karyawan->kode_karyawan }}</span>
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
                                style="font-size: 13px;">{{ $cetakpdf->user->karyawan->nama_lengkap }}</span>
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
                                {{ $cetakpdf->rute_perjalanan->nama_rute }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 13px;">Alamat Muat</span>
                        </td>
                        <td class="info-column">
                            <span class="info-titik" style="font-size: 13px;">:</span>
                        </td>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 13px;">
                                {{ $cetakpdf->alamat_muat->alamat }}</span>

                        </td>
                    </tr>
                    <tr>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 13px;">Alamat Bongkar</span>
                        </td>
                        <td class="info-column">
                            <span class="info-titik" style="font-size: 13px;">:</span>
                        </td>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 13px;">
                                {{ $cetakpdf->alamat_bongkar->alamat }}</span>

                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <hr style="border: 0.5px solid;">

   <br>

    <table class="tdd" cellpadding="10" cellspacing="0" style="margin: 0 auto;">
        <tr>
            <td style="text-align: center;">
                <table style="margin: 0 auto;">
                    <tr style="text-align: center;">
                        <td style="font-size: 13px;" class="label">
                            {{ $cetakpdf->user->karyawan->nama_lengkap }}
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
    <div style="text-align: right; font-size:11px; margin-top:0px">
        <span style="font-style: italic;">Printed Date {{ \Carbon\Carbon::now()->format('Y-m-d H:i:s') }}</span>
    </div>

</body>

</html>
