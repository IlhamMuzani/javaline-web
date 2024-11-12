@extends('layouts.app')

@section('title', 'Tambah Driver')

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
                    <h1 class="m-0">Driver</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/driver') }}">Driver</a></li>
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
            <form action="{{ url('admin/driver') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                @csrf
                <div class="card">
                    <div class="card-body">
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
                            <label for="alamat">Alamat</label>
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
                        <h3 class="card-title">Dokumen Survei</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="ft_kk">Foto KK </label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="ft_kk" name="ft_kk"
                                        accept="image/*">
                                    <label class="custom-file-label" for="ft_kk">Masukkan foto ktp</label>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="ft_ktp">Foto KTP</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="ft_ktp" name="ft_ktp"
                                        accept="image/*">
                                    <label class="custom-file-label" for="ft_ktp">Masukkan foto ktp</label>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="ft_sim">Foto SIM</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="ft_sim" name="ft_sim"
                                        accept="image/*">
                                    <label class="custom-file-label" for="ft_sim">Masukkan foto sim</label>
                                </div>
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="ft_kk_penjamin">Foto KK Penjamin</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="ft_kk_penjamin"
                                        name="ft_kk_penjamin" accept="image/*">
                                    <label class="custom-file-label" for="ft_kk_penjamin">Masukkan kk penjamin</label>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="ft_skck">Foto SKCK </label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="ft_skck" name="ft_skck"
                                        accept="image/*">
                                    <label class="custom-file-label" for="ft_skck">Masukkan foto skck</label>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="ft_surat_pernyataan">Foto Surat Pernyataan </label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="ft_surat_pernyataan"
                                        name="ft_surat_pernyataan" accept="image/*">
                                    <label class="custom-file-label" for="ft_surat_pernyataan">Masukkan foto surat
                                        pernyataan</label>
                                </div>
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="ft_terbaru">Foto Terbaru</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="ft_terbaru" name="ft_terbaru"
                                        accept="image/*">
                                    <label class="custom-file-label" for="ft_terbaru">Masukkan foto terbaru</label>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="ft_rumah">Foto Rumah</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="ft_rumah" name="ft_rumah"
                                        accept="image/*">
                                    <label class="custom-file-label" for="ft_rumah">Masukkan foto rumah</label>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="ft_penjamin">Foto Keluarga / Foto Penjamin</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="ft_penjamin" name="ft_penjamin"
                                        accept="image/*">
                                    <label class="custom-file-label" for="ft_penjamin">Masukkan foto penjamin</label>
                                </div>
                            </div>
                        </div>
                        <br>
                        <br>

                        {{-- <div class="form-group">
                            <label for="titik_koordinat">Masukkan titik koordinat</label>
                            <input type="text" class="form-control" id="titik_koordinat" name="titik_koordinat"
                                placeholder="Masukan titik koordinat" value="{{ old('titik_koordinat') }}">
                        </div> --}}
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="latitude">latitude</label>
                                <div>
                                    <input type="text" class="form-control" placeholder="Masukan latitude"
                                        id="latitude" name="latitude">
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="ft_rumah">Longitude</label>
                                <div>
                                    <input type="text" class="form-control" placeholder="Masukan longitude"
                                        id="longitude" name="longitude">
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
