<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Surat Penggantian Oli</title>
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
            font-size: 13px;
            /* border: 1px solid black; */
        }

        .container {
            position: relative;
            /* margin-top: 7rem; */
        }

        .info-container {
            display: flex;
            justify-content: space-between;
            font-size: 15px;
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
            padding-top: 13px;
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
        <img src="{{ asset('storage/uploads/user/logo.png') }}" alt="Java Line" width="130" height="40">
    </div>
    <div style="font-weight: bold; text-align: center; margin-bottom:5px">
        <span style="font-weight: bold; font-size: 20px;">SURAT PENGGANTIAN OLI</span>
    </div>
    {{-- <hr style="border-top: 0.1px solid black; margin: 1px 0;"> --}}

    <table style="width: 100%; border-top: 1px solid black;" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td" style="text-align: center; padding: 3px; font-size: 15px;">No.
                Kabin:{{ $pemasangans->kendaraan->no_kabin }}</td>
            {{-- <td class="td" style="text-align: center; padding: 3px; font-size: 15px;">No.
                Registrasi:{{ $pemasangans->kendaraan->no_pol }}</td> --}}
            <td class="td" style="text-align: center; padding: 3px; font-size: 15px;">Jenis
                Kendaraan:{{ $pemasangans->kendaraan->jenis_kendaraan->nama_jenis_kendaraan }}</td>
            <td class="td" style="text-align: center; padding: 3px; font-size: 15px;">
                Tanggal:{{ $pemasangans->tanggal_penggantian }}</td>
        </tr>
    </table>
    </div>
    {{-- <hr style="border-top: 0.1px solid black; margin: 1px 0;"> --}}
    <table style="width: 100%; border-top: 1px solid black;" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td" style="text-align: left; padding: 5px; font-size: 13px;">No.</td>
            <td class="td" style="text-align: left; padding: 5px; font-size: 13px;">Kode Barang</td>
            <td class="td" style="text-align: left; padding: 5px; font-size: 13px;">Nama Barang</td>
            <td class="td" style="text-align: left; padding: 5px; font-size: 13px;">Qty</td>
            <td class="td" style="text-align: left; padding: 5px; font-size: 13px;">Km Penggantian</td>
            <td class="td" style="text-align: left; padding: 5px; font-size: 13px;">Km Berikutnya</td>
        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td colspan="7" style="padding: 0px;">
            </td>
        </tr>
        @foreach ($parts as $item)
            <tr>
                <td class="td" style="text-align: left; padding: 5px; font-size: 13px;">{{ $loop->iteration }}
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 13px;">
                    {{ $item->sparepart->kode_partdetail }}
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 13px;">
                    {{ $item->sparepart->nama_barang }}
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 13px;">
                    {{ $item->jumlah }}</td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 13px;">
                    {{ $item->km_penggantian }}
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 13px;">{{ $item->km_berikutnya }}
                </td>
            </tr>
        @endforeach
        <tr style="border-bottom: 1px solid black;">
            <td colspan="8" style="padding: 0px;">
            </td>
        </tr>
    </table>

    <div style="font-weight: bold; text-align: left; margin-top:10px">
        <span style="font-weight: bold; font-size: 13px;">PENGGANTIAN PART FILTER</span>
    </div>

    <table style="width: 100%; border-top: 1px solid black;" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td" style="text-align: left; padding: 5px; font-size: 13px;">No.</td>
            <td class="td" style="text-align: left; padding: 5px; font-size: 13px;">Kode Barang</td>
            <td class="td" style="text-align: left; padding: 5px; font-size: 13px;">Nama Barang</td>
            <td class="td" style="text-align: left; padding: 5px; font-size: 13px;">Qty</td>
            <td class="td" style="text-align: left; padding: 5px; font-size: 13px;">Satuan</td>
            {{-- <td class="td" style="text-align: left; padding: 5px; font-size: 13px;">Km Penggantian</td>
            <td class="td" style="text-align: left; padding: 5px; font-size: 13px;">Km Berikutnya</td> --}}
        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td colspan="7" style="padding: 0px;">
            </td>
        </tr>
        @foreach ($parts2 as $item)
            <tr>
                <td class="td" style="text-align: left; padding: 5px; font-size: 13px;">{{ $loop->iteration }}
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 13px;">
                    {{ $item->spareparts->kode_partdetail }}
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 13px;">
                    {{ $item->spareparts->nama_barang }}
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 13px;">
                    {{ $item->jumlah2 }}</td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 13px;">
                    {{ $item->spareparts->satuan }}</td>
                {{-- <td class="td" style="text-align: left; padding: 5px; font-size: 13px;">
                    {{ $item->km_penggantian }}
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 13px;">{{ $item->km_berikutnya }}
                </td> --}}
            </tr>
        @endforeach
        <tr style="border-bottom: 1px solid black;">
            <td colspan="8" style="padding: 0px;">
            </td>
        </tr>
    </table>

    <br><br>

    <table class="tdd" cellpadding="10" cellspacing="0" style="margin: 0 auto;">
        <tr>
            <td style="text-align: center;">
                <table style="margin: 0 auto;">
                    <tr style="text-align: center; font-size:15px">
                        <td class="label">{{ auth()->user()->karyawan->nama_lengkap }}</td>
                    </tr>
                    <tr>
                        <td class="separator" colspan="2"><span></span></td>
                    </tr>
                    <tr style="text-align: center; font-size:15px">
                        <td class="label">Operasional</td>
                    </tr>
                </table>
            </td>
            <td style="text-align: center;">
                <table style="margin: 0 auto;">
                    <tr style="text-align: center;">
                        <td class="label" style="min-height: 15px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="separator" colspan="2"><span></span></td>
                    </tr>
                    <tr style="text-align: center; font-size:15px">
                        <td class="label">SPV Sparepart</td>
                    </tr>
                </table>
            </td>
            <td style="text-align: center;">
                <table style="margin: 0 auto;">
                    <tr style="text-align: center;">
                        <td class="label" style="min-height: 15px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="separator" colspan="2"><span></span></td>
                    </tr>
                    <tr style="text-align: center; font-size:15px">
                        <td class="label">Gudang</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
