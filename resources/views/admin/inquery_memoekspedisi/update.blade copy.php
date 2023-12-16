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
        <form action="{{ url('admin/inquery_memoekspedisi/' . $inquery->id) }}" method="POST" enctype="multipart/form-data" autocomplete="off">
            @csrf
            @method('put')
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Perbarui Memo Ekspedisi</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="form-group">
                        <label style="font-size:14px" class="form-label" for="kategori">Pilih Kategori</label>
                        <select style="font-size:14px" class="form-control" id="kategori" name="kategori">
                            <option value="">- Pilih -</option>
                            <option value="Memo Perjalanan" {{ old('kategori', $inquery->kategori) == 'Memo Perjalanan' ? 'selected' : null }}>
                                Memo Perjalanan</option>
                            <option value="Memo Borong" {{ old('kategori', $inquery->kategori) == 'Memo Borong' ? 'selected' : null }}>
                                Memo Borong</option>
                            <option value="Memo Tambahan" {{ old('kategori', $inquery->kategori) == 'Memo Tambahan' ? 'selected' : null }}>
                                Memo Tambahan</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
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
                                <input type="text" class="form-control" id="kendaraan_id" readonly name="kendaraan_id" placeholder="" value="{{ old('kendaraan_id', $inquery->kendaraan_id) }}">
                            </div>
                            {{-- <div class="form-group">
                                    <label for="no_kabin">No. Kabin</label>
                                    <input type="text" class="form-control" id="no_kabin" readonly name="no_kabin"
                                        placeholder="" value="{{ old('no_kabin') }}">
                        </div> --}}
                        <label style="font-size:14px" class="form-label" for="no_kabin">No. Kabin</label>
                        <div class="form-group d-flex">
                            <input class="form-control" id="no_kabin" name="no_kabin" type="text" placeholder="" value="{{ old('no_kabin', $inquery->no_kabin) }}" readonly style="margin-right: 10px; font-size:14px" />
                            <button class="btn btn-primary" type="button" onclick="showCategoryModalkendaraan(this.value)">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                        <div class="form-group">
                            <label style="font-size:14px" for="golongan">Gol. Kendaraan</label>
                            <input style="font-size:14px" type="text" class="form-control" id="golongan" readonly name="golongan" placeholder="" value="{{ old('golongan', $inquery->golongan) }}">
                        </div>
                        <div class="form-group">
                            <label style="font-size:14px" for="km">KM Awal</label>
                            <input style="font-size:14px" type="text" class="form-control" id="km" readonly name="km_awal" placeholder="" value="{{ old('km_awal', $inquery->km_awal) }}">
                        </div>
                        <div class="form-check" style="color:white">
                            <label class="form-check-label">
                                .
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Sopir</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group" hidden>
                            <label for="user_id">User Id</label>
                            <input type="text" class="form-control" id="user_id" readonly name="user_id" placeholder="" value="{{ old('user_id', $inquery->user_id) }}">
                        </div>
                        <div class="form-group" hidden>
                            <label for="kode_driver">kode Sopir</label>
                            <input type="text" class="form-control" id="kode_driver" readonly name="kode_driver" placeholder="" value="{{ old('kode_driver', $inquery->kode_driver) }}">
                        </div>
                        <label style="font-size:14px" class="form-label" for="nama_driver">Nama Sopir</label>
                        <div class="form-group d-flex">
                            <input class="form-control" id="nama_driver" name="nama_driver" type="text" placeholder="" value="{{ old('nama_driver', $inquery->nama_driver) }}" readonly style="margin-right: 10px;font-size:14px" />
                            <button class="btn btn-primary" type="button" onclick="showCategoryModaldriver(this.value)">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                        <div class="form-group">
                            <label style="font-size:14px" for="telp">No. Telp</label>
                            <input style="font-size:14px" type="tex" class="form-control" id="telp" readonly name="telp" placeholder="" value="{{ old('telp', $inquery->telp) }}">
                        </div>
                        <div class="form-group">
                            <label style="font-size:14px" for="saldo_deposit">Saldo Deposit</label>
                            <input style="font-size:14px" type="text" class="form-control" id="saldo_deposit" readonly name="saldo_deposit" placeholder="" value="{{ old('saldo_deposit', $inquery->saldo_deposit) }}">
                        </div>
                        <div class="form-check" style="color:white">
                            <label class="form-check-label">
                                .
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3" id="form_rute">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Rute Perjalanan</h3>
                    </div>
                    <div class="card-body">
                        {{-- <div class="mb-3">
                                    <button class="btn btn-primary btn-sm" type="button"
                                        onclick="showCategoryModalrute(this.value)">
                                        <i class="fas fa-search mr-1"></i> Search Rute
                                    </button>
                                </div> --}}
                        <div class="form-group" hidden>
                            <label for="rute_perjalanan_id">rute Id</label>
                            <input type="text" class="form-control" id="rute_perjalanan_id" readonly name="rute_perjalanan_id" placeholder="" value="{{ old('rute_perjalanan_id', $inquery->rute_perjalanan_id) }}">
                        </div>
                        {{-- <div class="form-group">
                                    <label for="kode_rute">Kode Rute</label>
                                    <input type="text" class="form-control" id="kode_rute" readonly name="kode_rute"
                                        placeholder="" value="{{ old('kode_rute') }}">
                    </div> --}}
                    <label style="font-size:14px" class="form-label" for="kode_rute">Kode Rute</label>
                    <div class="form-group d-flex">
                        <input class="form-control" id="kode_rute" name="kode_rute" type="text" placeholder="" value="{{ old('kode_rute', $inquery->kode_rute) }}" readonly style="margin-right: 10px; font-size:14px" />
                        <button class="btn btn-primary" type="button" onclick="showCategoryModalrute(this.value)">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <div class="form-group">
                        <label style="font-size:14px" for="rute_perjalanan">Rute Perjalanan</label>
                        <input style="font-size:14px" type="text" class="form-control" id="rute_perjalanan" readonly name="nama_rute" placeholder="" value="{{ old('nama_rute', $inquery->nama_rute) }}">
                    </div>
                    <div class="form-group">
                        <label style="font-size:14px" for="biaya">Uang Jalan</label>
                        <input style="font-size:14px" type="text" class="form-control" id="biaya" readonly name="uang_jalan" placeholder="" value="{{ old('uang_jalan', $inquery->uang_jalan) }}" onclick="calculateHasilUangjaminan()">
                    </div>
                    <div class="form-check" style="color:white">
                        <label class="form-check-label">
                            .
                        </label>
                    </div>
                </div>
            </div>
    </div>

    <div class="col-md-3" id="form_pelanggan" style="display: none;">
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
                    <input type="text" class="form-control" id="pelanggan_id" readonly name="pelanggan_id" placeholder="" value="{{ old('pelanggan_id', $inquery->pelanggan_id) }}">
                </div>
                <div class="form-group" hidden>
                    <label for="kode_pelanggan">kode Pelanggan</label>
                    <input type="text" class="form-control" id="kode_pelanggan" readonly name="kode_pelanggan" placeholder="" value="{{ old('kode_pelanggan', $inquery->kode_pelanggan) }}">
                </div>
                <label style="font-size:14px" class="form-label" for="nama_pelanggan">Nama
                    Pelanggan</label>
                <div class="form-group d-flex">
                    <input class="form-control" id="nama_pell" name="nama_pelanggan" type="text" placeholder="" value="{{ old('nama_pelanggan', $inquery->nama_pelanggan) }}" readonly style="margin-right: 10px; font-size:14px" />
                    <button class="btn btn-primary" type="button" onclick="showCategoryModalPelanggan(this.value)">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <div class="form-group">
                    <label style="font-size:14px" for="alamat_pelanggan">Alamat</label>
                    <input style="font-size:14px" type="text" class="form-control" id="alamat_pelanggan" readonly name="alamat_pelanggan" placeholder="" value="{{ old('alamat_pelanggan', $inquery->alamat_pelanggan) }}">
                </div>
                <div class="form-group">
                    <label style="font-size:14px" for="telp_pelanggan">No. Telp</label>
                    <input style="font-size:14px" type="text" class="form-control" id="telp_pelanggan" readonly name="telp_pelanggan" placeholder="" value="{{ old('telp_pelanggan', $inquery->telp_pelanggan) }}">
                </div>
                <div class="form-check" style="color:white">
                    <label class="form-check-label">
                        .
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Biaya</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label style="font-size:14px" for="uang_jaminan">Uang Jaminan</label>
                    <input style="font-size:14px" type="text" class="form-control" id="uang_jaminan" readonly name="uang_jaminan" placeholder="" value="{{ old('uang_jaminan', $inquery->uang_jaminan) }}">
                </div>

                <div class="form-group">
                    <label style="font-size:14px" for="harga_tambahan">Biaya Tambahan</label>
                    <input style="font-size:14px" type="text" class="form-control" id="harga_tambahan" name="biaya_tambahan" placeholder="" value="{{ old('biaya_tambahan', $inquery->biaya_tambahan) }}" onclick="calculateAndDisplayTotal()">
                </div>

                <div class="form-group">
                    <label style="font-size:14px" for="deposit_driver">Deposit Sopir</label>
                    <input style="font-size:14px" type="text" class="form-control" id="deposit_driver" name="deposit_driver" value="{{ old('deposit_driver', $inquery->deposit_driver) }}" placeholder="" oninput="limitInput()" onclick="calculateAndDeposit()">
                </div>
                <!-- Add checkbox below the form -->
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="additional_checkbox" name="additional_checkbox" onchange="limitInput()">
                    <label class="form-check-label" for="additional_checkbox">
                        Min Deposit 50.000
                    </label>
                </div>

            </div>
        </div>
    </div>
    </div>

    <div class="card" id="form_biayatambahan">
        <div class="card-header">
            <h3 class="card-title">Biaya Tambahan <span>
                    <p style="font-size: 13px">(Tambahkan biaya jika ada tambahan biaya)</p>
                </span></h3>
            <div class="float-right">
                <button type="button" class="btn btn-primary btn-sm" onclick="addPesanan()">
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
                        <th style="font-size:14px">Kode Akun</th>
                        <th style="font-size:14px">Nama Akun</th>
                        <th style="font-size:14px">Nominal</th>
                        <th style="font-size:14px">Opsi</th>
                    </tr>
                </thead>
                <tbody id="tabel-pembelian">
                    @foreach ($details as $detail)
                    <tr id="pembelian-{{ $loop->index }}">
                        <td style="width: 70px; font-size:14px" class="text-center" id="urutan">
                            {{ $loop->index + 1 }}
                        </td>
                        <td hidden>
                            <div class="form-group" hidden>
                                <input type="text" class="form-control" name="detail_ids[]" value="{{ $detail['id'] }}">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="biaya_id-0" name="biaya_id[]" value="{{ $detail['biaya_id'] }}">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input style="font-size:14px" type="text" class="form-control" readonly id="kode_biaya-0" name="kode_biaya[]" value="{{ $detail['kode_biaya'] }}">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input style="font-size:14px" type="text" class="form-control" readonly id="nama_biaya-0" name="nama_biaya[]" value="{{ $detail['nama_biaya'] }}">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input style="font-size:14px" type="text" class="form-control" id="nominal-0" readonly name="nominal[]" value="{{ $detail['nominal'] }}">
                            </div>
                        </td>
                        <td style="width: 100px">
                            <button type="button" class="btn btn-primary btn-sm" onclick="biayatambah(0)">
                                <i class="fas fa-plus"></i>
                            </button>
                            <button style="margin-left:5px" type="button" class="btn btn-danger btn-sm" onclick="removeBan(0)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="card" id="form_borongan">
        <div class="card-header">
            <h3 class="card-title">Rute Perjalanan <span>
                    <p style="font-size: 13px">(Tambahkan rute perjalanan)</p>
                </span></h3>
            <div class="float-right">
                <button type="button" class="btn btn-primary btn-sm" onclick="addRute()">
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
                    @foreach ($details as $detail)
                    <tr id="rute-{{ $loop->index }}">
                        <td style="width: 70px; font-size:14px" class="text-center" id="urutanrute">
                            {{ $loop->index + 1 }}
                        </td>
                        <td hidden>
                            <div class="form-group" hidden>
                                <input type="text" class="form-control" name="detail_ids[]" value="{{ $detail['id'] }}">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="rute_id-0" name="rute_id[]" value="{{ $detail['rute_id'] }}">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input style="font-size:14px" type="text" class="form-control" readonly id="kode_rutes-0" name="kode_rutes[]" value="{{ $detail['kode_rutes'] }}">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input style="font-size:14px" type="text" class="form-control" readonly id="nama_rutes-0" name="nama_rutes[]" value="{{ $detail['nama_rutes'] }}">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input style="font-size:14px" type="number" class="form-control harga_rute" readonly id="harga_rute-0" name="harga_rute[]" data-row-id="0" value="{{ $detail['harga_rute'] }}">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input style="font-size:14px" type="number" class="form-control jumlah" id="jumlah-0" name="jumlah[]" data-row-id="0" value="{{ $detail['jumlah'] }}">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <select style="font-size:14px" class="form-control" id="satuan" name="satuan[]">
                                    <option value="">- Pilih -</option>
                                    <option value="pcs" {{ old('satuan', $detail['satuan']) == 'pcs' ? 'selected' : null }}>
                                        pcs</option>
                                    <option value="ltr" {{ old('satuan', $detail['satuan']) == 'ltr' ? 'selected' : null }}>
                                        ltr</option>
                                    <option value="ton" {{ old('satuan', $detail['satuan']) == 'ton' ? 'selected' : null }}>
                                        ton</option>
                                    <option value="dus" {{ old('satuan', $detail['satuan']) == 'dus' ? 'selected' : null }}>
                                        dus</option>
                                </select>
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input style="font-size:14px" type="text" class="form-control totalrute" id="totalrute-0" name="totalrute[]" value="{{ $detail['totalrute'] }}" readonly>
                            </div>
                        </td>
                        <td style="width: 100px">
                            <button type="button" class="btn btn-primary btn-sm" onclick="rutebaru(0)">
                                <i class="fas fa-plus"></i>
                            </button>
                            <button style="margin-left:5px" type="button" class="btn btn-danger btn-sm" onclick="removerute(0)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card">
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-bordered table-striped" id="borongpph" style="display: none">
                <tbody>
                    <tr>
                        <td>
                            <div class="form-group" style="display: flex; align-items: center;">
                                <label style="font-size: 14px; margin-right: 30px;" for="rute_perjalanan">Total Borong</label>
                                <input style="width: 300px; font-size: 14px;" type="text" class="form-control text-right" id="totalborong" readonly name="total_borongs" placeholder="" value="{{ old('total_borongs', $inquery->total_borongs) }}">
                                <label style="font-size: 14px; margin-right: 70px; margin-left:48px" for="rute_perjalanan">PPH</label>
                                <input style="width: 300px; font-size: 14px;" type="text" class="form-control" readonly placeholder="" value="2 %">
                            </div>
                            <div class="form-group" style="display: flex; align-items: center;">
                                <label style="font-size: 14px; margin-right: 82px;" for="rute_perjalanan">PPH</label>
                                <input style="width: 300px; font-size: 14px;" type="text" class="form-control text-right" id="pph2" readonly name="pphs" placeholder="" value="{{ old('pphs', $inquery->pphs) }}">
                                <label style="font-size: 14px; margin-right: 52px; margin-left:47px" for="rute_perjalanan">Borong</label>
                                <input style="width: 300px; font-size: 14px;" type="text" class="form-control" readonly placeholder="" value="50 %">
                            </div>
                            <div class="form-group" style="display: flex; align-items: center;">
                                <label style="font-size: 14px; margin-right: 20px;" for="rute_perjalanan">Uang
                                    Jaminan</label>
                                <input style="width: 300px; font-size: 14px;" id="uangjaminanss" type="text" class="form-control text-right" readonly name="uang_jaminans" placeholder="" value="{{ old('uang_jaminans', $inquery->uang_jaminans) }}">
                                <label style="font-size: 14px; margin-right: 10px; margin-left:46px" for="rute_perjalanan">Uang Jaminan</label>
                                <input style="width: 300px; font-size: 14px;" type="text" class="form-control" readonly placeholder="" value="1 %">
                            </div>
                            <div class="form-group" style="display: flex; align-items: center;">
                                <label style="font-size: 14px; margin-right: 25px;" for="rute_perjalanan">Deposit Sopir</label>
                                <input style="width: 300px; font-size: 14px;" type="text" class="form-control text-right" id="depositsdriverss" readonly name="deposit_drivers" placeholder="" value="{{ old('deposit_drivers', $inquery->deposit_drivers) }}">
                                <label style="font-size: 14px; margin-right: 10px; margin-left:45px" for="rute_perjalanan">Deposit Sopir</label>
                                <input style="width: 300px; font-size: 14px; margin-left:6px" type="text" class="form-control" id="depositsdriversst" readonly name="depositsdriversst" placeholder="" value="{{ old('depositsdriversst', $inquery->deposit_drivers) }}">

                            </div>
                            <div class="form-group" style="display: flex; align-items: center;">
                                <label style="font-size: 14px; margin-right: 78px;" for="rute_perjalanan">Total</label>
                                <input style="width: 300px; font-size: 14px;" type="text" class="form-control text-right" id="hasilsss" readonly name="totals" placeholder="" value="{{ old('totals', $inquery->totals) }}" onclick="calculateHasilsrute()">
                                <label style="color:white; font-size: 14px; margin-right: 78px; margin-left: 585px" for="rute_perjalanan">.</label>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <br>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th style="font-size:14px">keterangan</th>
                        <th style="font-size:14px">Sisa Saldo</th>
                        <th style="font-size:14px">Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td hidden>
                            <div class="form-group">
                                <input type="text" class="form-control" id="biaya_id-0" name="biaya_id[]">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <textarea style="font-size:14px" type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Masukan keterangan">{{ old('keterangan', $inquery->keterangan) }}</textarea>
                                {{-- <input style="font-size:14px" type="text" class="form-control"
                                                id="kode_biaya-0" name="kode_biaya[]"> --}}
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input style="font-size:14px" type="text" readonly class="form-control" id="sisa_saldo" name="sisa_saldo" value="{{ old('sisa_saldo', $inquery->sisa_saldo) }}">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input style="font-size:14px; font-weight:bold" readonly type="text" class="form-control" id="sub_total" name="sub_total" value="{{ old('sub_total', $inquery->sub_total) }}" onclick="SubTotalss()">
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="card-footer text-right">
            <button type="reset" class="btn btn-secondary">Reset</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </div>
    </form>

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
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $pelanggan->kode_pelanggan }}</td>
                                <td>{{ $pelanggan->nama_pell }}</td>
                                <td>{{ $pelanggan->alamat }}</td>
                                <td>{{ $pelanggan->telp }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-primary btn-sm" onclick="getSelectedDataPelanggan('{{ $pelanggan->id }}', '{{ $pelanggan->kode_pelanggan }}', '{{ $pelanggan->nama_pell }}', '{{ $pelanggan->alamat }}', '{{ $pelanggan->telp }}')">
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
                    <table id="datatables3" class="table table-bordered table-striped">
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
                            <tr data-biaya_id="{{ $biayatambah->id }}" data-kode_biaya="{{ $biayatambah->kode_biaya }}" data-nama_biaya="{{ $biayatambah->nama_biaya }}" data-nominal="{{ $biayatambah->nominal }}" data-param="{{ $loop->index }}">
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $biayatambah->kode_biaya }}</td>
                                <td>{{ $biayatambah->nama_biaya }}</td>
                                <td>{{ $biayatambah->nominal }}</td>
                                <td class="text-center">
                                    <button type="button" id="btnTambah" class="btn btn-primary btn-sm" onclick="getBiaya({{ $loop->index }})">
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
                                        <button type="button" class="btn btn-primary btn-sm" onclick="getSelectedDatarute('{{ $rute->id }}', '{{ $rute->kode_rute }}', '{{ $rute->nama_rute }}', '{{ $rute->harga }}')">
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
                                @foreach ($ruteperjalanans as $ruteperjalanan)
                                <tr data-rute_perjalanan_id="{{ $ruteperjalanan->id }}" data-kode_rute="{{ $ruteperjalanan->kode_rute }}" data-nama_rute="{{ $ruteperjalanan->nama_rute }}" data-harga="{{ $ruteperjalanan->harga }}" data-param="{{ $loop->index }}">
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $ruteperjalanan->kode_rute }}</td>
                                    <td>{{ $ruteperjalanan->nama_rute }}</td>
                                    @if ($ruteperjalanan->kategori == 'Golongan 1')
                                    <td style="font-weight: bold">Rp.
                                        {{ number_format($ruteperjalanan->harga, 0, ',', '.') }}
                                    </td>
                                    @else
                                    <td>Rp.0
                                    </td>
                                    @endif
                                    @if ($ruteperjalanan->kategori == 'Golongan 2')
                                    <td style="font-weight: bold">Rp.
                                        {{ number_format($ruteperjalanan->harga, 0, ',', '.') }}
                                    </td>
                                    @else
                                    <td>Rp.0
                                    </td>
                                    @endif
                                    @if ($ruteperjalanan->kategori == 'Golongan 3')
                                    <td style="font-weight: bold">Rp.
                                        {{ number_format($ruteperjalanan->harga, 0, ',', '.') }}
                                    </td>
                                    @else
                                    <td>Rp.0
                                    </td>
                                    @endif
                                    @if ($ruteperjalanan->kategori == 'Golongan 4')
                                    <td style="font-weight: bold">Rp.
                                        {{ number_format($ruteperjalanan->harga, 0, ',', '.') }}
                                    </td>
                                    @else
                                    <td>Rp.0
                                    </td>
                                    @endif
                                    @if ($ruteperjalanan->kategori == 'Golongan 5')
                                    <td style="font-weight: bold">Rp.
                                        {{ number_format($ruteperjalanan->harga, 0, ',', '.') }}
                                    </td>
                                    @else
                                    <td>Rp.0
                                    </td>
                                    @endif
                                    <td class="text-center">
                                        <button type="button" id="btnTambah" class="btn btn-primary btn-sm" onclick="getRutes({{ $loop->index }})">
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
                                        <button type="button" class="btn btn-primary btn-sm" onclick="getSelectedDatakendaraan('{{ $kendaraan->id }}', '{{ $kendaraan->no_kabin }}', '{{ $kendaraan->golongan->nama_golongan }}', '{{ $kendaraan->km }}')">
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
                                        <button type="button" class="btn btn-primary btn-sm" onclick="getSelectedDatadriver('{{ $user->id }}', '{{ $user->karyawan->kode_karyawan }}', '{{ $user->karyawan->nama_lengkap }}', '{{ $user->karyawan->telp }}', '{{ $user->karyawan->tabungan }}')">
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
    document.addEventListener("DOMContentLoaded", function() {
        var kategoriSelect = document.getElementById("kategori");
        var formBiayaTambahan = document.getElementById("form_biayatambahan");
        var FormRUte = document.getElementById("form_rute");
        var FormBorongan = document.getElementById("form_borongan");
        var BorongPPh = document.getElementById("borongpph");
        var FormPelanggan = document.getElementById("form_pelanggan");


        if (!kategoriSelect || !formBiayaTambahan || !FormBorongan) {
            console.error("One or more elements not found!");
            return;
        }

        // Initial adjustment based on the selected category
        adjustDisplay(kategoriSelect.value);

        kategoriSelect.addEventListener("change", function() {
            adjustDisplay(kategoriSelect.value);
        });

        function adjustDisplay(selectedKategori) {
            console.log("Selected Kategori:", selectedKategori);

            // Hide both forms initially
            formBiayaTambahan.style.display = "none";
            FormBorongan.style.display = "none";
            BorongPPh.style.display = "none";
            FormRUte.style.display = "none";
            FormPelanggan.style.display = "none";

            // Show the appropriate form based on the selected category
            if (selectedKategori === "Memo Perjalanan") {
                formBiayaTambahan.style.display = "block";
                FormRUte.style.display = "block";
            } else if (selectedKategori === "Memo Borong") {
                FormBorongan.style.display = "block";
                BorongPPh.style.display = "block";
                FormPelanggan.style.display = "block";
            } else if (selectedKategori === "Memo Tambahan") {
                FormRUte.style.display = "block";
                formBiayaTambahan.style.display = "block";
                FormBorongan.style.display = "none";
                BorongPPh.style.display = "none";
                FormPelanggan.style.display = "none";
            }
        }

    });

    var TotalHasilss = 0;

    function calculateAndDisplayTotal() {
        var selectedCategory = $('#kategori').val();

        if (selectedCategory === 'Memo Perjalanan') {
            TotalHasilss++;

            if (TotalHasilss === 2) {
                // Calculate total of 'nominal[]' inputs
                var total = 0;
                $('input[name="nominal[]"]').each(function() {
                    total += parseFloat($(this).val()) || 0;
                });
                $('#harga_tambahan').val(total);

                // Get values for calculation
                var UangJalans = parseFloat($('#biaya').val()) || 0;
                var UangTambahan = parseFloat($('#harga_tambahan').val()) || 0;
                var DepositDriv = parseFloat($('#uang_jaminan').val()) || 0;

                // Calculate new subtotal
                var newSubTotal = UangJalans + UangTambahan;

                // Calculate 1% of newSubTotal
                var uangJaminanValue = newSubTotal * 0.01;

                // Update the 'uang_jaminan' input with the 1% value
                $('#uang_jaminan').val(uangJaminanValue);

                // Reset the counter for the next calculation
                TotalHasilss = 0;
            }
        }

        if (selectedCategory === 'Memo Borong') {
            TotalHasilss++;

            if (TotalHasilss === 2) {
                // Calculate total of 'nominal[]' inputs
                var total = 0;
                $('input[name="totalrute[]"]').each(function() {
                    total += parseFloat($(this).val()) || 0;
                });
                $('#harga_tambahan').val(total);

                // Get values for calculation
                var UangTambahan = parseFloat($('#harga_tambahan').val()) || 0;
                var DepositDriv = parseFloat($('#uang_jaminan').val()) || 0;

                // Calculate new subtotal
                var newSubTotal = UangTambahan;

                // Calculate 1% of newSubTotal
                var uangJaminanValue = newSubTotal * 0.01;

                // Update the 'uang_jaminan' input with the 1% value
                $('#uang_jaminan').val(uangJaminanValue);


                $('#sub_total').val(0);
                $('#totalborong').val(0);
                $('#uangjaminanss').val(0);
                $('#pph2').val(0);

                // Update the value of the 'harga_tambahan' input
                $('#harga_tambahan').val(total);

                // Get the value of #sub_total
                var subTotalValue = parseFloat($('#sub_total').val()) || 0;

                // Sum #harga_tambahan and #sub_total
                var newSubTotal = total + subTotalValue;

                // Update the value of the 'sub_total' input
                // $('#sub_total').val(newSubTotal);
                $('#totalborong').val(newSubTotal);

                // Calculate 1% of the newSubTotal
                var Uangjaminan = newSubTotal * 0.01;

                // Update the value of the 'pph2' input
                $('#uangjaminanss').val(Uangjaminan);
                $('#uang_jaminan').val(Uangjaminan);

                // Calculate 2% of the totalborong
                var pph2Value = newSubTotal * 0.02;

                // Update the value of the 'pph2' input
                $('#pph2').val(pph2Value);

                // Reset the counter for the next calculation
                TotalHasilss = 0;
            }
        }

        if (selectedCategory === 'Memo Tambahan') {
            TotalHasilss++;

            if (TotalHasilss === 2) {
                // Calculate total of 'nominal[]' inputs
                var total = 0;
                $('input[name="nominal[]"]').each(function() {
                    total += parseFloat($(this).val()) || 0;
                });
                $('#harga_tambahan').val(total);

                TotalHasilss = 0;
            }
        }
    }

    var TotalPerjalanan = 0;

    function SubTotalss() {
        var selectedCategory = $('#kategori').val();

        if (selectedCategory === 'Memo Tambahan') {
            TotalPerjalanan++;

            if (TotalPerjalanan === 2) {
                var Biaya_tambahan = parseFloat($('#harga_tambahan').val()) || 0;
                var UangJalan = parseFloat($('#biaya').val()) || 0;

                // Calculate the sum of Biaya_tambahan and UangJalan
                var uangJaminanValue = Biaya_tambahan + UangJalan;

                // Round the uangJaminanValue to the nearest integer
                var roundedUangJaminanValue = Math.round(uangJaminanValue);

                // Update the value of the 'sub_total' input with the rounded value
                $('#sub_total').val(roundedUangJaminanValue);

                TotalPerjalanan = 0; // Reset click count
            }
        }

        if (selectedCategory === 'Memo Perjalanan') {
            TotalPerjalanan++;

            if (TotalPerjalanan === 2) {
                var biaya = parseFloat($('#biaya').val()) || 0;
                var DepositDrivers = parseFloat($('#deposit_driver').val()) || 0;
                var UangJamin = parseFloat($('#uang_jaminan').val()) || 0;
                var Biaya_tambahan = parseFloat($('#harga_tambahan').val()) || 0;

                // Calculate 1% of biaya
                var TotalsValue = Biaya_tambahan + biaya - 0.01 - UangJamin - DepositDrivers;

                // Round the result to the nearest integer
                var roundedTotal = Math.round(TotalsValue);

                // Update the value of the 'sub_total' input
                $('#sub_total').val(roundedTotal);

                TotalPerjalanan = 0; // Reset click count
            }

        }

        if (selectedCategory === 'Memo Borong') {
            TotalPerjalanan++;

            if (TotalPerjalanan === 2) {
                var TotalBorong = parseFloat($('#totalborong').val()) || 0;
                var PPh = parseFloat($('#pph2').val()) || 0;
                var UangJaminan = parseFloat($('#uangjaminanss').val()) || 0;
                var DepositDriver = parseFloat($('#depositsdriverss').val()) || 0;

                // Calculate uangJaminanValue without rounding
                var uangJaminanValue = TotalBorong - PPh - UangJaminan - DepositDriver;

                // Round the uangJaminanValue to the nearest integer
                var roundedUangJaminanValue = Math.round(uangJaminanValue);

                // Update the value of the 'hasilsss' input with the rounded value
                $('#hasilsss').val(roundedUangJaminanValue);

                // Calculate HasilBagi without rounding
                var HasilBagi = uangJaminanValue / 2;

                // Round the HasilBagi to the nearest integer
                var roundedHasilBagi = Math.round(HasilBagi);

                // Update the value of the 'sub_total' input with the rounded value
                $('#sub_total').val(roundedHasilBagi);

                TotalPerjalanan = 0; // Reset click count
            }
        }
    }

    // Add an event listener to the dropdown
    $('#kategori').on('change', function() {
        // Call the SubTotalss function when the dropdown changes
        SubTotalss();
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var kategoriSelect = document.getElementById("kategori");
        var uangJalanInput = document.getElementById("biaya");
        var formBiayaTambahan = document.getElementById("form_biayatambahan");
        var FormBorongan = document.getElementById("form_borongan");
        var FormRute = document.getElementById("form_rute");
        var FormPelanggan = document.getElementById("form_pelanggan");
        var BorongPPh = document.getElementById("borongpph");


        kategoriSelect.addEventListener("change", function() {
            // Mengambil nilai yang dipilih pada dropdown "Pilih Kategori"
            var selectedKategori = kategoriSelect.value;

            // Memeriksa apakah kategori yang dipilih adalah "Memo Tambahan"
            if (selectedKategori === "Memo Tambahan") {
                // Jika ya, hapus atribut readonly pada input "Uang Jalan"
                uangJalanInput.removeAttribute("readonly");
                formBiayaTambahan.style.display = "block";
                FormBorongan.style.display = "none";
                BorongPPh.style.display = "none";
                FormPelanggan.style.display = "none";
                FormRute.style.display = "block";

            } else if (selectedKategori === "Memo Perjalanan") {
                uangJalanInput.setAttribute("readonly", "readonly");
                formBiayaTambahan.style.display = "block";
                FormBorongan.style.display = "none";
                BorongPPh.style.display = "none";
                FormPelanggan.style.display = "none";
                FormRute.style.display = "block";


            } else if (selectedKategori === "Memo Borong") {
                uangJalanInput.setAttribute("readonly", "readonly");
                FormBorongan.style.display = "block";
                BorongPPh.style.display = "block";
                formBiayaTambahan.style.display = "none";
                FormRute.style.display = "none";
                FormPelanggan.style.display = "block";
            }
        });
    });


    document.addEventListener("DOMContentLoaded", function() {
        limitInput();
    });

    function limitInput() {
        var depositInput = document.getElementById("deposit_driver");
        var checkbox = document.getElementById("additional_checkbox");

        if (!checkbox.checked) {
            // If checkbox is not checked, set the input value to 50000
            depositInput.value = "50000";
        }
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


    document.addEventListener("DOMContentLoaded", function() {
        var kategoriSelect = document.getElementById("kategori");
        var uangJaminanInput = document.getElementById("uang_jaminan");
        var BiayaTambahan = document.getElementById("harga_tambahan");
        var uangJalanInput = document.getElementById("biaya");
        var DepositDriver = document.getElementById("deposit_driver");

        // Event listener untuk setiap kali kategori berubah
        kategoriSelect.addEventListener("change", function() {
            // Mengambil nilai yang dipilih pada dropdown "Pilih Kategori"
            var selectedKategori = kategoriSelect.value;

            // Memeriksa apakah kategori yang dipilih adalah "Memo Tambahan"
            if (selectedKategori === "Memo Tambahan") {
                // Jika tidak, atur nilai uang jaminan menjadi 0
                uangJaminanInput.value = 0;
                BiayaTambahan.value = 0;
                DepositDriver.value = 0;
                // Set nilai uang jaminan
            } else {
                // Jika ya, ambil nilai uang jalan dan hitung 1% dari nilai tersebut
                var uangJalanValue = parseFloat(uangJalanInput.value);
                var uangJaminan = uangJalanValue * 0.01;
                uangJaminanInput.value = uangJaminan;

            }
        });
    });



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

    function biayatambah(param) {
        activeSpecificationIndex = param;
        // Show the modal and filter rows if necessary
        $('#tableBiaya').modal('show');
    }

    function getBiaya(rowIndex) {
        var selectedRow = $('#datatables3 tbody tr:eq(' + rowIndex + ')');
        var biaya_id = selectedRow.data('biaya_id');
        var kode_biaya = selectedRow.data('kode_biaya');
        var nama_biaya = selectedRow.data('nama_biaya');
        var nominal = selectedRow.data('nominal');

        // Update the form fields for the active specification
        $('#biaya_id-' + activeSpecificationIndex).val(biaya_id);
        $('#kode_biaya-' + activeSpecificationIndex).val(kode_biaya);
        $('#nama_biaya-' + activeSpecificationIndex).val(nama_biaya);
        $('#nominal-' + activeSpecificationIndex).val(nominal);

        $('#tableBiaya').modal('hide');
    }

    var clickHasiljamin = 0;

    function calculateHasilUangjaminan() {
        clickHasiljamin++;

        if (clickHasiljamin === 2) {
            var biaya = parseFloat($('#biaya').val()) || 0;

            // Calculate 1% of biaya
            var uangJaminanValue = biaya * 0.01;

            // Update the value of the 'uang_jaminan' input
            $('#uang_jaminan').val(uangJaminanValue);

            clickHasiljamin = 0; // Reset click count
        }
    }


    var clickHasils = 0;

    function calculateHasilsrute() {
        clickHasils++;

        if (clickHasils === 2) {
            var saldoDeposit = parseFloat($('#totalborong').val()) || 0;
            var ppH2 = parseFloat($('#pph2').val()) || 0;
            var hasilPengurangan = parseFloat($('#uangjaminanss').val()) || 0;
            var depositDriver = parseFloat($('#depositsdriverss').val()) || 0;


            // Sum saldoDeposit and depositDriver
            var newSaldoDeposit = saldoDeposit - ppH2 - hasilPengurangan - depositDriver;
            // Update the value of the 'saldo_deposit' input
            $('#hasilsss').val(newSaldoDeposit);


            var newTotals = (saldoDeposit - ppH2 - hasilPengurangan - depositDriver) / 2;
            $('#sub_total').val(newTotals);

            clickHasils = 0; // Reset click count
        }
    }


    var clickCountDeposit = 0;
    var previousDepositDriver = 0;

    function calculateAndDeposit() {
        clickCountDeposit++;

        if (clickCountDeposit === 2) {
            var saldoDeposit = parseFloat($('#saldo_deposit').val()) || 0;
            var depositDriver = parseFloat($('#deposit_driver').val()) || 0;

            // Set the value of depositsdriverss and depositsdriversst to the new depositDriver
            $('#depositsdriverss').val(depositDriver);
            $('#depositsdriversst').val(depositDriver);

            // Calculate the change in depositDriver
            var depositDriverChange = depositDriver - previousDepositDriver;

            // Subtract the previous depositDriver and add the new depositDriver to saldoDeposit
            var newSaldoDeposit = saldoDeposit - previousDepositDriver + depositDriver;

            // Update the value of the 'saldo_deposit' input
            $('#saldo_deposit').val(newSaldoDeposit);

            // Update the previousDepositDriver with the new value
            previousDepositDriver = depositDriver;

            clickCountDeposit = 0; // Reset click count
        }
    }


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
        calculateTotal(); // Calculate total after populating existing data
    }

    function addPesanan() {
        jumlah_ban = jumlah_ban + 1;

        if (jumlah_ban === 1) {
            $('#tabel-pembelian').empty();
        }

        itemPembelian(jumlah_ban, jumlah_ban - 1);
        calculateTotal(); // Calculate total after adding a new item
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
            calculateTotal(); // Calculate total after removing an item
        }
    }

    function calculateTotal() {
        var total = 0;
        $('input[name="nominal[]"]').each(function() {
            total += parseFloat($(this).val()) || 0;
        });

        // Update the value of the 'harga_tambahan' input
        $('#harga_tambahan').val(total);
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

        item_pembelian += '<td style="width: 100px">';
        item_pembelian += '<button type="button" class="btn btn-primary btn-sm" onclick="biayatambah(' + urutan + ')">';
        item_pembelian += '<i class="fas fa-plus"></i>';
        item_pembelian += '</button>';
        item_pembelian +=
            '<button style="margin-left:5px" type="button" class="btn btn-danger btn-sm" onclick="removeBan(' +
            urutan + ')">';
        item_pembelian += '<i class="fas fa-trash"></i>';
        item_pembelian += '</button>';
        item_pembelian += '</td>';
        item_pembelian += '</tr>';

        $('#tabel-pembelian').append(item_pembelian);
    }
