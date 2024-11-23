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
    <br>
    <div style="font-weight: bold; text-align: center">
        <span style="font-weight: bold; font-size: 22px;">SURAT PENGGANTIAN OLI</span>
        <br>
        <br>
    </div>
    {{-- <hr style="border-top: 0.1px solid black; margin: 1px 0;"> --}}

    <table style="width: 100%; border-top: 1px solid black;" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td" style="text-align: center; padding: 3px; font-size: 16px;">No.
                Kabin:{{ $pemasangan_part->kendaraan->no_kabin }}</td>
            <td class="td" style="text-align: center; padding: 3px; font-size: 16px;">No.
                Registrasi:{{ $pemasangan_part->kendaraan->no_pol }}</td>
            <td class="td" style="text-align: center; padding: 3px; font-size: 16px;">Jenis
                Kendaraan:{{ $pemasangan_part->kendaraan->jenis_kendaraan->nama_jenis_kendaraan }}</td>
            <td class="td" style="text-align: center; padding: 3px; font-size: 16px;">
                Tanggal:{{ $pemasangan_part->tanggal_penggantian }}</td>
        </tr>
    </table>
    </div>
    {{-- <hr style="border-top: 0.1px solid black; margin: 1px 0;"> --}}
    <table style="width: 100%; border-top: 1px solid black;" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td" style="text-align: left; padding: 5px; font-size: 15px;">No.</td>
            <td class="td" style="text-align: left; padding: 5px; font-size: 15px;">Kode Barang</td>
            <td class="td" style="text-align: left; padding: 5px; font-size: 15px;">Nama Barang</td>
            <td class="td" style="text-align: left; padding: 5px; font-size: 15px;">Qty</td>
            <td class="td" style="text-align: left; padding: 5px; font-size: 15px;">Km Penggantian</td>
            <td class="td" style="text-align: left; padding: 5px; font-size: 15px;">Km Berikutnya</td>
        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td colspan="7" style="padding: 0px;">
            </td>
        </tr>
        @foreach ($parts as $item)
            <tr>
                <td class="td" style="text-align: left; padding: 5px; font-size: 15px;">{{ $loop->iteration }}
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 15px;">
                    {{ $item->sparepart->kode_partdetail }}
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 15px;">
                    {{ $item->sparepart->nama_barang }}
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 15px;">
                    {{ $item->jumlah }}</td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 15px;">
                    {{ $item->km_penggantian }}
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 15px;">
                    {{ $item->km_berikutnya }}
                </td>
            </tr>
        @endforeach
        <tr style="border-bottom: 1px solid black;">
            <td colspan="8" style="padding: 0px;">
            </td>
        </tr>
    </table>

    <div style="font-weight: bold; text-align: left">
        <br>
        <span style="font-weight: bold; font-size: 15px;">PENGGANTIAN PART</span>
    </div>
    <table style="width: 100%; border-top: 1px solid black;" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td" style="text-align: left; padding: 5px; font-size: 15px;">No.</td>
            <td class="td" style="text-align: left; padding: 5px; font-size: 15px;">Kode Barang</td>
            <td class="td" style="text-align: left; padding: 5px; font-size: 15px;">Nama Barang</td>
            <td class="td" style="text-align: left; padding: 5px; font-size: 15px;">Qty</td>
            <td class="td" style="text-align: left; padding: 5px; font-size: 15px;">Satuan</td>
        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td colspan="7" style="padding: 0px;">
            </td>
        </tr>
        @foreach ($parts2 as $item)
            <tr>
                <td class="td" style="text-align: left; padding: 5px; font-size: 15px;">{{ $loop->iteration }}
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 15px;">
                    {{ $item->spareparts->kode_partdetail }}
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 15px;">
                    {{ $item->spareparts->nama_barang }}
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 15px;">
                    {{ $item->jumlah2 }}</td>

                <td class="td" style="text-align: left; padding: 5px; font-size: 15px;">
                    {{ $item->spareparts->satuan }}</td>
            </tr>
        @endforeach
        <tr style="border-bottom: 1px solid black;">
            <td colspan="8" style="padding: 0px;">
            </td>
        </tr>
    </table>
    <br><br><br>

    <table class="tdd" cellpadding="10" cellspacing="0" style="margin: 0 auto;">
        <tr>
            <td style="text-align: center;">
                <table style="margin: 0 auto;">
                    <tr style="text-align: center;">
                        <td class="label">
                            @if ($pemasangan_part->user)
                                {{ $pemasangan_part->user->karyawan->nama_lengkap }}
                            @else
                                user tidak ada
                            @endif
                        </td>
            </td>
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
                <td class="label">SPV Sparepart</td>
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
                <td class="label">Gudang</td>
            </tr>
        </table>
    </td>
    </tr>
    </table>
</body>

<div class="container">
    {{-- <a href="{{ url('admin/inquery_penggantianoli') }}" class="blue-button">Kembali</a> --}}
    <a href="{{ url('admin/inquery_penggantianoli') . '?status=&tanggal_awal=' . $pemasangan_part->tanggal_awal . '&tanggal_akhir=' . $pemasangan_part->tanggal_awal . '&ids=' }}"
        class="blue-button">
        Kembali
    </a>
    <a href="{{ url('admin/penggantian_oli/cetak-pdf/' . $pemasangan_part->id) }}" class="blue-button">Cetak</a>
</div>

</html>
