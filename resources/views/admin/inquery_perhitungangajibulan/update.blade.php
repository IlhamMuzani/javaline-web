@extends('layouts.app')

@section('title', 'Inquery Perhitungan Gaji Karyawan')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Inquery Perhitungan Gaji Karyawan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/inquery_perhitungangaji') }}">Perhitungan Gaji
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
        <form action="{{ url('admin/inquery_perhitungangajibulanan/' . $inquery->id) }}" method="POST"
            enctype="multipart/form-data" autocomplete="off">
            @csrf
            @method('put')
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Perhitungan Gaji Karyawan Bulanan</h3>
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
                                    <th style="font-size:14px; text-align:center; width: 50px;" class="text-center">NO</th>
                                    <th style="font-size:14px; text-align:center; min-width: 150px;">NAMA</th>
                                    <th style="font-size:14px; text-align:center; min-width: 150px;">GAPOK</th>
                                    <th style="font-size:14px; text-align:center; min-width: 150px;">GAJI PERHARI</th>
                                    {{-- <th style="font-size:14px; text-align:center; min-width: 150px;">UM</th>
                                    <th style="font-size:14px; text-align:center; min-width: 150px;">UH</th> --}}
                                    <th style="font-size:14px; text-align:center; min-width: 150px;">HE</th>
                                    <th style="font-size:14px; text-align:center; min-width: 150px;">HK</th>
                                    <th style="font-size:14px; text-align:center; min-width: 150px;">HASIL HK</th>
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
                                @foreach ($details as $detail)
                                    <tr id="pembelian-{{ $loop->index }}">
                                        <td style="width: 70px; font-size:14px" class="text-center" id="urutan">
                                            {{ $loop->index + 1 }}
                                        </td>
                                        <td hidden>
                                            <div class="form-group" hidden>
                                                <input type="text" class="form-control"
                                                    id="nomor_seri-{{ $loop->index }}" name="detail_ids[]"
                                                    value="{{ $detail['id'] }}">
                                            </div>
                                        </td>
                                        <td hidden>
                                            <div class="form-group">
                                                <input type="text" class="form-control"
                                                    id="karyawan_id-{{ $loop->index }}" name="karyawan_id[]"
                                                    value="{{ $detail['karyawan_id'] }}">
                                            </div>
                                        </td>
                                        <td hidden>
                                            <div class="form-group">
                                                <input onclick="Karyawan({{ $loop->index }})" style="font-size:14px"
                                                    type="text" readonly class="form-control"
                                                    id="kode_karyawan-{{ $loop->index }}" name="kode_karyawan[]"
                                                    value="{{ $detail['kode_karyawan'] }}">
                                            </div>
                                        </td>
                                        <td style="width: 150px;">
                                            <div class="form-group">
                                                <input onclick="Karyawan({{ $loop->index }})" style="font-size:14px"
                                                    type="text" readonly class="form-control"
                                                    id="nama_lengkap-{{ $loop->index }}" name="nama_lengkap[]"
                                                    value="{{ $detail['nama_lengkap'] }}">
                                            </div>
                                        </td>
                                        <td style="width: 150px;">
                                            <div class="form-group">
                                                <input type="text" onclick="Karyawan({{ $loop->index }})"
                                                    style="font-size:14px" readonly class="form-control gaji"
                                                    id="gaji-{{ $loop->index }}" name="gaji[]" data-row-id="0"
                                                    value="{{ number_format($detail['gaji'], 0, ',', '.') }}">
                                            </div>
                                        </td>
                                        <td style="width: 150px;">
                                            <div class="form-group">
                                                <input type="text" style="font-size:14px" readonly
                                                    class="form-control gaji_perhari"
                                                    id="gaji_perhari-{{ $loop->index }}" name="gaji_perhari[]"
                                                    value="{{ number_format($detail['gaji_perhari'], 0, ',', '.') }}">
                                            </div>
                                        </td>
                                        <td style="width: 150px;">
                                            <div class="form-group">
                                                <input style="font-size:14px" type="text"
                                                    class="form-control hari_efektif"
                                                    id="hari_efektif-{{ $loop->index }}" name="hari_efektif[]"
                                                    data-row-id="0" value="{{ $detail['hari_efektif'] }}"
                                                    onkeypress="return isNumberKey(event)">
                                            </div>
                                        </td>
                                        <td style="width: 150px;">
                                            <div class="form-group">
                                                <input style="font-size:14px" type="text"
                                                    class="form-control hari_kerja" id="hari_kerja-{{ $loop->index }}"
                                                    name="hari_kerja[]" data-row-id="0"
                                                    value="{{ $detail['hari_kerja'] }}"
                                                    onkeypress="return isNumberKey(event)">
                                            </div>
                                        </td>
                                        <td style="width: 150px;">
                                            <div class="form-group">
                                                <input type="text" style="font-size:14px" readonly
                                                    class="form-control hasil_hk" id="hasil_hk-{{ $loop->index }}"
                                                    name="hasil_hk[]" data-row-id="0"
                                                    value="{{ number_format($detail['hasil_hk'], 0, ',', '.') }}">
                                            </div>
                                        </td style="width: 150px;">
                                        <td>
                                            <div class="form-group">
                                                <input style="font-size:14px" type="text" class="form-control lembur"
                                                    id="lembur-{{ $loop->index }}" name="lembur[]" data-row-id="0"
                                                    value="{{ $detail['lembur'] }}"
                                                    onkeypress="return isNumberKey(event)">
                                            </div>
                                        </td>
                                        <td style="width: 150px;">
                                            <div class="form-group">
                                                <input style="font-size:14px" readonly type="text"
                                                    class="form-control hasil_lembur"
                                                    id="hasil_lembur-{{ $loop->index }}" name="hasil_lembur[]"
                                                    data-row-id="0"
                                                    value="{{ number_format($detail['hasil_lembur'], 0, ',', '.') }}">
                                            </div>
                                        </td>
                                        <td style="width: 150px;">
                                            <div class="form-group">
                                                <input style="font-size:14px" type="text" class="form-control storing"
                                                    id="storing-{{ $loop->index }}" name="storing[]" data-row-id="0"
                                                    value="{{ $detail['storing'] }}"
                                                    onkeypress="return isNumberKey(event)">
                                            </div>
                                        </td>
                                        <td style="width: 150px;">
                                            <div class="form-group">
                                                <input style="font-size:14px" readonly type="text"
                                                    class="form-control hasil_storing"
                                                    id="hasil_storing-{{ $loop->index }}" name="hasil_storing[]"
                                                    data-row-id="0"
                                                    value="{{ number_format($detail['hasil_storing'], 0, ',', '.') }}">
                                            </div>
                                        </td>
                                        <td style="width: 150px;">
                                            <div class="form-group">
                                                <input style="font-size:14px" readonly type="text"
                                                    class="form-control gaji_kotor" id="gaji_kotor-{{ $loop->index }}"
                                                    name="gaji_kotor[]"
                                                    value="{{ number_format($detail['gaji_kotor'], 0, ',', '.') }}">
                                            </div>
                                        </td>
                                        <td style="width: 300px;">
                                            <div style="display: flex; justify-content: space-between;">
                                                <div style="width: 45%;">
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="number"
                                                            class="form-control kurangtigapuluh"
                                                            id="kurangtigapuluh-{{ $loop->index }}"
                                                            name="kurangtigapuluh[]"
                                                            value="{{ $detail['kurangtigapuluh'] }}">
                                                    </div>
                                                </div>
                                                <div style="width: 45%;">
                                                    <div class="form-group">
                                                        <input style="font-size:14px" type="number"
                                                            class="form-control lebihtigapuluh"
                                                            id="lebihtigapuluh-{{ $loop->index }}"
                                                            name="lebihtigapuluh[]"value="{{ $detail['lebihtigapuluh'] }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="width: 300px;">
                                            <div style="display: flex; justify-content: space-between;">
                                                <div style="width: 45%;">
                                                    <div class="form-group">
                                                        <input readonly style="font-size:14px" type="text"
                                                            class="form-control hasilkurang"
                                                            id="hasilkurang-{{ $loop->index }}" name="hasilkurang[]"
                                                            value="{{ number_format($detail['hasilkurang'], 0, ',', '.') }}">
                                                    </div>
                                                </div>
                                                <div style="width: 45%;">
                                                    <div class="form-group">
                                                        <input readonly style="font-size:14px" type="text"
                                                            class="form-control hasillebih"
                                                            id="hasillebih-{{ $loop->index }}" name="hasillebih[]"
                                                            value="{{ number_format($detail['hasillebih'], 0, ',', '.') }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="width: 150px;">
                                            <div class="form-group">
                                                <input style="font-size:14px" type="number" class="form-control absen"
                                                    id="absen-{{ $loop->index }}" name="absen[]"
                                                    value="{{ $detail['absen'] }}" oninput="formatRupiahform(this)"
                                                    onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                            </div>
                                        </td>
                                        <td style="width: 150px;">
                                            <div class="form-group">
                                                <input style="font-size:14px" readonly type="text"
                                                    class="form-control hasil_absen"
                                                    value="{{ number_format($detail['hasil_absen'], 0, ',', '.') }}"
                                                    id="hasil_absen-{{ $loop->index }}" name="hasil_absen[]"
                                                    data-row-id="0">
                                            </div>
                                        </td>
                                        <td style="width: 150px;">
                                            <div class="form-group">
                                                <input type="text" style="font-size:14px"
                                                    class="form-control potongan_bpjs" readonly
                                                    id="potongan_bpjs-{{ $loop->index }}" name="potongan_bpjs[]"
                                                    value="{{ number_format($detail['potongan_bpjs'], 0, ',', '.') }}"
                                                    data-row-id="0">
                                            </div>
                                        </td>
                                        <td style="width: 150px;">
                                            <div class="form-group">
                                                <input style="font-size:14px" type="text" class="form-control lainya"
                                                    id="lainya-{{ $loop->index }}" name="lainya[]"
                                                    value="{{ number_format($detail['lainya'], 0, ',', '.') }}"
                                                    oninput="formatRupiahform(this)"
                                                    onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                            </div>
                                        </td>
                                        <td style="width: 150px;">
                                            <div class="form-group">
                                                <input style="font-size:14px" type="text"
                                                    class="form-control pelunasan_kasbon"
                                                    id="pelunasan_kasbon-{{ $loop->index }}" name="pelunasan_kasbon[]"
                                                    value="{{ number_format($detail['pelunasan_kasbon'], 0, ',', '.') }}"
                                                    oninput="formatRupiahform(this)"
                                                    onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                            </div>
                                        </td>
                                        <td hidden style="width: 150px;">
                                            <div class="form-group">
                                                <input style="font-size:14px" readonly type="text"
                                                    class="form-control gajinol_pelunasan"
                                                    value="{{ number_format($detail['gajinol_pelunasan'], 0, ',', '.') }}"
                                                    id="gajinol_pelunasan-{{ $loop->index }}"
                                                    name="gajinol_pelunasan[]">
                                            </div>
                                        </td>
                                        <td style="width: 150px;">
                                            <div class="form-group">
                                                <input style="font-size:14px" readonly type="text"
                                                    class="form-control gaji_bersih" id="gaji_bersih-{{ $loop->index }}"
                                                    name="gaji_bersih[]"
                                                    value="{{ number_format($detail['gaji_bersih'], 0, ',', '.') }}">
                                            </div>
                                        </td>
                                        <td style="width: 100px">
                                            <button type="button" class="btn btn-primary btn-sm"
                                                onclick="Karyawan({{ $loop->index }})">
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
                    </div>
                    <div class="float-left mt-3">
                        <button type="button" class="btn btn-primary btn-sm" onclick="addPesanan()">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>

                <div style="margin-right: 20px; margin-left:20px" class="form-group">
                    <label for="alamat">Keterangan</label>
                    <textarea type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Masukan keterangan"
                        value="">{{ old('keterangan', $inquery->keterangan) }}</textarea>
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
                                        <th>Cicilan</th>
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
                                            data-pelunasan_kasbon="@php $detail_cicilan_posting_belum_lunas = $karyawan->detail_cicilan
                                            ->where('status', 'posting')
                                            ->where('status_cicilan', 'belum lunas')
                                            ->first();
                                            if ($detail_cicilan_posting_belum_lunas) {
                                                echo $detail_cicilan_posting_belum_lunas->nominal_cicilan;
                                            } else {
                                                echo 0;
                                            } @endphp"
                                            data-param="{{ $loop->index }}">
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $karyawan->kode_karyawan }}</td>
                                            <td>{{ $karyawan->nama_lengkap }}</td>
                                            <td>{{ number_format($karyawan->gaji, 0, ',', '.') }}</td>
                                            <td>
                                                @php
                                                    $detail_cicilan_posting_belum_lunas = $karyawan->detail_cicilan
                                                        ->where('status', 'posting')
                                                        ->where('status_cicilan', 'belum lunas')
                                                        ->first();
                                                @endphp

                                                @if ($detail_cicilan_posting_belum_lunas)
                                                    {{ number_format($detail_cicilan_posting_belum_lunas->nominal_cicilan, 0, ',', '.') }}
                                                @else
                                                    0
                                                @endif
                                            </td>
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
            updateUrutans();
        }

        function updateUrutans() {
            var urutan = document.querySelectorAll('#urutan');
            for (let i = 0; i < urutan.length; i++) {
                urutan[i].innerText = i + 1;
            }
        }


        function removeBan(identifier, detailId) {
            var row = document.getElementById('pembelian-' + identifier);
            row.remove();

            $.ajax({
                url: "{{ url('admin/inquery_perhitungangajibulanan/deletedetailperhitungan/') }}/" + detailId,
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

            updateUrutans();
            updateGrandTotal();
        }
        updateGrandTotal();

        function itemPembelian(urutan, key, value = null) {
            var karyawan_id = '';
            var kode_karyawan = '';
            var nama_lengkap = '';
            var gaji = '';
            var gaji_perhari = '';
            var hari_efektif = '';
            var hari_kerja = '';
            var hasil_hk = '';
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
                gaji_perhari = value.gaji_perhari;
                hari_efektif = value.hari_efektif;
                hari_kerja = value.hari_kerja;
                hasil_hk = value.hasil_hk;
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
            var item_pembelian = '<tr id="pembelian-' + key + '">';
            item_pembelian += '<td  style="width: 70px; font-size:14px" class="text-center" id="urutan">' + key +
                '</td>';

            // karyawan_id 
            item_pembelian += '<td hidden>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" id="karyawan_id-' + key +
                '" name="karyawan_id[]" value="' + karyawan_id + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // kode_karyawan 
            item_pembelian += '<td hidden onclick="Karyawan(' + key +
                ')">';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" readonly style="font-size:14px" id="kode_karyawan-' +
                key +
                '" name="kode_karyawan[]" value="' + kode_karyawan + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // nama_lengkap 
            item_pembelian += '<td onclick="Karyawan(' + key +
                ')">';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" readonly style="font-size:14px" id="nama_lengkap-' +
                key +
                '" name="nama_lengkap[]" value="' + nama_lengkap + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // gaji 
            item_pembelian += '<td onclick="Karyawan(' + key +
                ')">';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control gaji" style="font-size:14px" readonly id="gaji-' +
                key +
                '" name="gaji[]" value="' + gaji + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // gaji_perhari 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control gaji_perhari" style="font-size:14px" readonly id="gaji_perhari-' +
                key +
                '" name="gaji_perhari[]" value="' + gaji_perhari + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // hari_efektif
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control hari_efektif" onkeypress="return isNumberKey(event)" style="font-size:14px" id="hari_efektif-' +
                key +
                '" name="hari_efektif[]" value="' + hari_efektif + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // hari_kerja 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control hari_kerja" onkeypress="return isNumberKey(event)" style="font-size:14px" id="hari_kerja-' +
                key +
                '" name="hari_kerja[]" value="' + hari_kerja + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // hasil_hk 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control hasil_hk" readonly style="font-size:14px" id="hasil_hk-' +
                key +
                '" name="hasil_hk[]" value="' + hasil_hk + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // lembur 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control lembur" onkeypress="return isNumberKey(event)" style="font-size:14px" id="lembur-' +
                key +
                '" name="lembur[]" value="' + lembur + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // hasil_lembur 
            item_pembelian += '<td >';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control hasil_lembur" style="font-size:14px" readonly id="hasil_lembur-' +
                key +
                '" name="hasil_lembur[]" value="' + hasil_lembur + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // storing 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control storing" onkeypress="return isNumberKey(event)" style="font-size:14px" id="storing-' +
                key +
                '" name="storing[]" value="' + storing + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // hasil_storing 
            item_pembelian += '<td >';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control hasil_storing" style="font-size:14px" readonly id="hasil_storing-' +
                key +
                '" name="hasil_storing[]" value="' + hasil_storing + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // gaji_kotor 
            item_pembelian += '<td >';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control gaji_kotor" style="font-size:14px" readonly id="gaji_kotor-' +
                key +
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
                key + '" name="kurangtigapuluh[]" value="' + kurangtigapuluh + '">';
            item_pembelian += '</div>';
            item_pembelian += '</div>';
            item_pembelian += '<div style="width: 45%;">';
            item_pembelian += '<div class="form-group">';
            item_pembelian +=
                '<input type="number" class="form-control lebihtigapuluh" style="font-size:14px" id="lebihtigapuluh-' +
                key + '" name="lebihtigapuluh[]" value="' + lebihtigapuluh + '">';
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
                key +
                '" name="hasilkurang[]" value="' + hasilkurang + '">';
            item_pembelian += '</div>';
            item_pembelian += '</div>';
            item_pembelian += '<div style="width: 45%;">';
            item_pembelian += '<div class="form-group">';
            item_pembelian +=
                '<input type="text" class="form-control hasillebih" readonly style="font-size:14px" id="hasillebih-' +
                key +
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
                key +
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
                key +
                '" name="hasil_absen[]" value="' + hasil_absen + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // bpjs 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control potongan_bpjs" style="font-size:14px" readonly id="potongan_bpjs-' +
                key +
                '" name="potongan_bpjs[]" value="' + potongan_bpjs + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // lainya 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">';
            item_pembelian +=
                '<input type="text" class="form-control lainya" style="font-size:14px" id="lainya-' +
                key +
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
                key +
                '" name="pelunasan_kasbon[]" value="' + pelunasan_kasbon + '" ';
            item_pembelian += 'oninput="formatRupiahform(this)" ';
            item_pembelian += 'onkeypress="return event.charCode >= 48 && event.charCode <= 57">';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // gajinol_pelunasan 
            item_pembelian += '<td hidden >';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control gajinol_pelunasan" style="font-size:14px" readonly id="gajinol_pelunasan-' +
                key +
                '" name="gajinol_pelunasan[]" value="' + gajinol_pelunasan + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // gaji_bersih 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian +=
                '<input type="text" class="form-control gaji_bersih" style="font-size:14px" readonly id="gaji_bersih-' +
                key +
                '" name="gaji_bersih[]" value="' + gaji_bersih + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            item_pembelian += '<td style="width: 100px">';
            item_pembelian += '<button type="button" class="btn btn-primary btn-sm" onclick="Karyawan(' + key +
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
            var pelunasan_kasbon = parseFloat(selectedRow.data('pelunasan_kasbon')).toLocaleString('id-ID');
            var gaji = parseFloat(selectedRow.data('gaji')).toLocaleString('id-ID');

            // Update the form fields for the active specification
            $('#karyawan_id-' + activeSpecificationIndex).val(karyawan_id);
            $('#kode_karyawan-' + activeSpecificationIndex).val(kode_karyawan);
            $('#nama_lengkap-' + activeSpecificationIndex).val(nama_lengkap);
            $('#potongan_bpjs-' + activeSpecificationIndex).val(bpjs);
            $('#pelunasan_kasbon-' + activeSpecificationIndex).val(pelunasan_kasbon);
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
            ".gaji, .lembur, .storing, .kurangtigapuluh, .lebihtigapuluh, .pelunasan_kasbon, .lainya, .absen, .hari_kerja, .hasil_hk, .hari_efektif, .gaji_perhari, .potongan_bpjs",
            function() {
                // Ambil baris saat ini
                var currentRow = $(this).closest('tr');

                // Ambil nilai dari input
                var gaji = parseFloat(currentRow.find(".gaji").val().replace(/[.]/g, '')) || 0;
                var hari_efektif = parseFloat(currentRow.find(".hari_efektif").val()) || 0;
                var hari_kerja = parseFloat(currentRow.find(".hari_kerja").val()) || 0;
                var lembur = parseFloat(currentRow.find(".lembur").val().replace(",", ".")) || 0;
                var storing = parseFloat(currentRow.find(".storing").val().replace(",", ".")) || 0;
                var kurangtigapuluh = parseFloat(currentRow.find(".kurangtigapuluh").val()) || 0;
                var lebihtigapuluh = parseFloat(currentRow.find(".lebihtigapuluh").val()) || 0;
                var gaji_perhari = parseFloat(currentRow.find(".gaji_perhari").val()) || 0;
                var hasil_hk = parseFloat(currentRow.find(".hasil_hk").val()) || 0;
                var pelunasan_kasbon = parseFloat(currentRow.find(".pelunasan_kasbon").val().replace(/[.]/g, '')) || 0;
                var lainya = parseFloat(currentRow.find(".lainya").val().replace(/[.]/g, '')) || 0;
                var absen = parseFloat(currentRow.find(".absen").val()) || 0;
                var potongan_bpjs = parseFloat(currentRow.find(".potongan_bpjs").val().replace(/[.]/g, '')) || 0;


                // Gaji satu Hari
                var gaji_perhari = gaji / hari_efektif;
                var hasil_harikerja = gaji_perhari * hari_kerja
                // // Hitung uang makan dan uang hadir

                // Hitung hasil lembur dan storing
                var hasil_lembur = lembur * 10000;

                // Hitung hasil terlambat
                var hasil_kurangtigapuluh = kurangtigapuluh * 5000;
                var hasil_lebihtigapuluh = lebihtigapuluh * 15000;

                // hitung absen 
                var hasil_absen = absen * 5000;

                var test = gaji;
                console.log(test);
                console.log(test);
                var gajiperjam = storing / 12;
                // Bulatkan gajiperjam menjadi 4 digit di belakang koma
                gajiperjam = gajiperjam.toFixed(4);
                var hasil_storing = gajiperjam * gaji_perhari;

                // Hitung gaji kotor dan gaji bersih
                var gaji_kotor = hasil_harikerja + hasil_lembur + hasil_storing;
                // var gaji_bersih = gaji_kotor - kurangtigapuluh - pelunasan_kasbon - absen;
                var gaji_kotor_bulat = Math.round(gaji_kotor);

                var gaji_bersih = gaji_kotor - hasil_kurangtigapuluh - hasil_lebihtigapuluh - hasil_absen -
                    potongan_bpjs - lainya;
                var gaji_bersih_bulat = Math.round(gaji_bersih);

                var hasil_gajibersih = gaji_bersih - pelunasan_kasbon;
                var hasil_gajibersih_bulat = Math.round(hasil_gajibersih);

                // Masukkan hasil perhitungan ke dalam input yang sesuai
                currentRow.find(".hasil_hk").val(hasil_harikerja.toLocaleString('id-ID'));
                currentRow.find(".hasil_lembur").val(hasil_lembur.toLocaleString('id-ID'));
                currentRow.find(".hasilkurang").val(hasil_kurangtigapuluh.toLocaleString('id-ID'));
                currentRow.find(".hasillebih").val(hasil_lebihtigapuluh.toLocaleString('id-ID'));
                currentRow.find(".hasil_absen").val(hasil_absen.toLocaleString('id-ID'));
                currentRow.find(".hasil_storing").val(hasil_storing.toLocaleString('id-ID'));
                currentRow.find(".gaji_perhari").val(gaji_perhari.toLocaleString('id-ID'));
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
