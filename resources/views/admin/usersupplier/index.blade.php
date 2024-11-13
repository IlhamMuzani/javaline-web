@extends('layouts.app')

@section('title', 'Data User Pelanggan')

@section('content')

    <div id="loadingSpinner" style="display: flex; align-items: center; justify-content: center; height: 100vh;">
        <i class="fas fa-spinner fa-spin" style="font-size: 3rem;"></i>
    </div>
    <!-- Content Header (Page header) -->
    <div class="content-header" style="display: none;" id="mainContent">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data User Pelanggan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Data User Pelanggan</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
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
                    <h3 class="card-title">Data User Pelanggan</h3>
                    <div class="float-right">
                        @if (auth()->check() && auth()->user()->fitur['user create'])
                            <a href="{{ url('admin/userpelanggan/create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Tambah
                            </a>
                        @endif
                    </div>
                </div>
                <div class="row align-items-center p-3 d-flex justify-content-between">
                    <!-- Form Kategori di sebelah kiri -->
                    <div class="col-md-3 mb-3">
                        <form method="GET" id="form-action">
                            <label for="status">Kategori</label>
                            <select class="custom-select form-control" id="status" name="status">
                                <option value="">- Pilih -</option>
                                <option value="staff">Staff</option>
                                <option value="driver">Driver</option>
                                <option value="pelanggan">Pelanggan</option>
                                <option value="supplier" selected>Supplier</option>
                            </select>
                        </form>
                    </div>

                    <!-- Form Cari User di sebelah kanan -->
                    <div class="col-md-4">
                        <form action="{{ url('admin/userpelanggan') }}" method="GET" id="get-keyword" autocomplete="off">
                            <label for="keyword">Cari User :</label>
                            <div class="input-group">
                                <input type="search" class="form-control" name="keyword" id="keyword"
                                    value="{{ Request::get('keyword') }}">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center">No</th>
                                <th>Kode Supplier</th>
                                <th>Nama</th>
                                <th>Telepon</th>
                                <th class="text-center" width="150">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <tbody>

                        </tbody>
                        </tbody>
                    </table>
                </div>
                @if ($pelanggans->total() > 10)
                    <div class="card-footer">
                        <div class="pagination float-right">
                            {{ $pelanggans->appends(Request::all())->links('pagination::simple-bootstrap-4') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(function() {
                document.getElementById("loadingSpinner").style.display = "none";
                document.getElementById("mainContent").style.display = "block";
                document.getElementById("mainContentSection").style.display = "block";
            }, 100); // Adjust the delay time as needed
        });
    </script>

    <script>
        $(document).ready(function() {
            // Detect the change event on the 'status' dropdown
            $('#status').on('change', function() {
                // Get the selected value
                var selectedValue = $(this).val();

                // Check the selected value and redirect accordingly
                switch (selectedValue) {
                    case 'staff':
                        window.location.href = "{{ url('admin/user') }}";
                        break;
                    case 'driver':
                        window.location.href = "{{ url('admin/userdriver') }}";
                        break;
                    case 'pelanggan':
                        window.location.href = "{{ url('admin/userpelanggan') }}";
                        break;
                    case 'supplier':
                        window.location.href = "{{ url('admin/usersupplier') }}";
                        break;
                    default:
                        // Handle other cases or do nothing
                        break;
                }
            });
        });
    </script>
    <!-- /.card -->
@endsection
