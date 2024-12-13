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
            margin: 1cm;
            counter-increment: page;
            counter-reset: page 1;
        }

        /* Define the footer with page number */
        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: start;
            font-size: 10px;
        }

        footer::after {
            content: counter(page);
        }
    </style>
</head>

<body style="margin: 0; padding: 0;">
    <div id="logo-container">
        <img src="{{ public_path('storage/uploads/user/logo.png') }}" alt="JAVA LINE LOGISTICS" width="150"
            height="50">
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
            <td class="td"
                style="text-align: right; padding: 5px; font-weight:bold; font-size: 10px; border-bottom: 1px solid black;">
                Total MA</td>
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
            $tanggal_akhir = isset($tanggal_akhir) ? $tanggal_akhir . ' 23:59:59' : null;
            $kategoris = $kategoris ?? null;
            $totalFakturawal = 0; // Initialize the total
            $totalFakturtambahan = 0; // Initialize the total
            $totalFakturpph = 0; // Initialize the total
            $totalFakturmemo = 0; // Initialize the total
            $totalFakturnonmemo = 0; // Initialize the total
            $totalMemo = 0; // Initialize the total variable
            $totalMemotambahan = 0; // Initialize the total variable
            $totalRitase = 0; // Initialize the total variable
            $totalOperasional = 0; // Initialize the total variable
            $totalPerbaikan = 0; // Initialize the total variable
            $totalSubtotal = 0; // Initialize the total variable
            $nomorUrut = 1; // Initialize the counter for row number
            $totalMemoasuransi = 0;
            $totalJumlahasuran = 0;
        @endphp

        @foreach ($kendaraans as $kendaraan)
            @php
                // Calculate necessary values
                $kategoriMemo =
                    optional($kendaraan->faktur_ekspedisi)
                        ->whereIn('status', ['posting', 'selesai'])
                        ->whereBetween('created_at', [
                            Carbon\Carbon::parse($created_at)->startOfDay(),
                            Carbon\Carbon::parse($tanggal_akhir)->endOfDay(),
                        ])
                        ->where('kategoris', 'memo')
                        ->sum('grand_total') ?? 0;
                // Calculate the total faktur for the kendaraan
                $totalFakturKendaraan = $kategoriMemo;
                // Skip rendering if total faktur is 0
                if ($totalFakturKendaraan <= 0) {
                    continue;
                }
            @endphp
            <tr>
                <td class="td"
                    style="text-align: left; padding: 5px; font-size: 10px; border-bottom: 1px solid black;">
                    {{ $nomorUrut }}</td>
                <td class="td"
                    style="text-align: left; padding: 5px; font-size: 10px; border-bottom: 1px solid black;">
                    {{ $kendaraan->no_kabin }} </td>
                <td class="td"
                    style="text-align: left; padding: 5px; font-size: 10px; border-bottom: 1px solid black;">
                    @if ($kendaraan->memo_ekspedisi->where('status', 'selesai')->whereBetween('created_at', [$created_at, $tanggal_akhir])->first())
                        {{ $kendaraan->memo_ekspedisi->where('status', 'selesai')->whereBetween('created_at', [$created_at, $tanggal_akhir])->first()->nama_driver }}
                    @endif
                </td>

                <td class="td"
                    style="text-align: right; padding: 5px; font-size: 10px; border-bottom: 1px solid black;">
                    @php
                        $totalRitase = 0;
                    @endphp
                    @foreach ($kendaraan->faktur_ekspedisi->whereBetween('created_at', [$created_at, $tanggal_akhir]) as $faktur)
                        {{-- Faktur ID: {{ $faktur->id }} --}}
                        @php
                            $totalRitase++;
                        @endphp
                    @endforeach
                    {{ $totalRitase }}
                </td>

                {{-- {{ $kendaraan->memo_ekspedisi_count }} --}}
                <td class="td"
                    style="text-align: right; padding: 5px; font-size: 10px; border-bottom: 1px solid black;">
                    @php
                        $totalTarifMemo =
                            optional($kendaraan->faktur_ekspedisi)
                                ->whereIn('status', ['posting', 'selesai'])
                                ->whereBetween('created_at', [
                                    Carbon\Carbon::parse($created_at)->startOfDay(),
                                    Carbon\Carbon::parse($tanggal_akhir)->endOfDay(),
                                ])
                                ->where('kategoris', 'memo')
                                ->sum('total_tarif') ?? 0;

                        $biayaTambahanMemo =
                            optional($kendaraan->faktur_ekspedisi)
                                ->whereIn('status', ['posting', 'selesai'])
                                ->whereBetween('created_at', [
                                    Carbon\Carbon::parse($created_at)->startOfDay(),
                                    Carbon\Carbon::parse($tanggal_akhir)->endOfDay(),
                                ])
                                ->where('kategoris', 'memo')
                                ->sum('biaya_tambahan') ?? 0;

                        $pphMemo =
                            optional($kendaraan->faktur_ekspedisi)
                                ->whereIn('status', ['posting', 'selesai'])
                                ->whereBetween('created_at', [
                                    Carbon\Carbon::parse($created_at)->startOfDay(),
                                    Carbon\Carbon::parse($tanggal_akhir)->endOfDay(),
                                ])
                                ->where('kategoris', 'memo')
                                ->sum('pph') ?? 0;

                        $operasional =
                            optional($kendaraan->detail_pengeluaran)
                                ->where('kode_akun', 'KA000029')
                                ->whereBetween('created_at', [
                                    Carbon\Carbon::parse($created_at)->startOfDay(),
                                    Carbon\Carbon::parse($tanggal_akhir)->endOfDay(),
                                ])
                                ->sum('nominal') ?? 0;

                        $perbaikan =
                            optional($kendaraan->detail_pengeluaran)
                                ->where('kode_akun', 'KA000015')
                                ->whereBetween('created_at', [
                                    Carbon\Carbon::parse($created_at)->startOfDay(),
                                    Carbon\Carbon::parse($tanggal_akhir)->endOfDay(),
                                ])
                                ->sum('nominal') ?? 0;

                        $fakawal = $totalTarifMemo + $biayaTambahanMemo - $pphMemo;
                    @endphp
                    {{ number_format($fakawal, 2, ',', '.') }}
                </td>
                <td class="td"
                    style="text-align: right; padding: 5px; font-size: 10px; border-bottom: 1px solid black;">
                    @php
                        $totalHasilJumlah = 0;
                        $totalHasilJumlahtambahan = 0;
                    @endphp

                    @foreach ($kendaraan->faktur_ekspedisi->whereBetween('created_at', [$created_at, $tanggal_akhir]) as $faktur)
                        @foreach ($faktur->detail_faktur as $detail)
                            @php
                                $totalHasilJumlah += $detail->memo_ekspedisi->hasil_jumlah;
                            @endphp
                            {{-- {{ $detail->memo_ekspedisi->hasil_jumlah }} --}}
                            @foreach ($detail->memo_ekspedisi->memotambahan as $item)
                                {{-- {{ $item->grand_total }} --}}
                                @php
                                    $totalHasilJumlahtambahan += $item->grand_total;
                                @endphp
                            @endforeach
                        @endforeach
                    @endforeach
                    {{-- <p>Total: {{ $totalHasilJumlah }}</p>
                                        <p>Total: {{ $totalHasilJumlahtambahan }}</p> --}}
                    {{ number_format($totalHasilJumlah + $totalHasilJumlahtambahan, 2, ',', '.') }}
                </td>
                <td class="td"
                    style="text-align: right; padding: 5px; font-size: 10px; border-bottom: 1px solid black;">
                    @php
                        $memoAsuransiCollection = optional($kendaraan->memo_asuransi)
                            ->whereIn('status', ['posting', 'selesai'])
                            ->whereBetween('created_at', [
                                Carbon\Carbon::parse($created_at)->startOfDay(),
                                Carbon\Carbon::parse($tanggal_akhir)->endOfDay(),
                            ]);

                        // Tampilkan ID memo_asuransi dan jumlah hasil_tarif
                        $idsMemoAsuransi = $memoAsuransiCollection->pluck('id')->implode(', '); // Ambil ID memo_asuransi dalam format string terpisah dengan koma
                        $totalMemoasuransi = $memoAsuransiCollection->sum('hasil_tarif'); // Jumlahkan semua hasil_tarif
                    @endphp
                    {{ number_format($totalMemoasuransi, 2, ',', '.') }}
                </td>
                <td class="td"
                    style="text-align: right; padding: 5px; font-size: 10px; border-bottom: 1px solid black;">
                    {{ number_format($operasional, 2, ',', '.') }}
                </td>
                <td class="td"
                    style="text-align: right; padding: 5px; font-size: 10px; border-bottom: 1px solid black;">
                    {{ number_format($perbaikan, 2, ',', '.') }}
                </td>
                <td class="td"
                    style="text-align: right; padding: 5px; font-size: 10px; border-bottom: 1px solid black; background:rgb(206, 206, 206)">
                    {{ number_format($fakawal - $totalHasilJumlah - $totalHasilJumlahtambahan - $operasional - $perbaikan, 2, ',', '.') }}
                </td>
            </tr>

            @php
                $nomorUrut++;

                $totalRitase +=
                    optional($kendaraan->memo_ekspedisi)
                        ->where('status', 'selesai')
                        ->whereBetween('created_at', [$created_at, $tanggal_akhir])
                        ->count() ?? 0;

                $totalFakturawal +=
                    optional($kendaraan->faktur_ekspedisi)
                        ->whereIn('status', ['posting', 'selesai'])
                        ->whereBetween('created_at', [
                            Carbon\Carbon::parse($created_at)->startOfDay(),
                            Carbon\Carbon::parse($tanggal_akhir)->endOfDay(),
                        ])
                        ->where('kategoris', 'memo')
                        ->sum('total_tarif') ?? 0;

                $totalFakturtambahan +=
                    optional($kendaraan->faktur_ekspedisi)
                        ->whereIn('status', ['posting', 'selesai'])
                        ->whereBetween('created_at', [
                            Carbon\Carbon::parse($created_at)->startOfDay(),
                            Carbon\Carbon::parse($tanggal_akhir)->endOfDay(),
                        ])
                        ->where('kategoris', 'memo')
                        ->sum('biaya_tambahan') ?? 0;

                $totalFakturpph +=
                    optional($kendaraan->faktur_ekspedisi)
                        ->whereIn('status', ['posting', 'selesai'])
                        ->whereBetween('created_at', [
                            Carbon\Carbon::parse($created_at)->startOfDay(),
                            Carbon\Carbon::parse($tanggal_akhir)->endOfDay(),
                        ])
                        ->where('kategoris', 'memo')
                        ->sum('pph') ?? 0;
                // Accumulate the grand_total for each $kendaraan
                $totalFakturmemo +=
                    optional($kendaraan->faktur_ekspedisi)
                        ->whereIn('status', ['posting', 'selesai'])
                        ->whereBetween('created_at', [
                            Carbon\Carbon::parse($created_at)->startOfDay(),
                            Carbon\Carbon::parse($tanggal_akhir)->endOfDay(),
                        ])
                        ->where('kategoris', 'memo')
                        ->sum('grand_total') ?? 0;
                $totalMemo +=
                    optional($kendaraan->memo_ekspedisi)
                        ->where('status', 'selesai')
                        ->whereBetween('created_at', [
                            Carbon\Carbon::parse($created_at)->startOfDay(),
                            Carbon\Carbon::parse($tanggal_akhir)->endOfDay(),
                        ])
                        ->sum('hasil_jumlah') ?? 0;

                $totalMemotambahan += $kendaraan->memo_ekspedisi
                    ->where('status', 'selesai')
                    ->sum(function ($memoEkspedisi) use ($created_at, $tanggal_akhir) {
                        return $memoEkspedisi
                            ->memotambahan()
                            ->whereBetween('created_at', [
                                Carbon\Carbon::parse($created_at)->startOfDay(),
                                Carbon\Carbon::parse($tanggal_akhir)->endOfDay(),
                            ])
                            ->sum('grand_total');
                    });

                $totalMemoasuransi =
                    optional($kendaraan->memo_asuransi)
                        ->whereIn('status', ['posting', 'selesai'])
                        ->whereBetween('created_at', [
                            Carbon\Carbon::parse($created_at)->startOfDay(),
                            Carbon\Carbon::parse($tanggal_akhir)->endOfDay(),
                        ])
                        ->sum('hasil_tarif') ?? 0;

                $totalOperasional +=
                    optional($kendaraan->detail_pengeluaran)
                        ->where('kode_akun', 'KA000029')
                        ->whereBetween('created_at', [
                            Carbon\Carbon::parse($created_at)->startOfDay(),
                            Carbon\Carbon::parse($tanggal_akhir)->endOfDay(),
                        ])
                        ->sum('nominal') ?? 0;

                $totalPerbaikan +=
                    optional($kendaraan->detail_pengeluaran)
                        ->where('kode_akun', 'KA000015')
                        ->whereBetween('created_at', [
                            Carbon\Carbon::parse($created_at)->startOfDay(),
                            Carbon\Carbon::parse($tanggal_akhir)->endOfDay(),
                        ])
                        ->sum('nominal') ?? 0;

                $subtotalDifference =
                    optional($kendaraan->faktur_ekspedisi)
                        ->whereIn('status', ['posting', 'selesai'])

                        ->whereBetween('created_at', [
                            Carbon\Carbon::parse($created_at)->startOfDay(),
                            Carbon\Carbon::parse($tanggal_akhir)->endOfDay(),
                        ])
                        ->where('kategoris', 'memo')
                        ->sum('grand_total') ?? 0;

                $subtotalDifference -=
                    optional($kendaraan->memo_ekspedisi)
                        ->where('status', 'selesai')
                        ->whereBetween('created_at', [
                            Carbon\Carbon::parse($created_at)->startOfDay(),
                            Carbon\Carbon::parse($tanggal_akhir)->endOfDay(),
                        ])
                        ->sum('hasil_jumlah') ?? 0;

                $totalSubtotal += $subtotalDifference - $totalMemotambahan; // Accumulate the difference
                $totalJumlahasuran += $totalMemoasuransi; // Accumulate the difference

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
                @php
                    $totalSemuaRitase = 0; // Inisialisasi variabel untuk total ritase semua kendaraan
                    $totalHasilJumlahall = 0;
                    $totalHasilJumlahtambahanall = 0;
                @endphp
                @foreach ($kendaraans as $kendaraan)
                    @php
                        $totalRitaseKendaraan = $kendaraan->faktur_ekspedisi
                            ->whereBetween('created_at', [$created_at, $tanggal_akhir])
                            ->count();
                        $totalSemuaRitase += $totalRitaseKendaraan;
                    @endphp
                @endforeach
                {{ $totalSemuaRitase }}
            </td>
            <td
                style="text-align: right; font-weight: bold; padding: 5px; font-size: 10px;background:rgb(190, 190, 190)">
                Rp.{{ number_format($totalFakturawal + $totalFakturtambahan - $totalFakturpph, 2, ',', '.') }}
            </td>
            <td
                style="text-align: right; font-weight: bold; padding: 5px; font-size: 10px;background:rgb(190, 190, 190)">
                @foreach ($kendaraans as $kendaraan)
                    @php
                        $totalRitaseKendaraan = 0;
                        foreach (
                            $kendaraan->faktur_ekspedisi->whereBetween('created_at', [$created_at, $tanggal_akhir])
                            as $faktur
                        ) {
                            foreach ($faktur->detail_faktur as $detail) {
                                if ($memo = $detail->memo_ekspedisi->first()) {
                                    $totalRitaseKendaraan++;
                                }
                            }
                        }
                        $totalSemuaRitase += $totalRitaseKendaraan;

                        // Hitung total hasil jumlah dan total tambahan semua kendaraan
                        foreach (
                            $kendaraan->faktur_ekspedisi->whereBetween('created_at', [$created_at, $tanggal_akhir])
                            as $faktur
                        ) {
                            foreach ($faktur->detail_faktur as $detail) {
                                $totalHasilJumlahall += $detail->memo_ekspedisi->hasil_jumlah;

                                foreach ($detail->memo_ekspedisi->memotambahan as $item) {
                                    $totalHasilJumlahtambahanall += $item->grand_total;
                                }
                            }
                        }
                    @endphp
                    {{-- Iterasi lainnya seperti yang telah Anda implementasikan --}}
                @endforeach
                Rp.{{ number_format($totalHasilJumlahall + $totalHasilJumlahtambahanall, 2, ',', '.') }}
            </td>
            {{-- <td
                style="text-align: right; font-weight: bold; padding: 5px; font-size: 10px;background:rgb(190, 190, 190)">
                {{ number_format($totalMemotambahan, 0, ',', '.') }}</td> --}}
            <td
                style="text-align: right; font-weight: bold; padding: 5px; font-size: 10px;background:rgb(190, 190, 190)">
                {{ number_format($totalJumlahasuran, 2, ',', '.') }}</td>
            <td
                style="text-align: right; font-weight: bold; padding: 5px; font-size: 10px;background:rgb(190, 190, 190)">
                {{ number_format($totalOperasional, 2, ',', '.') }}</td>
            <td
                style="text-align: right; font-weight: bold; padding: 5px; font-size: 10px;background:rgb(190, 190, 190)">
                {{ number_format($totalPerbaikan, 2, ',', '.') }}</td>
            <td
                style="text-align: right; font-weight: bold; padding: 5px; font-size: 10px;background:rgb(190, 190, 190)">
                {{-- {{ number_format($totalFaktur - $totalMemo - $totalMemotambahan, 0, ',', '.') }} --}}
                Rp.{{ number_format($totalFakturawal + $totalFakturtambahan - $totalFakturpph - $totalHasilJumlahall - $totalHasilJumlahtambahanall - $totalOperasional - $totalPerbaikan - $totalJumlahasuran, 2, ',', '.') }}
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


    <footer style="position: fixed; bottom: 0; right: 20px; width: auto; text-align: end; font-size: 10px;">Page
    </footer>


</body>

</html>
