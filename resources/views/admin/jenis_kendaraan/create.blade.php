@extends('layouts.app')

@section('title', 'Tambah Jenis Kendaraan')

@section('content')
    <div id="loadingSpinner" style="display: flex; align-items: center; justify-content: center; height: 100vh;">
        <i class="fas fa-spinner fa-spin" style="font-size: 3rem;"></i>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(function() {
                document.getElementById("loadingSpinner").style.display = "none";
                document.getElementById("mainContent").style.display = "block";
                document.getElementById("mainContentSection").style.display = "block";
            }, 100); // Adjust the delay time as needed
        });
    </script>

    <!-- Content Header (Page header) -->
    <div class="content-header" style="display: none;" id="mainContent">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Jenis Kendaraan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/jenis_kendaraan') }}">Jenis Kendaraan</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content" style="display: none;" id="mainContentSection">
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
                    <h3 class="card-title">Tambah Jenis Kendaraan</h3>
                </div>
                <!-- /.card-header -->
                <form action="{{ url('admin/jenis_kendaraan') }}" method="POST" enctype="multipart/form-data"
                    autocomplete="off">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama_jenis_kendaraan">Nama Jenis Kendaraan</label>
                            <input type="text" class="form-control" id="nama_jenis_kendaraan" name="nama_jenis_kendaraan"
                                placeholder="Masukan nama jenis kendaraan" value="{{ old('nama_jenis_kendaraan') }}">
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="panjang">Panjang</label>
                                    <input type="text" class="form-control" id="panjang" name="panjang"
                                        placeholder="Masukan panjang" value="{{ old('panjang') }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="lebar">Lebar</label>
                                    <input type="text" class="form-control" id="lebar" name="lebar"
                                        placeholder="Masukan lebar" value="{{ old('lebar') }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="tinggi">Tinggi</label>
                                    <input type="text" class="form-control" id="tinggi" name="tinggi"
                                        placeholder="Masukan tinggi" value="{{ old('tinggi') }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="total_ban">Total Ban</label>
                                    <input type="text" class="form-control" id="total_ban" name="total_ban"
                                        placeholder="Masukan total ban" value="{{ old('total_ban') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="reset" class="btn btn-secondary" id="btnReset">Reset</button>
                        <button type="submit" class="btn btn-primary" id="btnSimpan">Simpan</button>
                        <div id="loading" style="display: none;">
                            <i class="fas fa-spinner fa-spin"></i> Sedang Menyimpan...
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script>
        $(document).ready(function() {
            // Tambahkan event listener pada tombol "Simpan"
            $('#btnSimpan').click(function() {
                // Sembunyikan tombol "Simpan" dan "Reset", serta tampilkan elemen loading
                $(this).hide();
                $('#btnReset').hide(); // Tambahkan id "btnReset" pada tombol "Reset"
                $('#loading').show();

                // Lakukan pengiriman formulir
                $('form').submit();
            });
        });
    </script>
@endsection
