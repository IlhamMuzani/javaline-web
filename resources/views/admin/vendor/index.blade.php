@extends('layouts.app')

@section('title', 'Data Rekanan')

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
                    <h1 class="m-0">Data Rekanan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Data Rekanan</li>
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
                        <i class="icon fas fa-check"></i> Success!
                    </h5>
                    {{ session('success') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Rekanan</h3>
                    <div class="float-right">
                        {{-- @if (auth()->check() && auth()->user()->fitur['vendor create']) --}}
                            <a href="{{ url('admin/vendor/create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Tambah
                            </a>
                        {{-- @endif --}}
                    </div>
                </div>
                <form action="{{ url('admin/vendor') }}" method="GET" id="get-keyword" autocomplete="off">
                    @csrf
                    <div class="row p-3">
                        <div class="col-0 col-md-8"></div>
                        <div class="col-md-4">
                            <label for="keyword">Cari Rekanan :</label>
                            <div class="input-group">
                                <input type="search" class="form-control" name="keyword" id="keyword"
                                    value="{{ Request::get('keyword') }}"
                                    onsubmit="event.preventDefault();
                                        document.getElementById('get-keyword').submit();">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="card-body">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center">No</th>
                                <th>Kode</th>
                                <th>Nama Rekanan</th>
                                {{-- <th>Nama Alias</th> --}}
                                <th>Nama</th>
                                <th>Telepon</th>
                                <th class="text-center">Qr Code</th>
                                <th class="text-center" width="130">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($vendors as $vendor)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $vendor->kode_vendor }}</td>
                                    <td>{{ $vendor->nama_vendor }}</td>
                                    {{-- <td>{{ $vendor->nama_alias }}</td> --}}
                                    <td>{{ $vendor->nama_person }}</td>
                                    <td>{{ $vendor->telp }}</td>
                                    <td data-toggle="modal" data-target="#modal-qrcode-{{ $vendor->id }}"
                                        style="text-align: center;">
                                        <div style="display: inline-block;">
                                            {!! DNS2D::getBarcodeHTML("$vendor->qrcode_vendor", 'QRCODE', 2, 2) !!}
                                        </div>
                                        {{-- <br>
                                        AB - {{ $user->qrcode_user }} --}}
                                    </td>
                                    <td class="text-center">
                                        {{-- @if (auth()->check() && auth()->user()->fitur['vendor show']) --}}
                                            <a href="{{ url('admin/vendor/' . $vendor->id) }}"
                                                class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        {{-- @endif
                                        @if (auth()->check() && auth()->user()->fitur['vendor update']) --}}
                                            <a href="{{ url('admin/vendor/' . $vendor->id . '/edit') }}"
                                                class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        {{-- @endif
                                        @if (auth()->check() && auth()->user()->fitur['vendor delete']) --}}
                                            <button type="submit" class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#modal-hapus-{{ $vendor->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        {{-- @endif --}}
                                    </td>
                                </tr>
                                <div class="modal fade" id="modal-hapus-{{ $vendor->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Hapus Rekanan</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Yakin hapus vendor <strong>{{ $vendor->nama_vendor }}</strong>?</p>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Batal</button>
                                                <form action="{{ url('admin/vendor/' . $vendor->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="modal-qrcode-{{ $vendor->id }}">
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
                                                {{-- <p>Yakin hapus kendaraan
                                                    <strong>{{ $kendaraan->kode_kendaraan }}</strong>?
                                                </p> --}}
                                                <div style="text-align: center;">
                                                    <p style="font-size:20px; font-weight: bold;">
                                                        {{ $vendor->kode_vendor }}</p>
                                                    <div style="display: inline-block;">
                                                        {!! DNS2D::getBarcodeHTML("$vendor->qrcode_vendor", 'QRCODE', 15, 15) !!}
                                                    </div>
                                                    <p style="font-size:20px; font-weight: bold;">
                                                        {{ $vendor->nama_vendor }}</p>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">Batal</button>
                                                    <a href="{{ url('admin/vendor/cetak-pdf/' . $vendor->id) }}"
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
                @if ($vendors->total() > 10)
                    <div class="card-footer">
                        <div class="pagination float-right">
                            {{ $vendors->appends(Request::all())->links('pagination::simple-bootstrap-4') }}
                        </div>
                    </div>
                @endif
                <!-- /.card-body -->
            </div>
        </div>
    </section>
    <!-- /.card -->
@endsection
