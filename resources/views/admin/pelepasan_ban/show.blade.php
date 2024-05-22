<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Surat Pelepasan Ban</title>
    <style>
        /* * {
            border: 1px solid black;
        } */
        .b {
            border: 1px solid black;
        }

        .table,
        .td {
            /* border: 1px solid black; */
        }

        .table,
        .tdd {
            border: 1px solid white;
        }

        html,
        body {
            margin: 40px;
            padding: 10px;
        }

        span.h2 {
            font-size: 24px;
            font-weight: 500;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
        }

        .tdd td {
            border: none;
        }
        .faktur {
            text-align: center
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
            font-weight: bold;
            font-size: 16px;
            margin: 5px 0;
        }

        .right-col {
            text-align: right;
        }

        .info-text {
            text-align: left;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .info-left {
            text-align: left;
            /* Apply left-align specifically for the info-text class */
        }

        .info-item {
            flex: 1;
        }

        .alamat {
            color: black;
            font-weight: bold;
        }

        .blue-button:hover {
            background-color: #0056b3;
        }

        .nama-pt {
            color: black;
            font-weight: bold;
        }

        .alamat {
            color: black;
            font-weight: bold;
        }

        .info-catatan {
            display: flex;
            flex-direction: row;
            /* Mengatur arah menjadi baris */
            align-items: center;
            /* Posisi elemen secara vertikal di tengah */
            margin-bottom: 2px;
            /* Menambah jarak antara setiap baris */
        }

        .info-catatan2 {
            font-weight: bold;
            margin-right: 5px;
            min-width: 120px;
            /* Menetapkan lebar minimum untuk kolom pertama */
        }

        .tdd1 td {
            text-align: center;
            font-size: 13px;
            position: relative;
            padding-top: 10px;
            /* Sesuaikan dengan kebutuhan Anda */
        }

        .tdd1 td::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            border-top: 1px solid black;
        }

        .info-1 {}

        .label {
            font-size: 13px;
            text-align: center;
            /* Teks menjadi berada di tengah */

        }

        .separator {
            padding-top: 15px;
            /* Atur sesuai kebutuhan Anda */
            text-align: center;
            /* Teks menjadi berada di tengah */

        }

        .separator span {
            display: inline-block;
            border-top: 1px solid black;
            width: 100%;
            position: relative;
            top: -8px;
            /* Sesuaikan posisi vertikal garis tengah */
        }
    </style>
</head>

