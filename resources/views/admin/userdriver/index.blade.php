@extends('layouts.app')

@section('title', 'Data User Driver')

@section('content')

    <div id="loadingSpinner" style="display: flex; align-items: center; justify-content: center; height: 100vh;">
        <i class="fas fa-spinner fa-spin" style="font-size: 3rem;"></i>
    </div>
    <!-- Content Header (Page header) -->
    <div class="content-header" style="display: none;" id="mainContent">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data User Driver</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Data User Driver</li>
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
                    <h3 class="card-title">Data User Driver</h3>
                    <div class="float-right">
                        @if (auth()->check() && auth()->user()->fitur['user create'])
                            <a href="{{ url('admin/userdriver/create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Tambah
                            </a>
                        @endif
                    </div>
                </div>
                @csrf
                <div class="row align-items-center p-3 d-flex justify-content-between">
                    <!-- Form Kategori di sebelah kiri -->
                    <div class="col-md-3 mb-3">
                        <form method="GET" id="form-action">
                            <label for="status">Kategori</label>
                            <select class="custom-select form-control" id="status" name="status">
                                <option value="">- Pilih -</option>
                                <option value="staff">Staff</option>
                                <option value="driver"selected>Driver</option>
                                <option value="pelanggan">Pelanggan</option>
                                <option value="supplier">Supplier</option>
                            </select>
                        </form>
                    </div>

                    <!-- Form Cari User di sebelah kanan -->
                    <div class="col-md-4">
                        <form action="{{ url('admin/userdriver') }}" method="GET" id="get-keyword" autocomplete="off">
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
                    <div class="table-responsive" style="overflow-x: auto;">
                        <table class="table table-bordered table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Kode User</th>
                                    <th>Nama</th>
                                    <th>Telepon</th>
                                    <th>Departemen</th>
                                    {{-- <th class="text-center">Qr Code</th> --}}
                                    <th class="text-center" width="20">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr class="{{ $loop->iteration % 2 == 0 ? 'bg-light' : '' }}">
                                        <td class="text-center">
                                            {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                                        </td>
                                        <td>{{ $user->kode_user }}</td>
                                        <td>{{ $user->karyawan->nama_lengkap }}</td>
                                        <td>{{ $user->karyawan->telp }}</td>
                                        <td>{{ $user->karyawan->departemen->nama }}</td>
                                        {{-- <td data-toggle="modal" data-target="#modal-qrcode-{{ $user->id }}"
                                        style="text-align: center;">
                                        <div style="display: inline-block;">
                                            {!! DNS2D::getBarcodeHTML("$user->qrcode_user", 'QRCODE', 2, 2) !!}
                                        </div>
                                    </td> --}}
                                        <td class="text-center">
                                            @if (auth()->check() && auth()->user()->fitur['user delete'])
                                                <button type="submit" class="btn btn-danger btn-sm" data-toggle="modal"
                                                    data-target="#modal-hapus-{{ $user->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="modal-hapus-{{ $user->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Hapus User</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Yakin hapus user
                                                        <strong>{{ $user->karyawan->nama_lengkap }}</strong>?
                                                    </p>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">Batal</button>
                                                    <form action="{{ url('admin/user/' . $user->id) }}" method="POST">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="modal-qrcode-{{ $user->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Gambar QR Code</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div style="text-align: center;">
                                                        <div style="display: inline-block;">
                                                            {!! DNS2D::getBarcodeHTML("$user->qrcode_user", 'QRCODE', 15, 15) !!}
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-default"
                                                            data-dismiss="modal">Batal</button>
                                                        <a href="{{ url('admin/user/cetak-pdf/' . $user->id) }}"
                                                            class="btn btn-primary btn-sm">
                                                            <i class=""></i> Cetak
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    {{ $users->links('pagination::bootstrap-4') }}
                </div>
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
