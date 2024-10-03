<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Surat Penggantian Bearing</title>
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
        <span style="font-weight: bold; font-size: 22px;">SURAT PENGGANTIAN BEARING</span>
        <br>
        <br>
    </div>
    {{-- <hr style="border-top: 0.1px solid black; margin: 1px 0;"> --}}

    <table style="width: 100%; border-top: 1px solid black;" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td" style="text-align: center; padding: 3px; font-size: 16px;">No.
                Kabin:{{ $penggantian->kendaraan->no_kabin }}
            </td>
            <td class="td" style="text-align: center; padding: 3px; font-size: 16px;">No.
                Registrasi:{{ $penggantian->kendaraan->no_pol }}</td>
            <td class="td" style="text-align: center; padding: 3px; font-size: 16px;">Jenis
                Kendaraan:{{ $penggantian->kendaraan->jenis_kendaraan->nama_jenis_kendaraan }}</td>
            <td class="td" style="text-align: center; padding: 3px; font-size: 16px;">
                Tanggal:{{ $penggantian->tanggal_penggantian }}</td>
        </tr>
    </table>
    <table style="width: 100%; border-top: 1px solid black;" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td" style="text-align: center; padding: 3px; font-size: 16px;">Km
                Penggantian:
                {{ number_format($penggantian->detail_penggantianbearing->first()->km_penggantian ?? null, 0, ',', '.') }}
            </td>
            {{-- <td class="td" style="text-align: center; padding: 3px; font-size: 15px;">No.
                Registrasi:{{ $penggantian->kendaraan->no_pol }}</td> --}}
            <td class="td" style="text-align: center; padding: 3px; font-size: 16px;">Km
                Berikutnya:
                {{ number_format($penggantian->detail_penggantianbearing->first()->km_berikutnya ?? null, 0, ',', '.') }}
            </td>
        </tr>
    </table>
    </div>
    {{-- <hr style="border-top: 0.1px solid black; margin: 1px 0;"> --}}
    <table style="width: 100%; border-top: 1px solid black;" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td" style="text-align: left; padding: 5px; font-size: 15px;">No.</td>
            <td class="td" style="text-align: left; padding: 5px; font-size: 15px;">Posisi</td>
            <td class="td" style="text-align: left; padding: 5px; font-size: 15px;">Kode Barang</td>
            <td class="td" style="text-align: left; padding: 5px; font-size: 15px;">Nama Barang</td>
            <td class="td" style="text-align: left; padding: 5px; font-size: 15px;">Qty</td>
            <td class="td" style="text-align: left; padding: 5px; font-size: 15px;">Kode Grease</td>
            <td class="td" style="text-align: left; padding: 5px; font-size: 15px;">Nama Grease</td>
            <td class="td" style="text-align: left; padding: 5px; font-size: 15px;">Qty Grease</td>

        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td colspan="7" style="padding: 0px;">
            </td>
        </tr>
        @foreach ($details as $item)
            <tr>
                <td class="td" style="text-align: left; padding: 5px; font-size: 15px;">{{ $loop->iteration }}
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 15px;">
                    {{ $item->kategori }}
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 15px;">
                    {{ $item->sparepart->kode_partdetail ?? null }}
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 15px;">
                    {{ $item->sparepart->nama_barang ?? null }}
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 15px;">
                    {{ $item->jumlah }}</td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 15px;">
                    {{ $item->kode_grease }}
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 15px;">
                    {{ $item->nama_grease }}
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 15px;">
                    {{ $item->jumlah_grease }}
                </td>
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
                            @if ($penggantian->user)
                                {{ $penggantian->user->karyawan->nama_lengkap }}
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
    <a href="{{ url('admin/inquery_penggantianbearing') }}" class="blue-button">Kembali</a>
    <a href="{{ url('admin/penggantian_bearing/cetak-pdf/' . $penggantian->id) }}" class="blue-button">Cetak</a>
</div>

</html>
