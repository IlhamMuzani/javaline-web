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
            font-family: 'DOSVGA', Arial, Helvetica, sans-serif;
            /* font-family: 'DOSVGA', monospace; */
            color: black;

            margin-top: 5px;
            margin-right: 14px;
            margin-left: 14px;
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
            padding: 14px 20px;
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
    </style>
</head>


<body style="margin-top: 90; padding: 0;">
    <div class="welcome-text">
        <div class="header">
            <table width="100%">
                <tr>
                    <td style="width:20%;">
                        <div style="text-align: left;">
                            <img src="{{ asset('storage/uploads/user/logo.png') }}" alt="JAVA LINE" width="160"
                                height="60">
                        </div>
                    </td>
                    <td style="width: 95%; text-align: left;">
                        <div style="text-align: center;">
                            <span style="font-weight: bold; font-size: 18px;">PT JAVA LINE LOGISTICS</span>
                            <br>
                            <span style=" font-size: 15;">JL. HOS COKRO AMINOTO NO 5 SLAWI TEGAL
                                {{-- <br>Tegal 52411 --}}
                            </span>
                            <br>
                            <span style=" font-size: 15;">Telp / Fax, 02836195328 02838195187</span>
                            <br>
                            <span style=" font-size: 15;">Email : marketing2.javalinelogistics@gmail.com</span>
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
                <td style="width:40%;">
                    <table style="font-weight: bold; font-size: 14px;">
                        <tr>
                            <td class="info-column">
                                <span class="info-item" style="font-size: 14px;">No Invoice</span>
                            </td>
                            <td class="info-column">
                                <span class="info-titik" style="font-size: 14px;">:</span>
                            </td>
                            <td class="info-column">
                                <span class="info-item" style="font-size: 14px;">{{ $cetakpdf->kode_tagihan }}</span>
                            </td>
                        </tr>
                        {{-- <tr>
                            <td class="info-column">
                                <span class="info-item" style="font-size: 14px;">Periode</span>
                            </td>
                            <td class="info-column">
                                <span class="info-titik" style="font-size: 14px;">:</span>
                            </td>
                            <td class="info-column">
                                <span class="info-item" style="font-size: 14px;">
                                    {{ \Carbon\Carbon::parse($cetakpdf->periode_awal)->locale('id')->isoFormat('D MMMM') .
                                        ' - ' .
                                        \Carbon\Carbon::parse($cetakpdf->periode_akhir)->locale('id')->isoFormat('D MMMM YYYY') }}
                                </span>
                            </td>

                        </tr> --}}
                        {{-- <tr>
                            <td class="info-column">
                                <span class="info-item" style="font-size: 14px;">No. Aproval</span>
                            </td>
                            <td class="info-column">
                                <span class="info-titik" style="font-size: 14px;">:</span>
                            </td>
                            <td class="info-column">
                                <span class="info-item" style="font-size: 14px;"></span>
                            </td>
                        </tr> --}}
                    </table>
                </td>
                <td style="width: 70%; text-align: left;">
                </td>
            </tr>
        </table>
    </div>

    <div style="text-align: left; margin-top:0px">
        <span style="font-size: 14px">Kepada Yth.</span>
        <br>
        <span style="font-weight: bold; font-size: 14px;">{{ $cetakpdf->nama_pelanggan }}</span>
        <br>
        <span style="font-size: 14px; display: block; max-width: 45%; word-wrap: break-word;">
            {{ $cetakpdf->alamat_pelanggan }}
        </span>
    </div>
    {{-- <div style="text-align: left;">
        <table width="100%">
            <tr>
                <td style="width:80%;">
                    <table>
                        <tr>
                            <td>
                                <span style="font-size: 14px;">{{ $cetakpdf->alamat_pelanggan }}</span>
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="width: 70%; text-align: left;">
                </td>
            </tr>
        </table>
    </div> --}}

    <div style="text-align: center;">
        <span style="font-weight: bold; font-size: 18px;">INVOICE FAKTUR EKSPEDISI</span>
    </div>
    {{-- <div style="text-align: center; margin-top:8px">
        <span style="font-size: 14px;">Jasa Pengiriman Barang <span
                style="font-weight: bold;">{{ $cetakpdf->nama_pelanggan }}</span></span>
    </div>
    <div style="text-align: center;">
        <span style="font-size: 14px;">Daftar Rincian Sebagai Berikut :</span>
    </div> --}}
    <table style="width: 100%; border-top: 1px solid #000; margin-top:5px" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td" style="text-align: center; padding: 0px; font-size: 14px;  font-weight:bold; width:3%">
                No.</td>
            <td class="td" style="text-align: left; padding: 0px; font-size: 14px;  font-weight:bold; width:25%">
                Rute</td>
            <td class="td" style="text-align: left; padding: 0px; font-size: 14px;  font-weight:bold; width:10%">
                Tgl. SJ</td>
            <td class="td" style="text-align: left; padding: 0px; font-size: 14px;  font-weight:bold; width:13%">No.
                Faktur</td>
            <td class="td" style="text-align: left; padding: 2px; font-size: 14px;  font-weight:bold; width:14%">
                No. SJ</td>
            {{-- <td class="td" style="text-align: left; padding: 0px; font-size: 14px;  font-weight:bold; width:12%">No.
                PO</td> --}}
            <td class="td" style="text-align: left; padding: 0px; font-size: 14px;  font-weight:bold; width:9%">No.
                Mobil</td>
            <td class="td" style="text-align: left; padding: 0px; font-size: 14px;  font-weight:bold; width:8%">Qty
            </td>
            <td class="td" style="text-align: right; font-size: 14px;  font-weight:bold; width:10%">Harga</td>
            <td class="td" style="text-align: right; font-size: 14px;  font-weight:bold; width:10%">Total</td>
        </tr>
        <!-- Add horizontal line below this row -->
        <tr>
            <td colspan="10" style="padding: 0px;">
                <hr style="border: 0.5px solid; margin-top:3px; margin-bottom: 1px; padding: 0;">
                <hr style="border: 0.5px solid; margin-top:1px; margin-bottom: 1px; padding: 0;">
            </td>
        </tr>
        @php
            $totalRuteSum = 0;
        @endphp
        @foreach ($details as $item)
            <tr>
                <td class="td" style="text-align: center; padding: 0px; font-size: 14px;">
                    {{ $loop->iteration }}
                </td>
                <td class="td" style="text-align: left; padding: 2px; font-size: 14px;">
                    {{ substr($item->nama_rute, 0, 28) }}
                </td>

                <td class="td" style="text-align: left; padding: 0px; font-size: 14px;">
                    {{ $item->tanggal_memo }}
                </td>
                <td class="td" style="text-align: left; padding: 0px; font-size: 14px;">
                    {{ $item->kode_faktur }}
                </td>
                <td class="td" style="text-align: left; padding: 0px; font-size: 14px;">
                    {{ substr($item->no_do, 0, 20) }}
                </td>
                {{-- <td class="td" style="text-align: left; padding: 0px; font-size: 14px;">
                    {{ $item->no_po }}
                </td> --}}
                <td class="td" style="text-align: left; padding: 1px; font-size: 14px;">
                    @if ($item->faktur_ekspedisi)
                        @if ($item->faktur_ekspedisi->kendaraan)
                            {{ $item->faktur_ekspedisi->kendaraan->no_pol }}
                        @else
                            {{ $item->faktur_ekspedisi->no_pol }}
                        @endif
                    @else
                        -
                    @endif
                </td>
                <td class="td" style="text-align: left; padding: 1px; font-size: 14px;">
                    {{ number_format($item->jumlah, 2, ',', '.') }} {{ $item->satuan }}
                </td>
                <td class="td" style="text-align: right; padding-right: 7px; font-size: 14px;">
                    {{ number_format($item->harga, 2, ',', '.') }}
                </td>
                <td class="td" style="text-align: right; font-size: 14px;">
                    @if ($item->faktur_ekspedisi)
                        @if ($item->faktur_ekspedisi->biaya_tambahan != 0)
                            {{ number_format($item->faktur_ekspedisi->total_tarif, 0, ',', '.') }},00
                        @else
                            {{ number_format($item->total, 0, ',', '.') }},00
                        @endif
                    @else
                        {{ number_format($item->total, 0, ',', '.') }},00
                    @endif
                </td>
            </tr>
            @php
                $totalRuteSum += $item->total;
            @endphp

            @foreach ($item->faktur_ekspedisi->detail_tariftambahan as $detail_tariftambahan)
                <tr>
                    <td class="td" style="text-align: center; padding: 0px; font-size: 14px;">
                        {{-- {{ $loop->iteration + 1 }} --}}
                    </td>
                    <td class="td"
                        style="text-align: left; padding: 2px; font-size: 14px; text-transform: uppercase;">
                        {{ $detail_tariftambahan->keterangan_tambahan }}
                    </td>
                    <td class="td" style="text-align: left; padding: 0px; font-size: 14px;">
                        {{ $item->tanggal_memo }}
                    </td>
                    <td class="td" style="text-align: left; padding: 0px; font-size: 14px;">
                        {{ $item->kode_faktur }}
                    </td>
                    <td class="td" style="text-align: left; padding: 0px; font-size: 14px;">
                        {{ $item->no_do }}
                    </td>
                    {{-- <td class="td" style="text-align: left; padding: 0px; font-size: 14px;">
                    {{ $item->no_po }}
                </td> --}}
                    <td class="td" style="text-align: left; padding: 1px; font-size: 14px;">
                        {{ $item->no_pol }}
                    </td>
                    <td class="td" style="text-align: left; padding: 1px; font-size: 14px;">
                        {{ number_format($detail_tariftambahan->qty_tambahan, 2, ',', '.') }}
                        {{ $detail_tariftambahan->satuan_tambahan }}
                    </td>
                    <td class="td" style="text-align: right; padding-right: 7px; font-size: 14px;">
                        {{ number_format($detail_tariftambahan->nominal_tambahan, 2, ',', '.') }}
                    </td>
                    <td class="td" style="text-align: right; font-size: 14px;">
                        {{ number_format($detail_tariftambahan->nominal_tambahan, 2, ',', '.') }}
                    </td>
                </tr>
                <!-- Add other columns you want to display -->
            @endforeach
        @endforeach


        <tr>
        </tr>
    </table>
    <table style="width: 100%; border-top: 1px solid #000;">
        <tr>
            <td>

            </td>
            <td style="text-align: right;font-size: 14px;  font-weight:bold">
                {{ number_format($totalRuteSum, 0, ',', '.') }},00
            </td>
        </tr>
    </table>

    <table style="width: 100%;" cellpadding="2" cellspacing="0">
        <tr style="color: white">
            <td class="td" style="text-align: center; padding: 0px; font-size: 14px;">No.</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 14px;">Nama Tarif</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 14px;">Harga</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 14px;">Qty</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 14px;">Satuan</td>
            <td class="td" style="text-align: right; padding-right: 23px; font-size: 14px;">Total</td>
        </tr>
        <!-- Add horizontal line below this row -->

        <tr>
            <td class="td" style="text-align: center; padding: 0px; font-size: 14px;">

            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 14px;">

            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 14px;">

            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 14px;">

            </td>
            <td class="td" style="text-align: right; padding: 2px; font-size: 14px;">
                Dasar Pengenaan Pajak (DPP) :
            </td>
            <td class="td" style="text-align: right; font-size: 14px;  font-weight:bold">
                {{ number_format($totalRuteSum, 0, ',', '.') }},00
            </td>
        </tr>

        <tr>
            <td class="td" style="text-align: center; padding: 0px; font-size: 14px;">

            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 14px;">

            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 14px;">

            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 14px;">

            </td>
            <td class="td" style="text-align: right; padding: 2px; font-size: 14px;">
                PPH23 = 2% * Dasar Pengenaan Pajak :
            </td>
            <td class="td" style="text-align: right; font-size: 14px;  font-weight:bold">
                @if ($cetakpdf->kategori == 'PPH')
                    {{ number_format($cetakpdf->pph, 0, ',', '.') }},00
                @elseif ($cetakpdf->kategori == 'NON PPH')
                    0,00
                @endif
            </td>
        </tr>

        <tr style="color: white">
            <td class="td" style="text-align: center; padding: 0px; font-size: 14px;">
                .
            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 14px;">
                .
            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 14px;">
                .
            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 14px;">
                .
            </td>
            <td class="td" style="text-align: right; padding: 2px; font-size: 14px;">
                .
            </td>
            <td class="td" style="text-align: right; padding-right: 23px; font-size: 14px;">
                .
            </td>
        </tr>


        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td colspan="6"></td>
        </tr>
        <tr>
            <td class="td" style="text-align: center; padding: 0px; font-size: 14px;">

            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 14px;">

            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 14px;">

            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 14px;">

            </td>
            <td class="td" style="text-align: right; padding: 2px; font-size: 14px;">
                Grand Total :
            </td>
            <td class="td" style="text-align: right; font-size: 14px; font-weight:bold">
                {{ number_format($cetakpdf->grand_total, 0, ',', '.') }},00

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
    <div style="font-size: 14px">
        Terbilang : <span style="font-weight: bold; font-style: italic; margin-right:250px ">
            ({{ terbilang($cetakpdf->grand_total) }}
            Rupiah)
        </span>
    </div>

    <br>


    <table width="100%">
        <tr style="font-size: 12px">
            <td style="width:60%;">
                <div>
                    Pembayaran :
                    <br>
                    @if ($cetakpdf->kategori == 'PPH')
                        Bank BCA No. Rek. 3620567000. PT. Java Line Logistics
                    @else
                        Bank BCA No. Rek. 3620488886. a.n Djohan Wahyudi
                    @endif
                    <br>
                    <span style="color: white">.
                    </span>
                    <br>
                    <span style="color: white">.
                    </span>
                    <br>
                    <span style="color: white">.
                    </span>
                    <br>
                    <span style="color: white">.
                    </span>
                    <br>
                    <span style="color: white">.
                    </span>
                    <span style="color: white">.
                    </span>
                    <br>
                </div>
            </td>
            <td style="width: 30%; text-align: left;">
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
                                            style="font-size: 12px; padding-right:0px; margin-top:5px">
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
                                    <td class="separator" colspan="2"><span></span></td>
                                </tr>
                                <tr style="text-align: center;">
                                    <td class="label">
                                        <span class="info-item"
                                            style="font-size: 12px; padding-right:0px;  font-weight:bold">
                                            PT. JAVA LINE LOGISTICS
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
    {{-- <div style="text-align: right; font-size:14px; margin-top:25px">
        <span style="font-style: italic;">Printed Date {{ \Carbon\Carbon::now()->format('Y-m-d H:i:s') }}</span>
    </div> --}}
</body>

<div class="container">
    <a href="{{ url('admin/inquery_tagihanekspedisi') }}" class="blue-button">Kembali</a>
    <a href="{{ url('admin/tagihan_ekspedisi/cetak-pdf/' . $cetakpdf->id) }}" class="blue-button">Cetak</a>
</div>

</html>
