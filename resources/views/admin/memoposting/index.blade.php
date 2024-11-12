@extends('layouts.app')

@section('title', 'Inquery Memo Tambahan')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Inquery Memo Tambahan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Inquery Memo Tambahan</li>
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
                    <h3 class="card-title">Data Inquery Memo Tambahan</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="GET" id="form-action">
                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <select class="custom-select form-control" id="kategori" name="kategori">
                                    <option value="">- Semua Status -</option>
                                    <option value="Memo Perjalanan"
                                        {{ Request::get('kategori') == 'Memo Perjalanan' ? 'selected' : '' }}>
                                        Memo Perjalanan
                                    </option>
                                    <option value="Memo Borong"
                                        {{ Request::get('kategori') == 'Memo Borong' ? 'selected' : '' }}>
                                        Memo Borong
                                    </option>
                                    <option value="Memo Tambahan"
                                        {{ Request::get('kategori') == 'Memo Tambahan' ? 'selected' : '' }}>
                                        Memo Tambahan
                                    </option>
                                </select>
                                <label for="kategori">(Pilih Kategori Memo)</label>
                            </div>
                            <div class="col-md-2 mb-3">
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
                    @if (auth()->user()->id == 1 || auth()->user()->id == 4 || auth()->user()->id == 31)
                        <form method="GET" id="form-action">
                            <div class="row">
                                <div class="col-md-2 mb-3">
                                    <input type="hidden" name="ids" id="selectedIds" value="">
                                    <button type="button" class="btn btn-success btn-block mt-1" id="postingfilter"
                                        onclick="postingSelectedData()">
                                        <i class="fas fa-check-square"></i> Posting Filter
                                    </button>

                                </div>
                                <div class="col-md-2 mb-3">
                                    <input type="hidden" name="ids" id="selectedIdss" value="">
                                    <button type="button" class="btn btn-warning btn-block mt-1" id="unpostfilter"
                                        onclick="unpostSelectedData()">
                                        <i class="fas fa-times-circle"></i> Unpost Filter
                                    </button>
                                </div>
                            </div>
                        </form>
                    @endif
                    <table id="datatables66" class="table table-bordered table-striped table-hover"
                        style="font-size: 13px">
                        <thead class="thead-dark">
                            <tr>
                                <th> <input type="checkbox" name="" id="select_all_ids"></th>
                                <th class="text-center">No</th>
                                <th>No Memo Tambahan</th>
                                <th>No Memo</th>
                                <th>Tanggal</th>
                                <th>Sopir</th>
                                <th>No Kabin</th>
                                <th>Rute</th>
                                <th style="text-align: center">Uang Tambah</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inquery as $memotambahan)
                                <tr class="dropdown"{{ $memotambahan->id }}>
                                    <td><input type="checkbox" name="selectedIds[]" class="checkbox_ids"
                                            value="{{ $memotambahan->id }}">
                                    </td>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>
                                        {{ $memotambahan->kode_tambahan }}</td>
                                    <td>
                                        {{ $memotambahan->no_memo }}</td>
                                    <td>
                                        {{ $memotambahan->tanggal_awal }}</td>
                                    <td>
                                        {{ substr($memotambahan->nama_driver, 0, 7) }} ..
                                    </td>
                                    <td>
                                        {{ $memotambahan->no_kabin }}
                                    </td>
                                    <td>
                                        {{ $memotambahan->nama_rute }}</td>
                                    <td style="text-align: end">
                                        {{ number_format($memotambahan->grand_total, 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        @if ($memotambahan->status == 'posting')
                                            <button type="button" class="btn btn-success btn-sm">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        @endif
                                        @if ($memotambahan->status == 'selesai')
                                            <img src="{{ asset('storage/uploads/indikator/faktur.png') }}" height="40"
                                                width="40" alt="faktur">
                                        @endif
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            @if ($memotambahan->status == 'unpost')
                                                @if (auth()->check() && auth()->user()->fitur['inquery memo tambahan update'])
                                                    <a class="dropdown-item"
                                                        href="{{ url('admin/inquery_memotambahan/' . $memotambahan->id . '/edit') }}">Update</a>
                                                @endif
                                                @if (auth()->check() && auth()->user()->fitur['inquery memo tambahan show'])
                                                    <a class="dropdown-item"
                                                        href="{{ url('admin/inquery_memotambahan/' . $memotambahan->id) }}">Show</a>
                                                @endif
                                                @if (auth()->check() && auth()->user()->fitur['inquery memo tambahan delete'])
                                                    <form style="margin-top:5px" method="GET"
                                                        action="{{ route('hapusmemotambahan', ['id' => $memotambahan->id]) }}">
                                                        <button type="submit"
                                                            class="dropdown-item btn btn-outline-danger btn-block mt-2">
                                                            </i> Delete
                                                        </button>
                                                    </form>
                                                @endif
                                            @endif
                                            @if ($memotambahan->status == 'posting')
                                                @if (auth()->check() && auth()->user()->fitur['inquery memo tambahan unpost'])
                                                    <a class="dropdown-item unpost-btn"
                                                        data-memo-id="{{ $memotambahan->id }}">Unpost</a>
                                                @endif
                                                @if (auth()->check() && auth()->user()->fitur['inquery memo tambahan show'])
                                                    <a class="dropdown-item"
                                                        href="{{ url('admin/inquery_memotambahan/' . $memotambahan->id) }}">Show</a>
                                                @endif
                                            @endif
                                            @if ($memotambahan->status == 'selesai')
                                                @if (auth()->check() && auth()->user()->fitur['inquery memo tambahan show'])
                                                    <a class="dropdown-item"
                                                        href="{{ url('admin/inquery_memotambahan/' . $memotambahan->id) }}">Show</a>
                                                @endif
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
