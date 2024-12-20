@extends('layouts.app')

@section('title', 'Inquery Invoice F. Sewa Kendaraan')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Inquery Invoice F. Sewa Kendaraan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/inquery_invoicesewakendaraan') }}">Inquery Invoice
                                F.
                                Sewa Kendaraan</a></li>
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
                        <i class="icon fas fa-ban"></i> Gagal!
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
                        <i class="icon fas fa-ban"></i> Gagal!
                    </h5>
                    {{ session('erorrss') }}
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
            <form action="{{ url('admin/inquery_invoicesewakendaraan/' . $inquery->id) }}" method="POST"
                enctype="multipart/form-data" autocomplete="off">
                @csrf
                @method('put')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">perbarui Invoice F. Sewa Kendaraan</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group">
                            <label style="font-size:14px" class="form-label" for="kategori">Pilih Kategori</label>
                            <input type="text" class="form-control" id="kategori" readonly name="kategori"
                                placeholder="" value="{{ old('kategori', $inquery->kategori) }}">
                        </div>
                        <div class="form-group" style="flex: 8;">
                            <div class="row">
                                <div class="form-group" hidden>
                                    <label for="vendor_id">Rekanan Id</label>
                                    <input type="text" class="form-control" id="vendor_id" readonly name="vendor_id"
                                        placeholder="" value="{{ old('vendor_id', $inquery->vendor_id) }}">
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label style="font-size:14px" for="kode_vendor">Kode Rekanan</label>
                                        <input onclick="showCategoryModalPelanggan(this.value)" style="font-size:14px"
                                            type="text" class="form-control" id="kode_vendor" readonly name="kode_vendor"
                                            placeholder="" value="{{ old('kode_vendor', $inquery->kode_vendor) }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label style="font-size:14px" class="form-label" for="nama_vendor">Nama
                                        Rekanan</label>
                                    <div class="form-group d-flex">
                                        <input onclick="showCategoryModalPelanggan(this.value)" class="form-control"
                                            id="nama_vendor" name="nama_vendor" type="text" placeholder=""
                                            value="{{ old('nama_vendor', $inquery->nama_vendor) }}" readonly
                                            style="margin-right: 10px; font-size:14px" />
                                        <button class="btn btn-primary" type="button"
                                            onclick="showCategoryModalPelanggan(this.value)">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label style="font-size:14px" for="telp_vendor">No. Telp</label>
                                        <input onclick="showCategoryModalPelanggan(this.value)" style="font-size:14px"
                                            type="text" class="form-control" id="telp_vendor" readonly name="telp_vendor"
                                            placeholder="" value="{{ old('telp_vendor', $inquery->telp_vendor) }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label style="font-size:14px" for="alamat_vendor">Alamat</label>
                                        <input onclick="showCategoryModalPelanggan(this.value)" style="font-size:14px"
                                            type="text" class="form-control" id="alamat_vendor" readonly
                                            name="alamat_vendor" placeholder=""
                                            value="{{ old('alamat_vendor', $inquery->alamat_vendor) }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label>Periode:</label>
                                    <div class="input-group date" id="reservationdatetime">
                                        <input type="date" id="periode_awal" name="periode_awal"
                                            placeholder="d M Y sampai d M Y"
                                            data-options='{"mode":"range","dateFormat":"d M Y","disableMobile":true}'
                                            value="{{ old('periode_awal', $inquery->periode_awal) }}"
                                            class="form-control datetimepicker-input" data-target="#reservationdatetime">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label style="color:white">.</label>
                                    <div class="input-group date" id="reservationdatetime">
                                        <input type="date" id="periode_akhir" name="periode_akhir"
                                            placeholder="d M Y sampai d M Y"
                                            data-options='{"mode":"range","dateFormat":"d M Y","disableMobile":true}'
                                            value="{{ old('periode_akhir', $inquery->periode_akhir) }}"
                                            class="form-control datetimepicker-input" data-target="#reservationdatetime">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Faktur Sewa Kendaraan <span>
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
                                    <th style="font-size:14px">No. SJ</th>
                                    {{-- <th style="font-size:14px">No. PO</th> --}}
                                    <th style="font-size:14px">No Mobil</th>
                                    <th style="font-size:14px">Qty</th>
                                    {{-- <th style="font-size:14px">Satuan</th> --}}
                                    <th style="font-size:14px">Harga</th>
                                    <th style="font-size:14px">Potongan</th>
                                    <th style="font-size:14px">Total</th>
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
                                                    id="sewa_kendaraan_id-{{ $loop->index }}" name="sewa_kendaraan_id[]"
                                                    value="{{ $detail['sewa_kendaraan_id'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input onclick="MemoEkspedisi({{ $loop->index }})"
                                                    style="font-size:14px" readonly type="text" class="form-control"
                                                    id="nama_rute-{{ $loop->index }}" name="nama_rute[]"
                                                    value="{{ $detail['nama_rute'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input style="font-size:14px" type="text" class="form-control"
                                                    id="tanggal_memo-{{ $loop->index }}" name="tanggal_memo[]"
                                                    value="{{ $detail['tanggal_memo'] }}">
                                            </div>
                                        </td>
                                        <td style="width: 150px">
                                            <div class="form-group">
                                                <input onclick="MemoEkspedisi({{ $loop->index }})"
                                                    style="font-size:14px" readonly type="text" class="form-control"
                                                    id="kode_faktur-{{ $loop->index }}" name="kode_faktur[]"
                                                    value="{{ $detail['kode_faktur'] }}">
                                            </div>
                                        </td>
                                        <td hidden>
                                            <div class="form-group">
                                                <input style="font-size:14px" readonly type="text"
                                                    class="form-control" id="no_memo-{{ $loop->index }}"
                                                    name="no_memo[]" value="{{ $detail['no_memo'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input style="font-size:14px" type="text" class="form-control"
                                                    id="no_do-{{ $loop->index }}" name="no_do[]"
                                                    value="{{ $detail['no_do'] }}">
                                            </div>
                                        </td>
                                        {{-- <td>
                                            <div class="form-group">
                                                <input onclick="MemoEkspedisi({{ $loop->index }})"
                                                    style="font-size:14px" type="text" class="form-control"
                                                    id="no_po-{{ $loop->index }}" name="no_po[]"
                                                    value="{{ $detail['no_po'] }}">
                                            </div>
                                        </td> --}}
                                        <td hidden>
                                            <div class="form-group">
                                                <input style="font-size:14px" readonly type="text"
                                                    class="form-control" id="no_kabin-{{ $loop->index }}"
                                                    name="no_kabin[]" value="{{ $detail['no_kabin'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input onclick="MemoEkspedisi({{ $loop->index }})"
                                                    style="font-size:14px" readonly type="text" class="form-control"
                                                    id="no_pol-{{ $loop->index }}" name="no_pol[]"
                                                    value="{{ $detail['no_pol'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input onclick="MemoEkspedisi({{ $loop->index }})"
                                                    style="font-size:14px" readonly type="text" class="form-control"
                                                    id="jumlah-{{ $loop->index }}" name="jumlah[]"
                                                    value="{{ $detail['jumlah'] }}">
                                            </div>
                                        </td>
                                        <td hidden>
                                            <div class="form-group">
                                                <input style="font-size:14px" readonly type="text"
                                                    class="form-control" id="satuan-{{ $loop->index }}" name="satuan[]"
                                                    value="{{ $detail['satuan'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input onclick="MemoEkspedisi({{ $loop->index }})"
                                                    style="font-size:14px" readonly type="text" class="form-control"
                                                    id="harga-{{ $loop->index }}" name="harga[]"
                                                    value="{{ number_format($detail['harga'], 0, ',', '.') }}">
                                            </div>
                                        </td>

                                        <td>
                                            <div class="form-group">
                                                <input onclick="MemoEkspedisi({{ $loop->index }})"
                                                    style="font-size:14px" readonly type="text" class="form-control"
                                                    id="nominal_potongan-{{ $loop->index }}" name="nominal_potongan[]"
                                                    value="{{ number_format($detail['nominal_potongan'], 0, ',', '.') }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input onclick="MemoEkspedisi({{ $loop->index }})"
                                                    style="font-size:14px" readonly type="text" class="form-control"
                                                    id="total-{{ $loop->index }}" name="total[]"
                                                    value="{{ number_format($detail['total'], 2, ',', '.') }}">
                                            </div>
                                        </td>
                                        <td style="width: 100px">
                                            <button type="button" class="btn btn-primary btn-sm"
                                                onclick="MemoEkspedisi({{ $loop->index }})">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                            <button style="margin-left:5px" type="button" class="btn btn-danger btn-sm"
                                                onclick="removeBan({{ $loop->index }}, {{ $detail['id'] }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="form-group mt-2">
                            <label style="font-size:14px" for="keterangan">Keterangan</label>
                            <textarea style="font-size:14px" type="text" class="form-control" id="keterangan" name="keterangan"
                                placeholder="Masukan keterangan">{{ old('keterangan', $inquery->keterangan) }}</textarea>
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
                                                    name="sub_total" placeholder=""
                                                    value="{{ old('sub_total', number_format($inquery->sub_total, 0, ',', '.')) }}">
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
                                                    placeholder="" value="{{ old('pph', $inquery->pph) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <hr
                                            style="border: 2px solid black; display: inline-block; width: 98%; vertical-align: middle;">
                                        <span
                                            style="display: inline-block; margin-left: 0px; margin-right: 0; font-size: 18px; vertical-align: middle;">-</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label style="font-size:14px; margin-top:5px" for="grand_total">Grand
                                        Total <span style="margin-left:46px">:</span></label>
                                    <input style="text-align: end; margin:right:10px; font-size:14px;" type="text"
                                        class="form-control grand_total" readonly id="grand_total" name="grand_total"
                                        placeholder="" value="{{ old('grand_total', $inquery->grand_total) }}">
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
                        <h4 class="modal-title">Data Rekanan</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table id="datatables4" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Kode Rekanan</th>
                                    <th>Nama Rekanan</th>
                                    <th>Alamat</th>
                                    <th>No. Telp</th>
                                    {{-- <th>Kategori</th> --}}
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $uniqueCustomerIds = [];
                                @endphp

                                @foreach ($fakturs as $faktur)
                                    @php
                                        $customerId = $faktur->vendor->id;
                                    @endphp

                                    @if (!in_array($customerId, $uniqueCustomerIds))
                                        <tr
                                            onclick="getSelectedDataVendor('{{ $faktur->vendor->id }}', '{{ $faktur->vendor->kode_vendor }}', '{{ $faktur->vendor->nama_vendor }}', '{{ $faktur->vendor->alamat }}', '{{ $faktur->vendor->telp }}')">
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            {{-- <td>{{ $faktur->vendor->id }}</td> --}}
                                            <td>{{ $faktur->vendor->kode_vendor }}</td>
                                            <td>{{ $faktur->vendor->nama_vendor }}</td>
                                            <td>{{ $faktur->vendor->alamat }}</td>
                                            <td>{{ $faktur->vendor->telp }}</td>
                                            {{-- <td>{{ $faktur->kategori }}</td> --}}
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="getSelectedDataVendor('{{ $faktur->vendor->id }}', '{{ $faktur->vendor->kode_vendor }}', '{{ $faktur->vendor->nama_vendor }}', '{{ $faktur->vendor->alamat }}', '{{ $faktur->vendor->telp }}')">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @php
                                            $uniqueCustomerIds[] = $customerId;
                                        @endphp
                                    @endif
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
                        <div class="m-2">
                            <input type="text" id="searchInputrutes" class="form-control" placeholder="Search...">
                        </div>
                        <table id="tablefaktur" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Kode Faktur</th>
                                    <th>Tanggal</th>
                                    <th>Rekanan</th>
                                    <th>Rute</th>
                                    <th>Kategori</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Faktur data will be populated here via JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <script>
        function filterTablefaktur() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchInputrutes");
            filter = input.value.toUpperCase();
            table = document.getElementById("tablefaktur");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                var displayRow = false;

                // Loop through columns (td 1, 2, and 3)
                for (j = 1; j <= 4; j++) {
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
        document.getElementById("searchInputrutes").addEventListener("input", filterTablefaktur);
    </script>

    <script>
        function showCategoryModalPelanggan(selectedCategory) {
            $('#tablePelanggan').modal('show');
        }

        function getSelectedDataVendor(Pelanggan_id, KodePelanggan, NamaPell, AlamatPel, Telpel) {
            // Set the values in the form fields
            document.getElementById('vendor_id').value = Pelanggan_id;
            document.getElementById('kode_vendor').value = KodePelanggan;
            document.getElementById('nama_vendor').value = NamaPell;
            document.getElementById('alamat_vendor').value = AlamatPel;
            document.getElementById('telp_vendor').value = Telpel;

            $('#vendor_id').trigger('input');

            // Close the modal (if needed)
            $('#tablePelanggan').modal('hide');
        }
    </script>

    {{-- filter kategori  --}}
    <script>
        $(document).ready(function() {
            // Define a function to handle category filtering
            function filterCategory(selectedCategory) {
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
            }

            // Listen for changes in the category dropdown
            $('#kategori').change(function() {
                // Get the selected category value
                var selectedCategory = $(this).val();

                // Call the filterCategory function
                filterCategory(selectedCategory);
            });

            // Call the filterCategory function on page load
            var selectedCategoryOnLoad = $('#kategori').val();
            filterCategory(selectedCategoryOnLoad);
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

            // Mengambil kode faktur yang akan dihapus
            var kode_faktur = row.querySelector('[id^="kode_faktur"]').value;
            removeFaktur(kode_faktur);

            row.remove();

            // console.log(detailId);

            $.ajax({
                url: "{{ url('admin/inquery_invoicesewakendaraan/deletedetailsewa/') }}/" + detailId,
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
            updateGrandTotal()
        }

        function itemPembelian(identifier, key, value = null) {
            var sewa_kendaraan_id = '';
            var nama_rute = '';
            var tanggal_memo = '';
            var kode_faktur = '';
            var no_memo = '';
            var no_do = '';
            // var no_po = '';
            var no_kabin = '';
            var no_pol = '';
            var jumlah = '';
            var satuan = '';
            var harga = '';
            var nominal_potongan = '';
            var total = '';

            if (value !== null) {
                sewa_kendaraan_id = value.sewa_kendaraan_id;
                nama_rute = value.nama_rute;
                tanggal_memo = value.tanggal_memo;
                kode_faktur = value.kode_faktur;
                no_memo = value.no_memo;
                no_do = value.no_do;
                // no_po = value.no_po;
                no_kabin = value.no_kabin;
                no_pol = value.no_pol;
                jumlah = value.jumlah;
                satuan = value.satuan;
                harga = value.harga;
                nominal_potongan = value.nominal_potongan;
                total = value.total;
            }

            // urutan 
            var item_pembelian = '<tr id="pembelian-' + identifier + '">';
            item_pembelian += '<td style="width: 70px; font-size:14px" class="text-center" id="urutan">' + identifier +
                '</td>';

            // sewa_kendaraan_id 
            item_pembelian += '<td hidden>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" id="sewa_kendaraan_id-' + identifier +
                '" name="sewa_kendaraan_id[]" value="' +
                sewa_kendaraan_id +
                '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // nama_rute
            item_pembelian += '<td onclick="MemoEkspedisi(' + identifier +
                ')">';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" readonly style="font-size:14px" id="nama_rute-' +
                identifier + '" name="nama_rute[]" value="' +
                nama_rute +
                '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // tanggal_memo
            item_pembelian += '<td >';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" style="font-size:14px" id="tanggal_memo-' +
                identifier + '" name="tanggal_memo[]" value="' +
                tanggal_memo +
                '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // kode_faktur
            item_pembelian += '<td style="width: 150px" onclick="MemoEkspedisi(' + identifier +
                ')">';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" readonly style="font-size:14px" id="kode_faktur-' +
                identifier + '" name="kode_faktur[]" value="' +
                kode_faktur +
                '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // no_memo
            item_pembelian += '<td hidden>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" readonly style="font-size:14px" id="no_memo-' +
                identifier +
                '" name="no_memo[]" value="' +
                no_memo +
                '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // no_do 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" style="font-size:14px" id="no_do-' +
                identifier +
                '" name="no_do[]" value="' + no_do + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // // no_po 
            // item_pembelian += '<td>';
            // item_pembelian += '<div class="form-group">'
            // item_pembelian += '<input type="text" class="form-control" style="font-size:14px" id="no_po-' +
            //     identifier +
            //     '" name="no_po[]" value="' + no_po + '" ';
            // item_pembelian += '</div>';
            // item_pembelian += '</td>';

            // no_kabin
            item_pembelian += '<td hidden>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" readonly style="font-size:14px" id="no_kabin-' +
                identifier + '" name="no_kabin[]" value="' +
                no_kabin +
                '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // no_pol
            item_pembelian += '<td onclick="MemoEkspedisi(' + identifier +
                ')">';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" readonly style="font-size:14px" id="no_pol-' +
                identifier +
                '" name="no_pol[]" value="' +
                no_pol +
                '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';


            // jumlah
            item_pembelian += '<td onclick="MemoEkspedisi(' + identifier +
                ')">';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" readonly style="font-size:14px" id="jumlah-' +
                identifier +
                '" name="jumlah[]" value="' +
                jumlah +
                '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // satuan
            item_pembelian += '<td hidden>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" readonly style="font-size:14px" id="satuan-' +
                identifier +
                '" name="satuan[]" value="' +
                satuan +
                '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';


            // harga
            item_pembelian += '<td onclick="MemoEkspedisi(' + identifier +
                ')">';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" readonly style="font-size:14px" id="harga-' +
                identifier +
                '" name="harga[]" value="' +
                harga +
                '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // nominal_potongan
            item_pembelian += '<td onclick="MemoEkspedisi(' + identifier +
                ')">';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control" readonly style="font-size:14px" id="nominal_potongan-' +
                identifier +
                '" name="nominal_potongan[]" value="' +
                nominal_potongan +
                '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // total
            item_pembelian += '<td onclick="MemoEkspedisi(' + identifier +
                ')">';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" readonly style="font-size:14px" id="total-' +
                identifier +
                '" name="total[]" value="' +
                total +
                '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // delete
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            item_pembelian += '<td style="width: 100px">';
            item_pembelian += '<button type="button" class="btn btn-primary btn-sm" onclick="MemoEkspedisi(' + identifier +
                ')">';
            item_pembelian += '<i class="fas fa-plus"></i>';
            item_pembelian += '</button>';
            item_pembelian +=
                '<button  style="margin-left:10px" type="button" class="btn btn-danger btn-sm" onclick="removeBan(' +
                identifier +
                ')">';
            item_pembelian += '<i class="fas fa-trash"></i>';
            item_pembelian += '</button>';
            item_pembelian += '</td>';
            item_pembelian += '</tr>';

            $('#tabel-pembelian').append(item_pembelian);

        }
    </script>

    <script>
        var activeSpecificationIndex = 0;
        var fakturAlreadySelected = [];

        document.addEventListener('DOMContentLoaded', function() {
            var tbody = document.getElementById('tabel-pembelian');
            var inputs = tbody.querySelectorAll('input[name="kode_faktur[]"]');

            inputs.forEach(function(input) {
                fakturAlreadySelected.push(input.value);
            });

            console.log(fakturAlreadySelected); // Untuk memeriksa apakah array sudah terisi dengan benar
        });

        function MemoEkspedisi(param) {
            activeSpecificationIndex = param;
            // Show the modal and filter rows if necessary
            $('#tableMemo').modal('show');
            console.log(param);
        }

        function getFaktur(rowIndex) {
            var selectedRow = $('#tablefaktur tbody tr:eq(' + rowIndex + ')');
            var sewa_kendaraan_id = selectedRow.data('id');
            var kode_faktur = selectedRow.data('kode_faktur');

            if (fakturAlreadySelected.includes(kode_faktur)) {
                alert('Kode faktur sudah dipilih sebelumnya.');
                return;
            }
            fakturAlreadySelected.push(kode_faktur); // Menambahkan kode faktur ke daftar yang sudah dipilih

            var nama_rute = selectedRow.data('nama_rute');
            var kode_memo = selectedRow.data('kode_memo');
            var tanggal_awal = selectedRow.data('tanggal_awal');
            var no_kabin = selectedRow.data('no_kabin');
            var no_pol = selectedRow.data('no_pol');
            var jumlah = selectedRow.data('jumlah');
            var satuan = selectedRow.data('satuan');
            var harga = selectedRow.data('harga_tarif');
            var nominal_potongan = selectedRow.data('nominal_potongan');
            var sub_total = selectedRow.data('total_tarif');

            // Update the form fields for the active specification
            $('#sewa_kendaraan_id-' + activeSpecificationIndex).val(sewa_kendaraan_id);
            $('#kode_faktur-' + activeSpecificationIndex).val(kode_faktur);
            $('#nama_rute-' + activeSpecificationIndex).val(nama_rute);
            $('#no_memo-' + activeSpecificationIndex).val(kode_memo);
            $('#tanggal_memo-' + activeSpecificationIndex).val(tanggal_awal);
            $('#no_kabin-' + activeSpecificationIndex).val(no_kabin);
            $('#no_pol-' + activeSpecificationIndex).val(no_pol);
            $('#jumlah-' + activeSpecificationIndex).val(jumlah);
            $('#satuan-' + activeSpecificationIndex).val(satuan);

            $('#harga-' + activeSpecificationIndex).val(parseFloat(harga).toLocaleString('id-ID'));
            $('#nominal_potongan-' + activeSpecificationIndex).val(parseFloat(nominal_potongan).toLocaleString('id-ID'));
            $('#total-' + activeSpecificationIndex).val(parseFloat(sub_total).toLocaleString('id-ID'));

            updateGrandTotal()

            $('#tableMemo').modal('hide');
        }

        function removeFaktur(kode_faktur) {
            var index = fakturAlreadySelected.indexOf(kode_faktur);
            if (index > -1) {
                fakturAlreadySelected.splice(index, 1);
            }
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
        function updateGrandTotal() {
            var grandTotal = 0;
            var kategori = document.getElementById("kategori").value;

            // Loop through all elements with name "nominal_tambahan[]"
            $('input[name^="total"]').each(function() {
                var nominalValue = $(this).val().replace(/\./g, '').replace(',',
                    '.'); // Replace dots and convert comma to dot
                grandTotal += parseFloat(nominalValue) || 0; // Convert to float and sum
            });

            var pph2Value = grandTotal * 0.02;

            // $('#sub_total').val(grandTotal.toLocaleString('id-ID'));
            $('#sub_total').val(formatRupiah(grandTotal));
            $('#pph2').val(pph2Value.toLocaleString('id-ID'));

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

        function formatRupiah(number) {
            var formatted = new Intl.NumberFormat('id-ID', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(number);
            return '' + formatted;
        }
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


    <script>
        var tanggalAwal = document.getElementById('periode_awal');
        var tanggalAkhir = document.getElementById('periode_akhir');
        if (tanggalAwal.value == "") {
            tanggalAkhir.readOnly = true;
        }
        tanggalAwal.addEventListener('change', function() {
            if (this.value == "") {
                tanggalAkhir.readOnly = true;
            } else {
                tanggalAkhir.readOnly = false;
            };
            tanggalAkhir.value = "";
            var today = new Date().toISOString().split('T')[0];
            tanggalAkhir.value = today;
            tanggalAkhir.setAttribute('min', this.value);
        });
    </script>


    <script>
        $(document).ready(function() {
            $('#vendor_id').on('input', function() {
                var pelangganID = $(this).val();

                // Jika pelangganID tidak ada, ambil dari nilai vendor_id
                if (!pelangganID) {
                    pelangganID = $('#vendor_id').attr('data-id');
                }

                if (pelangganID) {
                    $.ajax({
                        url: "{{ url('admin/inquery_invoicesewakendaraan/get_faktursewanonpph') }}" +
                            '/' +
                            pelangganID,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#tablefaktur tbody').empty();
                            if (data.length > 0) {
                                $.each(data, function(index, faktur) {
                                    var nominal_potongan = faktur.nominal_potongan ||
                                        0; // Replace null with 0
                                    var row = '<tr data-id="' + faktur.id +
                                        '" data-kode_faktur="' + faktur.kode_sewa +
                                        '" data-nama_rute="' + faktur.nama_rute +
                                        '" data-id="' + faktur.id +
                                        '" data-tanggal_awal="' + faktur.tanggal_awal +
                                        '" data-id="' + faktur.id +
                                        '" data-no_pol="' + faktur.no_pol +
                                        '" data-jumlah="' + faktur.jumlah +
                                        '" data-satuan="' + faktur.satuan +
                                        '" data-harga_tarif="' + faktur.harga_tarif +
                                        '" data-nominal_potongan="' + nominal_potongan +
                                        // Use the fallback value
                                        '" data-total_tarif="' + faktur.total_tarif +
                                        '" data-param="' + index + '">' +
                                        '<td class="text-center">' + (index + 1) +
                                        '</td>' +
                                        '<td>' + faktur.kode_sewa + '</td>' +
                                        '<td>' + faktur.tanggal_awal + '</td>' +
                                        '<td>' + faktur.vendor.nama_vendor + '</td>' +
                                        '<td>' + faktur.nama_rute + '</td>' +
                                        '<td>' + faktur.kategori + '</td>' +
                                        '<td class="text-center">' +
                                        '<button type="button" id="btnTambah" class="btn btn-primary btn-sm" onclick="getFaktur(' +
                                        index + ')">' +
                                        '<i class="fas fa-plus"></i>' +
                                        '</button>' +
                                        '</td>' +
                                        '</tr>';
                                    $('#tablefaktur tbody').append(row);
                                });
                            } else {
                                $('#tablefaktur tbody').append(
                                    '<tr><td colspan="7" class="text-center">No data available</td></tr>'
                                );
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX Error:", status, error);
                            $('#tablefaktur tbody').empty();
                            $('#tablefaktur tbody').append(
                                '<tr><td colspan="7" class="text-center">Error loading data</td></tr>'
                            );
                        }
                    });
                } else {
                    $('#tablefaktur tbody').empty();
                    $('#tablefaktur tbody').append(
                        '<tr><td colspan="7" class="text-center">No data available</td></tr>'
                    );
                }
            });

            // Trigger the input event manually on page load if there's a value in the vendor_id field
            if ($('#vendor_id').val()) {
                $('#vendor_id').trigger('input');
            }
        });
    </script>

@endsection
