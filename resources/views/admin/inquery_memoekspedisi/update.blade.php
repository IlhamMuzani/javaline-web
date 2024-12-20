@extends('layouts.app')

@section('title', 'Inquery Memo Ekspedisi')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Inquery Memo Ekspedisi</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/inquery_memoekspedisi') }}">Memo Ekspedisi</a></li>
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
            <form action="{{ url('admin/inquery_memoekspedisi/' . $inquery->id) }}" method="POST"
                enctype="multipart/form-data" autocomplete="off">
                @csrf
                @method('put')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Perbarui Memo Ekspedisi</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group">
                            <label style="font-size:14px" for="kategori">Kategori</label>
                            <input style="font-size:14px" type="text" class="form-control" id="kategori" readonly
                                name="kategori" placeholder="" value="{{ old('kategori', $inquery->kategori) }}">
                        </div>
                    </div>
                </div>
                <div>
                    <div id="memoperjalananborong">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Kendaraan</h3>
                                    </div>
                                    <div class="card-body">
                                        {{-- <div class="mb-3">

                                    <div class="float-right">
                                        <button class="btn btn-primary btn-sm" type="button"
                                            onclick="showCategoryModalkendaraan(this.value)">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div> --}}
                                        <div class="form-group" hidden>
                                            <label for="kendaraan_id">Kendaraan Id</label>
                                            <input type="text" class="form-control" id="kendaraan_id" readonly
                                                name="kendaraan_id" placeholder=""
                                                value="{{ old('kendaraan_id', $inquery->kendaraan_id) }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="no_pol">No pol</label>
                                            <input type="text" class="form-control" id="no_pol" readonly
                                                name="no_pol" placeholder="" value="{{ old('no_pol', $inquery->no_pol) }}">
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
                                                type="text" class="form-control" id="golongan" readonly name="golongan"
                                                placeholder="" value="{{ old('golongan', $inquery->golongan) }}">
                                        </div>
                                        <div class="form-group">
                                            <label style="font-size:14px" for="km">KM Awal</label>
                                            <input onclick="showCategoryModalkendaraan(this.value)" style="font-size:14px"
                                                type="text" class="form-control" id="km" readonly
                                                name="km_awal" placeholder=""
                                                value="{{ old('km_awal', $inquery->km_awal) }}">
                                        </div>
                                        <div class="form-check" style="color:white">
                                            <label class="form-check-label">
                                                .
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card">
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
                                                value="{{ old('saldo_deposit', number_format($inquery->saldo_deposit, 0, ',', '.')) }}">
                                        </div>
                                        <div class="form-check" style="color:white">
                                            <label class="form-check-label">
                                                .
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4" id="form_rute">
                                <div class="card">
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
                                                value="{{ old('uang_jalan', number_format($inquery->uang_jalan, 0, ',', '.')) }}">
                                        </div>
                                        <div class="form-check" style="color:white">
                                            <label class="form-check-label">
                                                .
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4" id="form_pelanggan" style="display: none;">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Pelanggan</h3>
                                    </div>
                                    <div class="card-body">
                                        {{-- <div class="mb-3">
                                    <button class="btn btn-primary btn-sm" type="button"
                                        onclick="showCategoryModalrute(this.value)">
                                        <i class="fas fa-search mr-1"></i> Search Rute
                                    </button>
                                </div> --}}
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
                                            <input class="form-control" id="nama_pell" name="nama_pelanggan"
                                                type="text" placeholder=""
                                                value="{{ old('nama_pelanggan', $inquery->nama_pelanggan) }}" readonly
                                                style="margin-right: 10px; font-size:14px" />
                                            <button class="btn btn-primary" type="button"
                                                onclick="showCategoryModalPelanggan(this.value)">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                        <div class="form-group">
                                            <label style="font-size:14px" for="alamat_pelanggan">Alamat</label>
                                            <input style="font-size:14px" type="text" class="form-control"
                                                id="alamat_pelanggan" readonly name="alamat_pelanggan" placeholder=""
                                                value="{{ old('alamat_pelanggan', $inquery->alamat_pelanggan) }}">
                                        </div>
                                        <div class="form-group">
                                            <label style="font-size:14px" for="telp_pelanggan">No. Telp</label>
                                            <input style="font-size:14px" type="text" class="form-control"
                                                id="telp_pelanggan" readonly name="telp_pelanggan" placeholder=""
                                                value="{{ old('telp_pelanggan', $inquery->telp_pelanggan) }}">
                                        </div>
                                        <div class="form-check" style="color:white">
                                            <label class="form-check-label">
                                                .
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3" hidden>
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Biaya</h3>
                                    </div>
                                    <div class="card-body">

                                        <div id="memoperjalanan">
                                            <label style="font-size:14px" for="harga_tambahan">Biaya Tambahan</label>
                                            <div class="form-group d-flex">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card" id="form_biayatambahan">
                            <div class="card-header">
                                <h3 class="card-title">Biaya Tambahan <span>
                                    </span></h3>
                                <div class="float-right">
                                    <button type="button" class="btn btn-primary btn-sm" onclick="addTambahan()">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="font-size:14px" class="text-center">No</th>
                                            <th style="font-size:14px">Kode Biaya Tambahan</th>
                                            <th style="font-size:14px">Keterangan</th>
                                            <th style="font-size:14px">Nominal</th>
                                            <th style="font-size:14px">Opsi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabel-pembelian">
                                        @foreach ($detailstambahan as $detail)
                                            <tr id="pembelian-{{ $loop->index }}">
                                                <td style="width: 70px; font-size:14px" class="text-center"
                                                    id="urutan">
                                                    {{ $loop->index + 1 }}
                                                </td>
                                                <td hidden>
                                                    <div class="form-group" hidden>
                                                        <input type="text" class="form-control"
                                                            id="nomor_seri-{{ $loop->index }}" name="detail_idss[]"
                                                            value="{{ $detail['id'] }}">
                                                    </div>
                                                </td>
                                                <td hidden>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control"
                                                            id="biaya_tambahan_id-{{ $loop->index }}"
                                                            name="biaya_tambahan_id[]"
                                                            value="{{ $detail['biaya_tambahan_id'] }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input onclick="biayatambah({{ $loop->index }})"
                                                            style="font-size:14px" type="text" class="form-control"
                                                            readonly id="kode_biaya-{{ $loop->index }}"
                                                            name="kode_biaya[]" value="{{ $detail['kode_biaya'] }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input onclick="biayatambah({{ $loop->index }})"
                                                            style="font-size:14px" type="text" class="form-control"
                                                            readonly id="nama_biaya-{{ $loop->index }}"
                                                            name="nama_biaya[]" value="{{ $detail['nama_biaya'] }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input onclick="biayatambah({{ $loop->index }})"
                                                            style="font-size:14px" type="text" class="form-control"
                                                            id="nominal-{{ $loop->index }}" readonly name="nominal[]"
                                                            value="{{ number_format($detail['nominal'], 0, ',', '.') }}">
                                                    </div>
                                                </td>
                                                <td style="width: 100px">
                                                    <button style="margin-left:5px" type="button"
                                                        class="btn btn-danger btn-sm"
                                                        onclick="removeTambahan({{ $loop->index }}, {{ $detail['id'] }})">

                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        onclick="biayatambah({{ $loop->index }})">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card" id="form_potonganmemo">
                            <div class="card-header">
                                <h3 class="card-title">Potongan Memo <span>
                                    </span></h3>
                                <div class="float-right">
                                    <button type="button" class="btn btn-primary btn-sm" onclick="addPesanan()">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="font-size:14px" class="text-center">No</th>
                                            <th style="font-size:14px">Kode Potongan Memo</th>
                                            <th style="font-size:14px">Keterangan</th>
                                            <th style="font-size:14px">Nominal</th>
                                            <th style="font-size:14px">Opsi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabel-potongan">
                                        @foreach ($details as $detail)
                                            <tr id="potongan-{{ $loop->index }}">
                                                <td style="width: 70px; font-size:14px" class="text-center"
                                                    id="urutanpotongan">
                                                    {{ $loop->index + 1 }}
                                                </td>
                                                <td hidden>
                                                    <div class="form-group" hidden>
                                                        <input type="text" class="form-control"
                                                            id="nomor_seri-{{ $loop->index }}" name="detail_ids[]"
                                                            value="{{ $detail['id'] }}">
                                                    </div>
                                                </td>
                                                <td hidden>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control"
                                                            id="potongan_memo_id-{{ $loop->index }}"
                                                            name="potongan_memo_id[]"
                                                            value="{{ $detail['potongan_memo_id'] }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input onclick="potonganmemo({{ $loop->index }})"
                                                            style="font-size:14px" type="text" class="form-control"
                                                            readonly id="kode_potongan-{{ $loop->index }}"
                                                            name="kode_potongan[]"
                                                            value="{{ $detail['kode_potongan'] }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input onclick="potonganmemo({{ $loop->index }})"
                                                            style="font-size:14px" type="text" class="form-control"
                                                            readonly id="keterangan_potongan-{{ $loop->index }}"
                                                            name="keterangan_potongan[]"
                                                            value="{{ $detail['keterangan_potongan'] }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input onclick="potonganmemo({{ $loop->index }})"
                                                            style="font-size:14px" type="text" class="form-control"
                                                            id="nominal_potongan-{{ $loop->index }}" readonly
                                                            name="nominal_potongan[]"
                                                            value="{{ number_format($detail['nominal_potongan'], 0, ',', '.') }}">
                                                    </div>
                                                </td>
                                                <td style="width: 100px">
                                                    <button style="margin-left:5px" type="button"
                                                        class="btn btn-danger btn-sm"
                                                        onclick="removeBan({{ $loop->index }}, {{ $detail['id'] }})">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        onclick="potonganmemo({{ $loop->index }})">
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

                    <div class="card">
                        <div class="card-body">
                            <div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label style="font-size:14px; margin-top:5px"
                                                                for="tarif">Administrasi
                                                                <span style="margin-left:25px">:</span></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input style=" font-size:14px;" type="text"
                                                                class="form-control total_tarif2" readonly placeholder=""
                                                                value="1 %">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label style="font-size:14px; margin-top:5px"
                                                                for="tarif">Deposit Sopir
                                                                <span style="margin-left:19px">:</span></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input style="font-size:14px;" type="text"
                                                                class="form-control pph2" id="deposit_driver"
                                                                name="deposit_driver"
                                                                value="{{ old('deposit_driver', $inquery->deposit_driver) }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6" style="color: white">
                                                        <div class="form-group">
                                                            <label style="font-size:14px; margin-top:5px" for="tarif">.
                                                                <span class="ml-3">:</span></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input style="margin-left: 0px" class="form-check-input"
                                                                type="checkbox" id="additional_checkbox"
                                                                name="additional_checkbox" onchange="limitInput()">
                                                            <label style="margin-left: 20px" class="form-check-label"
                                                                for="additional_checkbox">
                                                                Min Deposit 50.000
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6" style="color: white">
                                                        <div class="form-group">
                                                            <label style="font-size:18px; margin-top:5px" for="tarif">.
                                                                <span class="ml-3">:</span></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6" style="color: white">
                                                        <div class="form-group">
                                                            <label style="font-size:18px; margin-top:5px" for="tarif">.
                                                                <span class="ml-3">:</span></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label style="font-size:14px; margin-top:5px"
                                                                for="tarif">Uang Jalan
                                                                <span style="margin-left:50px">:</span></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input style="text-align: end; font-size:14px;" type="text"
                                                                class="form-control" id="uangjalans" readonly
                                                                name="uang_jalans" placeholder=""
                                                                value="{{ number_format($inquery->uang_jalan, 0, ',', '.') }}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label style="font-size:14px; margin-top:5px"
                                                                for="tarif">Biaya Tambahan
                                                                <span style="margin-left:17px">:</span></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input style="text-align: end; font-size:14px;" type="text"
                                                                class="form-control pph2" readonly id="harga_tambahan"
                                                                readonly name="biaya_tambahan"
                                                                value="{{ number_format($inquery->biaya_tambahan, 0, ',', '.') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label style="font-size:14px; margin-top:5px"
                                                                for="tarif">Potongan Memo
                                                                <span style="margin-left:19px">:</span></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input style="text-align: end; font-size:14px;" type="text"
                                                                class="form-control" id="potongan_memo" readonly
                                                                name="potongan_memo" placeholder=""
                                                                value="{{ number_format($inquery->potongan_memo, 0, ',', '.') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label style="font-size:14px; margin-top:5px"
                                                                for="tarif">Administrasi
                                                                <span style="margin-left:41px">:</span></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input style="text-align: end; font-size:14px;" type="text"
                                                                class="form-control" readonly id="uang_jaminan"
                                                                name="uang_jaminan" placeholder=""
                                                                value="{{ number_format($inquery->uang_jaminan, 0, ',', '.') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label style="font-size:14px; margin-top:5px"
                                                                for="tarif">Deposit Sopir
                                                                <span style="margin-left:35px">:</span></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input style="text-align: end; font-size:14px;" type="text"
                                                                class="form-control" id="depositsdriverss" readonly
                                                                name="deposit_drivers" placeholder=""
                                                                value="{{ number_format($inquery->uangd_jalan, 0, ',', '.') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <br>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="font-size:14px">keterangan</th>
                                        {{-- <th style="font-size:14px">Sisa Saldo</th> --}}
                                        <th style="font-size:14px">Grand Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <textarea style="font-size:14px" type="text" class="form-control" id="keterangan" name="keterangan"
                                                    placeholder="Masukan keterangan">{{ old('keterangan', $inquery->keterangan) }}</textarea>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input style="font-size:14px; font-weight:bold; text-align:end;" readonly
                                                    type="text" class="form-control" id="sub_total" name="sub_total"
                                                    {{-- value="{{ old('sub_total', $inquery->sub_total) }}" --}}
                                                    value="{{ old('sub_total', number_format($inquery->sub_total, 0, ',', '.')) }}"
                                                    onclick="SubTotalss()">
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="reset" class="btn btn-secondary">Reset</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
        </div>
        </form>

        <div class="modal fade" id="tableBiaya" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Biaya Tambahan</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table id="datatables66" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Kode Biaya Tambahan</th>
                                    <th>Nama Biaya</th>
                                    <th>Nominal</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($biayatambahan as $biayatambah)
                                    <tr onclick="getBiaya({{ $loop->index }})" data-id="{{ $biayatambah->id }}"
                                        data-kode_biaya="{{ $biayatambah->kode_biaya }}"
                                        data-nama_biaya="{{ $biayatambah->nama_biaya }}"
                                        data-nominal="{{ $biayatambah->nominal }}" data-param="{{ $loop->index }}">
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $biayatambah->kode_biaya }}</td>
                                        <td>{{ $biayatambah->nama_biaya }}</td>
                                        <td>{{ number_format($biayatambah->nominal, 0, ',', '.') }}</td>
                                        <td class="text-center">
                                            <button type="button" id="btnTambah" class="btn btn-primary btn-sm"
                                                onclick="getBiaya({{ $loop->index }})">
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

        <div class="modal fade" id="tablePotongans" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Potongan Memo</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table id="datatables6" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Kode Potongan Memo</th>
                                    <th>Keterangan</th>
                                    <th>Nominal</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($potonganmemos as $potonganmemo)
                                    <tr onclick="getPotongan({{ $loop->index }})" data-id="{{ $potonganmemo->id }}"
                                        data-kode_potongan="{{ $potonganmemo->kode_potongan }}"
                                        data-keterangan="{{ $potonganmemo->keterangan }}"
                                        data-nominal="{{ $potonganmemo->nominal }}" data-param="{{ $loop->index }}">
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $potonganmemo->kode_potongan }}</td>
                                        <td>{{ $potonganmemo->keterangan }}</td>
                                        <td>{{ number_format($potonganmemo->nominal, 0, ',', '.') }}</td>
                                        <td class="text-center">
                                            <button type="button" id="btnTambah" class="btn btn-primary btn-sm"
                                                onclick="getPotongan({{ $loop->index }})">
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
                            <table id="datatables2" class="table table-bordered table-striped">
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
                                                <td hidden style="font-weight: bold">{{ $rute_perjalanan->golongan1 }}
                                                </td>
                                            @else
                                                <td hidden>Rp.0
                                                </td>
                                            @endif
                                            @if ($rute_perjalanan->golongan2)
                                                <td hidden style="font-weight: bold">{{ $rute_perjalanan->golongan2 }}
                                                </td>
                                            @else
                                                <td hidden>Rp.0
                                                </td>
                                            @endif
                                            @if ($rute_perjalanan->golongan3)
                                                <td hidden style="font-weight: bold">{{ $rute_perjalanan->golongan3 }}
                                                </td>
                                            @else
                                                <td hidden>Rp.0
                                                </td>
                                            @endif
                                            @if ($rute_perjalanan->golongan4)
                                                <td hidden style="font-weight: bold">{{ $rute_perjalanan->golongan4 }}
                                                </td>
                                            @else
                                                <td hidden>Rp.0
                                                </td>
                                            @endif
                                            @if ($rute_perjalanan->golongan5)
                                                <td hidden style="font-weight: bold">{{ $rute_perjalanan->golongan5 }}
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
                        <div class="table-responsive scrollbar m-2">
                            <table id="datatables1" class="table table-bordered table-striped">
                                <thead class="bg-200 text-900">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Kode Kendaraan</th>
                                        <th>No Kabin</th>
                                        <th>Golongan</th>
                                        <th>Km</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kendaraans as $kendaraan)
                                        <tr
                                            onclick="getSelectedDatakendaraan('{{ $kendaraan->id }}', '{{ $kendaraan->no_kabin }}',  '{{ $kendaraan->no_pol }}', '{{ $kendaraan->golongan->nama_golongan }}', '{{ $kendaraan->km }}')">
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $kendaraan->kode_kendaraan }}</td>
                                            <td>{{ $kendaraan->no_kabin }}</td>
                                            <td>{{ $kendaraan->golongan->nama_golongan }}</td>
                                            <td>{{ $kendaraan->km }}</td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="getSelectedDatakendaraan('{{ $kendaraan->id }}', '{{ $kendaraan->no_kabin }}',  '{{ $kendaraan->no_pol }}', '{{ $kendaraan->golongan->nama_golongan }}', '{{ $kendaraan->km }}')">
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
        // filter rute 
        function filterTable() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("datatables2");
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
        document.getElementById("searchInput").addEventListener("input", filterTable);



        function removePotongan() {
            // Clear the values of the specified form elements
            $('#potongan_memo_id').val('');
            $('#kode_potongan').val('');
            $('#keteranganpotongan').val('');
            $('#nominalpotongan').val('');
            $('#potongan_memo').val('0');

            // You can add additional code here if needed

            // Update the grand total or perform any other necessary actions
            updateSubTotals();
        }
    </script>


    <script>
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
            document.getElementById('saldo_deposit').value = SaldoDP;
            // Close the modal (if needed)
            $('#tableDriver').modal('hide');

            // if (kategori === 'Memo Perjalanan') {
            // Set deposit_driver value based on SaldoDP
            if (parseFloat(SaldoDP) < 0) {
                document.getElementById('deposit_driver').value = 100000;
                document.getElementById('depositsdriverss').value = (100000).toLocaleString('id-ID');
            }
            updateSubTotals();
            // } else if (kategori === 'Memo Borong') {
            //     document.getElementById('depositsopir').value = 100000;
            //     document.getElementById('depositsopir2').value = (100000).toLocaleString('id-ID');
            //     // depositsopir
            //     updateSubTotal();
            // }
        }

        function showCategoryModalkendaraan(selectedCategory) {
            $('#tableKendaraan').modal('show');
        }

        function getSelectedDatakendaraan(Kendaraan_id, NoKabin, NoPol, Golongan, Km) {
            // Set the values in the form fields
            document.getElementById('kendaraan_id').value = Kendaraan_id;
            document.getElementById('no_kabin').value = NoKabin;
            document.getElementById('no_pol').value = NoPol;
            document.getElementById('golongan').value = Golongan;
            document.getElementById('km').value = Km;
            // Close the modal (if needed)
            $('#tableKendaraan').modal('hide');
        }

        function showCategoryModalrute(selectedCategory) {
            $('#tableRute').modal('show');
        }

        function getSelectedDatarute(Rute_id, KodeRute, NamaRute, Golongan1, Golongan2, Golongan3, Golongan4, Golongan5,
            Golongan6, Golongan7, Golongan8, Golongan9, Golongan10) {

            var Golongan = document.getElementById("golongan").value;
            console.log(Golongan);

            document.getElementById('rute_perjalanan_id').value = Rute_id;
            document.getElementById('kode_rute').value = KodeRute;
            document.getElementById('rute_perjalanan').value = NamaRute;

            if (Golongan === 'Golongan 1') {
                var Golongan1Value = parseFloat(Golongan1);
                document.getElementById('biaya').value = Golongan1Value.toLocaleString('id-ID');
                console.log(Golongan1);
                document.getElementById('uangjalans').value = Golongan1Value.toLocaleString('id-ID');
            } else if (Golongan === 'Golongan 2') {
                var Golongan2Value = parseFloat(Golongan2);
                document.getElementById('biaya').value = Golongan2Value.toLocaleString('id-ID');
                document.getElementById('uangjalans').value = Golongan2Value.toLocaleString('id-ID');
            } else if (Golongan === 'Golongan 3') {
                var Golongan3Value = parseFloat(Golongan3);
                document.getElementById('biaya').value = Golongan3Value.toLocaleString('id-ID');
                document.getElementById('uangjalans').value = Golongan3Value.toLocaleString('id-ID');
            } else if (Golongan === 'Golongan 4') {
                var Golongan4Value = parseFloat(Golongan4);
                document.getElementById('biaya').value = Golongan4Value.toLocaleString('id-ID');
                document.getElementById('uangjalans').value = Golongan4Value.toLocaleString('id-ID');
            } else if (Golongan === 'Golongan 5') {
                var Golongan5Value = parseFloat(Golongan5);
                document.getElementById('biaya').value = Golongan5Value.toLocaleString('id-ID');
                document.getElementById('uangjalans').value = Golongan5Value.toLocaleString('id-ID');
            } else if (Golongan === 'Golongan 6') {
                var Golongan6Value = parseFloat(Golongan6);
                document.getElementById('biaya').value = Golongan6Value.toLocaleString('id-ID');
                document.getElementById('uangjalans').value = Golongan6Value.toLocaleString('id-ID');
            } else if (Golongan === 'Golongan 7') {
                var Golongan7Value = parseFloat(Golongan7);
                document.getElementById('biaya').value = Golongan7Value.toLocaleString('id-ID');
                document.getElementById('uangjalans').value = Golongan7Value.toLocaleString('id-ID');
            } else if (Golongan === 'Golongan 8') {
                var Golongan8Value = parseFloat(Golongan8);
                document.getElementById('biaya').value = Golongan8Value.toLocaleString('id-ID');
                document.getElementById('uangjalans').value = Golongan8Value.toLocaleString('id-ID');
            } else if (Golongan === 'Golongan 9') {
                var Golongan9Value = parseFloat(Golongan9);
                document.getElementById('biaya').value = Golongan9Value.toLocaleString('id-ID');
                document.getElementById('uangjalans').value = Golongan9Value.toLocaleString('id-ID');
            } else if (Golongan === 'Golongan 10') {
                var Golongan10Value = parseFloat(Golongan10);
                document.getElementById('biaya').value = Golongan10Value.toLocaleString('id-ID');
                document.getElementById('uangjalans').value = Golongan10Value.toLocaleString('id-ID');

            }

            // Close the modal (if needed)
            $('#tableRute').modal('hide');

            updateSubTotals();
        }

        var activeSpecificationIndexs = 0;

        function rutebaru(param) {
            activeSpecificationIndexs = param;
            // Show the modal and filter rows if necessary
            $('#tableRutes').modal('show');
        }

        function getRutes(rowIndex) {
            var selectedRow = $('#datatables5 tbody tr:eq(' + rowIndex + ')');
            var rute_perjalanan_id = selectedRow.data('rute_perjalanan_id');
            var kode_rute = selectedRow.data('kode_rute');
            var nama_rute = selectedRow.data('nama_rute');
            var harga = selectedRow.data('harga');

            // Update the form fields for the active specification
            $('#rute_id-' + activeSpecificationIndexs).val(rute_perjalanan_id);
            $('#kode_rutes-' + activeSpecificationIndexs).val(kode_rute);
            $('#nama_rutes-' + activeSpecificationIndexs).val(nama_rute);
            $('#harga_rute-' + activeSpecificationIndexs).val(harga);

            $('#tableRutes').modal('hide');
        }

        var activeSpecificationIndex = 0;

        function potonganmemo(param) {
            activeSpecificationIndex = param;
            // Show the modal and filter rows if necessary
            $('#tablePotongans').modal('show');
        }

        function getPotongan(rowIndex) {
            var selectedRow = $('#datatables6 tbody tr:eq(' + rowIndex + ')');
            var Potongan_id = selectedRow.data('id');
            var KodePotongan = selectedRow.data('kode_potongan');
            var Keterangan = selectedRow.data('keterangan');
            var Nominal = selectedRow.data('nominal');

            // Update the form fields for the active specification
            $('#potongan_memo_id-' + activeSpecificationIndex).val(Potongan_id);
            $('#kode_potongan-' + activeSpecificationIndex).val(KodePotongan);
            $('#keterangan_potongan-' + activeSpecificationIndex).val(Keterangan);
            $('#nominal_potongan-' + activeSpecificationIndex).val(Nominal.toLocaleString('id-ID'));

            // var formattedNominal = parseFloat(Nominal).toLocaleString('id-ID');
            // document.getElementById('nominal_potongan-').value = formattedNominal;

            $('#tablePotongans').modal('hide');
            updateTotalpotongan()
            updateSubTotals()
        }

        var activeSpecificationIndex = 0;

        var activeSpecificationIndex = 0;

        function biayatambah(param) {
            activeSpecificationIndex = param;
            // Show the modal and filter rows if necessary
            $('#tableBiaya').modal('show');
        }

        function getBiaya(rowIndex) {
            var selectedRow = $('#datatables66 tbody tr:eq(' + rowIndex + ')');
            var Biaya_id = selectedRow.data('id');
            var KodeBiaya = selectedRow.data('kode_biaya');
            var NamabIaya = selectedRow.data('nama_biaya');
            var Nominal = selectedRow.data('nominal');
            // var kategori = $('#kategori').val(); // Get the value of the 'kategori' select element

            // Update the form fields for the active specification
            $('#biaya_tambahan_id-' + activeSpecificationIndex).val(Biaya_id);
            $('#kode_biaya-' + activeSpecificationIndex).val(KodeBiaya);
            $('#nama_biaya-' + activeSpecificationIndex).val(NamabIaya);
            $('#nominal-' + activeSpecificationIndex).val(Nominal.toLocaleString('id-ID'));

            // var formattedNominal = parseFloat(Nominal).toLocaleString('id-ID');
            // // Assuming 'biaya_tambahan' is an input element
            // document.getElementById('nominal').value = formattedNominal;
            // document.getElementById('harga_tambahan').value = formattedNominal;
            // document.getElementById('harga_tambahanborong').value = formattedNominal;

            $('#tableBiaya').modal('hide');

            updateTotaltambahan()
            updateSubTotals();

        }
    </script>

    <script>
        $('#deposit_driver').on('input', function() {
            // Mengambil nilai input nominal
            var nominalValue = $(this).val();

            // Memeriksa apakah input nominal kosong atau tidak
            if (nominalValue === "") {
                // Jika kosong, set form saldo masuk dan sub total menjadi 0
                $('#depositsdriverss').val("0");
                updateSubTotals()
            } else {
                // Jika tidak kosong, mengonversi nilai ke format rupiah
                var saldoMasukValue = formatRupiahs(nominalValue);

                // Menetapkan nilai ke input saldo masuk
                $('#depositsdriverss').val(saldoMasukValue);

                // Memperbarui nilai sub total saat input nominal berubah
                updateSubTotals();
            }
        });

        function formatRupiahs(angka) {
            var reverse = angka.toString().split('').reverse().join(''),
                ribuan = reverse.match(/\d{1,3}/g);
            ribuan = ribuan.join('.').split('').reverse().join('');
            return ribuan; // Mengembalikan hanya angka tanpa teks "Rp"
        }

        function formatRupiah(value) {
            return value.toLocaleString('id-ID');
        }

        function updateSubTotals() {
            var Uangjalans = $('#biaya').val().replace(/\./g, '') || 0;
            var PotonganMemo = parseCurrency($('#potongan_memo').val().replace(/\./g, '')) || 0;
            var HargaTambahan = parseCurrency($('#harga_tambahan').val().replace(/\./g, '')) || 0;
            var DepositDriv = parseCurrency($('#deposit_driver').val()) || 0;


            Uangjalans = parseFloat(Uangjalans) || 0;
            // Menghitung sub total (1% dari UangJaminan)
            var UangJaminan = Uangjalans + HargaTambahan - PotonganMemo;
            var satuPersenUangJaminan = 0.01 * UangJaminan;

            // Menetapkan nilai ke input uang_jaminan
            $('#uang_jaminan').val(formatRupiah(satuPersenUangJaminan));

            // Menghitung Subtotal (satuPersenUangJaminan - DepositDriv)
            var Subtotal = UangJaminan - satuPersenUangJaminan - DepositDriv;

            // Menetapkan nilai ke input sub_total
            $('#sub_total').val(formatRupiah(Subtotal));
        }

        function parseCurrency(value) {
            return parseFloat(value.replace(/[^\d.-]/g, '')) || 0;
        }

        document.addEventListener("DOMContentLoaded", function() {
            limitInput();
        });

        var initialValue = {{ old('deposit_driver', $inquery->deposit_driver) }};

        function limitInput() {
            var depositInput = document.getElementById("deposit_driver");
            var depositInputss = document.getElementById("depositsdriverss");
            var depositInputsst = document.getElementById("depositsdriversst");
            var checkbox = document.getElementById("additional_checkbox");

            // Convert the value to a number
            var depositValue = parseFloat(depositInput.value);

            // Check if the checkbox is checked
            if (checkbox.checked) {
                // If checkbox is checked, set the value to 50,000
                depositInput.value = 50000;
            }

            depositInputss.value = formatRupiah(depositInput.value);
            depositInputsst.value = depositInput.value;

            // Update other elements or perform other actions as needed
            updateSubTotals();

            // Function to format the input value to Rupiah without the currency symbol
            function formatRupiah(value) {
                var formatter = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0,
                });
                var formattedValue = formatter.format(value);
                formattedValue = formattedValue.replace('Rp', '');

                return formattedValue.trim();
            }
        }


        var potonganMemoInput = document.getElementById('potongan_memo');
        var HargaTambahan = document.getElementById('harga_tambahan');

        // Check if the input is empty or not
        if (potonganMemoInput.value.trim() === '') {
            // Set the default value to 0 if the input is empty
            potonganMemoInput.value = '0';
        }

        // Add an event listener to adjust the value on user input
        potonganMemoInput.addEventListener('input', function() {
            // Remove non-numeric characters and leading zeros
            var sanitizedValue = potonganMemoInput.value.replace(/[^0-9]/g, '').replace(/^0+/, '');

            // Set the adjusted value back to the input
            potonganMemoInput.value = sanitizedValue || '0';
        });


        if (HargaTambahan.value.trim() === '') {
            // Set the default value to 0 if the input is empty
            HargaTambahan.value = '0';
        }

        // Add an event listener to adjust the value on user input
        HargaTambahan.addEventListener('input', function() {
            // Remove non-numeric characters and leading zeros
            var sanitizedValues = HargaTambahan.value.replace(/[^0-9]/g, '').replace(/^0+/, '');

            // Set the adjusted value back to the input
            HargaTambahan.value = sanitizedValues || '0';
        });
    </script>

    <script>
        var data_pembelian = @json(session('data_pembelians'));
        var jumlah_tambahan = 1;

        if (data_pembelian != null) {
            jumlah_tambahan = data_pembelian.length;
            $('#tabel-pembelian').empty();
            var urutan = 0;
            $.each(data_pembelian, function(key, value) {
                urutan = urutan + 1;
                itemPembelians(urutan, key, value);
            });
        }

        var counters = 0;

        function addTambahan() {
            counters++;
            jumlah_tambahan = jumlah_tambahan + 1;

            if (jumlah_tambahan === 1) {
                $('#tabel-pembelian').empty();
            } else {
                // Find the last row and get its index to continue the numbering
                var lastRow = $('#tabel-pembelian tr:last');
                var lastRowIndex = lastRow.find('#urutan').text();
                jumlah_tambahan = parseInt(lastRowIndex) + 1;
            }

            console.log('Current jumlah_tambahan:', jumlah_tambahan);
            itemPembelians(jumlah_tambahan, jumlah_tambahan - 1);
            updateUrutanss();
        }


        function updateUrutanss() {
            var urutan = document.querySelectorAll('#urutan');
            for (let i = 0; i < urutan.length; i++) {
                urutan[i].innerText = i + 1;
            }
        }


        function removeTambahan(identifier, detailId) {
            var row = document.getElementById('pembelian-' + identifier);
            row.remove();

            console.log(detailId);
            $.ajax({
                url: "{{ url('admin/inquery_memoekspedisi/deletedetailbiayatambahan/') }}/" + detailId,
                type: "POST",
                data: {
                    _method: 'DELETE',
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log('Data deleted successfully');
                },
                error: function(error) {
                    console.error('Failed to delete data:', error);
                }
            });

            updateTotaltambahan()
            updateSubTotals()
            updateUrutanss();
        }

        function itemPembelians(identifier, key, value = null) {
            var biaya_tambahan_id = '';
            var kode_biaya = '';
            var nama_biaya = '';
            var nominal = '';

            if (value !== null) {
                biaya_tambahan_id = value.biaya_tambahan_id;
                kode_biaya = value.kode_biaya;
                nama_biaya = value.nama_biaya;
                nominal = value.nominal;

            }

            // urutan 
            var item_pembelian = '<tr id="pembelian-' + key + '">';
            item_pembelian += '<td  style="width: 70px; font-size:14px" class="text-center" id="urutan">' + key +
                '</td>';

            // biaya_tambahan_id 
            item_pembelian += '<td hidden>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" id="biaya_tambahan_id-' + key +
                '" name="biaya_tambahan_id[]" value="' + biaya_tambahan_id + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // kode_biaya 
            item_pembelian += '<td onclick="biayatambah(' +
                key +
                ')">';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" style="font-size:14px" readonly id="kode_biaya-' +
                key +
                '" name="kode_biaya[]" value="' + kode_biaya + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // nama_biaya 
            item_pembelian += '<td onclick="biayatambah(' +
                key +
                ')">';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control" style="font-size:14px" readonly id="nama_biaya-' +
                key +
                '" name="nama_biaya[]" value="' + nama_biaya + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // nominal 
            item_pembelian += '<td onclick="biayatambah(' +
                key +
                ')">';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control" style="font-size:14px" readonly id="nominal-' +
                key +
                '" name="nominal[]" value="' + nominal + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            //
            item_pembelian += '<td style="width: 100px">';
            item_pembelian +=
                '<button  style="margin-left:5px" type="button" class="btn btn-danger btn-sm" onclick="removeTambahan(' +
                key + ')">';
            item_pembelian += '<i class="fas fa-trash"></i>';
            item_pembelian += '</button>';
            item_pembelian +=
                '<button  style="margin-left:3px" type="button" class="btn btn-primary btn-sm" onclick="biayatambah(' +
                key +
                ')">';
            item_pembelian += '<i class="fas fa-plus"></i>';
            item_pembelian += '</button>';
            item_pembelian += '</td>';
            item_pembelian += '</tr>';

            $('#tabel-pembelian').append(item_pembelian);
        }
    </script>

    <script>
        var data_pembelian = @json(session('data_pembelians4'));
        var jumlah_ban = 1;

        if (data_pembelian != null) {
            jumlah_ban = data_pembelian.length;
            $('#tabel-potongan').empty();
            var urutan = 0;
            $.each(data_pembelian, function(key, value) {
                urutan = urutan + 1;
                itemPembelian(urutan, key, value);
            });
        }

        var counter = 0;

        function addPesanan() {
            counter++;
            jumlah_ban = jumlah_ban + 1;

            if (jumlah_ban === 1) {
                $('#tabel-potongan').empty();
            } else {
                // Find the last row and get its index to continue the numbering
                var lastRow = $('#tabel-potongan tr:last');
                var lastRowIndex = lastRow.find('#urutanpotongan').text();
                jumlah_ban = parseInt(lastRowIndex) + 1;
            }

            console.log('Current jumlah_ban:', jumlah_ban);
            itemPembelian(jumlah_ban, jumlah_ban - 1);
            updateUrutans();
        }


        function updateUrutans() {
            var urutan = document.querySelectorAll('#urutanpotongan');
            for (let i = 0; i < urutan.length; i++) {
                urutan[i].innerText = i + 1;
            }
        }


        function removeBan(identifier, detailId) {
            var row = document.getElementById('potongan-' + identifier);
            row.remove();

            console.log(detailId);
            $.ajax({
                url: "{{ url('admin/inquery_memoekspedisi/deletedetailbiayapotongan/') }}/" + detailId,
                type: "POST",
                data: {
                    _method: 'DELETE',
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log('Data deleted successfully');
                },
                error: function(error) {
                    console.error('Failed to delete data:', error);
                }
            });

            updateTotalpotongan()
            updateSubTotals()
            updateUrutans();
        }

        function itemPembelian(identifier, key, value = null) {
            var potongan_memo_id = '';
            var kode_potongan = '';
            var keterangan_potongan = '';
            var nominal_potongan = '';

            if (value !== null) {
                potongan_memo_id = value.potongan_memo_id;
                kode_potongan = value.kode_potongan;
                keterangan_potongan = value.keterangan_potongan;
                nominal_potongan = value.nominal_potongan;

            }

            // urutan 
            var item_pembelian = '<tr id="potongan-' + key + '">';
            item_pembelian += '<td  style="width: 70px; font-size:14px" class="text-center" id="urutanpotongan">' + key +
                '</td>';

            // potongan_memo_id 
            item_pembelian += '<td hidden>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" id="potongan_memo_id-' + key +
                '" name="potongan_memo_id[]" value="' + potongan_memo_id + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // kode_potongan 
            item_pembelian += '<td onclick="potonganmemo(' +
                key +
                ')">';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" style="font-size:14px" readonly id="kode_potongan-' +
                key +
                '" name="kode_potongan[]" value="' + kode_potongan + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // keterangan_potongan 
            item_pembelian += '<td onclick="potonganmemo(' +
                key +
                ')">';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control" style="font-size:14px" readonly id="keterangan_potongan-' +
                key +
                '" name="keterangan_potongan[]" value="' + keterangan_potongan + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // nominal_potongan 
            item_pembelian += '<td onclick="potonganmemo(' +
                key +
                ')">';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control" style="font-size:14px" readonly id="nominal_potongan-' +
                key +
                '" name="nominal_potongan[]" value="' + nominal_potongan + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            //
            item_pembelian += '<td style="width: 100px">';
            item_pembelian +=
                '<button  style="margin-left:5px" type="button" class="btn btn-danger btn-sm" onclick="removeBan(' +
                key + ')">';
            item_pembelian += '<i class="fas fa-trash"></i>';
            item_pembelian += '</button>';
            item_pembelian +=
                '<button  style="margin-left:3px" type="button" class="btn btn-primary btn-sm" onclick="potonganmemo(' +
                key +
                ')">';
            item_pembelian += '<i class="fas fa-plus"></i>';
            item_pembelian += '</button>';
            item_pembelian += '</td>';
            item_pembelian += '</tr>';

            $('#tabel-potongan').append(item_pembelian);
        }
    </script>

    <script>
        function updateTotalpotongan() {
            var grandTotal = 0;

            // Iterate through all input elements with IDs starting with 'total-'
            $('input[id^="nominal_potongan-"]').each(function() {
                // Remove dots and replace comma with dot, then parse as float
                var nilaiTotal = parseFloat($(this).val().replace(/\./g, '').replace(',', '.')) || 0;
                grandTotal += nilaiTotal;
            });

            // Format grandTotal as currency in Indonesian Rupiah
            var formattedGrandTotal = grandTotal.toLocaleString('id-ID');
            console.log(formattedGrandTotal);
            // Set the formatted grandTotal to the target element
            $('#potongan_memo').val(formattedGrandTotal);
        }
    </script>

    <script>
        function updateTotaltambahan() {
            var grandTotal = 0;

            // Iterate through all input elements with IDs starting with 'total-'
            $('input[id^="nominal-"]').each(function() {
                // Remove dots and replace comma with dot, then parse as float
                var nilaiTotal = parseFloat($(this).val().replace(/\./g, '').replace(',', '.')) || 0;
                grandTotal += nilaiTotal;
            });

            // Format grandTotal as currency in Indonesian Rupiah
            var formattedGrandTotal = grandTotal.toLocaleString('id-ID');
            console.log(formattedGrandTotal);
            // Set the formatted grandTotal to the target element
            $('#harga_tambahan').val(formattedGrandTotal);
            // $('#harga_tambahanborong').val(formattedGrandTotal);
        }
    </script>

@endsection
