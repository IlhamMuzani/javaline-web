@extends('layouts.app')

@section('title', 'Memo Borong')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Memo Borong</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Memo Borong</li>
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
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-ban"></i> Error!
                    </h5>
                    {{ session('error') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Memo Borong</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="GET" id="form-action">
                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <select class="custom-select form-control" id="statusx" name="statusx">
                                    <option value="">- Pilih Memo -</option>
                                    <option value="memo_perjalanan">Memo Perjalanan</option>
                                    <option value="memo_borong">Memo Borong</option>
                                    <option value="memo_tambahan">Memo Tambahan</option>
                                </select>
                                {{-- <label for="statusx">(Kategori Memo)</label> --}}
                            </div>
                            <div class="col-md-2 mb-3">
                                <a href="{{ url('admin/memo_ekspedisi') }}" class="btn btn-primary" target="_blank">
                                    <i class="fas fa-plus"></i> Tambah
                                </a>
                            </div>

                            {{-- <div class="col-md-2 mb-3">
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
                            </div> --}}
                            {{-- <div class="col-md-2 mb-3">
                                <button type="button" class="btn btn-outline-primary mr-2" onclick="cari()">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                            </div> --}}
                        </div>
                    </form>
                    <table id="example1" class="table table-bordered table-striped" style="font-size: 13px">
                        <thead>
                            <tr>
                                <th> <input type="checkbox" name="" id="select_all_ids"></th>
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
                                {{-- <th style="text-align: center">Adm</th> --}}
                                <th style="text-align: center">Deposit Sopir</th>
                                <th style="text-align: center">Grand Total</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($memos as $memoborong)
                                <tr>
                                    <td><input type="checkbox" name="selectedIds[]" class="checkbox_ids"
                                            value="{{ $memoborong->id }}">
                                    </td>
                                    <td id="editMemoekspedisi" data-toggle="modal"
                                        data-target="#modal-posting-{{ $memoborong->id }}" style="cursor: pointer;"
                                        class="text-center">{{ $loop->iteration }}</td>
                                    <td id="editMemoekspedisi" data-toggle="modal"
                                        data-target="#modal-posting-{{ $memoborong->id }}" style="cursor: pointer;">
                                        {{ $memoborong->kode_memo }}</td>
                                    <td id="editMemoekspedisi" data-toggle="modal"
                                        data-target="#modal-posting-{{ $memoborong->id }}" style="cursor: pointer;">
                                        {{ $memoborong->tanggal_awal }}</td>
                                    <td id="editMemoekspedisi" data-toggle="modal"
                                        data-target="#modal-posting-{{ $memoborong->id }}" style="cursor: pointer;">
                                        {{ substr($memoborong->nama_driver, 0, 7) }} ..
                                    </td>
                                    <td id="editMemoekspedisi" data-toggle="modal"
                                        data-target="#modal-posting-{{ $memoborong->id }}" style="cursor: pointer;">
                                        {{ $memoborong->no_kabin }}
                                    </td>
                                    <td id="editMemoekspedisi" data-toggle="modal"
                                        data-target="#modal-posting-{{ $memoborong->id }}" style="cursor: pointer;">
                                        @if ($memoborong->nama_rute == null)
                                            {{ $memoborong->detail_memo->first()->nama_rutes }}
                                        @else
                                            {{ $memoborong->nama_rute }}
                                        @endif
                                    </td>
                                    <td id="editMemoekspedisi" data-toggle="modal"
                                        data-target="#modal-posting-{{ $memoborong->id }}" style="cursor: pointer;"
                                        style="text-align: end">
                                        {{ number_format($memoborong->harga_rute, 0, ',', '.') }}
                                    </td>
                                    <td id="editMemoekspedisi" data-toggle="modal"
                                        data-target="#modal-posting-{{ $memoborong->id }}" style="cursor: pointer;"
                                        style="text-align: end">
                                        {{ $memoborong->jumlah }}
                                    </td>
                                    <td id="editMemoekspedisi" data-toggle="modal"
                                        data-target="#modal-posting-{{ $memoborong->id }}" style="cursor: pointer;"
                                        style="text-align: end">
                                        @if ($memoborong->totalrute == null)
                                            0
                                        @else
                                            {{ number_format($memoborong->totalrute, 0, ',', '.') }}
                                        @endif
                                    </td>
                                    <td id="editMemoekspedisi" data-toggle="modal"
                                        data-target="#modal-posting-{{ $memoborong->id }}" style="cursor: pointer;"
                                        style="text-align: end">
                                        {{ number_format($memoborong->pphs, 0, ',', '.') }}
                                    </td>
                                    {{-- <td style="text-align: end">
                                        {{ number_format($memoborong->uang_jaminans, 0, ',', '.') }}
                                    </td> --}}
                                    <td id="editMemoekspedisi" data-toggle="modal"
                                        data-target="#modal-posting-{{ $memoborong->id }}" style="cursor: pointer;"
                                        style="text-align: end">
                                        {{ number_format($memoborong->deposit_drivers, 0, ',', '.') }}
                                    </td>
                                    <td id="editMemoekspedisi" data-toggle="modal"
                                        data-target="#modal-posting-{{ $memoborong->id }}" style="cursor: pointer;"
                                        style="text-align: end">
                                        {{ number_format($memoborong->sub_total, 0, ',', '.') }}
                                    </td>
                                    <td id="editMemoekspedisi" data-toggle="modal"
                                        data-target="#modal-posting-{{ $memoborong->id }}" style="cursor: pointer;"
                                        class="text-center">
                                        @if ($memoborong->status == 'posting')
                                            <button type="button" class="btn btn-success btn-sm">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        @endif
                                        @if ($memoborong->status == 'selesai')
                                            <img src="{{ asset('storage/uploads/indikator/truck.png') }}" height="40"
                                                width="40" alt="Roda Mobil">
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
                                                        {{-- <form method="GET"
                                                            action="{{ route('postingmemoborong', ['id' => $memoborong->id]) }}"> --}}
                                                        <button type="button"
                                                            class="btn btn-outline-success btn-block mt-2 posting-btn"
                                                            data-memo-id="{{ $memoborong->id }}">
                                                            <i class="fas fa-check"></i> Posting
                                                        </button>
                                                        {{-- </form> --}}
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

    {{-- posting memo --}}
    <script>
        $(document).ready(function() {
            $('.posting-btn').click(function() {
                var memoId = $(this).data('memo-id');

                // Kirim permintaan AJAX untuk melakukan unpost
                $.ajax({
                    url: "{{ url('admin/inquery_memoborong/postingmemoborong/') }}/" + memoId,
                    type: 'GET',
                    data: {
                        id: memoId
                    },
                    success: function(response) {
                        // Tampilkan pesan sukses atau lakukan tindakan lain sesuai kebutuhan
                        console.log(response);

                        // Tutup modal setelah berhasil unpost
                        $('#modal-posting-' + memoId).modal('hide');

                        // Reload the page to refresh the table
                        location.reload();
                    },
                    error: function(error) {
                        // Tampilkan pesan error atau lakukan tindakan lain sesuai kebutuhan
                        console.log(error);
                    }
                });
            });
        });
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
                        window.location.href = "{{ url('admin/tablememo') }}";
                        break;
                    case 'memo_borong':
                        window.location.href = "{{ url('admin/tablememoborongs') }}";
                        break;
                    case 'memo_tambahan':
                        window.location.href = "{{ url('admin/tablememotambahans') }}";
                        break;
                    default:
                        // Handle other cases or do nothing
                        break;
                }
            });
        });
    </script>
@endsection
