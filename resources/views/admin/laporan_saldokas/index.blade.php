@extends('layouts.app')

@section('title', 'Laporan Saldo Kas')

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
                    <h1 class="m-0">Laporan Saldo Kas</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Laporan Saldo Kas</li>
                    </ol>
                </div><!-- /.col -->
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
                    <h3 class="card-title">Data Laporan Saldo Kas</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="GET" id="form-action">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <select class="custom-select form-control" id="statusx" name="statusx">
                                    <option value="">- Pilih Laporan -</option>
                                    <option value="laporan_masuk">Laporan Kas Masuk</option>
                                    <option value="laporan_keluar">Laporan Kas Keluar</option>
                                    <option value="akun">Laporan Kas Keluar Group by Akun</option>
                                    <option value="saldo_kas" selected>Saldo Kas</option>
                                </select>
                                <label for="">(Kategori)</label>
                            </div>
                            <div hidden class="col-md-3 mb-3">
                                <input class="form-control" id="tanggal_awal" name="tanggal_awal" type="date"
                                    value="{{ Request::get('tanggal_awal', '2024-05-01') }}" max="{{ date('Y-m-d') }}" />
                                <label for="tanggal_awal">Tanggal Awal</label>
                            </div>

                            <div class="col-md-3 mb-3">
                                <input class="form-control" id="tanggal_akhir" name="tanggal_akhir" type="date"
                                    value="{{ Request::get('tanggal_akhir') }}" max="{{ date('Y-m-d') }}" />
                                <label for="tanggal_akhir">(Tanggal)</label>
                            </div>
                            <div class="col-md-3 mb-3">
                                <button type="button" class="btn btn-outline-primary btn-block" onclick="cari()">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                                <form method="GET" id="form-action">
                                    <button type="button" class="btn btn-primary btn-block" onclick="printCetak(this.form)"
                                        target="_blank">
                                        <i class="fas fa-print"></i> Cetak
                                    </button>
                                </form>
                            </div>
                        </div>
                    </form>
                    {{-- <table class="table table-bordered table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Sisa Saldo Kas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td> Rp. {{ $hasil ? number_format($hasil, 0, ',', '.') : '0' }}</td>
                            </tr>
                        </tbody>
                    </table> --}}
                    <table id="datatables66" class="table table-bordered table-striped table-hover" style="font-size: 13px">
                        <thead class="thead-dark">
                            <tr>
                                {{-- <th>Saldo Kemarin</th>
                                <th>Saldo Masuk</th>
                                <th>Saldo Keluar</th> --}}
                                <th>Sisa Saldo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                {{-- <td> Rp. {{ $sisa_saldo_awal ? number_format($sisa_saldo_awal, 0, ',', '.') : '0' }}</td>
                                <td> Rp. {{ $Penerimaan ? number_format($Penerimaan, 0, ',', '.') : '0' }}</td>
                                <td> Rp. {{ $Pengeluaran ? number_format($Pengeluaran, 0, ',', '.') : '0' }}</td> --}}
                                <td> Rp. {{ $hasil ? number_format($hasil, 0, ',', '.') : '0' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        </div>
    </section>
    <!-- /.card -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tanggalAkhirInput = document.getElementById('tanggal_akhir');
            const tanggalAwalInput = document.getElementById('tanggal_awal');
        });

        var form = document.getElementById('form-action');

        function cari() {
            form.action = "{{ url('admin/laporan_saldokas') }}";
            form.submit();
        }
    </script>

    <script>
        function printCetak(form) {
            form.action = "{{ url('admin/print_saldokas') }}";
            form.submit();
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
                    case 'laporan_masuk':
                        window.location.href = "{{ url('admin/laporan_penerimaankaskecil') }}";
                        break;
                    case 'laporan_keluar':
                        window.location.href = "{{ url('admin/laporan_pengeluarankaskecil') }}";
                        break;
                    case 'akun':
                        window.location.href = "{{ url('admin/laporan_pengeluarankaskecilakun') }}";
                        break;
                    case 'saldo_kas':
                        window.location.href = "{{ url('admin/laporan_saldokas') }}";
                        break;
                    default:
                        // Handle other cases or do nothing
                        break;
                }
            });
        });
    </script>
@endsection
