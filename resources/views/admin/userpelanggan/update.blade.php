@extends('layouts.app')

@section('title', 'Perbarui User')

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
                    <h1 class="m-0">User</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/userpelanggan') }}">User</a></li>
                        <li class="breadcrumb-item active">Perbarui</li>
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
                    <h3 class="card-title">Perbarui User</h3>
                </div>
                <form action="{{ url('admin/userpelanggan/' . $user->id) }}" method="POST" enctype="multipart/form-data"
                    autocomplete="off">
                    @csrf
                    @method('put')
                    <div class="card-body">
                        <div hidden class="form-group">
                            <label for="id">id Pelanggan</label>
                            <input type="text" class="form-control" id="id" name="id" readonly
                                placeholder="" value="{{ old('id', $user->id) }}">
                        </div>
                        <div class="form-group">
                            <label for="kode_pelanggan">Nama Pelanggan</label>
                            <input type="text" class="form-control" id="kode" name="kode_pelanggan" readonly
                                placeholder="" value="{{ old('kode_pelanggan', $user->nama_pell) }}">
                        </div>
                        <div class="form-group">
                            <label for="kode_pelanggan">Kode Pelanggan</label>
                            <input type="text" class="form-control" id="kode" name="kode_pelanggan" readonly
                                placeholder="" value="{{ old('kode_pelanggan', $user->kode_pelanggan) }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">Telp</label>
                            <input type="text" class="form-control" id="telp" name="telp" readonly placeholder=""
                                value="{{ old('telp', $user->telp) }}">
                        </div>

                        <div class="form-group">
                            <label for="nama">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat" readonly placeholder=""
                                value="{{ old('alamat', $user->alamat) }}">
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
        function getData(id) {
            var kode_pelanggan = document.getElementById('kode_pelanggan');
            $.ajax({
                url: "{{ url('admin/userpelanggan/pelanggan') }}" + "/" + kode_pelanggan.value,
                type: "GET",
                dataType: "json",
                success: function(response) {
                    console.log('Respons dari server:', response);

                    var kode = document.getElementById('kode');
                    var telp = document.getElementById('telp');
                    var alamat = document.getElementById('alamat');

                    // Periksa apakah properti yang diharapkan ada dalam respons JSON
                    if (response && response.kode_pelanggan) {
                        kode.value = response.kode_pelanggan;
                    }
                    if (response && response.telp) {
                        telp.value = response.telp;
                    }
                    if (response && response.alamat) {
                        alamat.value = response.alamat;
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Terjadi kesalahan dalam permintaan AJAX:', error);
                }
            });
        }
    </script>

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
