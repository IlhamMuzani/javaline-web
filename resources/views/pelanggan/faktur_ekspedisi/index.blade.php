@extends('layouts.app')

@section('title', 'Faktur Ekspedisi')

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

        /* Gaya untuk header tabel */
        .thead-custom {
            color: white;
            /* Warna teks putih */
        }

        .thead-custom th {
            background: linear-gradient(to bottom, #9cb4d0, #687275);
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
                    <h1 class="m-0">Faktur Ekspedisi</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Faktur Ekspedisi</li>
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
                    <h3 class="card-title">Faktur Ekspedisi</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="GET" id="form-action">
                        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <input class="form-control" id="tanggal_awal" name="tanggal_awal" type="date"
                                    value="{{ Request::get('tanggal_awal') }}" max="{{ date('Y-m-d') }}" />
                                <label for="tanggal_awal">(Tanggal Awal)</label>
                            </div>
                            <div class="col-md-3 mb-3">
                                <input class="form-control" id="tanggal_akhir" name="tanggal_akhir" type="date"
                                    value="{{ Request::get('tanggal_akhir') }}" max="{{ date('Y-m-d') }}" />
                                <label for="tanggal_akhir">(Tanggal Akhir)</label>
                            </div>
                            <div class="col-md-3 mb-3">
                                <button type="button" class="btn btn-outline-primary btn-block" onclick="cari()">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                            </div>
                        </div>

                    </form>
                    <style>
                        /* Gunakan !important untuk memastikan warna diterapkan */
                        .bg-blue {
                            background-color: #8cb0d6 !important;
                            /* Gunakan warna biru muda yang lebih lembut */
                        }
                    </style>

                    <div class="table-responsive" style="overflow-x: auto;">
                        <table id="aksesTable" class="table table-bordered table-striped table-hover"
                            style="font-size: 10px; min-width: 1000px;">
                            <thead class="thead-custom">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Faktur Ekspedisi</th>
                                    <th></th>
                                    <th>Pelanggan</th>
                                    <th>No Kabin</th>
                                    <th>Total</th>
                                    <th>PPH</th>
                                    <th>U. Tambahan</th>
                                    <th>Sub Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalGrandTotal = 0;
                                    $pph23 = 0;
                                @endphp
                                @foreach ($inquery as $faktur)
                                    <!-- Tambahkan kelas 'bg-blue' jika status_pelunasan == 'aktif' -->
                                    <tr class="{{ $faktur->status_pelunasan == 'aktif' ? 'bg-blue' : '' }}">
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $faktur->kode_faktur }}</td>
                                        <td>{{ $faktur->tanggal_awal }}</td>
                                        <td>{{ $faktur->nama_pelanggan }}</td>
                                        <td>
                                            @if ($faktur->detail_faktur->first())
                                                {{ $faktur->detail_faktur->first()->nama_driver }}
                                            @else
                                                tidak ada
                                            @endif
                                            @if ($faktur->detail_faktur->first())
                                                ({{ $faktur->detail_faktur->first()->no_kabin }})
                                            @else
                                                tidak ada
                                            @endif
                                        </td>
                                        <td style="text-align: right">
                                            {{ number_format($faktur->total_tarif, 2, ',', '.') }}</td>
                                        <td style="text-align: right">{{ number_format($faktur->pph, 2, ',', '.') }}</td>
                                        <td style="text-align: right">
                                            @if (is_numeric($faktur->biaya_tambahan))
                                                {{ number_format($faktur->biaya_tambahan, 2, ',', '.') }}
                                            @else
                                                Format salah
                                            @endif
                                        </td>
                                        <td style="text-align: right">
                                            {{ number_format($faktur->grand_total, 2, ',', '.') }}</td>
                                        <td>
                                            @if ($faktur->status_pelunasan == 'aktif')
                                                LUNAS
                                            @endif
                                        </td>
                                    </tr>
                                    @php
                                        $totalGrandTotal += $faktur->total_tarif + $faktur->biaya_tambahan;
                                        $pph23 += $faktur->pph;
                                    @endphp
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
        var tanggalAwal = document.getElementById('tanggal_awal');
        var tanggalAkhir = document.getElementById('tanggal_akhir');

        // Set tanggalAkhir readOnly jika tanggalAwal belum dipilih
        if (tanggalAwal.value == "") {
            tanggalAkhir.readOnly = true;
        }

        // Event listener untuk mengatur tanggalAkhir saat tanggalAwal berubah
        tanggalAwal.addEventListener('change', function() {
            if (this.value == "") {
                tanggalAkhir.readOnly = true;
            } else {
                tanggalAkhir.readOnly = false;
            }

            tanggalAkhir.value = "";
            var today = new Date().toISOString().split('T')[0];
            tanggalAkhir.value = today;
            tanggalAkhir.setAttribute('min', this.value);
        });

        var form = document.getElementById('form-action');

        function cari() {
            // Pengecekan jika tanggalAwal belum diisi
            if (tanggalAwal.value == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Pilih Tanggal Awal',
                    text: 'Silakan pilih tanggal awal terlebih dahulu.',
                    confirmButtonText: 'OK'
                });
                return;
            }

            form.action = "{{ url('pelanggan/faktur-ekspedisi') }}";
            form.submit();
        }
    </script>


    {{-- sudah benar  --}}
    <script>
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
    </script>

@endsection
