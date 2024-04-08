@extends('layouts.app')

@section('title', 'Penggantian Oli')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Penggantian Oli</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/penggantian_oli') }}">Operasional</a></li>
                        <li class="breadcrumb-item active">Penggantian Oli</li>
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
            <form action="{{ url('admin/penggantian_oli/' . $kendaraans->id) }}" method="POST"
                enctype="multipart/form-data" autocomplete="off">
                @csrf
                @method('put')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Penggantian Oli</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group" hidden>
                            <input type="text" class="form-control" readonly id="kendaraan_id" name="kendaraan_id"
                                value="{{ $kendaraans->id }}">
                        </div>
                        <div class="form-group">
                            <label for="alamat">No Kabin</label>
                            <input type="text" class="form-control" readonly id="no_kabin" name="no_kabin"
                                value="{{ $kendaraans->no_kabin }}">
                        </div>
                        <div class="form-group">
                            <label for="alamat">No Registrasi</label>
                            <input type="text" class="form-control" readonly id="no_pol" name="no_pol"
                                value="{{ $kendaraans->no_pol }}">
                        </div>
                        <div class="form-group">
                            <label for="alamat">Jenis Kendaraan</label>
                            <input type="text" class="form-control" readonly id="jenis_kendaraan" name="jenis_kendaraan"
                                value="{{ $kendaraans->jenis_kendaraan->nama_jenis_kendaraan }}">
                        </div>
                        <div class="form-group">
                            <label for="alamat">Km Penggantian</label>
                            <input type="number" class="form-control" id="km" name="km"
                                value="{{ old('km') }}">
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Oli</h3>
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
                                    <th>Nama Part</th>
                                    <th>Kode Part</th>
                                    <th>Jumlah Liter</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody id="tabel-pembelian">
                                <tr id="pembelian-0">
                                    <td class="text-center" id="urutan">1</td>
                                    <td>
                                        <div class="form-group">
                                            <select class="form-control" id="kategori-0" name="kategori[]">
                                                <option value="">Pilih</option>
                                                <option value="Oli Mesin"
                                                    {{ old('kategori') == 'Oli Mesin' ? 'selected' : null }}>
                                                    Oli Mesin</option>
                                                <option value="Oli Gardan"
                                                    {{ old('kategori') == 'Oli Gardan' ? 'selected' : null }}>
                                                    Oli Gardan</option>
                                                <option value="Oli Transmisi"
                                                    {{ old('kategori') == 'Oli Transmisi' ? 'selected' : null }}>
                                                    Oli Transmisi</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td style="width: 240px">
                                        <div class="form-group">
                                            <select class="select2bs4 select21-hidden-accessible" id="sparepart_id-0"
                                                name="sparepart_id[]" data-placeholder="Cari Part.." style="width: 100%;"
                                                data-select21-id="23" tabindex="-1" aria-hidden="true"
                                                onchange="getData1(0)">
                                                <option value="">- Pilih -</option>
                                                @foreach ($spareparts as $sparepart_id)
                                                    <option value="{{ $sparepart_id->id }}">
                                                        {{ $sparepart_id->nama_barang }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" readonly class="form-control" id="nama_barang-0"
                                                name="nama_barang[]">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="jumlah-0" name="jumlah[]"
                                                onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || event.charCode == 46">
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

                <div style="margin-top: 20px;" class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Filter</h3>
                        <div class="float-right">
                            <button type="button" class="btn btn-primary btn-sm" onclick="addPesanan2()">
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
                                    <th>Nama Part</th>
                                    <th>Kode Part</th>
                                    <th>Jumlah Pcs</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody id="tabel-pembelian2">
                                <tr id="pembelian2-0">
                                    <td class="text-center" id="urutan2">1</td>
                                    <td>
                                        <div class="form-group">
                                            <select class="form-control" id="kategori2-0" name="kategori2[]">
                                                <option value="">Pilih</option>
                                                <option value="Filter Oli"
                                                    {{ old('kategori2') == 'Filter Oli' ? 'selected' : null }}>
                                                    Filter Oli</option>
                                                <option value="Filter Solar Atas"
                                                    {{ old('kategori2') == 'Filter Solar Atas' ? 'selected' : null }}>
                                                    Filter Solar Atas</option>
                                                <option value="Filter Solar Bawah"
                                                    {{ old('kategori2') == 'Filter Solar Bawah' ? 'selected' : null }}>
                                                    Filter Solar Bawah</option>
                                                <option value="Filter Angin"
                                                    {{ old('kategori2') == 'Filter Angin' ? 'selected' : null }}>
                                                    Filter Angin</option>
                                                <option value="Gemuk"
                                                    {{ old('kategori2') == 'Gemuk' ? 'selected' : null }}>
                                                    Gemuk</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td style="width: 240px">
                                        <div class="form-group">
                                            <select class="select2bs4 select2-hidden-accessible" name="spareparts_id[]"
                                                data-placeholder="Cari Filter.." style="width: 100%;"
                                                data-select2-id="23" tabindex="-1" aria-hidden="true"
                                                onchange="getData2(0)" id="spareparts_id-0">
                                                <option value="">- Cari -</option>
                                                @foreach ($spareparts as $sparepart_id)
                                                    <option value="{{ $sparepart_id->id }}">
                                                        {{ $sparepart_id->nama_barang }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" readonly class="form-control" id="nama_barang2-0"
                                                name="nama_barang2[]">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="jumlah2-0" name="jumlah2[]"
                                                onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || event.charCode == 46">
                                        </div>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger" onclick="removeBan2(0)">
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
    </section>
    <script>
        function getData1(id) {
            var sparepart_id = document.getElementById('sparepart_id-0');
            $.ajax({
                url: "{{ url('admin/pembelian_part/sparepart') }}" + "/" + sparepart_id.value,
                type: "GET",
                dataType: "json",
                success: function(sparepart_id) {
                    var kode_partdetail = document.getElementById('nama_barang-0');
                    kode_partdetail.value = sparepart_id.kode_partdetail;
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
                    var kode_partdetail = document.getElementById('nama_barang-' + key);
                    kode_partdetail.value = response.kode_partdetail;
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
            if (jumlah_ban < 3) { // Cek apakah jumlah_ban kurang dari 3
                jumlah_ban++; // Tambahkan 1 ke jumlah_ban
                if (jumlah_ban === 1) {
                    $('#tabel-pembelian').empty();
                }
                itemPembelian(jumlah_ban, jumlah_ban - 1, true);
            } else {
                // Jumlah penambahan mencapai batas maksimum (3), tindakan lain dapat diambil di sini jika diperlukan.
                alert('Anda telah mencapai batas maksimum (3) penambahan.');
            }
        }


        function removeBan(params) {
            jumlah_ban = jumlah_ban - 1;

            console.log(jumlah_ban);

            var tabel_pesanan = document.getElementById('tabel-pembelian');
            var pembelian = document.getElementById('pembelian-' + params);

            tabel_pesanan.removeChild(pembelian);

            if (jumlah_ban === 0) {
                var item_pembelian = '<tr>';
                item_pembelian += '<td class="text-center" colspan="8">- Part belum ditambahkan -</td>';
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
            var kategori = '';
            var sparepart_id = '';
            var nama_barang = '';
            // var keterangan = '';
            var jumlah = '';

            if (value !== null) {
                kategori = value.kategori;
                sparepart_id = value.sparepart_id;
                nama_barang = value.nama_barang;
                // keterangan = value.keterangan;
                jumlah = value.jumlah;
            }

            console.log(kategori);
            // urutan 
            var item_pembelian = '<tr id="pembelian-' + urutan + '">';
            item_pembelian += '<td class="text-center" id="urutan">' + urutan + '</td>';
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">';
            item_pembelian += '<select class="form-control" id="kategori-' + key +
                '" name="kategori[]">';
            item_pembelian += '<option value="">Pilih</option>';
            item_pembelian += '<option value="Oli Mesin"' + (kategori === 'Oli Mesin' ? ' selected' : '') +
                '>Oli Mesin</option>';
            item_pembelian += '<option value="Oli Gardan"' + (kategori === 'Oli Gardan' ? ' selected' : '') +
                '>Oli Gardan</option>';
            item_pembelian += '<option value="Oli Transmisi"' + (kategori === 'Oli Transmisi' ? ' selected' : '') +
                '>Oli Transmisi</option>';
            item_pembelian += '</select>';
            item_pembelian += '</div>';
            item_pembelian += '</td>';
            item_pembelian += '<td style="width: 240px">';
            item_pembelian += '<div class="form-group">';
            item_pembelian += '<select class="form-control select2bs4" id="sparepart_id-' + key +
                '" name="sparepart_id[]"onchange="getDataarray(' + key + ')">';
            item_pembelian += '<option value="">Cari Part..</option>';
            item_pembelian += '@foreach ($spareparts as $sparepart_id)';
            item_pembelian +=
                '<option value="{{ $sparepart_id->id }}" {{ $sparepart_id->id == ' + sparepart_id + ' ? 'selected' : '' }}>{{ $sparepart_id->nama_barang }}</option>';
            item_pembelian += '@endforeach';
            item_pembelian += '</select>';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // Nama Barang 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">';
            item_pembelian += '<input type="text" readonly class="form-control" id="nama_barang-' + key +
                '" name="nama_barang[]" value="' +
                nama_barang +
                '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // harga
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">';
            item_pembelian += '<input type="text" class="form-control" id="jumlah-' + key + '" name="jumlah[]" value="' +
                jumlah + '" onkeypress="return isNumberKey(event)">';
            item_pembelian += '</div>';
            item_pembelian += '</td>';


            // delete
            item_pembelian += '<td>';
            item_pembelian += '<button type="button" class="btn btn-danger" onclick="removeBan(' + urutan + ')">';
            item_pembelian += '<i class="fas fa-trash"></i>';
            item_pembelian += '</button>';
            item_pembelian += '</td>';
            item_pembelian += '</tr>';

            //     $('#tabel-pembelian').append(item_pembelian);

            //     if (value !== null) {
            //         $('#kategori-' + key).val(value.kategori);
            //         $('#sparepart_id-' + key).val(value.sparepart_id);
            //         $('#nama_barang-' + key).val(value.nama_barang);
            //         // $('#keterangan-' + key).val(value.keterangan);
            //         $('#jumlah-' + key).val(value.jumlah);
            //     }
            // }
            if (style) {
                select2(key);
            }

            $('#tabel-pembelian').append(item_pembelian);

            $('#sparepart_id-' + key + '').val(sparepart_id).attr('selected', true);
        }

        function select2(id) {
            $(function() {
                $('#sparepart_id-' + id).select2({
                    theme: 'bootstrap4'
                });
            });
        }

        function getData2(id) {
            var sparepart_id = document.getElementById('spareparts_id-0');
            $.ajax({
                url: "{{ url('admin/pembelian_part/sparepart') }}" + "/" + sparepart_id.value,
                type: "GET",
                dataType: "json",
                success: function(sparepart_id) {
                    var kode_partdetail = document.getElementById('nama_barang2-0');
                    kode_partdetail.value = sparepart_id.kode_partdetail;
                },
            });
        }

        function getDataarray2(key) {
            var sparepart_id = document.getElementById('spareparts_id-' + key);
            $.ajax({
                url: "{{ url('admin/pembelian_part/sparepart') }}" + "/" + sparepart_id.value,
                type: "GET",
                dataType: "json",
                success: function(response) {
                    var kode_partdetail = document.getElementById('nama_barang2-' + key);
                    kode_partdetail.value = response.kode_partdetail;
                },
            });
        }

        var data_pembelian = @json(session('data_pembelians2'));
        var jumlah_ban2 = 1;

        if (data_pembelian != null) {
            jumlah_ban2 = data_pembelian.length;
            $('#tabel-pembelian2').empty();
            var urutan = 0;
            $.each(data_pembelian, function(key, value) {
                urutan = urutan + 1;
                itemPembelian2(urutan, key, false, value);
            });
        }

        function addPesanan2() {
            if (jumlah_ban2 < 4) { // Cek apakah jumlah_ban kurang dari 3
                jumlah_ban2++; // Tambahkan 1 ke jumlah_ban
                if (jumlah_ban2 === 1) {
                    $('#tabel-pembelian2').empty();
                }
                itemPembelian2(jumlah_ban2, jumlah_ban2 - 1, true);
            } else {
                // Jumlah penambahan mencapai batas maksimum (3), tindakan lain dapat diambil di sini jika diperlukan.
                alert('Anda telah mencapai batas maksimum (4) penambahan.');
            }
        }


        function removeBan2(params) {
            jumlah_ban2 = jumlah_ban2 - 1;

            console.log(jumlah_ban2);

            var tabel_pesanan = document.getElementById('tabel-pembelian2');
            var pembelian = document.getElementById('pembelian2-' + params);

            tabel_pesanan.removeChild(pembelian);

            if (jumlah_ban2 === 0) {
                var item_pembelian = '<tr>';
                item_pembelian += '<td class="text-center" colspan="8">- Part belum ditambahkan -</td>';
                item_pembelian += '</tr>';
                $('#tabel-pembelian2').html(item_pembelian);
            } else {
                var urutan = document.querySelectorAll('#urutan2');
                for (let i = 0; i < urutan.length; i++) {
                    urutan[i].innerText = i + 1;
                }
            }
        }

        function itemPembelian2(urutan, key, style, value = null) {
            var kategori2 = '';
            var spareparts_id = '';
            var nama_barang2 = '';
            // var keterangan = '';
            var jumlah2 = '';

            if (value !== null) {
                kategori2 = value.kategori2;
                spareparts_id = value.spareparts_id;
                nama_barang2 = value.nama_barang2;
                // keterangan = value.keterangan;
                jumlah2 = value.jumlah2;
            }

            console.log(kategori2);
            // urutan 
            var item_pembelian = '<tr id="pembelian2-' + urutan + '">';
            item_pembelian += '<td class="text-center" id="urutan2">' + urutan + '</td>';
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">';
            item_pembelian += '<select class="form-control" id="kategori2-' + key +
                '" name="kategori2[]">';
            item_pembelian += '<option value="">Pilih</option>';
            item_pembelian += '<option value="Filter Oli"' + (kategori2 === 'Filter Oli' ? ' selected' : '') +
                '>Filter Oli</option>';
            item_pembelian += '<option value="Filter Solar Atas"' + (kategori2 === 'Filter Solar Atas' ? ' selected' : '') +
                '>Filter Solar Atas</option>';
            item_pembelian += '<option value="Filter Solar Bawah"' + (kategori2 === 'Filter Solar Bawah' ? ' selected' :
                    '') +
                '>Filter Solar Bawah</option>';
            item_pembelian += '<option value="Filter Angin"' + (kategori2 === 'Filter Angin' ? ' selected' :
                    '') +
                '>Filter Angin</option>';
            item_pembelian += '<option value="Gemuk"' + (kategori2 === 'Gemuk' ? ' selected' :
                    '') +
                '>Gemuk</option>';
            item_pembelian += '</select>';
            item_pembelian += '</div>';
            item_pembelian += '</td>';
            item_pembelian += '<td style="width: 240px">';
            item_pembelian += '<div class="form-group">';
            item_pembelian += '<select class="form-control select2bs4" id="spareparts_id-' + key +
                '" name="spareparts_id[]"onchange="getDataarray2(' + key + ')">';
            item_pembelian += '<option value="">Cari Filter..</option>';
            item_pembelian += '@foreach ($spareparts as $spareparts_id)';
            item_pembelian +=
                '<option value="{{ $spareparts_id->id }}" {{ $spareparts_id->id == ' + spareparts_id + ' ? 'selected' : '' }}>{{ $spareparts_id->nama_barang }}</option>';
            item_pembelian += '@endforeach';
            item_pembelian += '</select>';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // Nama Barang 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">';
            item_pembelian += '<input type="text" readonly class="form-control" id="nama_barang2-' + key +
                '" name="nama_barang2[]" value="' +
                nama_barang2 +
                '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // harga
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">';
            item_pembelian += '<input type="text" class="form-control" id="jumlah2-' + key + '" name="jumlah2[]" value="' +
                jumlah2 + '" onkeypress="return isNumberKey(event)">';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // delete
            item_pembelian += '<td>';
            item_pembelian += '<button type="button" class="btn btn-danger" onclick="removeBan2(' + urutan + ')">';
            item_pembelian += '<i class="fas fa-trash"></i>';
            item_pembelian += '</button>';
            item_pembelian += '</td>';
            item_pembelian += '</tr>';

            //     $('#tabel-pembelian').append(item_pembelian);

            //     if (value !== null) {
            //         $('#kategori-' + key).val(value.kategori);
            //         $('#sparepart_id-' + key).val(value.sparepart_id);
            //         $('#nama_barang-' + key).val(value.nama_barang);
            //         // $('#keterangan-' + key).val(value.keterangan);
            //         $('#jumlah-' + key).val(value.jumlah);
            //     }
            // }
            if (style) {
                select22(key);
            }

            $('#tabel-pembelian2').append(item_pembelian);

            $('#spareparts_id-' + key + '').val(spareparts_id).attr('selected', true);
        }

        function select22(id) {
            $(function() {
                $('#spareparts_id-' + id).select2({
                    theme: 'bootstrap4'
                });
            });
        }
    </script>

    <script>
        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode;
            if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }
    </script>

@endsection
