@extends('layouts.app')

@section('title', 'Inquery Memo Perjalanan')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
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
                    <h3 class="card-title">Data Inquery Memo Perjalanan</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="GET" id="form-action">
                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <select class="custom-select form-control" id="statusx" name="statusx">
                                    <option value="">- Pilih Memo -</option>
                                    <option value="memo_perjalanan">Memo Perjalanan</option>
                                    <option value="memo_borong">Memo Borong</option>
                                    <option value="memo_tambahan">Memo Tambahan</option>
                                </select>
                                <label for="statusx">(Kategori Memo)</label>
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
                            </div>
                        </div>
                    </form>
                    <table id="datatables66" class="table table-bordered table-striped" style="font-size: 13px">
                        <thead>
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
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inquery as $memoekspedisi)
                                <tr>
                                    <td><input type="checkbox" name="selectedIds[]" class="checkbox_ids"
                                            value="{{ $memoekspedisi->id }}">
                                    </td>
                                    <td id="editMemoekspedisi" data-toggle="modal"
                                        data-target="#modal-posting-{{ $memoekspedisi->id }}" style="cursor: pointer;"
                                        class="text-center">{{ $loop->iteration }}</td>
                                    <td id="editMemoekspedisi" data-toggle="modal"
                                        data-target="#modal-posting-{{ $memoekspedisi->id }}" style="cursor: pointer;">
                                        {{ $memoekspedisi->kode_memo }}</td>
                                    <td id="editMemoekspedisi" data-toggle="modal"
                                        data-target="#modal-posting-{{ $memoekspedisi->id }}" style="cursor: pointer;">
                                        {{ $memoekspedisi->tanggal_awal }}</td>
                                    <td id="editMemoekspedisi" data-toggle="modal"
                                        data-target="#modal-posting-{{ $memoekspedisi->id }}" style="cursor: pointer;">
                                        {{ substr($memoekspedisi->nama_driver, 0, 7) }} ..
                                    </td>
                                    <td id="editMemoekspedisi" data-toggle="modal"
                                        data-target="#modal-posting-{{ $memoekspedisi->id }}" style="cursor: pointer;">
                                        {{ $memoekspedisi->no_kabin }}
                                    </td>
                                    <td id="editMemoekspedisi" data-toggle="modal"
                                        data-target="#modal-posting-{{ $memoekspedisi->id }}" style="cursor: pointer;">
                                        @if ($memoekspedisi->nama_rute == null)
                                            rute tidak ada
                                        @else
                                            {{ $memoekspedisi->nama_rute }}
                                        @endif
                                    </td>
                                    <td id="editMemoekspedisi" data-toggle="modal"
                                        data-target="#modal-posting-{{ $memoekspedisi->id }}" style="cursor: pointer;"
                                        class="text-right">
                                        {{ number_format($memoekspedisi->uang_jalan, 0, ',', '.') }}
                                    </td>
                                    <td id="editMemoekspedisi" data-toggle="modal"
                                        data-target="#modal-posting-{{ $memoekspedisi->id }}" style="cursor: pointer;"
                                        class="text-right">
                                        @if ($memoekspedisi->biaya_tambahan == null)
                                            0
                                        @else
                                            {{ number_format($memoekspedisi->biaya_tambahan, 0, ',', '.') }}
                                        @endif
                                    </td>
                                    <td id="editMemoekspedisi" data-toggle="modal"
                                        data-target="#modal-posting-{{ $memoekspedisi->id }}" style="cursor: pointer;"
                                        class="text-right">
                                        @if ($memoekspedisi->deposit_driver == null)
                                            0
                                        @else
                                            {{ number_format($memoekspedisi->deposit_driver, 0, ',', '.') }}
                                        @endif
                                    </td>
                                    {{-- <td>
                                        @if ($memoekspedisi->uang_jaminan == null)
                                            0
                                        @else
                                            {{ number_format($memoekspedisi->uang_jaminan, 0, ',', '.') }}
                                        @endif
                                    </td> --}}
                                    <td id="editMemoekspedisi" data-toggle="modal"
                                        data-target="#modal-posting-{{ $memoekspedisi->id }}" style="cursor: pointer;"
                                        class="text-right">
                                        {{ number_format($memoekspedisi->sub_total, 0, ',', '.') }}
                                    </td>
                                    <td id="editMemoekspedisi" data-toggle="modal"
                                        data-target="#modal-posting-{{ $memoekspedisi->id }}" style="cursor: pointer;"
                                        class="text-center">
                                        @if ($memoekspedisi->status == 'posting')
                                            <button type="button" class="btn btn-success btn-sm">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        @endif
                                        @if ($memoekspedisi->status == 'selesai')
                                            <img src="{{ asset('storage/uploads/indikator/faktur.png') }}" height="40"
                                                width="40" alt="faktur">
                                        @endif
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </td>
                                </tr>
                                <div class="modal fade" id="modal-posting-{{ $memoekspedisi->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Opsi menu</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Memo ekspedisi
                                                    <strong>{{ $memoekspedisi->kode_memo }}</strong>
                                                </p>
                                                @if ($memoekspedisi->detail_faktur->first())
                                                    <p>Digunakan Oleh Faktur Ekspedisi
                                                        <strong>{{ $memoekspedisi->detail_faktur->first()->faktur_ekspedisi->kode_faktur }}</strong>
                                                    </p>
                                                @else
                                                    <!-- Kode yang ingin Anda jalankan jika kondisi tidak terpenuhi -->
                                                @endif
                                                @if ($memoekspedisi->status == 'unpost')
                                                    @if (auth()->check() && auth()->user()->fitur['inquery memo perjalanan delete'])
                                                        <form method="GET"
                                                            action="{{ route('hapusmemo', ['id' => $memoekspedisi->id]) }}">
                                                            <button type="submit"
                                                                class="btn btn-outline-danger btn-block mt-2">
                                                                <i class="fas fa-trash-alt"></i> Delete
                                                            </button>
                                                        </form>
                                                    @endif
                                                    @if (auth()->check() && auth()->user()->fitur['inquery memo perjalanan show'])
                                                        <a href="{{ url('admin/inquery_memoekspedisi/' . $memoekspedisi->id) }}"
                                                            type="button" class="btn btn-outline-info btn-block">
                                                            <i class="fas fa-eye"></i> Show
                                                        </a>
                                                    @endif
                                                    @if (auth()->check() && auth()->user()->fitur['inquery memo perjalanan update'])
                                                        <a href="{{ url('admin/inquery_memoekspedisi/' . $memoekspedisi->id . '/edit') }}"
                                                            type="button" class="btn btn-outline-warning btn-block">
                                                            <i class="fas fa-edit"></i> Update
                                                        </a>
                                                    @endif

                                                    @if ($saldoTerakhir->sisa_saldo < $memoekspedisi->uang_jalan)
                                                        <p style="margin-top:5px">Sisa saldo tidak mencukupi untuk posting
                                                            memo <span style="font-weight: bold">
                                                                {{ $memoekspedisi->kode_memo }}
                                                            </span>
                                                        </p>
                                                    @else
                                                        @if (auth()->check() && auth()->user()->fitur['inquery memo perjalanan posting'])
                                                            {{-- <form method="GET"
                                                            action="{{ route('postingmemo', ['id' => $memoekspedisi->id]) }}"> --}}
                                                            <button type="button"
                                                                class="btn btn-outline-success btn-block mt-2 posting-btn"
                                                                data-memo-id="{{ $memoekspedisi->id }}">
                                                                <i class="fas fa-check"></i> Posting
                                                            </button>
                                                            {{-- </form> --}}
                                                        @endif
                                                    @endif
                                                @endif
                                                @if ($memoekspedisi->status == 'posting')
                                                    @if (auth()->check() && auth()->user()->fitur['inquery memo perjalanan show'])
                                                        <a href="{{ url('admin/inquery_memoekspedisi/' . $memoekspedisi->id) }}"
                                                            type="button" class="btn btn-outline-info btn-block">
                                                            <i class="fas fa-eye"></i> Show
                                                        </a>
                                                    @endif
                                                    @if (auth()->check() && auth()->user()->fitur['inquery memo perjalanan unpost'])
                                                        <button type="button"
                                                            class="btn btn-outline-primary btn-block mt-2 unpost-btn"
                                                            data-memo-id="{{ $memoekspedisi->id }}">
                                                            <i class="fas fa-check"></i> Unpost
                                                        </button>
                                                    @endif
                                                @endif
                                                @if ($memoekspedisi->status == 'selesai')
                                                    @if (auth()->check() && auth()->user()->fitur['inquery memo perjalanan show'])
                                                        <a href="{{ url('admin/inquery_memoekspedisi/' . $memoekspedisi->id) }}"
                                                            type="button" class="btn btn-outline-info btn-block">
                                                            <i class="fas fa-eye"></i> Show
                                                        </a>
                                                    @endif
                                                    {{-- @if (auth()->check() && auth()->user()->fitur['inquery memo perjalanan unpost'])
                                                        <form method="GET"
                                                            action="{{ route('unpostmemoselesai', ['id' => $memoekspedisi->id]) }}">
                                                            <button type="submit"
                                                                class="btn btn-outline-primary btn-block mt-2">
                                                                <i class="fas fa-check"></i> Unpost
                                                            </button>
                                                        </form>
                                                    @endif --}}
                                                @endif
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

    {{-- unpost memo  --}}
    <script>
        $(document).ready(function() {
            $('.unpost-btn').click(function() {
                var memoId = $(this).data('memo-id');

                // Kirim permintaan AJAX untuk melakukan unpost
                $.ajax({
                    url: "{{ url('admin/inquery_memoekspedisi/unpostmemo/') }}/" + memoId,
                    type: 'GET',
                    data: {
                        id: memoId
                    },
                    success: function(response) {
                        // Tampilkan pesan sukses atau lakukan tindakan lain sesuai kebutuhan
                        console.log(response);

                        // Tutup modal setelah berhasil unpost
                        $('#modal-posting-' + memoId).modal('hide');

                        // Reload the page to refresh the table
                        location.reload();
                    },
                    error: function(error) {
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

                // Kirim permintaan AJAX untuk melakukan unpost
                $.ajax({
                    url: "{{ url('admin/inquery_memoekspedisi/postingmemo/') }}/" + memoId,
                    type: 'GET',
                    data: {
                        id: memoId
                    },
                    success: function(response) {
                        // Tampilkan pesan sukses atau lakukan tindakan lain sesuai kebutuhan
                        console.log(response);

                        // Tutup modal setelah berhasil unpost
                        $('#modal-posting-' + memoId).modal('hide');

                        // Reload the page to refresh the table
                        location.reload();
                    },
                    error: function(error) {
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


    {{-- untuk klik 2 kali ke edit  --}}
    {{-- <script>
        document.getElementById('editMemoekspedisi').addEventListener('dblclick', function() {
            window.location.href = "{{ url('admin/inquery_memoekspedisi/' . $memoekspedisi->id . '/edit') }}";
        });
    </script> --}}

    <script>
        $(document).ready(function() {
            $('tbody tr.dropdown').click(function(e) {
                // Menghilangkan efek highlight seleksi yang dibuat secara otomatis oleh browser
                $('tr.dropdown').removeClass('selected');

                // Menambahkan kelas 'selected' ke baris yang dipilih
                $(this).addClass('selected');

                // Mendapatkan posisi td yang diklik
                var clickedTd = $(e.target).closest('td');
                var tdPosition = clickedTd.position();

                // Menampilkan dropdown pada posisi yang tepat
                $(this).find('.dropdown-menu').css({
                    top: tdPosition.top + 30, // Sesuaikan offset dari posisi td
                    left: tdPosition.left
                }).toggle();

                // Menyembunyikan dropdown pada baris lain yang tidak dipilih
                $('tbody tr.dropdown').not(this).find('.dropdown-menu').hide();

                // Mencegah event klik menyebar ke atas (misalnya, saat mengklik dropdown)
                e.stopPropagation();
            });

            // Menyembunyikan dropdown saat klik di tempat lain
            $(document).click(function() {
                $('.dropdown-menu').hide();
            });
        });
    </script>
@endsection
