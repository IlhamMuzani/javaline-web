@extends('layouts.app')

@section('title', 'Data Driver')

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
                    <h1 class="m-0">Data Driver</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Data Driver</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
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
                    <h3 class="card-title">Data Driver</h3>
                    <div class="float-right">
                        {{-- @if (auth()->check() && auth()->user()->fitur['driver create']) --}}
                        <a href="{{ url('admin/driver/create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah
                        </a>
                        {{-- @endif --}}
                    </div>
                </div>

                <div class="card-body">
                    <form method="GET" id="form-action">
                        <div class="row">
                            <div class="col-md-2">
                                <button type="button" class="btn btn-primary btn-block" onclick="printCetak(this.form)"
                                    target="_blank">
                                    <i class="fas fa-print"></i> Cetak
                                </button>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-success btn-block" onclick="printExport(this.form)"
                                    target="_blank">
                                    <i class="fas fa-table"></i> Export
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="card-body">
                    <table id="datatables66" class="table table-bordered table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center">No</th>
                                <th>Kode Sopir</th>
                                <th>Nama Sopir</th>
                                <th>Telp</th>
                                <th class="text-right">Deposit</th>
                                <th class="text-right">Kasbon</th>
                                <th class="text-right">Bayar Kasbon</th>
                                <th class="text-right">Saldo Deposit</th>
                                <th class="text-center" width="50">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($drivers as $driver)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $driver->kode_karyawan }}</td>
                                    <td>{{ $driver->nama_lengkap }}</td>
                                    <td>{{ $driver->telp }}</td>
                                    <td class="text-right">
                                        {{ number_format($driver->deposit, 0, ',', '.') }}
                                    </td>
                                    <td class="text-right">
                                        {{ number_format($driver->kasbon, 0, ',', '.') }}
                                    </td>
                                    <td class="text-right">
                                        {{ number_format($driver->bayar_kasbon, 0, ',', '.') }}
                                    </td>
                                    <td class="text-right">
                                        {{ number_format($driver->tabungan, 0, ',', '.') }}
                                    </td>
                                    {{-- <td>{{  number_format($driver->tabungan, 0, ',', '.')}}</td> --}}
                                    <td class="text-center">
                                        {{-- @if (auth()->check() && auth()->user()->fitur['driver show']) --}}
                                        <a href="{{ url('admin/driver/' . $driver->id . '/edit') }}"
                                            class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ url('admin/driver/' . $driver->id) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        {{-- @endif --}}
                                        {{-- @if (auth()->check() && auth()->user()->fitur['driver update']) --}}
                                        {{-- <td>
                                        <a href="{{ url('admin/driver/' . $driver->id . '/edit') }}"
                                            class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td> --}}
                                        {{-- @endif --}}
                                        {{-- @if (auth()->check() && auth()->user()->fitur['driver delete'])
                                        <button type="submit" class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#modal-hapus-{{ $driver->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        {{-- <tbody>
                            <?php $totalTabungan = 0; ?>
                            @foreach ($drivers as $driver)
                                <tr>
                                </tr>
                                    <?php $totalTabungan += $driver->tabungan; ?>
                            @endforeach
                            <tr>
                                <td colspan="5"></td>
                                <td><strong>Total Deposit:</strong></td>
                                <td class="text-right" style="font-weight: bold;">
                                    Rp.{{ number_format($totalTabungan, 0, ',', '.') }}
                                </td>
                                <td>
                                </td>
                            </tr>
                        </tbody> --}}
                        <tbody>
                            <?php $totalTabungan = 0; ?>
                            <?php $totalDeposit = 0; ?>
                            <?php $totalKasbon = 0; ?>
                            <?php $totalBayar = 0; ?>
                            @foreach ($drivers as $driver)
                                <tr>
                                </tr>
                                <?php $totalTabungan += $driver->tabungan; ?>
                                <?php $totalDeposit += $driver->deposit; ?>
                                <?php $totalKasbon += $driver->kasbon; ?>
                                <?php $totalBayar += $driver->bayar_kasbon; ?>
                            @endforeach
                            <tr>
                                <td colspan="1"></td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td><strong>Total:</strong></td>
                                <td class="text-right" style="font-weight: bold;">
                                    Rp.{{ number_format($totalDeposit, 0, ',', '.') }}
                                </td>
                                <td class="text-right" style="font-weight: bold;">
                                    Rp.{{ number_format($totalKasbon, 0, ',', '.') }}
                                </td>
                                <td class="text-right" style="font-weight: bold;">
                                    Rp.{{ number_format($totalBayar, 0, ',', '.') }}
                                </td>
                                <td class="text-right" style="font-weight: bold;">
                                    Rp.{{ number_format($totalTabungan, 0, ',', '.') }}
                                </td>
                                {{-- <td>
                                </td> --}}
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <script>
        function printCetak(form) {
            form.action = "{{ url('admin/print_sopir') }}";
            form.submit();
        }

        function printExport(form) {
            form.action = "{{ url('admin/driver/rekapexport') }}"; // Adjust the URL accordingly
            form.submit();
        }
    </script>

@endsection
