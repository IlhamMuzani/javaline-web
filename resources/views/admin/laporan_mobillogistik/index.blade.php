@extends('layouts.app')

@section('title', 'Laporan Mobil Logistik')

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
                    <h1 class="m-0">Laporan Mobil Logistik</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Laporan Mobil Logistik</li>
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
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Laporan Mobil Logistik</h3>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="GET" id="form-action">
                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <label for="created_at">Kategori</label>
                                <select class="custom-select form-control" id="statusx" name="statusx">
                                    <option value="">- Pilih Laporan -</option>
                                    <option value="laporandetail" selected>Laporan Detail</option>
                                    <option value="laporanglobal">Laporan Global</option>
                                    {{-- <option value="akun">Laporan Kas Keluar Group by Akun</option>
                                    <option value="memo_tambahan">Saldo Kas</option> --}}
                                </select>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="created_at">Status</label>
                                <select class="custom-select form-control" id="kategoris" name="kategoris">
                                    <option value="">- Semua Status -</option>
                                    <option value="memo" {{ Request::get('kategoris') == 'memo' ? 'selected' : '' }}>
                                        MEMO
                                    </option>
                                    <option value="non memo"
                                        {{ Request::get('kategoris') == 'non memo' ? 'selected' : '' }}>
                                        NON MEMO</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="created_at">Kendaraan</label>
                                <select class="select2bs4 select2-hidden-accessible" name="kendaraan_id"
                                    data-placeholder="Cari Kendaraan.." style="width: 100%;" data-select2-id="23"
                                    tabindex="-1" aria-hidden="true" id="kendaraan_id">
                                    <option value="">- Pilih -</option>
                                    @foreach ($kendaraans as $kendaraan)
                                        <option value="{{ $kendaraan->id }}"
                                            {{ Request::get('kendaraan_id') == $kendaraan->id ? 'selected' : '' }}>
                                            {{ $kendaraan->no_kabin }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="created_at">Tanggal Awal</label>
                                <input class="form-control" id="created_at" name="created_at" type="date"
                                    value="{{ Request::get('created_at') }}" max="{{ date('Y-m-d') }}" />
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="tanggal_akhir">Tanggal Akhir</label>
                                <input class="form-control" id="tanggal_akhir" name="tanggal_akhir" type="date"
                                    value="{{ Request::get('tanggal_akhir') }}" max="{{ date('Y-m-d') }}" />
                            </div>
                            <div class="col-md-2 mb-3">
                                {{-- @if (auth()->check() && auth()->user()->fitur['laporan pengambilan kas kecil cari']) --}}
                                <button type="button" class="btn btn-outline-primary btn-block" onclick="cari()">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                                {{-- @endif
                                @if (auth()->check() && auth()->user()->fitur['laporan pengambilan kas kecil cetak']) --}}
                                <button type="button" class="btn btn-primary btn-block" onclick="printReport()"
                                    target="_blank">
                                    <i class="fas fa-print"></i> Cetak
                                </button>
                                <button id="toggle-all" type="button" class="btn btn-info btn-block">
                                    All Toggle Detail
                                </button>
                                {{-- <button id="toggle-all" class="btn btn-info float-right">Buka Semua Detail</button> --}}

                                {{-- @endif --}}
                            </div>
                        </div>
                    </form>
                    <!-- Tabel Faktur Utama -->
                    <table class="table table-bordered table-striped table-hover" style="font-size: 13px">
                        <thead>
                            <tr>
                                <th>Kode Faktur</th>
                                <th>Tanggal</th>
                                <th>Pelanggan</th>
                                <th>No Polisi</th>
                                <th>Grand Total</th>
                                <th>Actions</th> <!-- Tambahkan kolom aksi untuk collapse/expand -->
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $created_at = isset($created_at) ? $created_at : null;
                                $tanggal_akhir = isset($tanggal_akhir) ? $tanggal_akhir : null;
                            @endphp
                            @foreach ($inquery as $index => $faktur)
                                <!-- Gunakan index untuk ID unik -->
                                <!-- Baris Faktur Utama -->
                                <tr data-toggle="collapse" data-target="#faktur-{{ $index }}"
                                    class="accordion-toggle" style="background: rgb(156, 156, 156)">
                                    <td>{{ $faktur->kode_faktur }}</td>
                                    <td>{{ $faktur->created_at }}</td>
                                    <td>{{ $faktur->nama_pelanggan }}</td>
                                    <td>{{ $faktur->kendaraan ? $faktur->kendaraan->no_kabin : 'Tidak ada' }}</td>
                                    <td class="text-right">{{ number_format($faktur->grand_total, 2, ',', '.') }}</td>
                                    <td>
                                        <!-- Tombol untuk Menampilkan/Menyembunyikan Detail -->
                                        <button class="btn btn-info" data-toggle="collapse"
                                            data-target="#faktur-{{ $index }}">Toggle Detail</button>
                                    </td>
                                </tr>

                                <!-- Baris Detail Faktur -->
                                <tr>
                                    <td colspan="6"> <!-- Gabungkan kolom untuk detail -->
                                        <div id="faktur-{{ $index }}" class="collapse">
                                            <table class="table table-sm" style="margin: 0;">
                                                <thead>
                                                    <tr>
                                                        <th>Kode Memo</th>
                                                        <th>Tanggal</th>
                                                        <th>Nama Rute</th>
                                                        <th>Biaya Ekspedisi</th>
                                                        <th>Jumlah</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($faktur->detail_faktur as $memo)
                                                        <tr>
                                                            <td>{{ $memo->kode_memo }}</td>
                                                            <td>{{ $memo->created_at }}</td>
                                                            <td>{{ $memo->nama_rute }}</td>
                                                            <td class="text-right">
                                                                {{ $memo->memo_ekspedisi ? number_format($memo->memo_ekspedisi->uang_jalan, 2, ',', '.') : 'Tidak ada' }}
                                                            </td>
                                                            <td class="text-right">
                                                                {{ $memo->memo_ekspedisi ? number_format($memo->memo_ekspedisi->hasil_jumlah, 2, ',', '.') : 'Tidak ada' }}
                                                            </td>
                                                        </tr>

                                                        <!-- Menampilkan Memo Tambahan, jika ada -->
                                                        @if ($memo->memo_ekspedisi && $memo->memo_ekspedisi->memotambahan->isNotEmpty())
                                                            @foreach ($memo->memo_ekspedisi->memotambahan as $memoTambahan)
                                                                <tr>
                                                                    <td>{{ $memoTambahan->kode_tambahan }}</td>
                                                                    <td>{{ $memoTambahan->created_at }}</td>
                                                                    <td>{{ $memoTambahan->memo_ekspedisi->nama_rute }}</td>
                                                                    <td class="text-right">
                                                                        {{ number_format($memoTambahan->grand_total, 2, ',', '.') }}
                                                                    </td>
                                                                    <td class="text-right">
                                                                        {{ number_format($memoTambahan->grand_total, 2, ',', '.') }}
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>


                    <!-- Perhitungan Nilai Total -->
                    @php
                        $totalGrandTotal = 0;
                        $totalMemo = 0;
                        $totalMemoTambahan = 0;

                        foreach ($inquery as $faktur) {
                            $totalGrandTotal += $faktur->grand_total; // Total Faktur

                            foreach ($faktur->detail_faktur as $memo) {
                                $totalMemo += $memo->memo_ekspedisi->hasil_jumlah ?? 0; // Total Memo Ekspedisi

                                if ($memo->memo_ekspedisi && $memo->memo_ekspedisi->memotambahan) {
                                    foreach ($memo->memo_ekspedisi->memotambahan as $memoTambahan) {
                                        $totalMemoTambahan += $memoTambahan->grand_total ?? 0; // Total Memo Tambahan
                                    }
                                }
                            }
                        }

                        // Hitung selisih antara total faktur dengan total memo + memo tambahan
                        $selisih = $totalGrandTotal - ($totalMemo + $totalMemoTambahan);
                    @endphp

                    <!-- Tampilkan Nilai Total -->
                    <div class="row mt-4"> <!-- Tambahkan margin-top -->
                        <div class="col-md-6">
                            <!-- Ruang kosong atau konten tambahan -->
                            <div class="card"></div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <!-- Total Faktur -->
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label style="font-size:14px;">Total Faktur:</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input style="text-align: end; font-size:14px;" type="text"
                                                class="form-control"
                                                value="{{ number_format($totalGrandTotal, 2, ',', '.') }}" readonly>
                                        </div>
                                    </div>
                                    <!-- Total Memo -->
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label style="font-size:14px;">Total Memo:</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input style="text-align: end; font-size:14px;" type="text"
                                                class="form-control"
                                                value="{{ number_format($totalMemo + $totalMemoTambahan, 2, ',', '.') }}"
                                                readonly>
                                        </div>
                                    </div>

                                    <!-- Divider -->
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <hr style="border: 2px solid black;">
                                        </div>
                                    </div>

                                    <!-- Selisih -->
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label style="font-size:14px;">Selisih:</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input style="text-align: end; font-size:14px;" type="text"
                                                class="form-control" value="{{ number_format($selisih, 2, ',', '.') }}"
                                                readonly>
                                        </div>
                                    </div>
                                    <!-- Biaya Operasional -->
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label style="font-size:14px;">Biaya Operasional:</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input style="text-align: end; font-size:14px;" type="text"
                                                class="form-control" readonly
                                                value="{{ number_format($totalNominalOperasional, 2, ',', '.') }}">
                                        </div>
                                    </div>

                                    <!-- Biaya Perbaikan -->
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label style="font-size:14px;">Biaya Perbaikan:</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input style="text-align: end; font-size:14px;" type="text"
                                                class="form-control" readonly
                                                value="{{ number_format($totalNominalPerbaikan, 2, ',', '.') }}">
                                        </div>
                                    </div>
                                    <!-- Divider -->
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <hr style="border: 2px solid black;">
                                        </div>
                                    </div>

                                    <!-- Sub Total -->
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label style="font-size:14px;">Sub Total:</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input style="text-align: end; font-size:14px;" type="text"
                                                class="form-control"
                                                value="{{ number_format(
                                                    $selisih -
                                                        $totalNominalPerbaikan - $totalNominalOperasional,
                                                    2,
                                                    ',',
                                                    '.',
                                                ) }}"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- /.card -->
    <script>
        var tanggalAwal = document.getElementById('created_at');
        var tanggalAkhir = document.getElementById('tanggal_akhir');
        var kendaraanId = document.getElementById('kendaraan_id');
        var form = document.getElementById('form-action');

        if (tanggalAwal.value == "") {
            tanggalAkhir.readOnly = true;
        }

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

        function cari() {
            // Dapatkan nilai tanggal awal dan tanggal akhir
            var startDate = tanggalAwal.value;
            var endDate = tanggalAkhir.value;
            var Kendaraanid = kendaraanId.value;

            // Cek apakah tanggal awal dan tanggal akhir telah diisi
            if (startDate && endDate && Kendaraanid) {
                form.action = "{{ url('admin/laporan_mobillogistik') }}";
                form.submit();
            } else {
                alert("Silakan pilih kendaraan dan isi kedua tanggal sebelum mencetak.");
            }
        }


        function printReport() {
            var startDate = tanggalAwal.value;
            var endDate = tanggalAkhir.value;

            if (startDate && endDate) {
                form.action = "{{ url('admin/print_mobillogistik') }}" + "?start_date=" + startDate + "&end_date=" +
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
                    case 'laporandetail':
                        window.location.href = "{{ url('admin/laporan_mobillogistik') }}";
                        break;
                    case 'laporanglobal':
                        window.location.href = "{{ url('admin/laporan_mobillogistikglobal') }}";
                        break;
                        // case 'akun':
                        //     window.location.href = "{{ url('admin/laporan_pengeluarankaskecilakun') }}";
                        //     break;
                        // case 'memo_tambahan':
                        //     window.location.href = "{{ url('admin/laporan_saldokas') }}";
                        //     break;
                    default:
                        // Handle other cases or do nothing
                        break;
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            var toggleAll = $("#toggle-all");
            var isExpanded = false; // Status untuk melacak apakah semua detail telah dibuka

            toggleAll.click(function() {
                if (isExpanded) {
                    $(".collapse").collapse("hide");
                    toggleAll.text("All Toggle Detail");
                    isExpanded = false;
                } else {
                    $(".collapse").collapse("show");
                    toggleAll.text("All Close Detail");
                    isExpanded = true;
                }
            });

            // Event listener untuk mengubah status jika ada interaksi manual
            $(".accordion-toggle").click(function() {
                var target = $(this).data("target");
                if ($("#" + target).hasClass("show")) {
                    $("#" + target).collapse("hide");
                } else {
                    $("#" + target).collapse("show");
                }
            });
        });
    </script>
@endsection
