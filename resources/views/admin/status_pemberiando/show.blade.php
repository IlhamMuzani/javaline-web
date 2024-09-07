@extends('layouts.app')

@section('title', 'Status Pengambilan Do')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Status Pengambilan Do</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ url('admin/status_pemberiando') }}">Status Pengambilan Do</a>
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
                    <h3 class="card-title">Status Pengambilan Do</h3>
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
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tujuan Muat</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <strong>Tujuan Muat</strong>
                                </div>
                                <div class="col-md-4">
                                    {{ $cetakpdf->alamat_muat->alamat ?? null }} </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <strong>Telp</strong>
                                </div>
                                <div class="col-md-4">
                                    {{ $cetakpdf->alamat_muat->telp ?? null }} </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tujuan Bongkar</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <strong>Tujuan Bongkar</strong>
                                </div>
                                <div class="col-md-4">
                                    {{ $cetakpdf->alamat_bongkar->alamat ?? null }} </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <strong>Telp</strong>
                                </div>
                                <div class="col-md-4">
                                    {{ $cetakpdf->alamat_bongkar->telp ?? null }} </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Status</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <strong>Status Perjalanan</strong>
                                </div>
                                <div class="col-md-4">
                                    {{ $cetakpdf->status }} </div>
                            </div>
                            @php
                                use Carbon\Carbon;

                                $waktu_awal = Carbon::parse($cetakpdf->waktu_awal);
                                $waktu_akhir = Carbon::parse($cetakpdf->waktu_akhir);

                                $durasi = $waktu_awal->diff($waktu_akhir);
                            @endphp

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <strong>Lama Waktu</strong>
                                </div>
                                <div class="col-md-4">
                                    {{ $durasi->format('%d hari, %H jam, %I menit, %S detik') }}
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <strong>Total Km</strong>
                                </div>
                                <div class="col-md-4">
                                    @if ($cetakpdf->km_akhir == null)
                                        {{ $cetakpdf->kendaraan->km ?? '0' - $cetakpdf->km_awal }}
                                    @else
                                        {{ $cetakpdf->km_akhir - $cetakpdf->km_awal }}
                                    @endif
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <strong>Foto Surat Jalan Muat</strong>
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
                                    <strong>Foto Surat Jalan Bongkar</strong>
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
