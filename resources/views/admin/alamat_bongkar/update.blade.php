@extends('layouts.app')

@section('title', 'Tujuan Bongkar')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tujuan Bongkar</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/alamat_bongkar') }}">Tujuan Bongkar</a></li>
                        <li class="breadcrumb-item active">Perbarui</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

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
            <form action="{{ url('admin/alamat_bongkar/' . $alamatbongkars->id) }}" method="POST" autocomplete="off">
                @csrf
                @method('put')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Perbarui Tujuan Bongkar</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group" style="flex: 8;">
                            <div class="form-group">
                                <div class="form-group" style="flex: 8;">
                                    <label style="font-size: 14px" for="pelanggan_id">Nama Pelanggan</label>
                                    <select class="select2bs4 select22-hidden-accessible" name="pelanggan_id"
                                        data-placeholder="Cari Pelanggan.." style="width: 100%; font-size:14px"
                                        data-select22-id="23" tabindex="-1" aria-hidden="true" id="pelanggan_id">
                                        <option value="">- Pilih -</option>
                                        @foreach ($pelanggans as $pelanggan)
                                            <option value="{{ $pelanggan->id }}"
                                                {{ old('pelanggan_id', $alamatbongkars->pelanggan_id) == $pelanggan->id ? 'selected' : '' }}>
                                                {{ $pelanggan->nama_pell }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label style="font-size: 14px" for="nama">No Telp</label>
                                <input style="font-size: 14px" type="text" class="form-control" id="telp"
                                    name="telp" placeholder="Masukan no telp"
                                    value="{{ old('telp', $alamatbongkars->telp) }}">
                            </div>
                            <div class="form-group">
                                <label style="font-size: 14px" for="alamat">Tujuan Bongkar</label>
                                <input style="font-size: 14px" type="text" class="form-control" id="alamat"
                                    name="alamat" placeholder="masukkan tujuan bongkar"
                                    value="{{ old('alamat', $alamatbongkars->alamat) }}">
                            </div>
                        </div>

                        <div>
                            <label style="font-size: 14px" for="alamat">Ambil Lokasi</label>
                            <div class="form-group d-flex">
                                <input onclick="showCategoryLokasi(this.value)" class="form-control" id="nama_lokasi"
                                    name="nama_lokasi" type="text" placeholder=""
                                    value="{{ old('nama_lokasi', $alamatbongkars->nama_lokasi) }}" readonly
                                    style="margin-right: 10px; font-size:14px" />
                                <button class="btn btn-primary" type="button" onclick="showCategoryLokasi(this.value)">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label style="font-size: 14px" for="latitude">Latitude</label>
                                <input readonly type="text" class="form-control" id="latitude" name="latitude"
                                    style="font-size: 14px" placeholder=""
                                    value="{{ old('latitude', $alamatbongkars->latitude) }}">
                            </div>
                            <div class="col-md-6">
                                <label style="font-size: 14px" for="longitude">Longitude</label>
                                <input readonly type="text" class="form-control" id="longitude" name="longitude"
                                    style="font-size: 14px" placeholder=""
                                    value="{{ old('longitude', $alamatbongkars->longitude) }}">
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

                    <!-- /.card-body -->
                </div>
            </form>
        </div>
        <div class="modal fade" id="tableLokasi" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Lokasi</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table id="tableid" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Nama Lokasi</th>
                                    <th>Latitude</th>
                                    <th>Longitude</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
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

    <!-- Include Leaflet CSS and JavaScript -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <!-- Include Leaflet Control Geocoder CSS and JavaScript -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize the map with default coordinates
            var defaultLat = -6.967463;
            var defaultLng = 109.139252;
            var latitude = parseFloat(document.getElementById('latitude').value) || defaultLat;
            var longitude = parseFloat(document.getElementById('longitude').value) || defaultLng;

            // Initialize the map
            var map = L.map('map').setView([latitude, longitude], 13);

            // Add a tile layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Initialize the geocoder and add it to the map
            var geocoder = L.Control.Geocoder.nominatim();
            L.Control.geocoder({
                geocoder: geocoder
            }).addTo(map);

            // Initialize the marker with the retrieved coordinates
            var marker = L.marker([latitude, longitude], {
                draggable: true
            }).addTo(map);

            // Add debugging to check if coordinates are correct
            console.log('Initial Latitude:', latitude);
            console.log('Initial Longitude:', longitude);

            // Update the hidden fields with marker coordinates on move
            marker.on('moveend', function(event) {
                var position = event.target.getLatLng();
                document.getElementById('latitude').value = position.lat;
                document.getElementById('longitude').value = position.lng;
            });

            // Update the marker coordinates when the map is clicked
            map.on('click', function(event) {
                var latlng = event.latlng;
                marker.setLatLng(latlng);
                document.getElementById('latitude').value = latlng.lat;
                document.getElementById('longitude').value = latlng.lng;
            });
        });
    </script>

    <script>
        function showCategoryLokasi(selectedCategory) {
            // Tampilkan modal
            $('#tableLokasi').modal('show');

            // Hapus data sebelumnya di tabel
            $('#tableid tbody').empty();

            // Hapus inisialisasi DataTables jika sudah ada
            if ($.fn.DataTable.isDataTable('#tableid')) {
                $('#tableid').DataTable().clear().destroy();
            }

            // Panggil data lokasi melalui AJAX
            $.ajax({
                url: '{{ route('ambil_lokasi') }}',
                method: 'GET',
                success: function(data) {
                    if (data.error) {
                        alert(data.error);
                        return;
                    }

                    // Masukkan data ke dalam tabel
                    $.each(data.Data, function(index, lokasi) {
                        const lon = lokasi.data_circle ? lokasi.data_circle.lon : '';
                        const lat = lokasi.data_circle ? lokasi.data_circle.lat : '';

                        $('#tableid tbody').append(
                            `<tr onclick="getSelectedDataLokasi('${lokasi.geo_nm}', '${lat}', '${lon}')">
                        <td class="text-center">${index + 1}</td>
                        <td>${lokasi.geo_nm}</td>
                        <td>${lat}</td>
                        <td>${lon}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-primary btn-sm"
                                onclick="getSelectedDataLokasi('${lokasi.geo_nm}', '${lat}', '${lon}')">
                                <i class="fas fa-plus"></i>
                            </button>
                        </td>
                    </tr>`
                        );
                    });

                    // Inisialisasi DataTables
                    $('#tableid').DataTable({
                        searching: true,
                        paging: true
                    });
                },
                error: function() {
                    alert('Gagal mengambil data lokasi kendaraan.');
                }
            });
        }

        function getSelectedDataLokasi(nama_lokasi, latitude, longitude) {
            document.getElementById('nama_lokasi').value = nama_lokasi;
            document.getElementById('latitude').value = latitude;
            document.getElementById('longitude').value = longitude;
            $('#tableLokasi').modal('hide');
        }
    </script>


    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

@endsection
