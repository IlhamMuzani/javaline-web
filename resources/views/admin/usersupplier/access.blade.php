@extends('layouts.app')

@section('title', 'Tambahkan Hak Akses')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Hak Akses</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ url('admin/user') }}">Hak akses</a>
                        </li>
                        <li class="breadcrumb-item active">Lihat</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tambahkan</h3>
                </div>
                <!-- /.card-header -->
                <form action="{{ url('admin/user-access/' . $user->id) }}" method="post" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                {{-- <input type="hidden" class="form-control" id="user_id" name="user_id"
                                    placeholder="Masukan nama" value="{{ old('user_id', $user->id) }}"> --}}
                                {{-- <div class="row mb-3">
                                    <div class="col-md-6">
                                        <strong>Master</strong>
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-check-input" type="checkbox" id="master" name="menu[]"
                                            value="master" />
                                    </div>
                                </div> --}}
                                {{-- <div class="row mb-3">
                                    <div class="col-md-6">
                                        <strong>Data karyawan</strong>
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-check-input" type="checkbox" id="karyawan" name="menu[]"
                                            value="karyawan" />
                                    </div>
                                </div> --}}
                                {{-- <div class="row mb-3">
                                    <div class="col-md-6">
                                        <strong>Data User</strong>
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-check-input" type="checkbox" id="user" name="menu[]"
                                            value="user" />
                                    </div>
                                </div> --}}
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <strong>Data Kendaraan</strong>
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-check-input" type="checkbox" id="kendaraan" name="kendaraan"
                                            value="1" />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <strong>Data Pelanggan</strong>
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-check-input" type="checkbox" id="pelanggan" name="pelanggan"
                                            value="1" />
                                    </div>
                                </div>
                                {{-- <div class="row mb-3">
                                    <div class="col-md-6">
                                        <strong>Data Departemen</strong>
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-check-input" type="checkbox" id="departemen" name="menu[]"
                                            value="departemen" />
                                    </div>
                                </div> --}}
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
