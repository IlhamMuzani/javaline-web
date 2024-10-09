@extends('layouts.app')

@section('title', 'Target Pengecekan Tromol')

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
                    <h1 class="m-0">Target Pengecekan Tromol</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Target Pengecekan Tromol</li>
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
                    <h3 class="card-title">Target Pengecekan Tromol</h3>
                    <div class="float-right">
                        {{-- @if (auth()->check() && auth()->user()->fitur['lama_bearing create']) --}}
                        {{-- <a href="{{ url('admin/lama_bearing/create') }}" class="btn btn-primary btn-sm">
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
                            <option value="lama_penggantianoli">Target Penggantian Oli</option>
                            <option value="jarak_km">Target Update Km</option>
                            <option value="lama_bearing" selected>Target Pengecekan Tromol</option>
                        </select>
                    </div>
                    <table id="datatables66" class="table table-bordered table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center">No</th>
                                <th>Kode</th>
                                <th>Target Pengecekan Tromol </th>
                                <th class="text-center" width="90">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jarak_kms as $lama_bearing)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $lama_bearing->kode_bearing }}
                                    </td>
                                    <td> {{ number_format($lama_bearing->batas, 0, ',', '.') }} Km

                                    </td>
                                    <td class="text-center">
                                        <a href="{{ url('admin/lama_bearing/' . $lama_bearing->id . '/edit') }}"
                                            class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                                <div class="modal fade" id="modal-hapus-{{ $lama_bearing->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Hapus Target Pengecekan Tromol</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Yakin Target Pengecekan Tromol
                                                    <strong>{{ $lama_bearing->nama }}</strong>?
                                                </p>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Batal</button>
                                                <form action="{{ url('admin/lama_bearing/' . $lama_bearing->id) }}"
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
