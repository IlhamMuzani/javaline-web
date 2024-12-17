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
            font-size: 10x;
            background-color: #fff;
        }

        .container {
            width: 64mm;
            /* Adjusted width */
            margin: 0 auto;
            border: 1px solid white;
            background-color: #fff;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.1);
        }

        .section {
            margin-bottom: 10px;
        }

        .section h2 {
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
            text-align: center;
            margin-bottom: 5px;
            font-size: 12px;
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
            /* padding: 5px; */
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
            margin-top: -24px;
            flex-direction: column;
        }

        .detail-info .pengiriman {
            display: flex;
            margin-top: 0px;
            margin-bottom: 2px;
            flex-direction: column;
            /* border-bottom: 1px solid #ccc;
            padding-bottom: 5px; */

        }

        .detail-info .penjualan {
            display: flex;
            margin-top: 2px;
            margin-bottom: 2px;
            flex-direction: column;
            /* border-bottom: 1px solid #ccc;
            padding-bottom: 5px; */

        }

        .detail-info p {
            margin: -1px 0;
            display: flex;
            justify-content: space-between;
        }

        .detail-info p strong {
            min-width: 130px;
            /* Sesuaikan dengan lebar maksimum label */
            font-size: 8px;
        }

        .detail-info p span {
            flex: 1;
            text-align: left;
            font-size: 10px;
            white-space: nowrap;
            /* Agar teks tidak pindah ke baris baru */
        }


        .label {
            font-size: 13px;
            text-align: center;
            /* Teks menjadi berada di tengah */

        }

        .separator {
            padding-top: 10px;
            /* Atur sesuai kebutuhan Anda */
            text-align: center;
            /* Teks menjadi berada di tengah */

        }

        .separator span {
            display: inline-block;
            border-top: 0.5px solid black;
            width: 100%;
            position: relative;
            top: -8px;
            /* Sesuaikan posisi vertikal garis tengah */
        }
    </style>


</head>

