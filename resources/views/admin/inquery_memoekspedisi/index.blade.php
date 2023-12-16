@extends('layouts.app')

@section('title', 'Inquery Memo Perjalanan')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Inquery Memo Perjalanan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Inquery Memo Perjalanan</li>
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
                    <h3 class="card-title">Data Inquery Memo Perjalanan</h3>
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
                                <th>Type Memo</th>
                                <th>Rute</th>
                                <th>U. Jalan</th>
                                <th>U. Tambah</th>
                                {{-- <th>Deposit</th>
                                <th>Uang Jaminan</th> --}}
                                <th>Total</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inquery as $memoekspedisi)
                                <tr id="editMemoekspedisi" data-toggle="modal"
                                    data-target="#modal-posting-{{ $memoekspedisi->id }}" style="cursor: pointer;">
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $memoekspedisi->kode_memo }}</td>
                                    <td>{{ $memoekspedisi->tanggal_awal }}</td>
                                    <td>
                                        @if ($memoekspedisi->kategori == 'Memo Tambahan')
                                            {{ explode(' ', $memoekspedisi->memotambahan->memo->nama_driver)[0] }}
                                        @else
                                            {{ explode(' ', $memoekspedisi->nama_driver)[0] }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($memoekspedisi->kategori == 'Memo Tambahan')
                                            {{ $memoekspedisi->memotambahan->memo->no_kabin }}
                                        @else
                                            {{ $memoekspedisi->no_kabin }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($memoekspedisi->kategori == 'Memo Perjalanan')
                                            Perjalanan
                                        @elseif($memoekspedisi->kategori == 'Memo Borong')
                                            Borong
                                        @elseif($memoekspedisi->kategori == 'Memo Tambahan')
                                            Tambahan
                                        @endif
                                    </td>
                                    <td>
                                        @if ($memoekspedisi->kategori == 'Memo Tambahan')
                                        @else
                                            @if ($memoekspedisi->nama_rute == null)
                                                {{ $memoekspedisi->detail_memo->first()->nama_rutes }}
                                            @else
                                                {{ $memoekspedisi->nama_rute }}
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        @if ($memoekspedisi->uang_jalan == null)
                                            0
                                        @else
                                            {{ number_format($memoekspedisi->uang_jalan, 0, ',', '.') }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($memoekspedisi->kategori == 'Memo Tambahan')
                                            {{ number_format($memoekspedisi->memotambahan->grand_total, 0, ',', '.') }}
                                        @else
                                            @if ($memoekspedisi->biaya_tambahan == null)
                                                0
                                            @else
                                                {{ number_format($memoekspedisi->biaya_tambahan, 0, ',', '.') }}
                                            @endif
                                        @endif

                                    </td>
                                    {{-- <td>
                                        @if ($memoekspedisi->deposit_driver == null)
                                            0
                                        @else
                                            {{ number_format($memoekspedisi->deposit_driver, 0, ',', '.') }}
                                        @endif
                                    </td> --}}
                                    {{-- <td>
                                        @if ($memoekspedisi->uang_jaminan == null)
                                            0
                                        @else
                                            {{ number_format($memoekspedisi->uang_jaminan, 0, ',', '.') }}
                                        @endif
                                    </td> --}}
                                    {{-- <td>
                                        @if ($memoekspedisi->uang_jaminan == null)
                                            0
                                        @else
                                            {{ number_format($memoekspedisi->uang_jaminan, 0, ',', '.') }}
                                        @endif
                                    </td> --}}
                                    <td style="text-align: end" data-toggle="modal"
                                        data-target="#modal-posting-{{ $memoekspedisi->id }}">
                                        @if ($memoekspedisi->kategori == 'Memo Tambahan')
                                            {{ number_format($memoekspedisi->memotambahan->grand_total, 0, ',', '.') }}
                                        @else
                                            @if ($memoekspedisi->kategori == 'Memo Borong')
                                                {{ number_format(($memoekspedisi->total_borongs - $memoekspedisi->pphs - $memoekspedisi->uang_jaminans - $memoekspedisi->deposit_drivers) / 2, 0, ',', '.') }}
                                            @else
                                                @if ($memoekspedisi->biaya_tambahan == 0)
                                                    {{ number_format($memoekspedisi->uang_jalan - $memoekspedisi->potongan_memo - $memoekspedisi->deposit_driver - $memoekspedisi->uang_jaminan, 0, ',', '.') }}
                                                @endif
                                                @if ($memoekspedisi->potongan_memo == 0)
                                                    {{ number_format($memoekspedisi->uang_jalan + $memoekspedisi->biaya_tambahan - $memoekspedisi->deposit_driver - $memoekspedisi->uang_jaminan, 0, ',', '.') }}
                                                @endif
                                            @endif
                                        @endif

                                        <button type="button" class="btn btn-primary btn-sm" style="display: none;">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </td>
                                    <td class="text-center">
                                        @if ($memoekspedisi->status == 'posting')
                                            <button type="button" class="btn btn-success btn-sm">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            {{-- <button type="button" class="btn btn-primary btn-sm">
                                                <i class="fas fa-truck-moving"></i>
                                            </button> --}}
                                        @endif

                                    </td>
                                </tr>
                                <div class="modal fade" id="modal-posting-{{ $memoekspedisi->id }}">
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
                                                    <strong>{{ $memoekspedisi->kode_memo }}</strong>
                                                </p>
                                                @if ($memoekspedisi->status == 'unpost')
                                                    <form method="GET"
                                                        action="{{ route('hapusmemo', ['id' => $memoekspedisi->id]) }}">
                                                        <button type="submit"
                                                            class="btn btn-outline-danger btn-block mt-2">
                                                            <i class="fas fa-trash-alt"></i> Delete
                                                        </button>
                                                    </form>
                                                    <a href="{{ url('admin/inquery_memoekspedisi/' . $memoekspedisi->id) }}"
                                                        type="button" class="btn btn-outline-info btn-block">
                                                        <i class="fas fa-eye"></i> Show
                                                    </a>
                                                    <a href="{{ url('admin/inquery_memoekspedisi/' . $memoekspedisi->id . '/edit') }}"
                                                        type="button" class="btn btn-outline-warning btn-block">
                                                        <i class="fas fa-edit"></i> Update
                                                    </a>
                                                    <form method="GET"
                                                        action="{{ route('postingmemo', ['id' => $memoekspedisi->id]) }}">
                                                        <button type="submit"
                                                            class="btn btn-outline-success btn-block mt-2">
                                                            <i class="fas fa-check"></i> Posting
                                                        </button>
                                                    </form>
                                                @endif
                                                @if ($memoekspedisi->status == 'posting')
                                                    <a href="{{ url('admin/inquery_memoekspedisi/' . $memoekspedisi->id) }}"
                                                        type="button" class="btn btn-outline-info btn-block">
                                                        <i class="fas fa-eye"></i> Show
                                                    </a>
                                                    <form method="GET"
                                                        action="{{ route('unpostmemo', ['id' => $memoekspedisi->id]) }}">
                                                        <button type="submit"
                                                            class="btn btn-outline-primary btn-block mt-2">
                                                            <i class="fas fa-check"></i> Unpost
                                                        </button>
                                                    </form>
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
            form.action = "{{ url('admin/inquery_memoekspedisi') }}";
            form.submit();
        }
    </script>

    {{-- untuk klik 2 kali ke edit  --}}
    {{-- <script>
        document.getElementById('editMemoekspedisi').addEventListener('dblclick', function() {
            window.location.href = "{{ url('admin/inquery_memoekspedisi/' . $memoekspedisi->id . '/edit') }}";
        });
    </script> --}}

@endsection
