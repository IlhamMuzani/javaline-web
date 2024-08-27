<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kotrak Rute</title>
    <style>
        html,
        body {
            font-family: 'DOSVGA', Arial, Helvetica, sans-serif;
            /* font-family: 'DOSVGA', monospace; */
            color: black;

            margin-top: 5px;
            margin-right: 12px;
            margin-left: 12px;
            /* Margin kiri sebesar 20 piksel */

            /* font-weight: bold; */
            /* Atur ketebalan huruf menjadi bold */
        }

        .container {
            display: flex;
            justify-content: space-between;
            margin-top: 7rem;
        }

        .blue-button {
            padding: 12px 20px;
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
            /* padding-left: 5px; */
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
            padding-top: 12px;
            text-align: center;
        }

        .separator span {
            display: inline-block;
            border-top: 1px solid black;
            width: 100%;
            position: relative;
            top: -8px;
        }

        @media print {
            .header {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                z-index: 1000;
                /* Pastikan z-index lebih tinggi dari elemen lain yang mungkin ada */
            }

            /* Atur properti CSS untuk elemen header di sini */
            /* Misalnya, properti seperti ukuran font, warna teks, latar belakang, dll. */
        }

        .welcome-text {
            position: fixed;
            top: 2px;
            /* Atur jarak dari atas halaman */
            left: 9;
            /* Letakkan teks di kiri halaman */
            right: 9;
            /* Letakkan teks di kanan halaman */
            text-align: center;
            /* Pusatkan teks horizontal */
            font-size: 18px;
            font-weight: 700;
            /* Ganti dengan nilai yang lebih tinggi untuk bold */
            color: #000;
            /* Ganti dengan nilai hex yang lebih gelap */
            /* Warna teks */
            z-index: 999;
            /* Pastikan z-index lebih tinggi dari elemen lain */
        }
    </style>
</head>


