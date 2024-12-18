@extends('layouts.app')

@section('title', 'Inquery Pengambilan DO')

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
                    <h1 class="m-0">Inquery Pengambilan DO</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Inquery Pengambilan DO</li>
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
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-ban"></i> Gagal!
                    </h5>
                    {{ session('error') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Inquery Pengambilan DO</h3>
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
                                <button type="button" class="btn btn-primary btn-block" onclick="cari()">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                                <button type="button" class="btn btn-success btn-block mt-1" id="postingfilter"
                                    onclick="postingSelectedData()">
                                    <i class="fas fa-check-square"></i> Posting Filter
                                </button>
                                <button type="button" class="btn btn-warning btn-block mt-1" id="unpostfilter"
                                    onclick="unpostSelectedData()">
                                    <i class="fas fa-times-circle"></i> Unpost Filter
                                </button>
                                <button type="button" class="btn btn-success btn-block mt-1" id="postingfilter"
                                    onclick="postingSelectedDatafrangki()">
                                    <i class="fas fa-check-square"></i> Posting frangki
                                </button>
                                <button type="button" class="btn btn-success btn-block mt-1" id="postingfilter"
                                    onclick="postingSelectedDatakuswanto()">
                                    <i class="fas fa-check-square"></i> Posting kuswanto
                                </button>
                                <button type="button" class="btn btn-success btn-block mt-1" id="postingfilter"
                                    onclick="postingSelectedDatatohirin()">
                                    <i class="fas fa-check-square"></i> Posting tohirin
                                </button>
                                <button type="button" class="btn btn-success btn-block mt-1" id="postingfilter"
                                    onclick="postingSelectedDataishak()">
                                    <i class="fas fa-check-square"></i> Posting ishak
                                </button>
                                <button type="button" class="btn btn-success btn-block mt-1" id="postingfilter"
                                    onclick="postingSelectedDataniam()">
                                    <i class="fas fa-check-square"></i> Posting niam
                                </button>
                                <input type="hidden" name="ids" id="selectedIds" value="">
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive" style="overflow-x: auto;">
                        <table id="datatables66" class="table table-bordered table-striped table-hover"
                            style="font-size: 13px">
                            <thead class="thead-dark">
                                <tr>
                                    <th> <input type="checkbox" name="" id="select_all_ids"></th>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Id</th>
                                    <th>Kode SPK</th>
                                    <th>Penerima</th>
                                    {{-- <th>User Penerima</th> --}}
                                    <th>No Kabin</th>
                                    <th>Nama Driver</th>
                                    <th>Jenis Kendaraan</th>
                                    <th class="text-center" width="40">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inquery as $index => $pengambilan_do)
                                    <tr data-toggle="collapse" data-target="#barang-{{ $index }}"
                                        class="accordion-toggle{{ $loop->iteration % 2 == 0 ? ' bg-light' : '' }}"
                                        style="background: rgb(240, 242, 246)">
                                        <td><input type="checkbox" name="selectedIds[]" class="checkbox_ids"
                                                value="{{ $pengambilan_do->id }}"></td>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $pengambilan_do->id }}</td>
                                        <td>{{ $pengambilan_do->spk->kode_spk ?? 'tidak ada' }}</td>
                                        <td>{{ $pengambilan_do->userpenerima->karyawan->nama_lengkap ?? 'tidak ada' }}</td>
                                        <td>{{ $pengambilan_do->spk->kendaraan->no_kabin ?? 'tidak ada' }}</td>
                                        <td>{{ $pengambilan_do->spk->user->karyawan->nama_lengkap ?? 'tidak ada' }}</td>
                                        <td>
                                            @if ($pengambilan_do->kendaraan)
                                                {{ $pengambilan_do->kendaraan->jenis_kendaraan->nama_jenis_kendaraan }}
                                            @else
                                                nama tidak ada
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($pengambilan_do->status_penerimaansj == 'posting')
                                                <button type="button" class="btn btn-success btn-sm">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @endif
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                @if (is_null($pengambilan_do->status_penerimaansj) || $pengambilan_do->status_penerimaansj == 'unpost')
                                                    <a class="dropdown-item posting-btn"
                                                        data-memo-id="{{ $pengambilan_do->id }}">Posting</a>
                                                @endif
                                                @if ($pengambilan_do->status_penerimaansj == 'posting')
                                                    <a class="dropdown-item unpost-btn"
                                                        data-memo-id="{{ $pengambilan_do->id }}">Unpost</a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8"> <!-- Gabungkan kolom untuk detail -->
                                            <div id="barang-{{ $index }}" class="collapse show">
                                                <!-- Tambahkan class "show" -->
                                                <table class="table table-sm" style="margin: 0;">
                                                    <thead>
                                                        <tr>
                                                            <th>id</th>
                                                            <th>Nama</th>
                                                            <th>Kategori</th>
                                                            <th>Timer Awal</th>
                                                            <th>Timer Akhir</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($pengambilan_do->timer_suratjalan as $item)
                                                            <tr>
                                                                <td>{{ $item->id }}</td>
                                                                <td>{{ $item->user->karyawan->nama_lengkap ?? 'tidak ada' }}
                                                                </td>
                                                                <td>{{ $item->kategori }}</td>
                                                                <td>{{ $item->timer_awal }}</td>
                                                                <td>{{ $item->timer_akhir }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
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
                </div>

                <!-- Modal Konfirmasi Hapus -->
                <div class="modal fade" id="modal-confirm-delete" tabindex="-1" role="dialog"
                    aria-labelledby="modal-confirm-delete-label" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modal-confirm-delete-label">Konfirmasi Hapus</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Apakah Anda yakin ingin menghapus pengambilan_do yang dipilih?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="button" class="btn btn-danger" id="btn-confirm-delete">Hapus</button>
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
            form.action = "{{ url('admin/inquery_pengambilando') }}";
            form.submit();
        }
    </script>
    <script>
        $(document).ready(function() {
            var toggleAll = $("#toggle-all");
            var isExpanded = true; // Semua toggle terbuka saat halaman dimuat

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

            // Event listener untuk interaksi manual
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
                    url: "{{ url('admin/postingfilterpenerimaanpusat') }}?ids=" + selectedIdsString,
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
                document.getElementById('postingfilter').value = selectedIdsString;

                // Tampilkan modal loading sebelum mengirim permintaan AJAX
                $('#modal-loading').modal('show');

                $.ajax({
                    url: "{{ url('admin/unpostfilterpenerimaanpusat') }}?ids=" + selectedIdsString,
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

        function postingSelectedDatafrangki() {
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
                    url: "{{ url('admin/postingfilterpenerimaanfrangki') }}?ids=" + selectedIdsString,
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

        function postingSelectedDatakuswanto() {
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
                    url: "{{ url('admin/postingfilterpenerimaankuswanto') }}?ids=" + selectedIdsString,
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

        function postingSelectedDatatohirin() {
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
                    url: "{{ url('admin/postingfilterpenerimaantohirin') }}?ids=" + selectedIdsString,
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

        function postingSelectedDataishak() {
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
                    url: "{{ url('admin/postingfilterpenerimaanishak') }}?ids=" + selectedIdsString,
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

        function postingSelectedDataniam() {
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
                    url: "{{ url('admin/postingfilterpenerimaanniam') }}?ids=" + selectedIdsString,
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
