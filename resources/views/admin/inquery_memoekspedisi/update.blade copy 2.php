@extends('layouts.app')

@section('title', 'Memo Ekspedisi')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Memo Ekspedisi</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('admin/memo_ekspedisi') }}">Memo Ekspedisi</a></li>
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
        @if (session('erorrss'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5>
                <i class="icon fas fa-ban"></i> Error!
            </h5>
            {{ session('erorrss') }}
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
                    <h3 class="card-title">Tambah Memo Ekspedisi</h3>
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
                    @if ($inquery->kategori == 'Memo Tambahan')
                    <div id="formmemotambahans" class="form-group" style="flex: 8;">
                        <div class="mb-3 mt-4">
                            <button class="btn btn-primary btn-sm" type="button" onclick="ShowMemo(this.value)">
                                <i class="fas fa-plus mr-2"></i> Pilih Memo
                            </button>
                        </div>
                        <div class="form-group" hidden>
                            <label for="nopol">Id Memo</label>
                            <input type="text" class="form-control" id="memo_id" name="memo_id" value="{{ old('memo_id', $inquery->memotambahan->id) }}" readonly placeholder="" value="">
                        </div>
                        <div class="form-group">
                            <label style="font-size:14px" for="nopol">No Memo</label>
                            <input style="font-size:14px" type="text" class="form-control" id="kode_memosa" name="kode_memosa" readonly placeholder="" value="{{ old('kode_memosa', $inquery->memotambahan->memo->kode_memo) }}">
                        </div>
                        <div class="form-group">
                            <label style="font-size:14px" for="nopol">Nama Sopir</label>
                            <input style="font-size:14px" type="text" class="form-control" name="nama_driversa" id="nama_driversa" readonly placeholder="" value="{{ old('nama_driversa', $inquery->memotambahan->memo->nama_driver) }}">
                        </div>
                        <div class="form-group">
                            <label style="font-size:14px" style="font-size:14px" for="nama">No Kabin</label>
                            <input style="font-size:14px" style="font-size:14px" type="text" class="form-control" name="no_kabinsa" id="no_kabinsa" readonly placeholder="" value="{{ old('no_kabinsa', $inquery->memotambahan->memo->no_kabin) }}">
                        </div>
                        <div class="form-group">
                            <label style="font-size:14px" for="nama">Rute Perjalanan</label>
                            <input style="font-size:14px" type="text" class="form-control" name="nama_rutesa" id="nama_rutesa" readonly placeholder="" value="{{ old('nama_rutesa', $inquery->memotambahan->memo->nama_rute) }}">
                        </div>
                    </div>
                    @endif
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

                    <div class="col-md-4">
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
                                <label style="font-size:14px" class="form-label" for="nama_driver">Nama
                                    Sopir</label>
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

                    <div class="col-md-4" id="form_rute">
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
                            <label style="font-size:14px" class="form-label" for="kode_rute">Kode
                                Rute</label>
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

                <div class="col-md-3" hidden>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Biaya</h3>
                        </div>
                        <div class="card-body">

                            <div id="memoperjalanan">
                                <label style="font-size:14px" for="harga_tambahan">Biaya Tambahan</label>
                                <div class="form-group d-flex">
                                    {{-- <input class="form-control" id="harga_tambahan" name="biaya_tambahan"
                                                    type="text" placeholder="" value="{{ old('biaya_tambahan') }}"
                                    readonly style="margin-right: 10px; font-size:14px" />
                                    <button class="btn btn-primary" type="button" onclick="biayatambah(0)">
                                        <i class="fas fa-plus"></i>
                                    </button> --}}
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
                                <td style="width: 50px">
                                    <button type="button" class="btn btn-primary btn-sm" onclick="biayatambah(0)">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                    {{-- <button style="margin-left:5px" type="button" class="btn btn-danger btn-sm"
                                            onclick="removeBan(0)">
                                            <i class="fas fa-trash"></i>
                                        </button> --}}
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
                            {{-- <p style="font-size: 13px">(Tambahkan biaya jika ada tambahan biaya)</p> --}}
                        </span></h3>
                    <div class="float-right">
                        {{-- <button type="button" class="btn btn-primary btn-sm" onclick="addPesanan()">
                                <i class="fas fa-plus"></i>
                            </button> --}}
                    </div>
                </div>
                <!-- /.card-header -->
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
                                <td style="width: 70px; font-size:14px" class="text-center" id="urutanpotongan">
                                    {{ $loop->index + 1 }}
                                </td>
                                <td hidden>
                                    <div class="form-group" hidden>
                                        <input type="text" class="form-control" name="detail_ids[]" value="{{ $detail['id'] }}">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="potongan_id-0" name="potongan_id[]" value="{{ $detail['potongan_id'] }}">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input style="font-size:14px" type="text" class="form-control" readonly id="kode_potongan" name="kode_potongan[]" value="{{ $detail['kode_potongan'] }}">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input style="font-size:14px" type="text" class="form-control" readonly id="keteranganpotongan" name="keterangan_potongan[]" value="{{ $detail['keterangan_potongan'] }}">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input style="font-size:14px" type="text" class="form-control" id="nominalpotongan" readonly name="nominal_potongan[]" value="{{ $detail['nominal_potongan'] }}">
                                    </div>
                                </td>
                                <td style="width: 50px">
                                    <button type="button" class="btn btn-primary btn-sm" onclick="potonganmemo(0)">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                    {{-- <button style="margin-left:5px" type="button" class="btn btn-danger btn-sm"
                                            onclick="removeBan(0)">
                                            <i class="fas fa-trash"></i>
                                        </button> --}}
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
                                <td style="width: 50px">
                                    <button type="button" class="btn btn-primary btn-sm" onclick="showCategoryModalRuts(this.value)">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                    {{-- <button style="margin-left:5px" type="button" class="btn btn-danger btn-sm"
                                            onclick="removerute(0)">
                                            <i class="fas fa-trash"></i>
                                        </button> --}}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="perjalananss" style="display: none">
                        <tbody>
                            <tr>
                                <td>
                                    <div class="form-group" style="display: flex; align-items: center;">
                                        <label style="font-size: 14px; margin-right: 50px;" for="uangjalan">Uang
                                            Jalan</label>
                                        <input style="width: 300px; font-size: 14px;" type="text" class="form-control text-right" id="uangjalans" readonly name="uangjalans" placeholder="" value="{{ old('uangjalans', $inquery->uang_jalan) }}">
                                        <label style="font-size: 14px; margin-right: 22px; margin-left:46px" for="rute_perjalanan">Administrasi</label>
                                        <input style="width: 300px; font-size: 14px;" type="text" class="form-control" readonly placeholder="" value="1 %">
                                    </div>
                                    <div class="form-group" style="display: flex; align-items: center;">
                                        <label style="font-size: 14px; margin-right: 18px;" for="rute_perjalanan">Biaya
                                            Tambahan</label>
                                        <input style="width: 300px; font-size: 14px;" type="text" class="form-control text-right" id="harga_tambahan" readonly name="biaya_tambahan" value="{{ old('biaya_tambahan', $inquery->biaya_tambahan) }}">
                                        <label style="font-size: 14px; margin-right: 10px; margin-left:45px" for="rute_perjalanan">Deposit Sopir</label>
                                        <input style="width: 300px; font-size: 14px; margin-left:6px" type="text" class="form-control" id="deposit_driver" name="deposit_driver" value="{{ old('deposit_driver') }}" placeholder="" oninput="limitInput()">
                                    </div>
                                    <div class="form-group" style="display: flex; align-items: center;">
                                        <label style="font-size: 14px; margin-right: 20px;" for="rute_perjalanan">Potongan Memo</label>
                                        <input style="width: 300px; font-size: 14px;" type="text" class="form-control text-right" id="potongan_memo" readonly name="potongan_memo" placeholder="" value="{{ old('potongan_memo', $inquery->potongan_memo) }}">
                                        <input style="margin-left: 565px" class="form-check-input" type="checkbox" id="additional_checkbox" name="additional_checkbox" onchange="limitInput()">
                                        <label style="margin-left: 170px" class="form-check-label" for="additional_checkbox">
                                            Min Deposit 50.000
                                        </label>
                                        {{-- <label style="font-size: 14px; margin-right: 78px;"
                                                        for="rute_perjalanan">Min Deposit 50.000</label> --}}

                                    </div>
                                    <div class="form-group" style="display: flex; align-items: center;">
                                        <label style="font-size: 14px; margin-right: 42px;" for="rute_perjalanan">Administrasi</label>
                                        <input style="width: 300px; font-size: 14px;" id="uang_jaminan" type="text" class="form-control text-right" readonly name="uang_jaminan" placeholder="" value="{{ old('uang_jaminan', $inquery->uang_jaminan) }}">

                                    </div>
                                    <div class="form-group" style="display: flex; align-items: center;">
                                        <label style="font-size: 14px; margin-right: 37px;" for="rute_perjalanan">Deposit
                                            Sopir</label>
                                        <input style="width: 300px; font-size: 14px;" type="text" class="form-control text-right" id="depositsdriverss" readonly name="deposit_drivers" placeholder="" value="{{ old('deposit_drivers', $inquery->deposit_driver) }}">
                                        <label style="color:white; font-size: 14px; margin-right: 65px; margin-left: 584px" for="rute_perjalanan">.</label>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-bordered table-striped" id="borongpph" style="display: none">
                        <tbody>
                            <tr>
                                <td>
                                    <div class="form-group" style="display: flex; align-items: center;">
                                        <label style="font-size: 14px; margin-right: 30px;" for="rute_perjalanan">Total
                                            Borong</label>
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
                                        <label style="font-size: 14px; margin-right: 25px;" for="rute_perjalanan">Deposit
                                            Sopir</label>
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
                                <th style="font-size:14px">Grand Total</th>
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

            </div>

    </div>
    @if ($inquery->kategori == 'Memo Tambahan')
    <div id="memotambahanss">
        <div class="card" id="form_biayatambahan">
            <div class="card-header">
                <h3 class="card-title">Memo Tambahan <span>
                    </span></h3>
                <div class="float-right">
                    <button type="button" class="btn btn-primary btn-sm" onclick="addMemotambahan()">
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
                            <th style="font-size:14px">Keterangan</th>
                            <th style="font-size:14px">Nominal</th>
                            {{-- <th style="font-size:14px">Opsi</th> --}}
                        </tr>
                    </thead>
                    <tbody id="tabel-memotambahan">
                        @foreach ($detailstambahan as $detail)
                        <tr id="memotambah-{{ $loop->index }}">
                            <td style="width: 70px; font-size:14px" class="text-center" id="urutantambah">
                                {{ $loop->index + 1 }}
                            </td>
                            <td hidden>
                                <div class="form-group" hidden>
                                    <input type="text" class="form-control" name="detail_idstambahan[]" value="{{ $detail['id'] }}">
                                </div>
                            <td>
                                <div class="form-group">
                                    <input style="font-size:14px" type="text" class="form-control" id="keterangan_tambahan-0" name="keterangan_tambahan[]" value="{{ $detail['keterangan_tambahan'] }}">
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input style="font-size:14px" type="number" class="form-control" id="nominal_tambahan-0" name="nominal_tambahan[]" value="{{ $detail['nominal_tambahan'] }}">
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="form-group">
                    <label style="font-size:14px" class="mt-3" for="nopol">Grand Total</label>
                    <input style="font-size:14px" type="number" class="form-control text-right" id="grand_total" name="grand_total" readonly placeholder="" value="{{ old('grand_total', $inquery->grand_total) }}">
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="card-footer text-right">
        <button type="reset" class="btn btn-secondary">Reset</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
    </div>
    </form>

    <div class="modal fade" id="tableMemo" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Data Memo</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive scrollbar m-2">
                        <table id="datatables7" class="table table-bordered table-striped">
                            <thead class="bg-200 text-900">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>No. Memo</th>
                                    <th>Tanggal</th>
                                    <th>Nama Sopir</th>
                                    <th>No. Kabin</th>
                                    <th>Rute Perjalanan</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($memos as $memo)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $memo->kode_memo }}</td>
                                    <td>{{ $memo->tanggal_awal }}</td>
                                    <td>{{ $memo->nama_driver }}</td>
                                    <td>{{ $memo->no_kabin }}</td>
                                    <td>{{ $memo->nama_rute }}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-primary btn-sm" onclick="getSelectedData('{{ $memo->id }}',
                                                    '{{ $memo->kode_memo }}',
                                                    '{{ $memo->nama_driver }}',
                                                    '{{ $memo->no_kabin }}',
                                                    '{{ $memo->nama_rute }}',   
                                                    )">
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
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $biayatambah->kode_biaya }}</td>
                                <td>{{ $biayatambah->nama_biaya }}</td>
                                <td>{{ $biayatambah->nominal }}</td>
                                <td class="text-center">
                                    <button type="button" id="btnTambah" class="btn btn-primary btn-sm" onclick="getBiaya('{{ $biayatambah->id }}', '{{ $biayatambah->kode_biaya }}', '{{ $biayatambah->nama_biaya }}', '{{ $biayatambah->nominal }}')">
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
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $potonganmemo->kode_potongan }}</td>
                                <td>{{ $potonganmemo->keterangan }}</td>
                                <td>{{ $potonganmemo->nominal }}</td>
                                <td class="text-center">
                                    <button type="button" id="btnTambah" class="btn btn-primary btn-sm" onclick="getPotongan('{{ $potonganmemo->id }}', '{{ $potonganmemo->kode_potongan }}', '{{ $potonganmemo->keterangan }}', '{{ $potonganmemo->nominal }}')">
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
                                @foreach ($ruteperjalanans as $rute_perjalanan)
                                <tr>
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
                                        <button type="button" class="btn btn-primary btn-sm" onclick="getSelectedDatarute('{{ $rute_perjalanan->id }}', '{{ $rute_perjalanan->kode_rute }}', '{{ $rute_perjalanan->nama_rute }}', '{{ $rute_perjalanan->golongan1 }}' , '{{ $rute_perjalanan->golongan2 }}', '{{ $rute_perjalanan->golongan3 }}', '{{ $rute_perjalanan->golongan4 }}', '{{ $rute_perjalanan->golongan5 }}', '{{ $rute_perjalanan->golongan6 }}', '{{ $rute_perjalanan->golongan7 }}', '{{ $rute_perjalanan->golongan8 }}', '{{ $rute_perjalanan->golongan9 }}', '{{ $rute_perjalanan->golongan10 }}')">
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
                                @foreach ($ruteperjalanans as $rute_perjalanan)
                                <tr>
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
                                        <button type="button" class="btn btn-primary btn-sm" onclick="getRutes('{{ $rute_perjalanan->id }}', '{{ $rute_perjalanan->kode_rute }}', '{{ $rute_perjalanan->nama_rute }}', '{{ $rute_perjalanan->golongan1 }}' , '{{ $rute_perjalanan->golongan2 }}', '{{ $rute_perjalanan->golongan3 }}', '{{ $rute_perjalanan->golongan4 }}', '{{ $rute_perjalanan->golongan5 }}', '{{ $rute_perjalanan->golongan6 }}', '{{ $rute_perjalanan->golongan7 }}', '{{ $rute_perjalanan->golongan8 }}', '{{ $rute_perjalanan->golongan9 }}', '{{ $rute_perjalanan->golongan10 }}')">
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
    document.addEventListener("DOMContentLoaded", function() {
        var kategoriSelect = document.getElementById("kategori");
        var uangJalanInput = document.getElementById("biaya");
        var formBiayaTambahan = document.getElementById("form_biayatambahan");
        var FormBorongan = document.getElementById("form_borongan");
        var FormRute = document.getElementById("form_rute");
        var FormPelanggan = document.getElementById("form_pelanggan");
        var FormPotongan = document.getElementById("form_potonganmemo");
        var BorongPPh = document.getElementById("borongpph");
        var Perjalananss = document.getElementById("perjalananss");
        var Memoperjlan = document.getElementById("memoperjalanan");
        var MemoPerjalananBorong = document.getElementById("memoperjalananborong");
        var Memotambahanns = document.getElementById("memotambahanss");
        var FormMemotambahan = document.getElementById("formmemotambahans");


        // Cek apakah ada nilai kategori yang tersimpan dalam localStorage
        var selectedKategori = localStorage.getItem("selectedKategori");
        if (selectedKategori) {
            // Set nilai kategori sesuai dengan yang tersimpan
            kategoriSelect.value = selectedKategori;

            // Panggil fungsi untuk menyesuaikan tampilan berdasarkan kategori
            adjustDisplay(selectedKategori);
        }

        kategoriSelect.addEventListener("change", function() {
            // Mengambil nilai yang dipilih pada dropdown "Pilih Kategori"
            var selectedKategori = kategoriSelect.value;

            // Menyimpan nilai kategori dalam localStorage
            localStorage.setItem("selectedKategori", selectedKategori);

            // Panggil fungsi untuk menyesuaikan tampilan berdasarkan kategori
            adjustDisplay(selectedKategori);
        });

        // Fungsi untuk menyesuaikan tampilan berdasarkan kategori
        function adjustDisplay(selectedKategori) {
            if (selectedKategori === "Memo Tambahan") {
                uangJalanInput.removeAttribute("readonly");
                formBiayaTambahan.style.display = "block";
                FormBorongan.style.display = "none";
                BorongPPh.style.display = "none";
                FormPotongan.style.display = "none";
                FormPelanggan.style.display = "none";
                FormRute.style.display = "block";
                MemoPerjalananBorong.style.display = "none";
                Memotambahanns.style.display = "block";
                FormMemotambahan.style.display = "block";
                Perjalananss.style.display = "none";
            } else if (selectedKategori === "Memo Perjalanan") {
                uangJalanInput.setAttribute("readonly", "readonly");
                formBiayaTambahan.style.display = "block";
                FormBorongan.style.display = "none";
                BorongPPh.style.display = "none";
                FormPelanggan.style.display = "none";
                FormRute.style.display = "block";
                Memoperjlan.style.display = "block";
                FormPotongan.style.display = "block";
                MemoPerjalananBorong.style.display = "block";
                Memotambahanns.style.display = "none";
                FormMemotambahan.style.display = "none";
                Perjalananss.style.display = "block";

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

            } else if (selectedKategori === "Memo Borong") {
                uangJalanInput.setAttribute("readonly", "readonly");
                FormBorongan.style.display = "block";
                BorongPPh.style.display = "block";
                formBiayaTambahan.style.display = "none";
                FormRute.style.display = "none";
                Memoperjlan.style.display = "none";
                FormPelanggan.style.display = "block";
                FormPotongan.style.display = "none";
                MemoPerjalananBorong.style.display = "block";
                Memotambahanns.style.display = "none";
                FormMemotambahan.style.display = "none";
                Perjalananss.style.display = "none";
                //
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
                //
            }
        }
    });

    document.addEventListener("DOMContentLoaded", function() {
        limitInput();
    });
    document.addEventListener("DOMContentLoaded", function() {
        limitInputs();
    });

    function limitInputs() {
        var depositInput = document.getElementById("depositsopir");
        var depositInputss = document.getElementById("depositsopir2");
        var checkbox = document.getElementById("additional_checkboxs");

        if (!checkbox.checked) {
            // If checkbox is not checked, set the input value to 50000
            var defaultValue = 50000;

            depositInput.value = defaultValue;
            depositInputss.value = formatRupiah(defaultValue);
            depositInputsst.value = formatRupiah(defaultValue); // Update the value of depositInputsst as well
        }
    }


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

    function formatRupiah(value) {
        return "Rp " + value.toLocaleString('id-ID');
    }

    function ShowMemo(selectedCategory) {
        $('#tableMemo').modal('show');
    }

    function getSelectedData(Memo_id, KodeMemo, NamaSopir, NoKabin, RutePerjalanan) {
        // Set the values in the form fields
        document.getElementById('memo_id').value = Memo_id;
        document.getElementById('kode_memosa').value = KodeMemo;
        document.getElementById('nama_driversa').value = NamaSopir;
        document.getElementById('no_kabinsa').value = NoKabin;
        document.getElementById('nama_rutesa').value = RutePerjalanan;
        // Close the modal (if needed)
        $('#tableMemo').modal('hide');
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

    function getSelectedDatarute(Rute_id, KodeRute, NamaRute, Golongan1, Golongan2, Golongan3, Golongan4, Golongan5,
        Golongan6, Golongan7, Golongan8, Golongan9, Golongan10) {

        var Golongan = document.getElementById("golongan").value;

        document.getElementById('rute_perjalanan_id').value = Rute_id;
        document.getElementById('kode_rute').value = KodeRute;
        document.getElementById('rute_perjalanan').value = NamaRute;

        if (Golongan === 'Golongan 1') {
            document.getElementById('biaya').value = Golongan1;
            var formattedNominal = parseFloat(Golongan1).toLocaleString('id-ID');
            document.getElementById('uangjalans').value = formattedNominal;
        } else if (Golongan === 'Golongan 2') {
            document.getElementById('biaya').value = Golongan2;
            var formattedNominal = parseFloat(Golongan2).toLocaleString('id-ID');
            document.getElementById('uangjalans').value = formattedNominal;
        } else if (Golongan === 'Golongan 3') {
            document.getElementById('biaya').value = Golongan3;
            var formattedNominal = parseFloat(Golongan3).toLocaleString('id-ID');
            document.getElementById('uangjalans').value = formattedNominal;
        } else if (Golongan === 'Golongan 4') {
            document.getElementById('biaya').value = Golongan4;
            var formattedNominal = parseFloat(Golongan4).toLocaleString('id-ID');
            document.getElementById('uangjalans').value = formattedNominal;
        } else if (Golongan === 'Golongan 5') {
            document.getElementById('biaya').value = Golongan5;
            var formattedNominal = parseFloat(Golongan5).toLocaleString('id-ID');
            document.getElementById('uangjalans').value = formattedNominal;
        } else if (Golongan === 'Golongan 6') {
            document.getElementById('biaya').value = Golongan6;
            var formattedNominal = parseFloat(Golongan6).toLocaleString('id-ID');
            document.getElementById('uangjalans').value = formattedNominal;
        } else if (Golongan === 'Golongan 7') {
            document.getElementById('biaya').value = Golongan7;
            var formattedNominal = parseFloat(Golongan7).toLocaleString('id-ID');
            document.getElementById('uangjalans').value = formattedNominal;
        } else if (Golongan === 'Golongan 8') {
            document.getElementById('biaya').value = Golongan8;
            var formattedNominal = parseFloat(Golongan8).toLocaleString('id-ID');
            document.getElementById('uangjalans').value = formattedNominal;
        } else if (Golongan === 'Golongan 9') {
            document.getElementById('biaya').value = Golongan9;
            var formattedNominal = parseFloat(Golongan9).toLocaleString('id-ID');
            document.getElementById('uangjalans').value = formattedNominal;
        } else if (Golongan === 'Golongan 10') {
            document.getElementById('biaya').value = Golongan10;
            var formattedNominal = parseFloat(Golongan10).toLocaleString('id-ID');
            document.getElementById('uangjalans').value = formattedNominal;

        }

        // Close the modal (if needed)
        $('#tableRute').modal('hide');

        updateSubTotals();
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
            document.getElementById('harga_rute').value = Golongan1;
        } else if (Golongan === 'Golongan 2') {
            document.getElementById('harga_rute').value = Golongan2;
        } else if (Golongan === 'Golongan 3') {
            document.getElementById('harga_rute').value = Golongan3;
        } else if (Golongan === 'Golongan 4') {
            document.getElementById('harga_rute').value = Golongan4;
        } else if (Golongan === 'Golongan 5') {
            document.getElementById('harga_rute').value = Golongan5;
        } else if (Golongan === 'Golongan 6') {
            document.getElementById('harga_rute').value = Golongan6;
        } else if (Golongan === 'Golongan 7') {
            document.getElementById('harga_rute').value = Golongan7;
        } else if (Golongan === 'Golongan 8') {
            document.getElementById('harga_rute').value = Golongan8;
        } else if (Golongan === 'Golongan 9') {
            document.getElementById('harga_rute').value = Golongan9;
        } else if (Golongan === 'Golongan 10') {
            document.getElementById('harga_rute').value = Golongan10;
        }


        // Close the modal (if needed)
        $('#tableRutes').modal('hide');
    }

    function potonganmemo(selectedCategory) {
        $('#tablePotongans').modal('show');
    }

    function getPotongan(Potongan_id, KodePotongan, Keterangan, Nominal) {
        // Set the values in the form fields

        var formattedNominal = parseFloat(Nominal).toLocaleString('id-ID');

        document.getElementById('potongan_id').value = Potongan_id;
        document.getElementById('kode_potongan').value = KodePotongan;
        document.getElementById('keteranganpotongan').value = Keterangan;
        document.getElementById('nominalpotongan').value = formattedNominal;
        document.getElementById('potongan_memo').value = formattedNominal;
        // Close the modal (if needed)
        $('#tablePotongans').modal('hide');

        updatePotongans();
    }

    function biayatambah(selectedCategory) {
        $('#tableBiaya').modal('show');
    }

    function getBiaya(Biaya_id, KodeBiaya, NamabIaya, Nominal) {
        var formattedNominal = parseFloat(Nominal).toLocaleString('id-ID');

        // Set the values in the form fields
        document.getElementById('biaya_id').value = Biaya_id;
        document.getElementById('kode_biaya').value = KodeBiaya;
        document.getElementById('nama_biaya').value = NamabIaya;
        document.getElementById('nominal').value = formattedNominal;
        document.getElementById('harga_tambahan').value = formattedNominal;
        // Close the modal (if needed)
        $('#tableBiaya').modal('hide');

        updateSubTotals();
    }

    // fungsi total harga memo perjalanan 
    function updateSubTotals() {

        var Biaya = document.getElementById("harga_tambahan").value;
        var Potongan = document.getElementById("potongan_memo").value;

        if (Biaya == 0) {
            var Uangjalans = parseCurrency($('#biaya').val()) || 0;
            var PotonganMemo = parseCurrency($('#potongan_memo').val().replace(/\./g, '')) || 0;
            var DepositDriv = parseCurrency($('#deposit_driver').val()) || 0;


            // Menghitung sub total (1% dari UangJaminan)
            var UangJaminan = Uangjalans - PotonganMemo;
            var satuPersenUangJaminan = 0.01 * UangJaminan;

            // Menetapkan nilai ke input uang_jaminan
            $('#uang_jaminan').val(formatRupiah(satuPersenUangJaminan));

            // Menghitung Subtotal (satuPersenUangJaminan - DepositDriv)
            var Subtotal = UangJaminan - satuPersenUangJaminan - DepositDriv;

            // Menetapkan nilai ke input sub_total
            $('#sub_total').val(formatRupiah(Subtotal));
        } else {
            // Mengambil nilai saldo masuk, sisa saldo, dan deposit driver
            var Uangjalans = parseCurrency($('#biaya').val()) || 0;
            var HargaTambahan = parseCurrency($('#harga_tambahan').val().replace(/\./g, '')) || 0;
            var DepositDriv = parseCurrency($('#deposit_driver').val()) || 0;


            // Menghitung sub total (1% dari UangJaminan)
            var UangJaminan = Uangjalans + HargaTambahan;
            var satuPersenUangJaminan = 0.01 * UangJaminan;

            // Menetapkan nilai ke input uang_jaminan
            $('#uang_jaminan').val(formatRupiah(satuPersenUangJaminan));

            // Menghitung Subtotal (satuPersenUangJaminan - DepositDriv)
            var Subtotal = UangJaminan - satuPersenUangJaminan - DepositDriv;

            // Menetapkan nilai ke input sub_total
            $('#sub_total').val(formatRupiah(Subtotal));
        }
    }

    function updatePotongans() {
        // Mengambil nilai saldo masuk, sisa saldo, dan deposit driver
        var Uangjalans = parseCurrency($('#biaya').val()) || 0;
        var PotonganMemo = parseCurrency($('#potongan_memo').val().replace(/\./g, '')) || 0;
        var DepositDriv = parseCurrency($('#deposit_driver').val()) || 0;


        // Menghitung sub total (1% dari UangJaminan)
        var UangJaminan = Uangjalans - PotonganMemo;
        var satuPersenUangJaminan = 0.01 * UangJaminan;

        // Menetapkan nilai ke input uang_jaminan
        $('#uang_jaminan').val(formatRupiah(satuPersenUangJaminan));

        // Menghitung Subtotal (satuPersenUangJaminan - DepositDriv)
        var Subtotal = UangJaminan - satuPersenUangJaminan - DepositDriv;

        // Menetapkan nilai ke input sub_total
        $('#sub_total').val(formatRupiah(Subtotal));
    }
