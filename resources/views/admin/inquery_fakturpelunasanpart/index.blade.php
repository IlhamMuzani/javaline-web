@extends('layouts.app')

@section('title', 'Inquery Pelunasan Faktur Pembelian Part')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Inquery Pelunasan Faktur Pembelian Part</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Inquery Pelunasan Faktur Pembelian Part</li>
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
                        <i class="icon fas fa-check"></i> Berhasil!
                    </h5>
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-ban"></i> Gagal!
                    </h5>
                    {{ session('error') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Inquery Pelunasan Faktur Pembelian Part</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="GET" id="form-action">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <select class="custom-select form-control" id="status" name="status">
                                    <option value="">- Semua Status -</option>
                                    <option value="posting" {{ Request::get('status') == 'posting' ? 'selected' : '' }}>
                                        Posting
                                    </option>
                                    <option value="unpost" {{ Request::get('status') == 'unpost' ? 'selected' : '' }}>
                                        Unpost</option>
                                </select>
                                <label for="status">(Pilih Status)</label>
                            </div>
                            <div class="col-md-3 mb-3">
                                <input class="form-control" id="tanggal_awal" name="tanggal_awal" type="date"
                                    value="{{ Request::get('tanggal_awal') }}" max="{{ date('Y-m-d') }}" />
                                <label for="tanggal_awal">(Tanggal Awal)</label>
                            </div>
                            <div class="col-md-3 mb-3">
                                <input class="form-control" id="tanggal_akhir" name="tanggal_akhir" type="date"
                                    value="{{ Request::get('tanggal_akhir') }}" max="{{ date('Y-m-d') }}" />
                                <label for="tanggal_awal">(Tanggal Akhir)</label>
                            </div>
                            <div class="col-md-2 mb-3">
                                <button type="button" class="btn btn-outline-primary mr-2" onclick="cari()">
                                    <i class="fas fa-search"></i> Cari
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
                                    <th>No Faktur </th>
                                    <th>Tanggal</th>
                                    <th>Admin</th>
                                    <th>Supplier</th>
                                    {{-- <th>PPH</th> --}}
                                    <th style="text-align: end">Total</th>
                                    <th style="width: 20px">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inquery as $fakturpelunasanpart)
                                    <tr id="editMemoekspedisi" data-toggle="modal"
                                        data-target="#modal-posting-{{ $fakturpelunasanpart->id }}"
                                        style="cursor: pointer;">
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $fakturpelunasanpart->kode_pelunasanpart }}</td>
                                        <td>{{ $fakturpelunasanpart->tanggal_awal }}</td>
                                        <td>
                                            {{ $fakturpelunasanpart->user->karyawan->nama_lengkap }}
                                        </td>
                                        <td>
                                            {{ $fakturpelunasanpart->nama_supplier }}
                                        </td>
                                        {{-- <td style="text-align: end">
                                        {{ number_format($fakturpelunasanpart->pph, 0, ',', '.') }}
                                    </td> --}}
                                        <td style="text-align: end">
                                            {{ number_format($fakturpelunasanpart->totalpembayaran, 0, ',', '.') }}
                                        </td>
                                        <td class="text-center">
                                            @if ($fakturpelunasanpart->status == 'posting')
                                                <button type="button" class="btn btn-success btn-sm">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                {{-- <button type="button" class="btn btn-primary btn-sm">
                                                <i class="fas fa-truck-moving"></i>
                                            </button> --}}
                                            @endif
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="modal-posting-{{ $fakturpelunasanpart->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Opsi menu</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Pelunasan Faktur Pembelian Part
                                                        <strong>{{ $fakturpelunasanpart->kode_pelunasan }}</strong>
                                                    </p>
                                                    @if ($fakturpelunasanpart->status == 'unpost')
                                                        @if (auth()->check() && auth()->user()->fitur['inquery pelunasan faktur pembelian part delete'])
                                                            <form method="GET"
                                                                action="{{ route('hapuspelunasanpart', ['id' => $fakturpelunasanpart->id]) }}">
                                                                <button type="submit"
                                                                    class="btn btn-outline-danger btn-block mt-2">
                                                                    <i class="fas fa-trash-alt"></i> Delete
                                                                </button>
                                                            </form>
                                                        @endif
                                                        @if (auth()->check() && auth()->user()->fitur['inquery pelunasan faktur pembelian part show'])
                                                            <a href="{{ url('admin/inquery_partpembelianlunas/' . $fakturpelunasanpart->id) }}"
                                                                type="button" class="btn btn-outline-info btn-block">
                                                                <i class="fas fa-eye"></i> Show
                                                            </a>
                                                        @endif
                                                        @if (auth()->check() && auth()->user()->fitur['inquery pelunasan faktur pembelian part update'])
                                                            <a href="{{ url('admin/inquery_partpembelianlunas/' . $fakturpelunasanpart->id . '/edit') }}"
                                                                type="button" class="btn btn-outline-warning btn-block">
                                                                <i class="fas fa-edit"></i> Update
                                                            </a>
                                                        @endif
                                                        @if (auth()->check() && auth()->user()->fitur['inquery pelunasan faktur pembelian part posting'])
                                                            <form method="GET"
                                                                action="{{ route('postingpelunasanpart', ['id' => $fakturpelunasanpart->id]) }}">
                                                                <button type="submit"
                                                                    class="btn btn-outline-success btn-block mt-2">
                                                                    <i class="fas fa-check"></i> Posting
                                                                </button>
                                                            </form>
                                                        @endif
                                                    @endif
                                                    @if ($fakturpelunasanpart->status == 'posting')
                                                        @if (auth()->check() && auth()->user()->fitur['inquery pelunasan faktur pembelian part show'])
                                                            <a href="{{ url('admin/inquery_partpembelianlunas/' . $fakturpelunasanpart->id) }}"
                                                                type="button" class="btn btn-outline-info btn-block">
                                                                <i class="fas fa-eye"></i> Show
                                                            </a>
                                                        @endif
                                                        @if (auth()->check() && auth()->user()->fitur['inquery pelunasan faktur pembelian part unpost'])
                                                            <form method="GET"
                                                                action="{{ route('unpostpelunasanpart', ['id' => $fakturpelunasanpart->id]) }}">
                                                                <button type="submit"
                                                                    class="btn btn-outline-primary btn-block mt-2">
                                                                    <i class="fas fa-check"></i> Unpost
                                                                </button>
                                                            </form>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
            }

            tanggalAkhir.value = "";
            var today = new Date().toISOString().split('T')[0];
            tanggalAkhir.value = today;
            tanggalAkhir.setAttribute('min', this.value);
        });

        var form = document.getElementById('form-action');

        function cari() {
            form.action = "{{ url('admin/inquery_partpembelianlunas') }}";
            form.submit();
        }
    </script>

    {{-- untuk klik 2 kali ke edit  --}}
    {{-- <script>
        document.getElementById('editMemoekspedisi').addEventListener('dblclick', function() {
            window.location.href = "{{ url('admin/inquery_fakturpelunasan/' . $fakturpelunasanpart->id . '/edit') }}";
        });
    </script> --}}

@endsection
