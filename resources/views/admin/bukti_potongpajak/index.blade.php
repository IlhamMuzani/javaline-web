@extends('layouts.app')

@section('title', 'List Invoice PPH23')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">List Invoice PPH23</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">List Invoice PPH23</li>
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
                    <h3 class="card-title">Data List Invoice PPH23</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="GET" id="form-action">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="created_at">Status</label>
                                <select class="custom-select form-control" id="status" name="status">
                                    <option value="">- Pilih Laporan -</option>
                                    <option value="pemasukan" selected>Pemasukan</option>
                                    <option value="pengeluaran">Pengeluaran</option>
                                    {{-- <option value="akun">Laporan Kas Keluar Group by Akun</option>
                                    <option value="memo_tambahan">Saldo Kas</option> --}}
                                </select>
                            </div>
                            {{-- <div class="col-md-3 mb-3">
                                <label for="created_at">Status</label>
                                <select class="custom-select form-control" id="kategori" name="kategori">
                                    <option value="">- Semua Status -</option>
                                    <option value="memo" {{ Request::get('kategori') == 'memo' ? 'selected' : '' }}>
                                        MEMO
                                    </option>
                                    <option value="non memo"
                                        {{ Request::get('kategori') == 'non memo' ? 'selected' : '' }}>
                                        NON MEMO</option>
                                </select>
                            </div> --}}
                            <div class="col-md-2 mb-3">
                                <label for="status">Cari Pelanggan</label>
                                <select class="select2bs4 select2-hidden-accessible" name="pelanggan_id"
                                    data-placeholder="Cari Pelanggan.." style="width: 100%;" data-select2-id="23"
                                    tabindex="-1" aria-hidden="true" id="pelanggan_id">
                                    <option value="">- Pilih -</option>
                                    @foreach ($pelanggans as $pelanggan)
                                        <option value="{{ $pelanggan->id }}"
                                            {{ Request::get('pelanggan_id') == $pelanggan->id ? 'selected' : '' }}>
                                            {{ $pelanggan->nama_pell }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="created_at">Tanggal Awal</label>
                                <input class="form-control" id="created_at" name="created_at" type="date"
                                    value="{{ Request::get('created_at') }}" max="{{ date('Y-m-d') }}" />
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="tanggal_akhir">Tanggal Akhir</label>
                                <input class="form-control" id="tanggal_akhir" name="tanggal_akhir" type="date"
                                    value="{{ Request::get('tanggal_akhir') }}" max="{{ date('Y-m-d') }}" />
                            </div>
                            <div class="col-md-3 mb-3">
                                {{-- @if (auth()->check() && auth()->user()->fitur['laporan pengambilan kas kecil cari']) --}}
                                <button type="button" class="btn btn-outline-primary btn-block" onclick="cari()">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                                {{-- @endif
                                @if (auth()->check() && auth()->user()->fitur['laporan pengambilan kas kecil cetak']) --}}
                                <button id="toggle-all" type="button" class="btn btn-info btn-block">
                                    All Toggle Detail
                                </button>
                                {{-- <button id="toggle-all" class="btn btn-info float-right">Buka Semua Detail</button> --}}

                                {{-- @endif --}}
                            </div>
                        </div>
                    </form>
                    <!-- Tabel Faktur Utama -->
                    <table class="table table-bordered table-striped table-hover" style="font-size: 13px">
                        <thead>
                            <tr>
                                <th>Kode Invoice</th>
                                <th>Tanggal</th>
                                <th>Pelanggan</th>
                                <th>DPP</th>
                                <th>PPH23</th>
                                <th class="text-center" style="width:12%">Actions</th>
                                <!-- Tambahkan kolom aksi untuk collapse/expand -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inquery as $index => $faktur)
                                <!-- Gunakan index untuk ID unik -->
                                <!-- Baris Faktur Utama -->
                                <tr data-target="#faktur-{{ $index }}" class="accordion-toggle"
                                    style="background: rgb(156, 156, 156)">
                                    <td>{{ $faktur->kode_tagihan }}</td>
                                    <td>{{ $faktur->created_at }}</td>
                                    <td>{{ $faktur->nama_pelanggan }}</td>
                                    <td class="text-right">{{ number_format($faktur->sub_total, 2, ',', '.') }}</td>
                                    <td class="text-right">{{ number_format($faktur->pph, 2, ',', '.') }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-info btn-sm" data-toggle="collapse"
                                            data-target="#faktur-{{ $index }}"><i class="fas fa-eye"></i></button>
                                        <button class="btn btn-primary ml-2 btn-sm" data-toggle="modal"
                                            data-target="#modal-add-{{ $faktur->id }}"><i
                                                class="fas fa-plus"></i></button>
                                    </td>
                                </tr>
                                <div class="modal fade" id="modal-add-{{ $faktur->id }}">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Masukkan Nomor Bukti</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div style="text-align: left;">
                                                    <form action="{{ url('admin/updatebuktitagihan/' . $faktur->id) }}"
                                                        method="POST" enctype="multipart/form-data" autocomplete="off">
                                                        @csrf
                                                        <div class="card-body">
                                                            <h2>Invoice</h2>

                                                            <div class="form-group mb-3">
                                                                @if ($faktur->gambar_bukti == null)
                                                                    <img class="mt-3"
                                                                        src="{{ asset('storage/uploads/gambaricon/imagenoimage.jpg') }}"
                                                                        alt="tigerload" height="180" width="200">
                                                                @else
                                                                    <img class="mt-3"
                                                                        src="{{ asset('storage/uploads/' . $faktur->gambar_bukti) }}"
                                                                        alt="tigerload" height="180" width="200">
                                                                @endif
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="gambar">Foto bukti <small>(Kosongkan saja
                                                                        jika
                                                                        tidak
                                                                        ingin menambahkan)</small></label>
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input"
                                                                        id="gambar_bukti" name="gambar_bukti"
                                                                        accept="image/*">
                                                                    <label class="custom-file-label"
                                                                        for="gambar_bukti">Masukkan gambar</label>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label for="nomor invoice">Invoice
                                                                            {{ $faktur->kode_tagihan }}</label>
                                                                        <input type="text" class="form-control"
                                                                            id="nomor_buktitagihan"
                                                                            name="nomor_buktitagihan"
                                                                            placeholder="masukkan nomor bukti"
                                                                            value="{{ old('nomor_buktitagihan', $faktur->nomor_buktitagihan) }}"
                                                                            maxlength="10">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label for="nomor invoice">Tanggal Bukti</label>
                                                                        <input type="date" class="form-control"
                                                                            id="tanggal_nomortagihan"
                                                                            name="tanggal_nomortagihan"
                                                                            value="{{ old('tanggal_nomortagihan', $faktur->tanggal_nomortagihan) }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <br>
                                                            <h2>Faktur</h2>
                                                            @foreach ($faktur->detail_tagihan as $item)
                                                                <div class="form-group mb-3">
                                                                    @if ($item->gambar_buktifaktur == null)
                                                                        <img class="mt-3"
                                                                            src="{{ asset('storage/uploads/gambaricon/imagenoimage.jpg') }}"
                                                                            alt="tigerload" height="180"
                                                                            width="200">
                                                                    @else
                                                                        <img class="mt-3"
                                                                            src="{{ asset('storage/uploads/' . $item->gambar_buktifaktur) }}"
                                                                            alt="tigerload" height="180"
                                                                            width="200">
                                                                    @endif
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="gambar">Foto bukti <small>(Kosongkan saja
                                                                            jika tidak ingin menambahkan)</small></label>
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input"
                                                                            id="gambar_buktifaktur_{{ $item->id }}"
                                                                            name="gambar_buktifaktur[{{ $item->id }}]"
                                                                            accept="image/*">
                                                                        <label class="custom-file-label"
                                                                            for="gambar_buktifaktur_{{ $item->id }}">Masukkan
                                                                            gambar</label>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group">
                                                                            <label for="nomor faktur">DPP
                                                                                {{ number_format($item->faktur_ekspedisi->total_tarif, 2, ',', '.') }}</label>
                                                                            <label style="margin-left:40px"
                                                                                for="nomor faktur">PPH
                                                                                {{ number_format($item->faktur_ekspedisi->pph, 2, ',', '.') }}</label>
                                                                            <input type="text" class="form-control"
                                                                                id="nomor_buktifaktur"
                                                                                placeholder="masukkan nomor bukti"
                                                                                name="nomor_buktifaktur[{{ $item->id }}]"
                                                                                placeholder=""
                                                                                value="{{ $item->nomor_buktifaktur }}"
                                                                                maxlength="10">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group">
                                                                            <label for="nomor faktur">Tanggal
                                                                                {{ $item->kode_faktur }}</label>
                                                                            <input type="date" id="tanggal_nomorfaktur"
                                                                                name="tanggal_nomorfaktur[{{ $item->id }}]"
                                                                                placeholder="d M Y"
                                                                                value="{{ old('tanggal_nomorfaktur.' . $item->id, $item->tanggal_nomorfaktur) }}"
                                                                                class="form-control">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <div class="card-footer text-right">
                                                            <button type="reset"
                                                                class="btn btn-secondary">Reset</button>
                                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Baris Detail Faktur -->
                                <tr>
                                    <td colspan="6"> <!-- Gabungkan kolom untuk detail -->
                                        <div id="faktur-{{ $index }}" class="collapse">
                                            <table class="table table-sm" style="margin: 0;">
                                                <thead>
                                                    <tr>
                                                        <th>Kode Faktur</th>
                                                        <th>Tanggal</th>
                                                        <th>Nama Pelanggan</th>
                                                        <th>DPP</th>
                                                        <th>PPH23</th>
                                                        <th>Nomor Bukti</th>
                                                        <th>Tanggal Bukti</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($faktur->detail_tagihan as $faktur)
                                                        <tr>
                                                            <td>{{ $faktur->kode_faktur }}</td>
                                                            <td>{{ $faktur->created_at }}</td>
                                                            <td>{{ $faktur->nama_rute }}</td>
                                                            <td class="text-right">
                                                                {{ number_format($item->faktur_ekspedisi->total_tarif, 2, ',', '.') }}
                                                            </td>
                                                            <td class="text-right">
                                                                {{ number_format($faktur->faktur_ekspedisi->pph, 2, ',', '.') }}
                                                            </td>
                                                            <td>{{ $faktur->nomor_buktifaktur }}</td>
                                                            <td>{{ $faktur->tanggal_nomorfaktur }}</td>
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
            </div>
        </div>
    </section>
    <!-- /.card -->
    <script>
        var tanggalAwal = document.getElementById('created_at');
        var tanggalAkhir = document.getElementById('tanggal_akhir');
        var kendaraanId = document.getElementById('pelanggan_id');
        var form = document.getElementById('form-action');

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

        function cari() {
            // Dapatkan nilai tanggal awal dan tanggal akhir
            var startDate = tanggalAwal.value;
            var endDate = tanggalAkhir.value;
            var Kendaraanid = kendaraanId.value;

            // Cek apakah tanggal awal dan tanggal akhir telah diisi
            if (Kendaraanid) {
                form.action = "{{ url('admin/buktipotong') }}";
                form.submit();
            } else {
                alert("pilih pelanggan.");
            }
        }


        function printReport() {
            var startDate = tanggalAwal.value;
            var endDate = tanggalAkhir.value;

            if (startDate && endDate) {
                form.action = "{{ url('admin/print_mobillogistik') }}" + "?start_date=" + startDate + "&end_date=" +
                    endDate;
                form.submit();
            } else {
                alert("Silakan isi kedua tanggal sebelum mencetak.");
            }
        }
    </script>

    <script>
        $(document).ready(function() {
            // Detect the change event on the 'status' dropdown
            $('#status').on('change', function() {
                // Get the selected value
                var selectedValue = $(this).val();

                // Check the selected value and redirect accordingly
                switch (selectedValue) {
                    case 'pemasukan':
                        window.location.href = "{{ url('admin/laporan_mobillogistik') }}";
                        break;
                    case 'pengeluaran':
                        window.location.href = "{{ url('admin/laporan_mobillogistikglobal') }}";
                        break;
                        // case 'akun':
                        //     window.location.href = "{{ url('admin/laporan_pengeluarankaskecilakun') }}";
                        //     break;
                        // case 'memo_tambahan':
                        //     window.location.href = "{{ url('admin/laporan_saldokas') }}";
                        //     break;
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
            var isExpanded = false; // Status untuk melacak apakah semua detail telah dibuka

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
