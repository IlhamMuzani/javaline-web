@extends('layouts.app')

@section('title', 'Laporan Faktur Ekspedisi')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Laporan Faktur Ekspedisi</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Laporan Faktur Ekspedisi</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
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
                    <h3 class="card-title">Data Laporan Faktur Ekspedisi</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="GET" id="form-action">
                        <div class="row">
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
                                <label for="created_at">Kategori</label>
                                <select class="custom-select form-control" id="status_pelunasan" name="status_pelunasan">
                                    <option value="">- Semua Status -</option>
                                    <option value="" {{ Request::get('status_pelunasan') == '' ? 'selected' : '' }}>
                                        Belum Lunas
                                    </option>
                                    <option value="aktif"
                                        {{ Request::get('status_pelunasan') == 'aktif' ? 'selected' : '' }}>
                                        Lunas</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="tanggal_awal">Tanggal Awal</label>
                                <input class="form-control" id="tanggal_awal" name="tanggal_awal" type="date"
                                    value="{{ Request::get('tanggal_awal') }}" max="{{ date('Y-m-d') }}" />
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="tanggal_akhir">Tanggal Akhir</label>
                                <input class="form-control" id="tanggal_akhir" name="tanggal_akhir" type="date"
                                    value="{{ Request::get('tanggal_akhir') }}" max="{{ date('Y-m-d') }}" />
                            </div>
                            <div class="col-md-2 mb-3">
                                <button type="button" class="btn btn-outline-primary btn-block" onclick="cari()">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                                @if (auth()->check() && auth()->user()->fitur['laporan penggantian oli cetak'])
                                    <button type="button" class="btn btn-primary btn-block" onclick="printReport()"
                                        target="_blank">
                                        <i class="fas fa-print"></i> Cetak
                                    </button>
                                @endif
                            </div>
                        </div>
                    </form>
                    <table id="datatables66" class="table table-bordered table-striped table-hover" style="font-size: 13px">
                        <thead class="thead-dark">
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
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalGrandTotal = 0;
                                $totalGrandTotalMemo = 0;
                            @endphp
                            @foreach ($inquery as $faktur)
                                <tr style="background: rgb(193, 193, 193)">
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>
                                        {{ $faktur->kode_faktur }}
                                    </td>
                                    <td>
                                        {{ $faktur->tanggal_awal }}
                                    </td>
                                    <td>
                                        {{ $faktur->nama_pelanggan }}
                                    </td>
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
                                    <td style="text-align: right">
                                        {{ number_format($faktur->pph, 2, ',', '.') }}</td>
                                    <td style="text-align: right">
                                        @if (is_numeric($faktur->biaya_tambahan))
                                            {{ number_format($faktur->biaya_tambahan, 2, ',', '.') }}
                                        @else
                                            Format salah
                                        @endif
                                    </td>
                                    <td style="text-align: right">
                                        {{ number_format($faktur->grand_total, 2, ',', '.') }}</td>
                                </tr>
                                @foreach ($faktur->detail_faktur as $memo)
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>{{ $memo->kode_memo }}</td>
                                        <td>{{ $memo->tanggal_awal }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                @endforeach

                                @php
                                    $totalGrandTotal += $faktur->total_tarif;
                                    $totalGrandTotalMemo += $faktur->pph;
                                    // $Selisih = $totalGrandTotal - $totalGrandTotalMemo;
                                    // $Totals = $totalGrandTotal - $totalGrandTotalMemo;
                                @endphp

                                @php
                                    $Totals = $totalGrandTotal - $totalGrandTotalMemo;
                                @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label style="font-size:14px; margin-top:5px" for="tarif">Total
                                                    Faktur
                                                    <span style="margin-left:70px"></span></label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input style="text-align: end; font-size:14px;" id="total_faktur"
                                                    value="{{ number_format($totalGrandTotal, 2, ',', '.') }}"
                                                    type="text" class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label style="font-size:14px; margin-top:5px">PPH
                                                    <span style="margin-left:72px"></span></label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input style="text-align: end; font-size:14px;" type="text"
                                                    class="form-control" readonly
                                                    value="{{ number_format($totalGrandTotalMemo, 2, ',', '.') }}">
                                            </div>
                                        </div>
                                        <hr
                                            style="border: 2px solid black; display: inline-block; width: 97%; vertical-align: middle;">
                                        <span
                                            style="display: inline-block; margin-left: 0px; margin-right: 0; font-size: 18px; vertical-align: middle;"></span>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label style="font-size:14px; margin-top:5px">Total
                                                    <span style="margin-left:101px"></span></label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input style="text-align: end; font-size:14px;" type="text"
                                                    class="form-control" readonly
                                                    value="{{ Request::get('tanggal_awal') ? number_format($totalGrandTotal - $totalGrandTotalMemo, 2, ',', '.') : 0 }}">
                                            </div>
                                        </div>
                                    </div>

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
            form.action = "{{ url('admin/laporan_fakturekspedisi') }}";
            form.submit();
        }

        function printReport() {
            var startDate = tanggalAwal.value;
            var endDate = tanggalAkhir.value;

            if (startDate && endDate) {
                form.action = "{{ url('admin/print_fakturekspedisi') }}" + "?start_date=" + startDate + "&end_date=" +
                    endDate;
                form.submit();
            } else {
                alert("Silakan isi kedua tanggal sebelum mencetak.");
            }
        }
    </script>
@endsection
