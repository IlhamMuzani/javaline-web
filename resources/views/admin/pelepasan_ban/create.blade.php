@extends('layouts.app')

@section('title', 'Tambah Pelepasan')

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
            <form action="{{ url('admin/pelepasan_ban/' . $kendaraan->id) }}" method="POST" enctype="multipart/form-data"
                autocomplete="off">
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
            {{-- <div class="">
                <div class=""> --}}
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th>Posisi</th>
                        <th>Kode</th>
                        <th>No. Seri</th>
                        <th>Ukuran</th>
                        <th>Merek</th>
                        <th>Keterangan</th>

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
                            <td>{{ $ban->keterangan }}</td>
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
                                            <form action="{{ url('admin/pelepasan_ban/' . $ban->id) }}" method="POST"
                                                enctype="multipart/form-data" autocomplete="off">
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
        </div>
        </div>
        {{-- modal exle 1A  --}}
        @if ($bans != null)
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
                                        <div class="form-group" hidden>
                                            <label for="kendaraan_id">Id Kendaraan</label>
                                            <input type="text" class="form-control" id="kendaraan_x1b" readonly
                                                name="kendaraan_id" placeholder="Masukan id kendaraan"
                                                value="{{ $kendaraan->id }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="km_pemasangan">Ban Id</label>
                                            <input type="text" class="form-control" id="" name="id_ban"
                                                placeholder="" value="{{ $bans->id }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Kode Ban</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="kode_ban" placeholder="" value="{{ $bans->kode_ban }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">No. Seri</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="seri_ban" placeholder="" value="{{ $bans->no_seri }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" readonly id="km_pemasangan1"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ $bans->km_pemasangan }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pelepasan</label>
                                            <input type="text" class="form-control" id="km_pemasangan1"
                                                name="km_pelepasan" placeholder="Masukan km pelepasan"
                                                value="{{ old('km_pelepasan') }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="warna">Keterangan</label>
                                            <select class="form-control" id="warna" name="keterangan">
                                                <option value="">- Pilih -</option>
                                                <option value="Habis"
                                                    {{ old('keterangan') == 'Habis' ? 'selected' : null }}>
                                                    Habis</option>
                                                <option value="Pecah"
                                                    {{ old('keterangan') == 'Pecah' ? 'selected' : null }}>
                                                    Pecah</option>
                                                <option value="Stok"
                                                    {{ old('keterangan') == 'Stok' ? 'selected' : null }}>
                                                    Stok</option>
                                            </select>
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
        @if ($bansb != null)
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
                                <form action="{{ url('admin/pelepasan1b/' . $kendaraan->id) }}" method="POST"
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
                                            <label for="km_pemasangan">Ban Id</label>
                                            <input type="text" class="form-control" id="" name="id_ban"
                                                placeholder="" value="{{ $bansb->id }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Kode Ban</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="kode_ban" placeholder="" value="{{ $bansb->kode_ban }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">No. Seri</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="seri_ban" placeholder="" value="{{ $bansb->no_seri }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" readonly id="km_pemasangan1"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ $bansb->km_pemasangan }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pelepasan</label>
                                            <input type="text" class="form-control" id="km_pemasangan1"
                                                name="km_pelepasan" placeholder="Masukan km pelepasan"
                                                value="{{ old('km_pelepasan') }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="warna">Keterangan</label>
                                            <select class="form-control" id="warna" name="keterangan">
                                                <option value="">- Pilih -</option>
                                                <option value="Habis"
                                                    {{ old('keterangan') == 'Habis' ? 'selected' : null }}>
                                                    Habis</option>
                                                <option value="Pecah"
                                                    {{ old('keterangan') == 'Pecah' ? 'selected' : null }}>
                                                    Pecah</option>
                                                <option value="Stok"
                                                    {{ old('keterangan') == 'Stok' ? 'selected' : null }}>
                                                    Stok</option>
                                            </select>
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
        @if ($bans2a != null)
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
                                <form action="{{ url('admin/pelepasan2a/' . $kendaraan->id) }}" method="POST"
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
                                            <label for="km_pemasangan">Ban Id</label>
                                            <input type="text" class="form-control" id="" name="id_ban"
                                                placeholder="" value="{{ $bans2a->id }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Kode Ban</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="kode_ban" placeholder="" value="{{ $bans2a->kode_ban }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">No Seri</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="no_seri" placeholder="" value="{{ $bans2a->no_seri }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" readonly id="km_pemasangan1"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ $bans2a->km_pemasangan }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pelepasan</label>
                                            <input type="text" class="form-control" id="km_pemasangan1"
                                                name="km_pelepasan" placeholder="Masukan km pelepasan"
                                                value="{{ old('km_pelepasan') }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="warna">Keterangan</label>
                                            <select class="form-control" id="warna" name="keterangan">
                                                <option value="">- Pilih -</option>
                                                <option value="Habis"
                                                    {{ old('keterangan') == 'Habis' ? 'selected' : null }}>
                                                    Habis</option>
                                                <option value="Pecah"
                                                    {{ old('keterangan') == 'Pecah' ? 'selected' : null }}>
                                                    Pecah</option>
                                                <option value="Stok"
                                                    {{ old('keterangan') == 'Stok' ? 'selected' : null }}>
                                                    Stok</option>
                                            </select>
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
        @if ($bans2b != null)
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
                                <form action="{{ url('admin/pelepasan2b/' . $kendaraan->id) }}" method="POST"
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
                                            <label for="km_pemasangan">Ban Id</label>
                                            <input type="text" class="form-control" id="" name="id_ban"
                                                placeholder="" value="{{ $bans2b->id }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Kode Ban</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="kode_ban" placeholder="" value="{{ $bans2b->kode_ban }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">No Seri</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="no_seri" placeholder="" value="{{ $bans2b->no_seri }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" id="km_pemasangan1"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ $bans2b->km_pemasangan }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pelepasan</label>
                                            <input type="text" class="form-control" id="km_pemasangan1"
                                                name="km_pelepasan" placeholder="Masukan km pelepasan"
                                                value="{{ old('km_pelepasan') }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="warna">Keterangan</label>
                                            <select class="form-control" id="warna" name="keterangan">
                                                <option value="">- Pilih -</option>
                                                <option value="Habis"
                                                    {{ old('keterangan') == 'Habis' ? 'selected' : null }}>
                                                    Habis</option>
                                                <option value="Pecah"
                                                    {{ old('keterangan') == 'Pecah' ? 'selected' : null }}>
                                                    Pecah</option>
                                                <option value="Stok"
                                                    {{ old('keterangan') == 'Stok' ? 'selected' : null }}>
                                                    Stok</option>

                                            </select>
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
        @if ($bans2c != null)
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
                                <form action="{{ url('admin/pelepasan2c/' . $kendaraan->id) }}" method="POST"
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
                                            <label for="km_pemasangan">Ban Id</label>
                                            <input type="text" class="form-control" id="" name="id_ban"
                                                placeholder="" value="{{ $bans2c->id }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">Kode Ban</label>
                                            <input type="text" class="form-control" readonly id=""
                                                name="kode_ban" placeholder="" value="{{ $bans2c->kode_ban }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">No Seri</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="no_seri" placeholder="" value="{{ $bans2c->no_seri }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" readonly id="km_pemasangan1"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ $bans2c->km_pemasangan }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pelepasan</label>
                                            <input type="text" class="form-control" id="km_pemasangan1"
                                                name="km_pelepasan" placeholder="Masukan km pelepasan"
                                                value="{{ old('km_pelepasan') }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="warna">Keterangan</label>
                                            <select class="form-control" id="warna" name="keterangan">
                                                <option value="">- Pilih -</option>
                                                <option value="Habis"
                                                    {{ old('keterangan') == 'Habis' ? 'selected' : null }}>
                                                    Habis</option>
                                                <option value="Pecah"
                                                    {{ old('keterangan') == 'Pecah' ? 'selected' : null }}>
                                                    Pecah</option>
                                                <option value="Stok"
                                                    {{ old('keterangan') == 'Stok' ? 'selected' : null }}>
                                                    Stok</option>
                                            </select>
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
        @if ($bans2d != null)
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
                                <form action="{{ url('admin/pelepasan2d/' . $kendaraan->id) }}" method="POST"
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
                                            <label for="km_pemasangan">Ban Id</label>
                                            <input type="text" class="form-control" id="" name="id_ban"
                                                placeholder="" value="{{ $bans2d->id }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Kode Ban</label>
                                            <input type="text" class="form-control" readonly id=""
                                                name="kode_ban" placeholder="" value="{{ $bans2d->kode_ban }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">No Seri</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="no_seri" placeholder="" value="{{ $bans2d->no_seri }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" readonly id="km_pemasangan1"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ $bans2d->km_pemasangan }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pelepasan</label>
                                            <input type="text" class="form-control" id="km_pemasangan1"
                                                name="km_pelepasan" placeholder="Masukan km pelepasan"
                                                value="{{ old('km_pelepasan') }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="warna">Keterangan</label>
                                            <select class="form-control" id="warna" name="keterangan">
                                                <option value="">- Pilih -</option>
                                                <option value="Habis"
                                                    {{ old('keterangan') == 'Habis' ? 'selected' : null }}>
                                                    Habis</option>
                                                <option value="Pecah"
                                                    {{ old('keterangan') == 'Pecah' ? 'selected' : null }}>
                                                    Pecah</option>
                                                <option value="Stok"
                                                    {{ old('keterangan') == 'Stok' ? 'selected' : null }}>
                                                    Stok</option>
                                            </select>
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
        @if ($bans3a != null)
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
                                <form action="{{ url('admin/pelepasan3a/' . $kendaraan->id) }}" method="POST"
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
                                            <label for="km_pemasangan">Ban Id</label>
                                            <input type="text" class="form-control" id="" name="id_ban"
                                                placeholder="" value="{{ $bans3a->id }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">Kode Ban</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="kode_ban" placeholder="" value="{{ $bans3a->kode_ban }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">No Seri</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="no_seri" placeholder="" value="{{ $bans3a->no_seri }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" readonly id="km_pemasangan1"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ $bans3a->km_pemasangan }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pelepasan</label>
                                            <input type="text" class="form-control" id="km_pemasangan1"
                                                name="km_pelepasan" placeholder="Masukan km pelepasan"
                                                value="{{ old('km_pelepasan') }}">
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label" for="warna">Keterangan</label>
                                            <select class="form-control" id="warna" name="keterangan">
                                                <option value="">- Pilih -</option>
                                                <option value="Habis"
                                                    {{ old('keterangan') == 'Habis' ? 'selected' : null }}>
                                                    Habis</option>
                                                <option value="Pecah"
                                                    {{ old('keterangan') == 'Pecah' ? 'selected' : null }}>
                                                    Pecah</option>
                                                <option value="Stok"
                                                    {{ old('keterangan') == 'Stok' ? 'selected' : null }}>
                                                    Stok</option>
                                            </select>
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
        @if ($bans3b != null)
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
                                <form action="{{ url('admin/pelepasan3b/' . $kendaraan->id) }}" method="POST"
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
                                            <label for="km_pemasangan">Ban Id</label>
                                            <input type="text" class="form-control" id="" name="id_ban"
                                                placeholder="" value="{{ $bans3b->id }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">Kode Ban</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="kode_ban" placeholder="" value="{{ $bans3b->kode_ban }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">No Seri</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="no_seri" placeholder="" value="{{ $bans3b->no_seri }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" readonly id="km_pemasangan1"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ $bans3b->km_pemasangan }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pelepasan</label>
                                            <input type="text" class="form-control" id="km_pemasangan1"
                                                name="km_pelepasan" placeholder="Masukan km pelepasan"
                                                value="{{ old('km_pelepasan') }}">
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label" for="warna">Keterangan</label>
                                            <select class="form-control" id="warna" name="keterangan">
                                                <option value="">- Pilih -</option>
                                                <option value="Habis"
                                                    {{ old('keterangan') == 'Habis' ? 'selected' : null }}>
                                                    Habis</option>
                                                <option value="Pecah"
                                                    {{ old('keterangan') == 'Pecah' ? 'selected' : null }}>
                                                    Pecah</option>
                                                <option value="Stok"
                                                    {{ old('keterangan') == 'Stok' ? 'selected' : null }}>
                                                    Stok</option>
                                            </select>
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
        @if ($bans3c != null)
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
                                <form action="{{ url('admin/pelepasan3c/' . $kendaraan->id) }}" method="POST"
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
                                            <label for="km_pemasangan">Ban Id</label>
                                            <input type="text" class="form-control" id="" name="id_ban"
                                                placeholder="" value="{{ $bans3c->id }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">Kode Ban</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="kode_ban" placeholder="" value="{{ $bans3c->kode_ban }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">No Seri</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="no_seri" placeholder="" value="{{ $bans3c->no_seri }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" readonly id="km_pemasangan1"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ $bans3c->km_pemasangan }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pelepasan</label>
                                            <input type="text" class="form-control" id="km_pemasangan1"
                                                name="km_pelepasan" placeholder="Masukan km pelepasan"
                                                value="{{ old('km_pelepasan') }}">
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label" for="warna">Keterangan</label>
                                            <select class="form-control" id="warna" name="keterangan">
                                                <option value="">- Pilih -</option>
                                                <option value="Habis"
                                                    {{ old('keterangan') == 'Habis' ? 'selected' : null }}>
                                                    Habis</option>
                                                <option value="Pecah"
                                                    {{ old('keterangan') == 'Pecah' ? 'selected' : null }}>
                                                    Pecah</option>
                                                <option value="Stok"
                                                    {{ old('keterangan') == 'Stok' ? 'selected' : null }}>
                                                    Stok</option>
                                            </select>
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
        @if ($bans3d != null)
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
                                <form action="{{ url('admin/pelepasan3d/' . $kendaraan->id) }}" method="POST"
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
                                            <label for="km_pemasangan">Ban Id</label>
                                            <input type="text" class="form-control" id="" name="id_ban"
                                                placeholder="" value="{{ $bans3d->id }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">Kode Ban</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="kode_ban" placeholder="" value="{{ $bans3d->kode_ban }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">No Seri</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="no_seri" placeholder="" value="{{ $bans3d->no_seri }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" readonly id="km_pemasangan1"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ $bans3d->km_pemasangan }}">
                                        </div>


                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pelepasan</label>
                                            <input type="text" class="form-control" id="km_pemasangan1"
                                                name="km_pelepasan" placeholder="Masukan km pelepasan"
                                                value="{{ old('km_pelepasan') }}">
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label" for="warna">Keterangan</label>
                                            <select class="form-control" id="warna" name="keterangan">
                                                <option value="">- Pilih -</option>
                                                <option value="Habis"
                                                    {{ old('keterangan') == 'Habis' ? 'selected' : null }}>
                                                    Habis</option>
                                                <option value="Pecah"
                                                    {{ old('keterangan') == 'Pecah' ? 'selected' : null }}>
                                                    Pecah</option>
                                                <option value="Stok"
                                                    {{ old('keterangan') == 'Stok' ? 'selected' : null }}>
                                                    Stok</option>
                                            </select>
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
        @if ($bans4a != null)
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
                                <form action="{{ url('admin/pelepasan4a/' . $kendaraan->id) }}" method="POST"
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
                                            <label for="km_pemasangan">Ban Id</label>
                                            <input type="text" class="form-control" id="" name="id_ban"
                                                placeholder="" value="{{ $bans4a->id }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">Kode Ban</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="kode_ban" placeholder="" value="{{ $bans4a->kode_ban }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">No Seri</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="no_seri" placeholder="" value="{{ $bans4a->no_seri }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" readonly id="km_pemasangan1"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ $bans4a->km_pemasangan }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pelepasan</label>
                                            <input type="text" class="form-control" id="km_pemasangan1"
                                                name="km_pelepasan" placeholder="Masukan km pelepasan"
                                                value="{{ old('km_pelepasan') }}">
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label" for="warna">Keterangan</label>
                                            <select class="form-control" id="warna" name="keterangan">
                                                <option value="">- Pilih -</option>
                                                <option value="Habis"
                                                    {{ old('keterangan') == 'Habis' ? 'selected' : null }}>
                                                    Habis</option>
                                                <option value="Pecah"
                                                    {{ old('keterangan') == 'Pecah' ? 'selected' : null }}>
                                                    Pecah</option>
                                                <option value="Stok"
                                                    {{ old('keterangan') == 'Stok' ? 'selected' : null }}>
                                                    Stok</option>
                                            </select>
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
        @if ($bans4b != null)
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
                                <form action="{{ url('admin/pelepasan4b/' . $kendaraan->id) }}" method="POST"
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
                                            <label for="km_pemasangan">Ban Id</label>
                                            <input type="text" class="form-control" id="" name="id_ban"
                                                placeholder="" value="{{ $bans4b->id }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">Kode Ban</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="kode_ban" placeholder="" value="{{ $bans4b->kode_ban }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">No Seri</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="no_seri" placeholder="" value="{{ $bans4b->no_seri }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" readonly id="km_pemasangan1"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ $bans4b->km_pemasangan }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pelepsan</label>
                                            <input type="text" class="form-control" id="km_pemasangan1"
                                                name="km_pelepasan" placeholder="Masukan km pelepasan"
                                                value="{{ old('km_pelepasan') }}">
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label" for="warna">Keterangan</label>
                                            <select class="form-control" id="warna" name="keterangan">
                                                <option value="">- Pilih -</option>
                                                <option value="Habis"
                                                    {{ old('keterangan') == 'Habis' ? 'selected' : null }}>
                                                    Habis</option>
                                                <option value="Pecah"
                                                    {{ old('keterangan') == 'Pecah' ? 'selected' : null }}>
                                                    Pecah</option>
                                                <option value="Stok"
                                                    {{ old('keterangan') == 'Stok' ? 'selected' : null }}>
                                                    Stok</option>
                                            </select>
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
        @if ($bans4c != null)
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
                                <form action="{{ url('admin/pelepasan4c/' . $kendaraan->id) }}" method="POST"
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
                                            <label for="km_pemasangan">Ban Id</label>
                                            <input type="text" class="form-control" id="" name="id_ban"
                                                placeholder="" value="{{ $bans4c->id }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">Kode Ban</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="kode_ban" placeholder="" value="{{ $bans4c->kode_ban }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">No Seri</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="no_seri" placeholder="" value="{{ $bans4c->no_seri }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" readonly id="km_pemasangan1"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ $bans4c->km_pemasangan }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pelepasan</label>
                                            <input type="text" class="form-control" id="km_pemasangan1"
                                                name="km_pelepasan" placeholder="Masukan km pelepasan"
                                                value="{{ old('km_pelepasan') }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="warna">Keterangan</label>
                                            <select class="form-control" id="warna" name="keterangan">
                                                <option value="">- Pilih -</option>
                                                <option value="Habis"
                                                    {{ old('keterangan') == 'Habis' ? 'selected' : null }}>
                                                    Habis</option>
                                                <option value="Pecah"
                                                    {{ old('keterangan') == 'Pecah' ? 'selected' : null }}>
                                                    Pecah</option>
                                                <option value="Stok"
                                                    {{ old('keterangan') == 'Stok' ? 'selected' : null }}>
                                                    Stok</option>
                                            </select>
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
        @if ($bans4d != null)
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
                                <form action="{{ url('admin/pelepasan4d/' . $kendaraan->id) }}" method="POST"
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
                                            <label for="km_pemasangan">Ban Id</label>
                                            <input type="text" class="form-control" id="" name="id_ban"
                                                placeholder="" value="{{ $bans4d->id }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">Kode Ban</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="kode_ban" placeholder="" value="{{ $bans4d->kode_ban }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">No Seri</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="no_seri" placeholder="" value="{{ $bans4d->no_seri }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" readonly id="km_pemasangan1"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ $bans4d->km_pemasangan }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pelepasan</label>
                                            <input type="text" class="form-control" id="km_pemasangan1"
                                                name="km_pelepasan" placeholder="Masukan km pelepasan"
                                                value="{{ old('km_pelepasan') }}">
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label" for="warna">Keterangan</label>
                                            <select class="form-control" id="warna" name="keterangan">
                                                <option value="">- Pilih -</option>
                                                <option value="Habis"
                                                    {{ old('keterangan') == 'Habis' ? 'selected' : null }}>
                                                    Habis</option>
                                                <option value="Pecah"
                                                    {{ old('keterangan') == 'Pecah' ? 'selected' : null }}>
                                                    Pecah</option>
                                                <option value="Stok"
                                                    {{ old('keterangan') == 'Stok' ? 'selected' : null }}>
                                                    Stok</option>
                                            </select>
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
        @if ($bans5a != null)
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
                                <form action="{{ url('admin/pelepasan5a/' . $kendaraan->id) }}" method="POST"
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
                                            <label for="km_pemasangan">Ban Id</label>
                                            <input type="text" class="form-control" id="" name="id_ban"
                                                placeholder="" value="{{ $bans5a->id }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Kode Ban</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="kode_ban" placeholder="" value="{{ $bans5a->kode_ban }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">No Seri</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="no_seri" placeholder="" value="{{ $bans5a->no_seri }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" readonly id="km_pemasangan1"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ $bans5a->km_pemasangan }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pelepasan</label>
                                            <input type="text" class="form-control" id="km_pemasangan1"
                                                name="km_pelepasan" placeholder="Masukan km pelepasan"
                                                value="{{ old('km_pelepasan') }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="warna">Keterangan</label>
                                            <select class="form-control" id="warna" name="keterangan">
                                                <option value="">- Pilih -</option>
                                                <option value="Habis"
                                                    {{ old('keterangan') == 'Habis' ? 'selected' : null }}>
                                                    Habis</option>
                                                <option value="Pecah"
                                                    {{ old('keterangan') == 'Pecah' ? 'selected' : null }}>
                                                    Pecah</option>
                                                <option value="Stok"
                                                    {{ old('keterangan') == 'Stok' ? 'selected' : null }}>
                                                    Stok</option>
                                            </select>
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
        @if ($bans5b != null)
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
                                <form action="{{ url('admin/pelepasan5b/' . $kendaraan->id) }}" method="POST"
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
                                            <label for="km_pemasangan">Ban Id</label>
                                            <input type="text" class="form-control" id="" name="id_ban"
                                                placeholder="" value="{{ $bans5b->id }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Kode Ban</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="kode_ban" placeholder="" value="{{ $bans5b->kode_ban }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">No Seri</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="no_seri" placeholder="" value="{{ $bans5b->no_seri }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" readonly id="km_pemasangan1"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ $bans5b->km_pemasangan }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pelepasan</label>
                                            <input type="text" class="form-control" id="km_pemasangan1"
                                                name="km_pelepasan" placeholder="Masukan km pelepasan"
                                                value="{{ old('km_pelepasan') }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="warna">Keterangan</label>
                                            <select class="form-control" id="warna" name="keterangan">
                                                <option value="">- Pilih -</option>
                                                <option value="Habis"
                                                    {{ old('keterangan') == 'Habis' ? 'selected' : null }}>
                                                    Habis</option>
                                                <option value="Pecah"
                                                    {{ old('keterangan') == 'Pecah' ? 'selected' : null }}>
                                                    Pecah</option>
                                                <option value="Stok"
                                                    {{ old('keterangan') == 'Stok' ? 'selected' : null }}>
                                                    Stok</option>
                                            </select>
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
        @if ($bans5c != null)
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
                                <form action="{{ url('admin/pelepasan5c/' . $kendaraan->id) }}" method="POST"
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
                                            <label for="km_pemasangan">Ban Id</label>
                                            <input type="text" class="form-control" id="" name="id_ban"
                                                placeholder="" value="{{ $bans5c->id }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Kode Ban</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="kode_ban" placeholder="" value="{{ $bans5c->kode_ban }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">No Seri</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="no_seri" placeholder="" value="{{ $bans5c->no_seri }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" readonly id="km_pemasangan1"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ $bans5c->km_pemasangan }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pelepasan</label>
                                            <input type="text" class="form-control" id="km_pemasangan1"
                                                name="km_pelepasan" placeholder="Masukan km pelepasan"
                                                value="{{ old('km_pelepasan') }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="warna">Keterangan</label>
                                            <select class="form-control" id="warna" name="keterangan">
                                                <option value="">- Pilih -</option>
                                                <option value="Habis"
                                                    {{ old('keterangan') == 'Habis' ? 'selected' : null }}>
                                                    Habis</option>
                                                <option value="Pecah"
                                                    {{ old('keterangan') == 'Pecah' ? 'selected' : null }}>
                                                    Pecah</option>
                                                <option value="Stok"
                                                    {{ old('keterangan') == 'Stok' ? 'selected' : null }}>
                                                    Stok</option>
                                            </select>
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
        @if ($bans5d != null)
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
                                <form action="{{ url('admin/pelepasan5d/' . $kendaraan->id) }}" method="POST"
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
                                            <label for="km_pemasangan">Ban Id</label>
                                            <input type="text" class="form-control" id="" name="id_ban"
                                                placeholder="" value="{{ $bans5d->id }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Kode Ban</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="kode_ban" placeholder="" value="{{ $bans5d->kode_ban }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">No Seri</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="no_seri" placeholder="" value="{{ $bans5d->no_seri }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" readonly id="km_pemasangan1"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ $bans5d->km_pemasangan }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pelepasan</label>
                                            <input type="text" class="form-control" id="km_pemasangan1"
                                                name="km_pelepasan" placeholder="Masukan km pelepasan"
                                                value="{{ old('km_pelepasan') }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="warna">Keterangan</label>
                                            <select class="form-control" id="warna" name="keterangan">
                                                <option value="">- Pilih -</option>
                                                <option value="Habis"
                                                    {{ old('keterangan') == 'Habis' ? 'selected' : null }}>
                                                    Habis</option>
                                                <option value="Pecah"
                                                    {{ old('keterangan') == 'Pecah' ? 'selected' : null }}>
                                                    Pecah</option>
                                                <option value="Stok"
                                                    {{ old('keterangan') == 'Stok' ? 'selected' : null }}>
                                                    Stok</option>
                                            </select>
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
        @if ($bans6a != null)
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
                                <form action="{{ url('admin/pelepasan6a/' . $kendaraan->id) }}" method="POST"
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
                                            <label for="km_pemasangan">Ban Id</label>
                                            <input type="text" class="form-control" id="" name="id_ban"
                                                placeholder="" value="{{ $bans6a->id }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Kode Ban</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="kode_ban" placeholder="" value="{{ $bans6a->kode_ban }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">No Seri</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="no_seri" placeholder="" value="{{ $bans6a->no_seri }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" readonly id="km_pemasangan1"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ $bans6a->km_pemasangan }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pelepasan</label>
                                            <input type="text" class="form-control" id="km_pemasangan1"
                                                name="km_pelepasan" placeholder="Masukan km pelepasan"
                                                value="{{ old('km_pelepasan') }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="warna">Keterangan</label>
                                            <select class="form-control" id="warna" name="keterangan">
                                                <option value="">- Pilih -</option>
                                                <option value="Habis"
                                                    {{ old('keterangan') == 'Habis' ? 'selected' : null }}>
                                                    Habis</option>
                                                <option value="Pecah"
                                                    {{ old('keterangan') == 'Pecah' ? 'selected' : null }}>
                                                    Pecah</option>
                                                <option value="Stok"
                                                    {{ old('keterangan') == 'Stok' ? 'selected' : null }}>
                                                    Stok</option>
                                            </select>
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
        @if ($bans6b != null)
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
                                <form action="{{ url('admin/pelepasan6b/' . $kendaraan->id) }}" method="POST"
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
                                            <label for="km_pemasangan">Ban Id</label>
                                            <input type="text" class="form-control" id="" name="id_ban"
                                                placeholder="" value="{{ $bans6b->id }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Kode Ban</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="kode_ban" placeholder="" value="{{ $bans6b->kode_ban }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">No Seri</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="no_seri" placeholder="" value="{{ $bans6b->no_seri }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" readonly id="km_pemasangan1"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ $bans6b->km_pemasangan }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pelepasan</label>
                                            <input type="text" class="form-control" id="km_pemasangan1"
                                                name="km_pelepasan" placeholder="Masukan km pelepasan"
                                                value="{{ old('km_pelepasan') }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="warna">Keterangan</label>
                                            <select class="form-control" id="warna" name="keterangan">
                                                <option value="">- Pilih -</option>
                                                <option value="Habis"
                                                    {{ old('keterangan') == 'Habis' ? 'selected' : null }}>
                                                    Habis</option>
                                                <option value="Pecah"
                                                    {{ old('keterangan') == 'Pecah' ? 'selected' : null }}>
                                                    Pecah</option>
                                                <option value="Stok"
                                                    {{ old('keterangan') == 'Stok' ? 'selected' : null }}>
                                                    Stok</option>
                                            </select>
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
        @if ($bans6c != null)
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
                                <form action="{{ url('admin/pelepasan6c/' . $kendaraan->id) }}" method="POST"
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
                                            <label for="km_pemasangan">Ban Id</label>
                                            <input type="text" class="form-control" id="" name="id_ban"
                                                placeholder="" value="{{ $bans6c->id }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Kode Ban</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="kode_ban" placeholder="" value="{{ $bans6c->kode_ban }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">No Seri</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="no_seri" placeholder="" value="{{ $bans6c->no_seri }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" readonly id="km_pemasangan1"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ $bans6c->km_pemasangan }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pelepasan</label>
                                            <input type="text" class="form-control" id="km_pemasangan1"
                                                name="km_pelepasan" placeholder="Masukan km pelepasan"
                                                value="{{ old('km_pelepasan') }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="warna">Keterangan</label>
                                            <select class="form-control" id="warna" name="keterangan">
                                                <option value="">- Pilih -</option>
                                                <option value="Habis"
                                                    {{ old('keterangan') == 'Habis' ? 'selected' : null }}>
                                                    Habis</option>
                                                <option value="Pecah"
                                                    {{ old('keterangan') == 'Pecah' ? 'selected' : null }}>
                                                    Pecah</option>
                                                <option value="Stok"
                                                    {{ old('keterangan') == 'Stok' ? 'selected' : null }}>
                                                    Stok</option>
                                            </select>
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
        @if ($bans6d != null)
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
                                <form action="{{ url('admin/pelepasan6d/' . $kendaraan->id) }}" method="POST"
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
                                            <label for="km_pemasangan">Ban Id</label>
                                            <input type="text" class="form-control" id="" name="id_ban"
                                                placeholder="" value="{{ $bans6d->id }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Kode Ban</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="kode_ban" placeholder="" value="{{ $bans6d->kode_ban }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="km_pemasangan">No Seri</label>
                                            <input type="text" class="form-control" id="" readonly
                                                name="no_seri" placeholder="" value="{{ $bans6d->no_seri }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pemasangan</label>
                                            <input type="text" class="form-control" readonly id="km_pemasangan1"
                                                name="km_pemasangan" placeholder="Masukan km pemasangan"
                                                value="{{ $bans6d->km_pemasangan }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="km_pemasangan">Km Pelepasan</label>
                                            <input type="text" class="form-control" id="km_pemasangan1"
                                                name="km_pelepasan" placeholder="Masukan km pelepasan"
                                                value="{{ old('km_pelepasan') }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="warna">Keterangan</label>
                                            <select class="form-control" id="warna" name="keterangan">
                                                <option value="">- Pilih -</option>
                                                <option value="Habis"
                                                    {{ old('keterangan') == 'Habis' ? 'selected' : null }}>
                                                    Habis</option>
                                                <option value="Pecah"
                                                    {{ old('keterangan') == 'Pecah' ? 'selected' : null }}>
                                                    Pecah</option>
                                                <option value="Stok"
                                                    {{ old('keterangan') == 'Stok' ? 'selected' : null }}>
                                                    Stok</option>
                                            </select>
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
