@extends('layouts.app')

@section('title', 'Target Penggantian Oli')

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
                    <h1 class="m-0">Target Penggantian Oli</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Target Penggantian Oli</li>
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
                        <i class="icon fas fa-check"></i> Berhasil!
                    </h5>
                    {{ session('success') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Target Penggantian Oli</h3>
                    <div class="float-right">
                        {{-- @if (auth()->check() && auth()->user()->fitur['lama_penggantianoli create']) --}}
                        {{-- <a href="{{ url('admin/lama_penggantianoli/create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah
                        </a> --}}
                        {{-- @endif --}}
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="col-md-2 mb-3">
                        <select class="custom-select form-control" id="status" name="status">
                            <option value="">- Pilih -</option>
                            <option value="lama_penggantianoli" selected>Target Penggantian Oli</option>
                            <option value="jarak_km">Target Update Km</option>
                            <option value="lama_bearing">Target Pengecekan Tromol</option>
                        </select>
                    </div>
                    <div class="table-responsive" style="overflow-x: auto;">
                        <table id="datatables66" class="table table-bordered table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Kode</th>
                                    <th>Nama Oli </th>
                                    <th>Target Penggantian Oli </th>
                                    <th class="text-center" width="90">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lama_penggantianolis as $lama_penggantianoli)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $lama_penggantianoli->kode_oli }}
                                        </td>
                                        <td>{{ $lama_penggantianoli->nama }}
                                        </td>
                                        <td> {{ number_format($lama_penggantianoli->km_oli, 0, ',', '.') }}

                                        </td>
                                        <td class="text-center">
                                            <a href="{{ url('admin/lama_penggantianoli/' . $lama_penggantianoli->id . '/edit') }}"
                                                class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            {{-- <button type="submit" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#modal-hapus-{{ $lama_penggantianoli->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button> --}}
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="modal-hapus-{{ $lama_penggantianoli->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Hapus Target Penggantian Oli</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Yakin hapus Target Penggantian Oli
                                                        <strong>{{ $lama_penggantianoli->nama }}</strong>?
                                                    </p>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">Batal</button>
                                                    <form
                                                        action="{{ url('admin/lama_penggantianoli/' . $lama_penggantianoli->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                                    </form>
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

    <script>
        $(document).ready(function() {
            // Detect the change event on the 'status' dropdown
            $('#status').on('change', function() {
                // Get the selected value
                var selectedValue = $(this).val();

                // Check the selected value and redirect accordingly
                switch (selectedValue) {
                    case 'lama_penggantianoli':
                        window.location.href = "{{ url('admin/lama_penggantianoli') }}";
                        break;
                    case 'jarak_km':
                        window.location.href = "{{ url('admin/jarak_km') }}";
                        break;
                    case 'lama_bearing':
                        window.location.href = "{{ url('admin/lama_bearing') }}";
                        break;
                    default:
                        // Handle other cases or do nothing
                        break;
                }
            });
        });
    </script>
    <!-- /.card -->
@endsection
