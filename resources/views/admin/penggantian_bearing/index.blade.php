@extends('layouts.app')

@section('title', 'Penggantian Bearing')

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
                    <h1 class="m-0">Penggantian Bearing</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Penggantian Bearing</li>
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
                        <i class="icon fas fa-check"></i> Success!
                    </h5>
                    {{ session('success') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Penggantian Bearing</h3>
                    {{-- <div class="float-right">
                        <a href="{{ url('admin/kendaraan/create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah
                        </a>
                    </div> --}}
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="datatables66" class="table table-bordered table-striped table-hover" style="font-size: 13px">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center">No</th>
                                <th>Kode Kendaraan</th>
                                <th>No. Kabin</th>
                                <th>Jenis Kendaraan</th>
                                <th>Keterangan</th>
                                <th class="text-center" width="90">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kendaraans as $kendaraan)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $kendaraan->kode_kendaraan }}</td>
                                    <td>{{ $kendaraan->no_kabin }}</td>
                                    <td>
                                        @if ($kendaraan->jenis_kendaraan)
                                            {{ $kendaraan->jenis_kendaraan->nama_jenis_kendaraan }}
                                        @else
                                            data tidak ada
                                        @endif
                                    </td>
                                    <td>
                                        @if (optional($kendaraan->bearing->first())->status_bearing1a == 'belum penggantian')
                                            <span> axle 1A
                                                <i class="fas fa-exclamation-circle" style="color: red;"></i>
                                            </span>
                                            <br>
                                        @endif
                                        @if (optional($kendaraan->bearing->first())->status_bearing1b == 'belum penggantian')
                                            <span> axle 1B
                                                <i class="fas fa-exclamation-circle" style="color: red;"></i>
                                            </span>
                                            <br>
                                        @endif
                                        @if (optional($kendaraan->bearing->first())->status_bearing2a == 'belum penggantian')
                                            <span> axle 2A
                                                <i class="fas fa-exclamation-circle" style="color: red;"></i>
                                            </span>
                                            <br>
                                        @endif
                                        @if (optional($kendaraan->bearing->first())->status_bearing2b == 'belum penggantian')
                                            <span> axle 2B
                                                <i class="fas fa-exclamation-circle" style="color: red;"></i>
                                            </span>
                                            <br>
                                        @endif
                                        @if (optional($kendaraan->bearing->first())->status_bearing3a == 'belum penggantian')
                                            <span> axle 3A
                                                <i class="fas fa-exclamation-circle" style="color: red;"></i>
                                            </span>
                                            <br>
                                        @endif
                                        @if (optional($kendaraan->bearing->first())->status_bearing3b == 'belum penggantian')
                                            <span> axle 3B
                                                <i class="fas fa-exclamation-circle" style="color: red;"></i>
                                            </span>
                                            <br>
                                        @endif

                                        @if (in_array($kendaraan->jenis_kendaraan->total_ban, [18, 22]))
                                            @if (optional($kendaraan->bearing->first())->status_bearing4a == 'belum penggantian')
                                                <span> axle 4A
                                                    <i class="fas fa-exclamation-circle" style="color: red;"></i>
                                                </span>
                                                <br>
                                            @endif

                                            @if (optional($kendaraan->bearing->first())->status_bearing4b == 'belum penggantian')
                                                <span> axle 4B
                                                    <i class="fas fa-exclamation-circle" style="color: red;"></i>
                                                </span>
                                                <br>
                                            @endif

                                            @if (optional($kendaraan->bearing->first())->status_bearing5a == 'belum penggantian')
                                                <span> axle 5A
                                                    <i class="fas fa-exclamation-circle" style="color: red;"></i>
                                                </span>
                                                <br>
                                            @endif

                                            @if (optional($kendaraan->bearing->first())->status_bearing5b == 'belum penggantian')
                                                <span> axle 5B
                                                    <i class="fas fa-exclamation-circle" style="color: red;"></i>
                                                </span>
                                                <br>
                                            @endif
                                        @endif
                                        @if ($kendaraan->jenis_kendaraan->total_ban == 22)
                                            @if (optional($kendaraan->bearing->first())->status_bearing6a == 'belum penggantian')
                                                <span> axle 6A
                                                    <i class="fas fa-exclamation-circle" style="color: red;"></i>
                                                </span>
                                                <br>
                                            @endif
                                            @if (optional($kendaraan->bearing->first())->status_bearing6b == 'belum penggantian')
                                                <span> axle 6B
                                                    <i class="fas fa-exclamation-circle" style="color: red;"></i>
                                                </span>
                                            @endif
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <a href="{{ url('admin/penggantian_bearing/' . $kendaraan->id . '/edit') }}"
                                            class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </section>
    <!-- /.card -->


@endsection
