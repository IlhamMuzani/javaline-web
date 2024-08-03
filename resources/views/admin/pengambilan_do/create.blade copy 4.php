@extends('layouts.app')

@section('title', 'Pemberian DO')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Pemberian DO</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/pengambilan_do') }}">Pemberian DO</a></li>
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
            <form action="{{ url('admin/pengambilan_do') }}" method="POST" enctype="multipart/form-data"
                autocomplete="off">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Pemberian DO</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group" style="flex: 8;">
                            <label style="font-size:14px" class="form-label" for="kode_spk">Pilih SPK</label>
                            <div class="form-group d-flex">
                                <input hidden class="form-control" id="spk_id" name="spk_id" type="text"
                                    placeholder="" value="{{ old('spk_id') }}" readonly
                                    style="margin-right: 10px; font-size:14px" />
                                <input onclick="showCategoryModalSPK(this.value)" class="form-control" id="kode_spk"
                                    name="kode_spk" type="text" placeholder="" value="{{ old('kode_spk') }}" readonly
                                    style="margin-right: 10px; font-size:14px" />
                                <button class="btn btn-primary" type="button" onclick="showCategoryModalSPK(this.value)">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>

                            <div id="form_pelanggan">
                                <div hidden class="form-group">
                                    <label for="kendaraan_id">Kendaraan Id</label>
                                    <input type="text" class="form-control" id="kendaraan_id" readonly
                                        name="kendaraan_id" placeholder="" value="{{ old('kendaraan_id') }}">
                                </div>
                                <div class="form-group">
                                    <div class="form-group">
                                        <label style="font-size:14px" for="kode_kendaraan">Kode Kendaraan</label>
                                        <input style="font-size:14px" type="text" class="form-control"
                                            id="kode_kendaraan" readonly name="kode_kendaraan" placeholder=""
                                            value="{{ old('kode_kendaraan') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-group">
                                        <label style="font-size:14px" for="no_kabin">No Kabin</label>
                                        <input style="font-size:14px" type="text" class="form-control" id="no_kabin"
                                            readonly name="no_kabin" placeholder="" value="{{ old('no_kabin') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-group">
                                        <label style="font-size:14px" for="no_pol">No Pol</label>
                                        <input style="font-size:14px" type="text" class="form-control" id="no_pol"
                                            readonly name="no_pol" placeholder="" value="{{ old('no_pol') }}">
                                    </div>
                                </div>
                                <div hidden class="form-group">
                                    <label for="rute_perjalanan_id">Rute Id</label>
                                    <input type="text" class="form-control" id="rute_perjalanan_id" readonly
                                        name="rute_perjalanan_id" placeholder=""
                                        value="{{ old('rute_perjalanan_id') }}">
                                </div>
                                <div class="form-group">
                                    <div class="form-group">
                                        <label style="font-size:14px" for="kode_rute">Kode Rute Perjalanan</label>
                                        <input style="font-size:14px" type="text" class="form-control" id="kode_rute"
                                            readonly name="kode_rute" placeholder="" value="{{ old('kode_rute') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-group">
                                        <label style="font-size:14px" for="nama_rute">Rute Perjalanan</label>
                                        <input style="font-size:14px" type="text" class="form-control" id="nama_rute"
                                            readonly name="nama_rute" placeholder="" value="{{ old('nama_rute') }}">
                                    </div>
                                </div>
                                <div hidden class="form-group">
                                    <label for="user_id">Driver Id</label>
                                    <input type="text" class="form-control" id="user_id" readonly name="user_id"
                                        placeholder="" value="{{ old('user_id') }}">
                                </div>
                                <div class="form-group">
                                    <div class="form-group">
                                        <label style="font-size:14px" for="kode_driver">Kode Driver</label>
                                        <input style="font-size:14px" type="text" class="form-control"
                                            id="kode_driver" readonly name="kode_driver" placeholder=""
                                            value="{{ old('kode_driver') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-group">
                                        <label style="font-size:14px" for="nama_driver">Nama Driver</label>
                                        <input style="font-size:14px" type="text" class="form-control"
                                            id="nama_driver" readonly name="nama_driver" placeholder=""
                                            value="{{ old('nama_driver') }}">
                                    </div>
                                </div>
                                <div hidden class="form-group">
                                    <label for="alamat_muat_id">Alamat Muat Id</label>
                                    <input type="text" class="form-control" id="alamat_muat_id" readonly
                                        name="alamat_muat_id" placeholder="" value="{{ old('alamat_muat_id') }}">
                                </div>
                                <div class="form-group">
                                    <label for="alamat_muat">Alamat Muat</label>
                                    <textarea readonly type="text" class="form-control" id="alamat_muat" name="alamat_muat" placeholder="">{{ old('alamat_muat_id') }}</textarea>
                                </div>
                                <div hidden class="form-group">
                                    <label for="alamat_bongkar_id">Alamat Bongkar Id</label>
                                    <input type="text" class="form-control" id="alamat_bongkar_id" readonly
                                        name="alamat_bongkar_id" placeholder="" value="{{ old('alamat_bongkar_id') }}">
                                </div>
                                <div class="form-group">
                                    <label for="alamat_bongkar">Alamat Bongkar</label>
                                    <textarea readonly type="text" class="form-control" id="alamat_bongkar" name="alamat_bongkar" placeholder="">{{ old('alamat_bongkar_id') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Add Leaflet map container -->
                        <div class="form-group">
                            <label style="font-size:14px" for="map">Peta</label>
                            <div id="map"></div>
                            <input id="latitude" name="latitude" />
                            <input id="longitude" name="longitude" />
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ url('admin/pengambilan_do') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </form>
        </div>
    </section>

    <!-- Include Leaflet CSS and JavaScript -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <!-- Include Leaflet Control Geocoder CSS and JavaScript -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ambil nilai latitude dan longitude dari input tersembunyi
            var initialLat = parseFloat(document.getElementById('latitude').value) || -6.967463;
            var initialLng = parseFloat(document.getElementById('longitude').value) || 109.139252;

            // Inisialisasi peta dengan koordinat default atau yang diambil dari input
            var map = L.map('map').setView([initialLat, initialLng], 13);

            // Tambahkan layer tile
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Inisialisasi marker dengan koordinat default atau yang diambil dari input
            var marker = L.marker([initialLat, initialLng], {
                    draggable: true
                }).addTo(map)
                .bindPopup('<b>PT. JAVA LINE LOGISTICS</b>')
                .openPopup();

            // Inisialisasi geocoder dan tambahkan ke peta
            var geocoder = L.Control.Geocoder.nominatim();
            L.Control.geocoder({
                geocoder: geocoder
            }).addTo(map);

            // Perbarui input tersembunyi dengan koordinat marker saat marker dipindahkan
            marker.on('moveend', function(event) {
                var position = event.target.getLatLng();
                document.getElementById('latitude').value = position.lat;
                document.getElementById('longitude').value = position.lng;
            });

            // Perbarui marker dan input tersembunyi saat peta diklik
            map.on('click', function(event) {
                var latlng = event.latlng;
                marker.setLatLng(latlng);
                document.getElementById('latitude').value = latlng.lat;
                document.getElementById('longitude').value = latlng.lng;
            });

            // Set nilai awal latitude dan longitude ke input tersembunyi jika belum diatur
            document.getElementById('latitude').value = initialLat;
            document.getElementById('longitude').value = initialLng;
        });
    </script>
@endsection
