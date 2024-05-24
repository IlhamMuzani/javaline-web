@extends('layouts.app')

@section('title', 'Memo Ekspedisi')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Memo Ekspedisi</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Memo Ekspedisi</li>
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
                    <h3 class="card-title">Data Memo Ekspedisi</h3>
                    <div class="float-right">
                        @if (auth()->check() && auth()->user()->fitur['create memo ekspedisi'])
                            <a href="{{ url('admin/memo_ekspedisi') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Tambah
                            </a>
                        @endif
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="GET" id="form-action">
                        <div class="row">
                            @if (auth()->check() && auth()->user()->fitur['posting memo perjalanan continue'])
                                <div class="col-md-2 mb-3">
                                    <input type="hidden" name="ids" id="selectedIds" value="">
                                    <button type="button" class="btn btn-success btn-block mt-1" id="postingfilter"
                                        onclick="postingSelectedData()">
                                        <i class="fas fa-check-square"></i> Posting Perjalanan
                                    </button>
                                </div>
                            @endif
                            @if (auth()->check() && auth()->user()->fitur['posting memo borong continue'])
                                <div class="col-md-2 mb-3">
                                    <input type="hidden" name="ids" id="selectedIdss" value="">
                                    <button type="button" class="btn btn-success btn-block mt-1" id="postingfilterborong"
                                        onclick="postingSelectedDataborong()">
                                        <i class="fas fa-check-square"></i> Posting Borong
                                    </button>
                                </div>
                            @endif
                            @if (auth()->check() && auth()->user()->fitur['posting memo tambahan continue'])
                                <div class="col-md-2 mb-3">
                                    <input type="hidden" name="ids" id="selectedIdss" value="">
                                    <button type="button" class="btn btn-success btn-block mt-1" id="postingfiltertambahan"
                                        onclick="postingSelectedDatatambahan()">
                                        <i class="fas fa-check-square"></i> Posting Tambahan
                                    </button>
                                </div>
                            @endif
                            <div class="col-md-2 mb-3">
                                <input type="hidden" name="ids" id="selectedIds" value="">
                                <button type="button" class="btn btn-primary btn-block mt-1" id="checkfilter"
                                    onclick="printSelectedData()" target="_blank">
                                    <i class="fas fa-print"></i> Cetak Filter MP
                                </button>
                            </div>
                            <div class="col-md-2 mb-3">
                                <input type="hidden" name="ids" id="selectedIds" value="">
                                <button type="button" class="btn btn-primary btn-block mt-1" id="checkfilter"
                                    onclick="printSelectedDatamt()" target="_blank">
                                    <i class="fas fa-print"></i> Cetak Filter MT
                                </button>
                            </div>
                        </div>
                    </form>
                    <table id="datatables66" class="table table-bordered table-striped table-hover" style="font-size: 13px">
                        <thead class="thead-dark">
                            <tr>
                                <th> <input type="checkbox" name="" id="select_all_ids"></th>
                                <th class="text-center">No</th>
                                <th>Kode Memo</th>
                                <th>Tanggal</th>
                                <th>Bag.input</th>
                                <th>Sopir</th>
                                <th>No Kabin</th>
                                <th>Rute</th>
                                <th>U. Jalan</th>
                                <th>U. Tambah</th>
                                <th>Deposit</th>
                                <th>Total</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $rowNumber = 1; // Initialize row number
                            @endphp
                            @foreach ($memos as $memo)
                                <tr class="dropdown"{{ $memo->id }}>
                                    <td><input type="checkbox" name="selectedIds[]" class="checkbox_ids"
                                            value="{{ $memo->id }}">
                                    </td>
                                    <td class="text-center">{{ $rowNumber++ }}</td>
                                    <td>
                                        {{ $memo->kode_memo }}{{ $memo->kode_tambahan }}</td>
                                    <td>
                                        {{ $memo->tanggal_awal }}</td>
                                    <td>
                                        {{ substr($memo->admin, 0, 7) }} ..
                                    </td>
                                    <td>
                                        {{ substr($memo->nama_driver, 0, 7) }} ..
                                    </td>
                                    <td>
                                        {{ $memo->no_kabin }}
                                    </td>
                                    <td>
                                        @if ($memo->nama_rute == null)
                                            rute tidak ada
                                        @else
                                            {{ $memo->nama_rute }}
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        @if (substr($memo->kode_memo, 0, 2) === 'MP')
                                            {{ number_format($memo->uang_jalan, 0, ',', '.') }}
                                        @elseif (substr($memo->kode_memo, 0, 2) === 'MB')
                                            {{ number_format($memo->totalrute, 0, ',', '.') }}
                                        @else
                                            {{ number_format($memo->grand_total, 0, ',', '.') }}
                                        @endif
                                    </td>

                                    <td class="text-right">
                                        {{ number_format($memo->biaya_tambahan ?? 0, 0, ',', '.') }}
                                    </td>
                                    <td class="text-right">
                                        {{ number_format($memo->deposit_driver ?? 0, 0, ',', '.') }}
                                    </td>
                                    <td class="text-right">
                                        {{ number_format($memo->sub_total ?? $memo->grand_total, 0, ',', '.') }}
                                    </td>
                                    <td class="text-center">
                                        @if ($memo->status == 'posting')
                                            <button type="button" class="btn btn-success btn-sm">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        @endif
                                        @if ($memo->status == 'selesai')
                                            <img src="{{ asset('storage/uploads/indikator/') }}{{ $memo->nama_rute == null ? 'faktur.png' : 'truck.png' }}"
                                                height="40" width="40"
                                                alt="{{ $memo->nama_rute == null ? 'Roda Mobil' : 'Truck' }}">
                                        @endif
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            @if ($memo->status == 'unpost')
                                                @if ($saldoTerakhir->sisa_saldo < $memo->uang_jalan)
                                                    <a class="dropdown-item">Saldo tidak cukup</a>
                                                @else
                                                @endif
                                                @if ($memo->kategori == 'Memo Perjalanan')
                                                    @if (auth()->check() && auth()->user()->fitur['posting memo ekspedisi'])
                                                        <a class="dropdown-item posting-btn"
                                                            data-memo-id="{{ $memo->id }}">Posting</a>
                                                    @endif
                                                    @if (auth()->check() && auth()->user()->fitur['show memo ekspedisi'])
                                                        <a class="dropdown-item"
                                                            href="{{ url('admin/inquery_memoekspedisi/' . $memo->id) }}">Show</a>
                                                    @endif
                                                    @if (auth()->check() && auth()->user()->fitur['update memo ekspedisi'])
                                                        <a class="dropdown-item"
                                                            href="{{ url('admin/inquery_memoekspedisi/' . $memo->id . '/edit') }}">Update</a>
                                                    @endif
                                                    @if (auth()->check() && auth()->user()->fitur['delete memo ekspedisi'])
                                                        <form style="margin-top:5px" method="GET"
                                                            action="{{ route('hapusmemo', ['id' => $memo->id]) }}">
                                                            <button type="submit"
                                                                class="dropdown-item btn btn-outline-danger btn-block mt-2">
                                                                </i> Delete
                                                            </button>
                                                        </form>
                                                    @endif
                                                @elseif($memo->kategori == 'Memo Borong')
                                                    @if ($saldoTerakhir->sisa_saldo < $memo->hasil_jumlah)
                                                        <a class="dropdown-item">Saldo tidak cukup</a>
                                                    @else
                                                        @if (auth()->check() && auth()->user()->fitur['posting memo ekspedisi'])
                                                            <a class="dropdown-item posting-btnborong"
                                                                data-memo-id="{{ $memo->id }}">Posting</a>
                                                        @endif
                                                    @endif
                                                    @if (auth()->check() && auth()->user()->fitur['show memo ekspedisi'])
                                                        <a class="dropdown-item"
                                                            href="{{ url('admin/inquery_memoborong/' . $memo->id) }}">Show</a>
                                                    @endif
                                                    @if (auth()->check() && auth()->user()->fitur['update memo ekspedisi'])
                                                        <a class="dropdown-item"
                                                            href="{{ url('admin/inquery_memoborong/' . $memo->id . '/edit') }}">Update</a>
                                                    @endif
                                                    @if (auth()->check() && auth()->user()->fitur['delete memo ekspedisi'])
                                                        <form style="margin-top:5px" method="GET"
                                                            action="{{ route('hapusmemo', ['id' => $memo->id]) }}">
                                                            <button type="submit"
                                                                class="dropdown-item btn btn-outline-danger btn-block mt-2">
                                                                </i> Delete
                                                            </button>
                                                        </form>
                                                    @endif
                                                @else
                                                    @if ($saldoTerakhir->sisa_saldo < $memo->grand_total)
                                                        <a class="dropdown-item">Saldo tidak cukup</a>
                                                    @else
                                                        @if (auth()->check() && auth()->user()->fitur['posting memo ekspedisi'])
                                                            <a class="dropdown-item posting-btntambahan"
                                                                data-memo-id="{{ $memo->id }}">Posting</a>
                                                        @endif
                                                    @endif
                                                    @if (auth()->check() && auth()->user()->fitur['show memo ekspedisi'])
                                                        <a class="dropdown-item"
                                                            href="{{ url('admin/inquery_memotambahan/' . $memo->id) }}">Show</a>
                                                    @endif
                                                    @if (auth()->check() && auth()->user()->fitur['update memo ekspedisi'])
                                                        <a class="dropdown-item"
                                                            href="{{ url('admin/inquery_memotambahan/' . $memo->id . '/edit') }}">Update</a>
                                                    @endif
                                                    @if (auth()->check() && auth()->user()->fitur['delete memo ekspedisi'])
                                                        <form style="margin-top:5px" method="GET"
                                                            action="{{ route('hapusmemotambahan', ['id' => $memo->id]) }}">
                                                            <button type="submit"
                                                                class="dropdown-item btn btn-outline-danger btn-block mt-2">
                                                                </i> Delete
                                                            </button>
                                                        </form>
                                                    @endif
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
                        window.location.href = "{{ url('admin/tablememo') }}";
                        break;
                    case 'memo_borong':
                        window.location.href = "{{ url('admin/tablememoborongs') }}";
                        break;
                    case 'memo_tambahan':
                        window.location.href = "{{ url('admin/tablememotambahans') }}";
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

        function printSelectedDataMB() {
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
                window.location.href = "{{ url('admin/cetak_memoborongfilter') }}?ids=" + selectedIdsString;
                // var url = "{{ url('admin/ban/cetak_pdffilter') }}?ids=" + selectedIdsString;
            }
        }


        function printSelectedDatamt() {
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
                window.location.href = "{{ url('admin/cetak_memotambahanfilter') }}?ids=" + selectedIdsString;
                // var url = "{{ url('admin/ban/cetak_pdffilter') }}?ids=" + selectedIdsString;
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
                    var driverName = checkbox.parentNode.parentNode.querySelector("td:nth-child(6)").innerText
                        .trim();
                    driverCounts[driverName] = (driverCounts[driverName] || 0) +
                        1; // Menambah jumlah kemunculan nama sopir

                    // Tambahkan uang jalan dari setiap item yang dicentang ke total
                    totalUangJalan += parseInt(checkbox.parentNode.parentNode.querySelector("td:nth-child(9)")
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

        function getTotalGrandTotals() {
            var totalGrandTotal = 0;
            var selectedCheckboxes = document.querySelectorAll('.checkbox_ids:checked');

            selectedCheckboxes.forEach(function(checkbox) {
                var grandTotal = parseFloat(checkbox.closest('tr').querySelector('td:nth-child(12)').textContent
                    .replace(/\D/g, ''));
                totalGrandTotal += grandTotal;
            });

            return totalGrandTotal;
        }

        function postingSelectedDatatambahan() {
            var totalGrandTotal = getTotalGrandTotals();
            var saldoTerakhir = parseFloat("{{ $saldoTerakhir->sisa_saldo }}");

            console.log(totalGrandTotal);

            if (totalGrandTotal > saldoTerakhir) {
                // Menampilkan modal validasi saat saldo tidak mencukupi
                $('#validationMessage').text("Saldo tidak mencukupi untuk melakukan posting.");
                $('#validationModal').modal('show');
            } else {
                var selectedCheckboxes = document.querySelectorAll('.checkbox_ids:checked');
                if (selectedCheckboxes.length === 0) {
                    // Menampilkan modal validasi saat tidak ada item yang dicentang
                    $('#validationMessage').text("Harap centang setidaknya satu item sebelum posting.");
                    $('#validationModal').modal('show');
                } else {
                    var selectedIds = [];
                    selectedCheckboxes.forEach(function(checkbox) {
                        selectedIds.push(checkbox.value);
                    });
                    document.getElementById('postingfiltertambahan').value = selectedIds.join(',');
                    var selectedIdsString = selectedIds.join(',');

                    // Tampilkan modal loading sebelum mengirim permintaan AJAX
                    $('#modal-loading').modal('show');

                    $.ajax({
                        url: "{{ url('admin/postingmemotambahanfilter') }}?ids=" + selectedIdsString,
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

        function getTotalGrandTotal() {
            var totalGrandTotal = 0;
            var selectedCheckboxes = document.querySelectorAll('.checkbox_ids:checked');

            selectedCheckboxes.forEach(function(checkbox) {
                var grandTotal = parseFloat(checkbox.closest('tr').querySelector('td:nth-child(11)').textContent
                    .replace(/\D/g, ''));
                totalGrandTotal += grandTotal;
            });

            return totalGrandTotal;
        }


        function postingSelectedDataborong() {
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
                    document.getElementById('postingfilterborong').value = selectedIds.join(',');
                    var selectedIdsString = selectedIds.join(',');

                    // Tampilkan modal loading sebelum mengirim permintaan AJAX
                    $('#modal-loading').modal('show');

                    $.ajax({
                        url: "{{ url('admin/postingmemoborongfilter') }}?ids=" + selectedIdsString,
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
        $(document).ready(function() {
            $('.posting-btnborong').click(function() {
                var memoId = $(this).data('memo-id');
                $(this).addClass('disabled');

                // Tampilkan modal loading saat permintaan AJAX diproses
                $('#modal-loading').modal('show');

                // Kirim permintaan AJAX untuk melakukan posting
                $.ajax({
                    url: "{{ url('admin/inquery_memoborong/postingmemoborong/') }}/" + memoId,
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
            $('.posting-btntambahan').click(function() {
                var memoId = $(this).data('memo-id');
                $(this).addClass('disabled');

                // Tampilkan modal loading saat permintaan AJAX diproses
                $('#modal-loading').modal('show');

                // Kirim permintaan AJAX untuk melakukan posting
                $.ajax({
                    url: "{{ url('admin/inquery_memotambahan/postingmemotambahan/') }}/" + memoId,
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

@endsection
