@extends('layouts.app')

@section('title', 'Pembelian Part')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Pembelian Part</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/pembelian_part') }}">Transaksi</a></li>
                        <li class="breadcrumb-item active">Pembelian part</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
        <div class="container-fluid">
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
            @if (session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-check"></i> Success!
                    </h5>
                    {{ session('success') }}
                </div>
            @endif
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
            <form action="{{ url('admin/pembelian_part') }}" method="post" autocomplete="off">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Detail Supplier</h3>
                        <div class="float-right">
                            <button type="button" data-toggle="modal" data-target="#modal-supplier"
                                class="btn btn-primary btn-sm">
                                Tambah
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group" style="flex: 8;">
                            <label for="supplier_id">Nama Supplier</label>
                            <select class="select2bs4 select2-hidden-accessible" name="supplier_id"
                                data-placeholder="Cari Supplier.." style="width: 100%;" data-select2-id="23" tabindex="-1"
                                aria-hidden="true" id="supplier_id" onchange="getData(0)">
                                <option value="">- Pilih -</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}"
                                        {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->nama_supp }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea type="text" class="form-control" readonly id="alamat" name="alamat" placeholder="Masukan alamat">{{ old('alamat') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Part</h3>
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
                                    <th class="text-center">No</th>
                                    <th>Kategori</th>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Satuan</th>
                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody id="tabel-pembelian">
                                <tr id="pembelian-0">
                                    <td class="text-center" id="urutan">1</td>
                                    <td style="width: 240px">
                                        <div class="form-group">
                                            <select class="form-control" id="kategori-0" name="kategori[]"
                                                onchange="getModalKategori(0)">
                                                <option value="">- Kategori -</option>
                                                <option value="oli" {{ old('kategori') == 'oli' ? 'selected' : null }}>
                                                    oli</option>
                                                <option value="mesin"
                                                    {{ old('kategori') == 'mesin' ? 'selected' : null }}>
                                                    mesin</option>
                                                <option value="body" {{ old('body') == 'body' ? 'selected' : null }}>
                                                    body</option>
                                                <option value="sasis"
                                                    {{ old('kategori') == 'sasis' ? 'selected' : null }}>
                                                    sasis</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" class="form-control" readonly id="kode_partdetail-0"
                                                name="kode_partdetail[]">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" class="form-control" readonly id="nama_barang-0"
                                                name="nama_barang[]">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" class="form-control" readonly id="satuan-0"
                                                name="satuan[]">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="number" class="form-control" id="jumlah-0" name="jumlah[]">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="number" class="form-control" id="harga-0" name="harga[]">
                                        </div>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger" onclick="removeBan(0)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="reset" class="btn btn-secondary">Reset</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>

        <div class="modal fade" id="modal-supplier">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Supplier</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div style="text-align: center;">
                            <form action="{{ url('admin/tambah_supplier') }}" method="POST"
                                enctype="multipart/form-data" autocomplete="off">
                                @csrf
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Tambah Supplier</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="nama">Nama Supplier</label>
                                            <input type="text" class="form-control" id="nama_supp" name="nama_supp"
                                                placeholder="Masukan nama supplier" value="{{ old('nama_supp') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="alamat">Alamat</label>
                                            <textarea type="text" class="form-control" id="alamat" name="alamat" placeholder="Masukan alamat">{{ old('alamat') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                {{-- div diatas ini --}}

                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Kotak Person</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="nama">Nama</label>
                                            <input type="text" class="form-control" id="nama_person"
                                                name="nama_person" placeholder="Masukan nama"
                                                value="{{ old('nama_person') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="nama">Jabatan</label>
                                            <input type="text" class="form-control" id="jabatan" name="jabatan"
                                                placeholder="Masukan jabatan" value="{{ old('jabatan') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="nama">No. Telepon</label>
                                            <input type="number" class="form-control" id="telp" name="telp"
                                                placeholder="Masukan no telepon" value="{{ old('telp') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="nama">Fax</label>
                                            <input type="number" class="form-control" id="fax" name="fax"
                                                placeholder="Masukan no fax" value="{{ old('fax') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="telp">Hp</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">+62</span>
                                                </div>
                                                <input type="number" id="hp" name="hp" class="form-control"
                                                    placeholder="Masukan nomor hp" value="{{ old('hp') }}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="nama">Email</label>
                                            <input type="text" class="form-control" id="email" name="email"
                                                placeholder="Masukan email" value="{{ old('email') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="nama">No. NPWP</label>
                                            <input type="text" class="form-control" id="npwp" name="npwp"
                                                placeholder="Masukan no npwp" value="{{ old('npwp') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Informasi Bank</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label" for="nama_bank">Nama Bank</label>
                                            <select class="form-control" id="nama_bank" name="nama_bank">
                                                <option value="">- Pilih -</option>
                                                <option value="bri"
                                                    {{ old('nama_bank') == 'bri' ? 'selected' : null }}>
                                                    BRI</option>
                                                <option value="mandiri"
                                                    {{ old('nama_bank') == 'mandiri' ? 'selected' : null }}>
                                                    MANDIRI</option>
                                                <option value="bni"
                                                    {{ old('nama_bank') == 'bni' ? 'selected' : null }}>
                                                    BNI</option>
                                                <option value="bni"
                                                    {{ old('nama_bank') == 'bni' ? 'selected' : null }}>
                                                    BTN</option>
                                                <option value="btn"
                                                    {{ old('nama_bank') == 'btn' ? 'selected' : null }}>
                                                    DANAMON</option>
                                                <option value="danamon"
                                                    {{ old('nama_bank') == 'danamon' ? 'selected' : null }}>
                                                    PERMATA</option>
                                                <option value="permata"
                                                    {{ old('nama_bank') == 'permata' ? 'selected' : null }}>
                                                    BCA</option>
                                                <option value="maybank"
                                                    {{ old('nama_bank') == 'maybank' ? 'selected' : null }}>
                                                    MAYBANK</option>
                                                <option value="pan"
                                                    {{ old('nama_bank') == 'pan' ? 'selected' : null }}>
                                                    PAN</option>
                                                <option value="cimb_niaga"
                                                    {{ old('nama_bank') == 'cimb_niaga' ? 'selected' : null }}>
                                                    CIMB NIAGA</option>
                                                <option value="uob"
                                                    {{ old('nama_bank') == 'uob' ? 'selected' : null }}>
                                                    UOB</option>
                                                <option value="artha_graha"
                                                    {{ old('nama_bank') == 'artha_graha' ? 'selected' : null }}>
                                                    ARTHA GRAHA</option>
                                                <option value="bumi_artha"
                                                    {{ old('nama_bank') == 'bumi_artha' ? 'selected' : null }}>
                                                    BUMI ARTHA</option>
                                                <option value="mega"
                                                    {{ old('nama_bank') == 'mega' ? 'selected' : null }}>
                                                    MEGA</option>
                                                <option value="syariah"
                                                    {{ old('nama_bank') == 'syariah' ? 'selected' : null }}>
                                                    SYARIAH</option>
                                                <option value="mega_syariah"
                                                    {{ old('nama_bank') == 'mega_syariah' ? 'selected' : null }}>
                                                    MEGA SYARIAH</option>

                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="atas_nama">Atas nama</label>
                                            <input type="text" class="form-control" id="atas_nama" name="atas_nama"
                                                placeholder="Masukan atas nama" value="{{ old('atas_nama') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="norek">No. Rekening</label>
                                            <input type="number" class="form-control" id="norek" name="norek"
                                                placeholder="Masukan no rekening" value="{{ old('norek') }}">
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

        <div class="modal fade" id="modal-part">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Part</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div style="text-align: center;">
                            <form id="form-sparepart" action="{{ url('admin/tambah_sparepart') }}" method="POST"
                                enctype="multipart/form-data" autocomplete="off">
                                @csrf
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label class="form-label" for="kategori">Kategori</label>
                                            <select class="form-control" id="kategori" name="kategori">
                                                <option value="">- Pilih -</option>
                                                <option value="oli" {{ old('kategori') == 'oli' ? 'selected' : null }}>
                                                    oli</option>
                                                <option value="body"
                                                    {{ old('kategori') == 'body' ? 'selected' : null }}>
                                                    body</option>
                                                <option value="mesin"
                                                    {{ old('kategori') == 'mesin' ? 'selected' : null }}>
                                                    mesin</option>
                                                <option value="sasis"
                                                    {{ old('kategori') == 'sasis' ? 'selected' : null }}>
                                                    sasis</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="nama">Nama Barang</label>
                                            <input type="text" class="form-control" id="nama_barang"
                                                name="nama_barang" placeholder="Masukan nama pemilik" value="">
                                        </div>
                                        <div class="form-group">
                                            <label for="keterangan">Keterangan</label>
                                            <textarea type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Masukan keterangan">{{ old('keterangan') }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="nama">Harga</label>
                                            <input type="number" class="form-control" id="harga" name="harga"
                                                placeholder="Masukan harga" value="">
                                        </div>
                                        <div class="form-group">
                                            <label for="nama">Stok</label>
                                            <input type="number" class="form-control" id="jumlah" name="jumlah"
                                                placeholder="Tersedia" value="">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="satuan">Satuan</label>
                                            <select class="form-control" id="satuan" name="satuan">
                                                <option value="">- Pilih -</option>
                                                <option value="pcs" {{ old('satuan') == 'pcs' ? 'selected' : null }}>
                                                    pcs</option>
                                                <option value="ltr" {{ old('satuan') == 'ltr' ? 'selected' : null }}>
                                                    ltr</option>
                                                {{-- <option value="btl" {{ old('satuan') == 'btl' ? 'selected' : null }}>
                                    btl</option>
                                <option value="klng" {{ old('satuan') == 'klng' ? 'selected' : null }}>
                                    klng</option>
                                <option value="gln" {{ old('satuan') == 'gln' ? 'selected' : null }}>
                                    gln</option>
                                <option value="pack" {{ old('satuan') == 'pack' ? 'selected' : null }}>
                                    pack</option>
                                <option value="tgg" {{ old('satuan') == 'tgg' ? 'selected' : null }}>
                                    tgg</option>
                                <option value="set" {{ old('satuan') == 'set' ? 'selected' : null }}>
                                    set</option>
                                <option value="dus" {{ old('satuan') == 'dus' ? 'selected' : null }}>
                                    dus</option>
                                <option value="role" {{ old('satuan') == 'role' ? 'selected' : null }}>
                                    role</option>
                                <option value="pail" {{ old('satuan') == 'pail' ? 'selected' : null }}>
                                    pail</option>
                                <option value="kg" {{ old('satuan') == 'kg' ? 'selected' : null }}>
                                    kg</option> --}}
                                            </select>
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

        <div class="modal fade" id="tableKategori" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Part</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="float-right">
                            <button type="button" data-toggle="modal" data-target="#modal-part"
                                class="btn btn-primary btn-sm mb-3" data-dismiss="modal">
                                Tambah
                            </button>
                        </div>
                        {{-- <button type="button" data-toggle="modal" data-target="#modal-part"
                            class="btn btn-primary btn-sm mb-2" data-dismiss="modal">
                            Tambah
                        </button> --}}
                        <table id="example" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Stok</th>
                                    <th>Satuan</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($spareparts as $part)
                                    <tr data-kategori="{{ $part->kategori }}" data-kode="{{ $part->kode_partdetail }}"
                                        data-nama="{{ $part->nama_barang }}" data-satuan="{{ $part->satuan }}">
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $part->kode_partdetail }}</td>
                                        <td>{{ $part->nama_barang }}</td>
                                        <td>{{ $part->jumlah }}</td>
                                        <td>{{ $part->satuan }}</td>
                                        <td class="text-center">
                                            <button type="button" id="btnTambah" class="btn btn-primary btn-sm"
                                                onclick="getSelectedData({{ $loop->iteration - 1 }})">
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
        function getData(id) {
            var supplier_id = document.getElementById('supplier_id');
            $.ajax({
                url: "{{ url('admin/pembelian_ban/supplier') }}" + "/" + supplier_id.value,
                type: "GET",
                dataType: "json",
                success: function(supplier_id) {
                    var alamat = document.getElementById('alamat');
                    alamat.value = supplier_id.alamat;
                },
            });
        }

        var data_pembelian = @json(session('data_pembelians'));
        var jumlah_part = 1;

        if (data_pembelian != null) {
            jumlah_part = data_pembelian.length;
            $('#tabel-pembelian').empty();
            var urutan = 0;
            $.each(data_pembelian, function(key, value) {
                urutan = urutan + 1;
                itemPembelian(urutan, key, value);
            });
        }

        function addPesanan() {
            console.log();
            jumlah_part = jumlah_part + 1;

            if (jumlah_part === 1) {
                $('#tabel-pembelian').empty();
            }

            itemPembelian(jumlah_part, jumlah_part - 1);
        }

        function removeBan(params) {
            jumlah_part = jumlah_part - 1;

            var tabel_pesanan = document.getElementById('tabel-pembelian');
            var pembelian = document.getElementById('pembelian-' + params);

            tabel_pesanan.removeChild(pembelian);

            if (jumlah_part === 0) {
                var item_pembelian = '<tr>';
                item_pembelian += '<td class="text-center" colspan="8">- Ban belum ditambahkan -</td>';
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
            var kategori = '';
            var kode_partdetail = '';
            var nama_barang = '';
            var satuan = '';
            var jumlah = '';
            var type_ban = '';
            var harga = '';
            var kondisi_ban = '';

            if (value !== null) {
                kategori = value.kategori;
                kode_partdetail = value.kode_partdetail;
                nama_barang = value.nama_barang;
                satuan = value.satuan;
                jumlah = value.jumlah;
                type_ban = value.type_ban;
                harga = value.harga;
                kondisi_ban = value.kondisi_ban;
            }

            console.log(kategori);
            // urutan 
            var item_pembelian = '<tr id="pembelian-' + urutan + '">';
            item_pembelian += '<td class="text-center" id="urutan">' + urutan + '</td>';
            item_pembelian += '<td style="width: 240px">';

            // kategori 
            item_pembelian += '<div class="form-group">';
            item_pembelian += '<select class="form-control" id="kategori-' + key +
                '" name="kategori[]"onchange="getModalKategori(' + key + ')">';
            item_pembelian += '<option value="">-Kategori-</option>';
            item_pembelian += '<option value="oli"' + (kategori === 'oli' ? ' selected' : '') + '>oli</option>';
            item_pembelian += '<option value="body"' + (kategori === 'body' ? ' selected' : '') +
                '>body</option>';
            item_pembelian += '<option value="mesin"' + (kategori === 'mesin' ? ' selected' : '') +
                '>mesin</option>';
            item_pembelian += '<option value="sasis"' + (kategori === 'sasis' ? ' selected' : '') +
                '>sasis</option>';
            item_pembelian += '</select>';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            //kode barang
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" readonly id="kode_partdetail-' + key +
                '" name="kode_partdetail[]" value="' +
                kode_partdetail +
                '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            //nama barang
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" readonly id="nama_barang-' + key +
                '" name="nama_barang[]" value="' +
                nama_barang +
                '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            //satuan
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" readonly id="satuan-' + key +
                '" name="satuan[]" value="' +
                satuan +
                '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            //jumlah
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="number" class="form-control" id="jumlah-' + key +
                '" name="jumlah[]" value="' +
                jumlah +
                '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // harga
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="number" class="form-control" id="harga-' + key + '" name="harga[]" value="' +
                harga +
                '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // delete
            item_pembelian += '<td>';
            item_pembelian += '<button type="button" class="btn btn-danger" onclick="removeBan(' + urutan + ')">';
            item_pembelian += '<i class="fas fa-trash"></i>';
            item_pembelian += '</button>';
            item_pembelian += '</td>';
            item_pembelian += '</tr>';

            $('#tabel-pembelian').append(item_pembelian);

            if (value !== null) {
                $('#kategori-' + key).val(value.kategori);
                $('#kode_partdetail-' + key).val(value.kode_partdetail);
                $('#nama_barang-' + key).val(value.nama_barang);
                $('#satuan-' + key).val(value.satuan);
                $('#jumlah-' + key).val(value.jumlah);
                $('#harga-' + key).val(value.harga);
            }
        }


        // $(document).ready(function() {
        //     $('#tableKategori').on('hidden.bs.modal', function() {
        //         $('#kategori-0').val('');
        //     });
        // });

        function getModalKategori(param) {
            var selectedValue = $('#kategori-' + param).val();
            $('#tableKategori').modal('show');
            $('#example tbody tr').each(function() {
                var rowKategori = $(this).data('kategori');
                $(this).attr('data-param', param);
                if (rowKategori !== selectedValue) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            });
        }

        function showCategoryModal(selectedCategory) {
            $('#tableKategori').modal('show');

            $('#example tbody tr').each(function() {
                var rowKategori = $(this).data('kategori');
                if (selectedCategory === rowKategori) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }

        function getSelectedData(rowIndex) {
            console.log(rowIndex);
            var selectedRow = $('#example tbody tr:eq(' + rowIndex + ')');

            var kategori = selectedRow.data('kategori');
            var kode_partdetail = selectedRow.data('kode');
            var nama_barang = selectedRow.data('nama');
            var satuan = selectedRow.data('satuan');
            var param = selectedRow.data('param');

            // bagian Isi nilai-nilai input pada form Anda dengan nilai dari modal
            $('#kategori-' + param).val(kategori);
            $('#kode_partdetail-' + param).val(kode_partdetail);
            $('#nama_barang-' + param).val(nama_barang);
            $('#satuan-' + param).val(satuan);

            $('#tableKategori').modal('hide');
        }



        //tambah part 
        // $(document).ready(function() {
        //     $('#form-sparepart').on('submit', function(e) {
        //         e.preventDefault();

        //         var formData = new FormData(this);

        //         // mengirim permintaan Ajax
        //         $.ajax({
        //             type: 'POST',
        //             url: "{{ url('admin/tambah_sparepart') }}",
        //             data: formData,
        //             processData: false,
        //             contentType: false,
        //             success: function(response) {
        //                 if (response.success) {
        //                     alert('Sparepart berhasil ditambahkan');
        //                 } else {
        //                     alert('Gagal menambahkan sparepart. Silakan coba lagi.');
        //                 }
        //             },
        //             error: function(error) {
        //                 alert('Terjadi kesalahan saat mengirim permintaan. Silakan coba lagi.');
        //             }
        //         });
        //     });
        // });


        function refreshTable() {
            $.ajax({
                type: 'GET',
                url: "{{ url('admin/pembelian_part/tabelpart') }}",
                // url: "{{ url('admin/pembelian_part/tabelpartmesin') }}", 
                dataType: 'json',
                success: function(data) {
                    // Menghapus semua baris dalam tabel
                    $('#example tbody').empty();

                    // Menambahkan data baru ke dalam tabel
                    $.each(data, function(index, part) {
                        var newRow = '<tr data-kategori="' + part.kategori + '" data-kode="' + part
                            .kode_partdetail + '" data-nama="' + part.nama_barang + '" data-jumlah="' +
                            part.jumlah + '" data-satuan="' +
                            part.satuan + '">';
                        newRow += '<td class="text-center">' + (index + 1) + '</td>';
                        newRow += '<td>' + part.kode_partdetail + '</td>';
                        newRow += '<td>' + part.nama_barang + '</td>';
                        newRow += '<td>' + part.jumlah + '</td>';
                        newRow += '<td>' + part.satuan + '</td>';
                        newRow += '<td class="text-center">';
                        newRow +=
                            '<button type="button" id="btnTambah" class="btn btn-primary btn-sm" onclick="getSelectedData(' +
                            index + ')">';
                        newRow += '<i class="fas fa-plus"></i>';
                        newRow += '</button>';
                        newRow += '</td>';
                        newRow += '</tr>';

                        $('#example tbody').append(newRow);
                    });
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        }

        // Panggil fungsi refreshTable saat dokumen siap
        $(document).ready(function() {
            // Memproses pengiriman form
            $('#form-sparepart').on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData(this);

                // Mengirim permintaan Ajax
                $.ajax({
                    type: 'POST',
                    url: "{{ url('admin/tambah_sparepart') }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            alert('Sparepart berhasil ditambahkan');
                            // Setelah berhasil menambahkan data, panggil refreshTable untuk memperbarui tabel
                            refreshTable();
                        } else {
                            alert('Gagal menambahkan sparepart. Silakan coba lagi.');
                        }
                    },
                    error: function(error) {
                        alert('Terjadi kesalahan saat mengirim permintaan. Silakan coba lagi.');
                    }
                });
            });

            // Panggil fungsi refreshTable saat dokumen siap
            refreshTable();
        });

        // setInterval(function() {
        //     refreshTable();
        // }, 5000);
    </script>
@endsection
