<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Nota Bon</title>
    <style>
        html,
        body {
            font-family: Arial, sans-serif;
            line-height: 1.4;
            margin: 0px;
            font-size: 10px;
            background-color: #fff;
        }

        .container {
            width: 100mm;
            margin: 0 auto;
            border: 1px solid white;
            background-color: #fff;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.1);
            page-break-after: always;
            /* Setiap 3 perulangan, pindah ke halaman baru */
        }

        .section {
            margin-bottom: 10px;
        }

        .section h2 {
            border-bottom: 1px solid #ccc;
            padding-bottom: 0px;
            text-align: center;
            margin-bottom: 5px;
            font-size: 13px;
            text-transform: uppercase;
        }

        .section table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0px;
        }

        .section table th,
        .section table td {
            border: 1px solid white;
            font-size: 8px;
        }

        .float-right {
            text-align: right;
            margin-top: 10px;
        }

        .float-right button {
            padding: 5px 10px;
            font-size: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 3px;
            box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.1);
        }

        .float-right button:hover {
            background-color: #0056b3;
        }

        .detail-info {
            display: flex;
            margin-top: -25px;
            flex-direction: column;
        }

        .detail-info .pengiriman {
            display: flex;
            margin-top: 0px;
            margin-bottom: 2px;
            flex-direction: column;
        }

        .detail-info .penjualan {
            display: flex;
            margin-top: 2px;
            margin-bottom: 0px;
            flex-direction: column;
        }

        .detail-info p {
            margin: -1px 0;
            display: flex;
            justify-content: space-between;
        }

        .detail-info p strong {
            min-width: 130px;
            font-size: 8px;
        }

        .detail-info p span {
            flex: 1;
            text-align: left;
            font-size: 10px;
            white-space: nowrap;
        }

        .label {
            font-size: 13px;
            text-align: center;
        }

        .separator {
            padding-top: 10px;
            text-align: center;
        }

        .separator span {
            display: inline-block;
            border-top: 0.5px solid black;
            width: 100%;
            position: relative;
            top: -8px;
        }
    </style>
</head>

<body>
    <table class="tdd" cellpadding="10" cellspacing="0" style="margin: 0 auto;">
        <tr>
            @foreach ($notas as $index => $cetakpdf)
                @if ($index % 2 === 0 && $index > 0)
        </tr>
        <tr>
            @endif
            <td style="text-align: center;">
                <table style="margin: 0 auto;">
                    <div class="container">
                        <div class="section">
                            <h2>Nota Bon Uang Jalan</h2>
                            <p style="text-align: right; font-size: 11px; margin-bottom: 5px;"></p>
                            <br>
                            <div class="detail-info">
                                <div class="kasir">
                                    <p>
                                        <span
                                            style="min-width: 60px; display: inline-flex; align-items: center; padding-left: 10px; font-size: 12px;">Kode
                                            Nota</span>
                                        <span
                                            style="min-width: 50px; display: inline-flex; align-items: center; font-size: 12px; margin-left:20px">
                                            :
                                            {{ $cetakpdf->kode_nota }}</span>
                                    </p>
                                </div>
                                <div class="kasir">
                                    <p>
                                        <span
                                            style="min-width: 60px; display: inline-flex; align-items: center; padding-left: 10px; font-size: 12px;">Kode
                                            Driver</span>
                                        <span
                                            style="min-width: 50px; display: inline-flex; align-items: center; font-size: 12px; margin-left:17px">
                                            :
                                            {{ $cetakpdf->kode_driver }}</span>
                                    </p>
                                </div>
                                <div class="">
                                    <p>
                                        <span
                                            style="min-width: 60px; display: inline-flex; align-items: center; padding-left: 10px; font-size: 12px;">Nama
                                            Driver</span>
                                        <span
                                            style="min-width: 50px; display: inline-flex; align-items: center; font-size: 12px; margin-left:13px">
                                            :
                                            {{ $cetakpdf->nama_driver }}</span>
                                    </p>
                                </div>
                                <div class="">
                                    <p>
                                        <span
                                            style="min-width: 60px; display: inline-flex; align-items: center; padding-left: 11px; font-size: 12px;">Nominal</span>
                                        <span
                                            style="min-width: 50px; display: inline-flex; align-items: center; font-size: 12px; margin-left:20px">
                                            :
                                            {{ number_format($cetakpdf->nominal, 0, ',', '.') }}</span>
                                    </p>
                                </div>
                                <div class="">
                                    <p>
                                        <span
                                            style="min-width: 60px; display: inline-flex; align-items: center; padding-left: 10px; font-size: 12px;">Keterangan</span>
                                        <span
                                            style="min-width: 50px; display: inline-flex; align-items: center; font-size: 12px;"></span>
                                    </p>
                                </div>
                                <div style="margin-left:10px; font-size:12px">- {{ $cetakpdf->keterangan }}</div>
                            </div>
                            <div style=" margin-bottom:10px; margin-top:0px">
                                <table class="tdd" cellpadding="10" cellspacing="0" style="margin: 0 auto;">
                                    <tr>
                                        <td style="text-align: center;">
                                            <table style="margin: 0 auto; sty">
                                                <tr style="text-align: center;">
                                                    <td style="font-size: 12px" class="label">{{ $cetakpdf->admin }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="separator" colspan="2"><span></span></td>
                                                </tr>
                                                <tr style="text-align: center;">
                                                    <td style="font-size: 12px" class="label">Admin</td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td style="text-align: center;">
                                            <table style="margin: 0 auto;">
                                                <tr style="text-align: center;">
                                                    <td style="font-size: 12px" class="label">DJOHAN WAHYUDI</td>
                                                </tr>
                                                <tr>
                                                    <td class="separator" colspan="2"><span></span></td>
                                                </tr>
                                                <tr style="text-align: center;">
                                                    <td style="font-size: 12px" class="label">Finance</td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td style="text-align: center;">
                                            <table style="margin: 0 auto;">
                                                <tr style="text-align: center;">
                                                    <td style="font-size: 12px; color:#fff" class="label">.</td>
                                                </tr>
                                                <tr>
                                                    <td class="separator" colspan="2"><span></span></td>
                                                </tr>
                                                <tr style="text-align: center;">
                                                    <td style="font-size: 12px" class="label">Finance</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                                <div style="text-align: right; font-size:10px; margin-right:20px">
                                    <span style="font-style: italic;">Printed Date
                                        {{ \Carbon\Carbon::now()->format('Y-m-d H:i:s') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </table>
            </td>
            @endforeach
        </tr>
    </table>
</body>

</html>
