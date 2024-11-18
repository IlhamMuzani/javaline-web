@extends('layouts.app')

@section('title', 'Monitoring Kendaraan')

@section('content')

    <div id="loadingSpinner"
        style="display: none; align-items: center; justify-content: center; height: 100vh; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(255, 255, 255, 0.8); z-index: 9999;">
        <div style="display: flex; flex-direction: column; align-items: center; text-align: center;">
            <!-- Animasi loading berputar -->
            <div class="spinner"
                style="width: 100px; height: 100px; border: 10px solid #f3f3f3; border-top: 10px solid #9cb4d0; border-radius: 50%; animation: spin 2s linear infinite; margin-bottom: 20px;">
            </div>

            <!-- Progress bar container -->
            <div id="progressBarContainer"
                style="width: 300px; background-color: #f3f3f3; border-radius: 5px; overflow: hidden;">
                <div id="progressBar"
                    style="width: 0%; height: 30px; background: linear-gradient(to right, #9cb4d0, #687275); border-radius: 5px;">
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

        /* Gaya untuk header tabel */
        .thead-custom {
            color: white;
            /* Warna teks putih */
        }

        .thead-custom th {
            background: linear-gradient(to bottom, #9cb4d0, #687275);
            /* background: linear-gradient(to bottom, #829dbb, #687275); */
            /* Gradient biru di atas, hitam di bawah */
        }

        /* Gaya untuk tabel */
        table {
            font-size: 13px;
            min-width: 1000px;
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
                    <h3 class="card-title">Monitoring Kendaraan</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="GET" id="form-action">
                        <div class="form-row">
                            <div class="col-md-3 mb-3">
                                <select class="select2bs4 select2-hidden-accessible" name="kendaraan_id"
                                    data-placeholder="Cari No. Pol.." style="width: 100%;" data-select2-id="23"
                                    tabindex="-1" aria-hidden="true" id="kendaraan_id">
                                    <option value="">- Pilih -</option>
                                    <option value="all" {{ Request::get('kendaraan_id') === 'all' ? 'selected' : '' }}>
                                        -Semua Kendaraan-</option> <!-- Opsi All Kendaraan -->
                                    @foreach ($do_kendaraans as $pengambilan)
                                        <option value="{{ $pengambilan->kendaraan->id }}"
                                            {{ Request::get('kendaraan_id') == $pengambilan->kendaraan->id ? 'selected' : '' }}>
                                            {{ $pengambilan->kendaraan->no_pol }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="kendaraan_id">(Cari Kendaraan)</label>
                            </div>

                            {{-- <div class="col-md-3 col-sm-12">
                                <div class="form-group">
                                    <select class="custom-select form-control" id="status_perjalanan"
                                        name="status_perjalanan">
                                        <option value="">- Semua Status -</option>
                                        <option value="Perjalanan Kosong"
                                            {{ Request::get('status_perjalanan') == 'Perjalanan Kosong' ? 'selected' : '' }}>
                                            Perjalanan Kosong
                                        </option>
                                        <option value="Tunggu Muat"
                                            {{ Request::get('status_perjalanan') == 'Tunggu Muat' ? 'selected' : '' }}>
                                            Tunggu Muat
                                        </option>
                                        <option value="Perjalanan Isi"
                                            {{ Request::get('status_perjalanan') == 'Perjalanan Isi' ? 'selected' : '' }}>
                                            Perjalanan Isi
                                        </option>
                                        <option value="Tunggu Bongkar"
                                            {{ Request::get('status_perjalanan') == 'Tunggu Bongkar' ? 'selected' : '' }}>
                                            Tunggu Bongkar
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
                            </div> --}}
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
                        <table id="aksesTable" class="table table-bordered table-striped table-hover"
                            style="font-size: 10px; min-width: 1000px;">
                            <thead class="thead-custom">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>No Kabin</th>
                                    <th>No. Pol</th>
                                    <th>Nama Driver</th>
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
                                @foreach ($pengambilan_do as $pengambilan)
                                    <tr>
                                        <td style="width: 1%" class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $pengambilan->kendaraan->no_kabin ?? null }}</td>
                                        <td>{{ $pengambilan->kendaraan->no_pol ?? null }}</td>
                                        <td>{{ $pengambilan->spk->nama_driver ?? null }}</td>
                                        <td>{{ $pengambilan->spk->pelanggan->nama_pell ?? null }}</td>
                                        <td>{{ $pengambilan->spk->nama_rute ?? null }}</td>
                                        <td>{{ $pengambilan->kendaraan->status_perjalanan ?? null }}</td>
                                        <td>
                                            @if ($pengambilan->kendaraan->status_kendaraan == 2)
                                                <span style="font-size: 10px" class="badge badge-success">Perjalanan</span>
                                            @else
                                                <span style="font-size: 10px" class="badge badge-info">Parkir</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $pengambilan->kendaraan->lokasi ?? null }}
                                        </td>
                                        <td>
                                            <a href="https://maps.google.com/maps?q={{ $pengambilan->kendaraan->latitude }},{{ $pengambilan->kendaraan->longitude }}"
                                                class="btn btn-secondary btn-sm" id="btn-update-latlong" target="_blank"
                                                onclick="updateLatLong({{ $pengambilan->kendaraan->id }}); return false;"
                                                style="display: inline-block; background-color: transparent; /* Membuat latar belakang transparan */ color: transparent; padding: 0; border: none; /* Menghapus border */ text-align: center; text-decoration: none;">
                                                <img src="{{ asset('storage/uploads/user/map.png') }}" alt="Peta"
                                                    style="width: 30px; height: 30px; object-fit: contain; display: block; margin: 0 auto;">
                                            </a>
                                            <span hidden id="lokasi-saat-ini">{{ $pengambilan->kendaraan->latitude }},
                                                {{ $pengambilan->kendaraan->longitude }}</span> <!-- Lokasi terbaru -->
                                        </td>
                                        <td>
                                            @if ($pengambilan->kendaraan->status_perjalanan != 'Kosong')
                                                @if ($pengambilan->kendaraan->status_perjalanan)
                                                    {{ $pengambilan->kendaraan->timer }}
                                                @else
                                                    00.00
                                                @endif
                                            @else
                                                {{ $pengambilan->kendaraan->timer }}
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
            form.action = "{{ url('pelanggan/monitoring-kendaraan') }}";

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
            fetch(`{{ url('pelanggan/monitoring/update_latlong') }}/${kendaraanId}`, {
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
                        // Tampilkan SweetAlert jika gagal memperbarui lokasi
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Gagal memperbarui lokasi!',
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Tampilkan SweetAlert jika terjadi kesalahan saat memperbarui lokasi
                    Swal.fire({
                        icon: 'error',
                        title: 'Kesalahan!',
                        text: 'Terjadi kesalahan saat memperbarui lokasi.',
                        confirmButtonText: 'OK'
                    });
                });
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- <script>
        function updateLatLong(kendaraanId) {
            // Memanggil API menggunakan AJAX untuk memperbarui koordinat
            fetch(`{{ url('pelanggan/monitoring/update_latlong') }}/${kendaraanId}`, {
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
 --}}

    <script>
        const tableContainer = document.querySelector('.table-responsive');

        let isDown = false;
        let startX;
        let scrollLeft;

        tableContainer.addEventListener('mousedown', (e) => {
            isDown = true;
            tableContainer.classList.add('active');
            startX = e.pageX - tableContainer.offsetLeft;
            scrollLeft = tableContainer.scrollLeft;
        });

        tableContainer.addEventListener('mouseleave', () => {
            isDown = false;
            tableContainer.classList.remove('active');
        });

        tableContainer.addEventListener('mouseup', () => {
            isDown = false;
            tableContainer.classList.remove('active');
        });

        tableContainer.addEventListener('mousemove', (e) => {
            if (!isDown) return; // stop the fn from running
            e.preventDefault();
            const x = e.pageX - tableContainer.offsetLeft;
            const walk = (x - startX) * 2; // the multiplier is for speed
            tableContainer.scrollLeft = scrollLeft - walk;
        });
    </script>

    {{-- sudah benar  --}}
    <script>
        $(document).ready(function() {
            // Inisialisasi DataTables
            $('#aksesTable').DataTable({
                "paging": false, // Menonaktifkan pagination
                "ordering": true,
                "info": true,
                "order": [], // Nonaktifkan pengurutan awal pada semua kolom
                "columnDefs": [{
                        "orderable": false,
                        "targets": 0
                    } // Nonaktifkan pengurutan untuk kolom No
                ],
                "language": {
                    "search": "Search: ",
                    "searchPlaceholder": ""
                },
                "drawCallback": function(settings) {
                    var api = this.api();
                    // Mengatur ulang nomor urut pada setiap refresh (filter/pagination)
                    api.column(0, {
                        order: 'applied'
                    }).nodes().each(function(cell, i) {
                        cell.innerHTML = i + 1;
                    });
                }
            });
        });
    </script>

@endsection
