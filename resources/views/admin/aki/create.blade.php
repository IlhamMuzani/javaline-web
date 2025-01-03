@extends('layouts.app')

@section('title', 'Tambah Ban')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Aki</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/aki') }}">Aki</a></li>
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
                        <i class="icon fas fa-aki"></i> Gagal!
                    </h5>
                    @foreach (session('error') as $error)
                        - {{ $error }} <br>
                    @endforeach
                </div>
            @endif
            <form action="{{ url('admin/aki') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Aki</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="no_seri">No. Seri</label>
                                    <input type="text" class="form-control" id="no_seri" name="no_seri"
                                        placeholder="Masukan no seri" value="{{ old('no_seri') }}">
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label" for="kondisi_aki">Pilih Kondisi</label>
                                <select class="form-control" id="kondisi_aki" name="kondisi_aki">
                                    <option value="">- Pilih -</option>
                                    <option value="BARU" {{ old('kondisi_aki') == 'BARU' ? 'selected' : null }}>
                                        BARU</option>
                                    <option value="BEKAS" {{ old('kondisi_aki') == 'BEKAS' ? 'selected' : null }}>
                                        BEKAS</option>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="merek_aki_id">Merek aki</label>
                                    <select class="custom-select form-control" id="merek_aki_id" name="merek_aki_id">
                                        <option value="">- Pilih -</option>
                                        @foreach ($mereks as $merek)
                                            <option value="{{ $merek->id }}"
                                                {{ old('merek_aki_id') == $merek->id ? 'selected' : '' }}>
                                                {{ $merek->nama_merek }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="harga">Harga</label>
                                    <input type="number" class="form-control" id="harga" name="harga"
                                        placeholder="Masukan harga" value="{{ old('harga') }}">
                                    </select>
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
            </form>
            {{-- </div> --}}
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
@endsection
