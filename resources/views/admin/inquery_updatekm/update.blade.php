@extends('layouts.app')

@section('title', 'Update Km')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    {{-- <h1 class="m-0">Kilo Meter</h1> --}}
                    {{-- <a href="{{ url('admin/km') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i>
                    </a> --}}
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/km') }}">Kilo Meter</a></li>
                        <li class="breadcrumb-item active">Update</li>
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
                    <h3 class="card-title">Update Kilo Meter</h3>
                </div>
                <!-- /.card-header -->
                <form action="{{ url('admin/inquery_updatekm/' . $kendaraan->id) }}" method="POST"
                    enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    @method('put')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nopol">No Kabin</label>
                            <input type="text" class="form-control" id="id" name="" readonly
                                placeholder="Masukan id" value="{{ old('no_kabin', $kendaraan->kendaraan->no_kabin) }}">
                        </div>
                        <div class="form-group">
                            <label for="nopol">No. Registrasi Kendaraan</label>
                            <input type="text" class="form-control" id="no_pol" name="no_pol" readonly
                                placeholder="Masukan no registrasi kendaraan"
                                value="{{ old('no_pol', $kendaraan->kendaraan->no_pol) }}">
                        </div>
                        <div class="form-group">
                            <label for="jenis_kendaraan">Jenis Kendaraan</label>
                            <input type="text" class="form-control" id="jenis_kendaraan" name="jenis_kendaraan" readonly
                                placeholder="Masukan jenis kendaraan"
                                value="{{ old('jenis_kendaraan', $kendaraan->kendaraan->jenis_kendaraan->nama_jenis_kendaraan) }}">
                        </div>
                        <div class="form-group">
                            <label for="km">KM Awal</label>
                            <input type="text" class="form-control" id="km_awal" readonly placeholder="0"
                                value="{{ old('km', $kendaraan->km_update) }}">
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="km">KM Akhir</label>
                            <input type="text" class="form-control" id="km" name="km"
                                placeholder="Masukan km akhir" value="">
                            </select>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary" data-toggle="modal"
                            data-target="#modal-simpan">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

@endsection
