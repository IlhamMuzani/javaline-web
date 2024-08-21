@extends('layouts.app')

@section('title', 'Status Perjalanan Kendaraan')

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
                            <div class="col-md-4 col-sm-12">
                                {{-- <div class="input-group mb-2"> --}}
                                <div class="form-group">
                                    <select class="custom-select form-control" id="status_perjalanan"
                                        name="status_perjalanan">
                                        <option value="">- Semua Status -</option>
                                        <option value="Tunggu Muat"
                                            {{ Request::get('status_perjalanan') == 'Tunggu Muat' ? 'selected' : '' }}>
                                            Tunggu Muat
                                        </option>
                                        <option value="Loading Muat"
                                            {{ Request::get('status_perjalanan') == 'Loading Muat' ? 'selected' : '' }}>
                                            Loading Muat
                                        </option>
                                        <option value="Perjalanan Isi"
                                            {{ Request::get('status_perjalanan') == 'Perjalanan Isi' ? 'selected' : '' }}>
                                            Perjalanan Isi
                                        </option>
                                        <option value="Tunggu Bongkar"
                                            {{ Request::get('status_perjalanan') == 'Tunggu Bongkar' ? 'selected' : '' }}>
                                            Tunggu Bongkar
                                        </option>
                                        <option value="Loading Bongkar"
                                            {{ Request::get('status_perjalanan') == 'Loading Bongkar' ? 'selected' : '' }}>
                                            Loading Bongkar
                                        </option>
                                        <option value="Kosong"
                                            {{ Request::get('status_perjalanan') == 'Kosong' ? 'selected' : '' }}>
                                            Kosong
                                        </option>
                                        <option value="Perjalanan Kosong"
                                            {{ Request::get('status_perjalanan') == 'Perjalanan Kosong' ? 'selected' : '' }}>
                                            Perjalanan Kosong
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
                                <select class="select2bs4 select2-hidden-accessible" name="kendaraan_id"
                                    data-placeholder="Cari Kode.." style="width: 100%;" data-select2-id="23" tabindex="-1"
                                    aria-hidden="true" id="kendaraan_id">
                                    <option value="">- Pilih -</option>
                                    @foreach ($kendaraans as $kendaraan)
                                        <option value="{{ $kendaraan->id }}"
                                            {{ Request::get('kendaraan_id') == $kendaraan->id ? 'selected' : '' }}>
                                            {{ $kendaraan->no_kabin }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="status">(Cari Kendaraan)</label>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-primary" onclick="cari()">
                                        <i class="fas fa-search"></i> Cari
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <table id="datatables66" class="table table-bordered table-striped table-hover" style="font-size: 13px">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center">No</th>
                                <th>No. Kabin</th>
                                <th>No. Registrasi</th>
                                <th>Nama Driver</th>
                                <th>Tujuan</th>
                                <th>Pelanggan</th>
                                <th>Status Kendaraan</th>
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
                                    <td>
                                        @if ($kendaraan->pengambilan_do->last())
                                            {{ $kendaraan->pengambilan_do->last()->spk->user->karyawan->nama_lengkap ?? 'tidak ada' }}
                                        @else
                                            tidak ada
                                        @endif
                                    </td>
                                    <td>
                                        @if ($kendaraan->pengambilan_do->last())
                                            {{ $kendaraan->pengambilan_do->last()->rute_perjalanan->nama_rute ?? 'tidak ada' }}
                                        @else
                                            tidak ada
                                        @endif
                                    </td>
                                    <td>
                                        @if ($kendaraan->pengambilan_do->last())
                                            {{ $kendaraan->pengambilan_do->last()->spk->pelanggan->nama_pell ?? 'belum ada' }}
                                        @else
                                            tidak ada
                                        @endif
                                    </td>

                                    <td>
                                        @if ($kendaraan->status_perjalanan)
                                            {{ $kendaraan->status_perjalanan }}
                                        @else
                                            Kosong
                                        @endif
                                    </td>
                                    <td>
                                        @if ($kendaraan->status_perjalanan)
                                            {{ $kendaraan->timer }}
                                        @else
                                            00.00
                                        @endif
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        </div>
    </section>

    <script>
        var form = document.getElementById('form-action');

        function cari() {
            form.action = "{{ url('admin/status_perjalanan') }}";
            form.submit();
        }
    </script>
@endsection
