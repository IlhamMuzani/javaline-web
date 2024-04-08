@extends('layouts.app')

@section('title', 'Lihat Supplier')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Supplier</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ url('admin/supplier') }}">Supplier</a>
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
                    <h3 class="card-title">Lihat supplier</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Nama Supplier</strong>
                            </div>
                            <div class="col-md-6">
                                {{ $supplier->nama_supp }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Kode Supplier</strong>
                            </div>
                            <div class="col-md-6">
                                {{ $supplier->kode_supplier }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>No NPWP</strong>
                            </div>
                            <div class="col-md-6">
                                {{ $supplier->npwp }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Alamat</strong>
                            </div>
                            <div class="col-md-6">
                                {{ $supplier->alamat }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Nama</strong>
                            </div>
                            <div class="col-md-6">
                                {{ $supplier->nama_person }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Jabatan</strong>
                            </div>
                            <div class="col-md-6">
                                {{ $supplier->jabatan }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Telepon</strong>
                            </div>
                            <div class="col-md-6">
                                {{ $supplier->telp }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Fax</strong>
                            </div>
                            <div class="col-md-6">
                                {{ $supplier->fax }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Hp</strong>
                            </div>
                            <div class="col-md-6">
                                {{ $supplier->hp }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Email</strong>
                            </div>
                            <div class="col-md-6">
                                {{ $supplier->email }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Nama Bank</strong>
                            </div>
                            <div class="col-md-6">
                                {{ $supplier->nama_bank }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Atas Nama</strong>
                            </div>
                            <div class="col-md-6">
                                {{ $supplier->atas_nama }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>No. Rekening</strong>
                            </div>
                            <div class="col-md-6">
                                {{ $supplier->norek }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
