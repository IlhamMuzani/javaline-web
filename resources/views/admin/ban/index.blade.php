@extends('layouts.app')

@section('title', 'Data Ban')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Ban</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Data Ban</li>
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
                    <h3 class="card-title">Data Ban</h3>
                    <div class="float-right">
                        @if (auth()->check() && auth()->user()->fitur['ban create'])
                            <a href="{{ url('admin/ban/create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Tambah
                            </a>
                        @endif
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
                                <select class="custom-select form-control mr-2" id="status" name="status">
                                    <option value="">- Semua Status -</option>
                                    <option value="stok" {{ Request::get('status') == 'stok' ? 'selected' : '' }}>
                                        stok</option>
                                    <option value="aktif" {{ Request::get('status') == 'aktif' ? 'selected' : '' }}>
                                        aktif
                                    </option>
                                    <option value="non aktif" {{ Request::get('status') == 'non aktif' ? 'selected' : '' }}>
                                        non aktif</option>
                                </select>
                                <label for="status">(Pilih Status)</label>
                            </div>
                            <div class="col-md-3 mb-3">
                                <input class="form-control" id="tanggal_awal" name="created_at" type="date"
                                    value="{{ Request::get('created_at') }}" max="{{ date('Y-m-d') }}" />
                                <label for="tanggal_awal">(Tanggal Awal)</label>
                            </div>
                            <div class="col-md-3 mb-3">
                                <input class="form-control" id="tanggal_akhir" name="tanggal_akhir" type="date"
                                    value="{{ Request::get('tanggal_akhir') }}" max="{{ date('Y-m-d') }}" />
                                <label for="tanggal_awal">(Tanggal Akhir)</label>
                            </div>
                            <div class="col-md-2 mb-3">
                                <button type="button" class="btn btn-outline-primary btn-block" onclick="cari()">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                                <input type="hidden" name="ids" id="selectedIds" value="">
                                <button type="button" class="btn btn-primary btn-block mt-1" id="checkfilter"
                                    onclick="printSelectedData()" target="_blank">
                                    <i class="fas fa-print"></i> Cetak
                                </button>
                            </div>
                        </div>
                    </form>
                    <table style="font-size: 15px" id="datatables66" class="table table-bordered table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th> <input type="checkbox" name="" id="select_all_ids"></th>
                                <th class="text-center">No</th>
                                <th>Kode Ban</th>
                                <th>No Seri</th>
                                <th>Merek Ban</th>
                                <th>Type Ban</th>
                                <th>Ukuran</th>
                                <th class="text-center">Qr Code</th>
                                <th>Keterangan</th>
                                <th class="text-center">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bans as $ban)
                                <tr>
                                    <td><input type="checkbox" name="selectedIds[]" class="checkbox_ids"
                                            value="{{ $ban->id }}">
                                    </td>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $ban->kode_ban }}</td>
                                    <td>{{ $ban->no_seri }}</td>
                                    <td>
                                        @if ($ban->merek)
                                            {{ $ban->merek->nama_merek }}
                                        @else
                                            merek tidak ada
                                        @endif
                                    </td>
                                    <td>
                                        @if ($ban->typeban)
                                            {{ $ban->typeban->nama_type }}
                                        @else
                                            type tidak ada
                                        @endif
                                    </td>
                                    <td>
                                        @if ($ban->ukuran)
                                            {{ $ban->ukuran->ukuran }}
                                        @else
                                            ukuran tidak ada
                                        @endif
                                    </td>
                                    <td data-toggle="modal" data-target="#modal-qrcode-{{ $ban->id }}"
                                        style="text-align: center;">
                                        <div style="display: inline-block;">
                                            {!! DNS2D::getBarcodeHTML("$ban->qrcode_ban", 'QRCODE', 2, 2) !!}
                                        </div>
                                    </td>
                                    <td>
                                        @if ($ban->status == 'aktif')
                                            @if ($ban->kendaraan)
                                                {{ $ban->kendaraan->no_kabin }}
                                            @else
                                                tidak ada
                                            @endif
                                        @elseif($ban->status == 'stok')
                                            stok
                                        @elseif($ban->status == 'non aktif')
                                            non aktif
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if (auth()->check() && auth()->user()->fitur['ban show'])
                                            @if ($ban->status == 'aktif')
                                                <button type="submit" class="btn btn-success btn-sm " data-toggle="modal"
                                                    data-target="#modal-detail-{{ $ban->id }}">
                                                    <img src="{{ asset('storage/uploads/indikator/wheel2.png') }}"
                                                        height="17" width="17" alt="Roda Mobil">
                                                </button>
                                            @elseif($ban->status == 'stok')
                                                <button type="submit" class="btn btn-primary btn-sm "
                                                    data-toggle="modal"
                                                    data-target="#modal-detailstok-{{ $ban->id }}">
                                                    <img src="{{ asset('storage/uploads/indikator/wheel2.png') }}"
                                                        height="17" width="17" alt="Roda Mobil">
                                                </button>
                                            @elseif($ban->status == 'non aktif')
                                                <button type="submit" class="btn btn-danger btn-sm ">
                                                    <img src="{{ asset('storage/uploads/indikator/wheel2.png') }}"
                                                        height="17" width="17" alt="Roda Mobil">
                                                </button>
                                            @endif
                                        @endif
                                        @if (auth()->check() && auth()->user()->fitur['ban show'])
                                            <a href="{{ url('admin/ban/' . $ban->id) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        @endif
                                        @if (auth()->check() && auth()->user()->fitur['ban update'])
                                            <a href="{{ url('admin/ban/' . $ban->id . '/edit') }}"
                                                class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endif
                                        @if (auth()->check() && auth()->user()->fitur['ban delete'])
                                            <button type="submit" class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#modal-hapus-{{ $ban->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                                <div class="modal fade" id="modal-hapus-{{ $ban->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Hapus Ban</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Yakin hapus ban <strong>{{ $ban->no_seri }}</strong>?
                                                </p>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Batal</button>
                                                <form action="{{ url('admin/ban/' . $ban->id) }}" method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="modal-detail-{{ $ban->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Detail Keterangan</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="col-md">
                                                    <div class="row mb-3">
                                                        <div class="col-md">
                                                            <strong>No Kabin</strong>
                                                        </div>
                                                        <div class="col">
                                                            @if ($ban->kendaraan)
                                                                {{ $ban->kendaraan->no_kabin }}
                                                            @else
                                                                tidak ada
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col">
                                                            <strong>No Registrasi</strong>
                                                        </div>
                                                        <div class="col">
                                                            @if ($ban->kendaraan)
                                                                {{ $ban->kendaraan->no_pol }}
                                                            @else
                                                                tidak ada
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col">
                                                            <strong>Jenis Kendaraan</strong>
                                                        </div>
                                                        <div class="col">
                                                            @if ($ban->kendaraan)
                                                                {{ $ban->kendaraan->jenis_kendaraan->nama_jenis_kendaraan }}
                                                            @else
                                                                tidak ada
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col">
                                                            <strong>Posisi Ban</strong>
                                                        </div>
                                                        <div class="col">
                                                            {{ $ban->posisi_ban }}
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col">
                                                            <strong>Umur Ban</strong>
                                                        </div>
                                                        <div class="col">
                                                            {{ number_format($ban->umur_ban, 0, ',', '.') }} Km
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col">
                                                            <strong>Tanggal Pemasangan</strong>
                                                        </div>
                                                        <div class="col">
                                                            @if ($ban->pemasangan_ban)
                                                                {{ $ban->pemasangan_ban->tanggal }}
                                                            @else
                                                                tidak ada
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal-header">
                                                <h4 class="modal-title">Detail Supplier</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="col-md">
                                                    <div class="row mb-3">
                                                        <div class="col-md">
                                                            <strong>Kode Supplier</strong>
                                                        </div>
                                                        <div class="col">
                                                            @if ($ban->pembelian_ban)
                                                                {{ $ban->pembelian_ban->supplier->kode_supplier }}
                                                            @else
                                                                tidak ada
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col">
                                                            <strong>Nama Supplier</strong>
                                                        </div>
                                                        <div class="col">
                                                            @if ($ban->pembelian_ban)
                                                                {{ $ban->pembelian_ban->supplier->nama_supp }}
                                                            @else
                                                                tidak ada
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col">
                                                            <strong>Tanggal Pembelian</strong>
                                                        </div>
                                                        <div class="col">
                                                            @if ($ban->pembelian_ban)
                                                                {{ $ban->pembelian_ban->tanggal }}
                                                            @else
                                                                tidak ada
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="modal-detailstok-{{ $ban->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Detail Supplier</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="col-md">
                                                    <div class="row mb-3">
                                                        <div class="col-md">
                                                            <strong>Kode Supplier</strong>
                                                        </div>
                                                        <div class="col">
                                                            @if ($ban->pembelian_ban)
                                                                {{ $ban->pembelian_ban->supplier->kode_supplier }}
                                                            @else
                                                                tidak ada
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col">
                                                            <strong>Nama Supplier</strong>
                                                        </div>
                                                        <div class="col">
                                                            @if ($ban->pembelian_ban)
                                                                {{ $ban->pembelian_ban->supplier->nama_supp }}
                                                            @else
                                                                tidak ada
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col">
                                                            <strong>Tanggal Pembelian</strong>
                                                        </div>
                                                        <div class="col">
                                                            @if ($ban->pembelian_ban)
                                                                {{ $ban->pembelian_ban->tanggal }}
                                                            @else
                                                                tidak ada
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="modal-qrcode-{{ $ban->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Gambar QR Code</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div style="text-align: center;">
                                                    <p style="font-size:20px; font-weight: bold;">
                                                        {{ $ban->kode_ban }}</p>
                                                    <div style="display: inline-block;">
                                                        {!! DNS2D::getBarcodeHTML("$ban->qrcode_ban", 'QRCODE', 15, 15) !!}
                                                    </div>
                                                    <p style="font-size:20px; font-weight: bold;">
                                                        {{ $ban->typeban->nama_type }} /
                                                        {{ $ban->ukuran->ukuran }}
                                                    </p>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">Batal</button>
                                                    <a href="{{ url('admin/ban/cetak-pdf/' . $ban->id) }}"
                                                        class="btn btn-primary btn-sm">
                                                        <i class=""></i> Cetak
                                                    </a>
                                                </div>
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
        var form = document.getElementById('form-action');

        function cari() {
            form.action = "{{ url('admin/ban') }}";
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
                // var url = "{{ url('admin/ban/cetak_pdffilter') }}?ids=" + selectedIdsString;
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
            form.action = "{{ url('admin/ban') }}";
            form.submit();
        }
    </script>
@endsection
