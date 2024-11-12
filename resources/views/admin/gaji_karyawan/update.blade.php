@extends('layouts.app')

@section('title', 'Perbarui Gaji Karyawan')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Gaji Karyawan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/gaji_karyawan') }}">Gaji Karyawan</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
        <div class="container-fluid">
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5>
                        <i class="icon fas fa-ban"></i> Gagal!
                    </h5>
                    @foreach (session('error') as $error)
                        - {{ $error }} <br>
                    @endforeach
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Perbarui Gaji Karyawan</h3>
                </div>
                <!-- /.card-header -->
                <form action="{{ url('admin/gaji_karyawan/' . $gajis->id) }}" method="POST" enctype="multipart/form-data"
                    autocomplete="off">
                    @csrf
                    @method('put')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="kasbon">Kasbon</label>
                            <input type="text" class="form-control" id="kasbon" name="kasbon"
                                placeholder="masukkan kasbon"
                                value="{{ old('kasbon', number_format($gajis->kasbon, 0, ',', '.')) }}"
                                oninput="formatRupiah(this)"
                                onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                        </div>
                        <div class="form-group">
                            <label for="bpjs">Potongan BPJS</label>
                            <input type="text" class="form-control" id="bpjs" name="bpjs"
                                placeholder="masukkan nominal bpjs"
                                value="{{ old('bpjs', number_format($gajis->bpjs, 0, ',', '.')) }}"
                                oninput="formatRupiah(this)"
                                onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                        </div>
                        <div class="form-group">
                            <label for="gaji">Gaji Karyawan</label>
                            <input type="text" class="form-control" id="gaji" name="gaji"
                                placeholder="masukkan gaji"
                                value="{{ old('gaji', number_format($gajis->gaji, 0, ',', '.')) }}"
                                oninput="formatRupiah(this)"
                                onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="reset" class="btn btn-secondary" id="btnReset">Reset</button>
                        <button type="submit" class="btn btn-primary" id="btnSimpan">Simpan</button>
                        <div id="loading" style="display: none;">
                            <i class="fas fa-spinner fa-spin"></i> Sedang Menyimpan...
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

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
        function formatRupiah(input) {
            // Hapus karakter selain angka
            var value = input.value.replace(/\D/g, "");

            // Format angka dengan menambahkan titik sebagai pemisah ribuan
            value = new Intl.NumberFormat('id-ID').format(value);

            // Tampilkan nilai yang sudah diformat ke dalam input
            input.value = value;
        }
    </script>
@endsection
