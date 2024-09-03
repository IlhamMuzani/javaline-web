@extends('layouts.app')

@section('title', 'Surat Pemesanan Kendaraan')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Surat Pemesanan Kendaraan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/spk') }}">Surat Pemesanan Kendaraan</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <section class="content">
        <div class="container-fluid">
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-ban"></i> Gagal Menyimpan!
                    </h5>
                    @foreach (session('error') as $error)
                        - {{ $error }} <br>
                    @endforeach
                </div>
            @endif
            <form action="{{ url('admin/inquery_spk/' . $inquery->id) }}" method="POST" enctype="multipart/form-data"
                autocomplete="off">
                @csrf
                @method('put')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah SPK</h3>
                    </div>
                </div>
                <div>
                    <div>
                        <div class="row">
                            <div class="col-md-6">
                                <div id="pelangganspk" class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Pelanggan</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group" hidden>
                                            <label for="pelanggan_id">pelanggan Id</label>
                                            <input type="text" class="form-control" id="pelanggan_id" readonly
                                                name="pelanggan_id" placeholder=""
                                                value="{{ old('pelanggan_id', $inquery->pelanggan_id) }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="kode_pelanggan">kode Pelanggan</label>
                                            <input type="text" class="form-control" id="kode_pelanggan" readonly
                                                name="kode_pelanggan" placeholder=""
                                                value="{{ old('kode_pelanggan', $inquery->kode_pelanggan) }}">
                                        </div>
                                        <label style="font-size:14px" class="form-label" for="nama_pelanggan">Nama
                                            Pelanggan</label>
                                        <div class="form-group d-flex">
                                            <input onclick="showCategoryModalPelanggan(this.value)" class="form-control"
                                                id="nama_pell" name="nama_pelanggan" type="text" placeholder=""
                                                value="{{ old('nama_pelanggan', $inquery->nama_pelanggan) }}" readonly
                                                style="margin-right: 10px; font-size:14px" />
                                            <button class="btn btn-primary" type="button"
                                                onclick="showCategoryModalPelanggan(this.value)">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                        <div class="form-group">
                                            <label style="font-size:14px" for="alamat_pelanggan">Alamat</label>
                                            <input onclick="showCategoryModalPelanggan(this.value)" style="font-size:14px"
                                                type="text" class="form-control" id="alamat_pelanggan" readonly
                                                name="alamat_pelanggan" placeholder=""
                                                value="{{ old('alamat_pelanggan', $inquery->alamat_pelanggan) }}">
                                        </div>
                                        <div class="form-group">
                                            <label style="font-size:14px" for="telp_pelanggan">No. Telp</label>
                                            <input onclick="showCategoryModalPelanggan(this.value)" style="font-size:14px"
                                                type="text" class="form-control" id="telp_pelanggan" readonly
                                                name="telp_pelanggan" placeholder=""
                                                value="{{ old('telp_pelanggan', $inquery->telp_pelanggan) }}">
                                        </div>
                                        {{-- <div class="form-group" style="color:white">
                                            <label style="font-size:14px; margin-top:40px" for="telp_pelanggan">No.
                                                Telp</label>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div id="kendaraanspk" class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Kendaraan</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group" hidden>
                                            <label for="kendaraan_id">Kendaraan Id</label>
                                            <input type="text" class="form-control" id="kendaraan_id" readonly
                                                name="kendaraan_id" placeholder=""
                                                value="{{ old('kendaraan_id', $inquery->kendaraan_id) }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="no_pol">No Pol</label>
                                            <input type="text" class="form-control" id="no_pol" readonly
                                                name="no_pol" placeholder=""
                                                value="{{ old('no_pol', $inquery->no_pol) }}">
                                        </div>
                                        <label style="font-size:14px" class="form-label" for="no_kabin">No. Kabin</label>
                                        <div class="form-group d-flex">
                                            <input onclick="showCategoryModalkendaraan(this.value)" class="form-control"
                                                id="no_kabin" name="no_kabin" type="text" placeholder=""
                                                value="{{ old('no_kabin', $inquery->no_kabin) }}" readonly
                                                style="margin-right: 10px; font-size:14px" />
                                            <button class="btn btn-primary" type="button"
                                                onclick="showCategoryModalkendaraan(this.value)">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                        <div class="form-group">
                                            <label style="font-size:14px" for="golongan">Gol. Kendaraan</label>
                                            <input onclick="showCategoryModalkendaraan(this.value)" style="font-size:14px"
                                                type="text" class="form-control" id="golongan" readonly
                                                name="golongan" placeholder=""
                                                value="{{ old('golongan', $inquery->golongan) }}">
                                        </div>
                                        <div class="form-group">
                                            <label style="font-size:14px" for="km">KM Awal</label>
                                            <input onclick="showCategoryModalkendaraan(this.value)" style="font-size:14px"
                                                type="text" class="form-control" id="km" readonly
                                                name="km_awal" placeholder=""
                                                value="{{ old('km_awal', $inquery->km_awal) }}">
                                        </div>
                                        {{-- <div class="form-group">
                                            <label style="font-size:14px" for="km_akhir">KM Akhir</label>
                                            <input style="font-size:14px" type="text" class="form-control"
                                                id="km_akhir" name="km_akhir" placeholder=""
                                                value="{{ old('km_akhir', $inquery->km_akhir) }}">
                                        </div> --}}
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6" id="form_rute">
                                <div id="rutespk" class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Rute Perjalanan</h3>
                                    </div>
                                    <div class="card-body">

                                        <div class="form-group" hidden>
                                            <label for="rute_perjalanan_id">rute Id</label>
                                            <input type="text" class="form-control" id="rute_perjalanan_id" readonly
                                                name="rute_perjalanan_id" placeholder=""
                                                value="{{ old('rute_perjalanan_id', $inquery->rute_perjalanan_id) }}">
                                        </div>

                                        <label style="font-size:14px" class="form-label" for="kode_rute">Kode
                                            Rute</label>
                                        <div class="form-group d-flex">
                                            <input onclick="showCategoryModalrute(this.value)" class="form-control"
                                                id="kode_rute" name="kode_rute" type="text" placeholder=""
                                                value="{{ old('kode_rute', $inquery->kode_rute) }}" readonly
                                                style="margin-right: 10px; font-size:14px" />
                                            <button class="btn btn-primary" type="button"
                                                onclick="showCategoryModalrute(this.value)">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                        <div class="form-group">
                                            <label style="font-size:14px" for="rute_perjalanan">Rute Perjalanan</label>
                                            <input onclick="showCategoryModalrute(this.value)" style="font-size:14px"
                                                type="text" class="form-control" id="rute_perjalanan" readonly
                                                name="nama_rute" placeholder=""
                                                value="{{ old('nama_rute', $inquery->nama_rute) }}">
                                        </div>
                                        <div class="form-group">
                                            <label style="font-size:14px" for="biaya">Uang Jalan</label>
                                            <input onclick="showCategoryModalrute(this.value)" style="font-size:14px"
                                                type="text" class="form-control" id="biaya" readonly
                                                name="uang_jalan" placeholder=""
                                                value="{{ old('uang_jalan', $inquery->uang_jalan) }}">
                                        </div>
                                        <div class="form-check" style="color:white">
                                            <label class="form-check-label">
                                                .
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div id="sopirspk" class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Sopir</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group" hidden>
                                            <label for="user_id">User Id</label>
                                            <input type="text" class="form-control" id="user_id" readonly
                                                name="user_id" placeholder=""
                                                value="{{ old('user_id', $inquery->user_id) }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="kode_driver">kode Sopir</label>
                                            <input type="text" class="form-control" id="kode_driver" readonly
                                                name="kode_driver" placeholder=""
                                                value="{{ old('kode_driver', $inquery->kode_driver) }}">
                                        </div>
                                        <label style="font-size:14px" class="form-label" for="nama_driver">Nama
                                            Sopir</label>
                                        <div class="form-group d-flex">
                                            <input onclick="showCategoryModaldriver(this.value)" class="form-control"
                                                id="nama_driver" name="nama_driver" type="text" placeholder=""
                                                value="{{ old('nama_driver', $inquery->nama_driver) }}" readonly
                                                style="margin-right: 10px;font-size:14px" />
                                            <button class="btn btn-primary" type="button"
                                                onclick="showCategoryModaldriver(this.value)">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                        <div class="form-group">
                                            <label style="font-size:14px" for="telp">No. Telp</label>
                                            <input onclick="showCategoryModaldriver(this.value)" style="font-size:14px"
                                                type="tex" class="form-control" id="telp" readonly
                                                name="telp" placeholder="" value="{{ old('telp', $inquery->telp) }}">
                                        </div>
                                        <div class="form-group">
                                            <label style="font-size:14px" for="saldo_deposit">Saldo Deposit</label>
                                            <input onclick="showCategoryModaldriver(this.value)" style="font-size:14px"
                                                type="text" class="form-control" id="saldo_deposit" readonly
                                                name="saldo_deposit" placeholder=""
                                                value="{{ old('saldo_deposit', $inquery->saldo_deposit) }}">
                                        </div>
                                        <div class="form-check" style="color:white">
                                            <label class="form-check-label">
                                                .
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="alamat_jalan">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">Tujuan Muat</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group" hidden>
                                                <label for="alamat_muat_id">Tujuan Muat ID</label>
                                                <input type="text" class="form-control" id="alamat_muat_id" readonly
                                                    name="alamat_muat_id" placeholder=""
                                                    value="{{ old('alamat_muat_id', $inquery->alamat_muat->alamat_muat_id ?? null) }}">
                                            </div>

                                            <label style="font-size:14px" class="form-label" for="kode_alamatmuat">Kode
                                                Alamat Muat</label>
                                            <div class="form-group d-flex">
                                                <input onclick="showAlamatMuat(this.value)" class="form-control"
                                                    id="kode_alamatmuat" name="kode_alamatmuat" type="text"
                                                    placeholder=""
                                                    value="{{ old('kode_alamatmuat', $inquery->alamat_muat->kode_alamat ?? null) }}"
                                                    readonly style="margin-right: 10px; font-size:14px" />
                                                <button class="btn btn-primary" type="button"
                                                    onclick="showAlamatMuat(this.value)">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                            <div class="form-group">
                                                <label style="font-size:14px" for="alamat_muat">Tujuan Muat</label>
                                                <input onclick="showAlamatMuat(this.value)" style="font-size:14px"
                                                    type="text" class="form-control" id="alamat_muat" readonly
                                                    name="alamat_muat" placeholder=""
                                                    value="{{ old('alamat_muat', $inquery->alamat_muat->alamat ?? null) }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">Tujuan Bongkar</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group" hidden>
                                                <label for="alamat_bongkar_id">Tujuan Bongkar ID</label>
                                                <input type="text" class="form-control" id="alamat_bongkar_id"
                                                    readonly name="alamat_bongkar_id" placeholder=""
                                                    value="{{ old('alamat_bongkar_id', $inquery->alamat_bongkar->alamat_bongkar_id ?? null) }}">
                                            </div>
                                            <label style="font-size:14px" class="form-label"
                                                for="kode_alamatbongkar">Kode
                                                Tujuan Bongkar</label>
                                            <div class="form-group d-flex">
                                                <input onclick="showAlamatBongkar(this.value)" class="form-control"
                                                    id="kode_alamatbongkar" name="kode_alamatbongkar" type="text"
                                                    placeholder=""
                                                    value="{{ old('kode_alamatbongkar', $inquery->alamat_bongkar->kode_alamat ?? null) }}"
                                                    readonly style="margin-right: 10px; font-size:14px" />
                                                <button class="btn btn-primary" type="button"
                                                    onclick="showAlamatBongkar(this.value)">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                            <div class="form-group">
                                                <label style="font-size:14px" for="alamat_bongkar">Tujuan Bongkar</label>
                                                <input onclick="showAlamatBongkar(this.value)" style="font-size:14px"
                                                    type="text" class="form-control" id="alamat_bongkar" readonly
                                                    name="alamat_bongkar" placeholder=""
                                                    value="{{ old('alamat_bongkar', $inquery->alamat_bongkar->alamat ?? null) }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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

            <div class="modal fade" id="tableAlamatmuat" data-backdrop="static">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Data Alamat Muat</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table id="datatables2" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Kode Tujuan Muat</th>
                                        <th>Nama Pelanggan</th>
                                        <th>Alamat</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($alamat_muats as $alamat_muat)
                                        <tr
                                            onclick="getSelectedDataAlamatmuat('{{ $alamat_muat->id }}', '{{ $alamat_muat->kode_alamat }}', '{{ $alamat_muat->alamat }}')">
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $alamat_muat->kode_alamat }}</td>
                                            <td>{{ $alamat_muat->pelanggan->nama_pell ?? 'tidak ada' }}</td>
                                            <td>{{ $alamat_muat->alamat }}</td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="getSelectedDataAlamatmuat('{{ $alamat_muat->id }}', '{{ $alamat_muat->kode_pelanggan }}', '{{ $alamat_muat->alamat }}')">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="tableAlamatbongkar" data-backdrop="static">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Data Tujuan Bongkar</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table id="datatables3" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Kode Tujuan Bongkar</th>
                                        <th>Nama Pelanggan</th>
                                        <th>Alamat</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($alamat_bongkars as $alamat_bongkar)
                                        <tr
                                            onclick="getSelectedDataAlamatbongkar('{{ $alamat_bongkar->id }}', '{{ $alamat_bongkar->kode_alamat }}', '{{ $alamat_bongkar->alamat }}')">
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $alamat_bongkar->kode_alamat }}</td>
                                            <td>{{ $alamat_bongkar->pelanggan->nama_pell ?? 'tidak ada' }}</td>
                                            <td>{{ $alamat_bongkar->alamat }}</td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="getSelectedDataAlamatbongkar('{{ $alamat_bongkar->id }}', '{{ $alamat_bongkar->kode_pelanggan }}', '{{ $alamat_bongkar->alamat }}')">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="tablePelanggan" data-backdrop="static">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Data Pelanggan</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table id="datatables4" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Kode Pelanggan</th>
                                        <th>Nama Pelanggan</th>
                                        <th>Alamat</th>
                                        <th>No. Telp</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pelanggans as $pelanggan)
                                        <tr
                                            onclick="getSelectedDataPelanggan('{{ $pelanggan->id }}', '{{ $pelanggan->kode_pelanggan }}', '{{ $pelanggan->nama_pell }}', '{{ $pelanggan->alamat }}', '{{ $pelanggan->telp }}')">
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $pelanggan->kode_pelanggan }}</td>
                                            <td>{{ $pelanggan->nama_pell }}</td>
                                            <td>{{ $pelanggan->alamat }}</td>
                                            <td>{{ $pelanggan->telp }}</td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="getSelectedDataPelanggan('{{ $pelanggan->id }}', '{{ $pelanggan->kode_pelanggan }}', '{{ $pelanggan->nama_pell }}', '{{ $pelanggan->alamat }}', '{{ $pelanggan->telp }}')">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="tableRute" data-backdrop="static">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Data Rute Perjalanan</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="m-2">
                                <input type="text" id="searchInput" class="form-control" placeholder="Search...">
                            </div>
                            <div class="table-responsive scrollbar m-2">
                                <table id="tables" class="table table-bordered table-striped">
                                    <thead class="bg-200 text-900">
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th>Kode Rute</th>
                                            <th>Rute Perjalanan</th>
                                            <th>Golongan 1</th>
                                            <th>Golongan 2</th>
                                            <th>Golongan 3</th>
                                            <th>Golongan 4</th>
                                            <th>Golongan 5</th>
                                            <th>Opsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ruteperjalanans as $rute_perjalanan)
                                            <tr onclick="getSelectedDatarute('{{ $rute_perjalanan->id }}', '{{ $rute_perjalanan->kode_rute }}', '{{ $rute_perjalanan->nama_rute }}', '{{ $rute_perjalanan->golongan1 }}' , '{{ $rute_perjalanan->golongan2 }}', '{{ $rute_perjalanan->golongan3 }}', '{{ $rute_perjalanan->golongan4 }}', '{{ $rute_perjalanan->golongan5 }}', '{{ $rute_perjalanan->golongan6 }}', '{{ $rute_perjalanan->golongan7 }}', '{{ $rute_perjalanan->golongan8 }}', '{{ $rute_perjalanan->golongan9 }}', '{{ $rute_perjalanan->golongan10 }}')"
                                                class="selectable-row">
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td>{{ $rute_perjalanan->kode_rute }}
                                                </td>
                                                <td>{{ $rute_perjalanan->nama_rute }}
                                                </td>
                                                @if ($rute_perjalanan->golongan1)
                                                    <td hidden style="font-weight: bold">
                                                        {{ $rute_perjalanan->golongan1 }}
                                                    </td>
                                                @else
                                                    <td hidden>Rp.0
                                                    </td>
                                                @endif
                                                @if ($rute_perjalanan->golongan2)
                                                    <td hidden style="font-weight: bold">
                                                        {{ $rute_perjalanan->golongan2 }}
                                                    </td>
                                                @else
                                                    <td hidden>Rp.0
                                                    </td>
                                                @endif
                                                @if ($rute_perjalanan->golongan3)
                                                    <td hidden style="font-weight: bold">
                                                        {{ $rute_perjalanan->golongan3 }}
                                                    </td>
                                                @else
                                                    <td hidden>Rp.0
                                                    </td>
                                                @endif
                                                @if ($rute_perjalanan->golongan4)
                                                    <td hidden style="font-weight: bold">
                                                        {{ $rute_perjalanan->golongan4 }}
                                                    </td>
                                                @else
                                                    <td hidden>Rp.0
                                                    </td>
                                                @endif
                                                @if ($rute_perjalanan->golongan5)
                                                    <td hidden style="font-weight: bold">
                                                        {{ $rute_perjalanan->golongan5 }}
                                                    </td>
                                                @else
                                                    <td hidden>Rp.0
                                                    </td>
                                                @endif
                                                @if ($rute_perjalanan->golongan1)
                                                    <td style="font-weight: bold">Rp.
                                                        {{ number_format($rute_perjalanan->golongan1, 0, ',', '.') }}
                                                    </td>
                                                @else
                                                    <td>Rp.0
                                                    </td>
                                                @endif
                                                @if ($rute_perjalanan->golongan2)
                                                    <td style="font-weight: bold">Rp.
                                                        {{ number_format($rute_perjalanan->golongan2, 0, ',', '.') }}
                                                    </td>
                                                @else
                                                    <td>Rp.0
                                                    </td>
                                                @endif
                                                @if ($rute_perjalanan->golongan3)
                                                    <td style="font-weight: bold">Rp.
                                                        {{ number_format($rute_perjalanan->golongan3, 0, ',', '.') }}
                                                    </td>
                                                @else
                                                    <td>Rp.0
                                                    </td>
                                                @endif
                                                @if ($rute_perjalanan->golongan4)
                                                    <td style="font-weight: bold">Rp.
                                                        {{ number_format($rute_perjalanan->golongan4, 0, ',', '.') }}
                                                    </td>
                                                @else
                                                    <td>Rp.0
                                                    </td>
                                                @endif
                                                @if ($rute_perjalanan->golongan5)
                                                    <td style="font-weight: bold">Rp.
                                                        {{ $rute_perjalanan->golongan5 }}
                                                    </td>
                                                @else
                                                    <td>Rp.0
                                                    </td>
                                                @endif
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        onclick="getSelectedDatarute('{{ $rute_perjalanan->id }}', '{{ $rute_perjalanan->kode_rute }}', '{{ $rute_perjalanan->nama_rute }}', '{{ $rute_perjalanan->golongan1 }}' , '{{ $rute_perjalanan->golongan2 }}', '{{ $rute_perjalanan->golongan3 }}', '{{ $rute_perjalanan->golongan4 }}', '{{ $rute_perjalanan->golongan5 }}', '{{ $rute_perjalanan->golongan6 }}', '{{ $rute_perjalanan->golongan7 }}', '{{ $rute_perjalanan->golongan8 }}', '{{ $rute_perjalanan->golongan9 }}', '{{ $rute_perjalanan->golongan10 }}')">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="tableKendaraan" data-backdrop="static">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Data Kendaraan</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="m-2">
                                <input type="text" id="searchInputken" class="form-control" placeholder="Search...">
                            </div>
                            <div class="table-responsive scrollbar m-2">
                                <table id="tablekendaraan" class="table table-bordered table-striped">
                                    <thead class="bg-200 text-900">
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th>Kode Kendaraan</th>
                                            <th>No Kabin</th>
                                            <th>No Mobil</th>
                                            <th>Golongan</th>
                                            <th>Km</th>
                                            <th>Opsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($kendaraans as $kendaraan)
                                            <tr
                                                onclick="getSelectedDatakendaraan('{{ $kendaraan->id }}', '{{ $kendaraan->no_kabin }}', '{{ $kendaraan->no_pol }}', '{{ $kendaraan->golongan->nama_golongan }}')">
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td>{{ $kendaraan->kode_kendaraan }}</td>
                                                <td>{{ $kendaraan->no_kabin }}</td>
                                                <td>{{ $kendaraan->no_pol }}</td>
                                                <td>{{ $kendaraan->golongan->nama_golongan }}</td>
                                                <td>{{ $kendaraan->km }}</td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        onclick="getSelectedDatakendaraan('{{ $kendaraan->id }}', '{{ $kendaraan->no_kabin }}', '{{ $kendaraan->no_pol }}', '{{ $kendaraan->golongan->nama_golongan }}')">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="tableDriver" data-backdrop="static">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Data Sopir</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive scrollbar m-2">
                                <table id="datatables" class="table table-bordered table-striped">
                                    <thead class="bg-200 text-900">
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th>Kode Sopir</th>
                                            <th>Nama Sopir</th>
                                            <th>No. Telp</th>
                                            {{-- <th>Saldo Deposit</th> --}}
                                            <th>Opsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($drivers as $user)
                                            <tr
                                                onclick="getSelectedDatadriver('{{ $user->id }}', '{{ $user->karyawan->kode_karyawan }}', '{{ $user->karyawan->nama_lengkap }}', '{{ $user->karyawan->telp }}', '{{ $user->karyawan->tabungan }}')">
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td>{{ $user->karyawan->kode_karyawan }}</td>
                                                <td>{{ $user->karyawan->nama_lengkap }}</td>
                                                <td>{{ $user->karyawan->telp }}</td>
                                                {{-- <td>{{ $user->saldodp }}</td> --}}
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        onclick="getSelectedDatadriver('{{ $user->id }}', '{{ $user->karyawan->kode_karyawan }}', '{{ $user->karyawan->nama_lengkap }}', '{{ $user->karyawan->telp }}', '{{ $user->karyawan->tabungan }}')">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <script>
        function filterTableken() {
            var input, filter, table, tr, td, i, j, txtValue;
            input = document.getElementById("searchInputken");
            filter = input.value.toUpperCase();
            table = document.getElementById("tablekendaraan");
            tr = table.getElementsByTagName("tr");

            for (i = 0; i < tr.length; i++) {
                var displayRow = false;

                // Loop through columns (td 1, 2, and 3)
                for (j = 1; j <= 3; j++) {
                    td = tr[i].getElementsByTagName("td")[j];
                    if (td) {
                        txtValue = td.textContent || td.innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            displayRow = true;
                            break; // Break the loop if a match is found in any column
                        }
                    }
                }

                // Set the display style based on whether a match is found in any column
                tr[i].style.display = displayRow ? "" : "none";
            }
        }

        document.getElementById("searchInputken").addEventListener("input", filterTableken);


        // filter rute 
        function filterTable() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("tables");
            tr = table.getElementsByTagName("tr");

            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[2]; // Change index to match the column you want to search
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
        document.getElementById("searchInput").addEventListener("input", filterTable);
    </script>

    <script>
        function formatRupiah(value) {
            return "Rp " + value.toLocaleString('id-ID');
        }

        function ShowMemo(selectedCategory) {
            $('#tableMemo').modal('show');
        }

        function getSelectedData(Memo_id, KodeMemo, NamaSopir, Telp, Kendaraan_id, NoKabin, NoPol, RutePerjalanan) {
            // Set the values in the form fields
            document.getElementById('memo_ekspedisi_id').value = Memo_id;
            document.getElementById('kode_memosa').value = KodeMemo;
            document.getElementById('nama_driversa').value = NamaSopir;
            document.getElementById('telps').value = Telp;
            document.getElementById('kendaraan_idsa').value = Kendaraan_id;
            document.getElementById('no_kabinsa').value = NoKabin;
            document.getElementById('no_polsa').value = NoPol;
            document.getElementById('nama_rutesa').value = RutePerjalanan;
            // Close the modal (if needed)
            $('#tableMemo').modal('hide');
        }


        function showAlamatMuat(selectedCategory) {
            $('#tableAlamatmuat').modal('show');
        }

        function getSelectedDataAlamatmuat(AlamatMuat_id, KodeAlamat, Alamats) {
            // Set the values in the form fields
            document.getElementById('alamat_muat_id').value = AlamatMuat_id;
            document.getElementById('kode_alamatmuat').value = KodeAlamat;
            document.getElementById('alamat_muat').value = Alamats;
            // Close the modal (if needed)
            $('#tableAlamatmuat').modal('hide');
        }

        function showAlamatBongkar(selectedCategory) {
            $('#tableAlamatbongkar').modal('show');
        }

        function getSelectedDataAlamatbongkar(AlamatMuat_id, KodeAlamat, Alamats) {
            // Set the values in the form fields
            document.getElementById('alamat_bongkar_id').value = AlamatMuat_id;
            document.getElementById('kode_alamatbongkar').value = KodeAlamat;
            document.getElementById('alamat_bongkar').value = Alamats;
            // Close the modal (if needed)
            $('#tableAlamatbongkar').modal('hide');
        }


        function showCategoryModalPelanggan(selectedCategory) {
            $('#tablePelanggan').modal('show');
        }

        function getSelectedDataPelanggan(Pelanggan_id, KodePelanggan, NamaPell, AlamatPel, Telpel) {
            // Set the values in the form fields
            document.getElementById('pelanggan_id').value = Pelanggan_id;
            document.getElementById('kode_pelanggan').value = KodePelanggan;
            document.getElementById('nama_pell').value = NamaPell;
            document.getElementById('alamat_pelanggan').value = AlamatPel;
            document.getElementById('telp_pelanggan').value = Telpel;
            // Close the modal (if needed)
            $('#tablePelanggan').modal('hide');
        }

        function showCategoryModaldriver(selectedCategory) {
            $('#tableDriver').modal('show');
        }

        function getSelectedDatadriver(User_id, KodeDriver, NamaDriver, Telp, SaldoDP) {
            // Set the values in the form fields
            document.getElementById('user_id').value = User_id;
            document.getElementById('kode_driver').value = KodeDriver;
            document.getElementById('nama_driver').value = NamaDriver;
            document.getElementById('telp').value = Telp;
            var kategori = $('#kategori').val(); // Get the value of the 'kategori' select element
            // Format SaldoDP to display properly
            var formattedNominal = parseFloat(SaldoDP).toLocaleString('id-ID');
            document.getElementById('saldo_deposit').value = formattedNominal;

            // Close the modal
            $('#tableDriver').modal('hide');

            // Check the value of 'kategori' and call the appropriate function
            if (kategori === 'Memo Perjalanan') {
                // Set deposit_driver value based on SaldoDP
                if (parseFloat(SaldoDP) < 0) {
                    document.getElementById('deposit_driver').value = 100000;
                    document.getElementById('depositsdriverss').value = (100000).toLocaleString('id-ID');
                }
                updateSubTotals();
            } else if (kategori === 'Memo Borong') {
                if (parseFloat(SaldoDP) < 0) {
                    document.getElementById('depositsopir').value = 100000;
                    document.getElementById('depositsopir2').value = (100000).toLocaleString('id-ID');
                }
            }
        }

        function showCategoryModalkendaraan(selectedCategory) {
            $('#tableKendaraan').modal('show');
        }

        function getSelectedDatakendaraan(Kendaraan_id, NoKabin, No_pol, Golongan, Km) {
            // Set the values in the form fields
            document.getElementById('kendaraan_id').value = Kendaraan_id;
            document.getElementById('no_kabin').value = NoKabin;
            document.getElementById('no_pol').value = No_pol;
            document.getElementById('golongan').value = Golongan;
            $('#tableKendaraan').modal('hide');

            // Setelah nilai kendaraan_id diambil, lakukan request Ajax untuk update KM
            var kendaraan_id = Kendaraan_id;

            // Pastikan kendaraan_id telah dipilih
            if (!kendaraan_id) {
                alert('Silakan pilih kendaraan terlebih dahulu.');
                return;
            }

            // Buat URL dengan memasukkan kendaraan_id ke dalam rute
            var url = '{{ route('ambil_km', ['id' => ':id']) }}';
            url = url.replace(':id', kendaraan_id);

            // Lakukan request Ajax untuk update KM
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    // Hapus alert berhasil dan langsung update nilai input KM di form
                    if (response.km) {
                        $('#km').val(response.km); // Update input dengan ID 'kendaraan_km'
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('Terjadi kesalahan saat mengupdate KM');
                }
            });
        }


        function showCategoryModalrute(selectedCategory) {
            $('#tableRute').modal('show');
        }

        function getSelectedDatarute(Rute_id, KodeRute, NamaRute, Golongan1, Golongan2, Golongan3, Golongan4, Golongan5,
            Golongan6, Golongan7, Golongan8, Golongan9, Golongan10) {

            var Golongan = document.getElementById("golongan").value;

            document.getElementById('rute_perjalanan_id').value = Rute_id;
            document.getElementById('kode_rute').value = KodeRute;
            document.getElementById('rute_perjalanan').value = NamaRute;

            if (Golongan === 'Golongan 1') {
                var Golongan1Value = parseFloat(Golongan1);
                document.getElementById('biaya').value = Golongan1Value.toLocaleString('id-ID');
            } else if (Golongan === 'Golongan 2') {
                var Golongan2Value = parseFloat(Golongan2);
                document.getElementById('biaya').value = Golongan2Value.toLocaleString('id-ID');
            } else if (Golongan === 'Golongan 3') {
                var Golongan3Value = parseFloat(Golongan3);
                document.getElementById('biaya').value = Golongan3Value.toLocaleString('id-ID');
            } else if (Golongan === 'Golongan 4') {
                var Golongan4Value = parseFloat(Golongan4);
                document.getElementById('biaya').value = Golongan4Value.toLocaleString('id-ID');
            } else if (Golongan === 'Golongan 5') {
                var Golongan5Value = parseFloat(Golongan5);
                document.getElementById('biaya').value = Golongan5Value.toLocaleString('id-ID');
            } else if (Golongan === 'Golongan 6') {
                var Golongan6Value = parseFloat(Golongan6);
                document.getElementById('biaya').value = Golongan6Value.toLocaleString('id-ID');
            } else if (Golongan === 'Golongan 7') {
                var Golongan7Value = parseFloat(Golongan7);
                document.getElementById('biaya').value = Golongan7Value.toLocaleString('id-ID');
            } else if (Golongan === 'Golongan 8') {
                var Golongan8Value = parseFloat(Golongan8);
                document.getElementById('biaya').value = Golongan8Value.toLocaleString('id-ID');
            } else if (Golongan === 'Golongan 9') {
                var Golongan9Value = parseFloat(Golongan9);
                document.getElementById('biaya').value = Golongan9Value.toLocaleString('id-ID');
            } else if (Golongan === 'Golongan 10') {
                var Golongan10Value = parseFloat(Golongan10);
                document.getElementById('biaya').value = Golongan10Value.toLocaleString('id-ID');
            }

            // Close the modal (if needed)
            $('#tableRute').modal('hide');
        }
    </script>

    <script>
        function formatRupiahs(angka) {
            var reverse = angka.toString().split('').reverse().join(''),
                ribuan = reverse.match(/\d{1,3}/g);
            ribuan = ribuan.join('.').split('').reverse().join('');
            return ribuan; // Mengembalikan hanya angka tanpa teks "Rp"
        }
    </script>

    <script>
        $(document).ready(function() {
            // Tambahkan event listener pada tombol "Simpan"
            $('#btnSimpan').click(function() {
                // Sembunyikan tombol "Simpan" dan "Reset", serta tampilkan elemen loading
                $(this).hide();
                $('#btnReset').hide(); // Tambahkan id "btnReset" pada tombol "Reset"
                $('#loading').show();

                // Lakukan pengiriman formulir
                $('form').submit();
            });
        });
    </script>

    <script>
        function toggleLabels() {
            var kategori = document.getElementById('kategori');
            var Pelangganspk = document.getElementById('pelangganspk');
            var Kendaraanspk = document.getElementById('kendaraanspk');
            var RuteSpk = document.getElementById('rutespk');
            var SopirSpk = document.getElementById('sopirspk');
            var AlamatJalan = document.getElementById('alamat_jalan');

            if (kategori.value === 'memo') {
                Pelangganspk.style.display = 'block';
                Kendaraanspk.style.display = 'block';
                RuteSpk.style.display = 'block';
                SopirSpk.style.display = 'block';
                AlamatJalan.style.display = 'block';
            } else if (kategori.value === 'non memo') {
                Pelangganspk.style.display = 'none';
                Kendaraanspk.style.display = 'none';
                RuteSpk.style.display = 'none';
                SopirSpk.style.display = 'none';
                AlamatJalan.style.display = 'none';
            }
        }

        toggleLabels();
        document.getElementById('kategori').addEventListener('change', toggleLabels);
    </script>
@endsection
