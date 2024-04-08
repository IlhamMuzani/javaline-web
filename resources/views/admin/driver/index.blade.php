@extends('layouts.app')

@section('title', 'Data Driver')

@section('content')
    <div class="content-header">
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
                                    {{-- <td class="text-center">
                                        @if (auth()->check() && auth()->user()->fitur['driver show'])
                                        <a href="{{ url('admin/driver/' . $driver->id) }}"
                                                class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        @endif --}}
                                    {{-- @if (auth()->check() && auth()->user()->fitur['driver update']) --}}
                                    <td>
                                        <a href="{{ url('admin/driver/' . $driver->id . '/edit') }}"
                                            class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                    {{-- @endif --}}
                                    {{-- @if (auth()->check() && auth()->user()->fitur['driver delete'])
                                        <button type="submit" class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#modal-hapus-{{ $driver->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif --}}
                                    {{-- </td> --}}
                                </tr>
                                <div class="modal fade" id="modal-hapus-{{ $driver->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Hapus Driver</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Yakin hapus driver <strong>{{ $driver->nama }}</strong>?</p>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Batal</button>
                                                <form action="{{ url('admin/driver/' . $driver->id) }}" method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="modal-qrcode-{{ $driver->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Gambar QR Code</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div style="text-align: center;">
                                                    <p style="font-size:20px; font-weight: bold;">
                                                        {{ $driver->kode_karyawan }}</p>
                                                    <div style="display: inline-block;">
                                                        {!! DNS2D::getBarcodeHTML("$driver->qrcode_karyawan", 'QRCODE', 15, 15) !!}
                                                    </div>
                                                    <p style="font-size:20px; font-weight: bold;">
                                                        {{ $driver->nama_lengkap }}</p>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">Batal</button>
                                                    <a href="{{ url('admin/driver/cetak-pdf/' . $driver->id) }}"
                                                        class="btn btn-primary btn-sm">
                                                        <i class=""></i> Cetak
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
