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
                                    {{-- <th>Keterangan</th> --}}
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
                                    {{-- <td>
                                        <div class="form-group">
                                            <select class="form-control" id="keterangan-0" name="keterangan[]"
                                                onchange="showCategoryModal(this.value)">
                                                <option value="">Pilih</option>
                                                <option value="Pergantian Baru"
                                                    {{ old('keterangan') == 'Pergantian Baru' ? 'selected' : null }}>
                                                    Pergantian Baru</option>
                                                <option value="Pergantian -"
                                                    {{ old('keterangan') == 'Pergantian -' ? 'selected' : null }}>
                                                    Pergantian - </option>
                                            </select>
                                        </div>
                                    </td> --}}
                                    <td>
                                        <div class="form-group">
                                            <input type="number" class="form-control" id="jumlah-0" name="jumlah[]">
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
                itemPembelian(urutan, key, value);
            });
        }

        function addPesanan() {
            if (jumlah_ban < 3) { // Cek apakah jumlah_ban kurang dari 3
                jumlah_ban++; // Tambahkan 1 ke jumlah_ban
                if (jumlah_ban === 1) {
                    $('#tabel-pembelian').empty();
                }
                itemPembelian(jumlah_ban, jumlah_ban - 1);
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

        function itemPembelian(urutan, key, value = null) {
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

            // keterangan
            // item_pembelian += '<td>';
            // item_pembelian += '<div class="form-group">';
            // item_pembelian += '<select class="form-control" id="keterangan-' + key +
            //     '" name="keterangan[]">';
            // item_pembelian += '<option value="">Pilih</option>';
            // item_pembelian += '<option value="Pergantian Baru"' + (keterangan === 'Pergantian Baru' ? ' selected' : '') +
            //     '>Pergantian Baru</option>';
            // item_pembelian += '<option value="Pergantian -"' + (keterangan === 'Pergantian -' ? ' selected' : '') +
            //     '>Pergantian -</option>';
            // item_pembelian += '</select>';
            // item_pembelian += '</div>';
            // item_pembelian += '</td>';

            // harga
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">';
            item_pembelian += '<input type="number" class="form-control" id="jumlah-' + key +
                '" name="jumlah[]" value="' +
                jumlah +
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
                $('#sparepart_id-' + key).val(value.sparepart_id);
                $('#nama_barang-' + key).val(value.nama_barang);
                // $('#keterangan-' + key).val(value.keterangan);
                $('#jumlah-' + key).val(value.jumlah);
            }
        }
    </script>
@endsection
