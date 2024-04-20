@extends('layouts.app')

@section('title', 'Laporan Mobil Logistik Global')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
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
    <section class="content">
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
                            <div class="col-md-2 mb-3">
                                <label for="created_at">Kategori</label>
                                <select class="custom-select form-control" id="statusx" name="statusx">
                                    <option value="">- Pilih Laporan -</option>
                                    <option value="memo_perjalanan">Laporan Detail</option>
                                    <option value="memo_borong" selected>Laporan Global</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="created_at">Tanggal Awal</label>
                                <input class="form-control" id="created_at" name="created_at" type="date"
                                    value="{{ Request::get('created_at') }}" max="{{ date('Y-m-d') }}" />
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="tanggal_akhir">Tanggal Akhir</label>
                                <input class="form-control" id="tanggal_akhir" name="tanggal_akhir" type="date"
                                    value="{{ Request::get('tanggal_akhir') }}" max="{{ date('Y-m-d') }}" />
                            </div>
                            <div class="col-md-2 mb-3">
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
                                $totalFaktur = 0; // Initialize the total variable
                                $totalMemo = 0; // Initialize the total variable
                                $totalMemotambahan = 0; // Initialize the total variable
                                $totalRitase = 0; // Initialize the total variable
                                $totalOperasional = 0; // Initialize the total variable
                                $totalPerbaikan = 0; // Initialize the total variable
                                $totalSubtotal = 0; // Initialize the total variable
                            @endphp

                            @foreach ($kendaraans as $kendaraan)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $kendaraan->no_kabin }} {{ $kendaraan->no_pol }}</td>
                                    <td>
                                        @if ($kendaraan->user)
                                            {{ $kendaraan->user->karyawan->nama_lengkap }}
                                        @else
                                            tidak ada
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        {{ $kendaraan->memo_ekspedisi->whereBetween('created_at', [$created_at, $tanggal_akhir])->count() }}

                                    </td>
                                    <td class="text-right">
                                        {{ number_format(
                                            optional($kendaraan->faktur_ekspedisi)->whereBetween('created_at', [
                                                    Carbon\Carbon::parse($created_at)->startOfDay(),
                                                    Carbon\Carbon::parse($tanggal_akhir)->endOfDay(),
                                                ])->sum('grand_total') ?? 0,
                                            0,
                                            ',',
                                            '.',
                                        ) }}
                                    </td>
                                    <td class="text-right">
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
                                            0,
                                            ',',
                                            '.',
                                        ) }}
                                    </td>
                                    {{-- <td class="text-right">
                                        {{ number_format(
                                            $kendaraan->memo_ekspedisi->sum(function ($memoEkspedisi) use ($created_at, $tanggal_akhir) {
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

                                    <td class="text-right">
                                        {{ number_format(
                                            optional($kendaraan->detail_pengeluaran)->where('kode_akun', 'KA000029')->whereBetween('created_at', [
                                                    Carbon\Carbon::parse($created_at)->startOfDay(),
                                                    Carbon\Carbon::parse($tanggal_akhir)->endOfDay(),
                                                ])->sum('nominal') ?? 0,
                                            0,
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
                                            0,
                                            ',',
                                            '.',
                                        ) }}
                                    </td>
                                    <td class="text-right">
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
                                            0,
                                            ',',
                                            '.',
                                        ) }}
                                    </td>
                                </tr>
                                @php
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
                                    {{ number_format($totalRitase, 0, ',', '.') }}
                                </td>
                                {{-- <td><strong>Total Deposit:</strong></td> --}}
                                <td class="text-right" style="font-weight: bold;">
                                    Rp.{{ number_format($totalFaktur, 0, ',', '.') }}
                                </td>
                                {{-- <td><strong>Total Saldo:</strong></td> --}}
                                <td class="text-right" style="font-weight: bold;">
                                    Rp.{{ number_format($totalMemo + $totalMemotambahan, 0, ',', '.') }}
                                </td>
                                {{-- <td class="text-right" style="font-weight: bold;">
                                    Rp.{{ number_format($totalMemotambahan, 0, ',', '.') }}
                                </td> --}}
                                <td class="text-right" style="font-weight: bold;">
                                    Rp.
                                    {{ number_format($totalOperasional, 0, ',', '.') }}
                                </td>
                                <td class="text-right" style="font-weight: bold;">
                                    Rp.
                                    {{ number_format($totalPerbaikan, 0, ',', '.') }}
                                </td>
                                <td class="text-right" style="font-weight: bold;">
                                    Rp.{{ number_format($totalFaktur - $totalMemo - $totalMemotambahan, 0, ',', '.') }}
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
