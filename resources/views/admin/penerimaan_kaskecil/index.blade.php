@extends('layouts.app')

@section('title', 'Faktur Penerimaan Kas Kecil')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Faktur Penerimaan Kas Kecil</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/penerimaan_kaskecil') }}">Faktur Pelunasan</a></li>
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
            <form action="{{ url('admin/penerimaan_kaskecil') }}" method="POST" enctype="multipart/form-data"
                autocomplete="off">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Penerimaan kas kecil</h3>
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
                                    <label for="saldo_masuk">Saldo Masuk</label>
                                    <input style="text-align: end" type="text" class="form-control" readonly
                                        id="saldo_masuk" name="saldo_masuk" placeholder="" value="{{ old('saldo_masuk') }}">
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
                                    <label for="sisa_saldo">Sisa Saldo</label>
                                    <input style="text-align: end;margin:right:10px" type="text" class="form-control"
                                        id="sisa_saldo" readonly name="sisa_saldo"
                                        value="{{ old('sisa_saldo', $saldoTerakhir->latest()->first()->sisa_saldo) }}"
                                        placeholder="">
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
                                        value="{{ old('sub_total') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="reset" class="btn btn-secondary">Reset</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
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

            // Menetapkan nilai ke input sub total
            $('#sub_total').val(subTotalRupiah);
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


@endsection
