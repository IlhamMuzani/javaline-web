@extends('layouts.app')

@section('title', 'Perbarui Pembelian Ban')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Perbarui Pembelian</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/pembelian_ban') }}">Transaksi</a></li>
                        <li class="breadcrumb-item active">Perbarui Pembelian ban</li>
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
            <form action="{{ url('admin/inquery_pembelianban/' . $inquery->id) }}" method="post" autocomplete="off">
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
                                @foreach ($details as $detail)
                                    <tr id="pembelian-{{ $loop->index }}">
                                        <td class="text-center" id="urutan">{{ $loop->index + 1 }}</td>
                                        <td style="width: 240px">
                                            <div class="form-group" hidden>
                                                <input type="text" class="form-control" id="nomor_seri-0"
                                                    name="detail_ids[]" value="{{ $detail['id'] }}">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="nomor_seri-0"
                                                    name="no_seri[]" value="{{ $detail['no_seri'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <select class="form-control" id="ukuran_id-{{ $loop->index }}"
                                                    name="ukuran_id[]">
                                                    <option value="">- Pilih Ukuran -</option>
                                                    @foreach ($ukurans as $ukuran)
                                                        <option value="{{ $ukuran->id }}"
                                                            {{ old('ukuran_id.' . $loop->parent->index, $detail['ukuran_id']) == $ukuran->id ? 'selected' : '' }}>
                                                            {{ $ukuran->ukuran }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <select class="form-control" id="kondisi_ban-0" name="kondisi_ban[]">
                                                    <option value="">- Pilih Kondisi -</option>
                                                    <option value="BARU"
                                                        {{ old('kondisi_ban', $detail['kondisi_ban']) == 'BARU' ? 'selected' : null }}>
                                                        BARU</option>
                                                    <option value="BEKAS"
                                                        {{ old('kondisi_ban', $detail['kondisi_ban']) == 'BEKAS' ? 'selected' : null }}>
                                                        BEKAS</option>
                                                    <option value="KANISIR"
                                                        {{ old('kondisi_ban', $detail['kondisi_ban']) == 'KANISIR' ? 'selected' : null }}>
                                                        KANISIR</option>
                                                    <option value="AFKIR"
                                                        {{ old('kondisi_ban', $detail['kondisi_ban']) == 'AFKIR' ? 'selected' : null }}>
                                                        AFKIR</option>
                                                    <option value="PROFIT"
                                                        {{ old('kondisi_ban', $detail['kondisi_ban']) == 'PROFIT' ? 'selected' : null }}>
                                                        PROFIT</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <select class="form-control" id="merek_id-{{ $loop->index }}"
                                                        name="merek_id[]">
                                                        <option value="">- Pilih Merek -</option>
                                                        @foreach ($mereks as $merek)
                                                            <option value="{{ $merek->id }}"
                                                                {{ old('merek_id.' . $loop->parent->index, $detail['merek_id']) == $merek->id ? 'selected' : '' }}>
                                                                {{ $merek->nama_merek }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <select class="form-control" id="typeban_id-{{ $loop->index }}"
                                                        name="typeban_id[]">
                                                        <option value="">- Pilih Type -</option>
                                                        @foreach ($typebans as $typeban_id)
                                                            <option value="{{ $typeban_id->id }}"
                                                                {{ old('typeban_id.' . $loop->parent->index, $detail['typeban_id']) == $typeban_id->id ? 'selected' : '' }}>
                                                                {{ $typeban_id->nama_type }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="harga-0" name="harga[]"
                                                    value="{{ $detail['harga'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger"
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
            }

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
            item_pembelian += '<td style="width: 240px">';

            // no_seri 
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" id="nomor_seri-' + key +
                '" name="no_seri[]" value="' +
                no_seri +
                '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';
            item_pembelian += '<td>';

            // ukuran 
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
            item_pembelian += '<td>';
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
            item_pembelian += '<option value="PROFIT"' + (kondisi_ban === 'PROFIT' ? ' selected' : '') +
                '>PROFIT</option>';
            item_pembelian += '</select>';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // merek
            item_pembelian += '<td>';
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
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">';
            item_pembelian += '<select class="form-control select2bs4" id="typeban_id-' + key +
                '" name="typeban_id[]">';
            item_pembelian += '<option value="">- Pilih Type -</option>';
            item_pembelian += '@foreach ($typebans as $typeban_id)';
            item_pembelian +=
                '<option value="{{ $typeban_id->id }}" {{ $typeban_id->id == ' + typeban_id + ' ? 'selected' : '' }}>{{ $typeban_id->nama_type }}</option>';
            item_pembelian += '@endforeach';
            item_pembelian += '</select>';
            item_pembelian += '</div>';
            item_pembelian += '</td>';
            item_pembelian += '</td>'

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

            $('#tabel-pembelian').append(item_pembelian);


            if (value !== null) {
                $('#nomor_seri-' + key).val(value.no_seri);
                $('#ukuran_id-' + key).val(value.ukuran_id);
                $('#kondisi_ban-' + key).val(value.kondisi_ban);
                $('#merek_id-' + key).val(value.merek_id);
                $('#typeban_id-' + key).val(value.typeban_id);
                $('#harga-' + key).val(value.harga);
            }
        }
    </script>
@endsection
