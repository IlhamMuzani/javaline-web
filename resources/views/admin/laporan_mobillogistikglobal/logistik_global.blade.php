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
            $totalFakturawal = 0; // Initialize the total
            $totalFakturtambahan = 0; // Initialize the total
            $totalFakturpph = 0; // Initialize the total
            $totalFakturmemo = 0;
            $totalFaktur = 0;
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

                // Hitung ritase
                $ritase =
                    optional($kendaraan->memo_ekspedisi)
                        ->where('status', 'selesai')
                        ->whereBetween('created_at', [$created_at, $tanggal_akhir])
                        ->count() ?? 0;
                $totalRitase += $ritase;

                // Hitung total faktur
                $faktursx =
                    optional($kendaraan->faktur_ekspedisi)
                        ->whereIn('status', ['posting', 'selesai'])
                        ->whereBetween('created_at', [$created_at, $tanggal_akhir])
                        ->where('kategoris', 'memo')
                        ->sum('total_tarif') +
                        optional($kendaraan->faktur_ekspedisi)
                            ->whereIn('status', ['posting', 'selesai'])
                            ->whereBetween('created_at', [$created_at, $tanggal_akhir])
                            ->where('kategoris', 'memo')
                            ->sum('biaya_tambahan') -
                        optional($kendaraan->faktur_ekspedisi)
                            ->whereIn('status', ['posting', 'selesai'])
                            ->whereBetween('created_at', [$created_at, $tanggal_akhir])
                            ->where('kategoris', 'memo')
                            ->sum('pph') ??
                    0;
                $totalFaktur += $faktursx;

                // Hitung total faktur memo
                $fakturmemo =
                    optional($kendaraan->faktur_ekspedisi)
                        ->whereIn('status', ['posting', 'selesai'])
                        ->whereBetween('created_at', [$created_at, $tanggal_akhir])
                        ->where('kategoris', 'memo')
                        ->sum('grand_total') ?? 0;
                $totalFakturmemo += $fakturmemo;

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
                $subtotalDifference = $faktursx;
                $totalSubtotal += $subtotalDifference;
            @endphp

            <tr>
                <td> {{ $nomorUrut }}</td>
                <td>{{ $kendaraan->no_kabin }} {{ $kendaraan->no_pol }}</td>
                <td>
                    @if ($kendaraan->memo_ekspedisi->where('status', 'selesai')->whereBetween('created_at', [$created_at, $tanggal_akhir])->first())
                        {{ $kendaraan->memo_ekspedisi->where('status', 'selesai')->whereBetween('created_at', [$created_at, $tanggal_akhir])->first()->nama_driver }}
                    @endif
                </td>
                <td>@php
                    $totalRitase = 0;
                @endphp
                    @foreach ($kendaraan->faktur_ekspedisi->whereBetween('created_at', [$created_at, $tanggal_akhir]) as $faktur)
                        {{-- Faktur ID: {{ $faktur->id }} --}}
                        @foreach ($faktur->detail_faktur as $detail)
                            {{-- Detail Faktur ID: {{ $detail->id }} --}}
                            @if ($memo = $detail->memo_ekspedisi->first())
                                {{-- Memo Ekspedisi ID: {{ $memo->id }} --}}
                                @php
                                    $totalRitase++;
                                @endphp
                            @else
                                Tidak ada memo ekspedisi
                            @endif
                        @endforeach
                    @endforeach
                    {{ $totalRitase }}
                </td>

                <td>Rp. {{ number_format($faktursx, 2, ',', '.') }}</td>
                <td>Rp. @php
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
            <td>@php
                $totalSemuaRitase = 0; // Inisialisasi variabel untuk total ritase semua kendaraan
                $totalHasilJumlahall = 0;
                $totalHasilJumlahtambahanall = 0;
            @endphp
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
                    @endphp
                @endforeach
                {{ $totalSemuaRitase }}
            </td>
            <td>{{ number_format($totalFaktur, 2, ',', '.') }}</td>
            <td>
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
                {{ number_format($totalHasilJumlahall + $totalHasilJumlahtambahanall, 2, ',', '.') }}
            </td>
            <td>{{ number_format($totalOperasional, 2, ',', '.') }}</td>
            <td>{{ number_format($totalPerbaikan, 2, ',', '.') }}</td>
            <td>{{ number_format($totalSubtotal - $totalHasilJumlahall - $totalHasilJumlahtambahanall, 2, ',', '.') }}
            </td>
        </tr>
    </tfoot>
</table>
