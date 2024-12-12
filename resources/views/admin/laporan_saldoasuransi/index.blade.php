@extends('layouts.app')

@section('title', 'Saldo Asuransi Barang')

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
                    <h1 class="m-0">Saldo Asuransi Barang</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Saldo Asuransi Barang</li>
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
                    <h3 class="card-title">Data Saldo Asuransi Barang</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2 mb-3">
                            <select class="custom-select form-control" id="statusx" name="statusx">
                                <option value="">- Pilih -</option>
                                <option value="pengambilan_asuransi">Pengambilan Asuransi</option>
                                <option value="saldo" selected>Saldo Asuransi</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <form method="GET" id="form-action">
                                <button type="button" class="btn btn-primary btn-block" onclick="printCetak(this.form)"
                                    target="_blank">
                                    <i class="fas fa-print"></i> Cetak
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive" style="overflow-x: auto;">
                        <table class="table table-bordered table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Sisa Saldo Asuransi Barang</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td> Rp. {{ number_format($inquery->sisa_asuransi, 0, ',', '.') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        </div>
    </section>
    <!-- /.card -->
    <script>
        function printCetak(form) {
            form.action = "{{ url('admin/print_saldoasuransi') }}";
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
                    case 'pengambilan_asuransi':
                        window.location.href = "{{ url('admin/pengambilanasuransi') }}";
                        break;
                    case 'saldo':
                        window.location.href = "{{ url('admin/saldo_asuransi') }}";
                        break;
                    default:
                        // Handle other cases or do nothing
                        break;
                }
            });
        });
    </script>
@endsection
