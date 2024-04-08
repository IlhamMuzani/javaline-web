@extends('layouts.app')

@section('title', 'Perbarui Driver')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Driver</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/karyawan') }}">Driver</a></li>
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
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Perbarui Driver</h3>
                </div>
                <!-- /.card-header -->
                <form action="{{ url('admin/driver/' . $drivers->id) }}" method="POST" enctype="multipart/form-data"
                    autocomplete="off">
                    @csrf
                    @method('put')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama">Deposit</label>
                            <input type="number" class="form-control" id="no_sim" name="deposit"
                                placeholder="Masukan deposit" value="{{ old('deposit', $drivers->deposit) }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">Kasbon</label>
                            <input type="number" class="form-control" id="kasbon" name="kasbon"
                                placeholder="Masukan kasbon" value="{{ old('kasbon', $drivers->kasbon) }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">Bayar Kasbon</label>
                            <input type="number" class="form-control" id="bayar_kasbon" name="bayar_kasbon"
                                placeholder="Masukan bayar" value="{{ old('bayar_kasbon', $drivers->bayar_kasbon) }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">Saldo Deposit</label>
                            <input type="number" class="form-control" id="no_sim" name="tabungan"
                                placeholder="Masukan deposit driver" value="{{ old('tabungan', $drivers->tabungan) }}">
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
