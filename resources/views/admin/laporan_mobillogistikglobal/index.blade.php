@extends('layouts.app')

@section('title', 'Laporan Mobil Logistik Global')

@section('content')
    <div id="loadingSpinner" style="display: flex; align-items: center; justify-content: center; height: 100vh;">
        <i class="fas fa-spinner fa-spin" style="font-size: 3rem;"></i>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(function() {
                document.getElementById("loadingSpinner").style.display = "none";
                document.getElementById("mainContent").style.display = "block";
                document.getElementById("mainContentSection").style.display = "block";
            }, 100); // Adjust the delay time as needed
        });
    </script>

    <!-- Content Header (Page header) -->
    <div class="content-header" style="display: none;" id="mainContent">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Laporan Mobil Logistik Global</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Laporan Mobil Logistik Global</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="container-fluid">
        <div class="container-fluid">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-check"></i> Success!
                    </h5>
                    {{ session('success') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Laporan Mobil Logistik Global</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="GET" id="form-action">
                        <div class="row">
                            <div class="col-md-3 mb-2">
                                <label for="created_at">Kategori</label>
                                <select class="custom-select form-control" id="statusx" name="statusx">
                                    <option value="">- Pilih Laporan -</option>
                                    <option value="memo_perjalanan">Laporan Detail</option>
                                    <option value="memo_borong" selected>Laporan Global</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-2">
                                <label for="created_at">Status</label>
                                <select class="custom-select form-control" id="kategoris" name="kategoris">
                                    <option value="">- Semua Status -</option>
                                    <option value="memo" {{ Request::get('kategoris') == 'memo' ? 'selected' : '' }}>
                                        MEMO
                                    </option>
                                    <option value="non memo"
                                        {{ Request::get('kategoris') == 'non memo' ? 'selected' : '' }}>
                                        NON MEMO</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="created_at">Tanggal Awal</label>
                                <input class="form-control" id="created_at" name="created_at" type="date"
                                    value="{{ Request::get('created_at') }}" max="{{ date('Y-m-d') }}" />
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="tanggal_akhir">Tanggal Akhir</label>
                                <input class="form-control" id="tanggal_akhir" name="tanggal_akhir" type="date"
                                    value="{{ Request::get('tanggal_akhir') }}" max="{{ date('Y-m-d') }}" />
                            </div>
                            <div class="col-md-3 mb-3">
                                {{-- @if (auth()->check() && auth()->user()->fitur['laporan pengambilan kas kecil cari']) --}}
                                <button type="button" class="btn btn-outline-primary btn-block" onclick="cari()">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                                {{-- @endif
                                @if (auth()->check() && auth()->user()->fitur['laporan pengambilan kas kecil cetak']) --}}
                                <button type="button" class="btn btn-primary btn-block" onclick="printReport()"
                                    target="_blank">
                                    <i class="fas fa-print"></i> Cetak
                                </button>
                                <button type="button" class="btn btn-success btn-block" onclick="printExportexcel()">
                                    <i class="fas fa-file-excel"></i> Export Excel
                                </button>
                                {{-- @endif --}}
                            </div>
                        </div>
                    </form>
                    <table id="datatables66" class="table table-bordered table-striped table-hover" style="font-size: 13px">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center">No</th>
                                <th>No Kabin</th>
                                <th>Sopir</th>
                                <th>Ritase</th>
                                <th>Total Faktur</th>
                                <th>Total Memo</th>
                                {{-- <th>Total Tambahan</th> --}}
                                <th>Total Operasional</th>
                                <th>Total Perbaikan</th>
                                <th>Sub Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $created_at = isset($created_at) ? $created_at : null;
                                $tanggal_akhir = isset($tanggal_akhir) ? $tanggal_akhir . ' 23:59:59' : null;
                                $kategoris = $kategoris ?? null;
                                $totalFaktur = 0; // Initialize the total
                                $totalFakturmemo = 0; // Initialize the total
                                $totalFakturnonmemo = 0; // Initialize the total
                                $totalMemo = 0; // Initialize the total variable
                                $totalMemotambahan = 0; // Initialize the total variable
                                $totalRitase = 0; // Initialize the total variable
                                $totalOperasional = 0; // Initialize the total variable
                                $totalPerbaikan = 0; // Initialize the total variable
                                $totalSubtotal = 0; // Initialize the total variable
                                $nomorUrut = 1; // Initialize the counter for row number
                            @endphp

                            @foreach ($kendaraans as $kendaraan)
                                @php
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
                                @endphp
                                <tr>
                                    <td class="text-center">{{ $nomorUrut }}</td> {{-- Menampilkan nomor urut --}} <td>
                                        {{ $kendaraan->no_kabin }} {{ $kendaraan->no_pol }}</td>
                                    <td>
                                        @if ($kendaraan->memo_ekspedisi->whereBetween('created_at', [$created_at, $tanggal_akhir])->first())
                                            {{ $kendaraan->memo_ekspedisi->whereBetween('created_at', [$created_at, $tanggal_akhir])->first()->nama_driver }}
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        @if ($kategoris == 'non memo')
                                            0
                                        @else
                                            {{ $kendaraan->memo_ekspedisi->whereBetween('created_at', [$created_at, $tanggal_akhir])->count() }}
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        @php
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

                                        @endphp
                                        @if ($kategoris == 'memo')
                                            @if ($kategoriMemo > 0)
                                                {{ number_format($kategoriMemo, 2, ',', '.') }}
                                            @endif
                                        @elseif ($kategoris == 'non memo')
                                            @if ($kategoriNonMemo > 0)
                                                {{ number_format($kategoriNonMemo, 2, ',', '.') }}
                                            @endif
                                        @else
                                            {{ number_format($kategoriMemo + $kategoriNonMemo, 2, ',', '.') }}
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        @if ($kategoris == 'non memo')
                                            0
                                        @else
                                            {{ number_format(
                                                (optional($kendaraan->memo_ekspedisi)->whereBetween('created_at', [
                                                        Carbon\Carbon::parse($created_at)->startOfDay(),
                                                        Carbon\Carbon::parse($tanggal_akhir)->endOfDay(),
                                                    ])->sum('hasil_jumlah') ??
                                                    0) +
                                                    $kendaraan->memo_ekspedisi->sum(function ($memoEkspedisi) use ($created_at, $tanggal_akhir) {
                                                        return $memoEkspedisi->memotambahan()->whereBetween('created_at', [
                                                                Carbon\Carbon::parse($created_at)->startOfDay(),
                                                                Carbon\Carbon::parse($tanggal_akhir)->endOfDay(),
                                                            ])->sum('grand_total');
                                                    }),
                                                2,
                                                ',',
                                                '.',
                                            ) }}
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        {{ number_format(
                                            optional($kendaraan->detail_pengeluaran)->where('kode_akun', 'KA000029')->whereBetween('created_at', [
                                                    Carbon\Carbon::parse($created_at)->startOfDay(),
                                                    Carbon\Carbon::parse($tanggal_akhir)->endOfDay(),
                                                ])->sum('nominal') ?? 0,
                                            2,
                                            ',',
                                            '.',
                                        ) }}
                                    </td>
                                    <td class="text-right">
                                        {{ number_format(
                                            optional($kendaraan->detail_pengeluaran)->where('kode_akun', 'KA000015')->whereBetween('created_at', [
                                                    Carbon\Carbon::parse($created_at)->startOfDay(),
                                                    Carbon\Carbon::parse($tanggal_akhir)->endOfDay(),
                                                ])->sum('nominal') ?? 0,
                                            2,
                                            ',',
                                            '.',
                                        ) }}
                                    </td>
                                    <td class="text-right">
                                        @if ($kategoris == 'memo')
                                            @if ($kategoriMemo > 0)
                                                {{ number_format(
                                                    optional($kendaraan->faktur_ekspedisi)->whereBetween('created_at', [
                                                            Carbon\Carbon::parse($created_at)->startOfDay(),
                                                            Carbon\Carbon::parse($tanggal_akhir)->endOfDay(),
                                                        ])->where('kategoris', 'memo')->sum('grand_total') -
                                                        optional($kendaraan->memo_ekspedisi)->whereBetween('created_at', [
                                                                Carbon\Carbon::parse($created_at)->startOfDay(),
                                                                Carbon\Carbon::parse($tanggal_akhir)->endOfDay(),
                                                            ])->sum('hasil_jumlah') -
                                                        $kendaraan->memo_ekspedisi->sum(function ($memoEkspedisi) use ($created_at, $tanggal_akhir) {
                                                            return $memoEkspedisi->memotambahan()->whereBetween('created_at', [
                                                                    Carbon\Carbon::parse($created_at)->startOfDay(),
                                                                    Carbon\Carbon::parse($tanggal_akhir)->endOfDay(),
                                                                ])->sum('grand_total');
                                                        }),
                                                    2,
                                                    ',',
                                                    '.',
                                                ) }}
                                            @endif
                                        @elseif ($kategoris == 'non memo')
                                            @if ($kategoriNonMemo > 0)
                                                {{ number_format(
                                                    optional($kendaraan->faktur_ekspedisi)->whereBetween('created_at', [
                                                            Carbon\Carbon::parse($created_at)->startOfDay(),
                                                            Carbon\Carbon::parse($tanggal_akhir)->endOfDay(),
                                                        ])->where('kategoris', 'non memo')->sum('grand_total') -
                                                        optional($kendaraan->memo_ekspedisi)->whereBetween('created_at', [
                                                                Carbon\Carbon::parse($created_at)->startOfDay(),
                                                                Carbon\Carbon::parse($tanggal_akhir)->endOfDay(),
                                                            ])->sum('hasil_jumlah') -
                                                        $kendaraan->memo_ekspedisi->sum(function ($memoEkspedisi) use ($created_at, $tanggal_akhir) {
                                                            return $memoEkspedisi->memotambahan()->whereBetween('created_at', [
                                                                    Carbon\Carbon::parse($created_at)->startOfDay(),
                                                                    Carbon\Carbon::parse($tanggal_akhir)->endOfDay(),
                                                                ])->sum('grand_total');
                                                        }),
                                                    2,
                                                    ',',
                                                    '.',
                                                ) }}
                                            @endif
                                        @else
                                            {{ number_format(
                                                optional($kendaraan->faktur_ekspedisi)->whereBetween('created_at', [
                                                        Carbon\Carbon::parse($created_at)->startOfDay(),
                                                        Carbon\Carbon::parse($tanggal_akhir)->endOfDay(),
                                                    ])->sum('grand_total') -
                                                    optional($kendaraan->memo_ekspedisi)->whereBetween('created_at', [
                                                            Carbon\Carbon::parse($created_at)->startOfDay(),
                                                            Carbon\Carbon::parse($tanggal_akhir)->endOfDay(),
                                                        ])->sum('hasil_jumlah') -
                                                    $kendaraan->memo_ekspedisi->sum(function ($memoEkspedisi) use ($created_at, $tanggal_akhir) {
                                                        return $memoEkspedisi->memotambahan()->whereBetween('created_at', [
                                                                Carbon\Carbon::parse($created_at)->startOfDay(),
                                                                Carbon\Carbon::parse($tanggal_akhir)->endOfDay(),
                                                            ])->sum('grand_total');
                                                    }),
                                                2,
                                                ',',
                                                '.',
                                            ) }}
                                        @endif
                                    </td>
                                </tr>
                                @php
                                    $nomorUrut++;

                                    $totalRitase +=
                                        optional($kendaraan->memo_ekspedisi)
                                            ->whereBetween('created_at', [$created_at, $tanggal_akhir])
                                            ->count() ?? 0;
                                    // Accumulate the grand_total for each $kendaraan
                                    $totalFaktur +=
                                        optional($kendaraan->faktur_ekspedisi)
                                            ->whereBetween('created_at', [
                                                Carbon\Carbon::parse($created_at)->startOfDay(),
                                                Carbon\Carbon::parse($tanggal_akhir)->endOfDay(),
                                            ])
                                            ->sum('grand_total') ?? 0;

                                    $totalFakturmemo +=
                                        optional($kendaraan->faktur_ekspedisi)
                                            ->whereBetween('created_at', [
                                                Carbon\Carbon::parse($created_at)->startOfDay(),
                                                Carbon\Carbon::parse($tanggal_akhir)->endOfDay(),
                                            ])
                                            ->where('kategoris', 'memo')
                                            ->sum('grand_total') ?? 0;

                                    $totalFakturnonmemo +=
                                        optional($kendaraan->faktur_ekspedisi)
                                            ->whereBetween('created_at', [
                                                Carbon\Carbon::parse($created_at)->startOfDay(),
                                                Carbon\Carbon::parse($tanggal_akhir)->endOfDay(),
                                            ])
                                            ->where('kategoris', 'non memo')
                                            ->sum('grand_total') ?? 0;

                                    $totalMemo +=
                                        optional($kendaraan->memo_ekspedisi)
                                            ->whereBetween('created_at', [
                                                Carbon\Carbon::parse($created_at)->startOfDay(),
                                                Carbon\Carbon::parse($tanggal_akhir)->endOfDay(),
                                            ])
                                            ->sum('hasil_jumlah') ?? 0;

                                    $totalMemotambahan += $kendaraan->memo_ekspedisi->sum(function (
                                        $memoEkspedisi,
                                    ) use ($created_at, $tanggal_akhir) {
                                        return $memoEkspedisi
                                            ->memotambahan()
                                            ->whereBetween('created_at', [
                                                Carbon\Carbon::parse($created_at)->startOfDay(),
                                                Carbon\Carbon::parse($tanggal_akhir)->endOfDay(),
                                            ])
                                            ->sum('grand_total');
                                    });

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
                                            ->whereBetween('created_at', [
                                                Carbon\Carbon::parse($created_at)->startOfDay(),
                                                Carbon\Carbon::parse($tanggal_akhir)->endOfDay(),
                                            ])
                                            ->sum('grand_total') ?? 0;

                                    $subtotalDifference -=
                                        optional($kendaraan->memo_ekspedisi)
                                            ->whereBetween('created_at', [
                                                Carbon\Carbon::parse($created_at)->startOfDay(),
                                                Carbon\Carbon::parse($tanggal_akhir)->endOfDay(),
                                            ])
                                            ->sum('hasil_jumlah') ?? 0;

                                    $totalSubtotal += $subtotalDifference - $totalMemotambahan; // Accumulate the difference

                                @endphp
                            @endforeach
                        </tbody>
                        <tbody>
                            <tr>
                                <td colspan="3"></td>
                                <td class="text-right" style="font-weight: bold;">
                                    @if ($kategoris == 'non memo')
                                        0
                                    @else
                                        {{ number_format($totalRitase, 0, ',', '.') }}
                                    @endif
                                </td>
                                {{-- <td><strong>Total Deposit:</strong></td> --}}
                                <td class="text-right" style="font-weight: bold;">
                                    @if ($kategoris == 'memo')
                                        @if ($totalFakturmemo > 0)
                                            Rp.{{ number_format($totalFakturmemo, 2, ',', '.') }}
                                        @endif
                                    @elseif ($kategoris == 'non memo')
                                        @if ($totalFakturnonmemo > 0)
                                            Rp.{{ number_format($totalFakturnonmemo, 2, ',', '.') }}
                                        @endif
                                    @else
                                        Rp.{{ number_format($totalFaktur, 2, ',', '.') }}
                                    @endif
                                </td>
                                {{-- <td><strong>Total Saldo:</strong></td> --}}
                                <td class="text-right" style="font-weight: bold;">
                                    @if ($kategoris == 'non memo')
                                        0
                                    @else
                                        Rp.{{ number_format($totalMemo + $totalMemotambahan, 2, ',', '.') }}
                                    @endif
                                </td>
                                {{-- <td class="text-right" style="font-weight: bold;">
                                    Rp.{{ number_format($totalMemotambahan, 0, ',', '.') }}
                                </td> --}}
                                <td class="text-right" style="font-weight: bold;">
                                    Rp.
                                    {{ number_format($totalOperasional, 2, ',', '.') }}
                                </td>
                                <td class="text-right" style="font-weight: bold;">
                                    Rp.
                                    {{ number_format($totalPerbaikan, 2, ',', '.') }}
                                </td>
                                <td class="text-right" style="font-weight: bold;">

                                    @if ($kategoris == 'memo')
                                        @if ($totalFakturmemo > 0)
                                            Rp.{{ number_format($totalFakturmemo - $totalMemo - $totalMemotambahan, 2, ',', '.') }}
                                        @endif
                                    @elseif ($kategoris == 'non memo')
                                        @if ($totalFakturnonmemo > 0)
                                            Rp.{{ number_format($totalFakturnonmemo - $totalMemo - $totalMemotambahan, 2, ',', '.') }}
                                        @endif
                                    @else
                                        Rp.{{ number_format($totalFaktur - $totalMemo - $totalMemotambahan, 2, ',', '.') }}
                                    @endif

                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </section>
        <!-- /.card -->
        <script>
            var tanggalAwal = document.getElementById('created_at');
            var tanggalAkhir = document.getElementById('tanggal_akhir');
            if (tanggalAwal.value == "") {
                tanggalAkhir.readOnly = true;
            }
            tanggalAwal.addEventListener('change', function() {
                if (this.value == "") {
                    tanggalAkhir.readOnly = true;
                } else {
                    tanggalAkhir.readOnly = false;
                };
                tanggalAkhir.value = "";
                var today = new Date().toISOString().split('T')[0];
                tanggalAkhir.value = today;
                tanggalAkhir.setAttribute('min', this.value);
            });
            var form = document.getElementById('form-action')

            function cari() {
                form.action = "{{ url('admin/laporan_mobillogistikglobal') }}";
                form.submit();
            }

            function printReport() {
                var startDate = tanggalAwal.value;
                var endDate = tanggalAkhir.value;

                if (startDate && endDate) {
                    form.action = "{{ url('admin/print_mobillogistikglobal') }}" + "?start_date=" + startDate + "&end_date=" +
                        endDate;
                    form.submit();
                } else {
                    alert("Silakan isi kedua tanggal sebelum mencetak.");
                }
            }
        </script>

        <script>
            function printExportexcel() {
                var startDate = tanggalAwal.value;
                var endDate = tanggalAkhir.value;

                if (startDate && endDate) {
                    var form = document.getElementById('form-action');
                    form.action = "{{ url('admin/laporan_mobillogistikglobal/rekapexportlaporanlogistik') }}";
                    form.submit();
                } else {
                    alert("Silakan isi kedua tanggal sebelum mengeksport.");
                }
            }
        </script>

        <script>
            $(document).ready(function() {
                // Detect the change event on the 'status' dropdown
                $('#statusx').on('change', function() {
                    // Get the selected value
                    var selectedValue = $(this).val();

                    // Check the selected value and redirect accordingly
                    switch (selectedValue) {
                        case 'memo_perjalanan':
                            window.location.href = "{{ url('admin/laporan_mobillogistik') }}";
                            break;
                        case 'memo_borong':
                            window.location.href = "{{ url('admin/laporan_mobillogistikglobal') }}";
                            break;
                            // case 'akun':
                            //     window.location.href = "{{ url('admin/laporan_pengeluarankaskecilakun') }}";
                            //     break;
                            // case 'memo_tambahan':
                            //     window.location.href = "{{ url('admin/laporan_saldokas') }}";
                            //     break;
                        default:
                            // Handle other cases or do nothing
                            break;
                    }
                });
            });
        </script>

    @endsection
