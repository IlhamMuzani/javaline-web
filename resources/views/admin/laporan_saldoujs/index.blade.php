@extends('layouts.app')

@section('title', 'Saldo Adm UJS')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Saldo Adm UJS</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Saldo Adm UJS</li>
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
                    <h3 class="card-title">Data Saldo Adm UJS</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2 mb-3">
                            <select class="custom-select form-control" id="statusx" name="statusx">
                                <option value="">- Pilih -</option>
                                <option value="memo_perjalanan">Pemasukan UJS</option>
                                <option value="memo_borong">Pengambilan UJS</option>
                                <option value="akun" selected>Saldo UJS</option>
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
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Sisa Saldo Adm UJS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td> Rp. {{ number_format($inquery->sisa_ujs, 0, ',', '.') }}</td>
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
            form.action = "{{ url('admin/print_saldoujs') }}";
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
                        window.location.href = "{{ url('admin/listadministrasi') }}";
                        break;
                    case 'memo_borong':
                        window.location.href = "{{ url('admin/pengambilanujs') }}";
                        break;
                    case 'akun':
                        window.location.href = "{{ url('admin/saldo_ujs') }}";
                        break;
                    default:
                        // Handle other cases or do nothing
                        break;
                }
            });
        });
    </script>
@endsection
