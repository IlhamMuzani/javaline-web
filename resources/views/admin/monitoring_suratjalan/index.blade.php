@extends('layouts.app')

@section('title', 'Monitoring Surat Jalan')

@section('content')
    <!-- Content Header (Page header) -->
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
                    <h1 class="m-0">Monitoring Surat Jalan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Monitoring Surat Jalan</li>
                    </ol>
                </div><!-- /.col -->
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
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-ban"></i> Error!
                    </h5>
                    {{ session('error') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Monitoring Surat Jalan</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="GET" id="form-action">
                        <div class="form-row">
                            <div class="col-md-2 col-sm-12">
                                <div class="form-group">
                                    <select class="custom-select form-control" id="divisi" name="divisi">
                                        <option value="">- Cari Divisi -</option>
                                        <option value="All" {{ Request::get('divisi') == 'All' ? 'selected' : '' }}>
                                            -Semua Divisi-
                                        </option>
                                        <option value="K1" {{ Request::get('divisi') == 'K1' ? 'selected' : '' }}>
                                            K1
                                        </option>
                                        <option value="K2" {{ Request::get('divisi') == 'K2' ? 'selected' : '' }}>
                                            K2
                                        </option>
                                        <option value="K3" {{ Request::get('divisi') == 'K3' ? 'selected' : '' }}>
                                            K3
                                        </option>
                                        <option value="K4" {{ Request::get('divisi') == 'K4' ? 'selected' : '' }}>
                                            K4
                                        </option>
                                        <option value="K5" {{ Request::get('divisi') == 'K5' ? 'selected' : '' }}>
                                            K5
                                        </option>
                                        <option value="K6" {{ Request::get('divisi') == 'K6' ? 'selected' : '' }}>
                                            K6
                                        </option>
                                        <option value="K7" {{ Request::get('divisi') == 'K7' ? 'selected' : '' }}>
                                            K7
                                        </option>

                                    </select>
                                    <label for="status">(Cari Divisi)</label>
                                </div>
                                {{-- </div> --}}
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-primary btn-block" onclick="cari()">
                                        <i class="fas fa-search"></i> Cari
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <table id="datatables66" class="table table-bordered table-striped table-hover" style="font-size: 11px">
                        <thead class="thead-dark">
                            <tr>
                                {{-- <th><input type="checkbox" name="" id="select_all_ids"></th> --}}
                                <th>NO</th>
                                <th>KODE SPK</th>
                                <th>PELANGGAN</th>
                                <th>TUJUAN</th>
                                <th>TANGGAL</th>
                                <th>No Kabin</th>
                                <th>Nama Driver</th>
                                <th>Posisi</th>
                                <th>TIMER</th>
                                <th>TIMER TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($spks as $pengambilan_do)
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
                                            @if ($pengambilan_do->timer_suratjalan->isNotEmpty())
                                                {{ $pengambilan_do->timer_suratjalan->last()->user->karyawan->nama_lengkap ?? null }}
                                            @else
                                                {{ $pengambilan_do->penerima_sj ?? '-' }}
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </td>
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
                                        @if ($pengambilan_do->status_penerimaansj == 'posting' && $pengambilan_do->durasi_penerimaan_hari !== null)
                                            {{ $pengambilan_do->durasi_penerimaan_hari }} hari,
                                            {{ $pengambilan_do->durasi_penerimaan_jam }} jam,
                                            {{ $pengambilan_do->durasi_penerimaan_menit }} menit,
                                            {{ $pengambilan_do->durasi_penerimaan_detik }} detik
                                        @elseif ($pengambilan_do->durasi_hari !== '-' && $pengambilan_do->durasi_jam !== '-')
                                            {{ $pengambilan_do->durasi_hari }} hari, {{ $pengambilan_do->durasi_jam }} jam
                                        @else
                                            Durasi tidak tersedia
                                        @endif
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                    <div class="modal fade" id="modal-loading" tabindex="-1" role="dialog"
                        aria-labelledby="modal-loading-label" aria-hidden="true" data-backdrop="static">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-body text-center">
                                    <i class="fas fa-spinner fa-spin fa-3x text-primary"></i>
                                    <h4 class="mt-2">Sedang Menyimpan...</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </section>

    <!-- /.card -->
    <script>
        var form = document.getElementById('form-action');

        function cari() {
            form.action = "{{ url('admin/monitoring_suratjalan') }}";
            form.submit();
        }
    </script>

    {{-- <script>
        $(document).ready(function() {
            $('tbody tr.dropdown').click(function(e) {
                // Memeriksa apakah yang diklik adalah checkbox
                if ($(e.target).is('input[type="checkbox"]')) {
                    return; // Jika ya, hentikan eksekusi
                }

                // Menghapus kelas 'selected' dan mengembalikan warna latar belakang ke warna default dari semua baris
                $('tr.dropdown').removeClass('selected').css('background-color', '');

                // Menambahkan kelas 'selected' ke baris yang dipilih dan mengubah warna latar belakangnya
                $(this).addClass('selected').css('background-color', '#b0b0b0');

                // Menyembunyikan dropdown pada baris lain yang tidak dipilih
                $('tbody tr.dropdown').not(this).find('.dropdown-menu').hide();

                // Mencegah event klik menyebar ke atas (misalnya, saat mengklik dropdown)
                e.stopPropagation();
            });

            $('tbody tr.dropdown').contextmenu(function(e) {
                // Memeriksa apakah baris ini memiliki kelas 'selected'
                if ($(this).hasClass('selected')) {
                    // Menampilkan dropdown saat klik kanan
                    var dropdownMenu = $(this).find('.dropdown-menu');
                    dropdownMenu.show();

                    // Mendapatkan posisi td yang diklik
                    var clickedTd = $(e.target).closest('td');
                    var tdPosition = clickedTd.position();

                    // Menyusun posisi dropdown relatif terhadap td yang di klik
                    dropdownMenu.css({
                        'position': 'absolute',
                        'top': tdPosition.top + clickedTd
                            .height(), // Menempatkan dropdown sedikit di bawah td yang di klik
                        'left': tdPosition
                            .left // Menempatkan dropdown di sebelah kiri td yang di klik
                    });

                    // Mencegah event klik kanan menyebar ke atas (misalnya, saat mengklik dropdown)
                    e.stopPropagation();
                    e.preventDefault(); // Mencegah munculnya konteks menu bawaan browser
                }
            });

            // Menyembunyikan dropdown saat klik di tempat lain
            $(document).click(function() {
                $('.dropdown-menu').hide();
                $('tr.dropdown').removeClass('selected').css('background-color',
                    ''); // Menghapus warna latar belakang dari semua baris saat menutup dropdown
            });
        });
    </script> --}}

    <script>
        $(document).ready(function() {
            $('#datatables99').DataTable({
                "lengthMenu": [
                    [-1],
                    ["All"]
                ],
                "columnDefs": [{
                        "orderable": false,
                        "targets": 0
                    } // Kolom nomor urut tidak dapat diurutkan
                ],
                "order": [
                    [1, 'asc']
                ], // Urutan default mulai dari kolom ke-2
                "drawCallback": function(settings) {
                    var api = this.api();
                    api.column(0, {
                        search: 'applied',
                        order: 'applied'
                    }).nodes().each(function(cell, i) {
                        cell.innerHTML = i +
                            1; // Mengisi ulang nomor urut berdasarkan urutan yang ditampilkan
                    });
                }
            });
        });
    </script>
@endsection