<body style="margin-top: 90; padding: 0;">
    <div class="welcome-text">
        <div class="header">
            <table width="100%">
                <tr>
                    <td style="width:20%;">
                        <div style="text-align: left;">
                            <img src="{{ public_path('storage/uploads/user/logo.png') }}" alt="JAVA LINE" width="160"
                                height="60">
                        </div>
                    </td>
                    <td style="width: 95%; text-align: left;">
                        <div style="text-align: center;">
                            <span style="font-weight: bold; font-size: 16px;">PT JAVA LINE LOGISTICS</span>
                            <br>
                            <span style=" font-size: 12px;">JL. HOS COKRO AMINOTO NO 5 SLAWI TEGAL
                                {{-- <br>Tegal 52411 --}}
                            </span>
                            <br>
                            <span style=" font-size: 12px;">Telp / Fax, 02836195328 02838195187</span>
                            <br>
                            <span style=" font-size: 12px;">Email : marketing2.javalinelogistics@gmail.com</span>
                        </div>
                    </td>
                    <td style="width: 10%; text-align: left; color:white">
                        <div style="text-align: center;">
                            <span style="font-weight: bold; font-size: 16px;">.</span>
                            <br>
                            <span style=" font-size: 15px;">..................................
                                {{-- <br>Tegal 52411 --}}
                            </span>
                            <br>
                            <span style=" font-size: 15px;">.</span>
                            <br>
                            <span style=" font-size: 15px;">.</span>
                        </div>
                    </td>
                </tr>
            </table>
            <hr style="border: 0.5px solid; margin-top:3px; margin-bottom: 1px; padding: 0;">
            <hr style="border: 0.5px solid; margin-top:1px; margin-bottom: 1px; padding: 0;">
        </div>
    </div>

    <div style="text-align: left; margin-top:7px">
        <table width="100%">
            <tr>
                <td style="width:60%;">
                    <table style="font-size: 12px;">
                        <tr>
                            <td class="info-column">
                                <span class="info-item" style="font-size: 12px;">No</span>
                            </td>
                            <td class="info-column">
                                <span class="info-titik" style="font-size: 12px;">:</span>
                            </td>
                            <td class="info-column">
                                <span class="info-item" style="font-size: 12px;">{{ $cetakpdf->kode_kontrak }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="info-column">
                                <span class="info-item" style="font-size: 12px;">Lampiran</span>
                            </td>
                            <td class="info-column">
                                <span class="info-titik" style="font-size: 12px;">:</span>
                            </td>
                            <td class="info-column">
                                <span class="info-item" style="font-size: 12px;">-</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="info-column">
                                <span class="info-item" style="font-size: 12px;">Hal</span>
                            </td>
                            <td class="info-column">
                                <span class="info-titik" style="font-size: 12px;">:</span>
                            </td>
                            <td class="info-column">
                                <span class="info-item" style="font-size: 12px; font-weight:bold">Pengajuan Harga</span>
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="width: 70%; text-align: left;">
                </td>
            </tr>
        </table>
    </div>
    <br>
    <div style="text-align: left; margin-top:0px">
        <span style="font-size: 12px">Kepada Yth.</span>
        <br>
        <span style="font-weight: bold; font-size: 12px;">{{ $cetakpdf->pelanggan->nama_pell ?? null }}</span>
        <br>
        <span style="font-size: 12px; display: block; max-width: 45%; word-wrap: break-word;">
            {{ $cetakpdf->pelanggan->alamat ?? null }}
        </span>
    </div>
    <br>
    <div style="text-align: left; margin-top:0px">
        <span style="font-size: 12px; display: block; word-wrap: break-word;">
            Bersama ini kami PT. JAVA LINE LOGISTICS ingin mengajukan harga untuk rute berikut :
        </span>
    </div>
    {{-- <div style="text-align: center;">
        <span style="font-weight: bold; font-size: 16px;">KONTRAK RUTE</span>
    </div> --}}
    <hr style="border-top: 0.1px solid black; margin: 5px 0;">
    <table style="width: 100%;" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td" style="text-align: left; padding: 0px; font-size: 12px; width:40px">No.</td>
            <td class="td" style="text-align: left; padding: 0px; font-size: 12px;">Rute</td>
            <td class="td" style="text-align: right; padding: 0px; font-size: 12px;">Harga</td>
        </tr>
        <!-- Add horizontal line below this row -->
        <tr>
            <td colspan="6" style="padding: 0px;">
                <hr style="border-top: 0.1px solid black; margin: 5px 0;">
            </td>
        </tr>
        @foreach ($details as $item)
            <tr>
                <td class="td" style="text-align: left; padding: 2px; font-size: 12px;">
                    {{ $loop->iteration }}
                </td>
                <td class="td" style="text-align: left; padding: 2px; font-size: 12px;">
                    {{ $item->nama_tarif }} </td>

                <td class="td" style="text-align: right; padding: 2px; font-size: 12px;">
                    {{ number_format($item->nominal, 2, ',', '.') }}

                </td>
            </tr>
        @endforeach
        <tr style="border-bottom: 1px solid black;">
            <td colspan="6"></td>
        </tr>
    </table>
    <div>
        <p style="font-size: 12px">NB :</p>
    </div>
    <div
        style="font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif; font-size: 12px; margin-left:18px">
        <table>
            <tr>
                <td> <img style="margin-top: 0px" src="{{ public_path('storage/uploads/gambar_logo/arrows.png') }}"
                        width="8" height="8"></td>
                <td>
                    <div style="margin-left: 12px">
                        Dengan asumsi harga bahan bakar minyak Rp. 6.800,-
                    </div>
                </td>
            </tr>
            <tr>
                <td> <img style="margin-top: 0px" src="{{ public_path('storage/uploads/gambar_logo/arrows.png') }}"
                        width="8" height="8"></td>
                <td>

                    <div style="margin-left: 12px">
                        Muatan Tronton Box/Wing Box
                    </div>
                </td>
            </tr>
            <tr>
                <td> <img style="margin-top: 0px" src="{{ public_path('storage/uploads/gambar_logo/arrows.png') }}"
                        width="8" height="8"></td>
                <td>
                    <div style="margin-left: 12px">
                        Tarif tersebut tidak termasuk biaya premi asuransi pengiriman barang. Kami bertanggung jawab
                        atas kerusakan barang yang disebabkan oleh factor kelalaian pihak kami misalnya barang basah
                        karena wingbox / Box / Terpal bocor, barang rusak karena jatuh, barang kurang / hilang.
                    </div>
                </td>
            </tr>
            <tr>
                <td> <img style="margin-top: 0px" src="{{ public_path('storage/uploads/gambar_logo/arrows.png') }}"
                        width="8" height="8"></td>
                <td>
                    <div style="margin-left: 12px">
                        Tarif tersebut tidak termasuk ongkos kuli muat maupun bongkar di gudang pengiriman / penerima
                        (Upah kuli BM)
                    </div>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <div style="margin-left: 12px">
                        Jika alamat bongkar lebih dari satu alamat tetapi dalam wilayah yang sama maka dikenakan
                        tambahan biaya sebesar Rp. 350.000,-
                    </div>
                </td>
            </tr>
            <tr>
                <td> <img style="margin-top: 0px" src="{{ public_path('storage/uploads/gambar_logo/arrows.png') }}"
                        width="8" height="8"></td>
                <td>
                    <div style="margin-left: 12px">
                        Kami tidak bertanggung jawab atas kerusakan, kehilangan dan kekurangan barang yang disebabkan
                        oleh factor Force Majeur, bencana alam dan hal hal yang diluar kemampuan manusia.
                    </div>
                </td>
            </tr>
            <tr>
                <td> <img style="margin-top: 0px" src="{{ public_path('storage/uploads/gambar_logo/arrows.png') }}"
                        width="8" height="8"></td>
                <td>
                    <div style="margin-left: 12px">
                        Pembayaran maksimal 30 hari setelah invoice diterima. Pembayaran dilaksanakan lewat transfer
                        bank BCA ke No. Rekening <span style="font-weight: bold">
                            3620567000 an. PT. Java Line Logistics
                        </span>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <div>
        <p style="font-size: 12px">Demikian surat pengajuan harga ini kami sampaikan, atas perhatian dan kerjasamanya
            kami ucapkan terimakasih.</p>
    </div>
    <table width="100%">
        <tr style="font-size: 12px">
            <td style="width: 30%;">
                <table class="tdd" cellpadding="10" cellspacing="0" style="margin: 0 auto;">
                    <tr>
                        <td style="text-align: center;">
                            <table style="margin: 0 auto;">
                                <tr style="text-align: center;">
                                    <td class="label">
                                        <span class="info-item" style="font-size: 12px; padding-right:0px">
                                            Tegal,
                                            {{ \Carbon\Carbon::parse($cetakpdf->tanggal)->locale('id')->isoFormat('D MMMM YYYY') }}
                                        </span>
                                        <br>
                                        <span class="info-item"
                                            style="font-size: 12px; padding-right:0px; font-weight:bold">
                                            PT. JAVA LINE LOGISTICS
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="color:white" class="">.</td>
                                </tr>
                                <tr>
                                    <td style="color:white" class="">.</td>
                                </tr>
                                <tr>
                                    <td style="color:white" class="">.</td>
                                </tr>
                                <tr>
                                    <td style="color:white" class="">.</td>
                                </tr>
                                <tr>
                                    <td style="color:white" class="">.</td>
                                </tr>
                                <tr>
                                    <td style="color:white" class="">.</td>
                                </tr>
                                <tr>
                                    <td style="color:white" class="">.</td>
                                </tr>
                                <tr>
                                </tr>
                                <tr style="text-align: center;">
                                    <td class="label">
                                        <span class="info-item"
                                            style="font-size: 12px; padding-right:0px;  font-weight:bold">
                                            Djohan Wahyudi
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>

            <td style="width: 30%;">
                <table class="tdd" cellpadding="10" cellspacing="0" style="margin: 0 auto;">
                    <tr>
                        <td style="text-align: center;">
                            <table style="margin: 0 auto;">
                                <tr style="text-align: center;">
                                    <td class="label">
                                        <span class="info-item" style="font-size: 12px; padding-right:0px">

                                        </span>
                                        <br>
                                        <span class="info-item"
                                            style="font-size: 12px; padding-right:0px; font-weight:bold">
                                            {{ $cetakpdf->pelanggan->nama_pell ?? null }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="color:white" class="">.</td>
                                </tr>
                                <tr>
                                    <td style="color:white" class="">.</td>
                                </tr>
                                <tr>
                                    <td style="color:white" class="">.</td>
                                </tr>
                                <tr>
                                    <td style="color:white" class="">.</td>
                                </tr>
                                <tr>
                                    <td style="color:white" class="">.</td>
                                </tr>
                                <tr>
                                    <td style="color:white" class="">.</td>
                                </tr>
                                <tr>
                                    <td style="color:white" class="">.</td>
                                </tr>
                                <tr>
                                </tr>
                                <tr style="text-align: center;">
                                    <td class="label">
                                        <span class="info-item"
                                            style="font-size: 12px; padding-right:0px;  font-weight:bold">
                                            (................................)
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
