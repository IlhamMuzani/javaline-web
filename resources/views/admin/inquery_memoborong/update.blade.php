@extends('layouts.app')

@section('title', 'Inquery Memo Borong')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Inquery Memo Borong</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/inquery_memoborong') }}">Memo Borong</a></li>
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
            <form action="{{ url('admin/inquery_memoborong/' . $inquery->id) }}" method="POST"
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
                            <div class="col-md-6">
                                <div class="card">
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
                                            <label for="kendaraan_id">No pol</label>
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

                            <div class="col-md-6">
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
                    </div>

                    <div class="card" id="form_borongan">
                        <div class="card-header">
                            <h3 class="card-title">Rute Perjalanan <span>
                                    {{-- <p style="font-size: 13px">(Tambahkan rute perjalanan)</p> --}}
                                </span></h3>
                            {{-- <div class="float-right">
                            <button type="button" class="btn btn-primary btn-sm" onclick="addRute()">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div> --}}
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="font-size:14px" class="text-center">No</th>
                                        <th style="font-size:14px">Kode Rute</th>
                                        <th style="font-size:14px">Nama Rute</th>
                                        <th style="font-size:14px">Harga</th>
                                        <th style="font-size:14px">Qty</th>
                                        <th style="font-size:14px">Satuan</th>
                                        <th style="font-size:14px">Total</th>
                                        <th style="font-size:14px">Opsi</th>
                                    </tr>
                                </thead>
                                <tbody id="tabel-rute">
                                    <tr id="rute-0">
                                        <td style="width: 70px; font-size:14px" class="text-center" id="urutanrute">1
                                        </td>
                                        <td hidden>
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="rute_id" name="rute_id"
                                                    value="{{ old('rute_id', $inquery->rute_id) }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input onclick="showCategoryModalRuts(this.value)"
                                                    onclick="showCategoryModalRuts(this.value)" style="font-size:14px"
                                                    type="text" class="form-control" readonly id="kode_rutes"
                                                    name="kode_rutes"
                                                    value="{{ old('kode_rutes', $inquery->kode_rute) }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input onclick="showCategoryModalRuts(this.value)" style="font-size:14px"
                                                    type="text" class="form-control" readonly id="nama_rutes"
                                                    name="nama_rutes"
                                                    value="{{ old('nama_rutes', $inquery->nama_rute) }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input onclick="showCategoryModalRuts(this.value)" style="font-size:14px"
                                                    type="text" class="form-control harga_rute" readonly
                                                    id="harga_rute"
                                                    value="{{ old('harga_rute', number_format($inquery->harga_rute, 0, ',', '.')) }}"
                                                    name="harga_rute" data-row-id="0">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input style="font-size:14px" type="text" class="form-control jumlah"
                                                    id="jumlah" name="jumlah"
                                                    value="{{ old('jumlah', $inquery->jumlah) }}" data-row-id="0"
                                                    onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || event.charCode === 46">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <select style="font-size:14px" class="form-control" id="satuan"
                                                    name="satuan">
                                                    <option value="">- Pilih -</option>
                                                    <option value="pcs"
                                                        {{ old('satuan', $inquery->satuan) == 'pcs' ? 'selected' : null }}>
                                                        pcs</option>
                                                    <option value="ltr"
                                                        {{ old('satuan', $inquery->satuan) == 'ltr' ? 'selected' : null }}>
                                                        ltr</option>
                                                    <option value="ton"
                                                        {{ old('satuan', $inquery->satuan) == 'ton' ? 'selected' : null }}>
                                                        ton</option>
                                                    <option value="dus"
                                                        {{ old('satuan', $inquery->satuan) == 'dus' ? 'selected' : null }}>
                                                        dus</option>
                                                    <option value="kubik"
                                                        {{ old('kubik', $inquery->satuan) == 'kubik' ? 'selected' : null }}>
                                                        kubik</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input onclick="showCategoryModalRuts(this.value)" style="font-size:14px"
                                                    type="text" class="form-control totalrute" readonly id="totalrute"
                                                    name="totalrute" value="{{ old('totalrute', $inquery->totalrute) }}">
                                            </div>
                                        </td>
                                        <td style="width: 50px">
                                            <button type="button" class="btn btn-primary btn-sm"
                                                onclick="showCategoryModalRuts(this.value)">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                            {{-- <button style="margin-left:5px" type="button" class="btn btn-danger btn-sm"
                                            onclick="removerute(0)">
                                            <i class="fas fa-trash"></i>
                                        </button> --}}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
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
                                        <td style="width: 70px; font-size:14px" class="text-center" id="urutan">
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
                                                    id="biaya_tambahan_id-{{ $loop->index }}" name="biaya_tambahan_id[]"
                                                    value="{{ $detail['biaya_tambahan_id'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input onclick="biayatambah({{ $loop->index }})" style="font-size:14px"
                                                    type="text" class="form-control" readonly
                                                    id="kode_biaya-{{ $loop->index }}" name="kode_biaya[]"
                                                    value="{{ $detail['kode_biaya'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input onclick="biayatambah({{ $loop->index }})" style="font-size:14px"
                                                    type="text" class="form-control" readonly
                                                    id="nama_biaya-{{ $loop->index }}" name="nama_biaya[]"
                                                    value="{{ $detail['nama_biaya'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input onclick="biayatambah({{ $loop->index }})" style="font-size:14px"
                                                    type="text" class="form-control" id="nominal-{{ $loop->index }}"
                                                    readonly name="nominal[]"
                                                    value="{{ number_format($detail['nominal'], 0, ',', '.') }}">
                                            </div>
                                        </td>
                                        <td style="width: 100px">
                                            <button style="margin-left:5px" type="button" class="btn btn-danger btn-sm"
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

                <div class="card">
                    <div class="card-body">
                        <div id="borongpph">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label style="font-size:14px; margin-top:5px" for="tarif">PPH
                                                            <span style="margin-left:77px">:</span></label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input style=" font-size:14px;" type="text"
                                                            class="form-control" readonly placeholder="" value="2 %">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label style="font-size:14px; margin-top:5px"
                                                            for="tarif">Borong
                                                            <span style="margin-left:58px">:</span></label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input style=" font-size:14px;" type="text"
                                                            class="form-control" readonly placeholder="" value="50 %">
                                                    </div>
                                                </div>
                                            </div>
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
                                                            class="form-control pph2"id="depositsopir" name="depositsopir"
                                                            placeholder=""
                                                            value="{{ old('depositsopir', $inquery->deposit_driver) }}"
                                                            oninput="limitInputs()">
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
                                                            type="checkbox" id="additional_checkboxs"
                                                            name="additional_checkboxs" onchange="limitInputs()">
                                                        <label style="margin-left: 20px" class="form-check-label"
                                                            for="additional_checkbox">
                                                            Min Deposit 50.000
                                                        </label>
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
                                                        <label style="font-size:14px; margin-top:5px" for="tarif">Total
                                                            Borong
                                                            <span style="margin-left:20px">:</span></label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input style="text-align: end; font-size:14px;" type="text"
                                                            class="form-control" id="totalborong" readonly
                                                            name="total_borongs" placeholder=""
                                                            value="{{ old('total_borongs', number_format($inquery->total_borongs, 0, ',', '.')) }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label style="font-size:14px; margin-top:5px" for="tarif">PPH
                                                            <span style="margin-left:71px">:</span></label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input style="text-align: end; font-size:14px;" type="text"
                                                            class="form-control pph2" readonly id="pph2" readonly
                                                            name="pphs" placeholder=""
                                                            value="{{ old('pphs', number_format($inquery->pphs, 0, ',', '.')) }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label style="font-size:14px; margin-top:5px" for="tarif">Biaya
                                                            Tambahan
                                                            <span style="margin-left:17px">:</span></label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input style="text-align: end; font-size:14px;" type="text"
                                                            class="form-control pph2" readonly id="harga_tambahanborong"
                                                            readonly name="biaya_tambahan"
                                                            value="{{ old('biaya_tambahan', number_format($inquery->biaya_tambahan, 0, ',', '.')) }}">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label style="font-size:14px; margin-top:5px"
                                                            for="tarif">Administrasi
                                                            <span style="margin-left:19px">:</span></label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input style="text-align: end; font-size:14px;" type="text"
                                                            id="uangjaminanss" type="text"
                                                            class="form-control text-right" readonly name="uang_jaminans"
                                                            placeholder=""
                                                            value="{{ old('uang_jaminans', number_format($inquery->uang_jaminans, 0, ',', '.')) }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label style="font-size:14px; margin-top:5px"
                                                            for="tarif">Deposit Sopir
                                                            <span style="margin-left:14px">:</span></label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input style="text-align: end; font-size:14px;" type="text"
                                                            class="form-control" id="depositsopir2" readonly
                                                            name="depositsopir2" placeholder=""
                                                            value="{{ old('depositsopir2', $inquery->deposit_driver) }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
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
                                    {{-- <td hidden>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="biaya_id-0"
                                                        name="biaya_id[]">
                                                </div>
                                            </td> --}}
                                    <td>
                                        <div class="form-group">
                                            <textarea style="font-size:14px" type="text" class="form-control" id="keterangan" name="keterangan"
                                                placeholder="Masukan keterangan">{{ old('keterangan', $inquery->keterangan) }}</textarea>
                                            {{-- <input style="font-size:14px" type="text" class="form-control"
                                                id="kode_biaya-0" name="kode_biaya[]"> --}}
                                        </div>
                                    </td>
                                    {{-- <td>
                                        <div class="form-group">
                                            <input style="font-size:14px" type="text" readonly class="form-control"
                                                id="sisa_saldo" name="sisa_saldo"
                                                value="{{ old('sisa_saldo', $saldoTerakhir->latest()->first()->sisa_saldo) }}">
                                        </div>
                                    </td> --}}
                                    <td>
                                        <div class="form-group">
                                            <input style="font-size:14px; font-weight:bold; text-align:end" readonly
                                                type="text" class="form-control" id="sub_total" name="sub_total"
                                                value="{{ old('sub_total', $inquery->sub_total) }}"
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

        <div class="modal fade" id="tableRutes" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Rute Perjalanan</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive scrollbar m-2">
                            <table id="datatables5" class="table table-bordered table-striped">
                                <thead>
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
                                        <tr
                                            onclick="getRutes('{{ $rute_perjalanan->id }}', '{{ $rute_perjalanan->kode_rute }}', '{{ $rute_perjalanan->nama_rute }}', '{{ $rute_perjalanan->golongan1 }}' , '{{ $rute_perjalanan->golongan2 }}', '{{ $rute_perjalanan->golongan3 }}', '{{ $rute_perjalanan->golongan4 }}', '{{ $rute_perjalanan->golongan5 }}', '{{ $rute_perjalanan->golongan6 }}', '{{ $rute_perjalanan->golongan7 }}', '{{ $rute_perjalanan->golongan8 }}', '{{ $rute_perjalanan->golongan9 }}', '{{ $rute_perjalanan->golongan10 }}')">
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $rute_perjalanan->kode_rute }}
                                            </td>
                                            <td>{{ $rute_perjalanan->nama_rute }}
                                            </td>
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
                                                    {{ number_format($rute_perjalanan->golongan5, 0, ',', '.') }}
                                                </td>
                                            @else
                                                <td>Rp.0
                                                </td>
                                            @endif
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="getRutes('{{ $rute_perjalanan->id }}', '{{ $rute_perjalanan->kode_rute }}', '{{ $rute_perjalanan->nama_rute }}', '{{ $rute_perjalanan->golongan1 }}' , '{{ $rute_perjalanan->golongan2 }}', '{{ $rute_perjalanan->golongan3 }}', '{{ $rute_perjalanan->golongan4 }}', '{{ $rute_perjalanan->golongan5 }}', '{{ $rute_perjalanan->golongan6 }}', '{{ $rute_perjalanan->golongan7 }}', '{{ $rute_perjalanan->golongan8 }}', '{{ $rute_perjalanan->golongan9 }}', '{{ $rute_perjalanan->golongan10 }}')">
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
                                            onclick="getSelectedDatakendaraan('{{ $kendaraan->id }}', '{{ $kendaraan->no_kabin }}', '{{ $kendaraan->no_pol }}', '{{ $kendaraan->golongan->nama_golongan }}', '{{ $kendaraan->km }}')">
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $kendaraan->kode_kendaraan }}</td>
                                            <td>{{ $kendaraan->no_kabin }}</td>
                                            <td>{{ $kendaraan->golongan->nama_golongan }}</td>
                                            <td>{{ $kendaraan->km }}</td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="getSelectedDatakendaraan('{{ $kendaraan->id }}', '{{ $kendaraan->no_kabin }}', '{{ $kendaraan->no_pol }}', '{{ $kendaraan->golongan->nama_golongan }}', '{{ $kendaraan->km }}')">
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
        </div>
    </section>


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

            //  if (kategori === 'Memo Perjalanan') {
            //     // Set deposit_driver value based on SaldoDP
            //     if (parseFloat(SaldoDP) < 0) {
            //         document.getElementById('deposit_driver').value = 100000;
            //         document.getElementById('depositsdriverss').value = (100000).toLocaleString('id-ID');
            //     }
            //     updateSubTotals();
            // } else if (kategori === 'Memo Borong') {
            document.getElementById('depositsopir').value = 100000;
            document.getElementById('depositsopir2').value = (100000).toLocaleString('id-ID');
            // depositsopir
            updateSubTotal();
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

        function showCategoryModalRuts(selectedCategory) {
            $('#tableRutes').modal('show');
        }

        function getRutes(Rutes_Id, KodeRutes, NamaRutes, Golongan1, Golongan2, Golongan3, Golongan4, Golongan5,
            Golongan6, Golongan7, Golongan8, Golongan9, Golongan10) {

            var Golongan = document.getElementById("golongan").value;
            // Set the values in the form fields
            document.getElementById('rute_id').value = Rutes_Id;
            document.getElementById('kode_rutes').value = KodeRutes;
            document.getElementById('nama_rutes').value = NamaRutes;
            // document.getElementById('harga_rute').value = HargaRute;

            if (Golongan === 'Golongan 1') {
                var Golongan1Value = parseFloat(Golongan1);
                document.getElementById('harga_rute').value = Golongan1Value.toLocaleString('id-ID');
            } else if (Golongan === 'Golongan 2') {
                var Golongan2Value = parseFloat(Golongan2);
                document.getElementById('harga_rute').value = Golongan2Value.toLocaleString('id-ID');
            } else if (Golongan === 'Golongan 3') {
                var Golongan3Value = parseFloat(Golongan3);
                document.getElementById('harga_rute').value = Golongan3Value.toLocaleString('id-ID');
            } else if (Golongan === 'Golongan 4') {
                var Golongan4Value = parseFloat(Golongan4);
                document.getElementById('harga_rute').value = Golongan4Value.toLocaleString('id-ID');
            } else if (Golongan === 'Golongan 5') {
                var Golongan5Value = parseFloat(Golongan5);
                document.getElementById('harga_rute').value = Golongan5Value.toLocaleString('id-ID');
            } else if (Golongan === 'Golongan 6') {
                var Golongan6Value = parseFloat(Golongan6);
                document.getElementById('harga_rute').value = Golongan6Value.toLocaleString('id-ID');
            } else if (Golongan === 'Golongan 7') {
                var Golongan7Value = parseFloat(Golongan7);
                document.getElementById('harga_rute').value = Golongan7Value.toLocaleString('id-ID');
            } else if (Golongan === 'Golongan 8') {
                var Golongan8Value = parseFloat(Golongan8);
                document.getElementById('harga_rute').value = Golongan8Value.toLocaleString('id-ID');
            } else if (Golongan === 'Golongan 9') {
                var Golongan9Value = parseFloat(Golongan9);
                document.getElementById('harga_rute').value = Golongan9Value.toLocaleString('id-ID');
            } else if (Golongan === 'Golongan 10') {
                var Golongan10Value = parseFloat(Golongan10);
                document.getElementById('harga_rute').value = Golongan10Value.toLocaleString('id-ID');
            }

            // Close the modal (if needed)
            $('#tableRutes').modal('hide');
        }
    </script>


    <script>
        $('#depositsopir').on('input', function() {
            // Mengambil nilai input nominal
            var nominalValue = $(this).val();
            // Memeriksa apakah input nominal kosong atau tidak
            if (nominalValue === "") {
                // Jika kosong, set form saldo masuk dan sub total menjadi 0
                $('#depositsopir2').val("0");
                updateSubTotal(); // Memanggil fungsi updateSubTotal tanpa argumen
            } else {
                // Jika tidak kosong, mengonversi nilai ke format rupiah
                var saldoMasukValue = formatRupiahs(nominalValue);

                // Menetapkan nilai ke input saldo masuk
                $('#depositsopir2').val(saldoMasukValue);

                // Memperbarui nilai sub total saat input nominal berubah
                updateSubTotal();
            }
        });

        document.addEventListener("DOMContentLoaded", function() {
            limitInputs();
        });

        var initialValue = {{ old('deposit_driver', $inquery->deposit_driver) }};

        function limitInputs() {
            var depositInput = document.getElementById("depositsopir");
            var depositInputss = document.getElementById("depositsopir2");
            var checkbox = document.getElementById("additional_checkboxs");

            // Assuming you have a global variable initialValue declared somewhere in your code
            var initialValue = {{ old('deposit_driver', $inquery->deposit_driver) }};

            // Function to reset the input value to the initial value if it's less than 50,000
            function resetToInitial() {
                depositInput.value = initialValue;
                depositInputss.value = formatRupiah(depositInput.value);
                updateSubTotal();
            }

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

            if (!checkbox.checked) {
                // If checkbox is not checked, set the input value to the initial value or 50,000, whichever is greater
                depositInput.value = Math.max(initialValue, 50000);
                resetToInitial();
            }
        }


        // function limitInputs() {
        //     var depositInput = document.getElementById("depositsopir");
        //     var depositInputss = document.getElementById("depositsopir2");
        //     var checkbox = document.getElementById("additional_checkboxs");

        //     if (!checkbox.checked) {
        //         // If checkbox is not checked, set the input value to 50000
        //         var defaultValue = 50000;

        //         depositInput.value = defaultValue;
        //         depositInputss.value = formatRupiah(defaultValue);
        //         depositInputsst.value = formatRupiah(defaultValue); // Update the value of depositInputsst as well
        //     }
        // }


        function formatRupiahs(angka) {
            var reverse = angka.toString().split('').reverse().join(''),
                ribuan = reverse.match(/\d{1,3}/g);
            ribuan = ribuan.join('.').split('').reverse().join('');
            return ribuan; // Mengembalikan hanya angka tanpa teks "Rp"
        }

        // Fungsi untuk menangani perubahan nilai pada input nominal
        $('#jumlah').on('input', function() {
            // Mengambil nilai input nominal
            var nominalValue = $(this).val();
        });

        function updateSubTotal() {
            // Mengambil nilai saldo masuk dan sisa saldo
            var saldoMasuk = parseCurrency($('#jumlah').val()) || 0;
            // var sisaSaldo = parseCurrency($('#harga_rute').val()) || 0;
            var sisaSaldo = $('#harga_rute').val().replace(/\./g, '') || 0;
            var HargaTambahan = parseCurrency($('#harga_tambahanborong').val().replace(/\./g, '')) || 0;
            var PPh2s = parseCurrency($('#pph2').val()) || 0;
            var UangJaminss = parseCurrency($('#uangjaminanss').val()) || 0;

            // Use parseFloat after removing commas and replacing dots with a decimal point
            var DepositSopirs = parseFloat(document.getElementById("depositsopir2").value.replace(/\./g, '').replace(
                /,/g, '.')) || 0;

            sisaSaldo = parseFloat(sisaSaldo) || 0;

            // Menghitung sub total
            var subTotal = saldoMasuk * sisaSaldo;
            var UangJaminan = saldoMasuk * sisaSaldo;

            // Menghitung 1% dari UangJaminan
            var satuPersenUangJaminan = 0.01 * UangJaminan;

            // Menghitung 2% dari UangJaminan
            var DuaPersenPPH = 0.02 * UangJaminan;

            // Mengonversi nilai sub total dan UangJaminan ke format rupiah
            var subTotalRupiah = formatRupiah(subTotal);
            var Total = subTotal;
            var UangJaminanRupiah = formatRupiah(UangJaminan);

            // Menetapkan nilai ke input sub total dan UangJaminan
            $('#totalrute').val(subTotalRupiah);

            // jika ingin total nominal ada titik
            // $('#totalrute').val(subTotalRupiah);
            $('#totalborong').val(subTotalRupiah);

            // Menetapkan nilai 1% dari UangJaminan ke input uang_jaminan_1_persen
            $('#uang_jaminan').val(formatRupiah(satuPersenUangJaminan));

            // Menetapkan nilai 2% dari UangJaminan ke input pph2
            $('#pph2').val(formatRupiah(DuaPersenPPH));

            // Menetapkan nilai 1% dari UangJaminan ke input uangjaminanss

            // Menghitung HasilTotals
            var HasilTotals = subTotal - satuPersenUangJaminan - DuaPersenPPH - DepositSopirs;
            var HasilGrand = (subTotal - DuaPersenPPH) / 2;
            var grandbaru = HasilGrand - satuPersenUangJaminan - DepositSopirs;

            var GrandBarus = subTotal - DuaPersenPPH;
            var GrandBarus2 = GrandBarus / 2;
            var GrandBarus23 = GrandBarus2 + HargaTambahan;
            console.log(GrandBarus23);

            var satupersenbaru = 0.01 * GrandBarus23;

            $('#uangjaminanss').val(formatRupiah(satupersenbaru));

            // seharusnya disini ada biaya tambahan 

            var GrandBarus3 = GrandBarus23 - satupersenbaru
            var GrandBarus4 = GrandBarus3 - DepositSopirs
            // Menghitung dan membulatkan nilai SubTotal
            var SubTotal = Math.round(HasilTotals / 2);

            // Menetapkan nilai ke input hasilsss dan sub_total
            // $('#hasilsss').val(formatRupiah(GrandBarus4));
            $('#sub_total').val(formatRupiah(GrandBarus4));
            // $('#hasil_barus').val(formatRupiah(GrandBarus4));
        }

        function parseCurrency(value) {
            return parseFloat(value.replace(/[^\d.-]/g, '')) || 0;
        }

        function formatRupiah(value) {
            return value.toLocaleString('id-ID');
        }

        $(document).on("input", "#jumlah, #harga_rute, #pph2, #depositsopir2", function() {
            updateSubTotal();
        });

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
            updateSubTotal();

        }
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
            updateSubTotal()
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
            // $('#harga_tambahan').val(formattedGrandTotal);
            $('#harga_tambahanborong').val(formattedGrandTotal);
        }
    </script>


@endsection
