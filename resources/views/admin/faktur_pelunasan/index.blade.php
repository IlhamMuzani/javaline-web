@extends('layouts.app')

@section('title', 'Faktur Pelunasan')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="containers-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Faktur Pelunasan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/faktur_pelunasan') }}">Faktur Pelunasan</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="containers-fluid">
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
            <form action="{{ url('admin/faktur_pelunasan') }}" method="POST" enctype="multipart/form-data"
                autocomplete="off">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Faktur Pelunasan</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group" style="flex: 8;">
                            <div class="col-md-0 mb-3">
                                <label>Kategori</label>
                                <select class="custom-select form-control" id="kategori" name="kategori">
                                    <option value="">- Pilih Kategori -</option>
                                    <option value="pelunasan1">Pelunasan Per Faktur</option>
                                    {{-- <option value="pelunasan2">Pelunasan Per Invoice</option> --}}
                                    <option value="pelunasan3" selected>Pelunasan lebih dari 1 kali</option>
                                </select>
                            </div>
                        </div>
                        <label style="font-size:14px" class="form-label" for="kode_tagihan">Kode invoice</label>
                        <div class="form-group d-flex">
                            <input class="form-control" hidden id="tagihan_ekspedisi_id" name="tagihan_ekspedisi_id"
                                type="text" placeholder="" value="{{ old('tagihan_ekspedisi_id') }}" readonly
                                style="margin-right: 10px; font-size:14px" />
                            <input class="form-control" id="kode_tagihan" name="kode_tagihan" type="text" placeholder=""
                                value="{{ old('kode_tagihan') }}" readonly style="margin-right: 10px; font-size:14px" />
                            <button class="btn btn-primary" type="button" onclick="showCategoryModalPelanggan(this.value)">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div>
                    <div>
                        {{-- <div class="row"> --}}
                        {{-- <div class="col-md-4"> --}}
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Pelanggan</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group" hidden>
                                    <label for="pelanggan_id">return Id</label>
                                    <input type="text" class="form-control" id="pelanggan_id" readonly
                                        name="pelanggan_id" placeholder="" value="{{ old('pelanggan_id') }}">
                                </div>
                                <div class="form-group">
                                    <label style="font-size:14px" for="kode_pelanggan">Kode Pelanggan</label>
                                    <input style="font-size:14px" type="text" class="form-control" id="kode_pelanggan"
                                        readonly name="kode_pelanggan" placeholder="" value="{{ old('kode_pelanggan') }}">
                                </div>
                                <div class="form-group">
                                    <label style="font-size:14px" for="nama_pelanggan">Nama Pelanggan</label>
                                    <input style="font-size:14px" type="text" class="form-control" id="nama_pelanggan"
                                        readonly name="nama_pelanggan" placeholder="" value="{{ old('nama_pelanggan') }}">
                                </div>
                                <div class="form-group" hidden>
                                    <div class="form-group">
                                        <label style="font-size:14px" for="alamat_pelanggan">Alamat
                                            return</label>
                                        <input style="font-size:14px" type="text" class="form-control"
                                            id="alamat_pelanggan" readonly name="alamat_pelanggan" placeholder=""
                                            value="{{ old('alamat_pelanggan') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-group">
                                        <label style="font-size:14px" for="telp_pelanggan">No. Telp</label>
                                        <input style="font-size:14px" type="text" class="form-control"
                                            id="telp_pelanggan" readonly name="telp_pelanggan" placeholder=""
                                            value="{{ old('telp_pelanggan') }}">
                                    </div>
                                </div>
                                <div class="form-check" style="color:white">
                                    <label class="form-check-label">
                                        .
                                    </label>
                                </div>
                            </div>
                        </div>
                        {{-- </div> --}}
                        {{-- </div> --}}
                        <div id="forms-containers"></div>
                        {{-- <div class="card">
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="form-group">
                                    <label style="font-size:14px" for="grand_total">Grand Total</label>
                                    <input style="font-size:14px; text-align:end" type="text" class="form-control"
                                        id="grand_total" readonly name="grand_total" placeholder=""
                                        value="{{ old('grand_total') }}">
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button type="reset" class="btn btn-secondary" id="btnReset">Reset</button>
                                <button type="submit" class="btn btn-primary" id="btnSimpan">Simpan</button>
                                <div id="loading" style="display: none;">
                                    <i class="fas fa-spinner fa-spin"></i> Sedang Menyimpan...
                                </div>
                            </div>
                        </div> --}}

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Potongan Return <span>
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
                                            <th style="font-size:14px">Kode Faktur</th>
                                            <th style="font-size:14px">Kode Potongan</th>
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
                                                    <input type="text" class="form-control" id="nota_return_id-0"
                                                        name="nota_return_id[]">
                                                </div>
                                            </td>
                                            <td style="width:25%">
                                                <div class="form-group">
                                                    <select class="select2bs4 select2-hidden-accessible"
                                                        name="faktur_id[]" data-placeholder="Pilih Faktur.."
                                                        style="width: 100%;" data-select2-id="23" tabindex="-1"
                                                        aria-hidden="true" id="faktur_id-0">
                                                        <option value="">- Pilih Faktur -</option>
                                                        @foreach ($fakturs as $faktur)
                                                            <option value="{{ $faktur->id }}">
                                                                {{ $faktur->kode_faktur }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <input onclick="potonganmemo(0)" style="font-size:14px"
                                                        type="text" class="form-control" readonly id="kode_potongan-0"
                                                        name="kode_potongan[]">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <input onclick="potonganmemo(0)" style="font-size:14px"
                                                        type="text" class="form-control" readonly
                                                        id="keterangan_potongan-0" name="keterangan_potongan[]">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <input onclick="potonganmemo(0)" style="font-size:14px"
                                                        type="text" class="form-control" id="nominal_potongan-0"
                                                        readonly name="nominal_potongan[]">
                                                </div>
                                            </td>
                                            <td style="width: 100px">
                                                <button style="margin-left:5px" type="button"
                                                    class="btn btn-danger btn-sm" onclick="removeBan(0)">
                                                    <i class="fas fa-trash"></i>
                                                </button>
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
                            <div class="card-header">
                                <h3 class="card-title">Potongan Lain-lain <span>
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
                                            <th style="font-size:14px">Kode Potongan</th>
                                            <th style="font-size:14px">Keterangan</th>
                                            <th style="font-size:14px">Nominal</th>
                                            <th style="font-size:14px">Opsi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabel-pembelianlain">
                                        <tr id="pembelianlain-0">
                                            <td style="width: 70px; font-size:14px" class="text-center" id="urutanlain">1
                                            </td>
                                            <td hidden>
                                                <div class="form-group">
                                                    <input type="text" class="form-control"
                                                        id="potongan_penjualan_id-0" name="potongan_penjualan_id[]">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <input onclick="biayatambah(0)" style="font-size:14px" type="text"
                                                        class="form-control" readonly id="kode_potonganlain-0"
                                                        name="kode_potonganlain[]">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <input onclick="biayatambah(0)" style="font-size:14px" type="text"
                                                        class="form-control" readonly id="keterangan_potonganlain-0"
                                                        name="keterangan_potonganlain[]">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <input onclick="biayatambah(0)" style="font-size:14px" type="text"
                                                        class="form-control" id="nominallain-0" readonly
                                                        name="nominallain[]">
                                                </div>
                                            </td>
                                            <td style="width: 100px">
                                                <button style="margin-left:5px" type="button"
                                                    class="btn btn-danger btn-sm" onclick="removeTambahan(0)">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="biayatambah(0)">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>

                                </table>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Rincian Pembayaran</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label style="font-size: 14px" for="panjang">Kategori Pembayaran</label>
                                            <select style="font-size: 14px" class="form-control" id="kategori"
                                                name="kategori">
                                                <option value="">- Pilih -</option>
                                                <option value="Bilyet Giro"
                                                    {{ old('kategori') == 'Bilyet Giro' ? 'selected' : null }}>
                                                    Bilyet Giro BG / Cek</option>
                                                <option value="Transfer"
                                                    {{ old('kategori') == 'Transfer' ? 'selected' : null }}>
                                                    Transfer</option>
                                                <option value="Tunai"
                                                    {{ old('kategori') == 'Tunai' ? 'selected' : null }}>
                                                    Tunai</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label style="font-size: 14px" id="bg" for="lebar">No.
                                                BG/Cek</label>
                                            <label style="font-size: 14px" id="trans" for="lebar">No.
                                                Transfer</label>
                                            <label style="font-size: 14px" id="tun" for="lebar">Tunai</label>
                                            <input style="font-size: 14px" type="text" class="form-control"
                                                id="nomor" name="nomor" placeholder="masukkan no"
                                                value="{{ old('nomor') }}">
                                        </div>
                                        <div class="form-group">
                                            <label style="font-size: 14px" for="tinggi">Tanggal</label>
                                            <div class="input-group date" id="reservationdatetime">
                                                <input style="font-size: 14px" type="date" id="tanggal"
                                                    name="tanggal_transfer" placeholder="d M Y sampai d M Y"
                                                    data-options='{"mode":"range","dateFormat":"d M Y","disableMobile":true}'
                                                    value="{{ old('tanggal_transfer') }}"
                                                    class="form-control datetimepicker-input"
                                                    data-target="#reservationdatetime">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label style="font-size: 14px" for="tinggi">Nominal</label>
                                            <input style="font-size: 14px" type="text" class="form-control"
                                                id="nominal" placeholder="masukkan nominal" name="nominal"
                                                value="{{ old('nominal') }}"
                                                onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || event.charCode == 46">
                                        </div>
                                    </div>
                                    <div class="col-md-6" style="margin-left: 89px">
                                        <div class="form-group">
                                            <label style="font-size: 14px" for="totalpenjualan">Sub Total</label>
                                            <input style="text-align: end; font-size: 14px" type="text"
                                                class="form-control" id="totalpembayaran" readonly name="totalpenjualan"
                                                placeholder="" value="{{ old('totalpenjualan') }}">
                                        </div>
                                        <div class="form-group">
                                            <label style="font-size: 14px" for="tinggi">Potongan Return</label>
                                            <input style="text-align: end; font-size: 14px" type="text"
                                                class="form-control" id="ongkosBongkar" readonly name="dp"
                                                placeholder="" value="{{ old('dp') }}">
                                        </div>
                                        <div class="form-group">
                                            <label style="font-size: 14px" for="tinggi">Potongan Lain-lain</label>
                                            <input style="text-align: end; font-size: 14px" type="text"
                                                class="form-control" id="tambahan_pembayaran" readonly
                                                name="potonganselisih" placeholder=""
                                                value="{{ old('potonganselisih') }}">
                                        </div>
                                        <hr style="border: 2px solid black;">
                                        <div class="form-group">
                                            <label style="font-size: 14px" for="tinggi">Total Pembayaran</label>
                                            <input style="text-align: end; font-size: 14px" type="text"
                                                class="form-control" id="totalPembayarans" readonly
                                                name="totalpembayaran" value="{{ old('totalpembayaran') }}"
                                                placeholder="">
                                        </div>
                                        <div class="form-group">
                                            <label style="font-size: 14px" for="saldo_masuk">Pembayaran</label>
                                            <input style="text-align: end; font-size: 14px" type="text"
                                                class="form-control" readonly id="saldo_masuk" name="saldo_masuk"
                                                placeholder="" value="{{ old('saldo_masuk') }}">
                                        </div>
                                        <div class="form-group">
                                            <label style="font-size: 14px" for="tinggi">Selisih Pembayaran</label>
                                            <input style="text-align: end; font-size: 14px" type="text"
                                                class="form-control" id="hasilselisih" readonly name="selisih"
                                                value="{{ old('selisih') }}" placeholder="">
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
                    </div>
                </div>
        </div>
        </form>

        <div class="modal fade" id="tableReturn" data-backdrop="static">
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
                                    <th>Kode Penerimaan</th>
                                    <th>Tanggal</th>
                                    <th>Pelanggan</th>
                                    {{-- <th>No Kabin</th>
                                    <th>Sopir</th> --}}
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoices as $return)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $return->kode_tagihan }}</td>
                                        <td>{{ $return->tanggal }}</td>
                                        <td>{{ $return->nama_pelanggan }}</td>
                                        {{-- <td>{{ $return->no_kabin }}</td>
                                        <td>{{ $return->nama_driver }}</td> --}}
                                        <td class="text-center">
                                            <button type="button" class="btn btn-primary btn-sm"
                                                onclick="GetReturn(
                                                '{{ $return->id }}',
                                                '{{ $return->kode_tagihan }}',
                                                '{{ $return->pelanggan_id }}',
                                                '{{ $return->kode_pelanggan }}',
                                                '{{ $return->nama_pelanggan }}',
                                                '{{ $return->telp_pelanggan }}',
                                                '{{ $return->alamat_pelanggan }}',
                                                '{{ $return->detail_tagihan->where('faktur_ekspedisi.status_pelunasan', null)->pluck('faktur_ekspedisi_id')->implode(', ') }}',
                                                '{{ $return->detail_tagihan->where('faktur_ekspedisi.status_pelunasan', null)->pluck('kode_faktur')->implode(', ') }}',
                                                '{{ $return->detail_tagihan->where('faktur_ekspedisi.status_pelunasan', null)->pluck('tanggal_memo')->implode(', ') }}',
                                                '{{ $return->detail_tagihan->where('faktur_ekspedisi.status_pelunasan', null)->pluck('faktur_ekspedisi.grand_total')->implode(', ') }}',
                                                '{{ $return->detail_tagihan->where('faktur_ekspedisi.status_pelunasan', null)->pluck('total_faktur')->implode(', ') }}'
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

        <div class="modal fade" id="tablePotongans" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Return</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="m-2">
                            <input type="text" id="searchInput" class="form-control" placeholder="Search...">
                        </div>
                        <table id="tables" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Kode Potongan</th>
                                    <th>Tanggal</th>
                                    <th>Nominal</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($returns as $potongan)
                                    <tr onclick="getPotongan({{ $loop->index }})" data-id="{{ $potongan->id }}"
                                        data-kode_nota="{{ $potongan->kode_nota }}"
                                        data-tanggal_awal="{{ $potongan->tanggal_awal }}"
                                        data-grand_total="{{ $potongan->grand_total }}"
                                        data-param="{{ $loop->index }}">
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $potongan->kode_nota }}</td>
                                        <td>{{ $potongan->tanggal_awal }}</td>
                                        <td>{{ number_format($potongan->grand_total, 0, ',', '.') }}</td>
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

        <div class="modal fade" id="tableBiaya" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Potongan Lain-lain</h4>
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
                                    <th>Keterangan</th>
                                    <th>Nominal</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($potonganlains as $potonganlain)
                                    <tr onclick="getBiaya({{ $loop->index }})" data-id="{{ $potonganlain->id }}"
                                        data-kode_potongan="{{ $potonganlain->kode_potongan }}"
                                        data-keterangan="{{ $potonganlain->keterangan }}"
                                        data-grand_total="{{ $potonganlain->grand_total }}"
                                        data-param="{{ $loop->index }}">
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $potonganlain->kode_potongan }}</td>
                                        <td>{{ $potonganlain->keterangan }}</td>
                                        <td>{{ number_format($potonganlain->grand_total, 0, ',', '.') }}</td>
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
    </section>


    <script>
        function showCategoryModalPelanggan(selectedCategory) {
            $('#tableReturn').modal('show');
        }

        function attachInputEventListeners(index) {
            // Attach input event listener for both "kode_tagihan" and "tanggal_return" fields
            $('#jumlah_' + index + ', #harga_' + index).on('input', function() {
                updateTotal(index);
            });
        }

        function saveFormDataToSessionStorageFaktur() {
            var formData = $('#forms-containers').html();
            sessionStorage.setItem('formData', formData);
        }

        // Call this function when the page is loaded to retrieve and display the saved form data
        // Call this function when the page is loaded to retrieve and display the saved form data
        function loadFormDataFromSessionStorage() {
            var formData = sessionStorage.getItem('formData');
            var returnId = $('#tagihan_ekspedisi_id').val(); // Get the value of return_id

            // Check if formData exists and return_id is not empty
            if (formData && returnId.trim() !== "") {
                $('#forms-containers').html(formData);
                attachInputEventListenersAfterLoad();
            } else {
                // If formData doesn't exist or return_id is empty, clear forms-containers
                $('#forms-containers').html('');
            }
        }

        // Call loadFormDataFromSessionStorage() on document ready
        $(document).ready(function() {
            loadFormDataFromSessionStorage();
        });

        $(document).ready(function() {
            loadFormDataFromSessionStorage();
        });
        // Attach input event listeners after loading the form data
        function attachInputEventListenersAfterLoad() {
            for (var i = 0; i < Fakturekspedisi_id.length; i++) {
                attachInputEventListeners(i);
            }
        }

        $(document).ready(function() {
            // Attach click event listener using event delegation
            $(document).on('click', '.btn-delete-row', function() {
                $(this).closest('tr').remove(); // Remove the closest row when delete button clicked

                // Update grand total when a row is deleted
                updateGrandTotal();
                updateSubTotalsxx();
                updateSubTotal();
            });
        });

        function filterTable() {
            var input, filter, table, tr, td, i, j, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("tables");
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

        function GetReturn(Return_id, KodeReturn, Pelanggan_id, KodePelanggan, NamaPell, Telpel, AlamatPelanggan,
            Faktur_ekspedisi_id, Kode_faktur, Tanggal_faktur, Total) {

            document.getElementById('tagihan_ekspedisi_id').value = Return_id;
            document.getElementById('kode_tagihan').value = KodeReturn;
            document.getElementById('pelanggan_id').value = Pelanggan_id;
            document.getElementById('kode_pelanggan').value = KodePelanggan;
            document.getElementById('nama_pelanggan').value = NamaPell;
            document.getElementById('telp_pelanggan').value = Telpel;
            document.getElementById('alamat_pelanggan').value = AlamatPelanggan;

            var Fakturekspedisi_id = Faktur_ekspedisi_id.split(', ');
            var KodeFaktur = Kode_faktur.split(', ');
            var Tanggalfaktur = Tanggal_faktur.split(', ');
            var TotalArray = Total.split(',').map(parseFloat); // Parse to float

            $('#forms-containers').html('');

            // Create forms for each faktur
            var formHtml = '<div class="card mb-3">' +
                '<div class="card-header">' +
                '<h3 class="card-title">Form Faktur</h3>' +
                '</div>' +
                '<div class="card-body">' +
                '<table class="table table-bordered table-striped">' +
                '<thead>' +
                '<tr>' +
                '<th style="font-size:14px" class="text-center">No</th>' +
                '<th style="font-size:14px">Kode Faktur</th>' +
                '<th style="font-size:14px">Tgl Ekspedisi</th>' +
                '<th style="font-size:14px">Total</th>' +
                '<th style="font-size:14px">Aksi</th>' + // Tambah kolom aksi
                '</tr>' +
                '</thead>' +
                '<tbody id="tabel-pembelian">';

            var grandTotal = 0; // Variable to store the grand total

            for (var i = 0; i < Fakturekspedisi_id.length; i++) {
                var totalFormatted = TotalArray[i].toLocaleString('id-ID'); // Format the total for display
                formHtml += '<tr>' +
                    '<td style="width: 70px; font-size:14px" class="text-center urutan">' + (i + 1) + '</td>' +
                    '<td hidden>' +
                    '   <div class="form-group">' +
                    '       <input type="text" class="form-control" name="faktur_ekspedisi_id[]" value="' +
                    Fakturekspedisi_id[i] +
                    '" readonly>' +
                    '   </div>' +
                    '</td>' +
                    '<td>' +
                    '   <div class="form-group">' +
                    '       <input style="font-size:14px" readonly type="text" class="form-control kode_faktur" name="kode_faktur[]" value="' +
                    KodeFaktur[i] + '">' +
                    '   </div>' +
                    '</td>' +
                    '<td>' +
                    '   <div class="form-group">' +
                    '       <input style="font-size:14px" readonly type="text" class="form-control tanggal_faktur" name="tanggal_faktur[]" value="' +
                    Tanggalfaktur[i] + '">' +
                    '   </div>' +
                    '</td>' +
                    '<td>' +
                    '   <div class="form-group">' +
                    '       <input style="font-size:14px; text-align: right" readonly type="text" class="form-control total" name="total[]" value="' +
                    totalFormatted + '">' +
                    '   </div>' +
                    '</td>' + // Display the formatted total
                    '<td>' + // Kolom aksi untuk tombol hapus
                    '   <button type="button" class="btn btn-danger btn-sm btn-delete-row"><i class="fa fa-trash"></i></button>' +
                    '</td>' +
                    '</tr>';

                grandTotal += TotalArray[i]; // Calculate the grand total
            }

            // Format grand total
            var grandTotalFormatted = grandTotal.toLocaleString('id-ID');

            // Add row for grand total
            formHtml += '<tr id="grandTotalRow">' +
                '<td colspan="3" style="text-align: right; font-size:14px"><strong>Grand Total:</strong></td>' +
                '<td id="grandTotalCell" style="font-size:14px; text-align: right; padding-right:25px;">' +
                grandTotalFormatted + '</td>' +
                '<td></td>' + // Kolom kosong untuk selaras dengan kolom aksi
                '</tr>';



            formHtml += '</tbody>' +
                '</table>' +
                '</div>' +
                '</div>';

            $('#forms-containers').append(formHtml);

            // Set the grand total value to the element with id 'totalpembayaran'
            $('#totalpembayaran').val(formatRupiah(grandTotal));

            // Update subtotal
            updateSubTotalsxx();
            updateSubTotal();

            // Hide modal
            $('#tableReturn').modal('hide');

            // Save form data to session storage
            saveFormDataToSessionStorageFaktur();

            // Attach event listeners after loading the form data
            attachInputEventListenersAfterLoad();

        }

        function saveFormDataToSessionStorageFaktur() {
            var formData = $('#forms-containers').html();
            sessionStorage.setItem('formData', formData);
        }

        function updateGrandTotal() {
            var grandTotal = 0;
            // Loop through each row to sum up the total values
            $('.total').each(function() {
                grandTotal += parseFloat($(this).val().replace(/\D/g, '') ||
                    0); // Parse and sum up the total values
            });

            // Format grand total
            var grandTotalFormatted = formatRupiah(grandTotal);
            var grandlocale = grandTotal.toLocaleString('id-ID'); // Menggunakan toLocaleString() untuk format lokal

            // Update the displayed grand total
            $('#totalpembayaran').val(grandTotalFormatted);
            $('#grandTotalCell').text(grandlocale);

            // Optionally, update other related values or perform any necessary actions
        }




        function formatRupiah(number) {
            var formatted = new Intl.NumberFormat('id-ID', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(number);
            return formatted;
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
        var data_pembelian = @json(session('data_pembelians2'));
        var jumlah_ban = 1;

        if (data_pembelian != null) {
            jumlah_ban = data_pembelian.length;
            $('#tabel-potongan').empty();
            var urutan = 0;
            $.each(data_pembelian, function(key, value) {
                urutan = urutan + 1;
                itemPembelian(urutan, key, false, value);
            });
        }

        function addPesanan() {
            jumlah_ban = jumlah_ban + 1;

            if (jumlah_ban === 1) {
                $('#tabel-potongan').empty();
            }

            itemPembelian(jumlah_ban, jumlah_ban - 1, true);
        }

        function removeBan(params) {
            jumlah_ban = jumlah_ban - 1;

            var tabel_pesanan = document.getElementById('tabel-potongan');
            var pembelian = document.getElementById('potongan-' + params);

            tabel_pesanan.removeChild(pembelian);

            if (jumlah_ban === 0) {
                var item_pembelian = '<tr>';
                item_pembelian += '<td class="text-center" colspan="5">- Potongan belum ditambahkan -</td>';
                item_pembelian += '</tr>';
                $('#tabel-potongan').html(item_pembelian);
            } else {
                var urutan = document.querySelectorAll('#urutanpotongan');
                for (let i = 0; i < urutan.length; i++) {
                    urutan[i].innerText = i + 1;
                }
            }
            updateGrandTotalreturn();
            updateSubTotalsxx();
            updateSubTotal();
        }

        function itemPembelian(urutan, key, style, value = null) {
            var nota_return_id = '';
            var faktur_id = '';
            var kode_potongan = '';
            var keterangan_potongan = '';
            var nominal_potongan = '';

            if (value !== null) {
                nota_return_id = value.nota_return_id;
                faktur_id = value.faktur_id;
                kode_potongan = value.kode_potongan;
                keterangan_potongan = value.keterangan_potongan;
                nominal_potongan = value.nominal_potongan;

            }

            // urutan 
            var item_pembelian = '<tr id="potongan-' + urutan + '">';
            item_pembelian += '<td style="width: 70px; font-size:14px" class="text-center" id="urutanpotongan-' + urutan +
                '">' +
                urutan + '</td>';

            // nota_return_id 
            item_pembelian += '<td hidden>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" id="nota_return_id-' + urutan +
                '" name="nota_return_id[]" value="' + nota_return_id + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // kode_faktur 
            item_pembelian += '<td style="width:25%">';
            item_pembelian += '<div class="form-group">';
            item_pembelian += '<select class="form-control select2bs4" id="faktur_id-' + key +
                '" name="faktur_id[]">';
            item_pembelian += '<option value="">Pilih Faktur..</option>';
            item_pembelian += '@foreach ($fakturs as $faktur_id)';
            item_pembelian +=
                '<option value="{{ $faktur_id->id }}" {{ $faktur_id->id == ' + faktur_id + ' ? 'selected' : '' }}>{{ $faktur_id->kode_faktur }}</option>';
            item_pembelian += '@endforeach';
            item_pembelian += '</select>';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // kode_potongan 
            item_pembelian += '<td onclick="potonganmemo(' + urutan +
                ')">';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" readonly style="font-size:14px" id="kode_potongan-' +
                urutan +
                '" name="kode_potongan[]" value="' + kode_potongan + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // keterangan_potongan 
            item_pembelian += '<td onclick="potonganmemo(' + urutan +
                ')">';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control" readonly style="font-size:14px" id="keterangan_potongan-' +
                urutan +
                '" name="keterangan_potongan[]" value="' + keterangan_potongan + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // nominal_potongan 
            item_pembelian += '<td onclick="potonganmemo(' + urutan +
                ')">';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control" style="font-size:14px" readonly id="nominal_potongan-' +
                urutan +
                '" name="nominal_potongan[]" value="' + nominal_potongan + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            item_pembelian += '<td style="width: 100px">';
            item_pembelian +=
                '<button type="button" style="margin-left:5px" class="btn btn-danger btn-sm" onclick="removeBan(' +
                urutan + ')">';
            item_pembelian += '<i class="fas fa-trash"></i>';
            item_pembelian += '</button>';
            item_pembelian +=
                '<button style="margin-left:3px" type="button" class="btn btn-primary btn-sm" onclick="potonganmemo(' +
                urutan +
                ')">';
            item_pembelian += '<i class="fas fa-plus"></i>';
            item_pembelian += '</button>';
            item_pembelian += '</td>';
            item_pembelian += '</tr>';

            if (style) {
                select2(key);
            }


            $('#tabel-potongan').append(item_pembelian);
            $('#faktur_id-' + key + '').val(faktur_id).attr('selected', true);

        }

        function select2(id) {
            $(function() {
                $('#faktur_id-' + id).select2({
                    theme: 'bootstrap4'
                });
            });
        }
    </script>

    <script>
        var activeSpecificationIndex = 0;

        function potonganmemo(param) {
            activeSpecificationIndex = param;
            // Show the modal and filter rows if necessary
            $('#tablePotongans').modal('show');
        }

        function getPotongan(rowIndex) {
            var selectedRow = $('#tables tbody tr:eq(' + rowIndex + ')');
            var Potongan_id = selectedRow.data('id');
            var KodePotongan = selectedRow.data('kode_nota');
            var TanggalAwal = selectedRow.data('tanggal_awal');
            var GrandTotal = selectedRow.data('grand_total');

            // Update the form fields for the active specification
            $('#nota_return_id-' + activeSpecificationIndex).val(Potongan_id);
            $('#kode_potongan-' + activeSpecificationIndex).val(KodePotongan);
            $('#keterangan_potongan-' + activeSpecificationIndex).val(TanggalAwal);
            $('#nominal_potongan-' + activeSpecificationIndex).val(GrandTotal.toLocaleString('id-ID'));

            // var formattedNominal = parseFloat(Nominal).toLocaleString('id-ID');
            // document.getElementById('nominal_potongan-').value = formattedNominal;

            $('#tablePotongans').modal('hide');
            updateGrandTotalreturn();
            updateSubTotalsxx();
            updateSubTotal();
        }
    </script>

    <script>
        var data_pembelian = @json(session('data_pembelians3'));
        var jumlah_ban = 1;

        if (data_pembelian != null) {
            jumlah_ban = data_pembelian.length;
            $('#tabel-pembelianlain').empty();
            var urutan = 0;
            $.each(data_pembelian, function(key, value) {
                urutan = urutan + 1;
                itemPembelians(urutan, key, value);
            });
        }

        function addTambahan() {
            jumlah_ban = jumlah_ban + 1;

            if (jumlah_ban === 1) {
                $('#tabel-pembelianlain').empty();
            }

            itemPembelians(jumlah_ban, jumlah_ban - 1);
        }

        function removeTambahan(params) {
            jumlah_ban = jumlah_ban - 1;

            var tabel_pesanan = document.getElementById('tabel-pembelianlain');
            var pembelian = document.getElementById('pembelianlain-' + params);

            tabel_pesanan.removeChild(pembelian);

            if (jumlah_ban === 0) {
                var item_pembelian = '<tr>';
                item_pembelian += '<td class="text-center" colspan="5">- Potongan belum ditambahkan -</td>';
                item_pembelian += '</tr>';
                $('#tabel-pembelianlain').html(item_pembelian);
            } else {
                var urutan = document.querySelectorAll('#urutanlain');
                for (let i = 0; i < urutan.length; i++) {
                    urutan[i].innerText = i + 1;
                }
            }
            updateGrandTotallain();
            updateSubTotalsxx();
            updateSubTotal();
        }

        function itemPembelians(urutan, key, value = null) {
            var potongan_penjualan_id = '';
            var kode_potonganlain = '';
            var keterangan_potonganlain = '';
            var nominallain = '';

            if (value !== null) {
                potongan_penjualan_id = value.potongan_penjualan_id;
                kode_potonganlain = value.kode_potonganlain;
                keterangan_potonganlain = value.keterangan_potonganlain;
                nominallain = value.nominallain;

            }

            // urutan 
            var item_pembelian = '<tr id="pembelianlain-' + urutan + '">';
            item_pembelian += '<td style="width: 70px; font-size:14px" class="text-center" id="urutanlain-' + urutan +
                '">' +
                urutan + '</td>';

            // potongan_penjualan_id 
            item_pembelian += '<td hidden>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" id="potongan_penjualan_id-' + urutan +
                '" name="potongan_penjualan_id[]" value="' + potongan_penjualan_id + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // kode_potonganlain 
            item_pembelian += '<td onclick="biayatambah(' + urutan +
                ')">';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control" readonly style="font-size:14px" id="kode_potonganlain-' +
                urutan +
                '" name="kode_potonganlain[]" value="' + kode_potonganlain + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // keterangan_potonganlain 
            item_pembelian += '<td onclick="biayatambah(' + urutan +
                ')">';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control" readonly style="font-size:14px" id="keterangan_potonganlain-' +
                urutan +
                '" name="keterangan_potonganlain[]" value="' + keterangan_potonganlain + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // nominallain 
            item_pembelian += '<td onclick="biayatambah(' + urutan +
                ')">';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control" style="font-size:14px" readonly id="nominallain-' +
                urutan +
                '" name="nominallain[]" value="' + nominallain + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            item_pembelian += '<td style="width: 100px">';
            item_pembelian +=
                '<button type="button" style="margin-left:5px" class="btn btn-danger btn-sm" onclick="removeTambahan(' +
                urutan + ')">';
            item_pembelian += '<i class="fas fa-trash"></i>';
            item_pembelian += '</button>';
            item_pembelian +=
                '<button style="margin-left:3px" type="button" class="btn btn-primary btn-sm" onclick="biayatambah(' +
                urutan +
                ')">';
            item_pembelian += '<i class="fas fa-plus"></i>';
            item_pembelian += '</button>';
            item_pembelian += '</td>';
            item_pembelian += '</tr>';

            $('#tabel-pembelianlain').append(item_pembelian);
        }
    </script>

    <script>
        var activeSpecificationIndex = 0;

        function biayatambah(param) {
            activeSpecificationIndex = param;
            // Show the modal and filter rows if necessary
            $('#tableBiaya').modal('show');
        }

        function getBiaya(rowIndex) {
            var selectedRow = $('#datatables66 tbody tr:eq(' + rowIndex + ')');
            var PotonganId = selectedRow.data('id');
            var KodeBiaya = selectedRow.data('kode_potongan');
            var NamabIaya = selectedRow.data('keterangan');
            var Nominal = selectedRow.data('grand_total');
            var kategori = $('#kategori').val(); // Get the value of the 'kategori' select element

            // Update the form fields for the active specification
            $('#potongan_penjualan_id-' + activeSpecificationIndex).val(PotonganId);
            $('#kode_potonganlain-' + activeSpecificationIndex).val(KodeBiaya);
            $('#keterangan_potonganlain-' + activeSpecificationIndex).val(NamabIaya);
            $('#nominallain-' + activeSpecificationIndex).val(Nominal.toLocaleString('id-ID'));

            // var formattedNominal = parseFloat(Nominal).toLocaleString('id-ID');
            // // Assuming 'biaya_tambahan' is an input element
            // document.getElementById('nominal').value = formattedNominal;
            // document.getElementById('harga_tambahan').value = formattedNominal;
            // document.getElementById('harga_tambahanborong').value = formattedNominal;

            $('#tableBiaya').modal('hide');

            updateGrandTotallain();
            updateSubTotalsxx();
            updateSubTotal();
        }
    </script>


    <script>
        function updateGrandTotalreturn() {
            var grandTotal = 0;

            // Loop through all elements with name "nominal_tambahan[]"
            $('input[name^="nominal_potongan"]').each(function() {
                var nominalValue = parseFloat($(this).val().replace(/\./g, '')) || 0; // Remove dots
                grandTotal += nominalValue;
            });

            $('#ongkosBongkar').val(formatRupiah(grandTotal));

        }

        $('body').on('input', 'input[name^="nominal_potongan"]', function() {
            updateGrandTotalreturn();
        });

        // Panggil fungsi saat halaman dimuat untuk menginisialisasi grand total
        $(document).ready(function() {
            updateGrandTotalreturn();
        });

        function formatRupiah(number) {
            var formatted = new Intl.NumberFormat('id-ID', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(number);
            return '' + formatted;
        }
    </script>

    <script>
        function updateGrandTotallain() {
            var grandTotal = 0;

            // Loop through all elements with name "nominal_tambahan[]"
            $('input[name^="nominallain"]').each(function() {
                var nominalValue = parseFloat($(this).val().replace(/\./g, '')) || 0; // Remove dots
                grandTotal += nominalValue;
            });

            $('#tambahan_pembayaran').val(formatRupiah(grandTotal));

        }

        $('body').on('input', 'input[name^="nominallain"]', function() {
            updateGrandTotallain();
        });

        // Panggil fungsi saat halaman dimuat untuk menginisialisasi grand total
        $(document).ready(function() {
            updateGrandTotallain();
        });

        function formatRupiah(number) {
            var formatted = new Intl.NumberFormat('id-ID', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(number);
            return '' + formatted;
        }
    </script>

    <script>
        function toggleLabels() {
            var kategori = document.getElementById('kategori');
            var bgLabel = document.getElementById('bg');
            var transLabel = document.getElementById('trans');
            var tunLabel = document.getElementById('tun');
            var Nomor = document.getElementById('nomor');

            if (kategori.value === 'Bilyet Giro') {
                bgLabel.style.display = 'block';
                transLabel.style.display = 'none';
                tunLabel.style.display = 'none';
                Nomor.style.display = 'block';
            } else if (kategori.value === 'Transfer') {
                bgLabel.style.display = 'none';
                transLabel.style.display = 'block';
                tunLabel.style.display = 'none';
                Nomor.style.display = 'block';
            } else if (kategori.value === 'Tunai') {
                bgLabel.style.display = 'none';
                transLabel.style.display = 'none';
                tunLabel.style.display = 'none';
                Nomor.style.display = 'none';
            }
        }

        toggleLabels();
        document.getElementById('kategori').addEventListener('change', toggleLabels);
    </script>

    <script>
        // fungsi total harga memo perjalanan 
        function updateSubTotalsxx() {
            var Uangjalans = $('#totalpembayaran').val().replace(/\./g, '').replace(',', '.') || '0';
            var HargaTambahan = $('#ongkosBongkar').val().replace(/\./g, '').replace(',', '.') || '0';
            var DepositDriv = $('#tambahan_pembayaran').val().replace(/\./g, '').replace(',', '.') || '0';

            Uangjalans = parseFloat(Uangjalans) || 0;

            console.log(Uangjalans);
            console.log(HargaTambahan);
            console.log(DepositDriv);
            // Menghitung sub total (1% dari UangJaminan)
            var Hasil = Uangjalans - HargaTambahan - DepositDriv;


            // Menetapkan nilai ke input uang_jaminan
            $('#totalPembayarans').val(formatRupiah(Hasil));

        }

        function parseCurrency(value) {
            return parseFloat(value.replace(/[^\d.-]/g, '')) || 0;
        }
    </script>

    <script>
        // Fungsi untuk menangani perubahan nilai pada input nominal
        $('#nominal').on('input', function() {
            // Mengambil nilai input nominal
            var nominalValue = $(this).val();

            // Memeriksa apakah input nominal kosong atau tidak
            if (nominalValue === "") {
                // Jika kosong, set form saldo masuk dan sub total menjadi 0
                $('#saldo_masuk').val("0,00");
                updateSubTotal(); // Memanggil fungsi updateSubTotal tanpa argumen
            } else {
                // Mengonversi nilai ke format rupiah
                var saldoMasukValue = formatRupiah(nominalValue);

                // Menetapkan nilai ke input saldo masuk
                $('#saldo_masuk').val(saldoMasukValue);

                // Memperbarui nilai sub total saat input nominal berubah
                updateSubTotal();
            }
        });

        function updateSubTotal() {
            // Mengambil nilai saldo masuk dan sisa saldo
            var saldoMasuk = parseCurrency($('#saldo_masuk').val());
            var sisaSaldo = parseCurrency($('#totalPembayarans').val());

            // Menghitung sub total
            var subTotal = sisaSaldo - saldoMasuk;

            // Mengonversi nilai sub total ke format rupiah
            var subTotalRupiah = subTotal.toLocaleString('id-ID', {
                minimumFractionDigits: 2
            });

            // Menetapkan nilai ke input sub total
            $('#hasilselisih').val("Rp " + subTotalRupiah);
        }

        // Fungsi untuk mengubah format uang ke angka
        function parseCurrency(value) {
            // Hilangkan semua karakter kecuali digit dan koma
            var cleanedValue = value.replace(/[^\d,]/g, '');
            // Ubah koma menjadi titik untuk memisahkan desimal
            cleanedValue = cleanedValue.replace(',', '.');
            // Ubah menjadi tipe data float
            return parseFloat(cleanedValue);
        }
    </script>

    <script>
        $(document).ready(function() {
            // Detect the change event on the 'status' dropdown
            $('#kategori').on('change', function() {
                // Get the selected value
                var selectedValue = $(this).val();

                // Check the selected value and redirect accordingly
                switch (selectedValue) {
                    case 'pelunasan1':
                        window.location.href = "{{ url('admin/faktur_pelunasanperfaktur') }}";
                        break;
                        // case 'pelunasan2':
                        //     window.location.href = "{{ url('admin/faktur_pelunasanperinvoice') }}";
                        //     break;
                    case 'pelunasan3':
                        window.location.href = "{{ url('admin/faktur_pelunasan') }}";
                        break;
                    default:
                        // Handle other cases or do nothing
                        break;
                }
            });
        });
    </script>

@endsection
