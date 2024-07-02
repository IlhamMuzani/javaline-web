<table>
    <thead>
        <tr>
            <th>No</th>
            <th>No Kabin</th>
            <th>Sopir</th>
            <th>Ritase</th>
            <th>Total Faktur</th>
            <th>Total Memo</th>
            <th>Total Operasional</th>
            <th>Total Perbaikan</th>
            <th>Sub Total</th>
        </tr>
    </thead>
    <tbody>
        @php
            $totalFaktur = 0;
            $totalFakturmemo = 0;
            $totalFakturnonmemo = 0;
            $totalMemo = 0;
            $totalMemotambahan = 0;
            $totalRitase = 0;
            $totalOperasional = 0;
            $totalPerbaikan = 0;
            $totalSubtotal = 0;
            $nomorUrut = 1; // Initialize the counter for row number
        @endphp

        @foreach ($kendaraans as $kendaraan)
            @php
                // Menggunakan nilai yang sudah ada atau nilai default
                $created_at = $created_at ?? Carbon\Carbon::now()->startOfMonth();
                $tanggal_akhir = $tanggal_akhir ?? Carbon\Carbon::now()->endOfMonth();
                $kategoris = $kategoris ?? null;

                // Menambahkan 23:59:59 hanya sekali
                $tanggal_akhir = Carbon\Carbon::parse($tanggal_akhir)->endOfDay();

                // Calculate necessary values
                $kategoriMemo =
                    optional($kendaraan->faktur_ekspedisi)
                        ->whereBetween('created_at', [
                            Carbon\Carbon::parse($created_at)->startOfDay(),
                            Carbon\Carbon::parse($tanggal_akhir)->endOfDay(),
                        ])
                        ->where('kategoris', 'memo')
                        ->sum('grand_total') ?? 0;

                $kategoriNonMemo =
                    optional($kendaraan->faktur_ekspedisi)
                        ->whereBetween('created_at', [
                            Carbon\Carbon::parse($created_at)->startOfDay(),
                            Carbon\Carbon::parse($tanggal_akhir)->endOfDay(),
                        ])
                        ->where('kategoris', 'non memo')
                        ->sum('grand_total') ?? 0;

                // Calculate the total faktur for the kendaraan
                $totalFakturKendaraan = $kategoriMemo + $kategoriNonMemo;

                // Skip rendering if total faktur is 0
                if ($totalFakturKendaraan <= 0) {
                    continue;
                }

                

                // Hitung ritase
                $ritase =
                    optional($kendaraan->memo_ekspedisi)
                        ->whereBetween('created_at', [$created_at, $tanggal_akhir])
                        ->count() ?? 0;
                $totalRitase += $ritase;

                // Hitung total faktur
                $faktur =
                    optional($kendaraan->faktur_ekspedisi)
                        ->whereBetween('created_at', [$created_at, $tanggal_akhir])
                        ->sum('grand_total') ?? 0;
                $totalFaktur += $faktur;

                // Hitung total faktur memo
                $fakturmemo =
                    optional($kendaraan->faktur_ekspedisi)
                        ->whereBetween('created_at', [$created_at, $tanggal_akhir])
                        ->where('kategoris', 'memo')
                        ->sum('grand_total') ?? 0;
                $totalFakturmemo += $fakturmemo;

                // Hitung total faktur non memo
                $fakturnonmemo =
                    optional($kendaraan->faktur_ekspedisi)
                        ->whereBetween('created_at', [$created_at, $tanggal_akhir])
                        ->where('kategoris', 'non memo')
                        ->sum('grand_total') ?? 0;
                $totalFakturnonmemo += $fakturnonmemo;

                // Hitung total memo
                $memo =
                    optional($kendaraan->memo_ekspedisi)
                        ->whereBetween('created_at', [$created_at, $tanggal_akhir])
                        ->sum('hasil_jumlah') ?? 0;
                $totalMemo += $memo;

                // Hitung total memo tambahan
                $memotambahan = $kendaraan->memo_ekspedisi->sum(function ($memoEkspedisi) use (
                    $created_at,
                    $tanggal_akhir,
                ) {
                    return $memoEkspedisi
                        ->memotambahan()
                        ->whereBetween('created_at', [$created_at, $tanggal_akhir])
                        ->sum('grand_total');
                });
                $totalMemotambahan += $memotambahan;

                // Hitung total operasional
                $operasional =
                    optional($kendaraan->detail_pengeluaran)
                        ->where('kode_akun', 'KA000029')
                        ->whereBetween('created_at', [$created_at, $tanggal_akhir])
                        ->sum('nominal') ?? 0;
                $totalOperasional += $operasional;

                // Hitung total perbaikan
                $perbaikan =
                    optional($kendaraan->detail_pengeluaran)
                        ->where('kode_akun', 'KA000015')
                        ->whereBetween('created_at', [$created_at, $tanggal_akhir])
                        ->sum('nominal') ?? 0;
                $totalPerbaikan += $perbaikan;

                // Hitung sub total
                $subtotalDifference = $faktur - $memo;
                $totalSubtotal += $subtotalDifference - $memotambahan;
            @endphp

            <tr>
                <td> {{ $nomorUrut }}</td>
                <td>{{ $kendaraan->no_kabin }} {{ $kendaraan->no_pol }}</td>
                <td>
                    @if ($kendaraan->memo_ekspedisi->whereBetween('created_at', [$created_at, $tanggal_akhir])->first())
                        {{ $kendaraan->memo_ekspedisi->whereBetween('created_at', [$created_at, $tanggal_akhir])->first()->nama_driver }}
                    @endif
                </td>
                <td>{{ number_format($ritase, 0, ',', '.') }}</td>
                <td>Rp. {{ number_format($faktur, 2, ',', '.') }}</td>
                <td>Rp. {{ number_format($memo + $memotambahan, 2, ',', '.') }}</td>
                <td>Rp. {{ number_format($operasional, 2, ',', '.') }}</td>
                <td>Rp. {{ number_format($perbaikan, 2, ',', '.') }}</td>
                <td>Rp. {{ number_format($totalSubtotal, 2, ',', '.') }}</td>
            </tr>
            @php
                $nomorUrut++;
            @endphp
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3"></td>
            <td>{{ number_format($totalRitase, 0, ',', '.') }}</td>
            <td>{{ number_format($totalFaktur, 2, ',', '.') }}</td>
            <td>{{ number_format($totalMemo + $totalMemotambahan, 2, ',', '.') }}</td>
            <td>{{ number_format($totalOperasional, 2, ',', '.') }}</td>
            <td>{{ number_format($totalPerbaikan, 2, ',', '.') }}</td>
            <td>{{ number_format($totalSubtotal, 2, ',', '.') }}</td>
        </tr>
    </tfoot>
</table>
