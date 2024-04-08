<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Pemasangan Part</title>
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
            margin-top: 2px;
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

        .kepala {
            background-color: #cfcfcf;
        }

        .detail {
            background-color: #ffffff;
        }

        .thdetail {
            background-color: #ffffff;
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
        <h1>LAPORAN PEMASANGAN PART - RANGKUMAN</h1>
    </div>
    <div class="text">
        @php
            $startDate = request()->query('tanggal_awal');
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
            <th>Kode Pemasangan</th>
            <th>Tanggal</th>
            <th>No Kabin</th>
            <th>No Registrasi</th>
            {{-- <th>Jumlah</th> --}}
            <th>Jenis Kendaraan</th>
        </tr>
        @foreach ($inquery as $pemasangan_part)
            <tr>
                <td class="kepala">{{ $pemasangan_part->kode_pemasanganpart }}</td>
                <td class="kepala"> {{ $pemasangan_part->tanggal_awal }}</td>
                <td class="kepala"> {{ $pemasangan_part->kendaraan->no_kabin }}</td>
                <td class="kepala"> {{ $pemasangan_part->kendaraan->no_pol }}</td>
                {{-- <td> {{ $pemasangan_part->detail_part->count() }} Part</td> --}}
                <td class="kepala"> {{ $pemasangan_part->kendaraan->jenis_kendaraan->nama_jenis_kendaraan }}</td>
            </tr>
            <!-- Tambahkan baris untuk detail part di bawah setiap pemasangan_part -->
            <tr>
                <td colspan="5"> <!-- Menggabungkan sel di semua kolom -->
                    <table>
                        <tr>
                            <th class="thdetail">Kode Part</th>
                            <th class="thdetail">Nama Part</th>
                            <th class="thdetail">Keterangan</th>
                            <th class="thdetail">Jumlah</th>
                        </tr>
                        @foreach ($pemasangan_part->detail_part as $detail_part)
                            <tr>
                                <td class="detail">{{ $detail_part->sparepart->kode_partdetail }}</td>
                                <td class="detail">{{ $detail_part->sparepart->nama_barang }}</td>
                                <td class="detail">{{ $detail_part->keterangan }}</td>
                                <td class="detail">{{ $detail_part->jumlah }}</td>
                            </tr>
                        @endforeach
                    </table>
                </td>
            </tr>
        @endforeach
    </table>
    <!-- ... (kode lainnya) ... -->
</body>

</html>


</html>
