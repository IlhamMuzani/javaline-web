@extends('layouts.app')

@section('title', 'Laporan Bukti Potong Pajak')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Laporan Bukti Potong Pajak</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Laporan Bukti Potong Pajak</li>
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
                    <h3 class="card-title">Data Laporan Bukti Potong Pajak</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="GET" id="form-action">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="kategori">(Pilih Kategori)</label>
                                <select class="custom-select form-control" id="kategori" name="kategori">
                                    <option value="">- Semua Kategori -</option>
                                    <option value="Pemasukan Deposit"
                                        {{ Request::get('kategori') == 'Pemasukan Deposit' ? 'selected' : '' }}>
                                        Pemasukan Deposit
                                    </option>
                                    <option value="Pengambilan Deposit"
                                        {{ Request::get('kategori') == 'Pengambilan Deposit' ? 'selected' : '' }}>
                                        Pengambilan Deposit</option>
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
                                {{-- @if (auth()->check() && auth()->user()->fitur['laporan penerimaan kas kecil cari']) --}}
                                <button type="button" class="btn btn-outline-primary btn-block" onclick="cari()">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                                {{-- @endif --}}
                                {{-- @if (auth()->check() && auth()->user()->fitur['laporan penerimaan kas kecil cetak']) --}}
                                <button type="button" class="btn btn-primary btn-block" onclick="printReport()"
                                    target="_blank">
                                    <i class="fas fa-print"></i> Cetak
                                </button>
                                {{-- @endif --}}
                            </div>
                        </div>
                    </form>
                    <table id="datatables66" class="table table-bordered table-striped table-hover" style="font-size: 13px">
                        <thead class="thead-dark">
                            <tr>
                                <th> <input type="checkbox" name="" id="select_all_ids"></th>
                                <th class="text-center">No</th>
                                <th>Kode Bukti</th>
                                <th>Tanggal</th>
                                <th>Bag.inp</th>
                                <th>Status</th>
                                <th>Kategori</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inquery as $buktipotongpajak)
                                <tr class="dropdown"{{ $buktipotongpajak->id }}>
                                    <td><input type="checkbox" name="selectedIds[]" class="checkbox_ids"
                                            value="{{ $buktipotongpajak->id }}">
                                    </td>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>
                                        {{ $buktipotongpajak->kode_bukti }}
                                    </td>
                                    <td>
                                        {{ $buktipotongpajak->tanggal_awal }}
                                    </td>
                                    <td>
                                        @if ($buktipotongpajak->user)
                                            {{ $buktipotongpajak->user->karyawan->nama_lengkap }}
                                        @else
                                            tidak ada
                                        @endif
                                    </td>
                                    <td>
                                        {{ $buktipotongpajak->kategori }}
                                    </td>
                                    <td>
                                        {{ $buktipotongpajak->kategoris }}
                                    </td>
                                    <td class="text-right">{{ number_format($buktipotongpajak->grand_total, 2, ',', '.') }}
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
            form.action = "{{ url('admin/laporan_buktipotongpajak') }}";
            form.submit();
        }

        function printReport() {
            var startDate = tanggalAwal.value;
            var endDate = tanggalAkhir.value;

            if (startDate && endDate) {
                form.action = "{{ url('admin/print_buktipotongpajak') }}" + "?start_date=" + startDate + "&end_date=" +
                    endDate;
                form.submit();
            } else {
                alert("Silakan isi kedua tanggal sebelum mencetak.");
            }
        }
    </script>
@endsection
