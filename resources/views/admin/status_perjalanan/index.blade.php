@extends('layouts.app')

@section('title', 'Status Perjalanan Kendaraan')

@section('content')

    <div id="loadingSpinner"
        style="display: none; align-items: center; justify-content: center; height: 100vh; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(255, 255, 255, 0.8); z-index: 9999;">
        <div style="display: flex; flex-direction: column; align-items: center; text-align: center;">
            <!-- Animasi loading berputar -->
            <div class="spinner"
                style="width: 100px; height: 100px; border: 10px solid #f3f3f3; border-top: 10px solid #74e1fc; border-radius: 50%; animation: spin 2s linear infinite; margin-bottom: 20px;">
            </div>

            <!-- Progress bar container -->
            <div id="progressBarContainer"
                style="width: 300px; background-color: #f3f3f3; border-radius: 5px; overflow: hidden;">
                <div id="progressBar"
                    style="width: 0%; height: 30px; background: linear-gradient(to right, #74e1fc, #687275); border-radius: 5px;">
                </div>
            </div>
            <!-- Progress text -->
            Memuat <p id="progressText" style="margin-top: 10px; font-size: 16px; font-weight: bold; color: #000000;">
                0%</p>
        </div>
    </div>

    <style>
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>


    <!-- Content Header (Page header) -->
    <div class="content-header" style="display: none;" id="mainContent">
        <div class="container-fluid">
            <div class="row mb-2">
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content" style="display: none;" id="mainContentSection">
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
                    <h3 class="card-title">Status Perjalanan Kendaraan</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="GET" id="form-action">
                        <div class="form-row">
                            <div class="col-md-2 col-sm-12">
                                <div class="form-group">
                                    <select class="custom-select form-control" id="divisi" name="divisi">
                                        <option value="">- Cari Kode -</option>
                                        <option value="All" {{ Request::get('divisi') == 'All' ? 'selected' : '' }}>
                                            -Semua Code-
                                        </option>
                                        <option value="K1" {{ Request::get('divisi') == 'K1' ? 'selected' : '' }}>
                                            K1
                                        </option>
                                        <option value="K2" {{ Request::get('divisi') == 'K2' ? 'selected' : '' }}>
                                            K2
                                        </option>
                                        <option value="K3" {{ Request::get('divisi') == 'K3' ? 'selected' : '' }}>
                                            K3
                                        </option>
                                        <option value="K4" {{ Request::get('divisi') == 'K4' ? 'selected' : '' }}>
                                            K4
                                        </option>
                                        <option value="K5" {{ Request::get('divisi') == 'K5' ? 'selected' : '' }}>
                                            K5
                                        </option>
                                        <option value="K6" {{ Request::get('divisi') == 'K6' ? 'selected' : '' }}>
                                            K6
                                        </option>
                                        <option value="K7" {{ Request::get('divisi') == 'K7' ? 'selected' : '' }}>
                                            K7
                                        </option>

                                    </select>
                                    <label for="status">(Cari Kode)</label>
                                </div>
                                {{-- </div> --}}
                            </div>


                            <div class="col-md-2 mb-3">
                                <select class="select2bs4 select2-hidden-accessible" name="kendaraan_id"
                                    data-placeholder="Cari No Kabin.." style="width: 100%;" data-select2-id="23"
                                    tabindex="-1" aria-hidden="true" id="kendaraan_id">
                                    <option value="">- Pilih -</option>
                                    <option value="all" {{ Request::get('kendaraan_id') === 'all' ? 'selected' : '' }}>
                                        -Semua Kendaraan-</option> <!-- Opsi All Kendaraan -->
                                    @foreach ($kendaraanall as $kendaraan)
                                        <option value="{{ $kendaraan->id }}"
                                            {{ Request::get('kendaraan_id') == $kendaraan->id ? 'selected' : '' }}>
                                            {{ $kendaraan->no_kabin }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="status">(Cari Kendaraan)</label>
                            </div>

                            <div class="col-md-2 col-sm-12">
                                {{-- <div class="input-group mb-2"> --}}
                                <div class="form-group">
                                    <select class="custom-select form-control" id="status_perjalanan"
                                        name="status_perjalanan">
                                        <option value="">-Semua Status-</option>
                                        <option value="Perjalanan Kosong"
                                            {{ Request::get('status_perjalanan') == 'Perjalanan Kosong' ? 'selected' : '' }}>
                                            Perjalanan Kosong
                                        </option>
                                        {{-- <option value="Tunggu Muat"
                                            {{ Request::get('status_perjalanan') == 'Tunggu Muat' ? 'selected' : '' }}>
                                            Tunggu Muat
                                        </option> --}}
                                        <option value="Tunggu Muat"
                                            {{ Request::get('status_perjalanan') == 'Tunggu Muat' ? 'selected' : '' }}>
                                            Tunggu Muat
                                        </option>
                                        <option value="Perjalanan Isi"
                                            {{ Request::get('status_perjalanan') == 'Perjalanan Isi' ? 'selected' : '' }}>
                                            Perjalanan Isi
                                        </option>
                                        {{-- <option value="Tunggu Bongkar"
                                            {{ Request::get('status_perjalanan') == 'Tunggu Bongkar' ? 'selected' : '' }}>
                                            Tunggu Bongkar
                                        </option> --}}
                                        <option value="Tunggu Bongkar"
                                            {{ Request::get('status_perjalanan') == 'Tunggu Bongkar' ? 'selected' : '' }}>
                                            Tunggu Bongkar
                                        </option>
                                        <option value="Kosong"
                                            {{ Request::get('status_perjalanan') == 'Kosong' ? 'selected' : '' }}>
                                            Kosong
                                        </option>
                                        <option value="Perbaikan di jalan"
                                            {{ Request::get('status_perjalanan') == 'Perbaikan di jalan' ? 'selected' : '' }}>
                                            Perbaikan di jalan
                                        </option>
                                        <option value="Perbaikan di garasi"
                                            {{ Request::get('status_perjalanan') == 'Perbaikan di garasi' ? 'selected' : '' }}>
                                            Perbaikan di garasi
                                        </option>
                                    </select>
                                    <label for="status">(Cari Status)</label>
                                </div>
                                {{-- </div> --}}
                            </div>


                            <div class="col-md-3 mb-3">
                                <select class="select2bs4 select2-hidden-accessible" name="pelanggan_id"
                                    data-placeholder="Cari Pelanggan.." style="width: 100%;" id="pelanggan_id">
                                    <option value="">- Pilih -</option>
                                    <option value="all" {{ Request::get('pelanggan_id') === 'all' ? 'selected' : '' }}>
                                        -Semua Pelanggan-</option>
                                    @foreach ($pelanggans as $pelanggan)
                                        <option value="{{ $pelanggan->id }}"
                                            {{ Request::get('pelanggan_id') == $pelanggan->id ? 'selected' : '' }}>
                                            {{ $pelanggan->nama_pell }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="status">(Cari Pelanggan)</label>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-primary btn-block" onclick="cari()">
                                        <i class="fas fa-search"></i> Cari
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive" style="overflow-x: auto;">
                        <table id="datatables66" class="table table-bordered table-striped table-hover"
                            style="font-size: 13px; min-width: 1000px;">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>No. Kabin</th>
                                    <th>No. Registrasi</th>
                                    <th>Pelanggan</th>
                                    <th>Tujuan</th>
                                    <th>Status Kendaraan</th>
                                    <th>Status Perjalanan</th>
                                    <th>Posisi</th>
                                    <th>Map</th>
                                    <th>Timer</th>
                                    {{-- <th class="text-center" width="40">Opsi</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kendaraans as $kendaraan)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $kendaraan->no_kabin }}</td>
                                        <td>{{ $kendaraan->no_pol }}</td>
                                        {{-- <td>
                                        @if ($kendaraan->pengambilan_do->last())
                                            {{ $kendaraan->pengambilan_do->last()->spk->user->karyawan->nama_lengkap ?? 'tidak ada' }}
                                        @else
                                            tidak ada
                                        @endif
                                    </td> --}}
                                        <td>
                                            @if ($kendaraan->status_perjalanan != 'Kosong')
                                                @if ($kendaraan->latestpengambilan_do)
                                                    {{ $kendaraan->latestpengambilan_do->spk->pelanggan->nama_pell ?? 'belum ada' }}
                                                @else
                                                    tidak ada
                                                @endif
                                            @else
                                                -
                                            @endif
                                        </td>

                                        <td>
                                            @if ($kendaraan->status_perjalanan != 'Kosong')
                                                @if ($kendaraan->pengambilan_do->whereNotIn('status', ['unpost', 'posting', 'selesai'])->last())
                                                    {{ $kendaraan->pengambilan_do->whereNotIn('status', ['unpost', 'posting', 'selesai'])->last()->rute_perjalanan->nama_rute ?? 'tidak ada' }}
                                                @else
                                                    -
                                                @endif
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if ($kendaraan->status_perjalanan)
                                                @if (strtolower($kendaraan->status_perjalanan) == 'loading muat')
                                                    Tunggu Muat
                                                @elseif(strtolower($kendaraan->status_perjalanan) == 'loading bongkar')
                                                    Tunggu Bongkar
                                                @else
                                                    {{ $kendaraan->status_perjalanan }}
                                                @endif
                                            @else
                                                Kosong
                                            @endif
                                        </td>
                                        <td>
                                            @if ($kendaraan->status_kendaraan == 2)
                                                <span style="font-size: 10px"
                                                    class="badge badge-success">Perjalanan</span>
                                            @else
                                                <span style="font-size: 10px" class="badge badge-info">Parkir</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $kendaraan->lokasi }}
                                        </td>
                                        {{-- <td>
                                        <a href="https://maps.google.com/maps?q={{ $kendaraan->latitude }},{{ $kendaraan->longitude }}"
                                            class="btn btn-secondary btn-sm">
                                            <i class="fas fa-map-marked-alt"></i>
                                            Maps
                                        </a>
                                    </td> --}}
                                        <td>
                                            <a style="font-size:12px"
                                                href="https://maps.google.com/maps?q={{ $kendaraan->latitude }},{{ $kendaraan->longitude }}"
                                                class="btn btn-secondary btn-sm" id="btn-update-latlong" target="_blank"
                                                onclick="updateLatLong({{ $kendaraan->id }}); return false;">
                                                <i class="fas fa-map-marked-alt"></i> Maps
                                            </a>
                                            <span hidden id="lokasi-saat-ini">{{ $kendaraan->latitude }},
                                                {{ $kendaraan->longitude }}</span> <!-- Lokasi terbaru -->
                                        </td>


                                        <td>
                                            @if ($kendaraan->status_perjalanan != 'Kosong')
                                                @if ($kendaraan->status_perjalanan)
                                                    {{ $kendaraan->timer }}
                                                @else
                                                    00.00
                                                @endif
                                            @else
                                                -
                                            @endif
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        </div>
    </section>

    <script>
        var form = document.getElementById('form-action');

        function cari() {
            // Tampilkan spinner dan gunakan display: flex agar berada di tengah
            document.getElementById('loadingSpinner').style.display = 'flex';

            // Set action form
            form.action = "{{ url('admin/status_perjalanan') }}";

            // Simulasi progress bar
            var progressBar = document.getElementById('progressBar');
            var progressText = document.getElementById('progressText');
            var progress = 0;

            // Kirim form secara bersamaan (akan dihandle di atas saat proses selesai)
            form.submit();

            // Interval untuk meningkatkan progress hingga 50%
            var interval = setInterval(function() {
                if (progress < 50) {
                    progress += 1;
                    progressBar.style.width = progress + '%';
                    progressText.innerText = progress + '%';
                } else {
                    clearInterval(interval);
                    // Berhenti sejenak sebelum melanjutkan
                    setTimeout(function() {
                        // Mulai meningkatkan dari 50% ke 75%
                        var nextInterval = setInterval(function() {
                            if (progress < 75) {
                                progress += 1;
                                progressBar.style.width = progress + '%';
                                progressText.innerText = progress + '%';
                            } else {
                                clearInterval(nextInterval);
                                // Berhenti sejenak sebelum melanjutkan ke 90%
                                setTimeout(function() {
                                    // Mulai meningkatkan dari 75% ke 90%
                                    var toNinetyInterval = setInterval(function() {
                                            if (progress < 90) {
                                                progress += 1;
                                                progressBar.style.width = progress +
                                                    '%';
                                                progressText.innerText = progress + '%';
                                            } else {
                                                clearInterval(toNinetyInterval);
                                                // Berhenti sejenak sebelum melanjutkan ke 100%
                                                setTimeout(function() {
                                                        // Tingkatkan dari 90% ke 100%
                                                        var finalInterval =
                                                            setInterval(function() {
                                                                    if (progress <
                                                                        99) {
                                                                        progress +=
                                                                            1;
                                                                        progressBar
                                                                            .style
                                                                            .width =
                                                                            progress +
                                                                            '%';
                                                                        progressText
                                                                            .innerText =
                                                                            progress +
                                                                            '%';
                                                                    } else {
                                                                        clearInterval
                                                                            (
                                                                                finalInterval
                                                                            );
                                                                        // Form sudah disubmit sebelumnya
                                                                    }
                                                                },
                                                                500
                                                            ); // Ganti dengan durasi yang sesuai dengan waktu reload Anda
                                                    },
                                                    3000
                                                ); // Ganti dengan durasi delay sebelum melanjutkan ke 100%
                                            }
                                        },
                                        500
                                    ); // Ganti dengan durasi yang sesuai untuk progress dari 75% ke 90%
                                }, 1000); // Ganti dengan durasi delay setelah mencapai 75%
                            }
                        }, 500); // Ganti dengan durasi yang sesuai untuk progress dari 50% ke 75%
                    }, 1000); // Ganti dengan durasi delay setelah mencapai 50%
                }
            }, 30); // Simulasi loading hingga 50%
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(function() {
                document.getElementById("loadingSpinner").style.display = "none";
                document.getElementById("mainContent").style.display = "block";
                document.getElementById("mainContentSection").style.display = "block";
            }, 100); // Sesuaikan waktu penundaan sesuai kebutuhan
        });
    </script>

    <script>
        function updateLatLong(kendaraanId) {
            // Memanggil API menggunakan AJAX untuk memperbarui koordinat
            fetch(`{{ url('admin/status_perjalanan/update_latlong') }}/${kendaraanId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}', // Laravel CSRF Token
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Perbarui tampilan lokasi saat ini
                        document.getElementById('lokasi-saat-ini').innerText = `${data.latitude}, ${data.longitude}`;

                        // Perbarui tautan Google Maps dengan koordinat yang baru
                        const mapLink = document.getElementById('btn-update-latlong');
                        mapLink.href = `https://maps.google.com/maps?q=${data.latitude},${data.longitude}`;

                        // Redirect ke Google Maps setelah pembaruan
                        window.open(mapLink.href, '_blank');
                    } else {
                        alert('Gagal memperbarui lokasi!');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat memperbarui lokasi.');
                });
        }
    </script>



@endsection
