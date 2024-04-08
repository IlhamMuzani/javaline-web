@extends('layouts.app')

@section('title', 'Tambah Pemasangan Part')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tambah Pemasangan Part</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/pemasangan_part') }}">Operasional</a></li>
                        <li class="breadcrumb-item active">Tambah Pemasangan Part</li>
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
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tabel Pemasangan Part</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                {{-- <th>Kode</th> --}}
                                <th>No. Kabin</th>
                                <th>Jenis Kendaraan</th>
                                {{-- <th class="text-center" width="90">Opsi</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($parts as $part)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    {{-- <td>{{ $part->id }}</td> --}}
                                    <td>{{ $part->kendaraan->no_kabin }}</td>
                                    <td>{{ $part->kendaraan->jenis_kendaraan->nama_jenis_kendaraan }}</td>
                                    {{-- <td class="text-center">
                                        <button type="submit" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#modal-hapus-{{ $part->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td> --}}
                                    <div class="modal fade" id="modal-hapus-{{ $part->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Hapus Pemasangan</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Yakin hapus
                                                        <strong>{{ $part->id }}</strong>?
                                                    </p>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">Batal</button>
                                                    <form action="{{ url('admin/hapus_part/' . $part->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-right">
                    <a href="{{ url('admin/pemasangan_part/' . $pemasangans->id) }}" class="btn btn-primary btn-sm">Lihat
                    </a>
                </div>
            </div>
            <form action="{{ url('admin/pemasangan_part/' . $pemasangans->id) }}" method="POST"
                enctype="multipart/form-data" autocomplete="off">
                @csrf
                @method('put')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Kabin</h3>
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
                                    <th>No Kabin</th>
                                    <th>No Pol</th>
                                    <th>Jenis Kendaraan</th>
                                    {{-- <th>Opsi</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="">
                                    <td style="width: 50px" class="text-center" id=""></td>
                                    <td style="width: 150px">
                                        <select class="select2bs4 select2-hidden-accessible" id="kendaraan_id-0"
                                            name="kendaraan_id" data-placeholder="Cari Kabin.." style="width: 100%;"
                                            data-select2-id="23" tabindex="-1" aria-hidden="true" onchange="getData(0)">
                                            <option value="">- Pilih -</option>
                                            @foreach ($kendaraans as $kendaraan_id)
                                                <option value="{{ $kendaraan_id->id }}">{{ $kendaraan_id->no_kabin }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" readonly class="form-control" id="no_pol-0"
                                                name="no_pol">
                                        </div>
                                    </td>
                                    <td  colspan="4">
                                        <div class="form-group">
                                            <input type="text" readonly class="form-control" id="jenis_kendaraan-0"
                                                name="jenis_kendaraan">
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody id="tabel-pembelian">
                                <tr id="pembelian-0">
                                    <td class="text-center" id="urutan">1</td>
                                    <td colspan="2">
                                        <div class="form-group">
                                            <select class="select2bs4 select21-hidden-accessible"
                                                id="sparepart_id-' + urutanspart + '" name="sparepart_id[]"
                                                data-placeholder="Cari Part.." style="width: 100%;" data-select21-id="23"
                                                tabindex="-1" aria-hidden="true">
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
                                            <input type="text" class="form-control" id="keterangan-0"
                                                name="keterangan[]" placeholder="Masukan keterangan">
                                        </div>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="removeParts(0)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- </div> --}}
                <div class="card-footer text-right">
                    <button type="reset" class="btn btn-secondary">Reset</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>

    </section>
    <script>
        function getData(id) {
            var kendaraan_id = document.getElementById('kendaraan_id-0');
            $.ajax({
                url: "{{ url('admin/pelepasan_ban/kendaraan') }}" + "/" + kendaraan_id.value,
                type: "GET",
                dataType: "json",
                success: function(kendaraan_id) {
                    var no_pol = document.getElementById('no_pol-0');
                    no_pol.value = kendaraan_id.no_pol;

                    var jenis_kendaraan = document.getElementById('jenis_kendaraan-0');
                    jenis_kendaraan.value = kendaraan_id.jenis_kendaraan.nama_jenis_kendaraan;
                },
            });
        }

        function getDataarray(key) {
            var kendaraan_id = document.getElementById('kendaraan_id-' + key);
            $.ajax({
                url: "{{ url('admin/pelepasan_ban/kendaraan') }}" + "/" + kendaraan_id.value,
                type: "GET",
                dataType: "json",
                success: function(response) {
                    var no_pol = document.getElementById('no_pol-' + key);
                    no_pol.value = response.no_pol;

                    var jenis_kendaraan = document.getElementById('jenis_kendaraan-' + key);
                    jenis_kendaraan.value = response.jenis_kendaraan.nama_jenis_kendaraan;
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

            itemPembelian(jumlah_ban, jumlah_ban - 1, true);
        }

        function removePart(params) {
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
            var sparepart_id = '';
            var keterangan = '';

            if (value !== null) {
                sparepart_id = value.sparepart_id;
                keterangan = value.keterangan;
            }

            console.log(sparepart_id);

            var item_pemasangan = '<tr id="pembelian-' + urutan + '">';
            item_pemasangan += '<td class="text-center" id="urutan">' + urutan + '</td>';
            item_pemasangan += '<td colspan="2">';
            item_pemasangan += '<div class="form-group">';
            item_pemasangan += '<select class="form-control select2bs4" id="sparepart_id-' + key +
                '" name="sparepart_id[]" style="width: 100%;" data-placeholder="Cari Part..">';
            item_pemasangan += '<option value="">- Pilih Part -</option>';
            item_pemasangan += '@foreach ($spareparts as $sparepart_id)';
            item_pemasangan +=
                '<option value="{{ $sparepart_id->id }}" {{ $sparepart_id->id == ' + sparepart_id + ' ? 'selected' : '' }}>{{ $sparepart_id->nama_barang }}</option>';
            item_pemasangan += '@endforeach';
            item_pemasangan += '</select>';
            item_pemasangan += '</div>';
            item_pemasangan += '</td>';
            item_pemasangan += '<td>';
            item_pemasangan += '<div class="form-group">'
            item_pemasangan += '<input type="text" class="form-control" id="keterangan-' + key +
                '" name="keterangan[]" value="' +
                keterangan +
                '" ';
            item_pemasangan += '</td>';
            item_pemasangan += '<td>';
            item_pemasangan +=
                '<button type="button" class="btn btn-danger btn-sm remove-part-button" onclick="removePart(' + urutan +
                ')">';
            item_pemasangan += '<i class="fas fa-trash"></i>';
            item_pemasangan += '</button>';
            item_pemasangan += '</td>';
            item_pemasangan += '</tr>';

            // if (style) {
            //     select2(key);
            // }

            $('#tabel-pembelian').append(item_pemasangan);

            $('#sparepart_id-' + key + '').val(sparepart_id).attr('selected', true);
        }

        function select2(id) {
            $(function() {
                $('#sparepart_id-' + id).select2({
                    theme: 'bootstrap4'
                });
            });
        }


        // Tambahkan event listener untuk tombol remove-part-button
        $(document).on('click', '.remove-part-button', function() {
            var urutanToRemove = $(this).data('urutan');
            removePart(urutanToRemove);
        });



        // date //
        function formatDateToYYYYMMDD(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }
        const currentDate = new Date();
        const dateInput = document.getElementById('tanggal_pemasangan');
        dateInput.min = formatDateToYYYYMMDD(currentDate);
        // date //
    </script>

@endsection
