@extends('layouts.app')

@section('title', 'Penggantian Oli')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Penggantian Oli</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Penggantian Oli</li>
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
                    <h3 class="card-title">Penggantian Oli</h3>
                    {{-- <div class="float-right">
                        <a href="{{ url('admin/kendaraan/create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah
                        </a>
                    </div> --}}
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Kode</th>
                                <th>No. Kabin</th>
                                <th>Jenis Kendaraan</th>
                                <th>Keterangan</th>
                                <th class="text-center" width="90">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kendaraans as $kendaraan)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $kendaraan->kode_kendaraan }}</td>
                                    <td>{{ $kendaraan->no_kabin }}</td>
                                    <td>
                                        @if ($kendaraan->jenis_kendaraan)
                                            {{ $kendaraan->jenis_kendaraan->nama_jenis_kendaraan }}
                                        @else
                                            data tidak ada
                                        @endif
                                    </td>
                                    <td>
                                        @if (
                                            $kendaraan->status_olimesin == 'belum penggantian' ||
                                                $kendaraan->status_oligardan == 'belum penggantian' ||
                                                $kendaraan->status_olitransmisi == 'belum penggantian')
                                            @if ($kendaraan->status_olimesin == 'belum penggantian')
                                                <span class="status_olimesin"> Oli Mesin
                                                    <i class="fas fa-exclamation-circle" style="color: red;"></i>
                                                </span>
                                                <br>
                                            @endif

                                            @if ($kendaraan->status_oligardan == 'belum penggantian')
                                                <span class="status_oligardan"> Oli Gardan
                                                    <i class="fas fa-exclamation-circle" style="color: red;"></i>
                                                </span>
                                                <br>
                                            @endif

                                            @if ($kendaraan->status_olitransmisi == 'belum penggantian')
                                                <span class="status_olitransmisi"> Oli Transmisi
                                                    <i class="fas fa-exclamation-circle" style="color: red;"></i>
                                                </span>
                                                <br>
                                            @endif
                                        @else
                                            Konfirmasi
                                        @endif

                                    </td>

                                    <td class="text-center">
                                        @if (auth()->check() && auth()->user()->fitur['penggantian oli create'])
                                            @if (
                                                $kendaraan->status_olimesin == 'konfirmasi' ||
                                                    $kendaraan->status_oligardan == 'konfirmasi' ||
                                                    $kendaraan->status_olitransmisi == 'konfirmasi')
                                                {{-- <a href="{{ url('admin/penggantian_oli/' . $kendaraan->id) }}"
                                                class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a> --}}
                                                <a href="{{ url('admin/penggantian_oli/' . $kendaraan->id . '/edit') }}"
                                                    class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ url('admin/penggantian_oli/checkpostoli/' . $kendaraan->id) }}"
                                                    class="btn btn-success btn-sm">
                                                    <i class="fas fa-check"></i>
                                                </a>
                                            @else
                                                <a href="{{ url('admin/penggantian_oli/' . $kendaraan->id . '/edit') }}"
                                                    class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endif
                                        @endif

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </section>
    <!-- /.card -->
@endsection
