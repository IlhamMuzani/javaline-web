@extends('layouts.app')

@section('title', 'Lihat Kendaraan')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Kendaraan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ url('admin/kendaraan') }}">Kendaraan</a>
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
                    <h3 class="card-title">Lihat kendaraan</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">                
                        <div class="col-md-6">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Kode Kendaraan</strong>
                                </div>
                                <div class="col-md-6">
                                    {{ $kendaraan->kode_kendaraan }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Golongan</strong>
                                </div>
                                <div class="col-md-6">
                                    {{ $kendaraan->golongan }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Jenis Kendaraan</strong>
                                </div>
                                <div class="col-md-6">
                                    {{ $kendaraan->jenis_kendaraan }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Devisi Mobil</strong>
                                </div>
                                <div class="col-md-6">
                                    {{ $kendaraan->devisi_mobil }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>No Kabin</strong>
                                </div>
                                <div class="col-md-6">
                                    {{ $kendaraan->no_kabin }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>No Mobil</strong>
                                </div>
                                <div class="col-md-6">
                                    {{ $kendaraan->no_mobil }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Warna</strong>
                                </div>
                                <div class="col-md-6">
                                    {{ $kendaraan->warna }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Km</strong>
                                </div>
                                <div class="col-md-6">
                                    {{ $kendaraan->km }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Target Solar</strong>
                                </div>
                                <div class="col-md-6">
                                    {{ $kendaraan->target_solar }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Batas Km Service</strong>
                                </div>
                                <div class="col-md-6">
                                    {{ $kendaraan->batas_km_service }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Keterangan</strong>
                                </div>
                                <div class="col-md-6">
                                    {{ $kendaraan->keterangan }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>No. Kirim</strong>
                                </div>
                                <div class="col-md-6">
                                    {{ $kendaraan->no_kir }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Expired Kirim</strong>
                                </div>
                                <div class="col-md-6">
                                    {{ $kendaraan->expired_kir }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>No. Stnk</strong>
                                </div>
                                <div class="col-md-6">
                                    {{ $kendaraan->no_stnk }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Expired STNK</strong>
                                </div>
                                <div class="col-md-6">
                                    {{ $kendaraan->expired_stnk }}
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </section>
@endsection
