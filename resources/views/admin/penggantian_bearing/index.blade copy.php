@extends('layouts.app')

@section('title', 'Penggantian Bearing')

@section('content')
<div id="loadingSpinner" style="display: flex; align-items: center; justify-content: center; height: 100vh;">
    <i class="fas fa-spinner fa-spin" style="font-size: 3rem;"></i>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        setTimeout(function() {
            document.getElementById("loadingSpinner").style.display = "none";
            document.getElementById("mainContent").style.display = "block";
            document.getElementById("mainContentSection").style.display = "block";
        }, 100); // Adjust the delay time as needed
    });
</script>

<!-- Content Header (Page header) -->
<div class="content-header" style="display: none;" id="mainContent">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Penggantian Bearing</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Penggantian Bearing</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content" style="display: none;" id="mainContentSection">
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
                <h3 class="card-title">Data kendaraan</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form method="GET" id="form-action">
                    <div class="row">
                        <div class="col-md-2 mb-3">
                            <label for="created_at">Show All</label>
                            <button id="toggle-all" type="button" class="btn btn-info btn-block">
                                All Toggle Detail
                            </button>
                        </div>
                        <div class="col-md-2 mb-3">

                        </div>

                        <!-- Bagian pencarian berada di sebelah kanan -->
                        <div class="col-md-4 offset-md-4">
                            <label for="keyword">Cari Barang :</label>
                            <div class="input-group">
                                <input type="search" class="form-control" name="keyword" id="keyword"
                                    value="{{ Request::get('keyword') }}"
                                    onsubmit="event.preventDefault();
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
                <table id="datatables66" class="table table-bordered table-striped table-hover" style="font-size: 13px">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center">No</th>
                            <th>Kode Kendaraan</th>
                            <th>No Kabin</th>
                            <th>Jenis Kendaraan</th>
                            <th class="text-center" width="120">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kendaraans as $index => $kendaraan)
                        <tr data-toggle="collapse" data-target="#kendaraan-{{ $index }}"
                            class="accordion-toggle" style="background: rgb(240, 242, 246)">
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $kendaraan->kode_kendaraan }}</td>
                            <td>{{ $kendaraan->no_kabin }}</td>
                            <td>
                                @if ($kendaraan->jenis_kendaraan)
                                {{ $kendaraan->jenis_kendaraan->nama_jenis_kendaraan }}
                                @else
                                data tidak ada
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ url('admin/kendaraan/' . $kendaraan->id . '/edit') }}"
                                    class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="7"> <!-- Gabungkan kolom untuk detail -->
                                <div id="kendaraan-{{ $index }}" class="collapse">
                                    <table class="table table-sm" style="margin: 0;">
                                        <thead>
                                            <tr>
                                                <th>Axle</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Axle 1</td>
                                                <td>Warning</td>
                                            </tr>
                                            <tr>
                                                <td>Axle 2</td>
                                                <td>Warning</td>
                                            </tr>
                                            <tr>
                                                <td>Axle 3</td>
                                                <td>Warning</td>
                                            </tr>
                                            <tr>
                                                <td>Axle 4</td>
                                                <td>Warning</td>
                                            </tr>
                                            <tr>
                                                <td>Axle 5</td>
                                                <td>Warning</td>
                                            </tr>
                                            <tr>
                                                <td>Axle 6</td>
                                                <td>Warning</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() {
        // Detect the change event on the 'status' dropdown
        $('#kategori').on('change', function() {
            // Get the selected value
            var selectedValue = $(this).val();

            // Check the selected value and redirect accordingly
            switch (selectedValue) {
                case 'kendaraan':
                    window.location.href = "{{ url('admin/kendaraan') }}";
                    break;
                case 'barangnon':
                    window.location.href = "{{ url('admin/barangnonbesi') }}";
                    break;
                default:
                    // Handle other cases or do nothing
                    break;
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        var toggleAll = $("#toggle-all");
        var isExpanded = true; // Status awal untuk memastikan semua detail telah dibuka

        // Membuka semua elemen collapse saat halaman dimuat
        $(".collapse").collapse("show");
        toggleAll.text("All Close Detail");

        toggleAll.click(function() {
            if (isExpanded) {
                $(".collapse").collapse("hide");
                toggleAll.text("All Toggle Detail");
                isExpanded = false;
            } else {
                $(".collapse").collapse("show");
                toggleAll.text("All Close Detail");
                isExpanded = true;
            }
        });

        // Event listener untuk mengubah status jika ada interaksi manual
        $(".accordion-toggle").click(function() {
            var target = $(this).data("target");
            if ($("#" + target).hasClass("show")) {
                $("#" + target).collapse("hide");
            } else {
                $("#" + target).collapse("show");
            }
        });
    });
</script>

@endsection