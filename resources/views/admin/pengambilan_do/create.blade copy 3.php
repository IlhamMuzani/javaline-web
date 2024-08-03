@extends('layouts.app')

@section('title', 'Pengambilan DO')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Pengambilan DO</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/pengambilan_do') }}">Pengambilan DO</a></li>
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

        #searchBox {
            width: 100%;
            margin-bottom: 10px;
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
                        <h3 class="card-title">Tambah Pengambilan DO</h3>
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

                            <div class="container">
                                <h3>Lokasi</h3>
                                <input id="searchBox" type="text" placeholder="Cari lokasi" class="form-control"
                                    style="margin-bottom: 10px;">
                                <div id="map" style="height: 400px; width: 100%;"></div>
                                <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude') }}">
                                <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude') }}">
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
                                    <textarea readonly type="text" class="form-control" id="alamat_bongkar" name="alamat_bongkar" placeholder="">{{ old('alamat_bongkar') }}</textarea>
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
                </div>
            </form>
            <div class="container">
                <h3>Lokasi</h3>
                <div id="map" style="height: 400px; width: 100%;"></div>
            </div>
        </div>

        <div class="modal fade" id="tableSpk" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Spk</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive scrollbar m-2">
                            <table id="datatables7" class="table table-bordered table-striped">
                                <thead class="bg-200 text-900">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>No. Spk</th>
                                        <th>Tanggal</th>
                                        <th>Pelanggan</th>
                                        <th>Nama Driver</th>
                                        <th>No Kabin</th>
                                        <th>Golongan</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($spks as $spk)
                                        <tr
                                            onclick="getSelectedDataspk(
                                                '{{ $spk->id }}',
                                                '{{ $spk->kode_spk }}',
                                                '{{ $spk->kendaraan_id }}',
                                                '{{ $spk->kendaraan->kode_kendaraan ?? null }}',
                                                '{{ $spk->kendaraan->no_kabin ?? null }}',
                                                '{{ $spk->kendaraan->no_pol ?? null }}',
                                                '{{ $spk->rute_perjalanan_id }}',
                                                '{{ $spk->rute_perjalanan->kode_rute ?? null }}',
                                                '{{ $spk->nama_rute }}',
                                                '{{ $spk->user_id }}',
                                                '{{ $spk->kode_driver }}',
                                                '{{ $spk->nama_driver }}',
                                                '{{ $spk->alamat_muat_id }}',
                                                '{{ $spk->alamat_muat->alamat ?? null }}',
                                                '{{ $spk->alamat_bongkar_id }}',
                                                '{{ $spk->alamat_bongkar->alamat ?? null }}'
                                                )">
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $spk->kode_spk }}</td>
                                            <td>{{ $spk->tanggal_awal }}</td>
                                            <td>{{ $spk->nama_pelanggan }}</td>
                                            <td>{{ $spk->nama_driver }}</td>
                                            <td>{{ $spk->no_kabin }}</td>
                                            <td>{{ $spk->golongan }}</td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="getSelectedDataspk(
                                                '{{ $spk->id }}',
                                                '{{ $spk->kode_spk }}',
                                                '{{ $spk->kendaraan_id }}',
                                                '{{ $spk->kendaraan->kode_kendaraan }}',
                                                '{{ $spk->kendaraan->no_kabin }}',
                                                '{{ $spk->kendaraan->no_pol }}',
                                                '{{ $spk->rute_perjalanan_id }}',
                                                '{{ $spk->rute_perjalanan->kode_rute }}',
                                                '{{ $spk->nama_rute }}',
                                                '{{ $spk->user_id }}',
                                                '{{ $spk->kode_driver }}',
                                                '{{ $spk->nama_driver }}',
                                                '{{ $spk->alamat_muat_id }}',
                                                '{{ $spk->alamat_muat->alamat ?? null }}',
                                                '{{ $spk->alamat_bongkar_id }}',
                                                '{{ $spk->alamat_bongkar->alamat ?? null }}'
                                                )">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBMLFLHH-g6kiaMRktCqUsQFNnq2yB87ko&libraries=places&callback=initMap" async defer>
    </script>


    {{-- <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBgdXemgf013J8OZxwnTbves0nEh0iuDRE&libraries=places&callback=initMap"
        async defer></script> --}}
    <script>
        let map;
        let marker;

        function initMap() {
            // Inisialisasi peta di pusat lokasi yang diinginkan
            const initialLocation = {
                lat: -6.1751,
                lng: 106.8650
            }; // Ganti dengan koordinat lokasi awal Anda

            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 15,
                center: initialLocation,
            });

            marker = new google.maps.Marker({
                position: initialLocation,
                map: map,
                title: "Lokasi",
                draggable: true // Membuat marker dapat dipindah
            });

            // Menambahkan kontrol pencarian lokasi
            const input = document.getElementById('searchBox');
            const searchBox = new google.maps.places.SearchBox(input);
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

            searchBox.addListener('places_changed', function() {
                const places = searchBox.getPlaces();

                if (places.length === 0) {
                    return;
                }

                // Ambil data dari hasil pencarian
                const place = places[0];
                const location = place.geometry.location;

                // Update peta dan marker
                map.setCenter(location);
                marker.setPosition(location);

                // Update latitude dan longitude di input form
                document.getElementById('latitude').value = location.lat();
                document.getElementById('longitude').value = location.lng();
            });

            // Event listener untuk drag marker
            google.maps.event.addListener(marker, 'dragend', function(event) {
                document.getElementById('latitude').value = event.latLng.lat();
                document.getElementById('longitude').value = event.latLng.lng();
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

    <script>
        function showCategoryModalSPK(selectedCategory) {
            $('#tableSpk').modal('show');
        }

        function getSelectedDataspk(Spk_id, Kode_spk, KendaraanId, KodeKendaraan, NoKabin, NoPol, RuteId, KodeRute,
            NamaRute, DriverId, KodeDriver, NamaDriver, AlamatMuat_id, AlamatMuat, AlamatBongkar_id, AlamatBongkar) {

            // Assign the values to the corresponding input fields
            document.getElementById('spk_id').value = Spk_id;
            document.getElementById('kode_spk').value = Kode_spk;
            document.getElementById('kendaraan_id').value = KendaraanId;
            document.getElementById('kode_kendaraan').value = KodeKendaraan;
            document.getElementById('no_kabin').value = NoKabin;
            document.getElementById('no_pol').value = NoPol;
            document.getElementById('rute_perjalanan_id').value = RuteId;
            document.getElementById('kode_rute').value = KodeRute;
            document.getElementById('nama_rute').value = NamaRute;
            document.getElementById('user_id').value = DriverId;
            document.getElementById('kode_driver').value = KodeDriver;
            document.getElementById('nama_driver').value = NamaDriver;
            document.getElementById('alamat_muat_id').value = AlamatMuat_id;
            document.getElementById('alamat_muat').value = AlamatMuat;
            document.getElementById('alamat_bongkar_id').value = AlamatBongkar_id;
            document.getElementById('alamat_bongkar').value = AlamatBongkar;

            $('#tableSpk').modal('hide');
        }
    </script>

@endsection
