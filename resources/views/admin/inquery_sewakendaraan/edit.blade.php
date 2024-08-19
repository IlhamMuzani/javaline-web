@extends('layouts.app')

@section('title', 'Inquery Faktur Sewa Kendaraan')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Inquery Faktur Sewa Kendaraan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/inquery_sewakendaraan') }}">Faktur Sewa Kendaraan</a></li>
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
                        <i class="icon fas fa-ban"></i> Gagal Menyimpan!
                    </h5>
                    @foreach (session('error') as $error)
                        - {{ $error }} <br>
                    @endforeach
                </div>
            @endif
            <form action="{{ url('admin/inquery_sewakendaraan/' . $inquery->id) }}" method="POST" enctype="multipart/form-data"
                autocomplete="off">
                @csrf
                @method('put')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Faktur Sewa Kendaraan</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div id="pelangganspk" class="card">
                            <div class="card-header">
                                <h3 class="card-title">Rekanan</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group" hidden>
                                    <label for="vendor_id">Rekanan Id</label>
                                    <input type="text" class="form-control" id="vendor_id" readonly name="vendor_id"
                                        placeholder="" value="{{ old('vendor_id', $inquery->vendor_id) }}">
                                </div>
                                <div class="form-group" hidden>
                                    <label for="kode_vendor">kode Rekan</label>
                                    <input type="text" class="form-control" id="kode_vendor" readonly name="kode_vendor"
                                        placeholder="" value="{{ old('kode_vendor') }}">
                                </div>
                                <label style="font-size:14px" class="form-label" for="nama_vendor">Nama
                                    Rekan</label>
                                <div class="form-group d-flex">
                                    <input onclick="showCategoryModalVendor(this.value)" class="form-control"
                                        id="nama_vendor" name="nama_vendor" type="text" placeholder=""
                                        value="{{ old('nama_vendor', $inquery->nama_vendor) }}" readonly
                                        style="margin-right: 10px; font-size:14px" />
                                    <button class="btn btn-primary" type="button"
                                        onclick="showCategoryModalVendor(this.value)">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                                <div class="form-group">
                                    <label style="font-size:14px" for="alamat_vendor">Alamat</label>
                                    <input onclick="showCategoryModalVendor(this.value)" style="font-size:14px"
                                        type="text" class="form-control" id="alamat_vendor" readonly name="alamat_vendor"
                                        placeholder="" value="{{ old('alamat_vendor', $inquery->vendor->alamat ?? null) }}">
                                </div>
                                <div class="form-group">
                                    <label style="font-size:14px" for="telp_vendor">No. Telp</label>
                                    <input onclick="showCategoryModalVendor(this.value)" style="font-size:14px"
                                        type="text" class="form-control" id="telp_vendor" readonly name="telp_vendor"
                                        placeholder="" value="{{ old('telp_vendor', $inquery->vendor->telp ?? null) }}">
                                </div>
                                <div class="form-check" style="color:white">
                                    <label class="form-check-label">
                                        .
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6" id="form_rute">
                        <div id="rutespk" class="card">
                            <div class="card-header">
                                <h3 class="card-title">Rute Perjalanan</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group" hidden>
                                    <label for="rute_perjalanan_id">rute Id</label>
                                    <input type="text" class="form-control" id="rute_perjalanan_id" readonly
                                        name="rute_perjalanan_id" placeholder="" value="{{ old('rute_perjalanan_id', $inquery->rute_perjalanan_id) }}">
                                </div>

                                <label style="font-size:14px" class="form-label" for="kode_rute">Kode
                                    Rute</label>
                                <div class="form-group d-flex">
                                    <input onclick="showCategoryModalrute(this.value)" class="form-control"
                                        id="kode_rute" name="kode_rute" type="text" placeholder=""
                                        value="{{ old('kode_rute', $inquery->rute_perjalanan->kode_rute ?? null) }}" readonly
                                        style="margin-right: 10px; font-size:14px" />
                                    <button class="btn btn-primary" type="button"
                                        onclick="showCategoryModalrute(this.value)">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                                <div class="form-group">
                                    <label style="font-size:14px" for="rute_perjalanan">Rute Perjalanan</label>
                                    <input onclick="showCategoryModalrute(this.value)" style="font-size:14px"
                                        type="text" class="form-control" id="rute_perjalanan" readonly
                                        name="nama_rute" placeholder="" value="{{ old('nama_rute', $inquery->rute_perjalanan->nama_rute ?? null) }}">
                                </div>
                                <div class="form-check" style="color:white; margin-top:102px">
                                    <label class="form-check-label">
                                        .
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div id="pelangganspk" class="card">
                            <div class="card-header">
                                <h3 class="card-title">Pelanggan</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group" hidden>
                                    <label for="pelanggan_id">pelanggan Id</label>
                                    <input type="text" class="form-control" id="pelanggan_id" readonly
                                        name="pelanggan_id" placeholder="" value="{{ old('pelanggan_id', $inquery->pelanggan_id) }}">
                                </div>
                                <div class="form-group" hidden>
                                    <label for="kode_pelanggan">kode Pelanggan</label>
                                    <input type="text" class="form-control" id="kode_pelanggan" readonly
                                        name="kode_pelanggan" placeholder="" value="{{ old('kode_pelanggan', $inquery->pelanggan->kode_pelanggan ?? null) }}">
                                </div>
                                <label style="font-size:14px" class="form-label" for="nama_pelanggan">Nama
                                    Pelanggan</label>
                                <div class="form-group d-flex">
                                    <input onclick="showCategoryModalPelanggan(this.value)" class="form-control"
                                        id="nama_pell" name="nama_pelanggan" type="text" placeholder=""
                                        value="{{ old('nama_pelanggan', $inquery->nama_pelanggan) }}" readonly
                                        style="margin-right: 10px; font-size:14px" />
                                    <button class="btn btn-primary" type="button"
                                        onclick="showCategoryModalPelanggan(this.value)">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                                <div class="form-group">
                                    <label style="font-size:14px" for="alamat_pelanggan">Alamat</label>
                                    <input onclick="showCategoryModalPelanggan(this.value)" style="font-size:14px"
                                        type="text" class="form-control" id="alamat_pelanggan" readonly
                                        name="alamat_pelanggan" placeholder="" value="{{ old('alamat_pelanggan', $inquery->pelanggan->alamat ?? null) }}">
                                </div>
                                <div class="form-group">
                                    <label style="font-size:14px" for="telp_pelanggan">No. Telp</label>
                                    <input onclick="showCategoryModalPelanggan(this.value)" style="font-size:14px"
                                        type="text" class="form-control" id="telp_pelanggan" readonly
                                        name="telp_pelanggan" placeholder="" value="{{ old('telp_pelanggan', $inquery->pelanggan->telp ?? null) }}">
                                </div>
                                <div class="form-check" style="color:white">
                                    <label class="form-check-label">
                                        .
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6" id="form_rute">
                        <div id="rutespk" class="card">
                            <div class="card-header">
                                <h3 class="card-title">Nama Sopir</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label style="font-size:14px" for="nama_driver">Nama Sopir</label>
                                    <input style="font-size:14px" type="text" class="form-control" id="nama_driver"
                                        name="nama_driver" placeholder="" value="{{ old('nama_driver', $inquery->nama_driver) }}">
                                </div>
                                <div class="form-group">
                                    <label style="font-size:14px" for="telp_driver">Telp</label>
                                    <input style="font-size:14px" type="text" class="form-control" id="telp_driver"
                                        name="telp_driver" placeholder="" value="{{ old('telp_driver', $inquery->telp_driver) }}">
                                </div>
                                <div class="form-group">
                                    <label style="font-size:14px" for="no_pol">No Pol Kendaraan</label>
                                    <input style="font-size:14px" type="text" class="form-control" id="no_pol"
                                        name="no_pol" placeholder="" value="{{ old('no_pol', $inquery->no_pol) }}">
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

                <div class="card-footer text-right">
                    <button type="reset" class="btn btn-secondary" id="btnReset">Reset</button>
                    <button type="submit" class="btn btn-primary" id="btnSimpan">Simpan</button>
                    <div id="loading" style="display: none;">
                        <i class="fas fa-spinner fa-spin"></i> Sedang Menyimpan...
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
                                    <tr
                                        onclick="getSelectedDataPelanggan('{{ $pelanggan->id }}', '{{ $pelanggan->kode_pelanggan }}', '{{ $pelanggan->nama_pell }}', '{{ $pelanggan->alamat }}', '{{ $pelanggan->telp }}')">
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

        <div class="modal fade" id="tableVendor" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Rekanan</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table id="datatables2" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Kode Rekanan</th>
                                    <th>Nama Rekanan</th>
                                    <th>Alamat</th>
                                    <th>No. Telp</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($vendors as $vendor)
                                    <tr
                                        onclick="getSelectedDataVendor('{{ $vendor->id }}', '{{ $vendor->kode_vendor }}', '{{ $vendor->nama_vendor }}', '{{ $vendor->alamat }}', '{{ $vendor->telp }}')">
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $vendor->kode_vendor }}</td>
                                        <td>{{ $vendor->nama_vendor }}</td>
                                        <td>{{ $vendor->alamat }}</td>
                                        <td>{{ $vendor->telp }}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-primary btn-sm"
                                                onclick="getSelectedDataVendor('{{ $vendor->id }}', '{{ $vendor->kode_vendor }}', '{{ $vendor->nama_vendor }}', '{{ $vendor->alamat }}', '{{ $vendor->telp }}')">
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

        <div class="modal fade" id="tableRute" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Rute Perjalanan</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="m-2">
                            <input type="text" id="searchInput" class="form-control" placeholder="Search...">
                        </div>
                        <div class="table-responsive scrollbar m-2">
                            <table id="tables" class="table table-bordered table-striped">
                                <thead class="bg-200 text-900">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Kode Rute</th>
                                        <th>Rute Perjalanan</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ruteperjalanans as $rute_perjalanan)
                                        <tr onclick="getSelectedDatarute('{{ $rute_perjalanan->id }}', '{{ $rute_perjalanan->kode_rute }}', '{{ $rute_perjalanan->nama_rute }}', '{{ $rute_perjalanan->golongan1 }}' , '{{ $rute_perjalanan->golongan2 }}', '{{ $rute_perjalanan->golongan3 }}', '{{ $rute_perjalanan->golongan4 }}', '{{ $rute_perjalanan->golongan5 }}', '{{ $rute_perjalanan->golongan6 }}', '{{ $rute_perjalanan->golongan7 }}', '{{ $rute_perjalanan->golongan8 }}', '{{ $rute_perjalanan->golongan9 }}', '{{ $rute_perjalanan->golongan10 }}')"
                                            class="selectable-row">
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $rute_perjalanan->kode_rute }}
                                            </td>
                                            <td>{{ $rute_perjalanan->nama_rute }}
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="getSelectedDatarute('{{ $rute_perjalanan->id }}', '{{ $rute_perjalanan->kode_rute }}', '{{ $rute_perjalanan->nama_rute }}')">
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

    <script>
        function showCategoryModalPelanggan(selectedCategory) {
            $('#tablePelanggan').modal('show');
        }

        function getSelectedDataPelanggan(Pelanggan_id, KodePelanggan, NamaPell, AlamatPel, Telpel) {
            // Set the values in the form fields
            document.getElementById('pelanggan_id').value = Pelanggan_id;
            document.getElementById('kode_pelanggan').value = KodePelanggan;
            document.getElementById('nama_pell').value = NamaPell;
            document.getElementById('alamat_pelanggan').value = AlamatPel;
            document.getElementById('telp_pelanggan').value = Telpel;
            // Close the modal (if needed)
            $('#tablePelanggan').modal('hide');
        }


        function showCategoryModalVendor(selectedCategory) {
            $('#tableVendor').modal('show');
        }

        function getSelectedDataVendor(Vendor_id, KodeVendor, NamaVendor, AlamatVendord, TelpVendor) {
            // Set the values in the form fields
            document.getElementById('vendor_id').value = Vendor_id;
            document.getElementById('kode_vendor').value = KodeVendor;
            document.getElementById('nama_vendor').value = NamaVendor;
            document.getElementById('alamat_vendor').value = AlamatVendord;
            document.getElementById('telp_vendor').value = TelpVendor;
            // Close the modal (if needed)
            $('#tableVendor').modal('hide');
        }

        function showCategoryModalrute(selectedCategory) {
            $('#tableRute').modal('show');
        }

        function getSelectedDatarute(Rute_id, KodeRute, NamaRute) {

            document.getElementById('rute_perjalanan_id').value = Rute_id;
            document.getElementById('kode_rute').value = KodeRute;
            document.getElementById('rute_perjalanan').value = NamaRute;
            // Close the modal (if needed)
            $('#tableRute').modal('hide');
        }
    </script>

@endsection
