@extends('layouts.app')

@section('title', 'Faktur Pelunasan Pembelian Ban')

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
                    <h1 class="m-0">Faktur Pelunasan Pembelian Ban</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Faktur Pelunasan Pembelian Ban</li>
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
                    <h3 class="card-title">Faktur Pelunasan Pembelian Ban</h3>
                    <div class="float-right">
                        @if (auth()->check() && auth()->user()->fitur['create pelunasan faktur pembelian ban'])
                            <a href="{{ url('admin/faktur_pelunasanban') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Tambah
                            </a>
                        @endif
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive" style="overflow-x: auto;">
                        <table id="datatables66" class="table table-bordered table-striped table-hover"
                            style="font-size: 13px">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>No Faktur</th>
                                    <th>Tanggal</th>
                                    <th>Admin</th>
                                    <th>Supplier</th>
                                    {{-- <th>PPH</th> --}}
                                    <th style="text-align: end">Total</th>
                                    <th style="width: 20px">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inquery as $fakturpelunasan)
                                    <tr class="dropdown"{{ $fakturpelunasan->id }}>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $fakturpelunasan->kode_pelunasanban }}</td>
                                        <td>{{ $fakturpelunasan->tanggal_awal }}</td>
                                        <td>
                                            {{ $fakturpelunasan->user->karyawan->nama_lengkap }}
                                        </td>
                                        <td>
                                            {{ $fakturpelunasan->nama_supplier }}
                                        </td>
                                        {{-- <td style="text-align: end">
                                        {{ number_format($fakturpelunasan->pph, 0, ',', '.') }}
                                    </td> --}}
                                        <td style="text-align: end">
                                            {{ number_format($fakturpelunasan->totalpembayaran, 0, ',', '.') }}
                                        </td>
                                        <td class="text-center">
                                            @if ($fakturpelunasan->status == 'posting')
                                                <button type="button" class="btn btn-success btn-sm">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                {{-- <button type="button" class="btn btn-primary btn-sm">
                                                <i class="fas fa-truck-moving"></i>
                                            </button> --}}
                                            @endif
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                @if ($fakturpelunasan->status == 'unpost')
                                                    @if ($fakturpelunasan->deposit_driver_id === null)
                                                        @if (auth()->check() && auth()->user()->fitur['inquery pelunasan faktur pembelian ban posting'])
                                                            <a class="dropdown-item posting-btn"
                                                                data-memo-id="{{ $fakturpelunasan->id }}">Posting</a>
                                                        @endif
                                                        @if (auth()->check() && auth()->user()->fitur['inquery pelunasan faktur pembelian ban update'])
                                                            <a class="dropdown-item"
                                                                href="{{ url('admin/inquery_banpembelianlunas/' . $fakturpelunasan->id . '/edit') }}">Update</a>
                                                        @endif
                                                    @endif
                                                    @if (auth()->check() && auth()->user()->fitur['inquery pelunasan faktur pembelian ban show'])
                                                        <a class="dropdown-item"
                                                            href="{{ url('admin/inquery_banpembelianlunas/' . $fakturpelunasan->id) }}">Show</a>
                                                    @endif
                                                    @if ($fakturpelunasan->deposit_driver_id === null)
                                                        @if (auth()->check() && auth()->user()->fitur['inquery pelunasan faktur pembelian ban delete'])
                                                            <form style="margin-top:5px" method="GET"
                                                                action="{{ route('hapuspelunasanban', ['id' => $fakturpelunasan->id]) }}">
                                                                <button type="submit"
                                                                    class="dropdown-item btn btn-outline-danger btn-block mt-2">
                                                                    </i> Delete
                                                                </button>
                                                            </form>
                                                        @endif
                                                    @endif
                                                @endif
                                                @if ($fakturpelunasan->status == 'posting')
                                                    @if ($fakturpelunasan->deposit_driver_id === null)
                                                        @if (auth()->check() && auth()->user()->fitur['inquery pelunasan faktur pembelian ban unpost'])
                                                            <a class="dropdown-item unpost-btn"
                                                                data-memo-id="{{ $fakturpelunasan->id }}">Unpost</a>
                                                        @endif
                                                    @endif
                                                    @if (auth()->check() && auth()->user()->fitur['inquery pelunasan faktur pembelian ban show'])
                                                        <a class="dropdown-item"
                                                            href="{{ url('admin/inquery_banpembelianlunas/' . $fakturpelunasan->id) }}">Show</a>
                                                    @endif
                                                @endif
                                                @if ($fakturpelunasan->status == 'selesai')
                                                    @if (auth()->check() && auth()->user()->fitur['inquery pelunasan faktur pembelian ban show'])
                                                        <a class="dropdown-item"
                                                            href="{{ url('admin/inquery_banpembelianlunas/' . $fakturpelunasan->id) }}">Show</a>
                                                    @endif
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
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
            form.action = "{{ url('admin/inquery_fakturekspedisi') }}";
            form.submit();
        }
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
                window.location.href = "{{ url('admin/cetak_fakturekspedisifilter') }}?ids=" + selectedIdsString;
                // var url = "{{ url('admin/ban/cetak_pdffilter') }}?ids=" + selectedIdsString;
            }
        }
    </script>

@endsection
