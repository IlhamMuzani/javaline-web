<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Surat Klaim Ban Driver</title>
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
        font-family: 'DOSVGA', monospace;
        color: black;
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

    .faktur {
        text-align: center
    }

    /* .blue-button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            right: 0;
        } */

    .info-container {
        display: flex;
        justify-content: space-between;
        font-weight: bold;
        font-size: 15px;
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
        font-size: 15px;
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
        font-size: 15px;
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
    <div id="logo-container">
        <img src="{{ asset('storage/uploads/user/logo.png') }}" alt="JAVA LINE LOGISTICS" width="150" height="50">
    </div>
    <br>
    <div style="font-weight: bold; text-align: center">
        <span style="font-weight: bold; font-size: 23px;">SURAT KLAIM BAN DRIVER</span>
        <br>
        <br>
    </div>
    <hr style="border-top: 0.5px solid black; margin: 3px 0;">
    <table style="width: 100%;" cellpadding="2" cellspacing="0">
        <tr>
            <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">
                Kode Klaim:{{ $cetakpdf->kode_klaimban }}</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 15px; color:white">
                a</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 15px; color:white">
                a</td>
            <td class="td" style="text-align: center; padding: 0px; font-size: 15px;">
                Tanggal:{{ \Carbon\Carbon::parse($cetakpdf->tanggal)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
        </tr>
    </table>
    </div>
    <hr style="border-top: 0.5px solid black; margin: 3px 0;">
    <?php
    function terbilang($angka)
    {
        $angka = abs($angka); // Pastikan angka selalu positif
        $bilangan = ['', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas'];
        $hasil = '';
        if ($angka < 12) {
            $hasil = $bilangan[$angka];
        } elseif ($angka < 20) {
            $hasil = terbilang($angka - 10) . ' Belas';
        } elseif ($angka < 100) {
            $hasil = terbilang($angka / 10) . ' Puluh ' . terbilang($angka % 10);
        } elseif ($angka < 200) {
            $hasil = 'Seratus ' . terbilang($angka - 100);
        } elseif ($angka < 1000) {
            $hasil = terbilang($angka / 100) . ' Ratus ' . terbilang($angka % 100);
        } elseif ($angka < 2000) {
            $hasil = 'Seribu ' . terbilang($angka - 1000);
        } elseif ($angka < 1000000) {
            $hasil = terbilang($angka / 1000) . ' Ribu ' . terbilang($angka % 1000);
        } elseif ($angka < 1000000000) {
            $hasil = terbilang($angka / 1000000) . ' Juta ' . terbilang($angka % 1000000);
        } elseif ($angka < 1000000000000) {
            $hasil = terbilang($angka / 1000000000) . ' Miliar ' . terbilang($angka % 1000000000);
        } elseif ($angka < 1000000000000000) {
            $hasil = terbilang($angka / 1000000000000) . ' Triliun ' . terbilang($angka % 1000000000000);
        }
        return $hasil;
    }
    ?>

    <table style="width: 100%;" cellpadding="2" cellspacing="0">
        <tr>
            <td style="text-align: left; padding: 0px; font-weight:bold; font-size: 15px; width:20%">Kode Driver</td>
            <td style="text-align: center; padding: 0px; font-weight:bold; font-size: 15px; width:5%">:</td>
            <td style="text-align: left; padding: 0px; font-weight:bold; font-size: 15px; width:90%">
                {{ $cetakpdf->karyawan->kode_karyawan }}
            </td>
        </tr>
        <tr>
            <td style="text-align: left; padding: 0px; font-weight:bold; font-size: 15px; width:8%">Nama Driver</td>
            <td style="text-align: center; padding: 0px; font-weight:bold; font-size: 15px; width:5%">:</td>
            <td style="text-align: left; padding: 0px; font-weight:bold; font-size: 15px; width:90%">
                {{ $cetakpdf->karyawan->nama_lengkap }}
            </td>
        </tr>
        <tr>
            <td style="text-align: left; padding: 0px; font-weight:bold; font-size: 15px; width:8%">No Kabin</td>
            <td style="text-align: center; padding: 0px; font-weight:bold; font-size: 15px; width:5%">:</td>
            <td style="text-align: left; padding: 0px; font-weight:bold; font-size: 15px; width:90%">
                {{ $cetakpdf->kendaraan->no_kabin }}
            </td>
        </tr>
        <tr>
            <td style="text-align: left; padding: 0px; font-weight:bold; font-size: 15px; width:8%">No Seri Ban</td>
            <td style="text-align: center; padding: 0px; font-weight:bold; font-size: 15px; width:5%">:</td>
            <td style="text-align: left; padding: 0px; font-weight:bold; font-size: 15px; width:90%">
                {{ $cetakpdf->ban->no_seri }}
            </td>
        </tr>
        <tr>
            <td style="text-align: left; padding: 0px; font-weight:bold; font-size: 15px; width:8%">Posisi Ban</td>
            <td style="text-align: center; padding: 0px; font-weight:bold; font-size: 15px; width:5%">:</td>
            <td style="text-align: left; padding: 0px; font-weight:bold; font-size: 15px; width:90%">
                {{ $cetakpdf->ban->posisi_ban }}
            </td>
        </tr>
        <tr>
            <td style="text-align: left; padding: 0px; font-weight:bold; font-size: 15px; width:10%">Pemasangan Ban</td>
            <td style="text-align: center; padding: 0px; font-weight:bold; font-size: 15px; width:5%">:</td>
            <td style="text-align: left; padding: 0px; font-weight:bold; font-size: 15px; width:90%">
                {{ number_format($cetakpdf->km_pemasangan, 0, ',', '.') }}
            </td>
        </tr>
        <tr>
            <td style="text-align: left; padding: 0px; font-weight:bold; font-size: 15px; width:10%">Target Km Ban</td>
            <td style="text-align: center; padding: 0px; font-weight:bold; font-size: 15px; width:5%">:</td>
            <td style="text-align: left; padding: 0px; font-weight:bold; font-size: 15px; width:90%">
                {{ number_format($cetakpdf->target_km, 0, ',', '.') }}
            </td>
        </tr>
        <tr>
            <td style="text-align: left; padding: 0px; font-weight:bold; font-size: 15px; width:10%">Pelepasan Ban</td>
            <td style="text-align: center; padding: 0px; font-weight:bold; font-size: 15px; width:5%">:</td>
            <td style="text-align: left; padding: 0px; font-weight:bold; font-size: 15px; width:90%">
                {{ number_format($cetakpdf->km_pelepasan, 0, ',', '.') }}
            </td>
        </tr>
        <tr>
            <td style="text-align: left; padding: 0px; font-weight:bold; font-size: 15px; width:10%">KM Terpakai</td>
            <td style="text-align: center; padding: 0px; font-weight:bold; font-size: 15px; width:5%">:</td>
            <td style="text-align: left; padding: 0px; font-weight:bold; font-size: 15px; width:90%">
                {{ number_format($cetakpdf->km_terpakai, 0, ',', '.') }}
            </td>
        </tr>
        <tr>
            <td style="text-align: left; padding: 0px; font-weight:bold; font-size: 15px; width:5%">Nominal Klaim</td>
            <td style="text-align: center; padding: 0px; font-weight:bold; font-size: 15px; width:5%">:</td>
            <td style="text-align: left; padding: 0px; font-weight:bold; font-size: 15px; width:90%">Rp.
                {{ number_format($cetakpdf->sisa_harga, 2, ',', '.') }}
            </td>
        </tr>
        <tr>

        </tr>
        <tr>
            <td style="text-align: left; padding: 0px; font-size: 15px; font-weight:bold">
                Terbilang
            </td>
            <td style="text-align: center; padding: 0px; font-size: 15px; font-weight:bold">
                :
            </td>
            <td style="text-align: left; padding-top: 5px; font-size: 15px; font-style:italic; font-weight:bold">
                ({{ terbilang($cetakpdf->nominal) }} Rupiah)
            </td>

        </tr>
        <tr>
            <td colspan="5" style="padding: 0px;">
            </td>
        </tr>
    </table>
    {{-- <table width="100%">
        <tr>
            <td>
                <div class="info-catatan" style="max-width: 230px;">
                    <table>
                        <tr>
                            <td class="info-catatan2">Nominal</td>
                            <td class="info-item">:</td>
                            <td style="font-weight:bold; word-wrap: break-word;" class="info-text info-left">
                                Rp. {{ number_format($cetakpdf->nominal, 2, ',', '.') }}
    </td>
    </tr>
    <tr>
        <td class="info-catatan2">Terbilang</td>
        <td class="info-item">:</td>
        <td style="font-weight:bold; word-wrap: break-word;" class="info-text info-left">
        </td>
    </tr>
    </table>
    </div>
    </td>
    </tr>
    </table> --}}

    <hr style="border-top: 0.5px solid black; margin: 3px 0;">

    <table style="width: 100%;" cellpadding="2" cellspacing="0">
        <tr>
            <td style="text-align: left; padding: 0px; font-size: 15px; font-weight:bold">Keterangan :
            </td>
            <td style="text-align: right; padding: 0px; font-size: 15px; font-weight:bold">Sisa Deposit :
                <span>
                    Rp.{{ number_format($cetakpdf->sub_total, 2, ',', '.') }}
            </td>
            </span>
        </tr>
    </table>
    <div>
        <span style="display: block; max-width: 55%; word-wrap: break-word;">
            {{ $cetakpdf->keterangan }}
        </span>
    </div>

    <br><br><br>

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
                        <td class="label">Accounting</td>
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
                    <tr style="text-align: center;">
                        <td class="label">Finance</td>
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
                    <tr style="text-align: center;">
                        <td class="label">Admin</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <div style="text-align: right; font-size:12px; margin-top:25px">
        <span style="font-style: italic;">Printed Date {{ \Carbon\Carbon::now()->format('Y-m-d H:i:s') }}</span>
    </div>
</body>

</html>