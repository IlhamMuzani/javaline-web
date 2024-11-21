@extends('layouts.app')

@section('title', 'Inquery Slip Gaji Bulanan')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Inquery Slip Gaji Bulanan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Inquery Slip Gaji Bulanan</li>
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
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Inquery Slip Gaji Bulanan</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="GET" id="form-action">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <select class="custom-select form-control" id="kategori" name="kategori">
                                    <option value="">- Pilih Kategori -</option>
                                    <option value="memo_perjalanan">Gaji Mingguan</option>
                                    <option value="slip_mingguan">Slip Gaji Mingguan</option>
                                    <option value="memo_borong">Gaji Bulanan</option>
                                    <option value="slip_bulanan"selected>Slip Gaji Bulanan</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <select class="select2bs4 select2-hidden-accessible" name="perhitungan_gajikaryawan_id"
                                    data-placeholder="Cari Kode.." style="width: 100%;" data-select2-id="23" tabindex="-1"
                                    aria-hidden="true" id="perhitungan_gajikaryawan_id">
                                    <option value="">- Pilih -</option>
                                    @foreach ($gajis as $gaji)
                                        <option value="{{ $gaji->id }}"
                                            {{ Request::get('perhitungan_gajikaryawan_id') == $gaji->id ? 'selected' : '' }}>
                                            {{ $gaji->kode_gaji }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 mb-3">
                                {{-- @if (auth()->check() && auth()->user()->fitur['laporan slips kas kecil cari']) --}}
                                <button type="button" class="btn btn-outline-primary btn-block" onclick="cari()">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                                {{-- @endif --}}
                                {{-- @if (auth()->check() && auth()->user()->fitur['laporan slips kas kecil cetak']) --}}
                                {{-- @endif --}}
                            </div>
                            <div class="col-md-2 mb-3">
                                <input type="hidden" name="ids" id="selectedIds" value="">
                                <button type="button" class="btn btn-primary btn-block" id="checkfilter"
                                    onclick="printSelectedData()" target="_blank">
                                    <i class="fas fa-print"></i> Cetak Filter
                                </button>
                            </div>
                            {{-- <div class="col-md-2 mb-3">
                                <input type="hidden" name="idss" id="selectedIdss" value="">
                                <button type="button" class="btn btn-success btn-block" id="checkfilterss"
                                    onclick="DownloadPDF()" target="_blank">
                                    <i class="fas fa-print"></i> Download PDF
                                </button>
                            </div> --}}
                        </div>
                    </form>
                    <div class="table-responsive" style="overflow-x: auto;">
                        <table id="datatables66" class="table table-bordered table-striped table-hover"
                            style="font-size: 13px">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-center" width="10"> <input type="checkbox" name=""
                                            id="select_all_ids"></th>
                                    <th class="text-center">No</th>
                                    <th>Kode Gaji Bulanan</th>
                                    <th>Tanggal</th>
                                    <th>Bag.Input</th>
                                    <th>Nama</th>
                                    <th>Gaji Bulanan</th>
                                    <th>Opsi</th>
                                    <th class="text-center"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inquery as $slips)
                                    <tr class="dropdown" data-id="{{ $slips->id }}"
                                        data-telp="{{ $slips->karyawan->telp }}">
                                        <td><input type="checkbox" name="selectedIds[]" class="checkbox_ids"
                                                value="{{ $slips->id }}"></td>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $slips->kode_gajikaryawan }}</td>
                                        <td>{{ $slips->tanggal_awal }}</td>
                                        <td>
                                            @if ($slips->perhitungan_gajikaryawan)
                                                {{ $slips->perhitungan_gajikaryawan->user->karyawan->nama_lengkap }}
                                            @else
                                                tidak ada
                                            @endif
                                        </td>
                                        <td>
                                            @if ($slips->karyawan)
                                                {{ $slips->karyawan->nama_lengkap }}
                                            @else
                                                tidak ada
                                            @endif
                                        </td>
                                        <td class="text-right">{{ number_format($slips->gajinol_pelunasan, 2, ',', '.') }}
                                        </td>
                                        <td>
                                            {{-- <button class="waButton"  style="background-color: #25D366;">WhatsApp</button> --}}
                                            <span></span><button class="waButton" type="submit"
                                                style="background-color: #25D366;" class="btn btn-success btn-sm">
                                                <img src="{{ asset('storage/uploads/gambar_logo/whatsapp.png') }}"
                                                    height="19" width="19" alt="whatsapp">
                                            </button>
                                        </td>
                                        <td class="text-center">
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                @if ($slips->status == 'posting')
                                                    <a class="dropdown-item"
                                                        href="{{ url('admin/laporan_slipgajibulanan/' . $slips->id) }}">Show</a>
                                                @endif
                                                @if ($slips->status == 'selesai')
                                                    <a class="dropdown-item"
                                                        href="{{ url('admin/laporan_slipgajibulanan/' . $slips->id) }}">Show</a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </section>

    <script>
        $(document).ready(function() {
            // Ketika tombol WhatsApp diklik
            $('.waButton').click(function() {
                // Ambil nomor telepon yang sesuai dengan baris yang berisi tombol WhatsApp yang diklik
                var nomorPenerima = $(this).closest('tr').data('telp');

                // Jika nomor telepon tidak ditemukan, berikan peringatan
                if (!nomorPenerima) {
                    alert("Nomor telepon tidak tersedia untuk pengiriman pesan WhatsApp.");
                    return; // Berhenti eksekusi fungsi
                }

                // Ambil ID dari atribut data pada baris yang berisi tombol WhatsApp yang diklik
                var slipId = $(this).closest('tr').data('id');

                // Pesan yang ingin Anda kirim
                var pesan =
                    'Ini adalah gaji yang Anda terima. Silakan lihat detailnya disini dengan cara login terlebih dahulu menggunakan akun anda di web, kemudian klik link ini: ' +
                    'https://javaline.id/admin/report_slipgajibulanan/' + slipId;

                // Membuat URL dengan format URL Scheme WhatsApp
                var url = 'https://api.whatsapp.com/send?phone=' + nomorPenerima + '&text=' +
                    encodeURIComponent(pesan);

                // Buka URL dalam tab atau jendela baru
                window.open(url, '_blank');
            });
        });
    </script>




    <!-- /.card -->
    <script>
        var form = document.getElementById('form-action')

        function cari() {
            form.action = "{{ url('admin/inquery_slipgajibulanan') }}";
            form.submit();
        }

        function printReport() {
            var startDate = tanggalAwal.value;
            var endDate = tanggalAkhir.value;

            if (startDate && endDate) {
                form.action = "{{ url('admin/print_slipgaji') }}" + "?start_date=" + startDate + "&end_date=" +
                    endDate;
                form.submit();
            } else {
                alert("Silakan isi kedua tanggal sebelum mencetak.");
            }
        }
    </script>


    <script>
        $(document).ready(function() {
            // Detect the change event on the 'status' dropdown
            $('#kategori').on('change', function() {
                // Get the selected value
                var selectedValue = $(this).val();

                // Check the selected value and redirect accordingly
                switch (selectedValue) {
                    case 'memo_perjalanan':
                        window.location.href = "{{ url('admin/inquery_perhitungangaji') }}";
                        break;
                    case 'slip_mingguan':
                        window.location.href = "{{ url('admin/inquery_slipgaji') }}";
                        break;
                    case 'memo_borong':
                        window.location.href = "{{ url('admin/inquery_perhitungangajibulanan') }}";
                        break;
                    case 'slip_bulanan':
                        window.location.href = "{{ url('admin/inquery_slipgajibulanan') }}";
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
                window.location.href = "{{ url('admin/cetak_gajibulananfilter') }}?ids=" + selectedIdsString;
                // var url = "{{ url('admin/ban/cetak_pdffilter') }}?ids=" + selectedIdsString;
            }
        }
    </script>

    {{-- <script>
        $(function(e) {
            $("#select_all_ids").click(function() {
                $('.checkbox_ids').prop('checked', $(this).prop('checked'))
            })
        });

        function DownloadPDF() {
            var selectedIds = document.querySelectorAll(".checkbox_ids:checked");
            if (selectedIds.length === 0) {
                alert("Harap centang setidaknya satu item sebelum mencetak.");
            } else {
                var selectedCheckboxes = document.querySelectorAll('.checkbox_ids:checked');
                var selectedIds = [];
                selectedCheckboxes.forEach(function(checkbox) {
                    selectedIds.push(checkbox.value);
                });
                document.getElementById('selectedIdss').value = selectedIds.join(',');
                var selectedIdsString = selectedIds.join(',');
                window.location.href = "{{ url('admin/download_gajibulananfilter') }}?ids=" + selectedIdsString;
                // var url = "{{ url('admin/ban/cetak_pdffilter') }}?ids=" + selectedIdsString;
            }
        }
    </script> --}}
@endsection
