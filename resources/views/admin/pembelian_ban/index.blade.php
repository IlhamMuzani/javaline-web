@extends('layouts.app')

@section('title', 'Pembelian Ban')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Pembelian Ban</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/pembelian_ban') }}">Transaksi</a></li>
                        <li class="breadcrumb-item active">Pembelian ban</li>
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
            <form action="{{ url('admin/pembelian_ban') }}" method="post" autocomplete="off">
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
                            <select class="select2bs4 select22-hidden-accessible" name="supplier_id"
                                data-placeholder="Cari Supplier.." style="width: 100%;" data-select22-id="23" tabindex="-1"
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
                        <h3 class="card-title">Tambah Ban</h3>
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
                                    <th>No Seri</th>
                                    <th>Ukuran</th>
                                    <th>Kondisi Ban</th>
                                    <th>Merek</th>
                                    <th>Type</th>
                                    <th>Harga</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody id="tabel-pembelian">
                                <tr id="pembelian-0">
                                    <td class="text-center" id="urutan">1</td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="nomor_seri-0" name="no_seri[]">
                                        </div>
                                    </td>
                                    <td style="width: 150px">
                                        <div class="form-group">
                                            <select class="select2bs4 select2-hidden-accessible" name="ukuran_id[]"
                                                data-placeholder="Pilih Ukuran.." style="width: 100%;" data-select2-id="23"
                                                tabindex="-1" aria-hidden="true" id="ukuran_id-0">
                                                <option value="">- Pilih Ukuran -</option>
                                                @foreach ($ukurans as $ukuran)
                                                    <option value="{{ $ukuran->id }}">{{ $ukuran->ukuran }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td style="width: 150px">
                                        <div class="form-group">
                                            <select class="form-control" id="kondisi_ban-0" name="kondisi_ban[]">
                                                <option value="">- Pilih Kondisi -</option>
                                                <option value="BARU"
                                                    {{ old('kondisi_ban') == 'BARU' ? 'selected' : null }}>
                                                    BARU</option>
                                                <option value="BEKAS"
                                                    {{ old('kondisi_ban') == 'BEKAS' ? 'selected' : null }}>
                                                    BEKAS</option>
                                                <option value="KANISIR"
                                                    {{ old('kondisi_ban') == 'KANISIR' ? 'selected' : null }}>
                                                    KANISIR</option>
                                                <option value="AFKIR"
                                                    {{ old('kondisi_ban') == 'AFKIR' ? 'selected' : null }}>
                                                    AFKIR</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td style="width: 220px">
                                        <div class="form-group">
                                            <select class="select2bs4 select21-hidden-accessible" name="merek_id[]"
                                                data-placeholder="Pilih Merek.." style="width: 100%;"
                                                data-select21-id="23" tabindex="-1" aria-hidden="true" id="merek_id-0">
                                                <option value="">- Pilih -</option>
                                                @foreach ($mereks as $merek)
                                                    <option value="{{ $merek->id }}">{{ $merek->nama_merek }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td style="width: 200px">
                                        <div class="form-group">
                                            <select class="select2bs4 select21-hidden-accessible" name="typeban_id[]"
                                                data-placeholder="Pilih Type.." style="width: 100%;"
                                                data-select21-id="23" tabindex="-1" aria-hidden="true" id="typeban_id-0">
                                                <option value="">- Pilih -</option>
                                                @foreach ($typebans as $typeban_id)
                                                    <option value="{{ $typeban_id->id }}">
                                                        {{ $typeban_id->nama_type }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="harga-0" name="harga[]">
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
                                                <option value="BRI"
                                                    {{ old('nama_bank') == 'BRI' ? 'selected' : null }}>
                                                    BRI</option>
                                                <option value="MANDIRI"
                                                    {{ old('nama_bank') == 'MANDIRI' ? 'selected' : null }}>
                                                    MANDIRI</option>
                                                <option value="BNI"
                                                    {{ old('nama_bank') == 'BNI' ? 'selected' : null }}>
                                                    BNI</option>
                                                <option value="BTN"
                                                    {{ old('nama_bank') == 'BTN' ? 'selected' : null }}>
                                                    BTN</option>
                                                <option value="DANAMON"
                                                    {{ old('nama_bank') == 'DANAMON' ? 'selected' : null }}>
                                                    DANAMON</option>
                                                <option value="BCA"
                                                    {{ old('nama_bank') == 'BCA' ? 'selected' : null }}>
                                                    BCA</option>
                                                <option value="PERMATA"
                                                    {{ old('nama_bank') == 'PERMATA' ? 'selected' : null }}>
                                                    PERMATA</option>
                                                <option value="PAN"
                                                    {{ old('nama_bank') == 'PAN' ? 'selected' : null }}>
                                                    PAN</option>
                                                <option value="CIMB NIAGA"
                                                    {{ old('nama_bank') == 'CIMB NIAGA' ? 'selected' : null }}>
                                                    CIMB NIAGA</option>
                                                <option value="UOB"
                                                    {{ old('nama_bank') == 'UOB' ? 'selected' : null }}>
                                                    UOB</option>
                                                <option value="ARTHA GRAHA"
                                                    {{ old('nama_bank') == 'ARTHA GRAHA' ? 'selected' : null }}>
                                                    ARTHA GRAHA</option>
                                                <option value="BUMI ARTHA"
                                                    {{ old('nama_bank') == 'BUMI ARTHA' ? 'selected' : null }}>
                                                    BUMI ARTHA</option>
                                                <option value="MEGA"
                                                    {{ old('nama_bank') == 'MEGA' ? 'selected' : null }}>
                                                    MEGA</option>
                                                <option value="SYARIAH"
                                                    {{ old('nama_bank') == 'SYARIAH' ? 'selected' : null }}>
                                                    SYARIAH</option>
                                                <option value="MEGA SYARIAH"
                                                    {{ old('nama_bank') == 'MEGA SYARIAH' ? 'selected' : null }}>
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
        var jumlah_ban = 1;

        if (data_pembelian != null) {
            jumlah_ban = data_pembelian.length;
            $('#tabel-pembelian').empty();
            var urutan = 0;
            $.each(data_pembelian, function(key, value) {
                urutan = urutan + 1;
                itemPembelian(urutan, key, false, value);
            });
        }

        function addPesanan() {
            jumlah_ban = jumlah_ban + 1;

            if (jumlah_ban === 1) {
                $('#tabel-pembelian').empty();
            }

            itemPembelian(jumlah_ban, jumlah_ban - 1, true);
        }

        function removeBan(params) {
            jumlah_ban = jumlah_ban - 1;

            console.log(jumlah_ban);

            var tabel_pesanan = document.getElementById('tabel-pembelian');
            var pembelian = document.getElementById('pembelian-' + params);

            tabel_pesanan.removeChild(pembelian);

            if (jumlah_ban === 0) {
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

        function itemPembelian(urutan, key, style, value = null) {
            var no_seri = '';
            var ukuran_id = '';
            var merek_id = '';
            var typeban_id = '';
            var harga = '';
            var kondisi_ban = '';

            if (value !== null) {
                no_seri = value.no_seri;
                ukuran_id = value.ukuran_id;
                merek_id = value.merek_id;
                typeban_id = value.typeban_id;
                harga = value.harga;
                kondisi_ban = value.kondisi_ban;
            }

            console.log(no_seri);
            // urutan 
            var item_pembelian = '<tr id="pembelian-' + urutan + '">';
            item_pembelian += '<td class="text-center" id="urutan">' + urutan + '</td>';
            item_pembelian += '<td>';

            // no_seri 
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" id="nomor_seri-' + key +
                '" name="no_seri[]" value="' +
                no_seri +
                '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // ukuran 
            item_pembelian += '<td style="width: 150px">';
            item_pembelian += '<div class="form-group">';
            item_pembelian += '<select class="form-control select2bs4" id="ukuran_id-' + key +
                '" name="ukuran_id[]" onchange="getHarga(' + key + ')">';
            item_pembelian += '<option value="">- Pilih Ukuran -</option>';
            item_pembelian += '@foreach ($ukurans as $ukuran_id)';
            item_pembelian +=
                '<option value="{{ $ukuran_id->id }}" {{ $ukuran_id->id == ' + ukuran_id + ' ? 'selected' : '' }}>{{ $ukuran_id->ukuran }}</option>';
            item_pembelian += '@endforeach';
            item_pembelian += '</select>';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // kondisi_ban
            item_pembelian += '<td style="width: 150px">';
            item_pembelian += '<div class="form-group">';
            item_pembelian += '<select class="form-control" id="kondisi_ban-' + key + '" name="kondisi_ban[]">';
            item_pembelian += '<option value="">- Pilih Kondisi -</option>';
            item_pembelian += '<option value="BARU"' + (kondisi_ban === 'BARU' ? ' selected' : '') + '>BARU</option>';
            item_pembelian += '<option value="BEKAS"' + (kondisi_ban === 'BEKAS' ? ' selected' : '') +
                '>BEKAS</option>';
            item_pembelian += '<option value="KANISIR"' + (kondisi_ban === 'KANISIR' ? ' selected' : '') +
                '>KANISIR</option>';
            item_pembelian += '<option value="AFKIR"' + (kondisi_ban === 'AFKIR' ? ' selected' : '') +
                '>AFKIR</option>';
            item_pembelian += '</select>';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // merek
            item_pembelian += '<td style="width: 220px">';
            item_pembelian += '<div class="form-group">';
            item_pembelian += '<select class="form-control select2bs4" id="merek_id-' + key +
                '" name="merek_id[]">';
            item_pembelian += '<option value="">- Pilih Merek -</option>';
            item_pembelian += '@foreach ($mereks as $merek_id)';
            item_pembelian +=
                '<option value="{{ $merek_id->id }}" {{ $merek_id->id == ' + merek_id + ' ? 'selected' : '' }}>{{ $merek_id->nama_merek }}</option>';
            item_pembelian += '@endforeach';
            item_pembelian += '</select>';
            item_pembelian += '</div>';
            item_pembelian += '</td>';
            item_pembelian += '</td>'

            // type
            item_pembelian += '<td style="width: 200px">';
            item_pembelian += '<div class="form-group">';
            item_pembelian += '<select class="form-control select2bs4" id="typeban_id-' + key +
                '" name="typeban_id[]" onchange="getHarga(' + key + ')">';
            item_pembelian += '<option value="">- Pilih Type -</option>';
            item_pembelian += '@foreach ($typebans as $typeban_id)';
            item_pembelian +=
                '<option value="{{ $typeban_id->id }}" {{ $typeban_id->id == ' + typeban_id + ' ? 'selected' : '' }}>{{ $typeban_id->nama_type }}</option>';
            item_pembelian += '@endforeach';
            item_pembelian += '</select>';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // harga
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" id="harga-' + key + '" name="harga[]" value="' +
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

            // $('#tabel-pembelian').append(item_pembelian);

            // if (value !== null) {
            //     $('#nomor_seri-' + key).val(value.no_seri);
            //     $('#ukuran_id-' + key).val(value.ukuran_id);
            //     $('#kondisi_ban-' + key).val(value.kondisi_ban);
            //     $('#merek_id-' + key).val(value.merek_id);
            //     $('#typeban_id-' + key).val(value.typeban_id);
            //     $('#harga-' + key).val(value.harga);
            // }

            if (style) {
                select2(key);
            }

            $('#tabel-pembelian').append(item_pembelian);

            $('#ukuran_id-' + key + '').val(ukuran_id).attr('selected', true);
            $('#merek_id-' + key + '').val(merek_id).attr('selected', true);
            $('#typeban_id-' + key + '').val(typeban_id).attr('selected', true);
        }

        function select2(id) {
            $(function() {
                $('#ukuran_id-' + id).select2({
                    theme: 'bootstrap4'
                });
                $('#merek_id-' + id).select2({
                    theme: 'bootstrap4'
                });
                $('#typeban_id-' + id).select2({
                    theme: 'bootstrap4'
                });
            });
        }
    </script>
@endsection
