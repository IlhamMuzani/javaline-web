@extends('layouts.app')

@section('title', 'Laporan Saldo Kas')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
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
                    <h3 class="card-title">Data Laporan Saldo Kas</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="GET" id="form-action">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <select class="custom-select form-control" id="statusx" name="statusx">
                                    <option value="">- Pilih Laporan -</option>
                                    <option value="memo_perjalanan">Laporan Kas Masuk</option>
                                    <option value="memo_borong">Laporan Kas Keluar</option>
                                    <option value="akun">Laporan Kas Keluar Group by Akun</option>
                                    <option value="memo_tambahan" selected>Saldo Kas</option>
                                </select>
                                <label for="created_at">(Kategori)</label>
                            </div>
                            <div class="col-md-3 mb-3">
                                <input class="form-control" id="created_at" name="created_at" type="date"
                                    value="{{ Request::get('created_at') }}" max="{{ date('Y-m-d') }}" />
                                <label for="created_at">(Tanggal)</label>
                            </div>
                            {{-- <div class="col-md-3 mb-3">
                                <input class="form-control" id="tanggal_akhir" name="tanggal_akhir" type="date"
                                    value="{{ Request::get('tanggal_akhir') }}" max="{{ date('Y-m-d') }}" />
                                <label for="created_at">(Tanggal Akhir)</label>
                            </div> --}}
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
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Sisa Saldo Kas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td> Rp. {{ $saldos ? number_format($saldos->sisa_saldo, 0, ',', '.') : '0' }}</td>
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
                    case 'memo_perjalanan':
                        window.location.href = "{{ url('admin/laporan_penerimaankaskecil') }}";
                        break;
                    case 'memo_borong':
                        window.location.href = "{{ url('admin/laporan_pengeluarankaskecil') }}";
                        break;
                    case 'akun':
                        window.location.href = "{{ url('admin/laporan_pengeluarankaskecilakun') }}";
                        break;
                    case 'memo_tambahan':
                        window.location.href = "{{ url('admin/laporan_saldokas') }}";
                        break;
                    default:
                        // Handle other cases or do nothing
                        break;
                }
            });
        });
    </script>

    <script>
        var tanggalAwal = document.getElementById('created_at');
        var form = document.getElementById('form-action');

        function cari() {
            form.action = "{{ url('admin/laporan_saldokas') }}";
            form.submit();
        }
    </script>
@endsection
