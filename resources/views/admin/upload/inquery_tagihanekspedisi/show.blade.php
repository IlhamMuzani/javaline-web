<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice Ekspedisi</title>
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
    <table width="100%">

        <tr>
            <!-- First column (Nama PT) -->
            <td style="width:0%;">
            </td>
            <td style="width: 70%; text-align: right;">
            </td>
        </tr>
    </table>

    <table width="100%">
        <tr>
            <td style="width:20%;">
                <div style="text-align: left;">
                    <img src="{{ asset('storage/uploads/gambar_logo/Logo.jpg') }}" alt="BAT" width="150"
                        height="75">
                </div>
            </td>
            <td style="width: 70%; text-align: left;">
                <div style="text-align: center;">
                    <span style="font-weight: bold; font-size: 25px;">PT BINA ANUGERAH TRANSINDO</span>
                    <br>
                    <span style=" font-size: 15px;">JL. HOS COKRO AMINOTO NO 5 SLAWI TEGAL
                        {{-- <br>Tegal 52411 --}}
                    </span>
                    <br>
                    <span style=" font-size: 15px;">Telp / Fax, 02836195328 02838195187</span>
                    <br>
                    <span style=" font-size: 15px;">Email : binaanugerah.transindo1@gmail.com</span>
                </div>
            </td>
            <td style="width: 90%; text-align: left; color:white">
                <div style="text-align: center;">
                    <span style="font-weight: bold; font-size: 25px;">.</span>
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
    <hr style="border: 0.5px solid; margin-top:3px; margin-bottom: 1px; padding: 0;">
    <div style="text-align: left; margin-top:10px">
        <span style="font-weight: bold; font-size: 16px;">No Invoice : <span>{{ $cetakpdf->kode_tagihan }}</span></span>
    </div>

    <div style="text-align: center;">
        <span style="font-weight: bold; font-size: 20px;">INVOICE FAKTUR EKSPEDISI</span>
    </div>
    {{-- <div style="text-align: center; margin-top:8px">
        <span style="font-size: 19px;">Jasa Pengiriman Barang <span
                style="font-weight: bold;">{{ $cetakpdf->nama_pelanggan }}</span></span>
    </div>
    <div style="text-align: center;">
        <span style="font-size: 19px;">Daftar Rincian Sebagai Berikut :</span>
    </div> --}}
    <br>
    <hr style="border: 1px solid;">
    <table style="width: 100%;" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">No.</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">Rute</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">tgl. Kirim</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">No. Faktur</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">No. DO</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">No. PO</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">No. Mobil</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">Qty</td>
            <td class="td" style="text-align: right; padding-right: 23px; font-size: 15px;">Harga</td>
            <td class="td" style="text-align: right; padding-right: 23px; font-size: 15px;">Total</td>
        </tr>
        <!-- Add horizontal line below this row -->
        <tr>
            <td colspan="10" style="padding: 0px;">
                <hr style="border-top: 1px solid black; margin: 5px 0;">
            </td>
        </tr>
        @php
            $totalRuteSum = 0;
        @endphp
        @foreach ($details as $item)
            <tr>
                <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">
                    {{ $loop->iteration }} </td>
                <td class="td" style="text-align: center; padding: 2px; font-size: 15px;">
                    {{ $item->nama_rute }}
                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">
                    {{ $item->tanggal_memo }}</td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">
                    {{ $item->kode_faktur }}
                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">
                    {{ $item->no_do }}
                </td>
                 <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">
                    {{ $item->no_po }}
                </td>
                <td class="td" style="text-align: center; padding: 2px; font-size: 15px;">
                    {{ $item->no_pol }}
                </td>
                <td class="td" style="text-align: center; padding: 2px; font-size: 15px;">
                    {{ $item->jumlah }} {{ $item->satuan }}
                </td>
                <td class="td" style="text-align: right; padding: 2px; font-size: 15px;">
                    {{ number_format($item->harga, 0, ',', '.') }}
                </td>
                <td class="td" style="text-align: right; padding-right: 23px; font-size: 15px;">
                    {{ number_format($item->total, 0, ',', '.') }}
                </td>
            </tr>
            @php
                $totalRuteSum += $item->total;
            @endphp
        @endforeach
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
            <td>
            </td>
            <td style="text-align: right; padding: 0px;">
                <span class="info-item" style="font-size: 15px; padding-right:24px">
                    {{ number_format($totalRuteSum, 0, ',', '.') }}
                </span>
            </td>
        </tr>
    </table>
    <br>

    <table style="width: 100%;" cellpadding="2" cellspacing="0">
        <tr style="color: white">
            <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">No.</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">Nama Tarif</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">Harga</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">Qty</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">Satuan</td>
            <td class="td" style="text-align: right; padding-right: 23px; font-size: 15px;">Total</td>
        </tr>
        <!-- Add horizontal line below this row -->

        @if ($cetakpdf->kategori == 'PPH')
            <tr>
                <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">

                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">

                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">

                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">

                </td>
                <td class="td" style="text-align: right; padding: 2px; font-size: 15px;">
                    DPP :
                </td>
                <td class="td" style="text-align: right; padding-right: 23px; font-size: 15px;">
                    {{ number_format($totalRuteSum, 0, ',', '.') }}
                </td>
            </tr>

            <tr>
                <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">

                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">

                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">

                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">

                </td>
                <td class="td" style="text-align: right; padding: 2px; font-size: 15px;">
                    PPH23 = 2% :
                </td>
                <td class="td" style="text-align: right; padding-right: 23px; font-size: 15px;">
                    {{ number_format($cetakpdf->pph, 0, ',', '.') }}
                </td>
            </tr>

            <tr style="color: white">
                <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">
                    .
                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">
                    .
                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">
                    .
                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">
                    .
                </td>
                <td class="td" style="text-align: right; padding: 2px; font-size: 15px;">
                    .
                </td>
                <td class="td" style="text-align: right; padding-right: 23px; font-size: 15px;">
                    .
                </td>
            </tr>
        @endif


        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td colspan="6"></td>
        </tr>
        <tr>
            <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">

            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">

            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">

            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">

            </td>
            <td class="td" style="text-align: right; padding: 2px; font-size: 15px;">
                Grand Total :
            </td>
            <td class="td" style="text-align: right; padding-right: 23px; font-size: 15px;">
                {{ number_format($cetakpdf->grand_total, 0, ',', '.') }}

            </td>
        </tr>

        <tr>
        </tr>
    </table>

    <?php
    function terbilang($angka)
    {
        $angka = abs($angka); // Pastikan angka selalu positif
        $bilangan = ['', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas'];
        $hasil = '';
        if ($angka < 12) {
            $hasil = $bilangan[$angka];
        } elseif ($angka < 20) {
            $hasil = terbilang($angka - 10) . ' Belas';
        } elseif ($angka < 100) {
            $hasil = terbilang($angka / 10) . ' Puluh ' . terbilang($angka % 10);
        } elseif ($angka < 200) {
            $hasil = 'Seratus ' . terbilang($angka - 100);
        } elseif ($angka < 1000) {
            $hasil = terbilang($angka / 100) . ' Ratus ' . terbilang($angka % 100);
        } elseif ($angka < 2000) {
            $hasil = 'Seribu ' . terbilang($angka - 1000);
        } elseif ($angka < 1000000) {
            $hasil = terbilang($angka / 1000) . ' Ribu ' . terbilang($angka % 1000);
        } elseif ($angka < 1000000000) {
            $hasil = terbilang($angka / 1000000) . ' Juta ' . terbilang($angka % 1000000);
        } elseif ($angka < 1000000000000) {
            $hasil = terbilang($angka / 1000000000) . ' Miliar ' . terbilang($angka % 1000000000);
        } elseif ($angka < 1000000000000000) {
            $hasil = terbilang($angka / 1000000000000) . ' Triliun ' . terbilang($angka % 1000000000000);
        }
        return $hasil;
    }
    ?>
    <div>
        Terbilang : <span style="font-weight: bold; font-style: italic;">
            ({{ terbilang($cetakpdf->grand_total) }}
            Rupiah)
        </span>
    </div>
    <br>
    <br>
    <br>

    {{-- <table style="width: 100%; margin-bottom:0px;">
        <tr>
            <td>
                vxcvxc
            </td>
            <td style="text-align: right; padding-right: 100px;">
                <span class="info-item" style="font-size: 15px; padding-right:24px">
                    Tegal, {{ $cetakpdf->tanggal }}
                </span>
                <br>
                <span class="info-item" style="font-size: 15px; padding-right:70px">
                    Mengetahui,
                </span>
            </td>
        </tr>
    </table> --}}
    <br>


    <table width="100%">
        <tr>
            <td style="width:60%;">
                <table class="tdd" cellpadding="10" cellspacing="0" style="margin: 0 auto; font-size: 15px;">
                    <tr>
                        <td>
                            Pembayaran <br>
                            <span>
                                Bank BCA No. Rek. 1319988899. PT. Bina Anugerah Transindo
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td style="color: white">
                            .
                        </td>
                    </tr>
                    <tr>
                        <td style="color: white">
                            .
                        </td>
                    </tr>
                    <tr>
                        <td style="color: white">
                            .
                        </td>
                    </tr>
                </table>
            </td>
            <td style="width: 70%; text-align: left;">
                <table class="tdd" cellpadding="10" cellspacing="0" style="margin: 0 auto;">
                    <tr>
                        <td style="text-align: center;">
                            <table style="margin: 0 auto;">
                                <tr style="text-align: center;">
                                    <td class="label">
                                        <span class="info-item" style="font-size: 15px; padding-right:24px">
                                            Tegal, {{ $cetakpdf->tanggal }}
                                        </span>
                                        <br>
                                        <span class="info-item" style="font-size: 15px; padding-right:40px">
                                            Mengetahui,
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
                                    <td class="separator" colspan="2"><span></span></td>
                                </tr>
                                <tr style="text-align: center;">
                                    <td class="label">
                                        <span class="info-item" style="font-size: 15px; padding-right:24px">
                                            BINA ANUGERAH TRANSINDO
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





    <br>
</body>

<div class="container">
    <a href="{{ url('admin/inquery_tagihanekspedisi') }}" class="blue-button">Kembali</a>
    <a href="{{ url('admin/tagihan_ekspedisi/cetak-pdf/' . $cetakpdf->id) }}" class="blue-button">Cetak</a>
</div>


</html>
