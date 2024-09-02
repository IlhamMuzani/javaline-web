@extends('layouts.app')

@section('title', 'Laporan Piutang')

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
                    <h1 class="m-0">Laporan Piutang</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Laporan Piutang</li>
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
                        <i class="icon fas fa-check"></i> Success!
                    </h5>
                    {{ session('success') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Laporan Piutang</h3>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="GET" id="form-action">
                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <div class="form-group" style="flex: 8;">
                                    <select class="select2bs4 select22-hidden-accessible" name="pelanggan_id"
                                        data-placeholder="Cari Pelanggan.." style="width: 100%;" data-select22-id="23"
                                        tabindex="-1" aria-hidden="true" id="pelanggan_id">
                                        <option value="">- Pilih -</option>
                                        @foreach ($pelanggans as $pelanggan)
                                            <option value="{{ $pelanggan->id }}"
                                                {{ old('pelanggan_id') == $pelanggan->id ? 'selected' : '' }}>
                                                {{ $pelanggan->nama_pell }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 mb-3">
                                <button type="button" class="btn btn-outline-primary btn-block" onclick="cari()">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                            </div>
                            <div class="col-md-2 mb-3">
                                <button type="button" class="btn btn-primary btn-block" onclick="printReport()"
                                    target="_blank">
                                    <i class="fas fa-print"></i> Cetak
                                </button>
                            </div>
                            {{-- <div class="col-md-2 mb-3">
                                <button id="toggle-all" type="button" class="btn btn-info btn-block">
                                    All Toggle Detail
                                </button>
                            </div> --}}
                        </div>
                    </form>
                    <!-- Tabel Faktur Utama -->
                    <table class="table table-bordered table-striped table-hover" style="font-size: 13px">
                        <thead>
                            <tr>
                                <th>Kode Invoice</th>
                                <th>Tanggal</th>
                                <th>Pelanggan</th>
                                <th>No Polisi</th>
                                <th>Grand Total</th>
                                {{-- <th>Actions</th> <!-- Tambahkan kolom aksi untuk collapse/expand --> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inquery as $index => $invoice)
                                <tr data-toggle="collapse" data-target="#invoice-{{ $index }}"
                                    class="accordion-toggle" style="background: rgb(156, 156, 156)">
                                    <td>{{ $invoice->kode_tagihan }}</td>
                                    <td>{{ $invoice->created_at }}</td>
                                    <td>{{ $invoice->nama_pelanggan }}</td>
                                    <td>{{ $invoice->kendaraan ? $invoice->kendaraan->no_kabin : 'Tidak ada' }}</td>
                                    <td class="text-right">{{ number_format($invoice->grand_total, 2, ',', '.') }}</td>
                                    {{-- <td>
                                        <button class="btn btn-info" data-toggle="collapse"
                                            data-target="#invoice-{{ $index }}">Toggle Detail</button>
                                    </td> --}}
                                </tr>
                                <tr>
                                    <td colspan="6"> 
                                        <div id="invoice-{{ $index }}" class="collapse">
                                            <table class="table table-sm" style="margin: 0;">
                                                <thead>
                                                    <tr>
                                                        <th>Kode Faktur</th>
                                                        <th>Tanggal</th>
                                                        <th>Nama Rute</th>
                                                        <th>Biaya Ekspedisi</th>
                                                        <th>Jumlah</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($invoice->detail_tagihan as $memo)
                                                        <tr>
                                                            <td>{{ $memo->id }}</td>
                                                            <td>{{ $memo->id }}</td>
                                                            <td>{{ $memo->id }}</td>
                                                            <td class="text-right">
                                                                0
                                                            <td class="text-right">
                                                                0
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
