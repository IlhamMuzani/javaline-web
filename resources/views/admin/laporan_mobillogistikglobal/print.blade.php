<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-10px">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Ritase GLobal</title>
    <style>
        html,
        body {
            font-family: 'DOSVGA', Arial, Helvetica, sans-serif;
            color: black;
            font-weight: bold
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .td {
            text-align: center;
            padding: 5px;
            font-size: 10px;
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
            padding-top: 10px;
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
        <img src="{{ public_path('storage/uploads/user/logo.png') }}" alt="JAVA LINE LOGISTICS" width="150" height="50">
    </div>
    <div style="font-weight: bold; text-align: center">
        <span style="font-weight: bold; font-size: 22px;">LAPORAN RITASE GLOBAL - RANGKUMAN</span>
        <div class="text">
            @php
                $created_at = request()->query('created_at');
                $tanggal_akhir = request()->query('tanggal_akhir');
            @endphp
            @if ($created_at && $tanggal_akhir)
                <p>Periode:{{ $created_at }} s/d {{ $tanggal_akhir }}</p>
            @else
                <p>Periode: Tidak ada tanggal awal dan akhir yang diteruskan.</p>
            @endif
        </div>
    </div>
    {{-- <hr style="border-top: 0.1px solid black; margin: 1px 0;"> --}}

    </div>
    <table style="width: 100%; border-top: 1px solid black;" cellpadding="2" cellspacing="0">
        <!-- Header row -->
        <tr>
            <td class="td"
                style="text-align: left; padding: 5px; font-weight:bold; font-size: 10px; border-bottom: 1px solid black;">
                No</td>
            <td class="td"
                style="text-align: left; padding: 5px; font-weight:bold; font-size: 10px; border-bottom: 1px solid black;">
                No Kabin</td>
            <td class="td"
                style="text-align: left; padding: 5px; font-weight:bold; font-size: 10px; border-bottom: 1px solid black;">
                Sopir</td>
            <td class="td"
                style="text-align: right; padding: 5px; font-weight:bold; font-size: 10px; border-bottom: 1px solid black;">
                Ritase</td>
            <td class="td"
                style="text-align: right; padding: 5px; font-weight:bold; font-size: 10px; border-bottom: 1px solid black;">
                Total Faktur</td>
            <td class="td"
                style="text-align: right; padding: 5px; font-weight:bold; font-size: 10px; border-bottom: 1px solid black;">
                Total Memo</td>
            {{-- <td class="td"
                style="text-align: right; padding: 5px; font-weight:bold; font-size: 10px; border-bottom: 1px solid black;">
                Total Tambahan</td> --}}
            <td class="td"
                style="text-align: right; padding: 5px; font-weight:bold; font-size: 10px; border-bottom: 1px solid black;">
                Total Operasional</td>
            <td class="td"
                style="text-align: right; padding: 5px; font-weight:bold; font-size: 10px; border-bottom: 1px solid black;">
                Total Perbaikan</td>
            <td class="td"
                style="text-align: right; padding: 5px; font-weight:bold; font-size: 10px; border-bottom: 1px solid black;">
                Sub Total</td>
        </tr>
        <tr style="border-bottom: 1px solid black;">
            <td colspan="10" style="padding: 0px;"></td>
        </tr>
        <!-- Data rows -->

        @php
            $created_at = isset($created_at) ? $created_at : null;
            // $tanggal_akhir = isset($tanggal_akhir) ? $tanggal_akhir : null;
            // $tanggal_akhir = isset($tanggal_akhir) ? $tanggal_akhir . ' 23:59:59' : null;
            $tanggal_akhir = isset($tanggal_akhir) ? $tanggal_akhir . ' 23:59:59' : null;

            $totalFaktur = 0; // Initialize the total variable
            $totalMemo = 0; // Initialize the total variable
            $totalMemotambahan = 0; // Initialize the total variable
            $totalRitase = 0; // Initialize the total variable
            // $totalOperasional = 0; // Initialize the total variable
            // $totalPerbaikan = 0; // Initialize the total variable
            $totalSubtotal = 0; // Initialize the total variable
        @endphp

        @foreach ($kendaraans as $ritase)
            <tr>
                <td class="td"
                    style="text-align: left; padding: 5px; font-size: 10px; border-bottom: 1px solid black;">
                    {{ $loop->iteration }}</td>
                <td class="td"
                    style="text-align: left; padding: 5px; font-size: 10px; border-bottom: 1px solid black;">
                    {{ $ritase->no_kabin }} </td>
                <td class="td"
                    style="text-align: left; padding: 5px; font-size: 10px; border-bottom: 1px solid black;">
                    {{ $ritase->user->karyawan->nama_lengkap }}</td>
                <td class="td"
                    style="text-align: right; padding: 5px; font-size: 10px; border-bottom: 1px solid black;">
                    {{ $ritase->memo_ekspedisi->whereBetween('created_at', [$created_at, $tanggal_akhir])->count() }}
                </td>

                {{-- {{ $ritase->memo_ekspedisi_count }} --}}
                <td class="td"
                    style="text-align: right; padding: 5px; font-size: 10px; border-bottom: 1px solid black;">
                    {{ number_format(
                        optional($ritase->faktur_ekspedisi)->whereBetween('created_at', [$created_at, $tanggal_akhir])->sum('grand_total') ?? 0,
                        0,
                        ',',
                        '.',
                    ) }}
                </td>
                <td class="td"
                    style="text-align: right; padding: 5px; font-size: 10px; border-bottom: 1px solid black;">
                    {{ number_format(
                        (optional($ritase->memo_ekspedisi)->whereBetween('created_at', [
                                Carbon\Carbon::parse($created_at)->startOfDay(),
                                Carbon\Carbon::parse($tanggal_akhir)->endOfDay(),
                            ])->sum('hasil_jumlah') ??
                            0) +
                            $ritase->memo_ekspedisi->sum(function ($memoEkspedisi) use ($created_at, $tanggal_akhir) {
                                return $memoEkspedisi->memotambahan()->whereBetween('created_at', [
                                        Carbon\Carbon::parse($created_at)->startOfDay(),
                                        Carbon\Carbon::parse($tanggal_akhir)->endOfDay(),
                                    ])->sum('grand_total');
                            }),
                        0,
                        ',',
                        '.',
                    ) }}
                </td>
                {{-- <td class="td"
                    style="text-align: right; padding: 5px; font-size: 10px; border-bottom: 1px solid black;">
                    {{ number_format(
                        $ritase->memo_ekspedisi->sum(function ($memoEkspedisi) use ($created_at, $tanggal_akhir) {
                            return $memoEkspedisi->memotambahan()->whereBetween('created_at', [
                                    Carbon\Carbon::parse($created_at)->startOfDay(),
                                    Carbon\Carbon::parse($tanggal_akhir)->endOfDay(),
                                ])->sum('grand_total');
                        }),
                        0,
                        ',',
                        '.',
                    ) }}
                </td> --}}
                <td class="td"
                    style="text-align: right; padding: 5px; font-size: 10px; border-bottom: 1px solid black;">
                    0</td>
                <td class="td"
                    style="text-align: right; padding: 5px; font-size: 10px; border-bottom: 1px solid black;">
                    0</td>
                <td class="td"
                    style="text-align: right; padding: 5px; font-size: 10px; border-bottom: 1px solid black; background:rgb(206, 206, 206)">
                    {{ number_format(
                        optional($ritase->faktur_ekspedisi)->whereBetween('created_at', [
                                Carbon\Carbon::parse($created_at)->startOfDay(),
                                Carbon\Carbon::parse($tanggal_akhir)->endOfDay(),
                            ])->sum('grand_total') -
                            optional($ritase->memo_ekspedisi)->whereBetween('created_at', [
                                    Carbon\Carbon::parse($created_at)->startOfDay(),
                                    Carbon\Carbon::parse($tanggal_akhir)->endOfDay(),
                                ])->sum('hasil_jumlah') -
                            $ritase->memo_ekspedisi->sum(function ($memoEkspedisi) use ($created_at, $tanggal_akhir) {
                                return $memoEkspedisi->memotambahan()->whereBetween('created_at', [
                                        Carbon\Carbon::parse($created_at)->startOfDay(),
                                        Carbon\Carbon::parse($tanggal_akhir)->endOfDay(),
                                    ])->sum('grand_total');
                            }),
                        0,
                        ',',
                        '.',
                    ) }}
                </td>
            </tr>

            @php
                // Accumulate the grand_total for each $ritase
                $totalFaktur +=
                    optional($ritase->faktur_ekspedisi)
                        ->whereBetween('created_at', [$created_at, $tanggal_akhir])
                        ->sum('grand_total') ?? 0;

                $totalMemo +=
                    optional($ritase->memo_ekspedisi)
                        ->whereBetween('created_at', [$created_at, $tanggal_akhir])
                        ->sum('hasil_jumlah') ?? 0;

                $totalMemotambahan += $ritase->memo_ekspedisi->sum(function ($memoEkspedisi) use (
                    $created_at,
                    $tanggal_akhir,
                ) {
                    return $memoEkspedisi
                        ->memotambahan()
                        ->whereBetween('created_at', [
                            Carbon\Carbon::parse($created_at)->startOfDay(),
                            Carbon\Carbon::parse($tanggal_akhir)->endOfDay(),
                        ])
                        ->sum('grand_total');
                });

                $totalRitase +=
                    optional($ritase->memo_ekspedisi)
                        ->whereBetween('created_at', [$created_at, $tanggal_akhir])
                        ->count() ?? 0;

                // $totalFaktur +=
                //     optional($ritase->faktur_ekspedisi)
                //         ->whereBetween('created_at', [$created_at, $tanggal_akhir])
                //         ->sum('grand_total') ?? 0;

                // $totalFaktur +=
                //     optional($ritase->faktur_ekspedisi)
                //         ->whereBetween('created_at', [$created_at, $tanggal_akhir])
                //         ->sum('grand_total') ?? 0;

                $subtotalDifference =
                    optional($ritase->faktur_ekspedisi)
                        ->whereBetween('created_at', [$created_at, $tanggal_akhir])
                        ->sum('grand_total') ?? 0;

                $subtotalDifference -=
                    optional($ritase->memo_ekspedisi)
                        ->whereBetween('created_at', [$created_at, $tanggal_akhir])
                        ->sum('hasil_jumlah') ?? 0;

                $totalSubtotal += $subtotalDifference - $totalMemotambahan; // Accumulate the difference

            @endphp
        @endforeach
        <!-- Separator row -->
        <tr style="border-bottom: 1px solid black;">
            <td colspan="9" style="padding: 0px;"></td>
        </tr>
        <!-- Subtotal row -->
        @php
            $total = 0;
        @endphp
        @foreach ($inquery as $item)
            @php
                $total += $item->tabungan;
            @endphp
        @endforeach
        <tr>
            <td colspan="3"
                style="text-align: right; font-weight: bold; padding: 5px; font-size: 10px; background:rgb(190, 190, 190)">

            </td>
            <td
                style="text-align: right; font-weight: bold; padding: 5px; font-size: 10px;background:rgb(190, 190, 190)">
                {{ number_format($totalRitase, 0, ',', '.') }}</td>
            <td
                style="text-align: right; font-weight: bold; padding: 5px; font-size: 10px;background:rgb(190, 190, 190)">
                {{ number_format($totalFaktur, 0, ',', '.') }}</td>
            <td
                style="text-align: right; font-weight: bold; padding: 5px; font-size: 10px;background:rgb(190, 190, 190)">
                {{ number_format($totalMemo + $totalMemotambahan, 0, ',', '.') }}</td>
            {{-- <td
                style="text-align: right; font-weight: bold; padding: 5px; font-size: 10px;background:rgb(190, 190, 190)">
                {{ number_format($totalMemotambahan, 0, ',', '.') }}</td> --}}
            <td
                style="text-align: right; font-weight: bold; padding: 5px; font-size: 10px;background:rgb(190, 190, 190)">
                0</td>
            <td
                style="text-align: right; font-weight: bold; padding: 5px; font-size: 10px;background:rgb(190, 190, 190)">
                0</td>
            <td
                style="text-align: right; font-weight: bold; padding: 5px; font-size: 10px;background:rgb(190, 190, 190)">
                {{ number_format($totalFaktur - $totalMemo - $totalMemotambahan, 0, ',', '.') }}</td>
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
