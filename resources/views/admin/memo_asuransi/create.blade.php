@extends('layouts.app')

@section('title', 'Memo Asuransi Barang')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Memo Asuransi Barang</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
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
            @if (session('erorrss'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-ban"></i> Gagal Menyimpan!
                    </h5>
                    {{ session('erorrss') }}
                </div>
            @endif

            @if (session('error_pelanggans') || session('error_pesanans'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-ban"></i> Gagal Menyimpan!
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
            <form action="{{ url('admin/memo-asuransi') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Memo Asuransi Barang</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div id="form_spk">
                            <label style="font-size:14px" class="form-label" for="spk_id">No. Spk</label>
                            <div class="form-group d-flex">
                                <input hidden onclick="showSpk(this.value)" class="form-control" id="spk_id"
                                    name="spk_id" type="text" placeholder="" value="{{ old('spk_id') }}" readonly
                                    style="margin-right: 10px; font-size:14px" />
                                <input onclick="showSpk(this.value)" class="form-control" id="kode_spk" name="kode_spk"
                                    type="text" placeholder="" value="{{ old('kode_spk') }}" readonly
                                    style="margin-right: 10px; font-size:14px" />
                                <button class="btn btn-primary" type="button" onclick="showSpk(this.value)">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div>
                        <div class="row">
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
                                        <div class="form-group" hidden>
                                            <label for="no_pol">No Pol</label>
                                            <input type="text" class="form-control" id="no_pol" readonly
                                                name="no_pol" placeholder="" value="{{ old('no_pol') }}">
                                        </div>
                                        <label style="font-size:14px" class="form-label" for="no_kabin">No. Kabin</label>
                                        <div class="form-group d-flex">
                                            <input class="form-control" id="no_kabin" name="no_kabin" type="text"
                                                placeholder="" value="{{ old('no_kabin') }}" readonly
                                                style="margin-right: 0px; font-size:14px" />
                                        </div>
                                        <div class="form-group">
                                            <label style="font-size:14px" for="golongan">Gol. Kendaraan</label>
                                            <input style="font-size:14px" type="text" class="form-control" id="golongan"
                                                readonly name="golongan" placeholder="" value="{{ old('golongan') }}">
                                        </div>
                                        {{-- <div class="row"> --}}
                                        <div hidden class="form-group">
                                            <label style="font-size:14px" for="km">KM Awal</label>
                                            <input style="font-size:14px" type="text" class="form-control"
                                                id="km" readonly name="km_awal" placeholder=""
                                                value="{{ old('km_awal') }}">
                                        </div>
                                        <div hidden class="col-lg-6">
                                            <label style="font-size:14px" for="km_akhir">KM Awal</label>
                                            <input style="font-size:14px" type="text" class="form-control"
                                                id="km_akhir" name="km_akhir" placeholder=""
                                                value="{{ old('km_akhir') }}"
                                                onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                        </div>
                                        {{-- </div> --}}
                                        <div class="form-check" style="color:white; margin-top:16px">
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
                                        <h3 class="card-title">Driver</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group" hidden>
                                            <label for="user_id">User Id</label>
                                            <input type="text" class="form-control" id="user_id" readonly
                                                name="user_id" placeholder="" value="{{ old('user_id') }}">
                                        </div>
                                        <div class="form-group" hidden>
                                            <label for="kode_driver">kode Driver</label>
                                            <input type="text" class="form-control" id="kode_driver" readonly
                                                name="kode_driver" placeholder="" value="{{ old('kode_driver') }}">
                                        </div>
                                        <label style="font-size:14px" class="form-label" for="nama_driver">Nama
                                            Driver</label>
                                        <div class="form-group d-flex">
                                            <input class="form-control" id="nama_driver" name="nama_driver"
                                                type="text" placeholder="" value="{{ old('nama_driver') }}" readonly
                                                style="margin-right: 10px;font-size:14px" />
                                        </div>
                                        <div class="form-group">
                                            <label style="font-size:14px" for="telp">No. Telp</label>
                                            <input style="font-size:14px" type="tex" class="form-control"
                                                id="telp" readonly name="telp" placeholder=""
                                                value="{{ old('telp') }}">
                                        </div>
                                        <div hidden class="form-group">
                                            <label style="font-size:14px" for="saldo_deposit">Saldo Deposit</label>
                                            <input style="font-size:14px" type="text" class="form-control"
                                                id="saldo_deposit" readonly name="saldo_deposit" placeholder=""
                                                value="{{ old('saldo_deposit') }}">
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
                                        <h3 class="card-title">Rute Perjalanan</h3>
                                    </div>
                                    <div class="card-body">

                                        <div class="form-group" hidden>
                                            <label for="rute_perjalanan_id">rute Id</label>
                                            <input type="text" class="form-control" id="rute_perjalanan_id" readonly
                                                name="rute_perjalanan_id" placeholder="" value="{{ old('rute_perjalanan_id') }}">
                                        </div>
                                        <label style="font-size:14px" class="form-label" for="kode_rute">Kode
                                            Rute</label>
                                        <div class="form-group d-flex">
                                            <input class="form-control" id="kode_rute" name="kode_rute" type="text"
                                                placeholder="" value="{{ old('kode_rute') }}" readonly
                                                style="font-size:14px" />
                                        </div>
                                        <div class="form-group">
                                            <label style="font-size:14px" for="rute_perjalanan">Rute Perjalanan</label>
                                            <input style="font-size:14px" type="text" class="form-control"
                                                id="rute_perjalanan" readonly name="nama_rute" placeholder=""
                                                value="{{ old('nama_rute') }}">
                                        </div>
                                        <div hidden class="form-group">
                                            <label style="font-size:14px" for="biaya">Uang Jalan</label>
                                            <input style="font-size:14px" type="text" class="form-control"
                                                id="biaya" readonly name="uang_jalan" placeholder=""
                                                value="{{ old('uang_jalan') }}">
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
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tarif <span>
                            </span></h3>
                        <div class="float-right">
                            {{-- <button type="button" class="btn btn-primary btn-sm" onclick="addPesanan()">
                                <i class="fas fa-plus"></i>
                            </button> --}}
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="font-size:14px">Kode Tarif</th>
                                    <th style="font-size:14px">Nama Tarif</th>
                                    <th style="font-size:14px">Nominal Tarif</th>
                                    <th style="font-size:14px">%</th>
                                    <th style="font-size:14px">Total</th>
                                    <th style="font-size:14px; text-align:center">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td hidden>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="tarif_asuransi_id"
                                                value="{{ old('tarif_asuransi_id') }}" name="tarif_asuransi_id">
                                        </div>
                                    </td>
                                    <td onclick="addTarifasuransi(this.value)">
                                        <div class="form-group">
                                            <input style="font-size:14px" type="text" class="form-control" readonly
                                                id="kode_tarif" name="kode_tarif" value="{{ old('kode_tarif') }}">
                                        </div>
                                    </td>
                                    <td onclick="addTarifasuransi(this.value)">
                                        <div class="form-group">
                                            <input style="font-size:14px" type="text" class="form-control" readonly
                                                id="nama_tarif" name="nama_tarif" value="{{ old('nama_tarif') }}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input style="font-size:14px" type="text"
                                                class="form-control nominal_tarif" id="nominal_tarif"
                                                name="nominal_tarif" data-row-id="0" value="{{ old('nominal_tarif') }}">
                                        </div>
                                    </td>
                                    <td onclick="addTarifasuransi(this.value)">
                                        <div class="form-group">
                                            <input style="font-size:14px" readonly type="text"
                                                class="form-control persen" id="persen" name="persen"
                                                data-row-id="0" value="{{ old('persen') }}">
                                        </div>
                                    </td>
                                    <td onclick="addTarifasuransi(this.value)">
                                        <div class="form-group">
                                            <input style="font-size:14px" type="text" class="form-control hasil_tarif"
                                                readonly id="hasil_tarif" name="hasil_tarif"
                                                value="{{ old('hasil_tarif') }}">
                                        </div>
                                    </td>
                                    <td style="width: 50px">
                                        <button type="button" class="btn btn-primary btn-sm"
                                            onclick="addTarifasuransi(this.value)">
                                            <i class="fas fa-plus"></i>
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
                    <div class="card-footer text-right">
                        <button type="reset" class="btn btn-secondary" id="btnReset">Reset</button>
                        <button type="submit" class="btn btn-primary" id="btnSimpan">Simpan</button>
                        <div id="loading" style="display: none;">
                            <i class="fas fa-spinner fa-spin"></i> Sedang Menyimpan...
                        </div>
                    </div>
                </div>
            </form>

            <div class="modal fade" id="tableSpk" data-backdrop="static">
                <div class="modal-dialog" style="max-width: 70%;"> <!-- Atur lebar di sini -->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Data Spk</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive scrollbar m-2">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead class="bg-200 text-900">
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th>No. Spk</th>
                                            <th>Tanggal</th>
                                            <th>Pelanggan</th>
                                            <th>No Kabin</th>
                                            <th>No Pol</th>
                                            <th>Golongan</th>
                                            <th>Opsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($spks as $spk)
                                            <tr
                                                onclick="getSelectedDataspk('{{ $spk->id }}',
                                                    '{{ $spk->kode_spk }}','{{ $spk->kendaraan_id }}', '{{ $spk->no_kabin }}', '{{ $spk->no_pol }}', '{{ $spk->golongan }}', '{{ $spk->kendaraan->km ?? null }}','{{ $spk->km_akhir }}',
                                                    '{{ $spk->user_id }}', '{{ $spk->user->karyawan->kode_karyawan ?? '' }}', '{{ $spk->user->karyawan->nama_lengkap ?? '' }}', '{{ $spk->user->karyawan->telp ?? '' }}',
                                                    '{{ $spk->user->karyawan->tabungan ?? '' }}','{{ $spk->rute_id ?? '' }}', '{{ $spk->rute_perjalanan->kode_rute ?? '' }}', '{{ $spk->rute_perjalanan->nama_rute ?? '' }}',
                                                    '{{ $spk->uang_jalan }}')">
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td>{{ $spk->kode_spk }}</td>
                                                <td>{{ $spk->tanggal_awal }}</td>
                                                <td>{{ $spk->nama_pelanggan }}</td>
                                                <td>{{ $spk->no_kabin }}</td>
                                                <td>{{ $spk->no_pol }}</td>
                                                <td>{{ $spk->golongan }}</td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        onclick="getSelectedDataspk('{{ $spk->id }}',
                                                    '{{ $spk->kode_spk }}','{{ $spk->kendaraan_id }}', '{{ $spk->no_kabin }}', '{{ $spk->no_pol }}', '{{ $spk->golongan }}', '{{ $spk->kendaraan->km ?? null }}', '{{ $spk->km_akhir }}',
                                                    '{{ $spk->user_id }}', '{{ $spk->user->karyawan->kode_karyawan ?? '' }}', '{{ $spk->user->karyawan->nama_lengkap ?? '' }}', '{{ $spk->user->karyawan->telp ?? '' }}',
                                                    '{{ $spk->user->karyawan->tabungan ?? '' }}','{{ $spk->rute_id ?? '' }}', '{{ $spk->rute_perjalanan->kode_rute ?? '' }}', '{{ $spk->rute_perjalanan->nama_rute ?? '' }}',
                                                    '{{ $spk->uang_jalan }}')">
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
            <div class="modal fade" id="tableTarif" data-backdrop="static">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Data Tarif</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="m-2">
                                <input type="text" id="searchInputtarif" class="form-control"
                                    placeholder="Search...">
                            </div>
                            <table id="datatables3" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Kode Tarif</th>
                                        <th>Nama Tarif</th>
                                        <th>Nominal</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tarifs as $tarif)
                                        <tr
                                            onclick="getTarifs('{{ $tarif->id }}', '{{ $tarif->kode_tarif }}', '{{ $tarif->nama_tarif }}', '{{ $tarif->persen }}')">
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $tarif->kode_tarif }}</td>
                                            <td>{{ $tarif->nama_tarif }}</td>
                                            <td> {{ str_replace('.', ',', $tarif->persen) }}
                                            </td>
                                            <td class="text-center">
                                                <button type="button" id="btnTambah" class="btn btn-primary btn-sm"
                                                    onclick="getTarifs('{{ $tarif->id }}', '{{ $tarif->kode_tarif }}', '{{ $tarif->nama_tarif }}', '{{ $tarif->persen }}')">
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
        function showSpk(selectedCategory) {
            $('#tableSpk').modal('show');
        }

        function getSelectedDataspk(Spk_id, KodeSpk, Kendaraan_id, NoKabin, Nopol, Golongan, KmAwal, KmAkhir, User_id,
            KodeDriver,
            NamaDriver, Telp, SaldoDP, Rute_id, KodeRute, NamaRute, UangJalan) {
            // Set the values in the form fields
            document.getElementById('spk_id').value = Spk_id;
            document.getElementById('kode_spk').value = KodeSpk;
            document.getElementById('kendaraan_id').value = Kendaraan_id;
            document.getElementById('no_kabin').value = NoKabin;
            document.getElementById('no_pol').value = Nopol;
            document.getElementById('golongan').value = Golongan;
            document.getElementById('km').value = KmAwal;
            document.getElementById('km_akhir').value = KmAkhir;
            document.getElementById('user_id').value = User_id;
            document.getElementById('kode_driver').value = KodeDriver;
            document.getElementById('nama_driver').value = NamaDriver;
            document.getElementById('telp').value = Telp;
            var kategori = $('#kategori').val(); // Get the value of the 'kategori' select element
            // Format SaldoDP to display properly
            var formattedNominal = parseFloat(SaldoDP).toLocaleString('id-ID');
            document.getElementById('saldo_deposit').value = formattedNominal;


            var Golongan = document.getElementById("golongan").value;

            document.getElementById('rute_perjalanan_id').value = Rute_id;
            document.getElementById('kode_rute').value = KodeRute;
            document.getElementById('rute_perjalanan').value = NamaRute;

            var formattedNominals = parseFloat(UangJalan).toLocaleString('id-ID');
            document.getElementById('biaya').value = formattedNominals;
            // Close the modal

            $('#tableSpk').modal('hide');
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


    <script>
        function addTarifasuransi(selectedCategory) {

            $('#tableTarif').modal('show');
        }


        function getTarifs(Tarif_id, Kodetarif, NamaTarif, Nominal) {

            // Set the values in the form fields
            document.getElementById('tarif_asuransi_id').value = Tarif_id;
            document.getElementById('kode_tarif').value = Kodetarif;
            document.getElementById('nama_tarif').value = NamaTarif;
            document.getElementById('persen').value = Nominal;
            document.getElementById('hasil_tarif').value = 0;

            // updateHarga();
            $('#tableTarif').modal('hide');
            updateHarga();
        }
    </script>

    <script>
        function updateHarga() {
            // Ambil nilai persen dan ubah koma menjadi titik
            var persen = parseFloat($(".persen").val().replace(',', '.')) || 0;
            var nominal = parseFloat($(".nominal_tarif").val()) || 0;

            // Hitung hasil (nominal * persen / 100)
            var harga = (nominal * persen) / 100;

            // Tampilkan hasil dengan format angka Indonesia
            $(".hasil_tarif").val(harga.toLocaleString('id-ID', {
                maximumFractionDigits: 2
            }));
        }

        $(document).on("input", ".persen, .nominal_tarif", function() {
            updateHarga();
        });
    </script>
@endsection
