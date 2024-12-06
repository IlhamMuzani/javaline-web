@extends('layouts.app')

@section('title', 'Perpanjangan No. Stnk')

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
                    <h1 class="m-0">Perpanjangan No. Stnk</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Perpanjangan No. Stnk</li>
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
                    <h3 class="card-title">Perpanjangan No. Stnk</h3>
                    {{-- <div class="float-right">
                        <a href="{{ url('admin/stnk/create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah
                        </a>
                    </div> --}}
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive" style="overflow-x: auto;">
                        <table id="datatables66" class="table table-bordered table-striped table-hover"
                            style="font-size: 13px">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Kode</th>
                                    <th>No Kabin</th>
                                    <th>No Registrasi</th>
                                    <th>Berlaku Sampai</th>
                                    <th class="text-center" width="90">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stnks as $stnk)
                                    @php
                                        $twoWeeksLater = now()->addWeeks(2);
                                        $oneMonthLater = now()->addMonth();
                                    @endphp
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $stnk->kode_stnk }}</td>
                                        <td>
                                            @if ($stnk->kendaraan)
                                                {{ $stnk->kendaraan->no_kabin }}
                                            @else
                                                No pol tidak ada
                                            @endif
                                        </td>
                                        <td>
                                            @if ($stnk->kendaraan)
                                                {{ $stnk->kendaraan->no_pol }}
                                            @else
                                                No pol tidak ada
                                            @endif
                                        </td>
                                        {{-- <td> {{ $stnk->expired_stnk }} </td> --}}
                                        <td>
                                            <span>{{ $stnk->expired_stnk }}</span>
                                            @if ($stnk->status_notif && $stnk->expired_stnk < $twoWeeksLater == true)
                                                <span class="">
                                                    <i class="fas fa-exclamation-circle" style="color: red;"></i>
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($stnk->status_notif && $stnk->expired_stnk < $oneMonthLater == false)
                                                <a href="{{ url('admin/perpanjangan_stnk/' . $stnk->id) }}"
                                                    class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye">
                                                    </i>
                                                </a>
                                                @if (auth()->check() && auth()->user()->fitur['perpanjangan stnk create'])
                                                    <a href="{{ url('admin/perpanjangan_stnk/' . $stnk->id . '/edit') }}"
                                                        class="btn btn-warning btn-sm">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endif
                                                <a href="{{ url('admin/perpanjangan_stnk/checkpost/' . $stnk->id) }}"
                                                    class="btn btn-success btn-sm">
                                                    <i class="fas fa-check"></i>
                                                </a>
                                            @else
                                                @if (auth()->check() && auth()->user()->fitur['perpanjangan stnk create'])
                                                    <a href="{{ url('admin/perpanjangan_stnk/' . $stnk->id . '/edit') }}"
                                                        class="btn btn-warning btn-sm">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endif
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
    <!-- /.card -->
@endsection
