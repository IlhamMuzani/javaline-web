@extends('layouts.app')

@section('title', 'Laporan Status Perjalanan')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                {{-- <div class="col-sm-6">
                    <h1 class="m-0">Status Perjalanan Kendaraan</h1>
                </div><!-- /.col --> --}}
                {{-- <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Status Perjalanan Kendaraan</li>
                    </ol>
                </div><!-- /.col --> --}}
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
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
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Laporan Status Perjalanan</h3>
                    {{-- <div class="float-right">
                        <a href="{{ url('admin/ban/create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah
                        </a>
                    </div> --}}
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    {{-- <form method="GET" id="form-action">
                        <div class="form-row">
                            <div class="col-md-4 col-sm-12">
                                <div class="input-group mb-2">
                                    <select class="custom-select form-control mr-2" id="status_perjalanan"
                                        name="status_perjalanan">
                                        <option value="">- Semua Status -</option>
                                        <option value="Tunggu Muat"
                                            {{ Request::get('status_perjalanan') == 'stok' ? 'selected' : '' }}>
                                            Tunggu Muat</option>
                                        <option value="Loading Muat"
                                            {{ Request::get('status_perjalanan') == 'aktif' ? 'selected' : '' }}>
                                            Loading Muat</option>
                                        <option value="Perjalanan Isi"
                                            {{ Request::get('status_perjalanan') == 'aktif' ? 'selected' : '' }}>
                                            Perjalanan Isi</option>
                                        <option value="Tunggu Bongkar"
                                            {{ Request::get('status_perjalanan') == 'aktif' ? 'selected' : '' }}>
                                            Tunggu Bongkar</option>
                                        <option value="Loading Bongkar"
                                            {{ Request::get('status_perjalanan') == 'aktif' ? 'selected' : '' }}>
                                            Loading Bongkar</option>
                                        <option value="Perjalanan Kosong"
                                            {{ Request::get('status_perjalanan') == 'aktif' ? 'selected' : '' }}>
                                            Perjalanan Kosong</option>
                                        <option value="Perbaikan di jalan"
                                            {{ Request::get('status_perjalanan') == 'aktif' ? 'selected' : '' }}>
                                            Perbaikan di jalan</option>
                                        <option value="Perbaikan di garasi"
                                            {{ Request::get('status_perjalanan') == 'aktif' ? 'selected' : '' }}>
                                            Perbaikan di garasi</option>
                                        </option>
                                    </select>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-outline-primary" onclick="cari()">
                                            <i class="fas fa-search"></i> Cari
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form> --}}
                    <form method="GET" id="form-action">
                        <div class="row">
                            <div class="col-md-5 mb-3">
                                <label for="tanggal_awalperjalanan">Tanggal Awal</label>
                                <input class="form-control" id="tanggal_awalperjalanan" name="tanggal_awalperjalanan"
                                    type="date" value="{{ Request::get('tanggal_awalperjalanan') }}"
                                    max="{{ date('Y-m-d') }}" />
                            </div>
                            <div class="col-md-5 mb-3">
                                <label for="tanggal_akhir">Tanggal Akhir</label>
                                <input class="form-control" id="tanggal_akhir" name="tanggal_akhir" type="date"
                                    value="{{ Request::get('tanggal_akhir') }}" max="{{ date('Y-m-d') }}" />
                            </div>
                            <div class="col-md-2 mb-3">
                                <button type="button" class="btn btn-outline-primary btn-block" onclick="cari()">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                                <button type="button" class="btn btn-primary btn-block" onclick="printReport()"
                                    target="_blank">
                                    <i class="fas fa-print"></i> Cetak
                                </button>
                            </div>
                        </div>
                    </form>
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>No. Kabin</th>
                                <th>No. Registrasi</th>
                                <th>Nama Driver</th>
                                <th>Tujuan</th>
                                <th>Pelanggan</th>
                                <th>Waktu Berangkat</th>
                                <th>Waktu Sampai</th>
                                <th>Waktu</th>
                                {{-- <th>Status Kendaraan</th> --}}
                                {{-- <th>Timer</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inquery as $kendaraan)
                                <?php
                                $tanggalAwal = new DateTime($kendaraan->tanggal_awalwaktuperjalanan);
                                $tanggalAkhir = new DateTime($kendaraan->tanggal_akhirwaktuperjalanan);
                                
                                // Menghitung selisih waktu antara tanggal awal dan tanggal akhir
                                $interval = $tanggalAwal->diff($tanggalAkhir);
                                
                                // Mengambil selisih hari dan jam
                                $selisihHari = $interval->days;
                                $selisihJam = $interval->h;
                                ?>

                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $kendaraan->no_kabin }}</td>
                                    <td>{{ $kendaraan->no_pol }}</td>
                                    <td>
                                        {{ $kendaraan->user->karyawan->nama_lengkap }}
                                    </td>
                                    <td>
                                        @if ($kendaraan->kota)
                                            {{ $kendaraan->kota->nama }}
                                        @else
                                            tujuan tidak ada
                                        @endif
                                    </td>
                                    <td>{{ $kendaraan->pelanggan->nama_pell }}</td>
                                    <td>{{ $kendaraan->tanggal_awalwaktuperjalanan }}</td>
                                    <td>{{ $kendaraan->tanggal_akhirwaktuperjalanan }}</td>
                                    <td>{{ $selisihHari }} hari {{ $selisihJam }} jam</td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </section>

    <script>
        var form = document.getElementById('form-action');

        var tanggalAwal = document.getElementById('tanggal_awalperjalanan');
        var tanggalAkhir = document.getElementById('tanggal_akhir');
        if (tanggalAwal.value == "") {
            tanggalAkhir.readOnly = true;
        }
        tanggalAwal.addEventListener('change', function() {
            if (this.value == "") {
                tanggalAkhir.readOnly = true;
            } else {
                tanggalAkhir.readOnly = false;
            };
            tanggalAkhir.value = "";
            var today = new Date().toISOString().split('T')[0];
            tanggalAkhir.value = today;
            tanggalAkhir.setAttribute('min', this.value);
        });
        var form = document.getElementById('form-action')

        function cari() {
            form.action = "{{ url('admin/laporan_statusperjalanan') }}";
            form.submit();
        }

        function printReport() {
            var startDate = tanggalAwal.value;
            var endDate = tanggalAkhir.value;

            if (startDate && endDate) {
                form.action = "{{ url('admin/print_laporanstatusperjalanan') }}" + "?start_date=" + startDate +
                    "&end_date=" +
                    endDate;
                form.submit();
            } else {
                alert("Silakan isi kedua tanggal sebelum mencetak.");
            }
        }
    </script>
@endsection
