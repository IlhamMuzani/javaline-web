@extends('layouts.app')

@section('title', 'Perpanjangan No. Kir')

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
                    <h1 class="m-0">Perpanjangan No. Kir</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/stnk') }}">Perpanjangan No. Kir</a></li>
                        <li class="breadcrumb-item active">Perbarui</li>
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
            <form action="{{ url('admin/perpanjangan_kir/' . $nokir->id) }}" method="POST" enctype="multipart/form-data"
                autocomplete="off">
                @csrf
                @method('put')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Detail No. Kir</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nopol">No. Kabin</label>
                            <input type="text" class="form-control" id="no_kabin" name="no_kabin" readonly
                                placeholder="Masukan no kabin" value="{{ old('no_pol', $nokir->kendaraan->no_kabin) }}">
                        </div>
                        <div class="form-group">
                            <label for="nopol">No. Registrasi Kendaraan</label>
                            <input type="text" class="form-control" id="no_pol" name="no_pol" readonly
                                placeholder="Masukan no registrasi kendaraan"
                                value="{{ old('no_pol', $nokir->kendaraan->no_pol) }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama Pemilik</label>
                            <input type="text" class="form-control" id="nama_pemilik" readonly name="nama_pemilik"
                                placeholder="Masukan nama pemilik" value="{{ old('nama_pemilik', $nokir->nama_pemilik) }}">
                        </div>
                        <div class="form-group">
                            <label for="no_rangka">Nomor Rangka</label>
                            <input type="text" class="form-control" id="no_rangka" name="no_rangka" readonly
                                placeholder="Masukan no rangka" value="{{ old('no_rangka', $nokir->no_rangka) }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">Nomor Mesin</label>
                            <input type="text" class="form-control" id="no_mesin" name="no_mesin" readonly
                                placeholder="Masukan no motor penggerak" value="{{ old('no_mesin', $nokir->no_mesin) }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="kategori">Pilih Kategori</label>
                            <select class="form-control" id="kategori" name="kategori">
                                <option value="">- Pilih -</option>
                                <option value="Perpanjangan JAVA LINE LOGISTICS"
                                    {{ old('kategori') == 'Perpanjangan JAVA LINE LOGISTICS' ? 'selected' : null }}>
                                    Perpanjangan JAVA LINE LOGISTICS</option>
                                <option value="Perpanjangan DISHUB"
                                    {{ old('kategori') == 'Perpanjangan DISHUB' ? 'selected' : null }}>
                                    Perpanjangan DISHUB</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Perpanjang No. Kir</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Berlaku Sampai</th>
                                    <th>Total Biaya</th>
                                    {{-- <th>Opsi</th> --}}
                                </tr>
                            </thead>
                            <tbody id="tabel-pesanan">
                                <tr id="pesanan-0">
                                    <td class="text-center" id="urutan">1</td>
                                    <td style="width: 240px">
                                        <div class="form-group">
                                            <div class="input-group date" id="reservationdatetime">
                                                <input type="date" id="masa_berlaku" name="masa_berlaku"
                                                    placeholder="d M Y sampai d M Y"
                                                    data-options='{"mode":"range","dateFormat":"d M Y","disableMobile":true}'
                                                    value="{{ old('masa_berlaku', $nokir->masa_berlaku) }}"
                                                    class="form-control datetimepicker-input"
                                                    data-target="#reservationdatetime">
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="total-0" name="jumlah"
                                                value="{{ old('jumlah') }}">
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
        </div>
    </section>

    <script>
        function getData(id) {
            var kendaraan_id = document.getElementById('kendaraan_id');
            $.ajax({
                url: "{{ url('admin/stnk/kendaraan') }}" + "/" + kendaraan_id.value,
                type: "GET",
                dataType: "json",
                success: function(kendaraan_id) {
                    var no_pol = document.getElementById('no_pol');
                    no_pol.value = kendaraan_id.no_pol;

                    var no_rangka = document.getElementById('no_rangka');
                    no_rangka.value = kendaraan_id.no_rangka;

                    var no_mesin = document.getElementById('no_mesin');
                    no_mesin.value = kendaraan_id.no_mesin;
                },
            });
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
