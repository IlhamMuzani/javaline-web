@extends('layouts.app')

@section('title', 'Tambah User')

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
                        <li class="breadcrumb-item"><a href="{{ url('admin/user') }}">User</a></li>
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
                    <h3 class="card-title">Tambah User</h3>
                </div>
                <!-- /.card-header -->
                {{-- <div class="card-body">
                    <form method="get" id="form-action">
                        <h3 class="card-title">
                            <input type="text" name="kode_karyawan" class="form-control float-right" onclick="getCari()"
                                placeholder="Search" id="kode_karyawan" value="{{ Request::get('kode_user') }}">
                        </h3>
                        <button type="button" class="btn btn-outline-primary mr-2" onclick="cari()">
                            <i class="fas fa-search"></i> Cari
                        </button>
                    </form>
                    <h3 class="card-title">
                        <button type="button" class="btn btn-default ml-2"><i class="fas fa-search"
                                onclick="cari()"></i></button>
                    </h3>
                </div> --}}
                <form action="{{ url('admin/user') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <div class="card-body">
                        <div class="form-group" style="flex: 8;"> <!-- Adjusted flex value -->
                            <label for="karyawan_id">Pilih Kode Karyawan</label>
                            <select class="select2bs4 select2-hidden-accessible" name="karyawan_id"
                                data-placeholder="Cari Karyawan.." style="width: 100%;" data-select2-id="23" tabindex="-1"
                                aria-hidden="true" id="kode_karyawan" onchange="getData(0)">
                                <option value="">- Pilih -</option>
                                @foreach ($karyawans as $karyawan)
                                    <option value="{{ $karyawan->id }}"
                                        {{ old('karyawan_id') == $karyawan->id ? 'selected' : '' }}>
                                        {{ $karyawan->kode_karyawan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nama_lengkap">Nama lengkap</label>
                            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" readonly
                                placeholder="" value="{{ old('nama_lengkap') }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">No KTP</label>
                            <input type="text" class="form-control" id="no_ktp" name="no_ktp" readonly placeholder=""
                                value="{{ old('no_ktp') }}">
                        </div>

                        <div class="form-group">
                            <label for="nama">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat" readonly placeholder=""
                                value="{{ old('alamat') }}">
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
            var kode_karyawan = document.getElementById('kode_karyawan');
            $.ajax({
                url: "{{ url('admin/user/karyawan') }}" + "/" + kode_karyawan.value,
                type: "GET",
                dataType: "json",
                success: function(response) {
                    console.log('Respons dari server:', response);

                    var nama_lengkap = document.getElementById('nama_lengkap');
                    var no_ktp = document.getElementById('no_ktp');
                    var alamat = document.getElementById('alamat');

                    // Periksa apakah properti yang diharapkan ada dalam respons JSON
                    if (response && response.nama_lengkap) {
                        nama_lengkap.value = response.nama_lengkap;
                    }
                    if (response && response.no_ktp) {
                        no_ktp.value = response.no_ktp;
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


        function getCari(id) {
            var kode_karyawan = document.getElementById('kode_karyawan');
            $.ajax({
                url: "{{ url('admin/user/karyawan') }}" + "/" + kode_karyawan.value,
                type: "GET",
                dataType: "json",
                success: function(kode_karyawan) {
                    var nama_lengkap = document.getElementById('nama_lengkap');
                    nama_lengkap.value = kode_karyawan.nama_lengkap;

                    var no_ktp = document.getElementById('no_ktp');
                    no_ktp.value = kode_karyawan.no_ktp;

                    var alamat = document.getElementById('alamat');
                    alamat.value = kode_karyawan.alamat;
                },
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