<body>
    @foreach ($notas as $cetakpdf)
        <table class="tdd" cellpadding="10" cellspacing="0" style="margin: 0 auto;">
            <tr>
                <td style="text-align: center;">
                    <table style="margin: 0 auto;">
                        <div class="container">
                            <div class="section">
                                <h2>Nota Bon Uang Jalan</h2>
                                <p style="text-align: right; font-size: 11px; margin-bottom: 10px;">
                                </p><br>
                                <div class="detail-info">
                                    <div class="kasir">
                                        <p>
                                            <span
                                                style="min-width: 60px; display: inline-flex; align-items: center; padding-left: 10px;">Kode
                                                Nota</span>
                                            <span style="min-width: 50px; display: inline-flex; align-items: center;">:
                                                {{ $cetakpdf->kode_nota }}
                                            </span>
                                        </p>
                                    </div>
                                    <div class="kasir">
                                        <p>
                                            <span
                                                style="min-width: 60px; display: inline-flex; align-items: center; padding-left: 10px;">Kode
                                                Driver</span>
                                            <span style="min-width: 50px; display: inline-flex; align-items: center;">:
                                                {{ $cetakpdf->kode_driver }}
                                            </span>
                                        </p>
                                    </div>
                                    <div class="pelanggan">
                                        <p>
                                            <span
                                                style="min-width: 60px; display: inline-flex; align-items: center; padding-left: 10px;">Nama
                                                Driver</span>
                                            <span
                                                style="min-width: 50px; display: inline-flex; align-items: center; font-size: 10px;">
                                                : {{ $cetakpdf->nama_driver }}
                                            </span>
                                        </p>
                                    </div>
                                    <div class="pelanggan">
                                        <p>
                                            <span
                                                style="min-width: 60px; display: inline-flex; align-items: center; padding-left: 10px;">Nominal</span>
                                            <span
                                                style="min-width: 50px; display: inline-flex; align-items: center; font-size: 10px;">
                                                : {{ number_format($cetakpdf->nominal, 0, ',', '.') }}

                                            </span>
                                        </p>
                                    </div>
                                    <div class="pelanggan">
                                        <p>
                                            <span
                                                style="min-width: 60px; display: inline-flex; align-items: center; padding-left: 10px;">Keterangan</span>
                                            <span
                                                style="min-width: 50px; display: inline-flex; align-items: center; font-size: 10px;">
                                                :

                                            </span>
                                        </p>
                                    </div>
                                    <div style="margin-left:10px; font-size:10px">
                                        - {{ $cetakpdf->keterangan }}
                                    </div>
                                </div>
                                <div style=" margin-bottom:10px; margin-top:30px">
                                    <table class="tdd" cellpadding="10" cellspacing="0" style="margin: 0 auto;">
                                        <tr>
                                            <td style="text-align: center;">
                                                <table style="margin: 0 auto;">
                                                    <tr style="text-align: center;">
                                                        <td class="label">
                                                            {{ auth()->user()->karyawan->nama_lengkap }} </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="separator" colspan="2"><span></span></td>
                                                    </tr>
                                                    <tr style="text-align: center;">
                                                        <td class="label">Admin</td>
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
                                                <table>
                                                    <tr>
                                                        <td class="label">.</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="separator" colspan="2"><span></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="label">Acounting</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <div style="text-align: right; font-size:8px; margin-right:20px">
                                        <span style="font-style: italic;">Printed Date
                                            {{ \Carbon\Carbon::now()->format('Y-m-d H:i:s') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </table>
                </td>
                <td style="text-align: center;">
                    <table style="margin: 0 auto;">
                        <div class="container">
                            <div class="section">
                                <h2>Nota Bon Uang Jalan</h2>
                                <p style="text-align: right; font-size: 11px; margin-bottom: 10px;">
                                </p><br>
                                <div class="detail-info">
                                    <div class="kasir">
                                        <p>
                                            <span
                                                style="min-width: 60px; display: inline-flex; align-items: center; padding-left: 10px;">Kode
                                                Nota</span>
                                            <span style="min-width: 50px; display: inline-flex; align-items: center;">:
                                                {{ $cetakpdf->kode_nota }}
                                            </span>
                                        </p>
                                    </div>
                                    <div class="kasir">
                                        <p>
                                            <span
                                                style="min-width: 60px; display: inline-flex; align-items: center; padding-left: 10px;">Kode
                                                Driver</span>
                                            <span style="min-width: 50px; display: inline-flex; align-items: center;">:
                                                {{ $cetakpdf->kode_driver }}
                                            </span>
                                        </p>
                                    </div>
                                    <div class="pelanggan">
                                        <p>
                                            <span
                                                style="min-width: 60px; display: inline-flex; align-items: center; padding-left: 10px;">Nama
                                                Driver</span>
                                            <span
                                                style="min-width: 50px; display: inline-flex; align-items: center; font-size: 10px;">
                                                : {{ $cetakpdf->nama_driver }}
                                            </span>
                                        </p>
                                    </div>
                                    <div class="pelanggan">
                                        <p>
                                            <span
                                                style="min-width: 60px; display: inline-flex; align-items: center; padding-left: 10px;">Nominal</span>
                                            <span
                                                style="min-width: 50px; display: inline-flex; align-items: center; font-size: 10px;">
                                                : {{ number_format($cetakpdf->nominal, 0, ',', '.') }}

                                            </span>
                                        </p>
                                    </div>
                                    <div class="pelanggan">
                                        <p>
                                            <span
                                                style="min-width: 60px; display: inline-flex; align-items: center; padding-left: 10px;">Keterangan</span>
                                            <span
                                                style="min-width: 50px; display: inline-flex; align-items: center; font-size: 10px;">
                                                :

                                            </span>
                                        </p>
                                    </div>
                                    <div style="margin-left:10px; font-size:10px">
                                        - {{ $cetakpdf->keterangan }}
                                    </div>
                                </div>
                                <div style=" margin-bottom:10px; margin-top:30px">
                                    <table class="tdd" cellpadding="10" cellspacing="0" style="margin: 0 auto;">
                                        <tr>
                                            <td style="text-align: center;">
                                                <table style="margin: 0 auto;">
                                                    <tr style="text-align: center;">
                                                        <td class="label">
                                                            {{ auth()->user()->karyawan->nama_lengkap }} </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="separator" colspan="2"><span></span></td>
                                                    </tr>
                                                    <tr style="text-align: center;">
                                                        <td class="label">Admin</td>
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
                                                <table>
                                                    <tr>
                                                        <td class="label">.</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="separator" colspan="2"><span></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="label">Acounting</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <div style="text-align: right; font-size:8px; margin-right:20px">
                                        <span style="font-style: italic;">Printed Date
                                            {{ \Carbon\Carbon::now()->format('Y-m-d H:i:s') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </table>
                </td>
                <td style="text-align: center;">
                    <table>
                        <div class="container">
                            <div class="section">
                                <h2>Nota Bon Uang Jalan</h2>
                                <p style="text-align: right; font-size: 11px; margin-bottom: 10px;">
                                </p><br>
                                <div class="detail-info">
                                    <div class="kasir">
                                        <p>
                                            <span
                                                style="min-width: 60px; display: inline-flex; align-items: center; padding-left: 10px;">Kode
                                                Nota</span>
                                            <span style="min-width: 50px; display: inline-flex; align-items: center;">:
                                                {{ $cetakpdf->kode_nota }}
                                            </span>
                                        </p>
                                    </div>
                                    <div class="kasir">
                                        <p>
                                            <span
                                                style="min-width: 60px; display: inline-flex; align-items: center; padding-left: 10px;">Kode
                                                Driver</span>
                                            <span style="min-width: 50px; display: inline-flex; align-items: center;">:
                                                {{ $cetakpdf->kode_driver }}
                                            </span>
                                        </p>
                                    </div>
                                    <div class="pelanggan">
                                        <p>
                                            <span
                                                style="min-width: 60px; display: inline-flex; align-items: center; padding-left: 10px;">Nama
                                                Driver</span>
                                            <span
                                                style="min-width: 50px; display: inline-flex; align-items: center; font-size: 10px;">
                                                : {{ $cetakpdf->nama_driver }}
                                            </span>
                                        </p>
                                    </div>
                                    <div class="pelanggan">
                                        <p>
                                            <span
                                                style="min-width: 60px; display: inline-flex; align-items: center; padding-left: 10px;">Nominal</span>
                                            <span
                                                style="min-width: 50px; display: inline-flex; align-items: center; font-size: 10px;">
                                                : {{ number_format($cetakpdf->nominal, 0, ',', '.') }}

                                            </span>
                                        </p>
                                    </div>
                                    <div class="pelanggan">
                                        <p>
                                            <span
                                                style="min-width: 60px; display: inline-flex; align-items: center; padding-left: 10px;">Keterangan</span>
                                            <span
                                                style="min-width: 50px; display: inline-flex; align-items: center; font-size: 10px;">
                                                :

                                            </span>
                                        </p>
                                    </div>
                                    <div style="margin-left:10px; font-size:10px">
                                        - {{ $cetakpdf->keterangan }}
                                    </div>
                                </div>
                                <div style=" margin-bottom:10px; margin-top:30px">
                                    <table class="tdd" cellpadding="10" cellspacing="0" style="margin: 0 auto;">
                                        <tr>
                                            <td style="text-align: center;">
                                                <table style="margin: 0 auto;">
                                                    <tr style="text-align: center;">
                                                        <td class="label">
                                                            {{ auth()->user()->karyawan->nama_lengkap }} </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="separator" colspan="2"><span></span></td>
                                                    </tr>
                                                    <tr style="text-align: center;">
                                                        <td class="label">Admin</td>
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
                                                <table>
                                                    <tr>
                                                        <td class="label">.</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="separator" colspan="2"><span></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="label">Acounting</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <div style="text-align: right; font-size:8px; margin-right:20px">
                                        <span style="font-style: italic;">Printed Date
                                            {{ \Carbon\Carbon::now()->format('Y-m-d H:i:s') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </table>
                </td>
            </tr>
        </table>
    @endforeach
</body>

</html>
