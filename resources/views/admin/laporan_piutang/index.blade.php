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
                        <i class="icon fas fa-check"></i> Berhasil!
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
                                <select class="select2bs4 select2-hidden-accessible" name="pelanggan_id"
                                    data-placeholder="Cari Pelanggan.." style="width: 100%;" id="pelanggan_id">
                                    <option value="">- Pilih -</option>
                                    {{-- <option value="all" {{ Request::get('pelanggan_id') == 'all' ? 'selected' : '' }}>All Pelanggan --}}
                                    </option>
                                    @foreach ($pelanggans as $pelanggan)
                                        <option value="{{ $pelanggan->id }}"
                                            {{ Request::get('pelanggan_id') == $pelanggan->id ? 'selected' : '' }}>
                                            {{ $pelanggan->nama_pell }}
                                        </option>
                                    @endforeach
                                </select>
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
                    <div class="table-responsive" style="overflow-x: auto;">
                        <table class="table table-bordered table-striped table-hover" style="font-size: 13px">
                            <thead>
                                <tr>
                                    <th>Kode Invoice</th>
                                    <th>Tanggal</th>
                                    <th>Pelanggan</th>
                                    <th>No Polisi</th>
                                    <th>DPP</th>
                                    <th>PPH</th>
                                    <th>Sub Total</th>
                                    {{-- <th>Actions</th> <!-- Tambahkan kolom aksi untuk collapse/expand --> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalDPP = 0;
                                    $totalPPH = 0;
                                    $totalSUB = 0;
                                @endphp
                                @foreach ($inquery as $index => $invoice)
                                    <tr data-toggle="collapse" data-target="#invoice-{{ $index }}"
                                        class="accordion-toggle" style="background: rgb(156, 156, 156)">
                                        <td>{{ $invoice->kode_tagihan }}</td>
                                        <td>{{ $invoice->created_at }}</td>
                                        <td>{{ $invoice->nama_pelanggan }}</td>
                                        <td>{{ $invoice->detail_tagihan->first()->faktur_ekspedisi->kendaraan ? $invoice->detail_tagihan->first()->faktur_ekspedisi->kendaraan->no_pol : 'Tidak ada' }}
                                        </td>
                                        <td style="text-align: end">
                                            {{ number_format($invoice->sub_total, 0, ',', '.') }}
                                        </td>
                                        <td style="text-align: end">
                                            @if ($invoice->kategori == 'PPH')
                                                {{ number_format($invoice->pph, 0, ',', '.') }}
                                            @else
                                                0
                                            @endif
                                        </td>
                                        <td style="text-align: end">
                                            {{ number_format($invoice->grand_total, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="7">
                                            <div id="invoice-{{ $index }}" class="collapse">
                                                <table class="table table-sm" style="margin: 0;">
                                                    <thead>
                                                        <tr>
                                                            <th>Kode Faktur</th>
                                                            <th>Tanggal</th>
                                                            <th>Nama Rute</th>
                                                            <th>Grand Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($invoice->detail_tagihan as $memo)
                                                            <tr>
                                                                <td>{{ $memo->kode_faktur }}</td>
                                                                <td>{{ $memo->tanggal_awal }}</td>
                                                                <td>{{ $memo->nama_rute }}</td>
                                                                <td class="text-right">
                                                                    {{ number_format($memo->faktur_ekspedisi->grand_total) }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                    @php
                                        $totalDPP += $invoice->sub_total;
                                        $totalPPH += $invoice->pph;
                                        $totalSUB += $invoice->grand_total;
                                    @endphp
                                @endforeach
                                <tr>
                                    <td colspan="1"></td>
                                    <td>
                                    </td>
                                    <td><strong>Total:</strong></td>
                                    <td>
                                    </td>
                                    <td class="text-right" style="font-weight: bold;">
                                        {{ number_format($totalDPP, 0, ',', '.') }}
                                    </td>
                                    <td class="text-right" style="font-weight: bold;">
                                        {{ number_format($totalPPH, 0, ',', '.') }}
                                    </td>
                                    <td class="text-right" style="font-weight: bold;">
                                        {{ number_format($totalSUB, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.card -->
    <script>
        var form = document.getElementById('form-action');

        function cari() {
            form.action = "{{ url('admin/laporan_piutang') }}";
            form.submit();
        }


        function printReport() {
            form.action = "{{ url('admin/print_piutang') }}";
            form.submit();
        }
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
