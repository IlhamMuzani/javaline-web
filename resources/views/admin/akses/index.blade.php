@extends('layouts.app')

@section('title', 'Data Akses')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Akses</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Data Akses</li>
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
                    <h3 class="card-title">Data Akses</h3>
                    <div class="float-right">
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Kode User</th>
                                <th>Nama</th>
                                <th class="text-center" width="60">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($aksess as $akses)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $akses->kode_user }}</td>
                                    <td>{{ $akses->karyawan->nama_lengkap }}</td>
                                    <td class="text-center">
                                        <a href="{{ url('admin/akses/access/' . $akses->id) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-low-vision"></i> Akses
                                        </a>
                                        {{-- <a href="{{ url('admin/akses/' . $akses->id . '/edit') }}"
                                            class="btn btn-warning btn-sm">
                                            <i class="fas fa-low-vision"></i> Update Akses
                                        </a> --}}
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
