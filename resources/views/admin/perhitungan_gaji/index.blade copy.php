@extends('layouts.app')

@section('title', 'Perhitungan Gaji Karyawan')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Perhitungan Gaji Karyawan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/perhitungan_gaji') }}">Perhitungan Gaji
                                Karyawan</a></li>
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
        </div>
        <form action="{{ url('admin/perhitungan_gaji') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
            @csrf
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Perhitungan Gaji Karyawan Mingguan</h3>
                </div>
                <div class="card-body">
                    <div class="form-group" style="flex: 8;">
                        <div class="row">
                            <div class="col-lg-6">
                                <label>Periode:</label>
                                <div class="input-group date" id="reservationdatetime">
                                    <input type="date" id="periode_awal" name="periode_awal"
                                        placeholder="d M Y sampai d M Y"
                                        data-options='{"mode":"range","dateFormat":"d M Y","disableMobile":true}'
                                        value="{{ old('periode_awal') }}" class="form-control datetimepicker-input"
                                        data-target="#reservationdatetime">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label style="color:white">.</label>
                                <div class="input-group date" id="reservationdatetime">
                                    <input type="date" id="periode_akhir" name="periode_akhir"
                                        placeholder="d M Y sampai d M Y"
                                        data-options='{"mode":"range","dateFormat":"d M Y","disableMobile":true}'
                                        value="{{ old('periode_akhir') }}" class="form-control datetimepicker-input"
                                        data-target="#reservationdatetime">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="float-right mb-3">
                        <button type="button" class="btn btn-primary btn-sm" onclick="addPesanan()">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    <div class="table-responsive">
                        <!-- Hapus class "overflow-x-auto" -->
                        <table class="table table-bordered table-striped">
                            <!-- Tambahkan class "table-responsive" -->
                            <thead>
                                <tr>
                                    <!-- Tambahkan style untuk lebar kolom -->
                                    <th style="font-size:14px; width: 50px;" class="text-center">No</th>
                                    <th style="font-size:14px; min-width: 150px;">Nama</th>
                                    <th style="font-size:14px; min-width: 150px;">Gapok</th>
                                    <th style="font-size:14px; min-width: 150px;">UM</th>
                                    <th style="font-size:14px; min-width: 150px;">UH</th>
                                    <th style="font-size:14px; min-width: 150px;">HK</th>
                                    <th style="font-size:14px; min-width: 150px;">Lembur</th>
                                    <th style="font-size:14px; min-width: 150px;">HL</th>
                                    <th style="font-size:14px; min-width: 150px;">Storing</th>
                                    <th style="font-size:14px; min-width: 150px;">Storing Hasil</th>
                                    <th style="font-size:14px; min-width: 150px;">Gaji Kotor</th>
                                    <th style="font-size:14px; min-width: 150px;">keterlambatan</th>
                                    <th style="font-size:14px; min-width: 150px;">Absen</th>
                                    <th style="font-size:14px; min-width: 150px;">Pelunasan</th>
                                    <th style="font-size:14px; min-width: 150px;">Gaji Bersih</th>
                                    <th style="font-size:14px; text-align:center; min-width: 100px;">Opsi</th>
                                </tr>
                            </thead>
                            <tbody id="tabel-pembelian">
                                <tr id="pembelian-0">
                                    <td style="width: 70px; font-size:14px" class="text-center" id="urutan">1
                                    </td>
                                    <td hidden>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="karyawan_id-0"
                                                name="karyawan_id[]">
                                        </div>
                                    </td>
                                    <td hidden>
                                        <div class="form-group">
                                            <input onclick="Karyawan(0)" style="font-size:14px" type="text" readonly
                                                class="form-control" id="kode_karyawan-0" name="kode_karyawan[]">
                                        </div>
                                    </td>
                                    <td style="width: 150px;">
                                        <div class="form-group">
                                            <input onclick="Karyawan(0)" style="font-size:14px" type="text" readonly
                                                class="form-control" id="nama_lengkap-0" name="nama_lengkap[]">
                                        </div>
                                    </td>
                                    <td style="width: 150px;">
                                        <div class="form-group">
                                            <input type="number" onclick="Karyawan(0)" style="font-size:14px" readonly
                                                class="form-control gaji" id="gaji-0" name="gaji[]" data-row-id="0">
                                        </div>
                                    </td>
                                    <td style="width: 150px;">
                                        <div class="form-group">
                                            <input type="number" onclick="Karyawan(0)" style="font-size:14px" readonly
                                                class="form-control uang_makan" id="uang_makan-0" name="uang_makan[]">
                                        </div>
                                    </td>
                                    <td style="width: 150px;">
                                        <div class="form-group">
                                            <input onclick="Karyawan(0)" onclick="Karyawan(0)" style="font-size:14px"
                                                readonly type="number" class="form-control uang_hadir" id="uang_hadir-0"
                                                name="uang_hadir[]" data-row-id="0">
                                        </div>
                                    </td>
                                    <td style="width: 150px;">
                                        <div class="form-group">
                                            <input type="number" style="font-size:14px" class="form-control hari_kerja"
                                                id="hari_kerja-0" name="hari_kerja[]" data-row-id="0">
                                        </div>
                                    </td style="width: 150px;">
                                    <td>
                                        <div class="form-group">
                                            <input style="font-size:14px" type="number" class="form-control lembur"
                                                id="lembur-0" name="lembur[]" data-row-id="0">
                                        </div>
                                    </td>
                                    <td style="width: 150px;">
                                        <div class="form-group">
                                            <input style="font-size:14px" readonly type="number"
                                                class="form-control hasil_lembur" id="hasil_lembur-0"
                                                name="hasil_lembur[]" data-row-id="0">
                                        </div>
                                    </td>
                                    <td style="width: 150px;">
                                        <div class="form-group">
                                            <input style="font-size:14px" type="number" class="form-control storing"
                                                id="storing-0" name="storing[]" data-row-id="0">
                                        </div>
                                    </td>
                                    <td style="width: 150px;">
                                        <div class="form-group">
                                            <input style="font-size:14px" readonly type="number"
                                                class="form-control hasil_storing" id="hasil_storing-0"
                                                name="hasil_storing[]" data-row-id="0">
                                        </div>
                                    </td>
                                    <td style="width: 150px;">
                                        <div class="form-group">
                                            <input style="font-size:14px" onclick="Karyawan(0)" readonly type="number"
                                                class="form-control gaji_kotor" id="gaji_kotor-0" name="gaji_kotor[]">
                                        </div>
                                    </td>
                                    <td style="width: 150px;">
                                        <div class="form-group">
                                            <input style="font-size:14px" type="number"
                                                class="form-control keterlambatan" id="keterlambatan-0"
                                                name="keterlambatan[]">
                                        </div>
                                    </td>
                                    <td style="width: 150px;">
                                        <div class="form-group">
                                            <input style="font-size:14px" type="number" class="form-control absen"
                                                id="absen-0" name="absen[]">
                                        </div>
                                    </td>
                                    <td style="width: 150px;">
                                        <div class="form-group">
                                            <input style="font-size:14px" type="number"
                                                class="form-control pelunasan_kasbon" id="pelunasan_kasbon-0"
                                                name="pelunasan_kasbon[]">
                                        </div>
                                    </td>
                                    <td style="width: 150px;">
                                        <div class="form-group">
                                            <input style="font-size:14px" onclick="Karyawan(0)" readonly type="number"
                                                class="form-control gaji_bersih" id="gaji_bersih-0" name="gaji_bersih[]">
                                        </div>
                                    </td>
                                    <td style="width: 100px">
                                        <button type="button" class="btn btn-primary btn-sm" onclick="Karyawan(0)">
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

                <div style="margin-right: 20px; margin-left:20px" class="form-group">
                    <label for="alamat">Keterangan</label>
                    <textarea type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Masukan keterangan">{{ old('keterangan') }}</textarea>
                </div>
                <div style="margin-right: 20px; margin-left:20px" class="form-group">
                    <label style="font-size:14px" class="mt-3" for="nopol">Grand Total</label>
                    <input style="font-size:14px" type="text" class="form-control text-right" id="grand_total"
                        name="grand_total" readonly placeholder="" value="{{ old('grand_total') }}">
                </div>
                <div class="card-footer text-right">
                    <button type="reset" class="btn btn-secondary" id="btnReset">Reset</button>
                    <button type="submit" class="btn btn-primary" id="btnSimpan">Simpan</button>
                    <div id="loading" style="display: none;">
                        <i class="fas fa-spinner fa-spin"></i> Sedang Menyimpan...
                    </div>
                </div>
            </div>

            <div class="modal fade" id="tableMemo" data-backdrop="static">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Data Gaji Karyawan</h4>
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
                                        <th>Kode Karyawan</th>
                                        <th>Nama Karyawan</th>
                                        <th>Gapok</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($karyawans as $karyawan)
                                        <tr onclick="getMemos({{ $loop->index }})" data-id="{{ $karyawan->id }}"
                                            data-kode_karyawan="{{ $karyawan->kode_karyawan }}"
                                            data-nama_lengkap="{{ $karyawan->nama_lengkap }}"
                                            data-gaji="{{ $karyawan->gaji }}" data-param="{{ $loop->index }}">
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $karyawan->kode_karyawan }}</td>
                                            <td>{{ $karyawan->nama_lengkap }}</td>
                                            <td>{{ number_format($karyawan->gaji, 0, ',', '.') }}</td>
                                            <td class="text-center">
                                                <button type="button" id="btnTambah" class="btn btn-primary btn-sm"
                                                    onclick="getMemos({{ $loop->index }})">
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
        // filter rute 
        function filterMemo() {
            var input, filter, table, tr, td, i, txtValue;
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
        document.getElementById("searchInput").addEventListener("input", filterMemo);
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
            updateGrandTotal();
        }

        function itemPembelian(urutan, key, value = null) {
            var karyawan_id = '';
            var kode_karyawan = '';
            var nama_lengkap = '';
            var gaji = '';
            var uang_makan = '';
            var uang_hadir = '';
            var hari_kerja = '';
            var lembur = '';
            var hasil_lembur = '';
            var storing = '';
            var hasil_storing = '';
            var gaji_kotor = '';
            var keterlambatan = '';
            var pelunasan_kasbon = '';
            var absen = '';
            var gaji_bersih = '';

            if (value !== null) {
                karyawan_id = value.karyawan_id;
                kode_karyawan = value.kode_karyawan;
                nama_lengkap = value.nama_lengkap;
                gaji = value.gaji;
                uang_makan = value.uang_makan;
                uang_hadir = value.uang_hadir;
                hari_kerja = value.hari_kerja;
                lembur = value.lembur;
                hasil_lembur = value.hasil_lembur;
                storing = value.storing;
                hasil_storing = value.hasil_storing;
                gaji_kotor = value.gaji_kotor;
                keterlambatan = value.keterlambatan;
                pelunasan_kasbon = value.pelunasan_kasbon;
                absen = value.absen;
                gaji_bersih = value.gaji_bersih;
            }

            // urutan 
            var item_pembelian = '<tr id="pembelian-' + urutan + '">';
            item_pembelian += '<td style="width: 70px; font-size:14px" class="text-center" id="urutan-' + urutan + '">' +
                urutan + '</td>';

            // karyawan_id 
            item_pembelian += '<td hidden>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" id="karyawan_id-' + urutan +
                '" name="karyawan_id[]" value="' + karyawan_id + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // kode_karyawan 
            item_pembelian += '<td hidden onclick="Karyawan(' + urutan +
                ')">';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" readonly style="font-size:14px" id="kode_karyawan-' +
                urutan +
                '" name="kode_karyawan[]" value="' + kode_karyawan + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // nama_lengkap 
            item_pembelian += '<td onclick="Karyawan(' + urutan +
                ')">';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" readonly style="font-size:14px" id="nama_lengkap-' +
                urutan +
                '" name="nama_lengkap[]" value="' + nama_lengkap + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // gaji 
            item_pembelian += '<td onclick="Karyawan(' + urutan +
                ')">';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="number" class="form-control gaji" style="font-size:14px" readonly id="gaji-' +
                urutan +
                '" name="gaji[]" value="' + gaji + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // uang_makan 
            item_pembelian += '<td onclick="Karyawan(' + urutan +
                ')">';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="number" class="form-control uang_makan" style="font-size:14px" readonly id="uang_makan-' +
                urutan +
                '" name="uang_makan[]" value="' + uang_makan + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // uang_hadir
            item_pembelian += '<td onclick="Karyawan(' + urutan +
                ')">';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="number" class="form-control uang_hadir" readonly style="font-size:14px" id="uang_hadir-' +
                urutan +
                '" name="uang_hadir[]" value="' + uang_hadir + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // hari_kerja 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="number" class="form-control hari_kerja" style="font-size:14px" id="hari_kerja-' +
                urutan +
                '" name="hari_kerja[]" value="' + hari_kerja + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // lembur 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="number" class="form-control lembur" style="font-size:14px" id="lembur-' +
                urutan +
                '" name="lembur[]" value="' + lembur + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // hasil_lembur 
            item_pembelian += '<td onclick="Karyawan(' + urutan +
                ')">';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="number" class="form-control hasil_lembur" style="font-size:14px" readonly id="hasil_lembur-' +
                urutan +
                '" name="hasil_lembur[]" value="' + hasil_lembur + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // storing 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="number" class="form-control storing" style="font-size:14px" id="storing-' +
                urutan +
                '" name="storing[]" value="' + storing + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // hasil_storing 
            item_pembelian += '<td onclick="Karyawan(' + urutan +
                ')">';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="number" class="form-control hasil_storing" style="font-size:14px" readonly id="hasil_storing-' +
                urutan +
                '" name="hasil_storing[]" value="' + hasil_storing + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // gaji_kotor 
            item_pembelian += '<td onclick="Karyawan(' + urutan +
                ')">';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="number" class="form-control gaji_kotor" style="font-size:14px" readonly id="gaji_kotor-' +
                urutan +
                '" name="gaji_kotor[]" value="' + gaji_kotor + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // keterlambatan 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="number" class="form-control keterlambatan" style="font-size:14px" id="keterlambatan-' +
                urutan +
                '" name="keterlambatan[]" value="' + keterlambatan + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // absen 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="number" class="form-control absen" style="font-size:14px" id="absen-' +
                urutan +
                '" name="absen[]" value="' + absen + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // pelunasan_kasbon 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="number" class="form-control pelunasan_kasbon" style="font-size:14px" id="pelunasan_kasbon-' +
                urutan +
                '" name="pelunasan_kasbon[]" value="' + pelunasan_kasbon + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // gaji_bersih 
            item_pembelian += '<td onclick="Karyawan(' + urutan +
                ')">';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="number" class="form-control gaji_bersih" style="font-size:14px" readonly id="gaji_bersih-' +
                urutan +
                '" name="gaji_bersih[]" value="' + gaji_bersih + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';
            item_pembelian += '<td style="width: 100px">';
            item_pembelian += '<button type="button" class="btn btn-primary btn-sm" onclick="Karyawan(' + urutan +
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

        function Karyawan(param) {
            activeSpecificationIndex = param;
            // Show the modal and filter rows if necessary
            $('#tableMemo').modal('show');
        }

        function getMemos(rowIndex) {
            var selectedRow = $('#tables tbody tr:eq(' + rowIndex + ')');
            var karyawan_id = selectedRow.data('id');
            var kode_karyawan = selectedRow.data('kode_karyawan');
            var nama_lengkap = selectedRow.data('nama_lengkap');
            var gaji = selectedRow.data('gaji');

            // Update the form fields for the active specification
            $('#karyawan_id-' + activeSpecificationIndex).val(karyawan_id);
            $('#kode_karyawan-' + activeSpecificationIndex).val(kode_karyawan);
            $('#nama_lengkap-' + activeSpecificationIndex).val(nama_lengkap);
            $('#gaji-' + activeSpecificationIndex).val(gaji);

            // Hide the modal after updating the form fields
            $('#tableMemo').modal('hide');
        }
    </script>

    {{-- hasil --}}
    <script>
        $(document).on("input", ".gaji, .lembur, .storing, .keterlambatan, .pelunasan_kasbon, .absen, .hari_kerja",
            function() {
                // Ambil baris saat ini
                var currentRow = $(this).closest('tr');

                // Ambil nilai dari input
                var gaji = parseFloat(currentRow.find(".gaji").val()) || 0;
                var hari_kerja = parseFloat(currentRow.find(".hari_kerja").val()) || 0;
                var lembur = parseFloat(currentRow.find(".lembur").val()) || 0;
                var storing = parseFloat(currentRow.find(".storing").val()) || 0;
                var keterlambatan = parseFloat(currentRow.find(".keterlambatan").val()) || 0;
                var pelunasan_kasbon = parseFloat(currentRow.find(".pelunasan_kasbon").val()) || 0;
                var absen = parseFloat(currentRow.find(".absen").val()) || 0;

                // Hitung uang makan dan uang hadir
                var uang_makan = hari_kerja * 10000;
                var uang_hadir = hari_kerja * 5000;

                // Hitung hasil lembur dan storing
                var hasil_lembur = lembur * 10000;
                var gajiperjam = gaji / 12;
                var hasil_storing = Math.round(gajiperjam * storing); // Menggunakan Math.round() untuk membulatkan

                // Hitung gaji kotor dan gaji bersih
                var gaji_kotor = (gaji + 10000 + 5000) * hari_kerja + hasil_lembur + hasil_storing;
                // var gaji_bersih = gaji_kotor - keterlambatan - pelunasan_kasbon - absen;
                var gaji_bersih = gaji_kotor - keterlambatan - absen;

                // Masukkan hasil perhitungan ke dalam input yang sesuai
                currentRow.find(".uang_makan").val(uang_makan);
                currentRow.find(".uang_hadir").val(uang_hadir);
                currentRow.find(".hasil_lembur").val(hasil_lembur);
                currentRow.find(".hasil_storing").val(hasil_storing);
                currentRow.find(".gaji_kotor").val(gaji_kotor);
                currentRow.find(".gaji_bersih").val(gaji_bersih);
                updateGrandTotal();

            });
    </script>

    {{-- grand_total --}}
    <script>
        function updateGrandTotal() {
            var grandTotal = 0;

            // Loop through all elements with name "nominal_tambahan[]"
            $('input[name^="gaji_bersih"]').each(function() {
                var nominalValue = parseFloat($(this).val().replace(/\./g, '')) || 0; // Remove dots
                grandTotal += nominalValue;
            });

            $('#grand_total').val(formatRupiah(grandTotal));

        }

        $('body').on('input', 'input[name^="gaji_bersih"]', function() {
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

@endsection
