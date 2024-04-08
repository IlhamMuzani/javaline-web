@extends('layouts.app')

@section('title', 'Kasbon Karyawan')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Kasbon Karyawan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/kasbon_karyawan') }}">Kasbon Karyawan</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <section class="content">
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
            <form action="{{ url('admin/kasbon_karyawan') }}" method="POST" enctype="multipart/form-data"
                autocomplete="off">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah</h3>
                    </div>
                    <div class="card-body">

                        <div class="form-group">
                            <label class="form-label" for="kategori">Pilih Kategori</label>
                            <select class="form-control" id="kategori" name="kategori">
                                <option value="">- Pilih -</option>
                                <option value="Pengambilan Kasbon"
                                    {{ old('kategori') == 'Pengambilan Kasbon' ? 'selected' : null }}>
                                    Pengambilan Kasbon</option>
                                <option value="Pengembalian Kasbon"
                                    {{ old('kategori') == 'Pengembalian Kasbon' ? 'selected' : null }}>
                                    Pengembalian Kasbon</option>
                            </select>
                        </div>

                        <div class="mb-3 mt-4">
                            <button class="btn btn-primary btn-sm" type="button" onclick="showKaryawan(this.value)">
                                <i class="fas fa-plus mr-2"></i> Pilih Karyawan
                            </button>
                        </div>

                        <div class="form-group" hidden>
                            <label for="nopol">Id Karyawan</label>
                            <input type="text" class="form-control" id="karyawan_id" name="karyawan_id"
                                value="{{ old('karyawan_id') }}" readonly placeholder="" value="">
                        </div>
                        <div class="form-group">
                            <label for="nopol">Kode Karyawan</label>
                            <input type="text" class="form-control" id="kode_karyawan" name="kode_sopir" readonly
                                placeholder="" value="{{ old('kode_sopir') }}">
                        </div>
                        <div class="form-group">
                            <label for="nopol">Nama Karyawan</label>
                            <input type="text" class="form-control" name="nama_sopir" id="nama_lengkap" readonly
                                placeholder="" value="{{ old('nama_sopir') }}">
                        </div>
                        <div class="form-group" hidden>
                            <label for="sub_total2">Sub total Hidden</label>
                            <input type="text" class="form-control" name="sub_total2" id="sub_total2" readonly
                                placeholder="" value="{{ old('sub_total2') }}">
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div id="pemasukan">
                        <div class="card-header">
                            <h3 class="card-title">Pengambilan Kasbon</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="nominal">Nominal</label>
                                        <input type="text" class="form-control" id="nominal" name="nominal"
                                            placeholder="Masukan nominal" value="{{ old('nominal') }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="saldo_masuk">Nominal Masuk</label>
                                        <input style="text-align: end" type="text" class="form-control" readonly
                                            id="saldo_masuk" name="saldo_masuk" placeholder=""
                                            value="{{ old('saldo_masuk') }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="alamat">Keterangan</label>
                                        <textarea type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Masukan keterangan">{{ old('keterangan') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="sisa_saldo">Sisa Kasbon</label>
                                        <input style="text-align: end;margin:right:10px" type="text"
                                            class="form-control" id="sisa_saldo" readonly name="sisa_saldo"
                                            value="{{ old('sisa_saldo') }}" placeholder="">
                                    </div>
                                    <hr
                                        style="border: 2px solid black; display: inline-block; width: 97%; vertical-align: middle;">
                                    <span
                                        style="display: inline-block; margin-left: 0px; margin-right: 0; font-size: 18px; vertical-align: middle;">+</span>

                                </div>
                                <div class="col-lg-6">
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="sub_total">Sub Total</label>
                                        <input style="text-align: end; margin:right:10px" type="text"
                                            class="form-control" readonly id="sub_total" name="sub_total" placeholder=""
                                            value="{{ old('sub_total') }}">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div id="pengambilan">
                        <div class="card-header">
                            <h3 class="card-title">Pengembalian Kasbon</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="nominal">Nominal</label>
                                        <input type="text" class="form-control" id="nominals" name="nominals"
                                            placeholder="Masukan nominal" value="{{ old('nominals') }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="sisa_saldo">Sisa Kasbon</label>
                                        <input style="text-align: end;margin:right:10px" type="text"
                                            class="form-control" id="sisa_saldos" readonly name="sisa_saldos"
                                            value="{{ old('sisa_saldos') }}" placeholder="">

                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="alamat">Keterangan</label>
                                        <textarea type="text" class="form-control" id="keterangans" name="keterangans" placeholder="Masukan keterangan">{{ old('keterangans') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="saldo_masuk">Potongan Kasbon</label>
                                        <input style="text-align: end" type="text" class="form-control" readonly
                                            id="saldo_keluar" name="saldo_keluar" placeholder=""
                                            value="{{ old('saldo_keluar') }}">
                                    </div>
                                    <hr
                                        style="border: 2px solid black; display: inline-block; width: 97%; vertical-align: middle;">
                                    <span
                                        style="display: inline-block; margin-left: 0px; margin-right: 0; font-size: 18px; vertical-align: middle;">-</span>
                                </div>
                                <div class="col-lg-6">
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="sub_total">Sub Total</label>
                                        <input style="text-align: end; margin:right:10px" type="text"
                                            class="form-control" readonly id="sub_totals" name="sub_totals"
                                            placeholder="" value="{{ old('sub_totals') }}">
                                    </div>
                                </div>
                            </div>
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
            </form>
        </div>
        {{-- </div> --}}
        </div>
        <div class="modal fade" id="tableSopir" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Karyawan</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive scrollbar m-2">
                            <table id="datatables1" class="table table-bordered table-striped">
                                <thead class="bg-200 text-900">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Kode Karyawan</th>
                                        <th>Nama Nama Karyawan</th>
                                        <th>Tanggal</th>
                                        <th>Sisa Kasbon</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($karyawanAll as $sopir)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $sopir->kode_karyawan }}</td>
                                            <td>{{ $sopir->nama_lengkap }}</td>
                                            <td>{{ $sopir->telp }}</td>
                                            <td> {{ number_format($sopir->kasbon, 0, ',', '.') }}
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="getSelectedData('{{ $sopir->id }}',
                                                     '{{ $sopir->kode_karyawan }}',
                                                     '{{ $sopir->nama_lengkap }}',
                                                      '{{ $sopir->kasbon }}',
                                                      )">
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
        function showKaryawan(selectedCategory) {
            $('#tableSopir').modal('show');
        }

        // function formatCurrency(number) {
        //     // Format number as currency with period as thousands separator and comma as decimal separator
        //     const formattedNumber = new Intl.NumberFormat('id-ID', {
        //         style: 'currency',
        //         currency: 'IDR',
        //         minimumFractionDigits: 0,
        //     }).format(number);

        //     // Remove the currency symbol "Rp"
        //     return formattedNumber.replace(/^.*?\s/, '');
        // }
        function formatCurrency(number) {
            // Check if the number is negative
            const isNegative = number < 0;

            // Format number as currency with period as thousands separator and comma as decimal separator
            const formattedNumber = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
            }).format(Math.abs(number)); // Use Math.abs() to work with the absolute value

            // Add a minus sign for negative numbers
            return isNegative ? `-${formattedNumber}` : formattedNumber;
        }


        function getSelectedData(Sopir_id, KodeSopir, NamaSopir, Tabungan) {
            // Set the values in the form fields
            document.getElementById('karyawan_id').value = Sopir_id;
            document.getElementById('kode_karyawan').value = KodeSopir;
            document.getElementById('nama_lengkap').value = NamaSopir;

            // Format Tabungan as currency with proper handling for negative values
            const formattedTabungan = formatCurrency(Tabungan);

            document.getElementById('sisa_saldo').value = formattedTabungan;
            document.getElementById('sisa_saldos').value = formattedTabungan;

            // Close the modal (if needed)
            $('#tableSopir').modal('hide');
        }
    </script>

    <script>
        // Fungsi untuk mengonversi angka ke format rupiah
        function formatRupiah(angka) {
            var reverse = angka.toString().split('').reverse().join(''),
                ribuan = reverse.match(/\d{1,3}/g);
            ribuan = ribuan.join('.').split('').reverse().join('');
            return ribuan; // Mengembalikan hanya angka tanpa teks "Rp"
        }

        // Fungsi untuk menangani perubahan nilai pada input nominal
        $('#nominal').on('input', function() {
            // Mengambil nilai input nominal
            var nominalValue = $(this).val();

            // Memeriksa apakah input nominal kosong atau tidak
            if (nominalValue === "") {
                // Jika kosong, set form saldo masuk dan sub total menjadi 0
                $('#saldo_masuk').val("0");
                updateSubTotal(); // Memanggil fungsi updateSubTotal tanpa argumen
            } else {
                // Jika tidak kosong, mengonversi nilai ke format rupiah
                var saldoMasukValue = formatRupiah(nominalValue);

                // Menetapkan nilai ke input saldo masuk
                $('#saldo_masuk').val(saldoMasukValue);

                // Memperbarui nilai sub total saat input nominal berubah
                updateSubTotal();
            }
        });

        // Fungsi untuk mengonversi sisa saldo ke format rupiah saat dokumen selesai dimuat
        $(document).ready(function() {
            // Mengambil nilai sisa saldo dari elemen dengan id sisa_saldo
            var sisaSaldoValue = $('#sisa_saldo').val();

            // Mengonversi nilai ke format rupiah
            var sisaSaldoRupiah = formatRupiah(sisaSaldoValue);

            // Menetapkan nilai ke input sisa saldo
            $('#sisa_saldo').val(sisaSaldoRupiah);

            // Memperbarui nilai sub total saat dokumen selesai dimuat
            updateSubTotal();
        });

        // Fungsi untuk memperbarui nilai sub total
        function updateSubTotal() {
            // Mengambil nilai saldo masuk dan sisa saldo
            var saldoMasuk = parseCurrency($('#saldo_masuk').val());
            var sisaSaldo = parseCurrency($('#sisa_saldo').val());

            // Menghitung sub total
            var subTotal = saldoMasuk + sisaSaldo;

            // Mengonversi nilai sub total ke format rupiah
            var subTotalRupiah = "Rp " + formatRupiah(subTotal);
            var subTotalRupiahs = (subTotal);

            // Menetapkan nilai ke input sub total
            $('#sub_total').val(subTotalRupiah);
            $('#sub_total2').val(subTotalRupiahs);
        }

        // Fungsi untuk mengubah format uang ke angka
        function parseCurrency(value) {
            return parseInt(value.replace(/[^0-9]/g, ''));
        }

        // max="{{ date('Y-m-d') }}"

        // var tanggalAkhir = document.getElementById('tanggal_awal');

        // if (this.value == "") {
        //     tanggalAkhir.readOnly = true;
        // } else {
        //     tanggalAkhir.readOnly = false;
        // }
        // tanggalAkhir.value = "";
        // var today = new Date().toISOString().split('T')[0];
        // tanggalAkhir.value = today;
        // tanggalAkhir.setAttribute('min', this.value);
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var kategoriSelect = document.getElementById("kategori");
            var Pemasukan = document.getElementById("pemasukan");
            var Pengambilan = document.getElementById("pengambilan");

            // Cek apakah ada nilai kategori yang tersimpan dalam localStorage
            var selectedKategori = localStorage.getItem("selectedKategori");
            if (selectedKategori) {
                // Set nilai kategori sesuai dengan yang tersimpan
                kategoriSelect.value = selectedKategori;

                // Panggil fungsi untuk menyesuaikan tampilan berdasarkan kategori
                adjustDisplay(selectedKategori);
            }

            kategoriSelect.addEventListener("change", function() {
                // Mengambil nilai yang dipilih pada dropdown "Pilih Kategori"
                var selectedKategori = kategoriSelect.value;

                // Menyimpan nilai kategori dalam localStorage
                localStorage.setItem("selectedKategori", selectedKategori);

                // Panggil fungsi untuk menyesuaikan tampilan berdasarkan kategori
                adjustDisplay(selectedKategori);
            });

            // Fungsi untuk menyesuaikan tampilan berdasarkan kategori
            function adjustDisplay(selectedKategori) {
                if (selectedKategori === "Pengambilan Kasbon") {
                    Pemasukan.style.display = "block";
                    Pengambilan.style.display = "none";
                } else if (selectedKategori === "Pengembalian Kasbon") {
                    Pemasukan.style.display = "none";
                    Pengambilan.style.display = "block";
                }
            }
        });
    </script>


    <script>
        // Fungsi untuk mengonversi angka ke format rupiah
        function formatRupiah(angka) {
            var reverse = angka.toString().split('').reverse().join(''),
                ribuan = reverse.match(/\d{1,3}/g);
            ribuan = ribuan.join('.').split('').reverse().join('');
            return ribuan; // Mengembalikan hanya angka tanpa teks "Rp"
        }

        // Fungsi untuk menangani perubahan nilai pada input nominal
        $('#nominals').on('input', function() {
            // Mengambil nilai input nominal
            var nominalValue = $(this).val();

            // Memeriksa apakah input nominal kosong atau tidak
            if (nominalValue === "") {
                // Jika kosong, set form saldo masuk dan sub total menjadi 0
                $('#saldo_keluar').val("0");
                updateSubTotals(); // Memanggil fungsi updateSubTotal tanpa argumen
            } else {
                // Jika tidak kosong, mengonversi nilai ke format rupiah
                var saldoMasukValue = formatRupiah(nominalValue);

                // Menetapkan nilai ke input saldo masuk
                $('#saldo_keluar').val(saldoMasukValue);

                // Memperbarui nilai sub total saat input nominal berubah
                updateSubTotals();
            }
        });

        // Fungsi untuk mengonversi sisa saldo ke format rupiah saat dokumen selesai dimuat
        $(document).ready(function() {
            // Mengambil nilai sisa saldo dari elemen dengan id sisa_saldo
            var sisaSaldoValue = $('#sisa_saldos').val();

            // Mengonversi nilai ke format rupiah
            var sisaSaldoRupiah = formatRupiah(sisaSaldoValue);

            // Menetapkan nilai ke input sisa saldo
            $('#sisa_saldos').val(sisaSaldoRupiah);

            // Memperbarui nilai sub total saat dokumen selesai dimuat
            updateSubTotals();
        });

        // Fungsi untuk memperbarui nilai sub total
        function updateSubTotals() {
            // Mengambil nilai saldo masuk dan sisa saldo
            var saldoMasuk = parseCurrency($('#sisa_saldos').val());
            var sisaSaldo = parseCurrency($('#saldo_keluar').val());

            // Menghitung sub total
            var subTotal = saldoMasuk - sisaSaldo;

            // Mengonversi nilai sub total ke format rupiah dengan menambahkan simbol mines (-)
            var subTotalRupiah = "Rp " + (subTotal < 0 ? "- " : "") + formatRupiah(Math.abs(subTotal));
            var subTotalRupiahs = (subTotal);

            // Menetapkan nilai ke input sub total
            $('#sub_totals').val(subTotalRupiah);
            $('#sub_total2').val(subTotalRupiahs);
        }

        // Fungsi untuk mengubah format uang ke angka
        function parseCurrency(value) {
            return parseInt(value.replace(/[^0-9-]/g, ''));
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
