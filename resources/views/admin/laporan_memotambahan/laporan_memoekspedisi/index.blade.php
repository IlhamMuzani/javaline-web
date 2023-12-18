@extends('layouts.app')

@section('title', 'Laporan Memo Ekspedisi')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Laporan Memo Ekspedisi</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Laporan Memo Ekspedisi</li>
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
                    <h3 class="card-title">Data Laporan Memo Ekspedisi</h3>
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
                                <th>U. Jalan</th>
                                <th>U. Tambah</th>
                                <th>Deposit</th>
                                <th>Adm</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inquery as $memoekspedisi)
                                <tr id="editMemoekspedisi" data-toggle="modal"
                                    data-target="#modal-posting-{{ $memoekspedisi->id }}" style="cursor: pointer;">
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $memoekspedisi->kode_memo }}</td>
                                    <td>{{ $memoekspedisi->tanggal_awal }}</td>
                                    <td>
                                        {{ explode(' ', $memoekspedisi->nama_driver)[0] }}
                                    </td>
                                    <td>
                                        {{ $memoekspedisi->no_kabin }}
                                    </td>
                                    <td>
                                        @if ($memoekspedisi->nama_rute == null)
                                            {{ $memoekspedisi->detail_memo->first()->nama_rutes }}
                                        @else
                                            {{ $memoekspedisi->nama_rute }}
                                        @endif
                                    </td>
                                    <td>
                                        {{ number_format($memoekspedisi->uang_jalan, 0, ',', '.') }}
                                    </td>
                                    <td>
                                        @if ($memoekspedisi->biaya_tambahan == null)
                                            0
                                        @else
                                            {{ number_format($memoekspedisi->biaya_tambahan, 0, ',', '.') }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($memoekspedisi->deposit_driver == null)
                                            0
                                        @else
                                            {{ number_format($memoekspedisi->deposit_driver, 0, ',', '.') }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($memoekspedisi->uang_jaminan == null)
                                            0
                                        @else
                                            {{ number_format($memoekspedisi->uang_jaminan, 0, ',', '.') }}
                                        @endif
                                    </td>
                                    <td>
                                        {{ number_format($memoekspedisi->sub_total, 0, ',', '.') }}
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
            form.action = "{{ url('admin/laporan_memoekspedisi') }}";
            form.submit();
        }

        function printReport() {
            var startDate = tanggalAwal.value;
            var endDate = tanggalAkhir.value;

            if (startDate && endDate) {
                form.action = "{{ url('admin/print_memoekspedisi') }}" + "?start_date=" + startDate + "&end_date=" +
                    endDate;
                form.submit();
            } else {
                alert("Silakan isi kedua tanggal sebelum mencetak.");
            }
        }
    </script>
@endsection
