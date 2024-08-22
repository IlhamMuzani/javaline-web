@extends('layouts.app')

@section('title', 'Inquery Faktur Sewa Kendaraan')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Inquery Faktur Sewa Kendaraan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/inquery_sewakendaraan') }}">Faktur Sewa
                                Kendaraan</a></li>
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
            <form action="{{ url('admin/inquery_sewakendaraan/' . $inquery->id) }}" method="POST"
                enctype="multipart/form-data" autocomplete="off">
                @csrf
                @method('put')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Faktur Sewa Kendaraan</h3>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label style="font-size:14px" class="form-label" for="kategori">Pilih
                                Kategori</label>
                            <select style="font-size:14px" class="form-control" id="kategori" name="kategori">
                                <option value="">- Pilih -</option>
                                <option value="PPH"
                                    {{ old('kategori', $inquery->kategori) == 'PPH' ? 'selected' : null }}>
                                    PPH</option>
                                <option value="NON PPH"
                                    {{ old('kategori', $inquery->kategori) == 'NON PPH' ? 'selected' : null }}>
                                    NON PPH</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div id="pelangganspk" class="card">
                            <div class="card-header">
                                <h3 class="card-title">Rekanan</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group" hidden>
                                    <label for="vendor_id">Rekanan Id</label>
                                    <input type="text" class="form-control" id="vendor_id" readonly name="vendor_id"
                                        placeholder="" value="{{ old('vendor_id', $inquery->vendor_id) }}">
                                </div>
                                <div class="form-group" hidden>
                                    <label for="kode_vendor">kode Rekan</label>
                                    <input type="text" class="form-control" id="kode_vendor" readonly name="kode_vendor"
                                        placeholder="" value="{{ old('kode_vendor') }}">
                                </div>
                                <label style="font-size:14px" class="form-label" for="nama_vendor">Nama
                                    Rekan</label>
                                <div class="form-group d-flex">
                                    <input onclick="showCategoryModalVendor(this.value)" class="form-control"
                                        id="nama_vendor" name="nama_vendor" type="text" placeholder=""
                                        value="{{ old('nama_vendor', $inquery->nama_vendor) }}" readonly
                                        style="margin-right: 10px; font-size:14px" />
                                    <button class="btn btn-primary" type="button"
                                        onclick="showCategoryModalVendor(this.value)">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                                <div class="form-group">
                                    <label style="font-size:14px" for="alamat_vendor">Alamat</label>
                                    <input onclick="showCategoryModalVendor(this.value)" style="font-size:14px"
                                        type="text" class="form-control" id="alamat_vendor" readonly name="alamat_vendor"
                                        placeholder="" value="{{ old('alamat_vendor', $inquery->vendor->alamat ?? null) }}">
                                </div>
                                <div class="form-group">
                                    <label style="font-size:14px" for="telp_vendor">No. Telp</label>
                                    <input onclick="showCategoryModalVendor(this.value)" style="font-size:14px"
                                        type="text" class="form-control" id="telp_vendor" readonly name="telp_vendor"
                                        placeholder="" value="{{ old('telp_vendor', $inquery->vendor->telp ?? null) }}">
                                </div>
                                <div class="form-check" style="color:white">
                                    <label class="form-check-label">
                                        .
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                        value="{{ old('kode_rute', $inquery->rute_perjalanan->kode_rute ?? null) }}"
                                        readonly style="margin-right: 10px; font-size:14px" />
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
                                        value="{{ old('nama_rute', $inquery->rute_perjalanan->nama_rute ?? null) }}">
                                </div>
                                <div class="form-check" style="color:white; margin-top:101px">
                                    <label class="form-check-label">
                                        .
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                                        value="{{ old('kode_pelanggan', $inquery->pelanggan->kode_pelanggan ?? null) }}">
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
                                        value="{{ old('alamat_pelanggan', $inquery->pelanggan->alamat ?? null) }}">
                                </div>
                                <div class="form-group">
                                    <label style="font-size:14px" for="telp_pelanggan">No. Telp</label>
                                    <input onclick="showCategoryModalPelanggan(this.value)" style="font-size:14px"
                                        type="text" class="form-control" id="telp_pelanggan" readonly
                                        name="telp_pelanggan" placeholder=""
                                        value="{{ old('telp_pelanggan', $inquery->pelanggan->telp ?? null) }}">
                                </div>
                                <div class="form-check" style="color:white">
                                    <label class="form-check-label">
                                        .
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6" id="form_rute">
                        <div id="rutespk" class="card">
                            <div class="card-header">
                                <h3 class="card-title">Nama Sopir</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label style="font-size:14px" for="nama_driver">Nama Sopir</label>
                                    <input style="font-size:14px" type="text" class="form-control" id="nama_driver"
                                        name="nama_driver" placeholder=""
                                        value="{{ old('nama_driver', $inquery->nama_driver) }}">
                                </div>
                                <div class="form-group">
                                    <label style="font-size:14px" for="telp_driver">Telp</label>
                                    <input style="font-size:14px" type="text" class="form-control" id="telp_driver"
                                        name="telp_driver" placeholder=""
                                        value="{{ old('telp_driver', $inquery->telp_driver) }}">
                                </div>
                                <div class="form-group">
                                    <label style="font-size:14px" for="no_pol">No Pol Kendaraan</label>
                                    <input style="font-size:14px" type="text" class="form-control" id="no_pol"
                                        name="no_pol" placeholder="" value="{{ old('no_pol', $inquery->no_pol) }}">
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

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tarif <span>
                            </span></h3>
                        <div class="float-right">
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="font-size:14px">Kode Tarif</th>
                                    <th style="font-size:14px">Nama Tarif</th>
                                    <th style="font-size:14px">Harga Tarif</th>
                                    <th style="font-size:14px">Qty</th>
                                    <th style="font-size:14px">Satuan</th>
                                    <th style="font-size:14px">Total</th>
                                    <th style="font-size:14px; text-align:center">Opsi</th>
                                </tr>
                            </thead>
                            <tbody id="tabel-pembelian">
                                <tr id="pembelian-0">
                                    <td hidden>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="tarif_id"
                                                value="{{ old('tarif_id', $inquery->tarif_id) }}" name="tarif_id">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input onclick="Tarifs(0)" style="font-size:14px" type="text"
                                                class="form-control" readonly id="kode_tarif" name="kode_tarif"
                                                value="{{ old('kode_tarif', $inquery->kode_tarif) }}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input onclick="Tarifs(0)" style="font-size:14px" type="text"
                                                class="form-control" readonly id="nama_tarif" name="nama_tarif"
                                                value="{{ old('nama_tarif', $inquery->nama_tarif) }}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input onclick="Tarifs(0)" style="font-size:14px" type="text"
                                                class="form-control harga_tarif" readonly id="harga_tarif"
                                                name="harga_tarif" data-row-id="0"
                                                value="{{ old('harga_tarif', number_format($inquery->harga_tarif, 0, ',', '.')) }}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input style="font-size:14px" type="text" class="form-control jumlah"
                                                id="jumlah" name="jumlah" data-row-id="0"
                                                value="{{ old('jumlah', str_replace(',', '.', $inquery->jumlah)) }}">
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
                                                <option value="kg"
                                                    {{ old('satuan', $inquery->satuan) == 'kg' ? 'selected' : null }}>
                                                    kg</option>
                                                <option value="ton"
                                                    {{ old('satuan', $inquery->satuan) == 'ton' ? 'selected' : null }}>
                                                    ton</option>
                                                <option value="dus"
                                                    {{ old('satuan', $inquery->satuan) == 'dus' ? 'selected' : null }}>
                                                    dus</option>
                                                <option value="M3"
                                                    {{ old('M3', $inquery->satuan) == 'M3' ? 'selected' : null }}>
                                                    M&sup3;</option>
                                                <option value="rit"
                                                    {{ old('satuan', $inquery->satuan) == 'rit' ? 'selected' : null }}>
                                                    rit</option>
                                                <option value="hr"
                                                    {{ old('satuan', $inquery->satuan) == 'hr' ? 'selected' : null }}>
                                                    hr</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input onclick="Tarifs(0)" style="font-size:14px" type="text"
                                                class="form-control total_tarif" readonly id="total_tarif"
                                                name="total_tarif"
                                                value="{{ old('total_tarif', $inquery->total_tarif) }}">
                                        </div>
                                    </td>
                                    <td style="width: 50px">
                                        <button type="button" class="btn btn-primary btn-sm" onclick="Tarifs(0)">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group mt-2">
                            <label style="font-size:14px" for="keterangan">Keterangan</label>
                            <textarea style="font-size:14px" type="text" class="form-control" id="keterangan" name="keterangan"
                                placeholder="Masukan keterangan">{{ old('keterangan', $inquery->keterangan) }}</textarea>
                        </div>
                    </div>
                </div>

                <div>
                    <div>
                        {{-- <div class="row"> --}}
                        <div hidden class="col-md-6">
                            <div class="card" id="form_biayatambahan">
                                <div class="card-header">
                                    <h3 class="card-title">Biaya Tambahan <span>
                                        </span></h3>
                                    <div class="float-right">
                                        <button type="button" class="btn btn-primary btn-sm"
                                            onclick="addMemotambahan()">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th style="font-size:14px" class="text-center">No</th>
                                                <th style="font-size:14px">Keterangan</th>
                                                <th style="font-size:14px">Nominal</th>
                                                <th style="font-size:14px">Qty</th>
                                                <th style="font-size:14px">Satuan</th>
                                                <th style="font-size:14px">Opsi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tabel-memotambahan">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label style="font-size:14px; margin-top:5px" for="tarif">Tarif
                                                    <span style="margin-left:89px">:</span></label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input style="text-align: end; font-size:14px;" type="text"
                                                    class="form-control total_tarif2" readonly id="total_tarif2"
                                                    name="total_tarif2" placeholder=""
                                                    value="{{ old('total_tarif2', $inquery->total_tarif2) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label style="font-size:14px; margin-top:5px" for="tarif">PPH
                                                    2%
                                                    <span style="margin-left:69px">:</span></label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input style="text-align: end; font-size:14px;" type="text"
                                                    class="form-control pph2" readonly id="pph2" name="pph"
                                                    placeholder="" value="{{ old('pph', $inquery->pph) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <hr
                                            style="border: 2px solid black; display: inline-block; width: 97%; vertical-align: middle;">
                                        <span
                                            style="display: inline-block; margin-left: 0px; margin-right: 0; font-size: 18px; vertical-align: middle;">-</span>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label style="font-size:14px; margin-top:5px" for="tarif">
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input style="text-align: end; font-size:14px;" type="text"
                                                    class="form-control sisa" readonly id="sisa" name="sisa"
                                                    placeholder="" value="{{ old('sisa', $inquery->sisa) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" hidden>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label style="font-size:14px; margin-top:5px" for="tarif">Biaya
                                                    Tambahan
                                                    <span class="ml-3">:</span></label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input style="text-align: end; font-size:14px;" type="text"
                                                    class="form-control" readonly id="biaya_tambahan"
                                                    name="biaya_tambahan" placeholder=""
                                                    value="{{ number_format($inquery->uang_jalan, 0, ',', '.') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label style="font-size:14px; margin-top:5px" for="tarif">Potongan %
                                                    <span style="margin-left:44px">:</span></label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input style="text-align: end; font-size:14px;" type="number"
                                                        class="form-control" id="nominal_potongan"
                                                        name="nominal_potongan" placeholder="masukkan nominal_potongan"
                                                        value="{{ number_format($inquery->nominal_potongan, 0, ',', '.') }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <input style="text-align: end; font-size:14px;" type="text"
                                                        class="form-control" readonly id="hasil_potongan"
                                                        name="hasil_potongan" placeholder=""
                                                        value="{{ number_format($inquery->hasil_potongan, 0, ',', '.') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr
                                        style="border: 2px solid black; display: inline-block; width: 97%; vertical-align: middle;">
                                    <span
                                        style="display: inline-block; margin-left: 0px; margin-right: 0; font-size: 17px; vertical-align: middle;">+</span>
                                    <div class="col-lg-6">

                                    </div>
                                    <div class="form-group">
                                        <label style="font-size:14px; margin-top:5px" for="sub_total">Grand
                                            Total <span style="margin-left:46px">:</span></label>
                                        <input style="text-align: end; margin:right:10px; font-size:14px;" type="text"
                                            class="form-control sub_total" readonly id="sub_total" name="sub_total"
                                            placeholder="" value="{{ old('sub_total', $inquery->grand_total) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- </div> --}}

                        <div class="card-footer text-right">
                            <button type="reset" class="btn btn-secondary">Reset</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
            </form>
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

        <div class="modal fade" id="tableVendor" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Rekanan</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table id="datatables2" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Kode Rekanan</th>
                                    <th>Nama Rekanan</th>
                                    <th>Alamat</th>
                                    <th>No. Telp</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($vendors as $vendor)
                                    <tr
                                        onclick="getSelectedDataVendor('{{ $vendor->id }}', '{{ $vendor->kode_vendor }}', '{{ $vendor->nama_vendor }}', '{{ $vendor->alamat }}', '{{ $vendor->telp }}')">
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $vendor->kode_vendor }}</td>
                                        <td>{{ $vendor->nama_vendor }}</td>
                                        <td>{{ $vendor->alamat }}</td>
                                        <td>{{ $vendor->telp }}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-primary btn-sm"
                                                onclick="getSelectedDataVendor('{{ $vendor->id }}', '{{ $vendor->kode_vendor }}', '{{ $vendor->nama_vendor }}', '{{ $vendor->alamat }}', '{{ $vendor->telp }}')">
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
                            <table id="datatables5" class="table table-bordered table-striped">
                                <thead class="bg-200 text-900">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Kode Rute</th>
                                        <th>Rute Perjalanan</th>
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
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="getSelectedDatarute('{{ $rute_perjalanan->id }}', '{{ $rute_perjalanan->kode_rute }}', '{{ $rute_perjalanan->nama_rute }}')">
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

        <div class="modal fade" id="tableHarga" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Harga Sewa</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive scrollbar m-2">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead class="bg-200 text-900">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Kode Harga</th>
                                        <th>Rute Perjalanan</th>
                                        <th>Harga</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($harga_sewas as $harga_sewa)
                                        <tr onclick="getSelectedDatahargasewa('{{ $harga_sewa->id }}', '{{ $harga_sewa->kode_tarif }}', '{{ $harga_sewa->nama_tarif }}', '{{ $harga_sewa->nominal }}')"
                                            class="selectable-row">
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $harga_sewa->kode_tarif }}
                                            </td>
                                            <td>{{ $harga_sewa->nama_tarif }}
                                            </td>
                                            <td>{{ $harga_sewa->nominal }}
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="getSelectedDatahargasewa('{{ $harga_sewa->id }}', '{{ $harga_sewa->kode_tarif }}', '{{ $harga_sewa->nama_tarif }}', '{{ $harga_sewa->nominal }}')">
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


        function showCategoryModalVendor(selectedCategory) {
            $('#tableVendor').modal('show');
        }

        function getSelectedDataVendor(Vendor_id, KodeVendor, NamaVendor, AlamatVendord, TelpVendor) {
            // Set the values in the form fields
            document.getElementById('vendor_id').value = Vendor_id;
            document.getElementById('kode_vendor').value = KodeVendor;
            document.getElementById('nama_vendor').value = NamaVendor;
            document.getElementById('alamat_vendor').value = AlamatVendord;
            document.getElementById('telp_vendor').value = TelpVendor;
            // Close the modal (if needed)
            $('#tableVendor').modal('hide');
        }

        function showCategoryModalrute(selectedCategory) {
            $('#tableRute').modal('show');
        }

        function getSelectedDatarute(Rute_id, KodeRute, NamaRute) {

            document.getElementById('rute_perjalanan_id').value = Rute_id;
            document.getElementById('kode_rute').value = KodeRute;
            document.getElementById('rute_perjalanan').value = NamaRute;
            // Close the modal (if needed)
            $('#tableRute').modal('hide');
        }
    </script>

    <script>
        function showCategoryModalhargasewa(selectedCategory) {
            $('#tableHarga').modal('show');
        }

        function getSelectedDatahargasewa(Harga_Sewaid, KodeTarif, NamaTarif, HargaTarif) {

            document.getElementById('harga_sewa_id').value = Harga_Sewaid;
            document.getElementById('kode_tarif').value = KodeTarif;
            document.getElementById('nama_tarif').value = NamaTarif;
            document.getElementById('harga_tarif').value = HargaTarif;
            // Close the modal (if needed)
            updateHarga();
            $('#tableHarga').modal('hide');
        }

        $(document).ready(function() {
            updateHarga(); // Panggil updateHarga saat dokumen telah siap
        });

        function updateHarga() {
            var selectedValue = document.getElementById("kategori").value;
            var hargasatuan = parseFloat($(".harga_tarif").val().replace(/\./g, '')) || 0;
            var jumlah = parseFloat($(".jumlah").val()) || 0;
            var nominal_potongan = parseFloat($("#nominal_potongan").val()) || 0;

            // Remove dots and parse as float for biaya_tambahan
            // var biaya_tambahan = parseFloat($("#biaya_tambahan").val().replace(/\./g, '')) || 0;
            var biaya_tambahan = parseFloat($("#biaya_tambahan").val().replace(/\./g, "")) || 0;
            var hargas = hargasatuan * jumlah;
            var harga = hargasatuan * jumlah + biaya_tambahan;


            $(".total_tarif").val(hargas.toLocaleString('id-ID'));
            $(".total_tarif2").val(harga.toLocaleString('id-ID'));

            if (selectedValue == "PPH") {
                var pph = 0.02 * harga;
                var sisa = harga - pph;
                 var hasil_potongan = (sisa * nominal_potongan) / 100;
                $("#hasil_potongan").val(hasil_potongan.toLocaleString('id-ID'));
                var Subtotal = sisa - hasil_potongan;
                $(".pph2").val(pph.toLocaleString('id-ID'));
                $(".sisa").val(sisa.toLocaleString('id-ID'));
                $(".sub_total").val(Subtotal.toLocaleString('id-ID'));
            } else {
                var hasil_potongan = (harga * nominal_potongan) / 100;
                $("#hasil_potongan").val(hasil_potongan.toLocaleString('id-ID'));
                $(".pph2").val(0);
                $(".sisa").val(harga.toLocaleString('id-ID'));
                var Subtotal = harga - hasil_potongan;
                $(".sub_total").val(Subtotal.toLocaleString('id-ID'));
            }
        }

        $(document).on("input", ".harga_tarif, .jumlah, #nominal_potongan, #hasil_potongan, #biaya_tambahan", function() {
            updateHarga();
        });

        function setPphValue() {
            var kategori = document.getElementById("kategori").value;
            var pphInput = document.getElementById("pph2");

            // Jika kategori adalah NON PPH, atur nilai pph2 menjadi 0
            if (kategori === "NON PPH") {
                pphInput.value = 0;
                updateHarga();
            }
            // Jika kategori adalah PPH, atur nilai pph2 sesuai dengan nilai dari server
            else if (kategori === "PPH") {
                updateHarga();

            }
        }

        // Panggil fungsi setPphValue() saat halaman dimuat ulang
        document.addEventListener("DOMContentLoaded", setPphValue);

        // Tambahkan event listener untuk mendeteksi perubahan pada elemen <select>
        document.getElementById("kategori").addEventListener("change", setPphValue);
    </script>

@endsection
