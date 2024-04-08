@extends('layouts.app')

@section('title', 'Inquery Pengambilan Kas Kecil')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Inquery Pengambilan Kas Kecil</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Inquery Pengambilan Kas Kecil</li>
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
                <h3 class="card-title">Data Inquery Pengambilan Kas Kecil</h3>
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
                <table id="datatables66" class="table table-bordered table-striped" style="font-size: 13px">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>No Pengambilan Kas Kecil</th>
                            <th>Tanggal</th>
                            <th>Finance</th>
                            <th>No Kabin</th>
                            <th>Jam</th>
                            <th>Total</th>
                            <th style="width:20px">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inquery as $pengeluaran)
                        <tr id="editMemoekspedisi" data-toggle="modal"
                            data-target="#modal-posting-{{ $pengeluaran->id }}" style="cursor: pointer;">
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $pengeluaran->kode_pengeluaran }}</td>
                            <td>{{ $pengeluaran->tanggal_awal }}</td>
                            <td>
                                {{ $pengeluaran->user->karyawan->nama_lengkap }}
                            </td>
                            <td>
                                @if ($pengeluaran->kendaraan)
                                {{ $pengeluaran->kendaraan->no_kabin }}
                                @else
                                tidak ada
                                @endif
                            </td>
                            <td>{{ $pengeluaran->jam }}</td>
                            <td class="text-right">
                                {{ number_format($pengeluaran->grand_total, 0, ',', '.') }}

                            </td>
                            <td class="text-center">
                                @if ($pengeluaran->status == 'posting')
                                <button type="button" class="btn btn-success btn-sm">
                                    <i class="fas fa-check"></i>
                                </button>
                                @endif
                            </td>
                        </tr>
                        <div class="modal fade" id="modal-posting-{{ $pengeluaran->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Opsi menu</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Memo ekspedisi
                                            <strong>{{ $pengeluaran->kode_return }}</strong>
                                        </p>
                                        @if ($pengeluaran->status == 'unpost')
                                        {{-- @if (auth()->check() && auth()->user()->fitur['inquery pengambilan kas kecil delete']) --}}
                                        <form method="GET"
                                            action="{{ route('hapuspengeluaran', ['id' => $pengeluaran->id]) }}">
                                            <button type="submit" class="btn btn-outline-danger btn-block mt-2">
                                                <i class="fas fa-trash-alt"></i> Delete
                                            </button>
                                        </form>
                                        {{-- @endif
                                                    @if (auth()->check() && auth()->user()->fitur['inquery pengambilan kas kecil show']) --}}
                                        <a href="{{ url('admin/inquery_pengeluarankaskecil/' . $pengeluaran->id) }}"
                                            type="button" class="btn btn-outline-info btn-block">
                                            <i class="fas fa-eye"></i> Show
                                        </a>
                                        {{-- @endif
                                                    @if (auth()->check() && auth()->user()->fitur['inquery pengambilan kas kecil update']) --}}
                                        <a href="{{ url('admin/inquery_pengeluarankaskecil/' . $pengeluaran->id . '/edit') }}"
                                            type="button" class="btn btn-outline-warning btn-block">
                                            <i class="fas fa-edit"></i> Update
                                        </a>
                                        {{-- @endif
                                                    @if (auth()->check() && auth()->user()->fitur['inquery pengambilan kas kecil posting']) --}}
                                        {{-- <form method="GET"
                                                        action="{{ route('postingpengeluaran', ['id' => $pengeluaran->id]) }}">
                                        --}}
                                        <button type="button" class="btn btn-outline-success btn-block mt-2 posting-btn"
                                            data-memo-id="{{ $pengeluaran->id }}">
                                            <i class="fas fa-check"></i> Posting
                                        </button>
                                        {{-- </form> --}}
                                        {{-- @endif --}}
                                        @endif
                                        @if ($pengeluaran->status == 'posting')
                                        {{-- @if (auth()->check() && auth()->user()->fitur['inquery pengambilan kas kecil show']) --}}
                                        <a href="{{ url('admin/inquery_pengeluarankaskecil/' . $pengeluaran->id) }}"
                                            type="button" class="btn btn-outline-info btn-block">
                                            <i class="fas fa-eye"></i> Show
                                        </a>
                                        {{-- @endif
                                                    @if (auth()->check() && auth()->user()->fitur['inquery pengambilan kas kecil unpost']) --}}
                                        {{-- <form method="GET"
                                                        action="{{ route('unpostpengeluaran', ['id' => $pengeluaran->id]) }}">
                                        --}}
                                        <button type="button" class="btn btn-outline-primary btn-block mt-2 unpost-btn"
                                            data-memo-id="{{ $pengeluaran->id }}">
                                            <i class="fas fa-check"></i> Unpost
                                        </button>
                                        {{-- </form> --}}
                                        {{-- @endif --}}
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

{{-- unpost memo  --}}
<script>
$(document).ready(function() {
    $('.unpost-btn').click(function() {
        var memoId = $(this).data('memo-id');

        // Kirim permintaan AJAX untuk melakukan unpost
        $.ajax({
            url: "{{ url('admin/inquery_pengeluarankaskecil/unpostpengeluaran/') }}/" +
                memoId,
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
            url: "{{ url('admin/inquery_pengeluarankaskecil/postingpengeluaran/') }}/" +
                memoId,
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
    form.action = "{{ url('admin/inquery_pengeluarankaskecil') }}";
    form.submit();
}
</script>

{{-- untuk klik 2 kali ke edit  --}}
{{-- <script>
        document.getElementById('editMemoekspedisi').addEventListener('dblclick', function() {
            window.location.href = "{{ url('admin/inquery_notareturn/' . $pengeluaran->id . '/edit') }}";
});
</script> --}}

@endsection