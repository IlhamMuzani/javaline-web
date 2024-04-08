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
                        <div class="col-md-0 mb-3">
                            <label>Kategori</label>
                            <select class="custom-select form-control" id="statusx" name="statusx">
                                <option value="">- Pilih Kategori -</option>
                                <option value="memo_perjalanan" selected>Gaji Mingguan</option>
                                @if (auth()->check() && auth()->user()->menu['gaji karyawan'])
                                    <option value="memo_borong">Gaji Bulanan</option>
                                @endif
                            </select>
                        </div>
                    </div>
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
                    <!-- Tombol untuk menggeser tabel ke kanan -->
                    {{-- <button type="button" class="btn btn-secondary btn-sm" onclick="geserTabelKeKanan()">
                        <i class="fas fa-arrow-right"></i>
                    </button> --}}

                    <div class="table-responsive">
                        <!-- Hapus class "overflow-x-auto" -->
                        <table class="table table-bordered table-striped">
                            <!-- Tambahkan class "table-responsive" -->
                            <thead>
                                <tr>
                                    <!-- Tambahkan style untuk lebar kolom -->
                                    <th style="font-size:14px; text-align:center; width: 50px;" class="text-center">NO</th>
                                    <th style="font-size:14px; text-align:center; min-width: 150px;">NAMA</th>
                                    <th style="font-size:14px; text-align:center; min-width: 150px;">GAPOK</th>
                                    <th style="font-size:14px; text-align:center; min-width: 150px;">UM</th>
                                    <th style="font-size:14px; text-align:center; min-width: 150px;">UH</th>
                                    <th style="font-size:14px; text-align:center; min-width: 150px;">HK</th>
                                    <th style="font-size:14px; text-align:center; min-width: 150px;">LEMBUR <br> <span>
                                            (JAM)
                                        </span>
                                    </th>
                                    <th style="font-size:14px; text-align:center; min-width: 150px;">HASIL LEMBUR</th>
                                    <th style="font-size:14px; text-align:center; min-width: 150px;">STORING <br> <span>
                                            (JAM)
                                        </span>
                                    </th>
                                    <th style="font-size:14px; text-align:center; min-width: 150px;">STORING HASIL</th>
                                    <th style="font-size:14px; text-align:center; min-width: 150px;">GAJI KOTOR</th>
                                    <th style="font-size:14px; text-align:center; min-width: 300px;">KETERLAMBATAN <br>
                                        <span>
                                            (< 30 MENIT) (> 30 MENIT)
                                        </span>
                                    </th>
                                    <th style="font-size:14px; text-align:center; min-width: 300px;">HASIL TERLAMBAT <br>
                                        <span>
                                            (< 30 MENIT) (> 30 MENIT)
                                        </span>
                                    </th>
                                    <th style="font-size:14px; text-align:center; min-width: 150px;">ABSEN</th>
                                    <th style="font-size:14px; text-align:center; min-width: 150px;">HASIL ABSEN</th>
                                    <th style="font-size:14px; text-align:center; min-width: 150px;">BPJS</th>
                                    <th style="font-size:14px; text-align:center; min-width: 150px;">LAINYA</th>
                                    <th style="font-size:14px; text-align:center; min-width: 150px;">PELUNASAN</th>
                                    {{-- <th style="font-size:14px; text-align:center; min-width: 150px;">GAJI NOL PELUNASAN
                                    </th> --}}
                                    <th style="font-size:14px; text-align:center; min-width: 150px;">GAJI BERSIH</th>
                                    <th style="font-size:14px; text-align:center; min-width: 100px;">OPSI</th>
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
                                            <input type="text" onclick="Karyawan(0)" style="font-size:14px" readonly
                                                class="form-control gaji" id="gaji-0" name="gaji[]" data-row-id="0">
                                        </div>
                                    </td>
                                    <td style="width: 150px;">
                                        <div class="form-group">
                                            <input type="text" style="font-size:14px" readonly
                                                class="form-control uang_makan" id="uang_makan-0" name="uang_makan[]">
                                        </div>
                                    </td>
                                    <td style="width: 150px;">
                                        <div class="form-group">
                                            <input style="font-size:14px" readonly type="text"
                                                class="form-control uang_hadir" id="uang_hadir-0" name="uang_hadir[]"
                                                data-row-id="0">
                                        </div>
                                    </td>
                                    <td style="width: 150px;">
                                        <div class="form-group">
                                            <input type="text" style="font-size:14px" class="form-control hari_kerja"
                                                id="hari_kerja-0" name="hari_kerja[]" data-row-id="0"
                                                onkeypress="return isNumberKey(event)">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input style="font-size:14px" type="text" class="form-control lembur"
                                                id="lembur-0" name="lembur[]" data-row-id="0"
                                                onkeypress="return isNumberKey(event)">
                                        </div>
                                    </td>
                                    <td style="width: 150px;">
                                        <div class="form-group">
                                            <input style="font-size:14px" readonly type="text"
                                                class="form-control hasil_lembur" id="hasil_lembur-0"
                                                name="hasil_lembur[]" data-row-id="0">
                                        </div>
                                    </td>
                                    <td style="width: 150px;">
                                        <div class="form-group">
                                            <input style="font-size:14px" type="text" class="form-control storing"
                                                id="storing-0" name="storing[]" data-row-id="0"
                                                onkeypress="return isNumberKey(event)">
                                        </div>
                                    </td>
                                    <td style="width: 150px;">
                                        <div class="form-group">
                                            <input style="font-size:14px" readonly type="text"
                                                class="form-control hasil_storing" id="hasil_storing-0"
                                                name="hasil_storing[]" data-row-id="0">
                                        </div>
                                    </td>
                                    <td style="width: 150px;">
                                        <div class="form-group">
                                            <input style="font-size:14px" readonly type="text"
                                                class="form-control gaji_kotor" id="gaji_kotor-0" name="gaji_kotor[]">
                                        </div>
                                    </td>
                                    <td style="width: 300px;">
                                        <div style="display: flex; justify-content: space-between;">
                                            <div style="width: 45%;">
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="number"
                                                        class="form-control kurangtigapuluh" id="kurangtigapuluh-0"
                                                        name="kurangtigapuluh[]">
                                                </div>
                                            </div>
                                            <div style="width: 45%;">
                                                <div class="form-group">
                                                    <input style="font-size:14px" type="number"
                                                        class="form-control lebihtigapuluh" id="lebihtigapuluh-0"
                                                        name="lebihtigapuluh[]">
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td style="width: 300px;">
                                        <div style="display: flex; justify-content: space-between;">
                                            <div style="width: 45%;">
                                                <div class="form-group">
                                                    <input style="font-size:14px" readonly type="text"
                                                        class="form-control hasilkurang" id="hasilkurang-0"
                                                        name="hasilkurang[]">
                                                </div>
                                            </div>
                                            <div style="width: 45%;">
                                                <div class="form-group">
                                                    <input style="font-size:14px" readonly type="text"
                                                        class="form-control hasillebih" id="hasillebih-0"
                                                        name="hasillebih[]">
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="width: 150px;">
                                        <div class="form-group">
                                            <input style="font-size:14px" type="number" class="form-control absen"
                                                id="absen-0" name="absen[]" oninput="formatRupiahform(this)"
                                                onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                        </div>
                                    </td>
                                    <td style="width: 150px;">
                                        <div class="form-group">
                                            <input style="font-size:14px" readonly type="text"
                                                class="form-control hasil_absen" id="hasil_absen-0" name="hasil_absen[]"
                                                data-row-id="0">
                                        </div>
                                    </td>
                                    <td style="width: 150px;">
                                        <div class="form-group">
                                            <input type="text" style="font-size:14px"
                                                class="form-control potongan_bpjs" readonly id="potongan_bpjs-0"
                                                name="potongan_bpjs[]" data-row-id="0">
                                        </div>
                                    </td>
                                    <td style="width: 150px;">
                                        <div class="form-group">
                                            <input style="font-size:14px" type="text" class="form-control lainya"
                                                id="lainya-0" name="lainya[]" oninput="formatRupiahform(this)"
                                                onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                        </div>
                                    </td>
                                    <td style="width: 150px;">
                                        <div class="form-group">
                                            <input style="font-size:14px" type="text"
                                                class="form-control pelunasan_kasbon" id="pelunasan_kasbon-0"
                                                name="pelunasan_kasbon[]" oninput="formatRupiahform(this)"
                                                onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                        </div>
                                    </td>
                                    <td hidden style="width: 150px;">
                                        <div class="form-group">
                                            <input style="font-size:14px" readonly type="text"
                                                class="form-control gajinol_pelunasan" id="gajinol_pelunasan-0"
                                                name="gajinol_pelunasan[]">
                                        </div>
                                    </td>
                                    <td style="width: 150px;">
                                        <div class="form-group">
                                            <input style="font-size:14px" readonly type="text"
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
                    <div class="float-left mb-2 mt-3">
                        <button type="button" class="btn btn-primary btn-sm" onclick="addPesanan()">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>

                <div style="margin-right: 20px; margin-left:20px" class="form-group">
                    <label for="alamat">Keterangan</label>
                    <textarea type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Masukan keterangan">{{ old('keterangan') }}</textarea>
                </div>
                <div style="margin-right: 20px; margin-left:20px" class="form-group">
                    <label style="font-size:14px" class="mt-0" for="total_gaji">Total Gaji</label>
                    <input style="font-size:14px" type="text" class="form-control text-right" id="total_gaji"
                        name="total_gaji" readonly placeholder="" value="{{ old('total_gaji') }}">
                </div>
                <div style="margin-right: 20px; margin-left:20px" class="form-group">
                    <label style="font-size:14px" class="mt-0" for="total_pelunasan">Total Pelunasan</label>
                    <input style="font-size:14px" type="text" class="form-control text-right" id="total_pelunasan"
                        name="total_pelunasan" readonly placeholder="" value="{{ old('total_pelunasan') }}">
                </div>
                <hr style="border-width: 2px; border-color: black; margin-right: 20px; margin-left: 20px;">
                <div style="margin-right: 20px; margin-left:20px" class="form-group">
                    <label style="font-size:14px" class="mb-0" for="nopol">Grand Total</label>
                    <input style="font-size:14px" type="text" class="form-control text-right" id="grand_total"
                        name="grand_total" readonly placeholder="" value="{{ old('grand_total') }}">
                </div>
                <div class="card-footer text-right mt-3">
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
                                            data-gaji="{{ $karyawan->gaji }}" data-bpjs="{{ $karyawan->bpjs }}"
                                            data-param="{{ $loop->index }}">
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
            var kurangtigapuluh = '';
            var lebihtigapuluh = '';
            var hasilkurang = '';
            var hasillebih = '';
            var pelunasan_kasbon = '';
            var absen = '';
            var hasil_absen = '';
            var potongan_bpjs = '';
            var lainya = '';
            var gajinol_pelunasan = '';
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
                kurangtigapuluh = value.kurangtigapuluh;
                lebihtigapuluh = value.lebihtigapuluh;
                hasilkurang = value.hasilkurang;
                hasillebih = value.hasillebih;
                pelunasan_kasbon = value.pelunasan_kasbon;
                absen = value.absen;
                hasil_absen = value.hasil_absen;
                potongan_bpjs = value.potongan_bpjs;
                lainya = value.lainya;
                gajinol_pelunasan = value.gajinol_pelunasan;
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
            item_pembelian += '<input type="text" class="form-control gaji" style="font-size:14px" readonly id="gaji-' +
                urutan +
                '" name="gaji[]" value="' + gaji + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // uang_makan 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control uang_makan" style="font-size:14px" readonly id="uang_makan-' +
                urutan +
                '" name="uang_makan[]" value="' + uang_makan + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // uang_hadir
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control uang_hadir" readonly style="font-size:14px" id="uang_hadir-' +
                urutan +
                '" name="uang_hadir[]" value="' + uang_hadir + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // hari_kerja 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control hari_kerja" onkeypress="return isNumberKey(event)" style="font-size:14px" id="hari_kerja-' +
                urutan +
                '" name="hari_kerja[]" value="' + hari_kerja + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // lembur 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control lembur" onkeypress="return isNumberKey(event)" style="font-size:14px" id="lembur-' +
                urutan +
                '" name="lembur[]" value="' + lembur + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // hasil_lembur 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control hasil_lembur" style="font-size:14px" readonly id="hasil_lembur-' +
                urutan +
                '" name="hasil_lembur[]" value="' + hasil_lembur + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // storing 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control storing" onkeypress="return isNumberKey(event)" style="font-size:14px" id="storing-' +
                urutan +
                '" name="storing[]" value="' + storing + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // hasil_storing 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control hasil_storing" style="font-size:14px" readonly id="hasil_storing-' +
                urutan +
                '" name="hasil_storing[]" value="' + hasil_storing + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // gaji_kotor 
            item_pembelian += '<td >';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control gaji_kotor" style="font-size:14px" readonly id="gaji_kotor-' +
                urutan +
                '" name="gaji_kotor[]" value="' + gaji_kotor + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // keterlambatan
            item_pembelian += '<td style="width: 300px;">';
            item_pembelian += '<div style="display: flex; justify-content: space-between;">';
            item_pembelian += '<div style="width: 45%;">';
            item_pembelian += '<div class="form-group">';
            item_pembelian +=
                '<input type="number" class="form-control kurangtigapuluh" style="font-size:14px" id="kurangtigapuluh-' +
                urutan + '" name="kurangtigapuluh[]" value="' + kurangtigapuluh + '">';
            item_pembelian += '</div>';
            item_pembelian += '</div>';
            item_pembelian += '<div style="width: 45%;">';
            item_pembelian += '<div class="form-group">';
            item_pembelian +=
                '<input type="number" class="form-control lebihtigapuluh" style="font-size:14px" id="lebihtigapuluh-' +
                urutan + '" name="lebihtigapuluh[]" value="' + lebihtigapuluh + '">';
            item_pembelian += '</div>';
            item_pembelian += '</div>';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // hasil_terlambat
            item_pembelian += '<td style="width: 300px;">';
            item_pembelian += '<div style="display: flex; justify-content: space-between;">';
            item_pembelian += '<div style="width: 45%;">';
            item_pembelian += '<div class="form-group">';
            item_pembelian +=
                '<input type="text" class="form-control hasilkurang" readonly style="font-size:14px" id="hasilkurang-' +
                urutan +
                '" name="hasilkurang[]" value="' + hasilkurang + '">';
            item_pembelian += '</div>';
            item_pembelian += '</div>';
            item_pembelian += '<div style="width: 45%;">';
            item_pembelian += '<div class="form-group">';
            item_pembelian +=
                '<input type="text" class="form-control hasillebih" readonly style="font-size:14px" id="hasillebih-' +
                urutan +
                '" name="hasillebih[]" value="' + hasillebih + '">';
            item_pembelian += '</div>';
            item_pembelian += '</div>';
            item_pembelian += '</div>';
            item_pembelian += '</td>';


            // absen 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">';
            item_pembelian +=
                '<input type="number" class="form-control absen" style="font-size:14px" id="absen-' +
                urutan +
                '" name="absen[]" value="' + absen + '" ';
            item_pembelian += 'oninput="formatRupiahform(this)" ';
            item_pembelian += 'onkeypress="return event.charCode >= 48 && event.charCode <= 57">';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // hasil_absen 
            item_pembelian += '<td >';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control hasil_absen" style="font-size:14px" readonly id="hasil_absen-' +
                urutan +
                '" name="hasil_absen[]" value="' + hasil_absen + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // bpjs 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control potongan_bpjs" style="font-size:14px" readonly id="potongan_bpjs-' +
                urutan +
                '" name="potongan_bpjs[]" value="' + potongan_bpjs + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // lainya 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">';
            item_pembelian +=
                '<input type="text" class="form-control lainya" style="font-size:14px" id="lainya-' +
                urutan +
                '" name="lainya[]" value="' + lainya + '" ';
            item_pembelian += 'oninput="formatRupiahform(this)" ';
            item_pembelian += 'onkeypress="return event.charCode >= 48 && event.charCode <= 57">';
            item_pembelian += '</div>';
            item_pembelian += '</td>';


            // pelunasan_kasbon 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">';
            item_pembelian +=
                '<input type="text" class="form-control pelunasan_kasbon" style="font-size:14px" id="pelunasan_kasbon-' +
                urutan +
                '" name="pelunasan_kasbon[]" value="' + pelunasan_kasbon + '" ';
            item_pembelian += 'oninput="formatRupiahform(this)" ';
            item_pembelian += 'onkeypress="return event.charCode >= 48 && event.charCode <= 57">';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // gajinol_pelunasan 
            item_pembelian += '<td hidden>';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control gajinol_pelunasan" style="font-size:14px" readonly id="gajinol_pelunasan-' +
                urutan +
                '" name="gajinol_pelunasan[]" value="' + gajinol_pelunasan + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // gaji_bersih 
            item_pembelian += '<td >';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control gaji_bersih" style="font-size:14px" readonly id="gaji_bersih-' +
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
            var bpjs = selectedRow.data('bpjs');
            var gaji = parseFloat(selectedRow.data('gaji')).toLocaleString('id-ID');

            // Update the form fields for the active specification
            $('#karyawan_id-' + activeSpecificationIndex).val(karyawan_id);
            $('#kode_karyawan-' + activeSpecificationIndex).val(kode_karyawan);
            $('#nama_lengkap-' + activeSpecificationIndex).val(nama_lengkap);
            $('#potongan_bpjs-' + activeSpecificationIndex).val(bpjs);
            $('#gaji-' + activeSpecificationIndex).val(gaji);

            // Check if bpjs is not null or has a value
            if (bpjs !== null && bpjs !== '') {
                // Jika ada nilai bpjs
                if (bpjs === 65735) {
                    // Jika nilai bpjs adalah 65735, tandai checkbox potongan_bpjs dan atur nilainya menjadi 65735
                    $('#potongan_bpjs-' + activeSpecificationIndex).val((65735).toLocaleString('id-ID'));
                } else if (bpjs === 43823) {
                    // Jika nilai bpjs adalah 43823, tandai checkbox potongan_bpjs dan atur nilainya menjadi 43823
                    $('#potongan_bpjs-' + activeSpecificationIndex).val((43823).toLocaleString('id-ID'));
                }
            } else {
                // Jika tidak ada nilai bpjs, pastikan checkbox potongan_bpjs tidak dicentang dan biarkan nilainya kosong
                $('#potongan_bpjs-' + activeSpecificationIndex).val("");
            }

            // Hide the modal after updating the form fields
            $('#tableMemo').modal('hide');
        }
    </script>

    {{-- hasil --}}
    <script>
        $(document).on("input",
            ".gaji, .lembur, .storing, .kurangtigapuluh, .lebihtigapuluh, .pelunasan_kasbon, .lainya, .absen, .hari_kerja, .potongan_bpjs",
            function() {
                // Ambil baris saat ini
                var currentRow = $(this).closest('tr');

                // Ambil nilai dari input
                var gaji = parseFloat(currentRow.find(".gaji").val().replace(/[.]/g, '')) || 0;
                var hari_kerja = parseFloat(currentRow.find(".hari_kerja").val()) || 0;
                var lembur = parseFloat(currentRow.find(".lembur").val().replace(",", ".")) || 0;
                var storing = parseFloat(currentRow.find(".storing").val().replace(",", ".")) || 0;
                var kurangtigapuluh = parseFloat(currentRow.find(".kurangtigapuluh").val()) || 0;
                var lebihtigapuluh = parseFloat(currentRow.find(".lebihtigapuluh").val()) || 0;
                var pelunasan_kasbon = parseFloat(currentRow.find(".pelunasan_kasbon").val().replace(/[.]/g, '')) || 0;
                var lainya = parseFloat(currentRow.find(".lainya").val().replace(/[.]/g, '')) || 0;
                var absen = parseFloat(currentRow.find(".absen").val()) || 0;
                var potongan_bpjs = parseFloat(currentRow.find(".potongan_bpjs").val().replace(/[.]/g, '')) || 0;

                // Hitung uang makan dan uang hadir
                var uang_makan = hari_kerja * 10000;
                var uang_hadir = hari_kerja * 5000;

                // Hitung hasil lembur dan storing
                var hasil_lembur = lembur * 10000;

                // Hitung hasil terlambat
                var hasil_kurangtigapuluh = kurangtigapuluh * 5000;
                var hasil_lebihtigapuluh = lebihtigapuluh * 15000;

                // hitung absen 
                var hasil_absen = absen * 5000;

                var test = gaji;
                console.log(test);
                var gajiperjam = storing / 12;
                // Bulatkan gajiperjam menjadi 4 digit di belakang koma
                gajiperjam = gajiperjam.toFixed(4);
                var hasil_storing = gajiperjam * gaji;

                // Hitung gaji kotor dan gaji bersih
                var gaji_kotor = (gaji + 10000 + 5000) * hari_kerja + hasil_lembur + hasil_storing;
                var gaji_kotor_bulat = Math.round(gaji_kotor);

                var gaji_bersih = gaji_kotor - hasil_kurangtigapuluh - hasil_lebihtigapuluh - hasil_absen -
                    potongan_bpjs - lainya;
                var gaji_bersih_bulat = Math.round(gaji_bersih);
                var hasil_gajibersih = gaji_bersih - pelunasan_kasbon;
                var hasil_gajibersih_bulat = Math.round(hasil_gajibersih);

                // Masukkan hasil perhitungan ke dalam input yang sesuai
                currentRow.find(".uang_makan").val(uang_makan.toLocaleString('id-ID'));
                currentRow.find(".uang_hadir").val(uang_hadir.toLocaleString('id-ID'));
                currentRow.find(".hasil_lembur").val(hasil_lembur.toLocaleString('id-ID'));
                currentRow.find(".hasilkurang").val(hasil_kurangtigapuluh.toLocaleString('id-ID'));
                currentRow.find(".hasillebih").val(hasil_lebihtigapuluh.toLocaleString('id-ID'));
                currentRow.find(".hasil_absen").val(hasil_absen.toLocaleString('id-ID'));
                currentRow.find(".hasil_storing").val(hasil_storing.toLocaleString('id-ID'));
                currentRow.find(".gaji_kotor").val(gaji_kotor_bulat.toLocaleString('id-ID'));
                currentRow.find(".gajinol_pelunasan").val(gaji_bersih_bulat.toLocaleString('id-ID'));
                currentRow.find(".gaji_bersih").val(hasil_gajibersih_bulat.toLocaleString('id-ID'));
                updateGrandTotal();

            });
    </script>



    {{-- perhitungan --}}
    <script>
        function updateGrandTotal() {
            var totalGaji = 0;
            var totalPelunasan = 0;

            // Loop through all elements with name "gaji_bersih[]"
            $('input[name^="gajinol_pelunasan"]').each(function() {
                var nominalValue = parseFloat($(this).val().replace(/\./g, '')) || 0; // Remove dots
                totalGaji += nominalValue;
            });

            // Loop through all elements with name "pelunasan_kasbon[]"
            $('input[name^="pelunasan_kasbon"]').each(function() {
                var nominalValue = parseFloat($(this).val().replace(/\./g, '')) || 0; // Remove dots
                totalPelunasan += nominalValue;
            });

            var grandTotal = totalGaji - totalPelunasan;

            $('#total_gaji').val(formatRupiah(totalGaji));
            $('#total_pelunasan').val(formatRupiah(totalPelunasan));
            $('#grand_total').val(formatRupiah(grandTotal));
        }

        $('body').on('input', 'input[name^="gaji_bersih"], input[name^="pelunasan_kasbon"]', function() {
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

    <script>
        function formatRupiahform(input) {
            // Hapus karakter selain angka
            var value = input.value.replace(/\D/g, "");

            // Format angka dengan menambahkan titik sebagai pemisah ribuan
            value = new Intl.NumberFormat('id-ID').format(value);

            // Tampilkan nilai yang sudah diformat ke dalam input
            input.value = value;
        }
    </script>

    <script>
        $(document).ready(function() {
            // Detect the change event on the 'status' dropdown
            $('#statusx').on('change', function() {
                // Get the selected value
                var selectedValue = $(this).val();

                // Check the selected value and redirect accordingly
                switch (selectedValue) {
                    case 'memo_perjalanan':
                        window.location.href = "{{ url('admin/perhitungan_gaji') }}";
                        break;
                    case 'memo_borong':
                        window.location.href = "{{ url('admin/perhitungan_gajibulanan') }}";
                        break;
                    default:
                        // Handle other cases or do nothing
                        break;
                }
            });
        });
    </script>

    <script>
        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode;
            if (charCode == 46) {
                var currentValue = evt.target.value;
                // Pastikan hanya satu titik yang diterima
                if (currentValue.indexOf('.') !== -1) {
                    return false;
                }
            }
            return !(charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 46);
        }
    </script>


    <script>
        var startX;

        function startDrag(event) {
            startX = event.clientX;
            // Mencegah seleksi teks saat menyeret mouse
            event.preventDefault();
            document.addEventListener('mousemove', dragTable);
            document.addEventListener('mouseup', stopDrag);
        }

        function dragTable(event) {
            var table = document.querySelector('.table-responsive');
            // Mendapatkan perubahan posisi mouse
            var movementX = event.clientX - startX;
            // Geser tabel berdasarkan arah pergerakan mouse
            table.scrollLeft -= movementX;
            // Simpan posisi mouse untuk digunakan di event selanjutnya
            startX = event.clientX;
        }

        function stopDrag() {
            document.removeEventListener('mousemove', dragTable);
            document.removeEventListener('mouseup', stopDrag);
        }

        // Menambahkan event listener ke tabel untuk memulai drag
        var table = document.querySelector('.table-responsive');
        table.addEventListener('mousedown', function(event) {
            // Periksa apakah mouse ditekan pada elemen selain sel-sel input
            if (!event.target.tagName.toLowerCase().match(/input|textarea/)) {
                startDrag(event);
            }
        });
    </script>


@endsection
