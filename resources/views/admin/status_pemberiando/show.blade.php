@extends('layouts.app')

@section('title', 'Status Pemberian Do')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Status Pemberian Do</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ url('admin/status_pemberiando') }}">Status Pemberian Do</a>
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
                    <h3 class="card-title">Status Pemberian Do</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <strong>Kode SPK</strong>
                                </div>
                                <div class="col-md-4">
                                    {{ $cetakpdf->spk->kode_spk ?? null }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <strong>Kode Pemberian Do</strong>
                                </div>
                                <div class="col-md-4">
                                    {{ $cetakpdf->kode_pengambilan }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <strong>Tanggal</strong>
                                </div>
                                <div class="col-md-4">
                                    {{ $cetakpdf->spk->tanggal }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <strong>Nama Pelanggan</strong>
                                </div>
                                <div class="col-md-4">
                                    {{ $cetakpdf->spk->pelanggan->nama_pell ?? null }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <strong>Nama Dirver</strong>
                                </div>
                                <div class="col-md-4">
                                    {{ $cetakpdf->spk->nama_driver ?? null }} </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <strong>Rute Perjalanan</strong>
                                </div>
                                <div class="col-md-4">
                                    {{ $cetakpdf->rute_perjalanan->nama_rute ?? null }} </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <strong>Alamat Muat</strong>
                                </div>
                                <div class="col-md-4">
                                    {{ $cetakpdf->alamat_muat->alamat ?? null }} </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <strong>Alamat Bongkar</strong>
                                </div>
                                <div class="col-md-4">
                                    {{ $cetakpdf->alamat_muat->alamat ?? null }} </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <strong>Status Perjalanan</strong>
                                </div>
                                <div class="col-md-4">
                                    {{ $cetakpdf->status }} </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <strong>Foto Memo Muat</strong>
                                </div>
                                <div class="col-md-4">
                                    @if ($cetakpdf->gambar)
                                        <img src="{{ asset('storage/uploads/' . $cetakpdf->gambar) }}"
                                            class="w-100 rounded border">
                                    @else
                                        <img src="{{ asset('adminlte/dist/img/img-placeholder.jpg') }}"
                                            class="w-100 rounded border">
                                    @endif
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <strong>Foto Memo Sampai</strong>
                                </div>
                                <div class="col-md-4">
                                    @if ($cetakpdf->gambar)
                                        <img src="{{ asset('storage/uploads/' . $cetakpdf->bukti) }}"
                                            class="w-100 rounded border">
                                    @else
                                        <img src="{{ asset('adminlte/dist/img/img-placeholder.jpg') }}"
                                            class="w-100 rounded border">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
