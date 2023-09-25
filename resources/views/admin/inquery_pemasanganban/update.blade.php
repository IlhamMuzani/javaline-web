@extends('layouts.app')

@section('title', 'Inquery Pemasangan')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Pemasangan Ban</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/pelepasan_ban') }}">Pemasangan Ban</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

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
            @if (session('errors'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-check"></i> Success!
                    </h5>
                    @foreach (session('errors') as $errors)
                        - {{ $errors }} <br>
                    @endforeach
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-ban"></i> Error!
                    </h5>
                    @foreach (session('error') as $error)
                        - {{ $error }} <br>
                    @endforeach
                </div>
            @endif
            <form action="{{ url('admin/inquery_pemasanganban/' . $inquerypemasangan->id) }}" method="POST"
                enctype="multipart/form-data" autocomplete="off">
                @csrf
                @method('put')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Pemasangan Ban</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nopol">No. Kabin</label>
                            <input type="text" class="form-control" id="no_pol" name="no_pol" readonly
                                placeholder="Masukan no registrasi kendaraan" value="{{ $kendaraan->no_kabin }}">
                        </div>
                        <div class="form-group">
                            <label for="nopol">No. Registrasi Kendaraan</label>
                            <input type="text" class="form-control" id="no_pol" name="no_pol" readonly
                                placeholder="Masukan no registrasi kendaraan" value="{{ $kendaraan->no_pol }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">Jumlah Ban</label>
                            <input type="text" class="form-control" id="jumlah_ban" name="jumlah_ban" readonly
                                placeholder="Masukan jumlah ban" value="{{ $kendaraan->jenis_kendaraan->total_ban }}">
                        </div>
                        <div class="form-group" id="layoutjenis">
                            <label for="jenis_kendaraan">Jenis Kendaraan</label>
                            <input type="text" class="form-control" id="jenis_kendaraan" name="jenis_kendaraan" readonly
                                placeholder="Masukan jenis kendaraan"
                                value="{{ $kendaraan->jenis_kendaraan->nama_jenis_kendaraan }}">
                        </div>
                    </div>
                </div>
                {{-- div diatas ini --}}
                <div class="card" id="layout_posisi">
                    <div class="card-header">
                        <h3 class="card-title">Posisi Ban</h3>
                    </div>
                    <div class="row">
                        <div class="card-body">
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="col">
                                    {{-- baris axle 1  --}}
                                    <div class="row mb-5">
                                        <div class="row">
                                            <div class="form-group mt-2" style="text-align: center;">
                                                @if ($bans != null)
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/hijau.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @else
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/merah.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @endif
                                                <div class="mt-2" data-toggle="modal"
                                                    data-target="#modal-exle_1A-{{ $kendaraan->id }}">
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/karyawan/1A.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>
                                            <div class="form-group mt-5" style="text-align: center;">
                                                <label>Axle 1</label>
                                                <div class="">
                                                    <img class="mt-2"
                                                        src="{{ asset('storage/uploads/karyawan/axle.png') }}"
                                                        alt="AdminLTELogo" height="20" width="200">
                                                </div>
                                            </div>
                                            <div class="form-group mt-2" style="text-align: center;">
                                                @if ($bansb != null)
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/hijau.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @else
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/merah.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @endif
                                                <div class="mt-2"data-toggle="modal"
                                                    data-target="#modal-exle_1B-{{ $kendaraan->id }}">
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/karyawan/1B.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- baris axle 2  --}}
                                    <div class="row mb-5">
                                        <div class="row">
                                            <div class="form-group" style="text-align: center;">
                                                @if ($bans2a != null)
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/hijau.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @else
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/merah.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @endif
                                                <div class="mt-2" data-toggle="modal"
                                                    data-target="#modal-exle_2A-{{ $kendaraan->id }}">
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/karyawan/2A.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>
                                            <div class="form-group ml-1" style="text-align: center;">
                                                @if ($bans2b != null)
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/hijau.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @else
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/merah.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @endif
                                                <div class="mt-2" data-toggle="modal"
                                                    data-target="#modal-exle_2B-{{ $kendaraan->id }}">
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/karyawan/2B.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>
                                            <div class="form-group mt-5" style="text-align: center;">
                                                <label>Axle 2</label>
                                                <div class="">
                                                    <img class="mt-1"
                                                        src="{{ asset('storage/uploads/karyawan/axle.png') }}"
                                                        alt="AdminLTELogo" height="20" width="110">
                                                </div>
                                            </div>
                                            <div class="form-group" style="text-align: center;">
                                                @if ($bans2c != null)
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/hijau.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @else
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/merah.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @endif
                                                <div class="mt-2" data-toggle="modal"
                                                    data-target="#modal-exle_2C-{{ $kendaraan->id }}">
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/karyawan/2C.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>
                                            <div class="form-group ml-1" style="text-align: center;">
                                                @if ($bans2d != null)
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/hijau.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @else
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/merah.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @endif
                                                <div class="" data-toggle="modal"
                                                    data-target="#modal-exle_2D-{{ $kendaraan->id }}">
                                                    <img class="mt-2"
                                                        src="{{ asset('storage/uploads/karyawan/2D.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- baris axle 3  --}}
                            <div class="card-body" id="layout_tronton">
                                <div class="col ml-3">
                                    <div class="row mb-5">
                                        <div class="row">
                                            <div class="form-group" style="text-align: center;">
                                                @if ($bans3a != null)
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/hijau.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @else
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/merah.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @endif
                                                <div class="mt-2" data-toggle="modal"
                                                    data-target="#modal-exle_3A-{{ $kendaraan->id }}">
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/karyawan/3A.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>
                                            <div class="form-group ml-1" style="text-align: center;">
                                                @if ($bans3b != null)
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/hijau.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @else
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/merah.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @endif
                                                <div class="mt-2" data-toggle="modal"
                                                    data-target="#modal-exle_3B-{{ $kendaraan->id }}">
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/karyawan/3B.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>
                                            <div class="form-group mt-5" style="text-align: center;">
                                                <label>Axle 3</label>
                                                <div class="">
                                                    <img class="mt-1"
                                                        src="{{ asset('storage/uploads/karyawan/axle.png') }}"
                                                        alt="AdminLTELogo" height="20" width="110">
                                                </div>
                                            </div>
                                            <div class="form-group" style="text-align: center;">
                                                @if ($bans3c != null)
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/hijau.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @else
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/merah.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @endif
                                                <div class="mt-2" data-toggle="modal"
                                                    data-target="#modal-exle_3C-{{ $kendaraan->id }}">
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/karyawan/3C.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>
                                            <div class="form-group ml-1" style="text-align: center;">
                                                @if ($bans3d != null)
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/hijau.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @else
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/merah.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @endif
                                                <div class="mt-2" data-toggle="modal"
                                                    data-target="#modal-exle_3D-{{ $kendaraan->id }}">
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/karyawan/3D.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- baris axle 4 dan 5  --}}
                            <div class="card-body" id="layout_trailer_engkel">
                                <div class="col ml-3">
                                    <div class="row mb-5">
                                        <div class="row">
                                            <div class="form-group" style="text-align: center;">
                                                @if ($bans4a != null)
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/hijau.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @else
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/merah.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @endif
                                                <div class="mt-2" data-toggle="modal"
                                                    data-target="#modal-exle_4A-{{ $kendaraan->id }}">
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/karyawan/4A.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>
                                            <div class="form-group ml-1" style="text-align: center;">
                                                @if ($bans4b != null)
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/hijau.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @else
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/merah.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @endif
                                                <div class="mt-2" data-toggle="modal"
                                                    data-target="#modal-exle_4B-{{ $kendaraan->id }}">
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/karyawan/4B.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>
                                            <div class="form-group mt-5" style="text-align: center;">
                                                <label>Axle 4</label>
                                                <div class="">
                                                    <img class="mt-1"
                                                        src="{{ asset('storage/uploads/karyawan/axle.png') }}"
                                                        alt="AdminLTELogo" height="20" width="110">
                                                </div>
                                            </div>
                                            <div class="form-group" style="text-align: center;">
                                                @if ($bans4c != null)
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/hijau.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @else
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/merah.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @endif
                                                <div class="mt-2" data-toggle="modal"
                                                    data-target="#modal-exle_4C-{{ $kendaraan->id }}">
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/karyawan/4C.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>
                                            <div class="form-group ml-1" style="text-align: center;">
                                                @if ($bans4d != null)
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/hijau.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @else
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/merah.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @endif
                                                <div class="mt-2" data-toggle="modal"
                                                    data-target="#modal-exle_4D-{{ $kendaraan->id }}">
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/karyawan/4D.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="row">
                                            <div class="form-group" style="text-align: center;">
                                                @if ($bans5a != null)
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/hijau.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @else
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/merah.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @endif
                                                <div class="mt-2" data-toggle="modal"
                                                    data-target="#modal-exle_5A-{{ $kendaraan->id }}">
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/karyawan/5A.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>
                                            <div class="form-group ml-1" style="text-align: center;">
                                                @if ($bans5b != null)
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/hijau.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @else
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/merah.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @endif
                                                <div class="mt-2" data-toggle="modal"
                                                    data-target="#modal-exle_5B-{{ $kendaraan->id }}">
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/karyawan/5B.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>
                                            <div class="form-group mt-5" style="text-align: center;">
                                                <label>Axle 5</label>
                                                <div class="">
                                                    <img class="mt-1"
                                                        src="{{ asset('storage/uploads/karyawan/axle.png') }}"
                                                        alt="AdminLTELogo" height="20" width="110">
                                                </div>
                                            </div>
                                            <div class="form-group" style="text-align: center;">
                                                @if ($bans5c != null)
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/hijau.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @else
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/merah.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @endif
                                                <div class="mt-2" data-toggle="modal"
                                                    data-target="#modal-exle_5C-{{ $kendaraan->id }}">
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/karyawan/5C.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>
                                            <div class="form-group ml-1" style="text-align: center;">
                                                @if ($bans5d != null)
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/hijau.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @else
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/merah.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @endif
                                                <div class="mt-2" data-toggle="modal"
                                                    data-target="#modal-exle_5D-{{ $kendaraan->id }}">
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/karyawan/5D.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- baris axle 6  --}}
                            <div class="card-body" id="layout_trailer_tronton">
                                <div class="col ml-3">
                                    <div class="row mb-5">
                                        <div class="row">
                                            <div class="form-group" style="text-align: center;">
                                                @if ($bans6a != null)
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/hijau.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @else
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/merah.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @endif
                                                <div class="mt-2" data-toggle="modal"
                                                    data-target="#modal-exle_6A-{{ $kendaraan->id }}">
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/karyawan/6A.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>
                                            <div class="form-group ml-1" style="text-align: center;">
                                                @if ($bans6b != null)
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/hijau.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @else
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/merah.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @endif
                                                <div class="mt-2" data-toggle="modal"
                                                    data-target="#modal-exle_6B-{{ $kendaraan->id }}">
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/karyawan/6B.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>
                                            <div class="form-group mt-5" style="text-align: center;">
                                                <label>Axle 6</label>
                                                <div class="">
                                                    <img class="mt-1"
                                                        src="{{ asset('storage/uploads/karyawan/axle.png') }}"
                                                        alt="AdminLTELogo" height="20" width="110">
                                                </div>
                                            </div>
                                            <div class="form-group" style="text-align: center;">
                                                @if ($bans6c != null)
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/hijau.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @else
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/merah.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @endif
                                                <div class="mt-2" data-toggle="modal"
                                                    data-target="#modal-exle_6C-{{ $kendaraan->id }}">
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/karyawan/6C.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>
                                            <div class="form-group ml-1" style="text-align: center;">
                                                @if ($bans6d != null)
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/hijau.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @else
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/merah.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @endif
                                                <div class="mt-2" data-toggle="modal"
                                                    data-target="#modal-exle_6D-{{ $kendaraan->id }}">
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/karyawan/6D.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button type="reset" class="btn btn-secondary">Reset</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
            </form>
        </div>
        <div class="card-body">
            <!-- /.card-header -->
            {{-- <div class=""> --}}
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Posisi</th>
                            <th>Kode</th>
                            <th>No. Seri</th>
                            <th>Ukuran</th>
                            <th>Merek</th>
                            <th>Kondisi</th>
                            <th class="text-center" width="">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tabelbans as $ban)
                            <tr class="">
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $ban->posisi_ban }}</td>
                                <td>{{ $ban->kode_ban }}</td>
                                <td>{{ $ban->no_seri }}</td>
                                <td>{{ $ban->ukuran->ukuran }}</td>
                                <td>{{ $ban->merek->nama_merek }}</td>
                                <td>{{ $ban->kondisi_ban }}</td>
                                <td class="text-center">
                                    <a class="btn btn-danger btn-sm" data-toggle="modal"
                                        data-target="#modal-hapus1-{{ $ban->id }}">
                                        <i class="fas fa-trash"></i> Hapus
                                    </a>
                                </td>
                                <div class="modal fade" id="modal-hapus1-{{ $ban->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Hapus Ban</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Yakin hapus pemasangan ban?
                                                    <strong>{{ $ban->no_seri }}</strong>?
                                                </p>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Batal</button>
                                                <form action="{{ url('admin/inquery_pemasanganban/' . $ban->id) }}"
                                                    method="POST" enctype="multipart/form-data" autocomplete="off">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{-- </div> --}}
        </div>
        {{-- modal exle 1A  --}}
        @if ($bans == null)
            <div class="modal fade" id="modal-exle_1A-{{ $kendaraan->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 1A</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="{{ url('admin/inquerypemasangan1/' . $kendaraan->id) }}" method="POST"
                                    enctype="multipart/form-data" autocomplete="off">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group" hidden>
                                            <label for="posisi_ban">Kendaraan Id</label>
                                            <input type="text" class="form-control" readonly name="kendaraan_id"
                                                placeholder="Masukan km pemasangan" value="{{ $kendaraan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="posisi_ban">Pemasangan Id</label>
                                            <input type="text" class="form-control" readonly name="pemasangan_ban_id"
                                                placeholder="" value="{{ $inquerypemasangan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="posisi_ban">Posisi Ban</label>
                                            <input type="text" class="form-control" readonly name="posisi_1a"
                                                placeholder="Masukan km pemasangan" value="1A">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="exel_1a">No. Seri Ban</label>
                                            <select class="form-control" id="exel_1b" name="exel_1a">
                                                <option value="">- Pilih -</option>
                                                @foreach ($daftarbans as $ban)
                                                    <option value="{{ $ban->id }}"
                                                        {{ old('ban_id') == $ban->id ? 'selected' : '' }}>
                                                        {{ $ban->no_seri }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" id="km_pemasangan1"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ $kendaraan->km_pemasangan }}">
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button type="reset" class="btn btn-secondary">Reset</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="modal fade" id="modal-exle_1A-{{ $kendaraan->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 1A</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="{{ url('admin/pelepasan1/' . $kendaraan->id) }}" method="POST"
                                    enctype="multipart/form-data" autocomplete="off">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group">
                                            <h4>Hapus ban terlebih dahulu</h4>
                                            {{-- <p>Tidak ada Ban terpasang di axle 1A</p> --}}
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- modal exle 1B  --}}
        @if ($bansb == null)
            <div class="modal fade" id="modal-exle_1B-{{ $kendaraan->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 1B</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="{{ url('admin/inquerypemasangan1b/' . $kendaraan->id) }}" method="POST"
                                    enctype="multipart/form-data" autocomplete="off">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group" hidden>
                                            <label for="kendaraan_id">Id Kendaraan</label>
                                            <input type="text" class="form-control" id="kendaraan_x1b" readonly
                                                name="kendaraan_id" placeholder="Masukan id kendaraan"
                                                value="{{ $kendaraan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="posisi_ban">Pemasangan Id</label>
                                            <input type="text" class="form-control" readonly name="pemasangan_ban_id"
                                                placeholder="" value="{{ $inquerypemasangan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="posisi_ban">Posisi Ban</label>
                                            <input type="text" class="form-control" readonly name="posisi_1b"
                                                placeholder="Masukan km pemasangan" value="1B">
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label" for="exel_1b">No. Seri Ban</label>
                                            <select class="form-control" id="exel_1b" name="exel_1b">
                                                <option value="">- Pilih -</option>
                                                @foreach ($daftarbans as $ban)
                                                    <option value="{{ $ban->id }}"
                                                        {{ old('ban_id') == $ban->id ? 'selected' : '' }}>
                                                        {{ $ban->no_seri }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" id="km_pemasangan"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ old('km_pemasangan') }}">
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button type="reset" class="btn btn-secondary">Reset</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="modal fade" id="modal-exle_1B-{{ $kendaraan->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 1B</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
                                    @csrf
                                    <div class="card-body">

                                        <div class="form-group">
                                            <h4>Hapus ban terlebih dahulu</h4>
                                            {{-- <p>Tidak ada Ban terpasang di axle 1B</p> --}}
                                        </div>
                                    </div>
                                </form>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- modal exle 2A  --}}
        @if ($bans2a == null)
            <div class="modal fade" id="modal-exle_2A-{{ $kendaraan->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 2A</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="{{ url('admin/inquerypemasangan2a/' . $kendaraan->id) }}" method="POST"
                                    enctype="multipart/form-data" autocomplete="off">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group" hidden>
                                            <label for="kendaraan_id">Id Kendaraan</label>
                                            <input type="text" class="form-control" id="kendaraan_x2a" readonly
                                                name="kendaraan_id" placeholder="Masukan id kendaraan"
                                                value="{{ $kendaraan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="posisi_ban">Pemasangan Id</label>
                                            <input type="text" class="form-control" readonly name="pemasangan_ban_id"
                                                placeholder="" value="{{ $inquerypemasangan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="posisi_ban">Posisi Ban</label>
                                            <input type="text" class="form-control" readonly name="posisi_2a"
                                                placeholder="Masukan km pemasangan" value="2A">
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label" for="exel_1a">No. Seri Ban</label>
                                            <select class="form-control" id="exel_1b" name="exel_2a">
                                                <option value="">- Pilih -</option>
                                                @foreach ($daftarbans as $ban)
                                                    <option value="{{ $ban->id }}"
                                                        {{ old('ban_id') == $ban->id ? 'selected' : '' }}>
                                                        {{ $ban->no_seri }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" id="km_pemasangan"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ old('km_pemasangan') }}">
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button type="reset" class="btn btn-secondary">Reset</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="modal fade" id="modal-exle_2A-{{ $kendaraan->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 2A</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
                                    @csrf
                                    <div class="card-body">

                                        <div class="form-group">
                                            {{-- <label class="form-label" for="warna">Ban tidak ada</label> --}}
                                            <h4>Hapus ban terlebih dahulu</h4>
                                            {{-- <p>Tidak ada Ban terpasang di axle 2A</p> --}}
                                        </div>
                                    </div>
                                </form>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- modal exle 2B  --}}
        @if ($bans2b == null)
            <div class="modal fade" id="modal-exle_2B-{{ $kendaraan->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 2B</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="{{ url('admin/inquerypemasangan2b/' . $kendaraan->id) }}" method="POST"
                                    enctype="multipart/form-data" autocomplete="off">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group" hidden>
                                            <label for="kendaraan_id">Id Kendaraan</label>
                                            <input type="text" class="form-control" id="kendaraan_x2b" readonly
                                                name="kendaraan_id" placeholder="Masukan id kendaraan"
                                                value="{{ $kendaraan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="posisi_ban">Posisi Ban</label>
                                            <input type="text" class="form-control" readonly name="posisi_2b"
                                                placeholder="Masukan km pemasangan" value="2B">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="posisi_ban">Pemasangan Id</label>
                                            <input type="text" class="form-control" readonly name="pemasangan_ban_id"
                                                placeholder="" value="{{ $inquerypemasangan->id }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="exel_1a">No. Seri Ban</label>
                                            <select class="form-control" id="exel_1b" name="exel_2b">
                                                <option value="">- Pilih -</option>
                                                @foreach ($daftarbans as $ban)
                                                    <option value="{{ $ban->id }}"
                                                        {{ old('ban_id') == $ban->id ? 'selected' : '' }}>
                                                        {{ $ban->no_seri }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" id="km_pemasangan"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ old('km_pemasangan') }}">
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button type="reset" class="btn btn-secondary">Reset</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="modal fade" id="modal-exle_2B-{{ $kendaraan->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 2B</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group">
                                            {{-- <label class="form-label" for="warna">Ban tidak ada</label> --}}
                                            <h4>Hapus ban terlebih dahulu</h4>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- modal exle 2C  --}}
        @if ($bans2c == null)
            <div class="modal fade" id="modal-exle_2C-{{ $kendaraan->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 2C</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="{{ url('admin/inquerypemasangan2c/' . $kendaraan->id) }}" method="POST"
                                    enctype="multipart/form-data" autocomplete="off">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group" hidden>
                                            <label for="kendaraan_id">Id Kendaraan</label>
                                            <input type="text" class="form-control" id="kendaraan_x2c" readonly
                                                name="kendaraan_id" placeholder="Masukan id kendaraan"
                                                value="{{ $kendaraan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="posisi_ban">Pemasangan Id</label>
                                            <input type="text" class="form-control" readonly name="pemasangan_ban_id"
                                                placeholder="" value="{{ $inquerypemasangan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="posisi_ban">Posisi Ban</label>
                                            <input type="text" class="form-control" readonly name="posisi_2c"
                                                placeholder="Masukan km pemasangan" value="2C">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="exel_1a">No. Seri Ban</label>
                                            <select class="form-control" id="exel_1b" name="exel_2c">
                                                <option value="">- Pilih -</option>
                                                @foreach ($daftarbans as $ban)
                                                    <option value="{{ $ban->id }}"
                                                        {{ old('ban_id') == $ban->id ? 'selected' : '' }}>
                                                        {{ $ban->no_seri }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" id="km_pemasangan"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ old('km_pemasangan') }}">
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button type="reset" class="btn btn-secondary">Reset</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="modal fade" id="modal-exle_2C-{{ $kendaraan->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 2C</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="#" method="POST" enctype="multipart/form-data"
                                    autocomplete="off">
                                    @csrf
                                    <div class="card-body">

                                        <div class="form-group">
                                            {{-- <label class="form-label" for="warna">Ban tidak ada</label> --}}
                                            <h4>Hapus ban terlebih dahulu</h4>
                                            {{-- <p>Tidak ada Ban terpasang di axle 2C</p> --}}
                                        </div>
                                    </div>
                                </form>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- modal exle 2D  --}}
        @if ($bans2d == null)
            <div class="modal fade" id="modal-exle_2D-{{ $kendaraan->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 2D</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="{{ url('admin/inquerypemasangan2d/' . $kendaraan->id) }}" method="POST"
                                    enctype="multipart/form-data" autocomplete="off">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group" hidden>
                                            <label for="kendaraan_id">Id Kendaraan</label>
                                            <input type="text" class="form-control" id="kendaraan_x2d" readonly
                                                name="kendaraan_id" placeholder="Masukan id kendaraan"
                                                value="{{ $kendaraan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="posisi_ban">Pemasangan Id</label>
                                            <input type="text" class="form-control" readonly name="pemasangan_ban_id"
                                                placeholder="" value="{{ $inquerypemasangan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="posisi_ban">Posisi Ban</label>
                                            <input type="text" class="form-control" readonly name="posisi_2d"
                                                placeholder="Masukan km pemasangan" value="2D">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="exel_1a">No. Seri Ban</label>
                                            <select class="form-control" id="exel_1b" name="exel_2d">
                                                <option value="">- Pilih -</option>
                                                @foreach ($daftarbans as $ban)
                                                    <option value="{{ $ban->id }}"
                                                        {{ old('ban_id') == $ban->id ? 'selected' : '' }}>
                                                        {{ $ban->no_seri }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" id="km_pemasangan"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ old('km_pemasangan') }}">
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button type="reset" class="btn btn-secondary">Reset</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="modal fade" id="modal-exle_2D-{{ $kendaraan->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 2D</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="#" method="POST" enctype="multipart/form-data"
                                    autocomplete="off">
                                    @csrf
                                    <div class="card-body">

                                        <div class="form-group">
                                            {{-- <label class="form-label" for="warna">Ban tidak ada</label> --}}
                                            <h4>Hapus ban terlebih dahulu</h4>
                                            {{-- <p>Tidak ada Ban terpasang di axle 2D</p> --}}
                                        </div>
                                    </div>
                                </form>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- modal exle 3A  --}}
        @if ($bans3a == null)
            <div class="modal fade" id="modal-exle_3A-{{ $kendaraan->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 3A</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="{{ url('admin/inquerypemasangan3a/' . $kendaraan->id) }}" method="POST"
                                    enctype="multipart/form-data" autocomplete="off">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group" hidden>
                                            <label for="kendaraan_id">Id Kendaraan</label>
                                            <input type="text" class="form-control" id="kendaraan_x3a" readonly
                                                name="kendaraan_id" placeholder="Masukan id kendaraan"
                                                value="{{ $kendaraan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="posisi_ban">Pemasangan Id</label>
                                            <input type="text" class="form-control" readonly name="pemasangan_ban_id"
                                                placeholder="" value="{{ $inquerypemasangan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="posisi_ban">Posisi Ban</label>
                                            <input type="text" class="form-control" readonly name="posisi_3a"
                                                placeholder="Masukan km pemasangan" value="3A">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="exel_1a">No. Seri Ban</label>
                                            <select class="form-control" id="exel_1b" name="exel_3a">
                                                <option value="">- Pilih -</option>
                                                @foreach ($daftarbans as $ban)
                                                    <option value="{{ $ban->id }}"
                                                        {{ old('ban_id') == $ban->id ? 'selected' : '' }}>
                                                        {{ $ban->no_seri }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" id="km_pemasangan"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ old('km_pemasangan') }}">
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button type="reset" class="btn btn-secondary">Reset</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="modal fade" id="modal-exle_3A-{{ $kendaraan->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 3A</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="#" method="POST" enctype="multipart/form-data"
                                    autocomplete="off">
                                    @csrf
                                    <div class="card-body">

                                        <div class="form-group">
                                            {{-- <label class="form-label" for="warna">Ban tidak ada</label> --}}
                                            <h4>Hapus ban terlebih dahulu</h4>
                                            {{-- <p>Tidak ada Ban terpasang di axle 3A</p> --}}
                                        </div>
                                    </div>
                                </form>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- modal exle 3B  --}}
        @if ($bans3b == null)
            <div class="modal fade" id="modal-exle_3B-{{ $kendaraan->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 3B</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="{{ url('admin/inquerypemasangan3b/' . $kendaraan->id) }}" method="POST"
                                    enctype="multipart/form-data" autocomplete="off">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group" hidden>
                                            <label for="kendaraan_id">Id Kendaraan</label>
                                            <input type="text" class="form-control" id="kendaraan_x3b" readonly
                                                name="kendaraan_id" placeholder="Masukan id kendaraan"
                                                value="{{ $kendaraan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="posisi_ban">Pemasangan Id</label>
                                            <input type="text" class="form-control" readonly name="pemasangan_ban_id"
                                                placeholder="" value="{{ $inquerypemasangan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="posisi_ban">Posisi Ban</label>
                                            <input type="text" class="form-control" readonly name="posisi_3b"
                                                placeholder="Masukan km pemasangan" value="3B">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="exel_1a">No. Seri Ban</label>
                                            <select class="form-control" id="exel_1b" name="exel_3b">
                                                <option value="">- Pilih -</option>
                                                @foreach ($daftarbans as $ban)
                                                    <option value="{{ $ban->id }}"
                                                        {{ old('ban_id') == $ban->id ? 'selected' : '' }}>
                                                        {{ $ban->no_seri }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" id="km_pemasangan"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ old('km_pemasangan') }}">
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button type="reset" class="btn btn-secondary">Reset</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="modal fade" id="modal-exle_3B-{{ $kendaraan->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 3B</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="#" method="POST" enctype="multipart/form-data"
                                    autocomplete="off">
                                    @csrf
                                    <div class="card-body">

                                        <div class="form-group">
                                            {{-- <label class="form-label" for="warna">Ban tidak ada</label> --}}
                                            <h4>Hapus ban terlebih dahulu</h4>
                                            {{-- <p>Tidak ada Ban terpasang di axle 3B</p> --}}
                                        </div>
                                    </div>
                                </form>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- modal exle 3C  --}}
        @if ($bans3c == null)
            <div class="modal fade" id="modal-exle_3C-{{ $kendaraan->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 3C</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="{{ url('admin/inquerypemasangan3c/' . $kendaraan->id) }}" method="POST"
                                    enctype="multipart/form-data" autocomplete="off">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group" hidden>
                                            <label for="kendaraan_id">Id Kendaraan</label>
                                            <input type="text" class="form-control" id="kendaraan_x3c" readonly
                                                name="kendaraan_id" placeholder="Masukan id kendaraan"
                                                value="{{ $kendaraan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="posisi_ban">Pemasangan Id</label>
                                            <input type="text" class="form-control" readonly name="pemasangan_ban_id"
                                                placeholder="" value="{{ $inquerypemasangan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="posisi_ban">Posisi Ban</label>
                                            <input type="text" class="form-control" readonly name="posisi_3c"
                                                placeholder="Masukan km pemasangan" value="3C">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="exel_1a">No. Seri Ban</label>
                                            <select class="form-control" id="exel_1b" name="exel_3c">
                                                <option value="">- Pilih -</option>
                                                @foreach ($daftarbans as $ban)
                                                    <option value="{{ $ban->id }}"
                                                        {{ old('ban_id') == $ban->id ? 'selected' : '' }}>
                                                        {{ $ban->no_seri }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" id="km_pemasangan"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ old('km_pemasangan') }}">
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button type="reset" class="btn btn-secondary">Reset</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="modal fade" id="modal-exle_3C-{{ $kendaraan->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 3C</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="#" method="POST" enctype="multipart/form-data"
                                    autocomplete="off">
                                    @csrf
                                    <div class="card-body">

                                        <div class="form-group">
                                            {{-- <label class="form-label" for="warna">Ban tidak ada</label> --}}
                                            <h4>Hapus ban terlebih dahulu</h4>
                                            {{-- <p>Tidak ada Ban terpasang di axle 3C</p> --}}
                                        </div>
                                    </div>
                                </form>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- modal exle 3D  --}}
        @if ($bans3d == null)
            <div class="modal fade" id="modal-exle_3D-{{ $kendaraan->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 3D</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="{{ url('admin/inquerypemasangan3d/' . $kendaraan->id) }}" method="POST"
                                    enctype="multipart/form-data" autocomplete="off">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group" hidden>
                                            <label for="kendaraan_id">Id Kendaraan</label>
                                            <input type="text" class="form-control" id="kendaraan_x3d" readonly
                                                name="kendaraan_id" placeholder="Masukan id kendaraan"
                                                value="{{ $kendaraan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="posisi_ban">Pemasangan Id</label>
                                            <input type="text" class="form-control" readonly name="pemasangan_ban_id"
                                                placeholder="" value="{{ $inquerypemasangan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="posisi_ban">Posisi Ban</label>
                                            <input type="text" class="form-control" readonly name="posisi_3d"
                                                placeholder="Masukan km pemasangan" value="3D">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="exel_1a">No. Seri Ban</label>
                                            <select class="form-control" id="exel_1b" name="exel_3d">
                                                <option value="">- Pilih -</option>
                                                @foreach ($daftarbans as $ban)
                                                    <option value="{{ $ban->id }}"
                                                        {{ old('ban_id') == $ban->id ? 'selected' : '' }}>
                                                        {{ $ban->no_seri }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" id="km_pemasangan"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ old('km_pemasangan') }}">
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button type="reset" class="btn btn-secondary">Reset</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="modal fade" id="modal-exle_3D-{{ $kendaraan->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 3D</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="#" method="POST" enctype="multipart/form-data"
                                    autocomplete="off">
                                    @csrf
                                    <div class="card-body">

                                        <div class="form-group">
                                            {{-- <label class="form-label" for="warna">Ban tidak ada</label> --}}
                                            <h4>Hapus ban terlebih dahulu</h4>
                                            {{-- <p>Tidak ada Ban terpasang di axle 3D</p> --}}
                                        </div>
                                    </div>
                                </form>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- modal exle 4A  --}}
        @if ($bans4a == null)
            <div class="modal fade" id="modal-exle_4A-{{ $kendaraan->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 4A</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="{{ url('admin/inquerypemasangan4a/' . $kendaraan->id) }}" method="POST"
                                    enctype="multipart/form-data" autocomplete="off">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group" hidden>
                                            <label for="kendaraan_id">Id Kendaraan</label>
                                            <input type="text" class="form-control" id="kendaraan_x4a" readonly
                                                name="kendaraan_id" placeholder="Masukan id kendaraan"
                                                value="{{ $kendaraan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="posisi_ban">Pemasangan Id</label>
                                            <input type="text" class="form-control" readonly name="pemasangan_ban_id"
                                                placeholder="" value="{{ $inquerypemasangan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="posisi_ban">Posisi Ban</label>
                                            <input type="text" class="form-control" readonly name="posisi_4a"
                                                placeholder="Masukan km pemasangan" value="4A">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="exel_1a">No. Seri Ban</label>
                                            <select class="form-control" id="exel_1b" name="exel_4a">
                                                <option value="">- Pilih -</option>
                                                @foreach ($daftarbans as $ban)
                                                    <option value="{{ $ban->id }}"
                                                        {{ old('ban_id') == $ban->id ? 'selected' : '' }}>
                                                        {{ $ban->no_seri }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" id="km_pemasangan"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ old('km_pemasangan') }}">
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button type="reset" class="btn btn-secondary">Reset</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="modal fade" id="modal-exle_4A-{{ $kendaraan->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 4A</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="#" method="POST" enctype="multipart/form-data"
                                    autocomplete="off">
                                    @csrf
                                    <div class="card-body">

                                        <div class="form-group">
                                            {{-- <label class="form-label" for="warna">Ban tidak ada</label> --}}
                                            <h4>Hapus ban terlebih dahulu</h4>
                                            {{-- <p>Tidak ada Ban terpasang di axle 4A</p> --}}
                                        </div>
                                    </div>
                                </form>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- modal exle 4B  --}}
        @if ($bans4b == null)
            <div class="modal fade" id="modal-exle_4B-{{ $kendaraan->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 4B</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="{{ url('admin/inquerypemasangan4b/' . $kendaraan->id) }}" method="POST"
                                    enctype="multipart/form-data" autocomplete="off">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group" hidden>
                                            <label for="kendaraan_id">Id Kendaraan</label>
                                            <input type="text" class="form-control" id="kendaraan_x4b" readonly
                                                name="kendaraan_id" placeholder="Masukan id kendaraan"
                                                value="{{ $kendaraan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="posisi_ban">Pemasangan Id</label>
                                            <input type="text" class="form-control" readonly name="pemasangan_ban_id"
                                                placeholder="" value="{{ $inquerypemasangan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="posisi_ban">Posisi Ban</label>
                                            <input type="text" class="form-control" readonly name="posisi_4b"
                                                placeholder="Masukan km pemasangan" value="4B">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="exel_1a">No. Seri Ban</label>
                                            <select class="form-control" id="exel_1b" name="exel_4b">
                                                <option value="">- Pilih -</option>
                                                @foreach ($daftarbans as $ban)
                                                    <option value="{{ $ban->id }}"
                                                        {{ old('ban_id') == $ban->id ? 'selected' : '' }}>
                                                        {{ $ban->no_seri }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" id="km_pemasangan"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ old('km_pemasangan') }}">
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button type="reset" class="btn btn-secondary">Reset</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="modal fade" id="modal-exle_4B-{{ $kendaraan->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 4B</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="#" method="POST" enctype="multipart/form-data"
                                    autocomplete="off">
                                    @csrf
                                    <div class="card-body">

                                        <div class="form-group">
                                            {{-- <label class="form-label" for="warna">Ban tidak ada</label> --}}
                                            <h4>Hapus ban terlebih dahulu</h4>
                                            {{-- <p>Tidak ada Ban terpasang di axle 4B</p> --}}
                                        </div>
                                    </div>
                                </form>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- modal exle 4C  --}}
        @if ($bans4c == null)
            <div class="modal fade" id="modal-exle_4C-{{ $kendaraan->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 4C</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="{{ url('admin/inquerypemasangan4c/' . $kendaraan->id) }}" method="POST"
                                    enctype="multipart/form-data" autocomplete="off">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group" hidden>
                                            <label for="kendaraan_id">Id Kendaraan</label>
                                            <input type="text" class="form-control" id="kendaraan_x4c" readonly
                                                name="kendaraan_id" placeholder="Masukan id kendaraan"
                                                value="{{ $kendaraan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="posisi_ban">Pemasangan Id</label>
                                            <input type="text" class="form-control" readonly name="pemasangan_ban_id"
                                                placeholder="" value="{{ $inquerypemasangan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="posisi_ban">Posisi Ban</label>
                                            <input type="text" class="form-control" readonly name="posisi_4c"
                                                placeholder="Masukan km pemasangan" value="4C">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="exel_1a">No. Seri Ban</label>
                                            <select class="form-control" id="exel_1b" name="exel_4c">
                                                <option value="">- Pilih -</option>
                                                @foreach ($daftarbans as $ban)
                                                    <option value="{{ $ban->id }}"
                                                        {{ old('ban_id') == $ban->id ? 'selected' : '' }}>
                                                        {{ $ban->no_seri }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" id="km_pemasangan"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ old('km_pemasangan') }}">
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button type="reset" class="btn btn-secondary">Reset</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="modal fade" id="modal-exle_4C-{{ $kendaraan->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 4C</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="#" method="POST" enctype="multipart/form-data"
                                    autocomplete="off">
                                    @csrf
                                    <div class="card-body">

                                        <div class="form-group">
                                            {{-- <label class="form-label" for="warna">Ban tidak ada</label> --}}
                                            <h4>Hapus ban tidak terlebih dahulu</h4>
                                            {{-- <p>Tidak ada Ban terpasang di axle 4C</p> --}}
                                        </div>
                                    </div>
                                </form>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- modal exle 4D  --}}
        @if ($bans4d == null)
            <div class="modal fade" id="modal-exle_4D-{{ $kendaraan->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 4D</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="{{ url('admin/inquerypemasangan4d/' . $kendaraan->id) }}" method="POST"
                                    enctype="multipart/form-data" autocomplete="off">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group" hidden>
                                            <label for="kendaraan_id">Id Kendaraan</label>
                                            <input type="text" class="form-control" id="kendaraan_x4d" readonly
                                                name="kendaraan_id" placeholder="Masukan id kendaraan"
                                                value="{{ $kendaraan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="posisi_ban">Pemasangan Id</label>
                                            <input type="text" class="form-control" readonly name="pemasangan_ban_id"
                                                placeholder="" value="{{ $inquerypemasangan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="posisi_ban">Posisi Ban</label>
                                            <input type="text" class="form-control" readonly name="posisi_4d"
                                                placeholder="Masukan km pemasangan" value="4D">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="exel_1a">No. Seri Ban</label>
                                            <select class="form-control" id="exel_1b" name="exel_4d">
                                                <option value="">- Pilih -</option>
                                                @foreach ($daftarbans as $ban)
                                                    <option value="{{ $ban->id }}"
                                                        {{ old('ban_id') == $ban->id ? 'selected' : '' }}>
                                                        {{ $ban->no_seri }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" id="km_pemasangan"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ old('km_pemasangan') }}">
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button type="reset" class="btn btn-secondary">Reset</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="modal fade" id="modal-exle_4D-{{ $kendaraan->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 4D</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="#" method="POST" enctype="multipart/form-data"
                                    autocomplete="off">
                                    @csrf
                                    <div class="card-body">

                                        <div class="form-group">
                                            {{-- <label class="form-label" for="warna">Ban tidak ada</label> --}}
                                            <h4>Hapus ban terlebih dahulu</h4>
                                            {{-- <p>Tidak ada Ban terpasang di axle 4D</p> --}}
                                        </div>
                                    </div>
                                </form>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- modal exle 5A  --}}
        @if ($bans5a == null)
            <div class="modal fade" id="modal-exle_5A-{{ $kendaraan->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 5A</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="{{ url('admin/inquerypemasangan5a/' . $kendaraan->id) }}" method="POST"
                                    enctype="multipart/form-data" autocomplete="off">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group" hidden>
                                            <label for="kendaraan_id">Id Kendaraan</label>
                                            <input type="text" class="form-control" id="kendaraan_x5a" readonly
                                                name="kendaraan_id" placeholder="Masukan id kendaraan"
                                                value="{{ $kendaraan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="posisi_ban">Pemasangan Id</label>
                                            <input type="text" class="form-control" readonly name="pemasangan_ban_id"
                                                placeholder="" value="{{ $inquerypemasangan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="posisi_ban">Posisi Ban</label>
                                            <input type="text" class="form-control" readonly name="posisi_5a"
                                                placeholder="Masukan km pemasangan" value="5A">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="exel_1a">No. Seri Ban</label>
                                            <select class="form-control" id="exel_1b" name="exel_5a">
                                                <option value="">- Pilih -</option>
                                                @foreach ($daftarbans as $ban)
                                                    <option value="{{ $ban->id }}"
                                                        {{ old('ban_id') == $ban->id ? 'selected' : '' }}>
                                                        {{ $ban->no_seri }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" id="km_pemasangan"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ old('km_pemasangan') }}">
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button type="reset" class="btn btn-secondary">Reset</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="modal fade" id="modal-exle_5A-{{ $kendaraan->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 5A</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="#" method="POST" enctype="multipart/form-data"
                                    autocomplete="off">
                                    @csrf
                                    <div class="card-body">

                                        <div class="form-group">
                                            {{-- <label class="form-label" for="warna">Ban tidak ada</label> --}}
                                            <h4>Hapus ban terlebih dahulu</h4>
                                            {{-- <p>Tidak ada Ban terpasang di axle 5A</p> --}}
                                        </div>
                                    </div>
                                </form>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- modal exle 5B  --}}
        @if ($bans5b == null)
            <div class="modal fade" id="modal-exle_5B-{{ $kendaraan->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 5B</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="{{ url('admin/inquerypemasangan5b/' . $kendaraan->id) }}" method="POST"
                                    enctype="multipart/form-data" autocomplete="off">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group" hidden>
                                            <label for="kendaraan_id">Id Kendaraan</label>
                                            <input type="text" class="form-control" id="kendaraan_x5b" readonly
                                                name="kendaraan_id" placeholder="Masukan id kendaraan"
                                                value="{{ $kendaraan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="posisi_ban">Pemasangan Id</label>
                                            <input type="text" class="form-control" readonly name="pemasangan_ban_id"
                                                placeholder="" value="{{ $inquerypemasangan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="posisi_ban">Posisi Ban</label>
                                            <input type="text" class="form-control" readonly name="posisi_5b"
                                                placeholder="Masukan km pemasangan" value="5B">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="exel_1a">No. Seri Ban</label>
                                            <select class="form-control" id="exel_1b" name="exel_5b">
                                                <option value="">- Pilih -</option>
                                                @foreach ($daftarbans as $ban)
                                                    <option value="{{ $ban->id }}"
                                                        {{ old('ban_id') == $ban->id ? 'selected' : '' }}>
                                                        {{ $ban->no_seri }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" id="km_pemasangan"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ old('km_pemasangan') }}">
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button type="reset" class="btn btn-secondary">Reset</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="modal fade" id="modal-exle_5B-{{ $kendaraan->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 5B</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="#" method="POST" enctype="multipart/form-data"
                                    autocomplete="off">
                                    @csrf
                                    <div class="card-body">

                                        <div class="form-group">
                                            {{-- <label class="form-label" for="warna">Ban tidak ada</label> --}}
                                            <h4>Hapus ban terlebih dahulu</h4>
                                            {{-- <p>Tidak ada Ban terpasang di axle 5B</p> --}}
                                        </div>
                                    </div>
                                </form>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- modal exle 5C  --}}
        @if ($bans5c == null)
            <div class="modal fade" id="modal-exle_5C-{{ $kendaraan->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 5C</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="{{ url('admin/inquerypemasangan5c/' . $kendaraan->id) }}" method="POST"
                                    enctype="multipart/form-data" autocomplete="off">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group" hidden>
                                            <label for="kendaraan_id">Id Kendaraan</label>
                                            <input type="text" class="form-control" id="kendaraan_x5c" readonly
                                                name="kendaraan_id" placeholder="Masukan id kendaraan"
                                                value="{{ $kendaraan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="posisi_ban">Pemasangan Id</label>
                                            <input type="text" class="form-control" readonly name="pemasangan_ban_id"
                                                placeholder="" value="{{ $inquerypemasangan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="posisi_ban">Posisi Ban</label>
                                            <input type="text" class="form-control" readonly name="posisi_5c"
                                                placeholder="Masukan km pemasangan" value="5C">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="exel_1a">No. Seri Ban</label>
                                            <select class="form-control" id="exel_1b" name="exel_5c">
                                                <option value="">- Pilih -</option>
                                                @foreach ($daftarbans as $ban)
                                                    <option value="{{ $ban->id }}"
                                                        {{ old('ban_id') == $ban->id ? 'selected' : '' }}>
                                                        {{ $ban->no_seri }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" id="km_pemasangan"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ old('km_pemasangan') }}">
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button type="reset" class="btn btn-secondary">Reset</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="modal fade" id="modal-exle_5C-{{ $kendaraan->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 5C</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="#" method="POST" enctype="multipart/form-data"
                                    autocomplete="off">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group">
                                            {{-- <label class="form-label" for="warna">Ban tidak ada</label> --}}
                                            <h4>Hapus ban terlebih dahulu</h4>
                                            {{-- <p>Tidak ada Ban terpasang di axle 5C</p> --}}
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- modal exle 5D  --}}
        @if ($bans5d == null)
            <div class="modal fade" id="modal-exle_5D-{{ $kendaraan->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 5D</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="{{ url('admin/inquerypemasangan5d/' . $kendaraan->id) }}" method="POST"
                                    enctype="multipart/form-data" autocomplete="off">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group" hidden>
                                            <label for="kendaraan_id">Id Kendaraan</label>
                                            <input type="text" class="form-control" id="kendaraan_x5d" readonly
                                                name="kendaraan_id" placeholder="Masukan id kendaraan"
                                                value="{{ $kendaraan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="posisi_ban">Pemasangan Id</label>
                                            <input type="text" class="form-control" readonly name="pemasangan_ban_id"
                                                placeholder="" value="{{ $inquerypemasangan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="posisi_ban">Posisi Ban</label>
                                            <input type="text" class="form-control" readonly name="posisi_5d"
                                                placeholder="Masukan km pemasangan" value="5D">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="exel_1a">No. Seri Ban</label>
                                            <select class="form-control" id="exel_1b" name="exel_5d">
                                                <option value="">- Pilih -</option>
                                                @foreach ($daftarbans as $ban)
                                                    <option value="{{ $ban->id }}"
                                                        {{ old('ban_id') == $ban->id ? 'selected' : '' }}>
                                                        {{ $ban->no_seri }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" id="km_pemasangan"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ old('km_pemasangan') }}">
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button type="reset" class="btn btn-secondary">Reset</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="modal fade" id="modal-exle_5D-{{ $kendaraan->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 5D</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="#" method="POST" enctype="multipart/form-data"
                                    autocomplete="off">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group">
                                            {{-- <label class="form-label" for="warna">Ban tidak ada</label> --}}
                                            <h4>Hapus ban terlebih dahulu</h4>
                                            {{-- <p>Tidak ada Ban terpasang di axle 5D</p> --}}
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- modal exle 6A  --}}
        @if ($bans6a == null)
            <div class="modal fade" id="modal-exle_6A-{{ $kendaraan->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 6A</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="{{ url('admin/inquerypemasangan6a/' . $kendaraan->id) }}" method="POST"
                                    enctype="multipart/form-data" autocomplete="off">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group" hidden>
                                            <label for="kendaraan_id">Id Kendaraan</label>
                                            <input type="text" class="form-control" id="kendaraan_x6a" readonly
                                                name="kendaraan_id" placeholder="Masukan id kendaraan"
                                                value="{{ $kendaraan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="posisi_ban">Pemasangan Id</label>
                                            <input type="text" class="form-control" readonly name="pemasangan_ban_id"
                                                placeholder="" value="{{ $inquerypemasangan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="posisi_ban">Posisi Ban</label>
                                            <input type="text" class="form-control" readonly name="posisi_6a"
                                                placeholder="Masukan km pemasangan" value="6A">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="exel_1a">No. Seri Ban</label>
                                            <select class="form-control" id="exel_1b" name="exel_6a">
                                                <option value="">- Pilih -</option>
                                                @foreach ($daftarbans as $ban)
                                                    <option value="{{ $ban->id }}"
                                                        {{ old('ban_id') == $ban->id ? 'selected' : '' }}>
                                                        {{ $ban->no_seri }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" id="km_pemasangan"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ old('km_pemasangan') }}">
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button type="reset" class="btn btn-secondary">Reset</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="modal fade" id="modal-exle_6A-{{ $kendaraan->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 6A</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="#" method="POST" enctype="multipart/form-data"
                                    autocomplete="off">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group">
                                            {{-- <label class="form-label" for="warna">Ban tidak ada</label> --}}
                                            <h4>Hapus ban terlebih dahulu</h4>
                                            {{-- <p>Tidak ada Ban terpasang di axle 6A</p> --}}
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- modal exle 6B  --}}
        @if ($bans6b == null)
            <div class="modal fade" id="modal-exle_6B-{{ $kendaraan->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 6B</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="{{ url('admin/inquerypemasangan6b/' . $kendaraan->id) }}" method="POST"
                                    enctype="multipart/form-data" autocomplete="off">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group" hidden>
                                            <label for="kendaraan_id">Id Kendaraan</label>
                                            <input type="text" class="form-control" id="kendaraan_x6b" readonly
                                                name="kendaraan_id" placeholder="Masukan id kendaraan"
                                                value="{{ $kendaraan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="posisi_ban">Pemasangan Id</label>
                                            <input type="text" class="form-control" readonly name="pemasangan_ban_id"
                                                placeholder="" value="{{ $inquerypemasangan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="posisi_ban">Posisi Ban</label>
                                            <input type="text" class="form-control" readonly name="posisi_6b"
                                                placeholder="Masukan km pemasangan" value="6B">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="exel_1a">No. Seri Ban</label>
                                            <select class="form-control" id="exel_1b" name="exel_6b">
                                                <option value="">- Pilih -</option>
                                                @foreach ($daftarbans as $ban)
                                                    <option value="{{ $ban->id }}"
                                                        {{ old('ban_id') == $ban->id ? 'selected' : '' }}>
                                                        {{ $ban->no_seri }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" id="km_pemasangan"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ old('km_pemasangan') }}">
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button type="reset" class="btn btn-secondary">Reset</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="modal fade" id="modal-exle_6B-{{ $kendaraan->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 6B</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="#" method="POST" enctype="multipart/form-data"
                                    autocomplete="off">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group">
                                            {{-- <label class="form-label" for="warna">Ban tidak ada</label> --}}
                                            <h4>Hapus ban terlebih dahulu</h4>
                                            {{-- <p>Tidak ada Ban terpasang di axle 6B</p> --}}
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- modal exle 6C  --}}
        @if ($bans6c == null)
            <div class="modal fade" id="modal-exle_6C-{{ $kendaraan->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 6C</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="{{ url('admin/inquerypemasangan6c/' . $kendaraan->id) }}" method="POST"
                                    enctype="multipart/form-data" autocomplete="off">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group" hidden>
                                            <label for="kendaraan_id">Id Kendaraan</label>
                                            <input type="text" class="form-control" id="kendaraan_x6c" readonly
                                                name="kendaraan_id" placeholder="Masukan id kendaraan"
                                                value="{{ $kendaraan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="posisi_ban">Pemasangan Id</label>
                                            <input type="text" class="form-control" readonly name="pemasangan_ban_id"
                                                placeholder="" value="{{ $inquerypemasangan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="posisi_ban">Posisi Ban</label>
                                            <input type="text" class="form-control" readonly name="posisi_6c"
                                                placeholder="Masukan km pemasangan" value="6C">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="exel_1a">No. Seri Ban</label>
                                            <select class="form-control" id="exel_1b" name="exel_6c">
                                                <option value="">- Pilih -</option>
                                                @foreach ($daftarbans as $ban)
                                                    <option value="{{ $ban->id }}"
                                                        {{ old('ban_id') == $ban->id ? 'selected' : '' }}>
                                                        {{ $ban->no_seri }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" id="km_pemasangan"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ old('km_pemasangan') }}">
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button type="reset" class="btn btn-secondary">Reset</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="modal fade" id="modal-exle_6C-{{ $kendaraan->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 6C</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="#" method="POST" enctype="multipart/form-data"
                                    autocomplete="off">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group">
                                            {{-- <label class="form-label" for="warna">Ban tidak ada</label> --}}
                                            <h4>Hapus ban terlebih dahulu</h4>
                                            <p>Tidak ada Ban terpasang di axle 6C</p>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- modal exle 6D  --}}
        @if ($bans6d == null)
            <div class="modal fade" id="modal-exle_6D-{{ $kendaraan->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 6D</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="{{ url('admin/inquerypemasangan6d/' . $kendaraan->id) }}" method="POST"
                                    enctype="multipart/form-data" autocomplete="off">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group" hidden>
                                            <label for="kendaraan_id">Id Kendaraan</label>
                                            <input type="text" class="form-control" id="kendaraan_x6d" readonly
                                                name="kendaraan_id" placeholder="Masukan id kendaraan"
                                                value="{{ $kendaraan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="posisi_ban">Pemasangan Id</label>
                                            <input type="text" class="form-control" readonly name="pemasangan_ban_id"
                                                placeholder="" value="{{ $inquerypemasangan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="posisi_ban">Posisi Ban</label>
                                            <input type="text" class="form-control" readonly name="posisi_6d"
                                                placeholder="Masukan km pemasangan" value="6D">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="exel_1a">No. Seri Ban</label>
                                            <select class="form-control" id="exel_1b" name="exel_6d">
                                                <option value="">- Pilih -</option>
                                                @foreach ($daftarbans as $ban)
                                                    <option value="{{ $ban->id }}"
                                                        {{ old('ban_id') == $ban->id ? 'selected' : '' }}>
                                                        {{ $ban->no_seri }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" id="km_pemasangan"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ old('km_pemasangan') }}">
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button type="reset" class="btn btn-secondary">Reset</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="modal fade" id="modal-exle_6D-{{ $kendaraan->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 6D</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="#" method="POST" enctype="multipart/form-data"
                                    autocomplete="off">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group">
                                            {{-- <label class="form-label" for="warna">Ban tidak ada</label> --}}
                                            <h4>Hapus ban terlebih dahulu</h4>
                                            {{-- <p>Tidak ada Ban terpasang di axle 6D</p> --}}
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </section>

    <script>
        function getData() {
            var jenis_kendaraan = document.getElementById('jenis_kendaraan');
            var jumlah_ban = document.getElementById('jumlah_ban');
            var layout_tronton = document.getElementById('layout_tronton');
            var layout_trailer_engkel = document.getElementById('layout_trailer_engkel');
            var layout_trailer_tronton = document.getElementById('layout_trailer_tronton');

            // Mendapatkan value terpilih dari jenis_kendaraan
            var selectedValue = jumlah_ban.value;

            // Menyembunyikan semua layout terlebih dahulu
            layout_tronton.style.display = 'none';
            layout_trailer_engkel.style.display = 'none';
            layout_trailer_tronton.style.display = 'none';

            // Memeriksa value terpilih dan menampilkan layout yang sesuai
            if (selectedValue === '6') {
                // Tidak ada layout yang perlu ditampilkan karena ENGKEL dipilih
            } else if (selectedValue === '10') {
                layout_tronton.style.display = 'inline';
                layout_trailer_engkel.style.display = 'none';
                layout_trailer_tronton.style.display = 'none';
            } else if (selectedValue === '18') {
                layout_tronton.style.display = 'inline';
                layout_trailer_engkel.style.display = 'inline';
            } else if (selectedValue === '22') {
                layout_tronton.style.display = 'inline';
                layout_trailer_engkel.style.display = 'inline';
                layout_trailer_tronton.style.display = 'inline';
            } else {
                // Jika value yang terpilih tidak sesuai dengan opsi yang diizinkan,
                // maka lakukan sesuatu (misalnya menampilkan pesan kesalahan atau mengatur default layout)
            }
        }

        getData()

        // Panggil fungsi getData() saat halaman selesai dimuat
        window.addEventListener('load', function() {
            getData();
        });

        // Validasi form sebelum submit
        document.getElementById('submitBtn').addEventListener('click', function() {
            var selectValue = document.getElementById('exel_1b').value;
            var kmPemasangan = document.getElementById('km_pemasangan1').value;

            if (selectValue === '' || kmPemasangan === '') {
                alert('Harap lengkapi semua kolom sebelum menyimpan data.');
                return;
            }

            // Jika form sudah lengkap terisi, submit form
            document.getElementById('exleForm').submit();
        });
    </script>
@endsection
