@extends('layouts.app')

@section('title', 'Faktur Pelunasan Pembelian Part')

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
                    <h1 class="m-0">Faktur Pelunasan Pembelian Part</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Faktur Pelunasan Pembelian Part</li>
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
                        <i class="icon fas fa-Part"></i> Gagal!
                    </h5>
                    {{ session('error') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Faktur Pelunasan Pembelian Part</h3>
                    <div class="float-right">
                        @if (auth()->check() && auth()->user()->fitur['create pelunasan faktur pembelian part'])
                            <a href="{{ url('admin/faktur_pelunasanpart') }}" class="btn btn-primary btn-sm">
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
                                @foreach ($inquery as $fakturpelunasanpart)
                                    <tr class="dropdown"{{ $fakturpelunasanpart->id }}>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $fakturpelunasanpart->kode_pelunasanpart }}</td>
                                        <td>{{ $fakturpelunasanpart->tanggal_awal }}</td>
                                        <td>
                                            {{ $fakturpelunasanpart->user->karyawan->nama_lengkap }}
                                        </td>
                                        <td>
                                            {{ $fakturpelunasanpart->nama_supplier }}
                                        </td>
                                        {{-- <td style="text-align: end">
                                        {{ number_format($fakturpelunasanpart->pph, 0, ',', '.') }}
                                    </td> --}}
                                        <td style="text-align: end">
                                            {{ number_format($fakturpelunasanpart->totalpembayaran, 0, ',', '.') }}
                                        </td>
                                        <td class="text-center">
                                            @if ($fakturpelunasanpart->status == 'posting')
                                                <button type="button" class="btn btn-success btn-sm">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @endif

                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                @if ($fakturpelunasanpart->status == 'unpost')
                                                    @if ($fakturpelunasanpart->deposit_driver_id === null)
                                                        @if (auth()->check() && auth()->user()->fitur['inquery pelunasan faktur pembelian part posting'])
                                                            <a class="dropdown-item posting-btn"
                                                                data-memo-id="{{ $fakturpelunasanpart->id }}">Posting</a>
                                                        @endif
                                                        @if (auth()->check() && auth()->user()->fitur['inquery pelunasan faktur pembelian part update'])
                                                            <a class="dropdown-item"
                                                                href="{{ url('admin/inquery_partpembelianlunas/' . $fakturpelunasanpart->id . '/edit') }}">Update</a>
                                                        @endif
                                                    @endif
                                                    @if (auth()->check() && auth()->user()->fitur['inquery pelunasan faktur pembelian part show'])
                                                        <a class="dropdown-item"
                                                            href="{{ url('admin/inquery_partpembelianlunas/' . $fakturpelunasanpart->id) }}">Show</a>
                                                    @endif
                                                    @if ($fakturpelunasanpart->deposit_driver_id === null)
                                                        @if (auth()->check() && auth()->user()->fitur['inquery pelunasan faktur pembelian part delete'])
                                                            <form style="margin-top:5px" method="GET"
                                                                action="{{ route('hapuspelunasanpart', ['id' => $fakturpelunasanpart->id]) }}">
                                                                <button type="submit"
                                                                    class="dropdown-item btn btn-outline-danger btn-block mt-2">
                                                                    </i> Delete
                                                                </button>
                                                            </form>
                                                        @endif
                                                    @endif
                                                @endif
                                                @if ($fakturpelunasanpart->status == 'posting')
                                                    @if ($fakturpelunasanpart->deposit_driver_id === null)
                                                        @if (auth()->check() && auth()->user()->fitur['inquery pelunasan faktur pembelian part unpost'])
                                                            <a class="dropdown-item unpost-btn"
                                                                data-memo-id="{{ $fakturpelunasanpart->id }}">Unpost</a>
                                                        @endif
                                                    @endif
                                                    @if (auth()->check() && auth()->user()->fitur['inquery pelunasan faktur pembelian part show'])
                                                        <a class="dropdown-item"
                                                            href="{{ url('admin/inquery_partpembelianlunas/' . $fakturpelunasanpart->id) }}">Show</a>
                                                    @endif
                                                @endif
                                                @if ($fakturpelunasanpart->status == 'selesai')
                                                    @if (auth()->check() && auth()->user()->fitur['inquery pelunasan faktur pembelian part show'])
                                                        <a class="dropdown-item"
                                                            href="{{ url('admin/inquery_partpembelianlunas/' . $fakturpelunasanpart->id) }}">Show</a>
                                                    @endif
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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
                // var url = "{{ url('admin/Part/cetak_pdffilter') }}?ids=" + selectedIdsString;
            }
        }
    </script>

    {{-- unpost penerimaan  --}}
    <script>
        $(function(e) {
            $("#select_all_ids").click(function() {
                $('.checkbox_ids').prop('checked', $(this).prop('checked'))
            })
        });

        $(document).ready(function() {
            $('.unpost-btn').click(function() {
                var memoId = $(this).data('memo-id');

                $(this).addClass('disabled');
                // Tampilkan modal loading saat permintaan AJAX diproses
                $('#modal-loading').modal('show');

                // Kirim permintaan AJAX untuk melakukan unpost
                $.ajax({
                    url: "{{ url('admin/inquery_partpembelianlunas/unpostpelunasanpart/') }}/" +
                        memoId,
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
    {{-- posting penerimaan --}}
    <script>
        $(document).ready(function() {
            $('.posting-btn').click(function() {
                var memoId = $(this).data('memo-id');

                $(this).addClass('disabled');
                // Tampilkan modal loading saat permintaan AJAX diproses
                $('#modal-loading').modal('show');

                // Kirim permintaan AJAX untuk melakukan posting
                $.ajax({
                    url: "{{ url('admin/inquery_partpembelianlunas/postingpelunasanpart/') }}/" +
                        memoId,
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

@endsection
