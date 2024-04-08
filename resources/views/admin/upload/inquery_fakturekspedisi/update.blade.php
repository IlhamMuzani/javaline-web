@extends('layouts.app')

@section('title', 'Inquery Faktur Ekspedisi')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Inquery Faktur Ekspedisi</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/inquery_fakturekspedisi') }}">Faktur Ekspedisi</a>
                        </li>
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
            <form action="{{ url('admin/inquery_fakturekspedisi/' . $inquery->id) }}" method="POST"
                enctype="multipart/form-data" autocomplete="off">
                @csrf
                @method('put')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Perbarui Faktur Ekspedisi</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group">
                            <label style="font-size:14px" class="form-label" for="kategori">Pilih Kategori</label>
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
                        <div class="form-group" style="flex: 8;">
                            <div class="row">
                                {{-- <div class="mb-3 mt-4">
                                <button class="btn btn-primary btn-sm" type="button" onclick="ShowMemo(this.value)">
                                    <i class="fas fa-plus mr-2"></i> Pilih Pelanggan
                                </button>
                            </div> --}}
                                <div class="form-group" hidden>
                                    <label for="pelanggan_id">pelanggan Id</label>
                                    <input type="text" class="form-control" id="pelanggan_id" readonly
                                        name="pelanggan_id" placeholder=""
                                        value="{{ old('pelanggan_id', $inquery->pelanggan_id) }}">
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label style="font-size:14px" for="kode_pelanggan">Kode Pelanggan</label>
                                        <input style="font-size:14px" type="text" class="form-control"
                                            id="kode_pelanggan" readonly name="kode_pelanggan" placeholder=""
                                            value="{{ old('kode_pelanggan', $inquery->kode_pelanggan) }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label style="font-size:14px" class="form-label" for="nama_pelanggan">Nama
                                        Pelanggan</label>
                                    <div class="form-group d-flex">
                                        <input class="form-control" id="nama_pelanggan" name="nama_pelanggan" type="text"
                                            placeholder="" value="{{ old('nama_pelanggan', $inquery->nama_pelanggan) }}"
                                            readonly style="margin-right: 10px; font-size:14px" />
                                        <button class="btn btn-primary" type="button"
                                            onclick="showCategoryModalPelanggan(this.value)">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label style="font-size:14px" for="telp_pelanggan">No. Telp</label>
                                        <input style="font-size:14px" type="text" class="form-control"
                                            id="telp_pelanggan" readonly name="telp_pelanggan" placeholder=""
                                            value="{{ old('telp_pelanggan', $inquery->telp_pelanggan) }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label style="font-size:14px" for="alamat_pelanggan">Alamat</label>
                                        <input style="font-size:14px" type="text" class="form-control"
                                            id="alamat_pelanggan" readonly name="alamat_pelanggan" placeholder=""
                                            value="{{ old('alamat_pelanggan', $inquery->alamat_pelanggan) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Memo Ekspedisi <span>
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
                                    <th style="font-size:14px">No Memo</th>
                                    <th style="font-size:14px">Nama Sopir</th>
                                    <th style="font-size:14px">Rute Perjalanan</th>
                                    <th style="font-size:14px; text-align:center">Opsi</th>
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
                                                <input type="text" class="form-control"
                                                    id="nomor_seri-{{ $loop->index }}" name="detail_ids[]"
                                                    value="{{ $detail['id'] }}">
                                            </div>
                                        </td>
                                        <td hidden>
                                            <div class="form-group">
                                                <input type="text" class="form-control"
                                                    id="memo_ekspedisi_id-{{ $loop->index }}" name="memo_ekspedisi_id[]"
                                                    value="{{ $detail['memo_ekspedisi_id'] }}{{ $detail['memotambahan_id'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input style="font-size:14px" readonly type="text"
                                                    class="form-control" id="kode_memo-{{ $loop->index }}"
                                                    name="kode_memo[]" value="{{ $detail['kode_memo'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input style="font-size:14px" readonly type="text"
                                                    class="form-control" id="nama_driver-{{ $loop->index }}"
                                                    name="nama_driver[]" value="{{ $detail['nama_driver'] }}">
                                            </div>
                                        </td>
                                        <td hidden>
                                            <div class="form-group">
                                                <input style="font-size:14px" readonly type="text"
                                                    class="form-control" id="telp_driver-{{ $loop->index }}"
                                                    name="telp_driver[]" value="{{ $detail['telp_driver'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input style="font-size:14px" readonly type="text"
                                                    class="form-control" id="nama_rute-{{ $loop->index }}"
                                                    name="nama_rute[]" value="{{ $detail['nama_rute'] }}">
                                            </div>
                                        </td>
                                        <td hidden>
                                            <div class="form-group">
                                                <input style="font-size:14px" readonly type="text"
                                                    class="form-control" id="kendaraan_id-{{ $loop->index }}"
                                                    name="kendaraan_id[]" value="{{ $detail['kendaraan_id'] }}">
                                            </div>
                                        </td>
                                        <td hidden>
                                            <div class="form-group">
                                                <input style="font-size:14px" readonly type="text"
                                                    class="form-control" id="no_kabin-{{ $loop->index }}"
                                                    name="no_kabin[]" value="{{ $detail['no_kabin'] }}">
                                            </div>
                                        </td>
                                        <td hidden>
                                            <div class="form-group">
                                                <input style="font-size:14px" readonly type="text"
                                                    class="form-control" id="no_pol-{{ $loop->index }}" name="no_pol[]"
                                                    value="{{ $detail['no_pol'] }}">
                                            </div>
                                        </td>
                                        <td style="width: 100px">
                                            <button type="button" class="btn btn-primary btn-sm"
                                                onclick="MemoEkspedisi({{ $loop->index }})">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                            <button style="margin-left:5px" type="button" class="btn btn-danger btn-sm"
                                                onclick="removeBan({{ $loop->index }}, {{ $detail['id'] }})">
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
                                            <input style="font-size:14px" type="text" class="form-control" readonly
                                                id="kode_tarif" name="kode_tarif"
                                                value="{{ old('kode_tarif', $inquery->kode_tarif) }}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input style="font-size:14px" type="text" class="form-control" readonly
                                                id="nama_tarif" name="nama_tarif"
                                                value="{{ old('nama_tarif', $inquery->nama_tarif) }}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input style="font-size:14px" type="text" class="form-control harga_tarif"
                                                readonly id="harga_tarif" name="harga_tarif" data-row-id="0"
                                                value="{{ old('harga_tarif', number_format($inquery->harga_tarif, 0, ',', '.')) }}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input style="font-size:14px" type="number" class="form-control jumlah"
                                                id="jumlah" name="jumlah" data-row-id="0"
                                                value="{{ old('jumlah', $inquery->jumlah) }}">
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
                                                <option value="dus"
                                                    {{ old('kubik', $inquery->satuan) == 'kubik' ? 'selected' : null }}>
                                                    kubik</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input style="font-size:14px" type="text" class="form-control total_tarif"
                                                readonly id="total_tarif" name="total_tarif"
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
                        <div class="row">
                            <div class="col-md-6">
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
                                                </tr>
                                            </thead>
                                            <tbody id="tabel-memotambahan">
                                                @foreach ($detailtarifs as $detail)
                                                    <tr id="memotambahan-{{ $loop->index }}">
                                                        <td style="width: 70px; font-size:14px" class="text-center"
                                                            id="urutantambahan">{{ $loop->index + 1 }}
                                                        </td>
                                                        <td>
                                                            <div class="form-group" hidden>
                                                                <input type="text" class="form-control"
                                                                    id="nomor_seri-{{ $loop->index }}"
                                                                    name="detail_idss[]" value="{{ $detail['id'] }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <input style="font-size:14px" type="text"
                                                                    class="form-control"
                                                                    id="keterangan_tambahan-{{ $loop->index }}"
                                                                    name="keterangan_tambahan[]"
                                                                    value="{{ $detail['keterangan_tambahan'] }}">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <input style="font-size:14px" type="number"
                                                                    class="form-control"
                                                                    id="nominal_tambahan-{{ $loop->index }}"
                                                                    name="nominal_tambahan[]"
                                                                    value="{{ $detail['nominal_tambahan'] }}">
                                                            </div>
                                                        </td>
                                                        <td style="width: 50px">
                                                            <button style="margin-left:5px" type="button"
                                                                class="btn btn-danger btn-sm"
                                                                onclick="removememotambahans({{ $loop->index }})">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
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
                                                    <label style="font-size:14px; margin-top:5px" for="tarif">PPH 2%
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
                                        <div class="row">
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
                                        <hr
                                            style="border: 2px solid black; display: inline-block; width: 97%; vertical-align: middle;">
                                        <span
                                            style="display: inline-block; margin-left: 0px; margin-right: 0; font-size: 17px; vertical-align: middle;">+</span>

                                        <div class="col-lg-6">

                                        </div>
                                        <div class="form-group">
                                            <label style="font-size:14px; margin-top:5px" for="sub_total">Grand
                                                Total <span style="margin-left:46px">:</span></label>
                                            <input style="text-align: end; margin:right:10px; font-size:14px;"
                                                type="text" class="form-control sub_total" readonly id="sub_total"
                                                name="sub_total" placeholder=""
                                                value="{{ old('sub_total', $inquery->grand_total) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

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
                                    <tr>
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

        <div class="modal fade" id="tableMemo" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Memo Ekspedisi</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table id="datatables66" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Kode Memo</th>
                                    <th>Nama Sopir</th>
                                    <th>Rute Perjalanan</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($memos as $memo)
                                    <tr data-id="{{ $memo->id }}"
                                        data-kode_memo="@if ($memoEkspedisi == true) {{ $memo->kode_memo }} @endif @if ($memoTambahan == true) {{ $memo->kode_tambahan }} @endif"
                                        data-nama_driver="@if ($memoEkspedisi == true) {{ $memo->nama_driver }} @endif @if ($memoTambahan == true) {{ $memo->nama_driver }} @endif"
                                        data-telp_driver="@if ($memoEkspedisi == true) {{ $memo->telp }}@else{{ $memo->telp }} @endif"
                                        data-nama_rute="@if ($memoEkspedisi == true) {{ $memo->nama_rute }}@else{{ $memo->nama_rute }} @endif"
                                        data-kendaraan_id="@if ($memoEkspedisi == true) {{ $memo->kendaraan_id }}@else{{ $memo->kendaraan_id }} @endif"
                                        data-no_kabin="@if ($memoEkspedisi == true) {{ $memo->no_kabin }}@else{{ $memo->no_kabin }} @endif"
                                        data-no_pol="@if ($memoEkspedisi == true) {{ $memo->no_pol }}@else{{ $memo->no_pol }} @endif"
                                        data-param="{{ $loop->index }}">
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>
                                            @if ($memoEkspedisi == true)
                                                {{ $memo->kode_memo }}
                                            @endif
                                            @if ($memoTambahan == true)
                                                {{ $memo->kode_tambahan }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($memoEkspedisi == true)
                                                {{ $memo->nama_driver }}
                                            @else
                                                {{ $memo->nama_driver }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($memoEkspedisi == true)
                                                {{ $memo->nama_rute }}
                                            @else
                                                {{ $memo->nama_rute }}
                                            @endif
                                        </td>

                                        <td class="text-center">
                                            <button type="button" id="btnTambah" class="btn btn-primary btn-sm"
                                                onclick="getMemos({{ $loop->index }})">
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

        <div class="modal fade" id="tableTarif" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Tarif</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table id="datatables3" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Kode Tarif</th>
                                    <th>Nama Tarif</th>
                                    <th>Nominal</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tarifs as $tarif)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $tarif->kode_tarif }}</td>
                                        <td>{{ $tarif->nama_tarif }}</td>
                                        <td>{{ number_format($tarif->nominal, 0, ',', '.') }}</td>
                                        <td class="text-center">
                                            <button type="button" id="btnTambah" class="btn btn-primary btn-sm"
                                                onclick="getTarifs('{{ $tarif->id }}', '{{ $tarif->kode_tarif }}', '{{ $tarif->nama_tarif }}', '{{ $tarif->nominal }}')">
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

    </section>


    <script>
        function showCategoryModalPelanggan(selectedCategory) {
            $('#tablePelanggan').modal('show');
        }

        function getSelectedDataPelanggan(Pelanggan_id, KodePelanggan, NamaPell, AlamatPel, Telpel) {
            // Set the values in the form fields
            document.getElementById('pelanggan_id').value = Pelanggan_id;
            document.getElementById('kode_pelanggan').value = KodePelanggan;
            document.getElementById('nama_pelanggan').value = NamaPell;
            document.getElementById('alamat_pelanggan').value = AlamatPel;
            document.getElementById('telp_pelanggan').value = Telpel;
            // Close the modal (if needed)
            $('#tablePelanggan').modal('hide');
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

        var counter = 0;

        function addPesanan() {
            counter++;
            jumlah_ban = jumlah_ban + 1;

            if (jumlah_ban === 1) {
                $('#tabel-pembelian').empty();
            } else {
                // Find the last row and get its index to continue the numbering
                var lastRow = $('#tabel-pembelian tr:last');
                var lastRowIndex = lastRow.find('#urutan').text();
                jumlah_ban = parseInt(lastRowIndex) + 1;
            }

            console.log('Current jumlah_ban:', jumlah_ban);
            itemPembelian(jumlah_ban, jumlah_ban - 1);
            updateUrutans();
        }


        function updateUrutans() {
            var urutan = document.querySelectorAll('#urutan');
            for (let i = 0; i < urutan.length; i++) {
                urutan[i].innerText = i + 1;
            }
        }


        function removeBan(identifier, detailId) {
            var row = document.getElementById('pembelian-' + identifier);
            row.remove();

            $.ajax({
                url: "{{ url('admin/inquery_fakturekspedisi/deletedetailfaktur/') }}/" + detailId,
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

            updateUrutans();
        }

        function itemPembelian(identifier, key, value = null) {
            var memo_ekspedisi_id = '';
            var kode_memo = '';
            var nama_driver = '';
            var telp_driver = '';
            var nama_rute = '';
            var kendaraan_id = '';
            var no_kabin = '';
            var no_pol = '';

            if (value !== null) {
                memo_ekspedisi_id = value.memo_ekspedisi_id;
                kode_memo = value.kode_memo;
                nama_driver = value.nama_driver;
                telp_driver = value.telp_driver;
                nama_rute = value.nama_rute;
                kendaraan_id = value.kendaraan_id;
                no_kabin = value.no_kabin;
                no_pol = value.no_pol;
            }

            // urutan 
            var item_pembelian = '<tr id="pembelian-' + key + '">';
            item_pembelian += '<td  style="width: 70px; font-size:14px" class="text-center" id="urutan">' + key +
                '</td>';

            // biaya_id 
            item_pembelian += '<td hidden>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" id="memo_ekspedisi_id-' + key +
                '" name="memo_ekspedisi_id[]" value="' + memo_ekspedisi_id + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // kode_memo 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" style="font-size:14px" readonly id="kode_memo-' +
                key +
                '" name="kode_memo[]" value="' + kode_memo + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // nama_driver 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" style="font-size:14px" readonly id="nama_driver-' +
                key +
                '" name="nama_driver[]" value="' + nama_driver + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // telp_driver 
            item_pembelian += '<td hidden>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" style="font-size:14px" readonly id="telp_driver-' +
                key +
                '" name="telp_driver[]" value="' + telp_driver + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';


            // nama_rute 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control" style="font-size:14px" readonly id="nama_rute-' +
                key +
                '" name="nama_rute[]" value="' + nama_rute + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // kendaraan_id 
            item_pembelian += '<td hidden>';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control" style="font-size:14px" readonly id="kendaraan_id-' +
                key +
                '" name="kendaraan_id[]" value="' + kendaraan_id + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // no_kabin 
            item_pembelian += '<td hidden>';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control" style="font-size:14px" readonly id="no_kabin-' +
                key +
                '" name="no_kabin[]" value="' + no_kabin + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // no_pol 
            item_pembelian += '<td hidden>';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control" style="font-size:14px" readonly id="no_pol-' +
                key +
                '" name="no_pol[]" value="' + no_pol + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            item_pembelian += '<td style="width: 100px">';
            item_pembelian += '<button type="button" class="btn btn-primary btn-sm" onclick="MemoEkspedisi(' + key +
                ')">';
            item_pembelian += '<i class="fas fa-plus"></i>';
            item_pembelian += '</button>';
            item_pembelian +=
                '<button style="margin-left:5px" type="button" class="btn btn-danger btn-sm" onclick="removeBan(' +
                key + ')">';
            item_pembelian += '<i class="fas fa-trash"></i>';
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
            $('#tabel-memotambahan').empty();
            var urutan = 0;
            $.each(data_pembelian, function(key, value) {
                urutan = urutan + 1;
                itemPembelians(urutan, key, value);
            });
        }

        function updateUrutan() {
            var urutan = document.querySelectorAll('#urutantambahan');
            for (let i = 0; i < urutan.length; i++) {
                urutan[i].innerText = i + 1;
            }
        }

        var counter = 0;

        function addMemotambahan() {
            counter++;
            jumlah_ban = jumlah_ban + 1;

            if (jumlah_ban === 1) {
                $('#tabel-memotambahan').empty();
            }

            itemPembelians(jumlah_ban, jumlah_ban - 1);
            updateUrutan();
        }

        //  function addMemotambahan() {
        //     jumlah_ban = jumlah_ban + 1;

        //     if (jumlah_ban === 1) {
        //         $('#tabel-memotambahan').empty();
        //     }

        //     itemPembelians(jumlah_ban, jumlah_ban - 1);
        // }

        function removememotambahans(identifier, detailId) {
            var row = document.getElementById('memotambahan-' + identifier);
            row.remove();

            // $.ajax({
            //     url: "{{ url('admin/ban/') }}/" + detailId,
            //     type: "POST",
            //     data: {
            //         _method: 'DELETE',
            //         _token: '{{ csrf_token() }}'
            //     },
            //     success: function(response) {
            //         console.log('Data deleted successfully');
            //     },
            //     error: function(error) {
            //         console.error('Failed to delete data:', error);
            //     }
            // });

            updateUrutan();
        }

        function itemPembelians(identifier, key, value = null) {
            var keterangan_tambahan = '';
            var nominal_tambahan = '';

            if (value !== null) {
                keterangan_tambahan = value.keterangan_tambahan;
                nominal_tambahan = value.nominal_tambahan;
            }

            // urutan 
            var item_pembelian = '<tr id="memotambahan-' + urutan + '">';
            item_pembelian += '<td style="width: 70px; font-size:14px" class="text-center" id="urutantambahan">' + urutan +
                '</td>';

            // keterangan_tambahan 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" style="font-size:14px" id="keterangan_tambahan-' +
                key +
                '" name="keterangan_tambahan[]" value="' + keterangan_tambahan + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // nominal_tambahan 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" style="font-size:14px" id="nominal_tambahan-' +
                key +
                '" name="nominal_tambahan[]" value="' + nominal_tambahan + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            item_pembelian += '<td style="width: 50px">';
            item_pembelian +=
                '<button style="margin-left:5px" type="button" class="btn btn-danger btn-sm" onclick="removememotambahans(' +
                urutan + ')">';
            item_pembelian += '<i class="fas fa-trash"></i>';
            item_pembelian += '</button>';
            item_pembelian += '</td>';
            item_pembelian += '</tr>';

            $('#tabel-memotambahan').append(item_pembelian);
        }

        function updateGrandTotal() {
            var grandTotal = 0;
            // Loop through all elements with name "nominal_tambahan[]"
            $('input[name^="nominal_tambahan"]').each(function() {
                var nominalValue = parseFloat($(this).val()) || 0;
                grandTotal += nominalValue;
            });

            $('#grand_total').val(grandTotal.toLocaleString(
                'id-ID'));

            $('#biaya_tambahan').val(grandTotal.toLocaleString(
                'id-ID'));
        }

        $('body').on('input', 'input[name^="nominal_tambahan"]', function() {
            updateGrandTotal();
            updateHarga();
        });

        // Panggil fungsi saat halaman dimuat untuk menginisialisasi grand total
        $(document).ready(function() {
            updateGrandTotal();
        });
    </script>

    <script>
        var activeSpecificationIndex = 0;

        function MemoEkspedisi(param) {
            activeSpecificationIndex = param;
            // Show the modal and filter rows if necessary
            $('#tableMemo').modal('show');
        }

        // membatasi inputan memo
        function getMemos(rowIndex) {
            var selectedRow = $('#datatables66 tbody tr:eq(' + rowIndex + ')');
            var memo_ekspedisi_id = selectedRow.data('id');
            var kode_memo = selectedRow.data('kode_memo');
            var nama_driver = selectedRow.data('nama_driver');
            var telp_driver = selectedRow.data('telp_driver');
            var nama_rute = selectedRow.data('nama_rute');
            var kendaraan_id = selectedRow.data('kendaraan_id');
            var no_kabin = selectedRow.data('no_kabin');
            var no_pol = selectedRow.data('no_pol');

            // Check if there are already 2 entries with the 'MP' prefix
            var mpPrefixCount = 0;
            var mbBrefixCount = 0;
            var mtTrefixCount = 0;
            $('input[name^="kode_memo"]').each(function() {
                var currentValue = $(this).val();
                if (currentValue.startsWith('MP')) {
                    mpPrefixCount++;
                    if (mpPrefixCount >= 2) {
                        if (!kode_memo.startsWith('MP')) {
                            // Allow entry with a different prefix
                            return true; // Continue with the loop
                        } else {
                            alert('Anda hanya dapat menambahkan 2 memo perjalanan"');
                            // Prevent modal from being hidden on validation failure
                            return false; // exit the loop if the condition is met
                        }
                    }
                }
                if (currentValue.startsWith('MB')) {
                    mbBrefixCount++;
                    if (mbBrefixCount >= 1) {
                        if (!kode_memo.startsWith('MB')) {
                            // Allow entry with a different prefix
                            return true; // Continue with the loop
                        } else {
                            alert('Anda hanya dapat menambahkan 1 memo borong');
                            // Prevent modal from being hidden on validation failure
                            return false; // exit the loop if the condition is met
                        }
                    }
                }

                if (currentValue.startsWith('MT')) {
                    mtTrefixCount++;
                    if (mtTrefixCount >= 2) {
                        if (!kode_memo.startsWith('MT')) {
                            // Allow entry with a different prefix
                            return true; // Continue with the loop
                        } else {
                            alert('Anda hanya dapat menambahkan 2 memo tambahan');
                            // Prevent modal from being hidden on validation failure
                            return false; // exit the loop if the condition is met
                        }
                    }
                }
            });

            // Check if validation failed
            if (mpPrefixCount >= 2 && kode_memo.startsWith('MP')) {
                // Do not hide the modal if validation failed
                return;
            }

            if (mbBrefixCount >= 1 && kode_memo.startsWith('MB')) {
                // Do not hide the modal if validation failed
                return;
            }

            if (mtTrefixCount >= 2 && kode_memo.startsWith('MT')) {
                // Do not hide the modal if validation failed
                return;
            }

            // Update the form fields for the active specification
            $('#memo_ekspedisi_id-' + activeSpecificationIndex).val(memo_ekspedisi_id);
            $('#kode_memo-' + activeSpecificationIndex).val(kode_memo);
            $('#nama_driver-' + activeSpecificationIndex).val(nama_driver);
            $('#telp_driver-' + activeSpecificationIndex).val(telp_driver);
            $('#nama_rute-' + activeSpecificationIndex).val(nama_rute);
            $('#kendaraan_id-' + activeSpecificationIndex).val(kendaraan_id);
            $('#no_kabin-' + activeSpecificationIndex).val(no_kabin);
            $('#no_pol-' + activeSpecificationIndex).val(no_pol);

            // Hide the modal after updating the form fields
            $('#tableMemo').modal('hide');
        }


        $(document).on("input", ".hargasatuan, .jumlah", function() {
            var currentRow = $(this).closest('tr');
            var hargasatuan = parseFloat(currentRow.find(".hargasatuan").val()) || 0;
            var jumlah = parseFloat(currentRow.find(".jumlah").val()) || 0;
            var harga = hargasatuan * jumlah;
            currentRow.find(".harga").val(harga);


        });
    </script>

    <script>
        function Tarifs(selectedCategory) {
            $('#tableTarif').modal('show');
        }

        function getTarifs(Tarif_id, Kodetarif, NamaTarif, Nominal) {

            // Set the values in the form fields
            document.getElementById('tarif_id').value = Tarif_id;
            document.getElementById('kode_tarif').value = Kodetarif;
            document.getElementById('nama_tarif').value = NamaTarif;
            var formattedNominal = parseFloat(Nominal).toLocaleString('id-ID');
            // Assuming 'biaya_tambahan' is an input element
            document.getElementById('harga_tarif').value = formattedNominal;
            // Close the modal (if needed)

            updateHarga();
            $('#tableTarif').modal('hide');
        }

        function updateHarga() {
            var selectedValue = document.getElementById("kategori").value;
            var hargasatuan = parseFloat($(".harga_tarif").val().replace(/\./g, '')) || 0;
            var jumlah = parseFloat($(".jumlah").val()) || 0;

            // Remove dots and parse as float for biaya_tambahan
            var biaya_tambahan = parseFloat($("#biaya_tambahan").val().replace(/\./g, '')) || 0;

            var harga = hargasatuan * jumlah;

            $(".total_tarif").val(harga.toLocaleString('id-ID'));
            $(".total_tarif2").val(harga.toLocaleString('id-ID'));

            if (selectedValue == "PPH") {
                var pph = 0.02 * harga;
                var sisa = harga - pph;
                var Subtotal = sisa + biaya_tambahan;
                $(".pph2").val(pph.toLocaleString('id-ID'));
                $(".sisa").val(sisa.toLocaleString('id-ID'));
                $(".sub_total").val(Subtotal.toLocaleString('id-ID'));
            } else {
                // Jika kategori NON PPH, tidak kurangkan 2%
                $(".pph2").val(0);
                $(".sisa").val(harga.toLocaleString('id-ID'));
                var Subtotal = harga + biaya_tambahan;
                $(".sub_total").val(Subtotal.toLocaleString('id-ID'));
            }
        }

        $(document).on("input", ".harga_tarif, .jumlah, #biaya_tambahan", function() {
            updateHarga();
        });
    </script>

    <script>
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
