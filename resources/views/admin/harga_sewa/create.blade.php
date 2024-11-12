@extends('layouts.app')

@section('title', 'Tambah Harga Sewa')

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
                    <h1 class="m-0">Harga Sewa</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/harga_sewa') }}">Harga Sewa</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content" style="display: none;" id="mainContentSection">
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
            <form action="{{ url('admin/harga_sewa') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Harga Sewa</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group">
                            <div class="form-group" style="flex: 8;">
                                <label for="vendor_id">Nama Rekanan</label>
                                <select class="select2bs4 select22-hidden-accessible" name="vendor_id"
                                    data-placeholder="Cari Rekanan.." style="width: 100%;" data-select22-id="23"
                                    tabindex="-1" aria-hidden="true" id="vendor_id">
                                    <option value="">- Pilih -</option>
                                    @foreach ($vendors as $vendor)
                                        <option value="{{ $vendor->id }}"
                                            {{ old('vendor_id') == $vendor->id ? 'selected' : '' }}>
                                            {{ $vendor->nama_vendor }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nama_tarif">Nama Rute</label>
                            <input type="text" class="form-control" id="nama_tarif" name="nama_tarif"
                                placeholder="masukkan nama harga sewa" value="{{ old('nama_tarif') }}">
                        </div>
                        <div class="form-group">
                            <label for="harga">Nominal</label>
                            <input type="text" class="form-control" id="nominal" name="nominal"
                                placeholder="masukkan nominal" value="{{ old('nominal') }}" oninput="formatRupiah(this)">
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
        function formatRupiah(input) {
            // Hapus karakter selain angka dan koma
            var value = input.value.replace(/[^\d,]/g, "");

            // Pisahkan bagian desimal jika ada
            var parts = value.split(',');

            // Format angka dengan menambahkan titik sebagai pemisah ribuan untuk bagian pertama
            parts[0] = new Intl.NumberFormat('id-ID').format(parts[0]);

            // Gabungkan kembali bagian pertama dengan bagian desimal jika ada
            input.value = parts.join(',');
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
