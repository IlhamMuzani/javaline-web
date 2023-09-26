<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Status Perjalanan</title>
    <style>
        body {
            margin: 0;
            padding: 20px;
            font-family: Arial, sans-serif;
        }

        .container {
            text-align: center;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 24px;
            font-weight: bold;
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 10px;
            /* Atur ukuran font tabel sesuai kebutuhan */
        }

        th,
        td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .total {
            font-weight: bold;
        }

        .signature {
            position: absolute;
            bottom: 20px;
            right: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;

            /* Menghilangkan garis tepi tabel */
        }

        td {
            padding: 5px 10px;

            /* Menghilangkan garis tepi sel */

        }

        .label {
            text-align: left;
            width: 50%;
            border: none;
            /* Mengatur lebar kolom teks */
        }

        .value {
            text-align: right;
            width: 50%;
            border: none;
            /* Mengatur lebar kolom hasil */
        }

        .separator {
            text-align: center;
            font-weight: bold;
            border: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>LAPORAN STATUS PERJALANAN - RANGKUMAN</h1>
    </div>
    <div class="text">
        @php
            $startDate = request()->query('tanggal_awalperjalanan');
            $endDate = request()->query('tanggal_akhir');
        @endphp
        @if ($startDate && $endDate)
            <p>Periode:{{ $startDate }} s/d {{ $endDate }}</p>
        @else
            <p>Periode: Tidak ada tanggal awal dan akhir yang diteruskan.</p>
        @endif
    </div>
    <table>
        <tr>
            <th>No. Kabin</th>
            <th>No. Registrasi</th>
            <th>Nama Driver</th>
            <th>Tujuan</th>
            <th>Waktu Berangkat</th>
            <th>Waktu Sampai</th>
            <th>Waktu</th>
        </tr>
        @foreach ($inquery as $kendaraan)
            <?php
            $tanggalAwal = new DateTime($kendaraan->tanggal_awalwaktuperjalanan);
            $tanggalAkhir = new DateTime($kendaraan->tanggal_akhirwaktuperjalanan);
            
            // Menghitung selisih waktu antara tanggal awal dan tanggal akhir
            $interval = $tanggalAwal->diff($tanggalAkhir);
            
            // Mengambil selisih hari dan jam
            $selisihHari = $interval->days;
            $selisihJam = $interval->h;
            ?>

            <tr>
                <td>{{ $kendaraan->no_kabin }}</td>
                <td> {{ $kendaraan->no_pol }}</td>
                <td> {{ $kendaraan->user->karyawan->nama_lengkap }}</td>
                <td> {{ $kendaraan->tujuan }}</td>
                <td>{{ $kendaraan->tanggal_awalwaktuperjalanan }}</td>
                <td>{{ $kendaraan->tanggal_akhirwaktuperjalanan }}</td>
                <td>{{ $selisihHari }} hari {{ $selisihJam }} jam</td>

            </tr>
        @endforeach
    </table>

    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br> <br>
    {{-- <div class="signature">
        <table>
            <tr>
                <td class="label">Jumlah ban :</td>
                <td class="value">Rp. {{ number_format($total, 2) }}</td>
            </tr>
            <!-- Tambahkan baris-baris lainnya jika diperlukan -->
            <tr>
                <td class="separator" colspan="2">______________________________</td>
            </tr>
            <tr>
                <td class="label">Jumlah ban :</td>
                <td class="value">Rp. {{ number_format($total, 2) }}</td>
            </tr>
        </table>
    </div> --}}

</body>


</html>
