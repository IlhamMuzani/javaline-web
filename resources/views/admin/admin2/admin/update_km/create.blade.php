@extends('layouts.app')

@section('title', 'Update Km')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    {{-- <h1 class="m-0">Kilo Meter</h1> --}}
                    <a href="{{ url('admin/km') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i>
                    </a>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/km') }}">Kilo Meter</a></li>
                        <li class="breadcrumb-item active">Update</li>
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
                    <h3 class="card-title">Update Kilo Meter</h3>
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
                        <div class="form-group">
                            <label for="kendaraan_id">Pilih No Kabin</label>
                            {{-- <select class="custom-select form-control" id="kode_karyawan" name="karyawan_id"
                                onchange="getData(0)">
                                <option value="">- Pilih -</option>
                                @foreach ($kms as $km)
                                    <option value="{{ $km->id }}">{{ $km->no_kabin }}</option>
                                @endforeach
                            </select> --}}
                            <select class="form-control select2bs4 select2-hidden-accessible" style="width: 100%;"
                                data-select2-id="17" tabindex="-1" aria-hidden="true">
                                <option selected="selected" data-select2-id="19">Alabama</option>
                                <option data-select2-id="31">Alaska</option>
                                <option data-select2-id="32">California</option>
                                <option data-select2-id="33">Delaware</option>
                                <option data-select2-id="34">Tennessee</option>
                                <option data-select2-id="35">Texas</option>
                                <option data-select2-id="36">Washington</option>
                            </select><span
                                class="select2 select2-container select2-container--bootstrap4 select2-container--below"
                                dir="ltr" data-select2-id="18" style="width: 100%;"><span class="selection"><span
                                        class="select2-selection select2-selection--single" role="combobox"
                                        aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false"
                                        aria-labelledby="select2-3nd0-container"><span class="select2-selection__rendered"
                                            id="select2-3nd0-container" role="textbox" aria-readonly="true"
                                            title="Alabama">Alabama</span><span class="select2-selection__arrow"
                                            role="presentation"><b role="presentation"></b></span></span></span><span
                                    class="dropdown-wrapper" aria-hidden="true"></span></span>
                        </div>
                        <div class="form-group">
                            <label for="km">Update Km</label>
                            <input type="text" class="form-control" id="km" name="km" placeholder=""
                                value="{{ old('km') }}">
                        </div>
                        <div class="form-group">
                            <label for="nama_lengkap">No Pol</label>
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
                        <button type="reset" class="btn btn-secondary">Reset</button>
                        <button type="submit" class="btn btn-primary">Update</button>
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
@endsection
