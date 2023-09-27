<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Surat Pemasangan Ban</title>
    <style>
        html,
        body {
           font-family: 'DOSVGA', monospace;
            color: black;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .td {
            text-align: center;
            padding: 5px;
            font-size: 15px;
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
            padding-top: 15px;
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
    <br>
    <div style="font-weight: bold; text-align: center">
        <span style="font-weight: bold; font-size: 22px;">SURAT PEMASANGAN BAN</span>
        <br>
        <br>
    </div>
    {{-- <hr style="border-top: 0.1px solid black; margin: 1px 0;"> --}}

    <table style="width: 100%; border-top: 1px solid black;" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td" style="text-align: center; padding: 3px; font-size: 14px;">No.
                Kabin:{{ $kendaraan->no_kabin }}</td>
            <td class="td" style="text-align: center; padding: 3px; font-size: 14px;">Jenis
                Kendaraan:{{ $kendaraan->jenis_kendaraan->nama_jenis_kendaraan }}</td>
            <td class="td" style="text-align: center; padding: 3px; font-size: 14px;">Total
                Ban:{{ $kendaraan->jenis_kendaraan->total_ban }}</td>
            <td class="td" style="text-align: center; padding: 3px; font-size: 14px;">
                Tanggal:{{ Carbon\Carbon::now()->translatedFormat('d M Y') }}</td>
        </tr>
    </table>
    </div>
    {{-- <hr style="border-top: 0.1px solid black; margin: 1px 0;"> --}}
    <table style="width: 100%; border-top: 1px solid black;" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td" style="text-align: center; padding: 5px; font-size: 15px;">No.</td>
            <td class="td" style="text-align: center; padding: 5px; font-size: 15px;">Posisi Ban</td>
            <td class="td" style="text-align: center; padding: 5px; font-size: 15px;">Kode Ban</td>
            <td class="td" style="text-align: center; padding: 5px; font-size: 15px;">No. Seri</td>
            <td class="td" style="text-align: center; padding: 5px; font-size: 15px;">Ukuran</td>
            <td class="td" style="text-align: center; padding: 5px; font-size: 15px;">Merek</td>
            <td class="td" style="text-align: center; padding: 5px; font-size: 15px;">Kondisi</td>
            <td class="td" style="text-align: center; padding: 5px; font-size: 15px;">Km Pemasangan</td>
        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td colspan="7" style="padding: 0px;">
            </td>
        </tr>
        @foreach ($bans as $item)
            <tr>
                <td class="td" style="text-align: center; padding: 5px; font-size: 15px;">{{ $loop->iteration }}
                </td>
                <td class="td" style="text-align: center; padding: 5px; font-size: 15px;">
                    {{ $item->posisi_ban }}
                </td>
                <td class="td" style="text-align: center; padding: 5px; font-size: 15px;">{{ $item->kode_ban }}
                </td>
                <td class="td" style="text-align: center; padding: 5px; font-size: 15px;">{{ $item->no_seri }}
                </td>
                <td class="td" style="text-align: center; padding: 5px; font-size: 15px;">
                    {{ $item->ukuran->ukuran }}</td>
                <td class="td" style="text-align: center; padding: 5px; font-size: 15px;">
                    {{ $item->merek->nama_merek }}</td>
                <td class="td" style="text-align: center; padding: 5px; font-size: 15px;">
                    {{ $item->kondisi_ban }}
                </td>
                <td class="td" style="text-align: center; padding: 5px; font-size: 15px;">
                    {{ number_format($item->km_pemasangan, 0, ',', '.') }}
                </td>
            </tr>
        @endforeach
        <tr style="border-bottom: 1px solid black;">
            <td colspan="8" style="padding: 0px;">
            </td>
        </tr>
    </table>

    {{-- <br> --}}

    {{-- <table width="100%">
        <tr>
            <td>
                <div class="info-catatan" style="max-width: 230px;">
                    <table>
                        <tr>
                            <td class="info-catatan2" style="font-size: 15px;">Nama Supplier</td>
                            <td class="info-item" style="font-size: 15px;">:</td>
                            <td class="info-text info-left" style="font-size: 15px;">
                                {{ $pasang_ban->supplier->nama_bank }}
                            </td>
                        </tr>
                        <tr>
                            <td class="info-catatan2" style="font-size: 15px;">No. Rekening</td>
                            <td class="info-item" style="font-size: 15px;">:</td>
                            <td class="info-text info-left" style="font-size: 15px;">
                                {{ $pasang_ban->supplier->norek }}
                            </td>
                        </tr>
                        <tr>
                            <td class="info-catatan2" style="font-size: 15px;">Atas Nama</td>
                            <td class="info-item" style="font-size: 15px;">:</td>
                            <td class="info-text info-left" style="font-size: 15px;">
                                {{ $pasang_ban->supplier->atas_nama }}
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table> --}}

    <br>
    <br>

    <table class="tdd" cellpadding="10" cellspacing="0" style="margin: 0 auto;">
        <tr>
            <td style="text-align: center;">
                <table style="margin: 0 auto;">
                    <tr style="text-align: center;">
                        <td class="label">{{ auth()->user()->karyawan->nama_lengkap }}</td>
                    </tr>
                    <tr>
                        <td class="separator" colspan="2"><span></span></td>
                    </tr>
                    <tr style="text-align: center;">
                        <td class="label">Operasional</td>
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
                        <td class="label">SPV Ban</td>
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
                        <td class="label">Accounting</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</body>

</html>
