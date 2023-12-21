<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Memo Ekspedisi</title>
    <style>
        html,
        body {
            font-family: 'DOSVGA', Arial, Helvetica, sans-serif;
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
    </style>
</head>

<body style="margin: 0; padding: 0;">
    <table width="100%">
        <tr>
            <td style="width:10%;">
                <div style="text-align: left;">
                    <img src="{{ asset('storage/uploads/user/logo.png') }}" alt="Java Line" width="220"
                        height="80">
                </div>
            </td>
            <td style="width: 65%; text-align: left;">
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
            <td style="width: 90%; text-align: left; color:white">
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
    <div style="text-align: left; margin-top:10px">
        <span style="font-weight: bold; font-size: 13px;">No Faktur : <span>{{ $cetakpdf->kode_tagihan }}</span></span>
    </div>
    <div style="text-align: center;">
        <span style="font-weight: bold; font-size: 16px;">DAFTAR RINCIAN FAKTUR</span>
    </div>
    <div style="text-align: center; margin-top:8px">
        <span style="font-size: 13px;">Jasa Pengiriman Barang <span
                style="font-weight: bold;">{{ $cetakpdf->nama_pelanggan }}</span></span>
    </div>
    <div style="text-align: center;">
        <span style="font-size: 13px;">Daftar Rincian Sebagai Berikut :</span>
    </div>
    <br>
    <table style="width: 100%; border-top: 1px solid #000;" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">No.</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">No. SJ</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">Tgl. SJ</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">No. Faktur</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">Rute</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">No Registrasi</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">Qty</td>
            <td class="td" style="text-align: right; font-size: 12px;">harga</td>
            <td class="td" style="text-align: right; font-size: 12px;">Sub Total</td>
        </tr>
        <!-- Add horizontal line below this row -->
        <tr>
            <td colspan="9" style="padding: 0px;">
                <hr style="border: 0.5px solid; margin-top:3px; margin-bottom: 1px; padding: 0;">
                <hr style="border: 0.5px solid; margin-top:1px; margin-bottom: 1px; padding: 0;">
            </td>
        </tr>
        @php
            $totalRuteSum = 0;
        @endphp
        @foreach ($details as $item)
            <tr>
                <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">
                    {{ $loop->iteration }} </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">
                    {{ $item->no_memo }}
                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">
                    {{ $item->tanggal_memo }}</td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">
                    {{ $item->kode_faktur }}
                </td>
                <td class="td" style="text-align: center; padding: 2px; font-size: 12px;">
                    {{ $item->nama_rute }}
                </td>
                <td class="td" style="text-align: center; padding: 2px; font-size: 12px;">
                    {{ $item->no_pol }}
                </td>
                <td class="td" style="text-align: center; padding: 2px; font-size: 12px;">
                    {{ $item->jumlah }} {{ $item->satuan }}
                </td>
                <td class="td" style="text-align: right; padding: 2px; font-size: 12px;">
                    {{ number_format($item->harga, 0, ',', '.') }}
                </td>
                <td class="td" style="text-align: right; font-size: 12px;">
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
    <table style="width: 100%; border-top: 1px solid #000;">
        <tr>
            <td>

            </td>
            <td style="text-align: right;font-size: 12px;">
                {{ number_format($totalRuteSum, 0, ',', '.') }}
            </td>
        </tr>
    </table>

    <table style="width: 100%;" cellpadding="2" cellspacing="0">
        <tr style="color: white">
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">No.</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">Nama Tarif</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">Harga</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">Qty</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">Satuan</td>
            <td class="td" style="text-align: right; padding-right: 23px; font-size: 12px;">Total</td>
        </tr>
        <!-- Add horizontal line below this row -->

        <tr>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">

            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">

            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">

            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">

            </td>
            <td class="td" style="text-align: right; padding: 2px; font-size: 12px;">
                Dasar Pengenaan Pajak(DPP) :
            </td>
            <td class="td" style="text-align: right; font-size: 12px;">
                {{ number_format($totalRuteSum, 0, ',', '.') }}
            </td>
        </tr>

        <tr>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">

            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">

            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">

            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">

            </td>
            <td class="td" style="text-align: right; padding: 2px; font-size: 12px;">
                PPH23 = 2% * Dasar Pengenaan Pajak :
            </td>
            <td class="td" style="text-align: right; font-size: 12px;">
                @if ($cetakpdf->kategori == 'PPH')
                    {{ number_format($cetakpdf->pph, 0, ',', '.') }}
                @elseif ($cetakpdf->kategori == 'NON PPH')
                    0
                @endif
            </td>
        </tr>

        <tr style="color: white">
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">
                .
            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">
                .
            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">
                .
            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">
                .
            </td>
            <td class="td" style="text-align: right; padding: 2px; font-size: 12px;">
                .
            </td>
            <td class="td" style="text-align: right; padding-right: 23px; font-size: 12px;">
                .
            </td>
        </tr>


        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td colspan="6"></td>
        </tr>
        <tr>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">

            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">

            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">

            </td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">

            </td>
            <td class="td" style="text-align: right; padding: 2px; font-size: 12px;">
                Grand Total :
            </td>
            <td class="td" style="text-align: right; font-size: 12px;">
                {{ number_format($cetakpdf->grand_total, 0, ',', '.') }}

            </td>
        </tr>

        <tr>
        </tr>
    </table>

    <br>


    <table width="100%">
        <tr style="font-size: 12px">
            <td style="width:60%;">
                <div>
                    Pembayaran :
                    <br>
                    @if ($cetakpdf->kategori == 'PPH')
                        Bank BCA No. Rek. 3620567000. Java Line Logistics
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
                                            Tegal, {{ $cetakpdf->tanggal }}
                                        </span>
                                        <br>
                                        <span class="info-item" style="font-size: 12px; padding-right:40px">
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
                                        <span class="info-item" style="font-size: 12px; padding-right:24px">
                                            JAVA LINE
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

</html>
