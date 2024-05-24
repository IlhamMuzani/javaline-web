@extends('layouts.app')

@section('title', 'Inquery Pelepasan')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Pelepasan Ban</h1>
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
            @if (session('errormax'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-check"></i> Error!
                    </h5>
                    {{ session('errormax') }}
                </div>
            @endif
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
            <form action="{{ url('admin/inquery_pelepasanban/' . $inquerypelepasan->id) }}" method="POST"
                enctype="multipart/form-data" autocomplete="off">
                @csrf
                @method('put')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Pelepasan Ban</h3>
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
                                                @if ($bans == null)
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/merah.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @else
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/hijau.png') }}"
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
                                                @if ($bansb == null)
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/merah.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @else
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/hijau.png') }}"
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
                                                @if ($bans2a == null)
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/merah.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @else
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/hijau.png') }}"
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
                                                @if ($bans2b == null)
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/merah.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @else
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/hijau.png') }}"
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
                                                @if ($bans2c == null)
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/merah.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @else
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/hijau.png') }}"
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
                                                @if ($bans2d == null)
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/merah.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @else
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/hijau.png') }}"
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
                                                @if ($bans3a == null)
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/merah.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @else
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/hijau.png') }}"
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
                                                @if ($bans3b == null)
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/merah.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @else
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/hijau.png') }}"
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
                                                @if ($bans3c == null)
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/merah.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @else
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/hijau.png') }}"
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
                                                @if ($bans3d == null)
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/merah.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @else
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/hijau.png') }}"
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
                                                @if ($bans4a == null)
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/merah.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @else
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/hijau.png') }}"
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
                                                @if ($bans4b == null)
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/merah.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @else
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/hijau.png') }}"
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
                                                @if ($bans4c == null)
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/merah.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @else
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/hijau.png') }}"
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
                                                @if ($bans4d == null)
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/merah.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @else
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/hijau.png') }}"
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
                                                @if ($bans5a == null)
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/merah.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @else
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/hijau.png') }}"
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
                                                @if ($bans5b == null)
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/merah.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @else
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/hijau.png') }}"
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
                                                @if ($bans5c == null)
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/merah.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @else
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/hijau.png') }}"
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
                                                @if ($bans5d == null)
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/merah.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @else
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/hijau.png') }}"
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
                                                @if ($bans6a == null)
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/merah.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @else
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/hijau.png') }}"
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
                                                @if ($bans6b == null)
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/merah.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @else
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/hijau.png') }}"
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
                                                @if ($bans6c == null)
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/merah.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @else
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/hijau.png') }}"
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
                                                @if ($bans6d == null)
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/merah.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @else
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/indikator/hijau.png') }}"
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
                                                <p>Yakin hapus pelepasan ban?
                                                    <strong>{{ $ban->no_seri }}</strong>?
                                                </p>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Batal</button>
                                                <form action="{{ url('admin/inquery_pelepasanban/' . $ban->id) }}"
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
        @if ($banspas != null)
            <div class="modal fade" id="modal-exle_1A-{{ $kendaraan->id }}">
                <div class="modal-dialog" style="max-width: 90%;"> <!-- Atur lebar maksimum modal di sini -->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 1A</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="{{ url('admin/inquerypelepasan1/' . $kendaraan->id) }}" method="POST"
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
                                            <label for="posisi_ban">Pelepasan Id</label>
                                            <input type="text" class="form-control" readonly name="pelepasan_ban_id"
                                                placeholder="" value="{{ $inquerypelepasan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="km_pemasangan">Ban Id</label>
                                            <input type="text" class="form-control" id="" name="id_ban"
                                                placeholder="" value="{{ $banspas->id }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Kode Ban</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="kode_ban" placeholder="" value="{{ $banspas->kode_ban }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">No. Seri</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="seri_ban" placeholder="" value="{{ $banspas->no_seri }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" readonly id="km_pemasangan1"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ $banspas->km_pemasangan }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pelepasan</label>
                                            <input type="text" class="form-control" id="km_pelepasan1"
                                                name="km_pelepasan" placeholder="Masukan km pelepasan"
                                                value="{{ old('km_pelepasan') }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="keterangan">Keterangan</label>
                                            <select class="form-control" id="keterangan" name="keterangan">
                                                <option value="">- Pilih -</option>
                                                <option value="Habis"
                                                    {{ old('keterangan') == 'Habis' ? 'selected' : null }}>
                                                    Habis</option>
                                                <option value="Pecah"
                                                    {{ old('keterangan') == 'Pecah' ? 'selected' : null }}>
                                                    Pecah Non Klaim</option>
                                                <option value="Pecah Klaim"
                                                    {{ old('keterangan') == 'Pecah Klaim' ? 'selected' : null }}>
                                                    Pecah Klaim</option>
                                                <option value="Stok"
                                                    {{ old('keterangan') == 'Stok' ? 'selected' : null }}>
                                                    Stok</option>
                                            </select>
                                        </div>
                                        <div class="form-group" id="perhitungan_klaim">
                                            <div class="form-group">
                                                <label for="km_pemasangan">Harga Ban</label>
                                                <input type="text" class="form-control" id="harga" readonly
                                                    name="harga" placeholder=""
                                                    value="{{ number_format($banspas->harga, 0, ',', '.') }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="km_pemasangan">Target Km</label>
                                                <input type="text" class="form-control" id="" readonly
                                                    name="target_km_ban" placeholder=""
                                                    value="{{ $banspas->target_km_ban }}">
                                            </div>
                                            <div class="form-group" hidden>
                                                <label for="km_pemasangan">KM target</label>
                                                <input type="text" class="form-control" id="km_target" readonly
                                                    name="km_target" placeholder=""
                                                    value="{{ $banspas->target_km_ban - $banspas->km_pemasangan }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="km_terpakai">KM Terpakai</label>
                                                <input type="text" class="form-control" id="km_terpakai" readonly
                                                    name="km_terpakai" value="{{ $banspas->km_terpakai }}"
                                                    placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="sisa_harga">Harga Klaim</label>
                                                <input type="text" class="form-control" id="sisa_harga" readonly
                                                    name="sisa_harga" placeholder=""
                                                    value="{{ number_format($banspas->sisa_harga, 0, ',', '.') }}">
                                            </div>
                                            <div id="pengambilan">
                                                <div class="card-header mb-3">
                                                    <h3 class="card-title">Pengambilan Deposit Sopir</h3>
                                                </div>
                                                <div>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <label for="sisa_saldo">Kode Sopir</label>
                                                            <div class="form-group d-flex">
                                                                <input readonly type="text" hidden class="form-control"
                                                                    id="karyawan_id" name="karyawan_id" placeholder=""
                                                                    value="{{ old('karyawan_id') }}">
                                                                <input onclick="showSopir(this.value)"
                                                                    class="form-control" id="kode_karyawan"
                                                                    name="kode_karyawan" type="text" placeholder=""
                                                                    value="{{ old('kode_karyawan') }}" readonly
                                                                    style="margin-right: 10px; font-size:14px" />
                                                                <button class="btn btn-primary" type="button"
                                                                    onclick="showSopir(this.value)">
                                                                    <i class="fas fa-search"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="sisa_saldo">Sisa Saldo</label>
                                                                <input style="text-align: end;margin:right:10px"
                                                                    type="text" class="form-control" id="sisa_saldo"
                                                                    readonly name="sisa_saldo"
                                                                    value="{{ old('sisa_saldo') }}" placeholder="">

                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="nama_lengkap">Nama Sopir</label>
                                                                <input readonly type="text" class="form-control"
                                                                    id="nama_lengkap" name="nama_lengkap" placeholder=""
                                                                    value="{{ old('nama_lengkap') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="saldo_masuk">Potongan Saldo</label>
                                                                <input style="text-align: end" type="text"
                                                                    class="form-control" readonly id="saldo_keluar"
                                                                    name="saldo_keluar" placeholder=""
                                                                    value="{{ old('saldo_keluar') }}">
                                                            </div>
                                                            <hr
                                                                style="border: 2px solid black; display: inline-block; width: 97%; vertical-align: middle;">
                                                            <span
                                                                style="display: inline-block; margin-left: 0px; margin-right: 0; font-size: 18px; vertical-align: middle;">-</span>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="alamat">Keterangan</label>
                                                                <textarea type="text" class="form-control" id="keterangans" name="keterangans" placeholder="Masukan keterangan">{{ old('keterangans') }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="sub_total">Sub Total</label>
                                                                <input style="text-align: end; margin:right:10px"
                                                                    type="text" class="form-control" readonly
                                                                    id="sub_totals" name="sub_totals" placeholder=""
                                                                    value="{{ old('sub_totals') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <script>
                                            $(document).ready(function() {
                                                // Definisikan fungsi perhitungan
                                                function hitung() {
                                                    var km_pemasangan = parseInt($('#km_pemasangan1').val());
                                                    var km_pelepasan = parseInt($('#km_pelepasan1').val());
                                                    var km_terpakai = km_pelepasan - km_pemasangan;
                                                    $('#km_terpakai').val(km_terpakai);
                                                    var km_target = parseFloat($('#km_target').val());
                                                    var hargaString = $('#harga').val().replaceAll('.', '');
                                                    var harga = parseFloat(hargaString);
                                                    console.log(harga);
                                                    var hasil_persen = km_terpakai / km_target * 100;
                                                    var hasil_harga = harga * hasil_persen / 100;
                                                    // Memperoleh hasil harga yang dibulatkan
                                                    var hasil_harga_bulat = Math.round(hasil_harga);
                                                    var sisa_harga = harga - hasil_harga_bulat;
                                                    var hasil_harga_formatted = sisa_harga.toLocaleString('id-ID');
                                                    $('#sisa_harga').val(hasil_harga_formatted);
                                                    $('#saldo_keluar').val(hasil_harga_formatted);

                                                    // Hitung selisih antara sisa_saldo dan saldo_keluar
                                                    var sisa_saldo = parseFloat($('#sisa_saldo').val().replace(/\D/g, ''));
                                                    var saldo_keluar = parseFloat($('#saldo_keluar').val().replace(/\D/g, ''));
                                                    var sub_totals = sisa_saldo - saldo_keluar;
                                                    var formattedSubTotals = sub_totals.toLocaleString('id-ID');
                                                    $('#sub_totals').val(formattedSubTotals);
                                                }
                                                // Panggil fungsi perhitungan saat dokumen siap
                                                hitung();
                                                // Panggil fungsi perhitungan saat input berubah
                                                $('#km_pelepasan1').on('input', function() {
                                                    hitung();
                                                });
                                            });
                                        </script>

                                        <script>
                                            function toggleLabels() {
                                                var keterangan = document.getElementById('keterangan');
                                                var perhitungan_klaim = document.getElementById('perhitungan_klaim');

                                                if (keterangan.value === 'Pecah Klaim') {
                                                    perhitungan_klaim.style.display = 'block';
                                                } else {
                                                    perhitungan_klaim.style.display = 'none';
                                                }
                                            }

                                            toggleLabels();
                                            document.getElementById('keterangan').addEventListener('change', toggleLabels);
                                        </script>

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
                                            <h4>Ban tidak ada !!</h4>
                                            <p>Tidak ada Ban terpasang di axle 1A</p>
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
        @if ($banspasb != null)
            <div class="modal fade" id="modal-exle_1B-{{ $kendaraan->id }}">
                <div class="modal-dialog" style="max-width: 90%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 1B</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="{{ url('admin/inquerypelepasan1/' . $kendaraan->id) }}" method="POST"
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
                                            <label for="posisi_ban">Pelepasan Id</label>
                                            <input type="text" class="form-control" readonly name="pelepasan_ban_id"
                                                placeholder="" value="{{ $inquerypelepasan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="km_pemasangan">Ban Id</label>
                                            <input type="text" class="form-control" id="" name="id_ban"
                                                placeholder="" value="{{ $banspasb->id }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Kode Ban</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="kode_ban" placeholder="" value="{{ $banspasb->kode_ban }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">No. Seri</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="seri_ban" placeholder="" value="{{ $banspasb->no_seri }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" readonly id="km_pemasangan1b"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ $banspasb->km_pemasangan }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pelepasan</label>
                                            <input type="text" class="form-control" id="km_pelepasan1b"
                                                name="km_pelepasan" placeholder="Masukan km pelepasan"
                                                value="{{ old('km_pelepasan') }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="keterangan1b">Keterangan</label>
                                            <select class="form-control" id="keterangan1b" name="keterangan">
                                                <option value="">- Pilih -</option>
                                                <option value="Habis"
                                                    {{ old('keterangan') == 'Habis' ? 'selected' : null }}>
                                                    Habis</option>
                                                <option value="Pecah"
                                                    {{ old('keterangan') == 'Pecah' ? 'selected' : null }}>
                                                    Pecah Non Klaim</option>
                                                <option value="Pecah Klaim"
                                                    {{ old('keterangan') == 'Pecah Klaim' ? 'selected' : null }}>
                                                    Pecah Klaim</option>
                                                <option value="Stok"
                                                    {{ old('keterangan') == 'Stok' ? 'selected' : null }}>
                                                    Stok</option>
                                            </select>
                                        </div>
                                        <div class="form-group" id="perhitungan_klaim1b">
                                            <div class="form-group">
                                                <label for="km_pemasangan">Harga Ban</label>
                                                <input type="text" class="form-control" id="harga1b" readonly
                                                    name="harga" placeholder=""
                                                    value="{{ number_format($banspasb->harga, 0, ',', '.') }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="km_pemasangan">Target Km</label>
                                                <input type="text" class="form-control" id="" readonly
                                                    name="target_km_ban" placeholder="" value="{{ $banspasb->target_km_ban }}">
                                            </div>

                                            <div class="form-group" hidden>
                                                <label for="km_pemasangan">KM target</label>
                                                <input type="text" class="form-control" id="km_target1b" readonly
                                                    name="km_target" placeholder=""
                                                    value="{{ $banspasb->target_km_ban - $banspasb->km_pemasangan }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="km_terpakai">KM Terpakai</label>
                                                <input type="text" class="form-control" id="km_terpakai1b" readonly
                                                    name="km_terpakai" value="{{ $banspasb->km_terpakai }}" placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="sisa_harga">Harga Klaim</label>
                                                <input type="text" class="form-control" id="sisa_harga1b" readonly
                                                    name="sisa_harga" placeholder=""
                                                    value="{{ number_format($banspasb->sisa_harga, 0, ',', '.') }}">
                                            </div>
                                            <div id="pengambilan">
                                                <div class="card-header mb-3">
                                                    <h3 class="card-title">Pengambilan Deposit Sopir</h3>
                                                </div>
                                                <div>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <label for="sisa_saldo">Kode Sopir</label>
                                                            <div class="form-group d-flex">
                                                                <input readonly type="text" hidden class="form-control"
                                                                    id="karyawan_id1b" name="karyawan_id" placeholder=""
                                                                    value="{{ old('karyawan_id') }}">
                                                                <input onclick="showSopir1b(this.value)"
                                                                    class="form-control" id="kode_karyawan1b"
                                                                    name="kode_karyawan" type="text" placeholder=""
                                                                    value="{{ old('kode_karyawan') }}" readonly
                                                                    style="margin-right: 10px; font-size:14px" />
                                                                <button class="btn btn-primary" type="button"
                                                                    onclick="showSopir1b(this.value)">
                                                                    <i class="fas fa-search"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="sisa_saldo">Sisa Saldo</label>
                                                                <input style="text-align: end;margin:right:10px"
                                                                    type="text" class="form-control" id="sisa_saldo1b"
                                                                    readonly name="sisa_saldo"
                                                                    value="{{ old('sisa_saldo') }}" placeholder="">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="nama_lengkap">Nama Sopir</label>
                                                                <input readonly type="text" class="form-control"
                                                                    id="nama_lengkap1b" name="nama_lengkap"
                                                                    placeholder="" value="{{ old('nama_lengkap') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="saldo_masuk">Potongan Saldo</label>
                                                                <input style="text-align: end" type="text"
                                                                    class="form-control" readonly id="saldo_keluar1b"
                                                                    name="saldo_keluar" placeholder=""
                                                                    value="{{ old('saldo_keluar') }}">
                                                            </div>
                                                            <hr
                                                                style="border: 2px solid black; display: inline-block; width: 97%; vertical-align: middle;">
                                                            <span
                                                                style="display: inline-block; margin-left: 0px; margin-right: 0; font-size: 18px; vertical-align: middle;">-</span>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="alamat">Keterangan</label>
                                                                <textarea type="text" class="form-control" id="keterangans" name="keterangans"
                                                                    placeholder="Masukan keterangan">{{ old('keterangans') }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="sub_total">Sub Total</label>
                                                                <input style="text-align: end; margin:right:10px"
                                                                    type="text" class="form-control" readonly
                                                                    id="sub_totals1b" name="sub_totals" placeholder=""
                                                                    value="{{ old('sub_totals') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <script>
                                            $(document).ready(function() {
                                                // Definisikan fungsi perhitungan
                                                function hitung1b() {
                                                    var km_pemasangan = parseInt($('#km_pemasangan1b').val());
                                                    var km_pelepasan = parseInt($('#km_pelepasan1b').val());
                                                    var km_terpakai = km_pelepasan - km_pemasangan;
                                                    $('#km_terpakai1b').val(km_terpakai);
                                                    var km_target = parseFloat($('#km_target1b').val());
                                                    var hargaString = $('#harga1b').val().replaceAll('.', '');
                                                    var harga = parseFloat(hargaString);
                                                    console.log(harga);
                                                    var hasil_persen = km_terpakai / km_target * 100;
                                                    var hasil_harga = harga * hasil_persen / 100;
                                                    // Memperoleh hasil harga yang dibulatkan
                                                    var hasil_harga_bulat = Math.round(hasil_harga);
                                                    var sisa_harga = harga - hasil_harga_bulat;
                                                    var hasil_harga_formatted = sisa_harga.toLocaleString('id-ID');
                                                    $('#sisa_harga1b').val(hasil_harga_formatted);
                                                    $('#saldo_keluar1b').val(hasil_harga_formatted);
                                                    // Hitung selisih antara sisa_saldo dan saldo_keluar
                                                    var sisa_saldo = parseFloat($('#sisa_saldo1b').val().replace(/\D/g, ''));
                                                    var saldo_keluar = parseFloat($('#saldo_keluar1b').val().replace(/\D/g, ''));
                                                    var sub_totals = sisa_saldo - saldo_keluar;
                                                    var formattedSubTotals = sub_totals.toLocaleString('id-ID');
                                                    $('#sub_totals1b').val(formattedSubTotals);
                                                }
                                                // Panggil fungsi perhitungan saat dokumen siap
                                                hitung1b();
                                                // Panggil fungsi perhitungan saat input berubah
                                                $('#km_pelepasan1b').on('input', function() {
                                                    hitung1b();
                                                });
                                            });
                                        </script>
                                        <script>
                                            function toggleLabels2() {
                                                var keterangan = document.getElementById('keterangan1b');
                                                var perhitungan_klaim = document.getElementById('perhitungan_klaim1b');
                                                if (keterangan.value === 'Pecah Klaim') {
                                                    perhitungan_klaim.style.display = 'block';
                                                } else {
                                                    perhitungan_klaim.style.display = 'none';
                                                }
                                            }
                                            toggleLabels2();
                                            document.getElementById('keterangan1b').addEventListener('change', toggleLabels2);
                                        </script>
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
                                            {{-- <label class="form-label" for="warna">Ban tidak ada</label> --}}
                                            <h4>Ban tidak ada !!</h4>
                                            <p>Tidak ada Ban terpasang di axle 1B</p>
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
        @if ($banspas2a != null)
            <div class="modal fade" id="modal-exle_2A-{{ $kendaraan->id }}">
                <div class="modal-dialog" style="max-width: 90%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 2A</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="{{ url('admin/inquerypelepasan1/' . $kendaraan->id) }}" method="POST"
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
                                            <label for="posisi_ban">Pelepasan Id</label>
                                            <input type="text" class="form-control" readonly name="pelepasan_ban_id"
                                                placeholder="" value="{{ $inquerypelepasan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="km_pemasangan">Ban Id</label>
                                            <input type="text" class="form-control" id="" name="id_ban"
                                                placeholder="" value="{{ $banspas2a->id }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Kode Ban</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="kode_ban" placeholder="" value="{{ $banspas2a->kode_ban }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">No Seri</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="no_seri" placeholder="" value="{{ $banspas2a->no_seri }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" readonly id="km_pemasangan2a"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ $banspas2a->km_pemasangan }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pelepasan</label>
                                            <input type="text" class="form-control" id="km_pelepasan2a"
                                                name="km_pelepasan" placeholder="Masukan km pelepasan"
                                                value="{{ old('km_pelepasan') }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="warna">Keterangan</label>
                                            <select class="form-control" id="keterangan2a" name="keterangan">
                                                <option value="">- Pilih -</option>
                                                <option value="Habis"
                                                    {{ old('keterangan') == 'Habis' ? 'selected' : null }}>
                                                    Habis</option>
                                                <option value="Pecah"
                                                    {{ old('keterangan') == 'Pecah' ? 'selected' : null }}>
                                                    Pecah Non Klaim</option>
                                                <option value="Pecah Klaim"
                                                    {{ old('keterangan') == 'Pecah Klaim' ? 'selected' : null }}>
                                                    Pecah Klaim</option>
                                                <option value="Stok"
                                                    {{ old('keterangan') == 'Stok' ? 'selected' : null }}>
                                                    Stok</option>
                                            </select>
                                        </div>
                                        <div class="form-group" id="perhitungan_klaim2a">
                                            <div class="form-group">
                                                <label for="km_pemasangan">Harga Ban</label>
                                                <input type="text" class="form-control" id="harga2a" readonly
                                                    name="harga" placeholder=""
                                                    value="{{ number_format($banspas2a->harga, 0, ',', '.') }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="km_pemasangan">Target Km</label>
                                                <input type="text" class="form-control" id="" readonly
                                                    name="target_km_ban" placeholder="" value="{{ $banspas2a->target_km_ban }}">
                                            </div>
                                            <div class="form-group" hidden>
                                                <label for="km_pemasangan">KM target</label>
                                                <input type="text" class="form-control" id="km_target2a" readonly
                                                    name="km_pemasangan" placeholder=""
                                                    value="{{ $banspas2a->target_km_ban - $banspas2a->km_pemasangan }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="km_terpakai">KM Terpakai</label>
                                                <input type="text" class="form-control" id="km_terpakai2a" readonly
                                                    name="km_terpakai" value="{{ $banspas2a->km_terpakai }}" placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="sisa_harga">Harga Klaim</label>
                                                <input type="text" class="form-control" id="sisa_harga2a" readonly
                                                    name="sisa_harga" placeholder=""
                                                    value="{{ number_format($banspas2a->sisa_harga, 0, ',', '.') }}">
                                            </div>
                                            <div id="pengambilan">
                                                <div class="card-header mb-3">
                                                    <h3 class="card-title">Pengambilan Deposit Sopir</h3>
                                                </div>
                                                <div>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <label for="sisa_saldo">Kode Sopir</label>
                                                            <div class="form-group d-flex">
                                                                <input readonly type="text" hidden class="form-control"
                                                                    id="karyawan_id2a" name="karyawan_id" placeholder=""
                                                                    value="{{ old('karyawan_id') }}">
                                                                <input onclick="showSopir2a(this.value)"
                                                                    class="form-control" id="kode_karyawan2a"
                                                                    name="kode_karyawan" type="text" placeholder=""
                                                                    value="{{ old('kode_karyawan') }}" readonly
                                                                    style="margin-right: 10px; font-size:14px" />
                                                                <button class="btn btn-primary" type="button"
                                                                    onclick="showSopir2a(this.value)">
                                                                    <i class="fas fa-search"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="sisa_saldo">Sisa Saldo</label>
                                                                <input style="text-align: end;margin:right:10px"
                                                                    type="text" class="form-control" id="sisa_saldo2a"
                                                                    readonly name="sisa_saldo"
                                                                    value="{{ old('sisa_saldo') }}" placeholder="">

                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="nama_lengkap">Nama Sopir</label>
                                                                <input readonly type="text" class="form-control"
                                                                    id="nama_lengkap2a" name="nama_lengkap" placeholder=""
                                                                    value="{{ old('nama_lengkap') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="saldo_masuk">Potongan Saldo</label>
                                                                <input style="text-align: end" type="text"
                                                                    class="form-control" readonly id="saldo_keluar2a"
                                                                    name="saldo_keluar" placeholder=""
                                                                    value="{{ old('saldo_keluar') }}">
                                                            </div>
                                                            <hr
                                                                style="border: 2px solid black; display: inline-block; width: 97%; vertical-align: middle;">
                                                            <span
                                                                style="display: inline-block; margin-left: 0px; margin-right: 0; font-size: 18px; vertical-align: middle;">-</span>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="alamat">Keterangan</label>
                                                                <textarea type="text" class="form-control" id="keterangans" name="keterangans" placeholder="Masukan keterangan">{{ old('keterangans') }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="sub_total">Sub Total</label>
                                                                <input style="text-align: end; margin:right:10px"
                                                                    type="text" class="form-control" readonly
                                                                    id="sub_totals2a" name="sub_totals" placeholder=""
                                                                    value="{{ old('sub_totals') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <script>
                                            $(document).ready(function() {
                                                // Definisikan fungsi perhitungan
                                                function hitung2a() {
                                                    var km_pemasangan = parseInt($('#km_pemasangan2a').val());
                                                    var km_pelepasan = parseInt($('#km_pelepasan2a').val());
                                                    var km_terpakai = km_pelepasan - km_pemasangan;
                                                    $('#km_terpakai2a').val(km_terpakai);
                                                    var km_target = parseFloat($('#km_target2a').val());
                                                    var hargaString = $('#harga2a').val().replaceAll('.', '');
                                                    var harga = parseFloat(hargaString);
                                                    console.log(harga);
                                                    var hasil_persen = km_terpakai / km_target * 100;
                                                    var hasil_harga = harga * hasil_persen / 100;
                                                    // Memperoleh hasil harga yang dibulatkan
                                                    var hasil_harga_bulat = Math.round(hasil_harga);
                                                    var sisa_harga = harga - hasil_harga_bulat;
                                                    var hasil_harga_formatted = sisa_harga.toLocaleString('id-ID');
                                                    $('#sisa_harga2a').val(hasil_harga_formatted);
                                                    $('#saldo_keluar2a').val(hasil_harga_formatted);
                                                    // Hitung selisih antara sisa_saldo dan saldo_keluar
                                                    var sisa_saldo = parseFloat($('#sisa_saldo2a').val().replace(/\D/g, ''));
                                                    var saldo_keluar = parseFloat($('#saldo_keluar2a').val().replace(/\D/g, ''));
                                                    var sub_totals = sisa_saldo - saldo_keluar;
                                                    var formattedSubTotals = sub_totals.toLocaleString('id-ID');
                                                    $('#sub_totals2a').val(formattedSubTotals);
                                                }
                                                // Panggil fungsi perhitungan saat dokumen siap
                                                hitung2a();
                                                // Panggil fungsi perhitungan saat input berubah
                                                $('#km_pelepasan2a').on('input', function() {
                                                    hitung2a();
                                                });
                                            });
                                        </script>
                                        <script>
                                            function toggleLabels() {
                                                var keterangan = document.getElementById('keterangan2a');
                                                var perhitungan_klaim = document.getElementById('perhitungan_klaim2a');
                                                if (keterangan.value === 'Pecah Klaim') {
                                                    perhitungan_klaim.style.display = 'block';
                                                } else {
                                                    perhitungan_klaim.style.display = 'none';
                                                }
                                            }
                                            toggleLabels();
                                            document.getElementById('keterangan2a').addEventListener('change', toggleLabels);
                                        </script>
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
                                <form action="#" method="POST" enctype="multipart/form-data"
                                    autocomplete="off">
                                    @csrf
                                    <div class="card-body">

                                        <div class="form-group">
                                            {{-- <label class="form-label" for="warna">Ban tidak ada</label> --}}
                                            <h4>Ban tidak ada !!</h4>
                                            <p>Tidak ada Ban terpasang di axle 2A</p>
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
        @if ($banspas2b != null)
            <div class="modal fade" id="modal-exle_2B-{{ $kendaraan->id }}">
                <div class="modal-dialog" style="max-width: 90%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 2B</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="{{ url('admin/inquerypelepasan1/' . $kendaraan->id) }}" method="POST"
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
                                            <label for="posisi_ban">Pelepasan Id</label>
                                            <input type="text" class="form-control" readonly
                                                name="pelepasan_ban_id" placeholder=""
                                                value="{{ $inquerypelepasan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="km_pemasangan">Ban Id</label>
                                            <input type="text" class="form-control" id="" name="id_ban"
                                                placeholder="" value="{{ $banspas2b->id }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Kode Ban</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="kode_ban" placeholder="" value="{{ $banspas2b->kode_ban }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">No Seri</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="no_seri" placeholder="" value="{{ $banspas2b->no_seri }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" id="km_pemasangan2b"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ $banspas2b->km_pemasangan }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pelepasan</label>
                                            <input type="text" class="form-control" id="km_pelepasan2b"
                                                name="km_pelepasan" placeholder="Masukan km pelepasan"
                                                value="{{ old('km_pelepasan') }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="warna">Keterangan</label>
                                            <select class="form-control" id="keterangan2b" name="keterangan">
                                                <option value="">- Pilih -</option>
                                                <option value="Habis"
                                                    {{ old('keterangan') == 'Habis' ? 'selected' : null }}>
                                                    Habis</option>
                                                <option value="Pecah"
                                                    {{ old('keterangan') == 'Pecah' ? 'selected' : null }}>
                                                    Pecah Non Klaim</option>
                                                <option value="Pecah Klaim"
                                                    {{ old('keterangan') == 'Pecah Klaim' ? 'selected' : null }}>
                                                    Pecah Klaim</option>
                                                <option value="Stok"
                                                    {{ old('keterangan') == 'Stok' ? 'selected' : null }}>
                                                    Stok</option>

                                            </select>
                                        </div>
                                        <div class="form-group" id="perhitungan_klaim2b">
                                            <div class="form-group">
                                                <label for="km_pemasangan">Harga Ban</label>
                                                <input type="text" class="form-control" id="harga2b" readonly
                                                    name="harga" placeholder=""
                                                    value="{{ number_format($banspas2b->harga, 0, ',', '.') }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="km_pemasangan">Target Km</label>
                                                <input type="text" class="form-control" id="" readonly
                                                    name="target_km_ban" placeholder="" value="{{ $banspas2b->target_km_ban }}">
                                            </div>
                                            <div class="form-group" hidden>
                                                <label for="km_pemasangan">KM target</label>
                                                <input type="text" class="form-control" id="km_target2b" readonly
                                                    name="km_target" placeholder=""
                                                    value="{{ $banspas2b->target_km_ban - $banspas2b->km_pemasangan }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="km_terpakai">KM Terpakai</label>
                                                <input type="text" class="form-control" id="km_terpakai2b" readonly
                                                    name="km_terpakai" value="{{ $banspas2b->km_terpakai }}" placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="sisa_harga">Harga Klaim</label>
                                                <input type="text" class="form-control" id="sisa_harga2b" readonly
                                                    name="sisa_harga" placeholder=""
                                                    value="{{ number_format($banspas2b->sisa_harga, 0, ',', '.') }}">
                                            </div>
                                            <div id="pengambilan">
                                                <div class="card-header mb-3">
                                                    <h3 class="card-title">Pengambilan Deposit Sopir</h3>
                                                </div>
                                                <div>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <label for="sisa_saldo">Kode Sopir</label>
                                                            <div class="form-group d-flex">
                                                                <input readonly type="text" hidden class="form-control"
                                                                    id="karyawan_id2b" name="karyawan_id" placeholder=""
                                                                    value="{{ old('karyawan_id') }}">
                                                                <input onclick="showSopir2b(this.value)"
                                                                    class="form-control" id="kode_karyawan2b"
                                                                    name="kode_karyawan" type="text" placeholder=""
                                                                    value="{{ old('kode_karyawan') }}" readonly
                                                                    style="margin-right: 10px; font-size:14px" />
                                                                <button class="btn btn-primary" type="button"
                                                                    onclick="showSopir2b(this.value)">
                                                                    <i class="fas fa-search"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="sisa_saldo">Sisa Saldo</label>
                                                                <input style="text-align: end;margin:right:10px"
                                                                    type="text" class="form-control" id="sisa_saldo2b"
                                                                    readonly name="sisa_saldo"
                                                                    value="{{ old('sisa_saldo') }}" placeholder="">

                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="nama_lengkap">Nama Sopir</label>
                                                                <input readonly type="text" class="form-control"
                                                                    id="nama_lengkap2b" name="nama_lengkap" placeholder=""
                                                                    value="{{ old('nama_lengkap') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="saldo_masuk">Potongan Saldo</label>
                                                                <input style="text-align: end" type="text"
                                                                    class="form-control" readonly id="saldo_keluar2b"
                                                                    name="saldo_keluar" placeholder=""
                                                                    value="{{ old('saldo_keluar') }}">
                                                            </div>
                                                            <hr
                                                                style="border: 2px solid black; display: inline-block; width: 97%; vertical-align: middle;">
                                                            <span
                                                                style="display: inline-block; margin-left: 0px; margin-right: 0; font-size: 18px; vertical-align: middle;">-</span>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="alamat">Keterangan</label>
                                                                <textarea type="text" class="form-control" id="keterangans" name="keterangans" placeholder="Masukan keterangan">{{ old('keterangans') }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="sub_total">Sub Total</label>
                                                                <input style="text-align: end; margin:right:10px"
                                                                    type="text" class="form-control" readonly
                                                                    id="sub_totals2b" name="sub_totals" placeholder=""
                                                                    value="{{ old('sub_totals') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <script>
                                            $(document).ready(function() {
                                                // Definisikan fungsi perhitungan
                                                function hitung() {
                                                    var km_pemasangan = parseInt($('#km_pemasangan2b').val());
                                                    var km_pelepasan = parseInt($('#km_pelepasan2b').val());
                                                    var km_terpakai = km_pelepasan - km_pemasangan;
                                                    $('#km_terpakai2b').val(km_terpakai);
                                                    var km_target = parseFloat($('#km_target2b').val());
                                                    var hargaString = $('#harga2b').val().replaceAll('.', '');
                                                    var harga = parseFloat(hargaString);
                                                    console.log(harga);
                                                    var hasil_persen = km_terpakai / km_target * 100;
                                                    var hasil_harga = harga * hasil_persen / 100;
                                                    // Memperoleh hasil harga yang dibulatkan
                                                    var hasil_harga_bulat = Math.round(hasil_harga);
                                                    var sisa_harga = harga - hasil_harga_bulat;
                                                    var hasil_harga_formatted = sisa_harga.toLocaleString('id-ID');
                                                    $('#sisa_harga2b').val(hasil_harga_formatted);
                                                    $('#saldo_keluar2b').val(hasil_harga_formatted);

                                                    // Hitung selisih antara sisa_saldo dan saldo_keluar
                                                    var sisa_saldo = parseFloat($('#sisa_saldo2b').val().replace(/\D/g, ''));
                                                    var saldo_keluar = parseFloat($('#saldo_keluar2b').val().replace(/\D/g, ''));
                                                    var sub_totals = sisa_saldo - saldo_keluar;
                                                    var formattedSubTotals = sub_totals.toLocaleString('id-ID');
                                                    $('#sub_totals2b').val(formattedSubTotals);
                                                }
                                                // Panggil fungsi perhitungan saat dokumen siap
                                                hitung();
                                                // Panggil fungsi perhitungan saat input berubah
                                                $('#km_pelepasan2b').on('input', function() {
                                                    hitung();
                                                });
                                            });
                                        </script>

                                        <script>
                                            function toggleLabels() {
                                                var keterangan = document.getElementById('keterangan2b');
                                                var perhitungan_klaim = document.getElementById('perhitungan_klaim2b');

                                                if (keterangan.value === 'Pecah Klaim') {
                                                    perhitungan_klaim.style.display = 'block';
                                                } else {
                                                    perhitungan_klaim.style.display = 'none';
                                                }
                                            }

                                            toggleLabels();
                                            document.getElementById('keterangan2b').addEventListener('change', toggleLabels);
                                        </script>
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
                                <form action="#" method="POST" enctype="multipart/form-data"
                                    autocomplete="off">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group">
                                            {{-- <label class="form-label" for="warna">Ban tidak ada</label> --}}
                                            <h4>Ban tidak ada !!</h4>
                                            <p>Tidak ada Ban terpasang di axle 2B</p>
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
        @if ($banspas2c != null)
            <div class="modal fade" id="modal-exle_2C-{{ $kendaraan->id }}">
                <div class="modal-dialog" style="max-width: 90%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 2C</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="{{ url('admin/inquerypelepasan1/' . $kendaraan->id) }}" method="POST"
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
                                            <label for="posisi_ban">Pelepasan Id</label>
                                            <input type="text" class="form-control" readonly
                                                name="pelepasan_ban_id" placeholder=""
                                                value="{{ $inquerypelepasan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="km_pemasangan">Ban Id</label>
                                            <input type="text" class="form-control" id="" name="id_ban"
                                                placeholder="" value="{{ $banspas2c->id }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">Kode Ban</label>
                                            <input type="text" class="form-control" readonly id=""
                                                name="kode_ban" placeholder="" value="{{ $banspas2c->kode_ban }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">No Seri</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="no_seri" placeholder="" value="{{ $banspas2c->no_seri }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" readonly id="km_pemasangan2c"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ $banspas2c->km_pemasangan }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pelepasan</label>
                                            <input type="text" class="form-control" id="km_pelepasan2c"
                                                name="km_pelepasan" placeholder="Masukan km pelepasan"
                                                value="{{ old('km_pelepasan') }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="warna">Keterangan</label>
                                            <select class="form-control" id="keterangan2c" name="keterangan">
                                                <option value="">- Pilih -</option>
                                                <option value="Habis"
                                                    {{ old('keterangan') == 'Habis' ? 'selected' : null }}>
                                                    Habis</option>
                                                <option value="Pecah"
                                                    {{ old('keterangan') == 'Pecah' ? 'selected' : null }}>
                                                    Pecah Non Klaim</option>
                                                <option value="Pecah Klaim"
                                                    {{ old('keterangan') == 'Pecah Klaim' ? 'selected' : null }}>
                                                    Pecah Klaim</option>
                                                <option value="Stok"
                                                    {{ old('keterangan') == 'Stok' ? 'selected' : null }}>
                                                    Stok</option>
                                            </select>
                                        </div>
                                        <div class="form-group" id="perhitungan_klaim2c">
                                            <div class="form-group">
                                                <label for="km_pemasangan">Harga Ban</label>
                                                <input type="text" class="form-control" id="harga2c" readonly
                                                    name="harga" placeholder=""
                                                    value="{{ number_format($banspas2c->harga, 0, ',', '.') }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="km_pemasangan">Target Km</label>
                                                <input type="text" class="form-control" id="" readonly
                                                    name="target_km_ban" placeholder="" value="{{ $banspas2c->target_km_ban }}">
                                            </div>
                                            <div class="form-group" hidden>
                                                <label for="km_pemasangan">KM target</label>
                                                <input type="text" class="form-control" id="km_target2c" readonly
                                                    name="km_target" placeholder=""
                                                    value="{{ $banspas2c->target_km_ban - $banspas2c->km_pemasangan }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="km_terpakai">KM Terpakai</label>
                                                <input type="text" class="form-control" id="km_terpakai2c" readonly
                                                    name="km_terpakai" value="{{ $banspas2c->km_terpakai }}" placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="sisa_harga">Harga Klaim</label>
                                                <input type="text" class="form-control" id="sisa_harga2c" readonly
                                                    name="sisa_harga" placeholder=""
                                                    value="{{ number_format($banspas2c->sisa_harga, 0, ',', '.') }}">
                                            </div>
                                            <div id="pengambilan">
                                                <div class="card-header mb-3">
                                                    <h3 class="card-title">Pengambilan Deposit Sopir</h3>
                                                </div>
                                                <div>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <label for="sisa_saldo">Kode Sopir</label>
                                                            <div class="form-group d-flex">
                                                                <input readonly type="text" hidden class="form-control"
                                                                    id="karyawan_id2c" name="karyawan_id" placeholder=""
                                                                    value="{{ old('karyawan_id') }}">
                                                                <input onclick="showSopir2c(this.value)"
                                                                    class="form-control" id="kode_karyawan2c"
                                                                    name="kode_karyawan" type="text" placeholder=""
                                                                    value="{{ old('kode_karyawan') }}" readonly
                                                                    style="margin-right: 10px; font-size:14px" />
                                                                <button class="btn btn-primary" type="button"
                                                                    onclick="showSopir2c(this.value)">
                                                                    <i class="fas fa-search"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="sisa_saldo">Sisa Saldo</label>
                                                                <input style="text-align: end;margin:right:10px"
                                                                    type="text" class="form-control" id="sisa_saldo2c"
                                                                    readonly name="sisa_saldo"
                                                                    value="{{ old('sisa_saldo') }}" placeholder="">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="nama_lengkap">Nama Sopir</label>
                                                                <input readonly type="text" class="form-control"
                                                                    id="nama_lengkap2c" name="nama_lengkap" placeholder=""
                                                                    value="{{ old('nama_lengkap') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="saldo_masuk">Potongan Saldo</label>
                                                                <input style="text-align: end" type="text"
                                                                    class="form-control" readonly id="saldo_keluar2c"
                                                                    name="saldo_keluar" placeholder=""
                                                                    value="{{ old('saldo_keluar') }}">
                                                            </div>
                                                            <hr
                                                                style="border: 2px solid black; display: inline-block; width: 97%; vertical-align: middle;">
                                                            <span
                                                                style="display: inline-block; margin-left: 0px; margin-right: 0; font-size: 18px; vertical-align: middle;">-</span>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="alamat">Keterangan</label>
                                                                <textarea type="text" class="form-control" id="keterangans" name="keterangans" placeholder="Masukan keterangan">{{ old('keterangans') }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="sub_total">Sub Total</label>
                                                                <input style="text-align: end; margin:right:10px"
                                                                    type="text" class="form-control" readonly
                                                                    id="sub_totals2c" name="sub_totals" placeholder=""
                                                                    value="{{ old('sub_totals') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <script>
                                            $(document).ready(function() {
                                                // Definisikan fungsi perhitungan
                                                function hitung() {
                                                    var km_pemasangan = parseInt($('#km_pemasangan2c').val());
                                                    var km_pelepasan = parseInt($('#km_pelepasan2c').val());
                                                    var km_terpakai = km_pelepasan - km_pemasangan;
                                                    $('#km_terpakai2c').val(km_terpakai);
                                                    var km_target = parseFloat($('#km_target2c').val());
                                                    var hargaString = $('#harga2c').val().replaceAll('.', '');
                                                    var harga = parseFloat(hargaString);
                                                    console.log(harga);
                                                    var hasil_persen = km_terpakai / km_target * 100;
                                                    var hasil_harga = harga * hasil_persen / 100;
                                                    // Memperoleh hasil harga yang dibulatkan
                                                    var hasil_harga_bulat = Math.round(hasil_harga);
                                                    var sisa_harga = harga - hasil_harga_bulat;
                                                    var hasil_harga_formatted = sisa_harga.toLocaleString('id-ID');
                                                    $('#sisa_harga2c').val(hasil_harga_formatted);
                                                    $('#saldo_keluar2c').val(hasil_harga_formatted);

                                                    // Hitung selisih antara sisa_saldo dan saldo_keluar
                                                    var sisa_saldo = parseFloat($('#sisa_saldo2c').val().replace(/\D/g, ''));
                                                    var saldo_keluar = parseFloat($('#saldo_keluar2c').val().replace(/\D/g, ''));
                                                    var sub_totals = sisa_saldo - saldo_keluar;
                                                    var formattedSubTotals = sub_totals.toLocaleString('id-ID');
                                                    $('#sub_totals2c').val(formattedSubTotals);
                                                }
                                                // Panggil fungsi perhitungan saat dokumen siap
                                                hitung();
                                                // Panggil fungsi perhitungan saat input berubah
                                                $('#km_pelepasan2c').on('input', function() {
                                                    hitung();
                                                });
                                            });
                                        </script>
                                        <script>
                                            function toggleLabels() {
                                                var keterangan = document.getElementById('keterangan2c');
                                                var perhitungan_klaim = document.getElementById('perhitungan_klaim2c');

                                                if (keterangan.value === 'Pecah Klaim') {
                                                    perhitungan_klaim.style.display = 'block';
                                                } else {
                                                    perhitungan_klaim.style.display = 'none';
                                                }
                                            }

                                            toggleLabels();
                                            document.getElementById('keterangan2c').addEventListener('change', toggleLabels);
                                        </script>
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
                                            <h4>Ban tidak ada !!</h4>
                                            <p>Tidak ada Ban terpasang di axle 2C</p>
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
        @if ($banspas2d != null)
            <div class="modal fade" id="modal-exle_2D-{{ $kendaraan->id }}">
                <div class="modal-dialog" style="max-width: 90%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 2D</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="{{ url('admin/inquerypelepasan1/' . $kendaraan->id) }}" method="POST"
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
                                            <label for="posisi_ban">Pelepasan Id</label>
                                            <input type="text" class="form-control" readonly
                                                name="pelepasan_ban_id" placeholder=""
                                                value="{{ $inquerypelepasan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="km_pemasangan">Ban Id</label>
                                            <input type="text" class="form-control" id="" name="id_ban"
                                                placeholder="" value="{{ $banspas2d->id }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Kode Ban</label>
                                            <input type="text" class="form-control" readonly id=""
                                                name="kode_ban" placeholder="" value="{{ $banspas2d->kode_ban }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">No Seri</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="no_seri" placeholder="" value="{{ $banspas2d->no_seri }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" readonly id="km_pemasangan2d"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ $banspas2d->km_pemasangan }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pelepasan</label>
                                            <input type="text" class="form-control" id="km_pelepasan2d"
                                                name="km_pelepasan" placeholder="Masukan km pelepasan"
                                                value="{{ old('km_pelepasan') }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="warna">Keterangan</label>
                                            <select class="form-control" id="keterangan2d" name="keterangan">
                                                <option value="">- Pilih -</option>
                                                <option value="Habis"
                                                    {{ old('keterangan') == 'Habis' ? 'selected' : null }}>
                                                    Habis</option>
                                                <option value="Pecah"
                                                    {{ old('keterangan') == 'Pecah' ? 'selected' : null }}>
                                                    Pecah Non Klaim</option>
                                                <option value="Pecah Klaim"
                                                    {{ old('keterangan') == 'Pecah Klaim' ? 'selected' : null }}>
                                                    Pecah Klaim</option>
                                                <option value="Stok"
                                                    {{ old('keterangan') == 'Stok' ? 'selected' : null }}>
                                                    Stok</option>
                                            </select>
                                        </div>
                                         <div class="form-group" id="perhitungan_klaim2d">
                                            <div class="form-group">
                                                <label for="km_pemasangan">Harga Ban</label>
                                                <input type="text" class="form-control" id="harga2d" readonly
                                                    name="harga" placeholder=""
                                                    value="{{ number_format($banspas2d->harga, 0, ',', '.') }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="km_pemasangan">Target Km</label>
                                                <input type="text" class="form-control" id="" readonly
                                                    name="target_km_ban" placeholder="" value="{{ $banspas2d->target_km_ban }}">
                                            </div>
                                            <div class="form-group" hidden>
                                                <label for="km_pemasangan">KM target</label>
                                                <input type="text" class="form-control" id="km_target2d" readonly
                                                    name="km_target" placeholder=""
                                                    value="{{ $banspas2d->target_km_ban - $banspas2d->km_pemasangan }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="km_terpakai">KM Terpakai</label>
                                                <input type="text" class="form-control" id="km_terpakai2d" readonly
                                                    name="km_terpakai" value="{{ $banspas2d->km_terpakai }}" placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="sisa_harga">Harga Klaim</label>
                                                <input type="text" class="form-control" id="sisa_harga2d" readonly
                                                    name="sisa_harga" placeholder=""
                                                    value="{{ number_format($banspas2d->sisa_harga, 0, ',', '.') }}">
                                            </div>
                                            <div id="pengambilan">
                                                <div class="card-header mb-3">
                                                    <h3 class="card-title">Pengambilan Deposit Sopir</h3>
                                                </div>
                                                <div>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <label for="sisa_saldo">Kode Sopir</label>
                                                            <div class="form-group d-flex">
                                                                <input readonly type="text" hidden class="form-control"
                                                                    id="karyawan_id2d" name="karyawan_id" placeholder=""
                                                                    value="{{ old('karyawan_id') }}">
                                                                <input onclick="showSopir2d(this.value)"
                                                                    class="form-control" id="kode_karyawan2d"
                                                                    name="kode_karyawan" type="text" placeholder=""
                                                                    value="{{ old('kode_karyawan') }}" readonly
                                                                    style="margin-right: 10px; font-size:14px" />
                                                                <button class="btn btn-primary" type="button"
                                                                    onclick="showSopir2d(this.value)">
                                                                    <i class="fas fa-search"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="sisa_saldo">Sisa Saldo</label>
                                                                <input style="text-align: end;margin:right:10px"
                                                                    type="text" class="form-control" id="sisa_saldo2d"
                                                                    readonly name="sisa_saldo"
                                                                    value="{{ old('sisa_saldo') }}" placeholder="">

                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="nama_lengkap">Nama Sopir</label>
                                                                <input readonly type="text" class="form-control"
                                                                    id="nama_lengkap2d" name="nama_lengkap" placeholder=""
                                                                    value="{{ old('nama_lengkap') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="saldo_masuk">Potongan Saldo</label>
                                                                <input style="text-align: end" type="text"
                                                                    class="form-control" readonly id="saldo_keluar2d"
                                                                    name="saldo_keluar" placeholder=""
                                                                    value="{{ old('saldo_keluar') }}">
                                                            </div>
                                                            <hr
                                                                style="border: 2px solid black; display: inline-block; width: 97%; vertical-align: middle;">
                                                            <span
                                                                style="display: inline-block; margin-left: 0px; margin-right: 0; font-size: 18px; vertical-align: middle;">-</span>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="alamat">Keterangan</label>
                                                                <textarea type="text" class="form-control" id="keterangans" name="keterangans" placeholder="Masukan keterangan">{{ old('keterangans') }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="sub_total">Sub Total</label>
                                                                <input style="text-align: end; margin:right:10px"
                                                                    type="text" class="form-control" readonly
                                                                    id="sub_totals2d" name="sub_totals" placeholder=""
                                                                    value="{{ old('sub_totals') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <script>
                                            $(document).ready(function() {
                                                // Definisikan fungsi perhitungan
                                                function hitung() {
                                                    var km_pemasangan = parseInt($('#km_pemasangan2d').val());
                                                    var km_pelepasan = parseInt($('#km_pelepasan2d').val());
                                                    var km_terpakai = km_pelepasan - km_pemasangan;
                                                    $('#km_terpakai2d').val(km_terpakai);
                                                    var km_target = parseFloat($('#km_target2d').val());
                                                    var hargaString = $('#harga2d').val().replaceAll('.', '');
                                                    var harga = parseFloat(hargaString);
                                                    console.log(harga);
                                                    var hasil_persen = km_terpakai / km_target * 100;
                                                    var hasil_harga = harga * hasil_persen / 100;
                                                    // Memperoleh hasil harga yang dibulatkan
                                                    var hasil_harga_bulat = Math.round(hasil_harga);
                                                    var sisa_harga = harga - hasil_harga_bulat;
                                                    var hasil_harga_formatted = sisa_harga.toLocaleString('id-ID');
                                                    $('#sisa_harga2d').val(hasil_harga_formatted);
                                                    $('#saldo_keluar2d').val(hasil_harga_formatted);

                                                    // Hitung selisih antara sisa_saldo dan saldo_keluar
                                                    var sisa_saldo = parseFloat($('#sisa_saldo2d').val().replace(/\D/g, ''));
                                                    var saldo_keluar = parseFloat($('#saldo_keluar2d').val().replace(/\D/g, ''));
                                                    var sub_totals = sisa_saldo - saldo_keluar;
                                                    var formattedSubTotals = sub_totals.toLocaleString('id-ID');
                                                    $('#sub_totals2d').val(formattedSubTotals);
                                                }
                                                // Panggil fungsi perhitungan saat dokumen siap
                                                hitung();
                                                // Panggil fungsi perhitungan saat input berubah
                                                $('#km_pelepasan2d').on('input', function() {
                                                    hitung();
                                                });
                                            });
                                        </script>

                                        <script>
                                            function toggleLabels() {
                                                var keterangan = document.getElementById('keterangan2d');
                                                var perhitungan_klaim = document.getElementById('perhitungan_klaim2d');

                                                if (keterangan.value === 'Pecah Klaim') {
                                                    perhitungan_klaim.style.display = 'block';
                                                } else {
                                                    perhitungan_klaim.style.display = 'none';
                                                }
                                            }

                                            toggleLabels();
                                            document.getElementById('keterangan2d').addEventListener('change', toggleLabels);
                                        </script>
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
                                            <h4>Ban tidak ada !!</h4>
                                            <p>Tidak ada Ban terpasang di axle 2D</p>
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
        @if ($banspas3a != null)
            <div class="modal fade" id="modal-exle_3A-{{ $kendaraan->id }}">
                <div class="modal-dialog" style="max-width: 90%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 3A</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="{{ url('admin/inquerypelepasan1/' . $kendaraan->id) }}" method="POST"
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
                                            <label for="posisi_ban">Pelepasan Id</label>
                                            <input type="text" class="form-control" readonly
                                                name="pelepasan_ban_id" placeholder=""
                                                value="{{ $inquerypelepasan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="km_pemasangan">Ban Id</label>
                                            <input type="text" class="form-control" id="" name="id_ban"
                                                placeholder="" value="{{ $banspas3a->id }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">Kode Ban</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="kode_ban" placeholder="" value="{{ $banspas3a->kode_ban }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">No Seri</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="no_seri" placeholder="" value="{{ $banspas3a->no_seri }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" readonly id="km_pemasangan3a"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ $banspas3a->km_pemasangan }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pelepasan</label>
                                            <input type="text" class="form-control" id="km_pelepasan3a"
                                                name="km_pelepasan" placeholder="Masukan km pelepasan"
                                                value="{{ old('km_pelepasan') }}">
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label" for="warna">Keterangan</label>
                                            <select class="form-control" id="keterangan3a" name="keterangan">
                                                <option value="">- Pilih -</option>
                                                <option value="Habis"
                                                    {{ old('keterangan') == 'Habis' ? 'selected' : null }}>
                                                    Habis</option>
                                                <option value="Pecah"
                                                    {{ old('keterangan') == 'Pecah' ? 'selected' : null }}>
                                                    Pecah Non Klaim</option>
                                                <option value="Pecah Klaim"
                                                    {{ old('keterangan') == 'Pecah Klaim' ? 'selected' : null }}>
                                                    Pecah Klaim</option>
                                                <option value="Stok"
                                                    {{ old('keterangan') == 'Stok' ? 'selected' : null }}>
                                                    Stok</option>
                                            </select>
                                        </div>
                                        <div class="form-group" id="perhitungan_klaim3a">
                                            <div class="form-group">
                                                <label for="km_pemasangan">Harga Ban</label>
                                                <input type="text" class="form-control" id="harga3a" readonly
                                                    name="harga" placeholder=""
                                                    value="{{ number_format($banspas3a->harga, 0, ',', '.') }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="km_pemasangan">Target Km</label>
                                                <input type="text" class="form-control" id="" readonly
                                                    name="target_km_ban" placeholder="" value="{{ $banspas3a->target_km_ban }}">
                                            </div>
                                            <div class="form-group" hidden>
                                                <label for="km_pemasangan">KM target</label>
                                                <input type="text" class="form-control" id="km_target3a" readonly
                                                    name="km_target" placeholder=""
                                                    value="{{ $banspas3a->target_km_ban - $banspas3a->km_pemasangan }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="km_terpakai">KM Terpakai</label>
                                                <input type="text" class="form-control" id="km_terpakai3a" readonly
                                                    name="km_terpakai" value="{{ $banspas3a->km_terpakai }}" placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="sisa_harga">Harga Klaim</label>
                                                <input type="text" class="form-control" id="sisa_harga3a" readonly
                                                    name="sisa_harga" placeholder=""
                                                    value="{{ number_format($banspas3a->sisa_harga, 0, ',', '.') }}">
                                            </div>
                                            <div id="pengambilan">
                                                <div class="card-header mb-3">
                                                    <h3 class="card-title">Pengambilan Deposit Sopir</h3>
                                                </div>
                                                <div>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <label for="sisa_saldo">Kode Sopir</label>
                                                            <div class="form-group d-flex">
                                                                <input readonly type="text" hidden class="form-control"
                                                                    id="karyawan_id3a" name="karyawan_id" placeholder=""
                                                                    value="{{ old('karyawan_id') }}">
                                                                <input onclick="showSopir3a(this.value)"
                                                                    class="form-control" id="kode_karyawan3a"
                                                                    name="kode_karyawan" type="text" placeholder=""
                                                                    value="{{ old('kode_karyawan') }}" readonly
                                                                    style="margin-right: 10px; font-size:14px" />
                                                                <button class="btn btn-primary" type="button"
                                                                    onclick="showSopir3a(this.value)">
                                                                    <i class="fas fa-search"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="sisa_saldo">Sisa Saldo</label>
                                                                <input style="text-align: end;margin:right:10px"
                                                                    type="text" class="form-control" id="sisa_saldo3a"
                                                                    readonly name="sisa_saldo"
                                                                    value="{{ old('sisa_saldo') }}" placeholder="">

                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="nama_lengkap">Nama Sopir</label>
                                                                <input readonly type="text" class="form-control"
                                                                    id="nama_lengkap3a" name="nama_lengkap" placeholder=""
                                                                    value="{{ old('nama_lengkap') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="saldo_masuk">Potongan Saldo</label>
                                                                <input style="text-align: end" type="text"
                                                                    class="form-control" readonly id="saldo_keluar3a"
                                                                    name="saldo_keluar" placeholder=""
                                                                    value="{{ old('saldo_keluar') }}">
                                                            </div>
                                                            <hr
                                                                style="border: 2px solid black; display: inline-block; width: 97%; vertical-align: middle;">
                                                            <span
                                                                style="display: inline-block; margin-left: 0px; margin-right: 0; font-size: 18px; vertical-align: middle;">-</span>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="alamat">Keterangan</label>
                                                                <textarea type="text" class="form-control" id="keterangans" name="keterangans" placeholder="Masukan keterangan">{{ old('keterangans') }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="sub_total">Sub Total</label>
                                                                <input style="text-align: end; margin:right:10px"
                                                                    type="text" class="form-control" readonly
                                                                    id="sub_totals3a" name="sub_totals" placeholder=""
                                                                    value="{{ old('sub_totals') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <script>
                                            $(document).ready(function() {
                                                // Definisikan fungsi perhitungan
                                                function hitung() {
                                                    var km_pemasangan = parseInt($('#km_pemasangan3a').val());
                                                    var km_pelepasan = parseInt($('#km_pelepasan3a').val());
                                                    var km_terpakai = km_pelepasan - km_pemasangan;
                                                    $('#km_terpakai3a').val(km_terpakai);
                                                    var km_target = parseFloat($('#km_target3a').val());
                                                    var hargaString = $('#harga3a').val().replaceAll('.', '');
                                                    var harga = parseFloat(hargaString);
                                                    console.log(harga);
                                                    var hasil_persen = km_terpakai / km_target * 100;
                                                    var hasil_harga = harga * hasil_persen / 100;
                                                    // Memperoleh hasil harga yang dibulatkan
                                                    var hasil_harga_bulat = Math.round(hasil_harga);
                                                    var sisa_harga = harga - hasil_harga_bulat;
                                                    var hasil_harga_formatted = sisa_harga.toLocaleString('id-ID');
                                                    $('#sisa_harga3a').val(hasil_harga_formatted);
                                                    $('#saldo_keluar3a').val(hasil_harga_formatted);

                                                    // Hitung selisih antara sisa_saldo dan saldo_keluar
                                                    var sisa_saldo = parseFloat($('#sisa_saldo3a').val().replace(/\D/g, ''));
                                                    var saldo_keluar = parseFloat($('#saldo_keluar3a').val().replace(/\D/g, ''));
                                                    var sub_totals = sisa_saldo - saldo_keluar;
                                                    var formattedSubTotals = sub_totals.toLocaleString('id-ID');
                                                    $('#sub_totals3a').val(formattedSubTotals);
                                                }
                                                // Panggil fungsi perhitungan saat dokumen siap
                                                hitung();
                                                // Panggil fungsi perhitungan saat input berubah
                                                $('#km_pelepasan3a').on('input', function() {
                                                    hitung();
                                                });
                                            });
                                        </script>

                                        <script>
                                            function toggleLabels() {
                                                var keterangan = document.getElementById('keterangan3a');
                                                var perhitungan_klaim = document.getElementById('perhitungan_klaim3a');

                                                if (keterangan.value === 'Pecah Klaim') {
                                                    perhitungan_klaim.style.display = 'block';
                                                } else {
                                                    perhitungan_klaim.style.display = 'none';
                                                }
                                            }

                                            toggleLabels();
                                            document.getElementById('keterangan3a').addEventListener('change', toggleLabels);
                                        </script>
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
                                            <h4>Ban tidak ada !!</h4>
                                            <p>Tidak ada Ban terpasang di axle 3A</p>
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
        @if ($banspas3b != null)
           <div class="modal fade" id="modal-exle_3B-{{ $kendaraan->id }}">
                <div class="modal-dialog" style="max-width: 90%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 3B</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="{{ url('admin/inquerypelepasan1/' . $kendaraan->id) }}" method="POST"
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
                                            <label for="posisi_ban">Pelepasan Id</label>
                                            <input type="text" class="form-control" readonly
                                                name="pelepasan_ban_id" placeholder=""
                                                value="{{ $inquerypelepasan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="km_pemasangan">Ban Id</label>
                                            <input type="text" class="form-control" id="" name="id_ban"
                                                placeholder="" value="{{ $banspas3b->id }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">Kode Ban</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="kode_ban" placeholder="" value="{{ $banspas3b->kode_ban }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">No Seri</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="no_seri" placeholder="" value="{{ $banspas3b->no_seri }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" readonly id="km_pemasangan3b"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ $banspas3b->km_pemasangan }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pelepasan</label>
                                            <input type="text" class="form-control" id="km_pelepasan3b"
                                                name="km_pelepasan" placeholder="Masukan km pelepasan"
                                                value="{{ old('km_pelepasan') }}">
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label" for="keterangan3b">Keterangan</label>
                                            <select class="form-control" id="keterangan3b" name="keterangan">
                                                <option value="">- Pilih -</option>
                                                <option value="Habis"
                                                    {{ old('keterangan') == 'Habis' ? 'selected' : null }}>
                                                    Habis</option>
                                                <option value="Pecah"
                                                    {{ old('keterangan') == 'Pecah' ? 'selected' : null }}>
                                                    Pecah Non Klaim</option>
                                                <option value="Pecah Klaim"
                                                    {{ old('keterangan') == 'Pecah Klaim' ? 'selected' : null }}>
                                                    Pecah Klaim</option>
                                                <option value="Stok"
                                                    {{ old('keterangan') == 'Stok' ? 'selected' : null }}>
                                                    Stok</option>
                                            </select>
                                        </div>
                                         <div class="form-group" id="perhitungan_klaim3b">
                                            <div class="form-group">
                                                <label for="km_pemasangan">Harga Ban</label>
                                                <input type="text" class="form-control" id="harga3b" readonly
                                                    name="harga" placeholder=""
                                                    value="{{ number_format($banspas3b->harga, 0, ',', '.') }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="km_pemasangan">Target Km</label>
                                                <input type="text" class="form-control" id="" readonly
                                                    name="target_km_ban" placeholder="" value="{{ $banspas3b->target_km_ban }}">
                                            </div>
                                            <div class="form-group" hidden>
                                                <label for="km_pemasangan">KM target</label>
                                                <input type="text" class="form-control" id="km_target3b" readonly
                                                    name="km_target" placeholder=""
                                                    value="{{ $banspas3b->target_km_ban - $banspas3b->km_pemasangan }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="km_terpakai">KM Terpakai</label>
                                                <input type="text" class="form-control" id="km_terpakai3b" readonly
                                                    name="km_terpakai" value="{{ $banspas3b->km_terpakai }}" placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="sisa_harga">Harga Klaim</label>
                                                <input type="text" class="form-control" id="sisa_harga3b" readonly
                                                    name="sisa_harga" placeholder=""
                                                    value="{{ number_format($banspas3b->sisa_harga, 0, ',', '.') }}">
                                            </div>
                                            <div id="pengambilan">
                                                <div class="card-header mb-3">
                                                    <h3 class="card-title">Pengambilan Deposit Sopir</h3>
                                                </div>
                                                <div>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <label for="sisa_saldo">Kode Sopir</label>
                                                            <div class="form-group d-flex">
                                                                <input readonly type="text" hidden class="form-control"
                                                                    id="karyawan_id3b" name="karyawan_id" placeholder=""
                                                                    value="{{ old('karyawan_id') }}">
                                                                <input onclick="showSopir3b(this.value)"
                                                                    class="form-control" id="kode_karyawan3b"
                                                                    name="kode_karyawan" type="text" placeholder=""
                                                                    value="{{ old('kode_karyawan') }}" readonly
                                                                    style="margin-right: 10px; font-size:14px" />
                                                                <button class="btn btn-primary" type="button"
                                                                    onclick="showSopir3b(this.value)">
                                                                    <i class="fas fa-search"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="sisa_saldo">Sisa Saldo</label>
                                                                <input style="text-align: end;margin:right:10px"
                                                                    type="text" class="form-control" id="sisa_saldo3b"
                                                                    readonly name="sisa_saldo"
                                                                    value="{{ old('sisa_saldo') }}" placeholder="">

                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="nama_lengkap">Nama Sopir</label>
                                                                <input readonly type="text" class="form-control"
                                                                    id="nama_lengkap3b" name="nama_lengkap" placeholder=""
                                                                    value="{{ old('nama_lengkap') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="saldo_masuk">Potongan Saldo</label>
                                                                <input style="text-align: end" type="text"
                                                                    class="form-control" readonly id="saldo_keluar3b"
                                                                    name="saldo_keluar" placeholder=""
                                                                    value="{{ old('saldo_keluar') }}">
                                                            </div>
                                                            <hr
                                                                style="border: 2px solid black; display: inline-block; width: 97%; vertical-align: middle;">
                                                            <span
                                                                style="display: inline-block; margin-left: 0px; margin-right: 0; font-size: 18px; vertical-align: middle;">-</span>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="alamat">Keterangan</label>
                                                                <textarea type="text" class="form-control" id="keterangans" name="keterangans" placeholder="Masukan keterangan">{{ old('keterangans') }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="sub_total">Sub Total</label>
                                                                <input style="text-align: end; margin:right:10px"
                                                                    type="text" class="form-control" readonly
                                                                    id="sub_totals3b" name="sub_totals" placeholder=""
                                                                    value="{{ old('sub_totals') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <script>
                                            $(document).ready(function() {
                                                // Definisikan fungsi perhitungan
                                                function hitung() {
                                                    var km_pemasangan = parseInt($('#km_pemasangan3b').val());
                                                    var km_pelepasan = parseInt($('#km_pelepasan3b').val());
                                                    var km_terpakai = km_pelepasan - km_pemasangan;
                                                    $('#km_terpakai3b').val(km_terpakai);
                                                    var km_target = parseFloat($('#km_target3b').val());
                                                    var hargaString = $('#harga3b').val().replaceAll('.', '');
                                                    var harga = parseFloat(hargaString);
                                                    console.log(harga);
                                                    var hasil_persen = km_terpakai / km_target * 100;
                                                    var hasil_harga = harga * hasil_persen / 100;
                                                    // Memperoleh hasil harga yang dibulatkan
                                                    var hasil_harga_bulat = Math.round(hasil_harga);
                                                    var sisa_harga = harga - hasil_harga_bulat;
                                                    var hasil_harga_formatted = sisa_harga.toLocaleString('id-ID');
                                                    $('#sisa_harga3b').val(hasil_harga_formatted);
                                                    $('#saldo_keluar3b').val(hasil_harga_formatted);

                                                    // Hitung selisih antara sisa_saldo dan saldo_keluar
                                                    var sisa_saldo = parseFloat($('#sisa_saldo3b').val().replace(/\D/g, ''));
                                                    var saldo_keluar = parseFloat($('#saldo_keluar3b').val().replace(/\D/g, ''));
                                                    var sub_totals = sisa_saldo - saldo_keluar;
                                                    var formattedSubTotals = sub_totals.toLocaleString('id-ID');
                                                    $('#sub_totals3b').val(formattedSubTotals);
                                                }
                                                // Panggil fungsi perhitungan saat dokumen siap
                                                hitung();
                                                // Panggil fungsi perhitungan saat input berubah
                                                $('#km_pelepasan3b').on('input', function() {
                                                    hitung();
                                                });
                                            });
                                        </script>

                                        <script>
                                            function toggleLabels() {
                                                var keterangan = document.getElementById('keterangan3b');
                                                var perhitungan_klaim = document.getElementById('perhitungan_klaim3b');

                                                if (keterangan.value === 'Pecah Klaim') {
                                                    perhitungan_klaim.style.display = 'block';
                                                } else {
                                                    perhitungan_klaim.style.display = 'none';
                                                }
                                            }

                                            toggleLabels();
                                            document.getElementById('keterangan3b').addEventListener('change', toggleLabels);
                                        </script>
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
                                            <h4>Ban tidak ada !!</h4>
                                            <p>Tidak ada Ban terpasang di axle 3B</p>
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
        @if ($banspas3c != null)
            <div class="modal fade" id="modal-exle_3C-{{ $kendaraan->id }}">
                <div class="modal-dialog" style="max-width: 90%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 3C</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="{{ url('admin/inquerypelepasan1/' . $kendaraan->id) }}" method="POST"
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
                                            <label for="posisi_ban">Pelepasan Id</label>
                                            <input type="text" class="form-control" readonly
                                                name="pelepasan_ban_id" placeholder=""
                                                value="{{ $inquerypelepasan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="km_pemasangan">Ban Id</label>
                                            <input type="text" class="form-control" id="" name="id_ban"
                                                placeholder="" value="{{ $banspas3c->id }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">Kode Ban</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="kode_ban" placeholder="" value="{{ $banspas3c->kode_ban }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">No Seri</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="no_seri" placeholder="" value="{{ $banspas3c->no_seri }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" readonly id="km_pemasangan3c"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ $banspas3c->km_pemasangan }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pelepasan</label>
                                            <input type="text" class="form-control" id="km_pelepasan3c"
                                                name="km_pelepasan" placeholder="Masukan km pelepasan"
                                                value="{{ old('km_pelepasan') }}">
                                        </div>

                                            <div class="form-group">
                                            <label class="form-label" for="warna">Keterangan</label>
                                            <select class="form-control" id="keterangan3c" name="keterangan">
                                                <option value="">- Pilih -</option>
                                                <option value="Habis"
                                                    {{ old('keterangan') == 'Habis' ? 'selected' : null }}>
                                                    Habis</option>
                                                <option value="Pecah"
                                                    {{ old('keterangan') == 'Pecah' ? 'selected' : null }}>
                                                    Pecah Non Klaim</option>
                                                <option value="Pecah Klaim"
                                                    {{ old('keterangan') == 'Pecah Klaim' ? 'selected' : null }}>
                                                    Pecah Klaim</option>
                                                <option value="Stok"
                                                    {{ old('keterangan') == 'Stok' ? 'selected' : null }}>
                                                    Stok</option>
                                            </select>
                                        </div>
                                        <div class="form-group" id="perhitungan_klaim3c">
                                            <div class="form-group">
                                                <label for="km_pemasangan">Harga Ban</label>
                                                <input type="text" class="form-control" id="harga3c" readonly
                                                    name="harga" placeholder=""
                                                    value="{{ number_format($banspas3c->harga, 0, ',', '.') }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="km_pemasangan">Target Km</label>
                                                <input type="text" class="form-control" id="" readonly
                                                    name="target_km_ban" placeholder="" value="{{ $banspas3c->target_km_ban }}">
                                            </div>
                                            <div class="form-group" hidden>
                                                <label for="km_pemasangan">KM target</label>
                                                <input type="text" class="form-control" id="km_target3c" readonly
                                                    name="km_target" placeholder=""
                                                    value="{{ $banspas3c->target_km_ban - $banspas3c->km_pemasangan }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="km_terpakai">KM Terpakai</label>
                                                <input type="text" class="form-control" id="km_terpakai3c" readonly
                                                    name="km_terpakai" value="{{ $banspas3c->km_terpakai }}" placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="sisa_harga">Harga Klaim</label>
                                                <input type="text" class="form-control" id="sisa_harga3c" readonly
                                                    name="sisa_harga" placeholder=""
                                                    value="{{ number_format($banspas3c->sisa_harga, 0, ',', '.') }}">
                                            </div>
                                            <div id="pengambilan">
                                                <div class="card-header mb-3">
                                                    <h3 class="card-title">Pengambilan Deposit Sopir</h3>
                                                </div>
                                                <div>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <label for="sisa_saldo">Kode Sopir</label>
                                                            <div class="form-group d-flex">
                                                                <input readonly type="text" hidden class="form-control"
                                                                    id="karyawan_id3c" name="karyawan_id" placeholder=""
                                                                    value="{{ old('karyawan_id') }}">
                                                                <input onclick="showSopir3c(this.value)"
                                                                    class="form-control" id="kode_karyawan3c"
                                                                    name="kode_karyawan" type="text" placeholder=""
                                                                    value="{{ old('kode_karyawan') }}" readonly
                                                                    style="margin-right: 10px; font-size:14px" />
                                                                <button class="btn btn-primary" type="button"
                                                                    onclick="showSopir3c(this.value)">
                                                                    <i class="fas fa-search"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="sisa_saldo">Sisa Saldo</label>
                                                                <input style="text-align: end;margin:right:10px"
                                                                    type="text" class="form-control" id="sisa_saldo3c"
                                                                    readonly name="sisa_saldo"
                                                                    value="{{ old('sisa_saldo') }}" placeholder="">

                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="nama_lengkap">Nama Sopir</label>
                                                                <input readonly type="text" class="form-control"
                                                                    id="nama_lengkap3c" name="nama_lengkap" placeholder=""
                                                                    value="{{ old('nama_lengkap') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="saldo_masuk">Potongan Saldo</label>
                                                                <input style="text-align: end" type="text"
                                                                    class="form-control" readonly id="saldo_keluar3c"
                                                                    name="saldo_keluar" placeholder=""
                                                                    value="{{ old('saldo_keluar') }}">
                                                            </div>
                                                            <hr
                                                                style="border: 2px solid black; display: inline-block; width: 97%; vertical-align: middle;">
                                                            <span
                                                                style="display: inline-block; margin-left: 0px; margin-right: 0; font-size: 18px; vertical-align: middle;">-</span>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="alamat">Keterangan</label>
                                                                <textarea type="text" class="form-control" id="keterangans" name="keterangans" placeholder="Masukan keterangan">{{ old('keterangans') }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="sub_total">Sub Total</label>
                                                                <input style="text-align: end; margin:right:10px"
                                                                    type="text" class="form-control" readonly
                                                                    id="sub_totals3c" name="sub_totals" placeholder=""
                                                                    value="{{ old('sub_totals') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <script>
                                            $(document).ready(function() {
                                                // Definisikan fungsi perhitungan
                                                function hitung() {
                                                    var km_pemasangan = parseInt($('#km_pemasangan3c').val());
                                                    var km_pelepasan = parseInt($('#km_pelepasan3c').val());
                                                    var km_terpakai = km_pelepasan - km_pemasangan;
                                                    $('#km_terpakai3c').val(km_terpakai);
                                                    var km_target = parseFloat($('#km_target3c').val());
                                                    var hargaString = $('#harga3c').val().replaceAll('.', '');
                                                    var harga = parseFloat(hargaString);
                                                    console.log(harga);
                                                    var hasil_persen = km_terpakai / km_target * 100;
                                                    var hasil_harga = harga * hasil_persen / 100;
                                                    // Memperoleh hasil harga yang dibulatkan
                                                    var hasil_harga_bulat = Math.round(hasil_harga);
                                                    var sisa_harga = harga - hasil_harga_bulat;
                                                    var hasil_harga_formatted = sisa_harga.toLocaleString('id-ID');
                                                    $('#sisa_harga3c').val(hasil_harga_formatted);
                                                    $('#saldo_keluar3c').val(hasil_harga_formatted);

                                                    // Hitung selisih antara sisa_saldo dan saldo_keluar
                                                    var sisa_saldo = parseFloat($('#sisa_saldo3c').val().replace(/\D/g, ''));
                                                    var saldo_keluar = parseFloat($('#saldo_keluar3c').val().replace(/\D/g, ''));
                                                    var sub_totals = sisa_saldo - saldo_keluar;
                                                    var formattedSubTotals = sub_totals.toLocaleString('id-ID');
                                                    $('#sub_totals3c').val(formattedSubTotals);
                                                }
                                                // Panggil fungsi perhitungan saat dokumen siap
                                                hitung();
                                                // Panggil fungsi perhitungan saat input berubah
                                                $('#km_pelepasan3c').on('input', function() {
                                                    hitung();
                                                });
                                            });
                                        </script>

                                        <script>
                                            function toggleLabels() {
                                                var keterangan = document.getElementById('keterangan3c');
                                                var perhitungan_klaim = document.getElementById('perhitungan_klaim3c');

                                                if (keterangan.value === 'Pecah Klaim') {
                                                    perhitungan_klaim.style.display = 'block';
                                                } else {
                                                    perhitungan_klaim.style.display = 'none';
                                                }
                                            }
                                            toggleLabels();
                                            document.getElementById('keterangan3c').addEventListener('change', toggleLabels);
                                        </script>
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
                                            <h4>Ban tidak ada !!</h4>
                                            <p>Tidak ada Ban terpasang di axle 3C</p>
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
        @if ($banspas3d != null)
            <div class="modal fade" id="modal-exle_3D-{{ $kendaraan->id }}">
                <div class="modal-dialog" style="max-width: 90%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 3D</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="{{ url('admin/inquerypelepasan1/' . $kendaraan->id) }}" method="POST"
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
                                            <label for="posisi_ban">Pelepasan Id</label>
                                            <input type="text" class="form-control" readonly
                                                name="pelepasan_ban_id" placeholder=""
                                                value="{{ $inquerypelepasan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="km_pemasangan">Ban Id</label>
                                            <input type="text" class="form-control" id="" name="id_ban"
                                                placeholder="" value="{{ $banspas3d->id }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">Kode Ban</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="kode_ban" placeholder="" value="{{ $banspas3d->kode_ban }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">No Seri</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="no_seri" placeholder="" value="{{ $banspas3d->no_seri }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" readonly id="km_pemasangan3d"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ $banspas3d->km_pemasangan }}">
                                        </div>


                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pelepasan</label>
                                            <input type="text" class="form-control" id="km_pelepasan3d"
                                                name="km_pelepasan" placeholder="Masukan km pelepasan"
                                                value="{{ old('km_pelepasan') }}">
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label" for="keterangan3d">Keterangan</label>
                                            <select class="form-control" id="keterangan3d" name="keterangan">
                                                <option value="">- Pilih -</option>
                                                <option value="Habis"
                                                    {{ old('keterangan') == 'Habis' ? 'selected' : null }}>
                                                    Habis</option>
                                                <option value="Pecah"
                                                    {{ old('keterangan') == 'Pecah' ? 'selected' : null }}>
                                                    Pecah Non Klaim</option>
                                                <option value="Pecah Klaim"
                                                    {{ old('keterangan') == 'Pecah Klaim' ? 'selected' : null }}>
                                                    Pecah Klaim</option>
                                                <option value="Stok"
                                                    {{ old('keterangan') == 'Stok' ? 'selected' : null }}>
                                                    Stok</option>
                                            </select>
                                        </div>
                                        <div class="form-group" id="perhitungan_klaim3d">
                                            <div class="form-group">
                                                <label for="km_pemasangan">Harga Ban</label>
                                                <input type="text" class="form-control" id="harga3d" readonly
                                                    name="harga" placeholder=""
                                                    value="{{ number_format($banspas3d->harga, 0, ',', '.') }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="km_pemasangan">Target Km</label>
                                                <input type="text" class="form-control" id="" readonly
                                                    name="target_km_ban" placeholder="" value="{{ $banspas3d->target_km_ban }}">
                                            </div>
                                            <div class="form-group" hidden>
                                                <label for="km_pemasangan">KM target</label>
                                                <input type="text" class="form-control" id="km_target3d" readonly
                                                    name="km_target" placeholder=""
                                                    value="{{ $banspas3d->target_km_ban - $banspas3d->km_pemasangan }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="km_terpakai">KM Terpakai</label>
                                                <input type="text" class="form-control" id="km_terpakai3d" readonly
                                                    name="km_terpakai" value="{{ $banspas3d->km_terpakai }}" placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="sisa_harga">Harga Klaim</label>
                                                <input type="text" class="form-control" id="sisa_harga3d" readonly
                                                    name="sisa_harga" placeholder=""
                                                    value="{{ number_format($banspas3d->sisa_harga, 0, ',', '.') }}">
                                            </div>
                                            <div id="pengambilan">
                                                <div class="card-header mb-3">
                                                    <h3 class="card-title">Pengambilan Deposit Sopir</h3>
                                                </div>
                                                <div>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <label for="sisa_saldo">Kode Sopir</label>
                                                            <div class="form-group d-flex">
                                                                <input readonly type="text" hidden class="form-control"
                                                                    id="karyawan_id3d" name="karyawan_id" placeholder=""
                                                                    value="{{ old('karyawan_id') }}">
                                                                <input onclick="showSopir3d(this.value)"
                                                                    class="form-control" id="kode_karyawan3d"
                                                                    name="kode_karyawan" type="text" placeholder=""
                                                                    value="{{ old('kode_karyawan') }}" readonly
                                                                    style="margin-right: 10px; font-size:14px" />
                                                                <button class="btn btn-primary" type="button"
                                                                    onclick="showSopir3d(this.value)">
                                                                    <i class="fas fa-search"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="sisa_saldo">Sisa Saldo</label>
                                                                <input style="text-align: end;margin:right:10px"
                                                                    type="text" class="form-control" id="sisa_saldo3d"
                                                                    readonly name="sisa_saldo"
                                                                    value="{{ old('sisa_saldo') }}" placeholder="">

                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="nama_lengkap">Nama Sopir</label>
                                                                <input readonly type="text" class="form-control"
                                                                    id="nama_lengkap3d" name="nama_lengkap" placeholder=""
                                                                    value="{{ old('nama_lengkap') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="saldo_masuk">Potongan Saldo</label>
                                                                <input style="text-align: end" type="text"
                                                                    class="form-control" readonly id="saldo_keluar3d"
                                                                    name="saldo_keluar" placeholder=""
                                                                    value="{{ old('saldo_keluar') }}">
                                                            </div>
                                                            <hr
                                                                style="border: 2px solid black; display: inline-block; width: 97%; vertical-align: middle;">
                                                            <span
                                                                style="display: inline-block; margin-left: 0px; margin-right: 0; font-size: 18px; vertical-align: middle;">-</span>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="alamat">Keterangan</label>
                                                                <textarea type="text" class="form-control" id="keterangans" name="keterangans" placeholder="Masukan keterangan">{{ old('keterangans') }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="sub_total">Sub Total</label>
                                                                <input style="text-align: end; margin:right:10px"
                                                                    type="text" class="form-control" readonly
                                                                    id="sub_totals3d" name="sub_totals" placeholder=""
                                                                    value="{{ old('sub_totals') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <script>
                                            $(document).ready(function() {
                                                // Definisikan fungsi perhitungan
                                                function hitung() {
                                                    var km_pemasangan = parseInt($('#km_pemasangan3d').val());
                                                    var km_pelepasan = parseInt($('#km_pelepasan3d').val());
                                                    var km_terpakai = km_pelepasan - km_pemasangan;
                                                    $('#km_terpakai3d').val(km_terpakai);
                                                    var km_target = parseFloat($('#km_target3d').val());
                                                    var hargaString = $('#harga3d').val().replaceAll('.', '');
                                                    var harga = parseFloat(hargaString);
                                                    console.log(harga);
                                                    var hasil_persen = km_terpakai / km_target * 100;
                                                    var hasil_harga = harga * hasil_persen / 100;
                                                    // Memperoleh hasil harga yang dibulatkan
                                                    var hasil_harga_bulat = Math.round(hasil_harga);
                                                    var sisa_harga = harga - hasil_harga_bulat;
                                                    var hasil_harga_formatted = sisa_harga.toLocaleString('id-ID');
                                                    $('#sisa_harga3d').val(hasil_harga_formatted);
                                                    $('#saldo_keluar3d').val(hasil_harga_formatted);

                                                    // Hitung selisih antara sisa_saldo dan saldo_keluar
                                                    var sisa_saldo = parseFloat($('#sisa_saldo3d').val().replace(/\D/g, ''));
                                                    var saldo_keluar = parseFloat($('#saldo_keluar3d').val().replace(/\D/g, ''));
                                                    var sub_totals = sisa_saldo - saldo_keluar;
                                                    var formattedSubTotals = sub_totals.toLocaleString('id-ID');
                                                    $('#sub_totals3d').val(formattedSubTotals);
                                                }
                                                // Panggil fungsi perhitungan saat dokumen siap
                                                hitung();
                                                // Panggil fungsi perhitungan saat input berubah
                                                $('#km_pelepasan3d').on('input', function() {
                                                    hitung();
                                                });
                                            });
                                        </script>

                                        <script>
                                            function toggleLabels() {
                                                var keterangan = document.getElementById('keterangan3d');
                                                var perhitungan_klaim = document.getElementById('perhitungan_klaim3d');

                                                if (keterangan.value === 'Pecah Klaim') {
                                                    perhitungan_klaim.style.display = 'block';
                                                } else {
                                                    perhitungan_klaim.style.display = 'none';
                                                }
                                            }

                                            toggleLabels();
                                            document.getElementById('keterangan3d').addEventListener('change', toggleLabels);
                                        </script>
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
                                            <h4>Ban tidak ada !!</h4>
                                            <p>Tidak ada Ban terpasang di axle 3D</p>
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
        @if ($banspas4a != null)
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
                                <form action="{{ url('admin/inquerypelepasan1/' . $kendaraan->id) }}" method="POST"
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
                                            <label for="posisi_ban">Pelepasan Id</label>
                                            <input type="text" class="form-control" readonly
                                                name="pelepasan_ban_id" placeholder=""
                                                value="{{ $inquerypelepasan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="km_pemasangan">Ban Id</label>
                                            <input type="text" class="form-control" id="" name="id_ban"
                                                placeholder="" value="{{ $banspas4a->id }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">Kode Ban</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="kode_ban" placeholder="" value="{{ $banspas4a->kode_ban }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">No Seri</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="no_seri" placeholder="" value="{{ $banspas4a->no_seri }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" readonly id="km_pemasangan4a"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ $banspas4a->km_pemasangan }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pelepasan</label>
                                            <input type="text" class="form-control" id="km_pelepasan4a"
                                                name="km_pelepasan" placeholder="Masukan km pelepasan"
                                                value="{{ old('km_pelepasan') }}">
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label" for="keterangan4a">Keterangan</label>
                                            <select class="form-control" id="keterangan4a" name="keterangan">
                                                <option value="">- Pilih -</option>
                                                <option value="Habis"
                                                    {{ old('keterangan') == 'Habis' ? 'selected' : null }}>
                                                    Habis</option>
                                                <option value="Pecah"
                                                    {{ old('keterangan') == 'Pecah' ? 'selected' : null }}>
                                                    Pecah Non Klaim</option>
                                                <option value="Pecah Klaim"
                                                    {{ old('keterangan') == 'Pecah Klaim' ? 'selected' : null }}>
                                                    Pecah Klaim</option>
                                                <option value="Stok"
                                                    {{ old('keterangan') == 'Stok' ? 'selected' : null }}>
                                                    Stok</option>
                                            </select>
                                        </div>
                                        <div class="form-group" id="perhitungan_klaim4a">
                                            <div class="form-group">
                                                <label for="km_pemasangan">Harga Ban</label>
                                                <input type="text" class="form-control" id="harga4a" readonly
                                                    name="harga" placeholder=""
                                                    value="{{ number_format($banspas4a->harga, 0, ',', '.') }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="km_pemasangan">Target Km</label>
                                                <input type="text" class="form-control" id="" readonly
                                                    name="target_km_ban" placeholder="" value="{{ $banspas4a->target_km_ban }}">
                                            </div>
                                            <div class="form-group" hidden>
                                                <label for="km_pemasangan">KM target</label>
                                                <input type="text" class="form-control" id="km_target4a" readonly
                                                    name="km_target" placeholder=""
                                                    value="{{ $banspas4a->target_km_ban - $banspas4a->km_pemasangan }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="km_terpakai">KM Terpakai</label>
                                                <input type="text" class="form-control" id="km_terpakai4a" readonly
                                                    name="km_terpakai" value="{{ $banspas4a->km_terpakai }}" placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="sisa_harga">Harga Klaim</label>
                                                <input type="text" class="form-control" id="sisa_harga4a" readonly
                                                    name="sisa_harga" placeholder=""
                                                    value="{{ number_format($banspas4a->sisa_harga, 0, ',', '.') }}">
                                            </div>
                                            <div id="pengambilan">
                                                <div class="card-header mb-3">
                                                    <h3 class="card-title">Pengambilan Deposit Sopir</h3>
                                                </div>
                                                <div>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <label for="sisa_saldo">Kode Sopir</label>
                                                            <div class="form-group d-flex">
                                                                <input readonly type="text" hidden class="form-control"
                                                                    id="karyawan_id4a" name="karyawan_id" placeholder=""
                                                                    value="{{ old('karyawan_id') }}">
                                                                <input onclick="showSopir4a(this.value)"
                                                                    class="form-control" id="kode_karyawan4a"
                                                                    name="kode_karyawan" type="text" placeholder=""
                                                                    value="{{ old('kode_karyawan') }}" readonly
                                                                    style="margin-right: 10px; font-size:14px" />
                                                                <button class="btn btn-primary" type="button"
                                                                    onclick="showSopir4a(this.value)">
                                                                    <i class="fas fa-search"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="sisa_saldo">Sisa Saldo</label>
                                                                <input style="text-align: end;margin:right:10px"
                                                                    type="text" class="form-control" id="sisa_saldo4a"
                                                                    readonly name="sisa_saldo"
                                                                    value="{{ old('sisa_saldo') }}" placeholder="">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="nama_lengkap">Nama Sopir</label>
                                                                <input readonly type="text" class="form-control"
                                                                    id="nama_lengkap4a" name="nama_lengkap" placeholder=""
                                                                    value="{{ old('nama_lengkap') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="saldo_masuk">Potongan Saldo</label>
                                                                <input style="text-align: end" type="text"
                                                                    class="form-control" readonly id="saldo_keluar4a"
                                                                    name="saldo_keluar" placeholder=""
                                                                    value="{{ old('saldo_keluar') }}">
                                                            </div>
                                                            <hr
                                                                style="border: 2px solid black; display: inline-block; width: 97%; vertical-align: middle;">
                                                            <span
                                                                style="display: inline-block; margin-left: 0px; margin-right: 0; font-size: 18px; vertical-align: middle;">-</span>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="alamat">Keterangan</label>
                                                                <textarea type="text" class="form-control" id="keterangans" name="keterangans" placeholder="Masukan keterangan">{{ old('keterangans') }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="sub_total">Sub Total</label>
                                                                <input style="text-align: end; margin:right:10px"
                                                                    type="text" class="form-control" readonly
                                                                    id="sub_totals4a" name="sub_totals" placeholder=""
                                                                    value="{{ old('sub_totals') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <script>
                                            $(document).ready(function() {
                                                // Definisikan fungsi perhitungan
                                                function hitung() {
                                                    var km_pemasangan = parseInt($('#km_pemasangan4a').val());
                                                    var km_pelepasan = parseInt($('#km_pelepasan4a').val());
                                                    var km_terpakai = km_pelepasan - km_pemasangan;
                                                    $('#km_terpakai4a').val(km_terpakai);
                                                    var km_target = parseFloat($('#km_target4a').val());
                                                    var hargaString = $('#harga4a').val().replaceAll('.', '');
                                                    var harga = parseFloat(hargaString);
                                                    console.log(harga);
                                                    var hasil_persen = km_terpakai / km_target * 100;
                                                    var hasil_harga = harga * hasil_persen / 100;
                                                    // Memperoleh hasil harga yang dibulatkan
                                                    var hasil_harga_bulat = Math.round(hasil_harga);
                                                    var sisa_harga = harga - hasil_harga_bulat;
                                                    var hasil_harga_formatted = sisa_harga.toLocaleString('id-ID');
                                                    $('#sisa_harga4a').val(hasil_harga_formatted);
                                                    $('#saldo_keluar4a').val(hasil_harga_formatted);

                                                    // Hitung selisih antara sisa_saldo dan saldo_keluar
                                                    var sisa_saldo = parseFloat($('#sisa_saldo4a').val().replace(/\D/g, ''));
                                                    var saldo_keluar = parseFloat($('#saldo_keluar4a').val().replace(/\D/g, ''));
                                                    var sub_totals = sisa_saldo - saldo_keluar;
                                                    var formattedSubTotals = sub_totals.toLocaleString('id-ID');
                                                    $('#sub_totals4a').val(formattedSubTotals);
                                                }
                                                // Panggil fungsi perhitungan saat dokumen siap
                                                hitung();
                                                // Panggil fungsi perhitungan saat input berubah
                                                $('#km_pelepasan4a').on('input', function() {
                                                    hitung();
                                                });
                                            });
                                        </script>

                                        <script>
                                            function toggleLabels() {
                                                var keterangan = document.getElementById('keterangan4a');
                                                var perhitungan_klaim = document.getElementById('perhitungan_klaim4a');

                                                if (keterangan.value === 'Pecah Klaim') {
                                                    perhitungan_klaim.style.display = 'block';
                                                } else {
                                                    perhitungan_klaim.style.display = 'none';
                                                }
                                            }

                                            toggleLabels();
                                            document.getElementById('keterangan4a').addEventListener('change', toggleLabels);
                                        </script>
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
                                            <h4>Ban tidak ada !!</h4>
                                            <p>Tidak ada Ban terpasang di axle 4A</p>
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
        @if ($banspas4b != null)
            <div class="modal fade" id="modal-exle_4B-{{ $kendaraan->id }}">
                <div class="modal-dialog" style="max-width: 90%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 4B</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="{{ url('admin/inquerypelepasan1/' . $kendaraan->id) }}" method="POST"
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
                                            <label for="posisi_ban">Pelepasan Id</label>
                                            <input type="text" class="form-control" readonly
                                                name="pelepasan_ban_id" placeholder=""
                                                value="{{ $inquerypelepasan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="km_pemasangan">Ban Id</label>
                                            <input type="text" class="form-control" id="" name="id_ban"
                                                placeholder="" value="{{ $banspas4b->id }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">Kode Ban</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="kode_ban" placeholder="" value="{{ $banspas4b->kode_ban }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">No Seri</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="no_seri" placeholder="" value="{{ $banspas4b->no_seri }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" readonly id="km_pemasangan4b"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ $banspas4b->km_pemasangan }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pelepsan</label>
                                            <input type="text" class="form-control" id="km_pelepasan4b"
                                                name="km_pelepasan" placeholder="Masukan km pelepasan"
                                                value="{{ old('km_pelepasan') }}">
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label" for="keterangan4b">Keterangan</label>
                                            <select class="form-control" id="keterangan4b" name="keterangan">
                                                <option value="">- Pilih -</option>
                                                <option value="Habis"
                                                    {{ old('keterangan') == 'Habis' ? 'selected' : null }}>
                                                    Habis</option>
                                                <option value="Pecah"
                                                    {{ old('keterangan') == 'Pecah' ? 'selected' : null }}>
                                                    Pecah Non Klaim</option>
                                                <option value="Pecah Klaim"
                                                    {{ old('keterangan') == 'Pecah Klaim' ? 'selected' : null }}>
                                                    Pecah Klaim</option>
                                                <option value="Stok"
                                                    {{ old('keterangan') == 'Stok' ? 'selected' : null }}>
                                                    Stok</option>
                                            </select>
                                        </div>
                                        <div class="form-group" id="perhitungan_klaim4b">
                                            <div class="form-group">
                                                <label for="km_pemasangan">Harga Ban</label>
                                                <input type="text" class="form-control" id="harga4b" readonly
                                                    name="harga" placeholder=""
                                                    value="{{ number_format($banspas4b->harga, 0, ',', '.') }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="km_pemasangan">Target Km</label>
                                                <input type="text" class="form-control" id="" readonly
                                                    name="target_km_ban" placeholder="" value="{{ $banspas4b->target_km_ban }}">
                                            </div>
                                            <div class="form-group" hidden>
                                                <label for="km_pemasangan">KM target</label>
                                                <input type="text" class="form-control" id="km_target4b" readonly
                                                    name="km_target" placeholder=""
                                                    value="{{ $banspas4b->target_km_ban - $banspas4b->km_pemasangan }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="km_terpakai">KM Terpakai</label>
                                                <input type="text" class="form-control" id="km_terpakai4b" readonly
                                                    name="km_terpakai" value="{{ $banspas4b->km_terpakai }}" placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="sisa_harga">Harga Klaim</label>
                                                <input type="text" class="form-control" id="sisa_harga4b" readonly
                                                    name="sisa_harga" placeholder=""
                                                    value="{{ number_format($banspas4b->sisa_harga, 0, ',', '.') }}">
                                            </div>
                                            <div id="pengambilan">
                                                <div class="card-header mb-3">
                                                    <h3 class="card-title">Pengambilan Deposit Sopir</h3>
                                                </div>
                                                <div>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <label for="sisa_saldo">Kode Sopir</label>
                                                            <div class="form-group d-flex">
                                                                <input readonly type="text" hidden class="form-control"
                                                                    id="karyawan_id4b" name="karyawan_id" placeholder=""
                                                                    value="{{ old('karyawan_id') }}">
                                                                <input onclick="showSopir4b(this.value)"
                                                                    class="form-control" id="kode_karyawan4b"
                                                                    name="kode_karyawan" type="text" placeholder=""
                                                                    value="{{ old('kode_karyawan') }}" readonly
                                                                    style="margin-right: 10px; font-size:14px" />
                                                                <button class="btn btn-primary" type="button"
                                                                    onclick="showSopir4b(this.value)">
                                                                    <i class="fas fa-search"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="sisa_saldo">Sisa Saldo</label>
                                                                <input style="text-align: end;margin:right:10px"
                                                                    type="text" class="form-control" id="sisa_saldo4b"
                                                                    readonly name="sisa_saldo"
                                                                    value="{{ old('sisa_saldo') }}" placeholder="">

                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="nama_lengkap">Nama Sopir</label>
                                                                <input readonly type="text" class="form-control"
                                                                    id="nama_lengkap4b" name="nama_lengkap" placeholder=""
                                                                    value="{{ old('nama_lengkap') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="saldo_masuk">Potongan Saldo</label>
                                                                <input style="text-align: end" type="text"
                                                                    class="form-control" readonly id="saldo_keluar4b"
                                                                    name="saldo_keluar" placeholder=""
                                                                    value="{{ old('saldo_keluar') }}">
                                                            </div>
                                                            <hr
                                                                style="border: 2px solid black; display: inline-block; width: 97%; vertical-align: middle;">
                                                            <span
                                                                style="display: inline-block; margin-left: 0px; margin-right: 0; font-size: 18px; vertical-align: middle;">-</span>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="alamat">Keterangan</label>
                                                                <textarea type="text" class="form-control" id="keterangans" name="keterangans" placeholder="Masukan keterangan">{{ old('keterangans') }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="sub_total">Sub Total</label>
                                                                <input style="text-align: end; margin:right:10px"
                                                                    type="text" class="form-control" readonly
                                                                    id="sub_totals4b" name="sub_totals" placeholder=""
                                                                    value="{{ old('sub_totals') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <script>
                                            $(document).ready(function() {
                                                // Definisikan fungsi perhitungan
                                                function hitung() {
                                                    var km_pemasangan = parseInt($('#km_pemasangan4b').val());
                                                    var km_pelepasan = parseInt($('#km_pelepasan4b').val());
                                                    var km_terpakai = km_pelepasan - km_pemasangan;
                                                    $('#km_terpakai4b').val(km_terpakai);
                                                    var km_target = parseFloat($('#km_target4b').val());
                                                    var hargaString = $('#harga4b').val().replaceAll('.', '');
                                                    var harga = parseFloat(hargaString);
                                                    console.log(harga);
                                                    var hasil_persen = km_terpakai / km_target * 100;
                                                    var hasil_harga = harga * hasil_persen / 100;
                                                    // Memperoleh hasil harga yang dibulatkan
                                                    var hasil_harga_bulat = Math.round(hasil_harga);
                                                    var sisa_harga = harga - hasil_harga_bulat;
                                                    var hasil_harga_formatted = sisa_harga.toLocaleString('id-ID');
                                                    $('#sisa_harga4b').val(hasil_harga_formatted);
                                                    $('#saldo_keluar4b').val(hasil_harga_formatted);

                                                    // Hitung selisih antara sisa_saldo dan saldo_keluar
                                                    var sisa_saldo = parseFloat($('#sisa_saldo4b').val().replace(/\D/g, ''));
                                                    var saldo_keluar = parseFloat($('#saldo_keluar4b').val().replace(/\D/g, ''));
                                                    var sub_totals = sisa_saldo - saldo_keluar;
                                                    var formattedSubTotals = sub_totals.toLocaleString('id-ID');
                                                    $('#sub_totals4b').val(formattedSubTotals);
                                                }
                                                // Panggil fungsi perhitungan saat dokumen siap
                                                hitung();
                                                // Panggil fungsi perhitungan saat input berubah
                                                $('#km_pelepasan4b').on('input', function() {
                                                    hitung();
                                                });
                                            });
                                        </script>

                                        <script>
                                            function toggleLabels() {
                                                var keterangan = document.getElementById('keterangan4b');
                                                var perhitungan_klaim = document.getElementById('perhitungan_klaim4b');

                                                if (keterangan.value === 'Pecah Klaim') {
                                                    perhitungan_klaim.style.display = 'block';
                                                } else {
                                                    perhitungan_klaim.style.display = 'none';
                                                }
                                            }

                                            toggleLabels();
                                            document.getElementById('keterangan4b').addEventListener('change', toggleLabels);
                                        </script>
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
                                            <h4>Ban tidak ada !!</h4>
                                            <p>Tidak ada Ban terpasang di axle 4B</p>
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
        @if ($banspas4c != null)
            <div class="modal fade" id="modal-exle_4C-{{ $kendaraan->id }}">
                <div class="modal-dialog" style="max-width: 90%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 4C</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="{{ url('admin/inquerypelepasan1/' . $kendaraan->id) }}" method="POST"
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
                                            <label for="posisi_ban">Pelepasan Id</label>
                                            <input type="text" class="form-control" readonly
                                                name="pelepasan_ban_id" placeholder=""
                                                value="{{ $inquerypelepasan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="km_pemasangan">Ban Id</label>
                                            <input type="text" class="form-control" id="" name="id_ban"
                                                placeholder="" value="{{ $banspas4c->id }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">Kode Ban</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="kode_ban" placeholder="" value="{{ $banspas4c->kode_ban }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">No Seri</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="no_seri" placeholder="" value="{{ $banspas4c->no_seri }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" readonly id="km_pemasangan4c"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ $banspas4c->km_pemasangan }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pelepasan</label>
                                            <input type="text" class="form-control" id="km_pelepasan4c"
                                                name="km_pelepasan" placeholder="Masukan km pelepasan"
                                                value="{{ old('km_pelepasan') }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="warna">Keterangan</label>
                                            <select class="form-control" id="keterangan4c" name="keterangan">
                                                <option value="">- Pilih -</option>
                                                <option value="Habis"
                                                    {{ old('keterangan') == 'Habis' ? 'selected' : null }}>
                                                    Habis</option>
                                                <option value="Pecah"
                                                    {{ old('keterangan') == 'Pecah' ? 'selected' : null }}>
                                                    Pecah Non Klaim</option>
                                                <option value="Pecah Klaim"
                                                    {{ old('keterangan') == 'Pecah Klaim' ? 'selected' : null }}>
                                                    Pecah Klaim</option>
                                                <option value="Stok"
                                                    {{ old('keterangan') == 'Stok' ? 'selected' : null }}>
                                                    Stok</option>
                                            </select>
                                        </div>
                                        <div class="form-group" id="perhitungan_klaim4c">
                                            <div class="form-group">
                                                <label for="km_pemasangan">Harga Ban</label>
                                                <input type="text" class="form-control" id="harga4c" readonly
                                                    name="harga" placeholder=""
                                                    value="{{ number_format($banspas4c->harga, 0, ',', '.') }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="km_pemasangan">Target Km</label>
                                                <input type="text" class="form-control" id="" readonly
                                                    name="target_km_ban" placeholder="" value="{{ $banspas4c->target_km_ban }}">
                                            </div>
                                            <div class="form-group" hidden>
                                                <label for="km_pemasangan">KM target</label>
                                                <input type="text" class="form-control" id="km_target4c" readonly
                                                    name="km_target" placeholder=""
                                                    value="{{ $banspas4c->target_km_ban - $banspas4c->km_pemasangan }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="km_terpakai">KM Terpakai</label>
                                                <input type="text" class="form-control" id="km_terpakai4c" readonly
                                                    name="km_terpakai" value="{{ $banspas4c->km_terpakai }}" placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="sisa_harga">Harga Klaim</label>
                                                <input type="text" class="form-control" id="sisa_harga4c" readonly
                                                    name="sisa_harga" placeholder=""
                                                    value="{{ number_format($banspas4c->sisa_harga, 0, ',', '.') }}">
                                            </div>
                                            <div id="pengambilan">
                                                <div class="card-header mb-3">
                                                    <h3 class="card-title">Pengambilan Deposit Sopir</h3>
                                                </div>
                                                <div>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <label for="sisa_saldo">Kode Sopir</label>
                                                            <div class="form-group d-flex">
                                                                <input readonly type="text" hidden class="form-control"
                                                                    id="karyawan_id4c" name="karyawan_id" placeholder=""
                                                                    value="{{ old('karyawan_id') }}">
                                                                <input onclick="showSopir4c(this.value)"
                                                                    class="form-control" id="kode_karyawan4c"
                                                                    name="kode_karyawan" type="text" placeholder=""
                                                                    value="{{ old('kode_karyawan') }}" readonly
                                                                    style="margin-right: 10px; font-size:14px" />
                                                                <button class="btn btn-primary" type="button"
                                                                    onclick="showSopir4c(this.value)">
                                                                    <i class="fas fa-search"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="sisa_saldo">Sisa Saldo</label>
                                                                <input style="text-align: end;margin:right:10px"
                                                                    type="text" class="form-control" id="sisa_saldo4c"
                                                                    readonly name="sisa_saldo"
                                                                    value="{{ old('sisa_saldo') }}" placeholder="">

                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="nama_lengkap">Nama Sopir</label>
                                                                <input readonly type="text" class="form-control"
                                                                    id="nama_lengkap4c" name="nama_lengkap" placeholder=""
                                                                    value="{{ old('nama_lengkap') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="saldo_masuk">Potongan Saldo</label>
                                                                <input style="text-align: end" type="text"
                                                                    class="form-control" readonly id="saldo_keluar4c"
                                                                    name="saldo_keluar" placeholder=""
                                                                    value="{{ old('saldo_keluar') }}">
                                                            </div>
                                                            <hr
                                                                style="border: 2px solid black; display: inline-block; width: 97%; vertical-align: middle;">
                                                            <span
                                                                style="display: inline-block; margin-left: 0px; margin-right: 0; font-size: 18px; vertical-align: middle;">-</span>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="alamat">Keterangan</label>
                                                                <textarea type="text" class="form-control" id="keterangans" name="keterangans" placeholder="Masukan keterangan">{{ old('keterangans') }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="sub_total">Sub Total</label>
                                                                <input style="text-align: end; margin:right:10px"
                                                                    type="text" class="form-control" readonly
                                                                    id="sub_totals4c" name="sub_totals" placeholder=""
                                                                    value="{{ old('sub_totals') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <script>
                                            $(document).ready(function() {
                                                // Definisikan fungsi perhitungan
                                                function hitung() {
                                                    var km_pemasangan = parseInt($('#km_pemasangan4c').val());
                                                    var km_pelepasan = parseInt($('#km_pelepasan4c').val());
                                                    var km_terpakai = km_pelepasan - km_pemasangan;
                                                    $('#km_terpakai4c').val(km_terpakai);
                                                    var km_target = parseFloat($('#km_target4c').val());
                                                    var hargaString = $('#harga4c').val().replaceAll('.', '');
                                                    var harga = parseFloat(hargaString);
                                                    console.log(harga);
                                                    var hasil_persen = km_terpakai / km_target * 100;
                                                    var hasil_harga = harga * hasil_persen / 100;
                                                    // Memperoleh hasil harga yang dibulatkan
                                                    var hasil_harga_bulat = Math.round(hasil_harga);
                                                    var sisa_harga = harga - hasil_harga_bulat;
                                                    var hasil_harga_formatted = sisa_harga.toLocaleString('id-ID');
                                                    $('#sisa_harga4c').val(hasil_harga_formatted);
                                                    $('#saldo_keluar4c').val(hasil_harga_formatted);

                                                    // Hitung selisih antara sisa_saldo dan saldo_keluar
                                                    var sisa_saldo = parseFloat($('#sisa_saldo4c').val().replace(/\D/g, ''));
                                                    var saldo_keluar = parseFloat($('#saldo_keluar4c').val().replace(/\D/g, ''));
                                                    var sub_totals = sisa_saldo - saldo_keluar;
                                                    var formattedSubTotals = sub_totals.toLocaleString('id-ID');
                                                    $('#sub_totals4c').val(formattedSubTotals);
                                                }
                                                // Panggil fungsi perhitungan saat dokumen siap
                                                hitung();
                                                // Panggil fungsi perhitungan saat input berubah
                                                $('#km_pelepasan4c').on('input', function() {
                                                    hitung();
                                                });
                                            });
                                        </script>

                                        <script>
                                            function toggleLabels() {
                                                var keterangan = document.getElementById('keterangan4c');
                                                var perhitungan_klaim = document.getElementById('perhitungan_klaim4c');

                                                if (keterangan.value === 'Pecah Klaim') {
                                                    perhitungan_klaim.style.display = 'block';
                                                } else {
                                                    perhitungan_klaim.style.display = 'none';
                                                }
                                            }

                                            toggleLabels();
                                            document.getElementById('keterangan4c').addEventListener('change', toggleLabels);
                                        </script>
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
                                            <h4>Ban tidak ada !!</h4>
                                            <p>Tidak ada Ban terpasang di axle 4C</p>
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
        @if ($banspas4d != null)
            <div class="modal fade" id="modal-exle_4D-{{ $kendaraan->id }}">
                <div class="modal-dialog" style="max-width: 90%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 4D</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="{{ url('admin/inquerypelepasan1/' . $kendaraan->id) }}" method="POST"
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
                                            <label for="posisi_ban">Pelepasan Id</label>
                                            <input type="text" class="form-control" readonly
                                                name="pelepasan_ban_id" placeholder=""
                                                value="{{ $inquerypelepasan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="km_pemasangan">Ban Id</label>
                                            <input type="text" class="form-control" id="" name="id_ban"
                                                placeholder="" value="{{ $banspas4d->id }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">Kode Ban</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="kode_ban" placeholder="" value="{{ $banspas4d->kode_ban }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">No Seri</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="no_seri" placeholder="" value="{{ $banspas4d->no_seri }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" readonly id="km_pemasangan4d"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ $banspas4d->km_pemasangan }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pelepasan</label>
                                            <input type="text" class="form-control" id="km_pelepasan4d"
                                                name="km_pelepasan" placeholder="Masukan km pelepasan"
                                                value="{{ old('km_pelepasan') }}">
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label" for="keterangan4d">Keterangan</label>
                                            <select class="form-control" id="keterangan4d" name="keterangan">
                                                <option value="">- Pilih -</option>
                                                <option value="Habis"
                                                    {{ old('keterangan') == 'Habis' ? 'selected' : null }}>
                                                    Habis</option>
                                                <option value="Pecah"
                                                    {{ old('keterangan') == 'Pecah' ? 'selected' : null }}>
                                                    Pecah Non Klaim</option>
                                                <option value="Pecah Klaim"
                                                    {{ old('keterangan') == 'Pecah Klaim' ? 'selected' : null }}>
                                                    Pecah Klaim</option>
                                                <option value="Stok"
                                                    {{ old('keterangan') == 'Stok' ? 'selected' : null }}>
                                                    Stok</option>
                                            </select>
                                        </div>
                                         <div class="form-group" id="perhitungan_klaim4a">
                                            <div class="form-group">
                                                <label for="km_pemasangan">Harga Ban</label>
                                                <input type="text" class="form-control" id="harga4d" readonly
                                                    name="harga" placeholder=""
                                                    value="{{ number_format($banspas4d->harga, 0, ',', '.') }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="km_pemasangan">Target Km</label>
                                                <input type="text" class="form-control" id="" readonly
                                                    name="target_km_ban" placeholder="" value="{{ $banspas4d->target_km_ban }}">
                                            </div>
                                            <div class="form-group" hidden>
                                                <label for="km_pemasangan">KM target</label>
                                                <input type="text" class="form-control" id="km_target4d" readonly
                                                    name="km_target" placeholder=""
                                                    value="{{ $banspas4d->target_km_ban - $banspas4d->km_pemasangan }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="km_terpakai">KM Terpakai</label>
                                                <input type="text" class="form-control" id="km_terpakai4d" readonly
                                                    name="km_terpakai" value="{{ $banspas4d->km_terpakai }}" placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="sisa_harga">Harga Klaim</label>
                                                <input type="text" class="form-control" id="sisa_harga4d" readonly
                                                    name="sisa_harga" placeholder=""
                                                    value="{{ number_format($banspas4d->sisa_harga, 0, ',', '.') }}">
                                            </div>
                                            <div id="pengambilan">
                                                <div class="card-header mb-3">
                                                    <h3 class="card-title">Pengambilan Deposit Sopir</h3>
                                                </div>
                                                <div>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <label for="sisa_saldo">Kode Sopir</label>
                                                            <div class="form-group d-flex">
                                                                <input readonly type="text" hidden class="form-control"
                                                                    id="karyawan_id4d" name="karyawan_id" placeholder=""
                                                                    value="{{ old('karyawan_id') }}">
                                                                <input onclick="showSopir4d(this.value)"
                                                                    class="form-control" id="kode_karyawan4d"
                                                                    name="kode_karyawan" type="text" placeholder=""
                                                                    value="{{ old('kode_karyawan') }}" readonly
                                                                    style="margin-right: 10px; font-size:14px" />
                                                                <button class="btn btn-primary" type="button"
                                                                    onclick="showSopir4d(this.value)">
                                                                    <i class="fas fa-search"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="sisa_saldo">Sisa Saldo</label>
                                                                <input style="text-align: end;margin:right:10px"
                                                                    type="text" class="form-control" id="sisa_saldo4d"
                                                                    readonly name="sisa_saldo"
                                                                    value="{{ old('sisa_saldo') }}" placeholder="">

                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="nama_lengkap">Nama Sopir</label>
                                                                <input readonly type="text" class="form-control"
                                                                    id="nama_lengkap4d" name="nama_lengkap" placeholder=""
                                                                    value="{{ old('nama_lengkap') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="saldo_masuk">Potongan Saldo</label>
                                                                <input style="text-align: end" type="text"
                                                                    class="form-control" readonly id="saldo_keluar4d"
                                                                    name="saldo_keluar" placeholder=""
                                                                    value="{{ old('saldo_keluar') }}">
                                                            </div>
                                                            <hr
                                                                style="border: 2px solid black; display: inline-block; width: 97%; vertical-align: middle;">
                                                            <span
                                                                style="display: inline-block; margin-left: 0px; margin-right: 0; font-size: 18px; vertical-align: middle;">-</span>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="alamat">Keterangan</label>
                                                                <textarea type="text" class="form-control" id="keterangans" name="keterangans" placeholder="Masukan keterangan">{{ old('keterangans') }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="sub_total">Sub Total</label>
                                                                <input style="text-align: end; margin:right:10px"
                                                                    type="text" class="form-control" readonly
                                                                    id="sub_totals4d" name="sub_totals" placeholder=""
                                                                    value="{{ old('sub_totals') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <script>
                                            $(document).ready(function() {
                                                // Definisikan fungsi perhitungan
                                                function hitung() {
                                                    var km_pemasangan = parseInt($('#km_pemasangan4d').val());
                                                    var km_pelepasan = parseInt($('#km_pelepasan4d').val());
                                                    var km_terpakai = km_pelepasan - km_pemasangan;
                                                    $('#km_terpakai4d').val(km_terpakai);
                                                    var km_target = parseFloat($('#km_target4d').val());
                                                    var hargaString = $('#harga4d').val().replaceAll('.', '');
                                                    var harga = parseFloat(hargaString);
                                                    console.log(harga);
                                                    var hasil_persen = km_terpakai / km_target * 100;
                                                    var hasil_harga = harga * hasil_persen / 100;
                                                    // Memperoleh hasil harga yang dibulatkan
                                                    var hasil_harga_bulat = Math.round(hasil_harga);
                                                    var sisa_harga = harga - hasil_harga_bulat;
                                                    var hasil_harga_formatted = sisa_harga.toLocaleString('id-ID');
                                                    $('#sisa_harga4d').val(hasil_harga_formatted);
                                                    $('#saldo_keluar4d').val(hasil_harga_formatted);

                                                    // Hitung selisih antara sisa_saldo dan saldo_keluar
                                                    var sisa_saldo = parseFloat($('#sisa_saldo4d').val().replace(/\D/g, ''));
                                                    var saldo_keluar = parseFloat($('#saldo_keluar4d').val().replace(/\D/g, ''));
                                                    var sub_totals = sisa_saldo - saldo_keluar;
                                                    var formattedSubTotals = sub_totals.toLocaleString('id-ID');
                                                    $('#sub_totals4d').val(formattedSubTotals);
                                                }
                                                // Panggil fungsi perhitungan saat dokumen siap
                                                hitung();
                                                // Panggil fungsi perhitungan saat input berubah
                                                $('#km_pelepasan4d').on('input', function() {
                                                    hitung();
                                                });
                                            });
                                        </script>

                                        <script>
                                            function toggleLabels() {
                                                var keterangan = document.getElementById('keterangan4d');
                                                var perhitungan_klaim = document.getElementById('perhitungan_klaim4d');

                                                if (keterangan.value === 'Pecah Klaim') {
                                                    perhitungan_klaim.style.display = 'block';
                                                } else {
                                                    perhitungan_klaim.style.display = 'none';
                                                }
                                            }

                                            toggleLabels();
                                            document.getElementById('keterangan4d').addEventListener('change', toggleLabels);
                                        </script>
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
                                            <h4>Ban tidak ada !!</h4>
                                            <p>Tidak ada Ban terpasang di axle 4D</p>
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
        @if ($banspas5a != null)
            <div class="modal fade" id="modal-exle_5A-{{ $kendaraan->id }}">
                <div class="modal-dialog" style="max-width: 90%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 5A</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="{{ url('admin/inquerypelepasan1/' . $kendaraan->id) }}" method="POST"
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
                                            <label for="posisi_ban">Pelepasan Id</label>
                                            <input type="text" class="form-control" readonly
                                                name="pelepasan_ban_id" placeholder=""
                                                value="{{ $inquerypelepasan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="km_pemasangan">Ban Id</label>
                                            <input type="text" class="form-control" id="" name="id_ban"
                                                placeholder="" value="{{ $banspas5a->id }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Kode Ban</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="kode_ban" placeholder="" value="{{ $banspas5a->kode_ban }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">No Seri</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="no_seri" placeholder="" value="{{ $banspas5a->no_seri }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" readonly id="km_pemasangan5a"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ $banspas5a->km_pemasangan }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pelepasan</label>
                                            <input type="text" class="form-control" id="km_pelepasan5a"
                                                name="km_pelepasan" placeholder="Masukan km pelepasan"
                                                value="{{ old('km_pelepasan') }}">
                                        </div>
                                                                               <div class="form-group">
                                            <label class="form-label" for="keterangan5a">Keterangan</label>
                                            <select class="form-control" id="keterangan5a" name="keterangan">
                                                <option value="">- Pilih -</option>
                                                <option value="Habis"
                                                    {{ old('keterangan') == 'Habis' ? 'selected' : null }}>
                                                    Habis</option>
                                                <option value="Pecah"
                                                    {{ old('keterangan') == 'Pecah' ? 'selected' : null }}>
                                                    Pecah Non Klaim</option>
                                                <option value="Pecah Klaim"
                                                    {{ old('keterangan') == 'Pecah Klaim' ? 'selected' : null }}>
                                                    Pecah Klaim</option>
                                                <option value="Stok"
                                                    {{ old('keterangan') == 'Stok' ? 'selected' : null }}>
                                                    Stok</option>
                                            </select>
                                        </div>
                                        <div class="form-group" id="perhitungan_klaim5a">
                                            <div class="form-group">
                                                <label for="km_pemasangan">Harga Ban</label>
                                                <input type="text" class="form-control" id="harga5a" readonly
                                                    name="harga" placeholder=""
                                                    value="{{ number_format($banspas5a->harga, 0, ',', '.') }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="km_pemasangan">Target Km</label>
                                                <input type="text" class="form-control" id="" readonly
                                                    name="target_km_ban" placeholder="" value="{{ $banspas5a->target_km_ban }}">
                                            </div>
                                            <div class="form-group" hidden>
                                                <label for="km_pemasangan">KM target</label>
                                                <input type="text" class="form-control" id="km_target5a" readonly
                                                    name="km_target" placeholder=""
                                                    value="{{ $banspas5a->target_km_ban - $banspas5a->km_pemasangan }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="km_terpakai">KM Terpakai</label>
                                                <input type="text" class="form-control" id="km_terpakai5a" readonly
                                                    name="km_terpakai" value="{{ $banspas5a->km_terpakai }}" placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="sisa_harga">Harga Klaim</label>
                                                <input type="text" class="form-control" id="sisa_harga5a" readonly
                                                    name="sisa_harga" placeholder=""
                                                    value="{{ number_format($banspas5a->sisa_harga, 0, ',', '.') }}">
                                            </div>
                                            <div id="pengambilan">
                                                <div class="card-header mb-3">
                                                    <h3 class="card-title">Pengambilan Deposit Sopir</h3>
                                                </div>
                                                <div>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <label for="sisa_saldo">Kode Sopir</label>
                                                            <div class="form-group d-flex">
                                                                <input readonly type="text" hidden class="form-control"
                                                                    id="karyawan_id5a" name="karyawan_id" placeholder=""
                                                                    value="{{ old('karyawan_id') }}">
                                                                <input onclick="showSopir5a(this.value)"
                                                                    class="form-control" id="kode_karyawan5a"
                                                                    name="kode_karyawan" type="text" placeholder=""
                                                                    value="{{ old('kode_karyawan') }}" readonly
                                                                    style="margin-right: 10px; font-size:14px" />
                                                                <button class="btn btn-primary" type="button"
                                                                    onclick="showSopir5a(this.value)">
                                                                    <i class="fas fa-search"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="sisa_saldo">Sisa Saldo</label>
                                                                <input style="text-align: end;margin:right:10px"
                                                                    type="text" class="form-control" id="sisa_saldo5a"
                                                                    readonly name="sisa_saldo"
                                                                    value="{{ old('sisa_saldo') }}" placeholder="">

                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="nama_lengkap">Nama Sopir</label>
                                                                <input readonly type="text" class="form-control"
                                                                    id="nama_lengkap5a" name="nama_lengkap" placeholder=""
                                                                    value="{{ old('nama_lengkap') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="saldo_masuk">Potongan Saldo</label>
                                                                <input style="text-align: end" type="text"
                                                                    class="form-control" readonly id="saldo_keluar5a"
                                                                    name="saldo_keluar" placeholder=""
                                                                    value="{{ old('saldo_keluar') }}">
                                                            </div>
                                                            <hr
                                                                style="border: 2px solid black; display: inline-block; width: 97%; vertical-align: middle;">
                                                            <span
                                                                style="display: inline-block; margin-left: 0px; margin-right: 0; font-size: 18px; vertical-align: middle;">-</span>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="alamat">Keterangan</label>
                                                                <textarea type="text" class="form-control" id="keterangans" name="keterangans" placeholder="Masukan keterangan">{{ old('keterangans') }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="sub_total">Sub Total</label>
                                                                <input style="text-align: end; margin:right:10px"
                                                                    type="text" class="form-control" readonly
                                                                    id="sub_totals5a" name="sub_totals" placeholder=""
                                                                    value="{{ old('sub_totals') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <script>
                                            $(document).ready(function() {
                                                // Definisikan fungsi perhitungan
                                                function hitung() {
                                                    var km_pemasangan = parseInt($('#km_pemasangan5a').val());
                                                    var km_pelepasan = parseInt($('#km_pelepasan5a').val());
                                                    var km_terpakai = km_pelepasan - km_pemasangan;
                                                    $('#km_terpakai5a').val(km_terpakai);
                                                    var km_target = parseFloat($('#km_target5a').val());
                                                    var hargaString = $('#harga5a').val().replaceAll('.', '');
                                                    var harga = parseFloat(hargaString);
                                                    console.log(harga);
                                                    var hasil_persen = km_terpakai / km_target * 100;
                                                    var hasil_harga = harga * hasil_persen / 100;
                                                    // Memperoleh hasil harga yang dibulatkan
                                                    var hasil_harga_bulat = Math.round(hasil_harga);
                                                    var sisa_harga = harga - hasil_harga_bulat;
                                                    var hasil_harga_formatted = sisa_harga.toLocaleString('id-ID');
                                                    $('#sisa_harga5a').val(hasil_harga_formatted);
                                                    $('#saldo_keluar5a').val(hasil_harga_formatted);

                                                    // Hitung selisih antara sisa_saldo dan saldo_keluar
                                                    var sisa_saldo = parseFloat($('#sisa_saldo5a').val().replace(/\D/g, ''));
                                                    var saldo_keluar = parseFloat($('#saldo_keluar5a').val().replace(/\D/g, ''));
                                                    var sub_totals = sisa_saldo - saldo_keluar;
                                                    var formattedSubTotals = sub_totals.toLocaleString('id-ID');
                                                    $('#sub_totals5a').val(formattedSubTotals);
                                                }
                                                // Panggil fungsi perhitungan saat dokumen siap
                                                hitung();
                                                // Panggil fungsi perhitungan saat input berubah
                                                $('#km_pelepasan5a').on('input', function() {
                                                    hitung();
                                                });
                                            });
                                        </script>

                                        <script>
                                            function toggleLabels() {
                                                var keterangan = document.getElementById('keterangan5a');
                                                var perhitungan_klaim = document.getElementById('perhitungan_klaim5a');

                                                if (keterangan.value === 'Pecah Klaim') {
                                                    perhitungan_klaim.style.display = 'block';
                                                } else {
                                                    perhitungan_klaim.style.display = 'none';
                                                }
                                            }

                                            toggleLabels();
                                            document.getElementById('keterangan5a').addEventListener('change', toggleLabels);
                                        </script>
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
                                            <h4>Ban tidak ada !!</h4>
                                            <p>Tidak ada Ban terpasang di axle 5A</p>
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
        @if ($banspas5b != null)
            <div class="modal fade" id="modal-exle_5B-{{ $kendaraan->id }}">
                <div class="modal-dialog" style="max-width: 90%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 5B</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="{{ url('admin/inquerypelepasan1/' . $kendaraan->id) }}" method="POST"
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
                                            <label for="posisi_ban">Pelepasan Id</label>
                                            <input type="text" class="form-control" readonly
                                                name="pelepasan_ban_id" placeholder=""
                                                value="{{ $inquerypelepasan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="km_pemasangan">Ban Id</label>
                                            <input type="text" class="form-control" id="" name="id_ban"
                                                placeholder="" value="{{ $banspas5b->id }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Kode Ban</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="kode_ban" placeholder="" value="{{ $banspas5b->kode_ban }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">No Seri</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="no_seri" placeholder="" value="{{ $banspas5b->no_seri }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" readonly id="km_pemasangan5b"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ $banspas5b->km_pemasangan }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pelepasan</label>
                                            <input type="text" class="form-control" id="km_pelepasan5b"
                                                name="km_pelepasan" placeholder="Masukan km pelepasan"
                                                value="{{ old('km_pelepasan') }}">
                                        </div>
                                       <div class="form-group">
                                            <label class="form-label" for="keterangan5b">Keterangan</label>
                                            <select class="form-control" id="keterangan5b" name="keterangan">
                                                <option value="">- Pilih -</option>
                                                <option value="Habis"
                                                    {{ old('keterangan') == 'Habis' ? 'selected' : null }}>
                                                    Habis</option>
                                                <option value="Pecah"
                                                    {{ old('keterangan') == 'Pecah' ? 'selected' : null }}>
                                                    Pecah Non Klaim</option>
                                                <option value="Pecah Klaim"
                                                    {{ old('keterangan') == 'Pecah Klaim' ? 'selected' : null }}>
                                                    Pecah Klaim</option>
                                                <option value="Stok"
                                                    {{ old('keterangan') == 'Stok' ? 'selected' : null }}>
                                                    Stok</option>
                                            </select>
                                        </div>
                                        <div class="form-group" id="perhitungan_klaim5b">
                                            <div class="form-group">
                                                <label for="km_pemasangan">Harga Ban</label>
                                                <input type="text" class="form-control" id="harga5b" readonly
                                                    name="harga" placeholder=""
                                                    value="{{ number_format($banspas5b->harga, 0, ',', '.') }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="km_pemasangan">Target Km</label>
                                                <input type="text" class="form-control" id="" readonly
                                                    name="target_km_ban" placeholder="" value="{{ $banspas5b->target_km_ban }}">
                                            </div>
                                            <div class="form-group" hidden>
                                                <label for="km_pemasangan">KM target</label>
                                                <input type="text" class="form-control" id="km_target5b" readonly
                                                    name="km_target" placeholder=""
                                                    value="{{ $banspas5b->target_km_ban - $banspas5b->km_pemasangan }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="km_terpakai">KM Terpakai</label>
                                                <input type="text" class="form-control" id="km_terpakai5b" readonly
                                                    name="km_terpakai" value="{{ $banspas5b->km_terpakai }}" placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="sisa_harga">Harga Klaim</label>
                                                <input type="text" class="form-control" id="sisa_harga5b" readonly
                                                    name="sisa_harga" placeholder=""
                                                    value="{{ number_format($banspas5b->sisa_harga, 0, ',', '.') }}">
                                            </div>
                                            <div id="pengambilan">
                                                <div class="card-header mb-3">
                                                    <h3 class="card-title">Pengambilan Deposit Sopir</h3>
                                                </div>
                                                <div>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <label for="sisa_saldo">Kode Sopir</label>
                                                            <div class="form-group d-flex">
                                                                <input readonly type="text" hidden class="form-control"
                                                                    id="karyawan_id5b" name="karyawan_id" placeholder=""
                                                                    value="{{ old('karyawan_id') }}">
                                                                <input onclick="showSopir5b(this.value)"
                                                                    class="form-control" id="kode_karyawan5b"
                                                                    name="kode_karyawan" type="text" placeholder=""
                                                                    value="{{ old('kode_karyawan') }}" readonly
                                                                    style="margin-right: 10px; font-size:14px" />
                                                                <button class="btn btn-primary" type="button"
                                                                    onclick="showSopir5b(this.value)">
                                                                    <i class="fas fa-search"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="sisa_saldo">Sisa Saldo</label>
                                                                <input style="text-align: end;margin:right:10px"
                                                                    type="text" class="form-control" id="sisa_saldo5b"
                                                                    readonly name="sisa_saldo"
                                                                    value="{{ old('sisa_saldo') }}" placeholder="">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="nama_lengkap">Nama Sopir</label>
                                                                <input readonly type="text" class="form-control"
                                                                    id="nama_lengkap5b" name="nama_lengkap" placeholder=""
                                                                    value="{{ old('nama_lengkap') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="saldo_masuk">Potongan Saldo</label>
                                                                <input style="text-align: end" type="text"
                                                                    class="form-control" readonly id="saldo_keluar5b"
                                                                    name="saldo_keluar" placeholder=""
                                                                    value="{{ old('saldo_keluar') }}">
                                                            </div>
                                                            <hr
                                                                style="border: 2px solid black; display: inline-block; width: 97%; vertical-align: middle;">
                                                            <span
                                                                style="display: inline-block; margin-left: 0px; margin-right: 0; font-size: 18px; vertical-align: middle;">-</span>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="alamat">Keterangan</label>
                                                                <textarea type="text" class="form-control" id="keterangans" name="keterangans" placeholder="Masukan keterangan">{{ old('keterangans') }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="sub_total">Sub Total</label>
                                                                <input style="text-align: end; margin:right:10px"
                                                                    type="text" class="form-control" readonly
                                                                    id="sub_totals5b" name="sub_totals" placeholder=""
                                                                    value="{{ old('sub_totals') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <script>
                                            $(document).ready(function() {
                                                // Definisikan fungsi perhitungan
                                                function hitung() {
                                                    var km_pemasangan = parseInt($('#km_pemasangan5b').val());
                                                    var km_pelepasan = parseInt($('#km_pelepasan5b').val());
                                                    var km_terpakai = km_pelepasan - km_pemasangan;
                                                    $('#km_terpakai5b').val(km_terpakai);
                                                    var km_target = parseFloat($('#km_target5b').val());
                                                    var hargaString = $('#harga5b').val().replaceAll('.', '');
                                                    var harga = parseFloat(hargaString);
                                                    console.log(harga);
                                                    var hasil_persen = km_terpakai / km_target * 100;
                                                    var hasil_harga = harga * hasil_persen / 100;
                                                    // Memperoleh hasil harga yang dibulatkan
                                                    var hasil_harga_bulat = Math.round(hasil_harga);
                                                    var sisa_harga = harga - hasil_harga_bulat;
                                                    var hasil_harga_formatted = sisa_harga.toLocaleString('id-ID');
                                                    $('#sisa_harga5b').val(hasil_harga_formatted);
                                                    $('#saldo_keluar5b').val(hasil_harga_formatted);

                                                    // Hitung selisih antara sisa_saldo dan saldo_keluar
                                                    var sisa_saldo = parseFloat($('#sisa_saldo5b').val().replace(/\D/g, ''));
                                                    var saldo_keluar = parseFloat($('#saldo_keluar5b').val().replace(/\D/g, ''));
                                                    var sub_totals = sisa_saldo - saldo_keluar;
                                                    var formattedSubTotals = sub_totals.toLocaleString('id-ID');
                                                    $('#sub_totals5b').val(formattedSubTotals);
                                                }
                                                // Panggil fungsi perhitungan saat dokumen siap
                                                hitung();
                                                // Panggil fungsi perhitungan saat input berubah
                                                $('#km_pelepasan5b').on('input', function() {
                                                    hitung();
                                                });
                                            });
                                        </script>
                                        <script>
                                            function toggleLabels() {
                                                var keterangan = document.getElementById('keterangan5b');
                                                var perhitungan_klaim = document.getElementById('perhitungan_klaim5b');

                                                if (keterangan.value === 'Pecah Klaim') {
                                                    perhitungan_klaim.style.display = 'block';
                                                } else {
                                                    perhitungan_klaim.style.display = 'none';
                                                }
                                            }

                                            toggleLabels();
                                            document.getElementById('keterangan5b').addEventListener('change', toggleLabels);
                                        </script>
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
                                            <h4>Ban tidak ada !!</h4>
                                            <p>Tidak ada Ban terpasang di axle 5B</p>
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
        @if ($banspas5c != null)
            <div class="modal fade" id="modal-exle_5C-{{ $kendaraan->id }}">
                <div class="modal-dialog" style="max-width: 90%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 5C</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="{{ url('admin/inquerypelepasan1/' . $kendaraan->id) }}" method="POST"
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
                                            <label for="posisi_ban">Pelepasan Id</label>
                                            <input type="text" class="form-control" readonly
                                                name="pelepasan_ban_id" placeholder=""
                                                value="{{ $inquerypelepasan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="km_pemasangan">Ban Id</label>
                                            <input type="text" class="form-control" id="" name="id_ban"
                                                placeholder="" value="{{ $banspas5c->id }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Kode Ban</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="kode_ban" placeholder="" value="{{ $banspas5c->kode_ban }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">No Seri</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="no_seri" placeholder="" value="{{ $banspas5c->no_seri }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" readonly id="km_pemasangan5c"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ $banspas5c->km_pemasangan }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pelepasan</label>
                                            <input type="text" class="form-control" id="km_pelepasan5c"
                                                name="km_pelepasan" placeholder="Masukan km pelepasan"
                                                value="{{ old('km_pelepasan') }}">
                                        </div>
                                       <div class="form-group">
                                            <label class="form-label" for="keterangan5c">Keterangan</label>
                                            <select class="form-control" id="keterangan5c" name="keterangan">
                                                <option value="">- Pilih -</option>
                                                <option value="Habis"
                                                    {{ old('keterangan') == 'Habis' ? 'selected' : null }}>
                                                    Habis</option>
                                                <option value="Pecah"
                                                    {{ old('keterangan') == 'Pecah' ? 'selected' : null }}>
                                                    Pecah Non Klaim</option>
                                                <option value="Pecah Klaim"
                                                    {{ old('keterangan') == 'Pecah Klaim' ? 'selected' : null }}>
                                                    Pecah Klaim</option>
                                                <option value="Stok"
                                                    {{ old('keterangan') == 'Stok' ? 'selected' : null }}>
                                                    Stok</option>
                                            </select>
                                        </div>
                                        <div class="form-group" id="perhitungan_klaim5c">
                                            <div class="form-group">
                                                <label for="km_pemasangan">Harga Ban</label>
                                                <input type="text" class="form-control" id="harga5c" readonly
                                                    name="harga" placeholder=""
                                                    value="{{ number_format($banspas5c->harga, 0, ',', '.') }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="km_pemasangan">Target Km</label>
                                                <input type="text" class="form-control" id="" readonly
                                                    name="target_km_ban" placeholder="" value="{{ $banspas5c->target_km_ban }}">
                                            </div>
                                            <div class="form-group" hidden>
                                                <label for="km_pemasangan">KM target</label>
                                                <input type="text" class="form-control" id="km_target5c" readonly
                                                    name="km_target" placeholder=""
                                                    value="{{ $banspas5c->target_km_ban - $banspas5c->km_pemasangan }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="km_terpakai">KM Terpakai</label>
                                                <input type="text" class="form-control" id="km_terpakai5c" readonly
                                                    name="km_terpakai" value="{{ $banspas5c->km_terpakai }}" placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="sisa_harga">Harga Klaim</label>
                                                <input type="text" class="form-control" id="sisa_harga5c" readonly
                                                    name="sisa_harga" placeholder=""
                                                    value="{{ number_format($banspas5c->sisa_harga, 0, ',', '.') }}">
                                            </div>
                                            <div id="pengambilan">
                                                <div class="card-header mb-3">
                                                    <h3 class="card-title">Pengambilan Deposit Sopir</h3>
                                                </div>
                                                <div>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <label for="sisa_saldo">Kode Sopir</label>
                                                            <div class="form-group d-flex">
                                                                <input readonly type="text" hidden class="form-control"
                                                                    id="karyawan_id5c" name="karyawan_id" placeholder=""
                                                                    value="{{ old('karyawan_id') }}">
                                                                <input onclick="showSopir5c(this.value)"
                                                                    class="form-control" id="kode_karyawan5c"
                                                                    name="kode_karyawan" type="text" placeholder=""
                                                                    value="{{ old('kode_karyawan') }}" readonly
                                                                    style="margin-right: 10px; font-size:14px" />
                                                                <button class="btn btn-primary" type="button"
                                                                    onclick="showSopir5c(this.value)">
                                                                    <i class="fas fa-search"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="sisa_saldo">Sisa Saldo</label>
                                                                <input style="text-align: end;margin:right:10px"
                                                                    type="text" class="form-control" id="sisa_saldo5c"
                                                                    readonly name="sisa_saldo"
                                                                    value="{{ old('sisa_saldo') }}" placeholder="">

                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="nama_lengkap">Nama Sopir</label>
                                                                <input readonly type="text" class="form-control"
                                                                    id="nama_lengkap5c" name="nama_lengkap" placeholder=""
                                                                    value="{{ old('nama_lengkap') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="saldo_masuk">Potongan Saldo</label>
                                                                <input style="text-align: end" type="text"
                                                                    class="form-control" readonly id="saldo_keluar5c"
                                                                    name="saldo_keluar" placeholder=""
                                                                    value="{{ old('saldo_keluar') }}">
                                                            </div>
                                                            <hr
                                                                style="border: 2px solid black; display: inline-block; width: 97%; vertical-align: middle;">
                                                            <span
                                                                style="display: inline-block; margin-left: 0px; margin-right: 0; font-size: 18px; vertical-align: middle;">-</span>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="alamat">Keterangan</label>
                                                                <textarea type="text" class="form-control" id="keterangans" name="keterangans" placeholder="Masukan keterangan">{{ old('keterangans') }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="sub_total">Sub Total</label>
                                                                <input style="text-align: end; margin:right:10px"
                                                                    type="text" class="form-control" readonly
                                                                    id="sub_totals5c" name="sub_totals" placeholder=""
                                                                    value="{{ old('sub_totals') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <script>
                                            $(document).ready(function() {
                                                // Definisikan fungsi perhitungan
                                                function hitung() {
                                                    var km_pemasangan = parseInt($('#km_pemasangan5c').val());
                                                    var km_pelepasan = parseInt($('#km_pelepasan5c').val());
                                                    var km_terpakai = km_pelepasan - km_pemasangan;
                                                    $('#km_terpakai5c').val(km_terpakai);
                                                    var km_target = parseFloat($('#km_target5c').val());
                                                    var hargaString = $('#harga5c').val().replaceAll('.', '');
                                                    var harga = parseFloat(hargaString);
                                                    console.log(harga);
                                                    var hasil_persen = km_terpakai / km_target * 100;
                                                    var hasil_harga = harga * hasil_persen / 100;
                                                    // Memperoleh hasil harga yang dibulatkan
                                                    var hasil_harga_bulat = Math.round(hasil_harga);
                                                    var sisa_harga = harga - hasil_harga_bulat;
                                                    var hasil_harga_formatted = sisa_harga.toLocaleString('id-ID');
                                                    $('#sisa_harga5c').val(hasil_harga_formatted);
                                                    $('#saldo_keluar5c').val(hasil_harga_formatted);

                                                    // Hitung selisih antara sisa_saldo dan saldo_keluar
                                                    var sisa_saldo = parseFloat($('#sisa_saldo5c').val().replace(/\D/g, ''));
                                                    var saldo_keluar = parseFloat($('#saldo_keluar5c').val().replace(/\D/g, ''));
                                                    var sub_totals = sisa_saldo - saldo_keluar;
                                                    var formattedSubTotals = sub_totals.toLocaleString('id-ID');
                                                    $('#sub_totals5c').val(formattedSubTotals);
                                                }
                                                // Panggil fungsi perhitungan saat dokumen siap
                                                hitung();
                                                // Panggil fungsi perhitungan saat input berubah
                                                $('#km_pelepasan5c').on('input', function() {
                                                    hitung();
                                                });
                                            });
                                        </script>

                                        <script>
                                            function toggleLabels() {
                                                var keterangan = document.getElementById('keterangan5c');
                                                var perhitungan_klaim = document.getElementById('perhitungan_klaim5c');

                                                if (keterangan.value === 'Pecah Klaim') {
                                                    perhitungan_klaim.style.display = 'block';
                                                } else {
                                                    perhitungan_klaim.style.display = 'none';
                                                }
                                            }

                                            toggleLabels();
                                            document.getElementById('keterangan5c').addEventListener('change', toggleLabels);
                                        </script>
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
                                            <h4>Ban tidak ada !!</h4>
                                            <p>Tidak ada Ban terpasang di axle 5C</p>
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
        @if ($banspas5d != null)
            <div class="modal fade" id="modal-exle_5D-{{ $kendaraan->id }}">
                <div class="modal-dialog" style="max-width: 90%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 5D</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="{{ url('admin/inquerypelepasan1/' . $kendaraan->id) }}" method="POST"
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
                                            <label for="posisi_ban">Pelepasan Id</label>
                                            <input type="text" class="form-control" readonly
                                                name="pelepasan_ban_id" placeholder=""
                                                value="{{ $inquerypelepasan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="km_pemasangan">Ban Id</label>
                                            <input type="text" class="form-control" id="" name="id_ban"
                                                placeholder="" value="{{ $banspas5d->id }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Kode Ban</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="kode_ban" placeholder="" value="{{ $banspas5d->kode_ban }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">No Seri</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="no_seri" placeholder="" value="{{ $banspas5d->no_seri }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" readonly id="km_pemasangan5d"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ $banspas5d->km_pemasangan }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pelepasan</label>
                                            <input type="text" class="form-control" id="km_pelepasan5d"
                                                name="km_pelepasan" placeholder="Masukan km pelepasan"
                                                value="{{ old('km_pelepasan') }}">
                                        </div>
                                                                               <div class="form-group">
                                            <label class="form-label" for="keterangan5d">Keterangan</label>
                                            <select class="form-control" id="keterangan5d" name="keterangan">
                                                <option value="">- Pilih -</option>
                                                <option value="Habis"
                                                    {{ old('keterangan') == 'Habis' ? 'selected' : null }}>
                                                    Habis</option>
                                                <option value="Pecah"
                                                    {{ old('keterangan') == 'Pecah' ? 'selected' : null }}>
                                                    Pecah Non Klaim</option>
                                                <option value="Pecah Klaim"
                                                    {{ old('keterangan') == 'Pecah Klaim' ? 'selected' : null }}>
                                                    Pecah Klaim</option>
                                                <option value="Stok"
                                                    {{ old('keterangan') == 'Stok' ? 'selected' : null }}>
                                                    Stok</option>
                                            </select>
                                        </div>
                                         <div class="form-group" id="perhitungan_klaim5d">
                                            <div class="form-group">
                                                <label for="km_pemasangan">Harga Ban</label>
                                                <input type="text" class="form-control" id="harga5d" readonly
                                                    name="harga" placeholder=""
                                                    value="{{ number_format($banspas5d->harga, 0, ',', '.') }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="km_pemasangan">Target Km</label>
                                                <input type="text" class="form-control" id="" readonly
                                                    name="target_km_ban" placeholder="" value="{{ $banspas5d->target_km_ban }}">
                                            </div>
                                            <div class="form-group" hidden>
                                                <label for="km_pemasangan">KM target</label>
                                                <input type="text" class="form-control" id="km_target5d" readonly
                                                    name="km_target" placeholder=""
                                                    value="{{ $banspas5d->target_km_ban - $banspas5d->km_pemasangan }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="km_terpakai">KM Terpakai</label>
                                                <input type="text" class="form-control" id="km_terpakai5d" readonly
                                                    name="km_terpakai" value="{{ $banspas5d->km_terpakai }}" placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="sisa_harga">Harga Klaim</label>
                                                <input type="text" class="form-control" id="sisa_harga5d" readonly
                                                    name="sisa_harga" placeholder=""
                                                    value="{{ number_format($banspas5d->sisa_harga, 0, ',', '.') }}">
                                            </div>
                                            <div id="pengambilan">
                                                <div class="card-header mb-3">
                                                    <h3 class="card-title">Pengambilan Deposit Sopir</h3>
                                                </div>
                                                <div>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <label for="sisa_saldo">Kode Sopir</label>
                                                            <div class="form-group d-flex">
                                                                <input readonly type="text" hidden class="form-control"
                                                                    id="karyawan_id5d" name="karyawan_id" placeholder=""
                                                                    value="{{ old('karyawan_id') }}">
                                                                <input onclick="showSopir5d(this.value)"
                                                                    class="form-control" id="kode_karyawan5d"
                                                                    name="kode_karyawan" type="text" placeholder=""
                                                                    value="{{ old('kode_karyawan') }}" readonly
                                                                    style="margin-right: 10px; font-size:14px" />
                                                                <button class="btn btn-primary" type="button"
                                                                    onclick="showSopir5d(this.value)">
                                                                    <i class="fas fa-search"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="sisa_saldo">Sisa Saldo</label>
                                                                <input style="text-align: end;margin:right:10px"
                                                                    type="text" class="form-control" id="sisa_saldo5d"
                                                                    readonly name="sisa_saldo"
                                                                    value="{{ old('sisa_saldo') }}" placeholder="">

                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="nama_lengkap">Nama Sopir</label>
                                                                <input readonly type="text" class="form-control"
                                                                    id="nama_lengkap5d" name="nama_lengkap" placeholder=""
                                                                    value="{{ old('nama_lengkap') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="saldo_masuk">Potongan Saldo</label>
                                                                <input style="text-align: end" type="text"
                                                                    class="form-control" readonly id="saldo_keluar5d"
                                                                    name="saldo_keluar" placeholder=""
                                                                    value="{{ old('saldo_keluar') }}">
                                                            </div>
                                                            <hr
                                                                style="border: 2px solid black; display: inline-block; width: 97%; vertical-align: middle;">
                                                            <span
                                                                style="display: inline-block; margin-left: 0px; margin-right: 0; font-size: 18px; vertical-align: middle;">-</span>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="alamat">Keterangan</label>
                                                                <textarea type="text" class="form-control" id="keterangans" name="keterangans" placeholder="Masukan keterangan">{{ old('keterangans') }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="sub_total">Sub Total</label>
                                                                <input style="text-align: end; margin:right:10px"
                                                                    type="text" class="form-control" readonly
                                                                    id="sub_totals5d" name="sub_totals" placeholder=""
                                                                    value="{{ old('sub_totals') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <script>
                                            $(document).ready(function() {
                                                // Definisikan fungsi perhitungan
                                                function hitung() {
                                                    var km_pemasangan = parseInt($('#km_pemasangan5d').val());
                                                    var km_pelepasan = parseInt($('#km_pelepasan5d').val());
                                                    var km_terpakai = km_pelepasan - km_pemasangan;
                                                    $('#km_terpakai5d').val(km_terpakai);
                                                    var km_target = parseFloat($('#km_target5d').val());
                                                    var hargaString = $('#harga5d').val().replaceAll('.', '');
                                                    var harga = parseFloat(hargaString);
                                                    console.log(harga);
                                                    var hasil_persen = km_terpakai / km_target * 100;
                                                    var hasil_harga = harga * hasil_persen / 100;
                                                    // Memperoleh hasil harga yang dibulatkan
                                                    var hasil_harga_bulat = Math.round(hasil_harga);
                                                    var sisa_harga = harga - hasil_harga_bulat;
                                                    var hasil_harga_formatted = sisa_harga.toLocaleString('id-ID');
                                                    $('#sisa_harga5d').val(hasil_harga_formatted);
                                                    $('#saldo_keluar5d').val(hasil_harga_formatted);

                                                    // Hitung selisih antara sisa_saldo dan saldo_keluar
                                                    var sisa_saldo = parseFloat($('#sisa_saldo5d').val().replace(/\D/g, ''));
                                                    var saldo_keluar = parseFloat($('#saldo_keluar5d').val().replace(/\D/g, ''));
                                                    var sub_totals = sisa_saldo - saldo_keluar;
                                                    var formattedSubTotals = sub_totals.toLocaleString('id-ID');
                                                    $('#sub_totals5d').val(formattedSubTotals);
                                                }
                                                // Panggil fungsi perhitungan saat dokumen siap
                                                hitung();
                                                // Panggil fungsi perhitungan saat input berubah
                                                $('#km_pelepasan5d').on('input', function() {
                                                    hitung();
                                                });
                                            });
                                        </script>

                                        <script>
                                            function toggleLabels() {
                                                var keterangan = document.getElementById('keterangan5d');
                                                var perhitungan_klaim = document.getElementById('perhitungan_klaim5d');
                                                if (keterangan.value === 'Pecah Klaim') {
                                                    perhitungan_klaim.style.display = 'block';
                                                } else {
                                                    perhitungan_klaim.style.display = 'none';
                                                }
                                            }
                                            toggleLabels();
                                            document.getElementById('keterangan5d').addEventListener('change', toggleLabels);
                                        </script>
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
                <div class="modal-dialog" style="max-width: 90%;">
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
                                            <h4>Ban tidak ada !!</h4>
                                            <p>Tidak ada Ban terpasang di axle 5D</p>
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
        @if ($banspas6a != null)
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
                                <form action="{{ url('admin/inquerypelepasan1/' . $kendaraan->id) }}" method="POST"
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
                                            <label for="posisi_ban">Pelepasan Id</label>
                                            <input type="text" class="form-control" readonly
                                                name="pelepasan_ban_id" placeholder=""
                                                value="{{ $inquerypelepasan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="km_pemasangan">Ban Id</label>
                                            <input type="text" class="form-control" id="" name="id_ban"
                                                placeholder="" value="{{ $banspas6a->id }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Kode Ban</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="kode_ban" placeholder="" value="{{ $banspas6a->kode_ban }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">No Seri</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="no_seri" placeholder="" value="{{ $banspas6a->no_seri }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" readonly id="km_pemasangan6a"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ $banspas6a->km_pemasangan }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pelepasan</label>
                                            <input type="text" class="form-control" id="km_pelepasan6a"
                                                name="km_pelepasan" placeholder="Masukan km pelepasan"
                                                value="{{ old('km_pelepasan') }}">
                                        </div>
                                                                               <div class="form-group">
                                            <label class="form-label" for="keterangan6a">Keterangan</label>
                                            <select class="form-control" id="keterangan6a" name="keterangan">
                                                <option value="">- Pilih -</option>
                                                <option value="Habis"
                                                    {{ old('keterangan') == 'Habis' ? 'selected' : null }}>
                                                    Habis</option>
                                                <option value="Pecah"
                                                    {{ old('keterangan') == 'Pecah' ? 'selected' : null }}>
                                                    Pecah Non Klaim</option>
                                                <option value="Pecah Klaim"
                                                    {{ old('keterangan') == 'Pecah Klaim' ? 'selected' : null }}>
                                                    Pecah Klaim</option>
                                                <option value="Stok"
                                                    {{ old('keterangan') == 'Stok' ? 'selected' : null }}>
                                                    Stok</option>
                                            </select>
                                        </div>
                                        <div class="form-group" id="perhitungan_klaim6a">
                                            <div class="form-group">
                                                <label for="km_pemasangan">Harga Ban</label>
                                                <input type="text" class="form-control" id="harga6a" readonly
                                                    name="harga" placeholder=""
                                                    value="{{ number_format($banspas6a->harga, 0, ',', '.') }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="km_pemasangan">Target Km</label>
                                                <input type="text" class="form-control" id="" readonly
                                                    name="target_km_ban" placeholder="" value="{{ $banspas6a->target_km_ban }}">
                                            </div>
                                            <div class="form-group" hidden>
                                                <label for="km_pemasangan">KM target</label>
                                                <input type="text" class="form-control" id="km_target6a" readonly
                                                    name="km_target" placeholder=""
                                                    value="{{ $banspas6a->target_km_ban - $banspas6a->km_pemasangan }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="km_terpakai">KM Terpakai</label>
                                                <input type="text" class="form-control" id="km_terpakai6a" readonly
                                                    name="km_terpakai" value="{{ $banspas6a->km_terpakai }}" placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="sisa_harga">Harga Klaim</label>
                                                <input type="text" class="form-control" id="sisa_harga6a" readonly
                                                    name="sisa_harga" placeholder=""
                                                    value="{{ number_format($banspas6a->sisa_harga, 0, ',', '.') }}">
                                            </div>
                                            <div id="pengambilan">
                                                <div class="card-header mb-3">
                                                    <h3 class="card-title">Pengambilan Deposit Sopir</h3>
                                                </div>
                                                <div>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <label for="sisa_saldo">Kode Sopir</label>
                                                            <div class="form-group d-flex">
                                                                <input readonly type="text" hidden class="form-control"
                                                                    id="karyawan_id6a" name="karyawan_id" placeholder=""
                                                                    value="{{ old('karyawan_id') }}">
                                                                <input onclick="showSopir6a(this.value)"
                                                                    class="form-control" id="kode_karyawan6a"
                                                                    name="kode_karyawan" type="text" placeholder=""
                                                                    value="{{ old('kode_karyawan') }}" readonly
                                                                    style="margin-right: 10px; font-size:14px" />
                                                                <button class="btn btn-primary" type="button"
                                                                    onclick="showSopir6a(this.value)">
                                                                    <i class="fas fa-search"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="sisa_saldo">Sisa Saldo</label>
                                                                <input style="text-align: end;margin:right:10px"
                                                                    type="text" class="form-control" id="sisa_saldo6a"
                                                                    readonly name="sisa_saldo"
                                                                    value="{{ old('sisa_saldo') }}" placeholder="">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="nama_lengkap">Nama Sopir</label>
                                                                <input readonly type="text" class="form-control"
                                                                    id="nama_lengkap6a" name="nama_lengkap" placeholder=""
                                                                    value="{{ old('nama_lengkap') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="saldo_masuk">Potongan Saldo</label>
                                                                <input style="text-align: end" type="text"
                                                                    class="form-control" readonly id="saldo_keluar6a"
                                                                    name="saldo_keluar" placeholder=""
                                                                    value="{{ old('saldo_keluar') }}">
                                                            </div>
                                                            <hr
                                                                style="border: 2px solid black; display: inline-block; width: 97%; vertical-align: middle;">
                                                            <span
                                                                style="display: inline-block; margin-left: 0px; margin-right: 0; font-size: 18px; vertical-align: middle;">-</span>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="alamat">Keterangan</label>
                                                                <textarea type="text" class="form-control" id="keterangans" name="keterangans" placeholder="Masukan keterangan">{{ old('keterangans') }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="sub_total">Sub Total</label>
                                                                <input style="text-align: end; margin:right:10px"
                                                                    type="text" class="form-control" readonly
                                                                    id="sub_totals6a" name="sub_totals" placeholder=""
                                                                    value="{{ old('sub_totals') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <script>
                                            $(document).ready(function() {
                                                // Definisikan fungsi perhitungan
                                                function hitung() {
                                                    var km_pemasangan = parseInt($('#km_pemasangan6a').val());
                                                    var km_pelepasan = parseInt($('#km_pelepasan6a').val());
                                                    var km_terpakai = km_pelepasan - km_pemasangan;
                                                    $('#km_terpakai6a').val(km_terpakai);
                                                    var km_target = parseFloat($('#km_target6a').val());
                                                    var hargaString = $('#harga6a').val().replaceAll('.', '');
                                                    var harga = parseFloat(hargaString);
                                                    console.log(harga);
                                                    var hasil_persen = km_terpakai / km_target * 100;
                                                    var hasil_harga = harga * hasil_persen / 100;
                                                    // Memperoleh hasil harga yang dibulatkan
                                                    var hasil_harga_bulat = Math.round(hasil_harga);
                                                    var sisa_harga = harga - hasil_harga_bulat;
                                                    var hasil_harga_formatted = sisa_harga.toLocaleString('id-ID');
                                                    $('#sisa_harga6a').val(hasil_harga_formatted);
                                                    $('#saldo_keluar6a').val(hasil_harga_formatted);

                                                    // Hitung selisih antara sisa_saldo dan saldo_keluar
                                                    var sisa_saldo = parseFloat($('#sisa_saldo6a').val().replace(/\D/g, ''));
                                                    var saldo_keluar = parseFloat($('#saldo_keluar6a').val().replace(/\D/g, ''));
                                                    var sub_totals = sisa_saldo - saldo_keluar;
                                                    var formattedSubTotals = sub_totals.toLocaleString('id-ID');
                                                    $('#sub_totals6a').val(formattedSubTotals);
                                                }
                                                // Panggil fungsi perhitungan saat dokumen siap
                                                hitung();
                                                // Panggil fungsi perhitungan saat input berubah
                                                $('#km_pelepasan6a').on('input', function() {
                                                    hitung();
                                                });
                                            });
                                        </script>

                                        <script>
                                            function toggleLabels() {
                                                var keterangan = document.getElementById('keterangan6a');
                                                var perhitungan_klaim = document.getElementById('perhitungan_klaim6a');

                                                if (keterangan.value === 'Pecah Klaim') {
                                                    perhitungan_klaim.style.display = 'block';
                                                } else {
                                                    perhitungan_klaim.style.display = 'none';
                                                }
                                            }

                                            toggleLabels();
                                            document.getElementById('keterangan6a').addEventListener('change', toggleLabels);
                                        </script>
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
                                            <h4>Ban tidak ada !!</h4>
                                            <p>Tidak ada Ban terpasang di axle 6A</p>
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
        @if ($banspas6b != null)
            <div class="modal fade" id="modal-exle_6B-{{ $kendaraan->id }}">
                <div class="modal-dialog" style="max-width: 90%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 6B</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="{{ url('admin/inquerypelepasan1/' . $kendaraan->id) }}" method="POST"
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
                                            <label for="posisi_ban">Pelepasan Id</label>
                                            <input type="text" class="form-control" readonly
                                                name="pelepasan_ban_id" placeholder=""
                                                value="{{ $inquerypelepasan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="km_pemasangan">Ban Id</label>
                                            <input type="text" class="form-control" id="" name="id_ban"
                                                placeholder="" value="{{ $banspas6b->id }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Kode Ban</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="kode_ban" placeholder="" value="{{ $banspas6b->kode_ban }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">No Seri</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="no_seri" placeholder="" value="{{ $banspas6b->no_seri }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" readonly id="km_pemasangan6b"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ $banspas6b->km_pemasangan }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pelepasan</label>
                                            <input type="text" class="form-control" id="km_pelepasan6b"
                                                name="km_pelepasan" placeholder="Masukan km pelepasan"
                                                value="{{ old('km_pelepasan') }}">
                                        </div>
                                                                               <div class="form-group">
                                            <label class="form-label" for="keterangan6b">Keterangan</label>
                                            <select class="form-control" id="keterangan6b" name="keterangan">
                                                <option value="">- Pilih -</option>
                                                <option value="Habis"
                                                    {{ old('keterangan') == 'Habis' ? 'selected' : null }}>
                                                    Habis</option>
                                                <option value="Pecah"
                                                    {{ old('keterangan') == 'Pecah' ? 'selected' : null }}>
                                                    Pecah Non Klaim</option>
                                                <option value="Pecah Klaim"
                                                    {{ old('keterangan') == 'Pecah Klaim' ? 'selected' : null }}>
                                                    Pecah Klaim</option>
                                                <option value="Stok"
                                                    {{ old('keterangan') == 'Stok' ? 'selected' : null }}>
                                                    Stok</option>
                                            </select>
                                        </div>
                                         <div class="form-group" id="perhitungan_klaim6b">
                                            <div class="form-group">
                                                <label for="km_pemasangan">Harga Ban</label>
                                                <input type="text" class="form-control" id="harga6b" readonly
                                                    name="harga" placeholder=""
                                                    value="{{ number_format($banspas6b->harga, 0, ',', '.') }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="km_pemasangan">Target Km</label>
                                                <input type="text" class="form-control" id="" readonly
                                                    name="target_km_ban" placeholder="" value="{{ $banspas6b->target_km_ban }}">
                                            </div>
                                            <div class="form-group" hidden>
                                                <label for="km_pemasangan">KM target</label>
                                                <input type="text" class="form-control" id="km_target6b" readonly
                                                    name="km_target" placeholder=""
                                                    value="{{ $banspas6b->target_km_ban - $banspas6b->km_pemasangan }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="km_terpakai">KM Terpakai</label>
                                                <input type="text" class="form-control" id="km_terpakai6b" readonly
                                                    name="km_terpakai" value="{{ $banspas6b->km_terpakai }}" placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="sisa_harga">Harga Klaim</label>
                                                <input type="text" class="form-control" id="sisa_harga6b" readonly
                                                    name="sisa_harga" placeholder=""
                                                    value="{{ number_format($banspas6b->sisa_harga, 0, ',', '.') }}">
                                            </div>
                                            <div id="pengambilan">
                                                <div class="card-header mb-3">
                                                    <h3 class="card-title">Pengambilan Deposit Sopir</h3>
                                                </div>
                                                <div>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <label for="sisa_saldo">Kode Sopir</label>
                                                            <div class="form-group d-flex">
                                                                <input readonly type="text" hidden class="form-control"
                                                                    id="karyawan_id6b" name="karyawan_id" placeholder=""
                                                                    value="{{ old('karyawan_id') }}">
                                                                <input onclick="showSopir6b(this.value)"
                                                                    class="form-control" id="kode_karyawan6b"
                                                                    name="kode_karyawan" type="text" placeholder=""
                                                                    value="{{ old('kode_karyawan') }}" readonly
                                                                    style="margin-right: 10px; font-size:14px" />
                                                                <button class="btn btn-primary" type="button"
                                                                    onclick="showSopir6b(this.value)">
                                                                    <i class="fas fa-search"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="sisa_saldo">Sisa Saldo</label>
                                                                <input style="text-align: end;margin:right:10px"
                                                                    type="text" class="form-control" id="sisa_saldo6b"
                                                                    readonly name="sisa_saldo"
                                                                    value="{{ old('sisa_saldo') }}" placeholder="">

                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="nama_lengkap">Nama Sopir</label>
                                                                <input readonly type="text" class="form-control"
                                                                    id="nama_lengkap6b" name="nama_lengkap" placeholder=""
                                                                    value="{{ old('nama_lengkap') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="saldo_masuk">Potongan Saldo</label>
                                                                <input style="text-align: end" type="text"
                                                                    class="form-control" readonly id="saldo_keluar6b"
                                                                    name="saldo_keluar" placeholder=""
                                                                    value="{{ old('saldo_keluar') }}">
                                                            </div>
                                                            <hr
                                                                style="border: 2px solid black; display: inline-block; width: 97%; vertical-align: middle;">
                                                            <span
                                                                style="display: inline-block; margin-left: 0px; margin-right: 0; font-size: 18px; vertical-align: middle;">-</span>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="alamat">Keterangan</label>
                                                                <textarea type="text" class="form-control" id="keterangans" name="keterangans" placeholder="Masukan keterangan">{{ old('keterangans') }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="sub_total">Sub Total</label>
                                                                <input style="text-align: end; margin:right:10px"
                                                                    type="text" class="form-control" readonly
                                                                    id="sub_totals6b" name="sub_totals" placeholder=""
                                                                    value="{{ old('sub_totals') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <script>
                                            $(document).ready(function() {
                                                // Definisikan fungsi perhitungan
                                                function hitung() {
                                                    var km_pemasangan = parseInt($('#km_pemasangan6b').val());
                                                    var km_pelepasan = parseInt($('#km_pelepasan6b').val());
                                                    var km_terpakai = km_pelepasan - km_pemasangan;
                                                    $('#km_terpakai6b').val(km_terpakai);
                                                    var km_target = parseFloat($('#km_target6b').val());
                                                    var hargaString = $('#harga6b').val().replaceAll('.', '');
                                                    var harga = parseFloat(hargaString);
                                                    console.log(harga);
                                                    var hasil_persen = km_terpakai / km_target * 100;
                                                    var hasil_harga = harga * hasil_persen / 100;
                                                    // Memperoleh hasil harga yang dibulatkan
                                                    var hasil_harga_bulat = Math.round(hasil_harga);
                                                    var sisa_harga = harga - hasil_harga_bulat;
                                                    var hasil_harga_formatted = sisa_harga.toLocaleString('id-ID');
                                                    $('#sisa_harga6b').val(hasil_harga_formatted);
                                                    $('#saldo_keluar6b').val(hasil_harga_formatted);

                                                    // Hitung selisih antara sisa_saldo dan saldo_keluar
                                                    var sisa_saldo = parseFloat($('#sisa_saldo6b').val().replace(/\D/g, ''));
                                                    var saldo_keluar = parseFloat($('#saldo_keluar6b').val().replace(/\D/g, ''));
                                                    var sub_totals = sisa_saldo - saldo_keluar;
                                                    var formattedSubTotals = sub_totals.toLocaleString('id-ID');
                                                    $('#sub_totals6b').val(formattedSubTotals);
                                                }
                                                // Panggil fungsi perhitungan saat dokumen siap
                                                hitung();
                                                // Panggil fungsi perhitungan saat input berubah
                                                $('#km_pelepasan6b').on('input', function() {
                                                    hitung();
                                                });
                                            });
                                        </script>

                                        <script>
                                            function toggleLabels() {
                                                var keterangan = document.getElementById('keterangan6b');
                                                var perhitungan_klaim = document.getElementById('perhitungan_klaim6b');

                                                if (keterangan.value === 'Pecah Klaim') {
                                                    perhitungan_klaim.style.display = 'block';
                                                } else {
                                                    perhitungan_klaim.style.display = 'none';
                                                }
                                            }

                                            toggleLabels();
                                            document.getElementById('keterangan6b').addEventListener('change', toggleLabels);
                                        </script>
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
                                            <h4>Ban tidak ada !!</h4>
                                            <p>Tidak ada Ban terpasang di axle 6B</p>
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
        @if ($banspas6c != null)
            <div class="modal fade" id="modal-exle_6C-{{ $kendaraan->id }}">
                <div class="modal-dialog" style="max-width: 90%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 6C</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="{{ url('admin/inquerypelepasan1/' . $kendaraan->id) }}" method="POST"
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
                                            <label for="posisi_ban">Pelepasan Id</label>
                                            <input type="text" class="form-control" readonly
                                                name="pelepasan_ban_id" placeholder=""
                                                value="{{ $inquerypelepasan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="km_pemasangan">Ban Id</label>
                                            <input type="text" class="form-control" id="" name="id_ban"
                                                placeholder="" value="{{ $banspas6c->id }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Kode Ban</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="kode_ban" placeholder="" value="{{ $banspas6c->kode_ban }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">No Seri</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="no_seri" placeholder="" value="{{ $banspas6c->no_seri }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" readonly id="km_pemasangan6c"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ $banspas6c->km_pemasangan }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pelepasan</label>
                                            <input type="text" class="form-control" id="km_pelepasan6c"
                                                name="km_pelepasan" placeholder="Masukan km pelepasan"
                                                value="{{ old('km_pelepasan') }}">
                                        </div>
                                                                               <div class="form-group">
                                            <label class="form-label" for="keterangan6c">Keterangan</label>
                                            <select class="form-control" id="keterangan6c" name="keterangan">
                                                <option value="">- Pilih -</option>
                                                <option value="Habis"
                                                    {{ old('keterangan') == 'Habis' ? 'selected' : null }}>
                                                    Habis</option>
                                                <option value="Pecah"
                                                    {{ old('keterangan') == 'Pecah' ? 'selected' : null }}>
                                                    Pecah Non Klaim</option>
                                                <option value="Pecah Klaim"
                                                    {{ old('keterangan') == 'Pecah Klaim' ? 'selected' : null }}>
                                                    Pecah Klaim</option>
                                                <option value="Stok"
                                                    {{ old('keterangan') == 'Stok' ? 'selected' : null }}>
                                                    Stok</option>
                                            </select>
                                        </div>
                                         <div class="form-group" id="perhitungan_klaim6c">
                                            <div class="form-group">
                                                <label for="km_pemasangan">Harga Ban</label>
                                                <input type="text" class="form-control" id="harga6c" readonly
                                                    name="harga" placeholder=""
                                                    value="{{ number_format($banspas6c->harga, 0, ',', '.') }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="km_pemasangan">Target Km</label>
                                                <input type="text" class="form-control" id="" readonly
                                                    name="target_km_ban" placeholder="" value="{{ $banspas6c->target_km_ban }}">
                                            </div>
                                            <div class="form-group" hidden>
                                                <label for="km_pemasangan">KM target</label>
                                                <input type="text" class="form-control" id="km_target6c" readonly
                                                    name="km_target" placeholder=""
                                                    value="{{ $banspas6c->target_km_ban - $banspas6c->km_pemasangan }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="km_terpakai">KM Terpakai</label>
                                                <input type="text" class="form-control" id="km_terpakai6c" readonly
                                                    name="km_terpakai" value="{{ $banspas6c->km_terpakai }}" placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="sisa_harga">Harga Klaim</label>
                                                <input type="text" class="form-control" id="sisa_harga6c" readonly
                                                    name="sisa_harga" placeholder=""
                                                    value="{{ number_format($banspas6c->sisa_harga, 0, ',', '.') }}">
                                            </div>
                                            <div id="pengambilan">
                                                <div class="card-header mb-3">
                                                    <h3 class="card-title">Pengambilan Deposit Sopir</h3>
                                                </div>
                                                <div>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <label for="sisa_saldo">Kode Sopir</label>
                                                            <div class="form-group d-flex">
                                                                <input readonly type="text" hidden class="form-control"
                                                                    id="karyawan_id6c" name="karyawan_id" placeholder=""
                                                                    value="{{ old('karyawan_id') }}">
                                                                <input onclick="showSopi6cr(this.value)"
                                                                    class="form-control" id="kode_karyawan6c"
                                                                    name="kode_karyawan" type="text" placeholder=""
                                                                    value="{{ old('kode_karyawan') }}" readonly
                                                                    style="margin-right: 10px; font-size:14px" />
                                                                <button class="btn btn-primary" type="button"
                                                                    onclick="showSopir6c(this.value)">
                                                                    <i class="fas fa-search"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="sisa_saldo">Sisa Saldo</label>
                                                                <input style="text-align: end;margin:right:10px"
                                                                    type="text" class="form-control" id="sisa_saldo6c"
                                                                    readonly name="sisa_saldo"
                                                                    value="{{ old('sisa_saldo') }}" placeholder="">

                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="nama_lengkap">Nama Sopir</label>
                                                                <input readonly type="text" class="form-control"
                                                                    id="nama_lengkap6c" name="nama_lengkap" placeholder=""
                                                                    value="{{ old('nama_lengkap') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="saldo_masuk">Potongan Saldo</label>
                                                                <input style="text-align: end" type="text"
                                                                    class="form-control" readonly id="saldo_keluar6c"
                                                                    name="saldo_keluar" placeholder=""
                                                                    value="{{ old('saldo_keluar') }}">
                                                            </div>
                                                            <hr
                                                                style="border: 2px solid black; display: inline-block; width: 97%; vertical-align: middle;">
                                                            <span
                                                                style="display: inline-block; margin-left: 0px; margin-right: 0; font-size: 18px; vertical-align: middle;">-</span>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="alamat">Keterangan</label>
                                                                <textarea type="text" class="form-control" id="keterangans" name="keterangans" placeholder="Masukan keterangan">{{ old('keterangans') }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="sub_total">Sub Total</label>
                                                                <input style="text-align: end; margin:right:10px"
                                                                    type="text" class="form-control" readonly
                                                                    id="sub_totals6c" name="sub_totals" placeholder=""
                                                                    value="{{ old('sub_totals') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <script>
                                            $(document).ready(function() {
                                                // Definisikan fungsi perhitungan
                                                function hitung() {
                                                    var km_pemasangan = parseInt($('#km_pemasangan6c').val());
                                                    var km_pelepasan = parseInt($('#km_pelepasan6c').val());
                                                    var km_terpakai = km_pelepasan - km_pemasangan;
                                                    $('#km_terpakai6c').val(km_terpakai);
                                                    var km_target = parseFloat($('#km_target6c').val());
                                                    var hargaString = $('#harga6c').val().replaceAll('.', '');
                                                    var harga = parseFloat(hargaString);
                                                    console.log(harga);
                                                    var hasil_persen = km_terpakai / km_target * 100;
                                                    var hasil_harga = harga * hasil_persen / 100;
                                                    // Memperoleh hasil harga yang dibulatkan
                                                    var hasil_harga_bulat = Math.round(hasil_harga);
                                                    var sisa_harga = harga - hasil_harga_bulat;
                                                    var hasil_harga_formatted = sisa_harga.toLocaleString('id-ID');
                                                    $('#sisa_harga6c').val(hasil_harga_formatted);
                                                    $('#saldo_keluar6c').val(hasil_harga_formatted);

                                                    // Hitung selisih antara sisa_saldo dan saldo_keluar
                                                    var sisa_saldo = parseFloat($('#sisa_saldo6c').val().replace(/\D/g, ''));
                                                    var saldo_keluar = parseFloat($('#saldo_keluar6c').val().replace(/\D/g, ''));
                                                    var sub_totals = sisa_saldo - saldo_keluar;
                                                    var formattedSubTotals = sub_totals.toLocaleString('id-ID');
                                                    $('#sub_totals6c').val(formattedSubTotals);
                                                }
                                                // Panggil fungsi perhitungan saat dokumen siap
                                                hitung();
                                                // Panggil fungsi perhitungan saat input berubah
                                                $('#km_pelepasan6c').on('input', function() {
                                                    hitung();
                                                });
                                            });
                                        </script>

                                        <script>
                                            function toggleLabels() {
                                                var keterangan = document.getElementById('keterangan6c');
                                                var perhitungan_klaim = document.getElementById('perhitungan_klaim6c');

                                                if (keterangan.value === 'Pecah Klaim') {
                                                    perhitungan_klaim.style.display = 'block';
                                                } else {
                                                    perhitungan_klaim.style.display = 'none';
                                                }
                                            }

                                            toggleLabels();
                                            document.getElementById('keterangan6c').addEventListener('change', toggleLabels);
                                        </script>
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
                                            <h4>Ban tidak ada !!</h4>
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
        @if ($banspas6d != null)
            <div class="modal fade" id="modal-exle_6D-{{ $kendaraan->id }}">
                <div class="modal-dialog" style="max-width: 90%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Exle 6D</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="text-align: center;">
                                <form action="{{ url('admin/inquerypelepasan1/' . $kendaraan->id) }}" method="POST"
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
                                            <label for="posisi_ban">Pelepasan Id</label>
                                            <input type="text" class="form-control" readonly
                                                name="pelepasan_ban_id" placeholder=""
                                                value="{{ $inquerypelepasan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="km_pemasangan">Ban Id</label>
                                            <input type="text" class="form-control" id="" name="id_ban"
                                                placeholder="" value="{{ $banspas6d->id }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Kode Ban</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="kode_ban" placeholder="" value="{{ $banspas6d->kode_ban }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">No Seri</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="no_seri" placeholder="" value="{{ $banspas6d->no_seri }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" readonly id="km_pemasangan6d"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ $banspas6d->km_pemasangan }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pelepasan</label>
                                            <input type="text" class="form-control" id="km_pelepasan6d"
                                                name="km_pelepasan" placeholder="Masukan km pelepasan"
                                                value="{{ old('km_pelepasan') }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="keterangan6d">Keterangan</label>
                                            <select class="form-control" id="keterangan6d" name="keterangan">
                                                <option value="">- Pilih -</option>
                                                <option value="Habis"
                                                    {{ old('keterangan') == 'Habis' ? 'selected' : null }}>
                                                    Habis</option>
                                                <option value="Pecah"
                                                    {{ old('keterangan') == 'Pecah' ? 'selected' : null }}>
                                                    Pecah Non Klaim</option>
                                                <option value="Pecah Klaim"
                                                    {{ old('keterangan') == 'Pecah Klaim' ? 'selected' : null }}>
                                                    Pecah Klaim</option>
                                                <option value="Stok"
                                                    {{ old('keterangan') == 'Stok' ? 'selected' : null }}>
                                                    Stok</option>
                                            </select>
                                        </div>
                                        <div class="form-group" id="perhitungan_klaim6d">
                                            <div class="form-group">
                                                <label for="km_pemasangan">Harga Ban</label>
                                                <input type="text" class="form-control" id="harga6d" readonly
                                                    name="harga" placeholder=""
                                                    value="{{ number_format($banspas6d->harga, 0, ',', '.') }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="km_pemasangan">Target Km</label>
                                                <input type="text" class="form-control" id="" readonly
                                                    name="target_km_ban" placeholder="" value="{{ $banspas6d->target_km_ban }}">
                                            </div>
                                            <div class="form-group" hidden>
                                                <label for="km_pemasangan">KM target</label>
                                                <input type="text" class="form-control" id="km_target6d" readonly
                                                    name="km_target" placeholder=""
                                                    value="{{ $banspas6d->target_km_ban - $banspas6d->km_pemasangan }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="km_terpakai">KM Terpakai</label>
                                                <input type="text" class="form-control" id="km_terpakai6d" readonly
                                                    name="km_terpakai" value="{{ $banspas6d->km_terpakai }}" placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="sisa_harga">Harga Klaim</label>
                                                <input type="text" class="form-control" id="sisa_harga6d" readonly
                                                    name="sisa_harga" placeholder=""
                                                    value="{{ number_format($banspas6d->sisa_harga, 0, ',', '.') }}">
                                            </div>
                                            <div id="pengambilan">
                                                <div class="card-header mb-3">
                                                    <h3 class="card-title">Pengambilan Deposit Sopir</h3>
                                                </div>
                                                <div>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <label for="sisa_saldo">Kode Sopir</label>
                                                            <div class="form-group d-flex">
                                                                <input readonly type="text" hidden class="form-control"
                                                                    id="karyawan_id6d" name="karyawan_id" placeholder=""
                                                                    value="{{ old('karyawan_id') }}">
                                                                <input onclick="showSopir6d(this.value)"
                                                                    class="form-control" id="kode_karyawan6d"
                                                                    name="kode_karyawan" type="text" placeholder=""
                                                                    value="{{ old('kode_karyawan') }}" readonly
                                                                    style="margin-right: 10px; font-size:14px" />
                                                                <button class="btn btn-primary" type="button"
                                                                    onclick="showSopir6d(this.value)">
                                                                    <i class="fas fa-search"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="sisa_saldo">Sisa Saldo</label>
                                                                <input style="text-align: end;margin:right:10px"
                                                                    type="text" class="form-control" id="sisa_saldo6d"
                                                                    readonly name="sisa_saldo"
                                                                    value="{{ old('sisa_saldo') }}" placeholder="">

                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="nama_lengkap">Nama Sopir</label>
                                                                <input readonly type="text" class="form-control"
                                                                    id="nama_lengkap6d" name="nama_lengkap" placeholder=""
                                                                    value="{{ old('nama_lengkap') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="saldo_masuk">Potongan Saldo</label>
                                                                <input style="text-align: end" type="text"
                                                                    class="form-control" readonly id="saldo_keluar6d"
                                                                    name="saldo_keluar" placeholder=""
                                                                    value="{{ old('saldo_keluar') }}">
                                                            </div>
                                                            <hr
                                                                style="border: 2px solid black; display: inline-block; width: 97%; vertical-align: middle;">
                                                            <span
                                                                style="display: inline-block; margin-left: 0px; margin-right: 0; font-size: 18px; vertical-align: middle;">-</span>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="alamat">Keterangan</label>
                                                                <textarea type="text" class="form-control" id="keterangans" name="keterangans" placeholder="Masukan keterangan">{{ old('keterangans') }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="sub_total">Sub Total</label>
                                                                <input style="text-align: end; margin:right:10px"
                                                                    type="text" class="form-control" readonly
                                                                    id="sub_totals6d" name="sub_totals" placeholder=""
                                                                    value="{{ old('sub_totals') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <script>
                                            $(document).ready(function() {
                                                // Definisikan fungsi perhitungan
                                                function hitung() {
                                                    var km_pemasangan = parseInt($('#km_pemasangan6d').val());
                                                    var km_pelepasan = parseInt($('#km_pelepasan6d').val());
                                                    var km_terpakai = km_pelepasan - km_pemasangan;
                                                    $('#km_terpakai6d').val(km_terpakai);
                                                    var km_target = parseFloat($('#km_target6d').val());
                                                    var hargaString = $('#harga6d').val().replaceAll('.', '');
                                                    var harga = parseFloat(hargaString);
                                                    console.log(harga);
                                                    var hasil_persen = km_terpakai / km_target * 100;
                                                    var hasil_harga = harga * hasil_persen / 100;
                                                    // Memperoleh hasil harga yang dibulatkan
                                                    var hasil_harga_bulat = Math.round(hasil_harga);
                                                    var sisa_harga = harga - hasil_harga_bulat;
                                                    var hasil_harga_formatted = sisa_harga.toLocaleString('id-ID');
                                                    $('#sisa_harga6d').val(hasil_harga_formatted);
                                                    $('#saldo_keluar6d').val(hasil_harga_formatted);

                                                    // Hitung selisih antara sisa_saldo dan saldo_keluar
                                                    var sisa_saldo = parseFloat($('#sisa_saldo6d').val().replace(/\D/g, ''));
                                                    var saldo_keluar = parseFloat($('#saldo_keluar6d').val().replace(/\D/g, ''));
                                                    var sub_totals = sisa_saldo - saldo_keluar;
                                                    var formattedSubTotals = sub_totals.toLocaleString('id-ID');
                                                    $('#sub_totals6d').val(formattedSubTotals);
                                                }
                                                // Panggil fungsi perhitungan saat dokumen siap
                                                hitung();
                                                // Panggil fungsi perhitungan saat input berubah
                                                $('#km_pelepasan6d').on('input', function() {
                                                    hitung();
                                                });
                                            });
                                        </script>

                                        <script>
                                            function toggleLabels() {
                                                var keterangan = document.getElementById('keterangan6d');
                                                var perhitungan_klaim = document.getElementById('perhitungan_klaim6d');

                                                if (keterangan.value === 'Pecah Klaim') {
                                                    perhitungan_klaim.style.display = 'block';
                                                } else {
                                                    perhitungan_klaim.style.display = 'none';
                                                }
                                            }

                                            toggleLabels();
                                            document.getElementById('keterangan6d').addEventListener('change', toggleLabels);
                                        </script>
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
                                            <h4>Ban tidak ada !!</h4>
                                            <p>Tidak ada Ban terpasang di axle 6D</p>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    <div class="modal fade" id="tableSopir" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Sopir</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive scrollbar m-2">
                            <table id="pelepasan1" class="table table-bordered table-striped">
                                <thead class="bg-200 text-900">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Kode Sopir</th>
                                        <th>Nama Nama Sopir</th>
                                        <th>Tanggal</th>
                                        <th>Sisa Saldo</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($SopirAll as $sopir)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $sopir->kode_karyawan }}</td>
                                            <td>{{ $sopir->nama_lengkap }}</td>
                                            <td>{{ $sopir->telp }}</td>
                                            <td> {{ number_format($sopir->tabungan, 0, ',', '.') }}
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="getSelectedData('{{ $sopir->id }}',
                                                    '{{ $sopir->kode_karyawan }}',
                                                    '{{ $sopir->nama_lengkap }}',
                                                    '{{ $sopir->tabungan }}',
                                                    )">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="tableSopir1b" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Sopir</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive scrollbar m-2">
                            <table id="pelepasan2" class="table table-bordered table-striped">
                                <thead class="bg-200 text-900">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Kode Sopir</th>
                                        <th>Nama Nama Sopir</th>
                                        <th>Tanggal</th>
                                        <th>Sisa Saldo</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($SopirAll as $sopir)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $sopir->kode_karyawan }}</td>
                                            <td>{{ $sopir->nama_lengkap }}</td>
                                            <td>{{ $sopir->telp }}</td>
                                            <td> {{ number_format($sopir->tabungan, 0, ',', '.') }}
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="getSelectedData1b('{{ $sopir->id }}',
                                                    '{{ $sopir->kode_karyawan }}',
                                                    '{{ $sopir->nama_lengkap }}',
                                                    '{{ $sopir->tabungan }}',
                                                    )">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="tableSopir2a" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Sopir</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive scrollbar m-2">
                            <table id="pelepasan3" class="table table-bordered table-striped">
                                <thead class="bg-200 text-900">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Kode Sopir</th>
                                        <th>Nama Nama Sopir</th>
                                        <th>Tanggal</th>
                                        <th>Sisa Saldo</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($SopirAll as $sopir)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $sopir->kode_karyawan }}</td>
                                            <td>{{ $sopir->nama_lengkap }}</td>
                                            <td>{{ $sopir->telp }}</td>
                                            <td> {{ number_format($sopir->tabungan, 0, ',', '.') }}
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="getSelectedData2a('{{ $sopir->id }}',
                                                    '{{ $sopir->kode_karyawan }}',
                                                    '{{ $sopir->nama_lengkap }}',
                                                    '{{ $sopir->tabungan }}',
                                                    )">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="tableSopir2b" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Sopir</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive scrollbar m-2">
                            <table id="pelepasan4" class="table table-bordered table-striped">
                                <thead class="bg-200 text-900">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Kode Sopir</th>
                                        <th>Nama Nama Sopir</th>
                                        <th>Tanggal</th>
                                        <th>Sisa Saldo</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($SopirAll as $sopir)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $sopir->kode_karyawan }}</td>
                                            <td>{{ $sopir->nama_lengkap }}</td>
                                            <td>{{ $sopir->telp }}</td>
                                            <td> {{ number_format($sopir->tabungan, 0, ',', '.') }}
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="getSelectedData2b('{{ $sopir->id }}',
                                                    '{{ $sopir->kode_karyawan }}',
                                                    '{{ $sopir->nama_lengkap }}',
                                                    '{{ $sopir->tabungan }}',
                                                    )">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="tableSopir2c" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Sopir</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive scrollbar m-2">
                            <table id="pelepasan5" class="table table-bordered table-striped">
                                <thead class="bg-200 text-900">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Kode Sopir</th>
                                        <th>Nama Nama Sopir</th>
                                        <th>Tanggal</th>
                                        <th>Sisa Saldo</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($SopirAll as $sopir)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $sopir->kode_karyawan }}</td>
                                            <td>{{ $sopir->nama_lengkap }}</td>
                                            <td>{{ $sopir->telp }}</td>
                                            <td> {{ number_format($sopir->tabungan, 0, ',', '.') }}
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="getSelectedData2c('{{ $sopir->id }}',
                                                    '{{ $sopir->kode_karyawan }}',
                                                    '{{ $sopir->nama_lengkap }}',
                                                    '{{ $sopir->tabungan }}',
                                                    )">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="tableSopir2d" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Sopir</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive scrollbar m-2">
                            <table id="pelepasan6" class="table table-bordered table-striped">
                                <thead class="bg-200 text-900">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Kode Sopir</th>
                                        <th>Nama Nama Sopir</th>
                                        <th>Tanggal</th>
                                        <th>Sisa Saldo</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($SopirAll as $sopir)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $sopir->kode_karyawan }}</td>
                                            <td>{{ $sopir->nama_lengkap }}</td>
                                            <td>{{ $sopir->telp }}</td>
                                            <td> {{ number_format($sopir->tabungan, 0, ',', '.') }}
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="getSelectedData2d('{{ $sopir->id }}',
                                                    '{{ $sopir->kode_karyawan }}',
                                                    '{{ $sopir->nama_lengkap }}',
                                                    '{{ $sopir->tabungan }}',
                                                    )">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="tableSopir3a" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Sopir</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive scrollbar m-2">
                            <table id="pelepasan7" class="table table-bordered table-striped">
                                <thead class="bg-200 text-900">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Kode Sopir</th>
                                        <th>Nama Nama Sopir</th>
                                        <th>Tanggal</th>
                                        <th>Sisa Saldo</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($SopirAll as $sopir)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $sopir->kode_karyawan }}</td>
                                            <td>{{ $sopir->nama_lengkap }}</td>
                                            <td>{{ $sopir->telp }}</td>
                                            <td> {{ number_format($sopir->tabungan, 0, ',', '.') }}
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="getSelectedData3a('{{ $sopir->id }}',
                                                    '{{ $sopir->kode_karyawan }}',
                                                    '{{ $sopir->nama_lengkap }}',
                                                    '{{ $sopir->tabungan }}',
                                                    )">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="tableSopir3b" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Sopir</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive scrollbar m-2">
                            <table id="pelepasan8" class="table table-bordered table-striped">
                                <thead class="bg-200 text-900">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Kode Sopir</th>
                                        <th>Nama Nama Sopir</th>
                                        <th>Tanggal</th>
                                        <th>Sisa Saldo</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($SopirAll as $sopir)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $sopir->kode_karyawan }}</td>
                                            <td>{{ $sopir->nama_lengkap }}</td>
                                            <td>{{ $sopir->telp }}</td>
                                            <td> {{ number_format($sopir->tabungan, 0, ',', '.') }}
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="getSelectedData3b('{{ $sopir->id }}',
                                                    '{{ $sopir->kode_karyawan }}',
                                                    '{{ $sopir->nama_lengkap }}',
                                                    '{{ $sopir->tabungan }}',
                                                    )">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="tableSopir3c" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Sopir</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive scrollbar m-2">
                            <table id="pelepasan9" class="table table-bordered table-striped">
                                <thead class="bg-200 text-900">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Kode Sopir</th>
                                        <th>Nama Nama Sopir</th>
                                        <th>Tanggal</th>
                                        <th>Sisa Saldo</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($SopirAll as $sopir)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $sopir->kode_karyawan }}</td>
                                            <td>{{ $sopir->nama_lengkap }}</td>
                                            <td>{{ $sopir->telp }}</td>
                                            <td> {{ number_format($sopir->tabungan, 0, ',', '.') }}
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="getSelectedData3c('{{ $sopir->id }}',
                                                    '{{ $sopir->kode_karyawan }}',
                                                    '{{ $sopir->nama_lengkap }}',
                                                    '{{ $sopir->tabungan }}',
                                                    )">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="tableSopir3d" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Sopir</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive scrollbar m-2">
                            <table id="pelepasan10" class="table table-bordered table-striped">
                                <thead class="bg-200 text-900">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Kode Sopir</th>
                                        <th>Nama Nama Sopir</th>
                                        <th>Tanggal</th>
                                        <th>Sisa Saldo</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($SopirAll as $sopir)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $sopir->kode_karyawan }}</td>
                                            <td>{{ $sopir->nama_lengkap }}</td>
                                            <td>{{ $sopir->telp }}</td>
                                            <td> {{ number_format($sopir->tabungan, 0, ',', '.') }}
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="getSelectedData3d('{{ $sopir->id }}',
                                                    '{{ $sopir->kode_karyawan }}',
                                                    '{{ $sopir->nama_lengkap }}',
                                                    '{{ $sopir->tabungan }}',
                                                    )">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="tableSopir4a" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Sopir</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive scrollbar m-2">
                            <table id="pelepasan11" class="table table-bordered table-striped">
                                <thead class="bg-200 text-900">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Kode Sopir</th>
                                        <th>Nama Nama Sopir</th>
                                        <th>Tanggal</th>
                                        <th>Sisa Saldo</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($SopirAll as $sopir)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $sopir->kode_karyawan }}</td>
                                            <td>{{ $sopir->nama_lengkap }}</td>
                                            <td>{{ $sopir->telp }}</td>
                                            <td> {{ number_format($sopir->tabungan, 0, ',', '.') }}
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="getSelectedData4a('{{ $sopir->id }}',
                                                    '{{ $sopir->kode_karyawan }}',
                                                    '{{ $sopir->nama_lengkap }}',
                                                    '{{ $sopir->tabungan }}',
                                                    )">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="tableSopir4b" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Sopir</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive scrollbar m-2">
                            <table id="pelepasan12" class="table table-bordered table-striped">
                                <thead class="bg-200 text-900">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Kode Sopir</th>
                                        <th>Nama Nama Sopir</th>
                                        <th>Tanggal</th>
                                        <th>Sisa Saldo</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($SopirAll as $sopir)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $sopir->kode_karyawan }}</td>
                                            <td>{{ $sopir->nama_lengkap }}</td>
                                            <td>{{ $sopir->telp }}</td>
                                            <td> {{ number_format($sopir->tabungan, 0, ',', '.') }}
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="getSelectedData4b('{{ $sopir->id }}',
                                                    '{{ $sopir->kode_karyawan }}',
                                                    '{{ $sopir->nama_lengkap }}',
                                                    '{{ $sopir->tabungan }}',
                                                    )">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="tableSopir4c" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Sopir</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive scrollbar m-2">
                            <table id="pelepasan13" class="table table-bordered table-striped">
                                <thead class="bg-200 text-900">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Kode Sopir</th>
                                        <th>Nama Nama Sopir</th>
                                        <th>Tanggal</th>
                                        <th>Sisa Saldo</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($SopirAll as $sopir)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $sopir->kode_karyawan }}</td>
                                            <td>{{ $sopir->nama_lengkap }}</td>
                                            <td>{{ $sopir->telp }}</td>
                                            <td> {{ number_format($sopir->tabungan, 0, ',', '.') }}
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="getSelectedData4c('{{ $sopir->id }}',
                                                    '{{ $sopir->kode_karyawan }}',
                                                    '{{ $sopir->nama_lengkap }}',
                                                    '{{ $sopir->tabungan }}',
                                                    )">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="tableSopir4d" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Sopir</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive scrollbar m-2">
                            <table id="pelepasan14" class="table table-bordered table-striped">
                                <thead class="bg-200 text-900">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Kode Sopir</th>
                                        <th>Nama Nama Sopir</th>
                                        <th>Tanggal</th>
                                        <th>Sisa Saldo</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($SopirAll as $sopir)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $sopir->kode_karyawan }}</td>
                                            <td>{{ $sopir->nama_lengkap }}</td>
                                            <td>{{ $sopir->telp }}</td>
                                            <td> {{ number_format($sopir->tabungan, 0, ',', '.') }}
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="getSelectedData4d('{{ $sopir->id }}',
                                                    '{{ $sopir->kode_karyawan }}',
                                                    '{{ $sopir->nama_lengkap }}',
                                                    '{{ $sopir->tabungan }}',
                                                    )">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="tableSopir5a" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Sopir</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive scrollbar m-2">
                            <table id="pelepasan15" class="table table-bordered table-striped">
                                <thead class="bg-200 text-900">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Kode Sopir</th>
                                        <th>Nama Nama Sopir</th>
                                        <th>Tanggal</th>
                                        <th>Sisa Saldo</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($SopirAll as $sopir)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $sopir->kode_karyawan }}</td>
                                            <td>{{ $sopir->nama_lengkap }}</td>
                                            <td>{{ $sopir->telp }}</td>
                                            <td> {{ number_format($sopir->tabungan, 0, ',', '.') }}
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="getSelectedData5a('{{ $sopir->id }}',
                                                    '{{ $sopir->kode_karyawan }}',
                                                    '{{ $sopir->nama_lengkap }}',
                                                    '{{ $sopir->tabungan }}',
                                                    )">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="tableSopir5b" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Sopir</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive scrollbar m-2">
                            <table id="pelepasan16" class="table table-bordered table-striped">
                                <thead class="bg-200 text-900">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Kode Sopir</th>
                                        <th>Nama Nama Sopir</th>
                                        <th>Tanggal</th>
                                        <th>Sisa Saldo</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($SopirAll as $sopir)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $sopir->kode_karyawan }}</td>
                                            <td>{{ $sopir->nama_lengkap }}</td>
                                            <td>{{ $sopir->telp }}</td>
                                            <td> {{ number_format($sopir->tabungan, 0, ',', '.') }}
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="getSelectedData5b('{{ $sopir->id }}',
                                                    '{{ $sopir->kode_karyawan }}',
                                                    '{{ $sopir->nama_lengkap }}',
                                                    '{{ $sopir->tabungan }}',
                                                    )">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="tableSopir5c" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Sopir</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive scrollbar m-2">
                            <table id="pelepasan17" class="table table-bordered table-striped">
                                <thead class="bg-200 text-900">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Kode Sopir</th>
                                        <th>Nama Nama Sopir</th>
                                        <th>Tanggal</th>
                                        <th>Sisa Saldo</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($SopirAll as $sopir)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $sopir->kode_karyawan }}</td>
                                            <td>{{ $sopir->nama_lengkap }}</td>
                                            <td>{{ $sopir->telp }}</td>
                                            <td> {{ number_format($sopir->tabungan, 0, ',', '.') }}
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="getSelectedData5c('{{ $sopir->id }}',
                                                    '{{ $sopir->kode_karyawan }}',
                                                    '{{ $sopir->nama_lengkap }}',
                                                    '{{ $sopir->tabungan }}',
                                                    )">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="tableSopir5d" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Sopir</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive scrollbar m-2">
                            <table id="pelepasan18" class="table table-bordered table-striped">
                                <thead class="bg-200 text-900">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Kode Sopir</th>
                                        <th>Nama Nama Sopir</th>
                                        <th>Tanggal</th>
                                        <th>Sisa Saldo</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($SopirAll as $sopir)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $sopir->kode_karyawan }}</td>
                                            <td>{{ $sopir->nama_lengkap }}</td>
                                            <td>{{ $sopir->telp }}</td>
                                            <td> {{ number_format($sopir->tabungan, 0, ',', '.') }}
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="getSelectedData5d('{{ $sopir->id }}',
                                                    '{{ $sopir->kode_karyawan }}',
                                                    '{{ $sopir->nama_lengkap }}',
                                                    '{{ $sopir->tabungan }}',
                                                    )">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="tableSopir6a" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Sopir</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive scrollbar m-2">
                            <table id="pelepasan19" class="table table-bordered table-striped">
                                <thead class="bg-200 text-900">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Kode Sopir</th>
                                        <th>Nama Nama Sopir</th>
                                        <th>Tanggal</th>
                                        <th>Sisa Saldo</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($SopirAll as $sopir)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $sopir->kode_karyawan }}</td>
                                            <td>{{ $sopir->nama_lengkap }}</td>
                                            <td>{{ $sopir->telp }}</td>
                                            <td> {{ number_format($sopir->tabungan, 0, ',', '.') }}
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="getSelectedData6a('{{ $sopir->id }}',
                                                    '{{ $sopir->kode_karyawan }}',
                                                    '{{ $sopir->nama_lengkap }}',
                                                    '{{ $sopir->tabungan }}',
                                                    )">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="tableSopir6b" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Sopir</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive scrollbar m-2">
                            <table id="pelepasan20" class="table table-bordered table-striped">
                                <thead class="bg-200 text-900">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Kode Sopir</th>
                                        <th>Nama Nama Sopir</th>
                                        <th>Tanggal</th>
                                        <th>Sisa Saldo</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($SopirAll as $sopir)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $sopir->kode_karyawan }}</td>
                                            <td>{{ $sopir->nama_lengkap }}</td>
                                            <td>{{ $sopir->telp }}</td>
                                            <td> {{ number_format($sopir->tabungan, 0, ',', '.') }}
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="getSelectedData6b('{{ $sopir->id }}',
                                                    '{{ $sopir->kode_karyawan }}',
                                                    '{{ $sopir->nama_lengkap }}',
                                                    '{{ $sopir->tabungan }}',
                                                    )">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="tableSopir6c" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Sopir</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive scrollbar m-2">
                            <table id="pelepasan21" class="table table-bordered table-striped">
                                <thead class="bg-200 text-900">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Kode Sopir</th>
                                        <th>Nama Nama Sopir</th>
                                        <th>Tanggal</th>
                                        <th>Sisa Saldo</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($SopirAll as $sopir)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $sopir->kode_karyawan }}</td>
                                            <td>{{ $sopir->nama_lengkap }}</td>
                                            <td>{{ $sopir->telp }}</td>
                                            <td> {{ number_format($sopir->tabungan, 0, ',', '.') }}
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="getSelectedData6c('{{ $sopir->id }}',
                                                    '{{ $sopir->kode_karyawan }}',
                                                    '{{ $sopir->nama_lengkap }}',
                                                    '{{ $sopir->tabungan }}',
                                                    )">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="tableSopir6d" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Sopir</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive scrollbar m-2">
                            <table id="pelepasan22" class="table table-bordered table-striped">
                                <thead class="bg-200 text-900">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Kode Sopir</th>
                                        <th>Nama Nama Sopir</th>
                                        <th>Tanggal</th>
                                        <th>Sisa Saldo</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($SopirAll as $sopir)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $sopir->kode_karyawan }}</td>
                                            <td>{{ $sopir->nama_lengkap }}</td>
                                            <td>{{ $sopir->telp }}</td>
                                            <td> {{ number_format($sopir->tabungan, 0, ',', '.') }}
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="getSelectedData6d('{{ $sopir->id }}',
                                                    '{{ $sopir->kode_karyawan }}',
                                                    '{{ $sopir->nama_lengkap }}',
                                                    '{{ $sopir->tabungan }}',
                                                    )">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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

    <script>
        function showSopir(selectedCategory) {
            $('#tableSopir').modal('show');
        }

        function formatCurrency(number) {
            // Check if the number is negative
            const isNegative = number < 0;

            // Format number as currency with period as thousands separator and comma as decimal separator
            const formattedNumber = new Intl.NumberFormat('id-ID', {
                // style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
            }).format(Math.abs(number)); // Use Math.abs() to work with the absolute value

            // Add a minus sign for negative numbers
            return isNegative ? `-${formattedNumber}` : formattedNumber;
        }


        function getSelectedData(Sopir_id, KodeSopir, NamaSopir, Tabungan) {
            // Set the values in the form fields
            document.getElementById('karyawan_id').value = Sopir_id;
            document.getElementById('kode_karyawan').value = KodeSopir;
            document.getElementById('nama_lengkap').value = NamaSopir;

            // Format Tabungan as currency with proper handling for negative values
            const formattedTabungan = formatCurrency(Tabungan);
            document.getElementById('sisa_saldo').value = formattedTabungan;

            // Parse numeric values from sisa_saldo and saldo_keluar
            const sisaSaldo = parseFloat(Tabungan.replace(/\D/g, ''));
            const saldoKeluar = parseFloat(document.getElementById('saldo_keluar').value.replace(/\D/g, ''));

            // Hitung sub_totals
            const subTotals = sisaSaldo - saldoKeluar;

            // Format sub_totals to locale currency
            const formattedSubTotals = formatCurrency(subTotals);
            document.getElementById('sub_totals').value = formattedSubTotals;

            // Close the modal (if needed)
            $('#tableSopir').modal('hide');

            // Mengatur kembali properti overflow-y pada modal axle
            $('#modal-exle_1A-{{ $kendaraan->id }}').css('overflow-y', 'auto');
        }
    </script>

    <script>
        function showSopir1b(selectedCategory) {
            $('#tableSopir1b').modal('show');
        }

        function formatCurrency(number) {
            // Check if the number is negative
            const isNegative = number < 0;

            // Format number as currency with period as thousands separator and comma as decimal separator
            const formattedNumber = new Intl.NumberFormat('id-ID', {
                // style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
            }).format(Math.abs(number)); // Use Math.abs() to work with the absolute value

            // Add a minus sign for negative numbers
            return isNegative ? `-${formattedNumber}` : formattedNumber;
        }


        function getSelectedData1b(Sopir_id, KodeSopir, NamaSopir, Tabungan) {
            // Set the values in the form fields
            document.getElementById('karyawan_id1b').value = Sopir_id;
            document.getElementById('kode_karyawan1b').value = KodeSopir;
            document.getElementById('nama_lengkap1b').value = NamaSopir;

            // Format Tabungan as currency with proper handling for negative values
            const formattedTabungan = formatCurrency(Tabungan);
            document.getElementById('sisa_saldo1b').value = formattedTabungan;

            // Parse numeric values from sisa_saldo and saldo_keluar
            const sisaSaldo = parseFloat(Tabungan.replace(/\D/g, ''));
            const saldoKeluar = parseFloat(document.getElementById('saldo_keluar1b').value.replace(/\D/g, ''));

            // Hitung sub_totals
            const subTotals = sisaSaldo - saldoKeluar;

            // Format sub_totals to locale currency
            const formattedSubTotals = formatCurrency(subTotals);
            document.getElementById('sub_totals1b').value = formattedSubTotals;

            // Close the modal (if needed)
            $('#tableSopir1b').modal('hide');

            // Mengatur kembali properti overflow-y pada modal axle
            $('#modal-exle_1B-{{ $kendaraan->id }}').css('overflow-y', 'auto');
        }
    </script>

    <script>
        function showSopir2a(selectedCategory) {
            $('#tableSopir2a').modal('show');
        }

        function formatCurrency(number) {
            // Check if the number is negative
            const isNegative = number < 0;

            // Format number as currency with period as thousands separator and comma as decimal separator
            const formattedNumber = new Intl.NumberFormat('id-ID', {
                // style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
            }).format(Math.abs(number)); // Use Math.abs() to work with the absolute value

            // Add a minus sign for negative numbers
            return isNegative ? `-${formattedNumber}` : formattedNumber;
        }


        function getSelectedData2a(Sopir_id, KodeSopir, NamaSopir, Tabungan) {
            // Set the values in the form fields
            document.getElementById('karyawan_id2a').value = Sopir_id;
            document.getElementById('kode_karyawan2a').value = KodeSopir;
            document.getElementById('nama_lengkap2a').value = NamaSopir;

            // Format Tabungan as currency with proper handling for negative values
            const formattedTabungan = formatCurrency(Tabungan);
            document.getElementById('sisa_saldo2a').value = formattedTabungan;

            // Parse numeric values from sisa_saldo and saldo_keluar
            const sisaSaldo = parseFloat(Tabungan.replace(/\D/g, ''));
            const saldoKeluar = parseFloat(document.getElementById('saldo_keluar2a').value.replace(/\D/g, ''));

            // Hitung sub_totals
            const subTotals = sisaSaldo - saldoKeluar;

            // Format sub_totals to locale currency
            const formattedSubTotals = formatCurrency(subTotals);
            document.getElementById('sub_totals2a').value = formattedSubTotals;

            // Close the modal (if needed)
            $('#tableSopir2a').modal('hide');

            // Mengatur kembali properti overflow-y pada modal axle
            $('#modal-exle_2A-{{ $kendaraan->id }}').css('overflow-y', 'auto');
        }
    </script>

    <script>
        function showSopir2b(selectedCategory) {
            $('#tableSopir2b').modal('show');
        }

        function formatCurrency(number) {
            // Check if the number is negative
            const isNegative = number < 0;

            // Format number as currency with period as thousands separator and comma as decimal separator
            const formattedNumber = new Intl.NumberFormat('id-ID', {
                // style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
            }).format(Math.abs(number)); // Use Math.abs() to work with the absolute value

            // Add a minus sign for negative numbers
            return isNegative ? `-${formattedNumber}` : formattedNumber;
        }

        function getSelectedData2b(Sopir_id, KodeSopir, NamaSopir, Tabungan) {
            // Set the values in the form fields
            document.getElementById('karyawan_id2b').value = Sopir_id;
            document.getElementById('kode_karyawan2b').value = KodeSopir;
            document.getElementById('nama_lengkap2b').value = NamaSopir;

            // Format Tabungan as currency with proper handling for negative values
            const formattedTabungan = formatCurrency(Tabungan);
            document.getElementById('sisa_saldo2b').value = formattedTabungan;

            // Parse numeric values from sisa_saldo and saldo_keluar
            const sisaSaldo = parseFloat(Tabungan.replace(/\D/g, ''));
            const saldoKeluar = parseFloat(document.getElementById('saldo_keluar2b').value.replace(/\D/g, ''));

            // Hitung sub_totals
            const subTotals = sisaSaldo - saldoKeluar;

            // Format sub_totals to locale currency
            const formattedSubTotals = formatCurrency(subTotals);
            document.getElementById('sub_totals2b').value = formattedSubTotals;

            // Close the modal (if needed)
            $('#tableSopir2b').modal('hide');

            // Mengatur kembali properti overflow-y pada modal axle
            $('#modal-exle_2B-{{ $kendaraan->id }}').css('overflow-y', 'auto');
        }
    </script>

    <script>
        function showSopir2c(selectedCategory) {
            $('#tableSopir2c').modal('show');
        }

        function formatCurrency(number) {
            // Check if the number is negative
            const isNegative = number < 0;

            // Format number as currency with period as thousands separator and comma as decimal separator
            const formattedNumber = new Intl.NumberFormat('id-ID', {
                // style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
            }).format(Math.abs(number)); // Use Math.abs() to work with the absolute value

            // Add a minus sign for negative numbers
            return isNegative ? `-${formattedNumber}` : formattedNumber;
        }

        function getSelectedData2c(Sopir_id, KodeSopir, NamaSopir, Tabungan) {
            // Set the values in the form fields
            document.getElementById('karyawan_id2c').value = Sopir_id;
            document.getElementById('kode_karyawan2c').value = KodeSopir;
            document.getElementById('nama_lengkap2c').value = NamaSopir;

            // Format Tabungan as currency with proper handling for negative values
            const formattedTabungan = formatCurrency(Tabungan);
            document.getElementById('sisa_saldo2c').value = formattedTabungan;

            // Parse numeric values from sisa_saldo and saldo_keluar
            const sisaSaldo = parseFloat(Tabungan.replace(/\D/g, ''));
            const saldoKeluar = parseFloat(document.getElementById('saldo_keluar2c').value.replace(/\D/g, ''));

            // Hitung sub_totals
            const subTotals = sisaSaldo - saldoKeluar;

            // Format sub_totals to locale currency
            const formattedSubTotals = formatCurrency(subTotals);
            document.getElementById('sub_totals2c').value = formattedSubTotals;

            // Close the modal (if needed)
            $('#tableSopir2c').modal('hide');

            // Mengatur kembali properti overflow-y pada modal axle
            $('#modal-exle_2C-{{ $kendaraan->id }}').css('overflow-y', 'auto');
        }
    </script>

    <script>
        function showSopir2d(selectedCategory) {
            $('#tableSopir2d').modal('show');
        }

        function formatCurrency(number) {
            // Check if the number is negative
            const isNegative = number < 0;

            // Format number as currency with period as thousands separator and comma as decimal separator
            const formattedNumber = new Intl.NumberFormat('id-ID', {
                // style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
            }).format(Math.abs(number)); // Use Math.abs() to work with the absolute value

            // Add a minus sign for negative numbers
            return isNegative ? `-${formattedNumber}` : formattedNumber;
        }

        function getSelectedData2d(Sopir_id, KodeSopir, NamaSopir, Tabungan) {
            // Set the values in the form fields
            document.getElementById('karyawan_id2d').value = Sopir_id;
            document.getElementById('kode_karyawan2d').value = KodeSopir;
            document.getElementById('nama_lengkap2d').value = NamaSopir;

            // Format Tabungan as currency with proper handling for negative values
            const formattedTabungan = formatCurrency(Tabungan);
            document.getElementById('sisa_saldo2d').value = formattedTabungan;

            // Parse numeric values from sisa_saldo and saldo_keluar
            const sisaSaldo = parseFloat(Tabungan.replace(/\D/g, ''));
            const saldoKeluar = parseFloat(document.getElementById('saldo_keluar2d').value.replace(/\D/g, ''));

            // Hitung sub_totals
            const subTotals = sisaSaldo - saldoKeluar;

            // Format sub_totals to locale currency
            const formattedSubTotals = formatCurrency(subTotals);
            document.getElementById('sub_totals2d').value = formattedSubTotals;

            // Close the modal (if needed)
            $('#tableSopir2d').modal('hide');

            // Mengatur kembali properti overflow-y pada modal axle
            $('#modal-exle_2D-{{ $kendaraan->id }}').css('overflow-y', 'auto');
        }
    </script>

    <script>
        function showSopir3a(selectedCategory) {
            $('#tableSopir3a').modal('show');
        }

        function formatCurrency(number) {
            // Check if the number is negative
            const isNegative = number < 0;

            // Format number as currency with period as thousands separator and comma as decimal separator
            const formattedNumber = new Intl.NumberFormat('id-ID', {
                // style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
            }).format(Math.abs(number)); // Use Math.abs() to work with the absolute value

            // Add a minus sign for negative numbers
            return isNegative ? `-${formattedNumber}` : formattedNumber;
        }

        function getSelectedData3a(Sopir_id, KodeSopir, NamaSopir, Tabungan) {
            // Set the values in the form fields
            document.getElementById('karyawan_id3a').value = Sopir_id;
            document.getElementById('kode_karyawan3a').value = KodeSopir;
            document.getElementById('nama_lengkap3a').value = NamaSopir;

            // Format Tabungan as currency with proper handling for negative values
            const formattedTabungan = formatCurrency(Tabungan);
            document.getElementById('sisa_saldo3a').value = formattedTabungan;

            // Parse numeric values from sisa_saldo and saldo_keluar
            const sisaSaldo = parseFloat(Tabungan.replace(/\D/g, ''));
            const saldoKeluar = parseFloat(document.getElementById('saldo_keluar3a').value.replace(/\D/g, ''));

            // Hitung sub_totals
            const subTotals = sisaSaldo - saldoKeluar;

            // Format sub_totals to locale currency
            const formattedSubTotals = formatCurrency(subTotals);
            document.getElementById('sub_totals3a').value = formattedSubTotals;

            // Close the modal (if needed)
            $('#tableSopir3a').modal('hide');

            // Mengatur kembali properti overflow-y pada modal axle
            $('#modal-exle_3A-{{ $kendaraan->id }}').css('overflow-y', 'auto');
        }
    </script>

    <script>
        function showSopir3b(selectedCategory) {
            $('#tableSopir3b').modal('show');
        }

        function formatCurrency(number) {
            // Check if the number is negative
            const isNegative = number < 0;

            // Format number as currency with period as thousands separator and comma as decimal separator
            const formattedNumber = new Intl.NumberFormat('id-ID', {
                // style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
            }).format(Math.abs(number)); // Use Math.abs() to work with the absolute value

            // Add a minus sign for negative numbers
            return isNegative ? `-${formattedNumber}` : formattedNumber;
        }

        function getSelectedData3b(Sopir_id, KodeSopir, NamaSopir, Tabungan) {
            // Set the values in the form fields
            document.getElementById('karyawan_id3b').value = Sopir_id;
            document.getElementById('kode_karyawan3b').value = KodeSopir;
            document.getElementById('nama_lengkap3b').value = NamaSopir;

            // Format Tabungan as currency with proper handling for negative values
            const formattedTabungan = formatCurrency(Tabungan);
            document.getElementById('sisa_saldo3b').value = formattedTabungan;

            // Parse numeric values from sisa_saldo and saldo_keluar
            const sisaSaldo = parseFloat(Tabungan.replace(/\D/g, ''));
            const saldoKeluar = parseFloat(document.getElementById('saldo_keluar3b').value.replace(/\D/g, ''));

            // Hitung sub_totals
            const subTotals = sisaSaldo - saldoKeluar;

            // Format sub_totals to locale currency
            const formattedSubTotals = formatCurrency(subTotals);
            document.getElementById('sub_totals3b').value = formattedSubTotals;

            // Close the modal (if needed)
            $('#tableSopir3b').modal('hide');

            // Mengatur kembali properti overflow-y pada modal axle
            $('#modal-exle_3B-{{ $kendaraan->id }}').css('overflow-y', 'auto');
        }
    </script>

    <script>
        function showSopir3c(selectedCategory) {
            $('#tableSopir3c').modal('show');
        }

        function formatCurrency(number) {
            // Check if the number is negative
            const isNegative = number < 0;

            // Format number as currency with period as thousands separator and comma as decimal separator
            const formattedNumber = new Intl.NumberFormat('id-ID', {
                // style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
            }).format(Math.abs(number)); // Use Math.abs() to work with the absolute value

            // Add a minus sign for negative numbers
            return isNegative ? `-${formattedNumber}` : formattedNumber;
        }

        function getSelectedData3c(Sopir_id, KodeSopir, NamaSopir, Tabungan) {
            // Set the values in the form fields
            document.getElementById('karyawan_id3c').value = Sopir_id;
            document.getElementById('kode_karyawan3c').value = KodeSopir;
            document.getElementById('nama_lengkap3c').value = NamaSopir;

            // Format Tabungan as currency with proper handling for negative values
            const formattedTabungan = formatCurrency(Tabungan);
            document.getElementById('sisa_saldo3c').value = formattedTabungan;

            // Parse numeric values from sisa_saldo and saldo_keluar
            const sisaSaldo = parseFloat(Tabungan.replace(/\D/g, ''));
            const saldoKeluar = parseFloat(document.getElementById('saldo_keluar3c').value.replace(/\D/g, ''));

            // Hitung sub_totals
            const subTotals = sisaSaldo - saldoKeluar;

            // Format sub_totals to locale currency
            const formattedSubTotals = formatCurrency(subTotals);
            document.getElementById('sub_totals3c').value = formattedSubTotals;

            // Close the modal (if needed)
            $('#tableSopir3c').modal('hide');

            // Mengatur kembali properti overflow-y pada modal axle
            $('#modal-exle_3C-{{ $kendaraan->id }}').css('overflow-y', 'auto');
        }
    </script>

    <script>
        function showSopir3d(selectedCategory) {
            $('#tableSopir3d').modal('show');
        }

        function formatCurrency(number) {
            // Check if the number is negative
            const isNegative = number < 0;

            // Format number as currency with period as thousands separator and comma as decimal separator
            const formattedNumber = new Intl.NumberFormat('id-ID', {
                // style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
            }).format(Math.abs(number)); // Use Math.abs() to work with the absolute value

            // Add a minus sign for negative numbers
            return isNegative ? `-${formattedNumber}` : formattedNumber;
        }

        function getSelectedData3d(Sopir_id, KodeSopir, NamaSopir, Tabungan) {
            // Set the values in the form fields
            document.getElementById('karyawan_id3d').value = Sopir_id;
            document.getElementById('kode_karyawan3d').value = KodeSopir;
            document.getElementById('nama_lengkap3d').value = NamaSopir;

            // Format Tabungan as currency with proper handling for negative values
            const formattedTabungan = formatCurrency(Tabungan);
            document.getElementById('sisa_saldo3d').value = formattedTabungan;

            // Parse numeric values from sisa_saldo and saldo_keluar
            const sisaSaldo = parseFloat(Tabungan.replace(/\D/g, ''));
            const saldoKeluar = parseFloat(document.getElementById('saldo_keluar3d').value.replace(/\D/g, ''));

            // Hitung sub_totals
            const subTotals = sisaSaldo - saldoKeluar;

            // Format sub_totals to locale currency
            const formattedSubTotals = formatCurrency(subTotals);
            document.getElementById('sub_totals3d').value = formattedSubTotals;

            // Close the modal (if needed)
            $('#tableSopir3d').modal('hide');

            // Mengatur kembali properti overflow-y pada modal axle
            $('#modal-exle_3D-{{ $kendaraan->id }}').css('overflow-y', 'auto');
        }
    </script>

    <script>
        function showSopir4a(selectedCategory) {
            $('#tableSopir4a').modal('show');
        }

        function formatCurrency(number) {
            // Check if the number is negative
            const isNegative = number < 0;

            // Format number as currency with period as thousands separator and comma as decimal separator
            const formattedNumber = new Intl.NumberFormat('id-ID', {
                // style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
            }).format(Math.abs(number)); // Use Math.abs() to work with the absolute value

            // Add a minus sign for negative numbers
            return isNegative ? `-${formattedNumber}` : formattedNumber;
        }

        function getSelectedData4a(Sopir_id, KodeSopir, NamaSopir, Tabungan) {
            // Set the values in the form fields
            document.getElementById('karyawan_id4a').value = Sopir_id;
            document.getElementById('kode_karyawan4a').value = KodeSopir;
            document.getElementById('nama_lengkap4a').value = NamaSopir;

            // Format Tabungan as currency with proper handling for negative values
            const formattedTabungan = formatCurrency(Tabungan);
            document.getElementById('sisa_saldo4a').value = formattedTabungan;

            // Parse numeric values from sisa_saldo and saldo_keluar
            const sisaSaldo = parseFloat(Tabungan.replace(/\D/g, ''));
            const saldoKeluar = parseFloat(document.getElementById('saldo_keluar4a').value.replace(/\D/g, ''));

            // Hitung sub_totals
            const subTotals = sisaSaldo - saldoKeluar;

            // Format sub_totals to locale currency
            const formattedSubTotals = formatCurrency(subTotals);
            document.getElementById('sub_totals4a').value = formattedSubTotals;

            // Close the modal (if needed)
            $('#tableSopir4a').modal('hide');

            // Mengatur kembali properti overflow-y pada modal axle
            $('#modal-exle_4A-{{ $kendaraan->id }}').css('overflow-y', 'auto');
        }
    </script>

    <script>
        function showSopir4b(selectedCategory) {
            $('#tableSopir4b').modal('show');
        }

        function formatCurrency(number) {
            // Check if the number is negative
            const isNegative = number < 0;

            // Format number as currency with period as thousands separator and comma as decimal separator
            const formattedNumber = new Intl.NumberFormat('id-ID', {
                // style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
            }).format(Math.abs(number)); // Use Math.abs() to work with the absolute value

            // Add a minus sign for negative numbers
            return isNegative ? `-${formattedNumber}` : formattedNumber;
        }

        function getSelectedData4b(Sopir_id, KodeSopir, NamaSopir, Tabungan) {
            // Set the values in the form fields
            document.getElementById('karyawan_id4b').value = Sopir_id;
            document.getElementById('kode_karyawan4b').value = KodeSopir;
            document.getElementById('nama_lengkap4b').value = NamaSopir;

            // Format Tabungan as currency with proper handling for negative values
            const formattedTabungan = formatCurrency(Tabungan);
            document.getElementById('sisa_saldo4b').value = formattedTabungan;

            // Parse numeric values from sisa_saldo and saldo_keluar
            const sisaSaldo = parseFloat(Tabungan.replace(/\D/g, ''));
            const saldoKeluar = parseFloat(document.getElementById('saldo_keluar4b').value.replace(/\D/g, ''));

            // Hitung sub_totals
            const subTotals = sisaSaldo - saldoKeluar;

            // Format sub_totals to locale currency
            const formattedSubTotals = formatCurrency(subTotals);
            document.getElementById('sub_totals4b').value = formattedSubTotals;

            // Close the modal (if needed)
            $('#tableSopir4b').modal('hide');

            // Mengatur kembali properti overflow-y pada modal axle
            $('#modal-exle_4B-{{ $kendaraan->id }}').css('overflow-y', 'auto');
        }
    </script>

    <script>
        function showSopir4c(selectedCategory) {
            $('#tableSopir4c').modal('show');
        }

        function formatCurrency(number) {
            // Check if the number is negative
            const isNegative = number < 0;

            // Format number as currency with period as thousands separator and comma as decimal separator
            const formattedNumber = new Intl.NumberFormat('id-ID', {
                // style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
            }).format(Math.abs(number)); // Use Math.abs() to work with the absolute value

            // Add a minus sign for negative numbers
            return isNegative ? `-${formattedNumber}` : formattedNumber;
        }

        function getSelectedData4c(Sopir_id, KodeSopir, NamaSopir, Tabungan) {
            // Set the values in the form fields
            document.getElementById('karyawan_id4c').value = Sopir_id;
            document.getElementById('kode_karyawan4c').value = KodeSopir;
            document.getElementById('nama_lengkap4c').value = NamaSopir;

            // Format Tabungan as currency with proper handling for negative values
            const formattedTabungan = formatCurrency(Tabungan);
            document.getElementById('sisa_saldo4c').value = formattedTabungan;

            // Parse numeric values from sisa_saldo and saldo_keluar
            const sisaSaldo = parseFloat(Tabungan.replace(/\D/g, ''));
            const saldoKeluar = parseFloat(document.getElementById('saldo_keluar4c').value.replace(/\D/g, ''));

            // Hitung sub_totals
            const subTotals = sisaSaldo - saldoKeluar;

            // Format sub_totals to locale currency
            const formattedSubTotals = formatCurrency(subTotals);
            document.getElementById('sub_totals4c').value = formattedSubTotals;

            // Close the modal (if needed)
            $('#tableSopir4c').modal('hide');

            // Mengatur kembali properti overflow-y pada modal axle
            $('#modal-exle_4C-{{ $kendaraan->id }}').css('overflow-y', 'auto');
        }
    </script>

    <script>
        function showSopir4d(selectedCategory) {
            $('#tableSopir4d').modal('show');
        }

        function formatCurrency(number) {
            // Check if the number is negative
            const isNegative = number < 0;

            // Format number as currency with period as thousands separator and comma as decimal separator
            const formattedNumber = new Intl.NumberFormat('id-ID', {
                // style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
            }).format(Math.abs(number)); // Use Math.abs() to work with the absolute value

            // Add a minus sign for negative numbers
            return isNegative ? `-${formattedNumber}` : formattedNumber;
        }

        function getSelectedData4d(Sopir_id, KodeSopir, NamaSopir, Tabungan) {
            // Set the values in the form fields
            document.getElementById('karyawan_id4d').value = Sopir_id;
            document.getElementById('kode_karyawan4d').value = KodeSopir;
            document.getElementById('nama_lengkap4d').value = NamaSopir;

            // Format Tabungan as currency with proper handling for negative values
            const formattedTabungan = formatCurrency(Tabungan);
            document.getElementById('sisa_saldo4d').value = formattedTabungan;

            // Parse numeric values from sisa_saldo and saldo_keluar
            const sisaSaldo = parseFloat(Tabungan.replace(/\D/g, ''));
            const saldoKeluar = parseFloat(document.getElementById('saldo_keluar4d').value.replace(/\D/g, ''));

            // Hitung sub_totals
            const subTotals = sisaSaldo - saldoKeluar;

            // Format sub_totals to locale currency
            const formattedSubTotals = formatCurrency(subTotals);
            document.getElementById('sub_totals4d').value = formattedSubTotals;

            // Close the modal (if needed)
            $('#tableSopir4d').modal('hide');

            // Mengatur kembali properti overflow-y pada modal axle
            $('#modal-exle_4D-{{ $kendaraan->id }}').css('overflow-y', 'auto');
        }
    </script>

    <script>
        function showSopir5a(selectedCategory) {
            $('#tableSopir5a').modal('show');
        }

        function formatCurrency(number) {
            // Check if the number is negative
            const isNegative = number < 0;

            // Format number as currency with period as thousands separator and comma as decimal separator
            const formattedNumber = new Intl.NumberFormat('id-ID', {
                // style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
            }).format(Math.abs(number)); // Use Math.abs() to work with the absolute value

            // Add a minus sign for negative numbers
            return isNegative ? `-${formattedNumber}` : formattedNumber;
        }

        function getSelectedData5a(Sopir_id, KodeSopir, NamaSopir, Tabungan) {
            // Set the values in the form fields
            document.getElementById('karyawan_id5a').value = Sopir_id;
            document.getElementById('kode_karyawan5a').value = KodeSopir;
            document.getElementById('nama_lengkap5a').value = NamaSopir;

            // Format Tabungan as currency with proper handling for negative values
            const formattedTabungan = formatCurrency(Tabungan);
            document.getElementById('sisa_saldo5a').value = formattedTabungan;

            // Parse numeric values from sisa_saldo and saldo_keluar
            const sisaSaldo = parseFloat(Tabungan.replace(/\D/g, ''));
            const saldoKeluar = parseFloat(document.getElementById('saldo_keluar5a').value.replace(/\D/g, ''));

            // Hitung sub_totals
            const subTotals = sisaSaldo - saldoKeluar;

            // Format sub_totals to locale currency
            const formattedSubTotals = formatCurrency(subTotals);
            document.getElementById('sub_totals5a').value = formattedSubTotals;

            // Close the modal (if needed)
            $('#tableSopir5a').modal('hide');

            // Mengatur kembali properti overflow-y pada modal axle
            $('#modal-exle_5A-{{ $kendaraan->id }}').css('overflow-y', 'auto');
        }
    </script>

    <script>
        function showSopir5b(selectedCategory) {
            $('#tableSopir5b').modal('show');
        }

        function formatCurrency(number) {
            // Check if the number is negative
            const isNegative = number < 0;

            // Format number as currency with period as thousands separator and comma as decimal separator
            const formattedNumber = new Intl.NumberFormat('id-ID', {
                // style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
            }).format(Math.abs(number)); // Use Math.abs() to work with the absolute value

            // Add a minus sign for negative numbers
            return isNegative ? `-${formattedNumber}` : formattedNumber;
        }

        function getSelectedData5b(Sopir_id, KodeSopir, NamaSopir, Tabungan) {
            // Set the values in the form fields
            document.getElementById('karyawan_id5b').value = Sopir_id;
            document.getElementById('kode_karyawan5b').value = KodeSopir;
            document.getElementById('nama_lengkap5b').value = NamaSopir;

            // Format Tabungan as currency with proper handling for negative values
            const formattedTabungan = formatCurrency(Tabungan);
            document.getElementById('sisa_saldo5b').value = formattedTabungan;

            // Parse numeric values from sisa_saldo and saldo_keluar
            const sisaSaldo = parseFloat(Tabungan.replace(/\D/g, ''));
            const saldoKeluar = parseFloat(document.getElementById('saldo_keluar5b').value.replace(/\D/g, ''));

            // Hitung sub_totals
            const subTotals = sisaSaldo - saldoKeluar;

            // Format sub_totals to locale currency
            const formattedSubTotals = formatCurrency(subTotals);
            document.getElementById('sub_totals5b').value = formattedSubTotals;

            // Close the modal (if needed)
            $('#tableSopir5b').modal('hide');

            // Mengatur kembali properti overflow-y pada modal axle
            $('#modal-exle_5B-{{ $kendaraan->id }}').css('overflow-y', 'auto');
        }
    </script>

    <script>
        function showSopir5c(selectedCategory) {
            $('#tableSopir5c').modal('show');
        }

        function formatCurrency(number) {
            // Check if the number is negative
            const isNegative = number < 0;

            // Format number as currency with period as thousands separator and comma as decimal separator
            const formattedNumber = new Intl.NumberFormat('id-ID', {
                // style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
            }).format(Math.abs(number)); // Use Math.abs() to work with the absolute value

            // Add a minus sign for negative numbers
            return isNegative ? `-${formattedNumber}` : formattedNumber;
        }

        function getSelectedData5c(Sopir_id, KodeSopir, NamaSopir, Tabungan) {
            // Set the values in the form fields
            document.getElementById('karyawan_id5c').value = Sopir_id;
            document.getElementById('kode_karyawan5c').value = KodeSopir;
            document.getElementById('nama_lengkap5c').value = NamaSopir;

            // Format Tabungan as currency with proper handling for negative values
            const formattedTabungan = formatCurrency(Tabungan);
            document.getElementById('sisa_saldo5c').value = formattedTabungan;

            // Parse numeric values from sisa_saldo and saldo_keluar
            const sisaSaldo = parseFloat(Tabungan.replace(/\D/g, ''));
            const saldoKeluar = parseFloat(document.getElementById('saldo_keluar5c').value.replace(/\D/g, ''));

            // Hitung sub_totals
            const subTotals = sisaSaldo - saldoKeluar;

            // Format sub_totals to locale currency
            const formattedSubTotals = formatCurrency(subTotals);
            document.getElementById('sub_totals5c').value = formattedSubTotals;

            // Close the modal (if needed)
            $('#tableSopir5c').modal('hide');

            // Mengatur kembali properti overflow-y pada modal axle
            $('#modal-exle_5C-{{ $kendaraan->id }}').css('overflow-y', 'auto');
        }
    </script>

    <script>
        function showSopir5d(selectedCategory) {
            $('#tableSopir5d').modal('show');
        }

        function formatCurrency(number) {
            // Check if the number is negative
            const isNegative = number < 0;

            // Format number as currency with period as thousands separator and comma as decimal separator
            const formattedNumber = new Intl.NumberFormat('id-ID', {
                // style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
            }).format(Math.abs(number)); // Use Math.abs() to work with the absolute value

            // Add a minus sign for negative numbers
            return isNegative ? `-${formattedNumber}` : formattedNumber;
        }

        function getSelectedData5d(Sopir_id, KodeSopir, NamaSopir, Tabungan) {
            // Set the values in the form fields
            document.getElementById('karyawan_id5d').value = Sopir_id;
            document.getElementById('kode_karyawan5d').value = KodeSopir;
            document.getElementById('nama_lengkap5d').value = NamaSopir;

            // Format Tabungan as currency with proper handling for negative values
            const formattedTabungan = formatCurrency(Tabungan);
            document.getElementById('sisa_saldo5d').value = formattedTabungan;

            // Parse numeric values from sisa_saldo and saldo_keluar
            const sisaSaldo = parseFloat(Tabungan.replace(/\D/g, ''));
            const saldoKeluar = parseFloat(document.getElementById('saldo_keluar5d').value.replace(/\D/g, ''));

            // Hitung sub_totals
            const subTotals = sisaSaldo - saldoKeluar;

            // Format sub_totals to locale currency
            const formattedSubTotals = formatCurrency(subTotals);
            document.getElementById('sub_totals5d').value = formattedSubTotals;

            // Close the modal (if needed)
            $('#tableSopir5d').modal('hide');

            // Mengatur kembali properti overflow-y pada modal axle
            $('#modal-exle_5D-{{ $kendaraan->id }}').css('overflow-y', 'auto');
        }
    </script>

    <script>
        function showSopir6a(selectedCategory) {
            $('#tableSopir6a').modal('show');
        }

        function formatCurrency(number) {
            // Check if the number is negative
            const isNegative = number < 0;

            // Format number as currency with period as thousands separator and comma as decimal separator
            const formattedNumber = new Intl.NumberFormat('id-ID', {
                // style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
            }).format(Math.abs(number)); // Use Math.abs() to work with the absolute value

            // Add a minus sign for negative numbers
            return isNegative ? `-${formattedNumber}` : formattedNumber;
        }

        function getSelectedData6a(Sopir_id, KodeSopir, NamaSopir, Tabungan) {
            // Set the values in the form fields
            document.getElementById('karyawan_id6a').value = Sopir_id;
            document.getElementById('kode_karyawan6a').value = KodeSopir;
            document.getElementById('nama_lengkap6a').value = NamaSopir;

            // Format Tabungan as currency with proper handling for negative values
            const formattedTabungan = formatCurrency(Tabungan);
            document.getElementById('sisa_saldo6a').value = formattedTabungan;

            // Parse numeric values from sisa_saldo and saldo_keluar
            const sisaSaldo = parseFloat(Tabungan.replace(/\D/g, ''));
            const saldoKeluar = parseFloat(document.getElementById('saldo_keluar6a').value.replace(/\D/g, ''));

            // Hitung sub_totals
            const subTotals = sisaSaldo - saldoKeluar;

            // Format sub_totals to locale currency
            const formattedSubTotals = formatCurrency(subTotals);
            document.getElementById('sub_totals6a').value = formattedSubTotals;

            // Close the modal (if needed)
            $('#tableSopir6a').modal('hide');

            // Mengatur kembali properti overflow-y pada modal axle
            $('#modal-exle_6A-{{ $kendaraan->id }}').css('overflow-y', 'auto');
        }
    </script>

    <script>
        function showSopir6b(selectedCategory) {
            $('#tableSopir6b').modal('show');
        }

        function formatCurrency(number) {
            // Check if the number is negative
            const isNegative = number < 0;

            // Format number as currency with period as thousands separator and comma as decimal separator
            const formattedNumber = new Intl.NumberFormat('id-ID', {
                // style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
            }).format(Math.abs(number)); // Use Math.abs() to work with the absolute value

            // Add a minus sign for negative numbers
            return isNegative ? `-${formattedNumber}` : formattedNumber;
        }

        function getSelectedData6b(Sopir_id, KodeSopir, NamaSopir, Tabungan) {
            // Set the values in the form fields
            document.getElementById('karyawan_id6b').value = Sopir_id;
            document.getElementById('kode_karyawan6b').value = KodeSopir;
            document.getElementById('nama_lengkap6b').value = NamaSopir;

            // Format Tabungan as currency with proper handling for negative values
            const formattedTabungan = formatCurrency(Tabungan);
            document.getElementById('sisa_saldo6b').value = formattedTabungan;

            // Parse numeric values from sisa_saldo and saldo_keluar
            const sisaSaldo = parseFloat(Tabungan.replace(/\D/g, ''));
            const saldoKeluar = parseFloat(document.getElementById('saldo_keluar6b').value.replace(/\D/g, ''));

            // Hitung sub_totals
            const subTotals = sisaSaldo - saldoKeluar;

            // Format sub_totals to locale currency
            const formattedSubTotals = formatCurrency(subTotals);
            document.getElementById('sub_totals6b').value = formattedSubTotals;

            // Close the modal (if needed)
            $('#tableSopir6b').modal('hide');

            // Mengatur kembali properti overflow-y pada modal axle
            $('#modal-exle_6B-{{ $kendaraan->id }}').css('overflow-y', 'auto');
        }
    </script>

    <script>
        function showSopir6c(selectedCategory) {
            $('#tableSopir6c').modal('show');
        }

        function formatCurrency(number) {
            // Check if the number is negative
            const isNegative = number < 0;

            // Format number as currency with period as thousands separator and comma as decimal separator
            const formattedNumber = new Intl.NumberFormat('id-ID', {
                // style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
            }).format(Math.abs(number)); // Use Math.abs() to work with the absolute value

            // Add a minus sign for negative numbers
            return isNegative ? `-${formattedNumber}` : formattedNumber;
        }

        function getSelectedData6c(Sopir_id, KodeSopir, NamaSopir, Tabungan) {
            // Set the values in the form fields
            document.getElementById('karyawan_id6c').value = Sopir_id;
            document.getElementById('kode_karyawan6c').value = KodeSopir;
            document.getElementById('nama_lengkap6c').value = NamaSopir;

            // Format Tabungan as currency with proper handling for negative values
            const formattedTabungan = formatCurrency(Tabungan);
            document.getElementById('sisa_saldo6c').value = formattedTabungan;

            // Parse numeric values from sisa_saldo and saldo_keluar
            const sisaSaldo = parseFloat(Tabungan.replace(/\D/g, ''));
            const saldoKeluar = parseFloat(document.getElementById('saldo_keluar6c').value.replace(/\D/g, ''));

            // Hitung sub_totals
            const subTotals = sisaSaldo - saldoKeluar;

            // Format sub_totals to locale currency
            const formattedSubTotals = formatCurrency(subTotals);
            document.getElementById('sub_totals6c').value = formattedSubTotals;

            // Close the modal (if needed)
            $('#tableSopir6c').modal('hide');

            // Mengatur kembali properti overflow-y pada modal axle
            $('#modal-exle_6C-{{ $kendaraan->id }}').css('overflow-y', 'auto');
        }
    </script>

    <script>
        function showSopir6d(selectedCategory) {
            $('#tableSopir6d').modal('show');
        }

        function formatCurrency(number) {
            // Check if the number is negative
            const isNegative = number < 0;

            // Format number as currency with period as thousands separator and comma as decimal separator
            const formattedNumber = new Intl.NumberFormat('id-ID', {
                // style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
            }).format(Math.abs(number)); // Use Math.abs() to work with the absolute value

            // Add a minus sign for negative numbers
            return isNegative ? `-${formattedNumber}` : formattedNumber;
        }

        function getSelectedData6d(Sopir_id, KodeSopir, NamaSopir, Tabungan) {
            // Set the values in the form fields
            document.getElementById('karyawan_id6d').value = Sopir_id;
            document.getElementById('kode_karyawan6d').value = KodeSopir;
            document.getElementById('nama_lengkap6d').value = NamaSopir;

            // Format Tabungan as currency with proper handling for negative values
            const formattedTabungan = formatCurrency(Tabungan);
            document.getElementById('sisa_saldo6d').value = formattedTabungan;

            // Parse numeric values from sisa_saldo and saldo_keluar
            const sisaSaldo = parseFloat(Tabungan.replace(/\D/g, ''));
            const saldoKeluar = parseFloat(document.getElementById('saldo_keluar6d').value.replace(/\D/g, ''));

            // Hitung sub_totals
            const subTotals = sisaSaldo - saldoKeluar;

            // Format sub_totals to locale currency
            const formattedSubTotals = formatCurrency(subTotals);
            document.getElementById('sub_totals6d').value = formattedSubTotals;

            // Close the modal (if needed)
            $('#tableSopir6d').modal('hide');

            // Mengatur kembali properti overflow-y pada modal axle
            $('#modal-exle_6D-{{ $kendaraan->id }}').css('overflow-y', 'auto');
        }
    </script>

    <script>
        $(document).ready(function() {
            $('#pelepasan1').DataTable();
        });
        $(document).ready(function() {
            $('#pelepasan2').DataTable();
        });
        $(document).ready(function() {
            $('#pelepasan3').DataTable();
        });
        $(document).ready(function() {
            $('#pelepasan4').DataTable();
        });
        $(document).ready(function() {
            $('#pelepasan5').DataTable();
        });
        $(document).ready(function() {
            $('#pelepasan6').DataTable();
        });
        $(document).ready(function() {
            $('#pelepasan7').DataTable();
        });
        $(document).ready(function() {
            $('#pelepasan8').DataTable();
        });
        $(document).ready(function() {
            $('#pelepasan9').DataTable();
        });
        $(document).ready(function() {
            $('#pelepasan10').DataTable();
        });
        $(document).ready(function() {
            $('#pelepasan11').DataTable();
        });
        $(document).ready(function() {
            $('#pelepasan12').DataTable();
        });
        $(document).ready(function() {
            $('#pelepasan13').DataTable();
        });
        $(document).ready(function() {
            $('#pelepasan14').DataTable();
        });
        $(document).ready(function() {
            $('#pelepasan15').DataTable();
        });
        $(document).ready(function() {
            $('#pelepasan16').DataTable();
        });
        $(document).ready(function() {
            $('#pelepasan17').DataTable();
        });
        $(document).ready(function() {
            $('#pelepasan18').DataTable();
        });
        $(document).ready(function() {
            $('#pelepasan19').DataTable();
        });
        $(document).ready(function() {
            $('#pelepasan20').DataTable();
        });
        $(document).ready(function() {
            $('#pelepasan21').DataTable();
        });
        $(document).ready(function() {
            $('#pelepasan22').DataTable();
        });
    </script>
@endsection
