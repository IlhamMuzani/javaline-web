@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Profile</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Profile</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-check"></i> Berhasil!
                    </h5>
                    {{ session('success') }}
                </div>
            @endif
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
                    <h5 class="mb-0">Update Profile</h5>
                </div>
                <form action="{{ url('admin/profile/update') }}" method="post" enctype="multipart/form-data"
                    autocomplete="off">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama">Nama User</label>
                            <input type="text" class="form-control" id="nama" name="nama_lengkap" readonly
                                placeholder="Masukan nama user" value="{{ old('nama', $user->karyawan->nama_lengkap) }}">
                        </div>
                        <div class="form-group">
                            <label for="kode">Kode User</label>
                            <input type="text" class="form-control" id="kode_user" name="kode_user" readonly
                                placeholder="Masukan user" value="{{ old('kode_user', $user->kode_user) }}">
                        </div>
                        <div class="form-group">
                            <label for="telp">No. Telepon</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">+62</span>
                                </div>
                                <input type="text" id="telp" name="telp" class="form-control" readonly
                                    placeholder="Masukan nomor telepon" value="{{ old('telp', $user->karyawan->telp) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" readonly rows="3" placeholder="Masukan alamat">{{ old('alamat', $user->karyawan->alamat) }}</textarea>
                        </div>
                        {{-- <div class="form-group">
                            <label for="foto">Foto</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="gambar" name="gambar"
                                    accept="image/*">
                                <label class="custom-file-label" for="gambar">Pilih Foto</label>
                            </div>
                        </div> --}}
                        <hr>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <div class="input-group">
                                        <input type="password" id="password" name="password" class="form-control"
                                            value="{{ old('password') }}">
                                        <div class="input-group-append">
                                            <div class="input-group-text" style="cursor: pointer;" id="password-toggle">
                                                <span id="password-icon" class="fas fa-eye"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <small>(Kosongkan saja jika tidak ingin diubah)</small>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="password_confirmation">Konfirmasi Password</label>
                                    <div class="input-group">
                                        <input type="password" id="password_confirmation" name="password_confirmation"
                                            class="form-control" value="{{ old('password_confirmation') }}">
                                        <div class="input-group-append">
                                            <div class="input-group-text" style="cursor: pointer;"
                                                id="password-confirm-toggle">
                                                <span id="password-confirm-icon" class="fas fa-eye"></span>
                                            </div>
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
        </div>
    </section>
    <script>
        $(document).ready(function() {
            $('#password-toggle').click(function() {
                togglePasswordVisibility('password', 'password-icon');
            });

            $('#password-confirm-toggle').click(function() {
                togglePasswordVisibility('password_confirmation', 'password-confirm-icon');
            });

            function togglePasswordVisibility(inputId, iconId) {
                var passwordInput = $('#' + inputId);
                var passwordIcon = $('#' + iconId);

                if (passwordInput.attr('type') === 'password') {
                    passwordInput.attr('type', 'text');
                    passwordIcon.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    passwordInput.attr('type', 'password');
                    passwordIcon.removeClass('fa-eye-slash').addClass('fa-eye');
                }
            }
        });
    </script>
@endsection
