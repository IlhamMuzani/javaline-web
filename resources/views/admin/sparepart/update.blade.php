@extends('layouts.app')

@section('title', 'Perbarui Part')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Part</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/sparepart') }}">Part</a></li>
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
                        <i class="icon fas fa-ban"></i> Error!
                    </h5>
                    @foreach (session('error') as $error)
                        - {{ $error }} <br>
                    @endforeach
                </div>
            @endif

            <form action="{{ url('admin/sparepart/' . $part->id) }}" method="POST" enctype="multipart/form-data"
                autocomplete="off">
                @csrf
                @method('put')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Perbarui Part</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="form-group">
                                <label class="form-label" for="kategori">Kategori</label>
                                <select class="form-control" id="kategori" name="kategori">
                                    <option value="">- Pilih -</option>
                                    <option value="oli"
                                        {{ old('kategori', $part->kategori) == 'oli' ? 'selected' : null }}>
                                        oli</option>
                                    <option value="body"
                                        {{ old('kategori', $part->kategori) == 'body' ? 'selected' : null }}>
                                        body</option>
                                    <option value="mesin"
                                        {{ old('kategori', $part->kategori) == 'mesin' ? 'selected' : null }}>
                                        mesin</option>
                                    <option value="sasis"
                                        {{ old('kategori', $part->kategori) == 'sasis' ? 'selected' : null }}>
                                        sasis</option>
                                    <option value="peralatan"
                                        {{ old('kategori', $part->kategori) == 'peralatan' ? 'selected' : null }}>
                                        peralatan</option>
                                </select>
                            </div>
                            <label for="nama">Nama Barang</label>
                            <input type="text" class="form-control" id="nama_barang" name="nama_barang"
                                placeholder="Masukan barang" value="{{ old('nama_barang', $part->nama_barang) }}">
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Masukan keterangan">{{ old('keterangan', $part->keterangan) }}</textarea>
                        </div>
                        {{-- <div class="form-group">
                            <label for="nama">Harga</label>
                            <input type="number" class="form-control" id="harga" name="harga"
                                placeholder="Masukan harga" value="{{ old('harga', $part->harga) }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">Stok</label>
                            <input type="number" class="form-control" id="jumlah" name="jumlah" placeholder="jumlah"
                                value="{{ old('jumlah', $part->jumlah) }}">
                        </div> --}}
                        <div class="form-group">
                            <label class="form-label" for="satuan">Satuan</label>
                            <select class="form-control" id="satuan" name="satuan">
                                <option value="">- Pilih -</option>
                                <option value="pcs" {{ old('satuan', $part->satuan) == 'pcs' ? 'selected' : null }}>
                                    pcs</option>
                                <option value="ltr" {{ old('satuan', $part->satuan) == 'ltr' ? 'selected' : null }}>
                                    ltr</option>
                                <option value="btl" {{ old('satuan', $part->satuan) == 'btl' ? 'selected' : null }}>
                                    btl</option>
                                <option value="klng" {{ old('satuan', $part->satuan) == 'klng' ? 'selected' : null }}>
                                    klng</option>
                                <option value="gln" {{ old('satuan', $part->satuan) == 'gln' ? 'selected' : null }}>
                                    gln</option>
                                <option value="pack" {{ old('satuan', $part->satuan) == 'pack' ? 'selected' : null }}>
                                    pack</option>
                                <option value="tgg" {{ old('satuan', $part->satuan) == 'tgg' ? 'selected' : null }}>
                                    tgg</option>
                                <option value="set" {{ old('satuan', $part->satuan) == 'set' ? 'selected' : null }}>
                                    set</option>
                                <option value="dus" {{ old('satuan', $part->satuan) == 'dus' ? 'selected' : null }}>
                                    dus</option>
                                <option value="role" {{ old('satuan', $part->satuan) == 'role' ? 'selected' : null }}>
                                    role</option>
                                <option value="pail" {{ old('satuan', $part->satuan) == 'pail' ? 'selected' : null }}>
                                    pail</option>
                                <option value="kg" {{ old('satuan', $part->satuan) == 'kg' ? 'selected' : null }}>
                                    kg</option>
                                <option value="pasang" {{ old('satuan', $part->satuan) == 'pasang' ? 'selected' : null }}>
                                    pasang</option>
                                <option value="set" {{ old('satuan', $part->satuan) == 'set' ? 'selected' : null }}>
                                    set</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="reset" class="btn btn-secondary">Reset</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>

            </form>
        </div>
        </div>
    </section>

@endsection
