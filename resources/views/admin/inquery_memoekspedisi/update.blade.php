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
                        <i class="icon fas fa-ban"></i> Error!
                    </h5>
                    @foreach (session('error') as $error)
                        - {{ $error }} <br>
                    @endforeach
                </div>
            @endif

            @if (session('error_pelanggans') || session('error_pesanans'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-ban"></i> Error!
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
                                                name="kendaraan_id" placeholder="" value="{{ old('kendaraan_id') }}">
                                        </div>
                                        {{-- <div class="form-group">
                                    <label for="no_kabin">No. Kabin</label>
                                    <input type="text" class="form-control" id="no_kabin" readonly name="no_kabin"
                                        placeholder="" value="{{ old('no_kabin') }}">
                                </div> --}}
                                        <label style="font-size:14px" class="form-label" for="no_kabin">No. Kabin</label>
                                        <div class="form-group d-flex">
                                            <input class="form-control" id="no_kabin" name="no_kabin" type="text"
                                                placeholder="" value="{{ old('no_kabin') }}" readonly
                                                style="margin-right: 10px; font-size:14px" />
                                            <button class="btn btn-primary" type="button"
                                                onclick="showCategoryModalkendaraan(this.value)">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                        <div class="form-group">
                                            <label style="font-size:14px" for="golongan">Gol. Kendaraan</label>
                                            <input style="font-size:14px" type="text" class="form-control" id="golongan"
                                                readonly name="golongan" placeholder="" value="{{ old('golongan') }}">
                                        </div>
                                        <div class="form-group">
                                            <label style="font-size:14px" for="km">KM Awal</label>
                                            <input style="font-size:14px" type="text" class="form-control" id="km"
                                                readonly name="km_awal" placeholder="" value="{{ old('km_awal') }}">
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
                                                name="user_id" placeholder="" value="{{ old('user_id') }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="kode_driver">kode Sopir</label>
                                            <input type="text" class="form-control" id="kode_driver" readonly
                                                name="kode_driver" placeholder="" value="{{ old('kode_driver') }}">
                                        </div>
                                        <label style="font-size:14px" class="form-label" for="nama_driver">Nama
                                            Sopir</label>
                                        <div class="form-group d-flex">
                                            <input class="form-control" id="nama_driver" name="nama_driver"
                                                type="text" placeholder="" value="{{ old('nama_driver') }}" readonly
                                                style="margin-right: 10px;font-size:14px" />
                                            <button class="btn btn-primary" type="button"
                                                onclick="showCategoryModaldriver(this.value)">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                        <div class="form-group">
                                            <label style="font-size:14px" for="telp">No. Telp</label>
                                            <input style="font-size:14px" type="tex" class="form-control"
                                                id="telp" readonly name="telp" placeholder=""
                                                value="{{ old('telp') }}">
                                        </div>
                                        <div class="form-group">
                                            <label style="font-size:14px" for="saldo_deposit">Saldo Deposit</label>
                                            <input style="font-size:14px" type="text" class="form-control"
                                                id="saldo_deposit" readonly name="saldo_deposit" placeholder=""
                                                value="{{ old('saldo_deposit') }}">
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
                                                value="{{ old('rute_perjalanan_id') }}">
                                        </div>

                                        <label style="font-size:14px" class="form-label" for="kode_rute">Kode
                                            Rute</label>
                                        <div class="form-group d-flex">
                                            <input class="form-control" id="kode_rute" name="kode_rute" type="text"
                                                placeholder="" value="{{ old('kode_rute') }}" readonly
                                                style="margin-right: 10px; font-size:14px" />
                                            <button class="btn btn-primary" type="button"
                                                onclick="showCategoryModalrute(this.value)">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                        <div class="form-group">
                                            <label style="font-size:14px" for="rute_perjalanan">Rute Perjalanan</label>
                                            <input style="font-size:14px" type="text" class="form-control"
                                                id="rute_perjalanan" readonly name="nama_rute" placeholder=""
                                                value="{{ old('nama_rute') }}">
                                        </div>
                                        <div class="form-group">
                                            <label style="font-size:14px" for="biaya">Uang Jalan</label>
                                            <input style="font-size:14px" type="text" class="form-control"
                                                id="biaya" readonly name="uang_jalan" placeholder=""
                                                value="{{ old('uang_jalan') }}" onclick="calculateHasilUangjaminan()">
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
                                                name="pelanggan_id" placeholder="" value="{{ old('pelanggan_id') }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="kode_pelanggan">kode Pelanggan</label>
                                            <input type="text" class="form-control" id="kode_pelanggan" readonly
                                                name="kode_pelanggan" placeholder=""
                                                value="{{ old('kode_pelanggan') }}">
                                        </div>
                                        <label style="font-size:14px" class="form-label" for="nama_pelanggan">Nama
                                            Pelanggan</label>
                                        <div class="form-group d-flex">
                                            <input class="form-control" id="nama_pell" name="nama_pelanggan"
                                                type="text" placeholder="" value="{{ old('nama_pelanggan') }}"
                                                readonly style="margin-right: 10px; font-size:14px" />
                                            <button class="btn btn-primary" type="button"
                                                onclick="showCategoryModalPelanggan(this.value)">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                        <div class="form-group">
                                            <label style="font-size:14px" for="alamat_pelanggan">Alamat</label>
                                            <input style="font-size:14px" type="text" class="form-control"
                                                id="alamat_pelanggan" readonly name="alamat_pelanggan" placeholder=""
                                                value="{{ old('alamat_pelanggan') }}">
                                        </div>
                                        <div class="form-group">
                                            <label style="font-size:14px" for="telp_pelanggan">No. Telp</label>
                                            <input style="font-size:14px" type="text" class="form-control"
                                                id="telp_pelanggan" readonly name="telp_pelanggan" placeholder=""
                                                value="{{ old('telp_pelanggan') }}">
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
                                        <tr id="pembelian-0">
                                            <td style="width: 70px; font-size:14px" class="text-center" id="urutan">1
                                            </td>
                                            <td hidden>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="biaya_id-0"
                                                        name="biaya_id[]">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="text" class="form-control"
                                                        readonly id="kode_biaya-0" name="kode_biaya[]">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="text" class="form-control"
                                                        readonly id="nama_biaya-0" name="nama_biaya[]">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="text" class="form-control"
                                                        id="nominal-0" readonly name="nominal[]">
                                                </div>
                                            </td>
                                            <td style="width: 50px">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="biayatambah(0)">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                                {{-- <button style="margin-left:5px" type="button" class="btn btn-danger btn-sm"
                                            onclick="removeBan(0)">
                                            <i class="fas fa-trash"></i>
                                        </button> --}}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card" id="form_potonganmemo">
                            <div class="card-header">
                                <h3 class="card-title">Potongan Memo <span>
                                    </span></h3>
                                <div class="float-right">
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
                                        <tr id="potongan-0">
                                            <td style="width: 70px; font-size:14px" class="text-center"
                                                id="urutanpotongan">1
                                            </td>
                                            <td hidden>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="potongan_id-0"
                                                        name="potongan_id[]">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="text" class="form-control"
                                                        readonly id="kode_potongan-0" name="kode_potongan[]">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="text" class="form-control"
                                                        readonly id="keteranganpotongan-0" name="keterangan_potongan[]">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="text" class="form-control"
                                                        id="nominalpotongan-0" readonly name="nominal_potongan[]">
                                                </div>
                                            </td>
                                            <td style="width: 50px">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="potonganmemo(0)">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <table class="table table-bordered table-striped">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="form-group" style="display: flex; align-items: center;">
                                                    <label style="font-size: 14px; margin-right: 50px;"
                                                        for="uangjalan">Uang Jalan</label>
                                                    <input style="width: 300px; font-size: 14px;" type="text"
                                                        class="form-control text-right" id="uangjalans" readonly
                                                        name="uangjalans" placeholder=""
                                                        value="{{ old('uangjalans') }}">
                                                    <label style="font-size: 14px; margin-right: 22px; margin-left:46px"
                                                        for="rute_perjalanan">Administrasi</label>
                                                    <input style="width: 300px; font-size: 14px;" type="text"
                                                        class="form-control" readonly placeholder="" value="1 %">
                                                </div>
                                                <div class="form-group" style="display: flex; align-items: center;">
                                                    <label style="font-size: 14px; margin-right: 18px;"
                                                        for="rute_perjalanan">Biaya Tambahan</label>
                                                    <input style="width: 300px; font-size: 14px;" type="text"
                                                        class="form-control text-right" id="harga_tambahan" readonly
                                                        name="biaya_tambahan" value="{{ old('biaya_tambahan') }}">
                                                    <label style="font-size: 14px; margin-right: 10px; margin-left:45px"
                                                        for="rute_perjalanan">Deposit Sopir</label>
                                                    <input style="width: 300px; font-size: 14px; margin-left:6px"
                                                        type="text" class="form-control" id="deposit_driver"
                                                        name="deposit_driver" value="{{ old('deposit_driver') }}"
                                                        placeholder="" oninput="limitInput()">
                                                </div>
                                                <div class="form-group" style="display: flex; align-items: center;">
                                                    <label style="font-size: 14px; margin-right: 20px;"
                                                        for="rute_perjalanan">Potongan Memo</label>
                                                    <input style="width: 300px; font-size: 14px;" type="text"
                                                        class="form-control text-right" id="potongan_memo" readonly
                                                        name="potongan_memo" placeholder=""
                                                        value="{{ old('potongan_memo') }}">
                                                    <input style="margin-left: 565px" class="form-check-input"
                                                        type="checkbox" id="additional_checkbox"
                                                        name="additional_checkbox" onchange="limitInput()">
                                                    <label style="margin-left: 170px" class="form-check-label"
                                                        for="additional_checkbox">
                                                        Min Deposit 50.000
                                                    </label>
                                                    {{-- <label style="font-size: 14px; margin-right: 78px;"
                                                        for="rute_perjalanan">Min Deposit 50.000</label> --}}

                                                </div>
                                                <div class="form-group" style="display: flex; align-items: center;">
                                                    <label style="font-size: 14px; margin-right: 42px;"
                                                        for="rute_perjalanan">Administrasi</label>
                                                    <input style="width: 300px; font-size: 14px;" id="uang_jaminan"
                                                        type="text" class="form-control text-right" readonly
                                                        name="uang_jaminan" placeholder=""
                                                        value="{{ old('uang_jaminan') }}">

                                                </div>
                                                <div class="form-group" style="display: flex; align-items: center;">
                                                    <label style="font-size: 14px; margin-right: 37px;"
                                                        for="rute_perjalanan">Deposit
                                                        Sopir</label>
                                                    <input style="width: 300px; font-size: 14px;" type="text"
                                                        class="form-control text-right" id="depositsdriverss" readonly
                                                        name="deposit_drivers" placeholder=""
                                                        value="{{ old('deposit_drivers') }}">
                                                    <label
                                                        style="color:white; font-size: 14px; margin-right: 65px; margin-left: 584px"
                                                        for="rute_perjalanan">.</label>


                                                </div>
                                                {{-- <div class="form-group" style="display: flex; align-items: center;">
                                                    <label style="font-size: 14px; margin-right: 89px;"
                                                        for="rute_perjalanan">Total</label>
                                                    <input style="width: 300px; font-size: 14px;" type="text"
                                                        class="form-control text-right" id="hasilsss" readonly
                                                        name="totals" placeholder="" value="{{ old('totals') }}"
                                                        onclick="calculateHasilsrute()">
                                                    
                                                </div> --}}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
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
                                            {{-- <td hidden>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="biaya_id-0"
                                                        name="biaya_id[]">
                                                </div>
                                            </td> --}}
                                            <td>
                                                <div class="form-group">
                                                    <textarea style="font-size:14px" type="text" class="form-control" id="keterangan" name="keterangan"
                                                        placeholder="Masukan keterangan">{{ old('keterangan') }}</textarea>
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
                                                    <input style="font-size:14px; font-weight:bold" readonly
                                                        type="text" class="form-control" id="sub_total"
                                                        name="sub_total" value="{{ old('sub_total') }}"
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
                                        <tr data-id="{{ $biayatambah->id }}"
                                            data-kode_biaya="{{ $biayatambah->kode_biaya }}"
                                            data-nama_biaya="{{ $biayatambah->nama_biaya }}"
                                            data-nominal="{{ $biayatambah->nominal }}" data-param="{{ $loop->index }}">
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $biayatambah->kode_biaya }}</td>
                                            <td>{{ $biayatambah->nama_biaya }}</td>
                                            <td>{{ $biayatambah->nominal }}</td>
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
                                        <tr data-id="{{ $potonganmemo->id }}"
                                            data-kode_potongan="{{ $potonganmemo->kode_potongan }}"
                                            data-keterangan="{{ $potonganmemo->keterangan }}"
                                            data-nominal="{{ $potonganmemo->nominal }}"
                                            data-param="{{ $loop->index }}">
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $potonganmemo->kode_potongan }}</td>
                                            <td>{{ $potonganmemo->keterangan }}</td>
                                            <td>{{ $potonganmemo->nominal }}</td>
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
                                        @foreach ($ruteperjalanans as $rute)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td>{{ $rute->kode_rute }}</td>
                                                <td>{{ $rute->nama_rute }}</td>
                                                @if ($rute->kategori == 'Golongan 1')
                                                    <td style="font-weight: bold">Rp.
                                                        {{ number_format($rute->harga, 0, ',', '.') }}
                                                    </td>
                                                @else
                                                    <td>Rp.0
                                                    </td>
                                                @endif
                                                @if ($rute->kategori == 'Golongan 2')
                                                    <td style="font-weight: bold">Rp.
                                                        {{ number_format($rute->harga, 0, ',', '.') }}
                                                    </td>
                                                @else
                                                    <td>Rp.0
                                                    </td>
                                                @endif
                                                @if ($rute->kategori == 'Golongan 3')
                                                    <td style="font-weight: bold">Rp.
                                                        {{ number_format($rute->harga, 0, ',', '.') }}
                                                    </td>
                                                @else
                                                    <td>Rp.0
                                                    </td>
                                                @endif
                                                @if ($rute->kategori == 'Golongan 4')
                                                    <td style="font-weight: bold">Rp.
                                                        {{ number_format($rute->harga, 0, ',', '.') }}
                                                    </td>
                                                @else
                                                    <td>Rp.0
                                                    </td>
                                                @endif
                                                @if ($rute->kategori == 'Golongan 5')
                                                    <td style="font-weight: bold">Rp.
                                                        {{ number_format($rute->harga, 0, ',', '.') }}
                                                    </td>
                                                @else
                                                    <td>Rp.0
                                                    </td>
                                                @endif
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        onclick="getSelectedDatarute('{{ $rute->id }}', '{{ $rute->kode_rute }}', '{{ $rute->nama_rute }}', '{{ $rute->harga }}')">
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
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td>{{ $kendaraan->kode_kendaraan }}</td>
                                                <td>{{ $kendaraan->no_kabin }}</td>
                                                <td>{{ $kendaraan->golongan->nama_golongan }}</td>
                                                <td>{{ $kendaraan->km }}</td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        onclick="getSelectedDatakendaraan('{{ $kendaraan->id }}', '{{ $kendaraan->no_kabin }}', '{{ $kendaraan->golongan->nama_golongan }}', '{{ $kendaraan->km }}')">
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
                                            <tr>
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
        }

        function showCategoryModalkendaraan(selectedCategory) {
            $('#tableKendaraan').modal('show');
        }

        function getSelectedDatakendaraan(Kendaraan_id, NoKabin, Golongan, Km) {
            // Set the values in the form fields
            document.getElementById('kendaraan_id').value = Kendaraan_id;
            document.getElementById('no_kabin').value = NoKabin;
            document.getElementById('golongan').value = Golongan;
            document.getElementById('km').value = Km;
            // Close the modal (if needed)
            $('#tableKendaraan').modal('hide');
        }

        function showCategoryModalrute(selectedCategory) {
            $('#tableRute').modal('show');
        }

        function getSelectedDatarute(Rute_id, KodeRute, NamaRute, Harga) {
            // Set the values in the form fields
            document.getElementById('rute_perjalanan_id').value = Rute_id;
            document.getElementById('kode_rute').value = KodeRute;
            document.getElementById('rute_perjalanan').value = NamaRute;
            document.getElementById('biaya').value = Harga;

            // document.getElementById('sub_total').value = Harga;

            // Check if the selected category is not "Memo Tambahan"
            var selectedCategory = document.getElementById('kategori').value;
            if (selectedCategory !== 'Memo Tambahan') {
                // Calculate 1% of the Harga for Uangjaminan
                var Uangjaminan = Harga * 0.01;

                // Set the value in the form field for Uangjaminan
                document.getElementById('uang_jaminan').value = Uangjaminan;
            }

            // Close the modal (if needed)
            $('#tableRute').modal('hide');
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
            $('#potongan_id-' + activeSpecificationIndex).val(Potongan_id);
            $('#kode_potongan-' + activeSpecificationIndex).val(KodePotongan);
            $('#keteranganpotongan-' + activeSpecificationIndex).val(Keterangan);
            $('#nominalpotongan-' + activeSpecificationIndex).val(Nominal);

            $('#tablePotongans').modal('hide');
        }


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
            var HargaTambahan = selectedRow.data('harga_tambahan');

            // Update the form fields for the active specification
            $('#biaya_id-' + activeSpecificationIndex).val(Biaya_id);
            $('#kode_biaya-' + activeSpecificationIndex).val(KodeBiaya);
            $('#nama_biaya-' + activeSpecificationIndex).val(NamabIaya);
            $('#nominal-' + activeSpecificationIndex).val(Nominal);
            $('#harga_tambahan-' + activeSpecificationIndex).val(HargaTambahan);

            $('#tableBiaya').modal('hide');
        }
    </script>


    <script>
        var data_pembelian = @json(session('data_pembelians'));
        var jumlah_ban = 1;

        if (data_pembelian != null) {
            jumlah_ban = data_pembelian.length;
            $('#tabel-pembelian').empty();
            var urutan = 0;
            $.each(data_pembelian, function(key, value) {
                urutan = urutan + 1;
                itemPembelian(urutan, key, value);
            });
        }

        function addPesanan() {
            jumlah_ban = jumlah_ban + 1;

            if (jumlah_ban === 1) {
                $('#tabel-pembelian').empty();
            }

            itemPembelian(jumlah_ban, jumlah_ban - 1);
        }

        function removeBan(params) {
            jumlah_ban = jumlah_ban - 1;

            var tabel_pesanan = document.getElementById('tabel-pembelian');
            var pembelian = document.getElementById('pembelian-' + params);

            tabel_pesanan.removeChild(pembelian);

            if (jumlah_ban === 0) {
                var item_pembelian = '<tr>';
                item_pembelian += '<td class="text-center" colspan="5">- Biaya tambahan belum ditambahkan -</td>';
                item_pembelian += '</tr>';
                $('#tabel-pembelian').html(item_pembelian);
            } else {
                var urutan = document.querySelectorAll('#urutan');
                for (let i = 0; i < urutan.length; i++) {
                    urutan[i].innerText = i + 1;
                }
            }
        }

        function itemPembelian(urutan, key, value = null) {
            var biaya_id = '';
            var kode_biaya = '';
            var nama_biaya = '';
            var nominal = '';

            if (value !== null) {
                biaya_id = value.biaya_id;
                kode_biaya = value.kode_biaya;
                nama_biaya = value.nama_biaya;
                nominal = value.nominal;
            }

            // urutan 
            var item_pembelian = '<tr id="pembelian-' + urutan + '">';
            item_pembelian += '<td style="width: 70px; font-size:14px" class="text-center" id="urutan-' + urutan + '">' +
                urutan + '</td>';

            // biaya_id 
            item_pembelian += '<td hidden>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" id="biaya_id-' + urutan +
                '" name="biaya_id[]" value="' + biaya_id + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // kode_biaya 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" style="font-size:14px" readonly id="kode_biaya-' +
                urutan +
                '" name="kode_biaya[]" value="' + kode_biaya + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // nama_biaya 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" style="font-size:14px" readonly id="nama_biaya-' +
                urutan +
                '" name="nama_biaya[]" value="' + nama_biaya + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // nominal 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" style="font-size:14px" readonly id="nominal-' +
                urutan +
                '" name="nominal[]" value="' + nominal + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            item_pembelian += '<td style="width: 50px">';
            item_pembelian += '<button type="button" class="btn btn-primary btn-sm" onclick="biayatambah(' + urutan + ')">';
            item_pembelian += '<i class="fas fa-plus"></i>';
            item_pembelian += '</button>';
            // item_pembelian +=
            //     '<button style="margin-left:5px" type="button" class="btn btn-danger btn-sm" onclick="removeBan(' +
            //     urutan + ')">';
            // item_pembelian += '<i class="fas fa-trash"></i>';
            // item_pembelian += '</button>';
            item_pembelian += '</td>';
            item_pembelian += '</tr>';

            $('#tabel-pembelian').append(item_pembelian);
        }
    </script>

    <script>
        var data_pembelian = @json(session('data_pembelians3'));
        var jumlah_ban = 1;

        if (data_pembelian != null) {
            jumlah_ban = data_pembelian.length;
            $('#tabel-potongan').empty();
            var urutan = 0;
            $.each(data_pembelian, function(key, value) {
                urutan = urutan + 1;
                itemPembelians(urutan, key, value);
            });
        }

        function addPesanan() {
            jumlah_ban = jumlah_ban + 1;

            if (jumlah_ban === 1) {
                $('#tabel-potongan').empty();
            }

            itemPembelians(jumlah_ban, jumlah_ban - 1);
        }

        function removeBan(params) {
            jumlah_ban = jumlah_ban - 1;

            var tabel_pesanan = document.getElementById('tabel-potongan');
            var pembelian = document.getElementById('potongan-' + params);

            tabel_pesanan.removeChild(pembelian);

            if (jumlah_ban === 0) {
                var item_pembelian = '<tr>';
                item_pembelian += '<td class="text-center" colspan="5">- Potongan memo belum ditambahkan -</td>';
                item_pembelian += '</tr>';
                $('#tabel-potongan').html(item_pembelian);
            } else {
                var urutan = document.querySelectorAll('#urutan');
                for (let i = 0; i < urutan.length; i++) {
                    urutan[i].innerText = i + 1;
                }
            }
        }

        function itemPembelians(urutan, key, value = null) {
            var potongan_id = '';
            var kode_potongan = '';
            var keterangan_potongan = '';
            var nominal_potongan = '';

            if (value !== null) {
                potongan_id = value.potongan_id;
                kode_potongan = value.kode_potongan;
                keterangan_potongan = value.keterangan_potongan;
                nominal_potongan = value.nominal_potongan;
            }

            // urutan 
            var item_pembelian = '<tr id="potongan-' + urutan + '">';
            item_pembelian += '<td style="width: 70px; font-size:14px" class="text-center" id="urutanpotongan-' + urutan +
                '">' +
                urutan + '</td>';

            // potongan_id 
            item_pembelian += '<td hidden>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" id="potongan_id-' + urutan +
                '" name="potongan_id[]" value="' + potongan_id + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // kode_potongan 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" style="font-size:14px" readonly id="kode_potongan-' +
                urutan +
                '" name="kode_potongan[]" value="' + kode_potongan + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // keterangan_potongan 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control" style="font-size:14px" readonly id="keterangan_potongan-' +
                urutan +
                '" name="keterangan_potongan[]" value="' + keterangan_potongan + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // nominal_potongan 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control" style="font-size:14px" readonly id="nominal_potongan-' +
                urutan +
                '" name="nominal_potongan[]" value="' + nominal_potongan + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            item_pembelian += '<td style="width: 50px">';
            item_pembelian += '<button type="button" class="btn btn-primary btn-sm" onclick="potonganmemo(' + urutan +
                ')">';
            item_pembelian += '<i class="fas fa-plus"></i>';
            item_pembelian += '</button>';
            // item_pembelian +=
            //     '<button style="margin-left:5px" type="button" class="btn btn-danger btn-sm" onclick="removeBan(' +
            //     urutan + ')">';
            // item_pembelian += '<i class="fas fa-trash"></i>';
            // item_pembelian += '</button>';
            item_pembelian += '</td>';
            item_pembelian += '</tr>';

            $('#tabel-potongan').append(item_pembelian);

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
            return "Rp " + value.toLocaleString('id-ID');
        }

        function updateSubTotals() {
            var Uangjalans = parseCurrency($('#biaya').val()) || 0;
            var PotonganMemo = parseCurrency($('#potongan_memo').val().replace(/\./g, '')) || 0;
            var HargaTambahan = parseCurrency($('#harga_tambahan').val().replace(/\./g, '')) || 0;
            var DepositDriv = parseCurrency($('#deposit_driver').val()) || 0;


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

        document.addEventListener("DOMContentLoaded", function() {
            limitInput();
        });

        function limitInput() {
            var depositInput = document.getElementById("deposit_driver");
            var depositInputss = document.getElementById("depositsdriverss");
            var depositInputsst = document.getElementById("depositsdriversst");
            var checkbox = document.getElementById("additional_checkbox");

            if (!checkbox.checked) {
                // If checkbox is not checked, set the input value to 50000
                var defaultValue = 50000;

                depositInput.value = defaultValue;
                depositInputss.value = formatRupiah(defaultValue);
                depositInputsst.value = formatRupiah(defaultValue);
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

@endsection
