@extends('layouts.app')

@section('title', 'Data Karyawan')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Data Karyawan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Data Karyawan</li>
                </ol>
            </div>
        </div>
    </div>
</div>
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
                <h3 class="card-title">Data Karyawan</h3>
                <div class="float-right">
                    @if (auth()->check() && auth()->user()->fitur['karyawan create'])
                    <a href="{{ url('admin/karyawan/create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah
                    </a>
                    @endif
                </div>
            </div>
            <form action="{{ url('admin/karyawan') }}" method="GET" id="get-keyword" autocomplete="off">
                @csrf
                <div class="row p-3">
                    <div class="col-0 col-md-8"></div>
                    <div class="col-md-4">
                        <label for="keyword">Cari Karyawan :</label>
                        <div class="input-group">
                            <input type="search" class="form-control" name="keyword" id="keyword"
                                value="{{ Request::get('keyword') }}" onsubmit="event.preventDefault();
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
                            <th>Kode Karyawan</th>
                            <th>Nama</th>
                            <th>Telepon</th>
                            <th>Departemen</th>
                            <th class="text-center">Qr Code</th>
                            <th class="text-center" width="150">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($karyawans as $karyawan)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $karyawan->kode_karyawan }}</td>
                            <td>{{ $karyawan->nama_lengkap }}</td>
                            <td>{{ $karyawan->telp }}</td>
                            <td>{{ $karyawan->departemen->nama }}</td>
                            <td data-toggle="modal" data-target="#modal-qrcode-{{ $karyawan->id }}"
                                style="text-align: center;">
                                <div style="display: inline-block;">
                                    {!! DNS2D::getBarcodeHTML("$karyawan->qrcode_karyawan", 'QRCODE', 2, 2) !!}
                                </div>
                            </td>
                            <td class="text-center">
                                @if (auth()->check() && auth()->user()->fitur['karyawan show'])
                                <a href="{{ url('admin/karyawan/' . $karyawan->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @endif
                                @if (auth()->check() && auth()->user()->fitur['karyawan update'])
                                <a href="{{ url('admin/karyawan/' . $karyawan->id . '/edit') }}"
                                    class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endif
                                @if (auth()->check() && auth()->user()->fitur['karyawan delete'])
                                <button type="submit" class="btn btn-danger btn-sm" data-toggle="modal"
                                    data-target="#modal-hapus-{{ $karyawan->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                                @endif
                            </td>
                        </tr>
                        <div class="modal fade" id="modal-hapus-{{ $karyawan->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Hapus Karyawan</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Yakin hapus karyawan <strong>{{ $karyawan->nama }}</strong>?</p>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default"
                                            data-dismiss="modal">Batal</button>
                                        <form action="{{ url('admin/karyawan/' . $karyawan->id) }}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="modal-qrcode-{{ $karyawan->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Gambar QR Code</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div style="text-align: center;">
                                            <p style="font-size:20px; font-weight: bold;">
                                                {{ $karyawan->kode_karyawan }}
                                            </p>
                                            <div style="display: inline-block;">
                                                {!! DNS2D::getBarcodeHTML("$karyawan->qrcode_karyawan", 'QRCODE', 15,
                                                15) !!}
                                            </div>
                                            <p style="font-size:20px; font-weight: bold;">
                                                {{ $karyawan->nama_lengkap }}
                                            </p>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default"
                                                data-dismiss="modal">Batal</button>
                                            <a href="{{ url('admin/karyawan/cetak-pdf/' . $karyawan->id) }}"
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
            @if ($karyawans->total() > 10)
            <div class="card-footer">
                <div class="pagination float-right">
                    {{ $karyawans->appends(Request::all())->links('pagination::simple-bootstrap-4') }}
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@endsection