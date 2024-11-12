@extends('layouts.app')

@section('title', 'Inquery Klaim Peralatan')

@section('content')

    <div id="loadingSpinner" style="display: flex; align-items: center; justify-content: center; height: 100vh;">
        <i class="fas fa-spinner fa-spin" style="font-size: 3rem;"></i>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(function() {
                document.getElementById("loadingSpinner").style.display = "none";
                document.getElementById("mainContent").style.display = "block";
                document.getElementById("mainContentSection").style.display = "block";
            }, 100); // Adjust the delay time as needed
        });
    </script>
    <!-- Content Header (Page header) -->
    <div class="content-header" style="display: none;" id="mainContent">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Inquery Klaim Peralatan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/inquery_klaimperalatan') }}">Transaksi</a></li>
                        <li class="breadcrumb-item active">Inquery Klaim Peralatan</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content" style="display: none;" id="mainContentSection">
        <div class="container-fluid">
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
            <form action="{{ url('admin/inquery_klaimperalatan/' . $inquery->id) }}" method="post" autocomplete="off">
                @csrf
                @method('put')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Inquery Inquery Klaim Peralatan</h3>
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
                        <h3 class="card-title">Perbarui Klaim Peralatan</h3>
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
                                    <th>Keterangan</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Total</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody id="tabel-pembelian">
                                @foreach ($details as $detail)
                                    <tr id="pembelian-{{ $loop->index }}">
                                        <td style="width: 70px; font-size:14px" class="text-center" id="urutan">
                                            {{ $loop->index + 1 }}
                                        </td>
                                        <td hidden>
                                            <div class="form-group" hidden>
                                                <input type="text" class="form-control" name="detail_ids[]"
                                                    value="{{ $detail['id'] }}">
                                            </div>
                                        <td hidden>
                                            <div class="form-group">
                                                <input style="font-size:14px" type="text" class="form-control"
                                                    id="sparepart_id-{{ $loop->index }}" name="sparepart_id[]"
                                                    value="{{ $detail['sparepart_id'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control" onclick="barang(0)" readonly
                                                    id="kode_partdetail-{{ $loop->index }}" name="kode_partdetail[]"
                                                    value="{{ $detail['kode_partdetail'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control" onclick="barang(0)" readonly
                                                    id="nama_barang-{{ $loop->index }}" name="nama_barang[]"
                                                    value="{{ $detail['nama_barang'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <select class="form-control" id="keterangan-{{ $loop->index }}"
                                                    name="keterangan[]" value="{{ $detail['keterangan'] }}">
                                                    <option value="">- Pilih -</option>
                                                    <option value="Klaim Hilang"
                                                        {{ old('Klaim Hilang', $detail['keterangan']) == 'Klaim Hilang' ? 'selected' : null }}>
                                                        Klaim Hilang</option>
                                                    <option value="Klaim Rusak"
                                                        {{ old('Klaim Rusak', $detail['keterangan']) == 'Klaim Rusak' ? 'selected' : null }}>
                                                        Klaim Rusak</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="number" class="form-control harga"
                                                    id="harga-{{ $loop->index }}" name="harga[]" data-row-id="0"
                                                    value="{{ $detail['harga'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="number" class="form-control jumlah"
                                                    id="jumlah-{{ $loop->index }}" name="jumlah[]" data-row-id="0"
                                                    value="{{ $detail['jumlah'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" onclick="barang(0)" readonly class="form-control total"
                                                    id="total-{{ $loop->index }}" name="total[]"
                                                    value="{{ $detail['total'] }}">
                                            </div>
                                        </td>
                                        <td style="width: 120px">
                                            <button type="button" class="btn btn-primary"
                                                onclick="barang({{ $loop->index }})">
                                                <i class="fas fa-plus"></i>
                                            </button>
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
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Pengambilan Deposit</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="sisa_saldo">Kode Sopir</label>
                                <div class="form-group d-flex">
                                    <input readonly type="text" hidden class="form-control" id="karyawan_id"
                                        name="karyawan_id" placeholder=""
                                        value="{{ old('karyawan_id', $inquery->karyawan->id) }}">
                                    <input onclick="showSopir(this.value)" class="form-control" id="kode_karyawan"
                                        name="kode_karyawan" type="text" placeholder=""
                                        value="{{ old('kode_karyawan', $inquery->karyawan->kode_karyawan) }}" readonly
                                        style="margin-right: 10px; font-size:14px" />
                                    <button class="btn btn-primary" type="button" onclick="showSopir(this.value)">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="sisa_saldo">Sisa Saldo</label>
                                    <input style="text-align: end;margin:right:10px" type="text" class="form-control"
                                        id="sisa_saldo" readonly name="sisa_saldo"
                                        value="{{ old('sisa_saldo', $inquery->deposit_driver->sisa_saldo) }}"
                                        placeholder="">

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="nama_lengkap">Nama Sopir</label>
                                    <input readonly type="text" class="form-control" id="nama_lengkap"
                                        name="nama_lengkap" placeholder="" value="{{ old('nama_lengkap', $inquery->karyawan->nama_lengkap) }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="saldo_masuk">Potongan Saldo</label>
                                    <input style="text-align: end" type="text" class="form-control" readonly
                                        id="saldo_keluar" name="saldo_keluar" placeholder=""
                                        value="{{ old('saldo_keluar', $inquery->deposit_driver->saldo_keluar) }}">
                                </div>
                                <hr
                                    style="border: 2px solid black; display: inline-block; width: 97%; vertical-align: middle;">
                                <span
                                    style="display: inline-block; margin-left: 0px; margin-right: 0; font-size: 18px; vertical-align: middle;">-</span>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="alamat">Keterangan</label>
                                    <textarea type="text" class="form-control" id="keterangans" name="keterangans" placeholder="Masukan keterangan">{{ old('keterangans', $inquery->keterangan) }}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="sub_total">Sub Total</label>
                                    <input style="text-align: end; margin:right:10px" type="text" class="form-control"
                                        readonly id="sub_totals" name="sub_totals" placeholder=""
                                        value="{{ old('sub_totals', $inquery->deposit_driver->sub_total) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="reset" class="btn btn-secondary">Reset</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="modal fade" id="tableKategori" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Peralatan Terpakai</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="m-2">
                            <input type="text" id="searchInput" class="form-control" placeholder="Search...">
                        </div>
                        <table id="tables" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Satuan</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @foreach ($spareparts as $part)
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
                                @endforeach --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="tableSopir" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Sopir</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive scrollbar m-2">
                            <table id="datatables66" class="table table-bordered table-striped">
                                <thead class="bg-200 text-900">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Kode Sopir</th>
                                        <th>Nama Nama Sopir</th>
                                        <th>Tanggal</th>
                                        <th>Sisa Saldo</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($SopirAll as $sopir)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $sopir->kode_karyawan }}</td>
                                            <td>{{ $sopir->nama_lengkap }}</td>
                                            <td>{{ $sopir->telp }}</td>
                                            <td> {{ number_format($sopir->tabungan, 0, ',', '.') }}
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="getSelectedData('{{ $sopir->id }}',
                                                    '{{ $sopir->kode_karyawan }}',
                                                    '{{ $sopir->nama_lengkap }}',
                                                    '{{ $sopir->tabungan }}',
                                                    )">
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


        });
    </script>

    <script>
        // Function to filter the table rows based on the search input
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
            var sparepart_id = selectedRow.data('sparepart_id');
            var kode_partdetail = selectedRow.data('kode_partdetail');
            var nama_barang = selectedRow.data('nama_barang');
            var satuan = selectedRow.data('satuan');

            // Update the form fields for the active specification
            $('#sparepart_id-' + activeSpecificationIndex).val(sparepart_id);
            $('#kode_partdetail-' + activeSpecificationIndex).val(kode_partdetail);
            $('#nama_barang-' + activeSpecificationIndex).val(nama_barang);
            $('#satuan-' + activeSpecificationIndex).val(satuan);

            $('#tableKategori').modal('hide');
        }


        var data_pembelian = @json(session('data_pembelians'));
        var jumlah_part = 1;

        if (data_pembelian != null) {
            jumlah_part = data_pembelian.length;
            $('#tabel-pembelian').empty();
            var urutan = 0;
            $.each(data_pembelian, function(key, value) {
                urutan = urutan + 1;
                itemPembelian(urutan, key, value);
            });
        }



        var counter = 0;

        function addPesanan() {
            counter++;
            jumlah_part = jumlah_part + 1;

            if (jumlah_part === 1) {
                $('#tabel-pembelian').empty();
            } else {
                // Find the last row and get its index to continue the numbering
                var lastRow = $('#tabel-pembelian tr:last');
                var lastRowIndex = lastRow.find('#urutan').text();
                jumlah_part = parseInt(lastRowIndex) + 1;
            }

            console.log('Current jumlah_part:', jumlah_part);
            itemPembelian(jumlah_part, jumlah_part - 1);
            updateUrutan();
        }

        function updateUrutan() {
            var urutan = document.querySelectorAll('#urutan');
            for (let i = 0; i < urutan.length; i++) {
                urutan[i].innerText = i + 1;
            }
        }


        function removeBan(identifier, detailId) {
            var row = document.getElementById('pembelian-' + identifier);
            row.remove();

            $.ajax({
                url: "{{ url('admin/inquery_klaimperalatan/deletedetailklaim/') }}/" + detailId,
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

            updateGrandTotal();
            updateUrutan();
        }

        function itemPembelian(identifier, key, value = null) {
            var sparepart_id = '';
            var kode_partdetail = '';
            var nama_barang = '';
            var keterangan = '';
            var jumlah = '';
            var type_ban = '';
            var harga = '';
            var total = '';
            var kondisi_ban = '';

            if (value !== null) {
                sparepart_id = value.sparepart_id;
                kode_partdetail = value.kode_partdetail;
                nama_barang = value.nama_barang;
                keterangan = value.keterangan;
                jumlah = value.jumlah;
                type_ban = value.type_ban;
                harga = value.harga;
                total = value.total;
                kondisi_ban = value.kondisi_ban;
            }

            console.log(sparepart_id);
            // urutan 
            var item_pembelian = '<tr id="pembelian-' + key + '">';
            item_pembelian += '<td  style="width: 70px; font-size:14px" class="text-center" id="urutan">' + key +
                '</td>';
            //sparepart_id
            item_pembelian += '<td hidden>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" onclick="barang(0)" readonly id="sparepart_id-' + key +
                '" name="sparepart_id[]" value="' +
                sparepart_id +
                '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            //kode barang
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" onclick="barang(0)" readonly id="kode_partdetail-' + key +
                '" name="kode_partdetail[]" value="' +
                kode_partdetail +
                '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            //nama barang
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" onclick="barang(0)" readonly id="nama_barang-' + key +
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
            item_pembelian += '<option value="Klaim Hilang"' + (keterangan === 'Klaim Hilang' ? ' selected' : '') +
                '>Klaim Hilang</option>';
            item_pembelian += '<option value="Klaim Rusak"' + (keterangan === 'Klaim Rusak' ? ' selected' : '') +
                '>Klaim Rusak</option>';
            item_pembelian += '</select>';
            item_pembelian += '</div>';
            item_pembelian += '</td>';


            // harga
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="number" class="form-control harga" id="harga-' + key +
                '" name="harga[]" value="' + harga + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // jumlah
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control jumlah" id="jumlah-' + key +
                '" name="jumlah[]" value="' + jumlah + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';


            // total
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" readonly onclick="barang(0)" class="form-control total" id="total-' + key +
                '" name="total[]" value="' + total + '" readonly';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // opsi
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
    </script>

    <script>
        $(document).on("input", ".harga, .jumlah", function() {
            var currentRow = $(this).closest('tr');
            var harga = parseFloat(currentRow.find(".harga").val()) || 0;
            var jumlah = parseFloat(currentRow.find(".jumlah").val()) || 0;
            var total = harga * jumlah;
            currentRow.find(".total").val(total);

            updateGrandTotal()

        });

        function updateGrandTotal() {
            var grandTotal = 0;

            // Retrieve the value from the element with id "sisa_saldo"
            var sisaSaldoValue = parseFloat($('#sisa_saldo').val().replace(/\./g, '').replace(',', '.')) || 0;

            // Loop through all elements with name "total[]"
            $('input[name^="total"]').each(function() {
                var nominalValue = parseFloat($(this).val().replace(/\./g, '').replace(',', '.')) || 0;
                grandTotal += nominalValue;
            });

            // Format and set the value for "saldo_keluar"
            $('#saldo_keluar').val(formatCurrency(grandTotal));

            // Calculate the remaining balance
            var subTotals = sisaSaldoValue - grandTotal;

            // Format the remaining balance and set it to the element with id "sub_totals"
            $('#sub_totals').val(formatCurrency(subTotals));
        }

        $('body').on('input', 'input[name^="total"]', function() {
            updateGrandTotal();
        });

        // Panggil fungsi saat halaman dimuat untuk menginisialisasi grand total
        $(document).ready(function() {
            updateGrandTotal();
        });

        function formatRupiahsss(number) {
            var formatted = new Intl.NumberFormat('id-ID', {
                minimumFractionDigits: 1,
                maximumFractionDigits: 1
            }).format(number);
            return '' + formatted;
        }
    </script>


    <script>
        function showSopir(selectedCategory) {
            $('#tableSopir').modal('show');
        }

        function formatCurrency(number) {
            // Check if the number is negative
            const isNegative = number < 0;

            // Format number as currency with period as thousands separator and comma as decimal separator
            const formattedNumber = new Intl.NumberFormat('id-ID', {
                // style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
            }).format(Math.abs(number)); // Use Math.abs() to work with the absolute value

            // Add a minus sign for negative numbers
            return isNegative ? `-${formattedNumber}` : formattedNumber;
        }


        function getSelectedData(Sopir_id, KodeSopir, NamaSopir, Tabungan) {
            // Set the values in the form fields
            document.getElementById('karyawan_id').value = Sopir_id;
            document.getElementById('kode_karyawan').value = KodeSopir;
            document.getElementById('nama_lengkap').value = NamaSopir;

            // Format Tabungan as currency with proper handling for negative values
            const formattedTabungan = formatCurrency(Tabungan);
            document.getElementById('sisa_saldo').value = formattedTabungan;

            // Parse numeric values from sisa_saldo and saldo_keluar
            const sisaSaldo = parseFloat(Tabungan.replace(/\D/g, ''));
            const saldoKeluar = parseFloat(document.getElementById('saldo_keluar').value.replace(/\D/g, ''));

            // Hitung sub_totals
            const subTotals = sisaSaldo - saldoKeluar;

            // Format sub_totals to locale currency
            const formattedSubTotals = formatCurrency(subTotals);
            document.getElementById('sub_totals').value = formattedSubTotals;

            // Close the modal (if needed)
            $('#tableSopir').modal('hide');
        }
    </script>

    <script>
        $(document).ready(function() {
            // Mengambil nilai sisa saldo dari elemen dengan id sisa_saldo
            var sisaSaldoValue = $('#sisa_saldo').val();
            var subTotal = $('#sub_totals').val();

            // Mengonversi nilai ke format rupiah
            var sisaSaldoRupiah = formatCurrency(sisaSaldoValue);
            var SubtotalRUpiah = formatCurrency(subTotal);

            // Menetapkan nilai ke input sisa saldo
            $('#sisa_saldo').val(sisaSaldoRupiah);
            $('#sub_totals').val(SubtotalRUpiah);

            // Memperbarui nilai sub total saat dokumen selesai dimuat
            updateGrandTotal();
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#kendaraan_id').on('input', function() {
                var kendaraanID = $(this).val();

                if (!kendaraanID) {
                    kendaraanID = $('#kendaraan_id').attr('data-id');
                }

                if (kendaraanID) {
                    $.ajax({
                        url: "{{ url('admin/klaim_peralatan/get_detailinventory') }}" +
                            '/' +
                            kendaraanID,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#tables tbody').empty();
                            if (data.length > 0) {
                                $.each(data, function(index, detail_inventory) {
                                    var row = '<tr onclick="getBarang(' +
                                        index + ')" data-sparepart_id="' +
                                        detail_inventory.sparepart.id +
                                        '" data-kode_partdetail="' + detail_inventory
                                        .sparepart.kode_partdetail +
                                        '" data-nama_barang="' + detail_inventory
                                        .sparepart.nama_barang +
                                        '" data-param="' + index + '">' +
                                        '<td class="text-center">' + (index + 1) +
                                        '</td>' +
                                        '<td>' + detail_inventory.sparepart
                                        .kode_partdetail + '</td>' +
                                        '<td>' + detail_inventory.sparepart
                                        .nama_barang + '</td>' +
                                        '<td>' + detail_inventory.jumlah + '</td>' +
                                        '<td>' + detail_inventory.sparepart.satuan +
                                        '</td>' +
                                        '<td class="text-center">' +
                                        '<button type="button" id="btnTambah" class="btn btn-primary btn-sm" onclick="getBarang(' +
                                        index + ')">' +
                                        '<i class="fas fa-plus"></i>' +
                                        '</button>' +
                                        '</td>' +
                                        '</tr>';
                                    $('#tables tbody').append(row);
                                });
                            } else {
                                $('#tables tbody').append(
                                    '<tr><td colspan="7" class="text-center">No data available</td></tr>'
                                );
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX Error:", status, error);
                            $('#tables tbody').empty();
                            $('#tables tbody').append(
                                '<tr><td colspan="7" class="text-center">Error loading data</td></tr>'
                            );
                        }
                    });
                } else {
                    $('#tables tbody').empty();
                    $('#tables tbody').append(
                        '<tr><td colspan="7" class="text-center">No data available</td></tr>'
                    );
                }
            });

            // Trigger the input event manually on page load if there's a value in the kendaraan_id field
            if ($('#kendaraan_id').val()) {
                $('#kendaraan_id').trigger('input');
            }
        });
    </script>
@endsection
