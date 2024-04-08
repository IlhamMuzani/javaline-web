@extends('layouts.app')

@section('title', 'Memo Ekspedisi')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Memo Ekspedisi</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Memo Ekspedisi</li>
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
                    <h3 class="card-title">Data Memo Ekspedisi</h3>
                    <div class="float-right">
                        <a href="{{ url('admin/memo_ekspedisi') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah
                        </a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    {{-- <form method="GET" id="form-action">
                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <select class="custom-select form-control" id="statusx" name="statusx">
                                    <option value="">- Pilih Memo -</option>
                                    <option value="memo_perjalanan">Memo Perjalanan</option>
                                    <option value="memo_borong">Memo Borong</option>
                                    <option value="memo_tambahan">Memo Tambahan</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-3">
                                <a href="{{ url('admin/memo_ekspedisi') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Tambah
                                </a>
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
                    </form> --}}
                    <table id="datatables66" class="table table-bordered table-striped" style="font-size: 13px">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Kode Memo</th>
                                <th>Tanggal</th>
                                <th>Sopir</th>
                                <th>No Kabin</th>
                                <th>Rute</th>
                                <th>U. Jalan</th>
                                <th>U. Tambah</th>
                                <th>Deposit</th>
                                {{-- <th>Adm</th> --}}
                                <th>Total</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($memos as $memo)
                                <tr id="editMemoekspedisi" data-toggle="modal"
                                    data-target="#modal-posting-{{ $memo->id }}" style="cursor: pointer;">
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>
                                        @if ($memoEkspedisi == true)
                                            {{ $memo->kode_memo }}
                                        @endif
                                        @if ($memoTambahan == true)
                                            {{ $memo->kode_tambahan }}
                                        @endif
                                    </td>
                                    <td>
                                        {{ $memo->tanggal_awal }}</td>
                                    <td>
                                        {{ substr($memo->nama_driver, 0, 7) }} ..
                                    </td>
                                    <td>
                                        {{ $memo->no_kabin }}
                                    </td>
                                    <td>
                                        @if ($memo->nama_rute == null)
                                            rute tidak ada
                                        @else
                                            {{ $memo->nama_rute }}
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        {{ number_format($memo->uang_jalan, 0, ',', '.') }}
                                    </td>
                                    <td class="text-right">
                                        @if ($memo->biaya_tambahan == null)
                                            0
                                        @else
                                            {{ number_format($memo->biaya_tambahan, 0, ',', '.') }}
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        @if ($memo->deposit_driver == null)
                                            0
                                        @else
                                            {{ number_format($memo->deposit_driver, 0, ',', '.') }}
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        @if ($memoEkspedisi)
                                            @if ($memo->sub_total !== null)
                                                {{ number_format($memo->sub_total, 0, ',', '.') }}
                                            @endif
                                        @endif

                                        @if ($memoTambahan)
                                            @if ($memo->grand_total !== null)
                                                {{ number_format($memo->grand_total, 0, ',', '.') }}
                                            @endif
                                        @endif

                                    </td>
                                    <td class="text-center">
                                        @if ($memo->status == 'posting')
                                            <button type="button" class="btn btn-success btn-sm">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        @endif
                                        @if ($memo->status == 'selesai')
                                            <img src="{{ asset('storage/uploads/indikator/faktur.png') }}" height="40"
                                                width="40" alt="Roda Mobil">
                                        @endif
                                    </td>
                                </tr>
                                <div class="modal fade" id="modal-posting-{{ $memo->id }}">
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
                                                    <strong>{{ $memo->kode_memo }}</strong>
                                                </p>
                                                @if ($memo->status == 'unpost')
                                                    @if (auth()->check() && auth()->user()->fitur['inquery memo perjalanan delete'])
                                                        <form method="GET"
                                                            action="{{ route('hapusmemo', ['id' => $memo->id]) }}">
                                                            <button type="submit"
                                                                class="btn btn-outline-danger btn-block mt-2">
                                                                <i class="fas fa-trash-alt"></i> Delete
                                                            </button>
                                                        </form>
                                                    @endif
                                                    @if (auth()->check() && auth()->user()->fitur['inquery memo perjalanan show'])
                                                        <a href="{{ url('admin/inquery_memoekspedisi/' . $memo->id) }}"
                                                            type="button" class="btn btn-outline-info btn-block">
                                                            <i class="fas fa-eye"></i> Show
                                                        </a>
                                                    @endif
                                                    @if (auth()->check() && auth()->user()->fitur['inquery memo perjalanan update'])
                                                        <a href="{{ url('admin/inquery_memoekspedisi/' . $memo->id . '/edit') }}"
                                                            type="button" class="btn btn-outline-warning btn-block">
                                                            <i class="fas fa-edit"></i> Update
                                                        </a>
                                                    @endif
                                                    @if (auth()->check() && auth()->user()->fitur['inquery memo perjalanan posting'])
                                                        {{-- <form method="GET"
                                                            action="{{ route('postingmemo', ['id' => $memo->id]) }}"> --}}
                                                        <button type="button"
                                                            class="btn btn-outline-success btn-block mt-2 posting-btn"
                                                            data-memo-id="{{ $memo->id }}">
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
                    url: "{{ url('admin/inquery_memoekspedisi/postingmemo/') }}/" + memoId,
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