</script>


<script>
    // var clickCountHargaTambahanrute = 0;

    // function calculateAndDisplayTotalrute() {
    //     clickCountHargaTambahanrute++;

    //     if (clickCountHargaTambahanrute === 2) {
    //         var total = 0;
    //         $('input[name="totalrute[]"]').each(function() {
    //             total += parseFloat($(this).val()) || 0;
    //         });

    //         // Update the value of the 'harga_tambahan' input
    //         $('#harga_tambahan').val(total);

    //         // Get the value of #sub_total
    //         var subTotalValue = parseFloat($('#sub_total').val()) || 0;

    //         // Sum #harga_tambahan and #sub_total
    //         var newSubTotal = total + subTotalValue;

    //         // Update the value of the 'sub_total' input
    //         $('#sub_total').val(newSubTotal);

    //         clickCountHargaTambahanrute = 0; // Reset click count
    //     }
    // }


    $(document).on("input", ".harga_rute, .jumlah", function() {
        var currentRow = $(this).closest('tr');
        var hargasatuan = parseFloat(currentRow.find(".harga_rute").val()) || 0;
        var jumlah = parseFloat(currentRow.find(".jumlah").val()) || 0;
        var harga = hargasatuan * jumlah;
        currentRow.find(".totalrute").val(harga);
    });

    var data_pembelian = @json(session('data_pembelians2'));
    var jumlah_ban = 1;

    if (data_pembelian != null) {
        jumlah_ban = data_pembelian.length;
        $('#tabel-rute').empty();
        var urutan = 0;
        $.each(data_pembelian, function(key, value) {
            urutan = urutan + 1;
            itemPembelianrute(urutan, key, value);
        });
        calculateTotalrute(); // Calculate total after populating existing data
    }

    function addRute() {
        jumlah_ban = jumlah_ban + 1;

        if (jumlah_ban === 1) {
            $('#tabel-rute').empty();
        }

        itemPembelianrute(jumlah_ban, jumlah_ban - 1);
        calculateTotalrute(); // Calculate total after adding a new item
    }

    function removerute(params) {
        jumlah_ban = jumlah_ban - 1;

        var tabel_pesanan = document.getElementById('tabel-rute');
        var pembelian = document.getElementById('rute-' + params);

        tabel_pesanan.removeChild(pembelian);

        if (jumlah_ban === 0) {
            var item_pembelian = '<tr>';
            item_pembelian += '<td class="text-center" colspan="5">- rute belum ditambahkan -</td>';
            item_pembelian += '</tr>';
            $('#tabel-rute').html(item_pembelian);
        } else {
            var urutan = document.querySelectorAll('#urutanrute');
            for (let i = 0; i < urutan.length; i++) {
                urutan[i].innerText = i + 1;
            }
            calculateTotal(); // Calculate total after removing an item
        }
    }

    function calculateTotalrute() {
        var total = 0;
        $('input[name="totalrute[]"]').each(function() {
            total += parseFloat($(this).val()) || 0;
        });

        // Calculate 1% of the total
        var onePercent = total * 0.01;

        // Update the value of the 'uang_jaminan' input
        $('#uang_jaminan').val(onePercent);
    }

    // Attach a click event handler to the 'uang_jaminan' input
    $(document).on('click', '#uang_jaminan', function() {
        // Call the calculateTotalrute function when 'uang_jaminan' is clicked
        calculateTotalrute();
    });

    function itemPembelianrute(urutan, key, value = null) {
        var rute_id = '';
        var kode_rutes = '';
        var nama_rutes = '';
        var harga_rute = '';
        var jumlah = '';
        var satuan = '';
        var totalrute = '';

        if (value !== null) {
            rute_id = value.rute_id;
            kode_rutes = value.kode_rutes;
            nama_rutes = value.nama_rutes;
            harga_rute = value.harga_rute;
            jumlah = value.jumlah;
            satuan = value.satuan;
            totalrute = value.totalrute;
        }

        // urutanrute 
        var item_pembelian = '<tr id="rute-' + urutan + '">';
        item_pembelian += '<td style="width: 70px; font-size:14px" class="text-center" id="urutanrute-' + urutan +
            '">' +
            urutan + '</td>';

        // rute_id 
        item_pembelian += '<td hidden>';
        item_pembelian += '<div class="form-group">'
        item_pembelian += '<input type="text" class="form-control" id="rute_id-' + urutan +
            '" name="rute_id[]" value="' + rute_id + '" ';
        item_pembelian += '</div>';
        item_pembelian += '</td>';

        // kode rutes 
        item_pembelian += '<td>';
        item_pembelian += '<div class="form-group">'
        item_pembelian += '<input type="text" class="form-control" style="font-size:14px" readonly id="kode_rutes-' +
            urutan +
            '" name="kode_rutes[]" value="' + kode_rutes + '" ';
        item_pembelian += '</div>';
        item_pembelian += '</td>';

        // nama rutes 
        item_pembelian += '<td>';
        item_pembelian += '<div class="form-group">'
        item_pembelian += '<input type="text" class="form-control" style="font-size:14px" readonly id="nama_rutes-' +
            urutan +
            '" name="nama_rutes[]" value="' + nama_rutes + '" ';
        item_pembelian += '</div>';
        item_pembelian += '</td>';

        // harga 
        item_pembelian += '<td>';
        item_pembelian += '<div class="form-group">'
        item_pembelian +=
            '<input type="number" class="form-control harga_rute" readonly style="font-size:14px" id="harga_rute-' +
            urutan +
            '" name="harga_rute[]" value="' + harga_rute + '" ';
        item_pembelian += '</div>';
        item_pembelian += '</td>';

        //jumlah
        item_pembelian += '<td>';
        item_pembelian += '<div class="form-group">'
        item_pembelian += '<input type="number" class="form-control jumlah" style="font-size:14px" id="jumlah-' +
            urutan +
            '" name="jumlah[]" value="' + jumlah + '" ';
        item_pembelian += '</div>';
        item_pembelian += '</td>';

        //satuan
        item_pembelian += '<td>';
        item_pembelian += '<div class="form-group">';
        item_pembelian += '<select class="form-control" style="font-size:14px" id="satuan-' + urutan +
            '" name="satuan[]">';
        item_pembelian += '<option value="">- Pilih -</option>';
        item_pembelian += '<option value="pcs"' + (satuan === 'pcs' ? ' selected' : '') + '>pcs</option>';
        item_pembelian += '<option value="liter"' + (satuan === 'liter' ? ' selected' : '') +
            '>liter</option>';
        item_pembelian += '<option value="ton"' + (satuan === 'ton' ? ' selected' : '') +
            '>ton</option>';
        item_pembelian += '<option value="dus"' + (satuan === 'dus' ? ' selected' : '') +
            '>dus</option>';

        item_pembelian += '</select>';
        item_pembelian += '</div>';
        item_pembelian += '</td>';

        //total
        item_pembelian += '<td>';
        item_pembelian += '<div class="form-group">'
        item_pembelian +=
            '<input type="number" class="form-control totalrute" style="font-size:14px" readonly id="totalrute-' +
            urutan +
            '" name="totalrute[]" value="' + totalrute + '" ';
        item_pembelian += '</div>';
        item_pembelian += '</td>';


        item_pembelian += '<td style="width: 100px">';
        item_pembelian += '<button type="button" class="btn btn-primary btn-sm" onclick="rutebaru(' + urutan +
            ')">';
        item_pembelian += '<i class="fas fa-plus"></i>';
        item_pembelian += '</button>';
        item_pembelian +=
            '<button style="margin-left:5px" type="button" class="btn btn-danger btn-sm" onclick="removerute(' +
            urutan + ')">';
        item_pembelian += '<i class="fas fa-trash"></i>';
        item_pembelian += '</button>';
        item_pembelian += '</td>';
        item_pembelian += '</tr>';

        $('#tabel-rute').append(item_pembelian);
    }
</script>

@endsection