@extends('layouts.app')

@section('title', 'Inquery Pembelian Part')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Inquery Pembelian Part</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/inquery_pembelianpart') }}">Transaksi</a></li>
                        <li class="breadcrumb-item active">Inquery Pembelian part</li>
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
            <form action="{{ url('admin/inquery_pembelianpart/' . $inquery->id) }}" method="post" autocomplete="off">
                @csrf
                @method('put')
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
                        <div class="form-group">
                            <label for="supplier_id">Nama Supplier</label>
                            <select class="custom-select form-control" id="supplier_id" name="supplier_id"
                                onchange="getData(0)">
                                <option value="">- Pilih Supplier -</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}"
                                        {{ old('supplier_id', $inquery->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->nama_supp }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea type="text" class="form-control" readonly id="alamat" name="alamat" placeholder="Masukan alamat"
                                value="">{{ old('alamat', $inquery->supplier->alamat) }}</textarea>
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
                                    <th>Harga Satuan</th>
                                    <th>Jumlah</th>
                                    <th>Total</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody id="tabel-pembelian">
                                @foreach ($details as $detail)
                                    <tr id="pembelian-{{ $loop->index }}">
                                        <td class="text-center" id="urutan">{{ $loop->index + 1 }}</td>
                                        <td>
                                            <div class="form-group" hidden>
                                                <input type="text" class="form-control" id="nomor_seri-0"
                                                    name="detail_ids[]" value="{{ $detail['id'] }}">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" readonly class="form-control"
                                                    id="kategori-{{ $loop->index }}" name="kategori[]"
                                                    value="{{ $detail['kategori'] }}">
                                            </div>
                                        </td>
                                        <td hidden>
                                            <div class="form-group">
                                                <input type="text" readonly class="form-control"
                                                    id="sparepart_id-{{ $loop->index }}" name="sparepart_id[]"
                                                    value="{{ $detail['sparepart_id'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" readonly class="form-control"
                                                    id="kode_partdetail-{{ $loop->index }}" name="kode_partdetail[]"
                                                    value="{{ $detail['kode_partdetail'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" readonly class="form-control"
                                                    id="nama_barang-{{ $loop->index }}" name="nama_barang[]"
                                                    value="{{ $detail['nama_barang'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" readonly class="form-control"
                                                    id="satuan-{{ $loop->index }}" name="satuan[]"
                                                    value="{{ $detail['satuan'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control hargasatuan" id="hargasatuan-0"
                                                    name="hargasatuan[]" data-row-id="0"
                                                    value="{{ $detail['hargasatuan'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control jumlah" id="jumlah-0"
                                                    name="jumlah[]" data-row-id="0" value="{{ $detail['jumlah'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="number" class="form-control harga" id="harga-0"
                                                    name="harga[]" value="{{ $detail['harga'] }}">
                                            </div>
                                        </td>
                                        <td style="width: 120px">
                                            <button type="button" class="btn btn-primary"
                                                onclick="barang({{ $loop->index }})">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                            <button style="margin-left:5px" type="button" class="btn btn-danger"
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
                            <form action="{{ url('admin/tambah_sparepartin') }}" method="POST"
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
                                        {{-- <div class="form-group">
                                            <label for="nama">Harga</label>
                                            <input type="number" class="form-control" id="harga" name="harga"
                                                placeholder="Masukan harga" value="">
                                        </div>
                                        <div class="form-group">
                                            <label for="nama">Stok</label>
                                            <input type="number" class="form-control" id="jumlah" name="jumlah"
                                                placeholder="Tersedia" value="">
                                        </div> --}}
                                        <div class="form-group">
                                            <label class="form-label" for="satuan">Satuan</label>
                                            <select class="form-control" id="satuan" name="satuan">
                                                <option value="">- Pilih -</option>
                                                <option value="pcs" {{ old('satuan') == 'pcs' ? 'selected' : null }}>
                                                    pcs</option>
                                                <option value="ltr" {{ old('satuan') == 'ltr' ? 'selected' : null }}>
                                                    ltr</option>
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
                        <button type="button" data-toggle="modal" data-target="#modal-part"
                            class="btn btn-primary btn-sm mb-2" data-dismiss="modal">
                            Tambah
                        </button>
                        <div class="m-2">
                            <input type="text" id="searchInput" class="form-control" placeholder="Search...">
                        </div>
                        <table id="tables" class="table table-bordered table-striped">
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
                                    <tr data-kategori="{{ $part->kategori }}" data-sparepart_id="{{ $part->id }}"
                                        data-kode_partdetail="{{ $part->kode_partdetail }}"
                                        data-nama_barang="{{ $part->nama_barang }}" data-satuan="{{ $part->satuan }}"
                                        data-param="{{ $loop->index }}">
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $part->kode_partdetail }}</td>
                                        <td>{{ $part->nama_barang }}</td>
                                        <td>{{ $part->jumlah }}</td>
                                        <td>{{ $part->satuan }}</td>
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


        var activeSpecificationIndex = 0;

        function barang(param) {
            activeSpecificationIndex = param;
            // Show the modal and filter rows if necessary
            $('#tableKategori').modal('show');
        }

        function getBarang(rowIndex) {
            var selectedRow = $('#tables tbody tr:eq(' + rowIndex + ')');
            var kategori = selectedRow.data('kategori');
            var sparepart_id = selectedRow.data('sparepart_id');
            var kode_partdetail = selectedRow.data('kode_partdetail');
            var nama_barang = selectedRow.data('nama_barang');
            var satuan = selectedRow.data('satuan');

            // Update the form fields for the active specification
            $('#kategori-' + activeSpecificationIndex).val(kategori);
            $('#sparepart_id-' + activeSpecificationIndex).val(sparepart_id);
            $('#kode_partdetail-' + activeSpecificationIndex).val(kode_partdetail);
            $('#nama_barang-' + activeSpecificationIndex).val(nama_barang);
            $('#satuan-' + activeSpecificationIndex).val(satuan);

            $('#tableKategori').modal('hide');
        }

        $(document).on("input", ".hargasatuan, .jumlah", function() {
            var currentRow = $(this).closest('tr');
            var hargasatuan = parseFloat(currentRow.find(".hargasatuan").val()) || 0;
            var jumlah = parseFloat(currentRow.find(".jumlah").val()) || 0;
            var harga = hargasatuan * jumlah;
            currentRow.find(".harga").val(harga);
        });

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

        function removeBan(identifier) {
            var row = $('#pembelian-' + identifier);
            var detailId = row.find("input[name='detail_ids[]']").val();

            row.remove();

            if (detailId) {
                $.ajax({
                    url: "{{ url('admin/inquery_pembelianpart/deletepart/') }}/" + detailId,
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
            }

            updateUrutan();
        }

        function itemPembelian(identifier, key, value = null) {
            var kategori = '';
            var sparepart_id = '';
            var kode_partdetail = '';
            var nama_barang = '';
            var satuan = '';
            var jumlah = '';
            var type_ban = '';
            var hargasatuan = '';
            var harga = '';
            var kondisi_ban = '';

            if (value !== null) {
                kategori = value.kategori;
                sparepart_id = value.sparepart_id;
                kode_partdetail = value.kode_partdetail;
                nama_barang = value.nama_barang;
                satuan = value.satuan;
                jumlah = value.jumlah;
                type_ban = value.type_ban;
                hargasatuan = value.hargasatuan;
                harga = value.harga;
                kondisi_ban = value.kondisi_ban;
            }

            console.log(kategori);
            // urutan 
            var item_pembelian = '<tr id="pembelian-' + key + '">';
            item_pembelian += '<td class="text-center" id="urutan">' + key + '</td>';

            // kategori 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" readonly id="kategori-' + key +
                '" name="kategori[]" value="' +
                kategori +
                '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            //sparepart_id
            item_pembelian += '<td hidden>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" readonly id="sparepart_id-' + key +
                '" name="sparepart_id[]" value="' +
                sparepart_id +
                '" ';
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
            item_pembelian += '<input type="number" class="form-control hargasatuan" id="hargasatuan-' + key +
                '" name="hargasatuan[]" value="' +
                hargasatuan +
                '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            //jumlah
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="number" class="form-control jumlah" id="jumlah-' + key +
                '" name="jumlah[]" value="' +
                jumlah +
                '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // harga
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="number" class="form-control harga" id="harga-' + key +
                '" name="harga[]" value="' +
                harga +
                '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // delete
            item_pembelian += '<td style="width: 120px">';
            item_pembelian += '<button type="button" class="btn btn-primary" onclick="barang(' + key + ')">';
            item_pembelian += '<i class="fas fa-plus"></i>';
            item_pembelian += '</button>';
            item_pembelian += '<button style="margin-left:5px" type="button" class="btn btn-danger" onclick="removeBan(' +
                key + ')">';
            item_pembelian += '<i class="fas fa-trash"></i>';
            item_pembelian += '</button>';
            item_pembelian += '</td>';
            item_pembelian += '</tr>';

            $('#tabel-pembelian').append(item_pembelian);
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
        });
    </script>
@endsection
