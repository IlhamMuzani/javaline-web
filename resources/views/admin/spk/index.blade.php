@extends('layouts.app')

@section('title', 'Surat Pemesanan Kendaraan')

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
                    <h1 class="m-0">Surat Pemesanan Kendaraan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Surat Pemesanan Kendaraan</li>
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
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Surat Pemesanan Kendaraan</h3>
                    <div class="float-right">
                        {{-- @if (auth()->check() && auth()->user()->fitur['creates buktipotongpajak ekspedisi']) --}}
                        <a href="{{ url('admin/spk/create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah
                        </a>
                        {{-- @endif --}}
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="datatables66" class="table table-bordered table-striped table-hover" style="font-size: 13px">
                        <thead class="thead-dark">
                            <tr>
                                <th> <input type="checkbox" name="" id="select_all_ids"></th>
                                <th>No</th>
                                <th>Kode Spk</th>
                                <th>Tanggal</th>
                                <th>Bag.input</th>
                                <th>Sopir</th>
                                <th>No Kabin</th>
                                <th>No Pol</th>
                                <th>Pelanggan</th>
                                <th>Divisi</th>
                                <th>Rute</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($spks as $buktipotongpajak)
                                <tr class="dropdown"{{ $buktipotongpajak->id }}>
                                    <td><input type="checkbox" name="selectedIds[]" class="checkbox_ids"
                                            value="{{ $buktipotongpajak->id }}">
                                    </td>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>
                                        {{ $buktipotongpajak->kode_spk }}
                                    </td>
                                    <td>
                                        {{ $buktipotongpajak->tanggal_awal }}
                                    </td>
                                    <td>
                                        {{ $buktipotongpajak->admin }}
                                    </td>
                                    <td>
                                        @if ($buktipotongpajak->user)
                                            {{ $buktipotongpajak->user->karyawan->nama_lengkap }}
                                        @else
                                            tidak ada
                                        @endif
                                    </td>
                                    <td>
                                        {{ $buktipotongpajak->no_kabin }}
                                    </td>
                                    <td>
                                        {{ $buktipotongpajak->no_pol }}
                                    </td>
                                    <td>
                                        {{ $buktipotongpajak->nama_pelanggan }}
                                    </td>
                                    <td>
                                        {{ $buktipotongpajak->userpelanggan->detail_pelanggan->nama_divisi ?? null }}
                                    </td>
                                    <td>
                                        {{ $buktipotongpajak->nama_rute }}
                                    </td>
                                    <td class="text-center">
                                        @if ($buktipotongpajak->status == 'posting')
                                            <button type="button" class="btn btn-success btn-sm">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        @endif
                                        @if ($buktipotongpajak->status == 'selesai')
                                            {{-- <img src="{{ asset('storage/uploads/indikator/faktur.png') }}" height="40"
                                                width="40" alt="Selesai"> --}}
                                            <button type="button" class="btn btn-danger btn-sm">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        @endif
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            @if ($buktipotongpajak->status == 'unpost')
                                                {{-- @if (auth()->user()->id == 1 || auth()->user()->id == 6 || auth()->user()->id == 31) --}}
                                                <a class="dropdown-item posting-btn"
                                                    data-memo-id="{{ $buktipotongpajak->id }}">Posting</a>
                                                {{-- @endif --}}
                                                <a class="dropdown-item"
                                                    href="{{ url('admin/inquery_spk/' . $buktipotongpajak->id . '/edit') }}">Update</a>
                                                {{-- <a class="dropdown-item"
                                                    href="{{ url('admin/inquery_spk/' . $buktipotongpajak->id) }}">Show</a> --}}
                                                <form style="margin-top:5px" method="GET"
                                                    action="{{ route('hapusspk', ['id' => $buktipotongpajak->id]) }}">
                                                    <button type="submit"
                                                        class="dropdown-item btn btn-outline-danger btn-block mt-2">
                                                        </i> Delete
                                                    </button>
                                                </form>
                                            @endif
                                            @if ($buktipotongpajak->status == 'posting')
                                                {{-- @if (auth()->user()->id == 1 || auth()->user()->id == 6 || auth()->user()->id == 31) --}}
                                                <a class="dropdown-item unpost-btn"
                                                    data-memo-id="{{ $buktipotongpajak->id }}">Unpost</a>
                                                {{-- @endif --}}
                                                {{-- @if (auth()->user()->id == 1 || auth()->user()->id == 7 || auth()->user()->id == 28) --}}
                                                <a class="dropdown-item"
                                                    href="{{ url('admin/inquery_spk/' . $buktipotongpajak->id . '/edit') }}">Update</a>
                                                {{-- @endif --}}
                                                {{-- <form style="margin-top:5px" method="GET"
                                                    action="{{ route('hapusspk', ['id' => $buktipotongpajak->id]) }}">
                                                    <button type="submit"
                                                        class="dropdown-item btn btn-outline-danger btn-block mt-2">
                                                        </i> Delete
                                                    </button>
                                                </form> --}}
                                                {{-- @endif
                                                @if (auth()->check() && auth()->user()->fitur['shows buktipotongpajak ekspedisi']) --}}
                                                {{-- <a class="dropdown-item"
                                                    href="{{ url('admin/inquery_spk/' . $buktipotongpajak->id) }}">Show</a> --}}
                                                {{-- @endif --}}
                                            @endif
                                            @if ($buktipotongpajak->status == 'selesai')
                                                {{-- @if (auth()->user()->id == 1 || auth()->user()->id == 6 || auth()->user()->id == 31) --}}
                                                {{-- <a class="dropdown-item unpost-btn"
                                                        data-memo-id="{{ $buktipotongpajak->id }}">Unpost</a> --}}
                                                {{-- @endif --}}
                                                {{-- @if (auth()->user()->id == 1 || auth()->user()->id == 7 || auth()->user()->id == 28) --}}
                                                <a class="dropdown-item"
                                                    href="{{ url('admin/inquery_spk/' . $buktipotongpajak->id . '/edit') }}">Update</a>
                                                {{-- @endif --}}
                                                {{-- <a class="dropdown-item"
                                                    href="{{ url('admin/inquery_spk/' . $buktipotongpajak->id . '/edit') }}">Update</a>

                                                <form style="margin-top:5px" method="GET"
                                                    action="{{ route('hapusspk', ['id' => $buktipotongpajak->id]) }}">
                                                    <button type="submit"
                                                        class="dropdown-item btn btn-outline-danger btn-block mt-2">
                                                        </i> Delete
                                                    </button>
                                                </form> --}}
                                                {{-- @if (auth()->check() && auth()->user()->fitur['shows buktipotongpajak ekspedisi']) --}}
                                                {{-- <a class="dropdown-item"
                                                    href="{{ url('admin/inquery_spk/' . $buktipotongpajak->id) }}">Show</a> --}}
                                                {{-- @endif --}}
                                            @endif
                                            @if ($buktipotongpajak->memo_ekspedisi->first())
                                                <p style="margin-left:15px; margin-right:15px">Digunakan Oleh Memo
                                                    Ekspedisi
                                                    <strong>{{ $buktipotongpajak->memo_ekspedisi->first()->kode_memo }}</strong>
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
            form.action = "{{ url('admin/spk') }}";
            form.submit();
        }
    </script>

    {{-- unpost memo  --}}
    <script>
        $(document).ready(function() {
            $('.unpost-btn').click(function() {
                var memoId = $(this).data('memo-id');

                // Tampilkan modal loading saat permintaan AJAX diproses
                $('#modal-loading').modal('show');

                // Kirim permintaan AJAX untuk melakukan unpost
                $.ajax({
                    url: "{{ url('admin/inquery_spk/unpostspk/') }}/" + memoId,
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
    {{-- posting memo --}}
    <script>
        $(document).ready(function() {
            $('.posting-btn').click(function() {
                var memoId = $(this).data('memo-id');

                // Kirim permintaan AJAX untuk melakukan posting
                $.ajax({
                    url: "{{ url('admin/inquery_spk/postingspk/') }}/" + memoId,
                    type: 'GET',
                    data: {
                        id: memoId
                    },
                    success: function(response) {
                        if (response.success) {
                            // Tampilkan modal loading saat permintaan sukses dan data lengkap
                            $('#modal-loading').modal('show');

                            // Tampilkan pesan sukses atau lakukan tindakan lain sesuai kebutuhan
                            console.log(response);

                            // Tutup modal setelah berhasil posting
                            $('#modal-posting-' + memoId).modal('hide');

                            // Reload the page to refresh the table
                            location.reload();
                        } else {
                            // Jika response.error ada, tampilkan pesan kesalahan di modal peringatan
                            $('#validationMessage').text(response.error);
                            $('#validationModal').modal('show');
                        }
                    },
                    error: function(error) {
                        // Tampilkan pesan error jika terjadi kesalahan pada server
                        if (error.responseJSON && error.responseJSON.error) {
                            $('#validationMessage').text(error.responseJSON.error);
                        } else {
                            $('#validationMessage').text(
                                'Terjadi kesalahan, silakan coba lagi.');
                        }

                        // Tampilkan modal peringatan
                        $('#validationModal').modal('show');
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
