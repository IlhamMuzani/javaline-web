@extends('layouts.app')

@section('title', 'Data Inventory Peralatan')

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
                    <h1 class="m-0">Data Inventory Peralatan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Data Inventory Peralatan</li>
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
                    <h3 class="card-title">Data Inventory Peralatan</h3>
                    <div class="float-right">
                        {{-- <a href="{{ url('admin/inventory_peralatan/create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah
                        </a> --}}
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="GET" id="form-action">
                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <select class="select2bs4 select2-hidden-accessible" name="kendaraan_id"
                                    data-placeholder="Cari Kode.." style="width: 100%;" data-select2-id="23" tabindex="-1"
                                    aria-hidden="true" id="kendaraan_id">
                                    <option value="">- Pilih -</option>
                                    @foreach ($kendaraans as $kendaraan)
                                        <option value="{{ $kendaraan->id }}"
                                            {{ Request::get('kendaraan_id') == $kendaraan->id ? 'selected' : '' }}>
                                            {{ $kendaraan->no_kabin }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="status">(Cari Kendaraan)</label>
                            </div>
                            <div class="col-md-2 mb-3">
                                <button type="button" class="btn btn-outline-primary btn-block" onclick="cari()">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                                <input type="hidden" name="ids" id="selectedIds" value="">
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive" style="overflow-x: auto;">
                        <table style="font-size: 15px" id="datatables66"
                            class="table table-bordered table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    {{-- <th> <input type="checkbox" name="" id="select_all_ids"></th> --}}
                                    <th class="text-center">No</th>
                                    <th>Kode Peralatan</th>
                                    <th>Nama Peralatan</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($detail_inventorys as $inventory_peralatan)
                                    <tr>
                                        {{-- <td><input type="checkbox" name="selectedIds[]" class="checkbox_ids"
                                            value="{{ $inventory_peralatan->id }}">
                                    </td> --}}
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>
                                            @if ($inventory_peralatan->sparepart)
                                                {{ $inventory_peralatan->sparepart->kode_partdetail }}
                                            @else
                                                tidak ada
                                            @endif
                                        </td>
                                        <td>
                                            @if ($inventory_peralatan->sparepart)
                                                {{ $inventory_peralatan->sparepart->nama_barang }}
                                            @else
                                                tidak ada
                                            @endif
                                        </td>
                                        <td>
                                            @if ($inventory_peralatan->sparepart->detail_inventory->first())
                                                {{ $inventory_peralatan->sparepart->detail_inventory->first()->jumlah }}
                                            @else
                                                tidak ada
                                            @endif
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
        var form = document.getElementById('form-action');

        function cari() {
            form.action = "{{ url('admin/inventory_peralatan') }}";
            form.submit();
        }

        // check semua 
        $(function(e) {
            $("#select_all_ids").click(function() {
                $('.checkbox_ids').prop('checked', $(this).prop('checked'))
            })
        });

        // print
        var form2 = document.getElementById('form-action2');

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
                window.location.href = "{{ url('admin/cetak_pdffilter') }}?ids=" + selectedIdsString;
                // var url = "{{ url('admin/inventory_peralatan/cetak_pdffilter') }}?ids=" + selectedIdsString;
            }
        }

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
            form.action = "{{ url('admin/inventory_peralatan') }}";
            form.submit();
        }
    </script>
@endsection
