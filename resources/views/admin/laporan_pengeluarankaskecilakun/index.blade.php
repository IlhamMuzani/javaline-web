@extends('layouts.app')

@section('title', 'Laporan Pengambilan Kas Kecil Group by Akun')

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
                    <h1 class="m-0">Laporan Pengambilan Kas Kecil Group by Akun</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Laporan Pengambilan Kas Kecil Group by Akun</li>
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
                    <h3 class="card-title">Data Laporan Pengambilan Kas Kecil Group by Akun</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="GET" id="form-action">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="created_at">Kategori</label>
                                <select class="custom-select form-control" id="statusx" name="statusx">
                                    <option value="">- Pilih Laporan -</option>
                                    <option value="laporan_masuk">Laporan Kas Masuk</option>
                                    <option value="laporan_keluar">Laporan Kas Keluar</option>
                                    <option value="akun" selected>Laporan Kas Keluar Group by Akun</option>
                                    <option value="sisa_saldo">Saldo Kas</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="status">Cari Akun</label>
                                <select class="select2bs4 select2-hidden-accessible" name="barangakun_id"
                                    data-placeholder="Cari Kode.." style="width: 100%;" data-select2-id="23" tabindex="-1"
                                    aria-hidden="true" id="barangakun_id">
                                    <option value="">- Pilih -</option>
                                    @foreach ($barangakuns as $akun)
                                        <option value="{{ $akun->id }}"
                                            {{ Request::get('barangakun_id') == $akun->id ? 'selected' : '' }}>
                                            {{ $akun->nama_barangakun }}
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
                                {{-- @endif --}}
                            </div>
                        </div>
                    </form>
                    <table id="datatables66" class="table table-bordered table-striped table-hover" style="font-size: 13px">
                        <thead class="thead-dark">
                            <tr>
                                <th style=" width: 5%" class="text-center">No</th>
                                <th style=" width: 18%">Kode Pengeluaran</th>
                                <th style=" width: 5%">Tangggal</th>
                                <th style=" width: 62%">Keterangan</th>
                                <th style=" width: 10%">Total</th>
                                {{-- <th class="text-center" width="70">Opsi</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inquery as $pengeluaran)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $pengeluaran->kode_detailakun }}</td>
                                    <td>{{ $pengeluaran->created_at }}</td>
                                    <td>{{ $pengeluaran->keterangan }}</td>
                                    <td class="text-right">
                                        {{ number_format($pengeluaran->nominal, 0, ',', '.') }}
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
        var tanggalAwal = document.getElementById('created_at');
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
            form.action = "{{ url('admin/laporan_pengeluarankaskecilakun') }}";
            form.submit();
        }

        function printReport() {
            var startDate = tanggalAwal.value;
            var endDate = tanggalAkhir.value;

            if (startDate && endDate) {
                form.action = "{{ url('admin/print_pengeluarankaskecilakun') }}" + "?start_date=" + startDate +
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
            $('#statusx').on('change', function() {
                // Get the selected value
                var selectedValue = $(this).val();

                // Check the selected value and redirect accordingly
                switch (selectedValue) {
                    case 'laporan_masuk':
                        window.location.href = "{{ url('admin/laporan_penerimaankaskecil') }}";
                        break;
                    case 'laporan_keluar':
                        window.location.href = "{{ url('admin/laporan_pengeluarankaskecil') }}";
                        break;
                    case 'akun':
                        window.location.href = "{{ url('admin/laporan_pengeluarankaskecilakun') }}";
                        break;
                    case 'sisa_saldo':
                        window.location.href = "{{ url('admin/laporan_saldokas') }}";
                        break;
                    default:
                        // Handle other cases or do nothing
                        break;
                }
            });
        });
    </script>
@endsection
