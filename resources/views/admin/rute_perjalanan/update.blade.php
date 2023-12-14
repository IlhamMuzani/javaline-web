@extends('layouts.app')

@section('title', 'Perbarui Rute Perjalanan')

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

            <!-- /.card-header -->
            <form action="{{ url('admin/rute_perjalanan/' . $rute_perjalanan->id) }}" method="POST"
                enctype="multipart/form-data" autocomplete="off">
                @csrf
                @method('put')
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
                                        {{ old('provinsi', $rute_perjalanan->provinsi) == $province ? 'selected' : null }}>
                                        {{ $province }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nama_rute">Rute Perjalanan</label>
                            <input type="text" class="form-control" id="nama_rute" name="nama_rute"
                                placeholder="masukkan tujuan" value="{{ old('nama_rute', $rute_perjalanan->nama_rute) }}">
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Biaya Perjalanan</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        @if ($golongan->count() >= 1)
                            <div class="form-group">
                                <label for="golongan1">Golongan 1</label>
                                <input type="number" class="form-control" id="golongan1" name="golongan1"
                                    placeholder="masukkan biaya"
                                    value="{{ old('golongan1', $rute_perjalanan->golongan1) }}">
                            </div>
                        @endif
                        @if ($golongan->count() >= 2)
                            <div class="form-group">
                                <label for="golongan2">Golongan 2</label>
                                <input type="number" class="form-control" id="golongan2" name="golongan2"
                                    placeholder="masukkan biaya"
                                    value="{{ old('golongan2', $rute_perjalanan->golongan2) }}">
                            </div>
                        @endif
                        @if ($golongan->count() >= 3)
                            <div class="form-group">
                                <label for="golongan3">Golongan 3</label>
                                <input type="number" class="form-control" id="golongan3" name="golongan3"
                                    placeholder="masukkan biaya"
                                    value="{{ old('golongan3', $rute_perjalanan->golongan3) }}">
                            </div>
                        @endif
                        @if ($golongan->count() >= 4)
                            <div class="form-group">
                                <label for="golongan4">Golongan 4</label>
                                <input type="number" class="form-control" id="golongan4" name="golongan4"
                                    placeholder="masukkan biaya"
                                    value="{{ old('golongan4', $rute_perjalanan->golongan4) }}">
                            </div>
                        @endif
                        @if ($golongan->count() >= 5)
                            <div class="form-group">
                                <label for="golongan5">Golongan 5</label>
                                <input type="number" class="form-control" id="golongan5" name="golongan5"
                                    placeholder="masukkan biaya"
                                    value="{{ old('golongan5', $rute_perjalanan->golongan5) }}">
                            </div>
                        @endif
                        @if ($golongan->count() >= 6)
                            <div class="form-group">
                                <label for="golongan6">Golongan 6</label>
                                <input type="number" class="form-control" id="golongan6" name="golongan6"
                                    placeholder="masukkan biaya"
                                    value="{{ old('golongan6', $rute_perjalanan->golongan6) }}">
                            </div>
                        @endif
                        @if ($golongan->count() >= 7)
                            <div class="form-group">
                                <label for="golongan7">Golongan 7</label>
                                <input type="number" class="form-control" id="golongan7" name="golongan7"
                                    placeholder="masukkan biaya"
                                    value="{{ old('golongan7', $rute_perjalanan->golongan7) }}">
                            </div>
                        @endif
                        @if ($golongan->count() >= 8)
                            <div class="form-group">
                                <label for="golongan8">Golongan 8</label>
                                <input type="number" class="form-control" id="golongan8" name="golongan8"
                                    placeholder="masukkan biaya"
                                    value="{{ old('golongan8', $rute_perjalanan->golongan8) }}">
                            </div>
                        @endif
                        @if ($golongan->count() >= 9)
                            <div class="form-group">
                                <label for="golongan9">Golongan 9</label>
                                <input type="number" class="form-control" id="golongan9" name="golongan9"
                                    placeholder="masukkan biaya"
                                    value="{{ old('golongan9', $rute_perjalanan->golongan9) }}">
                            </div>
                        @endif
                        @if ($golongan->count() >= 10)
                            <div class="form-group">
                                <label for="golongan10">Golongan 10</label>
                                <input type="number" class="form-control" id="golongan10" name="golongan10"
                                    placeholder="masukkan biaya"
                                    value="{{ old('golongan10', $rute_perjalanan->golongan10) }}">
                            </div>
                        @endif
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
