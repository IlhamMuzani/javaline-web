<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Surat Klaim Peralatan</title>
    <style>
        html,
        body {
            font-family: Arial, sans-serif;
            color: black;
            margin: 15px
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
            font-size: 12px;
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
        <img src="{{ public_path('storage/uploads/user/logo.png') }}" alt="JAVA LINE LOGISTICS" width="150"
            height="50">
    </div>
    <table width="100%">
        <tr>
            <td style="width:50%;">
                <table>
                    <tr>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 12px;">Kode Driver</span>
                        </td>
                        <td class="info-column">
                            <span class="info-titik" style="font-size: 12px;">:</span>
                        </td>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 12px;">
                                @if ($klaim_peralatan->karyawan)
                                    {{ $klaim_peralatan->karyawan->kode_karyawan }}
                                @else
                                @endif
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 12px;">Nama Driver</span>
                        </td>
                        <td class="info-column">
                            <span class="info-titik" style="font-size: 12px;">:</span>
                        </td>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 12px;">
                                @if ($klaim_peralatan->karyawan)
                                    {{ $klaim_peralatan->karyawan->nama_lengkap }}
                                @else
                                @endif
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 12px;">Telp</span>
                        </td>
                        <td class="info-column">
                            <span class="info-titik" style="font-size: 12px;">:</span>
                        </td>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 12px;">
                                @if ($klaim_peralatan->karyawan)
                                    {{ $klaim_peralatan->karyawan->telp }}
                                @else
                                @endif
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 12px;">Saldo Deposit</span>
                        </td>
                        <td class="info-column">
                            <span class="info-titik" style="font-size: 12px;">:</span>
                        </td>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 12px;">
                                {{ number_format($klaim_peralatan->sisa_saldo, 2, ',', '.') }}
                            </span>
                        </td>
                    </tr>
                </table>
            </td>
            <td style="width:50%;">
                <table>
                    <tr>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 12px;">No. Kabin</span>
                        </td>
                        <td class="info-column">
                            <span class="info-titik" style="font-size: 12px;">:</span>
                        </td>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 12px;">
                                @if ($klaim_peralatan->kendaraan)
                                    {{ $klaim_peralatan->kendaraan->no_kabin }}
                                @else
                                    NON KENDARAAN
                                @endif
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 12px;">No . Registrasi</span>
                        </td>
                        <td class="info-column">
                            <span class="info-titik" style="font-size: 12px;">:</span>
                        </td>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 12px;">
                                @if ($klaim_peralatan->kendaraan)
                                    {{ $klaim_peralatan->kendaraan->no_pol }}
                                @else
                                @endif
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 12px;">Jenis Kendaraan</span>
                        </td>
                        <td class="info-column">
                            <span class="info-titik" style="font-size: 12px;">:</span>
                        </td>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 12px;">
                                @if ($klaim_peralatan->kendaraan)
                                    {{ $klaim_peralatan->kendaraan->jenis_kendaraan->nama_jenis_kendaraan }}
                                @else
                                @endif
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 12px;">Tanggal Klaim</span>
                        </td>
                        <td class="info-column">
                            <span class="info-titik" style="font-size: 12px;">:</span>
                        </td>
                        <td class="info-column">
                            <span class="info-item"
                                style="font-size: 12px;">{{ \Carbon\Carbon::parse($klaim_peralatan->tanggal_klaim)->locale('id')->isoFormat('D MMMM YYYY') }}</span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <div style="font-weight: bold; text-align: center; margin-top:7px;">
        <span style="font-weight: bold; font-size: 18px;">SURAT KLAIM PERALATAN</span>
    </div>
    {{-- <hr style="border-top: 0.1px solid black; margin: 1px 0;"> --}}
    <table style="width: 100%; border-top: 1px solid black; margin-top:7px;" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td" style="text-align: center; padding: 5px; font-size: 12px;">No.</td>
            <td class="td" style="text-align: left; padding: 5px; font-size: 12px;">Kode Part</td>
            <td class="td" style="text-align: left; padding: 5px; font-size: 12px;">Nama Barang</td>
            <td class="td" style="text-align: left; padding: 5px; font-size: 12px;">Keterangan</td>
            <td class="td" style="text-align: right; padding: 5px; font-size: 12px;">Jumlah</td>
            <td class="td" style="text-align: right; padding: 5px; font-size: 12px;">Harga</td>
            <td class="td" style="text-align: right; padding: 5px; font-size: 12px;">Total</td>
        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td colspan="7" style="padding: 0px;">
            </td>
        </tr>
        @php
            $grandTotal = $details->sum('total');
        @endphp
        @foreach ($details as $item)
            <tr>
                <td class="td" style="text-align: center; padding: 5px; font-size: 12px;">{{ $loop->iteration }}
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 12px;">
                    {{ $item->sparepart->kode_partdetail }}
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 12px;">
                    {{ $item->sparepart->nama_barang }}
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 12px;">{{ $item->keterangan }}
                </td>
                <td class="td" style="text-align: right; padding: 5px; font-size: 12px;">
                    {{ $item->jumlah }}</td>
                <td class="td" style="text-align: right; padding: 5px; font-size: 12px;">
                    {{ number_format($item->harga, 2, ',', '.') }}</td>
                <td class="td" style="text-align: right; padding: 5px; font-size: 12px;">
                    {{ number_format($item->total, 2, ',', '.') }}</td>
            </tr>
        @endforeach
        <tr style="border-bottom: 1px solid black;">
            <td colspan="8" style="padding: 0px;">
            </td>
        </tr>
        <tr>
            <td class="td" colspan="6" style="text-align: right; padding: 5px; font-size: 12px;">
            </td>
            <td class="td" style="text-align: right; padding: 5px; font-size: 12px;">
                {{ number_format($grandTotal, 2, ',', '.') }}</td>
        </tr>
        <tr>
            <td><br></td>
        </tr>
        <tr>
            <td class="td" colspan="6" style="text-align: right; padding: 5px; font-size: 12px;">Saldo Deposit
            </td>
            <td class="td" style="text-align: right; padding: 5px; font-size: 12px;">
                {{ number_format($klaim_peralatan->sisa_saldo, 2, ',', '.') }}
            </td>
        </tr>
        <tr>
            <td class="td" colspan="6" style="text-align: right; padding: 5px; font-size: 12px;">Nominal Klaim
            </td>
            <td class="td" style="text-align: right; padding: 5px; font-size: 12px;">
                {{ number_format($grandTotal, 2, ',', '.') }}</td>
        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td colspan="7" style="padding: 0px;"></td>
        </tr>
        <tr>
            <td class="td" colspan="6" style="text-align: right; padding: 5px; font-size: 12px;">Sisa Deposit
            </td>
            <td class="td" style="text-align: right; padding: 5px; font-size: 12px;">
                {{ number_format($klaim_peralatan->sisa_saldo - $grandTotal, 2, ',', '.') }}</td>
        </tr>
    </table>

    <br><br>

    <div style=" margin-top:12px; margin-bottom:27px; font-size:12px">
        <table class="tdd" cellpadding="10" cellspacing="0" style="margin: 0 auto;">
            <tr>
                <td style="text-align: center;">
                    <table style="margin: 0 auto;">
                        <tr style="text-align: center;">
                            <td class="label">{{ $klaim_peralatan->karyawan->nama_lengkap }}</td>
                        </tr>
                        <tr>
                            <td class="separator" colspan="2"><span></span></td>
                        </tr>
                        <tr style="text-align: center;">
                            <td class="label">Driver</td>
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
                            <td class="label">Finance</td>
                        </tr>
                    </table>
                </td>
                <td style="text-align: center;">
                    <table style="margin: 0 auto;">
                        <tr style="text-align: center;">
                            <td class="label">{{ auth()->user()->karyawan->nama_lengkap }}</td>
                        </tr>
                        <tr>
                            <td class="separator" colspan="2"><span></span></td>
                        </tr>
                        <tr style="text-align: center;">
                            <td class="label">Admin</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <div style="text-align: right; font-size:11px">
            <span style="font-style: italic;">Printed Date
                {{ \Carbon\Carbon::now()->format('Y-m-d H:i:s') }}</span>
        </div>
    </div>
</body>

</html>
