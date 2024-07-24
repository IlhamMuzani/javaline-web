<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Bukti Potong Pajak</title>
    <style>
        html,
        body {
            font-family: 'DOSVGA', Arial, Helvetica, sans-serif;
            color: black;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .td {
            text-align: center;
            padding: 5px;
            font-size: 12px;
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


        .info-catatan2 {
            font-weight: bold;
            margin-right: 5px;
            min-width: 120px;
            /* Menetapkan lebar minimum untuk kolom pertama */
        }

        .alamat,
        .nama-pt {
            color: black;
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

        @page {
            /* size: A4; */
            margin: 1cm;
        }
    </style>
</head>

<body style="margin: 0; padding: 0;">
    <div id="logo-container">
        <img src="{{ public_path('storage/uploads/user/logo.png') }}" alt="JAVA LINELOGISTICS" width="150"
            height="50">
    </div>
    <div style="font-weight: bold; text-align: center">
        @php
            $startDate = request()->query('tanggal_awal');
            $endDate = request()->query('tanggal_akhir');
            $kategori = request()->query('kategori');
            $status = request()->query('status');
            $status_terpakai = request()->query('status_terpakai');
            $pelanggan_id = request()->query('pelanggan_id');
        @endphp
        <span style="font-weight: bold; font-size: 18px;">LAPORAN INVOICE EKSPEDISI - RANGKUMAN</span>
        <br>
        <div class="text">
            @if ($startDate && $endDate)
                <p>Periode:{{ $startDate }} s/d {{ $endDate }}</p>
            @else
                <p>Periode: Tidak ada tanggal awal dan akhir yang diteruskan.</p>
            @endif
        </div>
        <table width="100%">
            <tr>
                <td>
                    <div class="info-catatan" style="max-width: 570px;">
                        <table>
                            <tr>
                                <td class="info-catatan2" style="font-size: 13px;">Nama Pelanggan</td>
                                <td class="info-item" style="font-size: 13px;">:</td>
                                <td class="info-text info-left" style="font-size: 13px;">
                                    @if ($pelanggan_id == null)
                                        All Pelanggan
                                    @else
                                        {{ $pelanggans->nama_pell }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="info-catatan2" style="font-size: 13px;">Status Pelunasan</td>
                                <td class="info-item" style="font-size: 13px;">:</td>
                                <td class="info-text info-left" style="font-size: 13px;">
                                    @if ($status == 'selesai')
                                        Lunas
                                    @else
                                        Belum Lunas
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="info-catatan2" style="font-size: 13px;">Status Potong Pajak</td>
                                <td class="info-item" style="font-size: 13px;">:</td>
                                <td class="info-text info-left" style="font-size: 13px;">
                                    @if ($status_terpakai == 'digunakan')
                                        Sudah Ada Bukti Potong
                                    @else
                                        Belum Ada Bukti Potong
                                    @endif
                                </td>
                            </tr>

                        </table>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    {{-- <hr style="border-top: 0.1px solid black; margin: 1px 0;"> --}}

    </div>
    {{-- <hr style="border-top: 0.1px solid black; margin: 1px 0;"> --}}
    <table style="width: 100%; border-top: 1px solid black;" cellpadding="2" cellspacing="0">
        <!-- Header row -->
        <tr>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 12px; width:3%">No.
            </td>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 12px; width:10%">Kode
                Invoice
            </td>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 12px; width:10%">
                Tanggal
            </td>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 12px; width:10%">
                Tanggal
                Pelunasan
            </td>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 12px;width:27%">Nama
                Pelanggan
            </td>
            <td class="td" style="text-align: right; padding: 5px; font-weight:bold; font-size: 12px; width:10%">DPP
            </td>
            <td class="td" style="text-align: right; padding: 5px; font-weight:bold; font-size: 12px; width:20%">PPH
            </td>
        </tr>
        <!-- Separator row -->
        <tr style="border-bottom: 1px solid black;">
            <td colspan="6" style="padding: 0px;"></td>
        </tr>
        <!-- Data rows -->
        @foreach ($inquery as $item)
            <tr>
                <td class="td" style="text-align: left; padding: 5px; font-size: 12px;">{{ $loop->iteration }}
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 12px;">{{ $item->kode_tagihan }}
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 12px;">{{ $item->tanggal_awal }}
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 12px;">
                    @if ($item->faktur_pelunasan->first())
                        {{ $item->faktur_pelunasan->first()->tanggal_transfer }}
                    @else
                        -
                    @endif
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 12px;">{{ $item->nama_pelanggan }}
                </td>
                <td class="td" style="text-align: right; padding: 5px; font-size: 12px;">
                    {{ number_format($item->sub_total, 2, ',', '.') }}
                </td>
                <td class="td" style="text-align: right; padding: 5px; font-size: 12px;">
                    {{ number_format($item->pph, 2, ',', '.') }}
                </td>
            </tr>
        @endforeach
        <!-- Separator row -->
        <tr style="border-bottom: 1px solid black;">
            <td colspan="" style="padding: 0px;"></td>
        </tr>
        <!-- Subtotal row -->
        @php
            $total = 0;
        @endphp
        @foreach ($inquery as $item)
            @php
                $total += $item->grand_total;
            @endphp
        @endforeach
        <tr>
            <td colspan="7" style="text-align: right; font-weight: bold; padding: 5px; font-size: 12px;">
                {{ number_format($total, 0, ',', '.') }}
            </td>
            {{-- <td style="text-align: right; font-weight: bold; padding: 5px; font-size: 12px;">Rp.

            </td> --}}
        </tr>
    </table>
    <br>
    <br>
    <br>

</body>

</html>
