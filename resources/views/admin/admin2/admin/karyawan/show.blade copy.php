@extends('layouts.app')

@section('title', 'Lihat Karyawan')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Karyawan</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ url('admin/karyawan') }}">Karyawan</a>
                    </li>
                    <li class="breadcrumb-item active">Lihat</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Lihat Karyawan</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row">
                    <div class="col-md-5">
                        {{-- @if ($karyawan->gambar)
                                <img src="{{ asset('storage/uploads/' . $karyawan->gambar) }}"
                        class="w-100 rounded border">
                        @else
                        <img src="{{ asset('storage/uploads/karyawan/user.png') }}" class="w-100 rounded border">
                        @endif --}}
                        {{-- <img src="{{ asset('storage/uploads/' . $karyawan->gambar) }}"
                        alt="{{ $karyawan->nama_lengkap }}" class="w-100 rounded"> --}}
                        @if ($karyawan->gambar)
                        <img src="{{ asset('storage/uploads/' . $karyawan->gambar) }}"
                            alt="{{ $karyawan->nama_lengkap }}" class="w-100 rounded border">
                        @else
                        <img src="{{ asset('adminlte/dist/img/img-placeholder.jpg') }}"
                            alt="{{ $karyawan->nama_lengkap }}" class="w-100 rounded border">
                        @endif
                    </div>
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Qr Code</strong>
                            </div>
                            <div class="col-md-4">
                                <div data-toggle="modal" data-target="#modal-qrcode-{{ $karyawan->id }}"
                                    style="display: inline-block;">
                                    {!! DNS2D::getBarcodeHTML("$karyawan->qrcode_karyawan", 'QRCODE', 3, 3) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Kode Karyawan</strong>
                            </div>
                            <div class="col-md-4">
                                {{ $karyawan->kode_karyawan }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Departemen</strong>
                            </div>
                            <div class="col-md-4">
                                {{ $karyawan->departemen->nama }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>No KTP</strong>
                            </div>
                            <div class="col-md-4">
                                {{ $karyawan->no_ktp }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>No SIM</strong>
                            </div>
                            <div class="col-md-4">
                                {{ $karyawan->no_sim }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Gender</strong>
                            </div>
                            <div class="col-md-4">
                                @if ($karyawan->gender == 'L')
                                <td>Laki-Laki</td>
                                @else
                                <td>Perempuan</td>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Telepon</strong>
                            </div>
                            <div class="col-md-4">
                                {{ $karyawan->telp }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Alamat</strong>
                            </div>
                            <div class="col-md-4">
                                {{ $karyawan->alamat }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Tanggal Lahir</strong>
                            </div>
                            <div class="col-md-4">
                                {{ $karyawan->tanggal_lahir }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Tanggal Gabung</strong>
                            </div>
                            <div class="col-md-4">
                                {{ $karyawan->tanggal_gabung }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Jabatan</strong>
                            </div>
                            <div class="col-md-4">
                                {{ $karyawan->jabatan }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modal-qrcode-{{ $karyawan->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Gambar QR Code</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            {{-- <p>Yakin hapus kendaraan
                                                    <strong>{{ $kendaraan->kode_kendaraan }}</strong>?
                            </p> --}}
                            <div style="text-align: center;">
                                <div style="display: inline-block;">
                                    {!! DNS2D::getBarcodeHTML("$karyawan->qrcode_karyawan", 'QRCODE', 15, 15) !!}
                                </div>
                                {{-- <br>
                                                    AE - {{ $karyawan->qrcode_karyawan }} --}}
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                {{-- <form action="{{ url('admin/ban/' . $golongan->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary">Cetak</button>
                                </form> --}}
                                <a href="{{ url('admin/karyawan/cetak-pdf/' . $karyawan->id) }}"
                                    class="btn btn-primary btn-sm">
                                    <i class=""></i> Cetak
                                </a>
                                {{-- <a href="{{ url('admin/cetak-pdf/' . $golongan->id) }}" target="_blank"
                                class="btn btn-outline-primary btn-sm float-end">
                                <i class="fa-solid fa-print"></i> Cetak PDV
                                </a> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection