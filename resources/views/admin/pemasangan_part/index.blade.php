@extends('layouts.app')

@section('title', 'Pemasangan Part')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Pemasangan Part</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/pemasangan_part') }}">Operasional</a></li>
                        <li class="breadcrumb-item active">Pemasangan Part</li>
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
            <form action="{{ url('admin/pemasangan_part') }}" method="post" autocomplete="off">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Pemasangan Part</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group" style="flex: 8;">
                            <label for="kendaraan_id">No Kabin</label>
                            <select class="select2bs4 select2-hidden-accessible" name="kendaraan_id"
                                data-placeholder="Cari Kabin.." style="width: 100%;" data-select2-id="23" tabindex="-1"
                                aria-hidden="true" id="kendaraan_id" onchange="getData(0)">
                                <option value="">- Pilih -</option>
                                @foreach ($kendaraans as $kendaraan_id)
                                    <option value="{{ $kendaraan_id->id }}"
                                        {{ old('kendaraan_id') == $kendaraan_id->id ? 'selected' : '' }}>
                                        {{ $kendaraan_id->no_kabin }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="alamat">No Registrasi</label>
                            <input type="text" class="form-control" readonly id="no_pol" name="no_pol" value="{{ old('no_pol') }}">
                        </div>
                        <div class="form-group">
                            <label for="alamat">Jenis Kendaraan</label>
                            <input type="text" class="form-control" readonly id="jenis_kendaraan" name="jenis_kendaraan" value="{{ old('jenis_kendaraan') }}">
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
                                    <th>Nama Part</th>
                                    <th>Kode Part</th>
                                    <th>Keterangan</th>
                                    <th>Jumlah</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody id="tabel-pembelian">
                                <tr id="pembelian-0">
                                    <td class="text-center" id="urutan">1</td>
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
                                            <select class="form-control" id="keterangan-0" name="keterangan[]"
                                                onchange="showCategoryModal(this.value)">
                                                <option value="">Pilih</option>
                                                <option value="Pemasangan Baru"
                                                    {{ old('keterangan') == 'Pemasangan Baru' ? 'selected' : null }}>
                                                    Pemasangan Baru</option>
                                                <option value="Pergantian Rusak"
                                                    {{ old('keterangan') == 'Pergantian Rusak' ? 'selected' : null }}>
                                                    Pergantian Rusak</option>
                                            </select>
                                        </div>
                                    </td>
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
        function getData(id) {
            var kendaraan_id = document.getElementById('kendaraan_id');
            $.ajax({
                url: "{{ url('admin/pelepasan_ban/kendaraan') }}" + "/" + kendaraan_id.value,
                type: "GET",
                dataType: "json",
                success: function(kendaraan_id) {
                    var no_pol = document.getElementById('no_pol');
                    no_pol.value = kendaraan_id.no_pol;

                    var jenis_kendaraan = document.getElementById('jenis_kendaraan');
                    jenis_kendaraan.value = kendaraan_id.jenis_kendaraan.nama_jenis_kendaraan;

                    // Simpan nilai no_pol dan jenis_kendaraan dalam localStorage
                    localStorage.setItem('noPolValue', no_pol.value);
                    localStorage.setItem('jenisKendaraanValue', jenis_kendaraan.value);
                },
            });
        }

        // Saat halaman dimuat (misalnya dalam document ready)
        $(document).ready(function() {
            // Ambil nilai dari localStorage
            var noPolValue = localStorage.getItem('noPolValue');
            var jenisKendaraanValue = localStorage.getItem('jenisKendaraanValue');

            // Isi elemen-elemen form dengan nilai-nilai tersebut
            // $('#no_pol').val(noPolValue);
            // $('#jenis_kendaraan').val(jenisKendaraanValue);
        });


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
            jumlah_ban = jumlah_ban + 1;

            if (jumlah_ban === 1) {
                $('#tabel-pembelian').empty();
            }

            itemPembelian(jumlah_ban, jumlah_ban - 1);
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
            var sparepart_id = '';
            var nama_barang = '';
            var keterangan = '';
            var jumlah = '';

            if (value !== null) {
                sparepart_id = value.sparepart_id;
                nama_barang = value.nama_barang;
                keterangan = value.keterangan;
                jumlah = value.jumlah;
            }

            console.log(sparepart_id);
            // urutan 
            var item_pembelian = '<tr id="pembelian-' + urutan + '">';
            item_pembelian += '<td class="text-center" id="urutan">' + urutan + '</td>';

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
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">';
            item_pembelian += '<select class="form-control" id="keterangan-' + key +
                '" name="keterangan[]">';
            item_pembelian += '<option value="">Pilih</option>';
            item_pembelian += '<option value="Pemasangan Baru"' + (keterangan === 'Pemasangan Baru' ? ' selected' : '') +
                '>Pemasangan Baru</option>';
            item_pembelian += '<option value="Pergantian Rusak"' + (keterangan === 'Pergantian Rusak' ? ' selected' : '') +
                '>Pergantian Rusak</option>';
            item_pembelian += '</select>';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

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
                $('#sparepart_id-' + key).val(value.sparepart_id);
                $('#nama_barang-' + key).val(value.nama_barang);
                $('#keterangan-' + key).val(value.keterangan);
                $('#jumlah-' + key).val(value.jumlah);
            }
        }
    </script>
@endsection
