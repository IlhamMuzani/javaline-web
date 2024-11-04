@extends('layouts.app')

@section('title', 'Monitoring Surat Jalan')

@section('content')
    <!-- Content Header (Page header) -->
    <div id="loadingSpinner" style="display: flex; align-items: center; justify-content: center; height: 100vh;">
        <div class="spinner"></div>
    </div>
    <style>
        /* Gaya untuk membuat loading spinner menjadi lingkaran berwarna biru */
        .spinner {
            width: 50px;
            /* Diameter lingkaran */
            height: 50px;
            /* Diameter lingkaran */
            border: 5px solid #9cb4d0;
            /* Warna biru untuk tepi */
            border-top: 5px solid transparent;
            /* Transparan pada bagian atas untuk efek putaran */
            border-radius: 50%;
            /* Membuatnya menjadi lingkaran */
            animation: spin 1s linear infinite;
            /* Animasi berputar */
        }

        /* Definisi animasi berputar */
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* @keyframes spin {
                                    0% {
                                        transform: rotate(0deg);
                                    }

                                    100% {
                                        transform: rotate(360deg);
                                    }
                                } */

        /* Gaya untuk header tabel */
        .thead-custom {
            color: white;
            /* Warna teks putih */
        }

        .thead-custom th {
            background: linear-gradient(to bottom, #9cb4d0, #687275);
            /* background: linear-gradient(to bottom, #74e1fc, #687275); */
            /* Gradient biru di atas, hitam di bawah */
        }

        /* Gaya untuk tabel */
        table {
            font-size: 13px;
            min-width: 1000px;
        }
    </style>
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
                    <div class="table-responsive" style="overflow-x: auto;">
                        <table id="aksesTable" class="table table-bordered table-striped table-hover"
                            style="font-size: 10px; min-width: 1000px;">
                            <thead class="thead-custom">
                                <tr>
                                    {{-- <th><input type="checkbox" name="" id="select_all_ids"></th> --}}
                                    <th>NO</th>
                                    <th>KODE SPK</th>
                                    <th>PELANGGAN</th>
                                    <th>TUJUAN</th>
                                    <th>TANGGAL</th>
                                    <th>NO KABIN</th>
                                    <th>NAMA DRIVER</th>
                                    <th>POST</th>
                                    {{-- <th>NO RESI</th> --}}
                                    <th>TIMER</th>
                                    {{-- <th>TIMER TOTAL</th> --}}
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
                                                    @if ($pengambilan_do->timer_suratjalan->last()->user->karyawan->post_id == null)
                                                        PUSAT
                                                    @else
                                                        {{ $pengambilan_do->timer_suratjalan->last()->user->karyawan->post->nama_post ?? null }}
                                                    @endif
                                                @else
                                                    -
                                                @endif
                                            @else
                                                {{-- PAKET
                                                <br>
                                                NO RESI : 123456789098 --}}
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
                                        {{-- <td>
                                            @if ($pengambilan_do->status_penerimaansj == 'posting' && $pengambilan_do->durasi_penerimaan_hari !== null)
                                                {{ $pengambilan_do->durasi_penerimaan_hari }} hari,
                                                {{ $pengambilan_do->durasi_penerimaan_jam }} jam,
                                                {{ $pengambilan_do->durasi_penerimaan_menit }} menit,
                                                {{ $pengambilan_do->durasi_penerimaan_detik }} detik
                                            @elseif ($pengambilan_do->durasi_hari !== '-' && $pengambilan_do->durasi_jam !== '-')
                                                {{ $pengambilan_do->durasi_hari }} hari, {{ $pengambilan_do->durasi_jam }}
                                                jam
                                            @else
                                                Durasi tidak tersedia
                                            @endif
                                        </td> --}}
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
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


    <script>
        $(document).ready(function() {
            // Fungsi untuk memparsing durasi ke format angka untuk sorting
            function parseDuration(data) {
                const match = data.match(/(\d+)\s+hari,\s*(\d+)\s+jam/);
                if (match) {
                    // Menghitung total durasi dalam jam agar mudah diurutkan
                    const days = parseInt(match[1], 10);
                    const hours = parseInt(match[2], 10);
                    return (days * 24) + hours;
                }
                return 0; // Jika tidak ada format durasi yang cocok
            }

            // Menambahkan custom sorting untuk kolom durasi
            $.fn.dataTable.ext.type.order['duration-pre'] = function(d) {
                return parseDuration(d);
            };

            // Inisialisasi DataTables
            $('#aksesTable').DataTable({
                "paging": false, // Menonaktifkan pagination
                "ordering": true,
                "info": true,
                "order": [], // Nonaktifkan pengurutan awal pada semua kolom
                "columnDefs": [{
                        "orderable": false,
                        "targets": 0
                    }, // Nonaktifkan pengurutan untuk kolom No
                    {
                        "type": "duration",
                        "targets": 8
                    }, // Custom sorting untuk kolom "Posisi" (indeks kolom 8)
                    // {
                    //     "type": "duration",
                    //     "targets": 9
                    // } // Custom sorting untuk kolom "TIMER TOTAL" (indeks kolom 9)
                ],
                "language": {
                    "search": "Search: ",
                    "searchPlaceholder": ""
                },
                "drawCallback": function(settings) {
                    var api = this.api();
                    // Mengatur ulang nomor urut pada setiap refresh (filter/pagination)
                    api.column(0, {
                        order: 'applied'
                    }).nodes().each(function(cell, i) {
                        cell.innerHTML = i + 1;
                    });
                }
            });
        });
    </script>


    {{-- hanya index ke 9  --}}
    {{-- <script>
        $(document).ready(function() {
            // Fungsi untuk memparsing durasi ke format angka untuk sorting
            function parseDuration(data) {
                const match = data.match(/(\d+)\s+hari,\s*(\d+)\s+jam/);
                if (match) {
                    // Menghitung total durasi dalam jam agar mudah diurutkan
                    const days = parseInt(match[1], 10);
                    const hours = parseInt(match[2], 10);
                    return (days * 24) + hours;
                }
                return 0; // Jika tidak ada format durasi yang cocok
            }

            // Menambahkan custom sorting untuk kolom durasi
            $.fn.dataTable.ext.type.order['duration-pre'] = function(d) {
                return parseDuration(d);
            };

            // Inisialisasi DataTables
            $('#aksesTable').DataTable({
                "paging": false, // Menonaktifkan pagination
                "ordering": true,
                "info": true,
                "order": [], // Nonaktifkan pengurutan awal pada semua kolom
                "columnDefs": [{
                        "orderable": false,
                        "targets": 0
                    }, // Nonaktifkan pengurutan untuk kolom No
                    {
                        "type": "duration",
                        "targets": 9
                    } // Mengatur custom sorting di kolom "TIMER TOTAL" (indeks kolom 9)
                ],
                "language": {
                    "search": "Search: ",
                    "searchPlaceholder": ""
                },
                "drawCallback": function(settings) {
                    var api = this.api();
                    // Mengatur ulang nomor urut pada setiap refresh (filter/pagination)
                    api.column(0, {
                        order: 'applied'
                    }).nodes().each(function(cell, i) {
                        cell.innerHTML = i + 1;
                    });
                }
            });
        });
    </script> --}}


    {{-- sudah benar  --}}
    {{-- <script>
        $(document).ready(function() {
            // Inisialisasi DataTables
            $('#aksesTable').DataTable({
                "paging": false, // Menonaktifkan pagination
                "ordering": true,
                "info": true,
                "order": [], // Nonaktifkan pengurutan awal pada semua kolom
                "columnDefs": [{
                        "orderable": false,
                        "targets": 0
                    } // Nonaktifkan pengurutan untuk kolom No
                ],
                "language": {
                    "search": "Search: ",
                    "searchPlaceholder": ""
                },
                "drawCallback": function(settings) {
                    var api = this.api();
                    // Mengatur ulang nomor urut pada setiap refresh (filter/pagination)
                    api.column(0, {
                        order: 'applied'
                    }).nodes().each(function(cell, i) {
                        cell.innerHTML = i + 1;
                    });
                }
            });
        });
    </script> --}}

    <!-- /.card -->
    <script>
        var form = document.getElementById('form-action');

        function cari() {
            form.action = "{{ url('admin/monitoring_suratjalan') }}";
            form.submit();
        }
    </script>


    <script>
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
    </script>

@endsection
