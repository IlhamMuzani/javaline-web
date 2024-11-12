@extends('layouts.app')

@section('title', 'Data Kendaraan')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Kendaraan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Data Kendaraan</li>
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
                        <i class="icon fas fa-check"></i> Berhasil!
                    </h5>
                    {{ session('success') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Kendaraan</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="GET" id="form-action">
                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <button type="button" class="btn btn-success btn-block mt-1" id="postingfilter"
                                    onclick="postingSelectedData()">
                                    <i class="fas fa-check-square"></i> Posting Filter
                                </button>
                            </div>

                            <div class="col-md-2 mb-3">
                                <button type="button" class="btn btn-warning btn-block mt-1" id="unpostfilter"
                                    onclick="unpostSelectedData()">
                                    <i class="fas fa-times-circle"></i> Unpost Filter
                                </button>
                            </div>
                            <input type="hidden" name="ids" id="selectedIds" value="">
                        </div>
                    </form>
                    <table id="datatables66" class="table table-bordered table-striped table-hover" style="font-size: 13px">
                        <thead class="thead-dark">
                            <tr>
                                <th> <input type="checkbox" name="" id="select_all_ids"></th>
                                <th class="text-center">No</th>
                                <th>Kode Kendaraan</th>
                                <th>Driver</th>
                                <th>No Kabin</th>
                                <th>No Pol</th>
                                <th>Akses Lokasi</th>
                                <th class="text-center" width="90">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kendaraans as $kendaraan)
                                <tr class="dropdown"{{ $kendaraan->id }}>
                                    <td><input type="checkbox" name="selectedIds[]" class="checkbox_ids"
                                            value="{{ $kendaraan->id }}">
                                    </td>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $kendaraan->kode_kendaraan }}
                                    </td>
                                    <td>{{ $kendaraan->latestpengambilan_do->spk->nama_driver ?? null }}
                                    </td>
                                    <td>{{ $kendaraan->no_kabin }}
                                    </td>
                                    <td>{{ $kendaraan->no_pol }}
                                    </td>
                                    <td>
                                        @if ($kendaraan->akses_lokasi == 1)
                                            <span style="font-size: 10px" class="badge badge-success">True</span>
                                        @else
                                            <span style="font-size: 10px" class="badge badge-warning">False</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ url('admin/akses_lokasi/' . $kendaraan->id . '/edit') }}"
                                            class="btn btn-info btn-sm">
                                            <i class="fas fa-edit">Akses</i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- Modal Loading -->
                    <div class="modal fade" id="modal-loading" tabindex="-1" role="dialog"
                        aria-labelledby="modal-loading-label" aria-hidden="true" data-backdrop="static">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-body text-center">
                                    <i class="fas fa-spinner fa-spin fa-3x text-primary"></i>
                                    <h4 class="mt-2">Sedang Menyimpan...</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- validasi gagal  --}}
                    <div class="modal fade" id="validationModal" tabindex="-1" role="dialog"
                        aria-labelledby="validationModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="validationModalLabel">Validasi Gagal</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true"><i class="fas fa-times"></i></span>
                                    </button>
                                </div>
                                <div class="modal-body text-center">
                                    <i class="fas fa-times-circle fa-3x text-danger"></i>
                                    <h4 class="mt-2">Validasi Gagal!</h4>
                                    <p id="validationMessage"></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </section>
    <!-- /.card -->

    <script>
        $(function(e) {
            $("#select_all_ids").click(function() {
                $('.checkbox_ids').prop('checked', $(this).prop('checked'))
            })
        });

        function postingSelectedData() {
            var selectedCheckboxes = document.querySelectorAll(".checkbox_ids:checked");
            if (selectedCheckboxes.length === 0) {
                // Tampilkan modal peringatan jika tidak ada item yang dipilih
                $('#validationMessage').text('Harap centang setidaknya satu item sebelum posting.');
                $('#validationModal').modal('show');
            } else {
                var selectedIds = [];
                selectedCheckboxes.forEach(function(checkbox) {
                    selectedIds.push(checkbox.value);
                });
                var selectedIdsString = selectedIds.join(',');
                document.getElementById('postingfilter').value = selectedIdsString;

                // Tampilkan modal loading sebelum mengirim permintaan AJAX
                $('#modal-loading').modal('show');

                $.ajax({
                    url: "{{ url('admin/postingfilterakses') }}?ids=" + selectedIdsString,
                    type: 'GET',
                    success: function(response) {
                        // Sembunyikan modal loading setelah permintaan selesai
                        $('#modal-loading').modal('hide');

                        // Tampilkan pesan sukses atau lakukan tindakan lain sesuai kebutuhan
                        console.log(response);

                        // Reload the page to refresh the table
                        location.reload();
                    },
                    error: function(error) {
                        // Sembunyikan modal loading setelah permintaan selesai
                        $('#modal-loading').modal('hide');

                        // Tampilkan pesan error atau lakukan tindakan lain sesuai kebutuhan
                        console.log(error);
                    }
                });
            }
        }

        function unpostSelectedData() {
            var selectedCheckboxes = document.querySelectorAll(".checkbox_ids:checked");
            if (selectedCheckboxes.length === 0) {
                // Tampilkan modal peringatan jika tidak ada item yang dipilih
                $('#validationMessage').text('Harap centang setidaknya satu item sebelum mengunpost.');
                $('#validationModal').modal('show');
            } else {
                var selectedIds = [];
                selectedCheckboxes.forEach(function(checkbox) {
                    selectedIds.push(checkbox.value);
                });
                var selectedIdsString = selectedIds.join(',');
                document.getElementById('unpostfilter').value = selectedIdsString;

                // Tampilkan modal loading sebelum mengirim permintaan AJAX
                $('#modal-loading').modal('show');

                $.ajax({
                    url: "{{ url('admin/unpostfilterakses') }}?ids=" + selectedIdsString,
                    type: 'GET',
                    success: function(response) {
                        // Sembunyikan modal loading setelah permintaan selesai
                        $('#modal-loading').modal('hide');

                        // Tampilkan pesan sukses atau lakukan tindakan lain sesuai kebutuhan
                        console.log(response);

                        // Reload the page to refresh the table
                        location.reload();
                    },
                    error: function(error) {
                        // Sembunyikan modal loading setelah permintaan selesai
                        $('#modal-loading').modal('hide');

                        // Tampilkan pesan error atau lakukan tindakan lain sesuai kebutuhan
                        console.log(error);
                    }
                });
            }
        }
    </script>

@endsection
