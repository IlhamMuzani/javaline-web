@extends('layouts.app')

@section('title', 'Perbarui Rute Perjalanan')

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
                        <li class="breadcrumb-item active">Perbarui</li>
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

            <!-- /.card-header -->
            <form action="{{ url('admin/rute_perjalanan/' . $rute_perjalanan->id) }}" method="POST"
                enctype="multipart/form-data" autocomplete="off">
                @csrf
                @method('put')
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
                                        {{ old('provinsi', $rute_perjalanan->provinsi) == $province ? 'selected' : null }}>
                                        {{ $province }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nama_rute">Rute Perjalanan</label>
                            <input type="text" class="form-control" id="nama_rute" name="nama_rute"
                                style="text-transform: uppercase;" placeholder="masukkan tujuan"
                                value="{{ old('nama_rute', $rute_perjalanan->nama_rute) }}">
                        </div>
                    </div>
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
                                placeholder="masukkan biaya"
                                value="{{ old('golongan1', number_format($rute_perjalanan->golongan1, 0, ',', '.')) }}"
                                oninput="formatRupiah(this)"
                                onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                        </div>
                        <div class="form-group">
                            <label for="golongan2">Golongan 2</label>
                            <input type="text" class="form-control" id="golongan2" name="golongan2"
                                placeholder="masukkan biaya"
                                value="{{ old('golongan2', number_format($rute_perjalanan->golongan2, 0, ',', '.')) }}"
                                oninput="formatRupiah(this)"
                                onkeypress="return event.charCode >= 48 && event.charCode <= 57">

                        </div>
                        <div class="form-group">
                            <label for="golongan3">Golongan 3</label>
                            <input type="text" class="form-control" id="golongan3" name="golongan3"
                                placeholder="masukkan biaya"
                                value="{{ old('golongan3', number_format($rute_perjalanan->golongan3, 0, ',', '.')) }}"
                                oninput="formatRupiah(this)"
                                onkeypress="return event.charCode >= 48 && event.charCode <= 57">

                        </div>
                        <div class="form-group">
                            <label for="golongan4">Golongan 4</label>
                            <input type="text" class="form-control" id="golongan4" name="golongan4"
                                placeholder="masukkan biaya"
                                value="{{ old('golongan4', number_format($rute_perjalanan->golongan4, 0, ',', '.')) }}"
                                oninput="formatRupiah(this)"
                                onkeypress="return event.charCode >= 48 && event.charCode <= 57">

                        </div>
                        <div class="form-group">
                            <label for="golongan5">Golongan 5</label>
                            <input type="text" class="form-control" id="golongan5" name="golongan5"
                                placeholder="masukkan biaya"
                                value="{{ old('golongan5', number_format($rute_perjalanan->golongan5, 0, ',', '.')) }}"
                                oninput="formatRupiah(this)"
                                onkeypress="return event.charCode >= 48 && event.charCode <= 57">

                        </div>

                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Masukan keterangan">{{ old('keterangan', $rute_perjalanan->keterangan) }}</textarea>
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <button type="reset" class="btn btn-secondary">Reset</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </section>

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
