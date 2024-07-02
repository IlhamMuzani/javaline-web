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
                        <i class="icon fas fa-ban"></i> Gagal Menyimpan!
                    </h5>
                    @foreach (session('error') as $error)
                        - {{ $error }} <br>
                    @endforeach
                </div>
            @endif
            <form action="{{ url('admin/inquery_kasbonkaryawan/' . $inquery->id) }}" method="POST"
                enctype="multipart/form-data" autocomplete="off">
                @csrf
                @method('put')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 mt-4">
                            <button class="btn btn-primary btn-sm" type="button" onclick="showkaryawan(this.value)">
                                <i class="fas fa-plus mr-2"></i> Pilih Karyawan
                            </button>
                        </div>

                        <div class="form-group" hidden>
                            <label for="nopol">Id Karyawan</label>
                            <input type="text" class="form-control" id="karyawan_id" name="karyawan_id"
                                value="{{ old('karyawan_id', $inquery->karyawan->id) }}" readonly placeholder=""
                                value="">
                        </div>
                        <div class="form-group">
                            <label for="nopol">Kode Karyawan</label>
                            <input type="text" class="form-control" id="kode_karyawan" name="kode_sopir" readonly
                                placeholder="" value="{{ old('kode_sopir', $inquery->karyawan->kode_karyawan) }}">
                        </div>
                        <div class="form-group">
                            <label for="nopol">Nama Karyawan</label>
                            <input type="text" class="form-control" name="nama_sopir" id="nama_lengkap" readonly
                                placeholder="" value="{{ old('nama_sopir', $inquery->karyawan->nama_lengkap) }}">
                        </div>
                        <div class="form-group" hidden>
                            <label for="sub_total2">Sub Total hidden</label>
                            <input type="text" class="form-control" name="sub_total2" id="sub_total2" readonly
                                placeholder="" value="{{ old('sub_total2', $inquery->sub_total2) }}">
                        </div>
                    </div>
                </div>

                <div id="pengambilan" class="card">
                    <div class="card-header">
                        <h3 class="card-title">Pengembalian Kasbon</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="nominal">Nominal</label>
                                    <input type="text" class="form-control" id="nominals" name="nominal"
                                        placeholder="Masukan nominal" value="{{ old('nominal', $inquery->nominal) }}"
                                        onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="sisa_saldo">Sisa Kasbon</label>
                                    <input style="text-align: end;margin:right:10px" type="text" class="form-control"
                                        id="sisa_saldos" readonly name="sisa_saldo"
                                        @if ($inquery->karyawan->kasbon == null) value="{{ old('sisa_saldo', 0) }}"
                                        @else value="{{ old('sisa_saldo', $inquery->karyawan->kasbon) }}" @endif
                                        placeholder="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="alamat">Keterangan</label>
                                    <textarea type="text" class="form-control" id="keterangans" name="keterangans" placeholder="Masukan keterangan">{{ old('keterangans', $inquery->keterangan) }}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="saldo_masuk">Potongan Kasbon</label>
                                    <input style="text-align: end" type="text" class="form-control" readonly
                                        id="saldo_keluar" name="saldo_keluar" placeholder=""
                                        value="{{ old('saldo_keluar', $inquery->saldo_keluar) }}">
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
                                    <input style="text-align: end; margin:right:10px" type="text" class="form-control"
                                        readonly id="sub_totals" name="sub_totals" placeholder=""
                                        value="{{ old('sub_totals', $inquery->sub_total) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Rincian Cicilan <span>
                            </span></h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group">
                            <label for="sub_total">Cicilan</label>
                            <div class="row">
                                <div class="col-md-5">
                                    <input style="font-size:14px" type="text" class="form-control"
                                        id="nominal_cicilan" name="nominal_cicilan" placeholder="nominal cicilan"
                                        value="{{ old('nominal_cicilan', number_format($inquery->nominal_cicilan, 0, ',', '.')) }}"
                                        oninput="formatRupiahform(this)"
                                        onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                </div>
                                <div class="col-md-1">
                                    <input style="font-size:14px; text-align:center" readonly type="text"
                                        class="form-control" value="x">
                                </div>
                                <div class="col-md-6">
                                    <input style="font-size:14px" type="text" class="form-control"
                                        id="jumlah_cicilan" name="jumlah_cicilan" placeholder="jumlah cicilan"
                                        value="{{ old('jumlah_cicilan', number_format($inquery->jumlah_cicilan, 0, ',', '.')) }}"
                                        oninput="formatRupiahform(this)"
                                        onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label style="font-size:14px" class="mt-3" for="nominal_lebih">Nominal lebih</label>
                            <input style="font-size:14px" type="text" class="form-control" id="nominal_lebih"
                                name="nominal_lebih" placeholder="nominal di luar perkalian"
                                value="{{ old('nominal_lebih', number_format($inquery->nominal_lebih, 0, ',', '.')) }}"
                                oninput="formatRupiahform(this)"
                                onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                        </div>
                        <div class="form-group">
                            <label style="font-size:14px" class="mt-3" for="grand_total">Grand Total</label>
                            <input style="font-size:14px" type="text" class="form-control text-right"
                                id="grand_total" name="grand_total" readonly placeholder=""
                                value="{{ old('grand_total', number_format($inquery->grand_total, 0, ',', '.')) }}">
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
                        <h4 class="modal-title">Data Kasbon</h4>
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
                                        <th>Kode Kasbon</th>
                                        <th>Nama Nama Kasbon</th>
                                        <th>Tanggal</th>
                                        <th>Kasbon</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($KaryawanAll as $kasbon)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $kasbon->kode_karyawan }}</td>
                                            <td>{{ $kasbon->nama_lengkap }}</td>
                                            <td>{{ $kasbon->telp }}</td>
                                            <td> {{ number_format($kasbon->kasbon, 0, ',', '.') }}
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="getSelectedData('{{ $kasbon->id }}',
                                                    '{{ $kasbon->kode_karyawan }}',
                                                    '{{ $kasbon->nama_lengkap }}',
                                                    '{{ $kasbon->kasbon }}',
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


        function showkaryawan(selectedCategory) {
            $('#tableSopir').modal('show');
        }

        function getSelectedData(Sopir_id, KodeSopir, NamaSopir, Tabungan) {
            // Set the values in the form fields
            document.getElementById('karyawan_id').value = Sopir_id;
            document.getElementById('kode_karyawan').value = KodeSopir;
            document.getElementById('nama_lengkap').value = NamaSopir;
            const formattedTabungan = formatCurrency(Tabungan);

            document.getElementById('sisa_saldos').value = formattedTabungan;

            updateSubTotals();
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
            var subTotal = saldoMasuk + sisaSaldo;

            // Mengonversi nilai sub total ke format rupiah dengan menambahkan simbol mines (-)
            var subTotalRupiah = "Rp " + formatRupiah(Math.abs(subTotal));
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
        function formatRupiahform(input) {
            // Hapus karakter selain angka
            var value = input.value.replace(/\D/g, "");

            // Format angka dengan menambahkan titik sebagai pemisah ribuan
            value = new Intl.NumberFormat('id-ID').format(value);

            // Tampilkan nilai yang sudah diformat ke dalam input
            input.value = value;
        }
    </script>

    <script>
        function formatCurrencys2(value) {
            // Menghilangkan "Rp"
            value = value.replace(/Rp\s*/g, '');
            // Menghilangkan semua titik
            value = value.replace(/[.]/g, '');
            // Mengubah koma menjadi titik
            value = value.replace(/,/g, '.');

            return parseFloat(value) || 0;
        }

        $(document).ready(function() {
            function calculateTotal() {
                // Ambil nilai input dan hapus titik pemisah ribuan
                var nominalCicilan = parseFloat($('#nominal_cicilan').val().replace(/[.]/g, '')) || 0;
                var jumlahCicilan = parseFloat($('#jumlah_cicilan').val().replace(/[.]/g, '')) || 0;
                var nominalTambahan = parseFloat($('#nominal_lebih').val().replace(/[.]/g, '')) || 0;
                var subTotals = formatCurrency($('#sub_totals').val());

                console.log(subTotals);
                // Lakukan perkalian dan penjumlahan
                var grandTotal = (nominalCicilan * jumlahCicilan) + nominalTambahan;

                // Pastikan grandTotal tidak melebihi subTotals
                if (grandTotal > subTotals) {
                    grandTotal = 0;
                    $('#nominal_cicilan').val(0);
                    $('#nominal_lebih').val(0);
                }

                // Tampilkan hasil dengan format pemisah ribuan
                $('#grand_total').val(grandTotal.toLocaleString('id-ID'));
            }
            $('#nominal_cicilan, #jumlah_cicilan, #nominal_lebih').on('input', calculateTotal);
        });
    </script>
@endsection
