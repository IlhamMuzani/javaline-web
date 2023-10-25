@extends('layouts.app')

@section('title', 'Status Perjalanan Kendaraan')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                {{-- <div class="col-sm-6">
                    <h1 class="m-0">Status Perjalanan Kendaraan</h1>
                </div><!-- /.col --> --}}
                {{-- <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Status Perjalanan Kendaraan</li>
                    </ol>
                </div><!-- /.col --> --}}
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
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
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Status Perjalanan Kendaraan</h3>
                    {{-- <div class="float-right">
                        <a href="{{ url('admin/ban/create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah
                        </a>
                    </div> --}}
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="GET" id="form-action">
                        <div class="form-row">
                            <div class="col-md-4 col-sm-12">
                                <div class="input-group mb-2">
                                    <select class="custom-select form-control mr-2" id="status_perjalanan"
                                        name="status_perjalanan">
                                        <option value="">- Semua Status -</option>
                                        <option value="Tunggu Muat"
                                            {{ Request::get('status_perjalanan') == 'stok' ? 'selected' : '' }}>
                                            Tunggu Muat</option>
                                        <option value="Loading Muat"
                                            {{ Request::get('status_perjalanan') == 'aktif' ? 'selected' : '' }}>
                                            Loading Muat</option>
                                        <option value="Perjalanan Isi"
                                            {{ Request::get('status_perjalanan') == 'aktif' ? 'selected' : '' }}>
                                            Perjalanan Isi</option>
                                        <option value="Tunggu Bongkar"
                                            {{ Request::get('status_perjalanan') == 'aktif' ? 'selected' : '' }}>
                                            Tunggu Bongkar</option>
                                        <option value="Loading Bongkar"
                                            {{ Request::get('status_perjalanan') == 'aktif' ? 'selected' : '' }}>
                                            Loading Bongkar</option>
                                        <option value="Perjalanan Kosong"
                                            {{ Request::get('status_perjalanan') == 'aktif' ? 'selected' : '' }}>
                                            Perjalanan Kosong</option>
                                        <option value="Perbaikan di jalan"
                                            {{ Request::get('status_perjalanan') == 'aktif' ? 'selected' : '' }}>
                                            Perbaikan di jalan</option>
                                        <option value="Perbaikan di garasi"
                                            {{ Request::get('status_perjalanan') == 'aktif' ? 'selected' : '' }}>
                                            Perbaikan di garasi</option>
                                        </option>
                                    </select>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-outline-primary" onclick="cari()">
                                            <i class="fas fa-search"></i> Cari
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>No. Kabin</th>
                                <th>No. Registrasi</th>
                                <th>Nama Driver</th>
                                <th>Tujuan</th>
                                <th>Pelanggan</th>
                                <th>Status Kendaraan</th>
                                <th>Timer</th>
                                <th class="text-center" width="40">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kendaraans as $kendaraan)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $kendaraan->no_kabin }}</td>
                                    <td>{{ $kendaraan->no_pol }}</td>
                                    <td>
                                        @if ($kendaraan->user)
                                            {{ $kendaraan->user->karyawan->nama_lengkap }}
                                        @else
                                            driver tidak ada
                                        @endif
                                    </td>
                                    <td>
                                        @if ($kendaraan->kota)
                                            {{ $kendaraan->kota->nama }}
                                        @else
                                            tujuan tidak ada
                                        @endif
                                    </td>
                                    <td>
                                        @if ($kendaraan->pelanggan)
                                            {{ $kendaraan->pelanggan->nama_pell }}
                                        @else
                                            tidak ada
                                        @endif
                                    </td>
                                    <td>
                                        @if ($kendaraan->status_perjalanan)
                                            {{ $kendaraan->status_perjalanan }}
                                        @else
                                            menunggu konfirmasi
                                        @endif
                                    </td>
                                    <td>
                                        @if ($kendaraan->status_perjalanan)
                                            {{ $kendaraan->timer }}
                                        @else
                                            Kosong
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($kendaraan->status_perjalanan == 'Tunggu Muat')
                                            <button type="button" class="btn btn-yellow btn-sm"
                                                style="background-color: #eeff00;" data-toggle="modal"
                                                data-target="#modal-posting-{{ $kendaraan->id }}">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        @endif
                                        @if ($kendaraan->status_perjalanan == 'Loading Muat')
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                                data-target="#modal-posting-{{ $kendaraan->id }}">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        @endif
                                        @if ($kendaraan->status_perjalanan == 'Perjalanan Isi')
                                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                                style="background-color: #80ff00;"
                                                data-target="#modal-posting-{{ $kendaraan->id }}">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        @endif
                                        @if ($kendaraan->status_perjalanan == 'Tunggu Bongkar')
                                            <button type="button" class="btn btn-yellow btn-sm"
                                                style="background-color: #ff4800;" data-toggle="modal"
                                                data-target="#modal-posting-{{ $kendaraan->id }}">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        @endif
                                        @if ($kendaraan->status_perjalanan == 'Perbaikan di jalan')
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                style="background-color: #ff00b3;"
                                                data-target="#modal-posting-{{ $kendaraan->id }}">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        @endif
                                        @if ($kendaraan->status_perjalanan == 'Perbaikan di garasi')
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#modal-posting-{{ $kendaraan->id }}">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        @endif
                                        @if ($kendaraan->status_perjalanan == 'Loading Bongkar')
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                                style="background-color: #00c3ff;"
                                                data-target="#modal-posting-{{ $kendaraan->id }}">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        @endif
                                        @if ($kendaraan->status_perjalanan == 'Perjalanan Kosong')
                                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                                data-target="#modal-posting-{{ $kendaraan->id }}">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                                <div class="modal fade" id="modal-posting-{{ $kendaraan->id }}" data-backdrop="static">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div style="text-align: center;">
                                                    <form action="{{ url('admin/status_perjalanan/' . $kendaraan->id) }}"
                                                        method="POST" enctype="multipart/form-data" autocomplete="off">
                                                        @csrf
                                                        @method('put')
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h3 class="card-title">Perbarui</h3>
                                                                <div class="float-right">

                                                                    <button type="button" data-toggle="modal"
                                                                        data-target="#modal-kota"
                                                                        class="btn btn-primary btn-sm">
                                                                        <i class="fas fa-plus mr">Tujuan</i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="mr-3 ml-3">
                                                                <div class="form-group" style="flex: 8;">
                                                                    <label for="tujuan">Tujuan Perjalanan</label>
                                                                    <select class="form-control" id="kota_id"
                                                                        name="kota_id">
                                                                        <option value="">- Pilih -</option>
                                                                        @foreach ($kotas as $kota)
                                                                            <option value="{{ $kota->id }}"
                                                                                {{ old('kota_id', $kendaraan->kota_id) == $kota->id ? 'selected' : '' }}>
                                                                                {{ $kota->nama }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label"
                                                                        for="status_perjalanan">Status
                                                                        Perjalanan</label>
                                                                    <select class="form-control" id="nama_bank"
                                                                        name="status_perjalanan">
                                                                        <option value="">- Pilih -</option>
                                                                        <option value="Tunggu Muat"
                                                                            {{ old('status_perjalanan', $kendaraan->status_perjalanan) == 'Tunggu Muat' ? 'selected' : null }}>
                                                                            Tunggu Muat</option>
                                                                        <option value="Loading Muat"
                                                                            {{ old('status_perjalanan', $kendaraan->status_perjalanan) == 'Loading Muat' ? 'selected' : null }}>
                                                                            Loading Muat</option>
                                                                        <option value="Perjalanan Isi"
                                                                            {{ old('status_perjalanan', $kendaraan->status_perjalanan) == 'Perjalanan Isi' ? 'selected' : null }}>
                                                                            Perjalanan Isi</option>
                                                                        <option value="Tunggu Bongkar"
                                                                            {{ old('status_perjalanan', $kendaraan->status_perjalanan) == 'Tunggu Bongkar' ? 'selected' : null }}>
                                                                            Tunggu Bongkar</option>
                                                                        <option value="Loading Bongkar"
                                                                            {{ old('status_perjalanan', $kendaraan->status_perjalanan) == 'Loading Bongkar' ? 'selected' : null }}>
                                                                            Loading Bongkar</option>
                                                                        <option value="Perjalanan Kosong"
                                                                            {{ old('status_perjalanan', $kendaraan->status_perjalanan) == 'Perjalanan Kosong' ? 'selected' : null }}>
                                                                            Perjalanan Kosong</option>
                                                                        <option value="Perbaikan di jalan"
                                                                            {{ old('status_perjalanan', $kendaraan->status_perjalanan) == 'Perbaikan di jalan' ? 'selected' : null }}>
                                                                            Perbaikan di jalan</option>
                                                                        <option value="Perbaikan di garasi"
                                                                            {{ old('status_perjalanan', $kendaraan->status_perjalanan) == 'Perbaikan di garasi' ? 'selected' : null }}>
                                                                            Perbaikan di garasi</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                        </div>
                                                </div>
                                                <div class="card-footer text-right">
                                                    <button type="submit" class="btn btn-primary">Konfirmasi</button>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="modal-kota" data-backdrop="static">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Tambah Tujuan</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div style="text-align: center;">
                                                    <form id="form-sparepart" action="{{ url('admin/kota') }}"
                                                        method="POST" enctype="multipart/form-data" autocomplete="off">
                                                        @csrf
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div class="form-group">
                                                                    <label for="nama">Nama Kota (Tujuan)</label>
                                                                    <input type="text" class="form-control"
                                                                        id="nama" name="nama"
                                                                        placeholder="Masukan nama tujuan" value="">
                                                                </div>
                                                            </div>
                                                            <div class="card-footer text-right">

                                                                <button type="submit"
                                                                    class="btn btn-primary">Simpan</button>
                                                            </div>
                                                        </div>

                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="modal fade" id="modal-posting-{{ $kendaraan->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div style="text-align: center;">
                                                    <form action="{{ url('admin/status_perjalanan/' . $kendaraan->id) }}"
                                                        method="POST" enctype="multipart/form-data" autocomplete="off">
                                                        @csrf
                                                        @method('put')
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h3 class="card-title">Perbarui</h3>
                                                            </div>
                                                            <div class="mr-3 ml-3">
                                                                <div class="form-group" style="flex: 8;">
                                                                    <label for="tujuan">Tujuan Perjalanan</label>
                                                                    <select class="form-control"
                                                                        id="tujuan{{ $kendaraan->id }}" name="tujuan">
                                                                        <option value="">- Pilih -</option>
                                                                        <optgroup label="Jawa Timur">
                                                                            <option
                                                                                value="Kabupaten Bangkalan"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Bangkalan' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Bangkalan
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Banyuwangi"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Banyuwangi' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Banyuwangi
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Blitar"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Blitar' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Blitar
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Bojonegoro"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Bojonegoro' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Bojonegoro
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Bondowoso"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Bondowoso' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Bondowoso
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Gresik"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Gresik' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Gresik
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Jember"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Jember' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Jember
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Jombang"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Jombang' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Jombang
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Kediri"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Kediri' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Kediri
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Lamongan"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Lamongan' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Lamongan
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Lumajang"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Lumajang' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Lumajang
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Madiun"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Madiun' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Madiun
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Magetan"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Magetan' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Magetan
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Malang"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Malang' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Malang
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Mojokerto"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Mojokerto' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Mojokerto
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Nganjuk"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Nganjuk' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Nganjuk
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Ngawi"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Ngawi' ? 'selected' : null }}>
                                                                                Kabupaten Ngawi
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Pacitan"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Pacitan' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Pacitan
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Pamekasan"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Pamekasan' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Pamekasan
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Pasuruan"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Pasuruan' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Pasuruan
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Ponorogo"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Ponorogo' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Ponorogo
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Probolinggo"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Probolinggo' ? 'selected' : null }}>
                                                                                Kabupaten Probolinggo</option>
                                                                            <option
                                                                                value="Kabupaten Sampang"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Sampang' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Sampang
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Sidoarjo"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Sidoarjo' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Sidoarjo
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Situbondo"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Situbondo' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Situbondo
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Sumenep"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Sumenep' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Sumenep
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Trenggalek"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Trenggalek' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Trenggalek
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Tuban"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Tuban' ? 'selected' : null }}>
                                                                                Kabupaten Tuban
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Tulungagung"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Tulungagung' ? 'selected' : null }}>
                                                                                Kabupaten Tulungagung</option>

                                                                            <option
                                                                                value="Kota Batu"{{ old('tujuan', $kendaraan->tujuan) == 'Kota Batu' ? 'selected' : null }}>
                                                                                Kota Batu</option>
                                                                            <option
                                                                                value="Kota Blitar"{{ old('tujuan', $kendaraan->tujuan) == 'Kota Blitar' ? 'selected' : null }}>
                                                                                Kota Blitar</option>
                                                                            <option
                                                                                value="Kota Kediri"{{ old('tujuan', $kendaraan->tujuan) == 'Kota Kediri' ? 'selected' : null }}>
                                                                                Kota Kediri</option>
                                                                            <option
                                                                                value="Kota Madiun"{{ old('tujuan', $kendaraan->tujuan) == 'Kota Madiun' ? 'selected' : null }}>
                                                                                Kota Madiun</option>
                                                                            <option
                                                                                value="Kota Malang"{{ old('tujuan', $kendaraan->tujuan) == 'Kota Malang' ? 'selected' : null }}>
                                                                                Kota Malang</option>
                                                                            <option
                                                                                value="Kota Mojokerto"{{ old('tujuan', $kendaraan->tujuan) == 'Kota Mojokerto' ? 'selected' : null }}>
                                                                                Kota Mojokerto
                                                                            </option>
                                                                            <option
                                                                                value="Kota Pasuruan"{{ old('tujuan', $kendaraan->tujuan) == 'Kota Pasuruan' ? 'selected' : null }}>
                                                                                Kota Pasuruan
                                                                            </option>
                                                                            <option
                                                                                value="Kota Probolinggo"{{ old('tujuan', $kendaraan->tujuan) == 'Kota Probolinggo' ? 'selected' : null }}>
                                                                                Kota Probolinggo
                                                                            </option>
                                                                            <option
                                                                                value="Kota Surabaya"{{ old('tujuan', $kendaraan->tujuan) == 'Kota Surabaya' ? 'selected' : null }}>
                                                                                Kota Surabaya
                                                                            </option>
                                                                        </optgroup>
                                                                        <optgroup label="Jawa Tengah">
                                                                            <option
                                                                                value="Kabupaten Banjarnegara"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Banjarnegara' ? 'selected' : null }}>
                                                                                Kabupaten Banjarnegara</option>
                                                                            <option
                                                                                value="Kabupaten Banyumas"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Banyumas' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Banyumas
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Batang"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Batang' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Batang
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Blora"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Blora' ? 'selected' : null }}>
                                                                                Kabupaten Blora
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Boyolali"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Boyolali' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Boyolali
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Brebes"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Brebes' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Brebes
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Cilacap"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Cilacap' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Cilacap
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Demak"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Demak' ? 'selected' : null }}>
                                                                                Kabupaten Demak
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Grobogan"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Grobogan' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Grobogan
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Jepara"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Jepara' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Jepara
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Karanganyar"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Karanganyar' ? 'selected' : null }}>
                                                                                Kabupaten Karanganyar</option>
                                                                            <option
                                                                                value="Kabupaten Kebumen"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Kebumen' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Kebumen
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Kendal"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Kendal' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Kendal
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Klaten"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Klaten' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Klaten
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Kudus"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Kudus' ? 'selected' : null }}>
                                                                                Kabupaten Kudus
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Magelang"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Magelang' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Magelang
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Pati"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Pati' ? 'selected' : null }}>
                                                                                Kabupaten Pati
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Pekalongan"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Pekalongan' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Pekalongan
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Pemalang"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Pemalang' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Pemalang
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Purbalingga"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Purbalingga' ? 'selected' : null }}>
                                                                                Kabupaten Purbalingga</option>
                                                                            <option
                                                                                value="Kabupaten Purworejo"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Purworejo' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Purworejo
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Rembang"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Rembang' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Rembang
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Semarang"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Semarang' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Semarang
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Sragen"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Sragen' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Sragen
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Sukoharjo"{{ old('tujuan', $kendaraan->tujuan) == 'Tunggu Muat' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Sukoharjo
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Tegal"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Tegal' ? 'selected' : null }}>
                                                                                Kabupaten Tegal
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Temanggung"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Temanggung' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Temanggung
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Wonogiri"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Wonogiri' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Wonogiri
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Wonosobo"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Wonosobo' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Wonosobo
                                                                            </option>
                                                                            <option
                                                                                value="Kota Magelang"{{ old('tujuan', $kendaraan->tujuan) == 'Kota Magelang' ? 'selected' : null }}>
                                                                                Kota Magelang
                                                                            </option>
                                                                            <option
                                                                                value="Kota Pekalongan"{{ old('tujuan', $kendaraan->tujuan) == 'Kota Pekalongan' ? 'selected' : null }}>
                                                                                Kota Pekalongan
                                                                            </option>
                                                                            <option
                                                                                value="Kota Salatiga"{{ old('tujuan', $kendaraan->tujuan) == 'Kota Salatiga' ? 'selected' : null }}>
                                                                                Kota Salatiga
                                                                            </option>
                                                                            <option
                                                                                value="Kota Semarang"{{ old('tujuan', $kendaraan->tujuan) == 'Kota Semarang' ? 'selected' : null }}>
                                                                                Kota Semarang
                                                                            </option>
                                                                            <option
                                                                                value="Kota Surakarta"{{ old('tujuan', $kendaraan->tujuan) == 'Kota Surakarta' ? 'selected' : null }}>
                                                                                Kota Surakarta
                                                                            </option>
                                                                            <option
                                                                                value="Kota Tegal"{{ old('tujuan', $kendaraan->tujuan) == 'Kota Tegal' ? 'selected' : null }}>
                                                                                Kota Tegal</option>
                                                                        </optgroup>
                                                                        <optgroup label="Jawa Barat">
                                                                            <option
                                                                                value="Kabupaten Bandung"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Bandung' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Bandung
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Bandung Barat"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Bandung Barat' ? 'selected' : null }}>
                                                                                Kabupaten Bandung
                                                                                Barat</option>
                                                                            <option
                                                                                value="Kabupaten Bekasi"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Bekasi' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Bekasi
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Bogor"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Bogor' ? 'selected' : null }}>
                                                                                Kabupaten Bogor
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Ciamis"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Ciamis' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Ciamis
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Cianjur"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Cianjur' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Cianjur
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Cirebon"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Cirebon' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Cirebon
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Garut"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Garut' ? 'selected' : null }}>
                                                                                Kabupaten Garut
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Indramayu"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Indramayu' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Indramayu
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Karawang"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Karawang' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Karawang
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Kuningan"{{ old('tujuan', $kendaraan->tujuan) == 'Tunggu Muat' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Kuningan
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Majalengka"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Majalengka' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Majalengka
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Pangandaran"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Pangandaran' ? 'selected' : null }}>
                                                                                Kabupaten Pangandaran</option>
                                                                            <option
                                                                                value="Kabupaten Purwakarta"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Purwakarta' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Purwakarta
                                                                            </option>
                                                                            <option value="Kabupaten Subang">
                                                                                {{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Subang' ? 'selected' : null }}Kabupaten
                                                                                Subang
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Sukabumi"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Sukabumi' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Sukabumi
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Sumedang"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Sumedang' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Sumedang
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Tasikmalaya"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Tasikmalaya' ? 'selected' : null }}>
                                                                                Kabupaten Tasikmalaya</option>

                                                                            <option
                                                                                value="Kota Bandung"{{ old('tujuan', $kendaraan->tujuan) == 'Kota Bandung' ? 'selected' : null }}>
                                                                                Kota Bandung
                                                                            </option>
                                                                            <option
                                                                                value="Kota Banjar"{{ old('tujuan', $kendaraan->tujuan) == 'Kota Banjar' ? 'selected' : null }}>
                                                                                Kota Banjar
                                                                            </option>
                                                                            <option
                                                                                value="Kota Bekasi"{{ old('tujuan', $kendaraan->tujuan) == 'Kota Bekasi' ? 'selected' : null }}>
                                                                                Kota Bekasi
                                                                            </option>
                                                                            <option
                                                                                value="Kota Bogor"{{ old('tujuan', $kendaraan->tujuan) == 'Kota Bogor' ? 'selected' : null }}>
                                                                                Kota Bogor</option>
                                                                            <option
                                                                                value="Kota Cimahi"{{ old('tujuan', $kendaraan->tujuan) == 'Kota Cimahi' ? 'selected' : null }}>
                                                                                Kota Cimahi
                                                                            </option>
                                                                            <option
                                                                                value="Kota Cirebon"{{ old('tujuan', $kendaraan->tujuan) == 'Kota Cirebon' ? 'selected' : null }}>
                                                                                Kota Cirebon
                                                                            </option>
                                                                            <option
                                                                                value="Kota Depok"{{ old('tujuan', $kendaraan->tujuan) == 'Kota Depok' ? 'selected' : null }}>
                                                                                Kota Depok</option>
                                                                            <option
                                                                                value="Kota Sukabumi"{{ old('tujuan', $kendaraan->tujuan) == 'Kota Sukabumi' ? 'selected' : null }}>
                                                                                Kota Sukabumi
                                                                            </option>
                                                                            <option
                                                                                value="Kota Tasikmalaya"{{ old('tujuan', $kendaraan->tujuan) == 'Kota Tasikmalaya' ? 'selected' : null }}>
                                                                                Kota
                                                                                Tasikmalaya
                                                                            </option>
                                                                        </optgroup>
                                                                        <optgroup label="Yogyakarta">
                                                                            <option
                                                                                value="Kabupaten Bantul"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Bantul' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Bantul
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Gunungkidul"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Gunungkidul' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Gunungkidul</option>
                                                                            <option
                                                                                value="Kabupaten Kulon Progo"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Kulon Progo' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Kulon
                                                                                Progo</option>
                                                                            <option
                                                                                value="Kabupaten Sleman"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Sleman' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Sleman
                                                                            </option>

                                                                            <option
                                                                                value="Kota Yogyakarta"{{ old('tujuan', $kendaraan->tujuan) == 'Kota Yogyakarta' ? 'selected' : null }}>
                                                                                Kota Yogyakarta
                                                                            </option>
                                                                        </optgroup>
                                                                        <optgroup label="Banten">
                                                                            <option
                                                                                value="Kabupaten Lebak"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Lebak' ? 'selected' : null }}>
                                                                                Kabupaten Lebak
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Pandeglang"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Pandeglang' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Pandeglang
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Serang"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Serang' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Serang
                                                                            </option>
                                                                            <option
                                                                                value="Kabupaten Tangerang"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten Tangerang' ? 'selected' : null }}>
                                                                                Kabupaten
                                                                                Tangerang
                                                                            </option>
                                                                            <option
                                                                                value="Kota Cilegon"{{ old('tujuan', $kendaraan->tujuan) == 'Kota Cilegon' ? 'selected' : null }}>
                                                                                Kota Cilegon
                                                                            </option>
                                                                            <option
                                                                                value="Kota Serang"{{ old('tujuan', $kendaraan->tujuan) == 'Kota Serang' ? 'selected' : null }}>
                                                                                Kota Serang
                                                                            </option>
                                                                            <option
                                                                                value="Kota Tangerang"{{ old('tujuan', $kendaraan->tujuan) == 'Kota Tangerang' ? 'selected' : null }}>
                                                                                Kota Tangerang
                                                                            </option>
                                                                            <option
                                                                                value="Kota Tangerang Selatan"{{ old('tujuan', $kendaraan->tujuan) == 'Kota Tangerang Selatan' ? 'selected' : null }}>
                                                                                Kota Tangerang Selatan</option>
                                                                        </optgroup>
                                                                        <optgroup label="DKI Jakarta">
                                                                            <option
                                                                                value="Kabupaten  Kepulauan Seribu"{{ old('tujuan', $kendaraan->tujuan) == 'Kabupaten  Kepulauan Seribu' ? 'selected' : null }}>
                                                                                Kabupaten Kepulauan Seribu</option>
                                                                            <option
                                                                                value="Kota Jakarta Barat"{{ old('tujuan', $kendaraan->tujuan) == 'Kota Jakarta Barat' ? 'selected' : null }}>
                                                                                Kota Jakarta Barat</option>
                                                                            <option
                                                                                value="Kota Jakarta Pusat"{{ old('tujuan', $kendaraan->tujuan) == 'Kota Jakarta Pusat' ? 'selected' : null }}>
                                                                                Kota Jakarta Pusat</option>
                                                                            <option
                                                                                value="Kota Jakarta Selatan"{{ old('tujuan', $kendaraan->tujuan) == 'Kota Jakarta Selatan' ? 'selected' : null }}>
                                                                                Kota Jakarta Selatan</option>
                                                                            <option
                                                                                value="Kota Jakarta Timur"{{ old('tujuan', $kendaraan->tujuan) == 'Kota Jakarta Timur' ? 'selected' : null }}>
                                                                                Kota Jakarta Timur</option>
                                                                            <option
                                                                                value="Kota Jakarta Utara"{{ old('tujuan', $kendaraan->tujuan) == 'Kota Jakarta Utara' ? 'selected' : null }}>
                                                                                Kota Jakarta Utara</option>
                                                                        </optgroup>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label"
                                                                        for="status_perjalanan">Status
                                                                        Perjalanan</label>
                                                                    <select class="form-control" id="nama_bank"
                                                                        name="status_perjalanan">
                                                                        <option value="">- Pilih -</option>
                                                                        <option value="Tunggu Muat"
                                                                            {{ old('status_perjalanan', $kendaraan->status_perjalanan) == 'Tunggu Muat' ? 'selected' : null }}>
                                                                            Tunggu Muat</option>
                                                                        <option value="Loading Muat"
                                                                            {{ old('status_perjalanan', $kendaraan->status_perjalanan) == 'Loading Muat' ? 'selected' : null }}>
                                                                            Loading Muat</option>
                                                                        <option value="Perjalanan Isi"
                                                                            {{ old('status_perjalanan', $kendaraan->status_perjalanan) == 'Perjalanan Isi' ? 'selected' : null }}>
                                                                            Perjalanan Isi</option>
                                                                        <option value="Tunggu Bongkar"
                                                                            {{ old('status_perjalanan', $kendaraan->status_perjalanan) == 'Tunggu Bongkar' ? 'selected' : null }}>
                                                                            Tunggu Bongkar</option>
                                                                        <option value="Loading Bongkar"
                                                                            {{ old('status_perjalanan', $kendaraan->status_perjalanan) == 'Loading Bongkar' ? 'selected' : null }}>
                                                                            Loading Bongkar</option>
                                                                        <option value="Perjalanan Kosong"
                                                                            {{ old('status_perjalanan', $kendaraan->status_perjalanan) == 'Perjalanan Kosong' ? 'selected' : null }}>
                                                                            Perjalanan Kosong</option>
                                                                        <option value="Perbaikan di jalan"
                                                                            {{ old('status_perjalanan', $kendaraan->status_perjalanan) == 'Perbaikan di jalan' ? 'selected' : null }}>
                                                                            Perbaikan di jalan</option>
                                                                        <option value="Perbaikan di garasi"
                                                                            {{ old('status_perjalanan', $kendaraan->status_perjalanan) == 'Perbaikan di garasi' ? 'selected' : null }}>
                                                                            Perbaikan di garasi</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                        </div>
                                                </div>
                                                <div class="card-footer text-right">
                                                    <button type="submit" class="btn btn-primary">Konfirmasi</button>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        </div>
    </section>

    <script>
        var form = document.getElementById('form-action');

        function cari() {
            form.action = "{{ url('admin/status_perjalanan') }}";
            form.submit();
        }

        $(document).ready(function() {
            $('#modal-kota').on('show.bs.modal', function(e) {
                $('#modal-posting-{{ $kendaraan->id }}').modal('hide');
            });
        });
    </script>
@endsection
