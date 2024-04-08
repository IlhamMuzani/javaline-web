<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pengambilan Kas Kecil</title>
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
    <div id="logo-container">
        <img src="{{ public_path('storage/uploads/user/logo.png') }}" alt="JAVA LINE LOGISTICS" width="150" height="50">
    </div>
    <br>
    <div style="font-weight: bold; text-align: center">
        <span style="font-weight: bold; font-size: 23px;">PENGAMBILAN KAS KECIL</span>
        <br>
        <br>
    </div>
    <hr style="border-top: 0.5px solid black; margin: 3px 0;">
    <table style="width: 100%;" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td" style="text-align: center; padding: 0px; font-size: 14px;">No.
                Faktur:{{ $cetakpdf->kode_pengeluaran }}</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 14px;">
                @if ($cetakpdf->kendaraan)
                    No Kabin {{ $cetakpdf->kendaraan->no_kabin }}
                @else
                @endif
            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 14px;">
                Tanggal:{{ $cetakpdf->tanggal }}</td>
        </tr>
    </table>
    </div>
    <hr style="border-top: 0.1px solid black; margin: 3px 0;">

    <table style="width: 100%;" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td" style="text-align: center; padding: 0px; font-size: 15px; width:4%">No.</td>
            <td class="td" style="text-align: left; padding: 0px; font-size: 15px; width:15%">Kode Akun</td>
            <td class="td" style="text-align: left; padding: 0px; font-size: 15px; width:20%">Nama Akun</td>
            <td class="td" style="text-align: left; padding: 0px; font-size: 15px; width:40%">Keterangan</td>
            <td class="td" style="text-align: right; font-size: 15px width:10%; padding-right:7px">Total</td>
        </tr>
        <!-- Add horizontal line below this row -->
        <tr>
            <td colspan="5" style="padding: 0px;">
                <hr style="border-top: 0.1px  solid black; margin:0px;">
            </td>
        </tr>
        @php
            $totalRuteSum = 0;
        @endphp
        @foreach ($details as $item)
            <tr>
                <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">
                    {{ $loop->iteration }}
                </td>
                <td class="td" style="text-align: left; padding: 0px; font-size: 15px;">
                    {{ $item->kode_akun }}
                </td>
                <td class="td" style="text-align: left; padding: 0px; font-size: 15px;">
                    {{ $item->nama_akun }}
                </td>
                <td class="td" style="text-align: left; padding: 0px; font-size: 15px;">
                    {{ $item->keterangan }}
                </td>
                <td class="td" style="text-align: right; font-size: 15px; padding-right:7px">
                    {{ number_format($item->nominal, 0, ',', '.') }}
                </td>
            </tr>
            @php
                $totalRuteSum += $item->nominal;
            @endphp
        @endforeach
        <tr>
        </tr>
    </table>
    <hr style="border-top: 0.1px solid black; margin: 3px 0;">

    <table style="width: 100%; margin-bottom:0px;">
        <tr>
            <td>
                {{-- <span class="info-item" style="font-size: 15px;">{{ $cetakpdf->keterangan }}</span>
                <br> --}}
            </td>
            <td style="text-align: right; padding: 0px;">
                <span class="info-item" style="font-size: 15px; font-weight:bold; ">
                    {{ number_format($totalRuteSum, 0, ',', '.') }}
                </span>
            </td>
        </tr>
    </table>

    <br>
    <br>

    <table class="tdd" cellpadding="10" cellspacing="0" style="margin: 0 auto;">
        <tr>
            <td style="text-align: center;">
                <table style="margin: 0 auto;">
                    <tr style="text-align: center;">
                        <td class="label">
                            @if ($cetakpdf->user)
                                {{ $cetakpdf->user->karyawan->nama_lengkap }}
                            @else
                                user tidak ada
                            @endif
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
                        <td class="label" style="min-height: 16px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="separator" colspan="2"><span></span></td>
                    </tr>
                    <tr style="text-align: center;">
                        <td class="label">Penerima</td>
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
