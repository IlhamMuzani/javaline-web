@extends('layouts.app')

@section('title', 'Perbarui Satuan')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Satuan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/satuan') }}">Satuan</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
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
            <form action="{{ url('admin/satuan/' . $satuans->id) }}" method="POST" enctype="multipart/form-data"
                autocomplete="off">
                @csrf
                @method('put')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Satuan</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group">
                            <label for="kode_satuan">Kode Satuan</label>
                            <input type="text" class="form-control" id="kode_satuan" name="kode_satuan"
                                placeholder="masukkan kode satuan" value="{{ old('kode_satuan', $satuans->kode_satuan) }}">
                        </div>
                        <div class="form-group">
                            <label for="nama_satuan">Nama Satuan</label>
                            <input type="text" class="form-control" id="nama_satuan" name="nama_satuan"
                                placeholder="masukkan nama biaya" value="{{ old('nama_satuan', $satuans->nama_satuan) }}">
                        </div>
                        <div class="form-group">
                            <label for="nominal">Harga Satuan</label>
                            <input type="number" class="form-control" id="nominal" name="nominal"
                                placeholder="masukkan biaya" value="{{ old('nominal', $satuans->nominal) }}">
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="reset" class="btn btn-secondary">Reset</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
