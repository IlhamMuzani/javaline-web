@extends('layouts.app')

@section('title', 'Data Pengurus')

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
                    <h1 class="m-0">Data Pengurus</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Data Pengurus</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    {{-- <section class="content" style="display: none;" id="mainContentSection"> --}}
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
                    <h3 class="card-title">Data Pengurus</h3>
                    <div class="float-right">
                        {{-- <a href="{{ url('admin/karyawan/create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Tambah
                            </a> --}}
                    </div>
                </div>
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center">No</th>
                                <th>Kode Pengurus</th>
                                <th>Nama</th>
                                <th>Telepon</th>
                                <th>Post</th>
                                <th class="text-center" width="150">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($karyawans as $karyawan)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $karyawan->user->first()->kode_user ?? null }}</td>
                                    <td>{{ $karyawan->nama_lengkap }}</td>
                                    <td>{{ $karyawan->telp }}</td>
                                    <td>{{ $karyawan->post->nama_post ?? null }}</td>
                                    <td class="text-center">
                                        <button type="submit" class="btn btn-warning btn-sm" data-toggle="modal"
                                            data-target="#modal-update-{{ $karyawan->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                                <div class="modal fade" id="modal-update-{{ $karyawan->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Ubah Post Pengurus</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ url('admin/pengurus/' . $karyawan->id) }}" method="POST">
                                                @csrf
                                                @method('put')
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="post_id">Post</label>
                                                        <select class="custom-select form-control" id="post_id"
                                                            name="post_id">
                                                            <option value="">- Pilih Post -</option>
                                                            @foreach ($posts as $post)
                                                                <option value="{{ $post->id }}"
                                                                    {{ old('post_id', $karyawan->post_id) == $post->id ? 'selected' : '' }}>
                                                                    {{ $post->nama_post }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="card-footer text-right">
                                                    <button style="margin-right:10px" type="button" class="btn btn-default"
                                                        data-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary"
                                                        id="btnSimpan">Simpan</button>
                                                    <div id="loading" style="display: none;">
                                                        <i class="fas fa-spinner fa-spin"></i> Sedang Menyimpan...
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(function() {
                document.getElementById("loadingSpinner").style.display = "none";
                document.getElementById("mainContent").style.display = "block";
                document.getElementById("mainContentSection").style.display = "block";
            }, 100); // Adjust the delay time as needed
        });
    </script>
@endsection
