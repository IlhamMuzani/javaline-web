@extends('layouts.app')

@section('title', 'Faktur pelunasan')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Faktur pelunasan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/faktur_pelunasan') }}">Faktur pelunasan</a></li>
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
            <form action="{{ url('admin/faktur_pelunasan') }}" method="POST" enctype="multipart/form-data"
                autocomplete="off">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Faktur Pelunasan</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
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
                        <div class="form-group">
                            <label style="font-size:14px" for="keterangan">Catatan</label>
                            <div class="form-group">
                                <textarea style="font-size:14px" class="form-control" name="keterangan" placeholder="masukkan catatan">{{ old('keterangan') }}</textarea>
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
                                    <th style="font-size:14px">Kode Faktur</th>
                                    <th style="font-size:14px">Tgl Ekspedisi</th>
                                    <th style="font-size:14px">Total</th>
                                    <th style="font-size:14px">F. Return</th>
                                    <th style="font-size:14px">Tgl Return</th>
                                    <th style="font-size:14px">Total</th>
                                    <th style="font-size:14px">Sub Total</th>
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
                                                id="kode_faktur-0" name="kode_faktur[]">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input style="font-size:14px" readonly type="text" class="form-control"
                                                id="tanggal_faktur-0" name="tanggal_faktur[]">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input style="font-size:14px" readonly type="text" class="form-control"
                                                id="total_faktur-0" name="total_faktur[]">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group d-flex">
                                            <input hidden class="form-control" id="nota_return_id-0"
                                                name="nota_return_id[]" type="text" readonly
                                                style="margin-right: 10px; font-size:14px" />
                                            <input class="form-control" id="kode_return-0" name="kode_return[]"
                                                type="text" readonly style="margin-right: 10px; font-size:14px" />
                                            <button class="btn btn-primary btn-sm" type="button" onclick="Return(0)">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input style="font-size:14px" readonly type="text" class="form-control"
                                                id="tanggal_return-0" name="tanggal_return[]">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input style="font-size:14px" readonly type="text" class="form-control"
                                                id="total_return-0" name="total_return[]">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input style="font-size:14px" readonly type="text" class="form-control"
                                                id="total-0" name="total[]" oninput="updateTotalPembayaran()">
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
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Rincian Pembayaran</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group" style="flex: 8;">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label style="font-size:14px" for="potongan">Potongan Penjualan</label>
                                                <input style="font-size:14px" type="text" class="form-control"
                                                    id="potongan" name="potongan" placeholder="masukkan potongan"
                                                    value="{{ old('potongan') }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label style="font-size:14px" for="ongkos_bongkar">Ongkos Bongkar</label>
                                                <input style="font-size:14px" type="text" class="form-control"
                                                    id="ongkos_bongkar" name="ongkos_bongkar"
                                                    placeholder="masukkan ongkos bongkar"
                                                    value="{{ old('ongkos_bongkar') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label style="font-size: 14px" for="panjang">Kategori Pembayaran</label>
                                    <select style="font-size: 14px" class="form-control" id="kategori" name="kategori">
                                        <option value="">- Pilih -</option>
                                        <option value="Bilyet Giro"
                                            {{ old('kategori') == 'Bilyet Giro' ? 'selected' : null }}>
                                            Bilyet Giro BG / Cek</option>
                                        <option value="Transfer" {{ old('kategori') == 'Transfer' ? 'selected' : null }}>
                                            Transfer</option>
                                        <option value="Tunai" {{ old('kategori') == 'Tunai' ? 'selected' : null }}>
                                            Tunai</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label style="font-size: 14px" id="bg" for="lebar">No. BG/Cek</label>
                                    <label style="font-size: 14px" id="trans" for="lebar">No. Transfer</label>
                                    <label style="font-size: 14px" id="tun" for="lebar">Tunai</label>
                                    <input style="font-size: 14px" type="text" class="form-control" id="nomor"
                                        name="nomor" placeholder="masukkan no" value="{{ old('nomor') }}">
                                </div>
                                <div class="form-group">
                                    <label style="font-size: 14px" for="tinggi">Tanggal</label>
                                    <div class="input-group date" id="reservationdatetime">
                                        <input style="font-size: 14px" type="date" id="tanggal"
                                            name="tanggal_transfer" placeholder="d M Y sampai d M Y"
                                            data-options='{"mode":"range","dateFormat":"d M Y","disableMobile":true}'
                                            value="{{ old('tanggal_transfer') }}"
                                            class="form-control datetimepicker-input" data-target="#reservationdatetime">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label style="font-size: 14px" for="tinggi">Nominal</label>
                                    <input style="font-size: 14px" type="text" class="form-control" id="nominal"
                                        placeholder="masukkan nominal" name="nominal" value="{{ old('nominal') }}">
                                </div>
                            </div>
                            <div class="col-md-6" style="margin-left: 89px">
                                <div class="form-group">
                                    <label style="font-size: 14px" for="totalpenjualan">Sub Total</label>
                                    <input style="text-align: end; font-size: 14px" type="text" class="form-control"
                                        id="totalpembayaran" readonly name="totalpenjualan" placeholder=""
                                        value="{{ old('totalpenjualan') }}">
                                </div>
                                <div class="form-group">
                                    <label style="font-size: 14px" for="tinggi">Ongkos Bongkar</label>
                                    <input style="text-align: end; font-size: 14px" type="text" class="form-control"
                                        id="ongkosBongkar" readonly name="dp" placeholder=""
                                        value="{{ old('dp') }}">
                                </div>
                                <div class="form-group">
                                    <label style="font-size: 14px" for="tinggi">Potongan</label>
                                    <input style="text-align: end; font-size: 14px" type="text" class="form-control"
                                        id="potonganselisih" readonly name="potonganselisih" placeholder=""
                                        value="{{ old('potonganselisih') }}">
                                </div>
                                <hr style="border: 2px solid black;">
                                <div class="form-group">
                                    <label style="font-size: 14px" for="tinggi">Total Pembayaran</label>
                                    <input style="text-align: end; font-size: 14px" type="text" class="form-control"
                                        id="totalPembayaran" readonly name="totalpembayaran"
                                        value="{{ old('totalpembayaran') }}" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label style="font-size: 14px" for="tinggi">Selisih Pembayaran</label>
                                    <input style="text-align: end; font-size: 14px" type="text" class="form-control"
                                        id="hasilselisih" readonly name="selisih" value="{{ old('selisih') }}"
                                        placeholder="">
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
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pelanggans as $pelanggan)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $pelanggan->kode_pelanggan }}</td>
                                        <td>{{ $pelanggan->nama_pell }}</td>
                                        <td>{{ $pelanggan->alamat }}</td>
                                        <td>{{ $pelanggan->telp }}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-primary btn-sm"
                                                onclick="getSelectedDataPelanggan('{{ $pelanggan->id }}', '{{ $pelanggan->kode_pelanggan }}', '{{ $pelanggan->nama_pell }}', '{{ $pelanggan->alamat }}', '{{ $pelanggan->telp }}')">
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

        <div class="modal fade" id="tableFaktur" data-backdrop="static">
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
                                    <th>Total</th>
                                    {{-- <th>kode memo</th> --}}
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($fakturs as $faktur)
                                    <tr data-id="{{ $faktur->id }}" data-kode_faktur="{{ $faktur->kode_faktur }}"
                                        data-tanggal_awal="{{ $faktur->tanggal_awal }}"
                                        data-total_tarif="{{ $faktur->grand_total }}"
                                        data-tanggal_awal="{{ $faktur->tanggal_awal }}"
                                        data-no_kabin="{{ $faktur->detail_faktur->first()->no_kabin }}"
                                        data-no_pol="{{ $faktur->detail_faktur->first()->no_pol }}"
                                        data-jumlah="{{ $faktur->jumlah }}" data-satuan="{{ $faktur->satuan }}"
                                        data-harga_tarif="{{ $faktur->harga_tarif }}"
                                        data-total_tarif="{{ $faktur->grand_total }}" data-param="{{ $loop->index }}">
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $faktur->kode_faktur }}</td>
                                        <td>{{ $faktur->tanggal }}</td>
                                        <td>{{ $faktur->pelanggan->nama_pell }}</td>
                                        <td>{{ $faktur->detail_faktur->first()->nama_rute }}</td>
                                        <td>{{ number_format($faktur->grand_total, 0, ',', '.') }}</td>

                                        {{-- <td>{{ $faktur->detail_faktur->first()->memo_ekspedisi->kode_memo }}</td> --}}
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

        <div class="modal fade" id="tableReturn" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Return Ekspedisi</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table id="datatables6" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Kode Return</th>
                                    <th>Tanggal</th>
                                    <th>Pelanggan</th>
                                    {{-- <th>Rute</th> --}}
                                    <th>Total</th>
                                    {{-- <th>No Kabin</th> --}}
                                    {{-- <th>kode memo</th> --}}
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($returns as $return)
                                    <tr data-id="{{ $return->id }}" data-kode_return="{{ $return->kode_nota }}"
                                        data-tanggal_awal="{{ $return->tanggal_awal }}"
                                        data-grand_total="{{ $return->grand_total }}" data-param="{{ $loop->index }}">
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $return->kode_nota }}</td>
                                        <td>{{ $return->tanggal }}</td>
                                        <td>{{ $return->pelanggan->nama_pell }}</td>
                                        {{-- <td>{{ $faktur->detail_faktur->first()->nama_rute }}</td> --}}
                                        <td>{{ number_format($return->grand_total, 0, ',', '.') }}</td>
                                        {{-- <td>{{ $faktur->detail_faktur->first()->no_kabin }}</td> --}}
                                        {{-- <td>{{ $faktur->detail_faktur->first()->memo_ekspedisi->kode_memo }}</td> --}}
                                        <td class="text-center">
                                            <button type="button" id="btnTambah" class="btn btn-primary btn-sm"
                                                onclick="getReturn({{ $loop->index }})">
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

            updateTotalPembayaran()
        }

        function itemPembelian(urutan, key, value = null) {
            var faktur_ekspedisi_id = '';
            var kode_faktur = '';
            var tanggal_faktur = '';
            var total_faktur = '';
            var nota_return_id = '';
            var kode_return = '';
            var tanggal_return = '';
            var total_return = '';
            var total = '';

            if (value !== null) {
                faktur_ekspedisi_id = value.faktur_ekspedisi_id;
                kode_faktur = value.kode_faktur;
                tanggal_faktur = value.tanggal_faktur;
                total_faktur = value.total_faktur;
                nota_return_id = value.nota_return_id;
                kode_return = value.kode_return;
                tanggal_return = value.tanggal_return;
                total_return = value.total_return;
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

            // kode_faktur 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" style="font-size:14px" readonly id="kode_faktur-' +
                urutan +
                '" name="kode_faktur[]" value="' + kode_faktur + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // tanggal_faktur 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control" style="font-size:14px" readonly id="tanggal_faktur-' +
                urutan +
                '" name="tanggal_faktur[]" value="' + tanggal_faktur + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // total_faktur 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" style="font-size:14px" readonly id="total_faktur-' +
                urutan +
                '" name="total_faktur[]" value="' + total_faktur + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            //kode_return
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group d-flex">';
            item_pembelian += '<input hidden class="form-control" id="nota_return_id-' + urutan +
                '" name="nota_return_id[]" value="' + nota_return_id +
                '" type="text" readonly style="margin-right: 10px; font-size:14px" />';
            item_pembelian += '<input class="form-control" id="kode_return-' + urutan +
                '" name="kode_return[]" value="' + kode_return +
                '" type="text" readonly style="margin-right: 10px; font-size:14px" />';
            item_pembelian += '<button class="btn btn-primary btn-sm" type="button" onclick="Return(' + urutan + ')">';
            item_pembelian += '<i class="fas fa-search"></i>';
            item_pembelian += '</button>';
            item_pembelian += '</div>';
            item_pembelian += '</td>';


            // tanggal_return 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control" style="font-size:14px" readonly id="tanggal_return-' +
                urutan +
                '" name="tanggal_return[]" value="' + tanggal_return + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // total_return 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control" style="font-size:14px" readonly id="total_return-' +
                urutan +
                '" name="total_return[]" value="' + total_return + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // total 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control" readonly style="font-size:14px" id="total-' +
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
                '<button style="margin-left:10px" type="button" class="btn btn-danger btn-sm" onclick="removeBan(' +
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
            $('#tableFaktur').modal('show');
        }

        function getFaktur(rowIndex) {
            var selectedRow = $('#datatables66 tbody tr:eq(' + rowIndex + ')');
            var faktur_ekspedisi_id = selectedRow.data('id');
            var kode_faktur = selectedRow.data('kode_faktur');
            var tanggal_awal = selectedRow.data('tanggal_awal');
            var total_tarif = selectedRow.data('total_tarif');

            var totalReturn = parseFloat($('#total_return-' + activeSpecificationIndex).val().replace(/\./g, '')) || 0;
            console.log(totalReturn);
            var difference = total_tarif - totalReturn;
            console.log(difference);

            // Format the difference using toLocaleString('id-ID')
            var formattedDifference = difference.toLocaleString('id-ID');

            // Set the formatted difference to the total_faktur field
            $('#total_faktur-' + activeSpecificationIndex).val(formattedDifference);

            $('#faktur_ekspedisi_id-' + activeSpecificationIndex).val(faktur_ekspedisi_id);
            $('#kode_faktur-' + activeSpecificationIndex).val(kode_faktur);
            $('#tanggal_faktur-' + activeSpecificationIndex).val(tanggal_awal);

            // Format the total_tarif using toLocaleString('id-ID')
            var formattedTotalTarif = total_tarif.toLocaleString('id-ID');

            // Set the formatted total_tarif value to the total_faktur field
            $('#total_faktur-' + activeSpecificationIndex).val(formattedTotalTarif);

            // Set the formatted difference to the total field
            $('#total-' + activeSpecificationIndex).val(formattedDifference);

            updateTotalPembayaran();
            Hasil(); // Panggil Hasil dengan tanda kurung

            $('#tableFaktur').modal('hide');
        }

        var activeSpecificationIndexs = 0;

        function Return(param) {
            activeSpecificationIndexs = param;
            // Show the modal and filter rows if necessary
            $('#tableReturn').modal('show');
        }

        function getReturn(rowIndex) {
            var selectedRow = $('#datatables6 tbody tr:eq(' + rowIndex + ')');
            var nota_return_id = selectedRow.data('id');
            var kode_return = selectedRow.data('kode_return');
            var tanggal_awal = selectedRow.data('tanggal_awal');
            var grand_total = selectedRow.data('grand_total');

            var totalFaktur = parseFloat($('#total_faktur-' + activeSpecificationIndexs).val().replace(/\./g, '')) || 0;
            var difference = totalFaktur - grand_total;

            // Format the difference using toLocaleString('id-ID')
            var formattedDifference = difference.toLocaleString('id-ID');

            // Set the formatted difference to the total_faktur field
            $('#total_return-' + activeSpecificationIndexs).val(formattedDifference);

            $('#nota_return_id-' + activeSpecificationIndexs).val(nota_return_id);
            $('#kode_return-' + activeSpecificationIndexs).val(kode_return);
            $('#tanggal_return-' + activeSpecificationIndexs).val(tanggal_awal);

            // Format the total_tarif using toLocaleString('id-ID')
            var formattedTotalTarif = grand_total.toLocaleString('id-ID');

            // Set the formatted total_tarif value to the total_faktur field
            $('#total_return-' + activeSpecificationIndexs).val(formattedTotalTarif);

            // Set the formatted difference to the total field
            $('#total-' + activeSpecificationIndexs).val(formattedDifference);

            updateTotalPembayaran();
            Hasil(); // Panggil Hasil dengan tanda kurung

            $('#tableReturn').modal('hide');

        }

        // function getReturn(rowIndex) {
        //     var selectedRow = $('#datatables6 tbody tr:eq(' + rowIndex + ')');
        //     var nota_return_id = selectedRow.data('id');
        //     var kode_return = selectedRow.data('kode_return');
        //     var tanggal_awal = selectedRow.data('tanggal_awal');
        //     var grand_total = selectedRow.data('grand_total');

        //     // Get the value of total_faktur
        //     var totalFaktur = parseFloat($('#total_faktur-' + activeSpecificationIndexs).val().replace(/\./g, '')) || 0;
        //     console.log(totalFaktur);
        //     var difference = totalFaktur - grand_total;
        //     console.log(difference);

        //     // Format grand_total as currency in Indonesian Rupiah
        //     var formattedGrandTotal = grand_total.toLocaleString('id-ID');

        //     $('#total-' + activeSpecificationIndexs).val(difference);
        //     // Calculate the difference

        //     // Update the form fields for the active specification
        //     $('#nota_return_id-' + activeSpecificationIndexs).val(nota_return_id);
        //     $('#kode_return-' + activeSpecificationIndexs).val(kode_return);
        //     $('#tanggal_return-' + activeSpecificationIndexs).val(tanggal_awal);

        //     // Update the total field with the formatted grand_total
        //     $('#total_return-' + activeSpecificationIndexs).val(formattedGrandTotal);

        //     // Update the total field with the difference
        //     $('#total-' + activeSpecificationIndexs).val(formattedGrandTotal);
        //     updateTotalPembayaran();

        //     $('#tableReturn').modal('hide');
        // }


        // function updateTotalPembayaran() {
        //     var grandTotal = 0;
        //     $('input[id^="total-"]').each(function() {
        //         var nilaiTotal = parseFloat($(this).val()) || 0;
        //         grandTotal += nilaiTotal;
        //     });
        //     $('#totalpembayaran').val(grandTotal);
        // }

        function updateTotalPembayaran() {
            var grandTotal = 0;
            $('input[id^="total-"]').each(function() {
                // Remove dots and parse as float
                var nilaiTotal = parseFloat($(this).val().replace(/\./g, '')) || 0;
                grandTotal += nilaiTotal;
            });

            // Format grandTotal as currency in Indonesian Rupiah
            var formattedGrandTotal = grandTotal.toLocaleString('id-ID');

            $('#totalpembayaran').val(formattedGrandTotal);
        }
    </script>


    <script>
        function toggleLabels() {
            var kategori = document.getElementById('kategori');
            var bgLabel = document.getElementById('bg');
            var transLabel = document.getElementById('trans');
            var tunLabel = document.getElementById('tun');
            var Nomor = document.getElementById('nomor');

            if (kategori.value === 'Bilyet Giro') {
                bgLabel.style.display = 'block';
                transLabel.style.display = 'none';
                tunLabel.style.display = 'none';
                Nomor.style.display = 'block';
            } else if (kategori.value === 'Transfer') {
                bgLabel.style.display = 'none';
                transLabel.style.display = 'block';
                tunLabel.style.display = 'none';
                Nomor.style.display = 'block';
            } else if (kategori.value === 'Tunai') {
                bgLabel.style.display = 'none';
                transLabel.style.display = 'none';
                tunLabel.style.display = 'none';
                Nomor.style.display = 'none';
            }
        }
        toggleLabels();
        document.getElementById('kategori').addEventListener('change', toggleLabels);

        PenyamaanDP()

        function PenyamaanDP() {
            var potonganInput = document.getElementById('potongan');
            var potonganselisihInput = document.getElementById('potonganselisih');

            function formatRupiah(angka) {
                var reverse = angka.toString().split('').reverse().join(''),
                    ribuan = reverse.match(/\d{1,3}/g);
                ribuan = ribuan.join('.').split('').reverse().join('');
                return ribuan;
            }

            // Set nilai default untuk potonganselisih saat halaman dimuat
            if (potonganInput.value === '') {
                potonganselisihInput.value = '0';
            }

            // Mendengarkan perubahan pada input "potongan"
            potonganInput.addEventListener('input', function() {
                var potonganValue = this.value;

                // Jika input potongan kosong, atur nilai potonganselisih ke 0
                if (potonganValue === '') {
                    potonganselisihInput.value = '0';
                } else {
                    var formattedValue = formatRupiah(potonganValue);
                    potonganselisihInput.value = formattedValue;
                }
            });
            var oldPotongan = "{{ old('potongan') }}";
            if (oldPotongan !== '') {
                potonganInput.value = oldPotongan;
                var formattedOldValue = formatRupiah(oldPotongan);
                potonganselisihInput.value = formattedOldValue;
            }
        }
        document.addEventListener('DOMContentLoaded', PenyamaanDP);


        function OngkosBongkar() {
            var dpInput = document.getElementById('ongkosBongkar');
            var ongkosBongkarInput = document.getElementById('ongkos_bongkar');

            function formatRupiah(angka) {
                var reverse = angka.toString().split('').reverse().join(''),
                    ribuan = reverse.match(/\d{1,3}/g);
                ribuan = ribuan.join('.').split('').reverse().join('');
                return ribuan;
            }

            // Set nilai default untuk ongkosBongkar saat halaman dimuat
            if (ongkosBongkarInput.value === '') {
                dpInput.value = '0';
            }

            // Mendengarkan perubahan pada input "ongkos_bongkar"
            ongkosBongkarInput.addEventListener('input', function() {
                var potonganValue = this.value;

                // Jika input ongkos_bongkar kosong, atur nilai ongkosBongkar ke 0
                if (potonganValue === '') {
                    dpInput.value = '0';
                } else {
                    var formattedValue = formatRupiah(potonganValue);
                    dpInput.value = formattedValue;
                }
            });
            var oldOngkosBongkar = "{{ old('ongkos_bongkar') }}";
            if (oldOngkosBongkar !== '') {
                ongkosBongkarInput.value = oldOngkosBongkar;
                var formattedOldValue = formatRupiah(oldOngkosBongkar);
                dpInput.value = formattedOldValue;
            }
        }
        document.addEventListener('DOMContentLoaded', OngkosBongkar);


        PenyamaanSelisih()

        function PenyamaanSelisih() {
            document.getElementById('hasilselisih').value = '0';
            document.getElementById('nominal').addEventListener('input', function() {
                var potonganValue = this.value;
                if (potonganValue === '') {
                    document.getElementById('hasilselisih').value = '0'; // Set to 0 when 'potongan' is empty
                } else {
                    var formattedValue = formatRupiah(potonganValue);
                    document.getElementById('hasilselisih').value = formattedValue;
                }
            });
        }

        Potongan()

        function Potongan() {
            document.getElementById('potongan').addEventListener('input', hitungSelisih);

            document.getElementById('ongkos_bongkar').addEventListener('input', hitungSelisih);
            // Panggil fungsi hitungSelisih saat halaman dimuat (untuk menginisialisasi nilai selisih)
            window.addEventListener('load', hitungSelisih);
        }

        function hapusTitik(string) {
            return string.replace(/\./g, '');
        }

        function formatRupiah(angka) {
            var reverse = angka.toString().split('').reverse().join('');
            var ribuan = reverse.match(/\d{1,3}/g);
            var formatted = ribuan.join('.').split('').reverse().join('');
            return 'Rp ' + formatted;
        }

        hitungSelisih()

        function hitungSelisih() {


            // Dapatkan nilai dari input "Total Pembayaran" dan hapus titik
            var totalPembayaranInput = document.getElementById('totalpembayaran');
            var totalPembayaranValue = totalPembayaranInput.value;
            var totalPembayaran = parseFloat(hapusTitik(totalPembayaranValue)) || 0;

            var DpInput = document.getElementById('ongkosBongkar');
            var DpPembayaranValue = DpInput.value;
            var DpPembayaran = parseFloat(hapusTitik(DpPembayaranValue)) || 0;

            // Dapatkan nilai dari input "Nominal" dan hapus titik
            var nominalInput = document.getElementById('potongan');
            var nominalValue = nominalInput.value;
            var nominal = parseFloat(hapusTitik(nominalValue)) || 0;

            // Dapatkan nilai dari input "Nominal" dan hapus titik
            var OngkosInput = document.getElementById('ongkos_bongkar');
            var OngkosValue = OngkosInput.value;
            var Ongkos = parseFloat(hapusTitik(OngkosValue)) || 0;

            // Hitung selisih
            var selisih = totalPembayaran + Ongkos - nominal;

            // Tampilkan hasil selisih dalam format mata uang Rupiah dengan tanda negatif
            var hasilselisih = document.getElementById('totalPembayaran');

            // Tambahkan tanda negatif jika selisih negatif
            if (selisih < 0) {
                hasilselisih.value = '-' + formatRupiah(-selisih);
            } else {
                hasilselisih.value = ' ' + formatRupiah(selisih);
            }

            HitungSelisihHasil();
        }

        function updateSubTotals() {
            // Ambil nilai Total dan pastikan sudah berupa angka
            var Total = parseFloat($('#totalpembayaran').val().replace(/\./g, '')) || 0;
            console.log(Total);

            // Ambil nilai OngkosBongkar dan pastikan sudah berupa angka
            var OngkosBongkar = parseFloat(parseCurrency($('#ongkosBongkar').val().replace(/\./g, ''))) || 0;
            console.log(OngkosBongkar);

            // Ambil nilai HargaTambahan dan pastikan sudah berupa angka
            var HargaTambahan = parseFloat(parseCurrency($('#potonganselisih').val().replace(/\./g, ''))) || 0;
            console.log(HargaTambahan);

            // Hitung Subtotal
            var Subtotal = Total + OngkosBongkar - HargaTambahan;
            console.log(Subtotal);

            // Menetapkan nilai ke input sub_total
            $('#totalPembayaran').val(formatRupiah(Subtotal));
        }

        function parseCurrency(value) {
            return parseFloat(value.replace(/[^\d.-]/g, '')) || 0;
        }

        Hasil()

        function Hasil() {
            function hapusTitik(string) {
                return string.replace(/\./g, '');
            }

            // Fungsi untuk mengubah angka menjadi format mata uang Rupiah
            function formatRupiah(angka) {
                var reverse = angka.toString().split('').reverse().join('');
                var ribuan = reverse.match(/\d{1,3}/g);
                var formatted = ribuan.join('.').split('').reverse().join('');
                return 'Rp ' + formatted;
            }
            // Fungsi untuk menghitung selisih dan menampilkannya
            hitungSelisih();
            // Panggil fungsi hitungSelisih saat input "Nominal" berubah
            document.getElementById('nominal').addEventListener('input', hitungSelisih);

            // Panggil fungsi hitungSelisih saat halaman dimuat (untuk menginisialisasi nilai selisih)
            window.addEventListener('load', hitungSelisih);
        }

        function HitungSelisihHasil() {
            function formatRupiah(angka) {
                var reverse = angka.toString().split('').reverse().join('');
                var ribuan = reverse.match(/\d{1,3}/g);
                var formatted = ribuan.join('.').split('').reverse().join('');
                return 'Rp ' + formatted;
            }

            // Dapatkan nilai dari input "Total Pembayaran" dan hapus titik
            function formatRupiahToNumber(rupiah) {
                // Hapus karakter non-numeric seperti titik dan 'Rp'
                var numericString = rupiah.replace(/[^0-9]/g, '');
                // Konversi string ke tipe data number
                var numericValue = parseFloat(numericString);
                return numericValue;
            }

            // Dapatkan nilai dari input "Total Pembayaran" dan konversikan ke tipe data number
            var totalPembayaranInput = document.getElementById('totalPembayaran');
            var totalPembayaranValue = totalPembayaranInput.value;
            var totalPembayaran = formatRupiahToNumber(totalPembayaranValue);

            // Dapatkan nilai dari input "Nominal" dan hapus titik
            var nominalInput = document.getElementById('nominal');
            var nominalValue = nominalInput.value;
            var nominal = parseFloat(hapusTitik(nominalValue)) || 0;

            console.log(totalPembayaran);
            console.log(nominal);

            // Hitung selisih
            var selisih = totalPembayaran - nominal;

            // Tampilkan hasil selisih dalam format mata uang Rupiah dengan tanda negatif
            var hasilselisih = document.getElementById('hasilselisih');

            // Tambahkan tanda negatif jika selisih negatif
            if (selisih < 0) {
                hasilselisih.value = ' ' + formatRupiah(selisih);
            } else {
                hasilselisih.value = '-' + formatRupiah(-selisih);
            }
        }

        // Panggil fungsi HitungSelisihHasil saat input "Nominal" berubah
        document.getElementById('nominal').addEventListener('input', HitungSelisihHasil);

        // Panggil fungsi HitungSelisihHasil saat halaman dimuat (untuk menginisialisasi nilai selisih)
        window.addEventListener('load', HitungSelisihHasil);
    </script>

@endsection
