@extends('layouts.app')

@section('title', 'Update Alamat Bongkar')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Alamat Muat</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/alamat_bongkar') }}">Biaya Tambahan</a></li>
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
            <form action="{{ url('admin/alamat_bongkar/' . $alamatbongkars->id) }}" method="POST"
                enctype="multipart/form-data" autocomplete="off">
                @csrf
                @method('put')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Update Alamat Bongkar</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group" style="flex: 8;">
                                    <label for="pelanggan_id">Nama Pelanggan</label>
                                    <select class="select2bs4 select22-hidden-accessible" name="pelanggan_id"
                                        data-placeholder="Cari Pelanggan.." style="width: 100%;" data-select22-id="23"
                                        tabindex="-1" aria-hidden="true" id="pelanggan_id">
                                        <option value="">- Pilih -</option>
                                        @foreach ($pelanggans as $pelanggan)
                                            <option value="{{ $pelanggan->id }}"
                                                {{ old('pelanggan_id', $alamatbongkars->pelanggan_id) == $pelanggan->id ? 'selected' : '' }}>
                                                {{ $pelanggan->nama_pell }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group" style="flex: 8;">
                                    <label for="vendor_id">Nama Vendor</label>
                                    <select class="select2bs4 select22-hidden-accessible" name="vendor_id"
                                        data-placeholder="Cari Vendor.." style="width: 100%;" data-select22-id="23"
                                        tabindex="-1" aria-hidden="true" id="vendor_id">
                                        <option value="">- Pilih -</option>
                                        @foreach ($vendors as $vendor)
                                            <option value="{{ $vendor->id }}"
                                                {{ old('vendor_id', $alamatbongkars->vendor_id) == $vendor->id ? 'selected' : '' }}>
                                                {{ $vendor->nama_vendor }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nama_biaya">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat"
                                placeholder="masukkan alamat"
                                value="{{ old('alamat', $alamatbongkars->alamat) }}">
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
