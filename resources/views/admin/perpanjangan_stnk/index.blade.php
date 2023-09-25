@extends('layouts.app')

@section('title', 'Perpanjangan No. Stnk')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
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
                    <h3 class="card-title">Perpanjangan No. Stnk</h3>
                    {{-- <div class="float-right">
                        <a href="{{ url('admin/stnk/create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah
                        </a>
                    </div> --}}
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Kode</th>
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
                                            <a href="{{ url('admin/perpanjangan_stnk/' . $stnk->id . '/edit') }}"
                                                class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ url('admin/perpanjangan_stnk/checkpost/' . $stnk->id) }}"
                                                class="btn btn-success btn-sm">
                                                <i class="fas fa-check"></i>
                                            </a>
                                        @else
                                            <a href="{{ url('admin/perpanjangan_stnk/' . $stnk->id . '/edit') }}"
                                                class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endif
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
