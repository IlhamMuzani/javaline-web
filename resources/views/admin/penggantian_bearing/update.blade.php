@extends('layouts.app')

@section('title', 'Penggantian Bearing')

@section('content')
    <div id="loadingSpinner" style="display: flex; align-items: center; justify-content: center; height: 100vh;">
        <i class="fas fa-spinner fa-spin" style="font-size: 3rem;"></i>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(function() {
                document.getElementById("loadingSpinner").style.display = "none";
                document.getElementById("mainContent").style.display = "block";
                document.getElementById("mainContentSection").style.display = "block";
            }, 100); // Adjust the delay time as needed
        });
    </script>
    <div class="content-header" style="display: none;" id="mainContent">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Penggantian Bearing</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/penggantian_bearing') }}">Penggantian Bearing</a>
                        </li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content" style="display: none;" id="mainContentSection">
        <div class="container-fluid">
            @if (session('error_pelanggans') || session('error_pesanans'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-ban"></i> Error!
                    </h5>
                    @if (session('error_pelanggans'))
                        @foreach (session('error_pelanggans') as $error)
                            - {{ $error }} <br>
                        @endforeach
                    @endif
                    @if (session('error_pesanans'))
                        @foreach (session('error_pesanans') as $error)
                            - {{ $error }} <br>
                        @endforeach
                    @endif
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

            @if (session('erorrss'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-ban"></i> Gagal Menyimpan!
                    </h5>
                    {{ session('erorrss') }}
                </div>
            @endif
            <form action="{{ url('admin/penggantian_bearing/') }}" method="POST" enctype="multipart/form-data"
                autocomplete="off">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Penggantian Bearing</h3>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card-body">
                                <div hidden class="form-group">
                                    <label for="nopol">Kendaraan Id</label>
                                    <input type="text" class="form-control" id="kendaraan_id" name="kendaraan_id"
                                        readonly placeholder="Masukan no registrasi kendaraan" value="{{ $kendaraan->id }}">
                                </div>
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
                                <div hidden class="form-group">
                                    <label for="nama">Jumlah Ban</label>
                                    <input type="text" class="form-control" id="jumlah_ban" name="jumlah_ban" readonly
                                        placeholder="Masukan jumlah ban"
                                        value="{{ $kendaraan->jenis_kendaraan->total_ban }}">
                                </div>
                                <div class="form-group" id="layoutjenis">
                                    <label for="jenis_kendaraan">Jenis Kendaraan</label>
                                    <input type="text" class="form-control" id="jenis_kendaraan" name="jenis_kendaraan"
                                        readonly placeholder="Masukan jenis kendaraan"
                                        value="{{ $kendaraan->jenis_kendaraan->nama_jenis_kendaraan ?? null }}">
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Km Penggantian</label>
                                    <input type="number" class="form-control" id="km" name="km"
                                        value="{{ old('km') }}">
                                </div>
                            </div>
                        </div>
                        <div class="ml-3">
                            <div class="card-body">
                                <div class="col">
                                    {{-- baris axle 1  --}}
                                    <div class="row mb-5">
                                        <div class="row">
                                            <div class="form-group mt-2" style="text-align: center;">
                                                @if ($kendaraan->bearing->isNotEmpty() && $kendaraan->bearing->first()->status_bearing1a == 'belum penggantian')
                                                    <img src="{{ asset('storage/uploads/indikator/merah.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @else
                                                    <img src="{{ asset('storage/uploads/indikator/hijau.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @endif
                                                <div>
                                                    <img class="mt-1"
                                                        src="{{ asset('storage/uploads/karyawan/1A.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>

                                            <div class="form-group mt-5" style="text-align: center;">
                                                <label>Axle 1</label>
                                                <div class="">
                                                    <img class="mt-1"
                                                        src="{{ asset('storage/uploads/karyawan/axle.png') }}"
                                                        alt="AdminLTELogo" height="20" width="200">
                                                </div>
                                            </div>
                                            <div class="form-group mt-2" style="text-align: center;">
                                                @if ($kendaraan->bearing->isNotEmpty() && $kendaraan->bearing->first()->status_bearing1b == 'belum penggantian')
                                                    <img src="{{ asset('storage/uploads/indikator/merah.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @else
                                                    <img src="{{ asset('storage/uploads/indikator/hijau.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @endif
                                                <div>
                                                    <img class="mt-1"
                                                        src="{{ asset('storage/uploads/karyawan/1B.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="row">
                                            <div class="form-group mt-2" style="text-align: center;">
                                                @if ($kendaraan->bearing->isNotEmpty() && $kendaraan->bearing->first()->status_bearing2a == 'belum penggantian')
                                                    <img src="{{ asset('storage/uploads/indikator/merah.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @else
                                                    <img src="{{ asset('storage/uploads/indikator/hijau.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @endif
                                                <div>
                                                    <img class="mt-2"
                                                        src="{{ asset('storage/uploads/karyawan/2A.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>

                                            <div class="form-group mt-5" style="text-align: center;">
                                                <label>Axle 2</label>
                                                <div class="">
                                                    <img class="mt-1"
                                                        src="{{ asset('storage/uploads/karyawan/axle.png') }}"
                                                        alt="AdminLTELogo" height="20" width="200">
                                                </div>
                                            </div>
                                            <div class="form-group mt-2" style="text-align: center;">
                                                @if ($kendaraan->bearing->isNotEmpty() && $kendaraan->bearing->first()->status_bearing2b == 'belum penggantian')
                                                    <img src="{{ asset('storage/uploads/indikator/merah.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @else
                                                    <img src="{{ asset('storage/uploads/indikator/hijau.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @endif
                                                <div>
                                                    <img class="mt-2"
                                                        src="{{ asset('storage/uploads/karyawan/2B.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="row">
                                            <div class="form-group mt-2" style="text-align: center;">
                                                @if ($kendaraan->bearing->isNotEmpty() && $kendaraan->bearing->first()->status_bearing3a == 'belum penggantian')
                                                    <img src="{{ asset('storage/uploads/indikator/merah.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @else
                                                    <img src="{{ asset('storage/uploads/indikator/hijau.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @endif
                                                <div>
                                                    <img class="mt-2"
                                                        src="{{ asset('storage/uploads/karyawan/3A.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>

                                            <div class="form-group mt-5" style="text-align: center;">
                                                <label>Axle 3</label>
                                                <div class="">
                                                    <img class="mt-1"
                                                        src="{{ asset('storage/uploads/karyawan/axle.png') }}"
                                                        alt="AdminLTELogo" height="20" width="200">
                                                </div>
                                            </div>
                                            <div class="form-group mt-2" style="text-align: center;">
                                                @if ($kendaraan->bearing->isNotEmpty() && $kendaraan->bearing->first()->status_bearing3b == 'belum penggantian')
                                                    <img src="{{ asset('storage/uploads/indikator/merah.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @else
                                                    <img src="{{ asset('storage/uploads/indikator/hijau.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @endif
                                                <div>
                                                    <img class="mt-2"
                                                        src="{{ asset('storage/uploads/karyawan/3B.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="layout_tronton" class="row mb-5">
                                        <div class="row">
                                            <div class="form-group mt-2" style="text-align: center;">
                                                @if ($kendaraan->bearing->isNotEmpty() && $kendaraan->bearing->first()->status_bearing4a == 'belum penggantian')
                                                    <img src="{{ asset('storage/uploads/indikator/merah.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @else
                                                    <img src="{{ asset('storage/uploads/indikator/hijau.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @endif
                                                <div>
                                                    <img class="mt-2"
                                                        src="{{ asset('storage/uploads/karyawan/4A.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>

                                            <div class="form-group mt-5" style="text-align: center;">
                                                <label>Axle 4</label>
                                                <div class="">
                                                    <img class="mt-1"
                                                        src="{{ asset('storage/uploads/karyawan/axle.png') }}"
                                                        alt="AdminLTELogo" height="20" width="200">
                                                </div>
                                            </div>
                                            <div class="form-group mt-2" style="text-align: center;">
                                                @if ($kendaraan->bearing->isNotEmpty() && $kendaraan->bearing->first()->status_bearing4b == 'belum penggantian')
                                                    <img src="{{ asset('storage/uploads/indikator/merah.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @else
                                                    <img src="{{ asset('storage/uploads/indikator/hijau.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @endif
                                                <div>
                                                    <img class="mt-2"
                                                        src="{{ asset('storage/uploads/karyawan/4B.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="layout_trailer_engkel" class="row mb-5">
                                        <div class="row">
                                            <div class="form-group mt-2" style="text-align: center;">
                                                @if ($kendaraan->bearing->isNotEmpty() && $kendaraan->bearing->first()->status_bearing5a == 'belum penggantian')
                                                    <img src="{{ asset('storage/uploads/indikator/merah.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @else
                                                    <img src="{{ asset('storage/uploads/indikator/hijau.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @endif
                                                <div>
                                                    <img class="mt-2"
                                                        src="{{ asset('storage/uploads/karyawan/5A.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>

                                            <div class="form-group mt-5" style="text-align: center;">
                                                <label>Axle 5</label>
                                                <div class="">
                                                    <img class="mt-1"
                                                        src="{{ asset('storage/uploads/karyawan/axle.png') }}"
                                                        alt="AdminLTELogo" height="20" width="200">
                                                </div>
                                            </div>
                                            <div class="form-group mt-2" style="text-align: center;">
                                                @if ($kendaraan->bearing->isNotEmpty() && $kendaraan->bearing->first()->status_bearing5b == 'belum penggantian')
                                                    <img src="{{ asset('storage/uploads/indikator/merah.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @else
                                                    <img src="{{ asset('storage/uploads/indikator/hijau.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @endif
                                                <div>
                                                    <img class="mt-2"
                                                        src="{{ asset('storage/uploads/karyawan/5B.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="layout_trailer_tronton" class="row mb-5">
                                        <div class="row">
                                            <div class="form-group mt-2" style="text-align: center;">
                                                @if ($kendaraan->bearing->isNotEmpty() && $kendaraan->bearing->first()->status_bearing6a == 'belum penggantian')
                                                    <img src="{{ asset('storage/uploads/indikator/merah.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @else
                                                    <img src="{{ asset('storage/uploads/indikator/hijau.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @endif
                                                <div>
                                                    <img class="mt-2"
                                                        src="{{ asset('storage/uploads/karyawan/6A.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>

                                            <div class="form-group mt-5" style="text-align: center;">
                                                <label>Axle 6</label>
                                                <div class="">
                                                    <img class="mt-1"
                                                        src="{{ asset('storage/uploads/karyawan/axle.png') }}"
                                                        alt="AdminLTELogo" height="20" width="200">
                                                </div>
                                            </div>
                                            <div class="form-group mt-2" style="text-align: center;">
                                                @if ($kendaraan->bearing->isNotEmpty() && $kendaraan->bearing->first()->status_bearing6b == 'belum penggantian')
                                                    <img src="{{ asset('storage/uploads/indikator/merah.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @else
                                                    <img src="{{ asset('storage/uploads/indikator/hijau.png') }}"
                                                        alt="AdminLTELogo" height="20" width="20">
                                                @endif
                                                <div>
                                                    <img class="mt-2"
                                                        src="{{ asset('storage/uploads/karyawan/6B.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Penggantian Bearing <span>
                                    </span></h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="font-size:14px" class="text-center">No</th>
                                            <th style="font-size:14px">Posisi</th>
                                            <th style="font-size:14px">Kode Part</th>
                                            <th style="font-size:14px">Nama Part</th>
                                            <th style="font-size:14px">Opsi</th>
                                            <th style="font-size:14px">Kode Grease</th>
                                            <th style="font-size:14px">Nama Grease</th>
                                            <th style="font-size:14px">Jumlah Grease</th>
                                            <th style="font-size:14px">Opsi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabel-pembelian">
                                        {{-- axle 1a  --}}
                                        <tr id="pembelian-0">
                                            <td style="width: 70px; font-size:14px" class="text-center" id="urutan">1
                                            </td>
                                            <td hidden>
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="text" class="form-control"
                                                        id="sparepart_id-0" name="sparepart_id[0]"
                                                        value="{{ old('sparepart_id.0') }}">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" readonly
                                                            class="form-control" id="kategori-0" name="kategori[0]"
                                                            value="Axle 1A">
                                                    </div>
                                                </div>
                                            </td>
                                            <td onclick="addPart(0)">
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="text" readonly
                                                        class="form-control" id="kode_barang-0" name="kode_barang[0]"
                                                        value="{{ old('kode_barang.0') }}">
                                                </div>
                                            </td>
                                            <td onclick="addPart(0)">
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="text" readonly
                                                        class="form-control" id="nama_barang-0" name="nama_barang[0]"
                                                        value="{{ old('nama_barang.0') }}">
                                                </div>
                                            </td>
                                            <td hidden>
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="text" readonly
                                                        class="form-control" id="jumlah-0" name="jumlah[0]"
                                                        value="{{ old('jumlah.0') }}">
                                                </div>
                                            </td>
                                            <td style="width: 50px">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="addPart(0)">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </td>
                                            <td hidden>
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="text" readonly
                                                        class="form-control" id="spareparts_id-0" name="spareparts_id[0]"
                                                        value="{{ old('spareparts_id.0') }}">
                                                </div>
                                            </td>
                                            <td onclick="addParts(0)">
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="text" readonly
                                                        class="form-control" id="kode_grease-0" name="kode_grease[0]"
                                                        value="{{ old('kode_grease.0') }}">
                                                </div>
                                            </td>
                                            <td onclick="addParts(0)">
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="text" readonly
                                                        class="form-control" id="nama_grease-0" name="nama_grease[0]"
                                                        value="{{ old('nama_grease.0') }}">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="text" class="form-control"
                                                        id="jumlah_grease-0" name="jumlah_grease[0]"
                                                        value="{{ old('jumlah_grease.0') }}">
                                                </div>
                                            </td>
                                            <td style="width: 50px">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="addParts(0)">
                                                    <i class="fas fa-plus"></i>
                                                </button>

                                            </td>
                                        </tr>

                                        {{-- axle 1b  --}}
                                        <tr id="pembelian-1">
                                            <td style="width: 70px; font-size:14px" class="text-center" id="urutan">2
                                            </td>
                                            <td hidden>
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="text" class="form-control"
                                                        id="sparepart_id-1" name="sparepart_id[1]"
                                                        value="{{ old('sparepart_id.1') }}">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" readonly
                                                            class="form-control" id="kategori-1" name="kategori[1]"
                                                            value="Axle 1B">
                                                    </div>
                                                </div>
                                            </td>
                                            <td onclick="addPart(1)">
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="text" readonly
                                                        class="form-control" id="kode_barang-1" name="kode_barang[1]"
                                                        value="{{ old('kode_barang.1') }}">
                                                </div>
                                            </td>
                                            <td onclick="addPart(1)">
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="text" readonly
                                                        class="form-control" id="nama_barang-1" name="nama_barang[1]"
                                                        value="{{ old('nama_barang.1') }}">
                                                </div>
                                            </td>
                                            <td hidden>
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="text" readonly
                                                        class="form-control" id="jumlah-1" name="jumlah[1]"
                                                        value="{{ old('jumlah.2') }}">
                                                </div>
                                            </td>
                                            <td style="width: 50px">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="addPart(1)">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </td>
                                            <td hidden>
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="text" readonly
                                                        class="form-control" id="spareparts_id-1" name="spareparts_id[1]"
                                                        value="{{ old('spareparts_id.1') }}">
                                                </div>
                                            </td>
                                            <td onclick="addParts(1)">
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="text" readonly
                                                        class="form-control" id="kode_grease-1" name="kode_grease[1]"
                                                        value="{{ old('kode_grease.1') }}">
                                                </div>
                                            </td>
                                            <td onclick="addParts(1)">
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="text" readonly
                                                        class="form-control" id="nama_grease-1" name="nama_grease[1]"
                                                        value="{{ old('nama_grease.1') }}">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="text" class="form-control"
                                                        id="jumlah_grease-1" name="jumlah_grease[1]"
                                                        value="{{ old('jumlah_grease.1') }}">
                                                </div>
                                            </td>
                                            <td style="width: 50px">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="addParts(1)">
                                                    <i class="fas fa-plus"></i>
                                                </button>

                                            </td>
                                        </tr>

                                        {{-- axle 2a  --}}
                                        <tr id="pembelian-2">
                                            <td style="width: 70px; font-size:14px" class="text-center" id="urutan">3
                                            </td>
                                            <td hidden>
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="text" class="form-control"
                                                        id="sparepart_id-2" name="sparepart_id[2]"
                                                        value="{{ old('sparepart_id.2') }}">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" readonly
                                                            class="form-control" id="kategori-2" name="kategori[2]"
                                                            value="Axle 2A">
                                                    </div>
                                                </div>
                                            </td>
                                            <td onclick="addPart(2)">
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="text" readonly
                                                        class="form-control" id="kode_barang-2" name="kode_barang[2]"
                                                        value="{{ old('kode_barang.2') }}">
                                                </div>
                                            </td>
                                            <td onclick="addPart(2)">
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="text" readonly
                                                        class="form-control" id="nama_barang-2" name="nama_barang[2]"
                                                        value="{{ old('nama_barang.2') }}">
                                                </div>
                                            </td>
                                            <td hidden>
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="text" readonly
                                                        class="form-control" id="jumlah-2" name="jumlah[2]"
                                                        value="{{ old('jumlah.2') }}">
                                                </div>
                                            </td>
                                            <td style="width: 50px">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="addPart(2)">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </td>
                                            <td hidden>
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="text" readonly
                                                        class="form-control" id="spareparts_id-2" name="spareparts_id[2]"
                                                        value="{{ old('spareparts_id.2') }}">
                                                </div>
                                            </td>
                                            <td onclick="addParts(2)">
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="text" readonly
                                                        class="form-control" id="kode_grease-2" name="kode_grease[2]"
                                                        value="{{ old('kode_grease.2') }}">
                                                </div>
                                            </td>
                                            <td onclick="addParts(2)">
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="text" readonly
                                                        class="form-control" id="nama_grease-2" name="nama_grease[2]"
                                                        value="{{ old('nama_grease.2') }}">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="text" class="form-control"
                                                        id="jumlah_grease-2" name="jumlah_grease[2]"
                                                        value="{{ old('jumlah_grease.2') }}">
                                                </div>
                                            </td>
                                            <td style="width: 50px">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="addParts(2)">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </td>
                                        </tr>

                                        {{-- axle 2b --}}
                                        <tr id="pembelian-3">
                                            <td style="width: 70px; font-size:14px" class="text-center" id="urutan">4
                                            </td>
                                            <td hidden>
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="text" class="form-control"
                                                        id="sparepart_id-3" name="sparepart_id[3]"
                                                        value="{{ old('sparepart_id.3') }}">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" readonly
                                                            class="form-control" id="kategori-3" name="kategori[3]"
                                                            value="Axle 2B">
                                                    </div>
                                                </div>
                                            </td>
                                            <td onclick="addPart(3)">
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="text" readonly
                                                        class="form-control" id="kode_barang-3" name="kode_barang[3]"
                                                        value="{{ old('kode_barang.3') }}">
                                                </div>
                                            </td>
                                            <td onclick="addPart(3)">
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="text" readonly
                                                        class="form-control" id="nama_barang-3" name="nama_barang[3]"
                                                        value="{{ old('nama_barang.3') }}">
                                                </div>
                                            </td>
                                            <td hidden>
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="text" readonly
                                                        class="form-control" id="jumlah-3" name="jumlah[3]"
                                                        value="{{ old('jumlah.2') }}">
                                                </div>
                                            </td>
                                            <td style="width: 50px">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="addPart(3)">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </td>
                                            <td hidden>
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="text" readonly
                                                        class="form-control" id="spareparts_id-3" name="spareparts_id[3]"
                                                        value="{{ old('spareparts_id.3') }}">
                                                </div>
                                            </td>
                                            <td onclick="addParts(3)">
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="text" readonly
                                                        class="form-control" id="kode_grease-3" name="kode_grease[3]"
                                                        value="{{ old('kode_grease.3') }}">
                                                </div>
                                            </td>
                                            <td onclick="addParts(3)">
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="text" readonly
                                                        class="form-control" id="nama_grease-3" name="nama_grease[3]"
                                                        value="{{ old('nama_grease.3') }}">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="text" class="form-control"
                                                        id="jumlah_grease-3" name="jumlah_grease[3]"
                                                        value="{{ old('jumlah_grease.3') }}">
                                                </div>
                                            </td>
                                            <td style="width: 50px">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="addParts(3)">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </td>
                                        </tr>

                                        {{-- axle 3a  --}}
                                        <tr id="pembelian-4">
                                            <td style="width: 70px; font-size:14px" class="text-center" id="urutan">5
                                            </td>
                                            <td hidden>
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="text" class="form-control"
                                                        id="sparepart_id-4" name="sparepart_id[4]"
                                                        value="{{ old('sparepart_id.4') }}">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" readonly
                                                            class="form-control" id="kategori-4" name="kategori[4]"
                                                            value="Axle 3A">
                                                    </div>
                                                </div>
                                            </td>
                                            <td onclick="addPart(4)">
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="text" readonly
                                                        class="form-control" id="kode_barang-4" name="kode_barang[4]"
                                                        value="{{ old('kode_barang.4') }}">
                                                </div>
                                            </td>
                                            <td onclick="addPart(4)">
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="text" readonly
                                                        class="form-control" id="nama_barang-4" name="nama_barang[4]"
                                                        value="{{ old('nama_barang.4') }}">
                                                </div>
                                            </td>
                                            <td hidden>
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="text" readonly
                                                        class="form-control" id="jumlah-4" name="jumlah[4]"
                                                        value="{{ old('jumlah.2') }}">
                                                </div>
                                            </td>
                                            <td style="width: 50px">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="addPart(4)">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </td>
                                            <td hidden>
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="text" readonly
                                                        class="form-control" id="spareparts_id-4" name="spareparts_id[4]"
                                                        value="{{ old('spareparts_id.4') }}">
                                                </div>
                                            </td>
                                            <td onclick="addParts(4)">
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="text" readonly
                                                        class="form-control" id="kode_grease-4" name="kode_grease[4]"
                                                        value="{{ old('kode_grease.4') }}">
                                                </div>
                                            </td>
                                            <td onclick="addParts(4)">
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="text" readonly
                                                        class="form-control" id="nama_grease-4" name="nama_grease[4]"
                                                        value="{{ old('nama_grease.4') }}">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="text" class="form-control"
                                                        id="jumlah_grease-4" name="jumlah_grease[4]"
                                                        value="{{ old('jumlah_grease.4') }}">
                                                </div>
                                            </td>
                                            <td style="width: 50px">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="addParts(4)">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </td>
                                        </tr>

                                        {{-- axle 3b --}}
                                        <tr id="pembelian-5">
                                            <td style="width: 70px; font-size:14px" class="text-center" id="urutan">6
                                            </td>
                                            <td hidden>
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="text" class="form-control"
                                                        id="sparepart_id-5" name="sparepart_id[5]"
                                                        value="{{ old('sparepart_id.5') }}">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" readonly
                                                            class="form-control" id="kategori-5" name="kategori[5]"
                                                            value="Axle 3B">
                                                    </div>
                                                </div>
                                            </td>
                                            <td onclick="addPart(5)">
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="text" readonly
                                                        class="form-control" id="kode_barang-5" name="kode_barang[5]"
                                                        value="{{ old('kode_barang.5') }}">
                                                </div>
                                            </td>
                                            <td onclick="addPart(5)">
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="text" readonly
                                                        class="form-control" id="nama_barang-5" name="nama_barang[5]"
                                                        value="{{ old('nama_barang.5') }}">
                                                </div>
                                            </td>
                                            <td hidden>
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="text" readonly
                                                        class="form-control" id="jumlah-5" name="jumlah[5]"
                                                        value="{{ old('jumlah.2') }}">
                                                </div>
                                            </td>
                                            <td style="width: 50px">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="addPart(5)">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </td>
                                            <td hidden>
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="text" readonly
                                                        class="form-control" id="spareparts_id-5" name="spareparts_id[5]"
                                                        value="{{ old('spareparts_id.5') }}">
                                                </div>
                                            </td>
                                            <td onclick="addParts(5)">
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="text" readonly
                                                        class="form-control" id="kode_grease-5" name="kode_grease[5]"
                                                        value="{{ old('kode_grease.5') }}">
                                                </div>
                                            </td>
                                            <td onclick="addParts(5)">
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="text" readonly
                                                        class="form-control" id="nama_grease-5" name="nama_grease[5]"
                                                        value="{{ old('nama_grease.5') }}">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="text" class="form-control"
                                                        id="jumlah_grease-5" name="jumlah_grease[5]"
                                                        value="{{ old('jumlah_grease.5') }}">
                                                </div>
                                            </td>
                                            <td style="width: 50px">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="addParts(5)">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @if (in_array($kendaraan->jenis_kendaraan->total_ban, [18, 22]))
                                            {{-- axle 4a  --}}
                                            <tr id="pembelian-6">
                                                <td style="width: 70px; font-size:14px" class="text-center"
                                                    id="urutan">7
                                                </td>
                                                <td hidden>
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" class="form-control"
                                                            id="sparepart_id-6" name="sparepart_id[6]"
                                                            value="{{ old('sparepart_id.6') }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="form-group">
                                                            <input style="font-size:14px" type="text" readonly
                                                                class="form-control" id="kategori-6" name="kategori[6]"
                                                                value="Axle 4A">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td onclick="addPart(6)">
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" readonly
                                                            class="form-control" id="kode_barang-6" name="kode_barang[6]"
                                                            value="{{ old('kode_barang.6') }}">
                                                    </div>
                                                </td>
                                                <td onclick="addPart(6)">
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" readonly
                                                            class="form-control" id="nama_barang-6" name="nama_barang[6]"
                                                            value="{{ old('nama_barang.6') }}">
                                                    </div>
                                                </td>
                                                <td hidden>
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" readonly
                                                            class="form-control" id="jumlah-6" name="jumlah[6]"
                                                            value="{{ old('jumlah.2') }}">
                                                    </div>
                                                </td>
                                                <td style="width: 50px">
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        onclick="addPart(6)">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </td>
                                                <td hidden>
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" readonly
                                                            class="form-control" id="spareparts_id-6"
                                                            name="spareparts_id[6]"
                                                            value="{{ old('spareparts_id.6') }}">
                                                    </div>
                                                </td>
                                                <td onclick="addParts(6)">
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" readonly
                                                            class="form-control" id="kode_grease-6" name="kode_grease[6]"
                                                            value="{{ old('kode_grease.6') }}">
                                                    </div>
                                                </td>
                                                <td onclick="addParts(6)">
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" readonly
                                                            class="form-control" id="nama_grease-6" name="nama_grease[6]"
                                                            value="{{ old('nama_grease.6') }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" class="form-control"
                                                            id="jumlah_grease-6" name="jumlah_grease[6]"
                                                            value="{{ old('jumlah_grease.6') }}">
                                                    </div>
                                                </td>
                                                <td style="width: 50px">
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        onclick="addParts(6)">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </td>
                                            </tr>

                                            {{-- axle 4b --}}
                                            <tr id="pembelian-7">
                                                <td style="width: 70px; font-size:14px" class="text-center"
                                                    id="urutan">8
                                                </td>
                                                <td hidden>
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" class="form-control"
                                                            id="sparepart_id-7" name="sparepart_id[7]"
                                                            value="{{ old('sparepart_id.7') }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="form-group">
                                                            <input style="font-size:14px" type="text" readonly
                                                                class="form-control" id="kategori-7" name="kategori[7]"
                                                                value="Axle 4B">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td onclick="addPart(7)">
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" readonly
                                                            class="form-control" id="kode_barang-7" name="kode_barang[7]"
                                                            value="{{ old('kode_barang.7') }}">
                                                    </div>
                                                </td>
                                                <td onclick="addPart(7)">
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" readonly
                                                            class="form-control" id="nama_barang-7" name="nama_barang[7]"
                                                            value="{{ old('nama_barang.7') }}">
                                                    </div>
                                                </td>
                                                <td hidden>
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" readonly
                                                            class="form-control" id="jumlah-7" name="jumlah[7]"
                                                            value="{{ old('jumlah.2') }}">
                                                    </div>
                                                </td>
                                                <td style="width: 50px">
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        onclick="addPart(7)">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </td>
                                                <td hidden>
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" readonly
                                                            class="form-control" id="spareparts_id-7"
                                                            name="spareparts_id[7]"
                                                            value="{{ old('spareparts_id.7') }}">
                                                    </div>
                                                </td>
                                                <td onclick="addParts(7)">
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" readonly
                                                            class="form-control" id="kode_grease-7"
                                                            name="kode_grease[7]" value="{{ old('kode_grease.7') }}">
                                                    </div>
                                                </td>
                                                <td onclick="addParts(7)">
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" readonly
                                                            class="form-control" id="nama_grease-7"
                                                            name="nama_grease[7]" value="{{ old('nama_grease.7') }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text"
                                                            class="form-control" id="jumlah_grease-7"
                                                            name="jumlah_grease[7]"
                                                            value="{{ old('jumlah_grease.7') }}">
                                                    </div>
                                                </td>
                                                <td style="width: 50px">
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        onclick="addParts(7)">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </td>
                                            </tr>

                                            {{-- axle 5a  --}}
                                            <tr id="pembelian-8">
                                                <td style="width: 70px; font-size:14px" class="text-center"
                                                    id="urutan">9
                                                </td>
                                                <td hidden>
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text"
                                                            class="form-control" id="sparepart_id-8"
                                                            name="sparepart_id[8]"
                                                            value="{{ old('sparepart_id.8') }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="form-group">
                                                            <input style="font-size:14px" type="text" readonly
                                                                class="form-control" id="kategori-8"
                                                                name="kategori[8]" value="Axle 5A">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td onclick="addPart(8)">
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" readonly
                                                            class="form-control" id="kode_barang-8"
                                                            name="kode_barang[8]" value="{{ old('kode_barang.8') }}">
                                                    </div>
                                                </td>
                                                <td onclick="addPart(8)">
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" readonly
                                                            class="form-control" id="nama_barang-8"
                                                            name="nama_barang[8]" value="{{ old('nama_barang.8') }}">
                                                    </div>
                                                </td>
                                                <td hidden>
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" readonly
                                                            class="form-control" id="jumlah-8" name="jumlah[8]"
                                                            value="{{ old('jumlah.2') }}">
                                                    </div>
                                                </td>
                                                <td style="width: 50px">
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        onclick="addPart(8)">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </td>
                                                <td hidden>
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" readonly
                                                            class="form-control" id="spareparts_id-8"
                                                            name="spareparts_id[8]"
                                                            value="{{ old('spareparts_id.8') }}">
                                                    </div>
                                                </td>
                                                <td onclick="addParts(8)">
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" readonly
                                                            class="form-control" id="kode_grease-8"
                                                            name="kode_grease[8]" value="{{ old('kode_grease.8') }}">
                                                    </div>
                                                </td>
                                                <td onclick="addParts(8)">
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" readonly
                                                            class="form-control" id="nama_grease-8"
                                                            name="nama_grease[8]" value="{{ old('nama_grease.8') }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text"
                                                            class="form-control" id="jumlah_grease-8"
                                                            name="jumlah_grease[8]"
                                                            value="{{ old('jumlah_grease.8') }}">
                                                    </div>
                                                </td>
                                                <td style="width: 50px">
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        onclick="addParts(8)">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </td>
                                            </tr>

                                            {{-- axle 5b --}}
                                            <tr id="pembelian-9">
                                                <td style="width: 70px; font-size:14px" class="text-center"
                                                    id="urutan">10
                                                </td>
                                                <td hidden>
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text"
                                                            class="form-control" id="sparepart_id-9"
                                                            name="sparepart_id[9]"
                                                            value="{{ old('sparepart_id.9') }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="form-group">
                                                            <input style="font-size:14px" type="text" readonly
                                                                class="form-control" id="kategori-9"
                                                                name="kategori[9]" value="Axle 5B">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td onclick="addPart(9)">
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" readonly
                                                            class="form-control" id="kode_barang-9"
                                                            name="kode_barang[9]" value="{{ old('kode_barang.9') }}">
                                                    </div>
                                                </td>
                                                <td onclick="addPart(9)">
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" readonly
                                                            class="form-control" id="nama_barang-9"
                                                            name="nama_barang[9]" value="{{ old('nama_barang.9') }}">
                                                    </div>
                                                </td>
                                                <td hidden>
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" readonly
                                                            class="form-control" id="jumlah-9" name="jumlah[9]"
                                                            value="{{ old('jumlah.2') }}">
                                                    </div>
                                                </td>
                                                <td style="width: 50px">
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        onclick="addPart(9)">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </td>
                                                <td hidden>
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" readonly
                                                            class="form-control" id="spareparts_id-9"
                                                            name="spareparts_id[9]"
                                                            value="{{ old('spareparts_id.9') }}">
                                                    </div>
                                                </td>
                                                <td onclick="addParts(9)">
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" readonly
                                                            class="form-control" id="kode_grease-9"
                                                            name="kode_grease[9]" value="{{ old('kode_grease.9') }}">
                                                    </div>
                                                </td>
                                                <td onclick="addParts(9)">
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" readonly
                                                            class="form-control" id="nama_grease-9"
                                                            name="nama_grease[9]" value="{{ old('nama_grease.9') }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text"
                                                            class="form-control" id="jumlah_grease-9"
                                                            name="jumlah_grease[9]"
                                                            value="{{ old('jumlah_grease.9') }}">
                                                    </div>
                                                </td>
                                                <td style="width: 50px">
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        onclick="addParts(9)">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endif
                                        @if ($kendaraan->jenis_kendaraan->total_ban == 22)
                                            {{-- axle 6a  --}}
                                            <tr id="pembelian-10">
                                                <td style="width: 70px; font-size:14px" class="text-center"
                                                    id="urutan">11
                                                </td>
                                                <td hidden>
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text"
                                                            class="form-control" id="sparepart_id-10"
                                                            name="sparepart_id[10]"
                                                            value="{{ old('sparepart_id.10') }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="form-group">
                                                            <input style="font-size:14px" type="text" readonly
                                                                class="form-control" id="kategori-10"
                                                                name="kategori[10]" value="Axle 6A">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td onclick="addPart(10)">
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" readonly
                                                            class="form-control" id="kode_barang-10"
                                                            name="kode_barang[10]"
                                                            value="{{ old('kode_barang.10') }}">
                                                    </div>
                                                </td>
                                                <td onclick="addPart(10)">
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" readonly
                                                            class="form-control" id="nama_barang-10"
                                                            name="nama_barang[10]"
                                                            value="{{ old('nama_barang.10') }}">
                                                    </div>
                                                </td>
                                                <td hidden>
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" readonly
                                                            class="form-control" id="jumlah-10" name="jumlah[10]"
                                                            value="{{ old('jumlah.2') }}">
                                                    </div>
                                                </td>
                                                <td style="width: 50px">
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        onclick="addPart(10)">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </td>
                                                <td hidden>
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" readonly
                                                            class="form-control" id="spareparts_id-10"
                                                            name="spareparts_id[10]"
                                                            value="{{ old('spareparts_id.10') }}">
                                                    </div>
                                                </td>
                                                <td onclick="addParts(10)">
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" readonly
                                                            class="form-control" id="kode_grease-10"
                                                            name="kode_grease[10]"
                                                            value="{{ old('kode_grease.10') }}">
                                                    </div>
                                                </td>
                                                <td onclick="addParts(10)">
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" readonly
                                                            class="form-control" id="nama_grease-10"
                                                            name="nama_grease[10]"
                                                            value="{{ old('nama_grease.10') }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text"
                                                            class="form-control" id="jumlah_grease-10"
                                                            name="jumlah_grease[10]"
                                                            value="{{ old('jumlah_grease.10') }}">
                                                    </div>
                                                </td>
                                                <td style="width: 50px">
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        onclick="addParts(10)">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </td>
                                            </tr>

                                            {{-- axle 6b --}}
                                            <tr id="pembelian-11">
                                                <td style="width: 70px; font-size:14px" class="text-center"
                                                    id="urutan">12
                                                </td>
                                                <td hidden>
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text"
                                                            class="form-control" id="sparepart_id-11"
                                                            name="sparepart_id[11]"
                                                            value="{{ old('sparepart_id.11') }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="form-group">
                                                            <input style="font-size:14px" type="text" readonly
                                                                class="form-control" id="kategori-11"
                                                                name="kategori[11]" value="Axle 6B">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td onclick="addPart(11)">
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" readonly
                                                            class="form-control" id="kode_barang-11"
                                                            name="kode_barang[11]"
                                                            value="{{ old('kode_barang.11') }}">
                                                    </div>
                                                </td>
                                                <td onclick="addPart(11)">
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" readonly
                                                            class="form-control" id="nama_barang-11"
                                                            name="nama_barang[11]"
                                                            value="{{ old('nama_barang.11') }}">
                                                    </div>
                                                </td>
                                                <td hidden>
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" readonly
                                                            class="form-control" id="jumlah-11" name="jumlah[11]"
                                                            value="{{ old('jumlah.2') }}">
                                                    </div>
                                                </td>
                                                <td style="width: 50px">
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        onclick="addPart(11)">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </td>
                                                <td hidden>
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" readonly
                                                            class="form-control" id="spareparts_id-11"
                                                            name="spareparts_id[11]"
                                                            value="{{ old('spareparts_id.11') }}">
                                                    </div>
                                                </td>
                                                <td onclick="addParts(11)">
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" readonly
                                                            class="form-control" id="kode_grease-11"
                                                            name="kode_grease[11]"
                                                            value="{{ old('kode_grease.11') }}">
                                                    </div>
                                                </td>
                                                <td onclick="addParts(11)">
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" readonly
                                                            class="form-control" id="nama_grease-11"
                                                            name="nama_grease[11]"
                                                            value="{{ old('nama_grease.11') }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text"
                                                            class="form-control" id="jumlah_grease-11"
                                                            name="jumlah_grease[11]"
                                                            value="{{ old('jumlah_grease.11') }}">
                                                    </div>
                                                </td>
                                                <td style="width: 50px">
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        onclick="addParts(11)">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer text-right">
                                <button type="reset" class="btn btn-secondary" id="btnReset">Reset</button>
                                <button type="submit" class="btn btn-primary" id="btnSimpan">Simpan</button>
                                <div id="loading" style="display: none;">
                                    <i class="fas fa-spinner fa-spin"></i> Sedang Menyimpan...
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="modal fade" id="tableKategori2" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Part</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="m-2">
                            <input type="text" id="searchInput2" class="form-control" placeholder="Search...">
                        </div>
                        <table id="datatables2" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Kode Part</th>
                                    <th>Nama Part</th>
                                    <th>Stok</th>
                                    <th>Satuan</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($spareparts as $part)
                                    <tr data-sparepart_id="{{ $part->id }}"
                                        data-kode_barang="{{ $part->kode_partdetail }}"
                                        data-nama_barang="{{ $part->nama_barang }}" data-param="{{ $loop->index }}"
                                        onclick="getBarang2({{ $loop->index }})">
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $part->kode_partdetail }}</td>
                                        <td>{{ $part->nama_barang }}</td>
                                        <td>{{ $part->jumlah }}</td>
                                        <td>{{ $part->satuan }}</td>
                                        <td class="text-center">
                                            <button type="button" id="btnTambah" class="btn btn-primary btn-sm"
                                                onclick="getBarang2({{ $loop->index }})">
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

        <div class="modal fade" id="tableKategori" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Part</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="m-2">
                            <input type="text" id="searchInput" class="form-control" placeholder="Search...">
                        </div>
                        <table id="tables" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Kode Part</th>
                                    <th>Nama Part</th>
                                    <th>Stok</th>
                                    <th>Satuan</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($spareparts as $part)
                                    <tr data-sparepart_id="{{ $part->id }}"
                                        data-kode_barang="{{ $part->kode_partdetail }}"
                                        data-nama_barang="{{ $part->nama_barang }}" data-param="{{ $loop->index }}"
                                        onclick="getBarang({{ $loop->index }})">
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $part->kode_partdetail }}</td>
                                        <td>{{ $part->nama_barang }}</td>
                                        <td>{{ $part->jumlah }}</td>
                                        <td>{{ $part->satuan }}</td>
                                        <td class="text-center">
                                            <button type="button" id="btnTambah" class="btn btn-primary btn-sm"
                                                onclick="getBarang({{ $loop->index }})">
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

    </section>

    <script>
        // Function to filter the table rows based on the search input
        function filterTable() {
            var input, filter, table, tr, td, i, j, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("tables");
            tr = table.getElementsByTagName("tr");

            for (i = 0; i < tr.length; i++) {
                var displayRow = false;

                // Loop through columns (td 1, 2, and 3)
                for (j = 1; j <= 3; j++) {
                    td = tr[i].getElementsByTagName("td")[j];
                    if (td) {
                        txtValue = td.textContent || td.innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            displayRow = true;
                            break; // Break the loop if a match is found in any column
                        }
                    }
                }

                // Set the display style based on whether a match is found in any column
                tr[i].style.display = displayRow ? "" : "none";
            }
        }
        document.getElementById("searchInput").addEventListener("input", filterTable);


        function filterTable2() {
            var input, filter, table, tr, td, i, j, txtValue;
            input = document.getElementById("searchInput2");
            filter = input.value.toUpperCase();
            table = document.getElementById("datatables2");
            tr = table.getElementsByTagName("tr");

            for (i = 0; i < tr.length; i++) {
                var displayRow = false;

                // Loop through columns (td 1, 2, and 3)
                for (j = 1; j <= 3; j++) {
                    td = tr[i].getElementsByTagName("td")[j];
                    if (td) {
                        txtValue = td.textContent || td.innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            displayRow = true;
                            break; // Break the loop if a match is found in any column
                        }
                    }
                }

                // Set the display style based on whether a match is found in any column
                tr[i].style.display = displayRow ? "" : "none";
            }
        }
        document.getElementById("searchInput2").addEventListener("input", filterTable2);

        var activeSpecificationIndex = 0;

        function addPart(param) {
            activeSpecificationIndex = param;
            // Show the modal and filter rows if necessary
            $('#tableKategori').modal('show');
        }

        function getBarang(rowIndex) {
            var selectedRow = $('#tables tbody tr:eq(' + rowIndex + ')');
            var sparepart_id = selectedRow.data('sparepart_id');
            var kode_barang = selectedRow.data('kode_barang');
            var nama_barang = selectedRow.data('nama_barang');
            var jumlah = 1;

            $('#sparepart_id-' + activeSpecificationIndex).val(sparepart_id);
            $('#kode_barang-' + activeSpecificationIndex).val(kode_barang);
            $('#nama_barang-' + activeSpecificationIndex).val(nama_barang);
            $('#jumlah-' + activeSpecificationIndex).val(jumlah);
            $('#tableKategori').modal('hide');
        }


        var activeSpecificationIndex2 = 0;

        function addParts(param) {
            activeSpecificationIndex2 = param;
            // Show the modal and filter rows if necessary
            $('#tableKategori2').modal('show');
        }

        function getBarang2(rowIndex) {
            var selectedRow = $('#datatables2 tbody tr:eq(' + rowIndex + ')');
            var sparepart_id = selectedRow.data('sparepart_id');
            var kode_barang = selectedRow.data('kode_barang');
            var nama_barang = selectedRow.data('nama_barang');

            $('#spareparts_id-' + activeSpecificationIndex2).val(sparepart_id);
            $('#kode_grease-' + activeSpecificationIndex2).val(kode_barang);
            $('#nama_grease-' + activeSpecificationIndex2).val(nama_barang);

            $('#tableKategori2').modal('hide');
        }
    </script>

    <script>
        function getData() {
            var jumlah_ban = document.getElementById('jumlah_ban');
            var layout_tronton = document.getElementById('layout_tronton');
            var layout_trailer_engkel = document.getElementById('layout_trailer_engkel');
            var layout_trailer_tronton = document.getElementById('layout_trailer_tronton');

            // Mendapatkan value terpilih dari jumlah_ban
            var selectedValue = jumlah_ban.value;

            // Menyembunyikan semua layout terlebih dahulu
            layout_tronton.style.display = 'none';
            layout_trailer_engkel.style.display = 'none';
            layout_trailer_tronton.style.display = 'none';

            // Memeriksa value terpilih dan menampilkan layout yang sesuai
            if (selectedValue === '6') {
                // Tidak ada layout yang perlu ditampilkan untuk kendaraan engkel
            } else if (selectedValue === '10') {
                // Tampilkan hanya layout tronton
            } else if (selectedValue === '18') {
                // Tampilkan layout tronton dan trailer engkel
                layout_tronton.style.display = 'inline';
                layout_trailer_engkel.style.display = 'inline';
            } else if (selectedValue === '22') {
                // Tampilkan layout tronton, trailer engkel, dan trailer tronton
                layout_tronton.style.display = 'inline';
                layout_trailer_engkel.style.display = 'inline';
                layout_trailer_tronton.style.display = 'inline';
            }
        }

        // Memanggil fungsi getData untuk menjalankan logika saat halaman pertama kali dimuat
        window.onload = getData;
    </script>

    <script>
        $(document).ready(function() {
            // Tambahkan event listener pada tombol "Simpan"
            $('#btnSimpan').click(function() {
                // Sembunyikan tombol "Simpan" dan "Reset", serta tampilkan elemen loading
                $(this).hide();
                $('#btnReset').hide(); // Tambahkan id "btnReset" pada tombol "Reset"
                $('#loading').show();

                // Lakukan pengiriman formulir
                $('form').submit();
            });
        });
    </script>
@endsection
