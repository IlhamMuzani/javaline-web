@extends('layouts.app')

@section('title', 'Tambah Rute Perjalanan')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Rute Perjalanan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/rute_perjalanan') }}">Rute Perjalanan</a></li>
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
                        <i class="icon fas fa-ban"></i> Error!
                    </h5>
                    @foreach (session('error') as $error)
                        - {{ $error }} <br>
                    @endforeach
                </div>
            @endif
            <form action="{{ url('admin/rute_perjalanan') }}" method="POST" enctype="multipart/form-data"
                autocomplete="off">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Rute Perjalanan</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label" for="provinsi">Provinsi</label>
                            <select class="select2bs4 select2-hidden-accessible" name="provinsi"
                                data-placeholder="Cari Provinsi.." style="width: 100%;" data-select2-id="23" tabindex="-1"
                                aria-hidden="true" id="provinsi">
                                <option value="">- Pilih -</option>
                                @foreach ($provinces as $province)
                                    <option value="{{ $province }}"
                                        {{ old('provinsi') == $province ? 'selected' : null }}>
                                        {{ $province }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nama_rute">Rute Perjalanan</label>
                            <input type="text" class="form-control" id="nama_rute" name="nama_rute"
                                placeholder="masukkan tujuan" value="{{ old('nama_rute') }}">
                        </div>
                    </div>

                    {{-- <div class="card-footer text-right">
                        <button type="reset" class="btn btn-secondary">Reset</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div> --}}
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Biaya Perjalanan</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group">
                            <label for="golongan2">Golongan</label>
                            <select class="form-control" id="kategori" name="kategori">
                                <option value="">- Pilih Golongan -</option>
                                <option value="Golongan 1" {{ old('kategori') == 'Golongan 1' ? 'selected' : null }}>
                                    GOLONGAN 1</option>
                                <option value="Golongan 2" {{ old('kategori') == 'Golongan 2' ? 'selected' : null }}>
                                    GOLONGAN 2</option>
                                <option value="Golongan 3" {{ old('kategori') == 'Golongan 3' ? 'selected' : null }}>
                                    GOLONGAN 3</option>
                                <option value="Golongan 4" {{ old('kategori') == 'Golongan 4' ? 'selected' : null }}>
                                    GOLONGAN 4</option>
                                <option value="Golongan 5" {{ old('kategori') == 'Golongan 5' ? 'selected' : null }}>
                                    GOLONGAN 5</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="harga">Biaya</label>
                            <input type="number" class="form-control" id="harga" name="harga"
                                placeholder="masukkan biaya" value="{{ old('harga') }}">
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
