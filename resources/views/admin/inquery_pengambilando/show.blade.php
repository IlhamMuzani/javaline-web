<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pengambilan DO</title>
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
    <div style="text-align: center;">
        <span style="font-weight: bold; font-size: 25px;">PT JAVA LINE LOGISTICS</span>
        <br>
        <span style=" font-size: 15px;">JL. HOS COKRO AMINOTO NO 5 SLAWI TEGAL
            {{-- <br>Tegal 52411 --}}
        </span>
        <br>
        <span style=" font-size: 15px;">Telp / Fax, 02836195328 02838195187</span>
    </div>
    <hr style="border: 1px solid;">
    <div style="text-align: center;">
        <span style="font-weight: bold; font-size: 20px;">PENGAMBILAN DO</span>
    </div>
    <table width="100%">
        <tr>
            <td style="width:70%;">
                <table>
                    <tr>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 15px;">Tanggal</span>
                        </td>
                        <td class="info-column">
                            <span class="info-titik" style="font-size: 15px;">:</span>
                        </td>
                        <td class="info-column">
                            <span class="info-item"
                                style="font-size: 15px;">{{ \Carbon\Carbon::parse($cetakpdf->tanggal)->locale('id')->isoFormat('D MMMM YYYY') }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 15px;">No. Pengambilan</span>
                        </td>
                        <td class="info-column">
                            <span class="info-titik" style="font-size: 15px;">:</span>
                        </td>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 15px;">{{ $cetakpdf->kode_pengambilan }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 15px;">No. Kabin</span>
                        </td>
                        <td class="info-column">
                            <span class="info-titik" style="font-size: 15px;">:</span>
                        </td>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 15px;">{{ $cetakpdf->kendaraan->no_kabin }}</span>
                        </td>
                    </tr>
                </table>
            </td>

            <td style="width: 50%; text-align: left;">
                <table style="width: 100%; margin-top:4px">
                    <tr>
                        <td style="width: 40%;">
                            <span class="info-item"
                                style="font-size: 15px; text-align: left; display: inline-block; color:white">Nama
                                bank</span>
                        </td>
                        <td style="width: 60%;">
                            <span class="info-item"
                                style="font-size: 15px; text-align: left; display: inline-block; color:white">:
                                @if ($cetakpdf->user->karyawan->nama_bank != null)
                                    {{ $cetakpdf->user->karyawan->nama_bank }}
                                @else
                                @endif
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 40%;">
                            <span class="info-item"
                                style="font-size: 15px; text-align: left; display: inline-block; color:white">No
                                Rekening</span>
                        </td>
                        <td style="width: 60%;">
                            <span class="info-item"
                                style="font-size: 15px; text-align: left; display: inline-block; color:white">:
                                @if ($cetakpdf->user->karyawan->norek != null)
                                    {{ $cetakpdf->user->karyawan->norek }}
                                @else
                                @endif
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 40%;">
                            <span class="info-item"
                                style="font-size: 15px; text-align: left; display: inline-block; color:white">Atas
                                Nama</span>
                        </td>
                        <td style="width: 60%;">
                            <span class="info-item"
                                style="font-size: 15px; text-align: left; display: inline-block; color:white">:
                                @if ($cetakpdf->user->karyawan->atas_nama != null)
                                    {{ $cetakpdf->user->karyawan->atas_nama }}
                                @else
                                @endif
                            </span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <hr style="border: 2px solid;">
    <table width="100%">
        <tr>
            <td style="width:60%;">
                <table>
                    <tr>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 15px;">Rute Perjalanan</span>
                        </td>
                        <td class="info-column">
                            <span class="info-titik" style="font-size: 15px;">:</span>
                        </td>
                        <td class="info-column">
                            <span class="info-item"
                                style="font-size: 15px;">{{ $cetakpdf->rute_perjalanan->nama_rute }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 15px;">Kode Sopir</span>
                        </td>
                        <td class="info-column">
                            <span class="info-titik" style="font-size: 15px;">:</span>
                        </td>
                        <td class="info-column">
                            <span class="info-item"
                                style="font-size: 15px;">{{ $cetakpdf->user->karyawan->kode_karyawan }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 15px;">Nama Sopir</span>
                        </td>
                        <td class="info-column">
                            <span class="info-titik" style="font-size: 15px;">:</span>
                        </td>
                        <td class="info-column">
                            <span class="info-item"
                                style="font-size: 15px;">{{ $cetakpdf->user->karyawan->nama_lengkap }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 15px;">Alamat Muat</span>
                        </td>
                        <td class="info-column">
                            <span class="info-titik" style="font-size: 15px;">:</span>
                        </td>
                        <td class="info-column">
                            <span class="info-item"
                                style="font-size: 15px;">{{ $cetakpdf->alamat_muat->alamat }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="info-column">
                            <span class="info-item" style="font-size: 15px;">Alamat Bongkar</span>
                        </td>
                        <td class="info-column">
                            <span class="info-titik" style="font-size: 15px;">:</span>
                        </td>
                        <td class="info-column">
                            <span class="info-item"
                                style="font-size: 15px;">{{ $cetakpdf->alamat_bongkar->alamat }}</span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

    </table>


    {{-- <td colspan="5" style="padding: 0px;">Ket Memo</td> --}}
    <td colspan="6" style="padding: 0px; position: relative;">
        <hr
            style="border-top: 1px solid black; margin: 3px 0; display: inline-block; width: calc(100% - 25px); vertical-align: middle;">
        <span>
            -
        </span>
    </td>

    <table style="width: 100%;" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td"
                style="text-align: left; padding-left: 10px; font-size: 15px; white-space: nowrap; width: 60%;">
                {{ $cetakpdf->keterangan }}</td>
        </tr>
    </table>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>

    <table class="tdd" cellpadding="10" cellspacing="0" style="margin: 0 auto;">
        <tr>
            <td style="text-align: center;">
                <table style="margin: 0 auto;">
                    <tr style="text-align: center;">
                        <td class="label">
                            {{ $cetakpdf->nama_driver }}
                        </td>
                    </tr>
                    <tr>
                        <td class="separator" colspan="2"><span></span></td>
                    </tr>
                    <tr style="text-align: center;">
                        <td class="label">Sopir</td>
                    </tr>
                </table>
            </td>
            <td style="text-align: center;">
                <table style="margin: 0 auto;">
                    <tr style="text-align: center;">
                        <td class="label">
                            DJOHAN WAHYUDI
                        </td>
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
                        <td class="label">
                            {{-- @if ($cetakpdf->user)
                                {{ $cetakpdf->user->karyawan->nama_lengkap }}
                            @else
                                user tidak ada
                            @endif --}}
                            {{ auth()->user()->karyawan->nama_lengkap }}
                        </td>
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
    <br>
</body>

<div class="container">
    <a href="{{ url('admin/tablememo') }}" class="blue-button">Kembali</a>
    <a href="{{ url('admin/memo_ekspedisi/cetak-pdf/' . $cetakpdf->id) }}" class="blue-button">Cetak</a>
</div>


</html>
