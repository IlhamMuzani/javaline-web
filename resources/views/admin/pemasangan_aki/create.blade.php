@extends('layouts.app')

@section('title', 'Pemasangan Aki')

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
                    <h1 class="m-0">Pemasangan Aki</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/pemasangan-part') }}">Operasional</a></li>
                        <li class="breadcrumb-item active">Pemasangan Aki</li>
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
            <form action="{{ url('admin/pemasangan-aki') }}" method="post" autocomplete="off">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Pemasangan Aki</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group" style="flex: 8;">
                            <label style="font-size:14px;" for="kendaraan_id">No Kabin</label>
                            <select class="select2bs4 select2-hidden-accessible" name="kendaraan_id"
                                data-placeholder="Cari Kabin.." style="width: 100%;" data-select2-id="23" tabindex="-1"
                                aria-hidden="true" id="kendaraan_id" onchange="getData(0)">
                                <option value="">- Pilih -</option>
                                @foreach ($kendaraans as $kendaraan_id)
                                    <option value="{{ $kendaraan_id->id }}"
                                        {{ old('kendaraan_id') == $kendaraan_id->id ? 'selected' : '' }}>
                                        {{ $kendaraan_id->no_kabin }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label style="font-size:14px;" for="alamat">No Registrasi</label>
                            <input style="font-size:14px;" type="text" class="form-control" readonly id="no_pol"
                                name="no_pol" value="{{ old('no_pol') }}">
                        </div>
                        <div class="form-group">
                            <label style="font-size:14px;" for="alamat">Jenis Kendaraan</label>
                            <input style="font-size:14px;" type="text" class="form-control" readonly id="jenis_kendaraan"
                                name="jenis_kendaraan" value="{{ old('jenis_kendaraan') }}">
                        </div>
                        <div class="form-group">
                            <label style="font-size:14px;">Tanggal Pemasangan:</label>
                            <div class="input-group date" id="reservationdatetime">
                                <input style="font-size:14px;" type="date" id="tanggal_awal" name="tanggal_awal"
                                    placeholder="d M Y sampai d M Y"
                                    data-options='{"mode":"range","dateFormat":"d M Y","disableMobile":true}'
                                    value="{{ old('tanggal_awal', date('Y-m-d')) }}" max="{{ date('Y-m-d') }}"
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
                                    <th style="font-size:14px;" class="text-center">No</th>
                                    <th style="font-size:14px;">Nomor Seri</th>
                                    <th style="font-size:14px;">Kode Aki</th>
                                    <th style="font-size:14px;">Merek Aki</th>
                                    <th style="font-size:14px;">Keterangan</th>
                                    <th style="font-size:14px;">Opsi</th>
                                </tr>
                            </thead>
                            <tbody id="tabel-pembelian">
                                <tr id="pembelian-0">
                                    <td style="font-size:14px;" class="text-center" id="urutan">1</td>
                                    <td style="width: 240px; font-size:14px">
                                        <div class="form-group">
                                            <select class="select2bs4 select21-hidden-accessible" id="aki_id-0"
                                                name="aki_id[]" data-placeholder="Cari Aki.." style="width: 100%;"
                                                data-select21-id="23" tabindex="-1" aria-hidden="true"
                                                onchange="getData1(0)">
                                                <option value="">- Pilih -</option>
                                                @foreach ($spareparts as $aki_id)
                                                    <option value="{{ $aki_id->id }}">
                                                        {{ $aki_id->no_seri }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input style="font-size:14px;" type="text" readonly class="form-control"
                                                id="kode_aki-0" name="kode_aki[]">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input style="font-size:14px;" type="text" readonly class="form-control"
                                                id="merek-0" name="merek[]">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <select style="font-size:14px;" class="form-control" id="keterangan-0"
                                                name="keterangan[]" onchange="showCategoryModal(this.value)">
                                                <option value="">Pilih</option>
                                                <option value="Pemasangan Baru"
                                                    {{ old('keterangan') == 'Pemasangan Baru' ? 'selected' : null }}>
                                                    Pemasangan Baru</option>
                                                <option value="Pergantian Rusak"
                                                    {{ old('keterangan') == 'Pergantian Rusak' ? 'selected' : null }}>
                                                    Pergantian Rusak</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="removeBan(0)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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

            // Isi elemen-elemen form dengan nilai-nilai tersebut
            // $('#no_pol').val(noPolValue);
            // $('#jenis_kendaraan').val(jenisKendaraanValue);
        });


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
                itemPembelian(urutan, key, false, value);
            });
        }

        function addPesanan() {
            jumlah_ban = jumlah_ban + 1;

            if (jumlah_ban === 1) {
                $('#tabel-pembelian').empty();
            }

            itemPembelian(jumlah_ban, jumlah_ban - 1, true);
        }

        function removeBan(params) {
            jumlah_ban = jumlah_ban - 1;

            console.log(jumlah_ban);

            var tabel_pesanan = document.getElementById('tabel-pembelian');
            var pembelian = document.getElementById('pembelian-' + params);

            tabel_pesanan.removeChild(pembelian);

            if (jumlah_ban === 0) {
                var item_pembelian = '<tr>';
                item_pembelian += '<td class="text-center" colspan="8">- Aki belum ditambahkan -</td>';
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
            item_pembelian += '<td style="font-size:14px;" class="text-center" id="urutan">' + urutan + '</td>';

            item_pembelian += '<td style="width: 240px; font-size:14px">';
            item_pembelian += '<div class="form-group">';
            item_pembelian += '<select style="font-size:14px;" class="form-control select2bs4" id="aki_id-' + key +
                '" name="aki_id[]"onchange="getDataarray(' + key + ')">';
            item_pembelian += '<option value="">Cari Aki..</option>';
            item_pembelian += '@foreach ($spareparts as $aki_id)';
            item_pembelian +=
                '<option value="{{ $aki_id->id }}" {{ $aki_id->id == ' + aki_id + ' ? 'selected' : '' }}>{{ $aki_id->no_seri }}</option>';
            item_pembelian += '@endforeach';
            item_pembelian += '</select>';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // Kode Aki 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">';
            item_pembelian += '<input style="font-size:14px;" type="text" readonly class="form-control" id="kode_aki-' +
                key +
                '" name="kode_aki[]" value="' +
                kode_aki +
                '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // Merek Aki 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">';
            item_pembelian += '<input style="font-size:14px;" type="text" readonly class="form-control" id="merek-' + key +
                '" name="merek[]" value="' +
                merek +
                '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // keterangan
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">';
            item_pembelian += '<select style="font-size:14px;" class="form-control" id="keterangan-' + key +
                '" name="keterangan[]">';
            item_pembelian += '<option value="">Pilih</option>';
            item_pembelian += '<option value="Pemasangan Baru"' + (keterangan === 'Pemasangan Baru' ? ' selected' : '') +
                '>Pemasangan Baru</option>';
            item_pembelian += '<option value="Pergantian Rusak"' + (keterangan === 'Pergantian Rusak' ? ' selected' : '') +
                '>Pergantian Rusak</option>';
            item_pembelian += '</select>';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // delete
            item_pembelian += '<td>';
            item_pembelian += '<button type="button" class="btn btn-danger btn-sm" onclick="removeBan(' + urutan + ')">';
            item_pembelian += '<i class="fas fa-trash"></i>';
            item_pembelian += '</button>';
            item_pembelian += '</td>';
            item_pembelian += '</tr>';

            if (style) {
                select2(key);
            }


            $('#tabel-pembelian').append(item_pembelian);

            $('#aki_id-' + key + '').val(aki_id).attr('selected', true);


            if (value !== null) {
                $('#aki_id-' + key).val(value.aki_id);
                // $('#kode_aki-' + key).val(value.kode_aki);
                // $('#keterangan-' + key).val(value.keterangan);
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
        }

        function select2(id) {
            $(function() {
                $('#aki_id-' + id).select2({
                    theme: 'bootstrap4'
                });
            });
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
@endsection
