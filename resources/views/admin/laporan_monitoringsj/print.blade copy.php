<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Monitoring Surat Jalan</title>
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
        font-size: 12px;
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
        <h1>LAPORAN MONITORING SURAT JALAN - RANGKUMAN</h1>
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
            <th>NO</th>
            <th>KODE SPK</th>
            <th>PELANGGAN</th>
            <th>TUJUAN</th>
            <th>TANGGAL</th>
            <th>NO KABIN</th>
            <th>NAMA DRIVER</th>
            <th>PENERIMA</th>
        </tr>
        @php
        $total = 0;
        @endphp
        @foreach ($inquery as $pengambilan_do)
        @php
        $noKabin = $pengambilan_do->spk->kendaraan->no_kabin ?? '-';
        $isUserRestricted = in_array(auth()->user()->id, [372, 576]) && strpos($noKabin, 'K3') !== 0;
        @endphp
        @if (!$isUserRestricted)
        {{-- @if ($pengambilan_do->waktu_suratakhir == null) --}}
        <tr class="dropdown" {{ $pengambilan_do->id }}>
            <td class="text-center">{{ $loop->iteration }}</td>
            <td>{{ $pengambilan_do->spk->kode_spk ?? '-' }}</td>
            <td>{{ $pengambilan_do->spk->nama_pelanggan ?? '-' }}</td>
            <td>{{ $pengambilan_do->spk->nama_rute ?? '-' }}</td>
            <td>{{ $pengambilan_do->tanggal_awal }}</td>
            <td>{{ $pengambilan_do->spk->kendaraan->no_kabin ?? '-' }}</td>
            <td>{{ $pengambilan_do->spk->nama_driver ?? '-' }}</td>
            <td>{{ $pengambilan_do->penerima_sj ?? '-' }}</td>
        </tr>
        {{-- @endif --}}

        @php
        $total++;
        @endphp
        @endif
        @endforeach
        <tr style="border-bottom: 1px solid black;">
            <td colspan="7" style="padding: 0px;"></td>
        </tr>
        <tr>
            <td colspan="6" style="text-align: right; font-weight: bold;">
            </td>
            <td style="text-align: right; font-weight: bold; background:rgb(190, 190, 190)">
                {{ $total }}
            </td>
        </tr>
    </table>
</body>


</html>