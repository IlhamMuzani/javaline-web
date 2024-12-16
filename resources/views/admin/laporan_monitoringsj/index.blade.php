@extends('layouts.app')

@section('title', 'Laporan Monitoring SJ')

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
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content" style="display: none;" id="mainContentSection">
        <div class="container-fluid">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-check"></i> Berhasil!
                    </h5>
                    {{ session('success') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Laporan Monitoring Surat Jalan</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="GET" id="form-action">
                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <label for="tanggal_awal">Kategori</label>
                                <select class="custom-select form-control" id="statusx" name="statusx">
                                    <option value="">- Pilih Laporan -</option>
                                    <option value="detail"selected>Detail</option>
                                    <option value="global">Global</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="status">Cari Pengurus</label>
                                <select class="select2bs4 select2-hidden-accessible" name="karyawan_id"
                                    data-placeholder="Cari Pengurus.." style="width: 100%;" id="karyawan_id">
                                    <option value="">- Pilih -</option>
                                    @foreach ($pengurus as $karyawan)
                                        <option value="{{ $karyawan->id }}"
                                            {{ Request::get('karyawan_id') == $karyawan->id ? 'selected' : '' }}>
                                            {{ $karyawan->nama_lengkap }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="created_at">Status</label>
                                <select class="custom-select form-control" id="kategori" name="kategori">
                                    <option value="">- Semua Status -</option>
                                    <option value="belum_selesai"
                                        {{ Request::get('kategori') == 'belum_selesai' ? 'selected' : '' }}>
                                        Belum Selesai
                                    </option>
                                    <option value="selesai" {{ Request::get('kategori') == 'selesai' ? 'selected' : '' }}>
                                        Selesai</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="tanggal_awal">Tanggal Awal</label>
                                <input class="form-control" id="tanggal_awal" name="tanggal_awal" type="date"
                                    value="{{ Request::get('tanggal_awal') }}" max="{{ date('Y-m-d') }}" />
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="tanggal_akhir">Tanggal Akhir</label>
                                <input class="form-control" id="tanggal_akhir" name="tanggal_akhir" type="date"
                                    value="{{ Request::get('tanggal_akhir') }}" max="{{ date('Y-m-d') }}" />
                            </div>
                            <div class="col-md-2 mb-3">
                                @if (auth()->check() && auth()->user()->fitur['laporan pemasangan part cari'])
                                    <button type="button" class="btn btn-outline-primary btn-block" onclick="cari()">
                                        <i class="fas fa-search"></i> Cari
                                    </button>
                                @endif
                                @if (auth()->check() && auth()->user()->fitur['laporan pemasangan part cetak'])
                                    <button type="button" class="btn btn-primary btn-block" onclick="printReport()"
                                        target="_blank">
                                        <i class="fas fa-print"></i> Cetak
                                    </button>
                                @endif
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive" style="overflow-x: auto;">
                        <table id="datatables66" class="table table-bordered table-striped table-hover"
                            style="font-size: 10px">
                            <thead class="thead-dark">
                                <tr>
                                    {{-- <th><input type="checkbox" name="" id="select_all_ids"></th> --}}
                                    <th>NO</th>
                                    <th>KODE SPK</th>
                                    <th>PELANGGAN</th>
                                    <th>TUJUAN</th>
                                    <th>TANGGAL</th>
                                    <th>NO KABIN</th>
                                    <th>NAMA DRIVER</th>
                                    <th>TIMER</th>
                                    <th>TIMER TOTAL</th>
                                    <th>PENERIMA</th>
                                </tr>
                            </thead>
                            @php
                                $total = 0;
                            @endphp
                            <tbody>
                                @foreach ($inquery as $pengambilan_do)
                                    {{-- @if ($pengambilan_do->waktu_suratakhir == null) --}}
                                    <tr class="dropdown"{{ $pengambilan_do->id }}>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $pengambilan_do->spk->kode_spk ?? '-' }}</td>
                                        <td>{{ $pengambilan_do->spk->nama_pelanggan ?? '-' }}</td>
                                        <td>{{ $pengambilan_do->spk->nama_rute ?? '-' }}</td>
                                        <td>{{ $pengambilan_do->tanggal_awal }}</td>
                                        <td>{{ $pengambilan_do->spk->kendaraan->no_kabin ?? '-' }}</td>
                                        <td>{{ $pengambilan_do->spk->nama_driver ?? '-' }}</td>
                                        <td>
                                            @if ($pengambilan_do->status_penerimaansj == 'posting')
                                                @php
                                                    $timerAwal =
                                                        $pengambilan_do->timer_suratjalan->last()->timer_awal ?? null;

                                                    // Memeriksa apakah timer_awal ada
                                                    if ($timerAwal) {
                                                        $waktuAwal = \Carbon\Carbon::parse($timerAwal);
                                                        $waktuSekarang = \Carbon\Carbon::now();
                                                        $durasi = $waktuAwal->diff($waktuSekarang);

                                                        // Menampilkan hasil perhitungan durasi
                                                        echo "{$durasi->days} hari, {$durasi->h} jam";
                                                    } else {
                                                        echo '-';
                                                    }
                                                @endphp
                                            @endif
                                        </td>


                                        <td>
                                            @php
                                                $timerAwal = $pengambilan_do->waktu_suratawal ?? null;
                                                $timerAkhir = $pengambilan_do->waktu_suratakhir ?? null;

                                                // Memeriksa apakah timer_awal ada dan waktu_suratakhir tidak null
                                                if ($timerAwal && $timerAkhir) {
                                                    $waktuAwal = \Carbon\Carbon::parse($timerAwal);
                                                    $waktuAkhir = \Carbon\Carbon::parse($timerAkhir);
                                                    $durasi = $waktuAwal->diff($waktuAkhir);

                                                    // Menampilkan hasil perhitungan durasi
                                                    echo "{$durasi->days} hari, {$durasi->h} jam";
                                                } else {
                                                    // Jika waktu_suratakhir null, tampilkan '-'
                                                    echo '-';
                                                }
                                            @endphp
                                        </td>


                                        <td>{{ $pengambilan_do->penerima_sj ?? '-' }}</td>
                                    </tr>
                                    {{-- @endif --}}

                                    @php
                                        $total++;
                                    @endphp
                                @endforeach
                            </tbody>

                            <tbody>

                                @foreach ($inquery as $driver)
                                    <tr>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="1"></td>
                                    <td>
                                    </td>
                                    <td>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><strong>Total:</strong></td>
                                    <td class="text-left" style="font-weight: bold;">{{ $total }}</td>
                                    {{-- <td>
                                </td> --}}
                                </tr>
                            </tbody>

                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </section>
    <!-- /.card -->
    <script>
        var tanggalAwal = document.getElementById('tanggal_awal');
        var tanggalAkhir = document.getElementById('tanggal_akhir');
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
        var form = document.getElementById('form-action')

        function cari() {
            form.action = "{{ url('admin/laporan-monitoringsj') }}";
            form.submit();
        }

        function printReport() {
            var startDate = tanggalAwal.value;
            var endDate = tanggalAkhir.value;

            if (startDate && endDate) {
                form.action = "{{ url('admin/print-monitoringsj') }}" + "?start_date=" + startDate + "&end_date=" +
                    endDate;
                form.submit();
            } else {
                alert("Silakan isi kedua tanggal sebelum mencetak.");
            }
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
                    case 'detail':
                        window.location.href = "{{ url('admin/laporan-monitoringsj') }}";
                        break;
                    case 'global':
                        window.location.href = "{{ url('admin/laporan-monitoringsjglobal') }}";
                        break;
                    default:
                        // Handle other cases or do nothing
                        break;
                }
            });
        });
    </script>
@endsection
