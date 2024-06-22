@extends('layouts.app')

@section('title', 'Pengambilan Kas Kecil')

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
                    <h1 class="m-0">Pengambilan Kas Kecil</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/pengeluaran_kaskecil') }}">Pengambilan Kas
                                Kecil</a>
                        </li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <section class="content" style="display: none;" id="mainContentSection">
        <div class="container-fluid">
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-ban"></i> Error!
                    </h5>
                    @foreach (session('error') as $error)
                        - {{ $error }} <br>
                    @endforeach
                </div>
            @endif

            @if (session('error_pelanggans') || session('error_pesanans'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-ban"></i> Error!
                    </h5>
                    @if (session('error_pelanggans'))
                        @foreach (session('error_pelanggans') as $error)
                            - {{ $error }} <br>
                        @endforeach
                    @endif
                    @if (session('error_pesanans'))
                        @foreach (session('error_pesanans') as $error)
                            - {{ $error }} <br>
                        @endforeach
                    @endif
                </div>
            @endif
            <form action="{{ url('admin/pengeluaran_kaskecil') }}" method="POST" enctype="multipart/form-data"
                autocomplete="off">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah pengambilan kas kecil</h3>
                    </div>

                    <div class="card-body">
                        <div class="form-group" style="flex: 8;"> <!-- Adjusted flex value -->
                            <select class="select2bs4 select2-hidden-accessible" name="kendaraan_id"
                                data-placeholder="Cari Kabin.." style="width: 100%;" data-select2-id="23" tabindex="-1"
                                aria-hidden="true" id="kendaraan_id">
                                <option value="">- Pilih -</option>
                                @foreach ($kendaraans as $kendaraan)
                                    <option value="{{ $kendaraan->id }}"
                                        {{ old('kendaraan_id') == $kendaraan->id ? 'selected' : '' }}>
                                        {{ $kendaraan->no_kabin }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- /.card-header -->
                </div>
                <div>
                    <div class="card" id="form_biayatambahan">
                        <div class="card-header">
                            <h3 class="card-title">Tambahkan Akun <span>
                                </span></h3>
                            <div class="float-right">
                                <button type="button" class="btn btn-primary btn-sm" onclick="addPesanan()">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="font-size:14px" class="text-center">No</th>
                                        <th style="font-size:14px">Kode Akun</th>
                                        <th style="font-size:14px">Nama Akun</th>
                                        <th style="font-size:14px">Nominal</th>
                                        <th style="font-size:14px">Keterangan</th>
                                        <th style="font-size:14px">Opsi</th>
                                    </tr>
                                </thead>
                                <tbody id="tabel-pembelian">
                                    <tr id="pembelian-0">
                                        <td style="width: 70px; font-size:14px" class="text-center" id="urutan">1
                                        </td>

                                        <td hidden>
                                            <div class="form-group">
                                                <input style="font-size:14px" type="text" class="form-control"
                                                    id="barangakun_id-0" name="barangakun_id[]">
                                            </div>
                                        </td>
                                        <td onclick="addAkun(0)">
                                            <div class="form-group">
                                                <input style="font-size:14px" type="text" readonly class="form-control"
                                                    id="kode_akun-0" name="kode_akun[]">
                                            </div>
                                        </td>
                                        <td onclick="addAkun(0)">
                                            <div class="form-group">
                                                <input style="font-size:14px" type="text" readonly class="form-control"
                                                    id="nama_akun-0" name="nama_akun[]">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input style="font-size:14px" type="number" class="form-control"
                                                    id="nominal-0" name="nominal[]">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <textarea style="font-size:14px" type="text" class="form-control" id="keterangan-0" name="keterangan[]"
                                                    placeholder="Masukan keterangan"></textarea>
                                            </div>
                                        </td>
                                        <td style="width: 100px">
                                            <button type="button" class="btn btn-primary btn-sm" onclick="addAkun(0)">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                            <button style="margin-left:5px" type="button" class="btn btn-danger btn-sm"
                                                onclick="removePesanan(0)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            {{-- <div class="form-group">
                                <label style="font-size:14px" class="mt-3" for="nopol">Keterangan</label>
                                <textarea style="font-size:14px" type="text" class="form-control" id="keterangan" name="keterangan"
                                    placeholder="Masukan keterangan">{{ old('keterangan') }}</textarea>
                            </div> --}}
                            <div class="form-group">
                                <label style="font-size:14px" class="mt-3" for="nopol">Grand Total</label>
                                <input style="font-size:14px" type="text" class="form-control text-right"
                                    id="grand_total" name="grand_total" readonly placeholder=""
                                    value="{{ old('grand_total') }}">
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button type="reset" class="btn btn-secondary" id="btnReset">Reset</button>
                            <button type="submit" class="btn btn-primary" id="btnSimpan">Simpan</button>
                            <div id="loading" style="display: none;">
                                <i class="fas fa-spinner fa-spin"></i> Sedang Menyimpan...
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="modal fade" id="tableAkun" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Akun</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="m-2">
                            <input type="text" id="searchInput" class="form-control" placeholder="Search...">
                        </div>
                        <div class="table-responsive scrollbar m-2">
                            <table id="tables" class="table table-bordered table-striped">
                                <thead class="bg-200 text-900">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Kode Akun</th>
                                        <th>Nama Akun</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($barangakuns as $akun)
                                        <tr data-id="{{ $akun->id }}"
                                            data-kode_barangakun="{{ $akun->kode_barangakun }}"
                                            data-nama_barangakun="{{ $akun->nama_barangakun }}"
                                            data-param="{{ $loop->index }}">
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $akun->kode_barangakun }}</td>
                                            <td>{{ $akun->nama_barangakun }}</td>
                                            <td class="text-center">
                                                <button type="button" id="btnTambah" class="btn btn-primary btn-sm"
                                                    onclick="getSelectedData({{ $loop->index }})">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <script>
        // Function to filter the table rows based on the search input
        function filterTable() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("tables");
            tr = table.getElementsByTagName("tr");

            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[2]; // Change index to match the column you want to search
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
        document.getElementById("searchInput").addEventListener("input", filterTable);
    </script>


    <script>
        var activeSpecificationIndex = 0;

        function addAkun(param) {
            activeSpecificationIndex = param;
            // Show the modal and filter rows if necessary
            $('#tableAkun').modal('show');
        }

        function getSelectedData(rowIndex) {
            var selectedRow = $('#tables tbody tr:eq(' + rowIndex + ')');
            var barang_id = selectedRow.data('id');
            var kode_barang = selectedRow.data('kode_barangakun');
            var nama_barang = selectedRow.data('nama_barangakun');

            // Update the form fields for the active specification
            $('#barangakun_id-' + activeSpecificationIndex).val(barang_id);
            $('#kode_akun-' + activeSpecificationIndex).val(kode_barang);
            $('#nama_akun-' + activeSpecificationIndex).val(nama_barang);

            $('#tableAkun').modal('hide');
        }
    </script>


    <script>
        function updateGrandTotal() {
            var grandTotal = 0;

            // Loop through all elements with name "nominal_tambahan[]"
            $('input[name^="nominal"]').each(function() {
                var nominalValue = parseFloat($(this).val()) || 0;
                grandTotal += nominalValue;
            });

            // Set the calculated grand total to the input with ID "grand_total"
            $('#grand_total').val(grandTotal.toLocaleString('id-ID'));
        }

        // Panggil fungsi saat ada perubahan pada input "nominal_tambahan[]"
        $('body').on('input', 'input[name^="nominal"]', function() {
            updateGrandTotal();
        });

        // Panggil fungsi saat halaman dimuat untuk menginisialisasi grand total
        $(document).ready(function() {
            updateGrandTotal();
        });


        var data_pembelian = @json(session('data_pembelians'));
        var jumlah_ban = 1;

        if (data_pembelian != null) {
            jumlah_ban = data_pembelian.length;
            $('#tabel-pembelian').empty();
            var urutan = 0;
            $.each(data_pembelian, function(key, value) {
                urutan = urutan + 1;
                itemPembelian(urutan, key, value);
            });
        }

        function addPesanan() {
            jumlah_ban = jumlah_ban + 1;

            if (jumlah_ban === 1) {
                $('#tabel-pembelian').empty();
            }

            itemPembelian(jumlah_ban, jumlah_ban - 1);
        }

        function removePesanan(params) {
            jumlah_ban = jumlah_ban - 1;

            var tabel_pesanan = document.getElementById('tabel-pembelian');
            var pembelian = document.getElementById('pembelian-' + params);

            tabel_pesanan.removeChild(pembelian);

            if (jumlah_ban === 0) {
                var item_pembelian = '<tr>';
                item_pembelian += '<td class="text-center" colspan="5">- Akun belum ditambahkan -</td>';
                item_pembelian += '</tr>';
                $('#tabel-pembelian').html(item_pembelian);
            } else {
                var urutan = document.querySelectorAll('#urutan');
                for (let i = 0; i < urutan.length; i++) {
                    urutan[i].innerText = i + 1;
                }
            }
            updateGrandTotal()
        }

        function itemPembelian(urutan, key, value = null) {
            var barangakun_id = '';
            var kode_akun = '';
            var nama_akun = '';
            var nominal = '';
            var keterangan = '';

            if (value !== null) {
                barangakun_id = value.barangakun_id;
                kode_akun = value.kode_akun;
                nama_akun = value.nama_akun;
                nominal = value.nominal;
                keterangan = value.keterangan;
            }

            // urutan 
            var item_pembelian = '<tr id="pembelian-' + urutan + '">';
            item_pembelian += '<td style="width: 70px; font-size:14px" class="text-center" id="urutan-' + urutan +
                '">' +
                urutan + '</td>';

            // barangakun_id 
            item_pembelian += '<td hidden>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" style="font-size:14px" id="barangakun_id-' +
                urutan +
                '" name="barangakun_id[]" value="' + barangakun_id + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // kode_akun 
            item_pembelian += '<td onclick="addAkun(' + urutan +
                ')">';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" readonly style="font-size:14px" id="kode_akun-' +
                urutan +
                '" name="kode_akun[]" value="' + kode_akun + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // nama_akun 
            item_pembelian += '<td onclick="addAkun(' + urutan +
                ')">';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" readonly style="font-size:14px" id="nama_akun-' +
                urutan +
                '" name="nama_akun[]" value="' + nama_akun + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // nominal 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">'
            item_pembelian += '<input type="text" class="form-control" style="font-size:14px" id="nominal-' +
                urutan +
                '" name="nominal[]" value="' + nominal + '" ';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            // keterangan 
            item_pembelian += '<td>';
            item_pembelian += '<div class="form-group">';
            item_pembelian +=
                '<textarea style="font-size:14px" placeholder="Masukan keterangan" class="form-control" id="keterangan-' +
                urutan +
                '" name="keterangan[]">' + keterangan + '</textarea>';
            item_pembelian += '</div>';
            item_pembelian += '</td>';

            item_pembelian += '<td style="width: 100px">';
            item_pembelian += '<button type="button" class="btn btn-primary btn-sm" onclick="addAkun(' + urutan +
                ')">';
            item_pembelian += '<i class="fas fa-plus"></i>';
            item_pembelian += '</button>';
            item_pembelian +=
                '<button style="margin-left:10px" type="button" class="btn btn-danger btn-sm" onclick="removePesanan(' +
                urutan + ')">';
            item_pembelian += '<i class="fas fa-trash"></i>';
            item_pembelian += '</button>';
            item_pembelian += '</td>';
            item_pembelian += '</tr>';

            $('#tabel-pembelian').append(item_pembelian);
        }
    </script>

    <script>
        $(document).ready(function() {
            // Tambahkan event listener pada tombol "Simpan"
            $('#btnSimpan').click(function() {
                // Sembunyikan tombol "Simpan" dan "Reset", serta tampilkan elemen loading
                $(this).hide();
                $('#btnReset').hide(); // Tambahkan id "btnReset" pada tombol "Reset"
                $('#loading').show();

                // Lakukan pengiriman formulir
                $('form').submit();
            });
        });
    </script>

@endsection
