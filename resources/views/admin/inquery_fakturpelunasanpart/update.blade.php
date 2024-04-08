@extends('layouts.app')

@section('title', 'Inquery Pelunasan Faktur Pembelian Part')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Inquery Pelunasan Faktur Pembelian Part</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/inquery_partpembelianlunas') }}">Inquery
                                pelunasan Faktur Pembelian Part</a></li>
                        <li class="breadcrumb-item active">Perbarui</li>
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
            <form action="{{ url('admin/inquery_partpembelianlunas/' . $inquery->id) }}" method="POST"
                enctype="multipart/form-data" autocomplete="off">
                @csrf
                @method('put')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Perbarui Pelunasan Faktur Pembelian Part</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group" style="flex: 8;">
                            <div class="row">
                                {{-- <div class="mb-3 mt-4">
                                <button class="btn btn-primary btn-sm" type="button" onclick="ShowMemo(this.value)">
                                    <i class="fas fa-plus mr-2"></i> Pilih Supplier
                                </button>
                            </div> --}}
                                <div class="form-group" hidden>
                                    <label for="supplier_id">pelanggan Id</label>
                                    <input type="text" class="form-control" id="supplier_id" readonly name="supplier_id"
                                        placeholder="" value="{{ old('supplier_id', $inquery->supplier_id) }}">
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label style="font-size:14px" for="kode_supplier">Kode Supplier</label>
                                        <input onclick="showCategoryModalPelanggan(this.value)" style="font-size:14px"
                                            type="text" class="form-control" id="kode_supplier" readonly
                                            name="kode_supplier" placeholder=""
                                            value="{{ old('kode_supplier', $inquery->kode_supplier) }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label style="font-size:14px" class="form-label" for="nama_supplier">Nama
                                        Supplier</label>
                                    <div class="form-group d-flex">
                                        <input onclick="showCategoryModalPelanggan(this.value)" class="form-control"
                                            id="nama_supplier" name="nama_supplier" type="text" placeholder=""
                                            value="{{ old('nama_supplier', $inquery->nama_supplier) }}" readonly
                                            style="margin-right: 10px; font-size:14px" />
                                        <button class="btn btn-primary" type="button"
                                            onclick="showCategoryModalPelanggan(this.value)">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label style="font-size:14px" for="telp_supplier">No. Telp</label>
                                        <input onclick="showCategoryModalPelanggan(this.value)" style="font-size:14px"
                                            type="text" class="form-control" id="telp_supplier" readonly
                                            name="telp_supplier" placeholder=""
                                            value="{{ old('telp_supplier', $inquery->telp_supplier) }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label style="font-size:14px" for="alamat_supplier">Alamat</label>
                                        <input onclick="showCategoryModalPelanggan(this.value)" style="font-size:14px"
                                            type="text" class="form-control" id="alamat_supplier" readonly
                                            name="alamat_supplier" placeholder=""
                                            value="{{ old('alamat_supplier', $inquery->alamat_supplier) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label style="font-size:14px" for="keterangan">Catatan</label>
                            <div class="form-group">
                                <textarea style="font-size:14px" class="form-control" name="keterangan" placeholder="masukkan catatan">{{ old('keterangan', $inquery->keterangan) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Pelunasan Faktur Pembelian Part <span>
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
                                    <th style="font-size:14px">Kode Pembelian</th>
                                    <th style="font-size:14px">Tgl Pembelian</th>
                                    <th style="font-size:14px">Sub Total</th>
                                    <th style="font-size:14px; text-align:center">Opsi</th>
                                </tr>
                            </thead>
                            <tbody id="tabel-pembelian">
                                @foreach ($details as $detail)
                                    <tr id="pembelian-{{ $loop->index }}">
                                        <td style="width: 70px; font-size:14px" class="text-center" id="urutan">
                                            {{ $loop->index + 1 }}
                                        </td>
                                        <div class="form-group" hidden>
                                            <input type="text" class="form-control"
                                                id="nomor_seri-{{ $loop->index }}" name="detail_ids[]"
                                                value="{{ $detail['id'] }}">
                                        </div>
                                        <td hidden>
                                            <div class="form-group">
                                                <input type="text" class="form-control"
                                                    id="pembelian_part_id-{{ $loop->index }}" name="pembelian_part_id[]"
                                                    value="{{ $detail['pembelian_part_id'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input onclick="MemoEkspedisi({{ $loop->index }})"
                                                    style="font-size:14px" readonly type="text" class="form-control"
                                                    id="kode_pembelianpart-{{ $loop->index }}"
                                                    name="kode_pembelianpart[]"
                                                    value="{{ $detail['kode_pembelianpart'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input onclick="MemoEkspedisi({{ $loop->index }})"
                                                    style="font-size:14px" readonly type="text" class="form-control"
                                                    id="tanggal_pembelian-{{ $loop->index }}" name="tanggal_pembelian[]"
                                                    value="{{ $detail['tanggal_pembelian'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input onclick="Return({{ $loop->index }})" style="font-size:14px"
                                                    type="text" readonly class="form-control"
                                                    id="total-{{ $loop->index }}" name="total[]"
                                                    oninput="updateTotalPembayaran()"
                                                    value="{{ number_format($detail['total'], 2, ',', '.') }}">
                                            </div>
                                        </td>
                                        <td style="width: 100px">
                                            <button type="button" class="btn btn-primary btn-sm"
                                                onclick="MemoEkspedisi({{ $loop->index }})">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                            <button style="margin-left:5px" type="button" class="btn btn-danger btn-sm"
                                                onclick="removeBan({{ $loop->index }})">
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
                                                    value="{{ old('potongan', $inquery->potongan) }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label style="font-size:14px" for="tambahan_pembayaran">Ongkos
                                                    Bongkar</label>
                                                <input style="font-size:14px" type="text" class="form-control"
                                                    id="tambahan_pembayaran" name="tambahan_pembayaran"
                                                    placeholder="masukkan ongkos bongkar"
                                                    value="{{ old('tambahan_pembayaran', $inquery->tambahan_pembayaran) }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label style="font-size: 14px" for="panjang">Kategori Pembayaran</label>
                                    <select style="font-size: 14px" class="form-control" id="kategori" name="kategori">
                                        <option value="">- Pilih -</option>
                                        <option value="Bilyet Giro"
                                            {{ old('kategori', $inquery->kategori) == 'Bilyet Giro' ? 'selected' : null }}>
                                            Bilyet Giro BG / Cek</option>
                                        <option value="Transfer"
                                            {{ old('kategori', $inquery->kategori) == 'Transfer' ? 'selected' : null }}>
                                            Transfer</option>
                                        <option value="Tunai"
                                            {{ old('kategori', $inquery->kategori) == 'Tunai' ? 'selected' : null }}>
                                            Tunai</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label style="font-size: 14px" id="bg" for="lebar">No. BG/Cek</label>
                                    <label style="font-size: 14px" id="trans" for="lebar">No. Transfer</label>
                                    <label style="font-size: 14px" id="tun" for="lebar">Tunai</label>
                                    <input style="font-size: 14px" type="text" class="form-control" id="nomor"
                                        name="nomor" placeholder="masukkan no"
                                        value="{{ old('nomor', $inquery->nomor) }}">
                                </div>
                                <div class="form-group">
                                    <label style="font-size: 14px" for="tinggi">Tanggal</label>
                                    <div class="input-group date" id="reservationdatetime">
                                        <input style="font-size: 14px" type="date" id="tanggal"
                                            name="tanggal_transfer" placeholder="d M Y sampai d M Y"
                                            data-options='{"mode":"range","dateFormat":"d M Y","disableMobile":true}'
                                            value="{{ old('tanggal_transfer', $inquery->tanggal_transfer) }}"
                                            class="form-control datetimepicker-input" data-target="#reservationdatetime">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label style="font-size: 14px" for="tinggi">Nominal</label>
                                    <input style="font-size: 14px" type="text" class="form-control" id="nominal"
                                        placeholder="masukkan nominal" name="nominal" name="nominal"
                                        value="{{ number_format(old('nominal', $inquery->nominal), 2, ',', '.') }}">
                                </div>
                            </div>
                            <div class="col-md-6" style="margin-left: 89px">
                                <div class="form-group">
                                    <label style="font-size: 14px" for="totalpenjualan">Sub Total</label>
                                    <input style="text-align: end; font-size: 14px" type="text" class="form-control"
                                        id="totalpembayaran" readonly name="totalpenjualan" placeholder=""
                                        value="{{ old('totalpenjualan', number_format($inquery->totalpenjualan, 2, ',', '.')) }}">

                                </div>
                                <div class="form-group">
                                    <label style="font-size: 14px" for="tinggi">Ongkos Bongkar</label>
                                    <input style="text-align: end; font-size: 14px" type="text" class="form-control"
                                        id="ongkosBongkar" readonly name="dp" placeholder=""
                                        value="{{ old('dp', number_format($inquery->dp, 2, ',', '.')) }}">

                                </div>
                                <div class="form-group">
                                    <label style="font-size: 14px" for="tinggi">Potongan</label>
                                    <input style="text-align: end; font-size: 14px" type="text" class="form-control"
                                        id="potonganselisih" readonly name="potonganselisih" placeholder=""
                                        value="{{ old('potonganselisih', number_format($inquery->potonganselisih, 2, ',', '.')) }}">
                                </div>
                                <hr style="border: 2px solid black;">
                                <div class="form-group">
                                    <label style="font-size: 14px" for="tinggi">Total Pembayaran</label>
                                    <input style="text-align: end; font-size: 14px" type="text" class="form-control"
                                        id="totalPembayaran" readonly name="totalpembayaran"
                                        value="{{ old('totalpembayaran', $inquery->totalpembayaran) }}" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label style="font-size: 14px" for="tinggi">Selisih Pembayaran</label>
                                    <input style="text-align: end; font-size: 14px" type="text" class="form-control"
                                        id="hasilselisih" readonly name="selisih"
                                        value="{{ old('selisih', number_format($inquery->selisih, 2, ',', '.')) }}"
                                        placeholder="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="reset" class="btn btn-secondary" id="btnReset">Reset</button>
                        <button type="submit" class="btn btn-primary" id="btnSimpan">Simpan</button>
                        <div id="loading" style="display: none;">
                            <i class="fas fa-spinner fa-spin"></i> Sedang Menyimpan...
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="modal fade" id="tableSupplier" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Supplier</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table id="datatables4" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Kode Supplier</th>
                                    <th>Nama Supplier</th>
                                    <th>Alamat</th>
                                    <th>No. Telp</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($suppliers as $supplier)
                                    <tr
                                        onclick="getSelectedDataPelanggan('{{ $supplier->id }}', '{{ $supplier->kode_supplier }}', '{{ $supplier->nama_supp }}', '{{ $supplier->alamat }}', '{{ $supplier->telp }}')">
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $supplier->kode_supplier }}</td>
                                        <td>{{ $supplier->nama_supp }}</td>
                                        <td>{{ $supplier->alamat }}</td>
                                        <td>{{ $supplier->telp }}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-primary btn-sm"
                                                onclick="getSelectedDataPelanggan('{{ $supplier->id }}', '{{ $supplier->kode_supplier }}', '{{ $supplier->nama_supp }}', '{{ $supplier->alamat }}', '{{ $supplier->telp }}')">
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

        <div class="modal fade" id="tablePart" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Faktur Pembelian Part</h4>
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
                                    <th>Kode Faktur</th>
                                    <th>Tanggal</th>
                                    <th>Pelanggan</th>
                                    <th>Total</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($fakturs as $faktur)
                                    <tr onclick="getFaktur({{ $loop->index }})" data-id="{{ $faktur->id }}"
                                        data-kode_pembelianpart="{{ $faktur->kode_pembelianpart }}"
                                        data-tanggal_awal="{{ $faktur->tanggal_awal }}"
                                        data-grand_total="{{ $faktur->grand_total }}" data-param="{{ $loop->index }}">
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $faktur->kode_pembelianpart }}</td>
                                        <td>{{ $faktur->tanggal }}</td>
                                        <td>{{ $faktur->supplier->nama_supp }}</td>
                                        {{-- <td>
                                            {{ $faktur->kode_pembelianpart }}
                                        </td> --}}
                                        <td>{{ number_format($faktur->grand_total, 2, ',', '.') }}</td>

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

    </section>

    <script>
        function showCategoryModalPelanggan(selectedCategory) {
            $('#tableSupplier').modal('show');
        }

        function getSelectedDataPelanggan(Supplier_id, KodePelanggan, NamaPell, AlamatPel, Telpel) {
            // Set the values in the form fields
            document.getElementById('supplier_id').value = Supplier_id;
            document.getElementById('kode_supplier').value = KodePelanggan;
            document.getElementById('nama_supplier').value = NamaPell;
            document.getElementById('alamat_supplier').value = AlamatPel;
            document.getElementById('telp_supplier').value = Telpel;
            // Close the modal (if needed)
            $('#tableSupplier').modal('hide');
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
            } else {
                // Find the last row and get its index to continue the numbering
                var lastRow = $('#tabel-pembelian tr:last');
                var lastRowIndex = lastRow.find('#urutan').text();
                jumlah_ban = parseInt(lastRowIndex) + 1;
            }

            console.log('Current jumlah_ban:', jumlah_ban);
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
            updateTotalPembayaran()
        }

        function itemPembelian(identifier, key, value = null) {
            var pembelian_part_id = '';
            var kode_pembelianpart = '';
            var tanggal_pembelian = '';
            var total = '';

            if (value !== null) {
                pembelian_part_id = value.pembelian_part_id;
                kode_pembelianpart = value.kode_pembelianpart;
                tanggal_pembelian = value.tanggal_pembelian;
                total = value.total;
            }
            // urutan 
            var item_pembelian = '<tr id="pembelian-' + key + '">';
            item_pembelian += '<td style="width: 70px; font-size:14px" class="text-center" id="urutan">' + key + '</td>';

            // pembelian_part_id 
            item_pembelian += '<td hidden>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" id="pembelian_part_id-' + key +
                '" name="pembelian_part_id[]" value="' +
                pembelian_part_id +
                '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // kode_pembelianpart
            item_pembelian += '<td onclick="MemoEkspedisi(' + key +
                ')">';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control" style="font-size:14px" readonly id="kode_pembelianpart-' +
                key + '" name="kode_pembelianpart[]" value="' +
                kode_pembelianpart +
                '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // tanggal_pembelian
            item_pembelian += '<td onclick="MemoEkspedisi(' + key +
                ')">';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control" style="font-size:14px" readonly id="tanggal_pembelian-' + key +
                '" name="tanggal_pembelian[]" value="' +
                tanggal_pembelian +
                '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // total 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control" readonly style="font-size:14px" id="total-' +
                key +
                '" name="total[]" value="' + total + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            item_pembelian += '<td style="width: 100px">';
            item_pembelian += '<button type="button" class="btn btn-primary btn-sm" onclick="MemoEkspedisi(' + key +
                ')">';
            item_pembelian += '<i class="fas fa-plus"></i>';
            item_pembelian += '</button>';
            item_pembelian +=
                '<button style="margin-left:10px" type="button" class="btn btn-danger btn-sm" onclick="removeBan(' +
                key + ')">';
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
            $('#tablePart').modal('show');
        }

        function getFaktur(rowIndex) {
            var selectedRow = $('#tables tbody tr:eq(' + rowIndex + ')');
            var pembelian_part_id = selectedRow.data('id');
            var kode_pembelianpart = selectedRow.data('kode_pembelianpart');
            var tanggal_awal = selectedRow.data('tanggal_awal');
            var grand_total = selectedRow.data('grand_total');

            $('#pembelian_part_id-' + activeSpecificationIndex).val(pembelian_part_id);
            $('#kode_pembelianpart-' + activeSpecificationIndex).val(kode_pembelianpart);
            $('#tanggal_pembelian-' + activeSpecificationIndex).val(tanggal_awal);
            $('#total-' + activeSpecificationIndex).val(grand_total);

            updateTotalPembayaran();
            Hasil(); // Panggil Hasil dengan tanda kurung

            $('#tablePart').modal('hide');
        }

        function updateTotalPembayaran() {
            var grandTotal = 0;

            // Iterate through all input elements with IDs starting with 'total-'
            $('input[id^="total-"]').each(function() {
                // Remove dots and replace comma with dot, then parse as float
                var nilaiTotal = parseFloat($(this).val().replace(/\./g, '').replace(',', '.')) || 0;
                grandTotal += nilaiTotal;
            });

            // Format grandTotal as currency in Indonesian Rupiah
            var formattedGrandTotal = grandTotal.toLocaleString('id-ID');
            console.log(formattedGrandTotal);
            // Set the formatted grandTotal to the target element
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
            var ongkosBongkarInput = document.getElementById('tambahan_pembayaran');

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

            // Mendengarkan perubahan pada input "tambahan_pembayaran"
            ongkosBongkarInput.addEventListener('input', function() {
                var potonganValue = this.value;

                // Jika input tambahan_pembayaran kosong, atur nilai ongkosBongkar ke 0
                if (potonganValue === '') {
                    dpInput.value = '0';
                } else {
                    var formattedValue = formatRupiah(potonganValue);
                    dpInput.value = formattedValue;
                }
            });
            var oldOngkosBongkar = "{{ old('tambahan_pembayaran') }}";
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

            document.getElementById('tambahan_pembayaran').addEventListener('input', hitungSelisih);
            // Panggil fungsi hitungSelisih saat halaman dimuat (untuk menginisialisasi nilai selisih)
            window.addEventListener('load', hitungSelisih);
        }

        // function hapusTitik(string) {
        //     return string.replace(/\./g, '');
        // }

        function hapusTitik(string) {
            // Menghapus titik dan mengganti koma dengan titik
            return string.replace(/\./g, '').replace(',', '.');
        }


        function formatRupiah(number) {
            var formatted = new Intl.NumberFormat('id-ID', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(number);
            return '' + formatted;
        }

        // function formatRupiah(angka) {
        //     var reverse = angka.toString().split('').reverse().join('');
        //     var ribuan = reverse.match(/\d{1,3}/g);
        //     var formatted = ribuan.join('.').split('').reverse().join('');
        //     return 'Rp ' + formatted;
        // }


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
            var OngkosInput = document.getElementById('tambahan_pembayaran');
            var OngkosValue = OngkosInput.value;
            var Ongkos = parseFloat(hapusTitik(OngkosValue)) || 0;

            // Hitung selisih
            var selisih = totalPembayaran + Ongkos - nominal;
            // console.log(selisih);

            // Tampilkan hasil selisih dalam format mata uang Rupiah dengan tanda negatif
            var hasilselisih = document.getElementById('totalPembayaran');

            // Tambahkan tanda negatif jika selisih negatif
            if (selisih < 0) {
                hasilselisih.value = '-' + formatRupiah(selisih);
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
                return '' + formatted;
            }
            // Fungsi untuk menghitung selisih dan menampilkannya
            hitungSelisih();
            // Panggil fungsi hitungSelisih saat input "Nominal" berubah
            document.getElementById('nominal').addEventListener('input', hitungSelisih);

            // Panggil fungsi hitungSelisih saat halaman dimuat (untuk menginisialisasi nilai selisih)
            window.addEventListener('load', hitungSelisih);
        }

        function HitungSelisihHasil() {
            function formatRupiah(number) {
                var formatted = new Intl.NumberFormat('id-ID', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }).format(number);
                return '' + formatted;
            }



            function formatRupiahToNumber(rupiah) {
                // Hapus karakter non-numeric kecuali koma
                var numericString = rupiah.replace(/[^0-9,]/g, '');

                // Ganti koma dengan titik jika diperlukan
                numericString = numericString.replace(',', '.');

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

            // console.log(totalPembayaran);

            // Hitung selisih
            var selisih = totalPembayaran - nominal;

            console.log(selisih);

            // Tampilkan hasil selisih dalam format mata uang Rupiah dengan tanda negatif
            var hasilselisih = document.getElementById('hasilselisih');

            // Tambahkan tanda negatif jika selisih negatif
            if (selisih < 0) {
                hasilselisih.value = formatRupiahss(selisih);
            } else {
                hasilselisih.value = ' -' + formatRupiahss(selisih);
            }

            function formatRupiahss(number) {
                var formatted = new Intl.NumberFormat('id-ID', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }).format(number);
                return '' + formatted;
            }

        }

        // Panggil fungsi HitungSelisihHasil saat input "Nominal" berubah
        document.getElementById('nominal').addEventListener('input', HitungSelisihHasil);

        // Panggil fungsi HitungSelisihHasil saat halaman dimuat (untuk menginisialisasi nilai selisih)
        window.addEventListener('load', HitungSelisihHasil);
    </script>

    <script>
        $(document).ready(function() {
            // Tambahkan event listener pada tombol "Simpan"
            $('#btnSimpan').click(function() {
                // Sembunyikan tombol "Simpan" dan "Reset", serta tampilkan elemen loading
                $(this).hide();
                $('#btnReset').hide(); // Tambahkan id "btnReset" pada tombol "Reset"
                $('#loading').show();

                // Lakukan pengiriman formulir
                $('form').submit();
            });
        });
    </script>



@endsection
