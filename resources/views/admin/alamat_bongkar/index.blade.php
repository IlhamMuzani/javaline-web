@extends('layouts.app')

@section('title', 'Tujuan Bongkar')

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
                    <h1 class="m-0">Tujuan Bongkar</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Tujuan Bongkar</li>
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
                    <h3 class="card-title">Tujuan Bongkar</h3>
                    <div class="float-right">
                        <a href="{{ url('admin/alamat_bongkar/create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah
                        </a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="datatables66" class="table table-bordered table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center">No</th>
                                <th>Kode Tujuan</th>
                                <th>Nama Pelanggan</th>
                                <th>Tujuan Bongkar</th>
                                <th>Maps</th>
                                <th class="text-center" width="90">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($alamatbongkars as $alamatbongkar)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $alamatbongkar->kode_alamat }}
                                    </td>
                                    <td>{{ $alamatbongkar->pelanggan->nama_pell ?? 'tidak ada' }}
                                    </td>

                                    <td>{{ $alamatbongkar->alamat }}
                                    </td>
                                    <td>
                                        <a href="https://www.google.com/maps/search/?api=1&query={{ $alamatbongkar->latitude }},{{ $alamatbongkar->longitude }}"
                                            class="btn btn-secondary btn-sm" target="_blank"
                                            style="padding: 0; border: none; text-align: center; text-decoration: none;">
                                            <img src="{{ asset('storage/uploads/user/map.png') }}" alt="Peta"
                                                style="width: 30px; height: 30px; object-fit: contain; display: block; margin: 0 auto;">
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        {{-- @if (auth()->check() && auth()->user()->fitur['biaya update']) --}}
                                        <a href="{{ url('admin/alamat_bongkar/' . $alamatbongkar->id . '/edit') }}"
                                            class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        {{-- @endif --}}
                                        {{-- @if (auth()->check() && auth()->user()->fitur['biaya delete']) --}}
                                        <button type="submit" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#modal-hapus-{{ $alamatbongkar->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        {{-- @endif --}}
                                    </td>
                                </tr>
                                <div class="modal fade" id="modal-hapus-{{ $alamatbongkar->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Hapus alamat</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Yakin hapus alamat
                                                    <strong>{{ $alamatbongkar->nama_type }}</strong>?
                                                </p>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Batal</button>
                                                <form action="{{ url('admin/alamat_bongkar/' . $alamatbongkar->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
