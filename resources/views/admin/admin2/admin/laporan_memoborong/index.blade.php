@extends('layouts.app')

@section('title', 'Laporan Memo Borong')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Laporan Memo Borong</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Laporan Memo Borong</li>
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
                    <h3 class="card-title">Data Laporan Memo Borong</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="GET" id="form-action">
                        <div class="row">
                            <div class="col-md-5 mb-3">
                                <label for="tanggal_awal">Tanggal Awal</label>
                                <input class="form-control" id="tanggal_awal" name="tanggal_awal" type="date"
                                    value="{{ Request::get('tanggal_awal') }}" max="{{ date('Y-m-d') }}" />
                            </div>
                            <div class="col-md-5 mb-3">
                                <label for="tanggal_akhir">Tanggal Akhir</label>
                                <input class="form-control" id="tanggal_akhir" name="tanggal_akhir" type="date"
                                    value="{{ Request::get('tanggal_akhir') }}" max="{{ date('Y-m-d') }}" />
                            </div>
                            <div class="col-md-2 mb-3">
                                @if (auth()->check() && auth()->user()->fitur['laporan penggantian oli cari'])
                                    <button type="button" class="btn btn-outline-primary btn-block" onclick="cari()">
                                        <i class="fas fa-search"></i> Cari
                                    </button>
                                @endif
                                @if (auth()->check() && auth()->user()->fitur['laporan penggantian oli cetak'])
                                    <button type="button" class="btn btn-primary btn-block" onclick="printReport()"
                                        target="_blank">
                                        <i class="fas fa-print"></i> Cetak
                                    </button>
                                @endif
                            </div>
                        </div>
                    </form>
                    <table id="example1" class="table table-bordered table-striped" style="font-size:13px">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>No Memo</th>
                                <th>Tanggal</th>
                                <th>Sopir</th>
                                <th>No Kabin</th>
                                <th>Rute</th>
                                <th style="text-align: center">Harga</th>
                                <th style="text-align: center">qty</th>
                                <th style="text-align: center">Total</th>
                                <th style="text-align: center">PPH</th>
                                <th style="text-align: center">Adm</th>
                                <th style="text-align: center">Deposit Sopir</th>
                                <th style="text-align: center">Grand Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inquery as $memoborong)
                                <tr id="editMemoekspedisi" data-toggle="modal"
                                    data-target="#modal-posting-{{ $memoborong->id }}" style="cursor: pointer;">
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $memoborong->kode_memo }}</td>
                                    <td>{{ $memoborong->tanggal_awal }}</td>
                                    <td>

                                        {{ explode(' ', $memoborong->nama_driver)[0] }}
                                    </td>
                                    <td>
                                        {{ $memoborong->no_kabin }}
                                    </td>
                                    <td>
                                        @if ($memoborong->nama_rute == null)
                                            {{ $memoborong->detail_memo->first()->nama_rutes }}
                                        @else
                                            {{ $memoborong->nama_rute }}
                                        @endif
                                    </td>
                                    <td style="text-align: end">
                                        {{ number_format($memoborong->harga_rute, 0, ',', '.') }}
                                    </td>
                                    <td style="text-align: end">
                                        {{ $memoborong->jumlah }}
                                    </td>
                                    <td style="text-align: end">
                                        @if ($memoborong->totalrute == null)
                                            0
                                        @else
                                            {{ number_format($memoborong->totalrute, 0, ',', '.') }}
                                        @endif
                                    </td>
                                    <td style="text-align: end">
                                        {{ number_format($memoborong->pphs, 0, ',', '.') }}
                                    </td>
                                    <td style="text-align: end">
                                        {{ number_format($memoborong->uang_jaminans, 0, ',', '.') }}
                                    </td>
                                    <td style="text-align: end">
                                        {{ number_format($memoborong->deposit_drivers, 0, ',', '.') }}
                                    </td>
                                    <td style="text-align: end">
                                        {{ number_format($memoborong->sub_total, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
            form.action = "{{ url('admin/laporan_memoborong') }}";
            form.submit();
        }

        function printReport() {
            var startDate = tanggalAwal.value;
            var endDate = tanggalAkhir.value;

            if (startDate && endDate) {
                form.action = "{{ url('admin/print_memoborong') }}" + "?start_date=" + startDate + "&end_date=" +
                    endDate;
                form.submit();
            } else {
                alert("Silakan isi kedua tanggal sebelum mencetak.");
            }
        }
    </script>
@endsection
