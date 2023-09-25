@extends('layouts.app')

@section('title', 'Update KM')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Update KM</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Update Km</li>
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
                    <h3 class="card-title">Data Kilo Meter</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="GET" id="form-action">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <select class="custom-select form-control" id="status" name="status_post">
                                    <option value="">- Semua Status -</option>
                                    <option value="posting"
                                        {{ Request::get('status_post') == 'posting' ? 'selected' : '' }}>
                                        Posting
                                    </option>
                                    <option value="unpost" {{ Request::get('status_post') == 'unpost' ? 'selected' : '' }}>
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
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Nama User</th>
                                <th>No Kabin</th>
                                <th>Km Update</th>
                                <th>Tanggal</th>
                                <th class="text-center" width="120">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inquery as $kendaraan)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>
                                        {{ $kendaraan->nama_security }}
                                    </td>
                                    <td>
                                        <a href="#" style="color: #000000;" data-toggle="modal"
                                            data-target="#modal-pilih-{{ $kendaraan->id }}">
                                            {{ $kendaraan->no_kabin }}
                                        </a>
                                    </td>
                                    <td>
                                        <a href="#" style="color: #000000;" data-toggle="modal"
                                            data-target="#modal-pilih-{{ $kendaraan->id }}">
                                            {{ $kendaraan->km }}
                                        </a>
                                    </td>
                                    <td>
                                        <a href="#" style="color: #000000;" data-toggle="modal"
                                            data-target="#modal-pilih-{{ $kendaraan->id }}">
                                            {{ $kendaraan->tanggal_awal }}
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        @if ($kendaraan->status_post == 'unpost')
                                            <a href="{{ url('admin/lihat_kendaraan/' . $kendaraan->id) }}"
                                                class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ url('admin/edit_kendaraan/' . $kendaraan->id) }}"
                                                class="btn btn-info btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#modal-hapus-{{ $kendaraan->id }}">
                                                <i class="fas fa-times"></i>
                                            </button>
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                                data-target="#modal-posting-{{ $kendaraan->id }}">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        @endif
                                        @if ($kendaraan->status_post == 'posting')
                                            <a href="{{ url('admin/lihat_kendaraan/' . $kendaraan->id) }}"
                                                class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                                data-target="#modal-unpost-{{ $kendaraan->id }}">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                                <div class="modal fade" id="modal-hapus-{{ $kendaraan->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Hapus update</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Yakin hapus update km
                                                    <strong>{{ $kendaraan->km }}</strong>?
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Batal</button>
                                                <a class="btn btn-primary"
                                                    href="{{ route('deletekm', ['id' => $kendaraan->id]) }}">Ya
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="modal-unpost-{{ $kendaraan->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">UNPOST</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Unpost update km
                                                    <strong>{{ $kendaraan->km }}</strong>?
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Batal</button>
                                                <a class="btn btn-primary"
                                                    href="{{ route('unpostkm', ['id' => $kendaraan->id]) }}">Ya
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="modal-posting-{{ $kendaraan->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">POSTING</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Posting pembelian update km
                                                    <strong>{{ $kendaraan->km }}</strong>?
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Batal</button>
                                                <a class="btn btn-primary"
                                                    href="{{ route('postingkm', ['id' => $kendaraan->id]) }}">Ya</a>
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
            form.action = "{{ url('admin/inquery_km') }}";
            form.submit();
        }
    </script>
@endsection
