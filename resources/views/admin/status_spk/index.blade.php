@extends('layouts.app')

@section('title', 'Status SPK')

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
                    <h1 class="m-0">Status SPK</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Status SPK</li>
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
                    <h3 class="card-title">Surat Pemesanan Kendaraan</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="GET" id="form-action">
                        <div class="row">
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
                            </div>
                        </div>
                    </form>
                    {{-- <table id="datatables66" class="table table-bordered table-striped table-hover" style="font-size: 13px">
                        <thead class="thead-dark">
                            <tr>
                                <th> <input type="checkbox" name="" id="select_all_ids"></th>
                                <th>NO</th>
                                <th>KODE SPK</th>
                                <th>TANGGAL</th>
                                <th style="width: 12%">MEMO</th>
                                <th style="width: 12%">SJ</th>
                                <th style="width: 12%">FAKTUR</th>
                                <th style="width: 12%">INVOICE</th>
                                <th style="width: 12%">PELUNASAN</th>
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
                                        @if ($buktipotongpajak->status_spk == 'memo')
                                            <button type="button" class="btn btn-success btn-block">
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-danger btn-block">
                                            </button>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($buktipotongpajak->status_spk == 'sj')
                                            <button type="button" class="btn btn-success btn-block">
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-danger btn-block">
                                            </button>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($buktipotongpajak->status_spk == 'faktur')
                                            <button type="button" class="btn btn-success btn-block">
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-danger btn-block">
                                            </button>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($buktipotongpajak->status_spk == 'invoice')
                                            <button type="button" class="btn btn-success btn-block">
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-danger btn-block">
                                            </button>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($buktipotongpajak->status_spk == 'pelunasan')
                                            <button type="button" class="btn btn-success btn-block">
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-danger btn-block">
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table> --}}

                    <div class="table-responsive" style="overflow-x: auto;">
                        <table id="datatables66" class="table table-bordered table-striped table-hover"
                            style="font-size: 13px">
                            <thead class="thead-dark">
                                <tr>
                                    <th><input type="checkbox" name="" id="select_all_ids"></th>
                                    <th>NO</th>
                                    <th>KODE SPK</th>
                                    <th>KODE MEMO</th>
                                    <th>TANGGAL</th>
                                    <th>PELANGGAN</th>
                                    <th style="width: 10%">MEMO</th>
                                    <th style="width: 10%">SJ</th>
                                    <th style="width: 10%">FAKTUR</th>
                                    <th style="width: 10%">INVOICE</th>
                                    <th style="width: 10%">PELUNASAN</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($spks as $buktipotongpajak)
                                    @php
                                        $status = $buktipotongpajak->spk ? $buktipotongpajak->spk->status_spk : null;
                                        $isGreen = [
                                            'memo' => in_array($status, [
                                                'memo',
                                                'sj',
                                                'faktur',
                                                'invoice',
                                                'pelunasan',
                                            ]),
                                            'sj' => in_array($status, ['sj', 'faktur', 'invoice', 'pelunasan']),
                                            'faktur' => in_array($status, ['faktur', 'invoice', 'pelunasan']),
                                            'invoice' => in_array($status, ['invoice', 'pelunasan']),
                                            'pelunasan' => $status == 'pelunasan',
                                        ];
                                    @endphp
                                    <tr class="dropdown"{{ $buktipotongpajak->id }}>
                                        <td><input type="checkbox" name="selectedIds[]" class="checkbox_ids"
                                                value="{{ $buktipotongpajak->id }}"></td>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $buktipotongpajak->spk->kode_spk ?? null }}</td>
                                        <td>{{ $buktipotongpajak->kode_memo ?? null }}</td>
                                        <td>{{ $buktipotongpajak->tanggal_awal }}</td>
                                        <td>{{ $buktipotongpajak->spk->nama_pelanggan ?? null }}</td>
                                        <td>
                                            <button type="button"
                                                class="btn {{ $isGreen['memo'] ? 'btn-success' : 'btn-danger' }} btn-block"></button>
                                        </td>
                                        <td>
                                            <button type="button"
                                                class="btn {{ $isGreen['sj'] ? 'btn-success' : 'btn-danger' }} btn-block"></button>
                                        </td>
                                        <td>
                                            <button type="button"
                                                class="btn {{ $isGreen['faktur'] ? 'btn-success' : 'btn-danger' }} btn-block"></button>
                                        </td>
                                        <td>
                                            <button type="button"
                                                class="btn {{ $isGreen['invoice'] ? 'btn-success' : 'btn-danger' }} btn-block"></button>
                                        </td>
                                        <td>
                                            <button type="button"
                                                class="btn {{ $isGreen['pelunasan'] ? 'btn-success' : 'btn-danger' }} btn-block"></button>
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
            form.action = "{{ url('admin/status_spk') }}";
            form.submit();
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

@endsection
