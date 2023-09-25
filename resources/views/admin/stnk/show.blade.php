@extends('layouts.app')

@section('title', 'Lihat Stnk')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Stnk</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ url('admin/stnk') }}">Stnk</a>
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
                    <h3 class="card-title">Lihat stnk</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Kode Stnk</strong>
                            </div>
                            <div class="col-md-6">
                                {{ $stnk->kode_stnk }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>No Registrasi Kendaraan</strong>
                            </div>
                            <div class="col-md-6">
                                {{ $stnk->kendaraan->no_pol }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Nama Pemilik</strong>
                            </div>
                            <div class="col-md-6">
                                {{ $stnk->nama_pemilik }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Alamat</strong>
                            </div>
                            <div class="col-md-6">
                                {{ $stnk->alamat }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Merek</strong>
                            </div>
                            <div class="col-md-6">
                                {{ $stnk->merek }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Type</strong>
                            </div>
                            <div class="col-md-6">
                                {{ $stnk->type }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Jenis Kendaraan</strong>
                            </div>
                            <div class="col-md-6">
                                {{ $stnk->jenis_kendaraan->nama_jenis_kendaraan }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Model</strong>
                            </div>
                            <div class="col-md-6">
                                {{ $stnk->model }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Tahun Pembuatan</strong>
                            </div>
                            <div class="col-md-6">
                                {{ $stnk->tahun_pembuatan }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Nomor Rangka</strong>
                            </div>
                            <div class="col-md-6">
                                {{ $stnk->no_rangka }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Nomor Mesin</strong>
                            </div>
                            <div class="col-md-6">
                                {{ $stnk->no_mesin }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Warna</strong>
                            </div>
                            <div class="col-md-6">
                                {{ $stnk->warna }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Warna TNKB</strong>
                            </div>
                            <div class="col-md-6">
                                {{ $stnk->warna_tnkb }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Tahun Registrasi</strong>
                            </div>
                            <div class="col-md-6">
                                {{ $stnk->tahun_registrasi }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Nomor BPKB</strong>
                            </div>
                            <div class="col-md-6">
                                {{ $stnk->nomor_bpkb }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Berlaku sampai</strong>
                            </div>
                            <div class="col-md-6">
                                {{ $stnk->expired_stnk }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
