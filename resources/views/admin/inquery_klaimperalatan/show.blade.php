<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Klaim Peralatan</title>
    <style>
        html,
        body {
            font-family: Arial, sans-serif;
            color: black;
            padding: 20px
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
    <div id="logo-container">
        <img src="{{ asset('storage/uploads/user/logo.png') }}" alt="JAVA LINE" width="150" height="50">
    </div>
    <br>
    {{-- <hr style="border-top: 0.1px solid black; margin: 1px 0;"> --}}
    <table width="100%">
        <tr>
            <td style="width:50%;">
                <table>
                    <tr>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 15px;">Kode Driver</span>
                        </td>
                        <td class="info-column">
                            <span class="info-titik" style="font-size: 15px;">:</span>
                        </td>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 15px;">
                                @if ($klaim_peralatan->karyawan)
                                    {{ $klaim_peralatan->karyawan->kode_karyawan }}
                                @else
                                @endif
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 15px;">Nama Driver</span>
                        </td>
                        <td class="info-column">
                            <span class="info-titik" style="font-size: 15px;">:</span>
                        </td>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 15px;">
                                @if ($klaim_peralatan->karyawan)
                                    {{ $klaim_peralatan->karyawan->nama_lengkap }}
                                @else
                                @endif
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 15px;">Telp</span>
                        </td>
                        <td class="info-column">
                            <span class="info-titik" style="font-size: 15px;">:</span>
                        </td>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 15px;">
                                @if ($klaim_peralatan->karyawan)
                                    {{ $klaim_peralatan->karyawan->telp }}
                                @else
                                @endif
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 15px;">Saldo Deposit</span>
                        </td>
                        <td class="info-column">
                            <span class="info-titik" style="font-size: 15px;">:</span>
                        </td>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 15px;">
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
                            <span class="info-item" style="font-size: 15px;">No. Kabin</span>
                        </td>
                        <td class="info-column">
                            <span class="info-titik" style="font-size: 15px;">:</span>
                        </td>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 15px;">
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
                            <span class="info-item" style="font-size: 15px;">No . Registrasi</span>
                        </td>
                        <td class="info-column">
                            <span class="info-titik" style="font-size: 15px;">:</span>
                        </td>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 15px;">
                                @if ($klaim_peralatan->kendaraan)
                                    {{ $klaim_peralatan->kendaraan->no_pol }}
                                @else
                                @endif
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 15px;">Jenis Kendaraan</span>
                        </td>
                        <td class="info-column">
                            <span class="info-titik" style="font-size: 15px;">:</span>
                        </td>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 15px;">
                                @if ($klaim_peralatan->kendaraan)
                                    {{ $klaim_peralatan->kendaraan->jenis_kendaraan->nama_jenis_kendaraan }}
                                @else
                                @endif
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 15px;">Tanggal Klaim</span>
                        </td>
                        <td class="info-column">
                            <span class="info-titik" style="font-size: 15px;">:</span>
                        </td>
                        <td class="info-column">
                            <span class="info-item"
                                style="font-size: 15px;">{{ $klaim_peralatan->tanggal_klaim }}</span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    </div>
    <br>
    <div style="font-weight: bold; text-align: center">
        <span style="font-weight: bold; font-size: 22px;">SURAT KLAIM PERALATAN</span>
        <br>
        <br>
    </div>
    {{-- <hr style="border-top: 0.1px solid black; margin: 1px 0;"> --}}
    <table style="width: 100%; border-top: 1px solid black;" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td" style="text-align: center; padding: 5px; font-size: 15px;">No.</td>
            <td class="td" style="text-align: center; padding: 5px; font-size: 15px;">Kode Part</td>
            <td class="td" style="text-align: center; padding: 5px; font-size: 15px;">Nama Barang</td>
            <td class="td" style="text-align: center; padding: 5px; font-size: 15px;">Keterangan</td>
            <td class="td" style="text-align: center; padding: 5px; font-size: 15px;">Jumlah</td>
            <td class="td" style="text-align: center; padding: 5px; font-size: 15px;">Harga</td>
            <td class="td" style="text-align: right; padding: 5px; font-size: 15px;">Total</td>
        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td colspan="7" style="padding: 0px;"></td>
        </tr>
        @php
            $grandTotal = $details->sum('total');
        @endphp

        @foreach ($details as $item)
            <tr>
                <td class="td" style="text-align: center; padding: 5px; font-size: 15px;">{{ $loop->iteration }}
                </td>
                <td class="td" style="text-align: center; padding: 5px; font-size: 15px;">
                    {{ $item->sparepart->kode_partdetail }}</td>
                <td class="td" style="text-align: center; padding: 5px; font-size: 15px;">
                    {{ $item->sparepart->nama_barang }}</td>
                <td class="td" style="text-align: center; padding: 5px; font-size: 15px;">{{ $item->keterangan }}
                </td>
                <td class="td" style="text-align: center; padding: 5px; font-size: 15px;">{{ $item->jumlah }}
                </td>
                <td class="td" style="text-align: center; padding: 5px; font-size: 15px;">
                    {{ number_format($item->harga, 2, ',', '.') }}</td>
                <td class="td" style="text-align: right; padding: 5px; font-size: 15px;">
                    {{ number_format($item->total, 2, ',', '.') }}</td>
            </tr>
        @endforeach
        <tr style="border-bottom: 1px solid black;">
            <td colspan="7" style="padding: 0px;"></td>
        </tr>
        <tr>
            <td class="td" colspan="6" style="text-align: right; padding: 5px; font-size: 15px;">
            </td>
            <td class="td" style="text-align: right; padding: 5px; font-size: 15px;">
                {{ number_format($grandTotal, 2, ',', '.') }}</td>
        </tr>
        <tr>
            <td><br></td>
        </tr>
        <tr>
            <td class="td" colspan="6" style="text-align: right; padding: 5px; font-size: 15px;">Saldo Deposit
            </td>
            <td class="td" style="text-align: right; padding: 5px; font-size: 15px;">
                {{ number_format($klaim_peralatan->sisa_saldo, 2, ',', '.') }}
            </td>
        </tr>
        <tr>
            <td class="td" colspan="6" style="text-align: right; padding: 5px; font-size: 15px;">Nominal Klaim
            </td>
            <td class="td" style="text-align: right; padding: 5px; font-size: 15px;">
                {{ number_format($grandTotal, 2, ',', '.') }}</td>
        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td colspan="7" style="padding: 0px;"></td>
        </tr>
        <tr>
            <td class="td" colspan="6" style="text-align: right; padding: 5px; font-size: 15px;">Sisa Deposit
            </td>
            <td class="td" style="text-align: right; padding: 5px; font-size: 15px;">
                {{ number_format($klaim_peralatan->sisa_saldo - $grandTotal, 2, ',', '.') }}</td>
        </tr>
    </table>


    <br><br><br>

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
</body>

<div class="container">
    <a href="{{ url('admin/inquery_klaimperalatan') }}" class="blue-button">Kembali</a>
    <a href="{{ url('admin/klaim_peralatan/cetak-pdf/' . $klaim_peralatan->id) }}" class="blue-button">Cetak</a>
</div>

</html>
