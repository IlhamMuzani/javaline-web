@extends('layouts.app')

@section('title', 'Inquery Pengambilan DO')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Inquery Pengambilan DO</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/pengambilan_do') }}">Pengambilan DO</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <style>
        #map {
            height: 400px;
            width: 100%;
        }
    </style>
    <section class="content">
        <div class="container-fluid">
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-ban"></i> Gagal!
                    </h5>
                    @foreach (session('error') as $error)
                        - {{ $error }} <br>
                    @endforeach
                </div>
            @endif
            @if (session('erorrss'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-ban"></i> Gagal!
                    </h5>
                    {{ session('erorrss') }}
                </div>
            @endif

            @if (session('error_pelanggans') || session('error_pesanans'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-ban"></i> Gagal!
                    </h5>
                    @if (session('error_pelanggans'))
                        @foreach (session('error_pelanggans') as $error)
                            - {{ $error }} <br>
                        @endforeach
                    @endif
                    @if (session('error_pesanans'))
                        @foreach (session('error_pesanans') as $error)
                            - {{ $error }} <br>
                        @endforeach
                    @endif
                </div>
            @endif
            <form action="{{ url('admin/inquery_pengambilando/' . $inquery->id) }}" method="POST"
                enctype="multipart/form-data" autocomplete="off">
                @method('put')
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Perbarui Pengambilan DO</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group">
                            <label style="font-size: 14px" for="">Id</label>
                            <input style="font-size:14px" readonly type="text" class="form-control" id="id"
                                name="id" value="{{ old('id', $inquery->id) }}">
                        </div>
                        <div class="form-group">
                            <label style="font-size: 14px" for="">User_id</label>
                            <input style="font-size:14px" readonly type="text" class="form-control" id="user_id"
                                name="user_id" value="{{ old('user_id', $inquery->user_id) }}">
                        </div>
                        <div class="form-group">
                            <label style="font-size: 14px" for="">Spk_id</label>
                            <input style="font-size:14px" readonly type="text" class="form-control" id="spk_id"
                                name="spk_id" value="{{ old('spk_id', $inquery->spk_id) }}">
                        </div>
                        <div class="form-group">
                            <label style="font-size: 14px" for="">Km Awal</label>
                            <input style="font-size:14px" type="text" class="form-control" id="km_awal" name="km_awal"
                                value="{{ old('km_awal', $inquery->km_awal) }}">
                        </div>
                        <div class="form-group">
                            <label style="font-size: 14px" for="">Km Akhir</label>
                            <input style="font-size:14px" type="text" class="form-control" id="km_akhir" name="km_akhir"
                                value="{{ old('km_akhir', $inquery->km_akhir) }}">
                        </div>
                        <div class="form-group">
                            <label style="font-size: 14px" for="">Waktu Awal</label>
                            <input style="font-size:14px" type="text" class="form-control" id="waktu_awal"
                                name="waktu_awal" value="{{ old('waktu_awal', $inquery->waktu_awal) }}">
                        </div>
                        <div class="form-group">
                            <label style="font-size: 14px" for="">Waktu AKhir</label>
                            <input style="font-size:14px" type="text" class="form-control" id="waktu_akhir"
                                name="waktu_akhir" value="{{ old('waktu_akhir', $inquery->waktu_akhir) }}">
                        </div>
                        <div class="form-group">
                            <label style="font-size: 14px" for="">Kendaraan_id</label>
                            <input style="font-size:14px" type="text" class="form-control" id="kendaraan_id"
                                name="kendaraan_id" value="{{ old('kendaraan_id', $inquery->kendaraan_id) }}">
                        </div>
                        <div class="form-group">
                            <label style="font-size: 14px" for="">Rute Perjalanan Id</label>
                            <input style="font-size:14px" type="text" class="form-control" id="rute_perjalanan_id"
                                name="rute_perjalanan_id"
                                value="{{ old('rute_perjalanan_id', $inquery->rute_perjalanan_id) }}">
                        </div>
                        <div class="form-group">
                            <label style="font-size: 14px" for="">Alamat Muat Id</label>
                            <input style="font-size:14px" type="text" class="form-control" id="alamat_muat_id"
                                name="alamat_muat_id" value="{{ old('alamat_muat_id', $inquery->alamat_muat_id) }}">
                        </div>
                        <div class="form-group">
                            <label style="font-size: 14px" for="">Alamat Bongkar Id</label>
                            <input style="font-size:14px" type="text" class="form-control" id="alamat_bongkar_id"
                                name="alamat_bongkar_id"
                                value="{{ old('alamat_bongkar_id', $inquery->alamat_bongkar_id) }}">
                        </div>
                        <div class="form-group">
                            <label style="font-size: 14px" for="">Kode Pengambilan</label>
                            <input style="font-size:14px" type="text" class="form-control" id="kode_pengambilan"
                                name="kode_pengambilan"
                                value="{{ old('kode_pengambilan', $inquery->kode_pengambilan) }}">
                        </div>
                        <div class="form-group">
                            <label style="font-size: 14px" for="">Tanggal</label>
                            <input style="font-size:14px" type="text" class="form-control" id="tanggal"
                                name="tanggal" value="{{ old('tanggal', $inquery->tanggal) }}">
                        </div>

                        <div class="form-group">
                            <label for="gambar">
                                Gambar
                                <small>(kosongkan saja jika tidak ingin diubah)</small>
                            </label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="gambar" name="gambar"
                                    accept="image/*">
                                <label class="custom-file-label" for="gambar">Pilih Gambar</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="gambar2">
                                Gambar2
                                <small>(kosongkan saja jika tidak ingin diubah)</small>
                            </label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="gambar2" name="gambar2"
                                    accept="image/*">
                                <label class="custom-file-label" for="gambar2">Pilih Gambar</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="gambar3">
                                Gambar3
                                <small>(kosongkan saja jika tidak ingin diubah)</small>
                            </label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="gambar3" name="gambar3"
                                    accept="image/*">
                                <label class="custom-file-label" for="gambar3">Pilih Gambar</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="bukti">
                                Bukti
                                <small>(kosongkan saja jika tidak ingin diubah)</small>
                            </label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="bukti" name="bukti"
                                    accept="image/*">
                                <label class="custom-file-label" for="bukti">Pilih Gambar</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="bukti2">
                                Bukti2
                                <small>(kosongkan saja jika tidak ingin diubah)</small>
                            </label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="bukti2" name="bukti2"
                                    accept="image/*">
                                <label class="custom-file-label" for="bukti2">Pilih Gambar</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="bukti3">
                                Bukti3
                                <small>(kosongkan saja jika tidak ingin diubah)</small>
                            </label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="bukti3" name="bukti3"
                                    accept="image/*">
                                <label class="custom-file-label" for="bukti3">Pilih Gambar</label>
                            </div>
                        </div>


                        <div class="form-group">
                            <label style="font-size: 14px" for="">Tanggal Awal</label>
                            <input style="font-size:14px" type="text" class="form-control" id="tanggal_awal"
                                name="tanggal_awal" value="{{ old('tanggal_awal', $inquery->tanggal_awal) }}">
                        </div>
                        <div class="form-group">
                            <label style="font-size: 14px" for="">Tanggal Akhir</label>
                            <input style="font-size:14px" type="text" class="form-control" id="tanggal_akhir"
                                name="tanggal_akhir" value="{{ old('tanggal_akhir', $inquery->tanggal_akhir) }}">
                        </div>
                        <div class="form-group">
                            <label style="font-size: 14px" for="">Latitude</label>
                            <input style="font-size:14px" type="text" class="form-control" id="latitude"
                                name="latitude" value="{{ old('latitude', $inquery->latitude) }}">
                        </div>
                        <div class="form-group">
                            <label style="font-size: 14px" for="">Longitude</label>
                            <input style="font-size:14px" type="text" class="form-control" id="longitude"
                                name="longitude" value="{{ old('longitude', $inquery->longitude) }}">
                        </div>
                        <div class="form-group">
                            <label style="font-size: 14px" for="">Waktu Surat Awal</label>
                            <input style="font-size:14px" type="text" class="form-control" id="waktu_suratawal"
                                name="waktu_suratawal" value="{{ old('waktu_suratawal', $inquery->waktu_suratawal) }}">
                        </div>
                        <div class="form-group">
                            <label style="font-size: 14px" for="">Waktu Surat Akhir</label>
                            <input style="font-size:14px" type="text" class="form-control" id="waktu_suratakhir"
                                name="waktu_suratakhir"
                                value="{{ old('waktu_suratakhir', $inquery->waktu_suratakhir) }}">
                        </div>
                        <div class="form-group">
                            <label style="font-size: 14px" for="">Status Surat Jalan</label>
                            <input style="font-size:14px" type="text" class="form-control" id="status_suratjalan"
                                name="status_suratjalan"
                                value="{{ old('status_suratjalan', $inquery->status_suratjalan) }}">
                        </div>
                        <div class="form-group">
                            <label style="font-size: 14px" for="">Status</label>
                            <input style="font-size:14px" type="text" class="form-control" id="status"
                                name="status" value="{{ old('status', $inquery->status) }}">
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="reset" class="btn btn-secondary" id="btnReset">Reset</button>
                        <button type="submit" class="btn btn-primary" id="btnSimpan">Simpan</button>
                        <div id="loading" style="display: none;">
                            <i class="fas fa-spinner fa-spin"></i> Sedang Menyimpan...
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

@endsection
