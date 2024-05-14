@extends('layouts.app')

@section('title', 'Pengambilan Kas Kecil')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Pengambilan Kas Kecil</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Pengambilan Kas Kecil</li>
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
                    <h3 class="card-title">Pengambilan kas kecil</h3>
                    <div class="float-right">
                        <a href="{{ url('admin/pengeluaran_kaskecil') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah
                        </a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    {{-- <form method="GET" id="form-action">
                        <div class="row">
                            <div class="col-md-4 mb-3">
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
                                <button type="button" class="btn btn-outline-primary mr-2" onclick="cari()">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                            </div>
                        </div>
                    </form> --}}
                    @if (auth()->user()->id == 1 || auth()->user()->id == 31 || auth()->user()->id == 4)
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
                    <table id="datatables66" class="table table-bordered table-striped table-hover" style="font-size: 13px">
                        <thead class="thead-dark">
                            <tr>
                                <th> <input type="checkbox" name="" id="select_all_ids"></th>
                                <th class="text-center">No</th>
                                <th>No Pengambilan Kas Kecil</th>
                                <th>Tanggal</th>
                                <th>Finance</th>
                                <th>No Kabin</th>
                                <th>Jam</th>
                                <th>Total</th>
                                <th style="width:20px">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inquery as $pengeluaran)
                                <tr class="dropdown"{{ $pengeluaran->id }}>
                                    <td><input type="checkbox" name="selectedIds[]" class="checkbox_ids"
                                            value="{{ $pengeluaran->id }}">
                                    </td>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $pengeluaran->kode_pengeluaran }}</td>
                                    <td>{{ $pengeluaran->tanggal_awal }}</td>
                                    <td>
                                        {{ $pengeluaran->user->karyawan->nama_lengkap }}
                                    </td>
                                    <td>
                                        @if ($pengeluaran->kendaraan)
                                            {{ $pengeluaran->kendaraan->no_kabin }}
                                        @else
                                            tidak ada
                                        @endif
                                    </td>
                                    <td>{{ $pengeluaran->jam }}</td>
                                    <td class="text-right">
                                        {{ number_format($pengeluaran->grand_total, 0, ',', '.') }}

                                    </td>
                                    <td class="text-center">
                                        @if ($pengeluaran->status == 'posting')
                                            <button type="button" class="btn btn-success btn-sm">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        @endif
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            @if ($pengeluaran->memo_ekspedisi_id === null && $pengeluaran->memotambahan_id === null)
                                                @if ($pengeluaran->status == 'unpost')
                                                    @if ($saldoTerakhir->sisa_saldo < $pengeluaran->grand_total)
                                                        <a class="dropdown-item">Saldo tidak cukup</a>
                                                    @else
                                                        @if (auth()->check() && auth()->user()->fitur['inquery pengambilan kas kecil posting'])
                                                            <a class="dropdown-item posting-btn"
                                                                data-memo-id="{{ $pengeluaran->id }}">Posting</a>
                                                        @endif
                                                    @endif
                                                    @if (auth()->check() && auth()->user()->fitur['inquery pengambilan kas kecil update'])
                                                        <a class="dropdown-item"
                                                            href="{{ url('admin/inquery_pengeluarankaskecil/' . $pengeluaran->id . '/edit') }}">Update</a>
                                                    @endif
                                                    @if (auth()->check() && auth()->user()->fitur['inquery pengambilan kas kecil show'])
                                                        <a class="dropdown-item"
                                                            href="{{ url('admin/inquery_pengeluarankaskecil/' . $pengeluaran->id) }}">Show</a>
                                                    @endif
                                                    @if (auth()->check() && auth()->user()->fitur['inquery pengambilan kas kecil delete'])
                                                        <form style="margin-top:5px" method="GET"
                                                            action="{{ route('hapuspengeluaran', ['id' => $pengeluaran->id]) }}">
                                                            <button type="submit"
                                                                class="dropdown-item btn btn-outline-danger btn-block mt-2">
                                                                </i> Delete
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endif
                                                @if ($pengeluaran->status == 'posting')
                                                    @if (auth()->check() && auth()->user()->fitur['inquery pengambilan kas kecil unpost'])
                                                        <a class="dropdown-item unpost-btn"
                                                            data-memo-id="{{ $pengeluaran->id }}">Unpost</a>
                                                    @endif
                                                    @if (auth()->check() && auth()->user()->fitur['inquery pengambilan kas kecil show'])
                                                        <a class="dropdown-item"
                                                            href="{{ url('admin/inquery_pengeluarankaskecil/' . $pengeluaran->id) }}">Show</a>
                                                    @endif
                                                @endif
                                                @if ($pengeluaran->status == 'selesai')
                                                    @if (auth()->check() && auth()->user()->fitur['inquery pengambilan kas kecil show'])
                                                        <a class="dropdown-item"
                                                            href="{{ url('admin/inquery_pengeluarankaskecil/' . $pengeluaran->id) }}">Show</a>
                                                    @endif
                                                @endif
                                            @endif
                                            {{-- @if ($pengeluaran->detail_faktur->first())
                                        <p style="margin-left:15px; margin-right:15px">Digunakan Oleh Faktur
                                            Ekspedisi
                                            <strong>{{ $pengeluaran->detail_faktur->first()->faktur_ekspedisi->kode_faktur }}</strong>
                                        </p>
                                    @else
                                        <!-- Kode yang ingin Anda jalankan jika kondisi tidak terpenuhi -->
                                    @endif --}}
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
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
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
                    url: "{{ url('admin/inquery_pengeluarankaskecil/unpostpengeluaran/') }}/" +
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
    {{-- posting memo --}}
    <script>
        $(document).ready(function() {
            $('.posting-btn').click(function() {
                var memoId = $(this).data('memo-id');

                $(this).addClass('disabled');

                // Tampilkan modal loading saat permintaan AJAX diproses
                $('#modal-loading').modal('show');

                // Kirim permintaan AJAX untuk melakukan posting
                $.ajax({
                    url: "{{ url('admin/inquery_pengeluarankaskecil/postingpengeluaran/') }}/" +
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
            form.action = "{{ url('admin/inquery_pengeluarankaskecil') }}";
            form.submit();
        }
    </script>

    {{-- untuk klik 2 kali ke edit  --}}
    {{-- <script>
        document.getElementById('editMemoekspedisi').addEventListener('dblclick', function() {
            window.location.href = "{{ url('admin/inquery_notareturn/' . $pengeluaran->id . '/edit') }}";
        });
    </script> --}}

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

        function getTotalGrandTotal() {
            var totalGrandTotal = 0;
            var selectedCheckboxes = document.querySelectorAll('.checkbox_ids:checked');

            selectedCheckboxes.forEach(function(checkbox) {
                var grandTotal = parseFloat(checkbox.closest('tr').querySelector('td:nth-child(8)').textContent
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
                alert("Saldo tidak mencukupi untuk melakukan posting.");
            } else {
                var selectedCheckboxes = document.querySelectorAll('.checkbox_ids:checked');
                if (selectedCheckboxes.length === 0) {
                    alert("Harap centang setidaknya satu item sebelum posting.");
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
                        url: "{{ url('admin/postingpengeluaranfilter') }}?ids=" + selectedIdsString,
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
                    url: "{{ url('admin/unpostpengeluaranfilter') }}?ids=" + selectedIdsString,
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
