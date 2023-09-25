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
                        <li class="breadcrumb-item active">Pembelian Part</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
        <div class="container-fluid">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-check"></i> Success!
                    </h5>
                    {{ session('success') }}
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
                        <div class="form-group">
                            <label for="supplier_id">Nama Supplier</label>
                            <select class="custom-select form-control" id="supplier_id" name="supplier_id"
                                onchange="getData(0)">
                                <option value="">- Pilih Supplier -</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}"
                                        {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->nama_supp }}</option>
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
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody id="tabel-pesanan">
                                <tr id="pesanan-0">
                                    <td class="text-center" id="urutan">1</td>
                                    <td style="width: 240px; align-items: center;">
                                        <div class="d-flex"
                                            style="flex: 1; justify-content: space-between; align-items: center;">
                                            <div class="form-group mr-2" style="flex: 8;"> <!-- Adjusted flex value -->
                                                <select class="select2bs4 select2-hidden-accessible" name="sparepart_id[]"
                                                    data-placeholder="Cari Kode.." style="width: 100%;" data-select2-id="23"
                                                    tabindex="-1" aria-hidden="true" id="sparepart_id-0"
                                                    onchange="getData1(0)">
                                                    <option value="">- Pilih -</option>
                                                    @foreach ($spareparts as $sparepart_id)
                                                        <option value="{{ $sparepart_id->id }}">
                                                            {{ $sparepart_id->kode_barang }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group" style="flex: 1;">
                                                <button type="button" data-toggle="modal" data-target="#modal-part"
                                                    class="btn btn-primary btn-sm">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="nama_barang-0"
                                                name="nama_barang[]" onkeyup="getTotal(0)">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="number" class="form-control" id="jumlah-0" name="jumlah[]"
                                                onkeyup="getTotal(0)">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="harga-0" name="harga[]">
                                        </div>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger" onclick="removePesanan(0)">
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
                            <form action="{{ url('admin/tambah_sparepart') }}" method="POST"
                                enctype="multipart/form-data" autocomplete="off">
                                @csrf
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Tambah Part</h3>
                                    </div>
                                    <div class="card-body">
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
                                            <label for="nama">Harga Jual</label>
                                            <input type="text" class="form-control" id="harga_jual" name="harga_jual"
                                                placeholder="Masukan harga jual" value="">
                                        </div>
                                        <div class="form-group">
                                            <label for="nama">Tersedia</label>
                                            <input type="text" class="form-control" id="tersedia" name="tersedia"
                                                placeholder="Tersedia" value="">
                                        </div>
                                        <div class="form-group">
                                            <label for="nama">Satuan</label>
                                            <input type="text" class="form-control" id="satuan" name="satuan"
                                                placeholder="Masukan satuan" value="">
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button type="reset" class="btn btn-secondary">Reset</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </div>
                                {{-- div diatas ini --}}
                            </form>
                        </div>
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

        function getData1(id) {
            var sparepart_id = document.getElementById('sparepart_id-0');
            $.ajax({
                url: "{{ url('admin/pembelian_part/sparepart') }}" + "/" + sparepart_id.value,
                type: "GET",
                dataType: "json",
                success: function(sparepart_id) {
                    var nama_barang = document.getElementById('nama_barang-0');
                    nama_barang.value = sparepart_id.nama_barang;
                },
            });
        }

        function getDataarray(key) {
            var sparepart_id = document.getElementById('sparepart_id-' + key);
            $.ajax({
                url: "{{ url('admin/pembelian_part/sparepart') }}" + "/" + sparepart_id.value,
                type: "GET",
                dataType: "json",
                success: function(response) {
                    var nama_barang = document.getElementById('nama_barang-' + key);
                    nama_barang.value = response.nama_barang;
                },
            });
        }


        var data_pesanan = @json(session('data_pembelians'));
        var jumlah_pesanan = 1;

        if (data_pesanan != null) {
            jumlah_pesanan = data_pesanan.length;
            $('#tabel-pembelian').empty();
            var urutan = 0;
            $.each(data_pesanan, function(key, value) {
                urutan = urutan + 1;
                itemPesanan(urutan, key, false, value);
            });
        }

        function addPesanan() {
            jumlah_pesanan = jumlah_pesanan + 1;

            if (jumlah_pesanan === 1) {
                $('#tabel-pembelian').empty();
            }

            itemPesanan(jumlah_pesanan, jumlah_pesanan - 1, true);
        }

        function removePesanan(params) {
            jumlah_pesanan = jumlah_pesanan - 1;

            console.log(jumlah_pesanan);

            var tabel_pesanan = document.getElementById('tabel-pesanan');
            var pesanan = document.getElementById('pesanan-' + params);

            tabel_pesanan.removeChild(pesanan);

            if (jumlah_pesanan === 0) {
                var item_pesanan = '<tr>';
                item_pesanan += '<td class="text-center" colspan="5">- Part belum ditambahkan -</td>';
                item_pesanan += '</tr>';
                $('#tabel-pesanan').html(item_pesanan);
            } else {
                var urutan = document.querySelectorAll('#urutan');
                for (let i = 0; i < urutan.length; i++) {
                    urutan[i].innerText = i + 1;
                }
            }
        }

        function itemPesanan(urutan, key, style, value = null) {
            var sparepart_id = '';
            var nama_barang = '';
            var jumlah = '';
            var harga = '';

            if (value !== null) {
                sparepart_id = value.sparepart_id;
                nama_barang = value.nama_barang;
                jumlah = value.jumlah;
                harga = value.harga;
            }

            console.log(sparepart_id);

            var item_pesanan = '<tr id="pesanan-' + urutan + '">';
            item_pesanan += '<td class="text-center" id="urutan">' + urutan + '</td>';

            // Kode Barang Column
            item_pesanan += '<td style="width: 240px">';
            item_pesanan += '<div class="form-group">';
            item_pesanan += '<div class="d-flex align-items-center">';
            item_pesanan +=
                '<select class="form-control select2bs4 mr-2" id="sparepart_id-' + key +
                '" name="sparepart_id[]" onchange="getDataarray(' + key +
                ')" style="width: 100%;" data-placeholder="Cari Kode..">';

            var spareparts = <?php echo json_encode($spareparts); ?>;
            for (var i = 0; i < spareparts.length; i++) {
                item_pesanan += '<option value="' + spareparts[i].id + '"' +
                    (spareparts[i].id == sparepart_id ? ' selected' : '') +
                    '>' + spareparts[i].kode_barang + '</option>';
            }

            item_pesanan += '</select>';
            item_pesanan +=
                '<button type="button" data-toggle="modal" data-target="#modal-part" class="btn btn-primary btn-sm" style="margin-left: 10px;">';
            item_pesanan += '<i class="fas fa-plus"></i>';
            item_pesanan += '</button>';
            item_pesanan += '</div>';
            item_pesanan += '</div>';
            item_pesanan += '</td>';


            // nama barang 
            item_pesanan += '<td>';
            item_pesanan += '<div class="form-group">';
            item_pesanan += '<input type="text" class="form-control" id="nama_barang-' + key +
                '" name="nama_barang[]" value="' +
                nama_barang +
                '" onkeyup="getTotal(' + key + ')">';
            item_pesanan += '</div>';
            item_pesanan += '</td>';

            // jumlah 
            item_pesanan += '<td>';
            item_pesanan += '<div class="form-group">';
            item_pesanan += '<input type="number" class="form-control" id="jumlah-' + key +
                '" name="jumlah[]" value="' +
                jumlah + '" onkeyup="getTotal(' + key + ')">';
            item_pesanan += '</div>';
            item_pesanan += '</td>'
            item_pesanan += '<td>';
            item_pesanan += '<div class="form-group">'
            item_pesanan += '<input type="number" class="form-control" id="harga-' + key + '" name="harga[]" value="' +
                harga +
                '">';
            item_pesanan += '</div>';
            item_pesanan += '</td>';

            // delete
            item_pesanan += '<td>';
            item_pesanan += '<button type="button" class="btn btn-danger" onclick="removePesanan(' + urutan + ')">';
            item_pesanan += '<i class="fas fa-trash"></i>';
            item_pesanan += '</button>';
            item_pesanan += '</td>';
            item_pesanan += '</tr>';


            if (style) {
                select2(key);
            }

            $('#tabel-pesanan').append(item_pesanan);

            $('#sparepart_id-' + key + '').val(sparepart_id).attr('selected', true);
        }

        function select2(id) {
            $(function() {
                $('#sparepart_id-' + id).select2({
                    theme: 'bootstrap4'
                });
            });
        }
    </script>
@endsection
