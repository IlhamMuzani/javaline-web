@extends('layouts.app')

@section('title', 'Inquery Memo Asuransi')

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
                    <h1 class="m-0">Inquery Memo Asuransi</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Inquery Memo Asuransi</li>
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
                        <i class="icon fas fa-ban"></i> Error!
                    </h5>
                    {{ session('error') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Inquery Memo Asuransi</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="GET" id="form-action">
                        <div class="row">
                            <div class="col-md-3 mb-3">
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
                            <div class="col-md-3 mb-3">
                                <button type="button" class="btn btn-outline-primary btn-block" onclick="cari()">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                                <input type="hidden" name="ids" id="selectedIds" value="">
                                <button type="button" class="btn btn-primary btn-block mt-1" id="checkfilter"
                                    onclick="printSelectedData()" target="_blank">
                                    <i class="fas fa-print"></i> Cetak Filter
                                </button>
                            </div>
                        </div>
                    </form>
                    {{-- @if (auth()->user()->id == 1 || auth()->user()->id == 4 || auth()->user()->id == 31) --}}
                    {{-- @if (Request::get('kategori') == 'Memo Asuransi') --}}
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
                    <div class="table-responsive" style="overflow-x: auto;">
                        <table id="datatables66" class="table table-bordered table-striped table-hover"
                            style="font-size: 13px">
                            <thead class="thead-dark">
                                <tr>
                                    <th> <input type="checkbox" name="" id="select_all_ids"></th>
                                    <th class="text-center">No</th>
                                    <th>Kode Memo Asuransi</th>
                                    <th>Kode Spk</th>
                                    <th>Tanggal</th>
                                    <th>Nama Tarif</th>
                                    <th>Nominal</th>
                                    <th>%</th>
                                    <th>Total</th>
                                    <th>Opsi</th>
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
                                            {{ $memoekspedisi->kode_memo }}
                                        </td>
                                        <td>
                                            {{ $memoekspedisi->spk->kode_spk ?? null }}
                                        </td>
                                        <td>
                                            {{ $memoekspedisi->tanggal_awal }}
                                        </td>
                                        <td>
                                            {{ $memoekspedisi->nama_tarif }}
                                        </td>
                                        <td>
                                            {{ number_format($memoekspedisi->nominal_tarif ?? 0, 0, ',', '.') }}
                                        </td>
                                        <td>
                                            {{ $memoekspedisi->persen }}
                                        </td>
                                        <td>
                                            {{ number_format($memoekspedisi->hasil_tarif ?? 0, 0, ',', '.') }}
                                        </td>
                                        <td class="text-center">
                                            @if ($memoekspedisi->status == 'posting')
                                                <button type="button" class="btn btn-success btn-sm">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @endif
                                            @if ($memoekspedisi->status == 'selesai')
                                                <img src="{{ asset('storage/uploads/indikator/faktur.png') }}"
                                                    height="40" width="40" alt="Document">
                                            @endif
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                @if ($memoekspedisi->status == 'rilis')
                                                    @if (auth()->check() && auth()->user()->fitur['inquery memo perjalanan update'])
                                                        <a class="dropdown-item"
                                                            href="{{ url('admin/inquery_memoasuransi/' . $memoekspedisi->id . '/edit') }}">Update</a>
                                                    @endif
                                                    @if (auth()->check() && auth()->user()->fitur['inquery memo perjalanan show'])
                                                        <a class="dropdown-item"
                                                            href="{{ url('admin/inquery_memoasuransi/' . $memoekspedisi->id) }}">Show</a>
                                                    @endif
                                                    @if (auth()->check() && auth()->user()->fitur['inquery memo perjalanan delete'])
                                                        <form style="margin-top:5px" method="GET"
                                                            action="{{ route('hapusmemoasuransi', ['id' => $memoekspedisi->id]) }}">
                                                            <button type="submit"
                                                                class="dropdown-item btn btn-outline-danger btn-block mt-2">
                                                                </i> Delete
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endif
                                                @if ($memoekspedisi->status == 'unpost')
                                                    @if ($saldoTerakhir->sisa_saldo < $memoekspedisi->hasil_tarif)
                                                        <a class="dropdown-item">Saldo tidak cukup</a>
                                                    @else
                                                        @if (auth()->check() && auth()->user()->fitur['inquery memo perjalanan posting'])
                                                            <a class="dropdown-item posting-btn"
                                                                data-memo-id="{{ $memoekspedisi->id }}">Posting</a>
                                                        @endif
                                                    @endif
                                                    @if (auth()->check() && auth()->user()->fitur['inquery memo perjalanan update'])
                                                        <a class="dropdown-item"
                                                            href="{{ url('admin/inquery_memoasuransi/' . $memoekspedisi->id . '/edit') }}">Update</a>
                                                    @endif
                                                    @if (auth()->check() && auth()->user()->fitur['inquery memo perjalanan show'])
                                                        <a class="dropdown-item"
                                                            href="{{ url('admin/inquery_memoasuransi/' . $memoekspedisi->id) }}">Show</a>
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
                                                            href="{{ url('admin/inquery_memoasuransi/' . $memoekspedisi->id) }}">Show</a>
                                                    @endif
                                                @endif
                                                @if ($memoekspedisi->status == 'selesai')
                                                    @if (auth()->check() && auth()->user()->fitur['inquery memo perjalanan show'])
                                                        <a class="dropdown-item"
                                                            href="{{ url('admin/inquery_memoasuransi/' . $memoekspedisi->id) }}">Show</a>
                                                    @endif
                                                @endif
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
                    url: "{{ url('admin/inquery_memoasuransi/unpostmemoasuransi/') }}/" + memoId,
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
                // Tampilkan modal loading saat permintaan AJAX diproses
                $('#modal-loading').modal('show');

                // Kirim permintaan AJAX untuk melakukan posting
                $.ajax({
                    url: "{{ url('admin/inquery_memoasuransi/postingmemoasuransi/') }}/" + memoId,
                    type: 'GET',
                    data: {
                        id: memoId
                    },
                    success: function(response) {
                        // Sembunyikan modal loading setelah permintaan selesai
                        $('#modal-loading').modal('hide');

                        // Tampilkan pesan sukses atau lakukan tindakan lain sesuai kebutuhan
                        console.log(response);

                        // Tutup modal setelah berhasil posting
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
        var tanggalAwal = document.getElementById('tanggal_awal');
        var tanggalAkhir = document.getElementById('tanggal_akhir');
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

            // Validasi apakah tanggal awal diisi
            if (tanggalAwal.value === "") {
                validationMessage.innerText = "Mohon masukkan tanggal awal.";
                $('#validationModal').modal('show'); // Tampilkan modal
                return false; // Cegah pengiriman form
            }

            // Jika validasi lolos, kirim form
            form.action = "{{ url('admin/inquery_memoasuransi') }}";
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
                window.location.href = "{{ url('admin/cetak_asuransifilter') }}?ids=" + selectedIdsString;
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

        function getTotalGrandTotal() {
            var totalGrandTotal = 0;
            var selectedCheckboxes = document.querySelectorAll('.checkbox_ids:checked');

            selectedCheckboxes.forEach(function(checkbox) {
                var grandTotal = parseFloat(checkbox.closest('tr').querySelector('td:nth-child(9)').textContent
                    .replace(/\D/g, ''));
                totalGrandTotal += grandTotal;
            });

            return totalGrandTotal;
        }

        function postingSelectedData() {
            var totalGrandTotal = getTotalGrandTotal();
            var saldoTerakhir = parseFloat("{{ $saldoTerakhir->sisa_saldo }}");

            console.log(totalGrandTotal);

            if (totalGrandTotal > saldoTerakhir) {
                // Update pesan validasi di dalam modal
                document.getElementById('validationMessage').textContent = "Saldo tidak mencukupi untuk melakukan posting.";

                // Tampilkan modal validasi
                $('#validationModal').modal('show');
            } else {
                var selectedCheckboxes = document.querySelectorAll('.checkbox_ids:checked');
                if (selectedCheckboxes.length === 0) {
                    // Update pesan validasi untuk kasus checkbox tidak dipilih
                    document.getElementById('validationMessage').textContent =
                        "Harap centang setidaknya satu item sebelum posting.";

                    // Tampilkan modal validasi
                    $('#validationModal').modal('show');
                } else {
                    var selectedIds = [];
                    selectedCheckboxes.forEach(function(checkbox) {
                        selectedIds.push(checkbox.value);
                    });
                    document.getElementById('postingfilter').value = selectedIds.join(',');
                    var selectedIdsString = selectedIds.join(',');

                    // Tampilkan modal loading sebelum mengirim permintaan AJAX
                    $('#modal-loading').modal('show');

                    $.ajax({
                        url: "{{ url('admin/postingasuransifilter') }}?ids=" + selectedIdsString,
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
                    url: "{{ url('admin/unpostasuransifilter') }}?ids=" + selectedIdsString,
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
        $(function(e) {
            $("#select_all_ids").click(function() {
                $('.checkbox_ids').prop('checked', $(this).prop('checked'))
            })
        });

        function excelSelectedData() {
            var selectedIds = document.querySelectorAll(".checkbox_ids:checked");
            if (selectedIds.length === 0) {
                alert("Harap centang setidaknya satu item sebelum export.");
            } else {
                var selectedCheckboxes = document.querySelectorAll('.checkbox_ids:checked');
                var selectedIds = [];
                selectedCheckboxes.forEach(function(checkbox) {
                    selectedIds.push(checkbox.value);
                });
                document.getElementById('selectedIds').value = selectedIds.join(',');
                var selectedIdsString = selectedIds.join(',');
                window.location.href = "{{ url('admin/excel_memoekspedisifilter') }}?ids=" + selectedIdsString;
                // var url = "{{ url('admin/ban/cetak_pdffilter') }}?ids=" + selectedIdsString;
            }
        }
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
