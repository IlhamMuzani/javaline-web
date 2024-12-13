@extends('layouts.app')

@section('title', 'Memo Asuransi Barang')

@section('content')
    <!-- Content Header (Page header) -->
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
                    <h1 class="m-0">Memo Asuransi Barang</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Memo Asuransi Barang</li>
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
                    <h3 class="card-title">Memo Asuransi Barang</h3>
                    <div class="float-right">
                        @if (auth()->check() && auth()->user()->fitur['create memo ekspedisi'])
                            <a href="{{ url('admin/memo-asuransi/create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Tambah
                            </a>
                        @endif
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="datatables66" class="table table-bordered table-striped table-hover" style="font-size: 13px">
                        <thead class="thead-dark">
                            <tr>
                                <th> <input type="checkbox" name="" id="select_all_ids"></th>
                                <th>No</th>
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
                            @foreach ($memo_asuransis as $memos)
                                <tr class="dropdown"{{ $memos->id }}>
                                    <td><input type="checkbox" name="selectedIds[]" class="checkbox_ids"
                                            value="{{ $memos->id }}">
                                    </td>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>
                                        {{ $memos->kode_memo }}
                                    </td>
                                    <td>
                                        {{ $memos->spk->kode_spk ?? null }}
                                    </td>
                                    <td>
                                        {{ $memos->tanggal_awal }}
                                    </td>
                                    <td>
                                        {{ $memos->nama_tarif }}
                                    </td>
                                    <td>
                                        {{ number_format($memos->nominal_tarif ?? 0, 0, ',', '.') }}
                                    </td>
                                    <td>
                                        {{ $memos->persen }}
                                    </td>
                                    <td>
                                        {{ number_format($memos->hasil_tarif ?? 0, 0, ',', '.') }}
                                    </td>
                                    <td class="text-center">
                                        @if ($memos->status == 'posting')
                                            <button type="button" class="btn btn-success btn-sm">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        @endif
                                        @if ($memos->status == 'selesai')
                                            <img src="{{ asset('storage/uploads/indikator/faktur.png') }}" height="40"
                                                width="40" alt="Document">
                                        @endif
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            @if ($memos->status == 'unpost')
                                                @if ($saldoTerakhir->sisa_saldo < $memos->uang_jalan)
                                                    <a class="dropdown-item">Saldo tidak cukup</a>
                                                @else
                                                    @if (auth()->check() && auth()->user()->fitur['inquery memo perjalanan posting'])
                                                        <a class="dropdown-item posting-btn"
                                                            data-memo-id="{{ $memos->id }}">Posting</a>
                                                    @endif
                                                @endif
                                                @if (auth()->check() && auth()->user()->fitur['inquery memo perjalanan update'])
                                                    @if ($memos->spk_id == null)
                                                        <a class="dropdown-item"
                                                            href="{{ url('admin/inquery_memoasuransi/' . $memos->id . '/edit') }}">Update</a>
                                                    @else
                                                        <a class="dropdown-item"
                                                            href="{{ url('admin/inquery_memoasuransi/' . $memos->id . '/edit') }}">Update</a>
                                                    @endif
                                                @endif
                                                {{-- @if (auth()->check() && auth()->user()->fitur['inquery memo perjalanan show'])
                                                    <a class="dropdown-item"
                                                        href="{{ url('admin/inquery_memoasuransi/' . $memos->id) }}">Show</a>
                                                @endif --}}
                                                @if (auth()->check() && auth()->user()->fitur['inquery memo perjalanan delete'])
                                                    <form style="margin-top:5px" method="GET"
                                                        action="{{ route('hapusmemoasuransi', ['id' => $memos->id]) }}">
                                                        <button type="submit"
                                                            class="dropdown-item btn btn-outline-danger btn-block mt-2">
                                                            </i> Delete
                                                        </button>
                                                    </form>
                                                @endif
                                            @endif
                                            @if ($memos->status == 'posting')
                                                @if (auth()->check() && auth()->user()->fitur['inquery memo perjalanan unpost'])
                                                    <a class="dropdown-item unpost-btn"
                                                        data-memo-id="{{ $memos->id }}">Unpost</a>
                                                @endif
                                                {{-- @if (auth()->check() && auth()->user()->fitur['inquery memo perjalanan show'])
                                                    <a class="dropdown-item"
                                                        href="{{ url('admin/inquery_memoasuransi/' . $memos->id) }}">Show</a>
                                                @endif --}}
                                            @endif
                                            @if ($memos->status == 'selesai')
                                                {{-- @if (auth()->check() && auth()->user()->fitur['inquery memo perjalanan show'])
                                                    <a class="dropdown-item"
                                                        href="{{ url('admin/inquery_memoasuransi/' . $memos->id) }}">Show</a>
                                                @endif --}}
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
            form.action = "{{ url('admin/penerimaan_sj') }}";
            form.submit();
        }
    </script>

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
                    url: "{{ url('admin/postingfilterpenerimaansj') }}?ids=" + selectedIdsString,
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
                    url: "{{ url('admin/unpostfilterpenerimaansj') }}?ids=" + selectedIdsString,
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
