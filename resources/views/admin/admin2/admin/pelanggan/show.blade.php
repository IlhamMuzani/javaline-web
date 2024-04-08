@extends('layouts.app')

@section('title', 'Lihat Pelanggan')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Pelanggan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ url('admin/pelanggan') }}">Pelanggan</a>
                        </li>
                        <li class="breadcrumb-item active">Lihat</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Lihat pelanggan</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Kode Pelanggan</strong>
                            </div>
                            <div class="col-md-6">
                                {{ $pelanggan->kode_pelanggan }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Nama Pelanggan</strong>
                            </div>
                            <div class="col-md-6">
                                {{ $pelanggan->nama_pell }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>No. NPWP</strong>
                            </div>
                            <div class="col-md-6">
                                {{ $pelanggan->npwp }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Alamat</strong>
                            </div>
                            <div class="col-md-6">
                                {{ $pelanggan->alamat }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Nama</strong>
                            </div>
                            <div class="col-md-6">
                                {{ $pelanggan->nama_person }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Jabatan</strong>
                            </div>
                            <div class="col-md-6">
                                {{ $pelanggan->jabatan }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Telepon</strong>
                            </div>
                            <div class="col-md-6">
                                {{ $pelanggan->telp }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Fax</strong>
                            </div>
                            <div class="col-md-6">
                                {{ $pelanggan->fax }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Hp</strong>
                            </div>
                            <div class="col-md-6">
                                {{ $pelanggan->hp }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Email</strong>
                            </div>
                            <div class="col-md-6">
                                {{ $pelanggan->email }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
