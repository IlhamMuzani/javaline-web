@extends('layouts.app')

@section('title', 'Laporan Absensi')

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
                    <h1 class="m-0">Laporan Absensi</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Laporan Absensi</li>
                    </ol>
                </div><!-- /.col -->
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
                        <i class="icon fas fa-check"></i> Berhasil!
                    </h5>
                    {{ session('success') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Laporan Absensi</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="GET" id="form-action">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="status">Cari Karyawan</label>
                                <select class="select2bs4 select2-hidden-accessible" name="karyawan_id"
                                    data-placeholder="Cari Karyawan.." style="width: 100%;" id="karyawan_id">
                                    <option value="">- Pilih -</option>
                                    @foreach ($karyawans as $karyawan)
                                        <option value="{{ $karyawan->id }}"
                                            {{ Request::get('karyawan_id') == $karyawan->id ? 'selected' : '' }}>
                                            {{ $karyawan->nama_lengkap }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="tanggal_awal">Tanggal Awal</label>
                                <input class="form-control" id="tanggal_awal" name="tanggal_awal" type="date"
                                    value="{{ Request::get('tanggal_awal') }}" max="{{ date('Y-m-d') }}" />
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="tanggal_akhir">Tanggal Akhir</label>
                                <input class="form-control" id="tanggal_akhir" name="tanggal_akhir" type="date"
                                    value="{{ Request::get('tanggal_akhir') }}" max="{{ date('Y-m-d') }}" />
                            </div>

                            <div class="col-md-3 mb-3">
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
                    <div class="table-responsive" style="overflow-x: auto;">
                        <table id="datatables66" class="table table-bordered table-striped table-hover"
                            style="font-size: 13px">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Tanggal</th>
                                    <th>Waktu</th>
                                    <th>Nama Karyawan</th>
                                    <th>Foto</th>
                                    <th>Radius Absensi</th>
                                    <th>Lokasi Absensi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inquery as $absen)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $absen->tanggal_awal }}</td>
                                        <td>{{ $absen->waktu }}</td>
                                        <td>
                                            {{ $absen->user->karyawan->nama_lengkap ?? null }}
                                        </td>
                                        <td data-toggle="modal" data-target="#modal-stnk-{{ $absen->id }}"
                                            class="text-center">
                                            @if ($absen->gambar)
                                                <img src="{{ asset('storage/uploads/' . $absen->gambar) }}" width="50"
                                                    height="50">
                                            @else
                                                <img src="{{ asset('adminlte/dist/img/img-placeholder.jpg') }}"
                                                    width="50" height="50">
                                            @endif
                                        </td>
                                        <td>
                                            @if ($absen->jarak_absen == null)
                                            @else
                                                {{ $absen->jarak_absen }} m
                                            @endif
                                        </td>
                                        <td>
                                            <a href="https://www.google.com/maps/search/?api=1&query={{ $absen->latitude }},{{ $absen->longitude }}"
                                                class="btn btn-secondary btn-sm" target="_blank"
                                                style="padding: 0; border: none; text-align: center; text-decoration: none;">
                                                <img src="{{ asset('storage/uploads/user/map.png') }}" alt="Peta"
                                                    style="width: 30px; height: 30px; object-fit: contain; display: block; margin: 0 auto;">
                                            </a>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="modal-stnk-{{ $absen->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Foto</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">

                                                    <div style="text-align: center;">
                                                        {{-- <p style="font-size:15px; font-weight: bold;">
                                                            {{ $absen->kode_karyawan }}</p> --}}
                                                        <div style="display: inline-block;">
                                                            @if ($absen->gambar)
                                                                <style>
                                                                    .portrait-img {
                                                                        width: auto;
                                                                        height: 450px;
                                                                        /* Adjust this value to your desired height */
                                                                        display: block;
                                                                        margin: 0 auto;
                                                                        object-fit: cover;
                                                                    }
                                                                </style>
                                                                <img src="{{ asset('storage/uploads/' . $absen->gambar) }}"
                                                                    class="portrait-img">
                                                            @else
                                                                <img src="{{ asset('adminlte/dist/img/img-placeholder.jpg') }}"
                                                                    width="200" height="200">
                                                            @endif
                                                        </div>
                                                        {{-- <p style="font-size:15px; font-weight: bold;">
                                                            {{ $absen->no_kabin }} / {{ $absen->no_pol }}</p> --}}
                                                    </div>
                                                    {{-- <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-default"
                                                            data-dismiss="modal">Batal</button>
                                                        <a href="{{ url('admin/absen/cetak-pdfstnk/' . $absen->id) }}"
                                                            class="btn btn-primary btn-sm">
                                                            <i class=""></i> Cetak
                                                        </a>
                                                    </div> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </section>
    <!-- /.card -->
    <script>
        var tanggalAwal = document.getElementById('tanggal_awal');
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
            form.action = "{{ url('admin/laporan-absen') }}";
            form.submit();
        }

        function printReport() {
            var startDate = tanggalAwal.value;
            var endDate = tanggalAkhir.value;

            if (startDate && endDate) {
                form.action = "{{ url('admin/print-absen') }}" + "?start_date=" + startDate + "&end_date=" +
                    endDate;
                form.submit();
            } else {
                alert("Silakan isi kedua tanggal sebelum mencetak.");
            }
        }
    </script>
@endsection
