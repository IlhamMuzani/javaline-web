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
                                        {{ $odometer - $cetakpdf->km_awal }} Km
                                    @else
                                        {{ $cetakpdf->km_akhir - $cetakpdf->km_awal }} Km
                                    @endif
                                </div>
                            </div>
                            <style>
                                #gambar1,
                                #gambar2,
                                #gambar3 {
                                    width: 100%;
                                    /* Menyesuaikan lebar gambar dengan kolom */
                                    height: auto;
                                    /* Memastikan proporsi gambar tetap */
                                    object-fit: cover;
                                    /* Memastikan gambar mengisi kontainer tanpa merusak proporsi */
                                }

                                #col1,
                                #col2,
                                #col3 {
                                    width: 33.33%;
                                    /* Menetapkan lebar kolom menjadi sepertiga dari kontainer */
                                    padding: 0.5rem;
                                    /* Menambah jarak di dalam kolom */
                                    box-sizing: border-box;
                                    /* Termasuk padding dan border dalam perhitungan lebar */
                                    display: flex;
                                    justify-content: center;
                                    /* Memastikan gambar berada di tengah kolom */
                                }

                                .row img {
                                    width: 100%;
                                    /* Menyesuaikan lebar gambar dengan kolom */
                                    height: auto;
                                    /* Memastikan proporsi gambar tetap */
                                    object-fit: cover;
                                    /* Memastikan gambar mengisi kontainer tanpa merusak proporsi */
                                }
                            </style>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <strong>Foto Surat Jalan Muat</strong>
                                </div>
                                <div class="col-md-8 d-flex">
                                    <div id="col1">
                                        @if ($cetakpdf->gambar)
                                            <img id="gambar1" data-toggle="modal"
                                                data-target="#modal-foto-{{ $cetakpdf->id }}"
                                                src="{{ asset('storage/uploads/' . $cetakpdf->gambar) }}"
                                                class="rounded border">
                                        @else
                                            <img id="gambar1" src="{{ asset('adminlte/dist/img/img-placeholder.jpg') }}"
                                                class="rounded border">
                                        @endif
                                    </div>
                                    <div id="col2">
                                        @if ($cetakpdf->gambar2)
                                            <img id="gambar2" data-toggle="modal"
                                                data-target="#modal-foto2-{{ $cetakpdf->id }}"
                                                src="{{ asset('storage/uploads/' . $cetakpdf->gambar2) }}"
                                                class="rounded border">
                                        @else
                                            <img id="gambar2" src="{{ asset('adminlte/dist/img/img-placeholder.jpg') }}"
                                                class="rounded border">
                                        @endif
                                    </div>
                                    <div id="col3">
                                        @if ($cetakpdf->gambar3)
                                            <img id="gambar3" data-toggle="modal"
                                                data-target="#modal-foto3-{{ $cetakpdf->id }}"
                                                src="{{ asset('storage/uploads/' . $cetakpdf->gambar3) }}"
                                                class="rounded border">
                                        @else
                                            <img id="gambar3" src="{{ asset('adminlte/dist/img/img-placeholder.jpg') }}"
                                                class="rounded border">
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <style>
                                #bukti1,
                                #bukti2,
                                #bukti3 {
                                    width: 100%;
                                    /* Menyesuaikan lebar gambar dengan kolom */
                                    height: auto;
                                    /* Memastikan proporsi gambar tetap */
                                    object-fit: cover;
                                    /* Memastikan gambar mengisi kontainer tanpa merusak proporsi */
                                }

                                #col1,
                                #col2,
                                #col3 {
                                    width: 33.33%;
                                    /* Menetapkan lebar kolom menjadi sepertiga dari kontainer */
                                    padding: 0.5rem;
                                    /* Menambah jarak di dalam kolom */
                                    box-sizing: border-box;
                                    /* Termasuk padding dan border dalam perhitungan lebar */
                                    display: flex;
                                    justify-content: center;
                                    /* Memastikan gambar berada di tengah kolom */
                                }

                                .row img {
                                    width: 100%;
                                    /* Menyesuaikan lebar gambar dengan kolom */
                                    height: auto;
                                    /* Memastikan proporsi gambar tetap */
                                    object-fit: cover;
                                    /* Memastikan gambar mengisi kontainer tanpa merusak proporsi */
                                }
                            </style>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <strong>Foto Surat Jalan Bongkar</strong>
                                </div>
                                <div class="col-md-8 d-flex">
                                    <div id="bukti1" class="w-33 p-1">
                                        @if ($cetakpdf->bukti)
                                            <img data-toggle="modal"
                                                data-target="#modal-fototerbongkar-{{ $cetakpdf->id }}"
                                                src="{{ asset('storage/uploads/' . $cetakpdf->bukti) }}"
                                                class="w-100 rounded border">
                                        @else
                                            <img src="{{ asset('adminlte/dist/img/img-placeholder.jpg') }}"
                                                class="w-100 rounded border">
                                        @endif
                                    </div>
                                    <div id="bukti2" class="w-33 p-1">
                                        @if ($cetakpdf->bukti2)
                                            <img data-toggle="modal"
                                                data-target="#modal-fototerbongkar2-{{ $cetakpdf->id }}"
                                                src="{{ asset('storage/uploads/' . $cetakpdf->bukti2) }}"
                                                class="w-100 rounded border">
                                        @else
                                            <img src="{{ asset('adminlte/dist/img/img-placeholder.jpg') }}"
                                                class="w-100 rounded border">
                                        @endif
                                    </div>
                                    <div id="bukti3" class="w-33 p-1">
                                        @if ($cetakpdf->bukti3)
                                            <img data-toggle="modal"
                                                data-target="#modal-fototerbongkar3-{{ $cetakpdf->id }}"
                                                src="{{ asset('storage/uploads/' . $cetakpdf->bukti3) }}"
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

                <div class="modal fade" id="modal-foto-{{ $cetakpdf->id }}">
                    <div class="modal-dialog modal-lg"> <!-- Tambahkan modal-lg untuk memperbesar ukuran modal -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Foto Surat Jalan Muat</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div style="text-align: center;">
                                    <img src="{{ asset('storage/uploads/' . $cetakpdf->gambar) }}"
                                        class="img-fluid rounded border" width="400px" height="400px">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modal-foto2-{{ $cetakpdf->id }}">
                    <div class="modal-dialog modal-lg"> <!-- Tambahkan modal-lg untuk memperbesar ukuran modal -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Foto Surat Jalan Muat</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div style="text-align: center;">
                                    <img src="{{ asset('storage/uploads/' . $cetakpdf->gambar2) }}"
                                        class="img-fluid rounded border" width="400px" height="400px">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modal-foto3-{{ $cetakpdf->id }}">
                    <div class="modal-dialog modal-lg"> <!-- Tambahkan modal-lg untuk memperbesar ukuran modal -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Foto Surat Jalan Muat</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div style="text-align: center;">
                                    <img src="{{ asset('storage/uploads/' . $cetakpdf->gambar3) }}"
                                        class="img-fluid rounded border" width="400px" height="400px">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modal-fototerbongkar-{{ $cetakpdf->id }}">
                    <div class="modal-dialog modal-lg"> <!-- Tambahkan modal-lg untuk memperbesar ukuran modal -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Foto Surat Jalan Terbongkar</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div style="text-align: center;">
                                    <img src="{{ asset('storage/uploads/' . $cetakpdf->bukti) }}"
                                        class="img-fluid rounded border" width="400px" height="400px">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modal-fototerbongkar2-{{ $cetakpdf->id }}">
                    <div class="modal-dialog modal-lg"> <!-- Tambahkan modal-lg untuk memperbesar ukuran modal -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Foto Surat Jalan Terbongkar</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div style="text-align: center;">
                                    <img src="{{ asset('storage/uploads/' . $cetakpdf->bukti2) }}"
                                        class="img-fluid rounded border" width="400px" height="400px">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modal-fototerbongkar3-{{ $cetakpdf->id }}">
                    <div class="modal-dialog modal-lg"> <!-- Tambahkan modal-lg untuk memperbesar ukuran modal -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Foto Surat Jalan Terbongkar</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div style="text-align: center;">
                                    <img src="{{ asset('storage/uploads/' . $cetakpdf->bukti3) }}"
                                        class="img-fluid rounded border" width="400px" height="400px">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
    </section>
@endsection
