@extends('layouts.app')

@section('title', 'Data No. Kir')

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
                    <h1 class="m-0">Data No. Kir</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Data No. Kir</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <style>
        .qrcode-container {
            position: relative;
            display: inline-block;
        }

        .qrcode-logo {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 20%;
            /* Atur ukuran logo sesuai kebutuhan */
            height: auto;
            /* Jaga proporsi gambar */
        }
    </style>
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
                    <h3 class="card-title">Data No. Kir</h3>
                    <div class="float-right">
                        @if (auth()->check() && auth()->user()->fitur['nokir create'])
                            <a href="{{ url('admin/nokir/create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Tambah
                            </a>
                        @endif
                    </div>
                </div>
                <form action="{{ url('admin/nokir') }}" method="GET" id="get-keyword" autocomplete="off">
                    @csrf
                    <div class="row p-3">
                        <div class="col-0 col-md-8"></div>
                        <div class="col-md-4">
                            <label for="keyword">Cari No Kir :</label>
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
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center">No</th>
                                <th>Kode</th>
                                <th>No Kabin</th>
                                <th>No Pol</th>
                                <th>Nama Pemilik</th>
                                <th>Tanggal Expired</th>
                                <th class="text-center">Qr Code</th>
                                <th class="text-center" width="170">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($nokirs as $nokir)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $nokir->kode_kir }}</td>
                                    <td>
                                        @if ($nokir->kendaraan)
                                            {{ $nokir->kendaraan->no_kabin }}
                                        @else
                                            kabin tidak ada
                                        @endif
                                    </td>
                                    <td>
                                        @if ($nokir->kendaraan)
                                            {{ $nokir->kendaraan->no_pol }}
                                        @else
                                            kabin tidak ada
                                        @endif
                                    </td>
                                    <td>{{ $nokir->nama_pemilik }}</td>
                                    <td>{{ $nokir->masa_berlaku }}</td>

                                    {{-- <td>{{ \Carbon\Carbon::parse($nokir->masa_berlaku)->format('d M Y') }}</td> --}}

                                    <td data-toggle="modal" data-target="#modal-qrcode-{{ $nokir->id }}"
                                        style="text-align: center;">
                                        <div class="qrcode-container" style="position: relative; display: inline-block;">
                                            {!! DNS2D::getBarcodeHTML("$nokir->qrcode_kir", 'QRCODE', 2, 2) !!}
                                            <img src="{{ asset('storage/uploads/gambar_logo/dinas_perhubungan.jpg') }}"
                                                class="qrcode-logo" alt="Logo">
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        @if (auth()->check() && auth()->user()->fitur['nokir print'])
                                            <a href="{{ url('admin/nokir/cetak-pdfnokir/' . $nokir->id) }}"
                                                class="btn btn-primary btn-sm">
                                                <i class="fas fa-print"></i>
                                        @endif
                                        </a>
                                        @if (auth()->check() && auth()->user()->fitur['nokir show'])
                                            <a href="{{ url('admin/nokir/' . $nokir->id) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        @endif
                                        @if (auth()->check() && auth()->user()->fitur['nokir update'])
                                            <a href="{{ url('admin/nokir/' . $nokir->id . '/edit') }}"
                                                class="btn btn-warning btn-sm">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                        @endif
                                        @if (auth()->check() && auth()->user()->fitur['nokir delete'])
                                            <button type="submit" class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#modal-hapus-{{ $nokir->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                                <div class="modal fade" id="modal-hapus-{{ $nokir->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Hapus No. Kir</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Yakin hapus No. Kir <strong>{{ $nokir->nama_pemilik }}</strong>?</p>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Batal</button>
                                                <form action="{{ url('admin/nokir/' . $nokir->id) }}" method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="modal-qrcode-{{ $nokir->id }}">
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
                                                        {{ $nokir->kode_kir }}</p>
                                                    <div class="qrcode-container"
                                                        style="position: relative; display: inline-block;">
                                                        {!! DNS2D::getBarcodeHTML("$nokir->qrcode_kir", 'QRCODE', 15, 15) !!}
                                                        <img src="{{ asset('storage/uploads/gambar_logo/dinas_perhubungan.jpg') }}"
                                                            class="qrcode-logo" alt="Logo">
                                                    </div>
                                                    <p style="font-size:20px; font-weight: bold;">
                                                        {{ $nokir->masa_berlaku }}</p>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">Batal</button>
                                                    <a href="{{ url('admin/nokir/cetak-pdf/' . $nokir->id) }}"
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
                @if ($nokirs->total() > 10)
                    <div class="card-footer">
                        <div class="pagination float-right">
                            {{ $nokirs->appends(Request::all())->links('pagination::simple-bootstrap-4') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
    <!-- /.card -->
@endsection
