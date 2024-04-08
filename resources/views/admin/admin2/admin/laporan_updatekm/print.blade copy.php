@extends('layouts.app')

@section('title', 'Laporan Update KM')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Laporan Update KM</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Laporan Update KM</li>
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
                <h3 class="card-title">Data Laporan Update KM</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form method="GET" id="form-action">
                    <div class="row">
                        <div class="col-md-5 mb-3">
                            <label for="tanggal_awal">Tanggal Awal</label>
                            <input class="form-control" id="tanggal_awal" name="tanggal_awal" type="date"
                                value="{{ Request::get('tanggal_awal') }}" max="{{ date('Y-m-d') }}" />
                        </div>
                        <div class="col-md-5 mb-3">
                            <label for="tanggal_akhir">Tanggal Akhir</label>
                            <input class="form-control" id="tanggal_akhir" name="tanggal_akhir" type="date"
                                value="{{ Request::get('tanggal_akhir') }}" max="{{ date('Y-m-d') }}" />
                        </div>
                        <div class="col-md-2 mb-3">
                            <button type="button" class="btn btn-outline-primary btn-block" onclick="cari()">
                                <i class="fas fa-search"></i> Cari
                            </button>
                            <button type="button" class="btn btn-primary btn-block" onclick="printReport()"
                                target="_blank">
                                <i class="fas fa-print"></i> Cetak
                            </button>
                        </div>
                    </div>
                </form>
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Tanggal</th>
                            <th>Nama User</th>
                            <th>No Kabin</th>
                            <th>Km Update</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inquery as $updatekm)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $updatekm->tanggal }}</td>
                            <td>
                                @if ($updatekm->user)
                                {{ $updatekm->user->karyawan->nama_lengkap }}
                                @else
                                User tidak ada
                                @endif
                            </td>
                            <td>{{ $updatekm->no_kabin }}</td>
                            <td>{{ $updatekm->km }}</td>
                            {{-- <td class="text-center">
                                    </td> --}}
                        </tr>
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
    };
    tanggalAkhir.value = "";
    tanggalAkhir.setAttribute('min', this.value);
});
var form = document.getElementById('form-action')

function cari() {
    form.action = "{{ url('admin/laporan_updatekm') }}";
    form.submit();
}

function printReport() {
    var startDate = tanggalAwal.value;
    var endDate = tanggalAkhir.value;

    if (startDate && endDate) {
        form.action = "{{ url('admin/print_updatekm') }}" + "?start_date=" + startDate + "&end_date=" + endDate;
        form.submit();
    } else {
        alert("Silakan isi kedua tanggal sebelum mencetak.");
    }
}

// function printReport() {
//     var startDate = tanggalAwal.value;
//     var endDate = tanggalAkhir.value;

//     if (startDate && endDate) {
//         window.open("{{ url('admin/print_updatekm') }}" + "?start_date=" + startDate + "&end_date=" + endDate,
//             "_blank");
//     } else {
//         alert("Silakan isi kedua tanggal sebelum mencetak.");
//     }
// }
</script>
@endsection