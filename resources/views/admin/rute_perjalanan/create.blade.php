@extends('layouts.app')

@section('title', 'Tambah Rute Perjalanan')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Rute Perjalanan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/rute_perjalanan') }}">Rute Perjalanan</a></li>
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
                        <i class="icon fas fa-ban"></i> Error!
                    </h5>
                    @foreach (session('error') as $error)
                        - {{ $error }} <br>
                    @endforeach
                </div>
            @endif
            <form action="{{ url('admin/rute_perjalanan') }}" method="POST" enctype="multipart/form-data"
                autocomplete="off">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Rute Perjalanan</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label" for="provinsi">Provinsi</label>
                            <select class="select2bs4 select2-hidden-accessible" name="provinsi"
                                data-placeholder="Cari Provinsi.." style="width: 100%;" data-select2-id="23" tabindex="-1"
                                aria-hidden="true" id="provinsi">
                                <option value="">- Pilih -</option>
                                @foreach ($provinces as $province)
                                    <option value="{{ $province }}"
                                        {{ old('provinsi') == $province ? 'selected' : null }}>
                                        {{ $province }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nama_rute">Rute Perjalanan</label>
                            <input style="text-transform:uppercase" type="text" class="form-control" id="nama_rute"
                                name="nama_rute" placeholder="Masukkan Tujuan" value="{{ old('nama_rute') }}">
                        </div>
                    </div>

                    {{-- <div class="card-footer text-right">
                        <button type="reset" class="btn btn-secondary">Reset</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div> --}}
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Biaya Perjalanan</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="form-group">
                            <label for="golongan1">Golongan 1</label>
                            <input type="text" class="form-control" id="golongan1" name="golongan1"
                                placeholder="masukkan biaya" value="{{ old('golongan1') }}" oninput="formatRupiah(this)"
                                onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                        </div>
                        <div class="form-group">
                            <label for="golongan2">Golongan 2</label>
                            <input type="text" class="form-control" id="golongan2" name="golongan2"
                                placeholder="masukkan biaya" value="{{ old('golongan2') }}" oninput="formatRupiah(this)"
                                onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                        </div>
                        <div class="form-group">
                            <label for="golongan3">Golongan 3</label>
                            <input type="text" class="form-control" id="golongan3" name="golongan3"
                                placeholder="masukkan biaya" value="{{ old('golongan3') }}" oninput="formatRupiah(this)"
                                onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                        </div>
                        <div class="form-group">
                            <label for="golongan4">Golongan 4</label>
                            <input type="text" class="form-control" id="golongan4" name="golongan4"
                                placeholder="masukkan biaya" value="{{ old('golongan4') }}" oninput="formatRupiah(this)"
                                onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                        </div>
                        <div class="form-group">
                            <label for="golongan5">Golongan 5</label>
                            <input type="text" class="form-control" id="golongan5" name="golongan5"
                                placeholder="masukkan biaya" value="{{ old('golongan5') }}" oninput="formatRupiah(this)"
                                onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                        </div>

                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Masukan keterangan">{{ old('keterangan') }}</textarea>
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
