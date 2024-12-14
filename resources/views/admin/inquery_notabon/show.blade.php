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
            /* margin: 0; */
            margin-left: 0;
            margin-top: 0;
            /* padding: 0; */
            padding-right: 465px;
            font-size: 10x;
            background-color: #fff;
        }

        .container {
            width: 65mm;
            /* Adjusted width */
            margin: 0 auto;
            border: 1px solid white;
            padding: 5px;
            background-color: #fff;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.1);
        }

        .header {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100px;
            /* Sesuaikan tinggi header sesuai kebutuhan */
        }

        .header .text {
            display: flex;
            flex-direction: column;
            align-items: center;
            /* Mengatur konten di dalam .text agar berada di tengah */
            text-align: center;
            /* Mengatur teks di dalam .text agar berada di tengah */
        }

        .header .text h1 {
            margin-top: 10px;
            margin-bottom: 0px;
            padding: 0;
            font-size: 16px;
            color: #0c0c0c;
            text-transform: uppercase;
        }

        .header .text p {
            margin: 2px;
            font-size: 9px;
            margin-bottom: 2px;
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

        .penjualan p span {
            margin-top: 3px;
        }

        .pelanggan p span {
            margin-top: 3px;

        }

        .telepon p span {
            margin-top: 3px;
        }

        .alamat p span {
            margin-top: 3px;
        }

        .tanggal p span {
            margin-top: 3px;
        }

        .divider {
            border: 0.5px solid;
            margin-top: -10px;
            margin-bottom: 2px;
            border-bottom: 2px solid #0f0e0e;
        }

        .terimakasih p {
            border-top: 1px solid #ccc;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
            text-align: center;
            margin-bottom: 5px;
            margin-top: 10px;
            font-size: 10px;
        }

        .counts {
            display: flex;
            justify-content: space-between;
            margin-top: 1rem;
        }


        .blue-button {
            padding: 3px 5px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            text-decoration: none;
            top: 50%;
            font-size: 10px;
            border-radius: 3px;
            transform: translateY(-50%);

        }

        @media print {
            body {
                font-size: 10px;
                background-color: #fff;
                margin: 0;
                padding: 0;
            }

            .container {
                width: 65mm;
                /* Sesuaikan dengan lebar kertas thermal */
                margin: 0 auto;
                border: none;
                padding: 0;
                box-shadow: none;
            }

            .header .logo img {
                max-width: 80px;
                /* Sesuaikan jika perlu */
                height: auto;
            }

            .section table {
                width: 100%;
                margin-top: 5px;
            }

            .section table th,
            .section table td {
                border: 1px solid #ccc;
                padding: 5px;
                font-size: 8px;
            }

            .signatures {
                display: flex;
                justify-content: space-between;
            }

            .signature1,
            .signature2 {
                font-size: 7px;
                text-align: left;
            }

            .signature2 {
                margin-top: -65px;
                /* Atur posisi jika perlu */
            }

            .signature p {
                margin-top: 10px;
                line-height: 1.2;
            }

            .detail-info p strong {
                min-width: 130px;
                /* Sesuaikan dengan kebutuhan */
                font-size: 8px;
            }

            .float-right button {
                font-size: 10px;
                padding: 5px 10px;
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
                margin-top: -24px;
                flex-direction: column;
            }

            .detail-info p {
                margin: -1px 0;
                display: flex;
                justify-content: space-between;
            }

            .penjualan p span {
                margin-top: 3px;
            }

            .pelanggan p span {
                margin-top: 3px;
            }

            .telepon p span {
                margin-top: 3px;
            }

            .alamat p span {
                margin-top: 3px;
            }

            .tanggal p span {
                margin-top: 3px;
            }

            .divider {
                border: 0.5px solid;
                margin-top: 3px;
                margin-bottom: 1px;
                border-bottom: 1px solid #0f0e0e;
            }

            @page {
                size: 65mm auto;
                /* Sesuaikan dengan ukuran kertas thermal */
                margin: 0mm;
                /* Set margin ke 0 untuk semua sisi */
            }
        }
    </style>


</head>

<body>
    <div class="container">
        <div class="section">
            <h2>Nota Bon Uang Jalan</h2>
            <p style="text-align: right; font-size: 11px; margin-bottom: 10px;">
            </p><br>
            <div class="detail-info">
                <div class="penjualan">
                    <p>
                        <span
                            style="min-width: 10px; display: inline-flex; align-items: center; padding-left: 10px;">Kode
                            Nota</span>
                        <span style="min-width: 50px; display: inline-flex; align-items: center; font-size: 10px;">:
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
                        <span style="min-width: 50px; display: inline-flex; align-items: center; font-size: 10px;">
                            : {{ $cetakpdf->nama_driver }}
                        </span>
                    </p>
                </div>
                <div class="pelanggan">
                    <p>
                        <span
                            style="min-width: 60px; display: inline-flex; align-items: center; padding-left: 10px;">Nominal</span>
                        <span style="min-width: 50px; display: inline-flex; align-items: center; font-size: 10px;">
                            : {{ number_format($cetakpdf->nominal, 0, ',', '.') }}

                        </span>
                    </p>
                </div>
                <div class="pelanggan">
                    <p>
                        <span
                            style="min-width: 60px; display: inline-flex; align-items: center; padding-left: 10px;">Keterangan</span>
                        <span style="min-width: 50px; display: inline-flex; align-items: center; font-size: 10px;">
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
                <div style="text-align: right; font-size:8px">
                    <span style="font-style: italic;">Printed Date
                        {{ \Carbon\Carbon::now()->format('Y-m-d H:i:s') }}</span>
                </div>
            </div>
        </div>
        <div class="counts">
            <a href="{{ url('admin/inquery-notabon') }}" class="blue-button">Kembali</a>
            <a href="{{ url('admin/nota-bon/cetak-pdf/' . $cetakpdf->id) }}" class="blue-button">Cetak</a>
        </div>

</body>

</html>
