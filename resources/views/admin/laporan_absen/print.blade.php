<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-13px">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Absensi Karyawan</title>
    <style>
        html,
        body {
            font-family: 'DOSVGA', Arial, Helvetica, sans-serif;
            /* font-family: 'DOSVGA', monospace; */
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
            margin-top: 7rem;
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


        .info-catatan2 {
            font-weight: bold;
            margin-right: 5px;
            min-width: 120px;
            /* Menetapkan lebar minimum untuk kolom pertama */
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
        <img src="{{ public_path('storage/uploads/user/logo.png') }}" alt="JAVA LINE LOGISTICS" width="150"
            height="50">
    </div>
    <div style="font-weight: bold; text-align: center">
        <span style="font-weight: bold; font-size: 18px;">LAPORAN ABSENSI KARYAWAN - RANGKUMAN</span>
        <br>
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
    </div>
    {{-- <hr style="border-top: 0.1px solid black; margin: 1px 0;"> --}}

    </div>
    {{-- <hr style="border-top: 0.1px solid black; margin: 1px 0;"> --}}
    <table style="width: 100%; border-top: 1px solid black;" cellpadding="2" cellspacing="0">
        <!-- Header row -->
        <tr>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 13px;">No</td>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 13px;">Tanggal
            </td>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 13px;">
                Waktu
            </td>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 13px;">Nama Karyawan
            </td>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 13px;">Radius Absensi
            </td>
            {{-- <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 13px;">Absensi
                Karyawan</td> --}}
        </tr>
        <!-- Separator row -->
        <tr style="border-bottom: 1px solid black;">
            <td colspan="5" style="padding: 0px;"></td>
        </tr>
        <!-- Data rows -->
        @foreach ($inquery as $absen)
            <tr>
                <td class="td" style="text-align: left; padding: 5px; font-size: 13px;">{{ $loop->iteration }}</td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 13px;">{{ $absen->tanggal_awal }}
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 13px;">{{ $absen->waktu }}
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 13px;">
                    {{ $absen->user->karyawan->nama_lengkap ?? null }}
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 13px;">
                    @if ($absen->jarak_absen == null)
                    @else
                        {{ $absen->jarak_absen }} m
                    @endif
                </td>
                {{-- <td class="td" style="text-align: left; padding: 5px; font-size: 13px;">
                    <img src="{{ public_path('storage/uploads/' . $absen->gambar) }}" height="50" width="50">
                </td> --}}

            </tr>
        @endforeach

        <tr style="border-bottom: 1px solid black;">
            <td colspan="5" style="padding: 0px;"></td>
        </tr>

    </table>




    <br>

    <!-- Tampilkan sub-total di bawah tabel -->
    {{-- <div style="text-align: right;">
        <strong>Sub Total: Rp. {{ number_format($total, 0, ',', '.') }}</strong>
    </div> --}}


    {{-- <br> --}}

    <br>
    <br>

</body>

</html>
