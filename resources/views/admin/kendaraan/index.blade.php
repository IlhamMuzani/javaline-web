@extends('layouts.app')

@section('title', 'Data Kendaraan')

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
                    <h1 class="m-0">Data Kendaraan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Data Kendaraan</li>
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
                    <h3 class="card-title">Data Kendaraan</h3>
                    <div class="float-right">
                        @if (auth()->check() && auth()->user()->fitur['kendaraan create'])
                            <a href="{{ url('admin/kendaraan/create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Tambah
                            </a>
                        @endif
                    </div>
                </div>
                <form action="{{ url('admin/kendaraan') }}" method="GET" id="get-keyword" autocomplete="off">
                    @csrf
                    <div class="row p-3">
                        <div class="col-0 col-md-8"></div>
                        <div class="col-md-4">
                            <label for="keyword">Cari Kendaraan :</label>
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
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive" style="overflow-x: auto;">
                        <table class="table table-bordered table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Kode</th>
                                    <th>No. Kabin</th>
                                    <th>No. Registrasi</th>
                                    <th>Jenis Kendaraan</th>
                                    {{-- <th>Driver</th> --}}
                                    <th>Foto Stnk</th>
                                    <th>Barcode Solar</th>
                                    <th class="text-center">Qr Code</th>
                                    <th class="text-center" width="150">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kendaraans as $kendaraan)
                                    <tr class="{{ $loop->iteration % 2 == 0 ? 'bg-light' : '' }}">
                                        <td class="text-center">
                                            {{ ($kendaraans->currentPage() - 1) * $kendaraans->perPage() + $loop->iteration }}
                                        </td>
                                        <td>{{ $kendaraan->kode_kendaraan }}</td>
                                        <td>{{ $kendaraan->no_kabin }}</td>
                                        <td>{{ $kendaraan->no_pol }}</td>
                                        <td>
                                            @if ($kendaraan->jenis_kendaraan)
                                                {{ $kendaraan->jenis_kendaraan->nama_jenis_kendaraan }}
                                            @else
                                                data tidak ada
                                            @endif
                                        </td>
                                        {{-- <td>
                                        @if ($kendaraan->user)
                                            {{ $kendaraan->user->karyawan->nama_lengkap }}
                                        @else
                                            data tidak ada
                                        @endif
                                    </td> --}}
                                        <td data-toggle="modal" data-target="#modal-stnk-{{ $kendaraan->id }}"
                                            class="text-center">
                                            @if ($kendaraan->gambar_stnk)
                                                <img src="{{ asset('storage/uploads/' . $kendaraan->gambar_stnk) }}"
                                                    alt="{{ $kendaraan->kode_kendaraan }}" width="50" height="50">
                                            @else
                                                <img src="{{ asset('adminlte/dist/img/img-placeholder.jpg') }}"
                                                    alt="{{ $kendaraan->kode_kendaraan }}" width="50" height="50">
                                            @endif
                                        </td>
                                        <td data-toggle="modal" data-target="#modal-solar-{{ $kendaraan->id }}"
                                            class="text-center">
                                            @if ($kendaraan->gambar_barcodesolar)
                                                <img src="{{ asset('storage/uploads/' . $kendaraan->gambar_barcodesolar) }}"
                                                    alt="{{ $kendaraan->kode_kendaraan }}" width="50" height="50">
                                            @else
                                                <img src="{{ asset('adminlte/dist/img/img-placeholder.jpg') }}"
                                                    alt="{{ $kendaraan->kode_kendaraan }}" width="50" height="50">
                                            @endif
                                        </td>
                                        <td data-toggle="modal" data-target="#modal-qrcode-{{ $kendaraan->id }}"
                                            style="text-align: center;">
                                            <div style="display: inline-block;">
                                                {!! DNS2D::getBarcodeHTML("$kendaraan->qrcode_kendaraan", 'QRCODE', 2, 2) !!}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @if (auth()->check() && auth()->user()->fitur['kendaraan show'])
                                                <a href="{{ url('admin/kendaraan/' . $kendaraan->id) }}"
                                                    class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            @endif
                                            @if (auth()->check() && auth()->user()->fitur['kendaraan update'])
                                                <a href="{{ url('admin/kendaraan/' . $kendaraan->id . '/edit') }}"
                                                    class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endif
                                            @if (auth()->check() && auth()->user()->fitur['kendaraan delete'])
                                                <button type="submit" class="btn btn-danger btn-sm" data-toggle="modal"
                                                    data-target="#modal-hapus-{{ $kendaraan->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="modal-hapus-{{ $kendaraan->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Hapus Kendaraan</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Yakin hapus kendaraan no kabin
                                                        <strong>{{ $kendaraan->no_kabin }}</strong>?
                                                    </p>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">Batal</button>
                                                    <form action="{{ url('admin/kendaraan/' . $kendaraan->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="modal-qrcode-{{ $kendaraan->id }}">
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
                                                            {{ $kendaraan->kode_kendaraan }}</p>
                                                        <div style="display: inline-block;">
                                                            {!! DNS2D::getBarcodeHTML("$kendaraan->qrcode_kendaraan", 'QRCODE', 15, 15) !!}
                                                        </div>
                                                        <p style="font-size:20px; font-weight: bold;">
                                                            {{ $kendaraan->no_kabin }} / {{ $kendaraan->no_pol }}</p>
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-default"
                                                            data-dismiss="modal">Batal</button>
                                                        <a href="{{ url('admin/kendaraan/cetak-pdf/' . $kendaraan->id) }}"
                                                            class="btn btn-primary btn-sm">
                                                            <i class=""></i> Cetak
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="modal-solar-{{ $kendaraan->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Gambar QR Code Solar</h4>
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
                                                        <p style="font-size:15px; font-weight: bold;">
                                                            {{ $kendaraan->kode_kendaraan }}</p>
                                                        <div style="display: inline-block;">
                                                            @if ($kendaraan->gambar_barcodesolar)
                                                                <img src="{{ asset('storage/uploads/' . $kendaraan->gambar_barcodesolar) }}"
                                                                    alt="{{ $kendaraan->kode_kendaraan }}" width="400"
                                                                    height="220">
                                                            @else
                                                                <img src="{{ asset('adminlte/dist/img/img-placeholder.jpg') }}"
                                                                    alt="{{ $kendaraan->kode_kendaraan }}" width="200"
                                                                    height="200">
                                                            @endif
                                                        </div>
                                                        <p style="font-size:15px; font-weight: bold;">
                                                            {{ $kendaraan->no_kabin }} / {{ $kendaraan->no_pol }}</p>
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-default"
                                                            data-dismiss="modal">Batal</button>
                                                        <a href="{{ url('admin/kendaraan/cetak-pdfsolar/' . $kendaraan->id) }}"
                                                            class="btn btn-primary btn-sm">
                                                            <i class=""></i> Cetak
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="modal-stnk-{{ $kendaraan->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Foto Stnk</h4>
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
                                                        <p style="font-size:15px; font-weight: bold;">
                                                            {{ $kendaraan->kode_kendaraan }}</p>
                                                        <div style="display: inline-block;">
                                                            @if ($kendaraan->gambar_stnk)
                                                                <style>
                                                                    .portrait-img {
                                                                        width: auto;
                                                                        height: 450px;
                                                                        /* Adjust this value to your desired height */
                                                                        display: block;
                                                                        margin: 0 auto;
                                                                        object-fit: cover;
                                                                    }
                                                                </style>
                                                                <img src="{{ asset('storage/uploads/' . $kendaraan->gambar_stnk) }}"
                                                                    alt="{{ $kendaraan->kode_kendaraan }}"class="portrait-img">
                                                            @else
                                                                <img src="{{ asset('adminlte/dist/img/img-placeholder.jpg') }}"
                                                                    alt="{{ $kendaraan->kode_kendaraan }}" width="200"
                                                                    height="200">
                                                            @endif
                                                        </div>
                                                        <p style="font-size:15px; font-weight: bold;">
                                                            {{ $kendaraan->no_kabin }} / {{ $kendaraan->no_pol }}</p>
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-default"
                                                            data-dismiss="modal">Batal</button>
                                                        <a href="{{ url('admin/kendaraan/cetak-pdfstnk/' . $kendaraan->id) }}"
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
                    {{ $kendaraans->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </section>
    <!-- /.card -->
@endsection
