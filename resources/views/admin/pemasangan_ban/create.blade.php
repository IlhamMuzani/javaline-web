@extends('layouts.app')

@section('title', 'Tambah Pemasangan')

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
                        <li class="breadcrumb-item"><a href="{{ url('admin/pemasangan_ban') }}">Pemasangan Ban</a></li>
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
            <form action="{{ url('admin/pemasangan_ban/' . $kendaraan->id) }}" method="POST" enctype="multipart/form-data"
                autocomplete="off">
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
                                                {{-- <label>1A</label> --}}
                                                <div class="" data-toggle="modal"
                                                    data-target="#modal-exle_1A-{{ $kendaraan->id }}">
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/karyawan/1A.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>

                                            <div class="form-group mt-3" style="text-align: center;">
                                                <label>Axle 1</label>
                                                <div class="">
                                                    <img class="mt-1"
                                                        src="{{ asset('storage/uploads/karyawan/axle.png') }}"
                                                        alt="AdminLTELogo" height="20" width="200">
                                                </div>
                                            </div>
                                            <div class="form-group mt-2" style="text-align: center;">
                                                {{-- <label>1B</label> --}}
                                                <div class=""data-toggle="modal"
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
                                            <div class="form-group mt-2" style="text-align: center;">
                                                {{-- <label>2A</label> --}}
                                                <div class="" data-toggle="modal"
                                                    data-target="#modal-exle_2A-{{ $kendaraan->id }}">
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/karyawan/2A.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>
                                            <div class="form-group mt-2 ml-1" style="text-align: center;">
                                                {{-- <label>2B</label> --}}
                                                <div class="" data-toggle="modal"
                                                    data-target="#modal-exle_2B-{{ $kendaraan->id }}">
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/karyawan/2B.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>
                                            <div class="form-group mt-3" style="text-align: center;">
                                                <label>Axle 2</label>
                                                <div class="">
                                                    <img class="mt-1"
                                                        src="{{ asset('storage/uploads/karyawan/axle.png') }}"
                                                        alt="AdminLTELogo" height="20" width="110">
                                                </div>
                                            </div>
                                            <div class="form-group mt-2" style="text-align: center;">
                                                {{-- <label>2C</label> --}}
                                                <div class="" data-toggle="modal"
                                                    data-target="#modal-exle_2C-{{ $kendaraan->id }}">
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/karyawan/2C.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>
                                            <div class="form-group mt-2 ml-1" style="text-align: center;">
                                                {{-- <label>2D</label> --}}
                                                <div class="" data-toggle="modal"
                                                    data-target="#modal-exle_2D-{{ $kendaraan->id }}">
                                                    <img class=""
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
                                            <div class="form-group mt-2" style="text-align: center;">
                                                {{-- <label>2A</label> --}}
                                                <div class="" data-toggle="modal"
                                                    data-target="#modal-exle_3A-{{ $kendaraan->id }}">
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/karyawan/3A.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>
                                            <div class="form-group mt-2 ml-1" style="text-align: center;">
                                                {{-- <label>2B</label> --}}
                                                <div class="" data-toggle="modal"
                                                    data-target="#modal-exle_3B-{{ $kendaraan->id }}">
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/karyawan/3B.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>
                                            <div class="form-group mt-3" style="text-align: center;">
                                                <label>Axle 3</label>
                                                <div class="">
                                                    <img class="mt-1"
                                                        src="{{ asset('storage/uploads/karyawan/axle.png') }}"
                                                        alt="AdminLTELogo" height="20" width="110">
                                                </div>
                                            </div>
                                            <div class="form-group mt-2" style="text-align: center;">
                                                {{-- <label>2C</label> --}}
                                                <div class="" data-toggle="modal"
                                                    data-target="#modal-exle_3C-{{ $kendaraan->id }}">
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/karyawan/3C.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>
                                            <div class="form-group mt-2 ml-1" style="text-align: center;">
                                                {{-- <label>2D</label> --}}
                                                <div class="" data-toggle="modal"
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
                                            <div class="form-group mt-2" style="text-align: center;">
                                                <div class="" data-toggle="modal"
                                                    data-target="#modal-exle_4A-{{ $kendaraan->id }}">
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/karyawan/4A.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>
                                            <div class="form-group mt-2 ml-1" style="text-align: center;">
                                                <div class="" data-toggle="modal"
                                                    data-target="#modal-exle_4B-{{ $kendaraan->id }}">
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/karyawan/4B.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>
                                            <div class="form-group mt-3" style="text-align: center;">
                                                <label>Axle 4</label>
                                                <div class="">
                                                    <img class="mt-1"
                                                        src="{{ asset('storage/uploads/karyawan/axle.png') }}"
                                                        alt="AdminLTELogo" height="20" width="110">
                                                </div>
                                            </div>
                                            <div class="form-group mt-2" style="text-align: center;">
                                                <div class="" data-toggle="modal"
                                                    data-target="#modal-exle_4C-{{ $kendaraan->id }}">
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/karyawan/4C.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>
                                            <div class="form-group mt-2 ml-1" style="text-align: center;">
                                                <div class="" data-toggle="modal"
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
                                            <div class="form-group mt-2" style="text-align: center;">
                                                <div class="" data-toggle="modal"
                                                    data-target="#modal-exle_5A-{{ $kendaraan->id }}">
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/karyawan/5A.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>
                                            <div class="form-group mt-2 ml-1" style="text-align: center;">
                                                <div class="" data-toggle="modal"
                                                    data-target="#modal-exle_5B-{{ $kendaraan->id }}">
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/karyawan/5B.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>
                                            <div class="form-group mt-3" style="text-align: center;">
                                                <label>Axle 5</label>
                                                <div class="">
                                                    <img class="mt-1"
                                                        src="{{ asset('storage/uploads/karyawan/axle.png') }}"
                                                        alt="AdminLTELogo" height="20" width="110">
                                                </div>
                                            </div>
                                            <div class="form-group mt-2" style="text-align: center;">
                                                <div class="" data-toggle="modal"
                                                    data-target="#modal-exle_5C-{{ $kendaraan->id }}">
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/karyawan/5C.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>
                                            <div class="form-group mt-2 ml-1" style="text-align: center;">
                                                <div class="" data-toggle="modal"
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
                                            <div class="form-group mt-2" style="text-align: center;">
                                                <div class="" data-toggle="modal"
                                                    data-target="#modal-exle_6A-{{ $kendaraan->id }}">
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/karyawan/6A.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>
                                            <div class="form-group mt-2 ml-1" style="text-align: center;">
                                                <div class="" data-toggle="modal"
                                                    data-target="#modal-exle_6B-{{ $kendaraan->id }}">
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/karyawan/6B.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>
                                            <div class="form-group mt-3" style="text-align: center;">
                                                <label>Axle 6</label>
                                                <div class="">
                                                    <img class="mt-1"
                                                        src="{{ asset('storage/uploads/karyawan/axle.png') }}"
                                                        alt="AdminLTELogo" height="20" width="110">
                                                </div>
                                            </div>
                                            <div class="form-group mt-2" style="text-align: center;">
                                                <div class="" data-toggle="modal"
                                                    data-target="#modal-exle_6C-{{ $kendaraan->id }}">
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/karyawan/6C.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>
                                            <div class="form-group mt-2 ml-1" style="text-align: center;">
                                                <div class="" data-toggle="modal"
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
            {{-- <div class="card-body">
                <div class="col"> --}}
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
                        <tr class="text-center">
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
                                            <form action="{{ url('admin/pemasangan_ban/' . $ban->id) }}" method="POST"
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

        </div>
        {{-- </div> --}}
        </div>
        {{-- modal exle 1A  --}}
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
                            <form action="{{ url('admin/pemasangan1/' . $kendaraan->id) }}" method="POST"
                                enctype="multipart/form-data" autocomplete="off" id="exleForm">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group" hidden>
                                        <label for="posisi_ban">Kendaraan Id</label>
                                        <input type="text" class="form-control" readonly name="kendaraan_id"
                                            placeholder="Masukan km pemasangan" value="{{ $kendaraan->id }}">
                                    </div>
                                    <div class="form-group" hidden>
                                        <label for="posisi_ban">Posisi Ban</label>
                                        <input type="text" class="form-control" readonly name="posisi_1a"
                                            placeholder="Masukan km pemasangan" value="1A">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="exel_1a">No. Seri Ban</label>

                                        {{-- <select class="form-control" id="exel_1b" name="exel_1a">
                                            <option value="">- Pilih -</option>
                                            @foreach ($bans as $ban)
                                                <option value="{{ $ban->id }}"
                                                    {{ old('ban_id') == $ban->id ? 'selected' : '' }}>
                                                    {{ $ban->no_seri }}
                                                </option>
                                            @endforeach
                                        </select> --}}

                                        <select class="select2bs4 select2-hidden-accessible" name="exel_1a"
                                            data-placeholder="Cari Ban.." style="width: 100%;" data-select2-id="23"
                                            tabindex="-1" aria-hidden="true" id="exel_1b">
                                            <option value="">- Pilih -</option>
                                            @foreach ($bans as $ban)
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
                                            value="{{ old('km_pemasangan') }}">
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button type="reset" class="btn btn-secondary">Reset</button>
                                    <button type="button" class="btn btn-primary" id="submitBtn">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- modal exle 1B  --}}
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
                            <form action="{{ url('admin/pemasangan1b/' . $kendaraan->id) }}" method="POST"
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
                                        <label for="posisi_ban">Posisi Ban</label>
                                        <input type="text" class="form-control" readonly name="posisi_1b"
                                            placeholder="Masukan km pemasangan" value="1B">
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label" for="exel_1b">No. Seri Ban</label>
                                        <select class="select2bs4 select2-hidden-accessible" name="exel_1b"
                                            data-placeholder="Cari Ban.." style="width: 100%;" tabindex="-1"
                                            aria-hidden="true" id="exel_1b">
                                            <option value="">- Pilih -</option>
                                            @foreach ($bans as $ban)
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

        {{-- modal exle 2A  --}}
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
                            <form action="{{ url('admin/pemasangan2a/' . $kendaraan->id) }}" method="POST"
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
                                        <label for="posisi_ban">Posisi Ban</label>
                                        <input type="text" class="form-control" readonly name="posisi_2a"
                                            placeholder="Masukan km pemasangan" value="2A">
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label" for="exel_1a">No. Seri Ban</label>
                                        <select class="select2bs4 select2-hidden-accessible" name="exel_2a"
                                            data-placeholder="Cari Ban.." style="width: 100%;" tabindex="-1"
                                            aria-hidden="true" id="exel_2a">
                                            <option value="">- Pilih -</option>
                                            @foreach ($bans as $ban)
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

        {{-- modal exle 2B  --}}
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
                            <form action="{{ url('admin/pemasangan2b/' . $kendaraan->id) }}" method="POST"
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

                                    <div class="form-group">
                                        <label class="form-label" for="exel_2b">No. Seri Ban</label>
                                        <select class="select2bs4 select2-hidden-accessible" name="exel_2b"
                                            data-placeholder="Cari Ban.." style="width: 100%;" tabindex="-1"
                                            aria-hidden="true" id="exel_2b">
                                            <option value="">- Pilih -</option>
                                            @foreach ($bans as $ban)
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

        {{-- modal exle 2C  --}}
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
                            <form action="{{ url('admin/pemasangan2c/' . $kendaraan->id) }}" method="POST"
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
                                        <label for="posisi_ban">Posisi Ban</label>
                                        <input type="text" class="form-control" readonly name="posisi_2c"
                                            placeholder="Masukan km pemasangan" value="2C">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="exel_1a">No. Seri Ban</label>
                                        <select class="select2bs4 select2-hidden-accessible" name="exel_2c"
                                            data-placeholder="Cari Ban.." style="width: 100%;" tabindex="-1"
                                            aria-hidden="true" id="exel_2c">
                                            <option value="">- Pilih -</option>
                                            @foreach ($bans as $ban)
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

        {{-- modal exle 2D  --}}
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
                            <form action="{{ url('admin/pemasangan2d/' . $kendaraan->id) }}" method="POST"
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
                                        <label for="posisi_ban">Posisi Ban</label>
                                        <input type="text" class="form-control" readonly name="posisi_2d"
                                            placeholder="Masukan km pemasangan" value="2D">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="exel_1a">No. Seri Ban</label>
                                        <select class="select2bs4 select2-hidden-accessible" name="exel_2d"
                                            data-placeholder="Cari Ban.." style="width: 100%;" tabindex="-1"
                                            aria-hidden="true" id="exel_2d">
                                            <option value="">- Pilih -</option>
                                            @foreach ($bans as $ban)
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

        {{-- modal exle 3A  --}}
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
                            <form action="{{ url('admin/pemasangan3a/' . $kendaraan->id) }}" method="POST"
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
                                        <label for="posisi_ban">Posisi Ban</label>
                                        <input type="text" class="form-control" readonly name="posisi_3a"
                                            placeholder="Masukan km pemasangan" value="3A">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="exel_1a">No. Seri Ban</label>
                                        <select class="select2bs4 select2-hidden-accessible" name="exel_3a"
                                            data-placeholder="Cari Ban.." style="width: 100%;" tabindex="-1"
                                            aria-hidden="true" id="exel_3a">
                                            <option value="">- Pilih -</option>
                                            @foreach ($bans as $ban)
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

        {{-- modal exle 3B  --}}
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
                            <form action="{{ url('admin/pemasangan3b/' . $kendaraan->id) }}" method="POST"
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
                                        <label for="posisi_ban">Posisi Ban</label>
                                        <input type="text" class="form-control" readonly name="posisi_3b"
                                            placeholder="Masukan km pemasangan" value="3B">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="exel_1a">No. Seri Ban</label>
                                        <select class="select2bs4 select2-hidden-accessible" name="exel_3b"
                                            data-placeholder="Cari Ban.." style="width: 100%;" tabindex="-1"
                                            aria-hidden="true" id="exel_3b">
                                            <option value="">- Pilih -</option>
                                            @foreach ($bans as $ban)
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

        {{-- modal exle 3C  --}}
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
                            <form action="{{ url('admin/pemasangan3c/' . $kendaraan->id) }}" method="POST"
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
                                        <label for="posisi_ban">Posisi Ban</label>
                                        <input type="text" class="form-control" readonly name="posisi_3c"
                                            placeholder="Masukan km pemasangan" value="3C">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="exel_1a">No. Seri Ban</label>
                                        <select class="select2bs4 select2-hidden-accessible" name="exel_3c"
                                            data-placeholder="Cari Ban.." style="width: 100%;" tabindex="-1"
                                            aria-hidden="true" id="exel_3c">
                                            <option value="">- Pilih -</option>
                                            @foreach ($bans as $ban)
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

        {{-- modal exle 3D  --}}
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
                            <form action="{{ url('admin/pemasangan3d/' . $kendaraan->id) }}" method="POST"
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
                                        <label for="posisi_ban">Posisi Ban</label>
                                        <input type="text" class="form-control" readonly name="posisi_3d"
                                            placeholder="Masukan km pemasangan" value="3D">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="exel_1a">No. Seri Ban</label>
                                        <select class="select2bs4 select2-hidden-accessible" name="exel_3d"
                                            data-placeholder="Cari Ban.." style="width: 100%;" tabindex="-1"
                                            aria-hidden="true" id="exel_3d">
                                            <option value="">- Pilih -</option>
                                            @foreach ($bans as $ban)
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

        {{-- modal exle 4A  --}}
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
                            <form action="{{ url('admin/pemasangan4a/' . $kendaraan->id) }}" method="POST"
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
                                        <label for="posisi_ban">Posisi Ban</label>
                                        <input type="text" class="form-control" readonly name="posisi_4a"
                                            placeholder="Masukan km pemasangan" value="4A">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="exel_1a">No. Seri Ban</label>
                                        <select class="select2bs4 select2-hidden-accessible" name="exel_4a"
                                            data-placeholder="Cari Ban.." style="width: 100%;" tabindex="-1"
                                            aria-hidden="true" id="exel_4a">
                                            <option value="">- Pilih -</option>
                                            @foreach ($bans as $ban)
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

        {{-- modal exle 4B  --}}
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
                            <form action="{{ url('admin/pemasangan4b/' . $kendaraan->id) }}" method="POST"
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
                                        <label for="posisi_ban">Posisi Ban</label>
                                        <input type="text" class="form-control" readonly name="posisi_4b"
                                            placeholder="Masukan km pemasangan" value="4B">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="exel_1a">No. Seri Ban</label>
                                        <select class="select2bs4 select2-hidden-accessible" name="exel_4b"
                                            data-placeholder="Cari Ban.." style="width: 100%;" tabindex="-1"
                                            aria-hidden="true" id="exel_4b">
                                            <option value="">- Pilih -</option>
                                            @foreach ($bans as $ban)
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

        {{-- modal exle 4C  --}}
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
                            <form action="{{ url('admin/pemasangan4c/' . $kendaraan->id) }}" method="POST"
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
                                        <label for="posisi_ban">Posisi Ban</label>
                                        <input type="text" class="form-control" readonly name="posisi_4c"
                                            placeholder="Masukan km pemasangan" value="4C">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="exel_1a">No. Seri Ban</label>
                                        <select class="select2bs4 select2-hidden-accessible" name="exel_4c"
                                            data-placeholder="Cari Ban.." style="width: 100%;" tabindex="-1"
                                            aria-hidden="true" id="exel_4c">
                                            <option value="">- Pilih -</option>
                                            @foreach ($bans as $ban)
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

        {{-- modal exle 4D  --}}
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
                            <form action="{{ url('admin/pemasangan4d/' . $kendaraan->id) }}" method="POST"
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
                                        <label for="posisi_ban">Posisi Ban</label>
                                        <input type="text" class="form-control" readonly name="posisi_4d"
                                            placeholder="Masukan km pemasangan" value="4D">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="exel_1a">No. Seri Ban</label>
                                        <select class="select2bs4 select2-hidden-accessible" name="exel_4d"
                                            data-placeholder="Cari Ban.." style="width: 100%;" tabindex="-1"
                                            aria-hidden="true" id="exel_4d">
                                            <option value="">- Pilih -</option>
                                            @foreach ($bans as $ban)
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

        {{-- modal exle 5A  --}}
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
                            <form action="{{ url('admin/pemasangan5a/' . $kendaraan->id) }}" method="POST"
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
                                        <label for="posisi_ban">Posisi Ban</label>
                                        <input type="text" class="form-control" readonly name="posisi_5a"
                                            placeholder="Masukan km pemasangan" value="5A">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="exel_1a">No. Seri Ban</label>
                                        <select class="select2bs4 select2-hidden-accessible" name="exel_5a"
                                            data-placeholder="Cari Ban.." style="width: 100%;" tabindex="-1"
                                            aria-hidden="true" id="exel_5a">
                                            <option value="">- Pilih -</option>
                                            @foreach ($bans as $ban)
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

        {{-- modal exle 5B  --}}
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
                            <form action="{{ url('admin/pemasangan5b/' . $kendaraan->id) }}" method="POST"
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
                                        <label for="posisi_ban">Posisi Ban</label>
                                        <input type="text" class="form-control" readonly name="posisi_5b"
                                            placeholder="Masukan km pemasangan" value="5B">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="exel_1a">No. Seri Ban</label>
                                        <select class="select2bs4 select2-hidden-accessible" name="exel_5b"
                                            data-placeholder="Cari Ban.." style="width: 100%;" tabindex="-1"
                                            aria-hidden="true" id="exel_5b">
                                            <option value="">- Pilih -</option>
                                            @foreach ($bans as $ban)
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

        {{-- modal exle 5C  --}}
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
                            <form action="{{ url('admin/pemasangan5c/' . $kendaraan->id) }}" method="POST"
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
                                        <label for="posisi_ban">Posisi Ban</label>
                                        <input type="text" class="form-control" readonly name="posisi_5c"
                                            placeholder="Masukan km pemasangan" value="5C">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="exel_1a">No. Seri Ban</label>
                                        <select class="select2bs4 select2-hidden-accessible" name="exel_5c"
                                            data-placeholder="Cari Ban.." style="width: 100%;" tabindex="-1"
                                            aria-hidden="true" id="exel_5c">
                                            <option value="">- Pilih -</option>
                                            @foreach ($bans as $ban)
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

        {{-- modal exle 5D  --}}
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
                            <form action="{{ url('admin/pemasangan5d/' . $kendaraan->id) }}" method="POST"
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
                                        <label for="posisi_ban">Posisi Ban</label>
                                        <input type="text" class="form-control" readonly name="posisi_5d"
                                            placeholder="Masukan km pemasangan" value="5D">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="exel_1a">No. Seri Ban</label>
                                        <select class="select2bs4 select2-hidden-accessible" name="exel_5d"
                                            data-placeholder="Cari Ban.." style="width: 100%;" tabindex="-1"
                                            aria-hidden="true" id="exel_5d">
                                            <option value="">- Pilih -</option>
                                            @foreach ($bans as $ban)
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

        {{-- modal exle 6A  --}}
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
                            <form action="{{ url('admin/pemasangan6a/' . $kendaraan->id) }}" method="POST"
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
                                        <label for="posisi_ban">Posisi Ban</label>
                                        <input type="text" class="form-control" readonly name="posisi_6a"
                                            placeholder="Masukan km pemasangan" value="6A">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="exel_1a">No. Seri Ban</label>
                                        <select class="select2bs4 select2-hidden-accessible" name="exel_6a"
                                            data-placeholder="Cari Ban.." style="width: 100%;" tabindex="-1"
                                            aria-hidden="true" id="exel_6a">
                                            <option value="">- Pilih -</option>
                                            @foreach ($bans as $ban)
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

        {{-- modal exle 6B  --}}
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
                            <form action="{{ url('admin/pemasangan6b/' . $kendaraan->id) }}" method="POST"
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
                                        <label for="posisi_ban">Posisi Ban</label>
                                        <input type="text" class="form-control" readonly name="posisi_6b"
                                            placeholder="Masukan km pemasangan" value="6B">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="exel_1a">No. Seri Ban</label>
                                        <select class="select2bs4 select2-hidden-accessible" name="exel_6b"
                                            data-placeholder="Cari Ban.." style="width: 100%;" tabindex="-1"
                                            aria-hidden="true" id="exel_6b">
                                            <option value="">- Pilih -</option>
                                            @foreach ($bans as $ban)
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

        {{-- modal exle 6C  --}}
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
                            <form action="{{ url('admin/pemasangan6c/' . $kendaraan->id) }}" method="POST"
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
                                        <label for="posisi_ban">Posisi Ban</label>
                                        <input type="text" class="form-control" readonly name="posisi_6c"
                                            placeholder="Masukan km pemasangan" value="6C">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="exel_1a">No. Seri Ban</label>
                                        <select class="select2bs4 select2-hidden-accessible" name="exel_6c"
                                            data-placeholder="Cari Ban.." style="width: 100%;" tabindex="-1"
                                            aria-hidden="true" id="exel_6c">
                                            <option value="">- Pilih -</option>
                                            @foreach ($bans as $ban)
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

        {{-- modal exle 6D  --}}
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
                            <form action="{{ url('admin/pemasangan6d/' . $kendaraan->id) }}" method="POST"
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
                                        <label for="posisi_ban">Posisi Ban</label>
                                        <input type="text" class="form-control" readonly name="posisi_6d"
                                            placeholder="Masukan km pemasangan" value="6D">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="exel_1a">No. Seri Ban</label>
                                        <select class="select2bs4 select2-hidden-accessible" name="exel_6d"
                                            data-placeholder="Cari Ban.." style="width: 100%;" tabindex="-1"
                                            aria-hidden="true" id="exel_6d">
                                            <option value="">- Pilih -</option>
                                            @foreach ($bans as $ban)
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
