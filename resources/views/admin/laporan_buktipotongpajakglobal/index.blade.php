@extends('layouts.app')

@section('title', 'Laporan Bukti Potong Pajak Global')

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
                    <h3 class="card-title">Data Laporan Bukti Potong Pajak Global</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="GET" id="form-action">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="created_at">Jenis Laporan</label>
                                <select class="custom-select form-control" id="status" name="status">
                                    <option value="">- Pilih Laporan -</option>
                                    <option value="buktipotong">Laporan Bukti Potong Pajak</option>
                                    <option value="buktipotongglobal" selected>Laporan Bukti Potong Pajak Global</option>
                                </select>
                                <label style="margin-top:7px" for="status">Cari Pelanggan</label>
                                <select class="select2bs4 select2-hidden-accessible" name="pelanggan_id"
                                    data-placeholder="Cari Pelanggan.." style="width: 100%;" data-select2-id="23"
                                    tabindex="-1" aria-hidden="true" id="pelanggan_id">
                                    <option value="">- Pilih -</option>
                                    @foreach ($pelanggans as $pelanggan)
                                        <option value="{{ $pelanggan->id }}"
                                            {{ Request::get('pelanggan_id') == $pelanggan->id ? 'selected' : '' }}>
                                            {{ $pelanggan->nama_pell }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="created_at">Status</label>
                                <select class="custom-select form-control" id="status" name="status">
                                    <option value="">- Semua Status -</option>
                                    <option value="selesai" {{ Request::get('status') == 'selesai' ? 'selected' : '' }}>
                                        Lunas
                                    </option>
                                    <option value="posting" {{ Request::get('status') == 'posting' ? 'selected' : '' }}>
                                        Belum Lunas</option>
                                </select>
                                <label style="margin-top:7px" for="created_at">Kategori</label>
                                <select class="custom-select form-control" id="status_terpakai" name="status_terpakai">
                                    <option value="">- Semua Status -</option>
                                    <option value="digunakan"
                                        {{ Request::get('status_terpakai') == 'digunakan' ? 'selected' : '' }}>
                                        Sudah Ada Bukti Potong
                                    </option>
                                    <option value="" {{ Request::get('status_terpakai') == null ? 'selected' : '' }}>
                                        Belum Ada Bukti Potong</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="tanggal_awal">Tanggal Awal</label>
                                <input class="form-control" id="tanggal_awal" name="tanggal_awal" type="date"
                                    value="{{ Request::get('tanggal_awal') }}" max="{{ date('Y-m-d') }}" />
                                <label style="margin-top:7px" for="tanggal_akhir">Tanggal Akhir</label>
                                <input class="form-control" id="tanggal_akhir" name="tanggal_akhir" type="date"
                                    value="{{ Request::get('tanggal_akhir') }}" max="{{ date('Y-m-d') }}" />

                            </div>
                            <div class="col-md-3 mb-3">
                                <label style="color: white" for="tanggal_akhir">.</label>

                                <button type="button" class="btn btn-outline-primary btn-block" onclick="cari()">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                                {{-- @endif --}}
                                {{-- @if (auth()->check() && auth()->user()->fitur['laporan penerimaan kas kecil cetak']) --}}
                                <label style="margin-top:7px; color:white" for="tanggal_akhir">.</label>
                                <button type="button" class="btn btn-primary btn-block" onclick="printReport()"
                                    target="_blank">
                                    <i class="fas fa-print"></i> Cetak
                                </button>
                            </div>

                        </div>
                    </form>
                    <div class="table-responsive" style="overflow-x: auto;">
                        <table id="datatables66" class="table table-bordered table-striped table-hover"
                            style="font-size: 13px">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>No Invoice</th>
                                    <th>Tanggal</th>
                                    <th>Tanggal Pelunasan</th>
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
                                        <td>
                                            @if ($tagihanekspedisi->faktur_pelunasan->first())
                                                {{ $tagihanekspedisi->faktur_pelunasan->first()->tanggal_transfer }}
                                            @else
                                                -
                                            @endif
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
                form.action = "{{ url('admin/print_buktipotongpajakglobal') }}" + "?start_date=" + startDate +
                    "&end_date=" +
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
