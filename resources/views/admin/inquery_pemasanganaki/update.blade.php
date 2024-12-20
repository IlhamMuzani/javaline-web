@extends('layouts.app')

@section('title', 'Inquery Pemasangan Aki')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Inquery Pemasangan Aki</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/inquery-pemasanganaki') }}">Operasional</a></li>
                        <li class="breadcrumb-item active">Inquery Pemasangan Aki</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
        <div class="container-fluid">
            @if (session('errormax'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-check"></i> Gagal!
                    </h5>
                    {{ session('errormax') }}
                </div>
            @endif
            @if (session('error_pelanggans') || session('error_pesanans'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-ban"></i> Gagal!
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
                        <i class="icon fas fa-check"></i> Berhasil!
                    </h5>
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-ban"></i> Gagal!
                    </h5>
                    @foreach (session('error') as $error)
                        - {{ $error }} <br>
                    @endforeach
                </div>
            @endif
            <form action="{{ url('admin/inquery-pemasanganaki/' . $inquery->id) }}" method="post" autocomplete="off">
                @csrf
                @method('put')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Inquery Pemasangan Aki</h3>
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
                                        {{ old('kendaraan_id', $inquery->kendaraan_id) == $kendaraan_id->id ? 'selected' : '' }}>
                                        {{ $kendaraan_id->no_kabin }}</option>
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="alamat">No Registrasi</label>
                            <input type="text" class="form-control" readonly id="no_pol" name="no_pol"
                                value="{{ $inquery->kendaraan->no_pol }}">
                        </div>
                        <div class="form-group">
                            <label for="alamat">Jenis Kendaraan</label>
                            <input type="text" class="form-control" readonly id="jenis_kendaraan" name="jenis_kendaraan"
                                value="{{ $inquery->kendaraan->jenis_kendaraan->nama_jenis_kendaraan }}">
                        </div>
                        <div class="form-group">
                            <label>Tanggal Pemasangan:</label>
                            <div class="input-group date" id="reservationdatetime">
                                <input type="date" id="tanggal_awal" name="tanggal_awal" placeholder="d M Y sampai d M Y"
                                    data-options='{"mode":"range","dateFormat":"d M Y","disableMobile":true}'
                                    value="{{ old('tanggal_awal', $inquery->tanggal_awal) }}" max = "{{ date('Y-m-d') }}"
                                    class="form-control datetimepicker-input" data-target="#reservationdatetime">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Aki</h3>
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
                                    <th>Kode Aki</th>
                                    <th>Nama Aki</th>
                                    <th>Merek Aki</th>
                                    <th>Keterangan</th>
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
                                                <select class="form-control" id="aki_id-{{ $loop->index }}"
                                                    name="aki_id[]">
                                                    <option value="">- Pilih Aki -</option>
                                                    @foreach ($spareparts as $aki_id)
                                                        <option value="{{ $aki_id->id }}"
                                                            {{ old('aki_id.' . $loop->parent->index, $detail['aki_id']) == $aki_id->id ? 'selected' : '' }}>
                                                            {{ $aki_id->no_seri }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input readonly type="text" class="form-control"
                                                    id="kode_aki-{{ $loop->index }}" name="kode_aki[]"
                                                    value="{{ $detail['kode_aki'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input readonly type="text" class="form-control"
                                                    id="merek-{{ $loop->index }}" name="merek[]"
                                                    value="{{ $detail['merek'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <select class="form-control" id="keterangan-{{ $loop->index }}"
                                                    name="keterangan[]">
                                                    <option value="">- Pilih -</option>
                                                    <option value="Pemasangan Baru"
                                                        {{ old('Pemasangan Baru', $detail['keterangan']) == 'Pemasangan Baru' ? 'selected' : null }}>
                                                        Pemasangan Baru</option>
                                                    <option value="Pergantian Rusak"
                                                        {{ old('Pergantian Rusak', $detail['keterangan']) == 'Pergantian Rusak' ? 'selected' : null }}>
                                                        Pergantian Rusak</option>
                                                </select>
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

                },
            });
        }


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

                },
            });
        }

        function getData1(id) {
            var aki_id = document.getElementById('aki_id-0');
            $.ajax({
                url: "{{ url('admin/pembelian-aki/aki') }}" + "/" + aki_id.value,
                type: "GET",
                dataType: "json",
                success: function(aki_id) {
                    var kode_aki = document.getElementById('kode_aki-0');
                    kode_aki.value = aki_id.kode_aki;
                    var merek = document.getElementById('merek-0');
                    merek.value = aki_id.merek_aki.nama_merek;
                },
            });
        }

        function getDataarray(key) {
            var aki_id = document.getElementById('aki_id-' + key);
            $.ajax({
                url: "{{ url('admin/pembelian-aki/aki') }}" + "/" + aki_id.value,
                type: "GET",
                dataType: "json",
                success: function(response) {
                    var kode_aki = document.getElementById('kode_aki-' + key);
                    kode_aki.value = response.kode_aki;
                    var merek = document.getElementById('merek-' + key);
                    merek.value = response.merek_aki.nama_merek;
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
                url: "{{ url('admin/inquery-pemasanganaki/deleteakidetail/') }}/" + detailId,
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
            var aki_id = '';
            var kode_aki = '';
            var merek = '';
            var keterangan = '';

            if (value !== null) {
                aki_id = value.aki_id;
                kode_aki = value.kode_aki;
                merek = value.merek;
                keterangan = value.keterangan;

            }

            console.log(aki_id);
            // urutan 
            var item_pembelian = '<tr id="pembelian-' + urutan + '">';
            item_pembelian += '<td class="text-center" id="urutan">' + urutan + '</td>';
            item_pembelian += '<td style="width: 240px">';

            // aki_id 
            item_pembelian += '<div class="form-group">';
            item_pembelian += '<select class="form-control select2bs4" id="aki_id-' + key +
                '" name="aki_id[]" onchange="getDataarray(' + key + ')">';
            item_pembelian += '<option value="">- Pilih Aki -</option>';
            item_pembelian += '@foreach ($spareparts as $aki_id)';
            item_pembelian +=
                '<option value="{{ $aki_id->id }}" {{ $aki_id->id == ' + aki_id + ' ? 'selected' : '' }}>{{ $aki_id->no_seri }}</option>';
            item_pembelian += '@endforeach';
            item_pembelian += '</select>';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // kode_aki
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" readonly id="kode_aki-' + key +
                '" name="kode_aki[]" value="' +
                kode_aki +
                '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // merek
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" readonly id="merek-' + key +
                '" name="merek[]" value="' +
                merek +
                '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // keterangan
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">';
            item_pembelian += '<select class="form-control" id="keterangan-' + key + '" name="keterangan[]">';
            item_pembelian += '<option value="">- Pilih Kondisi -</option>';
            item_pembelian += '<option value="Pemasangan Baru"' + (keterangan === 'Pemasangan Baru' ? ' selected' : '') +
                '>Pemasangan Baru</option>';
            item_pembelian += '<option value="Pergantian Rusak"' + (keterangan === 'Pergantian Rusak' ? ' selected' : '') +
                '>Pergantian Rusak</option>';
            item_pembelian += '</select>';
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
                $('#aki_id-' + key).val(value.aki_id);
                $('#kode_aki-' + key).val(value.kode_aki);
                $('#keterangan-' + key).val(value.keterangan);
            }
        }

        var tanggalAkhir = document.getElementById('tanggal_awal');

        if (this.value == "") {
            tanggalAkhir.readOnly = true;
        } else {
            tanggalAkhir.readOnly = false;
        }
        tanggalAkhir.value = "";
        var today = new Date().toISOString().split('T')[0];
        tanggalAkhir.value = today;
        tanggalAkhir.setAttribute('min', this.value);
    </script>
@endsection
