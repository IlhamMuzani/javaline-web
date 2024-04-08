@extends('layouts.app')

@section('title', 'Inquery Faktur Ekspedisi')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Inquery Faktur Ekspedisi</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Inquery Faktur Ekspedisi</li>
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
                    <h3 class="card-title">Inquery Faktur Ekspedisi</h3>
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
                                <th>Faktur Ekspedisi</th>
                                <th>Tanggal</th>
                                <th>Kategori</th>
                                <th>No Kabin</th>
                                <th>Sopir</th>
                                <th>Tujuan</th>
                                <th>Pelanggan</th>
                                <th>Tarif</th>
                                <th>PPH</th>
                                <th>U. Tambahan</th>
                                <th>Total</th>
                                <th class="text-center" width="20">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inquery as $faktur)
                                <tr id="editMemoekspedisi" data-toggle="modal"
                                    data-target="#modal-posting-{{ $faktur->id }}" style="cursor: pointer;">
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>
                                        {{ $faktur->kode_faktur }}
                                    </td>
                                    <td>
                                        {{ $faktur->tanggal_awal }}
                                    </td>
                                    <td>
                                        {{ $faktur->kategori }}
                                    </td>
                                    <td>
                                        {{ $faktur->detail_faktur->first()->no_kabin }}
                                    </td>
                                    <td>
                                        {{ $faktur->detail_faktur->first()->nama_driver }} </td>
                                    <td>
                                        {{ $faktur->detail_faktur->first()->nama_rute }} </td>
                                    <td>
                                        {{ $faktur->nama_pelanggan }}
                                    </td>
                                    <td>
                                        Rp. {{ number_format($faktur->total_tarif, 0, ',', '.') }}</td>
                                    <td>
                                        Rp. {{ number_format($faktur->pph, 0, ',', '.') }}</td>
                                    <td>
                                        Rp. {{ number_format($faktur->biaya_tambahan, 0, ',', '.') }}</td>
                                    <td> Rp. {{ number_format($faktur->grand_total, 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        @if ($faktur->status == 'posting')
                                            <button type="button" class="btn btn-success btn-sm">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            {{-- <button type="button" class="btn btn-primary btn-sm">
                                                <i class="fas fa-truck-moving"></i>
                                            </button> --}}
                                        @endif
                                    </td>
                                </tr>
                                <div class="modal fade" id="modal-posting-{{ $faktur->id }}">
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
                                                <p>Faktur ekspedisi
                                                    <strong>{{ $faktur->kode_faktur }}</strong>
                                                </p>
                                                @if ($faktur->status == 'unpost')
                                                    @if (auth()->check() && auth()->user()->fitur['inquery faktur ekspedisi delete'])
                                                        <form method="GET"
                                                            action="{{ route('hapusfaktur', ['id' => $faktur->id]) }}">
                                                            <button type="submit"
                                                                class="btn btn-outline-danger btn-block mt-2">
                                                                <i class="fas fa-trash-alt"></i> Delete
                                                            </button>
                                                        </form>
                                                    @endif
                                                    @if (auth()->check() && auth()->user()->fitur['inquery faktur ekspedisi show'])
                                                        <a href="{{ url('admin/inquery_fakturekspedisi/' . $faktur->id) }}"
                                                            type="button" class="btn btn-outline-info btn-block">
                                                            <i class="fas fa-eye"></i> Show
                                                        </a>
                                                    @endif
                                                    @if (auth()->check() && auth()->user()->fitur['inquery faktur ekspedisi update'])
                                                        <a href="{{ url('admin/inquery_fakturekspedisi/' . $faktur->id . '/edit') }}"
                                                            type="button" class="btn btn-outline-warning btn-block">
                                                            <i class="fas fa-edit"></i> Update
                                                        </a>
                                                    @endif
                                                    @if (auth()->check() && auth()->user()->fitur['inquery faktur ekspedisi posting'])
                                                        <form method="GET"
                                                            action="{{ route('postingfaktur', ['id' => $faktur->id]) }}">
                                                            <button type="submit"
                                                                class="btn btn-outline-success btn-block mt-2">
                                                                <i class="fas fa-check"></i> Posting
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endif
                                                @if ($faktur->status == 'posting')
                                                    @if (auth()->check() && auth()->user()->fitur['inquery faktur ekspedisi show'])
                                                        <a href="{{ url('admin/inquery_fakturekspedisi/' . $faktur->id) }}"
                                                            type="button" class="btn btn-outline-info btn-block">
                                                            <i class="fas fa-eye"></i> Show
                                                        </a>
                                                    @endif
                                                    @if (auth()->check() && auth()->user()->fitur['inquery faktur ekspedisi unpost'])
                                                        <form method="GET"
                                                            action="{{ route('unpostfaktur', ['id' => $faktur->id]) }}">
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
            form.action = "{{ url('admin/inquery_fakturekspedisi') }}";
            form.submit();
        }
    </script>
@endsection