</script>

<script>
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
        var sisaSaldo = parseCurrency($('#harga_rute').val()) || 0;
        var PPh2s = parseCurrency($('#pph2').val()) || 0;
        var UangJaminss = parseCurrency($('#uangjaminanss').val()) || 0;

        // Use parseFloat after removing commas and replacing dots with a decimal point
        var DepositSopirs = parseFloat(document.getElementById("depositsopir2").value.replace(/\./g, '').replace(
            /,/g, '.')) || 0;


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
        $('#totalrute').val(Total);

        // jika ingin total nominal ada titik
        // $('#totalrute').val(subTotalRupiah);
        $('#totalborong').val(subTotalRupiah);

        // Menetapkan nilai 1% dari UangJaminan ke input uang_jaminan_1_persen
        $('#uang_jaminan').val(formatRupiah(satuPersenUangJaminan));

        // Menetapkan nilai 2% dari UangJaminan ke input pph2
        $('#pph2').val(formatRupiah(DuaPersenPPH));

        // Menetapkan nilai 1% dari UangJaminan ke input uangjaminanss
        $('#uangjaminanss').val(formatRupiah(satuPersenUangJaminan));

        // Menghitung HasilTotals
        var HasilTotals = subTotal - satuPersenUangJaminan - DuaPersenPPH - DepositSopirs;

        // Menghitung dan membulatkan nilai SubTotal
        var SubTotal = Math.round(HasilTotals / 2);

        // Menetapkan nilai ke input hasilsss dan sub_total
        $('#hasilsss').val(formatRupiah(HasilTotals));
        $('#sub_total').val(formatRupiah(SubTotal));
    }

    function parseCurrency(value) {
        return parseFloat(value.replace(/[^\d.-]/g, '')) || 0;
    }

    function formatRupiah(value) {
        return value.toLocaleString('id-ID');
    }

    $(document).on("input", "#jumlah, #harga_rute, #pph2, #uangjaminanss, #depositsopir2", function() {
        updateSubTotal();
    });
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
    }

    function addRute() {
        jumlah_ban = jumlah_ban + 1;

        if (jumlah_ban === 1) {
            $('#tabel-rute').empty();
        }

        itemPembelianrute(jumlah_ban, jumlah_ban - 1);
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
        }
    }

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


        item_pembelian += '<td style="width: 50px">';
        item_pembelian += '<button type="button" class="btn btn-primary btn-sm" onclick="rutebaru(' + urutan +
            ')">';
        item_pembelian += '<i class="fas fa-plus"></i>';
        item_pembelian += '</button>';
        // item_pembelian +=
        //     '<button style="margin-left:5px" type="button" class="btn btn-danger btn-sm" onclick="removerute(' +
        //     urutan + ')">';
        // item_pembelian += '<i class="fas fa-trash"></i>';
        // item_pembelian += '</button>';
        item_pembelian += '</td>';
        item_pembelian += '</tr>';

        $('#tabel-rute').append(item_pembelian);
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
            itemPembelian(urutan, key, value);
        });
    }

    function addPesanan() {
        jumlah_ban = jumlah_ban + 1;

        if (jumlah_ban === 1) {
            $('#tabel-potongan').empty();
        }

        itemPembelian(jumlah_ban, jumlah_ban - 1);
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

    function itemPembelian(urutan, key, value = null) {
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
    function updateGrandTotal() {
        var grandTotal = 0;

        // Loop through all elements with name "nominal_tambahan[]"
        $('input[name^="nominal_tambahan"]').each(function() {
            var nominalValue = parseFloat($(this).val()) || 0;
            grandTotal += nominalValue;
        });

        // Set the calculated grand total to the input with ID "grand_total"
        $('#grand_total').val(grandTotal.toLocaleString(
            'id-ID')); // Menggunakan toLocaleString() dengan 'id-ID' sebagai bahasa Indonesia
    }

    // Panggil fungsi saat ada perubahan pada input "nominal_tambahan[]"
    $('body').on('input', 'input[name^="nominal_tambahan"]', function() {
        updateGrandTotal();
    });

    // Panggil fungsi saat halaman dimuat untuk menginisialisasi grand total
    $(document).ready(function() {
        updateGrandTotal();
    });


    var data_pembelian = @json(session('data_pembelians4'));
    var jumlah_ban = 1;

    if (data_pembelian != null) {
        jumlah_ban = data_pembelian.length;
        $('#tabel-memotambahan').empty();
        var urutan = 0;
        $.each(data_pembelian, function(key, value) {
            urutan = urutan + 1;
            itemPembelian(urutan, key, value);
        });
    }

    function addMemotambahan() {
        jumlah_ban = jumlah_ban + 1;

        if (jumlah_ban === 1) {
            $('#tabel-memotambahan').empty();
        }

        itemPembelian(jumlah_ban, jumlah_ban - 1);
    }

    function removeBan(params) {
        jumlah_ban = jumlah_ban - 1;

        var tabel_pesanan = document.getElementById('tabel-memotambahan');
        var pembelian = document.getElementById('memotambahan-' + params);

        tabel_pesanan.removeChild(pembelian);

        if (jumlah_ban === 0) {
            var item_pembelian = '<tr>';
            item_pembelian += '<td class="text-center" colspan="5">- Memo tambahan belum ditambahkan -</td>';
            item_pembelian += '</tr>';
            $('#tabel-memotambahan').html(item_pembelian);
        } else {
            var urutan = document.querySelectorAll('#urutantambahan');
            for (let i = 0; i < urutan.length; i++) {
                urutan[i].innerText = i + 1;
            }
        }
    }

    function itemPembelian(urutan, key, value = null) {
        var keterangan_tambahan = '';
        var nominal_tambahan = '';

        if (value !== null) {
            keterangan_tambahan = value.keterangan_tambahan;
            nominal_tambahan = value.nominal_tambahan;
        }

        // urutan 
        var item_pembelian = '<tr id="memotambahan-' + urutan + '">';
        item_pembelian += '<td style="width: 70px; font-size:14px" class="text-center" id="urutantambahan-' + urutan +
            '">' +
            urutan + '</td>';

        // keterangan_tambahan 
        item_pembelian += '<td>';
        item_pembelian += '<div class="form-group">'
        item_pembelian += '<input type="text" class="form-control" style="font-size:14px" id="keterangan_tambahan-' +
            urutan +
            '" name="keterangan_tambahan[]" value="' + keterangan_tambahan + '" ';
        item_pembelian += '</div>';
        item_pembelian += '</td>';

        // nominal_tambahan 
        item_pembelian += '<td>';
        item_pembelian += '<div class="form-group">'
        item_pembelian += '<input type="text" class="form-control" style="font-size:14px" id="nominal_tambahan-' +
            urutan +
            '" name="nominal_tambahan[]" value="' + nominal_tambahan + '" ';
        item_pembelian += '</div>';
        item_pembelian += '</td>';

        // item_pembelian += '<td style="width: 100px">';
        // item_pembelian += '<button type="button" class="btn btn-primary btn-sm" onclick="memotambahans(' + urutan +
        //     ')">';
        // item_pembelian += '<i class="fas fa-plus"></i>';
        // item_pembelian += '</button>';
        // item_pembelian +=
        //     '<button style="margin-left:5px" type="button" class="btn btn-danger btn-sm" onclick="removememotambahans(' +
        //     urutan + ')">';
        // item_pembelian += '<i class="fas fa-trash"></i>';
        // item_pembelian += '</button>';
        // item_pembelian += '</td>';
        item_pembelian += '</tr>';

        $('#tabel-memotambahan').append(item_pembelian);
    }
</script>

@endsection