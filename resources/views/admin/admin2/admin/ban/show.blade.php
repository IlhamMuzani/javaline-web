@extends('layouts.app')

@section('title', 'Lihat Ban')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Ban</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ url('admin/ban') }}">Ban</a>
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
                    <h3 class="card-title">Lihat ban</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Kode Ban</strong>
                            </div>
                            <div class="col-md-6">
                                {{ $ban->kode_ban }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>No. Seri</strong>
                            </div>
                            <div class="col-md-6">
                                {{ $ban->no_seri }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Merek Ban</strong>
                            </div>
                            <div class="col-md-6">
                                {{ $ban->merek->nama_merek }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Type Ban</strong>
                            </div>
                            <div class="col-md-6">
                                {{ $ban->typeban->nama_type }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Ukuran Ban</strong>
                            </div>
                            <div class="col-md-6">
                                {{ $ban->ukuran->ukuran }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Kondisi Ban</strong>
                            </div>
                            <div class="col-md-6">
                                {{ $ban->kondisi_ban }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Harga</strong>
                            </div>
                            <div class="col-md-6">
                                {{ $ban->harga }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>No Kabin</strong>
                            </div>
                            <div class="col-md-6">
                                @if ($ban->kendaraan)
                                    {{ $ban->kendaraan->no_kabin }}
                                @else
                                    tidak ada
                                @endif
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Posisi Ban</strong>
                            </div>
                            <div class="col-md-6">
                                {{ $ban->posisi_ban }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Umur Ban</strong>
                            </div>
                            <div class="col-md-6">
                                {{ number_format($ban->umur_ban, 0, ',', '.') }} Km
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Target Km</strong>
                            </div>
                            <div class="col-md-6">
                                {{ $ban->target_km_ban }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
