@extends('layouts.app')

@section('title', 'Perbarui Jenis Kendaraan')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Jenis Kendaraan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/jenis_kendaraan') }}">Jenis Kendaraan</a></li>
                        <li class="breadcrumb-item active">Perbarui</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
        <div class="container-fluid">
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-ban"></i> Gagal!
                    </h5>
                    @foreach (session('error') as $error)
                        - {{ $error }} <br>
                    @endforeach
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Perbarui Jenis Kendaraan</h3>
                </div>
                <!-- /.card-header -->
                <form action="{{ url('admin/jenis_kendaraan/' . $jenis_kendaraan->id) }}" method="POST" enctype="multipart/form-data"
                    autocomplete="off">
                    @csrf
                    @method('put')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama_jenis_kendaraan">Nama Jenis Kendaraan</label>
                            <input type="text" class="form-control" id="nama_jenis_kendaraan" name="nama_jenis_kendaraan"
                                placeholder="Masukan nama jenis kendaraan" value="{{ old('nama_jenis_kendaraan', $jenis_kendaraan->nama_jenis_kendaraan) }}">
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="panjang">Panjang</label>
                                    <input type="text" class="form-control" id="panjang" name="panjang"
                                        placeholder="Masukan panjang" value="{{ old('panjang', $jenis_kendaraan->panjang) }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="lebar">Lebar</label>
                                    <input type="text" class="form-control" id="lebar" name="lebar"
                                        placeholder="Masukan lebar" value="{{ old('lebar', $jenis_kendaraan->lebar) }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="tinggi">Tinggi</label>
                                    <input type="text" class="form-control" id="tinggi" name="tinggi"
                                        placeholder="Masukan tinggi" value="{{ old('tinggi', $jenis_kendaraan->tinggi) }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="total_ban">Total Ban</label>
                                    <input type="text" class="form-control" id="total_ban" name="total_ban"
                                        placeholder="Masukan total ban" value="{{ old('total_ban', $jenis_kendaraan->total_ban) }}">
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
        </div>
    </section>
@endsection
