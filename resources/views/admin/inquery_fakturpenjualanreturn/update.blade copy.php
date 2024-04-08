@extends('layouts.app')

@section('title', ' Inquery Faktur Penjualan Return')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"> Inquery Faktur Penjualan Return</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/inquery_fakturpenjualanreturn') }}"> Faktur
                                Penjualan Return</a>
                        </li>
                        <li class="breadcrumb-item active">Perbarui</li>
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
            <form action="{{ url('admin/inquery_fakturpenjualanreturn/' . $inquery->id) }}" method="POST"
                enctype="multipart/form-data" autocomplete="off">
                @method('put')
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Perbarui Penjualan Return Ekspedisi</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <label style="font-size:14px" class="form-label" for="kode_nota">Kode Nota Return
                            Barang</label>
                        <div class="form-group d-flex">
                            <input class="form-control" hidden id="return_id" name="nota_return_id" type="text"
                                placeholder="" value="{{ old('nota_return_id', $inquery->nota_return_id) }}" readonly
                                style="margin-right: 10px; font-size:14px" />
                            <input class="form-control" id="kode_nota" name="kode_nota" type="text" placeholder=""
                                value="{{ old('kode_nota', $inquery->kode_nota) }}" readonly
                                style="margin-right: 10px; font-size:14px" />
                            <button class="btn btn-primary" type="button" onclick="showCategoryModalPelanggan(this.value)">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div>
                    <div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Pelanggan</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group" hidden>
                                            <label for="pelanggan_id">return Id</label>
                                            <input type="text" class="form-control" id="pelanggan_id" readonly
                                                name="pelanggan_id" placeholder=""
                                                value="{{ old('pelanggan_id', $inquery->pelanggan_id) }}">
                                        </div>
                                        <div class="form-group">
                                            <label style="font-size:14px" for="kode_pelanggan">Kode Pelanggan</label>
                                            <input style="font-size:14px" type="text" class="form-control"
                                                id="kode_pelanggan" readonly name="kode_pelanggan" placeholder=""
                                                value="{{ old('kode_pelanggan', $inquery->kode_pelanggan) }}">
                                        </div>
                                        <div class="form-group">
                                            <label style="font-size:14px" for="nama_pelanggan">Nama Pelanggan</label>
                                            <input style="font-size:14px" type="text" class="form-control"
                                                id="nama_pelanggan" readonly name="nama_pelanggan" placeholder=""
                                                value="{{ old('nama_pelanggan', $inquery->nama_pelanggan) }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <div class="form-group">
                                                <label style="font-size:14px" for="alamat_pelanggan">Alamat
                                                    return</label>
                                                <input style="font-size:14px" type="text" class="form-control"
                                                    id="alamat_pelanggan" readonly name="alamat_pelanggan" placeholder=""
                                                    value="{{ old('alamat_pelanggan', $inquery->alamat_pelanggan) }}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label style="font-size:14px" for="telp_pelanggan">No. Telp</label>
                                                <input style="font-size:14px" type="text" class="form-control"
                                                    id="telp_pelanggan" readonly name="telp_pelanggan" placeholder=""
                                                    value="{{ old('telp_pelanggan', $inquery->telp_pelanggan) }}">
                                            </div>
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
                                        <h3 class="card-title">Kendaraan</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group" hidden>
                                            <label for="kendaraan_id">Kendaraan Id</label>
                                            <input type="text" class="form-control" id="kendaraan_id" readonly
                                                name="kendaraan_id" placeholder=""
                                                value="{{ old('kendaraan_id', $inquery->kendaraan_id) }}">
                                        </div>
                                        <div class="form-group">
                                            <label style="font-size:14px" for="no_kabin">No. Kabin</label>
                                            <input style="font-size:14px" type="text" class="form-control"
                                                id="no_kabin" readonly name="no_kabin" placeholder=""
                                                value="{{ old('no_kabin', $inquery->no_kabin) }}">
                                        </div>
                                        <div class="form-group">
                                            <label style="font-size:14px" for="no_pol">No. Mobil</label>
                                            <input style="font-size:14px" type="text" class="form-control"
                                                id="no_pol" readonly name="no_pol" placeholder=""
                                                value="{{ old('no_pol', $inquery->no_pol) }}">
                                        </div>
                                        <div class="form-group">
                                            <label style="font-size:14px" for="jenis_kendaraan">Jenis Kendaraan</label>
                                            <input style="font-size:14px" type="text" class="form-control"
                                                id="jenis_kendaraan" readonly name="jenis_kendaraan" placeholder=""
                                                value="{{ old('jenis_kendaraan', $inquery->jenis_kendaraan) }}">
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
                                        <div class="form-group">
                                            <label style="font-size:14px" for="kode_driver">Kode Sopir</label>
                                            <input style="font-size:14px" type="text" class="form-control"
                                                id="kode_driver" readonly name="kode_driver" placeholder=""
                                                value="{{ old('kode_driver', $inquery->kode_driver) }}">
                                        </div>
                                        <div class="form-group">
                                            <label style="font-size:14px" for="nama_driver">Nama Sopir</label>
                                            <input style="font-size:14px" type="text" class="form-control"
                                                id="nama_driver" readonly name="nama_driver" placeholder=""
                                                value="{{ old('nama_driver', $inquery->nama_driver) }}">
                                        </div>
                                        <div class="form-group">
                                            <label style="font-size:14px" for="telp">No. Telp</label>
                                            <input style="font-size:14px" type="tex" class="form-control"
                                                id="telp" readonly name="telp" placeholder=""
                                                value="{{ old('telp', $inquery->telp) }}">
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
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Barang <span>
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
                                    <th style="font-size:14px">Kode Barang</th>
                                    <th style="font-size:14px">Nama Barang</th>
                                    <th style="font-size:14px">Satuan</th>
                                    <th style="font-size:14px">Harga Beli</th>
                                    <th style="font-size:14px">Harga Jual</th>
                                    <th style="font-size:14px">Jumlah</th>
                                    <th style="font-size:14px">Diskon</th>
                                    <th style="font-size:14px">Total</th>
                                    <th style="font-size:14px; text-align:center">Opsi</th>
                                </tr>
                            </thead>
                            <tbody id="tabel-pembelian">
                                @foreach ($details as $detail)
                                    <tr id="pembelian-{{ $loop->index }}">
                                        <td style="width: 70px; font-size:14px" class="text-center" id="urutan">
                                            {{ $loop->index + 1 }}
                                        </td>
                                        <div class="form-group" hidden>
                                            <input type="text" class="form-control"
                                                id="nomor_seri-{{ $loop->index }}" name="detail_ids[]"
                                                value="{{ $detail['id'] }}">
                                        </div>
                                        <td hidden>
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="barang_id-0"
                                                    name="barang_id[]" value="{{ $detail['barang_id'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input style="font-size:14px" readonly type="text"
                                                    class="form-control" id="kode_barang-{{ $loop->index }}"
                                                    name="kode_barang[]" value="{{ $detail['kode_barang'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input style="font-size:14px" readonly type="text"
                                                    class="form-control" id="nama_barang-{{ $loop->index }}"
                                                    name="nama_barang[]" value="{{ $detail['nama_barang'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <select style="font-size:14px" class="form-control" id="satuan-0"
                                                    name="satuan[]">
                                                    <option value="">- Pilih -</option>
                                                    <option value="pcs"
                                                        {{ old('satuan', $detail['satuan']) == 'pcs' ? 'selected' : null }}>
                                                        pcs</option>
                                                    <option value="ltr"
                                                        {{ old('satuan', $detail['satuan']) == 'ltr' ? 'selected' : null }}>
                                                        ltr</option>
                                                    <option value="ton"
                                                        {{ old('satuan', $detail['satuan']) == 'ton' ? 'selected' : null }}>
                                                        ton</option>
                                                    <option value="dus"
                                                        {{ old('satuan', $detail['satuan']) == 'dus' ? 'selected' : null }}>
                                                        dus</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input style="font-size:14px" type="number" readonly
                                                    class="form-control harga_beli" id="harga_beli-{{ $loop->index }}"
                                                    name="harga_beli[]" value="{{ $detail['harga_beli'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input style="font-size:14px" type="number"
                                                    class="form-control harga_jual" id="harga_jual-{{ $loop->index }}"
                                                    name="harga_jual[]"value="{{ $detail['harga_jual'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input style="font-size:14px" type="number" class="form-control jumlah"
                                                    id="jumlah-{{ $loop->index }}" name="jumlah[]"
                                                    value="{{ $detail['jumlah'] }}">
                                            </div>
                                        </td>

                                        <td>
                                            <div class="form-group">
                                                <input style="font-size:14px" type="text" class="form-control diskon"
                                                    id="diskon-{{ $loop->index }}" name="diskon[]"
                                                    value="{{ $detail['diskon'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input style="font-size:14px;" type="number" readonly
                                                    class="form-control total" id="total-{{ $loop->index }}"
                                                    name="total[]" value="{{ $detail['total'] }}">
                                            </div>
                                        </td>
                                        <td style="width: 100px">
                                            <button type="button" class="btn btn-primary btn-sm"
                                                onclick="Barangs({{ $loop->index }})">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                            <button style="margin-left:5px" type="button" class="btn btn-danger btn-sm"
                                                onclick="removeBan({{ $loop->index }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div>
                    <div>
                        <div class="card">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="font-size:14px">keterangan</th>
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
                                                <input style="text-align: end; margin:right:10px; font-size:14px;"
                                                    type="number" class="form-control grand_total" id="grand_total"
                                                    name="grand_total" placeholder=""
                                                    value="{{ old('grand_total', $inquery->grand_total) }}">
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="card-footer text-right">
                                <button type="reset" class="btn btn-secondary">Reset</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="modal fade" id="tableBarang" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Barang</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="float-right ml-3 mt-3">
                        <button type="button" data-toggle="modal" data-target="#modal-barang"
                            class="btn btn-primary btn-sm">
                            Tambah
                        </button>
                    </div>
                    <div class="modal-body">
                        <table id="datatables66" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Harga Beli</th>
                                    <th>Harga Jual</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($barangs as $barang)
                                    <tr data-id="{{ $barang->id }}" data-kode_barang="{{ $barang->kode_barang }}"
                                        data-nama_barang="{{ $barang->nama_barang }}"
                                        data-harga_beli="{{ $barang->harga_beli }}"
                                        data-harga_jual="{{ $barang->harga_beli }}" data-param="{{ $loop->index }}">
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $barang->kode_barang }}</td>
                                        <td>{{ $barang->nama_barang }}</td>
                                        <td>{{ $barang->harga_beli }}</td>
                                        <td>{{ $barang->harga_jual }}</td>
                                        <td class="text-center">
                                            <button type="button" id="btnTambah" class="btn btn-primary btn-sm"
                                                onclick="getBarang({{ $loop->index }})">
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

        <div class="modal fade" id="modal-barang">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Barang Return</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div style="text-align: center;">
                            <form action="{{ url('admin/tambah_barang') }}" method="POST" enctype="multipart/form-data"
                                autocomplete="off">
                                @csrf
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Tambah Barang Return</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="nama_barang">Nama Barang Return</label>
                                            <input type="text" class="form-control" id="nama_barang"
                                                name="nama_barang" placeholder="masukkan nama barang"
                                                value="{{ old('nama_barang') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="jumlah">Stok</label>
                                            <input type="number" class="form-control" id="jumlah" name="jumlah"
                                                placeholder="masukkan stok" value="{{ old('jumlah') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="harga_beli">Harga Beli</label>
                                            <input type="number" class="form-control" id="harga_beli" name="harga_beli"
                                                placeholder="masukkan harga beli" value="{{ old('harga_beli') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="harga_jual">Harga Jual</label>
                                            <input type="number" class="form-control" id="harga_jual" name="harga_jual"
                                                placeholder="masukkan harga jual" value="{{ old('harga_jual') }}">
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button type="reset" class="btn btn-secondary">Reset</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="tableReturn" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Nota Return</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table id="datatables4" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Kode Nota Return</th>
                                    <th>Tanggal</th>
                                    <th>Pelanggan</th>
                                    <th>No Kabin</th>
                                    <th>Sopir</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($notas as $nota)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $nota->kode_nota }}</td>
                                        <td>{{ $nota->tanggal }}</td>
                                        <td>{{ $nota->nama_pelanggan }}</td>
                                        <td>{{ $nota->no_kabin }}</td>
                                        <td>{{ $nota->nama_driver }}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-primary btn-sm"
                                                onclick="GetNota(
                                                '{{ $nota->id }}',
                                                '{{ $nota->kode_nota }}',
                                                '{{ $nota->pelanggan_id }}',
                                                '{{ $nota->kode_pelanggan }}',
                                                '{{ $nota->nama_pelanggan }}',
                                                '{{ $nota->telp_pelanggan }}',
                                                '{{ $nota->alamat_pelanggan }}',
                                                '{{ $nota->kendaraan_id }}',
                                                '{{ $nota->no_kabin }}',
                                                '{{ $nota->no_pol }}',
                                                '{{ $nota->jenis_kendaraan }}',
                                                '{{ $nota->user_id }}',
                                                '{{ $nota->kode_driver }}',
                                                '{{ $nota->nama_driver }}',
                                                '{{ $nota->telp }}',
                                                '{{ $nota->detail_nota->pluck('barang_id')->implode(', ') }}',
                                                '{{ $nota->detail_nota->pluck('kode_barang')->implode(', ') }}',
                                                '{{ $nota->detail_nota->pluck('nama_barang')->implode(', ') }}',
                                                '{{ $nota->detail_nota->pluck('satuan')->implode(', ') }}',
                                                '{{ $nota->detail_nota->pluck('jumlah')->implode(', ') }}'
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
    </section>

    <script>
        function showCategoryModalPelanggan(selectedCategory) {
            $('#tableReturn').modal('show');
        }

        function GetNota(Return_id, KodeReturn, Pelanggan_id, KodePelanggan, NamaPell, Telpel, AlamatPelanggan,
            Kendaraan_id, Nokabin,
            Nopol, JenisKen, User_id, KodeDriv, NamaDriv, Telpdriv, Barang_id, KodeBarang, NamaBarang, Satuan, Jumlah) {

            document.getElementById('return_id').value = Return_id;
            document.getElementById('kode_nota').value = KodeReturn;
            document.getElementById('pelanggan_id').value = Pelanggan_id;
            document.getElementById('kode_pelanggan').value = KodePelanggan;
            document.getElementById('nama_pelanggan').value = NamaPell;
            document.getElementById('telp_pelanggan').value = Telpel;
            document.getElementById('alamat_pelanggan').value = AlamatPelanggan;
            document.getElementById('kendaraan_id').value = Kendaraan_id;
            document.getElementById('no_kabin').value = Nokabin;
            document.getElementById('no_pol').value = Nopol;
            document.getElementById('jenis_kendaraan').value = JenisKen;
            document.getElementById('user_id').value = User_id;
            document.getElementById('kode_driver').value = KodeDriv;
            document.getElementById('nama_driver').value = NamaDriv;
            document.getElementById('telp').value = Telpdriv;

            $('#tableReturn').modal('hide');

        }
        var activeSpecificationIndexs = 0;


        // function Satuan(param) {
        //     activeSpecificationIndexs = param;
        //     // Show the modal and filter rows if necessary
        //     $('#tableSatuan').modal('show');
        // }

        // function getSatuan(rowIndex) {
        //     var selectedRow = $('#datatables6 tbody tr:eq(' + rowIndex + ')');
        //     var satuan_id = selectedRow.data('id');
        //     var kode_satuan = selectedRow.data('kode_satuan');
        //     var nama_satuan = selectedRow.data('nama_satuan');
        //     var nominal = selectedRow.data('nominal');

        //     // Update the form fields for the active specification
        //     $('#satuan_id-' + activeSpecificationIndexs).val(satuan_id);
        //     $('#kode_satuan-' + activeSpecificationIndexs).val(kode_satuan);
        //     $('#nama_satuan-' + activeSpecificationIndexs).val(nama_satuan);
        //     $('#harga_jual-' + activeSpecificationIndexs).val(nominal);
        //     // Check if the diskon field is empty
        //     var diskonValue = $('#diskon-' + activeSpecificationIndexs).val();
        //     if (!diskonValue) {
        //         // If empty, set the diskon field to 0
        //         $('#diskon-' + activeSpecificationIndexs).val(0);
        //     }

        //     $('#tableSatuan').modal('hide');
        // }
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

        function updateUrutan() {
            var urutan = document.querySelectorAll('#urutan');
            for (let i = 0; i < urutan.length; i++) {
                urutan[i].innerText = i + 1;
            }
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
            updateUrutan();
        }

        function removeBan(identifier, detailId) {
            var row = document.getElementById('pembelian-' + identifier);
            row.remove();

            $.ajax({
                url: "{{ url('admin/ban/') }}/" + detailId,
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

            updateUrutan();
        }

        function itemPembelian(identifier, key, value = null) {
            var barang_id = '';
            var kode_barang = '';
            var nama_barang = '';
            var satuan = '';
            var harga_beli = '';
            var harga_jual = '';
            var jumlah = '';
            var diskon = '';
            var total = '';

            if (value !== null) {
                barang_id = value.barang_id;
                kode_barang = value.kode_barang;
                nama_barang = value.nama_barang;
                satuan = value.satuan;
                harga_beli = value.harga_beli;
                harga_jual = value.harga_jual;
                jumlah = value.jumlah;
                diskon = value.diskon;
                total = value.total;
            }

            // urutan 
            var item_pembelian = '<tr id="pembelian-' + key + '">';
            item_pembelian += '<td style="width: 70px; font-size:14px" class="text-center"  id="urutan">' + key + '</td>';

            // barang_id 
            item_pembelian += '<td hidden>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" id="barang_id-' + key +
                '" name="barang_id[]" value="' + barang_id + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // kode_barang 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" style="font-size:14px" readonly id="kode_barang-' +
                key +
                '" name="kode_barang[]" value="' + kode_barang + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // nama_barang 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" style="font-size:14px" readonly id="nama_barang-' +
                key +
                '" name="nama_barang[]" value="' + nama_barang + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // satuan
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">';
            item_pembelian += '<select style="font-size:14px" class="form-control" id="satuan-' + key +
                '" name="satuan[]">';
            item_pembelian += '<option value="">- Pilih -</option>';
            item_pembelian += '<option value="pcs"' + (satuan === 'pcs' ? ' selected' : '') + '>pcs</option>';
            item_pembelian += '<option value="ltr"' + (satuan === 'ltr' ? ' selected' : '') +
                '>ltr</option>';
            item_pembelian += '<option value="ton"' + (satuan === 'ton' ? ' selected' : '') +
                '>ton</option>';
            item_pembelian += '<option value="dus"' + (satuan === 'dus' ? ' selected' : '') +
                '>dus</option>';
            item_pembelian += '</select>';
            item_pembelian += '</div>';
            item_pembelian += '</td>';


            // harga_beli 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control harga_beli" readonly style="font-size:14px"  id="harga_beli-' +
                key +
                '" name="harga_beli[]" value="' + harga_beli + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // harga_jual 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control harga_jual" style="font-size:14px"  id="harga_jual-' +
                key +
                '" name="harga_jual[]" value="' + harga_jual + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // jumlah 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control jumlah" style="font-size:14px"  id="jumlah-' +
                key +
                '" name="jumlah[]" value="' + jumlah + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // diskon 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control diskon" style="font-size:14px" id="diskon-' +
                key +
                '" name="diskon[]" value="' + diskon + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // total 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control total" readonly style="font-size:14px" id="total-' +
                key +
                '" name="total[]" value="' + total + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            item_pembelian += '<td style="width: 100px">';
            item_pembelian += '<button type="button" class="btn btn-primary btn-sm" onclick="Barangs(' + key +
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
        var activeSpecificationIndex = 0;

        function Barangs(param) {
            activeSpecificationIndex = param;
            // Show the modal and filter rows if necessary
            $('#tableBarang').modal('show');
        }

        function getBarang(rowIndex) {
            var selectedRow = $('#datatables66 tbody tr:eq(' + rowIndex + ')');
            var barang_id = selectedRow.data('id');
            var kode_barang = selectedRow.data('kode_barang');
            var nama_barang = selectedRow.data('nama_barang');
            var harga_beli = selectedRow.data('harga_beli');
            var harga_jual = selectedRow.data('harga_jual');

            // Update the form fields for the active specification
            $('#barang_id-' + activeSpecificationIndex).val(barang_id);
            $('#kode_barang-' + activeSpecificationIndex).val(kode_barang);
            $('#nama_barang-' + activeSpecificationIndex).val(nama_barang);
            $('#harga_beli-' + activeSpecificationIndex).val(harga_beli);
            $('#harga_jual-' + activeSpecificationIndex).val(harga_jual);
            $('#diskon-' + activeSpecificationIndex).val('0');
            $('#jumlah-' + activeSpecificationIndex).val('0');

            // updateGrandTotal()
            // Check if the diskon field is empty
            // Check if the diskon field is empty
            var diskonValue = $('#diskon-' + activeSpecificationIndex).val();
            if (!diskonValue) {
                // If empty, set the diskon field to 0
                $('#diskon-' + activeSpecificationIndex).val('0');
            }

            var diskonValues = $('#jumlah-' + activeSpecificationIndex).val();
            if (!diskonValues) {
                // If empty, set the diskon field to 0
                $('#jumlah-' + activeSpecificationIndex).val('0');
            }


            $('#tableBarang').modal('hide');
        }

        function Hitung(startingElement) {
            $(document).on("input", startingElement, function() {
                var currentRow = $(this).closest('tr');
                var jumlah = parseFloat(currentRow.find(".jumlah").val()) || 0;
                var hargasatuan = parseFloat(currentRow.find(".harga_jual").val()) || 0;
                var diskon = parseFloat(currentRow.find(".diskon").val()) || 0;
                var harga_jual = hargasatuan * jumlah - diskon;
                currentRow.find(".total").val(harga_jual);

                updateGrandTotal();
            });
        }

        function updateGrandTotal() {
            var grandTotal = 0;

            $('input[name^="total"]').each(function() {
                var nominalValue = parseFloat($(this).val()) || 0;
                grandTotal += nominalValue;
            });

            // Set the grand total without using toLocaleString
            $('#grand_total').val(grandTotal);
        }

        $(document).ready(function() {
            Hitung(".jumlah");
            Hitung(".harga_jual");
            Hitung(".diskon");
            updateGrandTotal();
        });
    </script>

@endsection
