@extends('layouts.app')

@section('title', 'Inquery Memo Tambahan')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Inquery Memo Tambahan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Inquery Memo Tambahan</li>
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
                    <h3 class="card-title">Data Inquery Memo Tambahan</h3>
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
                                <label for="statusx">(Kategori Memo)</label>
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
                                <button type="button" class="btn btn-outline-primary btn-block" onclick="cari()">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                                <input type="hidden" name="ids" id="selectedIds" value="">
                                <button type="button" class="btn btn-primary btn-block mt-1" id="checkfilter"
                                    onclick="printSelectedData()" target="_blank">
                                    <i class="fas fa-print"></i> Cetak Filter
                                </button>
                            </div>
                        </div>
                    </form>
                    <table id="datatables66" class="table table-bordered table-striped" style="font-size: 13px">
                        <thead>
                            <tr>
                                <th> <input type="checkbox" name="" id="select_all_ids"></th>
                                <th class="text-center">No</th>
                                <th>No Memo Tambahan</th>
                                <th>No Memo</th>
                                <th>Tanggal</th>
                                <th>Sopir</th>
                                <th>No Kabin</th>
                                <th>Rute</th>
                                <th style="text-align: center">Uang Tambah</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inquery as $memotambahan)
                                <tr>
                                    <td><input type="checkbox" name="selectedIds[]" class="checkbox_ids"
                                            value="{{ $memotambahan->id }}">
                                    </td>
                                    <td id="editMemoekspedisi" data-toggle="modal"
                                        data-target="#modal-posting-{{ $memotambahan->id }}" style="cursor: pointer;"
                                        class="text-center">{{ $loop->iteration }}</td>
                                    <td id="editMemoekspedisi" data-toggle="modal"
                                        data-target="#modal-posting-{{ $memotambahan->id }}" style="cursor: pointer;">
                                        {{ $memotambahan->kode_tambahan }}</td>
                                    <td id="editMemoekspedisi" data-toggle="modal"
                                        data-target="#modal-posting-{{ $memotambahan->id }}" style="cursor: pointer;">
                                        {{ $memotambahan->no_memo }}</td>
                                    <td id="editMemoekspedisi" data-toggle="modal"
                                        data-target="#modal-posting-{{ $memotambahan->id }}" style="cursor: pointer;">
                                        {{ $memotambahan->tanggal_awal }}</td>
                                    <td id="editMemoekspedisi" data-toggle="modal"
                                        data-target="#modal-posting-{{ $memotambahan->id }}" style="cursor: pointer;">
                                        {{ substr($memotambahan->nama_driver, 0, 7) }} ..
                                    </td>
                                    <td id="editMemoekspedisi" data-toggle="modal"
                                        data-target="#modal-posting-{{ $memotambahan->id }}" style="cursor: pointer;">
                                        {{ $memotambahan->no_kabin }}
                                    </td>
                                    <td id="editMemoekspedisi" data-toggle="modal"
                                        data-target="#modal-posting-{{ $memotambahan->id }}" style="cursor: pointer;">
                                        {{ $memotambahan->nama_rute }}</td>
                                    <td id="editMemoekspedisi" data-toggle="modal"
                                        data-target="#modal-posting-{{ $memotambahan->id }}" style="cursor: pointer;"
                                        style="text-align: end">
                                        {{ number_format($memotambahan->grand_total, 0, ',', '.') }}</td>
                                    <td id="editMemoekspedisi" data-toggle="modal"
                                        data-target="#modal-posting-{{ $memotambahan->id }}" style="cursor: pointer;"
                                        class="text-center">
                                        @if ($memotambahan->status == 'posting')
                                            <button type="button" class="btn btn-success btn-sm">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        @endif
                                        @if ($memotambahan->status == 'selesai')
                                            <img src="{{ asset('storage/uploads/indikator/faktur.png') }}" height="40"
                                                width="40" alt="faktur">
                                        @endif
                                    </td>
                                </tr>
                                <div class="modal fade" id="modal-posting-{{ $memotambahan->id }}">
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
                                                <p>Memo Tambahan
                                                    <strong>{{ $memotambahan->kode_tambahan }}</strong>
                                                </p>
                                                @if ($memotambahan->detail_faktur->first())
                                                    <p>Digunakan Oleh Faktur Ekspedisi
                                                        <strong>{{ $memotambahan->detail_faktur->first()->faktur_ekspedisi->kode_faktur }}</strong>
                                                    </p>
                                                @else
                                                    <!-- Kode yang ingin Anda jalankan jika kondisi tidak terpenuhi -->
                                                @endif
                                                @if ($memotambahan->status == 'unpost')
                                                    @if (auth()->check() && auth()->user()->fitur['inquery memo tambahan delete'])
                                                        <form method="GET"
                                                            action="{{ route('hapusmemotambahan', ['id' => $memotambahan->id]) }}">
                                                            <button type="submit"
                                                                class="btn btn-outline-danger btn-block mt-2">
                                                                <i class="fas fa-trash-alt"></i> Delete
                                                            </button>
                                                        </form>
                                                    @endif
                                                    @if (auth()->check() && auth()->user()->fitur['inquery memo tambahan show'])
                                                        <a href="{{ url('admin/inquery_memotambahan/' . $memotambahan->id) }}"
                                                            type="button" class="btn btn-outline-info btn-block">
                                                            <i class="fas fa-eye"></i> Show
                                                        </a>
                                                    @endif
                                                    @if (auth()->check() && auth()->user()->fitur['inquery memo tambahan update'])
                                                        <a href="{{ url('admin/inquery_memotambahan/' . $memotambahan->id . '/edit') }}"
                                                            type="button" class="btn btn-outline-warning btn-block">
                                                            <i class="fas fa-edit"></i> Update
                                                        </a>
                                                    @endif
                                                    @if ($saldoTerakhir->sisa_saldo < $memotambahan->grand_total)
                                                        <p style="margin-top:5px">Sisa saldo tidak mencukupi untuk posting
                                                            memo <span style="font-weight: bold">
                                                                {{ $memotambahan->kode_tambahan }}
                                                            </span>
                                                        </p>
                                                    @else
                                                        @if (auth()->check() && auth()->user()->fitur['inquery memo tambahan posting'])
                                                            {{-- <form method="GET"
                                                            action="{{ route('postingmemotambahan', ['id' => $memotambahan->id]) }}"> --}}
                                                            <button type="button" data-memo-id="{{ $memotambahan->id }}"
                                                                class="btn btn-outline-success btn-block mt-2 posting-btn">
                                                                <i class="fas fa-check"></i> Posting
                                                            </button>
                                                            {{-- </form> --}}
                                                        @endif
                                                    @endif
                                                @endif
                                                @if ($memotambahan->status == 'posting')
                                                    @if (auth()->check() && auth()->user()->fitur['inquery memo tambahan show'])
                                                        <a href="{{ url('admin/inquery_memotambahan/' . $memotambahan->id) }}"
                                                            type="button" class="btn btn-outline-info btn-block">
                                                            <i class="fas fa-eye"></i> Show
                                                        </a>
                                                    @endif
                                                    @if (auth()->check() && auth()->user()->fitur['inquery memo tambahan unpost'])
                                                        {{-- <form method="GET"
                                                            action="{{ route('unpostmemotambahan', ['id' => $memotambahan->id]) }}"> --}}
                                                        <button type="button" data-memo-id="{{ $memotambahan->id }}"
                                                            class="btn btn-outline-primary btn-block mt-2 unpost-btn">
                                                            <i class="fas fa-check"></i> Unpost
                                                        </button>
                                                        {{-- </form> --}}
                                                    @endif
                                                @endif
                                                @if ($memotambahan->status == 'selesai')
                                                    @if (auth()->check() && auth()->user()->fitur['inquery memo tambahan show'])
                                                        <a href="{{ url('admin/inquery_memotambahan/' . $memotambahan->id) }}"
                                                            type="button" class="btn btn-outline-info btn-block">
                                                            <i class="fas fa-eye"></i> Show
                                                        </a>
                                                    @endif
                                                    @if (auth()->check() && auth()->user()->fitur['inquery memo tambahan unpost'])
                                                        <form method="GET"
                                                            action="{{ route('unpostmemotambahanselesai', ['id' => $memotambahan->id]) }}">
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

    <script>
        $(document).ready(function() {
            $('.unpost-btn').click(function() {
                var memoId = $(this).data('memo-id');

                // Kirim permintaan AJAX untuk melakukan unpost
                $.ajax({
                    url: "{{ url('admin/inquery_memotambahan/unpostmemotambahan/') }}/" + memoId,
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
    {{-- posting memo --}}
    <script>
        $(document).ready(function() {
            $('.posting-btn').click(function() {
                var memoId = $(this).data('memo-id');

                // Kirim permintaan AJAX untuk melakukan unpost
                $.ajax({
                    url: "{{ url('admin/inquery_memotambahan/postingmemotambahan/') }}/" + memoId,
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
            form.action = "{{ url('admin/inquery_memotambahan') }}";
            form.submit();
        }
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
                        window.location.href = "{{ url('admin/inquery_memoekspedisi') }}";
                        break;
                    case 'memo_borong':
                        window.location.href = "{{ url('admin/inquery_memoborong') }}";
                        break;
                    case 'memo_tambahan':
                        window.location.href = "{{ url('admin/inquery_memotambahan') }}";
                        break;
                    default:
                        // Handle other cases or do nothing
                        break;
                }
            });
        });
    </script>

    <script>
        $(function(e) {
            $("#select_all_ids").click(function() {
                $('.checkbox_ids').prop('checked', $(this).prop('checked'))
            })
        });

        function printSelectedData() {
            var selectedIds = document.querySelectorAll(".checkbox_ids:checked");
            if (selectedIds.length === 0) {
                alert("Harap centang setidaknya satu item sebelum mencetak.");
            } else {
                var selectedCheckboxes = document.querySelectorAll('.checkbox_ids:checked');
                var selectedIds = [];
                selectedCheckboxes.forEach(function(checkbox) {
                    selectedIds.push(checkbox.value);
                });
                document.getElementById('selectedIds').value = selectedIds.join(',');
                var selectedIdsString = selectedIds.join(',');
                window.location.href = "{{ url('admin/cetak_memotambahanfilter') }}?ids=" + selectedIdsString;
                // var url = "{{ url('admin/ban/cetak_pdffilter') }}?ids=" + selectedIdsString;
            }
        }
    </script>
@endsection
