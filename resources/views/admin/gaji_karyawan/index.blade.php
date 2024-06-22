@extends('layouts.app')

@section('title', 'Data Gaji Karyawan')

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
                    <h1 class="m-0">Data Gaji Karyawan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Data Gaji Karyawan</li>
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
                    <h3 class="card-title">Data Gaji Karyawan</h3>
                    <div class="float-right">
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    {{-- <form method="GET" id="form-action">
                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <label for="created_at">Kategori</label>
                                <select class="custom-select form-control" id="statusx" name="statusx">
                                    <option value="">- Pilih -</option>
                                    <option value="memo_perjalanan">Gaji Staff</option>
                                    <option value="memo_borong">Gaji Teknisi</option>
                                </select>
                            </div>
                        </div>
                    </form> --}}
                    <table id="datatables66" class="table table-bordered table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center">No</th>
                                <th>Kode Karyawan</th>
                                <th>Nama</th>
                                <th>Departemen</th>
                                <th>Kasbon</th>
                                <th>Deposit Karyawan</th>
                                <th>Gaji</th>
                                <th class="text-center" width="60">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($gajis as $gaji)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $gaji->kode_karyawan }}</td>
                                    <td>{{ $gaji->nama_lengkap }}</td>
                                    <td>
                                        @if ($gaji->departemen)
                                            {{ $gaji->departemen->nama }}
                                        @else
                                            tidak ada
                                        @endif
                                    </td>
                                    <td style="text-align: right">{{ number_format($gaji->kasbon, 0, ',', '.') }}</td>
                                    <td style="text-align: right">{{ number_format($gaji->bayar_kasbon, 0, ',', '.') }}</td>
                                    <td style="text-align: right">{{ number_format($gaji->gaji, 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        @if (auth()->check() && auth()->user()->fitur['gaji karyawan update'])
                                            <a href="{{ url('admin/gaji_karyawan/' . $gaji->id . '/edit') }}"
                                                class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endif
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
            }

            tanggalAkhir.value = "";
            var today = new Date().toISOString().split('T')[0];
            tanggalAkhir.value = today;
            tanggalAkhir.setAttribute('min', this.value);
        });

        var form = document.getElementById('form-action');
    </script>

    <script>
        $(document).ready(function() {
            // Detect the change event on the 'status' dropdown
            $('#statusx').on('change', function() {
                // Get the selected value
                var selectedValue = $(this).val();

                // Check the selected value and redirect accordingly
                switch (selectedValue) {
                    case 'memo_perjalanan':
                        window.location.href = "{{ url('admin/gaji_karyawan') }}";
                        break;
                    case 'memo_borong':
                        window.location.href = "{{ url('admin/gaji_teknisi') }}";
                        break;
                    default:
                        // Handle other cases or do nothing
                        break;
                }
            });
        });
    </script>

@endsection
