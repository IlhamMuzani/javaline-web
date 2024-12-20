@extends('layouts.app')

@section('title', 'Inquery Penerimaan Return')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Inquery Penerimaan Return Barang</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Inquery Penerimaan Return Barang</li>
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
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Inquery Penerimaan Return Barang</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="GET" id="form-action">
                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <select class="custom-select form-control" id="statusx" name="statusx">
                                    <option value="">- Pilih Return -</option>
                                    <option selected value="penerimaan">Penerimaan Return Barang</option>
                                    <option value="nota">Nota Return Barang</option>
                                    <option value="penjualan">Penjualan Return Barang</option>
                                </select>
                                <label for="statusx">(Kategori Return)</label>
                            </div>
                            <div class="col-md-2 mb-3">
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
                                    <th>Kode Surat Return</th>
                                    <th>No Surat Jalan</th>
                                    <th>Tanggal</th>
                                    <th>Admin</th>
                                    <th>Pelanggan</th>
                                    <th style="width:20px">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inquery as $returnekspedisi)
                                    <tr id="editMemoekspedisi" data-toggle="modal"
                                        data-target="#modal-posting-{{ $returnekspedisi->id }}" style="cursor: pointer;">
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $returnekspedisi->kode_return }}</td>
                                        <td>{{ $returnekspedisi->nomor_suratjalan }}</td>
                                        <td>{{ $returnekspedisi->tanggal_awal }}</td>
                                        <td>
                                            {{ $returnekspedisi->admin }}
                                        </td>
                                        <td>
                                            {{ $returnekspedisi->nama_pelanggan }}
                                        </td>
                                        <td class="text-center">
                                            @if ($returnekspedisi->status == 'posting')
                                                <button type="button" class="btn btn-success btn-sm">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="modal-posting-{{ $returnekspedisi->id }}">
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
                                                        <strong>{{ $returnekspedisi->kode_return }}</strong>
                                                    </p>
                                                    @if ($returnekspedisi->status == 'unpost')
                                                        @if (auth()->check() && auth()->user()->fitur['inquery return penerimaan barang delete'])
                                                            <form method="GET"
                                                                action="{{ route('hapusreturn', ['id' => $returnekspedisi->id]) }}">
                                                                <button type="submit"
                                                                    class="btn btn-outline-danger btn-block mt-2">
                                                                    <i class="fas fa-trash-alt"></i> Delete
                                                                </button>
                                                            </form>
                                                        @endif
                                                        @if (auth()->check() && auth()->user()->fitur['inquery return penerimaan barang show'])
                                                            <a href="{{ url('admin/inquery_returnekspedisi/' . $returnekspedisi->id) }}"
                                                                type="button" class="btn btn-outline-info btn-block">
                                                                <i class="fas fa-eye"></i> Show
                                                            </a>
                                                        @endif
                                                        @if (auth()->check() && auth()->user()->fitur['inquery return penerimaan barang update'])
                                                            <a href="{{ url('admin/inquery_returnekspedisi/' . $returnekspedisi->id . '/edit') }}"
                                                                type="button" class="btn btn-outline-warning btn-block">
                                                                <i class="fas fa-edit"></i> Update
                                                            </a>
                                                        @endif
                                                        @if (auth()->check() && auth()->user()->fitur['inquery return penerimaan barang posting'])
                                                            <form method="GET"
                                                                action="{{ route('postingreturn', ['id' => $returnekspedisi->id]) }}">
                                                                <button type="submit"
                                                                    class="btn btn-outline-success btn-block mt-2">
                                                                    <i class="fas fa-check"></i> Posting
                                                                </button>
                                                            </form>
                                                        @endif
                                                    @endif
                                                    @if ($returnekspedisi->status == 'posting')
                                                        @if (auth()->check() && auth()->user()->fitur['inquery return penerimaan barang show'])
                                                            <a href="{{ url('admin/inquery_returnekspedisi/' . $returnekspedisi->id) }}"
                                                                type="button" class="btn btn-outline-info btn-block">
                                                                <i class="fas fa-eye"></i> Show
                                                            </a>
                                                        @endif
                                                        @if (auth()->check() && auth()->user()->fitur['inquery return penerimaan barang unpost'])
                                                            <form method="GET"
                                                                action="{{ route('unpostreturn', ['id' => $returnekspedisi->id]) }}">
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
            form.action = "{{ url('admin/inquery_returnekspedisi') }}";
            form.submit();
        }
    </script>

    {{-- untuk klik 2 kali ke edit  --}}
    {{-- <script>
        document.getElementById('editMemoekspedisi').addEventListener('dblclick', function() {
            window.location.href = "{{ url('admin/inquery_returnekspedisi/' . $returnekspedisi->id . '/edit') }}";
        });
    </script> --}}

    <script>
        $(document).ready(function() {
            // Detect the change event on the 'status' dropdown
            $('#statusx').on('change', function() {
                // Get the selected value
                var selectedValue = $(this).val();

                // Check the selected value and redirect accordingly
                switch (selectedValue) {
                    case 'penerimaan':
                        window.location.href = "{{ url('admin/inquery_returnekspedisi') }}";
                        break;
                    case 'nota':
                        window.location.href = "{{ url('admin/inquery_notareturn') }}";
                        break;
                    case 'penjualan':
                        window.location.href = "{{ url('admin/inquery_fakturpenjualanreturn') }}";
                        break;
                    default:
                        // Handle other cases or do nothing
                        break;
                }
            });
        });
    </script>

@endsection
