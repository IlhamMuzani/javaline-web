@extends('layouts.app')

@section('title', 'Data Merek Aki')

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
                    <h1 class="m-0">Data Merek Aki</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Data Merek Aki</li>
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
                    <h3 class="card-title">Data Merek Aki</h3>
                    <div class="float-right">
                        @if (auth()->check() && auth()->user()->fitur['merek create'])
                            <a href="{{ url('admin/merek-aki/create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Tambah
                            </a>
                        @endif
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive" style="overflow-x: auto;">
                        <table id="datatables66" class="table table-bordered table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Kode Merek ban</th>
                                    <th>Nama Merek</th>
                                    <th class="text-center">Qr Code</th>
                                    <th class="text-center" width="90">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($merek_akis as $merek_aki)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $merek_aki->kode_merek }}</td>
                                        <td>{{ $merek_aki->nama_merek }}</td>
                                        <td data-toggle="modal" data-target="#modal-qrcode-{{ $merek_aki->id }}"
                                            style="text-align: center;">
                                            <div style="display: inline-block;">
                                                {!! DNS2D::getBarcodeHTML("$merek_aki->qrcode_merek", 'QRCODE', 2, 2) !!}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @if (auth()->check() && auth()->user()->fitur['merek update'])
                                                <a href="{{ url('admin/merek-aki/' . $merek_aki->id . '/edit') }}"
                                                    class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endif
                                            @if (auth()->check() && auth()->user()->fitur['merek delete'])
                                                <button type="submit" class="btn btn-danger btn-sm" data-toggle="modal"
                                                    data-target="#modal-hapus-{{ $merek_aki->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="modal-hapus-{{ $merek_aki->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Hapus Merek Aki</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Yakin hapus merek ban <strong>{{ $merek_aki->nama_merek }}</strong>?
                                                    </p>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">Batal</button>
                                                    <form action="{{ url('admin/merek-aki/' . $merek_aki->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="modal-qrcode-{{ $merek_aki->id }}">
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
                                                        <p style="font-size:20px; font-weight: bold;">
                                                            {{ $merek_aki->kode_merek }}</p>
                                                        <div style="display: inline-block;">
                                                            {!! DNS2D::getBarcodeHTML("$merek_aki->qrcode_merek", 'QRCODE', 15, 15) !!}
                                                        </div>
                                                        <p style="font-size:20px; font-weight: bold;">
                                                            {{ $merek_aki->nama_merek }}</p>
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-default"
                                                            data-dismiss="modal">Batal</button>
                                                        <a href="{{ url('admin/merek-aki/cetak-pdf/' . $merek_aki->id) }}"
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
                <!-- /.card-body -->
            </div>
        </div>
    </section>
    <!-- /.card -->
@endsection
