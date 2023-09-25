@extends('layouts.app')

@section('title', 'Data Ban')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Ban</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Data Ban</li>
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
                    <h3 class="card-title">Data Ban</h3>
                    <div class="float-right">
                        <a href="{{ url('admin/ban/create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah
                        </a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="GET" id="form-action">
                        <div class="form-row">
                            <div class="col-md-4 col-sm-12">
                                <div class="input-group mb-2">
                                    <select class="custom-select form-control mr-2" id="status" name="status">
                                        <option value="">- Semua Status -</option>
                                        <option value="stok" {{ Request::get('status') == 'stok' ? 'selected' : '' }}>
                                            stok</option>
                                        <option value="aktif" {{ Request::get('status') == 'aktif' ? 'selected' : '' }}>
                                            aktif
                                        </option>
                                        <option value="non aktif"
                                            {{ Request::get('status') == 'non aktif' ? 'selected' : '' }}>
                                            non aktif</option>
                                    </select>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-outline-primary" onclick="cari()">
                                            <i class="fas fa-search"></i> Cari
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Kode Ban</th>
                                <th>No Seri</th>
                                <th>Merek Ban</th>
                                <th>Type Ban</th>
                                <th>Ukuran</th>
                                <th class="text-center">Qr Code</th>
                                <th>Keterangan</th>
                                <th class="text-center" width="150">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bans as $ban)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $ban->kode_ban }}</td>
                                    <td>{{ $ban->no_seri }}</td>
                                    <td>
                                        @if ($ban->merek)
                                            {{ $ban->merek->nama_merek }}
                                        @else
                                            merek tidak ada
                                        @endif
                                    </td>
                                    <td>
                                        @if ($ban->typeban)
                                            {{ $ban->typeban->nama_type }}
                                        @else
                                            type tidak ada
                                        @endif
                                    </td>
                                    <td>
                                        @if ($ban->ukuran)
                                            {{ $ban->ukuran->ukuran }}
                                        @else
                                            ukuran tidak ada
                                        @endif
                                    </td>
                                    <td data-toggle="modal" data-target="#modal-qrcode-{{ $ban->id }}"
                                        style="text-align: center;">
                                        <div style="display: inline-block;">
                                            {!! DNS2D::getBarcodeHTML("$ban->qrcode_ban", 'QRCODE', 2, 2) !!}
                                        </div>
                                    </td>
                                    <td>
                                        @if ($ban->status == 'aktif')
                                            @if ($ban->kendaraan)
                                                {{ $ban->kendaraan->no_kabin }}
                                            @else
                                                tidak ada
                                            @endif
                                        @elseif($ban->status == 'stok')
                                            stok
                                        @elseif($ban->status == 'non aktif')
                                            non aktif
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($ban->status == 'aktif')
                                            <button type="submit" class="btn btn-success btn-sm mr-3" data-toggle="modal"
                                                data-target="#modal-detail-{{ $ban->id }}">
                                                <img src="{{ asset('storage/uploads/indikator/wheel2.png') }}"
                                                    height="17" width="17" alt="Roda Mobil">
                                            </button>
                                        @elseif($ban->status == 'stok')
                                            <button type="submit" class="btn btn-primary btn-sm mr-3">
                                                <img src="{{ asset('storage/uploads/indikator/wheel2.png') }}"
                                                    height="17" width="17" alt="Roda Mobil">
                                            </button>
                                        @elseif($ban->status == 'non aktif')
                                            <button type="submit" class="btn btn-danger btn-sm mr-3">
                                                <img src="{{ asset('storage/uploads/indikator/wheel2.png') }}"
                                                    height="17" width="17" alt="Roda Mobil">
                                            </button>
                                        @endif
                                        <a href="{{ url('admin/ban/' . $ban->id) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ url('admin/ban/' . $ban->id . '/edit') }}"
                                            class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="submit" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#modal-hapus-{{ $ban->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <div class="modal fade" id="modal-hapus-{{ $ban->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Hapus Ban</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Yakin hapus ban <strong>{{ $ban->no_seri }}</strong>?
                                                </p>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Batal</button>
                                                <form action="{{ url('admin/ban/' . $ban->id) }}" method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="modal-detail-{{ $ban->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Detail Keterangan</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="col-md">
                                                    <div class="row mb-3">
                                                        <div class="col-md">
                                                            <strong>No Kabin</strong>
                                                        </div>
                                                        <div class="col">
                                                            @if ($ban->kendaraan)
                                                                {{ $ban->kendaraan->no_kabin }}
                                                            @else
                                                                tidak ada
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col">
                                                            <strong>No Registrasi</strong>
                                                        </div>
                                                        <div class="col">
                                                            @if ($ban->kendaraan)
                                                                {{ $ban->kendaraan->no_pol }}
                                                            @else
                                                                tidak ada
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col">
                                                            <strong>Jenis Kendaraan</strong>
                                                        </div>
                                                        <div class="col">
                                                            @if ($ban->kendaraan)
                                                                {{ $ban->kendaraan->jenis_kendaraan->nama_jenis_kendaraan }}
                                                            @else
                                                                tidak ada
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col">
                                                            <strong>Posisi Ban</strong>
                                                        </div>
                                                        <div class="col">
                                                            {{ $ban->posisi_ban }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="modal-qrcode-{{ $ban->id }}">
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
                                                    <div style="display: inline-block;">
                                                        {!! DNS2D::getBarcodeHTML("$ban->qrcode_ban", 'QRCODE', 15, 15) !!}
                                                    </div>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">Batal</button>
                                                    <a href="{{ url('admin/ban/cetak-pdf/' . $ban->id) }}"
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
                <!-- /.card-body -->
            </div>
        </div>
    </section>

    <script>
        var form = document.getElementById('form-action');

        function cari() {
            form.action = "{{ url('admin/ban') }}";
            form.submit();
        }
    </script>
@endsection
