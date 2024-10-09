@extends('layouts.app')

@section('title', 'Inquery Memo Perjalanan')

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
                    <h1 class="m-0">Inquery Memo Perjalanan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Inquery Memo Perjalanan</li>
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
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-ban"></i> Error!
                    </h5>
                    {{ session('error') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Inquery Memo Perjalanan</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="GET" id="form-action">
                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <select class="custom-select form-control" id="kategori" name="kategori">
                                    <option value="">- Semua Kategori -</option>
                                    <option value="Memo Perjalanan"
                                        {{ Request::get('kategori') == 'Memo Perjalanan' ? 'selected' : '' }}>
                                        Memo Perjalanan
                                    </option>
                                    <option value="Memo Borong"
                                        {{ Request::get('kategori') == 'Memo Borong' ? 'selected' : '' }}>
                                        Memo Borong</option>
                                    <option value="Memo Tambahan"
                                        {{ Request::get('') == 'Memo Tambahan' ? 'selected' : '' }}>
                                        Memo Tambahan</option>
                                </select>
                                <label for="status">(Pilih Kategori Memo)</label>
                            </div>
                            <div class="col-md-2 mb-3">
                                <select class="custom-select form-control" id="status" name="status">
                                    <option value="">- Semua Status -</option>
                                    <option value="selesai" {{ Request::get('status') == 'selesai' ? 'selected' : '' }}>
                                        Aktif
                                    </option>
                                    <option value="posting" {{ Request::get('status') == 'posting' ? 'selected' : '' }}>
                                        Posting
                                    </option>
                                    <option value="unpost" {{ Request::get('status') == 'unpost' ? 'selected' : '' }}>
                                        Unpost</option>
                                    <option value="rilis" {{ Request::get('status') == 'rilis' ? 'selected' : '' }}>
                                        Rilis</option>
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
                            {{-- <div class="col-md-2 mb-3">
                                <button type="button" class="btn btn-outline-primary mr-2" onclick="cari()">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                            </div> --}}
                            <div class="col-md-2 mb-3">
                                <button type="button" class="btn btn-outline-primary btn-block" onclick="cari()">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                                <input type="hidden" name="ids" id="selectedIds" value="">
                                <button type="button" class="btn btn-primary btn-block mt-1" id="checkfilter"
                                    onclick="printSelectedData()" target="_blank">
                                    <i class="fas fa-print"></i> Cetak Filter
                                </button>
                                <button type="button" class="btn btn-success btn-block" onclick="printExportexcel()">
                                    <i class="fas fa-file-excel"></i> Export Excel
                                </button>
                            </div>
                        </div>
                    </form>
                    {{-- @if (auth()->user()->id == 1 || auth()->user()->id == 4 || auth()->user()->id == 31) --}}
                    {{-- @if (Request::get('kategori') == 'Memo Perjalanan') --}}
                    <form method="GET" id="form-action">
                        <div class="row">
                            @if (auth()->check() && auth()->user()->fitur['inquery memo perjalanan posting'])
                                <div class="col-md-2 mb-3">
                                    <input type="hidden" name="ids" id="selectedIds" value="">
                                    <button type="button" class="btn btn-success btn-block mt-1" id="postingfilter"
                                        onclick="postingSelectedData()">
                                        <i class="fas fa-check-square"></i> Posting Filter
                                    </button>
                                </div>
                            @endif
                            @if (auth()->check() && auth()->user()->fitur['inquery memo perjalanan unpost'])
                                <div class="col-md-2 mb-3">
                                    <input type="hidden" name="ids" id="selectedIdss" value="">
                                    <button type="button" class="btn btn-warning btn-block mt-1" id="unpostfilter"
                                        onclick="unpostSelectedData()">
                                        <i class="fas fa-times-circle"></i> Unpost Filter
                                    </button>
                                </div>
                            @endif
                        </div>
                    </form>
                    {{-- @endif --}}
                    <table id="datatables66" class="table table-bordered table-striped table-hover"
                        style="font-size: 13px">
                        <thead class="thead-dark">
                            <tr>
                                <th> <input type="checkbox" name="" id="select_all_ids"></th>
                                <th class="text-center">No</th>
                                <th>No Memo</th>
                                <th>Tanggal</th>
                                <th>Sopir</th>
                                <th>No Kabin</th>
                                <th>Rute</th>
                                <th>U. Jalan</th>
                                <th>U. Tambah</th>
                                <th>Deposit</th>
                                {{-- <th>Adm</th> --}}
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inquery as $memoekspedisi)
                                <tr class="dropdown"{{ $memoekspedisi->id }}>
                                    <td><input type="checkbox" name="selectedIds[]" class="checkbox_ids"
                                            value="{{ $memoekspedisi->id }}">
                                    </td>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>
                                        {{ $memoekspedisi->kode_memo }}</td>
                                    <td>
                                        {{ $memoekspedisi->tanggal_awal }}</td>
                                    <td>
                                        {{ substr($memoekspedisi->nama_driver, 0, 10) }} ..
                                    </td>
                                    <td>
                                        {{ $memoekspedisi->no_kabin }}
                                    </td>
                                    <td>
                                        @if ($memoekspedisi->nama_rute == null)
                                            rute tidak ada
                                        @else
                                            {{ $memoekspedisi->nama_rute }}
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        {{ number_format($memoekspedisi->uang_jalan, 0, ',', '.') }}
                                    </td>
                                    <td class="text-right">
                                        @if ($memoekspedisi->biaya_tambahan == null)
                                            0
                                        @else
                                            {{ number_format($memoekspedisi->biaya_tambahan, 0, ',', '.') }}
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        @if ($memoekspedisi->deposit_driver == null)
                                            0
                                        @else
                                            {{ number_format($memoekspedisi->deposit_driver, 0, ',', '.') }}
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        {{ number_format($memoekspedisi->sub_total, 0, ',', '.') }}
                                    </td>
                                    <td class="text-center">
                                        @if ($memoekspedisi->status == 'rilis')
                                            <button type="button" class="btn btn-primary btn-sm">
                                                <i class="fas fa-check" style="opacity: 0; background: transparent;"></i>
                                            </button>
                                        @endif
                                        @if ($memoekspedisi->status == 'unpost')
                                            <button type="button" class="btn btn-warning btn-sm">
                                                <i class="fas fa-check" style="opacity: 0; background: transparent;"></i>
                                            </button>
                                        @endif
                                        @if ($memoekspedisi->status == 'posting')
                                            <button type="button" class="btn btn-success btn-sm">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        @endif
                                        @if ($memoekspedisi->status == 'selesai')
                                            <button type="button" class="btn btn-danger btn-sm">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        @endif
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            @if ($memoekspedisi->status == 'rilis')
                                                @if (auth()->check() && auth()->user()->fitur['inquery memo perjalanan update'])
                                                    @if ($memoekspedisi->spk_id == null)
                                                        <a class="dropdown-item"
                                                            href="{{ url('admin/inquery_memoekspedisi/' . $memoekspedisi->id . '/edit') }}">Update</a>
                                                    @else
                                                        <a class="dropdown-item"
                                                            href="{{ url('admin/inquery_memoekspedisispk/' . $memoekspedisi->id . '/edit') }}">Update</a>
                                                    @endif
                                                @endif
                                                @if (auth()->check() && auth()->user()->fitur['inquery memo perjalanan show'])
                                                    <a class="dropdown-item"
                                                        href="{{ url('admin/inquery_memoekspedisi/' . $memoekspedisi->id) }}">Show</a>
                                                @endif
                                                @if (auth()->check() && auth()->user()->fitur['inquery memo perjalanan delete'])
                                                    <form style="margin-top:5px" method="GET"
                                                        action="{{ route('hapusmemo', ['id' => $memoekspedisi->id]) }}">
                                                        <button type="submit"
                                                            class="dropdown-item btn btn-outline-danger btn-block mt-2">
                                                            </i> Delete
                                                        </button>
                                                    </form>
                                                @endif
                                            @endif
                                            @if ($memoekspedisi->status == 'unpost')
                                                @if ($saldoTerakhir->sisa_saldo < $memoekspedisi->uang_jalan)
                                                    <a class="dropdown-item">Saldo tidak cukup</a>
                                                @else
                                                    @if (auth()->check() && auth()->user()->fitur['inquery memo perjalanan posting'])
                                                        <a class="dropdown-item posting-btn"
                                                            data-memo-id="{{ $memoekspedisi->id }}">Posting</a>
                                                    @endif
                                                @endif
                                                @if (auth()->check() && auth()->user()->fitur['inquery memo perjalanan update'])
                                                    @if ($memoekspedisi->spk_id == null)
                                                        <a class="dropdown-item"
                                                            href="{{ url('admin/inquery_memoekspedisi/' . $memoekspedisi->id . '/edit') }}">Update</a>
                                                    @else
                                                        <a class="dropdown-item"
                                                            href="{{ url('admin/inquery_memoekspedisispk/' . $memoekspedisi->id . '/edit') }}">Update</a>
                                                    @endif
                                                @endif
                                                @if (auth()->check() && auth()->user()->fitur['inquery memo perjalanan show'])
                                                    <a class="dropdown-item"
                                                        href="{{ url('admin/inquery_memoekspedisi/' . $memoekspedisi->id) }}">Show</a>
                                                @endif
                                                @if (auth()->check() && auth()->user()->fitur['inquery memo perjalanan delete'])
                                                    <form style="margin-top:5px" method="GET"
                                                        action="{{ route('hapusmemo', ['id' => $memoekspedisi->id]) }}">
                                                        <button type="submit"
                                                            class="dropdown-item btn btn-outline-danger btn-block mt-2">
                                                            </i> Delete
                                                        </button>
                                                    </form>
                                                @endif
                                            @endif
                                            @if ($memoekspedisi->status == 'posting')
                                                @if (auth()->check() && auth()->user()->fitur['inquery memo perjalanan unpost'])
                                                    <a class="dropdown-item unpost-btn"
                                                        data-memo-id="{{ $memoekspedisi->id }}">Unpost</a>
                                                @endif
                                                @if (auth()->check() && auth()->user()->fitur['inquery memo perjalanan show'])
                                                    <a class="dropdown-item"
                                                        href="{{ url('admin/inquery_memoekspedisi/' . $memoekspedisi->id) }}">Show</a>
                                                @endif
                                            @endif
                                            @if ($memoekspedisi->status == 'selesai')
                                                @if (auth()->check() && auth()->user()->fitur['inquery memo perjalanan show'])
                                                    <a class="dropdown-item"
                                                        href="{{ url('admin/inquery_memoekspedisi/' . $memoekspedisi->id) }}">Show</a>
                                                @endif
                                            @endif
                                            @if ($memoekspedisi->detail_faktur->first())
                                                <p style="margin-left:15px; margin-right:15px">Digunakan Oleh Faktur
                                                    Ekspedisi
                                                    <strong>
                                                        @if ($memoekspedisi->detail_faktur->first()->faktur_ekspedisi)
                                                            {{ $memoekspedisi->detail_faktur->first()->faktur_ekspedisi->kode_faktur }}
                                                        @else
                                                            tidak ada
                                                        @endif
                                                    </strong>
                                                </p>
                                            @else
                                                <!-- Kode yang ingin Anda jalankan jika kondisi tidak terpenuhi -->
                                            @endif
                                        </div>
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


    {{-- unpost memo  --}}
    <script>
        $(document).ready(function() {
            $('.unpost-btn').click(function() {
                var memoId = $(this).data('memo-id');

                $(this).addClass('disabled');
                // Tampilkan modal loading saat permintaan AJAX diproses
                $('#modal-loading').modal('show');

                // Kirim permintaan AJAX untuk melakukan unpost
                $.ajax({
                    url: "{{ url('admin/inquery_memoekspedisi/unpostmemo/') }}/" + memoId,
                    type: 'GET',
                    data: {
                        id: memoId
                    },
                    success: function(response) {
                        // Sembunyikan modal loading setelah permintaan selesai
                        $('#modal-loading').modal('hide');

                        // Tampilkan pesan sukses atau lakukan tindakan lain sesuai kebutuhan
                        console.log(response);

                        // Tutup modal setelah berhasil unpost
                        $('#modal-posting-' + memoId).modal('hide');

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
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            $('.posting-btn').click(function() {

                var memoId = $(this).data('memo-id');

                $(this).addClass('disabled');

                // Kirim permintaan AJAX untuk melakukan posting
                $.ajax({
                    url: "{{ url('admin/inquery_memoekspedisi/postingmemo/') }}/" + memoId,
                    type: 'GET',
                    success: function(response) {
                        // Periksa apakah ada pesan success dalam respons
                        if (response.success) {
                            // Tampilkan modal loading saat permintaan AJAX berhasil
                            $('#modal-loading').modal('show');

                            // Tutup modal setelah berhasil posting
                            $('#modal-posting-' + memoId).modal('hide');

                            // Muat ulang halaman untuk menyegarkan tabel
                            location.reload();
                        } else if (response.error) {
                            // Tampilkan modal validasi gagal dengan pesan error
                            $('#validationMessage').text(response.error);
                            $('#validationModal').modal('show');
                        }
                    },
                    error: function(xhr, status, error) {
                        // Tampilkan pesan error yang dihasilkan oleh AJAX
                        alert("Terjadi kesalahan: " + xhr.responseText);
                    },
                    complete: function() {
                        // Sembunyikan modal loading setelah permintaan AJAX selesai
                        $('#modal-loading').modal('hide');
                    }
                });
            });
        });
    </script>



    <script>
        var tanggalAwal = document.getElementById('tanggal_awal');
        var tanggalAkhir = document.getElementById('tanggal_akhir');
        var kategori = document.getElementById('kategori');
        var form = document.getElementById('form-action');
        var validationMessage = document.getElementById('validationMessage');

        // Disable tanggalAkhir jika tanggalAwal belum diisi
        if (tanggalAwal.value == "") {
            tanggalAkhir.readOnly = true;
        }

        // Event listener untuk perubahan tanggalAwal
        tanggalAwal.addEventListener('change', function() {
            if (this.value == "") {
                tanggalAkhir.readOnly = true;
            } else {
                tanggalAkhir.readOnly = false;
            }

            // Reset tanggalAkhir setelah tanggalAwal dipilih
            tanggalAkhir.value = "";
            var today = new Date().toISOString().split('T')[0];
            tanggalAkhir.value = today;
            tanggalAkhir.setAttribute('min', this.value);
        });

        // Fungsi untuk validasi dan menjalankan pencarian
        function cari() {
            // Validasi apakah kategori dipilih
            if (kategori.value === "") {
                validationMessage.innerText = "Mohon pilih kategori memo terlebih dahulu.";
                $('#validationModal').modal('show'); // Tampilkan modal
                return false; // Cegah pengiriman form
            }

            // Validasi apakah tanggal awal diisi
            if (tanggalAwal.value === "") {
                validationMessage.innerText = "Mohon masukkan tanggal awal.";
                $('#validationModal').modal('show'); // Tampilkan modal
                return false; // Cegah pengiriman form
            }

            // Jika validasi lolos, kirim form
            form.action = "{{ url('admin/inquery_memoekspedisi') }}";
            form.submit();
        }
    </script>


    <script>
        $(document).ready(function() {
            // Detect the change event on the 'status' dropdown
            $('#statusx').on('change', function() {
                // Get the selected value
                var selectedValue = $(this).val();

                // Check the selected value and redirect accordingly
                switch (selectedValue) {
                    case 'memo_perjalanan':
                        window.location.href = "{{ url('admin/inquery_memoekspedisi') }}";
                        break;
                    case 'memo_borong':
                        window.location.href = "{{ url('admin/inquery_memoborong') }}";
                        break;
                    case 'memo_tambahan':
                        window.location.href = "{{ url('admin/inquery_memotambahan') }}";
                        break;
                    default:
                        // Handle other cases or do nothing
                        break;
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
                window.location.href = "{{ url('admin/cetak_memoekspedisifilter') }}?ids=" + selectedIdsString;
                // var url = "{{ url('admin/ban/cetak_pdffilter') }}?ids=" + selectedIdsString;
            }
        }
    </script>

    <script>
        $(function(e) {
            $("#select_all_ids").click(function() {
                $('.checkbox_ids').prop('checked', $(this).prop('checked'))
            })
        });

        function postingSelectedData() {
            var selectedIds = document.querySelectorAll(".checkbox_ids:checked");
            if (selectedIds.length === 0) {
                // Tampilkan modal peringatan jika tidak ada item yang dipilih
                $('#validationMessage').text('Harap centang setidaknya satu item sebelum posting.');
                $('#validationModal').modal('show');
            } else {
                var totalUangJalan = 0; // Tambahkan variabel untuk menyimpan total uang jalan
                var selectedCheckboxes = document.querySelectorAll('.checkbox_ids:checked');
                var selectedIds = [];
                var driverCounts = {}; // Object untuk menyimpan jumlah kemunculan setiap nama sopir
                selectedCheckboxes.forEach(function(checkbox) {
                    selectedIds.push(checkbox.value);
                    var driverName = checkbox.parentNode.parentNode.querySelector("td:nth-child(5)").innerText
                        .trim();
                    driverCounts[driverName] = (driverCounts[driverName] || 0) +
                        1; // Menambah jumlah kemunculan nama sopir

                    // Tambahkan uang jalan dari setiap item yang dicentang ke total
                    totalUangJalan += parseInt(checkbox.parentNode.parentNode.querySelector("td:nth-child(8)")
                        .innerText.replace(/\./g, ''));
                });

                // Lakukan pengecekan total uang jalan dengan saldo terakhir
                if (totalUangJalan > parseInt("{{ $saldoTerakhir->sisa_saldo }}")) {
                    // Tampilkan pesan kesalahan jika total uang jalan melebihi saldo terakhir
                    $('#validationMessage').text('Saldo tidak mencukupi untuk melakukan posting.');
                    $('#validationModal').modal('show');
                    return; // Hentikan proses posting jika saldo tidak mencukupi
                }

                // Lakukan pengecekan untuk setiap nama sopir
                var hasError = false;
                Object.keys(driverCounts).forEach(function(driverName) {
                    if (driverCounts[driverName] >= 4) {
                        // Tampilkan modal peringatan jika terdapat 4 atau lebih item dengan nama sopir yang sama
                        $('#validationMessage').text(
                            'Anda tidak dapat melakukan posting karena terdapat 4 atau lebih item dengan nama sopir yang sama: ' +
                            driverName);
                        $('#validationModal').modal('show');
                        hasError = true;
                    }
                });

                if (!hasError) {
                    document.getElementById('postingfilter').value = selectedIds.join(',');
                    var selectedIdsString = selectedIds.join(',');

                    // Tampilkan modal loading sebelum mengirim permintaan AJAX
                    $('#modal-loading').modal('show');

                    $.ajax({
                        url: "{{ url('admin/postingfilter') }}?ids=" + selectedIdsString,
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
        }
    </script>

    <script>
        $(function(e) {
            $("#select_all_ids").click(function() {
                $('.checkbox_ids').prop('checked', $(this).prop('checked'))
            })
        });

        function unpostSelectedData() {
            var selectedIds = document.querySelectorAll(".checkbox_ids:checked");
            if (selectedIds.length === 0) {
                alert("Harap centang setidaknya satu item sebelum unpost.");
            } else {
                var selectedCheckboxes = document.querySelectorAll('.checkbox_ids:checked');
                var selectedIds = [];
                selectedCheckboxes.forEach(function(checkbox) {
                    selectedIds.push(checkbox.value);
                });
                document.getElementById('unpostfilter').value = selectedIds.join(',');
                var selectedIdsString = selectedIds.join(',');

                // Tampilkan modal loading sebelum mengirim permintaan AJAX
                $('#modal-loading').modal('show');

                $.ajax({
                    url: "{{ url('admin/unpostfilter') }}?ids=" + selectedIdsString,
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

    <script>
        $(document).ready(function() {
            $('tbody tr.dropdown').click(function(e) {
                // Memeriksa apakah yang diklik adalah checkbox
                if ($(e.target).is('input[type="checkbox"]')) {
                    return; // Jika ya, hentikan eksekusi
                }

                // Menghapus kelas 'selected' dan mengembalikan warna latar belakang ke warna default dari semua baris
                $('tr.dropdown').removeClass('selected').css('background-color', '');

                // Menambahkan kelas 'selected' ke baris yang dipilih dan mengubah warna latar belakangnya
                $(this).addClass('selected').css('background-color', '#b0b0b0');

                // Menyembunyikan dropdown pada baris lain yang tidak dipilih
                $('tbody tr.dropdown').not(this).find('.dropdown-menu').hide();

                // Mencegah event klik menyebar ke atas (misalnya, saat mengklik dropdown)
                e.stopPropagation();
            });

            $('tbody tr.dropdown').contextmenu(function(e) {
                // Memeriksa apakah baris ini memiliki kelas 'selected'
                if ($(this).hasClass('selected')) {
                    // Menampilkan dropdown saat klik kanan
                    var dropdownMenu = $(this).find('.dropdown-menu');
                    dropdownMenu.show();

                    // Mendapatkan posisi td yang diklik
                    var clickedTd = $(e.target).closest('td');
                    var tdPosition = clickedTd.position();

                    // Menyusun posisi dropdown relatif terhadap td yang di klik
                    dropdownMenu.css({
                        'position': 'absolute',
                        'top': tdPosition.top + clickedTd
                            .height(), // Menempatkan dropdown sedikit di bawah td yang di klik
                        'left': tdPosition
                            .left // Menempatkan dropdown di sebelah kiri td yang di klik
                    });

                    // Mencegah event klik kanan menyebar ke atas (misalnya, saat mengklik dropdown)
                    e.stopPropagation();
                    e.preventDefault(); // Mencegah munculnya konteks menu bawaan browser
                }
            });

            // Menyembunyikan dropdown saat klik di tempat lain
            $(document).click(function() {
                $('.dropdown-menu').hide();
                $('tr.dropdown').removeClass('selected').css('background-color',
                    ''); // Menghapus warna latar belakang dari semua baris saat menutup dropdown
            });
        });
    </script>

    <script>
        function printExportexcel() {
            var startDate = tanggalAwal.value;
            var endDate = tanggalAkhir.value;

            if (startDate && endDate) {
                var form = document.getElementById('form-action');
                form.action = "{{ url('admin/inquery_memoperjalanan/rekapexportmemoperjalanan') }}";
                form.submit();
            } else {
                alert("Silakan isi kedua tanggal sebelum mengeksport.");
            }
        }
    </script>
@endsection
