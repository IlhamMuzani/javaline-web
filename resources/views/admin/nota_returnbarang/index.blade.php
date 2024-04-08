@extends('layouts.app')

@section('title', 'Nota Return Barang')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Nota Return Barang</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/nota_returnbarang') }}">Nota Return Barang</a></li>
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
            <form action="{{ url('admin/nota_returnbarang') }}" method="POST" enctype="multipart/form-data"
                autocomplete="off">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Penerimaan Ekspedisi</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <label style="font-size:14px" class="form-label" for="kode_return">Kode Penerimaan Return
                            Barang</label>
                        <div class="form-group d-flex">
                            <input class="form-control" hidden id="return_id" name="return_ekspedisi_id" type="text"
                                placeholder="" value="{{ old('return_ekspedisi_id') }}" readonly
                                style="margin-right: 10px; font-size:14px" />
                            <input class="form-control" id="kode_return" name="kode_return" type="text" placeholder=""
                                value="{{ old('kode_return') }}" readonly style="margin-right: 10px; font-size:14px" />
                            <button class="btn btn-primary" type="button" onclick="showCategoryModalPelanggan(this.value)">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div>
                    <div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Pelanggan</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group" hidden>
                                            <label for="pelanggan_id">return Id</label>
                                            <input type="text" class="form-control" id="pelanggan_id" readonly
                                                name="pelanggan_id" placeholder="" value="{{ old('pelanggan_id') }}">
                                        </div>
                                        <div class="form-group">
                                            <label style="font-size:14px" for="kode_pelanggan">Kode Pelanggan</label>
                                            <input style="font-size:14px" type="text" class="form-control"
                                                id="kode_pelanggan" readonly name="kode_pelanggan" placeholder=""
                                                value="{{ old('kode_pelanggan') }}">
                                        </div>
                                        <div class="form-group">
                                            <label style="font-size:14px" for="nama_pelanggan">Nama Pelanggan</label>
                                            <input style="font-size:14px" type="text" class="form-control"
                                                id="nama_pelanggan" readonly name="nama_pelanggan" placeholder=""
                                                value="{{ old('nama_pelanggan') }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <div class="form-group">
                                                <label style="font-size:14px" for="alamat_pelanggan">Alamat
                                                    return</label>
                                                <input style="font-size:14px" type="text" class="form-control"
                                                    id="alamat_pelanggan" readonly name="alamat_pelanggan" placeholder=""
                                                    value="{{ old('alamat_pelanggan') }}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label style="font-size:14px" for="telp_pelanggan">No. Telp</label>
                                                <input style="font-size:14px" type="text" class="form-control"
                                                    id="telp_pelanggan" readonly name="telp_pelanggan" placeholder=""
                                                    value="{{ old('telp_pelanggan') }}">
                                            </div>
                                        </div>
                                        <div class="form-check" style="color:white">
                                            <label class="form-check-label">
                                                .
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Kendaraan</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group" hidden>
                                            <label for="kendaraan_id">Kendaraan Id</label>
                                            <input type="text" class="form-control" id="kendaraan_id" readonly
                                                name="kendaraan_id" placeholder="" value="{{ old('kendaraan_id') }}">
                                        </div>
                                        <div class="form-group">
                                            <label style="font-size:14px" for="no_kabin">No. Kabin</label>
                                            <input style="font-size:14px" type="text" class="form-control"
                                                id="no_kabin" readonly name="no_kabin" placeholder=""
                                                value="{{ old('no_kabin') }}">
                                        </div>
                                        <div class="form-group">
                                            <label style="font-size:14px" for="no_pol">No. Mobil</label>
                                            <input style="font-size:14px" type="text" class="form-control"
                                                id="no_pol" readonly name="no_pol" placeholder=""
                                                value="{{ old('no_pol') }}">
                                        </div>
                                        <div class="form-group">
                                            <label style="font-size:14px" for="jenis_kendaraan">Jenis Kendaraan</label>
                                            <input style="font-size:14px" type="text" class="form-control"
                                                id="jenis_kendaraan" readonly name="jenis_kendaraan" placeholder=""
                                                value="{{ old('jenis_kendaraan') }}">
                                        </div>
                                        <div class="form-check" style="color:white">
                                            <label class="form-check-label">
                                                .
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Sopir</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group" hidden>
                                            <label for="user_id">User Id</label>
                                            <input type="text" class="form-control" id="user_id" readonly
                                                name="user_id" placeholder="" value="{{ old('user_id') }}">
                                        </div>
                                        <div class="form-group">
                                            <label style="font-size:14px" for="kode_driver">Kode Sopir</label>
                                            <input style="font-size:14px" type="text" class="form-control"
                                                id="kode_driver" readonly name="kode_driver" placeholder=""
                                                value="{{ old('kode_driver') }}">
                                        </div>
                                        <div class="form-group">
                                            <label style="font-size:14px" for="nama_driver">Nama Sopir</label>
                                            <input style="font-size:14px" type="text" class="form-control"
                                                id="nama_driver" readonly name="nama_driver" placeholder=""
                                                value="{{ old('nama_driver') }}">
                                        </div>
                                        <div class="form-group">
                                            <label style="font-size:14px" for="telp">No. Telp</label>
                                            <input style="font-size:14px" type="tex" class="form-control"
                                                id="telp" readonly name="telp" placeholder=""
                                                value="{{ old('telp') }}">
                                        </div>
                                        <div class="form-check" style="color:white">
                                            <label class="form-check-label">
                                                .
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="forms-container"></div>
                        <div class="card">
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="form-group">
                                    <label style="font-size:14px" for="grand_total">Grand Total</label>
                                    <input style="font-size:14px; text-align:end" type="text" class="form-control"
                                        id="grand_total" readonly name="grand_total" placeholder=""
                                        value="{{ old('grand_total') }}">
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
                    </div>
                </div>
        </div>
        </form>

        <div class="modal fade" id="tableReturn" data-backdrop="static">
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
                                    <th>Kode Penerimaan</th>
                                    <th>Tanggal</th>
                                    <th>Pelanggan</th>
                                    <th>No Kabin</th>
                                    <th>Sopir</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($returnbarangs as $return)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $return->kode_return }}</td>
                                        <td>{{ $return->tanggal }}</td>
                                        <td>{{ $return->nama_pelanggan }}</td>
                                        <td>{{ $return->no_kabin }}</td>
                                        <td>{{ $return->nama_driver }}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-primary btn-sm"
                                                onclick="GetReturn(
                                                '{{ $return->id }}',
                                                '{{ $return->kode_return }}',
                                                '{{ $return->pelanggan_id }}',
                                                '{{ $return->kode_pelanggan }}',
                                                '{{ $return->nama_pelanggan }}',
                                                '{{ $return->telp_pelanggan }}',
                                                '{{ $return->alamat_pelanggan }}',
                                                '{{ $return->kendaraan_id }}',
                                                '{{ $return->no_kabin }}',
                                                '{{ $return->no_pol }}',
                                                '{{ $return->jenis_kendaraan }}',
                                                '{{ $return->user_id }}',
                                                '{{ $return->kode_driver }}',
                                                '{{ $return->nama_driver }}',
                                                '{{ $return->telp }}',
                                                '{{ $return->detail_return->pluck('barang_id')->implode(', ') }}',
                                                '{{ $return->detail_return->pluck('kode_barang')->implode(', ') }}',
                                                '{{ $return->detail_return->pluck('nama_barang')->implode(', ') }}',
                                                '{{ $return->detail_return->pluck('satuan')->implode(', ') }}',
                                                '{{ $return->detail_return->pluck('jumlah')->implode(', ') }}'
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

    </section>


    <script>
        function showCategoryModalPelanggan(selectedCategory) {
            $('#tableReturn').modal('show');
        }

        $(document).ready(function() {
            // Call updateTotal function for each existing row to initialize totals
            for (var i = 0; i < barangIds.length; i++) {
                updateTotal(i);
                attachInputEventListeners(i);
            }
        });


        function updateTotal(index) {
            var jumlah = parseFloat($('#jumlah_' + index).val()) || 0;
            var harga = parseFloat($('#harga_' + index).val()) || 0;
            var total = jumlah * harga;

            $('#total_' + index).val(formatNumber(total));
            // Update the grand total
            updateGrandTotal();
        }

        function onHargaChange(index) {
            // Update the total based on harga and jumlah
            var harga = parseFloat($('#harga_' + index).val()) || 0;
            var jumlah = parseFloat($('#jumlah_' + index).val()) || 0;
            var total = harga * jumlah;

            // Update the total field
            $('#total_' + index).val(total.toLocaleString('id-ID'));

            // Update the grand total
            updateGrandTotal();
        }

        function attachInputEventListeners(index) {
            // Attach input event listener for both "jumlah" and "harga" fields
            $('#jumlah_' + index + ', #harga_' + index).on('input', function() {
                updateTotal(index);
            });
        }

        function saveFormDataToSessionStorage() {
            var formData = $('#forms-container').html();
            sessionStorage.setItem('formData', formData);
        }

        // Call this function when the page is loaded to retrieve and display the saved form data
        // Call this function when the page is loaded to retrieve and display the saved form data
        function loadFormDataFromSessionStorage() {
            var formData = sessionStorage.getItem('formData');
            var returnId = $('#return_id').val(); // Get the value of return_id

            // Check if formData exists and return_id is not empty
            if (formData && returnId.trim() !== "") {
                $('#forms-container').html(formData);
                attachInputEventListenersAfterLoad();
            } else {
                // If formData doesn't exist or return_id is empty, clear forms-container
                $('#forms-container').html('');
            }
        }

        // Call loadFormDataFromSessionStorage() on document ready
        $(document).ready(function() {
            loadFormDataFromSessionStorage();
        });

        $(document).ready(function() {
            loadFormDataFromSessionStorage();
        });
        // Attach input event listeners after loading the form data
        function attachInputEventListenersAfterLoad() {
            for (var i = 0; i < barangIds.length; i++) {
                attachInputEventListeners(i);
            }
        }

        function updateGrandTotal() {
            var grandTotal = 0;
            $('.total').each(function() {
                // Remove dots and parse as float
                var totalValue = parseFloat($(this).val().replace(/\./g, '')) || 0;
                grandTotal += totalValue;
            });

            // Format the grandTotal as currency in Indonesian Rupiah
            var formattedGrandTotal = grandTotal.toLocaleString('id-ID');

            $('#grand_total').val(formattedGrandTotal);
            saveFormDataToSessionStorage(); // Save the form data to sessionStorage
        }


        // function formatNumber(number) {
        //     // Format the number with dots for thousands separator
        //     return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        // }


        function formatNumber(value) {
            // Check if the value is an integer or has decimal places
            if (value === parseInt(value, 10)) {
                return value.toFixed(0); // If it's an integer, remove decimal places
            } else {
                return value.toFixed(2); // If it has decimal places, keep two decimal places
            }
        }

        function GetReturn(Return_id, KodeReturn, Pelanggan_id, KodePelanggan, NamaPell, Telpel, AlamatPelanggan,
            Kendaraan_id, Nokabin,
            Nopol, JenisKen, User_id, KodeDriv, NamaDriv, Telpdriv, Barang_id, KodeBarang, NamaBarang, Satuan, Jumlah) {

            document.getElementById('return_id').value = Return_id;
            document.getElementById('kode_return').value = KodeReturn;
            document.getElementById('pelanggan_id').value = Pelanggan_id;
            document.getElementById('kode_pelanggan').value = KodePelanggan;
            document.getElementById('nama_pelanggan').value = NamaPell;
            document.getElementById('telp_pelanggan').value = Telpel;
            document.getElementById('alamat_pelanggan').value = AlamatPelanggan;
            document.getElementById('kendaraan_id').value = Kendaraan_id;
            document.getElementById('no_kabin').value = Nokabin;
            document.getElementById('no_pol').value = Nopol;
            document.getElementById('jenis_kendaraan').value = JenisKen;
            document.getElementById('user_id').value = User_id;
            document.getElementById('kode_driver').value = KodeDriv;
            document.getElementById('nama_driver').value = NamaDriv;
            document.getElementById('telp').value = Telpdriv;

            var barangIds = Barang_id.split(', ');
            var kodeBarangs = KodeBarang.split(', ');
            var namaBarangs = NamaBarang.split(', ');
            var satuans = Satuan.split(', ');
            var jumlahs = Jumlah.split(', ');

            $('#forms-container').html('');

            // Create forms for each barang
            var formHtml = '<div class="card mb-3">' +
                '<div class="card-header">' +
                '<h3 class="card-title">Form Barang</h3>' +
                '</div>' +
                '<div class="card-body">' +
                '<table class="table table-bordered table-striped">' +
                '<thead>' +
                '<tr>' +
                '<th style="font-size:14px" class="text-center">No</th>' +
                '<th style="font-size:14px">Kode Barang</th>' +
                '<th style="font-size:14px">Nama Barang</th>' +
                '<th style="font-size:14px">Satuan</th>' +
                '<th style="font-size:14px">Jumlah</th>' +
                '<th style="font-size:14px">Harga</th>' +
                '<th style="font-size:14px">Total</th>' +
                '</tr>' +
                '</thead>' +
                '<tbody id="tabel-pembelian">';

            for (var i = 0; i < barangIds.length; i++) {
                formHtml += '<tr>' +
                    '<td style="width: 70px; font-size:14px" class="text-center urutan">' + (i + 1) + '</td>' +
                    '<td hidden>' +
                    '   <div class="form-group">' +
                    '       <input type="text" class="form-control" name="barang_id[]" value="' + barangIds[i] +
                    '" readonly>' +
                    '   </div>' +
                    '</td>' +
                    '<td>' +
                    '   <div class="form-group">' +
                    '       <input style="font-size:14px" readonly type="text" class="form-control kode_barang" name="kode_barang[]" value="' +
                    kodeBarangs[i] + '">' +
                    '   </div>' +
                    '</td>' +
                    '<td>' +
                    '   <div class="form-group">' +
                    '       <input style="font-size:14px" readonly type="text" class="form-control nama_barang" name="nama_barang[]" value="' +
                    namaBarangs[i] + '">' +
                    '   </div>' +
                    '</td>' +
                    '<td>' +
                    '   <div class="form-group">' +
                    '       <input style="font-size:14px" readonly type="text" class="form-control satuan" name="satuan[]" value="' +
                    satuans[i] + '">' +
                    '   </div>' +
                    '</td>' +
                    '<td>' +
                    '   <div class="form-group">' +
                    '       <input style="font-size:14px" type="number" readonly class="form-control jumlah" name="jumlah[]" id="jumlah_' +
                    i + '" value="' + jumlahs[i] + '" onchange="updateTotal(' + i + ')">' +
                    '   </div>' +
                    '</td>' +
                    '<td>' +
                    '   <div class="form-group">' +
                    '       <input style="font-size:14px" type="number" class="form-control harga" name="harga[]" id="harga_' +
                    i + '" value="" oninput="onHargaChange(' + i + ')">' +
                    '   </div>' +
                    '</td>' +
                    '<td>' +
                    '   <div class="form-group">' +
                    '       <input style="font-size:14px" type="text" readonly class="form-control total" name="total[]" id="total_' +
                    i + '" value="">' +
                    '   </div>' +
                    '</td>' +
                    '</tr>';
                $('#harga_' + i).on('input', function() {
                    var index = this.id.split('_')[1];
                    onHargaChange(index);
                });
            }

            formHtml += '</tbody>' +
                '</table>' +
                '</div>' +
                '</div>';

            $('#forms-container').append(formHtml);

            updateGrandTotal();

            $('#tableReturn').modal('hide');
            attachInputEventListenersAfterLoad();
        }
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



    {{-- <script>
        function showCategoryModalPelanggan(selectedCategory) {
            $('#tableReturn').modal('show');
        }

        $(document).ready(function() {
            // Call updateTotal function for each existing row to initialize totals
            for (var i = 0; i < barangIds.length; i++) {
                updateTotal(i);
                attachInputEventListeners(i);
            }
        });


        function updateTotal(index) {
            var jumlah = parseFloat($('#jumlah_' + index).val()) || 0;
            var harga = parseFloat($('#harga_' + index).val()) || 0;
            var total = jumlah * harga;

            $('#total_' + index).val(formatNumber(total));
            // Update the grand total
            updateGrandTotal();
        }

        function onHargaChange(index) {
            var jumlah = parseFloat($('#jumlah_' + index).val()) || 0;
            var harga = parseFloat($('#harga_' + index).val()) || 0;
            var total = jumlah * harga;

            $('#total_' + index).val(formatNumber(total));
            // Update the grand total
            updateGrandTotal();
        }

        function attachInputEventListeners(index) {
            // Attach input event listener for both "jumlah" and "harga" fields
            $('#jumlah_' + index + ', #harga_' + index).on('input', function() {
                updateTotal(index);
            });
        }

        function saveFormDataToSessionStorage() {
            var formData = $('#forms-container').html();
            sessionStorage.setItem('formData', formData);
        }

        // Call this function when the page is loaded to retrieve and display the saved form data
        // Call this function when the page is loaded to retrieve and display the saved form data
        function loadFormDataFromSessionStorage() {
            var formData = sessionStorage.getItem('formData');
            var returnId = $('#return_id').val(); // Get the value of return_id

            // Check if formData exists and return_id is not empty
            if (formData && returnId.trim() !== "") {
                $('#forms-container').html(formData);
                attachInputEventListenersAfterLoad();
            } else {
                // If formData doesn't exist or return_id is empty, clear forms-container
                $('#forms-container').html('');
            }
        }

        // Call loadFormDataFromSessionStorage() on document ready
        $(document).ready(function() {
            loadFormDataFromSessionStorage();
        });

        // Update GetReturn() function to call attachInputEventListenersAfterLoad()
        function GetReturn(Return_id, KodeReturn, Pelanggan_id, KodePelanggan, NamaPell, Telpel, Kendaraan_id, Nokabin,
            Nopol, JenisKen, User_id, KodeDriv, NamaDriv, Telpdriv, Barang_id, KodeBarang, NamaBarang, Satuan, Jumlah) {
            // ...

            // Append the form to the container
            $('#forms-container').html(formHtml);

            updateGrandTotal();

            $('#tableReturn').modal('hide');

            attachInputEventListenersAfterLoad(); // Attach input event listeners after loading the form data
        }

        $(document).ready(function() {
            loadFormDataFromSessionStorage();
        });
        // Attach input event listeners after loading the form data
        function attachInputEventListenersAfterLoad() {
            for (var i = 0; i < barangIds.length; i++) {
                attachInputEventListeners(i);
            }
        }

        function updateGrandTotal() {
            var grandTotal = 0;
            $('.total').each(function() {
                grandTotal += parseFloat($(this).val()) || 0;
            });

            $('#grand_total').val(formatNumber(grandTotal));
            saveFormDataToSessionStorage(); // Save the form data to sessionStorage
        }

        function formatNumber(value) {
            // Check if the value is an integer or has decimal places
            if (value === parseInt(value, 10)) {
                return value.toFixed(0); // If it's an integer, remove decimal places
            } else {
                return value.toFixed(2); // If it has decimal places, keep two decimal places
            }
        }

        function GetReturn(Return_id, KodeReturn, Pelanggan_id, KodePelanggan, NamaPell, Telpel, Kendaraan_id, Nokabin,
            Nopol, JenisKen, User_id, KodeDriv, NamaDriv, Telpdriv, Barang_id, KodeBarang, NamaBarang, Satuan, Jumlah) {

            document.getElementById('return_id').value = Return_id;
            document.getElementById('kode_return').value = KodeReturn;
            document.getElementById('pelanggan_id').value = Pelanggan_id;
            document.getElementById('kode_pelanggan').value = KodePelanggan;
            document.getElementById('nama_pelanggan').value = NamaPell;
            document.getElementById('telp_pelanggan').value = Telpel;
            document.getElementById('kendaraan_id').value = Kendaraan_id;
            document.getElementById('no_kabin').value = Nokabin;
            document.getElementById('no_pol').value = Nopol;
            document.getElementById('jenis_kendaraan').value = JenisKen;
            document.getElementById('user_id').value = User_id;
            document.getElementById('kode_driver').value = KodeDriv;
            document.getElementById('nama_driver').value = NamaDriv;
            document.getElementById('telp').value = Telpdriv;

            var barangIds = Barang_id.split(', ');
            var kodeBarangs = KodeBarang.split(', ');
            var namaBarangs = NamaBarang.split(', ');
            var satuans = Satuan.split(', ');
            var jumlahs = Jumlah.split(', ');

            $('#forms-container').html('');

            // Create forms for each barang
            var formHtml = '<div class="card mb-3">' +
                '<div class="card-header">' +
                '<h3 class="card-title">Form Barang</h3>' +
                '</div>' +
                '<div class="card-body">' +
                '<table class="table table-bordered table-striped">' +
                '<thead>' +
                '<tr>' +
                '<th style="font-size:14px" class="text-center">No</th>' +
                '<th style="font-size:14px">Kode Barang</th>' +
                '<th style="font-size:14px">Nama Barang</th>' +
                '<th style="font-size:14px">Satuan</th>' +
                '<th style="font-size:14px">Jumlah</th>' +
                '<th style="font-size:14px">Harga</th>' +
                '<th style="font-size:14px">Total</th>' +
                '</tr>' +
                '</thead>' +
                '<tbody id="tabel-pembelian">';

            for (var i = 0; i < barangIds.length; i++) {
                formHtml += '<tr>' +
                    '<td style="width: 70px; font-size:14px" class="text-center urutan">' + (i + 1) + '</td>' +
                    '<td hidden>' +
                    '   <div class="form-group">' +
                    '       <input type="text" class="form-control" name="barang_id[]" value="' + barangIds[i] +
                    '" readonly>' +
                    '   </div>' +
                    '</td>' +
                    '<td>' +
                    '   <div class="form-group">' +
                    '       <input style="font-size:14px" readonly type="text" class="form-control kode_barang" name="kode_barang[]" value="' +
                    kodeBarangs[i] + '">' +
                    '   </div>' +
                    '</td>' +
                    '<td>' +
                    '   <div class="form-group">' +
                    '       <input style="font-size:14px" readonly type="text" class="form-control nama_barang" name="nama_barang[]" value="' +
                    namaBarangs[i] + '">' +
                    '   </div>' +
                    '</td>' +
                    '<td>' +
                    '   <div class="form-group">' +
                    '       <input style="font-size:14px" readonly type="text" class="form-control satuan" name="satuan[]" value="' +
                    satuans[i] + '">' +
                    '   </div>' +
                    '</td>' +
                    '<td>' +
                    '   <div class="form-group">' +
                    '       <input style="font-size:14px" type="number" readonly class="form-control jumlah" name="jumlah[]" id="jumlah_' +
                    i + '" value="' + jumlahs[i] + '" onchange="updateTotal(' + i + ')">' +
                    '   </div>' +
                    '</td>' +
                    '<td>' +
                    '   <div class="form-group">' +
                    '       <input style="font-size:14px" type="number" class="form-control harga" name="harga[]" id="harga_' +
                    i + '" value="" oninput="onHargaChange(' + i + ')">' +
                    '   </div>' +
                    '</td>' +
                    '<td>' +
                    '   <div class="form-group">' +
                    '       <input style="font-size:14px" type="number" readonly class="form-control total" name="total[]" id="total_' +
                    i + '" value="">' +
                    '   </div>' +
                    '</td>' +
                    '</tr>';

                $('#harga_' + i).on('input', function() {
                    onHargaChange(i);
                });
            }

            formHtml += '</tbody>' +
                '</table>' +
                '</div>' +
                '</div>';

            $('#forms-container').append(formHtml);

            updateGrandTotal();

            $('#tableReturn').modal('hide');
            attachInputEventListenersAfterLoad(); 
        }
    </script> --}}



    {{-- <script>
        function showCategoryModalPelanggan(selectedCategory) {
            $('#tableReturn').modal('show');
        }

        $(document).ready(function() {
            // Call updateTotal function for each existing row to initialize totals
            for (var i = 0; i < barangIds.length; i++) {
                updateTotal(i);
                attachInputEventListeners(i);
            }
        });


        function updateTotal(index) {
            var jumlah = parseFloat($('#jumlah_' + index).val()) || 0;
            var harga = parseFloat($('#harga_' + index).val()) || 0;
            var total = jumlah * harga;

            $('#total_' + index).val(formatNumber(total));
            // Update the grand total
            updateGrandTotal();
        }

        function onHargaChange(index) {
            var jumlah = parseFloat($('#jumlah_' + index).val()) || 0;
            var harga = parseFloat($('#harga_' + index).val()) || 0;
            var total = jumlah * harga;

            $('#total_' + index).val(formatNumber(total));
            // Update the grand total
            updateGrandTotal();
        }

        function attachInputEventListeners(index) {
            // Attach input event listener for both "jumlah" and "harga" fields
            $('#jumlah_' + index + ', #harga_' + index).on('input', function() {
                updateTotal(index);
            });
        }

        function saveFormDataToSessionStorage() {
            var formData = $('#forms-container').html();
            sessionStorage.setItem('formData', formData);
        }

        // Call this function when the page is loaded to retrieve and display the saved form data
        function loadFormDataFromSessionStorage() {
            var formData = sessionStorage.getItem('formData');
            if (formData) {
                $('#forms-container').html(formData);
                attachInputEventListenersAfterLoad();
            }
        }

        // Attach input event listeners after loading the form data
        function attachInputEventListenersAfterLoad() {
            for (var i = 0; i < barangIds.length; i++) {
                attachInputEventListeners(i);
            }
        }

        // Call loadFormDataFromSessionStorage() on document ready
        $(document).ready(function() {
            loadFormDataFromSessionStorage();
        });

        function updateGrandTotal() {
            var grandTotal = 0;
            $('.total').each(function() {
                grandTotal += parseFloat($(this).val()) || 0;
            });

            $('#grand_total').val(formatNumber(grandTotal));
            saveFormDataToSessionStorage(); // Save the form data to sessionStorage
        }

        function formatNumber(value) {
            // Check if the value is an integer or has decimal places
            if (value === parseInt(value, 10)) {
                return value.toFixed(0); // If it's an integer, remove decimal places
            } else {
                return value.toFixed(2); // If it has decimal places, keep two decimal places
            }
        }

        function GetReturn(Return_id, KodeReturn, Pelanggan_id, KodePelanggan, NamaPell, Telpel, Kendaraan_id, Nokabin,
            Nopol, JenisKen, User_id, KodeDriv, NamaDriv, Telpdriv, Barang_id, KodeBarang, NamaBarang, Satuan, Jumlah) {

            // Set the values in the form fields
            document.getElementById('return_id').value = Return_id;
            document.getElementById('kode_return').value = KodeReturn;
            document.getElementById('pelanggan_id').value = Pelanggan_id;
            document.getElementById('kode_pelanggan').value = KodePelanggan;
            document.getElementById('nama_pelanggan').value = NamaPell;
            document.getElementById('telp_pelanggan').value = Telpel;
            document.getElementById('kendaraan_id').value = Kendaraan_id;
            document.getElementById('no_kabin').value = Nokabin;
            document.getElementById('no_pol').value = Nopol;
            document.getElementById('jenis_kendaraan').value = JenisKen;
            document.getElementById('user_id').value = User_id;
            document.getElementById('kode_driver').value = KodeDriv;
            document.getElementById('nama_driver').value = NamaDriv;
            document.getElementById('telp').value = Telpdriv;

            // Split values into arrays
            var barangIds = Barang_id.split(', ');
            var kodeBarangs = KodeBarang.split(', ');
            var namaBarangs = NamaBarang.split(', ');
            var satuans = Satuan.split(', ');
            var jumlahs = Jumlah.split(', ');
            

            // Clear existing forms
            $('#forms-container').html('');

            // Create forms for each barang
            var formHtml = '<div class="card mb-3">' +
                '<div class="card-header">' +
                '<h3 class="card-title">Form Barang</h3>' +
                '</div>' +
                '<div class="card-body">' +
                '<table class="table table-bordered table-striped">' +
                '<thead>' +
                '<tr>' +
                '<th style="font-size:14px" class="text-center">No</th>' +
                '<th style="font-size:14px">Kode Barang</th>' +
                '<th style="font-size:14px">Nama Barang</th>' +
                '<th style="font-size:14px">Satuan</th>' +
                '<th style="font-size:14px">Jumlah</th>' +
                '<th style="font-size:14px">Harga</th>' +
                '<th style="font-size:14px">Total</th>' +
                '</tr>' +
                '</thead>' +
                '<tbody id="tabel-pembelian">';

            for (var i = 0; i < barangIds.length; i++) {
                formHtml += '<tr>' +
                    '<td style="width: 70px; font-size:14px" class="text-center urutan">' + (i + 1) + '</td>' +
                    '<td hidden>' +
                    '   <div class="form-group">' +
                    '       <input type="text" class="form-control" name="barang_id[]" value="' + barangIds[i] +
                    '" readonly>' +
                    '   </div>' +
                    '</td>' +
                    '<td>' +
                    '   <div class="form-group">' +
                    '       <input style="font-size:14px" readonly type="text" class="form-control kode_barang" name="kode_barang[]" value="' +
                    kodeBarangs[i] + '">' +
                    '   </div>' +
                    '</td>' +
                    '<td>' +
                    '   <div class="form-group">' +
                    '       <input style="font-size:14px" readonly type="text" class="form-control nama_barang" name="nama_barang[]" value="' +
                    namaBarangs[i] + '">' +
                    '   </div>' +
                    '</td>' +
                    '<td>' +
                    '   <div class="form-group">' +
                    '       <input style="font-size:14px" readonly type="text" class="form-control satuan" name="satuan[]" value="' +
                    satuans[i] + '">' +
                    '   </div>' +
                    '</td>' +
                    '<td>' +
                    '   <div class="form-group">' +
                    '       <input style="font-size:14px" type="number" readonly class="form-control jumlah" name="jumlah[]" id="jumlah_' +
                    i + '" value="' + jumlahs[i] + '" onchange="updateTotal(' + i + ')">' +
                    '   </div>' +
                    '</td>' +
                    '<td>' +
                    '   <div class="form-group">' +
                    '       <input style="font-size:14px" type="number" class="form-control harga" name="harga[]" id="harga_' +
                    i + '" value="" oninput="onHargaChange(' + i + ')">' +
                    '   </div>' +
                    '</td>' +
                    '<td>' +
                    '   <div class="form-group">' +
                    '       <input style="font-size:14px" type="number" readonly class="form-control total" name="total[]" id="total_' +
                    i + '" value="">' +
                    '   </div>' +
                    '</td>' +
                    '</tr>';

                $('#harga_' + i).on('input', function() {
                    onHargaChange(i);
                });
            }

            formHtml += '</tbody>' +
                '</table>' +
                '</div>' +
                '</div>';

            // Append the form to the container
            $('#forms-container').append(formHtml);

            updateGrandTotal();

            $('#tableReturn').modal('hide');
            attachInputEventListenersAfterLoad(); // Attach input event listeners after loading the form data
        }
    </script> --}}


    {{-- <script>
        function showCategoryModalPelanggan(selectedCategory) {
            $('#tableReturn').modal('show');
        }

        $(document).ready(function() {
            // Call updateTotal function for each existing row to initialize totals
            for (var i = 0; i < barangIds.length; i++) {
                updateTotal(i);
                attachInputEventListeners(i);
            }
        });

        function updateTotal(index) {
            var jumlah = parseFloat($('#jumlah_' + index).val()) || 0;
            var harga = parseFloat($('#harga_' + index).val()) || 0;
            var total = jumlah * harga;

            $('#total_' + index).val(formatNumber(total));
            // Update the grand total
            updateGrandTotal();
        }

        function onHargaChange(index) {
            var jumlah = parseFloat($('#jumlah_' + index).val()) || 0;
            var harga = parseFloat($('#harga_' + index).val()) || 0;
            var total = jumlah * harga;

            $('#total_' + index).val(formatNumber(total));
            // Update the grand total
            updateGrandTotal();
        }

        function attachInputEventListeners(index) {
            // Attach input event listener for both "jumlah" and "harga" fields
            $('#jumlah_' + index + ', #harga_' + index).on('input', function() {
                updateTotal(index);
            });
        }

        function updateGrandTotal() {
            var grandTotal = 0;
            $('.total').each(function() {
                grandTotal += parseFloat($(this).val()) || 0;
            });

            $('#grand_total').val(formatNumber(grandTotal));
        }

        function formatNumber(value) {
            // Check if the value is an integer or has decimal places
            if (value === parseInt(value, 10)) {
                return value.toFixed(0); // If it's an integer, remove decimal places
            } else {
                return value.toFixed(2); // If it has decimal places, keep two decimal places
            }
        }

        function GetReturn(Return_id, KodeReturn, Pelanggan_id, KodePelanggan, NamaPell, Telpel, Kendaraan_id, Nokabin,
            Nopol, JenisKen, User_id, KodeDriv, NamaDriv, Telpdriv, Barang_id, KodeBarang, NamaBarang, Satuan, Jumlah) {

            // Set the values in the form fields
            document.getElementById('return_id').value = Return_id;
            document.getElementById('kode_return').value = KodeReturn;
            document.getElementById('pelanggan_id').value = Pelanggan_id;
            document.getElementById('kode_pelanggan').value = KodePelanggan;
            document.getElementById('nama_pelanggan').value = NamaPell;
            document.getElementById('telp_pelanggan').value = Telpel;
            document.getElementById('kendaraan_id').value = Kendaraan_id;
            document.getElementById('no_kabin').value = Nokabin;
            document.getElementById('no_pol').value = Nopol;
            document.getElementById('jenis_kendaraan').value = JenisKen;
            document.getElementById('user_id').value = User_id;
            document.getElementById('kode_driver').value = KodeDriv;
            document.getElementById('nama_driver').value = NamaDriv;
            document.getElementById('telp').value = Telpdriv;

            // Split values into arrays
            var barangIds = Barang_id.split(', ');
            var kodeBarangs = KodeBarang.split(', ');
            var namaBarangs = NamaBarang.split(', ');
            var satuans = Satuan.split(', ');
            var jumlahs = Jumlah.split(', ');

            // Clear existing forms
            $('#forms-container').html('');

            // Create forms for each barang
            var formHtml = '<div class="card mb-3">' +
                '<div class="card-header">' +
                '<h3 class="card-title">Form Barang</h3>' +
                '</div>' +
                '<div class="card-body">' +
                '<table class="table table-bordered table-striped">' +
                '<thead>' +
                '<tr>' +
                '<th style="font-size:14px" class="text-center">No</th>' +
                '<th style="font-size:14px">Kode Barang</th>' +
                '<th style="font-size:14px">Nama Barang</th>' +
                '<th style="font-size:14px">Satuan</th>' +
                '<th style="font-size:14px">Jumlah</th>' +
                '<th style="font-size:14px">Harga</th>' +
                '<th style="font-size:14px">Total</th>' +
                '</tr>' +
                '</thead>' +
                '<tbody id="tabel-pembelian">';

            for (var i = 0; i < barangIds.length; i++) {
                formHtml += '<tr>' +
                    '<td style="width: 70px; font-size:14px" class="text-center urutan">' + (i + 1) + '</td>' +
                    '<td hidden>' +
                    '   <div class="form-group">' +
                    '       <input type="text" class="form-control" name="barang_id[]" value="' + barangIds[i] +
                    '" readonly>' +
                    '   </div>' +
                    '</td>' +
                    '<td>' +
                    '   <div class="form-group">' +
                    '       <input style="font-size:14px" readonly type="text" class="form-control kode_barang" name="kode_barang[]" value="' +
                    kodeBarangs[i] + '">' +
                    '   </div>' +
                    '</td>' +
                    '<td>' +
                    '   <div class="form-group">' +
                    '       <input style="font-size:14px" readonly type="text" class="form-control nama_barang" name="nama_barang[]" value="' +
                    namaBarangs[i] + '">' +
                    '   </div>' +
                    '</td>' +
                    '<td>' +
                    '   <div class="form-group">' +
                    '       <input style="font-size:14px" readonly type="text" class="form-control satuan" name="satuan[]" value="' +
                    satuans[i] + '">' +
                    '   </div>' +
                    '</td>' +
                    '<td>' +
                    '   <div class="form-group">' +
                    '       <input style="font-size:14px" type="number" readonly class="form-control jumlah" name="jumlah[]" id="jumlah_' +
                    i + '" value="' + jumlahs[i] + '" onchange="updateTotal(' + i + ')">' +
                    '   </div>' +
                    '</td>' +
                    '<td>' +
                    '   <div class="form-group">' +
                    '       <input style="font-size:14px" type="number" class="form-control harga" name="harga[]" id="harga_' +
                    i + '" value="" oninput="onHargaChange(' + i + ')">' +
                    '   </div>' +
                    '</td>' +
                    '<td>' +
                    '   <div class="form-group">' +
                    '       <input style="font-size:14px" type="number" readonly class="form-control total" name="total[]" id="total_' +
                    i + '" value="">' +
                    '   </div>' +
                    '</td>' +
                    '</tr>';

                $('#harga_' + i).on('input', function() {
                    onHargaChange(i);
                });
            }

            formHtml += '</tbody>' +
                '</table>' +
                '</div>' +
                '</div>';

            // Append the form to the container
            $('#forms-container').append(formHtml);

            updateGrandTotal();

            $('#tableReturn').modal('hide');
        }
    </script> --}}


    {{-- sudah benar  --}}
    {{-- <script>
        function showCategoryModalPelanggan(selectedCategory) {
            $('#tableReturn').modal('show');
        }

        $(document).ready(function() {
            // Call updateTotal function for each existing row to initialize totals
            for (var i = 0; i < barangIds.length; i++) {
                updateTotal(i);
            }
        });

        function updateTotal(index) {
            var jumlah = parseFloat($('#jumlah_' + index).val()) || 0;
            var harga = parseFloat($('#harga_' + index).val()) || 0;
            var total = jumlah * harga;

            $('#total_' + index).val(total.toFixed(2));
        }

        function onHargaChange(index) {
            updateTotal(index);
        }

        function GetReturn(Return_id, KodeReturn, Pelanggan_id, KodePelanggan, NamaPell, Telpel, Kendaraan_id, Nokabin,
            Nopol, JenisKen, User_id, KodeDriv, NamaDriv, Telpdriv, Barang_id, KodeBarang, NamaBarang, Satuan, Jumlah) {

            // Set the values in the form fields
            document.getElementById('return_id').value = Return_id;
            document.getElementById('kode_return').value = KodeReturn;
            document.getElementById('pelanggan_id').value = Pelanggan_id;
            document.getElementById('kode_pelanggan').value = KodePelanggan;
            document.getElementById('nama_pelanggan').value = NamaPell;
            document.getElementById('telp_pelanggan').value = Telpel;
            document.getElementById('kendaraan_id').value = Kendaraan_id;
            document.getElementById('no_kabin').value = Nokabin;
            document.getElementById('no_pol').value = Nopol;
            document.getElementById('jenis_kendaraan').value = JenisKen;
            document.getElementById('user_id').value = User_id;
            document.getElementById('kode_driver').value = KodeDriv;
            document.getElementById('nama_driver').value = NamaDriv;
            document.getElementById('telp').value = Telpdriv;

            // Split values into arrays
            var barangIds = Barang_id.split(', ');
            var kodeBarangs = KodeBarang.split(', ');
            var namaBarangs = NamaBarang.split(', ');
            var satuans = Satuan.split(', ');
            var jumlahs = Jumlah.split(', ');

            // Clear existing forms
            $('#forms-container').html('');

            // Create forms for each barang
            var formHtml = '<div class="card mb-3">' +
                '<div class="card-header">' +
                '<h3 class="card-title">Form Barang</h3>' +
                '</div>' +
                '<div class="card-body">' +
                '<table class="table table-bordered table-striped">' +
                '<thead>' +
                '<tr>' +
                '<th style="font-size:14px" class="text-center">No</th>' +
                '<th style="font-size:14px">Kode Barang</th>' +
                '<th style="font-size:14px">Nama Barang</th>' +
                '<th style="font-size:14px">Satuan</th>' +
                '<th style="font-size:14px">Jumlah</th>' +
                '<th style="font-size:14px">Harga</th>' +
                '<th style="font-size:14px">Total</th>' +
                '</tr>' +
                '</thead>' +
                '<tbody id="tabel-pembelian">';

            for (var i = 0; i < barangIds.length; i++) {
                formHtml += '<tr>' +
                    '<td style="width: 70px; font-size:14px" class="text-center urutan">' + (i + 1) + '</td>' +
                    '<td hidden>' +
                    '   <div class="form-group">' +
                    '       <input type="text" class="form-control" name="barang_id[]" value="' + barangIds[i] +
                    '" readonly>' +
                    '   </div>' +
                    '</td>' +
                    '<td>' +
                    '   <div class="form-group">' +
                    '       <input style="font-size:14px" readonly type="text" class="form-control kode_barang" name="kode_barang[]" value="' +
                    kodeBarangs[i] + '">' +
                    '   </div>' +
                    '</td>' +
                    '<td>' +
                    '   <div class="form-group">' +
                    '       <input style="font-size:14px" readonly type="text" class="form-control nama_barang" name="nama_barang[]" value="' +
                    namaBarangs[i] + '">' +
                    '   </div>' +
                    '</td>' +
                    '<td>' +
                    '   <div class="form-group">' +
                    '       <input style="font-size:14px" readonly type="text" class="form-control satuan" name="satuan[]" value="' +
                    satuans[i] + '">' +
                    '   </div>' +
                    '</td>' +
                    '<td>' +
                    '   <div class="form-group">' +
                    '       <input style="font-size:14px" type="number" readonly class="form-control jumlah" name="jumlah[]" id="jumlah_' +
                    i + '" value="' + jumlahs[i] + '" onchange="updateTotal(' + i + ')">' +
                    '   </div>' +
                    '</td>' +
                    '<td>' +
                    '   <div class="form-group">' +
                    '       <input style="font-size:14px" type="number" class="form-control harga" name="harga[]" id="harga_' +
                    i + '" value="" onchange="onHargaChange(' + i + ')">' +
                    '   </div>' +
                    '</td>' +
                    '<td>' +
                    '   <div class="form-group">' +
                    '       <input style="font-size:14px" type="number" readonly class="form-control total" name="total[]" id="total_' +
                    i + '" value="">' +
                    '   </div>' +
                    '</td>' +
                    '</tr>';
            }

            formHtml += '</tbody>' +
                '</table>' +
                '</div>' +
                '</div>';

            // Append the form to the container
            $('#forms-container').append(formHtml);

            $('#tableReturn').modal('hide');
        }
    </script> --}}

@endsection
