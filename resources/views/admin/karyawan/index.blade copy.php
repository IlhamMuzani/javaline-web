@extends('layouts.app')

@section('title', 'Data Karyawan')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Data Karyawan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Data Karyawan</li>
                </ol>
            </div>
        </div>
    </div>
</div>
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
                <h3 class="card-title">Data Karyawan</h3>
                <div class="float-right">
                    @if (auth()->check() && auth()->user()->fitur['karyawan create'])
                    <a href="{{ url('admin/karyawan/create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah
                    </a>
                    @endif
                </div>
            </div>
            <form action="{{ url('admin/karyawan') }}" method="GET" id="get-keyword" autocomplete="off">
                @csrf
                <div class="row p-3">
                    <div class="col-0 col-md-8"></div>
                    <div class="col-md-4">
                        <label for="keyword">Cari Barang :</label>
                        <div class="input-group">
                            <input type="search" class="form-control" name="keyword" id="keyword"
                                value="{{ Request::get('keyword') }}" onsubmit="event.preventDefault();
                                        document.getElementById('get-keyword').submit();">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Kode Karyawan</th>
                            <th>Nama</th>
                            <th>Telepon</th>
                            <th>Departemen</th>
                            <th class="text-center">Qr Code</th>
                            <th class="text-center" width="150">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($karyawans as $karyawan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $karyawan->kode_karyawan }}</td>
                            <td>{{ $karyawan->nama_lengkap }}</td>
                            <td>{{ $karyawan->telp }}</td>
                            <td>{{ $karyawan->departemen->nama }}</td>
                            <td class="text-center">
                                {!! DNS2D::getBarcodeHTML($karyawan->qrcode_karyawan, 'QRCODE', 2, 2) !!}
                            </td>
                            <td class="text-center">
                                <!-- Tambahkan tombol aksi sesuai kebutuhan -->
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if ($karyawans->total() > 10)
            <div class="card-footer">
                <div class="pagination float-right">
                    {{ $karyawans->appends(Request::all())->links('pagination::simple-bootstrap-4') }}
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
<script>
$(document).ready(function() {
    $('#keyword').keyup(function() {
        var keyword = $(this).val();
        $.ajax({
            url: "{{ url('admin/karyawan/search') }}",
            method: 'GET',
            data: {
                keyword: keyword
            },
            success: function(response) {
                var tableBody = '';
                $.each(response.data, function(index, karyawan) {
                    tableBody += '<tr>';
                    tableBody += '<td>' + karyawan.id + '</td>';
                    tableBody += '<td>' + karyawan.kode_karyawan + '</td>';
                    tableBody += '<td>' + karyawan.nama_lengkap + '</td>';
                    tableBody += '<td>' + karyawan.telp + '</td>';
                    tableBody += '<td>' + karyawan.departemen.nama + '</td>';
                    // Tampilkan barcode di sini
                    tableBody += '<td class="text-center">' +
                        '<img src="data:image/png;base64,' + karyawan
                        .qrcode_karyawan + '" alt="barcode">' + '</td>';
                    // Akhir dari tampilkan barcode
                    tableBody += '<td class="text-center">' + 'Tombol aksi' +
                        '</td>'; // Tambahkan tombol aksi
                    tableBody += '</tr>';
                });
                $('tbody').html(tableBody);
            }
        });
    });
});
</script>

@endsection