<body style="margin: 0; padding: 0;">
    <br>
    <div style="font-weight: bold; text-align: center">
        <span style="font-weight: bold; font-size: 20px;">SURAT PELEPASAN BAN</span>
        <br>
        <br>
    </div>
    <hr style="border-top: 0.5px solid black; margin: 3px 0;">
    {{-- <table width="100%">
                <tr>
                    <td>
                        <span class="info-item" style="font-size: 13px;">No. Kabin:{{ $kendaraan->no_kabin }}</span>
                        <br>
                    </td>
                    <td>
                        <span class="info-item" style="font-size: 13px;">Jenis
                            Kendaraan:{{ $kendaraan->no_kabin }}</span>
                        <br>
                    </td>
                    <td>
                        <span class="info-item" style="font-size: 13px;">Total Ban:{{ $kendaraan->no_kabin }}</span>
                        <br>
                    </td>
                    <td>
                        <span class="info-item"
                            style="font-size: 13px;">Tanggal:{{ $pasang_ban->tanggal }}</span>
                        <br>
                    </td>
                </tr>
            </table> --}}
    <table style="width: 100%;" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td" style="text-align: center; padding: 0px; font-size: 14px;">No.
                Kabin:{{ $kendaraan->no_kabin }}</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 14px;">Jenis
                Kendaraan:{{ $kendaraan->jenis_kendaraan->nama_jenis_kendaraan }}</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 14px;">Total
                Ban:{{ $kendaraan->jenis_kendaraan->total_ban }}</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 14px;">
                Tanggal:{{ $pelepasan_ban->tanggal }}</td>
        </tr>
    </table>
    </div>
    <hr style="border-top: 0.5px solid black; margin: 3px 0;">
    <table style="width: 100%;" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">No.</td>
            <td class="td" style="text-align: left; padding: 0px; font-size: 12px;">Posisi</td>
            <td class="td" style="text-align: left; padding: 0px; font-size: 12px;">Kode Ban</td>
            <td class="td" style="text-align: left; padding: 0px; font-size: 12px;">No. Seri</td>
            <td class="td" style="text-align: left; padding: 0px; font-size: 12px;">Ukuran</td>
            <td class="td" style="text-align: left; padding: 0px; font-size: 12px;">Merek</td>
            <td class="td" style="text-align: left; padding: 0px; font-size: 12px;">Ket</td>
            <td class="td" style="text-align: right; padding: 0px; font-size: 12px;">Km Pasang</td>
            <td class="td" style="text-align: right; padding: 0px; font-size: 12px;">Km Lepas</td>
            <td class="td" style="text-align: right; padding-right: 10px; font-size: 12px;">Km Terpakai</td>
        </tr>
        <!-- Add horizontal line below this row -->

        @foreach ($bans as $item)
            <tr>
                <td colspan="10" style="padding: 0px;">
                    <hr style="border-top: 0.1px solid black; margin: 5px 0;">
                </td>
            </tr>
            @php
                $kmPasang = $item->km_pemasangan;
                $kmLepas = $item->km_pelepasan;
                $selisih = $kmLepas - $kmPasang;
            @endphp
            <tr>
                <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">
                    {{ $loop->iteration }}
                </td>
                <td class="td" style="text-align: left; padding: 0px; font-size: 12px;">
                    {{ $item->posisi_ban }}
                </td>

                <td class="td" style="text-align: left; padding: 0px; font-size: 12px;">
                    {{ $item->kode_ban }}
                </td>
                <td class="td" style="text-align: left; padding: 0px; font-size: 12px;">
                    {{ $item->no_seri }}
                </td>
                <td class="td" style="text-align: left; padding: 2px; font-size: 12px;">
                    {{ $item->ukuran->ukuran }}
                </td>
                <td class="td" style="text-align: left; padding: 2px; font-size: 12px;">
                    {{ $item->merek->nama_merek }}
                </td>
                <td class="td" style="text-align: left; padding: 2px; font-size: 12px;">
                    {{ $item->keterangan }}
                </td>
                <td class="td" style="text-align: right; padding: 2px; font-size: 12px;">
                    {{ number_format($kmPasang, 0, ',', '.') }}
                </td>
                <td class="td" style="text-align: right; padding: 2px; font-size: 12px;">
                    {{ number_format($kmLepas, 0, ',', '.') }}
                </td>

                <td class="td" style="text-align: right;padding-right: 10px; font-size: 12px;">
                    {{ number_format($selisih, 0, ',', '.') }}
                </td>
            </tr>

            {{-- <tr style="border-bottom: 1px solid black;">
                <td colspan="10"></td>
            </tr> --}}
            @if ($item->keterangan == 'Stok')
                <tr>
                    <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">

                    </td>
                    <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">

                    </td>
                    <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">

                    </td>
                    <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">

                    </td>
                    <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">

                    </td>
                    <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">

                    </td>
                    <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">

                    </td>
                    <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">

                    </td>
                    <td class="td" style="text-align: right; padding: 2px; font-size: 12px;">
                        Umur Awal Ban :
                    </td>
                    @php
                        // Ambil semua data km_ban yang diurutkan berdasarkan waktu atau ID
                        $kmBanRecords = $item->ban->km_ban()->orderBy('created_at', 'desc')->get();
                        // Ambil umur_ban terakhir kedua
                        $umurBanTerakhirKedua = $kmBanRecords->skip(1)->first();
                    @endphp
                    <td class="td" style="text-align: right;padding: 0px; font-size: 12px;">
                        {{ number_format($umurBanTerakhirKedua ? $umurBanTerakhirKedua->umur_ban : 0, 0, ',', '.') }} +
                    </td>
                </tr>
            @else
                <tr>
                    <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">

                    </td>
                    <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">

                    </td>
                    <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">

                    </td>
                    <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">

                    </td>
                    <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">

                    </td>
                    <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">

                    </td>
                    <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">

                    </td>
                    <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">

                    </td>
                    <td class="td" style="text-align: right; padding: 2px; font-size: 12px;">
                        Umur Awal Ban :
                    </td>
                    <td class="td" style="text-align: right;padding: 0px; font-size: 12px;">
                        {{ number_format(optional($item->ban->km_ban()->latest()->first())->umur_ban ?? 0, 0, ',', '.') }} +
                    </td>
                </tr>
            @endif

            <tr style="border-bottom: 1px solid black;">
                <td colspan="10"></td>
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
                <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">

                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">

                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">

                </td>
                <td class="td" style="text-align: center; padding: 0px; font-size: 12px;">

                </td>
                <td class="td" style="text-align: right; padding: 2px; font-size: 12px;">
                    Total Umur Ban :
                </td>
                <td class="td" style="text-align: right;padding-right: 10px; font-size: 12px;">
                    @if ($item->keterangan == 'Stok')
                        {{ number_format($selisih + ($umurBanTerakhirKedua ? $umurBanTerakhirKedua->umur_ban : 0), 0, ',', '.') }}
                    @else
                        {{ number_format($selisih + (optional($item->ban->km_ban()->latest()->first())->umur_ban ?? 0), 0, ',', '.') }}
                    @endif
                </td>
            </tr>
            <tr>
                <td>
                    <br>
                </td>
            </tr>
        @endforeach
    </table>

    <br><br><br>

    <table class="tdd" cellpadding="10" cellspacing="0">
        <tr>
            <td>
                <table>
                    <tr>
                        <td class="label">{{ auth()->user()->karyawan->nama_lengkap }}</td>
                    </tr>
                    <tr>
                        <td class="separator" colspan="2"><span></span></td>
                    </tr>
                    <tr>
                        <td class="label">Operasional</td>
                    </tr>
                </table>
            </td>
            <td>
                <table>
                    <tr>
                        <td class="label">.</td>
                    </tr>
                    <tr>
                        <td class="separator" colspan="2"><span></span></td>
                    </tr>
                    <tr>
                        <td class="label">SPV Ban</td>
                    </tr>
                </table>
            </td>
            <td>
                <table>
                    <tr>
                        <td class="label">.</td>
                    </tr>
                    <tr>
                        <td class="separator" colspan="2"><span></span></td>
                    </tr>
                    <tr>
                        <td class="label">Accounting</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

<div class="container">
    <a href="{{ url('admin/pelepasan_ban') }}" class="blue-button">Kembali</a>
    <a href="{{ url('admin/pelepasan_ban/cetak-pdf/' . $pelepasan_ban->id) }}" class="blue-button">Cetak</a>
</div>

</html>
