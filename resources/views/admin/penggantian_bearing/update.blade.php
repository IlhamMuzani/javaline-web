@extends('layouts.app')

@section('title', 'Penggantian Bearing')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Penggantian Bearing</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/penggantian_bearing') }}">Penggantian Bearing</a>
                        </li>
                        <li class="breadcrumb-item active">Tambah</li>
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
            @if (session('errors'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-check"></i> Success!
                    </h5>
                    @foreach (session('errors') as $errors)
                        - {{ $errors }} <br>
                    @endforeach
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
            <form action="{{ url('admin/pemasangan_ban/' . $kendaraan->id) }}" method="POST" enctype="multipart/form-data"
                autocomplete="off">
                @csrf
                @method('put')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Penggantian Bearing</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nopol">No. Kabin</label>
                            <input type="text" class="form-control" id="no_pol" name="no_pol" readonly
                                placeholder="Masukan no registrasi kendaraan" value="{{ $kendaraan->no_kabin }}">
                        </div>
                        <div class="form-group">
                            <label for="nopol">No. Registrasi Kendaraan</label>
                            <input type="text" class="form-control" id="no_pol" name="no_pol" readonly
                                placeholder="Masukan no registrasi kendaraan" value="{{ $kendaraan->no_pol }}">
                        </div>
                        <div class="form-group" id="layoutjenis">
                            <label for="jenis_kendaraan">Jenis Kendaraan</label>
                            <input type="text" class="form-control" id="jenis_kendaraan" name="jenis_kendaraan" readonly
                                placeholder="Masukan jenis kendaraan"
                                value="{{ $kendaraan->jenis_kendaraan->nama_jenis_kendaraan ?? null }}">
                        </div>
                        <div class="form-group">
                            <label for="alamat">Km Penggantian</label>
                            <input type="number" class="form-control" id="km" name="km"
                                value="{{ old('km') }}">
                        </div>
                    </div>
                    {{-- <div class="card-footer text-right">
                        <button type="reset" class="btn btn-secondary">Reset</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div> --}}
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Posisi Bearing</h3>
                    </div>
                    <div class="row">
                        <div class="ml-3">
                            <div class="card-body">
                                <div class="col">
                                    {{-- baris axle 1  --}}
                                    <div class="row mb-5">
                                        <div class="row">
                                            <div class="form-group mt-2" style="text-align: center;">
                                                <div>
                                                    <img class="" src="{{ asset('storage/uploads/karyawan/1A.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>

                                            <div class="form-group mt-3" style="text-align: center;">
                                                <label>Axle 1</label>
                                                <div class="">
                                                    <img class="mt-1"
                                                        src="{{ asset('storage/uploads/karyawan/axle.png') }}"
                                                        alt="AdminLTELogo" height="20" width="200">
                                                </div>
                                            </div>
                                            <div class="form-group mt-2" style="text-align: center;">
                                                <div>
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/karyawan/1B.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="row">
                                            <div class="form-group mt-2" style="text-align: center;">
                                                <div>
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/karyawan/2A.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>

                                            <div class="form-group mt-3" style="text-align: center;">
                                                <label>Axle 2</label>
                                                <div class="">
                                                    <img class="mt-1"
                                                        src="{{ asset('storage/uploads/karyawan/axle.png') }}"
                                                        alt="AdminLTELogo" height="20" width="200">
                                                </div>
                                            </div>
                                            <div class="form-group mt-2" style="text-align: center;">
                                                <div>
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/karyawan/2B.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="row">
                                            <div class="form-group mt-2" style="text-align: center;">
                                                <div>
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/karyawan/3A.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>

                                            <div class="form-group mt-3" style="text-align: center;">
                                                <label>Axle 3</label>
                                                <div class="">
                                                    <img class="mt-1"
                                                        src="{{ asset('storage/uploads/karyawan/axle.png') }}"
                                                        alt="AdminLTELogo" height="20" width="200">
                                                </div>
                                            </div>
                                            <div class="form-group mt-2" style="text-align: center;">
                                                <div>
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/karyawan/3B.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="row">
                                            <div class="form-group mt-2" style="text-align: center;">
                                                <div>
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/karyawan/4A.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>

                                            <div class="form-group mt-3" style="text-align: center;">
                                                <label>Axle 4</label>
                                                <div class="">
                                                    <img class="mt-1"
                                                        src="{{ asset('storage/uploads/karyawan/axle.png') }}"
                                                        alt="AdminLTELogo" height="20" width="200">
                                                </div>
                                            </div>
                                            <div class="form-group mt-2" style="text-align: center;">
                                                <div>
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/karyawan/4B.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="row">
                                            <div class="form-group mt-2" style="text-align: center;">
                                                <div>
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/karyawan/5A.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>

                                            <div class="form-group mt-3" style="text-align: center;">
                                                <label>Axle 5</label>
                                                <div class="">
                                                    <img class="mt-1"
                                                        src="{{ asset('storage/uploads/karyawan/axle.png') }}"
                                                        alt="AdminLTELogo" height="20" width="200">
                                                </div>
                                            </div>
                                            <div class="form-group mt-2" style="text-align: center;">
                                                <div>
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/karyawan/5B.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="row">
                                            <div class="form-group mt-2" style="text-align: center;">
                                                <div>
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/karyawan/6A.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>

                                            <div class="form-group mt-3" style="text-align: center;">
                                                <label>Axle 6</label>
                                                <div class="">
                                                    <img class="mt-1"
                                                        src="{{ asset('storage/uploads/karyawan/axle.png') }}"
                                                        alt="AdminLTELogo" height="20" width="200">
                                                </div>
                                            </div>
                                            <div class="form-group mt-2" style="text-align: center;">
                                                <div>
                                                    <img class=""
                                                        src="{{ asset('storage/uploads/karyawan/6B.png') }}"
                                                        alt="AdminLTELogo" height="100" width="40">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Penggantian Bearing <span>
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
                                                <th style="font-size:14px">Posisi</th>
                                                <th style="font-size:14px">Kode Part</th>
                                                <th style="font-size:14px">Nama Part</th>
                                                <th style="font-size:14px">Opsi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tabel-pembelian">
                                            <tr id="pembelian-0">
                                                <td style="width: 70px; font-size:14px" class="text-center"
                                                    id="urutan">1
                                                </td>

                                                <td hidden>
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" class="form-control"
                                                            id="sparepart_id-0" name="sparepart_id[]">
                                                    </div>
                                                </td>
                                                <td onclick="addAkun(0)">
                                                    <div class="form-group">
                                                        <select class="form-control" id="kategori-0" name="kategori[]">
                                                            <option value="">- Pilih Kategori -</option>
                                                            <option value="Axle 1A"
                                                                {{ old('kategori') == 'Axle 1A' ? 'selected' : null }}>
                                                                Axle 1A</option>
                                                            <option value="Axle 1B"
                                                                {{ old('kategori') == 'Axle 1B' ? 'selected' : null }}>
                                                                Axle 1B</option>
                                                            <option value="Axle 2A"
                                                                {{ old('kategori') == 'Axle 2A' ? 'selected' : null }}>
                                                                Axle 2A</option>
                                                            <option value="Axle 2B"
                                                                {{ old('kategori') == 'Axle 2B' ? 'selected' : null }}>
                                                                Axle 2B</option>
                                                            <option value="Axle 3A"
                                                                {{ old('kategori') == 'Axle 3A' ? 'selected' : null }}>
                                                                Axle 3A</option>
                                                            <option value="Axle 3B"
                                                                {{ old('kategori') == 'Axle 3B' ? 'selected' : null }}>
                                                                Axle 3B</option>
                                                            <option value="Axle 4A"
                                                                {{ old('kategori') == 'Axle 4A' ? 'selected' : null }}>
                                                                Axle 4A</option>
                                                            <option value="Axle 4B"
                                                                {{ old('kategori') == 'Axle 4B' ? 'selected' : null }}>
                                                                Axle 4B</option>
                                                            <option value="Axle 5A"
                                                                {{ old('kategori') == 'Axle 5A' ? 'selected' : null }}>
                                                                Axle 5A</option>
                                                            <option value="Axle 5B"
                                                                {{ old('kategori') == 'Axle 5B' ? 'selected' : null }}>
                                                                Axle 5B</option>
                                                            <option value="Axle 6A"
                                                                {{ old('kategori') == 'Axle 6A' ? 'selected' : null }}>
                                                                Axle 6A</option>
                                                            <option value="Axle 6B"
                                                                {{ old('kategori') == 'Axle 6B' ? 'selected' : null }}>
                                                                Axle 6B</option>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td onclick="addAkun(0)">
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" readonly
                                                            class="form-control" id="kode_part-0" name="kode_part[]">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" readonly
                                                            class="form-control" id="nama_part-0" name="nama_part[]">
                                                    </div>
                                                </td>
                                                <td style="width: 100px">
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        onclick="addAkun(0)">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                    <button style="margin-left:5px" type="button"
                                                        class="btn btn-danger btn-sm" onclick="removePesanan(0)">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>

                                    </table>
                                    <h3 style="font-size: 17px; margin-top:30px">Tambahkan Gris</h3>
                                    <table class="table table-bordered table-striped ">
                                        <thead>
                                            <tr>
                                                <th style="font-size:14px" class="text-center">No</th>
                                                <th style="font-size:14px">Kode Part</th>
                                                <th style="font-size:14px">Nama Part</th>
                                                <th style="font-size:14px">Jumlah</th>
                                                <th style="font-size:14px">Opsi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="width: 70px; font-size:14px" class="text-center">1
                                                </td>

                                                <td>
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" readonly
                                                            class="form-control" id="kode_gris" name="kode_gris">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" readonly
                                                            class="form-control" id="nama_gris" name="nama_gris">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="text" class="form-control"
                                                            id="jumlah" name="jumlah">
                                                    </div>
                                                </td>
                                                <td style="width: 100px">
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        onclick="addAkun(0)">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                    <button style="margin-left:5px" type="button"
                                                        class="btn btn-danger btn-sm" onclick="removePesanan(0)">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>

                                    </table>
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
        </div>
    </section>

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

        function addPesanan() {
            jumlah_ban = jumlah_ban + 1;

            if (jumlah_ban === 1) {
                $('#tabel-pembelian').empty();
            }

            itemPembelian(jumlah_ban, jumlah_ban - 1);
        }

        function removePesanan(params) {
            jumlah_ban = jumlah_ban - 1;

            var tabel_pesanan = document.getElementById('tabel-pembelian');
            var pembelian = document.getElementById('pembelian-' + params);

            tabel_pesanan.removeChild(pembelian);

            if (jumlah_ban === 0) {
                var item_pembelian = '<tr>';
                item_pembelian += '<td class="text-center" colspan="5">- Akun belum ditambahkan -</td>';
                item_pembelian += '</tr>';
                $('#tabel-pembelian').html(item_pembelian);
            } else {
                var urutan = document.querySelectorAll('#urutan');
                for (let i = 0; i < urutan.length; i++) {
                    urutan[i].innerText = i + 1;
                }
            }
            updateGrandTotal()
        }

        function itemPembelian(urutan, key, value = null) {
            var sparepart_id = '';
            var kategori = '';
            var kode_part = '';
            var nama_part = '';

            if (value !== null) {
                sparepart_id = value.sparepart_id;
                kategori = value.kategori;
                kode_part = value.kode_part;
                nama_part = value.nama_part;
            }

            // urutan 
            var item_pembelian = '<tr id="pembelian-' + urutan + '">';
            item_pembelian += '<td style="width: 70px; font-size:14px" class="text-center" id="urutan-' + urutan +
                '">' +
                urutan + '</td>';

            // sparepart_id 
            item_pembelian += '<td hidden>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" style="font-size:14px" id="sparepart_id-' +
                urutan +
                '" name="sparepart_id[]" value="' + sparepart_id + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // kategori 
            item_pembelian += '<td onclick="addAkun(' + urutan +
                ')">';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<select class="form-control" id="kategori-' + key + '" name="kategori[]">';
            item_pembelian += '<option value="">- Pilih Kategori -</option>';
            item_pembelian += '<option value="Axle 1A"' + (kategori === 'Axle 1A' ? ' selected' : '') + '>Axle 1A</option>';
            item_pembelian += '<option value="Axle 1B"' + (kategori === 'Axle 1B' ? ' selected' : '') +
                '>Axle 1B</option>';
            item_pembelian += '<option value="Axle 2A"' + (kategori === 'Axle 2A' ? ' selected' : '') +
                '>Axle 2A</option>';
            item_pembelian += '<option value="Axle 2B"' + (kategori === 'Axle 2B' ? ' selected' : '') +
                '>Axle 2B</option>';
            item_pembelian += '<option value="Axle 3A"' + (kategori === 'Axle 3A' ? ' selected' : '') +
                '>Axle 3A</option>';
            item_pembelian += '<option value="Axle 3B"' + (kategori === 'Axle 3B' ? ' selected' : '') +
                '>Axle 3B</option>';
            item_pembelian += '<option value="Axle 4A"' + (kategori === 'Axle 4A' ? ' selected' : '') +
                '>Axle 4A</option>';
            item_pembelian += '<option value="Axle 4B"' + (kategori === 'Axle 4B' ? ' selected' : '') +
                '>Axle 4B</option>';
            item_pembelian += '<option value="Axle 5A"' + (kategori === 'Axle 5A' ? ' selected' : '') +
                '>Axle 5A</option>';
            item_pembelian += '<option value="Axle 5B"' + (kategori === 'Axle 5B' ? ' selected' : '') +
                '>Axle 5B</option>';
            item_pembelian += '<option value="Axle 6A"' + (kategori === 'Axle 6A' ? ' selected' : '') +
                '>Axle 6A</option>';
            item_pembelian += '<option value="Axle 6B"' + (kategori === 'Axle 6B' ? ' selected' : '') +
                '>Axle 6B</option>';
            item_pembelian += '</select>';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // kode_part 
            item_pembelian += '<td onclick="addAkun(' + urutan +
                ')">';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" readonly style="font-size:14px" id="kode_part-' +
                urutan +
                '" name="kode_part[]" value="' + kode_part + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // nama_part 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" style="font-size:14px" readonly id="nama_part-' +
                urutan +
                '" name="nama_part[]" value="' + nama_part + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';


            item_pembelian += '<td style="width: 100px">';
            item_pembelian += '<button type="button" class="btn btn-primary btn-sm" onclick="addAkun(' + urutan +
                ')">';
            item_pembelian += '<i class="fas fa-plus"></i>';
            item_pembelian += '</button>';
            item_pembelian +=
                '<button style="margin-left:10px" type="button" class="btn btn-danger btn-sm" onclick="removePesanan(' +
                urutan + ')">';
            item_pembelian += '<i class="fas fa-trash"></i>';
            item_pembelian += '</button>';
            item_pembelian += '</td>';
            item_pembelian += '</tr>';

            $('#tabel-pembelian').append(item_pembelian);
        }
    </script>
@endsection
