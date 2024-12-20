<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Surat Pemasangan Aki</title>
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
        <span style="font-weight: bold; font-size: 19px;">SURAT PEMASANGAN AKI</span>
        <br>
        <br>
    </div>
    {{-- <hr style="border-top: 0.1px solid black; margin: 1px 0;"> --}}

    <table style="width: 100%; border-top: 1px solid black;" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td" style="text-align: center; padding: 3px; font-size: 13px;">No.
                Kabin: @if ($cetakpdf->kendaraan)
                    {{ $cetakpdf->kendaraan->no_kabin }}
                @else
                    NON KENDARAAN
                @endif
            </td>
            {{-- <td class="td" style="text-align: center; padding: 3px; font-size: 16px;">No.
                Registrasi:{{ $cetakpdf->kendaraan->no_pol }}</td> --}}
            <td class="td" style="text-align: center; padding: 3px; font-size: 13px;">Jenis
                Kendaraan: @if ($cetakpdf->kendaraan)
                    {{ $cetakpdf->kendaraan->jenis_kendaraan->nama_jenis_kendaraan }}
                @else
                @endif
            </td>
            <td class="td" style="text-align: center; padding: 3px; font-size: 13px;">
                Tanggal:{{ $cetakpdf->tanggal_pemasangan }}</td>
        </tr>
    </table>
    </div>
    {{-- <hr style="border-top: 0.1px solid black; margin: 1px 0;"> --}}
    <table style="width: 100%; border-top: 1px solid black;" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td" style="text-align: center; padding: 5px; font-size: 13px;">No.</td>
            <td class="td" style="text-align: center; padding: 5px; font-size: 13px;">Kode Aki</td>
            <td class="td" style="text-align: center; padding: 5px; font-size: 13px;">No Seri</td>
            <td class="td" style="text-align: center; padding: 5px; font-size: 13px;">Merek</td>
            <td class="td" style="text-align: center; padding: 5px; font-size: 13px;">Keterangan</td>
        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td colspan="7" style="padding: 0px;">
            </td>
        </tr>
        @foreach ($details as $item)
            <tr>
                <td class="td" style="text-align: center; padding: 5px; font-size: 13px;">{{ $loop->iteration }}
                </td>
                <td class="td" style="text-align: center; padding: 5px; font-size: 13px;">
                    {{ $item->aki->kode_aki ?? null }}
                </td>
                <td class="td" style="text-align: center; padding: 5px; font-size: 13px;">
                    {{ $item->aki->no_seri ?? null }}
                </td>
                <td class="td" style="text-align: center; padding: 5px; font-size: 13px;">
                    {{ $item->merek }}
                </td>
                <td class="td" style="text-align: center; padding: 5px; font-size: 13px;">{{ $item->keterangan }}
                </td>
            </tr>
        @endforeach
        <tr style="border-bottom: 1px solid black;">
            <td colspan="8" style="padding: 0px;">
            </td>
        </tr>
    </table>

    <br><br><br>

    <table class="tdd" cellpadding="10" cellspacing="0" style="margin: 0 auto;">
        <tr>
            <td style="text-align: center;">
                <table style="margin: 0 auto;">
                    <tr style="text-align: center;">
                        <td style="font-size: 13px" class="label">
                            @if ($cetakpdf->user)
                                {{ $cetakpdf->user->karyawan->nama_lengkap }}
                            @else
                                user tidak ada
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 13px" class="separator" colspan="2"><span></span></td>
                    </tr>
                    <tr style="text-align: center;">
                        <td style="font-size:13px" class="label">Operasional</td>
                    </tr>
                </table>
            </td>
            <td style="text-align: center;">
                <table style="margin: 0 auto;">
                    <tr style="text-align: center;">
                        <td style="font-size: 13px" class="label" style="min-height: 16px; font-size:13px">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="font-size: 13px" class="separator" colspan="2"><span></span></td>
                    </tr>
                    <tr style="text-align: center;">
                        <td style="font-size: 13px" class="label">SPV Sparepart</td>
                    </tr>
                </table>
            </td>
            <td style="text-align: center;">
                <table style="margin: 0 auto;">
                    <tr style="text-align: center;">
                        <td style="font-size: 13px" class="label" style="min-height: 16px; font-size:13px">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="font-size: 13px" class="separator" colspan="2"><span></span></td>
                    </tr>
                    <tr style="text-align: center;">
                        <td style="font-size: 13px" class="label">Gudang</td>
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
