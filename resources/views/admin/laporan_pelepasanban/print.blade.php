<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Pelepasan Ban</title>
    <style>
        body {
            margin: 0;
            padding: 20px;
            font-family: 'DOSVGA', monospace;
            color: black;
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
            font-size: 12px;
            /* Atur ukuran font tabel sesuai kebutuhan */
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
        <h1>LAPORAN PELEPASAN BAN - RANGKUMAN</h1>
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
            <th>Kode Pelepasan</th>
            <th>Tanggal</th>
            <th>No Kabin</th>
            <th>No Registrasi</th>
            <th>Jumlah Ban</th>
            <th>Pelepasan Ban</th>
            <th>Jenis Kendaraan</th>
        </tr>
        @foreach ($inquery as $pelepasan_ban)
            <tr>
                <td>{{ $pelepasan_ban->kode_pelepasan }}</td>
                <td> {{ $pelepasan_ban->tanggal_awal }}</td>
                <td> {{ $pelepasan_ban->kendaraan->no_kabin }}</td>
                <td> {{ $pelepasan_ban->kendaraan->no_pol }}</td>
                <td> {{ $pelepasan_ban->kendaraan->jenis_kendaraan->total_ban }}</td>
                <td> {{ $pelepasan_ban->detail_ban->count() }} Ban</td>
                <td> {{ $pelepasan_ban->kendaraan->jenis_kendaraan->nama_jenis_kendaraan }}</td>
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
                <td class="label">Total :</td>
                <td class="value">Rp. {{ number_format($total, 2) }}</td>
            </tr>
            <!-- Tambahkan baris-baris lainnya jika diperlukan -->
            <tr>
                <td class="separator" colspan="2">______________________________</td>
            </tr>
            <tr>
                <td class="label">Sub Total :</td>
                <td class="value">Rp. {{ number_format($total, 2) }}</td>
            </tr>
        </table>
    </div> --}}


    {{-- <div class="signature">
        <p>_________________________</p>
        <p>Tanda Tangan</p>
    </div> --}}

    <script>
        function printReport() {
            var startDate = tanggalAwal.value;
            var endDate = tanggalAkhir.value;

            if (startDate && endDate) {
                form.action = "{{ url('admin/print_ban') }}" + "?start_date=" + startDate + "&end_date=" + endDate;
                form.submit();

                // Update the date range in the HTML
                document.getElementById("dateRange").textContent = "Tanggal awal: " + startDate + " - Tanggal akhir: " +
                    endDate;
            } else {
                alert("Silakan isi kedua tanggal sebelum mencetak.");
            }
        }
    </script>
</body>


</html>
