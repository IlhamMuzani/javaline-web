@extends('layouts.app')

@section('title', 'Perbarui Tarif Asuransi')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Perbarui Tarif Asuransi</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/tarif-asuransi') }}">Perbarui Tarif Asuransi</a>
                        </li>
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
                        <i class="icon fas fa-ban"></i> Error!
                    </h5>
                    @foreach (session('error') as $error)
                        - {{ $error }} <br>
                    @endforeach
                </div>
            @endif
            <form action="{{ url('admin/tarif-asuransi/' . $tarifs->id) }}" method="POST" enctype="multipart/form-data"
                autocomplete="off">
                @csrf
                @method('put')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Tarif Asuransi</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama_tarif">Nama Tarif Asuransi</label>
                            <input type="text" class="form-control" id="nama_tarif" name="nama_tarif"
                                placeholder="masukkan nama biaya" value="{{ old('nama_tarif', $tarifs->nama_tarif) }}">
                        </div>
                        <div class="form-group">
                            <label for="nominal">Tarif</label>
                            <input type="text" class="form-control" id="persen" name="persen"
                                placeholder="masukkan tarif %"
                                value="{{ old('persen', $tarifs->persen) }}"
                                oninput="formatRupiah(this)">
                            {{-- onkeypress="return event.charCode >= 48 && event.charCode <= 57" --}}
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
            // Hapus karakter selain angka dan koma
            var value = input.value.replace(/[^0-9,]/g, "");

            // Pisahkan bagian desimal jika ada (hanya satu koma yang diperbolehkan)
            var parts = value.split(',');

            // Jika terdapat lebih dari satu koma, gabungkan kembali dengan membatasi hanya satu koma
            if (parts.length > 2) {
                value = parts[0] + ',' + parts.slice(1).join('');
                parts = value.split(',');
            }

            // Format angka dengan menambahkan titik sebagai pemisah ribuan untuk bagian pertama
            parts[0] = new Intl.NumberFormat('id-ID').format(parts[0]);

            // Gabungkan kembali bagian pertama dengan bagian desimal jika ada
            input.value = parts.join(',');
        }
    </script>
@endsection
