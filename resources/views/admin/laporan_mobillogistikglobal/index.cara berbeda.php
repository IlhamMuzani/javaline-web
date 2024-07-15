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
                                <option value="perfaktur">Laporan Detail</option>
                                <option value="global" selected>Laporan Global</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="created_at">Tanggal Awal</label>
                            <input class="form-control" id="created_at" name="created_at" type="date"
                                value="{{ Request::get('created_at') }}" max="{{ date('Y-m-d') }}" />
                        </div>
                        <div class="col-md-3 mb-3">
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
                            <th>Nama Kendaraan</th>
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
                        $sortedInquery = $inquery->sortBy(function ($fakturs, $kendaraanId) use ($kendaraans) {
                        $kendaraan = $kendaraans->firstWhere('id', $kendaraanId);
                        return $kendaraan ? $kendaraan->no_kabin : '';
                        });
                        @endphp

                        @foreach ($sortedInquery as $kendaraanId => $fakturs)
                        @php
                        $kendaraan = $kendaraans->firstWhere('id', $kendaraanId);
                        if ($kendaraan) {
                        $totalFaktur = $fakturs->sum('grand_total'); // Adjust the field name as necessary

                        $jumlahMemo = $fakturs
                        ->flatMap(function ($faktur) {
                        return $faktur->detail_fakturs->filter(function ($detailFaktur) {
                        return $detailFaktur->memo_ekspedisi !== null &&
                        $detailFaktur->memo_ekspedisi->status === 'selesai';
                        });
                        })
                        ->count();

                        $grandTotalForKendaraan = $grandTotalPerKendaraan[$kendaraanId] ?? 0;
                        $detailPengeluarans = $kendaraan->detail_pengeluaran;
                        }
                        @endphp

                        @if ($kendaraan)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $kendaraan->no_kabin }}</td>
                            <td>
                                @php
                                $drivers = $fakturs
                                ->flatMap(function ($faktur) {
                                return $faktur->detail_fakturs->map(function ($detailFaktur) {
                                return $detailFaktur->memo_ekspedisi &&
                                $detailFaktur->memo_ekspedisi->status === 'selesai'
                                ? $detailFaktur->memo_ekspedisi->nama_driver
                                : null;
                                });
                                })
                                ->filter()
                                ->unique();
                                @endphp
                                {{ $drivers->join(', ') }}
                            </td>
                            <td class="text-right">{{ $jumlahMemo }}</td>
                            <td class="text-right">{{ number_format($totalFaktur, 2, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($grandTotalForKendaraan, 2, ',', '.') }}
                            </td>
                            <td class="text-right">
                                @if ($detailPengeluarans->isNotEmpty())
                                @php
                                $totalNominal = $detailPengeluarans->sum('nominal');
                                @endphp
                                {{ number_format($totalNominal, 2, ',', '.') }}
                                @else
                                0
                                @endif
                            </td>
                            <td class="text-right">
                            </td>
                            <td class="text-right">
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>






                    {{-- <td class="text-right">{{ number_format($totalGrandTotal, 2, ',', '.') }}</td> --}}


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
                case 'perfaktur':
                    window.location.href = "{{ url('admin/laporan_mobillogistik') }}";
                    break;
                case 'global':
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