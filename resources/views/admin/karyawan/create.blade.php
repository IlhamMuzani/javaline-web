@extends('layouts.app')

@section('title', 'Tambah Karyawan')

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
                    <h1 class="m-0">Karyawan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/karyawan') }}">Karyawan</a></li>
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
            <!-- /.card-header -->
            <form action="{{ url('admin/karyawan') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="departemen_id">Departemen</label>
                            <select class="custom-select form-control" id="departemen_id" name="departemen_id">
                                <option value="">- Pilih Departemen -</option>
                                @foreach ($departemens as $departemen)
                                    <option value="{{ $departemen->id }}"
                                        {{ old('departemen_id') == $departemen->id ? 'selected' : '' }}>
                                        {{ $departemen->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- <div class="form-group">
                            <label for="kode_karyawan">Kode Karyawan</label>
                            <input type="text" class="form-control" id="kode_karyawan" name="kode_karyawan"
                                placeholder="Masukan kode" value="{{ old('kode_karyawan') }}">
                        </div> --}}
                        <div class="form-group">
                            <label for="nama">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap"
                                placeholder="Masukan nama lengkap" value="{{ old('nama_lengkap') }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama Kecil</label>
                            <input type="text" class="form-control" id="nama_kecil" name="nama_kecil"
                                placeholder="Masukan nama kecil" value="{{ old('nama_kecil') }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">No KTP</label>
                            <input type="text" class="form-control" id="no_ktp" name="no_ktp"
                                placeholder="Masukan no KTP" value="{{ old('no_ktp') }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">No SIM</label>
                            <input type="text" class="form-control" id="no_sim" name="no_sim"
                                placeholder="Masukan no SIM" value="{{ old('no_sim') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="gender">Pilih Gender</label>
                            <select class="form-control" id="gender" name="gender">
                                <option value="">- Pilih -</option>
                                <option value="L" {{ old('gender') == 'L' ? 'selected' : null }}>
                                    Laki-laki</option>
                                <option value="P" {{ old('gender') == 'P' ? 'selected' : null }}>
                                    Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Lahir:</label>
                            <div class="input-group date" id="reservationdatetime">
                                <input type="date" id="tanggal_lahir" name="tanggal_lahir"
                                    placeholder="d M Y sampai d M Y"
                                    data-options='{"mode":"range","dateFormat":"d M Y","disableMobile":true}'
                                    value="{{ old('tanggal_lahir') }}" class="form-control datetimepicker-input"
                                    data-target="#reservationdatetime">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Gabung:</label>
                            <div class="input-group date" id="reservationdatetime">
                                <input type="date" id="tanggal_gabung" name="tanggal_gabung"
                                    placeholder="d M Y sampai d M Y"
                                    data-options='{"mode":"range","dateFormat":"d M Y","disableMobile":true}'
                                    value="{{ old('tanggal_gabung') }}" class="form-control datetimepicker-input"
                                    data-target="#reservationdatetime">
                            </div>
                        </div>
                        {{-- <div class="mb-3">
                            <label class="form-label" for="jabatan">Jabatan</label>
                            <select class="form-control" id="jabatan" name="jabatan">
                                <option value="">- Pilih Jabatan -</option>
                                <option value="STAFF" {{ old('jabatan') == 'STAFF' ? 'selected' : null }}>
                                    STAFF</option>
                            </select>
                        </div> --}}
                        <div class="form-group">
                            <label for="nama">No Telp</label>
                            <input type="text" class="form-control" id="telp" name="telp"
                                placeholder="Masukan no telp" value="{{ old('telp') }}">
                        </div>
                        <div class="form-group">
                            <label for="gmail">Email</label>
                            <input type="text" class="form-control" id="gmail" name="gmail"
                                placeholder="Masukan email" value="{{ old('gmail') }}">
                        </div>
                        <div class="form-group">
                            <label for="alamat3">Provinsi</label>
                            <textarea type="text" class="form-control" id="alamat3" name="alamat3" placeholder="Masukan provinsi">{{ old('alamat3') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="alamat2">Kota / Kabupaten</label>
                            <textarea type="text" class="form-control" id="alamat2" name="alamat2" placeholder="Masukan kota / kabupaten">{{ old('alamat2') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="alamat">Kecamatan dan desa</label>
                            <textarea type="text" class="form-control" id="alamat" name="alamat" placeholder="Masukan alamat">{{ old('alamat') }}</textarea>
                        </div>

                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Informasi Bank</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="nama_bank">Nama Bank</label>
                            <select class="form-control" id="nama_bank" name="nama_bank">
                                <option value="">- Pilih -</option>
                                <option value="BRI" {{ old('nama_bank') == 'BRI' ? 'selected' : null }}>
                                    BRI</option>
                                <option value="MANDIRI" {{ old('nama_bank') == 'MANDIRI' ? 'selected' : null }}>
                                    MANDIRI</option>
                                <option value="BNI" {{ old('nama_bank') == 'BNI' ? 'selected' : null }}>
                                    BNI</option>
                                <option value="BTN" {{ old('nama_bank') == 'BTN' ? 'selected' : null }}>
                                    BTN</option>
                                <option value="DANAMON" {{ old('nama_bank') == 'DANAMON' ? 'selected' : null }}>
                                    DANAMON</option>
                                <option value="BCA" {{ old('nama_bank') == 'BCA' ? 'selected' : null }}>
                                    BCA</option>
                                <option value="PERMATA" {{ old('nama_bank') == 'PERMATA' ? 'selected' : null }}>
                                    PERMATA</option>
                                <option value="PAN" {{ old('nama_bank') == 'PAN' ? 'selected' : null }}>
                                    PAN</option>
                                <option value="CIMB NIAGA" {{ old('nama_bank') == 'CIMB NIAGA' ? 'selected' : null }}>
                                    CIMB NIAGA</option>
                                <option value="UOB" {{ old('nama_bank') == 'UOB' ? 'selected' : null }}>
                                    UOB</option>
                                <option value="ARTHA GRAHA" {{ old('nama_bank') == 'ARTHA GRAHA' ? 'selected' : null }}>
                                    ARTHA GRAHA</option>
                                <option value="BUMI ARTHA" {{ old('nama_bank') == 'BUMI ARTHA' ? 'selected' : null }}>
                                    BUMI ARTHA</option>
                                <option value="MEGA" {{ old('nama_bank') == 'MEGA' ? 'selected' : null }}>
                                    MEGA</option>
                                <option value="SYARIAH" {{ old('nama_bank') == 'SYARIAH' ? 'selected' : null }}>
                                    SYARIAH</option>
                                <option value="MEGA SYARIAH" {{ old('nama_bank') == 'MEGA SYARIAH' ? 'selected' : null }}>
                                    MEGA SYARIAH</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="atas_nama">Atas nama</label>
                            <input type="text" class="form-control" id="atas_nama" name="atas_nama"
                                placeholder="Masukan atas nama" value="{{ old('atas_nama') }}">
                        </div>
                        <div class="form-group">
                            <label for="norek">No. Rekening</label>
                            <input type="text" class="form-control" id="norek" name="norek"
                                placeholder="Masukan no rekening" value="{{ old('norek') }}">
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Informasi KTP dan SIM</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="ft_ktp">Foto KTP <small>(Kosongkan saja jika tidak
                                        ingin menambahkan)</small></label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="ft_ktp" name="ft_ktp"
                                        accept="image/*">
                                    <label class="custom-file-label" for="ft_ktp">Masukkan foto ktp</label>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="ft_sim">Foto SIM <small>(Kosongkan saja jika tidak
                                        ingin menambahkan)</small></label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="ft_sim" name="ft_sim"
                                        accept="image/*">
                                    <label class="custom-file-label" for="ft_sim">Masukkan foto sim</label>
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
                </div>
            </form>
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
