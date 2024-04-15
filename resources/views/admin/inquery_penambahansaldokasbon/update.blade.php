@extends('layouts.app')

@section('title', 'Inquery Penerimaan Deposit Karyawan')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Inquery Penerimaan Deposit Karyawan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/penerimaan_kaskecil') }}">Inquery Penerimaan Deposit Karyawan</a>
                        </li>
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
            <form action="{{ url('admin/inquery_penambahansaldokasbon/' . $inquery->id) }}" method="POST" autocomplete="off">
                @method('put')
                @csrf <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Penerimaan Deposit Karyawan</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="nominal">Nominal</label>
                                    <input type="text" class="form-control" id="nominal" name="nominal"
                                        placeholder="masukkan nominal"
                                        value="{{ old('nominal', number_format($inquery->nominal, 0, ',', '.')) }}"
                                        oninput="formatRupiahsx(this)"
                                        onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="saldo_masuk">Saldo Masuk</label>
                                    <input style="text-align: end" type="text" class="form-control" readonly
                                        id="saldo_masuk" name="saldo_masuk" placeholder=""
                                        value="{{ old('saldo_masuk', $inquery->saldo_masuk) }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="alamat">Keterangan</label>
                                    <textarea type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Masukan keterangan">{{ old('keterangan', $inquery->keterangan) }}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="sisa_kasbon">Sisa Saldo</label>
                                    <input style="text-align: end;margin:right:10px" type="text" class="form-control"
                                        id="sisa_kasbon" readonly name="sisa_kasbon"
                                        value="{{ old('sisa_kasbon', $inquery->sisa_kasbon) }}" placeholder="" placeholder="">
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
                                    <input style="text-align: end; margin:right:10px" type="text" class="form-control"
                                        readonly id="sub_total" name="sub_total" placeholder=""
                                        value="{{ old('sub_total', number_format($inquery->sub_total, 2, ',', '.')) }}">
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

        </div>

        </div>
        </form>
        {{-- </div> --}}
        </div>
    </section>

    <script>
        // Fungsi untuk mengonversi angka ke format rupiah
        function formatRupiah(angka) {
            var reverse = angka.toString().split('').reverse().join(''),
                ribuan = reverse.match(/\d{1,3}/g);
            ribuan = ribuan.join('.').split('').reverse().join('');
            return ribuan; // Mengembalikan hanya angka tanpa teks "Rp"
        }

        function formatRupiahxs(angka) {
            // Menghilangkan semua titik dan koma
            var cleanedAngka = angka.replace(/[.,]/g, '');
            // Konversi ke tipe data numerik
            var parsedAngka = parseFloat(cleanedAngka);
            // Mengubah ke format rupiah dengan dua digit desimal dan koma sebagai pemisah desimal
            var formattedAngka = parsedAngka.toLocaleString('id-ID', {
                minimumFractionDigits: 2
            });
            return formattedAngka;
        }

        // Fungsi untuk menangani perubahan nilai pada input nominal
        $('#nominal').on('input', function() {
            // Mengambil nilai input nominal
            var nominalValue = $(this).val();

            // Memeriksa apakah input nominal kosong atau tidak
            if (nominalValue === "") {
                // Jika kosong, set form saldo masuk dan sub total menjadi 0
                $('#saldo_masuk').val("0,00");
                updateSubTotal(); // Memanggil fungsi updateSubTotal tanpa argumen
            } else {
                // Mengonversi nilai ke format rupiah
                var saldoMasukValue = formatRupiahxs(nominalValue);

                // Menetapkan nilai ke input saldo masuk
                $('#saldo_masuk').val(saldoMasukValue);

                // Memperbarui nilai sub total saat input nominal berubah
                updateSubTotal();
            }
        });



        // Fungsi untuk mengonversi sisa saldo ke format rupiah saat dokumen selesai dimuat
        // Fungsi untuk memformat angka menjadi format Rupiah yang benar
        // function formatRupiahx(angka) {
        //     // Mengganti titik dengan koma untuk memisahkan desimal
        //     var formattedAngka = angka.toString().replace(/\./g, ',');
        //     // Lakukan pemisahan ribuan menggunakan titik
        //     var ribuan = formattedAngka.replace(/\d(?=(\d{3})+(?!\d))/g, '$&.');
        //     return ribuan;
        // }

        $(document).ready(function() {
            // Mengambil nilai sisa saldo dari elemen dengan id sisa_kasbon
            var sisaSaldoValue = $('#sisa_kasbon').val();

            // Mengonversi nilai ke format rupiah
            var sisaSaldoRupiah = formatRupiahx(sisaSaldoValue);

            // Menetapkan nilai ke input sisa saldo
            $('#sisa_kasbon').val(sisaSaldoRupiah);

            // Memperbarui nilai sub total saat dokumen selesai dimuat
            updateSubTotal();
        });


        function updateSubTotal() {
            // Mengambil nilai saldo masuk dan sisa saldo
            var saldoMasuk = parseCurrency($('#saldo_masuk').val());
            var sisaSaldo = parseCurrency($('#sisa_kasbon').val());

            // Menghitung sub total
            var subTotal = sisaSaldo + saldoMasuk;

            // Mengonversi nilai sub total ke format rupiah
            var subTotalRupiah = subTotal.toLocaleString('id-ID', {
                minimumFractionDigits: 2
            });

            // Menetapkan nilai ke input sub total
            $('#sub_total').val("Rp " + subTotalRupiah);
        }

        // Fungsi untuk mengubah format uang ke angka
        function parseCurrency(value) {
            // Hilangkan semua karakter kecuali digit, koma, dan tanda minus
            var cleanedValue = value.replace(/[^\d,-]/g, '');

            // Jika nilai memiliki tanda minus di awal
            var isNegative = false;
            if (cleanedValue.charAt(0) === '-') {
                isNegative = true;
                // Hilangkan tanda minus agar bisa di-parse sebagai angka
                cleanedValue = cleanedValue.slice(1);
            }

            // Ubah koma menjadi titik untuk memisahkan desimal
            cleanedValue = cleanedValue.replace(',', '.');

            // Ubah menjadi tipe data float
            var parsedValue = parseFloat(cleanedValue);

            // Jika nilai negatif, ubah ke bentuk negatif setelah di-parse
            if (isNegative) {
                parsedValue *= -1;
            }

            return parsedValue;
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

    <script>
        function formatRupiahsx(input) {
            // Hapus karakter selain angka
            var value = input.value.replace(/\D/g, "");

            // Format angka dengan menambahkan titik sebagai pemisah ribuan
            value = new Intl.NumberFormat('id-ID').format(value);

            // Tampilkan nilai yang sudah diformat ke dalam input
            input.value = value;
        }
    </script>

@endsection
