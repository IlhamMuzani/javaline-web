@extends('layouts.app')

@section('title', 'Laporan Monitoring SJ')

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
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content" style="display: none;" id="mainContentSection">
        <div class="container-fluid">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-check"></i> Berhasil!
                    </h5>
                    {{ session('success') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Laporan Monitoring Surat Jalan</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="GET" id="form-action">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="tanggal_awal">Kategori</label>
                                <select class="custom-select form-control" id="statusx" name="statusx">
                                    <option value="">- Pilih Laporan -</option>
                                    <option value="detail">Detail</option>
                                    <option value="global"selected>Global</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="tanggal_awal">Tanggal Awal</label>
                                <input class="form-control" id="tanggal_awal" name="tanggal_awal" type="date"
                                    value="{{ Request::get('tanggal_awal') }}" max="{{ date('Y-m-d') }}" />
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="tanggal_akhir">Tanggal Akhir</label>
                                <input class="form-control" id="tanggal_akhir" name="tanggal_akhir" type="date"
                                    value="{{ Request::get('tanggal_akhir') }}" max="{{ date('Y-m-d') }}" />
                            </div>
                            <div class="col-md-3 mb-3">
                                @if (auth()->check() && auth()->user()->fitur['laporan pemasangan part cari'])
                                    <button type="button" class="btn btn-outline-primary btn-block" onclick="cari()">
                                        <i class="fas fa-search"></i> Cari
                                    </button>
                                @endif
                                @if (auth()->check() && auth()->user()->fitur['laporan pemasangan part cetak'])
                                    <button type="button" class="btn btn-primary btn-block" onclick="printReport()"
                                        target="_blank">
                                        <i class="fas fa-print"></i> Cetak
                                    </button>
                                @endif
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive" style="overflow-x: auto;">
                        <table id="datatables66" class="table table-bordered table-striped table-hover"
                            style="font-size: 10px">
                            <thead class="thead-dark">
                                <tr>
                                    <th>NO</th>
                                    <th>KODE PENGURUS</th>
                                    <th>NAMA PENGURUS</th>
                                    <th>M1</th>
                                    <th>M2</th>
                                    <th>M3</th>
                                    <th>M4</th>
                                    <th>M5</th>
                                    <th>M6</th>
                                    <th>M7</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalSuratJalan = 0;
                                    $totalSuratJalan1 = 0;
                                    $totalSuratJalan2 = 0;
                                    $totalSuratJalan3 = 0;
                                    $totalSuratJalan4 = 0;
                                    $totalSuratJalan5 = 0;
                                    $totalSuratJalan6 = 0;
                                    $totalSuratJalan7 = 0;
                                @endphp
                                @foreach ($pengurus as $pengurus)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $pengurus->kode_karyawan ?? '-' }}</td>
                                        <td>{{ $pengurus->nama_lengkap ?? '-' }}</td>
                                        <td>{{ $pengurus->jumlah_surat_jalan_k1  ?? 0 }}</td>
                                        <td>{{ $pengurus->jumlah_surat_jalan_k2  ?? 0 }}</td>
                                        <td>{{ $pengurus->jumlah_surat_jalan_k3  ?? 0 }}</td>
                                        <td>{{ $pengurus->jumlah_surat_jalan_k4  ?? 0 }}</td>
                                        <td>{{ $pengurus->jumlah_surat_jalan_k5  ?? 0 }}</td>
                                        <td>{{ $pengurus->jumlah_surat_jalan_k6  ?? 0 }}</td>
                                        <td>{{ $pengurus->jumlah_surat_jalan_k7  ?? 0 }}</td>
                                        <td>{{ $pengurus->jumlah_surat_jalan_diterima ?? 0 }}</td>
                                    </tr>
                                    @php
                                        $totalSuratJalan += $pengurus->jumlah_surat_jalan_diterima ?? 0;
                                        $totalSuratJalan1 += $pengurus->jumlah_surat_jalan_k1 ?? 0;
                                        $totalSuratJalan2 += $pengurus->jumlah_surat_jalan_k2 ?? 0;
                                        $totalSuratJalan3 += $pengurus->jumlah_surat_jalan_k3 ?? 0;
                                        $totalSuratJalan4 += $pengurus->jumlah_surat_jalan_k4 ?? 0;
                                        $totalSuratJalan5 += $pengurus->jumlah_surat_jalan_k5 ?? 0;
                                        $totalSuratJalan6 += $pengurus->jumlah_surat_jalan_k6 ?? 0;
                                        $totalSuratJalan7 += $pengurus->jumlah_surat_jalan_k7 ?? 0;
                                    @endphp
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="font-weight-bold">
                                    <td colspan="3" class="text-center">TOTAL</td>
                                    <td>{{ $totalSuratJalan1 }}</td>
                                    <td>{{ $totalSuratJalan2 }}</td>
                                    <td>{{ $totalSuratJalan3 }}</td>
                                    <td>{{ $totalSuratJalan4 }}</td>
                                    <td>{{ $totalSuratJalan5 }}</td>
                                    <td>{{ $totalSuratJalan6 }}</td>
                                    <td>{{ $totalSuratJalan7 }}</td>
                                    <td>{{ $totalSuratJalan }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>


                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </section>
    <!-- /.card -->
    <script>
        var tanggalAwal = document.getElementById('tanggal_awal');
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
            form.action = "{{ url('admin/laporan-monitoringsjglobal') }}";
            form.submit();
        }

        function printReport() {
            var startDate = tanggalAwal.value;
            var endDate = tanggalAkhir.value;

            if (startDate && endDate) {
                form.action = "{{ url('admin/print-monitoringsjglobal') }}" + "?start_date=" + startDate + "&end_date=" +
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
                    case 'detail':
                        window.location.href = "{{ url('admin/laporan-monitoringsj') }}";
                        break;
                    case 'global':
                        window.location.href = "{{ url('admin/laporan-monitoringsjglobal') }}";
                        break;
                    default:
                        // Handle other cases or do nothing
                        break;
                }
            });
        });
    </script>
@endsection
