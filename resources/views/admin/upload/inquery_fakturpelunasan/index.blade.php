@extends('layouts.app')

@section('title', 'Inquery Faktur Pelunasan')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Inquery Faktur Pelunasan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Inquery Faktur Pelunasan</li>
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
                    <h3 class="card-title">Data Inquery Faktur Pelunasan</h3>
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
                    <table id="example1" class="table table-bordered table-striped" style="font-size: 13px">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>No Faktur</th>
                                <th>Tanggal</th>
                                <th>Admin</th>
                                <th>Pelanggan</th>
                                {{-- <th>PPH</th> --}}
                                <th style="text-align: end">Total</th>
                                <th style="width: 20px">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inquery as $fakturpelunasan)
                                <tr id="editMemoekspedisi" data-toggle="modal"
                                    data-target="#modal-posting-{{ $fakturpelunasan->id }}" style="cursor: pointer;">
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $fakturpelunasan->kode_pelunasan }}</td>
                                    <td>{{ $fakturpelunasan->tanggal_awal }}</td>
                                    <td>
                                        {{ $fakturpelunasan->user->karyawan->nama_lengkap }}
                                    </td>
                                    <td>
                                        {{ $fakturpelunasan->nama_pelanggan }}
                                    </td>
                                    {{-- <td style="text-align: end">
                                        {{ number_format($fakturpelunasan->pph, 0, ',', '.') }}
                                    </td> --}}
                                    <td style="text-align: end">
                                        {{ number_format($fakturpelunasan->totalpembayaran, 0, ',', '.') }}
                                    </td>
                                    <td class="text-center">
                                        @if ($fakturpelunasan->status == 'posting')
                                            <button type="button" class="btn btn-success btn-sm">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            {{-- <button type="button" class="btn btn-primary btn-sm">
                                                <i class="fas fa-truck-moving"></i>
                                            </button> --}}
                                        @endif
                                    </td>
                                </tr>
                                <div class="modal fade" id="modal-posting-{{ $fakturpelunasan->id }}">
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
                                                <p>Memo ekspedisi
                                                    <strong>{{ $fakturpelunasan->kode_pelunasan }}</strong>
                                                </p>
                                                @if ($fakturpelunasan->status == 'unpost')
                                                    @if (auth()->check() && auth()->user()->fitur['inquery pelunasan ekspedisi delete'])
                                                        <form method="GET"
                                                            action="{{ route('hapuspelunasan', ['id' => $fakturpelunasan->id]) }}">
                                                            <button type="submit"
                                                                class="btn btn-outline-danger btn-block mt-2">
                                                                <i class="fas fa-trash-alt"></i> Delete
                                                            </button>
                                                        </form>
                                                    @endif
                                                    @if (auth()->check() && auth()->user()->fitur['inquery pelunasan ekspedisi show'])
                                                        <a href="{{ url('admin/inquery_fakturpelunasan/' . $fakturpelunasan->id) }}"
                                                            type="button" class="btn btn-outline-info btn-block">
                                                            <i class="fas fa-eye"></i> Show
                                                        </a>
                                                    @endif
                                                    @if (auth()->check() && auth()->user()->fitur['inquery pelunasan ekspedisi update'])
                                                        <a href="{{ url('admin/inquery_fakturpelunasan/' . $fakturpelunasan->id . '/edit') }}"
                                                            type="button" class="btn btn-outline-warning btn-block">
                                                            <i class="fas fa-edit"></i> Update
                                                        </a>
                                                    @endif
                                                    @if (auth()->check() && auth()->user()->fitur['inquery pelunasan ekspedisi posting'])
                                                        <form method="GET"
                                                            action="{{ route('postingpelunasan', ['id' => $fakturpelunasan->id]) }}">
                                                            <button type="submit"
                                                                class="btn btn-outline-success btn-block mt-2">
                                                                <i class="fas fa-check"></i> Posting
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endif
                                                @if ($fakturpelunasan->status == 'posting')
                                                    @if (auth()->check() && auth()->user()->fitur['inquery pelunasan ekspedisi show'])
                                                    <a href="{{ url('admin/inquery_fakturpelunasan/' . $fakturpelunasan->id) }}"
                                                        type="button" class="btn btn-outline-info btn-block">
                                                        <i class="fas fa-eye"></i> Show
                                                    </a>
                                                    @endif
                                                    @if (auth()->check() && auth()->user()->fitur['inquery pelunasan ekspedisi unpost'])
                                                    <form method="GET"
                                                        action="{{ route('unpostpelunasan', ['id' => $fakturpelunasan->id]) }}">
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
            form.action = "{{ url('admin/inquery_fakturpelunasan') }}";
            form.submit();
        }
    </script>

    {{-- untuk klik 2 kali ke edit  --}}
    {{-- <script>
        document.getElementById('editMemoekspedisi').addEventListener('dblclick', function() {
            window.location.href = "{{ url('admin/inquery_fakturpelunasan/' . $fakturpelunasan->id . '/edit') }}";
        });
    </script> --}}

@endsection
