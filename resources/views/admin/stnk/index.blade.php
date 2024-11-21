@extends('layouts.app')

@section('title', 'Data No. Stnk')

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
                    <h1 class="m-0">Data No. Stnk</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Data No. Stnk</li>
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
                    <h3 class="card-title">Data No. Stnk</h3>
                    <div class="float-right">
                        @if (auth()->check() && auth()->user()->fitur['stnk create'])
                            <a href="{{ url('admin/stnk/create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Tambah
                            </a>
                        @endif
                    </div>
                </div>
                <form action="{{ url('admin/stnk') }}" method="GET" id="get-keyword" autocomplete="off">
                    @csrf
                    <div class="row p-3">
                        <div class="col-0 col-md-8"></div>
                        <div class="col-md-4">
                            <label for="keyword">Cari No Stnk :</label>
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
                                    <th>No Registrasi</th>
                                    <th>Nama Pemilik</th>
                                    <th>Tanggal Expired</th>
                                    <th class="text-center">Qr Code</th>
                                    <th class="text-center" width="135">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stnks as $stnk)
                                    <tr class="{{ $loop->iteration % 2 == 0 ? 'bg-light' : '' }}">
                                        <td class="text-center">
                                            {{ ($stnks->currentPage() - 1) * $stnks->perPage() + $loop->iteration }}</td>
                                        <td>{{ $stnk->kode_stnk }}</td>
                                        <td>
                                            @if ($stnk->kendaraan)
                                                {{ $stnk->kendaraan->no_pol }}
                                            @else
                                                No pol tidak ada
                                            @endif
                                        </td>
                                        <td>{{ $stnk->nama_pemilik }}</td>
                                        <td>{{ $stnk->expired_stnk }}</td>
                                        <td data-toggle="modal" data-target="#modal-qrcode-{{ $stnk->id }}"
                                            style="text-align: center;">
                                            <div style="display: inline-block;">
                                                {!! DNS2D::getBarcodeHTML("$stnk->qrcode_stnk", 'QRCODE', 2, 2) !!}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @if (auth()->check() && auth()->user()->fitur['stnk show'])
                                                <a href="{{ url('admin/stnk/' . $stnk->id) }}" class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            @endif
                                            @if (auth()->check() && auth()->user()->fitur['stnk update'])
                                                <a href="{{ url('admin/stnk/' . $stnk->id . '/edit') }}"
                                                    class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endif
                                            @if (auth()->check() && auth()->user()->fitur['stnk delete'])
                                                <button type="submit" class="btn btn-danger btn-sm" data-toggle="modal"
                                                    data-target="#modal-hapus-{{ $stnk->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="modal-hapus-{{ $stnk->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Hapus No. Stnk</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Yakin hapus No. Stnk <strong>{{ $stnk->nama_pemilik }}</strong>?</p>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">Batal</button>
                                                    <form action="{{ url('admin/stnk/' . $stnk->id) }}" method="POST">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="modal-qrcode-{{ $stnk->id }}">
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
                                                            {{ $stnk->kode_stnk }}</p>
                                                        <div style="display: inline-block;">
                                                            {!! DNS2D::getBarcodeHTML("$stnk->qrcode_stnk", 'QRCODE', 15, 15) !!}
                                                        </div>
                                                        <p style="font-size:20px; font-weight: bold;">
                                                            {{ $stnk->expired_stnk }}</p>
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-default"
                                                            data-dismiss="modal">Batal</button>
                                                        <a href="{{ url('admin/stnk/cetak-pdf/' . $stnk->id) }}"
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
                    {{ $stnks->links('pagination::bootstrap-4') }}
                </div>

            </div>
        </div>
    </section>
    <!-- /.card -->
@endsection
