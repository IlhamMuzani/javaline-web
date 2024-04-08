@extends('layouts.app')

@section('title', 'Inquery Memo Borong')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Inquery Memo Borong</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Inquery Memo Borong</li>
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
                    <h3 class="card-title">Data Inquery Memo Borong</h3>
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
                                <th>No Memo</th>
                                <th>Tanggal</th>
                                <th>Sopir</th>
                                <th>No Kabin</th>
                                <th>Rute</th>
                                <th style="text-align: center">Harga</th>
                                <th style="text-align: center">qty</th>
                                <th style="text-align: center">Total</th>
                                <th style="text-align: center">PPH</th>
                                <th style="text-align: center">Adm</th>
                                <th style="text-align: center">Deposit Sopir</th>
                                <th style="text-align: center">Grand Total</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inquery as $memoborong)
                                <tr id="editMemoekspedisi" data-toggle="modal"
                                    data-target="#modal-posting-{{ $memoborong->id }}" style="cursor: pointer;">
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $memoborong->kode_memo }}</td>
                                    <td>{{ $memoborong->tanggal_awal }}</td>
                                    <td>

                                        {{ explode(' ', $memoborong->nama_driver)[0] }}
                                    </td>
                                    <td>
                                        {{ $memoborong->no_kabin }}
                                    </td>
                                    <td>
                                        @if ($memoborong->nama_rute == null)
                                            {{ $memoborong->detail_memo->first()->nama_rutes }}
                                        @else
                                            {{ $memoborong->nama_rute }}
                                        @endif
                                    </td>
                                    <td style="text-align: end">
                                        {{ number_format($memoborong->harga_rute, 0, ',', '.') }}
                                    </td>
                                    <td style="text-align: end">
                                        {{ $memoborong->jumlah }}
                                    </td>
                                    <td style="text-align: end">
                                        @if ($memoborong->totalrute == null)
                                            0
                                        @else
                                            {{ number_format($memoborong->totalrute, 0, ',', '.') }}
                                        @endif
                                    </td>
                                    <td style="text-align: end">
                                        {{ number_format($memoborong->pphs, 0, ',', '.') }}
                                    </td>
                                    <td style="text-align: end">
                                        {{ number_format($memoborong->uang_jaminans, 0, ',', '.') }}
                                    </td>
                                    <td style="text-align: end">
                                        {{ number_format($memoborong->deposit_drivers, 0, ',', '.') }}
                                    </td>
                                    <td style="text-align: end">
                                        {{ number_format($memoborong->sub_total, 0, ',', '.') }}
                                    </td>
                                    <td class="text-center">
                                        @if ($memoborong->status == 'posting')
                                            <button type="button" class="btn btn-success btn-sm">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            {{-- <button type="button" class="btn btn-primary btn-sm">
                                                <i class="fas fa-truck-moving"></i>
                                            </button> --}}
                                        @endif

                                    </td>
                                </tr>
                                <div class="modal fade" id="modal-posting-{{ $memoborong->id }}">
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
                                                <p>Memo Borong
                                                    <strong>{{ $memoborong->kode_memo }}</strong>
                                                </p>
                                                @if ($memoborong->status == 'unpost')
                                                    @if (auth()->check() && auth()->user()->fitur['inquery memo borong delete'])
                                                        <form method="GET"
                                                            action="{{ route('hapusmemoborong', ['id' => $memoborong->id]) }}">
                                                            <button type="submit"
                                                                class="btn btn-outline-danger btn-block mt-2">
                                                                <i class="fas fa-trash-alt"></i> Delete
                                                            </button>
                                                        </form>
                                                    @endif
                                                    @if (auth()->check() && auth()->user()->fitur['inquery memo borong show'])
                                                        <a href="{{ url('admin/inquery_memoborong/' . $memoborong->id) }}"
                                                            type="button" class="btn btn-outline-info btn-block">
                                                            <i class="fas fa-eye"></i> Show
                                                        </a>
                                                    @endif
                                                    @if (auth()->check() && auth()->user()->fitur['inquery memo borong update'])
                                                        <a href="{{ url('admin/inquery_memoborong/' . $memoborong->id . '/edit') }}"
                                                            type="button" class="btn btn-outline-warning btn-block">
                                                            <i class="fas fa-edit"></i> Update
                                                        </a>
                                                    @endif
                                                    @if (auth()->check() && auth()->user()->fitur['inquery memo borong posting'])
                                                        <form method="GET"
                                                            action="{{ route('postingmemoborong', ['id' => $memoborong->id]) }}">
                                                            <button type="submit"
                                                                class="btn btn-outline-success btn-block mt-2">
                                                                <i class="fas fa-check"></i> Posting
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endif
                                                @if ($memoborong->status == 'posting')
                                                    @if (auth()->check() && auth()->user()->fitur['inquery memo borong show'])
                                                        <a href="{{ url('admin/inquery_memoborong/' . $memoborong->id) }}"
                                                            type="button" class="btn btn-outline-info btn-block">
                                                            <i class="fas fa-eye"></i> Show
                                                        </a>
                                                    @endif
                                                    @if (auth()->check() && auth()->user()->fitur['inquery memo borong unpost'])
                                                        <form method="GET"
                                                            action="{{ route('unpostmemoborong', ['id' => $memoborong->id]) }}">
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
            form.action = "{{ url('admin/inquery_memoborong') }}";
            form.submit();
        }
    </script>

@endsection
