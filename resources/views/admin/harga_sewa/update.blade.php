@extends('layouts.app')

@section('title', 'Perbarui Harga Sewa')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Perbarui Harga Sewa</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/harga_sewa') }}">Perbarui Tarif</a></li>
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
            <form action="{{ url('admin/harga_sewa/' . $harga_sewas->id) }}" method="POST" enctype="multipart/form-data"
                autocomplete="off">
                @csrf
                @method('put')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Perbarui harga sewa</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group">
                            <div class="form-group" style="flex: 8;">
                                <label for="vendor_id">Nama Rekanan</label>
                                <select class="select2bs4 select22-hidden-accessible" name="vendor_id"
                                    data-placeholder="Cari Vendor.." style="width: 100%;" data-select22-id="23"
                                    tabindex="-1" aria-hidden="true" id="vendor_id">
                                    <option value="">- Pilih -</option>
                                    @foreach ($vendors as $vendor)
                                        <option value="{{ $vendor->id }}"
                                            {{ old('vendor_id', $harga_sewas->vendor_id) == $vendor->id ? 'selected' : '' }}>
                                            {{ $vendor->nama_vendor }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nama_tarif">Nama Rute</label>
                            <input type="text" class="form-control" id="nama_tarif" name="nama_tarif"
                                placeholder="masukkan nama harga" value="{{ old('nama_tarif', $harga_sewas->nama_tarif) }}">
                        </div>
                        <div class="form-group">
                            <label for="nominal">Nominal</label>
                            <input type="text" class="form-control" id="nominal" name="nominal"
                                placeholder="masukkan nominal"
                                value="{{ old('nominal', number_format($harga_sewas->nominal, 2, ',', '.')) }}"
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
            var value = input.value.replace(/[^\d,]/g, "");

            // Pisahkan bagian desimal jika ada
            var parts = value.split(',');

            // Format angka dengan menambahkan titik sebagai pemisah ribuan untuk bagian pertama
            parts[0] = new Intl.NumberFormat('id-ID').format(parts[0]);

            // Gabungkan kembali bagian pertama dengan bagian desimal jika ada
            input.value = parts.join(',');
        }
    </script>
@endsection
