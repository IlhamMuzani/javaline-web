@extends('layouts.app')

@section('title', 'Tambah Potongan Penjualan')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Potongan Penjualan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/potongan_penjualan') }}">Potongan Penjualan</a>
                        </li>
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
            <form action="{{ url('admin/potongan_penjualan') }}" method="POST" enctype="multipart/form-data"
                autocomplete="off">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Potongan Penjualan</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group">
                            <label for="keterangan">Nama Potongan Penjualan</label>
                            <textarea type="text" class="form-control" id="keterangan" name="keterangan" placeholder="masukkan keterangan"
                                value="">{{ old('keterangan') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="harga">Nominal</label>
                            <input type="text" class="form-control" id="grand_total" name="grand_total"
                                placeholder="masukkan nominal" value="{{ old('grand_total') }}"
                                oninput="formatRupiah(this)"
                                onkeypress="return event.charCode >= 48 && event.charCode <= 57">
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
