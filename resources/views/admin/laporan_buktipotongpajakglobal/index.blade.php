@extends('layouts.app')

@section('title', 'Laporan Bukti Potong Pajak Global')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Laporan Bukti Potong Pajak Global</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Laporan Bukti Potong Pajak Global</li>
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
                    <h3 class="card-title">Data Laporan Bukti Potong Pajak Global</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="GET" id="form-action">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="created_at">Kategori</label>
                                <select class="custom-select form-control" id="status" name="status">
                                    <option value="">- Pilih Laporan -</option>
                                    <option value="buktipotong">Laporan Bukti Potong Pajak</option>
                                    <option value="buktipotongglobal" selected>Laporan Bukti Potong Pajak Global</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="created_at">Kategori</label>
                                <select class="custom-select form-control" id="status_terpakai" name="status_terpakai">
                                    <option value="">- Semua Status -</option>
                                    <option value="digunakan"
                                        {{ Request::get('status_terpakai') == 'digunakan' ? 'selected' : '' }}>
                                        Lunas
                                    </option>
                                    <option value="" {{ Request::get('status_terpakai') == null ? 'selected' : '' }}>
                                        Belum Lunas</option>
                                </select>

                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="tanggal_awal">Tanggal Awal</label>
                                <input class="form-control" id="tanggal_awal" name="tanggal_awal" type="date"
                                    value="{{ Request::get('tanggal_awal') }}" max="{{ date('Y-m-d') }}" />
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="tanggal_akhir">Tanggal Akhir</label>
                                <input class="form-control" id="tanggal_akhir" name="tanggal_akhir" type="date"
                                    value="{{ Request::get('tanggal_akhir') }}" max="{{ date('Y-m-d') }}" />
                            </div>
                            <div class="col-md-3 mb-3">
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
                                <th class="text-center">No</th>
                                <th>No Faktur</th>
                                <th>Tanggal</th>
                                <th>Kategori</th>
                                <th>Admin</th>
                                <th>Pelanggan</th>
                                <th>DPP</th>
                                <th>PPH</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inquery as $tagihanekspedisi)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $tagihanekspedisi->kode_tagihan }}</td>
                                    <td>{{ $tagihanekspedisi->tanggal_awal }}</td>
                                    <td>{{ $tagihanekspedisi->kategori }}</td>
                                    <td>
                                        {{ $tagihanekspedisi->user->karyawan->nama_lengkap }}
                                    </td>
                                    <td>
                                        {{ $tagihanekspedisi->nama_pelanggan }}
                                    </td>
                                    <td style="text-align: end">
                                        {{ number_format($tagihanekspedisi->sub_total, 0, ',', '.') }}
                                    </td>
                                    <td style="text-align: end">
                                        {{ number_format($tagihanekspedisi->pph, 0, ',', '.') }}
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
            form.action = "{{ url('admin/laporan_buktipotongpajakglobal') }}";
            form.submit();
        }

        function printReport() {
            var startDate = tanggalAwal.value;
            var endDate = tanggalAkhir.value;

            if (startDate && endDate) {
                form.action = "{{ url('admin/print_buktipotongpajakglobal') }}" + "?start_date=" + startDate + "&end_date=" +
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
            $('#status').on('change', function() {
                // Get the selected value
                var selectedValue = $(this).val();

                // Check the selected value and redirect accordingly
                switch (selectedValue) {
                    case 'buktipotong':
                        window.location.href = "{{ url('admin/laporan_buktipotongpajak') }}";
                        break;
                    case 'buktipotongglobal':
                        window.location.href = "{{ url('admin/laporan_buktipotongpajakglobal') }}";
                        break;
                    default:
                        break;
                }
            });
        });
    </script>
@endsection
