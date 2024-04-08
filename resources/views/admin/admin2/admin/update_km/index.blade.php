@extends('layouts.app')

@section('title', 'Update Km')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    {{-- <h1 class="m-0">Kilo Meter</h1> --}}
                    {{-- <a href="{{ url('admin/km') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i>
                    </a> --}}
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
            @if (session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-check"></i> Success!
                    </h5>
                    {{ session('success') }}
                </div>
            @endif
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
                <form action="{{ url('admin/updatekm') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <div class="card-body">
                        <div class="form-group" style="flex: 8;"> <!-- Adjusted flex value -->
                            <select class="select2bs4 select2-hidden-accessible" name="kendaraan_id"
                                data-placeholder="Cari Kode.." style="width: 100%;" data-select2-id="23" tabindex="-1"
                                aria-hidden="true" id="kendaraan_id" onchange="getData(0)">
                                <option value="">- Pilih -</option>
                                @foreach ($kms as $kendaraan)
                                    <option value="{{ $kendaraan->id }}"
                                        {{ old('kendaraan_id') == $kendaraan->id ? 'selected' : '' }}>
                                        {{ $kendaraan->no_kabin }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" hidden>
                            <label for="nopol">id kendaraan</label>
                            <input type="text" class="form-control" id="id" name="id_kendaraan" readonly
                                placeholder="Masukan id" value="{{ old('id') }}">
                        </div>
                        <div class="form-group">
                            <label for="nopol">No. Registrasi Kendaraan</label>
                            <input type="text" class="form-control" id="no_pol" name="no_pol" readonly
                                placeholder="Masukan no registrasi kendaraan" value="{{ old('no_pol') }}">
                        </div>
                        <div class="form-group">
                            <label for="jenis_kendaraan">Jenis Kendaraan</label>
                            <input type="text" class="form-control" id="jenis_kendaraan" name="jenis_kendaraan" readonly
                                placeholder="Masukan jenis kendaraan" value="{{ old('jenis_kendaraan') }}">
                        </div>
                        <div class="form-group">
                            <label for="km">KM Awal</label>
                            <input type="text" class="form-control" id="km_awal" readonly placeholder="0"
                                value="">
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="km">KM Akhir</label>
                            <input type="text" class="form-control" id="km" name="km"
                                placeholder="Masukan km akhir" value="">
                            </select>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary" data-toggle="modal"
                            data-target="#modal-simpan">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script>
        // Fungsi untuk mengambil nilai dari sessionStorage saat halaman dimuat
        window.onload = function() {
            var kendaraanId = document.getElementById('kendaraan_id');
            var noPolInput = document.getElementById('no_pol');
            var jenisKendaraanInput = document.getElementById('jenis_kendaraan');
            var kmAwalInput = document.getElementById('km_awal');

            // Cek apakah data tersimpan di sessionStorage
         

            if (sessionStorage.getItem('km_awal')) {
                kmAwalInput.value = sessionStorage.getItem('km_awal');
            }
        }

        // Fungsi untuk mengubah nilai form dan menyimpannya di sessionStorage
        function getData(id) {
            var kendaraan_id = document.getElementById('kendaraan_id');
            $.ajax({
                url: "{{ url('admin/pelepasan_ban/kendaraan') }}" + "/" + kendaraan_id.value,
                type: "GET",
                dataType: "json",
                success: function(kendaraan_id) {
                    var noPolInput = document.getElementById('no_pol');
                    noPolInput.value = kendaraan_id.no_pol;

                    var jenisKendaraanInput = document.getElementById('jenis_kendaraan');
                    jenisKendaraanInput.value = kendaraan_id.jenis_kendaraan.nama_jenis_kendaraan;

                    var kmAwalInput = document.getElementById('km_awal');
                    kmAwalInput.value = kendaraan_id.km;

                    // Simpan nilai di sessionStorage
                    sessionStorage.setItem('no_pol', noPolInput.value);
                    sessionStorage.setItem('jenis_kendaraan', jenisKendaraanInput.value);
                    sessionStorage.setItem('km_awal', kmAwalInput.value);
                },
            });
        }
    </script>
@endsection
