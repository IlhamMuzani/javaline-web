@extends('layouts.app')

@section('title', 'Penggantian Bearing')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
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

    <section class="content">
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
            <form action="{{ url('admin/inquery_penggantianbearing/' . $inquery->id) }}" method="POST"
                enctype="multipart/form-data" autocomplete="off">
                @csrf
                @method('put')
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
                                        readonly placeholder="Masukan no registrasi kendaraan"
                                        value="{{ $inquery->kendaraan->id }}">
                                </div>
                                <div class="form-group">
                                    <label for="nopol">No. Kabin</label>
                                    <input type="text" class="form-control" id="no_pol" name="no_pol" readonly
                                        placeholder="Masukan no registrasi kendaraan"
                                        value="{{ $inquery->kendaraan->no_kabin }}">
                                </div>
                                <div class="form-group">
                                    <label for="nopol">No. Registrasi Kendaraan</label>
                                    <input type="text" class="form-control" id="no_pol" name="no_pol" readonly
                                        placeholder="Masukan no registrasi kendaraan"
                                        value="{{ $inquery->kendaraan->no_pol }}">
                                </div>
                                <div hidden class="form-group">
                                    <label for="nama">Jumlah Ban</label>
                                    <input type="text" class="form-control" id="jumlah_ban" name="jumlah_ban" readonly
                                        placeholder="Masukan jumlah ban"
                                        value="{{ $inquery->kendaraan->jenis_kendaraan->total_ban }}">
                                </div>
                                <div class="form-group" id="layoutjenis">
                                    <label for="jenis_kendaraan">Jenis Kendaraan</label>
                                    <input type="text" class="form-control" id="jenis_kendaraan" name="jenis_kendaraan"
                                        readonly placeholder="Masukan jenis kendaraan"
                                        value="{{ $inquery->kendaraan->jenis_kendaraan->nama_jenis_kendaraan ?? null }}">
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Km Penggantian</label>
                                    <input type="number" class="form-control" id="km" name="km"
                                        value="{{ $inquery->kendaraan->km ?? null }}">
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
                                                @if (
                                                    $inquery->kendaraan->bearing->isNotEmpty() &&
                                                        $inquery->kendaraan->bearing->first()->status_bearing1a == 'belum penggantian')
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
                                                @if (
                                                    $inquery->kendaraan->bearing->isNotEmpty() &&
                                                        $inquery->kendaraan->bearing->first()->status_bearing1b == 'belum penggantian')
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
                                                @if (
                                                    $inquery->kendaraan->bearing->isNotEmpty() &&
                                                        $inquery->kendaraan->bearing->first()->status_bearing2a == 'belum penggantian')
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
                                                @if (
                                                    $inquery->kendaraan->bearing->isNotEmpty() &&
                                                        $inquery->kendaraan->bearing->first()->status_bearing2b == 'belum penggantian')
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
                                                @if (
                                                    $inquery->kendaraan->bearing->isNotEmpty() &&
                                                        $inquery->kendaraan->bearing->first()->status_bearing3a == 'belum penggantian')
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
                                                @if (
                                                    $inquery->kendaraan->bearing->isNotEmpty() &&
                                                        $inquery->kendaraan->bearing->first()->status_bearing3b == 'belum penggantian')
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
                                                @if (
                                                    $inquery->kendaraan->bearing->isNotEmpty() &&
                                                        $inquery->kendaraan->bearing->first()->status_bearing4a == 'belum penggantian')
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
                                                @if (
                                                    $inquery->kendaraan->bearing->isNotEmpty() &&
                                                        $inquery->kendaraan->bearing->first()->status_bearing4b == 'belum penggantian')
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
                                                @if (
                                                    $inquery->kendaraan->bearing->isNotEmpty() &&
                                                        $inquery->kendaraan->bearing->first()->status_bearing5a == 'belum penggantian')
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
                                                @if (
                                                    $inquery->kendaraan->bearing->isNotEmpty() &&
                                                        $inquery->kendaraan->bearing->first()->status_bearing5b == 'belum penggantian')
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
                                                @if (
                                                    $inquery->kendaraan->bearing->isNotEmpty() &&
                                                        $inquery->kendaraan->bearing->first()->status_bearing6a == 'belum penggantian')
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
                                                @if (
                                                    $inquery->kendaraan->bearing->isNotEmpty() &&
                                                        $inquery->kendaraan->bearing->first()->status_bearing6b == 'belum penggantian')
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
                    <div class="card-header">
                        <h3 class="card-title">Posisi Bearing</h3>
                    </div>
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
                                        @foreach ($details as $detail)
                                            <tr id="pembelian-{{ $loop->index }}">
                                                <td class="text-center" id="urutan">{{ $loop->index + 1 }}</td>
                                                <td hidden>
                                                    <input type="text" class="form-control" id="nomor_seri-0"
                                                        name="detail_ids[]" value="{{ $detail['id'] }}">
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" class="form-control"
                                                            id="sparepart_id-{{ $loop->index }}" name="sparepart_id[]"
                                                            value="{{ $detail['sparepart_id'] }}">
                                                    </div>
                                                </td>

                                                <td onclick="addPart({{ $loop->index }})">
                                                    <div class="form-group">
                                                        <input readonly style="font-size:14px" type="text"
                                                            class="form-control" id="kategori-{{ $loop->index }}"
                                                            name="kategori[]" value="{{ $detail['kategori'] }}">
                                                    </div>
                                                </td>
                                                <td onclick="addPart({{ $loop->index }})">
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" readonly
                                                            class="form-control" id="kode_barang-{{ $loop->index }}"
                                                            name="kode_barang[]" value="{{ $detail['kode_barang'] }}">
                                                    </div>
                                                </td>
                                                <td onclick="addPart({{ $loop->index }})">
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" readonly
                                                            class="form-control" id="nama_barang-{{ $loop->index }}"
                                                            name="nama_barang[]" value="{{ $detail['nama_barang'] }}">
                                                    </div>
                                                </td>
                                                <td hidden>
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" readonly
                                                            class="form-control" id="jumlah-{{ $loop->index }}"
                                                            name="jumlah[]" value="{{ $detail['jumlah'] }}">
                                                    </div>
                                                </td>
                                                <td style="width: 50px">
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        onclick="addPart({{ $loop->index }})">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </td>
                                                <td hidden>
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" readonly
                                                            class="form-control" id="spareparts_id-{{ $loop->index }}"
                                                            name="spareparts_id[]"
                                                            value="{{ $detail['spareparts_id'] }}">
                                                    </div>
                                                </td>
                                                <td onclick="addPa{{ $loop->index }})">
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" readonly
                                                            class="form-control" id="kode_grease-{{ $loop->index }}"
                                                            name="kode_grease[]" value="{{ $detail['kode_grease'] }}">
                                                    </div>
                                                </td>
                                                <td onclick="addParts({{ $loop->index }})">
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" readonly
                                                            class="form-control" id="nama_grease-{{ $loop->index }}"
                                                            name="nama_grease[]" value="{{ $detail['nama_grease'] }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" class="form-control"
                                                            id="jumlah_grease-{{ $loop->index }}" name="jumlah_grease[]"
                                                            value="{{ $detail['jumlah_grease'] }}">
                                                    </div>
                                                </td>
                                                <td style="width: 50px">
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        onclick="addParts({{ $loop->index }})">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
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
        var data_pembelian = @json(session('data_pembelians'));
        var jumlah_ban = 1;

        if (data_pembelian != null) {
            jumlah_ban = data_pembelian.length;
            $('#tabel-pembelian').empty();
            var urutan = 0;
            $.each(data_pembelian, function(key, value) {
                urutan = urutan + 1;
                itemPembelian(urutan, key, value);
            });
        }

        function updateUrutan() {
            var urutan = document.querySelectorAll('#urutan');
            for (let i = 0; i < urutan.length; i++) {
                urutan[i].innerText = i + 1;
            }
        }

        var counter = 0;

        function addPesanan() {
            counter++;
            jumlah_ban = jumlah_ban + 1;

            if (jumlah_ban === 1) {
                $('#tabel-pembelian').empty();
            } else {
                // Find the last row and get its index to continue the numbering
                var lastRow = $('#tabel-pembelian tr:last');
                var lastRowIndex = lastRow.find('#urutan').text();
                jumlah_ban = parseInt(lastRowIndex) + 1;
            }

            console.log('Current jumlah_ban:', jumlah_ban);
            itemPembelian(jumlah_ban, jumlah_ban - 1);
            updateUrutan();
        }

        function removeBan(identifier, detailId) {
            var row = document.getElementById('pembelian-' + identifier);
            row.remove();

            $.ajax({
                url: "{{ url('admin/inquery_penggantianbearing/deletedetailpenggantian/') }}/" + detailId,
                type: "POST",
                data: {
                    _method: 'DELETE',
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log('Data deleted successfully');
                },
                error: function(error) {
                    console.error('Failed to delete data:', error);
                }
            });

            updateUrutan();
        }

        function itemPembelian(identifier, key, value = null) {
            var sparepart_id = '';
            var kategori = '';
            var kode_barang = '';
            var nama_barang = '';
            var jumlah = '';

            if (value !== null) {
                sparepart_id = value.sparepart_id;
                kategori = value.kategori;
                kode_barang = value.kode_barang;
                nama_barang = value.nama_barang;
                jumlah = value.jumlah;
            }
            var total_ban = {!! json_encode($inquery->kendaraan->jenis_kendaraan->total_ban) !!};
            var bearing = {!! json_encode($inquery->kendaraan->bearing->first()) !!};

            // urutan 
            var item_pembelian = '<tr id="pembelian-' + key + '">';
            item_pembelian += '<td class="text-center" id="urutan">' + key + '</td>';
            // sparepart_id 
            item_pembelian += '<td hidden>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" style="font-size:14px" id="sparepart_id-' +
                key +
                '" name="sparepart_id[]" value="' + sparepart_id + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // kategori
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">';
            item_pembelian += '<select class="form-control" id="kategori-' + key + '" name="kategori[]">';
            item_pembelian += '<option value="">- Pilih Posisi -</option>';

            // Cek nilai total ban, misalnya 18 atau 22
            if (bearing && bearing.status_bearing1a === 'belum penggantian') {
                item_pembelian += '<option value="Axle 1A"' + (kategori === 'Axle 1A' ? ' selected' : '') +
                    '>Axle 1A</option>';
            }
            if (bearing && bearing.status_bearing1b === 'belum penggantian') {
                item_pembelian += '<option value="Axle 1B"' + (kategori === 'Axle 1B' ? ' selected' : '') +
                    '>Axle 1B</option>';
            }
            if (bearing && bearing.status_bearing2a === 'belum penggantian') {
                item_pembelian += '<option value="Axle 2A"' + (kategori === 'Axle 2A' ? ' selected' : '') +
                    '>Axle 2A</option>';
            }
            if (bearing && bearing.status_bearing2b === 'belum penggantian') {
                item_pembelian += '<option value="Axle 2B"' + (kategori === 'Axle 2B' ? ' selected' : '') +
                    '>Axle 2B</option>';
            }
            if (bearing && bearing.status_bearing3a === 'belum penggantian') {
                item_pembelian += '<option value="Axle 3A"' + (kategori === 'Axle 3A' ? ' selected' : '') +
                    '>Axle 3A</option>';
            }
            if (bearing && bearing.status_bearing3b === 'belum penggantian') {
                item_pembelian += '<option value="Axle 3B"' + (kategori === 'Axle 3B' ? ' selected' : '') +
                    '>Axle 3B</option>';
            }
            if (total_ban === 18 || total_ban === 22) {
                if (bearing && bearing.status_bearing4a === 'belum penggantian') {
                    item_pembelian += '<option value="Axle 4A"' + (kategori === 'Axle 4A' ? ' selected' : '') +
                        '>Axle 4A</option>';
                }
                if (bearing && bearing.status_bearing4b === 'belum penggantian') {

                    item_pembelian += '<option value="Axle 4B"' + (kategori === 'Axle 4B' ? ' selected' : '') +
                        '>Axle 4B</option>';
                }
                if (bearing && bearing.status_bearing5a === 'belum penggantian') {

                    item_pembelian += '<option value="Axle 5A"' + (kategori === 'Axle 5A' ? ' selected' : '') +
                        '>Axle 5A</option>';
                }
                if (bearing && bearing.status_bearing5b === 'belum penggantian') {

                    item_pembelian += '<option value="Axle 5B"' + (kategori === 'Axle 5B' ? ' selected' : '') +
                        '>Axle 5B</option>';
                }
                // Tambahkan opsi Axle 6 jika total ban adalah 22
                if (total_ban === 22) {
                    if (bearing && bearing.status_bearing6a === 'belum penggantian') {
                        item_pembelian += '<option value="Axle 6A"' + (kategori === 'Axle 6A' ? ' selected' : '') +
                            '>Axle 6A</option>';
                    }
                    if (bearing && bearing.status_bearing6b === 'belum penggantian') {
                        item_pembelian += '<option value="Axle 6B"' + (kategori === 'Axle 6B' ? ' selected' : '') +
                            '>Axle 6B</option>';
                    }
                }
            }

            item_pembelian += '</select>';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // kode_barang 
            item_pembelian += '<td onclick="addPart(' + key +
                ')">';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" readonly style="font-size:14px" id="kode_barang-' +
                key +
                '" name="kode_barang[]" value="' + kode_barang + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // nama_barang 
            item_pembelian += '<td onclick="addPart(' + key +
                ')">';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" style="font-size:14px" readonly id="nama_barang-' +
                key +
                '" name="nama_barang[]" value="' + nama_barang + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // jumlah 
            item_pembelian += '<td onclick="addPart(' + key +
                ')">';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" style="font-size:14px" readonly id="jumlah-' +
                key +
                '" name="jumlah[]" value="' + jumlah + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';


            item_pembelian += '<td style="width: 100px">';
            item_pembelian += '<button type="button" class="btn btn-primary btn-sm" onclick="addPart(' + key +
                ')">';
            item_pembelian += '<i class="fas fa-plus"></i>';
            item_pembelian += '</button>';
            item_pembelian +=
                '<button style="margin-left:10px" type="button" class="btn btn-danger btn-sm" onclick="removeBan(' +
                key + ')">';
            item_pembelian += '<i class="fas fa-trash"></i>';
            item_pembelian += '</button>';
            item_pembelian += '</td>';
            item_pembelian += '</tr>';

            $('#tabel-pembelian').append(item_pembelian);
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

@endsection