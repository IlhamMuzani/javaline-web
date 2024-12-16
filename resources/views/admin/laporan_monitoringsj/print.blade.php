<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Monitoring Surat Jalan</title>
    <style>
        html,
        body {
            font-family: 'DOSVGA', Arial, Helvetica, sans-serif;
            color: black;
            margin-left: 5px;
            margin-right: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .td {
            text-align: center;
            padding: 5px;
            font-size: 8px;
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
            padding-top: 8px;
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
        <span style="font-weight: bold; font-size: 17px;">LAPORAN PENERIMAAN SURAT JALAN - RANGKUMAN</span>
        <br>
        <div class="text">
            @php
                $startDate = request()->query('tanggal_awal');
                $endDate = request()->query('tanggal_akhir');
                $total = 0;

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
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 8px; width:1%">NO
            </td>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 8px; width:7%">KODE
                SPK
            </td>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 8px; width:10%">
                PELANGGAN
            </td>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 8px; width:10%">
                TUJUAN
            </td>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 8px; width:7%">
                TANGGAL</td>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 8px; width:7%">NO
                KABIN</td>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 8px; width:10%">NAMA
                DRIVER
            </td>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 8px; width:8%">
                TIMER
            </td>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 8px; width:8%">
                TIMER TOTAL
            </td>
            <td class="td" style="text-align: left; padding: 5px; font-weight:bold; font-size: 8px; width:10%">
                PENERIMA</td>
        </tr>
        <!-- Separator row -->
        <tr style="border-bottom: 1px solid black;">
            <td colspan="5" style="padding: 0px;"></td>
        </tr>
        <!-- Data rows -->
        @foreach ($inquery as $pengambilan_do)
            <tr>
                <td class="td" style="text-align: left; padding: 5px; font-size: 8px;">{{ $loop->iteration }}</td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 8px;">
                    {{ $pengambilan_do->spk->kode_spk ?? '-' }}
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 8px;">
                    {{ $pengambilan_do->spk->nama_pelanggan ?? '-' }}
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 8px;">
                    {{ $pengambilan_do->spk->nama_rute ?? '-' }}
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 8px;">
                    {{ $pengambilan_do->tanggal_awal }}
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 8px;">
                    {{ $pengambilan_do->spk->kendaraan->no_kabin ?? '-' }}
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 8px;">
                    {{ $pengambilan_do->spk->nama_driver ?? '-' }}
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 8px;">
                    @if ($pengambilan_do->status_penerimaansj == 'posting')
                        @php
                            $timerAwal = $pengambilan_do->timer_suratjalan->last()->timer_awal ?? null;

                            // Memeriksa apakah timer_awal ada
                            if ($timerAwal) {
                                $waktuAwal = \Carbon\Carbon::parse($timerAwal);
                                $waktuSekarang = \Carbon\Carbon::now();
                                $durasi = $waktuAwal->diff($waktuSekarang);

                                // Menampilkan hasil perhitungan durasi
                                echo "{$durasi->days} hari, {$durasi->h} jam";
                            } else {
                                echo '-';
                            }
                        @endphp
                    @endif
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 8px;">
                    @php
                        $timerAwal = $pengambilan_do->waktu_suratawal ?? null;
                        $timerAkhir = $pengambilan_do->waktu_suratakhir ?? null;

                        // Memeriksa apakah timer_awal ada dan waktu_suratakhir tidak null
                        if ($timerAwal && $timerAkhir) {
                            $waktuAwal = \Carbon\Carbon::parse($timerAwal);
                            $waktuAkhir = \Carbon\Carbon::parse($timerAkhir);
                            $durasi = $waktuAwal->diff($waktuAkhir);

                            // Menampilkan hasil perhitungan durasi
                            echo "{$durasi->days} hari, {$durasi->h} jam";
                        } else {
                            // Jika waktu_suratakhir null, tampilkan '-'
                            echo '-';
                        }
                    @endphp
                </td>
                <td class="td" style="text-align: left; padding: 5px; font-size: 8px;">
                    {{ $pengambilan_do->penerima_sj ?? '-' }}
                </td>
            </tr>

            @php
                $total++;
            @endphp
        @endforeach
        <!-- Separator row -->
        <tr style="border-bottom: 1px solid black;">
            <td colspan="" style="padding: 0px;"></td>
        </tr>
        <!-- Subtotal row -->


        {{-- <tr style="color: white">
            <td colspan="2" style="text-align: right; font-weight: bold; padding: 5px; font-size: 8px;">a
            </td>
            <td style="text-align: right; font-weight: bold; padding: 5px; font-size: 8px;">a
            </td>
            <td style="text-align: right; font-weight: bold; padding: 5px; color:white; font-size: 8px;">a
            </td>
        </tr> --}}
        <tr>
            <td>
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="2" style="text-align: right; font-weight: bold; padding: 5px; font-size: 8px;">Total
            </td>
            <td style="text-align: left; font-weight: bold; padding: 5px; font-size: 8px;">{{ $total }}
            </td>
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
