@extends('layouts.app')

@section('title', 'Tambah Pelanggan')

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
                    <h1 class="m-0">Pelanggan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/pelanggan') }}">Pelanggan</a></li>
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
                        <i class="icon fas fa-ban"></i> Error!
                    </h5>
                    @foreach (session('error') as $error)
                        - {{ $error }} <br>
                    @endforeach
                </div>
            @endif
            {{-- <div class="card"> --}}
            {{-- <div class="card-header">
                    <h3 class="card-title">Tambah Pelanggan</h3>
                </div> --}}
            <!-- /.card-header -->
            <form action="{{ url('admin/pelanggan') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Pelanggan</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="nama_pell">Nama Pelanggan</label>
                                        <input type="text" class="form-control" id="nama_pell" name="nama_pell"
                                            placeholder="Masukan nama pelanggan" value="{{ old('nama_pell') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="nama_alias">Nama Alias</label>
                                        <input type="text" class="form-control" id="nama_alias" name="nama_alias"
                                            placeholder="Masukan nama alias" value="{{ old('nama_alias') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="npwp">No. NPWP</label>
                                        <input type="number" class="form-control" id="npwp" name="npwp"
                                            placeholder="Masukan no npwp" value="{{ old('npwp') }}">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <textarea type="text" class="form-control" id="alamat" name="alamat" placeholder="Masukan alamat">{{ old('alamat') }}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div hidden class="form-group">
                                    <label for="karyawan_id">Marketing Id</label>
                                    <input type="text" class="form-control" id="karyawan_id" readonly name="karyawan_id"
                                        placeholder="" value="{{ old('karyawan_id') }}">
                                </div>
                                <div class="form-group">
                                    <label style="font-size:14px" class="form-label" for="kode_karyawan">Kode
                                        Marketing</label>
                                    <div class="form-group d-flex">
                                        <input onclick="showCategoryModalMarketing(this.value)" class="form-control"
                                            id="kode_karyawan" name="kode_karyawan" type="text" placeholder=""
                                            value="{{ old('kode_karyawan') }}" readonly
                                            style="margin-right: 10px; font-size:14px" />
                                        <button class="btn btn-primary" type="button"
                                            onclick="showCategoryModalMarketing(this.value)">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label style="font-size:14px" for="nama_lengkap">Kode Marketing</label>
                                    <input onclick="showCategoryModalMarketing(this.value)" style="font-size:14px"
                                        type="text" class="form-control" id="nama_lengkap" readonly
                                        name="nama_lengkap" placeholder="" value="{{ old('nama_lengkap') }}">
                                </div>
                                <div class="form-group">
                                    <label style="font-size:14px" for="telp">No. Telp</label>
                                    <input onclick="showCategoryModalMarketing(this.value)" style="font-size:14px"
                                        type="text" class="form-control" id="telp" readonly name="telp"
                                        placeholder="" value="{{ old('telp') }}">
                                </div>
                                <div class="form-group">
                                    <label style="font-size:14px" for="alamat_karyawan">Alamat</label>
                                    <input onclick="showCategoryModalMarketing(this.value)" style="font-size:14px"
                                        type="text" class="form-control" id="alamat_karyawan" readonly
                                        name="alamat_karyawan" placeholder="" value="{{ old('alamat_karyawan') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Kotak Person</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" id="nama_person" name="nama_person"
                                placeholder="Masukan nama" value="{{ old('nama_person') }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">Jabatan</label>
                            <input type="text" class="form-control" id="jabatan" name="jabatan"
                                placeholder="Masukan jabatan" value="{{ old('jabatan') }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">No. Telepon</label>
                            <input type="number" class="form-control" id="telp" name="telp"
                                placeholder="Masukan no telepon" value="{{ old('telp') }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">Fax</label>
                            <input type="number" class="form-control" id="fax" name="fax"
                                placeholder="Masukan no fax" value="{{ old('fax') }}">
                        </div>
                        <div class="form-group">
                            <label for="telp">Hp</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">+62</span>
                                </div>
                                <input type="number" id="hp" name="hp" class="form-control"
                                    placeholder="Masukan nomor hp" value="{{ old('hp') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nama">Email</label>
                            <input type="text" class="form-control" id="email" name="email"
                                placeholder="Masukan email" value="{{ old('email') }}">
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
            {{-- </div> --}}
        </div>

        <div class="modal fade" id="tableKaryawan" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Marketing</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive scrollbar m-2">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead class="bg-200 text-900">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Kode Marketing</th>
                                        <th>Nama Lengkap</th>
                                        <th>Telp</th>
                                        <th>Alamat</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($karyawans as $karyawan)
                                        <tr
                                            onclick="getSelectedDataMarketing('{{ $karyawan->id }}', '{{ $karyawan->kode_karyawan }}', '{{ $karyawan->nama_lengkap }}', '{{ $karyawan->telp }}', '{{ $karyawan->alamat }}')">
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $karyawan->kode_karyawan }}</td>
                                            <td>{{ $karyawan->nama_lengkap }}</td>
                                            <td>{{ $karyawan->telp }}</td>
                                            <td>{{ $karyawan->alamat }}</td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="getSelectedDataMarketing('{{ $karyawan->id }}', '{{ $karyawan->kode_karyawan }}', '{{ $karyawan->nama_lengkap }}', '{{ $karyawan->telp }}', '{{ $karyawan->alamat }}')">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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
        function showCategoryModalMarketing(selectedCategory) {
            $('#tableKaryawan').modal('show');
        }

        function getSelectedDataMarketing(Karyawan_id, KodeKaryawan, NamaKaryawan, Telp, Alamat) {

            // Assign the values to the corresponding input fields
            document.getElementById('karyawan_id').value = Karyawan_id;
            document.getElementById('kode_karyawan').value = KodeKaryawan;
            document.getElementById('nama_lengkap').value = NamaKaryawan;
            document.getElementById('telp').value = Telp;
            document.getElementById('alamat_karyawan').value = Alamat;

            $('#tableKaryawan').modal('hide');
        }
    </script>
@endsection
