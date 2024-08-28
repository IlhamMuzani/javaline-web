@extends('layouts.app')

@section('title', 'Tujuan Muat')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tujuan Muat</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/alamat_muat') }}">Tujuan Muat</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <style>
        #map {
            height: 400px;
            width: 100%;
        }
    </style>

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
            @if (session('erorrss'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-ban"></i> Error!
                    </h5>
                    {{ session('erorrss') }}
                </div>
            @endif

            @if (session('error_pelanggans') || session('error_pesanans'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-ban"></i> Error!
                    </h5>
                    @if (session('error_pelanggans'))
                        @foreach (session('error_pelanggans') as $error)
                            - {{ $error }} <br>
                        @endforeach
                    @endif
                    @if (session('error_pesanans'))
                        @foreach (session('error_pesanans') as $error)
                            - {{ $error }} <br>
                        @endforeach
                    @endif
                </div>
            @endif
            <form action="{{ url('admin/alamat_muat') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Tujuan Muat</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group" style="flex: 8;">
                            <div class="form-group">
                                <div class="form-group" style="flex: 8;">
                                    <label for="pelanggan_id">Nama Pelanggan</label>
                                    <select class="select2bs4 select22-hidden-accessible" name="pelanggan_id"
                                        data-placeholder="Cari Pelanggan.." style="width: 100%;" data-select22-id="23"
                                        tabindex="-1" aria-hidden="true" id="pelanggan_id">
                                        <option value="">- Pilih -</option>
                                        @foreach ($pelanggans as $pelanggan)
                                            <option value="{{ $pelanggan->id }}"
                                                {{ old('pelanggan_id') == $pelanggan->id ? 'selected' : '' }}>
                                                {{ $pelanggan->nama_pell }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="nama">No Telp</label>
                                <input type="text" class="form-control" id="telp" name="telp"
                                    placeholder="Masukan no telp" value="{{ old('telp') }}">
                            </div>
                            <div class="form-group">
                                <label for="alamat">Tujuan Muat</label>
                                <input type="text" class="form-control" id="alamat" name="alamat"
                                    placeholder="masukkan tujuan muat" value="{{ old('alamat') }}">
                            </div>
                        </div>

                        <!-- Add Leaflet map container -->
                        <div class="form-group">
                            <label style="font-size:14px" for="map">Peta</label>
                            <div id="map"></div>
                            <input type="hidden" id="latitude" value="{{ old('latitude') }}" name="latitude" />
                            <input type="hidden" id="longitude" value="{{ old('longitude') }}" name="longitude" />
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="reset" class="btn btn-secondary" id="btnReset">Reset</button>
                        <button type="submit" class="btn btn-primary" id="btnSimpan">Simpan</button>
                        <div id="loading" style="display: none;">
                            <i class="fas fa-spinner fa-spin"></i> Sedang Menyimpan...
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </form>
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

    <!-- Include Leaflet CSS and JavaScript -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBkIDNG5j-03RVePcLfpD_F7GfUxh5U1FE&callback=initMap" async
        defer></script>

    <script>
        function initMap() {
            var defaultLat = -6.967463;
            var defaultLng = 109.139252;
            var latitude = parseFloat(document.getElementById('latitude').value) || defaultLat;
            var longitude = parseFloat(document.getElementById('longitude').value) || defaultLng;

            // Initialize the map
            var map = new google.maps.Map(document.getElementById('map'), {
                center: {
                    lat: latitude,
                    lng: longitude
                },
                zoom: 13
            });

            // Initialize the marker
            var marker = new google.maps.Marker({
                position: {
                    lat: latitude,
                    lng: longitude
                },
                map: map,
                draggable: true
            });

            // Update the hidden fields with marker coordinates on dragend
            marker.addListener('dragend', function(event) {
                document.getElementById('latitude').value = event.latLng.lat();
                document.getElementById('longitude').value = event.latLng.lng();
            });

            // Update the marker position when map is clicked
            map.addListener('click', function(event) {
                marker.setPosition(event.latLng);
                document.getElementById('latitude').value = event.latLng.lat();
                document.getElementById('longitude').value = event.latLng.lng();
            });
        }
    </script>
@endsection
