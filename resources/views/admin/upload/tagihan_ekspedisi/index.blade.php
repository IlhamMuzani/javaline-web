@extends('layouts.app')

@section('title', 'Invoice Faktur Ekspedisi')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Invoice Faktur Ekspedisi</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/tagihan_ekspedisi') }}">Invoice Faktur
                                Ekspedisi</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
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
            @if (session('erorrss'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-ban"></i> Error!
                    </h5>
                    {{ session('erorrss') }}
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
            <form action="{{ url('admin/tagihan_ekspedisi') }}" method="POST" enctype="multipart/form-data"
                autocomplete="off">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Invoice Faktur Ekspedisi</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group">
                            <label style="font-size:14px" class="form-label" for="kategori">Pilih Kategori</label>
                            <select style="font-size:14px" class="form-control" id="kategori" name="kategori">
                                <option value="">- Pilih -</option>
                                <option value="PPH" {{ old('kategori') == 'PPH' ? 'selected' : null }}>
                                    PPH</option>
                                <option value="NON PPH" {{ old('kategori') == 'NON PPH' ? 'selected' : null }}>
                                    NON PPH</option>
                            </select>
                        </div>
                        <div class="form-group" style="flex: 8;">
                            <div class="row">
                                {{-- <div class="mb-3 mt-4">
                                <button class="btn btn-primary btn-sm" type="button" onclick="ShowMemo(this.value)">
                                    <i class="fas fa-plus mr-2"></i> Pilih Pelanggan
                                </button>
                            </div> --}}
                                <div class="form-group" hidden>
                                    <label for="pelanggan_id">pelanggan Id</label>
                                    <input type="text" class="form-control" id="pelanggan_id" readonly
                                        name="pelanggan_id" placeholder="" value="{{ old('pelanggan_id') }}">
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label style="font-size:14px" for="kode_pelanggan">Kode Pelanggan</label>
                                        <input style="font-size:14px" type="text" class="form-control"
                                            id="kode_pelanggan" readonly name="kode_pelanggan" placeholder=""
                                            value="{{ old('kode_pelanggan') }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label style="font-size:14px" class="form-label" for="nama_pelanggan">Nama
                                        Pelanggan</label>
                                    <div class="form-group d-flex">
                                        <input class="form-control" id="nama_pelanggan" name="nama_pelanggan" type="text"
                                            placeholder="" value="{{ old('nama_pelanggan') }}" readonly
                                            style="margin-right: 10px; font-size:14px" />
                                        <button class="btn btn-primary" type="button"
                                            onclick="showCategoryModalPelanggan(this.value)">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label style="font-size:14px" for="telp_pelanggan">No. Telp</label>
                                        <input style="font-size:14px" type="text" class="form-control"
                                            id="telp_pelanggan" readonly name="telp_pelanggan" placeholder=""
                                            value="{{ old('telp_pelanggan') }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label style="font-size:14px" for="alamat_pelanggan">Alamat</label>
                                        <input style="font-size:14px" type="text" class="form-control"
                                            id="alamat_pelanggan" readonly name="alamat_pelanggan" placeholder=""
                                            value="{{ old('alamat_pelanggan') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Faktur Ekspedisi <span>
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
                                    <th style="font-size:14px">Rute</th>
                                    <th style="font-size:14px">Tgl. Kirim</th>
                                    <th style="font-size:14px">No Faktur</th>
                                    {{-- <th style="font-size:14px">No. SJ</th> --}}
                                    <th style="font-size:14px">No. DO</th>
                                    <th style="font-size:14px">No. PO</th>
                                    <th style="font-size:14px">No Mobil</th>
                                    <th style="font-size:14px">Qty</th>
                                    {{-- <th style="font-size:14px">Satuan</th> --}}
                                    <th style="font-size:14px">Harga</th>
                                    <th style="font-size:14px">Total</th>
                                    <th style="font-size:14px; text-align:center">Opsi</th>
                                </tr>
                            </thead>
                            <tbody id="tabel-pembelian">
                                <tr id="pembelian-0">
                                    <td style="width: 70px; font-size:14px" class="text-center" id="urutan">1
                                    </td>
                                    <td hidden>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="faktur_ekspedisi_id-0"
                                                name="faktur_ekspedisi_id[]">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input style="font-size:14px" readonly type="text" class="form-control"
                                                id="nama_rute-0" name="nama_rute[]">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input style="font-size:14px" readonly type="text" class="form-control"
                                                id="tanggal_memo-0" name="tanggal_memo[]">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input style="font-size:14px" readonly type="text" class="form-control"
                                                id="kode_faktur-0" name="kode_faktur[]">
                                        </div>
                                    </td>
                                    <td hidden>
                                        <div class="form-group">
                                            <input style="font-size:14px" readonly type="text" class="form-control"
                                                id="no_memo-0" name="no_memo[]">
                                        </div>
                                    </td>

                                    <td>
                                        <div class="form-group">
                                            <input style="font-size:14px" type="text" class="form-control"
                                                id="no_do-0" name="no_do[]">
                                        </div>
                                    </td>

                                    <td>
                                        <div class="form-group">
                                            <input style="font-size:14px" type="text" class="form-control"
                                                id="no_po-0" name="no_po[]">
                                        </div>
                                    </td>
                                    <td hidden>
                                        <div class="form-group">
                                            <input style="font-size:14px" readonly type="text" class="form-control"
                                                id="no_kabin-0" name="no_kabin[]">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input style="font-size:14px" readonly type="text" class="form-control"
                                                id="no_pol-0" name="no_pol[]">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input style="font-size:14px" readonly type="text" class="form-control"
                                                id="jumlah-0" name="jumlah[]">
                                        </div>
                                    </td>
                                    <td hidden>
                                        <div class="form-group">
                                            <input style="font-size:14px" readonly type="text" class="form-control"
                                                id="satuan-0" name="satuan[]">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input style="font-size:14px" readonly type="text" class="form-control"
                                                id="harga-0" name="harga[]">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input style="font-size:14px" readonly type="text" class="form-control"
                                                id="total-0" name="total[]">
                                        </div>
                                    </td>
                                    <td style="width: 100px">
                                        <button type="button" class="btn btn-primary btn-sm" onclick="MemoEkspedisi(0)">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                        <button style="margin-left:5px" type="button" class="btn btn-danger btn-sm"
                                            onclick="removeBan(0)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group mt-2">
                            <label style="font-size:14px" for="keterangan">Keterangan</label>
                            <textarea style="font-size:14px" type="text" class="form-control" id="keterangan" name="keterangan"
                                placeholder="Masukan keterangan">{{ old('keterangan') }}</textarea>
                        </div>
                    </div>
                </div>
                <div>
                    <div>
                        <div class="card">
                            <div class="card-body">
                                <div id="form_pph">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label style="font-size:14px; margin-top:5px" for="sub_total">Sub Total
                                                    <span style="margin-left:61px">:</span></label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input style="text-align: end; font-size:14px;" type="text"
                                                    class="form-control sub_total" readonly id="sub_total"
                                                    name="sub_total" placeholder="" value="{{ old('sub_total') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label style="font-size:14px; margin-top:5px" for="pph">PPH 2%
                                                    <span style="margin-left:69px">:</span></label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input style="text-align: end; font-size:14px;" type="text"
                                                    class="form-control pph2" readonly id="pph2" name="pph"
                                                    placeholder="" value="{{ old('pph') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <hr
                                            style="border: 2px solid black; display: inline-block; width: 97%; vertical-align: middle;">
                                        <span
                                            style="display: inline-block; margin-left: 0px; margin-right: 0; font-size: 18px; vertical-align: middle;">-</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label style="font-size:14px; margin-top:5px" for="grand_total">Grand
                                        Total <span style="margin-left:46px">:</span></label>
                                    <input style="text-align: end; margin:right:10px; font-size:14px;" type="text"
                                        class="form-control grand_total" readonly id="grand_total" name="grand_total"
                                        placeholder="" value="{{ old('grand_total') }}">
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button type="reset" class="btn btn-secondary">Reset</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </div>
            </form>
        </div>

        <div class="modal fade" id="tablePelanggan" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Pelanggan</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table id="datatables4" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Kode Pelanggan</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Alamat</th>
                                    <th>No. Telp</th>
                                    <th>Kategori</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($fakturs as $faktur)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $faktur->pelanggan->kode_pelanggan }}</td>
                                        <td>{{ $faktur->pelanggan->nama_pell }}</td>
                                        <td>{{ $faktur->pelanggan->alamat }}</td>
                                        <td>{{ $faktur->pelanggan->telp }}</td>
                                        <td>{{ $faktur->kategori }}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-primary btn-sm"
                                                onclick="getSelectedDataPelanggan('{{ $faktur->pelanggan->id }}', '{{ $faktur->pelanggan->kode_pelanggan }}', '{{ $faktur->pelanggan->nama_pell }}', '{{ $faktur->pelanggan->alamat }}', '{{ $faktur->pelanggan->telp }}')">
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

        <div class="modal fade" id="tableMemo" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Faktur Ekspedisi</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table id="datatables66" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Kode Faktur</th>
                                    <th>Tanggal</th>
                                    <th>Pelanggan</th>
                                    <th>Rute</th>
                                    <th>Kategori</th>
                                    {{-- <th>kode memo</th> --}}
                                    {{-- <th>kabin</th>
                                    <th>nopol</th> --}}
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($fakturs as $faktur)
                                    <tr data-id="{{ $faktur->id }}" data-kode_faktur="{{ $faktur->kode_faktur }}"
                                        data-nama_rute="{{ $faktur->detail_faktur->first()->nama_rute }}"
                                        data-kode_memo="{{ $faktur->detail_faktur->first()->kode_memo }}"
                                        data-tanggal_awal="{{ $faktur->tanggal_awal }}"
                                        data-no_kabin="{{ $faktur->detail_faktur->first()->no_kabin }}"
                                        data-no_pol="{{ $faktur->detail_faktur->first()->no_pol }}"
                                        data-jumlah="{{ $faktur->jumlah }}" data-satuan="{{ $faktur->satuan }}"
                                        data-harga_tarif="{{ $faktur->harga_tarif }}"
                                        data-total_tarif="{{ $faktur->total_tarif }}" data-param="{{ $loop->index }}">
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $faktur->kode_faktur }}</td>
                                        <td>{{ $faktur->tanggal }}</td>
                                        <td>{{ $faktur->pelanggan->nama_pell }}</td>
                                        <td>{{ $faktur->detail_faktur->first()->nama_rute }}</td>
                                        <td>{{ $faktur->kategori }}</td>
                                        {{-- <td>{{ $faktur->detail_faktur->first()->kode_memo }}</td> --}}
                                        {{-- <td>{{ $faktur->detail_faktur->first()->no_kabin }}</td> --}}
                                        {{-- <td>{{ $faktur->detail_faktur->first()->no_pol }}</td> --}}
                                        <td class="text-center">
                                            <button type="button" id="btnTambah" class="btn btn-primary btn-sm"
                                                onclick="getFaktur({{ $loop->index }})">
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
    </section>

    <script>
        function showCategoryModalPelanggan(selectedCategory) {
            $('#tablePelanggan').modal('show');
        }

        function getSelectedDataPelanggan(Pelanggan_id, KodePelanggan, NamaPell, AlamatPel, Telpel) {
            // Set the values in the form fields
            document.getElementById('pelanggan_id').value = Pelanggan_id;
            document.getElementById('kode_pelanggan').value = KodePelanggan;
            document.getElementById('nama_pelanggan').value = NamaPell;
            document.getElementById('alamat_pelanggan').value = AlamatPel;
            document.getElementById('telp_pelanggan').value = Telpel;
            // Close the modal (if needed)
            $('#tablePelanggan').modal('hide');
        }
    </script>


    {{-- filter kategori  --}}
    <script>
        $(document).ready(function() {
            // Listen for changes in the category dropdown
            $('#kategori').change(function() {
                // Get the selected category value
                var selectedCategory = $(this).val();

                // Loop through each row in the table
                $('#datatables4 tbody tr').each(function() {
                    // Get the category value of the current row
                    var rowCategory = $(this).find('td:eq(5)')
                        .text(); // Assuming category is in the 6th column (index 5)

                    // Show or hide the row based on the selected category
                    if (selectedCategory === '' || selectedCategory === rowCategory) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });

        $(document).ready(function() {
            // Listen for changes in the category dropdown
            $('#kategori').change(function() {
                // Get the selected category value
                var selectedCategory = $(this).val();

                // Loop through each row in the table
                $('#datatables66 tbody tr').each(function() {
                    // Get the category value of the current row
                    var rowCategory = $(this).find('td:eq(5)')
                        .text(); // Assuming category is in the 6th column (index 5)

                    // Show or hide the row based on the selected category
                    if (selectedCategory === '' || selectedCategory === rowCategory) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });

        // Function to reset the modal content when it's closed
        $('#tableMemo').on('hidden.bs.modal', function() {
            // Show all rows
            $('#datatables66 tbody tr').show();
            // Reset the selected category in the dropdown
            $('#kategori').val('');
        });
    </script>

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

        function removeBan(params) {
            jumlah_ban = jumlah_ban - 1;

            var tabel_pesanan = document.getElementById('tabel-pembelian');
            var pembelian = document.getElementById('pembelian-' + params);

            tabel_pesanan.removeChild(pembelian);

            if (jumlah_ban === 0) {
                var item_pembelian = '<tr>';
                item_pembelian += '<td class="text-center" colspan="5">- Memo belum ditambahkan -</td>';
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
            var faktur_ekspedisi_id = '';
            var nama_rute = '';
            var tanggal_memo = '';
            var kode_faktur = '';
            var no_memo = '';
            var no_do = '';
            var no_po = '';
            var no_kabin = '';
            var no_pol = '';
            var jumlah = '';
            var satuan = '';
            var harga = '';
            var total = '';

            if (value !== null) {
                faktur_ekspedisi_id = value.faktur_ekspedisi_id;
                nama_rute = value.nama_rute;
                tanggal_memo = value.tanggal_memo;
                kode_faktur = value.kode_faktur;
                no_memo = value.no_memo;
                no_do = value.no_do;
                no_po = value.no_po;
                no_kabin = value.no_kabin;
                no_pol = value.no_pol;
                jumlah = value.jumlah;
                satuan = value.satuan;
                harga = value.harga;
                total = value.total;
            }

            // urutan 
            var item_pembelian = '<tr id="pembelian-' + urutan + '">';
            item_pembelian += '<td style="width: 70px; font-size:14px" class="text-center" id="urutan-' + urutan + '">' +
                urutan + '</td>';

            // faktur_ekspedisi_id 
            item_pembelian += '<td hidden>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" id="faktur_ekspedisi_id-' + urutan +
                '" name="faktur_ekspedisi_id[]" value="' + faktur_ekspedisi_id + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // nama_rute 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" style="font-size:14px" readonly id="nama_rute-' +
                urutan +
                '" name="nama_rute[]" value="' + nama_rute + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // tanggal_memo 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control" style="font-size:14px" readonly id="tanggal_memo-' +
                urutan +
                '" name="tanggal_memo[]" value="' + tanggal_memo + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // kode_faktur 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" style="font-size:14px" readonly id="kode_faktur-' +
                urutan +
                '" name="kode_faktur[]" value="' + kode_faktur + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // no_memo 
            item_pembelian += '<td hidden>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" style="font-size:14px" readonly id="no_memo-' +
                urutan +
                '" name="no_memo[]" value="' + no_memo + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // no_do 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" style="font-size:14px" id="no_do-' +
                urutan +
                '" name="no_do[]" value="' + no_do + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // no_po 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" style="font-size:14px" id="no_po-' +
                urutan +
                '" name="no_po[]" value="' + no_po + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // no_kabin 
            item_pembelian += '<td hidden>';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control" style="font-size:14px" readonly id="no_kabin-' +
                urutan +
                '" name="no_kabin[]" value="' + no_kabin + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // no_pol 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control" style="font-size:14px" readonly id="no_pol-' +
                urutan +
                '" name="no_pol[]" value="' + no_pol + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // jumlah 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control" style="font-size:14px" readonly id="jumlah-' +
                urutan +
                '" name="jumlah[]" value="' + jumlah + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // satuan 
            item_pembelian += '<td hidden>';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control" style="font-size:14px" readonly id="satuan-' +
                urutan +
                '" name="satuan[]" value="' + satuan + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // harga 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control" style="font-size:14px" readonly id="harga-' +
                urutan +
                '" name="harga[]" value="' + harga + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // total 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control" style="font-size:14px" readonly id="total-' +
                urutan +
                '" name="total[]" value="' + total + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            item_pembelian += '<td style="width: 100px">';
            item_pembelian += '<button type="button" class="btn btn-primary btn-sm" onclick="MemoEkspedisi(' + urutan +
                ')">';
            item_pembelian += '<i class="fas fa-plus"></i>';
            item_pembelian += '</button>';
            item_pembelian +=
                '<button style="margin-left:5px" type="button" class="btn btn-danger btn-sm" onclick="removeBan(' +
                urutan + ')">';
            item_pembelian += '<i class="fas fa-trash"></i>';
            item_pembelian += '</button>';
            item_pembelian += '</td>';
            item_pembelian += '</tr>';

            $('#tabel-pembelian').append(item_pembelian);
        }
    </script>

    <script>
        var activeSpecificationIndex = 0;

        function MemoEkspedisi(param) {
            activeSpecificationIndex = param;
            // Show the modal and filter rows if necessary
            $('#tableMemo').modal('show');
        }

        function getFaktur(rowIndex) {
            var selectedRow = $('#datatables66 tbody tr:eq(' + rowIndex + ')');
            var faktur_ekspedisi_id = selectedRow.data('id');
            var kode_faktur = selectedRow.data('kode_faktur');
            var nama_rute = selectedRow.data('nama_rute');
            var kode_memo = selectedRow.data('kode_memo');
            var tanggal_awal = selectedRow.data('tanggal_awal');
            var no_kabin = selectedRow.data('no_kabin');
            var no_pol = selectedRow.data('no_pol');
            var jumlah = selectedRow.data('jumlah');
            var satuan = selectedRow.data('satuan');
            var harga = selectedRow.data('harga_tarif');
            var sub_total = selectedRow.data('total_tarif');

            // Update the form fields for the active specification
            $('#faktur_ekspedisi_id-' + activeSpecificationIndex).val(faktur_ekspedisi_id);
            $('#kode_faktur-' + activeSpecificationIndex).val(kode_faktur);
            $('#nama_rute-' + activeSpecificationIndex).val(nama_rute);
            $('#no_memo-' + activeSpecificationIndex).val(kode_memo);
            $('#tanggal_memo-' + activeSpecificationIndex).val(tanggal_awal);
            $('#no_kabin-' + activeSpecificationIndex).val(no_kabin);
            $('#no_pol-' + activeSpecificationIndex).val(no_pol);
            $('#jumlah-' + activeSpecificationIndex).val(jumlah);
            $('#satuan-' + activeSpecificationIndex).val(satuan);
            $('#harga-' + activeSpecificationIndex).val(parseFloat(harga).toLocaleString('id-ID'));
            $('#total-' + activeSpecificationIndex).val(parseFloat(sub_total).toLocaleString('id-ID'));


            updateGrandTotal();

            $('#tableMemo').modal('hide');
        }



        $(document).on("input", ".hargasatuan, .jumlah", function() {
            var currentRow = $(this).closest('tr');
            var hargasatuan = parseFloat(currentRow.find(".hargasatuan").val()) || 0;
            var jumlah = parseFloat(currentRow.find(".jumlah").val()) || 0;
            var harga = hargasatuan * jumlah;
            currentRow.find(".harga").val(harga);


        });
    </script>

    <script>
        // function updateGrandTotal() {
        //     var grandTotal = 0;
        //     var kategori = document.getElementById("kategori").value;
        //     // Loop through all elements with name "nominal_tambahan[]"
        //     $('input[name^="total"]').each(function() {
        //         var nominalValue = parseFloat($(this).val()) || 0;
        //         grandTotal += nominalValue;
        //     });

        //     var pph2Value = grandTotal * 0.02;


        //     $('#sub_total').val(grandTotal.toLocaleString('id-ID'));
        //     $('#pph2').val(pph2Value.toLocaleString('id-ID')); // Display 2% of the grand total here

        //     var grandtotals = grandTotal - pph2Value;
        //     $('#grand_total').val(grandtotals.toLocaleString('id-ID'));
        // }

        // $('body').on('input', 'input[name^="total"]', function() {
        //     updateGrandTotal();
        // });

        // // Panggil fungsi saat halaman dimuat untuk menginisialisasi grand total
        // $(document).ready(function() {
        //     updateGrandTotal();
        // });
        function updateGrandTotal() {
            var grandTotal = 0;
            var kategori = document.getElementById("kategori").value;

            // Loop through all elements with name "nominal_tambahan[]"
            $('input[name^="total"]').each(function() {
                var nominalValue = parseFloat($(this).val().replace(/\./g, '')) || 0; // Remove dots
                grandTotal += nominalValue;
            });

            var pph2Value = grandTotal * 0.02;

            $('#sub_total').val(grandTotal.toLocaleString('id-ID'));
            $('#pph2').val(pph2Value.toLocaleString('id-ID')); // Display 2% of the grand total here

            // Check the category and subtract pph2Value only if the category is "PPH"
            var grandtotals = (kategori === "PPH") ? grandTotal - pph2Value : grandTotal;
            $('#grand_total').val(grandtotals.toLocaleString('id-ID'));
        }

        $('body').on('input', 'input[name^="total"]', function() {
            updateGrandTotal();
        });

        // Panggil fungsi saat halaman dimuat untuk menginisialisasi grand total
        $(document).ready(function() {
            updateGrandTotal();
        });
    </script>

    <script>
        function setPphValue() {
            var kategori = document.getElementById("kategori").value;
            var pphInput = document.getElementById("pph2");
            var FormPPH = document.getElementById("form_pph");

            // Jika kategori adalah NON PPH, atur nilai pph2 menjadi 0
            if (kategori === "NON PPH") {
                pphInput.value = 0;
                FormPPH.style.display = "none";
                updateHarga();
            }
            // Jika kategori adalah PPH, atur nilai pph2 sesuai dengan nilai dari server
            else if (kategori === "PPH") {
                FormPPH.style.display = "block";
                updateHarga();
            }

            updateGrandTotal(); // Call updateGrandTotal() whenever the category is changed
        }

        // Panggil fungsi setPphValue() saat halaman dimuat ulang
        document.addEventListener("DOMContentLoaded", setPphValue);

        // Tambahkan event listener untuk mendeteksi perubahan pada elemen <select>
        document.getElementById("kategori").addEventListener("change", setPphValue);
        document.getElementById("kategori").addEventListener("change", updateGrandTotal);
    </script>

@endsection
